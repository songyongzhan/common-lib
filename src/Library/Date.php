<?php

namespace Songyz\Common\Library;


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
    public static function getCurrentDate($format = 'Y-m-d H:i:s', int $time = 0)
    {
        empty($time) && $time = time();
        return date($format, $time);
    }

    public static function formatWeekCN($date = null)
    {
        return '星期' . ['日', '一', '二', '三', '四', '五', '六'][date('w', $date === null ? time() : strtotime($date))];
    }

    public static function formatTimeCN($date = null)
    {
        return ['凌晨', '上午', '下午', '晚上'][floor(date('G', $date === null ? time() : strtotime($date)) / 6)];
    }


}
