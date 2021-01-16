<?php

namespace Songyz\Common\Tests;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Jwt\JwtService;
use Songyz\Common\Library\Aes;
use Songyz\Common\Library\Captcha;
use Songyz\Common\Library\Rsa;
use function GuzzleHttp\default_user_agent;

class CaptchaTest extends TestCase
{

    public function testCreateImg()
    {
        $img = Captcha::createImg("1234");
        print_r($img);
    }


}
