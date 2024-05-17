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
        'searchFields' => 'name,name_science,name_discoverer,year,remark,characteristic,habitat,dissemination,grid_frequency,last_updated_date,red_list_hessia,red_list_germany,phenology,mtb64,proof,image,dissemination_img,sidebar_img,files,family',
        'iconfile' => 'EXT:hgon_species/Resources/Public/Icons/tx_hgonspecies_domain_model_species.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, name_science, name_discoverer, year, remark, characteristic, habitat, dissemination, grid_frequency, last_updated_date, red_list_hessia, red_list_germany, phenology, mtb64, proof, image, dissemination_img, sidebar_img, files, family',
    ],
    'types' => [
        '1' => [
            'showitem' => '
            
                record_type, name, name_science, name_discoverer, year, grid_frequency, last_updated_date, red_list_hessia, red_list_germany, mtb64, proof,  
            
                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_text,
                remark, characteristic, habitat, dissemination, phenology, 
                
                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_family,
                family,
                
                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_files,
                image, dissemination_img, sidebar_img, files,
                
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, 
                sys_language_uid, l10n_parent, l10n_diffsource, 
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, 
                hidden, starttime, endtime
            
            '],
    ],
    'columns' => [

        'record_type' => [
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.recordType',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.recordType.default', 'default'],
                    ['LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.recordType.dragonfly', 'dragonfly'],
                ],
                'default' => 'default'
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
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
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
        'red_list_germany' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.red_list_germany',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'phenology' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.phenology',
            'config' => [
                'type' => 'text',
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
