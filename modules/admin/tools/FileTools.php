<?php
namespace app\modules\admin\models;

class FileTools {

    private static $uploadsPath = '/uploads/images/';

    public static function getUploadsPath($modelName) {
        if($modelName != "") {
            return dirname(dirname(dirname(dirname(__FILE__)))) .'/web'. FileTools::$uploadsPath . $modelName . '/';
        } else {
            return dirname(dirname(dirname(dirname(__FILE__)))) .'/web'. FileTools::$uploadsPath;
        }
    }

    public static function uploadFile($files, $modelName)
    {
        $fileName = "";
        if ($files["error"] <= 0) {
            $fileName = date('YmdHis') . $files["name"];
            if(!file_exists(FileTools::getUploadsPath(""))) {
                mkdir(FileTools::getUploadsPath(""));
                if(!file_exists(FileTools::getUploadsPath($modelName))) {
                    mkdir(FileTools::getUploadsPath($modelName));
                }
            }
            if (!file_exists(FileTools::getUploadsPath($modelName).$fileName)) {
                move_uploaded_file($files["tmp_name"], FileTools::getUploadsPath($modelName).iconv("utf-8","gb2312",$fileName));
            } else {
                $fileName = "";
            }
        }
        return FileTools::$uploadsPath.$modelName.'/'.$fileName;
    }

    public static function downloadFile($file)
    {
        $fileNmae = dirname(dirname(dirname(dirname(__FILE__)))) .'/web'. $file;
        header('content-disposition:attachment;filename='.basename($file));
        header('content-length:'.filesize($file));
        readfile($file);

//        header("Content-type: octet/stream");
//        header("Content-disposition:attachment;filename=".$file.";");
//        header("Content-Length:".filesize($file));
//        readfile($file);
    }


    public static function downFile($file_name,$modelName){
        $file_path=dirname(dirname(dirname(dirname(__FILE__)))) .'/web'. FileTools::$uploadsPath . $modelName . '/'.$file_name;
        if(file_exists($file_path)){

        }
        $file_size=filesize($file_path);
        $fp=fopen($file_path,"r");
        //返回的文件
        header("Content-type:application/octet-stream");
        //按照字节大小返回
        header("Accept-Ranges:bytes");
        //返回文件大小
        header("Accept-Length:$file_size");
        //这里客户端的弹出对话框
        header("Content-Disposition:attachment;filename=".$file_name);
        //向客户端回送数据
        $buffer=1024;
        //为了下载的安全。我们最后做一个文件字节读取计数器
        $file_count=0;
        //判断文件是否结束
        while(!feof($fp)&&($file_size-$file_count>0)){
            $file_data=fread($fp,$buffer);
            //统计读了多少个字节
            $file_count+=$buffer;
            //把部分数据回送给浏览器
            //echo $file_data;
        }
        fclose($fp);
    }
}