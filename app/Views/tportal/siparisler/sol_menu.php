<?php
$order_total = $order_item['amount_to_be_paid'];
$order_money_unit_icon = $order_item['money_icon'];
$deadline_date = $order_item['deadline_date'];
$order_direction = $order_item['order_direction'];

switch ($order_item['order_status']) {
    case 'new':
        $statusText = 'Yeni Sipariş';
        $statusTextColor = 'text-primary';
        $statusBgColor = 'bg-primary';
        break;
        case 'sevk_emri':
            $statusText = 'Sevk Emri Verildi';
            $statusTextColor = 'text-primary';
            $statusBgColor = 'bg-primary';
            break;
    case 'pending':
        $statusText = 'Hazırlanıyor';
        $statusTextColor = 'text-warning';
        $statusBgColor = 'bg-warning';
        break;
    case 'success':
        $statusText = 'Teslim Edildi';
        $statusTextColor = 'text-success';
        $statusBgColor = 'bg-success';
        break;
        case 'sevk_edildi':
            $statusText = 'Sevk Edildi';
            $statusTextColor = 'text-success';
            $statusBgColor = 'bg-success';
            break;
    case 'failed':
        $statusText = 'İptal';
        $statusTextColor = 'text-danger';
        $statusBgColor = 'bg-danger';
        break;
    case 'tenik_hata':
        $statusText = 'Tenkik Hata';
        $statusTextColor = 'text-danger';
        $statusBgColor = 'bg-danger';
        break;
    case 'stokta_yok':
        $statusText = 'Stokta Yok';
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

if ($order_direction == 'incoming') {
    $order_directionText = 'Alınan Sipariş';
    $order_directionTextColor = 'text-success';
    $order_directionBgColor = 'bg-success';
} else {
    $order_directionText = 'Verilen Sipariş';
    $order_directionTextColor = 'text-primary';
    $order_directionBgColor = 'bg-primary';
}


helper('Helpers\number_format_helper');
?>

<div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
    <div class="card-inner-group" data-simplebar>
        <div class="card-inner">
            <div class="user-card">
                <div class="user-avatar sq <?= $statusBgColor ?>"><span><?= $order_item['cari_invoice_title'] == '' ? mb_substr($order_item['cari_name'], 0, 1) : mb_substr($order_item['cari_invoice_title'], 0, 1) ?></span></div>
                <div class="user-info">
                    <span class="lead-text"><?= $order_item['order_no'] ?></span>
                    <span class="sub-text"><?= $order_item['cari_invoice_title'] != '' ? $order_item['cari_invoice_title'] : $order_item['cari_name'] . " " . $order_item['cari_surname'] ?></span>
                </div>

            </div><!-- .user-card -->
        </div><!-- .card-inner -->
        <div class="card-inner">
            <div class="row">
                <div class="col-6">
                    <div class="user-account-info py-0">
                        <h6 class="overline-title-alt">Sipariş Tutarı</h6>
                        <div class="user-balance <?= $statusTextColor ?> pb-3"><strong><?= number_format($order_item['amount_to_be_paid'], 2, ',', '.') ?> <small class="currency currency-btc"><?= $order_item['money_icon'] ?></small></strong></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="user-account-info py-0">
                        <h6 class="overline-title-alt">Sipariş Durumu</h6>
                        <span class="badge badge-sm badge-dim <?= $statusBgColor ?> <?= $statusTextColor ?> "><?= $statusText ?></span>
                        <span class="badge badge-dot badge-dot-xs bg-success"></span>
                    </div>
                </div>
                <?php if ($order_item['is_deadline'] == 1) { ?>
                    <div class="col-6">
                        <div class="user-account-info pt-2">
                            <h6 class="overline-title-alt">Termin Tarihi</h6>
                            <span class="badge badge-sm badge-dim <?= $deadlineDateTextColor ?> <?= $deadlineDateBgColor ?> "><?= convert_date_for_view($order_item['deadline_date']) ?></span>
                            <span class="badge badge-dot badge-dot-xs bg-success"></span>
                        </div>
                    </div>
                <?php } ?>




                <?php if(isset($order_item["b2b"])): ?>
                <div class="col-12">
                    <div class="user-account-info pt-2">
                        <h6 class="overline-title-alt">İşlem Detayları</h6>
                        <div class="alert alert-primary " style="padding: 10px; margin-top: 0;">   
                        <?php if(isset($order_item["service_name"])): ?>

                                <div style="display:flex; align-items:center;">
                                    <div><img style="height:30px; margin-right: 10px;" src="<?php echo $order_item["service_logo"] ?>" alt="<?php echo $order_item["service_name"]; ?>"> </div>
                                    <div style="font-size:18px; line-height:18px; text-transform:uppercase"><?php echo $order_item["service_name"]; ?></div>
                                </div>

                        <?php endif;  ?>

                            
                                        <p><?php echo $order_item["b2b"]; ?> </p>    
                </div>

                  
                    </div>
                </div>
                <?php else: ?>
                    <div class="col-6">
                    <div class="user-account-info pt-2">
                        <h6 class="overline-title-alt">Sipariş Türü</h6>
                        <span class="badge badge-sm badge-dim <?= $order_directionBgColor ?> <?= $order_directionTextColor ?> "><?= $order_directionText ?></span>
                        <span class="badge badge-dot badge-dot-xs bg-success"></span>
                    </div>
                </div>

                <?php endif; ?>

                <div class="col-md-6 d-none">
                    <div class="user-account-info py-0">
                        <h6 class="overline-title-alt">Ön Ödeme <small><strong>(%25)</strong></small></h6>
                        <div class="user-balance text-secondary">0,00 <small class="currency currency-btc">₺</small></div>
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
                <li <?= current_url(true)->getSegment(3) == "detail" ? 'class="active"' : "" ?>><a class="" href="<?= route_to('tportal.siparisler.detail', $order_item['order_id']) ?>"><em class="icon ni ni-layers"></em><span>Sipariş Kalemleri</span></a></li>
                <li <?= current_url(true)->getSegment(3) == "order-movements" ? 'class="active"' : "" ?>><a class="" href="<?= route_to('tportal.siparisler.orderMovements', $order_item['order_id']) ?>"><em class="icon ni ni-list-thumb"></em><span>Sipariş Hareketleri</span></a></li>
                <li <?= current_url(true)->getSegment(3) == "edit" ? 'class="active"' : "" ?>><a class="" href="<?= route_to('tportal.siparisler.edit', $order_item['order_id']) ?>"><em class="icon ni ni-edit"></em><span>Sipariş Düzenle</span></a></li>
                <li><a data-bs-toggle="modal" data-bs-target="#mdl_siparisdurumguncelle"><em class="icon ni ni-list-check"></em><span>Sipariş Durum Güncelle</span></a></li>
                <input type="hidden" name="eski_durum" id ="eski_durum" value="<?php echo $order_item["order_status"]; ?>">
                
                <?php if(session()->get('user_item')['user_id'] == 1){
                        if($order_item["order_status"] == "sevk_edildi"){ ?>
                                   <?php if(isset($faturaVarmi)): ?>
                    <li><a href="<?= route_to('tportal.faturalar.detail', $faturaVarmi['invoice_id']) ?>" target="_blank"><em class="icon ni ni-report-profit"></em><span>Faturayı Görüntüle</span></a></li>

               <?php else: ?>
                <li><a data-bs-toggle="modal" data-bs-target="#mdl_siparisFaturalandir"><em class="icon ni ni-report-profit"></em><span>Siparişi Faturalandır</span></a></li>

                <?php endif; ?>
                      <?php   }else{ ?> 
                        <?php if(isset($faturaVarmi)): ?>
                    <li><a href="<?= route_to('tportal.faturalar.detail', $faturaVarmi['invoice_id']) ?>" target="_blank"><em class="icon ni ni-report-profit"></em><span>Faturayı Görüntüle</span></a></li>

               <?php else: ?>
                <li><a class="sevk_yoks"><em class="icon ni ni-report-profit"></em><span>Siparişi Faturalandır</span></a></li>

                <?php endif; ?>
                       <?php  }

                      }else{ ?>
                             <?php if(isset($faturaVarmi)): ?>
                    <li><a href="<?= route_to('tportal.faturalar.detail', $faturaVarmi['invoice_id']) ?>" target="_blank"><em class="icon ni ni-report-profit"></em><span>Faturayı Görüntüle</span></a></li>

               <?php else: ?>
                <li><a data-bs-toggle="modal" data-bs-target="#mdl_siparisFaturalandir"><em class="icon ni ni-report-profit"></em><span>Siparişi Faturalandır</span></a></li>

                <?php endif; ?>
                      <?php } ?>
                

         
                <?php if(session()->get('user_item')['user_id'] == 1){
                        if($order_item["order_status"] == "sevk_edildi"){
                            $url = route_to('tportal.siparisler.sevkSiparisYazdir', $order_item['order_id']);
                            $modal="";
                        }else{
                            $url = "";
                            $modal = "sevk_yok";
                        }
                    ?>
                    <li><a class="<?php echo $modal; ?>" <?php if(!empty($url)){ ?> href="<?= $url ?>" <?php }  ?><?php if(!empty($url)) { echo 'target="_blank"'; } ?>><em class="icon ni ni-printer"></em><span>Sipariş Fişi Yazdır</span></a></li>

                <?php }else{?>
                    <li><a class="" href="<?= route_to('tportal.siparisler.quickOrderPrint', $order_item['order_id']) ?>" target="_blank"><em class="icon ni ni-printer"></em><span>Sipariş Fişi Yazdır</span></a></li>

                    <?php } ?> 
                <li><a data-bs-toggle="modal" data-bs-target="#mdl_siparissil" class=" text-danger"><em class="icon ni ni-trash text-danger"></em><span>Sipariş Sil</span></a></li>

            </ul>
        </div><!-- .card-inner -->
    </div><!-- .card-inner-group -->
</div>

<!-- Sipariş Durum Güncelle Modal -->
<div class="modal fade" tabindex="-1" id="mdl_siparisdurumguncelle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sipariş Durum Güncelle</h5>
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
                                <option value="new" <?= $order_item['order_status'] == 'new' ? "selected" : '' ?>>Yeni Sipraiş</option>
                                <option value="pending" <?= $order_item['order_status'] == 'pending' ? "selected" : '' ?>>Hazırlanıyor</option>
                                <option value="success" <?= $order_item['order_status'] == 'success' ? "selected" : '' ?>>Tamamlandı</option>
                                <option value="failed" <?= $order_item['order_status'] == 'failed' ? "selected" : '' ?>>İptal Edildi</option>
                                <option value="sevk_emri" <?= $order_item['order_status'] == 'sevk_emri' ? "selected" : '' ?>>Sevk Emri Verildi</option>
                                <option value="sevk_edildi" <?= $order_item['order_status'] == 'sevk_edildi' ? "selected" : '' ?>>Sevk Edildi</option>
                                <option value="teknik_hata" <?= $order_item['order_status'] == 'teknik_hata' ? "selected" : '' ?>>Teknik Hata</option>
                                <option value="stokta_yok" <?= $order_item['order_status'] == 'stokta_yok' ? "selected" : '' ?>>Stokta Yok</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="updateOrderStatus" class="btn btn-lg btn-primary">Kaydet</button>
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
                        <a href="<?= route_to('tportal.siparis_create', $order_item['order_id']) ?>" class="btn btn-lg btn-mw btn-primary" >Evet</a>
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
        $(document).on("click", ".sevk_yok", function(event) {
            
            Swal.fire({
                        title: "Bilgilendirme",
                        html: '<b>Fiş Yazdırabilmek için <br> Sipariş Durumu <span class="text-success ">Sevk  Edildi</span>  Olması Gerekmektedir.</b>',
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "info",
                    })

        });

        $(document).on("click", ".sevk_yoks", function(event) {
            
            Swal.fire({
                        title: "Bilgilendirme",
                        html: '<b>Siparişi Faturalandırabilmek için <br> Sipariş Durumu <span class="text-success ">Sevk  Edildi</span>  Olması Gerekmektedir.</b>',
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "info",
                    })

        });
    $(document).on("click", "#updateOrderStatus", function(event) {
        var url = window.location.href;
        var lastSegment = url.split('/').filter(function(segment) {
            return segment !== ''; // Boş parçaları filtrele
        }).pop();

        var newOrderStatus = $('#slct_order_status').val();
        var eski_durum = $('#eski_durum').val();

        if(eski_durum == "sevk_edildi" || eski_durum == "success" || eski_durum == "failed")
        {
            $("#mdl_siparisdurumguncelle").modal("hide");
            Swal.fire({
                        title: "Bilgilendirme",
                        html: '<b>Sevk Edildi, Teslim Edildi ve İptal Olan Siparişlerin Durumu Değiştirilemez.</b>', 
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "info",
                    });
                    return false;
        } 

        


        


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
</script>

<?= $this->endSection() ?>