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
                                        <h5>Kullanıcı Yönetimi</h5>
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
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                        </div>
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#add_user" id="btn_add_user_modal">Kullanıcı
                                                            Ekle</button>
                                                    </div>
                                                </div>
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
                                <table class="table table-tranx is-compact">
                                    <thead class="bg-light bg-opacity-75">
                                        <tr class="tb-tnx-head">
                                            <th class="tb-tnx-id">
                                                <span class="">#</span>
                                            </th>
                                            <th class="nk-tb-col"><span class="sub-text">OLUŞTURMA TARİHİ </span></th>
                                            <th class="nk-tb-col"><span class="sub-text">KULLANICI EPOSTA </span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">KULLANICI AD SOYAD</span></th>
                                            <th class="nk-tb-col tb-col-md" data-orderable="false"
                                                style="min-width:120px"><span class="sub-text">FİRMA ADI</span></th>
                                            <th class="nk-tb-col tb-col-md" data-orderable="false"
                                                style="min-width:80px"><span class="sub-text">DURUM</span></th>
                                            <th class="nk-tb-col tb-col-md" data-orderable="false"
                                                style="min-width:40px"><span class="sub-text">...</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $sira = 1;

                                        if (count($user_list) > 0) {
                                            foreach ($user_list as $item) {

                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= $sira ?>
                                                    </td>
                                                    <td data-order="<?= $item['created_at'] ?>"
                                                        title="<?= $item['created_at'] ?>">
                                                        <?= date("d/m/Y", strtotime($item['created_at'])) ?>
                                                    </td>
                                                    <td>
                                                        <!-- data.sale_type  == "quick" ? "#PROFORMA" : ( data.is_quick_sale_receipt == 1 && data.invoice_direction == 'outgoing_invoice' ? 'Hızlı Satış Fişi' : data.invoice_no) -->

                                                        <?=
                                                            $item['user_eposta'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <span class="tb-lead">
                                                            <?= $item['user_adsoyad'] != null ? $item['user_adsoyad'] : '-' ?>
                                                    </td>
                                                    <td>
                                                        <?= $item['firma_adi'] ?? '-' ?>
                                                    </td>
                                                    <td>
                                                        <?= $item['status'] == 'active' ? '<span class="text-success">AKTİF</span>' : '<span class="text-danger">PASİF</span>' ?>
                                                    </td>
                                                    <td>
                                                        <!-- <a class="btn btn-icon btn-xs btn-dim btn-outline-dark"
                                                            id="btnPrintBarcode" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" data-bs-title="Kullanıcıyı Düzenle"><em
                                                                class="icon ni ni-arrow-right"></em></a> -->

                                                        <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#mdl_edit_user" id=""
                                                            user_id="<?= $item['user_id'] ?>"
                                                            client_id="<?= $item['client_id'] ?>"
                                                            user_email="<?= $item['user_eposta'] ?>"
                                                            operation_user="<?= $item['operation'] ?>"
                                                            user_phone="<?= $item['user_telefon'] ?>"
                                                            user_namesurname="<?= $item['user_adsoyad'] ?>"
                                                            user_company="<?= $item['firma_adi'] ?>"
                                                            user_pin="<?= $item['pin'] ?>"
                                                            user_pass="<?= $item['user_password'] ?>"
                                                            user_status="<?= $item['status'] ?>"
                                                            class="btn btn-icon btn-xs btn-dim btn-outline-dark editUser"><em
                                                                class="icon ni ni-pen-alt-fill"></em></button>
                                                        <input type="hidden" id="client_id" value="<?= $item['client_id'] ?>">
                                                    </td>

                                                </tr>
                                                <?php $sira++;
                                            }
                                        } else {
                                            echo '<tr><td class="text-center" colspan="6"> Henüz alt kullanıcı eklenmedi </td></tr>';
                                        }




                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div><!-- .card-inner-group -->
                </div><!-- .card -->

                <div class="modal fade" tabindex="-1" id="add_user">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Kullanıcı Oluştur</h5>
                                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <em class="icon ni ni-cross"></em>
                                </a>
                            </div>
                            <div class="modal-body bg-white">
                                <form id="createSubUserModal" class="form-validate is-alter">

                                    <div class="row mb-3 g-3 align-center">
                                        <div class="col-lg-6 col-xxl-6 ">
                                            <div class="form-group">
                                                <label class="form-label" for="firma_adi">Firma Adı</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl"
                                                        placeholder="Firma Adı" id="firma_adi" name="firma_adi"
                                                        value="<?= session()->get("user_item")['firma_adi'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-xxl-6 ">
                                            <div class="form-group">
                                                <label class="form-label" for="user_adsoyad">Kullanıcı Adı
                                                    Soyadı</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl"
                                                        placeholder="Adı Soyadı" id="user_adsoyad" name="user_adsoyad">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-xxl-6 ">
                                            <div class="form-group">
                                                <label class="form-label" for="user_telefon">Kullanıcı Telefon
                                                    Numarası</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl"
                                                        placeholder="Telefon Numarası" id="user_telefon"
                                                        name="user_telefon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-xxl-6 ">
                                            <div class="form-group">
                                                <label class="form-label" for="user_eposta">Kullanıcı
                                                    E-posta</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl"
                                                        placeholder="E-posta adresi" id="user_eposta"
                                                        name="user_eposta">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xxl-12 ">
                                            <label class="form-label" for="edit_user_password">Kullanıcı Pin Şifresi
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="input-group"><input type="text" class="form-control"
                                                        placeholder="Kullanıcı Pin Şifresi" id="user_pin"
                                                        name="user_pin>">
                                                    <div class="input-group-append"><button type="button"
                                                            class="btn btn-outline-primary btn-dim"
                                                                id="btnCreatePin">Pin Şifresi
                                                            Oluştur</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-6 col-xxl-6 ">
                                            <div class="form-group">
                                                <label class="form-label" for="user_password">Kullanıcı Şifre</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl"
                                                        placeholder="Kullanıcı şifre" id="user_password"
                                                        name="user_password">
                                                    <span class="sub-text">Şifre en az 8 karakter olmalıdır.</span>
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="col-lg-6 col-xxl-6 ">
                                            <div class="form-group">
                                                <label class="form-label" for="password_check">Şifre
                                                    Doğrula</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl"
                                                        placeholder="Kullanıcı şifre" id="password_check"
                                                        name="password_check">
                                                    <span class="sub-text">Belirlediğiniz şifreyi yeniden
                                                        giriniz.</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xxl-12 ">
                                        <div class="form-group">
                                                <label class="form-label mt-2 mb-0 " for="slct_birim_0">Operasyon</label>
                                                <div class="form-control-wrap str_kaldir">
                                                    <select class="form-select js-select2 form-control  form-control-xl" data-search="on" id="operation_id" satir="0" data-placeholder="Seçiniz">
                                                        <option value="0">Sistem Kullanıcısı</option>
                                                        <?php foreach($modelOperation as $operation): ?>
                                                                    <option value="<?php echo $operation->operation_id; ?>"><?php echo $operation->operation_title; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                </form>
                                <hr>
                                <div style="float:right;">
                                    <button type="button" id="btnCreatePassword" class="btn btn-secondary"><em
                                            class="icon ni ni-regen-alt"></em> <span>Şifre
                                            Oluştur</span></button>
                                    <button type="button" id="btnCopyPassword" class="btn btn-dim btn-secondary"><em
                                            class="icon ni ni-copy-fill"></em> <span>Şifreyi
                                            Kopyala</span></button>
                                </div>
                            </div>
                            <div class="modal-footer d-block p-3 bg-white">
                                <div class="row">
                                    <div class="col-md-4 p-0">
                                        <button type="button" class="btn  btn-dim btn-outline-light"
                                            data-bs-dismiss="modal">Kapat</button>
                                    </div>
                                    <div class="col-md-8 text-end p-0">
                                        <button type="button" id="btnCreateSubUser" class="btn btn-primary">Kullanıcıyı
                                            Oluştur</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Edit User Modal -->
                <div id="mdl_edit_user" class="modal fade" role="dialog" aria-labelledby="mdl_edit_user"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Kullanıcı Düzenle</h5>
                                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <em class="icon ni ni-cross"></em>
                                </a>
                            </div>
                            <div class="modal-body bg-white">

                                <form id="editUserForm" class="form-validate is-alter">

                                    <div class="row mb-3 g-3 align-center">
                                        <div class="col-lg-6 col-xxl-6 ">
                                            <div class="form-group">
                                                <label class="form-label" for="edit_firma_adi">Firma Adı</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl"
                                                        placeholder="Firma Adı" id="edit_firma_adi"
                                                        name="edit_firma_adi">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-xxl-6 ">
                                            <div class="form-group">
                                                <label class="form-label" for="edit_user_adsoyad">Kullanıcı Adı
                                                    Soyadı</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl"
                                                        placeholder="Adı Soyadı" id="edit_user_adsoyad"
                                                        name="edit_user_adsoyad">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-xxl-6 ">
                                            <div class="form-group">
                                                <label class="form-label" for="edit_user_telefon">Kullanıcı Telefon
                                                    Numarası</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl"
                                                        placeholder="Telefon Numarası" readonly id="edit_user_telefon"
                                                        name="edit_user_telefon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-xxl-6 ">
                                            <div class="form-group">
                                                <label class="form-label" for="edit_user_eposta">Kullanıcı
                                                    E-posta</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl"
                                                        placeholder="E-posta adresi" id="edit_user_eposta"
                                                        name="edit_user_eposta">
                                                </div>
                                            </div>
                                        </div>
                                      


                                         
                                        <div class="col-lg-12 col-xxl-12 ">
                                            <label class="form-label" for="edit_user_password">Kullanıcı Pin Şifresi
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="input-group"><input type="text" class="form-control"
                                                        placeholder="Kullanıcı Pin Şifresi" id="edit_user_pin"
                                                        name="edit_user_pin">
                                                    <div class="input-group-append"><button type="button"
                                                            class="btn btn-outline-primary btn-dim"
                                                            id="btnCreatePin">Pin Şifresi
                                                            Oluştur</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="form-group">
                                                <label class="form-label" for="edit_user_password">Kullanıcı Şifre
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl"
                                                        placeholder="Kullanıcı şifre" id="edit_user_password"
                                                        name="edit_user_password">
                                                </div>
                                            </div> -->
                                        </div>

                                        
                                        <div class="col-lg-12 col-xxl-12 ">
                                            <label class="form-label" for="edit_user_password">Kullanıcı Şifre
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="input-group"><input type="text" class="form-control"
                                                        placeholder="Kullanıcı şifre" id="edit_user_password"
                                                        name="edit_user_password">
                                                    <div class="input-group-append"><button type="button"
                                                            class="btn btn-outline-primary btn-dim"
                                                            id="btnCreatePassword">Şifre
                                                            Oluştur</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="form-group">
                                                <label class="form-label" for="edit_user_password">Kullanıcı Şifre
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl"
                                                        placeholder="Kullanıcı şifre" id="edit_user_password"
                                                        name="edit_user_password">
                                                </div>
                                            </div> -->
                                        </div>

                                        <div class="col-lg-12 col-xxl-12 ">
                                        <div class="form-group">
                                                <label class="form-label mt-2 mb-0 " for="slct_birim_0">Operasyon</label>
                                                <div class="form-control-wrap str_kaldir">
                                                    <select class="form-select  form-control  form-control-xl" data-search="on" name="operation_update" id="operation_update" satir="0" data-placeholder="Seçiniz">
                                                        <option value="0">Sistem Kullanıcısı</option>
                                                        <?php foreach($modelOperation as $operation): ?>
                                                                    <option  <?php if(session()->get("user_item")["operation"] ==  $operation->operation_id ) { echo 'selected';  } ?> value="<?php echo $operation->operation_id; ?>"><?php echo $operation->operation_title; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>


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
                                                                data_module_title="<?= $item['module_title']; ?>"
                                                                data_module="<?= $item['module_id']; ?>">

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

                                    <hr>
                                    <div class="mt-3">
                                        <h6 class="title mb-3">Kullanıcı Durumu</h6>

                                        <div class="g-4 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio checked"><input type="radio"
                                                        id="activeRadio" name="statusRadio" class="custom-control-input"
                                                        value="active"><label class="custom-control-label"
                                                        for="activeRadio">Aktif Hale Getir</label>
                                                </div>
                                            </div>
                                            <div class="g">
                                                <div class="custom-control custom-radio checked"><input type="radio"
                                                        id="passiveRadio" name="statusRadio"
                                                        class="custom-control-input" value="passive"><label
                                                        class="custom-control-label" for="passiveRadio">Pasif Hale
                                                        Getir</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </form>
                            </div>
                            <div class="modal-footer d-block p-3 bg-white">
                                <div class="row">
                                    <div class="col-md-4 p-0">
                                        <button type="button" class="btn btn-dim btn-outline-light"
                                            data-bs-dismiss="modal">KAPAT</button>
                                    </div>
                                    <div class="col-md-8 text-end p-0">
                                        <button type="button" id="deleteUser" class="btn btn-dim btn-danger">KULLANICIYI
                                            SİL</button>
                                        <button type="button" id="editSaveUser" class="btn btn-success">KAYDET</button>
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

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    $(document).ready(function () {


        function selectOptionByValue(selectId, valueToSelect) {
        // Select öğesini bul
        var selectElement = document.getElementById(selectId);
        
        // Select öğesi içindeki tüm option öğelerini dolaş
        for(var i = 0; i < selectElement.options.length; i++) {
            if(selectElement.options[i].value == valueToSelect) {
                selectElement.selectedIndex = i; // Eşleşen option öğesini seç
                break;
            }
        }
    }

        $("#user_telefon").mask("(000) 000 0000");


        $(document).on("click", "#btn_add_user_modal", function () {
            $('#user_password').val('');
            $('#password_check').val('');
        });

        function genPass() {
            var password = "";
            var characters = "0123456789@ABCDEFGHJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
            var long = "8";
            for (var i = 0; i < long; i++) {
                gen = characters.charAt(Math.floor(Math.random() * characters.length));
                password += gen;
            }
            document.getElementById('user_password').value = password;
            document.getElementById('password_check').value = password;
            document.getElementById('edit_user_password').value = password;
        }

        function genPin() {
            var password = "";
            var characters = "0123456789";
            var long = "4";
            for (var i = 0; i < long; i++) {
                gen = characters.charAt(Math.floor(Math.random() * characters.length));
                password += gen;
            }
            document.getElementById('user_pin').value = password;
            document.getElementById('edit_user_pin').value = password;
        }


        function copy() {
            var copyText = document.getElementById("user_password");
            copyText.setSelectionRange(0, 9999);
            navigator.clipboard.writeText(copyText.value);

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: 'success',
                title: 'kopyalandı',
            });
        }

        function copyUserInfo() {
            var copyMail = document.getElementById("edit_user_eposta");
            var copyPass = document.getElementById("edit_user_password");
            var copied = "email: " + copyMail.value + " şifre: " + copyPass.value;
            // copied.setSelectionRange(0, 9999);
            navigator.clipboard.writeText(copied);

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: 'success',
                title: 'kopyalandı',
            });
        }

        function refFunc() {
            swal.close();
            location.reload();
        }


        $(document).on("click", "#btnCreatePassword", function () {
            genPass();
        });

        $(document).on("click", "#btnCreatePin", function () {
            genPin();
        });

        $(document).on("click", "#btnCopyPassword", function () {
            copy();
        });
        $(document).on("click", "#btnCopyUserInfo", function () {
            copyUserInfo();
            $('#mdl_edit_user').modal('hide');
            // $('#modal').modal('toggle');
        });
        $(document).on("click", "#btnRef", function () {
            console.log("tiklandii");
            refFunc();
        });

        $(document).on("click", "#btnCreateSubUser", function () {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.auth.checkRegister') ?>',
                dataType: 'json',
                data: {
                    user_eposta: $('#user_eposta').val(),
                    user_phone: $('#user_telefon').val().replace(/\s+/g, ""),
                    user_adsoyad: $('#user_adsoyad').val(),
                    firma_adi: $('#firma_adi').val(),
                    operation_id: $('#operation_id').val(),
                    user_password: $('#user_password').val(),
                    password_check: $('#password_check').val(),
                    user_pin: $('#user_pin').val(),
                },
                async: true,
                success: function (response) {
                    if (response['icon'] == 'success') {

                        Swal.fire({
                            title: 'Başarılı!',
                            html: "Kullanıcı başarıyla oluşturuldu.",
                            icon: "success",
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then(function () {
                            location.reload();
                        });
                    } else {

                        Swal.fire({
                            title: 'Hata!',
                            html: response['message'],
                            icon: 'warning',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        return false;
                    }
                }
            })
        });


        $(document).on("click", "#deleteUser", function () {

            client_id = $('#client_id').val();
            Swal.fire({
                title: 'Kullanıcıyı silmek üzeresiniz!',
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
                        url: '<?= route_to('tportal.ayarlar.kullanici.sil') ?>',
                        data: {
                            client_id: client_id,
                        },
                        success: function (response, data) {
                            if (data === "success") {
                                var fd = JSON.parse(response);
                                Swal.fire({
                                    title: "İşlem Başarılı",
                                    html: fd.message,
                                    confirmButtonText: "Tamam",
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    icon: "success",
                                })
                                    .then(function () {
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
                        error: function (xhr, status, error) {
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

     

        $(".editUser").each(function (index) {

            $(".checkUserModule").prop("checked", false);

            // $("#user_telefon").mask("(000) 000 0000");
            // $("#edit_user_telefon").mask("(000) 000 0000");

            $(this).on("click", function () {

                var user_id = $(this).attr('user_id'),
                    client_id = $(this).attr('client_id'),
                    user_email = $(this).attr('user_email'),
                    user_phone = $(this).attr('user_phone').replace(/\s+/g, ""),
                    user_namesurname = $(this).attr('user_namesurname'),
                    user_company = $(this).attr('user_company'),
                    user_status = $(this).attr('user_status'),
                    user_pass = $(this).attr('user_pass'),
                    user_pin = $(this).attr('user_pin'),
                    operation_user = $(this).attr('operation_user');
                    selectOptionByValue('operation_update', operation_user);
                // check_password = Hash::check($data['user_password'], $user_item['user_password']);


                $('#edit_user_eposta').val(user_email);
                $('#edit_user_telefon').val(user_phone).unmask().mask("(000) 000 0000");
                $('#edit_user_adsoyad').val(user_namesurname);
                $('#edit_firma_adi').val(user_company);
                $('#edit_user_pin').val(user_pin);


                $('#user_id').val(user_id);
                $('#client_id').val(client_id);

                if (user_status == 'active') {
                    $('#activeRadio').prop("checked", true);
                } else {
                    $('#passiveRadio').prop("checked", true);
                }

                var temp_client_str = '';

                var list = [];
                var permission_list_c = [];
                var permission_list_u = [];

                list.push({
                    name: "client_id",
                    value: client_id,
                });
                list.push({
                    name: "user_id",
                    value: user_id,
                });

                $(".checkUserModule").each(function (index, element) {
                    var module_id = $(this).attr('data_module');
                    var temp_str = "checkUserModule_" + module_id;


                    temp_client_str = client_id + '_checkUserModule_' + $(element).attr("data_module");

                    $(this).attr('id', temp_client_str);
                    $(this).attr('client_id', client_id);

                    $("#" + temp_client_str).next('label').attr("for", temp_client_str);
                });



                $(".checkUserModule").prop("checked", false);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= route_to('tportal.ayarlar.yetkiler.get') ?>',
                    dataType: 'json',
                    data: {
                        user_id: user_id,
                        client_id: client_id,
                        pass: user_pass,
                    },
                    async: true,
                    success: function (response) {

                        if (response.icon == 'success') {
                            $(response.response).each(function (index, element) {
                                $('#edit_user_password').val(element.pass);

                                var temp_str = $(element).attr("client_id") + "_checkUserModule_" + $(element).attr("module_id");

                                if ($("input[id='" + temp_str + "']")) {
                                    $("#" + temp_str).prop("checked", true);
                                } else {
                                    $("#" + temp_str).prop("checked", false);
                                }
                            });
                        } else {
                            swetAlert("Hatalı İşlem", response['message'], "err");
                        }
                    }
                });


            })
        });
    });



    $(document).on("click", "#editSaveUser", function () {
        var user_id = 4;
        var client_id = $('#client_id').val();
        console.log(user_id, client_id);
var list = [];
var permission_list_c = [];
var permission_list_u = [];

$("input[client_id='" + client_id + "']").each(function (index, element) {
    var module_title = $(element).attr('data_module_title');
    var module_id = $(element).attr('data_module');

    if ($(element).is(':checked')) {
        if (module_id !== undefined) {
            permission_list_c.push({
                name: module_title,
                value: module_id,
            });
        }
    } else {
        if (module_id !== undefined) {
            permission_list_u.push({
                name: module_title,
                value: module_id,
            });
        }
    }
});


list.push({
    name: "permission_list_c",
    value: permission_list_c
});
list.push({
    name: "permission_list_u",
    value: permission_list_u
});

if ($('#edit_firma_adi') == null || $('#edit_user_adsoyad').val() == '' || $('#edit_user_eposta').val() == '' ) {
    swetAlert("Eksik Bir Şeyler Var", "Lütfen tüm alanları doldurunuz! ", "err");
} else {
    var formData = $('#editUserForm').serializeArray();
    console.log(formData);
    formData.push({
        name: 'user_id',
        value: user_id,
    });
    formData.push({
        name: 'client_id',
        value: client_id,
    });
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.ayarlar.kullanici.duzenle') ?>',
        dataType: 'json',
        data: {
            formData: formData,
            list: list,
        },
        async: true,
        success: function (response) {
            if (response['icon'] == 'success') {
                if (response['changeUserEposta'] == 1 || response['changePassword'] == 1) {
                    Swal.fire({
                        icon: "success",
                        title: 'Başarılı!',
                        html: "E-posta: " + $('#edit_user_eposta').val() + " <br> Şifre: " + $('#edit_user_password').val() + " <br> kullanıcı bilgileri başarıyla güncellendi.",


                        html: "E-posta: " + $('#edit_user_eposta').val() + " <br> Şifre: " + $('#edit_user_password').val() + " <br> kullanıcı bilgileri başarıyla güncellendi." +
                            "<br><br>" +
                            '<button class="btn btn-success me-2" id="btnRef">' + 'Tamam' + '</button>' +
                            '<button class="btn btn-dim btn-outline-light" id="btnCopyUserInfo">' + 'Bilgileri Kopyala' + '</button>',
                        showCancelButton: false,
                        showConfirmButton: false,

                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        // footer: '<a class="text-primary" id="btnCopyUserInfo">Bilgileri Kopyala</button>',
                    }).then(function () {
                        location.reload();
                    });
                } else if(response['changeUserStatus'] == 1) {
                    Swal.fire({
                        title: 'Başarılı!',
                        html: "Kullanıcı durumu başarıyla güncellendi.",
                        icon: "success",
                        confirmButtonText: 'Tamam',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Başarılı!',
                        html: "Modül yetkileri başarıyla güncellendi.",
                        icon: "success",
                        confirmButtonText: 'Tamam',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then(function () {
                        location.reload();
                    });
                }

            } else {
                return false;
            }
        }
    });
}
});
</script>

<?= $this->endSection() ?>