<?php

namespace HH\IceKioskBundle\EventListener;

use HH\ApiBundle\Event\DeviceMessageEvent;
use HH\ApiBundle\EventListener\DeviceMessageEventListenerInterface;
use HH\IceKioskBundle\Service\IceKioskService;

class IceKioskListener implements DeviceMessageEventListenerInterface
{
    /** @var IceKioskService */
    private $iceKioskService;

    /**
     * @param IceKioskService $iceKioskService
     */
    public function __construct(IceKioskService $iceKioskService)
    {
        $this->iceKioskService = $iceKioskService;
    }

    /**
     * @param DeviceMessageEvent $event
     */
    public function processMessage(DeviceMessageEvent $event)
    {
        if ($event->getDeviceId() !== IceKioskService::DEVICE_ID) {
            return;
        }

        $this->iceKioskService->processIceCream($event);
        $event->setProcessed();
    }

}
