<?php

namespace app\modules\admin\controllers;

class IndexController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
