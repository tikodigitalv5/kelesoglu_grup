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
    tfoot{
        position: relative;
        overflow: hidden;
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

                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                    <div class="form-inline">
                                        <h5>Müşteri Raporu</h5>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                            
                               
                            </div><!-- .card-title-group -->
                   
                        </div>

                        <div class="card-inner p-0">

                            
                        <div class="nk-block">
                                <div class="nk-data data-list">
                                   

                                    <table class="datatable-init-exports nowrap table" data-export-title="Dışa Aktar">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2;">#</th>
                                                <th width="50%" style="background-color: #ebeef2;" >ÜNVAN/YETKİLİ</th>
                                                <th width="10%" style="text-align:left; background-color: #ebeef2;" >İLETİŞİM</th>
                                                <th width="10%" style="text-align:right; background-color: #ebeef2;" >BAKİYE</th>
                                                <th width="10%" style="background-color: #ebeef2;" >DURUM</th>
                                                <th width="5%" style="background-color: #ebeef2;" data-orderable="false">...</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                <?php
                                        $sira = 1;
                                        $cari_haric = session()->get("user_item")["stock_user"] ?? 0;

                                        foreach ($builder as  $data) {
                                            if($data["cari_id"] != $cari_haric):
                                            if($data['cari_balance'] > 0 ){
                                                $color = "success";
                                            }else{
                                                $color = "danger";
                                            }
                                    ?>
                                            <tr>
                         
                                                <td><?= $sira ?></td>
                                                <td><?= $data["invoice_title"]; ?></td>
                                                <td style="text-align:left;"><?= $data["cari_phone"]; ?> </td>
												
                                                <td style="text-align:right;">
                                                <span class="tb-amount text-<?php echo $color; ?> para"><?= number_format($data['cari_balance'], 2,  ',') ?? '-' ?> <?php echo $data["money_icon"];  ?></span>
                                                </td>
                                                <td style="text-align:left;"><?php 
                                                    if($data['cari_balance'] > 0){ ?> 
                                                         <span class="tb-amount text-success">BORÇLU</span>
                                                  <?php   }else{ ?>
                                                    <span class="tb-amount text-danger">ALACAKLI</span>
                                                   <?php  } ?>
                                                 </td>
                                                <td>
                                                <a href="<?= route_to("tportal.cariler.detail", $data["cari_id"]) ?>" class="btn btn-icon btn-xs btn-dim btn-outline-dark" id="btnPrintBarcode" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari Detaylarını Görüntüle"><em class="icon ni ni-arrow-right"></em></a>
                            
                

                                            </td>
                                            </tr>
                                    <?php
                                            $sira++;
                                                  endif;
                                        }
                                    ?>


                                        </tbody>
                                       
                                    </table>
                                   
                                </div><!-- data-list -->
                              
                            </div><!-- .nk-block -->

                       
                        </div>
               


            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
$(document).ready(function() {
            // PHP'den gelen JSON verisini JavaScript değişkenine aktar
            var totalstocktype = <?= $totals_borclu; ?>;
            var totalPricesByCurrency = <?= $totals_alacakli; ?>;

            // Borçlu toplamlarını güncelle
            var totalstockHtml = "<span style='margin-right: 25px; background: green; padding: 5px; color: white; border-radius: 10%; position: absolute; left: 59%; top: 25%;  font-size: 12px;'>BORÇLU</span>";
            $.each(totalstocktype, function(index, currency) {
                totalstockHtml += "<b style='color:green; font-weight: bold;'>" + parseFloat(currency.amount).toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + "</b>" + " <b style='color:green; font-weight: bold;' > " + currency.icon + " </b> <br>";
            });
            $("#totalPriceCell").html(totalstockHtml);

            // Alacaklı toplamlarını güncelle
            var totalAmountHtml = "<span style='margin-right: 25px; background: red; padding: 5px; color: white; border-radius: 10%; position: absolute; right: 12%; top: 25%;  font-size: 12px;'>ALACAKLI</span>";
            $.each(totalPricesByCurrency, function(index, currency) {
                totalAmountHtml += "<b style='color:red; font-weight: bold;' >" + parseFloat(currency.amount).toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + "</b>" + " <b style='color:red; font-weight: bold;' > " + currency.icon + " </b> <br>";
            });
            $("#totalAmount").html(totalAmountHtml);
        });


</script>

<?= $this->endSection() ?>