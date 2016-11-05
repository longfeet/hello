<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_customer".
 *
 * @property string $id
 * @property string $customer_company
 * @property string $customer_address
 * @property string $customer_contact
 * @property string $customer_phone
 * @property string $customer_email
 * @property string $customer_industry
 * @property string $company_id
 * @property string $creator
 * @property string $create_time
 * @property string $updater
 * @property string $update_time
 */
class PCustomer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_company', 'customer_address', 'customer_contact', 'customer_industry', 'company_id'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['updater'], 'integer'],
            [['customer_company', 'customer_email'], 'string', 'max' => 100],
            [['customer_address'], 'string', 'max' => 255],
            [['customer_contact'], 'string', 'max' => 20],
            [['customer_phone', 'customer_industry'], 'string', 'max' => 50],
            [['company_id', 'creator'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_company' => 'Customer Company',
            'customer_address' => 'Customer Address',
            'customer_contact' => 'Customer Contact',
            'customer_phone' => 'Customer Phone',
            'customer_email' => 'Customer Email',
            'customer_industry' => 'Customer Industry',
            'company_id' => 'Company ID',
            'creator' => 'Creator',
            'create_time' => 'Create Time',
            'updater' => 'Updater',
            'update_time' => 'Update Time',
        ];
    }
}
