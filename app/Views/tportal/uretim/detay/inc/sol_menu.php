<?php

$order_total = $order_item['production_total'];

$deadline_date = $order_item['deadline_date'];

switch ($order_item['status']) {
    case 'new':
        $statusText = 'Devam Ediyor';
        $statusTextColor = 'text-primary';
        $statusBgColor = 'bg-primary';
        break;
    case 'pending':
        $statusText = 'Hazırlanıyor';
        $statusTextColor = 'text-warning';
        $statusBgColor = 'bg-warning';
        break;
    case 'success':
        $statusText = 'Tamamlandı';
        $statusTextColor = 'text-success';
        $statusBgColor = 'bg-success';
        break;
    case 'failed':
        $statusText = 'İptal';
        $statusTextColor = 'text-danger';
        $statusBgColor = 'bg-danger';
        break;
}

if ($deadline_date >= date('Y-m-d')) {
    $deadlineDateTextColor = 'text-success';
    $deadlineDateBgColor = 'bg-success';
} else {
    $deadlineDateTextColor = 'text-danger';
    $deadlineDateBgColor = 'bg-danger';
}




helper('Helpers\number_format_helper');
?>

<div style="width:110px" class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
    <div class="card-inner-group" data-simplebar>
        <div class="card-inner">
            <div class="user-card">
                <div class="user-avatar sq <?= $statusBgColor ?>"><span><?= $order_item['stock_title'] == '' ? mb_substr($order_item['stock_title'], 0, 1) : mb_substr($order_item['stock_title'], 0, 1) ?></span></div>
                <div class="user-info">
                    <span class="lead-text"><?= $order_item['production_no'] ?></span>
                    <span class="sub-text"><?= $order_item['stock_title'] != '' ? $order_item['stock_title'] : $order_item['stock_title'] . " " . $order_item['stock_title'] ?></span>
                </div>

            </div><!-- .user-card -->
        </div><!-- .card-inner -->
        <div class="card-inner">
            <div class="row">
                <div class="col-12">
                    <div class="user-account-info py-0">
                        <h6 class="overline-title-alt"> Toplam Miktar</h6>
                        <div class="user-balance <?= $statusTextColor ?> pb-3"><strong><?= number_format($toplam_adet, 2, ',', '.') ?> <small class="currency currency-btc"></small></strong></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="user-account-info py-0">
                        <h6 class="overline-title-alt">Üretim Durumu</h6>
                        <span class="badge badge-sm badge-dim <?= $statusBgColor ?> <?= $statusTextColor ?> "><?= $statusText ?></span>
                        <span class="badge badge-dot badge-dot-xs bg-success"></span>
                    </div>
                </div>
                
                
           
            </div>

            <!-- <div class="row">
                <div class="col-md-6">
                    <div class="user-account-info py-0">
                        <h6 class="overline-title-alt">Tahsilat Toplamı</h6>
                        <div class="user-balance"><strong>1.000,00 <small class="currency currency-btc">€</small></strong></div>
                        <span class="badge badge-dot badge-dot-xs bg-success"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="user-account-info py-0">
                    <h6 class="overline-title-alt">Ön Ödeme Kalan <small></small></h6>
                        <div class="user-balance text-info">931,47 <small class="currency currency-btc">€</small></div>
                        <span class="badge badge-dot badge-dot-xs bg-success"></span>
                    </div>
                </div>
            </div> -->

        </div>
        <div class="card-inner p-0">
            <ul class="link-list-menu">
           
                <li <?= current_url(true)->getSegment(3) == "order-movements" ? 'class="active"' : "" ?>><a class="" href="<?= route_to('tportal.uretim.orderMovements', $order_item['production_id']) ?>"><em class="icon ni ni-list-thumb"></em><span>Üretim Hareketleri</span></a></li>
                <li><a data-bs-toggle="modal" data-bs-target="#mdl_siparisdurumguncelle"><em class="icon ni ni-list-check"></em><span>Üretim Durum Güncelle</span></a></li>
                <!--
                                <li <?= current_url(true)->getSegment(3) == "edit" ? 'class="active"' : "" ?>><a class="" href="<?= route_to('tportal.siparisler.edit', $order_item['production_id']) ?>"><em class="icon ni ni-edit"></em><span>Üretim Düzenle</span></a></li>
    
                <li><a data-bs-toggle="modal" data-bs-target="#mdl_siparisFaturalandir"><em class="icon ni ni-report-profit"></em><span>Siparişi Faturalandır</span></a></li>
                <li><a class="" href="<?= route_to('tportal.siparisler.quickOrderPrint', $order_item['production_id']) ?>" target="_blank"><em class="icon ni ni-printer"></em><span>Sipariş Fişi Yazdır</span></a></li>
                
                -->
                <li>
                    <a id="btn-uretim-sil" class="text-danger" data-id="<?= $order_item['production_id'] ?>" href="javascript:void(0);">
                        <em class="icon ni ni-trash text-danger"></em>
                        <span>Üretimi Sil</span>
                    </a>
                </li>
            </ul>
        </div><!-- .card-inner -->
    </div><!-- .card-inner-group -->
