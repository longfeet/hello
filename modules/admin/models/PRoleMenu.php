<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_role_menu".
 *
 * @property string $id
 * @property string $menu_id
 * @property string $role_id
 * @property string $create_time
 */
class PRoleMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_role_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'role_id', 'create_time'], 'required'],
            [['menu_id', 'role_id'], 'integer'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu ID',
            'role_id' => 'Role ID',
            'create_time' => 'Create Time',
        ];
    }
}
