<?php

namespace HH\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use HH\ApiBundle\Entity\EventsLog;
use HH\ApiBundle\Event\DeviceRequest;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestManager
{
    /** @var EntityManager */
    private $entityManager;
    /** @var EventDispatcherInterface */
    protected $dispatcher;

    /**
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->entityManager = $manager;
    }

    public function processRequest(Request $request, $timestamp)
    {
        $time = $request->get('time');

        $deviceId = $request->get('deviceId');
        $type = $request->get('type');
        $data = $request->get('data');

        $event = new EventsLog();

        //@todo: set processed on kernel.terminate
        $event->setDeviceId($deviceId)
            ->setData($data)
            ->setDeviceTime($time['sec'])
            ->setProcessed(false)
            ->setTimestamp($timestamp)
            ->setType($type);

        $em = $this->entityManager;
        $em->persist($event);
        $em->flush();

        $realEvent = new DeviceRequest();
        $realEvent->setLog($event);
        $this->dispatcher->dispatch(KernelEvents::TERMINATE, $realEvent);

        return array("status" => "ok");
    }

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
}
