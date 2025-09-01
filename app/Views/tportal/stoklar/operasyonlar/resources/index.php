<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Operasyon Kaynakları <?= $this->endSection() ?>
<?= $this->section('title') ?> Operasyon Kaynakları | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<style>
.resource-name {
    max-width: 250px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.nk-tb-item {
    padding-top: 0.6rem !important;
    padding-bottom: 0.6rem !important;
}

.nk-tb-col {
    padding-top: 0.3rem !important;
    padding-bottom: 0.3rem !important;
}
</style>

<?= $this->section('main') ?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">
                            <?php
                            $titles = [
                                'kisi' => 'Kişiler',
                                'atolye' => 'Atölyeler',
                                'makine' => 'Makineler',
                                'setup' => 'Setup'
                            ];
                            echo $titles[$current_type] ?? 'Operasyon Kaynakları';
                            ?>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="nk-block-head-content">
                                    <div class="toggle-wrap nk-block-tools-toggle">
                                        <ul class="nk-block-tools g-3">
                                            <li>
                                                <a href="?type=kisi" class="btn btn-outline-light <?= $current_type == 'kisi' ? 'active' : '' ?>">
                                                    <em class="icon ni ni-user-list"></em>
                                                    <span>Kişiler</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="?type=atolye" class="btn btn-outline-light <?= $current_type == 'atolye' ? 'active' : '' ?>">
                                                    <em class="icon ni ni-building"></em>
                                                    <span>Atölyeler</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="?type=makine" class="btn btn-outline-light <?= $current_type == 'makine' ? 'active' : '' ?>">
                                                    <em class="icon ni ni-setting"></em>
                                                    <span>Makineler</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="?type=setup" class="btn btn-outline-light <?= $current_type == 'setup' ? 'active' : '' ?>">
                                                    <em class="icon ni ni-tools"></em>
                                                    <span>Setup</span>
                                                </a>
                                            </li>
                                            <li class="nk-block-tools-opt">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModalForm">
                                                    <em class="icon ni ni-plus"></em>
                                                    <span>Yeni <?= ucfirst($current_type) ?></span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-inner p-0">
                            <div class="nk-tb-list nk-tb-ulist">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col"><span class="sub-text">Kaynak Adı</span></div>
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Durum</span></div>
                                    <div class="nk-tb-col nk-tb-col-tools text-end"></div>
                                </div>

                                <?php foreach($resources as $resource): ?>
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <span class="tb-lead resource-name" title="<?= $resource['name'] ?>">
                                            <?= (strlen($resource['name']) > 30) ? 
                                                substr($resource['name'], 0, 30) . '...' : 
                                                $resource['name'] ?>
                                        </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span class="badge badge-dim <?= $resource['status'] == 'active' ? 
                                            'bg-success' : 'bg-danger' ?>">
                                            <?= $resource['status'] == 'active' ? 'Aktif' : 'Pasif' ?>
                                        </span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-col-tools">
                                        <ul class="nk-tb-actions gx-1">
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" 
                                                       data-bs-toggle="dropdown">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li>
                                                                <a href="#" class="edit-action" 
                                                                   data-bs-toggle="modal" 
                                                                   data-bs-target="#editModalForm"
                                                                   data-id="<?= $resource['id'] ?>"
                                                                   data-name="<?= $resource['name'] ?>">
                                                                    <em class="icon ni ni-edit"></em>
                                                                    <span>Düzenle</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="delete-action"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#deleteModal"
                                                                   data-id="<?= $resource['id'] ?>">
                                                                    <em class="icon ni ni-trash"></em>
                                                                    <span>Sil</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="card-inner">
                            <div class="nk-block-between-md g-3">
                                <div class="g">
                                    <ul class="pagination justify-content-center justify-content-md-start">
                                        <li class="page-item <?= ($pager['currentPage'] <= 1) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= $pager['currentPage']-1 ?>&type=<?= $current_type ?>">
                                                <em class="icon ni ni-chevron-left"></em>
                                            </a>
                                        </li>
                                        
                                        <?php for($i = 1; $i <= $pager['totalPages']; $i++): ?>
                                        <li class="page-item <?= ($pager['currentPage'] == $i) ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?>&type=<?= $current_type ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                        <?php endfor; ?>

                                        <li class="page-item <?= ($pager['currentPage'] >= $pager['totalPages']) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= $pager['currentPage']+1 ?>&type=<?= $current_type ?>">
                                                <em class="icon ni ni-chevron-right"></em>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Yeni <?php
                    $modalTitles = [
                        'kisi' => 'Kişi',
                        'atolye' => 'Atölye',
                        'makine' => 'Makine',
                        'setup' => 'Setup'
                    ];
                    echo $modalTitles[$current_type] ?? 'Kaynak';
                    ?> Ekle
                </h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" id="createResourceForm">
                    <div class="form-group">
                        <label class="form-label" for="name"><?= $modalTitles[$current_type] ?? 'Kaynak' ?> Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <input type="hidden" name="resource_type" value="<?= $current_type ?>">
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" id="saveResource">Kaydet</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <?= $modalTitles[$current_type] ?? 'Kaynak' ?> Düzenle
                </h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" id="editResourceForm">
                    <div class="form-group">
                        <label class="form-label" for="edit_name"><?= $modalTitles[$current_type] ?? 'Kaynak' ?> Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                            <input type="hidden" id="edit_id" name="id">
                            <input type="hidden" name="resource_type" value="<?= $current_type ?>">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" id="updateResource">Güncelle</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $modalTitles[$current_type] ?? 'Kaynak' ?> Sil</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <p>Bu <?= strtolower($modalTitles[$current_type] ?? 'kaynak') ?>ı silmek istediğinizden emin misiniz?</p>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Sil</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Enter tuşu ile form submit işlemi - Yeni Kaynak Ekleme
    $('#createResourceForm').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#saveResource').click();
        }
    });

    // Enter tuşu ile form submit işlemi - Düzenleme
    $('#editResourceForm').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#updateResource').click();
        }
    });

    // Yeni Kaynak Ekleme
    $('#saveResource').click(function() {
        var resourceType = $('input[name="resource_type"]').val();
        var resourceNames = {
            'kisi': 'kişi',
            'atolye': 'atölye',
            'makine': 'makine',
            'setup': 'setup'
        };
        var resourceName = resourceNames[resourceType] || 'kaynak';

        if ($('#name').val() == '') {
            swetAlert("Eksik Bilgi", "Lütfen " + resourceName + " adını giriniz!", "err");
            return;
        }

        var formData = $('#createResourceForm').serialize();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.operation_resource.create') ?>',
            dataType: 'json',
            data: formData,
            success: function(response) {
                if (response.icon == 'success') {
                    $("#createResourceForm")[0].reset();
                    $('#createModalForm').modal('hide');
                    window.location.reload();
                } else {
                    swetAlert("Hata!", response.message, "err");
                }
            },
            error: function() {
                swetAlert("Hata!", "İşlem sırasında bir hata oluştu.", "err");
            }
        });
    });

    // Düzenleme modalını açma
    $(document).on('click', '.edit-action', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        console.log("Edit clicked - ID:", id, "Name:", name);
        
        $('#edit_id').val(id);
        $('#edit_name').val(name);
    });

    // Silme modalını açma
    $(document).on('click', '.delete-action', function() {
        var id = $(this).data('id');
        console.log("Delete clicked - ID:", id);
        $('#confirmDelete').attr('data-id', id);
    });

    // Kaynak Düzenleme
    $('#updateResource').click(function() {
        var id = $('#edit_id').val();
        var name = $('#edit_name').val();
        var resourceType = $('input[name="resource_type"]').val();
        
        console.log("Update clicked - ID:", id, "Name:", name, "Type:", resourceType);

        if (!name) {
            swetAlert("Eksik Bilgi", "Lütfen kaynak adını giriniz!", "err");
            return;
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.operation_resource.edit') ?>',
            dataType: 'json',
            data: {
                id: id,
                name: name,
                resource_type: resourceType
            },
            success: function(response) {
                if (response.icon == 'success') {
                    $('#editModalForm').modal('hide');
                    window.location.reload();
                } else {
                    swetAlert("Hata!", response.message || "Güncelleme işlemi başarısız!", "err");
                }
            },
            error: function(xhr, status, error) {
                console.log("Error:", error);
                swetAlert("Hata!", "Güncelleme sırasında bir hata oluştu.", "err");
            }
        });
    });

    // Kaynak Silme
    $('#confirmDelete').click(function() {
        var id = $(this).attr('data-id');
        var resourceType = $('input[name="resource_type"]').val();
        
        console.log("Confirm Delete clicked - ID:", id, "Type:", resourceType);

        if (!id) {
            swetAlert("Hata!", "Silinecek kayıt bulunamadı!", "err");
            return;
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.operation_resource.delete') ?>',
            dataType: 'json',
            data: {
                id: id,
                resource_type: resourceType
            },
            success: function(response) {
                if (response.icon == 'success') {
                    $('#deleteModal').modal('hide');
                    window.location.reload();
                } else {
                    swetAlert("Hata!", response.message || "Silme işlemi başarısız!", "err");
                }
            },
            error: function(xhr, status, error) {
                console.log("Error:", error);
                swetAlert("Hata!", "Silme işlemi sırasında bir hata oluştu.", "err");
            }
        });
    });
});
</script>
<?= $this->endSection() ?>