<?php
declare(strict_types = 1);

return [
    \HGON\HgonSpecies\Domain\Model\Species::class => [
        'subclasses' => [
            0 => \HGON\HgonSpecies\Domain\Model\SpeciesDefault::class,
            1 => \HGON\HgonSpecies\Domain\Model\SpeciesDragonfly::class,
            2 => \HGON\HgonSpecies\Domain\Model\SpeciesBird::class,
        ],
    ],

    \HGON\HgonSpecies\Domain\Model\SpeciesDefault::class => [
        'tableName'  => 'tx_hgonspecies_domain_model_species',
        'recordType' => 'default',
    ],

    \HGON\HgonSpecies\Domain\Model\SpeciesDragonfly::class => [
        'tableName'  => 'tx_hgonspecies_domain_model_species',
        'recordType' => 'dragonfly',
    ],

    \HGON\HgonSpecies\Domain\Model\SpeciesBird::class => [
        'tableName'  => 'tx_hgonspecies_domain_model_species',
        'recordType' => 'bird',
    ],

    // Custom Category model mapped to sys_category
    \HGON\HgonSpecies\Domain\Model\Category::class => [
        'tableName' => 'sys_category',
    ],

    // Core Category subclass mapping: old TS key "Tx_HgonSpecies_Category"
    // becomes recordType "Tx_HgonSpecies_Category" for sys_category records.
    \TYPO3\CMS\Extbase\Domain\Model\Category::class => [
        'subclasses' => [
            'Tx_HgonSpecies_Category' => \HGON\HgonSpecies\Domain\Model\Category::class,
        ],
    ],
];


