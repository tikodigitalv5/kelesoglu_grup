
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?= $invoice_item['cari_invoice_title'] ?> -  <?= $invoice_item['invoice_date'] ?></title>
    <style type="text/css">
      body {
        background-color: #FFFFFF;
        font-family: 'Tahoma', "Times New Roman", Times, serif;
        font-size: 11px;
        color: #666666;
      }

      h1,
      h2 {
        padding-bottom: 3px;
        padding-top: 3px;
        margin-bottom: 5px;
        text-transform: uppercase;
        font-family: Arial, Helvetica, sans-serif;
      }

      h1 {
        font-size: 1.4em;
        text-transform: none;
      }

      h2 {
        font-size: 1em;
        color: brown;
      }

      h3 {
        font-size: 1em;
        color: #333333;
        text-align: justify;
        margin: 0;
        padding: 0;
      }

      h4 {
        font-size: 1.1em;
        font-style: bold;
        font-family: Arial, Helvetica, sans-serif;
        color: #000000;
        margin: 0;
        padding: 0;
      }

      hr {
        height: 2px;
        color: #000000;
        background-color: #000000;
        border-bottom: 1px solid #000000;
      }

      p,
      ul,
      ol {
        margin-top: 1.5em;
      }

      ul,
      ol {
        margin-left: 3em;
      }

      blockquote {
        margin-left: 3em;
        margin-right: 3em;
        font-style: italic;
      }

      a {
        text-decoration: none;
        color: #70A300;
      }

      a:hover {
        border: none;
        color: #70A300;
      }

      #despatchTable {
        border-collapse: collapse;
        font-size: 11px;
        float: right;
        border-color: gray;
      }

      #ettnTable {
        border-collapse: collapse;
        font-size: 11px;
        border-color: gray;
      }

      #customerPartyTable {
        border-width: 0px;
        border-spacing: ;
        border-style: inset;
        border-color: gray;
        border-collapse: collapse;
        background-color:
      }

      #customerIDTable {
        border-width: 2px;
        border-spacing: ;
        border-style: inset;
        border-color: gray;
        border-collapse: collapse;
        background-color:
      }

      #customerIDTableTd {
        border-width: 2px;
        border-spacing: ;
        border-style: inset;
        border-color: gray;
        border-collapse: collapse;
        background-color:
      }

      #lineTable {
        border-width: 2px;
        border-spacing: ;
        border-style: inset;
        border-color: black;
        border-collapse: collapse;
        background-color: ;
      }

      #lineTableTd {
        border-width: 1px;
        padding: 1px;
        border-style: inset;
        border-color: black;
        background-color: white;
      }

      #lineTableTr {
        border-width: 1px;
        padding: 0px;
        border-style: inset;
        border-color: black;
        background-color: white;
        -moz-border-radius: ;
      }

      #lineTableDummyTd {
        border-width: 1px;
        border-color: white;
        padding: 1px;
        border-style: inset;
        border-color: black;
        background-color: white;
      }

      #lineTableBudgetTd {
        border-width: 2px;
        border-spacing: 0px;
        padding: 1px;
        border-style: inset;
        border-color: black;
        background-color: white;
        -moz-border-radius: ;
      }

      #notesTable {
        border-width: 2px;
        border-spacing: ;
        border-style: inset;
        border-color: black;
        border-collapse: collapse;
        background-color:
      }

      #notesTableTd {
        border-width: 0px;
        border-spacing: ;
        border-style: inset;
        border-color: black;
        border-collapse: collapse;
        background-color:
      }

      table {
        border-spacing: 0px;
      }

      #budgetContainerTable {
        border-width: 0px;
        border-spacing: 0px;
        border-style: inset;
        border-color: black;
        border-collapse: collapse;
        background-color: ;
      }

      td {
        border-color: gray;
      }
    </style>
    <title>e-Fatura</title>
  </head>
  <body style="margin-left=0.6in; margin-right=0.6in; margin-top=0.79in; margin-bottom=0.79in">
   
  <div style="z-index:-1;" >

<h1 style="

