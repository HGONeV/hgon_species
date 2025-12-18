<?php
declare(strict_types=1);

return [
    'web_hgonspecies_speciesImport' => [
        'parent' => 'web',
        'position' => [],
        'access' => 'user,group',
        'icon' => 'EXT:hgon_species/Resources/Public/Icons/ext_icon_be.svg',
        'labels' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_be.xlf',
        'extensionName' => 'HgonSpecies',
        'controllerActions' => [
            \HGON\HgonSpecies\Controller\BackendController::class => [
                'index',
                'import',
            ],
        ],
    ],
];
