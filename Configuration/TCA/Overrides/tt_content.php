<?php
defined('TYPO3_MODE') or die();


call_user_func(
    function($extKey)
    {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'HGON.HgonSpecies',
            'List',
            'HGON Artenliste'
        );

        
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'HGON.HgonSpecies',
            'Show',
            'HGON Arten Detail'
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