<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Cari Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Cari Detay | <?= session()->get('user_item')['firma_adi'] ?> <?= $this->endSection() ?>
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
                                        <h4 class="nk-block-title">Yetkili Bilgileri</h4>

                                    </div>
                                    <div class="nk-block-head-content align-self-start">
                                        <button data-bs-toggle="modal" data-bs-target="#mdl_create_cari_user" class="btn btn-primary">Yeni Yetkili</button>
                                        <button class="toggle btn btn-icon btn-trigger mt-n1 d-lg-none" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></button>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">
                                <div class="nk-data data-list">


                                    <table class="datatable-init-hareketler nowrap table" data-export-title="Export">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2;">Ad soyad</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Telefon / Dahili</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">E-posta</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Departman</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false"></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($cari_user_items as $cari_user_item) { ?>
                                                <?php
                                                $basePhone = $cari_user_item['cari_user_phone'];
                                                $splitPhone = explode(" ", $basePhone);
                                                ?>
                                                <tr>
                                                    <td><?= $cari_user_item['cari_user_name'] ?></td>
                                                    <td class="money-mask"><?= $cari_user_item['cari_user_phone'] ?></td>
                                                    <td><?= $cari_user_item['cari_user_email'] ?></td>
                                                    <td>
                                                        <?php switch ($cari_user_item['department_id']) {
                                                            case '1':
                                                                echo "Firma Sahibi";
                                                                break;
                                                            case '2':
                                                                echo "Muhasebe";
                                                                break;
                                                            case '3':
                                                                echo "Satış";
                                                                break;
                                                            case '4':
                                                                echo "Satınalma";
                                                                break;
                                                        } ?>
                                                    </td>

                                                    <td class="text-end">
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#mdl_edit_cari_user" id="editCariUser" user_id="<?= $cari_user_item['cari_user_id'] ?>" user="<?= $cari_user_item['cari_user_name'] ?>" user_phone_area_code="<?= $splitPhone[0] ?>" user_phone="<?= $splitPhone[1] ?>" user_internal_number="<?= $cari_user_item['internal_number'] ?>" user_email="<?= $cari_user_item['cari_user_email'] ?>" user_department="<?= $cari_user_item['department_id'] ?>" class="btn btn-icon btn-xs btn-dim btn-outline-dark editCariUser"><em class="icon ni ni-pen-alt-fill"></em></button>
                                                        <button type="button" id="deleteCariUser" user_id="<?= $cari_user_item['cari_user_id'] ?>" user="<?= $cari_user_item['cari_user_name'] ?>" user_phone="<?= $cari_user_item['cari_user_phone'] ?>" user_internal_number="<?= $cari_user_item['internal_number'] ?>" user_email="<?= $cari_user_item['cari_user_email'] ?>" class="btn btn-icon btn-xs btn-dim btn-outline-danger deleteCariUser"><em class="icon ni ni-trash-empty"></em></button>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div><!-- data-list -->

                            </div><!-- .nk-block -->
                        </div>

                        <?= $this->include('tportal/cariler/detay/inc/sol_menu') ?>
                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>



<!-- Create Cari User Modal -->
<div id="mdl_create_cari_user" class="modal fade" role="dialog" aria-labelledby="mdl_create_cari_user" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Yetkili</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="createCariUserForm" method="post" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="type_title">Departman Seç</label>
                        <div class="form-control-wrap">
                            <select class="form-select  init-select2" data-ui="xl" name="department_id" id="department_id">
                                <option value="0" selected disabled>Lütfen Seçiniz</option>

                                <option value="1">Firma Sahibi</option>
                                <option value="2">Muhasebe</option>
                                <option value="3">Satış</option>
                                <option value="4">Satınalma</option>

                            </select>
                        </div>
                    </div>

                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-12">
                            <label class="form-label" for="type_title">Ad Soyad</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="Yetkilinin Adı" id="cari_user_name" name="cari_user_name" required>
                            </div>
                        </div>

                    </div>

                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-12">
                            <label class="form-label" for="type_title">E-posta</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="Yetkilinin E-posta Adresi" id="cari_user_email" name="cari_user_email" required>
                            </div>
                        </div>

                    </div>

                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-9 col-xxl-9 col-9">
                            <label class="form-label" for="type_title">Telefonu</label>
                            <div class="form-control-wrap">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-lg btn-block btn-dim btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                                                <span id="lastAreaCode">seçiniz</span>
                                                <em class="icon mx-n1 ni ni-chevron-down"></em>
                                            </button>
                                            <div class="dropdown-menu">
                                                <select id="area_code" name="area_code" class="form-select js-select2" data-ui="lg" data-search="on" data-placeholder="Seçiniz">
                                                    <option id="selecteditem" value="">Seçiniz</option>
                                                    <option value="+90">🇹🇷 (+90) Türkiye</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" name="cari_user_phone" id="cari_user_phone" aria-label="Carinin iletişim için telefon numarası" placeholder="000 000 0000" onkeypress="return SadeceRakam(event,['-'],'');">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xxl-3 col-3">
                            <label class="form-label" for="type_title">Dahili</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="000" required="" id="cari_user_internal_number" name="cari_user_internal_number" maxlength="4">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-dim btn-outline-light" data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <!-- <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ HESAP</button> -->
                        <button type="button" id="saveCariUser" class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Cari User Modal -->
