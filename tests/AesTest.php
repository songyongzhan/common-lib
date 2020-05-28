<?php

namespace Songyz\Common\Tests\Jwt;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Jwt\JwtService;
use Songyz\Common\Library\Aes;
use Songyz\Common\Library\Rsa;
use function GuzzleHttp\default_user_agent;

class AesTest extends TestCase
{

    public function testEncrypt()
    {
        $str = 'james';
        $str = Aes::encrypt($str, '123');
        echo $str;
        $this->assertIsString($str);

    }

    public function testDe()
    {
        $str = 'NL7rrUNodNkSMvdBtDbob334VRnlM25/TPjkCcga9mE=';
        $data = Aes::decrypt($str, '123');
        var_dump($data);
        $this->assertIsString($data);
    }

}
