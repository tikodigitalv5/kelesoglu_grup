<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Varyantlar <?= $this->endSection() ?>
<?= $this->section('title') ?> Varyantlar | <?= $stock_item['stock_code']; ?> - <?= $stock_item['stock_title']; ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>

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
                            <div class="nk-block-head nk-block-head-lg">
                            <ul class="link-list-menu">

<?php
if (isset($stock_item['stock_id']) && $stock_item['stock_id'] != 0) {
echo '<li class="bg-gray-100"><a class="" href="' . route_to('tportal.stocks.detail', $stock_item['stock_id']) . '"><em class="icon ni ni-arrow-left"></em><span>Ürüne Dön</span></a></li>';
}
?>
</ul>
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Varyantlar</h4>
                                    </div>
                                    <div class="nk-block-head-content align-self-start">
                                    
                                <?= view_cell('App\Libraries\ViewComponents::getComponent', ['component_name' => 'stoklar.detay.topluvaryant.buton']); ?>
                                        <a href="#" class="btn btn-md btn-primary" data-bs-toggle="modal"
                                            <?php if($variant_property_items){echo 'data-bs-target="#mdl_variant_create"'; } ?> id="new_variant">Yeni Varyant</a>
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1 d-lg-none"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                                
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                    <table class="nowrap table datatable-init-hareketler">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2; width:120px">Kod
                                                </th>
                                                <?php
                                                                foreach($variant_groups as $variant_column_name => $variant_group_title){
                                                                    echo '
                                                                    <th style="background-color: #ebeef2;">'.$variant_group_title.'</th>
                                                                    ';
                                                                }
                                                                ?>
                                                <th style="background-color: #ebeef2;" class="text-end">
                                                    B.Fiyat</th>
                                                <th style="background-color: #ebeef2;" class="text-end">
                                                    Stok</th>
                                                <th style="background-color: #ebeef2;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($variant_stocks as $variant_stock){ ?>
                                            <tr>
                                                <td class="text-black">
                                                    <?= $variant_stock['stock_code'] ?>
                                                </td>
                                                <?php foreach($variant_groups as $variant_column_name => $variant_group_title){ ?>
                                                    <td>
                                                        <?php if($variant_stock['variant_'.$variant_column_name]){echo $variant_properties[$variant_stock['variant_'.$variant_column_name]];}else {echo '-';} ?>
                                                    </td>
                                                <?php } ?>
                                                <td class="text-end para">
                                                    <?= number_format($variant_stock['sale_unit_price'], 4, ',', '').' '.$variant_stock['sale_money_icon'] ?>
                                                </td>
                                                <td class="text-end stock">
                                                    <?= $variant_stock['stock_total_quantity'] != 0 ? number_format($variant_stock['stock_total_quantity'], 2, ',', '.') : 0; ?>
                                                </td>
                                                <td class="text-end">
                                                    <a href="<?= route_to('tportal.stocks.detail', $variant_stock['stock_id']) ?>" class="btn btn-round btn-icon btn-outline-light btn-xs">
                                                    <em class="icon ni ni-chevron-right"></em></a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                    <!-- Modal Alert 2 -->
                                    <div class="modal fade" tabindex="-1" id="mdl_variant_edit">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Varyant Düzenle</h5>
                                                    <a href="#" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <em class="icon ni ni-cross"></em>
                                                    </a>
                                                </div>
                                                <div class="modal-body bg-white">
                                                    <form onsubmit="return false;" id="editVariantForm" method="post"
                                                        class="form-validate is-alter">
                                                        <div class="row g-3 align-center mb-4">
                                                            <label class="form-label" for="type_title">Geçerli
                                                                Ürün</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control form-control-xl"
                                                                    disabled placeholder="" id="stock_id"
                                                                    name="stock_id"
                                                                    value="<?= $stock_item['stock_code'] ?> - <?= $stock_item['stock_title'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row g-3 align-center mb-4">
                                                            <label class="form-label"
                                                                for="edit_substock_code">Kod</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control form-control-xl"
                                                                    placeholder="Kod" id="edit_substock_code"
                                                                    name="substock_code" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="row g-3 align-center mb-4">
                                                            <label class="form-label" for="edit_substock_title">Varyant
                                                                Adı</label>
                                                            <div class="form-control-wrap">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control form-control-xl"
                                                                        placeholder="Alt Ürün Adını Giriniz"
                                                                        id="edit_substock_title" name="substock_title"
                                                                        required value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3 align-center">
                                                            <div class="col-lg-6 ">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="edit_sale_unit_price">Birim Fiyat
                                                                        <small>( KDV Hariç)</small>
                                                                    </label>
                                                                    <span class="form-note d-none d-md-block">Ürünün
                                                                        birim fiyat bilgisi</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 mt-0 mt-md-2 d-flex">
                                                                <div class="col-8 pe-2">
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <input type="text"
                                                                                class="form-control form-control-xl"
                                                                                id="edit_sale_unit_price" value=""
                                                                                placeholder="15,8700"
                                                                                name="sale_unit_price"
                                                                                onkeypress="return SadeceRakam(event,[',','-']);">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap ">
                                                                            <div class="form-control-select">
                                                                                <select disabled required=""
                                                                                    class="form-control select2 form-control-xl"
                                                                                    name="edit_money_unit_id"
                                                                                    id="edit_money_unit_id">
                                                                                    <option value="" disabled>Lütfen
                                                                                        Seçiniz
                                                                                    </option>
                                                                                    <?php 
                                                                                    foreach($money_unit_items as $money_unit_item){ ?>
                                                                                    <option
                                                                                        value="<?= $money_unit_item['money_unit_id'] ?>"
                                                                                        <?php if($money_unit_item['money_unit_id'] == $stock_item['sale_unit_id']){ echo 'selected'; } ?>>
                                                                                        <?= $money_unit_item['money_code'] ?>
                                                                                    </option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer d-block p-3 bg-white">
                                                    <div class="row">
                                                        <div class="col-md-4 p-0">
                                                            <button type="button" id="btn_hesapyeniekle_mdl"
                                                                class="btn btn-lg  btn-dim btn-outline-light"
                                                                data-bs-dismiss="modal">KAPAT</button>
                                                        </div>
                                                        <div class="col-md-8 text-end p-0">
                                                            <!-- <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ HESAP</button> -->
                                                            <button type="button" id="variantKaydet"
                                                                class="btn btn-lg btn-primary ">KAYDET</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Alert 2 -->
                                    <div class="modal fade" tabindex="-1" id="mdl_variant_create">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Yeni Varyant</h5>
                                                    <a href="#" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <em class="icon ni ni-cross"></em>
                                                    </a>
                                                </div>
                                                <div class="modal-body bg-white">
                                                    <form onsubmit="return false;" id="createVariantModalForm"
                                                        method="post" class="form-validate is-alter">
                                                        <div class="form-group">
                                                            <label class="form-label" for="stock_title">Geçerli
                                                                Ürün</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control form-control-xl"
                                                                    disabled placeholder="" id="stock_id"
                                                                    name="stock_id"
                                                                    value="<?= $stock_item['stock_code'] ?> - <?= $stock_item['stock_title'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row g-3 align-center mb-4">
                                                            <div class="col-4">
                                                                <?php 
                                                                $parent_variant_id = 0;
                                                                foreach($variant_property_items as $variant_property_item){
                                                                    if($parent_variant_id == 0){
                                                                        echo '
                                                                        
                                                                            <label class="form-label" for="type_title">'.$variant_property_item['variant_title'].'</label>
                                                                            <div class="form-control-wrap">
                                                                                <select class="form-select init-select2 stock_variant_select"
                                                                                    data-search="on" data-ui="lg" name="'.$variant_property_item['variant_group_id'].'_select"
                                                                                    id="'.$variant_property_item['variant_group_id'].'"
                                                                                    data-variant-column-name="'.$variant_property_item['variant_column'].'" required>
                                                                                    <option value="">Lütfen Seçiniz</option>
                                                                        ';
                                                                    }elseif($parent_variant_id != $variant_property_item['variant_group_id']){
                                                                        echo '
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label class="form-label" for="type_title">'.$variant_property_item['variant_title'].'</label>
                                                                            <div class="form-control-wrap">
                                                                                <select class="form-select  init-select2 stock_variant_select"
                                                                                    data-search="on" data-ui="lg" name="'.$variant_property_item['variant_group_id'].'_select"
                                                                                    id="'.$variant_property_item['variant_group_id'].'" data-variant-column-name="'.$variant_property_item['variant_column'].'" required>
                                                                                    <option value="">Lütfen Seçiniz</option>                
                                                                        ';
                                                                    }
                                                                    echo '
                                                                            <option data-variant-column="'.$variant_property_item['variant_column'].'" data-property-title="'.$variant_property_item['variant_property_title'].'" data-property-code="'.$variant_property_item['variant_property_code'].'" value="'.$variant_property_item['variant_property_id'].'">'.$variant_property_item['variant_property_title'].'</option>
                                                                        ';
                                                                    $parent_variant_id = $variant_property_item['variant_group_id'];
                                                                }
                                                                ?>
                                                                <?php if($variant_property_items){
                                                                    echo '
                                                                    </select>
                                                                </div>
                                                                    ';
                                                                } ?>
                                                            </div>  
                                                        </div>
                                                        <div class="row g-3 align-center mt-0 mb-2">
                                                            <label class="form-label" for="create_variant_title">Varyant
                                                                Adı</label>
                                                            <div class="form-control-wrap mt-0">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control form-control-xl"
                                                                        placeholder="Varyant Adını Giriniz"
                                                                        id="create_variant_title" name="variant_title"
                                                                        required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3 align-center mt-0 mb-2">
                                                            <label class="form-label" for="create_variant_code">Varyant
                                                                Kodu</label>
                                                            <div class="form-control-wrap mt-0">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div
                                                                            class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                            <span
                                                                                id="create_variant_code_bas"><?= $stock_item['stock_code'] ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <input type="text" id="create_variant_code"
                                                                        name="variant_code"
                                                                        class="form-control form-control-xl"
                                                                        placeholder="Varyant Kodu">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3 align-center mt-0 mb-2">
                                                            <label class="form-label"
                                                                for="create_variant_barcode">Varyant
                                                                Barkod Kodu</label>
                                                            <div class="form-control-wrap mt-0">
                                                                <input type="text" class="form-control form-control-xl"
                                                                    placeholder="Yoksa otomatik oluşacaktır"
                                                                    id="create_variant_barcode" name="variant_barcode"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer d-block p-3 bg-white">
                                                    <div class="row">
                                                        <div class="col-md-4 p-0">
                                                            <button type="button" id="btn_hesapyeniekle_mdl"
                                                                class="btn btn-lg  btn-dim btn-outline-light"
                                                                data-bs-dismiss="modal">KAPAT</button>
                                                        </div>
                                                        <div class="col-md-8 text-end p-0">
                                                            <!-- <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ HESAP</button> -->
                                                            <button type="button" id="variantOlustur"
                                                                class="btn btn-lg btn-primary ">KAYDET</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- data-list -->
                            </div><!-- .nk-block -->
                        </div>
                    </div><!-- card-aside -->
                </div><!-- .card-aside-wrap -->
            </div><!-- .card -->
        </div><!-- .nk-block -->
    </div>
</div>

<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'variant',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="#" id="stockDetail" class="btn btn-info btn-block mb-2">Bu Varyantın (<span class="fw-bold" id="new_stock_code"></span>) Detayına Git</a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#mdl_variant_create" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Varyant Ekle</a>
                                    <a href="#" onclick="location.reload()" class="btn btn-l btn-dim btn-outline-dark btn-block">Varyant Listesi</a>'
            ],
            'delete' => [
                'modal_title' => 'Bu Varyantı Silmek İstediğinize<br>Emin misiniz?',
                'modal_text' => 'Bu varyantı silmeden önce lütfen yetkilinize danışınız.',
            ]
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>

