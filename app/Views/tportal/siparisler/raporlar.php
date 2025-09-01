<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Sipariş Raporları <?= $this->endSection() ?>
<?= $this->section('title') ?> Sipariş Raporları | <?= session()->get('user_item')['firma_adi'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>
<style>
    .table th {
    font-weight: 600;
    background: #f5f6fa;
}

.table td {
    vertical-align: middle;
}

/* Badge stilleri */
.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
}

/* Kullanıcı kartı stilleri */
.user-card {
    display: flex;
    align-items: center;
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    background: #e5e9f2;
}

.user-info {
    line-height: 1.3;
}

.tb-lead {
    font-weight: 500;
}

/* Dropdown menü stilleri */
.dropdown-menu {
    padding: 0.5rem 0;
}

.link-list-opt {
    padding: 0;
    margin: 0;
    list-style: none;
}

.link-list-opt li:not(:last-child) {
    border-bottom: 1px solid #e5e9f2;
}

.link-list-opt a {
    display: flex;
    align-items: center;
    padding: 0.625rem 1.25rem;
    font-size: 0.875rem;
    color: #526484;
    transition: all .3s;
}

.link-list-opt a:hover {
    background: #f5f6fa;
}

.link-list-opt .icon {
    font-size: 1.125rem;
    margin-right: 0.5rem;
}

/* Platform ve kargo logoları için stil */
.platform-logo, .shipping-logo {
    height: 30px;
    width: auto;
    object-fit: contain;
}

</style>
<!-- app/Views/tportal/siparisler/raporlar.php -->

<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Sipariş Raporları</h3>
                        </div>
                    </div>
                </div>

                <!-- Filtreler -->
                <div class="card card-bordered mb-4">
                    <div class="card-inner">
                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Tarih Aralığı</label>
                                    <div class="form-control-wrap">
                                        <div class="input-daterange date-picker-range input-group">
                                            <input type="text" id="startDate"  class="form-control" />
                                            <div class="input-group-addon">İLE</div>
                                            <input type="text" id="endDate" class="form-control" />
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Platform</label>
                                    <select class="form-select" id="platform">
                                        <option value="">Tümü</option>
                                        <option value="Trendyol">Trendyol</option>
                                        <option value="Hepsiburada">Hepsiburada</option>
                                        <option value="N11">N11</option>
                                        <option value="Çiçek Sepeti">Çiçek Sepeti</option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Durum</label>
                                    <select class="form-select" id="status">
                                        <option value="">Tümü</option>
                                      
                                        <option value="new">YENİ SİPARİŞ</option>
                                        <option value="pending">BEKLİYOR</option>
                                        <option value="success">TESLİM EDİLDİ</option>
                                        <option value="sevk_emri">SEVK EMRİ VERİLDİ</option>
                                        <option value="sevk_edildi">SEVK EDİLDİ</option>
                                        <option value="failed">İPTAL</option>
                                        <option value="teknik_hata">TEKNİK HATA</option>
                                        <option value="stokta_yok">STOKTA YOK</option>
                                        <option value="kargolandi">KARGOLANDİ</option>
                                        <option value="kargo_bekliyor">KARGO BEKLİYOR</option>

                                        <option value="yetistirilemedi">YETİŞTİRİLEMEDİ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary" onclick="filterReports()">Filtrele</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- İstatistikler -->
                <div class="row g-gs">
                    <div class="col-md-6 col-lg-6">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="card-title-group align-start mb-2">
                                    <div class="card-title">
                                        <h6 class="title">Toplam Sipariş</h6>
                                    </div>
                                    <div class="card-tools">
                                        <em class="card-hint icon ni ni-shopping-cart"></em>
                                    </div>
                                </div>
                                <div class="card-amount">
                                    <span class="amount" id="totalOrders">0</span>
                                </div>
                                <div class="invest-data">
                                    <div class="invest-data-amount g-2">
                                        <div class="invest-data-history">
                                            <div class="title">Başarılı</div>
                                            <span class="amount text-success" id="successOrders">0</span>
                                        </div>
                                        <div class="invest-data-history">
                                            <div class="title">Başarısız</div>
                                            <span class="amount text-danger" id="failedOrders">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="card-title-group align-start mb-2">
                                    <div class="card-title">
                                        <h6 class="title">Toplam Ciro</h6>
                                    </div>
                                    <div class="card-tools">
                                        <em class="card-hint icon ni ni-sign-try"></em>
                                    </div>
                                </div>
                                <div class="card-amount">
                                    <span class="amount" id="totalRevenue">₺0</span>
                                </div>
                                <div class="invest-data">
                                    <div class="invest-data-amount g-2">
                                        <div class="invest-data-history">
                                            <br>
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Platform Dağılımı -->
                    <div class="col-md-6">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start mb-2">
                                    <div class="card-title">
                                        <h6 class="title">Platform Dağılımı</h6>
                                    </div>
                                </div>
                                <div class="nk-order-ovwg">
                                    <canvas id="platformChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Günlük Sipariş Trendi -->
                    <div class="col-md-6">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start mb-2">
                                    <div class="card-title">
                                        <h6 class="title">Günlük Sipariş</h6>
                                    </div>
                                </div>
                                <div class="nk-order-ovwg">
                                    <canvas id="orderTrendChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sipariş Listesi -->
                <div class="card card-bordered mt-4">
                    <div class="card-inner">
                        <div class="card-title-group align-start mb-3">
                            <div class="card-title">
                                <h6 class="title">Sipariş Listesi</h6>
                            </div>
                            
                        </div>
                        <table class="table" id="orderTable">
                            <thead>
                                <tr>
                                    <th>Sipariş No</th>
                                    <th>Platform</th>
                                    <th>Tarih</th>
                                    <th>Müşteri</th>
                                    <th>Kargo</th>
                                    <th>Tutar</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<!-- Önce jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

