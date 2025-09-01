<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Paket Seçenekleri
<?= $this->endSection() ?>
<?= $this->section('title') ?> Paket Seçenekleri |
<?= $stock_item['stock_code'] ?> -
<?= $stock_item['stock_title'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>




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
                                        <h4 class="nk-block-title">Paket Seçenekleri</h4>

                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="card-inner-group">
                                    <form onsubmit="return false;" id="formStockPackage" method="post">
                                        <div class="card-inner position-relative card-tools-toggle">
                                            <div class="gy-3">

                                                <!-- <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"for="stock_type">Ürün / Hizmet</label></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                        <ul class="custom-control-group">
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="stock_type" id="stock_type_product"
                                                                        value="product" disabled>
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
                                                                        value="service" disabled>
                                                                    <label class="custom-control-label"
                                                                        for="stock_type_service">
                                                                        <span>HİZMET</span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div> -->

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group">
                                                            <label class="form-label" for="stock_package_name">Paket
                                                                Adı</label>
                                                            <span class="form-note d-none d-md-block">Gözükecek paket
                                                                adı. Ör: 500'lü paket</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control form-control-xl"
                                                                    id="stock_package_name" value=""
                                                                    name="stock_package_name"
                                                                    placeholder="Gözükecek paket adını giriniz">
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
                                                        <div class="form-group">
                                                            <label class="form-label" for="supplier_stock_code">Satış
                                                                Birim İçindeki Miktarı</label>
                                                            <span class="form-note d-none d-md-block">Seçilen satış
                                                                birimin içindeki miktar bilgisini giriniz.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="col mt-0 mt-md-2">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" id="txt_amount_in_package"
                                                                            name="txt_amount_in_package"
                                                                            class="form-control form-control-xl text-end"
                                                                            placeholder="0,0000" value=""
                                                                            onkeypress="return SadeceRakam(event,[',','-']);">
                                                                        <div class="input-group-append">
                                                                            <button
                                                                                class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                                <span
                                                                                    id="unit_title"><?= $stock_item['unit_title'] ?></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="txt_amount_in_package_price">Satış Birim
                                                                Fiyat </label>
                                                            <span class="form-note d-none d-md-block">Ürünün KDV HARİÇ
                                                                satış fiyatı</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                        <div class="col-4 pe-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap"><input type="text"
                                                                        class="form-control form-control-xl"
                                                                        id="txt_amount_in_package_price"
                                                                        value="<?= number_format($stock_item['sale_unit_price'], 2, ',', '.') ?>"
                                                                        placeholder="15,8700"
                                                                        name="txt_amount_in_package_price"
                                                                        onkeypress="return SadeceRakam(event,[',','-']);"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="<?= $stock_item['stock_title'] ?> ürününün birim satış fiyatı."
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 pe-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap ">
                                                                    <div class="">
                                                                        <!-- 
                                                                        <select required=""
                                                                            class="form-control select2 form-control-xl"
                                                                            name="slct_doviz_tipi" id="slct_doviz_tipi">
                                                                            <option value="" disabled>Seçiniz</option>
                                                                            <option value="1"
                                                                                data-money-unit-code="TRY">TRY</option>
                                                                            <option value="2"
                                                                                data-money-unit-code="USD">USD</option>
                                                                            <option value="3"
                                                                                data-money-unit-code="GBP">GBP</option>
                                                                        </select> -->

                                                                        <select id="slct_doviz_tipi" name="slct_doviz_tipi" class="form-select js-select2" data-ui="xl" data-search="on" data-val="TRY">
                                                                            <?php foreach ($money_unit_items as $money_unit_item) { ?>
                                                                                <option value="<?= $money_unit_item['money_unit_id'] ?>" data-money-unit-code="<?= $money_unit_item['money_code'] ?>" <?php if ($stock_item['buy_money_unit_id'] == $money_unit_item['money_unit_id']) {
                                                                                                                                                echo "selected";
                                                                                                                                            } ?>>
                                                                                    <?= $money_unit_item['money_code'] ?> </option>
                                                                            <?php } ?>
                                                                        </select>

                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group d-none" id="currency_area">
                                                                <div class="form-control-wrap ">
                                                                    <input type="text"
                                                                        class="form-control form-control-xl"
                                                                        id="currency_amount" value=""
                                                                        onkeypress="return SadeceRakam(event,[',','-']);"
                                                                        name="currency_amount"
                                                                        placeholder="TL Karşılığı">
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
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group">
                                                            <label class="form-label" for="chx_package_discount">Paket
                                                                Fiyatı
                                                                İndirimi</label>
                                                            <span class="form-note d-none d-md-block">Paket fiyatı için
                                                                indirim uygulamak isteseniz seçiniz.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                        <div class="col-3">
                                                            <div
                                                                class="custom-control custom-control-sm custom-checkbox custom-control-pro">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="chx_package_discount"
                                                                    id="chx_package_discount"><label
                                                                    class="custom-control-label form-control-xl"
                                                                    for="chx_package_discount">Evet</label>
                                                            </div>
                                                        </div>

                                                            <div class="col-4 pe-2">
                                                                <div class="form-group d-none" id="txt_package_discount_rate_area">
                                                                    <div class="input-group">
                                                                        <div class="input-group input-group-lg">
                                                                            <div class="input-group-prepend"><span
                                                                                    class="input-group-text"
                                                                                    id="inputGroup-sizing-lg">%</span>
                                                                            </div><input type="text"
                                                                                maxlength="100"
                                                                                id="txt_package_discount_rate"
                                                                                name="txt_package_discount_rate"
                                                                                class="form-control form-control-xl text-end"
                                                                                placeholder="0,00" value=""
                                                                                onkeypress="return SadeceRakam(event,[',','-']);">
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-5">
                                                                <div class="form-grou d-none" id="txt_package_discount_rate_price_area">
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            id="txt_package_discount_rate_price"
                                                                            name="txt_package_discount_rate_price"
                                                                            class="form-control form-control-xl text-end"
                                                                            placeholder="0,0000" value=""
                                                                            onkeypress="return SadeceRakam(event,[',','-']);"
                                                                            disabled>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    </div>
                                                </div>


                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="chx_custom_package_price">Birim Fiyata Endeksle</label>
                                                            <span class="form-note d-none d-md-block">Birim fiyata endekslemek isterseniz seçiniz.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                        <div class="col-6 pe-2">
                                                            <div
                                                                class="custom-control custom-control-sm custom-checkbox custom-control-pro">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="chx_custom_package_price"
                                                                    id="chx_custom_package_price"><label
                                                                    class="custom-control-label form-control-xl"
                                                                    for="chx_custom_package_price">Evet</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <!-- <div class="form-group d-none" id="custom_package_price_area">
                                                            <div class="input-group">
                                                                <input type="text" id="txt_custom_package_price"
                                                                    name="txt_custom_package_price"
                                                                    class="form-control form-control-xl text-end"
                                                                    placeholder="0,0000" value=""
                                                                    onkeypress="return SadeceRakam(event,[',','-']);">
                                                                <div class="input-group-append">
                                                                    <button
                                                                        class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                        <span id="txt_custom_package_price_currency">TRY</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="txt_total_package_price">Paket
                                                                Satış Fiyatı</label>
                                                            <span class="form-note d-none d-md-block">Seçilen satış
                                                                birimin içindeki miktar bilgisini giriniz.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="col mt-0">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" id="txt_total_package_price"
                                                                            name="txt_total_package_price"
                                                                            class="form-control form-control-xl text-end"
                                                                            placeholder="0,0000" value=""
                                                                            onkeypress="return SadeceRakam(event,[',','-']);">
                                                                        <div class="input-group-append">
                                                                            <button
                                                                                class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                                <span
                                                                                    id="txt_total_package_price_currency">TRY</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


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
                                                        <button type="submit" id="save_stock_package"
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

<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'stock',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Ürün/Hizmet Başarıyla Güncellendi.',
                'modal_buttons' => '<a href="#" onclick="location.reload()" id="stockDetail" class="btn btn-info btn-block mb-2">Bu Ürün/Hizmetin Detayına Git</a>
                                    <a href="' . route_to('tportal.stocks.create') . '" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Ürün/Hizmet Ekle</a>
                                    <a href="' . route_to('tportal.stocks.list', 'all') . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Tüm Stoklar</a>'
            ],
        ],
    ]
); ?>



