<?php

namespace HH\KickerTableBundle\EventListener;

use HH\ApiBundle\Event\DeviceRequest;
use HH\ApiBundle\EventListener\ApiTerminateInterface;
use HH\KickerTableBundle\Service\SoccerMatchService;
use Symfony\Component\DependencyInjection\Container;

class SoccerMatchListener implements ApiTerminateInterface
{
    /** @var Container */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param DeviceRequest $event
     */
    public function onTerminate(DeviceRequest $event)
    {
        $request = $event->getLog();
        $device = $request->getDeviceId();
        if ($device !== 'table_1') {
            return;
        }
        $soccerMatchService = $this->getSoccerMatchService();
        $type = $request->getType();
        $soccerMatchService->processByType($request, $type, $device);
    }

    /**
     * @return SoccerMatchService
     */
    private function getSoccerMatchService()
    {
        /** @var SoccerMatchService $soccerMatchService */
        $soccerMatchService = $this->container->get('kicker_table.soccer_match_service');
        return $soccerMatchService;
    }
}
