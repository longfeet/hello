<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_check_control".
 *
 * @property string $id
 * @property string $company_id
 * @property integer $control_community
 * @property integer $control_adv
 * @property integer $control_model
 * @property integer $control_customer
 * @property string $updater
 * @property string $update_time
 */
class PCheckControl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_check_control';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id'], 'required'],
            [['company_id', 'control_community', 'control_adv', 'control_model', 'control_customer', 'updater'], 'integer'],
            [['update_time'], 'safe'],
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
            'control_community' => 'Control Community',
            'control_adv' => 'Control Adv',
            'control_model' => 'Control Model',
            'control_customer' => 'Control Customer',
            'updater' => 'Updater',
            'update_time' => 'Update Time',
        ];
    }
}
