<?php $segments = explode('/', $_SERVER['REQUEST_URI']); ?>
<div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg"
    data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
    <div class="card-inner-group" data-simplebar>
        <div class="card-inner">
            <div class="user-card">
                <div class="user-avatar sq"> <a class="gallery-image popup-image"
                        href="<?= base_url($stock_item['default_image']) ?>">
                        <img class="w-100 rounded-top" src="<?= base_url($stock_item['default_image']) ?>" alt="">
                    </a></div>
                <div class="user-info">
                    <span class="lead-text"><?= $stock_item['stock_code'] ?></span>
                    <span class="sub-text"><?= $stock_item['stock_title'] ?></span>

                </div>

            </div><!-- .user-card -->
        </div><!-- .card-inner -->
        <div class="card-inner">
            <div class="user-account-info py-0">
                <h6 class="overline-title-alt">STOK DURUMU</h6>

                <div class="user-balance">
                    <?= $stock_item['has_variant'] == 0 ? number_format($stock_item['stock_total_quantity'], 2, ',', '.') : number_format($stock_item['stock_total_quantity'], 2, ',', '.') ?>
                    <small
                        class="currency currency-btc"><?= isset($stock_item['sale_unit_title']) ? $stock_item['sale_unit_title'] : $stock_item['unit_title'] ?></small>
                </div>
                <div class="user-balance-sub">Stokta 0 <span
                        class="currency currency-btc"><?= isset($stock_item['sale_unit_title']) ? $stock_item['sale_unit_title'] : $stock_item['unit_title'] ?></span></span>
                </div>
                <div class="user-balance-sub d-none text-warning">İşlemde <span class=" text-warning">0 <span
                            class="currency currency-btc text-warning"><?= isset($stock_item['sale_unit_title']) ? $stock_item['sale_unit_title'] : $stock_item['unit_title'] ?></span></span>
                </div>

                <br>

<?php 


