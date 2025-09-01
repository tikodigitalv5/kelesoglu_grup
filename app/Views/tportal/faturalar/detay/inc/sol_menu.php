<?php
$cari_balance = $cari_item['cari_balance'];
$cari_money_unit_icon = $cari_item['money_icon'];
[$balanceColor, $balanceBgColor, $balanceText] = ($cari_balance == 0) ? ["text-secondary", "bg-secondary-dim", "-"] : ($cari_balance > 0 ? ["text-success", "bg-success-dim", "Borçlu"] : ["text-danger", "bg-danger-dim", "Alacaklı"]);

helper('Helpers\number_format_helper');
?>

<div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
  <div class="card-inner-group" data-simplebar>
    <div class="card-inner">
      <div class="user-card">
        <div class="user-avatar <?= $balanceBgColor ?> sq">
          <span><?= $cari_item['invoice_title'] == '' ? mb_substr($cari_item['name'], 0, 1) : mb_substr($cari_item['invoice_title'], 0, 1) ?></span>
        </div>
        <div class="user-info">
          <span class="lead-text"><?= $cari_item['company_type'] == 'person' ? ($cari_item['invoice_title'] != '' ? $cari_item['invoice_title'] : $cari_item['name'] . " " . $cari_item['surname']) : ($cari_item['invoice_title'] != '' ? $cari_item['invoice_title'] : "") ?></span>
          <span class="sub-text"><?= $cari_item['invoice_title'] ?></span>
        </div>

      </div><!-- .user-card -->
    </div><!-- .card-inner -->
    <div class="card-inner">
      <div class="user-account-info py-0">
        <h6 class="overline-title-alt">CARİ DURUMU</h6>
        <div class="user-balance <?= $balanceColor ?>"><?= convert_number_for_form($cari_balance, 2) . "<small>" . $cari_money_unit_icon . "</small>" ?></div>
        <div class="user-balance-sub <?= $balanceColor ?>"><?= $balanceText ?> </div>
      </div>
    </div><!-- .card-inner -->
    <div class="card-inner p-0">
      <ul class="link-list-menu">

        <li><a <?= current_url(true)->getSegment(3) == "detail" ? 'class="active"' : "" ?> href="<?= isset($cari_item['cari_id']) ? route_to('tportal.cariler.detail', $cari_item['cari_id']) : "" ?>"><em class="icon ni ni-user-alt"></em><span>Cari Bilgileri</span></a></li>
        <li><a <?= current_url(true)->getSegment(3) == "financial-movements" ? 'class="active"' : "yok" ?> class="" href="<?= route_to('tportal.cariler.financial_movements', $cari_item['cari_id']) ?>"><em class="icon ni ni-list-thumb"></em><span>Cari Hareketleri</span></a></li>
        <li style="pointer-events:none; opacity:0.6;"><a class="" href="#"><em class="icon ni ni-file-plus"></em><span>Fatura Oluştur</span></a></li>

        <?php $user_modules = session()->get('user_modules'); ?>
        <?php if (array_search('Sevkiyatlar', array_column($user_modules, 'module_title')) != null || strval(array_search('Sevkiyatlar', array_column($user_modules, 'module_title'))) == '0') { ?>
          <li><a <?= current_url(true)->getSegment(3) == "sale_order" ? 'class="active"' : "" ?> class="" href="<?= route_to('tportal.cari.sale_order_create', $cari_item['cari_id']) ?>"><em class="icon ni ni-box"></em><span>Sipariş Oluştur</span></a></li>
        <?php } ?>

        <li><a <?= current_url(true)->getSegment(3) == "payment-or-collection" ? 'class="active"' : "" ?> href="<?= route_to('tportal.cariler.payment_or_collection_create', $cari_item['cari_id']) ?> "><em class="icon ni ni-money"></em><span>Tahsilat / Ödeme Oluştur</span></a></li>
        <li><a <?= current_url(true)->getSegment(3) == "cari_user" ? 'class="active"' : "" ?> href="<?= isset($cari_item['cari_id']) ? route_to('tportal.cariler.user', $cari_item['cari_id']) : "" ?>"><em class="icon ni ni-users"></em><span>Yetkili Bilgileri</span></a></li>
        <li><a <?= current_url(true)->getSegment(3) == "address" ? 'class="active"' : "" ?> href="<?= isset($cari_item['cari_id']) ? route_to('tportal.cariler.address', $cari_item['cari_id']) : "" ?>"><em class="icon ni ni-truck"></em><span>Cari Adresleri</span></a></li>
        <!-- <li><a class="" href="#"><em class="icon ni ni-account-setting-alt"></em><span>Cari Ayarları</span></a></li> -->
        <li><a <?= current_url(true)->getSegment(3) == "edit" ? 'class="active"' : "" ?> href="<?= isset($cari_item['cari_id']) ? route_to('tportal.cariler.edit', $cari_item['cari_id']) : "" ?>"><em class="icon ni ni-edit"></em><span>Cari Düzenle</span></a></li>
        <li><a data-bs-toggle="modal" data-bs-target="#modal_delete_cari" class=" text-danger"><em class="icon ni ni-trash text-danger"></em><span>Cari Sil</span></a></li>

      </ul>
    </div><!-- .card-inner -->
  </div><!-- .card-inner-group -->
