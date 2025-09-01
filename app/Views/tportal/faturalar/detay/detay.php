<?php
    $detail_text = $invoice_item['is_quick_sale_receipt'] == 1 && $invoice_item['invoice_direction'] == 'outgoing_invoice' ? 'Satış Fişi' : 'Fatura' ;
?>

<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> <?= $detail_text ?> Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> <?= $detail_text ?> Detay | <?= $invoice_item['invoice_no'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>



<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="invoice">
                    <!-- <div class="invoice-action">
                        <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" href="/demo9/invoice-print.html" target="_blank"><em class="icon ni ni-printer-fill"></em></a>
                    </div> -->
                    <div class="card invoice-wrap">
                        <div class="invoice-head" style="">
                            <div class="invoice-contact"><span class="overline-title"><?= $invoice_item['invoice_no'] ?></span>
                                <div class="invoice-contact-info">
                                    <h4 class="title"><?= $invoice_item['cari_invoice_title'] ?></h4>
                                    <ul class="list-plain">
                                        <?= $invoice_item['address'] != '' ? '<li><em class="icon ni ni-map-pin-fill"></em><span>' . $invoice_item['address'] . '</span></li>' : ''; ?>
                                        <?= $invoice_item['cari_phone'] != '' ? '<li><em class="icon ni ni-call-fill"></em><span>' . $invoice_item['cari_phone'] . '</span></li>' : ''; ?>
                                        <?= $invoice_item['cari_email'] != '' ? '<li><em class="icon ni ni-mail-fill"></em><span>' . $invoice_item['cari_email'] . '</span></li>' : ''; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="invoice-desc" style="min-width: 300px;">

                            


                                <h4 class="title text-<?= $invoice_item['status_info'] ?>"><?= $invoice_item['status_name'] ?></h4>
                               
                             
                                <ul class="list-plain">
                                    <li class="invoice-id"><?= $invoice_item['invoice_ettn'] ?></li>
                                    <li class="invoice-id"><span>Fatura Senaryo</span>:<span><?= $invoice_item['invoice_scenario'] ?></span></li>
                                    <?php 
                                    
                                    $invoice_typelist = [
                                        [
                                            "invoice_type" => "incoming_invoice",
                                            "invoice_scenario_text" => "ALIŞ"
                                        ],
                                        [
                                            "invoice_type" => "SATIS",
                                            "invoice_scenario_text" => "SATIŞ"
                                        ],
                                        [
                                            "invoice_type" => "IADE",
                                            "invoice_scenario_text" => "İADE"
                                        ],
                                        [
                                            "invoice_type" => "TEVKIFAT",
                                            "invoice_scenario_text" => "TEVKİFAT"
                                        ],
                                        [
                                            "invoice_type" => "ISTISNA",
                                            "invoice_scenario_text" => "İSTİSNA"
                                        ],
                                        [
                                            "invoice_type" => "IADEISTISNA",
                                            "invoice_scenario_text" => "İADE İSTİSNA"
                                        ],
                                        [
                                            "invoice_type" => "OZELMATRAH",
                                            "invoice_scenario_text" => "ÖZEL MATRAH"
                                        ],
                                        [
                                            "invoice_type" => "IHRACKAYITLI",
                                            "invoice_scenario_text" => "İHRACAT KAYITLI"
                                        ]
                                    ];
            
                                    // Fatura tipini bul
                                    $invoice_type_text = "Belirsiz";
                                    foreach($invoice_typelist as $type) {
                                        if($type["invoice_type"] === $invoice_item["invoice_type"]) {
                                            $invoice_type_text = $type["invoice_scenario_text"];
                                            break;
                                        }
                                    }
                                    ?>
                                    <li class="invoice-id"><span>Fatura Tipi</span>:<span><?= $invoice_type_text ?></span></li>
                                    <li class="invoice-id"><span>Fatura No</span>:<span><?= $invoice_item['invoice_no'] ?></span></li>
                                    <li class="invoice-date"><span>Fatura Tarihi</span>:<span><?= $invoice_item['invoice_date'] ?></span></li>
                                    <?php if($invoice_item['payment_method'] != '') : ?>
                                    <li class="invoice-date"><span>Vade Tarihi</span>:<span><?= $invoice_item['expiry_date'] ?></span></li>
                                    
                                   
                                    <?php endif; ?>
                                    <li class="invoice-date"><span>Ödeme Durumu</span>:<?= $invoice_item["is_quick_collection_financial_movement_id"] == 0 ? "<span style='padding-left:0px;' class='dot dot-danger ms-1'></span> Ödenmedi" : " <span style='padding-left:0px;' class='dot dot-success ms-1'></span> Ödendi" ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="invoice-bills">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="w-10">Açıklama</th>
                                            <th class="text-right">Birim Fiyatı</th>
                                            <th class="text-right">Miktar</th>
                                            <th class="text-right">İskonto</th>
                                            <th class="text-right">Ara Toplam</th>
                                            <th class="text-right">KDV</th>
                                            <?php if ($invoice_item['invoice_type'] == 'TEVKIFAT') {
                                                echo '<th class="text-right">Tev. Oran</th>' .
                                                    '<th class="text-right">Tev. Tutar</th>';
                                            } ?>
                                            <th>Toplam</th>
                                        </tr>
                                    </thead>
                                    <tbody id="fatura_satirlar">

                                        <?php
                                        if ($invoice_item['invoice_type'] == 'IHRACAT') $colspan = 10;
                                        else if ($invoice_item['invoice_type'] == 'TEVKIFAT') $colspan = 6;
                                        else if ($invoice_item['invoice_type'] == 'OZELMATRAH') $colspan = 5;
                                        else $colspan = 4;

                                        foreach ($invoice_rows as $invoice_row) { ?>
                                            <tr class="" id="Satir_<?= $invoice_row['invoice_row_id'] ?>">
                                                <td id="txt_aciklama_<?= $invoice_row['invoice_row_id'] ?>">
                                                    <strong><?= $invoice_row['stock_title'] ?><br></strong><?= $invoice_row['stock_code'] ?? '' ?>
                                                </td>
                                                <td id="txt_birimfiyat_<?= $invoice_row['invoice_row_id'] ?>" class="text-right"><?= number_format($invoice_row['unit_price'], session()->get('user_item')['para_yuvarlama'], ',', '.') ?> <?= $invoice_item['money_icon'] ?></td>
                                                <td id="txt_miktar_birim_<?= $invoice_row['invoice_row_id'] ?>" class="text-right"><?= number_format($invoice_row['stock_amount'], 2, ',', '.') ?> <?= $invoice_row['unit_title'] ?></td>
                                                <td id="txt_iskonto_<?= $invoice_row['invoice_row_id'] ?>" class="text-right"><?= number_format($invoice_row['discount_price'], 2, ',', '.') ?> <?= $invoice_item['money_icon'] ?> (%<?= $invoice_row['discount_rate'] ?>)</td>
                                                <td id="txt_ara_toplam_<?= $invoice_row['invoice_row_id'] ?>" class="text-right"><?= number_format($invoice_row['subtotal_price'], 2, ',', '.') ?> <?= $invoice_item['money_icon'] ?></td>


                                                <td id="txt_kdv_<?= $invoice_row['invoice_row_id'] ?>" class="text-right"><?= number_format($invoice_row['tax_price'], 2, ',', '.') ?> <?= $invoice_item['money_icon'] ?> (%<?= $invoice_row['tax_id'] ?>)</td>
                                                <?php if ($invoice_item['invoice_type'] == 'TEVKIFAT') {
                                                    echo '<td id="txt_tevkifat_oran_" class="text-right"> %' . number_format($invoice_row['withholding_rate'], 2, ',', '.') . '</td>' .
                                                        '<td id="txt_tevkifat_tutar_" class="text-right"> ' . number_format($invoice_row['withholding_price'], 2, ',', '.') . ' ' . $invoice_item['money_icon'] . '</td>';
                                                } ?>
                                                <td id="txt_genel_toplam_<?= $invoice_row['invoice_row_id'] ?>" class="text-right"><?= number_format($invoice_row['total_price'], 2, ',', '.') ?> <?= $invoice_item['money_icon'] ?></td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td colspan="<?= $colspan ?>"></td>
                                            <td colspan="2">Mal/Hizmet Toplam</td>
                                            <td class="text-right" id="txt_kdvsiz_toplam"><?= number_format($invoice_item['stock_total'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></td>
                                        </tr>

                                        <?php

                                        if ($invoice_item['stock_total_try'] != 0) {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2"></td>' .
                                                '<td class="text-right" id="txt_kdvsiz_toplam">' . number_format($invoice_item["stock_total_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        }
                                        ?>


                                        <tr>
                                            <td colspan="<?= $colspan ?>"></td>
                                            <td colspan="2">İskonto</td>
                                            <td class="text-right" id="txt_iskonto_toplam"><?= number_format($invoice_item['discount_total'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></td>
                                        </tr>
                                        <?php
                                        if ($invoice_item['discount_total_try'] != 0) {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2"></td>' .
                                                '<td class="text-right" id="txt_iskonto_toplam_dvz">' . number_format($invoice_item["discount_total_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        }
                                        ?>

                                        <tr>
                                            <td colspan="<?= $colspan ?>"></td>
                                            <td colspan="2">Ara Toplam</td>
                                            <td class="text-right" id="txt_ara_toplam"><?= number_format($invoice_item['sub_total'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></td>
                                        </tr>
                                        <?php
                                        if ($invoice_item['sub_total_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2"></td>' .
                                                '<td class="text-right" id="txt_ara_toplam_dvz">' . number_format($invoice_item["sub_total_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['tax_rate_1_amount'] != 0) {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2">KDV Toplam (%1)</td>' .
                                                '<td class="text-right" id="txt_kdv_toplam1">' . number_format($invoice_item["tax_rate_1_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['tax_rate_1_amount_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2"></td>' .
                                                '<td class="text-right" id="txt_kdv_toplam1_dvz">' . number_format($invoice_item["tax_rate_1_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['tax_rate_10_amount'] != 0) {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2">KDV Toplam (%10)</td>' .
                                                '<td class="text-right" id="txt_kdv_toplam10">' . number_format($invoice_item["tax_rate_10_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['tax_rate_10_amount_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2"></td>' .
                                                '<td class="text-right" id="txt_kdv_toplam10_dvz">' . number_format($invoice_item["tax_rate_10_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['tax_rate_20_amount'] != 0) {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2">KDV Toplam (%20)</td>' .
                                                '<td class="text-right" id="txt_kdv_toplam20">' . number_format($invoice_item["tax_rate_20_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['tax_rate_20_amount_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2"></td>' .
                                                '<td class="text-right" id="txt_kdv_toplam20_dvz">' . number_format($invoice_item["tax_rate_20_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['transaction_subject_to_withholding_amount'] != 0) {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2">Tevkifata Tabi İşlem Tutar</td>' .
                                                '<td class="text-right" id="txt_V9015_islem_tutar">' . number_format($invoice_item["transaction_subject_to_withholding_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['transaction_subject_to_withholding_amount_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2"></td>' .
                                                '<td class="text-right" id="txt_V9015_islem_tutar_dvz">' . number_format($invoice_item["transaction_subject_to_withholding_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['transaction_subject_to_withholding_calculated_tax'] != 0) {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2">Tevkifata Tabi İşlem Hes. Kdv.</td>' .
                                                '<td class="text-right" id="txt_V9015_hesaplanan_kdv">' . number_format($invoice_item["transaction_subject_to_withholding_calculated_tax"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['transaction_subject_to_withholding_calculated_tax_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2"></td>' .
                                                '<td class="text-right" id="txt_V9015_hesaplanan_kdv_dvz">' . number_format($invoice_item["transaction_subject_to_withholding_calculated_tax_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['withholding_tax'] != 0) {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2">KDV Tevkifat</td>' .
                                                '<td class="text-right" id="txt_V9015">' . number_format($invoice_item["withholding_tax"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['withholding_tax_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2"></td>' .
                                                '<td class="text-right" id="txt_V9015_dvz">' . number_format($invoice_item["withholding_tax_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        }

                                        ?>
                                        <tr>
                                            <td colspan="<?= $colspan ?>"></td>
                                            <td colspan="2"><strong>Genel Toplam</strong></td>
                                            <td class="text-right" id="txt_genel_toplam"><strong><?= number_format($invoice_item['grand_total'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></strong></td>
                                        </tr>
                                        <?php
                                        if ($invoice_item['grand_total_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2"></td>' .
                                                '<td class="text-right" id="txt_genel_toplam_dvz">' . number_format($invoice_item["grand_total_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        } ?>
<?php if(isset($Kurlar)): foreach($Kurlar as $kur){ 
                                                if($invoice_item['money_unit_id'] != $kur["kur"]):
                                            ?>
                                            <tr>
                                            <td colspan="<?= $colspan ?>"></td>
                                            <td colspan="2"><strong><?php echo $kur["money_code"] ?></strong></td>
                                            <td class="text-right" id="txt_odenecek_toplam"><strong><?= number_format($kur['toplam_tutar'], 2, ',', '.') ?> <?= $kur['money_code'] ?></strong></td>
                                        </tr>

                                       
                                            
                                            
                                        <?php endif; } endif;?>
                                        
                                        <tr>
                                            <td colspan="<?= $colspan ?>"></td>
                                            <td colspan="2"><strong>Ödenecek Toplam</strong></td>
                                            <td class="text-right" id="txt_odenecek_toplam"><strong><?= number_format($invoice_item['amount_to_be_paid'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></strong></td>
                                        </tr>
                                        <?php
                                        if ($invoice_item['amount_to_be_paid_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2"></td>' .
                                                '<td class="text-right" id="txt_odenecek_toplam_dvz">' . number_format($invoice_item["amount_to_be_paid_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        } ?>
                                    </tfoot>
                                </table>
                                <hr>
                                <div class="invoice-desc w-100" style="display: flex; justify-content:space-between; align-items:center;">
                                    <div>
                                        <span>Fatura Not</span>:
                                        <ul class="list-plain">
                                            <li class="invoice-date">
                                                <span><?= $invoice_item['amount_to_be_paid_text'] ?></span>
                                            </li>

                                            <?php
                                            if ($invoice_item['currency_amount'] != 0) {
                                                echo '<li class="invoice-date">' .
                                                    '<span>Döviz Kur Bilgisi:' . number_format($invoice_item['currency_amount'], 2, ',', '.') . ' </span>' .
                                                    '</li>';
                                            }

                                            if ($invoice_item['is_quick_collection_financial_movement_id'] != 0) {
                                                echo '<li class="invoice-date">' .
                                                    '<span>Tahsilatlı fatura </span>' .
                                                    '</li>';
                                            } ?>

                                            <li class="invoice-date">
                                                <!-- <span>Fatura Not</span>: -->
                                                <span style="text-transform:initial;"><?= $invoice_item['invoice_note'] ?></span>
                                            </li>

                                            <li class="invoice-date">

                                                <span style="text-transform: capitalize;">

                                                    <?php if ($invoice_item['invoice_type'] == 'TEVKIFAT') {
                                                        echo 'Fatura Tevkifat Bilgileri:<br>';
                                                        $withholdingItems = session()->get('withholding_items');

                                                        foreach ($invoice_rows as $invoice_row) {
                                                            $withholdingId = $invoice_row['withholding_id'];
                                                            $matchingItem = null;

                                                            foreach ($withholdingItems as $item) {
                                                                if ($item['withholding_code'] == $withholdingId) {
                                                                    $matchingItem = $item;
                                                                    break;
                                                                }
                                                            }

                                                            if ($matchingItem !== null) echo $matchingItem['withholding_code'] . " | %" . $matchingItem['withholding_value'] . " | " . $matchingItem['withholding_name'] . "<br>";
                                                        }
                                                    }
                                                    ?>

                                                </span>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- #TODO burası modal yapısına çevirilebilir... -->
                                    <div>
                                        <?php if($invoice_item['tiko_imza'] == 0): ?>
                                            <div class="mt-1"><a href="<?= route_to('tportal.faturalar.edit', $invoice_item['invoice_id']) ?>" class="btn btn-warning btn-block"><em class="icon ni ni-edit"></em><span><?= $detail_text ?> Düzenle</span></a></div>
                                        <?php else: ?>
                                            <div class="mt-1"><button disabled class="btn btn-warning btn-block"><em class="icon ni ni-edit"></em><span><?= $detail_text ?> Düzenle</span></button></div>
                                        <?php endif; ?>
                                  
                                        <?php if($invoice_item['tiko_imza'] == 0 ): ?>
                                        <div class="mt-1"><button class="btn btn-danger btn-block" data-invoice-id="<?= $invoice_item['invoice_id'] ?>" id="btnDeleteInvoice"><em class="icon ni ni-edit"></em><span><?= $detail_text ?> Sil</span></button></div>
                                        <?php else: ?> 
                                            <div class="mt-1"><button disabled class="btn btn-danger btn-block"><em class="icon ni ni-edit"></em><span><?= $detail_text ?> Sil</span></button></div>
                                        <?php endif; ?>
                                       
                                        <?php if($invoice_item['tiko_imza'] == 0 ): ?>
                                            <?php if($invoice_item["invoice_direction"] != "incoming_invoice"): ?>
                                        <div class="mt-1"><button class="btn btn-success btn-block" id="btnImzala" data-invoice-id="<?= $invoice_item['invoice_id'] ?>"><em class="icon ni ni-pen"></em><span><?= $detail_text ?> İmzala</span></button></div>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        <div class="mt-1"><button class="btn btn-primary btn-block" disabled><em class="icon ni ni-copy"></em><span><?= $detail_text ?> Çoğalt</span></a></button></div>

                                        <?php
                                            if ($invoice_item['is_quick_sale_receipt'] == 1 || $invoice_item['sale_type'] == 'quick' ) {
                                                echo '<div class="mt-1"><a href= '.route_to('tportal.faturalar.quickSalePrint', $invoice_item['invoice_id']) .'" target="_blank" class="btn btn-dark btn-block"><em class="icon ni ni-printer"></em><span>Satış Fişi Yazdır</span></a></div>';
                                            }
                                        ?>

                                        <?php if($invoice_item['tiko_imza'] == 1 && $invoice_item['tiko_id'] != null): ?>
                                            <div class="dropdown mt-1">
    <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
        <em class="icon ni ni-send me-2"></em>
        <span>Fatura İşlemleri</span>
        <em class="icon ni ni-chevron-down ms-2"></em>
    </button>
    <div class="dropdown-menu dropdown-menu-end" style="min-width: 240px;">
        <div class="dropdown-inner">
            <div class="link-list-opt">
          
                <a href="#" class="link-option" id="btnViewPDF" data-pdf-url="<?= $invoice_item['tiko_pdf'] ?>">
                    <em class="icon ni ni-file-pdf text-danger"></em>
                    <span>PDF Görüntüle</span>
                </a>
         

       
                <a href="#" class="link-option" id="btnViewHTML" data-html-url="<?= $invoice_item['tiko_html'] ?>">
                    <em class="icon ni ni-html5 text-warning"></em>
                    <span>HTML Görüntüle</span>
                </a>
             

         
                <a href="#" class="link-option" id="btnDownloadXML" data-xml-url="<?= $invoice_item['tiko_xml'] ?>">
                    <em class="icon ni ni-file-code text-info"></em>
                    <span>XML İndir</span>
                </a>
               
                
                <div class="dropdown-divider"></div>

                <a href="#" class="link-option" id="btnSendMail" data-invoice-id="<?= $invoice_item['tiko_id'] ?>" data-invoice-email="<?= $invoice_item['cari_email'] ?>">
                    <em class="icon ni ni-mail text-primary"></em>
                    <span>Mail Gönder</span>
                </a>
            </div>
        </div>
    </div>
</div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>


                        
                    </div>
                </div>
            </div>
        <?php if(isset($invoiceLoglar)){ ?> 
            <div class="nk-block nk-block-lg">
              <div class="nk-block-head">
                <div class="nk-block-head-content">
                  <h4 class="nk-block-title">Fatura İşlemleri</h4>
                  <p>Burada bu fatura üzerindeki son işlemleri görebilirsiniz.</p>
                </div>
              </div>
              <div class="card card-preview">
                <table class="table table-ulogs">
                  <thead class="bg-light bg-opacity-75">
                    <tr>
                    <th class="tb-col-os">
                        <span class="overline-title">AKTİVİTE</span>
                      </th>
                      <th class="tb-col-os">
                        <span class="overline-title">İŞLEM</span>
                      </th>
                      <th class="tb-col-os">
                        <span class="overline-title">KULLLANICI</span>
                      </th>
                      <th class="tb-col-os">
                        <span class="overline-title">TARAYICI</span>
                      </th>
                      <th class="tb-col-ip">
                        <span class="overline-title">IP</span>
                      </th>
                      <th class="tb-col-time">
                        <span class="overline-title">ZAMAN</span>
                      </th>
                      <th class="tb-col-action">
                        <span class="overline-title">&nbsp;</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($invoiceLoglar as $log){ ?> 
                    
                        <tr>
                      <td class="tb-col-os"><?php echo $log["log_mesaj"] ?></td>
                      <td class="tb-col-os"><?php
                        if($log["log_islem"] == "fatura"){
                            echo '<span class="tb-odr-status"><span class="badge badge-dot bg-primary">FATURA</span></span>';
                        }else if($log["log_islem"] == "odeme"){
                            echo '<span class="tb-odr-status"><span class="badge badge-dot bg-success">TAHSİLAT</span></span>';
                        }else{
                            "İşlem";
                        }

                      ?></td>
                       <td class="tb-col-os"><?php echo $log["islemi_yapan"] ?></td>
                      <td class="tb-col-os"><?php echo $log["isletim_sistemi"] ?></td>
                      <td class="tb-col-ip">
                        <span class="sub-text"><?php echo $log["ip"] ?></span>
                      </td>
                      <td class="tb-col-time">
                        <span class="sub-text">
                        <?php 
                        setlocale(LC_TIME, 'tr_TR.UTF-8');
                        echo strftime('%d %B %Y %H:%M:%S', strtotime($log["created_at"]));
                        ?>
                         </span>
                      </td>
                      <td class="tb-col-action"></td>
                    </tr>

                    <?php } ?>
                    
                  </tbody>
                </table>
              </div>
            </div>
            <?php } ?>

        </div>

        <?= $this->endSection() ?>

        <?= $this->section('script') ?>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $('document').ready(function () {
                var myVar = $("#DataTables_Table_1_wrapper").find('.with-export').removeClass('d-none');
                var myVar2 = $("#DataTables_Table_1_wrapper").find('.with-export').css("margin-bottom", "10px");
                var base_url = window.location.origin;

                $(document).on("click", "#btnDeleteInvoice", function () {
                    var invoice_id = $(this).attr('data-invoice-id');
                    console.log(invoice_id);


                    Swal.fire({
                            title: '<?= $detail_text ?> silmek üzeresiniz!',
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
                                                    html: '<?= $detail_text ?> silme işlemi başarıyla gerçekleşti.',
                                                    confirmButtonText: "Tamam",
                                                    allowEscapeKey: false,
                                                    allowOutsideClick: false,
                                                    icon: "success",
                                                })
                                                .then(function() {
                                                    (window.history.length > 1) ? window.history.back() : window.location.href = base_url+"/tportal/invoice/list/all";
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

                // İmzalama butonu için SweetAlert2
                $(document).on('click', '#btnImzala', function() {
                    var invoice_id = $(this).data('invoice-id');
                    
                    Swal.fire({
                        title: '<div class="modal-icon-wrapper">' +
                               '<div class="modal-icon modal-icon-primary pulse-primary">' +
                               '<i class="ni ni-file-text"></i>' +
                               '</div></div>' +
                               '<h2 class="modal-title">Fatura İmzalama</h2>',
                        html: '<div class="modal-description">' +
                              'Faturayı imzaya göndermek istediğinizden emin misiniz?' +
                              '</div>',
                        showCancelButton: true,
                        confirmButtonText: '<i class="ni ni-check"></i> Evet, Gönder',
                        cancelButtonText: '<i class="ni ni-cross"></i> İptal',
                        customClass: {
                            popup: 'modal-popup',
                            confirmButton: 'modal-btn modal-btn-success',
                            cancelButton: 'modal-btn modal-btn-light'
                        },
                        buttonsStyling: false,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown animate__faster'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp animate__faster'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: base_url + '/api/tikoportal/fatura/imzala/' + invoice_id,
                                async: true,
                                beforeSend: function() {
                                    Swal.fire({
                                        title: '<div class="modal-icon-wrapper">' +
                                               '<div class="modal-icon modal-icon-primary loading">' +
                                               '<i class="ni ni-loader"></i>' +
                                               '</div></div>' +
                                               '<h2 class="modal-title">İşleminiz Gerçekleştiriliyor</h2>',
                                        html: '<div class="modal-description">Lütfen bekleyiniz...</div>',
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                        customClass: {
                                            popup: 'modal-popup'
                                        }
                                    });
                                },
                                success: function(response) {
                                    Swal.fire({
                                        title: '<div class="modal-icon-wrapper">' +
                                               '<div class="modal-icon modal-icon-success pulse-success">' +
                                               '<i class="ni ni-check-circle-fill"></i>' +
                                               '</div></div>' +
                                               '<h2 class="modal-title">Başarılı!</h2>',
                                        html: '<div class="modal-description">' +
                                              '<p>Faturanız başarıyla imzaya gönderildi.</p>' +
                                              '<div class="modal-info">' +
                                              '<i class="ni ni-info"></i>' +
                                              '<span>Faturanız tikoportal.com adresinde taslak olarak oluşturulmuştur.</span>' +
                                              '</div>' +
                                              '</div>',
                                        confirmButtonText: '<i class="ni ni-check"></i> Tamam',
                                        customClass: {
                                            popup: 'modal-popup',
                                            confirmButton: 'modal-btn modal-btn-success'
                                        },
                                        buttonsStyling: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                },
                                error: function() {
                                    Swal.fire({
                                        title: '<div class="modal-icon-wrapper">' +
                                               '<div class="modal-icon modal-icon-error pulse-error">' +
                                               '<i class="ni ni-cross-circle-fill"></i>' +
                                               '</div></div>' +
                                               '<h2 class="modal-title">Hata!</h2>',
                                        html: '<div class="modal-description">İşlem sırasında bir hata oluştu.</div>',
                                        confirmButtonText: '<i class="ni ni-check"></i> Tamam',
                                        customClass: {
                                            popup: 'modal-popup',
                                            confirmButton: 'modal-btn modal-btn-error'
                                        },
                                        buttonsStyling: false
                                    });
                                }
                            });
                        }
                    });
                });

                // PDF Görüntüleme
                $('#btnViewPDF').on('click', function(e) {
                    e.preventDefault();
                    const pdfUrl = $(this).data('pdf-url');
                    
                    if (!pdfUrl) {
                        Swal.fire({
                            title: '<div class="modal-icon-wrapper">' +
                                   '<div class="modal-icon modal-icon-info">' +
                                   '<i class="ni ni-info-fill"></i>' +
                                   '</div></div>' +
                                   '<h2 class="modal-title">Bilgi</h2>',
                            html: '<div class="modal-description">PDF dosyası henüz hazırlanıyor...</div>',
                            customClass: {
                                popup: 'modal-popup',
                                confirmButton: 'modal-btn modal-btn-info'
                            },
                            buttonsStyling: false
                        });
                        return;
                    }
                    window.open(pdfUrl, '_blank');
                });

                // HTML Görüntüleme
                $('#btnViewHTML').on('click', function(e) {
                    e.preventDefault();
                    const htmlUrl = $(this).data('html-url');
                    
                    if (!htmlUrl) {
                        Swal.fire({
                            title: '<div class="modal-icon-wrapper">' +
                                   '<div class="modal-icon modal-icon-info">' +
                                   '<i class="ni ni-info-fill"></i>' +
                                   '</div></div>' +
                                   '<h2 class="modal-title">Bilgi</h2>',
                            html: '<div class="modal-description">HTML görüntüsü henüz hazırlanıyor...</div>',
                            customClass: {
                                popup: 'modal-popup',
                                confirmButton: 'modal-btn modal-btn-info'
                            },
                            buttonsStyling: false
                        });
                        return;
                    }
                    window.open(htmlUrl, '_blank');
                });

                // XML İndirme
                $('#btnDownloadXML').on('click', function(e) {
                    e.preventDefault();
                    const xmlUrl = $(this).data('xml-url');
                    
                    if (!xmlUrl) {
                        Swal.fire({
                            title: '<div class="modal-icon-wrapper">' +
                                   '<div class="modal-icon modal-icon-info">' +
                                   '<i class="ni ni-info-fill"></i>' +
                                   '</div></div>' +
                                   '<h2 class="modal-title">Bilgi</h2>',
                            html: '<div class="modal-description">XML dosyası henüz hazırlanıyor...</div>',
                            customClass: {
                                popup: 'modal-popup',
                                confirmButton: 'modal-btn modal-btn-info'
                            },
                            buttonsStyling: false
                        });
                        return;
                    }
                    window.open(xmlUrl, '_blank');
                });

                // Mail Gönderme
                $('#btnSendMail').on('click', function(e) {
                    e.preventDefault();
                    const invoiceId = $(this).data('invoice-id');
                    const defaultEmail = $(this).data('invoice-email');
                    
                    Swal.fire({
                        title: '<div class="modal-icon-wrapper">' +
                               '<div class="modal-icon modal-icon-primary">' +
                               '<i class="ni ni-mail"></i>' +
                               '</div></div>' +
                               '<h2 class="modal-title">Fatura Gönderimi</h2>',
                        html: `<div class="modal-description mb-3">
                                Faturayı hangi mail adresine göndermek istiyorsunuz?
                               </div>
                               <div class="form-group">
                                 <div class="form-control-wrap">
                                   <div class="input-group">
                                     <input type="email" class="form-control form-control-lg" 
                                            id="mailInput" value="${defaultEmail}" 
                                            placeholder="E-posta adresi giriniz">
                                     <div class="input-group-append">
                                       <span class="input-group-text"><em class="ni ni-mail"></em></span>
                                     </div>
                                   </div>
                                 </div>
                               </div>`,
                        showCancelButton: true,
                        confirmButtonText: '<i class="ni ni-check"></i> Gönder',
                        cancelButtonText: '<i class="ni ni-cross"></i> İptal',
                        customClass: {
                            popup: 'modal-popup',
                            confirmButton: 'modal-btn modal-btn-success',
                            cancelButton: 'modal-btn modal-btn-light'
                        },
                        buttonsStyling: false,
                        preConfirm: () => {
                            const email = document.getElementById('mailInput').value;
                            if (!email) {
                                Swal.showValidationMessage('Lütfen bir e-posta adresi giriniz');
                                return false;
                            }
                            if (!/\S+@\S+\.\S+/.test(email)) {
                                Swal.showValidationMessage('Lütfen geçerli bir e-posta adresi giriniz');
                                return false;
                            }
                            return email;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const emailToSend = result.value;
                            $.ajax({
                                type: "GET",
                                url: 'http://127.0.0.1:8000/erpsistemi_mail_gonder/' + invoiceId + '/' + emailToSend,
                                beforeSend: function() {
                                    Swal.fire({
                                        title: '<div class="modal-icon-wrapper">' +
                                               '<div class="modal-icon modal-icon-primary loading">' +
                                               '<i class="ni ni-loader"></i>' +
                                               '</div></div>' +
                                               '<h2 class="modal-title">Mail Gönderiliyor</h2>',
                                        html: '<div class="modal-description">Lütfen bekleyiniz...</div>',
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                        customClass: {
                                            popup: 'modal-popup'
                                        }
                                    });
                                },
                                success: function(response) {
                                    Swal.fire({
                                        title: '<div class="modal-icon-wrapper">' +
                                               '<div class="modal-icon modal-icon-success">' +
                                               '<i class="ni ni-check-circle-fill"></i>' +
                                               '</div></div>' +
                                               '<h2 class="modal-title">Başarılı!</h2>',
                                        html: `<div class="modal-description">
                                                Fatura başarıyla <strong>${emailToSend}</strong> adresine gönderildi.
                                              </div>`,
                                        customClass: {
                                            popup: 'modal-popup',
                                            confirmButton: 'modal-btn modal-btn-success'
                                        },
                                        buttonsStyling: false
                                    });
                                },
                                error: function() {
                                    Swal.fire({
                                        title: '<div class="modal-icon-wrapper">' +
                                               '<div class="modal-icon modal-icon-error">' +
                                               '<i class="ni ni-cross-circle-fill"></i>' +
                                               '</div></div>' +
                                               '<h2 class="modal-title">Hata!</h2>',
                                        html: '<div class="modal-description">Mail gönderimi sırasında bir hata oluştu.</div>',
                                        customClass: {
                                            popup: 'modal-popup',
                                            confirmButton: 'modal-btn modal-btn-error'
                                        },
                                        buttonsStyling: false
                                    });
                                }
                            });
                        }
                    });
                });
            });
        </script>

        <style>


/* Dropdown Menü Stilleri */
.dropdown-menu {
    padding: 0.5rem 0;
    border: 1px solid #e5e9f2;
    box-shadow: 0 3px 12px rgba(43,55,72,0.15);
    border-radius: 6px;
}

.dropdown-inner {
    padding: 0.25rem;
}

.link-option {
    display: flex;
    align-items: center;
    padding: 0.625rem 1.25rem;
    color: #526484;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
}

.link-option:hover {
    background-color: #f5f6fa;
    color: #364a63;
    transform: translateX(3px);
}

.link-option.disabled {
    opacity: 0.6;
    cursor: not-allowed;
    pointer-events: none;
}

.link-option em {
    font-size: 1.25rem;
    margin-right: 0.75rem;
    width: 24px;
    text-align: center;
}

.dropdown-divider {
    margin: 0.5rem 0;
    border-top: 1px solid #e5e9f2;
}

/* Buton Stilleri */


/* Animasyonlar */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.dropdown-menu.show {
    animation: fadeIn 0.2s ease;
}
            /* Modal Temel Stiller */
            .modal-popup {
                border-radius: 20px;
                padding: 2rem;
                background: #fff;
                box-shadow: 0 10px 40px rgba(0,0,0,0.1);
                max-width: 500px;
            }

            /* İkon Wrapper */
            .modal-icon-wrapper {
                margin-bottom: 1.5rem;
            }

            .modal-icon {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
                position: relative;
            }

            .modal-icon i {
                font-size: 2.5rem;
            }

            /* İkon Varyasyonları */
            .modal-icon-primary {
                background: rgba(101, 118, 255, 0.1);
                color: #6576ff;
            }

            .modal-icon-success {
                background: rgba(30, 224, 172, 0.1);
                color: #1ee0ac;
            }

            .modal-icon-error {
                background: rgba(232, 83, 71, 0.1);
                color: #e85347;
            }

            /* Pulse Animasyonları */
            .pulse-primary::after,
            .pulse-success::after,
            .pulse-error::after {
                content: '';
                position: absolute;
                width: 100%;
                height: 100%;
                border-radius: 50%;
                animation: pulse 2s infinite;
                opacity: 0.8;
            }

            .pulse-primary::after {
                border: 3px solid #6576ff;
            }

            .pulse-success::after {
                border: 3px solid #1ee0ac;
            }

            .pulse-error::after {
                border: 3px solid #e85347;
            }

            @keyframes pulse {
                0% {
                    transform: scale(0.95);
                    opacity: 0.8;
                }
                70% {
                    transform: scale(1.1);
                    opacity: 0;
                }
                100% {
                    transform: scale(0.95);
                    opacity: 0;
                }
            }

            /* Loading Animasyonu */
            .loading i {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            /* Başlık ve Açıklama */
            .modal-title {
                color: #364a63;
                font-size: 1.5rem;
                font-weight: 700;
                margin: 1rem 0;
                text-align: center;
            }

            .modal-description {
                color: #526484;
                font-size: 1rem;
                text-align: center;
                margin-bottom: 1.5rem;
            }

            /* Bilgi Kutusu */
            .modal-info {
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(101, 118, 255, 0.1);
                padding: 1rem;
                border-radius: 10px;
                margin-top: 1rem;
            }

            .modal-info i {
                color: #6576ff;
                margin-right: 0.5rem;
            }

            .modal-info span {
                color: #526484;
                font-size: 0.875rem;
            }

            /* Butonlar */
            .modal-btn {
                font-weight: 500;
                border-radius: 10px;
                font-size: 0.9375rem;
                padding: 0.75rem 1.75rem;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                border:none;
            }

            .modal-btn i {
                font-size: 1.1em;
            }

            .modal-btn-success {
                background: #1ee0ac;
                margin-right: 10px;
                color: white;
            }

            .modal-btn-success:hover {
                background: #1bc598;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(30,224,172,0.3);
            }

            .modal-btn-light {
                background: #e5e9f2;
                color: #526484;
            }

            .modal-btn-light:hover {
                background: #dbdfeb;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(219,223,235,0.3);
            }

            .modal-btn-error {
                background: #e85347;
                color: white;
            }

            .modal-btn-error:hover {
                background: #e43d2f;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(232,83,71,0.3);
            }

            /* Animasyonlar */
            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translate3d(0, -20%, 0);
                }
                to {
                    opacity: 1;
                    transform: translate3d(0, 0, 0);
                }
            }

            @keyframes fadeOutUp {
                from {
                    opacity: 1;
                    transform: translate3d(0, 0, 0);
                }
                to {
                    opacity: 0;
                    transform: translate3d(0, -20%, 0);
                }
            }

            .animate__animated {
                animation-duration: 0.3s;
                animation-fill-mode: both;
            }

            .animate__fadeInDown {
                animation-name: fadeInDown;
            }

            .animate__fadeOutUp {
                animation-name: fadeOutUp;
            }

            .animate__faster {
                animation-duration: 0.2s;
            }

            .dropdown-menu-lg {
                min-width: 250px;
            }

            .dropdown-item {
                padding: 0.75rem 1.25rem;
                transition: all 0.3s ease;
            }

            .dropdown-item:hover {
                background-color: #f5f6fa;
                transform: translateX(5px);
            }

            .divider {
                border-top: 1px solid #e5e9f2;
                margin: 0.5rem 0;
            }

            .modal-icon-info {
                background: rgba(9, 113, 241, 0.1);
                color: #0971f1;
            }

            .fs-5 {
                font-size: 1.25rem !important;
            }
        </style>

        <?= $this->endSection() ?>