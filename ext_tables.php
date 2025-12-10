<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {


        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hgonspecies_domain_model_species', 'EXT:hgon_species/Resources/Private/Language/locallang_csh_tx_hgonspecies_domain_model_species.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hgonspecies_domain_model_species');


        //=================================================================
        // Register BE-Module
        //=================================================================
        if (TYPO3_MODE === 'BE') {

            /**
             * Registers a Backend Module
             */
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'HGON.' . $extKey,
                'web',	 // Make module a submodule of 'Web'
                'speciesImport',	// Submodule key
                '',						// Position
                array(
                    'Backend' => 'index, import',
                ),
                array(
                    'access' => 'user,group',
                    'icon'   => 'EXT:' . $extKey . '/ext_icon_be.gif',
                    'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf',
                )
            );

        }
    },
    $_EXTKEY
);
