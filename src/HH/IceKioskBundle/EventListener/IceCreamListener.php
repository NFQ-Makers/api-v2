<?php

namespace HH\IceKioskBundle\EventListener;

use HH\ApiBundle\Event\DeviceMessageEvent;
use HH\ApiBundle\EventListener\DeviceMessageEventListenerInterface;
use HH\IceKioskBundle\Service\IceKioskService;

class IceKioskListener implements DeviceMessageEventListenerInterface
{
    /**
     * @param DeviceMessageEvent $event
     */
    public function processMessage(DeviceMessageEvent $event)
    {
        if ($event->getDeviceId() !== IceKioskService::DEVICE_ID) {
            return;
        }
        $event->setProcessed();

//        $request = $event->getLog();
//        $device = $request->getDeviceId();
//        if ($device !== 'iceCream_1') {
//            return;
//        }
//        $iceCreamService = $this->getIceCreamService();
//        $type = $request->getType();
//        $iceCreamService->processIceCream($request, $type, $device);
    }
}
