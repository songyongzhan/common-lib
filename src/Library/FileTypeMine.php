<?php

namespace Songyz\Common\Library;

class FileTypeMine
{

    /**
     * 获取文件的mine 流名称
     * getFileTypeMine
     * @return string[]
     *
     * @author songyongzhan <574482856@qq.com>
     */
    public static function getFileTypeMine()
    {
        return array(
            'gif'   => 'image/gif',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'jpe'   => 'image/jpeg',
            'bmp'   => 'image/bmp',
            'png'   => 'image/png',
            'pict'  => 'image/x-pict',
            'pic'   => 'image/x-pict',
            'pct'   => 'image/x-pict',
            'tif'   => 'image/tiff',
            'tiff'  => 'image/tiff',
            'psd'   => 'image/x-photoshop',
            'swf'   => 'application/x-shockwave-flash',
            'js'    => 'application/x-javascrīpt',
            'pdf'   => 'application/pdf',
            'ps'    => 'application/postscrīpt',
            'eps'   => 'application/postscrīpt',
            'ai'    => 'application/postscrīpt',
            'wmf'   => 'application/x-msmetafile',
            'css'   => 'text/css',
            'htm'   => 'text/html',
            'html'  => 'text/html',
            'txt'   => 'text/plain',
            'xml'   => 'text/xml',
            'wml'   => 'text/wml',
            'wbmp'  => 'image/vnd.wap.wbmp',
            'mid'   => 'audio/midi',
            'wav'   => 'audio/wav',
            'mp3'   => 'audio/mpeg',
            'mp2'   => 'audio/mpeg',
            'avi'   => 'video/x-msvideo',
            'mpeg'  => 'video/mpeg',
            'mpg'   => 'video/mpeg',
            'qt'    => 'video/quicktime',
            'mov'   => 'video/quicktime',
            'lha'   => 'application/x-lha',
            'lzh'   => 'application/x-lha',
            'z'     => 'application/x-compress',
            'gtar'  => 'application/x-gtar',
            'gz'    => 'application/x-gzip',
            'gzip'  => 'application/x-gzip',
            'tgz'   => 'application/x-gzip',
            'tar'   => 'application/x-tar',
            'bz2'   => 'application/bzip2',
            'zip'   => 'application/zip',
            'arj'   => 'application/x-arj',
            'rar'   => 'application/x-rar-compressed',
            'hqx'   => 'application/mac-binhex40',
            'sit'   => 'application/x-stuffit',
            'bin'   => 'application/x-macbinary',
            'uu'    => 'text/x-uuencode',
            'uue'   => 'text/x-uuencode',
            'latex' => 'application/x-latex',
            'ltx'   => 'application/x-latex',
            'tcl'   => 'application/x-tcl',
            'pgp'   => 'application/pgp',
            'asc'   => 'application/pgp',
            'exe'   => 'application/x-msdownload',
            'doc'   => 'application/msword',
            'rtf'   => 'application/rtf',
            'xls'   => 'application/vnd.ms-excel',
            'ppt'   => 'application/vnd.ms-powerpoint',
            'mdb'   => 'application/x-msaccess',
            'wri'   => 'application/x-mswrite',
        );
    }

    /**
     * 返回文件对应的mine
     * getFileMineBySuffix
     * @param $fileSuffix
     * @return string
     *
     * @author songyongzhan <574482856@qq.com>
     */
    public static function getFileMineBySuffix($fileSuffix)
    {

        $fileType = self::getFileTypeMine();

        return $fileType[$fileSuffix] ?? '';
    }

}
