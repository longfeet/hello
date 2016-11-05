<div id="hidden" style="position:absolute;top:10%;left:34%;width:5px;height:5px;">
</div>
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                消息管理/ <small>消息提醒</small>
            </h1>
        </div>
    </div>
    <!-- /. ROW  -->

    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    消息列表
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="8%">序号</th>
                                <th >消息内容</th>
                                <th width="30%">发布时间</th>
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
                        }
                    });
                },
                'columns' : <?=$columns?>
            }
        ).api();
    });
</script>
