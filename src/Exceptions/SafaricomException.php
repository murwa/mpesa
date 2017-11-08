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
     * SafaricomException constructor.
     *
     * @param null|string $message
     * @param \Exception|null $previous
     * @param int $code
     */
    public function __construct(?string $message = null, Exception $previous = null, $code = 0)
    {
        dump($message);
        dump($previous);
        dump($code);
        parent::__construct($message, $code, $previous);
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

        return new self(array_get($content, 'errorMessage'), $previous, array_get($content, 'errorCode'));
    }
}