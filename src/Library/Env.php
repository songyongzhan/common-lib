<?php

namespace Songyz\Common\Library;

/**
 * Env 环境读取
 * Class Env
 * @package Songyz\Common\Library
 * @author songyongzhan <574482856@qq.com>
 */
class Env
{

    /**
     * 获取当前运行的环境
     * getRunEnv
     * @return string|null
     *
     * @author songyongzhan <574482856@qq.com>
     * @date 2021/4/28 16:28
     */
    public static function getRunEnv()
    {
        return self::getValueByEnvName('ENV.RUN_ENV') ?: 'development';
    }

    /**
     * 根据传入的字符串获取ini中的配置
     * getValueByName
     * @param string $name
     * @return string|null
     *
     * @author songyongzhan <574482856@qq.com>
     * @date 2021/4/28 16:31
     */
    public static function getValueByName(string $name)
    {
        return self::getValueByEnvName($name);
    }

    public static function isDevelopment()
    {
        return self::getRunEnv() === 'development';
    }

    public static function isTest()
    {
        return self::getRunEnv() === 'test';
    }

    /**
     * 判断是不是预发环境
     * isPreProduction
     * @return bool
     *
     * @author songyongzhan <574482856@qq.com>
     * @date 2021/4/28 16:32
     */
    public static function isPreProduction()
    {
        return self::getRunEnv() === 'pre-production';
    }

    /**
     * 判断是不是生产环境
     * isProduction
     * @return bool
     *
     * @author songyongzhan <574482856@qq.com>
     * @date 2021/4/28 16:31
     */
    public static function isProduction()
    {
        return self::getRunEnv() === 'production';
    }


    /**
     * 获取php.ini中的配置
     * getValueByEnvName
     * @param string $envName
     * @return string|null
     *
     * @author songyongzhan <574482856@qq.com>
     * @date 2021/4/28 16:27
     */
    private static function getValueByEnvName(string $envName): ?string
    {
        if (empty($envName)) {
            throw new InvalidArgumentException('环境配置名不能为空');
        }

        $value = get_cfg_var($envName);

        return false !== $value ? $value : null;
    }


}
