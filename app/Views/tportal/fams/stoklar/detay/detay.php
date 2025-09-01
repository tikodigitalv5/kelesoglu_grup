<div class="nk-data data-list">
                                    <div class="data-head">
                                        <h6 class="overline-title">Bilgiler</h6>
                                    </div>
                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Ürün / Hizmet</span>
                                            <span class="data-value"><?php if($stock_item['stock_type'] == 'product'){echo 'Ürün'; }elseif($stock_item['stock_type'] == 'service'){echo 'Hizmet';} ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Ürün Tipi</span>
                                            <span class="data-value"><?= $stock_item['type_title'] ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Ürün Adı</span>
                                            <span class="data-value"><?= $stock_item['stock_title'] ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Ürün Kodu</span>
                                            <span class="data-value"><?= $stock_item['stock_code'] ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <?php if(session()->get('user_id') != 1) { ?>
                                    <div style="cursor:pointer;" title="Barkodu Kopyala" class="data-item" id="copy_items">
                                        <div class="data-col">
                                            <span class="data-label">Ürün Barkodu</span>
                                            <span id="copy_item"  class="data-value"><?= remove_end_of_barcode($stock_item['stock_barcode']) ?></span>
                                           <!-- <span id="copy_item"  class="data-value">convert_barcode_number_for_sql(remove_end_of_barcode($stock_item['stock_barcode'])</span> -->
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-copy-fill"></em></span></div>
                                    </div><!-- data-item -->
                                    <?php }else{ ?>
                                        
                                        <div style="cursor:pointer;" title="Barkodu Görüntüle" class="data-item" id="">
                                        <div class="data-col">
                                            <span class="data-label">Ürün Barkodu</span>
                                            <a href="<?= route_to('tportal.stocks.stok_barkodlar', $stock_item['stock_id']) ?>" class="data-value">Stok Barkodları İçin Tıklayınız</a>
                                           <!-- <span id="copy_item"  class="data-value">convert_barcode_number_for_sql(remove_end_of_barcode($stock_item['stock_barcode'])</span> -->
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                        
                                        
                                        <?php } ?>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Kalıp Adresi</span>
                                            <span class="data-value"><?= $stock_item['pattern_code'] ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Tedarikçi Stok Kodu</span>
                                            <span class="data-value"><?= $stock_item['supplier_stock_code'] ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Depo Raf Adresi</span>
                                            <span class="data-value"><?= $stock_item['warehouse_address'] ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit" data-tab-target="#address">
                                        <div class="data-col">
                                            <span class="data-label">Para Birimi</span>
                                            <span class="data-value"><?= $stock_item['buy_money_code'] ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit" data-tab-target="#address">
                                        <div class="data-col">
                                            <span class="data-label">Birim Fiyat</span>
                                            <span class="data-value"><?= number_format($stock_item['buy_unit_price'], 4, ',', '.') ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Kategori</span>
                                            <span class="data-value"><?= $stock_item['category_title'] ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit" data-tab-target="#address">
                                        <div class="data-col">
                                            <span class="data-label">Birim</span>
                                            <span class="data-value"><?= $stock_item['buy_unit_title'] ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Ürün Fotoğraf</span>
                                            <span class="data-value">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <a class="gallery-image popup-image" href="<?= base_url($stock_item['default_image']) ?>">
                                                            <img class="w-100 rounded" src="<?= base_url($stock_item['default_image']) ?>" alt="<?= $stock_item['stock_title'] ?>">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-9">
                                                    </div>
                                                </div>
                                            </span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                </div><!-- data-list -->  

                                <script>
document.addEventListener('DOMContentLoaded', (event) => {
    const copyItem = document.getElementById('copy_items');
    const copyItemm = document.getElementById('copy_item');

    if (copyItem) {
        copyItem.addEventListener('click', () => {
            // Geçici bir textarea oluşturun
            const tempInput = document.createElement('textarea');
            tempInput.value = copyItemm.textContent;
            document.body.appendChild(tempInput);

            // Metni seç ve kopyala
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); // Mobil cihazlar için

            try {
                // Kopyalama işlemi
                const successful = document.execCommand('copy');
                
                Swal.fire({
                    title: "Başarılı!",
                    html: '<b><?= $stock_item['stock_title'] ?></b> barkodu başarıyla kopyalandı.',
                    icon: "success",
                    confirmButtonText: 'Tamam',
                });

            } catch (err) {
                console.error('Kopyalama sırasında bir hata oluştu', err);
                Swal.fire({
                    title: "Hata!",
                    text: "Kopyalama sırasında bir hata oluştu. Lütfen tekrar deneyin.",
                    icon: "error",
                    confirmButtonText: 'Tamam',
                });
            }

            // Geçici textarea'yı kaldır
            document.body.removeChild(tempInput);
        });
    } else {
        console.error('Element with id "copy_item" not found.');
    }
});

</script>