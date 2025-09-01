<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Cari Detay
<?= $this->endSection() ?>
<?= $this->section('title') ?> Cari Detay | 
<?php echo $cari_item['invoice_title'] ?? $cari_item["name"]  . " " . $cari_item["surname"] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>
<?php 

$cari_balance = $cari_item['cari_balance'];
$cari_money_unit_icon = $cari_item['money_icon'];

[$balanceColor, $balanceBgColor, $balanceText] = ($cari_balance == 0) ? ["text-secondary", "bg-secondary-dim", "-"] : ($cari_balance > 0 ? ["text-success", "bg-success-dim", "Borçlu"] : ["text-danger", "bg-danger-dim", "Alacaklı"]);

helper('Helpers\number_format_helper');

?>


<?= $this->section('main') ?>


<style>
.dataTables_wrapper {
    width: 100%; /* Tablonun genişliği yüzde 100 olacak şekilde ayarlanır */
    overflow-x: auto; /* Eğer tablo genişlerse yatay kaydırma çıkar */
}

table.dataTable {
    table-layout: auto; /* Tablo sütun genişliği içeriğe göre ayarlanacak */
    width: 100%; /* Tablonun genişliği yüzde 100 olacak */
}

    
    .dataTables_length, .dataTables_filter, .datatable-filter{
        display: block!important;

    }
    .with-export{
        display: flex!important;
        margin-bottom:20px;
        margin-right: 10px;

    }
    .dataTables_length .form-control-select{
        display: block!important;
    }
    .dataTables_length span{
        display:block!important;
    }

tr.bg-danger-dim:hover {
    background-color: #ffcdd2 !important; /* Hover durumunda biraz daha koyu ton */
}

tr.bg-danger-dim td {
    color: #c62828; /* Metin rengi biraz daha koyu kırmızı */
}

.ni-cross-circle-fill {
    margin-left: 5px;
    font-size: 16px;
    color: #d32f2f;
}
</style>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap">
                        <div class="card-inner card-inner-lg">
                        <div class="card mb-4">
                            <div class="nk-block-head nk-block-head-lg">
                            <div class="card-inner-group" style="display: flex ; align-items: center; justify-content: space-between;">
                            <div class="card-inner" style="border-bottom:0;">
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
    <div class="card-inner" style="display: flex; align-items: center; justify-content: space-between;">
      <div class="user-account-info py-0">
        <h6 class="overline-title-alt">CARİ DURUMU</h6>
      
        <div class="user-balance <?= $balanceColor ?> para"><?= convert_number_for_form($cari_balance, 2) . "<small>" . $cari_money_unit_icon . "</small>" ?></div>
        <div class="user-balance-sub <?= $balanceColor ?>"><?= $balanceText ?> </div>

      </div>
      <div>
        <a href="<?= route_to('tportal.cariler.financial_movements', $cari_item['cari_id']) ?>" class="btn btn-sm btn-primary"><em class="icon ni ni-arrow-left"></em><span>Cariye Geri Dön</span></a>
      </div>
    </div><!-- .card-inner -->
    </div><!-- .card-inner -->
                        
                              
                            </div><!-- .nk-block-head -->
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">
                                <div class="nk-data data-list">


                                    <table class="datatable-init-hareketler nowrap table">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2;">Tarih</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">İşlem</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Fatura/İşlem No</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Durum</th>
                                                <th style="background-color: #ebeef2; width:5px; "
                                                    data-orderable="false">Bilgi</th>
                                                <th style="background-color: #ebeef2; text-align: right;" data-orderable="false">Tutar</th>
                                                <th style="background-color: #ebeef2; text-align: right;" data-orderable="false">Bakiye  </th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">...</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
// Başlangıç bakiyesi veritabanından alınan cari bakiye
$temp_balance = 0; // Cari bakiyeyi başlangıç olarak alıyoruz.

// Toplam borç ve alacak için değişkenler
$total_debt = 0; // Toplam borç
$total_credit = 0; // Toplam alacak

