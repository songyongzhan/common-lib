<?php

namespace Songyz\Common\Test;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Traits\HttpClientAsyncTrait;
use Songyz\Common\Components\Traits\HttpClientTrait;
use Songyz\Common\Components\Traits\SnakeCamelChangeTrait;
use Songyz\Common\Library\Test;
use Songyz\Common\Library\Tools;

class HttpClientAsyncTraitTest extends TestCase
{
    use HttpClientAsyncTrait, SnakeCamelChangeTrait;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);


        $this->host = 'http://127.0.0.1:8888';
        $this->headers = [
            'content-type' => 'application/json',
//            'content-type' => 'application/x-www-form-urlencoded',
//            'content-type' => 'multipart/form-data',
            'X-Requested-With' => 'XMLHttpRequest',
            // your other header
        ];

        //设置接口请求超时
        $this->setClientConfig('timeout', 3);
        //不验证ssl
        $this->setClientConfig('verify', false);
    }

    public function testCheckToken()
    {
        $result = $this->checkAddUser();
        echo microtime(true);


        //获取请求code
        $code = $result->wait()->getStatusCode();
        Tools::p($code);
        //获取内容 只能获取一次，第二次获取是空值
        $contentStr = $result->wait()->getBody()->getContents();

        //获取headers
        Tools::p($result->wait()->getHeaders());

        echo microtime(true);

        $content = json_decode($contentStr, true);
        $content['user_name'] = 'james';
        Tools::p($content);

        print_r($this->dataCamel($content));
        
        $this->assertIsString($contentStr);
    }

    public function checkAddUser()
    {
        $data = $this->fetchPost('/open/ca/addUser', []);

        return $data;
    }
}
