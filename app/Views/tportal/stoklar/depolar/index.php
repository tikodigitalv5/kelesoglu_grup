<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Depolar <?= $this->endSection() ?>
<?= $this->section('title') ?> Depolar | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>


<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Depolar</h3>
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
                                                                        class="ps-0 ms-0 pe-2">Yeni Depo</span></a>

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
                                        <a href="#" class="search-back btn btn-icon toggle-search"
                                            data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" class="form-control border-transparent form-focus-none"
                                            placeholder="Bulmak istediğiniz ürünün adını yada kodunu yazınız..">
                                        <button class="search-submit btn btn-icon"><em
                                                class="icon ni ni-search"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div><!-- .card-inner -->
                        <div class="card-inner p-0">
                            <div class="nk-tb-list nk-tb-ulist">
                                <div class="nk-tb-item nk-tb-head tb-tnx-head">
                                    <div class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid">
                                            <label class="custom-control-label" for="uid"></label>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col"><span class="sub-text">Sıralama</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Depo Adı</span></div>
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Durum</span></div>
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Varsayılan</span></div>
                                    <div class="nk-tb-col nk-tb-col-tools text-end">

                                    </div>
                                </div><!-- .nk-tb-item -->

                                <?php 
                              foreach($warehouse_items as $warehouse_item){ ?>

                                <div class="nk-tb-item" data-url="'.route_to('tportal.stoklar.detay').'"
                                    id="warehouse_'.$warehouse_item['warehouse_id'].'">
                                    <div class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid3">
                                            <label class="custom-control-label" for="uid3"></label>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead"><?= $warehouse_item['order'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead"><?= $warehouse_item['warehouse_title'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <div class="custom-control custom-switch ps-0">
                                            <div id="div_status_<?= $warehouse_item['warehouse_id'] ?>"
                                                class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input status-button"
                                                    data-status="<?= $warehouse_item['status'] ?>"
                                                    data-id="<?= $warehouse_item['warehouse_id'] ?>"
                                                    id="chk_status_<?= $warehouse_item['warehouse_id'] ?>"
                                                    <?php if($warehouse_item['status'] == 'active'){ ?>checked
                                                    <?php } ?>>
                                                <label class="custom-control-label"
                                                    id="btn_status_<?= $warehouse_item['warehouse_id'] ?>"
                                                    for="chk_status_<?= $warehouse_item['warehouse_id'] ?>">
                                                    <?php if($warehouse_item['status'] == 'active'){ echo 'Aktif'; }else{ echo 'Pasif'; } ?>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <div class="custom-control custom-switch ps-0">
                                            <div id="div_default_<?= $warehouse_item['warehouse_id'] ?>"
                                                class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input default-button"
                                                    data-default="<?= $warehouse_item['default'] ?>"
                                                    data-id="<?= $warehouse_item['warehouse_id'] ?>"
                                                    id="chk_default_<?= $warehouse_item['warehouse_id'] ?>"
                                                    <?php if($warehouse_item['default'] == 'true'){ ?>checked <?php } ?>>
                                                <label class="custom-control-label"
                                                    id="btn_default_<?= $warehouse_item['warehouse_id'] ?>"
                                                    for="chk_default_<?= $warehouse_item['warehouse_id'] ?>">
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="nk-tb-col nk-tb-col-tools  text-end">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#editModalForm"
                                            data-item-id="<?= $warehouse_item['warehouse_id'] ?>"
                                            data-title="<?= $warehouse_item['warehouse_title'] ?>"
                                            data-order="<?= $warehouse_item['order'] ?>"
                                            class="btn btn-round btn-icon btn-dim btn-outline-dark edit-action"><em
                                                class="icon ni ni-pen-alt-fill"></em></a>
                                        <a href="#"
                                            class="btn btn-round btn-icon btn-dim btn-outline-danger delete-action"
                                            data-bs-toggle="modal" data-bs-target="#modal_delete_warehouse"
                                            data-item-id="<?= $warehouse_item['warehouse_id'] ?>"><em
                                                class="icon ni ni-trash-empty"></em></a>

                                    </div>
                                </div><!-- .nk-tb-item -->
                                <?php
                              } 
                              ?>

                            </div><!-- .nk-tb-list -->
                        </div><!-- .card-inner -->
                        <div class="card-inner">
                            <div class="nk-block-between-md g-3">
                                <div class="g">
                                    <ul class="pagination justify-content-center justify-content-md-start">
                                        <li class="page-item"><a class="page-link" href="#">Geri</a></li>
                                        <li class="page-item  active"><a class="page-link" style="color:#fff"
                                                href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><span class="page-link"><em
                                                    class="icon ni ni-more-h"></em></span></li>
                                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                                        <li class="page-item"><a class="page-link" href="#">7</a></li>
                                        <li class="page-item"><a class="page-link" href="#">İleri</a></li>
                                    </ul><!-- .pagination -->
                                </div>
                                <div class="g d-none">
                                    <div
                                        class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                                        <div>Page</div>
                                        <div>
                                            <select class="form-select js-select2" data-search="on"
                                                data-dropdown="xs center">
                                                <option value="page-1">1</option>
                                                <option value="page-2">2</option>
                                                <option value="page-4">4</option>
                                                <option value="page-5">5</option>
                                                <option value="page-6">6</option>
                                                <option value="page-7">7</option>
                                                <option value="page-8">8</option>
                                                <option value="page-9">9</option>
                                                <option value="page-10">10</option>
                                                <option value="page-11">11</option>
                                                <option value="page-12">12</option>
                                                <option value="page-13">13</option>
                                                <option value="page-14">14</option>
                                                <option value="page-15">15</option>
                                                <option value="page-16">16</option>
                                                <option value="page-17">17</option>
                                                <option value="page-18">18</option>
                                                <option value="page-19">19</option>
                                                <option value="page-20">20</option>
                                            </select>
                                        </div>
                                        <div>OF 102</div>
                                    </div>
                                </div><!-- .pagination-goto -->
                            </div><!-- .nk-block-between -->
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
                <h5 class="modal-title">Yeni Depo</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="createWarehouseForm" method="post" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="warehouse_title">Depo Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="warehouse_title"
                                name="warehouse_title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="warehouse_title">Sıralama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="order" name="order" required>
                        </div>
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
                    <div class="row g-3 align-center">
                        <div class="col-lg-5 col-xxl-5 col-6">
                            <div class="form-group">
                                <label class="form-label">Varsayılan</label>
                            </div>
                        </div>
                        <div class="col-lg-7 col-xxl-7 col-6">
                            <div class="custom-control custom-switch">
                                <div id="is_default" class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="chk_default"
                                        name="default">
                                    <label class="custom-control-label" for="chk_default"></label>
                                </div>
                            </div>
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
                        <button type="button" id="warehouseOlustur" class="btn btn-lg btn-primary ">KAYDET</button>
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
                <h5 class="modal-title">Depo Düzenle</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="editWarehouseForm" method="post" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="warehouse_title">Depo Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_warehouse_title"
                                name="warehouse_title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="order">Sıralama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_order" name="order"
                                required>
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
                        <button type="button" id="warehouseDuzenle" class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'warehouse',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="#" data-bs-toggle="modal" data-bs-target="#createModalForm" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Depo Ekle</a>
                                    <a href="#" onclick="location.reload()" class="btn btn-l btn-dim btn-outline-dark btn-block">Depo Listesi</a>'
            ],
            'delete' => [
                'modal_title' => 'Bu Depoyu Silmek İstediğinize<br>Emin misiniz?',
                'modal_text' => 'Bu depoyu silmeden önce lütfen yetkilinize danışınız.',
            ]
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
var item_id = 0;
$('#warehouseOlustur').click(function(e) {
    if ($('#warehouse_title').val() == '') {
        swetAlert("Eksik Birşeyler Var", "Depo Adı Giriniz.! ", "err");
    } else {
        var formData = $('#createWarehouseForm').serializeArray();
        formData.push({
            name: 'warehouse_value',
            value: ''
        });
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.warehouse.create') ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    $("#createWarehouseForm")[0].reset();
                    $('#createModalForm').modal('toggle');
                    $("#trigger_warehouse_ok_button").trigger("click");
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

$('#modal_delete_warehouse_button').on('click', function() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.warehouse.delete') ?>',
        dataType: 'json',
        data: {
            warehouse_id: item_id,
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#editWarehouseForm")[0].reset();
                $("#createWarehouseForm")[0].reset();
                $("#trigger_warehouse_ok_button").trigger("click");
            }
        }
    })
});

