<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 6:27 AM
 */

namespace Mxgel\MPesa\Contracts;


/**
 * Interface CommandsContract
 *
 * @package Mxgel\MPesa\Contracts
 */
interface CommandsContract
{
    /**
     * Reversal for an erroneous C2B transaction.
     */
    const COMMAND_TRANSACTION_REVERSAL = "TransactionReversal";

    /**
     * Used to send money from an employer to employees e.g. salaries
     */
    const COMMAND_SALARY_PAYMENT = "SalaryPayment";

    /**
     * Used to send money from business to customer e.g. refunds
     */
    const COMMAND_BUSINESS_PAYMENT = "BusinessPayment";

    /**
     * Used to send money when promotions take place e.g. raffle winners
     */
    const COMMAND_PROMOTION_PAYMENT = "PromotionPayment";

    /**
     * Used to check the balance in a paybill/buy goods account (includes utility, MMF, Merchant, Charges paid account).
     */
    const COMMAND_ACCOUNT_BALANCE = "AccountBalance";
    /**
     * Used to simulate a transaction taking place in the case of C2B Simulate Transaction or to initiate a transaction
     * on behalf of the customer (STK Push).
     */
    const COMMAND_CUSTOMER_PAY_BILL_ONLINE = "CustomerPayBillOnline";

    /**
     * Used to query the details of a transaction.
     */
    const COMMAND_TRANSACTION_STATUS_QUERY = "TransactionStatusQuery";

    /**
     * Similar to STK push, uses M-Pesa PIN as a service.
     */
    const COMMAND_CHECK_IDENTITY = "CheckIdentity";

    /**
     * Sending funds from one paybill to another paybill
     */
    const COMMAND_BUSINESS_PAY_BILL = "BusinessPayBill";

    /**
     * Sending funds from buy goods to another buy goods.
     */
    const COMMAND_BUSINESS_BUY_GOODS = "BusinessBuyGoods";

    /**
     * Transfer of funds from utility to MMF account.
     */
    const COMMAND_DISBURSE_FUNDS_BUSINESS = "DisburseFundsToBusiness";

    /**
     * Transferring funds from one paybills MMF to another paybills MMF account.
     */
    const COMMAND_BUSINESS_TO_BUSINESS = "BusinessToBusinessTransfer";

    /**
     * Transferring funds from paybills MMF to another paybills utility account.
     */
    const COMMAND_MMF_TO_UTILITY = "BusinessTransferFromMMFToUtility";
}