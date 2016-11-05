<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">设备管理/ <small>设备详情</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?=$model->model_name?>
                </div>
                <div class="panel-body">
                    <form role="form" id="editModelForm" action="/admin/model/doedit" method="POST">
                        <input name="id" type="hidden" value="<?=$model->id?>" />
                        <div class="form-group">
                            <label class="control-label">设备编号：</label>
                            <label class="control-label"><?=$model->model_no?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">产品名称：</label>
                            <label class="control-label"><?=$model->model_name?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">产品类别：</label>
                            <label class="control-label"><?=$model->model_category?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">规格型号：</label>
                            <label class="control-label"><?=$model->model_desc?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">机器尺寸：</label>
                            <label class="control-label"><?=$model->model_size?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">展示尺寸：</label>
                            <label class="control-label"><?=$model->model_display?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">生产厂家：</label>
                            <label class="control-label"><?=$model->model_factory?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">备注：</label>
                            <label class="control-label"><?=$model->model_note?></label>
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