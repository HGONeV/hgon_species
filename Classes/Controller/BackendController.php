<?php

namespace HGON\HgonSpecies\Controller;

use HGON\HgonSpecies\Service\CsvExportService;
use HGON\HgonSpecies\Service\CsvImportService;
use HGON\HgonSpecies\Service\SpeciesStorageService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Beuser\Domain\Repository\BackendUserRepository;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;

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
        $this->view->assign(
            'storageOptions',
            GeneralUtility::makeInstance(SpeciesStorageService::class)->getSelectOptions()
        );

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
            && $this->request->hasArgument('storageSelection')
        ) {
            try {
                $selection = GeneralUtility::makeInstance(SpeciesStorageService::class)
                    ->resolveSelection((string)$this->request->getArgument('storageSelection'));
            } catch (\Throwable $exception) {
                $this->addFlashMessage(
                    'Import abgebrochen: ' . $exception->getMessage(),
                    '',
                    ContextualFeedbackSeverity::ERROR
                );
                return new ForwardResponse('index', 'Backend');
            }
            $import = $this->request->getArgument('importData');
            $csvFile = $import['csvFile'];

            if (is_uploaded_file($csvFile['tmp_name'])) {
                $csvImportService = GeneralUtility::makeInstance(CsvImportService::class);
                $result = $csvImportService->importFromCsv(
                    $csvFile,
                    $selection['speciesType'],
                    $selection['targetPid']
                );

                $this->addFlashMessage($result);
            }
        }

        return new ForwardResponse(
            'index',
            'Backend'
        );
    }

    public function exportAction(): ResponseInterface
    {
        if (!$this->request->hasArgument('storageSelection')) {
            $this->addFlashMessage('Bitte einen Datenbestand auswählen.');
            return new ForwardResponse('index', 'Backend');
        }

        try {
            $selection = GeneralUtility::makeInstance(SpeciesStorageService::class)
                ->resolveSelection((string)$this->request->getArgument('storageSelection'));
            $csvContent = GeneralUtility::makeInstance(CsvExportService::class)
                ->exportToCsv($selection['speciesType'], $selection['targetPid']);
        } catch (\Throwable $exception) {
            $this->addFlashMessage(
                'Export abgebrochen: ' . $exception->getMessage(),
                '',
                ContextualFeedbackSeverity::ERROR
            );
            return new ForwardResponse('index', 'Backend');
        }

        $typeLabel = $selection['speciesType'] === 'bird' ? 'voegel' : 'libellen';
        $fileName = sprintf(
            'arten-%s-pid-%d-%s.csv',
            $typeLabel,
            $selection['targetPid'],
            date('Y-m-d')
        );
        $response = $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'text/csv; charset=utf-8')
            ->withHeader('Content-Disposition', sprintf('attachment; filename="%s"', $fileName))
            ->withHeader('Cache-Control', 'no-store');
        $response->getBody()->write($csvContent);

        return $response;
    }




}
