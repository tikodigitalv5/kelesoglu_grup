<?= $this->section('page_title') ?> Operatör Sayfası
<?= $this->endSection() ?>
<?= $this->section('title') ?> <?php echo $operation_title ?? 'Palet'; ?> Operatörü | <?= session()->get('user_item')['user_adsoyad'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>

<?= $this->include('tportal/inc/head') ?>

<!-- Bootstrap JS for Modal Support -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
                $koliSayisi = 0;
                
                if (!empty($palet['stok_koli'][0]['stock_title'])) {
                    $koliBasligi = $palet['stok_koli'][0]['stock_title'];
                    $koliSayisi = intval($palet['stok_koli'][0]['used_amount']);
                }
        ?>
        <div class="col-lg-6">
            <div class="pallet-action-button" onclick="previewEtiket('<?= $paletId ?>')">
                <em class="icon ni ni-printer pallet-action-icon"></em>
                <h3 class="pallet-action-title"><?= htmlspecialchars($koliBasligi) ?></h3>
                <p class="pallet-action-subtitle">
                    <?php if($koliSayisi > 0): ?>
                        <?= $koliSayisi ?> Kolili Palet
                    <?php endif; ?>
                    Etiket Yazdır
                </p>
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
    // Palet ID'sini çıkar (P001 -> 001)
    const stockId = paletId.replace('P', '');
    
    // Loading modal göster
    showLoadingModal();
    
    // AJAX isteği ile paletSatisControl metodunu çağır
    $.ajax({
        url: '<?= route_to("tportal.paletSatisControl") ?>',
        type: 'POST',
        data: {
            palet_id: stockId
        },
        dataType: 'json',
        success: function(response) {
            hideLoadingModal();
            
            if (response.icon === 'success') {
                showStockAnalysisModal(response.data, paletId);
            } else {
                showErrorModal(response.title, response.text);
            }
        },
        error: function(xhr, status, error) {
            hideLoadingModal();
            showErrorModal('Hata', 'Sunucu ile bağlantı kurulamadı: ' + error);
        }
    });
}

// Loading modal fonksiyonları
function showLoadingModal() {
    const loadingHtml = `
        <div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center py-5">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Yükleniyor...</span>
                        </div>
                        <h5>Stok Analizi Yapılıyor...</h5>
                        <p class="text-muted">Lütfen bekleyiniz</p>
                    </div>
                </div>
            </div>
        </div>
    `;
    $('body').append(loadingHtml);
    $('#loadingModal').modal('show');
}

function hideLoadingModal() {
    $('#loadingModal').modal('hide');
    setTimeout(() => {
        $('#loadingModal').remove();
    }, 300);
}

