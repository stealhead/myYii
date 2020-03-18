<?php

namespace app\console\controller;

use yii\console\Controller;

class ProductPicController extends Controller {

    // 批量下载商品图片
    public function actionGen() {

        $fileList = $this->getData();
        $counter = [];

        foreach ($fileList as $fileInfo) {

            $brand = $fileInfo[0];
            $spuName = $fileInfo[1];
            $spuId = $fileInfo[2];
            $url = $fileInfo[3];

            $key = $brand . '-' . $spuId;
            if (array_key_exists($key, $counter)) {
                $counter[$key] = $counter[$key] + 1;
            } else {
                $counter[$key] = 1;
            }
            //$filePath = 'derek-temp/' . $brand . '/' . $spuName . '-' . $spuId;
            $filePath = 'derek-temp/' . $brand. '/' . $spuName;

            $this->createDir($filePath);
            //$filename = $filePath . '/' . $spuName . '-' . $counter[$key] . '.jpg';//文件名称生成
            $filename = $filePath . '/' . $spuId . '.jpg';//文件名称生成
            try {

                if (!file_exists($filename)) {
                    $this->createFile($filename, $url);
                }
            } catch (\Exception $exception) {
                echo $exception->getMessage();
            }
        }
        echo "all done \n";
    }

    public function createFile($fileName, $url) {
        ob_start();//打开缓冲区
        readfile($url);//输出图片文件到缓冲区
        $img = ob_get_contents();//得到浏览器输出
        ob_end_clean();//清除输出并关闭

        $fp = @fopen($fileName, "a");
        fwrite($fp, $img);//向当前目录写入图片文件，并重新命名
        fclose($fp);
        echo "写入成功:" . $fileName . "\n";
    }

    public function createDir($path) {
        if (is_dir($path)){
            //echo "目录存在\n";
        }else{
            //第三个参数是“true”表示能创建多级目录，iconv防止中文目录乱码
            $res=mkdir($path,0777,true);
            if ($res){
                //echo "目录 $path 创建成功\n";
            }else{
                echo "目录 $path 创建失败\n";
            }
        }
    }

    public function getData() {
        return [
            ['家具', 'WINK', '5954马特沙发', 'https://pimg.wzj.com/goods/images/PIC2201503042688.jpg?x-oss-process=style/w1000'],
        ];
    }
}
