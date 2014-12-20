<?php

namespace HH\IceKioskBundle\EventListener;

use HH\ApiBundle\Entity\EventsLog;
use HH\ApiBundle\Service\EventsLogService;
use HH\IceKioskBundle\Service\IceCreamService;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class IceKioskListener
{
    /** @var Container */
    private $container;
    /** @var EventsLog */
    private $lastEvent;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        /** @var EventsLogService $event */
        $event = $this->container->get('api.events_log_service');
        $this->lastEvent = $event->getLastEvent();
    }

    /**
     * @param PostResponseEvent $event
     */
    public function onTerminate(PostResponseEvent $event)
    {
        /** @var Request $request */
        $request = $event->getLog();
        $device = $request->get('deviceId');
        if ($device !== 'iceCream_1') {
            return;
        }
        $IceCreamService = $this->getIceCreamService();
        $type = $request->get('type');
        $this->iceCreamService->processIceCream($request, $type, $device);
    }

    /**
     * @return IceCreamService
     */
    private function getIceCreamService()
    {
        $this->iceCreamService->setEventsLog($this->lastEvent);
        return $iceCreamService;
    }

    public function setIceCreamService($service){
        $this->iceCreamService = $service;

    }
}
