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
<style>
#DataTables_Table_0_filter, #DataTables_Table_0_length{
    display: none!important;
}

/* Sayısal değerler için monospace font */
.datatable-init_tahsilat td:nth-child(6),
.table td.text-end,
.table th.text-end,
tfoot td b,
.table td[style*="text-align: right"],
.table th[style*="text-align: right"] {
    font-family: monospace !important;
}

.datatable-init_tahsilat td,
.datatable-init_tahsilat th {
    white-space: nowrap;
    padding: 8px !important;
}

.datatable-init_tahsilat td:nth-child(5) {
    white-space: normal !important;
    min-width: 300px !important;
}

.datatable-init_tahsilat td:nth-child(6) {
    text-align: right !important;
}

.datatable-init_tahsilat th:nth-child(6) {
    text-align: right !important;
}

.datatable-init_tahsilat {
    width: 100% !important;
}

.datatable-init_tahsilat td {
    vertical-align: middle !important;
}


	
	
</style>
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
                    
                        <div class="card-tools me-n1" style="flex:1">
                            <ul class="btn-toolbar gx-1">
                                <li style="width:100%">
                                <div class="col-md-12">
                                            <div class="">
                                                <b>İşlem Tarihi Para Birimi ve Müşteri Seçiniz: </b>
                                            </div>
                                        </div>
                                    <div class="form-inline flex-nowrap gx-3">
                                        
                                        <div class="form-group col-md-5" style="margin-top:14px">
  <div class="form-control-wrap">
  <div class="form-icon form-icon-right">
                                                    <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                </div>
    <div class="input-daterange date-picker input-group">
      <input type="text" name="report_date" id="report_date" class="form-control" value="<?= isset ($date) ? date("d/m/Y", strtotime($date)) : date('d/m/Y') ?>"/>
      <div class="input-group-addon">İLE</div>
      <input type="text" name="report_date_end" id="report_date_end" class="form-control" value="<?= isset ($date2) ? date("d/m/Y", strtotime($date2)) : date('d/m/Y') ?>" />
    </div>
  </div>
</div>

<div class="form-group col-md-2" style="margin-top:14px">
<select class="form-select js-select2" id="fatura_senaryo" name="fatura_senaryo"  data-search="on" data-placeholder="Para Birimi Seçiniz">
<?php foreach ($para_birimleri as $money_unit_item) { ?>
                                                                <option value="<?= $money_unit_item['money_unit_id'] ?>" data-money-unit-code="<?= $money_unit_item['money_code'] ?>" data-money-unit-icon="<?= $money_unit_item['money_icon'] ?>" 
                                                                <?php if ($money_unit_item['default'] == 'true') { echo "selected"; }  ?>   
                                                                <?php if ($money_unit_item['money_unit_id'] ==  $currency) { echo "selected"; }  ?>   
                                                                >
                                                                    <?= $money_unit_item['money_code'] ?> -
                                                                    <?= $money_unit_item['money_title'] ?></option>
                                                            <?php } ?>
                                                        </select>
</div>

<div class="form-group col-md-2" style="margin-top:14px">
<select class="form-select js-select2" id="musteri_sec" name="musteri_sec"  data-search="on" data-placeholder="Müşteri  Seçiniz">
    <option value="0">Hepsi</option>
<?php foreach ($musteriler as $musteri) { ?>
                                                                <option   <?php if ($musteri['cari_id'] ==  $secilen_musteri) { echo "selected"; }  ?>   value="<?= $musteri['cari_id'] ?>"><?php echo $musteri['invoice_title'] ?? $musteri["name"]  . " " . $musteri["surname"] ?></option>
                                                            <?php } ?>
                                                        </select>
</div>

