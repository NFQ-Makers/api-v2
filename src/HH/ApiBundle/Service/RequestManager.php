<?php

namespace HH\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use HH\ApiBundle\Entity\EventsLog;
use HH\ApiBundle\Event\DeviceRequest;
use HH\ApiBundle\Event\StoreEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\Exception\ValidatorException;

class RequestManager
{
    /** @var EntityManager */
    private $entityManager;
    /** @var EventDispatcherInterface */
    protected $dispatcher;
    const REQUEST_TYPE_TABLE_SHAKE = 'TableShake';
    const REQUEST_TYPE_AUTO_GOAL = 'AutoGoal';
    const REQUEST_TYPE_CARD_SWIPE = 'CardSwipe';
    const REQUEST_TYPE_ICE_CREAM = 'IceCream';

    /**
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->entityManager = $manager;
    }

    /**
     * @param Request $request
     * @param $timestamp
     * @return array
     */
    public function processRequest(Request $request, $timestamp)
    {
        $eventEntity = new EventsLog();
        $eventEntity->setTimestamp($timestamp);
        try {
            $this->parseFromRequest($request, $eventEntity);
        } catch (\Exception $e) {
            return array("status" => "fail");
        }

        $em = $this->entityManager;
        $em->persist($eventEntity);
        $em->flush();

        $deviceRequestEvent = new DeviceRequest();
        $deviceRequestEvent->setLog($eventEntity);
        $this->dispatcher->dispatch(StoreEvent::SET_STORE_REQUEST_EVENT, $deviceRequestEvent);

        return array("status" => "ok");
    }

    /**
     * @param Request $request
     * @param EventsLog $eventEntity
     */
    private function parseFromRequest(Request $request, EventsLog $eventEntity)
    {
        $time = $request->get('time');
        $deviceId = $request->get('deviceId');
        $type = $request->get('type');
        $data = $request->get('data');
        $this->validateTime($time);
        $this->validateDeviceId($deviceId);
        $this->validateType($type);
        $this->validateData($data);

        //@todo: set processed on kernel.terminate
        $eventEntity->setDeviceId($deviceId)
            ->setData($data)
            ->setDeviceTime($time['sec'])
            ->setProcessed(false)
            ->setType($type);
    }

    /**
     * @param array $time
     * @return bool
     * @todo: move to validator
     */
    private function validateTime(array $time)
    {
        if (!isset($time)) {
            throw new ValidatorException();
        }
        if (!isset($time['sec']) || !isset($time['usec'])) {
            throw new ValidatorException();
        }
        return true;
    }

    /**
     * @param $deviceId
     * @return bool
     * @todo: move to validator
     */
    private function validateDeviceId($deviceId)
    {
        if (!isset($deviceId)) {
            throw new ValidatorException();
        }
        if (strlen($deviceId) <= 0) {
            throw new ValidatorException();
        }
        return true;
    }

    /**
     * @param $type
     * @return bool
     * @todo: move to validator
     */
    private function validateType($type)
    {
        if (!isset($type)) {
            throw new ValidatorException();
        }
        if (strlen($type) <= 0) {
            throw new ValidatorException();
        }
        $types = array(
            self::REQUEST_TYPE_TABLE_SHAKE,
            self::REQUEST_TYPE_AUTO_GOAL,
            self::REQUEST_TYPE_CARD_SWIPE,
            self::REQUEST_TYPE_ICE_CREAM,
        );
        if (!in_array($type, $types)) {
            throw new ValidatorException();
        }
        return true;
    }

    /**
     * @param $data
     * @todo: move to validator
     */
    private function validateData($data)
    {
    }

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
}
