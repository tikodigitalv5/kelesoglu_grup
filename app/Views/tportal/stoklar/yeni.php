<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Yeni Ürün <?= $this->endSection() ?>
<?= $this->section('title') ?> Yeni Ürün | <?= session()->get('user_item')['firma_adi'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>
<style>
.alt_cizgi{
    border-bottom: 1px solid #dbdfea;
}
    </style>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content  d-xl-none">
                        <h3 class="nk-block-title page-title">Yeni Ürün Kayıt</h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">

                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="row">
                    <div class="col-md-8 col-lg-8">
                        <div class="card card-stretch">
                            <div class="card-inner-group">
                                <form onsubmit="return false;" id="createStock" method="post">
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

                                            <div class="row g-3 align-center" id="urun_listeleme_alani">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="stock_type">Ürün Listeleme</label><span
                                                            class="form-note d-none d-md-block">Ürününüz varyantlı ise
                                                            seçiniz.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="has_variant" name="has_variant">
                                                        <label class="custom-control-label" for="has_variant">Varyantlı
                                                            Ürün</label>
                                                    </div>

                                                </div>
                                            </div>

                                               <div class="row g-3 align-center" id="urun_listeleme_alani">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="stock_type">Paketli Ürün</label><span
                                                            class="form-note d-none d-md-block">Ürününüz paketli ürün ise
                                                            seçiniz.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="paket" name="paket">
                                                        <label class="custom-control-label" for="paket">Paketli
                                                            Ürün</label>
                                                    </div>

                                                </div>
                                            </div>

                                            

                                            <div class="row g-3 align-center" id="urun_tipi_alani">
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
                                                                value="" placeholder="Gözükecek ürün kodunu giriniz"
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
                                                                class="form-control form-control-xl" id="stock_title"
                                                                value="" name="stock_title"
                                                                placeholder="Gözükecek ürün adını giriniz">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <?= view_cell('App\Libraries\ViewComponents::getComponent', ['component_name' => 'stoklar.detay.ozellikler']); ?>

                                    <div class="card-inner position-relative card-tools-toggle">
                                        <div class="gy-3">
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
                                                                placeholder="Ürünün varsa tedarikçi kodunu giriniz"
                                                                name="supplier_stock_code">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="buy_unit_id">Alış Birim</label>
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
                                                                            <?php if($unit_item['default'] == 'true'){ echo 'selected'; } ?>>
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
                                                            class="form-note d-none d-md-block">Ürünün KDV HARİÇ alış
                                                            fiyatı</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                    <div class="col-6 pe-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text"
                                                                    class="form-control form-control-xl"
                                                                    id="buy_unit_price" value="" placeholder="15,8700"
                                                                    name="buy_unit_price"
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
                                                                        name="buy_money_unit_id" id="buy_money_unit_id">
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

                                                    <div class="col-3 ps-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap ">
                                                                <div class="form-control-select">
                                                                    <select required=""
                                                                        class="form-control select2 form-control-xl"
                                                                        name="buy_tax_rate" id="buy_tax_rate">
                                                                        <!-- <option value="" >Seç
                                                                        </option> -->
                                                                        <option value="20" selected>%20</option>
                                                                        <option value="0">%0</option>
                                                                        <option value="1">%1</option>
                                                                        <option value="10">%10</option>
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
                                                            class="form-note d-none d-md-block">Ürünün KDV DAHİL alış
                                                            fiyatı</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                    <div class="col-6 pe-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text"
                                                                    class="form-control form-control-xl"
                                                                    id="buy_unit_price_with_tax" value=""
                                                                    placeholder="15,8700" name="buy_unit_price_with_tax"
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
                                                                            <?php if($unit_item['default'] == 'true'){ echo 'selected'; } ?>>
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
                                                            class="form-note d-none d-md-block">Ürünün KDV HARİÇ birim
                                                            satış fiyatı</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                    <div class="col-6 pe-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text"
                                                                    class="form-control form-control-xl"
                                                                    id="sale_unit_price" value="" placeholder="15,8700"
                                                                    name="sale_unit_price"
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
                                                                            <?php if($money_unit_item['default'] == 'true'){ echo 'selected'; } ?>>
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
                                                                        <option value="20">%20</option>
                                                                        <option value="0">%0</option>
                                                                        <option value="1">%1</option>
                                                                        <option value="10">%10</option>
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
                                                            for="sale_unit_price_with_tax">Satış Birim Fiyat <small>(
                                                                <b>KDV Dahil</b> )</small></label><span
                                                            class="form-note d-none d-md-block">Ürünün KDV DAHİL birim
                                                            satış fiyatı</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                    <div class="col-6 pe-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text"
                                                                    class="form-control form-control-xl"
                                                                    id="sale_unit_price_with_tax" value=""
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
                                                            <div class="custom-control custom-radio custom-control-pro">
                                                                <input type="radio" class="custom-control-input"
                                                                    name="stock_tracking" id="stock_tracking_true"
                                                                    value="1" checked>
                                                                <label class="custom-control-label"
                                                                    for="stock_tracking_true">
                                                                    <span>Yapılsın</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-radio custom-control-pro">
                                                                <input type="radio" class="custom-control-input"
                                                                    name="stock_tracking" id="stock_tracking_false"
                                                                    value="0">
                                                                <label class="custom-control-label"
                                                                    for="stock_tracking_false">
                                                                    <span>Yapılmasın</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div id="stock_tracking">
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">Başlangıç Stoğu ve
                                                                Tarihi</label>
                                                            <span class="form-note d-none d-md-block">Ürün için
                                                                başlangıç
                                                                stoğunu ve<br>tarihini belirleyebilirsiniz.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control form-control-xl text-end"
                                                                    placeholder="0,0000"
                                                                    onkeypress="return SadeceRakam(event,[',','-']);"
                                                                    name="starting_stock" id="starting_stock">
                                                                <div class="input-group-append">
                                                                    <button
                                                                        class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                        <span id="starting_stock_unit">Adet</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- Otomatik o günün tarihi gelebilir -->
                                                    <div class="" style="width: 160px">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-left"
                                                                style="width: calc(1rem + 30px); top:1px">
                                                                <em class="icon ni ni-calendar icon-xl"></em>
                                                            </div>
                                                            <input id="starting_stock_date" name="starting_stock_date"
                                                                type="text"
                                                                class="form-control form-control-xl date-picker"
                                                                style="padding-right: 16px; padding-left: 44px;"
                                                                data-date-format="dd/mm/yyyy" value="12/08/2023">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="critical_stock">Kritik Stok</label><span
                                                                class="form-note d-none d-md-block">Ürünün kritik stok
                                                                miktarı</span></div>
                                                    </div>
                                                    <div class="col mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" id="critical_stock"
                                                                    name="critical_stock"
                                                                    class="form-control form-control-xl text-end"
                                                                    placeholder="0,0000"
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
                                    </div><!-- .card-inner -->
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <a href="javascript:history.back()"
                                                        class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em
                                                            class="icon ni ni-arrow-left"></em><span>Geri</span></a>
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <div class="form-group">
                                                    <button type="submit" id="yeniStok"
                                                        class="btn btn-lg btn-primary">Kaydet</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                </form>
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div>
                </div>
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'stock',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Ürün/Hizmet Başarıyla Oluşturuldu.',
                'modal_buttons' => '<a href="#" id="stockDetail" class="btn btn-info btn-block mb-2"><span>Bu Ürünün (</span><span class="fw-bold" id="new_stock_code"></span><span>) Detayına Git</span></a>
                                    <a href="'.route_to('tportal.stocks.create').'" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Ürün/Hizmet Ekle</a>
                                    <a href="'.route_to('tportal.stocks.list','all').'" class="btn btn-l btn-dim btn-outline-dark btn-block">Tüm Stoklar</a>'
            ],
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
$(document).ready(function(){
    $('#starting_stock_unit').html($('#buy_unit_id').find(":selected").html())
    $('#critical_stock_unit').html($('#buy_unit_id').find(":selected").html())

    // $('.custom-control').on('chan', function() {
    $('input[type=radio][name=stock_type]').change(function() {
        selectedType =this.value;
        if (selectedType=='service') {
            $('#urun_listeleme_alani').addClass('d-none');
            $('#urun_tipi_alani').addClass('d-none');
        } else {
            $('#urun_listeleme_alani').removeClass('d-none');
            $('#urun_tipi_alani').removeClass('d-none');
        }
    });
})

$('#yeniStok').click(function(e) {
    e.preventDefault();
    if ($('#stock_title').val() == '') {
        swetAlert("Eksik Birşeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
    } else {
        var formData = $('#createStock').serializeArray();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.create') ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    $('#stockDetail').attr('href', '<?= route_to('tportal.stocks.detail.null')?>/' +
                        response['new_stock_id'])
                    $('#new_stock_code').html(response['new_stock_code'])
                    $("#trigger_stock_ok_button").trigger("click");
                } else {
                    swetAlert("Hatalı İşlem", response['message'], "err");
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