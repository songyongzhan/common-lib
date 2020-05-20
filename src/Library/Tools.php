<?php

namespace Songyz\Common\Library;

/**
 * 常用工具包
 * Class Tools
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
     * @date 2020/5/20 14:20
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

    /**
     * 获取当前时间
     * getCurrentDate
     * @param string $format
     * @return false|string
     *
     * @date 2020/5/20 23:01
     */
    public static function getCurrentDate($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }

    /**
     * 字符脱敏输出
     * desensitizeStr
     * @param $str
     * @param $firstNumber
     * @param $lastNumber
     * @param string $replaceChar
     * @return string
     *
     * @date 2020/5/20 22:59
     */
    public static function desensitizeStr($str, $firstNumber, $lastNumber, $replaceChar = '*')
    {
        $first = $firstNumber == 0 ? '' : mb_substr($str, 0, $firstNumber);
        $last = $lastNumber == 0 ? '' : mb_substr($str, -$lastNumber, $lastNumber);
        $result = $first;
        $result .= str_repeat($replaceChar, mb_strlen($str) - $firstNumber - $lastNumber);
        $result .= $last;

        return $result;
    }


    /**
     * 数字转大写
     * numberToChinese
     * @param $num
     * @return mixed|string
     *
     * @date 2020/5/20 22:51
     */
    public static function numberToChinese($num)
    {
        $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $chiUni = array('', '十', '百', '千', '万', '亿', '十', '百', '千');
        $num_str = (string)$num;
        $count = strlen($num_str);
        $last_flag = true; //上一个 是否为0
        $zero_flag = true; //是否第一个
        $temp_num = null; //临时数字
        $chiStr = '';//拼接结果
        if ($count == 2) {//两位数
            $temp_num = $num_str[0];
            $chiStr = $temp_num == 1 ? $chiUni[1] : $chiNum[$temp_num] . $chiUni[1];
            $temp_num = $num_str[1];
            $chiStr .= $temp_num == 0 ? '' : $chiNum[$temp_num];
        } else {
            if ($count > 2) {
                $index = 0;
                for ($i = $count - 1; $i >= 0; $i--) {
                    $temp_num = $num_str[$i];
                    if ($temp_num == 0) {
                        if (!$zero_flag && !$last_flag) {
                            $chiStr = $chiNum[$temp_num] . $chiStr;
                            $last_flag = true;
                        }
                    } else {
                        $chiStr = $chiNum[$temp_num] . $chiUni[$index % 9] . $chiStr;
                        $zero_flag = false;
                        $last_flag = false;
                    }
                    $index++;
                }
            } else {
                $chiStr = $chiNum[$num_str[0]];
            }
        }

        return $chiStr;
    }

    /**
     * 下划线转驼峰
     * camel
     * @param $value
     * @return string
     *
     * @date 2020/5/20 23:26
     */
    public static function camel($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        return lcfirst(str_replace(' ', '', $value));
    }

    /**
     * 驼峰转下划线 指定分隔符
     * snake
     * @param $value
     * @param string $delimiter
     *
     * @date 2020/5/20 23:30
     * @return string|string[]|null
     */
    public static function snake($value, $delimiter = '_')
    {
        $value = preg_replace('/\s+/u', '', ucwords($value));
        $value = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value));

        return $value;
    }


    /**
     * 设置数组键值前缀
     * addArrayPrefix
     * @param array $array
     * @param string $prefix
     * @param string $addPrefixType 默认加前缀的是key  也可以改成val
     * @param string $field //如果是二维数组 则指定的key加前缀
     * @param string $expectDot 如果里面包含字符指定 则不进行前缀添加
     * @return array
     *
     * @author songyz <songyz@guahao.com>
     * @date 2020/2/5 12:20
     */
    public static function addArrayPrefix(
        array $array,
        $prefix = '',
        $addPrefixType = 'key',
        $field = '',
        $expectDot = '.'
    ) {
        if (empty($array)) {
            return [];
        }

        $new_arr = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {

                if (!empty($field) && isset($value[$field])) {
                    if ($addPrefixType == 'val') {
                        $value[$field] = stripos($value[$field],
                            $expectDot) ? $value[$field] : $prefix . str_replace($prefix, '', $value[$field]);
                        $new_arr[$key] = $value;
                    } else {
                        if (!stripos($value[$field], $expectDot)) {
                            $value[$prefix . str_replace($prefix, '', $field)] = $value[$field];
                            unset($value[$field]);
                        }
                        $new_arr[$key] = $value;
                    }
                } else {
                    $new_arr = $value;
                }

            } else {
                if ($addPrefixType == 'val') {
                    $new_arr[$key] = stripos($value, $expectDot) ? $value : $prefix . str_replace($prefix, '', $value);
                } else {
                    $vKey = stripos($value, $expectDot) ? $key : $prefix . str_replace($prefix, '', $key);
                    $new_arr[$vKey] = $value;
                }
            }
        }
        return $new_arr;
    }


    /**
     * 时间比较函数，返回两个日期相差几秒、几分钟、几小时或几天
     * @param  $date1 日期1   2015-10-20
     * @param  $date2 日期2   2014-11-22
     * @param string $unit 比较类型秒、分钟、小时、天
     * @return float|int|string
     * @author wangjiacheng
     */
    public static function dateDiff($date1, $date2, $unit = 'd')
    {
        switch ($unit) {
            case 's':
                $dividend = 1;
                break;
            case 'i':
                $dividend = 60;
                break;
            case 'h':
                $dividend = 3600;
                break;
            case 'd':
                $dividend = 86400;
                break;
            default:
                $dividend = 86400;
        }
        $time1 = strtotime($date1);
        $time2 = strtotime($date2);

        if ($time1 && $time2) {
            return (float)($time1 - $time2) / $dividend;
        }

        return '';
    }

    /**
     * 数据XML编码
     * @param mixed $data 数据
     * @param string $item 数字索引时的节点名称
     * @param string $id 数字索引key转换为的属性名
     * @return string
     */
    public static function dataToXml($data, $item = 'item', $id = 'id')
    {
        $xml = $attr = '';
        foreach ($data as $key => $val) {
            if (is_numeric($key)) {
                $id && $attr = " {$id}=\"{$key}\"";
                $key = $item;
            }
            $xml .= "<{$key}{$attr}>";
            $xml .= (is_array($val) || is_object($val)) ? self::dataToXml($val, $item, $id) : $val;
            $xml .= "</{$key}>";
        }

        return $xml;
    }

    /**
     * XML编码
     * @param mixed $data 数据
     * @param string $root 根节点名
     * @param string $item 数字索引的子节点名
     * @param string $attr 根节点属性
     * @param string $id 数字索引子节点key转换的属性名
     * @param string $encoding 数据编码
     * @return string
     */
    public static function xmlEncode($data, $root = 'root', $item = 'item', $attr = '', $id = 'id', $encoding = 'utf-8')
    {
        if (is_array($attr)) {
            $_attr = array();
            foreach ($attr as $key => $value) {
                $_attr[] = "{$key}=\"{$value}\"";
            }
            $attr = implode(' ', $_attr);
        }
        $attr = trim($attr);
        $attr = empty($attr) ? '' : " {$attr}";
        $xml = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
        $xml .= "<{$root}{$attr}>";
        $xml .= self::dataToXml($data, $item, $id);
        $xml .= "</{$root}>";
        return $xml;
    }


}