<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">广告位管理/ <small>编辑广告位</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    编辑广告位
                </div>
                <div class="panel-body">
                    <form role="form" id="editForm" action="/admin/adv/doedit" method="POST" enctype="multipart/form-data">
                        <input name="id" type="hidden" value="<?=$data->id?>" />
                        <div class="form-group">
                            <label class="control-label">广告位编号：</label>
                            <input type="text" class="form-control" value="<?=$data->adv_no?>" name="adv_no" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">所属楼盘：</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;" name="adv_community_id">
                                <?php foreach($list as $key=>$value){?>
                                <option value="<?=$value->id?>" <?php echo $data->adv_community_id == $value->id?"selected=\"selected\"":""?>><?=$value->community_name?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位名称：</label>
                            <input type="text" name="adv_name" class="form-control" value="<?=$data->adv_name?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位开始时间</label>
                            <input type="text" name="adv_starttime" class="form-control" id="selectDate1" value="<?=substr($data->adv_starttime,0,10)?>" />
                        </div>
<!--                        <div class="form-group">
                            <label class="control-label">广告位结束时间</label>
                            <input type="text" name="adv_endtime" class="form-control" id="selectDate2" value="<?//=substr($data->adv_endtime,0,10)?>" />
                        </div>-->
                        <div class="form-group">
                            <label class="control-label">广告位画面：</label>
                            <input type="file" style="float:right;margin-right:67%;" name="adv_image" />
                        </div>
                        <div class="form-group">
                            <label class="control-label" style="vertical-align:middle;">原画：</label>
                            <label class="control-label"><?php if(isset($data->adv_image)){ ?><img id="adv_image" src="<?=$data->adv_image?>" class="smallPic" style="padding-bottom: 10px;" /><?php } ?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位性质：</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;" name="adv_property">
                                <option value="0" <?php echo $data->adv_property == "0"?"selected=\"selected\"":""?>>
                                    电梯广告</option>
                                <option value="1" <?php echo $data->adv_property == "1"?"selected=\"selected\"":""?>>
                                    道闸广告</option>
                                <option value="2" <?php echo $data->adv_property == "2"?"selected=\"selected\"":""?>>
                                    道杆广告</option>
                                <option value="3" <?php echo $data->adv_property == "3"?"selected=\"selected\"":""?>>
                                    灯箱</option>
                                <option value="4" <?php echo $data->adv_property == "4"?"selected=\"selected\"":""?>>
                                    行人门禁</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位详细地址：</label>
                            <input type="text" class="form-control" name="adv_position" value="<?=$data->adv_position?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">设备型号：</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;" name="model_id">
                                <?php foreach($model as $key=>$value) {?>
                                <option value="<?=$value->id?>" <?php echo $data->model_id == $value->id?"selected=\"selected\"":""?>>
                                    <?=$value->model_name?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">当前状态：</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;" name="adv_install_status">
                                <option value="0" <?php echo $data->adv_install_status == "0"?"selected=\"selected\"":""?>>
                                    未安装</option>
                                <option value="1" <?php echo $data->adv_install_status == "1"?"selected=\"selected\"":""?>>
                                    待维修(损坏)</option>
                                <option value="2" <?php echo $data->adv_install_status == "2"?"selected=\"selected\"":""?>>
                                    正常使用</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">使用状态：</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;" name="adv_use_status">
                                <option value="0" <?php echo $data->adv_use_status == "0"?"selected=\"selected\"":""?>>
                                    新增</option>
                                <option value="1" <?php echo $data->adv_use_status == "1"?"selected=\"selected\"":""?>>
                                    未使用</option>
                                <option value="2" <?php echo $data->adv_use_status == "2"?"selected=\"selected\"":""?>>
                                    已使用</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">销售状态：</label>
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
                            <label class="control-label">画面状态：</label>
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
                            <label class="control-label"><a href="javascript:;" class="btn btn-info" id="editAdv" style="float:right;width:5rem;text-align:center;margin-right:50%;">提&nbsp;交</a></label>
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
<!-- /. PAGE INNER  -->
<script type="text/javascript">
    $(window).ready(function() {
        $('#adv_image').click(function(){
            if($(this).hasClass('smallPic')) {
                $('#adv_image').removeClass('smallPic');
                $('#adv_image').addClass('bigPic');
            } else {
                $('#adv_image').removeClass('bigPic');
                $('#adv_image').addClass('smallPic');
            }
        });

        $("#editAdv").click(function(){
            $("#editForm").submit();
        });
        $('#selectDate1').datepicker({
            dateFormat:"yy-mm-dd",
            monthNamesShort: ['1月','2月','3月','4月','5月','6月', '7月','8月','9月','10月','11月','12月'],
            dayNamesMin:['日','一','二','三','四','五','六'],
            changeMonth: true,
            changeYear: true
        });
        $('#selectDate2').datepicker({
            dateFormat:"yy-mm-dd",
            monthNamesShort: ['1月','2月','3月','4月','5月','6月', '7月','8月','9月','10月','11月','12月'],
            dayNamesMin:['日','一','二','三','四','五','六'],
            changeMonth: true,
            changeYear: true
        });
    });
</script>