
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
                                        <h4 class="nk-block-title">Yetkili Bilgileri</h4>
                                      
                                    </div>
                                    <div class="nk-block-head-content align-self-start">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#mdl_yetkili" class="btn btn-primary">Yeni Yetkili</a>
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1 d-lg-none" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                   

                                    <table class="datatable-init-hareketler nowrap table" data-export-title="Export">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2;">Ad soyad</th>
                                                <th style="background-color: #ebeef2;">Telefon / Dahili</th>
                                                <th style="background-color: #ebeef2;">E-posta</th>
                                                <th style="background-color: #ebeef2;">Departman</th>
                                                <th style="background-color: #ebeef2;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Fesih Bey</td>
                                                <td>+90 536 999 65 45</td>
                                                <td>fesih@famsotomotiv.com</td>
                                                <td>Firma Sahibi</td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-icon btn-xs btn-dim btn-outline-dark"><em class="icon ni ni-pen-alt-fill"></em></a>
                                                    <a href="#" class="btn btn-icon btn-xs btn-dim btn-outline-danger"><em class="icon ni ni-trash-empty"></em></a>
                                                </td>
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



<!-- Modal Alert 2 -->
<div class="modal fade" tabindex="-1" id="mdl_yetkili">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Yetkili</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="createStockOperationForm" method="post"
                    class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="type_title">Departman Seç</label>
                        <div class="form-control-wrap">
                            <select class="form-select  init-select2" data-ui="xl" name="yetkili_departman_id"
                                id="yetkili_departman_id">
                                <option value="0" selected disabled>Lütfen Seçiniz</option>
                              
                                <option value="1">Firma Sahibi</option>
                                <option value="2">Muhasebe</option>
                                <option value="3">Satış</option>
                                <option value="4">Satınalma</option>
                               
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-12">
                            <label class="form-label" for="type_title">Ad Soyad</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="Yetkilinin Adı"
                                    id="relation_order" name="relation_order" required>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-12">
                            <label class="form-label" for="type_title">E-posta</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="Yetkilinin E-posta Adresi"
                                    id="relation_order" name="relation_order" required>
                            </div>
                        </div>
                        
                    </div>
                   


                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-9 col-xxl-9 col-9">
                            <label class="form-label" for="type_title">Telefonu</label>
                            <div class="form-control-wrap">
                            <div class="form-group">
                                        <div class="input-group  input-group-xl">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-lg btn-block btn-dim btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                                                    <span>+90</span>
                                                    <em class="icon mx-n1 ni ni-chevron-down"></em>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#">+90 Türkiye</a></li>
                                                        <li><a href="#">+01 USA, Canada</a></li>
                                                        <li><a href="#">+20 Mısır</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control form-control-xl" aria-label="Text input with dropdown button" placeholder="000 000 00 00"></div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xxl-3 col-3">
                            <label class="form-label" for="type_title">Dahili</label>
                            <div class="form-control-wrap">
                               
                                    <input type="text" class="form-control form-control-xl" placeholder="10"
                                        required="" id="duration" name="duration">
                                   
                               
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
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>

</script>

<?= $this->endSection() ?>