<!-- Sonra Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Moment.js ve lokalizasyon -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/tr.min.js"></script>

<!-- DateRangePicker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<script>
let platformChart = null;
let trendChart = null;
let dataTable = null;

$(document).ready(function() {
    // DataTable initialization
    dataTable = $('#orderTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/tr.json'
        },
        
        columns: [
            { 
                title: 'Sipariş No',
                data: 'order_no',
                render: function(data, type, row) {
                    let orderNo = row.order_no;

// Remove the "DPG" prefix if it exists
orderNo = orderNo.replace(/^DPG/, '');
                    return `<div class="d-flex align-items-center">
                  
                        <span class="fw-medium">${orderNo}</span>
                    </div>`;
                }
            },
            { 
                title: 'Platform',
                data: 'platform',
                render: function(data,type,row) {
                   
                       return `<img style="height:40px;margin-right:10px" src="${row.service_logo}" >` ;
                }
            },
            { 
                title: 'Tarih',
                data: 'date',
                render: function(data) {
                    const date = moment(data, 'DD.MM.YYYY HH:mm');
                    return `<div class="d-flex flex-column">
                        <span class="fw-medium">${date.format('DD.MM.YYYY')}</span>
                        <small class="text-muted">${date.format('HH:mm')}</small>
                    </div>`;
                }
            },
            { 
                title: 'Müşteri',
                data: 'customer',
                render: function(data) {
                    const initial = data.charAt(0).toUpperCase();
                    const colors = ['primary', 'success', 'info', 'warning', 'danger'];
                    const colorIndex = data.charCodeAt(0) % colors.length;
                    return `<div class="d-flex align-items-center">
                        <div class="user-avatar bg-${colors[colorIndex]} text-white me-2" style="width: 32px; height: 32px;">
                            ${initial}
                        </div>
                        <div class="user-info">
                            <span class="fw-medium">${data}</span>
                        </div>
                    </div>`;
                }
            },
            { 
                title: 'Kargo',
                data: 'shipping',
                render: function(data) {
                    const kargoImages = {
                        'Yurtiçi': { img: '/images/kargo/yurtici.png', color: 'purple' },
                        'Aras': { img: '/images/kargo/aras.png', color: 'blue' },
                        'MNG': { img: '/images/kargo/mng.png', color: 'orange' },
                        'PTT': { img: '/images/kargo/ptt.png', color: 'yellow' },
                        'Sürat': { img: '/images/kargo/surat.png', color: 'red' },
                        'HepsiJet': { img: '/images/kargo/hepsijet.png', color: 'green' },
                        'UPS': { img: '/images/kargo/ups.png', color: 'brown' }
                    };

                    const kargoInfo = kargoImages[data] || { color: 'secondary' };
                    return kargoInfo.img ? 
                        `<div class="d-flex align-items-center">
                            <img src="${kargoInfo.img}" height="24" alt="${data}" class="me-2">
                            
                        </div>` : 
                        ``;
                }
            },
            { 
                title: 'Tutar',
                data: 'total',
                render: function(data) {
                    return `<div class="d-flex align-items-center justify-content-end">
                        <span class="fw-bold">₺${data}</span>
                    </div>`;
                }
            },
            { 
                title: 'Durum',
                data: 'status',
                render: function(data) {
                    const statusConfig = {
                        'new': { text: 'YENİ SİPARİŞ', class: 'primary', icon: 'ni-bell' },
                        'pending': { text: 'BEKLİYOR', class: 'warning', icon: 'ni-clock' },
                        'success': { text: 'TESLİM EDİLDİ', class: 'success', icon: 'ni-check-circle' },
                        'sevk_emri': { text: 'SEVK EMRİ VERİLDİ', class: 'info', icon: 'ni-send' },
                        'sevk_edildi': { text: 'SEVK EDİLDİ', class: 'success', icon: 'ni-truck' },
                        'failed': { text: 'İPTAL', class: 'danger', icon: 'ni-cross-circle' },
                        'teknik_hata': { text: 'TEKNİK HATA', class: 'danger', icon: 'ni-alert' },
                        'stokta_yok': { text: 'STOKTA YOK', class: 'danger', icon: 'ni-box' },
                        'kargolandi': { text: 'KARGOLANDI', class: 'success', icon: 'ni-truck' },
                        'kargo_bekliyor': { text: 'KARGO BEKLİYOR', class: 'info', icon: 'ni-time' },
                        'yetistirilemedi': { text: 'YETİŞTİRİLEMEDİ', class: 'danger', icon: 'ni-alert' }
                    };
                    
                    const status = statusConfig[data] || { text: data, class: 'secondary', icon: 'ni-info' };
                    return `<div class="d-flex align-items-center">
                        <span class="badge bg-${status.class} d-flex align-items-center">
                            <em class="icon ni ${status.icon} me-1"></em>
                            ${status.text}
                        </span>
                    </div>`;
                }
            },
            { 
                title: 'İşlemler',
                data: 'actions',
                render: function(data, type, row) {
                    return `<div class="dropdown">
                             <a href="../order/detail/${row.order_id}" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                    </div>`;
                }
            }
        ],
        responsive: true,
        processing: true,
        serverSide: false,
        ordering: true,
        order: [[2, 'desc']], // Tarihe göre sırala
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tümü"]],
        dom: '<"row g-2 align-items-center"<"col-12 col-sm-6 col-lg-4"l><"col-12 col-sm-6 col-lg-4"f><"col-12 col-lg-4 text-lg-end"B>><"table-responsive my-3"t><"row align-items-center"<"col-12 col-sm-6"i><"col-12 col-sm-6"p>>',
        buttons: [
            {
                extend: 'excel',
                text: '<em class="icon ni ni-file-download"></em> Excel\'e Aktar',
                className: 'btn btn-outline-primary'
            }
        ]
    });

    // Moment.js'i Türkçe'ye ayarla
    moment.locale('tr');

    // DateRangePicker initialization
    $('#dateRange').daterangepicker({
        startDate: moment().startOf('day'),
        endDate: moment().endOf('day'),
        locale: {
            format: 'DD.MM.YYYY',
            applyLabel: 'Uygula',
            cancelLabel: 'İptal',
            fromLabel: 'Dan',
            toLabel: 'a',
            customRangeLabel: 'Özel Aralık',
            daysOfWeek: ['Pz', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct'],
            monthNames: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
            firstDay: 1
        },
        ranges: {
            'Bugün': [moment().startOf('day'), moment().endOf('day')],
            'Dün': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
            'Son 7 Gün': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
            'Son 30 Gün': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
            'Bu Ay': [moment().startOf('month'), moment().endOf('month')],
            'Geçen Ay': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });

    // Initial load
    console.log('Sayfa yüklendi, loadReports() çağrılıyor...');
    loadReports();
});

