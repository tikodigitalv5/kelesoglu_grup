<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> <?= $page_title ?> <?= $this->endSection() ?>
<?= $this->section('title') ?> <?= $page_title ?> | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<style>
    .nk-iv-wg2 {
    display: flex;
    flex-direction: column;
    height: 100%;
}
.nk-iv-wg2-title {
    margin-bottom: .75rem;
}
.is-dark .nk-iv-wg2-title .title {
    color: #c4cefe;
}

.nk-iv-wg2-title .title {
    font-size: .875rem;
    line-height: 1.25rem;
    font-weight: 500;
    color: #8094ae;
    font-family: Roboto, sans-serif;
}
.nk-iv-wg2-title .title .icon {
    font-size: 13px;
    margin-left: .2rem;
}

.nk-iv-wg2-amount {
    font-size: 2.25rem;
    letter-spacing: -.03em;
    line-height: 1.15em;
    display: flex;
    justify-content: space-between;
    align-items: baseline;
}
.card-bordered {
    border: 1px solid #dbdfea;
}



.nk-wg-card.is-s3:after {
    background-color: #1ee0ac;
}


.nk-wg-card.is-s1:after {
    background-color: #364a63;
}
.nk-wg-card.is-s2:after {
    background-color: #004ad0;
}
.nk-wg-card:after {
    content: "";
    position: absolute;
    height: .25rem;
    background-color: transparent;
    left: 0;
    bottom: 0;
    right: 0;
    border-radius: 0 0 3px 3px;
}
.nk-wg-card.is-s0:after{
    background: #3a2272;
    color: white;
}

.stok-kontrol-modal .modal-dialog.modal-lg {
    max-width: 800px !important;
    width: 800px !important;
}

.stok-kontrol-modal .modal-content {
    width: 100% !important;
}

</style>


<?= $this->section('main') ?>
<style>
    .btn-dim {

padding: 10px!important;
}


</style>


<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title"><?= $page_title ?></h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                    <li class="nk-block-tools-opt">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>Add User</span></a></li>
                                                    <li><a href="#"><span>Add Team</span></a></li>
                                                    <li><a href="#"><span>Import User</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .toggle-wrap -->
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19): ?>
            <div class="nk-block">
  <div class="row gy-gs">

        <?php
        $toplamSiparis = 0;
        if(isset($platformlarliste) && count($platformlarliste) > 0):
        foreach($platformlarliste as $key):
        $toplamSiparis += $key["count"];
        if(isset($key["service_name"])):
        ?>
  <div class="col-md-6 col-lg-3 hovers serviceSecme" style="cursor:pointer;" data-service="<?php echo $key["service_name"]; ?>">
      <div class="nk-wg-card is-s0 card card-bordered">
        <div class="card-inner">
          <div class="nk-iv-wg2">
            <div class="nk-iv-wg2-title" style="display:flex; align-items:center; gap:30px">
                <div>
                    <img style="height: 70px;" src="<?php echo $key["service_logo"]; ?>" alt="">
                </div>
                <div>
                <h6 class="title" style="text-transform:uppercase"><?php echo $key["service_name"]; ?>
              </h6>
              

                <div class="nk-iv-wg2-text">
              <div class="nk-iv-wg2-amount" style="font-size:16px"> BUGÜN  <b><span  style="font-size:25px; margin-left:10px" class="  text-primary"><?php echo $key["count"]; ?></span></b> 
              </div>
            </div>
                </div>
            
            </div>
          
          </div>
        </div>
      </div>
    </div>
        <?php endif; endforeach; endif; ?>

    <div class="col-md-6 col-lg-3 hovers serviceSecme" style="cursor:pointer;" data-service="0">
      <div class="nk-wg-card is-s0 card card-bordered">
        <div class="card-inner">
          <div class="nk-iv-wg2">
            <div class="nk-iv-wg2-title" style="display:flex; align-items:center; gap:30px">
                <div>
                    <img style="height: 70px;" src="https://www.famsotomotiv.com/assets/images/favicon.png" alt="">
                </div>
                <div>
                <h6 class="title" style="text-transform:uppercase">TOPLAM SİPARİŞ
              </h6>
              

                <div class="nk-iv-wg2-text">
              <div class="nk-iv-wg2-amount" style="font-size:16px"> BUGÜN  <b><span  style="font-size:25px; margin-left:10px" class="  text-primary"><?php echo $toplamSiparis; ?></span></b> 
              </div>
            </div>
                </div>
            
            </div>
          
          </div>
        </div>
      </div>
    </div>



    <div class="col-md-6 col-lg-3 hovers d-none" style="cursor:pointer;" onclick="window.location.href='<?php echo base_url('tportal/order/sevk_emirleri');  ?>' "  data-service="0">
    <div class="nk-wg-card is-s0 card card-bordered">
        <div class="card-inner">
            <div class="nk-iv-wg2">
                <div class="nk-iv-wg2-title" style="display:flex; align-items:center; gap:30px">
                    <div>
                    <img style="height: 70px;" src="<?php echo base_url("uploads/kargo_logov2.png"); ?>" alt="">

                    </div>
                    <div>
                        <h6 class="title" style="text-transform:uppercase">TOPLAM SEVK</h6>
                        <div class="nk-iv-wg2-text">
                            <div class="nk-iv-wg2-amount" style="font-size:16px">BUGÜN
                                <b><span style="font-size:25px; margin-left:10px" class="text-primary"><?php echo $bugunSevkler; ?></span></b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="col-md-6 col-lg-3 hovers" style="cursor:pointer;" onclick="window.location.href='<?php echo base_url('tportal/order/sevk_emirleri');  ?>' "  data-service="0">
    <div class="nk-wg-card is-s0 card card-bordered">
        <div class="card-inner">
            <div class="nk-iv-wg2">
                <div class="nk-iv-wg2-title" style="display:flex; align-items:center; gap:30px">
                    <div>
                    <img style="height: 70px;" src="<?php echo base_url("uploads/kargo_logov2.png"); ?>" alt="">

                    </div>
                    <div>
                        <h6 class="title" style="text-transform:uppercase">AÇIK EMİR</h6>
                        <div class="nk-iv-wg2-text">
                            <div class="nk-iv-wg2-amount" style="font-size:16px">
                                <b><span style="font-size:25px; margin-left:10px" class="text-primary"><?php echo $bugunSevkler; ?>  </span></b>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 
  
   
  </div>
</div>

