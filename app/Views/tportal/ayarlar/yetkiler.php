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
                                        <h5>Kullanıcı Yetkileri</h5>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>
                                            <div class="form-inline flex-nowrap gx-3">
                                                <!-- <div class="">
                                                    <div class="">
                                                        <p>İşlem Tarihi: </p>
                                                    </div>
                                                </div> -->
                                                <!-- <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </li><!-- li -->
                                        <li class="btn-toolbar-sep d-none"></li><!-- li -->
                                        <!-- li -->
                                    </ul><!-- .btn-toolbar -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search"
                                            data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" id="invoice_input_search"
                                            class="form-control border-transparent form-focus-none"
                                            placeholder="Bulmak istediğiniz faturanın fatura ünvanını veya fatura numarasını yazınız...">
                                        <a href="#" class="btn btn-icon toggle-search" data-target="search"
                                            style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em
                                                class="icon ni ni-cross"></em></a>
                                        <button class="search-submit btn btn-icon" style="margin-right: 50px;"
                                            id="invoice_input_search_clear_button"
                                            name="invoice_input_search_clear_button"><em
                                                class="icon ni ni-trash"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div>

                        <div class="card-inner p-0">
                            <div class="card card-preview">
                                <div class="card-inner">
                                    <h6 class="title mb-3">Kulanıcı</h6>
                                    <div class="row gy-4 align-center">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-lg"
                                                        placeholder="Kullanıcı Adı" id="user_name_surname"
                                                        name="user_name_surname" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-lg"
                                                        placeholder="Kullanıcı Eposta" id="user_eposta"
                                                        name="user_eposta" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-lg" data-bs-toggle="modal"
                                                    data-bs-target="#select_user_modal">Kullanıcı Seç</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <h6 class="title mb-3">Modüller</h6>
                                        <ul class="custom-control-group">



                                            <?php foreach ($all_module as $item) { ?>
                                                <tr>

                                                    <li>
                                                        <div
                                                            class="custom-control custom-control-sm custom-checkbox custom-control-pro checked">

                                                            <input type="checkbox"
                                                                class="custom-control-input checkUserModule"
                                                                name="btnCheckControl"
                                                                id="checkUserModule_<?= $item['module_id']; ?>"
                                                                data-module-title="<?= $item['module_title']; ?>"
                                                                data-module="<?= $item['module_id']; ?>">

                                                            <label class="custom-control-label"
                                                                for="checkUserModule_<?= $item['module_id']; ?>">
                                                                <?= $item['module_title']; ?>
                                                            </label>

                                                        </div>
                                                    </li>
                                                </tr>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <a href="javascript:history.back()"
                                                class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em
                                                    class="icon ni ni-arrow-left"></em><span>Geri</span></a>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <div class="form-group">
                                            <button id="btnSaveUserPermission"
                                                class="btn btn-lg btn-success">Kaydet</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- .card-inner-group -->
            </div><!-- .card -->

            <div class="modal fade" tabindex="-1" id="select_user_modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Kullanıcı Seç</h5>
                            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body bg-white">
                            <table class="table table-tranx is-compact">
                                <thead class="bg-light bg-opacity-75">
                                    <tr class="tb-tnx-head">
                                        <th class="tb-tnx-id">
                                            <span class="">#</span>
                                        </th>
                                        <th class="nk-tb-col"><span class="sub-text">KULLANICI EPOSTA </span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                class="sub-text">KULLANICI AD SOYAD</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                class="sub-text"></span></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $sira = 1;
                                    foreach ($user_list as $item) {
                                        ?>
                                        <tr>
                                            <td><?= $sira ?></td>


                                            <td>
                                                <div
                                                    class="custom-control custom-control-sm custom-checkbox notext datatable-checkbox-container">
                                                    <div class="custom-control custom-radio no-control">
                                                        <input type="radio" id="rd_user_<?= $item['client_id']; ?>"
                                                            name="rd_user"
                                                            class="custom-control-input rd_user btnModalUserPermission"
                                                            data-user-name-surname="<?= $item['user_adsoyad']; ?>"
                                                            data-user-eposta="<?= $item['user_eposta']; ?>"
                                                            data-client-id="<?= $item['client_id']; ?>"
                                                            data-user-id="<?= $item['user_id']; ?>">

                                                        <label class="text-primary text-nowrap"
                                                            for="rd_user_<?= $item['client_id']; ?>"><?= $item['user_eposta']; ?></label>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="tb-lead"><?= $item['user_adsoyad'] ?? '-' ?></span>
                                            </td>
                                        </tr>
                                        <?php $sira++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer d-block p-3 bg-white">
                            <div class="row">
                                <div class="col-md-4 p-0">
                                    <button type="button" class="btn btn-lg  btn-dim btn-outline-light"
                                        data-bs-dismiss="modal">KAPAT</button>
                                </div>
                                <div class="col-md-8 text-end p-0">
                                    <button type="button" id="btnCreateSubUser" class="btn btn-lg btn-primary">Kullanıcı
                                        Seç</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div><!-- .nk-block -->
    </div>
</div>
</div>

<button type="button" id="trigger_create_permission_info_modal" class="btn btn-success d-none" data-bs-toggle="modal"
    data-bs-target="#create_variant_multiple_info">Approve</button>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" id="create_variant_multiple_info">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em
                        class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent"></em>
                    <h4 class="nk-modal-title">Bazı Modüller Tanımlanamdı!</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text" id="info-caption-text"></div><br>
                        <ul id="failed_variant_items"></ul>
                    </div>
                    <div class="nk-modal-action">
                        <a class="btn btn-lg btn-mw btn-danger" id="approveInfo" onclick="window.location.reload()">Devam</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'create_permission_modal',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Modül yetkileri başarıyla tanımlandı.',
                'modal_buttons' => '<a href="' . route_to('tportal.ayarlar.yetkiler') . '" class="btn btn-primary btn-block mb-2">Yeni Modül Tanımlaması Yap</a>
                                    <a href="' . route_to('tportal.ayarlar.kullanici_yonetimi') . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Kullanıcı Yönetimine Git</a>'
            ],
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    $(document).on("click", ".btnModalUserPermission", function () {
        $('#select_user_modal').modal('hide');
        $(".checkUserModule").prop("checked", false);

        selectedUserNameSurname = $('.rd_user:checked').attr('data-user-name-surname');
        selectedUserEposta = $('.rd_user:checked').attr('data-user-eposta');

        selectedClientId = $('.rd_user:checked').attr('data-client-id');
        selectedUserId = $('.rd_user:checked').attr('data-user-id');

        $('#user_name_surname').val(selectedUserNameSurname);
        $('#user_eposta').val(selectedUserEposta);


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.ayarlar.yetkiler.get') ?>',
            dataType: 'json',
            data: {
                user_id: selectedUserId,
                client_id: selectedClientId,
            },
            success: function (response) {
                swal.close();

                if (response.icon == 'success') {
                    $(response.response).each(function (index, element) {
                        var temp_str = "checkUserModule_" + element.module_id;

                        if ($("input[id='" + temp_str + "']")) {
                            $("#"+temp_str).prop("checked", true);
                        }
                    });
                } else {
                    swetAlert("Hatalı İşlem", response['message'], "err");
                }
            }
        });

    });

    $(document).on("click", "#btnSaveUserPermission", function () {

        var list = [];
        var permission_list_c = [];
        var permission_list_u = [];

        var client_id = $("input[name=rd_user]:checked").attr('data-client-id');
        var user_id = $("input[name=rd_user]:checked").attr('data-user-id');

        list.push({
            name: "client_id",
            value: client_id
        });
        list.push({
            name: "user_id",
            value: user_id
        });

        $(".checkUserModule").each(function (index, element) {
            var module_id = $(this).attr('data-module')
            var temp_str = "checkUserModule_" + module_id;


            $("input[id='" + temp_str + "']").each(function (index, element) {
                if ($(this).is(':checked')) {
                    
                    var module_title = $(this).attr('data-module-title')
                    var module_id = $(this).attr('data-module')
    
                    if (module_id != undefined) {
                        permission_list_c.push({
                            name: module_title,
                            value: module_id,
                        });
                    }
                }
                else{
                    var module_title = $(this).attr('data-module-title')
                    var module_id = $(this).attr('data-module')
    
                    if (module_id != undefined) {
                        permission_list_u.push({
                            name: module_title,
                            value: module_id,
                        });
                    }
                }
            });
        });

        list.push({
            name: "permission_list_c",
            value: permission_list_c
        });
        list.push({
            name: "permission_list_u",
            value: permission_list_u
        });


        if ((client_id && user_id) && list.length > 2) {
            Swal.fire({
                title: 'Kaydetmek Üzeresiniz!',
                html: 'Kullanıcı için seçilen yetkileri tanımlamak üzeresiniz. Devam etmek istiyor musunuz?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Devam Et',
                cancelButtonText: 'Düzenle',
                allowEscapeKey: false,
                allowOutsideClick: false,

            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Yetkiler tanımlanıyor...',
                        html: 'Yetkiler tanımlanırken lütfen bekleyiniz...',
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
                        url: '<?= route_to('tportal.ayarlar.yetkiler.kaydet') ?>',
                        dataType: 'json',
                        data: {
                            params: list,
                        },
                        success: function (response) {
                            swal.close();

                            if (response.icon == 'success' || response.icon == 'warning') {
                                $("#trigger_create_permission_modal_ok_button").trigger("click");
                            }
                            // else if (response.icon == 'warning') {
                            //     $("#info-caption-text").html(response.message);
                            //     $.each(response['failed_items'], function (key, failed_item) {
                            //         jQuery('<li>', {
                            //             html: '<b>' + failed_item + '</b>'
                            //         }).appendTo('#failed_variant_items');
                            //     });
                            //     $("#trigger_create_permission_info_modal").trigger("click");
                            // } 
                            else {
                                swetAlert("Hatalı İşlem", response['message'], "err");
                            }
                        }
                    });
                }
            });

        }
        else {
            Swal.fire({
                title: 'Uyarı!',
                html: 'Kullanıcı ve modül seçimi yapılması zorunludur. <br> Lütfen kontrol edip tekrar deneyiniz.',
                icon: 'warning',
                confirmButtonText: 'Tamam',
                allowEscapeKey: false,
                allowOutsideClick: false,
            });
        }
    });
</script>

<?= $this->endSection() ?>