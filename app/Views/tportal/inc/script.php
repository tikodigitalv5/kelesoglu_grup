<script>
  var para_yuvarlama = <?php echo session()->get('user_item')['para_yuvarlama'] ?? 2; ?>;
</script>

<script src="<?= base_url('assets/js/bundle.js') ?>"></script>
<script src="<?= base_url('assets/js/scripts.js?ver='.date('YmdHis')) ?>"></script>
<script src="<?= base_url('assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('assets/js/il-ilce.js?ver=1.1.1') ?>"></script>
<script src="<?= base_url('assets/js/phone-area-code.js?ver=1.1.0') ?>"></script>
<script src="<?= base_url('assets/js/charts/gd-default.js') ?>"></script>
<script src="<?= base_url('assets/js/libs/datatable-btns.js') ?>"></script>
<script src="<?= base_url('custom/tiko.js') ?>"></script>
<style>
  .logo-container {
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    color: #fff;
}

.logo-text {
    font-weight: 300;
    animation: fadeInLeft 0.8s ease-out;
}

.logo-portal {
    font-weight: 500;
    animation: fadeInRight 0.8s ease-out;
}

.logo-dot {
    color: #4A90E2;
    animation: bounce 1s ease-out;
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}
  #global-ajax-loading .loading-content {
    /* ... mevcut stiller ... */
    border: 1px solid #e0e0e0;
}

#global-ajax-loading .spinner-border {
    width: 3rem;
    height: 3rem;
}

#global-ajax-loading .loading-text {
    font-weight: 500;
    margin-top: 10px;
}
</style>

<script>

document.getElementById('datatableStock-loading-close').addEventListener('click', function () {
    $('#datatableStock-loading').fadeOut(200);
});



if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('https://app.tikoportal.com.tr/custom/service-worker.js').then(function(registration) {
      console.log('Service Worker başarıyla kayıt edildi:', registration.scope);
    }).catch(function(error) {
      console.log('Service Worker kaydedilirken hata oluştu:', error);
    });
  });
}
/*

// HTML'e loading div'i ekleyelim (CSS ile ortalanmış, sayfa üzerinde fixed konumlu)
$('body').append(`
    <div id="global-ajax-loading" style="display:none;">
        <div class="loading-overlay" style="position:fixed; top:0; left:0; width:100%; height:100%;  z-index:99333398;"></div>
        <div class="loading-content" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 99333399; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); display: flex ; align-items: center; justify-content: center; flex-direction: column; gap: 10px;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Yükleniyor...</span>
            </div>
            <div class="mt-2">İşlem yapılıyor, lütfen bekleyiniz...</div>
        </div>
    </div>
`);

// Global Ajax event handler'ları
$(document).ajaxStart(function() {
    $('#global-ajax-loading').fadeIn(1);
    $('#global-ajax-loading').css({
        'position': 'fixed',
        'top': '0',
        'left': '0', 
        'width': '100%',
        'height': '100%',
        'background': 'rgba(0, 0, 0, 0.5)',
        'z-index': '99333398',
        'display': 'flex'
    });
}).ajaxStop(function() {
    $('#global-ajax-loading').fadeOut(200);
}).ajaxError(function(event, jqXHR, settings, error) {
    // Ajax hatalarını yönet
    $('#global-ajax-loading').fadeOut(200);
    Swal.fire({
        icon: 'error',
        title: 'Hata!',
        text: 'İşlem sırasında bir hata oluştu: ' + error
    });
});

// Belirli Ajax isteklerini hariç tutmak için (opsiyonel)
$.ajaxPrefilter(function(options, originalOptions, jqXHR) {
    // Eğer istek özel bir parametre içeriyorsa loading'i gösterme
    if (options.noLoading) {
        jqXHR._noLoading = true;
    }
});

$(document).ajaxSend(function(event, jqXHR, settings) {
    // noLoading parametresi olan isteklerde loading'i gösterme
    if (jqXHR._noLoading) {
        return;
    }
    $('#global-ajax-loading').fadeIn(200);
    $('#global-ajax-loading').css({
        'position': 'fixed',
        'top': '0',
        'left': '0', 
        'width': '100%',
        'height': '100%',
        'background': 'rgba(0, 0, 0, 0.5)',
        'z-index': '99333398',
        'display': 'flex'
    });
});
*/
</script>

