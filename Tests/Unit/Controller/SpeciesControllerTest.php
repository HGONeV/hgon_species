<?php
namespace Hgon\HgonSpecies\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 */
class SpeciesControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Hgon\HgonSpecies\Controller\SpeciesController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Hgon\HgonSpecies\Controller\SpeciesController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllSpeciessFromRepositoryAndAssignsThemToView()
    {

        $allSpeciess = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $speciesRepository = $this->getMockBuilder(\Hgon\HgonSpecies\Domain\Repository\SpeciesRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $speciesRepository->expects(self::once())->method('findAll')->will(self::returnValue($allSpeciess));
        $this->inject($this->subject, 'speciesRepository', $speciesRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('speciess', $allSpeciess);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenSpeciesToView()
    {
        $species = new \Hgon\HgonSpecies\Domain\Model\Species();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('species', $species);

        $this->subject->showAction($species);
    }
}
