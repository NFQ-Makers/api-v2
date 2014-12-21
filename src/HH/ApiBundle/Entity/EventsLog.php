<?php

namespace HH\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventsLog
 *
 * @ORM\Table(name="events_log")
 * @ORM\Entity
 */
class EventsLog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="deviceId", type="string", length=255, nullable=false)
     */
    private $deviceid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=16, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="deviceTime", type="string", length=10, nullable=false)
     */
    private $devicetime;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text", nullable=false)
     */
    private $data;

    /**
     * @var boolean
     *
     * @ORM\Column(name="processed", type="boolean", nullable=false)
     */
    private $processed;


    /**
     * Set deviceid
     *
     * @param string $deviceid
     * @return EventsLog
     */
    public function setDeviceId($deviceid)
    {
        $this->deviceid = $deviceid;

        return $this;
    }

    /**
     * Get deviceid
     *
     * @return string
     */
    public function getDeviceId()
    {
        return $this->deviceid;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return EventsLog
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return EventsLog
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set devicetime
     *
     * @param string $devicetime
     * @return EventsLog
     */
    public function setDeviceTime($devicetime)
    {
        $this->devicetime = $devicetime;

        return $this;
    }

    /**
     * Get devicetime
     *
     * @return string
     */
    public function getDeviceTime()
    {
        return $this->devicetime;
    }

    /**
     * Set data
     *
     * @param string $data
     * @return EventsLog
     */
    public function setData($data)
    {
        $this->data = json_encode($data);

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return json_decode($this->data, true);
    }

    /**
     * Set processed
     *
     * @param boolean $processed
     * @return EventsLog
     */
    public function setProcessed($processed)
    {
        $this->processed = (bool)$processed;

        return $this;
    }

    /**
     * Get processed
     *
     * @return boolean
     */
    public function getProcessed()
    {
        return $this->processed;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
