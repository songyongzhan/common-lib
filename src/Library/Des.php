<?php

namespace Songyz\Common\Library;


class Des
{
    public static function encrypt(string $data, string $key, $urlSafe = false)
    {
        if ($data && $key) {
            $data = openssl_encrypt($data, 'des-ecb', $key);
            $urlSafe && $data = strtr($data, '+/', '-_');
        }

        return $data;
    }

    public static function decrypt(string $data, string $key, $urlSafe = false): string
    {
        if ($data && $key) {
            $urlSafe && $data = strtr($data, '-_', '+/');
            $data = openssl_decrypt($data, 'des-ecb', $key);
        }
        return $data;
    }

}
