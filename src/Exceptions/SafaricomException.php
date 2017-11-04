<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 3:59 PM
 */

namespace Mxgel\MPesa\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class SafaricomException
 *
 * @package Mxgel\MPesa\Exceptions
 */
class SafaricomException extends HttpException
{
    /**
     * SafaricomException constructor.
     *
     * @param null            $message
     * @param int             $statusCode
     * @param \Exception|null $previous
     * @param array           $headers
     * @param int             $code
     */
    public function __construct($message = null, $statusCode = 500, \Exception $previous = null, array $headers = [], $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

    /**
     * @param string          $content
     * @param \Exception|null $previous
     *
     * @return \Mxgel\MPesa\Exceptions\SafaricomException
     */
    public static function createFromString(string $content, \Exception $previous = null): SafaricomException
    {
        $content = json_decode($content, true);

        return new self(array_get($content, 'errorMessage'), array_get($content, 'errorCode'), $previous);
    }
}