// Stok analizi modal fonksiyonu
function showStockAnalysisModal(data, paletId) {
    const { palet_bilgisi, stok_analizi, eksik_urunler, yeterli_urunler, cikarilacak_stok } = data;
    
    let modalContent = `
        <div class="modal fade" id="stockAnalysisModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="icon ni ni-package me-2"></i>
                            Stok Analizi - ${palet_bilgisi.stock_title}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Palet Bilgileri -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary">📦 Palet Bilgileri</h6>
                                        <p><strong>Kod:</strong> ${palet_bilgisi.stock_code}</p>
                                        <p><strong>Palet İçeriği:</strong> <span class="badge bg-primary">${parseInt(palet_bilgisi.istenen_koli)} Koli</span></p>
                                        <p><strong>Toplam Ürün:</strong> ${palet_bilgisi.toplam_urun_sayisi} çeşit</p>
                                        <br>
                                     
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" >
                                <div style="padding-bottom:17px;" class="card border-${getStatusColor(stok_analizi.genel_durum)}">
                                    <div class="card-body">
                                        <h6 class="card-title text-${getStatusColor(stok_analizi.genel_durum)}">📊 Durum Özeti</h6>
                                        <p><strong>Maksimum Koli:</strong> 
                                            ${eksik_urunler.length > 0 ? 
                                                '<span class="badge bg-danger">0 adet</span><br><small class="text-muted">Eksik ürün olduğu için hiç üretilemez</small>' : 
                                                '<span class="badge bg-success">' + parseInt(palet_bilgisi.istenen_koli) + ' adet</span><br><small class="text-muted">Tüm ürünler yeterli, tam üretim yapılabilir</small>'
                                            }
                                        </p>
                                        <p><strong>Genel Durum:</strong> <span class="badge bg-${getStatusColor(stok_analizi.genel_durum)}">${stok_analizi.genel_durum}</span></p>
                                        <p><strong>Yeterli Ürün:</strong> 
                                            <span class="badge bg-success">${stok_analizi.yeterli_urun_sayisi}</span> / 
                                            <span class="badge bg-secondary">${stok_analizi.yeterli_urun_sayisi + stok_analizi.eksik_urun_sayisi}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
    `;
    
    // Eksik ürünler varsa göster
    if (eksik_urunler.length > 0) {
        modalContent += `
            <div class="alert alert-danger">
                <h6><i class="icon ni ni-alert-circle me-2"></i>⚠️ Eksik Stok Uyarısı (${eksik_urunler.length} ürün)</h6>
                <div class="alert alert-warning mb-3">
                    <h6><i class="icon ni ni-info me-2"></i>Etiket yazdırma işlemi durduruldu!</h6>
                    <p class="mb-2">Aşağıdaki ürünlerde yetersiz stok bulunmaktadır. Etiket yazdırabilmek için önce bu ürünlerin stoklarını tamamlamanız gerekmektedir.</p>
                    <p class="mb-0"><strong>Çözüm:</strong> Bu ürünler için <strong>Alış Faturası</strong> ile <strong>Stok Hareketi</strong> girmeniz gerekiyor.</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Ürün Adı</th>
                                <th>Gerekli</th>
                                <th>Mevcut</th>
                                <th>Eksik</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
        `;
        eksik_urunler.forEach(urun => {
            modalContent += `
                <tr>
                    <td>${urun.urun_adi}</td>
                    <td>${urun.gerekli_miktar}</td>
                    <td>${urun.mevcut_stok}</td>
                    <td><span class="badge bg-danger">${urun.eksik_miktar}</span></td>
                    <td><span class="badge bg-danger">STOK EKSİK</span></td>
                </tr>
            `;
        });
        modalContent += `
                        </tbody>
                    </table>
                </div>
                <div class="alert alert-info mt-3">
                    <h6><i class="icon ni ni-lightbulb me-2"></i>Yapılması Gerekenler:</h6>
                    <ol class="mb-0">
                        <li>Eksik ürünler için <strong>Alış Faturası</strong> oluşturun</li>
                        <li>Faturayı onaylayarak <strong>Stok Hareketi</strong> gerçekleştirin</li>
                        <li>Stoklar güncellendikten sonra tekrar etiket yazdırma işlemini deneyin</li>
                    </ol>
                </div>
            </div>
        `;
    }
    
    // Yeterli ürünler varsa göster
    if (yeterli_urunler.length > 0) {
        modalContent += `
            <div class="alert alert-success">
                <h6><i class="icon ni ni-check-circle me-2"></i>✅ Yeterli Ürünler (${yeterli_urunler.length} adet)</h6>
                <p class="mb-2">Bu ürünler yeterli stokta mevcut. ${yeterli_urunler.length > 8 ? '<small class="text-muted">(Liste uzun olduğu için sağda scroll bar bulunmaktadır)</small>' : ''}</p>
                <div class="table-responsive" style="max-height: 200px; overflow-y: scroll; border: 1px solid #d1ecf1; border-radius: 5px;">
                    <style>
                        .table-responsive::-webkit-scrollbar {
                            width: 8px;
                        }
                        .table-responsive::-webkit-scrollbar-track {
                            background: #f1f1f1;
                            border-radius: 4px;
                        }
                        .table-responsive::-webkit-scrollbar-thumb {
                            background: #28a745;
                            border-radius: 4px;
                        }
                        .table-responsive::-webkit-scrollbar-thumb:hover {
                            background: #218838;
                        }
                    </style>
                    <table class="table table-sm table-striped mb-0">
                        <thead class="table-success sticky-top">
                            <tr>
                                <th>Ürün Adı</th>
                                <th>Gerekli</th>
                                <th>Mevcut</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
        `;
        yeterli_urunler.forEach(urun => {
            modalContent += `
                <tr>
                    <td>${urun.urun_adi}</td>
                    <td><span class="badge bg-primary">${urun.gerekli_miktar}</span></td>
                    <td><span class="badge bg-success">${urun.mevcut_stok}</span></td>
                    <td><span class="badge bg-success">YETERLİ</span></td>
                </tr>
            `;
        });
        modalContent += `
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    }
    
    // Çıkarılacak stok bilgisi
    modalContent += `
        <div class="alert alert-info">
            <h6><i class="icon ni ni-info me-2"></i>Çıkarılacak Stok</h6>
            <p><strong>Toplam Koli:</strong> ${cikarilacak_stok.toplam_koli} adet</p>
            <p><strong>Toplam Ürün Çeşidi:</strong> ${cikarilacak_stok.urun_listesi.length} adet</p>
        </div>
    `;
    
    modalContent += `
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
    `;
    
    // Durum kontrolü ve buton ekleme - Eksik varsa kesinlikle devam edemesin
    if (eksik_urunler.length > 0) {
        // Eksik ürün varsa kesinlikle yazdırma butonu yok
        modalContent += `
            <button type="button" class="btn btn-danger" disabled>
                <i class="icon ni ni-cross me-2"></i>Etiket Yazdırılamaz (Eksik Stok)
            </button>
        `;
    } else if (stok_analizi.genel_durum === 'YETERLI') {
        // Tüm ürünler yeterli ise yazdırma butonu aktif
        modalContent += `
            <button type="button" class="btn btn-success" onclick="confirmPrintEtiket('${paletId}', ${cikarilacak_stok.toplam_koli}, 'Tam')">
                <i class="icon ni ni-printer me-2"></i>Etiket Yazdır (1 Palet içinde ${cikarilacak_stok.toplam_koli} koli)
            </button>
        `;
    } else {
        // Hiç stok yoksa yazdırma butonu yok
        modalContent += `
            <button type="button" class="btn btn-danger" disabled>
                <i class="icon ni ni-cross me-2"></i>Etiket Yazdırılamaz (Stok Yok)
            </button>
        `;
    }
    
    modalContent += `
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('body').append(modalContent);
    $('#stockAnalysisModal').modal('show');
    
    // Modal kapandığında temizle
    $('#stockAnalysisModal').on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

// Hata modal fonksiyonu
function showErrorModal(title, message) {
    const errorHtml = `
        <div class="modal fade" id="errorModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="icon ni ni-alert-circle me-2"></i>
                            ${title}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>${message}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tamam</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    $('body').append(errorHtml);
    $('#errorModal').modal('show');
    
    $('#errorModal').on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

// Durum rengi belirleme
function getStatusColor(status) {
    switch(status) {
        case 'YETERLI': return 'success';
        case 'KISMEN_YETERLI': return 'warning';
        case 'YETERSIZ': return 'danger';
        default: return 'secondary';
    }
}

// Onay modal'ı göster
function confirmPrintEtiket(paletId, koliSayisi, tip) {
    // Önce eski modal'ı kapat ve backdrop'u temizle
    $('#stockAnalysisModal').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
    
    // Kısa bir gecikme sonra yeni modal'ı aç
    setTimeout(() => {
        const onayHtml = `
        <div class="modal fade" id="confirmPrintModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header border-0 bg-gradient text-black" style="background: linear-gradient(135deg, #28a745, #20c997);">
                        <h5 class="modal-title fw-bold">
                            <i class="icon ni ni-printer me-2"></i>
                            Etiket Yazdırma Onayı
                        </h5>
                        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <!-- Loading Animation -->
                        <div class="mb-4">
                            <div class="spinner-border text-success mb-3" role="status" style="width: 3rem; height: 3rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h6 class="text-muted">Etiket Hazırlanıyor...</h6>
                        </div>
                        
                        <!-- Bilgi Kartı -->
                        <div class="card border-0 bg-light mb-4">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-end">
                                            <h6 class="text-muted mb-1">Palet Kodu</h6>
                                            <h5 class="text-primary fw-bold mb-0">${paletId}</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-muted mb-1">Koli Sayısı</h6>
                                        <h5 class="text-success fw-bold mb-0">${koliSayisi} Koli</h5>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1">Yazdırılacak</h6>
                                    <h4 class="text-dark fw-bold mb-0">1 Palet içinde ${koliSayisi} koli</h4>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Onay Mesajı -->
                        <div class="alert alert-info border-0">
                            <i class="icon ni ni-info-circle me-2"></i>
                            <strong>Bu işlemi onaylıyor musunuz?</strong>
                            <br>
                            <small class="text-muted">Etiket yazdırma işlemi başlatılacak.</small>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            <i class="icon ni ni-cross me-2"></i>İptal
                        </button>
                        <button type="button" class="btn btn-success px-4 fw-bold" onclick="printEtiket('${paletId}', ${koliSayisi})">
                            <i class="icon ni ni-printer me-2"></i>Evet, Yazdır
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
        $('body').append(onayHtml);
        $('#confirmPrintModal').modal('show');
        
        // Modal kapandığında temizle
        $('#confirmPrintModal').on('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $(this).remove();
        });
    }, 300); // 300ms gecikme
}

