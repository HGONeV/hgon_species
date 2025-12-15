<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_attributes',
        'label' => 'migratory_behavior',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'hideTable' => true,
        'searchFields' => 'length,wingspan,weight,age_limit,food,nest_size,breeding_season,migratory_behavior,winter_district',
        'iconfile' => 'EXT:hgon_species/Resources/Public/Icons/tx_hgonspecies_domain_model_attributes.gif',
    ],
    'types' => [
        '1' => [
            'showitem' => '
                hidden,
                length,
                wingspan,
                weight,
                age_limit,
                food,
                nest_size,
                breeding_season,
                migratory_behavior,
                winter_district
        '],
    ],
    'columns' => [
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

        // Custom fields
        'length' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_attributes.length',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'wingspan' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_attributes.wingspan',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'weight' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_attributes.weight',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'age_limit' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_attributes.age_limit',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'food' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_attributes.food',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'nest_size' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_attributes.nest_size',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'breeding_season' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_attributes.breeding_season',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'migratory_behavior' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_attributes.migratory_behavior',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'winter_district' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_db.xlf:tx_hgonspecies_domain_model_attributes.winter_district',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
    ],
];
