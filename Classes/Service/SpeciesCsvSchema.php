<?php

namespace HGON\HgonSpecies\Service;

use RuntimeException;

final class SpeciesCsvSchema
{
    public const ATTRIBUTE_FIELDS = [
        'length',
        'wingspan',
        'weight',
        'age_limit',
        'food',
        'nest_size',
        'breeding_season',
        'migratory_behavior',
        'winter_district',
    ];

    public const SPECIES_FIELDS = [
        'name',
        'name_science',
        'name_discoverer',
        'subtitle',
        'year',
        'remark',
        'characteristic',
        'habitat',
        'dissemination',
        'grid_frequency',
        'last_updated_date',
        'red_list_comment',
        'red_list_hessia',
        'red_list_germany',
        'phenology',
        'mtb64',
        'proof',
        'family',
        'state_of_preservation_hessia',
        'eu_vsrl',
        'population_in_hessia',
        'population_development',
        'custom_link',
        'import_id',
        'first_spotted',
        'last_spotted',
    ];

    private const EXPORT_FIELDS = [
        'bird' => [
            'import_id',
            'family',
            'name',
            'name_science',
            'subtitle',
            'red_list_comment',
            'red_list_hessia',
            'red_list_germany',
            'eu_vsrl',
            'state_of_preservation_hessia',
            'custom_link',
            'characteristic',
            'population_in_hessia',
            'habitat',
            'population_development',
            'dissemination',
            'phenology',
            'remark',
            'length',
            'wingspan',
            'weight',
            'age_limit',
            'food',
            'nest_size',
            'breeding_season',
            'migratory_behavior',
            'winter_district',
        ],
        'dragonfly' => [
            'import_id',
            'family',
            'name',
            'name_science',
            'first_spotted',
            'last_spotted',
            'grid_frequency',
            'last_updated_date',
            'red_list_hessia',
            'red_list_germany',
            'mtb64',
            'proof',
            'characteristic',
            'habitat',
            'dissemination',
            'phenology',
            'remark',
        ],
    ];

    /**
     * @return array<int, string>
     */
    public static function allowedImportFields(): array
    {
        return array_values(array_unique(array_merge(self::SPECIES_FIELDS, self::ATTRIBUTE_FIELDS)));
    }

    /**
     * @return array<int, string>
     */
    public static function exportFieldsForType(string $speciesType): array
    {
        if (!isset(self::EXPORT_FIELDS[$speciesType])) {
            throw new RuntimeException(sprintf('Unbekannter Datensatz-Typ "%s".', $speciesType));
        }

        return self::EXPORT_FIELDS[$speciesType];
    }

    public static function isAttributeField(string $fieldName): bool
    {
        return in_array($fieldName, self::ATTRIBUTE_FIELDS, true);
    }
}
