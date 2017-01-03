<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">楼盘管理/ <small>添加楼盘</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    楼盘添加
                </div>
                <div class="panel-body">
                    <form role="form" id="communityForm" method="post" action="/admin/community/doadd" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label">楼盘编号(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" name="community_no" />
                        </div>

                        <div class="form-group">
                            <label class="control-label">楼盘名称(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" name="community_name" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">所在城市</label>
                            <input type="text" class="form-control" name="community_city" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">所属区域</label>
                            <input type="text" class="form-control" name="community_area" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘详细地址(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" name="community_position" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘类型</label>
                            <input type="text" class="form-control" name="community_category" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘均价(￥)</label>
                            <input type="text" class="form-control" name="community_price" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘所在商圈</label>
                            <input type="text" class="form-control" name="community_cbd" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">交通特征</label>
                            <input type="text" class="form-control" name="community_traffic" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">周边配套</label>
                            <input type="text" class="form-control" name="community_facility" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘性质</label>
                            <select class="form-control" name="community_nature" style="width:40%;float:right;margin-right:50%;">
                                <option value="0">新建楼盘</option>
                                <option value="1">老楼盘</option>
                                <option value="2">改造楼盘</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘开盘时间(<span class="mydanger">*</span>)</label>
                            <input type="text" id="selectDate1" name="community_opentime" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘入住时间(<span class="mydanger">*</span>)</label>
                            <input type="text" id="selectDate2" name="community_staytime" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘户数(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" name="community_units" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘入住人数(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" name="community_households" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘坐标(<span class="mydanger">*</span>)</label>
                            <input type="text" class="form-control" id="position" name="community_map" />
                        </div>
                        <div id="map" style="width:50rem;height:50rem;margin-left:10%;">

                        </div>
                        <div class="form-group" style="margin-top:2rem;">
                            <label class="control-label">楼盘门头图片</label>
                            <input type="file" style="float:right;margin-right:67%;" name="community_image1" />
                        </div>
                        <div class="form-group1">
                            <label class="control-label"></label>
                            <label class="control-label"><a href="javascript:;" class="btn btn-info" id="addCommunity" style="float:right;width:5rem;text-align:center;margin-right:50%;">提&nbsp;交</a></label>
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
    map.centerAndZoom("南京", 15);                    // 初始化地图,设置中心点坐标和地图级别
    map.enableScrollWheelZoom(true);
    map.addEventListener("click", function(e){
        $("#position").val(e.point.lng + "," + e.point.lat);
        map.clearOverlays();
        var point = new BMap.Point(e.point.lng, e.point.lat);
        var marker = new BMap.Marker(point);
        map.addOverlay(marker);
    });

    var inputs = ['community_no','community_name','community_position','community_opentime','community_staytime','community_units','community_households','community_map'];
    $(window).ready(function() {
        $("#addCommunity").click(function(){
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