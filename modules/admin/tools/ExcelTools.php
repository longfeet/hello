<?php
namespace app\modules\admin\models;

include '/../vendor/phpexcel/Classes/PHPExcel/IOFactory.php';

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
     */
    public static function setDataIntoCommunity($excel)
    {
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $user_id = \Yii::$app->session['loginUser']->id;
        $sql = 'insert into p_community values ';
        $array = array('A', 'C', 'V', 'G', 'H', 'W', 'AB', '<1>', 'AA', 'AE', 'O', 'P', 'AH', 'BQ', '<null>', '<null>', '<null>', 'Z', 'AG', 'AK', 'F', '<company>', '<0>', '<userid>', '<now>', '<userid>', '<now>');
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
        $array = array('A', 'B', '<null>', '<null>', 'C', '<null>', '<null>', '<company>', 'F', 'G', 'D', 'E', '<now>', '<now>', '<0>', '<0>', '<now>', '<now>');
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
        $array = array('A', 'B', 'C', 'D', 'E', 'F', '<null>', 'G', 'H', 'I', 'J', 'K', 'L', 'M', '<null>', '<company>', '<0>', '<userid>', '<now>', '<userid>', '<now>');
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
                            if ($cv["model_id"] == trim($value[$v]) || $cv["model_name"] == trim($value[$v])) {
                                $sql .= $cv["id"] . "," . $value[$v] . ",";
                                $hasModel = 1;
                            }
                        }
                        if ($hasModel == 0) {
                            if ($value[$v] == "")
                                $sql .= "0,null,";
                            else
                                $sql .= "0," . $value[$v] . ",";
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

}