<?php

namespace Songyz\Common\Library;

/**
 * 用户api请求 返回动态验证码
 * Class Captcha
 * @package Songyz\Common\Library
 * @author songyongzhan <574482856@qq.com>
 */
class Captcha
{
    /**
     * 生产接口需要的图片验证码
     * createImg
     * @param string $code
     * @param int $width
     * @param int $height
     * @param int $len
     * @param bool $border
     * @param string $fontPath
     * @return array
     * @throws \Exception
     *
     * @author songyongzhan <574482856@qq.com>
     * @date 2021/1/16 10:51
     */
    public static function createImg($code = '', $width = 70, $height = 25, $len = 4, $border = false, $fontPath = '')
    {
        if (!$code) { //create_captcha
            for ($i = 0; $i < $len; $i++) {
                $code .= dechex(mt_rand(0, 15));
            }
        }

        empty($fontPath) && $fontPath = dirname(__FILE__) . '/font/calibril.ttf';

        if (!file_exists($fontPath)) {
            throw new \Exception("fontPath指定的文件不存在");
        }

        $img = imagecreatetruecolor($width, $height);
        imagefill($img, 0, 0, imagecolorallocate($img, 255, 255, 255));

        for ($i = 0; $i < 10; $i++) { //干扰线
            $color = imagecolorallocate($img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            imageline($img, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $color);
        }

        for ($i = 0; $i < 200; $i++) { //背景
            $color = imagecolorallocate($img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
            imagestring($img, 1, mt_rand(1, $width), mt_rand(1, $height), '*', $color);
        }

        $size = $width / $len - 3;
        for ($i = 0; $i < strlen($code); $i++) { //验证码
            $color = imagecolorallocate($img, mt_rand(0, 100), mt_rand(0, 150), mt_rand(0, 200));

            imagettftext($img, $size, mt_rand(-50, 50), $i * $size + 5, $height - 5, $color
                , $fontPath, $code[$i]);
        }

        if ($border) { //黑色边框
            imagerectangle($img, 0, 0, $width - 1, $height - 1, imagecolorallocate($img, 0, 0, 0));
        }

        ob_start();
        imagepng($img);
        $result = ob_get_contents();
        ob_end_clean();
        imagedestroy($img);

        return ['createTime' => time(), 'image' => 'data:image/png;base64,' . base64_encode($result)];
    }
}

