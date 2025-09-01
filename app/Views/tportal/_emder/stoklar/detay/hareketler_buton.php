<a href="#" id="btn_sevkgiris" data-bs-toggle="modal" data-bs-target="#mdl_stock_barcode_create"
    class="btn btn-primary">Stok
    Giriş</a>


<div class="modal fade" tabindex="-1" id="mdl_stock_barcode_create">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manuel Stok Ekleme</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="createStockBarcodeModalForm" method="post"
                    class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="warehouse_id">Depo Seç</label>
                        <div class="form-control-wrap">
                            <select class="form-select init-select2" data-search="on" data-ui="xl" name="warehouse_id"
                                id="warehouse_id">
                                <option value="" disabled>Lütfen Seçiniz</option>
                                <?php foreach($warehouse_items as $warehouse_item){ ?>
                                <option value="<?= $warehouse_item['warehouse_id'] ?>"
                                    <?php if($warehouse_item['default'] == 'true'){ echo 'selected'; } ?>>
                                    <?= $warehouse_item['warehouse_title'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 align-center mb-4">
                        <div class="col-12">
                            <label class="form-label" for="warehouse_address">Depo Adresi</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="Depo Adresi"
                                    id="warehouse_address" name="warehouse_address">
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center mb-4">
                        <input type="hidden" value="0" name="" id="str_s">
                        <div class="col-12">
                            <label class="form-label" for="stock_quantity">Miktar</label>
                            <div class="form-control-wrap" id="Satir_0">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl text-end" id="stock_quantity"
                                        placeholder="İşlem Miktarını Giriniz" name="stock_quantity"
                                        onkeypress="return SadeceRakam(event,[',']);">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                            id="basic-addon2"><?= $stock_item['buy_unit_title'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center mb-4">
                        <div class="col-12">
                            <div class="form-group"><label class="form-label" for="buy_unit_price">Alış Birim Fiyat
                                    <small>(
                                        <b>KDV
                                            Hariç</b>
                                        )</small></label><span class="form-note d-none d-md-block">Ürünün KDV HARİÇ alış
                                    fiyatı</span></div>
                        </div>
                        <div class="col-12 mt-0 mt-md-2 d-flex">
                            <div class="col-md-7 col-12 pe-md-2">
                                <div class="form-group">
                                    <div class="form-control-wrap"><input type="text"
                                            class="form-control form-control-xl" id="buy_unit_price" value="<?= number_format($stock_item['buy_unit_price'], 4, ',', '') ?>"
                                            placeholder="15,8700" name="buy_unit_price"
                                            onkeypress="return SadeceRakam(event,[',']);">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-12">
                                <div class="form-group">
                                    <div class="form-control-wrap ">
                                        <div class="form-control-select">
                                            <select required="" class="form-control select2 form-control-xl"
                                                name="buy_money_unit_id" id="buy_money_unit_id">
                                                <option value="" disabled>Lütfen Seçiniz
                                                </option>
                                                <?php 
                                                                        foreach($money_unit_items as $money_unit_item){ ?>
                                                <option value="<?= $money_unit_item['money_unit_id'] ?>"
                                                    <?php if($money_unit_item['money_unit_id'] == $stock_item['buy_money_unit_id']){ echo 'selected'; } ?>>
                                                    <?= $money_unit_item['money_code'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center mb-4">
                        <div class="col-12">
                            <label class="form-label" for="transaction_note">Not</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl"
                                    placeholder="Varsa işlem notunuz" id="transaction_note" name="transaction_note">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" class="btn btn-lg  btn-dim btn-outline-light"
                            data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <button type="button" id="stokBarkodOlustur" class="btn btn-lg btn-primary ">KAYDET ve BARKOD
                            YAZDIR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>