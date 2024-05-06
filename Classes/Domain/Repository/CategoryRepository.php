<?php

namespace HGON\HgonSpecies\Domain\Repository;
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class CategoryRepository
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CategoryRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * initializeObject
     *
     * @return void
     */
    public function initializeObject()
    {

        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');

        // don't add the pid constraint
        $querySettings->setRespectStoragePage(false);

        $this->setDefaultQuerySettings($querySettings);
    }


    /**
     * Returns all categories of a given parent category
     *
     * @param int $category
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findSubFamiliesOfExtendedFamilies($category = 0)
    {
        $query = $this->createQuery();

        // get extended families
        $query->matching($query->equals('parent', $category));
        $extendedFamilyResult = $query->execute();

        // now get standard families
        $extendedFamilyUidList = [];
        foreach ($extendedFamilyResult as $extendedFamilyResultRow) {
            $extendedFamilyUidList[] = $extendedFamilyResultRow->getUid();
        }

        $query->matching($query->in('parent', $extendedFamilyUidList));

        return $query->execute();
        //===
    }
}
