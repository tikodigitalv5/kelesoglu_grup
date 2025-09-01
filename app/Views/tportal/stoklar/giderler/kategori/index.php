<?= $this->extend('tportal/layout') ?>
<?php 

$title = "Gider Kategorileri";
$title_new = "Gider Kategori";
?>
<?= $this->section('page_title') ?> <?php echo $title; ?> <?= $this->endSection() ?>
<?= $this->section('title') ?> <?php echo $title; ?> | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>


<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title"><?php echo $title; ?></h3>
                        <!-- <div class="nk-block-des text-soft">
                          <p>You have total 2,595 users.</p>
                      </div> -->
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
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
                                    <div class="form-inline flex-nowrap gx-3">
                                        <div class="form-wrap w-150px">
                                            <select class="form-select js-select2" data-search="off"
                                                data-placeholder="Toplu İşlem">
                                                <option value="">Toplu İşlem</option>
                                                <option value="#">İndir (Excel)</option>
                                                <option value="#">İndir (PDF)</option>
                                                <option value="#">Yazdır</option>
                                                <option value="#">Seçilenleri Sil</option>
                                            </select>
                                        </div>
                                        <div class="btn-wrap">
                                            <span class="d-none d-md-block"><button
                                                    class="btn btn-dim btn-outline-light disabled">Uygula</button></span>
                                            <span class="d-md-none"><button
                                                    class="btn btn-dim btn-outline-light btn-icon disabled"><em
                                                        class="icon ni ni-arrow-right"></em></button></span>
                                        </div>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>
                                            <a href="#" class="btn btn-icon search-toggle toggle-search"
                                                data-target="search"><em class="icon ni ni-search"></em></a>
                                        </li><!-- li -->
                                        <li class="btn-toolbar-sep"></li><!-- li -->
                                        <li>
                                            <div class="toggle-wrap">
                                                <a href="#" class="btn btn-icon btn-trigger toggle"
                                                    data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                <div class="toggle-content" data-content="cardTools">
                                                    <ul class="btn-toolbar gx-1">
                                                        <li class="toggle-close">
                                                            <a href="#" class="btn btn-icon btn-trigger toggle"
                                                                data-target="cardTools"><em
                                                                    class="icon ni ni-arrow-left"></em></a>
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#"
                                                                    class="btn btn-trigger btn-icon dropdown-toggle d-none"
                                                                    data-bs-toggle="dropdown">
                                                                    <div class="dot dot-primary"></div>
                                                                    <em class="icon ni ni-filter-alt"></em>
                                                                </a>
                                                                <div
                                                                    class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                                    <div class="dropdown-head">
                                                                        <span class="sub-title dropdown-title">Detaylı
                                                                            Arama</span>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="btn btn-sm btn-icon">
                                                                                <em class="icon ni ni-more-h"></em>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="dropdown-foot between">
                                                                        <a class="clickable" href="#">Reset Filter</a>
                                                                        <a href="#">Save Filter</a>
                                                                    </div>
                                                                </div><!-- .filter-wg -->
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#createModalForm"><em
                                                                        class="icon ni ni-plus"></em><span
                                                                        class="ps-0 ms-0 pe-2">Yeni  <?php echo $title_new; ?></span></a>

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
                                        <input type="text" id="stock_input_search" class="form-control border-transparent form-focus-none" placeholder="Bulmak istediğiniz ürünün adını yada kodunu yazınız..">
                                        <a href="#" class="btn btn-icon toggle-search active" data-target="search" style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em class="icon ni ni-cross"></em></a>
                                        <button class="search-submit btn btn-icon" style="margin-right: 50px;" id="stock_input_search_clear_button" name="stock_input_search_clear_button"><em class="icon ni ni-trash"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div><!-- .card-inner -->
                        <div class="card-inner p-0">


                        <table id="hareketler" class="nowrap table datatable-init-hareketler nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                <thead>
                                    <tr class="nk-tb-item nk-tb-head tb-tnx-head">
                                       

                                
                                        <th width="2%" class="nk-tb-col tb-col-md"><span class="sub-text">Sıralama</span></th>
                                      
                                        <th width="3%" class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">Grubu</span></th>
                                        <th width="3%" class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text"><?php echo $title_new; ?> Adı</span></th>
                                       
                                        <th  width="3%" class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">Durum</span></th>
                                        <th width="20%" class="nk-tb-col nk-tb-col-tools text-end" data-orderable="false"></th>
                                        <th width="20%" class="nk-tb-col nk-tb-col-tools text-end" data-orderable="false"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                              foreach($category_items as $category_item){ ?>
                                <tr  >

                        
                                <td class="nk-tb-col tb-col-md">
                              
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead"><?= $category_item['order'] ?></span>
                                            </div>
                                        </div>
                                 
                                </td>
                                <td class="nk-tb-col tb-col-md">
                             
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead"><b><?= $category_item['gider_group_category_title'] ?></b></span>
                                            </div>
                                        </div>
                                   
                                </td>
                                <td class="nk-tb-col tb-col-md">
                              
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead"><?= $category_item['gider_category_title'] ?></span>
                                            </div>
                                        </div>
                                   
                                </td>
                                <td class="nk-tb-col tb-col-md">
                              
                                        <div class="custom-control custom-switch ps-0">
                                            <div id="div_status_<?= $category_item['gider_category_id'] ?>"
                                                class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input status-button"
                                                    data-status="<?= $category_item['status'] ?>"
                                                    data-id="<?= $category_item['gider_category_id'] ?>"
                                                  
                                                    id="chk_status_<?= $category_item['gider_category_id'] ?>"
                                                    <?php if($category_item['status'] == 'active'){ ?>checked
                                                    <?php } ?>>
                                                <label class="custom-control-label"
                                                    id="btn_status_<?= $category_item['gider_category_id'] ?>"
                                                    for="chk_status_<?= $category_item['gider_category_id'] ?>">
                                                    <?php if($category_item['status'] == 'active'){ echo 'Aktif'; }else{ echo 'Pasif'; } ?>
                                                </label>
                                            </div>

                                        </div>
                                   
                                
                                </td>
                                <td class="nk-tb-col nk-tb-col-tools  text-end">
                              
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#editModalForm"
                                            data-item-id="<?= $category_item['gider_category_id'] ?>"
                                            data-title="<?= $category_item['gider_category_title'] ?>"
                                            data-order="<?= $category_item['order'] ?>"
                                            data-grup="<?= $category_item['grup_id'] ?>"
                                            data-img="<?= get_image_url($category_item['default_image'] ?? null); ?>"
                                            class="btn btn-round btn-icon btn-dim btn-outline-dark edit-action"><em
                                                class="icon ni ni-pen-alt-fill"></em></a>
                                        <a href="#"
                                            class="btn btn-round btn-icon btn-dim btn-outline-danger delete-action"
                                            data-bs-toggle="modal" data-bs-target="#modal_delete_category"
                                            data-item-id="<?= $category_item['gider_category_id'] ?>"><em
                                                class="icon ni ni-trash-empty"></em></a>

                               
                                </td>
<td></td>

                                </tr>
                                <?php
                              } 
                              ?>
                                </tbody>
                            </table>

                        </div><!-- .card-inner -->
                    
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>




