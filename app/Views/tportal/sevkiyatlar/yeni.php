<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Yeni Sevk Emri <?= $this->endSection() ?>
<?= $this->section('title') ?> Yeni Sevk Emri | <?= session()->get('user_item')['firma_adi'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>



<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content  d-xl-none">
                        <h3 class="nk-block-title page-title">Yeni Sevk Emri</h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">

                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="card card-stretch">
                    <form onsubmit="return false;" id="create_shipment_order_form" method="POST">
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
                                            <select class="form-select  init-select2" data-search="on" data-ui="xl"
                                                name="from_warehouse" id="from_warehouse">
                                                <option value="0" disabled selected>Lütfen Seçiniz</option>
                                                <?php foreach($warehouse_items as $warehouse_item){ ?>
                                                <option value="<?= $warehouse_item['warehouse_id'] ?>">
                                                    <?= $warehouse_item['warehouse_title'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-3 ">
                                            <div class="form-group">
                                                <label class="form-label" for="to_warehouse">Giriş Deposu</label>
                                                <span class="form-note d-none d-md-block">Ürün sevk edilecek
                                                    depo.</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3  mt-0 mt-md-2">
                                            <select class="form-select  init-select2" data-search="on" data-ui="xl"
                                                name="to_warehouse" id="to_warehouse">
                                                <option value="0" disabled selected>Lütfen Seçiniz</option>
                                                <?php foreach($warehouse_items as $warehouse_item){ ?>
                                                <option value="<?= $warehouse_item['warehouse_id'] ?>">
                                                    <?= $warehouse_item['warehouse_title'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="gy-3">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-3 col-xxl-3 ">
                                            <div class="form-group"><label class="form-label"
                                                    for="is_sample">Numune</label><span
                                                    class="form-note d-none d-md-block">Sipariş numune içinse
                                                    işaretleyiniz.</span></div>
                                        </div>
                                        <div class="col-lg-9 col-xxl-9 mt-0 mt-md-2">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="is_sample"
                                                            class="custom-control-input" id="is_sample">
                                                        <label class="custom-control-label"
                                                            for="is_sample">İşaretlenirse siparişte ürün başına 10 m.
                                                            den fazla girilemez.</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 pt-3 align-center">
                                        <div class="col-lg-3 col-xxl-3 ">
                                            <div class="form-group">
                                                <label class="form-label" for="stock_id">Ürün</label>
                                                <span class="form-note d-none d-md-block">Sipariş verilen ürünü
                                                    seçin.</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="input-group flex-nowrap">
                                                        <select class="form-select  init-select2" data-search="on"
                                                            data-ui="xl" name="stock_id" id="stock_id">
                                                            <option value="0" disabled selected>Sevk emrine başlamak
                                                                için depo seçiniz.
                                                            </option>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <button id="getStockFromDatabase"
                                                                class="btn btn-outline-primary btn-dim w-min-110px d-block">Ürün
                                                                Seç</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 pt-3 align-center">
                                        <div class="col-lg-3 col-xxl-3 ">
                                            <div class="form-group"><label class="form-label"
                                                    for="shipment_order_note">Ürün
                                                    Not</label><span class="form-note d-none d-md-block">Ürüne ait
                                                    sipariş notu</span></div>
                                        </div>
                                        <div class="col-lg-9 col-xxl-9 mt-0 mt-md-2">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" name="shipment_order_note"
                                                        id="shipment_order_note" class="form-control form-control-xl"
                                                        placeholder="Varsa ürüne ait sipariş notunuz">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 pt-3 align-center">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label"
                                                for="remaining_quantity">Depodaki Miktar</label><span
                                                class="form-note d-none d-md-block">Depodaki ürün miktarı.</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xxl-2 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" id="remaining_quantity"
                                                        class="form-control form-control-xl text-right" placeholder=""
                                                        disabled>
                                                    <div class="input-group-append">
                                                        <!-- İlerleyen zamanlarda bu aktif olucak -->
                                                        <span class="input-group-text"
                                                            id="shipment_order_unit">m.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 pt-3 align-center">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label"
                                                for="shipment_order_quantity">Miktar</label><span
                                                class="form-note d-none d-md-block">Siparişteki ürün miktarı.</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xxl-2 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="shipment_order_quantity"
                                                        id="shipment_order_quantity"
                                                        class="form-control form-control-xl text-right"
                                                        placeholder="0,0000"
                                                        onkeypress="return SadeceRakam(event,[',']);">
                                                    <div class="input-group-append">
                                                        <!-- İlerleyen zamanlarda bu aktif olucak -->
                                                        <span class="input-group-text"
                                                            id="shipment_order_unit">m.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xxl-2 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <button type="button" id="add_shipment_order_item"
                                                class="btn btn-xl btn-primary">Ekle</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="gy-3">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label" for="site-name">Sevk
                                                Emri Verilecek Ürünler</label><span
                                                class="form-note d-none d-md-block">Listedeki
                                                ürünler sevk edilecektir.</span></div>
                                    </div>
                                    <div class="col-md-9 col-lg-9 col-xxl-9  col-12 pt-4">
                                        <div class="invoice-bills">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-100 d-none">Barkod</th>
                                                            <th>Ürün Adı</th>
                                                            <th class="w-100" style="padding-right:30px;">Miktar</th>
                                                            <!-- <th class="text-center" style="width: 200px;"></th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="shipment_order_items">
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="w-100 text-end" colspan="1">TOPLAM</td>
                                                            <td class="w-100 text-end">
                                                                <b id="total_yazi">0</b>
                                                                <input type="hidden" name="total_stock_amount"
                                                                    id="total_stock_amount" value="0">
                                                            </td>
                                                            <!-- <td colspan="1"></td> -->
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center pt-5">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label" for="shipment_note">Sevkiyat
                                                Notu</label><span class="form-note d-none d-md-block">Sevkiyat ile
                                                ilgili notunuz varsa yazınız.</span></div>
                                    </div>
                                    <div class="col-lg-9 col-xxl-9 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <textarea class="form-control form-control-xl no-resize"
                                                    name="shipment_note" id="shipment_note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                        <button id="yeniSevkiyat" class="btn btn-lg btn-primary"
                                            type="button">Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
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
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent"
                        style="font-size: 70px;"></em>
                    <h4 class="nk-modal-title">Bu Depoyu Değiştirmek İstediğinize<br>Emin misiniz?</h4>
                    <div class="nk-modal-action mb-5">
                        <a href="#" class="btn btn-lg btn-mw btn-light" id="not_confirm_change_warehouse"
                            data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger" id="confirm_change_warehouse"
                            data-bs-dismiss="modal">Evet</a>
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

<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'shipment',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="#" id="shipmentDetail" class="btn btn-info btn-block mb-2">Bu Sevkiyatın Detayına Git</a>
                                    <a href="#" onclick="location.reload()" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Sevkiyat Emri Oluştur</a>
                                    <a href="'.route_to('tportal.shipment.list', 'all').'" class="btn btn-l btn-dim btn-outline-dark btn-block">Sevkiyat Listesi</a>'
            ],
        ],
    ]
); ?>


<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
var selected_from_warehouse = 0;

$('#from_warehouse').on('change', function() {
    if (selected_from_warehouse == this.value || selected_from_warehouse == 0) {
        selected_from_warehouse = this.value;
        getStockItemsByWarehouse(this.value)
        return;
    } else {
        $('#confirm_change_warehouse_modal').modal('toggle');
        temp_value = this.value
    }
});

$('#confirm_change_warehouse').on('click', function() {
    selected_from_warehouse = temp_value
    $('#confirm_change_warehouse_modal').modal('toggle');
    $('#shipment_order_items').empty();
    $('#total_amount').val(0)
    $('#total_yazi').html(0)

    getStockItemsByWarehouse(temp_value)
})
$('#not_confirm_change_warehouse').on('click', function() {
    $("#from_warehouse").val(selected_from_warehouse);
    $('#from_warehouse').trigger('change');
})

function getStockItemsByWarehouse(warehouse_id) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.shipment.stock.list') ?>',
        dataType: 'json',
        data: {
            warehouse_id: warehouse_id,
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $('#stock_id').empty();
                jQuery('<option value="0" disabled selected>Sevk edilecek ürünü seçiniz.</option>')
                    .appendTo('#stock_id')
                response['stock_items'].forEach(function(stock_item) {
                    jQuery('<option>', {
                        value: stock_item.stock_id,
                        html: stock_item.stock_code + ' | ' + stock_item.stock_title,
                        'data-remaining-amount': stock_item.total_remaining_amount,
                        'data-unit-id': stock_item.buy_unit_id
                    }).appendTo('#stock_id');
                })
                swetAlert("İşlem Başarılı", response['message'], "ok");
            } else {
                swetAlert("Hatalı İşlem", response['message'], "err");
            }
        }
    })
}

