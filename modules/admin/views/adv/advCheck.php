<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">广告管理/ <small>广告位审核信息</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    待审核列表
                </div>
                <div class="panel-heading">
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
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="just_see" id="just_see"> 浏览模式
                            </label>
                        </div>
                        <button type="button" id="searchBtn" class="btn btn-default">搜索</button>
                  </form>
                </div>
                
                <div class="panel-body">
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="5%">序号</th>
                                <th width="15%">广告名称</th>
                                <th width="15%">楼盘名称</th>
                                <th width="15%">公司名称</th>
                                <th width="10%">安装状态</th>
                                <th width="10%">显示状态</th>
                                <th width="15%">审核状态</th>
                                <th width="25%">编辑</th>
                            </tr>
                            </thead>
                            <tbody id="table_content">
                            </tbody>
                        </table>
                        <div class="dataTables_paginate paging_simple_numbers" id="fenyeHtml">

                        </div>
                    </div>
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

var install_status = ['未安装','待维修','正常使用','安装中','维修中'];
var pic_status = ['预定','待上刊','已上刊','待下刊','已下刊'];
var adv_status = ['无需审核','待审核(新增)','待审核(修改)','待审核(删除)','驳回(新增)','驳回(修改)','驳回(删除)','审核通过'];

var status_search = {};
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
        adv_status:"1,2,3,4,5,6",       //所有待审核状态
        name: getIdVlaue("community_name"),
        adv_no: getIdVlaue("adv_no"),
        postion: getIdVlaue("community_position"),
        com_no:getIdVlaue("community_no"),
        page:page
    }
    
    data = Object.assign(data, status_search);
    jsonPost(data,buildHtml);
    console.log(data);
}

function buildHtml(data){
    console.log(data);
    var html = '';
    for(var key in data.list_data){
        var item = data.list_data[key];

        var control_html = "";
        if(data.range == "mine")
            control_html= '<div class="advEdit"><a href="/admin/adv/details?id='+item.id+'">详情</a> | <a href="/admin/adv/edit?id='+item.id+'">编辑</a> | <a href="javascript:;" adv_id="'+item.id+'" class="advDelete">删除</a></div>';
        html += '<tr><td>'+(parseInt(key)+1)+'</td><td>'+item.adv_name+'</td><td>'+item.community_name+'</td><td>'+item.company_name+'</td><td>'+install_status[item.adv_install_status]+'</td><td>'+pic_status[item.adv_pic_status]+'</td><td>'+adv_status[item.adv_status]+'</td><td>'+control_html+'</td></tr>';
    }
    document.getElementById("table_content").innerHTML = html;
    buildPage(data.page_data);

    $('.showPeople').click(function(){
        var adv_staff_id = $(this).attr("adv_staff_id");
        $.ajax({
            "type": "GET",
            "contentType": "application/json",
            "url": "/admin/adv/showpeople",
            "dataType": "json",
            "data": {id: adv_staff_id}, //以json格式传递
            "success": function (data) {
                alert(data);
            }
        });
    });
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
    
    $("#fenyeHtml").on('click','a',function(e){
        var a = e||window.event;
        a.preventDefault();
        a.stopPropagation();
        var page = $(this).attr("value");
        if(page > 0){
            getList(page);
        }
        
    });

    //删除
    $('.advDelete').click(function(){
        adv_id =$(this).attr("adv_id");
        if(confirm("确定要删除该广告位信息吗？")) {
            $.ajax({
                "type": "GET",
                "contentType": "application/json",
                "url": "/admin/adv/deleteajax",
                "dataType": "json",
                "data": {id: adv_id}, //以json格式传递
                "success": function (data) {
                    console.log(data);
                    window.location.reload();
                }
            });
        }
    });

});
</script>