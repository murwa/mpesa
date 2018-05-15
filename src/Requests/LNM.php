<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 05/10/2017
 * Time: 01:53
 */

namespace Mxgel\MPesa\Requests;


use Carbon\Carbon;

/**
 * Class LNM
 *
 * @package Mxgel\MPesa\Requests
 */
abstract class LNM extends Request
{
    /**
     * @var
     */
    private $passKey;

    /**
     * LNM constructor.
     *
     * @param null $content
     */
    public function __construct($content = null)
    {
        parent::__construct($content);

        $this->setTimestamp(with(new Carbon('now'))->format($this->getDateFormat()));
        $this->setPassword($this->generatePassword($this->getPassKey()));
    }

    /**
     * @return string
     */
    public function getPassKey()
    {
        return $this->passKey;
    }

    /**
     * @param string $passKey
     *
     * @return \Mxgel\MPesa\Requests\LNM
     */
    public function setPassKey($passKey)
    {
        $this->passKey = $passKey;

        return $this;
    }

}