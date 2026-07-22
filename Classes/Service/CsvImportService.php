<?php

namespace HGON\HgonSpecies\Service;

use Doctrine\DBAL\ParameterType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use RuntimeException;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CsvImportService
{
    private const SPECIES_TABLE = 'tx_hgonspecies_domain_model_species';
    private const ATTRIBUTES_TABLE = 'tx_hgonspecies_domain_model_attributes';
    private const CATEGORY_TABLE = 'sys_category';
    private const ALLOWED_SPECIES_TYPES = ['default', 'bird', 'dragonfly'];
    private const CREATE_REQUIRED_FIELDS = ['name', 'name_science', 'family'];
    private const NON_CLEARABLE_FIELDS = ['import_id', 'name', 'name_science', 'family'];
    private const HTML_FIELDS = [
        'remark',
        'characteristic',
        'habitat',
        'dissemination',
        'red_list_comment',
        'phenology',
        'population_in_hessia',
        'population_development',
        'food',
        'migratory_behavior',
    ];

    public function importFromCsv(array $csvFile, string $speciesType, int $targetPid): string
    {
        $speciesType = trim($speciesType);
        if ($targetPid <= 0) {
            return 'Import abgebrochen: Die Ziel-Seiten-ID muss groesser als 0 sein.';
        }
        if (!in_array($speciesType, self::ALLOWED_SPECIES_TYPES, true)) {
            return sprintf('Import abgebrochen: Unbekannter Datensatz-Typ "%s".', $speciesType);
        }

        try {
            $rows = $this->readRows($csvFile);
        } catch (\Throwable $exception) {
            return 'Import abgebrochen: ' . $exception->getMessage();
        }

        if ($rows === []) {
            return 'Import abgebrochen: Die Datei enthaelt keine importierbaren Datensaetze.';
        }

        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $speciesConnection = $connectionPool->getConnectionForTable(self::SPECIES_TABLE);
        $attributesConnection = $connectionPool->getConnectionForTable(self::ATTRIBUTES_TABLE);
        $connections = $this->uniqueConnections($speciesConnection, $attributesConnection);

        $imported = 0;
        $updated = 0;
        $skipped = [];
        $preparedRecords = [];
        $importIdCounts = [];

        foreach ($rows as $record) {
            $importId = $this->normalizeScalar($record['import_id'] ?? '');
            if ($importId !== '') {
                $importIdCounts[$importId] = ($importIdCounts[$importId] ?? 0) + 1;
            }
        }

        foreach ($rows as $lineNumber => $record) {
            $record = $this->normalizeRecord($record);
            $importId = $record['import_id'] ?? '';
            $existingRecords = $importId === ''
                ? []
                : $this->findSpeciesByImportId($speciesConnection, $importId, $targetPid, $speciesType);

            $validationErrors = $this->validateRecord(
                $record,
                $speciesType,
                $targetPid,
                ($importIdCounts[$importId] ?? 0) > 1,
                $existingRecords !== []
            );

            if (count($existingRecords) > 1) {
                $validationErrors[] = sprintf(
                    'Mehrdeutige import_id "%s" auf PID %d fuer Typ "%s"',
                    $importId,
                    $targetPid,
                    $speciesType
                );
            } elseif (
                $existingRecords === []
                && $importId !== ''
                && $this->deletedSpeciesExists($speciesConnection, $importId, $targetPid, $speciesType)
            ) {
                $validationErrors[] = sprintf(
                    'import_id "%s" gehoert zu einem geloeschten Datensatz; bitte diesen zuerst wiederherstellen oder endgueltig entfernen',
                    $importId
                );
            }

            if ($validationErrors !== []) {
                $skipped[] = sprintf('Zeile %d: %s', $lineNumber, implode('; ', array_unique($validationErrors)));
                continue;
            }

            $preparedRecords[] = [
                'record' => $record,
                'existingRecord' => $existingRecords[0] ?? null,
            ];
        }

        try {
            foreach ($connections as $connection) {
                $connection->beginTransaction();
            }

            foreach ($preparedRecords as $preparedRecord) {
                $record = $preparedRecord['record'];
                $existingRecord = $preparedRecord['existingRecord'];
                $attributesData = $this->buildAttributesData($record, $targetPid);
                $speciesData = $this->buildSpeciesData($record, $targetPid, $speciesType);

                if (is_array($existingRecord)) {
                    if ($attributesData !== []) {
                        $speciesData['attributes'] = $this->persistAttributesForExistingRecord(
                            $attributesConnection,
                            $attributesData,
                            $targetPid,
                            $existingRecord
                        );
                    }
                    if ((string)($existingRecord['slug'] ?? '') === '') {
                        $speciesData['slug'] = $this->generateSlug(
                            (string)($record['name'] ?? $existingRecord['name'] ?? ''),
                            $targetPid,
                            (int)$existingRecord['uid']
                        );
                    }

                    $speciesConnection->update(
                        self::SPECIES_TABLE,
                        $speciesData,
                        ['uid' => (int)$existingRecord['uid']]
                    );
                    $updated++;
                    continue;
                }

                if ($attributesData !== []) {
                    $speciesData['attributes'] = $this->insertAttributes($attributesConnection, $attributesData);
                }
                $speciesData['slug'] = $this->generateSlug((string)$record['name'], $targetPid);
                $speciesData['crdate'] = time();
                $speciesConnection->insert(self::SPECIES_TABLE, $speciesData);
                $imported++;
            }

            foreach ($connections as $connection) {
                $connection->commit();
            }
        } catch (\Throwable $exception) {
            foreach (array_reverse($connections) as $connection) {
                if ($connection->isTransactionActive()) {
                    $connection->rollBack();
                }
            }
            return 'Import abgebrochen: ' . $exception->getMessage();
        }

        $resultMessage = $this->formatResultMessage($imported, $updated, $skipped);
        if ($imported > 0 || $updated > 0) {
            try {
                GeneralUtility::makeInstance(CacheManager::class)->flushCachesInGroup('pages');
            } catch (\Throwable $exception) {
                $resultMessage .= "\n\nHinweis: Der Seiten-Cache konnte nicht automatisch geleert werden: "
                    . $exception->getMessage();
            }
        }

        return $resultMessage;
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function readRows(array $csvFile): array
    {
        $extension = strtolower((string)pathinfo((string)($csvFile['name'] ?? ''), PATHINFO_EXTENSION));
        $tmpFile = (string)($csvFile['tmp_name'] ?? '');
        if ($tmpFile === '' || !is_file($tmpFile)) {
            throw new \RuntimeException('Die hochgeladene Datei ist nicht verfuegbar.');
        }

        return match ($extension) {
            'csv' => $this->readCsvRows($tmpFile),
            'xls', 'xlsx' => $this->readSpreadsheetRows($tmpFile),
            default => throw new \RuntimeException('Dateiformat nicht unterstuetzt. Erlaubt sind CSV, XLS und XLSX.'),
        };
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function readCsvRows(string $fileName): array
    {
        $separator = ';';
        $handle = fopen($fileName, 'r');
        if ($handle === false) {
            throw new \RuntimeException('Datei konnte nicht geoeffnet werden.');
        }

        try {
            $header = fgetcsv($handle, 0, $separator, '"', '');
            if (!is_array($header)) {
                throw new \RuntimeException('Die CSV-Datei enthaelt keine Kopfzeile.');
            }
            $header = $this->normalizeHeader($header);
            $this->validateHeader($header);

            $rows = [];
            $lineNumber = 1;
            while (($data = fgetcsv($handle, 0, $separator, '"', '')) !== false) {
                $lineNumber++;
                if ($this->rowIsEmpty($data)) {
                    continue;
                }
                if (count($data) !== count($header)) {
                    throw new \RuntimeException(sprintf(
                        'CSV-Strukturfehler in Zeile %d: Erwartet %d Spalten, erhalten %d.',
                        $lineNumber,
                        count($header),
                        count($data)
                    ));
                }
                $rows[$lineNumber] = array_combine($header, array_map([$this, 'normalizeScalar'], $data));
            }
        } finally {
            fclose($handle);
        }

        return $rows;
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function readSpreadsheetRows(string $fileName): array
    {
        $spreadsheet = IOFactory::load($fileName);
        $sheetRows = $spreadsheet->getActiveSheet()->toArray('', false, false, false);
        if ($sheetRows === []) {
            return [];
        }

        $header = $this->normalizeHeader(array_shift($sheetRows));
        if ($header === []) {
            throw new \RuntimeException('Die Tabellen-Datei enthaelt keine Kopfzeile.');
        }
        $this->validateHeader($header);

        $rows = [];
        foreach ($sheetRows as $index => $data) {
            $lineNumber = $index + 2;
            if ($this->rowIsEmpty($data)) {
                continue;
            }
            $data = array_map([$this, 'normalizeScalar'], $data);
            if (count($data) < count($header)) {
                $data = array_pad($data, count($header), '');
            }
            if (count($data) > count($header)) {
                throw new \RuntimeException(sprintf(
                    'Tabellen-Strukturfehler in Zeile %d: Erwartet maximal %d Spalten, erhalten %d.',
                    $lineNumber,
                    count($header),
                    count($data)
                ));
            }
            $rows[$lineNumber] = array_combine($header, $data);
        }

        return $rows;
    }

    /**
     * @param array<int, mixed> $header
     * @return array<int, string>
     */
    private function normalizeHeader(array $header): array
    {
        $normalizedHeader = array_map(
            fn($value): string => strtolower(trim((string)$value)),
            $header
        );
        if (isset($normalizedHeader[0])) {
            $normalizedHeader[0] = ltrim($normalizedHeader[0], "\xEF\xBB\xBF");
        }
        return $normalizedHeader;
    }

    /**
     * @param array<int, string> $header
     */
    private function validateHeader(array $header): void
    {
        if (in_array('', $header, true)) {
            throw new RuntimeException('Die Kopfzeile enthaelt eine Spalte ohne Namen.');
        }

        $duplicates = array_keys(array_filter(
            array_count_values($header),
            static fn(int $count): bool => $count > 1
        ));
        if ($duplicates !== []) {
            throw new RuntimeException(sprintf(
                'Die Kopfzeile enthaelt doppelte Spalten: %s.',
                implode(', ', $duplicates)
            ));
        }

        if (!in_array('import_id', $header, true)) {
            throw new RuntimeException('Die Pflichtspalte "import_id" fehlt in der Kopfzeile.');
        }

        $allowedFields = SpeciesCsvSchema::allowedImportFields();
        $unknownFields = array_values(array_diff($header, $allowedFields));
        if ($unknownFields !== []) {
            throw new RuntimeException(sprintf(
                'Nicht unterstuetzte Spalten in der Kopfzeile: %s.',
                implode(', ', $unknownFields)
            ));
        }
    }

    /**
     * @param array<int, mixed> $row
     */
    private function rowIsEmpty(array $row): bool
    {
        foreach ($row as $value) {
            if (trim((string)$value) !== '') {
                return false;
            }
        }
        return true;
    }

    /**
     * @param array<string, string> $record
     * @return array<int, string>
     */
    private function validateRecord(
        array $record,
        string $speciesType,
        int $targetPid,
        bool $duplicateImportId,
        bool $existingRecord
    ): array
    {
        $errors = [];
        $importId = $record['import_id'] ?? '';

        if ($importId === '') {
            $errors[] = 'Pflichtfeld "import_id" ist leer';
        }
        if ($duplicateImportId) {
            $errors[] = sprintf('import_id "%s" kommt in der Datei mehrfach vor', $importId);
        }

        if (!$existingRecord) {
            foreach (self::CREATE_REQUIRED_FIELDS as $fieldName) {
                if (($record[$fieldName] ?? '') === '') {
                    $errors[] = sprintf('Pflichtfeld "%s" ist fuer neue Datensaetze leer oder fehlt', $fieldName);
                }
            }
        }

        foreach (self::NON_CLEARABLE_FIELDS as $fieldName) {
            if (array_key_exists($fieldName, $record) && $record[$fieldName] === '') {
                $errors[] = sprintf('Pflichtfeld "%s" darf nicht geleert werden', $fieldName);
            }
        }

        if (array_key_exists('family', $record) && $record['family'] !== '') {
            $familyUid = (int)$record['family'];
            if ($familyUid <= 0) {
                $errors[] = 'family muss eine gueltige TYPO3-Kategorie-ID sein';
            } elseif (!$this->categoryExists($familyUid)) {
                $errors[] = sprintf('family-ID %d existiert nicht', $familyUid);
            }
        }

        if (($record['last_updated_date'] ?? '') !== '' && !$this->isValidDate($record['last_updated_date'])) {
            $errors[] = 'last_updated_date hat kein gueltiges Format YYYY-MM-DD';
        }

        $gridFrequency = $record['grid_frequency'] ?? '';
        if ($gridFrequency !== '' && !is_numeric(str_replace(',', '.', $gridFrequency))) {
            $errors[] = 'grid_frequency ist keine gueltige Zahl';
        }

        foreach (['mtb64', 'proof'] as $integerField) {
            $value = $record[$integerField] ?? '';
            if ($value !== '' && filter_var($value, FILTER_VALIDATE_INT) === false) {
                $errors[] = sprintf('%s ist keine gueltige Ganzzahl', $integerField);
            }
        }

        if ($importId !== '') {
            $crossScopeMatches = $this->countSpeciesByImportId($importId);
            $scopedMatches = $this->countSpeciesByImportId($importId, $targetPid, $speciesType);
            if ($crossScopeMatches > $scopedMatches) {
                $errors[] = sprintf(
                    'import_id "%s" existiert bereits ausserhalb der gewaehlten PID bzw. des gewaehlten Typs',
                    $importId
                );
            }
            if ($scopedMatches > 1) {
                $errors[] = sprintf(
                    'import_id "%s" ist innerhalb der gewaehlten PID bzw. des gewaehlten Typs nicht eindeutig',
                    $importId
                );
            }
        }

        return $errors;
    }

    /**
     * @param array<string, string> $record
     * @return array<string, mixed>
     */
    private function buildAttributesData(array $record, int $targetPid): array
    {
        $attributesData = [];
        foreach (SpeciesCsvSchema::ATTRIBUTE_FIELDS as $fieldName) {
            if (array_key_exists($fieldName, $record)) {
                $attributesData[$fieldName] = $this->normalizeFieldValue($fieldName, $record[$fieldName]);
            }
        }
        if ($attributesData !== []) {
            $attributesData['pid'] = $targetPid;
            $attributesData['tstamp'] = time();
        }
        return $attributesData;
    }

    /**
     * @param array<string, string> $record
     * @return array<string, mixed>
     */
    private function buildSpeciesData(array $record, int $targetPid, string $speciesType): array
    {
        $speciesData = [
            'pid' => $targetPid,
            'record_type' => $speciesType,
            'tstamp' => time(),
        ];

        foreach (SpeciesCsvSchema::SPECIES_FIELDS as $fieldName) {
            if (array_key_exists($fieldName, $record)) {
                $speciesData[$fieldName] = $this->normalizeFieldValue($fieldName, $record[$fieldName]);
            }
        }

        if (array_key_exists('family', $speciesData)) {
            $speciesData['family'] = (int)$speciesData['family'];
        }
        if (array_key_exists('grid_frequency', $speciesData)) {
            $speciesData['grid_frequency'] = $speciesData['grid_frequency'] === ''
                ? 0.0
                : (float)str_replace(',', '.', (string)$speciesData['grid_frequency']);
        }
        foreach (['mtb64', 'proof'] as $integerField) {
            if (array_key_exists($integerField, $speciesData)) {
                $speciesData[$integerField] = $speciesData[$integerField] === '' ? 0 : (int)$speciesData[$integerField];
            }
        }
        if (array_key_exists('last_updated_date', $speciesData)) {
            $speciesData['last_updated_date'] = $speciesData['last_updated_date'] === ''
                ? null
                : $speciesData['last_updated_date'];
        }

        return $speciesData;
    }

    /**
     * @param array<string, mixed> $existingRecord
     */
    private function persistAttributesForExistingRecord(Connection $attributesConnection, array $attributesData, int $targetPid, array $existingRecord): int
    {
        $attributesUid = (int)($existingRecord['attributes'] ?? 0);
        if ($attributesUid > 0 && $this->attributesExists($attributesUid)) {
            $attributesConnection->update(
                self::ATTRIBUTES_TABLE,
                $attributesData,
                ['uid' => $attributesUid]
            );
            return $attributesUid;
        }

        $attributesData['pid'] = $targetPid;
        return $this->insertAttributes($attributesConnection, $attributesData);
    }

    private function insertAttributes(Connection $attributesConnection, array $attributesData): int
    {
        $attributesData['crdate'] = time();
        $attributesConnection->insert(self::ATTRIBUTES_TABLE, $attributesData);
        return (int)$attributesConnection->lastInsertId(self::ATTRIBUTES_TABLE);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function findSpeciesByImportId(Connection $speciesConnection, string $importId, int $targetPid, string $speciesType): array
    {
        $queryBuilder = $speciesConnection->createQueryBuilder();
        return $queryBuilder
            ->select('uid', 'attributes', 'name', 'slug')
            ->from(self::SPECIES_TABLE)
            ->where(
                $queryBuilder->expr()->eq('import_id', $queryBuilder->createNamedParameter($importId)),
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($targetPid, ParameterType::INTEGER)),
                $queryBuilder->expr()->eq('record_type', $queryBuilder->createNamedParameter($speciesType)),
                $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0, ParameterType::INTEGER))
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function deletedSpeciesExists(
        Connection $speciesConnection,
        string $importId,
        int $targetPid,
        string $speciesType
    ): bool {
        $queryBuilder = $speciesConnection->createQueryBuilder();
        return (int)$queryBuilder
            ->count('uid')
            ->from(self::SPECIES_TABLE)
            ->where(
                $queryBuilder->expr()->eq('import_id', $queryBuilder->createNamedParameter($importId)),
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($targetPid, ParameterType::INTEGER)),
                $queryBuilder->expr()->eq('record_type', $queryBuilder->createNamedParameter($speciesType)),
                $queryBuilder->expr()->neq('deleted', $queryBuilder->createNamedParameter(0, ParameterType::INTEGER))
            )
            ->executeQuery()
            ->fetchOne() > 0;
    }

    private function generateSlug(string $name, int $targetPid, int $recordUid = 0): string
    {
        $fieldConfig = $GLOBALS['TCA'][self::SPECIES_TABLE]['columns']['slug']['config'] ?? null;
        if (!is_array($fieldConfig)) {
            throw new RuntimeException('Die TCA-Konfiguration fuer Arten-Slugs ist nicht verfuegbar.');
        }

        $record = [
            'uid' => $recordUid,
            'pid' => $targetPid,
            'name' => $name,
            'sys_language_uid' => 0,
        ];
        $slugHelper = GeneralUtility::makeInstance(
            SlugHelper::class,
            self::SPECIES_TABLE,
            'slug',
            $fieldConfig
        );
        $slug = $slugHelper->generate($record, $targetPid);
        $state = RecordStateFactory::forName(self::SPECIES_TABLE)
            ->fromArray($record, $targetPid, $recordUid);
        if (!$slugHelper->isUniqueInPid($slug, $state)) {
            $slug = $slugHelper->buildSlugForUniqueInPid($slug, $state);
        }
        if ($slug === '' || !$slugHelper->isUniqueInPid($slug, $state)) {
            throw new RuntimeException(sprintf('Fuer die Art "%s" konnte kein eindeutiger Slug erzeugt werden.', $name));
        }

        return $slug;
    }

    private function countSpeciesByImportId(string $importId, ?int $targetPid = null, ?string $speciesType = null): int
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::SPECIES_TABLE);

        $constraints = [
            $queryBuilder->expr()->eq('import_id', $queryBuilder->createNamedParameter($importId)),
        ];
        if ($targetPid !== null) {
            $constraints[] = $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($targetPid, ParameterType::INTEGER));
        }
        if ($speciesType !== null) {
            $constraints[] = $queryBuilder->expr()->eq('record_type', $queryBuilder->createNamedParameter($speciesType));
        }

        return (int)$queryBuilder
            ->count('uid')
            ->from(self::SPECIES_TABLE)
            ->where(...$constraints)
            ->executeQuery()
            ->fetchOne();
    }

    private function categoryExists(int $categoryUid): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::CATEGORY_TABLE);

        return (int)$queryBuilder
            ->count('uid')
            ->from(self::CATEGORY_TABLE)
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($categoryUid, ParameterType::INTEGER))
            )
            ->executeQuery()
            ->fetchOne() > 0;
    }

    private function attributesExists(int $attributesUid): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::ATTRIBUTES_TABLE);

        return (int)$queryBuilder
            ->count('uid')
            ->from(self::ATTRIBUTES_TABLE)
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($attributesUid, ParameterType::INTEGER))
            )
            ->executeQuery()
            ->fetchOne() > 0;
    }

    private function isValidDate(string $value): bool
    {
        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $value);
        return $date instanceof \DateTimeImmutable && $date->format('Y-m-d') === $value;
    }

    /**
     * @param array<string, mixed> $record
     * @return array<string, string>
     */
    private function normalizeRecord(array $record): array
    {
        $normalized = [];
        foreach ($record as $fieldName => $value) {
            $normalized[strtolower(trim((string)$fieldName))] = $this->normalizeScalar($value);
        }
        return $normalized;
    }

    private function normalizeScalar(mixed $value): string
    {
        return trim((string)$value);
    }

    private function normalizeFieldValue(string $fieldName, string $value): string
    {
        $value = trim($value);
        if (in_array($fieldName, self::HTML_FIELDS, true) && $value !== '') {
            return $this->stringCleanUp($value);
        }
        return $value;
    }

    /**
     * @param array<int, string> $skipped
     */
    private function formatResultMessage(int $imported, int $updated, array $skipped): string
    {
        $message = sprintf(
            'Import abgeschlossen: %d importiert, %d aktualisiert, %d uebersprungen.',
            $imported,
            $updated,
            count($skipped)
        );
        if ($skipped !== []) {
            $message .= "\n\nUebersprungene Zeilen:\n- " . implode("\n- ", array_slice($skipped, 0, 20));
            if (count($skipped) > 20) {
                $message .= sprintf("\n- ... und %d weitere", count($skipped) - 20);
            }
        }
        return $message;
    }

    /**
     * @return array<int, Connection>
     */
    private function uniqueConnections(Connection ...$connections): array
    {
        $uniqueConnections = [];
        foreach ($connections as $connection) {
            $uniqueConnections[spl_object_id($connection)] = $connection;
        }
        return array_values($uniqueConnections);
    }

    protected function parseHtml($string)
    {
        if (strip_tags($string) == $string) {
            $string = '<p>' . $string . '</p>';
        }

        return trim($string);
    }

    protected function stringCleanUp($string)
    {
        $tagCfg = array(
            'br' => array(),
            'a'  => array(),
            'p'  => array(),
            'ul' => array(
                'nesting' => 1,
            ),
            'ol' => array(
                'nesting' => 1,
            ),
            'li' => array(
                'nesting' => 1,
            ),
        );
        $additionalConfig = array(
            'stripEmptyTags' => 1,
        );

        /** @var \TYPO3\CMS\Core\Html\HtmlParser $parseObj */
        $parseObj = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Html\HtmlParser::class);
        $string = $parseObj->HTMLcleaner(trim($string), $tagCfg, 0, 0, $additionalConfig);
        $string = str_replace('\n', "", trim($string));
        $string = str_replace('<p><p>', '<p>', trim($string));
        $string = str_replace('</p></p>', '</p>', trim($string));
        $string = str_replace('&shy;', '', trim($string));

        return trim($string);
    }
}
