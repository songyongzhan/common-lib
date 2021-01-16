<?php

namespace Songyz\Common\Library;

/**
 * 对称 des 加解密工具类
 * Class Des
 * @package Songyz\Common\Library
 * @author songyongzhan <574482856@qq.com>
 * @date 2021/1/16 15:32
 */
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
