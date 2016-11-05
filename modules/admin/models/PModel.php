<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_model".
 *
 * @property string $id
 * @property string $model_no
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

    public function getCompany()
    {
        return $this->hasOne(PCompany::className(), ['id' => 'company_id']);
    }
}
