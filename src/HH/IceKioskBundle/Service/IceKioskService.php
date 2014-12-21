<?php

namespace HH\IceKioskBundle\Service;

use Doctrine\ORM\EntityManager;
use HH\ApiBundle\Event\DeviceMessageEvent;
use HH\IceKioskBundle\Entity\IceCream;

class IceKioskService
{
    const DEVICE_ID = 'iceCream_1';

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
     * @param DeviceMessageEvent $request
     */
    public function processIceCream(DeviceMessageEvent $request)
    {
        $type = $request->getType();
        $device = $request->getDeviceId();
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
//        /** @var EventsLogService $eventService */
//        $eventService = $this->get('api.events_log_service');
//        $eventService->markAsProcessed();
    }

// {"time":{"sec":1398619851,"usec":844563},"deviceId":"iceCream_1","type":"IceCream","data":{"userId":123,"amount":3}}
    /**
     * @param IceCream $iceCreamEntity
     * @param DeviceMessageEvent $eventsLog
     * @param $data
     */
    public function IceCream(IceCream $iceCreamEntity, DeviceMessageEvent $eventsLog, $data)
    {
        $timestamp = $eventsLog->getDeviceTime();
        $iceCreamEntity->setTimestamp($timestamp);
        $iceCreamEntity->setAmount($data['amount'])
            ->setUserId($data['userId']);
    }
} 
