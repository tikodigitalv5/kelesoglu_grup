<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Yeni Hesap <?= $this->endSection() ?>
<?= $this->section('title') ?> Yeni Hesap | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>



<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content  d-xl-none">
                        <h3 class="nk-block-title page-title">Yeni Hesap</h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">

                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->

            <div class="nk-block">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card card-stretch">
                            <div class="card-inner-group">
                                <form onsubmit="return false;" id="createFinancialAccountForm" method="post">
                                    <div class="card-inner position-relative card-tools-toggle">
                                        <div class="gy-2">
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 ">
                                                    <div class="form-group"><label class="form-label" for="site-name">Hesap Tipi</label><span class="form-note d-none d-md-block">Hesabın ait olduğu
                                                            tipi.</span></div>
                                                </div>
                                                <div class="col  mt-0 mt-md-2">
                                                    <ul class="custom-control-group">
                                                        <li>
                                                            <div class="custom-control custom-control-sm custom-radio custom-control-pro account_type">
                                                                <input type="radio" class="custom-control-input" name="account_type" id="account_type_vault" value="vault" checked required>
                                                                <label class="custom-control-label" for="account_type_vault">
                                                                    <span>Kasa</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-control-sm custom-radio custom-control-pro account_type">
                                                                <input type="radio" class="custom-control-input" name="account_type" id="account_type_bank" value="bank" required>
                                                                <label class="custom-control-label" for="account_type_bank">
                                                                    <span>Banka</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-control-sm custom-radio custom-control-pro account_type">
                                                                <input type="radio" class="custom-control-input" name="account_type" id="account_type_credit_card" value="credit_card" required>
                                                                <label class="custom-control-label" for="account_type_credit_card">
                                                                    <span>Kredi Kartı</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-control-sm custom-radio custom-control-pro account_type">
                                                                <input type="radio" class="custom-control-input" name="account_type" id="account_type_pos" value="pos" required>
                                                                <label class="custom-control-label" for="account_type_pos">
                                                                    <span>POS</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li >
                                                            <div class="custom-control custom-control-sm custom-radio custom-control-pro account_type">
                                                                <input type="radio" class="custom-control-input" name="account_type" id="account_type_cek_senet" value="check_bill" required>
                                                                <label class="custom-control-label" for="account_type_cek_senet">
                                                                    <span>Çek/Senet</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 ">
                                                    <div class="form-group"><label class="form-label" for="account_title">Hesap Adı</label>
                                                        <span class="form-note d-none d-md-block">Seçerken kolaylık sağlayacak bir ad.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control form-control-lg" name="account_title" id="account_title" value="" placeholder="ENPARA ŞİRKETİM vb.">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="money_unit_id">Para Birimi</label>
                                                        <span class="form-note d-none d-md-block">Cari ile çalışmak istediğiniz para birimi.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <select id="money_unit_id" name="money_unit_id" class="form-select js-select2" data-placeholder="Lütfen Seçiniz">
                                                            <!-- foreach money_unit_items -->
                                                            <option></option>
                                                            <?php if (isset($money_unit_items)) {
                                                                foreach ($money_unit_items as $money_unit) { ?>
                                                                    <option value="<?= $money_unit['money_unit_id'] ?>">(<?= $money_unit['money_code'] ?>) <?= $money_unit['money_title'] ?></option>

                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-none gy-2" id="without_vault">
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 ">
                                                        <div class="form-group"><label class="form-label" for="bank_id">Banka</label>
                                                            <span class="form-note d-none d-md-block">Hesabın ait olduğu bankayı seçiniz.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <select id="bank_id" name="bank_id" class="form-select js-select2" data-placeholder="Lütfen Seçiniz">
                                                                <!-- foreach bank_items -->
                                                                <option name="" id="" value="0" selected disabled>Lütfen Seçiniz</option>
                                                                <?php $all_bank = session()->get('bank_items');
                                                                foreach ($all_bank as $bank_item) { ?>
                                                                    <option value="<?= $bank_item['bank_id'] ?>">
                                                                        <?= $bank_item['bank_title'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 ">
                                                        <div class="form-group"><label class="form-label" for="bank_iban">IBAN</label><span class="form-note d-none d-md-block">Banka iban bilgilsi.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" name="bank_iban" id="bank_iban" value="" placeholder="TR00 0000 0000 0000 0000 0000 00"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 ">
                                                        <div class="form-group"><label class="form-label" for="bank_branch">Banka Şube</label><span class="form-note d-none d-md-block">Banka şube bilgilsi.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" name="bank_branch" id="bank_branch" value="" placeholder="İstanbul/İstoç"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-5 ">
                                                        <div class="form-group"><label class="form-label" for="bank_account_number">Banka Hesap No</label><span class="form-note d-none d-md-block">Banka hesap bilgilsi.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" name="bank_account_number" id="bank_account_number" value="" placeholder="ENPARA ŞİRKETİM vb."></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="site-name">Açılış Bakiyesi ve Tarihi</label>
                                                        <span class="form-note d-none d-md-block">Hesap için açılış
                                                            bakiyesi belirleyebilirsiniz.<br>Alacaklı ise tutarı başına
                                                            (-) eksi ile giriniz.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-lg text-end" name="starting_balance" id="starting_balance" placeholder="0,00" onkeypress="return SadeceRakam(event,[',','-']);">
                                                        </div>
                                                        <small>Kuruş bilgisini , ile belirtebilirsiniz.</small>
                                                    </div>

                                                </div>

                                                <div class="" style="width: 160px">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left" style="width: calc(1rem + 30px); top:1px">
                                                            <em class="icon ni ni-calendar icon-lg"></em>
                                                        </div>
                                                        <input id="starting_balance_date" name="starting_balance_date" type="text" class="form-control form-control-lg date-picker" style="padding-right: 16px; padding-left: 44px;" data-date-format="dd/mm/yyyy" value="<?= date('d/m/Y') ?>">
                                                        <small>&nbsp;</small>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div><!-- .card-inner -->
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <a href="javascript:history.back()" class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Geri</span></a>
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <div class="form-group">
                                                    <button type="submit" id="createFinancialAccount" class="btn btn-lg btn-primary">Kaydet</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                </form>
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div>
                </div>
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'create_financial_account',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Hesap bilgileri başarıyla kaydedildi.',
                'modal_buttons' => '<a href="' . route_to('tportal.financial_accounts.create') . '" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Hesap Ekle</a>
                                    <a href="' . route_to('tportal.financial_accounts.list', 'all') . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Tüm Hesapları Göster</a>'
            ],
        ],
    ]
); ?>



