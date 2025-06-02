<?php
namespace HGON\HgonSpecies\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

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
 * The repository for Species
 */
class SpeciesRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Returns all objects of this repository.
     *
     * @return QueryResultInterface|array
     * @api
     */
    public function findAllOrderByName()
    {
        $query = $this->createQuery();

        $query->setOrderings(
            [
                'name' => QueryInterface::ORDER_ASCENDING
            ]
        );

        return $query->execute();
    }


    /**
     * Returns all objects of this repository.
     *
     * @return QueryResultInterface|array
     * @api
     */
    public function findAllOrderByNameScience()
    {
        $query = $this->createQuery();

        $query->setOrderings(
            [
                'family.parent.title' => QueryInterface::ORDER_ASCENDING,
                'nameScience' => QueryInterface::ORDER_ASCENDING
            ]
        );

        return $query->execute();
    }

}
