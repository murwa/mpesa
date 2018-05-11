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
     * Fetch access token
     *
     * @return \Mxgel\MPesa\Auth\AccessToken
     *
     */
    public function accessToken()
    {
        $response = Model::getHttpClient()->get(self::API_GENERATE_ACCESS_TOKEN, [
            'auth' => [
                $this->key,
                $this->secret,
            ],
        ]);

        return new AccessToken($response->getBody()->getContents());
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
}