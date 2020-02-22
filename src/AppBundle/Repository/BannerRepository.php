<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * RegionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BannerRepository extends EntityRepository
{

    public function listAll () {
        $qb = $this->createQueryBuilder('b')
            ->orderBy('b.title', 'ASC')
            ->getQuery();

        return $qb;
    }

}
