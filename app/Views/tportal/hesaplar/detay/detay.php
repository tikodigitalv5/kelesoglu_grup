<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Hesap Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Hesap Detay | <?= $financial_account_item['account_title'] ?> <?= $this->endSection() ?>
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
                                        <h4 class="nk-block-title">Hesap Bilgileri</h4>
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
                                            <span class="data-label">Hesap Tipi</span>
                                            <span class="data-value">
                                                <?php switch ($financial_account_item['account_type']) {
                                                    case 'vault':
                                                        echo "Kasa";
                                                        break;
                                                    case 'bank':
                                                        echo "Banka";
                                                        break;
                                                    case 'pos':
                                                        echo "POS";
                                                        break;
                                                    case 'check_bill':
                                                        echo "ÇEK/SENET";
                                                        break; 
                                                    case 'credit_card':
                                                        echo "Kredi Kartı";
                                                        break;
                                                } ?>
                                            </span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-lock-alt"></em></span></div>
                                    </div><!-- data-item -->
                                    <?php if($financial_account_item['account_type'] != 'check_bill'): ?>
                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Banka Adı</span>
                                            <!-- Bu sayfa kasaysa veya kredi kartıysa farklı şekillerde olabilmeli. Ceyhun Bey ile konuşmak gerekiyor. -->
                                            <!-- Banka Adını çekebilmek için aşağıdaki fonksyionu kullan -->
                                            <!-- İleride mapleyerek getireceğimiz için daha hızlı ulaşabilicez. Şu anda performansı sorun etmiyoruz -->
                                            <?php if (isset($bank_items) && $financial_account_item['bank_id'] != null) {
                                                echo $bank_items[array_search($financial_account_item['bank_id'], array_column($bank_items, 'bank_id'))]['bank_title'];
                                            } else {
                                                echo " - ";
                                            }  ?>
                                            <!-- <span class="data-value">QNB Finansbank</span> -->
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->

                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Banka Şubesi</span>
                                            <span class="data-value"><?= $financial_account_item['account_title'] ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Banka Hesap No</span>
                                            <span class="data-value"><?= $financial_account_item['bank_account_number'] != "" ? $financial_account_item['bank_account_number'] : "-" ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Banka IBAN</span>
                                            <span class="data-value"><?= $financial_account_item['bank_iban'] != "" ? $financial_account_item['bank_iban'] : "-" ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <?php endif; ?>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Para Birimi</span>
                                            <span class="data-value">(<?= $financial_account_item['money_icon'] . ") " . $financial_account_item['money_code'] . " - " . $financial_account_item['money_title'] ?> </span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->

                                </div><!-- data-list -->

                            </div><!-- .nk-block -->
                        </div>

                        <?= $this->include('tportal/hesaplar/detay/inc/sol_menu') ?>
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