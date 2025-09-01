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

        p,li,h2,h3,th,tr,td,span {
          color: #000000 !important;  
        }
    </style>
</head>

<body class="bg-white" onload="printPromot()">
    <div class="nk-block">
        <div class="invoice invoice-print mt-0">
            <div class="invoice-wrap">
                <div class="invoice-head">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="">
                                    <h2 class="title ">Sipariş Fişi</h2>
                                    <ul class="list-plain">
                                        <li class="invoice-id fw-light "><span>Fiş Türü: <?php 
                                        if ($order_item["order_direction"] == 'incoming') {
                                            echo'ALIŞ';
                                           
                                        } else {
                                            echo'SATIŞ';
                                            
                                        }
                                        ?></span></li>
                                        <li class="invoice-id fw-light "><span>Fiş No: <?= $order_item['order_id'] ?></span></li>
                                        <li class="invoice-date fw-light"><span>Tarih: <?= convert_date_for_view($order_item['order_date']) ?></li>
                                    </ul>
                                </th>
                                <th class="text-right">
                                    <p class="fw-light m-0"><?= mb_strtoupper(session()->get('user_item')['firma_adi']) ?></p>
                                    <h2 class="title "><?= $order_item['cari_invoice_title'] ?></h2>
                                </th>
                                
                            </tr>
                        </thead>
                    </table>

                    
                </div><!-- .invoice-head -->
                <div class="invoice-bills">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="w-90px">FOTOĞRAF</th>
                                    <th class="w-10">AÇIKLAMA</th>
                                    <th class="text-right">BİRİM FİYAT</th>
                                    <th class="text-right">MİKTAR</th>

                                    <?php 
                                    if(empty($order_item["b2b"])):
                                        if ($order_item['discount_total'] != 0 ) {
                                        echo '<th class="text-right">İskonto</th>';
                                        } 
                                    endif;
                                    ?>
                                    <!-- <th class="text-right">İskonto</th> -->


                                    <?php if ($order_item['tax_rate_1_amount'] != 0 || $order_item['tax_rate_10_amount'] != 0 || $order_item['tax_rate_20_amount'] != 0) {
                                        echo '<th class="text-right">KDV</th>';
                                    } ?>
                                    <!-- <th class="text-right">KDV</th> -->


                                    <th style="width:100px;">Toplam</th>
                                </tr>
                            </thead>
                            <tbody id="fatura_satirlar">

                                <?php
                                $colspan = 2;

                                foreach ($order_rows as $order_row) { ?>
                                    <tr class="" id="Satir_<?= $order_row['order_row_id'] ?>">
                                        <td id="txt_img_<?= $order_row['order_row_id'] ?>">
                                            <img src="<?= base_url($order_row['default_image']) ?>" alt="image" class="rounded img-thumbnail">
                                        </td>
                                        <td id="txt_aciklama_<?= $order_row['order_row_id'] ?>">
                                            <strong><?= $order_row['stock_title'] ?><br></strong>
                                        </td>
                                        <td id="txt_birimfiyat_<?= $order_row['order_row_id'] ?>" class="text-right"><?= number_format($order_row['unit_price'], 2, ',', '.') ?> <?= $order_item['money_icon'] ?></td>
                                        <td id="txt_miktar_birim_<?= $order_row['order_row_id'] ?>" class="text-right"><?= number_format($order_row['stock_amount'], 2, ',', '.') ?> <?= $order_row['unit_title'] ?></td>

                                        <?php if ($order_row['discount_price'] != 0) {
                                            //echo '<td id="txt_iskonto_'. $order_row['order_row_id'] .'" class="text-right"> ' . number_format($order_row['discount_price'], 2, ',', '.') .' '. $order_item['money_icon'] .' (%'. $order_row['discount_rate'] . ') </td>';
                                        } ?>

                                        <!-- <td id="txt_iskonto_<?= $order_row['order_row_id'] ?>" class="text-right"><?= number_format($order_row['discount_price'], 2, ',', '.') ?> <?= $order_item['money_icon'] ?> (%<?= $order_row['discount_rate'] ?>)</td> -->


                                        
                                        <?php if(empty($order_item["b2b"])): if ($order_row['tax_id'] != 0) {
                                            echo '<td id="txt_kdv_'. $order_row['order_row_id'] .'" class="text-right"> ' . number_format($order_row['tax_price'], 2, ',', '.') .' '. $order_item['money_icon'] .' (%'. $order_row['tax_id'] . ') </td>';
                                        } endif; ?>

                                        <!-- <td id="txt_kdv_<?= $order_row['order_row_id'] ?>" class="text-right"><?= number_format($order_row['tax_price'], 2, ',', '.') ?> <?= $order_item['money_icon'] ?> (%<?= $order_row['tax_id'] ?>)</td> -->



                                        <td id="txt_genel_toplam_<?= $order_row['order_row_id'] ?>" class="text-right"><?= number_format($order_row['total_price'], 2, ',', '.') ?> <?= $order_item['money_icon'] ?></td>
                                    </tr>
                                <?php } ?>

                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="<?= $colspan ?>"></td>
                                    <td colspan="2">Mal/Hizmet Toplam</td>
                                    <td class="text-right" id="txt_kdvsiz_toplam"><?= number_format($order_item['stock_total'], 2, ',', '.') ?> <?= $order_item['money_code'] ?></td>
                                </tr>

                                <?php

                                if ($order_item['stock_total_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan . '"></td>' .
                                        '<td colspan="2"></td>' .
                                        '<td class="text-right" id="txt_kdvsiz_toplam">' . number_format($order_item["stock_total_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                }
                                ?>


                                <tr>
                                    <td colspan="<?= $colspan ?>"></td>
                                    <td colspan="2">İskonto</td>
                                    <td class="text-right" id="txt_iskonto_toplam"><?= number_format($order_item['discount_total'], 2, ',', '.') ?> <?= $order_item['money_code'] ?></td>
                                </tr>
                                <?php
                                if ($order_item['discount_total_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan . '"></td>' .
                                        '<td colspan="2"></td>' .
                                        '<td class="text-right" id="txt_iskonto_toplam_dvz">' . number_format($order_item["discount_total_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                }
                                ?>

                                <?php

                                if ($order_item['tax_rate_1_amount'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan . '"></td>' .
                                        '<td colspan="2">KDV Toplam (%1)</td>' .
                                        '<td class="text-right" id="txt_kdv_toplam1">' . number_format($order_item["tax_rate_1_amount"], 2, ',', '.') . ' ' . $order_item["money_code"] . '</td>' .
                                        '</tr>';
                                }

                                if ($order_item['tax_rate_1_amount_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan . '"></td>' .
                                        '<td colspan="2"></td>' .
                                        '<td class="text-right" id="txt_kdv_toplam1_dvz">' . number_format($order_item["tax_rate_1_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                }

                                if ($order_item['tax_rate_10_amount'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan . '"></td>' .
                                        '<td colspan="2">KDV Toplam (%10)</td>' .
                                        '<td class="text-right" id="txt_kdv_toplam10">' . number_format($order_item["tax_rate_10_amount"], 2, ',', '.') . ' ' . $order_item["money_code"] . '</td>' .
                                        '</tr>';
                                }

                                if ($order_item['tax_rate_10_amount_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan . '"></td>' .
                                        '<td colspan="2"></td>' .
                                        '<td class="text-right" id="txt_kdv_toplam10_dvz">' . number_format($order_item["tax_rate_10_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                }

                                if ($order_item['tax_rate_20_amount'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan . '"></td>' .
                                        '<td colspan="2">KDV Toplam (%20)</td>' .
                                        '<td class="text-right" id="txt_kdv_toplam20">' . number_format($order_item["tax_rate_20_amount"], 2, ',', '.') . ' ' . $order_item["money_code"] . '</td>' .
                                        '</tr>';
                                }

                                if ($order_item['tax_rate_20_amount_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan . '"></td>' .
                                        '<td colspan="2"></td>' .
                                        '<td class="text-right" id="txt_kdv_toplam20_dvz">' . number_format($order_item["tax_rate_20_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                }

                                

                                ?>
                                <tr>
                                    <td colspan="<?= $colspan ?>"></td>
                                    <td colspan="2"><strong>Genel Toplam</strong></td>
                                    <td class="text-right" id="txt_genel_toplam"><strong><?= number_format($order_item['grand_total'], 2, ',', '.') ?> <?= $order_item['money_code'] ?></strong></td>
                                </tr>
                                <?php
                                if ($order_item['grand_total_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan . '"></td>' .
                                        '<td colspan="2"></td>' .
                                        '<td class="text-right" id="txt_genel_toplam_dvz">' . number_format($order_item["grand_total_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                } ?>

                                <tr>
                                    <td colspan="<?= $colspan ?>"></td>
                                    <td colspan="2"><strong>Ödenecek Toplam</strong></td>
                                    <td class="text-right" id="txt_odenecek_toplam"><strong><?= number_format($order_item['amount_to_be_paid'], 2, ',', '.') ?> <?= $order_item['money_code'] ?></strong></td>
                                </tr>
                                <?php
                                if ($order_item['amount_to_be_paid_try'] != 0) {
                                    echo '<tr>' .
                                        '<td colspan="' . $colspan . '"></td>' .
                                        '<td colspan="2"></td>' .
                                        '<td class="text-right" id="txt_odenecek_toplam_dvz">' . number_format($order_item["amount_to_be_paid_try"], 2, ',', '.') . ' TRY</td>' .
                                        '</tr>';
                                } ?>
                            </tfoot>
                        </table>
                        <hr>
                        <div class="invoice-desc w-100" style="display: flex; justify-content:space-between; align-items:center;">
                            <div>
                                <span>Fiş Not</span>:
                                <ul class="list-plain">
                                    <li class="invoice-date">
                                        <span><?= $order_item['amount_to_be_paid_text'] ?></span>
                                    </li>

                                    <?php
                                    if ($order_item['currency_amount'] != 0) {
                                        echo '<li class="invoice-date">' .
                                            '<span>Döviz Kur Bilgisi:' . number_format($order_row['currency_amount'], 2, ',', '.') . ' </span>' .
                                            '</li>';
                                    } ?>

                                    <li class="invoice-date">
                                        <!-- <span>Fiş Not</span>: -->
                                        <span style="text-transform:initial;"><?= $order_item['order_note'] ?></span>
                                    </li>

                                    <?php
                                    if ($order_item['is_deadline'] == 1) { ?>
                                        <li class="invoice-date">
                                            <span>TERMİN TARİHİ</span>:
                                            <span style="text-transform:initial;"><?= convert_date_for_view($order_item['deadline_date']) ?></span>
                                        </li>
                                    <?php }
                                    ?>
                                </ul>

                              
                            </div>
                            <?php if(!empty($order_item["b2b"])):
                                if(!empty($order_item["satisci"])):
                                ?>
                            <div>
                                <br>
                                <span><u>Satıcı</u></span>
                                <br>
                               <b><?php echo $order_item["satisci"]; ?></b>
                            </div>
                            <?php endif; endif; ?>
                            <div>
                                <span><u>Teslim Alan</u></span>
                            </div>


                        </div>
                    </div>
                </div>

            </div><!-- .invoice-wrap -->
        </div><!-- .invoice -->
    </div><!-- .nk-block -->
    <script>
        function printPromot() {
            window.print();
        }
    </script>
</body>

</html>