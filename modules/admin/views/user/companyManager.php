<div id="hidden" style="position:absolute;top:10%;left:34%;width:5px;height:5px;">
</div>
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                用户管理/ <small>公司管理</small>
            </h1>
        </div>
    </div>
    <!-- /. ROW  -->

    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    公司信息列表
                    <a href="javascript:;" class="btn btn-info" id="dialog" style="float:right;margin-top:-0.5rem;">添加公司信息</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="10%">序号</th>
                                <th width="20%">公司名称</th>
                                <th width="35%">涉及领域</th>
                                <th width="10%">员工规模</th>
                                <th width="15%">编辑</th>
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
</div>

<div id="companyAdd" style="display:none;width:60rem;">
    <div class="form-group" id="companyAddDialogDiv">
        <div class="row">
            <div class="col-md-2"><label class="help-block">公司名称：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="new_company_name" /></div>
        </div>
        <div class="row">
            <div class="col-md-2"><label class="help-block">涉及领域：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="new_company_field" /></div>
        </div>
        <div class="row">
            <div class="col-md-2"><label class="help-block">员工规模：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="new_staff_number" /></div>
        </div>
        <div class="row">
            <div id="addcompanyinfo" style="display:none;margin-top:10px;margin-left:12px;">
                <label>公司名已经存在!</label>
            </div>
        </div>
    </div>
</div>