</div>

<!-- Modal Alert 2 -->
<div class="modal fade" tabindex="-1" id="mdl_carisil">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body modal-body-lg text-center">
        <div class="nk-modal">
          <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent" style="font-size: 70px;"></em>
          <h4 class="nk-modal-title">Cari Silmek İstediğinize<br>Emin misiniz?</h4>
          <div class="nk-modal-action mb-5">
            <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
            <a href="#" class="btn btn-lg btn-mw btn-danger" data-bs-dismiss="modal">Evet</a>
          </div>
          <div class="nk-modal-text">
            <p class="lead">Bu carinizi silmeniz için;<br>mevcut herhangi bir cari hareketi olmamalıdır.</p>
            <p class="text-soft">Silmeden önce lütfen yetkilinize danışınız.</p>
          </div>
        </div>
      </div><!-- .modal-body -->
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
        <table class="datatable-parabirimi table">
          <thead>
            <tr>
              <th>Birim Adı</th>
              <th>Kodu</th>
              <th>Simgesi</th>
            </tr>
          </thead>
          <tbody>

            <?php if (isset($all_money_unit)) {
              foreach ($all_money_unit as $money_unit) { ?>
                <tr>
                  <td data-order="0">
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" name="radioSize" id="customRadio<?= $money_unit['money_unit_id'] ?>" value="<?= $money_unit['money_unit_id'] ?>" money_code="<?= $money_unit['money_code'] ?>">
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
                      <input type="radio" class="custom-control-input" name="radioSizeAccount" accName="<?= $financial_account_item['account_title']; ?>" accMoneyUnitId="<?= $financial_account_item['money_unit_id']; ?>" accMoneyUnitName="<?= $financial_account_item['money_code']; ?>" id="<?= $financial_account_item['financial_account_id'] ?>" />
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





<?= view_cell(
  'App\Libraries\ViewComponents::getModals',
  [
    'element' => 'cari',
    'modals' => [
      'ok' => [
        'modal_title' => 'İşlem Başarılı!',
        'modal_text' => 'Cari Başarıyla Silindi.',
        'modal_buttons' => '<a href="' . route_to('tportal.cariler.create') . '" class="btn btn-l btn-mw btn-primary">Yeni Cari Ekle</a>
                                    <a href="' . route_to('tportal.cariler.list', 'all') . '" class="btn btn-l btn-mw btn-secondary">Cari Listesine Dön</a>'
      ],
      'delete' => [
        'modal_title' => 'Bu Cariyi Silmek İstediğinize<br>Emin misiniz?',
        'modal_text' => 'Bu cariyi silmeden önce lütfen yetkilinize danışınız.',
      ]
    ],
  ]
); ?>


<?= $this->section('script') ?>

<script>
  $('#modal_delete_cari_button').click(function(e) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
      },
      type: 'POST',
      url: '<?= route_to('tportal.cariler.delete', $cari_item['cari_id']) ?>',
      dataType: 'json',
      async: true,
      success: function(response) {
        if (response['icon'] == 'success') {
          $("#trigger_cari_ok_button").trigger("click");
        } else {
          swetAlert("Bir Şeyler Ters Gitti", response["message"], "err");
        }
      }
    })
  });

  $('#btn_parabirimisec_mdl').click(function() {
    var selectedBaseMoneyCode = $('input[name="radioSize"]:checked').attr('money_code'); //TRY
    var selectedBaseMoneyID = $('input[name="radioSize"]:checked').attr('value');

    $('#moneyUnit').empty().append(selectedBaseMoneyCode);
    $('#money_unit_id').empty().val(selectedBaseMoneyID);
    $('#mdl_parabirimi').modal('hide');

  });

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
</script>

<?= $this->endSection() ?>