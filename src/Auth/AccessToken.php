<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 3:43 AM
 */

namespace Mxgel\MPesa\Auth;

use Mxgel\MPesa\Model;
use Carbon\Carbon;

/**
 * Class AccessToken
 *
 * @package Mxgel\MPesa\Auth
 */
class AccessToken extends Model
{
    /**
     * @var string
     */
    protected $accessToken;
    /**
     * @var int
     */
    protected $expiresIn;

    /**
     * @var int
     */
    private $expiresAt;

    /**
     * AccessToken constructor.
     *
     * @param null $content
     */
    public function __construct($content = null)
    {
        parent::__construct($content);

        $this->setExpiresAt(with(new Carbon())->timestamp + $this->getExpiresIn());
    }


    /**
     * @return int
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param int $expiresAt
     *
     * @return \Mxgel\MPesa\Auth\AccessToken
     *
     */
    private function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @param int $expiresIn
     *
     * @return \Mxgel\MPesa\Auth\AccessToken
     */
    public function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     *
     * @return \Mxgel\MPesa\Auth\AccessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        $data = parent::toArray();
        foreach ($data as $key => $value) {
            $result[snake_case($key)] = $value;
        }

        return $result;
    }

    /**
     * Check if token has expired
     *
     * @return bool
     */
    public function expired()
    {
        return with(new Carbon())->timestamp > $this->getExpiresAt();
    }
}