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
                <div class="panel-heading">
                    设备添加
                </div>
                <div>
                    <div class="row" style="padding-top: 7px;">
                        <div class="col-md-3" style="width:110px;"><label class="help-block" style="float: right;">部门名称：</label></div>
                        <div class="col-md-5"><input class="form-control" type="text" name="sector_name" /></div>
                    </div>
                    <div class="row" style="padding-top: 5px;">
                        <div class="col-md-3" style="width:110px;padding-left: 60px;padding-bottom: 5px;">
                            <a href="javascript:;" class="btn btn-info" id="addSector" style="float:right;width:5rem;text-align:center;margin-right:50%;">添&nbsp;加</a>
                        </div>
                        <div class="col-md-1"><a href="javascript:;" class="btn btn-info" id="updateSector" style="float:right;width:5rem;text-align:center;margin-right:50%;">更&nbsp;新</a></div>
                        <div class="col-md-1"><a href="javascript:;" class="btn btn-info" id="deleteSector" style="float:right;width:5rem;text-align:center;margin-right:50%;">删&nbsp;除</a></div>

                        <div class="col-md-5"></div>
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


<div  id="dialogForm" style="width:32rem;display:none;">
    <input class="form-control" type="hidden" name="menu_id" />
    <input class="form-control" type="hidden" name="tree_id" />
    <div class="form-group" id="menuUpdateDialog">
        <label>菜单名称：</label>
        <input class="form-control" type="text" name="menu_name" />

        <label>菜单地址：</label>
        <input class="form-control" type="text" name="menu_url" />
        <div style="margin-top:1rem;">
            <a href="javascript:;" id="addSubMenu" class="btn btn-success">添加子菜单</a>

            <a href="javascript:;" id="deleteMenu" class="btn btn-danger">删除菜单</a>
        </div>
        <div id="subMenuDiv" style="margin-top:1rem;display:none;"><label>子菜单名称：</label>
            <input class="form-control" type="text" name="sub_menu_name" />
            <label>子菜单地址：</label>
            <input class="form-control" type="text" name="sub_menu_url" />
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
            $('#subMenuDiv').hide();
            var eventNodeName = event.target.nodeName;
            if (eventNodeName == 'INS' || eventNodeName == 'A') {
                var treeId = $(event.target).attr('id');//.parent();
                $("input[name=tree_id]").val(treeId);
                var menu_id = $(event.target).parents('li').attr('menu_id');
                $.ajax( {
                    "type": "GET",
                    "contentType": "application/json",
                    "url": "/admin/auth/getmenuinfo?menu_id="+menu_id,
                    "dataType": "json",
                    "success": function(data) {
                        $("input[name=menu_id]").val(data.id);
                        $("input[name=menu_name]").val(data.menu_name);
                        $("input[name=menu_url]").val(data.menu_url);
                        if(data.childMenus > 0 && data.menu_level == 1) {
                            $("input[name=menu_url]").attr('readonly',true).attr('title',"此菜单无实际地址");
                        } else {
                            $("input[name=menu_url]").attr('readonly',false);
                        }
                        if (d != null) {
                            d.content($("#dialogForm"));
                            d.show();
                        } else {
                            d = dialog({
                                title: '编辑菜单',
                                id: 'menu_dialog_id_' + $("input[name=menu_id]").val(),
                                drag: true,
                                content: $("#dialogForm"),
                                fixed: true,
                                okValue: '确 定',
                                onshow:function() {
                                    $('#addSubMenu').html('添加子菜单').attr('cancel', '0');
                                    $('input[name=sub_menu_name]').val("");
                                    $('input[name=sub_menu_url]').val("");
                                    $("#addSubMenu").bind("click",function() {
                                        if($('#addSubMenu').attr('cancel') != '1') {
                                            $('#addSubMenu').html('取消子菜单').attr('cancel', '1');
                                            $('#subMenuDiv').show();
                                        } else {
                                            $('input[name=sub_menu_name]').val("");
                                            $('input[name=sub_menu_url]').val("");
                                            $('#subMenuDiv').hide();
                                            $('#addSubMenu').attr('cancel','0').html('添加子菜单');
                                        }
                                    });

                                    $('#deleteMenu').bind("click",function() {
                                        if(confirm("删除将无法恢复,确定要删除吗?")) {
                                            $.ajax({
                                                "type": "POST",
                                                "contentType": "application/json",
                                                "url": "/admin/auth/deletemenu",
                                                "data": {'menu_id': $("input[name=menu_id]").val()},
                                                "dataType": "json",
                                                "contentType": "application/x-www-form-urlencoded",
                                                "success": function (res) {
                                                    d.close();
                                                    if(res == 1) {
                                                        var alertDeleteSuccess = dialog({
                                                            id: 'operation_delete_success',
                                                            content:'删除成功!<i class="fa fa-check"></i>'
                                                        });
                                                        alertDeleteSuccess.show();
                                                        setTimeout(function () {
                                                            alertDeleteSuccess.close().remove();
                                                            window.location.reload();
                                                        }, 1000);
                                                    } else if(res == 0) {
                                                        alert("该菜单存在子菜单无法删除，需要先删除子菜单!");
                                                    } else if(res == -1) {
                                                        alert("删除失败!");
                                                    }
                                                    return false;
                                                }
                                            });
                                        }
                                    });
                                },
                                ok: function () {
                                    var currentTreeId = $("input[name=tree_id]").val();
                                    var ajaxData = {
                                        "menu_id" : $("input[name=menu_id]").val(),
                                        "menu_name" : $("input[name=menu_name]").val(),
                                        "menu_url" : $("input[name=menu_url]").val(),

                                        "sub_menu_name" : $("input[name=sub_menu_name]").val(),
                                        "sub_menu_url" : $("input[name=sub_menu_url]").val()
                                    };
                                    $.ajax({
                                        "type": "POST",
                                        "contentType": "application/json",
                                        "url": "/admin/auth/updatemenuinfo",
                                        "data": ajaxData,
                                        "dataType": "json",
                                        "contentType" : "application/x-www-form-urlencoded",
                                        "success": function (response) {
                                            if(response == 1) {
                                                var currentTree = $('#'+currentTreeId);
                                                //console.log(currentTree.html());
                                                var treeHtml = currentTree.html().replace(/<\/i>(.*)/, "</i>");
                                                currentTree.html(treeHtml);
                                                currentTree.append($("input[name=menu_name]").val());
                                                var alertSuccess = dialog({
                                                    id: 'operation_success',
                                                    content:'操作成功!<i class="fa fa-check"></i>'
                                                });
                                                alertSuccess.show();
                                                setTimeout(function () {
                                                    alertSuccess.close().remove();
                                                }, 1000);
                                            } else if(response == 2) {
                                                var alertSubSuccess = dialog({
                                                    id: 'operation_sub_success',
                                                    content:'子菜单添加成功!<i class="fa fa-check"></i>'
                                                });
                                                alertSubSuccess.show();
                                                setTimeout(function () {
                                                    alertSubSuccess.close().remove();
                                                    window.location.reload();
                                                }, 500);
                                            } else if(response == -1) {
                                                var alertFaild = dialog({
                                                    id: 'operation_faild',
                                                    content:'操作失败!<i class="fa fa-times"></i>'
                                                });
                                                alertFaild.show();
                                                setTimeout(function () {
                                                    alertFaild.close().remove();
                                                }, 1000);
                                            }
                                        }
                                    });
                                    d.close();
                                    return false;
                                },
                                cancelValue: '取消',
                                cancel: function () {
                                    d.close();
                                    return false;
                                },
                                resize: true,
                            });//end of d dialog
                            d.show();
                        }//end of else
                    }//end of ajax success
                });//end of ajax
            }//end of bind function
        });//end of tree

        //添加
        $("#addSector").click(function(){
            var sector_name = $('input[name=sector_name]').val();

            $.ajax({
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/user/addsector",
                "data" : {
                    'sector_name' : sector_name
                },
                "dataType": "json",
                "success": function (data) {
                    alert(1);


                }
            });
        });

    });//end of window.ready
</script>