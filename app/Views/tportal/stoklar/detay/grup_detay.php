<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Gruplama Detayları <?= $this->endSection() ?>
<?= $this->section('title') ?> Gruplama Detayları | <?= $stock_item['stock_code']; ?> - <?= $stock_item['stock_title'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>


<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                
                <div class="nk-block">
                    <div class="row g-gs">
                    <div class="col-lg-12">
<div class="alert alert-pro alert-info">
                                            <div class="d-flex">
        <em class="icon ni ni-info-fill me-2 fs-5"></em>
        <div>
            <h6 class="alert-heading mb-1">Gruplama Sistemi Hakkında</h6>
            <p class="mb-0">
                Gruplama sistemi, aynı ürünün farklı varyantlarını bir arada yönetmenizi sağlar. 
                Ana ürün altında listelenen alt ürünler, aynı digite sahip stok kodlarını içerir. 
                Örneğin: Ana ürün kodu <strong>100008</strong> ise, alt ürünler 
                <strong>1801 100008</strong>, <strong>1802 100008</strong> gibi aynı son 6 haneye sahip kodlardan oluşur.
            </p>
        </div>
        </div>
    </div>
</div>
                        
                        <!-- Sol Taraf - Ana Ürün Detayı -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-inner">
                                    <div class="product-info text-center mb-4">
                                        <div class="product-gallery mb-3">
                                            <a class="gallery-image popup-image" href="<?= base_url($aranan_urun['default_image'] ?? 'assets/images/no-image.png') ?>">
                                            <img src="<?= base_url($aranan_urun['default_image'] ?? 'assets/images/no-image.png') ?>" 
                                                 class="rounded-top img-fluid" alt="">
                                            </a>
                                        </div>
                                        <h4 class="product-title"><?= $aranan_urun['stock_title'] ?></h4>
                                        <div class="product-code text-muted mb-4">
                                            <span>Stok Kodu: <?= $aranan_urun['stock_code'] ?></span>
                                        </div>
                                    </div>
                                    <div class="product-meta">
                                        <ul class="custom-list">
                                            <li>
                                                <span class="fw-bold">Stock ID</span>
                                                <span><b><?= $aranan_urun['stock_id'] ?></b></span>
                                            </li>
                                            <li>
                                                <span class="fw-bold">SYSMOND REF ID</span>
                                                <span><b><?= $aranan_urun['sysmond'] ?></b></span>
                                            </li>
                                            <li>
                                                <span class="fw-bold">Stok Durumu:</span>
                                                <span class="badge bg-success">
                                                    <?= number_format($aranan_urun['stock_total_quantity'], 2) ?> Adet
                                                </span>
                                            </li>
                                            <?php if(isset($dopigoMap[$aranan_urun['stock_id']])): ?>
                                            <li>
                                                <span class="fw-bold">Dopigo ID:</span>
                                                <span class="badge bg-primary">
                                                    <?= $dopigoMap[$aranan_urun['stock_id']]['dopigo_id'] ?>
                                                </span>
                                            </li>
                                            <?php endif; ?>

                                            <li>
                                               
                                               
                                                    <a style="width: 100%;" href="<?= site_url('tportal/stock/detail/' . $aranan_urun['stock_id']) ?>" 
                                                       class="btn btn-light">
                                                        <em class="icon ni ni-arrow-left"></em>
                                                        <span>Ürün Detayına Dön</span>
                                                    </a>
                                               
                                            </li>
                                           
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sağ Taraf - Alt Ürünler Listesi -->
                        <div class="col-lg-8">
    <div class="card">
        <div class="card-inner">
            <div class="card-title-group mb-4">
                <div class="card-title">
                    <h6 class="title">Aynı Digite Sahip Gruplanan Ürünler</h6>

                   
                </div>

                <div class="card-tools">
                <a href="javascript:void(0)" 
   onclick="showGrupEkleModal()" 
   class="btn btn-primary w-100">
    <span>Gruba Yeni Ürün Ekle</span>
    <em class="icon ni ni-plus ms-2"></em>
</a>
                </div>
            </div>

            <div class="form-group">
                <div class="form-control-wrap">
                    <div class="form-icon form-icon-left">
                        <em class="icon ni ni-search"></em>
                    </div>
                    <input type="text" 
                           class="form-control form-control-lg" 
                           id="grupArama" 
                           placeholder="Ürün Kodu veya Adı ile Arama Yapın...">
                </div>
            </div>
            
            <table class="datatable-init_grup table" data-auto-responsive="false" style="padding-bottom:30px">
                <thead>
                    <tr>
                        <th>Ürün</th>
                        <th>S. Kodu</th>
                        <th>Stok </th>
                        <th>Dopigo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($gruplar)): ?>
                        <?php foreach($gruplar as $grup): ?>
                            <?php foreach($grup['alt_urunler'] as $altUrun): ?>
                                <tr class="<?= isset($dopigoMap[$altUrun['stock_id']]) ? 'dopigo-matched' : '' ?>">
    <td>
        <div class="d-flex align-items-center">
            <div class="user-avatar sq bg-lighter me-3">
                <a class="gallery-image popup-image" href="<?= base_url($altUrun['default_image'] ?? 'assets/images/no-image.png') ?>">
                    <img src="<?= base_url($altUrun['default_image'] ?? 'assets/images/no-image.png') ?>" alt="">
                </a>
            </div>
            <div>
                <span class="title fw-bold"><?= $altUrun['stock_title'] ?></span>
                <?php if(isset($dopigoMap[$altUrun['stock_id']])): ?>
                    <div class="sub-text text-danger">
                        <em class="icon ni ni-check-circle-fill"></em> Dopigo Eşleşmesi Var
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </td>
    <td>
        <div class="d-flex align-items-center">
            <span class="badge badge-dim <?= isset($dopigoMap[$altUrun['stock_id']]) ? 'bg-danger' : 'bg-primary' ?>">
                <?= $altUrun['stock_code'] ?>
            </span>
        </div>
    </td>
    <td>
        <span class="badge <?= $altUrun['stock_total_quantity'] > 0 ? 'bg-success' : 'bg-danger' ?>">
            <?= number_format($altUrun['stock_total_quantity'], 2) ?> Adet
        </span>
    </td>
    <td>
        <?php if(isset($dopigoMap[$altUrun['stock_id']])): ?>
            <div class="d-flex align-items-center">
                <span class="badge bg-danger me-1">
                    <em class="icon ni ni-link"></em>
                </span>
           
            </div>
        <?php endif; ?>
    </td>
