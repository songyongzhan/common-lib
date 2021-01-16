<?php

namespace Songyz\Common\Tests;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Jwt\JwtService;

class JwtTest extends TestCase
{

    private $jwt_rsa_public = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCGFnFKOOc+vMP5FnWGQgvxAxCd2f2ng8xxQy6hSpJvZWb/cFdeyhOr+xTca9w4bziGiwLO9xrr1a6wZY3ovzjCl2khtlV6wIXEGNXQmSyHgb9yBP1vgKwfJs+jtBy6Gt7uxUo4In4svNrZUWNmYQaDJZXpMLPkGo7GBrk8tze5cwIDAQAB';
    private $jwt_rsa_private = 'MIICWwIBAAKBgQCGFnFKOOc+vMP5FnWGQgvxAxCd2f2ng8xxQy6hSpJvZWb/cFdeyhOr+xTca9w4bziGiwLO9xrr1a6wZY3ovzjCl2khtlV6wIXEGNXQmSyHgb9yBP1vgKwfJs+jtBy6Gt7uxUo4In4svNrZUWNmYQaDJZXpMLPkGo7GBrk8tze5cwIDAQABAoGAB4UJWXDo1wXdtQG4xDdpVVzR+RLukg8RehCbHtnVwyrb+dtNAGMzczj41IZf//I3fflxxjWUFuxm3ZGfFxG87Gf76fViZWZc5hemosNUw9ScYYlg4ZqsO/qxKmtfyzUGzrOl+1H23HcWUjzGjvZkcBJKW9uiqw7dPk+OmbzGwhECQQCyBTrkA7QSR/nZATcv802E/wfXGVEK0NDyQ2nRSODMln2E0K69Pw4rKGD1tDN2FB7TEhO9EZO3/NCaIAlWmgkXAkEAwNKzgzb5eY/+9kWkL7j7qurM3zMtTe7nAc6BXAKFzb952230A/9hNTw+1z2iqy+bt0Aexij5xMK6KbbIbtZUBQJAOg5kl0nx5uhcPf4cfmHNjSsS5n5WJL3W9rsvflZTIcWOZ8sawZMXztFbVaYQBlkneFRz5Xwe/ajQawM5qGmRvwJAGH/tDSQECL0SESqCFQo099+DjmyLOha7xU/+wbkUVTMaAZZz5boiGMiB14leTM/swhjkkBsOuUBgtQIjb2nOHQJAODVV2lwOOEhh5p3tof7iYgMBius5UUf05yNyyDYXSKruoHsNo0RPTzyiSgzJbqA6Cg/Z4egzIC/+eQj5Nj+qag==';
    private $jwt_expire = 2592000;


    public function testCreateToken()
    {

        $token = '';
        $jwtService = new JwtService($token, $this->jwt_rsa_public, $this->jwt_rsa_private, $this->jwt_expire);

        $token = $jwtService->getToken(1, ['name' => 'james']);

        echo $token;

        //eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJqdGkiOiIxIiwiYXVkIjoiIiwiaWF0IjoxNTg5OTcwNjM1LCJleHAiOjE1OTI1NjI2MzUsImlzcyI6Imp3dCIsIm5hbWUiOiJqYW1lcyJ9.ZJszk-lpzUAlv7Kmxto4mlVi84Ibz7QKp8-IcQxkcwMePLVQBwUGVnSkPq_RKCJDKOpYrInQ301ZNj5xOpwssoa5M7t1rCx0NTkq57qK-F536Z8wjhC3LFC_uQJSHiM7xa0YJ1rVtBDwmBDVXuzLXPnhcL6ypTkgXqi11Aca_EU

        $this->assertTrue(true);
    }


    public function testParseToken()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJqdGkiOiIxIiwiYXVkIjoiIiwiaWF0IjoxNTg5OTcwNjM1LCJleHAiOjE1OTI1NjI2MzUsImlzcyI6Imp3dCIsIm5hbWUiOiJqYW1lcyJ9.ZJszk-lpzUAlv7Kmxto4mlVi84Ibz7QKp8-IcQxkcwMePLVQBwUGVnSkPq_RKCJDKOpYrInQ301ZNj5xOpwssoa5M7t1rCx0NTkq57qK-F536Z8wjhC3LFC_uQJSHiM7xa0YJ1rVtBDwmBDVXuzLXPnhcL6ypTkgXqi11Aca_EU';
        $jwtService = new JwtService($token, $this->jwt_rsa_public, $this->jwt_rsa_private, $this->jwt_expire);

