<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Tüm Çekler <?= $this->endSection() ?>
<?= $this->section('title') ?> Tüm Çekler | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>


<?= $this->section('main') ?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Yeni Çek Ekle</h3>
                    </div>
                </div>
            </div>

            <div class="nk-block">
                <div class="card">
                    <div class="card-inner">
                        <form action="<?= site_url('tportal/cekler/yeni') ?>" method="post">
                            <div class="row g-4">
                            <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="cari_id">Cari</label>
                                        <select class="form-select js-select2" name="cari_id" required>
                                            <option value="">Seçiniz</option>
                                            <?php foreach ($cariler as $cari): ?>
                                            <option value="<?= $cari['cari_id'] ?>">
                                                <?= $cari['company_type'] == 'company' ? $cari['invoice_title'] : $cari['name'] . ' ' . $cari['surname'] ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="bank_id">Banka</label>
                                        <select class="form-select js-select2" id="bank_id" name="bank_id" data-placeholder="Çek / Senet Banka" required>
                                            <option value="">Seçiniz</option>
                                            <?php foreach ($bankalar as $banka): ?>
                                            <option value="<?= $banka['bank_id'] ?>"><?= $banka['bank_title'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="cek_tutar">Tutar</label>
                                        <input type="number" step="0.01" class="form-control" id="cek_tutar" name="cek_tutar" placeholder="İşlem Tutarı" required onchange="hesaplaReelTutar()">
                                    </div>
                                </div>

                                


                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="cek_para_birimi">Döviz</label>
                                        <select class="form-select js-select2" id="cek_para_birimi" name="cek_para_birimi" data-placeholder="Çek / Senet Döviz" required onchange="toggleKurInput()">
                                            <option value="">Seçiniz</option>
                                            <?php foreach ($diger_para_birimleri as $birim): ?>
                                            <option value="<?= $birim['kodu'] ?>"> <?= $birim['adi'] ?></option>
                                            <?php endforeach; ?>
                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 kur-alani" style="display:none;">
                                    <div class="form-group">
                                        <label class="form-label" for="cek_kur">Döviz Kuru</label>
                                        <input type="number" step="0.0001" class="form-control" id="cek_kur" name="cek_kur" placeholder="Çek / Senet Döviz Kuru" onchange="hesaplaReelTutar()">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="cek_no">Çek / Senet No</label>
                                        <input type="text" class="form-control" id="cek_no" name="cek_no" placeholder="Çek / Senet No" required>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="tahsilat_tarihi">Tahsilat Tarihi</label>
                                        <div class="form-control-wrap">
                                            <input type="date" class="form-control " id="tahsilat_tarihi" name="tahsilat_tarihi" placeholder="Tahsilat Tarihi">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="vade_tarihi">Vade Tarihi</label>
                                        <div class="form-control-wrap">
                                            <input type="date" class="form-control " id="vade_tarihi" name="vade_tarihi" placeholder="Çek / Senet Vade Tarihi" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="islem_notu">İşlem Notu</label>
                                        <textarea class="form-control" id="islem_notu" name="islem_notu" placeholder="İşlem Notu" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Gönder</button>
                                        <a href="<?= site_url('tikoerp/cekler') ?>" class="btn btn-outline-light">İptal</a>
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
    $('.js-select2').select2({
        placeholder: "Seçiniz"
    });

    $('.date-picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
    });
});

function toggleKurInput() {
    const paraBirimi = document.getElementById('cek_para_birimi').value;
    const kurAlani = document.querySelector('.kur-alani');
    const kurInput = document.getElementById('cek_kur');
    
    if (paraBirimi !== 'TRY' && paraBirimi !== '') {
        kurAlani.style.display = 'block';
        kurInput.required = true;
        getGuncelKur(paraBirimi);
    } else {
        kurAlani.style.display = 'none';
        kurInput.required = false;
        kurInput.value = '1';
        hesaplaReelTutar();
    }
}

function getGuncelKur(paraBirimi) {
    // API'den güncel kur bilgisini çekme
    fetch('/api/guncel-kur/' + paraBirimi)
        .then(response => response.json())
        .then(data => {
            document.getElementById('cek_kur').value = data.kur;
            hesaplaReelTutar();
        })
        .catch(error => {
            console.error('Kur bilgisi alınamadı:', error);
        });
}

function hesaplaReelTutar() {
    const tutar = parseFloat(document.getElementById('cek_tutar').value) || 0;
    const kur = parseFloat(document.getElementById('cek_kur').value) || 1;
    const reelTutar = tutar * kur;
    
    // Reel tutarı hidden input'a kaydet
    if (!document.getElementById('cek_reel_tutar')) {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.id = 'cek_reel_tutar';
        hiddenInput.name = 'cek_reel_tutar';
        document.querySelector('form').appendChild(hiddenInput);
    }
    document.getElementById('cek_reel_tutar').value = reelTutar.toFixed(2);
}
</script>
<?= $this->endSection() ?>