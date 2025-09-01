<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Ürün Düzenleme <?= $this->endSection() ?>
<?= $this->section('title') ?> Ürün Düzenleme | <?= $stock_item['stock_code'] ?> - <?= $stock_item['stock_title'] ?> <?= $this->endSection() ?>
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
                                        <h4 class="nk-block-title">Ürün Düzenleme</h4>

                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="card-inner-group">
                                    <form onsubmit="return false;" id="saveStock" method="post">
                                        <div class="card-inner position-relative card-tools-toggle">
                                            <div class="gy-3">
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="stock_type">Ürün / Hizmet</label></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                        <ul class="custom-control-group">
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="stock_type" id="stock_type_product"
                                                                        value="product" disabled
                                                                        <?php if($stock_item['stock_type'] == 'product'){echo "checked";} ?>>
                                                                    <label class="custom-control-label"
                                                                        for="stock_type_product">
                                                                        <span>ÜRÜN</span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="stock_type" id="stock_type_service"
                                                                        value="service" disabled
                                                                        <?php if($stock_item['stock_type'] == 'service'){echo "checked";} ?>>
                                                                    <label class="custom-control-label"
                                                                        for="stock_type_service">
                                                                        <span>HİZMET</span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                              
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="stock_type">Ürün Listeleme</label><span
                                                                class="form-note d-none d-md-block">Ürününüz varyantlı
                                                                ise
                                                                seçiniz.</span></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="has_variant" name="has_variant" disabled
                                                                <?php if($stock_item['has_variant'] == 1){echo "checked";} ?>>
                                                            <label class="custom-control-label"
                                                                for="has_variant">Varyantlı
                                                                Ürün</label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="stock_type">Paketli Ürün</label><span
                                                                class="form-note d-none d-md-block">Ürününüz paketli ürün
                                                                ise
                                                                seçiniz.</span></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="paket" name="paket" disabled
                                                                <?php if($stock_item['paket'] == 1){echo "checked";} ?>>
                                                            <label class="custom-control-label"
                                                                for="paket">Paketli
                                                                Ürün</label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="type_id">Ürün
                                                                Tipi</label><span
                                                                class="form-note d-none d-md-block">Ürünün
                                                                ait olduğu
                                                                tipi.</span></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap ">
                                                                <div class="form-control-select">
                                                                    <select required=""
                                                                        class="form-control select2 form-control-xl"
                                                                        name="type_id" id="type_id" >
                                                                        <option value="" >Lütfen Seçiniz
                                                                        </option>
                                                                        <?php 
                                                                    foreach($type_items as $type_item){ ?>
                                                                        <option value="<?= $type_item['type_id'] ?>"
                                                                            <?php if($stock_item['type_id'] == $type_item['type_id']){ echo 'selected'; } ?>>
                                                                            <?= $type_item['type_title'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="category_id">Kategori</label><span
                                                                class="form-note d-none d-md-block">Ürünün ait olduğu
                                                                kategori.</span></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap ">
                                                                <div class="form-control-select">
                                                                    <select required=""
                                                                        class="form-control select2 form-control-xl"
                                                                        name="category_id" id="category_id" >
                                                                        <option value="" >Lütfen Seçiniz
                                                                        </option>
                                                                        <?php 
                                                                    foreach($category_items as $category_item){ ?>
                                                                        <option
                                                                            value="<?= $category_item['category_id'] ?>"
                                                                            <?php if($stock_item['category_id'] == $category_item['category_id']){ echo 'selected'; } ?>>
                                                                            <?= $category_item['category_title'] ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?=  view_cell(
                                                'App\Libraries\ViewComponents::getComponent',
                                                [
                                                    'component_name' => 'stoklar.list.altkategoriler',
                                                ]
                                    ) ?>
                                    

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="stock_barcode">Ürün Barkodu</label><span
                                                                class="form-note d-none d-md-block">Gözükecek ürün
                                                                barkodu.</span></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control form-control-xl"
                                                                    placeholder="Yoksa otomatik oluşacaktır"
                                                                    name="stock_barcode"
                                                                    <?php if(session()->get('user_item')['client_id'] != 155){ echo 'disabled'; } ?>
                                                                    value="<?= remove_end_of_barcode($stock_item['stock_barcode']); ?>"
                                                                    onkeypress="return SadeceRakam(event,['-'], 've -');">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="stock_code">Ürün Kodu</label><span
                                                                class="form-note d-none d-md-block">Gözükecek ürün
                                                                kodu.</span></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text"
                                                                    class="form-control form-control-xl" id="stock_code"
                                                                    value="<?= $stock_item['stock_code'] ?>"
                                                                    placeholder="Gözükecek ürün kodunu giriniz" disabled
                                                                    name="stock_code"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="stock_title">Ürün Adı</label><span
                                                                class="form-note d-none d-md-block">Gözükecek ürün
                                                                adı.</span></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text"
                                                                    class="form-control form-control-xl"
                                                                    id="stock_title"
                                                                    value="<?= $stock_item['stock_title'] ?>"
                                                                    name="stock_title"
                                                                    placeholder="Gözükecek ürün adını giriniz">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                  
                                        <div class="card-inner position-relative card-tools-toggle">
                                            <div class="gy-3">
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="supplier_stock_code">Tedarikçi Stok
                                                                Kodu</label><span
                                                                class="form-note d-none d-md-block">Ürünün varsa
                                                                tedarikçi
                                                                kodu</span></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text"
                                                                    class="form-control form-control-xl"
                                                                    id="supplier_stock_code"
                                                                    value="<?= $stock_item['supplier_stock_code'] ?>"
                                                                    placeholder="Ürünün varsa tedarikçi kodunu giriniz"
                                                                    name="supplier_stock_code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group">
                                                            <label class="form-label" for="buy_unit_id">Alış
                                                                Birim</label>
                                                            <span class="form-note d-none d-md-block">Ürünün alış
                                                                birimi.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                        <div class="col-6 pe-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap ">
                                                                    <div class="form-control-select">
                                                                        <select required=""
                                                                            class="form-control  select2 form-control-xl"
                                                                            name="buy_unit_id" id="buy_unit_id">
                                                                            <option value="" disabled>Lütfen Seçiniz
                                                                            </option>
                                                                            <?php 
                                                                    foreach($unit_items as $unit_item){ ?>
                                                                            <option value="<?= $unit_item['unit_id'] ?>"
                                                                                <?php if($unit_item['unit_id'] == $stock_item['buy_unit_id']){ echo 'selected'; } ?>>
                                                                                <?= $unit_item['unit_title'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="buy_unit_price">Alış Birim Fiyat <small>( <b>KDV
                                                                        Hariç</b>
                                                                    )</small></label><span
                                                                class="form-note d-none d-md-block">Ürünün KDV HARİÇ
                                                                alış
                                                                fiyatı</span></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                        <div class="col-6 pe-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap"><input type="text"
                                                                        class="form-control form-control-xl"
                                                                        id="buy_unit_price"
                                                                        value="<?= number_format($stock_item['buy_unit_price'], 4, ',', '') ?>"
                                                                        placeholder="15,8700" name="buy_unit_price"
                                                                        onkeypress="return SadeceRakam(event,[',','-']);">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap ">
                                                                    <div class="form-control-select">
                                                                        <select required=""
                                                                            class="form-control select2 form-control-xl"
                                                                            name="buy_money_unit_id"
                                                                            id="buy_money_unit_id">
                                                                            <option value="" disabled>Lütfen Seçiniz
                                                                            </option>
                                                                            <?php 
                                                                        foreach($money_unit_items as $money_unit_item){ ?>
                                                                            <option
                                                                                value="<?= $money_unit_item['money_unit_id'] ?>"
                                                                                <?php if($money_unit_item['money_unit_id'] == $stock_item['buy_money_unit_id']){ echo 'selected'; } ?>>
                                                                                <?= $money_unit_item['money_code'] ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-3 ps-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap ">
                                                                    <div class="form-control-select">
                                                                        <select required=""
                                                                            class="form-control select2 form-control-xl"
                                                                            name="buy_tax_rate" id="buy_tax_rate">
                                                                            <!-- <option value="" >Seç
                                                                        </option> -->
                                                                            <option value="20"
                                                                                <?php if($stock_item['buy_tax_rate'] == 20){ echo 'selected'; } ?>>
                                                                                %20</option>
                                                                            <option value="0"
                                                                                <?php if($stock_item['buy_tax_rate'] == 0){ echo 'selected'; } ?>>
                                                                                %0</option>
                                                                            <option value="1"
                                                                                <?php if($stock_item['buy_tax_rate'] == 1){ echo 'selected'; } ?>>
                                                                                %1</option>
                                                                            <option value="10"
                                                                                <?php if($stock_item['buy_tax_rate'] == 10){ echo 'selected'; } ?>>
                                                                                %10</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="buy_unit_price_with_tax">Alış Birim Fiyat <small>(
                                                                    <b>KDV Dahil</b>
                                                                    )</small></label><span
                                                                class="form-note d-none d-md-block">Ürünün KDV DAHİL
                                                                alış
                                                                fiyatı</span></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                        <div class="col-6 pe-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap"><input type="text"
                                                                        class="form-control form-control-xl"
                                                                        id="buy_unit_price_with_tax"
                                                                        value="<?= number_format($stock_item['buy_unit_price_with_tax'], 4, ',', '') ?>"
                                                                        placeholder="15,8700"
                                                                        name="buy_unit_price_with_tax"
                                                                        onkeypress="return SadeceRakam(event,[',','-']);">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-inner position-relative card-tools-toggle">
                                            <div class="gy-3">
                                                <!-- Alış birimi değişince otomatik buda güncellenecek, farklı sececekse belirleyecek.       -->
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group">
                                                            <label class="form-label" for="sale_unit_id">Satış
                                                                Birim</label>
                                                            <span class="form-note d-none d-md-block">Ürünün satış
                                                                birimi.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                        <div class="col-6 pe-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap ">
                                                                    <div class="form-control-select">
                                                                        <select required=""
                                                                            class="form-control  select2 form-control-xl"
                                                                            name="sale_unit_id" id="sale_unit_id">
                                                                            <option value="" disabled>Lütfen Seçiniz
                                                                            </option>
                                                                            <?php 
                                                                    foreach($unit_items as $unit_item){ ?>
                                                                            <option value="<?= $unit_item['unit_id'] ?>"
                                                                                <?php if($unit_item['unit_id'] == $stock_item['sale_unit_id']){ echo 'selected'; } ?>>
                                                                                <?= $unit_item['unit_title'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="sale_unit_price">Satış Birim Fiyat <small>( <b>KDV
                                                                        Hariç</b> )</small></label><span
                                                                class="form-note d-none d-md-block">Ürünün KDV HARİÇ
                                                                birim
                                                                satış fiyatı</span></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                        <div class="col-6 pe-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap"><input type="text"
                                                                        class="form-control form-control-xl"
                                                                        id="sale_unit_price"
                                                                        value="<?= number_format($stock_item['sale_unit_price'], 4, ',', '') ?>"
                                                                        placeholder="15,8700" name="sale_unit_price"
                                                                        onkeypress="return SadeceRakam(event,[',','-']);">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap ">
                                                                    <div class="form-control-select">
                                                                        <select required=""
                                                                            class="form-control select2 form-control-xl"
                                                                            name="sale_money_unit_id"
                                                                            id="sale_money_unit_id">
                                                                            <option value="" disabled>Lütfen Seçiniz
                                                                            </option>
                                                                            <?php 
                                                                        foreach($money_unit_items as $money_unit_item){ ?>
                                                                            <option
                                                                                value="<?= $money_unit_item['money_unit_id'] ?>"
                                                                                <?php if($money_unit_item['money_unit_id'] == $stock_item['sale_money_unit_id']){ echo 'selected'; } ?>>
                                                                                <?= $money_unit_item['money_code'] ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-3 ps-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap ">
                                                                    <div class="form-control-select">
                                                                        <select required=""
                                                                            class="form-control select2 form-control-xl"
                                                                            name="sale_tax_rate" id="sale_tax_rate">
                                                                            <!-- <option value="" >Seç
                                                                        </option> -->
                                                                            <option value="20"
                                                                                <?php if($stock_item['sale_tax_rate'] == 20){ echo 'selected'; } ?>>
                                                                                %20</option>
                                                                            <option value="0"
                                                                                <?php if($stock_item['sale_tax_rate'] == 0){ echo 'selected'; } ?>>
                                                                                %0</option>
                                                                            <option value="1"
                                                                                <?php if($stock_item['sale_tax_rate'] == 1){ echo 'selected'; } ?>>
                                                                                %1</option>
                                                                            <option value="10"
                                                                                <?php if($stock_item['sale_tax_rate'] == 10){ echo 'selected'; } ?>>
                                                                                %10</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="sale_unit_price_with_tax">Satış Birim Fiyat
                                                                <small>(
                                                                    <b>KDV Dahil</b> )</small></label><span
                                                                class="form-note d-none d-md-block">Ürünün KDV DAHİL
                                                                birim
                                                                satış fiyatı</span></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                        <div class="col-6 pe-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap"><input type="text"
                                                                        class="form-control form-control-xl"
                                                                        id="sale_unit_price_with_tax"
                                                                        value="<?= number_format($stock_item['sale_unit_price_with_tax'], 4, ',', '') ?>"
                                                                        placeholder="15,8700"
                                                                        name="sale_unit_price_with_tax"
                                                                        onkeypress="return SadeceRakam(event,[',','-']);">
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
                                                    <div class="col-lg-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="site-name">Stok Takibi</label><span
                                                                class="form-note d-none d-md-block">Stok tabinin yapılıp
                                                                yapılmayacağını seçin.</span></div>
                                                    </div>
                                                    <div class="col  mt-0 mt-md-2">
                                                        <ul class="custom-control-group">
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-radio custom-control-pro">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="stock_tracking" id="stock_tracking_true"
                                                                        value="1"
                                                                        <?php if($stock_item['stock_tracking'] == 1){ echo "checked"; } ?>>
                                                                    <label class="custom-control-label"
                                                                        for="stock_tracking_true">
                                                                        <span>Yapılsın</span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-radio custom-control-pro">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="stock_tracking" id="stock_tracking_false"
                                                                        value="0"
                                                                        <?php if($stock_item['stock_tracking'] == 0){ echo "checked"; } ?>>
                                                                    <label class="custom-control-label"
                                                                        for="stock_tracking_false">
                                                                        <span>Yapılmasın</span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div id="stock_tracking"
                                                    <?php if($stock_item['stock_tracking'] == 0){ echo 'class="d-none"'; } ?>>
                                                    <div class="row g-3 align-center">
                                                        <div class="col-lg-5 col-xxl-5 ">
                                                            <div class="form-group"><label class="form-label"
                                                                    for="critical_stock">Kritik Stok</label><span
                                                                    class="form-note d-none d-md-block">Ürünün kritik
                                                                    stok
                                                                    miktarı</span></div>
                                                        </div>
                                                        <div class="col mt-0 mt-md-2">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" id="critical_stock"
                                                                        name="critical_stock"
                                                                        class="form-control form-control-xl text-end"
                                                                        placeholder="0,0000"
                                                                        value="<?= number_format($stock_item['critical_stock'], 4, ',', '') ?>"
                                                                        onkeypress="return SadeceRakam(event,[',','-']);">
                                                                    <div class="input-group-append">
                                                                        <button
                                                                            class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                            <span id="critical_stock_unit">Adet</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="" style="width: 160px">
                                                            <div class="form-control-wrap">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 col-6">
                                                        <div class="form-group"><label class="form-label">Durum</label>
                                                            <span class="form-note">Sistemde yayınlamasına karar
                                                                veriniz.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 col-xxl-7 col-6">
                                                        <ul class="custom-control-group g-3 align-center flex-wrap">
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-control-xl custom-radio checked">
                                                                    <input type="radio" class="custom-control-input"
                                                                        value="active" checked="" name="status"
                                                                        id="reg-enable"><label
                                                                        class="custom-control-label" for="reg-enable"
                                                                        <?php if($stock_item['status'] == 'active'){ echo 'checked'; } ?>>Aktif</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-control-xl custom-radio">
                                                                    <input type="radio" class="custom-control-input"
                                                                        value="passive" name="status"
                                                                        id="reg-disable"><label
                                                                        class="custom-control-label" for="reg-disable"
                                                                        <?php if($stock_item['status'] == 'active'){ echo 'checked'; } ?>>Pasif</label>
                                                                </div>
                                                            </li>
                                                            <li class="d-none">
                                                                <div
                                                                    class="custom-control custom-control-xl custom-radio">
                                                                    <input type="radio" class="custom-control-input"
                                                                        value="critical" name="status"
                                                                        id="reg-critical"><label
                                                                        class="custom-control-label"
                                                                        for="reg-critical">Kritik</label>
                                                                </div>
                                                            </li>
                                                            <li class="d-none">
                                                                <div
                                                                    class="custom-control custom-control-xl custom-radio">
                                                                    <input type="radio" class="custom-control-input"
                                                                        value="processing" name="status"
                                                                        id="reg-processing"><label
                                                                        class="custom-control-label"
                                                                        for="reg-processing">İşlemde</label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card-inner -->
                                        <div class="card-inner">
                                            <div class="row g-3 pt-3">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <a href="javascript:history.back()"
                                                            class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em
                                                                class="icon ni ni-arrow-left"></em><span>Geri</span></a>
                                                    </div>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <div class="form-group">
                                                        <button type="submit" id="stokKaydet"
                                                            class="btn btn-lg btn-primary">Kaydet</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>

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

<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'stock',
        'modals' => [
            'okey' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Ürün/Hizmet Başarıyla Güncellendi.',
                'modal_buttons' => '<a href="#" onclick="location.reload()" id="stockDetail" class="btn btn-info btn-block mb-2">Bu Ürün/Hizmetin Detayına Git</a>
                                    <a href="'.route_to('tportal.stocks.create').'" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Ürün/Hizmet Ekle</a>
                                    <a href="'.route_to('tportal.stocks.list','all').'" class="btn btn-l btn-dim btn-outline-dark btn-block">Tüm Stoklar</a>'
            ],
        ],
    ]
); ?>



<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
$(document).ready(function() {
    $('#starting_stock_unit').html($('#buy_unit_id').find(":selected").html())
    $('#critical_stock_unit').html($('#buy_unit_id').find(":selected").html())
})
$('#stokKaydet').click(function(e) {
    e.preventDefault();
    if ($('#stock_title').val() == '') {
        swetAlert("Eksik Birşeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
    } else {
        var formData = $('#saveStock').serializeArray();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.edit', $stock_item['stock_id']) ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    $("#trigger_stock_okey_button").trigger("click");
                } else {
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

function calculateWithTax(price_type) {
    if ($('#' + price_type + '_unit_price').val() != null && $('#' + price_type + '_unit_price').val() != '') {
        tempValue = $('#' + price_type + '_unit_price').val()
        if (String(tempValue).includes(",")) {
            tempValue = tempValue.replace(',', '.')
            tempValue = parseFloat(tempValue).toFixed(4)
        } else {
            tempValue = parseFloat(tempValue).toFixed(4)
        }
        tax_rate = $('#' + price_type + '_tax_rate').val();
        new_unit_price_with_tax = tempValue * (1 + (parseFloat(tax_rate) / 100))
        tempValue = replace_for_form_input(tempValue)
        new_unit_price_with_tax = replace_for_form_input(new_unit_price_with_tax.toFixed(4))

        $('#' + price_type + '_unit_price').val(tempValue)
        $('#' + price_type + '_unit_price_with_tax').val(new_unit_price_with_tax)
    } else {
        $('#' + price_type + '_unit_price').val('0,0000')
        $('#' + price_type + '_unit_price_with_tax').val('0,0000')
    }
}

function calculateWithNoTax(price_type) {
    if ($('#' + price_type + '_unit_price_with_tax').val() != null && $('#' + price_type + '_unit_price_with_tax')
        .val() != '') {
        tempValue = $('#' + price_type + '_unit_price_with_tax').val();

        if (String(tempValue).includes(",")) {
            tempValue = tempValue.replace(',', '.')
            tempValue = parseFloat(tempValue).toFixed(4)
        } else {
            tempValue = parseFloat(tempValue).toFixed(4)
        }
        tax_rate = $('#' + price_type + '_tax_rate').val();
        new_unit_price = tempValue / (1 + (parseFloat(tax_rate) / 100))
        tempValue = replace_for_form_input(tempValue)
        new_unit_price = replace_for_form_input(new_unit_price.toFixed(4))

        $('#' + price_type + '_unit_price_with_tax').val(tempValue)
        $('#' + price_type + '_unit_price').val(new_unit_price)
    } else {
        $('#' + price_type + '_unit_price_with_tax').val('0,0000')
        $('#' + price_type + '_unit_price').val('0,0000')
    }
}

$('#buy_unit_price').on('blur', function() {
    calculateWithTax('buy');
})

$('#buy_unit_price_with_tax').on('blur', function() {
    calculateWithNoTax('buy')
})

$('#sale_unit_price').on('blur', function() {
    calculateWithTax('sale')
})

$('#sale_unit_price_with_tax').on('blur', function() {
    calculateWithNoTax('sale')
})

$('#buy_tax_rate').on('change', function() {
    calculateWithTax('buy')
})

$('#sale_tax_rate').on('change', function() {
    calculateWithTax('sale')
})

$('#buy_unit_id').on('change', function() {
    ;
    $('#starting_stock_unit').html($('#buy_unit_id').find(":selected").html())
    $('#critical_stock_unit').html($('#buy_unit_id').find(":selected").html())
})

$('#starting_stock').on('blur', function() {
    if ($('#starting_stock').val() != null && $('#starting_stock').val() != '') {
        tempValue = $('#starting_stock').val()
        if (String(tempValue).includes(",")) {
            tempValue = tempValue.replace(',', '.')
            tempValue = parseFloat(tempValue).toFixed(4)
        } else {
            tempValue = parseFloat(tempValue).toFixed(4)
        }
        tempValue = replace_for_form_input(tempValue)

        $('#starting_stock').val(tempValue)
    } else {
        $('#starting_stock').val('0,0000')
    }
})

$('#critical_stock').on('blur', function() {
    if ($('#critical_stock').val() != null && $('#critical_stock').val() != '') {
        tempValue = $('#critical_stock').val()
        if (String(tempValue).includes(",")) {
            tempValue = tempValue.replace(',', '.')
            tempValue = parseFloat(tempValue).toFixed(4)
        } else {
            tempValue = parseFloat(tempValue).toFixed(4)
        }
        tempValue = replace_for_form_input(tempValue)

        $('#critical_stock').val(tempValue)
    } else {
        $('#critical_stock').val('0,0000')
    }
})

$('input[type=radio][name=stock_tracking]').change(function() {
    if (this.value == '1') {
        $('#stock_tracking').removeClass('d-none');
    } else if (this.value == '0') {
        $('#stock_tracking').addClass('d-none');
    }
});
</script>

<?= $this->endSection() ?>