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
            ]
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
            ]
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
            ]
        );

        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
                wizards.newContentElement.wizardItems.plugins {
                    elements {
                        list {
                            iconIdentifier = hgon_species-plugin-list
                            title = LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgon_species_list.name
                            description = LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgon_species_list.description
                            tt_content_defValues {
                                CType = list
                                list_type = hgonspecies_list
                            }
                        }
                    }
                    show = *
                }
           }'
        );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

			$iconRegistry->registerIcon(
				'hgon_species-plugin-list',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:hgon_species/Resources/Public/Icons/user_plugin_list.svg']
			);

    },
    'hgon_species'
);
