<?php

namespace HH\KickerTableBundle\EventListener;

use HH\ApiBundle\Event\DeviceMessageEvent;
use HH\ApiBundle\EventListener\DeviceMessageEventListenerInterface;
use HH\KickerTableBundle\Service\KickerTableService;

class KickerTableListener implements DeviceMessageEventListenerInterface
{
    /** @var KickerTableService */
    private $kickerTable;

    /**
     * @param KickerTableService $kickerTable
     */
    public function __construct(KickerTableService $kickerTable)
    {
        $this->kickerTable = $kickerTable;
    }

    /**
     * @param DeviceMessageEvent $event
     */
    public function processMessage(DeviceMessageEvent $event)
    {
        if ($event->getDeviceId() !== KickerTableService::DEVICE_ID) {
            return;
        }

        $this->kickerTable->processByType($event);
        $event->setProcessed();
    }

}
