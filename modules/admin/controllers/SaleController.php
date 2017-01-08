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
    public $advColumns = array("id", "adv_community_id", "adv_no", "adv_name", "adv_position", "adv_install_status", "adv_use_status","adv_rate");
    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性(最多三层)
     * @var array
     */
    public $advColumnsVal = array("id", "adv_community_id", "adv_no", "adv_name", "adv_position", "adv_install_status", "adv_use_status","adv_rate");

    public $saleColumns = array("id", "community_name", "adv_no", "adv_name", "sales_company", "sales_customer", "sales_starttime", "sales_endtime", "sales_person", "sales_status");
    public $saleColumnsVal = array("id", "community_name", "adv_no", "adv_name", "sales_company", "sales_customer", "sales_starttime", "sales_endtime", "sales_person", "sales_status");

    public function actionManager()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];

        $column = DataTools::getDataTablesColumns($this->advColumns);
        $jsonDataUrl = '/admin/sale/salemanagerjson';

        $customerList = PCustomer::find()->where("company_id=" . $staff->company_id)->all();

        return $this->render('saleManager', array("columns" => $column, 'jsonurl' => $jsonDataUrl, 'customerList' => $customerList, 'staff' => $staff));
    }

    public function actionSalemanagerjson()
    {
        //$customer
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];

        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonSaleData(\Yii::$app->request, "adv_use_status,adv_rate asc", $this->advColumns, $this->advColumnsVal,
            new PAdv(), "adv_name", 'adv_id', $staff);
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
                    $time_start = strtotime($advInfo["adv_starttime"]);   //开始时间
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
                    if ($time_rate != 0)
                        $time_rate = $time_rate . "%";

                    //更新广告位状态
                    $adv = PAdv::find()->where("id=" . $value)->one();
                    if ($adv != null) {
                        $adv->adv_use_status = 2;
                        $adv->adv_sales_status = $sales_status;
                        $adv->adv_rate = $time_rate;
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
        DataTools::getJsonSaleSearchData(\Yii::$app->request, "sales_starttime desc", $this->saleColumns, $this->saleColumnsVal,new PSales(), $staff);
    }

}