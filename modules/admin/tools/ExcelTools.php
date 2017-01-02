<?php
namespace app\modules\admin\models;

include '/../vendor/phpexcel/Classes/PHPExcel/IOFactory.php';
include '/../vendor/phpexcel/Classes/PHPExcel.php';
include '/../vendor/phpexcel/Classes/PHPExcel/Writer/Excel5.php';     // 用于其他低版本xls
include '/../vendor/phpexcel/Classes/PHPExcel/Writer/Excel2007.php'; // 用于 excel-2007 格式

class ExcelTools
{
    public static function getExcelObject($inputFileName)
    {
        $objPHPExcel = \PHPExcel_IOFactory::load($inputFileName);
        return $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
    }

    /**
     * 这个方法待完善company_id没写
     * @param $excel
     * 审核状态全面默认为0，无须审核
     */
    public static function setDataIntoCommunity($excel)
    {
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $user_id = \Yii::$app->session['loginUser']->id;

        $sql = 'insert into p_community values ';
        $array = array('A', 'C', 'V', 'G', 'H', 'W', 'AB', '<1>', 'AA', 'AE', 'O', 'P', 'AH', 'BQ', 'Z', 'AG', '<null>', '<null>', '<null>', 'AK', '<0>', '<company>', '<0>', '<userid>', '<now>', '<userid>', '<now>');
        foreach ($excel as $key => $value) {
            if ($key > 2) {
                if ($value['A'] == '') {
                    continue;
                }
                $sql .= '(null,';
                foreach ($array as $k => $v) {
                    if ($v == 'BQ') {
                        $xy = explode(",", $value[$v]);
                        if (count($xy) > 1) {
                            $sql .= '"' . $xy[0] . '",';
                            $sql .= '"' . $xy[1] . '",';
                        } else {
                            $sql .= '"' . 'null' . '",';
                            $sql .= '"' . 'null' . '",';
                        }
                    } else {
                        if (strpos($v, ">") <= 0) {
                            $sql .= '"' . $value[$v] . '",';
                        } else {
                            $v = str_replace("<", "", $v);
                            $v = str_replace(">", "", $v);
                            if ($v == 'null') {
                                $sql .= 'null,';
                            } else if ($v == 'company') {
                                $sql .= '"' . $company_id . '",';
                            } else if ($v == 'userid') {
                                $sql .= '"' . $user_id . '",';
                            } else if ($v == 'now') {
                                $sql .= '"' . date('Y-m-d H:i:s') . '",';
                            } else {
                                $sql .= '"' . $v . '",';
                            }
                        }
                    }
                }
                $sql = substr($sql, 0, strlen($sql) - 1);
                $sql .= '),';
            }
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        \Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * customer客户报备信息导入
     * @param $excel
     */
    public static function setDataIntoCustomer($excel)
    {
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $user_id = \Yii::$app->session['loginUser']->id;
        $sql = 'insert into p_customer values ';
        $array = array('A', 'B', 'C', 'D', 'E', 'F', '<company>', '<userid>', '<now>', '<userid>', '<now>');
        foreach ($excel as $key => $value) {
            if ($key > 1) {
                if ($value['A'] == '') {
                    continue;
                }
                $sql .= '(null,';
                foreach ($array as $k => $v) {
                    if (strpos($v, ">") <= 0) {
                        $sql .= '"' . $value[$v] . '",';
                    } else {
                        $v = str_replace("<", "", $v);
                        $v = str_replace(">", "", $v);
                        if ($v == 'null') {
                            $sql .= 'null,';
                        } else if ($v == 'company') {
                            $sql .= '"' . $company_id . '",';
                        } else if ($v == 'userid') {
                            $sql .= '"' . $user_id . '",';
                        } else if ($v == 'now') {
                            $sql .= '"' . date('Y-m-d H:i:s') . '",';
                        } else {
                            $sql .= '"' . $v . '",';
                        }
                    }
                }
                $sql = substr($sql, 0, strlen($sql) - 1);
                $sql .= '),';
            }
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        \Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * customer客户信息导入
     * @param $excel
     * @param $sectorArray  该公司下面未删除(is_delete=0)的部门id和sector_name
     */
    public static function setDataIntoStaff($excel, $sectorArray)
    {
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $user_id = \Yii::$app->session['loginUser']->id;
        $sql = 'insert into p_staff values ';
        $array = array('A', 'B', '<1>', '<null>', 'C', '<null>', '<null>', '<company>', 'F', 'G', 'D', 'E', '<now>', '<now>', '<0>', '<0>', '<now>', '<now>');
        foreach ($excel as $key => $value) {
            if ($key > 1) {
                if ($value['A'] == '') {
                    continue;
                } else
                    $sql .= '(null,';
                foreach ($array as $k => $v) {
                    if ($v == 'F') {    //获得部门id
                        $hasSector = 0;  //是否已经设置了部门id，默认否
                        foreach ($sectorArray as $sk => $sv) {
                            if ($sv["sector_name"] == trim($value[$v])) {
                                $sql .= $sv["id"] . ",";
                                $hasSector = 1;
                            }
                        }
                        if ($hasSector == 0)
                            $sql .= "0,";
                    } else if ($v == 'B') {
                        $sql .= '"' . md5($value[$v]) . '",';   //密码加密
                    } else {
                        if (strpos($v, ">") <= 0) {
                            $sql .= '"' . $value[$v] . '",';
                        } else {
                            $v = str_replace("<", "", $v);
                            $v = str_replace(">", "", $v);
                            if ($v == 'null') {
                                $sql .= 'null,';
                            } else if ($v == 'company') {
                                $sql .= '"' . $company_id . '",';
                            } else if ($v == 'userid') {
                                $sql .= '"' . $user_id . '",';
                            } else if ($v == 'now') {
                                $sql .= '"' . date('Y-m-d H:i:s') . '",';
                            } else {
                                $sql .= '"' . $v . '",';
                            }
                        }
                    }
                }
                $sql = substr($sql, 0, strlen($sql) - 1);
                $sql .= '),';
            }
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        echo $sql;
        \Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * 广告位信息
     * @param $excel
     * @param $communityArray 楼宇Id及名称
     * @param $modelArray   设备型号
     */
    public static function setDataIntoAdv($excel, $communityArray, $modelArray)
    {
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $user_id = \Yii::$app->session['loginUser']->id;
        $sql = 'insert into p_adv values ';
        $array = array('A', 'B', 'C', 'D', 'E', 'F', '<null>', 'G', 'H', 'I', 'J', 'K', 'L', 'M', '<0>', '<company>', '<0>', '<userid>', '<now>', '<userid>', '<now>');
        foreach ($excel as $key => $value) {
            if ($key > 1) {
                if ($value['A'] == '') {
                    continue;
                }
                $sql .= '(null,';
                foreach ($array as $k => $v) {
                    if ($v == 'B') {     //设置楼宇Id
                        $hasCommunity = 0;  //是否已经设置了楼宇id，默认否
                        foreach ($communityArray as $ck => $cv) {
                            if ($cv["community_name"] == trim($value[$v])) {
                                $sql .= $cv["id"] . ",";
                                $hasCommunity = 1;
                            }
                        }
                        if ($hasCommunity == 0)
                            $sql .= "0,";
                    } else if ($v == 'G') {   //广告位性质 0.电梯广告,1.道闸广告,2.道杆广告,3.灯箱,4.行人门禁
                        if ($value[$v] == "电梯广告")
                            $sql .= "0,";
                        else if ($value[$v] == "道闸广告")
                            $sql .= "1,";
                        else if ($value[$v] == "道杆广告")
                            $sql .= "2,";
                        else if ($value[$v] == "灯箱")
                            $sql .= "3,";
                        else
                            $sql .= "4,";
                    } else if ($v == 'H') {  //设备型号
                        $hasModel = 0;  //是否已经设置了设备型号ID，默认否
                        foreach ($modelArray as $mk => $mv) {
                            if (trim($mv["model_id"]) == trim($value[$v]) || trim($mv["model_name"]) == trim($value[$v])) {
                                $sql .= $mv["id"] . ",'" . $value[$v] . "',";
                                $hasModel = 1;
                            }
                        }
                        if ($hasModel == 0) {
                            if ($value[$v] == "")
                                $sql .= "0,null,";
                            else
                                $sql .= "0,'" . $value[$v] . "',";
                        }
                    } else if ($v == 'J') {   //安装状态 0.未安装,1.待维修(损坏),2.正常使用
                        if ($value[$v] == "未安装")
                            $sql .= "0,";
                        else if ($value[$v] == "待维修(损坏)")
                            $sql .= "1,";
                        else
                            $sql .= "2,";   //$value[$v]=="正常使用"
                    } else if ($v == 'I') {   //使用状态  0.新增、1.未使用、2.已使用
                        if ($value[$v] == "新增")
                            $sql .= "0,";
                        else if ($value[$v] == "未使用")
                            $sql .= "1,";
                        else
                            $sql .= "2,";  //$value[$v]=="已使用"
                    } else if ($v == 'K') {   //销售状态  0.销售、1.赠送、2.置换
                        if ($value[$v] == "销售")
                            $sql .= "0,";
                        else if ($value[$v] == "赠送")
                            $sql .= "1,";
                        else
                            $sql .= "2,";  //$value[$v]=="置换"
                    } else if ($v == 'L') {   //画面状态  0.预定、1.待上刊、2.已上刊、3.待下刊、4.已下刊
                        if ($value[$v] == "预定")
                            $sql .= "0,";
                        else if ($value[$v] == "待上刊")
                            $sql .= "1,";
                        else if ($value[$v] == "已上刊")
                            $sql .= "2,";
                        else if ($value[$v] == "待下刊")
                            $sql .= "3,";
                        else
                            $sql .= "4,";
                    } else {
                        if (strpos($v, ">") <= 0) {
                            $sql .= '"' . $value[$v] . '",';
                        } else {
                            $v = str_replace("<", "", $v);
                            $v = str_replace(">", "", $v);
                            if ($v == 'null') {
                                $sql .= 'null,';
                            } else if ($v == 'company') {
                                $sql .= '"' . $company_id . '",';
                            } else if ($v == 'userid') {
                                $sql .= '"' . $user_id . '",';
                            } else if ($v == 'now') {
                                $sql .= '"' . date('Y-m-d H:i:s') . '",';
                            } else {
                                $sql .= '"' . $v . '",';
                            }
                        }
                    }
                }
                $sql = substr($sql, 0, strlen($sql) - 1);
                $sql .= '),';
            }
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public static function  getExcel($fileName,$headArr,$data){
        if(empty($data) || !is_array($data)){
            die("data must be a array");
        }
        if(empty($fileName)){
            exit;
        }
        //$date = date("Y_m_d",time());
        //$fileName .= "_{$date}.xlsx";

        //创建新的PHPExcel对象
        $objPHPExcel = new \PHPExcel();
        $objProps = $objPHPExcel->getProperties();

        //设置表头
        $key = ord("A");
        foreach($headArr as $v){
            $colum = chr($key);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.$key, $v);
            $key += 1;
        }

//        $column = 2;
//        $objActSheet = $objPHPExcel->getActiveSheet();
//        foreach($data as $key => $rows){ //行写入
//            $span = ord("A");
//            foreach($rows as $keyName=>$value){// 列写入
//                $j = chr($span);
//                $objActSheet->setCellValue($j.$column, $value);
//                $span++;
//            }
//            $column++;
//        }

        //$fileName = iconv("utf-8", "gb2312", $fileName);
        //重命名表
        $objPHPExcel->getActiveSheet()->setTitle('Simple');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        //将输出重定向到一个客户端web浏览器(Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if(!empty($_GET['excel'])){
            $objWriter->save('php://output'); //文件通过浏览器下载
        }else{
            $objWriter->save($fileName); //脚本方式运行，保存在当前目录
        }
        exit;
    }

    /*
     * 参考：http://blog.csdn.net/molaifeng/article/details/12527947
     * 广告位信息导出
     */
    public static function advExport($fileName,$data)
    {
        $objPHPExcel = new \PHPExcel();
        // 字体和样式
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
        // 表头
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '序号')
            ->setCellValue('B1', '所属楼盘')
            ->setCellValue('C1', '广告位编号')
            ->setCellValue('D1', '广告位名称')
            ->setCellValue('E1', '广告位位置')
            ->setCellValue('F1', '安装状态')
            ->setCellValue('G1', '销售状态')
            ->setCellValue('H1', '画面状态')
            ->setCellValue('I1', '人员分配');;

        // 内容
        $num=1;   //序号
        $i=2;
        foreach($data as $key=>$value)
        {
            $objPHPExcel->getActiveSheet(0)->setCellValue('A' . $i, $num);
            $objPHPExcel->getActiveSheet(0)->setCellValue('B' . $i, $value['community_name']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('C' . $i, $value['adv_no']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('D' . $i, $value['adv_name']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('E' . $i, $value['adv_position']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('F' . $i, $value['adv_install_status']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('G' . $i, $value['adv_sales_status']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('H' . $i, $value['adv_pic_status']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('I' . $i, $value['people_num']);
            $num++;
            $i++;
        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // 输出
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName);
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}