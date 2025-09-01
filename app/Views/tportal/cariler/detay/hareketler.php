<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Cari Detay
<?= $this->endSection() ?>
<?= $this->section('title') ?> Cari Detay |
<?= session()->get('user_item')['firma_adi'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>

<?php helper('Helpers\number_format_helper'); ?>


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
    tr.bg-danger-dim {
    background-color: #ffebee !important; /* Daha belirgin bir kırmızı ton */
}

tr.bg-danger-dim:hover {
    background-color: #ffcdd2 !important; /* Hover durumunda biraz daha koyu ton */
}

tr.bg-danger-dim td {
    color: #c62828; /* Metin rengi biraz daha koyu kırmızı */
}

.ni-cross-circle-fill {
    margin-left: 5px;
    font-size: 16px;
    color: #d32f2f;
}
</style>
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
                                        <h4 class="nk-block-title">Cari Hareketleri</h4>
                                    </div>
                                    <div class="nk-block-head-content align-self-start">
                                        <!-- <button class="btn btn-md btn-primary" id="getInvoiceRow">Fatura Satırlarını Getir</button> -->
                                        <a href="<?= base_url("tportal/cari/financial-movements/" . $cari_item['cari_id'] . "/" . "/detayli" ) ?>"
                                            class="btn btn-md btn-primary">Detaylı Cari Hareketleri <em class="icon ni ni-chevron-right"></em>  </a>
                                            <a href="<?= route_to('tportal.faturalar.getInvoicesRow', $cari_item['cari_id']) ?>"
                                            class="btn btn-md btn-primary">Fatura Satırlarını Getir <em class="icon ni ni-chevron-right"></em> </a>

                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">
                                <div class="nk-data data-list">


                                    <table class="datatable-init-hareketler nowrap table">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2;">Tarih</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">İşlem</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Fatura/İşlem No
                                                </th>
                                              
                                                <th style="background-color: #ebeef2;" data-orderable="false">Tutar</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Bakiye
                                                </th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">...</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                      

                                        <?php
// Başlangıç bakiyesi veritabanından alınan cari bakiye
$temp_balance = 0; // Cari bakiyeyi başlangıç olarak alıyoruz.

// Toplam borç ve alacak için değişkenler
$total_debt = 0; // Toplam borç
$total_credit = 0; // Toplam alacak

// İşlem listesi sırayla işlenecek
foreach ($financial_movement_items as $financial_movement_item) {
    // ÖNCE bakiye hesaplaması yapılıyor
    if($financial_movement_item["money_unit_id"] == $cari_item["money_unit_id"]){
        $transaction_amounts = ($financial_movement_item['virman'] != '' && $financial_movement_item['virman'] != 0 ) ? $financial_movement_item['virman'] : $financial_movement_item['transaction_amount'];
    }else{
        if($financial_movement_item["money_unit_id"] != 3){
            $movementFiyat = $financial_movement_item["amount_to_be_paid_try"];
        }else{
            $movementFiyat = $financial_movement_item["amount_to_be_paid"];
        }
        $transaction_amounts = ($financial_movement_item['virman'] != '' && $financial_movement_item['virman'] != 0 ) ? $financial_movement_item['virman'] : $movementFiyat;
    }

   
    
    // İşlem türüne göre bakiyeyi ve toplam borç/alacakları güncelleme
    if($financial_movement_item['invoice_status_title'] != "İptal Edildi" && $financial_movement_item['invoice_status_title'] != "Reddedildi" && $financial_movement_item['invoice_status_title'] != "Red Edildi"){
    switch ($financial_movement_item['transaction_type']) {
        case 'incoming_invoice':  // Giden fatura: Borç (çıkış işlemi)
        case 'collection':        // Ödeme: Borç
        case 'borc_alacak':       // Borç/Alacak (negatifse borç, pozitifse alacak)
            $temp_balance -= $transaction_amounts;
            $total_debt += $transaction_amounts; // Borç ekle
            break;
    
        case 'outgoing_invoice':  // Alış faturası: Alacak (giriş işlemi)
        case 'payment':           // Tahsilat: Alacak
            $temp_balance += $transaction_amounts;
            $total_credit += $transaction_amounts; // Alacak ekle
            break;
    
        case 'starting_balance': // Başlangıç bakiyesi
            if ($transaction_amounts < 0) {
                $temp_balance -= abs($transaction_amounts);
                $total_debt += abs($transaction_amounts);
            } else {
                $temp_balance += $transaction_amounts;
                $total_credit += $transaction_amounts;
            }
            break;
        case 'check_bill':
           if($financial_movement_item['transaction_direction'] == "entry"){
            $temp_balance -= $transaction_amounts;
            $total_debt += $transaction_amounts;
           }else{
           
            $temp_balance += $transaction_amounts;
            $total_credit += $transaction_amounts;
           }

           break; // Bu break eksikti

        default:
            break;
    }
    }
    // SONRA ekrana yazdırma işlemleri
    ?>
<tr <?php if($financial_movement_item['invoice_status_title'] == "İptal Edildi" || $financial_movement_item['invoice_status_title'] == "Reddedildi" || $financial_movement_item['invoice_status_title'] == "Red Edildi"): ?> 
    style="background-color: #ffebee !important;" 
    class="bg-danger-dim"
    <?php endif; ?>>
    <td data-order="<?= $financial_movement_item['transaction_date'] ?> . <?= $financial_movement_item['financial_movement_id'] ?>"
        title="<?= $financial_movement_item['transaction_date'] ?>">
        <?= date("d/m/Y", strtotime($financial_movement_item['transaction_date'])) ?>
        <?php if($financial_movement_item['invoice_status_title'] == "İptal Edildi" || $financial_movement_item['invoice_status_title'] == "Reddedildi" || $financial_movement_item['invoice_status_title'] == "Red Edildi"): ?>
            <em class="icon ni ni-cross-circle-fill text-danger" 
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="<?= $financial_movement_item['invoice_status_title'] ?>">
            </em>
        <?php endif; ?>
    </td>

        <td><span class="tb-status">
    <?= ($financial_movement_item['virman'] != '' && $financial_movement_item['virman'] != 0) ? "<b>" : '' ?>
    <?= $transaction_types[$financial_movement_item['transaction_type']] ?> 
    <?php if($financial_movement_item['transaction_type'] == 'check_bill'): ?>
        <?php if($financial_movement_item['transaction_direction'] == "entry"): ?>
            <em class="icon ni ni-arrow-down-left text-success" data-bs-toggle="tooltip" title="Giriş"></em>
        <?php else: ?>
            <em class="icon ni ni-arrow-up-right text-danger" data-bs-toggle="tooltip" title="Çıkış"></em>
        <?php endif; ?>
    <?php endif; ?>
    <?= ($financial_movement_item['virman'] != '' && $financial_movement_item['virman'] != 0) ? " - Virman</b>" : '' ?>
</span></td>    

        <td>
            <?php if(isset($financial_movement_item['fatura_id'])): ?>
                <a href="<?= route_to('tportal.faturalar.detail', $financial_movement_item['fatura_id']) ?>" target="_blank"><?= $financial_movement_item['invoice_no'] ?></a>
            <?php else: ?>
                <?= $financial_movement_item['transaction_number'] ?>
            <?php endif; ?>
        </td>


        <td class="text-end para">
            <?php 
            $transaction_amounts_satir = 0;
            if($financial_movement_item["money_unit_id"] == $cari_item["money_unit_id"]){
                $transaction_amounts_satir = $financial_movement_item['transaction_amount'];
            }else{
                if($financial_movement_item["money_unit_id"] != 3){
                    $transaction_amounts_satir = $financial_movement_item["amount_to_be_paid_try"];
                }else{
                    $transaction_amounts_satir = $financial_movement_item["amount_to_be_paid"];
                }
            }

            if ($financial_movement_item["virman"] != 0) {
                echo convert_number_for_form($financial_movement_item['virman'], 2) . " " . $cari_item['money_icon'];
                echo " (" . convert_number_for_form($financial_movement_item['transaction_amount'], 2) . " " . $financial_movement_item['money_icon'] . ")";
            } else {
                if (isset($financial_movement_item["is_return"])) {
                    echo convert_number_for_form($financial_movement_item['tedarik_price'], 2) . " " . $financial_movement_item['money_icon'];
                } else {
                    echo convert_number_for_form($financial_movement_item['transaction_amount'], 2) . " " . $financial_movement_item['money_icon'];
                    if($financial_movement_item["money_unit_id"] != $cari_item["money_unit_id"]){
                        echo " (" . convert_number_for_form($transaction_amounts_satir, 2) . " " . $cari_item['money_icon'] . ")";
                    }
                }
            }
            ?>
        </td>

        <!-- Güncel bakiye gösterimi -->
        <td class="text-end para <?= $temp_balance < 0 ? 'text-danger' : ''; ?> <?= $temp_balance > 0 ? 'text-success' : ''; ?>">
            <?= convert_number_for_form($temp_balance, 2) ?>
            <?= $cari_item['money_icon'] ?>
        </td>

        <!-- Detay butonları -->
        <td>
            
            
            <?php if ($financial_movement_item['transaction_type'] == 'collection' || $financial_movement_item['transaction_type'] == 'payment' || $financial_movement_item['transaction_type'] == 'incoming_gider' ||  $financial_movement_item['transaction_type'] == 'outgoing_gider') { ?>
                <a href="<?= route_to('tportal.cariler.payment_or_collection_edit', $financial_movement_item['financial_movement_id']) ?>"
                    class="btn btn-icon btn-xs btn-dim btn-outline-dark"
                    id="btnPrintBarcode" data-bs-toggle="tooltip"
                    style="padding: 4px;"
                    data-bs-placement="top" data-bs-title="Görüntüle"><em
                        class="icon ni ni-arrow-right"></em></a>
            <?php } else if (isset($financial_movement_item['invoice_id']) && ($financial_movement_item['invoice_id'] != null)) { 
                if ($financial_movement_item['sale_type'] == 'detailed') { ?>
                    <a href="<?= route_to('tportal.faturalar.detail', $financial_movement_item['invoice_id']) ?>"
                        class="btn btn-icon btn-xs btn-dim btn-outline-dark"
                        id="btnPrintBarcode" data-bs-toggle="tooltip"
                        style="padding: 4px;"
                        data-bs-placement="top" data-bs-title="Faturayı Görüntüle"><em
                            class="icon ni ni-arrow-right"></em></a>


                    <?php if(isset($financial_movement_item['tiko_id']) && $financial_movement_item['tiko_id'] == 0): ?>
                    <button type="button"
                        class="btn btn-icon btn-xs btn-dim btn-outline-danger deleteInvoice"
                        id="btnDeleteInvoice"
                        data-invoice-id="<?= $financial_movement_item['invoice_id'] ?>"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                        style="padding: 4px;"
                        data-bs-title="Faturayı Sil"><em
                            class="icon ni ni-trash-empty"></em></button>
                    <?php endif; ?>


                <?php } else if ($financial_movement_item['sale_type'] == 'quick') { ?>
                    <a href="<?= route_to('tportal.cari.quick_sale_order.detail', $financial_movement_item['invoice_id']) ?>"
                        class="btn btn-icon btn-xs btn-dim btn-outline-dark"
                        id="btnPrintBarcode" data-bs-toggle="tooltip"
                        style="padding: 4px;"
                        data-bs-placement="top" data-bs-title="Görüntüle"><em
                            class="icon ni ni-arrow-right"></em></a>
                <?php } ?>
            <?php } ?>

            <?php if($financial_movement_item['transaction_type'] == 'borc_alacak'): ?>
                <button type="button"
                        class="btn btn-icon btn-xs btn-dim btn-outline-danger deleteInvoiceBorc"
                        id="deleteInvoiceBorc"
                        style="padding: 4px;"
                        data-finansal-hareket-id="<?= $financial_movement_item['financial_movement_id'] ?>"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Finansal Hareketi Sil"><em
                            class="icon ni ni-trash-empty"></em></button>
            <?php endif; ?>
        </td>
    </tr>
    <?php
}
?>

<!-- Toplam Borç ve Alacakları Göster -->
<div class="totals d-none">
    <p><strong>Toplam Borç:</strong> <?= convert_number_for_form($total_debt, 2) ?> <?= $cari_item['money_icon'] ?></p>
    <p><strong>Toplam Alacak:</strong> <?= convert_number_for_form($total_credit, 2) ?> <?= $cari_item['money_icon'] ?></p>
</div>

                                        </tbody>
                                    </table>
                                </div><!-- data-list -->

                            </div><!-- .nk-block -->
                        </div>

                        <?= $this->include('tportal/cariler/detay/inc/sol_menu') ?>
                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    $('document').ready(function () {
        var myVar = $("#DataTables_Table_1_wrapper").find('.with-export').removeClass('d-none');
        var myVar2 = $("#DataTables_Table_1_wrapper").find('.with-export').css("margin-bottom", "10px");
        var base_url = window.location.origin;

        $(document).on("click", "#btnDeleteInvoice", function () {
            var invoice_id = $(this).attr('data-invoice-id');
            console.log(invoice_id);


            Swal.fire({
                    title: 'Fatura hareketini silmek üzeresiniz!',
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
                            type: "POST",
                            url: base_url + '/tportal/invoice/delete/' + invoice_id,
                            async: true,
                            datatype: "json",
                            success: function(response, data) {
                                dataa = JSON.parse(response);
                                if (dataa.icon === "success") {
                                    console.log(response);
                                    console.log(data);
                                    Swal.fire({
                                            title: "İşlem Başarılı",
                                            html: 'Fatura silme işlemi başarıyla gerçekleşti.',
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
                                        text: dataa.message,
                                        confirmButtonText: "Tamam",
                                        allowEscapeKey: false,
                                        allowOutsideClick: false,
                                        icon: "error",
                                    })
                                }
                            },
                            error: function () {
                                swetAlert("Hata!", "bir şeyler ters gitti", "err");
                            }
                        });

                    } else if (result.isCancel) {
                        Swal.fire('Değişiklikler kaydedilmedi', '', 'info')
                    }
                });
        });


        $(document).on("click", "#deleteInvoiceBorc", function () {
            var finansal_hareket_id = $(this).attr('data-finansal-hareket-id');
            console.log(finansal_hareket_id);


            Swal.fire({
                    title: 'Finansal hareketi silmek üzeresiniz!',
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
                            type: "POST",
                            url: base_url + '/tportal/invoice/finans_hareket_delete/' + finansal_hareket_id,
                            async: true,
                            datatype: "json",
                            success: function(response, data) {
                                dataa = JSON.parse(response);
                                if (dataa.icon === "success") {
                                    console.log(response);
                                    console.log(data);
                                    Swal.fire({
                                            title: "İşlem Başarılı",
                                            html: 'Finansal hareket silme işlemi başarıyla gerçekleşti.',
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
                                        text: dataa.message,
                                        confirmButtonText: "Tamam",
                                        allowEscapeKey: false,
                                        allowOutsideClick: false,
                                        icon: "error",
                                    })
                                }
                            },
                            error: function () {
                                swetAlert("Hata!", "bir şeyler ters gitti", "err");
                            }
                        });

                    } else if (result.isCancel) {
                        Swal.fire('Değişiklikler kaydedilmedi', '', 'info')
                    }
                });
        });
    });
</script>

<?= $this->endSection() ?>