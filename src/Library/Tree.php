<?php

namespace Songyz\Common\Library;

/**
 * 解决栏目菜单相关问题
 * Class Tree
 * @package Songyz\Common\Library
 * @author songyz <574482856@qq.com>
 * @date 2020/5/20 10:48
 */
class Tree
{
    /**
     * 以分组的形式展示
     * menuGroupList
     * @param $data
     * @param int $pid
     * @param string $primaryKey
     * @param string $parent_name
     * @param string $sun_name
     * @return array
     *
     * @author songyz <574482856@qq.com>
     * @date 2020/5/20 21:58
     */
    public static function menuGroupList($data, $pid = 0, $primaryKey = 'id', $parent_name = 'pid', $sun_name = 'sun')
    {
        if (empty($data)) {
            return [];
        }
        $result = [];
        foreach ($data as $key => $val) {
            if ($val[$parent_name] == $pid) {
                $temp = self::menuGroupList($data, $val[$primaryKey], $primaryKey, $parent_name, $sun_name);
                count($temp) > 0 ? $val[$sun_name] = $temp : $val[$sun_name] = [];
                $result[] = $val;
            }
        }
        return $result;
    }

    /**
     * 根据根据id 获取data中 id 及子类下所有的类目
     * menuGroupListById
     * @param $data
     * @param $id
     * @param string $primaryKey
     * @param string $parent_name
     * @param string $sun_name
     * @param string $sortFields
     * @param string $sortType
     * @return array
     * @throws \Exception
     *
     * @author songyongzhan <574482856@qq.com>
     * @date 2021/2/3 13:25
     */
    public static function getMenuGroupListById(
        $data,
        $id,
        $primaryKey = 'id',
        $parent_name = 'pid',
        $sun_name = 'sun',
        $sortFields = 'sort_id',
        $sortType = 'asc'
    ) {

        $result = self::getSuns($data, $id, $parent_name, $primaryKey);
        $result = self::menuSortBy($result, $sortFields, $sortType);

        $keys = array_column($data, $primaryKey);
        $data = array_combine($keys, $data);
        $first = $data[$id] ?? [];
        if (empty($first)) {
            throw new \Exception("没有找到{$id}对应的数据");
        }
        array_unshift($result, $first);

        return self::menuGroupList($result, $first['pid'], $primaryKey, $parent_name, $sun_name);
    }

    /**
     * 分组级联的数据结构 拆分成简单一维数组
     * getMenuListByGroupList
     *
     * @param $data
     * @param string $sun_name
     * @param string $levelName
     * @param int $level
     * @return array
     * @author songyongzhan <574482856@qq.com>
     * @date 2021/2/3 13:32
     */
    public static function getMenuLevelListByGroupList($data, $sun_name = 'sun', $levelName = 'level', $level = 0)
    {
        $result = [];
        foreach ($data as $key => $val) {
            $sunData = $val[$sun_name] ?? [];
            if (isset($val[$sun_name])) {
                unset($val[$sun_name]);
            }
            $val[$levelName] = $level;
            $result[] = $val;
            if ($sunData) {
                $result = array_merge($result,
                    self::getMenuLevelListByGroupList($sunData, $sun_name, $levelName, ++$level));
            }
        }

        return $result;
    }


    /**
     * 按照step显示栏目
     * menuList
     * @param $data
     * @param int $pid
     * @param string $primaryKey
     * @param string $parent_name
     * @param int $step
     * @return array
     *
     * @author songyz <574482856@qq.com>
     * @date 2020/5/20 21:58
     */
    public static function menuList($data, $pid = 0, $primaryKey = 'id', $parent_name = 'pid', $step = 0)
    {
        if (empty($data)) {
            return [];
        }
        $result = [];
        foreach ($data as $key => $val) {
            if ($val[$parent_name] == $pid) {
                $val['step'] = $step;
                $result[] = $val;
                $result = array_merge($result,
                    self::menuList($data, $val[$primaryKey], $primaryKey, $parent_name, $step + 1));
            }
        }
        return $result;
    }

    /**
     * 子类获取父级所有栏目
     * getParent
     * @param $data
     * @param $currentId
     * @param string $primaryKey
     * @param string $parentName
     * @return array
     *
     * @author songyz <574482856@qq.com>
     * @date 2020/5/20 21:58
     */
    public static function getParent($data, $currentId, $primaryKey = 'id', $parentName = 'pid')
    {
        if (empty($data)) {
            return [];
        }
        $result = [];
        foreach ($data as $key => $val) {
            if ($val[$primaryKey] == $currentId) {
                $result[] = $val;
                $result = array_merge($result, self::getParent($data, $val[$parentName], $primaryKey, $parentName));
            }
        }

        return $result;
    }

    /**
     * 按照字段排序
     * menuSortBy
     * @param $data
     * @param string $sortFields
     * @param string $sortType
     * @return mixed
     *
     * @author songyz <574482856@qq.com>
     * @date 2020/5/20 21:57
     */
    public static function menuSortBy($data, $sortFields = 'sort_id', $sortType = 'asc')
    {
        if ($sortType == 'asc') {
            usort($data, function ($a, $b) use ($sortFields) {
                if ($a[$sortFields] == $b[$sortFields]) {
                    return 0;
                }
                return ($a[$sortFields] < $b[$sortFields]) ? -1 : 1;
            });
        } else {
            usort($data, function ($a, $b) use ($sortFields) {
                if ($a[$sortFields] == $b[$sortFields]) {
                    return 0;
                }
                return ($a[$sortFields] < $b[$sortFields]) ? 1 : -1;
            });
        }

        return $data;
    }


    /**
     * 根据pid获取到子类所有id
     * getSunIds
     * @param array $data
     * @param string $pid
     * @param string $pidField
     * @param string $idField
     * @return array
     *
     * @author songyz <574482856@qq.com>
     * @date 2020/5/20 22:06
     */
    public static function getSunIds(array $data, string $pid, string $pidField = 'pid', string $idField = 'id')
    {
        $result = [];
        foreach ($data as $key => $val) {
            if ($val[$pidField] == $pid) {
                $result[] = $val[$idField];
                $result = array_merge(self::getSunIds($data, $val[$idField], $pidField, $idField), $result);
            }
        }

        return $result;
    }

    /**
     * 获取子类列表
     * getSuns
     * @param array $data
     * @param string $pid
     * @param string $pidField
     * @param string $idField
     * @return array
     *
     * @author songyz <574482856@qq.com>
     * @date 2020/5/20 22:35
     */
    public static function getSuns(array $data, string $pid, $pidField = 'pid', $idField = 'id')
    {
        $result = [];
        foreach ($data as $key => $val) {
            if ($val[$pidField] == $pid) {
                $result[] = $val;
                $result = array_merge($result,
                    self::getSuns($data, $val[$idField], $pidField, $idField));
            }
        }

        return $result;
    }


}
