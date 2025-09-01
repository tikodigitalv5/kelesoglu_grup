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
                                        <h4 class="nk-block-title">Tahsilat/Ödeme Oluştur </h4>

                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <form onsubmit="return false;" id="createPaymentOrCollectionForm" method="POST">

                                    <div class="gy-3">
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-4 col-xxl-4 ">
                                                <div class="form-group"><label class="form-label" for="site-name">Ödeme
                                                        / Tahsilat</label><span
                                                        class="form-note d-none d-md-block">Ödeme Aldıysanız
                                                        TAHSİLAT.<br>Ödeme yaptıysanız ÖDEME seçiniz.</span></div>
                                            </div>
                                            <div class="col-lg-4 col-xxl-8  mt-0 mt-md-2">
                                                <ul class="custom-control-group">
                                                    <li>
                                                        <div
                                                            class="custom-control custom-control-sm custom-radio custom-control-pro transaction_type">
                                                            <input type="radio" class="custom-control-input"
                                                                name="transaction_type" id="transaction_type_collection"
                                                                value="collection" required checked>
                                                            <label class="custom-control-label"
                                                                for="transaction_type_collection">
                                                                <span>TAHSİLAT</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div
                                                            class="custom-control custom-control-sm custom-radio custom-control-pro transaction_type">
                                                            <input type="radio" class="custom-control-input"
                                                                name="transaction_type" id="transaction_type_payment"
                                                                value="payment" required>
                                                            <label class="custom-control-label"
                                                                for="transaction_type_payment">
                                                                <span>ÖDEME</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                   
                                                     


                                                    <li>
                                                            <div
                                                                class="custom-control custom-control-sm custom-radio custom-control-pro transaction_type">
                                                                <input type="radio" class="custom-control-input"
                                                                    name="transaction_type"
                                                                    id="transaction_type_starting_balance"
                                                                    value="diger" required>
                                                                <label class="custom-control-label"
                                                                    for="transaction_type_starting_balance">
                                                                    <span>DİĞER</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="g-3" id="t_o_area">



                                            <div class="row g-3 align-center">
                                                <div class="col-lg-4 col-xxl-4 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="site-name">İşlem Hesabı</label>
                                                        <span class="form-note d-none d-md-block">İşlem yapılan hesabı
                                                            seçiniz veya ekleyiniz.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-xl"
                                                                id="account" name="account" disabled
                                                                placeholder="Hesap seçmek için tıklayınız..">
                                                            <div class="input-group-append">
                                                                <button data-bs-toggle="modal"
                                                                    data-bs-target="#mdl_hesaplar"
                                                                    class="btn btn-lg btn-block btn-dim btn-outline-light">SEÇ</button>
                                                               
                                                            </div>


                                                            
                                                            
                                                        </div>
                                                      
                                                    </div>
                                                </div>
                                            </div>



                                        

                                            <div class="row g-3 align-center check_bill_var">
                                                <div class="col-lg-4 col-xxl-4 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="site-name">Tutar, Para Birimi ve
                                                            Tarihi</label>
                                                        <span class="form-note d-none d-md-block">İşlem yapılan tutar,
                                                            para birimi ve tarih bilgisini giriniz.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control form-control-xl text-end"
                                                                name="transaction_amount" id="transaction_amount"
                                                                onkeypress="return SadeceRakam(event,[',']);"
                                                                placeholder="0,00">
                                                            <div class="input-group-append">
                                                                <button
                                                                    class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                    <span id="moneyUnit">SEÇ</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="" style="width: 160px">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left"
                                                            style="width: calc(1rem + 30px); top:1px">
                                                            <em class="icon ni ni-calendar icon-xl"></em>
                                                        </div>
                                                        <input id="transaction_date" name="transaction_date" type="text"
                                                            class="form-control form-control-xl date-picker"
                                                            style="padding-right: 16px; padding-left: 44px;"
                                                            data-date-format="dd/mm/yyyy" value="<?= date('d/m/Y') ?>">
                                                    </div>
                                                </div>
                                            </div>



                                        <div class="row g-3 align-center para_birimi_icin_ac d-none">
                                            <div class="col-lg-4 col-xxl-4 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-name">Kur'a Göre Karşılığı </label>
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
                                                                    <span id=""><?php echo $cari_item["money_code"] ?></span>
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
                                                                    <span id=""><?php echo $cari_item["money_code"] ?></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="islem_kuru" id="islem_kuru" value="">

                                       
                                        </div>



                                            <div class="row g-3 align-center">
                                                <div class="col-lg-4 col-xxl-4 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="urun_adi">İşlem Başlık</label>
                                                        <span class="form-note d-none d-md-block">Cari hareketlerinzde
                                                            gözükebilir yazarsanız.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text"
                                                                class="form-control form-control-xl"
                                                                id="transaction_title" name="transaction_title" value=""
                                                                placeholder="Örn : Ön Ödeme"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-4 col-xxl-4 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="transaction_description">İşlem Notu</label>
                                                        <span class="form-note d-none d-md-block">Sadece sizin detayda
                                                            görebileceğiniz br nottur.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-lg"
                                                                name="transaction_description"
                                                                id="transaction_description" cols="30"
                                                                rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <input type="hidden" name="financial_account_id" id="financial_account_id"
                                                value="">
                                            <input type="hidden" name="money_unit_id" id="money_unit_id" value="">
                                            <input type="hidden" name="selectedAccountType" id="selectedAccountType" value="">


                                            
                                        </div>
                                        <div class="d-none" id="sb_area">




                                        <div class="row g-3 align-center">
                                            <div class="col-lg-4 col-xxl-4 ">
                                                <div class="form-group"><label class="form-label" for="site-name">İşlem Seçiniz
                                            </label><span
                                                        class="form-note d-none d-md-block">Başlangıç Bakiyesi veya <br>Borç Alacak/Verecek Ekleyebilirsiniz</span></div>
                                            </div>
                                            <div class="col-lg-4 col-xxl-8  mt-0 mt-md-2">
                                                <ul class="custom-control-group">
                                                <?php
                                       
                                       if ($starting_balance_item == 0) { ?>
                                                    <li>
                                                        <div
                                                            class="custom-control custom-control-sm custom-radio custom-control-pro ">
                                                            <input type="radio" class="custom-control-input"
                                                                name="transaction_type" id="transaction_type_baslangic"
                                                                value="starting_balance" required checked>
                                                            <label class="custom-control-label"
                                                                for="transaction_type_baslangic">
                                                                <span>BAŞLANGIÇ BAKİYESİ</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <?php } ?>
                                                    <li>
                                                        <div
                                                            class="custom-control custom-control-sm custom-radio custom-control-pro ">
                                                            <input type="radio" class="custom-control-input"
                                                                name="transaction_type" id="transaction_type_borc"
                                                                value="borc_alacak" required>
                                                            <label class="custom-control-label"
                                                                for="transaction_type_borc">
                                                                <span>BORÇ/ALACAK/VERECEK EKLE</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                   
                                                     


                                                
                                                </ul>
                                            </div>
                                        </div>

                                           

                                            <?php
                                       
                                                    if ($starting_balance_item == 0) { ?>
                                                    <div class="row g-3 align-center mt-1 acilis d-none">
                                                <div class="col-lg-4 col-xxl-4 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="site-name">Açılış Bakiyesi /
                                                            Tarihi</label>
                                                        <span class="form-note d-none d-md-block">Cari için açılış
                                                            bakiyesi belirleyebilirsiniz. <br> Alacaklı ise tutarı
                                                            başına (-) eksi ile giriniz.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control form-control-xl text-end"
                                                                name="sb_transaction_amount" id="sb_transaction_amount"
                                                                onkeypress="return SadeceRakam(event,[',','-']);"
                                                                placeholder="0,00">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="" style="width: 180px">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left"
                                                            style="width: calc(1rem + 30px); top:1px">
                                                            <em class="icon ni ni-calendar icon-xl"></em>
                                                        </div>
                                                        <input id="transaction_dates" name="transaction_dates" type="text"
                                                            class="form-control form-control-xl date-picker"
                                                            style="padding-right: 16px; padding-left: 44px;"
                                                            data-date-format="dd/mm/yyyy" value="<?= date('d/m/Y') ?>">
                                                    </div>
                                                </div>
                                              </div>
                                                <?php } ?>
                                                <div class="row g-3 align-center mt-1 borc_alacak d-none">


                                                <div class="col-lg-4 col-xxl-4 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="site-name">Borç Alacak/Verecek Ekle /
                                                            Tarihi</label>
                                                        <span class="form-note d-none d-md-block">Cari için borç alacak verisi ekleyebilirsiniz  <br> Alacaklı ise tutarı 
                                                            başına (-) eksi ile giriniz.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control form-control-xl text-end"
                                                                name="borc_alacak" id="borc_alacak"
                                                                onkeypress="return SadeceRakam(event,[',','-']);"
                                                                placeholder="0,00">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="" style="width: 180px">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left"
                                                            style="width: calc(1rem + 30px); top:1px">
                                                            <em class="icon ni ni-calendar icon-xl"></em>
                                                        </div>
                                                        <input id="borc_dates" name="borc_dates" type="text"
                                                            class="form-control form-control-xl date-picker"
                                                            style="padding-right: 16px; padding-left: 44px;"
                                                            data-date-format="dd/mm/yyyy" value="<?= date('d/m/Y') ?>">
                                                    </div>
                                                </div>
                                                </div>
                                         





                                                <div class="row g-3 align-center mt-1">
                                                <div class="col-lg-4 col-xxl-4 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="urun_adi">İşlem Başlık</label>
                                                        <span class="form-note d-none d-md-block">Cari hareketlerinzde
                                                            gözükebilir yazarsanız.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text"
                                                                class="form-control form-control-xl"
                                                                id="borc_transaction_title" name="borc_transaction_title" value=""
                                                                placeholder="Örn : Ön Ödeme"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center mt-1">
                                                <div class="col-lg-4 col-xxl-4 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="transaction_description">İşlem Notu</label>
                                                        <span class="form-note d-none d-md-block">Sadece sizin detayda
                                                            görebileceğiniz br nottur.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-lg"
                                                                name="borc_transaction_description"
                                                                id="borc_transaction_description" cols="30"
                                                                rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                          
                                        </div>
                                    </div>
                                    <div class="row g-3 pt-3">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <!-- <a href="javascript:history.back()" class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Geri</span></a> -->
                                            </div>
                                        </div>
                                        <div class="col-6 text-end">
                                            <div class="form-group">
                                                <button type="submit" id="savePaymentOrCollection"
                                                    class="btn btn-lg btn-primary">Kaydet</button>
                                            </div>
                                        </div>
                                    </div>
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
        'element' => 'create_payment_or_collection',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => '<span id="paymentCollectionText"></span>',
                'modal_buttons' => '<a href="' . route_to('tportal.cariler.payment_or_collection_create', $cari_item['cari_id']) . '" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Tahsilat/Ödeme Ekle</a>
                                    <a href="' . route_to('tportal.cariler.financial_movements', $cari_item['cari_id']) . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Tüm Tahsilat/Ödeme\'leri Göster</a>'
            ],
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    $('#transaction_amount').mask('000.000.000,00', { reverse: true });

    var selectedTransaction;
    $('input[name="transaction_type"]').on('change', function () {
        selectedTransaction = $('input[name="transaction_type"]:checked').val();

        console.log('Seçilen işlem tipi: ' + selectedTransaction);

        if (selectedTransaction === 'starting_balance') {
            console.log('starting_balance tespit edildi');
            $('#t_o_area').addClass('d-none');
            $('#sb_area').removeClass('d-none');


            $('.acilis').removeClass('d-none');
            $('.borc_alacak').addClass('d-none');


            



        }else if (selectedTransaction === 'diger') {

            $('#t_o_area').addClass('d-none');
            $('#sb_area').removeClass('d-none');

            $('.acilis').addClass('d-none');
            $('.borc_alacak').removeClass('d-none');
        }else if (selectedTransaction === 'borc_alacak') {
            console.log('borc_alacak tespit edildi');

            $('#t_o_area').addClass('d-none');
            $('#sb_area').removeClass('d-none');

            $('.acilis').addClass('d-none');
            $('.borc_alacak').removeClass('d-none');
        }
        else {
            $('.acilis').addClass('d-none');
            $('.borc_alacak').addClass('d-none');
            $('#t_o_area').removeClass('d-none');
            $('#sb_area').addClass('d-none');

        }
    });

    $('#savePaymentOrCollection').click(function (e) {
        e.preventDefault();
        var formData2 = $('#createPaymentOrCollectionForm').serializeArray();
        console.log(formData2);
        if (selectedTransaction == 'starting_balance') {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.cariler.payment_or_collection_store', $cari_item['cari_id']) ?>',
                dataType: 'json',
                data: formData2,
                async: true,
                success: function (response) {
                    if (response['icon'] == 'success') {
                        $('#createPaymentOrCollectionForm')[0].reset();
                        $('#paymentCollectionText').text(response.message);
                        $("#trigger_create_payment_or_collection_ok_button").click();
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
        }else      if (selectedTransaction == 'borc_alacak') {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.cariler.payment_or_collection_store', $cari_item['cari_id']) ?>',
                dataType: 'json',
                data: formData2,
                async: true,
                success: function (response) {
                    if (response['icon'] == 'success') {
                        $('#createPaymentOrCollectionForm')[0].reset();
                        $('#paymentCollectionText').text(response.message);
                        $("#trigger_create_payment_or_collection_ok_button").click();
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
        } else {

            if ($('.transaction_type').val() == null || $('#transaction_amount').val() == "" || $('#money_unit_id').val() == "" || $('#financial_account_id').val() == "" || $('#transaction_title').val() == "") {
                var formData = $('#createPaymentOrCollectionForm').serializeArray();
                swetAlert("Hatalı İşlem", "Lütfen sizden istenen bilgileri doldurunuz...", "err");
            } else {
                var formData = $('#createPaymentOrCollectionForm').serializeArray();
                formData.push({
                    name: "money_unit_id",
                    value: $('#money_unit_id').val(),
                });
                formData.push({
                    name: "financial_account_id",
                    value: $('#financial_account_id').val(),
                });
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= route_to('tportal.cariler.payment_or_collection_store', $cari_item['cari_id']) ?>',
                    dataType: 'json',
                    data: formData,
                    async: true,
                    success: function (response) {
                        if (response['icon'] == 'success') {
                            $('#createPaymentOrCollectionForm')[0].reset();
                            $('#paymentCollectionText').text(response.message);
                            $("#trigger_create_payment_or_collection_ok_button").click();
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
        }
    });
</script>

<?= $this->endSection() ?>