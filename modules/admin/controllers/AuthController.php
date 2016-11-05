<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\PMenu;
use app\modules\admin\models\PRole;
use app\modules\admin\models\PRoleMenu;
use app\modules\admin\models\PStaff;
use app\modules\admin\models\PStaffRole;

class AuthController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public $layout = 'admin';

    /**
     * @var array 显示的数据列
     */
    public $usercolumns = array("id","staff_name","staff_sector_name","staff_in","edit");

    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性(最多三层)
     * @var array
     */
    public $usercolumnsVal = array("id","staff_name",array("sector","sector_name"),
        array("roleId",array("role"=>"role_name")),"<bindrole>");

    /**
     * @var array 显示的数据列
     */
    public $rolecolumns = array("id","role_name","role_code","create_time","edit");

    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性
     * @var array
     */
    public $rolecolumnsVal = array("id","role_name","role_code","create_time","<editrole,edit,delete>");

    /**
     * 用户管理
     * @return string
     */
    public function actionUsermanager()
    {
        $roleList = PRole::find()->all();
        $column = DataTools::getDataTablesColumns($this->usercolumns);
        $jsonDataUrl = '/admin/auth/usermanagerjson';
        return $this->render('userManager', array("columns" => $column, 'jsonurl'=>$jsonDataUrl,
            'rolelist' => $roleList
        ));
    }

    /**
     * 用户管理表格数据
     */
    public function actionUsermanagerjson()
    {
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonData(\Yii::$app->request, "id desc", $this->usercolumns, $this->usercolumnsVal,
            new PStaff, "staff_name");
    }

    /**
     * 权限管理
     * @return string
     */
    public function actionRolemanager()
    {
        $column = DataTools::getDataTablesColumns($this->rolecolumns);
        $jsonDataUrl = '/admin/auth/rolemanagerjson';
        return $this->render('roleManager', array("columns" => $column, 'jsonurl'=>$jsonDataUrl));
    }

    /**
     * 权限管理列表数据
     */
    public function actionRolemanagerjson()
    {
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonData(\Yii::$app->request, "id desc", $this->rolecolumns, $this->rolecolumnsVal,
            new PRole, "role_code");
    }

    /**
     *
     * @return string
     */
    public function actionMenumanager()
    {
        $menuList = PMenu::getTreeMenuList();
        return $this->render('menuManager', array('menus' => $menuList));
    }

    /**
     * 获取某个角色的菜单信息
     */
    public function actionGetmenutreedata()
    {
        $role_id = \Yii::$app->request->get('role_id','0');
        $roleMenuList = PRoleMenu::find()->select('menu_id')->where('`role_id` = "' . $role_id . '"')->asArray()->all();
        $menuList = PMenu::getTreeMenuList();
        DataTools::jsonEncodeResponse(PMenu::responseTreeJsonData($menuList, DataTools::put2dArrayTo1d($roleMenuList)));
    }

    /**
     * 获取单个菜单的信息
     * @param $menu_id
     */
    public function actionGetmenuinfo($menu_id)
    {
        $menu = PMenu::find()->where('`id` = ' . $menu_id)->one()->attributes;
        $menu['childMenus'] = PMenu::find()->where('`parent_id` = ' . $menu_id)->count();
        DataTools::jsonEncodeResponse($menu);
    }

    /**
     * 更新菜单信息，添加子菜单
     * 返回 -1失败 1更新成功 2更新成功并且添加子菜单成功
     */
    public function actionUpdatemenuinfo()
    {
        $request = \Yii::$app->request;
        $menu_id = $request->post('menu_id','0');
        $menu_name = $request->post('menu_name', null);
        $menu_url = $request->post('menu_url', null);

        $sub_menu_name = trim($request->post('sub_menu_name', null)) == "" ? null : trim($request->post('sub_menu_name', null));
        $sub_menu_url = trim($request->post('sub_menu_url', null)) == "" ? null : trim($request->post('sub_menu_url', null));

        $menu = PMenu::find()->where('`id` = ' . $menu_id)->one();
        if($menu == null || $menu->id < 1) {
            echo '-1';
            exit;
        }
        $childCount = PMenu::find()->where('`parent_id` = ' . $menu_id)->count();
        $menu->menu_name = trim($menu_name) == "" ? null : trim($menu_name);
        $menu->menu_url = trim($menu_url) == "/" ? null : trim($menu_url);
        if($childCount > 0) {
            $menu->menu_url = $menu->menu_url;//有子菜单的虚菜单url不做更新
        }
        $menu->save();

        //添加子菜单
        if($sub_menu_name != null && $sub_menu_url != null) {
            $subMenu = new PMenu();
            $subMenu->menu_name = $sub_menu_name;
            $subMenu->menu_url = $sub_menu_url;
            $subMenu->parent_id = $menu_id;
            $subMenu->menu_level = $menu->menu_level + 1;
            $subMenu->create_time = date('Y-m-d H:i:s');
            $subMenu->update_time = date('Y-m-d H:i:s');
            $subMenu->save();
            echo "2";
            exit;
        }
        echo '1';
        exit;
    }

    /**
     * 删除菜单,有子菜单的菜单无法删除,需要先删除其子菜单
     * @throws \Exception
     */
    public function actionDeletemenu()
    {
        $request = \Yii::$app->request;
        $menu_id = $request->post('menu_id','0');
        $menu = PMenu::find()->where('`id` = ' . $menu_id)->one();
        if($menu != null && $menu->id > 0) {
            $childMenuCounts = PMenu::find()->where('`parent_id` = ' . $menu_id)->count();
            if($childMenuCounts < 1) {
                $menu->delete();
                echo "1";
                exit;
            } else {
                echo "0";
                exit;
            }
        }
        echo "-1";
        exit;
    }


    /**
     * 更新权限和菜单的绑定关系
     * @throws \Exception
     */
    public function actionUpdaterolemenu()
    {
        $request = \Yii::$app->request;
        $menu_ids = $request->post('ids',array());
        $role_id = $request->post('role_id','0');
        $menuIds = DataTools::put2dArrayTo1d(PRoleMenu::find()->select('menu_id')->where('`role_id` = "' . $role_id . '"')->asArray()->all());
        $deleteSet = array();//需要删除的id集合
        $insertSet = array();//需要添加的id集合
        $allSet = array_merge($menu_ids,$menuIds);
        $insertSet = array_diff($allSet, $menuIds);
        $deleteSet = array_diff($allSet, $menu_ids);
        $deleteSetString = implode(',',$deleteSet);
        if(count($deleteSet) > 0) {
            \Yii::$app->db->createCommand('delete from p_role_menu where menu_id in (' . $deleteSetString . ') and role_id = "' . $role_id . '"')->execute();
        }
        $insertSql = 'insert into p_role_menu values';
        $date = date('Y-m-d H:i:s');
        foreach($insertSet as $insertMenuId) {
            $insertSql .= '(null, "' . $insertMenuId . '", "' . $role_id . '", "' . $date . '"),';
        }
        $insertSql = substr($insertSql,0,strlen($insertSql) - 1);
        if(count($insertSet) > 0) {
            \Yii::$app->db->createCommand($insertSql)->execute();
        }
        echo "1";exit;
    }

    /**
     * 删除权限角色
     * @throws \yii\db\Exception
     */
    public function actionDeleterole()
    {
        $request = \Yii::$app->request;
        $role_id = $request->post('role_id','0');
        $role = PRole::find()->where('id = "' . $role_id . '"')->one();
        $role->delete();
        \Yii::$app->db->createCommand('delete from p_role_menu where role_id = "' . $role_id . '"')->execute();
        echo "1";exit;
    }

    /**
     * 删除权限角色
     * @throws \yii\db\Exception
     */
    public function actionAddrole()
    {
        $date = date('Y-m-d H:i:s');
        $request = \Yii::$app->request;
        $role_name = $request->post('roleName', null);
        $role_code = $request->post('roleCode', null);
        if($role_name != null && trim($role_name) != '' && $role_code != null && trim($role_code) != '') {
            $roleNameExsist = PRole::find()->where('role_name = "' . $role_name . '"')->one();
            $roleCodeExsist = PRole::find()->where('role_code = "' . $role_code . '"')->one();
            if($roleNameExsist != null) {
                echo "-2";//角色名存在
            } else if($roleCodeExsist != null) {
                echo "-3";//角色代码存在
            } else {
                $role = new PRole();
                $role->role_name = trim($role_name);
                $role->role_code = trim($role_code);
                $role->create_time = $date;
                $role->update_time = $date;
                $role->save();

                echo "1";
            }
        } else {
            if($role_name == null || trim($role_name) == '')
                echo "-1.1";
            else if ($role_code == null || trim($role_code) == '')
                echo "-1.2";
        }
        exit;
    }

    /**
     * 获取单个权限信息
     * @param $role_id
     */
    public function actionGetroleinfo($role_id)
    {
        $role = PRole::find()->where('id = "' . $role_id . '"')->one()->attributes;
        DataTools::jsonEncodeResponse($role);
    }

    /**
     * 更新权限名称和代码
     */
    public function actionUpdateroleinfo()
    {
        $date = date('Y-m-d H:i:s');
        $request = \Yii::$app->request;
        $role_name = $request->post('role_name', null);
        $role_code = $request->post('role_code', null);
        $role_id = $request->post('role_id', '0');
        $role = PRole::find()->where('id = "' . $role_id . '"')->one();
        if ($role != null) {
            $roleNameExsist = PRole::find()->where('role_name = "' . $role_name . '" and id != "' . $role_id . '"')->one();
            $roleCodeExsist = PRole::find()->where('role_code = "' . $role_code . '" and id != "' . $role_id . '"')->one();
            if ($roleNameExsist != null) {
                echo "-2";//角色名存在
            } else if ($roleCodeExsist != null) {
                echo "-3";//角色代码存在
            } else {
                $role->role_name = trim($role_name);
                $role->role_code = trim($role_code);
                $role->update_time = $date;
                $role->save();

                echo "1";
            }
        } else {
            echo "-1";//权限id不存在

        }
        exit;
    }

    /**
     * 绑定员工和角色关系
     */
    public function actionStaffbindrole()
    {
        $date = date('Y-m-d H:i:s');
        $request = \Yii::$app->request;
        $role_id = $request->post('role_id', null);
        $staff_id = $request->post('staff_id', null);
        $staff = PStaff::find()->where('id = "' . $staff_id . '"')->one();
        $role = PRole::find()->where('id = "' . $role_id . '"')->one();
        if($staff != null && $role != null) {
            $staffRoleAr = PStaffRole::find()->where('staff_id = "' . $staff_id . '"');
            $staffRole = null;
            if($staffRoleAr->count() <= 1) {
                $staffRole = $staffRoleAr->one();
            } else {
                \Yii::$app->db->createCommand('delete from p_staff_role where staff_id = "' . $staff_id . '"')->execute();
            }
            $staffRoleNew = $staffRole == null ? new PStaffRole() : $staffRole;
            $staffRoleNew->role_id = $role_id;
            $staffRoleNew->staff_id = $staff_id;
            $staffRoleNew->create_time = $date;
            $staffRoleNew->save();
            echo "1";
        } else {
            echo "-1";
        }
        exit;
    }

    /**
     * 获取员工的角色
     */
    public function actionGetuserrole()
    {
        $request = \Yii::$app->request;
        $staff_id = $request->get('staff_id', '0');
        $role = PStaffRole::find()->where('staff_id = "' .$staff_id. '"')->one();
        DataTools::jsonEncodeResponse($role == null ? null : $role->attributes);
    }
}
