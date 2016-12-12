<?php

    namespace app\modules\admin\controllers;
    use app\modules\admin\models\PStaff;
    use app\modules\admin\models\PCheckControl;

    /**
     * 广告点管理
     * Class AdvController
     * @package app\modules\admin\controllers
     */
class LoginController extends \yii\web\Controller
{

    public $layout = 'empty';

    /**
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 登录
     * @return string
     */
    public function actionDologin()
    {
        $request = \Yii::$app->request;
        $username = $request->post('username', null);
        $password = $request->post('password', null);
        if(trim($username) == null || trim($username) == '') {
            exit('-1');//用户名不能为空
        }
        if(trim($password) == null || trim($password) == '') {
            exit('-2');//密码不能为空
        }
        $staffAr = PStaff::find()->where('staff_name = "' . $username . '"');
        if($staffAr->count() != 1) {
            exit('-3');//用户名不存在
        }
        $staff = $staffAr->one();
        if($staff->password !== md5($password)) {
            exit('-4');//密码不正确
        } else {
            $checkControl = PCheckControl::find()->where("company_id=".$staff->company_id)->one();

            $session = \Yii::$app->session;
            $session->set('loginUser', $staff);
            $session->set('check', $checkControl);
        }
        exit('1');
    }

    /**
     * 退出登录
     */
    public function actionDologout()
    {
        $session = \Yii::$app->session;
        unset($session['loginUser']);
        $this->redirect('/admin/login/index');
    }

    /**
     * 检验用户名
     */
    public function actionCheckname()
    {
        $request = \Yii::$app->request;
        $username = $request->post('username', null);
        if(trim($username) == null || trim($username) == '') {
            exit('-1');//用户名不能为空
        }
        $staffAr = PStaff::find()->where('staff_name = "' . $username . '"');
        if($staffAr->count() != 1) {
            exit('-2');//用户名不存在
        }
        exit('1');
    }
}
