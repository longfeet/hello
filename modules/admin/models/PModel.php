<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_model".
 *
 * @property string $id
 * @property string $model_id
 * @property string $model_name
 * @property string $model_category
 * @property string $model_desc
 * @property string $model_size
 * @property string $model_display
 * @property string $model_factory
 * @property string $model_use
 * @property string $model_note
 * @property integer $model_status
 * @property string $company_id
 * @property integer $is_delete
 * @property string $creator
 * @property string $create_time
 * @property string $updater
 * @property string $update_time
 */
class PModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'model_category'], 'required'],
            [['model_status', 'company_id', 'is_delete', 'creator', 'updater'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['model_id', 'model_category'], 'string', 'max' => 50],
            [['model_name'], 'string', 'max' => 20],
            [['model_desc', 'model_use'], 'string', 'max' => 255],
            [['model_size', 'model_display'], 'string', 'max' => 25],
            [['model_factory'], 'string', 'max' => 100],
            [['model_note'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model ID',
            'model_name' => 'Model Name',
            'model_category' => 'Model Category',
            'model_desc' => 'Model Desc',
            'model_size' => 'Model Size',
            'model_display' => 'Model Display',
            'model_factory' => 'Model Factory',
            'model_use' => 'Model Use',
            'model_note' => 'Model Note',
            'model_status' => 'Model Status',
            'company_id' => 'Company ID',
            'is_delete' => 'Is Delete',
            'creator' => 'Creator',
            'create_time' => 'Create Time',
            'updater' => 'Updater',
            'update_time' => 'Update Time',
        ];
    }
}
