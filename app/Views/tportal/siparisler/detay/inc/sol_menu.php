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
    case 'teknik_hata':
        $statusText = 'Tenkik Hata';
        $statusTextColor = 'text-danger';
        $statusBgColor = 'bg-danger';
        break;
    case 'stokta_yok':
        $statusText = 'Stokta Yok';
        $statusTextColor = 'text-danger';
        $statusBgColor = 'bg-danger';
        break;
    case 'kargolandi':
    $statusText = 'Kargolandı';
    $statusTextColor = 'text-success';
    $statusBgColor = 'bg-success';
    break;
    case 'kargo_bekliyor':
    $statusText = 'Kargo Bekliyor';
    $statusTextColor = 'text-warning';
    $statusBgColor = 'bg-warning';
    break;
    case 'yetistirilemedi':
    $statusText = 'Yetiştirilemedi';
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

                <?php if ($order_item['service_name'] != '') { ?>
                    <div class="col-6" style=" align-items: center; display: flex;">
                        <div class="user-account-info pt-2">
                            <h6 class="overline-title-alt">PLATFORM</h6>
                            <div style="font-size:18px; line-height:18px; text-transform:uppercase"><img style="height:30px; margin-right: 10px;" src="<?php echo $order_item["service_logo"] ?>" alt="<?php echo $order_item["service_name"]; ?>"><b style="    font-size: 16px;"> <?php echo $order_item["service_name"]; ?></b> </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($order_item['kargo'] != '') { ?>
                    <div class="col-6" style="align-items: center; display: flex;">
                        <div class="user-account-info pt-2">
                            <h6 class="overline-title-alt">KARGO</h6>
                            <?php echo KargoLogo($order_item["kargo"]) ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($order_item['order_status'] == 'kargolandi') { ?>
                    <div class="col-6" style="align-items: center; display: flex;">
                        <div class="user-account-info pt-2">
                            <h6 class="overline-title-alt">KARGO TARİHİ</h6>
                           <h6> <b><?php 
                           if(empty($order_item['shipped_date'])){
                            $date = new DateTime($order_item['updated_at']);

                           // Tarihi istediğiniz formata dönüştür
                           $formattedDate = $date->format('Y-m-d H:i:s');
                          echo $formattedDate;
                           }else{
                           $date = new DateTime($order_item['shipped_date']);

                           // Tarihi istediğiniz formata dönüştür
                           $formattedDate = $date->format('Y-m-d H:i:s');
                          echo $formattedDate; } ?></b></h6>
                        </div>
                    </div>
                    <div class="col-6" style="align-items: center; display: flex;">
                        <div class="user-account-info pt-2">
                            <h6 class="overline-title-alt">KARGO NUMARASI</h6>
                           <h6> <b><?php echo $order_item["kargo_kodu"] ?? "" ?></b></h6>
                        </div>
                    </div>
                <?php } ?>




                <?php if(isset($order_item["b2b"])): ?>
                <div class="col-12">
                    <div class="user-account-info pt-2">
                        <h6 class="overline-title-alt">İşlem Detayları</h6>
                        <div class="alert alert-primary " style="padding: 10px; margin-top: 0; padding-top:0">   
                       

                            
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
                <?php if(session()->get('user_item')['user_id'] == 5){ ?>
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#mdl_siparisCariDegistir"><em class="icon ni ni-report-profit"></em><span>Sipariş Cari Değiştir</span></a></li>

                <?php } ?>
                <li <?= current_url(true)->getSegment(3) == "detail" ? 'class="active"' : "" ?>><a class="" href="<?= route_to('tportal.siparisler.detail', $order_item['order_id']) ?>"><em class="icon ni ni-layers"></em><span>Sipariş Kalemleri</span></a></li>
                <li <?= current_url(true)->getSegment(3) == "order-movements" ? 'class="active"' : "" ?>><a class="" href="<?= route_to('tportal.siparisler.orderMovements', $order_item['order_id']) ?>"><em class="icon ni ni-list-thumb"></em><span>Sipariş Hareketleri</span></a></li>
                <li <?= current_url(true)->getSegment(3) == "loglar" ? 'class="active"' : "" ?>><a class="" href="<?= route_to('tportal.siparisler.loglar', $order_item['order_id']) ?>"><em class="icon ni ni-file-code"></em><span>Sipariş Logları</span></a></li>
                <li <?= current_url(true)->getSegment(3) == "edit" ? 'class="active"' : "" ?>><a class="" href="<?= route_to('tportal.siparisler.edit', $order_item['order_id']) ?>"><em class="icon ni ni-edit"></em><span>Sipariş Düzenle</span></a></li>
                <li><a data-bs-toggle="modal" data-bs-target="#mdl_siparisdurumguncelle"><em class="icon ni ni-list-check"></em><span>Sipariş Durum Güncelle</span></a></li>
                <input type="hidden" name="eski_durum" id ="eski_durum" value="<?php echo $order_item["order_status"]; ?>">
                
                <?php if(session()->get('user_item')['user_id'] == 1){
                        if($order_item["order_status"] == "sevk_edildi" || $order_item["order_status"] == "kargolandi"){ ?>
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
                                <option value="kargo_bekliyor" <?= $order_item['order_status'] == 'kargo_bekliyor' ? "selected" : '' ?>>Kargo Bekliyor</option>

                                <option value="kargolandi" <?= $order_item['order_status'] == 'kargolandi' ? "selected" : '' ?>>Kargolandı</option>
                                <option value="yetistirilemedi" <?= $order_item['order_status'] == 'yetistirilemedi' ? "selected" : '' ?>>Yetiştirilemedi</option>
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

<!-- Sipariş Cari Değiştir Modal -->
<div class="modal fade" tabindex="-1" id="mdl_siparisCariDegistir">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sipariş Cari Değiştir</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="current_cari">Mevcut Cari</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="current_cari" value="<?= $order_item['cari_invoice_title'] ?: ($order_item['cari_name'] . ' ' . $order_item['cari_surname']) ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="current_cari_phone">Mevcut Telefon</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="current_cari_phone" value="<?= $order_item['cari_phone'] ?: 'Telefon bilgisi yok' ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="new_cari_search">Yeni Cari Seç</label>
                    <div class="form-control-wrap">
                        <div class="form-icon form-icon-left">
                            <em class="icon ni ni-search"></em>
                        </div>
                        <input type="text" class="form-control" id="new_cari_search" placeholder="Cari adı, telefon veya vergi numarası ile arayın...">
                    </div>
                </div>
                
                <div class="form-group" id="cari_results_container" style="display: none;">
                    <label class="form-label">Bulunan Cariler</label>
                    <div class="form-control-wrap">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="cari_results_table">
                                <thead>
                                    <tr>
                                        <th>Seç</th>
                                        <th>Cari Adı</th>
                                        <th>Telefon</th>
                                        <th>Vergi No</th>
                                        <th>Bakiye</th>
                                    </tr>
                                </thead>
                                <tbody id="cari_results_body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="form-group" id="selected_cari_info" style="display: none;">
                    <label class="form-label">Seçilen Cari Bilgileri</label>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Cari Adı:</strong> <span id="selected_cari_name"></span><br>
                                    <strong>Telefon:</strong> <span id="selected_cari_phone"></span><br>
                                    <strong>E-posta:</strong> <span id="selected_cari_email"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Vergi No:</strong> <span id="selected_cari_tax"></span><br>
                                    <strong>Bakiye:</strong> <span id="selected_cari_balance"></span><br>
                                    <strong>Adres:</strong> <span id="selected_cari_address"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" id="updateOrderCari" disabled>Güncelle</button>
            </div>
        </div>
    </div>
</div>

<?= $this->section('script') ?>

<script>
        $(document).on("click", ".sevk_yok", function(event) {
            
            Swal.fire({
                        title: "Bilgilendirme",
                        html: '<b>Fiş Yazdırabilmek için <br> Sipariş Durumu <span class="text-success ">Sevk  Edildi</span>   Olması Gerekmektedir.</b>',
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

    // Sipariş Cari Değiştir Modal JavaScript
    $(document).ready(function() {
        let selectedCariId = null;
        let searchTimeout = null;

        // Cari arama fonksiyonu
        $('#new_cari_search').on('input', function() {
            const searchTerm = $(this).val().trim();
            
            // Önceki timeout'u temizle
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }
            
            // 3 karakterden az ise arama yapma
            if (searchTerm.length < 3) {
                $('#cari_results_container').hide();
                $('#selected_cari_info').hide();
                $('#updateOrderCari').prop('disabled', true);
                return;
            }
            
            // 500ms bekle ve arama yap
            searchTimeout = setTimeout(function() {
                searchCariler(searchTerm);
            }, 500);
        });

        // Cari arama AJAX fonksiyonu
        function searchCariler(searchTerm) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.siparisler.searchCariler') ?>',
                data: {
                    search: searchTerm
                },
                success: function(response) {
                    // Response string ise parse et
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }
                    
                    console.log('Cari arama response:', response); // Debug için
                    
                    if (response.success && response.data.length > 0) {
                        displayCariResults(response.data);
                    } else {
                        $('#cari_results_container').hide();
                        $('#cari_results_body').html('<tr><td colspan="5" class="text-center">Cari bulunamadı</td></tr>');
                        $('#cari_results_container').show();
                    }
                },
                error: function() {
                    Swal.fire({
                        title: "Hata",
                        text: "Cari arama sırasında bir hata oluştu.",
                        icon: "error",
                        confirmButtonText: "Tamam"
                    });
                }
            });
        }

        // Cari sonuçlarını tabloda göster
        function displayCariResults(cariler) {
            let html = '';
            cariler.forEach(function(cari) {
                const cariAdi = cari.invoice_title || (cari.name + ' ' + cari.surname).trim();
                html += `
                    <tr>
                        <td>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="cari_${cari.cari_id}" name="selected_cari" class="custom-control-input" value="${cari.cari_id}">
                                <label class="custom-control-label" for="cari_${cari.cari_id}"></label>
                            </div>
                        </td>
                        <td>${cariAdi}</td>
                        <td>${cari.cari_phone || '-'}</td>
                        <td>${cari.identification_number || '-'}</td>
                        <td>${formatCurrency(cari.cari_balance)}</td>
                    </tr>
                `;
            });
            
            $('#cari_results_body').html(html);
            $('#cari_results_container').show();
        }

        // Cari seçimi
        $(document).on('change', 'input[name="selected_cari"]', function() {
            selectedCariId = $(this).val();
            const cariId = $(this).val();
            
            // Seçilen cari bilgilerini getir
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.siparisler.getCariDetails') ?>',
                data: {
                    cari_id: cariId
                },
                success: function(response) {
                    // Response string ise parse et
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }
                    
                    console.log('Cari detay response:', response); // Debug için
                    
                    if (response.success) {
                        const cari = response.data;
                        displaySelectedCari(cari);
                        $('#updateOrderCari').prop('disabled', false);
                    }
                },
                error: function() {
                    Swal.fire({
                        title: "Hata",
                        text: "Cari bilgileri alınırken bir hata oluştu.",
                        icon: "error",
                        confirmButtonText: "Tamam"
                    });
                }
            });
        });

        // Seçilen cari bilgilerini göster
        function displaySelectedCari(cari) {
            const cariAdi = cari.invoice_title || (cari.name + ' ' + cari.surname).trim();
            $('#selected_cari_name').text(cariAdi);
            $('#selected_cari_phone').text(cari.cari_phone || '-');
            $('#selected_cari_email').text(cari.cari_email || '-');
            $('#selected_cari_tax').text(cari.identification_number || '-');
            $('#selected_cari_balance').text(formatCurrency(cari.cari_balance));
            $('#selected_cari_address').text(cari.address || 'Adres bilgisi bulunamadı');
            
            $('#selected_cari_info').show();
        }

        // Para formatı
        function formatCurrency(amount) {
            return new Intl.NumberFormat('tr-TR', {
                style: 'currency',
                currency: 'TRY'
            }).format(amount);
        }

        // Sipariş cari güncelleme
        $('#updateOrderCari').on('click', function() {
            if (!selectedCariId) {
                Swal.fire({
                    title: "Uyarı",
                    text: "Lütfen bir cari seçin.",
                    icon: "warning",
                    confirmButtonText: "Tamam"
                });
                return;
            }

            Swal.fire({
                title: 'Sipariş cari bilgileri güncelleniyor...',
                text: 'Lütfen bekleyiniz...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.siparisler.updateOrderCari') ?>',
                data: {
                    order_id: '<?= $order_item['order_id'] ?>',
                    new_cari_id: selectedCariId
                },
                success: function(response) {
                    // Response string ise parse et
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }
                    
                    console.log('Güncelleme response:', response); // Debug için
                    
                    if (response.success) {
                        Swal.fire({
                            title: "Başarılı",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "Tamam"
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Hata",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "Tamam"
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: "Hata",
                        text: "Sipariş cari bilgileri güncellenirken bir hata oluştu.",
                        icon: "error",
                        confirmButtonText: "Tamam"
                    });
                }
            });
        });

        // Modal kapandığında formu temizle
        $('#mdl_siparisCariDegistir').on('hidden.bs.modal', function() {
            $('#new_cari_search').val('');
            $('#cari_results_container').hide();
            $('#selected_cari_info').hide();
            $('#updateOrderCari').prop('disabled', true);
            selectedCariId = null;
            $('input[name="selected_cari"]').prop('checked', false);
        });
    });
</script>

<?= $this->endSection() ?>