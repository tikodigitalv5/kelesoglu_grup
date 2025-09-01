<?= $this->include('tportal/inc/head') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/light.css">

<body class="nk-body ui-rounder has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->

           
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
             
                <!-- main header @e -->
                <!-- content @s -->

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <!-- Tarih Filtresi -->
                 <?php 
                    $start_date = isset($start_date) ? $start_date : date('Y-m-d', strtotime('-2 days'));
                    $end_date = isset($end_date) ? $end_date : date('Y-m-d');
                 
                 ?>
                <div class="card card-bordered mb-4">
                    <div class="card-inner">
                        <form id="dateFilterForm" class="row gy-3 align-items-end">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Başlangıç Tarihi</label>
                                    <div class="form-control-wrap">
                                        <input type="date" class="form-control" id="startDate" name="start_date" value="<?= $start_date ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Bitiş Tarihi</label>
                                    <div class="form-control-wrap">
                                        <input type="date" class="form-control" id="endDate" name="end_date" value="<?= $end_date ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Filtrele</button>
                                    <button type="button" class="btn btn-outline-secondary" id="resetDates">Sıfırla</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row g-gs">
                    <!-- Özet Kartları -->
                    <div class="col-xxl-6">
                        <div class="row g-gs">
                            <div class="col-md-6">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start mb-2">
                                            <div class="card-title">
                                                <h6 class="title">Toplam Sipariş</h6>
                                            </div>
                                            <div class="card-tools">
                                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Bugünkü toplam sipariş sayısı"></em>
                                            </div>
                                        </div>
                                        <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                            <div class="nk-sale-data">
                                                <span class="amount"><?= $total_orders ?></span>
                                                <span class="sub-title">Adet Sipariş</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start mb-2">
                                            <div class="card-title">
                                                <h6 class="title">Toplam Tutar</h6>
                                            </div>
                                            <div class="card-tools">
                                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Bugünkü toplam sipariş tutarı"></em>
                                            </div>
                                        </div>
                                        <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                            <div class="nk-sale-data">
                                                <span class="amount"><?= number_format($total_amount, 2) ?> ₺</span>
                                                <span class="sub-title">Toplam Tutar</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start mb-2">
                                            <div class="card-title">
                                                <h6 class="title">Bugün En Çok Satılan Ürün</h6>
                                            </div>
                                            <div class="card-tools">
                                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Bugün en çok satılan ürün"></em>
                                            </div>
                                        </div>
                                        <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                            <div class="nk-sale-data w-100">
                                                <div class="amount text-wrap fs-15px mb-2" style="word-break: break-word; line-height: 1.2;"><?= $top_product['name'] ?></div>
                                                <span class="sub-title"><?= $top_product['count'] ?> Adet</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                       
                            
                         
                            <!-- Başarı Oranı -->
                           
                        </div>
                    </div>
                   
                    <div class=" col-xxl-6">
                    <div class="row g-gs">
                    <div class="col-xxl-6">
                        <div class="card card-bordered card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Sipariş Durumu Dağılımı</h6>
                                    </div>
                                </div>
                                <div class="nk-order-ovwg-ck">
                                    <canvas id="orderStatusChart" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start mb-2">
                                            <div class="card-title">
                                                <h6 class="title">Sipariş Başarı Oranı</h6>
                                            </div>
                                        </div>
                                        <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                            <div class="nk-order-ovwg-ck w-100">
                                                <canvas id="successRateChart" height="120"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                    </div>
                    </div>
                    <div class="col-xxl-4 d-none">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start gx-3 mb-3">
                                    <div class="card-title">
                                        <h6 class="title">Son 7 Gün Trend</h6>
                                        <p>Haftalık sipariş trendi</p>
                                    </div>
                                </div>
                                <div class="nk-order-ovwg">
                                    <div class="nk-order-ovwg-ck">
                                        <canvas id="weeklyTrendChart" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sipariş Durumu ve Saatlik Dağılım -->
                    <div class="col-xxl-12">
                <div class="card card-bordered card-full">
                    <div class="card-inner">
                        <div class="card-title-group d-none">
                            <div class="card-title">
                                <h6 class="title mb-10">Pazaryeri Bazlı Sipariş Durumları</h6>
                            </div>
                        </div>
                        <!-- Durum Özetleri -->
                        <div class="row g-2 mb-4">
                            <div class="col-sm-3">
                                <div class="card h-100 bg-light border-0 rounded-4 shadow-sm hover-shadow">
                                    <div class="card-body p-4">
                                        <div class="d-flex flex-column h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h3 class="fs-4 text-dark mb-0" id="sevkEdildiTotal">Sevk Edildi: 0</h3>
                                            </div>
                                           
                                            <div class="mt-auto">
                                                <div class="border-top border-dark border-opacity-10 pt-3">
                                                    <div class="text-dark marketplace-details" id="sevkEdildiDetails" style="font-size: 0.875rem"></div>
                                                    <div class="text-dark total-amount fw-bold mt-2" id="sevkEdildiAmount" style="font-size: 1rem;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="card h-100 bg-light border-0 rounded-4 shadow-sm hover-shadow">
                                    <div class="card-body p-4">
                                        <div class="d-flex flex-column h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h3 class="fs-4 text-dark mb-0" id="kargoTotal">Kargo Bekliyor: 0</h3>
                                            </div>
                                            
                                            <div class="mt-auto">
                                                <div class="border-top border-dark border-opacity-10 pt-3">
                                                    <div class="text-dark marketplace-details" id="kargoDetails" style="font-size: 0.875rem"></div>
                                                    <div class="text-dark total-amount fw-bold mt-2" id="kargoAmount" style="font-size: 1rem;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="card h-100 bg-light border-0 rounded-4 shadow-sm hover-shadow">
                                    <div class="card-body p-4">
                                        <div class="d-flex flex-column h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h3 class="fs-4 text-dark mb-0" id="iptalTotal">İptal: 0</h3>
                                            </div>
                                            
                                            <div class="mt-auto">
                                                <div class="border-top border-dark border-opacity-10 pt-3">
                                                    <div class="text-dark marketplace-details" id="iptalDetails" style="font-size: 0.875rem"></div>
                                                    <div class="text-dark total-amount fw-bold mt-2" id="iptalAmount" style="font-size: 1rem;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="card h-100 bg-light border-0 rounded-4 shadow-sm hover-shadow">
                                    <div class="card-body p-4">
                                        <div class="d-flex flex-column h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h3 class="fs-4 text-dark mb-0" id="sevkEmriTotal">Sevk Emrinde: 0</h3>
                                            </div>
                                           
                                            <div class="mt-auto">
                                                <div class="border-top border-dark border-opacity-10 pt-3">
                                                    <div class="text-dark marketplace-details" id="sevkEmriDetails" style="font-size: 0.875rem"></div>
                                                    <div class="text-dark total-amount fw-bold mt-2" id="sevkEmriAmount" style="font-size: 1rem;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nk-order-ovwg-ck">
                            <canvas id="serviceStatusChart" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>

                    <!-- Saatlik Analiz -->
               
                </div>
            </div>

            <!-- Platform Bazlı Analiz -->
            
        </div>
    </div>
