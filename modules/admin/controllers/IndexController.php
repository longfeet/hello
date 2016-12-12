<?php

namespace app\modules\admin\controllers;

class IndexController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $session = \Yii::$app->session;
        $staffInfo = $session['loginUser'];

        $sql = "select menu_url from p_menu where id in (select menu_id from p_role_menu where role_id=(select role_id from p_staff_role where staff_id=".$staffInfo->id."))";
        //exit(json_encode($sql));
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $list = $command->queryAll();    //获得该用户对应的menu

        $menuList = array();
        foreach($list as $key=>$value)
        {
            $list[]=$value["menu_url"];
        }

        $this->actionChecktask();
        return $this->render('index',array('list' => $list));
    }
    
    public function actionChecktask(){
        //处理是否需要执行脚本
        $file = "task_time.log";
        if(file_exists($file)){
            $last_time = file_get_contents($file);
            if(($last_time + 86400) < time()){
                $this->actionDotask();
            }
        }else{
            $this->actionDotask();
        }
       
    }
    
    public function actionDotask(){
        file_put_contents("task_time.log", strtotime(date("Y-m-d",time())));
        //todo sql  adv_use_status = 1  adv_pic_status = 4
        $sql = "UPDATE p_adv SET adv_use_status = 1, adv_pic_status = 4 where unix_timestamp(adv_endtime) < ".time();
        $connection=\Yii::$app->db;
        $command=$connection->createCommand($sql);
        $result=$command->execute();
        
    }
}
