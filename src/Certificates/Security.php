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
     * @return string
     */
    public static function generateCredentials(): string
    {
        $password = config('services.safaricom.short_codes.0.security_credential');
        $resource = self::getCertificateResource();

        openssl_public_encrypt($password, $encrypted, $resource, OPENSSL_PKCS1_PADDING);

        return base64_encode($encrypted);
    }

    /**
     * @return resource
     *
     * @throws \Mxgel\MPesa\Exceptions\InvalidCertificateException
     */
    private static function getCertificateResource()
    {
        $cert = storage_path('cert.cer');

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