<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 3:55 AM
 */

namespace Mxgel\MPesa\Auth;


use Mxgel\MPesa\Contracts\EndpointsContract;
use Mxgel\MPesa\Model;

/**
 * Class Auth
 *
 * @package Mxgel\MPesa\Auth
 */
class Auth extends Model implements EndpointsContract
{
    /**
     * @var string Key
     */
    private $key;

    /**
     * @var string Secret
     */
    private $secret;

    /**
     * @var
     */
    private $token;

    /**
     * Fetch access token
     *
     * @return \Mxgel\MPesa\Auth\AccessToken
     *
     */
    public function accessToken()
    {
        if ($this->getToken() && !$this->getToken()->expired()) {
            return $this->getToken();
        }
        $response = Model::getHttpClient()->get(self::API_GENERATE_ACCESS_TOKEN, [
            'auth' => [
                $this->key,
                $this->secret,
            ],
        ]);

        $token = new AccessToken($response->getBody()->getContents());
        $this->setToken($token);

        return $token;
    }

    /**
     * Prepare access token to send in request
     *
     * @return string
     *
     */
    public function getAuthorizationHeader()
    {
        $accessToken = $this->accessToken()->getAccessToken();

        return "Bearer {$accessToken}";
    }

    /**
     * @param string $key
     *
     * @return Auth
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param string $secret
     *
     * @return Auth
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * @return \Mxgel\MPesa\Auth\AccessToken
     */
    private function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     *
     * @return \Mxgel\MPesa\Auth\Auth
     */
    private function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}