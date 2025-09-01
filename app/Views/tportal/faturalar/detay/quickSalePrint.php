<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?= base_url('custom/favicon.png') ?>">

    <!-- Page Title  -->
    <title><?= $this->renderSection('page_title', true) ?> - Tiko Portal | Online Ön Muhasebe, E-Arşiv Fatura ve E-Fatura Kesme Programı</title>

    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?= base_url('assets/css/dashlite.css?ver=3.2.0') ?>">
    <link id="skin-default" rel="stylesheet" href="<?= base_url('assets/css/theme.css?ver=3.2.0') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('custom/webfont_gilroy/font.css') ?>">

    <link rel="stylesheet" href="<?= base_url('custom/theme_blue.css?ver=2.0.0') ?>">
    <link rel="stylesheet" href="<?= base_url('custom/style.css?ver=2.0.0') ?>">

    <style>
        input.transparent-input {
            background-color: rgba(0, 0, 0, 0) !important;
            border: none !important;
            color: #344357 !important;
        }

        .transparent-input-text {
            background-color: rgba(0, 0, 0, 0) !important;
            border: none !important;
            color: #344357 !important;
            padding: 0px !important;
            margin-top: 4px !important;
        }

        .dvz_str {
            margin-top: -14px !important;
        }

        .text-right {
            text-align: right !important;
        }

        p,li,h2,h3,h4,h6,th,tr,td,span {
          color: #000000 !important;  
          font-family: 'Roboto Mono',monospace,serif;
        }

        body{
            font-family: 'Roboto Mono',monospace,serif;
        }

        .invoice-head{
            padding-bottom: .5rem !important;
        }

        .border-none{
            border: none !important;
        }
    </style>
</head>

