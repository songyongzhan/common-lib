<?php

namespace Songyz\Common\Components\Traits;

use Songyz\Common\Library\Tools;

/**
 * 驼峰 下划线 相互转换
 * Trait SnakeCamelChange
 * @package Songyz\Common\Components\Traits
 */
trait SnakeCamelChangeTrait
{
    /**
     *
     * 下划线转驼峰转
     * dataCamel
     * @param $data
     * @return array
     *
     */
    public function dataCamel(array $data)
    {
        return Tools::dataCamel($data);
    }

    /**
     * 驼峰转下划线或其他字符
     * dataSnake
     * @param array $data
     * @param string $delimiter
     * @return array
     *
     */
    public function dataSnake(array $data, $delimiter = '_')
    {
        return Tools::dataSnake($data, $delimiter);
    }

}
