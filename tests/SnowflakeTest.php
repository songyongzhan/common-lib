<?php

namespace Songyz\Common\Tests;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Jwt\JwtService;
use Songyz\Common\Library\Aes;
use Songyz\Common\Library\Rsa;
use Songyz\Common\Library\Snowflake;
use function GuzzleHttp\default_user_agent;

class SnowflakeTest extends TestCase
{

    public function testId()
    {
        for ($i = 1; $i <= 100; $i++) {
            $generateId = Snowflake::generateId(0);
            echo "  ID长度: " . strlen($generateId) . "  ID: " . $generateId . "\n";
        }
    }

}