</tr>

                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>





        <!-- Sağ Taraf - Alt Ürünler Listesi -->
        <div class="col-lg-12">
    <div class="card">
        <div class="card-inner">
            <div class="card-title-group mb-4">
                <div class="card-title">
                    <h6 class="title">
                        <em class="icon ni ni-link me-2"></em>
                        <?= $stock_item['stock_title'] ?> - <?= $stock_item['stock_code'] ?> Dopigo Eşleştirmeleri
                    </h6>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="form-control-wrap">
                    <div class="form-icon form-icon-left">
                        <em class="icon ni ni-search"></em>
                    </div>
                    <input type="text" 
                           class="form-control form-control-lg" 
                           id="grupAramas" 
                           placeholder="Dopigo ID, Kod veya Ürün Adı ile Arama Yapın...">
                </div>
            </div>
            
    <!-- Tablo yapısı -->
<table class="datatable-init_grups table" data-auto-responsive="false">
    <thead>
        <tr class="bg-lighter">
            <th class="text-center" colspan="3">Dopigo Bilgileri</th>
            <th class="text-center" colspan="4">Stok Bilgileri</th>
        </tr>
        <tr>
   
            <th>Dopigo Kodu</th>
            <th>Dopigo Adı</th>
            <th>Görsel</th>
            <th>S.Kodu</th>
            <th>Stok Adı</th>
     
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($dopigoEslesmeleriFull)): ?>
            <?php 
     
            foreach($dopigoEslesmeleriFull as $eleman):

                ?>
                <tr>
                    
                    <td>
                        <span class="badge badge-dim bg-primary">
                            <?= $eleman['dopigo_code'] ?>
                        </span>
                    </td>
                    <td>
                        <span class="text-primary fw-bold">
                            <?= $eleman['dopigo_title'] ?>
                        </span>
                        <div class="sub-text">
                            <?= date('d.m.Y H:i', strtotime($eleman['created_at'])) ?>
                        </div>
                    </td>
                    <td>
    <div class="user-avatar sq bg-lighter">
        <a class="gallery-image popup-image" 
           href="<?= base_url($eleman['default_image']) ?>">
            <img src="<?= base_url($eleman['default_image']) ?>" 
                 alt="">
        </a>
    </div>
