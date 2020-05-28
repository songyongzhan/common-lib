<?php

namespace Songyz\Common\Tests\Jwt;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Jwt\JwtService;
use Songyz\Common\Library\Rsa;
use function GuzzleHttp\default_user_agent;

class RsaTest extends TestCase
{

    private $jwt_rsa_public = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCGFnFKOOc+vMP5FnWGQgvxAxCd2f2ng8xxQy6hSpJvZWb/cFdeyhOr+xTca9w4bziGiwLO9xrr1a6wZY3ovzjCl2khtlV6wIXEGNXQmSyHgb9yBP1vgKwfJs+jtBy6Gt7uxUo4In4svNrZUWNmYQaDJZXpMLPkGo7GBrk8tze5cwIDAQAB';
    private $jwt_rsa_private = 'MIICWwIBAAKBgQCGFnFKOOc+vMP5FnWGQgvxAxCd2f2ng8xxQy6hSpJvZWb/cFdeyhOr+xTca9w4bziGiwLO9xrr1a6wZY3ovzjCl2khtlV6wIXEGNXQmSyHgb9yBP1vgKwfJs+jtBy6Gt7uxUo4In4svNrZUWNmYQaDJZXpMLPkGo7GBrk8tze5cwIDAQABAoGAB4UJWXDo1wXdtQG4xDdpVVzR+RLukg8RehCbHtnVwyrb+dtNAGMzczj41IZf//I3fflxxjWUFuxm3ZGfFxG87Gf76fViZWZc5hemosNUw9ScYYlg4ZqsO/qxKmtfyzUGzrOl+1H23HcWUjzGjvZkcBJKW9uiqw7dPk+OmbzGwhECQQCyBTrkA7QSR/nZATcv802E/wfXGVEK0NDyQ2nRSODMln2E0K69Pw4rKGD1tDN2FB7TEhO9EZO3/NCaIAlWmgkXAkEAwNKzgzb5eY/+9kWkL7j7qurM3zMtTe7nAc6BXAKFzb952230A/9hNTw+1z2iqy+bt0Aexij5xMK6KbbIbtZUBQJAOg5kl0nx5uhcPf4cfmHNjSsS5n5WJL3W9rsvflZTIcWOZ8sawZMXztFbVaYQBlkneFRz5Xwe/ajQawM5qGmRvwJAGH/tDSQECL0SESqCFQo099+DjmyLOha7xU/+wbkUVTMaAZZz5boiGMiB14leTM/swhjkkBsOuUBgtQIjb2nOHQJAODVV2lwOOEhh5p3tof7iYgMBius5UUf05yNyyDYXSKruoHsNo0RPTzyiSgzJbqA6Cg/Z4egzIC/+eQj5Nj+qag==';

    public function testInstanceEncrypt()
    {
        $rsa = Rsa::getInstance($this->jwt_rsa_public, $this->jwt_rsa_private);
//        $rsa->setPadding(Rsa::PADDING_PKCS1_OAEP);
        $rsa->setPadding(Rsa::PADDING_PKCS1);
        $str = $rsa::encrypt(json_encode(['username' => 'song']));
        echo $str;
        //YZrAmY+jVXtcMYGmI0ncRZkfDG7vw93THahUJmgdHrtQHcHAbyf2auShQFD7SDsX8UK8KJYPT/OzCkkcTJegAHnd8Jy1gXUwfqWkI9k/qd/wEvyz6PBTGzT2i0aHb4eVfk8KJIMKWiOBCUHviHVyTCgofVLvYPauq/7Au992jUE=
        $this->assertIsString($str);
    }
    public function testInstanceDecrypt()
    {
        $rsa = Rsa::getInstance($this->jwt_rsa_public, $this->jwt_rsa_private);
        //$rsa->setPadding(Rsa::PADDING_PKCS1_OAEP);
        //$str = $rsa::decrypt('CtUaBq8iZqO+lPnkchskNP0xifexJpJ7jFsO8idwnMDdWVQAHFwNUXuIPEnVfNScsBiFpGXdJkv2DJl4HnO54KgTNUtQkw3qXhCGDoi8pS9gl1dPiY6z2bhU1ImpGDkjAxbqrv9UdqinX5zUO29cCNnMkdX/VtnSImrc/DYWtWo=');
        $rsa->setPadding(Rsa::PADDING_NO);
        $str = $rsa::decrypt('CtUaBq8iZqO+lPnkchskNP0xifexJpJ7jFsO8idwnMDdWVQAHFwNUXuIPEnVfNScsBiFpGXdJkv2DJl4HnO54KgTNUtQkw3qXhCGDoi8pS9gl1dPiY6z2bhU1ImpGDkjAxbqrv9UdqinX5zUO29cCNnMkdX/VtnSImrc/DYWtWo=');

        echo $str;
        //YZrAmY+jVXtcMYGmI0ncRZkfDG7vw93THahUJmgdHrtQHcHAbyf2auShQFD7SDsX8UK8KJYPT/OzCkkcTJegAHnd8Jy1gXUwfqWkI9k/qd/wEvyz6PBTGzT2i0aHb4eVfk8KJIMKWiOBCUHviHVyTCgofVLvYPauq/7Au992jUE=
        $this->assertIsString($str);
    }

    public function testEncrypt()
    {

        $str = Rsa::encrypt(json_encode(['username' => 'song']), $this->jwt_rsa_public, true);
        print_r($str);
        /**
         * encrypt 第三个参数 是安全传递 默认为false 可能携带 + / 相关字符
         * WpTVzIy6YTCYyd4Vmashs+ZgS7+GXmBGiKkJfAo7okbbwKXkK1h9EvynrKCT1fi/dr97DnFj0Y+2xUHP6e+NsMYkWIyWYbecNAtPxL2eIJRqFelDmCWTscMc2k42Nq/mHeWIif07vT6mLi+VylMdKX6uFYQf8uSGjkDP1OacZJ0=
         * C1e0mSo0BhEOK0MRyDcYZBhinUHx5tfYWNRhRj2JbCcjCYVcM_CdPaZl9PUkPgINe2-wNTsc4rnQqowGiIZ74yeUufavsNsUZTP0E24HcBNWa2GpX536npPZvZZ0iHocgG364vR-QzYRSeCAasY86N6IEpSkCB09i2wHUJXSF8c=
         * D5d_tRk3oy5f7RqypD9ebINjsT4OWEii4c6C8Hei2To_CGJWvCGtRuWhQoAvTZH_sOzaGO90YXCxz7Y9x_a2jP9aFmFrJvjTlp9_OkpgrFcmlD9Or-kCqkbJHSMFtxxsO06XODuv0hgXOUFrZKGNV8K0SQB_YY_0p1vNzi6uJXQ=
         */

        $this->assertIsString($str);

    }

    public function testDe()
    {
        $json = 'D5d_tRk3oy5f7RqypD9ebINjsT4OWEii4c6C8Hei2To_CGJWvCGtRuWhQoAvTZH_sOzaGO90YXCxz7Y9x_a2jP9aFmFrJvjTlp9_OkpgrFcmlD9Or-kCqkbJHSMFtxxsO06XODuv0hgXOUFrZKGNV8K0SQB_YY_0p1vNzi6uJXQ=';
        $data = Rsa::decrypt($json, $this->jwt_rsa_private, true);
        echo "<pre style='color:blue;font-size:14px;'>";
        print_r($data);
        print_r(json_decode($data, true));
        echo "</pre>";
        $this->assertIsString($data);
    }

}
