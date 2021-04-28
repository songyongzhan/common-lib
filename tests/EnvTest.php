<?php

namespace Songyz\Common\Tests;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Jwt\JwtService;
use Songyz\Common\Library\Aes;
use Songyz\Common\Library\Rsa;
use function GuzzleHttp\default_user_agent;

class EnvTest extends TestCase
{

    public function testRunEnv()
    {
        $str = \Songyz\Common\Library\Env::getRunEnv();
        echo $str;
        $this->assertIsString($str);

    }

    public function testGetName()
    {

        $data = \Songyz\Common\Library\Env::getValueByName('yaf.library');
        var_dump($data);
        $this->assertIsString($data);
    }

}
