<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\PAdv;
use app\modules\admin\models\DataTools;
use app\modules\admin\models\PCommunity;
use app\modules\admin\models\PModel;
use app\modules\admin\models\ExcelTools;
use app\modules\admin\models\PStaff;
use app\modules\admin\models\PStaffRole;

/**
 * 销售管理
 * Class SaleController
 * @package app\modules\admin\controllers
 */
class SaleController extends \yii\web\Controller
{
    public $layout='admin';

    /**
     * @var array 显示的数据列
     */
    public $advColumns = array("id","adv_community_id","adv_no","adv_name","adv_position","adv_install_status","adv_use_status");
    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性(最多三层)
     * @var array
     */
    public $advColumnsVal = array("id","adv_community_id","adv_no","adv_name","adv_position","adv_install_status","adv_use_status");

    public function actionManager()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];



        $column = DataTools::getDataTablesColumns($this->advColumns);
        $jsonDataUrl = '/admin/sale/salemanagerjson';



        return $this->render('saleManager', array("columns" => $column, 'jsonurl' => $jsonDataUrl));
    }

    public function actionSalemanagerjson()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonData(\Yii::$app->request, "id desc", $this->advColumns, $this->advColumnsVal,
            new PAdv(), "adv_name",'adv_id');
    }
}