<?php
namespace app\modules\admin\models;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of message
 *
 * @author wangnaixin
 */
class Message {
    //put your code here
    
    public static  function sendMessage($company_id,$message){
        $sql = "INSERT INTO p_message (company_id,message_content,create_time) VALUES($company_id,'".$message."',".time()."); ";
        $connection=\Yii::$app->db;
        $command=$connection->createCommand($sql);
        $result=$command->execute();
        
        if(!empty($result)){
            $last_id= \Yii::$app->db->getLastInsertID();
            //通过 company_id 判断 分发给多少用户
            $sql = "select id from p_staff where company_id = $company_id";
            $connection=\Yii::$app->db;
            $command=$connection->createCommand($sql);
            $user_list = $command->queryAll();
            $values_map = array();
            foreach ($user_list as $v){
                $values_map[] = "($last_id,".$v['id'].",0,0)";
            }
            $sql = "INSERT INTO p_message_log (message_id,user_id,read_time,status) VALUES ".implode(",", $values_map)." ;";
            $connection=\Yii::$app->db;
            $command=$connection->createCommand($sql);
            $result=$command->execute();
            return $result;
        }
    }
    
    public static  function readMessage($user_id){
        $sql = "UPDATE p_message_log SET read_time=".time().",status=1 where user_id = $user_id ;";
        $connection=\Yii::$app->db;
        $command=$connection->createCommand($sql);
        $result=$command->execute();
    }
    public static function getMessageList($user_id,$page=1,$count=20){
        $limit_str = (($page-1)*$count ).",".$count;
        //$sql = "select * from p_message where id IN ( select message_id from p_message_log where user_id = $user_id order by status desc ) limit $limit_str ";
        $sql = "select log.status,log.read_time,msg.* from p_message_log log left join p_message msg on log.message_id = msg.id where user_id =  $user_id order by log.status desc,msg.create_time desc limit $limit_str ";
        $connection=\Yii::$app->db;
        $command=$connection->createCommand($sql);
        $message_list = $command->queryAll();
        return $message_list;
    }
}
