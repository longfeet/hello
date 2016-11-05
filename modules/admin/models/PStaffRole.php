<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_staff_role".
 *
 * @property string $id
 * @property string $role_id
 * @property string $staff_id
 * @property string $create_time
 */
class PStaffRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_staff_role';
    }

    public function getRole()
    {
        return $this->hasOne(PRole::className(), ['id' => 'role_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'create_time'], 'required'],
            [['role_id', 'staff_id'], 'integer'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'staff_id' => 'Staff ID',
            'create_time' => 'Create Time',
        ];
    }
}
