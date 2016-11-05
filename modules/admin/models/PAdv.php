<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_adv".
 *
 * @property string $id
 * @property string $adv_no
 * @property string $adv_community_id
 * @property string $adv_name
 * @property string $adv_position
 * @property string $adv_starttime
 * @property string $adv_endtime
 * @property string $adv_image
 * @property integer $adv_property
 * @property string $model_id
 * @property string $adv_model
 * @property integer $adv_install_status
 * @property integer $adv_use_status
 * @property integer $adv_sales_status
 * @property integer $adv_pic_status
 * @property string $adv_note
 * @property integer $adv_status
 * @property string $company_id
 * @property integer $is_delete
 * @property string $creator
 * @property string $create_time
 * @property string $updater
 * @property string $update_time
 */
class PAdv extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_adv';
    }

    public function getCommunity()
    {
        return $this->hasOne(PCommunity::className(), ['id' => 'adv_community_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(PCompany::className(), ['id' => 'company_id']);
    }
}