<?php endif;  ?>

            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                    <div class="form-inline flex-nowrap gx-3">
                                        <div class="form-wrap w-200px">
                                            <select class="form-select toplu_islem js-select2" data-search="off" id="SiparisAktar" data-placeholder="Toplu İşlem">
                                                <option value="">Toplu İşlem</option>
                                                <?php if(session()->get('user_id') == 5): ?>
                                                <option value="b2b">B2B Sipariş Aktar</option>
                                                <?php endif; ?>
                                                <?php if(session()->get('user_id') == 5): ?>
                                                <option value="fabrika_aktar">Planlamaya Sipariş Aktar</option>
                                                <?php endif; ?>
                                                <?php if(session()->get('user_id') == 15): ?>
                                                <option value="b2b3d">B2B Sipariş Aktar</option>
                                                <?php endif; ?>
                                                <?php if(session()->get('user_id') == 13): ?>
                                                <option value="b2bartliving">B2B Sipariş Aktar</option>
                                                <?php endif; ?>
                                                <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19): ?>
                                                <option value="dopigo">DOPİGO Sipariş Aktar</option>
                                                <?php endif; ?>
                                                <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19): ?>
                                                <option value="sevk_emri">Sevkiyat Emiri Oluştur</option>
                                                <?php endif; ?>
                                                <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19): ?>
                                                <option value="sysmond_irsaliye">İRSALİYE OLUŞTUR</option>
                                                <?php endif; ?>
                                                <option value="#">İndir (Excel)</option>
                                                <option value="#">İndir (PDF)</option>
                                                <option value="#">Yazdır</option>
                                                <option value="#">Seçilenleri Sil</option>
                                            </select>
                                        </div>
                                        <div class="btn-wrap  ">
                                            <div style="display:flex;">
                                            <span class="d-none d-md-block"><button id="indirButton" class="btn btn-dim btn-outline-light disabled">Uygula</button></span>
                                            <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19): ?>
                                            <span style="margin-left:10px" class="d-none d-md-block"><a href="<?php echo route_to('tportal.siparisler.sevk_emirleri'); ?>" class="btn btn-dim btn-outline-primary ">Sevk Emirleri</a></span>
                                            <span style="margin-left:10px" class="d-none d-md-block"><a href="<?php echo route_to('tportal.siparisler.urunleri_esle'); ?>" class="btn btn-dim btn-outline-danger "><em style="margin-top:-3px" class="icon ni ni-layers"></em> &nbsp;Eşleşmeyen Ürünler</a></span>
                                            <span style="margin-left:10px" class="d-none d-md-block"><a href="<?php echo route_to('tportal.siparisler.eslesen_urunler'); ?>" class="btn btn-dim btn-outline-secondary "><em style="margin-top:-3px" class="icon ni ni-layers"></em> &nbsp;EŞLEŞEN ÜRÜNLER</a></span>
                                            <span style="margin-left:10px" class="d-none"><a href="<?php echo route_to('tportal.siparisler.urunleri_esle'); ?>" class="btn btn-dim btn-outline-primary "><em style="margin-top:-3px" class="icon ni ni-layers"></em> &nbsp;  Ürünleri Eşle</a></span>
                                            <span style="margin-left:10px" class="d-none d-md-block"><a href="<?php echo route_to('tportal.api.dopigo.list'); ?>" class="btn btn-dim btn-outline-primary "><em style="margin-top:-3px" class="icon ni ni-server"></em> &nbsp;  DOPİGO</a></span>
                                            <span style="margin-left:10px" class="d-none d-md-block"><a href="<?php echo route_to('tportal.siparisler.raporlar'); ?>" class="btn btn-dim btn-outline-primary "><em style="margin-top:-3px" class="icon ni ni-reports"></em> &nbsp;  RAPORLAR</a></span>
                                            <?php endif; ?>

                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                            </div>
                                        </div>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                   
                                        <li>

                                            <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search">
                                                <div class="dot dot-primary d-none" id="notification-dot-search"></div>
                                                <em class="icon ni ni-search"></em>
                                            </a>
                                        </li><!-- li -->
                                        <li class="btn-toolbar-sep"></li><!-- li -->
                                        
                                        <li>
                                        <li>
                                            <div class="toggle-wrap">
                                                <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                <div class="toggle-content" data-content="cardTools">
                                                    <ul class="btn-toolbar gx-1">
                                                        <li class="toggle-close">
                                                            <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                                    <div class="dot dot-primary d-none" id="notification-dot"></div>
                                                                    <em class="icon ni ni-filter"></em>
                                                                </a>
                                                                <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                                    <div class="dropdown-head">
                                                                        <span class="sub-title dropdown-title">Detaylı
                                                                            Arama</span>
                                                                        <div class="dropdown">
                                                                            <a href="#" class=" d-none btn btn-sm btn-icon">
                                                                                <em class="icon ni ni-more-h"></em>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dropdown-body dropdown-body-rg">
                                                                        <div class="row gx-6 gy-3">
                                                                          
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label class="overline-title overline-title-alt">Sipariş Durumları</label>
                                                                                    <select class="form-select durumaGore js-select2" data-search="off" id="durumaGore" data-placeholder="Sipariş Durumu">
                                                <option value="0" selected>Hepsi</option>

                                                <option value="new" >Yeni Sipraiş</option>
                                                <option value="pending" >Hazırlanıyor</option>
                                                <option value="success" >Tamamlandı</option>
                                                <option value="failed" >İptal Edildi</option>
                                                <option value="sevk_emri" >Sevk Emri Verildi</option>
                                                <option value="sevk_edildi" >Sevk Edildi</option>
                                                <option value="kargolandi" >Kargolandı</option>
                                                <option value="kargo_bekliyor" >Kargo Bekliyor</option>
                                                <option value="yetistirilemedi" >Yetiştirilmedi</option>
                                               
                                            </select>

                                                                           
                                                                                </div>
                                                                            </div>
                                                                            <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19): ?>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label class="overline-title overline-title-alt">Platformlar</label>
                                                                                    <select class="form-select  js-select2" data-search="off" id="platformSec" data-placeholder="Platformlar">
                                                <option value="0" selected>Hepsi</option>
                                                <?php
        $toplamSiparis = 0;
        foreach($platformlarliste as $key):
        $toplamSiparis += $key["count"];
        ?>
                                                <option value="<?php echo $key["service_name"]; ?>" style="text-transform:uppercase"><?php echo $key["service_name"]; ?></option>
                                                <?php endforeach; ?>
                                               
                                            </select>

                                                                           
                                                                                </div>
                                                                            </div>
                                                                            <?php else: ?>

                                                                                <select style="display:none;" class="form-select d-none" data-search="off" id="platformSec" data-placeholder="Platformlar">
                                                <option value="0" selected>Hepsi</option>
                                               
                                               
                                            </select>


                                                                            <?php endif; ?>
                                                                            <div class="col-12">
    <div class="form-group">
        <label class="overline-title overline-title-alt">Başlangıç Tarihi</label>
        <div class="form-control-wrap">
            <div class="form-icon form-icon-right">
                <em class="icon ni icon-lg ni-calendar-alt"></em>
            </div>
            <div class="input-daterange date-picker input-group">
                <input type="text" name="report_date_start" id="report_date_start" class="form-control" value="<?= isset($date1) ? date("d/m/Y", strtotime($date1)) : date('d/m/Y') ?>" />
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="form-group">
        <label class="overline-title overline-title-alt">Bitiş Tarihi</label>
        <div class="form-control-wrap">
            <div class="form-icon form-icon-right">
                <em class="icon ni icon-lg ni-calendar-alt"></em>
            </div>
            <div class="input-daterange date-picker input-group">
                <input type="text" name="report_date_end" id="report_date_end" class="form-control" value="<?= isset($date2) ? date("d/m/Y", strtotime($date2)) : date('d/m/Y') ?>" />
            </div>
        </div>
    </div>
</div>

<div class="dropdown-foot between">
    <button class="btn btn-light" id="clearFilters">Filtreyi Temizle</button>
    <button class="btn btn-primary" id="applyFilters">Filtreyi Uygula</button>
</div>
                                                                </div><!-- .filter-wg -->
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-filter-alt"></em>
                                                                </a>

                                                                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                                                    <ul class="link-check">
                                                                        <li><span>Sayfalama</span></li>
                                                                        <li><a href="javascript:;" id="row-10">10</a></li>
                                                                        <li><a href="javascript:;" id="row-25">25</a></li>
                                                                        <li><a href="javascript:;" id="row-50">50</a></li>
                                                                        <li><a href="javascript:;" id="row-100">100</a></li>
                                                                        <li><a href="javascript:;" id="row-200">200</a></li>
                                                                        <li><a href="javascript:;" id="row-1000">1000</a></li>
                                                                        <!-- <li><a href="javascript:;" id="row-all">Tümü</a></li> -->
                                                                    </ul>
                                                                    <!-- <ul class="link-check">
                                                                      <li><span>Order</span></li>
                                                                      <li class="active"><a href="#">DESC</a></li>
                                                                      <li><a href="#">ASC</a></li>
                                                                  </ul> -->
                                                                </div>
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                    </ul><!-- .btn-toolbar -->
                                                </div><!-- .toggle-content -->
                                            </div><!-- .toggle-wrap -->
                                        </li><!-- li -->
                                        </li><!-- li -->
                                    </ul><!-- .btn-toolbar -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" id="stock_input_search" class="form-control border-transparent form-focus-none" placeholder="Bulmak istediğiniz ürünün adını yada kodunu yazınız..">
                                        <a href="#" class="btn btn-icon toggle-search active" data-target="search" style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em class="icon ni ni-cross"></em></a>
                                        <button class="search-submit btn btn-icon" style="margin-right: 50px;" id="stock_input_search_clear_button" name="stock_input_search_clear_button"><em class="icon ni ni-trash"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div><!-- .card-inner -->



                        <div class="card-inner p-0">
                            <table id="datatableStock" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                <thead>
                                    <tr class="nk-tb-item nk-tb-head tb-tnx-head">
                                        <th class="nk-tb-col nk-tb-col-check">
                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                <input type="checkbox" class="custom-control-input" id="selectAllStock">
                                                <label class="custom-control-label" for="selectAllStock"></label>
                                            </div>
                                        </th>

                                        <!-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">S.Tipi</span></th> -->
                                        <th class="nk-tb-col" wdith="1%"><span class="sub-text">Sipariş Tarihi</span></th>
                                        <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19): ?>
                                        <th class="nk-tb-col" width="15%"><span class="sub-text">Platform</span></th>
                                        <?php endif; ?>
                                        <!-- <th class="nk-tb-col tb-col-mb"><span class="sub-text">Kodu</span></th> -->
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">Sipariş No</span></th>
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">Müşteri</span></th>
                                        <!-- <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">İşlemde</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">Toplam</span></th> -->
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">Tutar</span></th>
                                        <th class="nk-tb-col tb-col-lg" width="20%"data-orderable="false"><span class="sub-text">Durum</span></th>
                                        <th class="nk-tb-col nk-tb-col-tools text-end"  width="6%" data-orderable="false"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>


                  
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>



