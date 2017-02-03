<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\PAdv;
use app\modules\admin\models\PCommunity;
use app\modules\admin\models\PCompany;
use app\modules\admin\models\PCustomer;
use app\modules\admin\models\PModel;
use app\modules\admin\models\ExcelTools;
use app\modules\admin\models\PSales;
use app\modules\admin\models\PStaff;
use app\modules\admin\models\PStaffRole;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\Message;

/**
 * 销售管理
 * Class SaleController
 * @package app\modules\admin\controllers
 */
class SaleController extends \yii\web\Controller
{
    public $layout = 'admin';

    /**
     * @var array 显示的数据列
     */
    public $advColumns = array("id", "adv_community_id", "adv_no", "adv_name", "adv_position", "adv_install_status", "adv_use_status", "adv_rest_rate");
    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性(最多三层)
     * @var array
     */
    public $advColumnsVal = array("id", "adv_community_id", "adv_no", "adv_name", "adv_position", "adv_install_status", "adv_use_status", "adv_rest_rate");

    public $saleColumns = array("id", "community_name", "adv_no", "adv_name", "sales_company", "sales_customer", "sales_starttime", "sales_endtime", "sales_person", "sales_status");
    public $saleColumnsVal = array("id", "community_name", "adv_no", "adv_name", "sales_company", "sales_customer", "sales_starttime", "sales_endtime", "sales_person", "sales_status");

    public function actionManager()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];

        $customer_id = \Yii::$app->request->get('id', '0');    //从客户管理页面传过来的id，锁定客户
        $customer_name = "";
        if ($customer_id != 0) {
            $customer = PCustomer::find()->where("id=" . $customer_id)->one();
            $customer_name = $customer->customer_contact;
        }


        $column = DataTools::getDataTablesColumns($this->advColumns);
        $jsonDataUrl = '/admin/sale/salemanagerjson';

        $customerList = PCustomer::find()->where("company_id=" . $staff->company_id)->all();

        return $this->render('saleManagerOld', array("columns" => $column, 'jsonurl' => $jsonDataUrl, 'customerList' => $customerList, 'staff' => $staff, "customer_id" => $customer_id, "customer_name" => $customer_name));
    }

    public function actionSalemanagerjson()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];

        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonSaleData(\Yii::$app->request, "adv_use_status,adv_rate asc", $this->advColumns, $this->advColumnsVal,
            new PAdv(), "adv_name", 'adv_id', $staff);
    }

    public function actionSalemanager()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];

        $customer_id = \Yii::$app->request->get('id', '0');    //从客户管理页面传过来的id，锁定客户
        $customer_name = "";
        if ($customer_id != 0) {
            $customer = PCustomer::find()->where("id=" . $customer_id)->one();
            $customer_name = $customer->customer_contact;
        }
        $customerList = PCustomer::find()->where("company_id=" . $staff->company_id)->all();

        return $this->render('saleManager', array('customerList' => $customerList, 'staff' => $staff, "customer_id" => $customer_id, "customer_name" => $customer_name));
    }

    public function actionAjaxmamger()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];
        $now = date("Y-m-d H:i:s");
        $post = \Yii::$app->request->post();
        $page = $post['page'] ? $post['page'] : 1;
        $count = 20;
        $community_name = $post['community_name'];
        $adv_property = $post['adv_property'];
        $adv_rest_day = $post['adv_rest_day'];
        $where = array(
            ' 1=1 '
        );

        //权限控制
        if ($staff->staff_level == 1 || $staff->staff_level == 2 || $staff->staff_level == 3)
            $where[] = " adv.company_id =" . $staff->company_id . " and adv.adv_install_status=2 and (adv.adv_use_status=0 or adv.adv_use_status=1)";
        else if ($staff->staff_level == 4)
            $where[] = " adv.adv_install_status=2 and (adv.adv_use_status=0 or adv.adv_use_status=1)";

        //搜索条件
        if (!empty($community_name)) {
            $where[] = " com.community_name like '%$community_name%' ";
        }
        if ($adv_property != -1) {
            $where[] = " adv.adv_property = " . $adv_property . " ";
        }
        if ($adv_rest_day != -1) {
            if ($adv_rest_day == "1") {
                $where[] = " adv.adv_rest_day < 91 ";
            } else if ($adv_rest_day == 2) {
                $where[] = " adv.adv_rest_day > 90 and adv.adv_rest_day<181 ";
            } else if ($adv_rest_day == 3) {
                $where[] = " adv.adv_rest_day >180  ";
            }
        }

        //审核条件
        $where[] = " adv.adv_status in (0,7)";  //审核条件，0为无须审核，7为审核通过。

        $limit = (($page - 1) * $count) . ",$count ";
        $sql = "SELECT adv.*,com.community_name,cpy.company_name FROM p_adv adv "
            . " LEFT JOIN p_community com ON adv.adv_community_id = com.id "
            . " LEFT JOIN p_company cpy ON adv.company_id = cpy.id "
            . " WHERE " . implode(" AND ", $where)
            . " GROUP BY adv.id "
            . " ORDER BY  adv.adv_use_status,adv.adv_rest_rate asc"
            . " LIMIT " . $limit;
        //exit(json_encode($sql));

        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $list = $command->queryAll();

        foreach ($list as $key => $value) {
            //加工上刊率
            if (!isset($list[$key]["adv_rate"]))
                $list[$key]["adv_rate"] = 0;
            //加工空刊率
            if (!isset($list[$key]["adv_rest_rate"]))
                $list[$key]["adv_rest_rate"] = "0";
        }

        //测试
