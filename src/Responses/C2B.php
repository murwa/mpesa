<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 07/11/2017
 * Time: 15:03
 */

namespace Mxgel\MPesa\Responses;

use Illuminate\Support\Str;

/**
 * Class C2B
 *
 * @package Mxgel\MPesa\Responses
 */
class C2B extends Response
{
    /**
     * @var array
     */
    protected $only = [
        "transactionType",
        "transID",
        "transTime",
        "transAmount",
        "businessShortCode",
        "billRefNumber",
        "invoiceNumber",
        "orgAccountBalance",
        "thirdPartyTransID",
        "msisdn",
        "firstName",
        "middleName",
        "lastName",
    ];

    /**
     * @var string
     */
    protected $transactionType;
    /**
     * @var string
     */
    protected $transID;
    /**
     * @var string
     */
    protected $transTime;
    /**
     * @var float
     */
    protected $transAmount;
    /**
     * @var string
     */
    protected $businessShortCode;
    /**
     * @var string
     */
    protected $billRefNumber;
    /**
     * @var string
     */
    protected $invoiceNumber = null;
    /**
     * @var float
     */
    protected $orgAccountBalance = null;
    /**
     * @var string
     */
    protected $thirdPartyTransID = null;
    /**
     * @var string
     */
    protected $msisdn;
    /**
     * @var string
     */
    protected $firstName;
    /**
     * @var string
     */
    protected $middleName;
    /**
     * @var string
     */
    protected $lastName;

    /**
     * @return string
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * @param string $transactionType
     *
     * @return C2B
     */
    public function setTransactionType(?string $transactionType)
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransID()
    {
        return $this->transID;
    }

    /**
     * @param string $transID
     *
     * @return C2B
     */
    public function setTransID($transID)
    {
        $this->transID = $transID;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransTime()
    {
        return $this->transTime;
    }

    /**
     * @param string $transTime
     *
     * @return C2B
     */
    public function setTransTime($transTime)
    {
        $this->transTime = $transTime;

        return $this;
    }

    /**
     * @return float
     */
    public function getTransAmount()
    {
        return $this->transAmount;
    }

    /**
     * @param float $transAmount
     *
     * @return C2B
     */
    public function setTransAmount($transAmount)
    {
        $this->transAmount = $transAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getBusinessShortCode()
    {
        return $this->businessShortCode;
    }

    /**
     * @param string $businessShortCode
     *
     * @return C2B
     */
    public function setBusinessShortCode($businessShortCode)
    {
        $this->businessShortCode = $businessShortCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getBillRefNumber()
    {
        return $this->billRefNumber;
    }

    /**
     * @param string $billRefNumber
     *
     * @return C2B
     */
    public function setBillRefNumber($billRefNumber)
    {
        $this->billRefNumber = $billRefNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @param string $invoiceNumber
     *
     * @return C2B
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * @return float
     */
    public function getOrgAccountBalance()
    {
        return $this->orgAccountBalance;
    }

    /**
     * @param float $orgAccountBalance
     *
     * @return C2B
     */
    public function setOrgAccountBalance(?float $orgAccountBalance)
    {
        $this->orgAccountBalance = $orgAccountBalance;

        return $this;
    }

    /**
     * @return string
     */
    public function getThirdPartyTransID()
    {
        return $this->thirdPartyTransID;
    }

    /**
     * @param string $thirdPartyTransID
     *
     * @return C2B
     */
    public function setThirdPartyTransID(?string $thirdPartyTransID)
    {
        $this->thirdPartyTransID = $thirdPartyTransID;

        return $this;
    }

    /**
     * @return string
     */
    public function getMsisdn()
    {
        return $this->msisdn;
    }

    /**
     * @param string $msisdn
     *
     * @return C2B
     */
    public function setMsisdn($msisdn)
    {
        $this->msisdn = $msisdn;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return C2B
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     *
     * @return C2B
     */
    public function setMiddleName(?string $middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return C2B
     */
    public function setLastName(?string $lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return array
     */
    public function forDB()
    {
        $data = $this->toArray();
        $keys = array_map(function ($key) {
            return str_replace('i_d', 'id', Str::snake($key));
        }, array_keys($data));

        return array_combine($keys, array_values($data));
    }
}