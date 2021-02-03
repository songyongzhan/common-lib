<?php

namespace Songyz\Common\Library;

/**
 * 时间工具类
 * Class Date
 * @package Songyz\Common\Library
 * @author songyongzhan <574482856@qq.com>
 * @date 2021/1/16 15:31
 */
class Date
{
    /**
     * 获取当前时间
     * getCurrentDate
     * @param string $format
     * @param int $time
     * @return false|string
     *
     * @date 2020/5/20 23:01
     */
    public static function getCurrentDate($format = 'Y-m-d', int $time = 0)
    {
        empty($time) && $time = time();
        return date($format, $time);
    }

    /**
     *
     * getDateTime
     * @param string $format
     * @param int $time
     * @return false|string
     *
     * @author songyongzhan <574482856@qq.com>
     * @date 2020/5/20 23:01
     */
    public static function getDateTime($format = 'Y-m-d H:i:s', int $time = 0)
    {
        empty($time) && $time = time();
        return date($format, $time);
    }

    /**
     * 返回当前时间的星期
     * formatWeekCN
     * @param null $date
     * @return string
     *
     * @author songyongzhan <574482856@qq.com>
     * @date 2021/2/3 14:10
     */
    public static function formatWeekCN($date = null)
    {
        return '星期' . ['日', '一', '二', '三', '四', '五', '六'][date('w', $date === null ? time() : strtotime($date))];
    }

    /**
     * 返回当前时间时间段
     * formatTimeCN
     * @param null $date
     * @return string
     *
     * @author songyongzhan <574482856@qq.com>
     */
    public static function formatTimeCN($date = null)
    {
        return ['凌晨', '上午', '下午', '晚上'][floor(date('G', $date === null ? time() : strtotime($date)) / 6)];
    }

    /**
     * 返回2个时间相差的天数
     * timeDifference
     * @param $startTime
     * @param $endTime
     * @return false|float
     *
     * @author songyongzhan <574482856@qq.com>
     */
    public static function timeDifference($startTime, $endTime)
    {
        $cle = strtotime($startTime) - strtotime($endTime);

        return ceil($cle / 3600 / 24);
    }

}
