<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\PCustomer;
use app\modules\admin\models\ExcelTools;

class CustomerController extends \yii\web\Controller
{

    public $layout = 'admin';

    /**
     * @var array 显示的数据列
     */
    public $columns = array("id", "customer_company", "customer_address", "customer_contact", "customer_phone", "edit");

    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性
     * @var array
     */
    public $columnsVal = array("id", "customer_company", "customer_address", "customer_contact", "customer_phone", "<details,edit,delete>");

    /**
     *
     * @return string
     */
    public function actionManager()
    {
        $column = DataTools::getDataTablesColumns($this->columns);
        $jsonDataUrl = '/admin/customer/customermanagerjson';
        return $this->render('customerManager', array("columns" => $column, 'jsonurl' => $jsonDataUrl));
    }

    public function actionCustomermanagerjson()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonDataGenerl(\Yii::$app->request, "id desc", $this->columns, $this->columnsVal,
            new PCustomer, "customer_company", "customer", 2, $staff->company_id);
    }

    /*
     * 添加客户信息
     */
    public function actionAddcustomer()
    {
        $date = date('Y-m-d H:i:s');
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];

        $request = \Yii::$app->request;
        $company = $request->post('company', null);
        $address = $request->post('address', null);
        $contact = $request->post('contact', null);
        $phone = $request->post('phone', null);
        $email = $request->post('email', null);
        $industry = $request->post('industry', null);

        if (($company != null && trim($company) != '') || ($address != null && trim($address) != '') || ($contact != null && trim($contact) != '') || ($industry != null && trim($industry) != '')) {
            $companyNameExists = PCustomer::find()->where("customer_company='" . $company . "'")->one();
            if ($companyNameExists != null) {
                echo "-2";   //该公司名称已纯在
                exit;
            } else {
                $customer = new PCustomer();
                $customer->customer_company = $company;
                $customer->customer_address = $address;
                $customer->customer_contact = $contact;
                $customer->customer_phone = $phone;
                $customer->customer_email = $email;
                $customer->customer_industry = $industry;
                $customer->company_id = $staff->company_id;
                $customer->creator = $staff->id;
                $customer->create_time = $date;
                $customer->updater = $staff->id;
                $customer->update_time = $date;
                $customer->save();

                echo "1";
                exit;
            }
        } else {
            echo "-1";   //必填项不能为空
            exit;
        }

    }

    /*
     * 获得客户信息
     */
    public function actionGetcustomerinfo($customerID)
    {
        $customer = PCustomer::find()->where("id=" . $customerID)->one()->attributes;
        DataTools::jsonEncodeResponse($customer);
    }

    /*
     * 更新客户信息
     */
    public function actionUpdatecustomer()
    {
        $date = date('Y-m-d H:i:s');
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];

        $request = \Yii::$app->request;
        $customerID = $request->post('customerID', 0);
        $company = $request->post('company', null);
        $address = $request->post('address', null);
        $contact = $request->post('contact', null);
        $phone = $request->post('phone', null);
        $email = $request->post('email', null);
        $industry = $request->post('industry', null);

        $customer = PCustomer::find()->where("id=" . $customerID)->one();
        if ($customer != null) {
            $customer->customer_company = $company;
            $customer->customer_address = $address;
            $customer->customer_contact = $contact;
            $customer->customer_phone = $phone;
            $customer->customer_email = $email;
            $customer->customer_industry = $industry;
            $customer->company_id = $staff->company_id;
            $customer->updater = $staff->id;
            $customer->update_time = $date;
            $customer->save();

            echo "1";  //更新成功
        } else {
            echo "-1";   //该id不存在
        }
        exit;
    }

    /*
     * 删除客户备注信息
     */
    public function actionDeletecustomer()
    {
        $request = \Yii::$app->request;
        $customerID = $request->post('customerID', 0);

        $customer = PCustomer::find()->where("id=" . $customerID)->one();
        if ($customer != null) {
            $customer->delete();
            echo "1";    //删除成功
        } else {
            echo "-1";   //id不存在
        }
        exit;
    }

    /*
     * 添加excel页面
     */
    public function actionAddexcel()
    {
        return $this->render('customerExcel');
    }

    /*
     * excel上传
     */
    public function actionDoexcel()
    {
        if ($_FILES["commExcel"]["error"] <= 0)
        {
            $temp = explode(".",$_FILES["commExcel"]["name"]);
            $suffix = end($temp);
            if($suffix == "xlsx") {
                $excel = ExcelTools::getExcelObject($_FILES["commExcel"]["tmp_name"]);
                ExcelTools::setDataIntoCustomer($excel);
            }
        }
        $this->redirect("/admin/customer/manager");
    }

    public function actionDownloadexcel()
    {
        $this->redirect("/excel/模版（客户信息）.xlsx");
    }
}
