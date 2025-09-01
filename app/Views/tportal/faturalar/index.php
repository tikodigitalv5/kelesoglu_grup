<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> <?= $page_title ?> <?= $this->endSection() ?>
<?= $this->section('title') ?> <?= $page_title ?> | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>

<style>
    .dropdown-menu-xl {
    min-width: 460px;
    max-width: 460px;
}
.bg-success-dim {
    background-color: rgba(30, 224, 172, 0.15) !important;
}
.bg-warning-dim {
    background-color: rgba(244, 189, 14, 0.15) !important;
}
.bg-danger-dim {
    background-color: rgba(232, 83, 71, 0.15) !important;
}
.bg-info-dim {
    background-color: rgba(9, 113, 254, 0.15) !important;
}
.bg-primary-dim {
    background-color: rgba(101, 118, 255, 0.15) !important;
}

/* Hover efekti için */
.bg-success-dim:hover {
    background-color: rgba(30, 224, 172, 0.25) !important;
}
.bg-warning-dim:hover {
    background-color: rgba(244, 189, 14, 0.25) !important;
}
.bg-danger-dim:hover {
    background-color: rgba(232, 83, 71, 0.25) !important;
}
.bg-info-dim:hover {
    background-color: rgba(9, 113, 254, 0.25) !important;
}
.bg-primary-dim:hover {
    background-color: rgba(101, 118, 255, 0.25) !important;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}
.shake {
    animation: shake 0.5s ease-in-out;
}

</style>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title"><?= $page_title ?></h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon  toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                    <li class="nk-block-tools-opt">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
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
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                    <div class="form-inline flex-nowrap gx-3">
                                        <div class="form-wrap w-150px">
                                            <select class="form-select js-select2" data-search="off" id="sltc_export" data-placeholder="Toplu İşlem">
                                                <option value="">Toplu İşlem</option>
                                                <option value="toExcel">İndir (Excel)</option>
                                                <option value="toPdf">İndir (PDF)</option>
                                                <option value="toPrint" disabled>Yazdır</option>
                                                <option value="#" disabled>Seçilenleri Sil</option>
                                            </select>
                                        </div>
                                        <div class="btn-wrap">
                                            <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light" id="applyExport">Uygula</button></span>
                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>

                                        </div>
                                       <!-- Buton HTML'i -->
                                        <?php  if(session()->get('user_item')['efatura']):?>
                                        <span class="d-md-block">
                                            <button class="btn btn-dim btn-outline-primary" id="faturalariGuncelle">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                <span class="btn-text">Faturaları Güncelle</span>
                                            </button>
                                        </span>
                                        <?php endif;?>
                                        <!-- SweetAlert2 için gerekli modal -->
                                        <div class="modal fade" id="sonucModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Güncelleme Sonuçları</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="sonucListesi"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>

                                            <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search">
                                                <div class="dot dot-primary d-none" id="notification-dot-search"></div><em class="icon ni ni-search"></em>
                                            </a>
                                        </li><!-- li -->
                                        <li class="btn-toolbar-sep"></li><!-- li -->
                                        <li>
                                            <div class="toggle-wrap">
                                                <a href="#" class="btn btn-icon  toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                <div class="toggle-content" data-content="cardTools">
                                                    <ul class="btn-toolbar gx-1">
                                                        <li class="toggle-close">
                                                            <a href="#" class="btn btn-icon  toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn  btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                                    <div class="dot dot-primary d-none" id="notification-dot"></div>
                                                                    <em class="icon ni ni-filter"></em>
                                                                </a>
                                                                <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                                    <div class="dropdown-head">
                                                                        <span class="sub-title dropdown-title">Detaylı
                                                                            Arama</span>
                                                                        <div class="dropdown">
                                                                            <a href="#" class=" d-none btn btn-sm btn-icon">
                                                                                <em class="icon ni ni-more-h"></em>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dropdown-body dropdown-body-rg">
                                                                        <div class="row gx-6 gy-3">
                                                                            <div class="col-6 d-none">
                                                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input" id="hasBalance">
                                                                                    <label class="custom-control-label" for="hasBalance"> Have
                                                                                        Balance</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6 d-none">
                                                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input" id="hasKYC">
                                                                                    <label class="custom-control-label" for="hasKYC"> KYC
                                                                                        Verified</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6 d-none">
                                                                                <div class="form-group">
                                                                                    <label class="overline-title overline-title-alt">Kategori</label>
                                                                                    <select class="form-select js-select2" id="category-filter-dropdown">
                                                                                        <option value="0" selected disabled>Seçiniz</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12">
                                                                           <div class="row">
                                                                           <div class="form-group col-6 mt-2">
                                                                                    <label class="overline-title overline-title-alt">Fatura Tipi</label>
                                                                                    <select class="form-select js-select2" id="invoice-type-filter-dropdown" data-ui="lg">
                                                                                        <option value="null" selected >Seçiniz</option>
                                                                                        <option value="incoming_invoice">Alış</option>
                                                                                        <option value="outgoing_invoice">Satış</option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="form-group col-6 mt-2">
                                                                                    <label class="overline-title overline-title-alt">Fatura Ödeme Durumu</label>
                                                                                    <select class="form-select js-select2" id="is_quick_collection_financial_movement_id" data-ui="lg">
                                                                                        <option value="null" selected >Seçiniz</option>
                                                                                        <option value="1">Ödendi</option>
                                                                                        <option value="0">Ödenmedi</option>
                                                                                    </select>
                                                                                </div>
                                                                           </div>

                                                                                <div class="row">
                                                                                <div class="col-6">
    <div class="form-group">
        <label class="overline-title overline-title-alt">Fatura Başlangıç Tarihi</label>
        <div class="form-control-wrap">
            <div class="form-icon form-icon-right">
                <em class="icon ni icon-lg ni-calendar-alt"></em>
            </div>
            <div class="input-daterange date-picker input-group">
                <input style="text-align:left;" type="text" name="invoice_date_start" id="invoice_date_start" class="form-control form-control-lg"  placeholder="dd/mm/yyyy" />
            </div>
        </div>
    </div>
    
