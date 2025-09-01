<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>
<?= $this->section('title') ?>
<?= $page_title ?> |
<?= session()->get('user_item')['firma_adi'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>




<?= $this->section('main') ?>
<style>
    .row.justify-between.g-2.d-none.with-export{
        display: flex!important;
        padding: 20px!important;
    }
       .dataTables_sizing{
        display: none;
        opacity: 0;
    }
	#DataTables_Table_0_wrapper .with-export{
		    display: flex !important;
    align-items: center;
    padding: 20px;
	}
	
	#dataTables_length label span{
		display:flex!important;
	}
.form-control-select.d-none, span.d-none{
		display:flex!important;
	}
 
</style>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">
                            <?= $page_title ?>
                        </h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon  toggle-expand me-n1" data-target="pageMenu"><em
                                    class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li><a href="#" class="btn btn-white btn-outline-light"><em
                                                class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                    <li class="nk-block-tools-opt">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary"
                                                data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>Add User</span></a></li>
                                                    <li><a href="#"><span>Add Team</span></a></li>
                                                    <li><a href="#"><span>Import User</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .toggle-wrap -->
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">

                <div class="card p-3 px-5">
                    <div class="card-title-group">
                    
                        <div class="card-tools me-n1">
                            <ul class="btn-toolbar gx-1">
                                <li>
                                <div class="col-md-12">
                                            <div class="">
                                                <b>İşlem Tarihi Para Birimi ve Müşteri Seçiniz: </b>
                                            </div>
                                        </div>
                                    <div class="form-inline flex-nowrap gx-3">
                                        
                                        <div class="form-group col-md-5" style="margin-top:14px">
  <div class="form-control-wrap">
  <div class="form-icon form-icon-right">
                                                    <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                </div>
    <div class="input-daterange date-picker input-group">
      <input type="text" name="report_date" id="report_date" class="form-control" value="<?= isset ($date) ? date("d/m/Y", strtotime($date)) : date('d/m/Y') ?>"/>
      <div class="input-group-addon">İLE</div>
      <input type="text" name="report_date_end" id="report_date_end" class="form-control" value="<?= isset ($date2) ? date("d/m/Y", strtotime($date2)) : date('d/m/Y') ?>" />
    </div>
  </div>
</div>

<div class="form-group col-md-2" style="margin-top:14px">
<select class="form-select js-select2" id="fatura_senaryo" name="fatura_senaryo"  data-search="on" data-placeholder="Para Birimi Seçiniz">
<?php foreach ($para_birimleri as $money_unit_item) { ?>
                                                                <option value="<?= $money_unit_item['money_unit_id'] ?>" data-money-unit-code="<?= $money_unit_item['money_code'] ?>" data-money-unit-icon="<?= $money_unit_item['money_icon'] ?>" 
                                                                <?php if ($money_unit_item['default'] == 'true') { echo "selected"; }  ?>   
                                                                <?php if ($money_unit_item['money_unit_id'] ==  $currency) { echo "selected"; }  ?>   
                                                                >
                                                                    <?= $money_unit_item['money_code'] ?> -
                                                                    <?= $money_unit_item['money_title'] ?></option>
                                                            <?php } ?>
                                                        </select>
</div>

<div class="form-group col-md-2" style="margin-top:14px">
<select class="form-select js-select2" id="musteri_sec" name="musteri_sec"  data-search="on" data-placeholder="Müşteri  Seçiniz">
    <option value="0">Hepsi</option>
<?php foreach ($musteriler as $musteri) { ?>
                                                                <option   <?php if ($musteri['cari_id'] ==  $secilen_musteri) { echo "selected"; }  ?>   value="<?= $musteri['cari_id'] ?>"><?php echo $musteri['invoice_title'] ?? $musteri["name"]  . " " . $musteri["surname"] ?></option>
                                                            <?php } ?>
                                                        </select>
</div>
<div class="form-group col-md-3" style="margin-top:14px">
<select class="form-select js-select2" id="urun_sec" name="urun_sec"  data-search="on" data-placeholder="Ürün  Seçiniz">
    <option value="0">Tüm Ürünler</option>
