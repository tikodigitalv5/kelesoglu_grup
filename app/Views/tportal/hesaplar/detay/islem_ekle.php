<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Yeni İşlem <?= $this->endSection() ?>
<?= $this->section('title') ?> Yeni İşlem | ENPARA ŞİRKETİM <?= $this->endSection() ?>
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
                                        <h4 class="nk-block-title">Yeni İşlem</h4>

                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <form onsubmit="return false;" id="createTransactionForm" method="post">

                                    <div class="gy-3">

                                        <div class="row g-3 align-center d-none">
                                            <div class="col-lg-4 ">
                                                <div class="form-group"><label class="form-label" for="site-name">İşlem
                                                        Tipi</label><span class="form-note d-none d-md-block">Yapmak
                                                        istediğiniz işlemi seçin.</span></div>
                                            </div>
                                            <div class="col-lg-8  mt-0 mt-md-2">
                                                <ul class="custom-control-group">
                                                    <li>
                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                            <input type="radio" class="custom-control-input" name="transaction_type" id="transaction_type_virman" value="outgoing_virman" checked>
                                                            <label class="custom-control-label" for="transaction_type_virman">
                                                                <span>Virman</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                            <input type="radio" class="custom-control-input" name="transaction_type" id="transaction_type_payment" value="payment">
                                                            <label class="custom-control-label" for="transaction_type_payment">
                                                                <span>Cariye Transfer</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <!-- Buradaki seçilen değere göre list load routeuna istek atmamız gerekiyor. -->
                                                    <!-- Gelen değerleri hesap seç modalının içerisine basıcaz -->
                                                    <!-- tportal.financial_accounts.list_load_cari -->
                                                    <!-- tportal.financial_accounts.list_load_financial_account -->
                                                </ul>
                                                <hr>
                                            </div>
                                        </div>

                                        <!-- Bu başlık diger hesaba transfer ise gelecek -->
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-4 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-name">Diğer İşlem Hesabı</label>
                                                    <span class="form-note d-none d-md-block">Aktarılacak hesabı seçiniz
                                                        veya ekleyiniz.</span>
                                                </div>
                                            </div>
                                            <div class="col mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-xl" id="account" name="account" disabled placeholder="Hesap seçmek için tıklayınız..">
                                                        <div class="input-group-append">
                                                            <button data-bs-toggle="modal" data-bs-target="#mdl_hesaplar" class="btn btn-lg btn-block btn-dim btn-outline-light">SEÇ</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-4 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-name">Tutar ve Tarihi</label>
                                                    <span class="form-note d-none d-md-block">İşlem yapılan tutar ve
                                                        tarihi giriniz.</span>
                                                </div>
                                            </div>
                                            <div class="col mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-xl text-end" name="transaction_amount" id="transaction_amount" onkeypress="return SadeceRakam(event,[',']);" placeholder="0,00">
                                                        <div class="input-group-append">
                                                            <button  class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                <span id="moneyUnit">SEÇ</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="mt-0 mt-md-2" style="width: 160px">
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-left" style="width: calc(1rem + 30px); top:1px">
                                                        <em class="icon ni ni-calendar icon-xl"></em>
                                                    </div>
                                                    <input id="transaction_date" name="transaction_date" type="text" class="form-control form-control-xl date-picker" style="padding-right: 16px; padding-left: 44px;" data-date-format="dd/mm/yyyy" value="<?= date('d/m/Y') ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center para_birimi_icin_ac d-none">
                                        <div class="col-lg-4 ">
                                        <div class="form-group">
                                                    <label class="form-label" for="site-name">Kur'a Göre Karşılığı 2</label>
                                                    <span class="form-note d-none d-md-block">Carinin para birimine ve işlemin <br> para birimine göre kur girilmelidir.</span>
                                                </div>
                                            </div>

                                            <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control form-control-xl text-end"
                                                                name="donusturulecek_kur" id="donusturulecek_kur"
                                                                onkeypress="return SadeceRakam(event,[',']);"
                                                                placeholder="0,00">
                                                            <div class="input-group-append">
                                                                <button 
                                                                    
                                                                    class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                    <span class="money_kod"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control form-control-xl text-end"
                                                                name="toplam_kur" readonly id="toplam_kur"
                                                                onkeypress="return SadeceRakam(event,[',']);"
                                                                placeholder="0,00">
                                                            <div class="input-group-append">
                                                                <button 
                                                                    class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                    <span class="money_kod"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                       
                                        </div>

                                        <input type="hidden" name="islem_kuru" id="islem_kuru" value="">
                                        <input type="hidden" name="kasa_id" id="kasa_id" value="">


                                        <div class="row g-3 align-center">
                                            <div class="col-lg-4 ">
                                                <div class="form-group"><label class="form-label" for="is_transaction_cost">İşlem
                                                        Masrafı</label><span class="form-note d-none d-md-block">İşlemi
                                                        yaparken banka masrafı var ise.</span></div>
                                            </div>


                                            <!-- tik atılınca yanındaki input aktif olacak
                                                 ama ilk etap tamamen kapalı olabilir. Çünki gidere işlenmesi gerekli.-->
                                            <div class="" style="width: 160px">
                                                <div class="custom-control custom-control-lg custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="is_transaction_cost" name="is_transaction_cost">
                                                    <label class="custom-control-label" for="is_transaction_cost">Var</label>
                                                </div>
                                            </div>
                                            <div class="col mt-0 mt-md-2 d-none" id="transaction_cost_div" style="pointer-events: none;">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-xl text-end" name="transaction_cost" id="transaction_cost" onkeypress="return SadeceRakam(event,[',']);" placeholder="0,00" disabled>
                                                        <div class="input-group-append">
                                                            <button data-bs-toggle="modal" data-bs-target="#mdl_parabirimi" class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                <span id="moneyUnit">SEÇ</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- Bu başlık para girişi ve çıkışı ise gelecek -->
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-4 ">
                                                <div class="form-group"><label class="form-label" for="transaction_title">İşlem
                                                        Başlık</label><span class="form-note d-none d-md-block">Hareketlerinzde gözükebilir
                                                        yazarsanız.</span></div>
                                            </div>
                                            <div class="col-lg-8 mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <div class="form-control-wrap"><input type="text" class="form-control form-control-xl" name="transaction_title" id="transaction_title" value="" placeholder="Örn : Ön Ödeme"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-4 ">
                                                <div class="form-group"><label class="form-label" for="transaction_description">İşlem
                                                        Notu</label><span class="form-note d-none d-md-block">Sadece
                                                        sizin detayda görebileceğiniz br nottur.</span></div>
                                            </div>
                                            <div class="col-lg-8 mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <textarea class="form-control form-control-lg" name="transaction_description" id="transaction_description" cols="30" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="financial_account_id" id="financial_account_id" value="">
                                        <input type="hidden" name="money_unit_id" id="money_unit_id" value="">


                                    </div>
                                    <div class="row g-3 pt-3">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <!-- <a href="javascript:history.back()" class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Geri</span></a> -->
                                            </div>
                                        </div>
                                        <div class="col-6 text-end">
                                            <div class="form-group">
                                                <button type="submit" id="create_transaction" class="btn btn-lg btn-primary">Kaydet</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div><!-- .nk-block -->
                        </div>

                        <?= $this->include('tportal/hesaplar/detay/inc/sol_menu') ?>
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
        'element' => 'create_payment_or_collection',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Yeni işlem başarıyla oluşturuldu',
                'modal_buttons' => '<a href="' . route_to('tportal.financial_accounts.payment_or_collection_create', $financial_account_item['financial_account_id']) . '" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni İşlem Ekle</a>
                                    <a href="' . route_to('tportal.financial_accounts.list_load_financial_account', $financial_account_item['financial_account_id']) . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Hesap Hareketlerini Göster</a>'
            ],
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    $('#is_transaction_cost').on('click', function() {
        isChecked = $(this).is(':checked')

        if (isChecked) {
            $('#transaction_cost').removeAttr('disabled')
            $('#transaction_cost_div').removeAttr('style')
            $('#transaction_cost_div').removeClass('d-none')
        } else {
            $('#transaction_cost_div').css({
                'pointer-events': 'none'
            });
            $('#transaction_cost').attr({
                'disabled': 'true'
            });
            $('#transaction_cost_div').addClass('d-none')

        }
    })

    $('#transaction_amount').mask('000.000.000.000.000,00', {
            reverse: true
        });

    $('#create_transaction').click(function(e) {
        e.preventDefault();

        if ($('#account').val() == null || $('#transaction_amount').val() == '' || $('#transaction_title').val() == '' || $('#financial_account_id').val() == '' || $('#money_unit_id').val() == '') {
            swetAlert("Eksik Bir Şeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
        } else {
            var formData = $('#createTransactionForm').serializeArray();
            formData.push({
                name: 'to_transaction_id',
                value: $('#financial_account_id').val()
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.financial_accounts.payment_or_collection_store', $financial_account_item['financial_account_id']) ?>',
                dataType: 'json',
                data: formData,
                async: true,
                success: function(response) {
                    if (response['icon'] == 'success') {
                        $('#createTransactionForm')[0].reset();
                        $("#trigger_create_payment_or_collection_ok_button").click();
                    } else {
                        swetAlert("Bir Şeyler Ters Gitti", response["message"], "err");
                    }
                }
            })
        }
    });
</script>

<?= $this->endSection() ?>