if(isset($stock_operation) && !empty($stock_operation)) {  ?>
                <table class="table table-tranx is-compact">
  <thead class="bg-light bg-opacity-75">
    <tr class="tb-tnx-head">

      <th class="tb-tnx-info">
        <span style="width:calc(50% - 52px);" class="tb-tnx-desc d-none d-sm-inline-block">
          <span>İşlem</span>
        </span>
        <span style="width:calc(50% - 52px); text-align:right;" class="tb-tnx-desc d-none d-sm-inline-block">
          <span>Beklemede</span>
        </span>
        <span style="width:calc(50% - 52px); text-align:right;" class="tb-tnx-desc d-none d-sm-inline-block">
          <span>İşlemde</span>
        </span>
    
      </th>
   
    </tr>
  </thead>
  <tbody>

<?php foreach ($operation_amounts as $operation_id => $amounts): ?>
    <!-- Her bir operasyon için bir satır oluştur -->
    <tr class="tb-tnx-item">
        <td class="tb-tnx-info">
            <div class="tb-tnx-desc" style="width:calc(50% - 52px);">
                <span class="title"><?php echo $amounts['title']; ?></span>
            </div>
            <div class="tb-tnx-desc" style="width:calc(50% - 52px); text-align:center;">
                <span class="title"><?php echo number_format($amounts['beklemede'], 2, ',', '.'); ?></span>
            </div>
            <div class="tb-tnx-desc" style="width:calc(50% - 52px); text-align:center;">
                <span class="title"><?php echo number_format($amounts['islemde'], 2, ',', '.'); ?></span>
            </div>
        </td>
    </tr>
<?php endforeach; ?>



   
  </tbody>
</table>
<?php  } ?>

                

                

            </div>
        </div><!-- .card-inner -->
        <div class="card-inner p-0">
            <ul class="link-list-menu">


            <?php if(session()->get('user_id') == 5 || session()->get('client_id') == 154): ?>
            <li>
                <a href="<?= route_to('tportal.stocks.maliyet_hesapla', $stock_item['stock_id']) ?>">
                    <em class="icon ni ni-money"></em>
                    <span>Maliyet Hesapla</span>
                </a>
            </li>
            <?php endif ?>

            <?php if(session()->get('user_item')['user_id'] == 1){ ?>
<?php if(session()->get('user_item')['client_id'] == 155 || session()->get('user_item')['client_id'] == 1){ ?>
            <li>
    <a 
      class="<?php echo ($segments[3] == 'stok_gruplama_detay') ? 'active' : ''; ?>"
      href="<?= route_to('tportal.stocks.stok_gruplama_detay', isset($stock_item['grup_id']) && $stock_item['grup_id'] > 0 ? $stock_item['grup_id'] : $stock_item['stock_id']) ?>"
      >
        <em class="icon ni ni-layers"></em>
        <span>Gruplama Detayları</span>
    </a>
</li>
<?php } ?>
<li>
    <a 
      class="<?php echo ($segments[3] == 'stok_barkodlar') ? 'active' : ''; ?>"
      href="<?= route_to('tportal.stocks.stok_barkodlar', $stock_item['stock_id']) ?>"
      >
        <em class="icon ni ni-scan"></em>
        <span>Stok Barkodları</span>
    </a>
</li>
<?php } ?>
<?php if(session()->get('user_item')['user_id'] == 3){ ?>
    <li>
    <a 
      class="<?php echo ($segments[3] == 'stok_barkodlar_aktif') ? 'active' : ''; ?>"
      href="<?= route_to('tportal.stocks.stok_barkodlar_aktif', $stock_item['stock_id']) ?>"
      >
        <em class="icon ni ni-scan"></em>
        <span>Aktif Stok Barkodları</span>
    </a>
</li>
<?php } ?>
                <?php
                if (isset($parentStockId) && $parentStockId != 0) {
                    echo '<li class="bg-gray-100"><a class="" href="' . route_to('tportal.stocks.detail', $parentStockId) . '"><em class="icon ni ni-arrow-left"></em><span>Ana Ürüne Dön</span></a></li>';
                }
                ?>
                <?php if(session()->get('user_item')['user_id'] != 1){ ?>

                <li><a id="stokGuncelle" style="cursor:pointer;"><em class="icon ni ni-db-fill"></em><span>Stokları Güncelle</span></a></li>

                <?php } ?>


                <li><a class="<?php $sonuc = ($segments[3] == 'detail') ? 'active' : '';
                echo $sonuc; ?>"
                        href="<?= route_to('tportal.stocks.detail', $stock_item['stock_id']) ?>"><em
                            class="icon ni ni-layers"></em><span>Ürün Bilgileri</span></a></li>
                          

                <?= view_cell('App\Libraries\ViewComponents::getComponent', ['component_name' => 'stoklar.detay.ozellikler_solmenu']); ?>

                <li><a class="<?php $sonuc = ($segments[3] == 'price-variant-multiple') ? 'active' : '';
                echo $sonuc; ?>"
               href="<?= route_to('tportal.stocks.variant_price.multiple', $stock_item['stock_id']) ?>"
                        ><em
                            class="icon ni ni-sign-try"></em><span>Fiyat Güncelleme</span></a></li>

                <li><a class="<?php $sonuc = ($segments[3] == 'gallery') ? 'active' : '';
                echo $sonuc; ?>"
                        href="<?= route_to('tportal.stocks.gallery', $stock_item['stock_id']) ?>"><em
                            class="icon ni ni-img"></em><span>Ürün Galeri</span></a></li>
                <li><a class="<?php $sonuc = ($segments[3] == 'movements') ? 'active' : '';
                echo $sonuc; ?>"
                        href="<?= route_to('tportal.stocks.movements', $stock_item['stock_id']) ?>"><em
                            class="icon ni ni-list-thumb"></em><span>Ürün Hareketleri</span></a></li>

                <li><a class="<?php $sonuc = ($segments[3] == 'operations') ? 'active' : '';
                echo $sonuc; ?>"
                        href="<?= route_to('tportal.stocks.operations', $stock_item['stock_id']) ?>"><em
                            class="icon ni ni-dashboard"></em><span>Ürün Operasyonları</span></a></li>
                <li><a class="<?php $sonuc = ($segments[3] == 'contents') ? 'active' : '';
                echo $sonuc; ?>"
                        href="<?= route_to('tportal.stocks.contents', $stock_item['stock_id']) ?>"><em
                            class="icon ni ni-view-list-sq"></em><span>Ürün Reçetesi</span></a></li>
                <li><a href="#"><em class="icon ni ni-property-add"></em><span>Üretim Emri Ver</span></a></li>
                <li><a class="<?php $sonuc = ($segments[3] == 'substocks') ? 'active' : '';
                echo $sonuc; ?>"
                        href="<?= route_to('tportal.stocks.substocks', $stock_item['stock_id']) ?>"><em
                            class="icon ni ni-copy"></em></em><span>Alt Ürünler</span></a></li>
                <li class="d-none"><a
                        class="<?php $sonuc = ($segments[3] == 'stock_package') ? 'active' : '';
                        echo $sonuc; ?>"
                        href="<?= route_to('tportal.stocks.stock_package_list', $stock_item['stock_id']) ?>"><em
                            class="icon ni ni-package"></em></em><span>Ürün Paket Seçenekleri</span></a></li>
                <li><a class="<?php $sonuc = ($segments[3] == 'edit') ? 'active' : '';
                echo $sonuc; ?>"
                        href="<?= route_to('tportal.stocks.edit', $stock_item['stock_id']) ?>"><em
                            class="icon ni ni-edit"></em><span>Ürün Düzenle</span></a></li>

                            <?php if(session()->get('user_item')['user_id'] == 1){ ?>

                                <?php if(session()->get('user_item')['client_id'] == 155){?> 
                                    <li><a class=" text-danger" id="deleteBefore"><em class="icon ni ni-trash text-danger"></em><span>Ürün
                                    Sil</span></a></li>
                                    
                                <?php  }else{ ?>
                                    <li><a class=" text-danger" id="deleteBefores"><em class="icon ni ni-trash text-danger"></em><span>Ürün
                                    Sil</span></a></li>
                               <?php  } ?>

                            <?php }else{?>

                            <li><a class=" text-danger" id="deleteBefore"><em class="icon ni ni-trash text-danger"></em><span>Ürün
                            Sil</span></a></li>

                            <?php } ?>

                   

