<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_community".
 *
 * @property string $id
 * @property string $community_no
 * @property string $community_name
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

    public function getCompany()
    {
        return $this->hasOne(PCompany::className(), ['id' => 'company_id']);
    }
}
