<?php

namespace Songyz\Common\Library;

/**
 * aes 加解密工具
 * Class Aes
 * @package Songyz\Common\Library
 * @author songyongzhan <574482856@qq.com>
 */
class Aes
{
    public static function encrypt(string $data, string $key, $urlSafe = false)
    { //openssl_get_cipher_methods
        if ($data && $key) {
            $iv = openssl_random_pseudo_bytes(16);
            $data = self::base64encode($iv . openssl_encrypt($data, 'aes-128-cbc', $key, OPENSSL_RAW_DATA, $iv),
                $urlSafe);
        }

        return $data;
    }

    public static function decrypt(string $data, string $key, $urlSafe = false): string
    {
        if (strlen($data) >= 16 + 16 && $key) {
            $data = self::base64decode($data, $urlSafe);
            $data = openssl_decrypt(substr($data, 16), 'aes-128-cbc', $key, OPENSSL_RAW_DATA, substr($data, 0, 16));
        }

        return $data;
    }

    private static function base64encode($data, $urlSafe = false)
    {
        $data = base64_encode($data);
        return $urlSafe ? strtr($data, '+/', '-_') : $data;
    }

    private static function base64decode($data, $urlSafe = false)
    {
        return base64_decode($urlSafe ? strtr($data, '-_', '+/') : $data);
    }
}
