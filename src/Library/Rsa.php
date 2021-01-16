<?php

namespace Songyz\Common\Library;

/**
 * 非对称 rsa 加解密
 * Class Rsa
 * @package Songyz\Common\Library
 * @author songyongzhan <574482856@qq.com>
 * @date 2021/1/16 15:32
 */
class Rsa
{

    private $publicKey;
    private $privateKey;
    private static $instance;

    const PADDING_PKCS1 = OPENSSL_PKCS1_PADDING; //-11
    //const PADDING_SSLV23 = 'OPENSSL_SSLV23_PADDING';
    const PADDING_PKCS1_OAEP = OPENSSL_PKCS1_OAEP_PADDING; //-41
    //const PADDING_NO = OPENSSL_NO_PADDING;

    /**
     * @var string 选择填充方式
     */
    private $paddingMethod = OPENSSL_PKCS1_PADDING;

    private function __construct()
    {
    }

    /**
     * 加密
     * encrypt
     * @param $data
     * @param string $publicKey
     * @param bool $urlSafe
     * @return string
     *
     * @date 2020/5/28 10:53
     * @throws \Exception
     */
    public static function encrypt(string $data, string $publicKey = '', bool $urlSafe = false)
    {
        $self = self::getInstance($publicKey, '');
        return $self->base64encode($self->_encrypt($data), $urlSafe);
    }

    /**
     * 解密
     * decrypt
     * @param $data
     * @param string $privateKey
     * @param bool $urlSafe
     * @return mixed
     *
     * @date 2020/5/28 10:53
     * @throws \Exception
     */
    public static function decrypt(string $data, string $privateKey = '', bool $urlSafe = false)
    {
        $self = self::getInstance('', $privateKey);
        return $self->_decrypt($self->base64decode($data, $urlSafe));
    }

    /**
     * 实例化rsa类
     * getInstance
     * @param string $publicKey
     * @param string $privateKey
     * @return Rsa
     *
     * @date 2020/5/28 10:53
     */
    final public static function getInstance($publicKey = '', $privateKey = '')
    {
        isset(self::$instance) || self::$instance = new self();
        self::$instance->setKey($publicKey, $privateKey);

        return self::$instance;
    }

    /**
     * 设置填充方式
     * setPadding
     * @param string $paddingMethod
     * @throws \Exception
     *
     * @date 2020/5/28 14:20
     */
    public function setPadding($paddingMethod = OPENSSL_PKCS1_PADDING)
    {
        if (!empty($paddingMethod)) {
            if (!in_array($paddingMethod, [self::PADDING_PKCS1, self::PADDING_PKCS1_OAEP], true)) {
                throw new \Exception('setPadding method params err.');
            }

            $this->paddingMethod = $paddingMethod;
        }
    }

    private function setKey($publicKey, $privateKey)
    {
        if (stripos($publicKey, '-----BEGIN PUBLIC KEY-----')) {
            $this->publicKey = $publicKey;
        } elseif (!empty($publicKey)) {

            $this->publicKey = "-----BEGIN PUBLIC KEY-----\n" . chunk_split($publicKey,
                    64) . "-----END PUBLIC KEY-----";
        }

        if (stripos($privateKey, '-----BEGIN RSA PRIVATE KEY-----')) {
            $this->privateKey = $privateKey;
        } elseif (!empty($privateKey)) {
            $this->privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" . chunk_split($privateKey,
                    64) . "-----END RSA PRIVATE KEY-----";
        }
    }

    private function base64encode($data, $urlSafe = false)
    {
        $data = base64_encode($data);
        return $urlSafe ? strtr($data, '+/', '-_') : $data;
    }

    private function base64decode($data, $urlSafe = false)
    {
        return base64_decode($urlSafe ? strtr($data, '-_', '+/') : $data);
    }

    private function _encrypt($data)
    {
        $result = '';
        if ($data === 0 || $data) {
            foreach (str_split($data,
                $this->lengthByPaddingMethod()) as $chunk) { //RSA_PKCS1_PADDING  1024/8-11 => 117    RSA_PKCS1_OAEP_PADDING (41)
                if (!openssl_public_encrypt($chunk, $encrypted, $this->publicKey, $this->paddingMethod)) {
                    throw new \Exception('Unable to encrypt data.');
                }

                $result .= $encrypted;
            }
        }

        return $result;
    }

    private function lengthByPaddingMethod()
    {
        $length = 117;
        switch ($this->paddingMethod) {
            case OPENSSL_PKCS1_OAEP_PADDING:
                $length = 128 - 41;
                break;
            case OPENSSL_NO_PADDING:
                $length = 128;
                break;
            case OPENSSL_PKCS1_PADDING:
                $length = 128 - 11;
                break;
        }

        return $length;
    }

    private function _decrypt($data)
    {
        $result = '';
        if ($data) {
            foreach (str_split($data, 128) as $chunk) {
                if (!openssl_private_decrypt($chunk, $decrypted, $this->privateKey, $this->paddingMethod)) {
                    throw new \Exception('Unable to decrypt data.');
                }

                $result .= $decrypted;
            }
        }
        return $result;
    }
}
