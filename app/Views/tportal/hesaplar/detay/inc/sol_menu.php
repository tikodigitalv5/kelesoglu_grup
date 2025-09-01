<?php
$account_balance = $financial_account_item['account_balance'];
$cari_money_unit_icon = $financial_account_item['money_icon'];
$cari_hesap = $financial_account_item["money_code"];
[$balanceColor, $balanceBgColor, $balanceText] = ($account_balance == 0) ? ["text-secondary", "bg-secondary-dim", "-"] : ($account_balance > 0 ? ["text-success", "bg-success-dim", "Borçlu"] : ["text-danger", "bg-danger-dim", "Alacaklı"]);

helper('Helpers\number_format_helper');
?>

<div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg"
  data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
  <div class="card-inner-group" data-simplebar>
    <div class="card-inner">
      <div class="user-card">
        <div class="user-avatar <?= $balanceBgColor ?> sq">
          <span><?= mb_substr($financial_account_item['account_title'], 0, 1) ?></span>
        </div>
        <div class="user-info">
          <span class="lead-text"><?= $financial_account_item['account_title'] ?></span>
          <span
            class="sub-text"><?= $financial_account_item['bank_iban'] != "" ? $financial_account_item['bank_iban'] : "-" ?></span>
        </div>

      </div><!-- .user-card -->
    </div><!-- .card-inner -->
    <div class="card-inner">
      <div class="user-account-info py-0">
        <h6 class="overline-title-alt">Bakiye</h6>
        <div class="user-balance <?= $balanceColor ?> para">
          <?= convert_number_for_form($account_balance, 2) . "<small>" . $cari_money_unit_icon . "</small>" ?>
        </div>
        <div class="user-balance-sub <?= $balanceColor ?>"> <?= $balanceText ?> </div>
      </div>
    </div><!-- .card-inner -->
    <div class="card-inner p-0">
      <ul class="link-list-menu">
        <li><a <?= current_url(true)->getSegment(3) == "detail" ? 'class="active"' : "" ?>
            href="<?= route_to('tportal.financial_accounts.detail', $financial_account_item['financial_account_id']) ?>"><em
              class="icon ni ni-list-thumb"></em><span>Hesap Bilgileri</span></a></li>
        <li><a <?= current_url(true)->getSegment(3) == "financial-movements" ? 'class="active"' : "" ?>
            href="<?= route_to('tportal.financial_accounts.financial_movements', $financial_account_item['financial_account_id']) ?>"><em
              class="icon ni ni-swap"></em><span>Hesap Hareketleri</span></a></li>
        <li><a <?= current_url(true)->getSegment(3) == "payment-or-collection" ? 'class="active"' : "" ?> class=""
            href="<?= route_to('tportal.financial_accounts.payment_or_collection_create', $financial_account_item['financial_account_id']) ?>"><em
              class="icon ni ni-plus-round"></em><span>İşlem Ekle</span></a></li>
        <li><a <?= current_url(true)->getSegment(3) == "edit" ? 'class="active"' : "" ?>
            href="<?= route_to('tportal.financial_accounts.edit', $financial_account_item['financial_account_id']) ?>"><em
              class="icon ni ni-edit"></em><span>Hesap Düzenle</span></a></li>
        <li><a id="deleteAccount" class=" text-danger"><em class="icon ni ni-trash text-danger"></em><span>Hesap
              Sil</span></a></li>

      </ul>
    </div><!-- .card-inner -->
  </div><!-- .card-inner-group -->
</div>

