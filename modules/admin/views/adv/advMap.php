<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">楼盘管理/ <small>楼盘地图</small> </h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div style="float:left;width:20rem;">
            楼盘列表
            <ul class="mapul" style="margin-left:-3.5rem;">
                <li><input name="search" type="text" />&nbsp;&nbsp;&nbsp;&nbsp;<input id="searchComm" type="submit" value="搜索" /></li>
                <li>显示选取周围范围<br><input name="mapfield" value="0.5" type="text" style="width:9rem;" />&nbsp;&nbsp;公里圆形区域</li>
                <?php foreach($data as $key=>$value) {?>
                <li class="liComm" position="<?=$value['community_longitudex']?>,<?=$value['community_latitudey']?>">
                    <a href="javascript:;" class="custom_map" mapid="<?=$value['id']?>"
                       map_value_x="<?=$value['community_longitudex']?>"
                       map_value_y="<?=$value['community_latitudey']?>"><?=$value['community_name']?></a></li>
                <?php }?>
            </ul>
        </div>
        <div class="col-md-12" id="map" style="width:82rem;height:50rem;">
        </div>
        
        <div class="table-responsive">
            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid"><div class="row"><div class="col-sm-6"><div class="dataTables_length" id="dataTables-example_length"><label>每页显示  <select name="dataTables-example_length" aria-controls="dataTables-example" class="form-control input-sm"><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> 条</label></div></div><div class="col-sm-6"><div id="dataTables-example_filter" class="dataTables_filter"><label>搜索：<input type="search" class="form-control input-sm" aria-controls="dataTables-example"></label></div></div></div><table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info" style="width: 1529px;">
                <thead>
                <tr role="row">
                    <th width="10%" rowspan="1" colspan="1" style="width: 152px;"><input type="checkbox" id="checkAll"/>序号</th>
                    <th width="20%" rowspan="1" colspan="1" style="width: 322px;">广告名称</th>
                    <th width="35%" rowspan="1" colspan="1" style="width: 577px;">楼盘名称</th>
                    <th width="10%" rowspan="1" colspan="1" style="width: 152px;">公司名称</th>
                    <th width="10%" rowspan="1" colspan="1" style="width: 152px;">状态</th>
                </tr>
                </thead>
                <tbody id="tableCon">
                </tbody>
            </table>
        </div>
    </div>
         <div>
                <!--div class="form-group">
                    <label class="control-label">修改状态：</label>
                    <select class="form-control" style="width:40%;float:right;margin-right:50%;" name="adv_install_status">
                        <option value="-1">不修改</option>
                        <option value="0">未安装</option>
                        <option value="1">待维修(损坏)</option>
                        <option value="2">正常使用</option>
                    </select>
                </div-->
                
                <div class="form-group">
                    <label class="control-label">画面状态</label>
                    <select class="form-control" style="width:40%;float:right;margin-right:50%;" name="adv_pic_status">
                        <option value="-1">不修改</option>
                        <option value="0">预定</option>
                        <option value="1">待上刊</option>
                        <option value="2">已上刊</option>
                        <option value="3">待下刊</option>
                        <option value="4">已下刊</option>
                    </select>
                </div>
                
                <div id="staff">
                    <label class="control-label">人员分配：</label>
                    <?php foreach($staff as $key=>$value) {
                            echo '<span style = " margin:0 10px;" ><input type = "checkbox" name="staff" value = "'.$value->id.'" />'.$value->staff_name.'</span>';
                        }
                    ?>
                </div>
                <div>
                    <input type="hidden" id="typeValue" value="pic" />
                    <input type="button" id="editStatus" class="btn btn-info" value="修改" />
                </div>
            </div>
    <!-- /. ROW  -->
