function swetAlert(title,msg,type){
    var status = '';
    if(type == "ok"){
        status = "success";
    } 
    if(type == "err"){
        status = "warning";
    }
    Swal.fire({
        icon: status,
        title: title,
        html: '<b>'+msg+'</b>',
        showConfirmButton: false,
        timer: 2500
    });
}

