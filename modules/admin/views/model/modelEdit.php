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
                    <form role="form" id="editModelForm" action="/admin/model/doedit" method="POST">
                        <input name="id" type="hidden" value="<?=$model->id?>" />
                        <div class="form-group">
                            <label class="control-label">设备编号</label>
                            <input type="text" class="form-control" value="<?=$model->model_no?>" name="model_no" />
                        </div>

                        <div class="form-group">
                            <label class="control-label">产品名称</label>
                            <input type="text" class="form-control" value="<?=$model->model_name?>" name="model_name" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">产品类别</label>
                            <input type="text" class="form-control" value="<?=$model->model_category?>" name="model_category" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">规格型号</label>
                            <input type="text" class="form-control" value="<?=$model->model_desc?>" name="model_desc" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">机器尺寸</label>
                            <input type="text" class="form-control" value="<?=$model->model_size?>" name="model_size" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">展示尺寸</label>
                            <input type="text" class="form-control" value="<?=$model->model_display?>" name="model_display" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">生产厂家</label>
                            <input type="text" class="form-control" value="<?=$model->model_factory?>" name="model_factory" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">备注</label>
                            <input type="text" class="form-control" value="<?=$model->model_note?>" name="model_note" />
                        </div>
                        <div class="form-group1">
                            <label class="control-label"></label>
                            <a href="javascript:;" class="btn btn-info" id="editModel" style="float:right;width:5rem;text-align:center;margin-right:50%;">提&nbsp;交</a>
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
        $("#editModel").click(function(){
            $("#editModelForm").submit();
        });
    });
</script>