<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> <?= $page_title ?> <?= $this->endSection() ?>
<?= $this->section('title') ?> <?= $page_title ?> | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>

<style>
    div#DataTables_Table_0_length {
    display: none;
    visibility: hidden;
}

div#DataTables_Table_0_filter {
    display: none;
}
</style>

<style>
/* Yeni etiketi için stil */
.new-tag {
    position: absolute;
    top: -10px;
    right: -10px;
    z-index: 4;
}

.new-tag span {
    background: linear-gradient(45deg, #FF6B6B, #FF8787);
    color: white;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: bold;
    box-shadow: 0 2px 4px rgba(255, 107, 107, 0.3);
    display: inline-block;
}

/* Yanıp sönme animasyonu */
.blink {
    animation: blink-animation 1s ease-in-out infinite;
}

@keyframes blink-animation {
    0% { opacity: 1; }
    50% { opacity: 0.6; }
    100% { opacity: 1; }
}

/* Seçenek hover efekti */
.btn-outline-info {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.btn-outline-info:hover {
    border-color: #09c2de;
    box-shadow: 0 0 15px rgba(9, 194, 222, 0.2);
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
                               
                                        <div class="btn-wrap  w-500px">
                                            <div style="display:flex;">
                                            <?php if($yazdirildi == 1): ?>

                                                <span style="" class="d-none d-md-block"><a href="<?php echo base_url('tportal/order/sevk_emirleri'); ?>" class="btn btn-dim btn-outline-primary "> <em class="icon ni ni-chevron-left"></em>Açık Sevk Emirlerine Geri Dön</a></span>

                                            <?php else: ?>
                                                <span style="" class="d-none d-md-block"><a href="<?php echo base_url('tportal/order/list/all'); ?>" class="btn btn-dim btn-outline-primary "> <em class="icon ni ni-chevron-left"></em> Siparişlere Geri Dön</a></span>

                                                <span style="margin-left:10px" class="d-none d-md-block"><a href="<?php echo base_url('tportal/order/sevk_emirleri/yazdirilanlar'); ?>" class="btn  btn-primary "> <em  style="margin-top:-5px; margin-right:5px" class="icon ni ni-repeat-fill"></em> TAMAMLANAN SEVK EMİRLERİ</a></span>

                                            <?php endif; ?>
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
                                        <input type="text" id="stock_input_searchs" class="form-control border-transparent form-focus-none" placeholder="Bulmak istediğiniz ürünün adını yada kodunu yazınız..">
                                        <a href="#" class="btn btn-icon toggle-search active" data-target="search" style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em class="icon ni ni-cross"></em></a>
                                        <button class="search-submit btn btn-icon" style="margin-right: 50px;" id="stock_input_search_clear_buttons" name="stock_input_search_clear_buttons"><em class="icon ni ni-trash"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div><!-- .card-inner -->



                        <div class="card-inner p-0">

<table id="" class="datatable-init-hareketlers nk-tb-list nk-tb-ulist" data-auto-responsive="false">
    <thead>
        <tr class="nk-tb-item nk-tb-head tb-tnx-head">
            <th class="nk-tb-col"><span class="sub-text"> ID</span></th>
            <th class="nk-tb-col"><span class="sub-text">Emir Tarihi</span></th>
            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">Sevkiyat Emir No</span></th>
            <th class="nk-tb-col tb-col-md"  data-orderable="false"><span class="sub-text">Siparişler</span></th>
            <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">SEVK FİŞ</span></th>
            <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">Sevk Durum</span></th>
            <th class="nk-tb-col tb-col-md"  width="11%;" data-orderable="false"><span class="sub-text"></span></th>
        </tr>
    </thead>
    <tbody>
        <form method="POST">
        <?php 
        
        function showSubstringAfterCharacter($kelime, $str) {
            if (strlen($kelime) > $str)
		{
			if (function_exists("mb_substr")) $kelime = mb_substr($kelime, 0, $str, "UTF-8").'..';
			else $kelime = substr($kelime, 0, $str).'..';
		}
		return $kelime;
        }
        foreach($sevkler as $sevk): ?>
        
            <tr class="nk-tb-item">
                <td class="nk-tb-col tb-col-mb">
                <?= $sevk['sevk_id'] ?>
                </td>
                <td class="nk-tb-col tb-col-mb" data-order="<?= convert_date_for_view($sevk['created_at']) ?>">
                    <div class="user-info">
                        <span class="tb-lead"><?= convert_date_for_view($sevk['created_at']) ?></span>
                        <span><?= convert_time_for_form($sevk['created_at']) ?></span>
                    </div>
                </td>
                <td class="nk-tb-col tb-col-mb">
                    <div class="user-info">
                        <span class="tb-lead"><?= $sevk['sevk_no'] ?></span>
                    </div>
                </td>
                <td title="<?php echo $sevk['order_no']; ?>"  class="nk-tb-col tb-col-md">
                <?= showSubstringAfterCharacter($sevk['order_no'], 70) ?>
                </td>
                <td class="nk-tb-col tb-col-md">
                    <?php switch ($sevk['print']) {
                        case '1':
                            echo "<span class='tb-status text-success'> YAZDIRILDI </span>";
                            break;
                        case '0':
                            echo "<span class='tb-status text-primary'> BEKLEMEDE </span>";
                            break;
                    } ?>
                </td>
                <td class="nk-tb-col tb-col-md">
                    <?php switch ($sevk['bitti']) {
                        case '1':
                            echo "<span class='tb-status text-success'> TAMAMLANDI </span>";
                            break;
                        case '0':
                            echo "<span class='tb-status text-primary'> DEVAM EDİYOR </span>";
                            break;
                            case '3':
                                echo "<span class='tb-status text-danger'> MANUEL KAPATILDI </span>";
                                break;
                            case '2':
                                echo "<span class='tb-status text-danger'>  İPTAL EDİLDİ </span>";
                                break;
                    } ?>
                </td>
                <td class="nk-tb-col nk-tb-col-tools  text-end">
                    <?php if($sevk["bitti"] == 0): ?>
                 <a  data-order="<?php echo $sevk["sevk_id"] ?>" class="btn btn-round btn-icon btn-outline-info sevkBak"><em class="icon ni ni-layers"></em></a>
                        <?php endif; ?>
                <a  href="#"  data-sevkid="<?= $sevk['sevk_id'] ?>" class="btn btn-round btn-icon sevkGonder btn-outline-light"><em class="icon ni ni-printer"></em></a>
           
            </td>
            </tr><!-- .nk-tb-item -->
        <?php endforeach; ?>
        </form>
    </tbody>
</table>

                        </div>


                  
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>
<div class="modal fade" id="sevkEmirleri" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Açık Sevkin Son 5 Siparişi <em class="icon ni ni-info"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Açık Sevk Emirleri"></em></h5>
                <a href="#" id="btn_mdl_musteriSec_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>TARİH</th>
                            <th>SİPARİŞ NO</th>
                            <th>MÜŞTERİ</th>
                            <th>DURUM</th>
                        </tr>
                    </thead>
                    <tbody id="siparis_icerikleri" style="margin-top:5px">
                       
                                
                    </tbody>
                </table>
            </div>
            <div class="modal-footer d-flex justify-content-between align-items-center">
                <input type="hidden" id="sevk_id">
    <div style="flex:1">
        <select class="form-select form-select-lg js-select2 form-control" id="new_sevk_status" data-placeholder="Seçiniz">
            <option></option>
            <option value="sevk_edildi">Sevk Edildi</option>
            <option value="failed">İptal Edildi</option>
            <option value="teknik_hata">Teknik Hata</option>
            <option value="stokta_yok">Stokta Yok</option>
            <option value="kargo_bekliyor">Kargo Bekliyor</option>

        </select>
    </div>
    <div class="text-end">
        <button  id="sevkStatusDegis" class="btn btn-primary">( <div style="margin-left:3px; margin-right:3px;" id="toplamSiparis"></div> SİPARİŞİ ) Güncelle</button>
        <a href="" id="yonlendirSevk" class="btn  btn-secondary">Detaylı Güncelle</a>
    </div>
</div>
        </div>
    </div>
</div>
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Sevkiyat Fişi Yazdır</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="display:flex; gap:15px;">
                    <ul class="custom-control-group custom-control-vertical w-100" style="flex-direction: row;">
                        <li style="flex:1">
                            <div style="height: 100px;" class="custom-control custom-control-sm custom-radio custom-control-pro">
                                <input type="radio" class="custom-control-input" name="printOption" id="printOption1" onclick="openLink('siparisBazli')">
                                <label class="custom-control-label" for="printOption1">
                                    <em class="icon icon-lg ni ni-clipboad-check"></em>
                                    <span><b>SİPARİŞ BAZLI </b></span>
                                </label>
                            </div>
                        </li>
                        <li style="flex:1; position: relative;" class="btn-outline-info">
    <!-- Yeni etiketi -->
    <div class="new-tag">
        <span class="blink">YENİ</span>
    </div>
    <div style="height: 100px;" class="custom-control custom-control-sm custom-radio custom-control-pro">
        <input type="radio" class="custom-control-input" name="printOption" id="printOption2" onclick="openLink('tarihBazli')">
        <label class="custom-control-label" for="printOption2">
            <em class="icon icon-lg ni ni-calendar"></em>
            <span><b>TARİH BAZLI </b></span>
        </label>
    </div>
</li>
                        <li style="flex:1">
                            <div style="height: 100px;" class="custom-control custom-control-sm custom-radio custom-control-pro">
                                <input type="radio" class="custom-control-input" name="printOption" id="printOption2" onclick="openLink('urunBazli')">
                                <label class="custom-control-label" for="printOption2">
                                    <em class="icon icon-lg ni ni-layers"></em>
                                    <span><b>ÜRÜN BAZLI </b></span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Global değişken olarak sevkID
    let sevkID = null;

    // Butona tıklandığında sevkID'yi ayarla ve modalı aç
    $(".sevkGonder").click(function() {
        sevkID = $(this).attr("data-sevkid"); // Butondan sevkID al
        $("#printModal").modal("show"); // Modalı göster
    });

    // URL'yi sevkID'ye göre ayarla ve yeni sekmede aç
    function openLink(type) {
        let url = '';
        if (type === 'siparisBazli') {
            $("#printModal").modal("hide"); // Modalı göster
            url = `<?= base_url("tportal/order/sevkPrints") ?>/${sevkID}`;
        } else if (type === 'urunBazli') {
            $("#printModal").modal("hide"); // Modalı göster
            url = `<?= base_url("tportal/order/sevkPrint") ?>/${sevkID}`;
        }
        else if (type === 'tarihBazli') {
            $("#printModal").modal("hide"); // Modalı göster
            url = `<?= base_url("tportal/order/sevkPrint_tarih") ?>/${sevkID}`;
        }
        // Yeni sekmede URL'yi aç
        window.open(url, '_blank');
    }
</script>
<?= $this->endSection() ?>

<?= $this->section('script') ?>




<script>

    $(".sevkGonder").click(function(){
        $("#printModal").modal("show");
        sevkID = $(this).attr("data-sevkid");

    });


// DataTables başlatma ve ayarları
var table = $('.datatable-init-hareketlers').DataTable({
    language: {
    search: "",
    searchPlaceholder: "Arama kelimesi giriniz..",
    lengthMenu: "<span class='d-none'>Göster</span><div class='form-control-select d-none'> _MENU_ </div>",
    info: "_TOTAL_ kayıttan _START_-_END_ arası",
    infoEmpty: "0",
    infoFiltered: "( Toplam _MAX_ )",
    paginate: {
      first: "İlk",
      last: "Son",
      next: "İleri",
      previous: "Geri"
    }
  },
  pageLength: 15, // Varsayılan sayfa uzunluğu
  lengthMenu: [
    [15, 50, 100, -1], // Sayfa uzunluğu seçenekleri
    [15, 50, 100, "Tümü"] // Kullanıcıya gösterilen metin
  ],
  pagingType: 'full_numbers',
  order: [[0, "DESC"]], // İkinci sütunu DESC olarak sıralar
  buttons: ['copy', 'excel', 'csv', 'pdf'],
});

// Arama ve filtreleme ile ilgili kodlar
$('#stock_input_searchs').keyup(function() {
  var searchWord = $(this).val().toLocaleUpperCase('tr-TR');
  
  // DataTables arama işlevi
  table.search(searchWord).draw(); // search fonksiyonu
  localStorage.setItem('datatableStock_filter_searchs', searchWord);
  $('#stock_input_searchs').val(searchWord);
  
  // Bildirim noktasını göster/gizle
  if (this.value.length > 0) {
    $('#notification-dot-search').removeClass('d-none');
  } else {
    $('#notification-dot-search').addClass('d-none');
  }
});

// Arama temizleme butonu
$('#stock_input_search_clear_buttons').on('click', function(e) {
  $('#notification-dot-search').addClass('d-none');
  $('#stock_input_searchs').val('');
  localStorage.removeItem('datatableStock_filter_searchs');
        table.search('').draw();
});



    $('#sevkEmirleri').on('shown.bs.modal', function () {
    $(".js-select2").select2({
        dropdownParent: $('#sevkEmirleri') // Dropdown menüsünün modal içinde kalmasını sağlar
    });
});


    $(".sevkBak").click(function(){

        var selectedValues = [$(this).attr("data-order")];


 

$.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.siparisler.sevkGetir') ?>',
                dataType: 'json',
                data: {
                    sevk_id: selectedValues                   
                },
                async: true,
                success: function (response) {
                    
                    $("#siparis_icerikleri").html('');

                    $("#yonlendirSevk").attr("href", response["link"]);

                    $('#sevkEmirleri').modal('show');  // Örneğin, Bootstrap modal kullanıyorsanız bu şekilde açabilirsiniz
                    setTimeout(() => {
                    $(".js-select2").select2();
                    }, 100);
                    $("#toplamSiparis").html(response["toplamSiparis"]);
                    $("#sevk_id").val(response["sevk_id"]);
                    $("#siparis_icerikleri").html(response['html']);

                      
                    
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: 'Başarılı!',
                        html: 'Sevkiyat Emri Başarıyla Oluşturuldu.',
                        icon: 'success',
                        confirmButtonText: 'Tamam',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    });

                
                }
            });

    });


