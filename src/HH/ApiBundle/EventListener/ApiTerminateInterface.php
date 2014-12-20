<?php

namespace HH\ApiBundle\EventListener;

use HH\ApiBundle\Event\DeviceRequest;

interface ApiTerminateInterface
{
    public function onTerminate(DeviceRequest $event);
}
