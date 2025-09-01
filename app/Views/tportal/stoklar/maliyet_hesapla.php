
<?= $this->extend('tportal/layout_maliyet') ?>
<?= $this->section('page_title') ?> Maliyet Hesaplama | <?= $this->endSection() ?>
<?= $this->section('title') ?> Maliyet Hesaplama | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<?php
$ham_carpani = $category_item['ham_carpan'] ?? 0.6;
$kap_carpani = $category_item['kap_carpan'] ?? 0.2;
$tas_carpani = $category_item['tas_carpan'] ?? 0.15;
$mineli_default = $category_item['mineli_carpan'] ?? 0.3;
$kar_orani_default = $category_item['kar_oran'] ?? 30;
?>

<?= $this->section('main') ?>



<style>
    .table-orders td {
    vertical-align: middle !important;
    height: 40px;
    text-align: center;
}
.card .table tr:first-child th, .card .table tr:first-child td {
    border-top: none;
    text-align: center!important;
}
.table-orders td input[type="text"] {
    font-family: 'Gilroy-Medium', Arial, sans-serif;
    font-size: 15px;
    color: #19213D;
}
.table-orders td input[name$="[satis]"] {
    font-weight: bold;
    color: #000;
    background: #fff;
    border: 1px solid #e0e0e0;
    font-size: 16px;
}
</style>


 
<div class="nk-content nk-content-fluid">
    <div class="container-xl ">
        <div class="nk-content-body">
          


     



        <div class="nk-block nk-block-lg">
                  <!-- Ürüne Geri Dön Butonu -->
                  <div class="card card-preview mb-3">
                    <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3" style="gap: 16px;">
    <a href="<?= base_url('tportal/stock/detail/'.$stock_item['stock_id']) ?>" class="btn btn-outline-primary btn-lg">
      <i class="ni ni-arrow-left me-2"></i> Ürüne Geri Dön
    </a>
    <?php if(!empty($variant_property_items) && !empty($variant_properties)): ?>
    <button type="button" class="btn btn-success degisiklik_kaydet btn-lg" id="maliyetKaydet">
      <i class="ni ni-save me-2"></i> Değişiklikleri Kaydet
    </button>
    <?php endif; ?>
  </div>




                    </div>
                  </div>


                  <form id="maliyetForm" action="<?= route_to('tportal.stocks.ajaxMaliyetKaydet') ?>" method="post">

<?php if(empty($variant_property_items) || empty($variant_properties)): ?>
<div style="width:100%;min-height: 300px;">
    <div style="text-align: center; font-size: 1.3rem; color: #888; background: #fff; padding: 48px 32px; border-radius: 16px; box-shadow: 0 2px 16px 0 #e0e0e0;">
        <i class="ni ni-alert-circle" style="font-size:2.5rem; color:#ffad0a;"></i><br><br>
        <b>Bu ürün ile ilgili fiyat hesaplaması yapılamamaktadır. <br></b>
        <p>Ürün Varyantlarında  "<b style="color:red;">DÜĞME BOYLARI</b>"  bulunmamaktadır.</p>
    </div>
</div>
<?php else: ?>
                  
                  <div class="buraya_hesaplamalar">
                  <?php $ham_carpani = 0.6; ?>
<div style="margin-bottom: 16px; margin-top: 16px; display: flex; gap: 32px; align-items: center;">
    <div>
        <label for="hamCarpaniInput"><b>Ham Çarpanı:</b></label>
        <input type="number" readonly step="0.01" id="hamCarpaniInput" name="ham_carpani" value="<?= $ham_carpani ?>" style="width:80px; text-align:center; margin-left:8px;">
    </div>
    <div>
        <label for="kapCarpaniInput"><b>Kap. Maliyet Çarpanı:</b></label>
        <input type="number" readonly step="0.01" id="kapCarpaniInput" name="kap_carpani" value="<?= $kap_carpani ?>" style="width:80px; text-align:center; margin-left:8px;">
    </div>
    <div>
        <label for="tasCarpaniInput"><b>Taş Çarpanı:</b></label>
        <input type="number" readonly step="0.01" id="tasCarpaniInput" name="tas_carpani" value="<?= $tas_carpani ?>" style="width:80px; text-align:center; margin-left:8px;">
    </div>
    <div>
        <label for="mineliDefaultInput"><b>Mineli Varsayılan:</b></label>
        <input type="number" readonly step="0.01" id="mineliDefaultInput" name="mineli_default" value="<?= $mineli_default ?>" style="width:80px; text-align:center; margin-left:8px;">
    </div>
    <div>
        <label for="karOraniDefaultInput"><b>Kar Oranı Varsayılan:</b></label>
        <input type="number" readonly step="0.01" id="karOraniDefaultInput" name="kar_orani_default" value="<?= $kar_orani_default ?>" style="width:80px; text-align:center; margin-left:8px;">
    </div>