</td>
                    <td>
                        <span class="badge badge-dim bg-dark">
                            <?= $eleman['stock_code'] ?>
                        </span>
                    </td>
                    <td>
                        <?= $eleman['stock_title'] ?>
                    </td>
         
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
        </div>
    </div>
</div>

<style>
.user-avatar.sq {
    width: 40px;
    height: 40px;
    border-radius: 4px;
}
.user-avatar.sq img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
}
.table thead tr:first-child th {
    background: #ebeef2;
    font-weight: 500;
}
</style>


<div class="modal fade" id="grupEkleModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gruba Eklenecek Ürünü Seçin</h5>
                <a href="#" class="close" data-bs-dismiss="modal">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <!-- Arama -->
                <div class="form-group mb-3">
                    <div class="form-control-wrap">
                        <div class="form-icon ">
                            <em class="icon ni ni-search"></em>
                        </div>
                        <input type="text" 
                               class="form-control" 
                               id="urunArama" 
                               placeholder="Aramak için en az 3 karakter yazın..."
                               autocomplete="off">
                    </div>
                </div>

                <!-- Loading -->
                <div id="searchLoading" class="d-none text-center p-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Aranıyor...</span>
                    </div>
                </div>

                <!-- Sonuçlar -->
                <div id="searchResults" class="d-none">
                <table class="table table-ulogs" id="bosUrunlerTable">
                        <thead class="table-light">
                            <tr>
                                <th>Görsel</th>
                                <th>Ürün Adı</th>
                                <th>Stok Kodu</th>
                                <th>Stock ID</th>
                                <th>SYSMOND REF</th>
                                <th>Stok Durumu</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Ajax ile doldurulacak -->
                        </tbody>
                    </table>
                </div>

                <!-- Boş durum -->
                <div id="emptyState" class="text-center p-4">
                    <em class="icon ni ni-search" style="font-size: 2rem"></em>
                    <p class="mt-2">Ürün aramak için yukarıdaki kutuyu kullanın</p>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="eslesmeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dopigo Eşleştirmesini Değiştir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <em class="icon ni ni-alert-circle"></em>
                    Bu işlem mevcut eşleştirmeyi değiştirecektir. Devam etmek istiyor musunuz?
                </div>
                
                <div class="p-3 bg-lighter rounded mb-3">
                    <h6>Mevcut Eşleştirme:</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <small class="text-muted">Stock ID:</small>
                            <div id="oldStockId"></div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Stok Kodu:</small>
                            <div id="oldStockCode"></div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Ürün Adı:</small>
                            <div id="oldStockTitle"></div>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-light rounded">
                    <h6>Yeni Eşleştirme:</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <small class="text-muted">Stock ID:</small>
                            <div id="newStockId"></div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Stok Kodu:</small>
                            <div id="newStockCode"></div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Ürün Adı:</small>
                            <div id="newStockTitle"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-danger" onclick="eslesmeGuncelle()">
                    <em class="icon ni ni-check"></em>
                    <span>Eşleştirmeyi Değiştir</span>
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="dopigoTransferModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dopigo Eşleştirme Transferi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <em class="icon ni ni-info"></em>
                    <span>Bu ürünün Dopigo eşleştirmesi ana ürüne transfer edilecek.</span>
                </div>

                <div class="transfer-container d-flex align-items-center justify-content-between">
                    <!-- Eski Veri -->
                    <div class="transfer-box">
                        <h6 class="text-muted mb-3">Mevcut Eşleştirme</h6>
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div id="oldMatchData">
                                    <!-- JS ile doldurulacak -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ok İşareti -->
                    <div class="transfer-arrow px-4">
                        <em class="icon ni ni-arrow-right-round fs-2"></em>
                    </div>

                    <!-- Yeni Veri -->
                    <div class="transfer-box">
                        <h6 class="text-muted mb-3">Yeni Eşleştirme</h6>
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div id="newMatchData">
                                    <!-- JS ile doldurulacak -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" id="confirmTransfer">
                    <em class="icon ni ni-check"></em>
                    <span>Onayla ve Ekle</span>
                </button>
            </div>
        </div>
    </div>
