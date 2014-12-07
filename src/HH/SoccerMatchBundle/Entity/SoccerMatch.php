<?php

namespace HH\SoccerMatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SoccerMatch
 *
 * @ORM\Table(name="soccer_match")
 * @ORM\Entity
 */
class SoccerMatch
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
     * @var integer
     *
     * @ORM\Column(name="teamId1", type="integer", nullable=false)
     */
    private $teamid1;

    /**
     * @var integer
     *
     * @ORM\Column(name="teamId2", type="integer", nullable=false)
     */
    private $teamid2;

    /**
     * @var integer
     *
     * @ORM\Column(name="teamResult1", type="integer", nullable=false)
     */
    private $teamresult1;

    /**
     * @var integer
     *
     * @ORM\Column(name="teamResult2", type="integer", nullable=false)
     */
    private $teamresult2;

    /**
     * @var integer
     *
     * @ORM\Column(name="startTime", type="integer", nullable=false)
     */
    private $starttime;

    /**
     * @var integer
     *
     * @ORM\Column(name="lastShake", type="integer", nullable=false)
     */
    private $lastshake;

    /**
     * @var string
     *
     * @ORM\Column(name="deviceId", type="string", length=255, nullable=false)
     */
    private $deviceid;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    private $status;


    /**
     * Set teamid1
     *
     * @param integer $teamid1
     * @return SoccerMatch
     */
    public function setTeamId1($teamid1)
    {
        $this->teamid1 = $teamid1;

        return $this;
    }

    /**
     * Get teamid1
     *
     * @return integer
     */
    public function getTeamId1()
    {
        return $this->teamid1;
    }

    /**
     * Set teamid2
     *
     * @param integer $teamid2
     * @return SoccerMatch
     */
    public function setTeamId2($teamid2)
    {
        $this->teamid2 = $teamid2;

        return $this;
    }

    /**
     * Get teamid2
     *
     * @return integer
     */
    public function getTeamId2()
    {
        return $this->teamid2;
    }

    /**
     * Set teamresult1
     *
     * @param integer $teamresult1
     * @return SoccerMatch
     */
    public function setTeamResult1($teamresult1)
    {
        $this->teamresult1 = $teamresult1;

        return $this;
    }

    /**
     * Get teamresult1
     *
     * @return integer
     */
    public function getTeamResult1()
    {
        return $this->teamresult1;
    }

    /**
     * Set teamresult2
     *
     * @param integer $teamresult2
     * @return SoccerMatch
     */
    public function setTeamResult2($teamresult2)
    {
        $this->teamresult2 = $teamresult2;

        return $this;
    }

    /**
     * Get teamresult2
     *
     * @return integer
     */
    public function getTeamResult2()
    {
        return $this->teamresult2;
    }

    /**
     * Set starttime
     *
     * @param integer $starttime
     * @return SoccerMatch
     */
    public function setStartTime($starttime)
    {
        $this->starttime = $starttime;

        return $this;
    }

    /**
     * Get starttime
     *
     * @return integer
     */
    public function getStartTime()
    {
        return $this->starttime;
    }

    /**
     * Set lastshake
     *
     * @param integer $lastshake
     * @return SoccerMatch
     */
    public function setLastShake($lastshake)
    {
        $this->lastshake = $lastshake;

        return $this;
    }

    /**
     * Get lastshake
     *
     * @return integer
     */
    public function getLastShake()
    {
        return $this->lastshake;
    }

    /**
     * Set deviceid
     *
     * @param string $deviceid
     * @return SoccerMatch
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
     * Set status
     *
     * @param string $status
     * @return SoccerMatch
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
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