// İşlem listesi sırayla işlenecek
foreach ($financial_movement_items as $financial_movement_item) {
    // ÖNCE bakiye hesaplaması yapılıyor
    if($financial_movement_item["money_unit_id"] == $cari_item["money_unit_id"]){
        $transaction_amounts = ($financial_movement_item['virman'] != '' && $financial_movement_item['virman'] != 0 ) ? $financial_movement_item['virman'] : $financial_movement_item['transaction_amount'];
    }else{
        if($financial_movement_item["money_unit_id"] != 3){
            $movementFiyat = $financial_movement_item["amount_to_be_paid_try"];
        }else{
            $movementFiyat = $financial_movement_item["amount_to_be_paid"];
        }
        $transaction_amounts = ($financial_movement_item['virman'] != '' && $financial_movement_item['virman'] != 0 ) ? $financial_movement_item['virman'] : $movementFiyat;
    }

    // İşlem türüne göre bakiyeyi ve toplam borç/alacakları güncelleme
    if($financial_movement_item['invoice_status_title'] != "İptal Edildi" && $financial_movement_item['invoice_status_title'] != "Reddedildi" && $financial_movement_item['invoice_status_title'] != "Red Edildi"){
        switch ($financial_movement_item['transaction_type']) {
        case 'incoming_invoice':  // Giden fatura: Borç (çıkış işlemi)
        case 'collection':        // Ödeme: Borç
        case 'borc_alacak':       // Borç/Alacak (negatifse borç, pozitifse alacak)
            $temp_balance -= $transaction_amounts;
            $total_debt += $transaction_amounts; // Borç ekle
            break;
    
        case 'outgoing_invoice':  // Alış faturası: Alacak (giriş işlemi)
        case 'payment':           // Tahsilat: Alacak
            $temp_balance += $transaction_amounts;
            $total_credit += $transaction_amounts; // Alacak ekle
            break;
    
        case 'starting_balance': // Başlangıç bakiyesi
            if ($transaction_amounts < 0) {
                $temp_balance -= abs($transaction_amounts);
                $total_debt += abs($transaction_amounts);
            } else {
                $temp_balance += $transaction_amounts;
                $total_credit += $transaction_amounts;
            }
            break;
            case 'check_bill':
                if($financial_movement_item['transaction_direction'] == "entry"){
                 $temp_balance -= $transaction_amounts;
                 $total_debt += $transaction_amounts;
                }else{
                
                 $temp_balance += $transaction_amounts;
                 $total_credit += $transaction_amounts;
                }
     
                break; // Bu break eksikti
    }
    }

    // SONRA ekrana yazdırma işlemleri
    ?>
 <tr <?php if($financial_movement_item['invoice_status_title'] == "İptal Edildi" || $financial_movement_item['invoice_status_title'] == "Reddedildi" || $financial_movement_item['invoice_status_title'] == "Red Edildi"): ?> 
    style="background-color: #ffebee !important;" 
    class="bg-danger-dim"
    <?php endif; ?>>
    <td data-order="<?= $financial_movement_item['transaction_date'] ?> . <?= $financial_movement_item['financial_movement_id'] ?>"
        title="<?= $financial_movement_item['transaction_date'] ?>">
        <?= date("d/m/Y", strtotime($financial_movement_item['transaction_date'])) ?>
        <?php if($financial_movement_item['invoice_status_title'] == "İptal Edildi" || $financial_movement_item['invoice_status_title'] == "Reddedildi" || $financial_movement_item['invoice_status_title'] == "Red Edildi"): ?>
            <em class="icon ni ni-cross-circle-fill text-danger" 
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="<?= $financial_movement_item['invoice_status_title'] ?>">
            </em>
        <?php endif; ?>
    </td>

        <td><span class="tb-status">
    <?= ($financial_movement_item['virman'] != '' && $financial_movement_item['virman'] != 0) ? "<b>" : '' ?>
    <?= $transaction_types[$financial_movement_item['transaction_type']] ?> 
    <?php if($financial_movement_item['transaction_type'] == 'check_bill'): ?>
        <?php if($financial_movement_item['transaction_direction'] == "entry"): ?>
            <em class="icon ni ni-arrow-down-left text-success" data-bs-toggle="tooltip" title="Giriş"></em>
        <?php else: ?>
            <em class="icon ni ni-arrow-up-right text-danger" data-bs-toggle="tooltip" title="Çıkış"></em>
        <?php endif; ?>
    <?php endif; ?>
    <?= ($financial_movement_item['virman'] != '' && $financial_movement_item['virman'] != 0) ? " - Virman</b>" : '' ?>
</span></td>   
       
<td>
            <?php if(isset($financial_movement_item['fatura_id'])): ?>
                <a href="<?= route_to('tportal.faturalar.detail', $financial_movement_item['fatura_id']) ?>" target="_blank"><?= $financial_movement_item['invoice_no'] ?></a>
            <?php else: ?>
                <?= $financial_movement_item['transaction_number'] ?>
            <?php endif; ?>
        </td>

        <td>
            <?php  if($financial_movement_item['invoice_status_title_info'] != ""): ?>
        <span class="tb-lead">
                      
        <span class="dot dot-<?= $financial_movement_item['invoice_status_title_info'] ?> ms-1"></span>  <?= $financial_movement_item['invoice_status_title'] ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
        </span>
        <?php else: ?>
            <span class="tb-lead" style="text-transform: uppercase;">
                      
                      <span class="dot dot-primary ms-1"></span> &nbsp; <?= $transaction_types[$financial_movement_item['transaction_type']] ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
                      </span>
           
        <?php endif; ?>
        </td>


        <td style="max-width: 120px !important; width:120px !important; overflow:hidden; text-overflow:ellipsis"
            width="120" data-bs-toggle="tooltip" data-bs-placement="top"
            data-bs-title="<?= $financial_movement_item['transaction_title'] ?>">
            <?= $financial_movement_item['transaction_title'] ?>
        </td>

        <td class="text-end para">
            <?php 
            $transaction_amounts_satir = 0;
            if($financial_movement_item["money_unit_id"] == $cari_item["money_unit_id"]){
                $transaction_amounts_satir = $financial_movement_item['transaction_amount'];
            }else{
                if($financial_movement_item["money_unit_id"] != 3){
                    $transaction_amounts_satir = $financial_movement_item["amount_to_be_paid_try"];
                }else{
                    $transaction_amounts_satir = $financial_movement_item["amount_to_be_paid"];
                }
            }

            if ($financial_movement_item["virman"] != 0) {
                echo convert_number_for_form($financial_movement_item['virman'], 2) . " " . $cari_item['money_icon'];
                echo " (" . convert_number_for_form($financial_movement_item['transaction_amount'], 2) . " " . $financial_movement_item['money_icon'] . ")";
            } else {
                if (isset($financial_movement_item["is_return"])) {
                    echo convert_number_for_form($financial_movement_item['tedarik_price'], 2) . " " . $financial_movement_item['money_icon'];
                } else {
                    echo convert_number_for_form($financial_movement_item['transaction_amount'], 2) . " " . $financial_movement_item['money_icon'];
                    if($financial_movement_item["money_unit_id"] != $cari_item["money_unit_id"]){
                        echo " (" . convert_number_for_form($transaction_amounts_satir, 2) . " " . $cari_item['money_icon'] . ")";
                    }
                }
            }
            ?>
        </td>

        <!-- Güncel bakiye gösterimi -->
        <td class="text-end para <?= $temp_balance < 0 ? 'text-danger' : ''; ?> <?= $temp_balance > 0 ? 'text-success' : ''; ?>">
            <?= convert_number_for_form($temp_balance, 2) ?>
            <?= $cari_item['money_icon'] ?>
        </td>

        <!-- Detay butonları -->
        <td>
            <?php if ($financial_movement_item['transaction_type'] == 'collection' || $financial_movement_item['transaction_type'] == 'payment' || $financial_movement_item['transaction_type'] == 'incoming_gider' ||  $financial_movement_item['transaction_type'] == 'outgoing_gider') { ?>
                <a href="<?= route_to('tportal.cariler.payment_or_collection_edit', $financial_movement_item['financial_movement_id']) ?>"
                    class="btn btn-icon btn-xs btn-dim btn-outline-dark"
                    id="btnPrintBarcode" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="Görüntüle"><em
                        class="icon ni ni-arrow-right"></em></a>
            <?php } else if (isset($financial_movement_item['invoice_id']) && ($financial_movement_item['invoice_id'] != null)) { 
                if ($financial_movement_item['sale_type'] == 'detailed') { ?>
                    <a href="<?= route_to('tportal.faturalar.detail', $financial_movement_item['invoice_id']) ?>"
                        class="btn btn-icon btn-xs btn-dim btn-outline-dark"
                        id="btnPrintBarcode" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="Faturayı Görüntüle"><em
                            class="icon ni ni-arrow-right"></em></a>

                    <?php if(isset($financial_movement_item['tiko_id']) && $financial_movement_item['tiko_id'] == 0): ?>
                    <button type="button"
                        class="btn btn-icon btn-xs btn-dim btn-outline-danger deleteInvoice"
                        id="btnDeleteInvoice"
                        data-invoice-id="<?= $financial_movement_item['invoice_id'] ?>"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Faturayı Sil"><em
                                class="icon ni ni-trash-empty"></em></button>
                    <?php endif; ?>
                <?php } else if ($financial_movement_item['sale_type'] == 'quick') { ?>
                    <a href="<?= route_to('tportal.cari.quick_sale_order.detail', $financial_movement_item['invoice_id']) ?>"
                        class="btn btn-icon btn-xs btn-dim btn-outline-dark"
                        id="btnPrintBarcode" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="Görüntüle"><em
                            class="icon ni ni-arrow-right"></em></a>
                <?php } ?>
            <?php } ?>
        </td>
    </tr>
    <?php
}
?>
<!-- Toplam Borç ve Alacakları Göster -->
<div class="totals d-none">
    <p><strong>Toplam Borç:</strong> <?= convert_number_for_form($total_debt, 2) ?> <?= $cari_item['money_icon'] ?></p>
    <p><strong>Toplam Alacak:</strong> <?= convert_number_for_form($total_credit, 2) ?> <?= $cari_item['money_icon'] ?></p>
