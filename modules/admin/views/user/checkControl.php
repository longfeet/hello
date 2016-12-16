<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">企业管理/ <small>审核设置</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">

                </div>
                <div class="panel-body">
                    <form role="form" id="editForm" method="POST" action="/admin/user/editcheckcontrol">
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-md-3" style="width:150px;height: 35px;line-height:35px;">楼盘信息审核：</div>
                            <div class="col-md-5" style="height: 35px;line-height:35px;">
                                <label><input name="community" type="radio" value="0" <?=$checkControl->control_community==0?"checked='true'":"" ?>/>关闭 </label>&nbsp;&nbsp;&nbsp;
                                <label><input name="community" type="radio" value="1" <?=$checkControl->control_community==1?"checked='true'":"" ?> />开启 </label>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-md-3" style="width:150px;height: 35px;line-height:35px;">广告位信息审核：</div>
                            <div class="col-md-5" style="height: 35px;line-height:35px;">
                                <label><input name="adv" type="radio" value="0" <?=$checkControl->control_adv==0?"checked='true'":"" ?> />关闭 </label>&nbsp;&nbsp;&nbsp;
                                <label><input name="adv" type="radio" value="1" <?=$checkControl->control_adv==1?"checked='true'":"" ?> />开启 </label>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 5px;display: none;">
                            <div class="col-md-3" style="width:150px;height: 35px;line-height:35px;">设备信息审核：</div>
                            <div class="col-md-5" style="height: 35px;line-height:35px;">
                                <label><input name="model" type="radio" value="0" <?=$checkControl->control_model==0?"checked='true'":"" ?> />关闭 </label>&nbsp;&nbsp;&nbsp;
                                <label><input name="model" type="radio" value="1" <?=$checkControl->control_model==1?"checked='true'":"" ?> />开启 </label>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 5px;display: none;">
                            <div class="col-md-3" style="width:150px;height: 35px;line-height:35px;">客户信息审核：</div>
                            <div class="col-md-5" style="height: 35px;line-height:35px;">
                                <label><input name="customer" type="radio" value="0" <?=$checkControl->control_customer==0?"checked='true'":"" ?> />关闭 </label>&nbsp;&nbsp;&nbsp;
                                <label><input name="customer" type="radio" value="1" <?=$checkControl->control_customer==1?"checked='true'":"" ?> />开启 </label>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-md-3" style="width:120px;height: 35px;line-height:35px;">
                                <input type="hidden" name="id" value="<?=$checkControl->id ?>">
                                <a href="javascript:;" class="btn btn-info" id="edit" style="float:right;width:5rem;text-align:center;margin-right:50%;">提&nbsp;交</a>
                            </div>
                            <div class="col-md-5"></div>
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
        $("#edit").click(function(){
           $("#editForm").submit();
        });
    });
</script>