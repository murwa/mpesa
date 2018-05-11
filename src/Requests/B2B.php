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
 * Class B2B
 *
 * @package Mxgel\MPesa\Requests
 */
class B2B extends Request
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
        'initiator',
        'senderIdentifierType',
        'recieverIdentifierType',
        'accountReference',
        'occasion',
    ];

    /**
     * @var string
     */
    protected $resultRouteName = 'mpesa.b2b';

    /**
     * @return string
     */
    public function getUri()
    {
        return self::API_B2B_URL;
    }
}