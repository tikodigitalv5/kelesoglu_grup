<?php
$order_total = $offer_item['amount_to_be_paid'];
$order_money_unit_icon = $offer_item['money_icon'];
$validity_date = $offer_item['validity_date'];

switch ($offer_item['offer_status']) {
    case 'new':
        $statusText = 'Yeni Teklif';
        $statusTextColor = 'text-primary';
        $statusBgColor = 'bg-primary';
        break;
    case 'pending':
        $statusText = 'Teklif İnceleniyor';
        $statusTextColor = 'text-warning';
        $statusBgColor = 'bg-warning';
        break;
    case 'success':
        $statusText = 'Teklif Kabul Edildi';
        $statusTextColor = 'text-success';
        $statusBgColor = 'bg-success';
        break;
    case 'failed':
        $statusText = 'Teklif Reddelidi';
        $statusTextColor = 'text-danger';
        $statusBgColor = 'bg-danger';
        break;
    default:
        $statusText = '-';
        $statusTextColor = 'text-secondary';
        $statusBgColor = 'bg-secondary';
        break;
}

if ($validity_date >= date('Y-m-d')) {
    $deadlineDateTextColor = 'text-success';
    $deadlineDateBgColor = 'bg-success';
} else {
    $deadlineDateTextColor = 'text-danger';
    $deadlineDateBgColor = 'bg-danger';
}

helper('Helpers\number_format_helper');
?>

<div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
    <div class="card-inner-group" data-simplebar>
        <div class="card-inner">
            <div class="user-card">
                <div class="user-avatar sq <?= $statusBgColor ?>"><span><?= $offer_item['cari_invoice_title'] == '' ? mb_substr($offer_item['cari_name'], 0, 1) : mb_substr($offer_item['cari_invoice_title'], 0, 1) ?></span></div>
                <div class="user-info">
                    <span class="lead-text"><?= $offer_item['offer_no'] ?></span>
                    <span class="sub-text"><?= $offer_item['cari_invoice_title'] != '' ? $offer_item['cari_invoice_title'] : $offer_item['cari_name'] . " " . $offer_item['cari_surname'] ?></span>
                </div>

            </div><!-- .user-card -->
        </div><!-- .card-inner -->
        <div class="card-inner">
            <div class="row">
                <div class="col-6">
                    <div class="user-account-info py-0">
                        <h6 class="overline-title-alt">Teklif Tutarı</h6>
                        <div class="user-balance <?= $statusTextColor ?> pb-3"><strong><?= number_format($offer_item['amount_to_be_paid'], 2, ',', '.') ?> <small class="currency currency-btc"><?= $offer_item['money_icon'] ?></small></strong></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="user-account-info py-0">
                        <h6 class="overline-title-alt">Teklif Durumu</h6>
                        <span class="badge badge-sm badge-dim <?= $statusBgColor ?> <?= $statusTextColor ?> "><?= $statusText ?></span>
                        <span class="badge badge-dot badge-dot-xs bg-success"></span>
                    </div>
                </div>
                <?php if ($offer_item['is_validity'] == 1) { ?>
                    <div class="col-12">
                        <div class="user-account-info pt-2">
                            <h6 class="overline-title-alt">Teklif Geçerlilik Tarihi</h6>
                            <span class="badge badge-sm badge-dim <?= $deadlineDateTextColor ?> <?= $deadlineDateBgColor ?> "><?= convert_date_for_view($offer_item['validity_date']) ?></span>
                            <span class="badge badge-dot badge-dot-xs bg-success"></span>
                        </div>
                    </div>
                <?php } ?>


                <div class="col-6 d-none">
                    <div class="user-account-info pt-2">
                        <h6 class="overline-title-alt">Teklif Veren</h6>
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
            <li><a <?= current_url(true)->getSegment(3) == "offer-movements" ? 'class="active"' : "yok" ?> class="" href="<?= route_to('tportal.cariler.offer_movements', $offer_item['cari_id']) ?>"><em class="icon ni ni-folder-list"></em><span>Carinin Tüm Teklifleri</span></a></li>
                <li <?= current_url(true)->getSegment(3) == "detail" ? 'class="active"' : "" ?>><a class="" href="<?= route_to('tportal.teklifler.detail', $offer_item['offer_id']) ?>"><em class="icon ni ni-layers"></em><span>Teklif Kalemleri</span></a></li>
                <li style="pointer-events:none; opacity:0.6;"><a class="" href="<?= route_to('tportal.teklifler.orderMovements', $offer_item['offer_id']) ?>"><em class="icon ni ni-list-thumb"></em><span>Teklif Hareketleri</span></a></li>
                <li <?= current_url(true)->getSegment(3) == "edit" ? 'class="active"' : "" ?>><a class="" href="<?= route_to('tportal.teklifler.edit', $offer_item['offer_id']) ?>"><em class="icon ni ni-edit"></em><span>Teklif Düzenle</span></a></li>
                <li><a data-bs-toggle="modal" data-bs-target="#mdl_teklifdurumguncelle"><em class="icon ni ni-list-check"></em><span>Teklif Durum Güncelle</span></a></li>
           


                     
                <?php
                        if($offer_item["offer_status"] == "success"){ ?>
                                   <?php if(isset($faturaVarmi)): ?>
                    <li><a href="<?= route_to('tportal.faturalar.detail', $faturaVarmi['invoice_id']) ?>" target="_blank"><em class="icon ni ni-report-profit"></em><span>Faturayı Görüntüle</span></a></li>

               <?php else: ?>
                <li><a data-bs-toggle="modal" data-bs-target="#mdl_siparisFaturalandir"><em class="icon ni ni-report-profit"></em><span>Teklifi Faturalandır</span></a></li>

                <?php endif; ?>
                      <?php   }else{ ?> 
                        <?php if(isset($faturaVarmi)): ?>
                    <li><a href="<?= route_to('tportal.faturalar.detail', $faturaVarmi['invoice_id']) ?>" target="_blank"><em class="icon ni ni-report-profit"></em><span>Faturayı Görüntüle</span></a></li>

               <?php else: ?>
                <li><a class="sevk_yoks"><em class="icon ni ni-report-profit"></em><span>Teklifi Faturalandır</span></a></li>

                <?php endif; ?>
                       <?php  }

                     ?>


                <li style=""><a class="" target="_blank" href="<?= route_to('tportal.teklifler.teklifYazdir', $offer_item['offer_id']) ?>"><em class="icon ni ni-printer"></em><span>Teklif Fişi Yazdır</span></a></li>
                <?php if($offer_item["offer_status"] == "success"){ ?> 
                    <li><a  class=" text-danger teklifSilEngelle"><em class="icon ni ni-trash text-danger"></em><span>Teklif Sil</span></a></li>

                <?php }else{ ?> 
                
                    <li><a data-bs-toggle="modal" data-bs-target="#mdl_teklifsil" class=" text-danger"><em class="icon ni ni-trash text-danger"></em><span>Teklif Sil</span></a></li>

                <?php } ?> 

            </ul>
        </div><!-- .card-inner -->
    </div><!-- .card-inner-group -->
