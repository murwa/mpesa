<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 7:01 PM
 */

namespace Mxgel\MPesa\Contracts;


/**
 * Interface RequestContract
 *
 * @package Mxgel\MPesa\Contracts
 */
interface RequestContract
{
    /**
     * @return string
     */
    public function getMethod(): string ;

    /**
     * @return string
     */
    public function getUri(): string ;
}