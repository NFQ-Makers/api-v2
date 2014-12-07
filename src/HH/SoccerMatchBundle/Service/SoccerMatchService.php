<?php

namespace HH\SoccerMatchBundle\Service;

use Doctrine\ORM\EntityManager;
use HH\ApiBundle\Entity\EventsLog;
use HH\SoccerMatchBundle\Entity\SoccerMatch;
use Symfony\Component\HttpFoundation\Request;

class SoccerMatchService
{

    /** @var EntityManager */
    private $entityManager;
    /** @var EventsLog */
    private $eventsLog;

    /**
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->entityManager = $manager;
    }

    /**
     * @param EventsLog $eventsLog
     */
    public function setEventsLog(EventsLog $eventsLog = null)
    {
        $this->eventsLog = $eventsLog;
    }

    /**
     * @param Request $request
     * @param string $type
     * @param string $device
     */
    public function processByType(Request $request, $type, $device)
    {
        $soccerEntity = new SoccerMatch();
        $time = $request->get('time');
        $data = $request->get('data');

        $soccerEntity->setDeviceId($device)
            ->setStartTime($time['sec']);
        switch ($type) {
            case "TableShake" :
                $this->TableShake($soccerEntity, $time);
                break;
            case "AutoGoal" :
                $this->AutoGoal($soccerEntity, $data);
                break;
            case "CardSwipe" :
                $this->CardSwipe($soccerEntity, $data);
                break;
            default:
                return;
        }
        $soccerEntity->setDeviceId($device)
            ->setStartTime($time['sec']);


        //@todo: for debugging set all
        $soccerEntity
            ->setLastShake(1)
            ->setStartTime(2)
            ->setStatus('a')
            ->setTeamId1(3)
            ->setTeamId2(4)
            ->setTeamResult1(5)
            ->setTeamResult2(6);
//        $soccerEntity->setDeviceId()
//            ->setLastShake()
//            ->setStartTime()
//            ->setStatus()
//            ->setTeamId1()
//            ->setTeamId2()
//            ->setTeamResult1()
//            ->setTeamResult2();

        $em = $this->entityManager;
        $em->persist($soccerEntity);
        $em->flush();
    }

    // {"time":{"sec":1398619851,"usec":844563},"deviceId":"table_1","type":"TableShake","data":{}},
    public function TableShake(SoccerMatch $soccerEntity, $time)
    {
        // @todo: implement this, possible wrong ex.
        $soccerEntity->setLastShake($time);
    }

    // {"time":{"sec":1398619851,"usec":846044},"deviceId":"table_1","type":"AutoGoal","data":{"team":1}},
    public function AutoGoal(SoccerMatch $soccerEntity, $data)
    {
        // @todo: implement this, possible wrong ex.
        if ($data['team'] == 1) {
            $soccerEntity->setTeamResult1(1);
            $soccerEntity->setTeamResult2(0);
        } else {
            $soccerEntity->setTeamResult1(0);
            $soccerEntity->setTeamResult2(1);
        }
    }

    // {"time":{"sec":1398619851,"usec":847409},"deviceId":"table_1","type":"CardSwipe","data":{"team":0,"player":1,"card_id":123456789}},
    public function CardSwipe(SoccerMatch $soccerEntity, $data)
    {
        // @todo: implement this
    }
} 