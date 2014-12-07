<?php

namespace HH\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use HH\ApiBundle\Entity\EventsLog;

class EventsLogService
{
    /** @var EntityManager */
    private $entityManager;
    /** @var EventsLog */
    private $lastEvent;

    /**
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->entityManager = $manager;
    }

    /**
     * @param EventsLog $lastEvent
     */
    public function setLastEvent(EventsLog $lastEvent)
    {
        $this->lastEvent = $lastEvent;
    }

    /**
     * @return EventsLog
     */
    public function getLastEvent()
    {
        return $this->lastEvent;
    }

    public function markAsProcessed()
    {
        $this->lastEvent->setProcessed(true);
        $em = $this->entityManager;
        $em->persist($this->lastEvent);
        $em->flush();
    }
}
