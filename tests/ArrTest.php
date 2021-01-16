<?php

namespace Songyz\Common\Tests;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Jwt\JwtService;
use Songyz\Common\Library\Aes;
use Songyz\Common\Library\Arr;
use Songyz\Common\Library\Captcha;
use Songyz\Common\Library\Card;
use Songyz\Common\Library\Rsa;
use function GuzzleHttp\default_user_agent;

class ArrTest extends TestCase
{

    public function testArrAll()
    {

        $data = [
            "one"   => "苹果",
            "two"   => "香蕉",
            "three" => [
                "four" => "橘子",
                "five" => "芒果",
            ]
        ];

        //只能判断单个元素 不能使用 . 连缀的形式
        // var_dump(Arr::has($data, 'one'));
        // var_dump(Arr::exists($data, "three"));

        //返回最后一个、第一个元素
        // var_dump(Arr::last($data));
        // var_dump(Arr::first($data));

        //可以连缀删除
        // var_dump(Arr::del($data, "three.five"));
        // var_dump(Arr::get($data, "three"));
        // var_dump(Arr::get($data, "three.five"));


        // 在最前面插入一个元素 需要接受返回值
        // $data = Arr::prepend($data, "樱桃", "ten");
        // var_dump($data);

        $data = Arr::add($data, "nine","荔枝");
        var_dump($data);


        $this->assertIsBool(true);

    }


}
