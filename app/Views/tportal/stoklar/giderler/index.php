<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> <?= $page_title ?> <?= $this->endSection() ?>
<?= $this->section('title') ?> <?= $page_title ?> | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<style>
    .nk-iv-wg2 {
    display: flex;
    flex-direction: column;
    height: 100%;
}
.nk-iv-wg2-title {
    margin-bottom: .75rem;
}
.is-dark .nk-iv-wg2-title .title {
    color: #c4cefe;
}

.nk-iv-wg2-title .title {
    font-size: .875rem;
    line-height: 1.25rem;
    font-weight: 500;
    color: #8094ae;
    font-family: Roboto, sans-serif;
}
.nk-iv-wg2-title .title .icon {
    font-size: 13px;
    margin-left: .2rem;
}

.nk-iv-wg2-amount {
    font-size: 2.25rem;
    letter-spacing: -.03em;
    line-height: 1.15em;
    display: flex;
    justify-content: space-between;
    align-items: baseline;
}
.card-bordered {
    border: 1px solid #dbdfea;
}



.nk-wg-card.is-s3:after {
    background-color: #1ee0ac;
}


.nk-wg-card.is-s1:after {
    background-color: #364a63;
}
.nk-wg-card.is-s2:after {
    background-color: #004ad0;
}
.nk-wg-card:after {
    content: "";
    position: absolute;
    height: .25rem;
    background-color: transparent;
    left: 0;
    bottom: 0;
    right: 0;
    border-radius: 0 0 3px 3px;
}
.nk-wg-card.is-s0:after{
    background: #3a2272;
    color: white;
}

</style>


<?= $this->section('main') ?>

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
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
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
                                        <div class="form-wrap w-200px">
                                            <select class="form-select toplu_islem js-select2" data-search="off" id="SiparisAktar" data-placeholder="Toplu İşlem">
                                                <option value="">Toplu İşlem</option>
                                              
                                                <option value="#">İndir (Excel)</option>
                                                <option value="#">İndir (PDF)</option>
                                                <option value="#">Yazdır</option>
                                                <option value="#">Seçilenleri Sil</option>
                                            </select>
                                        </div>
                                        <div class="btn-wrap  ">
                                            <div style="display:flex;">
                                            <span class="d-none d-md-block"><button id="indirButton" class="btn btn-dim btn-outline-light disabled">Uygula</button></span>
                                           

                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                            </div>
                                        </div>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                   
                                        <li>

                                            <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search">
                                                <div class="dot dot-primary d-none" id="notification-dot-search"></div>
                                                <em class="icon ni ni-search"></em>
                                            </a>
                                        </li><!-- li -->
                                        <li class="btn-toolbar-sep"></li><!-- li -->
                                        
                                        <li>
                                        <li>
                                            <div class="toggle-wrap">
                                                <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                <div class="toggle-content" data-content="cardTools">
                                                    <ul class="btn-toolbar gx-1">
                                                        <li class="toggle-close">
                                                            <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon dropdown-toggle" data-bs-toggle="dropdown">
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
                                                                          
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label class="overline-title overline-title-alt">Tedarikçi Seç</label>
                                                                                    <select class="form-select musteriGore js-select2" data-search="off" id="musteriGore" data-placeholder="Tedarikçi Seç">
                                                                        <option value="0" selected>Hepsi</option>
                                                                        <?php if(!empty($cariler)):  foreach($cariler as $cari){ ?>
                                                                        <option value="<?php echo $cari["cari_id"]; ?>" ><?php echo $cari["invoice_title"]; ?></option>
                                                                        <?php } endif; ?>
                                                                                                        
                                                                        
                                                                        </select>

                                                                           
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label class="overline-title overline-title-alt">Gider Durumları</label>
                                                                                    <select class="form-select durumaGore js-select2" data-search="off" id="durumaGore" data-placeholder="Sipariş Durumu">
                                                                        <option value="0" selected>Hepsi</option>

                                                                        <option value="new" >YENİ </option>
                                                                        <option value="pending" > BEKLİYOR</option>
                                                                        <option value="success" > ÖDENDİ</option>
                                                                        <option value="failed" > İPTAL</option>
                                                                                                        
                                                                        
                                                                        </select>

                                                                           
                                                                                </div>
                                                                            </div>
                                                                           

                                                                                <select style="display:none;" class="form-select d-none" data-search="off" id="platformSec" data-placeholder="Platformlar">
                                                <option value="0" selected>Hepsi</option>
                                               
                                               
                                            </select>


                                                                           
                                                                            <div class="col-12">
    <div class="form-group">
        <label class="overline-title overline-title-alt">Başlangıç Tarihi</label>
        <div class="form-control-wrap">
            <div class="form-icon form-icon-right">
                <em class="icon ni icon-lg ni-calendar-alt"></em>
            </div>
            <div class="input-daterange date-picker input-group">
                <input type="text" name="report_date_start" id="report_date_start" class="form-control" value="<?= isset($date1) ? date("d/m/Y", strtotime($date1)) : date('d/m/Y') ?>" />
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="form-group">
        <label class="overline-title overline-title-alt">Bitiş Tarihi</label>
        <div class="form-control-wrap">
            <div class="form-icon form-icon-right">
                <em class="icon ni icon-lg ni-calendar-alt"></em>
            </div>
            <div class="input-daterange date-picker input-group">
                <input type="text" name="report_date_end" id="report_date_end" class="form-control" value="<?= isset($date2) ? date("d/m/Y", strtotime($date2)) : date('d/m/Y') ?>" />
            </div>
        </div>
    </div>
