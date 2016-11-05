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
     */
    public static function getJsonData($request, $order, $columns, $columnVals, $object, $searchField)
    {
        $seach = $request->get('search', "");
        $data = $object::find();
        $ar = $data;
        if (isset($seach['value'])) {
            $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\"");
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
                        $array[$v] = $num;
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
                            if ($element == 'editrole')
                                $array[$v] .= $editRoleHtml . $nbsp;
                            if ($element == 'edit')
                                $array[$v] .= $editHtml . $nbsp;
                            if ($element == 'delete')
                                $array[$v] .= $deleteHtml . $nbsp;
                            if ($element == 'bindrole')
                                $array[$v] .= $bindRoleHtml . $nbsp;
                            if($element == 'bindadv')
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
     * DataTables要求的Ajax Json数据(通用版)
     * @param $request 请求
     * @param $order   排序
     * @param $columns 列
     * @param $columnVals 列值字段名
     * @param $name  前缀名称，如roleEdit、roleDelete中role这个前缀即为想也页面的名称
     * @param $is_delete 该记录是否删除。 默认2（没有is_delete字段），0（未删除），1（已删除）
     * @param $company_id 公司id
     */
    public static function getJsonDataGenerl($request, $order, $columns, $columnVals, $object, $searchField, $name = "", $is_delete = 2, $company_id = 0)
    {
        $seach = $request->get('search', "");
        $data = $object::find();
        $ar = $data;
        if (isset($seach['value'])) {
            if ($is_delete == 2 && $company_id == 0)
                $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\"");
            else if ($is_delete != 2 && $company_id == 0)
                $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\" and is_delete =" . $is_delete);
            else if ($is_delete = 2 && $company_id != 0)
                $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\" and company_id =" . $company_id);
            else
                $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\" and company_id=" . $company_id . " and is_delete =" . $is_delete);
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
     */
    public static function getJsonDataStaff($request, $order, $columns, $columnVals, $object, $searchField, $name, $is_delete = 2)
    {
        $seach = $request->get('search', "");
        $data = $object::find();
        $ar = $data;
        if (isset($seach['value'])) {
            if ($is_delete == 2)
                $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\"");
            else
                $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\" and is_delete =" . $is_delete);
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
     * DataTables要求的Ajax Json数据(已弃用)
     * @param $request 请求
     * @param $order   排序
     * @param $columns 列
     * @param $columnVals 列值字段名
     * @param $company_id 公司id
     * @param $name  前缀名称，如roleEdit、roleDelete中role这个前缀即为想也页面的名称
     */
//    public static function getJsonDataMessage($request, $order, $columns, $columnVals, $object, $searchField, $company_id, $name = "")
//    {
//        $seach = $request->get('search', "");
//        $data = $object::find();
//        $ar = $data;
//        if (isset($seach['value'])) {
//            $ar = $data->where("company_id =" . $company_id . " and $searchField like \"%" . $seach['value'] . "%\"");
//        } else {
//            $ar = $data->where("company_id =" . $company_id);
//        }
//        $length = $request->get('length') ? $request->get('length') : "10";
//        $start = $request->get('start') ? $request->get('start') : "0";
//        $data = $ar->limit($length)->offset($start)->orderBy("id desc")->all();
//        $count = $ar->count();
//        $jsonArray = array(
//            'draw' => $request->get('draw') ? $request->get('draw') : "0",
//            'recordsTotal' => $object::find()->count(),
//            'recordsFiltered' => $count
//        );
//        if (count($data) == 0) {
//            $jsonArray['data'] = [];
//        }
//        $count = 10;
//        foreach ($data as $key => $val) {
//            foreach ($columns as $k => $v) {
//                if (is_array($columnVals[$k])) {
//                    $tempV = $val;
//                    for ($temp = 0; $temp < count($columnVals[$k]); $temp++) {
//                        if ($tempV != null) {
//                            if (is_array($columnVals[$k][$temp])) {
//                                foreach ($columnVals[$k][$temp] as $kkk => $vvv) {
//                                    $tempV = $tempV->$kkk->$vvv;
//                                }
//                            } else {
//                                $tempV = $tempV->$columnVals[$k][$temp];
//                            }
//                        } else {
//                            $tempV = "";
//                        }
//                    }
//                    $array[$v] = $tempV;
//                    continue;
//                }
//                if (isset($columnVals[$k]) && trim($columnVals[$k]) != "" && strpos($columnVals[$k], '<') !== 0) {
//                    $array[$v] = $val->$columnVals[$k];
//                } else {
//                    $array[$v] = "";
//                    $editHtml = "<a href='javascript:;' " . $name . "_id='" . $val->id . "' class='btn btn-success btn-xs " . $name . "Edit'>编辑</a>";
//                    $deleteHtml = "<a href='javascript:;' " . $name . "_id='" . $val->id . "' class='btn btn-danger btn-xs " . $name . "Delete'>删除</a>";
//                    $nbsp = "&nbsp;&nbsp;";
//                    if (strpos($columnVals[$k], '<') === 0) {
//                        $html = substr($columnVals[$k], 1);
//                        $html = substr($html, 0, strlen($html) - 1);
//                        $htmlArray = explode(',', $html);
//                        foreach ($htmlArray as $element) {
//                            if ($element == 'edit')
//                                $array[$v] .= $editHtml . $nbsp;
//                            if ($element == 'delete')
//                                $array[$v] .= $deleteHtml . $nbsp;
//                        }
//                    } else {
//                        $array[$v] = $editHtml . $nbsp . $deleteHtml;
//                    }
//                }
//            }
//            $jsonArray['data'][] = $array;
//        }
//        DataTools::jsonEncodeResponse($jsonArray);
//    }

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