</div>
                  </div>
                  <div class="card card-preview">
                    <table class="table table-orders">
                      <thead class="tb-odr-head bg-light bg-opacity-75">
                        <tr class="tb-odr-item">
                          <th class="tb-odr-info">
                            <span class="tb-odr-id">Görsel</span></th>
                            <th class="tb-odr-info"><span class="tb-odr-date d-none d-md-inline-block">Kod</span></th>
                            <th class="tb-odr-info"><span class="tb-odr-date d-none d-md-inline-block">Ürün</span></th>
                            <th class="tb-odr-info"><span class="tb-odr-date d-none d-md-inline-block">Gram</span></th>
                            <th class="tb-odr-info"><span class="tb-odr-date d-none d-md-inline-block">Taş Sayısı</span></th>
                            <th class="tb-odr-info"><span class="tb-odr-date d-none d-md-inline-block">Ham</span></th>
                            <th class="tb-odr-info"><span class="tb-odr-date d-none d-md-inline-block">Kap.Maliyet</span></th>
                            <th class="tb-odr-info"><span class="tb-odr-date d-none d-md-inline-block">Mineli</span></th>
                            <th class="tb-odr-info"><span class="tb-odr-date d-none d-md-inline-block">Taşlı</span></th>
                            <th class="tb-odr-info"><span class="tb-odr-date d-none d-md-inline-block">Toplam Maliyet</span></th>
                            <th class="tb-odr-info"><span class="tb-odr-date d-none d-md-inline-block">Kar Oranı</span></th>
                            <th class="tb-odr-info"><span class="tb-odr-date d-none d-md-inline-block">Satış</span></th>
                        </tr>
                      </thead>
                      <tbody class="tb-odr-body">
                        <tr>
                            <td rowspan="<?= count($variant_stocks) + 1 ?>" style="padding:0; width:110px; text-align:center; vertical-align:middle;">
                                <div style="height:100%; display:flex; align-items:center; justify-content:center;">
                                    <img src="<?= $stock_item['default_image'] ?>" style="max-width:80px; max-height:<?= (count($variant_stocks)+1)*40 ?>px; object-fit:contain;" alt="<?= $stock_item['stock_title'] ?>">
                                </div>
                            </td>
                            <td><b style="color:#009cff"><input type="text" name="stock_code" value="<?= $stock_item['stock_code'] ?>" style="width:100%;text-align:center;border:none;background:transparent;font-weight:bold;color:#009cff;"></b></td>
                            <td><b style="color:#009cff"><input type="text" name="stock_title" value="<?= $stock_item['stock_title'] ?>" style="width:100%;text-align:center;border:none;background:transparent;font-weight:bold;color:#009cff;"></b></td>
                            <td><input type="text" name="main_gram" value="" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="main_tas_sayisi" value="" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="main_ham" value="" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="main_kap_maliyet" value="" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="main_mineli" value="" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="main_tasli" value="" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="main_toplam_maliyet" value="" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="main_kar_orani" value="" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="main_satis" value="" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                        </tr>
                        <?php 
                       
                        foreach($variant_stocks as $i => $variant): ?>
                        <tr>
                        <input type="hidden" name="variant[<?= $i ?>][stock_id]" value="<?= $variant['stock_id'] ?? '' ?>">
                            <td><input type="text" name="variant[<?= $i ?>][kod]" value="<?= $variant['stock_code'] ?? '' ?>" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="variant[<?= $i ?>][urun]" value="<?= $variant_properties[$variant['variant_'.$column_number]] ?>" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="variant[<?= $i ?>][gram]" value="<?= $variant['gram'] ?? '0.00' ?>" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="variant[<?= $i ?>][tas_sayisi]" value="<?= $variant['tas_sayisi'] ?? '0.00' ?>" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="variant[<?= $i ?>][ham]" value="<?= $variant['ham'] ?? '0,00 ₺' ?>" data-ham-carpani="<?= $ham_carpani ?>" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="variant[<?= $i ?>][kap_maliyet]" value="<?= $variant['kap_maliyet'] ?? '0,00 ₺' ?>" data-kap-carpani="<?= $kap_carpani ?>" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="variant[<?= $i ?>][mineli]" value="<?= $variant['mineli'] ?? $mineli_default ?>" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="variant[<?= $i ?>][tasli]" value="<?= $variant['tasli'] ?? '0,00 ₺' ?>" data-tas-carpani="<?= $tas_carpani ?>" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="variant[<?= $i ?>][toplam_maliyet]" value="<?= $variant['toplam_maliyet'] ?? '0,00 ₺' ?>" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="variant[<?= $i ?>][kar_orani]" value="<?= $variant['kar_orani'] ?? $kar_orani_default ?>" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                            <td><input type="text" name="variant[<?= $i ?>][satis]" value="<?= $variant['satis'] ?? '0,00 ₺' ?>" style="width:100%;text-align:center;border:none;background:transparent;"></td>
                        </tr>
                        <?php endforeach; ?>
                        
                      </tbody>
                    </table>
                  </div>
                  <?php endif; ?>
        </div>



    </div>
