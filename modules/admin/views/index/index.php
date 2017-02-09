<div id="page-inner">


    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                控制台/<small> 应用信息</small>
            </h1>
        </div>
    </div>
    <!-- /. ROW  -->

    <div class="row">
        <?php if(in_array("/admin/community/manager", $list)){?>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-brown">
                <div class="picCommunity">
                </div>
                <div class="panel-footer back-footer-brown" style="background-color:#1DB8D1;">
                    <a href="/admin/community/manager" style="color: #FFFFFF;text-decoration:none;">小区管理</a>
                </div>
            </div>
        </div>
        <?php
        }
        if(in_array("/admin/adv/manager", $list)){
        ?>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-brown">
                <div class="picAdv">
                </div>
                <div class="panel-footer back-footer-brown" style="background-color:#DFB48E;">
                    <a href="/admin/adv/manager" style="color: #FFFFFF;text-decoration:none;">广告位管理</a>
                </div>
            </div>
        </div>
        <?php
        }
        if(in_array("/admin/adv/install", $list)){
        ?>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-brown">
                <div class="picInstall">
                </div>
                <div class="panel-footer back-footer-brown" style="background-color:#FDAFD9;">
                    <a href="/admin/adv/install" style="color: #FFFFFF;text-decoration:none;">安装管理</a>
                </div>
            </div>
        </div>
        <?php
        }
        if(in_array("/admin/adv/repair", $list)){
        ?>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-brown">
                <div class="picRepair">
                </div>
                <div class="panel-footer back-footer-brown" style="background-color:#7595FE;">
                    <a href="/admin/adv/repair" style="color: #FFFFFF;text-decoration:none;">维修管理</a>
                </div>
            </div>
        </div>
        <?php
        }
        if(in_array("/admin/adv/on", $list)){
        ?>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-brown">
                <div class="picOn">
                </div>
                <div class="panel-footer back-footer-brown" style="background-color:#56C390;">
                    <a href="/admin/adv/on" style="color: #FFFFFF;text-decoration:none;">上刊管理</a>
                </div>
            </div>
        </div>
        <?php
        }
        if(in_array("/admin/adv/down", $list)){
        ?>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-brown">
                <div class="picDown">
                </div>
                <div class="panel-footer back-footer-brown" style="background-color:#9A9A9A;">
                    <a href="/admin/adv/down" style="color: #FFFFFF;text-decoration:none;">下刊管理</a>
                </div>
            </div>
        </div>
        <?php
        }
        if(in_array("/admin/model/manager", $list)){
        ?>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-brown">
                <div class="picModel">
                </div>
                <div class="panel-footer back-footer-brown" style="background-color:#E09226;">
                    <a href="/admin/model/manager" style="color: #FFFFFF;text-decoration:none;">设备管理</a>
                </div>
            </div>
        </div>
        <?php
        }
        if(in_array("/admin/sale/salemanager", $list)){
        ?>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-brown">
                <div class="picSale">
                </div>
                <div class="panel-footer back-footer-brown" style="background-color:#DF6DB7;">
                    <a href="/admin/sale/salemanager" style="color: #FFFFFF;text-decoration:none;">销售管理</a>
                </div>
            </div>
        </div>
        <?php
        }
        if(in_array("/admin/sale/manager", $list)){
        ?>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-brown">
                <div class="picCustomer">
                </div>
                <div class="panel-footer back-footer-brown" style="background-color:#D82E2E;">
                    <a href="/admin/customer/manager" style="color: #FFFFFF;text-decoration:none;">客户管理</a>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-brown">
                <div class="picMessage">
                </div>
                <div class="panel-footer back-footer-brown" style="background-color:#EC681F;">
                    <a href="/admin/message/messagemanager" style="color: #FFFFFF;text-decoration:none;">消息提醒</a>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /. PAGE INNER  -->
