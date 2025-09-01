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
                        <!-- Yeni Barkod Ekleme Butonu -->
                        <div class="d-flex justify-content-between align-items-center mb-4" style="padding:10px;">
                            <h4 class="mb-0">Stok Barkodları</h4>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#yeniBarkodModal">
                                <em class="icon ni ni-plus"></em>
                                <span>Yeni Barkod Ekle</span>
                            </button>
                        </div>

                        <div class="row g-gs">
                    <?php foreach($stok as $stok_item): ?>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-inner">
                                <div class="text-center mb-4">
                                    <!-- Ürün Görseli -->
                                   
                                        <a class="gallery-image popup-image"
                                            href="<?= base_url($stock_item['default_image']) ?>">
                                            <img class="w-100 rounded-top" src="<?= base_url($stock_item['default_image']) ?>" alt="">
                                        </a>
                               
                                </div>

                                <!-- Ürün Adı -->
                                <h5 class="card-title text-center mb-3">
                                    <?= $stok_item['stok_basligi'] ?>
                                </h5>

                                <!-- Barkod -->
                                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                    <em class="icon ni ni-barcode fs-4 text-primary"></em>
                                    <code class="fs-5 fw-normal"><?= remove_end_of_barcode($stok_item['barkod']) ?></code>
                                </div>

                                <!-- Barkod Kopyalama Butonu -->
                                <div class="text-center mt-3">
                                    <button class="btn btn-outline-primary btn-dim btn-sm" 
                                            onclick="copyToClipboard('<?= remove_end_of_barcode($stok_item['barkod']) ?>')">
                                        <em class="icon ni ni-copy"></em>
                                        <span>Barkodu Kopyala</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
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



<!-- Yeni Barkod Ekleme Modal -->
<div class="modal fade" id="yeniBarkodModal" tabindex="-1" aria-labelledby="yeniBarkodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yeniBarkodModalLabel">Yeni Barkod Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="yeniBarkodForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="yeniBarkod">Barkod (13 Karakter)</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="yeniBarkod" name="barkod" 
                                   maxlength="13" 
                                   placeholder="13 karakterlik barkod giriniz" required>
                            <div class="form-note">Barkod 13 karakter olmalıdır (harf ve rakam içerebilir).</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Alert 2 -->

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

// Yeni Barkod Ekleme Form İşleme
document.getElementById('yeniBarkodForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const barkod = document.getElementById('yeniBarkod').value;
    
    // Barkod validasyonu
    if (barkod.length !== 13) {
        swal.fire({
            icon: 'error',
            title: 'Hata',
            text: 'Barkod 13 karakter olmalıdır!',
            confirmButtonText: 'Tamam'
        });
        return;
    }
    
    // Loading göster
    swal.fire({
        title: 'Kaydediliyor...',
        allowOutsideClick: false,
        didOpen: () => {
            swal.showLoading();
        }
    });
    
    // AJAX ile kaydetme işlemi
    fetch('<?= route_to("tportal.stocks.barkod_ekle") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            stock_id: '<?= $stock_item['stock_id'] ?? '' ?>',
            barkod: barkod
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            swal.fire({
                icon: 'success',
                title: 'Başarılı',
                text: 'Barkod başarıyla eklendi!',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                // Sayfayı yenile
                location.reload();
            });
        } else {
            swal.fire({
                icon: 'error',
                title: 'Hata',
                text: data.message || 'Barkod eklenirken bir hata oluştu!',
                confirmButtonText: 'Tamam'
            });
        }
    })
    .catch(error => {
        console.error('Hata:', error);
        swal.fire({
            icon: 'error',
            title: 'Hata',
            text: 'Bir hata oluştu!',
            confirmButtonText: 'Tamam'
        });
    });
});

// Barkod input karakter kontrolü (11 karakter sınırı ve büyük harf)
document.getElementById('yeniBarkod').addEventListener('input', function(e) {
    // Büyük harfe çevir
    this.value = this.value.toUpperCase();
    
    // 11 karakter sınırı
    if (this.value.length > 13) {
        this.value = this.value.slice(0, 13);
    }
});
</script>



<?= $this->endSection() ?>