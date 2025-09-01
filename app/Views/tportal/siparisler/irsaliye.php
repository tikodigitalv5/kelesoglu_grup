<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> İrsaliye Oluştur <?= $this->endSection() ?>
<?= $this->section('title') ?> İrsaliye Oluştur | <?= session()->get('user_item')['firma_adi'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>
<style>
    /* Ana stil - satır geçişleri için */
    .irsaliye-satir {
        transition: all 1s ease;
    }

    /* Sadece ikonun dönmesi için stil (butonun kendisi dönmeyecek) */
    .btn-reload-row .ni-reload {
        display: inline-block;
    }

    .spinning .ni-reload {
        animation: iconSpin 2s infinite linear;
    }

    @keyframes iconSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Satır güncelleme animasyonları - daha belirgin renkler */
    .updating-row {
        background-color: #ffeeba !important; /* Koyu sarı */
        transition: background-color 1s ease;
    }

    .success-update {
        background-color: rgba(30, 224, 172, 0.8) !important; /* Çok daha koyu yeşil - 0.8 opacity */
        transition: background-color 1s ease;
    }

    .error-update {
        background-color: rgba(255, 99, 99, 0.8) !important; /* Koyu kırmızı - 0.8 opacity */
        transition: background-color 1s ease;
    }
</style>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap">
                        <div class="card-inner card-inner-lg">
                           

                            <form id="irsaliyeForm" method="post">
                                <div class="nk-block">


                                <div class="buradabilgilerigetir">
    <?php if (!empty($statistics)) : ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
            <h4 class="nk-block-title">İrsaliye Oluştur</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="border rounded p-3 text-center mb-3">
                            <h6>Toplam Sipariş</h6>
                            <h3 class="text-primary"><?= $statistics['total_orders'] ?></h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 text-center mb-3">
                            <h6>Toplam Ürün Çeşidi</h6>
                            <h3 class="text-success"><?= $statistics['total_products'] ?></h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 text-center mb-3">
                            <h6>Toplam Ürün Adedi</h6>
                            <h3 class="text-info"><?= number_format($statistics['total_quantity'], 2) ?></h3>
                        </div>
                    </div>
                </div>

           
                <div class="row g-4 mb-10" style="margin-bottom: 10px;">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="irsaliye_tarihi">İrsaliye Tarihi</label>
                                                    <div class="form-control-wrap">
                                                        <input type="date" class="form-control" id="irsaliye_tarihi" name="irsaliye_tarihi" value="<?= date('Y-m-d') ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="irsaliye_saati">İrsaliye Saati</label>
                                                    <div class="form-control-wrap">
                                                        <input type="time" class="form-control" id="irsaliye_saati" name="irsaliye_saati" value="<?= date('H:i') ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                <label class="form-label" for="irsaliye_saati">Stokları Senkronize Et</label>
                                                <div class="form-control-wrap">
                                                <button type="button" class="btn btn-md btn-primary w-100 btn-reload-rows">
    <em class="icon ni ni-reload"></em> &nbsp; Tüm Stokları Senkronize Et
</button>
                                                </div>
                                                </div>
                                            </div>
                                          
                                        </div> 
            </div>
        </div>
    <?php endif; ?>
</div>


                                    <!-- Sipariş Bilgileri -->
                                    <div class="card-inner">
                                      
                                    </div>

                                    <!-- İrsaliye Kalemleri -->
                                    <div class="card-inner p-0">
                                        <div class="nk-tb-list nk-tb-ulist is-compact" id="irsaliye_satirlar">
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span>Ürün</span></div>
                                                <div class="nk-tb-col tb-col-md"><span>Stok Kodu</span></div>
                                                <div class="nk-tb-col tb-col-md"><span>Depo</span></div>
                                                <div class="nk-tb-col tb-col-md"><span>Miktar</span></div>
                                                <div class="nk-tb-col tb-col-md"><span>Birim</span></div>
                                                <div class="nk-tb-col tb-col-md"><span>Birim Fiyat</span></div>
                                                <div class="nk-tb-col tb-col-md text-end"><span>Toplam</span></div>
                                                <div class="nk-tb-col tb-col-md text-end"><span>Sil</span></div>
                                            </div>

                                            <?php 
                                            // Aynı ürünleri birleştir
                                            $merged_rows = [];
                                            foreach ($order_rows as $row) {
                                                $stock_id = $row['stock_id'];
                                                if (isset($merged_rows[$stock_id])) {
                                                    $merged_rows[$stock_id]['stock_amount'] += $row['stock_amount'];
                                                    $merged_rows[$stock_id]['total_price'] += $row['total_price'];
                                                } else {
                                                    $merged_rows[$stock_id] = $row;
                                                }
                                            }
                                            
                                            foreach ($merged_rows as $index => $order_row) :
                                            if($order_row['paket'] == 0){
                                            ?>
                                            <div class="nk-tb-item irsaliye-satir" id="satir_<?= $index ?>">
                                                <div class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-avatar bg-transparent">
                                                            <?php if(isset($order_row["default_image"])): ?>
                                                            <img src="<?= base_url($order_row['default_image']) ?>" alt="ürün" class="thumb">
                                                            <?php else: ?>
                                                            <img src="<?= base_url("uploads/default.png") ?>" alt="ürün" class="thumb">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="user-info">
                                                            <span class="tb-lead"><?= $order_row['stock_title'] ?></span>
                                                            <input type="hidden" name="stock_ids[]" value="<?= $order_row['stock_id'] ?>">
                                                            <input type="hidden" name="stock_titles[]" value="<?= $order_row['stock_title'] ?>">
                                                            <input type="hidden" name="stock_codes[]" value="<?= $order_row['stock_code'] ?>">
                                                            <input type="hidden" name="stock_images[]" value="<?= $order_row['default_image'] ?? '' ?>">
                                                            <input type="hidden" name="unit_titles[]" value="<?= $order_row['unit_title'] ?>">
                                                            <input type="hidden" name="money_icons[]" value="₺">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <span><?= $order_row['stock_code'] ?? '' ?></span>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                   
                                                    <div class="form-control-wrap">
                                                        <select class="form-select form-select-sm select2-depo" name="depo_ids[]" required>
                                                            <option value="">Depo Seçiniz</option>
                                                            <?php 
                                                            // Depo miktarlarını karşılaştır
                                                            $depo_miktarlari = [
                                                                2 => ['id' => $order_row['depo_2_id'] ?? 0, 'name' => $order_row['depo_2'] ?? '', 'count' => $order_row['depo_2_count'] ?? 0],
                                                                1 => ['id' => $order_row['depo_1_id'] ?? 0, 'name' => $order_row['depo_1'] ?? '', 'count' => $order_row['depo_1_count'] ?? 0],
                                                                3 => ['id' => $order_row['depo_3_id'] ?? 0, 'name' => $order_row['depo_3'] ?? '', 'count' => $order_row['depo_3_count'] ?? 0]
                                                            ];

                                                            // Önce 2. depoyu seç, stoğu 0 ise 1. depoya geç
                                                            $selected_depo = null;
                                                            if (!empty($depo_miktarlari[2]['name'])) {
                                                                if ($depo_miktarlari[2]['count'] > 0) {
                                                                    $selected_depo = $depo_miktarlari[2];
                                                                } elseif (!empty($depo_miktarlari[1]['name'])) {
                                                                    $selected_depo = $depo_miktarlari[1];
                                                                }
                                                            }

                                                            // Depoları listele
                                                            if (!empty($order_row['depo_2'])): ?>
                                                                <option value="<?= $order_row['depo_2_id'] ?>" 
                                                                    <?= ($selected_depo && $selected_depo['id'] == $order_row['depo_2_id'] ? 'selected' : '') ?>
                                                                    data-stock="<?= $order_row['depo_2_count'] ?>"
                                                                    data-badge="<?= $order_row['depo_2_count'] > 0 ? 'success' : 'danger' ?>">
                                                                    <?= $order_row['depo_2'] ?>
                                                                </option>
                                                            <?php endif; ?>
                                                            <?php if (!empty($order_row['depo_1'])): ?>
                                                                <option value="<?= $order_row['depo_1_id'] ?>" 
                                                                    <?= ($selected_depo && $selected_depo['id'] == $order_row['depo_1_id'] ? 'selected' : '') ?>
                                                                    data-stock="<?= $order_row['depo_1_count'] ?>"
                                                                    data-badge="<?= $order_row['depo_1_count'] > 0 ? 'success' : 'danger' ?>">
                                                                    <?= $order_row['depo_1'] ?>
                                                                </option>
                                                            <?php endif; ?>
                                                            <?php if (!empty($order_row['depo_3'])): ?>
                                                                <option value="<?= $order_row['depo_3_id'] ?>" 
                                                                    <?= ($selected_depo && $selected_depo['id'] == $order_row['depo_3_id'] ? 'selected' : '') ?>
                                                                    data-stock="<?= $order_row['depo_3_count'] ?>"
                                                                    data-badge="<?= $order_row['depo_3_count'] > 0 ? 'success' : 'danger' ?>">
                                                                    <?= $order_row['depo_3'] ?>
                                                                </option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="order_row_id[]" value="<?= implode(',', $order_row['order_row_ids']) ?>">
                                                <input type="hidden" name="order_ids[]" value="<?= implode(',', $order_row['order_ids']) ?>">
                                                <div class="nk-tb-col tb-col-md" style="width:80px">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-sm stock-amount text-end" 
                                                            name="stock_amounts[]" 
                                                            value="<?= number_format($order_row['stock_amount'], 2, ',', '.') ?>" 
                                                            readonly>
                                                        <input type="hidden" name="real_stock_amounts[]" value="<?= $order_row['stock_amount'] ?>">
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <span><?= $order_row['unit_title'] ?></span>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <span class="unit-price"><?= number_format($order_row['unit_price'], 2, ',', '.') ?></span>
                                                    <span class="currency">₺</span>
                                                    <input type="hidden" name="unit_prices[]" value="<?= $order_row['unit_price'] ?>">
                                                </div>
                                                <div class="nk-tb-col tb-col-md text-end">
                                                    <span class="row-total"><?= number_format($order_row['total_price'], 2, ',', '.') ?></span>
                                                    <span class="currency">₺</span>
                                                    <input type="hidden" name="total_prices[]" value="<?= $order_row['total_price'] ?>">
                                                </div>
                                                <div class="nk-tb-col tb-col-md text-end" style="display: flex !important ; align-items: center; gap: 5px; padding-bottom: 18px; justify-content: center;">
                                                <?php if($order_row["sysmond_id"] != ''): ?>
                                                <button type="button"  data-id="<?= $order_row["sysmond_id"] ?>" class="btn btn-sm btn-primary btn-reload-row">
                                                        <em class="icon ni ni-reload"></em>
                                                    </button>
                                                    <?php endif; ?>
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete-row">
                                                        <em class="icon ni ni-trash"></em>
                                                    </button>
                                                </div>
                                            </div>
                                            <?php } endforeach; ?>
                                        </div>
                                    </div>

                                    <!-- İrsaliye Notu -->
                                    <div class="card-inner">
                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="irsaliye_notu">İrsaliye Notu</label>
                                                    <div class="form-control-wrap">
                                                        <textarea class="form-control" id="irsaliye_notu" name="irsaliye_notu" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Submit -->
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="row g-3">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Ara Toplam</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control text-end" id="ara_toplam" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Genel Toplam</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control text-end" id="genel_toplam" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 text-end">
                                                <input type="hidden" name="order_id" value="<?= is_array($order_id_full) ? implode(',', $order_id_full) : $order_id_full ?>">
                                                <div class="form-group mt-2" style="margin-top: 30px!important;">
                                                    
                                                    <button type="submit" class="btn btn-primary" id="btnCreateIrsaliye">
                                                        <em class="icon ni ni-file-docs"></em>
                                                        <span>İrsaliye Oluştur</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="irsaliyeOnizleme" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Oluşturulacak İrsaliyeler</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs" id="irsaliyeTabs">
                    <!-- Tab başlıkları JavaScript ile eklenecek -->
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content mt-3" id="irsaliyeTabContent">
                    <!-- Tab içerikleri JavaScript ile eklenecek -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" id="irsaliyeOnayla">Onayla ve İrsaliye Oluştur</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-selection__rendered > span {
    display: block;
    margin-top: -4px;
}
.select2-container--default .select2-selection--single {
    border: 1px solid #dbdfea;
    border-radius: 4px;
    height: 36px;
    padding: 2px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 32px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 34px;
}
.select2-dropdown {
    border: 1px solid #dbdfea;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.select2-results__option {
    padding: 8px 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.stock-badge {
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.85em;
    color: white;
    margin-left: 8px;
}
.stock-badge.success { background-color: #1ee0ac; }
.stock-badge.danger { background-color: #e85347; }
.swal2-popup {
    border-radius: 15px;
    padding: 2rem;
    width: 42em !important;
}
.swal2-title {
    font-size: 1.5rem !important;
    margin-bottom: 1rem !important;
    color: #364a63 !important;
}
.stok-uyari-tablo {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-bottom: 1.5rem;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.stok-uyari-tablo th {
    background: #f5f6fa;
    padding: 12px;
    font-weight: 500;
    text-align: left;
    color: #364a63;
    font-size: 0.9rem;
    border-bottom: 2px solid #e5e9f2;
}
.stok-uyari-tablo td {
    padding: 12px;
    border-bottom: 1px solid #e5e9f2;
    color: #526484;
    font-size: 0.95rem;
}
.stok-uyari-tablo tr:last-child td {
    border-bottom: none;
}
.stok-uyari-tablo tr:hover td {
    background: #f5f6fa;
}
.stok-badge {
    display: inline-block;
    padding: 4px 12px;
    background: #e85347;
    color: white;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
}
.swal2-html-container {
    margin: 0 !important;
    padding: 0 !important;
}
.swal2-actions {
    margin-top: 1.5rem !important;
}
.swal2-confirm {
    background: #1ee0ac !important;
    border-radius: 5px !important;
    padding: 8px 20px !important;
    font-weight: 500 !important;
}
.swal2-cancel {
    background: #e85347 !important;
    border-radius: 5px !important;
    padding: 8px 20px !important;
    font-weight: 500 !important;
}
.stok-uyari-mesaj {
    margin-top: 1rem;
    padding: 12px;
    background: #fff9f9;
    border-radius: 5px;
    color: #526484;
    font-size: 0.95rem;
    text-align: center;
    border: 1px solid #ffe9e9;
}
.irsaliye-satir.stok-warning {
    background-color: rgba(232, 83, 71, 0.1) !important;
}


</style>
<script>
/// Yeni İşlemler Başlangıç


$(document).ready(function() {
    $('.btn-reload-rows').on('click', async function() {
        const rows = $('.irsaliye-satir');
        
        Swal.fire({
            title: 'Sysmond Depo Güncelleniyor',
            text: 'Lütfen bekleyiniz',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        for (let i = 0; i < rows.length; i++) {
            const row = $(rows[i]);
            const reloadBtn = row.find('.btn-reload-row');
            const sysmondId = reloadBtn.data('id');

            if (!sysmondId) continue;

            // Satırı vurgula ve animasyon ekle (2 saniye sürecek)
            row.addClass('updating-row');
            
            // Reload butonunu döndürmeye başla
            reloadBtn.addClass('spinning');
            reloadBtn.prop('disabled', true);

            try {
                // AJAX isteği
                const response = await $.ajax({
                    url: '<?= base_url("sysmond/sysmond_depo_tekli") ?>/' + sysmondId,
                    type: 'GET',
                    dataType: 'json'
                });

                if (response.status === 'success') {
                    // Depo verilerini güncelle
                    updateDepoData(row, response.data);
                    
                    // Başarılı animasyonu (4 saniye göster - 1 saniye daha ekledik)
                    row.removeClass('updating-row');
                    row.addClass('success-update');
                    await new Promise(resolve => setTimeout(resolve, 3000)); // 3 saniyeden 4 saniyeye çıkardık
                    row.removeClass('success-update');
                } else {
                    throw new Error(response.message);
                }

            } catch (error) {
                // Hata durumu (3 saniye göster)
                row.removeClass('updating-row');
                row.addClass('error-update');
                await new Promise(resolve => setTimeout(resolve, 3000));
                row.removeClass('error-update');
            }

            // Butonu normal haline getir
            reloadBtn.removeClass('spinning');
            reloadBtn.prop('disabled', false);

            // Sonraki satıra geçmeden önce 2 saniye bekle
            await new Promise(resolve => setTimeout(resolve, 2000));
        }

        Swal.fire({
            icon: 'success',
            title: 'Güncelleme Tamamlandı',
            text: 'Tüm depo bilgileri güncellendi.',
            confirmButtonText: 'Tamam'
        });
    });
});

// Depo verilerini güncelleyen yardımcı fonksiyon
function updateDepoData(row, data) {
    var select = row.find('select.select2-depo');
    select.empty();
    select.append('<option value="">Depo Seçiniz</option>');
    
    if (data.depo_2) {
        select.append(`<option value="${data.depo_2_id}" 
            data-stock="${data.depo_2_count}"
            data-badge="${data.depo_2_count > 0 ? 'success' : 'danger'}">
            ${data.depo_2}
        </option>`);
    }
    
    if (data.depo_1) {
        select.append(`<option value="${data.depo_1_id}" 
            data-stock="${data.depo_1_count}"
            data-badge="${data.depo_1_count > 0 ? 'success' : 'danger'}">
            ${data.depo_1}
        </option>`);
    }
    
    if (data.depo_3) {
        select.append(`<option value="${data.depo_3_id}" 
            data-stock="${data.depo_3_count}"
            data-badge="${data.depo_3_count > 0 ? 'success' : 'danger'}">
            ${data.depo_3}
        </option>`);
    }

    if (data.depo_2 && data.depo_2_count > 0) {
        select.val(data.depo_2_id);
        row.removeClass('stok-warning');
    } else if (data.depo_1) {
        select.val(data.depo_1_id);
        row.addClass('stok-warning');
    }

    select.trigger('change');
}

// Yeni İşlemler


$(document).ready(function() {
    $('.select2-depo').select2({
        templateResult: formatDepo,
        templateSelection: formatDepo,
        escapeMarkup: function(m) { return m; }
    });

    function formatDepo(state) {
        if (!state.id) return state.text;
        
        var stock = $(state.element).data('stock');
        var badgeClass = $(state.element).data('badge');
        
        return $('<span>' + state.text + 
                '<span class="stock-badge ' + badgeClass + '">Stok: ' + 
                new Intl.NumberFormat('tr-TR').format(stock) + 
                '</span></span>');
    }
    
    // Satır silme işlemi
    $(document).on('click', '.btn-delete-row', function() {
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Bu satırı silmek istediğinize emin misiniz?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Evet, Sil',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).closest('.irsaliye-satir').remove();
                hesaplaToplamlar();
            }
        });
    });
    hesaplaToplamlar();
    // Toplam hesaplama fonksiyonu
    function hesaplaToplamlar() {
        var araToplam = 0;
        $('.irsaliye-satir').each(function() {
            var amount = parseFloat($(this).find('input[name="real_stock_amounts[]"]').val()) || 0;
            var price = parseFloat($(this).find('input[name="unit_prices[]"]').val()) || 0;
            var total = amount * price;
            
            $(this).find('.row-total').text(number_format(total, 2, ',', '.'));
            $(this).find('input[name="total_prices[]"]').val(total.toFixed(2));
            
            araToplam += total;
        });
        
        $('#ara_toplam').val(number_format(araToplam, 2, ',', '.'));
        $('#genel_toplam').val(number_format(araToplam, 2, ',', '.'));
    }

    // Number format fonksiyonu
    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    // Depo seçimi ve satır renklendirme
    function updateRowColor(selectElement) {
        var row = $(selectElement).closest('.irsaliye-satir');
        var selectedDepo = $(selectElement).find('option:selected');
        var depoId = selectedDepo.val();
        var stockAmount = selectedDepo.data('stock');
        
        // 2. depodan 1. depoya geçiş yapıldıysa
        if (depoId && depoId === row.data('depo1-id')) {
            row.addClass('stok-warning');
        } else {
            row.removeClass('stok-warning');
        }
    }

    $('.select2-depo').each(function() {
        var select = $(this);
        var row = select.closest('.irsaliye-satir');
        var options = select.find('option');
        var depo2Option = null;
        var depo1Option = null;
        
        // Depo seçeneklerini bul
        options.each(function() {
            var depoText = $(this).text().trim();
            if (depoText.includes('2.DEPO')) {
                depo2Option = $(this);
            } else if (depoText.includes('1.DEPO')) {
                depo1Option = $(this);
            }
        });

        // 2. depo varsa ve stoğu varsa onu seç, yoksa 1. depoya geç
        if (depo2Option && depo2Option.length) {
            var depo2Stock = depo2Option.data('stock');
            if (depo2Stock > 0) {
                select.val(depo2Option.val()).trigger('change');
            } else if (depo1Option && depo1Option.length) {
                select.val(depo1Option.val()).trigger('change');
                row.addClass('stok-warning');
                row.data('depo1-id', depo1Option.val());
            }
        }
    });

    // Select2 değişikliklerini izle
    $('.select2-depo').on('change', function() {
        updateRowColor(this);
    });

    // Form submit
    $('#irsaliyeForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '<?= base_url("tportal/siparisler/irsaliye/irsaliye_kontrol") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    let tabHeaders = '';
                    let tabContent = '';
                    let isFirst = true;
                    
                    // Depo isimlerini tanımla
                    const depoIsimleri = {
                        '33': '1. Depo',
                        '34': '2. Depo',
                    };

                    Object.keys(response.depoGruplari).forEach(depoId => {
                        const depo = response.depoGruplari[depoId];
                        const depoAdi = depoIsimleri[depoId] || `Depo ${depoId}`;
                        const activeClass = isFirst ? 'active' : '';
                        const showClass = isFirst ? 'show active' : '';
                        
                        // Tab Header
                        tabHeaders += `
                            <li class="nav-item">
                                <a class="nav-link ${activeClass}" data-bs-toggle="tab" href="#depo${depoId}">
                                    ${depoAdi}
                                    <span class="stock-badge primary" style="background-color: #014ad0;">${depo.satirlar.length} Ürün</span>
                                </a>
                            </li>`;

                        // Tab Content
                        tabContent += `
                            <div class="tab-pane fade ${showClass}" id="depo${depoId}">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Sipariş No:</strong> 
                                                ${depo.order_numbers.map(no => `<span class="badge bg-primary mx-1">${no}</span>`).join('')}
                                            </div>
                                            <div>
                                                <strong>Sipariş Sayısı:</strong> 
                                                ${depo.order_numbers.length}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Ürün Kodu</th>
                                                    <th>Ürün Adı</th>
                                                    <th class="text-center">Miktar</th>
                                                    <th>Birim</th>
                                                    <th class="text-end">Birim Fiyat</th>
                                                    <th class="text-end">Toplam</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

                        depo.satirlar.forEach(satir => {
                            tabContent += `
                                    <tr>
                                        <td>${satir.stock_code}</td>
                                        <td>${satir.stock_title}</td>
                                        <td class="text-center">${satir.stock_amount}</td>
                                        <td>${satir.unit_title}</td>
                                        <td class="text-end">${parseFloat(satir.unit_price).toFixed(2)} ${satir.money_icon}</td>
                                        <td class="text-end">${parseFloat(satir.total_price).toFixed(2)} ${satir.money_icon}</td>
                                    </tr>`;
                        });

                        tabContent += `
                                            </tbody>
                                               <tfoot>
                                                    <tr>
                                                        <td colspan="5" class="text-end"><strong>Ara Toplam:</strong></td>
                                                        <td class="text-end"><strong>${parseFloat(depo.ara_toplam).toFixed(2)} TL</strong></td>
                                                    </tr>
                                                </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>`;

                        isFirst = false;
                    });

                    $('#irsaliyeTabs').html(tabHeaders);
                    $('#irsaliyeTabContent').html(tabContent);
                    $('#irsaliyeOnizleme').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: response.message,
                        confirmButtonText: 'Tamam'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: 'Bir hata oluştu: ' + error,
                    confirmButtonText: 'Tamam'
                });
            }
        });
    });

    $('#irsaliyeOnayla').on('click', function() {
        var formData = new FormData($('#irsaliyeForm')[0]);
        
        $.ajax({
            url: '<?= base_url("tportal/siparisler/irsaliye/create") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#irsaliyeOnizleme').modal('hide');
                
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
                        text: response.message,
                        confirmButtonText: 'Tamam'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.redirect;
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: response.message,
                        confirmButtonText: 'Tamam'
                    });
                }
            },
            error: function(xhr, status, error) {
                $('#irsaliyeOnizleme').modal('hide');
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: 'Bir hata oluştu: ' + error,
                    confirmButtonText: 'Tamam'
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>