<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('hgon_species', 'Configuration/TypoScript', 'HgonSpecies');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hgonspecies_domain_model_species', 'EXT:hgon_species/Resources/Private/Language/locallang_csh_tx_hgonspecies_domain_model_species.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hgonspecies_domain_model_species');

    }
);
