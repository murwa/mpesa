<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 07/11/2017
 * Time: 12:53
 */

namespace Mxgel\MPesa\Contracts;

//

/**
 * Interface ResultCodesContract
 *
 * @package Mxgel\MPesa\Contracts
 */
interface ResultCodesContract
{
    /**
     * Success
     */
    const RESULT_SUCCESS = 0;
    /**
     * Insufficient Funds
     */
    const RESULT_INSUFFICIENT_FUNDS = 1;
    /**
     * Less Than Minimum Transaction Value
     */
    const RESULT_LT_MINIMUM_TRANSACTION_VALUE = 2;
    /**
     * More Than Maximum Transaction Value
     */
    const RESULT_MT_MAXIMUM_TRANSACTION_VALUE = 3;
    /**
     * Would Exceed Daily Transfer Limit
     */
    const RESULT_WE_DAILY_TRANSFER_LIMIT = 4;
    /**
     * Would Exceed Minimum Balance
     */
    const RESULT_WE_MINIMUM_BALANCE = 5;
    /**
     * Would Exceed Maximum Balance
     */
    const RESULT_WE_MAXIMUM_BALANCE = 8;
    /**
     * Unresolved Primary Party
     */
    const RESULT_UNRESOLVED_PRIMARY_PARTY = 6;
    /**
     * Unresolved Receiver Party
     */
    const RESULT_UNRESOLVED_RECEIVER_PARTY = 7;
    /**
     * Debit Account Invalid
     */
    const RESULT_DEBIT_ACCOUNT_INVALID = 11;
    /**
     * Credit Account Invalid
     */
    const RESULT_CREDIT_ACCOUNT_INVALID = 12;
    /**
     * Unresolved Debit Account
     */
    const RESULT_UNRESOLVED_DEBIT_ACCOUNT = 13;
    /**
     * Unresolved Credit Account
     */
    const RESULT_UNRESOLVED_CREDIT_ACCOUNT = 14;
    /**
     * Duplicate Detected
     */
    const RESULT_DUPLICATE_DETECTED = 15;
    /**
     * Internal Failure
     */
    const RESULT_INTERNAL_FAILURE = 17;
    /**
     * Unresolved Initiator
     */
    const RESULT_UNRESOLVED_INITIATOR = 20;
    /**
     * Traffic blocking condition in place
     */
    const RESULT_TRAFFIC_BLOCKING = 26;
}