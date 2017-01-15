<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">楼盘管理/
                <small>楼盘信息</small>
            </h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= $data->community_name ?>
                </div>
                <div class="panel-body">
                    <form role="form" id="communityForm" method="post" action="/admin/community/doedit">
                        <input name="id" type="hidden" value="<?= $data->id ?>"/>
                        <div class="form-group row">
                            <label class="control-label col-md-1">楼盘编号：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= $data->community_no ?></label>
                            <label class="control-label col-md-1">楼盘名称：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= $data->community_name ?></label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">所在城市：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= $data->community_city ?></label>
                            <label class="control-label col-md-1">所属区域：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= $data->community_area ?></label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">楼盘详细地址：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= $data->community_position ?></label>
                            <label class="control-label col-md-1">楼盘类型：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= $data->community_category ?></label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">楼盘均价：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= $data->community_price ?></label>
                            <label class="control-label col-md-1">楼盘所在商圈：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= $data->community_cbd ?></label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">交通特征：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= $data->community_traffic ?></label>
                            <label class="control-label col-md-1">周边配套：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= $data->community_facility ?></label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">楼盘性质：</label>
                            <?php echo $data->community_nature == "0" ? "<label class='control-label col-md-4' style='font-weight:normal;'>新建楼盘</label>" : "" ?>
                            <?php echo $data->community_nature == "1" ? "<label class='control-label col-md-4' style='font-weight:normal;'>老楼盘</label>" : "" ?>
                            <?php echo $data->community_nature == "2" ? "<label class='control-label col-md-4' style='font-weight:normal;'>改造楼盘</label>" : "" ?>
                            <label class="control-label col-md-1">楼盘开盘时间：</label>
                            <label class="control-label col-md-4" style='font-weight:normal;'><?= substr($data->community_opentime, 0, 10) ?></label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">楼盘入住时间：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= substr($data->community_staytime, 0, 10) ?></label>
                            <label class="control-label col-md-1">楼盘户数：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= $data->community_units ?></label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">楼盘入住人数：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= $data->community_households ?></label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">楼盘门头图片：</label>
                            <label class="control-label col-md-4">
                                <?php if(isset($data->community_image1)){ ?><img id="community_image" src="<?= $data->community_image1 ?>" class="smallPic"/><?php } ?>
                            </label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">楼盘坐标：</label>
                            <label class="control-label col-md-4" style="font-weight:normal;"><?= $data->community_longitudex ?>
                                ,<?= $data->community_latitudey ?></label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1"></label>
                            <label class="control-label col-md-6">
                                <div id="map" style="width:50rem;height:50rem;"></div>
                            </label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1">历史图片：</label>
                            <label class="control-label col-md-4" style='font-weight:normal;'><a href="javascript:;" community_id="<?= $data->id ?>" class="showDetails">查看</a></label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-1"></label>
                            <label class="control-label col-md-8"><div id="details"></div></label>
                        </div>
                    </form>
                </div>
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
        clear: both;
    }

    .form-group input.form-control {
        float: right;
        width: 40%;
        margin-right: 50%;
    }

    .form-group label.control-label {
        line-height: 34px;
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
    var map = new BMap.Map("map");                    // 创建Map实例
    var editpoint = new BMap.Point("<?=$data->community_longitudex?>", "<?=$data->community_latitudey?>");
    map.addOverlay(new BMap.Marker(editpoint));
    map.centerAndZoom(editpoint, 15);                    // 初始化地图,设置中心点坐标
    //map.centerAndZoom("南京", 15);                    // 初始化地图,设置中心点坐标和地图级别
    map.enableScrollWheelZoom(true);
    map.addEventListener("click", function (e) {
        $("#position").val(e.point.lng + "," + e.point.lat);
        map.clearOverlays();
        var point = new BMap.Point(e.point.lng, e.point.lat);
        var marker = new BMap.Marker(point);
        map.addOverlay(marker);
    });
    var inputs = ['community_no', 'community_name', 'community_opentime', 'community_staytime', 'community_units', 'community_households', 'community_map'];
    $(window).ready(function () {
        $('#community_image').click(function(){
            if($(this).hasClass('smallPic')) {
                $('#community_image').removeClass('smallPic');
                $('#community_image').addClass('bigPic');
            } else {
                $('#community_image').removeClass('bigPic');
                $('#community_image').addClass('smallPic');
            }
        });


        $("#editCommunity").click(function () {
            for (var i in inputs) {
                if ($("input[name=" + inputs[i] + "]").val() == "") {
                    alert("必填项(*)不能为空！");
                    $("input[name=" + inputs[i] + "]").focus();
                    return false;
                }
            }
            $("#communityForm").submit();
        });

        $('#selectDate1').datepicker({
            dateFormat: "yy-mm-dd",
            monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
            changeMonth: true,
            changeYear: true
        });

        $('#selectDate2').datepicker({
            dateFormat: "yy-mm-dd",
            monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
            changeMonth: true,
            changeYear: true
        });

        //查看历史图片
        $('.showDetails').bind("click", function () {
            var community_id = $(this).attr('community_id');
            $.ajax({
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/community/ajaxhistoryimage?community_id=" + community_id,
                "dataType": "json",
                "success": function (data) {
                    var imgString = "";
                    for (var i = 0; i < data.length; i++) {
                        imgString += "<a href='/admin/community/downloadimage?file="+data[i].image_name+"'><img src='" + data[i].image_path + "' class='smallPic' style='padding-bottom: 5px;'/>" +
                            "</a>&nbsp;";
                    }
                    $('#details').html(imgString);
                }
            });
        });

    });
</script>