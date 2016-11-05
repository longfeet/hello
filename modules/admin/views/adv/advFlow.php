<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">广告位管理/ <small>广告位进度</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    广告位进度更新
                </div>
                <div class="panel-body">
                    <form role="form" id="editFlowForm" action="/admin/adv/doedit" method="POST" enctype="multipart/form-data">
                        <input name="id" type="hidden" value="<?=$data->id?>" />
                        <div class="form-group">
                            <label class="control-label">广告位名称</label>
                            <input type="text" name="adv_name" class="form-control" disabled="disabled" value="<?=$data->adv_name?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位编号</label>
                            <input type="text" class="form-control" value="<?=$data->adv_no?>" disabled="disabled" name="adv_no" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">所属楼盘</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;" disabled="disabled" name="adv_community_id">
                                <?php foreach($list as $key=>$value){?>
                                    <option value="<?=$value->id?>" <?php echo $data->adv_community_id == $value->id?"selected=\"selected\"":""?>><?=$value->community_name?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">当前状态</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;" name="adv_install_status">
                                <option value="0" <?php echo $data->adv_install_status == "0"?"selected=\"selected\"":""?>>
                                    未安装</option>
                                <option value="1" <?php echo $data->adv_install_status == "1"?"selected=\"selected\"":""?>>
                                    待维修(损坏)</option>
                                <option value="2" <?php echo $data->adv_install_status == "2"?"selected=\"selected\"":""?>>
                                    正常使用</option>
                            </select>
                        </div>
                        <a href="javascript:;" class="btn btn-info" id="install" style="float:right;width:5rem;text-align:center;margin-right:50%;">去安装</a>
                        <a href="javascript:;" class="btn btn-info" id="maintain" style="float:right;width:5rem;text-align:center;margin-right:50%;">去维修</a>
                        <div style="clear:both;"></div>
                        <br>
                        <!--<div class="form-group">
                            <label class="control-label">使用状态</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;" name="adv_use_status">
                                <option value="0" <?php /*echo $data->adv_use_status == "0"?"selected=\"selected\"":""*/?>>
                                    新增</option>
                                <option value="1" <?php /*echo $data->adv_use_status == "1"?"selected=\"selected\"":""*/?>>
                                    未使用</option>
                                <option value="2" <?php /*echo $data->adv_use_status == "2"?"selected=\"selected\"":""*/?>>
                                    已使用</option>
                            </select>
                        </div>-->
                        <div class="form-group">
                            <label class="control-label">销售状态</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;" name="adv_sales_status">
                                <option value="0" <?php echo $data->adv_sales_status == "0"?"selected=\"selected\"":""?>>
                                    销售</option>
                                <option value="1" <?php echo $data->adv_sales_status == "1"?"selected=\"selected\"":""?>>
                                    赠送</option>
                                <option value="2" <?php echo $data->adv_sales_status == "2"?"selected=\"selected\"":""?>>
                                    置换</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">画面状态</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;" name="adv_pic_status">
                                <option value="0" <?php echo $data->adv_pic_status == "0"?"selected=\"selected\"":""?>>
                                    预定</option>
                                <option value="1" <?php echo $data->adv_pic_status == "1"?"selected=\"selected\"":""?>>
                                    待上刊</option>
                                <option value="2" <?php echo $data->adv_pic_status == "2"?"selected=\"selected\"":""?>>
                                    已上刊</option>
                                <option value="3" <?php echo $data->adv_pic_status == "3"?"selected=\"selected\"":""?>>
                                    待下刊</option>
                                <option value="4" <?php echo $data->adv_pic_status == "4"?"selected=\"selected\"":""?>>
                                    已下刊</option>
                            </select>
                        </div>
                        <div class="form-group1">
                            <label class="control-label"></label>
                            <a href="javascript:;" class="btn btn-info" id="editAdvFlow" style="float:right;width:5rem;text-align:center;margin-right:50%;">提&nbsp;交</a>
                        </div>
                    </form>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <!-- /. ROW  -->
</div>

<div  id="dialogForm" style="width:40rem;display:none;">
    <?php foreach($staff as $key=>$value) {
            echo '<span style = "float:left;width:10rem;height:4rem;" ><input type = "checkbox" value = "" />'.$value->staff_name.'</span>';
        }
    ?>
</div>

<script src="/assets/datepicker/jquery.ui.datepicker.js"></script>
<script src="/assets/datepicker/jquery-ui.js"></script>
<link rel="stylesheet" href="/css/jquery-ui.css">
<script src="/assets/artDialog/dist/dialog.js"></script>
<script src="/assets/artDialog/dist/dialog-plus.js"></script>
<link href="/assets/artDialog/css/ui-dialog.css" rel="stylesheet" />
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
    .ui-dialog-body {
        padding:5px 10px 5px 10px;
    }
</style>
<!-- /. PAGE INNER  -->
<script type="text/javascript">
    $(window).ready(function() {
        $("#editAdvFlow").click(function () {
            $("#editFlowForm").submit();
        });

        $("#install").click(function(){
            var d = dialog({
                //follow: document.getElementById('install'),
                title: '选择安装人员',
                id: 'menu_dialog_id_install',
                drag: true,
                content: $("#dialogForm"),
                fixed: true,
                okValue: '确 定',
                onshow: function () {

                }
            });
            d.show();
        });

        $("#maintain").click(function(){
            var d = dialog({
                //follow: document.getElementById('install'),
                title: '选择安装人员',
                id: 'menu_dialog_id_install',
                drag: true,
                content: $("#dialogForm"),
                fixed: true,
                okValue: '确 定',
                onshow: function () {

                }
            });
            d.show();
        });

        firstStatus();
        $("select[name=adv_install_status]").change(function(){
            firstStatus();
        });

        function firstStatus () {
            if ($("select[name=adv_install_status]").val() == "0") {
                $("#install").show();
            } else {
                $("#install").hide();
            }
            if ($("select[name=adv_install_status]").val() == "1") {
                $("#maintain").show();
            } else {
                $("#maintain").hide();
            }
        }
    });
</script>