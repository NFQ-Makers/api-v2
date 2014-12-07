<?php

namespace HH\IceCreamBundle\EventListener;

use HH\ApiBundle\Entity\EventsLog;
use HH\ApiBundle\Service\EventsLogService;
use HH\IceCreamBundle\Service\IceCreamService;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class IceCreamListener
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
        $request = $event->getRequest();
        $device = $request->get('deviceId');
        if ($device !== 'iceCream_1') {
            return;
        }
        $IceCreamService = $this->getIceCreamService();
        $type = $request->get('type');
        $IceCreamService->processIceCream($request, $type, $device);
    }

    /**
     * @return IceCreamService
     */
    private function getIceCreamService()
    {
        /** @var IceCreamService $iceCreamService */
        $iceCreamService = $this->container->get('hh_ice_cream.ice_cream_service');
        $iceCreamService->setEventsLog($this->lastEvent);
        return $iceCreamService;
    }
}
