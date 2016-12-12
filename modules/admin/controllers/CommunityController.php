<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\FileTools;
use app\modules\admin\models\PAdv;
use app\modules\admin\models\PCommunity;
use app\modules\admin\models\PImage;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\ExcelTools;
use app\modules\admin\models\PPTools;
use app\modules\admin\models\Message;

/**
 * 小区管理
 * Class CommunityController
 * @package app\modules\admin\controllers
 */
class CommunityController extends \yii\web\Controller
{

    public $layout = 'admin';

    /**
     * @var array 显示的数据列
     */
    public $communityColumns = array("id", "community_no", "community_name", "community_position", "community_category", "community_cbd", "company_name", "edit");

    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性(最多三层)
     * @var array
     */
    public $communityColumnsVal = array("id", "community_no", "community_name", "community_position", "community_category", "community_cbd", array("company", "company_name"), "");
    public $communityCheckColumnsVal = array("id", "community_no", "community_name", "community_position", "community_category", "community_cbd", array("company", "company_name"), "<details>");

    /**
     * 楼盘列表
     * @return string
     */
    public function actionManager()
    {
        $communityList = PCommunity::find()->all();
        $column = DataTools::getDataTablesColumns($this->communityColumns);
        $jsonDataUrl = '/admin/community/managerjson';
        return $this->render('communityManager', array("columns" => $column, 'jsonurl' => $jsonDataUrl,
            'rolelist' => $communityList
        ));
    }

    /**
     * 楼盘管理表格数据
     */
    public function actionManagerjson()
    {
        $staff = \Yii::$app->session['loginUser'];
        $checkWhere = " and community_status in (0,7)";
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonDataCommunity(\Yii::$app->request, "id desc", $this->communityColumns, $this->communityColumnsVal,
            new PCommunity(), "community_name", "", $staff, $checkWhere);
    }

    /**
     *楼盘审核列表（添加）
     * @return string
     */
    public function actionCheckadd()
    {
        $communityList = PCommunity::find()->all();
        $column = DataTools::getDataTablesColumns($this->communityColumns);
        $jsonDataUrl = '/admin/community/checkaddjson';
        return $this->render('communityCheckAdd', array("columns" => $column, 'jsonurl' => $jsonDataUrl,
            'rolelist' => $communityList
        ));
    }

    public function actionCheckaddjson()
    {
        $staff = \Yii::$app->session['loginUser'];
        $checkWhere = " and community_status=1";
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonDataCommunity(\Yii::$app->request, "id desc", $this->communityColumns, $this->communityCheckColumnsVal,
            new PCommunity(), "community_name", "community_id", $staff, $checkWhere);
    }

    /*
     * 处理审核（添加）
     */
    public function actionDocheck()
    {
        $post = \Yii::$app->request->post();
        $ids = $post['ids'];
        $community_status = $post['community_status'];
        $status = $post['status'];

        $sql = "UPDATE p_community SET community_status=" . $community_status . " where id IN (" . implode(",", $ids) . ")";
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $result = $command->execute();

        //设置message消息
        $id_count = count($ids);
        $now = date("Y-m-d H:i:s");
        $staff_name = \Yii::$app->session['loginUser']->staff_name;
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $message = $staff_name . "于" . $now . $status . $id_count . "条楼盘信息为。";
        Message::sendMessage($company_id, $message);

        exit(json_encode($result));
    }


    /**
     * 楼盘添加
     */
    public function actionAdd()
    {
        return $this->render('communityAdd');
    }

    public function actionAddexcel()
    {
        return $this->render('communityExcel');
    }

    public function actionDoexcel()
    {
        if ($_FILES["commExcel"]["error"] <= 0) {
            $temp = explode(".", $_FILES["commExcel"]["name"]);
            $suffix = end($temp);
            if ($suffix == "xlsx") {
                $excel = ExcelTools::getExcelObject($_FILES["commExcel"]["tmp_name"]);
                ExcelTools::setDataIntoCommunity($excel);
            }
        }
        $this->redirect("/admin/community/manager");
    }

    /**
     * 楼盘添加
     * @param $id
     * @return string
     */
    public function actionEdit($id)
    {
        $community = PCommunity::find()->where('id = "' . $id . '"')->one();
        return $this->render('communityEdit', array('data' => $community));
    }