<?php foreach ($urunler as $urun) { ?>
                                                                <option   <?php if ($urun['stock_id'] ==  $secilen_urun) { echo "selected"; }  ?>   value="<?= $urun['stock_id'] ?>"><?php echo  $urun["stock_code"]  . " - " . $urun["stock_title"] ?></option>
                                                            <?php } ?>
                                                        </select>
</div>
<div class="form-group" style="margin-top:5px">
<button type="button" class="btn btn-primary mb-2 btnNext" id="">Bul</button>

</div>

                                    </div>
                                </li><!-- li -->
                                
                                <li class="btn-toolbar-sep d-none"></li><!-- li -->

                                
                                <!-- li -->
                            </ul><!-- .btn-toolbar -->
                            <p class="badge bg-primary text-white"><strong>T.A Fiyat : Toplam Alış Fiyatı</strong></p>
                        </div><!-- .card-tools -->
                    </div><!-- .card-title-group -->
                    <div class="card-search search-wrap" data-search="search">
                        <div class="card-body">
                            <div class="search-content">
                                <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em
                                        class="icon ni ni-arrow-left"></em></a>
                                <input type="text" id="invoice_input_search"
                                    class="form-control border-transparent form-focus-none"
                                    placeholder="Bulmak istediğiniz faturanın fatura ünvanını veya fatura numarasını yazınız...">
                                <a href="#" class="btn btn-icon toggle-search" data-target="search"
                                    style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em
                                        class="icon ni ni-cross"></em></a>
                                <button class="search-submit btn btn-icon" style="margin-right: 50px;"
                                    id="invoice_input_search_clear_button" name="invoice_input_search_clear_button"><em
                                        class="icon ni ni-trash"></em></button>
                            </div>
                        </div>
                    </div><!-- .card-search -->
                </div>
