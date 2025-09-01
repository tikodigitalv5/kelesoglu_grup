<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Tahsilat/Ödeme Oluştur <?= $this->endSection() ?>
<?= $this->section('title') ?> Tahsilat/Ödeme Oluştur | <?= session()->get('user_item')['firma_adi'] ?> <?= $this->endSection() ?>
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
                                        <h4 class="nk-block-title">Tahsilat/Ödeme Düzenle</h4>
                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <form onsubmit="return false;" id="createPaymentOrCollectionForm" method="POST">

                                    <div class="gy-3">
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-name">Müşteri</label>
                                                    <span class="form-note d-none d-md-block" style="">Satış yapılacak müşteriyi seçin veya ekleyin.</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-xl" id="cari_info" name="cari_info" value="<?= isset($financial_movement_item) ? $cari_item['invoice_title'] == '' ? $cari_item['name'] . " " . $cari_item['surname'] : $cari_item['invoice_title'] : ''; ?>" readonly placeholder="Müşteri seçmek için tıklayınız..">
                                                        <div class="input-group-append">
                                                            <button id="btn_musteriSec" data-bs-toggle="modal" data-bs-target="#mdl_musteriSec" class="btn btn-lg btn-block btn-dim btn-outline-primary" <?= isset($cari_item) ? "style='pointer-events: none; cursor: default; opacity:0.53; '" : ""  ?> disabled>Müşteri Seç</button>
                                                            <!-- <button class="btn btn-lg btn-block btn-dim btn-outline-light">EKLE</button> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group"><label class="form-label" for="site-name">Ödeme / Tahsilat</label><span class="form-note d-none d-md-block">Ödeme Aldıysanız TAHSİLAT.<br>Ödeme yaptıysanız ÖDEME seçiniz.</span></div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                <ul class="custom-control-group">
                                                    <li>
                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro transaction_type">
                                                            <input disabled type="radio" class="custom-control-input" name="transaction_type" id="transaction_type_collection" value="collection" <?= isset($financial_movement_item) ? (($financial_movement_item['transaction_type'] == 'collection') ? 'checked' : '') : ''  ?> required>
                                                            <label class="custom-control-label" for="transaction_type_collection">
                                                                <span>TAHSİLAT</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro transaction_type">
                                                            <input disabled type="radio" class="custom-control-input" name="transaction_type" id="transaction_type_payment" value="payment" <?= isset($financial_movement_item) ? (($financial_movement_item['transaction_type'] == 'payment') ? 'checked' : '') : '' ?> required>
                                                            <label class="custom-control-label" for="transaction_type_payment">
                                                                <span>ÖDEME</span>
                                                            </label>
                                                        </div>
                                                    </li>

                                                    <?php if($financial_movement_item['transaction_type'] == "incoming_gider" ||  $financial_movement_item['transaction_type'] == "outgoing_gider" ): ?>
                                                    <li>
                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro transaction_type">
                                                            <input type="radio" class="custom-control-input" name="transaction_type" id="transaction_type_payment" value="incoming_gider" <?= isset($financial_movement_item) ? (($financial_movement_item['transaction_type'] == 'incoming_gider' ||  $financial_movement_item['transaction_type'] == 'outgoing_gider') ? 'checked' : '') : '' ?> required>
                                                            <label class="custom-control-label" for="transaction_type_payment">
                                                                <span>GİDER TAHSİLATI</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-name">İşlem Hesabı</label>
                                                    <span class="form-note d-none d-md-block">İşlem yapılan hesabı seçiniz veya ekleyiniz.</span>
                                                </div>
                                            </div>
                                            <div class="col mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-xl" id="account" name="account" disabled placeholder="Hesap seçmek için tıklayınız.." value="<?= $current_financial_account_item['account_title'] ?>">
                                                        <div class="input-group-append">
                                                            <button data-bs-toggle="modal" data-bs-target="#mdl_hesaplar" class="btn btn-lg btn-block btn-dim btn-outline-light">SEÇ</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-name">Tutar, Para Birimi ve Tarihi</label>
                                                    <span class="form-note d-none d-md-block">İşlem yapılan tutar, para birimi ve tarih bilgisini giriniz.</span>
                                                </div>
                                            </div>
                                            <div class="col mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-xl text-end" name="transaction_amount" id="transaction_amount" onkeypress="return SadeceRakam(event,[',']);" placeholder="0,00" value="<?= number_format($financial_movement_item['transaction_amount'],2,',','.') ?>" readonly>
                                                        <div class="input-group-append">
                                                            <button data-bs-toggle="modal" data-bs-target="#mdl_parabirimi" class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                <span id="moneyUnit"><?= $current_financial_account_item['money_code'] ?></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="" style="width: 200px">
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-left" style="width: calc(1rem + 30px); top:1px">
                                                        <em class="icon ni ni-calendar icon-xl"></em>
                                                    </div>
                                                    <input id="transaction_date" name="transaction_date" disabled type="text" class="form-control form-control-xl date-picker" style="padding-right: 16px; padding-left: 44px;" data-date-format="dd/mm/yyyy" value="<?= convert_date_for_view($financial_movement_item['transaction_date']) ?>">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row g-3 align-center para_birimi_icin_ac d-none">
                                            <div class="col-lg-4 col-xxl-4 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-name">Kur'a Göre Karşılığı</label>
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
                                                                name="toplam_kur" disabled id="toplam_kur"
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
                                       
                                        </div>




                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group"><label class="form-label" for="urun_adi">İşlem Başlık</label>
                                                    <span class="form-note d-none d-md-block">Cari hareketlerinzde gözükebilir yazarsanız.</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <div class="form-control-wrap"><input type="text" class="form-control form-control-xl" id="transaction_title" name="transaction_title" value="<?= $financial_movement_item['transaction_title'] ?>" placeholder="Örn : Ön Ödeme" readonly></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group"><label class="form-label" for="transaction_description">İşlem Notu</label>
                                                    <span class="form-note d-none d-md-block">Sadece sizin detayda görebileceğiniz br nottur.</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <textarea class="form-control form-control-lg" name="transaction_description" id="transaction_description" cols="30" rows="3"><?= $financial_movement_item['transaction_description'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="financial_movement_id" id="financial_movement_id" value="<?= $financial_movement_item['financial_movement_id'] ?>">
                                        <input type="hidden" name="financial_account_id" id="financial_account_id" value="<?= $financial_movement_item['financial_account_id'] ?>">
                                        <input type="hidden" name="money_unit_id" id="money_unit_id" value="<?= $financial_movement_item['money_unit_id'] ?>">
                                        <input type="hidden" name="cari_id" id="cari_id" value="<?= $financial_movement_item['cari_id'] ?>">

                                    </div>
                                    <div class="row g-3 pt-3">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <!-- <button id="deletePaymentOrCollection" class="btn btn-lg btn-danger">Tahsilatı Sil</button> -->

                                            </div>
                                        </div>
                                        <div class="col-6 text-end">
                                            <div class="form-group">
                                            <?php if($financial_movement_item['transaction_type'] != "incoming_gider" &&  $financial_movement_item['transaction_type'] != "outgoing_gider" ): ?>
                                                <button id="deletePaymentOrCollection" class="btn btn-lg btn-danger">Sil</button>
                                                <?php endif; ?>
                                                <button type="submit" id="savePaymentOrCollection" class="btn btn-lg btn-primary d-none">Kaydet</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div><!-- .nk-block -->
                        </div>

                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>


<!-- Hesaplar Modal -->
<div class="modal fade" id="mdl_hesaplar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">İşlem Hesabı Seçiniz</h5>
                <a href="#" id="btn_hesaplar_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body p-0">
                <table class="datatable-hareketler table">
                    <thead>
                        <tr>
                            <th>Seç</th>
                            <th>Banka</th>
                            <th>Tipi - Döviz</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($financial_account_items)) {
                            foreach ($financial_account_items as $financial_account_item) { ?>
                                <tr>

                                    <td data-order="0">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                name="radioSizeAccount"
                                                accName="<?= $financial_account_item['account_title']; ?>"
                                                accMoneyUnitId="<?= $financial_account_item['money_unit_id']; ?>"
                                                accMoneyUnitName="<?= $financial_account_item['money_code']; ?>"
                                                id="<?= $financial_account_item['financial_account_id'] ?>"
                                                <?= $financial_account_item['financial_account_id'] == $current_financial_account_item['financial_account_id'] ? 'checked' : '' ?>/>
                                            <label class="custom-control-label" for="<?= $financial_account_item['financial_account_id'] ?>"><?= $financial_account_item['account_title']; ?></label>
                                        </div>
                                    </td>
                                    <td><?php if (isset($bank_items) && $financial_account_item['bank_id'] != null) {
                                            echo $bank_items[array_search($financial_account_item['bank_id'], array_column($bank_items, 'bank_id'))]['bank_title'];
                                        } else {
                                            echo " - ";
                                        }  ?></td>
                                    <td><?php switch ($financial_account_item['account_type']) {
                                            case 'vault':
                                                echo "Kasa";
                                                break;
                                            case 'bank':
                                                echo "Banka";
                                                break;
                                            case 'pos':
                                                echo "POS";
                                                break;
                                                case 'check_bill':
                                                    echo "ÇEK/SENET";
                                                    break; 
                                            case 'credit_card':
                                                echo "Kredi Kartı";
                                                break;
                                        } ?> - <?= $financial_account_item['money_code'] ?></td>

                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg btn-dim btn-outline-light" data-bs-dismiss="modal" aria-label="Close">KAPAT</button>

                    </div>
                    <div class="col-md-8 text-end p-0">

                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ HESAP</button>
                        <button type="button" id="btn_hesapsec_mdl" class="btn btn-lg btn-primary ">SEÇ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Para Birimi Modal -->
<div class="modal fade" tabindex="-1" id="mdl_parabirimi">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Para Birimi Seçiniz</h5>
                <a href="#" id="btn_mdl_parabirimi_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <table class=" table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Birim Adı</th>
                            <th data-orderable="false">Kodu</th>
                            <th data-orderable="false">Simgesi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (isset($all_money_unit)) {
                            foreach ($all_money_unit as $money_unit) { ?>
                                <tr>
                                    <td data-order="0">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="radioSize" id="customRadio<?= $money_unit['money_unit_id'] ?>" value="<?= $money_unit['money_unit_id'] ?>" money_code="<?= $money_unit['money_code'] ?>" <?= $money_unit['money_unit_id'] == $current_financial_account_item['money_unit_id'] ? 'checked' : '' ?> >
                                            <label class="custom-control-label" for="customRadio<?= $money_unit['money_unit_id'] ?>"><?= $money_unit['money_title'] ?></label>
                                        </div>
                                    </td>
                                    <td><?= $money_unit['money_code'] ?></td>
                                    <td><?= $money_unit['money_icon'] ?></td>
                                </tr>
                        <?php }
                        } ?>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_parabirimisec_mdl" class="btn btn-lg btn-primary">SEÇ</button>
            </div>
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
                'modal_text' => 'Tahsilat/Ödeme başarıyla oluşturuldu',
                'modal_buttons' => '<a href="' . route_to('tportal.cariler.payment_or_collection_create_page') . '" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Tahsilat/Ödeme Ekle</a>
                                    <a href="javascript:history.back()" class="btn btn-primary btn-block mb-2">Geri Dön</a>'
            ],
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    $(document).ready(function() {
        // $('#transaction_amount').mask('000.000.000,00', {
        //     reverse: true
        // });

        let searchParams = new URLSearchParams(window.location.search)
        let param = searchParams.get('q')

        if (param == "tahsilat")
            $('#transaction_type_collection').attr('checked', true);
        if (param == "odeme")
            $('#transaction_type_payment').attr('checked', true);


        $('#btn_hesapsec_mdl').click(function() {
            var selectedAccount = $('input[name="radioSizeAccount"]:checked').attr('id');
            var selectedAccountName = $('input[name="radioSizeAccount"]:checked').attr('accName');
            var selectedAccountMoneyId = $('input[name="radioSizeAccount"]:checked').attr('accMoneyUnitId');
            var selectedAccountMoneyName = $('input[name="radioSizeAccount"]:checked').attr('accMoneyUnitName');

            if (selectedAccount != null && selectedAccount != 0) {
                // selectedAccount = selectedAccount.substring(11);
                $('#account').empty().val(selectedAccountName);
                $('#financial_account_id').empty().val(selectedAccount);
                $('#mdl_hesaplar').modal('hide');

                $('#moneyUnit').empty().append(selectedAccountMoneyName);
                $('#money_unit_id').val(selectedAccountMoneyId);

                $('#customRadio' + selectedAccountMoneyId).attr('checked', 'checked');




    if (selectedAccount != null && selectedAccount != 0) {
      // selectedAccount = selectedAccount.substring(11);
      $('#account').empty().val(selectedAccountName);
      $('#financial_account_id').empty().val(selectedAccount);
      $('#selectedAccountType').empty().val(selectedAccountType);
      $('#mdl_hesaplar').modal('hide');

      $('#moneyUnit').empty().append(selectedAccountMoneyName);

      if(selectedAccountMoneyName == '<?php echo $cari_item["money_code"] ?>'){
          $(".para_birimi_icin_ac").addClass("d-none");
      }else if(selectedAccountMoneyName == 'USD'){
        $(".para_birimi_icin_ac").removeClass("d-none");  

        $("#toplam_kur").val($("#transaction_amount").val() * $("#donusturulecek_kur").val());

        
      }
      else if(selectedAccountMoneyName == 'EUR'){
        $(".para_birimi_icin_ac").removeClass("d-none");

        $("#toplam_kur").val($("#transaction_amount").val() * $("#donusturulecek_kur").val());


      }else if(selectedAccountMoneyName == 'TRY'){
        $(".para_birimi_icin_ac").removeClass("d-none");

        $("#toplam_kur").val($("#transaction_amount").val() * $("#donusturulecek_kur").val());


      }else{
        $(".para_birimi_icin_ac").addClass("d-none");

      }

      $('#money_unit_id').val(selectedAccountMoneyId);

      $('#customRadio' + selectedAccountMoneyId).attr('checked', 'checked');
    } else {
      swetAlert("Lütfen işlem hesabı seçiniz", "", "err");
    }

    $("#transaction_amount").keyup(function() {
    // Replace the comma with a dot and then parse as float
    var transactionAmount = parseFloat($("#transaction_amount").val().replace(",", ".")) || 0;
    var exchangeRate = parseFloat($("#donusturulecek_kur").val().replace(",", ".")) || 0;
    
    // Calculate the total
    var total = (transactionAmount * exchangeRate).toFixed(2);
    
    // Convert the result back to a string with a comma as the decimal separator
    var formattedTotal = total.replace(".", ",");
    
    // Update the #toplam_kur input with the formatted result
    $("#toplam_kur").val(formattedTotal);
});
$("#donusturulecek_kur").keyup(function() {
    // Replace the comma with a dot and then parse as float
    var transactionAmount = parseFloat($("#transaction_amount").val().replace(",", ".")) || 0;
    var exchangeRate = parseFloat($("#donusturulecek_kur").val().replace(",", ".")) || 0;
    
    // Calculate the total
    var total = (transactionAmount * exchangeRate).toFixed(2);
    
    // Convert the result back to a string with a comma as the decimal separator
    var formattedTotal = total.replace(".", ",");
    
    // Update the #toplam_kur input with the formatted result
    $("#toplam_kur").val(formattedTotal);
});



            } else {
                swetAlert("Lütfen işlem hesabı seçiniz", "", "err");
            }
        });

        $('#btn_parabirimisec_mdl').click(function() {
            var selectedBaseMoneyCode = $('input[name="radioSize"]:checked').attr('money_code'); //TRY
            var selectedBaseMoneyID = $('input[name="radioSize"]:checked').attr('value');

            $('#moneyUnit').empty().append(selectedBaseMoneyCode);
            $('#money_unit_id').empty().val(selectedBaseMoneyID);
            $('#mdl_parabirimi').modal('hide');

        });

        $('.rd_cari').click(function() {
            $('#mdl_musteriSec').modal('hide');
            selectedCariId = $('.rd_cari:checked').val();
            selectedCariInvoiceTitle = $('.rd_cari:checked').attr('invoice_title');
            selectedCariInvoiceName = $('.rd_cari:checked').attr('invoice_name');
            selectedCariInvoiceSurname = $('.rd_cari:checked').attr('invoice_surname');
            $('#cari_id').val($('.rd_cari:checked').val());

            console.log(selectedCariId, selectedCariInvoiceTitle);

            lastTitle = selectedCariInvoiceTitle == '' ? selectedCariInvoiceName + " " + selectedCariInvoiceSurname : selectedCariInvoiceTitle;
            $('#cari_info').val(lastTitle);
        });
    })


    $('#savePaymentOrCollection').click(function(e) {
        e.preventDefault();
        var base_url = window.location.origin;
        console.log(base_url);
        
        if ($('.transaction_type').val() == null || $('#transaction_amount').val() == "" || $('#money_unit_id').val() == "" || $('#financial_account_id').val() == "" || $('#transaction_title').val() == "") {
            var formData = $('#createPaymentOrCollectionForm').serializeArray();
            swetAlert("Hatalı İşlem", "Lütfen sizden istenen bilgileri doldurunuz...", "err");
        } else {
            var formData = $('#createPaymentOrCollectionForm').serializeArray();
            var lastCariId = $('#cari_id').val();
            formData.push({
                name: "money_unit_id",
                value: $('#money_unit_id').val(),
            });
            formData.push({
                name: "financial_account_id",
                value: $('#financial_account_id').val(),
            });
            formData = $('#createPaymentOrCollectionForm').serializeArray();
            console.log(formData);
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: base_url + '/tportal/cari/payment-or-collection/store/' + lastCariId,
                dataType: 'json',
                data: formData,
                async: true,
                success: function(response) {
                    if (response['icon'] == 'success') {
                        $('#createPaymentOrCollectionForm')[0].reset();
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
    });

    $('#deletePaymentOrCollection').click(function(e) {
            

            e.preventDefault();
            var base_url = window.location.origin;
        
            var formData = $('#createPaymentOrCollectionForm').serializeArray();
            var lastCariId = $('#cari_id').val();
            var financial_movement_id = $('#financial_movement_id').val();
            formData.push({
                name: "money_unit_id",
                value: $('#money_unit_id').val(),
            });
            formData.push({
                name: "financial_account_id",
                value: $('#financial_account_id').val(),
            });
            console.log(formData);


            Swal.fire({
                    title: 'Tahsilat/Ödeme işlemini silmek üzeresiniz!',
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
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                            },
                            async: true,
                            type: 'POST',
                            url: base_url + '/tportal/cari/payment-or-collection/delete/' + financial_movement_id,
                            data: {
                                data_form: formData,
                            },
                            success: function(response, data) {
                                dataa = JSON.parse(response);
                                if (dataa.icon === "success") {
                                    console.log(response);
                                    console.log(data);
                                    Swal.fire({
                                            title: "İşlem Başarılı",
                                            html: 'Tahsilat/Ödeme işlemi başarıyla silindi.',
                                            confirmButtonText: "Tamam",
                                            allowEscapeKey: false,
                                            allowOutsideClick: false,
                                            icon: "success",
                                        })
                                        .then(function() {
                                            window.location.reload();
                                            (window.history.length > 1) ? window.history.back() : window.location.href = base_url+"/tportal/invoice/list/all";
                                        });

                                } else {
                                    Swal.fire({
                                        title: "İşlem Başarısız",
                                        text: dataa.message,
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
</script>

<?= $this->endSection() ?>