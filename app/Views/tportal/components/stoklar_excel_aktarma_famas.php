


<div class="modal fade" id="modalExcel"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sysmond Excel Stok Aktarımı</h5>
        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
      </div>
      <div class="modal-body">
      <form method="post" id="import_form" enctype="multipart/form-data">
          <div class="form-group">
            <label class="form-label" for="full-name">Excel Dosyası</label>
            <div class="form-control-wrap">
              <input type="file" name="file-2" id="file-2" class="form-control inputfile inputfile-2" data-multiple-caption="{count} adet dosya seçildi." multiple  required accept=".xls,.xlsx"  />
            </div>
          </div>
     
          <div class="form-group">
            <button type="submit" id="submit_excel" class="btn btn-lg btn-primary">İçeri Aktar</button>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <span class="sub-text">Örnek Excel Dosyası İçin Tıklayınız</span>
      </div>
    </div>
  </div>
</div>




<script>
   // $(".excelAktar").removeClass("d-none");
$('#import_form').on('submit', function(event) {
    event.preventDefault();
    // alert(); return false;
    $("#submit_excel").html("Excel Aktarılıyor..");
    $("#submit_excel").prop("disabled", true);
    $.ajax({
        url: "<?= route_to('tportal.stocks.excel') ?>",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(res, textStatus, xhr) {
            $("#submit_excel").html("İçe Aktar");
            $("#submit_excel").prop("disabled", false);
            $("#file-2").val('');
            if (xhr.status == 200) {
                $("#modalExcel").modal("hide");
                Swal.fire({
                    title: "İşlem Başarılı",
                    html: "<br><strong>Excel Aktarma Başarılı. <br><br> Lütfen STOKLARI İŞLE Butonuna Tıklayınız..</strong>",
                    icon: "success",
                    showConfirmButton: true,
                    showCancelButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    cancelButtonColor: "#DD6B55",
                    confirmButtonText: 'Stokları İşle'

                }).then(function(result) {
                    if (result.value) {


                        Swal.fire({
                            title: 'Stoklar İşleniyor. Lütfen Bekleyiniz.',
                            html: '<br><b>  BU SAYFAYI İŞLEM BİTENE KADAR KAPATMAYINIZ </b>',
                            timer: 100000000000,

                            timerProgressBar: true,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            onBeforeOpen: function onBeforeOpen() {
                                Swal.showLoading();
                                timerInterval = setInterval(function() {
                                    Swal.getContent().querySelector('strong').textContent = (Swal.getTimerLeft() / 1000).toFixed(0);
                                }, 100);

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                                    },
                                    url: "<?= route_to('tportal.stocks.excelStock') ?>",
                                    data: {},
                                    method: "POST",
                                    datatype: 'JSON',
                                    async: true,
                                    success: function(res, textStatus, xhr) {
                            


                                        if (xhr.status == 200) {
                                            Swal.close();
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Stoklar Başarıyla  İşlendi',
                                                showConfirmButton: false,
                                                timer: 3500
                                            });

                                            // setTimeout(function(){ window.location.href = "<?php echo base_url("panel/urun/excel_basarili"); ?>";}, 3000);
                                        }

                                    }
                                });


                            },
                            onClose: function onClose() {
                                clearInterval(timerInterval);


                            }
                        }).then(function(result) {
                            if (
                                /* Read more about handling dismissals below */
                                result.dismiss === Swal.DismissReason.timer) {
                                console.log('I was closed by the timer'); // eslint-disable-line
                            }
                        });


                    }
                });
            }
        }
    })
});
</script>