<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Tedarikçi İade <?= $this->endSection() ?>
<?= $this->section('title') ?> Tedarikçi İade | <?= session()->get('user_item')['firma_adi'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>



<?= helper('Helpers\barcode_helper'); ?>
<?= helper('Helpers\number_format_helper'); ?>
<?= $this->section('main') ?>



<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content  d-xl-none">
                        <h3 class="nk-block-title page-title">Tedarikçi İade</h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">

                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="card card-stretch">
                    <form onsubmit="return false;" id="create_sale_order_form" method="POST">
                        <div class="card-inner-group">
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="gy-3">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-3 ">
                                            <div class="form-group">
                                                <label class="form-label" for="from_warehouse">Çıkış Deposu</label>
                                                <span class="form-note d-none d-md-block">Ürün çıkışı yapılacak
                                                    depo.</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3  mt-0 mt-md-2">
                                            <select class="form-select  init-select2" data-search="on" data-ui="xl" name="from_warehouse" id="from_warehouse">
                                                <option selected value="<?= $warehouse_items['warehouse_id'] ?>">
                                                    <?= $warehouse_items['warehouse_title'] ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-3 ">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Tedarikçi</label>
                                                <span class="form-note d-none d-md-block">İade yapılacak tedarikçiyi seçin veya ekleyin.</span>
                                            </div>
                                        </div>
                                        <div class="col mt-0 mt-md-2">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-xl" id="account" name="account" value="<?= isset($cari_item) ? $cari_item['invoice_title'] == '' ? $cari_item['name'] . " " . $cari_item['surname'] : $cari_item['invoice_title'] : ''; ?>" placeholder="İade seçmek için tıklayınız.." readonly="readonly">
                                                    <div class="input-group-append">
                                                        <a href="javascript;" id="mdl_tedarikciSec" data-bs-toggle="modal" data-bs-target="#mdl_tedarikciSecs" class="btn btn-lg btn-block btn-dim btn-outline-primary" <?= isset($cari_item) ? "style='pointer-events: none; cursor: default; opacity:0.53; '" : ""  ?>>İade Tedarikçi Seç</a>
                                                        <!-- <button class="btn btn-lg btn-block btn-dim btn-outline-light">EKLE</button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="gy-3">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-3 col-xxl-3 ">
                                            <div class="form-group"><label class="form-label" for="add_barcode_number">Stok Barkod</label><span class="form-note d-none d-md-block">Sevk etmek istediğiniz ürünün barkodunu okutunuz.</span></div>
                                        </div>
                                        <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" id="add_barcode_number" class="form-control form-control-xl" name="barcode_number" placeholder="Eklemek istediğiniz ürünün barkodunu okutunuz.">
                                                    <div class="input-group-append">
                                                        <div id="btn_cikart_aktif" class="btn btn-outline-primary btn-dim"> Çıkart</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner position-relative card-tools-toggle urun_cikart">
                                <div class="gy-3">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-3 col-xxl-3 ">
                                            <div class="form-group"><label class="form-label" for="site-name">Stok Çıkart</label>
                                                <span class="form-note d-none d-md-block">Sevkten çıkartmak istediğinizin ürünün barkodunu okutunuz.</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" id="remove_barcode_number" class="form-control form-control-xl" placeholder="Çıkartmak istediğiniz ürünün barkodunu okutunuz.">
                                                    <div class="input-group-append">
                                                        <div id="btn_cikart_pasif" class="btn btn-outline-primary btn-dim">
                                                            Kapat</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="row g-3 pt-3 align-center">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label" for="remaining_quantity">Stok Ürün Bilgisi</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xxl-3 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" id="stock_code" class="form-control form-control-xl text-right" placeholder="Ürün Kodu" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ürün Kodu" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xxl-3 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" id="stock_title" class="form-control form-control-xl text-right" placeholder="Ürün Adı" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ürün Adı" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-3 col-xxl-3 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" id="stock_info"
                                                        class="form-control form-control-xl text-right" placeholder="Stok Ürün Bilgisi" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>

                                <div class="row g-3 pt-3 align-center">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label" for="remaining_quantity">Barkodtaki Miktar</label><span class="form-note d-none d-md-block">Okutulan barkodtaki ürün miktarı.</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xxl-2 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" id="remaining_quantity" class="form-control form-control-xl text-right" placeholder="0.0000" disabled>
                                                    <div class="input-group-append">
                                                        <!-- İlerleyen zamanlarda bu aktif olucak -->
                                                        <span class="input-group-text" id="sale_order_unit">m.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 pt-3 align-center">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label" for="sale_order_quantity">İade Miktarı</label><span class="form-note d-none d-md-block">İade yapılan ürün miktarı.</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xxl-2 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="sale_order_quantity" id="sale_order_quantity" class="form-control form-control-xl text-right calc" placeholder="0,0000" onkeypress="return SadeceRakam(event,[',']);">
                                                    <div class="input-group-append">
                                                        <!-- İlerleyen zamanlarda bu aktif olucak -->
                                                        <span class="input-group-text" id="sale_order_unit2">m.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 pt-3 align-center">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label" for="sale_order_quantity">Birim Fiyatı</label><span class="form-note d-none d-md-block">İade yapılan ürünün birim fiyatı.</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-xxl-2 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control form-control-xl calc" id="sale_unit_price" value="0,00" placeholder="0,00" name="sale_unit_price" onkeypress="return SadeceRakam(event,[',']);">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-xxl-1 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap ">
                                                <div class="form-control-select">
                                                    <select required="" class="form-control select2 form-control-xl" name="sale_money_unit_id" id="sale_money_unit_id">
                                                        <option disabled value="">Lütfen Seçiniz</option>


                                                        <?php
                                                        foreach ($money_unit_items as $money_unit_item) { ?>
                                                            <option value="<?= $money_unit_item['money_unit_id'] ?>" <?= isset($cari_item) ? ($cari_item['money_unit_id'] == $money_unit_item['money_unit_id'] ? 'selected' : '') : '' ?> data_money_icon="<?= $money_unit_item['money_icon'] ?>"  data_money_code="<?= $money_unit_item['money_code'] ?>" data_money_currency="<?= number_format($money_unit_item['money_value'],2,',','.') ?>"><?= $money_unit_item['money_code'] ?> </option>
                                                        <?php }  ?>


                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-xxl-3 col-4 mt-0 mt-md-2 ps-1 d-none" id="txt_doviz_kuru_area">
                                        <div class="input-group">
                                            <input type="text" name="txt_doviz_kuru" id="txt_doviz_kuru" class="form-control form-control-xl text-end calcDvz doviz_degis" placeholder="Döviz kuru giriniz" onkeypress="return SadeceRakam(event,[',']);" value="">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="txt_doviz_kuru">TRY</span>
                                            </div>
                                            <input type="hidden" id="base_money_unit" value="TRY">
                                        </div>
                                    </div>


                                </div>
                                <div class="row g-3 pt-3 align-center">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label" for="sale_order_total_amount">Toplam Fiyat</label><span class="form-note d-none d-md-block">İade yapılan ürünün toplam fiyatı.</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-xxl-2 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="sale_order_total_amount" disabled id="sale_order_total_amount" class="form-control form-control-xl text-right" value="0,00" placeholder="0,00" onkeypress="return SadeceRakam(event,[',']);">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="shipment_order_money_unit"><?= isset($cari_item) ? $cari_item['money_icon'] : '' ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-xxl-2 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <button type="button" id="add_shipment_order_item" class="btn btn-xl btn-primary">Ekle</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="gy-3">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group">
                                            <label class="form-label" for="site-name">İade Yapılacak Ürünler</label><span class="form-note d-none d-md-block">Listedeki
                                                ürünler teslim edilecektir.</span>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-lg-9 col-xxl-9  col-12 pt-4">
                                        <div class="invoice-bills">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="satisYapilacakUrunler">
                                                    <thead>
                                                        <tr>
                                                            <th class="" style="width:80px !important;">Sıra No</th>
                                                            <th>Ürün Adı</th>
                                                            <th class="w-150px text-right" style="padding-right:50px; text-align:right ">Miktar</th>
                                                            <th class="w-100px text-right" style="padding-right:50px; text-align:right ">B.Fiyat</th>
                                                            <th class="w-100px text-right" style="padding-right:50px;">T.Fiyat</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody id="shipment_order_items" class="">

                                                        <tr id="order_item_" class="shipment_order_item d-none">
                                                            <td class="" id="data-sira-no"></td>
                                                            <td class="w-100" id="data-stock-title"></td>
                                                            <td class="w-100" id="data-sale-amount"></td>
                                                            <td class="w-100" id="data-sale-unit-price"></td>
                                                            <td class="w-100" id="data-shipment-order-total-amount"></td>
                                                        </tr>

                                                    </tbody>

                                                    <input id="order_count" type="hidden" value="0">
                                                    <input id="grandTotal" type="hidden" value="0">
                                                    <input id="grandTotal_try" type="hidden" value="0">

                                                    <tfoot>
    <!-- İlk toplam satırı -->
    <tr>
        <td class="text-end" colspan=""></td>
        <td class="text-end" colspan=""></td>
        <td class="text-end" colspan="">
            <input name="toplamSiparisMiktar" id="toplamSiparisMiktar" class="transparent-input form-control para" value="" readonly disabled>
            <span id="toplamSiparisMiktarBirim"></span>
        </td>
        <td class="text-end" colspan="">TOPLAM</td>
        <td class="text-end">
            <b id="total_yazi">0,00</b>
            <b id="total_yazi_para_birimi"><?= isset($cari_item) ? $cari_item['money_icon'] : '' ?></b> <br>
            <span id="total_yazi_try" class="d-none">0,00</span>
            <span id="total_yazi_para_birimi_try" class="d-none"> ₺ </span>
        </td>
    </tr>

</tfoot>
                                                </table>

<hr>
                                                <table style="width:100%" id="">
    <tbody>
    <!-- Döviz kurları satırları -->
    <?php foreach($Kurlar as $kur): ?>
    <tr>

        <td class="text-end" colspan="5" style="float:right" data-moneyID="<?= $kur['money_unit_id']; ?>">
            <div class="input-group " >
                <input type="text" name="kur_fiyat_<?= $kur['money_code']; ?>" id="kur_fiyat_<?= $kur['money_code']; ?>" 
                       class="transparent-input form-control form-control-sm text-end para"
                       value="<?php echo number_format($kur["money_value"], 2, ',', '.'); ?>" 
                       onkeypress="return SadeceRakam(event,[',']);">
                <div class="input-group-append">
                    <span class="input-group-text transparent-input-text text_simge_<?php echo $kur["money_code"]; ?>">TRY</span>
                </div>

                <input type="text" name="kur_toplam_fiyat_<?= $kur['money_code']; ?>" id="kur_toplam_fiyat_<?= $kur['money_code']; ?>" 
                       class="transparent-input form-control form-control-sm text-end para" 
                       placeholder="0,00" 
                       onkeypress="return SadeceRakam(event,[',']);" disabled>
                <div class="input-group-append">
                    <span class="input-group-text transparent-input-text"><?= $kur['money_code']; ?></span>
                </div>
            </div>

           
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>

    </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center pt-5">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label" for="shipment_note">İade Notu</label>
                                            <span class="form-note d-none d-md-block">İade ile ilgili notunuz varsa yazınız.</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-xxl-9 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <textarea class="form-control form-control-xl no-resize" name="shipment_note" id="shipment_note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row g-3 align-center d-none">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label" for="chx_has_collection">Tahsilat Yapıldı mı?</label><span class="form-note d-none d-md-block">Eğer bu satış işleminde tahsilat yapıldı ise işaretleyiniz.</span></div>
                                    </div>
                                    <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                        <ul class="custom-control-group">
                                            <li>
                                                <div class="custom-control custom-checkbox custom-control-pro">
                                                    <input type="checkbox" class="custom-control-input" name="chx_has_collection" id="chx_has_collection">
                                                    <label class="custom-control-label" for="chx_has_collection">
                                                        Evet
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                             

                            </div>
                        </div>
                        <div class="card-inner">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="form-group">
                                        <a href="javascript:history.back()" class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Geri</span></a>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="form-group">
                                        <button id="yeniSevkiyat" class="btn btn-lg btn-primary" type="button">Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                        <input type="hidden" name="cari_id" id="cari_id" value="<?= isset($cari_item) ? $cari_item['cari_id'] : '' ?>">
                </div><!-- .card-inner-group -->
                </form>
            </div><!-- .card -->

        </div><!-- .nk-block -->
    </div>
</div>
</div>

<!-- Modal Delete -->
<div class="modal fade" tabindex="-1" id="confirm_change_warehouse_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent" style="font-size: 70px;"></em>
                    <h4 class="nk-modal-title">Bu Depoyu Değiştirmek İstediğinize<br>Emin misiniz?</h4>
                    <div class="nk-modal-action mb-5">
                        <a href="#" class="btn btn-lg btn-mw btn-light" id="not_confirm_change_warehouse" data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger" id="confirm_change_warehouse" data-bs-dismiss="modal">Evet</a>
                    </div>
                    <div class="nk-modal-text">
                        <p class="lead">Mevcut çıkış deposunu değiştirmek okuttuğunuz barkodların silinmesine yol
                            açacaktır.</p>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>

<!-- Hesaplar Modal -->
<div class="modal fade" id="mdl_hesaplar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">İşlem Hesabı Seçiniz</h5>
                <a href="#" id="btn_hesaplar_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body p-0">
                <table class="datatable-hareketler table">
                    <thead>
                        <tr>
                            <th>Seç</th>
                            <th>Banka</th>
                            <th>Tipi - Döviz</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($financial_account_items)) {
                            foreach ($financial_account_items as $financial_account_item) {

                        ?>
                                <tr>

                                    <td data-order="0">
                                        <div class="custom-control custom-radio no-control">
                                            <input type="radio" class="custom-control-input rd_account " name="radioSizeAccount" accName="<?= $financial_account_item['account_title']; ?>" accMoneyUnitId="<?= $financial_account_item['money_unit_id']; ?>" accMoneyUnitName="<?= $financial_account_item['money_code']; ?>" id="<?= $financial_account_item['financial_account_id'] ?>" />
                                            <label class="custom-control-label text-primary" for="<?= $financial_account_item['financial_account_id'] ?>"><?= $financial_account_item['account_title']; ?></label>
                                        </div>
                                    </td>
                                    <td><?php if (isset($bank_items) && $financial_account_item['bank_id'] != null) {
                                            echo $bank_items[array_search($financial_account_item['bank_id'], array_column($bank_items, 'bank_id'))]['bank_title'];
                                        } else {
                                            echo " - ";
                                        }  ?></td>
                                    <td><?php switch ($financial_account_item['account_type']) {
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
                                        } ?> - <?= $financial_account_item['money_code'] ?></td>

                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" class="btn btn-lg btn-dim btn-outline-light d-none" data-bs-dismiss="modal" aria-label="Close">KAPAT</button>

                    </div>
                    <div class="col-md-8 text-end p-0">

                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2" disabled>YENİ HESAP</button>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-lg btn-primary ">KAPAT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Para Birimi Modal -->
<!-- <div class="modal fade" tabindex="-1" id="mdl_parabirimi">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Para Birimi Seçiniz</h5>
                <a href="#" id="btn_mdl_parabirimi_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <table class="datatable-parabirimi table">
                    <thead>
                        <tr>
                            <th data-orderable="false">Birim Adı</th>
                            <th data-orderable="false">Kodu</th>
                            <th data-orderable="false">Simgesi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (isset($money_unit_items)) {
                            foreach ($money_unit_items as $money_unit) { ?>
                                <tr>
                                    <td data-order="0">
                                        <div class="custom-control custom-radio no-control">
                                            <input type="radio" class="custom-control-input rd_money" name="radioSize" id="customRadio<?= $money_unit['money_unit_id'] ?>" value="<?= $money_unit['money_unit_id'] ?>" money_code="<?= $money_unit['money_code'] ?>">
                                            <label class="custom-control-label text-primary" for="customRadio<?= $money_unit['money_unit_id'] ?>"><?= $money_unit['money_title'] ?></label>
                                        </div>
                                    </td>
                                    <td><?= $money_unit['money_code'] ?></td>
                                    <td><?= $money_unit['money_icon'] ?></td>
                                </tr>
                        <?php }
                        } ?>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-lg btn-primary">KAPAT</button>
            </div>
        </div>
    </div>
</div> -->


<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'sale_order',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="#" onclick="location.reload()" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Satış Oluştur</a>
                                    <a href="" id="printQuickSale" target="_blank" class="btn btn-l btn-dim btn-outline-dark btn-block mb-2">Satış Fişini Yazdır</a>
                                    <a href="' . route_to('tportal.faturalar.list', 'all') . '" class="btn btn-l btn-dim btn-outline-dark btn-block mb-2">Satış Listesini Gör</a>
                                    <a href="" id="seeCari" class="btn btn-l btn-dim btn-outline-dark btn-block mb-2">Cari Detayını Gör</a>'
            ],
        ],
    ]
); ?>


