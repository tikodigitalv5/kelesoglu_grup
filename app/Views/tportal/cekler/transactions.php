<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?>Çek İşlem Geçmişi<?= $this->endSection() ?>
<?= $this->section('title') ?>Çek İşlem Geçmişi<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>Çek No: <?= $check['check_no'] ?><?= $this->endSection() ?>

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
                                                <span class="sub-text">Durum:</span>
                                                <span class="lead-text">
                                                    <?php
                                                    switch($check['status']) {
                                                        case 'portfolio':
                                                            echo '<span class="badge bg-primary text-white">Portföyde</span>';
                                                            break;
                                                        case 'endorsed':
                                                            echo '<span class="badge bg-info text-white">Ciro Edildi</span>';
                                                            break;
                                                        case 'paid':
                                                            echo '<span class="badge bg-success text-white">Ödendi</span>';
                                                            break;
                                                        case 'bounced':
                                                            echo '<span class="badge bg-danger text-white">Karşılıksız</span>';
                                                            break;
                                                        case 'cancelled':
                                                            echo '<span class="badge bg-warning text-white">İptal</span>';
                                                            break;
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Çek Görsel Alanı -->
                            <div class="col-md-6">
                                <?php if (!empty($check['check_image'])): ?>
                                <div class="card bg-light h-100">
                                    <div class="">
                                        <img src="<?= base_url($check['check_image']) ?>" 
                                             alt="Çek Görseli" 
                                             class="img-fluid rounded" 
                                             style="max-height: 180px; cursor: pointer; width:100%"
                                             onclick="openImageModal(this.src)">
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-inner">
                                <table class="datatable-init nowrap table" data-export-title="Export">
                                    <thead>
                                        <tr>
                                            <th>Tarih</th>
                                            <th>İşlem Tipi</th>
                                            <th>Kimden</th>
                                            <th>Kime</th>
                                            <th>Açıklama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($transactions as $transaction): ?>
                                        <tr>
                                            <td><?= date('d.m.Y H:i', strtotime($transaction['transaction_date'])) ?></td>
                                            <td>
                                                <?php
                                                switch($transaction['transaction_type']) {
                                                    case 'receive':
                                                        echo '<span class="badge bg-success">Portföye Alındı</span>';
                                                        break;
                                                    case 'endorse':
                                                        echo '<span class="badge bg-info">Ciro Edildi</span>';
                                                        break;
                                                    case 'payment':
                                                        echo '<span class="badge bg-primary">Ödendi</span>';
                                                        break;
                                                    case 'bounce':
                                                        echo '<span class="badge bg-danger">Karşılıksız</span>';
                                                        break;
                                                    case 'cancel':
                                                        echo '<span class="badge bg-warning">İptal</span>';
                                                        break;
                                                }
                                                ?>
                                            </td>
                                            <td><?= $transaction['from_name'] ?></td>
                                            <td><?= $transaction['to_name'] ?></td>
                                            <td><?= $transaction['description'] ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Görsel Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Çek Görseli</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="modalImage" class="img-fluid" alt="Çek Görseli">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    var modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}

function printCheck() {
    window.open('<?= site_url('tportal/checks/print/' . $check['id']) ?>', '_blank');
    }
</script>
<?= $this->endSection() ?> 