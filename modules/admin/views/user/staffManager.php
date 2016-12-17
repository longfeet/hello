<div id="hidden" style="position:absolute;top:10%;left:34%;width:5px;height:5px;">
</div>
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                用户管理/ <small>人员管理</small>
            </h1>
        </div>
    </div>
    <!-- /. ROW  -->

    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    人员信息列表
                    <a href="javascript:;" class="btn btn-info" id="dialog" style="float:right;margin-top:-0.5rem;">添加人员信息</a>
                    <a href="javascript:;" class="btn btn-info" id="addExcel" style="float:right;margin-top:-0.5rem;margin-right:1rem;">EXCEL上传</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="8%">序号</th>
                                <th width="10%">工号</th>
                                <th width="10%">姓名</th>
                                <th width="15%">手机号</th>
                                <th width="15%">邮箱</th>
                                <th width="12%">所属部门</th>
                                <th width="15%">操作权限</th>
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

<div id="staffAdd" style="display:none;width:60rem;">
    <div class="form-group" id="companyAddDialogDiv">
        <div class="row">
            <div class="col-md-3"><label class="help-block">姓名（<label class="mydanger">*</label>）：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="new_staff_name" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">工号：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="new_staff_no" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">手机号：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="new_staff_phone" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">邮箱：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="new_staff_email" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">公司：</label></div>
            <div class="col-md-9">
                <select class="form-control" name="new_company_id">
                    <?php foreach($companyList as $company) {?>
                        <option value="<?=$company->id?>"><?=$company->company_name?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">所属部门：</label></div>
            <div class="col-md-9">
                <select class="form-control" name="new_staff_sector">
                    <?php foreach($sectorList as $sector) {?>
                        <option value="<?=$sector->id?>"><?=$sector->sector_name?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">职务：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="new_staff_position" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">操作权限：</label></div>
            <div class="col-md-9">
                <select class="form-control" name="new_staff_level">
                    <option value="1">一级管理员（小）</option>
                    <option value="2">二级管理员（中）</option>
                    <option value="3">三级管理员（大）</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div id="addstaffinfo" style="display:none;margin-top:10px;margin-left:12px;">
                <label></label>
            </div>
        </div>
    </div>
</div>

<div id="staffEdit" style="display:none;width:60rem;">
    <div class="form-group" id="staffEditDialogDiv">
        <div class="row">
            <div class="col-md-3"><label class="help-block">姓名（<label class="mydanger">*</label>）：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="staff_name" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">工号：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="staff_no" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">手机号：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="staff_phone" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">邮箱：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="staff_email" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">公司：</label></div>
            <div class="col-md-9">
                <select class="form-control" name="company_id">
                    <?php foreach($companyList as $company) {?>
                        <option value="<?=$company->id?>"><?=$company->company_name?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">所属部门：</label></div>
            <div class="col-md-9">
                <select class="form-control" name="staff_sector">
                    <?php foreach($sectorList as $sector) {?>
                        <option value="<?=$sector->id?>"><?=$sector->sector_name?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">职务：</label></div>
            <div class="col-md-9"><input class="form-control" type="text" name="staff_position" /></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="help-block">操作权限：</label></div>
            <div class="col-md-9">
                <select class="form-control" name="staff_level">
                    <option value="1">一级管理员（小）</option>
                    <option value="2">二级管理员（中）</option>
                    <option value="3">三级管理员（大）</option>
                </select>
            </div>
        </div>
        <div class="row">
            <input name="staff_id" type="hidden" />
            <div id="editstaffinfo" style="display:none;margin-top:10px;margin-left:12px;"></div>
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
<style type="text/css">
    .mydanger {
        color:red;
    }
</style>
<script type="text/javascript">
    var tree;
    var search = null;
    $(document).ready(function () {
        $("#addExcel").click(function(){
            window.location.href = "/admin/user/addexcel";
        });

        $('input[name=new_staff_name]').keydown(function(){
            if($(this).hasClass('alert-danger')) {
                $('#addstaffinfo').hide();
                $('input[name=new_staff_name]').removeClass('alert-danger');
            }
        });

        //动态修改select
        $('select[name=company_id]').change(function(){
            var company_id=$('select[name=company_id] option:selected').val();
            $.ajax({
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/user/getsectorbycompany?company_id="+company_id,
                "dataType": "json",
                "success": function (data) {
                    var optionstring = "";
                    for(var i=0;i<data.length;i++){
                        optionstring += "<option value=\"" + data[i].id + "\" >" + data[i].sector_name + "</option>";
                    }
                    $('select[name=staff_sector]').html("<option value='0'>请选择...</option> "+optionstring);
                }
            });
        })

        $('select[name=new_company_id]').change(function(){
            var company_id=$('select[name=new_company_id] option:selected').val();
            $.ajax({
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/user/getsectorbycompany?company_id="+company_id,
                "dataType": "json",
                "success": function (data) {
                    var optionstring = "";
                    for(var i=0;i<data.length;i++){
                        optionstring += "<option value=\"" + data[i].id + "\" >" + data[i].sector_name + "</option>";
                    }
                    $('select[name=new_staff_sector]').html("<option value='0'>请选择...</option> "+optionstring);
                }
            });
        })

        var addDialog = dialog({
            title:'添加人员信息',
            id:'staffAdd',
            drag:true,
            content:$('#staffAdd'),
            fixed:true,
            top : '0%',
            okValue: '确 定',
            ok: function () {
                var staffName = $('input[name=new_staff_name]').val();
                var staffNo = $('input[name=new_staff_no]').val();
                var staffPhone = $('input[name=new_staff_phone]').val();
                var staffEmail = $('input[name=new_staff_email]').val();
                var companyId = $('select[name=new_company_id]').val();
                var staffSector = $('select[name=new_staff_sector]').val();
                var staffPosition = $('input[name=new_staff_position]').val();
                var staffLevel = $('select[name=new_staff_level]').val();

                if(staffName == '') {
                    $('#addstaffinfo').html('姓名不能为空!');
                    $('input[name=new_staff_name]').addClass('alert-danger').focus();
                }
                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/user/addstaff",
                    "data" : {
                        'staffName' : staffName,
                        'staffNo' : staffNo,
                        'staffPhone' : staffPhone,
                        'staffEmail' : staffEmail,
                        'companyId' : companyId,
                        'staffSector' : staffSector,
                        'staffPosition' : staffPosition,
                        'staffLevel':staffLevel
                    },
                    "dataType": "json",
                    "success": function (data) {
                        if(data != '1') {
                            $('#addstaffinfo').addClass('text-danger').show();
                            if(data == '-1') {//角色代码存在
                                $('#addstaffinfo').html('姓名不能为空!');
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

        var staffEditDialog = dialog({
            title:'修改人员信息',
            id:'staffInfoEdit',
            drag:true,
            content:$('#staffEdit'),
            fixed:true,
            top : '0%',
            okValue: '确 定',
            ok: function () {
                var staffName = $('input[name=staff_name]').val();
                var staffNo = $('input[name=staff_no]').val();
                var staffPhone = $('input[name=staff_phone]').val();
                var staffEmail = $('input[name=staff_email]').val();
                var companyId = $('select[name=company_id]').val();
                var staffSector = $('select[name=staff_sector]').val();
                var staffPosition = $('input[name=staff_position]').val();
                var staffLevel = $('select[name=staff_level]').val();
                var staffId=$('input[name=staff_id]').val();
//alert(staffName+";"+staffNo+";"+staffPhone+";"+staffEmail+";"+companyId+";"+staffSector+";"+staffPosition+";"+staffId);
                if(staffName == '') {
                    $('#addstaffinfo').html('姓名不能为空!');
                    $('input[name=staff_name]').addClass('alert-danger').focus();
                }

                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/user/updatestaff",
                    "data" : {
                        'staffId':staffId,
                        'staffName' : staffName,
                        'staffNo' : staffNo,
                        'staffPhone' : staffPhone,
                        'staffEmail' : staffEmail,
                        'companyId' : companyId,
                        'staffSector' : staffSector,
                        'staffPosition' : staffPosition,
                        'staffLevel' : staffLevel
                    },
                    "dataType": "json",
                    "success": function (data) {
                        $('#editstaffinfo').addClass('text-danger').show();
                        if(data == '-1') {//角色名存在
                            $('#editstaffinfo').html('非法人员id!');
                        }
                        if(data == '-2') {//角色代码存在
                            $('#editstaffinfo').html('姓名不能为空!');
                        }
                        if(data == '1') {
                            staffEditDialog.close();
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
                            $('.staffEdit').bind("click", function(){
                                var editStaffName = $('input[name=staff_name]');
                                var editStaffNo = $('input[name=staff_no]');
                                var editStaffPhone = $('input[name=staff_phone]');
                                var editStaffEmail = $('input[name=staff_email]');
                                var editCompanyId = $('select[name=company_id]');
                                var editStaffSector = $('select[name=staff_sector]');
                                var editStaffPosition = $('input[name=staff_position]');
                                var editStaffLevel = $('select[name=staff_level]');
                                if(editStaffName.hasClass('alert-danger')) {
                                    $('#editstaffinfo').hide();
                                    $('input[name=new_staff_name]').removeClass('alert-danger');
                                }
                                var staffId = $(this).attr('staff_id');
                                $('input[name=staff_id]').val(staffId);

                                $.ajax({
                                    "type": "GET",
                                    "url": "/admin/user/getsectorbystaff",
                                    "data": {'staff_id': staffId},
                                    "dataType": "json",
                                    "success": function (data) {
                                        if(data != null) {
                                            var optionstring = "";
                                            for(var i=0;i<data.length;i++){
                                                optionstring += "<option value=\"" + data[i].id + "\" >" + data[i].sector_name + "</option>";
                                            }
                                            $('select[name=staff_sector]').html("<option value='0'>请选择...</option> "+optionstring);

                                            $.ajax({
                                                "type": "GET",
                                                "url": "/admin/user/getstaffinfo",
                                                "data": {'staff_id': staffId},
                                                "dataType": "json",
                                                "success": function (data1) {
                                                    if(data1 != null && data1.staff_name != null) {
                                                        editStaffName.val(data1.staff_name);
                                                        editStaffNo.val(data1.staff_no);
                                                        editStaffPhone.val(data1.staff_phone);
                                                        editStaffEmail.val(data1.staff_email);
                                                        editCompanyId.val(data1.company_id);
                                                        editStaffSector.val(data1.staff_sector);
                                                        editStaffPosition.val(data1.staff_position);
                                                        editStaffLevel.val(data1.staff_level);
                                                    } else {
                                                        alert("获取人员信息失败,请刷新页面重试!");
                                                    }
                                                }
                                            });
                                        } else {
                                            alert("请刷新页面重试!");
                                        }
                                    }
                                });
                                staffEditDialog.show();
                            });

                            //删除（软删除 ）
                            $('.staffDelete').bind("click", function(){
                                var staffId = $(this).attr('staff_id');
                                $.ajax({
                                    "type": "POST",
                                    "contentType": "application/x-www-form-urlencoded",
                                    "url": "/admin/user/deletestaff",
                                    "data": {
                                        'staff_id': staffId,
                                    },
                                    "dataType": "json",
                                    "success": function (data) {
                                        if(data == '-1') {//角色名存在
                                            alert('非法人员id!');
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
