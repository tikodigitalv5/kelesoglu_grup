
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
                                        <h4 class="nk-block-title">Tahsilat/Ödeme Oluştur</h4>
                                      
                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <form onsubmit="return false;" id="addUrun" method="post"> 
                                  
                                        <div class="gy-3">
                
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="site-name">Ödeme / Tahsilar</label><span class="form-note d-none d-md-block">Ödeme Aldıysanız TAHSİLAT.<br>Ödeme yaptıysanız ÖDEME seçiniz.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                                <ul class="custom-control-group">
                                                                    <li>
                                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                            <input type="radio" class="custom-control-input" name="btnCheckControl" id="btnCheckControl1">
                                                                            <label class="custom-control-label" for="btnCheckControl1">
                                                                                
                                                                                <span>TAHSİLAT</span>
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                            <input type="radio" class="custom-control-input" name="btnCheckControl" id="btnCheckControl2">
                                                                            <label class="custom-control-label" for="btnCheckControl2">
                                                                               
                                                                                <span>ÖDEME</span>
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="site-name">Tutar ve Tarihi</label>
                                                            <span class="form-note d-none d-md-block">İşlem yapılan tutar ve tarihi giriniz.</span>
                                                        </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-xl text-end" placeholder="0,00">
                                                            <div class="input-group-append">
                                                                <button data-bs-toggle="modal" data-bs-target="#mdl_parabirimi" class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                    <span>TRY</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                      
                                                </div>
                
                                                <div class="" style="width: 160px">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left" style="width: calc(1rem + 30px); top:1px">
                                                            <em class="icon ni ni-calendar icon-xl"></em>
                                                        </div>
                                                        <input id="fatura_tarihi" name="fatura_tarihi" type="text" class="form-control form-control-xl date-picker" style="padding-right: 16px; padding-left: 44px;" data-date-format="dd/mm/yyyy" value="12/08/2023">
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="site-name">İşlem Hesabı</label>
                                                            <span class="form-note d-none d-md-block">İşlem yapılan hesabı seçiniz veya ekleyiniz.</span>
                                                        </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-xl" disabled placeholder="Hesap seçmek için tıklayınız..">
                                                            <div class="input-group-append">
                                                                <button data-bs-toggle="modal" data-bs-target="#mdl_hesaplar" class="btn btn-lg btn-block btn-dim btn-outline-light">SEÇ</button>
                                                               <!-- <button class="btn btn-lg btn-block btn-dim btn-outline-light">EKLE</button> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                      
                                                </div>
                
                                               
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="urun_adi">İşlem Başlık</label><span class="form-note d-none d-md-block">Cari hareketlerinzde gözükebilir yazarsanız.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-xl" id="urun_adi" value="" placeholder="Örn : Ön Ödeme"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group"><label class="form-label" for="txt_adres">İşlem Notu</label><span class="form-note d-none d-md-block">Sadece sizin detayda görebileceğiniz br nottur.</span></div>
                                            </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <textarea class="form-control form-control-lg" name="txt_adres" id="txt_adres" cols="30" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            
                                            
                                        </div>
                                        <div class="row g-3 pt-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <!-- <a href="javascript:history.back()" class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Geri</span></a> -->
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <div class="form-group">
                                                    <button type="submit" id="yeniUrun" class="btn btn-lg btn-primary">Kaydet</button>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                              
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