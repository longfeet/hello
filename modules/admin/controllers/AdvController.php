<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\PAdv;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\PCommunity;
use app\modules\admin\models\PModel;
use app\modules\admin\models\PImage;

use app\modules\admin\models\ExcelTools;
use app\modules\admin\models\PStaff;
use app\modules\admin\models\PStaffRole;
use app\modules\admin\models\PAdvStaff;
use app\modules\admin\models\FileTools;
use app\modules\admin\models\Message;
use app\modules\admin\tools\HelperTools;


/**
 * 广告点管理
 * Class AdvController
 * @package app\modules\admin\controllers
 */
class AdvController extends \yii\web\Controller
{

    public $layout = 'admin';

    /**
     * @var array 显示的数据列
     */
    public $advColumns = array("id", "adv_name", "community_name", "company_name", "edit");

    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性(最多三层)
     * @var array
     */
    public $advColumnsVal = array("id", "adv_name", array("community", "community_name"), array("company", "company_name"), "<bindadv,edit,delete>");

    /**
     *
     * @return string
     */
    public function actionManager()
    {
        $advList = PAdv::find()->all();
        //$column = DataTools::getDataTablesColumns($this->advColumns);
        //$jsonDataUrl = '/admin/adv/managerjson';
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $staff = PStaff::find()->where('company_id = "' . $company_id . '"')->select('staff_name,id')->all();

        //获取列表数据

        return $this->render('advManager', array("columns" => $column, 'jsonurl' => $jsonDataUrl,
            'advlist' => $advList, "staff" => $staff
        ));
    }

    public function actionAjaxmamger()
    {
        $post = \Yii::$app->request->post();
        $page = $post['page'] ? $post['page'] : 1;
        $count = 20;
        $name = $post['name'];
        $adv_no = $post['adv_no'];
        $postion = $post['postion'];
        $com_no = $post['com_no'];
        $value = $post['value'];
        $thisVal = $post['thisVal'];
        $range = $post['range'] ? $post['range'] : 'mine';
        $where = array(
            ' 1=1 '
        );
        if ($range === 'mine') {
            //读取用户等级和部门 
            $user_level = \Yii::$app->session['loginUser']->staff_level;
            $staff_sector = \Yii::$app->session['loginUser']->staff_sector;
            $user_id = \Yii::$app->session['loginUser']->id;
            $company_id = \Yii::$app->session['loginUser']->company_id;
            switch ($user_level) {
                case 1:
                    $where[] = " adv.creator = $user_id ";
                    break;
                case 2:
                    $where[] = " adv.creator IN ( select id from p_staff where staff_sector = $staff_sector AND company_id = $company_id ) ";
                    break;
                case 3:
                    $where[] = " adv.creator IN ( select id from p_staff where company_id = $company_id ) ";
                    break;
                case 4:
                    break;
                default :
                    die("非法请求");
                    break;
            }
        }

        if (!empty($name)) {
            $where[] = " com.community_name like '%$name%' ";
        }
        if (!empty($adv_no)) {
            $where[] = " adv.adv_no = $adv_no ";
        }
        if (!empty($postion)) {
            $where[] = " com.community_position = '$postion' ";
        }
        if (!empty($postion)) {
            $where[] = " com.community_no = $com_no ";
        }
        $st_where = array(
            ' adv.id = st.adv_id '
        );
        if (!empty($value)) {
            $where[] = " adv." . $value . " in ( " . $thisVal . " ) ";
            if ($value == 'adv_install_status') {
                $st_where[] = " st.type = 'install' ";
            } else {
                $st_where[] = " st.type = 'pic' ";
            }
            $st_where[] = " st.point_status = " . $thisVal;
        }
        $limit = (($page - 1) * $count) . ",$count ";
        $sql = "SELECT adv.*,com.community_name,cpy.company_name,count(st.id) people_num,st.id stid FROM p_adv adv "
            . " LEFT JOIN p_community com ON adv.adv_community_id = com.id "
            . " LEFT JOIN p_company cpy ON adv.company_id = cpy.id "
            . " LEFT JOIN p_adv_staff st ON ( " . implode(" AND ", $st_where) . " ) "
            . " WHERE " . implode(" AND ", $where)
            . " GROUP BY adv.id "
            . " ORDER BY  adv.id desc"
            . " LIMIT " . $limit;
        //exit(json_encode($sql));
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $list = $command->queryAll();

        $sql = "select count(DISTINCT(adv.id)) allCount from p_adv adv "
            . " LEFT JOIN p_community com ON adv.adv_community_id = com.id "
            . " LEFT JOIN p_company cpy ON adv.company_id = cpy.id "
            . " where " . implode("AND", $where)
            . " ORDER BY  adv.id desc";

        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $allCount = $command->queryOne();
        //提供分页数据
        $page_data = array(
            'page' => (int)$page,
            'count' => $count,
            'allCount' => (int)$allCount['allCount'],
            'allPage' => ceil($allCount['allCount'] / $count),
            'sql' => $sql
        );
        exit(json_encode(array('list_data' => $list, 'page_data' => $page_data, 'range' => $range)));
    }