<!-- Müşteri Seç Modal -->
<div class="modal fade" id="sevkEmirleri" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Açık Sevkin Son 5 Siparişi <em class="icon ni ni-info"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Açık Sevk Emirleri"></em></h5>
                <a href="#" id="btn_mdl_musteriSec_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>TARİH</th>
                            <th>SİPARİŞ NO</th>
                            <th>MÜŞTERİ</th>
                            <th>DURUM</th>
                        </tr>
                    </thead>
                    <tbody id="siparis_icerikleri" style="margin-top:5px">
                       
                                
                    </tbody>
                </table>
            </div>
            <div class="modal-footer d-flex justify-content-between align-items-center">
                <input type="hidden" id="sevk_id">
    <div style="flex:1">
        <select class="form-select form-select-lg js-select2 form-control" id="new_sevk_status" data-placeholder="Seçiniz">
            <option></option>
            <option value="sevk_edildi">Sevk Edildi</option>
            <option value="failed">İptal Edildi</option>
            <option value="teknik_hata">Teknik Hata</option>
            <option value="stokta_yok">Stokta Yok</option>
            <option value="kargo_bekliyor">Kargo Bekliyor</option>
        </select>
    </div>
    <div class="text-end">
        <button  id="sevkStatusDegis" class="btn btn-primary">( <div style="margin-left:3px; margin-right:3px;" id="toplamSiparis"></div> SİPARİŞİ ) Güncelle</button>
        <a href="" id="yonlendirSevk" class="btn  btn-secondary">Detaylı Güncelle</a>
    </div>
</div>
        </div>
    </div>
</div>


<div class="modal fade" id="irsaliyeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seçili Siparişler</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#bekleyen">Bekleyen</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#hazirlanan">Hazırlanan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tamamlanan">Tamamlanan</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="bekleyen">
                                <div class="bekleyen-list mt-3"></div>
                            </div>
                            <div class="tab-pane" id="hazirlanan">
                                <div class="hazirlanan-list mt-3"></div>
                            </div>
                            <div class="tab-pane" id="tamamlanan">
                                <div class="tamamlanan-list mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" id="irsaliyeOlustur">İrsaliye Oluştur</button>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>

<?= $this->section('script') ?>


<script>

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

// Modal açıldığında select2 initialize ediliyor
$('#sevkEmirleri').on('shown.bs.modal', function () {
    $(".js-select2").select2({
        dropdownParent: $('#sevkEmirleri') // Dropdown menüsünün modal içinde kalmasını sağlar
    });
});

$(document).ready(function() {





var search_text = localStorage.getItem('datatableStock_filter_search');
var category = localStorage.getItem('datatableStock_filter_categoryId');
var type = localStorage.getItem('datatableStock_filter_typeId');

console.log("search_text", search_text);
console.log("category", category);
console.log("type", type);

if (search_text) {
    $('#notification-dot-search').removeClass('d-none');
    $('#stock_input_search').val(search_text);
}
if (category) {
    $('#notification-dot').removeClass('d-none');
    $('#category-filter-dropdown').val(category);
    $('#category-filter-dropdown').trigger('change');
}
if (type) {
    $('#notification-dot').removeClass('d-none');
    $('#type-filter-dropdown').val(type);
    $('#type-filter-dropdown').trigger('change');
}
});

// // Save the filtering state to local storage when the user navigates away from the page
// $(window).on('unload', function() {
//     localStorage.setItem('datatableStock_filter', $('#datatableStock_filter input').val());
// });

