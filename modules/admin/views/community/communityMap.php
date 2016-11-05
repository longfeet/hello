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
    </div>
    <!-- /. ROW  -->
</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Ab2CQa603kmx8tYXETWEEOjozKgdUXVL"></script>
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

        div.onclick = function(){
            window.location.href = "/admin/community/edit?id=" + $(this).attr("id");
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
        map.addOverlay(myCompOverlay);
    }

    var circle = null;
    map.addEventListener("click", function(e){
        $("#position").val(e.point.lng + "," + e.point.lat);
        map.removeOverlay(circle);
        var mpoint = new BMap.Point(e.point.lng,e.point.lat);
        circle = new BMap.Circle(mpoint,$("input[name=mapfield]").val() * 1000,{fillColor:"blue", strokeWeight: 1 ,fillOpacity: 0.3, strokeOpacity: 0.3});
        map.addOverlay(circle);
    });
</script>
<style type="text/css">
.mapul li {
    list-style: none;
    margin: 0.2rem;
}
</style>