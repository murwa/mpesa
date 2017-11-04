<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 6:36 AM
 */

namespace Mxgel\MPesa\Contracts;

//

/**
 * Interface IdentifierContract
 *
 * @package Mxgel\MPesa\Contracts
 */
interface IdentifierContract
{
    /**
     * Phone number
     */
    const IDENTIFIER_MSISDN = 1;
    /**
     * Till number
     */
    const IDENTIFIER_TILL_NUMBER = 2;
    /**
     * Short code
     */
    const IDENTIFIER_SHORT_CODE = 4;
}