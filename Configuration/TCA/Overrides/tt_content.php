<?php
defined('TYPO3') or die("Access denied.");


call_user_func(
    function($extKey)
    {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'List',
            'HGON Species: Artenliste'
        );

        /*
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ListByCategory',
            'HGON Species: Artenliste nach Kategorie'
        );
        */

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Show',
            'HGON Species: Arten Detail'
        );


        //=================================================================
        // Add Flexform
        //=================================================================

        /*
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['hgon_species_list'] = 'recursive,select_key,pages';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hgon_species_list'] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('hgon_species',
            'FILE:EXT:hgon_species/Configuration/FlexForms/list.xml');
        */

    },
    'hgon_species'
);