$('document').ready(function () {
    var myVar = $("#DataTables_Table_0_wrapper").find('.with-export').removeClass('d-none');
    var myVar2 = $("#DataTables_Table_0_wrapper").find('.with-export').css("margin-bottom","10px");
})

$('.stock_variant_select').on('change', function() {
    tempTitle = '<?= $category_item['variant_title_template'] ?>'
    new_variant_stock_code = '';
    parent_title = '<?= $stock_item['stock_title'] ?>';

    if(tempTitle.includes('[PRODUCT_TITLE]')){
        tempTitle = tempTitle.replace('[PRODUCT_TITLE]', parent_title)
    }

    $('.stock_variant_select').each(function(index) {
        variant_property_title = $(this).find(":selected").attr('data-property-title');
        variant_property_code = $(this).find(":selected").attr('data-property-code');
        variant_column = $(this).find(":selected").attr('data-variant-column');

        if (variant_property_title != undefined) {
            if(tempTitle.includes('[VARIANT_' + variant_column + ']')){
                tempTitle = tempTitle.replace('[VARIANT_' + variant_column + ']', variant_property_title + ' ')
            }else {
                tempTitle += ' ' + variant_property_title;
            }
        }
        if (variant_property_code != undefined) {
            new_variant_stock_code += variant_property_code;
        }

        console.log('code: ' + new_variant_stock_code);
    })

    $('#create_variant_title').val(tempTitle);
    $('#create_variant_code').val(new_variant_stock_code);
});