<?php foreach($unitTitleMap as $maps): ?>
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                    <div class="form-inline">
                                        <h5>SATIŞ <?php echo $maps["unit_title"]; ?> </h5>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>
                                            <!-- <div class="form-inline flex-nowrap gx-3">
                                                <div class="">
                                                    <div class="">
                                                        <p>İşlem Tarihi: </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control  form-control-lg form-control-lg date-picker"
                                                            name="report_date" id="report_date"
                                                            value="<?= isset ($date) ? date("d/m/Y", strtotime($date)) : date('d/m/Y') ?>">
                                                    </div>
                                                </div>
                                            </div> -->
                                        </li><!-- li -->
                                        <li class="btn-toolbar-sep d-none"></li><!-- li -->
                                        <!-- li -->
                                    </ul><!-- .btn-toolbar -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search"
                                            data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" id="invoice_input_search"
                                            class="form-control border-transparent form-focus-none"
                                            placeholder="Bulmak istediğiniz faturanın fatura ünvanını veya fatura numarasını yazınız...">
                                        <a href="#" class="btn btn-icon toggle-search" data-target="search"
                                            style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em
                                                class="icon ni ni-cross"></em></a>
                                        <button class="search-submit btn btn-icon" style="margin-right: 50px;"
                                            id="invoice_input_search_clear_button"
                                            name="invoice_input_search_clear_button"><em
                                                class="icon ni ni-trash"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div>

                        <div class="card-inner p-0">
                            <div class="card card-preview">


                            <table class="nowrap table datatable-init-hareketler_<?php echo $maps["unit_id"]; ?>">
                                        <thead>
                                            <tr >
                                            <th class="nk-tb-col"><span class="sub-text">TARİH</span></th>
                                            <th style="width:10px!important" class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">MÜŞTERİ</span></th>
                                            <th class="nk-tb-col tb-col-md" data-orderable="false" style="min-width:120px"><span class="sub-text">ÜRÜN</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">RENK</span></th>
                                            <th class="nk-tb-col tb-col-lg text-right" data-orderable="false" ><span class="sub-text">SATILAN <?php echo $maps["unit_title"]; ?></span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">SATIŞ FİYATI</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">ALIŞ FİYATI</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">T.A FİYATI</span></th>
                                            <th class="nk-tb-col tb-col-lg" style="width:3%;" data-orderable="false"><span class="sub-text">SATIŞ-ALIŞ  FARK</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">BİZE KALAN</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $money_icon = "$";
                                        $toplam_adet = 0;
                                        $toplam_kar  = 0;
                                        $toplam_alis  = 0;
                                        $cari_haric = session()->get("user_item")["stock_user"] ?? 0;
                                        foreach($invoiceRows as $rows):
                                            if($rows["cari_id"] != $cari_haric):
                                                if($rows["unit_id"] == $maps["unit_id"]):


                                                    if($rows["is_return"] != 1):



                                                    $alis = 0;
                                                    $satis = 0;

                                                   
                                                  

                                                
                                                    $money_icon = $rows["money_icon"];
                                                

                                                
                                                  

                                                  

                                               // Alış fiyatını hesapla
                                               $alis = $rows["stock_amount"] * $rows["buy_unit_price"];
                                                    
                                               // Satış fiyatını hesapla, eğer invoice_direction "outgoing_invoice" ise
                                               if ($rows["invoice_direction"] == "outgoing_invoice") {
                                                   $satis = $rows["stock_amount"] * $rows["unit_price"];
                                               }

                                               

                                             


                                                
                                             
                                                    if($rows["invoice_direction"] == "outgoing_invoice"):
                                                        $fark = $rows["stock_amount"] * ($rows["unit_price"] - $rows["buy_unit_price"]);
                                                        $toplam_kar += $fark;
                                                        $toplam_adet += $rows["stock_amount"];

                                                        if ($fark < 0) {
                                                            $fark_class = 'text-danger';
                                                        } elseif ($fark == 0) {
                                                            $fark_class = 'text-secondary';
                                                        } else {
                                                            $fark_class = 'text-success';
                                                        }
    
                                                        if ($alis > $satis) {
                                                            $fark_class_alis = 'text-danger';
                                                        } elseif ($alis == $satis) {
                                                            $fark_class_alis = 'text-secondary';
                                                        } else {
                                                            $fark_class_alis = 'text-success';
                                                        }

                                                        $toplam_alis += $alis; // Alış fiyatını toplama ekle

                                            ?>
                                            <tr>
                                                <td><?php echo $rows["invoice_date"]; ?></td>
                                                <td data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="<?php echo $rows["cari_invoice_title_full"]; ?>" title=""><?php echo $rows["cari_invoice_title"]; ?></td>
                                                <td><?php echo $rows["stock_title"]; ?> #
                                            <?php echo $rows["invoice_row_id"]; ?>
                                            </td>
                                                <td><span class="tb-lead"><?php echo $rows["variant_property_title"]; ?></span></td>
                                                <td style="text-align:right;"><?php echo number_format($rows["stock_amount"], 2, ',', '.'); ?></td>
                                                <td style="text-align:right;">
                                                    <div data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Toplam Satış : <?php echo number_format($satis, 2, ',', '.'); ?>">
                                                   <span> <?php echo $rows["money_icon"]; ?> <?php echo number_format($rows["unit_price"], 4, ',', '.'); ?></span>
                                                    </div>
                                                </td>
                                                <td style="text-align:right;">
                                                    <div  data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Toplam Alış : <?php echo number_format($alis, 2, ',', '.'); ?>">
                                                    <span><?php echo $rows["money_icon"]; ?> <?php echo number_format($rows["buy_unit_price"], 4, ',', '.'); ?></span>
                                                    </div>
                                                </td>
                                                <td style="text-align:right;">
                                                    <div  data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Toplam Alış : <?php echo number_format($alis, 2, ',', '.'); ?>">
                                                    <span><?php echo $rows["money_icon"]; ?> <?php echo number_format($alis, 2, ',', '.'); ?></span>
                                                    </div>
                                                </td>
                                                <td style="text-align:right;">                                                    <div>
                                                   <span class="<?php echo $fark_class_alis; ?>"><?php echo $rows["money_icon"]; ?> <?php echo number_format(($rows["unit_price"] - $rows["buy_unit_price"]), 4, ',', '.'); ?></span>
                                                    </div>
                                                </td>
                                                <td style="text-align:right;">                                                    <div  data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Toplam Bize Kalan : <?php echo number_format($fark, 2, ',', '.'); ?>">
                                                    <span class="<?php echo $fark_class; ?>"><?php echo $rows["money_icon"]; ?> <?php echo number_format($fark, 2, ',', '.'); ?></span>
                                                    </div>
                                                </td>
                                            </tr>
                                         <?php endif; endif; endif; endif; endforeach; ?>
                                        </tbody>
                                        <tfoot>
    <tr>
        <td style="background-color: #f0f0f0; text-align:end" colspan="5"><b><?php echo number_format($toplam_adet, 2, ',', '.'); ?></b></td>
        <td style="background-color: #f0f0f0;text-align:end" colspan="1"><b></b></td>

        <td style="background-color: #f0f0f0;text-align:end" colspan="1"><b></b></td>

        <td style="background-color: #f0f0f0;text-align:end" colspan="1"><b><?php echo $money_icon; ?> <?php echo number_format($toplam_alis, 2, ',', '.'); ?></b></td>
        <td style="background-color: #f0f0f0;text-align:center" colspan="1"><b></b></td>
        <td style="background-color: #f0f0f0;text-align:end" colspan="1"><b><?php echo $money_icon; ?> <?php echo number_format($toplam_kar, 2, ',', '.'); ?></b></td>
    </tr>
