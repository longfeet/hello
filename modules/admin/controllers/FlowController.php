<?php

namespace app\modules\admin\controllers;

/**
 * 流程管理
 * Class AdvController
 * @package app\modules\admin\controllers
 */
class FlowController extends \yii\web\Controller
{

    public $layout='admin';

    /**
     * 开发流程
     * @return string
     */
    public function actionDevmanager()
    {
        return $this->render('devManager');
    }

    /**
     * 销售流程
     * @return string
     */
    public function actionSalemanager()
    {
        return $this->render('saleManager');
    }

    /**
     * 维修流程
     * @return string
     */
    public function actionMaintainmanager()
    {
        return $this->render('maintainManager');
    }
}