<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {

        $('input[type=radio][name=account_type]').change(function() {
            if (this.value == 'vault') {
                $('#without_vault').addClass('d-none');
            } else if (this.value == 'bank') {
                $('#without_vault').removeClass('d-none');
            } else if (this.value == 'credit_card') {
                $('#without_vault').removeClass('d-none');
            } else if (this.value == 'pos') {
                $('#without_vault').removeClass('d-none');
            }
        });

        // $('#starting_balance').mask('000.000.000.000.000,00', {
        //     reverse: true
        // });
    });

    $('#createFinancialAccount').click(function(e) {
        e.preventDefault();

        // Bu kısımda diğer hesap tipi de seçili mi diye kontrol edilmeli
        if ($('#account_title').val() == "" || $('#money_unit_id').val() == '') {
            swetAlert("Eksik Bir Şeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
        } else {
            var formData = $('#createFinancialAccountForm').serializeArray();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.financial_accounts.create') ?>',
                dataType: 'json',
                data: formData,
                async: true,
                success: function(response) {
                    console.log(response);
                    if (response['icon'] == 'success') {
                        $("#trigger_create_financial_account_ok_button").click();
                    } else {
                        swetAlert("Bir Şeyler Ters Gitti", response["message"], "err");
                    }
                }
            })
        }
    });
</script>

<?= $this->endSection() ?>