<?php

namespace Songyz\Common\Tests;

use PHPUnit\Framework\TestCase;
use Songyz\Common\Library\Upload;

class UploadTest extends TestCase
{

    public function testStrAll()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            
            $file = new Upload($_FILES['thumb']['tmp_name']);

            $file->setRule('date');
            $result = $file->setUploadInfo($_FILES['thumb'])->validate(['size' => 26214400])->move(__DIR__);

            if ($result) {
                $data = [
                    'state'     => '上传成功',
                    //'url' => rtrim(VIEW_HOST, '//') . DS . trim(VIEW_PATH, '//') . DS . ltrim($result->getSaveName(), '//'),
                    'extension' => $result->getExtension(),
                    'title'     => $result->getFilename(),
                    'original'  => $result->getFilename(),
                ];

            } else {
                $data = ['state' => '上传失败'];
            }

            print_r($data);
        } else {

            $content = <<<TOT
    <form action="./index.php" method="post" enctype="multipart/form-data" >
        <input type="file" name="thumb">
        <button type="submit">提交</button>
    </form>
TOT;

            echo $content;

        }

    }


}
