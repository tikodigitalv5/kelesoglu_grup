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
#datatableInvoice_length, #datatableInvoice_filter{
    display: none;
}
div.dataTables_wrapper div.dataTables_paginate {
    float: right;
}
.sysmond-row-highlight {
    background: #ffe5e5 !important;
    border-left: 4px solid #ff4d4f !important;
    box-shadow: none !important;
    animation: none !important;
    transition: background 0.2s;
}
.sysmond-row-highlight:hover {
    background: #ffd6d6 !important;
}
.butonDuzenle{
    display: flex !important; gap: 10px !important;
}
.resend-loading-row {
    background: #fffbe6 !important;
    transition: background 0.3s;
}
.spinner-border-sm {
    width: 1.2em;
    height: 1.2em;
    border-width: 0.18em;
}
</style>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
        <?php if (!empty($statistics)) : ?>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">İrsaliye İstatistikleri ( <?= date('d.m.Y H:i') ?> )</h5>
            <span class="badge bg-lighter text-black">Son Güncelleme: <?= date('d.m.Y H:i') ?></span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="border rounded p-3 text-center mb-3">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <em class="icon ni ni-files fs-3 me-2 text-primary"></em>
                        </div>
                        <h6>Bugün İrsaliye</h6>
                        <h3 class="text-primary"><?= number_format($statistics['total_invoices'], 0, ',', '.') ?></h3>
                    </div>
                </div>
                <div class="col">
                    <div class="border rounded p-3 text-center mb-3">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <em class="icon ni ni-cart fs-3 me-2 text-danger"></em>
                        </div>
                        <h6>Bugün Sipariş</h6>
                        <h3 class="text-danger"><?= number_format($statistics['total_orders'], 0, ',', '.') ?></h3>
                    </div>
                </div>
                <div class="col">
                    <div class="border rounded p-3 text-center mb-3">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <em class="icon ni ni-box fs-3 me-2 text-info"></em>
                        </div>
                        <h6>Bugün Ürün Çeşidi</h6>
                        <h3 class="text-info"><?= number_format($statistics['total_products'], 0, ',', '.') ?></h3>
                    </div>
                </div>
                <div class="col">
                    <div class="border rounded p-3 text-center mb-3">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <em class="icon ni ni-package fs-3 me-2 text-success"></em>
                        </div>
                        <h6>Bugün Miktar</h6>
                        <h3 class="text-success"><?= number_format($statistics['total_quantity'], 2, ',', '.') ?></h3>
                    </div>
                </div>
                <div class="col">
                    <div class="border rounded p-3 text-center mb-3">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <em class="icon ni ni-coins fs-3 me-2 text-warning"></em>
                        </div>
                        <h6>Bugün Tutar</h6>
                        <h3 class="text-warning"><?= number_format($statistics['total_amount'], 2, ',', '.') ?> ₺</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

            <?php if (!empty($sysmond_zero_irsaliyeler)) : ?>
            <div class="alert-sysmond-blink sysmond-filter-trigger" role="alert" style="cursor:pointer;">
                <div class="d-flex align-items-center">
                    <span class="sysmond-blink-icon">
                        <em class="icon ni ni-alert-circle-fill"></em>
                    </span>
                    <div class="flex-grow-1 ms-3">
                        <div class="sysmond-alert-title">
                            <span class="fw-bold">Uyarı!</span>
                            <span class="sysmond-alert-count"><?= $sysmond_zero_count ?></span>
                            <span>adet irsaliye <b>Sysmond</b> sistemine <b>gönderilemedi!</b></span>
                        </div>
                        <div class="sysmond-alert-desc">
                            Bu irsaliyelerin tekrar gönderilmesi gerekmektedir.<br>
                            <span class="sysmond-alert-filter-info" style="font-size:0.95em;opacity:0.8;">(Sadece bu kayıtları görmek için tıklayın. Filtre açıkken tekrar tıklayarak tüm kayıtları görebilirsiniz.)</span>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .alert-sysmond-blink {
                    background: #dc3545;
                    color: #fff;
                    font-weight: 500;
                    border-radius: 14px;
                    border-left: 8px solid #fff;
                    box-shadow: 0 4px 32px 0 rgba(220,53,69,0.25);
                    padding: 1.5rem 2.2rem;
                    margin-bottom: 2rem;
                    animation: blink 1.2s linear infinite;
                    font-size: 1.1rem;
                    position: relative;
                    transition: background 0.3s;
                }
                .alert-sysmond-blink.active {
                    background: #ff9800 !important;
                    color: #fff !important;
                }
                .sysmond-blink-icon {
                    font-size: 2.6rem;
                    color: #fff;
                    margin-right: 1.5rem;
                    animation: pulse 1.2s infinite;
                    flex-shrink: 0;
                }
                .sysmond-alert-title {
                    font-size: 1.35rem;
                    font-weight: 700;
                    letter-spacing: 0.01em;
                    margin-bottom: 0.2rem;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }
                .sysmond-alert-count {
                    font-size: 1.5rem;
                    font-weight: 900;
                    color: #fff;
                    margin: 0 0.3rem;
                    text-shadow: 0 2px 8px rgba(0,0,0,0.10);
                }
                .sysmond-alert-desc {
                    font-size: 1.08rem;
                    font-weight: 400;
                    margin-top: 0.1rem;
                    opacity: 0.95;
                }
               
                @media (max-width: 600px) {
                    .alert-sysmond-blink {
                        padding: 1rem 0.7rem;
                        font-size: 1rem;
                    }
                    .sysmond-blink-icon {
                        font-size: 2rem;
                        margin-right: 0.7rem;
                    }
                    .sysmond-alert-title {
                        font-size: 1.1rem;
                    }
                    .sysmond-alert-count {
                        font-size: 1.2rem;
                    }
                }
            </style>
            <?php endif; ?>

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

                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">İRSALİYE NUMARASI</span></th>
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">İRSALİYE TARİHİ</span></th>
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">DEPO </span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">TUTAR</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">DURUM</span></th>
                                        <th class="nk-tb-col nk-tb-col-tools text-end" data-orderable="false"></th>
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
        var base_url = window.location.origin;

        var url = window.location.pathname;
        var parts = url.split('/');
        var lastPart = parts[parts.length - 1];

        // sysmond_id=0 filtre kontrolü
        window.showSysmondZeroOnly = false;
        $(document).on('click', '.sysmond-filter-trigger', function() {
            window.showSysmondZeroOnly = !window.showSysmondZeroOnly;
            if(window.showSysmondZeroOnly) {
                $('.alert-sysmond-blink').addClass('active');
            } else {
                $('.alert-sysmond-blink').removeClass('active');
            }
            datatableInvoice.ajax.reload();
        });

        var datatableInvoice = $('#datatableInvoice').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('tportal/irsaliye/getIrsaliyeList/all') ?>',
                type: 'POST',
                data: function(d) {
                    d.irsaliye_date_start = $('#irsaliye_date_start').val();
                    d.irsaliye_date_end = $('#irsaliye_date_end').val();
                    d.status = $('#status').val();
                    d.sysmond_zero_only = window.showSysmondZeroOnly ? 1 : 0;
                }
            },
            createdRow: (row, data, dataIndex, cells) => {
                $(row).addClass('nk-tb-item');
                if (data.sysmond_id == 0) {
                    $(row).addClass('sysmond-row-highlight');
                }
               
            },
            columns: [{
                    data: 'id',
                    className: 'nk-tb-col',
                    render: function(data, type, row) {
                        return '<div class="custom-control custom-control-sm custom-checkbox notext">' +
                            '<input type="checkbox" class="custom-control-input" value="' + data + '" id="invoice_' + data + '">' +
                            '<label class="custom-control-label" for="invoice_' + data + '"></label>' +
                            '</div>';
                    }
                },
                {
                    data: 'irsaliye_no',
                    className: 'nk-tb-col tb-col-lg',
                    render: function(data, type, row) {
                        return '<a style="cursor: pointer; color:#8094ae" href="<?= base_url('tportal/irsaliye/detail/') ?>/' + row.id + '">' + data + '</a>';
                    }
                },
                {
                    data: 'irsaliye_tarihi',
                    className: 'nk-tb-col tb-col-lg',
                    render: function(data, type, row) {
                        return data + ' ' + row.irsaliye_saati;
                    }
                },
                {
                    data: 'depo_adi',
                    className: 'nk-tb-col tb-col-lg',
                },
                {
                    data: 'genel_toplam',
                    className: 'nk-tb-col tb-col-lg',
                    render: function(data, type, row) {
                        return formatMoney(data) + ' TL';
                    }
                },
                {
                    data: 'status',
                    className: 'nk-tb-col tb-col-lg',
                    render: function(data, type, row) {
                        var status_class = '';
                        var status_text = '';
                        
                        switch(data) {
                            case 'draft':
                                status_class = 'warning';
                                status_text = 'İRSALİYE TASLAK';
                                break;
                            case 'active':

                                
                                if(row.sysmond_id == 0){
                                    status_class = 'danger';
                                    status_text = 'İRSALİYE GÖNDERİLEMEDİ';
                                }else{
                                    status_class = 'success';
                                    status_text = 'İRSALİYE KESİLDİ';
                                }
                                break;
                            case 'cancelled':
                                status_class = 'danger';
                                status_text = 'İRSALİYE İPTAL';
                                break;
                            default:
                                status_class = 'info';
                                status_text = data;
                        }
                        
                        return '<span class="tb-lead"><span class="dot dot-' + status_class + ' ms-1"></span> <b>' + status_text + '</b></span>';
                    }
                },
                {
                    data: null,
                    className: 'nk-tb-col tb-col-lg',
                    render: function(data, type, row) {
                        let resendBtn = '';
                        let resendDuzenBtn = '';
                        if (row.sysmond_id == 0) {
                            resendBtn = `<button class="btn btn-sm btn-outline-danger resend-sysmond" data-id="${row.id}" title="Tekrar Gönder"><em class="icon ni ni-send"></em></button>`;
                            //resendDuzenBtn = `<button class="btn btn-sm btn-outline-warning resend-sysmond-duzen" data-id="${row.id}" title="Düzenle"><em class="icon ni ni-edit"></em></button>`;
                        }
                        let detailBtn = `<a href="${base_url}/tportal/irsaliye/detail/${row.id}" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>`;
                        return `<div class='butonDuzenle'>${resendBtn}${resendDuzenBtn}${detailBtn}</div>`;
                    }
                }
            ],
            language: {
                
    "info": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
    "infoEmpty": "Kayıt yok",
    "infoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
    "infoThousands": ".",
    "lengthMenu": "Sayfada _MENU_ kayıt göster",
    "loadingRecords": "Yükleniyor...",
    "processing": "İşleniyor...",
    "search": "Ara:",
    "zeroRecords": "Eşleşen kayıt bulunamadı",
    "paginate": {
        "first": "İlk",
        "last": "Son",
        "next": "Sonraki",
        "previous": "Önceki"
    },
    "aria": {
        "sortAscending": ": artan sütun sıralamasını aktifleştir",
        "sortDescending": ": azalan sütun sıralamasını aktifleştir"
    },
    "select": {
        "rows": {
            "_": "%d kayıt seçildi",
            "1": "1 kayıt seçildi"
        },
        "cells": {
            "1": "1 hücre seçildi",
            "_": "%d hücre seçildi"
        },
        "columns": {
            "1": "1 sütun seçildi",
            "_": "%d sütun seçildi"
        }
    },
    "autoFill": {
        "cancel": "İptal",
        "fillHorizontal": "Hücreleri yatay olarak doldur",
        "fillVertical": "Hücreleri dikey olarak doldur",
        "fill": "Bütün hücreleri <i>%d<\/i> ile doldur",
        "info": "Detayı"
    },
    "buttons": {
        "collection": "Koleksiyon <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
        "colvis": "Sütun görünürlüğü",
        "colvisRestore": "Görünürlüğü eski haline getir",
        "copySuccess": {
            "1": "1 satır panoya kopyalandı",
            "_": "%ds satır panoya kopyalandı"
        },
        "copyTitle": "Panoya kopyala",
        "csv": "CSV",
        "excel": "Excel",
        "pageLength": {
            "-1": "Bütün satırları göster",
            "_": "%d satır göster",
            "1": "1 Satır Göster"
        },
        "pdf": "PDF",
        "print": "Yazdır",
        "copy": "Kopyala",
        "copyKeys": "Tablodaki veriyi kopyalamak için CTRL veya u2318 + C tuşlarına basınız. İptal etmek için bu mesaja tıklayın veya escape tuşuna basın.",
        "createState": "Şuanki Görünümü Kaydet",
        "removeAllStates": "Tüm Görünümleri Sil",
        "removeState": "Aktif Görünümü Sil",
        "renameState": "Aktif Görünümün Adını Değiştir",
        "savedStates": "Kaydedilmiş Görünümler",
        "stateRestore": "Görünüm -&gt; %d",
        "updateState": "Aktif Görünümün Güncelle"
    },
    "searchBuilder": {
        "add": "Koşul Ekle",
        "button": {
            "0": "Arama Oluşturucu",
            "_": "Arama Oluşturucu (%d)"
        },
        "condition": "Koşul",
        "conditions": {
            "date": {
                "after": "Sonra",
                "before": "Önce",
                "between": "Arasında",
                "empty": "Boş",
                "equals": "Eşittir",
                "not": "Değildir",
                "notBetween": "Dışında",
                "notEmpty": "Dolu"
            },
            "number": {
                "between": "Arasında",
                "empty": "Boş",
                "equals": "Eşittir",
                "gt": "Büyüktür",
                "gte": "Büyük eşittir",
                "lt": "Küçüktür",
                "lte": "Küçük eşittir",
                "not": "Değildir",
                "notBetween": "Dışında",
                "notEmpty": "Dolu"
            },
            "string": {
                "contains": "İçerir",
                "empty": "Boş",
                "endsWith": "İle biter",
                "equals": "Eşittir",
                "not": "Değildir",
                "notEmpty": "Dolu",
                "startsWith": "İle başlar",
                "notContains": "İçermeyen",
                "notStartsWith": "Başlamayan",
                "notEndsWith": "Bitmeyen"
            },
            "array": {
                "contains": "İçerir",
                "empty": "Boş",
                "equals": "Eşittir",
                "not": "Değildir",
                "notEmpty": "Dolu",
                "without": "Hariç"
            }
        },
        "data": "Veri",
        "deleteTitle": "Filtreleme kuralını silin",
        "leftTitle": "Kriteri dışarı çıkart",
        "logicAnd": "ve",
        "logicOr": "veya",
        "rightTitle": "Kriteri içeri al",
        "title": {
            "0": "Arama Oluşturucu",
            "_": "Arama Oluşturucu (%d)"
        },
        "value": "Değer",
        "clearAll": "Filtreleri Temizle"
    },
    "searchPanes": {
        "clearMessage": "Hepsini Temizle",
        "collapse": {
            "0": "Arama Bölmesi",
            "_": "Arama Bölmesi (%d)"
        },
        "count": "{total}",
        "countFiltered": "{shown}\/{total}",
        "emptyPanes": "Arama Bölmesi yok",
        "loadMessage": "Arama Bölmeleri yükleniyor ...",
        "title": "Etkin filtreler - %d",
        "showMessage": "Tümünü Göster",
        "collapseMessage": "Tümünü Gizle"
    },
    "thousands": ".",
    "datetime": {
        "amPm": [
            "öö",
            "ös"
        ],
        "hours": "Saat",
        "minutes": "Dakika",
        "next": "Sonraki",
        "previous": "Önceki",
        "seconds": "Saniye",
        "unknown": "Bilinmeyen",
        "weekdays": {
            "6": "Paz",
            "5": "Cmt",
            "4": "Cum",
            "3": "Per",
            "2": "Çar",
            "1": "Sal",
            "0": "Pzt"
        },
        "months": {
            "9": "Ekim",
            "8": "Eylül",
            "7": "Ağustos",
            "6": "Temmuz",
            "5": "Haziran",
            "4": "Mayıs",
            "3": "Nisan",
            "2": "Mart",
            "11": "Aralık",
            "10": "Kasım",
            "1": "Şubat",
            "0": "Ocak"
        }
    },
    "decimal": ",",
    "editor": {
        "close": "Kapat",
        "create": {
            "button": "Yeni",
            "submit": "Kaydet",
            "title": "Yeni kayıt oluştur"
        },
        "edit": {
            "button": "Düzenle",
            "submit": "Güncelle",
            "title": "Kaydı düzenle"
        },
        "error": {
            "system": "Bir sistem hatası oluştu (Ayrıntılı bilgi)"
        },
        "multi": {
            "info": "Seçili kayıtlar bu alanda farklı değerler içeriyor. Seçili kayıtların hepsinde bu alana aynı değeri atamak için buraya tıklayın; aksi halde her kayıt bu alanda kendi değerini koruyacak.",
            "noMulti": "Bu alan bir grup olarak değil ancak tekil olarak düzenlenebilir.",
            "restore": "Değişiklikleri geri al",
            "title": "Çoklu değer"
        },
        "remove": {
            "button": "Sil",
            "confirm": {
                "_": "%d adet kaydı silmek istediğinize emin misiniz?",
                "1": "Bu kaydı silmek istediğinizden emin misiniz?"
            },
            "submit": "Sil",
            "title": "Kayıtları sil"
        }
    },
    "stateRestore": {
        "creationModal": {
            "button": "Kaydet",
            "columns": {
                "search": "Kolon Araması",
                "visible": "Kolon Görünümü"
            },
            "name": "Görünüm İsmi",
            "order": "Sıralama",
            "paging": "Sayfalama",
            "scroller": "Kaydırma (Scrool)",
            "search": "Arama",
            "searchBuilder": "Arama Oluşturucu",
            "select": "Seçimler",
            "title": "Yeni Görünüm Oluştur",
            "toggleLabel": "Kaydedilecek Olanlar"
        },
        "duplicateError": "Bu Görünüm Daha Önce Tanımlanmış",
        "emptyError": "Görünüm Boş Olamaz",
        "emptyStates": "Herhangi Bir Görünüm Yok",
        "removeJoiner": "ve",
        "removeSubmit": "Sil",
        "removeTitle": "Görünüm Sil",
        "renameButton": "Değiştir",
        "renameLabel": "Görünüme Yeni İsim Ver -&gt; %s:",
        "renameTitle": "Görünüm İsmini Değiştir",
        "removeConfirm": "Görünümü silmek istediğinize emin misiniz?",
        "removeError": "Görünüm silinemedi"
    },
    "emptyTable": "Tabloda veri bulunmuyor",
    "searchPlaceholder": "Arayın...",
    "infoPostFix": " "
},
            responsive: {
                details: {
                    type: 'column',
                    target: -1
                }
            },
            columnDefs: [{
                targets: [-1],
                orderable: false,
                searchable: false
            }],
            order: [[1, 'desc']]
        });

        // Tarih filtresi değiştiğinde tabloyu yenile
        $('#irsaliye_date_start, #irsaliye_date_end, #status').change(function() {
            datatableInvoice.ajax.reload();
        });

        // Tümünü seç
        $('#selectAllInvoice').on('change', function() {
            var checked = $(this).prop('checked');
            $('.custom-control-input').prop('checked', checked);
        });

        // Tekrar gönder butonuna tıklama
        $(document).on('click', '.resend-sysmond', function(e) {
    e.stopPropagation();
    let $btn = $(this);
    let id = $btn.data('id');

    Swal.fire({
        title: 'İrsaliye Tekrar Gönderilsin mi?',
        html: `
            <div style="font-size:1.1em;">
                <b>Bu irsaliye Sysmond sistemine gönderilememiştir.</b><br>
                <span style="color:#ff4d4f;">Tekrar göndermek istediğinize emin misiniz?</span><br>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Evet, Gönder!',
        cancelButtonText: 'Vazgeç',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Loading ikonu göster
            $btn.prop('disabled', true);
            let originalHtml = $btn.html();
            $btn.html('<span class="spinner-border spinner-border-sm text-danger" role="status" aria-hidden="true"></span>');

            // Satırı da loading class ile vurgula
            let $row = $btn.closest('tr');
            $row.addClass('resend-loading-row');

            $.ajax({
                url: '<?= route_to('tportal.siparisler.irsaliye.resendSysmond') ?>',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(resp) {
                    if(resp.status === 'success') {
                        Swal.fire('Başarılı!', resp.message, 'success');
                    } else {
                        Swal.fire('Hata!', resp.message, 'error');
                    }
                },
                complete: function() {
                    // Butonu eski haline getir
                    $btn.prop('disabled', false);
                    $btn.html(originalHtml);
                    $row.removeClass('resend-loading-row');
                    // Tabloyu yenile (isteğe bağlı)
                    $('#datatableInvoice').DataTable().ajax.reload(null, false);
                }
            });
        }
    });
});

        // DataTable tanımlandıktan sonra ekle:
        $('#invoice_input_search').on('keyup change', function() {
            datatableInvoice.search(this.value).draw();
        });
    });

    function deleteIrsaliye(id) {
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Bu irsaliyeyi silmek istediğinize emin misiniz?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'İptal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('tportal/irsaliye/delete') ?>/' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if(response.status === 'success') {
                            Swal.fire('Başarılı!', response.message, 'success');
                            $('#datatableInvoice').DataTable().ajax.reload();
                        } else {
                            Swal.fire('Hata!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Hata!', 'Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
                    }
                });
            }
        });
    }

    function formatMoney(amount) {
        return new Intl.NumberFormat('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(amount);
    }
</script>

<?= $this->endSection() ?>