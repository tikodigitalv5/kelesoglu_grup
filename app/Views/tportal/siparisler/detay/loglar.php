<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Sipariş Logları  <?= $this->endSection() ?>
<?= $this->section('title') ?> Sipariş Logları | <?= session()->get('user_item')['firma_adi'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>



<?= $this->section('main') ?>


<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap" style="flex-direction: column-reverse;">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head nk-block-head-lg">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Sipariş Logları</h4>
                                      
                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                   

                                    <table class="datatable-init-hareketler_log nowrap table" data-export-title="Export">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                            <th style="background-color: #ebeef2;">Durum</th>
                                                <th style="background-color: #ebeef2;">İşlem</th>
                                                
                                               
                                                <th style="background-color: #ebeef2;" data-orderable="false">Kullanıcı/Tarayıcı/Lokasyon</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                     


                                        <?php foreach($loglar as $log):?>
                                            <tr>
                                            <td><?php 
                                                if($log["log_islem"] == "sevk"){
                                                    echo '<span class="badge bg-primary" style="text-transform:uppercase">SEVK</span>';
                                                }else if($log["log_islem"] == "siparis"){
                                                    echo '<span class="badge bg-info" style="text-transform:uppercase">SİPARİŞ</span>';
                                                }else if($log["log_islem"] == "barkod"){
                                                    echo '<span class="badge bg-secondary" style="text-transform:uppercase">BARKOD</span>';
                                                }else if($log["log_islem"] == "stok"){
                                                    echo '<span class="badge bg-orange" style="text-transform:uppercase">STOK</span>';
                                                }else if($log["log_islem"] == "fatura"){
                                                    echo '<span class="badge bg-success" style="text-transform:uppercase">FATURA</span>';
                                                }
                                                ?></td>
                                                <td><?php echo $log["log_mesaj"] ?></td>
                                               
                                                
                                                <td><b><?php echo $log["islemi_yapan"] ?></b> / <?php echo $log["ip"] ?> /  <?php echo $log["isletim_sistemi"] ?> <br>  <?php echo $log["created_at"]; ?></td>
                                                
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td><?php 
                                             echo '<span class="badge bg-secondary" style="text-transform:uppercase">SİPARİŞ OLUŞTURULDU</span>';
                                                ?></td>
                                                <td><?php if(session()->get('user_item')['user_id'] == 1){ echo "<b>DOPİGO API Tarafından Sipariş Aktar Sonucu Oluşturuldu</b> <br> Oluşturulma Tarihi:  <b>".$order_item["order_created_at"]."</b>  "; }else{ echo "Sipariş Oluşturuldu"; } ?></td>
                                               
                                                
                                                <td><b><?php echo session()->get('user_item')['firma_adi'] ?></b> <br> </td>
                                                
                                            </tr>

                                        </tbody>
                                    </table>
                                </div><!-- data-list -->
                              
                            </div><!-- .nk-block -->
                        </div>
                        
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

<div class="card   " data-toggle-body="true" data-content="" data-toggle-screen="lg" data-toggle-overlay="true">
    <div class="card-inner-group" data-simplebar>
        
        <div class="card-inner">
            
            <div class="row">
            <div class="col" style="align-items: center; display: flex;">
                <a href="<?= route_to('tportal.siparisler.detail', $order_item['order_id']) ?>" class="btn btn-md btn-primary"><em class="icon ni ni-chevron-left"></em> Siparişe Dön  </a>
            </div>
            <div class="col" style="align-items: center; display: flex;">
            <div class="user-card">
                <div class="user-avatar sq <?= $statusBgColor ?>"><span><?= $order_item['cari_invoice_title'] == '' ? mb_substr($order_item['cari_name'], 0, 1) : mb_substr($order_item['cari_invoice_title'], 0, 1) ?></span></div>
                <div class="user-info">
                    <span class="lead-text"><?= $order_item['order_no'] ?></span>
                    <span class="sub-text"><?= $order_item['cari_invoice_title'] != '' ? $order_item['cari_invoice_title'] : $order_item['cari_name'] . " " . $order_item['cari_surname'] ?></span>
                </div>

            </div>
            </div>
            <!-- .user-card -->
            <div class="col" style="align-items: center; display: flex; ">
                    <div class="user-account-info py-0">
                        <h6 class="overline-title-alt">Sipariş Durumu</h6>
                        <span class="badge badge-sm badge-dim <?= $statusBgColor ?> <?= $statusTextColor ?> "><?= $statusText ?></span>
                        <span class="badge badge-dot badge-dot-xs bg-success"></span>
                    </div>
                </div>
                <div class="col" style="align-items: center; display: flex; margin-top: 10px;">
                    <div class="user-account-info py-0">
                        <h6 class="overline-title-alt">Sipariş Tutarı</h6>
                        <div class="user-balance <?= $statusTextColor ?> pb-3"><strong><?= number_format($order_item['amount_to_be_paid'], 2, ',', '.') ?> <small class="currency currency-btc"><?= $order_item['money_icon'] ?></small></strong></div>
                    </div>
                </div>
              
                <?php if ($order_item['is_deadline'] == 1) { ?>
                    <div class="col" style="align-items: center; display: flex;">
                        <div class="user-account-info pt-2">
                            <h6 class="overline-title-alt">Termin Tarihi</h6>
                            <span class="badge badge-sm badge-dim <?= $deadlineDateTextColor ?> <?= $deadlineDateBgColor ?> "><?= convert_date_for_view($order_item['deadline_date']) ?></span>
                            <span class="badge badge-dot badge-dot-xs bg-success"></span>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($order_item['service_name'] != '') { ?>
                    <div class="col" style=" align-items: center; display: flex;">
                        <div class="user-account-info pt-2">
                            <h6 class="overline-title-alt">PLATFORM</h6>
                            <div style="font-size:18px; line-height:18px; text-transform:uppercase"><img style="height:30px; margin-right: 10px;" src="<?php echo $order_item["service_logo"] ?>" alt="<?php echo $order_item["service_name"]; ?>"><b style="    font-size: 16px;"> <?php echo $order_item["service_name"]; ?></b> </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($order_item['kargo'] != '') { ?>
                    <div class="col" style="align-items: center; display: flex;">
                        <div class="user-account-info pt-2">
                            <h6 class="overline-title-alt">KARGO</h6>
                            <?php echo KargoLogo($order_item["kargo"]) ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($order_item['order_status'] == 'kargolandi') { ?>
                    <div class="col" style="align-items: center; display: flex;">
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
                    <div class="col" style="align-items: center; display: flex;">
                        <div class="user-account-info pt-2">
                            <h6 class="overline-title-alt">KARGO NUMARASI</h6>
                           <h6> <b><?php echo $order_item["kargo_kodu"] ?? "" ?></b></h6>
                        </div>
                    </div>
                <?php } ?>

                


                
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
 
    </div><!-- .card-inner-group -->
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
</script>

<?= $this->endSection() ?>
                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>

</script>

<?= $this->endSection() ?>