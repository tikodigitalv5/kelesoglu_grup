<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Dopigo Senkronizasyon <?= $this->endSection() ?>
<?= $this->section('title') ?> Dopigo Senkronizasyon <?= $this->endSection() ?>

<?= $this->section('head') ?>
<!-- Chart.js ve diğer gerekli dosyalar -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
  .quick-date-filters {
    margin: 1rem 0;
}

.quick-date-filters .btn-group {
    box-shadow: 0 2px 4px rgba(14,30,37,.12);
    border-radius: 6px;
    overflow: hidden;
}

.quick-date-filters .btn {
    border: none;
    padding: 0.5rem 1rem;
    font-size: 13px;
    font-weight: 500;
    color: #526484;
    background: #fff;
    transition: all 0.3s ease;
}

.quick-date-filters .btn:hover {
    background: #f5f6fa;
    color: #364a63;
}

.quick-date-filters .btn.active {
    background: #6576ff;
    color: #fff;
}

.quick-date-filters .btn:not(:last-child) {
    border-right: 1px solid #e5e9f2;
}

.quick-date-filters .icon {
    font-size: 1.1em;
    position: relative;
    top: -1px;
}

#loading-spinner {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

@media (max-width: 768px) {
    .quick-date-filters .btn-group {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
    }
    
    .quick-date-filters .btn:not(:last-child) {
        border-right: none;
        border-bottom: 1px solid #e5e9f2;
    }
}
.quick-date-filters {
    margin: 1rem 0;
}

.quick-date-filters .btn-group {
    box-shadow: 0 2px 4px rgba(14,30,37,.12);
    border-radius: 6px;
    overflow: hidden;
}

.quick-date-filters .btn {
    border: none;
    padding: 0.5rem 1rem;
    font-size: 13px;
    font-weight: 500;
    color: #526484;
    background: #fff;
    transition: all 0.3s ease;
}

.quick-date-filters .btn:hover {
    background: #f5f6fa;
    color: #364a63;
}

.quick-date-filters .btn.active {
    background: #6576ff;
    color: #fff;
}

.quick-date-filters .btn:not(:last-child) {
    border-right: 1px solid #e5e9f2;
}

