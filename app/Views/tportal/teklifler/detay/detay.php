<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Teklif Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Teklif Detay | <?= session()->get('user_item')['firma_adi'] ?> <?= $this->endSection() ?>
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
                                        <h4 class="nk-block-title">Teklif Kalemleri</h4>

                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                    <div class="data-head">
                                        <h6 class="overline-title">Bilgiler</h6>
                                    </div>

                                    <div class="card-inner p-0">
                                        <div class="nk-tb-list nk-tb-ulist is-compact">

                                            <?php
                                                foreach ($offer_rows as $offer_row) {
                                              
                                                ?>


                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col tb-col-md">
                                                        <div class="user-card">
                                                            <div class="user-avatar bg-transparent lg mt-3 mb-3">
                                                            <a class="gallery-image popup-image" href="<?= get_image_url($offer_row['default_image'] ?? null); ?>">
    <img src="<?= get_image_url($offer_row['default_image'] ?? null); ?>" alt="image" class="w-100 rounded-top">
</a>
                                                            </div>
                                                            <div class="user-name">
                                                                <span class="tb-lead">
                                                                    <strong><?= $offer_row['stock_title'] ?></strong><br>
                                                                    <?= $offer_row['stock_code'] ?><br>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="nk-tb-col d-md-none">
                                                        <div class="user-card">
                                                            <div class="user-avatar bg-transparent mt-3 mb-3">
                                                            <a class="gallery-image popup-image" href="<?= get_image_url($offer_row['default_image'] ?? null); ?>">
    <img src="<?= get_image_url($offer_row['default_image'] ?? null); ?>" alt="image" class="w-100 rounded-top">
</a>
                                                            </div>
                                                            <div class="user-name">
                                                                <span class="tb-lead"><?= $offer_row['stock_id'] != '0' ? $offer_row['stock_title'] : $offer_row['stok_adi'] ?></span>
                                                                <strong><?= $offer_row['stock_code'] ?></strong><br>
                                                                <span><strong><?= number_format($offer_row['unit_price'], 2, ',', '.') . ' ' . $offer_item['money_icon'] ?></strong></span>
                                                                |
                                                                <strong><?= number_format($offer_row['stock_amount'], 2, ',', '.') . ' ' . $offer_row['unit_title'] ?></strong>
                                                                |
                                                                <strong class="text-black"><?= number_format($offer_row['subtotal_price'], 2, ',', '.') . ' ' . $offer_item['money_icon'] ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="nk-tb-col tb-col-md minw-120">
                                                        <strong><?= number_format($offer_row['stock_amount'], 2, ',', '.') . ' ' . $offer_row['unit_title'] ?></strong>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md minw-120">
                                                        <span><strong><?= number_format($offer_row['unit_price'], 2, ',', '.') . ' ' . $offer_item['money_icon'] ?></strong></span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md text-end minw-120">
                                                        <strong class="text-black"><?= number_format($offer_row['total_price'], 2, ',', '.') . ' ' . $offer_item['money_icon'] ?></strong>
                                                    </div>
                                                </div>


                                            <?php } ?>

                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col tb-col-md text-end"></div>
                                                <div class="nk-tb-col tb-col-md"><strong>Mal/Hizmet Toplam </strong></div>
                                                <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                <div class="nk-tb-col text-end"> <?= number_format($offer_item['stock_total'], 2, ',', '.') . ' ' . $offer_item['money_icon'] ?><br> <?= $offer_item['stock_total_try'] != 0 ? number_format($offer_item['stock_total_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                            </div>

                                            <?php if ($offer_item['discount_total'] != 0) { ?>
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col tb-col-md text-end"></div>
                                                    <div class="nk-tb-col tb-col-md"><strong>İskonto </strong></div>
                                                    <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                    <div class="nk-tb-col text-end"> <?= number_format($offer_item['discount_total'], 2, ',', '.') . ' ' . $offer_item['money_icon'] ?><br> <?= $offer_item['discount_total_try'] != 0 ? number_format($offer_item['discount_total_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                                </div>
                                            <?php } ?>

                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col tb-col-md text-end"></div>
                                                <div class="nk-tb-col tb-col-md"><strong>Ara Toplam </strong></div>
                                                <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                <div class="nk-tb-col text-end"> <?= number_format($offer_item['sub_total'], 2, ',', '.') . ' ' . $offer_item['money_icon'] ?><br> <?= $offer_item['sub_total_try'] != 0 ? number_format($offer_item['sub_total_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                            </div>

                                            <?php if ($offer_item['tax_rate_1_amount'] != 0) { ?>
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col tb-col-md text-end"></div>
                                                    <div class="nk-tb-col tb-col-md"><strong>KDV Toplam (%1) </strong></div>
                                                    <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                    <div class="nk-tb-col text-end"> <?= number_format($offer_item['tax_rate_1_amount'], 2, ',', '.') . ' ' . $offer_item['money_icon'] ?><br> <?= $offer_item['tax_rate_1_amount_try'] != 0 ? number_format($offer_item['tax_rate_1_amount_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                                </div>
                                            <?php } ?>

                                            <?php if ($offer_item['tax_rate_10_amount'] != 0) { ?>
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col tb-col-md text-end"></div>
                                                    <div class="nk-tb-col tb-col-md"><strong>KDV Toplam (%10) </strong></div>
                                                    <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                    <div class="nk-tb-col text-end"> <?= number_format($offer_item['tax_rate_10_amount'], 2, ',', '.') . ' ' . $offer_item['money_icon'] ?><br> <?= $offer_item['tax_rate_10_amount_try'] != 0 ? number_format($offer_item['tax_rate_10_amount_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                                </div>
                                            <?php } ?>

                                            <?php if ($offer_item['tax_rate_20_amount'] != 0) { ?>
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col tb-col-md text-end"></div>
                                                    <div class="nk-tb-col tb-col-md"><strong>KDV Toplam (%20) </strong></div>
                                                    <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                    <div class="nk-tb-col text-end"> <?= number_format($offer_item['tax_rate_20_amount'], 2, ',', '.') . ' ' . $offer_item['money_icon'] ?><br> <?= $offer_item['tax_rate_20_amount_try'] != 0 ? number_format($offer_item['tax_rate_20_amount_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                                </div>
                                            <?php } ?>

                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col tb-col-md text-end"></div>
                                                <div class="nk-tb-col tb-col-md"><strong>Genel Toplam </strong></div>
                                                <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                <div class="nk-tb-col text-end"> <?= number_format($offer_item['grand_total'], 2, ',', '.') . ' ' . $offer_item['money_icon'] ?><br> <?= $offer_item['grand_total_try'] != 0 ? number_format($offer_item['grand_total_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                            </div>

                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col tb-col-md text-end"></div>
                                                <div class="nk-tb-col tb-col-md"><strong>Ödenecek Toplam </strong></div>
                                                <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                <div class="nk-tb-col text-end"> <?= number_format($offer_item['amount_to_be_paid'], 2, ',', '.') . ' ' . $offer_item['money_icon'] ?><br> <?= $offer_item['amount_to_be_paid_try'] != 0 ? number_format($offer_item['amount_to_be_paid_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                            </div>



                                        </div>
                                    </div>

                                </div><!-- data-list -->

                            </div><!-- .nk-block -->
                        </div>

                        <?= $this->include('tportal/teklifler/detay/inc/sol_menu') ?>
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