$(window).on('load', function() {
var filterValue = localStorage.getItem('datatableStock_filter');
if (filterValue) {
    $('#datatableStock_filter input').val(filterValue).keyup();
}
});
   $(document).ready(function() {
    var base_url = window.location.origin;
    var url = window.location.pathname;
    var parts = url.split('/');
    var lastPart = parts[parts.length - 1];

    var table = NioApp.DataTable('#datatableStock', {
        processing: true,
        serverSide: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Tümü"]
        ],
        ajax: {
            url: base_url + '/tportal/order/getOrderList/' + lastPart,
            data: function(d) {
                d.category_id = $('#category-filter-dropdown').find(':selected').val();
                d.type_id = $('#type-filter-dropdown').find(':selected').val();
            }
        },
        stateSave: true,
        stateDuration: 15,
        buttons: [
            'copy',
            'csv',
            'excel',
            {
                extend: 'print',
                text: 'Print all (not just selected)',
                exportOptions: {
                    modifier: {
                        selected: null
                    }
                }
            },
            {
                extend: 'pdf',
                text: 'pdf',
                exportOptions: {
                    modifier: {
                        selected: true
                    }
                }
            },
        ],
        columnDefs: [{
                className: "nk-tb-col",
                defaultContent: "-",
                targets: "_all"
            },
            {
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            },
        ],
        select: {
            style: 'os',
            selector: 'td:first-child',
            style: 'multi'
        },
        createdRow: (row, data, dataIndex, cells) => {
            $(row).addClass('nk-tb-item');
        <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19 ): ?>


            if(data.irsaliye != 0){
                $(row).css({
                    'background-color': '#E8F5E9',  // Açık yeşil arka plan
                    'position': 'relative',  // Pozisyon ayarı için
                    'border-left': '4px solid #4CAF50'  // Sol kenarda koyu yeşil şerit
                });
            }


            if(data.satir_toplam != 1){
    $(row).css({
        'background-color': '#FFEBEE',  // Daha belirgin pembe arka plan
        'position': 'relative'  // Pozisyon ayarı için
    });

    // Uyarı mesajını satırın içine ekleyelim
    setTimeout(() => {
    const warningDiv = $('<div>', {
        class: 'position-absolute start-0 top-0 px-2 py-1',
        style: `
            background-color: #D32F2F;
            color: white;
            width: 250px;
            font-size: 12px;
            border-radius: 0 0 4px 0;
            z-index: 100;
        `
    }).html(data.satir_toplam);  // text yerine html kullanıyoruz
    
    $(row).find('td:first').append(warningDiv);
}, 100);

    // Tüm işlem butonlarını devre dışı bırakalım
 
}
<?php endif; ?>


            <?php if(session()->get('user_id') != 1 || session()->get('user_id') != 19 ){

            }else{ ?>
            $(row).on('click', function() {
                // Burada 'data.id' örneğin veritabanından gelen bir ID olabilir. URL'yi kendi durumuna göre güncelle.
                window.location.href = '../detail/' + data.order_id;
                });
                <?php } ?>
        },
        columns: [{
                data: null,
                className: 'nk-tb-col',
                render: function(data, type, row) {
                    let disabled = 'disabled';
                    if(data.order_status === 'kargo_bekliyor' || data.order_status === 'sevk_edildi' || data.order_status === 'sevk_emri' || data.order_status === 'kargolandi') {
                        disabled = '';
                    }

                    <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19 ): ?>
                    if(data.satir_toplam != 1){
                        disabled = 'disabled';
                    }
                    if(data.irsaliye != 0){
                        disabled = 'disabled';
                    }
                    <?php endif; ?>

                    let action = '';
            

                    if (row.action !== '') {
                        disabled = 'disabled';
                    }

                    let statusText_input = "";
                   

                    if (row.order_status === 'new') {
                        statusText_input = "YENİ SİPARİŞ";
                       
                    } else if (row.order_status === 'pending') {
                        statusText_input = "BEKLİYOR";
                      
                    } else if (row.order_status === 'success') {
                        statusText_input = "TESLİM EDİLDİ";
                     
                    }  else if (row.order_status === 'sevk_emri') {
                        statusText_input = "SEVK EMRİ VERİLDİ";
                     
                    } else if (row.order_status === 'sevk_edildi') {
                        statusText_input = "SEVK EDİLDİ";
                      
                    }else if (row.order_status === 'failed') {
                        statusText_input = "İPTAL";
                    
                    }
                    else if (row.order_status === 'teknik_hata') {
                        statusText_input = "TEKNİK HATA";
                       
                    }
                    else if (row.order_status === 'stokta_yok') {
                        statusText_input = "STOKTA YOK";
                     
                    }
                    else if (row.order_status === 'kargolandi') {
                        statusText_input = "KARGOLANDI";
                       
                    }
                    else if (row.order_status === 'kargo_bekliyor') {
                        statusText_input = "KARGOLANMAYI BEKLİYOR";
                
                    }
                    else if (row.order_status === 'yetistirilemedi') {
                        statusText_input = "YETİŞTİRİLEMEDİ";
                       
                    }




                    return `
                    <div class="custom-control custom-control-sm custom-checkbox notext datatable-checkbox-container">
                        <input data-durum="${statusText_input}" type="checkbox" class="custom-control-input datatable-checkbox" data-id="${data.order_id}" data-stock-no="${data.order_id}" id="stockRow_${data.order_id}" ${disabled}>
                        <label class="custom-control-label datatable-checkbox-label" for="stockRow_${data.order_id}"></label>
                    </div>`;
                }
            },
            {
                data: 'order_date',
                className: 'nk-tb-col tb-col-lg',
                render: function(data, type, row) {

                    var datetime = new Date(row.order_date);

                    // Tarih ve saat bileşenlerini ayırma
                    var year = datetime.getFullYear();
                    var month = ("0" + (datetime.getMonth() + 1)).slice(-2); // Aylar 0-11 aralığında olduğu için 1 ekliyoruz ve 2 haneli yapıyoruz
                    var day = ("0" + datetime.getDate()).slice(-2); // Günü 2 haneli yapıyoruz

                    var hours = ("0" + datetime.getHours()).slice(-2); // Saati 2 haneli yapıyoruz
                    var minutes = ("0" + datetime.getMinutes()).slice(-2); // Dakikayı 2 haneli yapıyoruz
                    var seconds = ("0" + datetime.getSeconds()).slice(-2); // Saniyeyi 2 haneli yapıyoruz

                    // Tarih ve saat stringleri oluşturma
                    var dateStr = day + "/" + month + "/" + year;
                    var timeStr = hours + ":" + minutes + ":" + seconds;
                    return `
                    <div class="user-info">
                        <span class="tb-lead">${dateStr}</span>
                        <span>${timeStr}</span>
                    </div>`;
                }
            },
            <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19): ?>
            {
                data: "service_name",
                className: 'nk-tb-col',
                render: function(data, type, row) {

                    let img = '';
                    let kargo = row.kargo;
                    function baseUrl(path) {
                        return window.location.origin + '/' + path;
                    }

                        if (kargo === "Yurtiçi") {
                            img = '<img src="' + baseUrl("images/kargo/yurtici.png") + '" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        } else if (kargo === "Aras") {
                            img = '<img src="' + baseUrl("images/kargo/aras.png") + '" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        } else if (kargo === "Carrtell") {
                            img = '<img src="' + baseUrl("images/kargo/cartel.jpg") + '" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        } else if (kargo === "Gittigidiyor Express") {
                            img = '<img src="' + baseUrl("images/kargo/gittigidiyor.png") + '" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        }else if (kargo === "Trendyol Express") {
                            img = '<img src="' + baseUrl("images/kargo/trendyol_express.png") + '" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        } else if (kargo === "Jetizz") {
                            img = '<img src="' + baseUrl("images/kargo/jetiz.png") + '" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        } else if (kargo === "Kargokar") {
                            img = '<img src="' + baseUrl("images/kargo/kargokar.png") + '" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        } else if (kargo === "MNG Kargo") {
                            img = '<img src="' + baseUrl("images/kargo/mng.png") + '" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        } else if (kargo === "Murathan JET") {
                            img = '<img src="' + baseUrl("images/kargo/murat.png") + '" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        } else if (kargo === "Sürat") {
                            img = '<img src="' + baseUrl("images/kargo/surat.png") + '" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        } else if (kargo === "hepsiJet" || kargo === "HepsiJet" || kargo == "hepsiJET" || kargo == "HepsiJET") {
                            img = '<img src="' + baseUrl("images/kargo/hepsiJet.png") + '" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        } else if (kargo === "hepsiJET XL") {
                            img = '<img src="' + baseUrl("images/kargo/hepsiJET_XL.png") + '" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        } else if (kargo === "PTT Kargo" || kargo === "PTT" || kargo === "PTT Global" || kargo === "PTT Kargo Marketplace") {
                            img = '<img src="<?php echo base_url("uploads/ptt_kargo.png") ?>" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        }else if (kargo === "Sendeo") {
                            img = '<img src="' + baseUrl("images/kargo/sendeo.png") + '" style="height: auto; width:auto; max-width: 70px;" alt="logo">';
                        }else{
                            img = kargo;
                        }
                    return `
                    <div class="user-info">

                        <img style="height:40px;margin-right:10px" src="${row.service_logo}" >
                       ${img}

                    </div>`;
                }
            },
            <?php endif; ?>
            {
                data: 'order_no',
                className: 'nk-tb-col tb-col-md',
                render: function(data, type, row) {
                    
                    let orderNo = row.order_no;

// Remove the "DPG" prefix if it exists
orderNo = orderNo.replace(/^DPG/, '');
                    return `
                    <div class="user-info">
                        <span class="tb-lead">${orderNo}</span>
                        <span>${row.order_direction === 'incoming' ? 'Alınan Sipariş' : 'Verilen Sipariş'}</span>
                             
                    </div>`;
                }
            },

            {
                data: 'cari_invoice_title',
                className: 'nk-tb-col tb-col-md',
                render: function(data, type, row) {

                    let action = '';
                    let stok = '';
                    let kargo_sonuc = '';
                    let aktarim = '';

                    if (row.action !== '') {
                        action = `<span class="action-class">${row.action}</span><br>`;
                    }

                    if (row.stok !== '') {
                        stok = `<span class="stok-class"><span class="badge badge-dot bg-warning">Eksik Stok Var</span></span><br>`;
                    }
                    if (row.kargo_sonuc !== '') {
                        kargo_sonuc = `<span class="stok-class">${row.kargo_sonuc}</span><br>`;
                    }
                    if (row.aktarim !== '') {
                        aktarim = `<span class="stok-class">${row.aktarim}</span><br>`;
                    }
                    return `
                    <div class="user-info">
                        <span class="tb-lead">${row.cari_invoice_title}</span>

                        ${action}
                        ${stok}
                         <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19): ?>
                        ${kargo_sonuc}
                        <?php endif; ?>

                         <?php if(session()->get('user_id') == 5 || session()->get('user_id') == 16): ?>
                        ${aktarim}
                        <?php endif; ?>

                        

                             
                    </div>`;
                }
            },

       
            {
                data: 'amount_to_be_paid',
                className: 'nk-tb-col tb-col-md',
                render: function(data, type, row) {
        // Formatlama işlemi: 2 ondalıklı olarak sayıyı döndür
        let formattedAmount = parseFloat(row.amount_to_be_paid).toFixed(2);
        return `
            <span class="tb-amount">${formattedAmount} ${row.money_icon}</span>`;
    }
            },
            {
                data: 'order_status',
                className: 'nk-tb-col tb-col-md',
                render: function(data, type, row) {
                    let statusText = "";
                    let statusTextColor = "";

                    if (row.order_status === 'new') {
                        statusText = "YENİ SİPARİŞ";
                        statusTextColor = "text-primary";
                    } else if (row.order_status === 'pending') {
                        statusText = "BEKLİYOR";
                        statusTextColor = "text-warning";
                    } else if (row.order_status === 'success') {
                        statusText = "TESLİM EDİLDİ";
                        statusTextColor = "text-success";
                    }  else if (row.order_status === 'sevk_emri') {
                        statusText = "SEVK EMRİ VERİLDİ";
                        statusTextColor = "text-primary";
                    } else if (row.order_status === 'sevk_edildi') {
                        statusText = "SEVK EDİLDİ";
                        statusTextColor = "text-success";
                    }else if (row.order_status === 'failed') {
                        statusText = "İPTAL";
                        statusTextColor = "text-danger";
                    }
                    else if (row.order_status === 'teknik_hata') {
                        statusText = "TEKNİK HATA";
                        statusTextColor = "text-danger";
                    }
                    else if (row.order_status === 'stokta_yok') {
                        statusText = "STOKTA YOK";
                        statusTextColor = "text-danger";
                    }
                    else if (row.order_status === 'kargolandi') {
                        statusText = "KARGOLANDI";
                        statusTextColor = "text-success";
                    }
                    else if (row.order_status === 'kargo_bekliyor') {
                        statusText = "KARGOLANMAYI BEKLİYOR";
                        statusTextColor = "text-primary";
                    }
                    else if (row.order_status === 'yetistirilemedi') {
                        statusText = "YETİŞTİRİLEMEDİ";
                        statusTextColor = "text-danger";
                    }


                    var datetime = new Date(row.guncelleme ? row.guncelleme : row.updated_at);

// Tarih ve saat bileşenlerini ayırma
var year = datetime.getFullYear();
var month = ("0" + (datetime.getMonth() + 1)).slice(-2); // Aylar 0-11 aralığında olduğu için 1 ekliyoruz ve 2 haneli yapıyoruz
var day = ("0" + datetime.getDate()).slice(-2); // Günü 2 haneli yapıyoruz

var hours = ("0" + datetime.getHours()).slice(-2); // Saati 2 haneli yapıyoruz
var minutes = ("0" + datetime.getMinutes()).slice(-2); // Dakikayı 2 haneli yapıyoruz
var seconds = ("0" + datetime.getSeconds()).slice(-2); // Saniyeyi 2 haneli yapıyoruz

// Tarih ve saat stringleri oluşturma
var dateStr = day + "/" + month + "/" + year;
var timeStr = hours + ":" + minutes + ":" + seconds;

                    return `  
                 <div class="user-info">
                        <span class="tb-lead ${statusTextColor}">${statusText}</span>
                        <span>S.Gnc: ${dateStr} ${timeStr}</span>
                             
                    </div>
                 `;
                }
            },
            {
    data: null,
    className: 'nk-tb-col tb-col-md',
    render: function(data, type, row) {
        let kk_logo = '';

        if (data.kargo_kodu != '') {
            //kk_logo = `<a style="margin-right:10px" data-dopigo="${row.dopigo}" title="Kargo Kodunu Güncelle" class="urunGuncelle btn btn-round btn-icon btn-outline-danger"><em class="icon ni ni-reload-alt"></em></a>`;
            kk_logo = '';
        }

        let dopigoaction = '';

                    if (row.dopigo !== '') {
                        dopigoaction = `${row.dopigo}`;
                    }
        let irsaliye = '';
        let fatura = '';

        if(row.fatura != null && row.fatura > 3){
            fatura = `<a href="<?php echo base_url() ?>/tportal/invoice/detail/${row.fatura}" class="btn btn-round btn-icon btn-outline-light" style="margin-right:5px;"><em class="icon ni ni-report-profit"></em></a>`;
        }
        <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19): ?>
        if(row.irsaliye != 0){
            // row.irsaliye HTML içeriyor, direkt olarak kullanabiliriz
            irsaliye = row.irsaliye;
        } else {
            irsaliye = '<span class="badge badge-dot bg-danger"></span>';
        }
        <?php endif; ?>
        return `
        <div style="display:flex;">
        ${irsaliye}
        ${dopigoaction}
        ${fatura}
        <a href="../detail/${row.order_id}" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>

       
        </div>
        `;
    }
}
        ],
    });
    var table = $('#datatableStock').DataTable();

    function showLoading() {
        $('#datatableStock-loading').css('opacity', 1);
        $('#datatableStock-loading').fadeIn(200);
    }

    function hideLoading() {
        $('#datatableStock-loading').fadeOut(200);
        $('#datatableStock-loading').css('opacity', 0);
    }

    // Enter tuşuyla arama yapılınca
    $('#stock_input_search').on('keydown', function(e) {
        if (e.key === 'Enter') {
            var searchWord = $(this).val().toLocaleUpperCase('tr-TR');
            table.search(searchWord).draw();
            localStorage.setItem('datatableStock_filter_search', searchWord);
            $('#stock_input_search').val(searchWord);

            if (this.value.length > 0) {
                $('#notification-dot-search').removeClass('d-none');
            } else {
                $('#notification-dot-search').addClass('d-none');
            }

            showLoading(); // Loading başlat
        }
    });

