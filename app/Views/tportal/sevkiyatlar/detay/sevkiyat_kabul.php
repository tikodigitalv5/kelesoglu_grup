<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Sevkiyat Kabul Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Sevkiyat Kabul Detay | <?= $shipment_item['shipment_number'] ?> <?= $this->endSection() ?>
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
                                <div class="gy-3">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-3 col-xxl-3 ">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Çıkış Deposu</label>
                                                <span class="form-note d-none d-md-block">Sevkiyatın çıkış yaptığı depo.</span>
                                            </div>
                                        </div>
                                        <div class="col mt-0 mt-md-2">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="input-group">
                                                        <input type="text" id="to_warehouse" class="form-control form-control-xl" value="<?= $shipment_item['shipment_status'] == 'pending' ? $shipment_item['from_warehouse_title'] : $shipment_item['from_warehouse_title'] ?>" placeholder="" disabled="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-3 ">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Müşteri</label>
                                                <span class="form-note d-none d-md-block">Satış yapılan müşteri.</span>
                                            </div>
                                        </div>
                                        <div class="col mt-0 mt-md-2">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-xl" id="account" name="account" value="<?= $shipment_item['to_warehouse_title'] ?>" disabled placeholder="Müşteri seçmek için tıklayınız..">
                                                    <!-- <div class="input-group-append">
                                                        <button data-bs-toggle="modal" data-bs-target="#mdl_hesaplar" class="btn btn-lg btn-block btn-dim btn-outline-light">SEÇ</button>
                                                        <button class="btn btn-lg btn-block btn-dim btn-outline-light">EKLE</button>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-center">
                                        <div class="col-lg-3 ">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Sipariş Zamanı</label>
                                                <span class="form-note d-none d-md-block">Sipariş oluşturulan tarih ve saat bilgisi.</span>
                                            </div>
                                        </div>
                                        <div class="col mt-0 mt-md-2">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-xl" id="account" name="account" value="<?= date('d/m/Y H:i:s', strtotime($shipment_item['created_at'])) ?>" disabled>
                                                    <!-- <div class="input-group-append">
                                                        <button data-bs-toggle="modal" data-bs-target="#mdl_hesaplar" class="btn btn-lg btn-block btn-dim btn-outline-light">SEÇ</button>
                                                        <button class="btn btn-lg btn-block btn-dim btn-outline-light">EKLE</button>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-center">
                                        <div class="col-lg-3 ">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Sipariş Durumu</label>
                                                <span class="form-note d-none d-md-block"></span>
                                            </div>
                                        </div>
                                        <div class="col mt-0 mt-md-2">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-xl" id="account" name="account" value="<?php switch ($shipment_item['shipment_status']) {
                                                        case 'pending':
                                                           echo 'Yeni Sevk';
                                                            break;
                                                        case 'processing':
                                                           echo 'Sevkte';
                                                            break;
                                                        case 'successful':
                                                           echo 'Teslim Edildi';
                                                            break;
                                                        case 'failed':
                                                           echo 'İptal Edildi';
                                                            break;
                                                        default:
                                                            # code...
                                                            break;
                                                    } ?>" disabled placeholder="Müşteri seçmek için tıklayınız..">
                                                    <div class="input-group-append">
                                                        <button id="btnDeleteSaleOrder" class="btn btn-lg btn-block btn-dim btn-outline-danger" data-shipment-id="<?= $shipment_item['shipment_id'] ?>" >Siparişi İptal Et/Sil</button>
                                                        <!-- <button class="btn btn-lg btn-block btn-dim btn-outline-light">EKLE</button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="row g-3">
                                    <div class="col-md-12 col-lg-12 col-xxl-12 col-12">
                                        <div class="invoice-bills">
                                            <div class="table-responsive">

                                                <table class="table table-striped" id="satisYapilacakUrunler">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-100 d-none">Barkod</th>
                                                            <th>Ürün Adı</th>
                                                            <th class="w-100px text-right" style="padding-right:50px; text-align:right ">Miktar</th>
                                                            <th class="w-100px text-right" style="padding-right:50px; text-align:right ">B.Fiyat</th>
                                                            <th class="w-100px text-right" style="padding-right:50px;">T.Fiyat</th>
                                                            <!-- <th class="text-center" style="width: 200px;"></th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="shipment_order_items">
                                                        <?php foreach ($sale_order_items as $shipment_order_item) { ?>
                                                            <tr id="shipment_order_item_<?= $shipment_order_item['stock_code'] ?>">
                                                                <td>
                                                                    <?= convert_barcode_number_for_form($shipment_order_item['stock_barcode']) ?> | <b class="fw-bold"><?= $shipment_order_item['stock_title'] ?></b>
                                                                    <br>
                                                                </td>
                                                                <td><?= number_format($shipment_order_item['birim_adet'],2,',','.') ?> <?= $shipment_order_item['unit_title'] ?></td>
                                                                <td><?= number_format($shipment_order_item['birim_fiyat'], 2, ',','.')  ?> <?= $shipment_order_item['money_unit'] ?></td>

                                                                <td class="fw-bold">
                                                                    <a class=""><?= number_format($shipment_order_item['toplam_fiyat'], 2, ',', '.'); ?> <?= $shipment_order_item['money_unit'] ?></a>
                                                                </td>

                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class=" text-end" colspan="3">TOPLAM</td>
                                                            <td class=" text-end">
                                                                <b id="total_yazi"><?= number_format($shipment_item['ordered_stock_amount'], 2, ',', '.'); ?></b>
                                                                <b id="total_yazi_para_birimi"><?= $shipment_order_item['money_unit'] ?></b>
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
                                                <textarea disabled="" class="form-control form-control-xl no-resize" name="shipment_note" id="shipment_note"><?= $shipment_item['shipment_note'] ?></textarea>
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
                                        <a href="javascript:history.back()" class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Geri</span></a>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="form-group">
                                        <!-- <button type="button" id="checkBeforeArrival" class="btn btn-lg btn-primary">Sevkiyatı Tamamla</button> -->
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

<button type="button" id="trigger_approve_shipment_modal" class="btn btn-success d-none" data-bs-toggle="modal" data-bs-target="#approve_shipment_modal">Approve</button>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" id="approve_shipment_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent"></em>
                    <h4 class="nk-modal-title">Sevkiyatı Onaylıyor Musunuz!</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text">Sevkiyatta eksik ürünler bulunmaktadır. Sevkiyatı onaylıyor
                            musunuz?</div><br>
                        <ul id="checked_shipment_items"></ul>
                    </div>
                    <div class="nk-modal-action">
                        <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger" id="approveDeparture" data-bs-dismiss="modal">Evet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'shipment',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="' . route_to('tportal.shipment.create') . '" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Sevkiyat Emri Oluştur</a>
                                    <a href="' . route_to('tportal.shipment.list', 'all') . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Sevkiyat Listesi</a>'
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
                        '<?= route_to('tportal.shipment.detail.null') ?>/' +
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
                url: '<?= route_to('tportal.shipment.shipment_item.receive') ?>',
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

                        if ($('#accepted_shipment_item_' + stock_code).length) {
                            remaining_amount_el = $("#accepted_shipment_item_" + stock_code).find(
                                "[data-col='remaining_amount']");
                            stock_amount_el = $("#accepted_shipment_item_" + stock_code).find(
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
                                id: 'accepted_shipment_item_' + stock_code,
                                class: 'accepted_shipment_item',
                                'data-remaining-amount': remaining_amount,
                                'data-stock-amount': stock_amount,
                            }).appendTo('#accepted_shipment_items');

                            jQuery('<td>', {
                                html: stock_code + ' | <b>' + stock_title + '</b>',
                            }).appendTo('#accepted_shipment_item_' + stock_code);
                            jQuery('<td>', {
                                html: replace_for_form_input(parseFloat(remaining_amount)
                                    .toFixed(4)) + ' ' + unit_value,
                                'data-col': 'remaining_amount',
                                'data-val': remaining_amount
                            }).appendTo('#accepted_shipment_item_' + stock_code);
                            jQuery('<td>', {
                                html: replace_for_form_input(parseFloat(stock_amount)
                                    .toFixed(4)) + ' ' + unit_value,
                                'data-col': 'stock_amount',
                                'data-val': stock_amount
                            }).appendTo('#accepted_shipment_item_' + stock_code);
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
                url: '<?= route_to('tportal.shipment.shipment_item.cancel_receive') ?>',
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
                            $('#accepted_shipment_item_' + stock_code).remove();
                        } else {
                            remaining_amount_el = $("#accepted_shipment_item_" + stock_code).find(
                                "[data-col='remaining_amount']");
                            stock_amount_el = $("#accepted_shipment_item_" + stock_code).find(
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

    $('#checkBeforeArrival').on('click', function() {
        $('#checked_shipment_items').empty();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.shipment.check.before_arrival') ?>',
            dataType: 'json',
            data: {
                shipment_id: <?= $shipment_item['shipment_id'] ?>
            },
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    approveArrival();
                } else {
                    $.each(response['shipment_items'], function(key, shipment_item) {
                        jQuery('<li>', {
                            id: 'checked_shipment_item_' + shipment_item.shipment_item_id,
                            class: 'checked_shipment_item',
                            html: '<b>' + shipment_item.stock_code + '</b> | ' +
                                shipment_item.stock_title + ' | ' + shipment_item.barcode_number.slice(0, 13)
                        }).appendTo('#checked_shipment_items');
                    });
                    $('#approve_shipment_modal').modal('toggle');
                }
            }
        })
    })

    $("#btnDeleteSaleOrder").each(function(index) {
            $(this).on("click", function() {

                var shipment_id = $(this).attr('data-shipment-id');
                console.log(shipment_id);

                Swal.fire({
                    title: 'Mevcut siparişi iptal etmek üzeresiniz!',
                    html: 'Sipariş iptal işlemine devam etmek istiyor musunuz?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Devam Et',
                    cancelButtonText: 'Hayır',
                    allowEscapeKey: false,
                    allowOutsideClick: false,

                }).then((result) => {
                    if (result.isConfirmed) {

                        Swal.fire({
                            title: 'İşleminiz gerçekleştiriliyor, lütfen bekleyiniz...',
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                Swal.showLoading();
                            },
                        });

                        $.ajax({
                            type: 'POST',
                            url: '<?= route_to('tportal.cari.sale_order_delete') ?>',
                            data: "shipment_id=" + shipment_id,
                            success: function(response, data) {
                                if (data === "success") {
                                    console.log(response);
                                    console.log(data);
                                    Swal.fire({
                                            title: "İşlem Başarılı",
                                            html: 'Mevcut sipariş başarıyla iptal edildi.',
                                            confirmButtonText: "Tamam",
                                            allowEscapeKey: false,
                                            allowOutsideClick: false,
                                            icon: "success",
                                        })
                                        .then(function() {
                                            window.location.reload();
                                        });

                                } else {
                                    Swal.fire({
                                        title: "İşlem Başarısız",
                                        text: data,
                                        confirmButtonText: "Tamam",
                                        allowEscapeKey: false,
                                        allowOutsideClick: false,
                                        icon: "error",
                                    })
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                                console.log(status);
                                console.log(error);
                                Swal.fire({
                                    title: "Bir hata oluştu",
                                    text: "sistemsel bir hata. daha sonra tekrar deneyiniz.",
                                    confirmButtonText: "Tamam",
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    icon: "error",
                                })
                            },
                        });

                    } else if (result.isCancel) {
                        Swal.fire('Değişiklikler kaydedilmedi', '', 'info')
                    }
                })

            });
        });

    $('#approveArrival').on('click', function() {
        approveArrival();
    })

    function approveArrival() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.shipment.approve.arrival') ?>',
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