<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_menu".
 *
 * @property string $id
 * @property string $menu_name
 * @property string $menu_url
 * @property string $parent_id
 * @property integer $menu_level
 * @property string $menu_note
 * @property string $create_time
 * @property string $update_time
 */
class PMenu extends \yii\db\ActiveRecord
{
    public $childMenus;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_name', 'menu_url', 'parent_id', 'menu_level', 'create_time', 'update_time'], 'required'],
            [['parent_id', 'menu_level'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['menu_name'], 'string', 'max' => 50],
            [['menu_url', 'menu_note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_name' => 'Menu Name',
            'menu_url' => 'Menu Url',
            'parent_id' => 'Parent ID',
            'menu_level' => 'Menu Level',
            'menu_note' => 'Menu Note',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * 获取菜单树列表
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getTreeMenuList() {
        $menuList = PMenu::getSubMenuList(0);
        return $menuList;
    }

    /**
     * 返回JSTree需要的json数据
     * @param $menulist
     * @param $roleMenuList
     * @return array
     */
    public static function responseTreeJsonData($menulist, $roleMenuList = null) {
        $jsonArray = array();
        foreach($menulist as $key=>$menu) {
            $jsonArray[$key]['text'] = $menu->menu_name;
            $jsonArray[$key]['id'] = $menu->id;
            if(count($menu->childMenus) > 0) {
                $jsonArray[$key]['children'] = PMenu::responseTreeJsonData($menu->childMenus, $roleMenuList);
                $jsonArray[$key]['state']['opened'] = "true";
                $jsonArray[$key]['icon']= "glyphicon glyphicon-folder-open";
            }
            if(in_array($menu->id,$roleMenuList)) {
                $jsonArray[$key]['state']['selected'] = "true";
            }
        }
        return $jsonArray;
    }

    /**
     * 获取某个菜单的全部子菜单
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getSubMenuList($id) {
        $menuList = PMenu::find()->where('`parent_id` = "' . $id . '"')->all();
        foreach($menuList as &$li) {
            $li['childMenus'] = PMenu::getSubMenuList($li['id']);
        }
        return $menuList;
    }

    /**
     * 获取用户的权限子菜单
     * @param $roleMenuIdList
     * @param $parent_id
     * @param $request_url
     * @param $token
     * @return array
     */
    public static function getSubRoleMenuList($roleMenuIdList, $parent_id, $request_url, &$token) {
        $roleMenu = Yii::$app->db->createCommand('select * from p_menu where parent_id = ' . $parent_id .
            ' and (id in (SELECT parent_id FROM `p_menu` where id in(
            \'0\',"' . implode('","', DataTools::put2dArrayTo1d($roleMenuIdList)) . '"))
            or id in (\'0\',"' . implode('","', DataTools::put2dArrayTo1d($roleMenuIdList)) . '")) order by id asc')->queryAll();
        foreach($roleMenu as &$li) {
            if($li['menu_url'] === $request_url && $token['is_auth'] === false) {
                $token['is_auth'] = true;
                $token['menu_id'] = $li['id'];
            }
            $li['childMenus'] = PMenu::getSubRoleMenuList($roleMenuIdList, $li['id'], $request_url, $token);
        }
        return $roleMenu;
    }

    /**
     * 根据权限id获取菜单列表
     * @param $role_id
     * @param $request_url
     * @return array
     */
    public static function getrolemenulist($role_id, $request_url)
    {
        $roleMenuIdList = array();
        $roleMenuIdListAr = PRoleMenu::find()->select('menu_id')->where('role_id = "' . $role_id . '"');
        if($roleMenuIdListAr != null) {
            $roleMenuIdList = $roleMenuIdListAr->all();
        }
        $token = array(
            'is_auth' => false,  //当前菜单是否有权限访问
            'root_menu_id' => 0, //当前主菜单的id
            'menu_id' => 0,      //当前菜单的id
        );
        $roleMenu = PMenu::getSubRoleMenuList($roleMenuIdList, 0, $request_url, $token);
        $token['root_menu_id'] = PMenu::getMenuRootId($token['menu_id']);
        return array('roleMenu' => $roleMenu, 'token' => $token);
    }

    /**
     * 按照menu_url查询菜单信息
     * @param $menu_url
     * @return PMenu|array|null|\yii\db\ActiveRecord
     */
    public static function getMenuInfoByMenuUrl($menu_url)
    {
        $menu = PMenu::find()->where('menu_url = "' .$menu_url. '"')->one();
        return $menu == null ? new PMenu() : $menu;
    }

    public static function getMenuRootId($menu_id) {
        $menu = PMenu::find()->where('id = "' .$menu_id. '"')->one();
        if($menu == null || $menu->parent_id === '0') return $menu_id;
        else return PMenu::getMenuRootId($menu->parent_id);
    }
}
