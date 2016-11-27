<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\PAdv;
use app\modules\admin\models\DataTools;
use app\modules\admin\models\PCommunity;
use app\modules\admin\models\PCustomer;
use app\modules\admin\models\PModel;
use app\modules\admin\models\ExcelTools;
use app\modules\admin\models\PSales;
use app\modules\admin\models\PStaff;
use app\modules\admin\models\PStaffRole;

/**
 * 设备管理
 * Class AdvController
 * @package app\modules\admin\controllers
 */
class ModelController extends \yii\web\Controller
{

    public $layout = 'admin';

    /**
     * @var array 显示的数据列
     */
    public $modelColumns = array("id", "model_id", "model_name", "model_category", "model_size", "model_display", "model_factory", "model_note", "edit");

    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性(最多三层)
     * @var array
     */
    public $modelColumnsVal = array("id", "model_id", "model_name", "model_category", "model_size", "model_display", "model_factory", "model_note", "<details,edit,delete>");

    /**
     *
     * @return string
     */
    public function actionManager()
    {
        $column = DataTools::getDataTablesColumns($this->modelColumns);
        $jsonDataUrl = '/admin/model/managerjson';
        return $this->render('modelManager', array("columns" => $column, 'jsonurl' => $jsonDataUrl));
    }

    /**
     * 广告位管理表格数据
     */
    public function actionManagerjson()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonData(\Yii::$app->request, "id desc", $this->modelColumns, $this->modelColumnsVal, new PModel(), "model_name", "", $staff);
    }

    public function actionAdd()
    {
        return $this->render('modelAdd');
    }

    public function actionEdit($id)
    {
        $model = PModel::find()->where('id = "' . $id . '"')->one();
        return $this->render('modelEdit', array('model' => $model));
    }

    public function actionDetails($id)
    {
        $model = PModel::find()->where('id = "' . $id . '"')->one();
        return $this->render('modelDetails', array('model' => $model));
    }

    public function actionDoadd()
    {
        $now = date("Y-m-d H:i:s");
        $post = \Yii::$app->request->post();
        $model = new PModel();
        $model->model_id = $post['model_no'];
        $model->model_name = $post['model_name'];
        $model->model_category = $post['model_category'];
        $model->model_desc = $post['model_desc'];
        $model->model_size = $post['model_size'];
        $model->model_display = $post['model_display'];
        $model->model_factory = $post['model_factory'];
        $model->model_note = $post['model_note'];
        $model->company_id = \Yii::$app->session['loginUser']->company_id;
        $model->is_delete = "0";
        $model->creator = \Yii::$app->session['loginUser']->id;
        $model->create_time = $now;
        $model->update_time = $now;
        $model->save();
        $this->redirect("/admin/model/manager");
    }

    public function actionDoedit()
    {
        $now = date("Y-m-d H:i:s");
        $post = \Yii::$app->request->post();
        $model = PModel::find()->where('id = "' . $post['id'] . '"')->one();
        $model->model_id = $post['model_no'];
        $model->model_name = $post['model_name'];
        $model->model_category = $post['model_category'];
        $model->model_desc = $post['model_desc'];
        $model->model_size = $post['model_size'];
        $model->model_display = $post['model_display'];
        $model->model_factory = $post['model_factory'];
        $model->model_note = $post['model_note'];
        $model->company_id = \Yii::$app->session['loginUser']->company_id;
        $model->updater = \Yii::$app->session['loginUser']->id;
        $model->update_time = $now;
        $model->save();
        $this->redirect("/admin/model/manager");
    }

    /*
     * 删除
     * (硬删除)
     */
    public function actionDodelete()
    {
        $request = \Yii::$app->request;
        $id = $request->post('id', 0);

        $model = PModel::find()->where("id=" . $id)->one();
        if ($model != null) {
            $model->delete();
            echo "1";    //删除成功
        } else {
            echo "-1";   //id不存在
        }
        exit;
    }
}