//        $str = "";
//        foreach($list as $key=>$value)
//        {
//            foreach($value as $k=>$v)
//                $str =$str. $k.":".$v.";";
//            $str = $str. "<br/>";
//        }
//        exit(json_encode($str));

        $sql = "select count(DISTINCT(adv.id)) allCount from p_adv adv "
            . " LEFT JOIN p_community com ON adv.adv_community_id = com.id "
            . " LEFT JOIN p_company cpy ON adv.company_id = cpy.id "
            . " where " . implode("AND", $where)
            . " ORDER BY  adv.id desc";

        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $allCount = $command->queryOne();
        //提供分页数据
        $page_data = array(
            'page' => (int)$page,
            'count' => $count,
            'allCount' => (int)$allCount['allCount'],
            'allPage' => ceil($allCount['allCount'] / $count),
            'sql' => $sql
        );
        exit(json_encode(array('list_data' => $list, 'page_data' => $page_data)));
    }

    /**
     * 通过customer_id获得customer信息
     */
    public function actionGetcustomerinfo()
    {
        $customer_id = \Yii::$app->request->get('customer_id', '0');
        $customer = PCustomer::find()->select('customer_contact')->where('id=' . $customer_id)->asArray()->all();
        DataTools::jsonEncodeResponse($customer);
    }

    /*
     * 销售信息提交
     */
    public function actionDosale()
    {
        $result = 0; //记录直行成功数量

        $date = date('Y-m-d H:i:s');
        $post = \Yii::$app->request->post();
        $ids = $post['ids'];
        $sales_company = $post['sales_company'];
        $sales_customer = $post['sales_customer'];
        $sales_starttime = $post['sales_starttime'];
        $sales_endtime = $post['sales_endtime'];
        $sales_person = $post['sales_person'];
        $sales_status = $post['sales_status'];
        $sales_note = $post['sales_note'];

        //遍历设置销售信息
        foreach ($ids as $key => $value) {
            $advInfo = new PAdv();
            $advInfo = PAdv::find()->where("id=" . $value)->one();
            if ($advInfo != null) {
                $communityInfo = PCommunity::find()->where("id=" . $advInfo->adv_community_id)->one();
                if ($communityInfo != null) {
                    //设置销售信息
                    $sales = new PSales();
                    $sales->community_no = $communityInfo->community_no;
                    $sales->community_name = $communityInfo->community_name;
                    $sales->community_position = $communityInfo->community_position;
                    $sales->adv_id = $value;
                    $sales->adv_no = $advInfo->adv_no;
                    $sales->adv_name = $advInfo->adv_name;
                    $sales->company_id = $advInfo->company_id;
                    $sales->sales_customer = $sales_customer;
                    $sales->sales_company = $sales_company;
                    $sales->sales_starttime = $sales_starttime;
                    $sales->sales_endtime = $sales_endtime;
                    $sales->sales_person = $sales_person;
                    $sales->sales_status = $sales_status;
                    $sales->sales_note = $sales_note;
                    $sales->create_time = $date;
                    $sales->update_time = $date;
                    $sales->save();

                    //计算上刊率（销售时间/已安装完成时间到现在时间）
                    $time_now = strtotime($date);  //当前时间
                    $time_start = strtotime($advInfo["adv_starttime"]);   //广告位开始时间（即广告位安装完成日）
                    if ($time_now > $time_start)
                        $time_denominator = round(($time_now - $time_start) / 3600 / 24); //上刊率分母
                    else
                        $time_denominator = 1;
                    if ($time_denominator == 0)
                        $time_denominator = 1;
                    //计算销售时间
                    $sale = PSales::find()->select("sales_starttime,sales_endtime")->where("adv_id = " . $value)->asArray()->all();
                    $time_numerator = 0;  //上刊率分子
                    if (count($sale) > 0) {
                        foreach ($sale as $k => $v) {
                            $time_sale_starttime = strtotime($v["sales_starttime"]);
                            $time_sale_endtime = strtotime($v["sales_endtime"]);
                            if ($time_sale_starttime < $time_sale_endtime && $time_sale_endtime < $time_now)
                                $time_numerator = $time_numerator + round(($time_sale_endtime - $time_sale_starttime) / 3600 / 24);
                            else if ($time_sale_starttime < $time_now && $time_now < $time_sale_endtime)
                                $time_numerator = $time_numerator + round(($time_now - $time_sale_starttime) / 3600 / 24);
                        }
                    }
                    if ($time_denominator == 1)
                        $time_rate = 0;
                    else
                        $time_rate = (round($time_numerator / $time_denominator, 4) * 100);   //上刊率
                    if ($time_rate != 0) {
                        if ($time_rate > 100)
                            $time_rate = "100%";
                        else
                            $time_rate = $time_rate . "%";
                    }

                    //计算年上刊率：1年内广告位销售天数/365
                    $date_year_ago = date('Y-m-d', strtotime("-1 year"));   //1年前
                    $time_year_ago = strtotime($date_year_ago);
                    if ($time_now > $time_start) {
                        if ($time_start > $time_year_ago)    //广告位使用时间不足1年
                        {
                            $rest_denominator = round(($time_now - $time_start) / 3600 / 24);   //空刊率分母
                            $time_year_ago = $time_start;
                        } else {
                            $rest_denominator = round(($time_now - $time_year_ago) / 3600 / 24);
                        }
                    } else {
                        $rest_denominator = 1;
                    }

                    if ($rest_denominator == 0)
                        $rest_denominator = 1;

                    $rest_numerator = 0;  //空刊率分子
                    if (count($sale) > 0) {
                        foreach ($sale as $k => $v) {
                            $time_sale_starttime = strtotime($v["sales_starttime"]);
                            $time_sale_endtime = strtotime($v["sales_endtime"]);
                            if ($time_sale_starttime < $time_year_ago && $time_sale_endtime > $time_year_ago && $time_sale_endtime < $time_now)
                                $rest_numerator = $rest_numerator + round(($time_sale_endtime - $time_year_ago) / 3600 / 24);
                            else if ($time_sale_starttime < $time_year_ago && $time_sale_endtime > $time_now)
                                $rest_numerator = $rest_numerator + round(($time_now - $time_year_ago) / 3600 / 24);
                            else if ($time_sale_starttime > $time_year_ago && $time_sale_starttime < $time_now && $time_sale_endtime < $time_now)
                                $rest_numerator = $rest_numerator + round(($time_sale_endtime - $time_sale_starttime) / 3600 / 24);
                            else if ($time_sale_starttime > $time_year_ago && $time_sale_starttime < $time_now && $time_sale_endtime > $time_now)
                                $rest_numerator = $rest_numerator + round(($time_now - $time_sale_starttime) / 3600 / 24);
                        }
                    }

                    if ($rest_denominator == 1)
                        $rest_rate = 0;
                    else {
                        $rest_rate = round($rest_numerator / $rest_denominator, 4) * 100;   //1年广告位上刊率
                    }
                    if ($rest_rate != 0)
                        $rest_rate = $rest_rate . "%";

                    //更新广告位状态
                    $adv = PAdv::find()->where("id=" . $value)->one();
                    if ($adv != null) {
                        $adv->adv_use_status = 2;
                        $adv->adv_sales_status = $sales_status;
                        $adv->adv_rate = $time_rate;
                        $adv->adv_rest_rate = $rest_rate;
                        $adv->update_time = $date;
                        $adv->save();
                    }
                }
            }
            $result++;
        }

        //设置message消息
        $staff_name = \Yii::$app->session['loginUser']->staff_name;
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $info_status = "";  //销售状态
        if ($sales_status > -1) {
            switch ($sales_status) {
                case 0:
                    $info_status = '销售';
                    break;
                case 1:
                    $info_status = '赠送';
                    break;
                case 2:
                    $info_status = '置换';
                    break;
            }
        }
        $customer_company = "";    //客户公司
        $customer = PCustomer::find()->where("id=" . $sales_company)->one();
        if ($customer != null)
            $customer_company = $customer->customer_company;
        $message = $staff_name . "于" . $date . "将" . $result . "个广告位" . $info_status . "给" . $customer_company . "，销售人员为：" . $sales_person . "。";
        Message::sendMessage($company_id, $message);

        echo json_encode($result);
    }

    public function actionSearch()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];

        $column = DataTools::getDataTablesColumns($this->saleColumns);
        $jsonDataUrl = '/admin/sale/salesearchjson';

        return $this->render('saleSearch', array("columns" => $column, 'jsonurl' => $jsonDataUrl));
    }

    public function actionSalesearchjson()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];

        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonSaleSearchData(\Yii::$app->request, "sales_starttime desc", $this->saleColumns, $this->saleColumnsVal, new PSales(), $staff);
    }

    /*
     * 数据同步（建议shell自动执行）
     * 1.计算空刊日：1-3个月（90天）、3-6个月（90-180天）、半年以上（>180天）
     * 2.将已超过销售日期的广告牌状态恢复为待销售。
     */
    public function actionSalesync()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];

        $date = date('Y-m-d H:i:s');
        $time_now = strtotime($date);  //当前时间
        $advList = PAdv::find()->where("company_id=" . $staff->company_id)->select("id,adv_starttime")->all();

        //遍历所有广告位信息
        foreach ($advList as $key => $value) {
            $is_expired = false;  //销售是否过期
            $adv_rest_day = 0;  //空刊日
            $saleList = PSales::find()->where("adv_id=" . $value["id"])->select("sales_starttime,sales_endtime")->orderBy("create_time desc")->one();  //获得该广告位销售信息
            $adv_starttime = strtotime($value["adv_starttime"]);  //广告位安装时间
            if ($saleList != "") {
                //有销售记录，当前时间-销售时间（分3中情况讨论）
                $sale_starttime = strtotime($saleList["sales_starttime"]);
                $sales_endtime = strtotime($saleList["sales_endtime"]);

                if ($sales_endtime < $time_now) {
                    $rest_time = $time_now - $sales_endtime;

                    //已过销售时间，广告位重新变成：adv_use_status未使用,
                    $is_expired = true;

                } else if ($sale_starttime < $time_now && $sales_endtime > $time_now) {
                    $rest_time = 0;
                } else {
                    $rest_time = $time_now - $adv_starttime;
                }

            } else {
                //无销售记录：当前时间-广告位上刊时间
                $rest_time = $time_now - $adv_starttime;
            }
            $adv_rest_day = round($rest_time / (60 * 60 * 24));  //空刊日

            //更新广告位空刊日
            $adv = PAdv::find()->where("id=" . $value["id"])->one();
            if ($adv != null) {
                $adv->adv_rest_day = $adv_rest_day;
                $adv->update_time = $date;
                if($is_expired)
                {
                    $adv->adv_use_status = 1;
                }
                $adv->save();
            }
        }

        return $this->render('saleSync');
    }

}