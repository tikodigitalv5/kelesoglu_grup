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
                            <select class="form-select  init-select2" data-search="on" data-ui="xl" name="warehouse_id"
                                id="warehouse_id">
                                <option value="" disabled>Lütfen Seçiniz</option>
                                <?php foreach ($warehouse_items as $warehouse_item) { ?>
                                    <option value="<?= $warehouse_item['warehouse_id'] ?>" <?php if ($warehouse_item['default'] == 'true') {
                                          echo 'selected';
                                      } ?>>
                                        <?= $warehouse_item['warehouse_title'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="supplier_id">Tedarikçi Seç</label>
                        <div class="form-control-wrap">
                            <select class="form-select  init-select2" data-search="on" data-ui="xl" name="supplier_id"
                                id="supplier_id" data-placeholder="Seçiniz">
                                <option value="0">Seçiniz</option>
                                <?php foreach ($supplier_items as $supplier_item) { ?>
                                    <option value="<?= $supplier_item['cari_id'] ?>">
                                        <?= $supplier_item['invoice_title'] != '' ? $supplier_item['invoice_title'] : $supplier_item['name'] . " " . $supplier_item['surname'] ?>
                                    </option>
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


                    <div class="row g-3 align-center d-none" id="miktarSatirOrnek">
                        <div class="col-12">
                            <div class="d-flex col-lg-12 col-xxl-12">
                                <div class="col-lg-10 mt-0 mt-md-2 ps-1">
                                    <div class="form-control-wrap">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control form-control-xl calcStockTotal text-end"
                                                id="stock_quantity_" placeholder="İşlem Miktarını Giriniz"
                                                name="stock_quantity_" onkeypress="return SadeceRakam(event,[',']);"
                                                autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">
                                                    <?= $stock_item['buy_unit_title'] ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 mt-2" style="margin-left: 10px; align-self:center;">
                                    <div class="row g-1">
                                        <div class="col-6 text-center">
                                            <button id="miktar_satir_ekle"
                                                class="btn btn-icon btn-primary btn-block miktar_satir_ekle"><em
                                                    class="icon ni ni-plus"></em></button>
                                        </div>
                                        <div class="col-6 pl-sm-1 text-center">
                                            <button id="miktar_satir_sil"
                                                class="btn btn-icon btn-danger btn-block miktar_satir_sil"><em
                                                    class="icon ni ni-trash"></em></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div id="miktarBilgileriBlocks">
                        <input id="miktar_str_s" type="hidden" value="0">

                        <div class="row g-3 align-center" id="miktarSatir_0">
                            <div class="col-12">
                                <label class="form-label" for="stock_quantity">Miktar</label>

                                <div class="d-flex col-lg-12 col-xxl-12">
                                    <div class="col-lg-10 mt-0 mt-md-2 ps-1">
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control form-control-xl calcStockTotal text-end"
                                                    id="stock_quantity_0" placeholder="İşlem Miktarını Giriniz"
                                                    name="stock_quantity_0"
                                                    onkeypress="return SadeceRakam(event,[',']);" autocomplete="off">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">
                                                        <?= $stock_item['buy_unit_title'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 mt-2" style="margin-left: 10px; align-self:center;">
                                        <div class="row g-1">
                                            <div class="col-6 text-center">
                                                <button id="miktar_satir_ekle_"
                                                    class="btn btn-icon btn-primary btn-block miktar_satir_ekle"
                                                    satir="0" satir_id="0"><em class="icon ni ni-plus"></em></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row g-3 align-center mb-4 mt-4">
                    <div class="col-12 mt-0 mt-md-2 d-flex">
                    <div class="col-md-3 col-12 pe-md-2">
                        </div>
                    <div class="col-md-3 col-12 pe-md-2">
                        </div>
                    <div class="col-md-6 col-12 pe-md-2" style="margin-right: 50px; display:flex;">

        <div class="form-control-wrap">
            <input type="text" class="form-control form-control-xl text-end" id="total_quantity" disabled>
        </div>
        </div>
    </div>
</div>

                    <?= view_cell('App\Libraries\ViewComponents::getComponent', ['component_name' => 'manuel_stok_ekleme_finisaj_emdersan']); ?>


                    <div class="row g-3 align-center mb-4 mt-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="buy_unit_price">Alış Birim Fiyat <small>(<b>KDV
                                            Hariç</b>)</small></label>
                                <span class="form-note d-none d-md-block">Ürünün KDV HARİÇ alış fiyatı</span>
                            </div>
                        </div>
                        <div class="col-12 mt-0 mt-md-2 d-flex">
                            <div class="col-md-4 col-12 pe-md-2">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control form-control-xl "
                                            id="buy_unit_price"
                                            value="<?= number_format($stock_item['buy_unit_price'], 4, ',', '') ?>"
                                            placeholder="15,8700" name="buy_unit_price"
                                            onkeypress="return SadeceRakam(event,[',']);">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 pe-md-2">
                                <div class="form-group">
                                    <div class="form-control-wrap ">
                                        <div class="form-control-select">
                                            <select required="" class="form-control select2 form-control-xl"
                                                name="buy_money_unit_id" id="buy_money_unit_id">
                                                <option value="" disabled>Lütfen Seçiniz</option>
                                                <?php
                                                foreach ($money_unit_items as $money_unit_item) { ?>
                                                    <option value="<?= $money_unit_item['money_unit_id'] ?>" <?php if ($money_unit_item['money_unit_id'] == $stock_item['buy_money_unit_id']) {
                                                          echo 'selected';
                                                      } ?>>
                                                        <?= $money_unit_item['money_code'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <input type="hidden" name="" id="buy_money_unit_id"
                                                value="<?= $stock_item['buy_money_unit_id'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <div class="form-control-wrap"><input type="text"
                                            class="form-control form-control-xl d-none" id="currency_amount" value=""
                                            placeholder="Döviz Kuru" name="currency_amount"
                                            onkeypress="return SadeceRakam(event,[',']);">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="totalPriceArea" class="d-none">
                            <p>Toplam Fiyat: <span id="totalPrice"></span> <span id="dvz"></span> </p>
                        </div>
                        <div id="totalPriceAreaTRY" class="d-none mt-0">
                            <p>Toplam Fiyat: <span id="totalPriceTRY"></span> <span id="dvz">TRY</span> </p>
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
                    <div class="col-md-8 text-end p-0" id="base_btn">
                        <button type="button" id="stokBarkodOlustur" class="btn btn-lg btn-primary ">KAYDET ve BARKOD
                            YAZDIR</button>
                    </div>
                    <div class="col-md-8 text-end p-0 d-none" id="btn_waiting">
                        <button class="btn btn-lg btn-primary" type="button" disabled=""><span
                                class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span><span>İşleminiz gerçekleştiriliyor...</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->section('script') ?>
<script>
    $(document).ready(function () {

        function calculateTotal() {
    let total = 0;
    $('.calcStockTotal').each(function() {
        let val = $(this).val().replace(',', '.'); // Virgülü noktaya çevir
        if (!isNaN(parseFloat(val))) {
            total += parseFloat(val);
        }
    });
    $('#total_quantity').val(total.toFixed(2).replace('.', ',')); // Noktayı tekrar virgüle çevir
}



calculateTotal();

    // Tüm calcStockTotal inputlarına event listener ekle
    $(document).on('input', '.calcStockTotal', function() {
        calculateTotal();
    });

    // Yeni satır eklediğinizde toplamı hesaplamak için
    $(document).on('click', '.miktar_satir_ekle', function() {
        // Yeni satır ekleme kodunuz burada olacak
        // ...

        // Yeni input elemente 'calcStockTotal' sınıfı eklenmiş olduğundan emin olun
        calculateTotal();
    });

    // Satır sildiğinizde toplamı hesaplamak için
    $(document).on('click', '.miktar_satir_sil', function() {
        $(this).closest('.row').remove();
        calculateTotal();
    });





        $(document).on("click", ".miktar_satir_ekle", function () {
            var t = parseInt($("#miktar_str_s").val());
            t = t + 1;
            console.log("satir ekleden sonra toplam satir: ",t);

            var a = $("#miktarSatirOrnek").clone().prop("id", "miktarSatir_" + t);


            a.find("#stock_quantity_").attr("id", "stock_quantity_" + t);
            a.find("#stock_quantity_").attr("name", "stock_quantity_" + t);


            a.find("#miktar_satir_ekle").attr("miktar_satir", t);
            a.find("#miktar_satir_sil").attr("miktar_satir", t);

            $("#miktarBilgileriBlocks").append(a);
            $("#miktarSatir_" + t).removeClass("d-none");
            $("#miktar_str_s").val(t);
        });

        $(document).on("click", ".miktar_satir_sil", function () {
            var t = parseInt($("#miktar_str_s").val());
            // t = t - 1;

            console.log("satir silden sonra toplam satir: ",t);

            var a = parseInt($(this).attr("miktar_satir"));
            if (a > 0) {
                $("#miktar_str_s").val(t);
                $("#miktarSatir_" + $(this).attr("miktar_satir")).remove()
            }
        });

        if ($('#buy_money_unit_id').val() != 3) $('#currency_amount').removeClass('d-none');

        buy_money_unit_id = $('#buy_money_unit_id').find(":selected").text();
        $('#dvz').html(buy_money_unit_id);

        //tedarikçi değiştiğinde
        $(document).on("change", "#supplier_id", function () {
            if ($('#buy_money_unit_id').val() != 3)
                $('#currency_amount').removeClass('d-none');
            else
                $('#currency_amount').addClass('d-none');
        });

        //para birimi değiştiğinde
        $(document).on("change", "#buy_money_unit_id", function () {
            buy_money_unit_id = $('#buy_money_unit_id').find(":selected").text();
            $('#dvz').html(buy_money_unit_id);

            if ($('#buy_money_unit_id').val() != 3) {
                $('#currency_amount').removeClass('d-none');
                $('#totalPriceAreaTRY').removeClass('d-none');
            } else {
                $('#currency_amount').addClass('d-none');
                $('#totalPriceAreaTRY').addClass('d-none');
            }
        });

        //miktar değiştiğinde
        // $(document).on("keyup", ".calcStockTotal", function () {
        //     let money_unit_id = $('#buy_money_unit_id').val();

        //     if ($("#stock_quantity").val() == '')
        //         var stock_quantity = 0;
        //     else
        //         var stock_quantity = $("#stock_quantity").val().replace(".", "").replace(",", ".");

        //     if ($("#buy_unit_price").val() == '')
        //         var buy_unit_price = 0;
        //     else
        //         var buy_unit_price = $("#buy_unit_price").val().replace(".", "").replace(",", ".");

        //     let totalPrice = stock_quantity * buy_unit_price;

        //     if (totalPrice >= 0 && money_unit_id == 3) {
        //         $('#totalPriceArea').removeClass('d-none')
        //         $('#totalPrice').html(new Intl.NumberFormat('tr-TR').format(totalPrice));
        //     } else if (totalPrice >= 0 && money_unit_id != 3) {
        //         $('#totalPriceArea').removeClass('d-none')
        //         $('#totalPrice').html(new Intl.NumberFormat('tr-TR').format(totalPrice));
        //         $('#totalPriceAreaTRY').removeClass('d-none')
        //         $('#totalPriceTRY').html(new Intl.NumberFormat('tr-TR').format(0));
        //     } else {
        //         $('#totalPriceArea').addClass('d-none')
        //     }
        // });

        // unit price 0 ise temizle
        $(document).on("click", ".calcStockTotal", function () {
            var deger = $("#buy_unit_price").val();
            var temizDeger = parseFloat(deger.replace(/,/g, ''));

            if (temizDeger === 0)
                $("#buy_unit_price").val('');
        });

        //döviz kuru değiştiğinde
        $(document).on("keyup", "#currency_amount", function () {

            if ($("#stock_quantity").val() == "")
                var stock_quantity = 0;
            else
                var stock_quantity = $("#stock_quantity").val().replace(".", "").replace(",", ".");

            if ($("#buy_unit_price").val() == "")
                var buy_unit_price = 0;
            else
                var buy_unit_price = $("#buy_unit_price").val().replace(".", "").replace(",", ".");

            let totalPrice = stock_quantity * buy_unit_price;
            let currencyAmount = $("#currency_amount").val().replace(".", "").replace(",", ".");

            let grandTotal = totalPrice * currencyAmount;

            $('#totalPriceTRY').html(new Intl.NumberFormat('tr-TR').format(grandTotal));
        });
    })
</script>
<?= $this->endSection() ?>