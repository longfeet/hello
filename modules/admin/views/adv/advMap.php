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
                </tr>
                </thead>
                <tbody id="tableCon">
                </tbody>
            </table>
        </div>
    </div>
         <div>
                <div class="form-group">
                    <label class="control-label">修改状态：</label>
                    <select class="form-control" style="width:40%;float:right;margin-right:50%;" name="adv_install_status">
                        <option value="-1">不修改</option>
                        <option value="0">未安装</option>
                        <option value="1">待维修(损坏)</option>
                        <option value="2">正常使用</option>
                    </select>
                </div>
                
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
                
                <input type="button" id="editStatus" class="btn btn-info" value="修改" />
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

//        div.onclick = function(){
//            window.location.href = "/admin/community/edit?id=" + $(this).attr("id");
//        }

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
        //ajax 处理 园内 广告机列表
        getAdvList(e.point.lng,e.point.lat,$("input[name=mapfield]").val());
    });
    
    function getAdvList(lng,lat,length){
        console.log(lng+","+lat);
        $.ajax({
            "type": "POST",
            "contentType": "application/x-www-form-urlencoded",
            "url": "/admin/community/ajaxdetail",
            "data" : {'lng' : lng,'lat':lat,'length':length},
            "dataType": "json",
            "success": function (data) {
                console.log(data);
                var html = '';
                for(var key in data){
                    var item = data[key];
                    html += '<tr><td><input type="checkbox" name="adv_id" value="'+item.id+'" />'+(parseInt(key)+1)+'</td><td>'+item.adv_name+'</td><td>'+item.community_cbd+'</td><td>'+item.company_name+'</td></tr>'; 
                }
                document.getElementById('tableCon').innerHTML = html;
            }
        });
    }
    
    $("#checkAll").click(function(){
        
        for(var key in $("input[name='adv_id']")){
            $("input[name='adv_id']")[key].checked = this.checked;
        }
    })
    
    $(document).on('click', "input[name='adv_id']", function() {
        var status = true;
        for(var i=0;i< $("input[name='adv_id']").length;i++){
            if(!$("input[name='adv_id']")[i].checked){
                status = false;
            }
        }
        console.log(status);
        $("#checkAll").checked = status;
    });
    
    function getCheckId(){
        var arr = [];
        for(var i=0;i< $("input[name='adv_id']").length;i++){
            if($("input[name='adv_id']")[i].checked){
                arr.push($("input[name='adv_id']")[i].value); 
            }
        }
        return arr;
    }
    
    $("#editStatus").click(function(){
        var ids = getCheckId();
        if(ids.length < 1){
            alert("请选择至少一条记录！");
            return false;
        }
        //读取修改状态
        var adv_install_status = $("select[name='adv_install_status']").val();
        var adv_pic_status = $("select[name='adv_pic_status']").val();
        if(adv_install_status == -1 && adv_pic_status == -1 ){
            alert("无修改！");
            return false;
        }
        if(confirm("确定要修改记录状态吗？")){
            $.ajax( {
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/adv/ajaxeditstatus",
                "dataType": "json",
                "data": {ids:ids,adv_install_status:adv_install_status,adv_pic_status:adv_pic_status}, //以json格式传递
                "success": function(data) {
                    if(data > 0){
                        alert(data+"条记录状态修改成功！");
                        //刷新页面  目前无法在列表数据中看出状态 预留
                        //window.location.reload();
                    }else{
                        alert("记录修改失败！");
                    }
                }
            });
        }
    })
</script>
<style type="text/css">
.mapul li {
    list-style: none;
    margin: 0.2rem;
}
</style>