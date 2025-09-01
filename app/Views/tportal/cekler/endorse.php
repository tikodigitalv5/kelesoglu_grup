<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?>Çek Ciro<?= $this->endSection() ?>
<?= $this->section('title') ?>Çek Ciro<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>Çek Ciro Bilgilerini Giriniz<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-inner">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-inner">
                                        <h5 class="card-title">Çek Bilgileri</h5>
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <span class="sub-text">Çek No:</span>
                                                <span class="lead-text"><?= $check['check_no'] ?></span>
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Tutar:</span>
                                                <span class="lead-text"><?= number_format($check['amount'], 2) ?> TL</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Vade:</span>
                                                <span class="lead-text"><?= $check['due_date'] ?></span>
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Banka:</span>
                                                <span class="lead-text"><?= $check['bank_id'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="<?= site_url('tportal/checks/endorse/'.$check['id']) ?>" method="post" class="form-validate">
                            <div class="row g-gs">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="payee_id">Ciro Edilecek</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select" id="payee_id" name="payee_id" required>
                                                <option value="">Seçiniz</option>
                                               <?php foreach ($customers as $customer): ?>
                                                    <option value="<?= $customer['cari_id'] ?>"><?= $customer['invoice_title'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
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
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Ciro Et</button>
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
});
</script>
<?= $this->endSection() ?> 