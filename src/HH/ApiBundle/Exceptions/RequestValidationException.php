<?php
/**
 * Created by PhpStorm.
 * User: Nerijus
 * Date: 2014.12.21
 * Time: 13:48
 * Version: HH_1.0.1
 */
namespace HH\ApiBundle\Exceptions;

use Exception as Exception;

/**
 * Class RequestValidationException
 * @package HH\ApiBundle\Exceptions
 */
class RequestValidationException extends Exception
{
    const ERROR_DEVICE_ID = -1;
    const ERROR_REQUEST_TYPE = -2;
    const ERROR_DATE = -3;
    const ERROR_DATA = -4;

    /**
     * @param string $message
     * @param int $code
     */
    public function __construct($message = "", $code = 0)
    {
        parent::__construct($message, $code);
    }

    /**
     * @param int $errorCode
     * @return array
     */
    public function resolveRequestError($errorCode)
    {
        $errors = array();
        switch ($errorCode) {
            // @todo: sprintf, move to translations
            case RequestValidationException::ERROR_DEVICE_ID :
                $errors['ERROR_DEVICE_ID'] = 'Requested device id error';
                break;
            case RequestValidationException::ERROR_REQUEST_TYPE :
                $errors['ERROR_REQUEST_TYPE'] = 'Requested type error';
                break;
            case RequestValidationException::ERROR_DATE :
                $errors['ERROR_DATE'] = 'Requested date error';
                break;
            case RequestValidationException::ERROR_DATA :
                $errors['ERROR_DATA'] = 'Requested data error';
                break;
        }
        return $errors;
    }
} 