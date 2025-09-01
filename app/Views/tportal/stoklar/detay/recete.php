<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Ürün Reçetesi <?= $this->endSection() ?>
<?= $this->section('title') ?> Ürün Reçetesi | <?= $stock_item['stock_code'] ?> - <?= $stock_item['stock_title'] ?> <?= $this->endSection() ?>
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
                                        <h4 class="nk-block-title">Ürün Reçetesi</h4>
                                    </div>
                                    <div class="nk-block-head-content align-self-start">
                                    <a href="#" id="btn_recete_kopyala" data-bs-toggle="modal" data-bs-target="#mdl_recete_kopyala" class="btn btn-secondary">Reçete Kopyala</a>

                                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#mdl_recipe_item_create">Yeni Reçete Elemanı</a>
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1 d-lg-none"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                    <table id="example" class="datatable-init-operasyonlar table-responsive table"
                                        data-export-title="Export">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2; width:80px">Tipi</th>
                                                <!-- <th style="background-color: #ebeef2;">Ürün Kodu</th> -->
                                                <th style="background-color: #ebeef2;" data-orderable="false">Ürün</th>
                                                <!-- <th style="background-color: #ebeef2; text-align:center;">Kullanılan
                                                </th> -->
                                                <!-- <th style="background-color: #ebeef2; text-align:center;">Fire</th> -->
                                                <th style="background-color: #ebeef2; text-align:center;" data-orderable="false">Toplam</th>
                                                <th style="background-color: #ebeef2; text-align:center;" data-orderable="false">Birim Fiyat
                                                </th>
                                                <th style="background-color: #ebeef2; text-align:center;" data-orderable="false">Tutar</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($stock_recipe_items as $stock_recipe_item){ 
                                            $all_total_cost += $stock_recipe_item['total_cost'];    
                                            ?>
                                            <tr>
                                                <td><?= $stock_recipe_item['type_title'] ?></td>
                                                <!-- <td><?= $stock_recipe_item['stock_code'] ?></td> -->
                                                <td><?= $stock_recipe_item['stock_title'] ?></td>
                                                <!-- <td class="text-end pe-4">
                                                    <?= number_format($stock_recipe_item['used_amount'], 2, ',', '.') ?>
                                                    <?= $stock_recipe_item['buy_unit_value'] ?></td> -->
                                                <!-- <td class="text-end pe-4">
                                                    <?= number_format($stock_recipe_item['wastage_amount'], 2, ',', '.') ?>
                                                    <?= $stock_recipe_item['buy_unit_value'] ?></td> -->
                                                <td class="text-end pe-4">
                                                    <?= number_format($stock_recipe_item['total_amount'], 2, ',', '.') ?>
                                                    <?= $stock_recipe_item['buy_unit_value'] ?></td>
                                                <td class="text-end pe-4">
                                                    <?= number_format($stock_recipe_item['buy_unit_price'], 2, ',', '.') ?>
                                                    <?= $stock_recipe_item['buy_money_icon'] ?></td>
                                                <td class="text-end pe-4">
                                                    <?= number_format($stock_recipe_item['total_cost'], 2, ',', '.') ?>
                                                    <?= $stock_recipe_item['buy_money_icon'] ?></td>
                                                <td class="text-end">
                                                    <a href="#"
                                                        class="btn btn-icon btn-xs btn-dim btn-outline-dark edit-action"
                                                        data-bs-toggle="modal" data-bs-target="#mdl_recipe_item_edit"
                                                        data-stock-id="<?= $stock_recipe_item['stock_id'] ?>"
                                                        data-stock-code="<?= $stock_recipe_item['stock_code'] ?>"
                                                        data-unit-price="<?= number_format($stock_recipe_item['buy_unit_price'], 4, ',', '.'); ?>"
                                                        data-money-title="<?= $stock_recipe_item['buy_money_title'] ?>"
                                                        data-unit-value="<?= $stock_recipe_item['buy_unit_value'] ?>"
                                                        data-used-amount="<?= number_format($stock_recipe_item['used_amount'], 4, ',', '.'); ?>"
                                                        data-wastage-amount="<?= number_format($stock_recipe_item['wastage_amount'], 4, ',', ' '); ?>"
                                                        data-total-amount="<?=number_format($stock_recipe_item['total_amount'], 4, ',', '.'); ?>"
                                                        data-total-cost="<?= number_format($stock_recipe_item['total_cost'], 4, ',', '.'); ?>"><em
                                                            class="icon ni ni-pen-alt-fill"></em></a>
                                                    <a href="#"
                                                        class="btn btn-icon btn-xs btn-dim btn-outline-danger delete-action"
                                                        data-bs-toggle="modal" data-bs-target="#mdl_recipe_item_delete"
                                                        data-item-id="<?= $stock_recipe_item['recipe_item_id'] ?>"
                                                        data-recipe-id="<?= $stock_recipe_item['recipe_id'] ?>"><em
                                                            class="icon ni ni-trash-empty"></em></a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>

                                            <tr style="background-color: #ebeef2;">
                                                <td style="background-color: #ebeef2;"></td>
                                                <!-- <td style="background-color: #ebeef2;"></td>
                                                <td style="background-color: #ebeef2;"></td>
                                                <td style="background-color: #ebeef2;"></td> -->
                                                <td style="background-color: #ebeef2;"></td>
                                                <td style="background-color: #ebeef2;"></td>
                                                <td style="background-color: #ebeef2;text-align: right;">
                                                    <strong>TOPLAM</strong>
                                                </td>
                                                <td style="background-color: #ebeef2;" class="text-end pe-4 para">
                                                    <strong><?= convert_number_for_form($all_total_cost, 2) ?> <?= $stock_item['buy_money_icon'] ?></strong>
                                                </td>

                                                <td style="background-color: #ebeef2;"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- data-list -->

                            </div><!-- .nk-block -->
                        </div>

                        <?= $this->include('tportal/stoklar/detay/inc/sol_menu') ?>
                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" id="mdl_recete_kopyala">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reçete Kopyala</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="copyStockOperationForm" method="post" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="source_stock_id">Ürün Seç</label>
                        <div class="form-control-wrap">
                            <select class="form-select init-select2" data-search="on" data-ui="xl" name="source_stock_id" id="source_stock_id">
                                <option value="" disabled selected>Lütfen Ürün Seçiniz</option>
                                <?php foreach($stock_items as $item){ ?>
                                <option value="<?= $item['stock_id'] ?>"><?= $item['stock_code'] ?> - <?= $item['stock_title'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div id="operasyonListesiContainer" style="display:none;">
                        <div class="nk-block mt-4">
                            <div class="card">
                                <div class="card-inner p-0">
                                    <div id="loadingOperations" class="text-center p-5" style="display:none;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Yükleniyor...</span>
                                        </div>
                                        <p class="mt-2 text-muted">Reçeteler Yükleniyor...</p>
                                    </div>
                                    
                                    <div id="noOperationsMessage" class="alert alert-pro alert-warning alert-icon m-3" style="display:none;">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong>Reçete Bulunamadı</strong>
                                        <p class="mt-1 mb-0">Bu ürüne ait reçete kaydı bulunmamaktadır.</p>
                                    </div>

                                    <div id="operationsTable" style="display:none;">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-middle mb-0 align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="text-center">Tipi</th>
                                                        <th>Ürün Adı</th>
                                                        <th>Ürün Kodu</th>
                                                        <th class="text-end">Birim Fiyat</th>
                                                        <th class="text-end">Kullanılan Miktar</th>
                                                        <th class="text-end">Fire Miktar</th>
                                                        <th class="text-end">Toplam Miktar</th>
                                                        <th class="text-end">Maliyet Miktar</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="operationsTableBody">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" class="btn btn-lg btn-dim btn-outline-light" data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <button type="button" id="operasyonKopyala" class="btn btn-lg btn-primary" disabled>KOPYALA</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Alert 2 -->
<div class="modal fade" tabindex="-1" id="mdl_recipe_item_create">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Reçete Elemanı</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="form_recipe_item_create"
                    data-recipe-id="<?= $recipe_item['recipe_id'] ?>" method="post" class="form-validate is-alter">
                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-12 col-xxl-12 col-12">
                            <label class="form-label" for="create_stock_id">Ürün Adı</label>
                            <div class="form-control-wrap">
                                <select class="form-select init-select2" data-search="on" data-ui="xl"
                                    name="stock_id" id="create_stock_id" placeholder="Lütfen Ürün Seçiniz">
                                    <option value="" selected>Lütfen Ürün Seçiniz</option>
                                    <?php
                                    foreach($all_stock_items as $all_stock_item){
                                        echo '
                                            <option value="'.$all_stock_item['stock_id'].'" data-money-title="'.$all_stock_item['buy_money_icon'].'" data-stock-code="'.$all_stock_item['stock_code'].'" data-unit-price="'.number_format($all_stock_item['buy_unit_price'], 4, ',', '.').'" data-unit-value="'.$all_stock_item['buy_unit_value'].'">'.$all_stock_item['stock_code'].' - '.$all_stock_item['stock_title'].'</option>
                                        ';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="create_stock_code">Ürün Kodu</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" id="create_stock_code"
                                    name="stock_code" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="create_unit_price">Birim Fiyat</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl" required disabled
                                        id="create_unit_price" name="unit_price">
                                    <div class="input-group-append">
                                        <span class="input-group-text create_money_title" id="basic-addon2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="create_used_amount">Kullanılan Miktar</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl" required
                                        id="create_used_amount" name="used_amount"
                                        onkeypress="return SadeceRakam(event,[',','-']);">
                                    <div class="input-group-append">
                                        <span class="input-group-text create_unit_title" id="basic-addon2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="create_wastage_amount">Fire Miktarı</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl" required
                                        id="create_wastage_amount" name="wastage_amount"
                                        onkeypress="return SadeceRakam(event,[',','-']);">
                                    <div class="input-group-append">
                                        <span class="input-group-text create_unit_title" id="basic-addon2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="create_total_amount">Toplam Miktar</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl" required disabled
                                        id="create_total_amount" name="total_amount">
                                    <div class="input-group-append">
                                        <span class="input-group-text create_unit_title" id="basic-addon2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="create_total_cost">Toplam Maliyet</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl" required disabled
                                        id="create_total_cost" name="total_cost">
                                    <div class="input-group-append">
                                        <span class="input-group-text create_money_title" id="basic-addon2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-dim btn-outline-light"
                            data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <!-- <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ HESAP</button> -->
                        <button type="button" id="form_recipe_item_create_save"
                            class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Alert 2 -->
<div class="modal fade" tabindex="-1" id="mdl_recipe_item_edit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reçete Elemanı Düzenle</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="form_recipe_item_edit" method="post" class="form-validate is-alter"
                    data-recipe-id="<?= $recipe_item['recipe_id'] ?>">
                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="edit_stock_code">Ürün Kodu</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" id="edit_stock_code"
                                    name="stock_code" disabled>
                                <input type="hidden" class="form-control form-control-xl" id="edit_stock_id"
                                    name="stock_id" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="edit_unit_price">Birim Fiyat</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl" required disabled
                                        id="edit_unit_price" name="unit_price">
                                    <div class="input-group-append">
                                        <span class="input-group-text edit_money_title" id="basic-addon2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="edit_used_amount">Kullanılan Miktar</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl" required
                                        id="edit_used_amount" name="used_amount"
                                        onkeypress="return SadeceRakam(event,[',','-']);">
                                    <div class="input-group-append">
                                        <span class="input-group-text edit_unit_title" id="basic-addon2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="edit_wastage_amount">Fire Miktarı</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl" required
                                        id="edit_wastage_amount" name="wastage_amount"
                                        onkeypress="return SadeceRakam(event,[',','-']);">
                                    <div class="input-group-append">
                                        <span class="input-group-text edit_unit_title" id="basic-addon2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="edit_total_amount">Toplam Miktar</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl" required disabled
                                        id="edit_total_amount" name="total_amount">
                                    <div class="input-group-append">
                                        <span class="input-group-text edit_unit_title" id="basic-addon2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="edit_total_cost">Toplam Maliyet</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl" required disabled
                                        id="edit_total_cost" name="total_cost">
                                    <div class="input-group-append">
                                        <span class="input-group-text edit_money_title" id="basic-addon2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-dim btn-outline-light"
                            data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <!-- <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ HESAP</button> -->
                        <button type="button" id="form_recipe_item_edit_save"
                            class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button type="button" id="trigger_recipe_item_ok" class="btn btn-success d-none" data-bs-toggle="modal"
    data-bs-target="#mdl_recipe_item_ok">OK</button>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" id="mdl_recipe_item_ok">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                    <h4 class="nk-modal-title">İşlem Başarılı!</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text" id="txt_OK"></div>
                        </span>
                    </div>
                    <div class="nk-modal-action">
                        <a href="#" class="btn btn-l btn-mw btn-primary" data-bs-toggle="modal"
                            data-bs-target="#mdl_recipe_item_create">Yeni Reçete Elemanı Ekle</a>
                        <a href="#" data-bs-dismiss="modal" onclick="location.reload()"
                            class="btn btn-l btn-mw btn-secondary">Reçete Listesine
                            Dön</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="mdl_recipe_item_delete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent"
                        style="font-size: 70px;"></em>
                    <h4 class="nk-modal-title">Reçete Elemanını İstediğinize<br>Emin misiniz?</h4>
                    <div class="nk-modal-action mb-5">
                        <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger" id="delete-action"
                            data-bs-dismiss="modal">Evet</a>
                    </div>
                    <div class="nk-modal-text">
                        <!-- <p class="lead">Bu ürünü silmeniz için;<br>mevcut herhangi bir üretim emri olmamalıdır.</p> -->
                        <p class="text-soft">Silmeden önce lütfen yetkilinize danışınız.</p>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select2'yi başlat
    if($.fn.select2) {
        $('#source_stock_id').select2({
            dropdownParent: $('#mdl_recete_kopyala')
        });
    }

    // Operasyon kopyalama işlemleri
    $('#source_stock_id').on('change', function() {
        var stockId = $(this).val();
        
        if(stockId) {
            $('#operationsTable').hide();
            $('#noOperationsMessage').hide();
            $('#loadingOperations').show();
            $('#operasyonListesiContainer').show();
            $('#operasyonKopyala').prop('disabled', true);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.stocks.get_recipes') ?>',
                dataType: 'json',
                data: {
                    stock_id: stockId
                },
                success: function(response) {
                    var tbody = $('#operationsTableBody');
                    tbody.empty();
                    
                    if(response && response.recipe_items && response.recipe_items.length > 0) {
                        response.recipe_items.forEach(function(item) {
                            var row = `
                                <tr>
                                    <td class="text-center"><span class="badge bg-secondary">${item.type_title || '-'}</span></td>
                                    <td><span class="fw-bold text-dark">${item.stock_title || '-'}</span></td>
                                    <td><span class="text-muted">${item.stock_code || '-'}</span></td>
                                    <td class="text-end">
                                        <span class="fw-bold">${item.buy_unit_price || '-'}</span>
                                        <span class="badge bg-light text-dark ms-1">${item.buy_money_icon || ''}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold">${item.used_amount || '-'}</span>
                                        <span class="badge bg-light text-dark ms-1">${item.buy_unit_value || ''}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold">${item.wastage_amount || '-'}</span>
                                        <span class="badge bg-light text-dark ms-1">${item.buy_unit_value || ''}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold">${item.total_amount || '-'}</span>
                                        <span class="badge bg-light text-dark ms-1">${item.buy_unit_value || ''}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold">${item.total_cost || '-'}</span>
                                        <span class="badge bg-light text-dark ms-1">${item.buy_money_icon || ''}</span>
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                        
                        $('#operationsTable').show();
                        $('#operasyonKopyala').prop('disabled', false);
                    } else {
                        $('#noOperationsMessage').show();
                        $('#operasyonKopyala').prop('disabled', true);
                    }
                    
                    $('#loadingOperations').hide();
                },
                error: function(xhr, status, error) {
                    console.error('Ajax Hatası:', error);
                    $('#loadingOperations').hide();
                    $('#noOperationsMessage').show().find('span').text('Reçete elemanları yüklenirken bir hata oluştu.');
                    $('#operasyonKopyala').prop('disabled', true);
                }
            });
        } else {
            $('#operasyonListesiContainer').hide();
            $('#operasyonKopyala').prop('disabled', true);
        }
    });

    // Operasyon kopyalama butonu işlemi
    $('#operasyonKopyala').on('click', function() {
        const sourceStockId = $('#source_stock_id').val();
        const selectedText = $('#source_stock_id option:selected').text();
        $("#mdl_recete_kopyala").modal("hide");
        Swal.fire({
            title: 'Reçeteleri Kopyala',
            html: `<div class="text-start">
                    <p class="mb-2"><strong>${selectedText}</strong> ürününün reçetelerini şu anki ürüne kopyalamak istediğinize emin misiniz?</p>
                    <div class="alert alert-warning mt-3">
                        <em class="icon ni ni-alert-circle"></em>
                        <strong>Not:</strong> Bu işlem mevcut reçeteleri etkilemeyecektir.
                    </div>
                   </div>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#364a63',
            confirmButtonText: 'Evet, Kopyala',
            cancelButtonText: 'İptal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= base_url('tportal/stock/copy-recipe/'.$stock_item['stock_id']) ?>',
                    dataType: 'json',
                    data: {
                        source_stock_id: sourceStockId
                    },
                    success: function(response) {
                        if(response.icon === 'success') {
                            $('#txt_OK').html('Reçeteler Başarıyla Kopyalandı');
                            $("#triggerModaloperasyonKopyalaOK").click();
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata',
                                text: response.message || 'Bir hata oluştu',
                                confirmButtonText: 'Tamam'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Kopyalama Hatası:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            text: 'Reçeteler kopyalanırken bir hata oluştu',
                            confirmButtonText: 'Tamam'
                        });
                    }
                });
            }else{
                $("#mdl_recete_kopyala").modal("show");
            }
        });
    });
});
</script>



<script>

$('.delete-action').on('click', function(e) {
    recipe_item_id = $(this).attr('data-item-id');
    recipe_id = $(this).attr('data-recipe-id');

    $('#delete-action').attr('data-recipe-id', recipe_id);
    $('#delete-action').attr('data-item-id', recipe_item_id);
});

$('#delete-action').on('click', function(e) {
    recipe_id = $(this).attr('data-recipe-id');
    item_id = $(this).attr('data-item-id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.content_delete') ?>',
        dataType: 'json',
        data: {
            recipe_id: recipe_id,
            recipe_item_id: item_id,
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#trigger_recipe_item_ok").trigger("click");
            }
        }
    })
});

