<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_sector".
 *
 * @property string $id
 * @property string $sector_name
 * @property string $sector_financial_no
 * @property integer $sector_level
 * @property integer $sector_count
 * @property string $sector_fid
 * @property integer $sector_order_no
 * @property string $sector_sid
 * @property string $sector_city
 * @property string $create_time
 * @property string $update_time
 */
class PSector extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_sector';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sector_name', 'create_time', 'update_time'], 'required'],
            [['sector_level', 'sector_count', 'sector_fid', 'sector_order_no', 'sector_sid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['sector_name'], 'string', 'max' => 50],
            [['sector_financial_no'], 'string', 'max' => 30],
            [['sector_city'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sector_name' => 'Sector Name',
            'sector_financial_no' => 'Sector Financial No',
            'sector_level' => 'Sector Level',
            'sector_count' => 'Sector Count',
            'sector_fid' => 'Sector Fid',
            'sector_order_no' => 'Sector Order No',
            'sector_sid' => 'Sector Sid',
            'sector_city' => 'Sector City',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