    public function actionShowpeople()
    {
        $result = "";
        $id = \Yii::$app->request->get('id', '0');
        $advStaff = PAdvStaff::find()->where("id=" . $id)->one();
        if ($advStaff != '') {
            $result = "分配人员为：";
            $staff_ids = explode(",", $advStaff->staff_ids);
            foreach ($staff_ids as $staff_id) {
                $staff = PStaff::find()->where("id=" . $staff_id)->one();
                $result = $result . $staff->staff_name . "；";
            }
        }
        echo json_encode($result);
    }

    /**
     * 添加
     */
    public function actionAdd()
    {
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $models = PModel::find()->where('company_id = ' . $company_id)->all();
        $community = PCommunity::find()->all();
        return $this->render('advAdd', array('list' => $community, 'model' => $models));
    }

    /**
     * 广告位编辑
     * @param $id
     * @return string
     */
    public function actionEdit($id)
    {
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $adv = PAdv::find()->where('id = "' . $id . '"')->one();
        $models = PModel::find()->where('company_id = "' . $company_id . '"')->all();
        $community = PCommunity::find()->all();
        return $this->render('advEdit', array('data' => $adv, 'list' => $community, 'model' => $models));
    }

    /**
     * 广告位详情
     * @param $id
     * @return string
     */
    public function actionDetails($id)
    {
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $adv = PAdv::find()->where('id = "' . $id . '"')->one();
        $models = PModel::find()->where('company_id = "' . $company_id . '"')->all();
        $community = PCommunity::find()->all();
        return $this->render('advDetails', array('data' => $adv, 'list' => $community, 'model' => $models));
    }

    /**
     * 广告位管理表格数据
     */
    public function actionManagerjson()
    {
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonData(\Yii::$app->request, "id desc", $this->advColumns, $this->advColumnsVal,
            new PAdv(), "adv_name", 'adv_id');
    }

    public function actionDoadd()
    {
        $now = date("Y-m-d H:i:s");
        $post = \Yii::$app->request->post();
        $adv = new PAdv();
        $adv->adv_no = $post['adv_no'];
        $adv->adv_community_id = $post['adv_community_id'];
        $adv->adv_name = $post['adv_name'];
//        $adv->adv_starttime = $post['adv_starttime'];
//        $adv->adv_endtime = $post['adv_endtime'];
//        $adv->adv_image = $post['adv_image'];
        $adv->adv_property = $post['adv_property'];
        $adv->adv_position = $post['adv_position'];
        $adv->model_id = $post['model_id'];
        $adv->adv_install_status = $post['adv_install_status'];
        $adv->adv_use_status = $post['adv_use_status'];
        $adv->adv_sales_status = $post['adv_sales_status'];
        $adv->adv_pic_status = $post['adv_pic_status'];
        $adv->company_id = \Yii::$app->session['loginUser']->company_id;
        $adv->is_delete = "0";
        $adv->creator = \Yii::$app->session['loginUser']->id;
        $adv->create_time = $now;
        $adv->update_time = $now;
        if ($_FILES['adv_image']['error'] <= 0) {
            $adv->adv_image = FileTools::uploadFile($_FILES['adv_image'], 'adv');
        }
        $adv->save();

        $advID = $adv->attributes['id'];
        $advImage = $adv->attributes['adv_image'];
        //图片信息保持至图片附件表
        if ($_FILES['adv_image']['error'] <= 0) {
            $image = new PImage();
            $image->image_name = basename($advImage);
            $image->image_path = $advImage;
            $image->image_source = 1;     //1为adv表
            $image->source_id = $advID;
            $image->create_time = $now;
            $image->creator = \Yii::$app->session['loginUser']->id;
            $image->save();
        }

        //设置message消息
        $staff_name = \Yii::$app->session['loginUser']->staff_name;
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $message = $staff_name . "于" . $now . "添加了1条广告位信息，广告位编号为：" . $post['adv_no'] . ",广告位名称为：" . $post['adv_name'] . "。";
        Message::sendMessage($company_id, $message);

        $this->redirect("/admin/adv/manager");
    }

