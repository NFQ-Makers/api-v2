<?php

namespace HH\ApiBundle\Event;

use HH\ApiBundle\Entity\EventsLog;
use Symfony\Component\EventDispatcher\Event;

class DeviceRequest extends Event
{
    /** @var EventsLog */
    protected $log;

    /**
     * @param EventsLog $log
     */
    public function setLog(EventsLog $log)
    {
        $this->log = $log;
    }

    /**
     * @return EventsLog
     */
    public function getLog()
    {
        return $this->log;
    }

}