$('#stock_id').on('change', function() {
    if (this.value == 0 || this.value == undefined || this.value == '') {
        return;
    }

    remaining_amount = $(this).find(':selected').attr('data-remaining-amount')
    $('#remaining_quantity').val(replace_for_form_input(parseFloat(remaining_amount).toFixed(4)))
})

$('#is_sample').on('change', function(){
    if ($('#is_sample').is(":checked")){
        shipment_order_quantity = $('#shipment_order_quantity').val()
        if (String(shipment_order_quantity).includes(",")) {
            shipment_order_quantity = shipment_order_quantity.replace(',', '.')
            shipment_order_quantity = parseFloat(shipment_order_quantity).toFixed(4)
        } else {
            shipment_order_quantity = parseFloat(shipment_order_quantity).toFixed(4)
        }

        if(shipment_order_quantity > 10){
            swetAlert("Dikkat", "Numune ürünlerde sevkiyat miktarı 10 birimi geçemez.", "err");
            $('#shipment_order_quantity').val('10,0000')
        }
    }
});

$('#shipment_order_quantity').on('blur', function() {
    // Depo ve ürün id seçilmiş mi diye bakıyoruz
    // Girilen değer 0 mı diye bakıyoruz
    if (parseFloat($(this).val()) != 0 &&
        ($('#stock_id').find(':selected').val() == 0 ||
            $('#stock_id').find(':selected').val() == '' ||
            $('#stock_id').find(':selected').val() == undefined)) {
        $('#shipment_order_quantity').val('0,0000');
        swetAlert("Hatalı İşlem", "Lütfen miktar girmeden önce depo ve stok seçiniz", "err");
        return;
    }
    // Numune olarak işaretlenmiş mi diye bakıyoruz
    is_sample = $('#is_sample').is(":checked");
    if ($('#shipment_order_quantity').val() != null && $('#shipment_order_quantity').val() != '') {
        shipment_order_quantity = $('#shipment_order_quantity').val()
        if (String(shipment_order_quantity).includes(",")) {
            shipment_order_quantity = shipment_order_quantity.replace(',', '.')
            shipment_order_quantity = parseFloat(shipment_order_quantity).toFixed(4)
        } else {
            shipment_order_quantity = parseFloat(shipment_order_quantity).toFixed(4)
        }
        remaining_amount = $('#remaining_quantity').val();
        if (String(remaining_amount).includes(",")) {
            remaining_amount = remaining_amount.replace(',', '.')
            remaining_amount = parseFloat(remaining_amount).toFixed(4)
        } else {
            remaining_amount = parseFloat(remaining_amount).toFixed(4)
        }

        if (is_sample && shipment_order_quantity > 10) {
            $('#shipment_order_quantity').val('10,0000')
            swetAlert("Hatalı İşlem", "Numune olarak işaretlenen ürün 10m'yi geçemez.", "err");
            return;
        }

        if (parseFloat(shipment_order_quantity) > parseFloat(remaining_amount)) {
            $('#shipment_order_quantity').val('0,0000')
            swetAlert("Hatalı İşlem", "Sevkiyatı yapılacak miktar depodaki miktardan fazla olamaz.", "err");
            return;
        }

        shipment_order_quantity = replace_for_form_input(shipment_order_quantity)

        $('#shipment_order_quantity').val(shipment_order_quantity)
    } else {
        $('#shipment_order_quantity').val('0,0000')
    }
})

