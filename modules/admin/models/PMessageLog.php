<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_message_log".
 *
 * @property string $id
 * @property integer $message_id
 * @property integer $user_id
 * @property integer $read_time
 * @property integer $status
 */
class PMessageLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_message_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'user_id'], 'required'],
            [['message_id', 'user_id', 'read_time', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_id' => 'Message ID',
            'user_id' => 'User ID',
            'read_time' => 'Read Time',
            'status' => 'Status',
        ];
    }
}
