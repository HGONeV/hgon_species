<?php
namespace HGON\HgonSpecies\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class CsvImportService
{
    /**
     * @param array $csvFile
     * @param string $speciesType
     * @param int $targetPid
     * @return string
     */
    public function importFromCsv(array $csvFile, string $speciesType, int $targetPid): string
    {
        $separator = ';';

        $extension = strtolower(pathinfo($csvFile['name'], PATHINFO_EXTENSION));

        $rows = [];

        if (in_array($extension, ['xls', 'xlsx'])) {
            $spreadsheet = IOFactory::load($csvFile['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray(null, false, false, true);
        } elseif ($extension === 'csv') {
            $handle = fopen($csvFile['tmp_name'], 'r');
            if (!$handle) {
                return 'Datei konnte nicht geöffnet werden.';
            }

            $headerArray = fgetcsv($handle, 0, $separator, '"');

            while (($dataArray = fgetcsv($handle, 0, $separator, '"')) !== false) {
                // optional: alle Felder trimmen
                $dataArray = array_map('trim', $dataArray);

                // Kombinieren der Felder mit Header
                $rows[] = array_combine($headerArray, $dataArray);
            }
            fclose($handle);
        } else {
            return 'Dateiformat nicht unterstützt.';
        }


        // Check speciesType + PID combination
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_hgonspecies_domain_model_species');

        $statement = $queryBuilder
            ->count('uid')
            ->from('tx_hgonspecies_domain_model_species')
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($targetPid, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('record_type', $queryBuilder->createNamedParameter($speciesType))
            )
            ->execute();

        $count = (int)$statement->fetchColumn();

        if (!$count) {
            return 'Auf der angegebenen PID konnten keine Datensätze vom Typ "' . $speciesType . '" gefunden werden. Erstelle zuerst mindestens einen Datensatz an der gewünschten Stelle, damit der Import durchgeführt werden kann.';
        }


        $imported = 0;
        $updated = 0;

        foreach ($rows as $record) {

            // check mandatory fields
            if (
                !is_array($record)
                || !isset($record['name'])
                || !isset($record['name_science'])
                || !isset($record['import_id'])
                || !isset($record['family'])
            ) {
                continue;
            }


            // check if entry already exists
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('tx_hgonspecies_domain_model_species');

            $statement = $queryBuilder
                ->select('attributes', 'import_id')
                ->from('tx_hgonspecies_domain_model_species')
                ->where(
                    $queryBuilder->expr()->eq('import_id', $queryBuilder->createNamedParameter($record['import_id'], \PDO::PARAM_STR))
                )
                ->execute();

            $recordFromDbExists = $statement->fetch(\PDO::FETCH_ASSOC);

            // ✳️ Schritt 1: Attributes-Datensatz anlegen
            $attributesFields = [
                'length', 'wingspan', 'weight', 'age_limit',
                'food', 'nest_size', 'breeding_season',
                'migratory_behavior', 'winter_district'
            ];

            $attributesData = [];
            foreach ($attributesFields as $field) {
                $attributesData[$field] = $record[$field] ?? '';
            }
            $attributesData['pid'] = $targetPid;

            $attributesConnection = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tx_hgonspecies_domain_model_attributes');



            if ($recordFromDbExists) {
                // *** UPDATE ***
                $attributesConnection->update(
                    'tx_hgonspecies_domain_model_attributes',
                    $attributesData,
                    [
                        'uid' => $recordFromDbExists['attributes']
                    ]
                );
            } else {
                // *** INSERT ***
                $attributesConnection->insert(
                    'tx_hgonspecies_domain_model_attributes',
                    $attributesData
                );
                $attributesUid = $attributesConnection->lastInsertId('tx_hgonspecies_domain_model_attributes');
            }

            // ✳️ Schritt 2: Species-Datensatz anlegen mit relation zu attributes
            $speciesData = [
                'name' => $record['name'] ?? '',
                'name_science' => $record['name_science'] ?? '',
                'name_discoverer' => $record['name_discoverer'] ?? '',
                'subtitle' => $record['subtitle'] ?? '',
                'year' => $record['year'] ?? '',
                'remark' => $record['remark'] ?? '',
                'characteristic' => $record['characteristic'] ?? '',
                'habitat' => $record['habitat'] ?? '',
                'dissemination' => $record['dissemination'] ?? '',
                'grid_frequency' => $record['grid_frequency'] ?? '',
                'last_updated_date' => $record['last_updated_date'] ?? '',
                'red_list_comment' => $record['red_list_comment'] ?? '',
                'red_list_hessia' => $record['red_list_hessia'] ?? '',
                'red_list_germany' => $record['red_list_germany'] ?? '',
                'phenology' => $record['phenology'] ?? '',
                'mtb64' => $record['mtb64'] ?? '',
                'proof' => $record['proof'] ?? '',
                'family' => $record['family'] ?? '',
                'state_of_preservation_hessia' => $record['state_of_preservation_hessia'] ?? '',
                'eu_vsrl' => $record['eu_vsrl'] ?? '',
                'population_in_hessia' => $record['population_in_hessia'] ?? '',
                'population_development' => $record['population_development'] ?? '',
                'custom_link' => $record['custom_link'] ?? '',
                'import_id' => $record['import_id'] ?? '',
               // 'attributes' => $attributesUid, // 💡 Die Relation (1:1)
                'pid' => $targetPid,
                'record_type' => $speciesType
            ];

            if (!$recordFromDbExists) {
                $speciesData['attributes'] = $attributesUid;
            }

            $speciesConnection = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tx_hgonspecies_domain_model_species');

            if ($recordFromDbExists) {
                // *** UPDATE ***
                $speciesConnection->update(
                    'tx_hgonspecies_domain_model_species',
                    $speciesData,
                    [
                        'import_id' => $record['import_id']
                    ]
                );

                $updated++;
            } else {
                // *** INSERT ***
                $speciesConnection->insert(
                    'tx_hgonspecies_domain_model_species',
                    $speciesData
                );

                $imported++;
            }

            /*
            GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tx_hgonspecies_domain_model_species')
                ->insert('tx_hgonspecies_domain_model_species', $speciesData);
            */

        }

        return "Es wurden $imported Datensätze importiert. Und $updated wurden aktualisiert.";
    }


    /**
     * Cleans given string for import
     *
     * @param string $string
     * @return string
     */
    protected function parseHtml($string)
    {
        // add p-tag-wrap
        if (strip_tags($string) == $string) {
            $string = '<p>' . $string . '</p>';
        }

        // get replacement for UL-lists
        // $string = preg_replace('/[\\]{1}[n]{1}\* (.*?)/', '<ul><li>$1</li></ul>', $string);
        // $string = preg_replace('/<\/ul><ul>/', '', $string);

        return trim($string);
        //===
    }


    /**
     * Cleans given string for import
     *
     * @param string $string
     * @return string
     */
    protected function stringCleanUp($string)
    {
        // configuration for HTML-Cleanup
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
        $parseObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Html\\HtmlParser');
        $string = $parseObj->HTMLcleaner(trim($string), $tagCfg, 0, 0, $additionalConfig);
        $string = str_replace('\n', "", trim($string));
        $string = str_replace('<p><p>', '<p>', trim($string));
        $string = str_replace('</p></p>', '</p>', trim($string));
        $string = str_replace('&shy;', '', trim($string));

        return trim($string);
        //===
    }


}