$('#variantOlustur').click(function(e) {
    e.preventDefault();
    if ($('#create_variant_code').val() == '' ||
        $('#create_variant_title').val() == '') {
        swetAlert("Eksik Birşeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
    } else {
        var formData = $('#createVariantModalForm').serializeArray();
        var all_stock_variant = [];
        $('.stock_variant_select').each(function(index) {
            all_stock_variant.push({
                name: $(this).attr('data-variant-column-name'),
                value: $(this).find(":selected").val()
            })
        })
        formData.push({
            name: 'stock_variant',
            value: all_stock_variant
        })

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
                    url: '<?= route_to('tportal.stocks.variant_create', $stock_item['stock_id']) ?>',
                    dataType: 'json',
                    data: {
                        params: JSON.stringify(formData)
                    },
                    async: true,
                    success: function (response) {
                        swal.close();
                        if (response['icon'] == 'success') {
                            $('#createVariantModalForm')[0].reset();
                            $('#stockDetail').attr('href', '<?= route_to('tportal.stocks.detail.null')?>/' +
                                response['new_stock_id'])
                            $('#new_stock_code').html(response['new_stock_code'])
                            $("#trigger_variant_ok_button").trigger("click");
                            $(".stock_variant_select").select2({
                                placeholder: "",
                                allowClear: false
                            });
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
    }
});

<?php
if(!$variant_property_items){
    echo '
    $("#new_variant").on("click", function(){
        swetAlert("Hatalı İşlem", "Lütfen önce varyant özelliği tanımlayınız", "err");
    })

    $("#new_variants").on("click", function(){
        swetAlert("Hatalı İşlem", "Lütfen önce varyant özelliği tanımlayınız", "err");
    })
    ';
}
?>

</script>

<?= $this->endSection() ?>