</div>
<div class="col-6">
<div class="form-group">
        <label class="overline-title overline-title-alt">Fatura Bitiş Tarihi</label>
        <div class="form-control-wrap">
            <div class="form-icon form-icon-right">
                <em class="icon ni icon-lg ni-calendar-alt"></em>
            </div>
            <div class="input-daterange date-picker input-group">
                <input style="text-align:left;" type="text" name="invoice_date_end" id="invoice_date_end" class="form-control form-control-lg" placeholder="dd/mm/yyyy"     />
            </div>
        </div>
    </div>
    </div>
<div class="col-6 mt-2">
    <div class="form-group">
        <label class="overline-title overline-title-alt">Vade Başlangıç Tarihi</label>
        <div class="form-control-wrap">
            <div class="form-icon form-icon-right">
                <em class="icon ni icon-lg ni-calendar-alt"></em>
            </div>
            <div class="input-daterange date-picker input-group">
                <input type="text" style="text-align:left;"  name="expiry_date_start" id="expiry_date_start" class="form-control form-control-lg" placeholder="dd/mm/yyyy" />
            </div>
        </div>
    </div>
</div>

<div class="col-6 mt-2">
    <div class="form-group">
        <label class="overline-title overline-title-alt">Vade Bitiş Tarihi</label>
        <div class="form-control-wrap">
            <div class="form-icon form-icon-right">
                <em class="icon ni icon-lg ni-calendar-alt"></em>
            </div>
            <div class="input-daterange date-picker input-group">
                <input type="text" style="text-align:left;"  name="expiry_date_end" id="expiry_date_end" class="form-control form-control-lg" placeholder="dd/mm/yyyy" />
            </div>
        </div>
    </div>
</div>
                                                                                </div>
                                                                               
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dropdown-foot between">
                                                                        <button type="button" class="btn btn-secondary" id="applyFilter">Filtrele</button>
                                                                        <button type="button" class="btn btn-light" id="clearFilter">Filtreyi Sıfırla</button>

                                                                        <!-- <a href="#">Filtreyi Kaydet</a> -->
                                                                    </div>
                                                                </div><!-- .filter-wg -->
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn  btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-filter-alt"></em>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                                                    <ul class="link-check">
                                                                        <li><span>Sayfalama</span></li>
                                                                        <li><a href="javascript:;" id="row-10">10</a></li>
                                                                        <li><a href="javascript:;" id="row-25">25</a></li>
                                                                        <li><a href="javascript:;" id="row-50">50</a></li>
                                                                        <li><a href="javascript:;" id="row-100">100</a></li>
                                                                        <li><a href="javascript:;" id="row-200">200</a></li>
                                                                        <li><a href="javascript:;" id="row-1000">1000</a></li>
                                                                        <!-- <li><a href="javascript:;" id="row-all">Tümü</a></li> -->
                                                                    </ul>
                                                                    <!-- <ul class="link-check">
                                                                      <li><span>Order</span></li>
                                                                      <li class="active"><a href="#">DESC</a></li>
                                                                      <li><a href="#">ASC</a></li>
                                                                  </ul> -->
                                                                </div>
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                    </ul><!-- .btn-toolbar -->
                                                </div><!-- .toggle-content -->
                                            </div><!-- .toggle-wrap -->
                                        </li><!-- li -->
                                    </ul><!-- .btn-toolbar -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" id="invoice_input_search" class="form-control border-transparent form-focus-none" placeholder="Bulmak istediğiniz faturanın fatura ünvanını veya fatura numarasını yazınız...">
                                        <a href="#" class="btn btn-icon toggle-search active" data-target="search" style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em class="icon ni ni-cross"></em></a>
                                        <button class="search-submit btn btn-icon" style="margin-right: 50px;" id="invoice_input_search_clear_button" name="invoice_input_search_clear_button"><em class="icon ni ni-trash"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div><!-- .card-inner -->


                        <div class="card-inner p-0">
                            <table id="datatableInvoice" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                <thead>
                                    <tr class="nk-tb-item nk-tb-head tb-tnx-head">
                                        <th class="nk-tb-col nk-tb-col-check">
                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                <input type="checkbox" class="custom-control-input" id="selectAllInvoice">
                                                <label class="custom-control-label" for="selectAllInvoice"></label>
                                            </div>
                                        </th>

                                        <th class="nk-tb-col"><span class="sub-text">MÜŞTERİ / E-POSTA</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">F. NUMARASI</span></th>
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">F. TARİHİ</span></th>
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">VADE TARİHİ</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">F. TİPİ</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">F. DURUMU</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">F. TUTARI</span></th>
                                        <th class="nk-tb-col  nk-tb-col-tools text-end" data-orderable="false">  </th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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