</div>

<div class="dropdown-foot between">
    <button class="btn btn-light" id="clearFilters">Filtreyi Temizle</button>
    <button class="btn btn-primary" id="applyFilters">Filtreyi Uygula</button>
</div>
                                                                </div><!-- .filter-wg -->
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon dropdown-toggle" data-bs-toggle="dropdown">
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
                                        </li><!-- li -->
                                    </ul><!-- .btn-toolbar -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" id="stock_input_search" class="form-control border-transparent form-focus-none" placeholder="Bulmak istediğiniz ürünün adını yada kodunu yazınız..">
                                        <a href="#" class="btn btn-icon toggle-search active" data-target="search" style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em class="icon ni ni-cross"></em></a>
                                        <button class="search-submit btn btn-icon" style="margin-right: 50px;" id="stock_input_search_clear_button" name="stock_input_search_clear_button"><em class="icon ni ni-trash"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div><!-- .card-inner -->



                        <div class="card-inner p-0">
                            <table id="datatableStock" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                <thead>
                                    <tr class="nk-tb-item nk-tb-head tb-tnx-head">
                                        <th class="nk-tb-col nk-tb-col-check">
                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                <input type="checkbox" class="custom-control-input" id="selectAllStock">
                                                <label class="custom-control-label" for="selectAllStock"></label>
                                            </div>
                                        </th>

                                        <!-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">S.Tipi</span></th> -->
                                        <th class="nk-tb-col" wdith="1%"><span class="sub-text">Gider Tarihi</span></th>
                                       
                                        <!-- <th class="nk-tb-col tb-col-mb"><span class="sub-text">Kodu</span></th> -->
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">Gider No</span></th>
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">Tedarikçi</span></th>
                                        <!-- <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">İşlemde</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">Toplam</span></th> -->
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">Tutar</span></th>
                                        <th class="nk-tb-col tb-col-lg" width="20%"data-orderable="false"><span class="sub-text">Durum</span></th>
                                        <th class="nk-tb-col nk-tb-col-tools text-end"  width="6%" data-orderable="false"></th>
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



<!-- Müşteri Seç Modal -->



<?= $this->endSection() ?>

<?= $this->section('script') ?>


<script>



