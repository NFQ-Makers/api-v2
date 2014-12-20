<?php

namespace HH\IceKioskBundle\EventListener;

use HH\ApiBundle\Event\DeviceRequest;
use HH\ApiBundle\EventListener\ApiTerminateInterface;
use HH\IceKioskBundle\Service\IceCreamService;
use Symfony\Component\DependencyInjection\Container;

class IceKioskListener implements ApiTerminateInterface
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
        if ($device !== 'iceCream_1') {
            return;
        }
        $iceCreamService = $this->getIceCreamService();
        $type = $request->getType();
        $iceCreamService->processIceCream($request, $type, $device);
    }

    /**
     * @return IceCreamService
     */
    private function getIceCreamService()
    {
        /** @var IceCreamService $iceCreamService */
        $iceCreamService = $this->container->get('ice_kiosk.ice_cream_service');
        return $iceCreamService;
    }
}
