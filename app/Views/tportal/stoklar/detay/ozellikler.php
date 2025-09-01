<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Ürün Düzenleme <?= $this->endSection() ?>
<?= $this->section('title') ?> Ürün Düzenleme | <?= $stock_item['stock_code'] ?> - <?= $stock_item['stock_title'] ?><?= $this->endSection() ?>
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
                                        <h4 class="nk-block-title">Ürün Özellikleri</h4>

                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="card-inner-group">
                                    <form onsubmit="return false;" id="saveStock" method="post">
                                     
                                        <div class="card-inner position-relative card-tools-toggle  px-0">
                                            <div class="gy-3">
                                            <div class="row g-3 align-center">
                                                <div class="col-md-3 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="supplier_stock_code">Ürünün Eni</label><span
                                                                class="form-note d-none d-md-block">Ürünün enini giriniz.</span></div>
                                                    </div>
                                                    <div class="col-md-4 mt-0 mt-md-2 d-flex">
                                                        <div class="col-6 pe-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap"><input type="text" class="form-control form-control-xl text-end" id="buy_unit_price" value="0,00" placeholder="0,00" name="buy_unit_price" onkeypress="return SadeceRakam(event,[',','-']);">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap ">
                                                                    <div class="form-control-select">
                                                                        <select required="" class="form-control select2 form-control-xl" name="buy_money_unit_id" id="buy_money_unit_id">
                                                                            <option value="" disabled="">Lütfen Seçiniz
                                                                            </option>
                                                                                                                                                        <option value="1">
                                                                                Adet                                                                            </option>
                                                                                                                                                        <option value="2">
                                                                                mm                                                                            </option>
                                                                                                                                                        <option value="3" selected="">
                                                                                cm                                                                            </option>
                                                                                                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                    </div>
                                                </div>

                                                <div class="row g-3 align-center">
                                                <div class="col-md-3 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="supplier_stock_code">Ürünün Boyu</label><span
                                                                class="form-note d-none d-md-block">Ürünün boyunu giriniz.</span></div>
                                                    </div>
                                                    <div class="col-md-4 mt-0 mt-md-2 d-flex">
                                                        <div class="col-6 pe-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap"><input type="text" class="form-control form-control-xl text-end" id="buy_unit_price" value="0,00" placeholder="0,00" name="buy_unit_price" onkeypress="return SadeceRakam(event,[',','-']);">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap ">
                                                                    <div class="form-control-select">
                                                                        <select required="" class="form-control select2 form-control-xl" name="buy_money_unit_id" id="buy_money_unit_id">
                                                                            <option value="" disabled="">Lütfen Seçiniz
                                                                            </option>
                                                                                                                                                        <option value="1">
                                                                                Adet                                                                            </option>
                                                                                                                                                        <option value="2">
                                                                                mm                                                                            </option>
                                                                                                                                                        <option value="3" selected="">
                                                                                cm                                                                            </option>
                                                                                                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                    </div>
                                                </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-md-3 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="supplier_stock_code">Ürünün Kalınlığı</label><span
                                                                class="form-note d-none d-md-block">Ürünün kalınlığını giriniz.</span></div>
                                                    </div>
                                                    <div class="col-md-4 mt-0 mt-md-2 d-flex">
                                                        <div class="col-6 pe-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap"><input type="text" class="form-control form-control-xl text-end" id="buy_unit_price" value="0,00" placeholder="0,00" name="buy_unit_price" onkeypress="return SadeceRakam(event,[',','-']);">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap ">
                                                                    <div class="form-control-select">
                                                                        <select required="" class="form-control select2 form-control-xl" name="buy_money_unit_id" id="buy_money_unit_id">
                                                                            <option value="" disabled="">Lütfen Seçiniz
                                                                            </option>
                                                                                                                                                        <option value="1">
                                                                                Adet                                                                            </option>
                                                                                                                                                        <option value="2">
                                                                                mm                                                                            </option>
                                                                                                                                                        <option value="3" selected="">
                                                                                cm                                                                            </option>
                                                                                                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                    </div>
                                                </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-md-3 ">
                                                        <div class="form-group"><label class="form-label"
                                                                for="supplier_stock_code">Ürünün Özkütlesi</label><span
                                                                class="form-note d-none d-md-block">Ürünün özkütlesini giriniz.</span></div>
                                                    </div>
                                                    <div class="col-md-4 mt-0 mt-md-2 d-flex">
                                                        <div class="col-6 pe-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap"><input type="text" class="form-control form-control-xl text-end" id="buy_unit_price" value="0,00" placeholder="0,00" name="buy_unit_price" onkeypress="return SadeceRakam(event,[',','-']);">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap ">
                                                                    <div class="form-control-select">
                                                                        <select required="" class="form-control select2 form-control-xl" name="buy_money_unit_id" id="buy_money_unit_id">
                                                                            <option value="" disabled="">Lütfen Seçiniz
                                                                            </option>
                                                                                                                                                        <option value="1">
                                                                                Adet                                                                            </option>
                                                                                                                                                        <option value="2">
                                                                                mm                                                                            </option>
                                                                                                                                                        <option value="3" selected="">
                                                                                cm                                                                            </option>
                                                                                                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                  
                                        <div class="card-inner">
                                            <div class="row g-3 pt-3">
                                                <div class="col-6">
                                                   
                                                </div>
                                                <div class="col-6 text-end">
                                                    <div class="form-group">
                                                        <button type="submit" id="stokKaydet"
                                                            class="btn btn-lg btn-primary">Kaydet</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                            </div><!-- .nk-block -->
                        </div>


                        <?= $this->include('tportal/stoklar/detay/inc/sol_menu') ?>
                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'stock',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Ürün/Hizmet Başarıyla Güncellendi.',
                'modal_buttons' => '<a href="#" onclick="location.reload()" id="stockDetail" class="btn btn-info btn-block mb-2">Bu Ürün/Hizmetin Detayına Git</a>
                                    <a href="'.route_to('tportal.stocks.create').'" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Ürün/Hizmet Ekle</a>
                                    <a href="'.route_to('tportal.stocks.list','all').'" class="btn btn-l btn-dim btn-outline-dark btn-block">Tüm Stoklar</a>'
            ],
        ],
    ]
); ?>



