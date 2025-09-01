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
                                <div class="card-tools">
                                    <div class="form-inline flex-nowrap gx-3">
                               
                                        <div class="btn-wrap  w-300px">
                                            <div style="display:flex;">
                                            <span style="" class="d-none d-md-block"><a href="<?php echo base_url('tportal/order/list/all'); ?>" class="btn btn-dim btn-outline-primary "> <em class="icon ni ni-chevron-left"></em> Siparişlere Geri Dön</a></span>
                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                            </div>
                                        </div>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>

                                            <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search">
                                                <div class="dot dot-primary d-none" id="notification-dot-search"></div>
                                                <em class="icon ni ni-search"></em>
                                            </a>
                                        </li><!-- li -->
                                        <li class="btn-toolbar-sep"></li><!-- li -->
                                        <li>
                                            <div class="toggle-wrap">
                                                <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                <div class="toggle-content" data-content="cardTools">
                                                    <ul class="btn-toolbar gx-1">
                                                        <li class="toggle-close">
                                                            <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                                        </li><!-- li -->
                                       
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-filter-alt"></em>
                                                                </a>

                                                                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                                                    <ul class="link-check">
                                                                        <li><span>Sayfalama</span></li>
                                                                        <li><a href="javascript:;" id="row-10">10</a></li>
                                                                        <li><a href="javascript:;" id="row-25">25</a></li>
                                                                        <li><a href="javascript:;" id="row-50">50</a></li>
                                                                        <li><a href="javascript:;" id="row-100">100</a></li>
                                                                        <li><a href="javascript:;" id="row-200">200</a></li>
                                                                        <li><a href="javascript:;" id="row-1000">1000</a></li>
                                                                        <!-- <li><a href="javascript:;" id="row-all">Tümü</a></li> -->
                                                                    </ul>
                                                                    <!-- <ul class="link-check">
                                                                      <li><span>Order</span></li>
                                                                      <li class="active"><a href="#">DESC</a></li>
                                                                      <li><a href="#">ASC</a></li>
                                                                  </ul> -->
                                                                </div>
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                    </ul><!-- .btn-toolbar -->
                                                </div><!-- .toggle-content -->
                                            </div><!-- .toggle-wrap -->
                                        </li><!-- li -->
                                    </ul><!-- .btn-toolbar -->
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
    <tbody>
        <form method="POST" id="formSerialize">
        <?php $count = 0; foreach($eslesmeyenler as $esle): 
            $count ++;
  
            ?>
    <tr class="nk-tb-item">
    <td class="nk-tb-col tb-col-mb">
                                                <div class="user-info">
                                               <span style="color:black; opacity:0.8;"> <?php echo $esle["stock_title"]; ?> <br> Kodu: <?php echo $esle["dopigo_sku"]; ?> <br>
	Dopigo ID: <?php echo $esle["dopigo"]; ?>												
													</span>

                                                 </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-mb text-left">
                                                <div class="user-info">

                                                <img  class="img_urun_<?php echo $esle["order_row_id"]; ?>" src="https://app.tikoportal.com.tr/uploads/default.png" alt="logo" style="height: 70px;">
                        <a id="imghref_<?php echo $esle["order_row_id"]; ?>" class="gallery-image popup-image" href="">
                                                        <img class="d-none" id="img_urun_<?php echo $esle["order_row_id"]; ?>" src="" alt="logo" style="height: 70px;">
                                                        </a>
                                                    </td>
                                                <td class="nk-tb-col tb-col-mb">
                                                <div class="user-info">
                                                <div class="form-control-wrap ">
                                                <textarea class="form-control yeni_urun_<?php echo $esle["order_row_id"]; ?>  form-control-lg form-control-xl" placeholder="Ürün Seçiniz" disabled style="min-height: 70px; padding: 5px;  font-size: 14px; line-height: 19px;"></textarea>
                                                                    <input type="hidden" name="stok_id[]" class="stok_id_<?php echo $esle["order_row_id"]; ?>">
                                                                    <input type="hidden" value="<?php echo $esle["order_row_id"]; ?>" name="order_row_id[]" id="order_row_id">
                                                                    </div>
                             
                    </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-mb text-center">
                                                <div class="user-info">
                                                <button 
                                                type="button"
                                                data-order_row_id="<?php echo $esle["order_row_id"]; ?>"
                                                class="btn btn-outline-primary btn-dim btn_urun_sec"  data-nereden="siparis" id="btn_urunSec"><span>Ürün Seç</span></button>

                             
                    </div>
                                                </td>
                                            </tr>
                                            <?php   endforeach; ?>




                                            </form>
    </tbody>

</table>

<div style="margin-top: 20px; border-top: 1px solid #d3d3d3; padding-top: 20px; padding-bottom: 20px;">
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
    'App\Libraries\ViewComponents::getSiparisStockModal'
); ?>

<script>

