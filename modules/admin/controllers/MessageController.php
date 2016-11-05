<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/18
 * Time: 21:39
 */

namespace app\modules\admin\controllers;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\PMenu;
use app\modules\admin\models\PRole;
use app\modules\admin\models\PRoleMenu;
use app\modules\admin\models\PStaff;
use app\modules\admin\models\PStaffRole;
use app\modules\admin\models\PMessage;

class MessageController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public $layout = 'admin';

    public $messagecolumns = array("id", "message_content", "create_time");
    public $messageVal = array("id", "message_content", "create_time");

    /**
     * @return string
     * 消息展示页
     */
    public function actionMessagemanager()
    {
        $column = DataTools::getDataTablesColumns($this->messagecolumns);
        $jsonDataUrl = '/admin/message/messagemanagerjson';
        return $this->render('messageManager', array("columns" => $column, 'jsonurl' => $jsonDataUrl));
    }

    public function actionMessagemanagerjson()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];
        DataTools::getJsonDataGenerl(\Yii::$app->request, "id desc", $this->messagecolumns, $this->messageVal,
            new PMessage, "message_content","",2, $staff->company_id);
    }
}