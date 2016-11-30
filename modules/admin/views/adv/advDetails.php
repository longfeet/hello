<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">广告位管理/ <small>广告位信息</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?=$data->adv_name?>
                </div>
                <div class="panel-body">
                    <form role="form" id="editForm" action="/admin/adv/doedit" method="POST">
                        <div class="form-group">
                            <label class="control-label">广告位编号：</label>
                            <label class="control-label"><?=$data->adv_no?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">所属楼盘：</label>
                            <?php foreach($list as $key=>$value){?>
                                <?php echo $data->adv_community_id == $value->id?"<label class='control-label'>".$value->community_name."</label>":""?>
                            <?php }?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位名称：</label>
                            <label class="control-label"><?=$data->adv_name?></label>
                        </div>
<!--                        <div class="form-group">
                            <label class="control-label">广告位开始时间：</label>
                            <label class="control-label"><?=substr($data->adv_starttime,0,10)?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位结束时间：</label>
                            <label class="control-label"><?=substr($data->adv_endtime,0,10)?></label>
                        </div>
                        -->
                        <div class="form-group">
                            <label class="control-label">广告位画面：</label>
                            <label class="control-label"><img src="<?=$data->adv_image?>" style="width:500px; width:500px;"/></label>

                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位性质：</label>
                            <?php echo $data->adv_property == "0"?"<label class='control-label'>电梯广告</label>":""?>
                            <?php echo $data->adv_property == "1"?"<label class='control-label'>道闸广告</label>":""?>
                            <?php echo $data->adv_property == "2"?"<label class='control-label'>道杆广告</label>":""?>
                            <?php echo $data->adv_property == "3"?"<label class='control-label'>灯箱</label>":""?>
                            <?php echo $data->adv_property == "4"?"<label class='control-label'>行人门禁</label>":""?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位详细地址：</label>
                            <label class="control-label"><?=$data->adv_position?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">设备型号：</label>
                            <?php foreach($model as $key=>$value) {?>
                                <?php echo $data->model_id == $value->id?"<label class='control-label'>".$value->model_name."</label>":""?>
                            <?php }?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">当前状态：</label>
                            <?php echo $data->adv_install_status == "0"?"<label class='control-label'>未安装</label>":""?>
                            <?php echo $data->adv_install_status == "1"?"<label class='control-label'>待维修(损坏)</label>":""?>
                            <?php echo $data->adv_install_status == "2"?"<label class='control-label'>正常使用</label>":""?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">使用状态：</label>
                            <?php echo $data->adv_use_status == "0"?"<label class='control-label'>新增</label>":""?>
                            <?php echo $data->adv_use_status == "1"?"<label class='control-label'>未使用</label>":""?>
                            <?php echo $data->adv_use_status == "2"?"<label class='control-label'>已使用</label>":""?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">销售状态：</label>
                            <?php echo $data->adv_sales_status == "0"?"<label class='control-label'>销售</label>":""?>
                            <?php echo $data->adv_sales_status == "1"?"<label class='control-label'>赠送</label>":""?>
                            <?php echo $data->adv_sales_status == "2"?"<label class='control-label'>置换</label>":""?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">画面状态：</label>
                            <?php echo $data->adv_pic_status == "0"?"<label class='control-label'>预定</label>":""?>
                            <?php echo $data->adv_pic_status == "1"?"<label class='control-label'>待上刊</label>":""?>
                            <?php echo $data->adv_pic_status == "2"?"<label class='control-label'>已上刊</label>":""?>
                            <?php echo $data->adv_pic_status == "3"?"<label class='control-label'>待下刊</label>":""?>
                            <?php echo $data->adv_pic_status == "4"?"<label class='control-label'>已下刊</label>":""?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">历史图片：</label>
                            <label class="control-label"><a href="javascript:;" adv_id="<?= $data->id ?>"
                                                            class="showDetails">查看</a></label>
                            <div id="details"></div>
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

<script type="text/javascript">
    $(window).ready(function () {
        //查看历史图片
        $('.showDetails').bind("click", function () {
            var adv_id = $(this).attr('adv_id');
            $.ajax({
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/adv/ajaxhistoryimage?adv_id=" + adv_id,
                "dataType": "json",
                "success": function (data) {
                    var imgString = "";
                    for (var i = 0; i < data.length; i++) {
                        imgString += "<img src='" + data[i].image_path + "' style='width:500px; width:500px;padding-bottom: 5px;'/>" +
                            "&nbsp;<a href='/admin/adv/downloadimage?file="+data[i].image_name+"'>图片下载...</a><br/>";
                    }
                    $('#details').html(imgString);
                }
            });
        });

    });
</script>