    /**
     * 楼盘详情
     * @param $id
     * @return string
     */
    public function actionDetails($id)
    {
        $community = PCommunity::find()->where('id = "' . $id . '"')->one();
        return $this->render('communityDetails', array('data' => $community));
    }

    /**
     * 楼盘删除
     * @param $id
     */
    public function actionDeleteajax($id)
    {
        $community = PCommunity::find()->where('id = "' . $id . '"')->one();
        if (empty($community)) {
            echo "0";
            exit;
        }
        $advCount = PAdv::find()->where('adv_community_id = "' . $id . '"')->count();
        if ($advCount > 0) {
            echo "-1";
            exit;
        }
        $community->delete();
        echo "1";

        //设置message消息
        $now = date("Y-m-d H:i:s");
        $staff_name = \Yii::$app->session['loginUser']->staff_name;
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $message = $staff_name . "于" . $now . "删除了1条楼盘信息，楼盘编号为：" . $community->community_no . ",楼盘名称为：" . $community->community_name . "。";
        Message::sendMessage($company_id, $message);

        exit;
    }

    /**
     * 楼盘添加
     */
    public function actionMap()
    {
        $community = PCommunity::find()->asArray()->all();
        return $this->render('communityMap', array("data" => $community, "datajson" => json_encode($community)));
    }

    /**
     * 楼盘执行添加
     * @return string
     */
    public function actionDoadd()
    {
        $check = \Yii::$app->session['check'];   //待审核信息

        $now = date("Y-m-d H:i:s");
        $post = \Yii::$app->request->post();
        $community = new PCommunity();
        $community->community_no = $post['community_no'];
        $community->community_name = $post['community_name'];
        $community->community_position = $post['community_position'];
        $community->community_category = $post['community_category'];
        $community->community_price = $post['community_price'];
        $community->community_cbd = $post['community_cbd'];
        $community->community_nature = $post['community_nature'];
        $community->community_opentime = $post['community_opentime'];
        $community->community_staytime = $post['community_staytime'];
        $community->community_units = $post['community_units'];
        $community->community_households = $post['community_households'];
        $communityMap = explode(",", $post['community_map']);
        $community->community_longitudex = $communityMap[0];
        $community->community_latitudey = $communityMap[1];
        if ($check->control_community == 0)   //添加楼盘信息是否需要审核
            $community->community_status = 0; //0为无须审核
        else
            $community->community_status = 1;  //1为待审核（增）
        $community->company_id = \Yii::$app->session['loginUser']->company_id;
        $community->creator = \Yii::$app->session['loginUser']->id;
        $community->create_time = $now;
        $community->update_time = $now;
        if ($_FILES['community_image1']['error'] <= 0) {
            $community->community_image1 = FileTools::uploadFile($_FILES['community_image1'], 'community');
        }
        $community->save();
        $communityID = $community->attributes['id'];
        $communityImage = $community->attributes['community_image1'];

        //图片信息保持至图片附件表
        if ($_FILES['community_image1']['error'] <= 0) {
            $image = new PImage();
            $image->image_name = basename($communityImage);
            $image->image_path = $communityImage;
            $image->image_source = 0;     //0为community表
            $image->source_id = $communityID;
            $image->create_time = $now;
            $image->creator = \Yii::$app->session['loginUser']->id;
            $image->save();
        }

        //设置message消息
        $staff_name = \Yii::$app->session['loginUser']->staff_name;
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $message = $staff_name . "于" . $now . "添加了1条楼盘信息，楼盘编号为：" . $post['community_no'] . ",楼盘名称为：" . $post['community_name'] . "。";
        Message::sendMessage($company_id, $message);

        $this->redirect("/admin/community/manager");
    }

