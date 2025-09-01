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

    <!-- CDN for Bootstrap CSS -->

    <!-- CDN for Lightbox CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

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

        p, li, h2, h3, th, tr, td, span {
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
                                    <h2 class="title">Sevkiyat Emirleri</h2>
                                </th>
                                <th class="text-right">
                                    <ul class="list-plain">
                                        <li class="invoice-id fw-light"><span>Emir No: <?= $order_item['sevk_no'] ?></span></li>
                                        <li class="invoice-date fw-light"><span>Tarih: <?= convert_date_for_view($order_item['created_at']) ?></span></li>
                                    </ul>
                                    <br>
                                    <p class="fw-light m-0"><b><?= mb_strtoupper(session()->get('user_item')['firma_adi']) ?></b></p>
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
                                    <th class="w-90px">Ürün Görseli</th>
                                    <th class="w-10">Adı</th>
                                    <th class="w-10">Kodu</th>
                                    <th class="w-10"><b>DEPO</b></th>
                                    <th class="text-right">Adet</th>
                                    <th class="w-10">Depo</th>
                                    <th class="w-10">Raf</th>
                                </tr>
                            </thead>
                            <tbody id="fatura_satirlar">
                <?php foreach ($order_rows as $index => $order_row): ?>
                    <tr id="Satir_<?= $order_item['sevk_id'] ?>">
                        <td>
                            <?php if (!empty($order_row["gallery"])): ?>
                                <a href="<?php echo base_url(); ?>/<?php echo $order_row["default_image"] ?>" data-lightbox="gallery-<?= $index ?>" data-title="<?= $order_row['stock_title'] ?>">
                                    <img class="img-popup" style="height: 50px;" src="<?php echo base_url(); ?>/<?php echo $order_row["default_image"] ?>" alt="">
                                </a>
                                <!-- Lightbox Gallery for rows with multiple images -->
                                <?php foreach($order_row["gallery"] as $gallery): ?>
                                    <a style="display:none" href="<?php echo base_url(); ?>/<?php echo $gallery["image_path"] ?>" data-lightbox="gallery-<?= $index ?>" data-title="<?= $order_row['stock_title'] ?>">
                                        <img class="img-popup" style="height: 50px;" src="<?php echo base_url(); ?>/<?php echo $gallery["image_path"] ?>" alt="">
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Single Lightbox for rows with a single image -->
                                <a href="<?php echo base_url(); ?>/<?php echo $order_row["default_image"] ?>" data-lightbox="gallery-<?= $index ?>" data-title="<?= $order_row['stock_title'] ?>">
                                    <img class="img-popup" style="height: 50px;" src="<?php echo base_url(); ?>/<?php echo $order_row["default_image"] ?>" alt="">
                                </a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?= $order_row['stock_title'] ?></strong> <br>
                                <?php
                               
                               $yazdir = '';
                               foreach ($order_row['order_info'] as $info) {
                               
                                if($info["yazdir"] == 1){
                                    $yazdir = '<em  title="Bu Sipariş Daha Önce Yazdırıldı" style="margin-left:5px; font-size:15px;" class="icon ni ni-printer-fill"></em>';
                                }else{
                                    $yazdir = '';
                                }
                                echo "<b>" . substr($info['order_no'], 3) . "</b> -   " . $info['order_date'] . " ".$yazdir."";

                                echo  KargoLogoCustom($info["kargo"]) . "<br>";
                            }
                                ?>
                        </td>
                        <td>
                            <strong><?= $order_row['stock_code'] ?></strong>
                        </td>
                        <td class="text-right">
                            <b style="font-family: monospace;<?php  if($order_row['stok_miktari'] > 0){ echo "color:green"; }else{ echo "color:red"; } ?>"><?= number_format($order_row['stok_miktari'], 2, ',', '.') ?> </b>
                        </td>
                        <td class="text-right">
                            <?= number_format($order_row['stock_amount'], 2, ',', '.') ?> 
                        </td>
                        <td>
                            1. Depo
                        </td>
                        <td>
                            <?= $order_row['raf'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- .invoice-wrap -->
        </div><!-- .invoice -->
    </div><!-- .nk-block -->

    <!-- CDN for jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- CDN for Bootstrap JS -->

    <!-- CDN for Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <script>
        function printPromot() {
            window.print();
        }
    </script>
</body>

</html>
