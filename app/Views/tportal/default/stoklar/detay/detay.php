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
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Ürün Barkodu</span>
                                            <span class="data-value"><?= substr($stock_item['stock_barcode'], 0, -get_user_number_length()) ?></span>
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
                                            <span class="data-value">
                                                Alış: <?= number_format($stock_item['buy_unit_price'], 4, ',', '.') ?><br>
                                                Satış: <?= number_format($stock_item['sale_unit_price'], 4, ',', '.') ?>
                                            </span>
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