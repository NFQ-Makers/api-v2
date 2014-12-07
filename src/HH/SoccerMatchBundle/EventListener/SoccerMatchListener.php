<?php

namespace HH\SoccerMatchBundle\EventListener;

use HH\ApiBundle\Entity\EventsLog;
use HH\ApiBundle\Service\EventsLogService;
use HH\SoccerMatchBundle\Service\SoccerMatchService;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class SoccerMatchListener
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
        if ($device !== 'table_1') {
            return;
        }
        $soccerMatchService = $this->getSoccerMatchService();
        $type = $request->get('type');
        $soccerMatchService->processByType($request, $type, $device);
    }

    /**
     * @return SoccerMatchService
     */
    private function getSoccerMatchService()
    {
        /** @var SoccerMatchService $soccerMatchService */
        $soccerMatchService = $this->container->get('hh_soccer_match.soccer_match_service');
        $soccerMatchService->setEventsLog($this->lastEvent);
        return $soccerMatchService;
    }
}