$('.edit-action').on('click', function() {
    item_id = $(this).attr('data-item-id');
    item_title = $(this).attr('data-title');
    item_order = $(this).attr('data-order');

    $('#edit_warehouse_title').val(item_title);
    $('#edit_order').val(item_order);

    $('#warehouseDuzenle').click(function(e) {
        if ($('#edit_warehouse_title').val() == '') {
            swetAlert("Eksik Birşeyler Var", "Depo Adı Giriniz.! ", "err");
        } else {
            var formData = $('#editWarehouseForm').serializeArray();
            formData.push({
                name: 'warehouse_value',
                value: ''
            });
            formData.push({
                name: 'warehouse_id',
                value: item_id
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.stocks.warehouse.edit') ?>',
                dataType: 'json',
                data: formData,
                async: true,
                success: function(response) {

                    if (response['icon'] == 'success') {
                        $("#editWarehouseForm")[0].reset();
                        $("#createWarehouseForm")[0].reset();
                        $('#editModalForm').modal('toggle');
                        $("#trigger_warehouse_ok_button").trigger("click");
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

    warehouse_id = $(this).data('id');
    status = $(this).data('status');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.warehouse.edit.status') ?>',
        dataType: 'json',
        data: {
            status: status,
            warehouse_id: warehouse_id
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#editWarehouseForm")[0].reset();
                $("#createWarehouseForm")[0].reset();
                $("#trigger_warehouse_ok_button").trigger("click");
            } else {
                $('#sevkOlustur').attr("disabled", false);
                return false;
            }
        }
    })
});

$('.default-button').on('click', function() {

    $(".default-button").prop('checked', false);
    $(this).prop('checked', true);

    warehouse_id = $(this).data('id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.warehouse.edit.default') ?>',
        dataType: 'json',
        data: {
            warehouse_id: warehouse_id
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#editWarehouseForm")[0].reset();
                $("#createWarehouseForm")[0].reset();
                $("#trigger_warehouse_ok_button").trigger("click");
            } else {
                $('#sevkOlustur').attr("disabled", false);
                return false;
            }
        }
    })
});
</script>

<?= $this->endSection() ?>