$("#sevkStatusDegis").click(function(){

Swal.fire({
title: 'Sevk emrine ait siparişlerin durumları toplu olarak değiştirilsin mi?',
icon: 'warning',
showCancelButton: true,
confirmButtonText: 'Evet, Devam Et',
cancelButtonText: 'Hayır',
}).then((result) => {
if (result.isConfirmed) {
    Swal.fire({
    title: 'Sevkiyat emiri  durumları değiştiriliyor lütfen sayfayı kapatmayınız!',
    allowOutsideClick: false,
    onBeforeOpen: () => {
        Swal.showLoading();
    },
});


var  sevk_id = $("#sevk_id").val();
     new_sevk_status = $("#new_sevk_status").val();



$.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.siparisler.sevkGuncelle') ?>',
                dataType: 'json',
                data: {
                    sevk_id: sevk_id,
                    new_sevk_status:new_sevk_status                   
                },
                async: true,
                success: function (response) {
                    if (response['icon'] == 'success') {
                        Swal.fire({
                            title: 'Başarılı!',
                            html: 'Sevkiyat Emri Başarıyla Kapatıldı. Yeni Sevk Emiri Oluşturabilirsiniz.',
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(() => {
                            location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                        }, 2600);
                    }

                    if (response['icon'] == 'error') {
                        Swal.fire({
                            title: 'Bilgilendirme!',
                            html: response['message'],
                            icon: 'error',
                            confirmButtonText: 'Sevk Emiri Kapatılırken Bir Hata Oluştu',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                      
                    }

                }
            });



} else {
    // Handle if the user clicks Cancel
}
});


});



function getSelectedCheckboxValues() {
    var selectedValues = [];
    
    // Seçili olan checkbox'ları seç
    $('.datatable-checkbox:checked').each(function() {
        // Checkbox'ın 'data-id' değerini al
        selectedValues.push($(this).data('id'));
    });
    
    return selectedValues;
}
$("#indirButton").click(function(){

var data = $(".toplu_islem").val();

if (data == "b2b") {

    Swal.fire({
        title: 'MSH B2B sitesindeki siparişlerinizi aktarmak istiyormusunuz?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Evet, Devam Et',
        cancelButtonText: 'Hayır',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
            title: 'Siparişleriniz çekiliyor lütfen sayfayı kapatmayınız!',
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading();
            },
        });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.api.msh') ?>',
                dataType: 'json',
                data: {
                    // You can pass any additional data here if needed
                },
                async: true,
                success: function (response) {
                    Swal.fire({
                        title: 'Başarılı!',
                        html: 'B2B Sipariş Portalından Siparişler Başarıyla Çekildi.', // Display the server error message
                        icon: 'success',
                        confirmButtonText: 'Tamam',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    });

                    setTimeout(() => {
                            location.reload(); // Reload the page after a delay
                        }, 2600);
                       

               
           
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: 'Başarılı!',
                        html: 'B2B Sipariş Portalından Siparişler Başarıyla Çekildi.', // Display the server error message
                        icon: 'success',
                        confirmButtonText: 'Tamam',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    });

                    setTimeout(() => {
                            location.reload(); // Reload the page after a delay
                        }, 2600);

                }
            });

        } else {
            // Handle if the user clicks Cancel
        }
    });
}