    public function actionDoedit()
    {
        $now = date("Y-m-d H:i:s");
        $post = \Yii::$app->request->post();
        $adv = PAdv::find()->where('id = "' . $post['id'] . '"')->one();
        $adv->adv_no = $post['adv_no'];
        $adv->adv_community_id = $post['adv_community_id'];
        $adv->adv_name = $post['adv_name'];
//        $adv->adv_starttime = $post['adv_starttime'];
//        $adv->adv_endtime = $post['adv_endtime'];
//        $adv->adv_image = $post['adv_image'];
        $adv->adv_property = $post['adv_property'];
        $adv->adv_position = $post['adv_position'];
        $adv->model_id = $post['model_id'];
        $adv->adv_install_status = $post['adv_install_status'];
        $adv->adv_use_status = $post['adv_use_status'];
        $adv->adv_sales_status = $post['adv_sales_status'];
        $adv->adv_pic_status = $post['adv_pic_status'];
        $adv->company_id = \Yii::$app->session['loginUser']->company_id;
        $adv->updater = \Yii::$app->session['loginUser']->id;
        $adv->update_time = $now;
        if ($_FILES['adv_image']['error'] <= 0) {
            $adv->adv_image = FileTools::uploadFile($_FILES['adv_image'], 'adv');
        }
        $adv->save();

        $advID = $adv->attributes['id'];
        $advImage = $adv->attributes['adv_image'];
        //图片信息保持至图片附件表
        if ($_FILES['adv_image']['error'] <= 0) {
            $image = new PImage();
            $image->image_name = basename($advImage);
            $image->image_path = $advImage;
            $image->image_source = 1;     //1为adv表
            $image->source_id = $advID;
            $image->create_time = $now;
            $image->creator = \Yii::$app->session['loginUser']->id;
            $image->save();
        }

        //设置message消息
        $staff_name = \Yii::$app->session['loginUser']->staff_name;
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $message = $staff_name . "于" . $now . "修改了1条广告位信息，广告位编号为：" . $post['adv_no'] . ",广告位名称为：" . $post['adv_name'] . "。";
        Message::sendMessage($company_id, $message);

        $this->redirect("/admin/adv/manager");
    }

    /*
     * ajax返回历史图片
     */
    public function actionAjaxhistoryimage()
    {
        $adv_id = \Yii::$app->request->get('adv_id', '0');
        $imageList = PImage::find()->select("image_name,image_path")->where('source_id=' . $adv_id . ' and image_source = 1')->orderBy("create_time desc")->asArray()->all();
        DataTools::jsonEncodeResponse($imageList);
    }

    /*
     * 图片下载
     */
    public function actionDownloadimage()
    {
        $file = \Yii::$app->request->get('file', null);
        FileTools::downloadFile($file, "adv");
    }

    /*
     * excel 导入
     */
    public function actionAddexcel()
    {
        return $this->render('advExcel');
    }

    public function actionDoexcel()
    {
        if ($_FILES["commExcel"]["error"] <= 0) {
            $temp = explode(".", $_FILES["commExcel"]["name"]);
            $suffix = end($temp);
            if ($suffix == "xlsx") {
                $excel = ExcelTools::getExcelObject($_FILES["commExcel"]["tmp_name"]);

                $company_id = \Yii::$app->session['loginUser']->company_id;

                $communityList = PCommunity::find()->select('id,community_name')->where('company_id=' . $company_id . ' and is_delete=0')->asArray()->all();
//                foreach($communityList as $k=>$v)
//                    echo $v["community_name"];

                $modelList = PModel::find()->select('id,model_id,model_name')->where('company_id=' . $company_id . ' and is_delete=0')->asArray()->all();

                ExcelTools::setDataIntoAdv($excel, $communityList, $modelList);
            }
        }
        $this->redirect("/admin/adv/manager");
    }

