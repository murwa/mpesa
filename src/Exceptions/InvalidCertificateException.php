<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 5:52 AM
 */

namespace Mxgel\MPesa\Exceptions;

//
/**
 * Class InvalidCertificateException
 *
 * @package Mxgel\MPesa\Exceptions
 */
class InvalidCertificateException extends SafaricomException
{
    /**
     * @var string
     */
    protected $message = "Invalid certificate";
}