// Temizleme butonuna basıldığında
    $('#stock_input_search_clear_button').on('click', function(e) {
        $('#notification-dot-search').addClass('d-none');
        $('#stock_input_search').val('');
        localStorage.removeItem('datatableStock_filter_search');
        table.state.clear();
        table.ajax.reload();
        table.search('').draw();
        showLoading(); // Loading başlat
    });

    // Tablo tamamen yüklendikten sonra loading gizlenir
    table.on('draw', function () {
        hideLoading();
    });




    $("#applyExport").on("click", function() {
        var sltd_value = $('#sltc_export').find(':selected').val();
        if (sltd_value == "toExcel") {
            table.button('.buttons-excel').trigger();
        } else if (sltd_value == "toPdf") {
            table.button('.buttons-pdf').trigger();
        } else if (sltd_value == "toPrint") {
            table.button('.buttons-print').trigger();
        }
    });

    $(document).ajaxComplete(function() {
        console.log("ajax bitti");
    });
    $('#row-10').on('click', function() {
        table.page.len(10).draw();
    });
    $('#row-25').on('click', function() {
        table.page.len(25).draw();
    });
    $('#row-50').on('click', function() {
        table.page.len(50).draw();
    });
    $('#row-100').on('click', function() {
        table.page.len(100).draw();
    });
    $('#row-200').on('click', function() {
        table.page.len(200).draw();
    });
    $('#row-1000').on('click', function() {
        table.page.len(1000).draw();
    });

    $('#selectAllStock').on('click', function() {
        var rows = $('#datatableStock').DataTable().rows().nodes();
        $('input[type="checkbox"]', rows).each(function() {
            if(!$(this).prop('disabled')) {
                $(this).prop('checked', $('#selectAllStock').prop('checked'));
            }
        });
        
    });

});

</script>

<script>


function getSelectedCheckboxValues() {
    var selectedItems = [];
    
    // Seçili olan checkbox'ları seç
    $('.datatable-checkbox:checked').not(':disabled').each(function() {
        // Her seçili checkbox için bir obje oluştur
        selectedItems.push({
            id: $(this).data('id'),
            durum: $(this).data('durum')
        });
    });
    return selectedItems;
}

    


$("#indirButton").click(function(){

var data = $(".toplu_islem").val();

if (data == "b2b") {

    Swal.fire({
        title: 'MSH B2B sitesindeki siparişlerinizi aktarmak istiyormusunuz?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Evet, Devam Et',
        cancelButtonText: 'Hayır',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
            title: 'Siparişleriniz çekiliyor lütfen sayfayı kapatmayınız!',
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading();
            },
        });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.api.msh') ?>',
                dataType: 'json',
                data: {
                    // You can pass any additional data here if needed
                },
                async: true,
                success: function (response) {
                    Swal.fire({
                        title: 'Başarılı!',
                        html: 'B2B Sipariş Portalından Siparişler Başarıyla Çekildi.', // Display the server error message
                        icon: 'success',
                        confirmButtonText: 'Tamam',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    });

                    setTimeout(() => {
                            location.reload(); // Reload the page after a delay
                        }, 2600);
                       

               
           
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: 'Başarılı!',
                        html: 'B2B Sipariş Portalından Siparişler Başarıyla Çekildi.', // Display the server error message
                        icon: 'success',
                        confirmButtonText: 'Tamam',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    });

                    setTimeout(() => {
                            location.reload(); // Reload the page after a delay
                        }, 2600);

                }
            });

        } else {
            // Handle if the user clicks Cancel
        }
    });
}


if (data == "b2b3d") {

Swal.fire({
    title: 'Sistem3D B2B sitesindeki siparişlerinizi aktarmak istiyormusunuz?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, Devam Et',
    cancelButtonText: 'Hayır',
}).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
        title: 'Siparişleriniz çekiliyor lütfen sayfayı kapatmayınız!',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
    });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.api.siparisleriGetir') ?>',
            dataType: 'json',
            data: {
                // You can pass any additional data here if needed
            },
            async: true,
            success: function (response) {
                Swal.fire({
                    title: 'Başarılı!',
                    html: 'B2B Sipariş Portalından Siparişler Başarıyla Çekildi.', // Display the server error message
                    icon: 'success',
                    confirmButtonText: 'Tamam',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                });

                setTimeout(() => {
                        location.reload(); // Reload the page after a delay
                    }, 2600);
                   

           
       
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    title: 'Başarılı!',
                    html: 'B2B Sipariş Portalından Siparişler Başarıyla Çekildi.', // Display the server error message
                    icon: 'success',
                    confirmButtonText: 'Tamam',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                });

                setTimeout(() => {
                        location.reload(); // Reload the page after a delay
                    }, 2600);

            }
        });

    } else {
        // Handle if the user clicks Cancel
    }
});
}



if (data == "b2bartliving") {

Swal.fire({
    title: 'Artliving B2B sitesindeki siparişlerinizi aktarmak istiyormusunuz?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, Devam Et',
    cancelButtonText: 'Hayır',
}).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
        title: 'Siparişleriniz çekiliyor lütfen sayfayı kapatmayınız!',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
    });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.api.siparisleriGetir_art') ?>',
            dataType: 'json',
            data: {
                // You can pass any additional data here if needed
            },
            async: true,
            success: function (response) {
                Swal.fire({
                    title: 'Başarılı!',
                    html: 'B2B Sipariş Portalından Siparişler Başarıyla Çekildi.', // Display the server error message
                    icon: 'success',
                    confirmButtonText: 'Tamam',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                });

                setTimeout(() => {
                        location.reload(); // Reload the page after a delay
                    }, 2600);
                   

           
       
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    title: 'Başarılı!',
                    html: 'B2B Sipariş Portalından Siparişler Başarıyla Çekildi.', // Display the server error message
                    icon: 'success',
                    confirmButtonText: 'Tamam',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                });

                setTimeout(() => {
                        location.reload(); // Reload the page after a delay
                    }, 2600);

            }
        });

    } else {
        // Handle if the user clicks Cancel
    }
});
}


