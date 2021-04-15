<?php

namespace Songyz\Common\Tests;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Library\Str;

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
