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
    public function __construct(?string $message = null, Exception $previous = null, $code = 0)
    {
        $this->setErrorCode($code);
        parent::__construct($message, substr($code, 0, strpos($code, '.')), $previous);
    }

    /**
     * @param string $content
     * @param \Exception|null $previous
     *
     * @return \Mxgel\MPesa\Exceptions\SafaricomException
     */
    public static function createFromString(string $content, Exception $previous = null): SafaricomException
    {
        $content = json_decode($content, true);
        $code = array_get($content, 'errorCode');

        return new self(array_get($content, 'errorMessage') ?: config('errors' . $code), $previous, $code);
    }

    /**
     * @return null|string
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * @param null|string $errorCode
     *
     * @return SafaricomException
     */
    protected function setErrorCode(?string $errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }
}