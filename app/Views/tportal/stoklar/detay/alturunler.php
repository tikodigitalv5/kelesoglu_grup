<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Alt Ürünler <?= $this->endSection() ?>
<?= $this->section('title') ?> Alt Ürünler | <?= $stock_item['stock_code']; ?>-<?= $stock_item['stock_title']; ?>
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
                                        <h4 class="nk-block-title">Alt Ürünler</h4>
                                    </div>
                                    <div class="nk-block-head-content align-self-start">
                                        <a href="#" class="btn btn-md btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#createModalForm">Yeni Alt Ürün</a>
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1 d-lg-none"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                    <table class="datatable-init-operasyonlar nowrap table" data-export-title="Export">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2; width:80px">Kod</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Ürün Adı</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Birim Fiyat</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Stok</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($substock_items as $substock_item){ ?>
                                            <tr>
                                                <td class="text-black"><?= $substock_item['stock_title'] ?></td>
                                                <td><?= $substock_item['stock_title'] ?></td>
                                                <td><?= $substock_item['money_icon'] . ' ' . number_format($substock_item['sale_unit_price_with_tax'], 2, ',', '.') ?></td>
                                                <td><?= number_format($substock_item['stock_total_quantity'], 2, ',','.') . ' ' . $substock_item['unit_title'] ?></td>
                                                <td class="nk-tb-col nk-tb-col-tools  text-end">
                                                    <a href="<?= route_to('tportal.stocks.detail', $substock_item['stock_id']) ?>"
                                                        class="btn btn-round btn-icon btn-outline-light btn-xs"><em
                                                            class="icon ni ni-chevron-right"></em></a>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                    <!-- Modal Alert 2 -->
                                    <div class="modal fade" tabindex="-1" id="createModalForm">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Yeni Alt Ürün</h5>
                                                    <a href="#" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <em class="icon ni ni-cross"></em>
                                                    </a>
                                                </div>
                                                <div class="modal-body bg-white">
                                                    <form onsubmit="return false;" id="createSubstockForm" method="post"
                                                        class="form-validate is-alter">
                                                        <div class="form-group">
                                                            <label class="form-label" for="type_title">Geçerli
                                                                Ürün</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control form-control-xl"
                                                                    disabled placeholder="" id="stock_id"
                                                                    name="stock_id"
                                                                    value="<?= $stock_item['stock_code'] ?> - <?= $stock_item['stock_title'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label" for="substock_code">Ürün
                                                                Kodu</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control form-control-xl"
                                                                    placeholder="Ürün Kodu Giriniz" id="substock_code"
                                                                    name="substock_code">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label" for="substock_title">Alt Ürün
                                                                Adı</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control form-control-xl"
                                                                    placeholder="Alt Ürün Adı Giriniz"
                                                                    id="substock_title" name="substock_title">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label" for="substock_barcode">Alt Ürün
                                                                Barkod</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control form-control-xl"
                                                                    placeholder="Yoksa Otomatik Oluşacaktır"
                                                                    id="substock_barcode" name="substock_barcode"
                                                                    onkeypress="return SadeceRakam(event,['-'], 've -');">
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
                                                            <button type="button" id="createSubstockButton"
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
        'element' => 'substock',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="#" id="stockDetail" class="btn btn-info btn-block mb-2">Bu Alt Ürünün (<span class="fw-bold" id="new_stock_code"></span> Detayına Git</a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#createModalForm" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Alt Ürün Ekle</a>
                                    <a href="#" onclick="location.reload()" class="btn btn-l btn-dim btn-outline-dark btn-block">Alt Ürün Listesi</a>'
            ],
            'delete' => [
                'modal_title' => 'Bu Alt Ürünü Silmek İstediğinize<br>Emin misiniz?',
                'modal_text' => 'Bu alt ürünü silmeden önce lütfen yetkilinize danışınız.',
            ]
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
$('#createSubstockButton').click(function(e) {
    e.preventDefault();
    if ($('#create_substock_code').val() == '' ||
        $('#create_substock_title').val() == '') {
        swetAlert("Eksik Birşeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
    } else {
        var formData = $('#createSubstockForm').serializeArray();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.substock_create', $stock_item['stock_id']) ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    $('#createSubstockForm')[0].reset();
                    $('#stockDetail').attr('href', '<?= route_to('tportal.stocks.detail.null')?>/' +
                        response['new_stock_id'])
                    $('#new_stock_code').html(response['new_stock_code'])
                    $("#trigger_substock_ok_button").trigger("click");
                } else {
                    swetAlert("Hatalı İşlem", response['message'], "err");
                }
            }
        })
    }
});

$('.delete-action').on('click', function() {
    stock_id = $(this).attr('data-stock-id');
    substock_id = $(this).attr('data-substock-id');

    $('#delete-action').attr('data-stock-id', $(this).attr('data-stock-id'));
    $('#delete-action').attr('data-substock-id', $(this).attr('data-substock-id'));

    $('#triggerModalSil').trigger("click");


});

$('#delete-action').on('click', function() {
    stock_id = $(this).attr('data-stock-id');
    substock_id = $(this).attr('data-substock-id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.substock_delete') ?>',
        dataType: 'json',
        data: {
            stock_id: stock_id,
            substock_id: substock_id
        },
        async: true,
        success: function(response) {
            $('#txt_OK').html('Yeni Alt Ürün Başarıyla Silindi');
            $("#trigger_substock_ok_button").click();
        }
    })

});
</script>

<?= $this->endSection() ?>