</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Ab2CQa603kmx8tYXETWEEOjozKgdUXVL"></script>
<script src="/assets/adminTemplate/js/common.js"></script>
<!-- /. PAGE INNER  -->
<script type="text/javascript">
    
    $("#searchComm").click(function(){
        var searchValue = $("input[name=search]").val();
        $(".mapul>li").each(function() {
            if ($(this).hasClass("liComm")) {
                var lihtml = $(this).find("a").html();
                if (lihtml.indexOf(searchValue) < 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            }
        });
    });
    var data = <?=$datajson?>;
    var map = new BMap.Map("map");                    // 创建Map实例
    map.centerAndZoom("南京", 15);                    // 初始化地图,设置中心点坐标和地图级别
    map.enableScrollWheelZoom(true);

    $(".custom_map").click(function(){
        $map_x = $(this).attr("map_value_x");
        $map_y = $(this).attr("map_value_y");
        map.panTo(new BMap.Point($map_x,$map_y));
        var allOverlay = map.getOverlays();
        for (var i = 1; i < allOverlay.length; i++){
            if(allOverlay[i]._id == $(this).attr("mapid")) {
                allOverlay[i]._div.style.color = "#EAFF00";
                allOverlay[i]._div.style.zIndex = 1000;
            } else {
                if(allOverlay[i]._div != undefined) {
                    allOverlay[i]._div.style.color = "white";
                    allOverlay[i]._div.style.zIndex = 1;
                }
            }
        }
        /*var marker = new BMap.Marker(new BMap.Point($map_x,$map_y));
        map.addOverlay(marker);
        marker.setAnimation(BMAP_ANIMATION_BOUNCE);*/
    });

    // 复杂的自定义覆盖物
    function ComplexCustomOverlay(point, text, mouseoverText, id){
        this._point = point;
        this._text = text;
        this._id = id;
        this._overText = mouseoverText;
    }
    ComplexCustomOverlay.prototype = new BMap.Overlay();
    ComplexCustomOverlay.prototype.initialize = function(map){
        this._map = map;
        var div = this._div = document.createElement("div");
        div.style.position = "absolute";
        div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
        div.style.backgroundColor = "#EE5D5B";
        div.style.border = "1px solid #BC3B3A";
        div.style.color = "white";
        //div.style.width = "80px";
        div.style.height = "24px";
        div.style.padding = "3px";
        div.style.lineHeight = "17px";
        div.style.whiteSpace = "nowrap";
        div.style.MozUserSelect = "none";
        div.style.fontSize = "12px";
        div.style.textAlign = "center";
        div.id = this._id;
        var span = this._span = document.createElement("span");
        div.appendChild(span);
        span.appendChild(document.createTextNode(this._text));
        var that = this;

        var arrow = this._arrow = document.createElement("div");
        arrow.style.background = "url(http://map.baidu.com/fwmap/upload/r/map/fwmap/static/house/images/label.png) no-repeat";
        arrow.style.position = "absolute";
        arrow.style.width = "40px";
        arrow.style.height = "10px";
        arrow.style.top = "22px";
        arrow.style.left = "10px";
        arrow.style.overflow = "hidden";
        div.appendChild(arrow);

        div.onmouseover = function(){
            this.style.backgroundColor = "#6BADCA";
            this.style.borderColor = "#6BADCA";
            this.getElementsByTagName("span")[0].innerHTML = "广告数: {count}";
            arrow.style.backgroundPosition = "0px -20px";
        }
        var pointData = this._point;
        div.onclick = function(){
            var infoWindow = new BMap.InfoWindow("<p>便写点东西</p><p>呵呵呵</p>");    // 创建信息窗口对象
            console.log(pointData);
            map.openInfoWindow(infoWindow,pointData);
        }

        div.onmouseout = function(){
            this.style.backgroundColor = "#EE5D5B";
            this.style.borderColor = "#BC3B3A";
            this.getElementsByTagName("span")[0].innerHTML = that._text;
            arrow.style.backgroundPosition = "0px 0px";
        }

        map.getPanes().labelPane.appendChild(div);

        return div;
    }
    ComplexCustomOverlay.prototype.draw = function(){
        var map = this._map;
        var pixel = map.pointToOverlayPixel(this._point);
        this._div.style.left = pixel.x - parseInt(this._arrow.style.left) + "px";
        this._div.style.top  = pixel.y - 30 + "px";
    }

    for(var i in data) {
        var point = new BMap.Point(data[i]['community_longitudex'], data[i]['community_latitudey']);
        var myCompOverlay = new ComplexCustomOverlay(point, data[i]['community_name'], "", data[i]['id']);
        
        
                         //开启信息窗口
        map.addOverlay(myCompOverlay);
    }

    var circle = null;
    map.addEventListener("click", function(e){
        $("#position").val(e.point.lng + "," + e.point.lat);
        map.removeOverlay(circle);
        var mpoint = new BMap.Point(e.point.lng,e.point.lat);
        circle = new BMap.Circle(mpoint,$("input[name=mapfield]").val() * 1000,{fillColor:"blue", strokeWeight: 1 ,fillOpacity: 0.3, strokeOpacity: 0.3});
        map.addOverlay(circle);
        //ajax 处理 园内 广告机列表
        getAdvList(e.point.lng,e.point.lat,$("input[name=mapfield]").val());
    });
    var status_str = ['新增','未使用','已使用'];
    function getAdvList(lng,lat,length){
        //console.log(lng+","+lat);
        $.ajax({
            "type": "POST",
            "contentType": "application/x-www-form-urlencoded",
            "url": "/admin/community/ajaxdetail",
            "data" : {'lng' : lng,'lat':lat,'length':length},
            "dataType": "json",
            "success": function (data) {
                //console.log(data);
                var html = '';
                for(var key in data){
                    var item = data[key];
                    html += '<tr><td><input type="checkbox" name="adv_id" value="'+item.id+'" />'+(parseInt(key)+1)+'</td><td>'+item.adv_name+'</td><td>'+item.community_name+'</td><td>'+item.company_name+'</td><td>'+status_str[item.adv_use_status]+'</td></tr>'; 
                }
                document.getElementById('tableCon').innerHTML = html;
            }
        });
    }
</script>
<style type="text/css">
.mapul li {
    list-style: none;
    margin: 0.2rem;
}
</style>