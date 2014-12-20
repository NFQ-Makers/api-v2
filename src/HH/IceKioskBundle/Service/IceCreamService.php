<?php

namespace HH\IceKioskBundle\Service;

use Doctrine\ORM\EntityManager;
use HH\ApiBundle\Entity\EventsLog;
use HH\IceKioskBundle\Entity\IceCream;

class IceCreamService
{

    /** @var EntityManager */
    private $entityManager;

    /**
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->entityManager = $manager;
    }

    /**
     * @param EventsLog $request
     * @param string $type
     * @param string $device
     */
    public function processIceCream(EventsLog $request, $type, $device)
    {
        $data = $request->getData();

        $iceCreamEntity = new IceCream();
        switch ($type) {
            case "IceCream" :
                $this->IceCream($iceCreamEntity, $request, $data);
                break;
            default:
                return;
        }
        if (!preg_match("/(\d+)/", $device, $matches)) {
            return;
        }
        $deviceId = (int)$matches[1];
        $iceCreamEntity->setDeviceId($deviceId);

        $em = $this->entityManager;
        $em->persist($iceCreamEntity);
        $em->flush();
        // @todo: here can be dispatched user event, recalculate amount
        // @todo: dispatch mark as processed
//        /** @var EventsLogService $eventService */
//        $eventService = $this->get('api.events_log_service');
//        $eventService->markAsProcessed();
    }

// {"time":{"sec":1398619851,"usec":844563},"deviceId":"iceCream_1","type":"IceCream","data":{"userId":123,"amount":3}}
    /**
     * @param IceCream $iceCreamEntity
     * @param EventsLog $eventsLog
     * @param $data
     */
    public function IceCream(IceCream $iceCreamEntity, EventsLog $eventsLog, $data)
    {
        $timestamp = $eventsLog->getTimestamp();
        $iceCreamEntity->setTimestamp($timestamp);
        $iceCreamEntity->setAmount($data['amount'])
            ->setUserId($data['userId']);
    }
} 