<?php

namespace Songyz\Common\Library;

/**
 * 常用工具包
 * Class Card
 * @package Songyz\Common\Library
 * @author songyz <574482856@qq.com>
 * @date 2020/5/20 10:48
 */
class Card
{
    /**
     * 根据身份证获取生日信息
     * getBirthDay
     * @param $idCard
     * @param string $delimiter
     * @return string
     *
     * @date 2020/5/20 23:49
     */
    function getBirthDay($idCard, $delimiter = '-')
    {
        if (!$idCard) {
            return '';
        }

        $year = substr($idCard, 6, 4);
        $month = substr($idCard, 10, 2);
        $day = substr($idCard, 12, 2);
        return $year . $delimiter . $month . $delimiter . $day;
    }

    /**
     * 解析身份证信息
     * getIdCardInfo
     * [1 => '男', 2 => '女', 0 => '未知']
     * @param string $idCard
     * @return array
     *
     * @date 2020/5/20 23:48
     */
    public static function idCardInfo(string $idCard)
    {
        $data = [
            'birthday_date' => '',
            'birthday_timestamp' => '',
            'gender' => '',
            'age' => 0,
        ];

        if (!is_id_card_no($idCard)) {
            return $data;
        }

        if (!empty($idCard)) {
            $idCardLen = strlen($idCard);
            if (18 == $idCardLen || 15 == $idCardLen) {
                $birthday = [
                    'birthday_year' => '',
                    'birthday_month' => '',
                    'birthday_day' => '',
                ];
                if (15 == $idCardLen) {
                    $birthday['birthday_year'] = 19 . substr($idCard, 6, 2);
                    $birthday['birthday_month'] = substr($idCard, 8, 2);
                    $birthday['birthday_day'] = substr($idCard, 10, 2);
                    $data['gender'] = substr($idCard, -1, 1) % 2 == 1 ? 1 : 2; // [1 => '男', 2 => '女', 0 => '未知'];
                } elseif (18 == $idCardLen) {
                    $birthday['birthday_year'] = substr($idCard, 6, 4);;
                    $birthday['birthday_month'] = substr($idCard, 10, 2);
                    $birthday['birthday_day'] = substr($idCard, 12, 2);
                    $data['gender'] = substr($idCard, -2, 1) % 2 == 1 ? 1 : 2;  // [1 => '男', 2 => '女', 0 => '未知'];
                }

                $data['birthday_date'] = $birthday['birthday_year'] . '-' . $birthday['birthday_month'] . '-' . $birthday['birthday_day'];
                $data['birthday_year'] = $birthday['birthday_year'];
                $data['birthday_month'] = $birthday['birthday_month'];
                $data['birthday_day'] = $birthday['birthday_day'];
                $data['birthday_timestamp'] = strtotime($data['birthday_date']);
                $data['age'] = (int)((time() - $data['birthday_timestamp']) / (86400 * 365));
            }
        }

        return $data;
    }
}