</div>


 
<?= $this->include('tportal/inc/footer') ?>


              
<?= $this->include('tportal/inc/script') ?>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>
<script>
$(document).ready(function() {
    // Flatpickr tarih seçici ayarları
    flatpickr("#startDate", {
        locale: "tr",
        dateFormat: "Y-m-d",
        defaultDate: "<?= $start_date ?>",
        maxDate: "<?= $end_date ?>",
        onChange: function(selectedDates, dateStr, instance) {
            endDatePicker.set('minDate', dateStr);
        }
    });

    const endDatePicker = flatpickr("#endDate", {
        locale: "tr",
        dateFormat: "Y-m-d",
        defaultDate: "<?= $end_date ?>",
        minDate: "<?= $start_date ?>",
        onChange: function(selectedDates, dateStr, instance) {
            startDatePicker.set('maxDate', dateStr);
        }
    });

    // Tarih filtresi işlemleri
    $('#dateFilterForm').on('submit', function(e) {
        e.preventDefault();
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        window.location.href = '<?= route_to('tportal.siparisler.gunlukrapor') ?>?start_date='+startDate+'&end_date='+endDate;
    });

    // Tarihleri sıfırla
    $('#resetDates').on('click', function() {
        const today = new Date();
        const twoDaysAgo = new Date(today);
        twoDaysAgo.setDate(today.getDate() - 2);
        
        const formatDate = (date) => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        $('#startDate')[0]._flatpickr.setDate(formatDate(twoDaysAgo));
        $('#endDate')[0]._flatpickr.setDate(formatDate(today));
        $('#dateFilterForm').submit();
    });

    // Başarı Oranı Grafiği
    const successCount = <?= $success_count ?>;
    const failedCount = <?= $failed_count ?>;
    const totalCount = successCount + failedCount;
    const successRate = totalCount > 0 ? ((successCount / totalCount) * 100).toFixed(2) : 0;

    new Chart(document.getElementById('successRateChart'), {
        type: 'doughnut',
        data: {
            labels: ['Başarılı', 'İptal'],
            datasets: [{
                data: [successCount, failedCount],
                backgroundColor: ['#1ee0ac', '#e85347'],
                borderWidth: 0,
                borderRadius: 5,
                spacing: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { 
                    display: true,
                    position: 'center'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;
                            return `${label}: ${value} (%${percentage})`;
                        }
                    }
                }
            }
        },
        plugins: [{
            id: 'centerText',
            beforeDraw: function(chart) {
                const width = chart.width;
                const height = chart.height;
                const ctx = chart.ctx;
                ctx.restore();
                
                // Başarı oranı yazısı
                const fontSize = (height / 150).toFixed(2);
                ctx.font = fontSize + 'em sans-serif';
                ctx.textBaseline = 'middle';
                ctx.fillStyle = '#364a63';
                
                const text = `%${successRate}`;
                const textX = Math.round((width - ctx.measureText(text).width) / 2);
                const textY = height / 2;
                
                ctx.fillText(text, textX, textY);
                
                // "Başarı Oranı" alt yazısı
                const subText = 'Başarı Oranı';
                const subFontSize = (height / 250).toFixed(2);
                ctx.font = subFontSize + 'em sans-serif';
                const subTextX = Math.round((width - ctx.measureText(subText).width) / 2);
                const subTextY = height / 2 + 20;
                
                ctx.fillText(subText, subTextX, subTextY);
                
                ctx.save();
            }
        }]
    });

    // Sipariş Durumu Pasta Grafiği
    const statusData = <?= json_encode($status_data) ?>;
    const statusLabels = [];
    const statusCounts = [];
    const statusColors = [];

    Object.values(statusData).forEach(data => {
        if (data.count > 0) {
            statusLabels.push(data.name);
            statusCounts.push(data.count);
            statusColors.push(data.color);
        }
    });

    new Chart(document.getElementById('orderStatusChart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusCounts,
                backgroundColor: statusColors,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right'
                }
            },
            cutout: '60%'
        }
    });

    // Haftalık Trend Grafiği
    const weeklyData = <?= json_encode($weekly_data) ?>;
    const weekDays = Object.keys(weeklyData).map(date => {
        const d = new Date(date);
        return d.toLocaleDateString('tr-TR', { weekday: 'short' });
    });
    const weeklyCounts = Object.values(weeklyData).map(data => data.count);
    const weeklyAmounts = Object.values(weeklyData).map(data => data.amount);

    new Chart(document.getElementById('weeklyTrendChart'), {
        type: 'line',
        data: {
            labels: weekDays,
            datasets: [{
                label: 'Sipariş Sayısı',
                data: weeklyCounts,
                borderColor: '#6576ff',
                backgroundColor: 'rgba(101, 118, 255, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
 /*
    // Saatlik Analiz Grafiği
    new Chart(document.getElementById('hourlyAnalysisChart'), {
        type: 'bar',
        data: {
            labels: Array.from({length: 24}, (_, i) => `${i}:00`),
            datasets: [{
                label: 'Sipariş Sayısı',
                data: <?= json_encode($hourly_orders_new) ?>,
                backgroundColor: '#6576ff',
                borderColor: '#6576ff',
                borderWidth: 1,
                yAxisID: 'y'
            }, {
                label: 'Toplam Tutar (TL)',
                data: <?= json_encode($hourly_amounts_new) ?>,
                type: 'line',
                borderColor: '#1ee0ac',
                backgroundColor: 'transparent',
                borderWidth: 2,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Sipariş Sayısı'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false
                    },
                    title: {
                        display: true,
                        text: 'Toplam Tutar (TL)'
                    }
                }
            }
        }
    });  */

    // Pazaryeri Bazlı Sipariş Durumu Grafiği
    const serviceData = <?= json_encode($service_status) ?>;
    const services = Object.keys(serviceData);

    // Toplamları hesapla
    let sevkEdildi = 0;
    let kargoBekliyor = 0;
    let iptal = 0;
    let sevkEmri = 0;
    let sevkEdildiAmount = 0;
    let kargoBekliyorAmount = 0;
    let iptalAmount = 0;
    let sevkEmriAmount = 0;

    services.forEach(service => {
        sevkEdildi += serviceData[service].sevk_edildi || 0;
        kargoBekliyor += serviceData[service].kargo_bekliyor || 0;
        iptal += serviceData[service].failed || 0;
        sevkEmri += serviceData[service].sevk_emri || 0;
        
        sevkEdildiAmount += serviceData[service].sevk_edildi_amount || 0;
        kargoBekliyorAmount += serviceData[service].kargo_bekliyor_amount || 0;
        iptalAmount += serviceData[service].failed_amount || 0;
        sevkEmriAmount += serviceData[service].sevk_emri_amount || 0;
    });

    // Üst kartları güncelle
    document.getElementById('sevkEdildiTotal').textContent = `Sevk Edildi: ${sevkEdildi}`;
    document.getElementById('kargoTotal').textContent = `Kargo Bekliyor: ${kargoBekliyor}`;
    document.getElementById('iptalTotal').textContent = `İptal: ${iptal}`;
    document.getElementById('sevkEmriTotal').textContent = `Sevk Emrinde: ${sevkEmri}`;

    // Tutarları güncelle
    document.getElementById('sevkEdildiAmount').innerHTML = `Toplam Ciro: <strong>${new Intl.NumberFormat('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(sevkEdildiAmount)} ₺</strong>`;
    document.getElementById('kargoAmount').innerHTML = `Toplam Ciro: <strong>${new Intl.NumberFormat('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(kargoBekliyorAmount)} ₺</strong>`;
    document.getElementById('iptalAmount').innerHTML = `Toplam Ciro: <strong>${new Intl.NumberFormat('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(iptalAmount)} ₺</strong>`;
    document.getElementById('sevkEmriAmount').innerHTML = `Toplam Ciro: <strong>${new Intl.NumberFormat('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(sevkEmriAmount)} ₺</strong>`;

    // Her kartın marketplace detaylarını ekle
    services.forEach(service => {
        const serviceName = serviceData[service].name;
        const serviceDetails = {
            sevkEdildi: serviceData[service].sevk_edildi || 0,
            kargoBekliyor: serviceData[service].kargo_bekliyor || 0,
            failed: serviceData[service].failed || 0,
            sevkEmri: serviceData[service].sevk_emri || 0
        };

        const logoMap = {
            'trendyol': '<img src="https://dopigo.s3.amazonaws.com/integration_logos/trendyol.jpeg" class="marketplace-logo me-2" style="width: 30px; height: 30px; vertical-align: text-bottom;">',
            'n11': '<img src="https://dopigo.s3.amazonaws.com/integration_logos/n11-logo-v2.png" class="marketplace-logo me-2" style="width: 30px; height: 30px; vertical-align: text-bottom;">',
            'ciceksepeti': '<img src="https://dopigo.s3.amazonaws.com/integration_logos/ciceksepeti2x.png" class="marketplace-logo me-2" style="width: 30px; height: 30px; vertical-align: text-bottom;">',
            'pazarama': '<img src="https://dopigo.s3.amazonaws.com/integration_logos/pazarama.png" class="marketplace-logo me-2" style="width: 30px; height: 30px; vertical-align: text-bottom;">',
            'hepsiburada': '<img src="https://dopigo.s3.amazonaws.com/integration_logos/hepsiburada.png" class="marketplace-logo me-2" style="width: 30px; height: 30px; vertical-align: text-bottom;">'
        };

        const platformName = serviceName.toLowerCase();
        const logoHtml = logoMap[platformName] || '';

        if (serviceDetails.sevkEdildi > 0) {
            const detailHtml = `<div class="mb-2 d-flex align-items-center">
                ${logoHtml}<span class="fw-medium">${serviceDetails.sevkEdildi} Adet</span>
            </div>`;
            document.getElementById('sevkEdildiDetails').innerHTML += detailHtml;
        }
        if (serviceDetails.kargoBekliyor > 0) {
            const detailHtml = `<div class="mb-2 d-flex align-items-center">
                ${logoHtml}<span class="fw-medium">${serviceDetails.kargoBekliyor} Adet</span>
            </div>`;
            document.getElementById('kargoDetails').innerHTML += detailHtml;
        }
        if (serviceDetails.failed > 0) {
            const detailHtml = `<div class="mb-2 d-flex align-items-center">
                ${logoHtml}<span class="fw-medium">${serviceDetails.failed} Adet</span>
            </div>`;
            document.getElementById('iptalDetails').innerHTML += detailHtml;
        }
        if (serviceDetails.sevkEmri > 0) {
            const detailHtml = `<div class="mb-2 d-flex align-items-center">
                ${logoHtml}<span class="fw-medium">${serviceDetails.sevkEmri} Adet</span>
            </div>`;
            document.getElementById('sevkEmriDetails').innerHTML += detailHtml;
        }
    });

    const validStatusTypes = ['sevk_edildi', 'kargo_bekliyor', 'failed', 'sevk_emri'];
    
    const serviceStatusColors = {
        'sevk_edildi': '#1ee0ac',
        'kargo_bekliyor': '#f4bd0e',
        'failed': '#e85347',
        'sevk_emri': '#798bff'
    };

    const statusNames = {
        'sevk_edildi': 'Sevk Edildi',
        'kargo_bekliyor': 'Kargo Bekliyor',
        'failed': 'İptal',
        'sevk_emri': 'Sevk Emri'
    };

    const serviceDatasets = validStatusTypes.map(status => ({
        label: statusNames[status],
        data: services.map(service => serviceData[service][status] || 0),
        backgroundColor: serviceStatusColors[status],
        borderColor: serviceStatusColors[status],
        borderWidth: 1
    }));

    new Chart(document.getElementById('serviceStatusChart'), {
        type: 'bar',
        data: {
            labels: services.map(service => serviceData[service].name),
            datasets: serviceDatasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true,
                    ticks: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 12
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.dataset.label || '';
                            const value = context.parsed.y || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${label}: ${value} (%${percentage})`;
                        }
                    }
                }
            }
        }
    });
});
</script>

<style>
.bg-gradient-success {
    background: linear-gradient(45deg, #1ee0ac, #28c397) !important;
}
.bg-gradient-warning {
    background: linear-gradient(45deg, #f4bd0e, #e5a00d) !important;
}
.bg-gradient-danger {
    background: linear-gradient(45deg, #e85347, #e42a1d) !important;
}
.bg-gradient-primary {
    background: linear-gradient(45deg, #6576ff, #4b5fff) !important;
}
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.text-white-75 {
    color: rgba(255, 255, 255, 0.75) !important;
}
.rounded-4 {
    border-radius: 1rem !important;
}
.marketplace-logo {
    width: 32px;
    height: 32px;
    object-fit: contain;
    border-radius: 4px;
    background-color: white;
    padding: 4px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.text-white-75 .marketplace-logo {
    margin-right: 8px;
    margin-bottom: 4px;
}
.bg-light {
    background-color: #f8f9fa !important;
}
.marketplace-icons {
    opacity: 0.7;
}
.marketplace-icons img:hover {
    opacity: 1;
    transform: scale(1.1);
    transition: all 0.2s ease;
}
.marketplace-details {
    margin-top: 1rem;
}
.marketplace-details > div:last-child {
    margin-bottom: 0 !important;
}
</style>


</body>

</html>