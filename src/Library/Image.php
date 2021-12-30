<?php

namespace Songyz\Common\Library;

class Image
{

    /**
     * 文件到base64
     * fileToBase64
     * @param string $file
     * @param bool $urlSafe url传输是否安全
     * @return string
     *
     * @date 2021/12/30 13:52
     */
    public static function fileToBase64(string $file, $urlSafe = false)
    {
        if (!is_file($file)) {
            return '';
        }
        $imageInfo = getimagesize($file);

        $imageData = fread(fopen($file, 'r'), filesize($file));

        return 'data:' . $imageInfo['mime'] . ';base64,' . Tools::base64encode($imageData, $urlSafe);
    }

    /**
     * base64 转存成文件
     * base64ToFile
     * @param string $base64Content
     * @param $outPutPath
     * @param bool $urlSafe
     *
     * @return bool|false|int
     * @date 2021/12/30 13:38
     */
    public static function base64ToFile(string $base64Content, $outPutPath, $urlSafe = false)
    {
        if (empty(dirname($outPutPath) || empty($outPutPath))) {
            return false;
        }

        $dirPath = dirname($outPutPath);
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 777, true);
        }
        list($prefix, $content) = explode(',', $base64Content, 2);

        return file_put_contents($outPutPath, Tools::base64decode($content, $urlSafe));
    }

}
