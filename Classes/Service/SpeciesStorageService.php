<?php

namespace HGON\HgonSpecies\Service;

use Doctrine\DBAL\ParameterType;
use RuntimeException;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class SpeciesStorageService
{
    private const SPECIES_TABLE = 'tx_hgonspecies_domain_model_species';

    /**
     * @return array<string, string>
     */
    public function getSelectOptions(): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::SPECIES_TABLE);

        $rows = $queryBuilder
            ->selectLiteral(
                'species.pid',
                'species.record_type',
                'pages.title AS page_title',
                'COUNT(species.uid) AS record_count'
            )
            ->from(self::SPECIES_TABLE, 'species')
            ->leftJoin(
                'species',
                'pages',
                'pages',
                $queryBuilder->expr()->and(
                    $queryBuilder->expr()->eq('pages.uid', 'species.pid'),
                    $queryBuilder->expr()->eq(
                        'pages.deleted',
                        $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                    )
                )
            )
            ->where(
                $queryBuilder->expr()->or(
                    $queryBuilder->expr()->eq(
                        'species.record_type',
                        $queryBuilder->createNamedParameter('bird')
                    ),
                    $queryBuilder->expr()->eq(
                        'species.record_type',
                        $queryBuilder->createNamedParameter('dragonfly')
                    )
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
            ->groupBy('species.pid', 'species.record_type', 'pages.title')
            ->orderBy('species.record_type', 'ASC')
            ->addOrderBy('pages.title', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();

        $options = [];
        foreach ($rows as $row) {
            $pid = (int)$row['pid'];
            $speciesType = (string)$row['record_type'];
            $typeLabel = $speciesType === 'bird' ? 'Vögel' : 'Libellen';
            $pageTitle = trim((string)($row['page_title'] ?? ''));
            $folderLabel = $pageTitle !== '' ? $pageTitle : 'Datenordner';
            $recordCount = (int)$row['record_count'];

            $options[$pid . ':' . $speciesType] = sprintf(
                '%s – %s (PID %d, %d Datensätze)',
                $typeLabel,
                $folderLabel,
                $pid,
                $recordCount
            );
        }

        return $options;
    }

    /**
     * @return array{targetPid: int, speciesType: string}
     */
    public function resolveSelection(string $selection): array
    {
        $options = $this->getSelectOptions();
        if (!array_key_exists($selection, $options)) {
            throw new RuntimeException('Der ausgewählte Datenordner ist nicht verfügbar.');
        }

        [$targetPid, $speciesType] = explode(':', $selection, 2);

        return [
            'targetPid' => (int)$targetPid,
            'speciesType' => $speciesType,
        ];
    }
}
