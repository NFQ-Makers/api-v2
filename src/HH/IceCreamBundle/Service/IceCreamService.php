<?php

namespace HH\IceCreamBundle\Service;

use Doctrine\ORM\EntityManager;
use HH\IceCreamBundle\Entity\IceCream;
use Symfony\Component\HttpFoundation\Request;
use DateTime as DateTime;

class IceCreamService
{

    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $manager)
    {
        $this->entityManager = $manager;
    }

// {"time":{"sec":1398619851,"usec":844563},"deviceId":"iceCream_1","type":"IceCream","data":{"userId":123,"amount":3}}
    public function IceCream(IceCream $iceCreamEntity, $data)
    {
        // @todo: implement this, possible wrong ex.
        $iceCreamEntity->setAmount($data['amount'])
            ->setUserId($data['userId']);

    }

    /**
     * @param Request $request
     * @param string $type
     * @param string $device
     */
    public function processIceCream(Request $request, $type, $device)
    {
        $data = $request->get('data');

        date_default_timezone_set('Europe/Vilnius');
        $date = new DateTime();
        $time = $request->get('time');
        $timestamp = $date->setTimestamp($time['sec']);

        $iceCreamEntity = new IceCream();
        switch ($type) {
            case "IceCream" :
                $this->IceCream($iceCreamEntity, $data);
                break;
            default:
                return;
        }
        $iceCreamEntity->setTimestamp($timestamp);
        if (!preg_match("/(\d+)/", $device, $matches)) {
            return;
        }
        $deviceId = (int)$matches[1];
        $iceCreamEntity->setDeviceId($deviceId);

        $em = $this->entityManager;
        $em->persist($iceCreamEntity);
        $em->flush();
        // @todo: here can be dispatched user event, recalculate amount
    }
} 