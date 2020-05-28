<?php

namespace Songyz\Common\Tests\Jwt;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Jwt\JwtService;
use Songyz\Common\Library\Aes;
use Songyz\Common\Library\Des;
use Songyz\Common\Library\Rsa;
use function GuzzleHttp\default_user_agent;

class DesTest extends TestCase
{

    public function testEncrypt()
    {
        $str = 'james';
        $str = Des::encrypt($str, '123');
        echo $str;
        //mYUq4Al/TKs=
        $this->assertIsString($str);

    }


    public function testDe()
    {
        $str = 'mYUq4Al/TKs=';
        $data = Des::decrypt($str, '123');
        var_dump($data);
        $this->assertIsString($data);
    }

}