$('#add_shipment_order_item').on('click', function() {
    if (parseFloat($('#shipment_order_quantity').val()) != 0 &&
        ($('#stock_id').find(':selected').val() == 0 ||
            $('#stock_id').find(':selected').val() == '' ||
            $('#stock_id').find(':selected').val() == undefined)) {
        $('#shipment_order_quantity').val('0,0000');
        swetAlert("Hatalı İşlem", "Lütfen sevkiyat emri eklemeden önce depo ve stok seçiniz", "err");
        return;
    }
    shipment_order_note = $('#shipment_order_note').val();
    shipment_order_quantity = $('#shipment_order_quantity').val();
    is_sample = $('#is_sample').is(":checked");
    remaining_amount = $('#remaining_amount').val();
    stock_id = $('#stock_id').find(':selected').val();
    stock_title = $('#stock_id').find(':selected').html();
    unit_id = $('#stock_id').find(':selected').attr('data-unit-id');
    if ($('#order_item_' + stock_id).length) {
        swetAlert("Hatalı İşlem", "Aynı stok sevkiyata birden fazla kez eklenemez", "err");
        return;
    }else if(parseFloat(shipment_order_quantity.replace(',', '.')) == 0 || shipment_order_quantity == '' || shipment_order_quantity == undefined){
        swetAlert("Hatalı İşlem", "Lütfen sevkiyat emrine geçerli bir miktar ekleyiniz", "err");
        return;
    }

    total_stock_amount = $('#total_stock_amount').val()
    total_stock_amount = parseFloat(shipment_order_quantity.replace(',', '.')) + parseFloat(total_stock_amount);
    $('#total_stock_amount').val(parseFloat(total_stock_amount).toFixed(4));
    $('#total_yazi').empty().html(replace_for_form_input(parseFloat(total_stock_amount).toFixed(4)))

    new_row = jQuery('<tr>', {
        id: 'order_item_' + stock_id,
        class: 'shipment_order_item',
        'data-remaining-amount': remaining_amount,
        'data-shipment-order-quantity': shipment_order_quantity,
        'data-shipment-order-note': shipment_order_note,
        'data-stock-id': stock_id,
        'data-unit-id': unit_id,
        'data-is-sample': is_sample
    }).appendTo('#shipment_order_items');

    jQuery('<td>', {
        html: stock_title,
        class: 'w-100',
        'data-stock-title': stock_title,
    }).appendTo('#order_item_' + stock_id);
    jQuery('<td>', {
        html: shipment_order_note,
        class: 'd-none',
        'data-shipment-order-note': shipment_order_note,
    }).appendTo('#order_item_' + stock_id);
    jQuery('<td>', {
        html: shipment_order_quantity,
        'data-shipment-order-quantity': shipment_order_quantity,
    }).appendTo('#order_item_' + stock_id);

    $("#stock_id").val(0);
    $('#stock_id').trigger('change');
    $('#shipment_order_note').val('');
    $('#shipment_order_quantity').val('');
    $('#remaining_amount').val('');
});

