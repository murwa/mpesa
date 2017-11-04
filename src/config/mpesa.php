<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 10/10/2017
 * Time: 11:15
 */

return [
    'key'             => '7q3M4GhnHfxXR9eonHovQGlAKtZvAa8A',
    'secret'          => 'G6X66FyGyWY84gJH',
    'short_codes'     => [
        [
            "short_code"          => 600729,
            "initiator_name"      => "Safaricomapi",
            "security_credential" => "PJBg8v5P",
        ],
        [
            "short_code" => 600000,
        ],
    ],
    "msisdn"          => 254708374149,
    "LNMO_short_code" => 174379,
    "LNMO_passkey"    => "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919",
    "routes"          => [
        "timeout"      => "mpesa.timeout",
        "validation"   => "mpesa.validation",
        "confirmation" => "mpesa.confirmation",
        "callback"     => "mpesa.callback",
    ],
];