<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= view_cell(
    'App\Libraries\ViewComponents::getSearchSupplierModal',
    [
        'fromWhere' => 'onlyCustomers'
    ]
); ?>
<script>
// Seçili para birimini alıyoruz

var exchange_rates = {
        'USD': 1.0,    // USD sabit referans, yani 1 USD = 1 USD
        'EUR': 1.1,    // 1 EUR = 1.1 USD (örnek)
        'TRY': 0.05    // 1 TRY = 0.05 USD (örnek)
    };

    $("#add_shipment_order_item").attr("disabled", true);

var anlikBirim = $("#sale_money_unit_id").val();

$("td[data-moneyID]").each(function() {
            var moneyID = $(this).data('moneyid');  // data-moneyID değerini alıyoruz
            
            if (moneyID == anlikBirim) {
        $(this).hide();  // Eğer money_unit_id eşleşiyorsa <td> elementini kaldırıyoruz
    }else{   
         $(this).show(); 
         }
        });
function formatTurkishNumber(number) {
        // Sayıyı iki ondalık basamaklı hale getirir
        let parts = parseFloat(number).toFixed(2).split("."); // Virgülden önce ve sonrası
        // Binlik ayraçları ekler
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        // Ondalık ayırıcı olarak virgül kullanır
        return parts.join(",");
    }
    
