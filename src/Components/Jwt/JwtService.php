<?php

namespace Songyz\Common\Components\Jwt;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\ValidationData;

/**
 *
 * Class JwtService
 * @package App\Http\Services\Authorization
 * @author songyz <574482856@qq.com>
 * @date 2020/1/10 18:48
 */
class JwtService
{
    private $token;

    private $rsaPublicKey;

    private $rsaPrivateKey;

    /** @var 原始token */
    public $srcToken;

    /** @var 当前登录用户的id */
    public $id;

    /** @var token设置时间 */
    public $issuedAt = 0;

    /** @var token过期时间 */
    public $expiresAt = 0;

    /** @var 颁发者 */
    public $issuedBy = '';

    /** @var string 连接客户端 */
    public $clientId = '';

    /** @var 接受者 */
    public $permittedFor = '';

    /** @var int 过期时长 */
    public $expire = 0;

    public function __construct(
        string $token,
        string $jwtRsaPublic,
        string $jwtRsaPrivate,
        int $expire = 7200, //过期时间
        string $issuer = 'jwt' //颁发者
    )
    {
        if (stripos($jwtRsaPublic, '-----BEGIN PUBLIC KEY-----')) {
            $this->rsaPublicKey = $jwtRsaPublic;
        } else {
            $this->rsaPublicKey = "-----BEGIN PUBLIC KEY-----\n" . chunk_split($jwtRsaPublic,
                    64) . "-----END PUBLIC KEY-----";
        }

        if (stripos($jwtRsaPrivate, '-----BEGIN RSA PRIVATE KEY-----')) {
            $this->rsaPrivateKey = $jwtRsaPrivate;
        } else {
            $this->rsaPrivateKey = "-----BEGIN RSA PRIVATE KEY-----\n" . chunk_split($jwtRsaPrivate,
                    64) . "-----END RSA PRIVATE KEY-----";
        }

        $this->issuedBy = $issuer;
        $this->expire = $expire;
        $this->token = $token;
        $this->init();
    }

    /**
     * 生成token
     * getToken
     * @param string $id
     * @param array $params
     * @return string
     * @throws \Exception
     * @author songyz <574482856@qq.com>
     * @date 2020/1/10 18:43
     */
    public function getToken($id, array $params)
    {
        try {
            $builder = new Jwt();
            $now = time();
            $this->expiresAt = $expireTime = $now + $this->expire; //过期时间
            return (string)$builder->identifiedBy($id)->permittedFor($this->permittedFor)->issuedAt($now)->expiresAt($expireTime)
                ->issuedBy($this->issuedBy)->withClaim($params)->getToken(new Sha256(), new Key($this->rsaPrivateKey));
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * 设置接受者
     * setPermittedFor
     * @param string $permittedFor
     * @return $this
     *
     * @date 2020/5/20 18:49
     */
    public function setPermittedFor(string $permittedFor)
    {
        $this->permittedFor = $permittedFor;
        return $this;
    }

    /**
     * 设置过期时间
     * setExpire
     * @param int $expire
     * @return $this
     * @author songyz <574482856@qq.com>
     * @date 2020/1/10 19:32
     */
    public function setExpire(int $expire = 7200)
    {
        $expire < 0 && $expire = 7200;
        $this->expire = $expire;
        return $this;
    }

    /**
     * 验证是否是符合要求的token
     * validate
     * @param string $token
     * @return bool
     * @throws \Exception
     * @author songyz <574482856@qq.com>
     * @date 2020/1/11 10:36
     */
    protected function validate()
    {
        $data = new ValidationData();
        $data->setIssuer($this->issuedBy);
        $data->setAudience($this->permittedFor);
        $parseToken = $this->parseToken();

        if (!$parseToken) {
            return false;
        }

        return $parseToken->validate($data);
    }

    /**
     * 获取所有
     * getAllData
     * @author songyz <574482856@qq.com>
     * @date 2020/1/10 19:21
     */
    public function getAllData()
    {
        $parseToken = $this->parseToken();
        if (!$parseToken) {
            return [];
        }
        return $parseToken->getClaims();
    }

    /**
     * 从所有的数据中获取指定的key值
     * getData
     * @param $key
     * @return mixed|null
     *
     * @author songyz <574482856@qq.com>
     * @date 2020/2/6 16:01
     */
    public function getData($key)
    {
        $data = $this->getAllData();
        return strval($data[$key] ?? '');
    }

    /**
     * 是否登录
     * isLogin
     * @author songyz <574482856@qq.com>
     * @date 2020/1/10 20:41
     */
    public function isLogin()
    {
        $validateResult = $this->validate();
        if (!$validateResult) {
            return false;
        }
        $parseToken = $this->parseToken();
        //isExpired 判断的是否过期 这里的返回值需要取反操作
        return $parseToken->isExpired() ? false : true;
    }

    /**
     * 验证token是否有效
     * verify
     * @param $token
     * @return bool
     * @throws \Exception
     * @author songyz <574482856@qq.com>
     * @date 2020/1/11 11:03
     */
    public function verify($token = '')
    {
        empty($token) && $token = $this->token;

        $parseToken = $this->parseToken($token);
        if (!$parseToken) {
            return false;
        }

        return $parseToken->verify(new Sha256(), new Key($this->rsaPublicKey));
    }

    /**
     * 判断 还有second秒后过期
     * isExpire
     * @param int $second
     * @return bool
     * @author songyz <574482856@qq.com>
     * @date 2020/1/10 20:22
     */
    public function isExpire(int $second = 0)
    {
        if ($this->expiresAt > 0) {
            if ($this->expiresAt - time() < $second) {
                return true;
            }
        }
        return false;
    }

    /**
     *
     * parseToken
     * @param string $token
     * @return \Lcobucci\JWT\Token
     * @throws \Exception
     * @author songyz <574482856@qq.com>
     * @date 2020/1/10 19:01
     */
    protected function parseToken(string $token = '')
    {
        try {
            empty($token) && $token = $this->token;

            $data = explode('.', $token);

            if (count($data) != 3) {
                return false;
            }

            return (new Parser())->parse($token);
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * 数据初始化
     * init
     * @throws \Exception
     * @author songyz <574482856@qq.com>
     * @date 2020/1/10 19:22
     */
    private function init()
    {
        if (!$this->token) {
            return false;
        }
        $parseToken = $this->parseToken();
        if (!$parseToken) {
            return false;
        }
        $this->id = $parseToken->getClaim('jti');
        $this->issuedAt = $parseToken->getClaim('iat');
        $this->expiresAt = $parseToken->getClaim('exp');
        $this->permittedFor = $parseToken->getClaim('aud');
        $this->issuedBy = $parseToken->getClaim('iss');
        $this->srcToken = $this->token;

        return true;
    }

}
