<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Cari Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Cari Detay | <?= $cari_item['invoice_title'] == '' ? $cari_item['name'] . " " . $cari_item['surname'] : $cari_item['invoice_title'] ?> <?= $this->endSection() ?>
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
                                        <h4 class="nk-block-title">Cari Bilgileri</h4>

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
                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Cari Kodu</span>
                                            <span class="data-value"><?= $cari_item['cari_code'] ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                    </div><!-- data-item -->

                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Cari Tipi</span>
                                            <span class="data-value"><?= $cari_item['is_customer'] == 1 ? "Müşteri" : "" ?> <br> <?= $cari_item['is_supplier'] == 1 ? "Tedarikçi" : "" ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">T.C./Vergi No<br>V.Dairesi</span>
                                            <span class="data-value"><?= $cari_item['identification_number'] == 0 ? "" : $cari_item['identification_number'] ?><br><?= $cari_item['tax_administration'] ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <?php if ($cari_item['company_type'] == 'person') { ?>
                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                            <div class="data-col">
                                                <span class="data-label">Fatura Ünvan</span>
                                                <span class="data-value"><?= $cari_item['name'] . " " . $cari_item['surname'] ?></span>
                                            </div>
                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                        </div><!-- data-item -->
                                    <?php } else { ?>
                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                            <div class="data-col">
                                                <span class="data-label">Fatura Ünvan</span>
                                                <span class="data-value"><?= $cari_item['invoice_title'] ?></span>
                                            </div>
                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                        </div><!-- data-item -->
                                    <?php } ?>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Mükellefiyet</span>
                                            <span class="data-value"><?= $cari_item['obligation'] == "e-invoice" ? "E-Fatura" : "" ?> <?= $cari_item['obligation'] == "e-archive" ? "E-Arşiv Fatura" : "" ?> </span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->

                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Fatura Adresi</span>
                                            <span class="data-value"><?= $cari_item['address'] ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">İletişim</span>
                                            <span class="data-value"><?= $cari_item['cari_email'] ?> / <span id="cari_phone"> <?= $cari_item['cari_phone'] ?></span></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Cari Notu</span>
                                            <span class="data-value"><?= nl2br(htmlspecialchars($cari_item['cari_note'], ENT_QUOTES, 'UTF-8')); ?> </span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                </div><!-- data-list -->

                            </div><!-- .nk-block -->
                        </div>

                        <?= $this->include('tportal/cariler/detay/inc/sol_menu') ?>
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
    $(document).ready(function() {
        $("#cari_phone").mask("+00 (000) 000 0000");
    });
</script>

<?= $this->endSection() ?>