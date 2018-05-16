<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 4:51 AM
 */

namespace Mxgel\MPesa\Certificates;


use Mxgel\MPesa\Exceptions\InvalidCertificateException;

/**
 * Class Security
 *
 * @package Mxgel\MPesa\Certificates
 */
class Security
{
    /**
     * Generate security credentials from password and certificate
     *
     * @param string $password Security Credential provided by safaricom
     * @param string $path     Path to certificate
     *
     * @return string
     */
    public static function generateCredentials($password, $path = null)
    {
        openssl_public_encrypt($password, $encrypted, self::getCertificateResource($path), OPENSSL_PKCS1_PADDING);

        return base64_encode($encrypted);
    }

    /**
     * Fetch a certificate from storage
     *
     * @param string $path Path to certificate
     *
     * @return resource
     * @throws \Mxgel\MPesa\Exceptions\InvalidCertificateException
     */
    private static function getCertificateResource($path = null)
    {
        $cert = $path ?: storage_path('cert.cer');

        $fp = fopen($cert, "r");
        $pub_key = fread($fp, 8192);
        fclose($fp);

        $resource = openssl_get_publickey($pub_key);
        if ($resource) {
            return $resource;
        }

        throw new InvalidCertificateException(openssl_error_string());
    }
}