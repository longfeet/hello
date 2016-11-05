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
}