    /*
     * 广告位信息导出
     */
    public function actionExportexcel()
    {
        $post = \Yii::$app->request->post();
        $name = $post['name'];
        $adv_no = $post['adv_no'];
        $postion = $post['postion'];
        $com_no = $post['com_no'];
        $value = $post['value'];
        $thisVal = $post['thisVal'];
        $where = array(
            ' 1=1 '
        );
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $where[] = " adv.creator IN ( select id from p_staff where company_id = $company_id ) ";   //只能选取本公司
        if (!empty($name)) {
            $where[] = " com.community_name like '%$name%' ";
        }
        if (!empty($adv_no)) {
            $where[] = " adv.adv_no = $adv_no ";
        }
        if (!empty($postion)) {
            $where[] = " com.community_position = '$postion' ";
        }
        if (!empty($postion)) {
            $where[] = " com.community_no = $com_no ";
        }
        $st_where = array(
            ' adv.id = st.adv_id '
        );
        if (!empty($value)) {
            $where[] = " adv." . $value . " in ( " . $thisVal . " ) ";
            if ($value == 'adv_install_status') {
                $st_where[] = " st.type = 'install' ";
            } else {
                $st_where[] = " st.type = 'pic' ";
            }
            $st_where[] = " st.point_status = " . $thisVal;
        }
        $sql = "SELECT adv.*,com.community_name,cpy.company_name,count(st.id) people_num,st.id stid FROM p_adv adv "
            . " LEFT JOIN p_community com ON adv.adv_community_id = com.id "
            . " LEFT JOIN p_company cpy ON adv.company_id = cpy.id "
            . " LEFT JOIN p_adv_staff st ON ( " . implode(" AND ", $st_where) . " ) "
            . " WHERE " . implode(" AND ", $where)
            . " GROUP BY adv.id "
            . " ORDER BY  adv.id desc";
        //exit(json_encode($sql));
        //输出的sql为；
//        SELECT adv.*,com.community_name,cpy.company_name,count(st.id) people_num,st.id stid
//        FROM p_adv adv LEFT JOIN p_community com ON adv.adv_community_id = com.id
//        LEFT JOIN p_company cpy ON adv.company_id = cpy.id
//        LEFT JOIN p_adv_staff st ON ( adv.id = st.adv_id )
//        WHERE 1=1 AND adv.creator IN ( select id from p_staff where company_id = 1 )
//        GROUP BY adv.id ORDER BY adv.id desc

        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $list = $command->queryAll();

        foreach ($list as $key => $value) {
            foreach ($value as $k => $v) {
                //使用状态
//                if($k=="adv_use_status"){
//                    switch ($v) {
//                        case 0:
//                            $list[$key][$k] = "新增";
//                            break;
//                        case 1:
//                            $list[$key][$k] = "未使用";
//                            break;
//                        case 2:
//                            $list[$key][$k] = "已使用";
//                            break;
//                        default :
//                            break;
//                    }
//                }
                //安装状态
                if ($k == "adv_install_staus") {
                    switch ($v) {
                        case 0:
                            $list[$key][$k] = "未安装";
                            break;
                        case 1:
                            $list[$key][$k] = "待维修";
                            break;
                        case 2:
                            $list[$key][$k] = "正常使用";
                            break;
                        default :
                            break;
                    }
                }
                //销售状态
                if ($k == "adv_sales_status") {
                    switch ($v) {
                        case 0:
                            $list[$key][$k] = "销售";
                            break;
                        case 1:
                            $list[$key][$k] = "赠送";
                            break;
                        case 2:
                            $list[$key][$k] = "置换";
                            break;
                        default :
                            break;
                    }
                }
                //画面状态
                if ($k == "adv_pic_status") {
                    switch ($v) {
                        case 0:
                            $list[$key][$k] = "预定";
                            break;
                        case 1:
                            $list[$key][$k] = "待上刊";
                            break;
                        case 2:
                            $list[$key][$k] = "已上刊";
                            break;
                        case 3:
                            $list[$key][$k] = "待下刊";
                            break;
                        case 4:
                            $list[$key][$k] = "已下刊";
                            break;
                        default :
                            break;
                    }
                }
            }
        }

        //输出测试
//        foreach($list as $key=>$value) {
//            foreach ($value as $k => $v) {
//                echo $k.":".$v.";";
//            }
//            echo "<br/>";
//        }

        $filename = iconv("utf-8", "gb2312", "广告位信息.csv");
        $head = array("community_name", "adv_no", "adv_name", "adv_position", "adv_install_status", "adv_sales_status", "adv_pic_status");
        $alias = array("community_name" => "所属楼盘", "adv_no" => "广告位编号", "adv_name" => "广告位名称", "adv_position" => "广告位位置", "adv_install_status" => "安装状态", "adv_sales_status" => "销售状态", "adv_pic_status" => "画面状态");
//        $send_back = HelperTools::arrayToString($list, $head, $alias);
//        $download_size = strlen($send_back);

        ExcelTools::advExport($filename,$list);
        exit;
        //return $this->renderPartial('advExport', array("fileName" => $filename, 'downloadSize' => $download_size, 'sendBack' => $send_back));
    }