<div id="companyEdit" style="display:none;width:60rem;">
    <div class="form-group" id="companyEditDialogDiv">
        <div class="row">
            <div class="col-md-2"><label class="help-block">公司名称：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="company_name" /></div>
        </div>
        <div class="row">
            <div class="col-md-2"><label class="help-block">涉及领域：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="company_field" /></div>
        </div>
        <div class="row">
            <div class="col-md-2"><label class="help-block">员工规模：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="staff_number" /></div>
        </div>
        <div class="row">
            <input name="company_id" type="hidden" />
            <div id="editcompanyinfo" style="display:none;margin-top:10px;margin-left:12px;">
        </div>
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
<!-- JsTree Js-->
<script src="/assets/adminTemplate/js/jstree/dist/jstree.min.js"></script>
<script type="text/javascript">
    var tree;
    var search = null;
    $(document).ready(function () {
        $('input[name=new_company_name]').keydown(function(){
            if($(this).hasClass('alert-danger')) {
                $('#addcompanyinfo').hide();
                $('input[name=new_company_name]').removeClass('alert-danger');
            }
        });

        $('input[name=new_company_field]').keydown(function(){
            if($(this).hasClass('alert-danger')) {
                $('#addcompanyinfo').hide();
                $('input[name=new_company_field]').removeClass('alert-danger');
            }
        });

        var addDialog = dialog({
            title:'添加公司信息',
            id:'companyAdd',
            drag:true,
            content:$('#companyAdd'),
            fixed:true,
            top : '0%',
            okValue: '确 定',
            ok: function () {
                var companyName = $('input[name=new_company_name]').val();
                var companyField = $('input[name=new_company_field]').val();
                var staffNumber = $('input[name=new_staff_number]').val();

                if(companyName == '') {
                    $('#addcompanyinfo').html('公司名称不能为空!');
                    $('input[name=new_company_name]').addClass('alert-danger').focus();
                }
                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/user/addcompany",
                    "data" : {'companyName' : companyName,'companyField' : companyField,'staffNumber' : staffNumber},
                    "dataType": "json",
                    "success": function (data) {
                        if(data != '1') {
                            $('#addcompanyinfo').addClass('text-danger').show();
                            if(data == '-1') {//角色代码存在
                                $('#addcompanyinfo').html('公司名称不能为空!');
                                $('input[name=new_company_name]').addClass('alert-danger').focus();
                            }
                            if(data == '-2') {//角色名存在
                                $('#addcompanyinfo').html('公司名称存在!');
                                $('input[name=new_company_name]').addClass('alert-danger').focus();
                            }
                            return false;
                        } else {
                            window.location.reload();
                        }
                    }
                });
                //this.close();
                return false;
            },
            cancelValue:'取消',
            cancel: function () {
                this.close();// 隐藏
                return false;
            },
            resize:true,
        });

        var companyEditDialog = dialog({
            title:'修改公司信息',
            id:'companyInfoEdit',
            drag:true,
            content:$('#companyEdit'),
            fixed:true,
            top : '0%',
            okValue: '确 定',
            ok: function () {
                var companyNameEdit = $('input[name=company_name]').val();
                var companyFieldEdit = $('input[name=company_field]').val();
                var staffNumberEdit = $('input[name=staff_number]').val();
                if(companyNameEdit == '') {
                    $('#editcompanyinfo').html('公司名称不能为空!');
                    $('input[name=company_name]').addClass('alert-danger').focus();
                }
                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/user/updatecompany",
                    "data": {
                        'company_id': $('input[name=company_id]').val(),
                        'company_name' : $('input[name=company_name]').val(),
                        'company_field' : $('input[name=company_field]').val(),
                        'staff_number' : $('input[name=staff_number]').val()
                    },
                    "dataType": "json",
                    "success": function (data) {
                        $('#editcompanyinfo').addClass('text-danger').show();
                        if(data == '-3'){
                            $('#editcompanyinfo').html('公司名称不能为空!');
                            $('input[name=company_name]').addClass('alert-danger').focus();
                        }
                        if(data == '-2') {//角色代码存在
                            $('#editcompanyinfo').html('公司名称已存在!');
                            $('input[name=company_name]').addClass('alert-danger').focus();
                        }
                        if(data == '-1') {//角色名存在
                            $('#editcompanyinfo').html('非法公司id!');
                        }
                        if(data == '1') {
                            companyEditDialog.close();
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


        mybind("#dialog",function() {
            var addCompanyName = $('input[name=new_company_name');
            var addCompanyField = $('input[name=new_company_field');
            var addStaffNumber = $('input[name=new_staff_number');
            addCompanyName.val("");
            addCompanyField.val("");
            addStaffNumber.val("");
            if(addCompanyName.hasClass('alert-danger')) {
                $('#addcompanyinfo').hide();
                $('input[name=new_company_name]').removeClass('alert-danger');
            }
            if(addCompanyField.hasClass('alert-danger')) {
                $('#addcompanyinfo').hide();
                $('input[name=new_company_field]').removeClass('alert-danger');
            }
            if(addStaffNumber.hasClass('alert-danger')) {
                $('#addcompanyinfo').hide();
                $('input[name=new_staff_number]').removeClass('alert-danger');
            }
            addDialog.show();
        });

        mybind("#dialogSubmit",function() {
            addDialog.close();
        });

        var table = $('#dataTables-example').dataTable({
                "ordering": false,
                "language": {
                    "url": "/assets/adminTemplate/js/dataTables/zh-cn.txt",
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

                            //更新
                            $('.companyEdit').bind("click", function(){
                                var editRoleName = $('input[name=role_name');
                                var editoleCode = $('input[name=role_code');
                                if(editRoleName.hasClass('alert-danger')) {
                                    $('#editrolenameinfo').hide();
                                    $('input[name=role_name]').removeClass('alert-danger');
                                }
                                if(editoleCode.hasClass('alert-danger')) {
                                    $('#editrolenameinfo').hide();
                                    $('input[name=role_code]').removeClass('alert-danger');
                                }

                                var companyId = $(this).attr('company_id');
                                $('input[name=company_id]').val(companyId);
                                $.ajax({
                                    "type": "GET",
                                    "url": "/admin/user/getcompanyinfo",
                                    "data": {'company_id': companyId},
                                    "dataType": "json",
                                    "success": function (data) {
                                        if(data != null && data.company_name != null) {
                                            $('input[name=company_name]').val(data.company_name);
                                            $('input[name=company_field]').val(data.company_field);
                                            $('input[name=staff_number]').val(data.staff_number);
                                        } else {
                                            alert("获取公司信息失败,请刷新页面重试!");
                                        }
                                    }
                                });
                                companyEditDialog.show();
                            });

                            //删除（软删除 ）
                            $('.companyDelete').bind("click", function(){
                                var companyId = $(this).attr('company_id');
                                $.ajax({
                                    "type": "POST",
                                    "contentType": "application/x-www-form-urlencoded",
                                    "url": "/admin/user/deletecompany",
                                    "data": {
                                        'company_id': companyId,
                                    },
                                    "dataType": "json",
                                    "success": function (data) {
                                        if(data == '-1') {//角色名存在
                                            alert('非法公司id!');
                                        }
                                        if(data == '1') {
                                            table.page(table.page()).draw(false);
                                        }
                                    }
                                });
                            });

                        }
                    });
                },
                'columns' : <?=$columns?>
            }
        ).api();
    });

    function mybind(func, fn) {
        $(func).bind("touchstart",fn);
        $(func).bind("click",fn);
    }
</script>
