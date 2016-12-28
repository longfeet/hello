<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_community".
 *
 * @property string $id
 * @property string $community_no
 * @property string $community_name
 * @property string $community_city
 * @property string $community_area
 * @property string $community_position
 * @property string $community_category
 * @property string $community_level
 * @property string $community_price
 * @property string $community_cbd
 * @property integer $community_nature
 * @property string $community_opentime
 * @property string $community_staytime
 * @property integer $community_units
 * @property integer $community_households
 * @property string $community_taboos
 * @property string $community_longitudex
 * @property string $community_latitudey
 * @property string $community_traffic
 * @property string $community_facility
 * @property string $community_image1
 * @property string $community_image2
 * @property string $community_image3
 * @property string $community_note
 * @property integer $community_status
 * @property string $company_id
 * @property integer $is_delete
 * @property string $creator
 * @property string $create_time
 * @property string $updater
 * @property string $update_time
 */
class PCommunity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_community';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_no', 'community_name', 'community_position', 'community_opentime', 'community_staytime', 'community_units', 'community_households', 'company_id'], 'required'],
            [['community_nature', 'community_units', 'community_households', 'community_status', 'company_id', 'is_delete', 'creator', 'updater'], 'integer'],
            [['community_opentime', 'community_staytime', 'create_time', 'update_time'], 'safe'],
            [['community_no', 'community_city', 'community_area', 'community_position', 'community_taboos', 'community_traffic', 'community_facility', 'community_image1', 'community_image2', 'community_image3'], 'string', 'max' => 255],
            [['community_name', 'community_category', 'community_cbd'], 'string', 'max' => 100],
            [['community_level', 'community_longitudex', 'community_latitudey'], 'string', 'max' => 50],
            [['community_price'], 'string', 'max' => 20],
            [['community_note'], 'string', 'max' => 500],
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
            'community_city' => 'Community City',
            'community_area' => 'Community Area',
            'community_position' => 'Community Position',
            'community_category' => 'Community Category',
            'community_level' => 'Community Level',
            'community_price' => 'Community Price',
            'community_cbd' => 'Community Cbd',
            'community_nature' => 'Community Nature',
            'community_opentime' => 'Community Opentime',
            'community_staytime' => 'Community Staytime',
            'community_units' => 'Community Units',
            'community_households' => 'Community Households',
            'community_taboos' => 'Community Taboos',
            'community_longitudex' => 'Community Longitudex',
            'community_latitudey' => 'Community Latitudey',
            'community_traffic' => 'Community Traffic',
            'community_facility' => 'Community Facility',
            'community_image1' => 'Community Image1',
            'community_image2' => 'Community Image2',
            'community_image3' => 'Community Image3',
            'community_note' => 'Community Note',
            'community_status' => 'Community Status',
            'company_id' => 'Company ID',
            'is_delete' => 'Is Delete',
            'creator' => 'Creator',
            'create_time' => 'Create Time',
            'updater' => 'Updater',
            'update_time' => 'Update Time',
        ];
    }

    public function getCompany()
    {
        return $this->hasOne(PCompany::className(), ['id' => 'company_id']);
    }
}