<body class="bg-white" onload="printPromot()">
    <div class="nk-block">
        <div class="invoice invoice-print mt-0" id="print_element">
            <div class="invoice-wrap">
                <div class="invoice-head">

                <?php
                if (session()->get('user_id') == 3) { ?>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <td class="border-none" style="height:30px;">
                                        <img src="https://emdersan.com/wp-content/uploads/2022/09/cropped-emdersan-1.png" alt="" srcset="" style="filter: invert(1); width:320px;">
                                    </td>
                            </tr>
                            <tr>
                                <th class="border-none">
                                    <h6 class="title " ><u>Sayın</u></h6>
                                    <!-- <p class="fw-light m-0"><?= mb_strtoupper(session()->get('user_item')['firma_adi']) ?></p> -->
                                    <h4 class="title "><?= $invoice_item['cari_invoice_title'] ?></h4>
                                    
                                </th>
                                <th class="text-right border-none">
                                    <ul class="list-plain border-none">
                                        <li class="invoice-date fw-light mb-2"><span>Tarih: <?= convert_date_for_view($invoice_item['invoice_date']) ?></li>
                                      
                                        <li class="invoice-id fw-light"><span>Fiş No: <?= $invoice_item['invoice_no'] ?></span></li>
                                    </ul>
                                </th>
                                
                            </tr>
                        </thead>
                    </table>
                    
                <?php } else { ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="">
                                    <h2 class="title ">Satış Fişi</h2>
                                    <ul class="list-plain">
                                    <li class="invoice-id fw-light "><span>Fiş Türü: <?php 
                                        if ($invoice_item["invoice_direction"] == 'incoming_invoice') {
                                            echo'ALIŞ';
                                           
                                        } else {
                                            echo'SATIŞ';
                                            
                                        }
                                        ?></span></li>
                                        <li class="invoice-id fw-light "><span>Fiş No: <?= $invoice_item['invoice_no'] ?></span></li>
                                        <li class="invoice-date fw-light"><span>Tarih: <?= convert_date_for_view($invoice_item['invoice_date']) ?></li>
                                    </ul>
                                </th>
                                <th class="text-right">
                                    <p class="fw-light m-0"><?= mb_strtoupper(session()->get('user_item')['firma_adi']) ?></p>
                                    <h2 class="title "><?= $invoice_item['cari_invoice_title'] ?></h2>
                                </th>
                                
                            </tr>
                        </thead>
                    </table>

                    <?php } ?>
                    
                </div><!-- .invoice-head -->
                <div class="invoice-bills">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="w-10">Açıklama</th>
                                    <th class="text-right">Birim Fiyatı</th>
                                    <th class="text-right">Miktar</th>

                                    <?php if ($invoice_item['discount_total'] != 0) {
                                        echo '<th class="text-right">İskonto</th>';
                                    } ?>
                                    <!-- <th class="text-right">İskonto</th> -->


                                    <?php if ($invoice_item['tax_rate_1_amount'] != 0 || $invoice_item['tax_rate_10_amount'] != 0 || $invoice_item['tax_rate_20_amount'] != 0) {
                                        echo '<th class="text-right">KDV</th>';
                                    } ?>
                                    <!-- <th class="text-right">KDV</th> -->



                                    <?php if ($invoice_item['invoice_type'] == 'TEVKIFAT') {
                                        echo '<th class="text-right">Tev. Oran</th>' .
                                            '<th class="text-right">Tev. Tutar</th>';
                                    } ?>
                                    <th style="width:100px;">Toplam</th>
                                </tr>
                            </thead>
                            <tbody id="fatura_satirlar">

                                <?php
                                if (($invoice_item['tax_rate_1_amount'] != 0 || $invoice_item['tax_rate_10_amount'] != 0 || $invoice_item['tax_rate_20_amount'] != 0) && $invoice_item['discount_total'] != 0) $colspan = 3;
                                else if ($invoice_item['discount_total'] != 0) $colspan = 2;
                                else if ($invoice_item['tax_rate_1_amount'] != 0 || $invoice_item['tax_rate_10_amount'] != 0 || $invoice_item['tax_rate_20_amount'] != 0) $colspan = 2;
                                else if ($invoice_item['invoice_type'] == 'TEVKIFAT') $colspan = 5;
                                else $colspan = 1;

                                foreach ($invoice_rows as $invoice_row) { ?>
                                    <tr class="" id="Satir_<?= $invoice_row['invoice_row_id'] ?>">
                                        <td id="txt_aciklama_<?= $invoice_row['invoice_row_id'] ?>">
                                            <?= $invoice_row['stock_title'] ?><br>
                                        </td>
                                        <td id="txt_birimfiyat_<?= $invoice_row['invoice_row_id'] ?>" class="text-right"><?= number_format($invoice_row['unit_price'], 2, ',', '.') ?> <?= $invoice_item['money_icon'] ?></td>
                                        <td id="txt_miktar_birim_<?= $invoice_row['invoice_row_id'] ?>" class="text-right"><?= number_format($invoice_row['stock_amount'], 2, ',', '.') ?> <?= $invoice_row['unit_title'] ?></td>

                                        <?php if ($invoice_item['discount_total'] != 0) {
                                            echo '<td id="txt_iskonto_' . $invoice_row['invoice_row_id'] . '" class="text-right"> ' . number_format($invoice_row['discount_price'], 2, ',', '.') . ' ' . $invoice_item['money_icon'] . ' (%' . $invoice_row['discount_rate'] . ') </td>';
                                        } ?>

                                        <!-- <td id="txt_iskonto_<?= $invoice_row['invoice_row_id'] ?>" class="text-right"><?= number_format($invoice_row['discount_price'], 2, ',', '.') ?> <?= $invoice_item['money_icon'] ?> (%<?= $invoice_row['discount_rate'] ?>)</td> -->



                                        <?php if ($invoice_item['tax_rate_1_amount'] != 0 || $invoice_item['tax_rate_10_amount'] != 0 || $invoice_item['tax_rate_20_amount'] != 0) {
                                            echo '<td id="txt_kdv_' . $invoice_row['invoice_row_id'] . '" class="text-right"> ' . number_format($invoice_row['tax_price'], 2, ',', '.') . ' ' . $invoice_item['money_icon'] . ' (%' . $invoice_row['tax_id'] . ') </td>';
                                        } ?>

                                        <!-- <td id="txt_kdv_<?= $invoice_row['invoice_row_id'] ?>" class="text-right"><?= number_format($invoice_row['tax_price'], 2, ',', '.') ?> <?= $invoice_item['money_icon'] ?> (%<?= $invoice_row['tax_id'] ?>)</td> -->




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
                                    <td colspan="<?= $colspan+1 ?>"></td>
                                    <td colspan="1">Mal/Hizmet Toplam</td>
                                    <td class="text-right" id="txt_kdvsiz_toplam"><?= number_format($invoice_item['stock_total'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></td>
                                </tr>

                                <?php
                                if($invoice_item['money_unit_id'] != 3){
                                if ($invoice_item['stock_total_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1"></td>' .
                                        '<td class="text-right" id="txt_kdvsiz_toplam">' . number_format($invoice_item["stock_total_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                } }

                                if ($invoice_item['discount_total'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1">İskonto</td>' .
                                        '<td class="text-right" id="txt_iskonto_toplam">' . number_format($invoice_item["discount_total"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                        '</tr>';
                                }
                                
                                if ($invoice_item['discount_total_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1"></td>' .
                                        '<td class="text-right" id="txt_iskonto_toplam_dvz">' . number_format($invoice_item["discount_total_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                }
                                ?>

                                <?php

                                if ($invoice_item['tax_rate_1_amount'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1">KDV Toplam (%1)</td>' .
                                        '<td class="text-right" id="txt_kdv_toplam1">' . number_format($invoice_item["tax_rate_1_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                        '</tr>';
                                }

                                if ($invoice_item['tax_rate_1_amount_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1"></td>' .
                                        '<td class="text-right" id="txt_kdv_toplam1_dvz">' . number_format($invoice_item["tax_rate_1_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                }

                                if ($invoice_item['tax_rate_10_amount'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1">KDV Toplam (%10)</td>' .
                                        '<td class="text-right" id="txt_kdv_toplam10">' . number_format($invoice_item["tax_rate_10_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                        '</tr>';
                                }

                                if ($invoice_item['tax_rate_10_amount_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1"></td>' .
                                        '<td class="text-right" id="txt_kdv_toplam10_dvz">' . number_format($invoice_item["tax_rate_10_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                }

                                if ($invoice_item['tax_rate_20_amount'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1">KDV Toplam (%20)</td>' .
                                        '<td class="text-right" id="txt_kdv_toplam20">' . number_format($invoice_item["tax_rate_20_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                        '</tr>';
                                }

                                if ($invoice_item['tax_rate_20_amount_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1"></td>' .
                                        '<td class="text-right" id="txt_kdv_toplam20_dvz">' . number_format($invoice_item["tax_rate_20_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                }

                                if ($invoice_item['transaction_subject_to_withholding_amount'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1">Tevkifata Tabi İşlem Tutar</td>' .
                                        '<td class="text-right" id="txt_V9015_islem_tutar">' . number_format($invoice_item["transaction_subject_to_withholding_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                        '</tr>';
                                }

                                if ($invoice_item['transaction_subject_to_withholding_amount_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1"></td>' .
                                        '<td class="text-right" id="txt_V9015_islem_tutar_dvz">' . number_format($invoice_item["transaction_subject_to_withholding_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                }

                                if ($invoice_item['transaction_subject_to_withholding_calculated_tax'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1">Tevkifata Tabi İşlem Hes. Kdv.</td>' .
                                        '<td class="text-right" id="txt_V9015_hesaplanan_kdv">' . number_format($invoice_item["transaction_subject_to_withholding_calculated_tax"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                        '</tr>';
                                }

                                if ($invoice_item['transaction_subject_to_withholding_calculated_tax_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1"></td>' .
                                        '<td class="text-right" id="txt_V9015_hesaplanan_kdv_dvz">' . number_format($invoice_item["transaction_subject_to_withholding_calculated_tax_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                }

                                if ($invoice_item['withholding_tax'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1">KDV Tevkifat</td>' .
                                        '<td class="text-right" id="txt_V9015">' . number_format($invoice_item["withholding_tax"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                        '</tr>';
                                }

                                if ($invoice_item['withholding_tax_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1"></td>' .
                                        '<td class="text-right" id="txt_V9015_dvz">' . number_format($invoice_item["withholding_tax_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                }

                                ?>
                                <tr>
                                    <td colspan="<?= $colspan+1 ?>"></td>
                                    <td colspan="1">Genel Toplam</td>
                                    <td class="text-right" id="txt_genel_toplam"><?= number_format($invoice_item['grand_total'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></td>
                                </tr>
                                <?php
                                 if($invoice_item['money_unit_id'] != 3){
                                if ($invoice_item['grand_total_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1"></td>' .
                                        '<td class="text-right" id="txt_genel_toplam_dvz">' . number_format($invoice_item["grand_total_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                } }
                                 ?>

                                <?php

                                if ($invoice_item['discount_total'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan+1 . '"></td>' .
                                        '<td colspan="1">Ödenecek Toplam</td>' .
                                        '<td class="text-right" id="txt_odenecek_toplam">' . number_format($invoice_item["amount_to_be_paid"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                }

                                if($invoice_item['money_unit_id'] != 3){

                                    if ($invoice_item['amount_to_be_paid_try'] != 0) {
                                        echo '<tr >' .
                                            '<td colspan="' . $colspan+1 . '"></td>' .
                                            '<td colspan="1"></td>' .
                                            '<td class="text-right" id="txt_odenecek_toplam_dvz">' . number_format($invoice_item["amount_to_be_paid_try"], 2, ',', '.') . ' TRY</td>' .
                                            '</tr>';
                                    }

                                }
                                ?>

<tr>
<td colspan="3"></td>
</tr>

<?php 
        /*                                       $colspan = 2;
              if(isset($Kurlar)): foreach($Kurlar as $kur){ 
                                      if($invoice_item['money_unit_id'] != $kur["kur"]):
                                  ?>
                                  <tr>
                                  <td colspan="<?= $colspan ?>"></td>
                                  <td colspan="1"><strong><?php echo $kur["money_code"] ?></strong></td>
                                  <td class="text-right" id="txt_odenecek_toplam"><strong><?= number_format($kur['toplam_tutar'], 2, ',', '.') ?> <?= $kur['money_code'] ?></strong></td>
                              </tr>

                             
                                  
                                  
                              <?php endif; } endif; */ ?>
                            

                            </tfoot>
                        </table>
                        <hr>
                        <div class="invoice-desc w-100" style="display: flex; justify-content:space-between; /*align-items:center;*/">
                            <div>
                                <span>Fiş Not</span>:
                                <ul class="list-plain">
                                    <li class="invoice-date">
                                        <span><?= $invoice_item['amount_to_be_paid_text'] ?></span>
                                    </li>

                                    <?php
                                    if ($invoice_item['currency_amount'] != 0) {
                                        echo '<li class="invoice-date">' .
                                            '<span>Döviz Kur Bilgisi:' . number_format($invoice_row['currency_amount'], 2, ',', '.') . ' </span>' .
                                            '</li>';
                                    }
                                    
                                    if ($invoice_item['is_quick_collection_financial_movement_id'] != 0) {
                                        echo '<li class="invoice-date">' .
                                            '<span>Tahsilatlı satış </span>' .
                                            '</li>';
                                    } ?>

                                    <li class="invoice-date">
                                        <!-- <span>Fiş Not</span>: -->
                                        <span style="text-transform:initial;"><?= $invoice_item['invoice_note'] ?></span>
                                    </li>

                                    <li class="invoice-date">

                                        <span style="text-transform: capitalize;">

                                            <?php if ($invoice_item['invoice_type'] == 'TEVKIFAT') {
                                                echo 'Fiş Tevkifat Bilgileri:<br>';
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

                            <div>
                                <span><u>Teslim Alan</u></span>
                            </div>


                        </div>
                    </div>
                </div>

            </div><!-- .invoice-wrap -->
        </div><!-- .invoice -->

        <div id='forSECTIONPrint'></div>
    </div><!-- .nk-block -->
    
    <script>
        function printPromot() {
            window.print();
        }
    </script>

    <!-- <script type="text/javascript">
        window.onload = PrintAppendChangeScheduleButton;
        function PrintAppendChangeScheduleButton() {
            printElement(document.getElementById("print_element")); //Specify the DIV to be printed.

            function printElement(elem) {
                var forDOMClone = elem.cloneNode(true);
                var forDOMCloneCUT = elem.cloneNode(true);
                var $forSECTIONPrint = document.getElementById("forSECTIONPrint"); //For Section Specific Print
                if (!$forSECTIONPrint) {
                    var $printSection = document.createElement("div"); //For DIV Specific Print
                    $forSECTIONPrint.id = "forSECTIONPrint";
                    document.body.appendChild($forSECTIONPrint);
                } else {
                    $forSECTIONPrint.innerHTML = "";
                    var elemHeight = elem.offsetHeight;
                    elem.style.display = 'none';
                    var emptySpace = document.createElement('div');
                    $forSECTIONPrint.appendChild(forDOMClone);
                    $forSECTIONPrint.appendChild(emptySpace);
                    //if there's any empty space at the bottom of the page, then set the height of the
                    //empty div in between the clones with that space height
                    if (1122.5 - (elemHeight * 2) > 0){
                        setTimeout(function(){
                            emptySpace.style.height = 1122.5 - (elemHeight * 2) + 'px';
                            window.print();
                        },100);
                    }
                    //if there's no empty space, just print right away
                    else {
                        window.print();
                    }
                    $forSECTIONPrint.appendChild(forDOMCloneCUT);
                    return true;
                }
            }
        }
    </script> -->
</body>

</html>