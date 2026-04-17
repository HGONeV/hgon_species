<?php

namespace HGON\HgonSpecies\Controller;

use Doctrine\Common\Util\Debug;
use HGON\HgonSpecies\Service\CsvImportService;
use TYPO3\CMS\Beuser\Domain\Repository\BackendUserRepository;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
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
     * @var \TYPO3\CMS\Beuser\Domain\Repository\BackendUserRepository
     */
    protected BackendUserRepository $backendUserRepository;

    public function __construct(?BackendUserRepository $backendUserRepository = null)
    {
        $this->backendUserRepository = $backendUserRepository ?? GeneralUtility::makeInstance(BackendUserRepository::class);
    }

    public function injectBackendUserRepository(BackendUserRepository $backendUserRepository): void
    {
        $this->backendUserRepository = $backendUserRepository;
    }


    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function indexAction()
    {

        // show import form

        return $this->htmlResponse();
    }



    /**
     * @return ForwardResponse
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

        return new ForwardResponse(
            'index',
            'Backend'
        );
    }




}
