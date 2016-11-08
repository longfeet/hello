<?php

namespace app\modules\admin\controllers;

class IndexController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->actionChecktask();
        return $this->render('index');
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
        echo $sql;
    }
}
