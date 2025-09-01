<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>
<?= $this->section('title') ?>
<?= $page_title ?> |
<?= session()->get('user_item')['firma_adi'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>




<?= $this->section('main') ?>

<style>
	#DataTables_Table_0_wrapper .with-export{
		    display: flex !important;
    align-items: center;
    padding: 20px;
	}
	
	#dataTables_length label span{
		display:flex!important;
	}
.form-control-select.d-none, span.d-none{
		display:flex!important;
	}

	.loading-overlay {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(255, 255, 255, 0.8);
		display: flex;
		justify-content: center;
		align-items: center;
		z-index: 9999;
	}
	
	/* Footer stilleri */
	tfoot tr {
		font-weight: bold;
	}
	
	tfoot td {
		padding: 10px 8px !important;
		border-top: 2px solid #dee2e6 !important;
	}
	
	/* Stok ve fiyat sütunları sağa yaslı */
	.datatable-init-exports-excel th:nth-child(3),
	.datatable-init-exports-excel td:nth-child(3) {
		text-align: right !important;
	}
	
	.datatable-init-exports-excel th:nth-child(5),
	.datatable-init-exports-excel td:nth-child(5) {
		text-align: right !important;
	}
	</style>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">
                            <?= $page_title ?>
                        </h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon  toggle-expand me-n1" data-target="pageMenu"><em
                                    class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li><a href="#" class="btn btn-white btn-outline-light"><em
                                                class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                    <li class="nk-block-tools-opt">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary"
                                                data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
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
                                    <div class="form-inline">
                                        <h5>Stok Raporu</h5>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                            
                               
                            </div><!-- .card-title-group -->
                   
                        </div>

                        <div class="card-inner p-0">

                            
                        <div class="nk-block">
                                <div class="nk-data data-list">
                                   
                                <div class="filtreler">
                                    <div class="card ">
                                        <div class="card-inner">
                                            <div class="row g-3">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="start_date">Başlangıç Tarihi</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-left">
                                                                <em class="icon ni ni-calendar"></em>
                                                            </div>
                                                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= date('Y-m-01') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                                                                <div class="col-lg-4 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="end_date">Bitiş Tarihi</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-left">
                                                                <em class="icon ni ni-calendar"></em>
                                                            </div>
                                                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= date('Y-m-d') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">&nbsp;</label>
                                                        <div class="form-control-wrap">
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-primary" style="margin-right: 10px;" id="filter_btn">
                                                                    <em class="icon ni ni-search"></em>
                                                                    <span>Filtrele</span>
                                                                </button>
                                                                <button type="button" class="btn btn-outline-secondary" id="reset_btn">
                                                                    <em class="icon ni ni-refresh"></em>
                                                                    <span>Sıfırla</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <table class="datatable-init-exports-excel nowrap table" data-export-title="Dışa Aktar">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2;">#</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">ÜRÜN ADI</th>
                                   
                                                <th style="text-align:right; background-color: #ebeef2;" data-orderable="false">TOPLAM STOK</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">TİPİ</th>
                                                <th style="text-align:right; background-color: #ebeef2;" data-orderable="false">TOPLAM FİYAT</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">...</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                <?php
                                        $sira = 1;
                        
                                        foreach ($summary as $product_title => $data) {
                                    ?>
                                            <tr>
                         
                                                <td><?= $sira ?></td>
                                                <td><?= $product_title ?></td>
                                                <td style="text-align:right;" data-excel-value="<?= $data['total_amount'] ?? 0 ?>"><?= $data['total_amount'] ? number_format($data['total_amount'], 2, ',', '.') : '-' ?></td>
												<td><?php echo $data['buy_unit_title']; ?> </td>
                                                <td style="text-align:right;" data-excel-value="<?= $data['total_price'] ?? 0 ?>">$<?= $data['total_price'] ? number_format($data['total_price'], 2, ',', '.') : '-' ?></td>
                                                <td>
                                                            <a href="<?= route_to("tportal.stocks.movements", $data["stock_id"]) ?>" class="btn btn-icon btn-xs btn-dim btn-outline-dark" id="btnPrintBarcode" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Stok Haraketlerini Görüntüle"><em class="icon ni ni-arrow-right"></em></a>
                            
                

                                            </td>
                                            </tr>
                                    <?php
                                            $sira++;
                                        }
                                    ?>


                                        </tbody>
                                        <tfoot>
                                            <tr style="background-color: #ebeef2;">
                                                <td style="text-align:right; background-color: #ebeef2;"></td>
                                                <td style="text-align:right; background-color: #ebeef2;"></td>
                                                <td style="text-align:right; background-color: #ebeef2;" id="totalPriceCell">-</td>
                                                <td style="background-color: #ebeef2;"></td>
                                                <td style="text-align:right; background-color: #ebeef2;" id="totalAmount">-</td>
                                                <td style="background-color: #ebeef2;"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                   
                                </div><!-- data-list -->
                              
                            </div><!-- .nk-block -->

                       
                        </div>

         


            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    var BASE_URL = "<?= base_url() ?>";
