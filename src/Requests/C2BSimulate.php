<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 7:30 AM
 */

namespace Mxgel\MPesa\Requests;

//

/**
 * Class C2BSimulate
 *
 * @package Mxgel\MPesa\Requests
 */
class C2BSimulate extends Request
{
    /**
     * @var array
     */
    protected $only = [
        'commandID',
        'amount',
        'Msisdn',
        'billRefNumber',
        'shortCode',
    ];

    /**
     * @return string
     */
    public function getCommandID()
    {
        return self::COMMAND_CUSTOMER_PAY_BILL_ONLINE;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return self::API_C2B_SIMULATE_URL;
    }
}