<!-- Create Modal Form -->
<div class="modal fade" id="createModalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni  <?php echo $title_new; ?></h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="createCategoryForm" method="post" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="gider_category_title"> <?php echo $title_new; ?> Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="gider_category_title"
                                name="gider_category_title" required>
                        </div>
                    </div>
                  
                    <div class="form-group">
                        <label class="form-label" for="gider_category_title">Sıralama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="order" name="order" required>
                        </div>
                    </div>



                  
                    <div class="form-group">
                        <select class="form-select js-select2" id="gider_new_id"
                            name="gider_new_id" data-ui="lg" data-val="Gider Grubu Seçiniz ">
                            <option value="null" selected>Gider Grubu Seçiniz </option>
                          <?php foreach($gruplar as $grup): ?>
                            <option value="<?php echo $grup["gider_group_category_id"]; ?>" ><?php echo $grup["gider_group_category_title"]; ?> </option>
                          <?php endforeach; ?>
                        </select>
                    </div>
                                            


                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-5 col-xxl-5 col-6">
                            <div class="form-group">
                                <label class="form-label">Durum</label>
                            </div>
                        </div>
                        <div class="col-lg-7 col-xxl-7 col-6">
                            <ul class="custom-control-group g-3 align-center flex-wrap">
                                <li>
                                    <div class="custom-control custom-control-xl custom-radio checked"><input
                                            type="radio" class="custom-control-input" value="active" checked=""
                                            name="status" id="reg-enable"><label class="custom-control-label"
                                            for="reg-enable">Aktif</label></div>
                                </li>
                                <li>
                                    <div class="custom-control custom-control-xl custom-radio"><input type="radio"
                                            class="custom-control-input" value="passive" name="status" id="reg-disable">
                                        <label class="custom-control-label" for="reg-disable">Pasif</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-dim btn-outline-light"
                            data-bs-dismiss="modal">KAPAT</button>

                    </div>
                    <div class="col-md-8 text-end p-0">
                        <!-- <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ HESAP</button> -->
                        <button type="button" id="categoryOlustur" class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal Form -->
