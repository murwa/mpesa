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
     * @param string|null $key
     *
     * @return mixed
     */
    public function getUser($key = null)
    {
        $userModel = config('mpesa.user_model');
        $user = $userModel::wherePhoneNumber($this->getPhoneNumber())->first();

        return $user && $key ? $user->{$key} : $user;
    }


    /**
     * @return \Mxgel\MPesa\Responses\Response
     */
    public function execute()
    {
        $response = parent::execute();

        $this->setResponse($response);
        Event::dispatch('mpesa:requests.lnmo.executed', $this);

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
        $shortCode = $shortCode ?: config('mpesa.LNMO_short_code');

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