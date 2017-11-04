<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 3:59 AM
 */

namespace Mxgel\MPesa\Contracts;

//

/**
 * Interface EndpointsContract
 *
 * @package Mxgel\MPesa\Contracts
 */
interface EndpointsContract
{
    /**
     * For testing - sandbox
     */
    const SANDBOX_URL = "https://sandbox.safaricom.co.ke/";

    /**
     * Live
     */
    const LIVE_URL = "https://safaricom.co.ke/";

    /**
     * Generate access token on sandbox
     */
    const API_GENERATE_ACCESS_TOKEN = "oauth/v1/generate?grant_type=client_credentials";

    /**
     *
     * This API enables Business to Customer (B2C) transactions between a company and customers who are the end-users
     * of its products or services. Use of this API requires a valid and verified B2C M-Pesa Short code.
     */
    const API_B2C_URL = "mpesa/b2c/v1/paymentrequest";

    /**
     * This API enables Business to Business (B2B) transactions between a business and another business. Use of this
     * API requires a valid and verified B2B M-Pesa short code for the business initiating the transaction and the both
     * businesses involved in the transaction.
     */
    const API_B2B_URL = "mpesa/b2b/v1/paymentrequest";

    /**
     * The C2B Register URL API registers the 3rd party’s confirmation and validation URLs to M-Pesa ; which then maps
     * these URLs to the 3rd party shortcode.
     */
    const API_C2B_REGISTER_URL = "mpesa/c2b/v1/registerurl";
    /**
     *
     */
    const API_C2B_SIMULATE_URL = "mpesa/c2b/v1/simulate";
    /**
     * Initiate online payment on behalf of a customer.
     */
    const API_LNMO_URL = "mpesa/stkpush/v1/processrequest";
    /**
     * Check the status of a Lipa Na M-Pesa Online Payment.
     */
    const API_LNMO_QUERY_URL = "mpesa/stkpushquery/v1/query";
    /**
     * The Account Balance API requests for the account balance of a shortcode.
     */
    const API_ACCOUNT_BALANCE = "mpesa/accountbalance/v1/query";

    /**
     *  check the transaction status.
     */
    const API_TRANSACTION_STATUS = "mpesa/transactionstatus/v1/query";

    /**
     * Transaction Reversal API reverses a M-Pesa transaction.
     */
    const API_REVERSAL = "mpesa/reversal/v1/request";
}