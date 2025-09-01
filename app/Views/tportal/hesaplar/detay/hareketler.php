<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Hesap Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Hesap Detay | <?= $financial_account_item['account_title'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection(); helper('Helpers\date_helper'); ?>




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
                                        <h4 class="nk-block-title">Hesap Hareketleri</h4>
                                    </div>
                                    <div class="nk-block-head-content align-self-start">
                                        <a href="<?= route_to('tportal.hesaplar.hareketler.detayli') ?>"
                                            class="btn btn-dim btn-outline-light">Detaylı Hareketler</a>
                                        <a href="<?= route_to('tportal.financial_accounts.payment_or_collection_create',$financial_account_item['financial_account_id']) ?>"
                                            class="btn btn-primary">İşlem Ekle</a>
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1 d-lg-none"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                    <table class="datatable-init-hareketler  table"
                                        data-export-title="Hesap Hareketleri">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2; width:80px">Tarih</th>
                                                <th style="background-color: #ebeef2; width:50px" data-orderable="false">İşlem</th>
                                                <th style="background-color: #ebeef2; width:100px!important" data-orderable="false">Bilgi</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Miktar</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Bakiye</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                     
                                                foreach ($financial_movement_items as $financial_movement_item) {
                                                   
                                                    ?>
                                            <tr>
                                                <td data-order="<?= $financial_movement_item['transaction_date'] . $financial_movement_item['financial_movement_id'] ?>"><?= convert_date_for_view($financial_movement_item['transaction_date']); ?>
                                                </td>
                                                <td><span
                                                        class="tb-status <?= $financial_movement_item['transaction_direction'] == 'entry' ? "text-success" : "text-danger" ?>"><?= $financial_movement_item['transaction_type'] == 'starting_balance' ? 'Başlangıç Bakiyesi' : ($financial_movement_item['transaction_direction'] == 'entry' ? 'Giriş' : 'Çıkış')?></span>
                                                </td>
                                                <td>  <?= $financial_movement_item['transaction_title'] ?>
                                            <?php 
                                            if(isset($financial_movement_item['invoice_title'])){
                                                echo '<br> CARİ: ' . $financial_movement_item['invoice_title'];
                                            } ?>
                                            </td>
                                                <td class="text-end para">
                                                <?php if($financial_movement_item["virman"] != 0){ ?>
                                                                        <?= convert_number_for_form($financial_movement_item['transaction_amount'], 2) ?>
                                                                        <?= $financial_account_item['money_icon'] ?>
                                                                        <br>
                                                                        (<?= convert_number_for_form($financial_movement_item['virman'], 2) ?> 
                                                                            <?php if($financial_account_item['money_icon'] == "$") { echo 'TRY'; } ?>
                                                                        )

                                                                     

                                                                    <?php }else{ ?>
                                                                        <?= convert_number_for_form($financial_movement_item['transaction_amount'], 2) ?>
                                                                        <?= $financial_account_item['money_icon'] ?>
                                                                   <?php  } ?>
                                                                  
                                                </td>
                                                <td class="text-end para"><span
                                                        class="tb-status  "><?= convert_number_for_form($temp_balance, 2) . $financial_account_item['money_icon'] ?></span>
                                                </td>
                                            </tr>
                                            <?php

if($financial_movement_item["virman"] != 0){ 
  // $transaction_amounts = $financial_movement_item['virman'];
  $transaction_amounts = $financial_movement_item['transaction_amount'];
}else{
   $transaction_amounts = $financial_movement_item['transaction_amount'];
 } 
                                               $temp_balance = $financial_movement_item['transaction_direction'] == 'entry' ? $temp_balance + $transaction_amounts : $temp_balance - $transaction_amounts;
                                           } ?>

                                        </tbody>
                                    </table>
                                </div><!-- data-list -->
                            </div><!-- .nk-block -->
                        </div>
                        <?= $this->include('tportal/hesaplar/detay/inc/sol_menu') ?>
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