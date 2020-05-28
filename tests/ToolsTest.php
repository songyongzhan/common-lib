<?php

namespace Songyz\Common\Tests\Jwt;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Components\Jwt\JwtService;
use Songyz\Common\Library\Tools;

class ToolsTest extends TestCase
{
    public function testSnake()
    {
        $str = Tools::snake('userName');
        echo $str;
        $this->assertIsBool(true);

    }

    public function testArrayMultiSort()
    {
         $arr = array(
            '0' => array(
                'id' => 3,
                'age' => 27,
            ),
            '1' => array(
                'id' => 5,
                'age' => 50,
            ),
            '2' => array(
                'id' => 4,
                'age' => 44,
            ),
            '3' => array(
                'id' => 1,
                'age' => 78,
            ),
        );

        $data = Tools::arrayMultiSort($arr, 'id', SORT_ASC, 'age', SORT_DESC);
        echo "<pre style='color:blue;font-size:14px;'>";
        echo 'file:' . __FILE__ . ' line:' . __LINE__;
        print_r($data);
        echo "</pre>";
        exit;
    }

    public function testCamel()
    {
        echo Tools::camel('user_name');

        $this->assertIsBool(true);
    }

    public function testDataSnake()
    {

        $data = array(
            'user_name' => 'james',
            'home_address' => 'beijingZhuShiKou',
            'extends' =>
                array(
                    'info_age' => 14,
                    'info_computer' => '苹果',
                    'info_version' => 'verDomV4',
                ),
        );
//        $data = array(
//            'userName' => 'james',
//            'homeAddress' => 'beijing_zhuShiKou',
//            'extends' =>
//                array(
//                    'infoAge' => 14,
//                    'infoComputer' => '苹果',
//                    'infoVersion' => 'ver_dom_v4',
//                ),
//        );

        $result = Tools::dataSnake($data, '_', 'val');

        echo "<pre style='color:blue;font-size:14px;'>";
        echo 'file:' . __FILE__ . ' line:' . __LINE__;
        var_export($result);
        echo "</pre>";

        $this->assertIsBool(true);
    }

    public function testDataCamel()
    {
        $data = [
            'user_name' => 'james',
            'home_address' => 'beijing_zhuShiKou',
            'extends' => [
                'info_age' => 14,
                'info_computer' => '苹果',
                'info_version' => 'ver_dom_v4'
            ]
        ];

        $result = Tools::dataCamel($data, 'val');

        echo "<pre style='color:blue;font-size:14px;'>";
        echo 'file:' . __FILE__ . ' line:' . __LINE__;
        var_export($result);
        echo "</pre>";

        $this->assertIsBool(true);
    }

    public function testGetDataByKey()
    {
        $data = [
            'user_name' => 'james',
            'home_address' => 'beijing_zhuShiKou',
            'extends' => [
                'info_age' => 14,
                'info_computer' => '苹果',
                'info_version' => 'ver_dom_v4'
            ]
        ];

        $result = Tools::getDataByKey('extends.info_computer', $data);
        print_r($result);

        $result = Tools::getDataByKey('abc', $data);
        var_dump($result);
        $this->assertEmpty($result);

    }

}
