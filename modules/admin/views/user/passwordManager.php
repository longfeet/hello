<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">账户管理/ <small>修改密码</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <form role="form" id="pwdForm" method="post" action="">
                        <div class="form-group">
                            <label class="control-label">用户名</label>
                            <input type="text" name="staffName" class="form-control" placeholder="Readonly" value="<?=$staff->staff_name ?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">当前密码</label>
                            <input type="password" name="pwd" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">新密码</label>
                            <input type="password" name="newPwd" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">确认密码</label>
                            <input type="password" name="confirmPwd" class="form-control"/>
                        </div>
                        <div id="pwdInfo" style="display:none;margin-top:10px;">
                            <label></label>
                        </div>
                        <div class="form-group1">
                            <input type="text" name="staffID" style="display:none" class="form-control" value="<?=$staff->id ?>"/>
                            <label class="control-label"></label>
                            <a href="javascript:;" class="btn btn-info" id="addPwd" style="float:right;width:5rem;text-align:center;margin-right:50%;">提&nbsp;交</a>
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
</style>

<script type="text/javascript">
    $(document).ready(function () {
        //提示色移除
        $('input[name=pwd]').keydown(function(){
            if($(this).hasClass('alert-danger')) {
                $('#pwdInfo').hide();
                $('input[name=pwd]').removeClass('alert-danger');
            }
        });
        $('input[name=newPwd]').keydown(function(){
            if($(this).hasClass('alert-danger')) {
                $('#pwdInfo').hide();
                $('input[name=newPwd]').removeClass('alert-danger');
                $('input[name=confirmPwd]').removeClass('alert-danger');
            }
        });
        $('input[name=confirmPwd]').keydown(function(){
            if($(this).hasClass('alert-danger')) {
                $('#pwdInfo').hide();
                $('input[name=newPwd]').removeClass('alert-danger');
                $('input[name=confirmPwd]').removeClass('alert-danger');
            }
        });


        $("#addPwd").click(function(){
            var staffID=$('input[name=staffID]').val();
            var staffName=$('input[name=staffName]').val();
            var pwd=$('input[name=pwd]').val();
            var newPwd=$('input[name=newPwd]').val();
            var confirmPwd=$('input[name=confirmPwd]').val();

            if(pwd=='')
            {
                $('input[name=pwd]').addClass('alert-danger').focus();
                $('#pwdInfo').html('当前密码不能为空!');
                $('#pwdInfo').addClass('text-danger').show();
            }
            else if(newPwd=='')
            {
                $('input[name=newPwd]').addClass('alert-danger').focus();
                $('#pwdInfo').html('新密码不能为空!');
                $('#pwdInfo').addClass('text-danger').show();
            }
            else if(newPwd!=confirmPwd)
            {
                $('input[name=newPwd]').addClass('alert-danger').focus();
                $('input[name=confirmPwd]').addClass('alert-danger').focus();
                $('#pwdInfo').html('两次密码不符!');
                $('#pwdInfo').addClass('text-danger').show();
            }
            else
            {
                $.ajax({
                    "type": "POST",
                    "contentType": "application/x-www-form-urlencoded",
                    "url": "/admin/user/passwordchange",
                    "data" : {
                        'staffID':staffID,
                        'staffName' : staffName,
                        'pwd':pwd,
                        'newPwd':newPwd
                    },
                    "dataType": "json",
                    "success": function (data) {
                        if(data == '1') {
                            $('#pwdInfo').addClass('text-success').html('密码修改成功!');
                        }else if(data == '-2') {
                            $('#pwdInfo').addClass('text-danger').html('原密码错误!');
                        }else{
                            $('#pwdInfo').addClass('text-danger').html('该用户不存在!');
                        }
                        $('#pwdInfo').show();
                    }
                });
            }

        });

    });

    function mybind(func, fn) {
        $(func).bind("touchstart",fn);
        $(func).bind("click",fn);
    }
</script>