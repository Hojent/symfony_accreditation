<?php

namespace AppBundle\Repository;
use AppBundle\Entity\UserEvent;
use Doctrine\ORM\NonUniqueResultException;

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
        try {
            return $this->createQueryBuilder('ue')
                ->where('ue.userId = :userId AND ue.eventId = :eventId')
                ->setParameter('userId', $userId)
                ->setParameter('eventId', $eventId)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
        }
    }

    public function loadUser($userId)
    {
        return $this->createQueryBuilder('ue')
            ->where('ue.userId = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ;
    }

    public function loadEvent($eventId)
    {
        return $this->createQueryBuilder('ue')
            ->where('ue.eventId = :eventId')
            ->setParameter('eventId', $eventId)
            ->getQuery()
            ;
    }


}
