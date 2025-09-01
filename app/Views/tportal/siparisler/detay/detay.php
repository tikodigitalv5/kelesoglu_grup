<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Sipariş Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Sipariş Detay | <?= session()->get('user_item')['firma_adi'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>
<style>

.dopigo{

position: relative;
font-size:11.4px;
font-family: Roboto, sans-serif;
display: inline-block;
padding: 3px;
color: black;
background-color: #e5edfa !important;
border-color: #e5edfa;
}


</style>

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
                                        <h4 class="nk-block-title">Sipariş Kalemleri</h4>

                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                    <div class="data-head">
                                        <h6 class="overline-title">Bilgiler</h6>
                                    </div>

                                    <div class="card-inner p-0">
                                        <div class="nk-tb-list nk-tb-ulist is-compact">

                                            <?php
                                        
                                            foreach ($order_rows as $order_row) { ?>


                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col tb-col-md"
                                                    style="
                                                    
                                                    "
                                                    >
                                                        <div class="user-card">



                                                        <?php if(!empty($order_row["paket_text"])){ ?> 
                                                            <div style="padding-left:90px">
                                                            

                                                            </div>
                                                        <?php } ?>
                                                            <div class="user-avatar bg-transparent lg mt-3 mb-3">
                                                                <?php  if(isset($order_row["default_image"])): ?>
                                                                <a class="gallery-image popup-image" href="<?= base_url($order_row['default_image']) ?>">
                                                                    <img style="" src="<?= base_url($order_row['default_image']) ?>" alt="image" class="w-100 rounded-top">
                                                                </a>
                                                                <?php else: ?>

                                                                    <a class="gallery-image popup-image" href="<?= base_url("uploads/default.png") ?>">
                                                                    <img src="<?= base_url("uploads/default.png") ?>" alt="image" class="w-100 rounded-top">
                                                                </a>
                                                                <?php endif; ?>
                                                            </div>
                                                            
                                                            <?php if($order_row["stock_id"] != 0): ?>
                                                            <div class="user-name" onclick='window.location.href="<?php echo base_url("tportal/stock/detail/" . $order_row["stock_id"] ); ?>";' title="Ürün Detaylarına Git">
                                                                <?php else: ?> 
                                                                    <div class="user-name" >

                                                                <?php endif;  ?>
                                                                <span class="tb-lead">
                                                                <?php if(empty($order_row["paket_text"])){ ?> 
                                                                    <strong><?php 

                                                                    
                                                                    if(isset($order_item["dopigo"])){
                                                                        echo $order_row["dopigo_title"];

                                                                    }else{
                                                                        if(empty($order_row['stock_title'])){
                                                                            echo $order_row['dopigo_title'];
                                                                        }else{
                                                                            echo $order_row['stock_title'];
                                                                        }
                                                                    }
                                                                    
                                                                     ?>
                                                                <?php } ?>
                                                                        

                                                                    <?php if($order_row["stock_id"] == 0){ ?> 
                                                                        <br>
                                                                        <span class="tb-odr-status"><span class="badge badge-dot bg-danger">EŞLEŞMEYEN ÜRÜN</span></span>
                                                                        <?php } ?>
                                                                    <?php 
                                                                        if(isset($order_item["dopigo"])){
                                                                            echo "<b class='dopigo'>" . $order_row["stock_title"] . "</b>";

                                                                        }else{
                                                                            echo "<b class='dopigo'>" . $order_row["dopigo_title"] . "</b>";
                                                                        }
                                                                    ?>

                                                                        <?php if(!empty($order_row["paket_text"])){ ?> 
                                                                        <br>
                                                                        <br>
                                                                        <span class="tb-odr-status"><span class="badge badge-dot bg-primary">PAKET ÜRÜNÜ</span></span>
                                                                        <?php } ?>

                                                                        
                                                                </strong>
                                                                   
                                                                    <br>
                                                                    <?php if(isset($order_row['stock_code'])): $order_row['stock_code']; endif; ?>
                                                                    <?php if(session()->get('user_id') == 13){ ?>
                                                                      <div class="form-control-wrap " style=" margin-top:10px;">
                                                                      <?= str_replace('<br>', "\n", $order_row['varyantlar']) ?>                                                                     </div>  
                                                                      <?php }else{ echo '<br>'; } ?>
                                                                    <?php 

                                                                    
                                                                    if(isset($order_row["varyantlar"])):
                                                                      $data = json_decode($order_row["varyantlar"], true);


                                                                      if ($data !== null) {
                                                                          // Döngü ile dizi elemanlarını yazdır
                                                                          foreach ($data as $key => $value) {
                                                                              echo '  '.$value["altVaryantTitle"].' ';
                                                                          }
                                                                      } 
                                                                      
                                                                    endif;
                                                                    if(!empty($order_row["parent_id"])):
                                                                        if($order_row["parent_id"] == 0 && empty($order_item["dopigo"])){
                                                                            echo '<label class="badge badge-sm badge-dim bg-danger text-danger">ALT ÜRÜN BULUNAMADI</label>';
                                                                        }
                                                                    endif; 

                                                                    
                                                                    ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="nk-tb-col d-md-none">
                                                        <div class="user-card">
                                                            <div class="user-avatar bg-transparent mt-3 mb-3">
                                                            <?php  if(isset($order_row["default_image"])): ?>
                                                                <a class="gallery-image popup-image" href="<?= base_url($order_row['default_image']) ?>">
                                                                    <img src="<?= base_url($order_row['default_image']) ?>" alt="image" class="w-100 rounded-top">
                                                                </a>
                                                                <?php else: ?>

                                                                <a class="gallery-image popup-image" href="<?= base_url("uploads/default.png") ?>">
                                                                <img src="<?= base_url("uploads/default.png") ?>" alt="image" class="w-100 rounded-top">
                                                                </a>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="user-name">
                                                                <span class="tb-lead"><?= $order_row['stock_title'] ?></span>
                                                                <strong><?php if(!empty($order_row['stock_code'])): $order_row['stock_code']; endif;  ?></strong><br>
                                                                <span><strong><?= number_format($order_row['unit_price'], session()->get('user_item')['para_yuvarlama'], ',', '.') . ' ' . $order_item['money_icon'] ?></strong></span>
                                                                |
                                                                <strong><?= number_format($order_row['stock_amount'], 2, ',', '.') . ' ' . $order_row['unit_title'] ?></strong>
                                                                |
                                                                <strong class="text-black"><?= number_format($order_row['subtotal_price'], 2, ',', '.') . ' ' . $order_item['money_icon'] ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="nk-tb-col tb-col-md minw-120">
                                                        <strong><?= number_format($order_row['stock_amount'], 2, ',', '.') . ' ' . $order_row['unit_title'] ?></strong>
                                                    </div>
                                                    
                                                    <div class="nk-tb-col tb-col-md minw-120">
                                                        <span><strong><?= number_format($order_row['unit_price'], session()->get('user_item')['para_yuvarlama'], ',', '.') . ' ' . $order_item['money_icon'] ?></strong></span>
                                                    </div>
                                                   
                                                    <div class="nk-tb-col tb-col-md text-end minw-120">
                                                        <strong class="text-black"><?= number_format($order_row['total_price'], 2, ',', '.') . ' ' . $order_item['money_icon'] ?></strong>
                                                    </div>
                                             
                                                </div>


                                            <?php } ?>

                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col tb-col-md text-end"></div>
                                                <div class="nk-tb-col tb-col-md"><strong>Mal/Hizmet Toplam </strong></div>
                                                <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                <div class="nk-tb-col text-end"> <?= number_format($order_item['stock_total'], 2, ',', '.') . ' ' . $order_item['money_icon'] ?><br> <?= $order_item['stock_total_try'] != 0 ? number_format($order_item['stock_total_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                            </div>

                                            <?php if ($order_item['discount_total'] != 0) { ?>
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col tb-col-md text-end"></div>
                                                    <div class="nk-tb-col tb-col-md"><strong>İskonto </strong></div>
                                                    <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                    <div class="nk-tb-col text-end"> <?= number_format($order_item['discount_total'], 2, ',', '.') . ' ' . $order_item['money_icon'] ?><br> <?= $order_item['discount_total_try'] != 0 ? number_format($order_item['discount_total_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                                </div>
                                            <?php } ?>

                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col tb-col-md text-end"></div>
                                                <div class="nk-tb-col tb-col-md"><strong>Ara Toplam </strong></div>
                                                <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                <div class="nk-tb-col text-end"> <?= number_format($order_item['sub_total'], 2, ',', '.') . ' ' . $order_item['money_icon'] ?><br> <?= $order_item['sub_total_try'] != 0 ? number_format($order_item['sub_total_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                            </div>

                                            <?php if($order_item['komisyon'] != 0): ?>
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col tb-col-md text-end"></div>
                                                <div class="nk-tb-col tb-col-md" ><strong style="color:#014ad0" >Banka Komisyonu  </strong></div>
                                                <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                <div class="nk-tb-col text-end" style="color:#014ad0"> <?= number_format($order_item['komisyon'], 2, ',', '.') . ' ' . $order_item['money_icon'] ?><br> <?= $order_item['komisyon'] != 0 ? number_format($order_item['komisyon'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                            </div>
                                            <?php endif; ?>
                                            <?php if ($order_item['tax_rate_1_amount'] != 0) { ?>
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col tb-col-md text-end"></div>
                                                    <div class="nk-tb-col tb-col-md"><strong>KDV Toplam (%1) </strong></div>
                                                    <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                    <div class="nk-tb-col text-end"> <?= number_format($order_item['tax_rate_1_amount'], 2, ',', '.') . ' ' . $order_item['money_icon'] ?><br> <?= $order_item['tax_rate_1_amount_try'] != 0 ? number_format($order_item['tax_rate_1_amount_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                                </div>
                                            <?php } ?>

                                            <?php if ($order_item['tax_rate_10_amount'] != 0) { ?>
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col tb-col-md text-end"></div>
                                                    <div class="nk-tb-col tb-col-md"><strong>KDV Toplam (%10) </strong></div>
                                                    <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                    <div class="nk-tb-col text-end"> <?= number_format($order_item['tax_rate_10_amount'], 2, ',', '.') . ' ' . $order_item['money_icon'] ?><br> <?= $order_item['tax_rate_10_amount_try'] != 0 ? number_format($order_item['tax_rate_10_amount_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                                </div>
                                            <?php } ?>

                                            <?php if ($order_item['tax_rate_20_amount'] != 0) { ?>
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col tb-col-md text-end"></div>
                                                    <div class="nk-tb-col tb-col-md"><strong>KDV Toplam (%20) </strong></div>
                                                    <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                    <div class="nk-tb-col text-end"> <?= number_format($order_item['tax_rate_20_amount'], 2, ',', '.') . ' ' . $order_item['money_icon'] ?><br> <?= $order_item['tax_rate_20_amount_try'] != 0 ? number_format($order_item['tax_rate_20_amount_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                                </div>
                                            <?php } ?>

                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col tb-col-md text-end"></div>
                                                <div class="nk-tb-col tb-col-md"><strong>Genel Toplam </strong></div>
                                                <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                <div class="nk-tb-col text-end"> <?= number_format($order_item['grand_total'], 2, ',', '.') . ' ' . $order_item['money_icon'] ?><br> <?= $order_item['grand_total_try'] != 0 ? number_format($order_item['grand_total_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                            </div>

                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col tb-col-md text-end"></div>
                                                <div class="nk-tb-col tb-col-md"><strong>Ödenecek Toplam </strong></div>
                                                <div class="nk-tb-col tb-col-md "><strong></strong> </div>
                                                <div class="nk-tb-col text-end"> <?= number_format($order_item['amount_to_be_paid'], 2, ',', '.') . ' ' . $order_item['money_icon'] ?><br> <?= $order_item['amount_to_be_paid_try'] != 0 ? number_format($order_item['amount_to_be_paid_try'], 2, ',', '.') . ' TRY' : '' ?> </div>
                                            </div>


                                            <!-- <div class="nk-tb-item">

                                                <div class="nk-tb-col tb-col-md text-end"></div>

                                                <div class="nk-tb-col tb-col-md">
                                                    <strong></strong>
                                                </div>
                                                <div class="nk-tb-col tb-col-md "><strong>ARA TOPLAM </strong> </div>
                                                <div class="nk-tb-col text-end">
                                                    <strong class="text-black"><?= number_format($order_item['sub_total'], 2, ',', '.') . ' ' . $order_item['money_icon'] ?></strong>
                                                </div>

                                            </div>
                                            <div class="nk-tb-item">

                                                <div class="nk-tb-col  tb-col-md text-end">
                                                </div>

                                                <div class="nk-tb-col tb-col-md">

                                                </div>
                                                <div class="nk-tb-col tb-col-md "><strong>İSKONTO (%0) </strong>
                                                </div>
                                                <div class="nk-tb-col text-end">
                                                    <strong class="text-black"> 0,00 ₺</strong>
                                                </div>

                                            </div>
                                            <div class="nk-tb-item">

                                                <div class="nk-tb-col  tb-col-md text-end">
                                                </div>

                                                <div class="nk-tb-col tb-col-md">

                                                </div>
                                                <div class="nk-tb-col tb-col-md "><strong>KDV (%20) </strong>
                                                </div>
                                                <div class="nk-tb-col text-end">
                                                    <strong class="text-black"> 7.368,80 ₺</strong>
                                                </div>

                                            </div>
                                            <div class="nk-tb-item" style="background-color: #f5f6fa;">

                                                <div class="nk-tb-col tb-col-md text-end">
                                                </div>

                                                <div class="nk-tb-col tb-col-md">

                                                </div>
                                                <div class="nk-tb-col tb-col-md "><strong>GENEL TOPLAM </strong>
                                                </div>
                                                <div class="nk-tb-col text-end">
                                                    <strong class="text-black">44.212,80 ₺</strong>
                                                </div>

                                            </div>
                                            <div class="nk-tb-item d-none">

                                                <div class="nk-tb-col tb-col-md text-end">
                                                </div>

                                                <div class="nk-tb-col tb-col-md">

                                                </div>
                                                <div class="nk-tb-col tb-col-md "><strong>ÖN ÖDEME (%25)</strong>
                                                </div>
                                                <div class="nk-tb-col text-end">
                                                    <strong class="text-black">0,00 ₺</strong>
                                                </div>

                                            </div> -->


                                            


                                        </div>
                                    </div>



                                    <?php if($order_item['komisyon'] != 0): ?>
                                        <div class="card-inner p-0" style="margin-top:40px;">
                                        <div class="nk-block">
                                           
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <div class="text-base" >
                                                       <b style="color:#014ad0">Banka komisyonu genel toplam tutardan çıkarılmıştır.</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                            <?php endif; ?>

                                    <?php if(!empty($order_item['order_note'])): ?>
                                    <div class="card-inner p-0" style="margin-top:40px;">
                                        <div class="nk-block">
                                            <div class="nk-block-head">
                                                <div class="nk-block-head-content">
                                                    <h5 class="title">Sipariş Notu</h5>
                                                </div>
                                            </div>
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <div class="text-base">
                                                        <?php if(!empty($order_item['order_note'])): ?>
                                                           <b> <p class="text-soft mb-0" style="color:black"><?= $order_item['order_note'] ?></p></b>
                                                        <?php else: ?>
                                                            <b><p class="text-soft mb-0">Sipariş notu bulunmamaktadır.</p></b>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    

                                </div><!-- data-list -->

                            </div><!-- .nk-block -->

                            
                        </div>

                        <?= $this->include('tportal/siparisler/detay/inc/sol_menu') ?>


                        
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

</script>

<?= $this->endSection() ?>