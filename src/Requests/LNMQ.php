<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 05/10/2017
 * Time: 01:38
 */

namespace Mxgel\MPesa\Requests;

//

/**
 * Class LNMQ
 *
 * @package Mxgel\MPesa\Requests
 */
class LNMQ extends LNM
{
    /**
     * @var array
     */
    protected $only = [
        'businessShortCode',
        'password',
        'timestamp',
        'checkoutRequestID',
    ];

    /**
     * @var string
     */
    protected $checkoutRequestID;

    /**
     * @return string
     */
    public function getUri(): string
    {
        return self::API_LNMO_QUERY_URL;
    }

    /**
     * @return string
     */
    public function getCheckoutRequestID(): string
    {
        return $this->checkoutRequestID;
    }

    /**
     * @param string $checkoutRequestID
     *
     * @return \Mxgel\MPesa\Requests\LNMQ
     */
    public function setCheckoutRequestID(string $checkoutRequestID): LNMQ
    {
        $this->checkoutRequestID = $checkoutRequestID;

        return $this;
    }
}