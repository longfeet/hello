<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">广告位管理/ <small>添加广告位</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    EXCEL上传
                </div>
                <div class="panel-body">
                    <form role="form" id="advForm" method="post" action="/admin/adv/doexcel" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label"></label>
                            <a href="javascript:;" class="btn btn-info" id="downloadExcel" style="float:left;width:8rem;text-align:center;margin-right:50%;">模版下载</a>
                        </div>
                        <div class="form-group">
                            <label class="control-label">上传文件(<span class="mydanger">*</span>)</label>
                            <input type="file" name="commExcel" />
                        </div>
                        <div class="form-group1" style="padding-top: 15px;">
                            <label class="control-label"></label>
                            <a href="javascript:;" class="btn btn-info" id="addAdv" style="float:left;width:8rem;text-align:center;margin-right:50%;">提&nbsp;交</a>
                        </div>
                    </form>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <!-- /. ROW  -->
</div>
<script src="/assets/datepicker/jquery.ui.datepicker.js"></script>
<script src="/assets/datepicker/jquery-ui.js"></script>
<link rel="stylesheet" href="/css/jquery-ui.css">
<style type="text/css">
    .form-group:after {
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
        $("#downloadExcel").click(function(){
            window.location.href = "/admin/adv/downloadexcel";
        });

        $("#addAdv").click(function(){
            $("#advForm").submit();
        });
    });
</script>