.swal2-input-group {
    margin-top: 1rem;
}
.custom-swal-container {
        z-index: 9999;
    }
    .custom-swal-popup {
        padding: 20px;
    }
    .custom-swal-input {
        margin: 0 !important;
    }
    .date-range-container {
        margin: 20px 0;
    }
    .date-input-group input[type="date"] {
        padding: 8px 12px;
        border: 1px solid #e5e9f2;
        border-radius: 4px;
        color: #526484;
        background-color: #fff;
        transition: all 0.3s ease;
    }
    .date-input-group input[type="date"]:focus {
        border-color: #6576ff;
        box-shadow: 0 0 0 2px rgba(101, 118, 255, 0.1);
        outline: none;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <!-- Tarih Filtresi -->
            <div class="card card-bordered mb-3 d-none">
    <div class="card-inner">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5>Tarih Aralığı Seçin</h5>
                <div class="form-group">        
                        <div class="form-control-wrap">        
                            <div class="input-daterange date-picker-range input-group">            
                                <input type="text" class="form-control date-start" id="start_date" />            
                                <div class="input-group-addon">İLE</div>            
                                <input type="text" class="form-control date-end" id="end_date" />       
                             </div>    </div></div>

            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-primary mt-4 pt-1" style="margin-top: 25px;" onclick="filterData()">Filtrele</button>
            </div>
        </div>
    </div>
</div>

            <!-- İstatistik Kartları -->
            <div class="row g-gs">
                <div class="col-md-4">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="title">Toplam Başarılı İşlem</h6>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount text-success h1"><?= array_sum(array_column($daily_istatistik, 'total_successful')) ?></span>
                            </div>
                            <div class="invest-data mt-2">
                                <div class="invest-data-amount g-2">
                                    <div class="invest-data-history">
                                        <div class="title">SON 24 SAAT</div>
                                        <div class="amount"><?= end($daily_istatistik)['total_successful'] ?? 0 ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="title">Toplam Hatalı İşlem</h6>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount text-danger h1"><?= array_sum(array_column($daily_istatistik, 'total_failed')) ?></span>
                            </div>
                            <div class="invest-data mt-2">
                                <div class="invest-data-amount g-2">
                                    <div class="invest-data-history">
                                        <div class="title">Son 24 Saat</div>
                                        <div class="amount"><?= end($daily_istatistik)['total_failed'] ?? 0 ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="title">Başarı Oranı</h6>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount text-info h1">
                                    <?= number_format(
                                        count($success_rate) > 0 ? 
                                        array_sum(array_column($success_rate, 'success_rate')) / count($success_rate) : 
                                        0, 
                                        2
                                    ) ?>%
                                </span>
                            </div>
                            <div class="invest-data mt-2">
                                <div class="invest-data-amount g-2">
                                    <div class="invest-data-history">
                                        <div class="title">Son 24 Saat</div>
                                        <div class="amount"><?= number_format($success_rate[0]['success_rate'], 2) ?? 0 ?>%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                
                <!-- Diğer istatistik kartları aynı şekilde -->
            </div>

            <!-- Grafikler -->
            <div class="row g-gs mt-3">
                <div class="col-md-6">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-3">
                                <div class="card-title">
                                    <h6 class="title">Günlük Sipariş İstatistikleri</h6>
                                </div>
                            </div>
                            <div class="chart-container">
                                <canvas id="dailyStats"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-3">
                                <div class="card-title">
                                    <h6 class="title">Başarı Oranı </h6>
                                </div>
                            </div>
                            <div class="chart-container">
                                <canvas id="successRate"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Senkronizasyon Logları -->
            <div class="card card-bordered mt-3">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-3">
                        <div class="card-title">
                            <h6 class="title">Senkronizasyon Logları</h6>

                           
                        </div>
                        <div class="quick-date-filters">
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-outline-light btn-dim" onclick="filterByDays(3)">
            <em class="icon ni ni-calendar-check mr-1"></em>
            <span>Son 3 Gün</span>
        </button>
        <button type="button" class="btn btn-outline-light btn-dim" onclick="filterByDays(7)">
            <em class="icon ni ni-calendar-check mr-1"></em>
            <span>Son 7 Gün</span>
        </button>
        <button type="button" class="btn btn-outline-light btn-dim" onclick="filterByDays(14)">
            <em class="icon ni ni-calendar-check mr-1"></em>
            <span>Son 14 Gün</span>
        </button>
        <button type="button" class="btn btn-outline-light btn-dim" onclick="filterByDays(30)">
            <em class="icon ni ni-calendar-check mr-1"></em>
            <span>Son 30 Gün</span>
        </button>
        <button type="button" class="btn btn-outline-light btn-dim" onclick="showCustomDatePicker()">
            <em class="icon ni ni-calendar-alt mr-1"></em>
            <span>Özel Tarih</span>
        </button>
    </div>
</div>

                    </div>
                    <table class="datatable-init nowrap table" data-export-title="Export">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Başlangıç</th>
                                <th>Bitiş</th>
                                <th>Çalışma Tarihi</th>
                                <th>Platform</th>
                                <th>Toplam</th>
                                <th>Başarılı</th>
                                <th>Başarısız</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($daily_stats as $log): ?>
                            <tr>
                                <td><?= $log['id'] ?></td>
                                <td><?= $log['start_date'] ?></td>
                                <td><?= $log['end_date'] ?></td>
                                <td><?= $log['date'] ?></td>
                                <td><span class="badge bg-primary"><?= $log['platform'] ?></span></td>
                                <td><?= $log['total_orders'] ?> Sipariş</td>
                                <td><span class="badge bg-success"><?= $log['successful'] ?></span></td>
                                <td><span class="badge bg-danger"><?= $log['failed'] ?></span></td>
                                <td>
                                    <?php
                                    $statusBadge = [
                                        'running' => 'bg-warning',
                                        'completed' => 'bg-success',
                                        'failed' => 'bg-danger'
                                    ];
                                    $statusBadgeText = [
                                        'running' => 'Çalışıyor',
                                        'completed' => 'Tamamlandı',
                                        'failed' => 'Başarısız'
                                    ];
                                    ?>
                                    <span class="badge <?= $statusBadge[$log['status']] ?>">
                                        <?= $statusBadgeText[$log['status']] ?>
                                    </span>
                                </td>
                                <td>
                                    
                                        <a class=" btn btn-icon btn-trigger" onclick="showDetails(<?= $log['id'] ?>)" >
                                            <em class="icon ni ni-more-h"></em>
                                        </a>
                                       
                           
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sık Karşılaşılan Hatalar -->
            <div class="card card-bordered mt-3">
    <div class="card-inner">
        <div class="card-title-group mb-3">
            <div class="card-title d-flex align-items-center">
                <em class="icon ni ni-alert-circle text-danger me-2"></em>
                <h6 class="title mb-0">Son Karşılaşılan Hatalar</h6>
            </div>
        </div>

        <div class="error-list">
            <?php foreach($common_errors as $error): ?>
            <div class="error-item mb-3">
                <div class="d-flex align-items-start">
                    <div class="error-content flex-grow-1">
                        <div class="d-flex align-items-center mb-1">
                            <em class="icon ni ni-cross-circle text-danger me-2"></em>
                            <span class="text-dark">Sipariş No:</span>
                            <div class="error-message ms-1 text-gray">
                            <?= $error['error_message'] ?>
                        </div>
                        </div>
                       
                    </div>
                    <span class="badge bg-danger rounded-pill ms-2">
                        <?= $error['count'] ?> kez
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <style>
            .error-item {
                background-color: #f8f9fa;
                border-radius: 4px;
                padding: 15px;
                border-left: 3px solid #e85347;
            }
            .error-message {
                color: #6e6e6e;
            }
          
            .card-title .icon {
                font-size: 18px;
            }
        </style>
    </div>
</div>
    </div>
</div>
        </div>
    </div>
</div>

<!-- Detay Modal -->
<div class="modal fade" id="detailModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detaylar</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>

<style>
.circle-stats {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 50px;
    padding: 20px;
}

.success-stats, .failed-stats {
    text-align: center;
    padding: 20px;
}

.divider-vertical {
    width: 1px;
    height: 150px;
    background-color: #e5e9f2;
}

.modal-lg {
    max-width: 800px;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>

function showCustomDatePicker() {
    const modalContent = `
        <div class="modal fade" id="dateFilterModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Özel Tarih Aralığı Seçin</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="dateFilterForm">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Başlangıç Tarihi</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control date-picker" id="customStartDate" 
                                                data-date-format="yyyy-mm-dd" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Bitiş Tarihi</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control date-picker" id="customEndDate" 
                                                data-date-format="yyyy-mm-dd" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">İptal</button>
                        <button type="button" class="btn btn-primary" onclick="applyCustomDateFilter()">Filtrele</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Eğer modal zaten varsa kaldır
    $('#dateFilterModal').remove();
    
    // Yeni modalı ekle
    $('body').append(modalContent);

    // Date picker'ları başlat
    $('.date-picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        language: 'tr',
        todayHighlight: true
    });

    // Varsayılan tarihleri ayarla
    const today = new Date();
    $('#customStartDate').datepicker('setDate', today);
    $('#customEndDate').datepicker('setDate', today);

    // Modalı göster
    $('#dateFilterModal').modal('show');
}

function applyCustomDateFilter() {
    const startDate = $('#customStartDate').val();
    const endDate = $('#customEndDate').val();

    console.log('Seçilen tarihler:', { startDate, endDate });

    if (!startDate || !endDate) {
        Swal.fire({
            icon: 'warning',
            title: 'Uyarı',
            text: 'Lütfen her iki tarihi de seçin'
        });
        return;
    }

    // Loading göster
    Swal.fire({
        title: 'Yükleniyor...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // AJAX isteği
    $.ajax({
        url: '<?= base_url('tportal/senkronizasyon/dopigo/filter-data') ?>',
        type: 'POST',
        data: {
            start_date: startDate,
            end_date: endDate
        },
        success: function(response) {
            if (response.success) {
                // Verileri güncelle
                updateStats(response.data);
                updateTable(response.data.records);
                updateCharts(response.data);
                
                // Modalı kapat
                $('#dateFilterModal').modal('hide');
                
                // Aktif butonu güncelle
                $('.quick-date-filters .btn').removeClass('active');
                $('.quick-date-filters .btn:last-child').addClass('active');

                // Yükleniyor modalını kapat
                Swal.close();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: response.message || 'Veriler alınırken bir hata oluştu.'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                text: 'Sunucu ile iletişim kurulamadı.'
            });
        }
    });
}

// CSS ekleyelim
$('<style>').text(`
    .date-picker {
        background: #fff !important;
        border: 1px solid #dbdfea;
        border-radius: 4px;
        padding: 0.5rem 1rem;
    }
    .date-picker:focus {
        border-color: #6576ff;
        box-shadow: 0 0 0 3px rgba(101,118,255,.1);
    }
`).appendTo('head');

// Tarih validasyonu için yardımcı fonksiyon
function validateDates() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const messageDiv = document.getElementById('date-validation-message');
    const confirmButton = Swal.getConfirmButton();

    if (startDate && endDate) {
        if (new Date(startDate) > new Date(endDate)) {
            messageDiv.textContent = 'Başlangıç tarihi bitiş tarihinden büyük olamaz';
            messageDiv.style.display = 'block';
            confirmButton.disabled = true;
        } else {
            messageDiv.style.display = 'none';
            confirmButton.disabled = false;
        }
    }
}

// Özel tarih filtresi için fonksiyon
function filterByCustomDate(startDate, endDate) {
    $.ajax({
        url: '<?= base_url('tportal/senkronizasyon/dopigo/filter-data') ?>',
        type: 'POST',
        data: {
            start_date: startDate,
            end_date: endDate
        },
        beforeSend: function() {
            $('#loading-spinner').css('display', 'flex');
        },
        success: function(response) {
            if (response.success) {
                updateStats(response.data);
                updateTable(response.data.records);
                updateCharts(response.data);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: response.message || 'Veriler alınırken bir hata oluştu.'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                text: 'Sunucu ile iletişim kurulamadı.'
            });
        },
        complete: function() {
            $('#loading-spinner').hide();
        }
    });
}

// Gün bazlı filtreleme fonksiyonu (güncellendi)
function filterByDays(days) {
    // Aktif butonu güncelle
    $('.quick-date-filters .btn').removeClass('active');
    $(event.currentTarget).addClass('active');
    
    // Tarihleri hesapla
    var endDate = new Date();
    var startDate = new Date();
    startDate.setDate(startDate.getDate() - days);
    
    // Tarihleri formatla
    var formattedStartDate = startDate.toISOString().split('T')[0];
    var formattedEndDate = endDate.toISOString().split('T')[0];
    
    // Filtreleme işlemini yap
    filterByCustomDate(formattedStartDate, formattedEndDate);
}
document.addEventListener('DOMContentLoaded', function() {
    // Date Range Picker
    $('#daterange').daterangepicker({
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        ranges: {
           'Bugün': [moment(), moment()],
           'Dün': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Son 7 Gün': [moment().subtract(6, 'days'), moment()],
           'Son 30 Gün': [moment().subtract(29, 'days'), moment()],
           'Bu Ay': [moment().startOf('month'), moment().endOf('month')],
           'Geçen Ay': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        locale: {
            format: 'DD/MM/YYYY',
            applyLabel: 'Uygula',
            cancelLabel: 'İptal',
            customRangeLabel: 'Özel Aralık'
        }
    });

    // Grafikleri çiz
    const dailyStatsCtx = document.getElementById('dailyStats').getContext('2d');
    new Chart(dailyStatsCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_map(function($date) { 
                return date('d/m/Y', strtotime($date)); 
            }, array_column($daily_stats, 'date'))) ?>,
            datasets: [
                {
                    label: 'Başarılı',
                    data: <?= json_encode(array_column($daily_stats, 'successful')) ?>,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Başarısız',
                    data: <?= json_encode(array_column($daily_stats, 'failed')) ?>,
                    backgroundColor: 'rgba(220, 53, 69, 0.2)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const successRateCtx = document.getElementById('successRate').getContext('2d');
    new Chart(successRateCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_map(function($date) { 
                return date('d/m/Y', strtotime($date)); 
            }, array_column($success_rate, 'date'))) ?>,
            datasets: [{
                label: 'Başarı Oranı (%)',
                data: <?= json_encode(array_column($success_rate, 'success_rate')) ?>,
                borderColor: 'rgba(0, 123, 255, 1)',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
});

function showDetails(id) {
    // AJAX isteği ile verileri çekelim
    $.ajax({
        url: '<?= route_to('tportal.api.dopigo.list') ?>/get-details/' + id,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                // Modal içeriğini güncelle
                updateModalContent(response.data);
                // Modalı aç
                $('#detailModal').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: 'Detaylar alınırken bir hata oluştu.'
                });
            }
        }
    });
}

// Modal içeriğini güncelleyen fonksiyon
function updateModalContent(data) {
    console.log(data);
    let modalContent = '';
    
    modalContent = `
        <div class="text-center p-4">
            <div class="circle-stats">
                <div class="success-stats">
                    <em class="icon ni ni-check-circle text-success" style="font-size: 48px;"></em>
                    <h4 class="mt-3">Başarılı İşlemler</h4>
                    <div class="h2 text-success">${data.successful}</div>
                    <p class="text-soft">Toplam Başarılı Sipariş</p>
                </div>
                
                <div class="divider divider-vertical"></div>
                
                <div class="failed-stats">
                    <em class="icon ni ni-alert-circle text-danger" style="font-size: 48px;"></em>
                    <h4 class="mt-3">Başarısız İşlemler</h4>
                    <div class="h2 text-danger">${data.failed}</div>
                    <p class="text-soft">Toplam Başarısız Sipariş</p>
                </div>
            </div>`;

    // Eğer hata yoksa
    if (!data.errors || data.errors.length === 0) {
        modalContent += `
            <div class="mt-4">
                <div class="alert alert-success">
                    <em class="icon ni ni-check-circle"></em>
                    <strong>Harika!</strong> Hiç hata ile karşılaşılmadı.
                </div>
            </div>`;
    } else {
        // Hatalar varsa
        modalContent += `
            <div class="mt-4">
                <h6 class="title">Hata Detayları</h6>
                ${data.errors.map(error => `
                    <div class="alert alert-danger">
                        <em class="icon ni ni-alert-circle"></em>
                        <strong>Hata:</strong> ${error.message}
                        
                    </div>
                `).join('')}
            </div>`;
    }

    modalContent += '</div>';

    var modalTitle = `
    <div class="modal-title-custom" style='display:flex; align-items:center; justify-content:space-between; gap:10px;'>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-primary-soft" style="padding: 8px 16px; font-size: 13px; font-weight: 500; border-radius: 6px;">
                <em class="icon ni ni-building mr-1"></em> &nbsp; ${data.platform}
            </span>
            <div class="date-range" style="color: #364a63; font-size: 15px; font-weight: 500;">
                <em class="icon ni ni-calendar mr-1"></em>
                ${data.start_date} - ${data.end_date}
            </div>
        </div>
        <div class="process-time " style="font-size: 13px; color: #8094ae;">
            <em class="icon ni ni-clock"></em>
            <span class="ml-1">İşlem Tarihi: ${data.cron_date}</span>
        </div>
    </div>
`;

// Style ekleyelim
$('<style>')
    .text(`
        .modal-title-custom {
            padding: 5px 0;
        }
        .modal-title-custom .badge {
            background-color: rgba(85, 51, 255, 0.1) !important;
            color: #5533ff !important;
            transition: all 0.3s ease;
        }
        .modal-title-custom .badge:hover {
            background-color: rgba(85, 51, 255, 0.15) !important;
        }
        .modal-title-custom .date-range {
            position: relative;
            top: 1px;
        }
        .modal-title-custom .process-time {
            opacity: 0.75;
            font-weight: 400;
        }
        .modal-title-custom .icon {
            position: relative;
            top: -1px;
        }
        .gap-3 {
            gap: 1rem;
        }
    `)
    .appendTo('head');
// Modal başlığını güncelle

    // Modal içeriğini güncelle
    $('#detailModal .modal-body').html(modalContent);
    $('#detailModal .modal-title').html(modalTitle);
}


</script>


<script>
function updateStats(data) {
    $('#total-successful').text(data.total_successful);
    $('#total-failed').text(data.total_failed);
    $('#success-rate').text(data.success_rate + '%');
    $('#last24-successful').text(data.last24_successful);
    $('#last24-failed').text(data.last24_failed);
    $('#last24-success-rate').text(data.last24_success_rate + '%');
}
function updateTable(records) {
    var tbody = '';
    records.forEach(function(log) {
        if(log.status == 'completed'){
            status = 'success';
            text = 'Tamamlandı';
        }else if(log.status == 'failed'){
            status = 'danger';
            text = 'Başarısız';
        }else if(log.status == 'running'){
            status = 'warning';
            text = 'Çalışıyor';
        }
        
        tbody += `
            <tr>
                <td>${log.id}</td>
                <td>${log.start_date}</td>
                <td>${log.end_date}</td>
                <td>${log.date}</td>
                <td><span class="badge bg-primary">${log.platform}</span></td>
                <td>${log.total_orders} Sipariş</td>
                <td><span class="badge bg-success">${log.successful}</span></td>
                <td><span class="badge bg-danger">${log.failed}</span></td>
                <td>
                    <span class="badge ${getStatusBadgeClass(log.status)}">
                        ${text}

                    </span>
                </td>
                <td>
                    <div class="dropdown">
                        <a class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                            <em class="icon ni ni-more-h"></em>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <ul class="link-list-opt no-bdr">
                                <li>
                                    <a href="javascript:void(0)" onclick="showDetails(${log.id})">
                                        <em class="icon ni ni-eye"></em><span>Detaylar</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        `;
    });
    $('tbody').html(tbody);
}

// Status badge rengini belirleme yardımcı fonksiyonu
function getStatusBadgeClass(status) {
    const statusClasses = {
        'running': 'bg-warning',
        'completed': 'bg-success',
        'failed': 'bg-danger'
    };
    return statusClasses[status] || 'bg-secondary';
}

// Grafikleri güncelleme fonksiyonu
function updateCharts(data) {
    if (window.dailyStatsChart) {
        window.dailyStatsChart.data.labels = data.daily_stats.map(item => item.date);
        window.dailyStatsChart.data.datasets[0].data = data.daily_stats.map(item => item.successful);
        window.dailyStatsChart.data.datasets[1].data = data.daily_stats.map(item => item.failed);
        window.dailyStatsChart.update();
    }

    if (window.successRateChart) {
        window.successRateChart.data.labels = data.success_rate_trend.map(item => item.date);
        window.successRateChart.data.datasets[0].data = data.success_rate_trend.map(item => item.rate);
        window.successRateChart.update();
    }
}
/*
$(document).ready(function() {
    // Date picker başlatma

    $('.date-picker-range').datepicker({
        format: "yyyy-mm-dd", // MySQL formatında
        language: "tr",
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        orientation: "bottom auto",
    });

    // Varsayılan tarihleri ayarla (son 7 gün)
    var today = new Date();
    var lastWeek = new Date(today.getTime() - (7 * 24 * 60 * 60 * 1000));
    
    $('.date-start').datepicker('setDate', lastWeek);
    $('.date-end').datepicker('setDate', today);
});
// Filtreleme fonksiyonu
function filterData() {
    var startDate = $('.date-start').val();
    var endDate = $('.date-end').val();

    if (!startDate || !endDate) {
        Swal.fire({
            icon: 'warning',
            title: 'Uyarı!',
            text: 'Lütfen tarih aralığı seçin.'
        });
        return;
    }

    // Tarihleri MySQL formatına çevir
   

    // Yükleniyor göstergesini ekle
    const loadingHtml = `
        <div id="loading-spinner" class="d-flex justify-content-center align-items-center" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); z-index: 1000;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Yükleniyor...</span>
            </div>
        </div>
    `;

    // AJAX isteği
    $.ajax({
        url: '<?= route_to('tportal.api.dopigo.filterData') ?>',
        type: 'POST',
        data: {
            start_date: startDate,
            end_date: endDate
        },
        beforeSend: function() {
            // Yükleniyor göstergesini ekle
            $('.card-bordered').css('position', 'relative').append(loadingHtml);
        },
        success: function(response) {
            if (response.success) {
                $('#loading-spinner').remove();
                // İstatistikleri güncelle
                updateStats(response.data);
                // Tabloyu güncelle
                updateTable(response.data.records);
                // Grafikleri güncelle
                updateCharts(response.data);
               
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: 'Veriler alınırken bir hata oluştu.'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                text: 'Sunucu ile iletişim kurulamadı.'
            });
        },
        complete: function() {
            // Yükleniyor göstergesini kaldır
            $('#loading-spinner').remove();
        }
    });
}

// Tarih formatı dönüştürme yardımcı fonksiyonu
function convertToMySQLDate(dateStr) {
    var parts = dateStr.split('-');
    return parts[2] + '-' + parts[1] + '-' + parts[0];
}

// İstatistikleri güncelleme fonksiyonu


// Tabloyu güncelleme fonksiyonu
 */
</script>
<?= $this->endSection() ?>