<?php

namespace Songyz\Common\Tests\Jwt;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Jwt\JwtService;
use Songyz\Common\Library\Tools;

class ToolsTest extends TestCase
{
    public function testSnake(){
        $str=Tools::snake('userName');
        echo $str;
        $this->assertIsBool(true);

    }


    public function testCamel(){
       echo Tools::camel('user_name');

       $this->assertIsBool(true);
    }
}
