<?php

namespace Songyz\Common\Library;

/**
 * 雪花算法
 * Class Snowflake
 * @package Songyz\Common\Library
 * @author songyongzhan <574482856@qq.com>
 * @date 2021/1/16 15:32
 */
class Snowflake
{
    /**
     * 原理
     * ID由64bit组成
     *
     * 其中 第一个bit空缺
     * 41bit用于存放毫秒级时间戳
     *
     * 10bit用于存放机器id
     *
     * 12bit用于存放自增ID
     *
     * 除了最高位bit标记为不可用以外，其余三组bit占位均可浮动，
     * 看具体的业务需求而定。
     *
     * 默认情况下41bit的时间戳可以支持该算法使用到2082年，
     *
     * 10bit的工作机器id可以支持1023台机器，序列号支持1毫秒产生4095个自增序列id。
     *
     */
    private const EPOCH = 1610783561598;  //开始时间,固定一个小于当前时间的毫秒数
    private const max12bit = 4095;
    private const max41bit = 1099511627775;
    private static $machineId = null;

    public static function generateId($machineID = 0)
    {
        self::$machineId = $machineID;
        // 时间戳 42字节
        $time = floor(microtime(true) * 1000);
        // 当前时间 与 开始时间 差值
        $time -= self::EPOCH;
        // 二进制的 毫秒级时间戳
        $base = decbin(self::max41bit + $time);
        /*
        * Configured machine id - 10 bits - up to 1024 machines
        * 将机器码转换成二进制 如果不足10位，则在左侧用0补齐
        */
        $machineid = str_pad(decbin(self::$machineId), 10, "0", STR_PAD_LEFT);
        /*
        * sequence number - 12 bits - up to 4096 random numbers per machine
        * mt_rand 生成 0 到 4095 的随机数字，然后转换成二进制
        * 如果不足12位，在左侧通过0 补齐
        */
        $random = str_pad(decbin(mt_rand(0, self::max12bit)), 12, "0", STR_PAD_LEFT);
        /*
        * 将base.机器码.自动验证码 连接起来
        * 注：这是二进制数据
        */
        $base = $base . $machineid . $random;
        /*
        * Return unique time id no
        * 函数把二进制转换为十进制
        */
        return bindec($base);
    }
}