<?php

namespace Songyz\Common\Tests;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Traits\HttpClientTrait;
use Songyz\Common\Components\Traits\SnakeCamelChangeTrait;
use Songyz\Common\Library\Test;
use Songyz\Common\Library\Tools;

class HttpClientTraitTest extends TestCase
{
    use HttpClientTrait, SnakeCamelChangeTrait;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);


        $this->host = 'https://admin.xiaosongit.com';
        $this->headers = [
            'content-type' => 'application/json',
//            'content-type' => 'application/x-www-form-urlencoded',
//            'content-type' => 'multipart/form-data',
            'X-Requested-With' => 'XMLHttpRequest',
            // your other header
        ];
    }

    public function testCheckToken()
    {
        $result = $this->checkToken();
        $result = json_decode($result,true);
        $result['user_name'] = 'james';
        Tools::p($result);
        print_r($this->dataCamel($result));
        $this->assertIsString($result);
    }

    public function checkToken()
    {
        $data = $this->fetchPost('/api/manage/checktoken', []);

        return $data;
    }

    public function fetchAfter($data)
    {
        return $data['contents'];
    }

}