position: fixed;
opacity: 0.3;
font-size: 13em;
transform: rotate(-45deg);
color: #ff1e1e;
margin-top: 1.8em;
"
>PROFORMA</h1>
</div>
    <table style="border-color:blue;" border="0" cellspacing="0px" width="800" cellpadding="0px">
      <tbody>
        <tr valign="top">
          <td width="40%">
            <br>
            <table align="center" border="0" width="100%">
              <tbody>
                <hr>
                <tr align="left">
                  <td align="left"><?php echo session()->get('user_item')["firma_adi"]; ?> <br>
                  </td>
                </tr>
                <tr align="left">
                  <td align="left"> <?php echo session()->get('user_item')["adres"]; ?></td>
                </tr>
                <tr align="left">
                  <td align="left">Tel: <?php echo session()->get('user_item')["ticaret_sicil"]; ?> Fax: &nbsp;</td>
                </tr>
                <tr align="left">
                  <td>Web Sitesi: <?php echo session()->get('user_item')["web_site"]; ?></td>
                </tr>
                <tr align="left">
                  <td>E-Posta: <?php echo session()->get('user_item')["firma_mail"]; ?></td>
                </tr>
                <tr align="left">
                  <td align="left">Vergi Dairesi: <?php echo session()->get('user_item')["vergi"]; ?>&nbsp; </td>
                </tr>
                <tr align="left">
                  <td>VKN: <?php echo session()->get('user_item')["vkn"]; ?></td>
                </tr>
                <tr align="left">
                  <td>MERSISNO: </td>
                </tr>
                <tr align="left">
                  <td>TICARETSICILNO: </td>
                </tr>
              </tbody>
            </table>
            <hr>
            <table id="customerPartyTable" align="left" border="0" height="50%">
              <tbody>
                <tr style="height:71px; ">
                  <td>
                    <hr>
                    <table align="center" border="0">
                      <tbody>
                        <tr>
                          <td style="width:469px; " align="left">
                            <span style="font-weight:bold; ">SAYIN</span>
                          </td>
                        </tr>
                        <tr>
                          <td style="width:469px; " align="left">
                            <table cellpadding="0" cellspacing="0">
                              <tr>
                                <td><?= $invoice_item['cari_name'] . ' ' . $invoice_item['cari_surname'] ?></td>
                              </tr>
                              <tr>
                                <td><?= $invoice_item['cari_invoice_title'] ?></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td style="width:469px; " align="left"><?php echo $invoice_item["address"]; ?> <br>&nbsp;<?php echo $invoice_item["address_district"] ?>/<?php echo $invoice_item["address_city"] ?>&nbsp; </td>
                        </tr>
                        <tr align="left">
                          <td>E-Posta: <?php echo $invoice_item["cari_email"]; ?></td>
                        </tr>
                        <tr align="left">
                          <td style="width:469px; " align="left">Tel: <?php echo $invoice_item["cari_phone"]; ?> Fax: &nbsp;</td>
                        </tr>
                        <tr align="left">
                          <td>Vergi Dairesi: <?php echo $invoice_item["cari_tax_administration"]; ?></td>
                        </tr>
                        <tr align="left">
                          <td>TCKN: <?php echo $invoice_item["cari_identification_number"] ?></td>
                        </tr>
                      </tbody>
                    </table>
                    <hr>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
          <td width="26%" align="center">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            
           
          </td>
          <td width="28%" align="center" valign="middle">
            <table align="right" valign="middle">
              <tr>
                <td align="center" valign="middle">
                  
                  <img style="width:150px; padding-top:10px; padding-bottom:10px" src="<?php echo base_url(session()->get('user_item')['logo']); ?>" alt="Logo">
                </td>
              </tr>
              <tr>
                <td align="right">
                  <table border="1" height="13" id="despatchTable">
                    <tbody>
                    
                      <tr style="height:13px; ">
                        <td align="left">
                          <span style="font-weight:bold; ">Senaryo:</span>
                        </td>
                        <td align="left"><?= $invoice_item['invoice_scenario'] ?></td>
                      </tr>
                      <tr style="height:13px; ">
                        <td align="left">
                          <span style="font-weight:bold; ">Fatura Tipi:</span>
                        </td>
                        <td align="left"> <?php 
                                    
                                    $invoice_typelist = [
                                        [
                                            "invoice_type" => "incoming_invoice",
                                            "invoice_scenario_text" => "ALIŞ"
                                        ],
                                        [
                                            "invoice_type" => "SATIS",
                                            "invoice_scenario_text" => "SATIŞ"
                                        ],
                                        [
                                            "invoice_type" => "IADE",
                                            "invoice_scenario_text" => "İADE"
                                        ],
                                        [
                                            "invoice_type" => "TEVKIFAT",
                                            "invoice_scenario_text" => "TEVKİFAT"
                                        ],
                                        [
                                            "invoice_type" => "ISTISNA",
                                            "invoice_scenario_text" => "İSTİSNA"
                                        ],
                                        [
                                            "invoice_type" => "IADEISTISNA",
                                            "invoice_scenario_text" => "İADE İSTİSNA"
                                        ],
                                        [
                                            "invoice_type" => "OZELMATRAH",
                                            "invoice_scenario_text" => "ÖZEL MATRAH"
                                        ],
                                        [
                                            "invoice_type" => "IHRACKAYITLI",
                                            "invoice_scenario_text" => "İHRACAT KAYITLI"
                                        ]
                                    ];
                                    
                                    // Fatura tipini bul
                                    $invoice_type_text = "Belirsiz";
                                    foreach($invoice_typelist as $type) {
                                        if($type["invoice_type"] === $invoice_item["invoice_type"]) {
                                            $invoice_type_text = $type["invoice_scenario_text"];
                                            break;
                                        }
                                    }
                                    echo $invoice_type_text;
                                    ?></td>
                      </tr>
                      <tr style="height:13px; ">
                        <td align="left">
                          <span style="font-weight:bold; ">Fatura No:</span>
                        </td>
                        <td align="left"><?= $invoice_item['invoice_no'] ?></td>
                      </tr>
                      <tr style="height:13px; ">
                        <td align="left">
                          <span style="font-weight:bold; ">Fatura Tarihi:</span>
                        </td>
                        <td align="left"><?= date('d-m-Y', strtotime($invoice_item['invoice_date'])) ?></td>
                      </tr>
                      <tr style="height:13px; ">
                        <td align="left">
                          <span style="font-weight:bold; ">Düzenleme Saati:</span>
                        </td>
                        <td align="left"><?= date('H:i:s', strtotime($invoice_item['invoice_date'])) ?></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="left">
          <table id="ettnTable">
            <tr style="height:13px;">
              <td align="left" valign="top">
                <span style="font-weight:bold; ">ETTN:</span>
              </td>
              <td align="left" width="240px"><?= $invoice_item['invoice_ettn'] ?></td>
            </tr>
          </table>
        </tr>
      </tbody>
    </table>
    <div id="lineTableAligner">
      <span>&nbsp;</span>
    </div>
    <table border="1" id="lineTable" width="800">
      <tbody>
        <tr id="lineTableTr">
          <td id="lineTableTd" style="width:3%">
            <span style="font-weight:bold; " align="center">Sıra No</span>
          </td>
          <td id="lineTableTd" style="width:20%" align="center">
            <span style="font-weight:bold; ">Mal Hizmet</span>
          </td>
          <td id="lineTableTd" style="width:7.4%" align="center">
            <span style="font-weight:bold;">Miktar</span>
          </td>
          <td id="lineTableTd" style="width:9%" align="center">
            <span style="font-weight:bold; ">Birim Fiyat</span>
          </td>
          <td id="lineTableTd" style="width:7%" align="center">
            <span style="font-weight:bold; ">KDV Oranı</span>
          </td>
          <td id="lineTableTd" style="width:10%" align="center">
            <span style="font-weight:bold; ">KDV Tutarı</span>
          </td>
          <td id="lineTableTd" style="width:10.6%" align="center">
            <span style="font-weight:bold; ">Mal Hizmet Tutarı</span>
          </td>
        </tr>
        <?php
        $sira = 0;
                                        if ($invoice_item['invoice_type'] == 'IHRACAT') $colspan = 10;
                                        else if ($invoice_item['invoice_type'] == 'TEVKIFAT') $colspan = 6;
                                        else if ($invoice_item['invoice_type'] == 'OZELMATRAH') $colspan = 5;
                                        else $colspan = 4;

                                        foreach ($invoice_rows as $invoice_row) { $sira++;   ?>
        <tr id="lineTableTr">
          <td id="lineTableTd">&nbsp;<?php echo $sira; ?></td>
          <td id="lineTableTd">&nbsp; <?= $invoice_row['stock_title'] ?><br></strong><?= $invoice_row['stock_code'] ?? '' ?> </td>
          <td id="lineTableTd" align="right">&nbsp;<?= number_format($invoice_row['stock_amount'], 2, ',', '.') ?> <?= $invoice_row['unit_title'] ?></td>
          <td id="lineTableTd" align="right">&nbsp; <?= number_format($invoice_row['unit_price'], session()->get('user_item')['para_yuvarlama'], ',', '.') ?> <?= $invoice_item['money_icon'] ?></td>
          <td id="lineTableTd" align="right">&nbsp; %<?= $invoice_row['tax_id'] ?></td>
          <td id="lineTableTd" align="right">&nbsp; <?= number_format($invoice_row['tax_price'], 2, ',', '.') ?> <?= $invoice_item['money_icon'] ?></td>
          <td id="lineTableTd" align="right">&nbsp;<?= number_format($invoice_row['total_price'], 2, ',', '.') ?> <?= $invoice_item['money_icon'] ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <table id="budgetContainerTable" width="800px" style="    margin-top: 10px !important;">
    <tr id="budgetContainerTr" align="right">
<td id="budgetContainerDummyTd"></td>
<td id="lineTableBudgetTd" align="right" width="241px"><span style="font-weight:bold; "></span>Mal/Hizmet Toplam</span></td>
<td id="lineTableBudgetTd" style="width:81px; " align="right"><?= number_format($invoice_item['stock_total'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></td>
</tr>
      <tr id="budgetContainerTr" align="right">
        <td id="budgetContainerDummyTd"></td>
        <td id="lineTableBudgetTd" align="right" width="200px">
          <span style="font-weight:bold; ">Toplam İskonto</span>
        </td>
        <td id="lineTableBudgetTd" style="width:81px; " align="right"><?= number_format($invoice_item['discount_total'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></td>
      </tr>
      <?php   if ($invoice_item['tax_rate_1_amount'] != 0) { ?>
            <tr id="budgetContainerTr" align="right">
            <td id="budgetContainerDummyTd"></td>
            <td id="lineTableBudgetTd" width="211px" align="right">
            <span style="font-weight:bold; ">Hesaplanan KDV(%1)</span>
            </td>
            <td id="lineTableBudgetTd" style="width:82px; " align="right"> <?php echo number_format($invoice_item["tax_rate_1_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"]; ?></td>
        </tr>
   <?php } ?> 

   <?php   if ($invoice_item['tax_rate_10_amount'] != 0) { ?>
            <tr id="budgetContainerTr" align="right">
            <td id="budgetContainerDummyTd"></td>
            <td id="lineTableBudgetTd" width="211px" align="right">
            <span style="font-weight:bold; ">Hesaplanan KDV(%10)</span>
            </td>
            <td id="lineTableBudgetTd" style="width:82px; " align="right"> <?php echo number_format($invoice_item["tax_rate_10_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"]; ?></td>
        </tr>
   <?php } ?> 

   <?php   if ($invoice_item['tax_rate_20_amount'] != 0) { ?>
            <tr id="budgetContainerTr" align="right">
            <td id="budgetContainerDummyTd"></td>
            <td id="lineTableBudgetTd" width="211px" align="right">
            <span style="font-weight:bold; ">Hesaplanan KDV(%20)</span>
            </td>
            <td id="lineTableBudgetTd" style="width:82px; " align="right"> <?php echo number_format($invoice_item["tax_rate_20_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"]; ?></td>
        </tr>
   <?php } ?> 


      <tr id="budgetContainerTr" align="right">
        <td id="budgetContainerDummyTd"></td>
        <td id="lineTableBudgetTd" width="200px" align="right">
          <span style="font-weight:bold; ">Vergiler Dahil Toplam Tutar</span>
        </td>
        <td id="lineTableBudgetTd" style="width:82px; " align="right"><?= number_format($invoice_item['grand_total'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></td>
      </tr>
      <tr id="budgetContainerTr" align="right">
        <td id="budgetContainerDummyTd"></td>
        <td id="lineTableBudgetTd" width="200px" align="right">
          <span style="font-weight:bold; ">Ödenecek Tutar</span>
        </td>
        <td id="lineTableBudgetTd" style="width:82px; " align="right"><?= number_format($invoice_item['amount_to_be_paid'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></td>
      </tr>








    </table>
    <br>
    <br>
    <table id="notesTable" width="800" align="left" height="100">
      <tbody>
        <tr align="left">
          <td id="notesTableTd">
            <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>Toplam Tutar Yazıyla: <?php echo $invoice_item["amount_to_be_paid_text"] ?> <br>
            <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </b><?php echo $invoice_item["invoice_note"] ?>
          </td>
        </tr>
      </tbody>
    </table>
    <script>
      window.print();
    </script>
  </body>
</html>
