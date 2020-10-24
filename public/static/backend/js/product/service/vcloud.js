var vcloud = {
    VM_STATUS : {
        "-1" : "Could not be created",
        "0" : "Unresolved",
        "1" : "Resolved",
        "3" : "Suspended",
        "4" : "Powered on",
        "5" : "Waiting for user input",
        "6" : "In an unknown state",
        "7" : "In an unrecognized state",
        "8" : "Powered off",
        "9" : "In an inconsistent state",
        "NOT_CREATED" : "-1",
        "UNRESOLVED" : "0",
        "RESOLVED" : "1",
        "SUSPEND" : "3",
        "POWER_ON" : "4",
        "WAITING" : "5",
        "UNKNOWN_STATE" : "6",
        "UNRECOGNIZED_STATE" : "7",
        "POWER_OFF" : "8",
        "INCONSISTENT_STATE" : "9",
        'ACTION_POWER_ON' : 'power_on',
        'ACTION_POWER_OFF' : 'power_off',
        'ACTION_REBOOT' : 'reboot',
        'ACTION_SHUTDOWN' : 'shutdown',
        'ACTION_SUSPEND' : 'suspend',
    },
    action : (action)=>{
        window.nextState = action;
        $('#fade').show();
        $.ajax({
            url : laroute.route('vcloud.action'),
            method : 'POST',
            data : {
                customer_service_id : window.customer_service_id,
                action
            },
            success : function(e){
                $('#fade').hide();
                $('#vcloud-action').html(window.loading);
                window.update_wait_internal = setInterval(function(){
                    $.ajax({
                        url : laroute.route('vcloud.detail'),
                        method : 'POST',
                        data : {
                            customer_service_id : window.customer_service_id
                        },
                        success : function(data){
                            // check next state same with action => stop loading
                            if(
                                window.nextState == vcloud.VM_STATUS.ACTION_POWER_ON && data['status'] == vcloud.VM_STATUS.POWER_ON ||
                                window.nextState == vcloud.VM_STATUS.ACTION_POWER_OFF && data['status'] == vcloud.VM_STATUS.POWER_OFF ||
                                window.nextState == vcloud.VM_STATUS.ACTION_REBOOT ||
                                window.nextState == vcloud.VM_STATUS.ACTION_SHUTDOWN && data['status'] == vcloud.VM_STATUS.POWER_OFF ||
                                window.nextState == vcloud.VM_STATUS.ACTION_SUSPEND && data['status'] == vcloud.VM_STATUS.SUSPEND ||
                                data['status'] == vcloud.VM_STATUS.WAITING ||
                                data['status'] == vcloud.VM_STATUS.UNKNOWN_STATE ||
                                data['status'] == vcloud.VM_STATUS.UNRECOGNIZED_STATE ||
                                data['status'] == vcloud.VM_STATUS.INCONSISTENT_STATE
                                ){
                                    vcloud.update();
                                    $('#vcloud-action').text('-');
                                    clearInterval(window.update_wait_internal);
                                    if(window.nextState == vcloud.VM_STATUS.ACTION_POWER_ON || window.nextState == vcloud.VM_STATUS.ACTION_REBOOT){
                                        $('.group-power-off').removeClass('block-display').addClass('none-display');
                                        $('.group-power-on').removeClass('none-display').addClass('block-display');
                                    }else{
                                        $('.group-power-off').removeClass('none-display').addClass('block-display');
                                        $('.group-power-on').removeClass('block-display').addClass('none-display');
                                    }

                            }
                        }
                    });
                }, 5000);
            },
            fail : function(){
                $('#fade').hide();
            }
        })
    },
    update : ()=>{
        $.ajax({
            url : laroute.route('vcloud.detail'),
            method : 'POST',
            data : {
                customer_service_id : window.customer_service_id
            },
            success : function(data){
                $('#vcloud-vm').text(data['vm']);
                $('#vcloud-os').text(data['os']);
                $('#vcloud-status').text(vcloud.VM_STATUS[data['status']]);
                let color_status = Number(data['status']) > 4 ? 'red' : (Number(data['status']) == 4 ? 'green' : 'orange');
                $('#vcloud-status').css('color', color_status);
                $('#vcloud-memory').text(data['memory']);
                $('#vcloud-cpu').text(data['cpu']);
                $('#vcloud-disk').text(data['disk'].map((e)=>Number(e.capacity)).reduce((a,b) => a+b)/1024 + ' GB');
            }
        })
    },
    remote : ()=>{
        window.open(laroute.route('vcloud.remote'), "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,width=1000,height=800");

    },
    create_vm: (customer_service_id)=>{
        $('#fade').show();
        $.ajax({
            url : laroute.route('vcloud.creat-vm'),
            method : 'POST',
            data : {
                customer_service_id
            },
            success : function(done){
                $('#fade').hide();
                if(done.error == 0){
                    swal.fire('Tạo VMs thành công', "", "success").then(()=>{
                        location.reload();
                    });
                }else{
                    swal.fire('Tạo VMs thất bại', "", "error");
                }
            }
        })
    }
}
$(document).unbind("ajaxStart");
$(document).unbind("ajaxStop");
