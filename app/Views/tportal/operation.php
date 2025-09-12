<?= $this->section('page_title') ?> Operatör Sayfası
<?= $this->endSection() ?>
<?= $this->section('title') ?> <?php echo $operation_title ?? 'Palet'; ?> Operatörü | <?= session()->get('user_item')['user_adsoyad'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>

<?= $this->include('tportal/inc/head') ?>

<body class="nk-body ui-rounder has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <?= $this->include('tportal/inc/solmenu') ?>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header is-light nk-header-fixed is-light">
                    <div class="container-xl wide-xl">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1 me-3">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="<?= route_to('tportal.dashboard') ?>" class="logo-link">
                                    <img class="logo-light logo-img" src="<?= base_url('custom/tiko_portal_renkli.png') ?>" srcset="<?= base_url('custom/tiko_portal_renkli.png') ?>" alt="logo">
                                    <img class="logo-dark logo-img" src="<?= base_url('custom/tiko_portal_renkli.png') ?>" srcset="<?= base_url('custom/tiko_portal_renkli.png') ?> 2x" alt="logo-dark">
                                </a>
                            </div>
                            <div class="nk-header-menu is-light">
                                <div class="nk-block-head-content">
                                    <h3 class="nk-block-title page-title " style="line-height: .7; margin-bottom:0;"><?= $this->renderSection('title', true) ?></h3>
                                    <div class="nk-block-des text-soft">
                                        <p><?= $this->renderSection('subtitle', true) ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="nk-block-tools-opt">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="<?= route_to('tportal.stocks.create') ?>" class="<?php if(array_search('Stoklar', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Stoklar', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'disabled'; ?>"><em class="icon ni ni-plus"></em><span>Yeni <b>Stok</b></span></a></li>
                                                    <li><a href="<?= route_to('tportal.faturalar.create') ?>" class="<?php if(array_search('Faturalar', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Faturalar', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'disabled'; ?>"><em class="icon ni ni-plus"></em><span>Yeni <b>Fatura</b></span></a></li>
                                                    <li><a href="#"><em class="icon ni ni-plus"></em><span>Yeni <b>Gider</b></span></a></li>
                                                    <li><a href="<?= route_to('tportal.cariler.create') ?>" class="<?php if(array_search('Cariler', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Cariler', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'disabled'; ?>"><em class="icon ni ni-plus"></em><span>Yeni <b>Cari</b></span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <em class="icon ni ni-user-alt"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar" style="background: #024ad0 !important;">
                                                        <span style="font-size: 16px; padding-top:5px;"><?= mb_substr(session()->get('user_item')['user_adsoyad'],0,1) ?></span>
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="lead-text"><?= session()->get('user_item')['user_adsoyad'] ?></span>
                                                        <span class="sub-text"><?= session()->get('user_item')['firma_adi'] ?></span>
                                                        <span class="sub-text"><?= session()->get('user_item')['user_eposta'] ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="#"><em class="icon ni ni-user-alt"></em><span>Profil Bilgileri</span></a></li>
                                                    <li><a href="#"><em class="icon ni ni-opt-alt"></em><span>Profil Tercihleri</span></a></li>
                                                    <li><a href="#"><em class="icon ni ni-activity-alt"></em><span>Profil Hareketleri</span></a></li>
                                                    <li><a class="dark-switch" href="#"><em class="icon ni ni-sun-fill"></em><span>Dark Mode</span></a></li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="<?= route_to('user_logout') ?>"><em class="icon ni ni-signout"></em><span>Çıkış</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown notification-dropdown d-md-inline d-none" >
                                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                            <div class="dropdown-head">
                                                <span class="sub-title nk-dropdown-title">Yeni Sevk Emirleri</span>
                                            </div>
                                            <div class="dropdown-body">
                                                <div class="nk-notification">
                                                    <?php if(isset($sevkler)): ?>
                                                    <?php foreach ($sevkler as $sevk):
                                                        if($sevk["bitti"] == 0){ ?>
                                                            <a target="_blank" href="<?php echo base_url('tportal/order/sevkPrint_tarih/' . $sevk["sevk_id"]) ?>">
                                                                <div class="nk-notification-item dropdown-inner" style="cursor:pointer" >
                                                                    <div class="nk-notification-icon">
                                                                        <em class="icon ni ni-file-download text-primary" style="font-size: 36px"></em>
                                                                    </div>
                                                                    <div class="nk-notification-content">
                                                                        <div class="nk-notification-text"><span><?php echo $sevk["sevk_no"] ?> Numaralı Yeni Sevk Emri</span></div>
                                                                        <div class="nk-notification-time"><?php echo $sevk["created_at"]; ?> 
                                                                        <?php if($sevk["print"] == 1): ?>
                                                                            <div class="badge rounded-pill bg-success">Yazdırıldı</div>
                                                                        <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                       <?php } else { ?> 
                                                            <div class="nk-notification-item dropdown-inner tamamlanan_sevk" style="cursor:pointer; opacity: 0.6;" >
                                                                <div class="nk-notification-icon">
                                                                    <em class="icon ni ni-file-check text-success" style="font-size: 36px"></em>
                                                                </div>
                                                                <div class="nk-notification-content">
                                                                    <div class="nk-notification-text"><span><?php echo $sevk["sevk_no"] ?> Numaralı Sevk Emri</span></div>
                                                                    <div class="nk-notification-time"><?php echo $sevk["created_at"]; ?> 
                                                                    <?php if($sevk["bitti"] == 1): ?>
                                                                        <div class="badge rounded-pill bg-success">SEVK TAMAMLANDI</div>
                                                                    <?php endif; ?>
                                                                    <?php if($sevk["bitti"] == 2): ?>
                                                                        <div class="badge rounded-pill bg-danger">MANUEL KAPATILDI</div>
                                                                    <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                       <?php } ?>
                                                    <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class=" d-md-inline d-none">
                                        <a href="<?= route_to('user_logout') ?>" class="nk-quick-nav-icon">
                                            <div class="icon-status icon-status-na"><em class="icon ni ni-signout"></em></div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

<style>
@media screen and (max-width: 1024px) {
    body {
        zoom: 90%;
        padding: 20px;
    }
    .nk-menu-trigger{
      display:none!important;
    }
}

.nk-sidebar, .nk-block-tools-opt, .nk-header-tools .dropdown:not(.notification-dropdown) .link-list{
  opacity: 0;
  display: none!important;
}
.nk-sidebar + .nk-wrap {
    transition: padding 450ms ease;
    padding-left: 0px !important;
}

/* DEV BUTON TASARIMI */
.pallet-action-button {
    background: linear-gradient(145deg, #ffffff, #f0f0f0);
    border: 2px solid #e0e0e0;
    border-radius: 25px;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    padding: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    min-height: 320px;
    width: 100%;
}
.pallet-action-button:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    border-color: #4f68f6;
}
.pallet-action-icon {
    font-size: 4.5rem;
    color: #4f68f6;
    margin-bottom: 20px;
    line-height: 1;
}
.pallet-action-title {
    font-size: 2rem;
    font-weight: 800;
    color: #364a7e;
    line-height: 1.2;
    margin: 0;
}
.pallet-action-subtitle {
    font-size: 1.3rem;
    font-weight: 700;
    color: #8094ae;
    margin-top: 12px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

</style>

<section id="barcode">
<div class="container-xl wide-xl" style="margin-top: 2rem;">
    <div class="text-center mb-5">
        <h1 style="font-size: 4rem; font-weight: bold; color: #4f68f6;">PALET OPERATÖR PANELİ</h1>
        <p style="font-size: 1.4rem; color: #526484;">Yazdırmak istediğiniz paleti seçin</p>
    </div>
    
    <!-- Palet Listesi -->
    <div class="row g-4">
        <?php 
        if(isset($kategori_urunleri) && !empty($kategori_urunleri)) {
            foreach($kategori_urunleri as $palet): 
                $paletId = 'P' . str_pad($palet['stock_id'], 3, '0', STR_PAD_LEFT);
                $koliBasligi = 'Palet İçeriği Tanımsız';
                if (!empty($palet['stok_koli'][0]['stock_title'])) {
                    $koliBasligi = $palet['stok_koli'][0]['stock_title'];
                }
        ?>
        <div class="col-lg-6">
            <div class="pallet-action-button" onclick="previewEtiket('<?= $paletId ?>')">
                <em class="icon ni ni-printer pallet-action-icon"></em>
                <h3 class="pallet-action-title"><?= htmlspecialchars($koliBasligi) ?></h3>
                <p class="pallet-action-subtitle">Etiket Yazdır</p>
            </div>
        </div>
        <?php 
            endforeach;
        } else {
        ?>
        <div class="col-12">
            <div class="card card-bordered py-5">
                <div class="text-center">
                    <em class="icon ni ni-search" style="font-size: 4rem; color: #dbdfea;"></em>
                    <h3 class="mt-3">Palet Bulunamadı</h3>
                    <p class="text-soft">Bu kategoriye ait görüntülenecek palet bulunmuyor.</p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function previewEtiket(paletId) {
    const previewWindow = window.open('', '_blank', 'width=600,height=900');
    const paletBilgi = getPaletBilgi(paletId);
    
    if (!paletBilgi) {
        previewWindow.document.write('<h1>Palet bilgisi bulunamadı!</h1>');
        previewWindow.document.close();
        return;
    }

    const previewHTML = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Palet Etiketi Önizleme - ${paletId}</title>
            <style>
                body { margin: 0; padding: 20px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: #f0f2f5; }
                .etiket { border: 2px solid #333; width: 400px; margin: 0 auto; background-color: white; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
                .etiket-ust-bilgi { text-align: center; padding: 20px; border-bottom: 2px solid #333; }
                .musteri-adi { font-size: 28px; font-weight: 900; color: #005a9e; letter-spacing: 1px; }
                .palet-adi { font-size: 24px; font-weight: bold; color: #333; margin-top: 5px; }
                .etiket-body { padding: 20px; text-align: center; }
                .etiket-bottom { background: #333; color: white; padding: 10px; text-align: center; font-size: 10px; }
                .palet-kodu { font-size: 60px; font-weight: bold; color: #000; letter-spacing: 2px; margin-bottom: 10px; font-family: "Courier New", monospace; }
                .barcode-container { padding: 15px; text-align: center; background: white; border-top: 2px solid #333; }
                .barcode-label { font-weight: bold; font-size: 16px; margin-bottom: 5px; color: #333; text-transform: uppercase; }
                .print-button-container { text-align: center; margin-top: 20px; }
                .print-button { background: #007bff; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; }
                @media print {
                    body { background-color: white; padding: 0; }
                    .etiket { box-shadow: none; margin: 0; border: 2px solid #000; }
                    .print-button-container { display: none; }
                }
            </style>
            <script>
                function generateAllBarcodes() {
                    document.addEventListener('DOMContentLoaded', function() {
                        const palletBarcodeElement = document.getElementById('pallet-barcode');
                        const koliBarcodeElement = document.getElementById('koli-barcode');

                        if (typeof JsBarcode !== 'undefined') {
                            if (palletBarcodeElement) {
                                JsBarcode(palletBarcodeElement, "${paletId}", {
                                    format: "CODE128", height: 50, displayValue: true
                                });
                            }
                            if (koliBarcodeElement && "${paletBilgi.koli_barcode}") {
                                JsBarcode(koliBarcodeElement, "${paletBilgi.koli_barcode}", {
                                    format: "CODE128", height: 50, displayValue: true
                                });
                            }
                        }
                    });
                }
                function handleBarcodeError() {
                    document.addEventListener('DOMContentLoaded', function() {
                        document.body.innerHTML = '<h2 style="color:red; text-align:center;">Barkod kütüphanesi yüklenemedi. İnternet bağlantınızı kontrol edin.</h2>';
                    });
                }
            <\/script>
            <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js" onload="generateAllBarcodes()" onerror="handleBarcodeError()"><\/script>
        </head>
        <body>
            <div class="etiket">
                <div class="etiket-ust-bilgi">
                    <div class="musteri-adi">${paletBilgi.musteri_adi}</div>
                </div>
                <div class="etiket-body">
                    <div class="palet-kodu">${paletId}</div>
                    <div class="palet-adi">${paletBilgi.koli_adi} (${paletBilgi.koli_total_amount} Adet)</div>
                </div>

              

                <div class="barcode-container" style="border-top: 1px solid #ccc;">
                    <div class="barcode-label">PALET BARKODU</div>
                    <svg id="koli-barcode"></svg>
                </div>
                
                <div class="etiket-bottom">
                    <div style="font-weight: bold;">KELEŞOĞLU GRUP</div>
                </div>
            </div>
            <div class="print-button-container">
                <button onclick="window.print()" class="print-button">🖨️ Yazdır</button>
            </div>
        </body>
        </html>
    `;
    
    previewWindow.document.write(previewHTML);
    previewWindow.document.close();
}

function getPaletBilgi(paletId) {
    <?php if(isset($kategori_urunleri) && !empty($kategori_urunleri)): ?>
    const paletVerileri = <?= json_encode($kategori_urunleri) ?>;
    const stockId = parseInt(paletId.replace('P', ''), 10);
    const palet = paletVerileri.find(p => parseInt(p.stock_id, 10) === stockId);
    
    if (palet && palet.stok_koli && palet.stok_koli.length > 0) {
        const koli = palet.stok_koli[0]; // İlk koliyi ana referans alıyoruz
        
        return {
            musteri_adi: palet.supplier_stock_code || 'CARREFOUR',
            palet_adi: palet.stock_title,
            koli_total_amount: parseFloat(koli.total_amount).toFixed(0), // Doğru değer: koli nesnesinden alınıyor
            koli_adi: koli.stock_title, // Kolinin kendi başlığı
            koli_barcode: koli.stock_barcode, // Kolinin kendi barkodu
        };
    }
    <?php endif; ?>
    
    return null;
}
</script>

<?= $this->include('tportal/inc/footer') ?>