$('.edit-action').on('click', function() {
    stock_code = $(this).attr('data-stock-code');
    stock_id = $(this).attr('data-stock-id');
    unit_price = $(this).attr('data-unit-price');
    money_title = $(this).attr('data-money-title');
    unit_title = $(this).attr('data-unit-value');
    used_amount = $(this).attr('data-used-amount');
    wastage_amount = $(this).attr('data-wastage-amount');
    total_amount = $(this).attr('data-total-amount');
    total_cost = $(this).attr('data-total-cost');

    $('#edit_stock_code').val(stock_code);
    $('#edit_stock_id').val(stock_id);
    $('#edit_unit_price').val(unit_price);
    $('#edit_used_amount').val(used_amount);
    $('#edit_wastage_amount').val(wastage_amount);
    $('#edit_total_amount').val(total_amount);
    $('#edit_total_cost').val(total_cost);

    $('.edit_unit_title').html(unit_title);
    $('.edit_money_title').html(money_title);
})

$('#form_recipe_item_edit_save').on('click', function(e) {
    if ($('#edit_type_id').val() == '' ||
        $('#edit_stock_code').val() == '' ||
        $('#edit_used_amount').val() == '') {
        swetAlert("Eksik Alanlar Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
    } else {
        var formData = $('#form_recipe_item_edit').serializeArray();
        formData.push({
            name: 'recipe_id',
            value: $('#form_recipe_item_edit').attr('data-recipe-id')
        });
        formData.push({
            name: 'stock_id',
            value: $('#edit_stock_id').val()
        });

        console.log(formData);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.content_edit') ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    $("#trigger_recipe_item_ok").trigger("click");
                } else {
                    $('#mdl_recipe_item_edit').modal('toggle');
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })

                    Toast.fire({
                        icon: response['icon'],
                        title: response['message']
                    })
                }
            }
        })
    }
});

