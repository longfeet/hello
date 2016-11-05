<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_role".
 *
 * @property string $id
 * @property string $role_name
 * @property string $role_code
 * @property string $create_time
 * @property string $update_time
 */
class PRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_name', 'role_code', 'create_time', 'update_time'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['role_name'], 'string', 'max' => 50],
            [['role_code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'role_code' => 'Role Code',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
