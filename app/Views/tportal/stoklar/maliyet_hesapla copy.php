<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Maliyet Hesaplama | <?= $this->endSection() ?>
<?= $this->section('title') ?> Maliyet Hesaplama | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>

<style>
    .excel-table {
        border-collapse: collapse;
        width: 100%;
        font-family: 'Calibri', 'Arial', sans-serif;
        background: #fff;
        table-layout: fixed;
    }
    .excel-table th, .excel-table td {
        border: 2px solid #222;
        padding: 0 8px;
        font-size: 15px;
        min-width: 60px;
        height: 36px;
        vertical-align: middle;
        background: #fff;
        text-align: center;
        font-weight: normal;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .excel-table th {
        background: #111;
        color: #e74c3c;
        font-weight: bold;
        font-size: 16px;
        border-bottom: 2.5px solid #222;
        border-top: 2.5px solid #222;
        letter-spacing: 0.5px;
        text-align: center;
        height: 40px;
    }
    .excel-table th span {
        color: #e74c3c;
        font-weight: bold;
    }
    .excel-table tr.ana-urun {
        background: #fff;
        font-weight: bold;
    }
    .excel-table tr.varyant {
        background: #fff;
    }
    .excel-table td img {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        background: #e0e0e0;
        display: block;
        margin: 0 auto;
    }
    .excel-table a {
        color: #0099ff;
        text-decoration: underline;
        font-weight: bold;
    }
    .excel-table .para {
        color: #222;
        font-weight: normal;
    }
    .excel-table .check {
        color: #27ae60;
        font-size: 18px;
        font-weight: bold;
        vertical-align: middle;
    }
    .excel-table .percent {
        color: #222;
        font-weight: normal;
        margin-left: 2px;
    }
    .excel-table .red {
        color: #e74c3c;
        font-weight: bold;
    }
    .excel-table .gray {
        color: #888;
    }
    .excel-table td {
        border-bottom: 2px solid #222;
    }
</style>
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <table class="excel-table" id="editableTable">
                <thead>
                    <tr>
                        <th>GÖRSEL</th>
                        <th>KOD</th>
                        <th>ÜRÜN</th>
                        <th>GRAM</th>
                        <th>TAŞ SAYISI</th>
                        <th>HAM</th>
                        <th>KAP MALİYETİ</th>
                        <th>MİNELİ</th>
                        <th>TAŞLI</th>
                        <th>TOPLAM MALİYET</th>
                        <th>KAR ORANI</th>
                        <th>SATIŞ</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($mainProduct) && $mainProduct): ?>
                    <tr class="ana-urun">
                        <td>
                            <?php if(!empty($mainProduct['default_image'])): ?>
                                <img src="<?= htmlspecialchars($mainProduct['default_image']) ?>" alt="Görsel">
                            <?php else: ?>
                                <div style="width:38px;height:38px;background:#ccc;border-radius:50%;"></div>
                            <?php endif; ?>
                        </td>
                        <td><a href="#">S000001</a></td>
                        <td><a href="#">ZS1</a></td>
                        <td class="gray">-</td>
                        <td class="gray">-</td>
                        <td class="gray">-</td>
                        <td class="gray">-</td>
                        <td class="gray">-</td>
                        <td class="gray">-</td>
                        <td class="gray">-</td>
                        <td class="gray">-</td>
                        <td class="gray">-</td>
                    </tr>
                    <?php if(isset($variantProducts) && count($variantProducts) > 0): ?>
                        <?php foreach($variantProducts as $variant): ?>
                        <tr class="varyant">
                            <td></td>
                            <td><a href="#">S<?= htmlspecialchars($variant['stock_code']) ?></a></td>
                            <td><?= htmlspecialchars($variant['stock_title']) ?></td>
                            <td>0,0</td>
                            <td>0,0</td>
                            <td><span class="para">0,0000 ₺</span></td>
                            <td><span class="para">0,0000 ₺</span></td>
                            <td><span class="para">0,0000 ₺</span></td>
                            <td><span class="para">0,0000 ₺</span></td>
                            <td><span class="para">0,0000 ₺</span></td>
                            <td><span class="check">✔</span> <span class="percent">%0</span></td>
                            <td><span class="para">0,0000 ₺</span></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
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
    document.querySelectorAll('#editableTable td.editable').forEach(function(cell) {
        cell.addEventListener('click', function() {
            makeCellEditable(cell);
        });
    });
});
</script>

<?= $this->endSection() ?>