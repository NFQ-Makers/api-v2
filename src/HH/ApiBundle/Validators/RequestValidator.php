<?php
/**
 * Created by PhpStorm.
 * User: Nerijus
 * Date: 2014.12.21
 * Time: 13:57
 * Version: HH_1.0.1
 */

namespace HH\ApiBundle\Validators;

use HH\ApiBundle\Exceptions\RequestValidationException;

/**
 * Class RequestValidator
 * @package HH\ApiBundle\Validators
 */
class RequestValidator
{
    const REQUEST_TYPE_TABLE_SHAKE = 'TableShake';
    const REQUEST_TYPE_AUTO_GOAL = 'AutoGoal';
    const REQUEST_TYPE_CARD_SWIPE = 'CardSwipe';
    const REQUEST_TYPE_ICE_CREAM = 'IceCream';

    /**
     * @param array $time
     * @return bool
     * @throws RequestValidationException
     */
    public function validateTime(array $time)
    {
        if (!isset($time)) {
            throw new RequestValidationException('', RequestValidationException::ERROR_DATE);
        }
        if (!isset($time['sec']) || !isset($time['usec'])) {
            throw new RequestValidationException('Doesn\'t exist sec or usec', RequestValidationException::ERROR_DATE);
        }
        return true;
    }

    /**
     * @param $deviceId
     * @return bool
     * @throws RequestValidationException
     */
    public function validateDeviceId($deviceId)
    {
        if (!isset($deviceId)) {
            throw new RequestValidationException('', RequestValidationException::ERROR_DEVICE_ID);
        }
        if (strlen($deviceId) <= 0) {
            throw new RequestValidationException('Empty string', RequestValidationException::ERROR_DEVICE_ID);
        }
        return true;
    }

    /**
     * @param $type
     * @return bool
     * @throws RequestValidationException
     */
    public function validateType($type)
    {
        if (!isset($type)) {
            throw new RequestValidationException('', RequestValidationException::ERROR_REQUEST_TYPE);
        }
        if (strlen($type) <= 0) {
            throw new RequestValidationException('Empty string', RequestValidationException::ERROR_REQUEST_TYPE);
        }
        $types = array(
            self::REQUEST_TYPE_TABLE_SHAKE,
            self::REQUEST_TYPE_AUTO_GOAL,
            self::REQUEST_TYPE_CARD_SWIPE,
            self::REQUEST_TYPE_ICE_CREAM,
        );
        if (!in_array($type, $types)) {
            throw new RequestValidationException('Not defined type', RequestValidationException::ERROR_REQUEST_TYPE);
        }
        return true;
    }

    /**
     * @param $data
     * @return bool
     * @throws RequestValidationException
     */
    public function validateData($data)
    {
        if (!is_array($data)) {
            throw new RequestValidationException('', RequestValidationException::ERROR_DATA);
        }
        return true;
    }
} 