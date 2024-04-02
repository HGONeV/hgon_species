<?php
namespace Hgon\HgonSpecies\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 */
class SpeciesTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Hgon\HgonSpecies\Domain\Model\Species
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Hgon\HgonSpecies\Domain\Model\Species();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getNameScienceReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getNameScience()
        );
    }

    /**
     * @test
     */
    public function setNameScienceForStringSetsNameScience()
    {
        $this->subject->setNameScience('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'nameScience',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getNameDiscovererReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getNameDiscoverer()
        );
    }

    /**
     * @test
     */
    public function setNameDiscovererForStringSetsNameDiscoverer()
    {
        $this->subject->setNameDiscoverer('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'nameDiscoverer',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getYearReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getYear()
        );
    }

    /**
     * @test
     */
    public function setYearForDateTimeSetsYear()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setYear($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'year',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCharacteristicReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCharacteristic()
        );
    }

    /**
     * @test
     */
    public function setCharacteristicForStringSetsCharacteristic()
    {
        $this->subject->setCharacteristic('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'characteristic',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getHabitatReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getHabitat()
        );
    }

    /**
     * @test
     */
    public function setHabitatForStringSetsHabitat()
    {
        $this->subject->setHabitat('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'habitat',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDisseminationReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDissemination()
        );
    }

    /**
     * @test
     */
    public function setDisseminationForStringSetsDissemination()
    {
        $this->subject->setDissemination('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'dissemination',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getGridFrequencyReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getGridFrequency()
        );
    }

    /**
     * @test
     */
    public function setGridFrequencyForFloatSetsGridFrequency()
    {
        $this->subject->setGridFrequency(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'gridFrequency',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getLastUpdatedDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getLastUpdatedDate()
        );
    }

    /**
     * @test
     */
    public function setLastUpdatedDateForDateTimeSetsLastUpdatedDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setLastUpdatedDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'lastUpdatedDate',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getRedListHessiaReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getRedListHessia()
        );
    }

    /**
     * @test
     */
    public function setRedListHessiaForStringSetsRedListHessia()
    {
        $this->subject->setRedListHessia('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'redListHessia',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getRedListGermanyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getRedListGermany()
        );
    }

    /**
     * @test
     */
    public function setRedListGermanyForStringSetsRedListGermany()
    {
        $this->subject->setRedListGermany('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'redListGermany',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPhenologyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPhenology()
        );
    }

    /**
     * @test
     */
    public function setPhenologyForStringSetsPhenology()
    {
        $this->subject->setPhenology('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'phenology',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMtb64ReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getMtb64()
        );
    }

    /**
     * @test
     */
    public function setMtb64ForIntSetsMtb64()
    {
        $this->subject->setMtb64(12);

        self::assertAttributeEquals(
            12,
            'mtb64',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getProofReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getProof()
        );
    }

    /**
     * @test
     */
    public function setProofForIntSetsProof()
    {
        $this->subject->setProof(12);

        self::assertAttributeEquals(
            12,
            'proof',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getImageReturnsInitialValueForFileReference()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getImage()
        );
    }

    /**
     * @test
     */
    public function setImageForFileReferenceSetsImage()
    {
        $image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $objectStorageHoldingExactlyOneImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneImage->attach($image);
        $this->subject->setImage($objectStorageHoldingExactlyOneImage);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneImage,
            'image',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addImageToObjectStorageHoldingImage()
    {
        $image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $imageObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $imageObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($image));
        $this->inject($this->subject, 'image', $imageObjectStorageMock);

        $this->subject->addImage($image);
    }

    /**
     * @test
     */
    public function removeImageFromObjectStorageHoldingImage()
    {
        $image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $imageObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $imageObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($image));
        $this->inject($this->subject, 'image', $imageObjectStorageMock);

        $this->subject->removeImage($image);
    }

    /**
     * @test
     */
    public function getDisseminationImgReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getDisseminationImg()
        );
    }

    /**
     * @test
     */
    public function setDisseminationImgForFileReferenceSetsDisseminationImg()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setDisseminationImg($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'disseminationImg',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSidebarImgReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getSidebarImg()
        );
    }

    /**
     * @test
     */
    public function setSidebarImgForFileReferenceSetsSidebarImg()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setSidebarImg($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'sidebarImg',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFilesReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getFiles()
        );
    }

    /**
     * @test
     */
    public function setFilesForFileReferenceSetsFiles()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setFiles($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'files',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFamilyReturnsInitialValueForCategory()
    {
    }

    /**
     * @test
     */
    public function setFamilyForCategorySetsFamily()
    {
    }

    /**
     * @test
     */
    public function getExtendedFamilyReturnsInitialValueForCategory()
    {
    }

    /**
     * @test
     */
    public function setExtendedFamilyForCategorySetsExtendedFamily()
    {
    }
}
