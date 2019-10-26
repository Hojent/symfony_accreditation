<?php

namespace AppBundle\Repository;
use AppBundle\Entity\UserEvent;

/**
 * UserEventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserEventRepository extends \Doctrine\ORM\EntityRepository
{
    public function loadKeys($userId, $eventId)
    {
        return $this->createQueryBuilder('ue')
            ->where('ue.userId = :userId AND ue.eventId = :eventId')
            ->setParameter('userId', $userId)
            ->setParameter('eventId', $eventId)
            ->getQuery()
            ->getOneOrNullResult(); //Get exactly one result or null.
    }
}
