<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Sevkiyat Emir Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Sevkiyat Emir Detay | <?= $shipment_item['shipment_number'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>
<?= $this->section('main') ?>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card card-stretch">
                    <form onsubmit="return false;" id="approve_shipment_form" method="POST">
                        <div class="card-inner-group">
                            <div class="card-inner">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group">
                                            <label class="form-label" for="site-name">Çıkış Deposu</label>
                                            <span class="form-note d-none d-md-block">Sevkiyatın çıkış yaptığı depo.</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" id="from_warehouse"
                                                        class="form-control form-control-xl"
                                                        value="<?= $shipment_item['shipment_status'] == 'pending' ? $shipment_item['from_warehouse_title'] : $shipment_item['to_warehouse_title'] ?>"
                                                        placeholder="" disabled="">
                                                    <input type="hidden" id="from_warehouse" name="from_warehouse"
                                                        class="form-control form-control-xl">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="row g-3">
                                    <div class="col-md-12 col-lg-12 col-xxl-12  col-12">
                                        <div class="col-lg-12 col-xxl-12  pb-2">
                                            <div class="form-group"><label class="form-label"
                                                    for="site-name">Sevkler</label>
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="invoice-bills">
                                            <div class="table-responsive">

                                                <table class="table table-striped" id="satisYapilacakUrunler">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-100 d-none">Barkod</th>
                                                            <th>Ürün Adı</th>
                                                            <th class="w-150px text-right" style="padding-right:50px; text-align:right ">Miktar</th>
                                                            <th class="w-100px text-right" style="padding-right:50px; text-align:right ">B.Fiyat</th>
                                                            <th class="w-100px text-right" style="padding-right:50px;">T.Fiyat</th>
                                                            <!-- <th class="text-center" style="width: 200px;"></th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="shipment_order_items">
                                                    <?php foreach($shipment_sale_order_items as $item){ ?>
                                                        <tr id="shipment_order_item_<?= $item['stock_code'] ?>">
                                                            <td>
                                                                <?= $item['stock_barcode']?> | <b class="fw-bold"><?= $item['stock_title']?></b>
                                                                <br>
                                                                <!-- <span class="form-note"><?= $item['stock_barcode']?></span> -->
                                                            </td>
                                                            <td><?= $item['sale_amount']?></td>
                                                            <td><?= $item['sale_unit_price']?></td>

                                                            <td class="fw-bold">
                                                                <a class=""><?= number_format($item['total_price'], 4, ',', '.'); ?></a>
                                                            </td>

                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class=" text-end" colspan="3">TOPLAM</td>
                                                            <td class=" text-end">
                                                                <b id="total_yazi"><?= number_format($shipment_item['ordered_stock_amount'], 4, ',', '.'); ?></b>
                                                                <b id="total_yazi_para_birimi"></b>
                                                                <input type="hidden" name="total_stock_amount" id="total_stock_amount" value="0">
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
                                                ilgili
                                                notunuz varsa yazınız.</span></div>
                                    </div>
                                    <div class="col-lg-9 col-xxl-9 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <textarea disabled="" class="form-control form-control-xl no-resize"
                                                    name="shipment_note"
                                                    id="shipment_note"><?= $shipment_item['shipment_note'] ?></textarea>
                                            </div>
                                        </div>
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
                                        <button type="button" id="checkBeforeDeparture"
                                            class="btn btn-lg btn-primary">Sevkiyatı Onayla</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                    </form>
                </div>
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<button type="button" id="trigger_approve_shipment_modal" class="btn btn-success d-none" data-bs-toggle="modal"
    data-bs-target="#approve_shipment_modal">Approve</button>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" id="approve_shipment_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent"></em>
                    <h4 class="nk-modal-title">Sevkiyatı Onaylıyor Musunuz!</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text">Sevkiyatta eksik ve fazla ürünler bulunmaktadır. Sevkiyatı onaylıyor
                            musunuz?</div><br>
                        <ul id="checked_shipment_items"></ul>
                    </div>
                    <div class="nk-modal-action">
                        <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger" id="approveDeparture"
                            data-bs-dismiss="modal">Evet</a>
                    </div>
                </div>
            </div>
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
                'modal_buttons' => '<a href="'.route_to('tportal.shipment.create').'" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Sevkiyat Emri Oluştur</a>
                                    <a href="'.route_to('tportal.shipment.list', 'all').'" class="btn btn-l btn-dim btn-outline-dark btn-block">Sevkiyat Listesi</a>'
            ],
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$('.urun_cikart').hide();
$('#btn_cikart_aktif').click(function(e) {
    e.preventDefault();
    $('.urun_cikart').show();
});
$('#btn_cikart_pasif').click(function(e) {
    e.preventDefault();
    $('.urun_cikart').hide();
});

$('#sevkiyatOnay').on('click', function(e) {
    e.preventDefault();
    var formData = $('#approve_shipment_form').serializeArray();
    shipment_items = [];
    $('.shipment_item_barcode').each(function(index) {
        shipment_item = [];
        shipment_item.push({
            'stock_barcode_id': $(this).attr('data-stock-barcode-id'),
            'during_shipment_amount': $(this).attr('data-stock-amount'),
        });
        shipment_items.push({
            shipment_items: shipment_item,
        });
    })
    console.log(shipment_items);
    console.log(formData)
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.shipment.approve') ?>',
        dataType: 'json',
        data: {
            formData: formData,
            shipment_items: JSON.stringify(shipment_items)
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $('#shipmentDetail').attr('href',
                    '<?= route_to('tportal.shipment.detail.null')?>/' +
                    response['new_shipment_id'])
                $("#trigger_shipment_ok_button").trigger("click");
            } else {
                console.log(response)
                swetAlert("Hatalı İşlem", response['message'], "err");
            }
        }
    })
});
$('#add_barcode_number').keypress(function(event) {
    // 13 'ENTER' tuşunun değeridir
    if (event.which === 13) {
        barcode_number = $('#add_barcode_number').val()
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.shipment.shipment_item.add') ?>',
            dataType: 'json',
            data: {
                barcode_number: barcode_number,
                shipment_id: <?= $shipment_item['shipment_id'] ?>
            },
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    stock_title = response['stock_title']
                    stock_code = response['stock_code']
                    stock_amount = response['stock_amount']
                    remaining_amount = response['remaining_amount']
                    unit_value = response['unit_value']

                    if ($('#shipment_item_' + stock_code).length) {
                        remaining_amount_el = $("#shipment_item_" + stock_code).find(
                            "[data-col='remaining_amount']");
                        stock_amount_el = $("#shipment_item_" + stock_code).find(
                            "[data-col='stock_amount']");

                        temp_stock_amount = stock_amount_el.attr('data-val')

                        remaining_amount_el.attr('data-val', remaining_amount);
                        remaining_amount_el.html(replace_for_form_input(parseFloat(remaining_amount)
                            .toFixed(4)) + ' ' + unit_value);

                        new_stock_amount = parseFloat(temp_stock_amount) + parseFloat(stock_amount)
                        stock_amount_el.attr('data-val', parseFloat(new_stock_amount).toFixed(4))
                        stock_amount_el.html(replace_for_form_input(parseFloat(new_stock_amount)
                            .toFixed(4)) + ' ' + unit_value)
                    } else {
                        new_row = jQuery('<tr>', {
                            id: 'shipment_item_' + stock_code,
                            class: 'shipment_item',
                            'data-remaining-amount': remaining_amount,
                            'data-stock-amount': stock_amount,
                        }).appendTo('#shipment_items');

                        jQuery('<td>', {
                            html: stock_code + ' | <b>' + stock_title + '</b>',
                        }).appendTo('#shipment_item_' + stock_code);
                        jQuery('<td>', {
                            html: replace_for_form_input(parseFloat(remaining_amount)
                                .toFixed(4)) + ' ' + unit_value,
                            'data-col': 'remaining_amount',
                            'data-val': remaining_amount
                        }).appendTo('#shipment_item_' + stock_code);
                        jQuery('<td>', {
                            html: replace_for_form_input(parseFloat(stock_amount)
                                .toFixed(4)) + ' ' + unit_value,
                            'data-col': 'stock_amount',
                            'data-val': stock_amount
                        }).appendTo('#shipment_item_' + stock_code);
                    }

                    total_stock_amount = $('#total_stock_amount').val()
                    total_stock_amount = parseFloat(stock_amount) + parseFloat(
                        total_stock_amount);
                    $('#total_stock_amount').val(parseFloat(total_stock_amount).toFixed(4));
                    $('#total_yazi').empty().html(replace_for_form_input(parseFloat(
                        total_stock_amount).toFixed(4)))

                    if (response['alert_message'] != null && response['alert_message'] != '') {
                        swetAlert("Dikkat", response['alert_message'], "err");
                    } else {
                        swetAlert("İşlem Başarılı", response['message'], "ok");
                    }
                } else {
                    swetAlert("Hatalı Barkod Numarası", response['message'], "err");
                }
            }
        })
    }
});

