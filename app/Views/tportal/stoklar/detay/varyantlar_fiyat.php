<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Fiyat Güncelleme <?= $this->endSection() ?>
<?= $this->section('title') ?> Fiyat Güncelleme  | <?= $stock_item['stock_code']; ?> - <?= $stock_item['stock_title']; ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>

<style>
    .table td:last-child, .table th:last-child{
        padding-right: 0;
    }
</style>


<style>
    
    .dataTables_length{
        display: block!important;

    }
    .dataTables_length .form-control-select{
        display: block!important;
    }
    .dataTables_length span{
        display:block!important;
    }
</style>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap">
                        <div class="card-inner card-inner-lg">
                          


                            <ul class="link-list-menu">

                            <?php
                if (isset($stock_item['stock_id']) && $stock_item['stock_id'] != 0) {
                    echo '<li class="bg-gray-100"><a class="" href="' . route_to('tportal.stocks.detail', $stock_item['stock_id']) . '"><em class="icon ni ni-arrow-left"></em><span>Ürüne Dön</span></a></li>';
                }
                ?>
                </ul>

                            <div class="nk-block">
                                <div class="nk-data data-list">
                                    <table class="nowrap table  table-hover" style="border:1px solid #dedede">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2; width:120px">Kod
                                                </th>
                                                <?php
                                                            if(isset($variant_groups)){ 
                                                                  foreach($variant_groups as $variant_column_name => $variant_group_title){
                                                                    echo '
                                                                    <th style="background-color: #ebeef2;">'.$variant_group_title.'</th>
                                                                    ';
                                                                } }
                                                                ?>
                                               
                                                <th style="background-color: #ebeef2;" class="text-end">
                                                    Stok</th>
                                                    <th style="background-color: #ebeef2;" class="text-end">
                                                    B.Fiyat</th>
                                                    <th style="background-color: #ebeef2;" class="text-center">
                                                    Yeni Fiyat</th>
                                                <th style="background-color: #ebeef2;"></th>
                                            </tr>
                                        </thead>
                                        <form method="POST" action="<?= route_to('tportal.stocks.variant_price.multiple', $stock_item['stock_id']) ?>"> 
                                        <tbody>
                                           
                                                    
                                            <?php if(isset($variant_stocks)){  foreach($variant_stocks as $variant_stock){ ?>
                                                <tr class="">
                                                    <td class="text-black">
                                                        <?= $variant_stock['stock_code'] ?>
                                                    </td>
                                                    <?php if(isset($variant_groups)){  foreach($variant_groups as $variant_column_name => $variant_group_title){ ?>

                                                        <?php 
                                                            
                                                            if($variant_stock['variant_'.$variant_column_name]){   $ColorBlack = ""; $variant_title =  $variant_properties[$variant_stock['variant_'.$variant_column_name]];}else {
                                                                
                                                               $variant_title =  '';
                                                             
                                                               $ColorBlack = "ana_varyant";
                                                                
                                                                
                                                                } ?>
                                                        <td data-property="<?php echo $variant_title;  ?>" class="<?php echo $ColorBlack; ?>">
                                                           <span ><?php echo $variant_title;  ?></span>
                                                        </td>
                                                    <?php } } ?>
                                                    <td class="text-end stock">
                                                        <?= $variant_stock['stock_total_quantity'] != 0 ? number_format($variant_stock['stock_total_quantity'], 2,  '.') : 0; ?>
                                                    </td>
                                                    <td class="text-end para">
                                                        <?= number_format($variant_stock['sale_unit_price'], 4, ',', '').' '.$variant_stock['sale_money_icon'] ?>
                                                    </td>
                                                    <td class="text-center para" style="  ">
                                                    <div class="form-control-wrap"  style="    width: 60%; text-align:center; margin-left: auto; margin-right: auto;">
                                                            <div class="form-text-hint">
                                                                    <span class="overline-title"><em class="icon ni ni-sign-try"></em></span></div>
                                                            
                                                                    <input type="text" class="form-control" name="updated_prices[]" placeholder="">

                                                                </div>
                                                    </td>
                                                
                                                    <input type="hidden" name="stock_ids[]" value="<?= $variant_stock['stock_id'] ?>">

                                                </tr>
                                                <?php } }else{ ?>

                                                    <tr>
                                                    <td colspan="5" class="text-black text-center">
                                                      <b>  Ürün Bulunamadı</b>
                                                    </td>
                                                    
                                                </tr>

                                               <?php  } ?>


                                               

                                         
                                        </tbody>


                                    </table>
                                    <?php if(isset($variant_stocks)){ ?>
                                    <div class="card-inner">
                            <div class="row g-3">
                                <div class="col-6">
                                    
                                </div>
                                <div class="col-6 text-end">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary" >Fiyatları Güncelle</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                                    </form>

    

                                </div><!-- data-list -->
                            </div><!-- .nk-block -->
                        </div>
                    </div><!-- card-aside -->
                </div><!-- .card-aside-wrap -->
            </div><!-- .card -->
        </div><!-- .nk-block -->
    </div>
</div>



<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
   /*  $("td.ana_varyant").parent("tr").children("td").css("background-color", "#6597f066");


    $("input[name='updated_prices[]']").on('keyup', function() {
    var enteredValue = $(this).val();
    var property = $(this).closest("tr").find("td").eq(1);
    var bulgetir = $(this).closest("tr").find("td.ana_varyant");
    if(bulgetir.length > 0){
        let propery_deger = property.data("property");
        $("td[data-property='" + propery_deger + "']").closest('tr').find('input[name="updated_prices[]"]').val(enteredValue);

    } 
    
   
}); */
</script>
<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            title: 'Başarılı!',
            html: '<?= session()->getFlashdata('success') ?>',
            confirmButtonText: 'Tamam',
            allowEscapeKey: false,
            allowOutsideClick: false,
            icon: 'success',
        });
    </script>
<?php endif; ?>
<script>

</script>

<?= $this->endSection() ?>