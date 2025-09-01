<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>
<?= $this->section('title') ?>
<?= $page_title ?> |
<?= session()->get('user_item')['firma_adi'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>




<?= $this->section('main') ?>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">
                            <?= $page_title ?>
                        </h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon  toggle-expand me-n1" data-target="pageMenu"><em
                                    class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li><a href="#" class="btn btn-white btn-outline-light"><em
                                                class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                    <li class="nk-block-tools-opt">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary"
                                                data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>Add User</span></a></li>
                                                    <li><a href="#"><span>Add Team</span></a></li>
                                                    <li><a href="#"><span>Import User</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .toggle-wrap -->
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">

                <div class="card p-3 px-5">
                    <div class="card-title-group">
                        <div class="card-tools">
                            <div class="form-inline">
                                <span class="">Bu sayfadan günlük olarak gelir ve gider durumlarını
                                    inceleyebilirsiniz.</span>
                            </div><!-- .form-inline -->
                        </div><!-- .card-tools -->
                        <div class="card-tools me-n1">
                            <ul class="btn-toolbar gx-1">
                                <li>
                                    <div class="form-inline flex-nowrap gx-3">
                                        <div class="">
                                            <div class="">
                                                <p>İşlem Tarihi: </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                </div>
                                                <input type="text"
                                                    class="form-control  form-control-lg form-control-lg date-picker"
                                                    name="report_date" id="report_date"
                                                    value="<?= isset ($date) ? date("d/m/Y", strtotime($date)) : date('d/m/Y') ?>">
                                            </div>
                                        </div>
                                    </div>
                                </li><!-- li -->
                                <li class="btn-toolbar-sep d-none"></li><!-- li -->
                                <!-- li -->
                            </ul><!-- .btn-toolbar -->
                        </div><!-- .card-tools -->
                    </div><!-- .card-title-group -->
                    <div class="card-search search-wrap" data-search="search">
                        <div class="card-body">
                            <div class="search-content">
                                <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em
                                        class="icon ni ni-arrow-left"></em></a>
                                <input type="text" id="invoice_input_search"
                                    class="form-control border-transparent form-focus-none"
                                    placeholder="Bulmak istediğiniz faturanın fatura ünvanını veya fatura numarasını yazınız...">
                                <a href="#" class="btn btn-icon toggle-search" data-target="search"
                                    style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em
                                        class="icon ni ni-cross"></em></a>
                                <button class="search-submit btn btn-icon" style="margin-right: 50px;"
                                    id="invoice_input_search_clear_button" name="invoice_input_search_clear_button"><em
                                        class="icon ni ni-trash"></em></button>
                            </div>
                        </div>
                    </div><!-- .card-search -->
                </div>

                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                    <div class="form-inline">
                                        <h5>Gelir Raporu</h5>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>
                                            <!-- <div class="form-inline flex-nowrap gx-3">
                                                <div class="">
                                                    <div class="">
                                                        <p>İşlem Tarihi: </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control  form-control-lg form-control-lg date-picker"
                                                            name="report_date" id="report_date"
                                                            value="<?= isset ($date) ? date("d/m/Y", strtotime($date)) : date('d/m/Y') ?>">
                                                    </div>
                                                </div>
                                            </div> -->
                                        </li><!-- li -->
                                        <li class="btn-toolbar-sep d-none"></li><!-- li -->
                                        <!-- li -->
                                    </ul><!-- .btn-toolbar -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search"
                                            data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" id="invoice_input_search"
                                            class="form-control border-transparent form-focus-none"
                                            placeholder="Bulmak istediğiniz faturanın fatura ünvanını veya fatura numarasını yazınız...">
                                        <a href="#" class="btn btn-icon toggle-search" data-target="search"
                                            style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em
                                                class="icon ni ni-cross"></em></a>
                                        <button class="search-submit btn btn-icon" style="margin-right: 50px;"
                                            id="invoice_input_search_clear_button"
                                            name="invoice_input_search_clear_button"><em
                                                class="icon ni ni-trash"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div>

                        <div class="card-inner p-0">
                            <div class="card card-preview">
                                <table class="table table-tranx is-compact">
                                    <thead class="bg-light bg-opacity-75">
                                        <tr class="tb-tnx-head">
                                            <th class="tb-tnx-id">
                                                <span class="">#</span>
                                            </th>
                                            <th class="nk-tb-col"><span class="sub-text">FATURA TARİHİ </span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">FATURA NUMARASI</span></th>
                                            <th class="nk-tb-col tb-col-md" data-orderable="false"
                                                style="min-width:120px"><span class="sub-text">DURUM</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">FATURA UNVAN</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"
                                                style="min-width:120px"><span class="sub-text">FATURA TİPİ</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">ARA TOPLAM </span></th>
                                                    <?php if(session()->get('user_id') == 5): ?>
                                                    <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">İSK TOPLAM </span></th>
                                                    <?php endif; ?>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">KDV TOPLAM </span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">GENEL TOPLAM </span></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
$sira = 1;
$genel_ara_toplam_outgoing = [];
$genel_kdv_toplam_outgoing = [];
$genel_iskonto_toplam_outgoing = [];
$genel_toplam_outgoing = [];
$cari_haric = session()->get("user_item")["stock_user"] ?? 0;

foreach ($invoice_items_outgoing as $invoice_item_outgoing) {
    if ($invoice_item_outgoing["cari_id"] != $cari_haric) {

        $money_unit_id = $invoice_item_outgoing['money_unit_id'];
        $money_icon = $invoice_item_outgoing['money_icon'];

        // KDV hesaplama
        if ($money_unit_id != 3) {
            $tax_1_outgoing = $invoice_item_outgoing['tax_rate_1_amount'];
            $tax_10_outgoing = $invoice_item_outgoing['tax_rate_10_amount'];
            $tax_20_outgoing = $invoice_item_outgoing['tax_rate_20_amount'];
        } else {
            $tax_1_outgoing = $invoice_item_outgoing['tax_rate_1_amount_try'];
            $tax_10_outgoing = $invoice_item_outgoing['tax_rate_10_amount_try'];
            $tax_20_outgoing = $invoice_item_outgoing['tax_rate_20_amount_try'];
        }

        $toplam_kdv_outgoing = floatval($tax_1_outgoing) + floatval($tax_10_outgoing) + floatval($tax_20_outgoing);


        // Para birimine göre toplamları güncelle
        if (!isset($genel_ara_toplam_outgoing[$money_unit_id])) {
            $genel_ara_toplam_outgoing[$money_unit_id] = 0;
            $genel_kdv_toplam_outgoing[$money_unit_id] = 0;
            $genel_toplam_outgoing[$money_unit_id] = 0;
            $genel_iskonto_toplam_outgoing[$money_unit_id] = 0;
        }

        $toplam_iskonto = floatval($invoice_item_outgoing["discount_total"]);

        $genel_iskonto_toplam_outgoing[$money_unit_id] += floatval($invoice_item_outgoing['discount_total']);
        $genel_ara_toplam_outgoing[$money_unit_id] += floatval($invoice_item_outgoing['sub_total']);
        $genel_kdv_toplam_outgoing[$money_unit_id] += $toplam_kdv_outgoing;
        $genel_toplam_outgoing[$money_unit_id] += floatval($invoice_item_outgoing['amount_to_be_paid']);

        ?>
        <tr>
            <td><?= $sira ?></td>
            <td data-order="<?= $invoice_item_outgoing['invoice_date'] ?>" title="<?= $invoice_item_outgoing['invoice_date'] ?>">
                <?= date("d/m/Y", strtotime($invoice_item_outgoing['invoice_date'])) ?>
            </td>
            <td>
                <?= $invoice_item_outgoing['is_quick_sale_receipt'] == 1 ? 'Hızlı Satış Fişi' : $invoice_item_outgoing['invoice_no']; ?>
            </td>
            <td>
                <span class="tb-lead"><span class="dot dot-<?= $invoice_item_outgoing['status_info'] ?>"></span>
                    <?= $invoice_item_outgoing['status_name'] ?? '-' ?>
            </td>
            <td><?= $invoice_item_outgoing['cari_invoice_title'] ?? '-' ?></td>
            <td><?= $invoice_item_outgoing['invoice_direction'] == 'outgoing_invoice' ? 'Satış' : '-' ?></td>
            <td>
                <?= $money_icon ?> <?= number_format($invoice_item_outgoing['sub_total'], 2, ',', '.') ?? '-' ?>
            </td>
            <td>
                <?= $money_icon ?> <?= number_format($toplam_iskonto, 2, ',', '.') ?? '-' ?>
            </td>
            <td>
                <?= $money_icon ?> <?= number_format($toplam_kdv_outgoing, 2, ',', '.') ?? '-' ?>
            </td>
            <td>
                <?= $money_icon ?> <?= number_format($invoice_item_outgoing['amount_to_be_paid'], 2, ',', '.') ?? '-' ?>
            </td>
        </tr>
        <?php
        $sira++;
    }
}
?>
                                    </tbody>
                                    <tfoot>
                                    <?php foreach ($outgoing_invoice_summary as $money_unit_id => $summary): ?>
        <tr>
            <td style="background-color: #f0f0f0; text-align:end" colspan="6"><b>TOPLAM (<?= $summary['money_icon'] ?>):</b></td>
            <td style="background-color: #f0f0f0;" colspan=""><b><?= number_format($summary['total_sub_total'], 2, ',', '.') ?> <?= $summary['money_icon'] ?></b></td>
            <td style="background-color: #f0f0f0;" colspan=""><b><?= number_format($genel_iskonto_toplam_outgoing[$money_unit_id], 2, ',', '.') ?> <?= $summary['money_icon'] ?></b></td>
            <td style="background-color: #f0f0f0;" colspan=""><b><?= number_format($summary['total_tax'], 2, ',', '.') ?> <?= $summary['money_icon'] ?></b></td>
            <td style="background-color: #f0f0f0;" colspan=""><b><?= number_format($summary['total_amount'], 2, ',', '.') ?> <?= $summary['money_icon'] ?></b></td>
        </tr>
    <?php endforeach; ?>

                                        <?php 
                                        $i = 0;
                                        foreach ($outgoingInvoiceSummary as $item) {
                                            $i++;
                                         ?>
                                      
                                      <tr>
                                      <td style="background-color: #f0f0f0; text-align:end" colspan="7">
                                          
                                            <b><?php echo $item["unit_title"]; ?>:</b>

                                            </td>
                                           
                                            <td style="background-color: #f0f0f0;" colspan=""><b>
                                                    <?= number_format($item['total_amount'], 2, ',', '.') ?>
                                                </b></td>
                                                <td style="background-color: #f0f0f0;" colspan=""><b>
                                                <td style="background-color: #f0f0f0;" colspan=""><b>
                                                </tr>
                                      
                                            
                                      <?php   }
                                        ?>
                                          
                                       


                           

                                    </tfoot>
                                </table>
                            </div>



                        </div>

                    </div><!-- .card-inner-group -->
                </div><!-- .card -->

                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                    <div class="form-inline">
                                        <h5>Gider Raporu</h5>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>
                                            <!-- <div class="form-inline flex-nowrap gx-3">
                                                <div class="">
                                                    <div class="">
                                                        <p>İşlem Tarihi: </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control  form-control-lg form-control-lg date-picker"
                                                            name="report_date" id="report_date"
                                                            value="<?= isset ($date) ? date("d/m/Y", strtotime($date)) : date('d/m/Y') ?>">
                                                    </div>
                                                </div>
                                            </div> -->
                                        </li><!-- li -->
                                        <li class="btn-toolbar-sep d-none"></li><!-- li -->
                                        <!-- li -->
                                    </ul><!-- .btn-toolbar -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search"
                                            data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" id="invoice_input_search"
                                            class="form-control border-transparent form-focus-none"
                                            placeholder="Bulmak istediğiniz faturanın fatura ünvanını veya fatura numarasını yazınız...">
                                        <a href="#" class="btn btn-icon toggle-search" data-target="search"
                                            style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em
                                                class="icon ni ni-cross"></em></a>
                                        <button class="search-submit btn btn-icon" style="margin-right: 50px;"
                                            id="invoice_input_search_clear_button"
                                            name="invoice_input_search_clear_button"><em
                                                class="icon ni ni-trash"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div>

                        <div class="card-inner p-0">
                            <div class="card card-preview">
                                <table class="table table-tranx is-compact">
                                    <thead class="bg-light bg-opacity-75">
                                        <tr class="tb-tnx-head">
                                            <th class="tb-tnx-id">
                                                <span class="">#</span>
                                            </th>
                                            <th class="nk-tb-col"><span class="sub-text">FATURA TARİHİ </span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">FATURA NUMARASI</span></th>
                                            <th class="nk-tb-col tb-col-md" data-orderable="false"
                                                style="min-width:120px"><span class="sub-text">ÖDEME</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">FATURA UNVAN</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"
                                                style="min-width:120px"><span class="sub-text">FATURA TİPİ</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">ARA TOPLAM </span></th>
                                                    <?php if(session()->get('user_id') == 5): ?>
                                                    <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">İSK TOPLAM </span></th>
                                                    <?php endif; ?>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">KDV TOPLAM </span></th>
                                                  
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">GENEL TOPLAM </span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sira = 1;
                                        $genel_ara_toplam_gider = 0;
                                        $genel_kdv_toplam_gider = 0;
                                        $genel_toplam_gider = 0;
                                        $genel_iskonto_toplam_gider = 0;

                                        foreach ($gider_items as $gider_item) {
                                            $tax_1 = $gider_item['tax_rate_1_amount'];
                                            $tax_10 = $gider_item['tax_rate_10_amount']; 
                                            $tax_20 = $gider_item['tax_rate_20_amount'];
                                            $toplam_kdv = floatval($tax_1) + floatval($tax_10) + floatval($tax_20);

                                            $genel_ara_toplam_gider += floatval($gider_item['sub_total']);
                                            $genel_kdv_toplam_gider += $toplam_kdv;
                                            $genel_toplam_gider += floatval($gider_item['amount_to_be_paid']);
                                            $genel_iskonto_toplam_gider += floatval($gider_item['discount_total']);
                                            ?>
                                            <tr>
                                                <td><?= $sira ?></td>
                                                <td data-order="<?= $gider_item['gider_date'] ?>" title="<?= $gider_item['gider_date'] ?>">
                                                    <?= date("d/m/Y", strtotime($gider_item['gider_date'])) ?>
                                                </td>
                                                <td><?= $gider_item['gider_no'] ?? '-' ?></td>
                                                <td>
                                                    <span class="tb-lead">
                                                        <?php   if($gider_item["odeme_durumu"] == "odendi"){
                                                            echo "<span class='dot dot-success'></span> ÖDENDİ";
                                                        }else{
                                                            echo "<span class='dot dot-danger'></span> ÖDENMEDİ";
                                                        }
                                                        ?>
                                                    </span>
                                                </td>
                                                <td><?= $gider_item['cari_invoice_title'] ?? '-' ?></td>
                                                <td>Gider</td>
                                                <td>
                                                    <?= $gider_item['money_icon'] ?>
                                                    <?= number_format($gider_item['sub_total'], 2, ',', '.') ?? '-' ?>
                                                </td>
                                               
                                                <td>
                                                    <?= $gider_item['money_icon'] ?>
                                                    <?= number_format($genel_iskonto_toplam_gider, 2, ',', '.') ?? '-' ?>
                                                </td>
                                                <td>
                                                    <?= $gider_item['money_icon'] ?>
                                                    <?= number_format($toplam_kdv, 2, ',', '.') ?? '-' ?>
                                                </td>
                                                <td>
                                                    <?= $gider_item['money_icon'] ?>
                                                    <?= number_format($gider_item['amount_to_be_paid'], 2, ',', '.') ?? '-' ?>
                                                </td>
                                            </tr>
                                            <?php 
                                            $sira++;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <?php foreach ($gider_summary as $money_unit_id => $summary): ?>
                                        <tr>
                                            <td style="background-color: #f0f0f0; text-align:end" colspan="7">
                                                <b>TOPLAM (<?= $summary['money_icon'] ?>):</b>
                                            </td>
                                            <td style="background-color: #f0f0f0;">
                                                <b><?= number_format($summary['total_sub_total'], 2, ',', '.') ?> <?= $summary['money_icon'] ?></b>
                                            </td>
                                            <td style="background-color: #f0f0f0;">
                                                <b><?= number_format($summary['total_tax'], 2, ',', '.') ?> <?= $summary['money_icon'] ?></b>
                                            </td>
                                            <td style="background-color: #f0f0f0;">
                                                <b><?= number_format($summary['total_amount'], 2, ',', '.') ?> <?= $summary['money_icon'] ?></b>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                      
                                    </tfoot>
                                </table>
                            </div>



                        </div>

                    </div><!-- .card-inner-group -->
                </div><!-- .card -->



            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>

    $(".custom-control-input").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(document).ready(function () {

        var base_url = window.location.origin;

        var url = window.location.pathname;
        var parts = url.split('/');
        var lastPart = parts[parts.length - 1];

        var myVar = $("#DataTables_Table_0_wrapper").find('.with-export').removeClass('d-none');
        var myVar2 = $("#DataTables_Table_0_wrapper").find('.with-export').css("margin-bottom", "10px");



        $(function () {
            $("#report_date").datepicker({ dateFormat: "yy-mm-dd" });
            $("#report_date").on("change", function () {
                var selected_date = $(this).val();

                var parcalar = selected_date.split('/');
                var donusturulmusTarih = parcalar[2] + "-" + parcalar[1] + "-" + parcalar[0];

                console.log(donusturulmusTarih);

                var yeniSayfaURL = base_url + '/tportal/reports/daily_datatable/' + donusturulmusTarih;

                window.location.href = yeniSayfaURL;
            });
        });

    });
</script>

<?= $this->endSection() ?>