// Modal açıldığında select2 initialize ediliyor
$('#sevkEmirleri').on('shown.bs.modal', function () {
    $(".js-select2").select2({
        dropdownParent: $('#sevkEmirleri') // Dropdown menüsünün modal içinde kalmasını sağlar
    });
});

$(document).ready(function() {


$()



var search_text = localStorage.getItem('datatableStock_filter_search');
var category = localStorage.getItem('datatableStock_filter_categoryId');
var type = localStorage.getItem('datatableStock_filter_typeId');

console.log("search_text", search_text);
console.log("category", category);
console.log("type", type);

if (search_text) {
    $('#notification-dot-search').removeClass('d-none');
    $('#stock_input_search').val(search_text);
}
if (category) {
    $('#notification-dot').removeClass('d-none');
    $('#category-filter-dropdown').val(category);
    $('#category-filter-dropdown').trigger('change');
}
if (type) {
    $('#notification-dot').removeClass('d-none');
    $('#type-filter-dropdown').val(type);
    $('#type-filter-dropdown').trigger('change');
}
});

// // Save the filtering state to local storage when the user navigates away from the page
// $(window).on('unload', function() {
//     localStorage.setItem('datatableStock_filter', $('#datatableStock_filter input').val());
// });

$(window).on('load', function() {
var filterValue = localStorage.getItem('datatableStock_filter');
if (filterValue) {
    $('#datatableStock_filter input').val(filterValue).keyup();
}
});
   $(document).ready(function() {
    var base_url = window.location.origin;
    var url = window.location.pathname;
    var parts = url.split('/');
    var lastPart = parts[parts.length - 1];

    var table = NioApp.DataTable('#datatableStock', {
        processing: true,
        serverSide: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Tümü"]
        ],
        ajax: {
            url: base_url + '/tportal/giderler/getOfferList/' + lastPart,
            data: function(d) {
                d.category_id = $('#category-filter-dropdown').find(':selected').val();
                d.type_id = $('#type-filter-dropdown').find(':selected').val();
            }
        },
        stateSave: true,
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
            $(row).addClass('nk-tb-item');
            <?php if(session()->get("user_id") != 1): ?>
            $(row).on('click', function() {
                // Burada 'data.id' örneğin veritabanından gelen bir ID olabilir. URL'yi kendi durumuna göre güncelle.
                window.location.href = '../detail/' + data.gider_id;
                });
                <?php endif; ?>
        },
        columns: [{
                data: null,
                className: 'nk-tb-col',
                render: function(data) {
                    disabled = '';
                  
                    return `
                    <div class="custom-control custom-control-sm custom-checkbox notext datatable-checkbox-container">
                        <input type="checkbox"  class="custom-control-input datatable-checkbox" data-id="${data.gider_id}" data-stock-no="${data.gider_id}" id="stockRow_${data.gider_id}"  ${disabled} >
                        <label class="custom-control-label datatable-checkbox-label" for="stockRow_${data.gider_id}"></label>
                    </div>`;
                }
            },
            {
                data: 'order_date',
                className: 'nk-tb-col tb-col-lg',
                render: function(data, type, row) {

                    var datetime = new Date(row.gider_date);

                    // Tarih ve saat bileşenlerini ayırma
                    var year = datetime.getFullYear();
                    var month = ("0" + (datetime.getMonth() + 1)).slice(-2); // Aylar 0-11 aralığında olduğu için 1 ekliyoruz ve 2 haneli yapıyoruz
                    var day = ("0" + datetime.getDate()).slice(-2); // Günü 2 haneli yapıyoruz

                    var hours = ("0" + datetime.getHours()).slice(-2); // Saati 2 haneli yapıyoruz
                    var minutes = ("0" + datetime.getMinutes()).slice(-2); // Dakikayı 2 haneli yapıyoruz
                    var seconds = ("0" + datetime.getSeconds()).slice(-2); // Saniyeyi 2 haneli yapıyoruz

                    // Tarih ve saat stringleri oluşturma
                    var dateStr = day + "/" + month + "/" + year;
                    var timeStr = hours + ":" + minutes + ":" + seconds;
                    return `
                    <div class="user-info">
                        <span class="tb-lead">${dateStr}</span>
                        <span>${timeStr}</span>
                    </div>`;
                }
            },
         
            {
                data: 'gider_no',
                className: 'nk-tb-col tb-col-md',
                render: function(data, type, row) {
                    
                    let orderNo = row.gider_no;

                    return `
                    <div class="user-info">
                        <span class="tb-lead">${orderNo}</span>
                        <span></span>
                             
                    </div>`;
                }
            },

            {
                data: 'cari_invoice_title',
                className: 'nk-tb-col tb-col-md',
                render: function(data, type, row) {

                    let action = '';
                    let stok = '';

                    if (row.action !== '') {
                        action = `<span class="action-class">${row.action}</span><br>`;
                    }

                    if (row.stok !== '') {
                        stok = `<span class="stok-class">${row.stok}</span><br>`;
                    }
                    return `
                    <div class="user-info">
                        <span class="tb-lead">${row.cari_invoice_title}</span>

                       

                             
                    </div>`;
                }
            },

       
            {
    data: 'amount_to_be_paid',
    className: 'nk-tb-col tb-col-md',
    render: function(data, type, row) {
        // amount_to_be_paid'i sayıya çevirip, yoksa 0 olarak varsayıyoruz
        let totalprice = parseFloat(row.amount_to_be_paid || 0).toFixed(2); // 2 basamaklı gösterim
        
        // money_code'u kontrol ediyoruz, boşsa varsayılan değer ekliyoruz
        let moneyCode = row.money_code ? row.money_code : 'N/A'; // N/A veya başka bir varsayılan para birimi

        return `
            <span class="tb-amount">${totalprice} ${moneyCode}</span>`;
    }
},
            {
                data: 'offer_status',
                className: 'nk-tb-col tb-col-md',
                render: function(data, type, row) {
                    let statusText = "";
                    let statusTextColor = "";
                   
                    if (row.offer_status === 'new') {
                        statusText = "YENİ";
                        statusTextColor = "text-primary";
                    } else if (row.offer_status === 'pending') {
                        statusText = "BEKLİYOR";
                        statusTextColor = "text-warning";
                    } else if (row.offer_status === 'success') {
                        statusText = "ÖDENDİ";
                        statusTextColor = "text-success";
                    }else if (row.offer_status === 'failed') {
                        statusText = "İPTAL";
                        statusTextColor = "text-danger";
                    }
                   

                    var datetime = new Date(row.updated_at);

// Tarih ve saat bileşenlerini ayırma
var year = datetime.getFullYear();
var month = ("0" + (datetime.getMonth() + 1)).slice(-2); // Aylar 0-11 aralığında olduğu için 1 ekliyoruz ve 2 haneli yapıyoruz
var day = ("0" + datetime.getDate()).slice(-2); // Günü 2 haneli yapıyoruz

var hours = ("0" + datetime.getHours()).slice(-2); // Saati 2 haneli yapıyoruz
var minutes = ("0" + datetime.getMinutes()).slice(-2); // Dakikayı 2 haneli yapıyoruz
var seconds = ("0" + datetime.getSeconds()).slice(-2); // Saniyeyi 2 haneli yapıyoruz

// Tarih ve saat stringleri oluşturma
var dateStr = day + "/" + month + "/" + year;
var timeStr = hours + ":" + minutes + ":" + seconds;

                    return `  
                 <div class="user-info">
                        <span class="tb-lead ${statusTextColor}">${statusText}</span>
                        <span>S.Gnc: ${dateStr} ${timeStr}</span>
                             
                    </div>
                 `;
                }
            },
            {
    data: null,
    className: 'nk-tb-col tb-col-md',
    render: function(data, type, row) {
        let kk_logo = '';

        if (data.kargo_kodu != '') {
            //kk_logo = `<a style="margin-right:10px" data-dopigo="${row.dopigo}" title="Kargo Kodunu Güncelle" class="urunGuncelle btn btn-round btn-icon btn-outline-danger"><em class="icon ni ni-reload-alt"></em></a>`;
            kk_logo = '';
        }

        return `<div style="display:flex;">${kk_logo}<a href="../detail/${row.gider_id}" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a></div>`;
    }
}
        ],
    });
    var table = $('#datatableStock').DataTable();

    // Arama ve filtreleme ile ilgili kodlarınızı buraya ekleyin
    $('#stock_input_search').keyup(function() {
        var searchWord = $(this).val().toLocaleUpperCase('tr-TR');
        table.search(searchWord).draw();
        localStorage.setItem('datatableStock_filter_search', searchWord);
        $('#stock_input_search').val(searchWord);

        if (this.value.length > 0) {
            $('#notification-dot-search').removeClass('d-none');
        } else {
            $('#notification-dot-search').addClass('d-none');
        }
    });

    $('#stock_input_search_clear_button').on('click', function(e) {
        $('#notification-dot-search').addClass('d-none');
        $('#stock_input_search').val('');
        localStorage.removeItem('datatableStock_filter_search');
        table.state.clear();
        table.ajax.reload();
        table.search('').draw();
    });



    $("#applyExport").on("click", function() {
        var sltd_value = $('#sltc_export').find(':selected').val();
        if (sltd_value == "toExcel") {
            table.button('.buttons-excel').trigger();
        } else if (sltd_value == "toPdf") {
            table.button('.buttons-pdf').trigger();
        } else if (sltd_value == "toPrint") {
            table.button('.buttons-print').trigger();
        }
    });

    $(document).ajaxComplete(function() {
        console.log("ajax bitti");
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

    $('#selectAllStock').on('click', function() {
        selectAll = false;
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
        var rows = $('#datatableStock').DataTable().rows().nodes();
    });
});

