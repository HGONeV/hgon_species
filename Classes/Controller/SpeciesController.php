<?php
namespace HGON\HgonSpecies\Controller;

use HGON\HgonDonation\Domain\Model\Project;
use HGON\HgonDonation\Service\ProjectLinkService;
use HGON\HgonSpecies\Domain\Model\SpeciesBird;
use HGON\HgonSpecies\PageTitle\SpeciesTitleProvider;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;

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
    protected \HGON\HgonSpecies\Domain\Repository\SpeciesRepository $speciesRepository;

    protected \HGON\HgonSpecies\Domain\Repository\CategoryRepository $categoryRepository;

    protected ProjectLinkService $projectLinkService;

    public function __construct(
        ?\HGON\HgonSpecies\Domain\Repository\SpeciesRepository $speciesRepository = null,
        ?\HGON\HgonSpecies\Domain\Repository\CategoryRepository $categoryRepository = null,
        ?ProjectLinkService $projectLinkService = null
    ) {
        $this->speciesRepository = $speciesRepository ?? \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\HGON\HgonSpecies\Domain\Repository\SpeciesRepository::class);
        $this->categoryRepository = $categoryRepository ?? \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\HGON\HgonSpecies\Domain\Repository\CategoryRepository::class);
        $this->projectLinkService = $projectLinkService ?? GeneralUtility::makeInstance(ProjectLinkService::class);
    }

    public function injectSpeciesRepository(\HGON\HgonSpecies\Domain\Repository\SpeciesRepository $speciesRepository): void
    {
        $this->speciesRepository = $speciesRepository;
    }

    public function injectCategoryRepository(\HGON\HgonSpecies\Domain\Repository\CategoryRepository $categoryRepository): void
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * action list
     *
     * "Artenliste"
     *
     * @return \Psr\Http\Message\ResponseInterface
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

        return $this->htmlResponse();
    }

    /**
     * action listByCategory
     *
     * "Artensteckbriefe"
     *
     * @deprecated Solved by tabs in listAction
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listByCategoryAction()
    {
        $speciesList = $this->speciesRepository->findAll();

        $this->view->assign('speciesList', $speciesList);
        $this->view->assign('speciesCategories', $this->categoryRepository->findSubFamiliesOfExtendedFamilies($this->settings['parentCategoryUid']));

        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \HGON\HgonSpecies\Domain\Model\Species $species
     * @return \Psr\Http\Message\ResponseInterface
     * @throws InvalidQueryException
     */
    #[IgnoreValidation(['argumentName' => 'species'])]
    public function showAction(\HGON\HgonSpecies\Domain\Model\Species $species)
    {
        $name = trim((string)$species->getName());
        $scientificName = trim((string)$species->getNameScience());
        $pageTitleParts = $species->getRecordType() === 'bird'
            ? [$name, $scientificName]
            : [$scientificName, $name];
        $pageTitle = implode(' – ', array_filter($pageTitleParts));

        if ($pageTitle !== '') {
            GeneralUtility::makeInstance(SpeciesTitleProvider::class)->setTitle($pageTitle);
        }

        $this->view->assign('species', $species);

        $donationProject = $species->getDonationProject();
        if (!$donationProject instanceof Project && $species instanceof SpeciesBird) {
            $donationProject = $this->createGeneralDonationProject();
        }

        if ($donationProject instanceof Project) {
            $donationUrl = $this->projectLinkService->buildPayPalDonateUrl(
                $donationProject,
                $this->getPaymentSettings()
            );
            if ($donationUrl !== '') {
                $this->view->assignMultiple([
                    'donationProject' => $donationProject,
                    'donationUrl' => $donationUrl,
                    'donationButtonText' => $this->projectLinkService->getButtonText($donationProject),
                ]);
            }
        }

        // sidebar
        $this->view->assign('speciesList', $this->speciesRepository->findAllOrderByName());
        $this->view->assign('speciesCategories', $this->categoryRepository->findExtendedFamilies(intval($this->settings['parentCategoryUid'])));

        return $this->htmlResponse();
    }

    private function getPaymentSettings(): array
    {
        $settings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'HgonPayment'
        );

        return is_array($settings) ? $settings : [];
    }

    private function createGeneralDonationProject(): Project
    {
        $project = new Project();
        $project->setTitle('Allgemeine Spende');
        $project->setProjectCode('allgemein');

        return $project;
    }

}
