<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 04/10/2017
 * Time: 04:27
 */

namespace Mxgel\MPesa\Requests;

//

/**
 * Class Status
 *
 * @package Mxgel\MPesa\Requests
 */
class Status extends Request
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
        'transactionID',
        'occasion'
    ];

    /**
     * @return string
     */
    public function getUri()
    {
        return self::API_TRANSACTION_STATUS;
    }
}