</div>



<style>
    .form-icon-left {
    left: 1rem;
}

.form-control-lg {
    padding-left: 3rem !important;
    height: 50px;
    font-size: 15px;
}

.form-icon {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    color: #6e82a5;
    z-index: 1;
}

#grupArama:focus {
    border-color: #6576ff;
    box-shadow: 0 0 0 3px rgba(101, 118, 255, 0.1);
}

#grupArama::placeholder {
    color: #b6c6e3;
}
    .dopigo-matched {
    background-color: rgba(231, 76, 60, 0.1) !important; /* Kırmızı tonunda arkaplan */
    transition: all 0.3s ease;
}

.dopigo-matched:hover {
    background-color: rgba(231, 76, 60, 0.15) !important;
}

.dopigo-matched td {
    position: relative;
}

/* Dopigo badge stil */
.dopigo-matched .badge.bg-danger {
    font-weight: 600;
    padding: 0.5rem 0.75rem;
    font-size: 0.9em;
}

.dopigo-matched .icon {
    font-size: 1.1em;
}
.dataTables_length, .dataTables_filter {
    display: none;
}
.user-avatar.sq {
    width: 40px;
    height: 40px;
    border-radius: 4px;
}
.user-avatar.sq img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
}

.custom-list {
    list-style: none;
    padding: 0;
}
.custom-list li {
    padding: 10px;
    border-bottom: 1px solid #e5e9f2;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.custom-list li:last-child {
    border-bottom: none;
}
</style>


</div>
                </div>
            </div>
        </div>
     </div>
 </div>

<?= $this->section('script') ?>

<script>


$(document).ready(function() {




var dataTables = $('.datatable-init_grups').DataTable({
    pageLength: 7,
    responsive: true,
    language: {
        "decimal":        ",",
        "emptyTable":     "Tabloda veri bulunmuyor",
        "info":          "_TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
        "infoEmpty":      "0 kayıttan 0 - 0 arası gösteriliyor",
        "infoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
        "infoPostFix":    "",
        "thousands":      ".",
        "lengthMenu":     "_MENU_ kayıt göster",
        "loadingRecords": "Yükleniyor...",
        "processing":     "İşleniyor...",
        "search":         "Ara:",
        "zeroRecords":    "Eşleşen kayıt bulunamadı",
        "paginate": {
            "first":      "İlk",
            "last":       "Son",
            "next":       "Sonraki",
            "previous":   "Önceki"
        }
    },
    createdRow: function(row, data, dataIndex) {
        // Dopigo eşleşmesi olan satırları işaretle
        if ($(row).hasClass('dopigo-matched')) {
            $(row).find('td').css('color', '#e74c3c'); // Yazı rengini kırmızı yap
        }
    },
    order: [[2, 'desc']], // Stok durumuna göre azalan sıralama
    columnDefs: [
        { orderable: false, targets: [0, 3] }, // Resim ve Dopigo kolonlarında sıralama olmasın
        { 
            targets: 2,
            type: 'numeric',
            render: function(data, type, row) {
                if (type === 'sort') {
                    // Stok miktarını sayısal değer olarak al
                    var text = $(data).text();
                    var number = parseFloat(text.replace(/[^\d.-]/g, ''));
                    return number || 0; // NaN durumunda 0 döndür
                }
                return data;
            }
        }
    ],
    drawCallback: function(settings) {
        console.log('Tablo yenilendi');
    }
    
});

$('#grupAramas').on('keyup', function() {
    dataTables.search(this.value).draw();
});


$('.dataTables_filter').hide();
});