</div>

                                     
                                        </tbody>
                                    </table>
                                </div><!-- data-list -->

                            </div><!-- .nk-block -->
                        </div>

                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>





<?= $this->endSection() ?>

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
     

      if(selectedAccountMoneyName == 'TRY' &&   musteriParaTipi == 'USD'){
      $("#donusturulecek_kur").val(<?php echo $cari_item["dolarKur"] ?>);

      }
      if(selectedAccountMoneyName == 'EUR' &&   musteriParaTipi == 'USD'){
      $("#donusturulecek_kur").val(<?php echo $cari_item["euroKurCeviri"] ?>);
      }

      if(selectedAccountMoneyName == 'USD' &&   musteriParaTipi == 'EUR'){
      $("#donusturulecek_kur").val(<?php echo $cari_item["dolarKurCeviri"] ?>);
      }
      if(musteriParaTipi == 'TRY' &&   selectedAccountMoneyName == 'USD'){
      $("#donusturulecek_kur").val(<?php echo $cari_item["dolarKur"] ?>);
      }
      if(musteriParaTipi == 'TRY' &&   selectedAccountMoneyName == 'EUR'){
      $("#donusturulecek_kur").val(<?php echo $cari_item["euroKur"] ?>);
      }

      if(musteriParaTipi == 'EUR' &&   selectedAccountMoneyName == 'TRY'){
      $("#donusturulecek_kur").val(<?php echo $cari_item["euroKur"] ?>);
      }
      if(musteriParaTipi == 'EUR' &&   selectedAccountMoneyName == 'USD'){
      $("#donusturulecek_kur").val(<?php echo $cari_item["euroKurCeviri"] ?>);
      }

      if(musteriParaTipi == 'USD' &&   selectedAccountMoneyName == 'TRY'){
      $("#donusturulecek_kur").val(<?php echo $cari_item["dolarKur"] ?>);
      }
      if(musteriParaTipi == 'USD' &&   selectedAccountMoneyName == 'EUR'){
      $("#donusturulecek_kur").val(<?php echo $cari_item["dolarKurCeviri"] ?>);
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

    $('document').ready(function () {
        var myVar = $("#DataTables_Table_1_wrapper").find('.with-export').removeClass('d-none');
        var myVar2 = $("#DataTables_Table_1_wrapper").find('.with-export').css("margin-bottom", "10px");
        var base_url = window.location.origin;

        $(document).on("click", "#btnDeleteInvoice", function () {
            var invoice_id = $(this).attr('data-invoice-id');
            console.log(invoice_id);


            Swal.fire({
                    title: 'Fatura hareketini silmek üzeresiniz!',
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
                            type: "POST",
                            url: base_url + '/tportal/invoice/delete/' + invoice_id,
                            async: true,
                            datatype: "json",
                            success: function(response, data) {
                                dataa = JSON.parse(response);
                                if (dataa.icon === "success") {
                                    console.log(response);
                                    console.log(data);
                                    Swal.fire({
                                            title: "İşlem Başarılı",
                                            html: 'Fatura silme işlemi başarıyla gerçekleşti.',
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
                                        text: dataa.message,
                                        confirmButtonText: "Tamam",
                                        allowEscapeKey: false,
                                        allowOutsideClick: false,
                                        icon: "error",
                                    })
                                }
                            },
                            error: function () {
                                swetAlert("Hata!", "bir şeyler ters gitti", "err");
                            }
                        });

                    } else if (result.isCancel) {
                        Swal.fire('Değişiklikler kaydedilmedi', '', 'info')
                    }
                });
        });

    });
</script>

<?= $this->endSection() ?>