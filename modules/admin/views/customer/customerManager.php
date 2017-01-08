<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">客户管理/ <small>客户列表</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    客户列表
                    <a href="javascript:;" class="btn btn-info" id="dialog" style="float:right;margin-top:-0.5rem;">客户信息报备</a>
                    <a href="javascript:;" class="btn btn-info" id="addExcel" style="float:right;margin-top:-0.5rem;margin-right:1rem;">EXCEL上传</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>公司名称</th>
                                    <th>公司地址</th>
                                    <th>添加人</th>
                                    <th>编辑</th>
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

    <div id="customerAdd" style="display:none;width:60rem;">
        <div class="row">
            <div class="col-md-3"><label class="help-block">公司名称（<label class="mydanger">*</label>）：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="company" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">公司地址（<label class="mydanger">*</label>）：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="address" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">联系人（<label class="mydanger">*</label>）：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="contact" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">联系电话：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="phone" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">邮&nbsp;&nbsp;箱：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="email" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">所属行业（<label class="mydanger">*</label>）：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="industry" /></div>
        </div>
        <div class="row">
            <div id="addInfo" style="display:none;margin-top:10px;margin-left:13px;">
                <label></label>
            </div>
        </div>
    </div>

    <div id="customerEdit" style="display:none;width:60rem;">
        <div class="row">
            <div class="col-md-3"><label class="help-block">公司名称（<label class="mydanger">*</label>）：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="companyEdit" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">公司地址（<label class="mydanger">*</label>）：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="addressEdit" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">联系人（<label class="mydanger">*</label>）：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="contactEdit" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">联系电话：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="phoneEdit" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">邮&nbsp;&nbsp;箱：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="emailEdit" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">所属行业（<label class="mydanger">*</label>）：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="industryEdit" /></div>
        </div>
        <div class="row">
            <input name="customerID" type="hidden" />
            <div id="editInfo" style="display:none;margin-top:10px;margin-left:13px;">
                <label></label>
            </div>
        </div>
    </div>

    <div id="customerDetails" style="display:none;width:60rem;">
        <div class="row">
            <div class="col-md-3"><label class="help-block">公司名称：</label></div>
            <div class="col-md-9"><label class="help-block" id="showCompany"></label></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">公司地址：</label></div>
            <div class="col-md-9"><label class="help-block" id="showAddress"></label></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">联系人：</label></div>
            <div class="col-md-9"><label class="help-block" id="showContact"></label></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">联系电话：</label></div>
            <div class="col-md-9"><label class="help-block" id="showPhone"></label></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">邮&nbsp;&nbsp;箱：</label></div>
            <div class="col-md-9"><label class="help-block" id="showEmail"></label></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">所属行业：</label></div>
            <div class="col-md-9"><label class="help-block" id="showIndustry"></label></div>
        </div>
    </div>