var kurlar = [];

    <?php foreach($Kurlar as $kur): ?>
        kurlar.push({
            money_unit_id: <?php echo $kur["money_unit_id"]; ?>,
            money_code: '<?php echo $kur["money_code"]; ?>',
            money_value: '<?php echo $kur["money_value"]; ?>',
            kur_fiyat_<?php echo $kur["money_code"]; ?>:'<?php echo $kur["money_value"]; ?>',
            kur_toplam_fiyat_<?php echo $kur["money_code"]; ?>: '0,00'
        });
    <?php endforeach; ?>


    var anlikBirim =  $("#sale_money_unit_id").val();




    $(document).ready(function() {
        selectedMoneyCurrency1 = $("#sale_money_unit_id option:selected").attr('data_money_currency');



        $('#txt_doviz_kuru').val(parseFloat(selectedMoneyCurrency1).toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        
        $("#shipment_order_money_unit").empty().text(" " + $("#sale_money_unit_id option:selected").attr('data_money_icon'));
        $("#total_yazi_para_birimi").empty().text(" " + $("#sale_money_unit_id option:selected").attr('data_money_icon'));

        if ($("#sale_money_unit_id").val() == '3') {
            $("#txt_doviz_kuru_area").addClass("d-none");
            $("#total_yazi_try").addClass("d-none");
            $("#total_yazi_para_birimi_try").addClass("d-none");
            $(".dvz_str").hide();
        } else {
            $("#txt_doviz_kuru_area").removeClass("d-none");
            $("#total_yazi_try").removeClass("d-none");
            $("#total_yazi_para_birimi_try").removeClass("d-none");

            $(".dvz_str").show();
        }

        number_format = function(number, decimals, dec_point, thousands_sep) {
            number = parseFloat(number);
            number = number.toFixed(decimals);


            var nstr = number.toString();
            nstr += '';
            x = nstr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? dec_point + x[1] : '';
            var rgx = /(\d+)(\d{3})/;

            while (rgx.test(x1))
                x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

            return x1 + x2;
        }


        $(document).on("keyup", "#txt_doviz_kuru", function () {
        // console.log("kur deÄŸiÅŸtiiii.. fatura_genel_toplam gidilmek Ã¼zere");


        var grandTotal = $('#grandTotal').val();




 // Genel toplam ve diğer değerler
 var GenelToplamFull = (grandTotal); // İlk genel toplam hesaplaması
        
        // Seçilen para birimi
        var anlikParaBirimi = $("#sale_money_unit_id option:selected").attr('data_money_code'); // Örneğin USD, EUR
    
        // Kurlar üzerinde döngü yaparak hesaplama
        kurlar.forEach(function(kur) {
            // Kur fiyatı anahtarını oluştur
            var kurFiyatKey = 'kur_fiyat_' + kur.money_code; // Örnek: 'kur_fiyat_USD'
            var kurFiyat = 0; // Virgülü noktaya çevirip float yapıyoruz
    
            // Eğer seçilen para birimi farklıysa hesaplamayı yap
            var toplamFiyat;
            if (anlikParaBirimi === kur.money_code) {
                // Eğer seçilen para birimi aynıysa (örn. USD), genel toplamı direkt alırız
                toplamFiyat = GenelToplamFull;
            } else {
                // Bu kısımda TRY veya diğer kurlar için input değerini alıyoruz
                var kurInputValue = 0;
    
                if(kur.money_code == "TRY") {
                    kurInputValue = $(".doviz_degis").val(); // TRY için 'doviz_degis' sınıfından değer alıyoruz
                    if (!kurInputValue) {
                        console.log("TRY için input değeri bulunamadı.");
                    }
                } else {
                    kurInputValue = $("#kur_fiyat_" + kur.money_code).val(); // Diğer kurlar için ID'den alıyoruz
                    if (!kurInputValue) {
                        console.log(kur.money_code + " için input değeri bulunamadı.");
                    }
                }
    
                if (kurInputValue) {
                    kurFiyat = parseFloat(kurInputValue.replace(",", ".")); // Input değerini sayıya çeviriyoruz
                }
    
                // Seçilen para birimi farklıysa dönüşüm işlemi yap
                if(anlikParaBirimi == "TRY"){
                    toplamFiyat = GenelToplamFull / kurFiyat; // Genel toplamı kur fiyatına böleriz

                }else{
                    toplamFiyat = GenelToplamFull * kurFiyat; // Genel toplamı kur fiyatına böleriz

                }
    
                console.log("anlikParaBirimi: " + kur.money_code);
                console.log("kurFiyat: " + kurInputValue);
                console.log("GenelToplamFull: " + GenelToplamFull);
            }
    
            // Kur toplam fiyatını string hale getirip güncelle
            var kurToplamFiyatKey = 'kur_toplam_fiyat_' + kur.money_code; // Örnek: 'kur_toplam_fiyat_USD'

            toplamFiyat = toplamFiyat.toString().replace(",", ".");



            kur[kurToplamFiyatKey] = parseFloat(toplamFiyat).toFixed(2); // Sonucu iki ondalıklı hale getirir
    
            // Hesaplanan toplam fiyatı ilgili input alanına yaz
            var toplamFiyatInput = document.querySelector('input[name="' + kurToplamFiyatKey + '"]');
            if (toplamFiyatInput) {
                toplamFiyatInput.value = formatTurkishNumber(toplamFiyat); // Input alanına değeri yaz
            }
    
            // Aynı şekilde kur fiyatını da ilgili input alanına yaz
            var kurFiyatInput = document.querySelector('input[name="' + kurFiyatKey + '"]');
            if (kurFiyatInput) {
                kurFiyatInput.value = formatTurkishNumber(kurFiyat); // Kur fiyatı input alanına değeri yaz
            }
    
            // Input alanı dinleyicisi ekleyelim ki kur fiyatı değişirse hesaplamayı güncelle
            if (kurFiyatInput) {
                kurFiyatInput.addEventListener('keyup', function () {
                    // Input alanındaki yeni değeri al ve sayıya dönüştür
                    var newKurFiyat = parseFloat(kurFiyatInput.value.replace(",", "."));
            
                    // Eğer sayı geçerli değilse işlemi durdur
                    if (isNaN(newKurFiyat)) {
                        return;
                    }
            
                    // Yeni kur fiyatı ile GenelToplamFull'ü yeniden çarp/böl
                    var newToplamFiyat;
                    if (anlikParaBirimi === kur.money_code) {
                        newToplamFiyat = GenelToplamFull; // Eğer aynı para birimi ise, genel toplam direkt alınır
                    } else {
                        // TRY ise bölme, diğer para birimleri için çarpma işlemi yapılır
                        if (anlikParaBirimi == "TRY") {
                            newToplamFiyat = GenelToplamFull / newKurFiyat; // TRY için genel toplamı kur fiyatına böleriz
                        } else {
                            newToplamFiyat = GenelToplamFull * newKurFiyat; // Diğer para birimleri için çarparız
                        }
                    }
            
                    // Sonucu ilgili 'kur_toplam_fiyat_' inputuna yaz
                    if (toplamFiyatInput) {
                        toplamFiyatInput.value = formatTurkishNumber(newToplamFiyat);
                    }
            
                    // Kurlar dizisindeki ilgili objeyi güncelleparseFloat(toplamFiyat.replace(",", "."))
                    kur['kur_fiyat_' + kur.money_code] = newKurFiyat; // Kur fiyatını güncelle

                    newToplamFiyat = newToplamFiyat.toString().replace(",", ".");

                    kur['kur_toplam_fiyat_' + kur.money_code] = parseFloat(newToplamFiyat).toFixed(2); // Toplam fiyatı güncelle
            
                    console.log('Güncellenmiş kurlar:', kurlar); // Güncellenmiş kurlar dizisini kontrol et
                });
            }
        });


        var roundedValue = parseFloat($(this).val()).toFixed(2);
            var formattedValue = roundedValue.replace('.', ',');

               

            // Set the input value
            $("#kur_fiyat_TRY").val(formattedValue);
    


    });

        //Para Birimi Değiştiğinde
        $(document).on("change", "#sale_money_unit_id", function() {

            $("#base_money_unit").val($("#sale_money_unit_id option:selected").attr('data_money_code'));







       
        var anlikParaBirimi = $("#sale_money_unit_id option:selected").attr('data_money_code'),
            anlikParaBirimiID = $(this).val();
    
        console.log("Selected currency:", anlikParaBirimi);
        console.log("Selected currency ID:", anlikParaBirimiID);
    
        // Fetch the correct currency rate
        var selectedRate = kurlar.find(function(kur) {
            return kur.money_unit_id == anlikParaBirimiID;
        });




        if (anlikParaBirimi == "TRY") {

            // USD ve EUR kurlarını array'den bulup TRY karşılıklarını yazdır
            var usdKur = kurlar.find(kur => kur.money_code === 'USD'); // USD kurunu bul
            var eurKur = kurlar.find(kur => kur.money_code === 'EUR'); // EUR kurunu bul
        
            // USD ve EUR için kur değerleri varsa işlemleri yap
            if (usdKur && eurKur) {
                // USD'nin TRY karşılığı
                var usdToTry = typeof usdKur['kur_fiyat_USD'] === 'string' 
                    ? parseFloat(usdKur['kur_fiyat_USD'].replace(",", ".")) // Eğer string ise replace ile düzenle
                    : usdKur['kur_fiyat_USD']; // Zaten sayıysa olduğu gibi al
        
                var usdFormatted = usdToTry.toFixed(2); // TRY'ye çevrilen USD'yi formatla
                $("#kur_fiyat_USD").val(usdFormatted);  // USD'nin TRY karşılığını inputa yaz
        
                // EUR'nin TRY karşılığı
                var eurToTry = typeof eurKur['kur_fiyat_EUR'] === 'string' 
                    ? parseFloat(eurKur['kur_fiyat_EUR'].replace(",", ".")) // Eğer string ise replace ile düzenle
                    : eurKur['kur_fiyat_EUR']; // Zaten sayıysa olduğu gibi al
        
                var eurFormatted = eurToTry.toFixed(2); // TRY'ye çevrilen EUR'yu formatla
                $("#kur_fiyat_EUR").val(eurFormatted);  // EUR'nin TRY karşılığını inputa yaz
        
                // Simgeleri "TRY" olarak güncelle
                $(".text_simge_EUR").html("TRY");  // EUR simgesi TRY olacak
                $(".text_simge_USD").html("TRY");  // USD simgesi TRY olacak
            } else {
                console.log("USD veya EUR için kur bulunamadı.");
            }
        }
        
       
    
  
        if (selectedRate) {
            // Kur değerini formatla
            var roundedValue = parseFloat(selectedRate.money_value).toFixed(2);
            var formattedValue = roundedValue.replace('.', ',');

               
            // Remove any readonly or disabled attributes, if they exist
            $(".doviz_degis").removeAttr('readonly').removeAttr('disabled');
            
            // Set the input value
            $(".doviz_degis").val(formattedValue);
    
            // Seçilen para birimi USD ise
            if (anlikParaBirimi == "USD") {
                // USD to TRY
     
                // USD to EUR: 1 USD = 1 / EUR kuru
                var usdToEur = (1 / exchange_rates['EUR']).toFixed(2);
                $("#kur_fiyat_EUR").val(usdToEur.replace('.', ','));
                    $(".text_simge_EUR").html("EUR");
    
            } else if (anlikParaBirimi == "EUR") {
                // EUR to TRY
               

                // EUR to USD: EUR'dan USD'ye dönüşüm (doğrudan kullan)
                var eurToUsd = (exchange_rates['EUR']).toFixed(2);
                $("#kur_fiyat_USD").val(eurToUsd.replace('.', ','));
                $(".text_simge_USD").html("USD");
    
            } else if (anlikParaBirimi != "TRY") {
                // TRY dışındaki diğer para birimlerinde yine TL'ye çevir
                
                
            }


    
            console.log("Updated input with value:", formattedValue);
        } else {
            console.log("No rate found for this currency");
        }


         


        var grandTotal = $('#grandTotal').val();




// Genel toplam ve diğer değerler
var GenelToplamFull = (grandTotal); // İlk genel toplam hesaplaması
       
       // Seçilen para birimi
       var anlikParaBirimi = $("#sale_money_unit_id option:selected").attr('data_money_code'); // Örneğin USD, EUR
   
       // Kurlar üzerinde döngü yaparak hesaplama
       kurlar.forEach(function(kur) {
           // Kur fiyatı anahtarını oluştur
           var kurFiyatKey = 'kur_fiyat_' + kur.money_code; // Örnek: 'kur_fiyat_USD'
           var kurFiyat = 0; // Virgülü noktaya çevirip float yapıyoruz
   
           // Eğer seçilen para birimi farklıysa hesaplamayı yap
           var toplamFiyat;
           if (anlikParaBirimi === kur.money_code) {
               // Eğer seçilen para birimi aynıysa (örn. USD), genel toplamı direkt alırız
               toplamFiyat = GenelToplamFull;
           } else {
               // Bu kısımda TRY veya diğer kurlar için input değerini alıyoruz
               var kurInputValue = 0;
   
               if(kur.money_code == "TRY") {
                   kurInputValue = $(".doviz_degis").val(); // TRY için 'doviz_degis' sınıfından değer alıyoruz
                   if (!kurInputValue) {
                       console.log("TRY için input değeri bulunamadı.");
                   }
               } else {
                   kurInputValue = $("#kur_fiyat_" + kur.money_code).val(); // Diğer kurlar için ID'den alıyoruz
                   if (!kurInputValue) {
                       console.log(kur.money_code + " için input değeri bulunamadı.");
                   }
               }
   
               if (kurInputValue) {
                   kurFiyat = parseFloat(kurInputValue.replace(",", ".")); // Input değerini sayıya çeviriyoruz
               }
   
               // Seçilen para birimi farklıysa dönüşüm işlemi yap
               if(anlikParaBirimi == "TRY"){
                   toplamFiyat = GenelToplamFull / kurFiyat; // Genel toplamı kur fiyatına böleriz

               }else{
                   toplamFiyat = GenelToplamFull * kurFiyat; // Genel toplamı kur fiyatına böleriz

               }
   
               console.log("anlikParaBirimi: " + kur.money_code);
               console.log("kurFiyat: " + kurInputValue);
               console.log("GenelToplamFull: " + GenelToplamFull);
           }
   
           // Kur toplam fiyatını string hale getirip güncelle
           var kurToplamFiyatKey = 'kur_toplam_fiyat_' + kur.money_code; // Örnek: 'kur_toplam_fiyat_USD'
           toplamFiyat = toplamFiyat.toString().replace(",", ".");

           kur[kurToplamFiyatKey] = parseFloat(toplamFiyat).toFixed(2); // Sonucu iki ondalıklı hale getirir
   
           // Hesaplanan toplam fiyatı ilgili input alanına yaz
           var toplamFiyatInput = document.querySelector('input[name="' + kurToplamFiyatKey + '"]');
           if (toplamFiyatInput) {
               toplamFiyatInput.value = formatTurkishNumber(toplamFiyat); // Input alanına değeri yaz
           }
   
           // Aynı şekilde kur fiyatını da ilgili input alanına yaz
           var kurFiyatInput = document.querySelector('input[name="' + kurFiyatKey + '"]');
           if (kurFiyatInput) {
               kurFiyatInput.value = formatTurkishNumber(kurFiyat); // Kur fiyatı input alanına değeri yaz
           }
   
           // Input alanı dinleyicisi ekleyelim ki kur fiyatı değişirse hesaplamayı güncelle
           if (kurFiyatInput) {
               kurFiyatInput.addEventListener('keyup', function () {
                   // Input alanındaki yeni değeri al ve sayıya dönüştür
                   var newKurFiyat = parseFloat(kurFiyatInput.value.replace(",", "."));
           
                   // Eğer sayı geçerli değilse işlemi durdur
                   if (isNaN(newKurFiyat)) {
                       return;
                   }
           
                   // Yeni kur fiyatı ile GenelToplamFull'ü yeniden çarp/böl
                   var newToplamFiyat;
                   if (anlikParaBirimi === kur.money_code) {
                       newToplamFiyat = GenelToplamFull; // Eğer aynı para birimi ise, genel toplam direkt alınır
                   } else {
                       // TRY ise bölme, diğer para birimleri için çarpma işlemi yapılır
                       if (anlikParaBirimi == "TRY") {
                           newToplamFiyat = GenelToplamFull / newKurFiyat; // TRY için genel toplamı kur fiyatına böleriz
                       } else {
                           newToplamFiyat = GenelToplamFull * newKurFiyat; // Diğer para birimleri için çarparız
                       }
                   }
           
                   // Sonucu ilgili 'kur_toplam_fiyat_' inputuna yaz
                   if (toplamFiyatInput) {
                       toplamFiyatInput.value = formatTurkishNumber(newToplamFiyat);
                   }
           
                   // Kurlar dizisindeki ilgili objeyi güncelle
                   kur['kur_fiyat_' + kur.money_code] = newKurFiyat; // Kur fiyatını güncelle
                   newToplamFiyat = newToplamFiyat.toString().replace(",", ".");

                   kur['kur_toplam_fiyat_' + kur.money_code] = parseFloat(newToplamFiyat).toFixed(2); // Toplam fiyatı güncelle
           
                   console.log('Güncellenmiş kurlar:', kurlar); // Güncellenmiş kurlar dizisini kontrol et
               });
           }
       });


       var roundedValue = parseFloat($(this).val()).toFixed(2);
           var formattedValue = roundedValue.replace('.', ',');

              

   

            
    
            


            if ($("#sale_money_unit_id").val() == '3') {
                $("#txt_doviz_kuru_area").addClass("d-none");
                $("#total_yazi_try").addClass("d-none");
                $("#total_yazi_para_birimi_try").addClass("d-none");
                $(".dvz_str").hide();
            } else {
                $("#txt_doviz_kuru_area").removeClass("d-none");
                $("#total_yazi_try").removeClass("d-none");
                $("#total_yazi_para_birimi_try").removeClass("d-none");

                $(".dvz_str").show();
            }

            var invoiceNotesCode = $("#sale_money_unit_id option:selected").attr('data_money_code');

            $(".dvz").html(invoiceNotesCode);
            var anlikBirim = $("#sale_money_unit_id").val();

            $("td[data-moneyID]").each(function() {
            var moneyID = $(this).data('moneyid');  // data-moneyID değerini alıyoruz
            
            if (moneyID == anlikBirim) {
        $(this).hide();  // Eğer money_unit_id eşleşiyorsa <td> elementini kaldırıyoruz
    }else{   
         $(this).show(); 
         }
        });

        });

        $("#chx_has_collection").change(function() {
            if (this.checked) {
                $('#area_has_collection').removeClass('d-none');

                $('#transaction_amount').val($('#grandTotal').val());
                has_collection = 1;
            } else {
                $('#area_has_collection').addClass('d-none');
                $('#transaction_amount').val(0);
                has_collection = 0;
            }
        });

    })



    $('.urun_cikart').hide();
    $('#btn_cikart_aktif').click(function(e) {
        e.preventDefault();
        $('.urun_cikart').show();
    });
    $('#btn_cikart_pasif').click(function(e) {
        e.preventDefault();
        $('.urun_cikart').hide();
    });

    $(document).on("click", ".rd_cari", function() {
        $("#add_shipment_order_item").attr("disabled", false);

        $('#mdl_tedarikciSecs').modal('hide');
        selectedCariId = $('.rd_cari:checked').val();
        // console.log(selectedCariId);

        selectedCariInvoiceTitle = $('.rd_cari:checked').attr('invoice_title');
        selectedCariInvoiceName = $('.rd_cari:checked').attr('invoice_name');
        selectedCariInvoiceSurname = $('.rd_cari:checked').attr('invoice_surname');
        selectedMoney = $('.rd_cari:checked').attr('money_tipi_id');
        money_tipi_icon = $('.rd_cari:checked').attr('money_tipi_icon');
        money_tipi_kur = $('.rd_cari:checked').attr('money_tipi_kur');
        $('#cari_id').val($('.rd_cari:checked').val());

        console.log(selectedCariInvoiceTitle, selectedCariInvoiceName, selectedCariInvoiceSurname);

        lastTitle = selectedCariInvoiceTitle == '' ? selectedCariInvoiceName + " " + selectedCariInvoiceSurname : selectedCariInvoiceTitle;
        $('#account').val(lastTitle);
        var anlikBirim = selectedMoney;



        $('#sale_money_unit_id').val(selectedMoney);
        $('#sale_money_unit_id').trigger('change');


        
        if (selectedMoney == '3') {
            $("#txt_doviz_kuru_area").addClass("d-none");
            $("#total_yazi_try").addClass("d-none");
            $("#total_yazi_para_birimi_try").addClass("d-none");
            $(".dvz_str").hide();
        } else {
            $("#txt_doviz_kuru_area").removeClass("d-none");
            $("#total_yazi_try").removeClass("d-none");
            $("#total_yazi_para_birimi_try").removeClass("d-none");

            $(".dvz_str").show();
        }

        $('#txt_doviz_kuru').val(parseFloat(money_tipi_kur).toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));



        $("#shipment_order_money_unit").empty().text(" " + money_tipi_icon);
        $("#total_yazi_para_birimi").empty().text(" " + money_tipi_icon);

        $("#sale_money_unit_id").attr("disabled",true);



        var grandTotal = $('#grandTotal').val();




// Genel toplam ve diğer değerler
var GenelToplamFull = (grandTotal); // İlk genel toplam hesaplaması
       
       // Seçilen para birimi
       var anlikParaBirimi = $("#sale_money_unit_id option:selected").attr('data_money_code'); // Örneğin USD, EUR
   
       // Kurlar üzerinde döngü yaparak hesaplama
       kurlar.forEach(function(kur) {
           // Kur fiyatı anahtarını oluştur
           var kurFiyatKey = 'kur_fiyat_' + kur.money_code; // Örnek: 'kur_fiyat_USD'
           var kurFiyat = 0; // Virgülü noktaya çevirip float yapıyoruz
   
           // Eğer seçilen para birimi farklıysa hesaplamayı yap
           var toplamFiyat;
           if (anlikParaBirimi === kur.money_code) {
               // Eğer seçilen para birimi aynıysa (örn. USD), genel toplamı direkt alırız
               toplamFiyat = GenelToplamFull;
           } else {
               // Bu kısımda TRY veya diğer kurlar için input değerini alıyoruz
               var kurInputValue = 0;
   
               if(kur.money_code == "TRY") {
                   kurInputValue = $(".doviz_degis").val(); // TRY için 'doviz_degis' sınıfından değer alıyoruz
                   if (!kurInputValue) {
                       console.log("TRY için input değeri bulunamadı.");
                   }
               } else {
                   kurInputValue = $("#kur_fiyat_" + kur.money_code).val(); // Diğer kurlar için ID'den alıyoruz
                   if (!kurInputValue) {
                       console.log(kur.money_code + " için input değeri bulunamadı.");
                   }
               }
   
               if (kurInputValue) {
                   kurFiyat = parseFloat(kurInputValue.replace(",", ".")); // Input değerini sayıya çeviriyoruz
               }
   
               // Seçilen para birimi farklıysa dönüşüm işlemi yap
               if(anlikParaBirimi == "TRY"){
                   toplamFiyat = GenelToplamFull / kurFiyat; // Genel toplamı kur fiyatına böleriz

               }else{
                   toplamFiyat = GenelToplamFull * kurFiyat; // Genel toplamı kur fiyatına böleriz

               }
   
               console.log("anlikParaBirimi: " + kur.money_code);
               console.log("kurFiyat: " + kurInputValue);
               console.log("GenelToplamFull: " + GenelToplamFull);
           }
   
           // Kur toplam fiyatını string hale getirip güncelle
           var kurToplamFiyatKey = 'kur_toplam_fiyat_' + kur.money_code; // Örnek: 'kur_toplam_fiyat_USD'
           toplamFiyat = toplamFiyat.toString().replace(",", ".");

           kur[kurToplamFiyatKey] = parseFloat(toplamFiyat).toFixed(2); // Sonucu iki ondalıklı hale getirir
   
           // Hesaplanan toplam fiyatı ilgili input alanına yaz
           var toplamFiyatInput = document.querySelector('input[name="' + kurToplamFiyatKey + '"]');
           if (toplamFiyatInput) {
               toplamFiyatInput.value = formatTurkishNumber(toplamFiyat); // Input alanına değeri yaz
           }
   
           // Aynı şekilde kur fiyatını da ilgili input alanına yaz
           var kurFiyatInput = document.querySelector('input[name="' + kurFiyatKey + '"]');
           if (kurFiyatInput) {
               kurFiyatInput.value = formatTurkishNumber(kurFiyat); // Kur fiyatı input alanına değeri yaz
           }
   
           // Input alanı dinleyicisi ekleyelim ki kur fiyatı değişirse hesaplamayı güncelle
           if (kurFiyatInput) {
               kurFiyatInput.addEventListener('keyup', function () {
                   // Input alanındaki yeni değeri al ve sayıya dönüştür
                   var newKurFiyat = parseFloat(kurFiyatInput.value.replace(",", "."));
           
                   // Eğer sayı geçerli değilse işlemi durdur
                   if (isNaN(newKurFiyat)) {
                       return;
                   }
           
                   // Yeni kur fiyatı ile GenelToplamFull'ü yeniden çarp/böl
                   var newToplamFiyat;
                   if (anlikParaBirimi === kur.money_code) {
                       newToplamFiyat = GenelToplamFull; // Eğer aynı para birimi ise, genel toplam direkt alınır
                   } else {
                       // TRY ise bölme, diğer para birimleri için çarpma işlemi yapılır
                       if (anlikParaBirimi == "TRY") {
                           newToplamFiyat = GenelToplamFull / newKurFiyat; // TRY için genel toplamı kur fiyatına böleriz
                       } else {
                           newToplamFiyat = GenelToplamFull * newKurFiyat; // Diğer para birimleri için çarparız
                       }
                   }
           
                   // Sonucu ilgili 'kur_toplam_fiyat_' inputuna yaz
                   if (toplamFiyatInput) {
                       toplamFiyatInput.value = formatTurkishNumber(newToplamFiyat);
                   }
           
                   // Kurlar dizisindeki ilgili objeyi güncelle
                   kur['kur_fiyat_' + kur.money_code] = newKurFiyat; // Kur fiyatını güncelle
                   newToplamFiyat = newToplamFiyat.toString().replace(",", ".");

                   kur['kur_toplam_fiyat_' + kur.money_code] = parseFloat(newToplamFiyat).toFixed(2); // Toplam fiyatı güncelle
           
                   console.log('Güncellenmiş kurlar:', kurlar); // Güncellenmiş kurlar dizisini kontrol et
               });
           }
       });


       var roundedValue = parseFloat($(this).val()).toFixed(2);
           var formattedValue = roundedValue.replace('.', ',');

              

           // Set the input value
           $("#kur_fiyat_TRY").val(formattedValue);
   

        

        // Eşleşen <td> elementlerini buluyoruz ve kaldırıyoruz
        $("td[data-moneyID]").each(function() {
            var moneyID = $(this).data('moneyid');  // data-moneyID değerini alıyoruz
            
            if (moneyID == anlikBirim) {
        $(this).hide();  // Eğer money_unit_id eşleşiyorsa <td> elementini kaldırıyoruz
    }else{   
         $(this).show(); 
         }
        });

    });

    var fullData = []; //okutulan barkod bilgileri
    let kalanMiktar = 0;
    let toplamSiparisMiktar = 0;
    let has_collection = 0;
    var table = $('#satisYapilacakUrunler tbody');

    $('#add_barcode_number').keypress(function(event) {
        // 13 'ENTER' tuşunun değeridir
        if (event.which === 13) {
            warehouse_id = $('#from_warehouse').find(":selected").val()
            barcode_number = $('#add_barcode_number').val()
            cari_id = $('#cari_id').val()


            var elementWithBarcode = $('[data-barcode-number="' + barcode_number + '"]')


            if (elementWithBarcode.length > 0) {
                swetAlert("Hatalı İşlem", "Bu ürün daha önce bu siparişe eklenmiştir. İşlem yapmak için önce bu ürünü çıkartınız.", "err");
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= route_to('tportal.cari.sale_order.check_barcode_iade') ?>',
                    dataType: 'json',
                    data: {
                        warehouse_id: warehouse_id,
                        barcode_number: barcode_number,
                        cari_id: cari_id
                    },
                    async: true,
                    success: function(response) {
                        if (response['icon'] == 'success') {
                            // console.log(response.data);

                            toplamMiktar = response.data.total_amount;
                            kullanilanMiktar = response.data.used_amount;
                            kalanMiktar = toplamMiktar - kullanilanMiktar;

                            // console.log("kalanMiktar", kalanMiktar);

                            fullData = response.data;
                            $('#stock_code').val(response.data.stock_code);
                            $('#stock_title').val(response.data.stock_title);
                            $('#remaining_quantity').val(base_money_format(kalanMiktar));
                            $('#sale_order_quantity').val(base_money_format(kalanMiktar));
                            $('#sale_unit_price').val(base_money_format(response.data.sale_unit_price));
                            $('#sale_order_unit').text(response.data.unit_title);
                            $('#sale_order_unit2').text(response.data.unit_title);
                            $('#stock_id').val(response.data.stock_barcode_id);

                            if(response.data.sale_unit_price){
                                kur = $("#txt_doviz_kuru").val().replace(".", "").replace(",", ".");

                                if ($("#sale_unit_price").val() == "")
                                    var sale_unit_price = 0;
                                else
                                    var sale_unit_price = $("#sale_unit_price").val().replace(".", "").replace(",", ".");

                                if ($("#sale_order_quantity").val() == "")
                                    var sale_order_quantity = 0;
                                else
                                    var sale_order_quantity = $("#sale_order_quantity").val().replace(".", "").replace(",", ".");

                                total = (parseFloat(sale_unit_price) * parseFloat(sale_order_quantity)).toFixed(2);

                                $("#sale_order_total_amount").val(total);
                                $("#sale_order_total_amount_try").val(total * kur);

                            }

                        } else {
                            swetAlert("Hatalı İşlem", response['message'], "err");
                        }
                    }
                })
            }
        }
    })

    $('#remove_barcode_number').keypress(function(event) {
        // 13 'ENTER' tuşunun değeridir
        if (event.which === 13) {
            warehouse_id = $('#from_warehouse').find(":selected").val()

            if ($('#from_warehouse').find(":selected").val() == 0) {
                swetAlert("Eksik Bir Şeyler Var", "Lütfen Giriş ve Çıkış Depolarını Seçiniz ", "err");
            } else {

                barcode_number = $('#remove_barcode_number').val()
                txt_doviz_kuru = $("#txt_doviz_kuru").val() == 0 ? 0 : $("#txt_doviz_kuru").val().replace(".", "").replace(",", ".");

                var elementWithBarcode = $('[data-barcode-number="' + barcode_number + '"]')

                if (elementWithBarcode.length > 0) {

                    elementWithBarcode.remove();
                    console.log("Element silindi.");

                    table.find('tr').each(function(index) {
                        $(this).find('td:first').text(index);
                    });

                    var order_count = parseInt($("#order_count").val());
                    order_count = order_count - 1;
                    $("#order_count").val(order_count);

                    satirTutar = elementWithBarcode.attr('data-sale-total-price');
                    satirMiktar = elementWithBarcode.attr('data-sale-amount');

                    lastGrandTotal = $("#grandTotal").val();
                    lastGrandTotal_try = $("#grandTotal_try").val();

                    lastGrandTotal = (parseFloat(lastGrandTotal) - parseFloat(satirTutar)).toFixed(2);
                    lastGrandTotal_try = (parseFloat(lastGrandTotal) * parseFloat(txt_doviz_kuru)).toFixed(2);


                    var lasttoplamSatis = (parseFloat(toplamSiparisMiktar) - satirMiktar.replace(".", "").replace(",", "."));

                    $("#grandTotal").val(lastGrandTotal);
                    $("#grandTotal_try").val(lastGrandTotal_try);


                    $('#total_yazi').empty().html(parseFloat(lastGrandTotal).toFixed(2));
                    $('#total_yazi_try').empty().html(parseFloat(lastGrandTotal_try).toFixed(2));

                    $('#toplamSiparisMiktar').val(parseFloat(lasttoplamSatis));

                    $('#remove_barcode_number').val('');
                    swetAlert("Başarılı İşlem", "Bu ürün satış yapılacak ürünler listesinden çıkartılmıştır.", "ok");

                    toplamSiparisMiktar = lasttoplamSatis;

                } else {
                    console.log("Element bulunamadı.");
                    swetAlert("Uyarı", "Satış yapılacak ürünler listesinde böyle bir ürün bulunamadı.", "err");

                }

                if (order_count == 0) {
                    $('#sale_money_unit_id').removeAttr('disabled');
                }
            }
        }
    });


    $('.calc').on('keyup', function() {

        kur = $("#txt_doviz_kuru").val().replace(".", "").replace(",", ".");

        if ($("#sale_unit_price").val() == "")
            var sale_unit_price = 0;
        else
            var sale_unit_price = $("#sale_unit_price").val().replace(".", "").replace(",", ".");

        if ($("#sale_order_quantity").val() == "")
            var sale_order_quantity = 0;
        else
            var sale_order_quantity = $("#sale_order_quantity").val().replace(".", "").replace(",", ".");

        total = (parseFloat(sale_unit_price) * parseFloat(sale_order_quantity)).toFixed(2);

        $("#sale_order_total_amount").val(total);
        $("#sale_order_total_amount_try").val(total * kur);

        // $('#sale_order_total_amount').val(total);
    });


    $('.calcDvz').on('keyup', function() {
        var grandTotal = $('#grandTotal').val();
        var grandTotal_try = $('#grandTotal_try').val();

        if ($("#txt_doviz_kuru").val() == "")
            var txt_doviz_kuru = 0;
        else
            var txt_doviz_kuru = $("#txt_doviz_kuru").val().replace(".", "").replace(",", ".");

        grandTotal = (parseFloat(grandTotal));

        grandTotal_try = (grandTotal * txt_doviz_kuru).toFixed(2);
        $('#grandTotal_try').val(grandTotal_try);

        $("#total_yazi_try").empty().html((number_format((grandTotal_try), 2, ',', '.')));
    });


    $(document).on("click", ".rd_account", function() {
        var selectedAccount = $('input[name="radioSizeAccount"]:checked').attr('id');
        var selectedAccountName = $('input[name="radioSizeAccount"]:checked').attr('accName');
        var selectedAccountMoneyId = $('input[name="radioSizeAccount"]:checked').attr('accMoneyUnitId');
        var selectedAccountMoneyName = $('input[name="radioSizeAccount"]:checked').attr('accMoneyUnitName');

        if (selectedAccountMoneyName != $("#sale_money_unit_id option:selected").attr('data_money_code')) {
            Swal.fire({
                title: "Uyarı!",
                html: 'Döviz tipi sadece '+ $("#sale_money_unit_id option:selected").attr('data_money_code') +' olan işlem hesaplarını seçebilirsiz. ',
                icon: "warning",
                confirmButtonText: 'Tamam',
            });
        } else {
            if (selectedAccount != null && selectedAccount != 0) {
                // selectedAccount = selectedAccount.substring(11);
                $('#account_name').empty().val(selectedAccountName);
                $('#financial_account_id').empty().val(selectedAccount);
                $('#mdl_hesaplar').modal('hide');

                $('#moneyUnit').empty().append(selectedAccountMoneyName);
                $('#money_unit_id').val(selectedAccountMoneyId);

                $('#customRadio' + selectedAccountMoneyId).attr('checked', 'checked');
            } else {
                swetAlert("Lütfen işlem hesabı seçiniz", "", "err");
            }
        }
    });

    $(document).on("click", ".rd_money", function() {
        var selectedBaseMoneyCode = $('input[name="radioSize"]:checked').attr('money_code'); //TRY
        var selectedBaseMoneyID = $('input[name="radioSize"]:checked').attr('value');

        $('#moneyUnit').empty().append(selectedBaseMoneyCode);
        $('#money_unit_id').empty().val(selectedBaseMoneyID);
        $('#mdl_parabirimi').modal('hide');

    });

    var selectedMoneyIcon = "<?= isset($cari_item) ? $cari_item['money_icon'] : '' ?>";

    $("#sale_money_unit_id").change(function() {
        var selectedVal = $("#sale_money_unit_id option:selected").val();
        var selectedText = $("#sale_money_unit_id option:selected").text();
        selectedMoneyIcon = $("#sale_money_unit_id option:selected").attr('data_money_icon');
        selectedMoneyCurrency = $("#sale_money_unit_id option:selected").attr('data_money_currency');

        $('#txt_doviz_kuru').val(parseFloat(selectedMoneyCurrency).toFixed(2));

        $("#shipment_order_money_unit").empty().text(" " + selectedMoneyIcon);
        $("#total_yazi_para_birimi").empty().text(" " + selectedMoneyIcon);
        var anlikBirim = $("#sale_money_unit_id").val();

        $("td[data-moneyID]").each(function() {
            var moneyID = $(this).data('moneyid');  // data-moneyID değerini alıyoruz
            
            if (moneyID == anlikBirim) {
        $(this).hide();  // Eğer money_unit_id eşleşiyorsa <td> elementini kaldırıyoruz
    }else{   
         $(this).show(); 
         }
        });
    });


    $('#add_shipment_order_item').on('click', function() {


        

      setTimeout(() => {
        $('#sale_money_unit_id').val($("#sale_money_unit_id option:selected").val());
        $('#sale_money_unit_id').trigger('change');
      }, 1);



        if (parseFloat($('#from_warehouse').val()) != 0 &&
            ($('#add_barcode_number').val() == 0 ||
                $('#add_barcode_number').val() == '' ||
                $('#add_barcode_number').val() == undefined)) {
            swetAlert("Hatalı İşlem", "Lütfen sevkiyat emri eklemeden önce çıkış deposu ve stok seçiniz", "err");
            return;
        } else {

            if ($("#sale_order_quantity").val() > kalanMiktar) {
                swetAlert("Hatalı İşlem", "Barkoddaki miktardan daha fazla miktar girilemez", "err");
            } else {
                if ($('#sale_order_quantity').val() == 0 || $('#sale_order_quantity').val() == '' || $('#sale_order_quantity').val() == undefined || $('#sale_order_total_amount').val() == '' || $('#sale_order_total_amount').val() == NaN) {
                    swetAlert("Hatalı İşlem", "Satış miktar alanı boş olamaz", "err");
                } else {

                    if ( $('#sale_money_unit_id').val() != 3 && ($('#txt_doviz_kuru').val() == 0 || $('#txt_doviz_kuru').val() == null ) ) {

                        swetAlert("Hatalı İşlem", "Lütfen döviz kur bilgisini giriniz", "err");
                        
                    } else {

                        $('#sale_money_unit_id').attr('disabled', true);
                        stock_id = fullData.stock_barcode_id;

                        stock_barcode = $('#add_barcode_number').val();
                        stock_barcode_id = fullData.stock_barcode_id;
                        sale_money_unit_id = $("#sale_money_unit_id option:selected").val();
                        stock_code = $('#stock_code').val();
                        stock_title = $('#stock_title').val();
                        sale_unit_id = fullData.sale_unit_id;
                        sale_unit_price = $('#sale_unit_price').val();
                        sale_order_unit = $('#sale_order_unit').text();
                        sale_order_quantity = $('#sale_order_quantity').val();
                        sale_order_total_amount = $('#sale_order_total_amount').val();

                        console.log("rowda gelen base sale_order_quantity",sale_order_quantity);
                        console.log("rowda gelen replace edilmiş base sale_order_quantity",sale_order_quantity.replace(".", "").replace(",", "."));


                        var $order_count = parseInt($("#order_count").val());
                        $order_count = $order_count + 1;

                        var str = $("#order_item_").clone().prop("id", "order_item_" + $order_count);

                        str.attr("data-sale-amount", sale_order_quantity);
                        str.attr("data-sale-unit-price", sale_unit_price);
                        str.attr("data-sale-total-price", sale_order_total_amount);
                        str.attr("data-sale-unit-id", sale_unit_id);
                        str.attr("data-barcode-number", stock_barcode);
                        str.attr("data-stock-barcode-id", stock_barcode_id);
                        str.attr("data-sale-money-unit-id", sale_money_unit_id);

                        str.find('#data-stock-title').text(stock_barcode + " | " + stock_code + " | " + stock_title);
                        str.find('#data-sale-amount').text(sale_order_quantity + " " + fullData.unit_title);
                        str.find('#data-sale-unit-price').text(sale_unit_price + " " + selectedMoneyIcon);
                        str.find('#data-shipment-order-total-amount').text(sale_order_total_amount + " " + selectedMoneyIcon);

                        $("#shipment_order_items").append(str);
                        $("#order_item_" + $order_count).removeClass("d-none");
                        $("#order_count").val($order_count);


                        table.find('tr').each(function(index) {
                            $(this).find('td:first').text(index);
                        });

            
                        // $('#toplamSiparisMiktar').val(toplamSiparisMiktar);


                        row_toplamSiparisMiktar = sale_order_quantity.replace(".", "").replace(",", ".");

                        var grandTotal = $('#grandTotal').val();
                        var grandTotal_try = $('#grandTotal_try').val();
                        var txt_doviz_kuru = $("#txt_doviz_kuru").val() == 0 ? 0 : $("#txt_doviz_kuru").val().replace(".", "").replace(",", ".");

                        grandTotal = (parseFloat(grandTotal) + parseFloat(sale_order_total_amount)).toFixed(2);
                        $('#grandTotal').val(grandTotal);

                        grandTotal_try = (parseFloat(grandTotal) * parseFloat(txt_doviz_kuru)).toFixed(2);
                        $('#grandTotal_try').val(grandTotal_try);




 // Genel toplam ve diğer değerler
 var GenelToplamFull = (grandTotal); // İlk genel toplam hesaplaması
        
        // Seçilen para birimi
        var anlikParaBirimi = $('#sale_money_unit_id').find(":selected").attr("data-money-unit-code"); // Örneğin USD, EUR
    
        // Kurlar üzerinde döngü yaparak hesaplama
        kurlar.forEach(function(kur) {
            // Kur fiyatı anahtarını oluştur
            var kurFiyatKey = 'kur_fiyat_' + kur.money_code; // Örnek: 'kur_fiyat_USD'
            var kurFiyat = 0; // Virgülü noktaya çevirip float yapıyoruz
    
            // Eğer seçilen para birimi farklıysa hesaplamayı yap
            var toplamFiyat;
            if (anlikParaBirimi === kur.money_code) {
                // Eğer seçilen para birimi aynıysa (örn. USD), genel toplamı direkt alırız
                toplamFiyat = GenelToplamFull;
            } else {
                // Bu kısımda TRY veya diğer kurlar için input değerini alıyoruz
                var kurInputValue = 0;
    
                if(kur.money_code == "TRY") {
                    kurInputValue = $(".doviz_degis").val(); // TRY için 'doviz_degis' sınıfından değer alıyoruz
                    if (!kurInputValue) {
                        console.log("TRY için input değeri bulunamadı.");
                    }
                } else {
                    kurInputValue = $("#kur_fiyat_" + kur.money_code).val(); // Diğer kurlar için ID'den alıyoruz
                    if (!kurInputValue) {
                        console.log(kur.money_code + " için input değeri bulunamadı.");
                    }
                }
    
                if (kurInputValue) {
                    kurFiyat = parseFloat(kurInputValue.replace(",", ".")); // Input değerini sayıya çeviriyoruz
                }
    
                // Seçilen para birimi farklıysa dönüşüm işlemi yap
                if(anlikParaBirimi == "TRY"){
                    toplamFiyat = GenelToplamFull / kurFiyat; // Genel toplamı kur fiyatına böleriz

                }else{
                    toplamFiyat = GenelToplamFull * kurFiyat; // Genel toplamı kur fiyatına böleriz

                }
    
                console.log("anlikParaBirimi: " + kur.money_code);
                console.log("kurFiyat: " + kurInputValue);
                console.log("GenelToplamFull: " + GenelToplamFull);
            }
    
            // Kur toplam fiyatını string hale getirip güncelle
            var kurToplamFiyatKey = 'kur_toplam_fiyat_' + kur.money_code; // Örnek: 'kur_toplam_fiyat_USD'
            toplamFiyat = toplamFiyat.toString().replace(",", ".");

            kur[kurToplamFiyatKey] = parseFloat(toplamFiyat).toFixed(2); // Sonucu iki ondalıklı hale getirir
    
            // Hesaplanan toplam fiyatı ilgili input alanına yaz
            var toplamFiyatInput = document.querySelector('input[name="' + kurToplamFiyatKey + '"]');
            if (toplamFiyatInput) {
                toplamFiyatInput.value = formatTurkishNumber(toplamFiyat); // Input alanına değeri yaz
            }
    
            // Aynı şekilde kur fiyatını da ilgili input alanına yaz
            var kurFiyatInput = document.querySelector('input[name="' + kurFiyatKey + '"]');
            if (kurFiyatInput) {
                kurFiyatInput.value = formatTurkishNumber(kurFiyat); // Kur fiyatı input alanına değeri yaz
            }
    
            // Input alanı dinleyicisi ekleyelim ki kur fiyatı değişirse hesaplamayı güncelle
            if (kurFiyatInput) {
                kurFiyatInput.addEventListener('keyup', function () {
                    // Input alanındaki yeni değeri al ve sayıya dönüştür
                    var newKurFiyat = parseFloat(kurFiyatInput.value.replace(",", "."));
            
                    // Eğer sayı geçerli değilse işlemi durdur
                    if (isNaN(newKurFiyat)) {
                        return;
                    }
            
                    // Yeni kur fiyatı ile GenelToplamFull'ü yeniden çarp/böl
                    var newToplamFiyat;
                    if (anlikParaBirimi === kur.money_code) {
                        newToplamFiyat = GenelToplamFull; // Eğer aynı para birimi ise, genel toplam direkt alınır
                    } else {
                        // TRY ise bölme, diğer para birimleri için çarpma işlemi yapılır
                        if (anlikParaBirimi == "TRY") {
                            newToplamFiyat = GenelToplamFull / newKurFiyat; // TRY için genel toplamı kur fiyatına böleriz
                        } else {
                            newToplamFiyat = GenelToplamFull * newKurFiyat; // Diğer para birimleri için çarparız
                        }
                    }
            
                    // Sonucu ilgili 'kur_toplam_fiyat_' inputuna yaz
                    if (toplamFiyatInput) {
                        toplamFiyatInput.value = formatTurkishNumber(newToplamFiyat);
                    }
            
                    // Kurlar dizisindeki ilgili objeyi güncelle
                    kur['kur_fiyat_' + kur.money_code] = newKurFiyat; // Kur fiyatını güncelle
                    newToplamFiyat = newToplamFiyat.toString().replace(",", ".");

                    kur['kur_toplam_fiyat_' + kur.money_code] = parseFloat(newToplamFiyat).toFixed(2); // Toplam fiyatı güncelle
            
                    console.log('Güncellenmiş kurlar:', kurlar); // Güncellenmiş kurlar dizisini kontrol et
                });
            }
        });
    


                        toplamSiparisMiktar = parseFloat(toplamSiparisMiktar) + parseFloat(row_toplamSiparisMiktar);

                        $('#toplamSiparisMiktar').val(parseFloat(toplamSiparisMiktar));


                        $('#total_yazi').empty().html(grandTotal);
                        $('#total_yazi_try').empty().html(parseFloat(grandTotal_try).toFixed(2));



                        $("#stock_id").val(0);
                        $("#add_barcode_number").val('');
                        $("#stock_code").val('');
                        $("#stock_title").val('');
                        $("#sale_unit_price").val('');
                        $("#sale_order_total_amount").val('');
                        $("#sale_order_quantity").val('');
                        $('#remaining_quantity').val('');

                    }
                }
            }
        }
    });


    $('#yeniSevkiyat').on('click', function(e) {



        var satir_sayisi = $('#order_count').val();
        if (satir_sayisi >= 1) {
            e.preventDefault();

            if (sale_order_quantity > kalanMiktar) {
                swetAlert("Hatalı İşlem", "stok yok", "err");
            } else {
                sale_unit_price = $("#sale_unit_price").val().replace(".", "").replace(",", ".");
                sale_order_quantity = $("#sale_order_quantity").val().replace(".", "").replace(",", ".");

                total = (parseFloat(sale_unit_price) * parseFloat(sale_order_quantity)).toFixed(2);

                $('#sale_order_total_amount').val(total);
            }


           

            var form_data = [{
                    name: "warehouse_id",
                    value: $("#from_warehouse option:selected").val(),
                },
                {
                    name: "cari_id",
                    value: $('#cari_id').val(),
                },
                {
                    name: "shipment_note",
                    value: $('#shipment_note').val(),
                },
                {
                    name: "money_unit_id",
                    value: $("#sale_money_unit_id option:selected").val(),
                },
                {
                    name: "total_stock_amount",
                    value: $('#grandTotal').val(),
                },
                {
                    name: "total_stock_amount_try",
                    value: $('#grandTotal_try').val(),
                },
                {
                    name: "currency_amount",
                    value: $("#txt_doviz_kuru").val() == 0 ? 0 : $("#txt_doviz_kuru").val().replace(".", "").replace(",", "."),
                },
                {
                    name: "has_collection",
                    value: has_collection,
                },
            ];

            if (has_collection === 1) {
                form_data.push({
                    name: "selectedAccount",
                    value: $('input[name="radioSizeAccount"]:checked').attr('id'),
                }, {
                    name: "selectedAccountMoneyId",
                    value: $('input[name="radioSizeAccount"]:checked').attr('accMoneyUnitId'),
                }, {
                    name: "collection_date",
                    value: $('#transaction_date').val(),
                });

            } else {
                console.log("has_collection tıklanmadı");
            }

            form_data.push({
                name: 'kurlar',
                value: JSON.stringify(kurlar), // Kurlar dizisini JSON formatında ekledik
            });

            if ($('#from_warehouse').find(":selected").val() == 0) {
                swetAlert("Eksik Birşeyler Var", "Lütfen Çıkış Deposunu Seçiniz ", "err");
                return;
            } else if ($('#to_warehouse').find(":selected").val() == 0) {
                swetAlert("Hatalı Depo Seçimi", "Lütfen Geçerli Bir Müşteri Seçiniz", "err");
                return;
            } else {

                let siparis_satir_sayi = $("#order_count").val();
                let siparis_satir_array = [];
                let siparis_satir = {};
                console.log("sipariş satır sayısı: " + siparis_satir_sayi);


                let i4 = 0;

                for (let index = i4; index <= siparis_satir_sayi; index++) {
                    if ($("#order_item_" + index).is(":visible") == true) {
                        siparis_satir = {
                            sale_amount: $("#order_item_" + index).attr('data-sale-amount'),
                            sale_unit_price: $("#order_item_" + index).attr('data-sale-unit-price'),
                            sale_unit_id: $("#order_item_" + index).attr('data-sale-unit-id'),
                            barcode_number: $("#order_item_" + index).attr('data-barcode-number'),
                            stock_barcode_id: $("#order_item_" + index).attr('data-stock-barcode-id'),
                            sale_money_unit_id: $("#order_item_" + index).attr('data-sale-money-unit-id'),
                        };

                        siparis_satir_array.push(siparis_satir);
                    }
                }


                console.log(form_data);
                console.log(siparis_satir_array);
                var base_url = window.location.origin;

                if ( $('#sale_money_unit_id').val() != 3 && ($('#txt_doviz_kuru').val() == 0 || $('#txt_doviz_kuru').val() == null ) ) {

                swetAlert("Hatalı İşlem", "Lütfen döviz kur bilgisini giriniz", "err");

                } else {

                    Swal.fire({
                        title: 'Kaydetmek Üzeresiniz!',
                        html: 'Tedarikçi iade faturanız sisteme kaydedilecektir.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Devam Et',
                        cancelButtonText: 'Düzenle',
                        allowEscapeKey: false,
                        allowOutsideClick: false,

                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Tedarikçi iade faturanız oluşturuluyor, lütfen bekleyiniz...',
                                html: 'Tedarikçi iade faturanız oluşturulurken lütfen bekleyiniz...',
                                allowOutsideClick: false,
                                onBeforeOpen: () => {
                                    Swal.showLoading();
                                },
                            });


                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                                },
                                type: 'POST',
                                url: '<?= route_to('tportal.cari.sale_order_store_iade') ?>',
                                dataType: 'json',
                                data: {
                                    formData: form_data,
                                    sale_order_items: siparis_satir_array
                                },
                                async: true,
                                success: function(response) {
                                    swal.close();
                                    console.log("response", response);
                                    if (response['icon'] == 'success') {
                                        $('#printQuickSale').attr('href', base_url + '/tportal/invoice/quickSalePrint/' + response['newOrderId']);
                                        $('#seeCari').attr('href', base_url + '/tportal/cari/detail/' + $('#cari_id').val());
                                        $("#trigger_sale_order_ok_button").trigger("click");
                                    } else {
                                        console.log(response)
                                        swetAlert("Hatalı İşlem", response['message'], "err");
                                    }
                                }
                            })
                        } else {
                            console.log("düzenlemeye devamm");
                        }
                    });

                }


            }
        } else {
            Swal.fire({
                title: 'Uyarı!',
                html: 'Lütfen en az 1 satır ürün ekleyiniz.',
                icon: 'warning',
                confirmButtonText: 'Tamam',

            })
        }
    });
</script>


<?= $this->endSection() ?>