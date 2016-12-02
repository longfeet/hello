<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/18
 * Time: 21:39
 */

namespace app\modules\admin\controllers;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\Message;

use app\modules\admin\models\PMenu;
use app\modules\admin\models\PRole;
use app\modules\admin\models\PRoleMenu;
use app\modules\admin\models\PStaff;
use app\modules\admin\models\PStaffRole;
use app\modules\admin\models\PMessage;
use app\modules\admin\models\PMessageLog;

class MessageController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public $layout = 'admin';

    public $messagecolumns = array("id", "message_id", "read_time", "status");
    public $messageVal = array("id", "message_id", "read_time", "status");

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
        DataTools::getJsonDataMessage(\Yii::$app->request, "id desc", $this->messagecolumns, $this->messageVal,
            new PMessageLog, "id","messageLog", $staff);
    }

    /*
     * 读取消息
     */
    public function actionDoread()
    {
        $result = 0; //记录直行成功数量

        $date = strtotime(date('Y-m-d H:i:s'));   //时间戳
        $post = \Yii::$app->request->post();
        $ids = $post['ids'];

        //遍历设置为已读的信息
        foreach ($ids as $key => $value) {
            $messageLog = new PMessageLog();
            $messageLog = PMessageLog::find()->where("id=" . $value)->one();
            if($messageLog!=null)
            {
                $messageLog->status = 1;   //1为已读
                $messageLog->read_time = $date;
                $messageLog->save();

            }
            $result++;
        }
        echo json_encode($result);
    }

    /*
     * 全部标记为已读
     */
    public function actionDoreadall()
    {
        $result = 0; //记录直行成功数量
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];
        $result = Message::readMessage($staff->id);
        echo json_encode($result);
    }
}