if (data == "sevk_emri") {

Swal.fire({
    title: 'Seçili olan siparişler için sevkiyat emiri oluşturmak istiyormusunuz?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, Devam Et',
    cancelButtonText: 'Hayır',
}).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
        title: 'Sevkiyat emiri  oluşturuluyor lütfen sayfayı kapatmayınız!',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
    });


    var selectedValues = getSelectedCheckboxValues();

 

    $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= route_to('tportal.siparisler.sevkEmirleri') ?>',
                    dataType: 'json',
                    data: {
                        order_id: selectedValues                    
                    },
                    async: true,
                    success: function (response) {
                        Swal.fire({
                            title: 'Başarılı!',
                            html: 'Sevkiyat Emri Başarıyla Oluşturuldu.',
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(() => {
                            location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                        }, 260330);
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Başarılı!',
                            html: 'Sevkiyat Emri Başarıyla Oluşturuldu.',
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(() => {
                            location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                        }, 263300);
                    }
                });



    } else {
        // Handle if the user clicks Cancel
    }
});
}



if (data == "dopigo") {

Swal.fire({
    title: 'Fams DOPİGO sitesindeki siparişlerinizi aktarmak istiyormusunuz?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, Devam Et',
    cancelButtonText: 'Hayır',
}).then((result) => {
    if (result.isConfirmed) {

        // Tarih aralığı almak için input alanları ekle
        Swal.fire({
            title: 'Tarih  Seçin',
            html:
                '<label for="start_date">Tarih Seçin:</label>' +
                '<input type="date" id="start_date" class="swal2-input" />',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Siparişleri Çek',
            cancelButtonText: 'İptal',
            preConfirm: () => {
                const startDate = Swal.getPopup().querySelector('#start_date').value;
                const endDate = Swal.getPopup().querySelector('#start_date').value;
                if (!startDate || !endDate) {
                    Swal.showValidationMessage('Lütfen geçerli bir tarih aralığı girin');
                    return false;
                }
                return { startDate: startDate, endDate: endDate };
            }
        }).then((dateResult) => {
            if (dateResult.isConfirmed) {
                
                Swal.fire({
                    title: 'Siparişleriniz çekiliyor lütfen sayfayı kapatmayınız!',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    },
                });

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= route_to('tportal.api.dopigo') ?>',
                    dataType: 'json',
                    data: {
                        start_date: dateResult.value.startDate,
                        end_date: dateResult.value.endDate
                        // Gerekirse buraya ek veri ekleyebilirsiniz
                    },
                    async: true,
                    success: function (response) {
                        Swal.fire({
                            title: 'Başarılı!',
                            html: 'DOPİGO Sipariş Portalından Siparişler Başarıyla Çekildi.',
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(() => {
                            location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                        }, 2600);
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Başarılı!',
                            html: 'DOPİGO Sipariş Portalından Siparişler Başarıyla Çekildi.',
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(() => {
                            location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                        }, 2600);
                    }
                });

            } else {
                // Kullanıcı Cancel butonuna tıklarsa yapılacak işlemler
            }
        });
    }
});
}





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

</script>

<?= $this->endSection() ?>