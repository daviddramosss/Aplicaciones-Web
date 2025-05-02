<?php

namespace es\ucm\fdi\aw\helpers;

class firmaHelper
{
    public static function crearFirma($claveSecreta, $order, $base64Params): string
    {
        $claveDerivada = self::encrypt_3DES($order, $claveSecreta);
        $hash = hash_hmac('sha256', $base64Params, $claveDerivada, true);
        return base64_encode($hash);
    }

    private static function encrypt_3DES($message, $key): string
    {
        $key = base64_decode($key);
        $iv = "\x00\x00\x00\x00\x00\x00\x00\x00"; // 8 bytes
        $l = ceil(strlen($message) / 8) * 8;
        $messagePadded = str_pad($message, $l, "\0");
        return openssl_encrypt($messagePadded, 'des-ede3-cbc', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
    }
}
