<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 07/11/2017
 * Time: 13:06
 */

namespace Mxgel\MPesa\Contracts;


/**
 * Interface ResponseCodeContract
 *
 * @package Mxgel\MPesa\Contracts
 */
interface ResponseCodeContract
{
    /**
     * Success (for C2B)
     */
    const RESPONSE_SUCCESS_C2B = 0;
    /**
     * Success (For APIs that are not C2B)
     */
    const RESPONSE_SUCCESS_NON_C2B = '00000000';
    /**
     * Rejecting the transaction
     */
    const RESPONSE_REJECT = 1;
}