<!-- Modal yapısı -->

                <!-- <li><a data-bs-toggle="modal" data-bs-target="#modal_delete_stock" class=" text-danger"><em
                            class="icon ni ni-trash text-danger"></em><span>Ürün Sil</span></a></li> -->

            </ul>
        </div><!-- .card-inner -->
    </div><!-- .card-inner-group -->
</div>

<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'stock',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Stok Başarıyla Silindi.',
                'modal_buttons' => '<a href="'.route_to('tportal.stocks.create').'" class="btn btn-l btn-mw btn-primary">Yeni Ürün/Hizmet Ekle</a>
                                    <a href="'.route_to('tportal.stocks.list', 'all').'" class="btn btn-l btn-mw btn-secondary">Stok Listesine Döne</a>'
            ],
            'delete' => [
                'modal_title' => 'Bu Stoğu Silmek İstediğinize<br>Emin misiniz?',
                'modal_text' => 'Bu stoğu silmeden önce lütfen yetkilinize danışınız.',
            ]
        ],
    ]
); ?>



<?= $this->section('script') ?>

<script>
    var base_url = window.location.origin;



    $('#deleteBefores').click(function (e) {

        Swal.fire({
                                title: "Bu işlem için yetkiniz yoktur.",
                                text: "<?php echo $stock_item['stock_title'] ?> ürününü silmek için yetkiniz yoktur.",
                                confirmButtonText: "Tamam",
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                icon: "error",
                            });

});


    $('#deleteBefore').click(function (e) {

        $.ajax({
            type: 'POST',
            url: '<?= route_to('tportal.stocks.deleteBefore', $stock_item['stock_id']) ?>',
            dataType: 'json',
            success: function (response, data) {

                // console.log(response);
                // console.log(data);

                if (response.icon == "success") {
                    messageText = "";
                    if (response.count != 0)
                        messageText = response.count +' adet alt ürün ile birlikte silme işlemi gerçekleştirilecektir. <br> Devam etmek istiyor musunuz?';
                    else
                        messageText = 'Silme işlemi gerçekleştirilecektir. <br> Devam etmek istiyor musunuz?';
                    
                    Swal.fire({
                        title: 'Stok silmek üzeresiniz!',
                        html: messageText,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Devam Et',
                        cancelButtonText: 'Hayır',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        
                    }).then((result) => {
                        if (result.isConfirmed) {

                            console.log(result.isConfirmed);

                            Swal.fire({
                                title: 'İşleminiz gerçekleştiriliyor, lütfen bekleyiniz...',
                                allowOutsideClick: false,
                                onBeforeOpen: () => {
                                    Swal.showLoading();
                                },
                            });

                            $.ajax({
                                type: 'POST',
                                url: '<?= route_to('tportal.stocks.delete', $stock_item['stock_id']) ?>',

                                success: function (response, data) {
                                    dataaa = JSON.parse(response);

                                    if (dataaa.icon == "success") {
                                        Swal.fire({
                                            title: "İşlem Başarılı",
                                            html: dataaa.message,
                                            confirmButtonText: "Tamam",
                                            allowEscapeKey: false,
                                            allowOutsideClick: false,
                                            icon: "success",
                                        })
                                        .then(function () {
                                            window.location.href = base_url + "/tportal/stock/list/all";
                                        });

                                    } else {
                                        data = dataaa;

                                        var detailsHtml = '';
                                        if (data.details && data.details.length > 0) {
                                            detailsHtml = '<ul>';
                                            data.details.forEach(function(detail) {
                                                detailsHtml += '<li><b>' + detail.stock_title + '</b></li>';
                                            });
                                            detailsHtml += '</ul>';
                                        }

                                        Swal.fire({
                                            title: data.icon === 'success' ? 'Başarılı!' : 'İşlem Başarısız',
                                            html: data.icon === 'error' ? data.message + detailsHtml : data.message,
                                            confirmButtonText: 'Tamam',
                                            allowEscapeKey: false,
                                            allowOutsideClick: false,
                                            icon: data.icon,
                                        });
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.log(xhr);
                                    console.log(status);
                                    console.log(error);
                                    Swal.fire({
                                        title: "Bir hata oluştu",
                                        text: "sistemsel bir hata. daha sonra tekrar deneyiniz.",
                                        confirmButtonText: "Tamam",
                                        allowEscapeKey: false,
                                        allowOutsideClick: false,
                                        icon: "error",
                                    })
                                },
                            });

                        } else if (result.isCancel) {
                            Swal.fire('Değişiklikler kaydedilmedi', '', 'info')
                        }
                    });

                } else {
                    console.log(response);
                    Swal.fire({
                        title: "İşlem Başarısız11",
                        text: response.message,
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "error",
                    })
                }
            },
        });
    });


 



        $('#modal_delete_stock_button').click(function (e) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.stocks.delete', $stock_item['stock_id']) ?>',
                dataType: 'json',
                async: true,
                success: function (response) {
                    if (response['icon'] == 'success') {
                        $("#trigger_stock_ok_button").trigger("click");
                    }
                }
            })
        });


        function temizleVeSayiyaCevir(sayiStr) {
    // Noktaları ve virgülleri temizleyip, sayıyı parseFloat ile dönüştürme
    return parseFloat(sayiStr.replace(/\./g, '').replace(',', '.'));
}

        $("#stokGuncelle").click(function(){

            Swal.fire({
    title: '<div style="font-size: 20px;"><b><?= $stock_item['stock_code'] ?> <br> <?= $stock_item["stock_title"] ?></b></div>',
    html: '<div style="font-size:20px; margin-top: 20px;"><b>Stokları güncellemek istiyor musunuz?</b></div>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, Güncelle',
    cancelButtonText: 'Hayır',
}).then((result) => {
    if (result.isConfirmed) {
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.faturalar.stokHesapla', $stock_item["stock_id"]) ?>',
            dataType: 'json',
            data: {},
            async: true,
           
            success: function (dataaa, data) {
                                  
    if (dataaa.icon != 'success') {
        Swal.fire({
            title: 'Hata',
            icon: 'info',
            html: dataaa.message,
            confirmButtonText: 'Kapat',
        });
    } else {
        let renk = "black";
let backrenk = "#a41313"; // Fazladan noktalı virgül kaldırıldı

// String sayıları kıyaslamadan önce parseFloat ile temizleyip sayıya çeviriyoruz
const totalPurchase = temizleVeSayiyaCevir(dataaa.message["total_purchase"]); // Alış
const remainingStock = temizleVeSayiyaCevir(dataaa.message["remaining_stock"]); // Kalan stok

// Eğer toplam alış kalan stoktan büyükse, yeşil yap
if (totalPurchase >= remainingStock) {
    renk = "white";  // Yazı rengi beyaz
    backrenk = "green";  // Arka plan rengi yeşil
} else {
    renk = "white";  // Yazı rengi beyaz
    backrenk = "#a41313";  // Arka plan rengi kırmızı
}
console.log("toplam_alis" + dataaa.message["total_purchase"] );
console.log("toplam_satis" + dataaa.message["remaining_stock"]);
Swal.fire({
    title: 'Stok Başarıyla Güncellendi',
    icon: 'success',
    html: 
        '<div style="text-align: left;">' + 
        '<table style="width: 100%; border-collapse: collapse; text-align: left;">' +
            '<thead>' +
                '<tr>' +
                    '<th style="border-bottom: 2px solid #ddd; padding: 8px;">Bilgi</th>' +
                    '<th style="border-bottom: 2px solid #ddd; padding: 8px;">Değer</th>' +
                '</tr>' +
            '</thead>' +
            '<tbody>' +
                '<tr>' +
                    '<td style="border-bottom: 1px solid #ddd; padding: 8px;">Ürün Adı</td>' +
                    '<td style="border-bottom: 1px solid #ddd; padding: 8px;">' + dataaa.message["stock_title"] + '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td style="border-bottom: 1px solid #ddd; padding: 8px;">Toplam Alış (Giriş)</td>' +
                    '<td style="border-bottom: 1px solid #ddd; padding: 8px;"><b>' + dataaa.message["total_purchase"] + ' ' + dataaa.message["buy_unit_name"] + '</b></td>' +
                '</tr>' +
                '<tr>' +
                    '<td style="border-bottom: 1px solid #ddd; padding: 8px;">Toplam Satış (Çıkış)</td>' +
                    '<td style="border-bottom: 1px solid #ddd; padding: 8px;"><b>' + dataaa.message["total_sales"] + ' ' + dataaa.message["sale_unit_name"] + '</b></td>' +
                '</tr>' +
                '<tr>' +
                    '<td style="border-bottom: 1px solid #ddd; padding: 8px;"><b>Kalan Stok</b></td>' +
                    '<td style="border-bottom: 1px solid #ddd; padding: 8px; background: ' + backrenk + '; color: ' + renk + ';"><b>' + dataaa.message["remaining_stock"] + ' ' + dataaa.message["buy_unit_name"] + '</b></td>' +
                '</tr>' +
            '</tbody>' +
        '</table>' +
        '</div>',
    showCancelButton: false,
    confirmButtonText: 'Kapat',
}).then(function () {
    location.reload(); // Sayfayı yenile
});
    }
},
            error: function (error) {
                Swal.fire({
                    title: 'Hata',
                    icon: 'error',
                    html: 'Stok güncelleme sırasında bir hata oluştu.',
                    confirmButtonText: 'Kapat',
                });
            }
        });

    }
});

});
</script>



<?= $this->endSection() ?>