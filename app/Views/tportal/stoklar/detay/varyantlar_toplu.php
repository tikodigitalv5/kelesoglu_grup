<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Toplu Varyant Ekleme <?= $this->endSection() ?>
<?= $this->section('title') ?> Toplu Varyant Ekleme | <?= $stock_item['stock_code'] ?> -
<?= $stock_item['stock_title'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




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
                                        <h4 class="nk-block-title">Toplu Varyant Ekleme</h4>
                                    </div>
                                    <div class="nk-block-head-content align-self-start">

                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                    <div class="card-inner-group">
                                        <form onsubmit="return false;" id="createVariantMultiple" method="post">
                                            <div class="card-inner position-relative card-tools-toggle">
                                                <div class="gy-3">
                                                    <?php
                                                    $parent_variant_id = 0;
                                                    foreach($variant_property_items as $variant_property_item){
                                                        if($parent_variant_id == 0){
                                                            echo '
                                                                <div class="row g-3 align-center variant-group-section" data-variant-column="'.$variant_property_item['variant_column'].'">
                                                                    <div class="col-lg-3 ">
                                                                        <div class="form-group"><b>'.$variant_property_item['variant_title'].'</b> <br><br>

                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input checkedAll"
                                                                                    data-variant-column-id="'.$variant_property_item['variant_column'].'"
                                                                                    name="variant_'.$variant_property_item['variant_column'].'"
                                                                                    id="chx_variant_'.$variant_property_item['variant_column'].'">
                                                                                <label class="custom-control-label" for="chx_variant_'.$variant_property_item['variant_column'].'">Tümünü Seç</label>
                                                                            </div>
                                                                            
                                                                            
                                                                        </div>  
                                                                    </div>
                                                                    <div class="col-lg-9  mt-0 mt-md-2">
                                                                        <div class="row g-3 align-center">
                                                            ';
                                                        }elseif($parent_variant_id != $variant_property_item['variant_group_id']){
                                                            echo '
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="row g-3 align-center variant-group-section" data-variant-column="'.$variant_property_item['variant_column'].'">
                                                                    <div class="col-lg-3 ">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="stock_type"><b>'.$variant_property_item['variant_title'].'</b></label><br><br>
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input checkedAll"
                                                                                    data-variant-column-id="'.$variant_property_item['variant_column'].'"
                                                                                    name="variant_'.$variant_property_item['variant_column'].'"
                                                                                    id="chx_variant_'.$variant_property_item['variant_column'].'">
                                                                                <label class="custom-control-label" for="chx_variant_'.$variant_property_item['variant_column'].'">Tümünü Seç</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-9  mt-0 mt-md-2">
                                                                        <div class="row g-3 align-center">
                                                            ';
                                                        }
                                                        echo '
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input checkSingle" id="variant_property_'.$variant_property_item['variant_property_id'].'"
                                                                    data-variant-property-title="'.$variant_property_item['variant_property_title'].'" 
                                                                    data-variant-property-code="'.$variant_property_item['variant_property_code'].'"
                                                                    name="variant_'.$variant_property_item['variant_column'].'" 
                                                                    value="'.$variant_property_item['variant_property_id'].'">
                                                                <label class="custom-control-label" for="variant_property_'.$variant_property_item['variant_property_id'].'">'.$variant_property_item['variant_property_title'].'</label>
                                                            </div>
                                                        </div>
                                                            ';
                                                        $parent_variant_id = $variant_property_item['variant_group_id'];
                                                    }
                                                    ?>
                                                    <?php if($variant_property_items){
                                                    echo '              
                                                            </div>
                                                        </div>
                                                    </div>
                                                        ';
                                                    } ?>
                                                </div>
                                            </div>

                                            <div class="card-inner">
                                                <div class="row g-3 pt-3">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <a href="javascript:history.back()"
                                                                class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex">
                                                                <em class="icon ni ni-arrow-left"></em>
                                                                <span>Geri</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <div class="form-group">
                                                            <button type="submit" id="variantTopluOlustur"
                                                                class="btn btn-lg btn-primary">Kaydet</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div><!-- data-list -->
                            </div><!-- .nk-block -->
                        </div>
                        <?= $this->include('tportal/stoklar/detay/inc/sol_menu') ?>
                    </div><!-- card-aside -->
                </div><!-- .card-aside-wrap -->
            </div><!-- .card -->
        </div><!-- .nk-block -->
    </div>
</div>

<button type="button" id="trigger_create_variant_multiple_info_modal" class="btn btn-success d-none"
    data-bs-toggle="modal" data-bs-target="#create_variant_multiple_info">Approve</button>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" id="create_variant_multiple_info">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em
                        class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent"></em>
                    <h4 class="nk-modal-title">Bazı Varyantlar Oluşturulamadı!</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text" id="info-caption-text"></div><br>
                        <ul id="failed_variant_items"></ul>
                    </div>
                    <div class="nk-modal-action">
                        <a href="#" class="btn btn-lg btn-mw btn-danger" id="approveInfo"
                            data-bs-dismiss="modal">Devam</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'variant_multiple',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="'.route_to('tportal.stocks.substocks', $stock_item['stock_id']).'" class="btn btn-l btn-primary btn-block">Varyant Listesi</a>'
            ]
        ],
    ]
); ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
$(document).ready(function() {
    
    var selectedName;
  $(".checkedAll").change(function(){

    selectedName = $(this).attr("name");
    console.log(selectedName);

    if(this.checked){
      $(".checkSingle[name='"+selectedName+"']").each(function(){
        this.checked=true;
      })              
    }else{
      $(".checkSingle[name='"+selectedName+"']").each(function(){
        this.checked=false;
      })              
    }
  });

  $(".checkSingle").click(function () {
    if ($(this).is(":checked")){

        var selectedName = $(this).attr("name");
        console.log(selectedName);

      var isAllChecked = 0;
      $(".checkSingle[name='"+selectedName+"']").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $(".checkedAll[name='"+selectedName+"']").prop("checked", true); }     
    }else {
      var unchx = $(this).attr("name")

      $(".checkedAll[name='"+unchx+"']").prop("checked", false);
      console.log("seçiliden gitti");
    }
  });
});

