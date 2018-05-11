<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 04/10/2017
 * Time: 03:22
 */

namespace Mxgel\MPesa\Requests;

//


/**
 * Class Balance
 *
 * @package Mxgel\MPesa\Requests
 */
class Balance extends Request
{
    /**
     * @var array
     */
    protected $only = [
        'commandID',
        'partyA',
        'identifierType',
        'remarks',
        'initiator',
        'securityCredential',
        'queueTimeOutURL',
        'resultURL',
    ];

    /**
     * @var string
     */
    protected $resultRouteName = 'mpesa.balance';

    /**
     * @return string
     */
    public function getUri()
    {
        return self::API_ACCOUNT_BALANCE;
    }

    /**
     * @return string
     */
    public function getCommandID()
    {
        return self::COMMAND_ACCOUNT_BALANCE;
    }
}