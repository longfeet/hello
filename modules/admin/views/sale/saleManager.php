<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">销售管理/ <small>广告位销售</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"/>序号</th>
                                <th>楼盘名称</th>
                                <th>广告位编号</th>
                                <th>广告位名称</th>
                                <th>广告位位置</th>
                                <th>当前状态</th>
                                <th>使用状态</th>
                                <th>上刊率</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <!-- /. ROW  -->

    <div class="row">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">客户公司：</div>
        <div class="col-md-9">
            <select class="form-control" name="sales_company">
                <option value="0">==请选择==</option>
                <?php foreach ($customerList as $customer) { ?>
                    <option value="<?= $customer->id ?>"><?= $customer->customer_company ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">客户联系人：</div>
        <div class="col-md-9"><input class="form-control" type="text" name="sales_customer"/></div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">开始时间：</div>
        <div class="col-md-9"><input type="text" class="form-control" name="sales_starttime" id="sales_starttime"/>
        </div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">到期时间：</div>
        <div class="col-md-9"><input type="text" class="form-control" name="sales_endtime" id="sales_endtime"/></div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">销售人员：</div>
        <div class="col-md-9"><input type="text" class="form-control" name="sales_person"
                                     value="<?= $staff->staff_name ?>"/></div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">销售状态：</div>
        <div class="col-md-9">
            <select class="form-control" name="sales_status">
                <option value="0">销售</option>
                <option value="1">赠送</option>
                <option value="2">置换</option>
            </select>
        </div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">备注：</div>
        <div class="col-md-9"><textarea class="form-control" rows="3" name="sales_note"></textarea></div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">
            <input type="button" id="saleSubmit" class="btn btn-info" value="提交"/>
        </div>
    </div>


</div>
<!-- /. PAGE INNER  -->
<script src="/assets/artDialog/dist/dialog.js"></script>
<script src="/assets/datepicker/jquery.ui.datepicker.js"></script>
<script src="/assets/datepicker/jquery-ui.js"></script>
<link rel="stylesheet" href="/css/jquery-ui.css">
<link href="/assets/artDialog/css/ui-dialog.css" rel="stylesheet"/>
<!-- JsTree Styles-->
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default/style.min.css">
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default-dark/style.min.css">
<style type="text/css">
    .mydanger {
        color: red;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('#sales_starttime').datepicker({
            dateFormat: "yy-mm-dd",
            monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
            changeMonth: true,
            changeYear: true
        });
        $('#sales_endtime').datepicker({
            dateFormat: "yy-mm-dd",
            monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
            changeMonth: true,
            changeYear: true
        });

        $("#checkAll").click(function () {

            for (var key in $("input[name='adv_id']")) {
                $("input[name='adv_id']")[key].checked = this.checked;
            }
        })

        //点击td选中checkbox
        $("#dataTables-example").on("click", "tr", function () {
            var input = $(this).find("input");
            if ($(input).attr("checked")) {
                $(input).removeAttr("checked");
            }
            else
            {
                $("#dataTables-example tr").find("input").each(function () {
                    $(this).removeAttr("checked");
                });
                $(input).attr("checked", true);
            }
        });



        //客户公司联动客户联系人
        $('select[name=sales_company]').change(function () {
            var customer_id = $('select[name=sales_company] option:selected').val();
            if (customer_id != 0) {
                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/sale/getcustomerinfo?customer_id=" + customer_id,
                    "dataType": "json",
                    "success": function (data) {
                        $("input[name='sales_customer']").val(data[0].customer_contact);
                    }
                });
            }
            else {
                $("input[name='sales_customer']").val("");
            }
        })

        var table = $('#dataTables-example').dataTable({
            "ordering": false,
            "language": {
                "url": "/assets/adminTemplate/js/dataTables/zh-cn.txt"
            },
            "aLengthMenu": [10, 20, 50, 100],
            "serverSide": true,
            "fnServerData": function (sSource, aoData, fnCallback) {
                $.ajax({
                    "type": "GET",
                    "contentType": "application/json",
                    "url": "<?=$jsonurl?>",
                    "dataType": "json",
                    "data": aoData, //以json格式传递
                    "success": function (data) {
                        fnCallback(data);

                        //详情
                        $('.customerDetails').bind("click", function () {
                            var customerID = $(this).attr('customer_id');
                            $.ajax({
                                "type": "GET",
                                "url": "/admin/customer/getcustomerinfo",
                                "data": {'customerID': customerID},
                                "dataType": "json",
                                "success": function (data) {
                                    if (data != null && data.customer_company != null) {
                                        $('#showCompany').html(data.customer_company);
                                        $('#showAddress').html(data.customer_address);
                                        $('#showContact').html(data.customer_contact);
                                        $('#showPhone').html(data.customer_phone);
                                        $('#showEmail').html(data.customer_email);
                                        $('#showIndustry').html(data.customer_industry);
                                    } else {
                                        alert("获取人员信息失败,请刷新页面重试!");
                                    }
                                }
                            });
                            detailsDialog.show();
                        });
                        //更新
                        $('.customerEdit').bind("click", function () {
                            var companyEdit = $('input[name=companyEdit]');
                            var addressEdit = $('input[name=addressEdit]');
                            var contactEdit = $('input[name=contactEdit]');
                            var phoneEdit = $('input[name=phoneEdit]');
                            var emailEdit = $('input[name=emailEdit]');
                            var industryEdit = $('input[name=industryEdit]');
                            if (companyEdit.hasClass('alert-danger') || addressEdit.hasClass('alert-danger') || contactEdit.hasClass('alert-danger') || industryEdit.hasClass('alert-danger')) {
                                $('#editInfo').hide();
                                companyEdit.removeClass('alert-danger');
                                addressEdit.removeClass('alert-danger');
                                contactEdit.removeClass('alert-danger');
                                industryEdit.removeClass('alert-danger');
                            }
                            var customerID = $(this).attr('customer_id');

                            $.ajax({
                                "type": "GET",
                                "url": "/admin/customer/getcustomerinfo",
                                "data": {'customerID': customerID},
                                "dataType": "json",
                                "success": function (data) {
                                    if (data != null && data.customer_company != null) {
                                        companyEdit.val(data.customer_company);
                                        addressEdit.val(data.customer_address);
                                        contactEdit.val(data.customer_contact);
                                        phoneEdit.val(data.customer_phone);
                                        emailEdit.val(data.customer_email);
                                        industryEdit.val(data.customer_industry);
                                        $('input[name=customerID]').val(customerID);
                                    } else {
                                        alert("获取人员信息失败,请刷新页面重试!");
                                    }
                                }
                            });
                            editDialog.show();
                        });
                        //删除（硬删除 ）
                        $('.customerDelete').bind("click", function () {
                            var customerID = $(this).attr('customer_id');
                            $.ajax({
                                "type": "POST",
                                "contentType": "application/x-www-form-urlencoded",
                                "url": "/admin/customer/deletecustomer",
                                "data": {
                                    'customerID': customerID,
                                },
                                "dataType": "json",
                                "success": function (data) {
                                    if (data == '-1') {//角色名存在
                                        alert('非法客户id!');
                                    }
                                    if (data == '1') {
                                        table.page(table.page()).draw(false);
                                    }
                                }
                            });
                        });

                        search =  $('input[type=search]');
                        search.before("(楼盘名称)&nbsp;");

                    }
                });
            },
            'columns': <?=$columns?>
        }).api();

        //提交
        $("#saleSubmit").click(function () {
            var ids = getCheckValue('adv_id');
            if (ids.length < 1) {
                alert("请选择至少一条记录！");
                return false;
            }

            //读取销售信息
            var sales_company = $('select[name=sales_company]').val();
            var sales_customer = $('input[name=sales_customer]').val();
            var sales_starttime = $('input[name=sales_starttime]').val();
            var sales_endtime = $('input[name=sales_endtime]').val();
            var sales_person = $('input[name=sales_person]').val();
            var sales_status = $('select[name=sales_status]').val();
            var sales_note = $('textarea[name=sales_note]').val();

            //数据验证;
            if (sales_company == "0") {
                alert("请选择客户公司");
            } else if (sales_starttime == "") {
                alert("请选开始时间");
            } else if(sales_endtime == "")
            {
                alert("请选到期时间");
            }
            else
            {
                $.ajax( {
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/sale/dosale",
                    "dataType": "json",
                    "data": {
                        ids:ids,
                        sales_company:sales_company,
                        sales_customer:sales_customer,
                        sales_starttime:sales_starttime,
                        sales_endtime:sales_endtime,
                        sales_person:sales_person,
                        sales_status:sales_status,
                        sales_note:sales_note
                    }, //以json格式传递
                    "success": function(data) {
                        if(data > 0){
                            window.location.reload();
                        }else{
                            alert("数据录入失败！");
                        }
                    }
                });
            }
        })

        //获得选中的广告位（adv）的id
        function getCheckValue(nameId) {
            var arr = [];
            for (var i = 0; i < $("input[name='" + nameId + "']").length; i++) {
                if ($("input[name='" + nameId + "']")[i].checked) {
                    arr.push($("input[name='" + nameId + "']")[i].value);
                }
            }
            return arr;
        }
    });

    function mybind(func, fn) {
        $(func).bind("touchstart", fn);
        $(func).bind("click", fn);
    }
</script>