$('#create_stock_id').on('change', function() {
    unitPrice = $('option:selected', this).attr('data-unit-price');
    unitTitle = $('option:selected', this).attr('data-unit-value');
    stockCode = $('option:selected', this).attr('data-stock-code');
    moneyTitle = $('option:selected', this).attr('data-money-title');

    $('#create_unit_price').val(unitPrice);
    $('#create_stock_code').val(stockCode);

    $('.create_unit_title').html(unitTitle);
    $('.create_money_title').html(moneyTitle);

    $('#create_total_amount').val('');
    $('#create_total_cost').val('');
    $('#create_used_amount').val('');
    $('#create_wastage_amount').val('');

});

// number_format = function(number, decimals, dec_point, thousands_sep) {
//     number = number.toFixed(decimals);

//     var nstr = number.toString();
//     nstr += '';
//     x = nstr.split('.');
//     x1 = x[0];
//     x2 = x.length > 1 ? dec_point + x[1] : '';
//     var rgx = /(\d+)(\d{3})/;

//     while (rgx.test(x1))
//         x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

//     return x1 + x2;
// }

calculate_recipe_item = function(element) {
    tempUnitPrice = $('#' + element + '_unit_price').val()
    unitPrice = replace_for_calculation(tempUnitPrice)

    tempUsedAmount = $('#' + element + '_used_amount').val();
    tempWastageAmount = $('#' + element + '_wastage_amount').val();
    used_amount = replace_for_calculation(tempUsedAmount)
    wastage_amount = replace_for_calculation(tempWastageAmount)
    if (wastage_amount == null || wastage_amount == '') {
        wastage_amount = 0
    }else if(isNaN(wastage_amount)){
        wastage_amount = 0
    }

    if (used_amount == null || used_amount == '' || used_amount == NaN){
        used_amount = 0
    }else if (isNaN(used_amount)){
        used_amount = 0
    }

    tempTotalVal = parseFloat(used_amount) + parseFloat(wastage_amount);
    total_amount = replace_for_form_input(parseFloat(tempTotalVal).toFixed(4))
    $('#' + element + '_total_amount').val(total_amount);

    tempTotalCost = parseFloat(unitPrice) * parseFloat(tempTotalVal)
    total_cost = replace_for_form_input(parseFloat(tempTotalCost).toFixed(4))
    $('#' + element + '_total_cost').val(total_cost);
}

