<?php

namespace HH\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use HH\ApiBundle\Entity\EventsLog;
use HH\ApiBundle\Event\DeviceMessageEvent;
use HH\ApiBundle\Exceptions\RequestValidationException;
use HH\ApiBundle\Validators\RequestValidator;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

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
     * @param ParameterBag $request
     * @param $timestamp
     * @return array
     */
    public function processRequest(ParameterBag $request, $timestamp)
    {
        $this->message = new EventsLog();
        try {
            $this->parseFromRequest($request);
        } catch (RequestValidationException $exception) {
            // @todo: log error
            $msg = $exception->resolveRequestError($exception->getCode());
            return array("status" => "error", "message" => "invalid data");
        }

        $this->message->setTimestamp($timestamp);
        $this->saveMessage();

        return array("status" => "ok");
    }

    /**
     * @param ParameterBag $request
     */
    private function parseFromRequest(ParameterBag $request)
    {
        $time = $request->get('time');
        $deviceId = $request->get('deviceId');
        $type = $request->get('type');
        $data = $request->get('data', array());

        $requestValidator = new RequestValidator();
        $requestValidator->validateTime($time);
        $requestValidator->validateDeviceId($deviceId);
        $requestValidator->validateType($type);
        $requestValidator->validateData($data);

        $this->message->setDeviceId($deviceId)
            ->setData($data)
            ->setDeviceTime($time['sec'])
            ->setProcessed(false)
            ->setType($type);
    }

    public function saveMessage()
    {
        $this->initEntityManager();
        $this->entityManager->persist($this->message);
        $this->entityManager->flush();
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
     * @return DeviceMessageEvent
     */
    public function getDeviceMessageEvent()
    {
        $event = new DeviceMessageEvent();
        $event->setDeviceTime($this->message->getTimestamp())
            ->setDeviceId($this->message->getDeviceId())
            ->setType($this->message->getType())
            ->setData($this->message->getData());

        return $event;
    }

    public function setProcessed()
    {
        $this->initEntityManager();
        $this->message->setProcessed(true);

        $this->entityManager->persist($this->message);
        $this->entityManager->flush();
    }
}
