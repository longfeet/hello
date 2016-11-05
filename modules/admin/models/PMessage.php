<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_message".
 *
 * @property string $id
 * @property string $company_id
 * @property string $message_content
 * @property string $create_time
 */
class PMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id'], 'required'],
            [['company_id'], 'integer'],
            [['create_time'], 'safe'],
            [['message_content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'message_content' => 'Message Content',
            'create_time' => 'Create Time',
        ];
    }
}
