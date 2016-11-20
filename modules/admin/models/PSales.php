<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_sales".
 *
 * @property string $id
 * @property string $community_no
 * @property string $community_name
 * @property string $community_position
 * @property string $adv_id
 * @property string $adv_no
 * @property string $adv_name
 * @property string $company_id
 * @property string $sales_customer
 * @property string $sales_company
 * @property string $sales_starttime
 * @property string $sales_endtime
 * @property string $sales_person
 * @property integer $sales_status
 * @property string $sales_note
 * @property string $create_time
 * @property string $update_time
 */
class PSales extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_sales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adv_id', 'company_id', 'sales_company', 'sales_status'], 'integer'],
            [['company_id'], 'required'],
            [['sales_starttime', 'sales_endtime', 'create_time', 'update_time'], 'safe'],
            [['community_no', 'community_position', 'adv_no'], 'string', 'max' => 255],
            [['community_name', 'sales_person'], 'string', 'max' => 100],
            [['adv_name', 'sales_customer'], 'string', 'max' => 50],
            [['sales_note'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'community_no' => 'Community No',
            'community_name' => 'Community Name',
            'community_position' => 'Community Position',
            'adv_id' => 'Adv ID',
            'adv_no' => 'Adv No',
            'adv_name' => 'Adv Name',
            'company_id' => 'Company ID',
            'sales_customer' => 'Sales Customer',
            'sales_company' => 'Sales Company',
            'sales_starttime' => 'Sales Starttime',
            'sales_endtime' => 'Sales Endtime',
            'sales_person' => 'Sales Person',
            'sales_status' => 'Sales Status',
            'sales_note' => 'Sales Note',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
