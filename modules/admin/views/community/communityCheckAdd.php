<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">楼盘管理/ <small>新增待审核</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    待审核列表
                    <a href="/admin/community/checkdelete" class="btn btn-info" style="float:right;margin-top:-0.5rem;margin-right:1rem;">删除审核</a>
                    <a href="/admin/community/checkedit" class="btn btn-info" style="float:right;margin-top:-0.5rem;margin-right:1rem;">修改审核</a>
                    <a href="/admin/community/checkadd" class="btn btn-info" style="float:right;margin-top:-0.5rem;margin-right:1rem;">新增审核</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"/>序号</th>
                                    <th>楼盘编号</th>
                                    <th>楼盘名称</th>
                                    <th>楼盘地址</th>
                                    <th>类型</th>
                                    <th>楼盘商圈</th>
                                    <th>审核类型</th>
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

            <div>
                <input type="button" id="doPass" class="btn btn-info" value="通过" />&nbsp;&nbsp;&nbsp;
                <input type="button" id="doFail" class="btn btn-danger" value="驳回" />
            </div>
        </div>
    </div>
    <!-- /. ROW  -->
</div>
<!-- /. PAGE INNER  -->
<!-- JsTree Styles-->
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default/style.min.css">
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default-dark/style.min.css">
<!-- JsTree Js-->
<script src="/assets/adminTemplate/js/jstree/dist/jstree.min.js"></script>
<script type="text/javascript">
var search = null;

//全选
$("#checkAll").click(function(){
    for(var key in $("input[name='community_id']")){
        $("input[name='community_id']")[key].checked = this.checked;
    }
})

function getCheckValue(nameId){
    var arr = [];
    for(var i=0;i< $("input[name='"+nameId+"']").length;i++){
        if($("input[name='"+nameId+"']")[i].checked){
            arr.push($("input[name='"+nameId+"']")[i].value);
        }
    }
    return arr;
}

$(window).ready(function(){
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
                        $('.roleDetails').click(function(){
                            window.location.href = "/admin/community/details?id=" + $(this).attr("role_id");
                        });

                        if(search == null) {
                            search =  $('input[type=search]');
                            search.before("(楼盘名称)&nbsp;");
                        }
                    }
                });
            },
            'columns' : <?=$columns?>
        }
    ).api();

    //审核通过
    $("#doPass").click(function(){
        var ids = getCheckValue('community_id');
        if(ids.length < 1){
            alert("请选择至少一条记录！");
            return false;
        }
        if(confirm("确定通过审核吗？")){
            $.ajax( {
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/community/docheck",
                "dataType": "json",
                "data": {ids:ids,community_status:7,status:"审核通过"}, //community_status审核状态，默认审核通过
                "success": function(data) {
                    console.log(data);
                    if(data > 0){
                        alert(data+"条记录状态修改成功！");
                        //刷新页面  目前无法在列表数据中看出状态 预留
                        window.location.reload();
                    }else{
                        alert("记录修改失败！");
                    }
                }
            });
        }
    })
    //审核驳回
    $("#doFail").click(function(){
        var ids = getCheckValue('community_id');
        if(ids.length < 1){
            alert("请选择至少一条记录！");
            return false;
        }
        if(confirm("确定审核驳回吗？")){
            $.ajax( {
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/community/docheck",
                "dataType": "json",
                "data": {ids:ids,community_status:4,status:"审核驳回"}, //community_status审核状态，默认审核通过
                "success": function(data) {
                    console.log(data);
                    if(data > 0){
                        alert(data+"条记录状态修改成功！");
                        //刷新页面  目前无法在列表数据中看出状态 预留
                        window.location.reload();
                    }else{
                        alert("记录修改失败！");
                    }
                }
            });
        }
    })
});
</script>