</div>

<!-- Teklif Durum Güncelle Modal -->
<div class="modal fade" tabindex="-1" id="mdl_teklifdurumguncelle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Teklif Durum Güncelle</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter">
                    <div class="form-group">

                        <div class="form-control-wrap">
                            <select class="form-select form-select-lg js-select2 form-control" data-ui="lg" id="slct_offer_status" satir="0" data-ui="lg" data-placeholder="Seçiniz">
                                <option></option>
                                <option value="new" <?= $offer_item['offer_status'] == 'new' ? "selected" : '' ?>>Yeni Teklif</option>
                                <option value="pending" <?= $offer_item['offer_status'] == 'pending' ? "selected" : '' ?>>Teklif İnceleniyor</option>
                                <option value="success" <?= $offer_item['offer_status'] == 'success' ? "selected" : '' ?>>Teklif Kabul Edildi</option>
                                <option value="failed" <?= $offer_item['offer_status'] == 'failed' ? "selected" : '' ?>>Teklif Reddelidi</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <?php if($offer_item['offer_status'] == 'success'){ ?> 
                    <button id="updateNot" class="updateNot btn btn-lg btn-primary">Kaydet</button>

                <?php }else if($offer_item['offer_status'] == 'failed'){ ?> 
                    <button id="updateNots" class="updateNots btn btn-lg btn-primary">Kaydet</button>

                <?php }else { ?> 
                    <button id="updateOfferStatus" class="btn btn-lg btn-primary">Kaydet</button>

                    
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="mdl_siparisFaturalandir">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-primary bg-transparent" style="font-size: 70px;"></em>
                    <h4 class="nk-modal-title">Teklif Formunu Faturalandırmak İstediğinize<br>Emin misiniz?</h4>
                    <div class="nk-modal-action mb-5">
                        <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                        <a href="<?= route_to('tportal.teklif_create', $offer_item['offer_id']) ?>" class="btn btn-lg btn-mw btn-primary" >Evet</a>
                    </div>
                    <div class="nk-modal-text">
                        <!-- <p class="lead">Bu sipariş ilgili müşteri için faturalandırılacaktır.</p> -->
                        <p class="text-soft">Bu teklif formu ilgili müşteri için faturalandırılacaktır.</p>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>

<!-- Teklif Sil Modal -->
<div class="modal fade" tabindex="-1" id="mdl_teklifsil">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent" style="font-size: 70px;"></em>
                    <h4 class="nk-modal-title">Teklifi Silmek İstediğinize<br>Emin misiniz?</h4>
                    <div class="nk-modal-action mb-5">
                        <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger teklifSil" data-teklifid="<?php echo $offer_item['offer_id'];  ?>">Evet</a>
                    </div>
                    <div class="nk-modal-text">
                        <p class="lead">Bu teklifi silmeniz için;<br>mevcut herhangi bir hareket olmamalıdır.</p>
                        <p class="text-soft">Silmeden önce lütfen yetkilinize danışınız.</p>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>

<?= $this->section('script') ?>

<script>
    
    $(document).on("click", ".teklifSilEngelle", function(event) {
            
            Swal.fire({
                        title: "Bilgilendirme",
                        html: '<b>Teklif Durumu <span class="text-success ">Teklif Kabul Edildi</span> Olan Teklifler Silinmemektedir!</b>',
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "info",
                    })

        });

      $(document).on("click", ".sevk_yoks", function(event) {
            
            Swal.fire({
                        title: "Bilgilendirme",
                        html: '<b>Teklif Formunu Faturalandırabilmek için <br> Teklif Durumu <span class="text-success ">Teklif Kabul Edildi</span>  Olması Gerekmektedir.</b>',
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "info",
                    })

        });

        $(document).on("click", ".updateNot", function(event) {

            $("#mdl_teklifdurumguncelle").modal("hide");
            
            Swal.fire({
                        title: "Bilgilendirme",
                        html: '<b>Teklif Durumu <span class="text-success ">Teklif Kabul Edildi</span> olan durum değiştirilemez!</b>',
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "info",
                    })

        });

        $(document).on("click", ".updateNots", function(event) {

$("#mdl_teklifdurumguncelle").modal("hide");

Swal.fire({
            title: "Bilgilendirme",
            html: '<b>Teklif Durumu <span class="text-danger ">Teklif Reddelidi</span> olan durum değiştirilemez!</b>',
            confirmButtonText: "Tamam",
            allowEscapeKey: false,
            allowOutsideClick: false,
            icon: "info",
        })

});




        
    $(document).on("click", "#updateOfferStatus", function(event) {
        var url = window.location.href;
        var lastSegment = url.split('/').filter(function(segment) {
            return segment !== ''; // Boş parçaları filtrele
        }).pop();

        var newOfferStatus = $('#slct_offer_status').val();


        $('#mdl_teklifdurumguncelle').modal('hide');

        Swal.fire({
            title: 'Teklif durumu güncelleniyor, lütfen bekleyiniz...',
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
            url: '<?= route_to('tportal.teklifler.setOfferStatus') ?>',
            data: {
                offerId: lastSegment,
                offerStatus: newOfferStatus
            },
            success: function(response) {
                console.log(response);
                let data = response;

                // swal.close();
                Swal.fire({
                        title: "İşlem Başarılı",
                        html: 'Teklif durumu başarıyla güncellendi.',
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

    $(document).on("click", ".teklifSil", function(event) {
        var url = window.location.href;
        var lastSegment = url.split('/').filter(function(segment) {
            return segment !== ''; // Boş parçaları filtrele
        }).pop();

        var teklifId = $(this).attr("data-teklifid");
        $('#mdl_teklifsil').modal('hide');

        Swal.fire({
            title: 'Teklif siliniyor, lütfen bekleyiniz...',
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
            url: '<?= base_url('tportal/offer/delete') ?>/' +  teklifId,
            data: {
              },
            success: function(response) {
                console.log(response);
                let data = response;

                // swal.close();
                Swal.fire({
                        title: "İşlem Başarılı",
                        html: 'Teklif  başarıyla silindi.',
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "success",
                    })
                    .then(function() {
                        window.location.href='<?php echo base_url("tportal/offer/list/all") ?>';
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