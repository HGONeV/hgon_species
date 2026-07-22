<?php
declare(strict_types=1);

return [
    'web_hgonspecies_speciesImport' => [
        'parent' => 'web',
        'position' => [],
        'access' => 'user,group',
        'iconIdentifier' => 'hgon-species-module',
        'labels' => 'LLL:EXT:hgon_species/Resources/Private/Language/locallang_be.xlf',
        'extensionName' => 'HgonSpecies',
        'controllerActions' => [
            \HGON\HgonSpecies\Controller\BackendController::class => [
                'index',
                'import',
                'export',
            ],
        ],
    ],
];
