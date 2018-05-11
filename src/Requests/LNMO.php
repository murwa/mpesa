<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 01/10/2017
 * Time: 9:49 AM
 */

namespace Mxgel\MPesa\Requests;


/**
 * Class LNMO
 *
 * @package Mxgel\MPesa\Requests
 */
use Event;

/**
 * Class LNMO
 *
 * @package Mxgel\MPesa\Requests
 */
class LNMO extends LNM
{
    /**
     * @var array
     */
    protected $only = [
        'businessShortCode',
        'password',
        'timestamp',
        'transactionType',
        'amount',
        'partyA',
        'partyB',
        'phoneNumber',
        'callBackURL',
        'accountReference',
        'transactionDesc',
    ];
    /**
     * @var string
     */
    protected $transactionType;

    /**
     * LNMO constructor.
     *
     * @param null $content
     */
    public function __construct($content = null)
    {
        parent::__construct($content);

        $this->setTransactionType(self::COMMAND_CUSTOMER_PAY_BILL_ONLINE);
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return self::API_LNMO_URL;
    }

    /**
     * @return string
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * @param string $transactionType
     */
    private function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
    }

    /**
     * @return string
     */
    public function getAccountReference()
    {
        return $this->getPhoneNumber();
    }


    /**
     * @param \Mxgel\MPesa\Auth\Auth $auth
     *
     * @return \Mxgel\MPesa\Responses\Response
     */
    public function execute($auth)
    {
        $response = parent::execute($auth);

        $this->setResponse($response);

        return $response;
    }

    /**
     * Create an LNMO Request
     *
     * @param float $amount
     * @param int $phoneNumber
     * @param int|null $shortCode
     * @param string $desc
     *
     * @return \Mxgel\MPesa\Requests\LNMO
     */
    public static function make($amount, $phoneNumber, $shortCode = null, $desc = "Transaction")
    {
        return new self([
            "businessShortCode" => $shortCode,
            "amount"            => $amount,
            "partyA"            => $phoneNumber,
            "partyB"            => $shortCode,
            "phoneNumber"       => $phoneNumber,
            "transactionDesc"   => $desc,
        ]);
    }

}