// Etiket yazdırma fonksiyonu
function printEtiket(paletId, koliSayisi = null) {
    // Onay modal'ını kapat ve backdrop'u temizle
    $('#confirmPrintModal').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
    
    // Loading modal göster
    showPrintLoadingModal();
    
    // Palet ID'sini çıkar (P085 -> 85)
    const stockId = paletId.replace('P', '');
    
    // AJAX isteği ile printEtiket metodunu çağır
    $.ajax({
        url: '<?= route_to("tportal.printEtiket") ?>',
        type: 'POST',
        data: {
            palet_id: stockId,
            koli_sayisi: koliSayisi
        },
        dataType: 'json',
        success: function(response) {
            hidePrintLoadingModal();
            
            if (response.icon === 'success') {
                // Etiket önizleme penceresini aç
                showEtiketPreview(response.data, paletId, koliSayisi);
            } else {
                showErrorModal(response.title, response.text);
            }
        },
        error: function(xhr, status, error) {
            hidePrintLoadingModal();
            showErrorModal('Hata', 'Sunucu ile bağlantı kurulamadı: ' + error);
        }
    });
}

// Print loading modal fonksiyonları
function showPrintLoadingModal() {
    const loadingHtml = `
        <div class="modal fade" id="printLoadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center py-5">
                        <div class="spinner-border text-success mb-3" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Yükleniyor...</span>
                        </div>
                        <h5>Etiket Hazırlanıyor...</h5>
                        <p class="text-muted">Lütfen bekleyiniz</p>
                    </div>
                </div>
            </div>
        </div>
    `;
    $('body').append(loadingHtml);
    $('#printLoadingModal').modal('show');
}

