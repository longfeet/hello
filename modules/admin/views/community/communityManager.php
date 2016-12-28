<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">楼盘管理/ <small>楼盘列表</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    楼盘列表
                    <a href="javascript:;" class="btn btn-info" id="map" style="float:right;margin-top:-0.5rem;">楼盘地图</a>
                    <a href="javascript:;" class="btn btn-info" id="addCommunity" style="float:right;margin-top:-0.5rem;margin-right:1rem;">添加楼盘</a>
                    <a href="javascript:;" class="btn btn-info" id="addExcel" style="float:right;margin-top:-0.5rem;margin-right:1rem;">EXCEL上传</a>
                    <a href="javascript:;" class="btn btn-info" id="downloadPPT" style="float:right;margin-top:-0.5rem;margin-right:1rem;">导出PPT</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>楼盘编号</th>
                                    <th>楼盘名称</th>
                                    <th>所在城市</th>
                                    <th>所属区域</th>
                                    <th>楼盘地址</th>
                                    <th>类型</th>
                                    <th>楼盘商圈</th>
                                    <th>备注</th>
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
</div>
<!-- /. PAGE INNER  -->
<!-- JsTree Styles-->
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default/style.min.css">
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default-dark/style.min.css">
<!-- JsTree Js-->
<script src="/assets/adminTemplate/js/jstree/dist/jstree.min.js"></script>
<script type="text/javascript">
var search = null;
$(window).ready(function(){

    $("#addExcel").click(function(){
        window.location.href = "/admin/community/addexcel";
    });

    $("#downloadPPT").click(function(){
        window.location.href = "/admin/community/downloadppt";
    });

    $("#addCommunity").click(function(){
       window.location.href = "/admin/community/add";
    });

    $("#map").click(function(){
        window.location.href = "/admin/community/map";
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
                        $('.roleDetails').click(function(){
                            window.location.href = "/admin/community/details?id=" + $(this).attr("role_id");
                        });

                        $('.roleEdit').click(function(){
                            window.location.href = "/admin/community/edit?id=" + $(this).attr("role_id");
                        });
                        $('.roleDelete').click(function(){
                            if(confirm("确定要删除该楼盘吗？")) {
                                $.ajax({
                                    "type": "GET",
                                    "contentType": "application/json",
                                    "url": "/admin/community/deleteajax",
                                    "dataType": "json",
                                    "data": {id: $(this).attr("role_id")}, //以json格式传递
                                    "success": function (data) {
                                        console.log(data);
                                        table.page(table.page()).draw(false);
                                    }
                                });
                            }
                        });
                        if(search == null) {
                            search =  $('input[type=search]');
                            search.before("(楼盘编号、名称，所在城市，所属区域、详细地址)&nbsp;");
                        }
                    }
                });
            },
            'columns' : <?=$columns?>
        }
    ).api();
});
</script>