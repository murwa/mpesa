<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 27/10/2017
 * Time: 03:24
 */

namespace Mxgel\MPesa\Responses;


/**
 * Class Callback
 *
 * @package Mxgel\MPesa\Responses
 */
/**
 * Class LNMOCallbackResponse
 *
 * @package Mxgel\MPesa\Responses
 */
class LNMOCallbackResponse extends Response
{
    /**
     * @var float
     */
    protected $amount;
    /**
     * @var string
     */
    protected $mpesaReceiptNumber;
    /**
     * @var float
     */
    protected $balance;
    /**
     * @var int
     */
    protected $phoneNumber;

    /**
     * Callback constructor.
     *
     * @param null $content
     */
    public function __construct($content = null)
    {
        $key = array_key_exists('Body', $content) ? 'Body' : 'stkCallback';
        $content = array_get($content, $key);
        $items = array_except($content, 'CallbackMetadata');
        foreach (array_get($content, 'CallbackMetadata.Item', []) as $value) {
            $items[array_get($value, 'Name')] = array_get($value, 'Value');
        }
        parent::__construct($items);
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getMpesaReceiptNumber()
    {
        return $this->mpesaReceiptNumber;
    }

    /**
     * @param string $mpesaReceiptNumber
     */
    public function setMpesaReceiptNumber($mpesaReceiptNumber)
    {
        $this->mpesaReceiptNumber = $mpesaReceiptNumber;
    }

    /**
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * @return int
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param int $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }
}