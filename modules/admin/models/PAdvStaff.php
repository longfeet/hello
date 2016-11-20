<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_adv_staff".
 *
 * @property string $id
 * @property integer $adv_id
 * @property string $staff_ids
 * @property integer $ctime
 * @property integer $point_status
 * @property string $type
 */
class PAdvStaff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_adv_staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adv_id', 'staff_ids', 'ctime', 'point_status'], 'required'],
            [['adv_id', 'ctime', 'point_status'], 'integer'],
            [['staff_ids'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adv_id' => 'Adv ID',
            'staff_ids' => 'Staff Ids',
            'ctime' => 'Ctime',
            'point_status' => 'Point Status',
            'type' => 'Type',
        ];
    }
}
