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
use App\Models\MPesaLNMO;
use App\Models\User;
use Event;
use Mxgel\MPesa\Responses\Response;
use Carbon\Carbon;

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
    public function getUri(): string
    {
        return self::API_LNMO_URL;
    }

    /**
     * @return string
     */
    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    /**
     * @param string $transactionType
     */
    private function setTransactionType(string $transactionType)
    {
        $this->transactionType = $transactionType;
    }

    /**
     * @return string
     */
    public function getAccountReference(): string
    {
        return $this->getPhoneNumber();
    }

    /**
     * @param string|null $key
     *
     * @return mixed
     */
    protected function getUser(string $key = null)
    {
        $userModel = config('mpesa.user_model');
        $user = $userModel::wherePhoneNumber($this->getPhoneNumber())->first();

        return $user && $key ? $user->{$key} : $user;
    }


    /**
     * @return \Mxgel\MPesa\Responses\Response
     */
    public function execute(): Response
    {
        $response = parent::execute();
        Event::dispatch('mpesa:requests.lnmo.executed', [
            'business_short_code' => $this->getBusinessShortCode(),
            'account_reference'   => $this->getAccountReference(),
            'merchant_request_id' => $response->getMerchantRequestID(),
            'checkout_request_id' => $response->getCheckoutRequestID(),
            'amount'              => $this->getAmount(),
            'msisdn'              => $this->getPhoneNumber(),
            'user_id'             => $this->getUser('id'),
        ]);

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
    public static function make(float $amount, int $phoneNumber, ?int $shortCode = null, string $desc = "Transaction")
    {
        $shortCode = $shortCode ?: config('services.safaricom.LNMO_short_code');

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