<!-- Modal Alert 2 -->
<!-- <div class="modal fade" tabindex="-1" id="mdl_hesap_sil">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body modal-body-lg text-center">
        <div class="nk-modal">
          <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent" style="font-size: 70px;"></em>
          <h4 class="nk-modal-title">Hesabı Silmek İstediğinize<br>Emin misiniz?</h4>
          <div class="nk-modal-action mb-5">
            <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
            <a href="#" class="btn btn-lg btn-mw btn-danger" data-bs-dismiss="modal">Evet</a>
          </div>
          <div class="nk-modal-text">
            <p class="lead">Bu hesabınızı silmeniz için;<br>mevcut herhangi bir hesap hareketi olmamalıdır.</p>
            <p class="text-soft">Silmeden önce lütfen yetkilinize danışınız.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->


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
                      <input type="radio" class="custom-control-input" name="radioSize"
                        id="customRadio<?= $money_unit['money_unit_id'] ?>" value="<?= $money_unit['money_unit_id'] ?>"
                        money_code="<?= $money_unit['money_code'] ?>">
                      <label class="custom-control-label"
                        for="customRadio<?= $money_unit['money_unit_id'] ?>"><?= $money_unit['money_title'] ?></label>
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
<div class="modal fade" tabindex="-1" id="mdl_hesaplar">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hesap Seçiniz</h5>
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
              foreach ($financial_account_items as $financial_account_item2) { ?>

                <tr <?php if ($financial_account_item2['financial_account_id'] == $financial_account_item['financial_account_id']) {
                  echo "class='d-none'";
                } ?>>
                  <td data-order="0">
                    <div class="custom-control custom-radio"><input type="radio" class="custom-control-input"
                        name="radioSizeAccount" 
                        money_code="<?= $financial_account_item2['money_code']; ?>" 
                        accName="<?= $financial_account_item2['account_title']; ?>"
                        accType="<?= $financial_account_item2['account_type']; ?>"
                        accMoneyUnitId="<?= $financial_account_item2['money_unit_id']; ?>"
                        accMoneyUnitName="<?= $financial_account_item2['money_code']; ?>"
                        id="customRadio_<?= $financial_account_item2['financial_account_id'] ?>"><label
                        class="custom-control-label"
                        for="customRadio_<?= $financial_account_item2['financial_account_id'] ?>"><?= $financial_account_item2['account_title']; ?></label>
                    </div>
                  </td>
                  <td><?php if (isset($bank_items) && $financial_account_item2['bank_id'] != null) {
                    echo $bank_items[array_search($financial_account_item2['bank_id'], array_column($bank_items, 'bank_id'))]['bank_title'];
                  } else {
                    echo " - ";
                  } ?></td>
                  <td><?php switch ($financial_account_item2['account_type']) {
                    case 'vault':
                      echo "Kasa";
                      break;
                    case 'bank':
                      echo "Banka";
                      break;
                    case 'pos':
                      echo "POS";
                      break;
                    case 'credit_card':
                      echo "Kredi Kartı";
                      break;
                  } ?> - <?= $financial_account_item2['money_code'] ?></td>

                </tr>
              <?php }
            } ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer d-block p-3 bg-white">
        <div class="row">
          <div class="col-md-4 p-0">
            <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg btn-dim btn-outline-light"
              data-bs-dismiss="modal" aria-label="Close">KAPAT</button>

          </div>
          <div class="col-md-8 text-end p-0">

            <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ
              HESAP</button>
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
    'element' => 'account',
    'modals' => [
      'ok' => [
        'modal_title' => 'İşlem Başarılı!',
        'modal_text' => 'Hesap Başarıyla Silindi.',
        'modal_buttons' => '<a href="' . route_to('tportal.financial_accounts.create') . '" class="btn btn-l btn-mw btn-primary">Yeni Hesap Ekle</a>
                                    <a href="' . route_to('tportal.financial_accounts.list', 'all') . '" class="btn btn-l btn-mw btn-secondary">Hesaplar Listesine Dön</a>'
      ]
    ],
  ]
); ?>

<?= $this->section('script') ?>