$("#sevkStatusDegis").click(function(){

    Swal.fire({
    title: 'Sevk emrine ait siparişlerin durumları toplu olarak değiştirilsin mi?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, Devam Et',
    cancelButtonText: 'Hayır',
}).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
        title: 'Sevkiyat emiri  durumları değiştiriliyor lütfen sayfayı kapatmayınız!',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
    });


    var  sevk_id = $("#sevk_id").val();
         new_sevk_status = $("#new_sevk_status").val();

 

    $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= route_to('tportal.siparisler.sevkGuncelle') ?>',
                    dataType: 'json',
                    data: {
                        sevk_id: sevk_id,
                        new_sevk_status:new_sevk_status                   
                    },
                    async: true,
                    success: function (response) {
                        if (response['icon'] == 'success') {
                            Swal.fire({
                                title: 'Başarılı!',
                                html: 'Sevkiyat Emri Başarıyla Kapatıldı. Yeni Sevk Emiri Oluşturabilirsiniz.',
                                icon: 'success',
                                confirmButtonText: 'Tamam',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                            });

                            setTimeout(() => {
                                location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                            }, 2600);
                        }

                        if (response['icon'] == 'error') {
                            Swal.fire({
                                title: 'Bilgilendirme!',
                                html: response['message'],
                                icon: 'error',
                                confirmButtonText: 'Sevk Emiri Kapatılırken Bir Hata Oluştu',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                            });

                          
                        }

                    }
                });



    } else {
        // Handle if the user clicks Cancel
    }
});


});





function checkSelectedStatuses(selectedItems, allowedStatuses, callback) {
    // Uygun olmayan durumları filtrele
    const invalidItems = selectedItems.filter(item => !allowedStatuses.includes(item.durum));
    
    // Uygun olan durumları filtrele
    const validItems = selectedItems.filter(item => allowedStatuses.includes(item.durum));
    
    if (invalidItems.length > 0) {
        // Uygun olmayan durumları grupla ve say
        const invalidStatusCounts = invalidItems.reduce((acc, item) => {
            acc[item.durum] = (acc[item.durum] || 0) + 1;
            return acc;
        }, {});
        
        // Hata mesajını oluştur
        let errorMsg = 'Aşağıdaki durumlar bu işlem için uygun değil:<br><br>';
        Object.keys(invalidStatusCounts).forEach(durum => {
            errorMsg += `<b>${durum}</b>: ${invalidStatusCounts[durum]} adet<br>`;
        });
        
        // Uyarı göster
        Swal.fire({
            title: 'Uygun Olmayan Durumlar',
            html: errorMsg,
            icon: 'warning',
            confirmButtonText: 'Tamam'
        }).then(() => {
            // Uygun olmayan checkboxları temizle
            invalidItems.forEach(item => {
                $(`#stockRow_${item.id}`).prop('checked', false);
            });
            
            // Kalan uygun durumları göster
            if (validItems.length > 0) {
                const validStatusCounts = validItems.reduce((acc, item) => {
                    acc[item.durum] = (acc[item.durum] || 0) + 1;
                    return acc;
                }, {});
                
                let validMsg = 'İşleme devam edilecek siparişler:<br><br>';
                Object.keys(validStatusCounts).forEach(durum => {
                    validMsg += `<b>${durum}</b>: ${validStatusCounts[durum]} adet<br>`;
                });
                
                Swal.fire({
                    title: 'Devam Edilecek Siparişler',
                    html: validMsg,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Devam Et',
                    cancelButtonText: 'İptal'
                }).then((result) => {
                    if (result.isConfirmed && callback) {
                        callback(validItems); // Devam et tıklanırsa callback'i çağır
                    }
                });
            }
        });
        
        return false;
    }
    
    if (callback) {
        callback(selectedItems); // Hepsi uygunsa direkt callback'i çağır
    }
    return true;
}


