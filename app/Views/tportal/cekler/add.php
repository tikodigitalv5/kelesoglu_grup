<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?>Yeni Çek Ekle<?= $this->endSection() ?>
<?= $this->section('title') ?>Yeni Çek Ekle<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>Çek Bilgilerini Giriniz<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-inner">
                    <form action="<?= site_url('tportal/checks/add') ?>" method="post" class="form-validate" enctype="multipart/form-data">                            <div class="row g-gs">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="check_no">Çek No</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="check_no" name="check_no" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="amount">Tutar</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="currency">Para Birimi</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select" id="currency" name="currency" required>
                                                <option value="TRY">TRY - Türk Lirası</option>
                                                <option value="USD">USD - Amerikan Doları</option>
                                                <option value="EUR">EUR - Euro</option>
                                               
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="exchange_rate_container" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-label" for="exchange_rate">Kur</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="exchange_rate" name="exchange_rate" step="0.0001">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="due_date">Vade Tarihi</label>
                                        <div class="form-control-wrap">
                                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="issue_date">Düzenleme Tarihi</label>
                                        <div class="form-control-wrap">
                                            <input type="date" class="form-control" id="issue_date" name="issue_date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="bank_id">Banka</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select" id="bank_id" name="bank_id" required>
                                                <option value="">Seçiniz</option>
                                                <?php foreach ($bankalar as $banka): ?>
                                                    <option value="<?= $banka['bank_id'] ?>"><?= $banka['bank_title'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="check_type">Çek Tipi</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select" id="check_type" name="check_type" required>
                                                <option value="customer">Müşteri Çeki</option>
                                                <option value="own">Kendi Çekimiz</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="customer_container">
                                    <div class="form-group">
                                        <label class="form-label" for="customer_id">Müşteri</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select" id="customer_id" name="customer_id">
                                                <option value="">Müşteri Seçiniz</option>
                                                <?php foreach ($customers as $customer): ?>
                                                    <option value="<?= $customer['cari_id'] ?>"><?= $customer['invoice_title'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
    <div class="form-group">
        <label class="form-label" for="check_image">Çek Resmi</label>
        <div class="form-control-wrap">
            <input type="file" class="form-control" id="check_image" name="check_image" accept="image/*">
        </div>
        <div class="mt-2" id="image_preview" style="display:none;">
            <img src="" alt="Çek Önizleme" class="img-fluid" style="max-height: 200px;">
            <button type="button" class="btn btn-icon btn-sm btn-danger" id="remove_image">
                <em class="icon ni ni-trash"></em>
            </button>
        </div>
    </div>
</div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="description">Açıklama</label>
                                        <div class="form-control-wrap">
                                            <textarea class="form-control" id="description" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>,
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Kaydet</button>
                                        <a href="<?= site_url('checks') ?>" class="btn btn-outline-light">İptal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Form validation
    $('.form-validate').validate();
    
    // Select2 initialization
    $('.form-select').select2({
        placeholder: "Seçiniz"
    });

    // Para birimi değiştiğinde kur alanını göster/gizle
    $('#currency').change(function() {
        if ($(this).val() !== 'TRY') {
            $('#exchange_rate_container').show();
            $('#exchange_rate').prop('required', true);
        } else {
            $('#exchange_rate_container').hide();
            $('#exchange_rate').prop('required', false);
        }
    });

    // Çek tipi değiştiğinde müşteri alanını göster/gizle
    $('#check_type').change(function() {
        if ($(this).val() === 'customer') {
            $('#customer_container').show();
            $('#customer_id').prop('required', true);
        } else {
            $('#customer_container').hide();
            $('#customer_id').prop('required', false);
        }
    });

    // Sayfa yüklendiğinde çek tipine göre müşteri alanını göster/gizle
    if ($('#check_type').val() === 'customer') {
        $('#customer_container').show();
        $('#customer_id').prop('required', true);
    }
});
// Resim yükleme ve önizleme
// Resim yükleme ve önizleme
$('#check_image').change(function(e) {
    var file = e.target.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#image_preview img').attr('src', e.target.result);
            $('#image_preview').show();
        }
        reader.readAsDataURL(file);
    }
});

// Resmi kaldır
$('#remove_image').click(function() {
    $('#check_image').val('');
    $('#image_preview').hide();
    $('#image_preview img').attr('src', '');
});
</script>
<?= $this->endSection() ?> 