<?php

namespace HH\ApiBundle\EventListener;

use HH\ApiBundle\Event\DeviceMessageEvent;
use HH\ApiBundle\Service\MessageManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PostRequestTerminate
{
    /** @var MessageManager */
    protected $messageManager;
    /** @var EventDispatcherInterface */
    private $dispatcher;

    /**
     * Method will be executed after response will be send to user
     */
    public function onTerminate()
    {
        $deviceMessageEvent = $this->messageManager->getDeviceMessageEvent();

        $this->dispatcher->dispatch(DeviceMessageEvent::NEW_DEVICE_MESSAGE_EVENT, $deviceMessageEvent);
        if ($deviceMessageEvent->isProcessed()) {
            $this->messageManager->setProcessed();
        }
    }

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param MessageManager $messageManager
     */
    public function setMessageManager($messageManager)
    {
        $this->messageManager = $messageManager;
    }
}
