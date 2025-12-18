<?php

use TYPO3\CMS\Core\Http\ApplicationType;

defined('TYPO3') or die("Access denied.");

call_user_func(
    function($extKey)
    {


        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hgonspecies_domain_model_species', 'EXT:hgon_species/Resources/Private/Language/locallang_csh_tx_hgonspecies_domain_model_species.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hgonspecies_domain_model_species');

    },
    'hgon_species'
);
