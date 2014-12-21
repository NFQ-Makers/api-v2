<?php

namespace HH\ApiBundle\EventListener;

use HH\ApiBundle\Event\DeviceRequest;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class PostRequestTerminate
{
    /** @var EventDispatcherInterface */
    private $dispatcher;

    /**
     * @param PostResponseEvent $postResponseEvent
     */
    public function onTerminate(PostResponseEvent $postResponseEvent)
    {
        $event = $this->getSavedRequestEvent();
        $this->publishApiTerminate($event);
    }

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return DeviceRequest
     */
    private function getSavedRequestEvent()
    {
        return $this->dispatcher->dispatch('api.get_request_event');
    }

    /**
     * @param $event
     */
    private function publishApiTerminate($event)
    {
        $this->dispatcher->dispatch('api.post_request_terminate', $event);
    }

}