</script>

<script>

function getSelectedCheckboxValues() {
    var selectedValues = [];
    
    // Seçili olan checkbox'ları seç
    $('.datatable-checkbox:checked').not(':disabled').each(function() {
        // Checkbox'ın 'data-id' değerini al
        selectedValues.push($(this).data('id'));
    });
    
    return selectedValues;
}




$(document).ready(function() {
    var table = $('#datatableStock').DataTable();

    
    // Filter by status when dropdown changes
   /* $('.durumaGore').on('change', function() {
        var selectedStatus = $(this).val();

        if (selectedStatus === '0') {
            // If 'Hepsi' is selected, clear the filter and show all rows
            table.column(6).search('').draw(); // 6 is the index of the 'order_status' column
        } else {
            // Apply the filter to the order_status column
            table.column(6).search(selectedStatus).draw();
        }
    }); */



    // Filter by status when dropdown changes
    $('.serviceSecme').on('click', function() {
       

// Yükleniyor SweetAlert'ini göster ve 1.5 saniye bekle
Swal.fire({
    title: 'Yükleniyor...',
    allowOutsideClick: false, // Dışarıya tıklayarak kapatmayı engelle
    onBeforeOpen: () => {
        Swal.showLoading(); // Yükleniyor animasyonunu göster
        setTimeout(() => {
            Swal.close(); // 1.5 saniye sonra SweetAlert'i kapat

            var selectedStatus = $(this).attr("data-service");

            if (selectedStatus === '0') {
                // Eğer 'Hepsi' seçildiyse, filtreyi temizle ve tüm satırları göster
                table.column(2).search('').draw(); 
            } else {
                // order_status sütununa filtre uygula
                table.column(2).search(selectedStatus).draw();
            }

            // Bugünün tarihi için tarih filtrelemesi yap
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); // Ocak 0 olarak kabul ediliyor
            var yyyy = today.getFullYear();
            
            var formattedToday = yyyy + '-' + mm + '-' + dd;

            var base_url = window.location.origin;
            var url = window.location.pathname;
            var parts = url.split('/');
            var lastPart = parts[parts.length - 1];

            var startDate = $('#report_date_start').val();
            var endDate = $('#report_date_end').val();

            function validateDateRange(startDate, endDate) {
        if (!startDate || !endDate) {
            return true; // Eğer tarihler boşsa geçerli olarak kabul et
        }
        
        var start = new Date(startDate.split('/').reverse().join('-'));
        var end = new Date(endDate.split('/').reverse().join('-'));

        return end >= start;
    }

            // Tarih aralığı geçerli mi kontrol et
            if (validateDateRange(startDate, endDate)) {
                // Eğer geçerli ise, filtreyi uygula
                table.ajax.url(base_url + '/tportal/giderler/getOfferList/' + lastPart + '?start_date=' + startDate + '&end_date=' + endDate).load();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Geçersiz Tarih Aralığı',
                    text: 'Bitiş tarihi, başlangıç tarihinden önce olamaz!',
                    confirmButtonText: 'Tamam'
                });
            }

        }, 1000); // 1.5 saniye
    }

});
});
});