<div class="form-group" style="margin-top:5px">
<button type="button" class="btn btn-primary mb-2 btnNext" id="">Bul</button>

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
                                        <h5>Ödeme Raporları</h5>
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


                            <table class="table datatable-init_tahsilat" style="opacity: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 100px !important;"><span class="sub-text">TARİH</span></th>
                                                <th style="width: 180px !important;"><span class="sub-text">KASA</span></th>
                                                <th style="width: 200px !important;"><span class="sub-text">MÜŞTERİ</span></th>
                                                <th style="width: 120px !important;"><span class="sub-text">İŞLEM TÜRÜ</span></th>
                                                <th style="min-width: 300px !important;"><span class="sub-text">AÇIKLAMA</span></th>
                                                <th style="width: 120px !important;"><span class="sub-text">TUTAR</span></th>
                                                <th style="width: 100px !important;"><span class="sub-text">PARA BİRİMİ</span></th>
                                                <th style="width: 100px !important;"><span class="sub-text">YÖN</span></th>
                                                <th style="width: 80px !important;"><span class="sub-text">...</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $toplam_tutar = 0;
                                        foreach($financialMovements as $movement): ?>
                                            <tr>
                                                <td style="width: 100px !important;"><?php echo date('d/m/Y', strtotime($movement["transaction_date"])); ?></td>
                                                <td style="width: 180px !important;">
                                                    <span class="badge bg-secondary text-white">
                                                    <?php echo empty($movement["account_title"]) ? "Diğer" : $movement["account_title"]; ?>
                                                    </span>
                                                   
                                                </td>
                                                <td style="width: 200px !important;"><?php echo $movement["cari_invoice_title"]; ?></td>
                                                <td style="width: 120px !important;"><?php 
                                                    $type_class = '';
                                                    switch($movement["transaction_type"]) {
                                                        case 'payment':
                                                            $type_class = 'bg-primary'; // mavi
                                                            break;
                                                        case 'starting_balance':
                                                            $type_class = 'bg-purple'; // mor
                                                            break;
                                                        case 'borc_alacak':
                                                            $type_class = 'bg-warning'; // turuncu
                                                            break;
                                                        default:
                                                            $type_class = 'bg-secondary'; // gri
                                                    }
                                                    echo '<span class="badge ' . $type_class . ' text-white">' . $movement["transaction_type_tr"] . '</span>'; 
                                                ?></td>
                                                <td style="min-width: 300px !important;"><?php echo $movement["transaction_description"]; ?></td>
                                                <td style="width: 120px !important; text-align: right;"><?php echo number_format($movement["transaction_amount"], 2, ',', '.'); ?></td>
                                                <td style="width: 100px !important;"><?php echo $movement["money_code"]; ?></td>
                                                <td style="width: 100px !important;"><?php 
                                                    $direction_class = $movement["transaction_direction"] == 'entry' ? 'bg-success' : 'bg-danger';
                                                    echo '<span class="badge ' . $direction_class . ' text-white">' . $movement["transaction_direction_tr"] . '</span>'; 
                                                ?></td>
                                                <td style="width: 80px !important;">
                                                    <?php if($movement["transaction_type"] == "collection"): ?>
                                                        <a href="/tportal/cari/payment-or-collection/edit/<?php echo $movement['financial_movement_id']; ?>" class="btn btn-icon btn-xs btn-dim btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Görüntüle"><em class="icon ni ni-arrow-right"></em></a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                         <?php 
                                         $toplam_tutar += $movement["transaction_amount"];
                                         endforeach; ?>
                                        </tbody>
                                        <tfoot>
    <tr>
        <td style="background-color: #f0f0f0; text-align:end" colspan="6"><b>TOPLAM</b></td>
        <td style="background-color: #f0f0f0;text-align:end"><b><?php echo number_format($toplam_tutar, 2, ',', '.'); ?></b></td>
        <td style="background-color: #f0f0f0;text-align:center" colspan="2"></td>
    </tr>
