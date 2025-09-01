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
        .invoice-print{
            width: 100%;
            max-width: 100%;
        }
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

        /* Yazdırma stilleri */
        @media print {
            @page {
                margin: 0;
                size: auto;
            }
            body {
                margin: 1.6cm;
            }
            .no-print {
                display: none !important;
            }
            /* Yazdırma önizlemesinde header'ı gizle */
            @-moz-document url-prefix() {
                .header-print {
                    display: none !important;
                }
            }
            /* Chrome için header gizleme */
            @media print and (-webkit-min-device-pixel-ratio:0) {
                .header-print {
                    display: none !important;
                }
            }
        }
    </style>
</head>

<body class="bg-white" >
    <div class="nk-block">
        <div class="invoice invoice-print mt-0">
            <div class="invoice-wrap">
                <div class="invoice-head">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                  
                                  <div style="display: flex ; align-items: center; gap: 31px;">
                                  <h2 class="title">Sevkiyat Emirleri</h2>   <?php if(session()->get('user_item')['client_id'] != 75){ ?>  <button onclick="window.print()" class="btn btn-primary no-print mb-2">
                                        <em class="icon ni ni-printer"></em>
                                        <span style="font-size:12px; color:white!important;">Yazdır</span>
                                    </button> <?php } ?>
                                  </div>
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
                                    <th class="w-220px">Sipariş NO</th>
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
                                    <?php 
                                    $tdBgColor = ($item['toplandi'] == 1) ? 'background-color: #C8E6C9;' : '';
                                    ?>
                                    <tr>
                                        <td style="<?= $tdBgColor ?>">
                                            <?php
                                            $yazdir = '';
                                            echo "<b>" . substr($item['order_no'], 3) . "</b> <br> " . $item['order_date'] . " ".$yazdir."";
                                            ?>
                                        </td>
                                        <td style="<?= $tdBgColor ?>">
                                            <?php echo KargoLogoCustom($item["kargo"]); ?>
                                        </td>
                                        <td style="<?= $tdBgColor ?>">
                                            <a href="<?= base_url() . '/' . $item['default_image'] ?>" data-lightbox="gallery-<?= $item['product_id'] ?>" data-title="<?= $item['title'] ?>">
                                                <img class="img-popup" style="height: 50px;" src="<?= base_url() . '/' . $item['default_image'] ?>" alt="">
                                            </a>
                                            <?php foreach ($item['gallery'] as $gallery): ?>
                                                <a style="display:none" href="<?= base_url() . '/' . $gallery['image_path'] ?>" data-lightbox="gallery-<?= $item['product_id'] ?>" data-title="<?= $item['title'] ?>">
                                                    <img class="img-popup" style="height: 50px;" src="<?= base_url() . '/' . $gallery['image_path'] ?>" alt="">
                                                </a>
                                            <?php endforeach; ?>
                                        </td>
                                        <td style="<?= $tdBgColor ?>"><strong><?= $item['title'] ?></strong></td>
                                        <td style="<?= $tdBgColor ?>"><strong><?= $item['code'] ?></strong></td>
                                        <td style="<?= $tdBgColor ?>" class="text-right">
                                            <b style="font-family: monospace;<?php if($item['stok_miktari'] > 0){ echo "color:green"; }else{ echo "color:red"; } ?>">
                                                <?= number_format($item['stok_miktari'], 2, ',', '.') ?>
                                            </b>
                                        </td>
                                        <td style="<?= $tdBgColor ?>" class="text-right"><?= number_format($item['quantity'], 2, ',', '.') ?></td>
                                        <td style="<?= $tdBgColor ?>"><?= $item['warehouse_location'] ?></td>
                                        <td style="text-align:center; <?= $tdBgColor ?>">
                                            <?php if($item['toplandi'] == 0){ ?>    
                                            <a href="javascript:void(0)" class="toggle-status" data-id="<?= $item['order_satir_id'] ?>">
                                                <em title="Tıkla ve Değiştir" 
                                                    style="font-size:40px; color:black; font-weight:bold;" 
                                                    class="icon ni ni-square status-icon"
                                                    data-status="bekliyor">
                                                </em>
                                            </a>
                                            <?php }else { ?> 
                                            <a href="javascript:void(0)" class="toggle-status" data-id="<?= $item['order_satir_id'] ?>">
                                                <em title="Tıkla ve İptal Et" 
                                                    style="font-size:40px; color:green; font-weight:bold;" 
                                                    class="icon ni ni-check-round-cut status-icon"
                                                    data-status="toplandi">
                                                </em>
                                            </a>
                                            <?php } ?>
                                        </td>
                                        <td style="text-align:center; <?= $tdBgColor ?>">
                                            <?php if($item["status"] == "sevk_edildi"){ ?> 
                                                
                                                <em title="Yazdırıldı" style="font-size:40px; color:green; font-weight:bold;" class="icon ni ni-check-round-cut"></em>
                                                
                                                
                                            <?php } else { ?> 
                                                
                                                <em title="Bekliyor" style="font-size:40px; color:red; font-weight:bold;" class="icon ni ni-square"></em>
                                                
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
        $(document).ready(function() {
    $('.toggle-status').on('click', function() {
        var $icon = $(this).find('.status-icon');
        var currentStatus = $icon.data('status');
        var $row = $(this).closest('tr');
        var orderRowId = $(this).data('id');
        
        console.log('Current status:', currentStatus); // Debug için

        if(currentStatus === 'bekliyor') {
            // Bekleyenden toplandıya çevirme
            $icon.removeClass('ni-square').addClass('ni-check-round-cut');
            $icon.css('color', 'green');
            $icon.data('status', 'toplandi');
            $icon.attr('title', 'Tıkla ve İptal Et');
            
            $row.find('td').each(function() {
                $(this).css('background-color', '#C8E6C9');
            });

            $.ajax({
                url: '<?= base_url('tportal/order/toplandiGuncelle') ?>',
                type: 'POST',
                data: {
                    order_row_id: orderRowId,
                    toplandi: 1
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                success: function(response) {
                    console.log('Toplandı olarak güncellendi');
                }
            });
        } else if(currentStatus === 'toplandi') {
            // Toplandıdan bekleyene çevirme
            $icon.removeClass('ni-check-round-cut').addClass('ni-square');
            $icon.css('color', 'black');
            $icon.data('status', 'bekliyor');
            $icon.attr('title', 'Tıkla ve Değiştir');
            
            $row.find('td').each(function() {
                $(this).css('background-color', '');
            });

            $.ajax({
                url: '<?= base_url('tportal/order/toplandiGuncelle') ?>',
                type: 'POST',
                data: {
                    order_row_id: orderRowId,
                    toplandi: 0
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                success: function(response) {
                    console.log('Beklemeye alındı');
                }
            });
        }
    });
});
        
    </script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>