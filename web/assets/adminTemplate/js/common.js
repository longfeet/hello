/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$("#staff").hide();
$("#checkAll").click(function(){
        
    for(var key in $("input[name='adv_id']")){
        $("input[name='adv_id']")[key].checked = this.checked;
    }
})
    
$("select[name='adv_install_status']").change(function(){
    var value = this.value;
    if(value == 0 || value == 1){
        $("#staff").show();
    }else{
        $("#staff").hide();
        for(var i = 0 ; i < $("#staff input[name='staff']").length ; i++){
            $("#staff input[name='staff']")[i].checked = false;
        }
    }
});

$("select[name='adv_pic_status']").change(function(){
    var value = this.value;
    if(value == 1 || value == 3){
        $("#staff").show();
    }else{
        $("#staff").hide();
        for(var i = 0 ; i < $("#staff input[name='staff']").length ; i++){
            $("#staff input[name='staff']")[i].checked = false;
        }
    }
});

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
    
    function getCheckValue(nameId){
        var arr = [];
        for(var i=0;i< $("input[name='"+nameId+"']").length;i++){
            if($("input[name='"+nameId+"']")[i].checked){
                arr.push($("input[name='"+nameId+"']")[i].value); 
            }
        }
        return arr;
    }
    
    $("#editStatus").click(function(){
        var ids = getCheckValue('adv_id');
        var staffs = getCheckValue('staff');
        console.log(staffs);
        if(ids.length < 1){
            alert("请选择至少一条记录！");
            return false;
        }
        //读取修改状态
        var adv_install_status = $("select[name='adv_install_status']").val() || -1;
        var adv_pic_status = $("select[name='adv_pic_status']").val() || -1;
        if(adv_install_status == -1 && adv_pic_status == -1){
            alert("无修改！");
            return false;
        }
        if(confirm("确定要修改记录状态吗？")){
            $.ajax( {
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/adv/ajaxeditstatus",
                "dataType": "json",
                "data": {ids:ids,adv_install_status:adv_install_status,adv_pic_status:adv_pic_status,staffs:staffs,type:$("#typeValue").val()}, //以json格式传递
                "success": function(data) {
                    console.log(data);
                    if(data > 0){
                        alert(data+"条记录状态修改成功！");
                        //刷新页面  目前无法在列表数据中看出状态 预留
                        window.location.reload();
                    }else{
                        alert("记录修改失败！");
                    }
                }
            });
        }
        
    })

