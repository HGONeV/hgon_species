<?php
namespace HGON\HgonSpecies\Controller;

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
     * action list
     *
     * "Artenliste"
     *
     * @return void
     */
    public function listAction()
    {
        $speciesList = $this->speciesRepository->findAll();

        $this->view->assign('speciesList', $speciesList);
    }

    /**
     * action list
     *
     * "Artensteckbriefe"
     *
     * @return void
     */
    public function profileAction()
    {
        $speciesList = $this->speciesRepository->findAll();

        $this->view->assign('speciesList', $speciesList);
    }

    /**
     * action show
     *
     * @param \HGON\HgonSpecies\Domain\Model\Species $species
     * @return void
     */
    public function showAction(\Hgon\HgonSpecies\Domain\Model\Species $species)
    {
        $this->view->assign('species', $species);
    }

}
