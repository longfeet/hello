<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                企业管理/ <small>部门管理</small>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading" style="font-size: 18px;">
                    公司：<?php echo $company->company_name; ?><input type="hidden" id="companyID" value="<?php echo $company->id; ?>">
                </div>
                <div>
                    <div class="row" style="padding-top: 7px;">
                        <div class="col-md-3" style="width:110px;"><label class="help-block" style="float: right;">部门名称：</label></div>
                        <div class="col-md-5">
                            <input class="form-control" type="text" name="sector_name" />
                            <input  type="hidden" name="sector_id" />
                        </div>
                        <div id="sectorInfo" style="margin-top:10px;margin-left:12px;color:red;"></div>
                    </div>
                    <div class="row" style="padding-top: 5px;"  class="row">
                        <div class="col-md-1" style="width:60px;padding-left: 20px;padding-bottom: 5px;">
                            <a href="javascript:;" class="btn btn-info" id="addSector" style="width:5rem;text-align:center;margin-right:50%;">添&nbsp;加</a>
                        </div>
                        <div class="col-md-1" style="width:60px;padding-bottom: 5px;">
                            <a href="javascript:;" class="btn btn-info" id="updateSector" style="width:5rem;text-align:center;margin-right:50%;">更&nbsp;新</a>
                        </div>
                        <div class="col-md-1" style="width:50px;padding-bottom: 5px;">
                            <a href="javascript:;" class="btn btn-info" id="deleteSector" style="width:5rem;text-align:center;margin-right:50%;">删&nbsp;除</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>

    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <div class="tree" id="tree" style="min-height:52rem;padding-top:1rem;padding-bottom:1rem;">
                <ul>
                    <?php
                        foreach($list as $sector) {
                            echo '<li data-jstree=\'{"opened" : true}\' sector_id="'.$sector['id'].'">'.$sector['sector_name'];
                            echo '<ul>';
                            foreach($sector['staffs'] as $staff) {
                                echo '<li data-jstree=\'{"opened" : true}\' staff_id="'.$staff['id'].'">'.$staff['staff_name'];
                            }
                            echo '</ul></li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- JsTree Styles-->
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default/style.min.css">
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default-dark/style.min.css">
<!-- JsTree Js-->
<script src="/assets/adminTemplate/js/jstree/dist/jstree.min.js"></script>
<!-- /. PAGE INNER  -->
<script src="/assets/artDialog/dist/dialog.js"></script>
<script src="/assets/artDialog/dist/dialog-plus.js"></script>
<link href="/assets/artDialog/css/ui-dialog.css" rel="stylesheet" />
<script type="text/javascript">
    var d = null;
    $(window).ready(function(){
        $.jstree.defaults.core.themes.responsive = true;
        $('#tree').jstree({
            plugins : ["","types","wholerow"], "core" : { "themes" : { "name" : "default-dark" } },
            "types" : { "file" : { "icon" : "jstree-file" }}
        }).bind('click.jstree', function(event) {
            var sector_id = $(event.target).parents('li').attr('sector_id');
            if(typeof(sector_id) != "undefined")
            {
                //部门输入框绑定
                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/user/getsectorbyid",
                    "data" : {
                        'sector_id' : sector_id
                    },
                    "dataType": "json",
                    "success": function (data) {
                        $('input[name=sector_name]').val(data);
                        $('input[name=sector_id]').val(sector_id);
                    }
                });
            }
        });//end of tree

        $('input[name=sector_name]').keydown(function(){
            if($(this).hasClass('alert-danger')) {
                $('#sectorInfo').hide();
                $('input[name=sector_name]').removeClass('alert-danger');
            }
        });

        //添加
        $("#addSector").click(function(){
            var sector_name = $('input[name=sector_name]').val();
            if(sector_name == "")
            {
                $('#sectorInfo').html('部门名称不能为空!');
                $('input[name=sector_name]').addClass('alert-danger').focus();
            }
            else
            {
                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/user/addsector",
                    "data" : {
                        'sector_name' : sector_name
                    },
                    "dataType": "json",
                    "success": function (data) {
                        if(data != '1') {
                            if(data == '-1') {
                                $('#sectorInfo').html('部门名称不能为空!');
                                $('input[name=sector_name]').addClass('alert-danger').focus();
                            }else if(data == '-2'){
                                $('#sectorInfo').html('部门名称已存在!');
                                $('input[name=sector_name]').addClass('alert-danger').focus();
                            }
                        } else {
                            window.location.reload();
                        }
                    }
                });
            }
        });

        //更新
        $("#updateSector").click(function(){
            var sector_name = $('input[name=sector_name]').val();
            var sector_id = $('input[name=sector_id]').val();
            var company_id = $('input[name=companyID]').val();
            if(sector_name == "")
            {
                $('#sectorInfo').html('部门名称不能为空!');
                $('input[name=sector_name]').addClass('alert-danger').focus();
            }
            else
            {
                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/user/updatesector",
                    "data" : {
                        'company_id':company_id,
                        'sector_id':sector_id,
                        'sector_name' : sector_name
                    },
                    "dataType": "json",
                    "success": function (data) {
                        if(data != '1') {
                            if(data == '-1') {
                                $('#sectorInfo').html('所选部门不合法!');
                                $('input[name=sector_name]').addClass('alert-danger').focus();
                            }else if(data == '-2'){
                                $('#sectorInfo').html('部门名称已存在!');
                                $('input[name=sector_name]').addClass('alert-danger').focus();
                            }else if(data=="-3")
                            {
                                $('#sectorInfo').html('部门名称不能为空!');
                                $('input[name=sector_name]').addClass('alert-danger').focus();
                            }
                        } else {
                            window.location.reload();
                        }
                    }
                });
            }
        });

        //删除
        $("#deleteSector").click(function(){
            var sector_id = $('input[name=sector_id]').val();
            if(confirm("确定要删除该部门吗？")) {
                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/user/deletesector",
                    "data" : {
                        'sector_id':sector_id
                    },
                    "dataType": "json",
                    "success": function (data) {
                        if(data == '-1') {
                            $('#sectorInfo').html('所选部门不合法!');
                            $('input[name=sector_name]').addClass('alert-danger').focus();
                        } else {
                            window.location.reload();
                        }
                    }
                });
            }
        });

    });//end of window.ready
</script>