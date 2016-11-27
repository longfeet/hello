<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">设备管理/ <small>添加设备</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    设备添加
                </div>
                <div class="panel-body">
                    <form role="form" id="addModelForm" method="POST" action="/admin/model/doadd">
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">设备编号：</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="model_no" /></div>
                        </div>
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">产品名称：</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="model_name" /></div>
                        </div>
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">产品类别：</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="model_category" /></div>
                        </div>
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">规格型号：</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="model_desc" /></div>
                        </div>
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">机器尺寸：</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="model_size" /></div>
                        </div>
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">展示尺寸：</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="model_display" /></div>
                        </div>
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">生产厂家：</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="model_factory" /></div>
                        </div>
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">备注：</div>
                            <div class="col-md-9"><textarea class="form-control" rows="3" name="model_note"></textarea></div>
                        </div>
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;"><a href="javascript:;" class="btn btn-info" id="addModel" style="float:right;width:5rem;text-align:center;margin-right:50%;">提&nbsp;交</a></div>
                            <div class="col-md-9"></div>
                        </div>
                    </form>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <!-- /. ROW  -->
</div>
<style type="text/css">
    .form-group:after {
        content:":";
        clear:both;
    }
    .form-group input.form-control {
        float:right;width:40%;margin-right:50%;
    }
    .form-group label.control-label {
        line-height:34px;
    }
</style>
<!-- /. PAGE INNER  -->
<script type="text/javascript">
    $(window).ready(function() {
        $("#addModel").click(function(){
           $("#addModelForm").submit();
        });
    });
</script>