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
    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    /**
     * @param string $transactionType
     *
     * @return C2B
     */
    public function setTransactionType(string $transactionType): C2B
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransID(): string
    {
        return $this->transID;
    }

    /**
     * @param string $transID
     *
     * @return C2B
     */
    public function setTransID(string $transID): C2B
    {
        $this->transID = $transID;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransTime(): string
    {
        return $this->transTime;
    }

    /**
     * @param string $transTime
     *
     * @return C2B
     */
    public function setTransTime(string $transTime): C2B
    {
        $this->transTime = $transTime;

        return $this;
    }

    /**
     * @return float
     */
    public function getTransAmount(): float
    {
        return $this->transAmount;
    }

    /**
     * @param float $transAmount
     *
     * @return C2B
     */
    public function setTransAmount(float $transAmount): C2B
    {
        $this->transAmount = $transAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getBusinessShortCode(): string
    {
        return $this->businessShortCode;
    }

    /**
     * @param string $businessShortCode
     *
     * @return C2B
     */
    public function setBusinessShortCode(string $businessShortCode): C2B
    {
        $this->businessShortCode = $businessShortCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getBillRefNumber(): string
    {
        return $this->billRefNumber;
    }

    /**
     * @param string $billRefNumber
     *
     * @return C2B
     */
    public function setBillRefNumber(string $billRefNumber): C2B
    {
        $this->billRefNumber = $billRefNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    /**
     * @param string $invoiceNumber
     *
     * @return C2B
     */
    public function setInvoiceNumber(?string $invoiceNumber): C2B
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * @return float
     */
    public function getOrgAccountBalance(): ?float
    {
        return $this->orgAccountBalance;
    }

    /**
     * @param float $orgAccountBalance
     *
     * @return C2B
     */
    public function setOrgAccountBalance(?float $orgAccountBalance): C2B
    {
        $this->orgAccountBalance = $orgAccountBalance;

        return $this;
    }

    /**
     * @return string
     */
    public function getThirdPartyTransID(): ?string
    {
        return $this->thirdPartyTransID;
    }

    /**
     * @param string $thirdPartyTransID
     *
     * @return C2B
     */
    public function setThirdPartyTransID(?string $thirdPartyTransID): C2B
    {
        $this->thirdPartyTransID = $thirdPartyTransID;

        return $this;
    }

    /**
     * @return string
     */
    public function getMsisdn(): string
    {
        return $this->msisdn;
    }

    /**
     * @param string $msisdn
     *
     * @return C2B
     */
    public function setMsisdn(string $msisdn): C2B
    {
        $this->msisdn = $msisdn;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return C2B
     */
    public function setFirstName(string $firstName): C2B
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     *
     * @return C2B
     */
    public function setMiddleName(string $middleName): C2B
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return C2B
     */
    public function setLastName(string $lastName): C2B
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return array
     */
    public function forDB(): array
    {
        $data = $this->toArray();
        $keys = array_map(function ($key) {
            return Str::snake($key);
        }, array_keys($data));

        return array_merge($keys, array_values($data));
    }
}