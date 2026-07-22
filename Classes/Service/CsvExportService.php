<?php

namespace HGON\HgonSpecies\Service;

use Doctrine\DBAL\ParameterType;
use RuntimeException;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class CsvExportService
{
    private const SPECIES_TABLE = 'tx_hgonspecies_domain_model_species';
    private const ATTRIBUTES_TABLE = 'tx_hgonspecies_domain_model_attributes';

    public function exportToCsv(string $speciesType, int $targetPid): string
    {
        $speciesType = trim($speciesType);
        if ($targetPid <= 0) {
            throw new RuntimeException('Die Ziel-Seiten-ID muss groesser als 0 sein.');
        }

        $fields = SpeciesCsvSchema::exportFieldsForType($speciesType);
        $rows = $this->findRows($fields, $speciesType, $targetPid);
        $this->assertImportableRows($rows);

        $stream = fopen('php://temp', 'w+b');
        if ($stream === false) {
            throw new RuntimeException('Die Exportdatei konnte nicht erzeugt werden.');
        }

        try {
            fwrite($stream, "\xEF\xBB\xBF");
            fputcsv($stream, $fields, ';', '"', '');
            foreach ($rows as $row) {
                $values = [];
                foreach ($fields as $fieldName) {
                    $values[] = $this->normalizeExportValue($row[$fieldName] ?? '');
                }
                fputcsv($stream, $values, ';', '"', '');
            }
            rewind($stream);
            $content = stream_get_contents($stream);
        } finally {
            fclose($stream);
        }

        if (!is_string($content)) {
            throw new RuntimeException('Die Exportdatei konnte nicht gelesen werden.');
        }

        return $content;
    }

    /**
     * @param array<int, string> $fields
     * @return array<int, array<string, mixed>>
     */
    private function findRows(array $fields, string $speciesType, int $targetPid): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::SPECIES_TABLE);

        $selectFields = ['species.uid AS export_uid'];
        foreach ($fields as $fieldName) {
            $tableAlias = SpeciesCsvSchema::isAttributeField($fieldName) ? 'attributes' : 'species';
            $selectFields[] = sprintf('%s.%s AS %s', $tableAlias, $fieldName, $fieldName);
        }

        return $queryBuilder
            ->selectLiteral(...$selectFields)
            ->from(self::SPECIES_TABLE, 'species')
            ->leftJoin(
                'species',
                self::ATTRIBUTES_TABLE,
                'attributes',
                $queryBuilder->expr()->and(
                    $queryBuilder->expr()->eq('attributes.uid', 'species.attributes'),
                    $queryBuilder->expr()->eq(
                        'attributes.deleted',
                        $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                    )
                )
            )
            ->where(
                $queryBuilder->expr()->eq(
                    'species.pid',
                    $queryBuilder->createNamedParameter($targetPid, ParameterType::INTEGER)
                ),
                $queryBuilder->expr()->eq(
                    'species.record_type',
                    $queryBuilder->createNamedParameter($speciesType)
                ),
                $queryBuilder->expr()->eq(
                    'species.deleted',
                    $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                ),
                $queryBuilder->expr()->in('species.sys_language_uid', [0, -1]),
                $queryBuilder->expr()->eq(
                    'species.t3ver_wsid',
                    $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                )
            )
            ->orderBy('species.name', 'ASC')
            ->addOrderBy('species.uid', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     */
    private function assertImportableRows(array $rows): void
    {
        $missingImportIdUids = [];
        $importIds = [];
        $duplicateImportIds = [];

        foreach ($rows as $row) {
            $importId = trim((string)($row['import_id'] ?? ''));
            if ($importId === '') {
                $missingImportIdUids[] = (int)($row['export_uid'] ?? 0);
                continue;
            }
            if (isset($importIds[$importId])) {
                $duplicateImportIds[] = $importId;
            }
            $importIds[$importId] = true;
        }

        if ($missingImportIdUids !== []) {
            throw new RuntimeException(sprintf(
                'Kein importfaehiger Export moeglich: Folgende Arten haben keine import_id: %s.',
                implode(', ', $missingImportIdUids)
            ));
        }
        if ($duplicateImportIds !== []) {
            throw new RuntimeException(sprintf(
                'Kein importfaehiger Export moeglich: Doppelte import_id gefunden: %s.',
                implode(', ', array_unique($duplicateImportIds))
            ));
        }
    }

    private function normalizeExportValue(mixed $value): string
    {
        if ($value === null) {
            return '';
        }

        return str_replace(["\r\n", "\r"], "\n", (string)$value);
    }
}
