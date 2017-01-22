<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">销售管理/ <small>销售查询</small></h1>
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
                                <th>序号</th>
                                <th>楼盘名称</th>
                                <th>广告位编号</th>
                                <th>广告位名称</th>
                                <th>客户公司</th>
                                <th>客户联系人</th>
                                <th>开始时间</th>
                                <th>到期时间</th>
                                <th>销售人员</th>
                                <th>销售状态</th>
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
<script src="/assets/artDialog/dist/dialog.js"></script>
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
    var search = null;
    $(document).ready(function () {

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

                        if(search == null) {
                            search = $('input[type=search]');
                            search.before("(楼盘名称、客户公司、销售人员)&nbsp;");
                        }
                    }
                });
            },
            'columns': <?=$columns?>
        }).api();

    });

    function mybind(func, fn) {
        $(func).bind("touchstart", fn);
        $(func).bind("click", fn);
    }
</script>