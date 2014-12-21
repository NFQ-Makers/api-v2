<?php

namespace HH\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use HH\ApiBundle\Entity\EventsLog;
use HH\ApiBundle\Event\DeviceMessageEvent;
use HH\ApiBundle\Event\DeviceRequest;
use HH\ApiBundle\Event\StoreEvent;
use HH\ApiBundle\Exceptions\RequestValidationException;
use HH\ApiBundle\Validators\RequestValidator;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

class MessageManager
{
    /** @var EventsLog */
    protected $message;

    /** @var ManagerRegistry */
    protected $managerRegistry;

    /** @var EntityManager */
    private $entityManager;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param Request $request
     * @param $timestamp
     * @return array
     */
    public function processRequest(Request $request, $timestamp)
    {
        $this->message = new EventsLog();
        try {
            $this->parseFromRequest($request);
        } catch (RequestValidationException $e) {
            return array("status" => "fail");
        }

        $this->message->setTimestamp($timestamp);
        $this->saveMessage();

        return array("status" => "ok");
    }

    public function saveMessage()
    {
        $this->initEntityManager();
        $this->entityManager->persist($this->message);
        $this->entityManager->flush();
    }

    /**
     * @return DeviceMessageEvent
     */
    public function getDeviceMessageEvent()
    {
        $event = new DeviceMessageEvent();
        $event->setDeviceTime($this->message->getDeviceTime())
            ->setDeviceId($this->message->getDeviceId())
            ->setType($this->message->getType())
            ->setData($this->message->getData());

        return $event;
    }

    /**
     * @return EntityManager
     */
    protected function initEntityManager()
    {
        if ($this->entityManager === null) {
            $this->entityManager = $this->managerRegistry->getManagerForClass(get_class($this->message));
        }
    }

    /**
     * @param Request $request
     */
    private function parseFromRequest(Request $request)
    {
        $time = $request->get('time');
        $deviceId = $request->get('deviceId');
        $type = $request->get('type');
        $data = $request->get('data');

        $requestValidator = new RequestValidator();
        $requestValidator->validateTime($time);
        $requestValidator->validateDeviceId($deviceId);
        $requestValidator->validateType($type);
        $requestValidator->validateData($data);

        //@todo: set processed on kernel.terminate
        $this->message->setDeviceId($deviceId)
            ->setData($data)
            ->setDeviceTime($time['sec'])
            ->setProcessed(false)
            ->setType($type);
    }

    public function setProcessed()
    {
        $this->initEntityManager();
        $this->message->setProcessed(true);

        $this->entityManager->persist($this->message);
        $this->entityManager->flush();
    }
}