</div>

<!-- Sipariş Durum Güncelle Modal -->
<div class="modal fade" tabindex="-1" id="mdl_siparisdurumguncelle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Üretim Durum Güncelle</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter">
                    <div class="form-group">

                        <div class="form-control-wrap">
                            <select class="form-select form-select-lg js-select2 form-control" data-ui="lg" id="slct_order_status" satir="0" data-ui="lg" data-placeholder="Seçiniz">
                                <option></option>
                                <option value="new" <?= $order_item['production_status'] == 'new' ? "selected" : '' ?>>Devam Ediyor</option>
                                <option value="pending" <?= $order_item['production_status'] == 'pending' ? "selected" : '' ?>>Hazırlanıyor</option>
                                <option value="success" <?= $order_item['production_status'] == 'success' ? "selected" : '' ?>>Tamamlandı</option>
                                <option value="failed" <?= $order_item['production_status'] == 'failed' ? "selected" : '' ?>>İptal Edildi</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="updateOrderStatuss" class="btn btn-lg btn-primary">Kaydet</button>
            </div>
        </div>
    </div>
</div>


<!-- Siparişi Faturalandır Modal -->
<div class="modal fade" tabindex="-1" id="mdl_siparisFaturalandir">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-primary bg-transparent" style="font-size: 70px;"></em>
                    <h4 class="nk-modal-title">Siparişi Faturalandırmak İstediğinize<br>Emin misiniz?</h4>
                    <div class="nk-modal-action mb-5">
                        <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-primary" data-bs-dismiss="modal">Evet</a>
                    </div>
                    <div class="nk-modal-text">
                        <!-- <p class="lead">Bu sipariş ilgili müşteri için faturalandırılacaktır.</p> -->
                        <p class="text-soft">Bu sipariş ilgili müşteri için faturalandırılacaktır.</p>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>

<!-- Sipariş Sil Modal -->
<div class="modal fade" tabindex="-1" id="mdl_siparissil">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent" style="font-size: 70px;"></em>
                    <h4 class="nk-modal-title">Siparişi Silmek İstediğinize<br>Emin misiniz?</h4>
                    <div class="nk-modal-action mb-5">
                        <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger" data-bs-dismiss="modal">Evet</a>
                    </div>
                    <div class="nk-modal-text">
                        <p class="lead">Bu siparişi silmeniz için;<br>mevcut herhangi bir hareket olmamalıdır.</p>
                        <p class="text-soft">Silmeden önce lütfen yetkilinize danışınız.</p>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>

<?= $this->section('script') ?>

<script>
    $(document).on("click", "#updateOrderStatus", function(event) {
        var url = window.location.href;
        var lastSegment = url.split('/').filter(function(segment) {
            return segment !== ''; // Boş parçaları filtrele
        }).pop();

        var newOrderStatus = $('#slct_order_status').val();


        $('#mdl_siparisdurumguncelle').modal('hide');

        Swal.fire({
            title: 'Sipariş durumu güncelleniyor, lütfen bekleyiniz...',
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
            url: '<?= route_to('tportal.siparisler.setOrderStatus') ?>',
            data: {
                orderId: lastSegment,
                orderStatus: newOrderStatus
            },
            success: function(response) {
                console.log(response);
                let data = response;

                // swal.close();
                Swal.fire({
                        title: "İşlem Başarılı",
                        html: 'Sipariş durumu başarıyla güncellendi.',
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "success",
                    })
                    .then(function() {
                        window.location.reload();
                    });
            },
            error: function(error) {
                swal.close();
                console.log("err: " + error);
            }
        });
    });

  
    document.getElementById('btn-uretim-sil').addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Emin misiniz?',
        text: "Bu üretimi silmek istediğinize emin misiniz? Bu işlem geri alınamaz!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Evet, sil!',
        cancelButtonText: 'Vazgeç'
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX ile silme isteği gönder
            fetch('<?= route_to('tportal.uretim.uretimSil', $order_item["production_id"]) ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire(
                    data.icon === 'success' ? 'Silindi!' : 'Uyarı!',
                    data.message,
                    data.icon
                );
                if(data.icon === 'success'){
                    // Silme başarılıysa yönlendirme veya sayfa yenileme
                    setTimeout(function(){ window.location.href = '/tportal/production/list'; }, 1500);
                }
            });
        }
    })
});
</script>

<?= $this->endSection() ?>