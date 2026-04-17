<?php

namespace HGON\HgonSpecies\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CsvImportService
{
    private const SPECIES_TABLE = 'tx_hgonspecies_domain_model_species';
    private const ATTRIBUTES_TABLE = 'tx_hgonspecies_domain_model_attributes';
    private const CATEGORY_TABLE = 'sys_category';
    private const ALLOWED_SPECIES_TYPES = ['default', 'bird', 'dragonfly'];
    private const REQUIRED_FIELDS = ['name', 'name_science', 'import_id', 'family'];
    private const ATTRIBUTES_FIELDS = [
        'length',
        'wingspan',
        'weight',
        'age_limit',
        'food',
        'nest_size',
        'breeding_season',
        'migratory_behavior',
        'winter_district',
    ];
    private const SPECIES_FIELDS = [
        'name',
        'name_science',
        'name_discoverer',
        'subtitle',
        'year',
        'remark',
        'characteristic',
        'habitat',
        'dissemination',
        'grid_frequency',
        'last_updated_date',
        'red_list_comment',
        'red_list_hessia',
        'red_list_germany',
        'phenology',
        'mtb64',
        'proof',
        'family',
        'state_of_preservation_hessia',
        'eu_vsrl',
        'population_in_hessia',
        'population_development',
        'custom_link',
        'import_id',
        'first_spotted',
        'last_spotted',
    ];
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
        $seenImportIds = [];

        try {
            foreach ($connections as $connection) {
                $connection->beginTransaction();
            }

            foreach ($rows as $lineNumber => $record) {
                $record = $this->normalizeRecord($record);
                $validationErrors = $this->validateRecord($record, $speciesType, $targetPid, $seenImportIds);

                if ($validationErrors !== []) {
                    $skipped[] = sprintf('Zeile %d: %s', $lineNumber, implode('; ', $validationErrors));
                    continue;
                }

                $importId = $record['import_id'];
                $seenImportIds[$importId] = true;

                $existingRecords = $this->findSpeciesByImportId($speciesConnection, $importId, $targetPid, $speciesType);
                if (count($existingRecords) > 1) {
                    $skipped[] = sprintf(
                        'Zeile %d: Mehrdeutige import_id "%s" auf PID %d fuer Typ "%s".',
                        $lineNumber,
                        $importId,
                        $targetPid,
                        $speciesType
                    );
                    continue;
                }

                $attributesData = $this->buildAttributesData($record, $targetPid);
                $speciesData = $this->buildSpeciesData($record, $targetPid, $speciesType);

                if ($existingRecords !== []) {
                    $existingRecord = $existingRecords[0];
                    $attributesUid = $this->persistAttributesForExistingRecord($attributesConnection, $attributesData, $targetPid, $existingRecord);
                    $speciesData['attributes'] = $attributesUid;

                    $speciesConnection->update(
                        self::SPECIES_TABLE,
                        $speciesData,
                        ['uid' => (int)$existingRecord['uid']]
                    );
                    $updated++;
                    continue;
                }

                $attributesUid = $this->insertAttributes($attributesConnection, $attributesData);
                $speciesData['attributes'] = $attributesUid;
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

        return $this->formatResultMessage($imported, $updated, $skipped);
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
            $header = fgetcsv($handle, 0, $separator, '"');
            if (!is_array($header)) {
                throw new \RuntimeException('Die CSV-Datei enthaelt keine Kopfzeile.');
            }
            $header = $this->normalizeHeader($header);

            $rows = [];
            $lineNumber = 1;
            while (($data = fgetcsv($handle, 0, $separator, '"')) !== false) {
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
        return array_map(
            fn($value): string => strtolower(trim((string)$value)),
            $header
        );
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
     * @param array<string, bool> $seenImportIds
     * @return array<int, string>
     */
    private function validateRecord(array $record, string $speciesType, int $targetPid, array $seenImportIds): array
    {
        $errors = [];

        foreach (self::REQUIRED_FIELDS as $fieldName) {
            if (($record[$fieldName] ?? '') === '') {
                $errors[] = sprintf('Pflichtfeld "%s" ist leer', $fieldName);
            }
        }

        $importId = $record['import_id'] ?? '';
        if ($importId !== '' && isset($seenImportIds[$importId])) {
            $errors[] = sprintf('import_id "%s" kommt in der Datei mehrfach vor', $importId);
        }

        $familyUid = (int)($record['family'] ?? 0);
        if ($familyUid <= 0) {
            $errors[] = 'family muss eine gueltige TYPO3-Kategorie-ID sein';
        } elseif (!$this->categoryExists($familyUid)) {
            $errors[] = sprintf('family-ID %d existiert nicht', $familyUid);
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

        $crossScopeMatches = $this->countSpeciesByImportId($importId);
        $scopedMatches = $this->countSpeciesByImportId($importId, $targetPid, $speciesType);
        if ($crossScopeMatches > 0 && $scopedMatches === 0) {
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

        return $errors;
    }

    /**
     * @param array<string, string> $record
     * @return array<string, mixed>
     */
    private function buildAttributesData(array $record, int $targetPid): array
    {
        $attributesData = ['pid' => $targetPid];
        foreach (self::ATTRIBUTES_FIELDS as $fieldName) {
            $attributesData[$fieldName] = $this->normalizeFieldValue($fieldName, $record[$fieldName] ?? '');
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
        ];

        foreach (self::SPECIES_FIELDS as $fieldName) {
            $speciesData[$fieldName] = $this->normalizeFieldValue($fieldName, $record[$fieldName] ?? '');
        }

        $speciesData['family'] = (int)$speciesData['family'];
        $speciesData['grid_frequency'] = $speciesData['grid_frequency'] === '' ? 0.0 : (float)str_replace(',', '.', (string)$speciesData['grid_frequency']);
        $speciesData['mtb64'] = $speciesData['mtb64'] === '' ? 0 : (int)$speciesData['mtb64'];
        $speciesData['proof'] = $speciesData['proof'] === '' ? 0 : (int)$speciesData['proof'];
        $speciesData['last_updated_date'] = $speciesData['last_updated_date'] === '' ? null : $speciesData['last_updated_date'];

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
            ->select('uid', 'attributes')
            ->from(self::SPECIES_TABLE)
            ->where(
                $queryBuilder->expr()->eq('import_id', $queryBuilder->createNamedParameter($importId)),
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($targetPid, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('record_type', $queryBuilder->createNamedParameter($speciesType))
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function countSpeciesByImportId(string $importId, ?int $targetPid = null, ?string $speciesType = null): int
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::SPECIES_TABLE);

        $constraints = [
            $queryBuilder->expr()->eq('import_id', $queryBuilder->createNamedParameter($importId)),
        ];
        if ($targetPid !== null) {
            $constraints[] = $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($targetPid, \PDO::PARAM_INT));
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
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($categoryUid, \PDO::PARAM_INT))
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
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($attributesUid, \PDO::PARAM_INT))
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
