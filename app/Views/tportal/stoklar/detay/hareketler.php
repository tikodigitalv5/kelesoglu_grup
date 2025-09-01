<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Ürün Hareketleri
<?= $this->endSection() ?>
<?= $this->section('title') ?> Ürün Hareketleri |
<?= $stock_item['stock_code'] ?> -
<?= $stock_item['stock_title'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>




<?= $this->section('main') ?>
<style>
.dataTables_wrapper {
    width: 100%; /* Tablonun genişliği yüzde 100 olacak şekilde ayarlanır */
    overflow-x: auto; /* Eğer tablo genişlerse yatay kaydırma çıkar */
}

table.dataTable {
    table-layout: auto; /* Tablo sütun genişliği içeriğe göre ayarlanacak */
    width: 100%; /* Tablonun genişliği yüzde 100 olacak */
}

    
    .dataTables_length, .dataTables_filter, .datatable-filter{
        display: block!important;

    }
    .with-export{
        display: flex!important;
        margin-bottom:20px;
        margin-right: 10px;

    }
    .dataTables_length .form-control-select{
        display: block!important;
    }
    .dataTables_length span{
        display:block!important;
    }
</style>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xxl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head nk-block-head-lg">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Ürün Hareketleri</h4>

                                    </div>
                                    <div class="nk-block-head-content align-self-start">

                                        <?php
                                        if ($stock_item['has_variant'] == 0) {
                                            echo view_cell(
                                                'App\Libraries\ViewComponents::getComponent',
                                                [
                                                    'component_name' => 'stoklar.detay.hareketler.buton',
                                                ]
                                            );
                                        } else {
                                            echo '<label> Bu ürün ana ürün olduğu için stok girişi yapılamaz. </label>';
                                        }


                                        
                                        ?>



                                    </div>

                                </div>
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">
                                <div class="nk-data data-list">

                                    <?= view_cell('App\Libraries\ViewComponents::getComponent', ['component_name' => 'stoklar.detay.hareketler']); ?>


                                </div><!-- data-list -->

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
        'element' => 'stock_barcode',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="' . route_to('tportal.stocks.detail', $stock_item['stock_id']) . '" id="stockDetail" class="btn btn-info btn-block mb-2">Bu Ürünün Detayına Git</a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#mdl_stock_barcode_create" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Stok Giriş Ekle</a>
                                    <a href="#" onclick="location.reload()" class="btn btn-l btn-dim btn-outline-dark btn-block">Stok Giriş Listesi</a>'
            ],
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>


