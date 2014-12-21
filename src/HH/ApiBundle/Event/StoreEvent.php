<?php
/**
 * Created by PhpStorm.
 * User: Nerijus
 * Date: 2014.12.21
 * Time: 03:36
 * Version: HH_1.0.1
 */

namespace HH\ApiBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class StoreEvent extends Event
{
    const STORE_REQUEST_EVENT = 'api.store_request_event';
}