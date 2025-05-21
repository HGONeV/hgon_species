<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'type' => 'record_type',
        'searchFields' => 'name,name_science,name_discoverer,year,remark,characteristic,habitat,dissemination,grid_frequency,last_updated_date,red_list_hessia,red_list_germany,phenology,mtb64,proof,image,dissemination_img,sidebar_img,files,family,subtitle,did_you_know,state_of_preservation_hessia,eu_vsrl,population_in_hessia,population_development,custom_link',
        'iconfile' => 'EXT:hgon_species/Resources/Public/Icons/tx_hgonspecies_domain_model_species.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, name_science, name_discoverer, year, remark, characteristic, habitat, dissemination, grid_frequency, last_updated_date, red_list_hessia, red_list_germany, phenology, mtb64, proof, image, dissemination_img, sidebar_img, files, family, subtitle, did_you_know, state_of_preservation_hessia, eu_vsrl, population_in_hessia, population_development, custom_link',
    ],
    'types' => [
        '0' => [
            'showitem' => '
                record_type
        '],
        'default' => [
            'showitem' => '
            
                record_type, name, name_science, name_discoverer, year, first_spotted, last_spotted, grid_frequency, last_updated_date, red_list_hessia, red_list_germany, mtb64, proof,
            
                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_text,
                characteristic, habitat, dissemination, phenology, remark, 
                
                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_family,
                family,
                
                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_files,
                image, dissemination_img, sidebar_img, files,
                
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, 
                sys_language_uid, l10n_parent, l10n_diffsource, 
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, 
                hidden
            
        '],
        'dragonfly' => [
            'showitem' => '
            
                record_type, name, name_science, first_spotted, last_spotted, grid_frequency, last_updated_date, red_list_hessia, red_list_germany, mtb64, proof,
            
                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_text,
                characteristic, habitat, dissemination, phenology, remark, 
                
                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_family,
                family,
                
                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_files,
                image, dissemination_img, sidebar_img, files,
                
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, 
                sys_language_uid, l10n_parent, l10n_diffsource, 
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, 
                hidden
            
        '],
        'bird' => [
            'showitem' => '
            
                record_type, name, name_science, subtitle, first_spotted, last_spotted, grid_frequency, last_updated_date, red_list_hessia, red_list_germany, eu_vsrl, state_of_preservation_hessia, mtb64, proof, customLink,
            
                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_text,
                characteristic, population_in_hessia, habitat, population_development, dissemination, phenology, remark, did_you_know, 
                
                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_attributes,
                attributes,
                
                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_family,
                family,
                
                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_files,
                image, dissemination_img, sidebar_img, files,
                
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, 
                sys_language_uid, l10n_parent, l10n_diffsource, 
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, 
                hidden
            
        '],
    ],
    'columns' => [

        'record_type' => [
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.recordType',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'items' => [
                    ['LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.recordType.choose', 0],
                    ['LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.recordType.default', 'default'],
                    ['LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.recordType.dragonfly', 'dragonfly'],
                    ['LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.recordType.bird', 'bird'],
                ],
                'minitems' => 1,
                'maxitems' => 1,
                'default' => '0'
            ],
        ],
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_hgonspecies_domain_model_species',
                'foreign_table_where' => 'AND tx_hgonspecies_domain_model_species.pid=###CURRENT_PID### AND tx_hgonspecies_domain_model_species.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
            ],
        ],

        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'name_science' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.name_science',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'name_discoverer' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.name_discoverer',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
            //'displayCond' => 'FIELD:record_type:!=:dragonfly'
        ],
        'subtitle' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.subtitle',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
        'year' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.year',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,required'
            ],
        ],
        'remark' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.remark',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'characteristic' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.characteristic',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            
        ],
        'habitat' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.habitat',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'dissemination' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.dissemination',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'did_you_know' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.did_you_know',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim',
            ],
        ],
        'grid_frequency' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.grid_frequency',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'last_updated_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.last_updated_date',
            'config' => [
                'dbType' => 'date',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 7,
                'eval' => 'date',
                'default' => null,
            ],
        ],
        'red_list_hessia' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.red_list_hessia',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'state_of_preservation_hessia' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.state_of_preservation_hessia',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
        'red_list_germany' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.red_list_germany',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'eu_vsrl' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.eu_vsrl',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
        'first_spotted' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.first_spotted',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'format' => 'date',
                'eval' => 'date',
                'default' => 0,
            ],
        ],
        'last_spotted' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.last_spotted',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'format' => 'date',
                'eval' => 'date',
                'default' => 0,
            ],
        ],
        'phenology' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.phenology',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'mtb64' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.mtb64',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ]
        ],
        'proof' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.proof',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ]
        ],
        'population_in_hessia' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.population_in_hessia',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
        'population_development' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.population_development',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'custom_link' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.custom_link',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'eval' => 'trim',
                'softref' => 'typolink',
            ],
        ],
        'image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.image',
            'config' => 
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ]
                    ],
                    'maxitems' => 20
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),

        ],
        'dissemination_img' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.dissemination_img',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'dissemination_img',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ]
                    ],
                    'maxitems' => 2
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'sidebar_img' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.sidebar_img',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'sidebar_img',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ]
                    ],
                    'maxitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'files' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.files',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'files',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media.addFileReference'
                    ],
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ]
                    ],
                    'maxitems' => 1
                ]
            ),
        ],
        'family' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.family',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'sys_category',
                'minitems' => 1,
                'maxitems' => 1,
                'multiple' => false,
                'treeConfig' => [
                    'parentField' =>'parent',
                    'appearance' => [
                        'expandAll' => true,
                        'showHeader' => true,
                    ],
                ],
            ],
        ],
        'attributes' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.attributes',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_hgonspecies_domain_model_attributes',
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 1,
                    'newRecordLinkAddTitle' => 1,
                    'useSortable' => 0,
                    'showSynchronizationLink' => 1,
                    'showAllLocalizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showRemovedLocalizationRecords' => 0,
                ],
            ],
        ],
        /*
         * // comes automatically from "family" parent
        'extended_family' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.extended_family',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'sys_category',
                'minitems' => 0,
                'maxitems' => 9999,
                'multiple' => 1,
                'treeConfig' => [
                    'parentField' =>'parent',
                    'appearance' => [
                        'expandAll' => false,
                        'showHeader' => true,
                    ],
                ],
            ],
        ],
        */
    
    ],
];
