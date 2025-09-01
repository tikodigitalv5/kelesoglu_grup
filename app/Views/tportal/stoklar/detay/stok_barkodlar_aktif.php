<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Stok Barkodları <?= $this->endSection() ?>
<?= $this->section('title') ?> Stok Barkodları | <?= $stock_item['stock_code'] ?> - <?= $stock_item['stock_title'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap">
                        <div class="nk-block">
                            <div class="row g-gs" >
                               <div class="listeBarkod row g-gs " style="padding-left:40px;">
                               <?php 
                                $hasBarcodes = false;
                                foreach($stok as $barcodeGroup): 
                                    if(!empty($barcodeGroup)):
                                        $hasBarcodes = true;
                                        foreach($barcodeGroup as $barcode_item): 

                                            $barcode_item["barcode_number"] = substr($barcode_item['barcode_number'], 0, -get_user_number_length());
                                ?>
                                    <div class="col-sm-6 col-lg-4 col-xl-3">
                                        <div class="card h-100">
                                            <div class="card-inner text-center d-flex flex-column">
                                                <!-- Barcode Icon -->
                                                <div class="mb-3">
                                               
                    <img style="width:100%; height:50px; object-fit: contain;" src="https://images.vexels.com/media/users/3/157862/isolated/lists/5fc76d9e8d748db3089a489cdd492d4b-barcode-scanning-icon.png" alt="">
         
                                                </div>

                                                <!-- Variant Title -->
                                                <h7 class="card-title mb-3 text-truncate" title="<?= $barcode_item['stock_title'] ?>">
                                                    <?= $barcode_item['stock_code'] ?>
                                                </h7>

                                                <!-- Barcode Number -->
                                                <code class="d-block mb-3" style="word-wrap: break-word; font-size: 1rem; line-height: 1.2;">
                                                    <?= $barcode_item['barcode_number'] ?>
                                                </code>

                                                <!-- Quantity -->
                                                <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                                                    <em class="icon ni ni-package text-success fs-4"></em>
                                                    <div class="fw-bold fs-5"><?= number_format($barcode_item['total_amount'] - $barcode_item['used_amount'], 2) ?></div>
                                                </div>
                                                
                                              

                                                <!-- Copy Button at the bottom -->
                                                <div class="mt-auto">
                                                    <button class="btn btn-outline-light btn-sm w-100" onclick="copyToClipboard('<?= $barcode_item['barcode_number'] ?>')">
                                                        <em class="icon ni ni-copy"></em>
                                                        <span style="font-size: 11px;">Barkod Kopyala</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php 
                                        endforeach;
                                    endif;
                                endforeach; 
                                
                                if(!$hasBarcodes): 
                                ?>
                                    <div class="col-12">
                                        <div class="alert alert-info text-center">
                                            <em class="icon ni ni-info-fill"></em>
                                            <span>Bu ürün için henüz barkod bulunmamaktadır.</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                               </div>
                            </div>
                        </div>

                        <?= $this->include('tportal/stoklar/detay/inc/sol_menu') ?>
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
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Başarılı bildirim göster
        swal.fire({
            icon: 'success',
            title: 'Başarılı',
            text: 'Barkod kopyalandı',
            showConfirmButton: false,
            timer: 1500
        });
    }).catch(err => {
        console.error('Kopyalama başarısız:', err);
    });
}
</script>

<?= $this->endSection() ?>