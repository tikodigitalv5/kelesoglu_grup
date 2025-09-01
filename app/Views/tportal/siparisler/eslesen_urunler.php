<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> <?= $page_title ?> <?= $this->endSection() ?>
<?= $this->section('title') ?> <?= $page_title ?> | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title"><?= $page_title ?></h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                    <li class="nk-block-tools-opt">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>Add User</span></a></li>
                                                    <li><a href="#"><span>Add Team</span></a></li>
                                                    <li><a href="#"><span>Import User</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .toggle-wrap -->
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                              
                                <div class="card-tools" style="flex:1">
                                                        <div class="form-inline flex-nowrap gx-3">
                                                           
                                                            <div class="form-wrap d-none d-md-block">
                                                                <div class="form-group">
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-icon form-icon-right">
                                                                            <em class="icon ni ni-layers" style="font-size: 24px;padding-top: 12px;"></em>
                                                                        </div>
                                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="stock_code" name="stock_code" style="width: 500px;">
                                                                        <label class="form-label-outlined label_gray" for="outlined-right-icon">Stok Kodu</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                  
                                                            
                                                            <div class="btn-wrap">
                                                                <span class=" d-md-inline"><button class="btn btn-dim btn-xl btn-outline-light urunFiltrele">Ara</button></span>
                                                        
                                                            </div>
                                                       
                                                        </div><!-- .form-inline -->
                                                    </div>

                                                    <div class="card-tools" >
                                    <div class="form-inline flex-nowrap gx-3">
                               
                                        <div class="btn-wrap  w-300px">
                                            <div style="display:flex;justify-content: end;">
                                            <span style="" class="d-none d-md-block"><a href="<?php echo base_url('tportal/order/list/all'); ?>" class="btn btn-dim btn-outline-primary "> <em class="icon ni ni-chevron-left"></em> Siparişlere Geri Dön</a></span>
                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                            </div>
                                        </div>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" id="stock_input_search" class="form-control border-transparent form-focus-none" placeholder="Bulmak istediğiniz ürünün adını yada kodunu yazınız..">
                                        <a href="#" class="btn btn-icon toggle-search active" data-target="search" style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em class="icon ni ni-cross"></em></a>
                                        <button class="search-submit btn btn-icon" style="margin-right: 50px;" id="stock_input_search_clear_button" name="stock_input_search_clear_button"><em class="icon ni ni-trash"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div><!-- .card-inner -->



                        <div class="card-inner p-0">
                        <form method="POST" id="formSerialize">

<table id="" class="datatable-init-hareketlers nk-tb-list nk-tb-ulist" data-auto-responsive="false">
    <thead>
    <tr class="nk-tb-item nk-tb-head tb-tnx-head">
                                       

                                       <!-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">S.Tipi</span></th> -->
                                       <th class="nk-tb-col tb-col-lg" style="width:40%"><span class="sub-text">Dopigo Ürün bilgileri</span></th>
                                       <!-- <th class="nk-tb-col tb-col-mb"><span class="sub-text">Kodu</span></th> -->
                                       <th class="nk-tb-col tb-col-lg" style="width:10%" data-orderable="false"><span class="sub-text">Görsel</span></th>
                                       <th class="nk-tb-col " data-orderable="false"><span class="sub-text">App Ürün Bilgileri</span></th>
                                  
                                       <th style="width:8%;" class="nk-tb-col nk-tb-col-tools text-center" data-orderable="false">Ürün Seç</th>
                                   </tr>
    </thead>
    <tbody id="bodyForm">


    <tr class="nk-tb-item">
                    <td  colspan="5" class="nk-tb-col tb-col-mb">
                        <div class="user-info">
                            <span style="color:black; opacity:0.8;">
                              <center> EŞLENEN ÜRÜN BULUNAMADI</center>
                            </span>
                        </div>
                    </td>
                  
                </tr>
      
    </tbody>

</table>
</form>

<div style="margin-top: 20px; border-top: 1px solid #d3d3d3; padding-top: 20px; padding-bottom: 20px;" id="DegisiklikButon">
<span style="float: right; padding-bottom: 20px; padding-right: 10px;"><button id="formGonder" class="btn btn-dim btn-outline-primary "> <em class="icon ni ni-check"></em> Değişiklikleri Kaydet</button> </span>

</div>

                        </div>


                  
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>




<?= view_cell(
    'App\Libraries\ViewComponents::getSiparisStockModalEslesen'
); ?>

<script>

document.getElementById('stock_code').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Formun varsayılan olarak gönderilmesini engelle
            document.querySelector('.urunFiltrele').click(); // Butona tıklama işlemi
        }
    });

