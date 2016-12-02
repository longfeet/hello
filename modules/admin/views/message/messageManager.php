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
                        <div class="panel-heading" id="statusFix">
                            <a href="javascript:;" class="btn btn-info" id="read">标记为已读</a>
                            <a href="javascript:;" class="btn btn-info" id="readAll">全部设为已读</a>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="8%"><input type="checkbox" id="checkAll"/>&nbsp;&nbsp;序号</th>
                                <th >内容</th>
                                <th width="30%">发布时间</th>
                                <th >状态</th>
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
<style type="text/css">

</style>


<script type="text/javascript">
    var tree;
    var search = null;
    $(document).ready(function () {
        //checkbox全选和全不选
        $("#checkAll").click(function () {
            for (var key in $("input[name='messageLog']")) {
                $("input[name='messageLog']")[key].checked = this.checked;
            }
        })

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

        //标记为已读
        $("#read").click(function () {
            var ids = getCheckValue('messageLog');
            if (ids.length < 1) {
                alert("请选择至少一条记录！");
                return false;
            }

            $.ajax( {
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/message/doread",
                "dataType": "json",
                "data": {
                    ids:ids
                }, //以json格式传递
                "success": function(data) {
                    if(data > 0){
                        window.location.reload();
                    }else{
                        alert("设置失败！");
                    }
                }
            });
        })

        //全部标记为已读
        $("#readAll").click(function () {
            $.ajax( {
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/message/doreadall",
                "dataType": "json",
                "success": function(data) {
                    if(data > 0){
                        window.location.reload();
                    }else{
                        alert("设置失败！");
                    }
                }
            });
        })


        //获得选中的消息（message_log）的id
        function getCheckValue(nameId) {
            var arr = [];
            for (var i = 0; i < $("input[name='" + nameId + "']").length; i++) {
                if ($("input[name='" + nameId + "']")[i].checked) {
                    arr.push($("input[name='" + nameId + "']")[i].value);
                }
            }
            return arr;
        }

    });
</script>
