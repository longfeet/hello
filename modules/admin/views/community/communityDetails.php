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
                        <div class="form-group">
                            <label class="control-label">楼盘编号：</label>
                            <label class="control-label"><?= $data->community_no ?></label>
                        </div>

                        <div class="form-group">
                            <label class="control-label">楼盘名称：</label>
                            <label class="control-label"><?= $data->community_name ?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘详细地址：</label>
                            <label class="control-label"><?= $data->community_position ?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘类型：</label>
                            <label class="control-label"><?= $data->community_category ?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘均价：</label>
                            <label class="control-label"><?= $data->community_price ?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘所在商圈：</label>
                            <label class="control-label"><?= $data->community_cbd ?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘性质：</label>
                            <?php echo $data->community_nature == "0" ? "<label class='control-label'>新建楼盘</label>" : "" ?>
                            <?php echo $data->community_nature == "1" ? "<label class='control-label'>老楼盘</label>" : "" ?>
                            <?php echo $data->community_nature == "2" ? "<label class='control-label'>改造楼盘</label>" : "" ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘开盘时间：</label>
                            <label class="control-label"><?= substr($data->community_opentime, 0, 10) ?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘入住时间：</label>
                            <label class="control-label"><?= substr($data->community_staytime, 0, 10) ?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘户数：</label>
                            <label class="control-label"><?= $data->community_units ?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘入住人数：</label>
                            <label class="control-label"><?= $data->community_households ?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘坐标：</label>
                            <label class="control-label"><?= $data->community_longitudex ?>
                                ,<?= $data->community_latitudey ?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label"></label>
                            <label class="control-label">
                                <div id="map" style="width:50rem;height:50rem;">
                            </label>
                        </div>
                </div>
                <div class="form-group">
                    <label class="control-label">楼盘门头图片：</label>
                    <img src="<?= $data->community_image1 ?>" style="width:500px; width:500px;"/>
                </div>
                <div class="form-group">
                    <label class="control-label">历史图片：</label>
                    <label class="control-label"><a href="javascript:;" community_id="<?= $data->id ?>"
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
                        imgString += "<img src='" + data[i].image_path + "' style='width:500px; width:500px;padding-bottom: 5px;'/><br/>";
                    }
                    $('#details').html(imgString);
                }
            });
        });

    });
</script>