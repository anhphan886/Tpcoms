var vcloud = {
    create_org : (customer_no)=>{
        $.ajax({
            method : 'POST',
            url : laroute.route('vcloud.creat-org'),
            data : { customer_no },
            success : (e)=>{
                if(e.error == 1){
                    swal.fire('Tạo organization thất bại', "", "error");
                }else{
                    swal.fire('Tạo organization thành công', "", "success");
                }
            }
        })
    },
    config_firewall: (customer_no) => {
        $.ajax({
            method : 'POST',
            url : laroute.route('vcloud.firewall'),
            data : { customer_no },
            success : (e)=>{
                if(e.error == 1){
                    swal.fire('Cập nhật firewall thất bại', "", "error");
                }else{
                    swal.fire('Cập nhật firewall thành công', "", "success");
                }
            }
        })
    }
}
