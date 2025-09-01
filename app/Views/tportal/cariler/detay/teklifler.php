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
                                        <h4 class="nk-block-title">Teklif Hareketleri</h4>
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
                                                <th style="background-color: #ebeef2;" data-orderable="false">Teklif No
                                                </th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Durum
                                                </th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Tutar</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Bakiye</th>
                                               
                                                <th style="background-color: #ebeef2;" data-orderable="false">...</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                      

                                        <?php
                                     
$temp_balance = 0; 

foreach ($financial_movement_items as $financial_movement_item) {


    // İşlemi yazdırıyoruz
    ?>
    <tr>
        <td data-order="<?= $financial_movement_item['offer_date'] ?> . <?= $financial_movement_item['offer_id'] ?>"
            title="<?= $financial_movement_item['offer_date'] ?>">
            <?= date("d/m/Y", strtotime($financial_movement_item['offer_date'])) ?>
        </td>

          
        <!-- İşlem numarası -->
        <td><?= $financial_movement_item['offer_no'] ?? '-' ?></td>

        <!-- Tutarlar -->
        <td class="">
    
                                                <?php switch ($financial_movement_item['offer_status']) {
                                                    case 'new':
                                                        echo "<span class='tb-status text-primary'> Yeni Teklif </span>";
                                                        break;
                                                    case 'pending':
                                                        echo "<span class='tb-status text-warning'> Teklif İnceleniyor </span>";
                                                        break;
                                                    case 'success':
                                                        echo "<span class='tb-status text-success'> Teklif Kabul Edildi </span>";
                                                        break;
                                                    case 'failed':
                                                        echo "<span class='tb-status text-danger'> Teklif Reddelidi </span>";
                                                        break;
                                                } ?>
                                          
        </td>
    

        <!-- Tutarlar -->
        <td class="text-end para">
            <?php 
                echo convert_number_for_form($financial_movement_item['amount_to_be_paid'], 2) . " " . $cari_item['money_icon'];
            ?>
        </td>

        <!-- Geçici bakiye (ilk işlemde cari bakiyeden başlıyor ve güncelleniyor) -->
        <td class="text-end para <?= $temp_balance < 0 ? 'text-danger' : ''; ?> <?= $temp_balance > 0 ? 'text-success' : ''; ?>">
            <?= convert_number_for_form($temp_balance, 2) ?>
            <?= $cari_item['money_icon'] ?>
        </td>
    

        <!-- Detaylar veya Fatura Silme Butonları -->
        <td>
        <a href="<?= route_to('tportal.teklifler.detail', $financial_movement_item['offer_id']) ?>"
                    class="btn btn-icon btn-xs btn-dim btn-outline-dark"
                    id="btnPrintBarcode" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="Görüntüle"><em
                        class="icon ni ni-arrow-right"></em></a>
        </td>
    </tr>
    <?php


$temp_balance += $financial_movement_item['amount_to_be_paid'];
}
?>



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

    });
</script>

<?= $this->endSection() ?>