function loadReports() {
    console.log('loadReports başladı');
    console.log('Tarih Aralığı:', $('#dateRange').val());
    console.log('Platform:', $('#platform').val());
    console.log('Durum:', $('#status').val());

    // AJAX call to get report data
    $.ajax({
        url: '<?= route_to('tportal.siparisler.getReportData') ?>',
        type: 'POST',
        data: {
            startDate: $('#startDate').val(),
            endDate: $('#endDate').val(),
            platform: $('#platform').val(),
            status: $('#status').val()
        },
        success: function(response) {
            console.log('Başarılı Response:', response);
            updateDashboard(response);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Hatası:', error);
            console.error('Status:', status);
            console.error('Response:', xhr.responseText);
        }
    });
}

function updateDashboard(data) {
    try {
        // Veri kontrolü
        if (!data) {
            console.error('Veri alınamadı');
            return;
        }

        // Update statistics
        $('#totalOrders').text(data.totalOrders || 0);
        $('#successOrders').text(data.successOrders || 0);
        $('#failedOrders').text(data.failedOrders || 0);
        $('#totalRevenue').text('₺' + formatMoney(data.totalRevenue || 0));
        $('#avgBasket').text('₺' + formatMoney(data.avgBasket || 0));

        // Update charts
        if (data.platformData) updatePlatformChart(data.platformData);
        if (data.trendData) updateTrendChart(data.trendData);
        if (data.orders) updateOrderTable(data.orders);

    } catch (error) {
        console.error('Dashboard güncelleme hatası:', error);
    }
}

