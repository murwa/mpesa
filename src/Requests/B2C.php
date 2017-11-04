<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 6:21 AM
 */

namespace Mxgel\MPesa\Requests;

//


/**
 * Class B2C
 *
 * @package Mxgel\MPesa\Requests
 */
class B2C extends Request
{
    /**
     * @var array
     */
    protected $only = [
        'securityCredential',
        'commandID',
        'amount',
        'partyA',
        'partyB',
        'remarks',
        'queueTimeOutURL',
        'resultURL',
        'initiatorName',
        'occasion',
    ];

    /**
     * @var string
     */
    protected $resultRouteName = 'mpesa.b2c';

    /**
     * @return string
     */
    public function getUri(): string
    {
        return self::API_B2C_URL;
    }
}