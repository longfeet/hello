<?php

namespace app\modules\admin\controllers;

/**
 * 企业管理
 * Class CompanyController
 * @package app\modules\admin\controllers
 */
class CompanyController extends \yii\web\Controller
{

    public $layout='admin';

    /**
     * 部门管理
     * @return string
     */
    public function actionSectormanager()
    {
        return $this->render('sectorManager');
    }

    public function actionStaffmanager()
    {
        return $this->render('staffManager');
    }
}
