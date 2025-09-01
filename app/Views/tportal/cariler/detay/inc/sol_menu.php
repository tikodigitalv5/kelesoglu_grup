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
          <span class="lead-text"><?= $cari_item['invoice_title'] != '' ? $cari_item['invoice_title'] : $cari_item['name'] . " " . $cari_item['surname'] ?></span>
          <span class="sub-text"><?= $cari_item['invoice_title'] ?></span>
        </div>

      </div><!-- .user-card -->
    </div><!-- .card-inner -->
    <div class="card-inner">
      <div class="user-account-info py-0">
        <h6 class="overline-title-alt">CARİ DURUMU</h6>
      
        <div class="user-balance <?= $balanceColor ?> para"><?= convert_number_for_form($cari_balance, 2) . "<small>" . $cari_money_unit_icon . "</small>" ?></div>
        <div class="user-balance-sub <?= $balanceColor ?>"><?= $balanceText ?> </div>

      </div>
    </div><!-- .card-inner -->
    <div class="card-inner p-0">
      <ul class="link-list-menu">
      <li><a href="#" id="exportReport" class="text-success" style="color:#0a3c27!important;"><em style="color:#0a3c27!important;" class="icon ni ni-file-xls text-success"></em><span>Cari Excel İndir</span></a></li>
        <li><a id="bakiyeGuncelle" style="cursor:pointer;"><em class="icon ni ni-wallet-fill"></em><span>Bakiye Güncelle</span></a></li>
        <li><a <?= current_url(true)->getSegment(3) == "detail" ? 'class="active"' : "" ?> href="<?= isset($cari_item['cari_id']) ? route_to('tportal.cariler.detail', $cari_item['cari_id']) : "" ?>"><em class="icon ni ni-user-alt"></em><span>Cari Bilgileri</span></a></li>
        <li><a <?= current_url(true)->getSegment(3) == "financial-movements" ? 'class="active"' : "yok" ?> class="" href="<?= route_to('tportal.cariler.financial_movements', $cari_item['cari_id']) ?>"><em class="icon ni ni-list-thumb"></em><span>Cari Hareketleri</span></a></li>
        <li><a <?= current_url(true)->getSegment(3) == "offer-movements" ? 'class="active"' : "yok" ?> class="" href="<?= route_to('tportal.cariler.offer_movements', $cari_item['cari_id']) ?>"><em class="icon ni ni-folder-list"></em><span>Teklif Hareketleri</span></a></li>
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
                      <input type="radio" class="custom-control-input" name="radioSizeAccount" accType="<?= $financial_account_item['account_type']; ?>"   accName="<?= $financial_account_item['account_title']; ?>" accMoneyUnitId="<?= $financial_account_item['money_unit_id']; ?>" accMoneyUnitName="<?= $financial_account_item['money_code']; ?>" id="<?= $financial_account_item['financial_account_id'] ?>" />
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


  $('input[name="transaction_type"]').change(function(){
      $('#account').val('');
      $('#financial_account_id').empty();
      $('#selectedAccountType').empty();
      $(".check_bill").addClass("d-none");
      $(".check_bill_div").addClass("d-none");
      $(".check_bill_var").removeClass("d-none");

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


    var  musteriParaTipi = '<?php echo $cari_item["money_code"] ?>';


    if (selectedAccount != null && selectedAccount != 0) {
     

   // Müşteri para birimi ve hesap para birimi kıyaslamaları
if (selectedAccountMoneyName == 'TRY' && musteriParaTipi == 'USD') {
    $("#donusturulecek_kur").val(<?php echo $cari_item["dolarKur"] ?>);
}
if (selectedAccountMoneyName == 'EUR' && musteriParaTipi == 'USD') {
    $("#donusturulecek_kur").val(<?php echo number_format($cari_item["euroKurCeviri"], 2, '.', '') ?>);
}
if (selectedAccountMoneyName == 'USD' && musteriParaTipi == 'EUR') {
    $("#donusturulecek_kur").val(<?php echo number_format($cari_item["dolarKurCeviri"], 2, '.', '') ?>);
}
if (musteriParaTipi == 'TRY' && selectedAccountMoneyName == 'USD') {
    $("#donusturulecek_kur").val(<?php echo number_format($cari_item["dolarKur"], 2, '.', '') ?>);
}
if (musteriParaTipi == 'TRY' && selectedAccountMoneyName == 'EUR') {
    $("#donusturulecek_kur").val(<?php echo number_format($cari_item["euroKur"], 2, '.', '') ?>);
}
if (musteriParaTipi == 'EUR' && selectedAccountMoneyName == 'TRY') {
    $("#donusturulecek_kur").val(<?php echo number_format($cari_item["euroKur"], 2, '.', '') ?>);
}
if (musteriParaTipi == 'EUR' && selectedAccountMoneyName == 'USD') {
    $("#donusturulecek_kur").val(<?php echo number_format($cari_item["euroKurCeviri"], 2, '.', '') ?>);
}
if (musteriParaTipi == 'USD' && selectedAccountMoneyName == 'TRY') {
    $("#donusturulecek_kur").val(<?php echo number_format($cari_item["dolarKur"], 2, '.', '') ?>);
}
if (musteriParaTipi == 'USD' && selectedAccountMoneyName == 'EUR') {
    $("#donusturulecek_kur").val(<?php echo number_format($cari_item["dolarKurCeviri"], 2, '.', '') ?>);
}

      console.log("selectedAccountMoneyName " + selectedAccountMoneyName);



      // selectedAccount = selectedAccount.substring(11);
      $('#account').empty().val(selectedAccountName);
      $('#financial_account_id').empty().val(selectedAccount);
      $('#selectedAccountType').empty().val(selectedAccountType);
      $('#mdl_hesaplar').modal('hide');

      $('#moneyUnit').empty().append(selectedAccountMoneyName);

      $("#islem_kuru").val(selectedAccountMoneyName);


      if(selectedAccountMoneyName == '<?php echo $cari_item["money_code"] ?>'){
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


      $("#donusturulecek_kur").val(<?php echo $cari_item["dolarKur"] ?>);

         
          var total = (transactionAmount / exchangeRate).toFixed(2);

    }else if(selectedAccountMoneyName == 'TRY' &&   musteriParaTipi == 'EUR'){


$("#donusturulecek_kur").val(<?php echo $cari_item["euroKur"] ?>);

   
    var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'USD' &&   musteriParaTipi == 'EUR'){


$("#donusturulecek_kur").val(<?php echo $cari_item["dolarKurCeviri"] ?>);

   
    var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'EUR' &&   musteriParaTipi == 'USD'){


$("#donusturulecek_kur").val(<?php echo $cari_item["euroKurCeviri"] ?>);

   
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



  $("#bakiyeGuncelle").click(function(){

    Swal.fire({
    title: '<?php echo $cari_item["invoice_title"] ?? $cari_item["name"] ?> Kullanıcısının  Bakiyesini Güncelle',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet,Güncelle',
    cancelButtonText: 'Hayır',
    }).then((result) => {
    if (result.isConfirmed) {
   
   
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.faturalar.bakiyeHesapla', $cari_item["cari_id"]) ?>',
                dataType: 'json',
                data: { },
                async: true,
                success: function (response) {
                  Swal.fire({
                            title: 'Devam',
                            icon: 'success',
                            html: 'Bakiye Başarıyla Güncellendi.',
                            showCancelButton: false,
                            confirmButtonText: 'Kapat',
                        }).then(function (result) {
                            location.reload();
                        });
                },
                error: function (error) {
                  Swal.fire({
                            title: 'Devam',
                            icon: 'success',
                            html: 'Bakiye Başarıyla Güncellendi.',
                            showCancelButton: false,
                            confirmButtonText: 'Kapat',
                        }).then(function (result) {
                            location.reload();
                        });
                }
            })
   
   
   
   
    } 
    });


  });


$("#exportReport").click(function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: '<h4 class="text-dark">Rapor Oluştur</h4>',
        width: '450px',
        padding: '0',
        icon: null,
        html: `
            <div class="container p-0">
                <div class="card border-0">
                    <div class="card-body p-4">
                        <!-- Rapor Türü -->
                        <div class="form-group mb-4">
                            <label class="small text-muted mb-3">RAPOR TÜRÜ</label>
                            <div class="d-flex gap-3" style="height: auto !important;">
                                <div class="form-check custom-option custom-option-basic checked" style="flex:1">
                                    <input type="radio" id="normalReport" name="reportType" class="form-check-input" value="normal" checked>
                                    <label class="form-check-label d-flex align-items-center" for="normalReport">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-wrap me-2">
                                                <em class="icon ni ni-file-text fs-4 text-primary"></em>
                                            </div>
                                            <div class="info">
                                                <span class="fw-medium">Normal Rapor</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check custom-option custom-option-basic" style="flex:1">
                                    <input type="radio" id="detailedReport" name="reportType" class="form-check-input" value="detailed">
                                    <label class="form-check-label d-flex align-items-center" for="detailedReport">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-wrap me-2">
                                                <em class="icon ni ni-files fs-4 text-primary"></em>
                                            </div>
                                            <div class="info">
                                                <span class="fw-medium">Detaylı Rapor</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dosya Formatı -->
                        <div class="form-group mb-4">
                            <label class="small text-muted mb-3">DOSYA FORMATI</label>
                            <div class="d-flex gap-3" style="height: auto !important;">
                                <div class="form-check custom-option custom-option-basic checked" style="flex:1">
                                    <input type="radio" id="excelFormat" name="fileFormat" class="form-check-input" value="excel" checked>
                                    <label class="form-check-label d-flex align-items-center" for="excelFormat">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-wrap me-2">
                                                <em class="icon ni ni-file-xls fs-4 text-success"></em>
                                            </div>
                                            <div class="info">
                                                <span class="fw-medium">Excel</span>
                                                <small class="d-block text-muted">.xlsx</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check custom-option custom-option-basic" style="flex:1">
                                    <input type="radio" id="pdfFormat" name="fileFormat" class="form-check-input" value="pdf">
                                    <label class="form-check-label d-flex align-items-center" for="pdfFormat">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-wrap me-2">
                                                <em class="icon ni ni-file-pdf fs-4 text-danger"></em>
                                            </div>
                                            <div class="info">
                                                <span class="fw-medium">PDF</span>
                                                <small class="d-block text-muted">.pdf</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Tarih Aralığı -->
                        <div class="form-group">
                            <label class="small text-muted mb-3">TARİH ARALIĞI</label>
                            <select class="form-select form-select-lg shadow-none" id="dateRange">
                                <option value="7">Son 7 Gün</option>
                                <option value="15">Son 15 Gün</option>
                                <option value="30">Son 30 Gün</option>
                                <option value="90">Son 3 Ay</option>
                                <option value="180">Son 6 Ay</option>
                                <option value="all">Tümü</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '<em class="ni ni-download me-1"></em> İndir',
        cancelButtonText: 'İptal',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-light',
            container: 'custom-swal-container'
        },
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const reportType = $('input[name="reportType"]:checked').val();
            const fileFormat = $('input[name="fileFormat"]:checked').val();
            const dateRange = $('#dateRange').val();
            let url = '';
            
            if(reportType === 'detailed') {
                url = '<?= base_url('tportal/cari/exportDetayliCariFull/'.$cari_item['cari_id'].'/') ?>' + dateRange + '/' + fileFormat;
            } else {
                url = '<?= base_url('tportal/cari/exportDetayliCari/'.$cari_item['cari_id'].'/') ?>' + dateRange + '/' + fileFormat;
            }
            
            // İndirme başlamadan önce yükleniyor göstergesi
            Swal.fire({
                title: 'Rapor Hazırlanıyor',
                html: `
                    <div class="d-flex flex-column align-items-center">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Yükleniyor...</span>
                        </div>
                        <div class="text-muted">Lütfen bekleyiniz...</div>
                    </div>
                `,
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Dosyayı indir
            window.location.href = url;
            
            // Kısa bir süre sonra yükleniyor göstergesini kapat
            setTimeout(() => {
                Swal.close();
                // İndirme başarılı bildirimi
                Swal.fire({
                    title: 'Başarılı!',
                    text: 'Raporunuz indiriliyor...',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            }, 2000);
        }
    });
});

// Özel CSS stilleri
$("<style>")
    .prop("type", "text/css")
    .html(`
        .custom-swal-container {
            font-family: 'DM Sans', sans-serif;
        }
        .custom-option {
            position: relative;
            padding: 0;
            margin: 0;
        }
        .custom-option .form-check-input {
            position: absolute;
            opacity: 0;
        }
        .custom-option .form-check-label {
            padding: 0.75rem 1rem;
            border: 1px solid #e5e9f2;
            border-radius: 0.375rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .custom-option .form-check-input:checked + .form-check-label {
            border-color: #0971fe;
            background-color: #f3f7fe;
        }
        .custom-option .icon-wrap {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-select {
            padding: 0.6rem 1rem;
            border-color: #e5e9f2;
            font-size: 0.9rem;
        }
        .form-select:focus {
            border-color: #0971fe;
            box-shadow: 0 0 0 0.2rem rgba(9, 113, 254, 0.25);
        }
        .swal2-title {
            padding: 1.5rem 1.5rem 0.5rem !important;
            border-bottom: 1px solid #e5e9f2;
        }
        .swal2-html-container {
            margin: 0 !important;
        }
        .swal2-actions {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e9f2;
            margin: 0 !important;
        }
        .btn {
            padding: 0.6rem 1.5rem;
            font-weight: 500;
        }
        .small {
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
    `)
    .appendTo("head");

// ... existing code ...
</script>


<?= $this->endSection() ?>