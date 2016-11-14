<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">广告管理/ <small>广告位列表</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    广告位列表
                    <!--a href="javascript:;" class="btn btn-info" id="showMap" style="float:right;margin-top:-0.5rem;">楼盘地图</a-->
                    <a href="javascript:;" class="btn btn-info" id="addAdv" style="float:right;margin-top:-0.5rem;margin-right:1rem;">添加广告位</a>
                    <a href="javascript:;" class="btn btn-info" id="addExcel" style="float:right;margin-top:-0.5rem;margin-right:1rem;">EXCEL上传</a>
                </div>
                <div class="panel-body">
                    <form class="form-inline" role="form">
                        <div class="form-group">
                          <input type="email" class="form-control" id="community_name" placeholder="请输入楼盘名称">
                        </div>
                        <div class="form-group">
                          <input type="email" class="form-control" id="community_position" placeholder="请输入地址">
                        </div>
                        <div class="form-group">
                          <input type="email" class="form-control" id="community_no" placeholder="请输入楼盘编号">
                        </div>
                        <div class="form-group">
                          <input type="email" class="form-control" id="adv_no" placeholder="请输入广告位编号">
                        </div>
                        <button type="button" id="searchBtn" class="btn btn-default">搜索</button>
                  </form>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="5%"><input type="checkbox" id="checkAll"/>序号</th>
                                <th width="25%">广告名称</th>
                                <th width="25%">楼盘名称</th>
                                <th width="15%">公司名称</th>
                                <th width="20%">编辑</th>
                            </tr>
                            </thead>
                            <tbody id="table_content">
                            </tbody>
                        </table>
                        <div class="dataTables_paginate paging_simple_numbers" id="fenyeHtml">
<!--                            <ul class="pagination">
                                <li class="paginate_button previous disabled">
                                    <a href="#">前一页</a></li>
                                <li class="paginate_button active" ><a href="#">1</a></li>
                                <li class="paginate_button "><a href="#">2</a></li>
                                <li class="paginate_button "><a href="#">3</a></li>
                                <li class="paginate_button "><a href="#">4</a></li>
                                <li class="paginate_button next">
                                    <a href="#">后一页</a></li>
                            </ul>-->
                        </div>
                    </div>
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
                
                <!--div class="form-group">
                    <label class="control-label">画面状态</label>
                    <select class="form-control" style="width:40%;float:right;margin-right:50%;" name="adv_pic_status">
                        <option value="-1">不修改</option>
                        <option value="0">预定</option>
                        <option value="1">待上刊</option>
                        <option value="2">已上刊</option>
                        <option value="3">待下刊</option>
                        <option value="4">已下刊</option>
                    </select>
                </div-->
                
                <div id="staff">
                    <label class="control-label">人员分配：</label>
                    <?php foreach($staff as $key=>$value) {
                            echo '<span style = " margin:0 10px;" ><input type = "checkbox" name="staff" value = "'.$value->id.'" />'.$value->staff_name.'</span>';
                        }
                    ?>
                </div>
                <div>
                    <input type="hidden" id="typeValue" value="install" />
                    <input type="button" id="editStatus" class="btn btn-info" value="修改" />
                </div>
                
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <!-- /. ROW  -->
</div>
<!-- /. PAGE INNER  -->
<!-- JsTree Styles-->
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default/style.min.css">
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default-dark/style.min.css">
<!-- JsTree Js-->
<script src="/assets/adminTemplate/js/jstree/dist/jstree.min.js"></script>
<script src="/assets/adminTemplate/js/common.js"></script>
<script type="text/javascript">
var search = null;


function getIdVlaue(name){
    return document.getElementById(name).value;
}

function jsonPost(data,cb){
    $.ajax( {
        "type": "POST",
        "contentType": "application/x-www-form-urlencoded",
        "url": "/admin/adv/ajaxmamger",
        "dataType": "json",
        "data": data, //以json格式传递
        "success": cb
    });
}

