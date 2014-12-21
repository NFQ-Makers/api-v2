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
    const SET_STORE_REQUEST_EVENT = 'api.set_store_request_event';
    const GET_STORE_REQUEST_EVENT = 'api.get_store_request_event';
}