<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    $(document).ready(function () {
        $('#starting_stock_unit').html($('#buy_unit_id').find(":selected").html())
        $('#critical_stock_unit').html($('#buy_unit_id').find(":selected").html())
    });

    number_format = function (number, decimals, dec_point, thousands_sep) {
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

    //birim fiyata endeksle
    $('#chx_custom_package_price').change(function () {
        if ($("#chx_custom_package_price").is(":checked")) {
            $('#custom_package_price_area').addClass('d-none');
            $('#txt_total_package_price').attr('disabled', true);


            var paketIcindekiMiktar = $('#txt_amount_in_package').val().replace(".", "").replace(",", ".");
            var mevcutBirimSatisFiyati = $('#txt_amount_in_package_price').val().replace(".", "").replace(",", ".");

            var total = mevcutBirimSatisFiyati * paketIcindekiMiktar;


            $('#txt_total_package_price').val(number_format(total, 2, ',', '.'));

            if( $("#txt_package_discount_rate").is(":visible") == true ) {
                $('#chx_package_discount').click();
            }

        } else {
            $('#custom_package_price_area').removeClass('d-none');
            $('#txt_total_package_price').removeAttr('disabled');

        }
    });
    
    //indirim
    $('#chx_package_discount').change(function () {
        if ($("#chx_package_discount").is(":checked")) {
            $('#txt_package_discount_rate_area').removeClass('d-none');
            $('#txt_package_discount_rate_price_area').removeClass('d-none');

            $('#txt_package_discount_rate').val(0);
            $('#txt_package_discount_rate_price').val(0);

            if( $("#chx_custom_package_price").is(":checked") == true ) {
                $('#chx_custom_package_price').click();
            }

        } else {
            $('#txt_package_discount_rate_area').addClass('d-none');
            $('#txt_package_discount_rate_price_area').addClass('d-none');

            var paketIcindekiMiktar = $('#txt_amount_in_package').val().replace(".", "").replace(",", ".");
            var mevcutBirimSatisFiyati = $('#txt_amount_in_package_price').val().replace(".", "").replace(",", ".");

            var total = mevcutBirimSatisFiyati * paketIcindekiMiktar;

            $('#txt_total_package_price').val(number_format(total, 2, ',', '.'));
        }
    });


    $(document).on("keyup", "#txt_amount_in_package", function () {
        var val = $(this).val().replace(".", "").replace(",", ".");
        console.log('Satış Birim İçindeki Miktarı keyup', val);

        var mevcutBirimSatisFiyati = $('#txt_amount_in_package_price').val().replace(".", "").replace(",", ".");

        var total = mevcutBirimSatisFiyati * val;

        $('#txt_total_package_price').val(number_format(total, 2, ',', '.'));
    });


    //indirim değiştiğinde
    $(document).on("keyup", "#txt_package_discount_rate", function () {

        var discount_rate = $(this).val().replace(".", "").replace(",", ".");

        var dovizKarsiligi = $('#currency_amount').val().replace(".", "").replace(",", ".");

        var mevcutBirimSatisFiyati = $('#txt_amount_in_package_price').val().replace(".", "").replace(",", ".");
        var paketIcindekiMiktar = $('#txt_amount_in_package').val().replace(".", "").replace(",", ".");


        var total;
        if ($('#slct_doviz_tipi').val() == 3) {
            total = mevcutBirimSatisFiyati * paketIcindekiMiktar;
        }
        else{
            total = (mevcutBirimSatisFiyati * paketIcindekiMiktar)*dovizKarsiligi;
        }

        var grandTotal = iskontoUygula(total, discount_rate);
        grandTotal = total - grandTotal;
        grandTotal = grandTotal.toFixed(2);
        
        $('#txt_package_discount_rate_price').val(number_format(iskontoUygula(total, discount_rate), 2, ',', '.'));
        $('#txt_total_package_price').val(number_format(grandTotal, 2, ',', '.'));
    });

    function iskontoUygula(mevcutMiktar, yuzde) {

        var iskontoMiktari = (mevcutMiktar * yuzde) / 100;
        // var yeniMiktar = mevcutMiktar - iskontoMiktari;
        
        return iskontoMiktari;
    }

    //Döziz Değiştiğinde
    $(document).on("change", "#slct_doviz_tipi", function () {
        if ($(this).val() == '3') {
            $("#currency_area").addClass("d-none");

            var paketIcindekiMiktar = $('#txt_amount_in_package').val().replace(".", "").replace(",", ".");
            var mevcutBirimSatisFiyati = $('#txt_amount_in_package_price').val().replace(".", "").replace(",", ".");
            var total = paketIcindekiMiktar * mevcutBirimSatisFiyati;

            $('#txt_total_package_price').val(number_format(total, 2, ',', '.'));
            $('#txt_total_package_price').html("dsa");
            
        }
        else {
            $("#currency_area").removeClass("d-none");
            $('#txt_total_package_price').val(0);
        }

        var invoiceNotesCode = $('#slct_doviz_tipi').find(":selected").attr("data-money-unit-code");
    });

    //döviz tl karşılığı
    $(document).on("keyup", "#currency_amount", function () {
        var dovizKarsiligi = $(this).val().replace(".", "").replace(",", ".");
        console.log('döviz tl karşılığı ', dovizKarsiligi);

        var paketIcindekiMiktar = $('#txt_amount_in_package').val().replace(".", "").replace(",", ".");
        var mevcutBirimSatisFiyati = $('#txt_amount_in_package_price').val().replace(".", "").replace(",", ".");

        var total = paketIcindekiMiktar * mevcutBirimSatisFiyati;
        var totalWithCurrency = dovizKarsiligi * total;

        $('#txt_total_package_price').val(number_format(totalWithCurrency, 2, ',', '.'));
    });










    $('#save_stock_package').click(function (e) {
        e.preventDefault();
        if ($('#stock_title').val() == '') {
            swetAlert("Eksik Birşeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
        } else {
            var formData = $('#formStockPackage').serializeArray();
            console.log(formData);
            
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
        if ($('#' + price_type + '_unit_price_with_tax').val() != null && $('#' + price_type + '_unit_price_with_tax').val() != '') {
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

    $('#buy_unit_price').on('blur', function () {
        calculateWithTax('buy');
    })

    $('#buy_unit_price_with_tax').on('blur', function () {
        calculateWithNoTax('buy')
    })

    $('#sale_unit_price').on('blur', function () {
        calculateWithTax('sale')
    })

    $('#sale_unit_price_with_tax').on('blur', function () {
        calculateWithNoTax('sale')
    })

    $('#buy_tax_rate').on('change', function () {
        calculateWithTax('buy')
    })

    $('#sale_tax_rate').on('change', function () {
        calculateWithTax('sale')
    })

    $('#buy_unit_id').on('change', function () {
        ;
        $('#starting_stock_unit').html($('#buy_unit_id').find(":selected").html())
        $('#critical_stock_unit').html($('#buy_unit_id').find(":selected").html())
    })

    $('#starting_stock').on('blur', function () {
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

    $('#critical_stock').on('blur', function () {
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

    $('input[type=radio][name=stock_tracking]').change(function () {
        if (this.value == '1') {
            $('#stock_tracking').removeClass('d-none');
        } else if (this.value == '0') {
            $('#stock_tracking').addClass('d-none');
        }
    });
</script>

<?= $this->endSection() ?>