$('#remove_barcode_number').keypress(function(event) {
    // 13 'ENTER' tuşunun değeridir
    if (event.which === 13) {
        barcode_number = $('#remove_barcode_number').val()
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.shipment.shipment_item.remove') ?>',
            dataType: 'json',
            data: {
                barcode_number: barcode_number,
                shipment_id: <?= $shipment_item['shipment_id'] ?>
            },
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    stock_code = response['stock_code']
                    unit_value = response['unit_value']
                    stock_amount = response['stock_amount']
                    remaining_amount = response['remaining_amount']
                    removeElement = response['removeElement']

                    if (removeElement) {
                        $('#shipment_item_' + stock_code).remove();
                    } else {
                        remaining_amount_el = $("#shipment_item_" + stock_code).find(
                            "[data-col='remaining_amount']");
                        stock_amount_el = $("#shipment_item_" + stock_code).find(
                            "[data-col='stock_amount']");

                        temp_stock_amount = stock_amount_el.attr('data-val')

                        remaining_amount_el.attr('data-val', remaining_amount);
                        remaining_amount_el.html(replace_for_form_input(parseFloat(remaining_amount)
                            .toFixed(4)) + ' ' + unit_value);

                        new_stock_amount = parseFloat(temp_stock_amount) - parseFloat(stock_amount)
                        stock_amount_el.attr('data-val', parseFloat(new_stock_amount).toFixed(4))
                        stock_amount_el.html(replace_for_form_input(parseFloat(new_stock_amount)
                            .toFixed(4)) + ' ' + unit_value)
                    }

                    total_stock_amount = $('#total_stock_amount').val()
                    total_stock_amount = parseFloat(total_stock_amount) - parseFloat(
                        stock_amount);
                    $('#total_stock_amount').val(parseFloat(total_stock_amount).toFixed(4));
                    $('#total_yazi').empty().html(replace_for_form_input(parseFloat(
                        total_stock_amount).toFixed(4)))

                    swetAlert("İşlem Başarılı", response['message'], "ok");
                } else {
                    swetAlert("Hatalı Barkod Numarası", response['message'], "err");
                }
            }
        })
    }
});

