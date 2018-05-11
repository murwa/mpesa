<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 04/10/2017
 * Time: 04:36
 */

namespace Mxgel\MPesa\Requests;

//


/**
 * Class Reversal
 *
 * @package Mxgel\MPesa\Requests
 */
class Reversal extends Request
{
    /**
     * @var array
     */
    protected $only = [
        'commandID',
        'receiverParty',
        'recieverIdentifierType',
        'remarks',
        'initiator',
        'securityCredential',
        'queueTimeOutURL',
        'resultURL',
        'transactionID',
        'occasion',
        'amount',
    ];

    /**
     * @var string
     */
    protected $resultRouteName = 'mpesa.reversal';

    /**
     * @var string
     */
    protected $receiverParty;

    /**
     * @var string
     */
    protected $receiverIdentifierType;

    /**
     * @return string
     */
    public function getUri()
    {
        return self::API_REVERSAL;
    }

    /**
     * @return string
     */
    public function getReceiverParty()
    {
        return $this->receiverParty;
    }

    /**
     * @param string $receiverParty
     *
     * @return \Mxgel\MPesa\Requests\Reversal
     */
    public function setReceiverParty($receiverParty)
    {
        $this->receiverParty = $receiverParty;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverIdentifierType()
    {
        return $this->receiverIdentifierType;
    }

    /**
     * @param string $receiverIdentifierType
     *
     * @return \Mxgel\MPesa\Requests\Reversal
     */
    public function setReceiverIdentifierType($receiverIdentifierType)
    {
        $this->receiverIdentifierType = $receiverIdentifierType;

        return $this;
    }
}