<?php
namespace HGON\HgonSpecies\Domain\Model;

/***
 *
 * This file is part of the "HgonSpecies" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2025 Maximilian Fäßler <maximilian@faesslerweb.de>, Fäßler Web UG
 *
 ***/

/**
 * Attributes
 */
class Attributes
{

    /**
     * length
     *
     * @var string
     */
    protected $length = '';

    /**
     * wingspan
     *
     * @var string
     */
    protected $wingspan = '';

    /**
     * weight
     *
     * @var string
     */
    protected $weight = '';

    /**
     * ageLimit
     *
     * @var string
     */
    protected $ageLimit = '';

    /**
     * food
     *
     * @var string
     */
    protected $food = '';

    /**
     * nestSize
     *
     * @var string
     */
    protected $nestSize = '';

    /**
     * breedingSeason
     *
     * @var string
     */
    protected $breedingSeason = '';

    /**
     * migratoryBehavior
     *
     * @var string
     */
    protected $migratoryBehavior = '';

    /**
     * winterDistrict
     *
     * @var string
     */
    protected $winterDistrict = '';

    /**
     * Retrieves the length.
     *
     * @return string The length value.
     */
    public function getLength(): string
    {
        return $this->length;
    }

    /**
     * Sets the length of the object.
     *
     * @param string $length The length to be set.
     * @return void
     */
    public function setLength(string $length): void
    {
        $this->length = $length;
    }

    /**
     * Retrieves the wingspan value.
     *
     * @return string The wingspan value.
     */
    public function getWingspan(): string
    {
        return $this->wingspan;
    }

    /**
     * Sets the wingspan value.
     *
     * @param string $wingspan The new wingspan value to set.
     * @return void
     */
    public function setWingspan(string $wingspan): void
    {
        $this->wingspan = $wingspan;
    }

    /**
     * Retrieves the weight value.
     *
     * @return string The weight value.
     */
    public function getWeight(): string
    {
        return $this->weight;
    }

    /**
     * Sets the weight value.
     *
     * @param string $weight The weight value to set.
     * @return void
     */
    public function setWeight(string $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * Retrieves the age limit value.
     *
     * @return string The age limit value.
     */
    public function getAgeLimit(): string
    {
        return $this->ageLimit;
    }

    /**
     * Sets the age limit value.
     *
     * @param string $ageLimit The age limit value to set.
     * @return void
     */
    public function setAgeLimit(string $ageLimit): void
    {
        $this->ageLimit = $ageLimit;
    }

    /**
     * Retrieves the food value.
     *
     * @return string
     */
    public function getFood(): string
    {
        return $this->food;
    }

    /**
     * Sets the food value.
     *
     * @param string $food The food item to be set.
     * @return void
     */
    public function setFood(string $food): void
    {
        $this->food = $food;
    }

    /**
     * Retrieves the nest size value.
     *
     * @return string The nest size value.
     */
    public function getNestSize(): string
    {
        return $this->nestSize;
    }

    /**
     * Sets the nest size value.
     *
     * @param string $nestSize The size of the nest to set.
     * @return void
     */
    public function setNestSize(string $nestSize): void
    {
        $this->nestSize = $nestSize;
    }

    /**
     * Retrieves the breeding season value*/
    public function getBreedingSeason(): string
    {
        return $this->breedingSeason;
    }

    /**
     * Sets the breeding season for the entity.
     *
     * @param string $breedingSeason The breeding season to set.
     * @return void
     */
    public function setBreedingSeason(string $breedingSeason): void
    {
        $this->breedingSeason = $breedingSeason;
    }

    /**
     * Retrieves the migratory behavior of the entity.
     *
     * @return string The migratory behavior.
     */
    public function getMigratoryBehavior(): string
    {
        return $this->migratoryBehavior;
    }

    /**
     * Sets the migratory behavior.
     *
     * @param string $migratoryBehavior The migratory behavior to set.
     * @return void
     */
    public function setMigratoryBehavior(string $migratoryBehavior): void
    {
        $this->migratoryBehavior = $migratoryBehavior;
    }

    /**
     * @return string
     */
    public function getWinterDistrict(): string
    {
        return $this->winterDistrict;
    }

    /**
     * Sets the winter district.
     *
     * @param string $winterDistrict The name of the winter district.
     * @return void
     */
    public function setWinterDistrict(string $winterDistrict): void
    {
        $this->winterDistrict = $winterDistrict;
    }

}
