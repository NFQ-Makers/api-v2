<?php

namespace HH\ApiBundle\Event;

use Datetime as Datetime;
use Symfony\Component\EventDispatcher\Event;

class DeviceMessageEvent extends Event
{
    const NEW_DEVICE_MESSAGE_EVENT = 'api.new_device_message_appear';

    /** @var bool */
    private $processed = false;

    /** @var Datetime */
    private $deviceTime;

    /** @var string */
    private $deviceId;

    /** @var  string */
    private $type;

    /** @var array */
    private $data;

    /**
     * @return bool
     */
    public function isProcessed()
    {
        return $this->processed;
    }

    /**
     * Mark event as processed
     * @return $this
     */
    public function setProcessed()
    {
        $this->processed = true;
        return $this;
    }

    /**
     * @return Datetime
     */
    public function getDeviceTime()
    {
        return $this->deviceTime;
    }

    /**
     * @param Datetime $deviceTime
     *
     * @return $this
     */
    public function setDeviceTime(DateTime $deviceTime)
    {
        $this->deviceTime = $deviceTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * @param string $deviceId
     *
     * @return $this
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }
}