<div class="modal fade" id="editModalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <?php echo $title_new; ?> Düzenle</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-white">
                <form id="editCategoryForm" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="form-label" for="edit_gider_category_title"> <?php echo $title_new; ?> Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_gider_category_title"
                                name="gider_category_title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_order">Sıralama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_order" name="order"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <select class="form-select js-select2" id="grup_id"
                            name="grup_id" data-ui="lg" data-val="Gider Grubu Seçiniz ">
                            <option value="null" selected>Gider Grubu Seçiniz </option>
                          <?php foreach($gruplar as $grup): ?>
                            <option value="<?php echo $grup["gider_group_category_id"]; ?>" ><?php echo $grup["gider_group_category_title"]; ?> </option>
                          <?php endforeach; ?>
                        </select>
                    </div>
                             
                   
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" class="btn btn-lg  btn-dim btn-outline-light"
                            data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <button type="button" class="btn btn-lg btn-primary" id="categoryDuzenle">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button type="button" id="trigger_gallery_item_ok" class="btn btn-success d-none" data-bs-toggle="modal"
    data-bs-target="#mdl_gallery_item_ok">OK</button>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" id="mdl_gallery_item_ok">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                    <h4 class="nk-modal-title">İşlem Başarılı!</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text" id="txt_OK"></div>
                        </span>
                    </div>
                    <div class="nk-modal-action">
                        <a href="#" data-bs-dismiss="modal" onclick="location.reload()"
                            class="btn btn-l btn-mw btn-secondary"><?php echo $title_new; ?> Geri
                            Dön</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'category',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="#" data-bs-toggle="modal" data-bs-target="#createModalForm" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni '.$title_new.' Ekle</a>
                                    <a href="#" onclick="location.reload()" class="btn btn-l btn-dim btn-outline-dark btn-block">'.$title_new.' Listesi</a>'
            ],
            'delete' => [
                'modal_title' => 'Bu '.$title_new.' Silmek İstediğinize<br>Emin misiniz?',
                'modal_text' => 'Bu '.$title_new.' silmeden önce lütfen yetkilinize danışınız.',
            ]
        ],
    ]
); ?>



<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
var item_id = 0;
$('#categoryOlustur').click(function(e) {
    if ($('#gider_category_title').val() == '') {
        swetAlert("Eksik Birşeyler Var", "<?php echo $title_new; ?> Adı Giriniz.! ", "err");
    } else if ($('#gider_new_id').val() == 'null') {
        swetAlert("Eksik Birşeyler Var", "Gider Grubunu Seçiniz.! ", "err");
    } else {
        var formData = $('#createCategoryForm').serializeArray();

    

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.gider_kategorileri.create') ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {

                if (response['icon'] == 'success') {
                    $("#createCategoryForm")[0].reset();
                    $('#createModalForm').modal('toggle');
                    $("#trigger_category_ok_button").trigger("click");
                } else {
                    $('#sevkOlustur').attr("disabled", false);
                    return false;
                }
            }
        })
    }

});

$('.delete-action').on('click', function() {
    item_id = $(this).attr('data-item-id');
});

$('#modal_delete_category_button').on('click', function() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.gider_kategorileri.delete') ?>',
        dataType: 'json',
        data: {
            gider_category_id: item_id,
        },
        async: true,
        success: function (response) {
               
          
            if (response["icon"] == "success") {
                $("#editCategoryForm")[0].reset();
                $("#createCategoryForm")[0].reset();
                $("#trigger_category_ok_button").trigger("click");

            

            }else{

                var detailsHtml = '';
                if (response["details"] && response["details"].length > 0) {
                    detailsHtml = '<ul>';
                    response["details"].forEach(function(detail) {
                        detailsHtml += '<li><b>' + detail.stock_title + '</b></li>';
                    });
                    detailsHtml += '</ul>';
                }

                Swal.fire({
                    title: response["icon"] === 'success' ? 'Başarılı!' : 'İşlem Başarısız',
                    html: response["icon"] === 'error' ? response["message"] + detailsHtml : response["message"],
                    confirmButtonText: 'Tamam',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    icon: response["icon"],
                });
               
            }
        }
    })
});

