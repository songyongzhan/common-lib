<?php


namespace Songyz\Common\Tests\Jwt;

use PHPUnit\Framework\TestCase;
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
        ['id' => 8, 'title' => '小米', 'pid' => 2, 'sort_id' => 1],
        ['id' => 9, 'title' => '红米', 'pid' => 2, 'sort_id' => 2],
        ['id' => 10, 'title' => 'nova', 'pid' => 3, 'sort_id' => 0],
    ];


    public function testGetSuns(){
        $result = Tree::getSuns($this->data,'1');
        $result = Tree::menuSortBy($result, 'sort_id', 'asc');

        print_r($result);
        $this->assertIsBool(true);
    }

    public function testGetSunIds(){
        $result = Tree::getSunIds($this->data,'1');

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
