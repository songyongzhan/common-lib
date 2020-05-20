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
    public static function menuGroupList($data, $pid = 0, $primaryKey = 'id', $parent_name = 'pid', $sun_name = 'sun')
    {
        if (empty($data)) {
            return [];
        }
        $result = [];
        foreach ($data as $key => $val) {
            if ($val[$parent_name] == $pid) {
                $temp = self::menuGroupList($data, $val[$primaryKey]);
                count($temp) > 0 ? $val[$sun_name] = $temp : '';
                $result[] = $val;
            }
        }
        return $result;
    }

    public static function menuList($data, $pid = 0, $primaryKey = 'id', $parent_name = 'pid', $rank = 0)
    {
        if (empty($data)) {
            return [];
        }
        $result = [];
        foreach ($data as $key => $val) {
            if ($val[$parent_name] == $pid) {
                $val['rank'] = $rank;
                $result[] = $val;
                $result = array_merge($result,
                    self::menuList($result, $val[$primaryKey], $primaryKey, $parent_name, $rank + 1));
            }
        }
        return $result;
    }

    /**
     *
     * getParent
     * @param $data
     * @param $currentId
     * @param string $primaryKey
     * @param string $parentName
     * @return array
     *
     * @date 2020/5/20 13:59
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

    public static function menuSortBySortId($data, $sortFields = 'sort_id', $sortType = 'asc')
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


}
