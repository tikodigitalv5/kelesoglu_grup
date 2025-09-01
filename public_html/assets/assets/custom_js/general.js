


function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
        return false;
    }else{
        return true;
    }
}



function alert_temizle(div = '#div_alert') {  
    $(div).hide();
    $(div+'_html').removeAttr('class');
    $(div+'_html').html('');
}

function alert_uyari(uyari_metin, div = '#div_alert') {  
    $(div+'_html').attr('class','alert alert-danger alert-icon');
    $(div+'_html').html('<em class="icon ni ni-alert-circle alert_icon"></em> ' + uyari_metin );
    $(div).show();
}
function alert_basarili(basarili_metin, div = '#div_alert') {  
    $(div+'_html').attr('class','alert alert-success alert-icon');
    $(div+'_html').html('<em class="icon ni ni-check-round alert_icon"></em> ' + basarili_metin );
    $(div).show();
}