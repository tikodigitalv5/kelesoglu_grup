<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?>Çekler<?= $this->endSection() ?>
<?= $this->section('title') ?>Çekler<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>Çek Listesi<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Çekler</h3>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Dışa Aktar</span></a></li>
                                    <li class="nk-block-tools-opt">
                                        <a href="<?= site_url('tportal/checks/add') ?>" class="btn btn-primary">
                                            <em class="icon ni ni-plus"></em>
                                            <span>Yeni Çek Ekle</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                    <div class="form-inline flex-nowrap gx-3">
                                    <div class="btn-wrap">
                                            <span class="d-none d-md-block"> <a href="/tportal/checks/add" class="btn btn-dim btn-outline-primary">Yeni Çek/Senet Ekle</a> </span>
                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                        </div>
                                        <div class="form-wrap w-150px">
                                            <select class="form-select js-select2" data-search="off" data-placeholder="Toplu İşlem">
                                                <option value="">Toplu İşlem</option>
                                                <option value="excel">İndir (Excel)</option>
                                                <option value="pdf">İndir (PDF)</option>
                                                <option value="print">Yazdır</option>
                                            </select>
                                        </div>
                                        <div class="btn-wrap">
                                            <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light disabled">Uygula</button></span>
                                        </div>
                                        
                                        <!-- Tarih Aralığı -->
                                        <div class="form-wrap d-md-block">
                                            <div class="form-group">    
                                                <div class="form-control-wrap">        
                                                    <div class="input-daterange date-picker-range input-group">            
                                                        <input type="text" class="form-control" data-date-format="dd/mm/yyyy" style="max-width: 150px;" />            
                                                        <div class="input-group-addon">İLE</div>            
                                                        <input type="text" class="form-control" data-date-format="dd/mm/yyyy" style="max-width: 150px;" />        
                                                    </div>    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn-wrap">
                                            <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light">Bul</button></span>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>

                            <!-- Tabs -->
                            <ul class="nav nav-tabs mt-3">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#" data-status="all">Tüm Çekler</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-status="portfolio">Portföydekiler</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-status="endorsed">Ciro Edilenler</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-status="paid">Ödenenler</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-status="bounced">Karşılıksız</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-inner p-0">
                            <div class="nk-tb-list nk-tb-ulist">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="checkAll">
                                            <label class="custom-control-label" for="checkAll"></label>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col"><span>Tarih</span></div>
                                    <div class="nk-tb-col"><span>Müşteri/Banka</span></div>
                                    <div class="nk-tb-col text-end"><span>Tutar</span></div>
                                    <div class="nk-tb-col text-end"><span>Vade</span></div>
                                    <div class="nk-tb-col"><span>Durum</span></div>
                                    <div class="nk-tb-col nk-tb-col-tools"></div>
                                </div>
                                <?php
                              
                                $aylar = array(
                                    'January'   => 'Ocak',
                                    'February'  => 'Şubat',
                                    'March'     => 'Mart',
                                    'April'     => 'Nisan',
                                    'May'       => 'Mayıs',
                                    'June'      => 'Haziran',
                                    'July'      => 'Temmuz',
                                    'August'    => 'Ağustos',
                                    'September' => 'Eylül',
                                    'October'   => 'Ekim',
                                    'November'  => 'Kasım',
                                    'December'  => 'Aralık'
                                );
                                ?>

                                <?php foreach ($checks as $check): ?>
                                <div class="nk-tb-item" data-status="<?= $check['status'] ?>">
                                    <div class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid<?= $check['id'] ?>">
                                            <label class="custom-control-label" for="uid<?= $check['id'] ?>"></label>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col">
                                        <div class="user-info">
                                            <span class="tb-lead">
                                                <?= date('d ', strtotime($check['check_created_at'])) . 
                                                    $aylar[date('F', strtotime($check['check_created_at']))] . 
                                                    date(' Y', strtotime($check['check_created_at'])) ?>
                                            </span>
                                            <span><?= date('H:i:s', strtotime($check['check_created_at'])) ?></span>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-avatar <?= in_array($check['status'], ['endorsed', 'paid', 'bounced']) ? 'bg-danger-dim' : 'bg-success-dim' ?> sq">
                                                <span><?= in_array($check['status'], ['endorsed', 'paid', 'bounced']) ? 'ÇKŞ' : 'GRŞ' ?></span>
                                            </div>
                                            <div class="user-info">
                                                <span class="tb-lead"><?= $check['invoice_title'] ?? ($check['check_type'] === 'customer' ? 'Müşteri Silinmiş' : session()->get('user_item')['firma_adi']) ?></span>
                                                <span><?= $check['bank_title'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col text-end">
                                        <?= number_format($check['amount'], 2, ',', '.') ?> <?= $check['currency'] ?>
                                    </div>
                                    <div class="nk-tb-col text-end">
                                        <?= date('d.m.Y', strtotime($check['due_date'])) ?>
                                    </div>
                                    <div class="nk-tb-col">
                                        <?php
                                        $statusClasses = [
                                            'portfolio' => 'primary',
                                            'endorsed' => 'info',
                                            'paid' => 'success',
                                            'bounced' => 'danger',
                                            'cancelled' => 'warning'
                                        ];
                                        $statusTexts = [
                                            'portfolio' => 'Portföyde',
                                            'endorsed' => 'Ciro Edildi',
                                            'paid' => 'Ödendi',
                                            'bounced' => 'Karşılıksız',
                                            'cancelled' => 'İptal'
                                        ];
                                        ?>
                                        <span class="badge bg-primary"><?= $statusTexts[$check['status']] ?></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-col-tools text-end">
                                        <?php if ($check['status'] === 'portfolio'): ?>
                                            <ul class="nk-tb-actions gx-2">
                                                <li>
                                                    <a href="<?= site_url('tportal/checks/endorse/' . $check['id']) ?>" 
                                                       class="btn btn-sm btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Ciro Et">
                                                        <em class="icon ni ni-arrow-right-circle text-primary"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= site_url('tportal/checks/mark-as-paid/' . $check['id']) ?>" 
                                                       class="btn btn-sm btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Öde">
                                                        <em class="icon ni ni-check-circle text-success"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= site_url('tportal/checks/mark-as-bounced/' . $check['id']) ?>" 
                                                       class="btn btn-sm btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Karşılıksız">
                                                        <em class="icon ni ni-cross-circle text-danger"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= site_url('tportal/checks/transactions/' . $check['id']) ?>" 
                                                       class="btn btn-sm btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Detay">
                                                        <em class="icon ni ni-chevron-right"></em>
                                                    </a>
                                                </li>
                                            </ul>
                                        <?php else: ?>
                                            <a href="<?= site_url('tportal/checks/transactions/' . $check['id']) ?>" 
                                               class="btn btn-sm btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Detay">
                                                <em class="icon ni ni-chevron-right"></em>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="card-inner">
                            <div class="nk-block-between-md g-3">
                                <div class="g">
                                    <ul class="pagination justify-content-center justify-content-md-start">
                                        <li class="page-item"><a class="page-link" href="#">Geri</a></li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">İleri</a></li>
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
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Tab işlevselliği
    $('.nav-tabs .nav-link').on('click', function(e) {
        e.preventDefault();
        
        // Aktif tab'ı değiştir
        $('.nav-tabs .nav-link').removeClass('active');
        $(this).addClass('active');
        
        // Seçilen durumu al
        const status = $(this).data('status');
        
        // Tabloyu filtrele
        if (status === 'all') {
            $('.nk-tb-item:not(.nk-tb-head)').show();
        } else {
            $('.nk-tb-item:not(.nk-tb-head)').each(function() {
                if ($(this).data('status') === status) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
        
        // Sayfalama bilgisini güncelle
        updatePagination();
    });

    // Toplu seçim
    $('#checkAll').on('change', function() {
        const isChecked = $(this).prop('checked');
        $('.nk-tb-item:visible:not(.nk-tb-head) .custom-control-input').prop('checked', isChecked);
    });

    // Sayfalama bilgisini güncelle
    function updatePagination() {
        const visibleRows = $('.nk-tb-item:visible:not(.nk-tb-head)').length;
        const totalRows = $('.nk-tb-item:not(.nk-tb-head)').length;
        $('.pagination-info').text(`1-${visibleRows} / ${totalRows} kayıt`);
    }

    // Tooltip'leri aktifleştir
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>

<style>
.nk-tb-actions {
    display: flex;
    align-items: center;
    margin: 0;
    padding: 0;
    list-style: none;
}

.nk-tb-actions li {
    display: inline-flex;
}

.btn-trigger {
    background: transparent;
    border: none;
    padding: 0.25rem;
    line-height: 1;
    height: 28px;
    width: 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all .3s;
}

.btn-trigger:hover {
    background-color: #f5f6fa;
    border-radius: 50%;
}

.btn-trigger .icon {
    font-size: 1rem;
}

/* Tooltip stilleri */
.tooltip {
    font-size: 12px;
}
</style>
<?= $this->endSection() ?>