</div>
</form>
<script>
// Inline edit script
function makeCellEditable(cell) {
    if (cell.querySelector('input')) return;
    var current = cell.innerText;
    var input = document.createElement('input');
    input.type = 'text';
    input.value = current;
    input.onblur = function() {
        cell.innerHTML = input.value;
        cell.classList.add('editable');
    };
    input.onkeydown = function(e) {
        if (e.key === 'Enter') {
            input.blur();
        }
    };
    cell.innerHTML = '';
    cell.appendChild(input);
    input.focus();
    cell.classList.remove('editable');
}
document.addEventListener('DOMContentLoaded', function() {
    function updateHamKapTasInputs() {
        const hamCarpani = parseFloat(document.getElementById('hamCarpaniInput').value) || 0;
        const kapCarpani = parseFloat(document.getElementById('kapCarpaniInput').value) || 0;
        const tasCarpani = parseFloat(document.getElementById('tasCarpaniInput').value) || 0;
        document.querySelectorAll('input[name^="variant"][name$="[gram]"]').forEach(function(gramInput) {
            const tr = gramInput.closest('tr');
            const hamInput = tr.querySelector('input[name^="variant"][name$="[ham]"]');
            const kapInput = tr.querySelector('input[name^="variant"][name$="[kap_maliyet]"]');
            const tasInput = tr.querySelector('input[name^="variant"][name$="[tasli]"]');
            const mineliInput = tr.querySelector('input[name^="variant"][name$="[mineli]"]');
            const toplamInput = tr.querySelector('input[name^="variant"][name$="[toplam_maliyet]"]');
            const karOraniInput = tr.querySelector('input[name^="variant"][name$="[kar_orani]"]');
            const satisInput = tr.querySelector('input[name^="variant"][name$="[satis]"]');
            const tasSayisiInput = tr.querySelector('input[name^="variant"][name$="[tas_sayisi]"]');
            const gram = parseFloat(gramInput.value.replace(',', '.')) || 0;
            if (hamInput) {
                const hamDeger = (gram * hamCarpani).toFixed(2) + ' ₺';
                hamInput.value = hamDeger;
            }
            if (kapInput) {
                const kapDeger = (gram * kapCarpani).toFixed(2) + ' ₺';
                kapInput.value = kapDeger;
            }
            if (tasInput && tasSayisiInput) {
                const tasSayisi = parseFloat(tasSayisiInput.value.replace(',', '.')) || 0;
                const tasDeger = (tasSayisi * tasCarpani).toFixed(2) + ' ₺';
                tasInput.value = tasDeger;
            }
            // Toplam maliyet hesaplama
            if (toplamInput && hamInput && kapInput && tasInput && mineliInput) {
                const hamVal = parseFloat((hamInput.value || '').replace('₺','').replace(',','.')) || 0;
                const kapVal = parseFloat((kapInput.value || '').replace('₺','').replace(',','.')) || 0;
                const mineliVal = parseFloat((mineliInput.value || '').replace('₺','').replace(',','.')) || 0;
                const tasVal = parseFloat((tasInput.value || '').replace('₺','').replace(',','.')) || 0;
                const toplam = (hamVal + kapVal + mineliVal + tasVal).toFixed(2);
                toplamInput.value = toplam + ' ₺';
                // Satış fiyatı hesaplama
                if (karOraniInput && satisInput) {
                    let karOrani = parseFloat((karOraniInput.value || '').replace('%','').replace(',','.')) || 0;
                    const satis = (toplam * (1 + karOrani / 100)).toFixed(2);
                    
                    satisInput.value = satis + ' ₺';
                }
            }
        });
    }
    // Gram, taş sayısı, mineli, kar oranı inputlarında değişiklik olunca
    document.querySelectorAll('input[name^="variant"][name$="[gram]"], input[name^="variant"][name$="[tas_sayisi]"], input[name^="variant"][name$="[mineli]"], input[name^="variant"][name$="[kar_orani]"]').forEach(function(input) {
        input.addEventListener('input', updateHamKapTasInputs);
    });
    // Çarpanlar değişince
    document.getElementById('hamCarpaniInput').addEventListener('input', updateHamKapTasInputs);
    document.getElementById('kapCarpaniInput').addEventListener('input', updateHamKapTasInputs);
    document.getElementById('tasCarpaniInput').addEventListener('input', updateHamKapTasInputs);
    // Sayfa yüklenince ilk hesaplama
    updateHamKapTasInputs();
});

</script>

<?= $this->section('script') ?>
<script>

$('#maliyetKaydet').on('click', function(e) {
    e.preventDefault();
    var form = $('#maliyetForm');
    var formData = form.serialize();
    $.ajax({
        url: '<?= route_to('tportal.stocks.ajaxMaliyetKaydet') ?>',
        type: 'POST',
        data: formData,
        dataType: 'json',
        beforeSend: function() {
            form.find('button[type=submit], #maliyetKaydet').prop('disabled', true);
        },
        success: function(response) {
            if(response.icon === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Başarılı!',
                    text: response.message || 'Değişiklikler kaydedildi.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: response.message || 'Bir hata oluştu.',
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                text: 'Sunucu ile iletişimde bir hata oluştu.',
            });
        },
        complete: function() {
            form.find('button[type=submit], #maliyetKaydet').prop('disabled', false);
        }
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