function formatMoney(amount) {
    return new Intl.NumberFormat('tr-TR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount);
}

function updatePlatformChart(data) {
    const ctx = document.getElementById('platformChart').getContext('2d');
    
    // Eğer chart zaten varsa yok et
    if (platformChart) {
        platformChart.destroy();
    }

    // Veri kontrolü
    if (!data || !data.labels || !data.values) {
        console.error('Platform verisi geçersiz:', data);
        return;
    }

    platformChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: data.labels,
            datasets: [{
                data: data.values,
                backgroundColor: [
                    '#f4bd0e',
                    '#09c2de',
                    '#6576ff',
                    '#e85347',
                    '#816bff'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom'
            }
        }
    });
}

function updateTrendChart(data) {
    const ctx = document.getElementById('orderTrendChart').getContext('2d');
    
    // Eğer chart zaten varsa yok et
    if (trendChart) {
        trendChart.destroy();
    }

    // Veri kontrolü
    if (!data || !data.dates || !data.orders) {
        console.error('Trend verisi geçersiz:', data);
        return;
    }

    trendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.dates,
            datasets: [{
                label: 'Siparişler',
                data: data.orders,
                borderColor: '#6576ff',
                backgroundColor: 'rgba(101, 118, 255, 0.1)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

function exportToExcel() {
    window.location.href = '<?= base_url('tportal/siparisler/exportReport') ?>' + 
                          '?dateRange=' + $('#dateRange').val() +
                          '&platform=' + $('#platform').val() +
                          '&status=' + $('#status').val();
}

function updateOrderTable(orders) {
    if (!orders || !Array.isArray(orders)) {
        console.error('Geçersiz sipariş verisi:', orders);
        return;
    }

    try {
        // Tabloyu temizle ve yeni verileri ekle
        dataTable.clear().rows.add(orders).draw();
    } catch (error) {
        console.error('Tablo güncelleme hatası:', error);
    }
}

function filterReports() {
    loadReports();
}
</script>

<style>
.card-amount .amount {
    font-size: 1.75rem;
    font-weight: 700;
    color: #364a63;
}
.invest-data-amount {
    display: flex;
    justify-content: space-between;
    margin-top: 0.75rem;
}
.invest-data-history .amount {
    font-size: 1.125rem;
    font-weight: 600;
}
.card-hint {
    font-size: 1.5rem;
}
</style>
<?= $this->endSection() ?>

