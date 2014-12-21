<?php

namespace HH\ApiBundle\EventListener;

use HH\ApiBundle\Event\DeviceMessageEvent;

interface DeviceMessageEventListenerInterface
{
    /**
     * @param DeviceMessageEvent $event
     */
    public function processMessage(DeviceMessageEvent $event);
}