$(document).ready(function() {


    // Dinamik başlık oluşturma fonksiyonu
    function getExportTitle() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        
        if (startDate && endDate) {
            // Tarihleri Türkçe formatına çevir
            var startDateObj = new Date(startDate);
            var endDateObj = new Date(endDate);
            
            var startFormatted = startDateObj.toLocaleDateString('tr-TR');
            var endFormatted = endDateObj.toLocaleDateString('tr-TR');
            
            return 'Stok Raporu (' + startFormatted + ' - ' + endFormatted + ')';
        }
        
        return 'Stok Raporu';
    }

    NioApp.DataTable('.datatable-init-exports-excel', {
      responsive: {
        details: true
      },
      pageLength: -1, // Varsayılan olarak tümünü göster
      createdRow: function(row, data, dataIndex) {
        // Excel export için data-excel-value attribute'larını ekle
        if (data[2] && data[2] !== '-') {
          // Toplam stok sütunu için
          var stockValue = data[2].replace(/\./g, '').replace(',', '.');
          $(row).find('td:eq(2)').attr('data-excel-value', stockValue);
        }
        if (data[4] && data[4] !== '-') {
          // Toplam fiyat sütunu için
          var priceValue = data[4].replace('$', '').replace(/\./g, '').replace(',', '.');
          $(row).find('td:eq(4)').attr('data-excel-value', priceValue);
        }
      },
      buttons: [
        'copy',
        {
          extend: 'excelHtml5',
          title: function() {
            return getExportTitle();
          },
          exportOptions: {
            columns: ':not(:last-child)', // Son sütunu (aksiyonlar) hariç tut
            format: {
              body: function (data, row, column, node) {
                // data-excel-value attribute'u varsa onu kullan
                if (node && node.getAttribute && node.getAttribute('data-excel-value')) {
                  return parseFloat(node.getAttribute('data-excel-value'));
                }
                return data;
              }
            }
          }
        },
        'csv',
        'pdf'
      ],
      lengthMenu: [[ -1], [ "Tümü"]]
    });
    // Sayfa yüklendiğinde otomatik filtreleme yap
    var checkDataTableInterval = setInterval(function() {
        if ($.fn.DataTable.isDataTable('.datatable-init-exports-excel')) {
            clearInterval(checkDataTableInterval);
            
            // Tarih alanlarını ayarla (eğer boşsa)
            if (!$('#start_date').val()) {
                $('#start_date').val('<?= date('Y-m-01') ?>');
            }
            if (!$('#end_date').val()) {
                $('#end_date').val('<?= date('Y-m-d') ?>');
            }
            
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            
            if (startDate && endDate) {
                applyFilters(startDate, endDate);
            }
        }
    }, 100);

    // Filtre fonksiyonları
    $('#filter_btn').on('click', function() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        
        if (!startDate || !endDate) {
            alert('Lütfen başlangıç ve bitiş tarihlerini seçiniz.');
            return;
        }
        
        if (startDate > endDate) {
            alert('Başlangıç tarihi bitiş tarihinden büyük olamaz.');
            return;
        }
        
        // AJAX ile filtreleme yap
        applyFilters(startDate, endDate);
    });
    
    $('#reset_btn').on('click', function() {
        $('#start_date').val('<?= date('Y-m-01') ?>');
        $('#end_date').val('<?= date('Y-m-d') ?>');
        resetFilter();
    });
    
    function applyFilters(startDate, endDate) {
        // Loading göster
        $('.nk-block').append('<div class="loading-overlay"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Yükleniyor...</span></div></div>');
        
        // AJAX ile veri gönder
        $.ajax({
            url: "<?= route_to('tportal.raporlar.stock_report_ajax') ?>",
            type: 'POST',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Tabloyu güncelle
                    updateTable(response.data);
                    // URL'yi güncelle
                    var newUrl = window.location.href.split('?')[0] + '?start_date=' + startDate + '&end_date=' + endDate;
                    window.history.pushState({}, '', newUrl);
                    
                    // DataTable'ın export başlığını güncelle
                    var table = $('.datatable-init-exports-excel').DataTable();
                    if (table) {
                        table.buttons.exportData({
                            modifier: {
                                order: 'current',
                                page: 'all'
                            }
                        });
                    }
                } else {
                    alert('Filtreleme sırasında hata oluştu: ' + response.message);
                }
            },
            error: function() {
                alert('Sunucu ile bağlantı kurulamadı.');
            },
            complete: function() {
                // Loading kaldır
                $('.loading-overlay').remove();
            }
        });
    }
    
    function resetFilter() {
        // Loading göster
        $('.nk-block').append('<div class="loading-overlay"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Yükleniyor...</span></div></div>');
        
        // Tarih alanlarını sıfırla
        $('#start_date').val('<?= date('Y-m-01') ?>');
        $('#end_date').val('<?= date('Y-m-d') ?>');
        
        $.ajax({
            url: "<?= route_to('tportal.raporlar.stock_report_ajax') ?>",
            type: 'POST',
            data: {
                start_date: '<?= date('Y-m-01') ?>',
                end_date: '<?= date('Y-m-d') ?>'
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    updateTable(response.data);
                    // URL'yi temizle
                    var cleanUrl = window.location.href.split('?')[0];
                    window.history.pushState({}, '', cleanUrl);
                    
                    // DataTable'ın export başlığını güncelle
                    var table = $('.datatable-init-exports-excel').DataTable();
                    if (table) {
                        table.buttons.exportData({
                            modifier: {
                                order: 'current',
                                page: 'all'
                            }
                        });
                    }
                }
            },
            error: function() {
                alert('Sunucu ile bağlantı kurulamadı.');
            },
            complete: function() {
                $('.loading-overlay').remove();
            }
        });
    }
    
    function updateTable(data) {
        // DataTable'ı al
        var table = $('.datatable-init-exports-excel').DataTable();
        
        // Mevcut verileri temizle
        table.clear();
        
        var sira = 1;
        $.each(data.summary, function(product_title, item) {
            var totalAmount = item.total_amount || 0;
            var totalPrice = item.total_price || 0;
            var buyUnitTitle = item.buy_unit_title || '-';
            var stockId = item.stock_id || 0;
            
            // DataTable'a yeni satır ekle
            table.row.add([
                sira,
                product_title,
                (totalAmount ? parseFloat(totalAmount).toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '-'),
                buyUnitTitle,
                '$' + (totalPrice ? parseFloat(totalPrice).toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '-'),
                '<a href="' + BASE_URL + '/tportal/stok/hareketler/' + stockId + '" class="btn btn-icon btn-xs btn-dim btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Stok Haraketlerini Görüntüle"><em class="icon ni ni-arrow-right"></em></a>'
            ]);
            sira++;
        });
        
        // DataTable'ı yeniden çiz
        table.draw();
        
        // Toplam değerleri güncelle
        updateTotals(data);
    }
    
    function updateTotals(data) {
        // Toplam stok güncelle
        var totalstockHtml = "";
        var toplamAdet = typeof data.toplam_adet === 'string' ? JSON.parse(data.toplam_adet) : data.toplam_adet;
        
        if (toplamAdet && typeof toplamAdet === 'object') {
            $.each(toplamAdet, function(key, currency) {
                var totalAmount = currency.total_amount || 0;
                var buyUnitTitle = currency.buy_unit_title || '';
                totalstockHtml += "<b>" + parseFloat(totalAmount).toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + "</b>" +" <b style='color: #014ad0;'> " + buyUnitTitle + " </b> <br>";
            });
        } else {
            totalstockHtml = "-";
        }
        $("#totalPriceCell").html(totalstockHtml);
        
        // Toplam fiyat güncelle
        var totalAmountHtml = "";
        var toplamFiyat = typeof data.toplam_fiyat === 'string' ? JSON.parse(data.toplam_fiyat) : data.toplam_fiyat;
        
        if (toplamFiyat && typeof toplamFiyat === 'object') {
            $.each(toplamFiyat, function(key, currency) {
                var totalPrice = currency.total_price || 0;
                var moneyIcon = currency.money_icon || '$';
                totalAmountHtml += "<b style='color: #014ad0;'> " + moneyIcon + " </b> <b >" + parseFloat(totalPrice).toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + "</b><br>";
            });
        } else {
            totalAmountHtml = "-";
        }
        $("#totalAmount").html(totalAmountHtml);
    }

    // Sayfa yüklendiğinde ilk toplamları göster
    var totalstocktype = <?php echo $toplam_adet; ?>;

    // HTML öğesini güncelle
    var totalstockHtml = "";
    if (totalstocktype && typeof totalstocktype === 'object') {
        $.each(totalstocktype, function(key, currency) {
            var totalAmount = currency.total_amount || 0;
            var buyUnitTitle = currency.buy_unit_title || '';
            totalstockHtml += "<b>" + parseFloat(totalAmount).toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + "</b>" +" <b style='color: #014ad0;'> " + buyUnitTitle + " </b> <br>";
        });
    } else {
        totalstockHtml = "-";
    }
    $("#totalPriceCell").html(totalstockHtml);
    
    // PHP'den gelen JSON verisini JavaScript değişkenine aktar
    var totalPricesByCurrency = <?php echo $toplam_fiyat; ?>;

    // HTML öğesini güncelle
    var totalAmountHtml = "";
    if (totalPricesByCurrency && typeof totalPricesByCurrency === 'object') {
        $.each(totalPricesByCurrency, function(key, currency) {
            var totalPrice = currency.total_price || 0;
            var moneyIcon = currency.money_icon || '$';
            totalAmountHtml += "<b style='color: #014ad0;'> " + moneyIcon + " </b> <b >" + parseFloat(totalPrice).toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + "</b><br>";
        });
    } else {
        totalAmountHtml = "-";
    }
    $("#totalAmount").html(totalAmountHtml);
    
    // PHP'den gelen ilk verileri DataTable'a yükle
    var initialData = <?php echo json_encode($summary); ?>;
    if (initialData && typeof initialData === 'object') {
        var table = $('.datatable-init-exports-excel').DataTable();
        if (table) {
            table.clear();
            var sira = 1;
            $.each(initialData, function(product_title, item) {
                var totalAmount = item.total_amount || 0;
                var totalPrice = item.total_price || 0;
                var buyUnitTitle = item.buy_unit_title || '-';
                var stockId = item.stock_id || 0;
                
                table.row.add([
                    sira,
                    product_title,
                    (totalAmount ? parseFloat(totalAmount).toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '-'),
                    buyUnitTitle,
                    '$' + (totalPrice ? parseFloat(totalPrice).toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '-'),
                    '<a href="' + BASE_URL + '/tportal/stok/hareketler/' + stockId + '" class="btn btn-icon btn-xs btn-dim btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Stok Haraketlerini Görüntüle"><em class="icon ni ni-arrow-right"></em></a>'
                ]);
                sira++;
            });
            table.draw();
        }
    }
});
</script>

<?= $this->endSection() ?>