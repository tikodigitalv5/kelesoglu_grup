
<?php 
if(session()->get('user_item')['user_id'] == 13){
    $title = "Koleksiyonlar";
    $title_new = "Koleksiyon";
}else{
    $title = "Markalar";
    $title_new = "Marka";
}

$AltCategory = altkategorilerHelper();
if(!isset($stock_item['altcategory_id']))
{
    $stock_item['altcategory_id'] = 0;
}
?>

<div class="row g-3 align-center">
                                                    <div class="col-lg-5 col-xxl-5 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="alt_category_id"><?php echo $title; ?></label><span
                                                                class="form-note d-none d-md-block">Ürünün ait olduğu
                                                                <?php echo $title; ?>.</span></div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap ">
                                                                <div class="form-control-select">
                                                                    <select required=""
                                                                        class="form-control select2 form-control-xl"
                                                                        name="alt_category_id" id="alt_category_id" >
                                                                        <option value="" >Lütfen Seçiniz
                                                                        </option>
                                                                        <?php 
                                                                    foreach($AltCategory as $category_item){ ?>
                                                                        <option
                                                                            value="<?= $category_item['alt_category_id'] ?>"
                                                                            <?php if($stock_item['altcategory_id'] == $category_item['alt_category_id']){ echo 'selected'; } ?>>
                                                                            <?= $category_item['alt_category_title'] ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>