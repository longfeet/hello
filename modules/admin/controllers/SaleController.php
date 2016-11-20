<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\PAdv;
use app\modules\admin\models\DataTools;
use app\modules\admin\models\PCommunity;
use app\modules\admin\models\PCustomer;
use app\modules\admin\models\PModel;
use app\modules\admin\models\ExcelTools;
use app\modules\admin\models\PSales;
use app\modules\admin\models\PStaff;
use app\modules\admin\models\PStaffRole;

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
    public $advColumns = array("id", "adv_community_id", "adv_no", "adv_name", "adv_position", "adv_install_status", "adv_use_status");
    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性(最多三层)
     * @var array
     */
    public $advColumnsVal = array("id", "adv_community_id", "adv_no", "adv_name", "adv_position", "adv_install_status", "adv_use_status");

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
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];

        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonSaleData(\Yii::$app->request, "adv_use_status asc", $this->advColumns, $this->advColumnsVal,
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
            if($advInfo!=null)
            {
                $communityInfo = PCommunity::find()->where("id=" . $advInfo->adv_community_id)->one();
                if($communityInfo!=null)
                {
                    //设置销售信息
                    $sales = new PSales();
                    $sales->community_no = $communityInfo->community_no;
                    $sales->community_name=$communityInfo->community_name;
                    $sales->community_position=$communityInfo->community_position;
                    $sales->adv_id = $value;
                    $sales->adv_no=$advInfo->adv_no;
                    $sales->adv_name=$advInfo->adv_name;
                    $sales->company_id=$advInfo->company_id;
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

                    //更新广告位状态
                    $adv = PAdv::find()->where("id=" . $value)->one();
                    if ($adv != null) {
                        $adv->adv_use_status = 2;
                        $adv->adv_sales_status = $sales_status;
                        $adv->update_time = $date;
                        $adv->save();
                    }
                }
            }


            $result++;
        }
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
        DataTools::getJsonSaleSearchData(\Yii::$app->request, "create_time desc", $this->saleColumns, $this->saleColumnsVal,
            new PSales(), "community_name");
    }

}