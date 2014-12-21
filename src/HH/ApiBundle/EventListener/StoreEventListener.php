<?php
/**
 * Created by PhpStorm.
 * User: Nerijus
 * Date: 2014.12.21
 * Time: 03:36
 * Version: HH_1.0.1
 */

namespace HH\ApiBundle\EventListener;

use HH\ApiBundle\Event\DeviceRequest;

class StoreEventListener
{
    /** @var DeviceRequest */
    private $event;

    /**
     * @param DeviceRequest $event
     */
    public function setRequestEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return DeviceRequest
     */
    public function getRequestEvent()
    {
        return $this->event;
    }

}