<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">楼盘管理/ <small>编辑楼盘</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    编辑楼盘
                </div>
                <div class="panel-body">
                    <form role="form" id="communityForm" method="post" action="/admin/community/doedit" enctype="multipart/form-data">
                        <input name="id" type="hidden" value="<?=$data->id?>" />
                        <div class="form-group">
                            <label class="control-label">楼盘编号(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" value="<?=$data->community_no?>" name="community_no" />
                        </div>

                        <div class="form-group">
                            <label class="control-label">楼盘名称(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" value="<?=$data->community_name?>" name="community_name" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">所在城市(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" value="<?=$data->community_city?>" name="community_city" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">所属区域(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" value="<?=$data->community_area?>" name="community_area" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘详细地址</label>
                            <input type="text" class="form-control" value="<?=$data->community_position?>" name="community_position" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘类型</label>
                            <input type="text" class="form-control" value="<?=$data->community_category?>" name="community_category" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘均价</label>
                            <input type="text" class="form-control" value="<?=$data->community_price?>" name="community_price" />(￥)
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘所在商圈</label>
                            <input type="text" class="form-control" value="<?=$data->community_cbd?>" name="community_cbd" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">交通特征</label>
                            <input type="text" class="form-control" value="<?=$data->community_traffic?>" name="community_traffic" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">周边配套</label>
                            <input type="text" class="form-control" value="<?=$data->community_facility?>" name="community_facility" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘性质</label>
                            <select class="form-control" name="community_nature" style="width:40%;float:right;margin-right:50%;">
                                <option value="0" <?php echo $data->community_nature == "0"?"selected=\"selected\"":""?>>新建楼盘</option>
                                <option value="1" <?php echo $data->community_nature == "1"?"selected=\"selected\"":""?>>老楼盘</option>
                                <option value="2" <?php echo $data->community_nature == "2"?"selected=\"selected\"":""?>>改造楼盘</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘开盘时间(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" name="community_opentime" id="selectDate1" value="<?=substr($data->community_opentime,0,10)?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘入住时间(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" name="community_staytime" id="selectDate2" value="<?=substr($data->community_staytime,0,10)?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘户数(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" name="community_units" value="<?=$data->community_units?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘入住人数(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" name="community_households" value="<?=$data->community_households?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘坐标(<span class="mydanger">*</span>)</label>
                            <input type="text" id="position" name="community_map" class="form-control" value="<?=$data->community_longitudex?>,<?=$data->community_latitudey?>" />
                        </div>
                        <div id="map" style="width:50rem;height:50rem;margin-left:10%;">

                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘门头图片</label>
                            <input type="file" name="community_image1" style="float:right;margin-right:67%;"  />
                        </div>
                        <div class="form-group">
                            <label class="control-label">原图</label>
                            <img src="<?=$data->community_image1?>" style="float:right;margin-right:63%;width:400px;" />
                        </div>
                        <div class="form-group1">
                            <label class="control-label"></label>
                            <a href="javascript:;" class="btn btn-info" id="editCommunity" style="float:right;width:5rem;text-align:center;margin-right:50%;margin-top:50px;">提&nbsp;交</a>
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
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Ab2CQa603kmx8tYXETWEEOjozKgdUXVL"></script>
<link rel="stylesheet" href="/css/jquery-ui.css">
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
    .mydanger {
        color:red;
    }
</style>
<!-- /. PAGE INNER  -->
<script type="text/javascript">
    var map = new BMap.Map("map");                    // 创建Map实例
    var editpoint = new BMap.Point("<?=$data->community_longitudex?>", "<?=$data->community_latitudey?>");
    map.addOverlay(new BMap.Marker(editpoint));
    map.centerAndZoom("南京", 15);                    // 初始化地图,设置中心点坐标和地图级别
    map.enableScrollWheelZoom(true);
    map.addEventListener("click", function(e){
        $("#position").val(e.point.lng + "," + e.point.lat);
        map.clearOverlays();
        var point = new BMap.Point(e.point.lng, e.point.lat);
        var marker = new BMap.Marker(point);
        map.addOverlay(marker);
    });
    var inputs = ['community_no','community_name','community_opentime','community_staytime','community_units','community_households','community_map'];
    $(window).ready(function() {
        $("#editCommunity").click(function(){
            for(var i in inputs) {
                if ($("input[name="+inputs[i]+"]").val() == "") {
                    alert("必填项(*)不能为空！");
                    $("input[name="+inputs[i]+"]").focus();
                    return false;
                }
            }
            $("#communityForm").submit();
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