    public function actionDoedit()
    {
        $now = date("Y-m-d H:i:s");

        $post = \Yii::$app->request->post();
        $community = PCommunity::find()->where('id = "' . $post['id'] . '"')->one();
        $community->community_no = $post['community_no'];
        $community->community_name = $post['community_name'];
        $community->community_position = $post['community_position'];
        $community->community_category = $post['community_category'];
        $community->community_price = $post['community_price'];
        $community->community_cbd = $post['community_cbd'];
        $community->community_nature = $post['community_nature'];
        $community->community_opentime = $post['community_opentime'];
        $community->community_staytime = $post['community_staytime'];
        $community->community_units = $post['community_units'];
        $community->community_households = $post['community_households'];
        $communityMap = explode(",", $post['community_map']);
        $community->community_longitudex = $communityMap[0];
        $community->community_latitudey = $communityMap[1];
        $community->company_id = \Yii::$app->session['loginUser']['company_id'];
        $community->updater = \Yii::$app->session['loginUser']['id'];
        $community->update_time = date("Y-m-d H:i:s");

        if ($_FILES['community_image1']['error'] <= 0) {
            $community->community_image1 = FileTools::uploadFile($_FILES['community_image1'], 'community');
        }
        $community->save();

        $communityID = $community->attributes['id'];
        $communityImage = $community->attributes['community_image1'];
        //图片信息保持至图片附件表
        if ($_FILES['community_image1']['error'] <= 0) {
            $image = new PImage();
            $image->image_name = basename($communityImage);
            $image->image_path = $communityImage;
            $image->image_source = 0;     //0为community表
            $image->source_id = $communityID;
            $image->create_time = $now;
            $image->creator = \Yii::$app->session['loginUser']->id;
            $image->save();
        }

        //设置message消息
        $staff_name = \Yii::$app->session['loginUser']->staff_name;
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $message = $staff_name . "于" . $now . "修改了1条楼盘信息，楼盘编号为：" . $post['community_no'] . ",楼盘名称为：" . $post['community_name'] . "。";
        Message::sendMessage($company_id, $message);

        $this->redirect("/admin/community/manager");
    }

    /*
     * ajax返回历史图片
     */
    public function actionAjaxhistoryimage()
    {
        $community_id = \Yii::$app->request->get('community_id', '0');
        //$imageList=PImage::find()->select("image_path")->where("source_id=".$community_id." and image_source=0")->asArray()->all();  //image_source为0代表community表对应图片
        $imageList = PImage::find()->select("image_name,image_path")->where('source_id=' . $community_id . ' and image_source = 0')->orderBy("create_time desc")->asArray()->all();
        DataTools::jsonEncodeResponse($imageList);
    }

    /*
     * 图片下载
     */
    public function actionDownloadimage()
    {
        $file = \Yii::$app->request->get('file', null);
        FileTools::downloadFile($file, "community");
    }

    public function actionDownloadppt()
    {
        $community = PCommunity::find()->all();
        $fileName = PPTools::createPPT("楼盘管理", $community);
        $this->redirect("/ppt/" . $fileName);
    }

    public function actionDownloadexcel()
    {
        $this->redirect("/excel/模版（楼盘信息）.xlsx");
    }

    /**
     * 根据经纬度获取范围内楼盘数据
     */

    public function actionAjaxdetail()
    {
        $post = \Yii::$app->request->post();
        $lat = $post['lat'];
        $lng = $post['lng'];
        $length = $post['length'] + 0.5;
        $sql = "select com.* , count(adv.id) adv_num  from p_community com "
            . "left join p_adv adv on adv.adv_community_id = com.id "
            . "where sqrt((((" . $lng . "-`community_longitudex`)*PI()*12656*cos(((" . $lat . "+`community_latitudey`)/2)*PI()/180)/180)*((" . $lng . "-`community_longitudex`)*PI()*12656*cos (((" . $lat . "+`community_latitudey`)/2)*PI()/180)/180))+(((" . $lat . "-`community_latitudey`)*PI()*12656/180)*((" . $lat . "-`community_latitudey`)*PI()*12656/180)))<" . $length
            . "group by com.id ";
        //$sql = " SELECT adv.*,com.community_name,cpy.company_name from p_adv adv "
        //        . " LEFT JOIN p_community com ON adv.adv_community_id = com.id "
        //        . " LEFT JOIN p_company cpy ON adv.company_id = cpy.id "
        //        . " where adv.adv_community_id IN (select id from p_community where sqrt((((".$lng."-`community_longitudex`)*PI()*12656*cos(((".$lat."+`community_latitudey`)/2)*PI()/180)/180)*((".$lng."-`community_longitudex`)*PI()*12656*cos (((".$lat."+`community_latitudey`)/2)*PI()/180)/180))+(((".$lat."-`community_latitudey`)*PI()*12656/180)*((".$lat."-`community_latitudey`)*PI()*12656/180)))<".$length .") "
        //        . " order by adv.adv_use_status asc";
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $rows = $command->queryAll();
        exit(json_encode($rows));
    }
}
