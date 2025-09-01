<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Ürün Hareketleri <?= $this->endSection() ?>
<?= $this->section('title') ?> Ürün Hareketleri | <?= $stock_item['stock_code'] ?> - <?= $stock_item['stock_title'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>


<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
        <ul class="link-list-menu">

<?php
if (isset($stock_item['stock_id']) && $stock_item['stock_id'] != 0) { ?>
<li class="bg-gray-100"><a class="" href="<?= route_to('tportal.stocks.detail', $stock_item['stock_id']) ?>">
    <em class="icon ni ni-arrow-left"></em><span> <b><?= $stock_item['stock_code'] ?> - <?= $stock_item['stock_title'] ?> - Ürüne Dön</b></span></a></li>
<?php } ?>
</ul>
            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head nk-block-head-lg">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Ürün Operasyonları</h4>
                                    </div>
                                    <div class="nk-block-head-content align-self-start">
                                    <a href="#" id="btn_operasyon_kopyala" data-bs-toggle="modal" data-bs-target="#mdl_operasyon_kopyala" class="btn btn-secondary">Operasyon Kopyala</a>
                                    <a href="#" class="toggle btn btn-icon btn-trigger mt-n1 d-lg-none" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                        <a href="#" id="btn_yenioperasyon" data-bs-toggle="modal"
                                            data-bs-target="#mdl_operasyon" class="btn btn-primary">Yeni Operasyon</a>
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1 d-lg-none"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">
                                <div class="nk-data data-list">


                                    <table class="datatable-init-operasyonlar nowrap table" data-export-title="Export">
                                        <thead>
                                            <tr>
                                                <th style="width: 80px; background-color: #ebeef2;">Sıra</th>
                                                <th style="width: 200px; background-color: #ebeef2;" data-orderable="false">İşlem</th>
                                                <th style="width: 120px; background-color: #ebeef2;" data-orderable="false">Kişi</th>
                                                <th style="width: 120px; background-color: #ebeef2;" data-orderable="false">Atölye</th>
                                                <th style="width: 120px; background-color: #ebeef2;" data-orderable="false">Makine</th>
                                                <th style="width: 120px; background-color: #ebeef2;" data-orderable="false">Setup</th>
                                                <th style="width: 120px; background-color: #ebeef2; text-align: center;" data-orderable="false">Süre</th>
                                             
                                                <th style="width: 100px; background-color: #ebeef2;" data-orderable="false"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $counter = 0;
                                            foreach($stock_operation_items as $stock_operation_item){ 
                                                $counter += $stock_operation_item['duration'];
                                            ?>
                                            <tr>
                                                <td class="text-center"><?= $stock_operation_item['relation_order'] ?></td>
                                                <td title="<?= $stock_operation_item['operation_title'] ?>">
                                                    <?= (mb_strlen($stock_operation_item['operation_title']) > 30) ? 
                                                        mb_substr($stock_operation_item['operation_title'], 0, 30) . '...' : 
                                                        $stock_operation_item['operation_title'] 
                                                    ?>
                                                </td>
                                                <td><?= $stock_operation_item['kisi'] ?></td>
                                                <td><?= $stock_operation_item['atolye'] ?></td>
                                                <td title="<?= $stock_operation_item['makine'] ?>">
                                                    <?= (mb_strlen($stock_operation_item['makine']) > 20) ? 
                                                        mb_substr($stock_operation_item['makine'], 0, 20) . '...' : 
                                                        $stock_operation_item['makine'] 
                                                    ?>
                                                </td>
                                                
                                                <td><?= $stock_operation_item['setup'] ?></td>
                                                <td class="text-center"><?= $stock_operation_item['duration'] ?>
                                                    <?= $stock_operation_item['duration_type'] ?></td>
                                               
                                                <td class="text-end">
                                                    <div class="btn-group">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#mdl_operasyon_edit"
                                                            data-stock-id="<?= $stock_operation_item['stock_id'] ?>"
                                                            data-relation-id="<?= $stock_operation_item['relation_id'] ?>"
                                                            data-kisi="<?= $stock_operation_item['kisi_id'] ?>"
                                                            data-atolye="<?= $stock_operation_item['atolye_id'] ?>"
                                                            data-makine="<?= $stock_operation_item['makine_id'] ?>"
                                                            data-setup="<?= $stock_operation_item['setup_id'] ?>"
                                                            data-operation-name="<?= $stock_operation_item['operation_title'] ?>"
                                                            data-duration="<?= $stock_operation_item['duration'] ?>"
                                                            data-relation-order="<?= $stock_operation_item['relation_order'] ?>"
                                                            class="btn btn-round btn-icon btn-xs btn-dim btn-outline-dark edit-action"><em
                                                                class="icon ni ni-pen-alt-fill"></em></a>
                                                        <a href="#"
                                                            class="btn btn-round btn-icon btn-xs btn-dim btn-outline-danger delete-action"
                                                            data-stock-id="<?= $stock_operation_item['stock_id'] ?>"
                                                            data-relation-id="<?= $stock_operation_item['relation_id'] ?>"><em
                                                                class="icon ni ni-trash-empty"></em></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td style="background-color: #ebeef2;"></td>
                                                <td style="background-color: #ebeef2;" colspan="5"></td>
                                                <td style="background-color: #ebeef2;" class="text-end">
                                                    <strong>TOPLAM</strong>
                                                </td>
                                                <td style="background-color: #ebeef2;" class="text-center">
                                                    <strong><?= floor($counter/60) ?> dakika <?= floor($counter%60) ?> saniye</strong>
                                                </td>
                                           
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- data-list -->

                            </div><!-- .nk-block -->
                        </div>

                      
                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<!-- Modal Alert 2 -->
<div class="modal fade" tabindex="-1" id="mdl_operasyon">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Operasyon</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="createStockOperationForm" method="post"
                    class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="type_title">Operasyon Seç</label>
                        <div class="form-control-wrap">
                            <select class="form-select  init-select2" data-search="on" data-ui="xl" name="operation_id"
                                id="operation_id">
                                <option value="" disabled>Lütfen Seçiniz</option>
                                <?php foreach($operation_items as $operation_item){ ?>
                                <option value="<?= $operation_item['operation_id'] ?>"
                                    <?php if($operation_item['default'] == 'true'){ echo 'selected'; } ?>>
                                    <?= $operation_item['operation_title'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="type_title">Sıralama</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="İşlem Sırası"
                                    id="relation_order" name="relation_order" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="type_title">Süre</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl" placeholder="İşlem Süresi"
                                        required="" id="duration" name="duration">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">Saniye</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="type_title">Kişi</label>
                            <div class="form-control-wrap">
                                <select class="form-select  init-select2" data-search="on" data-ui="xl" name="kisi"
                                    id="kisi">
                                    <option value="" disabled>Lütfen Seçiniz</option>
                                    <?php foreach($operation_resources as $operation_resource){ 
                                        if($operation_resource['resource_type'] == 'kisi'){
                                            ?>
                                            <option value="<?= $operation_resource['id'] ?>"><?= $operation_resource['name'] ?></option>
                                            <?php 
                                        }
                                    } ?>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="type_title">Atölye</label>
                            <div class="form-control-wrap">
                                <select class="form-select  init-select2" data-search="on" data-ui="xl" name="atolye"
                                    id="atolye">
                                    <option value="" disabled>Lütfen Seçiniz</option>
                                    <?php foreach($operation_resources as $operation_resource){ 
                                        if($operation_resource['resource_type'] == 'atolye'){
                                            ?>
                                            <option value="<?= $operation_resource['id'] ?>"><?= $operation_resource['name'] ?></option>
                                            <?php 
                                        }
                                    } ?>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="type_title">Makine</label>
                            <div class="form-control-wrap">
                                <select class="form-select  init-select2" data-search="on" data-ui="xl" name="makine"
                                    id="makine">
                                    <option value="" disabled>Lütfen Seçiniz</option>
                                    <?php foreach($operation_resources as $operation_resource){ 
                                        if($operation_resource['resource_type'] == 'makine'){
                                            ?>
                                            <option value="<?= $operation_resource['id'] ?>"><?= $operation_resource['name'] ?></option>
                                            <?php 
                                        }
                                    } ?>
                                   
                                </select>
                            </div>
                        </div>  
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="type_title">Setup</label>
                            <div class="form-control-wrap">
                                <select class="form-select  init-select2" data-search="on" data-ui="xl" name="setup"
                                    id="setup">
                                    <option value="" disabled>Lütfen Seçiniz</option>
                                    <?php foreach($operation_resources as $operation_resource){ 
                                        if($operation_resource['resource_type'] == 'setup'){
                                            ?>
                                            <option value="<?= $operation_resource['id'] ?>"><?= $operation_resource['name'] ?></option>
                                            <?php 
                                        }
                                    } ?>
                                   
                                </select>
                            </div>
                        </div> 
                    </div>
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-dim btn-outline-light"
                            data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <!-- <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ HESAP</button> -->
                        <button type="button" id="stokOperasyonOlustur" class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Alert 2 -->
<div class="modal fade" tabindex="-1" id="mdl_operasyon_edit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Operasyon Düzenle</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="editStockOperationForm" method="post" class="form-validate is-alter">
                    <div class="row g-3 align-center mb-4">
                        <div class="form-group">
                            <label class="form-label" for="type_title">Operasyon Adı</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" value=""
                                    id="edit_operation_name" name="operation_name" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="type_title">Sıralama</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="İşlem Sırası"
                                    id="edit_relation_order" name="relation_order" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="type_title">Süre</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl" placeholder="İşlem Süresi"
                                        required="" id="edit_duration" name="duration">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">Saniye</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="type_title">Kişi</label>
                            <div class="form-control-wrap">
                                <select class="form-select init-select2" data-search="on" data-ui="xl" name="kisi" id="edit_kisi">
                                    <option value="" disabled>Lütfen Seçiniz</option>
                                    <?php foreach($operation_resources as $operation_resource){ 
                                        if($operation_resource['resource_type'] == 'kisi'){
                                            ?>
                                            <option value="<?= $operation_resource['id'] ?>"><?= $operation_resource['name'] ?></option>
                                            <?php 
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="type_title">Atölye</label>
                            <div class="form-control-wrap">
                                <select class="form-select init-select2" data-search="on" data-ui="xl" name="atolye" id="edit_atolye">
                                    <option value="" disabled>Lütfen Seçiniz</option>
                                    <?php foreach($operation_resources as $operation_resource){ 
                                        if($operation_resource['resource_type'] == 'atolye'){
                                            ?>
                                            <option value="<?= $operation_resource['id'] ?>"><?= $operation_resource['name'] ?></option>
                                            <?php 
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="type_title">Makine</label>
                            <div class="form-control-wrap">
                                <select class="form-select init-select2" data-search="on" data-ui="xl" name="makine" id="edit_makine">
                                    <option value="" disabled>Lütfen Seçiniz</option>
                                    <?php foreach($operation_resources as $operation_resource){ 
                                        if($operation_resource['resource_type'] == 'makine'){
                                            ?>
                                            <option value="<?= $operation_resource['id'] ?>"><?= $operation_resource['name'] ?></option>
                                            <?php 
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>  
                        <div class="col-lg-6 col-xxl-6 col-6">
                            <label class="form-label" for="type_title">Setup</label>
                            <div class="form-control-wrap">
                                <select class="form-select init-select2" data-search="on" data-ui="xl" name="setup" id="edit_setup">
                                    <option value="" disabled>Lütfen Seçiniz</option>
                                    <?php foreach($operation_resources as $operation_resource){ 
                                        if($operation_resource['resource_type'] == 'setup'){
                                            ?>
                                            <option value="<?= $operation_resource['id'] ?>"><?= $operation_resource['name'] ?></option>
                                            <?php 
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>  

                    </div>
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-dim btn-outline-light"
                            data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <!-- <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ HESAP</button> -->
                        <button type="button" id="stokOperasyonKaydet" class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button type="button" id="triggerModaloperasyonOK" class="btn btn-success d-none" data-bs-toggle="modal"
    data-bs-target="#operasyonOK">OK</button>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" id="operasyonOK">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                    <h4 class="nk-modal-title">İşlem Başarılı!</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text" id="txt_OK"></div>
                        </span>
                    </div>
                    <div class="nk-modal-action">
                        <a href="#" class="btn btn-l btn-mw btn-primary" data-bs-toggle="modal"
                            data-bs-target="#mdl_operasyon">Yeni Operasyon Ekle</a>
                        <a href="#" data-bs-dismiss="modal" onclick="location.reload()"
                            class="btn btn-l btn-mw btn-secondary">Operasyon Listesine
                            Dön</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<button type="button" id="triggerModaloperasyonKopyalaOK" class="btn btn-success d-none" data-bs-toggle="modal"
    data-bs-target="#operasyonKopyalaOK">OK</button>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" id="operasyonKopyalaOK">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                    <h4 class="nk-modal-title">İşlem Başarılı!</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text" id="txt_OK_KOPYALA">Operasyon Kopyalandı</div>
                        </span>
                    </div>
                    <div class="nk-modal-action">
                        <a href="#" class="btn btn-l btn-mw btn-primary" data-bs-toggle="modal"
                            data-bs-target="#mdl_operasyon">Yeni Operasyon Ekle</a>
                        <a href="#" data-bs-dismiss="modal" onclick="location.reload()"
                            class="btn btn-l btn-mw btn-secondary">Operasyon Listesine
                            Dön</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<button type="button" id="triggerModalSil" class="btn btn-success d-none" data-bs-toggle="modal"
    data-bs-target="#mdl_operationsil">SİL</button>
<!-- Modal Alert 2 -->
<div class="modal fade" tabindex="-1" id="mdl_operationsil">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent"
                        style="font-size: 70px;"></em>
                    <h4 class="nk-modal-title">Operasyonu Silmek İstediğinize<br>Emin misiniz?</h4>
                    <div class="nk-modal-action mb-5">
                        <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger" id="delete-action"
                            data-bs-dismiss="modal">Evet</a>
                    </div>
                    <div class="nk-modal-text">
                        <!-- <p class="lead">Bu ürünü silmeniz için;<br>mevcut herhangi bir üretim emri olmamalıdır.</p> -->
                        <p class="text-soft">Silmeden önce lütfen yetkilinize danışınız.</p>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
$('#stokOperasyonOlustur').click(function(e) {
    e.preventDefault();
    if ($('#order').val() == '' ||
        $('#duration').val() == '') {
        swetAlert("Eksik Birşeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
    } else {
        var formData = $('#createStockOperationForm').serializeArray();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.operation_create', $stock_item['stock_id']) ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                console.log(response)
                if (response['icon'] == 'success') {
                    $('#createStockOperationForm')[0].reset();
                    $("#triggerModaloperasyonOK").click();
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

$('.delete-action').on('click', function() {
    stock_id = $(this).attr('data-stock-id');
    relation_id = $(this).attr('data-relation-id');

    $('#delete-action').attr('data-stock-id', $(this).attr('data-stock-id'));
    $('#delete-action').attr('data-relation-id', $(this).attr('data-relation-id'));

    $('#triggerModalSil').trigger("click");
});

$('#delete-action').on('click', function() {
    stock_id = $(this).attr('data-stock-id');
    relation_id = $(this).attr('data-relation-id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.operation_delete') ?>',
        dataType: 'json',
        data: {
            stock_id: stock_id,
            relation_id: relation_id
        },
        async: true,
        success: function(response) {

            $('#txt_OK').html('Operasyon Başarıyla Silindi');
            $("#triggerModaloperasyonOK").click();
            // const Toast = Swal.mixin({
            //     toast: true,
            //     position: 'top-end',
            //     showConfirmButton: false,
            //     timer: 3000,
            //     timerProgressBar: true,
            // })

            // Toast.fire({
            //     icon: response['icon'],
            //     title: response['message']
            // })
        }
    })
});


$('.edit-action').on('click', function() {
    relation_id = $(this).attr('data-relation-id');
    operation_name = $(this).attr('data-operation-name');
    relation_order = $(this).attr('data-relation-order');
    duration = $(this).attr('data-duration');
    kisi = $(this).attr('data-kisi');
    atolye = $(this).attr('data-atolye');
    makine = $(this).attr('data-makine');
    setup = $(this).attr('data-setup');




    // alert(item_id + " - " + item_title + " " +item_status);
    $('#edit_operation_name').val(operation_name);
    $('#edit_duration').val(duration);
    $('#edit_relation_order').val(relation_order);

 
        $('#edit_kisi').val(kisi).trigger('change');

    $('#edit_atolye').val(atolye).trigger('change');
    $('#edit_makine').val(makine).trigger('change');
    $('#edit_setup').val(setup).trigger('change');

   

    $('#stokOperasyonKaydet').click(function(e) {
        var formData = $('#editStockOperationForm').serializeArray();
        formData.push({
            name: 'relation_id',
            value: relation_id
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.operation_edit') ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {

                    $("#editStockOperationForm")[0].reset();

                    $('#txt_OK').html('Operasyon Güncellendi');
                    $("#triggerModaloperasyonOK").click();
                    // $("#list_load").trigger("click");
                    // $('#mdl_operasyon_edit').modal('toggle');
                } else {
                    return false;
                }
                // const Toast = Swal.mixin({
                //     toast: true,
                //     position: 'top-end',
                //     showConfirmButton: false,
                //     timer: 3000,
                //     timerProgressBar: true,
                // })

                // Toast.fire({
                //     icon: response['icon'],
                //     title: response['message']
                // })
            }
        })
    })

});
</script>



<div class="modal fade" tabindex="-1" id="mdl_operasyon_kopyala">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Operasyon Kopyala</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="copyStockOperationForm" method="post" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="source_stock_id">Ürün Seç</label>
                        <div class="form-control-wrap">
                            <select class="form-select init-select2" data-search="on" data-ui="xl" name="source_stock_id" id="source_stock_id">
                                <option value="" disabled selected>Lütfen Ürün Seçiniz</option>
                                <?php foreach($stock_items as $item){ ?>
                                <option value="<?= $item['stock_id'] ?>"><?= $item['stock_code'] ?> - <?= $item['stock_title'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div id="operasyonListesiContainer" style="display:none;">
                        <div class="nk-block mt-4">
                            <div class="card">
                                <div class="card-inner p-0">
                                    <div id="loadingOperations" class="text-center p-5" style="display:none;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Yükleniyor...</span>
                                        </div>
                                        <p class="mt-2 text-muted">Operasyonlar Yükleniyor...</p>
                                    </div>
                                    
                                    <div id="noOperationsMessage" class="alert alert-pro alert-warning alert-icon m-3" style="display:none;">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong>Operasyon Bulunamadı</strong>
                                        <p class="mt-1 mb-0">Bu ürüne ait operasyon kaydı bulunmamaktadır.</p>
                                    </div>

                                    <div id="operationsTable" style="display:none;">
                                        <div class="table-responsive">
                                            <table class="table table-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="text-center" style="width: 80px;">Sıra</th>
                                                        <th>Operasyon</th>
                                                        <th class="text-center" style="width: 120px;">Süre</th>
                                                        <th>Kişi</th>
                                                        <th>Atölye</th>
                                                        <th>Makine</th>
                                                        <th>Setup</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="operationsTableBody">
                                                </tbody>
                                            </table>
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
                        <button type="button" class="btn btn-lg btn-dim btn-outline-light" data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <button type="button" id="operasyonKopyala" class="btn btn-lg btn-primary" disabled>KOPYALA</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select2'yi başlat
    if($.fn.select2) {
        $('#source_stock_id').select2({
            dropdownParent: $('#mdl_operasyon_kopyala')
        });
    }

    // Operasyon kopyalama işlemleri
    $('#source_stock_id').on('change', function() {
        var stockId = $(this).val();
        
        if(stockId) {
            $('#operationsTable').hide();
            $('#noOperationsMessage').hide();
            $('#loadingOperations').show();
            $('#operasyonListesiContainer').show();
            $('#operasyonKopyala').prop('disabled', true);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.stocks.get_operations') ?>',
                dataType: 'json',
                data: {
                    stock_id: stockId
                },
                success: function(response) {
                    var tbody = $('#operationsTableBody');
                    tbody.empty();
                    
                    if(response && response.operations && response.operations.length > 0) {
                        response.operations.forEach(function(op) {
                            var row = `
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-dim bg-primary">${op.relation_order || '-'}</span>
                                    </td>
                                    <td>
                                        <div class="text-primary fw-bold">${op.operation_title || '-'}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-gray text-white">
                                            ${op.duration ? op.duration + ' saniye' : '-'}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <em class="icon ni ni-user-alt mr-1"></em>
                                            <span data-kisi-id="${op.kisi_id}">${op.kisi || '-'}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <em class="icon ni ni-building mr-1"></em>
                                            <span data-atolye-id="${op.atolye_id}">${op.atolye || '-'}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <em class="icon ni ni-setting mr-1"></em>
                                            <span data-makine-id="${op.makine_id}">${op.makine || '-'}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <em class="icon ni ni-clock mr-1"></em>
                                            <span data-setup-id="${op.setup_id}">${op.setup || '-'}</span>
                                        </div>
                                    </td>
                                </tr>`;
                            tbody.append(row);
                        });
                        
                        $('#operationsTable').show();
                        $('#operasyonKopyala').prop('disabled', false); // Operasyon varsa butonu aktif et
                    } else {
                        $('#noOperationsMessage').show();
                        $('#operasyonKopyala').prop('disabled', true); // Operasyon yoksa butonu pasif et
                    }
                    
                    $('#loadingOperations').hide();
                },
                error: function(xhr, status, error) {
                    console.error('Ajax Hatası:', error);
                    $('#loadingOperations').hide();
                    $('#noOperationsMessage').show().find('span').text('Operasyonlar yüklenirken bir hata oluştu.');
                    $('#operasyonKopyala').prop('disabled', true);
                }
            });
        } else {
            $('#operasyonListesiContainer').hide();
            $('#operasyonKopyala').prop('disabled', true);
        }
    });

    // Operasyon kopyalama butonu işlemi
    $('#operasyonKopyala').on('click', function() {
        const sourceStockId = $('#source_stock_id').val();
        const selectedText = $('#source_stock_id option:selected').text();
        $("#mdl_operasyon_kopyala").modal("hide");
        Swal.fire({
            title: 'Operasyonları Kopyala',
            html: `<div class="text-start">
                    <p class="mb-2"><strong>${selectedText}</strong> ürününün operasyonlarını şu anki ürüne kopyalamak istediğinize emin misiniz?</p>
                    <div class="alert alert-warning mt-3">
                        <em class="icon ni ni-alert-circle"></em>
                        <strong>Not:</strong> Bu işlem mevcut operasyonları etkilemeyecektir.
                    </div>
                   </div>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#364a63',
            confirmButtonText: 'Evet, Kopyala',
            cancelButtonText: 'İptal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= base_url('tportal/stock/copy-operation/'.$stock_item['stock_id']) ?>',
                    dataType: 'json',
                    data: {
                        source_stock_id: sourceStockId
                    },
                    success: function(response) {
                        if(response.icon === 'success') {
                            $('#txt_OK').html('Operasyonlar Başarıyla Kopyalandı');
                            $("#triggerModaloperasyonKopyalaOK").click();
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata',
                                text: response.message || 'Bir hata oluştu',
                                confirmButtonText: 'Tamam'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Kopyalama Hatası:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            text: 'Operasyonlar kopyalanırken bir hata oluştu',
                            confirmButtonText: 'Tamam'
                        });
                    }
                });
            }else{
                $("#mdl_operasyon_kopyala").modal("show");
            }
        });
    });
});
</script>

<?= $this->endSection() ?>