<div id="mdl_edit_cari_user" class="modal fade" role="dialog" aria-labelledby="mdl_edit_cari_user" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yetkili Düzenle</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="editCariUserForm" method="post" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="type_title">Departman Seç</label>
                        <div class="form-control-wrap">
                            <select class="form-select init-select2" data-ui="xl" name="edit_department_id" id="edit_department_id">
                                <option value="0" selected disabled>Lütfen Seçiniz</option>

                                <option value="1">Firma Sahibi</option>
                                <option value="2">Muhasebe</option>
                                <option value="3">Satış</option>
                                <option value="4">Satınalma</option>

                            </select>
                        </div>
                    </div>

                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-12">
                            <label class="form-label" for="type_title">Ad Soyad</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="Yetkilinin Adı" id="edit_cari_user_name" name="edit_cari_user_name" required>
                            </div>
                        </div>

                    </div>

                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-12">
                            <label class="form-label" for="type_title">E-posta</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="Yetkilinin E-posta Adresi" id="edit_cari_user_email" name="edit_cari_user_email" required>
                            </div>
                        </div>

                    </div>

                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-9 col-xxl-9 col-9">
                            <label class="form-label" for="type_title">Telefonu</label>
                            <div class="form-control-wrap">
                                <div class="form-group">
                                <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-lg btn-block btn-dim btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                                                <span id="editlastAreaCode">seçiniz</span>
                                                <em class="icon mx-n1 ni ni-chevron-down"></em>
                                            </button>
                                            <div class="dropdown-menu">
                                                <select id="edit_cari_user_phone_area_code" name="area_code" class="form-select js-select2" data-ui="lg" data-search="on" data-placeholder="Seçiniz">
                                                    <option id="selecteditem" value="">Seçiniz</option>
                                                    <option value="+90">🇹🇷 (+90) Türkiye</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" name="edit_cari_user_phone" id="edit_cari_user_phone" aria-label="Carinin iletişim için telefon numarası" placeholder="000 000 0000" onkeypress="return SadeceRakam(event,['-'],'');">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xxl-3 col-3">
                            <label class="form-label" for="type_title">Dahili</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="000" required="" id="edit_cari_user_internal_number" name="edit_cari_user_internal_number" maxlength="4">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-dim btn-outline-light" data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <button type="button" id="editSaveCariUser" class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'cari_user',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Yetkili başarıyla oluşturuldu',
                'modal_buttons' => '<a href="' . route_to('tportal.cariler.user', $cari_item['cari_id']) . '" class="btn btn-primary btn-block mb-2">Yeni Yetkili Ekle</a>
                                    <a href="' . route_to('tportal.cariler.user', $cari_item['cari_id']) . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Tüm Yetkilileri Göster</a>'
            ],
        ],
    ]
); ?>

<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'edit_cari_user',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Yetkili başarıyla güncellendi',
                'modal_buttons' => '<a href="' . route_to('tportal.cariler.user', $cari_item['cari_id']) . '" class="btn btn-primary btn-block mb-2"">Yeni Yetkili Ekle</a>
                                    <a href="' . route_to('tportal.cariler.user', $cari_item['cari_id']) . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Tüm Yetkilileri Göster</a>'
            ],
        ],
    ]
); ?>


<?= $this->endSection() ?>

<?= $this->section('script') ?>


