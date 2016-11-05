<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_company".
 *
 * @property string $id
 * @property string $company_name
 * @property string $company_field
 * @property integer $staff_number
 * @property integer $is_delete
 * @property string $create_time
 * @property string $update_time
 */
class PCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'create_time', 'update_time'], 'required'],
            [['staff_number', 'is_delete'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['company_name', 'company_field'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'company_field' => 'Company Field',
            'staff_number' => 'Staff Number',
            'is_delete' => 'Is Delete',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