$('#checkBeforeDeparture').on('click', function() {
    $('#checked_shipment_items').empty();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.shipment.check.before_departure') ?>',
        dataType: 'json',
        data: {
            shipment_id: <?= $shipment_item['shipment_id'] ?>
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                approveDeparture();
            } else {
                $.each(response['shipment_order_items'], function(key, shipment_order_item) {
                    if (shipment_order_item.shipment_order_status == 'more') {
                        text = 'Fazla'
                        value = parseFloat(shipment_order_item.quantity_shipped) - parseFloat(shipment_order_item.shipment_order_quantity)
                    } else {
                        text = 'Eksik'
                        value = parseFloat(shipment_order_item.shipment_order_quantity) - parseFloat(shipment_order_item.quantity_shipped)
                    }
                    value = replace_for_form_input(parseFloat(value).toFixed(4))
                    jQuery('<li>', {
                        id: 'checked_shipment_item_' + shipment_order_item
                            .stock_code,
                        class: 'checked_shipment_item',
                        'data-remaining-amount': shipment_order_item
                            .remaining_amount,
                        'data-stock-amount': shipment_order_item.stock_amount,
                        html: '<b>' + shipment_order_item.stock_code + '</b> | ' +
                            shipment_order_item.stock_title + ' | ' + value + ' ' + text
                    }).appendTo('#checked_shipment_items');
                });
                $('#approve_shipment_modal').modal('toggle');
            }
        }
    })
})

$('#approveDeparture').on('click', function() {
    approveDeparture();
})

function approveDeparture(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.shipment.approve.departure') ?>',
        dataType: 'json',
        data: {
            shipment_id: <?= $shipment_item['shipment_id'] ?>
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#trigger_shipment_ok_button").trigger("click");
            } else {
                swetAlert("İşlem Başarısız", response['message'], "err");
            }
        }
    })
}
</script>
<?= $this->endSection() ?>