</div>
<!-- /. PAGE INNER  -->
<script src="/assets/artDialog/dist/dialog.js"></script>
<script src="/assets/artDialog/dist/dialog-plus.js"></script>
<link href="/assets/artDialog/css/ui-dialog.css" rel="stylesheet" />
<!-- JsTree Styles-->
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default/style.min.css">
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default-dark/style.min.css">
<style type="text/css">
    .mydanger {
        color:red;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {

        //excel上传
        $("#addExcel").click(function(){
            window.location.href = "/admin/customer/addexcel";
        });

        var addDialog = dialog({
            title:'添加客户信息',
            id:'customerAdd',
            drag:true,
            content:$('#customerAdd'),
            fixed:true,
            top : '0%',
            okValue: '确 定',
            ok: function () {
                var company = $('input[name=company]').val();
                var address = $('input[name=address]').val();
                var contact = $('input[name=contact]').val();
                var phone = $('input[name=phone]').val();
                var email = $('input[name=email]').val();
                var industry = $('input[name=industry]').val();

                if(company == "") {
                    $('#addInfo').html('公司名称不能为空!');
                    $('input[name=company]').addClass('alert-danger').focus();
                }
                if(address == "") {
                    $('#addInfo').html('公司地址不能为空!');
                    $('input[name=address]').addClass('alert-danger').focus();
                }
                if(contact == "") {
                    $('#addInfo').html('联系人不能为空!');
                    $('input[name=contact]').addClass('alert-danger').focus();
                }
                if(industry == "") {
                    $('#addInfo').html('所属行业不能为空!');
                    $('input[name=industry]').addClass('alert-danger').focus();
                }
                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/customer/addcustomer",
                    "data" : {
                        'company' : company,
                        'address' : address,
                        'contact' : contact,
                        'phone' : phone,
                        'email' : email,
                        'industry' : industry
                    },
                    "dataType": "json",
                    "success": function (data) {
                        if(data != '1') {
                            $('#addInfo').addClass('text-danger').show();
                            if(data == '-1') {//角色代码存在
                                $('#addInfo').html('必填项不能为空!');
                                $('input[name=new_staff_name]').addClass('alert-danger').focus();
                            }else if(data == '-2'){
                                $('#addInfo').html('公司名称已存在!');
                                $('input[name=new_staff_name]').addClass('alert-danger').focus();
                            }
                            return false;
                        } else {
                            window.location.reload();
                        }
                    }
                });
                return false;
            },
            cancelValue:'取消',
            cancel: function () {
                this.close();// 隐藏
                return false;
            },
            resize:true,
        });

        var editDialog = dialog({
            title:'修改客户信息',
            id:'customerEdit',
            drag:true,
            content:$('#customerEdit'),
            fixed:true,
            top : '0%',
            okValue: '确 定',
            ok: function () {
                var customerID=$('input[name=customerID]').val();
                var companyEdit = $('input[name=companyEdit]').val();
                var addressEdit = $('input[name=addressEdit]').val();
                var contactEdit = $('input[name=contactEdit]').val();
                var phoneEdit = $('input[name=phoneEdit]').val();
                var emailEdit = $('input[name=emailEdit]').val();
                var industryEdit = $('input[name=industryEdit]').val();

                if(companyEdit == "") {
                    $('#editInfo').html('公司名称不能为空!');
                    $('input[name=companyEdit]').addClass('alert-danger').focus();
                }
                if(addressEdit == "") {
                    $('#editInfo').html('公司地址不能为空!');
                    $('input[name=addressEdit]').addClass('alert-danger').focus();
                }
                if(contactEdit == "") {
                    $('#editInfo').html('联系人不能为空!');
                    $('input[name=contactEdit]').addClass('alert-danger').focus();
                }
                if(industryEdit == "") {
                    $('#editInfo').html('所属行业不能为空!');
                    $('input[name=industryEdit]').addClass('alert-danger').focus();
                }

                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/customer/updatecustomer",
                    "data" : {
                        'customerID':customerID,
                        'company' : companyEdit,
                        'address' : addressEdit,
                        'contact' : contactEdit,
                        'phone' : phoneEdit,
                        'email' : emailEdit,
                        'industry' : industryEdit
                    },
                    "dataType": "json",
                    "success": function (data) {
                        $('#editInfo').addClass('text-danger').show();
                        if(data == '-1') {//角色名存在
                            $('#editInfo').html('非法客户id!');
                        }
                        if(data == '1') {
                            editDialog.close();
                            table.page(table.page()).draw(false);
                        }
                    }
                });
                return false;
            },
            cancelValue:'取消',
            cancel: function () {
                this.close();// 隐藏
                return false;
            },
            resize:true,
        });

        var detailsDialog = dialog({
            autoOpen:false,
            title:'客户信息',
            id:'customerDetails',
            drag:true,
            content:$('#customerDetails'),
            fixed:true,
            top : '0%',
            cancelValue:'确定',
            cancel: function () {
                this.close();// 隐藏
                return false;
            },
            resize:true,
        });

        mybind("#dialog",function() {
            //移除提示项
            $('input[name=company]').keydown(function(){
                if($(this).hasClass('alert-danger')) {
                    $('#addInfo').hide();
                    $('input[name=company]').removeClass('alert-danger');
                }
            });
            $('input[name=address]').keydown(function(){
                if($(this).hasClass('alert-danger')) {
                    $('#addInfo').hide();
                    $('input[name=address]').removeClass('alert-danger');
                }
            });
            $('input[name=contact]').keydown(function(){
                if($(this).hasClass('alert-danger')) {
                    $('#addInfo').hide();
                    $('input[name=contact]').removeClass('alert-danger');
                }
            });
            $('input[name=industry]').keydown(function(){
                if($(this).hasClass('alert-danger')) {
                    $('#addInfo').hide();
                    $('input[name=industry]').removeClass('alert-danger');
                }
            });
            addDialog.show();
        });

        mybind("#dialogSubmit",function() {
            addDialog.close();
        });

        var table = $('#dataTables-example').dataTable({
            "ordering": false,
            "language": {
                "url": "/assets/adminTemplate/js/dataTables/zh-cn.txt"
            },
            "aLengthMenu" : [10,20,50,100],
            "serverSide": true,
            "fnServerData": function(sSource, aoData, fnCallback) {
                $.ajax( {
                    "type": "GET",
                    "contentType": "application/json",
                    "url": "<?=$jsonurl?>",
                    "dataType": "json",
                    "data": aoData, //以json格式传递
                    "success": function(data) {
                        fnCallback(data);

                        //详情
                        $('.customerDetails').bind("click", function(){
                            var customerID = $(this).attr('customer_id');
                            $.ajax({
                                "type": "GET",
                                "url": "/admin/customer/getcustomerinfo",
                                "data": {'customerID': customerID},
                                "dataType": "json",
                                "success": function (data) {
                                    if(data != null && data.customer_company != null) {
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
                        $('.customerEdit').bind("click", function(){
                            var companyEdit = $('input[name=companyEdit]');
                            var addressEdit = $('input[name=addressEdit]');
                            var contactEdit = $('input[name=contactEdit]');
                            var phoneEdit = $('input[name=phoneEdit]');
                            var emailEdit = $('input[name=emailEdit]');
                            var industryEdit = $('input[name=industryEdit]');
                            if(companyEdit.hasClass('alert-danger') || addressEdit.hasClass('alert-danger') || contactEdit.hasClass('alert-danger') || industryEdit.hasClass('alert-danger')) {
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
                                    if(data != null && data.customer_company != null) {
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
                        $('.customerDelete').bind("click", function(){
                            if(confirm("确定要删除该信息吗？")) {
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
                            }
                        });
                        //进入销售
                        $('.customersale').click(function(){
                            window.location.href = "/admin/sale/manager?id=" + $(this).attr("role_id");
                            //window.location.href = "/admin/sale/manager?id=" + $(this).attr("role_id");
                        });


                    }
                });
            },
            'columns' : <?=$columns?>
        }).api();

    });

    function mybind(func, fn) {
        $(func).bind("touchstart",fn);
        $(func).bind("click",fn);
    }
</script>