</tfoot>
                                    </table>

                                    <!-- Özet Tabloları -->
                                    <div class="row mt-4">
                                        <!-- Para Birimi Bazlı Toplam -->
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="card-title mb-0">
                                                        Para Birimi Bazlı Toplam
                                                        <?php if(isset($date) && isset($date2)): 
                                                            $date1 = new DateTime($date);
                                                            $date2_obj = new DateTime($date2);
                                                            $interval = $date1->diff($date2_obj);
                                                            $days = $interval->days + 1;
                                                        ?>
                                                            <small class="text-muted">
                                                                (<?= date('d/m/Y', strtotime($date)) ?> - <?= date('d/m/Y', strtotime($date2)) ?>) - <?= $days ?> gün
                                                            </small>
                                                        <?php endif; ?>
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Para Birimi</th>
                                                                <th class="text-end">Toplam</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $paraBirimiToplam = [];
                                                            foreach($financialMovements as $movement) {
                                                                $moneyCode = $movement['money_code'];
                                                                if (!isset($paraBirimiToplam[$moneyCode])) {
                                                                    $paraBirimiToplam[$moneyCode] = 0;
                                                                }
                                                                $paraBirimiToplam[$moneyCode] += $movement['transaction_amount'];
                                                            }
                                                            foreach($paraBirimiToplam as $moneyCode => $total): ?>
                                                                <tr>
                                                                    <td><b><?php echo $moneyCode; ?></b></td>
                                                                    <td class="text-end"><?php echo number_format($total, 2, ',', '.'); ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Kasa Bazlı Toplam -->
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="card-title mb-0">
                                                        Kasa Bazlı Toplam
                                                        <?php if(isset($date) && isset($date2)): 
                                                            $date1 = new DateTime($date);
                                                            $date2_obj = new DateTime($date2);
                                                            $interval = $date1->diff($date2_obj);
                                                            $days = $interval->days + 1;
                                                        ?>
                                                            <small class="text-muted">
                                                                (<?= date('d/m/Y', strtotime($date)) ?> - <?= date('d/m/Y', strtotime($date2)) ?>) - <?= $days ?> gün
                                                            </small>
                                                        <?php endif; ?>
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Kasa</th>
                                                                <th>Para Birimi</th>
                                                                <th class="text-end">Toplam</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $kasaToplam = [];
                                                            foreach($financialMovements as $movement) {
                                                                $accountTitle = empty($movement['account_title']) ? "Diğer" : $movement['account_title'];
                                                                $key = $accountTitle . '_' . $movement['money_code'];
                                                                if (!isset($kasaToplam[$key])) {
                                                                    $kasaToplam[$key] = [
                                                                        'title' => $accountTitle,
                                                                        'money_code' => $movement['money_code'],
                                                                        'total' => 0
                                                                    ];  
                                                                }
                                                                $kasaToplam[$key]['total'] += $movement['transaction_amount'];
                                                            }
                                                            foreach($kasaToplam as $kasa): ?>
                                                                <tr>
                                                                    <td><b><?php echo $kasa['title']; ?></b></td>
                                                                    <td><?php echo $kasa['money_code']; ?></td>
                                                                    <td class="text-end"><?php echo number_format($kasa['total'], 2, ',', '.'); ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Özet Tabloları Son -->



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
window.addEventListener('load', function() {
    var base_url = window.location.origin;
    
    // DataTable'ı başlatmadan önce tablo yapısının hazır olmasını bekle
    var initDataTable = function() {
        if (typeof $.fn.DataTable !== 'undefined' && typeof NioApp !== 'undefined') {
            if ($.fn.DataTable.isDataTable('.datatable-init_tahsilat')) {
                $('.datatable-init_tahsilat').DataTable().destroy();
            }
            
            var tableSettings = {
                bFilter: true,
                bLengthChange: true,
                pageLength: 15,
                lengthMenu: [[15, 50, 100, -1], [15, 50, 100, "Tümü"]],
                language: {
                    search: "Ara:",
                    lengthMenu: "_MENU_ kayıt göster",
                    info: "_TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
                    infoEmpty: "Kayıt bulunamadı",
                    infoFiltered: "(_MAX_ kayıt içerisinden)",
                    paginate: {
                        first: "İlk",
                        last: "Son",
                        next: "Sonraki",
                        previous: "Önceki"
                    }
                },
                order: [[0, "desc"]],
                columnDefs: [
                    { 
                        targets: 3,
                        width: "300px"
                    }
                ],
                dom: '<"row justify-between g-2"<"col-7 col-sm-6 text-start"f><"col-5 col-sm-6 text-end"l>>t<"row align-items-center"<"col-7 col-sm-12 col-md-9"p><"col-5 col-sm-12 col-md-3 text-start text-md-end"i>>'
            };

            try {
                var dataTable = $('.datatable-init_tahsilat').DataTable(tableSettings);
                
                // Tablo yüklendikten sonra görünür yap
                $('.datatable-init_tahsilat').css('opacity', '1');
            } catch (error) {
                console.error('DataTable başlatma hatası:', error);
            }
        } else {
            setTimeout(initDataTable, 100);
        }
    };

    // İlk çağrı
    initDataTable();

    // Tarih seçici ayarları
    $('.input-daterange').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        autoclose: true,
        language: 'tr'
    });

    $('#report_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $('#report_date_end').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $('#report_date').on('change', function () {
        var startDate = $(this).datepicker('getDate');
        var endDate = $('#report_date_end').datepicker('getDate');

        if (endDate && startDate > endDate) {
            $('#date_error').show();
            $('#report_date_end').val('');
        } else {
            $('#date_error').hide();
        }
        $('#report_date_end').focus();
    });

    $('#report_date_end').on('change', function () {
        var startDate = $('#report_date').datepicker('getDate');
        var endDate = $(this).datepicker('getDate');

        if (startDate && endDate < startDate) {
            $('#date_error').show();
        } else {
            $('#date_error').hide();
        }
    });

    $('.btnNext').on('click', function () {
        var startDate = $('#report_date').val();
        var endDate = $('#report_date_end').val();
        var currency = $('#fatura_senaryo').val();
        var musteri = $('#musteri_sec').val();
        
        if (!startDate || !endDate || !currency) {
            alert('Lütfen tüm alanları doldurun.');
            return;
        }

        var startDateFormatted = startDate.split('/').reverse().join('-');
        var endDateFormatted = endDate.split('/').reverse().join('-');

        var newPageURL = base_url + '/tportal/reports/detayli-tahsilat-raporlarim/' + startDateFormatted + '/' + endDateFormatted + '/' + currency + '/' + musteri;

        window.location.href = newPageURL;
    });
});
</script>

<?= $this->endSection() ?>