$("#formGonder").click(function() {

var form = $("#formSerialize");

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
            url: '<?= route_to('tportal.siparisler.urun_guncelle') ?>',
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
                    title: 'Başarılı!',
                    html: 'B2B Sipariş Portalından Siparişler Başarıyla Çekildi.',
                    icon: 'success',
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


    $(".btn_urun_sec").click(function(){

        var satir_id = $(this).attr("data-order_row_id");
        $("#order_row_id").val(satir_id);
        $("#mdl_urunSec").modal("show");
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
$("#indirButton").click(function(){

var data = $(".toplu_islem").val();

if (data == "b2b") {

    Swal.fire({
        title: 'MSH B2B sitesindeki siparişlerinizi aktarmak istiyormusunuz?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Evet, Devam Et',
        cancelButtonText: 'Hayır',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
            title: 'Siparişleriniz çekiliyor lütfen sayfayı kapatmayınız!',
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
                url: '<?= route_to('tportal.api.msh') ?>',
                dataType: 'json',
                data: {
                    // You can pass any additional data here if needed
                },
                async: true,
                success: function (response) {
                    Swal.fire({
                        title: 'Başarılı!',
                        html: 'B2B Sipariş Portalından Siparişler Başarıyla Çekildi.', // Display the server error message
                        icon: 'success',
                        confirmButtonText: 'Tamam',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    });

                    setTimeout(() => {
                            location.reload(); // Reload the page after a delay
                        }, 2600);
                       

               
           
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: 'Başarılı!',
                        html: 'B2B Sipariş Portalından Siparişler Başarıyla Çekildi.', // Display the server error message
                        icon: 'success',
                        confirmButtonText: 'Tamam',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    });

                    setTimeout(() => {
                            location.reload(); // Reload the page after a delay
                        }, 2600);

                }
            });

        } else {
            // Handle if the user clicks Cancel
        }
    });
}




if (data == "sevk_emri") {

Swal.fire({
    title: 'Seçili olan siparişler için sevkiyat emiri oluşturmak istiyormusunuz?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, Devam Et',
    cancelButtonText: 'Hayır',
}).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
        title: 'Sevkiyat emiri  oluşturuluyor lütfen sayfayı kapatmayınız!',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
    });


    var selectedValues = getSelectedCheckboxValues();

 

    $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= route_to('tportal.siparisler.sevkEmirleri') ?>',
                    dataType: 'json',
                    data: {
                        order_id: selectedValues                    
                    },
                    async: true,
                    success: function (response) {
                        Swal.fire({
                            title: 'Başarılı!',
                            html: 'Sevkiyat Emri Başarıyla Oluşturuldu.',
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(() => {
                            location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                        }, 260330);
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Başarılı!',
                            html: 'Sevkiyat Emri Başarıyla Oluşturuldu.',
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(() => {
                            location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                        }, 263300);
                    }
                });



    } else {
        // Handle if the user clicks Cancel
    }
});
}



if (data == "dopigo") {

Swal.fire({
    title: 'Fams DOPİGO sitesindeki siparişlerinizi aktarmak istiyormusunuz?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, Devam Et',
    cancelButtonText: 'Hayır',
}).then((result) => {
    if (result.isConfirmed) {

        // Tarih aralığı almak için input alanları ekle
        Swal.fire({
            title: 'Tarih  Seçin',
            html:
                '<label for="start_date">Tarih Seçin:</label>' +
                '<input type="date" id="start_date" class="swal2-input" />',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Siparişleri Çek',
            cancelButtonText: 'İptal',
            preConfirm: () => {
                const startDate = Swal.getPopup().querySelector('#start_date').value;
                const endDate = Swal.getPopup().querySelector('#start_date').value;
                if (!startDate || !endDate) {
                    Swal.showValidationMessage('Lütfen geçerli bir tarih aralığı girin');
                    return false;
                }
                return { startDate: startDate, endDate: endDate };
            }
        }).then((dateResult) => {
            if (dateResult.isConfirmed) {
                
                Swal.fire({
                    title: 'Siparişleriniz çekiliyor lütfen sayfayı kapatmayınız!',
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
                    url: '<?= route_to('tportal.api.dopigo') ?>',
                    dataType: 'json',
                    data: {
                        start_date: dateResult.value.startDate,
                        end_date: dateResult.value.endDate
                        // Gerekirse buraya ek veri ekleyebilirsiniz
                    },
                    async: true,
                    success: function (response) {
                        Swal.fire({
                            title: 'Başarılı!',
                            html: 'DOPİGO Sipariş Portalından Siparişler Başarıyla Çekildi.',
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(() => {
                            location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                        }, 2600);
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Başarılı!',
                            html: 'DOPİGO Sipariş Portalından Siparişler Başarıyla Çekildi.',
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(() => {
                            location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                        }, 2600);
                    }
                });

            } else {
                // Kullanıcı Cancel butonuna tıklarsa yapılacak işlemler
            }
        });
    }
});
}





});

$('.toplu_islem').on('change', function() {
                // Seçilen değeri al
                var selectedValue = $(this).val();

                // Eğer seçilen değer boşsa butonu devre dışı bırak
                if (selectedValue == '#') {
                    $("#indirButton").addClass("disabled");
                    $("#indirButton").prop("href", "#");
                    return;
                }

                // Butonu etkinleştir
                $("#indirButton").removeClass("disabled");

                // href özniteliğini güncelle
                $('#indirButton').attr('href', selectedValue);
            });

</script>

<?= $this->endSection() ?>