$(document).ready(function() {




    var dataTable = $('.datatable-init_grup').DataTable({
        pageLength: 7,
        responsive: true,
        language: {
            "decimal":        ",",
            "emptyTable":     "Tabloda veri bulunmuyor",
            "info":          "_TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
            "infoEmpty":      "0 kayıttan 0 - 0 arası gösteriliyor",
            "infoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
            "infoPostFix":    "",
            "thousands":      ".",
            "lengthMenu":     "_MENU_ kayıt göster",
            "loadingRecords": "Yükleniyor...",
            "processing":     "İşleniyor...",
            "search":         "Ara:",
            "zeroRecords":    "Eşleşen kayıt bulunamadı",
            "paginate": {
                "first":      "İlk",
                "last":       "Son",
                "next":       "Sonraki",
                "previous":   "Önceki"
            }
        },
        createdRow: function(row, data, dataIndex) {
            // Dopigo eşleşmesi olan satırları işaretle
            if ($(row).hasClass('dopigo-matched')) {
                $(row).find('td').css('color', '#e74c3c'); // Yazı rengini kırmızı yap
            }
        },
        order: [[2, 'desc']], // Stok durumuna göre azalan sıralama
        columnDefs: [
            { orderable: false, targets: [0, 3] }, // Resim ve Dopigo kolonlarında sıralama olmasın
            { 
                targets: 2,
                type: 'numeric',
                render: function(data, type, row) {
                    if (type === 'sort') {
                        // Stok miktarını sayısal değer olarak al
                        var text = $(data).text();
                        var number = parseFloat(text.replace(/[^\d.-]/g, ''));
                        return number || 0; // NaN durumunda 0 döndür
                    }
                    return data;
                }
            }
        ],
        drawCallback: function(settings) {
            console.log('Tablo yenilendi');
        }
        
    });

    $('#grupArama').on('keyup', function() {
        dataTable.search(this.value).draw();
    });

   
    $('.dataTables_filter').hide();
});

function formatNumber(number) {
    return number ? parseFloat(number).toFixed(2) : '0.00';
}


let searchTimeout = null;

function showGrupEkleModal() {
    $('#grupEkleModal').modal('show');
    $('#urunArama').val('').focus();
    showEmptyState();
}

function showLoading() {
    $('#searchLoading').removeClass('d-none');
    $('#searchResults').addClass('d-none');
    $('#emptyState').addClass('d-none');
}

function showResults() {
    $('#searchLoading').addClass('d-none');
    $('#searchResults').removeClass('d-none');
    $('#emptyState').addClass('d-none');
}

function showEmptyState() {
    $('#searchLoading').addClass('d-none');
    $('#searchResults').addClass('d-none');
    $('#emptyState').removeClass('d-none');
}

function searchProducts(term) {
    if(term.length < 3) {
        showEmptyState();
        return;
    }

    showLoading();

    $.ajax({
        url: '<?= site_url('tportal/stock/get_available_products') ?>',
        type: 'POST',
        data: {
            term: term,
            grup_id: '<?= $aranan_urun['stock_id'] ?>'
        },
        success: function(response) {
            var table = $('#bosUrunlerTable').DataTable();
            table.clear();
            
            if(response.products.length > 0) {
                let base_url = '<?= base_url() ?>';
                response.products.forEach(function(urun) {
                    table.row.add([
                    `<div class="user-avatar sq bg-lighter">
                        <img src="${base_url + urun.default_image || base_url + 'assets/images/no-image.png'}" alt="">
                    </div>`,
                    urun.stock_title,
                    `<span class="badge badge-dim bg-primary">${urun.stock_code}</span>`,
                    urun.stock_id,
                    urun.sysmond,
                    `<span class="badge ${urun.stock_total_quantity > 0 ? 'bg-success' : 'bg-danger'}">
                        ${formatNumber(urun.stock_total_quantity)} Adet
                    </span>`,
                    `<button class="btn btn-sm btn-primary" onclick="urunuGrubaEkle(${urun.stock_id})">
                        <em class="icon ni ni-plus"></em> Ekle
                    </button>`
                ]).draw(false);
                });
                showResults();
            } else {
                $('#emptyState').html(' <em class="icon ni ni-info-fill" style="font-size: 2rem"></em><p class="mt-2">"'+term+'" ile eşleşen sonuç bulunamadı</p>');
                showEmptyState();
            }
        }
    });
}

$(document).ready(function() {
    $('#urunArama').on('input', function() {
        clearTimeout(searchTimeout);
        
        searchTimeout = setTimeout(() => {
            searchProducts(this.value.trim());
        }, 500);
    });
});


