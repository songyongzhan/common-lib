<?php

namespace Songyz\Common\Tests;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Library\Tools;
use Songyz\Common\Library\Tree;

class TreeTest extends TestCase
{
    private $data = [
        ['id' => 1, 'title' => '苹果', 'pid' => 0, 'sort_id' => 2],
        ['id' => 2, 'title' => '小米', 'pid' => 0, 'sort_id' => 1],
        ['id' => 3, 'title' => '华为', 'pid' => 0, 'sort_id' => 3],
        ['id' => 4, 'title' => 'iphone6', 'pid' => 1, 'sort_id' => 2],
        ['id' => 11, 'title' => 'iphone6 plus', 'pid' => 4, 'sort_id' => 2],
        ['id' => 5, 'title' => 'iphone7', 'pid' => 1, 'sort_id' => 3],
        ['id' => 6, 'title' => 'iphone5', 'pid' => 1, 'sort_id' => 1],
        ['id' => 7, 'title' => 'iphone9', 'pid' => 1, 'sort_id' => 4],
        ['id' => 8, 'title' => '小米充气泵', 'pid' => 2, 'sort_id' => 1],
        ['id' => 9, 'title' => '小米音响', 'pid' => 2, 'sort_id' => 2],
        ['id' => 10, 'title' => 'nova', 'pid' => 3, 'sort_id' => 0],
    ];


    public function testGetSuns()
    {
        $result = Tree::getSuns($this->data, '1');
        $result = Tree::menuSortBy($result, 'sort_id', 'asc');

        print_r($result);
        $this->assertIsBool(true);
    }

    /**
     * 从数据中拿到以某一个值为首的所有子类
     * testGetMenuGroupListById
     * @throws \Exception
     *
     * @author songyongzhan <574482856@qq.com>
     * @date 2021/2/3 13:49
     */
    public function testGetMenuGroupListById(){
        $result = Tree::GetMenuGroupListById($this->data,2);
        print_r($result);

        $this->assertIsBool(true);
    }

    /**
     * 将级联层级的结构 处理成一维数组
     * testGetMenuListByGroupList
     * @throws \Exception
     *
     * @author songyongzhan <574482856@qq.com>
     * @date 2021/2/3 13:48
     */
    public function testGetMenuListByGroupList(){
        $result = Tree::GetMenuGroupListById($this->data,1);
        $data = Tree::getMenuLevelListByGroupList($result);
        print_r($data);

        $this->assertIsBool(true);

    }

    public function testGetSunIds()
    {
        $result = Tree::getSunIds($this->data, '1');

        print_r($result);
        $this->assertIsBool(true);
    }

    public function testMenuGroupList()
    {
        $data = $this->data;
        $data = Tree::menuSortBy($data, 'sort_id', 'asc');

        $result = Tree::menuGroupList($data);

        print_r($result);
        $this->assertIsBool(true);
    }

    public function testMenuList()
    {
        $result = Tree::menuList($this->data);

        print_r($result);
        $this->assertIsBool(true);
    }


    public function testGetParent()
    {
        $result = Tree::getParent($this->data, 11);
        $result = array_reverse($result);

        print_r($result);
        $this->assertIsBool(true);
    }

}