$(document).ready(function() {

    <?php if(session()->get('user_item')['user_id'] == 5) { ?>
        // --- PROFORMA FATURA BİLDİRİM SİSTEMİ ---



   


        // 1. Modal ve stil kodunu sayfa yüklendiğinde SADECE BİR KEZ ekle.
        // Bu, sürekli DOM manipülasyonunu ve arka plan sorunlarını önler.
        $('body').append(`
            <style>
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                    20%, 40%, 60%, 80% { transform: translateX(5px); }
                }
                .shake {
                    animation: shake 0.5s ease-in-out;
                }
                #proformaBildirimModal .modal-header {
                    background-color: #f4bd0e; /* A slightly deeper yellow */
                    color: white;
                    border-bottom: none;
                    padding: 1.5rem;
                }
                 #proformaBildirimModal .modal-header .btn-close {
                    filter: invert(1) grayscale(100%) brightness(200%);
                }
                #proformaBildirimModal .modal-title {
                     font-size: 1.25rem;
                     font-weight: 700;
                     letter-spacing: 0.5px;
                }

                #proformaBildirimModal .alert-warning {
                    background-color: #fff3cd;
                    border-color: #ffeeba;
                    color: #664d03;
                    border-radius: .4rem;
                    padding: 1.5rem;
                    display: flex;
                    align-items: center;
                }
                #proformaBildirimModal .alert-warning .icon {
                    font-size: 2.5rem;
                    margin-right: 1.5rem;
                }
                #proformaBildirimModal .table-responsive {
                    max-height: 400px;
                }
                #proformaBildirimModal .table thead th {
                    background-color: #f8f9fa;
                    border-bottom-width: 1px;
                }
                #proformaBildirimModal .modal-footer .btn-primary {
                    background-color: #0971fe;
                    border-color: #0971fe;
                }

            </style>
            <div class="modal fade" id="proformaBildirimModal" tabindex="-1" role="dialog" aria-labelledby="proformaBildirimModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content shadow-lg" style="border-radius: .6rem;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="proformaBildirimModalLabel">
                                <em class="icon ni ni-alert-triangle-fill me-2"></em>
                                GÜNLÜK PROFORMA FATURA UYARISI
                            </h5>
                            <button type="button" class="btn-close" style="color:black!important; filter:none; font-weight:bold;" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="alert alert-warning" role="alert">
                                 <em class="icon ni ni-alarm-alt"></em>
                                <div>
                                    <h6 class="alert-heading fw-bold">
                                        Saat 17:00'a kadar imzalanmamış faturalar bulunmaktadır!
                                    </h6>
                                    <p class="mb-0">Aşağıdaki faturalar henüz imzalanmamış. Lütfen kontrol ediniz.</p>
                                </div>
                            </div>
                            <div id="proformaFaturaListesi" class="table-responsive mt-4"></div>
                        </div>
                        <div class="modal-footer">
                   
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kapat</button>
                            <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                                <em class="icon ni ni-reload me-2"></em>Sayfayı Yenile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `);

      

        // 2. Faturaları kontrol edecek fonksiyonu tanımla.
        const checkProformaInvoices = function() {
            $.ajax({
                url: '<?= route_to('tportal.faturalar.gunlukProformaFaturaBildirim') ?>',
                type: 'GET',
                dataType: 'json', // Sunucudan JSON beklediğimizi belirtelim
                success: function(response) {
                    if (response && response.success && response.data.toplam_fatura_sayisi > 0) {
                        // Fatura listesi için HTML oluştur
                        let faturaListesiHTML = '<table class="table table-hover">'; // Removed table-striped for a cleaner look
                        faturaListesiHTML += '<thead class="bg-light"><tr><th>Fatura No</th><th>Müşteri</th><th>Tarih</th><th>Tutar</th><th>Durum</th><th class="text-end">Detay</th></tr></thead><tbody>';

                        response.data.faturalar.forEach(function(fatura) {
                            const formattedAmount = parseFloat(fatura.grand_total_try).toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                            faturaListesiHTML += `
                                <tr>
                                    <td><strong>${fatura.invoice_no || '#PROFORMA'}</strong></td>
                                    <td>${fatura.cari_name || fatura.cari_invoice_title || 'N/A'}</td>
                                    <td>${new Date(fatura.created_at).toLocaleString('tr-TR')}</td>
                                    <td><span class="badge bg-primary fs-6">${formattedAmount} ₺</span></td>
                                    <td><span class="badge bg-danger">İmzalanmamış</span></td>
                                    <td class="text-end"><a href="../detail/${fatura.invoice_id}" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a></td>
                                </tr>`;
                        });

                        faturaListesiHTML += '</tbody></table>';

                        // Modal içeriğini güncelle
                        $('#proformaFaturaListesi').html(faturaListesiHTML);

                        // 3. Modal'ı göster. Bootstrap'in kendi mekanizması arka planı doğru yönetecektir.
                        $('#proformaBildirimModal').modal('show');

                       
                        // --- SES ÇALMA KODU BİTİŞ ---


                        // Ekstra görsel uyarılar
                        const originalTitle = document.title;
                        document.title = '⚠️ İMZALANMAMIŞ FATURA UYARISI!';
                        $('body').addClass('shake');

                        setTimeout(() => {
                            document.title = originalTitle;
                            $('body').removeClass('shake');
                        }, 4000);

                    }
                },
                error: function(xhr, status, error) {
                    console.error('Proforma fatura bildirim sorgusu başarısız oldu:', status, error);
                }
            });
        };

        // Sayfa yüklendikten 3 saniye sonra ilk kontrolü yap.
        setTimeout(checkProformaInvoices, 3000);

        // Her 5 dakikada bir (300000 ms) kontrolü tekrarla.
        setInterval(checkProformaInvoices, 300000);

    <?php } ?>

    // --- MEVCUT DİĞER SCRIPTLERİNİZ BURADAN DEVAM EDİYOR ---

    });