function hidePrintLoadingModal() {
    $('#printLoadingModal').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
    setTimeout(() => {
        $('#printLoadingModal').remove();
    }, 300);
}

// Etiket önizleme fonksiyonu
function showEtiketPreview(data, paletId, koliSayisi) {
    const { etiket_data, yazdirma_bilgisi } = data;
    const { palet_bilgisi, cari_adi, barcode_svg } = etiket_data;
    
    const previewWindow = window.open('', '_blank', 'width=600,height=900');
    
    // HTML içeriğini ayrı ayrı oluştur
    let previewHTML = '<!DOCTYPE html><html><head>';
    previewHTML += '<title>Palet Etiketi - ' + paletId + '</title>';
    previewHTML += '<style>';
    previewHTML += 'body { margin: 0; padding: 20px; font-family: Arial, sans-serif; background-color: #f0f2f5; }';
    previewHTML += '.etiket { border: 2px solid #333; width: 400px; margin: 0 auto; background-color: white; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }';
    previewHTML += '.etiket-ust-bilgi { text-align: center; padding: 20px; border-bottom: 2px solid #333; }';
    previewHTML += '.musteri-adi { font-size: 28px; font-weight: 900; color: #005a9e; letter-spacing: 1px; }';
    previewHTML += '.palet-adi { font-size: 24px; font-weight: bold; color: #333; margin-top: 5px; }';
    previewHTML += '.etiket-body { padding: 20px; text-align: center; }';
    previewHTML += '.etiket-bottom { background: #333; color: white; padding: 10px; text-align: center; font-size: 10px; }';
    previewHTML += '.palet-kodu { font-size: 60px; font-weight: bold; color: #000; letter-spacing: 2px; margin-bottom: 10px; font-family: "Courier New", monospace; }';
    previewHTML += '.barcode-container { padding: 15px; text-align: center; background: white; border-top: 2px solid #333; }';
    previewHTML += '.barcode-label { font-weight: bold; font-size: 16px; margin-bottom: 5px; color: #333; text-transform: uppercase; }';
    previewHTML += '.barcode-svg { margin: 10px 0; }';
    previewHTML += '.print-button-container { text-align: center; margin-top: 20px; }';
    previewHTML += '.print-button { background: #007bff; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; }';
    previewHTML += '@media print { body { background-color: white; padding: 0; } .etiket { box-shadow: none; margin: 0; border: 2px solid #000; } .print-button-container { display: none; } }';
    previewHTML += '</style>';
    previewHTML += '</head><body>';
    previewHTML += '<div class="etiket">';
    previewHTML += '<div class="etiket-ust-bilgi"><div class="musteri-adi">' + cari_adi + '</div></div>';
    previewHTML += '<div class="etiket-body">';
    previewHTML += '<div class="palet-kodu">' + paletId + '</div>';
    previewHTML += '<div class="palet-adi">' + palet_bilgisi.stock_title + '</div>';
    previewHTML += '<div class="palet-adi">' + koliSayisi + ' Koli</div>';
    previewHTML += '</div>';
    previewHTML += '<div class="barcode-container">';
    previewHTML += '<div class="barcode-label">PALET BARKODU</div>';
    previewHTML += '<div class="barcode-svg">' + barcode_svg + '</div>';
    previewHTML += '</div>';
    previewHTML += '<div class="etiket-bottom">';
    previewHTML += '<div style="font-weight: bold;">' + yazdirma_bilgisi.yazdirma_tarihi + '</div>';
    previewHTML += '</div>';
    previewHTML += '</div>';
    previewHTML += '<div class="print-button-container">';
    previewHTML += '<button onclick="window.print()" class="print-button">🖨️ Yazdır</button>';
    previewHTML += '</div>';
    previewHTML += '</body></html>';
    
    previewWindow.document.write(previewHTML);
    previewWindow.document.close();
}






</script>

<?= $this->include('tportal/inc/footer') ?>

