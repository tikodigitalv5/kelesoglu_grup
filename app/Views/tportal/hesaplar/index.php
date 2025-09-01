<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Tüm Hesaplar <?= $this->endSection() ?>
<?= $this->section('title') ?> Tüm Hesaplar | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>


<?= $this->section('main') ?>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Tüm Hesaplar</h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                    <li class="nk-block-tools-opt">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>Add User</span></a></li>
                                                    <li><a href="#"><span>Add Team</span></a></li>
                                                    <li><a href="#"><span>Import User</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .toggle-wrap -->
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                    <div class="form-inline flex-nowrap gx-3">
                                        <div class="form-wrap w-150px">
                                            <select class="form-select js-select2" data-search="off" data-placeholder="Toplu İşlem">
                                                <option value="">Toplu İşlem</option>
                                                <option value="#">İndir (Excel)</option>
                                                <option value="#">İndir (PDF)</option>
                                                <option value="#">Yazdır</option>
                                                <option value="#">Seçilenleri Sil</option>
                                            </select>
                                        </div>
                                        <div class="btn-wrap">
                                            <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light disabled">Uygula</button></span>
                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                        </div>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>
                                            <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                                        </li><!-- li -->
                                        <li class="btn-toolbar-sep"></li><!-- li -->
                                        <li>
                                            <div class="toggle-wrap">
                                                <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                <div class="toggle-content" data-content="cardTools">
                                                    <ul class="btn-toolbar gx-1">
                                                        <li class="toggle-close">
                                                            <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-trigger btn-icon dropdown-toggle d-none" data-bs-toggle="dropdown">
                                                                    <div class="dot dot-primary"></div>
                                                                    <em class="icon ni ni-filter-alt"></em>
                                                                </a>
                                                                <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                                    <div class="dropdown-head">
                                                                        <span class="sub-title dropdown-title">Detaylı Arama</span>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="btn btn-sm btn-icon">
                                                                                <em class="icon ni ni-more-h"></em>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dropdown-body dropdown-body-rg">
                                                                        <div class="row gx-6 gy-3">
                                                                            <div class="col-6">
                                                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input" id="hasBalance">
                                                                                    <label class="custom-control-label" for="hasBalance"> Have Balance</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input" id="hasKYC">
                                                                                    <label class="custom-control-label" for="hasKYC"> KYC Verified</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <label class="overline-title overline-title-alt">Role</label>
                                                                                    <select class="form-select js-select2">
                                                                                        <option value="any">Any Role</option>
                                                                                        <option value="investor">Investor</option>
                                                                                        <option value="seller">Seller</option>
                                                                                        <option value="buyer">Buyer</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <label class="overline-title overline-title-alt">Status</label>
                                                                                    <select class="form-select js-select2">
                                                                                        <option value="any">Any Status</option>
                                                                                        <option value="active">Active</option>
                                                                                        <option value="pending">Pending</option>
                                                                                        <option value="suspend">Suspend</option>
                                                                                        <option value="deleted">Deleted</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <button type="button" class="btn btn-secondary">Filter</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dropdown-foot between">
                                                                        <a class="clickable" href="#">Reset Filter</a>
                                                                        <a href="#">Save Filter</a>
                                                                    </div>
                                                                </div><!-- .filter-wg -->
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-setting"></em>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                                                    <ul class="link-check">
                                                                        <li><span>Sayfalama</span></li>
                                                                        <li class="active"><a href="#">10</a></li>
                                                                        <li><a href="#">20</a></li>
                                                                        <li><a href="#">50</a></li>
                                                                    </ul>


                                                                </div>
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                    </ul><!-- .btn-toolbar -->
                                                </div><!-- .toggle-content -->
                                            </div><!-- .toggle-wrap -->
                                        </li><!-- li -->
                                    </ul><!-- .btn-toolbar -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" class="form-control border-transparent form-focus-none" placeholder="Bulmak istediğiniz ürünün adını yada kodunu yazınız..">
                                        <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div><!-- .card-inner -->
                        <div class="card-inner p-0">
                            <div class="nk-tb-list nk-tb-ulist">
                                <div class="nk-tb-item nk-tb-head tb-tnx-head">
                                    <div class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid">
                                            <label class="custom-control-label" for="uid"></label>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col"><span class="sub-text">Hesap İsmi</span></div>
                                    <div class="nk-tb-col tb-col-mb w-max-110px"><span class="sub-text">Hesap Tipi</span></div>
                                    <div class="nk-tb-col tb-col-mb w-max-110px"><span class="sub-text">Döviz</span></div>
                                    <div class="nk-tb-col tb-col-mb w-max-110px"><span class="sub-text">Bakiye</span></div>
                                    <div class="nk-tb-col tb-col-md w-max-110px"><span class="sub-text">Durum</span></div>
                                    <div class="nk-tb-col nk-tb-col-tools text-end">

                                    </div>
                                </div><!-- .nk-tb-item -->


                                <?php foreach ($financial_account_items as $financial_account_item) { ?>

                                    <?php
                                    $cari_balance = $financial_account_item['account_balance'];
                                    $cari_money_unit_id = $financial_account_item['money_icon'];
                                    [$balanceColor, $balanceBgColor, $balanceText] = ($cari_balance == 0) ? ["text-secondary", "bg-secondary-dim", "-"] : ($cari_balance > 0 ? ["text-success", "bg-success-dim", "Borçlu"] : ["text-danger", "bg-danger-dim", "Alacaklı"]);

                                    helper('Helpers\number_format_helper');
                                    ?>

                                    <div class="nk-tb-item" data-url="<?= route_to('tportal.financial_accounts.detail', $financial_account_item['financial_account_id']); ?>">
                                        <div class="nk-tb-col nk-tb-col-check">
                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                <input type="checkbox" class="custom-control-input" id="uid2">
                                                <label class="custom-control-label" for="uid2"></label>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col">
                                            <div class="user-card">
                                                <div class="user-avatar <?= $balanceBgColor ?> sq">
                                                    <span> <?= mb_substr($financial_account_item['account_title'], 0, 1) ?> </span>
                                                </div>
                                                <div class="user-info">
                                                    <span class="tb-lead"><?= $financial_account_item['account_title'] ?> </span>
                                                    <span> <?= $financial_account_item['bank_iban'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            <div class="user-info">
                                                <span class="tb-lead"> <?php switch ($financial_account_item['account_type']) {
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
                                                                        } ?></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            <div class="user-info">
                                                <span class="tb-lead">(<?= $financial_account_item['money_icon'] ?>) <?= $financial_account_item['money_title'] ?><span class="dot dot-warning d-md-none ms-1"></span></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            <span class="tb-amount <?= $balanceColor ?> para"><?= convert_number_for_form($financial_account_item['account_balance'], 2)  . "<small>" . $cari_money_unit_id . "</small>" ?></span>
                                            <!-- <span class="fs-11px">7 Gün Vade</span> -->
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            <span class="tb-status <?= $balanceColor ?>"> <?= $balanceText ?> </span>
                                        </div>
                                        <div class="nk-tb-col nk-tb-col-tools text-end">
                                            <a href="<?= route_to('tportal.financial_accounts.detail', $financial_account_item['financial_account_id']); ?>" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                                        </div>


                                    </div><!-- .nk-tb-item -->

                                <?php } ?>


                            </div><!-- .nk-tb-list -->
                        </div><!-- .card-inner -->
                        <div class="card-inner">
                            <div class="nk-block-between-md g-3">
                                <div class="g">
                                    <ul class="pagination justify-content-center justify-content-md-start">
                                        <li class="page-item"><a class="page-link" href="#">Geri</a></li>
                                        <li class="page-item  active"><a class="page-link" style="color:#fff" href="#">1</a></li>

                                        <li class="page-item"><a class="page-link" href="#">İleri</a></li>
                                    </ul><!-- .pagination -->
                                </div>
                                <div class="g d-none">
                                    <div class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                                        <div>Page</div>
                                        <div>
                                            <select class="form-select js-select2" data-search="on" data-dropdown="xs center">
                                                <option value="page-1">1</option>
                                                <option value="page-2">2</option>
                                                <option value="page-4">4</option>
                                                <option value="page-5">5</option>
                                                <option value="page-6">6</option>
                                                <option value="page-7">7</option>
                                                <option value="page-8">8</option>
                                                <option value="page-9">9</option>
                                                <option value="page-10">10</option>
                                                <option value="page-11">11</option>
                                                <option value="page-12">12</option>
                                                <option value="page-13">13</option>
                                                <option value="page-14">14</option>
                                                <option value="page-15">15</option>
                                                <option value="page-16">16</option>
                                                <option value="page-17">17</option>
                                                <option value="page-18">18</option>
                                                <option value="page-19">19</option>
                                                <option value="page-20">20</option>
                                            </select>
                                        </div>
                                        <div>OF 102</div>
                                    </div>
                                </div><!-- .pagination-goto -->
                            </div><!-- .nk-block-between -->
                        </div><!-- .card-inner -->
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    $(".nk-tb-item").click(function() {
        // alert($(this).data('url'));
        window.location.href = $(this).data('url');
    });
</script>

<?= $this->endSection() ?>