<script>
    $(document).ready(function () {

        $('#stock_quantity').on('blur', function () {
            if ($('#stock_quantity').val() != null && $('#stock_quantity').val() != '') {
                tempValue = $('#stock_quantity').val();

                if (String(tempValue).includes(",")) {
                    tempValue = tempValue.replace(',', '.')
                    tempValue = parseFloat(tempValue).toFixed(4)
                } else {
                    tempValue = parseFloat(tempValue).toFixed(4)
                }
                tempValue = replace_for_form_input(tempValue)

                $('#stock_quantity').val(tempValue)
            } else {
                $('#stock_quantity').val('0,0000')
            }
        })

        $('#buy_unit_price').on('blur', function () {
            if ($('#buy_unit_price').val() != null && $('#buy_unit_price').val() != '') {
                tempValue = $('#buy_unit_price').val();

                if (String(tempValue).includes(",")) {
                    tempValue = tempValue.replace(',', '.')
                    tempValue = parseFloat(tempValue).toFixed(4)
                } else {
                    tempValue = parseFloat(tempValue).toFixed(4)
                }
                tempValue = replace_for_form_input(tempValue)

                $('#buy_unit_price').val(tempValue)
            } else {
                $('#buy_unit_price').val('0,0000')
            }
        })

        function printContent(content) {
            var w = window.open('', '_blank');

            for (let index = 0; index < content.length; index++) {
                w.document.write(content[index]);
            }

            setTimeout(function () {
                w.print();
                // w.close();
            }, 600);
        }


        $('#stokBarkodOlustur').click(function (e) {

            let miktar_satir_sayi = $("#miktar_str_s").val();
            let miktar_satir_array = [];
            let satir = {};

            // console.log("for için dönecek", miktar_satir_sayi);

            let iiii = 0;

            for (let index = iiii; index <= miktar_satir_sayi; index++) {
                // alert($('#txt_gtip_' + index).val());

                console.log("dön babam dön_" + index);

                if ($("#stock_quantity_" + index).is(":visible") == true) {

                    satir = {

                        miktar_satir_sira: (index + 1),

                        miktar: parseFloat(
                            $("#stock_quantity_" + index)
                                .val()
                                .replace(".", "")
                                .replace(",", ".")
                        ),
                    };

                    miktar_satir_array.push(satir);
                    console.log(miktar_satir_array);

                } else {
                    // fatura_satir_sil(index);
                    satir = {
                        invoice_row_id: $("#Satir_" + index).attr('invoice_row_id'),
                        order_row_id: $("#Satir_" + index).attr('order_row_id'),
                        offer_row_id: $("#Satir_" + index).attr('offer_row_id'),
                        isDeletedInvoice: $("#Satir_" + index).attr('invoice_row_id'),
                        isDeletedOrder: $("#Satir_" + index).attr('order_row_id'),
                        isDeletedOffer: $("#Satir_" + index).attr('offer_row_id'),

                        stock_amount: $("#txt_miktar_" + index).val(),
                        warehouse_id: $("#txt_warehouse_id_" + index).val(),
                        stock_id: $("#txt_aciklama_" + index).attr("urun_id"),
                        // stock_amount: $("#txt_miktar_" + index).val() != null || $("#txt_miktar_" + index).val() != undefined ? parseFloat($("#txt_miktar_" + index).val().replace(".", "").replace(",", ".")) : 0,

                    };

                    miktar_satir_array.push(satir);

                }
            }


            e.preventDefault();
            var formData = $('#createStockBarcodeModalForm').serializeArray();
            console.log(formData);
            $('#btn_waiting').removeClass('d-none');
            $('#base_btn').addClass('d-none');

            if ($('#stock_quantity').val() != '' && $('#stock_quantity').val() != '0,0000' && $('#stock_quantity').val() != '0,00' && $('#supplier_id').val() != 0) {

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= route_to('tportal.stocks.stock_barcode_create', $stock_item['stock_id']) ?>',
                    data: {
                        data_form: formData,
                        data_rows: miktar_satir_array,
                    },
                    async: true,
                    datatype: "json",
                    success: function (response) {
                        var res = JSON.parse(response);

                        // console.log(res);
                        // console.log(res.all_barcode);
                        // console.log(res.all_barcode.length);

                        var all_barcode_count = res.all_barcode.length;
                        console.log("all_barcode_lenght", all_barcode_count);

                        // var all_barcode_first = res.all_barcode[0];
                        // console.log("all_barcode_first", all_barcode_first);


                        if (res['icon'] == 'success') {

                            $('#supplier_id').val(0);
                            $('#supplier_id').trigger('change');
                            $('#totalPriceArea').addClass('d-none');
                            $('#totalPriceAreaTRY').addClass('d-none');
                            $('#btn_waiting').addClass('d-none');
                            $('#base_btn').removeClass('d-none');


                            $('#createStockBarcodeModalForm')[0].reset();
                            $('#mdl_stock_barcode_create').modal('toggle');
                            var timerInterval;


                            // Swal.fire({
                            //     title: 'Barkod Oluşturuluyor',
                            //     html: 'Lütfen Oluşturulana kadar bekleyiniz..',
                            //     timer: 1000,
                            //     timerProgressBar: true,
                            //     onBeforeOpen: function onBeforeOpen() {
                            //         Swal.showLoading();
                            //         timerInterval = setInterval(function () {
                            //             Swal.getContent().querySelector('b')
                            //                 .textContent = Swal.getTimerLeft();
                            //         }, 100);
                            //     },
                            //     onClose: function onClose() {
                            //         clearInterval(timerInterval);
                            //     }
                            // }).then(function (result) {
                            //     if (
                            //         result.dismiss === Swal.DismissReason.timer) {
                            //         console.log('I was closed by the timer');
                            //     }
                            // });


                            // for (let index = 0; index < all_barcode_count; index++) {
                            //     console.log("barkod için yazılacak",index);
                            //     printContent(res.all_barcode[index]);
                            // }


                            setTimeout(function () {
                                printContent(res.all_barcode);
                            }, 600);


                            $("#trigger_stock_barcode_ok_button").trigger("click");
                        } else {
                            swetAlert("Bir Sorun Oluştu", response['message'], "err");
                        }
                    }
                })

            } else {
                Swal.fire({
                    title: "Uyarı!",
                    html: 'Lütfen miktar alanını ve tedarikçi alanını boş bırakmayınız...',
                    icon: "warning",
                    confirmButtonText: 'Tamam',
                });

                $('#btn_waiting').addClass('d-none');
                $('#base_btn').removeClass('d-none');
            }
        });


        $(document).on("click", "#printStockBarcode", function () {

            var barcode_number = $(this).attr('data-barcode-number');
            console.log("printStockBarcode class'ına sahip btn tıklandı");
            console.log(barcode_number);
            Swal.fire({
                title: 'Barkod Oluşturuluyor...',
                html: 'Barkod oluşturulana kadar lütfen bekleyiniz. ',
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
                url: '<?= route_to('tportal.stocks.stock_barcode_print') ?>',
                dataType: 'json',
                data: {
                    barcode_number: barcode_number
                },
                async: true,
                success: function (response) {
                    if (response['icon'] == 'success') {
                        Swal.fire({
                            title: "İşlem Başarılı",
                            html: 'Barkod başarıyla oluşturuldu. <br> Yönlendiriliyorsunuz... ',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            icon: "success",
                            timer: 2120
                        }).then(function () {
                            printContent(response['barcode_html']);
                        });

                    } else {
                        swetAlert("Bir Sorun Oluştu", response['message'], "err");
                    }
                }
            });
        });


        $(document).on("click", "#btnDeleteStock", function () {

            var stock_barcode_id = $(this).attr('data-stock-barcode-id');
            var stock_id = $(this).attr('data-stock-id');

            Swal.fire({
                title: 'Stok hareketini silmek üzeresiniz!',
                html: 'Silme işlemine devam etmek istiyor musunuz?',
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
                        url: '<?= route_to('tportal.stocks.stock_barcode_delete') ?>',
                        data: { stock_barcode_id: stock_barcode_id, stock_id: stock_id },
                        success: function (response, data) {
                            dataa = JSON.parse(response);
                            if (dataa.icon === "success") {
                                console.log(response);
                                console.log(data);
                                Swal.fire({
                                    title: "İşlem Başarılı",
                                    html: 'Stok hareketi başarıyla silindi.',
                                    confirmButtonText: "Tamam",
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    icon: "success",
                                })
                                    .then(function () {
                                        window.location.reload();
                                    });
                            } else {
                                Swal.fire({
                                    title: "İşlem Başarısız",
                                    text: dataa.message,
                                    confirmButtonText: "Tamam",
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    icon: "error",
                                })
                            }
                        },
                        error: function (xhr, status, error) {
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
</script>

<?= $this->endSection() ?>