</script>
<script>


    // $(".nk-tb-item").click(function() {
    //     // alert($(this).data('url'));
    //     window.location.href = $(this).data('url');
    // });

    $(".custom-control-input").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(document).ready(function() {
    $('#faturalariGuncelle').on('click', function() {
        const btn = $(this);
        const btnSpinner = btn.find('.spinner-border');
        const btnText = btn.find('.btn-text');

        // Butonu devre dışı bırak ve spinner'ı göster
        btn.prop('disabled', true);
        btnSpinner.removeClass('d-none');
        btnText.text('Faturalar Senkronize Ediliyor...');

        Swal.fire({
            title: '<div class="modal-icon-wrapper">' +
                   '<h2 class="modal-title">Faturalar Senkronize Ediliyor</h2>',
            html: '<div class="modal-description">Lütfen bekleyiniz...</div>',
            showConfirmButton: false,
            allowOutsideClick: false,
            customClass: {
                popup: 'modal-popup'
            }
        });

        $.ajax({
            url: '/api/tikoportal/fatura/genel/guncelle',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    let sonucHTML = `
                        <div class="alert alert-success">
                            <strong>Toplam Başarılı:</strong> ${response.basarili}<br>
                            <strong>Toplam Başarısız:</strong> ${response.basarisiz}
                        </div>
                    `;

                    Swal.fire({
                        title: '<div class="modal-icon-wrapper">' +
                     
                               '<h2 class="modal-title">Faturalar Senkronize Edildi</h2>',
                        html: '',
                        confirmButtonText: 'Tamam',
                        customClass: {
                            popup: 'modal-popup',
                            confirmButton: 'btn btn-success'
                        }
                    });
                } else {
                    Swal.fire({
                        title: '<div class="modal-icon-wrapper">' +
                           
                               '<h2 class="modal-title">Hata</h2>',
                        html: `<div class="modal-description">${response.message}</div>`,
                        confirmButtonText: 'Tamam',
                        customClass: {
                            popup: 'modal-popup',
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: '<div class="modal-icon-wrapper">' +
                      
                           '<h2 class="modal-title">Hata</h2>',
                    html: '<div class="modal-description">Faturalar Senkronize Edilirken bir hata oluştu.</div>',
                    confirmButtonText: 'Tamam',
                    customClass: {
                        popup: 'modal-popup',
                        confirmButton: 'btn btn-danger'
                    }
                });
            },
            complete: function() {
                // Butonu normal haline getir
                btn.prop('disabled', false);
                btnSpinner.addClass('d-none');
                btnText.text('Faturalar Senkronize Edildi');
            }
        });
    });
});

    $(document).ready(function() {

        var base_url = window.location.origin;

        var url = window.location.pathname;
        var parts = url.split('/');
        var lastPart = parts[parts.length - 1];

        var myVar = $("#DataTables_Table_0_wrapper").find('.with-export').removeClass('d-none');
        var myVar2 = $("#DataTables_Table_0_wrapper").find('.with-export').css("margin-bottom", "10px");

        var table = NioApp.DataTable('#datatableInvoice', {
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: base_url + '/tportal/invoice/getInvoices/'+lastPart,
                data: function(d) {
                    d.invoice_status = $('#invoice-type-filter-dropdown').find(':selected').val(),
                    d.is_quick_collection_financial_movement_id = $('#is_quick_collection_financial_movement_id').find(':selected').val(),
                    d.invoice_date_start = $('#invoice_date_start').val(),
                    d.invoice_date_end = $('#invoice_date_end').val(),
                    d.expiry_date_start = $('#expiry_date_start').val(),
                    d.expiry_date_end = $('#expiry_date_end').val()
                }
            },
            pageLength: 15,
            search: true,
            stateDuration: 15,
            buttons: [
                'copy',
                'csv',
                'excel',
                {
                    extend: 'print',
                    text: 'Print all (not just selected)',
                    exportOptions: {
                        modifier: {
                            selected: null
                        }
                    }
                },
                {
                    extend: 'pdf',
                    text: 'pdf',
                    exportOptions: {
                        modifier: {
                            selected: true
                        }
                    }
                },
            ],
            columnDefs: [{
                    className: "nk-tb-col",
                    defaultContent: "-",
                    targets: "_all"
                },
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                },


            ],
            select: {
                style: 'os',
                selector: 'td:first-child',
                style: 'multi'
            },
            createdRow: (row, data, dataIndex, cells) => {
                
            let statusColor = 'bg-light';

           
           
       

            if(data.invoice_direction == 'outgoing_invoice') {
            if(data.giden_fatura_durumlar && data.giden_fatura_durumlar.length > 0) {
                data.giden_fatura_durumlar.some(item => {
                    if(item.invoice_outgoing_status_id == data.invoice_status_id) {
                        switch(item.status_info) {
                            case 'success':
                                statusColor = 'bg-success-dim';
                                break;
                            case 'warning':
                                statusColor = 'bg-warning-dim';
                                break;
                            case 'danger':
                                statusColor = 'bg-danger-dim';
                                break;
                            case 'info':
                                statusColor = 'bg-info-dim';
                                break;
                            case 'primary':
                                statusColor = '';
                                break;
                            default:
                                statusColor = 'bg-light';
                        }
                        return true;
                    }
                });
            }
        }
        if(data.invoice_direction == 'incoming_invoice') {
            if(data.gelen_fatura_durumlar && data.gelen_fatura_durumlar.length > 0) {
                data.gelen_fatura_durumlar.some(item => {
                    if(item.invoice_incoming_status_id == data.invoice_status_id) {
                        switch(item.status_info) {
                            case 'success':
                                statusColor = 'bg-success-dim';
                                break;
                            case 'warning':
                                statusColor = 'bg-warning-dim';
                                break;
                            case 'danger':
                                statusColor = 'bg-danger-dim';
                                break;
                            case 'info':
                                statusColor = 'bg-info-dim';
                                break;
                            case 'primary':
                                statusColor = '';
                                break;
                            default:
                                statusColor = 'bg-light';
                        }
                        return true;
                    }
                    });
                }
            }

          
            if(data.invoice_type == 'IADE'){
              
                $(row).addClass('bg-danger-dim');
            }else{
            $(row).addClass(statusColor);
            }
 
                $(row).addClass('nk-tb-item');
                $(row).on('click', function() {
                // Burada 'data.id' örneğin veritabanından gelen bir ID olabilir. URL'yi kendi durumuna göre güncelle.
                window.location.href = '../detail/' + data.invoice_id;
                });
            },
            columns: [{
                    data: null,
                    className: 'nk-tb-col',
                    render: function(data) {

                        return `
                        <div class="custom-control custom-control-sm custom-checkbox notext datatable-checkbox-container">
                            <input type="checkbox" class="custom-control-input datatable-checkbox" data-id="${data.invoice_id}" data-fatura-no="${data.invoice_id}" id="faturaRow${data.invoice_id}">
                            <label class="custom-control-label datatable-checkbox-label" for="faturaRow${data.invoice_id}"></label>
                        </div>`
                    }
                },
                {
                    data: null,
                    name: 'invoice_title',
                    className: 'nk-tb-col tb-col-lg',
                    render: function(data) {
    return `
        <td class="nk-tb-col">
            <div class="user-card">
                <div class="user-avatar bg-secondary-dim sq">
                    <span>${ 
                        data.cari_invoice_title ? 
                        data.cari_invoice_title.substring(0, 1) : 
                        (data.cari_name ? data.cari_name.substring(0, 1) : '-')
                    }</span>
                </div>
                <div class="user-info">
                    <a href="../detail/${ data.invoice_id }" style="color:inherit;">
                        <span class="tb-lead">${ data.cari_invoice_title || '-' }<span class="dot dot-warning d-md-none ms-1"></span></span>
                        <span>${ data.cari_email || '' }</span>
                    </a>
                </div>
            </div>
        </td>
    `;
}
                },
                {
                    data: null,
                    name: 'cari_phone',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data) {
                        var text1 = '';
                        var text2 = '';
                        var text3 = '';
                        
                        if (data.sale_type == 'quick' && data.invoice_direction == 'incoming_invoice')
                        {
                            if(data.invoice_type == 'IADE'){
                                text1 = 'Hızlı İade Faturası';
                            }
                            else{
                                text1 = 'Hızlı Alış Faturası';
                            }
                        }
                        
                        else if (data.sale_type == 'quick' && data.invoice_direction == 'outgoing_invoice')
                        {
                            if(data.invoice_type == 'IADE'){
                                text1 = 'Hızlı İade Faturası';
                            }
                            else{
                                text1 = 'Hızlı Satış Faturası';
                            }
                        }

                        if (data.sale_type == 'quick' && data.invoice_direction == 'incoming_invoice' && data.is_return == 1)
                            text2 = '( iade )';

                            console.log(data.is_quick_sale_receipt);
                        
                        
                        return `

                        <td class="nk-tb-col tb-col-lg">
                            <div class="user-info">
                                <span class="tb-lead">${ data.sale_type  == "quick" ? (data.invoice_no != '#PROFORMA' && data.invoice_no != null ? data.invoice_no : '#PROFORMA') : ( data.is_quick_sale_receipt == 1 && data.invoice_direction == 'outgoing_invoice' ? 'Hızlı Satış Fişi' : data.invoice_no) } <span class="dot dot-warning d-md-none ms-1"></span></span>
                                <span> ${text1} ${text2} ${ data.invoice_serial_prefix == null ? '' : data.invoice_serial_prefix  } ${ data.sale_type == "quick" ? " " : (data.cari_obligation == 'e-archive' ? "E-Arşiv" : "E-Fatura") }</span>
                            </div>
                        </td>
                        `;

                        
                    }
                },
                {
                    data: null,
                    name: 'cari_phone',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data) {

                        var currentdate = new Date(data.invoice_date); 

                        var date = currentdate.getDate().toString().padStart(2, '0') + "/" + (currentdate.getMonth()+1).toString().padStart(2, '0') + "/" + currentdate.getFullYear();
                        var time = currentdate.getHours().toString().padStart(2, '0') + ":" + currentdate.getMinutes().toString().padStart(2, '0') + ":" + currentdate.getSeconds().toString().padStart(2, '0');

                        return `

                        <td class="nk-tb-col tb-col-lg">
                                                    <div class="user-info">
                                                        <span class="tb-lead">${ date }</span>
                                                        <span>${ time }</span>
                                                    </div>
                                                </td>
                        `;
                    }
                },

                {
                    data: null,
                    name: 'cari_phone',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data) {
                        var currentdate = new Date(data.expiry_date); 
                        var today = new Date();
                        var date = currentdate.getDate().toString().padStart(2, '0') + "/" + (currentdate.getMonth()+1).toString().padStart(2, '0') + "/" + currentdate.getFullYear();
                        var time = currentdate.getHours().toString().padStart(2, '0') + ":" + currentdate.getMinutes().toString().padStart(2, '0') + ":" + currentdate.getSeconds().toString().padStart(2, '0');
                        
                        let status = '';
                        if(data.payment_method  == null)
                        {
                            status = '';
                        }
                        // Vade tarihi geçmişse
                       else if (currentdate < today && currentdate.getDate() !== today.getDate()) {
                            status = '<span class="dot dot-danger ms-1"></span>  Sona Erdi';
                        }
                        // Vade tarihine 3 gün veya daha az kaldıysa
                        else if ((currentdate - today) / (1000 * 60 * 60 * 24) <= 3) {
                            status = '<span class="dot dot-warning ms-1"></span>  Yaklaşıyor';
                        }
                        // Vade tarihi ilerideyse
                        else {
                            let remainingDays = Math.ceil((currentdate - today) / (1000 * 60 * 60 * 24));
                            status = ` <span class="dot dot-success ms-1"></span>  ${remainingDays} gün kaldı`;
                        }

                        return `
                        <td class="nk-tb-col tb-col-lg">
                            <div class="user-info" style="display: flex ; /* align-items: center; */ justify-content: center; flex-direction: column;">
                                <span class="tb-lead">${date} </span>
                                <span>${time}</span>
                                <span>${status}</span>
                            </div>
                        </td>
                        `;
                    }
                },

                {
                    data: null,
                    name: 'cari_phone',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data) {
                        var invoice_scenario = data.invoice_scenario;
                        var invoice_scenario_text = '';

                        if (invoice_scenario == "TEMELFATURA") {
                            invoice_scenario_text = "Temel Fatura";
                        } else if (invoice_scenario == "TICARIFATURA") {
                            invoice_scenario_text = "Ticari Fatura";
                        } else if (invoice_scenario == "EARSIVFATURA") {
                            invoice_scenario_text = "E-Arşiv Fatura";
                        } else if (invoice_scenario == "KAMU") {
                            invoice_scenario_text = "Kamu";
                        } else if (invoice_scenario == "IHRACAT") {
                            invoice_scenario_text = "İhracat";
                        }

                        console.log("data.invoice_scenario",invoice_scenario);
                        console.log("invoice_scenario_text",invoice_scenario_text);

                        invoice_typelist = [
                            {
                                "invoice_type": "incoming_invoice",
                                "invoice_scenario_text": "ALIŞ"
                            },
                            {
                                "invoice_type": "SATIS",
                                "invoice_scenario_text": "SATIŞ"
                            },
                            {
                                "invoice_type": "IADE", 
                                "invoice_scenario_text": "İADE"
                            },
                            {
                                "invoice_type": "TEVKIFAT",
                                "invoice_scenario_text": "TEVKİFAT"
                            },
                            {
                                "invoice_type": "ISTISNA",
                                "invoice_scenario_text": "İSTİSNA"
                            },
                            {
                                "invoice_type": "IADEISTISNA",
                                "invoice_scenario_text": "İADE İSTİSNA"
                            },
                            {
                                "invoice_type": "OZELMATRAH",
                                "invoice_scenario_text": "ÖZEL MATRAH"
                            },
                            {
                                "invoice_type": "IHRACKAYITLI",
                                "invoice_scenario_text": "İHRACAT KAYITLI"
                            }
                        ];

                        // Fatura tipine göre text'i bul
                        let invoice_type_text = invoice_typelist.find(item => item.invoice_type === data.invoice_type)?.invoice_scenario_text || "Belirsiz";

                        return `
                        <td class="nk-tb-col tb-col-lg">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead"> ${invoice_type_text} </span>
                                                            <span> ${ invoice_scenario_text } </span>
                                                        </div>
                                                    </div>
                                                </td>
                        `;
                    }
                },
                {
    data: null,
    name: 'cari_phone',
    className: 'nk-tb-col tb-col-md',

    render: function(data) {
        let odeme_durumu = null;
        if(data.is_quick_collection_financial_movement_id > 0) {
            odeme_durumu = `<span class="tb-lead"><span class="dot dot-success ms-1"></span> Ödendi</span>`;
        } else {
            odeme_durumu = `<span class="tb-lead"><span class="dot dot-danger ms-1"></span> Ödenmedi</span>`;
        }


        let durum = `<span class="tb-lead"><span class="dot dot-primary ms-1"></span> Sistemde</span>`;
      
      
        let giden_fatura_durumlar = data.giden_fatura_durumlar;
        let gelen_fatura_durumlar = data.gelen_fatura_durumlar;
        if(data.invoice_direction == 'outgoing_invoice') {
        if(giden_fatura_durumlar && giden_fatura_durumlar.length > 0) {
            giden_fatura_durumlar.some(item => {
                if(item.invoice_outgoing_status_id == data.invoice_status_id) {
                    durum = `<span class="tb-lead"><span class="dot dot-${item.status_info} ms-1"></span> ${item.status_name}</span>`;
                    return true;
                }
            });
        }
        }
        if(data.invoice_direction == 'incoming_invoice') {
        if(gelen_fatura_durumlar && gelen_fatura_durumlar.length > 0) {
            gelen_fatura_durumlar.some(item => {
                if(item.invoice_incoming_status_id == data.invoice_status_id) {
                    durum = `<span class="tb-lead"><span class="dot dot-${item.status_info} ms-1"></span> ${item.status_name}</span>`;
                    return true;
                }
            });
        }
        }

    
    
        return `<div class="d-flex flex-column">
                    ${durum}
                    ${odeme_durumu}
                </div>`;
    }
},
                {
                    data: null,
                    name: 'cari_phone',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data) {
                        return `
                        <td class="nk-tb-col tb-col-lg">
                            <span class="tb-lead">${ data.money_icon +' '+ numberFormat(data.amount_to_be_paid, 2, '.', ',') }</span>
                        </td>
                        `;
                    }
                },
                {
                    data: null,
                    name: 'cari_phone',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data) {
                        var proforma_button = '';
                        <?php if(session()->get('user_item')['user_id'] == 5) { ?>
                       
                        if(data.invoice_no == '#PROFORMA')
                            proforma_button = `<a target="_blank" href="${base_url}/tportal/invoice/proforma/${data.invoice_id}" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-file-text"></em></a>`;
                        else
                            proforma_button = '';
                        <?php } ?>



                        if (data.sale_type == "quick")
                            return `<td class="nk-tb-col nk-tb-col-tools text-end"><a href="${base_url}/tportal/cari/quick_sale_order/detail/${data.invoice_id}" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a></td>`;
                        else
                            return `<td class="nk-tb-col nk-tb-col-tools text-end" >${proforma_button} <a href="${base_url}/tportal/invoice/detail/${data.invoice_id}" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a></td>`;
                    }
                },
            ],
        });



        //fatura arama input
        $('#invoice_input_search').keyup(function() {
            var searchWord = $(this).val().toLocaleUpperCase('tr-TR');

            var table = $('#datatableInvoice').DataTable();
            table.search(searchWord).draw();

            localStorage.setItem('datatableInvoice_filter_search', searchWord);


            if (this.value.length > 0) {
                $('#notification-dot-search').removeClass('d-none');
            } else {
                $('#notification-dot-search').addClass('d-none');
            }

        });

        //fatura arama temizleme
        $('#invoice_input_search_clear_button').on('click', function(e) {
            var table = $('#datatableInvoice').DataTable();

            $('#notification-dot-search').addClass('d-none');
            $('#invoice_input_search').val('');

            localStorage.removeItem('datatableInvoice_filter_search');

            table.state.clear();
            table.ajax.reload();

            table.search('').draw();
            console.log("arama kelimesi temizlendi");
        });

        //fatura filtreleme
        $('#applyFilter').on('click', function(e) {
            var invoice_status = $('#invoice-type-filter-dropdown').find(':selected').val();
            console.log("uygulanacak filtre",invoice_status);

            $('#notification-dot').removeClass('d-none');

            var table = $('#datatableInvoice').DataTable();
            table.column(4).search('').draw();

            localStorage.setItem('datatableInvoice_filter_status', invoice_status);

            console.log("fatura filtre başladı");
            
        });

        //fatura filter clear
        $('#clearFilter').on('click', function(e) {

            $('#invoice-type-filter-dropdown').val(0);
            $('#invoice-type-filter-dropdown').trigger('change');

            $('#notification-dot').addClass('d-none');

            $("#invoice_date_start").val('');
            $("#invoice_date_end").val('');
            $("#expiry_date_start").val('');
            $("#expiry_date_end").val('');  

            var table = $('#datatableInvoice').DataTable();

            localStorage.removeItem('datatableInvoice_filter_status');

            table.state.clear();
            table.ajax.reload();

            console.log("fatura filtre temizlendi");
        });

        $("#applyExport").on("click", function() {
            var sltd_value = $('#sltc_export').find(':selected').val();
            var table = $('#datatableInvoice').DataTable();

            if (sltd_value == "toExcel") {
                table.button('.buttons-excel').trigger();
                console.log("excel için hazırlanıyorr");
            } else if (sltd_value == "toPdf") {
                table.button('.buttons-pdf').trigger();
                console.log("pdf için hazırlanıyorr");
            } else if (sltd_value == "toPrint") {
                table.button('.buttons-print').trigger();
                console.log("yazdırmak için hazırlanıyorr");
            } else {
                console.log("işlem yok");
            }
        });

        var table = $('#datatableInvoice').DataTable();

        $(document).ajaxComplete(function () {
            console.log("fatura yüklendi, ajax bitti");
        });
        $('#row-10').on('click', function() {
            table.page.len(10).draw();
        });
        $('#row-25').on('click', function() {
            table.page.len(25).draw();
        });
        $('#row-50').on('click', function() {
            table.page.len(50).draw();
        });
        $('#row-100').on('click', function() {
            table.page.len(100).draw();
        });
        $('#row-200').on('click', function() {
            table.page.len(200).draw();
        });
        $('#row-1000').on('click', function() {
            table.page.len(1000).draw();
        });

        $('#selectAllInvoice').on('click', function() {
            selectAll = false;
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
            var rows = $('#datatableInvoice').DataTable().rows().nodes();
        });

    });
</script>

<?= $this->endSection() ?>