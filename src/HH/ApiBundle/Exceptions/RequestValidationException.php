<?php
/**
 * Created by PhpStorm.
 * User: Nerijus
 * Date: 2014.12.21
 * Time: 13:48
 * Version: HH_1.0.1
 */
namespace HH\ApiBundle\Exceptions;

use \Exception as Exception;

/**
 * Class RequestValidationException
 * @package HH\ApiBundle\Exceptions
 */
class RequestValidationException extends Exception
{
    /** @var int */
    const ERROR_DEVICE_ID = -1;
    /** @var int */
    const ERROR_REQUEST_TYPE = -2;
    /** @var int */
    const ERROR_DATE = -3;
    /** @var int */
    const ERROR_DATA = -4;

    /**
     * @param string $message
     * @param int $code
     */
    public function __construct($message = "", $code = 0)
    {
        parent::__construct($message, $code);
    }
} 