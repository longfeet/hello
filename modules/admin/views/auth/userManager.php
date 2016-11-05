<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">权限管理/ <small>用户管理</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    用户列表
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="20%">序号</th>
                                <th width="20%">员工名称</th>
                                <th width="20%">部门名称</th>
                                <th width="20%">角色</th>
                                <th width="20%">编辑</th>
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
</div>

<div id="roleBind" style="display:none;width:60rem;">
    <div class="form-group" id="roleBindDialogDiv">
        <div class="row">
            <div class="col-md-2"><label class="help-block">选择角色：</label></div>
            <div class="col-md-9">
                <select class="form-control" name="role_id">
                    <option value="0"></option>
                    <?php foreach($rolelist as $role) {?>
                        <option value="<?=$role->id?>"><?=$role->role_name?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="row">
            <input name="staff_id" type="hidden" />
            <input name="current_role_id" type="hidden" />
        </div>
    </div>
</div>

<!-- /. PAGE INNER  -->
<!-- JsTree Styles-->
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default/style.min.css">
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default-dark/style.min.css">
<!-- JsTree Js-->
<script src="/assets/adminTemplate/js/jstree/dist/jstree.min.js"></script>
<script src="/assets/artDialog/dist/dialog.js"></script>
<script src="/assets/artDialog/dist/dialog-plus.js"></script>
<link href="/assets/artDialog/css/ui-dialog.css" rel="stylesheet" />
<script type="text/javascript">
var search = null;
$(window).ready(function(){
    var bindDialog = dialog({
        follow: document.getElementById('hidden'),
        title:'员工绑定角色',
        id:'roleBind',
        drag:true,
        content:$('#roleBind'),
        fixed:true,
        okValue: '确 定',
        ok: function () {
            $.ajax({
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/auth/staffbindrole",
                "data" : {'role_id' : $('select[name=role_id]').val(),'staff_id' : $('input[name=staff_id]').val()},
                "dataType": "json",
                "success": function (data) {
                    if(data == '1') {

                    }
                    table.page(table.page()).draw(false);
                }
            });
            this.close();
            return false;
        },
        cancelValue:'取消',
        cancel: function () {
            this.close();// 隐藏
            return false;
        },
        resize:true,
    });

    var table = $('#dataTables-example').dataTable({
            "ordering" : false,
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
                        $('.bindRole').click(function(){
                            var staffId = $(this).attr('staff_id');
                            $.ajax({
                                "type": "GET",
                                "url": "/admin/auth/getuserrole",
                                "data" : {'staff_id' : staffId},
                                "dataType": "json",
                                "success": function (data) {
                                    if(data != null) {
                                        $('select[name=role_id]').val(data.role_id);
                                    } else {
                                        $('select[name=role_id]').val('0');
                                    }
                                }
                            });
                            $('input[name=staff_id]').val(staffId);
                            bindDialog.show();
                        });
                        if(search == null) {
                            search =  $('input[type=search]');
                            search.before("(员工名称)&nbsp;");
                        }
                    }
                });
            },
            'columns' : <?=$columns?>
        }
    ).api();
});
</script>