function getList(page){
    document.getElementById("table_content").innerHTML = '';
    page = page || 1;
    var data = {
        name: getIdVlaue("community_name"),
        adv_no: getIdVlaue("adv_no"),
        postion: getIdVlaue("community_position"),
        com_no:getIdVlaue("community_no"),
        page:page
    }
    jsonPost(data,buildHtml);
    console.log(data);
}

function buildHtml(data){
    console.log(data);
    var html = '';
    for(var key in data.list_data){
        var item = data.list_data[key];
        var control_html = '<a href="/admin/adv/details?id='+item.id+'">详情</a> | <a href="/admin/adv/edit?id='+item.id+'">编辑</a> | <a href="/admin/adv/flow?id='+item.id+'">流程</a>';
        html += '<tr><td><input type="checkbox" value="'+item.id+'" name="adv_id" />'+(parseInt(key)+1)+'</td><td>'+item.adv_name+'</td><td>'+item.community_name+'</td><td>'+item.company_name+'</td><td>'+control_html+'</td></tr>';
    }
    document.getElementById("table_content").innerHTML = html;
    buildPage(data.page_data);
}

document.getElementById("searchBtn").addEventListener('click',function(){
    getList();
});

function buildPage(page_data){
    var html = ' <ul class="pagination"> ';
    var num_html = '';
    var prev_html = '<li class="paginate_button previous "><a value="'+(page_data.page - 1)+'">前一页</a></li>';
    var next_html = '<li class="paginate_button next"><a value="'+(page_data.page + 1)+'">后一页</a></li>';
    for(var i = 1 ; i <= page_data.allPage; i++){
        var active = '';
        if(i == page_data.page){
            active = 'active';
        }
        num_html += '<li class="paginate_button '+active+'" ><a value="'+i+'">'+i+'</a></li>';
    }
    if(page_data.page == 1){
        prev_html = '<li class="paginate_button previous disabled"><a value="-1">前一页</a></li>'
    }
    if(page_data.page == page_data.allPage){
        next_html = '<li class="paginate_button next disabled"><a value="-1">后一页</a></li>'
    }
    document.getElementById("fenyeHtml").innerHTML = html+prev_html+num_html+next_html+'</ul>';
}



$(window).ready(function(){
    getList();
    $("#addExcel").click(function(){
        window.location.href = "/admin/adv/addexcel";
    });

    $("#addAdv").click(function(){
        window.location.href = "/admin/adv/add";
    });
    
    $("#fenyeHtml").on('click','a',function(){
        event.preventDefault();
        event.stopPropagation();
        var page = $(this).attr("value");
        if(page > 0){
            getList(page);
        }
        
    })
    
   
    
//    var table = $('#dataTables-example').dataTable({
//            "ordering" : false,
//            "language": {
//                "url": "/assets/adminTemplate/js/dataTables/zh-cn.txt"
//            },
//            "aLengthMenu" : [10,20,50,100],
//            "serverSide": true,
//            "fnServerData": function(sSource, aoData, fnCallback) {
//                $.ajax( {
//                    "type": "GET",
//                    "contentType": "application/json",
//                    "url": "<?=$jsonurl?>",
//                    "dataType": "json",
//                    "data": aoData, //以json格式传递
//                    "success": function(data) {
//                        fnCallback(data);
//                        $('.roleDetails').click(function(){
//                            window.location.href = "/admin/adv/details?id=" + $(this).attr("role_id");
//                        });
//                        $('.roleEdit').click(function(){
//                            window.location.href = "/admin/adv/edit?id=" + $(this).attr("role_id");
//                        });
//                        $('.advBind').click(function(){
//                            window.location.href = "/admin/adv/flow?id=" + $(this).attr("adv_id")
//                        });
//                        if(search == null) {
//                            search =  $('input[type=search]');
//                            search.before("(广告位名称)&nbsp;");
//                        }
//                    }
//                });
//            },
//            'columns' : <?=$columns?>
//        }
//    ).api(); 
});
</script>