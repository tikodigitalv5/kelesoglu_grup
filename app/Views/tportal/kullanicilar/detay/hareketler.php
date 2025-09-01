
<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Cari Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Cari Detay | Müşteri Ünvan Gelecek <?= $this->endSection() ?>
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
                                        <h4 class="nk-block-title">Cari Hareketleri</h4>
                                      
                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                   

                                    <table class="datatable-init-hareketler nowrap table" data-export-title="Export">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2;">Tarih</th>
                                                <th style="background-color: #ebeef2;">İşlem</th>
                                                <th style="background-color: #ebeef2;">İşlem No</th>
                                                <th style="background-color: #ebeef2;">Bilgi</th>
                                                <th style="background-color: #ebeef2;">Miktar</th>
                                                <th style="background-color: #ebeef2;">Bakiye</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        <tr>
                                                <td>07/08/2023</td>
                                                <td><span class="tb-status text-success">Tahsilat</span></td>
                                                <td>THS2023000000011</td>
                                                <td>ENPARA-Şirketim</td>
                                                <td class="text-end">20.000,00 ₺</td>
                                                <td class="text-end"><span class="tb-status text-danger">-6.000,00 ₺</span></td>
                                            </tr>
                                            <tr>
                                                <td>07/08/2023</td>
                                                <td><span class="tb-status text-success">Tahsilat</span></td>
                                                <td>THS2023000000011</td>
                                                <td>ENPARA-Şirketim</td>
                                                <td class="text-end">5.000,00 ₺</td>
                                                <td class="text-end"><span class="tb-status text-success">14.000,00 ₺</span></td>
                                            </tr>
                                        <tr>
                                                <td>07/08/2023</td>
                                                <td><span class="tb-status text-danger">Giden Fatura</span></td>
                                                <td>PROFORMA</td>
                                                <td>Sistemde</td>
                                                <td class="text-end">19.000,00 ₺</td>
                                                <td class="text-end"><span class="tb-status text-success">19.000,00 ₺</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- data-list -->
                              
                            </div><!-- .nk-block -->
                        </div>
                        
                        <?= $this->include('tportal/cariler/detay/inc/sol_menu') ?>
                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>

</script>

<?= $this->endSection() ?>