if (data == "sevk_emri") {
    var selectedItems = getSelectedCheckboxValues();

// İzin verilen durumları tanımla
    const allowedStatuses = ['KARGOLANMAYI BEKLİYOR'];





    // Durumları kontrol et
    checkSelectedStatuses(selectedItems, allowedStatuses, function(validItems) {


        var selectedValues = validItems.map(item => item.id);
       
    // Önce stok kontrolü yap
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.siparisler.stokKontrol') ?>',
        dataType: 'json',
        data: {
            order_id: selectedValues                    
        },
        success: function(response) {
            if(response.eksikStok) {
                // Eksik stok varsa tablo ile göster
                let stokTablosu = `
                    <div class="modal-dialog modal-lg" style="max-width: 800px !important; width: 800px !important;    margin-bottom: -15px!important;">
                        <div class="modal-content">
                            <div class="modal-header bg-warning">
                                <h5 class="modal-title text-white">Dikkat! Eksik Stok Tespit Edildi</h5>
                            </div>
                            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="sticky-top bg-light">
                                            <tr>
                                                <th>Stok Kodu</th>
                                                <th>Ürün</th>
                                                <th>Mevcut Stok</th>
                                                <th>Sipariş Edilen</th>
                                                <th>Durum</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
    
    response.stokDurum.forEach(function(item) {
        let durumBadge = item.durum === "warning" ? 
            `<span class="badge badge-dot bg-danger">Eksik (${item.eksik_miktar})</span>` : 
            `<span class="badge badge-dot bg-success">Yeterli</span>`;
            let mevcutStokta = parseFloat(item.mevcutStokta).toFixed(2);
            let siparis_edilen = parseFloat(item.siparis_edilen).toFixed(2);
        stokTablosu += `
            <tr>
                <td><b>${item.stock_code}</b></td>
                <td><b>${item.stock_title}</b></td>
                <td>${mevcutStokta}</td>
                <td>${siparis_edilen}</td>
                <td>${durumBadge}</td>
            </tr>`;
    });
    
    stokTablosu += `
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">İptal</button>
                    <button type="button" class="btn btn-primary" id="devamEtButton">
                        Yine de Devam Et
                    </button>
                </div>
            </div>
        </div>`;

        // Global değişkenleri güncelle
        globalStokDurum = response.stokDurum;
        globalSelectedValues = selectedValues;
        setTimeout(() => {
            function sevkiyatEmirleriOlustur(selectedValues) {
    Swal.fire({
        title: 'Sevkiyat emiri oluşturuluyor lütfen sayfayı kapatmayınız!',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
    });

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.siparisler.sevkEmirleri') ?>',
        dataType: 'json',
        data: {
            order_id: selectedValues                    
        },
        async: true,
        success: function (response) {
            if (response['icon'] == 'success') {
                Swal.fire({
                    title: 'Başarılı!',
                    html: 'Sevkiyat Emri Başarıyla Oluşturuldu.',
                    icon: 'success',
                    confirmButtonText: 'Tamam',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                });

                setTimeout(() => {
                    location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                }, 2600);
            }

            if (response['icon'] == 'error') {
                Swal.fire({
                    title: 'Bilgilendirme!',
                    html: response['message'],
                    icon: 'error',
                    confirmButtonText: 'Kapat',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                });

              
            }

            $("#siparis_icerikleri").html('');

            if (response['icon'] == 'acik') {
                Swal.fire({
                    title: 'Bilgilendirme!',
                    html: '<b>'+ response['message'] + "</b>",
                    icon: 'info',
                    confirmButtonText: 'Açık Sevk Emrini Görüntüle',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#yonlendirSevk").attr("href", response["link"]);

                        // Modalı açmak için gereken kodu buraya ekleyin
                        $('#sevkEmirleri').modal('show');  // Örneğin, Bootstrap modal kullanıyorsanız bu şekilde açabilirsiniz
                       setTimeout(() => {
                        $(".js-select2").select2();
                       }, 100);
                       $("#toplamSiparis").html(response["toplamSiparis"]);
                       $("#sevk_id").val(response["sevk_id"]);
                        $("#siparis_icerikleri").html(response['html']);
                    }
                });

              
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                title: 'Başarılı!',
                html: 'Sevkiyat Emri Başarıyla Oluşturuldu.',
                icon: 'success',
                confirmButtonText: 'Tamam',
                allowEscapeKey: false,
                allowOutsideClick: false,
            });

            setTimeout(() => {
                location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
            }, 2600);
        }
    });
}
            window.stokWhatsappMesajGonders = function(selectedValues, stokDurum) {
       
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.siparisler.stokWhatsappMesaj') ?>',
            dataType: 'json',
            data: {
                stokDurum: stokDurum
            },
            success: function(response) {
                if(response.success) {
                    sevkiyatEmirleriOlustur(selectedValues);
                } else {
                    Swal.fire({
                        title: 'Hata!',
                        text: 'WhatsApp mesajı gönderilemedi!',
                        icon: 'error'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Hata!',
                    text: 'WhatsApp mesajı gönderilirken bir hata oluştu!',
                    icon: 'error'
                });
            }
        });
       
    }
                $('#devamEtButton').on('click', function() {
                   
                    if (globalStokDurum && globalSelectedValues) {
                        stokWhatsappMesajGonders(globalSelectedValues, globalStokDurum);
                        Swal.close(); // Modal'ı kapat
                    } else {
                        console.error("Gerekli veriler bulunamadı");
                    }
                });
              }, 400);
        Swal.fire({
            html: stokTablosu,
            showConfirmButton: false,
            showCancelButton: false,
            width: '800px',
            padding: '0',
            customClass: {
                container: 'stok-kontrol-modal'
            },
            didOpen: () => {
                // Modal açıldığında butona event listener ekle
           
            }
        });
            } else {
                function sevkiyatEmirleriOlustur(selectedValues) {
    Swal.fire({
        title: 'Sevkiyat emiri oluşturuluyor lütfen sayfayı kapatmayınız!',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
    });

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.siparisler.sevkEmirleri') ?>',
        dataType: 'json',
        data: {
            order_id: selectedValues                    
        },
        async: true,
        success: function (response) {
            if (response['icon'] == 'success') {
                Swal.fire({
                    title: 'Başarılı!',
                    html: 'Sevkiyat Emri Başarıyla Oluşturuldu.',
                    icon: 'success',
                    confirmButtonText: 'Tamam',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                });

                setTimeout(() => {
                    location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                }, 2600);
            }

            if (response['icon'] == 'error') {
                Swal.fire({
                    title: 'Bilgilendirme!',
                    html: response['message'],
                    icon: 'error',
                    confirmButtonText: 'Kapat',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                });

              
            }

            $("#siparis_icerikleri").html('');

            if (response['icon'] == 'acik') {
                Swal.fire({
                    title: 'Bilgilendirme!',
                    html: '<b>'+ response['message'] + "</b>",
                    icon: 'info',
                    confirmButtonText: 'Açık Sevk Emrini Görüntüle',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#yonlendirSevk").attr("href", response["link"]);

                        // Modalı açmak için gereken kodu buraya ekleyin
                        $('#sevkEmirleri').modal('show');  // Örneğin, Bootstrap modal kullanıyorsanız bu şekilde açabilirsiniz
                       setTimeout(() => {
                        $(".js-select2").select2();
                       }, 100);
                       $("#toplamSiparis").html(response["toplamSiparis"]);
                       $("#sevk_id").val(response["sevk_id"]);
                        $("#siparis_icerikleri").html(response['html']);
                    }
                });

              
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                title: 'Başarılı!',
                html: 'Sevkiyat Emri Başarıyla Oluşturuldu.',
                icon: 'success',
                confirmButtonText: 'Tamam',
                allowEscapeKey: false,
                allowOutsideClick: false,
            });

            setTimeout(() => {
                location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
            }, 2600);
        }
    });
}
                sevkiyatEmirleriOlustur(selectedValues);
            }
        }
    });

    

    });


    

    
}



if (data == "sysmond_irsaliye") {
    var selectedItems = getSelectedCheckboxValues();
    const allowedStatuses = ['SEVK EMRİ VERİLDİ', 'SEVK EDİLDİ'];

    checkSelectedStatuses(selectedItems, allowedStatuses, function(validItems) {
        Swal.fire({
            title: 'İrsaliye Oluştur',
            html: "Seçili olan siparişler için irsaliye oluşturmak istiyormusunuz? <br><br> <b>Seçili Siparişler: "+validItems.length+" Adet Sipariş Seçildi</b>",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Evet, Oluştur',
            cancelButtonText: 'Hayır',
        }).then((result) => {
            if (result.isConfirmed) {
                // İrsaliye oluşturma işlemine devam et...
                var orderIds = validItems.map(item => item.id);
                window.location.href = window.location.origin + '/tportal/siparisler/irsaliye?order_ids=' + orderIds.join(',');
            }
        });
    });
}


if (data == "fabrika_aktar") {

Swal.fire({
    title: 'Seçili olan siparişler için planlamaya aktarmak istiyormusunuz?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, Aktar',
    cancelButtonText: 'Hayır',
}).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
        title: 'Siparişleriniz aktarılıyor lütfen sayfayı kapatmayınız!',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
    });


    var selectedValues = getSelectedCheckboxValues();

 

    $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= route_to('tportal.siparisler.fabrika_aktar') ?>',
                    dataType: 'json',
                    data: {
                        order_id: selectedValues                    
                    },
                    async: true,
                    success: function (response) {
                        if (response['icon'] == 'success') {
                            Swal.fire({
                                title: 'Başarılı!',
                                html: 'Siparişler Başarıyla Aktarıldı!',
                                icon: 'success',
                                confirmButtonText: 'Tamam',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                            });

                            setTimeout(() => {
                                location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                            }, 2600);
                        }

                        if (response['icon'] == 'error') {
                            Swal.fire({
                                title: 'Bilgilendirme!',
                                html: response['message'],
                                icon: 'error',
                                confirmButtonText: 'Kapat',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                            });

                          
                        }

                        $("#siparis_icerikleri").html('');

                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Başarılı!',
                            html: 'Siparişler Başarıyla Aktarıldı!',
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(() => {
                            location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                        }, 2600);
                    }
                });



    } else {
        // Handle if the user clicks Cancel
    }
});
}


if (data == "dopigo") {

Swal.fire({
    title: 'Fams DOPİGO sitesindeki siparişlerinizi aktarmak istiyormusunuz?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, Devam Et',
    cancelButtonText: 'Hayır',
}).then((result) => {
    if (result.isConfirmed) {

        <?php
            // Select etiketini PHP tarafında oluşturuyoruz
            $selectHtml  = '<label for="pazar_yeri">Pazar Yeri:</label>';
            $selectHtml .= '<select name="pazar_yeri" id="pazar_yeri" class="swal2-input">';
            $selectHtml .= '<option value="1" selected>Tüm Platformlar</option>';
            foreach ($platformlarliste as $platform) {
                $serviceName = $platform["service_name"];
                $selectHtml .= '<option value="'.$serviceName.'" style="text-transform:uppercase">'.$serviceName.'</option>';
            }
            
            $selectHtml .= '</select>';
        ?>
        
   

        // Tarih aralığı almak için input alanları ekle
        Swal.fire({
            title: 'Tarih  Seçin',
            html:
                '<label for="start_date">Tarih Seçin:</label>' +
                '<input type="date" value="<?php echo Date("Y-m-d"); ?>" id="start_date" class="swal2-input" />' +
                '<?php echo $selectHtml; ?>',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Siparişleri Çek',
            cancelButtonText: 'İptal',
            preConfirm: () => {
                const startDate = Swal.getPopup().querySelector('#start_date').value;
                const endDate = Swal.getPopup().querySelector('#start_date').value;
                const pazarYeri = Swal.getPopup().querySelector('#pazar_yeri').value;

                if (!startDate || !endDate) {
                    Swal.showValidationMessage('Lütfen geçerli bir tarih aralığı girin');
                    return false;
                }
                return { startDate: startDate, endDate: endDate,  pazarYeri: pazarYeri };
            }
        }).then((dateResult) => {
            if (dateResult.isConfirmed) {
                
                Swal.fire({
                    title: 'Siparişleriniz çekiliyor lütfen sayfayı kapatmayınız!',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    },
                });

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= route_to('tportal.api.dopigo') ?>',
                    dataType: 'json',
                    data: {
                        start_date: dateResult.value.startDate,
                        end_date: dateResult.value.endDate,
                        pazar_yeri: dateResult.value.pazarYeri
                        // Gerekirse buraya ek veri ekleyebilirsiniz
                    },
                    async: true,
                    success: function (response) {
                        Swal.fire({
                            title: 'Başarılı!',
                            html: 'DOPİGO Sipariş Portalından Siparişler Başarıyla Çekildi.',
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(() => {
                            location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                        }, 2600);
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Başarılı!',
                            html: 'DOPİGO Sipariş Portalından Siparişler Başarıyla Çekildi.',
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(() => {
                            location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                        }, 2600);
                    }
                });

            } else {
                // Kullanıcı Cancel butonuna tıklarsa yapılacak işlemler
            }
        });
    }
});
}





});



$(document).ready(function() {
    var table = $('#datatableStock').DataTable();

    
    // Filter by status when dropdown changes
   /* $('.durumaGore').on('change', function() {
        var selectedStatus = $(this).val();

        if (selectedStatus === '0') {
            // If 'Hepsi' is selected, clear the filter and show all rows
            table.column(6).search('').draw(); // 6 is the index of the 'order_status' column
        } else {
            // Apply the filter to the order_status column
            table.column(6).search(selectedStatus).draw();
        }
    }); */



    // Filter by status when dropdown changes
    $('.serviceSecme').on('click', function() {
       

// Yükleniyor SweetAlert'ini göster ve 1.5 saniye bekle
Swal.fire({
    title: 'Yükleniyor...',
    allowOutsideClick: false, // Dışarıya tıklayarak kapatmayı engelle
    onBeforeOpen: () => {
        Swal.showLoading(); // Yükleniyor animasyonunu göster
        setTimeout(() => {
            Swal.close(); // 1.5 saniye sonra SweetAlert'i kapat

            var selectedStatus = $(this).attr("data-service");

            if (selectedStatus === '0') {
                // Eğer 'Hepsi' seçildiyse, filtreyi temizle ve tüm satırları göster
                table.column(2).search('').draw(); 
            } else {
                // order_status sütununa filtre uygula
                table.column(2).search(selectedStatus).draw();
            }

            // Bugünün tarihi için tarih filtrelemesi yap
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); // Ocak 0 olarak kabul ediliyor
            var yyyy = today.getFullYear();
            
            var formattedToday = yyyy + '-' + mm + '-' + dd;

            var base_url = window.location.origin;
            var url = window.location.pathname;
            var parts = url.split('/');
            var lastPart = parts[parts.length - 1];

            var startDate = $('#report_date_start').val();
            var endDate = $('#report_date_end').val();

            function validateDateRange(startDate, endDate) {
        if (!startDate || !endDate) {
            return true; // Eğer tarihler boşsa geçerli olarak kabul et
        }
        
        var start = new Date(startDate.split('/').reverse().join('-'));
        var end = new Date(endDate.split('/').reverse().join('-'));

        return end >= start;
    }

            // Tarih aralığı geçerli mi kontrol et
            if (validateDateRange(startDate, endDate)) {
                // Eğer geçerli ise, filtreyi uygula
                table.ajax.url(base_url + '/tportal/order/getOrderList/' + lastPart + '?start_date=' + startDate + '&end_date=' + endDate).load();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Geçersiz Tarih Aralığı',
                    text: 'Bitiş tarihi, başlangıç tarihinden önce olamaz!',
                    confirmButtonText: 'Tamam'
                });
            }

        }, 1000); // 1.5 saniye
    }

});
});
});

$('.toplu_islem').on('change', function() {
                // Seçilen değeri al
                var selectedValue = $(this).val();

                // Eğer seçilen değer boşsa butonu devre dışı bırak
                if (selectedValue == '#') {
                    $("#indirButton").addClass("disabled");
                    $("#indirButton").prop("href", "#");
                    return;
                }

                // Butonu etkinleştir
                $("#indirButton").removeClass("disabled");

                // href özniteliğini güncelle
                $('#indirButton').attr('href', selectedValue);
            });
            $(document).ready(function() {
    // Initialize your DataTable
    var table = $('#datatableStock').DataTable();

    


      // "Filtreyi Uygula" butonuna tıklama olayı
      $('#applyFilters').on('click', function() {
    var base_url = window.location.origin;
    var url = window.location.pathname;
    var parts = url.split('/');
    var lastPart = parts[parts.length - 1];

    var startDate = $('#report_date_start').val();
    var endDate = $('#report_date_end').val();

    var selectedStatus = $("#durumaGore").val();  // Durum seçimini al
    var selectedPlatform = $("#platformSec").val();  // Platform seçimini al
    
    if (validateDateRange(startDate, endDate)) {
        // Geçerli tarih aralığı ise filtreleri uygula
        var ajaxUrl = base_url + '/tportal/order/getOrderList/' + lastPart + 
                      '?start_date=' + startDate + 
                      '&end_date=' + endDate + 
                      '&status=' + selectedStatus + 
                      '&platform=' + selectedPlatform;

        table.ajax.url(ajaxUrl).load();
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Geçersiz Tarih Aralığı',
            text: 'Bitiş tarihi, başlangıç tarihinden önce olamaz!',
            confirmButtonText: 'Tamam'
        });
    }
});

    // "Filtreyi Temizle" butonuna tıklama olayı
    $('#clearFilters').on('click', function() {
        var base_url = window.location.origin;
    var url = window.location.pathname;
    var parts = url.split('/');
    var lastPart = parts[parts.length - 1];
        // Tarih girişlerini temizle
        $('#report_date_start').val('<?php echo Date("d/m/Y"); ?>');
        $('#report_date_end').val('<?php echo Date("d/m/Y"); ?>');

        // Filtreleri sıfırla ve DataTable'ı yeniden yükle
        table.ajax.url(base_url + '/tportal/order/getOrderList/' + lastPart).load();
    });

    // Tarih aralığını kontrol eden fonksiyon
    function validateDateRange(startDate, endDate) {
        if (!startDate || !endDate) {
            return true; // Eğer tarihler boşsa geçerli olarak kabul et
        }
        
        var start = new Date(startDate.split('/').reverse().join('-'));
        var end = new Date(endDate.split('/').reverse().join('-'));

        return end >= start;
    }


});

$(document).on('click', '.urunGuncelle', function() {
    var dopigo = $(this).attr("data-dopigo");
    
    Swal.fire({
    title: 'Siparişi Güncellemek İstiyormusunuz?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, Dopigoya Göre Güncelle',
    cancelButtonText: 'Hayır',
}).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
        title: 'Sipariş Dopigoya Göre Güncelleniyor. Lütfen Sayfayı Kapatmayınız..',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
    });

 

    $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= route_to('tportal.api.DopigoOrderSingle') ?>',
                    dataType: 'json',
                    data: {
                        dopigo: dopigo                    
                    },
                    async: true,
                    success: function (response) {
                       
                        console.log(response);

                       
                    }
                });



    } else {
        // Handle if the user clicks Cancel
    }
});


});



$(document).on('click', '.siparisTekli', function () {
    // Tıklanan butondan sipariş ID'sini al
    const orderId = $(this).data('dopigo_siparis_id');
    const invoice_title = $(this).data('invoice_title');
    let siparis_no = $(this).data('siparis_no');
    let order_id = $(this).data('order_id');

    siparis_no = siparis_no.replace(/^DPG/, '');
    

   
    Swal.fire({
   
    icon: 'warning',
    html: "<h5 style='font-weight:normal'><b style='text-transform:uppercase; color: #014ad0'>" + invoice_title + " </b> müşterisine ait <b style='text-transform:uppercase; color: #014ad0'>"+ siparis_no + " </b>  numaralı siparişi güncellemek istiyormusunuz? </h5>",
    showCancelButton: true,
    confirmButtonText: 'Evet, Güncelle',
    cancelButtonText: 'Hayır',
}).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
        title: 'Sipariş güncelleniyor lütfen sayfayı kapatmayınız!',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
    });



 

    $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?= base_url('tportal/api/dopigo/order/') ?>' + orderId,
                    dataType: 'json',
                    data: { orderId: orderId  },
                    async: true,
                    success: function (response) {
                        if (response['icon'] == 'success') {
                            Swal.fire({
                                title: 'Başarılı!',
                                html: 'Sipariş Başarıyla Güncellendi!',
                                icon: 'success',
                                confirmButtonText: 'Tamam',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                            });

                            setTimeout(() => {
                                window.location.href='<?= base_url('tportal/order/detail/') ?>' + order_id;
                            }, 1600);
                        }

                        if (response['icon'] == 'error') {
                            Swal.fire({
                                title: 'Bilgilendirme!',
                                html: response['message'],
                                icon: 'error',
                                confirmButtonText: 'Kapat',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                            });

                          
                        }

                        $("#siparis_icerikleri").html('');

                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Başarılı!',
                            html: 'Siparişler Başarıyla Aktarıldı!',
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(() => {
                            location.reload(); // Sayfayı belirli bir süre sonra yeniden yükle
                        }, 2600);
                    }
                });



    } else {
        // Handle if the user clicks Cancel
    }
});


});




</script>

<?= $this->endSection() ?>

<script>

// Global değişkenler
var globalStokDurum = null;
var globalSelectedValues = null;

$(document).ready(function() {
    // Mevcut document.ready kodları devam ediyor...

    // handleDevamEt fonksiyonunu global scope'a taşıyoruz
    window.handleDevamEt = function() {
        if (globalStokDurum && globalSelectedValues) {
            stokWhatsappMesajGonder(globalSelectedValues, globalStokDurum);
        } else {
            console.error("Gerekli veriler bulunamadı");
        }
    }

    // stokWhatsappMesajGonder fonksiyonunu da buraya taşıyoruz
    window.stokWhatsappMesajGonder = function(selectedValues, stokDurum) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.siparisler.stokWhatsappMesaj') ?>',
            dataType: 'json',
            data: {
                stokDurum: stokDurum
            },
            success: function(response) {
                if(response.success) {
                    sevkiyatEmirleriOlustur(selectedValues);
                } else {
                    Swal.fire({
                        title: 'Hata!',
                        text: 'WhatsApp mesajı gönderilemedi!',
                        icon: 'error'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Hata!',
                    text: 'WhatsApp mesajı gönderilirken bir hata oluştu!',
                    icon: 'error'
                });
            }
        });
    }

    // Stok kontrolü yapıldığında global değişkenleri güncelle
    if (data == "sevk_emri") {
        var selectedValues = getSelectedCheckboxValues();
        $.ajax({
            // ... mevcut ajax kodu ...
            success: function(response) {
                if(response.eksikStok) {
                    // Global değişkenleri güncelle
                    globalStokDurum = response.stokDurum;
                    globalSelectedValues = selectedValues;
                    // ... geri kalan kod ...
                }
            }
        });
    }
});
</script>