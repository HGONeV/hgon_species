<?php
defined('TYPO3') or die("Access denied.");

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extKey,
            'List',
            [
                \HGON\HgonSpecies\Controller\SpeciesController::class => 'list'
            ],
            // non-cacheable actions
            [
                \HGON\HgonSpecies\Controller\SpeciesController::class => 'list'
            ],
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
        );

        /*
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extKey,
            'ListByCategory',
            [
                \HGON\HgonSpecies\Controller\SpeciesController::class => 'listByCategory'
            ],
            // non-cacheable actions
            [
                \HGON\HgonSpecies\Controller\SpeciesController::class => 'listByCategory'
            ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
        );
        */

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extKey,
            'Show',
            [
                \HGON\HgonSpecies\Controller\SpeciesController::class => 'show'
            ],
            // non-cacheable actions
            [
                \HGON\HgonSpecies\Controller\SpeciesController::class => 'show'
            ],
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
        );

    },
    'hgon_species'
);
