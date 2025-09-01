<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> İrsaliye Oluştur <?= $this->endSection() ?>
<?= $this->section('title') ?> İrsaliye Oluştur | <?= session()->get('user_item')['firma_adi'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head nk-block-head-lg">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">İrsaliye Oluştur</h4>
                                    </div>
                                </div>
                            </div>

                            <form id="irsaliyeForm" method="post">
                                <div class="nk-block">
                                    <!-- Sipariş Bilgileri -->
                                    <div class="card-inner">
                                        <div class="row g-4">
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
                                          
                                        </div>  
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
                                            
                                            foreach ($merged_rows as $index => $order_row) : ?>
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
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <span><?= $order_row['stock_code'] ?? '' ?></span>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <div class="form-control-wrap">
                                                        <select class="form-select form-select-sm" name="depo_ids[]" required>
                                                            <option value="">Depo Seçiniz</option>
                                                            <?php foreach ($depoListesi as $depo): ?>
                                                            <option value="<?= $depo['depo_id'] ?>"><?= $depo['depo_title'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
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
                                                    <span class="currency"><?= $order_row['money_icon'] ?></span>
                                                    <input type="hidden" name="unit_prices[]" value="<?= $order_row['unit_price'] ?>">
                                                </div>
                                                <div class="nk-tb-col tb-col-md text-end">
                                                    <span class="row-total"><?= number_format($order_row['total_price'], 2, ',', '.') ?></span>
                                                    <span class="currency"><?= $order_row['money_icon'] ?></span>
                                                    <input type="hidden" name="total_prices[]" value="<?= $order_row['total_price'] ?>">
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
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
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
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

    // Form submit
    $('#irsaliyeForm').on('submit', function(e) {
        e.preventDefault();

        // Depo seçimi kontrolü
        var depoSecildi = true;
        $('select[name="depo_ids[]"]').each(function() {
            if (!$(this).val()) {
                depoSecildi = false;
                return false;
            }
        });

        if (!depoSecildi) {
            Swal.fire({
                icon: 'warning',
                title: 'Uyarı!',
                text: 'Lütfen tüm ürünler için depo seçimi yapınız.',
                confirmButtonText: 'Tamam'
            });
            return;
        }

        Swal.fire({
            title: 'İrsaliye oluşturuluyor...',
            text: 'Lütfen bekleyiniz',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        var formData = new FormData(this);
        
        $.ajax({
            url: '<?= base_url("tportal/siparisler/sysmond_irsaliye") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
                        text: data.message,
                        confirmButtonText: 'Tamam'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = data.redirect;
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: data.message,
                        confirmButtonText: 'Tamam'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: 'Bir hata oluştu. Lütfen tekrar deneyiniz.',
                    confirmButtonText: 'Tamam'
                });
            }
        });
    });

    // Sayfa yüklendiğinde toplamları hesapla
    hesaplaToplamlar();
});
</script>
<?= $this->endSection() ?>