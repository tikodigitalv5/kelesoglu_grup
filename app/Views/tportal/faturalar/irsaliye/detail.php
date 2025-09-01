<?php
    $detail_text = 'İrsaliye' ;
?>

<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> <?= $detail_text ?> Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> <?= $detail_text ?> Detay | <?= $invoice_item['irsaliye_no'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <!-- İstatistik Kartı -->
                <?php if (!empty($statistics)) : ?>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">İrsaliye İstatistikleri</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center mb-3">
                        <h6>Toplam Sipariş</h6>
                        <h3 class="text-danger"><?= $statistics['total_orders'] ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center mb-3">
                        <h6>Toplam Ürün Çeşidi</h6>
                        <h3 class="text-primary"><?= $statistics['total_products'] ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center mb-3">
                        <h6>Toplam Miktar</h6>
                        <h3 class="text-success"><?= number_format($statistics['total_quantity'], 2, ',', '.') ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center mb-3">
                        <h6>Toplam Tutar</h6>
                        <h3 class="text-info"><?= number_format($statistics['total_amount'], 2, ',', '.') ?> ₺</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
                <div class="invoice">
                    <div class="card invoice-wrap">
                        <div class="invoice-head">
                            <div class="invoice-contact">
                                <span class="overline-title"><?= $invoice_item['irsaliye_no'] ?></span>
                                <div class="invoice-contact-info">
                                    <h4 class="title">SYSMOND ONLİNE</h4>
                                    <ul class="list-plain">
                                        <li><em class="icon ni ni-map-pin-fill"></em><span>Fams Otomotiv Aksesuarları imalat aş</span></li>
                                        <li><em class="icon ni ni-call-fill"></em><span>(0224) 214 00 40</span></li>
                                        <li><em class="icon ni ni-mail-fill"></em><span>info@famsotomotiv.com</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="invoice-desc">
                                <?php 
                                if($invoice_item['status'] == 'draft'){
                                    $status_info = 'warning';
                                    $status_name = 'İRSALİYE TASLAK';
                                }else if($invoice_item['status'] == 'active'){
                                    $status_info = 'success';
                                    $status_name = 'İRSALİYE KESİLDİ';
                                }else if($invoice_item['status'] == 'cancelled'){
                                    $status_info = 'danger';
                                    $status_name = 'İRSALİYE İPTAL';
                                }
                                ?>
                                <h4 class="title text-<?= $status_info ?>"><?= $status_name ?></h4>
                                <ul class="list-plain">
                                    <li class="invoice-id"><span>İrsaliye No</span>:<span><?= $invoice_item['irsaliye_no'] ?></span></li>
                                    <li class="invoice-date"><span>İrsaliye Tarihi</span>:<span><?= $invoice_item['irsaliye_tarihi'] ?></span></li>
                                    <li class="invoice-date"><span>İrsaliye Saati</span>:<span><?= $invoice_item['irsaliye_saati'] ?></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="invoice-bills mt-3">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ürün Kodu/Adı</th>
                                            <th class="text-center">Depo</th>
                                            <th class="text-right">Miktar</th>
                                            <th class="text-right">Birim Fiyat</th>
                                            <th class="text-right">Toplam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($invoice_rows as $row): 
                                           
                                            ?>
                                        <tr>
                                            <td>
                                                <strong><?= $row['stock_title'] ?></strong><br>
                                                <?= $row['stock_code'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $depo_adi = '';
                                                switch($row['depo_id']) {
                                                    case 1: $depo_adi = '1.Depo'; break;
                                                    case 2: $depo_adi = '2.Depo'; break;
                                                    case 3: $depo_adi = '3.Depo'; break;
                                                    case 4: $depo_adi = 'AMBALAJ'; break;
                                                    case 5: $depo_adi = 'SAC DEPOSU'; break;
                                                    case 6: $depo_adi = 'ABS DEPOSU'; break;
                                                    case 7: $depo_adi = 'KALIP DEPOSU'; break;
                                                    case 8: $depo_adi = 'ÜRETİM ALANI'; break;
                                                }
                                                echo $invoice_item['depo_adi'];
                                                ?>
                                            </td>
                                            <td class="text-right">
                                                <?= number_format($row['stock_amount'], 2, ',', '.') ?> <?= $row['unit_title'] ?>
                                            </td>
                                            <td class="text-right">
                                                <?= number_format($row['unit_price'], 2, ',', '.') ?> <?= $row['money_icon'] ?>
                                            </td>
                                            <td class="text-right">
                                                <?= number_format($row['total_price'], 2, ',', '.') ?> <?= $row['money_icon'] ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right">
                                                <strong>Genel Toplam</strong>
                                            </td>
                                            <td class="text-right">
                                                <strong><?= number_format($invoice_item['genel_toplam'], 2, ',', '.') ?> <?= $invoice_rows[0]['money_icon'] ?? 'TRY' ?></strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                        </div>
                        <?php if($invoice_item['irsaliye_notu'] != ''): ?>
                        <div class="invoice-notes" style="margin-left:20px; margin-top:30px">
                            <div class="notes-info">
                                <h6 class="title">İrsaliye Notu:</h6>
                                <p><?= $invoice_item['irsaliye_notu'] ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $(document).on("click", "#btnDeleteInvoice", function() {
        var invoice_id = $(this).attr('data-invoice-id');
        
        Swal.fire({
            title: 'İrsaliye silmek üzeresiniz!',
            text: 'Silme işlemine devam etmek istiyor musunuz?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Evet, Sil',
            cancelButtonText: 'Hayır',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('tportal/irsaliye/delete/') ?>" + invoice_id,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if(data.status === "success") {
                            Swal.fire({
                                title: 'Başarılı!',
                                text: data.message,
                                icon: 'success'
                            }).then(() => {
                                window.location.href = "<?= base_url('tportal/irsaliye/list/all') ?>";
                            });
                        } else {
                            Swal.fire('Hata!', data.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Hata!', 'Bir şeyler ters gitti', 'error');
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>