<?php
/**
 * Created by PhpStorm.
 * User: Nerijus
 * Date: 2014.12.21
 * Time: 11:58
 * Version: HH_1.0.1
 */

namespace HH\ApiBundle\EventListener;

use HH\ApiBundle\Event\DeviceRequest;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StoreEventSubscriber implements EventSubscriberInterface
{
    /** @var DeviceRequest */
    private $event;

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            'api.get_request_event' => 'getRequestEvent',
        );
    }
    /**
     * @param DeviceRequest $event
     */
    public function setRequestEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return DeviceRequest
     */
    public function getRequestEvent()
    {
        return $this->event;
    }
}