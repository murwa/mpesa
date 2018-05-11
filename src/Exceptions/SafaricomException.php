<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 3:59 PM
 */

namespace Mxgel\MPesa\Exceptions;


use Exception;

/**
 * Class SafaricomException
 *
 * @package Mxgel\MPesa\Exceptions
 */
class SafaricomException extends Exception
{
    /**
     * @var null|string
     */
    protected $errorCode = null;

    /**
     * SafaricomException constructor.
     *
     * @param null|string $message
     * @param \Exception|null $previous
     * @param int $code
     */
    public function __construct($message = null, $previous = null, $code = 0)
    {
        $this->setErrorCode($code);
        parent::__construct($message ?: "", $code ? substr($code, 0, strpos($code, '.')) : 0, $previous);
    }

    /**
     * @param string $content
     * @param \Exception|null $previous
     *
     * @return \Mxgel\MPesa\Exceptions\SafaricomException
     */
    public static function createFromString($content, $previous = null)
    {
        $content = json_decode($content, true);
        $code = array_get($content, 'errorCode');

        return new self(array_get($content, 'errorMessage') ?: config('errors' . $code), $previous, $code);
    }

    /**
     * @return null|string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param null|string $errorCode
     *
     * @return SafaricomException
     */
    protected function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }
}