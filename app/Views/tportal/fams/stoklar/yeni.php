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
                                                                    value="product" required checked>
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
                                                                    value="service" required>
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
                                                    <div class="form-group"><label class="form-label" for="type_id">Ürün
                                                            Tipi</label><span class="form-note d-none d-md-block">Ürünün
                                                            ait olduğu
                                                            tipi.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap ">
                                                            <div class="form-control-select">
                                                                <select required=""
                                                                    class="form-control select2 form-control-xl"
                                                                    name="type_id" id="type_id">
                                                                    <option value="" disabled>Lütfen Seçiniz</option>
                                                                    <?php 
                                                                    foreach($type_items as $type_item){ ?>
                                                                    <option value="<?= $type_item['type_id'] ?>"
                                                                        <?php if($type_item['default'] == 'true'){ echo 'selected'; } ?>>
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
                                                            for="stock_title">Ürün Adı</label><span
                                                            class="form-note d-none d-md-block">Gözükecek ürün
                                                            adı.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text"
                                                                class="form-control form-control-xl" id="stock_title"
                                                                value="" name="stock_title"
                                                                placeholder="AUDI A3 8L 1996-2000 Ayna Kapağı 2 Prç. P.Çelik">
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
                                                                value="" placeholder="200037" name="stock_code"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="pattern_code">Kalıp Adresi</label><span
                                                            class="form-note d-none d-md-block">Gözükecek kalıp
                                                            adresi.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text"
                                                                class="form-control form-control-xl" id="pattern_code"
                                                                value="" placeholder="pattern_code" name="pattern_code">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="supplier_stock_code">Tedarikçi Stok Kodu</label><span
                                                            class="form-note d-none d-md-block">Ürünün varsa tedarikçi
                                                            kodu</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text"
                                                                class="form-control form-control-xl"
                                                                id="supplier_stock_code" value=""
                                                                placeholder="CT-SK-0005" name="supplier_stock_code">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="unit_price">Birim Fiyat</label><span
                                                            class="form-note d-none d-md-block">Ürünün birim fiyat
                                                            bilgisi</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                    <div class="col-8 pe-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text"
                                                                    class="form-control form-control-xl" id="unit_price"
                                                                    value="" placeholder="15,87" name="unit_price" onkeypress="return SadeceRakam(event,[',','-']);">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap ">
                                                                <div class="form-control-select">
                                                                    <select required=""
                                                                        class="form-control select2 form-control-xl"
                                                                        name="money_unit_id" id="money_unit_id">
                                                                        <option value="" disabled>Lütfen Seçiniz
                                                                        </option>
                                                                        <?php 
                                                                    foreach($money_unit_items as $money_unit_item){ ?>
                                                                        <option
                                                                            value="<?= $money_unit_item['money_unit_id'] ?>"
                                                                            <?php if($money_unit_item['default'] == 'true'){ echo 'selected'; } ?>>
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
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="critical_stock">Kritik Stok</label><span
                                                            class="form-note d-none d-md-block">Ürünün kritik stok sayısı</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text"
                                                                class="form-control form-control-xl"
                                                                id="critical_stock" value="" placeholder="critical_stock"
                                                                name="critical_stock"></div>
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
                                                                    name="category_id" id="category_id">
                                                                    <option value="" disabled>Lütfen Seçiniz</option>
                                                                    <?php 
                                                                    foreach($category_items as $category_item){ ?>
                                                                    <option value="<?= $category_item['category_id'] ?>"
                                                                        <?php if($category_item['default'] == 'true'){ echo 'selected'; } ?>>
                                                                        <?= $category_item['category_title'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="unit_id">Birim</label>
                                                        <span class="form-note d-none d-md-block">Ürünün birimi.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap ">
                                                            <div class="form-control-select">
                                                                <select required=""
                                                                    class="form-control  select2 form-control-xl"
                                                                    name="unit_id" id="unit_id">
                                                                    <option value="" disabled>Lütfen Seçiniz</option>
                                                                    <?php 
                                                                    foreach($unit_items as $unit_item){ ?>
                                                                    <option value="<?= $unit_item['unit_id'] ?>"
                                                                        <?php if($unit_item['default'] == 'true'){ echo 'selected'; } ?>>
                                                                        <?= $unit_item['unit_title'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
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
                                                                    id="reg-enable"><label class="custom-control-label"
                                                                    for="reg-enable" selected>Aktif</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-control-xl custom-radio">
                                                                <input type="radio" class="custom-control-input"
                                                                    value="passive" name="status"
                                                                    id="reg-disable"><label class="custom-control-label"
                                                                    for="reg-disable">Pasif</label>
                                                            </div>
                                                        </li>
                                                        <li class="d-none">
                                                            <div class="custom-control custom-control-xl custom-radio">
                                                                <input type="radio" class="custom-control-input"
                                                                    value="critical" name="status"
                                                                    id="reg-critical"><label
                                                                    class="custom-control-label"
                                                                    for="reg-critical">Kritik</label>
                                                            </div>
                                                        </li>
                                                        <li class="d-none">
                                                            <div class="custom-control custom-control-xl custom-radio">
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