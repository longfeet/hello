<?php

namespace app\modules\admin;
use app\modules\admin\models\PMenu;
use app\modules\admin\models\PMessageLog;

/**
 * admin module definition class
 */
class AdminModule extends \yii\base\Module
{
    /**
     * @var
     */
    public $layout = 'admin';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $donotneedlogin = array(
            '/admin/login/checkname',
            '/admin/login/dologin'
        );
        parent::init();
        if(MY_AUTH_FLAG) {
            $session = \Yii::$app->session;
            if ((!isset($session['loginUser']) || $session['loginUser']->id < 1) && !in_array($_SERVER['REQUEST_URI'], $donotneedlogin)) {
                parent::runAction("login", []);
                exit;
            } else {
                if (!in_array($_SERVER['REQUEST_URI'], $donotneedlogin)) {
                    $userLogin = $session['loginUser'];
                    $menulists = PMenu::getrolemenulist($userLogin->roleId->role_id, $_SERVER['REQUEST_URI']);
                    $hasMessage=false;  //是否有未读消息
                    $message = PMessageLog::find()->where("user_id = ".$userLogin->id." and status=0")->one();
                    if ($message != null) {
                        $hasMessage = true;
                    }

                    $view = \Yii::$app->view;
                    $view->params['staffName'] = $userLogin->staff_name;
                    $view->params['menuList'] = $menulists['roleMenu'];
                    $view->params['menuAuth'] = $menulists['token'];
                    $view->params['hasMessage'] = $hasMessage;
                    if($menulists['token']['is_auth'] === false) {
                        //header('Content-Type:text/html;charset=utf-8');
                        //echo "你没有该权限，请联系你的管理员!";exit;
                    }
                    if ($_SERVER['REQUEST_URI'] === '/admin') {
                        parent::runAction("index", []);
                        exit;
                    }
                }
            }
        } else {
            if ($_SERVER['REQUEST_URI'] === '/admin') {
                parent::runAction("index", []);
                exit;
            }
        }
    }
}
