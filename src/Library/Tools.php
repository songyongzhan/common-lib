<?php

namespace Songyz\Common\Library;

/**
 * 常用工具包
 * Class Tree
 * @package Songyz\Common\Library
 * @author songyz <574482856@qq.com>
 * @date 2020/5/20 10:48
 */
class Tools
{
    /**
     * ip转换成数字
     * ipToLong
     * @param $ip
     * @return string
     *
     * @date 2020/5/20 14:20\
     */
    public static function ipToLong($ip)
    {
        return sprintf('%u', ip2long($ip));
    }

    /**
     * 搜索条件拼接
     * getWhereCondition
     * @param $field
     * @param $val
     * @param string $operator
     * @param string $condition
     * @return array
     *
     * @date 2020/5/20 14:29
     */
    public static function getWhereCondition($field, $val, $operator = '=', $condition = 'AND')
    {
        return [
            'field' => trim($field),
            'val' => $val,
            'operator' => $operator,
            'condition' => $condition,
        ];
    }

}
