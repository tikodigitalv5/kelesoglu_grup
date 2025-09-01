


<div class="modal fade" id="mshDugmeModal"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Msh Düğme  Web Site İşlemleri</h5>
        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
      </div>
      <div class="modal-body">
      <div class="form-group">
            <button type="button" style="width:100%;"  id="siteden_disari" class="btn btn-lg btn-secondary">App'den Msh Düğme Siteye Aktar <em class="icon ni ni-arrow-right"></em></button>

          </div>
         
      </div>
      
    </div>
  </div>
</div>




<script>

    var siteden_iceri = $("#siteden_iceri"),
        siteden_disari  = $("#siteden_disari"),
        modal_div       = $("#mshDugmeModal");



    siteden_disari.click(function(){

        siteden_disari.html("<em style='margin-top: -4px; margin-right: 5px;' class='icon ni ni-reload'></em> Lütfen Bekleyiniz..");
        siteden_iceri.attr("disabled", true);
        modal_div.modal("hide");




        Swal.fire({
        title: 'Sitedeki ürünleri MSH Düğme Web Sitesine  sitesine aktarmak istiyormusunuz?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Evet, Aktar',
        cancelButtonText: 'Hayır',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
            title: 'Ürünleriniz aktarılıyor lütfen sayfayı kapatmayınız!',
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading();
            },
        });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.api.msh_send_products') ?>',
                dataType: 'json',
                data: {
                    // You can pass any additional data here if needed
                },
                async: true,
                success: function (response) {
                    

                    if (response['icon'] == 'success') {
                      
                        Swal.fire({
                            title: 'Başarılı!',
                            html: response['message'],
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Tamam butonuna tıklandığında sayfayı yeniden yükle
                            }
                        });

                    }
                    if (response['icon'] == 'info') {
                      
                        Swal.fire({
                            title: 'Bilgilendirme!',
                            html: response['message'],
                            icon: 'info',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Tamam butonuna tıklandığında sayfayı yeniden yükle
                            }
                        });
              }

                    siteden_disari.html("App'den Siteye Aktar <em class='icon ni ni-arrow-right'>");
                    siteden_iceri.attr("disabled", false);

               

               
           
                }
            });

        } else {
            modal_div.modal("show");
            siteden_iceri.attr("disabled", false);

            siteden_disari.html("App'den Siteye Aktar <em class='icon ni ni-arrow-right'>");

        }
    });





    });


</script>