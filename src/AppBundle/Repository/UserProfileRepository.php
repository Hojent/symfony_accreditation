<?php

namespace AppBundle\Repository;
use AppBundle\Entity\User;

/**
 * UserProfileRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserProfileRepository extends \Doctrine\ORM\EntityRepository
{
    public function listAll ($admin) {
        $qb = $this->createQueryBuilder('up')
            ->where('up.id != :adid')
            ->setParameter('adid', $admin)
            ->orderBy('up.family', 'ASC')
            ->getQuery();
        return $qb;
    }
}