function urunuGrubaEkle(stock_id) {
    // Önce dopigo eşleştirmesi var mı kontrol et
    $.ajax({
        url: '<?= site_url('tportal/stock/check_dopigo_match') ?>',
        type: 'POST',
        data: { stock_id: stock_id , grup_id: '<?= $stock_item['stock_id'] ?>'},
        success: function(response) {
            if(response.has_match) {
                $("#grupEkleModal").modal('hide');
                showDopigoTransferModal(response.old_data, response.new_data, stock_id);
            } else {
                $("#grupEkleModal").modal('hide');
                normalGrubaEkle(stock_id);
            }
        }
    });
}

// Normal ekleme fonksiyonu
function normalGrubaEkle(stock_id) {
    $.ajax({
        url: '<?= site_url('tportal/stock/add_to_group') ?>',
        type: 'POST',
        data: {
            stock_id: stock_id,
            grup_id: '<?= $aranan_urun['stock_id'] ?>'
        },
        success: function(response) {
            if(response.success) {
                location.reload();
            } else {
                alert('Bir hata oluştu!');
            }
        }
    });
}


let transferStockId = null;

function showDopigoTransferModal(oldData, newData, stock_id) {
    transferStockId = stock_id;
    
    // Eski veriyi göster
    $('#oldMatchData').html(`
        <div class="mb-2"><small class="text-muted">Stock ID:</small> <br>${oldData.stock_id}</div>
        <div class="mb-2"><small class="text-muted">Stok Kodu:</small> <br>${oldData.stock_code}</div>
        <div class="mb-2"><small class="text-muted">Ürün Adı:</small> <br>${oldData.stock_title}</div>
        <div><small class="text-muted">Dopigo ID:</small> <br>${oldData.dopigo_id}</div>
    `);
    
    // Yeni veriyi göster
    $('#newMatchData').html(`
        <div class="mb-2"><small class="text-muted">Stock ID:</small> <br>${newData.stock_id}</div>
        <div class="mb-2"><small class="text-muted">Stok Kodu:</small> <br>${newData.stock_code}</div>
        <div class="mb-2"><small class="text-muted">Ürün Adı:</small> <br>${newData.stock_title}</div>
        <div><small class="text-muted">Dopigo ID:</small> <br>${oldData.dopigo_id}</div>
    `);
    
    $('#dopigoTransferModal').modal('show');
}

// Onay butonuna tıklanınca
$('#confirmTransfer').click(function() {
    $.ajax({
        url: '<?= site_url('tportal/stock/gruba_yeni_eleman_ekle_dopigo_degistir') ?>',
        type: 'POST',
        data: {
            stock_id: transferStockId,
            grup_id: '<?= $aranan_urun['stock_id'] ?>'
        },
        success: function(response) {
            if(response.success) {
                // Modal'ı kapat
                $('#dopigoTransferModal').modal('hide');
                
                // Başarı mesajını göster
                Swal.fire({
                    title: 'Başarılı!',
                    text: 'Eşleştirme başarıyla güncellendi',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Hata!',
                    text: 'Bir hata oluştu',
                    icon: 'error'
                });
            }
        }
    });
});

let currentDopigoId = null;
let newStockData = null;

function showEslesmeModal(dopigoId, oldData, newData) {
    currentDopigoId = dopigoId;
    newStockData = newData;
    
    // Eski verileri göster
    $('#oldStockId').text(oldData.stock_id);
    $('#oldStockCode').text(oldData.stock_code);
    $('#oldStockTitle').text(oldData.stock_title);
    
    // Yeni verileri göster
    $('#newStockId').text(newData.stock_id);
    $('#newStockCode').text(newData.stock_code);
    $('#newStockTitle').text(newData.stock_title);
    
    $('#eslesmeModal').modal('show');
}

function eslesmeGuncelle() {
    $.ajax({
        url: '<?= site_url('tportal/stock/update_dopigo_match') ?>',
        type: 'POST',
        data: {
            dopigo_id: currentDopigoId,
            stock_id: newStockData.stock_id,
            stock_code: newStockData.stock_code,
            stock_title: newStockData.stock_title
        },
        success: function(response) {
            if(response.success) {
                location.reload();
            } else {
                alert('Bir hata oluştu!');
            }
        }
    });
}

</script>
<?= $this->endSection() ?>




<?= $this->endSection() ?>