var DegisiklikButon = $("#DegisiklikButon span button");

DegisiklikButon.hide();

$(".urunFiltrele").click(function(){
        var stock_code = $("#stock_code").val(),
            body_form  = $("#bodyForm");
            var DegisiklikButonSend = $("#DegisiklikButon span button");

            DegisiklikButonSend.hide();



    if(stock_code.length < 4){
        body_form.empty();

        Swal.fire({
                    title: 'Eksik Alan!',
                    html: 'Stok Kodu En Az 4 Karakter Olmalıdır.',
                    icon: 'error',
                    confirmButtonText: 'Tamam',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                });
    }else{



        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.siparisler.eslesen_getir') ?>',
            dataType: 'json',
            data: { stock_code : stock_code }, // Form verilerini serialize ederek gönder
            async: true,
            beforeSend: function() {
                Swal.fire({
                    title: 'Ürün Sorgulanıyor lütfen sayfayı kapatmayınız!',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    },
                });
                DegisiklikButonSend.hide(); // DegisiklikButonSend butonunu gizleyebilirsiniz
            },
            success: function (response) {

                Swal.close(); // Yükleme göstergesini kapat

                if (response['icon'] == 'success') {


               
                    DegisiklikButonSend.show();
                    body_form.empty();
                    body_form.html(response.data);
                }else{

                    body_form.empty();
                    Swal.fire({
                        title: 'Hata!',
                        html: stock_code + ' Koduna Ait Eşleşen Ürün Bulunamadı',
                        icon: 'error',
                        confirmButtonText: 'Tamam',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    });

                }

              
               
            },
            error: function (xhr, status, error) {
                Swal.close(); // Yükleme göstergesini kapat

                body_form.empty();
                Swal.fire({
                    title: 'Hata!',
                    html: stock_code + ' Koduna Ait Eşleşen Ürün Bulunamadı',
                    icon: 'error',
                    confirmButtonText: 'Tamam',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                });

   
            }
        });



    }
});

$("#formGonder").click(function() {

var form = $("#formSerialize");

console.log("form verisi" + $(this).serialize()); // Form verilerini console'a yazdır

Swal.fire({
    title: 'Yaptığınız değişiklikleri kaydetmek istiyormusunuz?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, Kayıt Et',
    cancelButtonText: 'Hayır',
}).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
            title: 'Değişiklikler kaydediliyor lütfen sayfayı kapatmayınız!',
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
            url: '<?= route_to('tportal.siparisler.eslesme_guncelle') ?>',
            dataType: 'json',
            data: form.serialize(), // Form verilerini serialize ederek gönder
            async: true,
            success: function (response) {
                Swal.fire({
                    title: 'Başarılı!',
                    html: 'Ürünleriniz Başarıyla Eşlendi.',
                    icon: 'success',
                    confirmButtonText: 'Tamam',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                });

                setTimeout(() => {
                    //location.reload(); // Belirli bir süre sonra sayfayı yenileyin
                }, 2600);
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    title: 'Hata!',
                    html: 'Ürün Eşleştirmede Bir Hata Oluştu!',
                    icon: 'error',
                    confirmButtonText: 'Tamam',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                });

                setTimeout(() => {
                   //    location.reload(); // Belirli bir süre sonra sayfayı yenileyin
                }, 2600);
            }
        });
    } else {
        // Kullanıcı iptal tuşuna basarsa yapılacak işlemler
    }
});

});





$(document).on('click', '.btn_urun_sec', function() {
    var satir_id = $(this).attr("data-order_row_id");
    var s_id = $(this).attr("data-s-id");
    console.log(s_id);
    $("#s_id").val(s_id);
    $("#mdl_stock_searchs").val('');
    var stockTable = $('#datatableStock').DataTable();
    stockTable.clear().draw();
    $('#datatableStock tbody').empty();
    $("#mdl_urunSec").attr("data-s-id", s_id).modal("show");
});


function getSelectedCheckboxValues() {
    var selectedValues = [];
    
    // Seçili olan checkbox'ları seç
    $('.datatable-checkbox:checked').each(function() {
        // Checkbox'ın 'data-id' değerini al
        selectedValues.push($(this).data('id'));
    });
    
    return selectedValues;
}

$(document).on('click', '.gallery-image', function() {
       
       var title = $(this).attr("data-title");
          
           var href = $(this).attr("data-href");
           
            $(".modal-backdrop").remove();
           $("#urunGorsel .modal-title").text(title);
           $("#urunGorsel img").attr("src", href); 
           
           // Modalı göster
           $("#urunGorsel").modal("show");
});




</script>

<?= $this->endSection() ?>




