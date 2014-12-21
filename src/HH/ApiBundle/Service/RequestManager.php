<?php

namespace HH\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use HH\ApiBundle\Entity\EventsLog;
use HH\ApiBundle\Event\DeviceRequest;
use HH\ApiBundle\Event\StoreEvent;
use HH\ApiBundle\Exceptions\RequestValidationException;
use HH\ApiBundle\Validators\RequestValidator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestManager
{
    /** @var EntityManager */
    private $entityManager;
    /** @var EventDispatcherInterface */
    protected $dispatcher;

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
        } catch (RequestValidationException $e) {
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
        $requestValidator = new RequestValidator();
        $requestValidator->validateTime($time);
        $requestValidator->validateDeviceId($deviceId);
        $requestValidator->validateType($type);
        $requestValidator->validateData($data);

        //@todo: set processed on kernel.terminate
        $eventEntity->setDeviceId($deviceId)
            ->setData($data)
            ->setDeviceTime($time['sec'])
            ->setProcessed(false)
            ->setType($type);
    }

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
}
