<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Ürün Galeri <?= $this->endSection() ?>
<?= $this->section('title') ?> Ürün Galeri | <?= $stock_item['stock_code']; ?> - <?= $stock_item['stock_title'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>


<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head nk-block-head-lg">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Ürün Galeri</h4>
                                    </div>
                                    <div class="nk-block-head-content align-self-start">

                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1 d-lg-none"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">
                                <div class="row g-gs pb-5">
                                    <div class="col-12">
                                        <div id="stockImageDropZone" class="upload-zone"
                                            data-url="<?= route_to('tportal.stocks.gallery_create', $stock_item['stock_id']) ?>">
                                            <div class="dz-message" data-dz-message>
                                                <span class="dz-message-text">Sürükle Bırak</span>
                                                <span class="dz-message-or">veya</span>
                                                <button type="" class="btn btn-primary">Dosya Seç</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-gs">
                                    <?php foreach($gallery_items as $gallery_item){ ?>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="gallery card">
                                            <a class="gallery-image popup-image"
                                                href="<?= base_url($gallery_item['image_path']) ?>">
                                                <img class="w-100 p-3 rounded-top"
                                                    src="<?= base_url($gallery_item['image_path']) ?>"
                                                    alt="<?= $gallery_item['image_title'] ?>">
                                            </a>
                                            <div
                                                class="gallery-body card-inner align-center justify-between flex-wrap g-2">
                                                <div class="user-card">
                                                    <div class="user-info"><span
                                                            class="lead-text"><?= $stock_item['stock_code'] ?></span><span
                                                            class="sub-text"><?= $gallery_item['created_at'] ?></span><span
                                                            class="sub-text mt-1">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox"
                                                                    class="custom-control-input default-button"
                                                                    id="chk_cover_<?= $gallery_item['gallery_item_id']; ?>"
                                                                    data-stock-code="<?= $stock_item['stock_code'] ?>"
                                                                    data-image-path="<?= $gallery_item['image_path'] ?>"
                                                                    data-id="<?= $gallery_item['gallery_item_id'] ?>"
                                                                    <?php if($gallery_item['default'] == 'true'){echo "checked";} ?>>
                                                                <label class="custom-control-label"
                                                                    for="chk_cover_<?= $gallery_item['gallery_item_id']; ?>">Kapak</label>
                                                            </div>
                                                        </span>
                                                        <span class="sub-text mt-1">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox"
                                                                    class="custom-control-input status-button"
                                                                    id="chk_status_<?= $gallery_item['gallery_item_id']; ?>"
                                                                    data-status="<?= $gallery_item['status'] ?>"
                                                                    data-id="<?= $gallery_item['gallery_item_id'] ?>"
                                                                    <?php if($gallery_item['status'] == 'active'){echo "checked";} ?>>
                                                                <label class="custom-control-label"
                                                                    for="chk_status_<?= $gallery_item['gallery_item_id']; ?>">Yayında</label>
                                                            </div>
                                                        </span>
                                                        <span class="lead-text mt-1 d-block">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    Sıra : <?= $gallery_item['order'] ?>
                                                                </div>
                                                                <div class="col-6 text-end">
                                                                    <a href="#" data-bs-toggle="modal"
                                                                        class="btn btn-round btn-icon btn-xs btn-dim btn-outline-dark edit-action"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#mdl_gallery_item_edit"
                                                                        data-order="<?= $gallery_item['order'] ?>"
                                                                        data-item-id="<?= $gallery_item['gallery_item_id'] ?>"><em
                                                                            class="icon ni ni-pen-alt-fill"></em></a>
                                                                    <a href="#"
                                                                        class="btn btn-round btn-icon btn-xs btn-dim btn-outline-danger delete-action"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#mdl_gallery_item_delete"
                                                                        data-default-image="<?= $stock_item['default_image'] ?>"
                                                                        data-item-id="<?= $gallery_item['gallery_item_id'] ?>"
                                                                        data-stock-code="<?= $stock_item['stock_code'] ?>"><em
                                                                            class="icon ni ni-trash-empty"></em></a>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?= $this->include('tportal/stoklar/detay/inc/sol_menu') ?>
                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<!-- Edit Modal Form -->
<div class="modal fade" id="mdl_gallery_item_edit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Resmi Düzenle</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="form_gallery_item_edit" method="post" class="form-validate is-alter"
                    data-stock-code="<?= $stock_item['stock_code'] ?>" data-item-id="">
                    <div class="form-group">
                        <label class="form-label" for="edit_order">Resim Sırası</label>
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
                        <button type="button" id="form_gallery_item_edit_save"
                            class="btn btn-lg btn-primary ">KAYDET</button>
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
                            class="btn btn-l btn-mw btn-secondary">Ürün Galerisine
                            Dön</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="mdl_gallery_item_delete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent"
                        style="font-size: 70px;"></em>
                    <h4 class="nk-modal-title">Resmi Silmek İstediğinize<br>Emin misiniz?</h4>
                    <div class="nk-modal-action mb-5">
                        <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger" id="delete-action"
                            data-bs-dismiss="modal">Evet</a>
                    </div>
                    <div class="nk-modal-text">
                        <!-- <p class="lead">Bu ürünü silmeniz için;<br>mevcut herhangi bir üretim emri olmamalıdır.</p> -->
                        <p class="text-soft">Silmeden önce lütfen yetkilinize danışınız.</p>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
$('.delete-action').on('click', function(e) {
    gallery_item_id = $(this).attr('data-item-id');
    stock_code = $(this).attr('data-stock-code');
    default_image = $(this).attr('data-default-image');

    $('#delete-action').attr('data-item-id', gallery_item_id);
    $('#delete-action').attr('data-stock-code', stock_code);
    $('#delete-action').attr('data-default-image', default_image);
});

$('#delete-action').on('click', function(e) {
    stock_code = $(this).attr('data-stock-code');
    default_image = $(this).attr('data-default-image');
    item_id = $(this).attr('data-item-id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.gallery_delete') ?>',
        dataType: 'json',
        data: {
            gallery_item_id: item_id,
            stock_code: stock_code,
            default_image: default_image
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#trigger_gallery_item_ok").trigger("click");
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
});

$('.edit-action').on('click', function() {
    order = $(this).attr('data-order');
    item_id = $(this).attr('data-item-id');

    $('#edit_order').val(order);
    $('#form_gallery_item_edit').attr('data-item-id', item_id);

})

$('#form_gallery_item_edit_save').on('click', function(e) {
    if ($('#edit_order').val() == '') {
        swetAlert("Eksik Birşeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
    } else {
        var formData = $('#form_gallery_item_edit').serializeArray();
        formData.push({
            name: 'stock_code',
            value: $('#form_gallery_item_edit').attr('data-stock-code')
        });
        formData.push({
            name: 'gallery_item_id',
            value: $('#form_gallery_item_edit').attr('data-item-id')
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.gallery_edit') ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    $("#trigger_gallery_item_ok").trigger("click");
                } else {
                    $('#mdl_gallery_item_edit').modal('toggle');
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
    }
});

$('.default-button').on('click', function() {

    $(".default-button").prop('checked', false);
    $(this).prop('checked', true);

    gallery_item_id = $(this).data('id');
    stock_code = $(this).data('stock-code');
    image_path = $(this).data('image-path');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.gallery_edit.default') ?>',
        dataType: 'json',
        data: {
            gallery_item_id: gallery_item_id,
            stock_code: stock_code,
            image_path: image_path
        },
        async: true,
        success: function(response) {
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
    })
});

$('.status-button').on('change', function() {
    if ($(this).data('status') == 'passive') {
        $(this).data('status', 'active');
    } else {
        $(this).data('status', 'passive')
    }

    gallery_item_id = $(this).data('id');
    status = $(this).data('status');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.gallery_edit.status') ?>',
        dataType: 'json',
        data: {
            status: status,
            gallery_item_id: gallery_item_id
        },
        async: true,
        success: function(response) {
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
    })
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
                    $("#trigger_gallery_item_ok").trigger("click");
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
</script>

<?= $this->endSection() ?>