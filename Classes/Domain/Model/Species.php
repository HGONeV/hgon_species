<?php
namespace HGON\HgonSpecies\Domain\Model;

/***
 *
 * This file is part of the "HgonSpecies" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2024 Maximilian Fäßler <maximilian@faesslerweb.de>, Fäßler Web UG
 *
 ***/

/**
 * Species
 */
class Species extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var string
     */
    protected $recordType = '';

    /**
     * @var string
     */
    protected $importId = '';

    /**
     * name
     *
     * @var string
     * @validate NotEmpty
     */
    protected $name = '';

    /**
     * nameScience
     *
     * @var string
     */
    protected $nameScience = '';

    /**
     * nameDiscoverer
     *
     * @var string
     */
    protected $nameDiscoverer = '';

    /**
     * subtitle
     *
     * @var string
     * @validate NotEmpty
     */
    protected $subtitle = '';

    /**
     * year
     *
     * @var string
     */
    protected $year = null;

    /**
     * remark
     *
     * @var string
     */
    protected $remark = '';

    /**
     * characteristic
     *
     * @var string
     */
    protected $characteristic = '';

    /**
     * habitat
     *
     * @var string
     */
    protected $habitat = '';

    /**
     * dissemination
     *
     * @var string
     */
    protected $dissemination = '';

    /**
     * @var string
     */
    //protected $didYouKnow = '';

    /**
     * gridFrequency
     *
     * @var float
     */
    protected $gridFrequency = 0.0;

    /**
     * Feld "Stand" (vermutlich letzte Aktualisierung?)
     *
     * @var \DateTime
     */
    protected $lastUpdatedDate = null;

    /**
     * redListComment
     *
     * @var string
     */
    protected $redListComment = '';
    
    /**
     * redListHessia
     *
     * @var string
     */
    protected $redListHessia = '';

    /**
     * stateOfPreservationHessia
     *
     * @var string
     */
    protected $stateOfPreservationHessia = '';

    /**
     * redListGermany
     *
     * @var string
     */
    protected $redListGermany = '';

    /**
     * euVsrl
     *
     * @var string
     */
    protected $euVsrl = '';

    /**
     * firstSpotted
     *
     * @var string
     */
    protected $firstSpotted = '';

    /**
     * lastSpotted
     *
     * @var string
     */
    protected $lastSpotted = '';


    /**
     * phenology
     *
     * @var string
     */
    protected $phenology = '';

    /**
     * mtb64
     *
     * @var int
     */
    protected $mtb64 = 0;

    /**
     * Feld "Nachw"
     *
     * @var int
     */
    protected $proof = 0;

    /**
     * @var string
     */
    protected $populationInHessia = '';

    /**
     * @var string
     */
    protected $populationDevelopment = '';

    /**
     * @var string
     */
    protected $customLink = '';

    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @cascade remove
     */
    protected $image = null;

    /**
     * disseminationImg
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @cascade remove
     */
    protected $disseminationImg = null;

    /**
     * sidebarImg
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $sidebarImg = null;

    /**
     * files
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $files = null;

    /**
     * family
     *
     * @var \HGON\HgonSpecies\Domain\Model\Category
     */
    protected $family = null;

    /**
     * extendedFamily
     *
     * @var \HGON\HgonSpecies\Domain\Model\Category
     */
    protected $extendedFamily = null;

    /**
     * attributes
     *
     * @var \HGON\HgonSpecies\Domain\Model\Attributes
     */
    protected $attributes = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->image = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->disseminationImg = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * @return string
     */
    public function getRecordType()
    {
        return $this->recordType;
    }

    /**
     * @param string $recordType
     * @return void
     */
    public function setRecordType(string $recordType): void
    {
        $this->recordType = $recordType;
    }

    /**
     * Get importId
     *
     * @return string
     */
    public function getImportId(): string
    {
        return $this->importId;
    }

    /**
     * Set importId
     *
     * @param string $importId
     * @return void
     */
    public function setImportId(string $importId): void
    {
        $this->importId = $importId;
    }

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the nameScience
     *
     * @return string $nameScience
     */
    public function getNameScience()
    {
        return $this->nameScience;
    }

    /**
     * Sets the nameScience
     *
     * @param string $nameScience
     * @return void
     */
    public function setNameScience($nameScience)
    {
        $this->nameScience = $nameScience;
    }

    /**
     * Returns the nameDiscoverer
     *
     * @return string $nameDiscoverer
     */
    public function getNameDiscoverer()
    {
        return $this->nameDiscoverer;
    }

    /**
     * Sets the nameDiscoverer
     *
     * @param string $nameDiscoverer
     * @return void
     */
    public function setNameDiscoverer($nameDiscoverer)
    {
        $this->nameDiscoverer = $nameDiscoverer;
    }

    /**
     * @return string
     */
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     * @return void
     */
    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Returns the year
     *
     * @return string $year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Sets the year
     *
     * @param string $year
     * @return void
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * Returns the remark
     *
     * @return string $remark
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Sets the remark
     *
     * @param string $remark
     * @return void
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    }

    /**
     * Returns the characteristic
     *
     * @return string $characteristic
     */
    public function getCharacteristic()
    {
        return $this->characteristic;
    }

    /**
     * Sets the characteristic
     *
     * @param string $characteristic
     * @return void
     */
    public function setCharacteristic($characteristic)
    {
        $this->characteristic = $characteristic;
    }

    /**
     * Returns the habitat
     *
     * @return string $habitat
     */
    public function getHabitat()
    {
        return $this->habitat;
    }

    /**
     * Sets the habitat
     *
     * @param string $habitat
     * @return void
     */
    public function setHabitat($habitat)
    {
        $this->habitat = $habitat;
    }

    /**
     * Returns the dissemination
     *
     * @return string $dissemination
     */
    public function getDissemination()
    {
        return $this->dissemination;
    }

    /**
     * Sets the dissemination
     *
     * @param string $dissemination
     * @return void
     */
    public function setDissemination($dissemination)
    {
        $this->dissemination = $dissemination;
    }

    /**
     * @return string

    public function getDidYouKnow(): string
    {
        return $this->didYouKnow;
    }

    /**
     * @param string $didYouKnow
     * @return void

    public function setDidYouKnow(string $didYouKnow): void
    {
        $this->didYouKnow = $didYouKnow;
    }
     */

    /**
     * Returns the gridFrequency
     *
     * @return float $gridFrequency
     */
    public function getGridFrequency()
    {
        return $this->gridFrequency;
    }

    /**
     * Sets the gridFrequency
     *
     * @param float $gridFrequency
     * @return void
     */
    public function setGridFrequency($gridFrequency)
    {
        $this->gridFrequency = $gridFrequency;
    }

    /**
     * Returns the lastUpdatedDate
     *
     * @return \DateTime $lastUpdatedDate
     */
    public function getLastUpdatedDate()
    {
        return $this->lastUpdatedDate;
    }

    /**
     * Sets the lastUpdatedDate
     *
     * @param \DateTime $lastUpdatedDate
     * @return void
     */
    public function setLastUpdatedDate(\DateTime $lastUpdatedDate)
    {
        $this->lastUpdatedDate = $lastUpdatedDate;
    }

    /**
     * Returns the redListComment
     *
     * @return string $redListComment
     */
    public function getRedListComment()
    {
        return $this->redListComment;
    }

    /**
     * Sets the redListComment
     *
     * @param string $redListComment
     * @return void
     */
    public function setRedListComment($redListComment)
    {
        $this->redListComment = $redListComment;
    }

    /**
     * Returns the redListHessia
     *
     * @return string $redListHessia
     */
    public function getRedListHessia()
    {
        return $this->redListHessia;
    }

    /**
     * Sets the redListHessia
     *
     * @param string $redListHessia
     * @return void
     */
    public function setRedListHessia($redListHessia)
    {
        $this->redListHessia = $redListHessia;
    }

    /**
     * @return string
     */
    public function getStateOfPreservationHessia(): string
    {
        return $this->stateOfPreservationHessia;
    }

    /**
     * @param string $stateOfPreservationHessia
     * @return void
     */
    public function setStateOfPreservationHessia(string $stateOfPreservationHessia): void
    {
        $this->stateOfPreservationHessia = $stateOfPreservationHessia;
    }

    /**
     * Returns the redListGermany
     *
     * @return string $redListGermany
     */
    public function getRedListGermany()
    {
        return $this->redListGermany;
    }

    /**
     * Sets the redListGermany
     *
     * @param string $redListGermany
     * @return void
     */
    public function setRedListGermany($redListGermany)
    {
        $this->redListGermany = $redListGermany;
    }

    /**
     * @return string
     */
    public function getEuVsrl(): string
    {
        return $this->euVsrl;
    }

    /**
     * @param string $euVsrl
     * @return void
     */
    public function setEuVsrl(string $euVsrl): void
    {
        $this->euVsrl = $euVsrl;
    }

    /**
     * @return string
     */
    public function getFirstSpotted(): string
    {
        return $this->firstSpotted;
    }

    /**
     * @param string $firstSpotted
     * @return void
     */
    public function setFirstSpotted(string $firstSpotted): void
    {
        $this->firstSpotted = $firstSpotted;
    }

    /**
     * @return string
     */
    public function getLastSpotted(): string
    {
        return $this->lastSpotted;
    }

    /**
     * @param string $lastSpotted
     * @return void
     */
    public function setLastSpotted(string $lastSpotted): void
    {
        $this->lastSpotted = $lastSpotted;
    }

    /**
     * Returns the phenology
     *
     * @return string $phenology
     */
    public function getPhenology()
    {
        return $this->phenology;
    }

    /**
     * Sets the phenology
     *
     * @param string $phenology
     * @return void
     */
    public function setPhenology($phenology)
    {
        $this->phenology = $phenology;
    }

    /**
     * Returns the mtb64
     *
     * @return int $mtb64
     */
    public function getMtb64()
    {
        return $this->mtb64;
    }

    /**
     * Sets the mtb64
     *
     * @param int $mtb64
     * @return void
     */
    public function setMtb64($mtb64)
    {
        $this->mtb64 = $mtb64;
    }

    /**
     * Returns the proof
     *
     * @return int $proof
     */
    public function getProof()
    {
        return $this->proof;
    }

    /**
     * Sets the proof
     *
     * @param int $proof
     * @return void
     */
    public function setProof($proof)
    {
        $this->proof = $proof;
    }

    /**
     * @return string
     */
    public function getPopulationInHessia(): string
    {
        return $this->populationInHessia;
    }

    /**
     * @param string $populationInHessia
     * @return void
     */
    public function setPopulationInHessia(string $populationInHessia): void
    {
        $this->populationInHessia = $populationInHessia;
    }

    /**
     * @return string
     */
    public function getPopulationDevelopment(): string
    {
        return $this->populationDevelopment;
    }

    /**
     * @param string $populationDevelopment
     * @return void
     */
    public function setPopulationDevelopment(string $populationDevelopment): void
    {
        $this->populationDevelopment = $populationDevelopment;
    }

    /**
     * @return string
     */
    public function getCustomLink()
    {
        return $this->customLink;
    }

    /**
     * @param string $customLink
     */
    public function setCustomLink($customLink): void
    {
        $this->customLink = $customLink;
    }

    /**
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function addImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->image->attach($image);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove The FileReference to be removed
     * @return void
     */
    public function removeImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove)
    {
        $this->image->detach($imageToRemove);
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $image)
    {
        $this->image = $image;
    }

    /**
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $disseminationImg
     * @return void
     */
    public function addDisseminationImg(\TYPO3\CMS\Extbase\Domain\Model\FileReference $disseminationImg)
    {
        $this->image->attach($disseminationImg);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $disseminationImgToRemove The FileReference to be removed
     * @return void
     */
    public function removeDisseminationImg(\TYPO3\CMS\Extbase\Domain\Model\FileReference $disseminationImgToRemove)
    {
        $this->image->detach($disseminationImgToRemove);
    }

    /**
     * Returns the disseminationImg
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $disseminationImg
     */
    public function getDisseminationImg()
    {
        return $this->disseminationImg;
    }

    /**
     * Sets the disseminationImg
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $disseminationImg
     * @return void
     */
    public function setDisseminationImg(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $disseminationImg)
    {
        $this->disseminationImg = $disseminationImg;
    }

    /**
     * Returns the sidebarImg
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $sidebarImg
     */
    public function getSidebarImg()
    {
        return $this->sidebarImg;
    }

    /**
     * Sets the sidebarImg
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $sidebarImg
     * @return void
     */
    public function setSidebarImg(\TYPO3\CMS\Extbase\Domain\Model\FileReference $sidebarImg)
    {
        $this->sidebarImg = $sidebarImg;
    }

    /**
     * Returns the files
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $files
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Sets the files
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $files
     * @return void
     */
    public function setFiles(\TYPO3\CMS\Extbase\Domain\Model\FileReference $files)
    {
        $this->files = $files;
    }

    /**
     * Returns the family
     *
     * @return \HGON\HgonSpecies\Domain\Model\Category $family
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Sets the family
     *
     * @param \HGON\HgonSpecies\Domain\Model\Category $family
     * @return void
     */
    public function setFamily(\HGON\HgonSpecies\Domain\Model\Category $family)
    {
        $this->family = $family;
    }

    /**
     * Returns the extendedFamily
     *
     * @return \HGON\HgonSpecies\Domain\Model\Category $extendedFamily
     */
    public function getExtendedFamily()
    {
        return $this->extendedFamily;
    }

    /**
     * Sets the extendedFamily
     *
     * @param \HGON\HgonSpecies\Domain\Model\Category $extendedFamily
     * @return void
     */
    public function setExtendedFamily(\HGON\HgonSpecies\Domain\Model\Category $extendedFamily)
    {
        $this->extendedFamily = $extendedFamily;
    }

    /**
     * Returns the attributes
     *
     * @return \HGON\HgonSpecies\Domain\Model\Attributes $attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Sets the attributes
     *
     * @param \HGON\HgonSpecies\Domain\Model\Attributes $attributes
     * @return void
     */
    public function setAttributes(\HGON\HgonSpecies\Domain\Model\Attributes $attributes)
    {
        $this->attributes = $attributes;
    }
}
