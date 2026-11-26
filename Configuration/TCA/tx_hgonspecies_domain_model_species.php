<?php

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

return [
    'ctrl' => [
        'title' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species',
        'label' => 'name',
        'rootLevel' => 0,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
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
        'searchFields' => 'name,name_science,name_discoverer,year,remark,characteristic,habitat,dissemination,grid_frequency,last_updated_date,red_list_comment,red_list_hessia,red_list_germany,phenology,mtb64,proof,image,dissemination_img,sidebar_img,files,family,subtitle,did_you_know,state_of_preservation_hessia,eu_vsrl,population_in_hessia,population_development,custom_link,import_id',
        'iconfile' => 'EXT:hgon_species/Resources/Public/Icons/tx_hgonspecies_domain_model_species.gif'
    ],
    'types' => [
        '0' => [
            'showitem' => '
                record_type
        '],
        'default' => [
            'showitem' => '

                record_type, import_id, name, slug, name_science, name_discoverer, year, first_spotted, last_spotted, grid_frequency, last_updated_date, red_list_hessia, red_list_germany, mtb64, proof,

                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_text,
                characteristic, habitat, dissemination, phenology, remark,

                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_family,
                family,

                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_files,
                image, dissemination_img, sidebar_img, files,

                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                sys_language_uid, l10n_diffsource,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                hidden

        '],
        'dragonfly' => [
            'showitem' => '

                record_type, import_id, name, slug, name_science, first_spotted, last_spotted, grid_frequency, last_updated_date, red_list_hessia, red_list_germany, mtb64, proof,

                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_text,
                characteristic, habitat, dissemination, phenology, remark,

                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_family,
                family,

                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_files,
                image, dissemination_img, sidebar_img, files,

                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                sys_language_uid, l10n_diffsource,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                hidden

        '],
        'bird' => [
            'showitem' => '

                record_type, import_id, name, slug, name_science, subtitle, red_list_comment, red_list_hessia, red_list_germany, eu_vsrl, state_of_preservation_hessia, custom_link, dda_link,

                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_text,
                characteristic, population_in_hessia, habitat, population_development, dissemination, phenology, remark,

                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_attributes,
                attributes,

                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_family,
                family,

                --div--;LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.tab_files,
                image, dissemination_img, sidebar_img,

                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                sys_language_uid, l10n_diffsource,
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
                    [
                        'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.recordType.choose',
                        'value' => 0,
                    ],
                    [
                        'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.recordType.default',
                        'value' => 'default',
                    ],
                    [
                        'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.recordType.dragonfly',
                        'value' => 'dragonfly',
                    ],
                    [
                        'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.recordType.bird',
                        'value' => 'bird',
                    ],
                ],
                'minitems' => 1,
                'maxitems' => 1,
                'default' => '0'
            ],
        ],
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    [
                        'label' => '',
                        'value' => 0,
                    ],
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
                    [
                        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.enabled',
                        'value' => 1,
                    ],
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
                'type' => 'datetime',
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
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
            ],
        ],

        'import_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.import_id',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true
            ],
        ],
        'slug' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:pages.slug',
            'displayCond' => 'VERSION:IS:false',
            'config' => [
                'type' => 'slug',
                'size' => 50,
                'generatorOptions' => [
                    'fields' => ['name'],
                    'replacements' => [
                        '/' => '-',
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInPid',
                'default' => '',
            ],
        ],
        'name_science' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.name_science',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true
            ],
        ],
        'name_discoverer' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.name_discoverer',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true
            ],
            //'displayCond' => 'FIELD:record_type:!=:dragonfly'
        ],
        'subtitle' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.subtitle',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'year' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.year',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim',
                'required' => true
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
                'rows' => 5,
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
                'rows' => 5,
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
                'rows' => 5,
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
                'rows' => 5,
                'eval' => 'trim'
            ]
        ],
        /*
        'did_you_know' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.did_you_know',
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
                'rows' => 5,
                'eval' => 'trim',
            ],
        ],
        */
        'grid_frequency' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.grid_frequency',
            'config' => [
                'type' => 'number',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'last_updated_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.last_updated_date',
            'config' => [
                'dbType' => 'date',
                'type' => 'datetime',
                'default' => null,
            ],
        ],
        'red_list_comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.red_list_comment',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim'
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
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.state_of_preservation_hessia.choose',
                        'value' => 0,
                    ],
                    [
                        'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.state_of_preservation_hessia.favorable',
                        'value' => 'g',
                    ],
                    [
                        'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.state_of_preservation_hessia.unfavorable',
                        'value' => 'u',
                    ],
                    [
                        'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.state_of_preservation_hessia.poor',
                        'value' => 's',
                    ],
                ],
                'minitems' => 1,
                'maxitems' => 1,
                'default' => '0'
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
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'first_spotted' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.first_spotted',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
            ],
        ],
        'last_spotted' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.last_spotted',
            'config' => [
                'type' => 'datetime',
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
                'rows' => 5,
                'eval' => 'trim'
            ]
        ],
        'mtb64' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.mtb64',
            'config' => [
                'type' => 'number',
                'size' => 4,
            ]
        ],
        'proof' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.proof',
            'config' => [
                'type' => 'number',
                'size' => 4,
            ]
        ],
        'population_in_hessia' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.population_in_hessia',
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
                'rows' => 5,
                'eval' => 'trim',
            ],
        ],
        'population_development' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.population_development',
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
                'rows' => 5,
                'eval' => 'trim',
            ],
        ],
        'custom_link' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.custom_link',
            'config' => [
                'type' => 'link',
                'eval' => 'trim',
            ],
        ],
        'dda_link' => [
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.dda_link',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'max' => 255,
                'placeholder' => 'https://www.dda-web.de/voegel/voegel-in-deutschland/…',
            ],
        ],
        'image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.image',
            'config' => [
                'type' => 'file',
                'allowed' => (string)($GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'] ?? 'jpg,jpeg,png,gif'),
                'maxitems' => 99,
                'appearance' => [
                    'createNewRelationLinkTitle' =>
                        'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                ],
                'overrideChildTca' => [
                    'types' => [
                        0 => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_TEXT => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_IMAGE => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_AUDIO => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_VIDEO => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_APPLICATION => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                    ],
                ],
            ],
        ],

        'dissemination_img' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.dissemination_img',
            'config' => [
                'type' => 'file',
                'allowed' => (string)($GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'] ?? 'jpg,jpeg,png,gif'),
                'maxitems' => 99,
                'appearance' => [
                    'createNewRelationLinkTitle' =>
                        'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                ],
                'overrideChildTca' => [
                    'types' => [
                        0 => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_TEXT => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_IMAGE => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_AUDIO => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_VIDEO => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_APPLICATION => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                    ],
                ],
            ],
        ],

        'sidebar_img' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.sidebar_img',
            'config' => [
                'type' => 'file',
                'allowed' => (string)($GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'] ?? 'jpg,jpeg,png,gif'),
                'maxitems' => 1,
                'appearance' => [
                    'createNewRelationLinkTitle' =>
                        'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                ],
                'overrideChildTca' => [
                    'types' => [
                        0 => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_TEXT => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_IMAGE => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_AUDIO => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_VIDEO => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_APPLICATION => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                    ],
                ],
            ],
        ],

        'files' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_species.files',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'appearance' => [
                    'createNewRelationLinkTitle' =>
                        'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media.addFileReference',
                ],
                'overrideChildTca' => [
                    'types' => [
                        0 => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_TEXT => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_IMAGE => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_AUDIO => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_VIDEO => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                        File::FILETYPE_APPLICATION => [
                            'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                        ],
                    ],
                ],
            ],
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