<script>
  var base_url = window.location.origin;

  $('#deleteAccount').click(function (e) {

    Swal.fire({
      title: 'Bu Hesabı Silmek İstediğinize<br>Emin misiniz?',
      html: "Bu hesabı silmeden önce lütfen yetkilinize danışınız",
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
          type: 'POST',
          url: '<?= route_to('tportal.financial_accounts.delete', $financial_account_item['financial_account_id']) ?>',
          dataType: 'json',
          async: true,
          success: function (response) {
            if (response['icon'] == 'success') {
              Swal.fire({
                title: "İşlem Başarılı",
                html: response.message,
                confirmButtonText: "Tamam",
                allowEscapeKey: false,
                allowOutsideClick: false,
                icon: "success",
              }).then(function () {
                // window.location.reload();
                (window.history.length > 1) ? window.history.back() : window.location.href = base_url + "/tportal/financial_account/list/all";
              });
            } else {
              Swal.fire({
                title: "Uyarı",
                html: response.message,
                confirmButtonText: "Tamam",
                allowEscapeKey: false,
                allowOutsideClick: false,
                icon: "warning",
              })
            }
          }
        })

      }
    });

  });


  $('#btn_hesapsec_mdl').click(function() {

var selectedAccount = $('input[name="radioSizeAccount"]:checked').attr('id');
var selectedAccountName = $('input[name="radioSizeAccount"]:checked').attr('accName');
var selectedAccountType = $('input[name="radioSizeAccount"]:checked').attr('accType');
var selectedAccountMoneyId = $('input[name="radioSizeAccount"]:checked').attr('accMoneyUnitId');
var selectedAccountMoneyName = $('input[name="radioSizeAccount"]:checked').attr('accMoneyUnitName');

var secili_transaction_type = $('input[name="transaction_type"]:checked').attr('value');

if(secili_transaction_type == 'payment'){
  $(".check_bill").removeClass("d-none");
}else{
  $(".check_bill").addClass("d-none");
}

if(selectedAccountType == "check_bill"){
  $(".check_bill_var").addClass("d-none");

  $(".check_bill_div").removeClass("d-none");
}else{
  $(".check_bill_div").addClass("d-none");
  $(".check_bill_var").removeClass("d-none");


}


var  musteriParaTipi = '<?php echo $cari_hesap; ?>';

$(".money_kod").html(musteriParaTipi);
$("#kasa_id").val(<?php echo $financial_account_item['financial_account_id']; ?>);

if (selectedAccount != null && selectedAccount != 0) {
 

  if(selectedAccountMoneyName == 'TRY' &&   musteriParaTipi == 'USD'){
  $("#donusturulecek_kur").val(<?php echo $cari_itemd["dolarKur"] ?>);

  }
  if(selectedAccountMoneyName == 'EUR' &&   musteriParaTipi == 'USD'){
  $("#donusturulecek_kur").val(<?php echo $cari_itemd["euroKurCeviri"] ?>);
  }

  if(selectedAccountMoneyName == 'USD' &&   musteriParaTipi == 'EUR'){
  $("#donusturulecek_kur").val(<?php echo $cari_itemd["dolarKurCeviri"] ?>);
  }
  if(musteriParaTipi == 'TRY' &&   selectedAccountMoneyName == 'USD'){
  $("#donusturulecek_kur").val(<?php echo $cari_itemd["dolarKur"] ?>);
  }
  if(musteriParaTipi == 'TRY' &&   selectedAccountMoneyName == 'EUR'){
  $("#donusturulecek_kur").val(<?php echo $cari_itemd["euroKur"] ?>);
  }

  if(musteriParaTipi == 'EUR' &&   selectedAccountMoneyName == 'TRY'){
  $("#donusturulecek_kur").val(<?php echo $cari_itemd["euroKur"] ?>);
  }
  if(musteriParaTipi == 'EUR' &&   selectedAccountMoneyName == 'USD'){
  $("#donusturulecek_kur").val(<?php echo $cari_itemd["euroKurCeviri"] ?>);
  }

  if(musteriParaTipi == 'USD' &&   selectedAccountMoneyName == 'TRY'){
  $("#donusturulecek_kur").val(<?php echo $cari_itemd["dolarKur"] ?>);
  }
  if(musteriParaTipi == 'USD' &&   selectedAccountMoneyName == 'EUR'){
  $("#donusturulecek_kur").val(<?php echo $cari_itemd["dolarKurCeviri"] ?>);
  }

  console.log("selectedAccountMoneyName " + selectedAccountMoneyName);



  // selectedAccount = selectedAccount.substring(11);
  $('#account').empty().val(selectedAccountName);
  $('#financial_account_id').empty().val(selectedAccount);
  $('#selectedAccountType').empty().val(selectedAccountType);
  $('#mdl_hesaplar').modal('hide');

  $('#moneyUnit').empty().append(selectedAccountMoneyName);

  $("#islem_kuru").val(selectedAccountMoneyName);


  if(selectedAccountMoneyName == '<?php echo $cari_hesap; ?>'){
      $(".para_birimi_icin_ac").addClass("d-none");


  }else if(selectedAccountMoneyName == 'USD'){
    $(".para_birimi_icin_ac").removeClass("d-none");  

   


    
  }
  else if(selectedAccountMoneyName == 'EUR'){
    $(".para_birimi_icin_ac").removeClass("d-none");



  



  }else if(selectedAccountMoneyName == 'TRY'){
    $(".para_birimi_icin_ac").removeClass("d-none");

   

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
// Girilen değeri doğru işlemek için önce binlik virgülleri kaldırıyoruz
var transactionAmount = parseFloat($("#transaction_amount").val().replace(/\./g, '').replace(",", ".")) || 0;

// Kur değerini de düzgün işlemek için ondalık ayraçları noktaya çeviriyoruz (ama burada binlik ayracı zaten yok)
var exchangeRate = parseFloat($("#donusturulecek_kur").val().replace(",", ".")) || 0;


console.log("transactionAmount " + transactionAmount);
console.log("exchangeRate " + exchangeRate);


      

if(selectedAccountMoneyName == 'TRY' &&   musteriParaTipi == 'USD'){


  $("#donusturulecek_kur").val(<?php echo $cari_itemd["dolarKur"] ?>);

     
      var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'TRY' &&   musteriParaTipi == 'EUR'){


$("#donusturulecek_kur").val(<?php echo $cari_itemd["euroKur"] ?>);


var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'USD' &&   musteriParaTipi == 'EUR'){


$("#donusturulecek_kur").val(<?php echo $cari_itemd["dolarKurCeviri"] ?>);


var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'EUR' &&   musteriParaTipi == 'USD'){


$("#donusturulecek_kur").val(<?php echo $cari_itemd["euroKurCeviri"] ?>);


var total = (transactionAmount / exchangeRate).toFixed(2);

}else{
      var total = (transactionAmount * exchangeRate).toFixed(2);

}

// Calculate the total

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
if(selectedAccountMoneyName == 'TRY' &&   musteriParaTipi == 'USD'){


     
      var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'TRY' &&   musteriParaTipi == 'EUR'){




var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'USD' &&   musteriParaTipi == 'EUR'){




var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'EUR' &&   musteriParaTipi == 'USD'){




var total = (transactionAmount / exchangeRate).toFixed(2);

}else{
      var total = (transactionAmount * exchangeRate).toFixed(2);

}

// Convert the result back to a string with a comma as the decimal separator
var formattedTotal = total.replace(".", ",");

// Update the #toplam_kur input with the formatted result
$("#toplam_kur").val(formattedTotal);
});

});


  


</script>

<?= $this->endSection() ?>