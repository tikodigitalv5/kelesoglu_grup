<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

    <style>
        input.transparent-input {
            background-color: rgba(0, 0, 0, 0) !important;
            border: none !important;
            color: #344357 !important;
        }
        .text-right {
            text-align: right !important;
        }
        p, li, h2, h3, th, tr, td, span {
            color: #000000 !important;  
        }
        .order-separator {
            background-color: #f5f5f5;
            font-weight: bold;
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
                                <th>
                                    <h2 class="title">Sevkiyat Emirleri</h2>
                                </th>
                                <th class="text-right">
                                    <ul class="list-plain">
                                        <li class="invoice-id fw-light"><span>Emir No: <?= $order_item['sevk_no'] ?></span></li>
                                        <li class="invoice-date fw-light"><span>Tarih: <?= convert_date_for_view($order_item['created_at']) ?></span></li>
                                    </ul>
                                    <p class="fw-light m-0"><b><?= mb_strtoupper(session()->get('user_item')['firma_adi']) ?></b></p>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
                
                <div class="invoice-bills">
                    <div class="table-responsive">
                        <table class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th class="w-120px">Sipariş NO</th>
                                    <th class="w-90px">Kargo</th>
                                    <th class="w-90px">Görsel</th>
                                    <th class="w-10">Adı</th>
                                    <th class="w-10">Kodu</th>
                                    <th class="text-right"><b>DEPO</b></th>
                                    <th class="text-right">Adet</th>
                                   
                                    <th class="w-10">Raf</th>
                                    <th class="w-10">TOPLANDI</th>
                                    <th class="w-10">GÖNDERİLDİ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $previousOrderNo = null;
                                foreach ($orders as $order):
                                    foreach ($order['items'] as $item): 
                                        // Yeni bir sipariş no ile karşılaşıldığında bir ayırıcı satır ekleyelim
                                        if ($previousOrderNo !== $order['order_no']): 
                                            $previousOrderNo = $order['order_no'];
                                ?>
                                   
                                <?php 
                                        endif; // Yeni sipariş kontrolü sonu
                                ?>
                                    <tr>     <td>

<?php

$yazdir = '';



echo "<b>" . substr($item['order_no'], 3) . "</b> -   " . $item['order_date'] . " ".$yazdir."";



?>

</td>
                                   
                                            <td>
                                           <?php   echo  KargoLogoCustom($item["kargo"]); ?>
                                            </td>
                                       
                                   
                                        <td>
                                            <a href="<?= base_url() . '/' . $item['default_image'] ?>" data-lightbox="gallery-<?= $item['product_id'] ?>" data-title="<?= $item['title'] ?>">
                                                <img class="img-popup" style="height: 50px;" src="<?= base_url() . '/' . $item['default_image'] ?>" alt="">
                                            </a>
                                            <?php foreach ($item['gallery'] as $gallery): ?>
                                                <a style="display:none" href="<?= base_url() . '/' . $gallery['image_path'] ?>" data-lightbox="gallery-<?= $item['product_id'] ?>" data-title="<?= $item['title'] ?>">
                                                    <img class="img-popup" style="height: 50px;" src="<?= base_url() . '/' . $gallery['image_path'] ?>" alt="">
                                                </a>
                                            <?php endforeach; ?>
                                        </td>
                                        <td><strong><?= $item['title'] ?></strong></td>
                                        <td><strong><?= $item['code'] ?></strong></td>
                                        <td class="text-right">
                            <b style="font-family: monospace;<?php  if($item['stok_miktari'] > 0){ echo "color:green"; }else{ echo "color:red"; } ?>"><?= number_format($item['stok_miktari'], 2, ',', '.') ?> </b>
                        </td>
                                        <td class="text-right"><?= number_format($item['quantity'], 2, ',', '.') ?></td>
                                       
                                        <td><?= $item['warehouse_location'] ?></td>
                                        <td style="text-align:center">
                                        <em title="Bekliyor" style="font-size:30px; color:black; font-weight:bold;" class="icon ni ni-square"></em>
                                        </td>
                                        <td style="text-align:center">
                                            <?php if($item["status"] == "sevk_edildi"){ ?> 
                                                
                                                <em title="Yazdırıldı" style="font-size:30px; color:green; font-weight:bold;" class="icon ni ni-check-round-cut"></em>
                                                
                                                
                                            <?php } else { ?> 
                                                
                                                <em title="Bekliyor" style="font-size:30px; color:red; font-weight:bold;" class="icon ni ni-square"></em>
                                                
                                            <?php }?>
                                      
                                        </td>
                                    </tr>
                                <?php endforeach; // Sipariş altındaki ürünlerin döngüsü ?>
                                <?php endforeach; // Tüm siparişlerin döngüsü ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        function printPromot() {
            window.print();
        }
    </script>
</body>

</html>