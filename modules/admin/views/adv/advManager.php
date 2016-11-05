<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">广告管理/ <small>广告位列表</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    广告位列表
                    <a href="javascript:;" class="btn btn-info" id="addAdv" style="float:right;margin-top:-0.5rem;">添加广告位</a>
                    <a href="javascript:;" class="btn btn-info" id="addExcel" style="float:right;margin-top:-0.5rem;margin-right:1rem;">EXCEL上传</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="5%">序号</th>
                                <th width="25%">广告名称</th>
                                <th width="25%">楼盘名称</th>
                                <th width="15%">公司名称</th>
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
        window.location.href = "/admin/adv/addexcel";
    });

    $("#addAdv").click(function(){
        window.location.href = "/admin/adv/add";
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
                            window.location.href = "/admin/adv/details?id=" + $(this).attr("role_id");
                        });
                        $('.roleEdit').click(function(){
                            window.location.href = "/admin/adv/edit?id=" + $(this).attr("role_id");
                        });
                        $('.advBind').click(function(){
                            window.location.href = "/admin/adv/flow?id=" + $(this).attr("adv_id")
                        });
                        if(search == null) {
                            search =  $('input[type=search]');
                            search.before("(广告位名称)&nbsp;");
                        }
                    }
                });
            },
            'columns' : <?=$columns?>
        }
    ).api();
});
</script>