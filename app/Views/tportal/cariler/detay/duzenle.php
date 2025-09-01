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
                                        <h4 class="nk-block-title">Cari Düzenle</h4>

                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <form onsubmit="return false;" id="editCari" method="post">
                                    <div class="card-inner position-relative card-tools-toggle p-0">
                                        <div class="gy-2">
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="site-name">Cari Tipi</label><span class="form-note d-none d-md-block">Ürünün ait olduğu
                                                            tipi.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <ul class="custom-control-group">
                                                        <li>
                                                            <div class="custom-control custom-control-sm custom-checkbox custom-control-pro">
                                                                <input type="checkbox" <?php if ($cari_item['is_customer']) {
                                                                                            echo "checked";
                                                                                        } ?> class="custom-control-input" name="is_customer" id="is_customer">
                                                                <label class="custom-control-label" for="is_customer">
                                                                    <em class="icon ni ni-user"></em>
                                                                    <span>Müşteri</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-control-sm custom-checkbox custom-control-pro">
                                                                <input type="checkbox" class="custom-control-input" <?php if ($cari_item['is_supplier']) {
                                                                                                                        echo "checked";
                                                                                                                    } ?> name="is_supplier" id="is_supplier">
                                                                <label class="custom-control-label" for="is_supplier">
                                                                    <em class="icon ni ni-truck"></em>
                                                                    <span>Tedarikçi</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="is_export_customer">İhracat Müşterisi</label><span class="form-note d-none d-md-block">Eğer bu müşteri ihracat
                                                            müşteriniz ise işaretleyiniz..</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <ul class="custom-control-group">
                                                        <li>
                                                            <div class="custom-control custom-control-sm custom-checkbox custom-control-pro">
                                                                <input type="checkbox" disabled class="custom-control-input" <?php if ($cari_item['is_export_customer']) {
                                                                                                                                    echo "checked";
                                                                                                                                } ?> name="is_export_customer" id="is_export_customer">
                                                                <label class="custom-control-label" for="is_export_customer">
                                                                    Evet
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="identification_number">T.C./Vergi No</label><span class="form-note d-none d-md-block">Bu bilgiyi doğru girip
                                                            sorgularsanız ünvan ve vergi dairesi gibi bilgiler otomatik
                                                            gelecektir.</span></div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-lg" id="identification_number" placeholder="T.C. veya Vergi No Giriniz.." value="<?= $cari_item['identification_number'] == 0 ? "" : $cari_item['identification_number'] ?>" name="identification_number" maxlength="11">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="obligation">Mükellefiyet</label><span class="form-note d-none d-md-block">Carinin mükellefiyet
                                                            durumu.</span></div>
                                                </div>
                                                <div class="col-lg-4 col-xxl-4  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <select class="form-select js-select2" id="obligation" name="obligation" data-ui="lg" data-placeholder="Mükellefiyet Seçiniz">
                                                            <option></option>
                                                            <option value="e-archive" <?php if ($cari_item['obligation'] == 'e-archive') {
                                                                                            echo "selected";
                                                                                        } ?>>
                                                                E-Arşiv Fatura</option>
                                                            <option value="e-invoice" <?php if ($cari_item['obligation'] == 'e-invoice') {
                                                                                            echo "selected";
                                                                                        } ?>>
                                                                E-Fatura</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-xxl-3  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <select class="form-select js-select2" id="company_type" name="company_type" data-ui="lg" data-placeholder="Şirket Tipi Seçiniz">
                                                            <option></option>
                                                            <option value="person" <?php if ($cari_item['company_type'] == 'person') {
                                                                                        echo "selected";
                                                                                    } ?>>
                                                                Şahıs</option>
                                                            <option value="company" <?php if ($cari_item['company_type'] == 'company') {
                                                                                        echo "selected";
                                                                                    } ?>>
                                                                Şirket</option>
                                                            <option value="public" <?php if ($cari_item['company_type'] == 'public') {
                                                                                        echo "selected";
                                                                                    } ?>>
                                                                Kamu</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>




                                                <div class="row g-3 align-center" id="namesurname">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group">
                                                            <label class="form-label" for="">Adı Soyadı</label><span class="form-note d-none d-md-block">Fatura kesilecek resmi
                                                                ünvan.<br>Şirket ise ünvan gelir, değil ise ad soyad.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-lg" id="name" name="name" value="<?= $cari_item['name'] ?>" placeholder="Adı">
                                                        </div>
                                                    </div>
                                                    <div class="col mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-lg" id="surname" name="surname" value="<?= $cari_item['surname'] ?>" placeholder="Soyadı">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label" for="invoice_title">Fatura
                                                                Ünvanı</label><span class="form-note d-none d-md-block">Fatura kesilecek resmi
                                                                ünvan.<br>Şirket ise ünvan gelir, değil ise ad soyad.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" id="invoice_title" name="invoice_title" value="<?= $cari_item['invoice_title'] ?>" placeholder="Cari Ünvanı">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>





                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="tax_administration">Vergi Dairesi</label><span class="form-note d-none d-md-block">Fatura kesilecek resmi vergi dairesi.</span></div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" id="tax_administration" name="tax_administration" value="<?= $cari_item['tax_administration'] ?>" placeholder="Vergi Dairesi Müd."></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="cari_email">E-posta</label><span class="form-note d-none d-md-block">Carinin faturalarının gönderileceği e-posta adresi.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input name="cari_email" type="text" class="form-control form-control-lg" id="cari_email" value="<?= $cari_item['cari_email'] ?>" placeholder="e-posta@mail.com"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="cari_phone">Telefon</label><span class="form-note d-none d-md-block">Carinin iletişim için telefon numarası</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-lg btn-block btn-dim btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                                                                    <span id="lastAreaCode">+90</span>
                                                                    <em class="icon mx-n1 ni ni-chevron-down"></em>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <select id="area_code" name="area_code" class="form-select js-select2" data-ui="lg" data-search="on" data-placeholder="Seçiniz">
                                                                        <option id="selecteditem" value="">+90</option>
                                                                        <option value="+90" selected>🇹🇷 (+90) Türkiye</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <input type="text" class="form-control form-control-lg" name="cari_phone" id="cari_phone" aria-label="Text input with dropdown button" placeholder="000 000 00 00" value="" maxlength="10">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="ddl_parabirimi">Para Birimi</label><span class="form-note d-none d-md-block">Cari ile çalışmak
                                                            istediğiniz para birimi.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <select id="money_unit_id" name="money_unit_id" class="form-select js-select2" data-ui="lg" data-search="on" data-val="TRY">
                                                            <?php foreach ($money_unit_items as $money_unit_item) { ?>
                                                                <option value="<?= $money_unit_item['money_unit_id'] ?>" <?php if ($cari_item['money_unit_id'] == $money_unit_item['money_unit_id']) {
                                                                                                                                echo "selected";
                                                                                                                            } ?>>
                                                                    <?= $money_unit_item['money_code'] ?> -
                                                                    <?= $money_unit_item['money_title'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="cari_note">Cari Notu</label><span class="form-note d-none d-md-block">Bu cari için eklemek istediğiniz bir not varsa yazınız.</span></div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-lg" name="cari_note" id="cari_note" rows="1" placeholder="Cari Notu"><?= $cari_item['cari_note'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div><!-- .card-inner -->
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <!-- <a href="javascript:history.back()" class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Geri</span></a>  -->
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <div class="form-group">
                                                    <button type="submit" id="saveCari" class="btn btn-lg btn-primary">Kaydet</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                </form>
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

<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'edit_cari',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Cari bilgileri başarıyla güncellendi',
                'modal_buttons' => '<a href="' . route_to('tportal.cariler.detail', $cari_item['cari_id']) . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Cari Bilgilerini Göster</a>'
            ],
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>


    $(document).ready(function() {


        basePhone = "<?= $cari_item['cari_phone'] ?>";
        splitPhone = basePhone.split(" ");
        cari_phone_area_code = splitPhone[0];
        cari_phone = splitPhone[1];

        if (cari_phone_area_code != '') {
            $("#lastAreaCode").text(cari_phone_area_code);

            $('#area_code').val(cari_phone_area_code);
            $('#area_code').trigger('change');

            $('#cari_phone').val(cari_phone);
        }

        $("#area_code").change(function() {
            var selectedVal = $(this).val();
            $("#lastAreaCode").text(selectedVal);
        });

        $("#cari_phone").mask("(000) 000 0000");
    });

    $('#saveCari').click(function(e) {
        e.preventDefault();
        if (($('#invoice_title').val() == '') && ($('#name').val() == '' || $('#surname').val() == '') || ($('#area_code').val() == '' || $('#cari_phone').val() == '' || $('#address').val() == '')) {
            Swal.fire({
                title: "Uyarı!",
                html: 'Lütfen aşağıdaki alanlardan doldurunuz. <br><br> <ul><li>Fatura Ünvanı veya Adı Soyadı</li> <li>Fatura Adres Bilgisi</li> <li>Telefon Bilgisi</li> </ul>',
                icon: "warning",
                confirmButtonText: 'Tamam',
            });
        } else {
            var formData = $('#editCari').serializeArray();
            console.log(formData);
            formData.push({
                name: 'vkn_tc',
                value: $('#identification_number').val()
            });

            Swal.fire({
                title: 'İşleminiz yapılıyor, lütfen bekleyiniz...',
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
                url: '<?= route_to('tportal.cariler.edit', $cari_item['cari_id']) ?>',
                dataType: 'json',
                data: formData,
                async: true,
                success: function(response) {
                    if (response['icon'] == 'success') {
                        $("#trigger_edit_cari_ok_button").click();
                        swal.close();
                    } else {
                        swetAlert("Bir Şeyler Ters Gitti", response["message"], "err");
                    }
                }
            })
        }
    });
</script>

<?= $this->endSection() ?>