$('#yeniSevkiyat').on('click', function(e) {
    e.preventDefault();
    if ($('#to_warehouse').find(":selected").val() == 0 ||
        $('#from_warehouse').find(":selected").val() == 0) {
        swetAlert("Eksik Birşeyler Var", "Lütfen Giriş ve Çıkış Depolarını Seçiniz ", "err");
        return;
    } else if ($('#to_warehouse').find(":selected").val() == $('#from_warehouse').find(":selected").val()) {
        swetAlert("Hatalı Depo Seçimi", "Giriş ve Çıkış Depoları Aynı Olamaz", "err");
        return;
    } else {
        var formData = $('#create_shipment_order_form').serializeArray();
        shipment_order_items = [];
        $('.shipment_order_item').each(function(index) {
            shipment_order_items.push({
                'stock_id': $(this).attr('data-stock-id'),
                'shipment_order_quantity': $(this).attr('data-shipment-order-quantity'),
                'shipment_order_note': $(this).attr('data-shipment-order-note'),
                'unit_id': $(this).attr('data-unit-id'),
                'is_sample': $(this).attr('data-is-sample')
            });
        })
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.shipment.create') ?>',
            dataType: 'json',
            data: {
                formData: formData,
                shipment_order_items: JSON.stringify(shipment_order_items)
            },
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    $('#shipmentDetail').attr('href',
                        '<?= route_to('tportal.shipment.detail.null')?>/' +
                        response['new_shipment_number'])
                    $("#trigger_shipment_ok_button").trigger("click");
                } else {
                    console.log(response)
                    swetAlert("Hatalı İşlem", response['message'], "err");
                }
            }
        })
    }
});
</script>

<?= $this->endSection() ?>