$('#variantTopluOlustur').on('click', function() {
    $('#failed_variant_items').empty();
    var list = [];
    var temp_list = [];
    var temp_item = [];
    var temp_items = [];
    $(".variant-group-section").each(function(index, element) {
        var variant_column = $(this).attr('data-variant-column')
        var temp_str = "variant_" + variant_column;

        $("input[name='" + temp_str + "']:checked").each(function(index, element) {
            var variant_property_code = $(this).attr('data-variant-property-code')
            var variant_property_title = $(this).attr('data-variant-property-title')
            var variant_property_id = $(this).val()

            if (variant_property_code != null || variant_property_code != undefined) {
                temp_list.push({
                    name: 'variant_property_code',
                    value: variant_property_code
                });
                temp_list.push({
                    name: 'variant_property_id',
                    value: variant_property_id
                });
                temp_list.push({
                    name: 'variant_property_title',
                    value: variant_property_title
                });
                temp_list.push({
                    name: 'variant_column',
                    value: variant_column
                });
                temp_item.push({
                    name: 'variant_item',
                    value: temp_list
                });

                console.log("variant_property_code",variant_property_code);
                if (variant_property_code != undefined) {
                    list.push({
                        name: temp_str,
                        value: temp_item
                    });
                }
                
                temp_item = [];
                temp_list = [];
            }
        });
    });
    if ($.isEmptyObject(list)) {
        swetAlert("Hatalı İşlem", "Devam etmek için lütfen en az bir adet varyant seçiniz. ", "err");
        return;
    }

    console.log(list);

    Swal.fire({
        title: 'Kaydetmek Üzeresiniz!',
        html: 'Toplu varyant ekleme işleminizi kaydetmek üzeresiniz.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Devam Et',
        cancelButtonText: 'Düzenle',
        allowEscapeKey: false,
        allowOutsideClick: false,

    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Varyantlar oluşturuluyor...',
                html: 'Varyantlar oluşturulurken lütfen bekleyiniz...',
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
                url: '<?= route_to('tportal.stocks.variant_store.multiple', $stock_item['stock_id']) ?>',
                dataType: 'json',
                data: {
                    params: JSON.stringify(list)
                },
                async: true,
                success: function (response) {
                    swal.close();
                    console.log(response)
                    if (response['icon'] == 'success') {
                        $("#trigger_variant_multiple_ok_button").trigger("click");
                    } else if (response['icon'] == 'warning') {
                        $("#info-caption-text").html(response['message']);
                        $.each(response['failed_items'], function (key, failed_item) {
                            jQuery('<li>', {
                                html: '<b>' + failed_item + '</b>'
                            }).appendTo('#failed_variant_items');
                        });
                        $("#trigger_create_variant_multiple_info_modal").trigger("click");
                    } else {
                        swetAlert("Hatalı İşlem", response['message'], "err");
                    }
                }
            })
        }
        else {
            console.log("düzenlemeye devamm");
        }
    });
})

$('#approveInfo').on('click', function(){
    $("#trigger_variant_multiple_ok_button").trigger("click");
})
</script>

<?= $this->endSection() ?>