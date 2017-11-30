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
     * @return \Mxgel\MPesa\Auth\AccessToken
     */
    public static function accessToken(): AccessToken
    {
        $response = self::getHttpClient()->get(self::API_GENERATE_ACCESS_TOKEN, [
            'auth' => [
                config('mpesa.key'),
                config('mpesa.secret'),
            ],
        ]);

        return new AccessToken($response->getBody()->getContents());
    }

    /**
     * @return string
     */
    public static function getAuthorizationHeader(): string
    {
        $accessToken = self::accessToken()->getAccessToken();

        return "Bearer {$accessToken}";
    }
}