<script>
    // $("#cari_user_phone").mask("(000) 000 0000");
    // $("#edit_cari_user_phone").mask("(000) 000 0000");

    $(document).ready(function() {
        $("#area_code").select2({
            dropdownParent: $('#mdl_create_cari_user .modal-content')
        });

        $("#edit_cari_user_phone_area_code").select2({
            dropdownParent: $('#mdl_edit_cari_user .modal-content')
        });
    });


    $("#area_code").change(function() {
        var selectedVal = $(this).val();
        $("#lastAreaCode").text(selectedVal);
    });
    $("#edit_cari_user_phone_area_code").change(function() {
        var selectedVal = $(this).val();
        $("#editlastAreaCode").text(selectedVal);
    });

    $('#saveCariUser').click(function(e) {
        e.preventDefault();
        var formData = $('#createCariUserForm').serializeArray();
        console.log(formData);
        
        if ($('#department_id').val() == null || $('#cari_user_name').val() == '' || $('#cari_user_email').val() == '0' || $('#cari_user_phone').val() == '') {
            swetAlert("Eksik Bir Şeyler Var", "Lütfen tüm alanları doldurunuz! ", "err");
        } else {
            var formData = $('#createCariUserForm').serializeArray();
            console.log(formData);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.cariler.user_create', $cari_item['cari_id']) ?>',
                dataType: 'json',
                data: formData,
                async: true,
                success: function(response) {
                    if (response['icon'] == 'success') {
                        $("#trigger_cari_user_ok_button").click();
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
        }
    });

    // $(".money-mask").each(function(index) {
    //     $(".money-mask").mask("+00 (000) 000 0000");
    // });


    $(".editCariUser").each(function(index) {
        $(this).on("click", function() {

            var user_id = $(this).attr('user_id'),
                cari_user_name = $(this).attr('user'),
                cari_user_email = $(this).attr('user_email'),
                edit_user_phone_area_code = $(this).attr('user_phone_area_code'),
                cari_user_phone = $(this).attr('user_phone'),
                cari_user_internal_number = $(this).attr('user_internal_number'),
                department_id = $(this).attr('user_department');


            $('#edit_cari_user_name').val(cari_user_name);
            $('#edit_cari_user_email').val(cari_user_email);
            $('#edit_cari_user_phone_area_code').val(edit_user_phone_area_code);
            $('#edit_cari_user_phone').val(cari_user_phone);
            $('#edit_cari_user_internal_number').val(cari_user_internal_number);



            $('#edit_department_id').val(department_id);
            $('#edit_department_id').trigger('change');

            $('#edit_cari_user_phone_area_code').val(edit_user_phone_area_code);
            $('#edit_cari_user_phone_area_code').trigger('change');

            $('#editSaveCariUser').click(function(e) {
                e.preventDefault();
                if ($('#department_id') == null || $('#edit_cari_user_name').val() == '' || $('#edit_cari_user_email').val() == '0' || $('#edit_cari_user_phone').val() == '') {
                    swetAlert("Eksik Bir Şeyler Var", "Lütfen tüm alanları doldurunuz! ", "err");
                } else {
                    var formData = $('#editCariUserForm').serializeArray();
                    // console.log(formData);
                    formData.push({
                        name: 'cari_user_id',
                        value: user_id
                    });
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                        },
                        type: 'POST',
                        url: '<?= route_to('tportal.cariler.user_edit', $cari_item['cari_id']) ?>',
                        dataType: 'json',
                        data: formData,
                        async: true,
                        success: function(response) {
                            if (response['icon'] == 'success') {
                                $("#trigger_edit_cari_user_ok_button").click();
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
                }
            });
        })
    });

    $(".deleteCariUser").each(function(index) {
        $(this).on("click", function() {

            var user_id = $(this).attr('user_id');
            var cari_user_name = $(this).attr('user');

            Swal.fire({
                title: 'Yetkiliyi silmek üzeresiniz!',
                html: 'Silme işlemine devam etmek istiyor musunuz?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Devam Et',
                cancelButtonText: 'Hayır',
                allowEscapeKey: false,
                allowOutsideClick: false,

            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'İşleminiz gerçekleştiriliyor, lütfen bekleyiniz...',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    $.ajax({
                        type: 'POST',
                        url: '<?= route_to('tportal.cariler.user_delete', $cari_item['cari_id']) ?>',
                        data: "cari_user_id=" + user_id,
                        success: function(response, data) {
                            if (data === "success") {
                                Swal.fire({
                                        title: "İşlem Başarılı",
                                        html: '<b> ' + cari_user_name + '</b> yetkilisi başarıyla silindi.',

                                        confirmButtonText: "Tamam",
                                        allowEscapeKey: false,
                                        allowOutsideClick: false,
                                        icon: "success",
                                    })
                                    .then(function() {
                                        window.location.reload();
                                    });

                            } else {

                                Swal.fire({
                                    title: "İşlem Başarısız",
                                    text: data,
                                    confirmButtonText: "Tamam",
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    icon: "error",

                                })
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                            Swal.fire({
                                title: "Bir hata oluştu",
                                text: "sistemsel bir hata. daha sonra tekrar deneyiniz.",
                                confirmButtonText: "Tamam",
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                icon: "error",
                            })
                        },
                    });

                } else if (result.isCancel) {
                    Swal.fire('Değişiklikler kaydedilmedi', '', 'info')
                }
            })

        });
    });
</script>

<?= $this->endSection() ?>