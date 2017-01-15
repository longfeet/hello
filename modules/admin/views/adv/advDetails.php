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
                        <div class="form-group row">
                            <label class="control-label col-md-1">广告位编号：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?=$data->adv_no?></label>
                            <label class="control-label col-md-1">所属楼盘：</label>
                            <?php foreach($list as $key=>$value){?>
                                <?php echo $data->adv_community_id == $value->id?"<label class='control-label col-md-4' style='font-weight:normal;'>".$value->community_name."</label>":""?>
                            <?php }?>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">广告位名称：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?=$data->adv_name?></label>
                            <label class="control-label col-md-1">开始时间：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?=substr($data->adv_starttime,0,10)?></label>
                        </div>

                        <!--                        <div class="form-group">
                            <label class="control-label">广告位结束时间：</label>
                            <label class="control-label"><?=substr($data->adv_endtime,0,10)?></label>
                        </div>
                        -->
                        <div class="form-group row">
                            <label class="control-label col-md-1">广告位画面：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?php if(isset($data->adv_image)){ ?><img id="adv_image" src="<?=$data->adv_image?>" class="smallPic"/><?php } ?></label>
                            <label class="control-label col-md-1">广告位性质：</label>
                            <?php echo $data->adv_property == "0"?"<label class='control-label col-md-4' style='font-weight:normal;'>电梯广告</label>":""?>
                            <?php echo $data->adv_property == "1"?"<label class='control-label col-md-4' style='font-weight:normal;'>道闸广告</label>":""?>
                            <?php echo $data->adv_property == "2"?"<label class='control-label col-md-4' style='font-weight:normal;'>道杆广告</label>":""?>
                            <?php echo $data->adv_property == "3"?"<label class='control-label col-md-4' style='font-weight:normal;'>灯箱</label>":""?>
                            <?php echo $data->adv_property == "4"?"<label class='control-label col-md-4' style='font-weight:normal;'>行人门禁</label>":""?>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">详细地址：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?=$data->adv_position?></label>
                            <label class="control-label col-md-1">设备型号：</label>
                            <?php foreach($model as $key=>$value) {?>
                                <?php echo $data->model_id == $value->id?"<label class='control-label col-md-4' style='font-weight:normal;'>".$value->model_name."</label>":""?>
                            <?php }?>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">当前状态：</label>
                            <?php echo $data->adv_install_status == "0"?"<label class='control-label col-md-4' style='font-weight:normal;'>未安装</label>":""?>
                            <?php echo $data->adv_install_status == "1"?"<label class='control-label col-md-4' style='font-weight:normal;'>待维修(损坏)</label>":""?>
                            <?php echo $data->adv_install_status == "2"?"<label class='control-label col-md-4' style='font-weight:normal;'>正常使用</label>":""?>
                            <label class="control-label col-md-1">使用状态：</label>
                            <?php echo $data->adv_use_status == "0"?"<label class='control-label col-md-4' style='font-weight:normal;'>新增</label>":""?>
                            <?php echo $data->adv_use_status == "1"?"<label class='control-label col-md-4' style='font-weight:normal;'>未使用</label>":""?>
                            <?php echo $data->adv_use_status == "2"?"<label class='control-label col-md-4' style='font-weight:normal;'>已使用</label>":""?>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">销售状态：</label>
                            <?php echo $data->adv_sales_status == "0"?"<label class='control-label col-md-4' style='font-weight:normal;'>销售</label>":""?>
                            <?php echo $data->adv_sales_status == "1"?"<label class='control-label col-md-4' style='font-weight:normal;'>赠送</label>":""?>
                            <?php echo $data->adv_sales_status == "2"?"<label class='control-label col-md-4' style='font-weight:normal;'>置换</label>":""?>
                            <label class="control-label col-md-1">画面状态：</label>
                            <?php echo $data->adv_pic_status == "0"?"<label class='control-label col-md-4' style='font-weight:normal;'>预定</label>":""?>
                            <?php echo $data->adv_pic_status == "1"?"<label class='control-label col-md-4' style='font-weight:normal;'>待上刊</label>":""?>
                            <?php echo $data->adv_pic_status == "2"?"<label class='control-label col-md-4' style='font-weight:normal;'>已上刊</label>":""?>
                            <?php echo $data->adv_pic_status == "3"?"<label class='control-label col-md-4' style='font-weight:normal;'>待下刊</label>":""?>
                            <?php echo $data->adv_pic_status == "4"?"<label class='control-label col-md-4' style='font-weight:normal;'>已下刊</label>":""?>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">历史图片：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><a href="javascript:;" adv_id="<?= $data->id ?>" class="showDetails">查看</a></label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1"></label>
                            <label class="control-label col-md-4""><div id="details"></div></label>
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

    .smallPic{
        width:200px;
        height:100px;
    }

    .bigPic{
        width:500px;
        height:250px;
    }
</style>

<script type="text/javascript">
    $(window).ready(function () {
        $('#adv_image').click(function(){
            if($(this).hasClass('smallPic')) {
                $('#adv_image').removeClass('smallPic');
                $('#adv_image').addClass('bigPic');
            } else {
                $('#adv_image').removeClass('bigPic');
                $('#adv_image').addClass('smallPic');
            }
        });

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
                        imgString += "<a href='/admin/adv/downloadimage?file="+data[i].image_name+"'><img src='" + data[i].image_path + "' class='smallPic' style='padding-bottom: 5px;'/>" +
                            "</a>&nbsp;";
                    }
                    $('#details').html(imgString);
                }
            });
        });

    });
</script>
