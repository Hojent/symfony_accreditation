<?php

namespace AppBundle\Repository;

/**
 * UserProfileRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserProfileRepository extends \Doctrine\ORM\EntityRepository
{
    public function listAll () {
        $qb = $this->createQueryBuilder('up')
            ->orderBy('up.family', 'ASC')
            ->getQuery();

        return $qb;
    }
}