</tfoot>
                                    </table>



                            </div>



                        </div>

                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
<?php endforeach; ?>




<?php foreach($unitTitleMap as $maps): ?>
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                    <div class="form-inline">
                                        <h5>SATIŞ <?php echo $maps["unit_title"]; ?> İADELER </h5>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>
                                            <!-- <div class="form-inline flex-nowrap gx-3">
                                                <div class="">
                                                    <div class="">
                                                        <p>İşlem Tarihi: </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-right">
                                                            <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control  form-control-lg form-control-lg date-picker"
                                                            name="report_date" id="report_date"
                                                            value="<?= isset ($date) ? date("d/m/Y", strtotime($date)) : date('d/m/Y') ?>">
                                                    </div>
                                                </div>
                                            </div> -->
                                        </li><!-- li -->
                                        <li class="btn-toolbar-sep d-none"></li><!-- li -->
                                        <!-- li -->
                                    </ul><!-- .btn-toolbar -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search"
                                            data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" id="invoice_input_search"
                                            class="form-control border-transparent form-focus-none"
                                            placeholder="Bulmak istediğiniz faturanın fatura ünvanını veya fatura numarasını yazınız...">
                                        <a href="#" class="btn btn-icon toggle-search" data-target="search"
                                            style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em
                                                class="icon ni ni-cross"></em></a>
                                        <button class="search-submit btn btn-icon" style="margin-right: 50px;"
                                            id="invoice_input_search_clear_button"
                                            name="invoice_input_search_clear_button"><em
                                                class="icon ni ni-trash"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div>

                        <div class="card-inner p-0">
                            <div class="card card-preview">


                            <table class="nowrap table datatable-init-hareketler_<?php echo $maps["unit_id"]; ?>">
                                        <thead>
                                            <tr >
                                            <th class="nk-tb-col"><span class="sub-text">TARİH</span></th>
                                            <th style="width:10px!important" class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">MÜŞTERİ</span></th>
                                            <th class="nk-tb-col tb-col-md" data-orderable="false" style="min-width:120px"><span class="sub-text">ÜRÜN</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">RENK</span></th>
                                            <th class="nk-tb-col tb-col-lg text-right" data-orderable="false" ><span class="sub-text">SATILAN <?php echo $maps["unit_title"]; ?></span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">SATIŞ FİYATI</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">ALIŞ FİYATI</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">T.A FİYATI</span></th>

                                            <th class="nk-tb-col tb-col-lg" style="width:3%;" data-orderable="false"><span class="sub-text">SATIŞ-ALIŞ  FARK</span></th>
                                            <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">BİZE KALAN</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $money_icon = "$";
                                        $toplam_adet = 0;
                                        $toplam_kar  = 0;
                                        $toplam_alis  = 0;
                                        $cari_haric = session()->get("user_item")["stock_user"] ?? 0;
                                        foreach($invoiceRows as $rows_iade):
                                            if($rows["cari_id"] != $cari_haric):
                                                if($rows_iade["unit_id"] == $maps["unit_id"]):


                                                    if(isset($rows_iade["is_return"]) && $rows_iade["is_return"] == 1){ // Ensure is_return is set and equals 1

                                                  
                                                        $money_icon = $rows["money_icon"];


                                                    $alis = 0;
                                                    $satis = 0;

                                                 
                                                    // Alış fiyatını hesapla
                                                    $alis = $rows_iade["stock_amount"] * $rows_iade["buy_unit_price"];
                                                    
                                                    // Satış fiyatını hesapla, eğer invoice_direction "outgoing_invoice" ise
                                                    if ($rows_iade["invoice_direction"] == "incoming_invoice") {
                                                        $satis = $rows_iade["stock_amount"] * $rows_iade["unit_price"];
                                                    }

                                                   
                                                

                                                
                                                  

                                                  

                                      


                                                    if($rows_iade["invoice_direction"] == "incoming_invoice"):

                                                        $fark = $rows["stock_amount"] * ($rows["unit_price"] - $rows["buy_unit_price"]);
                                                        $toplam_kar += $fark;
                                                        $toplam_adet += $rows["stock_amount"];

                                                    if ($fark < 0) {
                                                        $fark_class = 'text-danger';
                                                    } elseif ($fark == 0) {
                                                        $fark_class = 'text-secondary';
                                                    } else {
                                                        $fark_class = 'text-success';
                                                    }

                                                    if ($alis > $satis) {
                                                        $fark_class_alis = 'text-danger';
                                                    } elseif ($alis == $satis) {
                                                        $fark_class_alis = 'text-secondary';
                                                    } else {
                                                        $fark_class_alis = 'text-success';
                                                    }
                                                    $toplam_alis += $alis; // Alış fiyatını toplama ekle


                                            ?>
                                            <tr>
                                                <td><?php echo $rows_iade["invoice_date"]; ?></td>
                                                <td data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="<?php echo $rows_iade["cari_invoice_title_full"]; ?>" title=""><?php echo $rows_iade["cari_invoice_title"]; ?></td>
                                                <td><?php echo $rows_iade["stock_title"]; ?> </td>
                                                <td><span class="tb-lead"><?php echo $rows_iade["variant_property_title"]; ?></span></td>
                                                <td style="text-align:right;"><?php echo number_format($rows_iade["stock_amount"], 2, ',', '.'); ?></td>
                                                <td style="text-align:right;">
                                                    <div data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Toplam Satış : <?php echo number_format($satis, 2, ',', '.'); ?>">
                                                   <span> <?php echo $rows_iade["money_icon"]; ?> <?php echo number_format($rows_iade["unit_price"], 4, ',', '.'); ?></span>
                                                    </div>
                                                </td>
                                                <td style="text-align:right;">
                                                    <div  data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Toplam Alış : <?php echo number_format($alis, 2, ',', '.'); ?>">
                                                    <span><?php echo $rows_iade["money_icon"]; ?> <?php echo number_format($rows_iade["buy_unit_price"], 4, ',', '.'); ?></span>
                                                    </div>
                                                </td>
                                                <td style="text-align:right;">
                                                    <div  data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Toplam Alış : <?php echo number_format($alis, 2, ',', '.'); ?>">
                                                    <span><?php echo $rows["money_icon"]; ?> <?php echo number_format($alis, 2, ',', '.'); ?></span>
                                                    </div>
                                                </td>
                                                <td style="text-align:right;">                                                    <div>
                                                   <span class="<?php echo $fark_class_alis; ?>"><?php echo $rows_iade["money_icon"]; ?> <?php echo number_format(($rows_iade["unit_price"] - $rows_iade["buy_unit_price"]), 4, ',', '.'); ?></span>
                                                    </div>
                                                </td>
                                                <td style="text-align:right;">                                                    <div  data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Toplam Bize Kalan : <?php echo number_format($fark, 2, ',', '.'); ?>">
                                                    <span class="<?php echo $fark_class; ?>"><?php echo $rows_iade["money_icon"]; ?> <?php echo number_format($fark, 2, ',', '.'); ?></span>
                                                    </div>
                                                </td>
                                            </tr>
                                         <?php endif;  } endif; endif; endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
        <td style="background-color: #f0f0f0; text-align:end" colspan="5"><b><?php echo number_format($toplam_adet, 2, ',', '.'); ?></b></td>
        <td style="background-color: #f0f0f0;text-align:end" colspan="1"><b></b></td>

        <td style="background-color: #f0f0f0;text-align:end" colspan="1"><b></b></td>

        <td style="background-color: #f0f0f0;text-align:end" colspan="1"><b><?php echo $money_icon; ?> <?php echo number_format($toplam_alis, 2, ',', '.'); ?></b></td>
        <td style="background-color: #f0f0f0;text-align:center" colspan="1"><b></b></td>
        <td style="background-color: #f0f0f0;text-align:end" colspan="1"><b><?php echo $money_icon; ?> <?php echo number_format($toplam_kar, 2, ',', '.'); ?></b></td>
    </tr>
