<?php
namespace HGON\HgonSpecies\Controller;

use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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
 * SpeciesController
 */
class SpeciesController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \HGON\HgonSpecies\Domain\Repository\SpeciesRepository
     */
    protected $speciesRepository;

    /**
     * @param \HGON\HgonSpecies\Domain\Repository\SpeciesRepository $speciesRepository
     */
    public function injectSpeciesRepository(\HGON\HgonSpecies\Domain\Repository\SpeciesRepository $speciesRepository): void {
        $this->speciesRepository = $speciesRepository;
    }

    /**
     * @var \HGON\HgonSpecies\Domain\Repository\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @param \HGON\HgonSpecies\Domain\Repository\CategoryRepository $categoryRepository
     */
    public function injectCategoryRepository(\HGON\HgonSpecies\Domain\Repository\CategoryRepository $categoryRepository): void {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * action list
     *
     * "Artenliste"
     *
     * @return void
     */
    public function listAction()
    {
        $speciesRecordType = 'default';
        $checkSpeciesForRecordType = $this->speciesRepository->findAll()->getFirst();
        if ($checkSpeciesForRecordType) {
            $speciesRecordType = $checkSpeciesForRecordType->getRecordType();
        }

        if ($speciesRecordType == "dragonfly") {
            $speciesList = $this->speciesRepository->findAllOrderByNameScience();
        } else {
            // bird; default
            $speciesList = $this->speciesRepository->findAllOrderByName();
        }

        $this->view->assign('speciesRecordType', $speciesRecordType);
        $this->view->assign('speciesList', $speciesList);
        //$this->view->assign('speciesCategories', $this->categoryRepository->findSubFamiliesOfExtendedFamilies($this->settings['parentCategoryUid']));
        $this->view->assign('speciesCategories', $this->categoryRepository->findExtendedFamilies($this->settings['parentCategoryUid']));
    }

    /**
     * action listByCategory
     *
     * "Artensteckbriefe"
     *
     * @deprecated Solved by tabs in listAction
     *
     * @return void
     */
    public function listByCategoryAction()
    {
        $speciesList = $this->speciesRepository->findAll();

        $this->view->assign('speciesList', $speciesList);
        $this->view->assign('speciesCategories', $this->categoryRepository->findSubFamiliesOfExtendedFamilies($this->settings['parentCategoryUid']));
    }

    /**
     * action show
     *
     * @param \HGON\HgonSpecies\Domain\Model\Species $species
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("species")
     * @return void
     * @throws InvalidQueryException
     */
    public function showAction(\Hgon\HgonSpecies\Domain\Model\Species $species)
    {

        $this->view->assign('species', $species);

        // sidebar
        $this->view->assign('speciesList', $this->speciesRepository->findAllOrderByName());
        $this->view->assign('speciesCategories', $this->categoryRepository->findExtendedFamilies(intval($this->settings['parentCategoryUid'])));
    }

}
