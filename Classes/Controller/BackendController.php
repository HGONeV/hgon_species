<?php

namespace HGON\HgonSpecies\Controller;

use Doctrine\Common\Util\Debug;
use HGON\HgonSpecies\Service\CsvImportService;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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
class BackendController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{


    /**
     * backendUserRepository
     *
     * @var \RKW\RkwEvents\Domain\Repository\BackendUserRepository
     * @inject
     */
    protected $backendUserRepository = null;


    /**
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function indexAction()
    {

        // show import form

    }



    /**
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function importAction()
    {
        if (
            $this->request->hasArgument('importData')
            && $this->request->hasArgument('speciesType')
            && $this->request->hasArgument('targetPid')
        ) {
            $targetPid = $this->request->getArgument('targetPid');
            $speciesType = $this->request->getArgument('speciesType');
            $import = $this->request->getArgument('importData');
            $csvFile = $import['csvFile'];

            if (is_uploaded_file($csvFile['tmp_name'])) {
                $csvImportService = GeneralUtility::makeInstance(CsvImportService::class);
                $result = $csvImportService->importFromCsv($csvFile, $speciesType, $targetPid);

                $this->addFlashMessage($result);
            }
        }

        $this->forward('index', 'Backend');
    }




}