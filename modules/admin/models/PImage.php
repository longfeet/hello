<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_image".
 *
 * @property string $id
 * @property string $image_name
 * @property string $image_path
 * @property integer $image_source
 * @property string $source_id
 * @property string $create_time
 * @property string $creator
 */
class PImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_source', 'source_id', 'creator'], 'integer'],
            [['create_time'], 'safe'],
            [['image_name', 'image_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_name' => 'Image Name',
            'image_path' => 'Image Path',
            'image_source' => 'Image Source',
            'source_id' => 'Source ID',
            'create_time' => 'Create Time',
            'creator' => 'Creator',
        ];
    }
}