$('#edit_used_amount').on('blur', function() {
    if ($('#edit_used_amount').val() != null && $('#edit_used_amount').val() != '') {
        calculate_recipe_item('edit')

        tempValue = $('#edit_used_amount').val()
        tempValue = replace_for_calculation(tempValue)
        tempValue = replace_for_form_input(tempValue)
        $('#edit_used_amount').val(tempValue)
    }
})

$('#edit_wastage_amount').on('blur', function() {
    if ($('#edit_wastage_amount').val() != null && $('#edit_wastage_amount').val() != '') {
        calculate_recipe_item('edit')

        tempValue = $('#edit_wastage_amount').val()
        tempValue = replace_for_calculation(tempValue)
        tempValue = replace_for_form_input(tempValue)
        $('#edit_wastage_amount').val(tempValue)
    }
})

$('#create_used_amount').on('blur', function() {
    if ($('#create_used_amount').val() != null && $('#create_used_amount').val() != '') {
        calculate_recipe_item('create')

        tempValue = $('#create_used_amount').val()
        tempValue = replace_for_calculation(tempValue)
        tempValue = replace_for_form_input(tempValue)
        $('#create_used_amount').val(tempValue)
    }
})

$('#create_wastage_amount').on('blur', function() {
    if ($('#create_wastage_amount').val() != null && $('#create_wastage_amount').val() != '') {
        calculate_recipe_item('create')

        tempValue = $('#create_wastage_amount').val()
        tempValue = replace_for_calculation(tempValue)
        tempValue = replace_for_form_input(tempValue)
        $('#create_wastage_amount').val(tempValue)
    }
})

$('#form_recipe_item_create_save').on('click', function() {
    if ($('#create_type_id').val() == '' ||
        $('#create_stock_id').val() == '' ||
        $('#create_used_amount').val() == '') {
        swetAlert("Eksik Birşeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
    } else {
        var formData = $('#form_recipe_item_create').serializeArray();
        formData.push({
            name: 'recipe_id',
            value: $('#form_recipe_item_create').attr('data-recipe-id')
        });
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.content_create') ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                console.log(response)
                if (response['icon'] == 'success') {
                    $('#form_recipe_item_create')[0].reset();
                    $("#trigger_recipe_item_ok").click();
                    $('#create_stock_id').trigger('change');
                } else {
                    $('#mdl_recipe_item_create').modal('toggle');
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })

                    Toast.fire({
                        icon: response['icon'],
                        title: response['message']
                    })
                }
            }
        })
    }
});
</script>

<?= $this->endSection() ?>

<style>
.table-hover tbody tr:hover {
    background-color: #f5f7fa;
}
.badge.bg-light {
    background: #f1f3f7;
    color: #333;
    font-weight: 500;
}
</style>