<?php

namespace Songyz\Common\Tests;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Jwt\JwtService;
use Songyz\Common\Library\Aes;
use Songyz\Common\Library\Captcha;
use Songyz\Common\Library\Card;
use Songyz\Common\Library\Rsa;
use function GuzzleHttp\default_user_agent;

class CardTest extends TestCase
{

    public function testCreateImg()
    {
        $idCardInfo = Card::idCardInfo("130182198411201911");
        print_r($idCardInfo);

        $birthDay = Card::getBirthDay("130182198411201911", "/");
        print_r($birthDay);
    }


}
