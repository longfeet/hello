<?php
namespace app\modules\admin\models;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/12
 * Time: 14:33
 */
class DataTools
{

    /**
     * 拼装dataTable的返回列名json字符串
     * @param $columnsArray
     * @return string
     */
    public static function getDataTablesColumns($columnsArray)
    {
        if (is_array($columnsArray)) {
            $outString = "[";
            foreach ($columnsArray as $key => $col) {
                $outString .= "{\"data\": \"$col\"},";
            }
            $outString .= "]";
            return $outString;
        } else {
            return "";
        }
    }

    /**
     * DataTables要求的Ajax Json数据
     * @param $request 请求
     * @param $order   排序
     * @param $columns 列
     * @param $columnVals 列值字段名
     * @param $checkbox 有值标示 id 旁增加 checkbox 值 等于 checkbox name
     * @param $staff 传入session中的user
     */
    public static function getJsonData($request, $order, $columns, $columnVals, $object, $searchField, $checkbox = '', $staff = '')
    {
        $seach = $request->get('search', "");
        $data = $object::find();
        $ar = $data;
        if (isset($seach['value'])) {
            //权限控制
            if ($staff != '') {
                if ($staff->staff_level == 1)
                    $ar = $data->where("company_id =" . $staff->company_id . " and creator = " . $staff->id . " and $searchField like \"%" . $seach['value'] . "%\"");
                else if ($staff->staff_level == 2)
                    $ar = $data->where("company_id =" . $staff->company_id . " and creator in (select id from p_staff where staff_sector ='" . $staff->staff_sector . "')" . " and $searchField like \"%" . $seach['value'] . "%\"");
                else if ($staff->staff_level == 3)
                    $ar = $data->where("company_id =" . $staff->company_id . " and $searchField like \"%" . $seach['value'] . "%\"");
                else if ($staff->staff_level == 4)
                    $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\"");
            } else {
                $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\"");
            }
        } else {
            //权限控制
            if ($staff != '') {
                if ($staff->staff_level == 1)
                    $ar = $data->where("company_id =" . $staff->company_id . " and creator = " . $staff->id);
                else if ($staff->staff_level == 2)
                    $ar = $data->where("company_id =" . $staff->company_id . " and creator in (select id from p_staff where staff_sector ='" . $staff->staff_sector . "')");
                else if ($staff->staff_level == 3)
                    $ar = $data->where("company_id =" . $staff->company_id);
            }

        }
        $length = $request->get('length') ? $request->get('length') : "10";
        $start = $request->get('start') ? $request->get('start') : "0";
        $data = $ar->limit($length)->offset($start)->orderBy("id asc")->all();
        $count = $ar->count();
        $jsonArray = array(
            'draw' => $request->get('draw') ? $request->get('draw') : "0",
            'recordsTotal' => $object::find()->count(),
            'recordsFiltered' => $count
        );
        if (count($data) == 0) {
            $jsonArray['data'] = [];
        }
        $count = 10;
        $num = $start + 1;   //自定义自增长;
        foreach ($data as $key => $val) {
            foreach ($columns as $k => $v) {
                if (is_array($columnVals[$k])) {
                    $tempV = $val;
                    for ($temp = 0; $temp < count($columnVals[$k]); $temp++) {
                        if ($tempV != null) {
                            if (is_array($columnVals[$k][$temp])) {
                                foreach ($columnVals[$k][$temp] as $kkk => $vvv) {
                                    $tempV = $tempV->$kkk->$vvv;
                                }
                            } else {
                                $tempV = $tempV->$columnVals[$k][$temp];
                            }
                        } else {
                            $tempV = "";
                        }
                    }
                    $array[$v] = $tempV;
                    continue;
                }
                if (isset($columnVals[$k]) && trim($columnVals[$k]) != "" && strpos($columnVals[$k], '<') !== 0) {
                    if ($k == "id")      //序号自增长
                    {
                        if ($checkbox) {
                            $array[$v] = "<input type='checkbox' value='" . $val->id . "' name='" . $checkbox . "' />" . $num;
                        } else {
                            $array[$v] = $num;
                        }

                        $num++;
                    } else
                        $array[$v] = $val->$columnVals[$k];
                    //$array[$v] = $val->$columnVals[$k];
                } else {
                    $array[$v] = "";
                    $bindRoleHtml = "<a href='javascript:;' staff_id='" . $val->id . "' class='btn btn-success btn-xs bindRole'>关联角色</a>";
                    $editRoleHtml = "<a href='javascript:;' role_id='" . $val->id . "' class='btn btn-success btn-xs roleEditName'>更新权限名</a>";
                    $editHtml = "<a href='javascript:;' role_id='" . $val->id . "' class='btn btn-success btn-xs roleEdit'>编辑</a>";
                    $deleteHtml = '<a href=\'javascript:;\' role_id=\'' . $val->id . '\' class=\'btn btn-danger btn-xs roleDelete\'>删除</a>';
                    $bindadv = '<a href=\'javascript:;\' adv_id=\'' . $val->id . '\' class=\'btn btn-success btn-xs advBind\'>流程状态</a>';
                    $detailsHtml = '<a href=\'javascript:;\' role_id=\'' . $val->id . '\' class=\'btn btn-info btn-xs roleDetails\'>详情</a>';    //增加了详情页面
                    $nbsp = "&nbsp;&nbsp;";
                    if (strpos($columnVals[$k], '<') === 0) {
                        $html = substr($columnVals[$k], 1);
                        $html = substr($html, 0, strlen($html) - 1);
                        $htmlArray = explode(',', $html);
                        foreach ($htmlArray as $element) {
                            if ($element == 'details')
                                $array[$v] .= $detailsHtml . $nbsp;
                            if ($element == 'editrole')
                                $array[$v] .= $editRoleHtml . $nbsp;
                            if ($element == 'edit')
                                $array[$v] .= $editHtml . $nbsp;
                            if ($element == 'delete')
                                $array[$v] .= $deleteHtml . $nbsp;
                            if ($element == 'bindrole')
                                $array[$v] .= $bindRoleHtml . $nbsp;
                            if ($element == 'bindadv')
                                $array[$v] .= $bindadv . $nbsp;
                        }
                    } else {
                        $array[$v] = $detailsHtml . $nbsp . $editHtml . $nbsp . $deleteHtml;
                    }
                }
            }
            $jsonArray['data'][] = $array;
        }
        DataTools::jsonEncodeResponse($jsonArray);
    }

    /**
     * DataTables要求的Ajax Json数据
     * 用于sale销售显示
     * author breeze
     * @param $request 请求
     * @param $order   排序
     * @param $columns 列
     * @param $columnVals 列值字段名
     * @param $checkbox 有值标示 id 旁增加 checkbox 值 等于 checkbox name
     * @param $staff 传入session中的user
     * @param $communityList 传入楼宇信息
     */
    public static function getJsonSaleData($request, $order, $columns, $columnVals, $object, $searchField, $checkbox = '', $staff = '')
    {
        $seach = $request->get('search', "");
        $data = $object::find();
        $ar = $data;
        if (isset($seach['value'])) {
            //权限控制
            if ($staff != '') {
                if ($staff->staff_level == 1 || $staff->staff_level == 2 || $staff->staff_level == 3)
                    $ar = $data->where("company_id =" . $staff->company_id . " and adv_install_status=2 and (adv_use_status=0 or adv_use_status=1) and $searchField like \"%" . $seach['value'] . "%\"");
                else if ($staff->staff_level == 4)
                    $ar = $data->where("adv_install_status=2 and (adv_use_status=0 or adv_use_status=1) and $searchField like \"%" . $seach['value'] . "%\"");
            } else {
                $ar = $data->where("adv_install_status=2 and (adv_use_status=0 or adv_use_status=1) and $searchField like \"%" . $seach['value'] . "%\"");
            }
        } else {
            //权限控制
            if ($staff != '') {
                if ($staff->staff_level == 1 || $staff->staff_level == 2 || $staff->staff_level == 3)
                    $ar = $data->where("company_id =" . $staff->company_id . " and adv_install_status=2 and (adv_use_status=0 or adv_use_status=1)");
            }

        }
        $length = $request->get('length') ? $request->get('length') : "10";
        $start = $request->get('start') ? $request->get('start') : "0";
        $data = $ar->limit($length)->offset($start)->orderBy($order)->all();
        $count = $ar->count();
        $jsonArray = array(
            'draw' => $request->get('draw') ? $request->get('draw') : "0",
            'recordsTotal' => $object::find()->count(),
            'recordsFiltered' => $count
        );
        if (count($data) == 0) {
            $jsonArray['data'] = [];
        }
        $count = 10;
        $num = $start + 1;   //自定义自增长;
        foreach ($data as $key => $val) {
            foreach ($columns as $k => $v) {
                if (is_array($columnVals[$k])) {
                    $tempV = $val;
                    for ($temp = 0; $temp < count($columnVals[$k]); $temp++) {
                        if ($tempV != null) {
                            if (is_array($columnVals[$k][$temp])) {
                                foreach ($columnVals[$k][$temp] as $kkk => $vvv) {
                                    $tempV = $tempV->$kkk->$vvv;
                                }
                            } else {
                                $tempV = $tempV->$columnVals[$k][$temp];
                            }
                        } else {
                            $tempV = "";
                        }
                    }
                    $array[$v] = $tempV;
                    continue;
                }
                if (isset($columnVals[$k]) && trim($columnVals[$k]) != "" && strpos($columnVals[$k], '<') !== 0) {
                    if ($k == "id")      //序号自增长
                    {
                        if ($checkbox) {
                            $array[$v] = "<input type='checkbox' value='" . $val->id . "' name='" . $checkbox . "' />" . $num;
                        } else {
                            $array[$v] = $num;
                        }

                        $num++;
                    } else if ($v == "adv_community_id")  //楼盘名称
                    {
                        $community = PCommunity::find()->where("id=" . $val->$columnVals[$k])->one();
                        if ($community != null)
                            $array[$v] = $community->community_name;
                        else
                            $array[$v] = "";
                    } else if ($v == "adv_install_status")   //当前状态
                    {
                        if ($val->$columnVals[$k] == 0)
                            $array[$v] = "未安装";
                        else if ($val->$columnVals[$k] == 1)
                            $array[$v] = "待维修";
                        else if ($val->$columnVals[$k] == 2)
                            $array[$v] = "正常使用";
                        else
                            $array[$v] = "";
                    } else if ($v == "adv_use_status")  //使用状态
                    {
                        if ($val->$columnVals[$k] == 0)
                            $array[$v] = "新增";
                        else if ($val->$columnVals[$k] == 1)
                            $array[$v] = "未使用";
                        else if ($val->$columnVals[$k] == 2)
                            $array[$v] = "已使用";
                        else
                            $array[$v] = "";
                    } else
                        $array[$v] = $val->$columnVals[$k];
                    //$array[$v] = $val->$columnVals[$k];
                } else {
                    $array[$v] = "";
                    $bindRoleHtml = "<a href='javascript:;' staff_id='" . $val->id . "' class='btn btn-success btn-xs bindRole'>关联角色</a>";
                    $editRoleHtml = "<a href='javascript:;' role_id='" . $val->id . "' class='btn btn-success btn-xs roleEditName'>更新权限名</a>";
                    $editHtml = "<a href='javascript:;' role_id='" . $val->id . "' class='btn btn-success btn-xs roleEdit'>编辑</a>";
                    $deleteHtml = '<a href=\'javascript:;\' role_id=\'' . $val->id . '\' class=\'btn btn-danger btn-xs roleDelete\'>删除</a>';
                    $bindadv = '<a href=\'javascript:;\' adv_id=\'' . $val->id . '\' class=\'btn btn-success btn-xs advBind\'>流程状态</a>';
                    $detailsHtml = '<a href=\'javascript:;\' role_id=\'' . $val->id . '\' class=\'btn btn-info btn-xs roleDetails\'>详情</a>';    //增加了详情页面
                    $nbsp = "&nbsp;&nbsp;";
                    if (strpos($columnVals[$k], '<') === 0) {
                        $html = substr($columnVals[$k], 1);
                        $html = substr($html, 0, strlen($html) - 1);
                        $htmlArray = explode(',', $html);
                        foreach ($htmlArray as $element) {
                            if ($element == 'details')
                                $array[$v] .= $detailsHtml . $nbsp;
                            if ($element == 'editrole')
                                $array[$v] .= $editRoleHtml . $nbsp;
                            if ($element == 'edit')
                                $array[$v] .= $editHtml . $nbsp;
                            if ($element == 'delete')
                                $array[$v] .= $deleteHtml . $nbsp;
                            if ($element == 'bindrole')
                                $array[$v] .= $bindRoleHtml . $nbsp;
                            if ($element == 'bindadv')
                                $array[$v] .= $bindadv . $nbsp;
                        }
                    } else {
                        $array[$v] = $detailsHtml . $nbsp . $editHtml . $nbsp . $deleteHtml;
                    }
                }
            }
            $jsonArray['data'][] = $array;
        }
        DataTools::jsonEncodeResponse($jsonArray);
    }

    /**
     * DataTables要求的Ajax Json数据
     * 用于sale销售搜索显示
     * author breeze
     * @param $request 请求
     * @param $order   排序
     * @param $columns 列
     * @param $columnVals 列值字段名
     * @param $checkbox 有值标示 id 旁增加 checkbox 值 等于 checkbox name
     * @param $staff 传入session中的user
     * @param $communityList 传入楼宇信息
     */
    public static function getJsonSaleSearchData($request, $order, $columns, $columnVals, $object, $searchField, $checkbox = '', $staff = '')
    {
        $seach = $request->get('search', "");
        $data = $object::find();
        $ar = $data;
        if (isset($seach['value'])) {
            //权限控制
            if ($staff != '') {
                if ($staff->staff_level == 1 || $staff->staff_level == 2 || $staff->staff_level == 3)
                    $ar = $data->where("company_id =" . $staff->company_id . " and $searchField like \"%" . $seach['value'] . "%\"");
                else if ($staff->staff_level == 4)
                    $ar = $data->where(" $searchField like \"%" . $seach['value'] . "%\"");
            } else {
                $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\"");
            }
        } else {
            //权限控制
            if ($staff != '') {
                if ($staff->staff_level == 1 || $staff->staff_level == 2 || $staff->staff_level == 3)
                    $ar = $data->where("company_id =" . $staff->company_id);
            }

        }
        $length = $request->get('length') ? $request->get('length') : "10";
        $start = $request->get('start') ? $request->get('start') : "0";
        $data = $ar->limit($length)->offset($start)->orderBy($order)->all();
        $count = $ar->count();
        $jsonArray = array(
            'draw' => $request->get('draw') ? $request->get('draw') : "0",
            'recordsTotal' => $object::find()->count(),
            'recordsFiltered' => $count
        );
        if (count($data) == 0) {
            $jsonArray['data'] = [];
        }
        $count = 10;
        $num = $start + 1;   //自定义自增长;
        foreach ($data as $key => $val) {
            foreach ($columns as $k => $v) {
                if (is_array($columnVals[$k])) {
                    $tempV = $val;
                    for ($temp = 0; $temp < count($columnVals[$k]); $temp++) {
                        if ($tempV != null) {
                            if (is_array($columnVals[$k][$temp])) {
                                foreach ($columnVals[$k][$temp] as $kkk => $vvv) {
                                    $tempV = $tempV->$kkk->$vvv;
                                }
                            } else {
                                $tempV = $tempV->$columnVals[$k][$temp];
                            }
                        } else {
                            $tempV = "";
                        }
                    }
                    $array[$v] = $tempV;
                    continue;
                }
                if (isset($columnVals[$k]) && trim($columnVals[$k]) != "" && strpos($columnVals[$k], '<') !== 0) {
                    if ($k == "id")      //序号自增长
                    {
                        if ($checkbox) {
                            $array[$v] = "<input type='checkbox' value='" . $val->id . "' name='" . $checkbox . "' />" . $num;
                        } else {
                            $array[$v] = $num;
                        }

                        $num++;
                    } else if ($v == "sales_company") {
                        $customer = PCustomer::find()->where("id=" . $val->$columnVals[$k])->one();
                        if ($customer != null)
                            $array[$v] = $customer->customer_company;
                        else
                            $array[$v] = "";
                    } else if ($v == "sales_status")   //销售状态
                    {
                        if ($val->$columnVals[$k] == 0)
                            $array[$v] = "销售";
                        else if ($val->$columnVals[$k] == 1)
                            $array[$v] = "赠送";
                        else if ($val->$columnVals[$k] == 2)
                            $array[$v] = "置换";
                        else
                            $array[$v] = "";
                    } else
                        $array[$v] = $val->$columnVals[$k];
                    //$array[$v] = $val->$columnVals[$k];
                }
            }
            $jsonArray['data'][] = $array;
        }
        DataTools::jsonEncodeResponse($jsonArray);
    }

    /**
     * DataTables要求的Ajax Json数据(通用版)
     * @param $request 请求
     * @param $order   排序
     * @param $columns 列
     * @param $columnVals 列值字段名
     * @param $name  前缀名称，如roleEdit、roleDelete中role这个前缀即为想也页面的名称
     * @param $is_delete 该记录是否删除。 默认2（没有is_delete字段），0（未删除），1（已删除）
     * @param $company_id 公司id
     * @param $staff 登录者信息
     */
    public static function getJsonDataGenerl($request, $order, $columns, $columnVals, $object, $searchField, $name = "", $is_delete = 2, $company_id = 0, $staff = '')
    {
        $seach = $request->get('search', "");
        $data = $object::find();
        $ar = $data;
        if (isset($seach['value'])) {
            //权限控制
            if ($staff != '') {
                if ($staff->staff_level == 1 || $staff->staff_level == 2 || $staff->staff_level == 3)
                    $ar = $data->where("company_id =" . $staff->company_id . " and $searchField like \"%" . $seach['value'] . "%\"");
                else if ($staff->staff_level == 4)
                    $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\"");
            } else {
                $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\"");
            }
        } else {
            //权限控制
            if ($staff != '') {
                if ($staff->staff_level == 1 || $staff->staff_level == 2 || $staff->staff_level == 3)
                    $ar = $data->where("company_id =" . $staff->company_id);
            }
        }
        $length = $request->get('length') ? $request->get('length') : "10";
        $start = $request->get('start') ? $request->get('start') : "0";
        $data = $ar->limit($length)->offset($start)->orderBy($order)->all();
        $count = $ar->count();
        $jsonArray = array(
            'draw' => $request->get('draw') ? $request->get('draw') : "0",
            'recordsTotal' => $object::find()->count(),
            'recordsFiltered' => $count
        );
        if (count($data) == 0) {
            $jsonArray['data'] = [];
        }

        $num = $start + 1;   //自定义自增长;
        foreach ($data as $key => $val) {
            foreach ($columns as $k => $v) {
                if (is_array($columnVals[$k])) {
                    $tempV = $val;
                    for ($temp = 0; $temp < count($columnVals[$k]); $temp++) {
                        if ($tempV != null) {
                            if (is_array($columnVals[$k][$temp])) {
                                foreach ($columnVals[$k][$temp] as $kkk => $vvv) {
                                    $tempV = $tempV->$kkk->$vvv;
                                }
                            } else {
                                $tempV = $tempV->$columnVals[$k][$temp];
                            }
                        } else {
                            $tempV = "";
                        }
                    }
                    $array[$v] = $tempV;
                    continue;
                }
                if (isset($columnVals[$k]) && trim($columnVals[$k]) != "" && strpos($columnVals[$k], '<') !== 0) {
                    if ($k == "id")      //序号自增长
                    {
                        $array[$v] = $num;
                        $num++;
                    } else
                        $array[$v] = $val->$columnVals[$k];
                    //$array[$v] = $val->$columnVals[$k];
                } else {
                    $array[$v] = "";
                    $detailsHtml = "<a href='javascript:;' " . $name . "_id='" . $val->id . "' class='btn btn-info btn-xs " . $name . "Details'>详情</a>";
                    $editHtml = "<a href='javascript:;' " . $name . "_id='" . $val->id . "' class='btn btn-success btn-xs " . $name . "Edit'>编辑</a>";
                    $deleteHtml = "<a href='javascript:;' " . $name . "_id='" . $val->id . "' class='btn btn-danger btn-xs " . $name . "Delete'>删除</a>";
                    $nbsp = "&nbsp;&nbsp;";
                    if (strpos($columnVals[$k], '<') === 0) {
                        $html = substr($columnVals[$k], 1);
                        $html = substr($html, 0, strlen($html) - 1);
                        $htmlArray = explode(',', $html);
                        foreach ($htmlArray as $element) {
                            if ($element == 'details')
                                $array[$v] .= $detailsHtml . $nbsp;
                            if ($element == 'edit')
                                $array[$v] .= $editHtml . $nbsp;
                            if ($element == 'delete')
                                $array[$v] .= $deleteHtml . $nbsp;
                        }
                    } else {
                        $array[$v] = $editHtml . $nbsp . $deleteHtml;
                    }
                }
            }
            $jsonArray['data'][] = $array;
        }
        DataTools::jsonEncodeResponse($jsonArray);
    }

    /**
     * 专用
     * DataTables要求的Ajax Json数据,专用于人员staff表
     * @param $request 请求
     * @param $order   排序
     * @param $columns 列
     * @param $columnVals 列值字段名
     * @param $name  前缀名称，如roleEdit、roleDelete中role这个前缀即为想也页面的名称
     * @param $is_delete 该记录是否删除。 默认2（没有is_delete字段），0（未删除），1（已删除）
     * @param $staff 登录者信息
     */
    public static function getJsonDataStaff($request, $order, $columns, $columnVals, $object, $searchField, $name, $is_delete = 2, $staff = '')
    {
        $seach = $request->get('search', "");
        $data = $object::find();
        $ar = $data;
        if (isset($seach['value'])) {
            //权限控制
            if ($staff != '') {
                if ($staff->staff_level == 1 || $staff->staff_level == 2 || $staff->staff_level == 3)
                    $ar = $data->where("company_id =" . $staff->company_id . " and is_delete = 0 and $searchField like \"%" . $seach['value'] . "%\"");
                else if ($staff->staff_level == 4)
                    $ar = $data->where("is_delete = 0 and $searchField like \"%" . $seach['value'] . "%\"");
            } else {
                $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\"");
            }
        } else {
            //权限控制
            if ($staff != '') {
                if ($staff->staff_level == 1 || $staff->staff_level == 2 || $staff->staff_level == 3)
                    $ar = $data->where("company_id =" . $staff->company_id . " and is_delete = 0");
                else if ($staff->staff_level == 4)
                    $ar = $data->where("is_delete = 0");
            }
        }
        $length = $request->get('length') ? $request->get('length') : "10";
        $start = $request->get('start') ? $request->get('start') : "0";
        $data = $ar->limit($length)->offset($start)->orderBy("id asc")->all();
        $count = $ar->count();
        $jsonArray = array(
            'draw' => $request->get('draw') ? $request->get('draw') : "0",
            'recordsTotal' => $object::find()->count(),
            'recordsFiltered' => $count
        );
        if (count($data) == 0) {
            $jsonArray['data'] = [];
        }

        $num = $start + 1;   //自定义自增长;
        foreach ($data as $key => $val) {
            foreach ($columns as $k => $v) {
                if (is_array($columnVals[$k])) {
                    $tempV = $val;
                    for ($temp = 0; $temp < count($columnVals[$k]); $temp++) {
                        if ($tempV != null) {
                            if (is_array($columnVals[$k][$temp])) {
                                foreach ($columnVals[$k][$temp] as $kkk => $vvv) {
                                    $tempV = $tempV->$kkk->$vvv;
                                }
                            } else {
                                $tempV = $tempV->$columnVals[$k][$temp];
                            }
                        } else {
                            $tempV = "";
                        }
                    }
                    $array[$v] = $tempV;
                    continue;
                }
                if (isset($columnVals[$k]) && trim($columnVals[$k]) != "" && strpos($columnVals[$k], '<') !== 0) {
                    if ($k == "id")      //序号自增长
                    {
                        $array[$v] = $num;
                        $num++;
                    } else {
                        $array[$v] = $val->$columnVals[$k];
                        //根据公司id加工获得公司名称
                        if ($columns[$k] == "company_id") {
                            $company = PCompany::find()->where("id=" . $val->$columnVals[$k])->one();
                            if ($company != null)
                                $array[$v] = $company->company_name;
                            else
                                $array[$v] = "";
                        }
                        //根据部门id加工获得部门名称
                        if ($columns[$k] == "staff_sector") {
                            $sector = PSector::find()->where("id=" . $val->$columnVals[$k])->one();
                            if ($sector != null)
                                $array[$v] = $sector->sector_name;
                            else
                                $array[$v] = "";
                        }
                    }
                } else {
                    $array[$v] = "";
                    $editHtml = "<a href='javascript:;' " . $name . "_id='" . $val->id . "' class='btn btn-success btn-xs " . $name . "Edit'>编辑</a>";
                    $deleteHtml = "<a href='javascript:;' " . $name . "_id='" . $val->id . "' class='btn btn-danger btn-xs " . $name . "Delete'>删除</a>";
                    $nbsp = "&nbsp;&nbsp;";
                    if (strpos($columnVals[$k], '<') === 0) {
                        $html = substr($columnVals[$k], 1);
                        $html = substr($html, 0, strlen($html) - 1);
                        $htmlArray = explode(',', $html);
                        foreach ($htmlArray as $element) {
                            if ($element == 'edit')
                                $array[$v] .= $editHtml . $nbsp;
                            if ($element == 'delete')
                                $array[$v] .= $deleteHtml . $nbsp;
                        }
                    } else {
                        $array[$v] = $editHtml . $nbsp . $deleteHtml;
                    }
                }
            }
            $jsonArray['data'][] = $array;
        }
        DataTools::jsonEncodeResponse($jsonArray);
    }

    /**
     * DataTables要求的Ajax Json数据(用于message)
     * @param $request 请求
     * @param $order   排序
     * @param $columns 列
     * @param $columnVals 列值字段名
     * @param $name  前缀名称，如roleEdit、roleDelete中role这个前缀即为想也页面的名称
     * @param $staff 登录者信息
     */
    public static function getJsonDataMessage($request, $order, $columns, $columnVals, $object, $searchField, $name = "", $staff = '')
    {
        $seach = $request->get('search', "");
        $data = $object::find();
        $ar = $data;

        if (isset($seach['value'])) {
            //$ar = $data->where("user_id =" . $staff->id." and $searchField like \"%" . $seach['value'] . "%\"");
            $ar = $data->where("user_id =" . $staff->id);
        } else {
            $ar = $data->where("user_id =" . $staff->id);
        }
        $length = $request->get('length') ? $request->get('length') : "10";
        $start = $request->get('start') ? $request->get('start') : "0";
        $data = $ar->limit($length)->offset($start)->orderBy($order)->all();
        $count = $ar->count();
        $jsonArray = array(
            'draw' => $request->get('draw') ? $request->get('draw') : "0",
            'recordsTotal' => $object::find()->count(),
            'recordsFiltered' => $count
        );
        if (count($data) == 0) {
            $jsonArray['data'] = [];
        }

        $num = $start + 1;   //自定义自增长;
        foreach ($data as $key => $val) {
            $create_time = "";   //message中的create_time
            foreach ($columns as $k => $v) {
                if (is_array($columnVals[$k])) {
                    $tempV = $val;
                    for ($temp = 0; $temp < count($columnVals[$k]); $temp++) {
                        if ($tempV != null) {
                            if (is_array($columnVals[$k][$temp])) {
                                foreach ($columnVals[$k][$temp] as $kkk => $vvv) {
                                    $tempV = $tempV->$kkk->$vvv;
                                }
                            } else {
                                $tempV = $tempV->$columnVals[$k][$temp];
                            }
                        } else {
                            $tempV = "";
                        }
                    }
                    $array[$v] = $tempV;
                    continue;
                }
                if (isset($columnVals[$k]) && trim($columnVals[$k]) != "" && strpos($columnVals[$k], '<') !== 0) {
                    if ($k == "id")      //序号自增长
                    {
                        $array[$v] =  "<input type='checkbox' value='" . $val->id . "' name='" . $name . "' />&nbsp;&nbsp;" .$num;
                        $num++;
                    } else
                    {
                        $array[$v] = $val->$columnVals[$k];
                        //根据消息id加工获得消息内容
                        if ($columns[$k] == "message_id") {
                            $message=PMessage::find()->where("id=" . $val->$columnVals[$k])->one();
                            if ($message != null){
                                $array[$v] = $message->message_content;
                                $create_time= $message->create_time;
                            } else
                                $array[$v] = "";
                        }
                        //设置已读、未读
                        if ($columns[$k] == "status") {
                            if($val->$columnVals[$k] == 0)
                                $array[$v] = "待阅读";
                            else
                                $array[$v] = "已读";
                        }
                        //设置发布时间
                        if($columns[$k] == "read_time")
                        {
                            $array[$v] =$create_time;
                        }
                    }

                    //$array[$v] = $val->$columnVals[$k];
                }
            }
            $jsonArray['data'][] = $array;
        }
        DataTools::jsonEncodeResponse($jsonArray);
    }

    /**
     * 作为json字符串返回
     * @param $json
     */
    public static function jsonEncodeResponse($json)
    {
        header('Content-Type: text/json; charset=utf-8');
        echo json_encode($json);
        exit;
    }

    /**
     * 将2维的单列数组写成1维的有序数组
     * array('0'=>array('menu_id' = > 1)) ==> array(1)
     * @param $d2array
     * @return array
     */
    public static function put2dArrayTo1d($d2array)
    {
        $array = array();
        foreach ($d2array as $d1array) {
            foreach ($d1array as $value) {
                $array[] = $value;
            }
        }
        return $array;
    }
}