    public function actionProcess()
    {
        return $this->render('process');
    }

    public function actionFlow($id)
    {
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $adv = PAdv::find()->where('id = "' . $id . '" and company_id = "' . $company_id . '"')->one();
        $models = PModel::find()->where('company_id = "' . $company_id . '"')->all();
        $community = PCommunity::find()->where('company_id = "' . $company_id . '"')->all();
        $staff = PStaff::find()->where('company_id = "' . $company_id . '"')->all();
        return $this->render('advFlow', array('data' => $adv, 'list' => $community, 'model' => $models,
            'staff' => $staff));
    }

    public function actionDownloadexcel()
    {
        $this->redirect("/excel/模版（广告位信息）.xlsx");
    }

    public function actionAjaxeditstatus()
    {
        $post = \Yii::$app->request->post();
        $ids = $post['ids'];
        $adv_install_status = $post['adv_install_status'];
        $adv_pic_status = $post['adv_pic_status'];
        $staffs = $post['staffs'];
        $type = $post['type'];
        $set = array();
        if ($adv_install_status > -1) {
            $set[] = 'adv_install_status = ' . $adv_install_status;
//            switch ($adv_install_status) {
//                case 0:
//                    $set[] = ' adv_use_status = 0 ';
//                    break;
//                case 1:
//                    $set[] = ' adv_use_status = 1 ';
//                    break;
//                case 2:
//                    $set[] = ' adv_use_status = 2 ';
//                    break;
//            }
        }
        if ($adv_pic_status > -1) {
            $set[] = 'adv_pic_status = ' . $adv_pic_status;
//            switch ($adv_pic_status) {
//                case 2:
//                    $set[] = ' adv_use_status = 2 ';
//                    break;
//                default :
//                    $set[] = ' adv_use_status = 1 ';
//                    break;
//            }
        }
        $sql = "UPDATE p_adv SET " . implode(",", $set) . " where id IN (" . implode(",", $ids) . ")";
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $result = $command->execute();

        //设置message消息
        $id_count = count($ids);
        $now = date("Y-m-d H:i:s");
        $staff_name = \Yii::$app->session['loginUser']->staff_name;
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $info_status = "";   //提醒类型
        if ($adv_install_status > -1) {
            switch ($adv_install_status) {
                case 0:
                    $info_status = '待安装';
                    break;
                case 1:
                    $info_status = '维修';
                    break;
                case 2:
                    $info_status = '正常使用';
                    break;
            }
        }
        if ($adv_pic_status > -1) {
            switch ($adv_pic_status) {
                case 1:
                    $info_status = '预定';
                    break;
                case 1:
                    $info_status = '待上刊';
                    break;
                case 1:
                    $info_status = '已上刊';
                    break;
                case 3:
                    $info_status = '待下刊';
                    break;
                case 1:
                    $info_status = '已下刊';
                    break;
            }
        }
        $message = $staff_name . "于" . $now . "设置" . $id_count . "条广告位信息为" . $info_status . "。";
        Message::sendMessage($company_id, $message);


        //操作是否需要记录 p_adv_staff
        if (in_array($adv_install_status, array(0, 1)) || in_array($adv_pic_status, array(1, 3))) {
            $values_map = array();
            if ($adv_install_status != -1) {
                $point_status = $adv_install_status;
            } else {
                $point_status = $adv_pic_status;
            }
            foreach ($ids as $v) {
                $values_map[] = "( $v,'" . implode(",", $staffs) . "'," . time() . ",$point_status,'" . $type . "' )";
            }
            $sql = "INSERT INTO p_adv_staff (adv_id,staff_ids,ctime,point_status,type) VALUES " . implode(",", $values_map) . " ;";
            $connection = \Yii::$app->db;
            $command = $connection->createCommand($sql);
            $result = $command->execute();
        }

        exit(json_encode($result));
    }

    public function actionMap()
    {
        $community = PCommunity::find()->asArray()->all();
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $staff = PStaff::find()->where('company_id = "' . $company_id . '"')->all();
        return $this->render('advMap', array("data" => $community, "datajson" => json_encode($community), "staff" => $staff));
    }
}
