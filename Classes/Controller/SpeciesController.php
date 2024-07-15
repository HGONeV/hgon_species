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
     * speciesRepository
     *
     * @var \HGON\HgonSpecies\Domain\Repository\SpeciesRepository
     * @inject
     */
    protected $speciesRepository = null;

    /**
     * categoryRepository
     *
     * @var \HGON\HgonSpecies\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository = null;

    /**
     * action list
     *
     * "Artenliste"
     *
     * @return void
     */
    public function listAction()
    {
        $speciesList = $this->speciesRepository->findAllOrderByName();

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
     * @return void
     * @throws InvalidQueryException
     */
    public function showAction(\Hgon\HgonSpecies\Domain\Model\Species $species)
    {

        $this->view->assign('species', $species);

        // sidebar
        $this->view->assign('speciesList', $this->speciesRepository->findAll());
        $this->view->assign('speciesCategories', $this->categoryRepository->findSubFamiliesOfExtendedFamilies(intval($this->settings['parentCategoryUid'])));
    }

}