$('.toplu_islem').on('change', function() {
                // Seçilen değeri al
                var selectedValue = $(this).val();

                // Eğer seçilen değer boşsa butonu devre dışı bırak
                if (selectedValue == '#') {
                    $("#indirButton").addClass("disabled");
                    $("#indirButton").prop("href", "#");
                    return;
                }

                // Butonu etkinleştir
                $("#indirButton").removeClass("disabled");

                // href özniteliğini güncelle
                $('#indirButton').attr('href', selectedValue);
            });
            $(document).ready(function() {
    // Initialize your DataTable
    var table = $('#datatableStock').DataTable();

    


      // "Filtreyi Uygula" butonuna tıklama olayı
      $('#applyFilters').on('click', function() {
    var base_url = window.location.origin;
    var url = window.location.pathname;
    var parts = url.split('/');
    var lastPart = parts[parts.length - 1];

    var startDate = $('#report_date_start').val();
    var endDate = $('#report_date_end').val();

    var selectedStatus = $("#durumaGore").val();  // Durum seçimini al
    var selecMusteri = $("#musteriGore").val();  // Durum seçimini al
    var selectedPlatform = $("#platformSec").val();  // Platform seçimini al
    
    if (validateDateRange(startDate, endDate)) {
        // Geçerli tarih aralığı ise filtreleri uygula
        var ajaxUrl = base_url + '/tportal/stock/giderler/getOfferList/' + lastPart + 
                      '?start_date=' + startDate + 
                      '&end_date=' + endDate + 
                      '&status=' + selectedStatus + 
                      '&musteri=' + selecMusteri + 
                      '&platform=' + selectedPlatform;

        table.ajax.url(ajaxUrl).load();
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Geçersiz Tarih Aralığı',
            text: 'Bitiş tarihi, başlangıç tarihinden önce olamaz!',
            confirmButtonText: 'Tamam'
        });
    }
});

    // "Filtreyi Temizle" butonuna tıklama olayı
    $('#clearFilters').on('click', function() {
        var base_url = window.location.origin;
    var url = window.location.pathname;
    var parts = url.split('/');
    var lastPart = parts[parts.length - 1];
        // Tarih girişlerini temizle
        $('#report_date_start').val('<?php echo Date("d/m/Y"); ?>');
        $('#report_date_end').val('<?php echo Date("d/m/Y"); ?>');

        // Filtreleri sıfırla ve DataTable'ı yeniden yükle
        table.ajax.url(base_url + '/tportal/stock/giderler/getOfferList/' + lastPart).load();
    });

    // Tarih aralığını kontrol eden fonksiyon
    function validateDateRange(startDate, endDate) {
        if (!startDate || !endDate) {
            return true; // Eğer tarihler boşsa geçerli olarak kabul et
        }
        
        var start = new Date(startDate.split('/').reverse().join('-'));
        var end = new Date(endDate.split('/').reverse().join('-'));

        return end >= start;
    }


});



</script>

<?= $this->endSection() ?>