<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
$(document).ready(function() {
    $('#starting_stock_unit').html($('#buy_unit_id').find(":selected").html())
    $('#critical_stock_unit').html($('#buy_unit_id').find(":selected").html())
})
$('#stokKaydet').click(function(e) {
    e.preventDefault();
    if ($('#stock_title').val() == '' ||
        $('#stock_code').val() == '') {
        swetAlert("Eksik Birşeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
    } else {
        var formData = $('#saveStock').serializeArray();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.edit', $stock_item['stock_id']) ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    $("#trigger_stock_ok_button").trigger("click");
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })

                    Toast.fire({
                        icon: response['icon'],
                        title: response['message']
                    })
                }
            }
        })
    }
});

function calculateWithTax(price_type) {
    if ($('#' + price_type + '_unit_price').val() != null && $('#' + price_type + '_unit_price').val() != '') {
        tempValue = $('#' + price_type + '_unit_price').val()
        if (String(tempValue).includes(",")) {
            tempValue = tempValue.replace(',', '.')
            tempValue = parseFloat(tempValue).toFixed(4)
        } else {
            tempValue = parseFloat(tempValue).toFixed(4)
        }
        tax_rate = $('#' + price_type + '_tax_rate').val();
        new_unit_price_with_tax = tempValue * (1 + (parseFloat(tax_rate) / 100))
        tempValue = replace_for_form_input(tempValue)
        new_unit_price_with_tax = replace_for_form_input(new_unit_price_with_tax.toFixed(4))

        $('#' + price_type + '_unit_price').val(tempValue)
        $('#' + price_type + '_unit_price_with_tax').val(new_unit_price_with_tax)
    } else {
        $('#' + price_type + '_unit_price').val('0,0000')
        $('#' + price_type + '_unit_price_with_tax').val('0,0000')
    }
}

function calculateWithNoTax(price_type) {
    if ($('#' + price_type + '_unit_price_with_tax').val() != null && $('#' + price_type + '_unit_price_with_tax')
        .val() != '') {
        tempValue = $('#' + price_type + '_unit_price_with_tax').val();

        if (String(tempValue).includes(",")) {
            tempValue = tempValue.replace(',', '.')
            tempValue = parseFloat(tempValue).toFixed(4)
        } else {
            tempValue = parseFloat(tempValue).toFixed(4)
        }
        tax_rate = $('#' + price_type + '_tax_rate').val();
        new_unit_price = tempValue / (1 + (parseFloat(tax_rate) / 100))
        tempValue = replace_for_form_input(tempValue)
        new_unit_price = replace_for_form_input(new_unit_price.toFixed(4))

        $('#' + price_type + '_unit_price_with_tax').val(tempValue)
        $('#' + price_type + '_unit_price').val(new_unit_price)
    } else {
        $('#' + price_type + '_unit_price_with_tax').val('0,0000')
        $('#' + price_type + '_unit_price').val('0,0000')
    }
}

$('#buy_unit_price').on('blur', function() {
    calculateWithTax('buy');
})

$('#buy_unit_price_with_tax').on('blur', function() {
    calculateWithNoTax('buy')
})

$('#sale_unit_price').on('blur', function() {
    calculateWithTax('sale')
})

$('#sale_unit_price_with_tax').on('blur', function() {
    calculateWithNoTax('sale')
})

$('#buy_tax_rate').on('change', function() {
    calculateWithTax('buy')
})

$('#sale_tax_rate').on('change', function() {
    calculateWithTax('sale')
})

$('#buy_unit_id').on('change', function() {
    ;
    $('#starting_stock_unit').html($('#buy_unit_id').find(":selected").html())
    $('#critical_stock_unit').html($('#buy_unit_id').find(":selected").html())
})

$('#starting_stock').on('blur', function() {
    if ($('#starting_stock').val() != null && $('#starting_stock').val() != '') {
        tempValue = $('#starting_stock').val()
        if (String(tempValue).includes(",")) {
            tempValue = tempValue.replace(',', '.')
            tempValue = parseFloat(tempValue).toFixed(4)
        } else {
            tempValue = parseFloat(tempValue).toFixed(4)
        }
        tempValue = replace_for_form_input(tempValue)

        $('#starting_stock').val(tempValue)
    } else {
        $('#starting_stock').val('0,0000')
    }
})

$('#critical_stock').on('blur', function() {
    if ($('#critical_stock').val() != null && $('#critical_stock').val() != '') {
        tempValue = $('#critical_stock').val()
        if (String(tempValue).includes(",")) {
            tempValue = tempValue.replace(',', '.')
            tempValue = parseFloat(tempValue).toFixed(4)
        } else {
            tempValue = parseFloat(tempValue).toFixed(4)
        }
        tempValue = replace_for_form_input(tempValue)

        $('#critical_stock').val(tempValue)
    } else {
        $('#critical_stock').val('0,0000')
    }
})

$('input[type=radio][name=stock_tracking]').change(function() {
    if (this.value == '1') {
        $('#stock_tracking').removeClass('d-none');
    } else if (this.value == '0') {
        $('#stock_tracking').addClass('d-none');
    }
});
</script>

<?= $this->endSection() ?>