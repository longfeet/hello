<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">销售管理/
                <small>广告位销售</small>
            </h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form class="form-inline" role="form">
                        <div class="form-group">
                            <input type="email" class="form-control" id="community_name" placeholder="楼盘名称">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="community_category" placeholder="楼盘性质">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="community_city" placeholder="所在城市">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="community_area" placeholder="所属区域">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="community_cbd" placeholder="所在商圈">
                        </div>
                        <br/><br/>
                        <div class="form-group">
                            <select name="adv_property" id="adv_property" class="form-control">
                                <option value="-1">广告位类型</option>
                                <option value="0">电梯</option>
                                <option value="1">道闸</option>
                                <option value="2">道杆</option>
                                <option value="3">灯箱</option>
                                <option value="4">行人门禁</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="adv_rest_day" id="adv_rest_day" class="form-control">
                                <option value="-1">空刊时间</option>
                                <option value="1">1-3个月</option>
                                <option value="2">3-6个月</option>
                                <option value="3">半年</option>
                            </select>
                        </div>
                        <button type="button" id="searchBtn" class="btn btn-default">搜索</button>
                    </form>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"/>序号</th>
                                <th>楼盘名称</th>
                                <th>广告位编号</th>
                                <th>广告位类型</th>
                                <th>广告位位置</th>
                                <th>当前状态</th>
                                <th>使用状态</th>
                                <th>年上刊率</th>
                                <th>空刊时间</th>
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
    <div class="row">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">客户公司：</div>
        <div class="col-md-9">
            <select class="form-control" name="sales_company">
                <option value="0">==请选择==</option>
                <?php foreach ($customerList as $customer) { ?>
                    <option
                        value="<?= $customer->id ?>" <?php echo $customer_id == $customer->id ? "selected=\"selected\"" : "" ?> ><?= $customer->customer_company ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">客户联系人：</div>
        <div class="col-md-9"><input class="form-control" type="text" name="sales_customer"
                                     value="<?= $customer_name ?>"/></div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">开始时间：</div>
        <div class="col-md-9"><input type="text" class="form-control" name="sales_starttime" id="sales_starttime"/>
        </div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">到期时间：</div>
        <div class="col-md-9"><input type="text" class="form-control" name="sales_endtime" id="sales_endtime"/></div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">销售人员：</div>
        <div class="col-md-9"><input type="text" class="form-control" name="sales_person"
                                     value="<?= $staff->staff_name ?>"/></div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">销售状态：</div>
        <div class="col-md-9">
            <select class="form-control" name="sales_status">
                <option value="0">销售</option>
                <option value="1">赠送</option>
                <option value="2">置换</option>
            </select>
        </div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">备注：</div>
        <div class="col-md-9"><textarea class="form-control" rows="3" name="sales_note"></textarea></div>
    </div>
    <div class="row" style="padding-top: 5px;">
        <div class="col-md-1" style="width:120px;height: 35px;line-height:35px;">
            <input type="button" id="saleSubmit" class="btn btn-info" value="提交"/>
        </div>
    </div>

</div>
<!-- /. PAGE INNER  -->

<script src="/assets/artDialog/dist/dialog.js"></script>
<script src="/assets/datepicker/jquery.ui.datepicker.js"></script>
<script src="/assets/datepicker/jquery-ui.js"></script>
<link rel="stylesheet" href="/css/jquery-ui.css">
<link href="/assets/artDialog/css/ui-dialog.css" rel="stylesheet"/>

<script src="/assets/adminTemplate/js/common.js"></script>
<style type="text/css">
    .bgRed {
        background-color: red;
    }
</style>
<script type="text/javascript">
    var install_status = ['未安装', '待维修', '正常使用', '安装中', '维修中'];
    var use_status = ['新增', '未使用', '已使用'];
    var adv_property = ['电梯广告', '道闸广告', '道杆广告', '灯箱', '行人门禁'];

    var status_search = {};
    function getIdVlaue(name) {
        return document.getElementById(name).value;
    }

    function jsonPost(data, cb) {
        $.ajax({
            "type": "POST",
            "contentType": "application/x-www-form-urlencoded",
            "url": "/admin/sale/ajaxmamger",
            "dataType": "json",
            "async": false,      //ajax异步
            "data": data, //以json格式传递
            "success": cb
        });
    }

    function getList(page) {
        document.getElementById("table_content").innerHTML = '';
        page = page || 1;
        var data = {
            community_name: getIdVlaue("community_name"),
            community_category: getIdVlaue("community_category"),
            community_city: getIdVlaue("community_city"),
            community_area: getIdVlaue("community_area"),
            community_cbd: getIdVlaue("community_cbd"),
            adv_property: getIdVlaue("adv_property"),
            adv_rest_day: getIdVlaue("adv_rest_day"),
            page: page
        }

        for (var p in status_search){
            if(status_search.hasOwnProperty(p) && (!data.hasOwnProperty(p) ))
                data[p]=status_search[p];
        }
        //data = Object.assign(data, status_search);

        jsonPost(data, buildHtml);
        console.log(data);
    }

    function buildHtml(data) {
        console.log(data);
        var html = '';
        for (var key in data.list_data) {
            var item = data.list_data[key];

            //加工空看时间
            var rest_time = "";
            if (item.adv_rest_day < 91)
                rest_time = "1-3个月";
            else if (item.adv_rest_day > 90 && item.adv_rest_day < 181)
                rest_time = "3-6个月";
            else
                rest_time = "半年以上";

            html += '<tr><td><input type="checkbox" value="' + item.id + '" name="adv_id" />' + (parseInt(key) + 1) + '</td><td>' + item.community_name + '</td><td>' + item.adv_no + '</td><td>' + adv_property[item.adv_property] + '</td><td>' + item.adv_position + '</td><td>' + install_status[item.adv_install_status] + '</td><td>' + use_status[item.adv_use_status] + '</td><td>' + item.adv_rest_rate + '</td><td>' + rest_time + '</td></tr>';
        }
        document.getElementById("table_content").innerHTML = html;
        buildPage(data.page_data);
    }

    document.getElementById("searchBtn").addEventListener('click', function () {
        getList();
    });

    function buildPage(page_data) {
        var html = ' <ul class="pagination"> ';
        var num_html = '';
        var prev_html = '<li class="paginate_button previous "><a value="' + (page_data.page - 1) + '">前一页</a></li>';
        var next_html = '<li class="paginate_button next"><a value="' + (page_data.page + 1) + '">后一页</a></li>';
        for (var i = 1; i <= page_data.allPage; i++) {
            var active = '';
            if (i == page_data.page) {
                active = 'active';
            }
            num_html += '<li class="paginate_button ' + active + '" ><a value="' + i + '">' + i + '</a></li>';
        }
        if (page_data.page == 1) {
            prev_html = '<li class="paginate_button previous disabled"><a value="-1">前一页</a></li>'
        }
        if (page_data.page == page_data.allPage) {
            next_html = '<li class="paginate_button next disabled"><a value="-1">后一页</a></li>'
        }
        document.getElementById("fenyeHtml").innerHTML = html + prev_html + num_html + next_html + '</ul>';
    }

    $(window).ready(function () {
        getList();

        $('#sales_starttime').datepicker({
            dateFormat: "yy-mm-dd",
            monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
            changeMonth: true,
            changeYear: true
        });
        $('#sales_endtime').datepicker({
            dateFormat: "yy-mm-dd",
            monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
            changeMonth: true,
            changeYear: true
        });

        //点击td选中checkbox
        $("#dataTables-example").on("click", "tbody tr", function () {
            $(this).toggleClass("bgRed");
            if ($(this).hasClass("bgRed")) {
                //if ($(this).children().first().children().attr("checked")=="checked") {
                $(this).children().first().children().prop("checked", true);
            } else {
                $(this).children().first().children().prop("checked", false);
            }
        });

        $("#fenyeHtml").on('click', 'a', function (e) {
            var a = e || window.event;
            a.preventDefault();
            a.stopPropagation();
            var page = $(this).attr("value");
            if (page > 0) {
                getList(page);
            }
        });

        //客户公司联动客户联系人
        $('select[name=sales_company]').change(function () {
            var customer_id = $('select[name=sales_company] option:selected').val();
            if (customer_id != 0) {
                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/sale/getcustomerinfo?customer_id=" + customer_id,
                    "dataType": "json",
                    "success": function (data) {
                        $("input[name='sales_customer']").val(data[0].customer_contact);
                    }
                });
            }
            else {
                $("input[name='sales_customer']").val("");
            }
        })

        //提交
        $("#saleSubmit").click(function () {
            var ids = getCheckValue('adv_id');
            if (ids.length < 1) {
                alert("请选择至少一条记录！");
                return false;
            }

            //读取销售信息
            var sales_company = $('select[name=sales_company]').val();
            var sales_customer = $('input[name=sales_customer]').val();
            var sales_starttime = $('input[name=sales_starttime]').val();
            var sales_endtime = $('input[name=sales_endtime]').val();
            var sales_person = $('input[name=sales_person]').val();
            var sales_status = $('select[name=sales_status]').val();
            var sales_note = $('textarea[name=sales_note]').val();

            //数据验证;
            if (sales_company == "0") {
                alert("请选择客户公司");
            } else if (sales_starttime == "") {
                alert("请选开始时间");
            } else if (sales_endtime == "") {
                alert("请选到期时间");
            }
            else {
                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/sale/dosale",
                    "dataType": "json",
                    "data": {
                        ids: ids,
                        sales_company: sales_company,
                        sales_customer: sales_customer,
                        sales_starttime: sales_starttime,
                        sales_endtime: sales_endtime,
                        sales_person: sales_person,
                        sales_status: sales_status,
                        sales_note: sales_note
                    }, //以json格式传递
                    "success": function (data) {
                        if (data > 0) {
                            window.location.reload();
                        } else {
                            alert("数据录入失败！");
                        }
                    }
                });
            }
        })

    });
</script>