        $flag = $jwtService->verify($token);

        var_dump($flag);

        $this->assertTrue($flag);
    }

    public function testIsExpire()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJqdGkiOiIxIiwiYXVkIjoiIiwiaWF0IjoxNTg5OTcwNjM1LCJleHAiOjE1OTI1NjI2MzUsImlzcyI6Imp3dCIsIm5hbWUiOiJqYW1lcyJ9.ZJszk-lpzUAlv7Kmxto4mlVi84Ibz7QKp8-IcQxkcwMePLVQBwUGVnSkPq_RKCJDKOpYrInQ301ZNj5xOpwssoa5M7t1rCx0NTkq57qK-F536Z8wjhC3LFC_uQJSHiM7xa0YJ1rVtBDwmBDVXuzLXPnhcL6ypTkgXqi11Aca_EU';
        $jwtService = new JwtService($token, $this->jwt_rsa_public, $this->jwt_rsa_private, $this->jwt_expire);

        //是否举例10秒后过期
        $flag = $jwtService->isExpire(10);
        var_dump($flag);
        $this->assertIsBool($flag);

        //是否在1000000秒后过期
        $flag = $jwtService->isExpire(1000000);

        var_dump($flag);

        $this->assertIsBool($flag);
    }

    public function testIsLogin(){
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJqdGkiOiIxIiwiYXVkIjoiIiwiaWF0IjoxNTg5OTcwNjM1LCJleHAiOjE1OTI1NjI2MzUsImlzcyI6Imp3dCIsIm5hbWUiOiJqYW1lcyJ9.ZJszk-lpzUAlv7Kmxto4mlVi84Ibz7QKp8-IcQxkcwMePLVQBwUGVnSkPq_RKCJDKOpYrInQ301ZNj5xOpwssoa5M7t1rCx0NTkq57qK-F536Z8wjhC3LFC_uQJSHiM7xa0YJ1rVtBDwmBDVXuzLXPnhcL6ypTkgXqi11Aca_EU';
        $jwtService = new JwtService($token, $this->jwt_rsa_public, $this->jwt_rsa_private, $this->jwt_expire);

        $login = $jwtService->isLogin();

        var_dump($login);

        $this->assertIsBool($login);
    }

    public function testGetAllData(){
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJqdGkiOiIxIiwiYXVkIjoiIiwiaWF0IjoxNTg5OTcwNjM1LCJleHAiOjE1OTI1NjI2MzUsImlzcyI6Imp3dCIsIm5hbWUiOiJqYW1lcyJ9.ZJszk-lpzUAlv7Kmxto4mlVi84Ibz7QKp8-IcQxkcwMePLVQBwUGVnSkPq_RKCJDKOpYrInQ301ZNj5xOpwssoa5M7t1rCx0NTkq57qK-F536Z8wjhC3LFC_uQJSHiM7xa0YJ1rVtBDwmBDVXuzLXPnhcL6ypTkgXqi11Aca_EU';
        $jwtService = new JwtService($token, $this->jwt_rsa_public, $this->jwt_rsa_private, $this->jwt_expire);

        $tokenData = $jwtService->getAllData();

        var_dump((array)$tokenData);

        $this->assertIsBool(true);
    }

    public function testGetData(){
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJqdGkiOiIxIiwiYXVkIjoiIiwiaWF0IjoxNTg5OTcwNjM1LCJleHAiOjE1OTI1NjI2MzUsImlzcyI6Imp3dCIsIm5hbWUiOiJqYW1lcyJ9.ZJszk-lpzUAlv7Kmxto4mlVi84Ibz7QKp8-IcQxkcwMePLVQBwUGVnSkPq_RKCJDKOpYrInQ301ZNj5xOpwssoa5M7t1rCx0NTkq57qK-F536Z8wjhC3LFC_uQJSHiM7xa0YJ1rVtBDwmBDVXuzLXPnhcL6ypTkgXqi11Aca_EU';
        $jwtService = new JwtService($token, $this->jwt_rsa_public, $this->jwt_rsa_private, $this->jwt_expire);

        $name = $jwtService->getData('name');

        var_dump($name);

        $this->assertIsBool(true);
    }

}
