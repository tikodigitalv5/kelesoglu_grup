

<script src="<?= base_url('assets') ?>/assets/js/bundle.js?ver=3.0.2"></script>
<script src="<?= base_url('assets') ?>/assets/js/scripts.js?ver=3.0.2"></script>

<script src="<?= base_url('assets') ?>/assets/custom_js/general.js?ver=1.0.0"></script>


<script>
    if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('https://app.tikoportal.com.tr/custom/service-worker.js').then(function(registration) {
      console.log('Service Worker başarıyla kayıt edildi:', registration.scope);
    }).catch(function(error) {
      console.log('Service Worker kaydedilirken hata oluştu:', error);
    });
  });
}
</script>