$('.edit-action').on('click', function() {
    item_id = $(this).attr('data-item-id');
    item_title = $(this).attr('data-title');
    item_order = $(this).attr('data-order');
    item_img =   $(this).attr("data-img");
    grup_id =   $(this).attr("data-grup");





    $('#edit_gider_category_title').val(item_title);
    $('#edit_order').val(item_order);
    $('#grup_id').val(grup_id).trigger('change');

    $('.editImg').attr("src", item_img);
    $('.editPopup').attr("href", item_img);
    $('#stockImageDropZone').attr("data-url", "<?php echo base_url("tportal/stock/altkategoriler/create-gallery/") ?>"+item_id+"");

    
    

    $('#categoryDuzenle').click(function(e) {

if ($('#edit_category_title').val() == '') {
    swetAlert("Eksik Birşeyler Var", "<?php echo $title_new ?> Adı Giriniz.! ", "err");
} else {
    var formData = $('#editCategoryForm').serializeArray();
    formData.push({
        name: 'gider_category_id',
        value: item_id
    });

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.gider_kategorileri.edit') ?>',
        dataType: 'json',
        data: formData,
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#editCategoryForm")[0].reset();
                $('#editModalForm').modal('toggle');
                $("#trigger_category_ok_button").trigger("click");
            } else {
                $('#sevkOlustur').attr("disabled", false);
                return false;
            }
        }
    })
}
})

});

$('.status-button').on('change', function() {
    if ($(this).data('status') == 'passive') {
        $('#btn_status_' + $(this).data('id')).html('Aktif');
        $(this).data('status', 'active');
    } else {
        $('#btn_status_' + $(this).data('id')).html('Pasif');
        $(this).data('status', 'passive')
    }

    gider_category_id = $(this).data('id');
    status = $(this).data('status');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.gider_kategorileri.edit.status') ?>',
        dataType: 'json',
        data: {
            status: status,
            gider_category_id: gider_category_id
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#editCategoryForm")[0].reset();
                $("#createCategoryForm")[0].reset();
                $("#trigger_category_ok_button").trigger("click");
            } else {
                $('#sevkOlustur').attr("disabled", false);
                return false;
            }
        }
    })
});


$('#close_modal_create').on('click', function(){
    gider_category_id = $(this).attr('data-category-id')
    $('#mdl_variant_category_list_'+gider_category_id).modal('toggle');
});

$(document).ready(function() {
    var uploadSection = Dropzone.forElement("#stockImageDropZone");

    uploadSection.on("complete", function(file) {
        var $data_url = $("#stockImageDropZone").data("url");

        var formData = new FormData();
        formData.append('file', file);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: $data_url,
            dataType: 'json',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false,
            async: true,
            success: function(response) {
                console.log(response)
                if (response['icon'] == 'success') {
              

                    $('.editImg').attr("src", response['imagePath']);
                    $('.editPopup').attr("href", response['imagePath']);
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })

                    Toast.fire({
                        icon: response['icon'],
                        title: response['message']
                    })
                }
            }
        })
        // uploadSection.removeFile(file);

    });
});


$(document).ready(function() {
    var uploadSection = Dropzone.forElement("#stockImageDropZonee");

    uploadSection.on("complete", function(file) {
        var $data_url = $("#stockImageDropZonee").data("url");

        var formData = new FormData();
        formData.append('file', file);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: "<?php echo base_url("tportal/stock/altkategoriler/create-gallery/0") ?>",
            dataType: 'json',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false,
            async: true,
            success: function(response) {
                console.log(response)
                if (response['icon'] == 'success') {
              

                    $('.editImgs').attr("src", response['imagePath']);
                    $('.editPopups').attr("href", response['imagePath']);
                    $('#upload_image').val(response['imagePath']);

                    
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })

                    Toast.fire({
                        icon: response['icon'],
                        title: response['message']
                    })
                }
            }
        })
        // uploadSection.removeFile(file);

    });
});



    //stock search input
    $('#stock_input_search').keyup(function() {
            var searchWord = $(this).val().toLocaleUpperCase('tr-TR');

            var table = $('#hareketler').DataTable();
            table.search(searchWord).draw();

            localStorage.setItem('hareketler_filter_search', searchWord);

            $('#stock_input_search').val(searchWord);

            if (this.value.length > 0) {
                $('#notification-dot-search').removeClass('d-none');
            } else {
                $('#notification-dot-search').addClass('d-none');
            }

        });


</script>

<?= $this->endSection() ?>