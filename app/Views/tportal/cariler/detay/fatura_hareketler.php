<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Cari Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Cari Detay | <?= session()->get('user_item')['firma_adi'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

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
                                        <h4 class="nk-block-title">Fatura Satır Hareketleri</h4>
                                    </div>
                                    <div class="nk-block-head-content align-self-start">
                                        <!-- <button class="btn btn-md btn-primary" id="getInvoiceRow">Fatura Satırlarını Getir</button> -->
                                        <a href="<?= route_to('tportal.cariler.financial_movements',$cari_item['cari_id']) ?>" class="btn btn-md btn-primary"> <em class="icon ni ni-arrow-left"></em> Geri Dön</a>
                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">
                                <div class="nk-data data-list">


                                    <table class="datatable-init-hareketler_satir nowrap table">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2;">Tarih</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">İşlem</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Fatura No</th>
                                                <th style="background-color: #ebeef2; width:5px; " data-orderable="false">Ürün</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Ürün Miktarı</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Ürün Tutarı</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">...</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($invoice_row_items as $invoice_row_item) { ?>
                                                <tr>
                                                    <td title="<?= $invoice_row_item['invoice_date'] ?>"><?= date("d/m/Y", strtotime($invoice_row_item['invoice_date'])) ?> </td>
                                                    <td><span class="tb-status <?= $invoice_row_item['invoice_direction'] == 'incoming_invoice' ? 'text-success' : 'text-danger' ;?>"><?= $invoice_row_item['invoice_direction'] == 'incoming_invoice' ? 'Gelen Fatura' : 'Giden Fatura' ;?></span></td>
                                                    <td><?= $invoice_row_item['invoice_no'] == null ? '#PROFORMA' : $invoice_row_item['invoice_no'] ?></td>
                                                    <td style="max-width: 120px !important; width:120px !important; overflow:hidden; text-overflow:ellipsis" width="150" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?= $invoice_row_item['stock_title'] ?>"><?= $invoice_row_item['stock_title'] ?></td>
                                                    <td class="text-end para"><?= convert_number_for_form($invoice_row_item['stock_amount'], 2) ?> <?= $invoice_row_item['unit_title'] ?></td>
                                                    <td class="text-end para"><?= convert_number_for_form($invoice_row_item['total_price'], 2) ?> <?= $cari_item['money_icon'] ?></td>

                                                    <td>
                                                        <?php if (isset($invoice_row_item['invoice_id'])) { 

                                                                if($invoice_row_item['sale_type'] == 'quick'){
                                                                    $route_link = 'tportal.cari.quick_sale_order.detail';
                                                                }else{
                                                                    $route_link = 'tportal.faturalar.detail';
                                                                }
                                                            
                                                            ?>
                                                            <a href="<?= route_to($route_link, $invoice_row_item['invoice_id']) ?>" class="btn btn-icon btn-xs btn-dim btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Görüntüle"><em class="icon ni ni-arrow-right"></em></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>

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
    var myVar2 = $("#DataTables_Table_1_wrapper").find('.with-export').css("margin-bottom","10px");
    var base_url = window.location.origin;

    // $(document).on("click", "#getInvoiceRow", function () {
    //     $.ajax({
    //                                 type: "POST",
    //                                 url: base_url + '/tportal/invoice/getInvoicesRow',
    //                                 async: true,
    //                                 datatype: "json",
    //                                 success: function (response) {
    //                                     console.log(response);
    //                                 },
    //                                 error: function () {
    //                                     swetAlert("Hata!", "bir şeyler ters gitti", "err");
    //                                 }
    //                             });
    // });

});
</script>

<?= $this->endSection() ?>