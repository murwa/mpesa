<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 7:19 AM
 */

namespace Mxgel\MPesa\Requests;

//

/**
 * Class C2BRegister
 *
 * @package Mxgel\MPesa\Requests
 */
/**
 * Class C2BRegister
 *
 * @package Mxgel\MPesa\Requests
 */
class C2BRegister extends Request
{
    /**
     * @var array
     */
    protected $only = [
        'validationURL',
        'confirmationURL',
        'responseType',
        'shortCode',
    ];

    /**
     * @return string
     */
    public function getUri()
    {
        return self::API_C2B_REGISTER_URL;
    }
}