</tfoot>
                                    </table>



                            </div>



                        </div>

                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
<?php endforeach; ?>

            

            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
<?php foreach($unitTitleMap as $maps): ?>
NioApp.DataTable('.datatable-init-hareketler_<?php echo $maps["unit_id"] ?>', {
      // language: {
      //   url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/tr.json'
      //   },
      //paging: false, // Sayfalama devre dışı bırakılıyor
      pageLength: 15, // Varsayılan sayfa uzunluğu
      lengthMenu: [15, 50, 100, -1], // Sayfa uzunluğu seçenekleri: 15, 50, 100, Tüm
      lengthMenu: [
        [15, 50, 100, -1], // Sayfa uzunluğu seçenekleri
        [15, 50, 100, "Tümü"] // Kullanıcıya gösterilen metin
      ],
      pagingType: 'full_numbers',
      order: [[0, "desc"]],
      
      buttons: ['copy', 'excel', 'csv', 'pdf'],
    });
<?php endforeach; ?>
    $(".custom-control-input").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(document).ready(function () {

        var base_url = window.location.origin;

        var url = window.location.pathname;
        var parts = url.split('/');
        var lastPart = parts[parts.length - 1];

  

        $(function () {
         
            $('.input-daterange').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                autoclose: true
            });


          
            $(document).ready(function () {
    // Initialize the date picker
    $('#report_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $('#report_date_end').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    // Event handler for the start date input change
    $('#report_date').on('change', function () {
        var startDate = $(this).datepicker('getDate');
        var endDate = $('#report_date_end').datepicker('getDate');

        if (endDate && startDate > endDate) {
            // Show error if start date is after end date
            $('#date_error').show();
            $('#report_date_end').val(''); // Clear end date
        } else {
            $('#date_error').hide();
        }

        // Focus on the end date input
        $('#report_date_end').focus();
    });

    // Event handler for the end date input change
    $('#report_date_end').on('change', function () {
        var startDate = $('#report_date').val();
        var endDate = $(this).val();

        if (endDate && startDate > endDate) {
            // Show error if start date is after end date
            $('#date_error').show();
        } else {
            $('#date_error').hide();
        }
    });

    // Event handler for the button click
    $('.btnNext').on('click', function () {
        var startDate = $('#report_date').val();
        var endDate = $('#report_date_end').val();
        var currency = $('#fatura_senaryo').val(); // Get the selected currency
        var musteri = $('#musteri_sec').val(); // Get the selected currency
        var urun = $('#urun_sec').val(); // Get the selected currency
        
        if (!startDate || !endDate || !currency) {
            // Show error if any field is empty
            alert('Lütfen tüm alanları doldurun.');
            return;
        }

        var startDateFormatted = startDate.split('/').reverse().join('-'); // Format date
        var endDateFormatted = endDate.split('/').reverse().join('-'); // Format date

        var newPageURL = base_url + '/tportal/reports/detayli_satis_raporlarim/' + startDateFormatted + '/' + endDateFormatted + '/' + currency + '/' + musteri + '/' + urun;

        window.location.href = newPageURL;
    });
});


        });

    });
</script>

<?= $this->endSection() ?>