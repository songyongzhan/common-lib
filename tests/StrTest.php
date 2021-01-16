<?php

namespace Songyz\Common\Tests;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Jwt\JwtService;
use Songyz\Common\Library\Aes;
use Songyz\Common\Library\Arr;
use Songyz\Common\Library\Captcha;
use Songyz\Common\Library\Card;
use Songyz\Common\Library\Rsa;
use Songyz\Common\Library\Str;
use function GuzzleHttp\default_user_agent;

class StrTest extends TestCase
{

    public function testStrAll()
    {
        $random = Str::random(6, 3);
        var_dump($random);

        $str = "wyuion";

        var_dump(Str::contains($str,"so"));

        var_dump(Str::upper($str));


        $this->assertIsBool(true);

    }


}
