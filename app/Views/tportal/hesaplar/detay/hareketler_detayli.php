
<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Hesap Detaylı Hareketler <?= $this->endSection() ?>
<?= $this->section('title') ?> Hesap  Detaylı Hareketler | ENPARA ŞİRKETİM <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>


<div class="nk-content nk-content-fluid">
  <div class="container-xl wide-xl">
      <div class="nk-content-body">
          <div class="nk-block-head nk-block-head-sm">
              <div class="nk-block-between">
                  <div class="nk-block-head-content">
                      <h3 class="nk-block-title page-title">Tüm Hesaplar</h3>
                     
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
          <div class="nk-block">
              <div class="card card-stretch">
                  <div class="card-inner-group">
                      <div class="card-inner position-relative card-tools-toggle">
                          <div class="card-title-group">
                              <div class="card-tools">
                                  <div class="form-inline flex-nowrap gx-3">
                                      <div class="form-wrap w-150px">
                                          <select class="form-select js-select2" data-search="off" data-placeholder="Toplu İşlem">
                                              <option value="">Toplu İşlem</option>
                                              <option value="#">İndir (Excel)</option>
                                              <option value="#">İndir (PDF)</option>
                                              <option value="#">Yazdır</option>
                                              <option value="#">Seçilenleri Sil</option>
                                          </select>
                                      </div>
                                      <div class="btn-wrap">
                                          <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light disabled">Uygula</button></span>
                                          <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                      </div>

                            <div class="form-wrap d-md-block">
                            <div class="form-group">    
                                <div class="form-control-wrap">        
                                    <div class="input-daterange date-picker-range input-group">            
                                        <input type="text" class="form-control  form-control" data-date-format="dd/mm/yyyy" style="max-width: 150px;" />            
                                        <div class="input-group-addon">İLE</div>            
                                        <input type="text" class="form-control  form-control" data-date-format="dd/mm/yyyy" style="max-width: 150px;" />        
                                    </div>    
                                </div>
                            </div>
</div>
                            <div class="btn-wrap">
                                <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light">Bul</button></span>
                                <!-- <span class="d-md-none"><button class="btn btn-dim btn-xl btn-outline-light">Müşteri Arama</button></span> -->
                            </div>
                                  </div><!-- .form-inline -->
                                  
                              </div><!-- .card-tools -->
                              <div class="card-tools me-n1">
                                  <ul class="btn-toolbar gx-1">
                                      <li>
                                          <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                                      </li><!-- li -->
                                      <li class="btn-toolbar-sep"></li><!-- li -->
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
                                                              <a href="#" class="btn btn-trigger btn-icon dropdown-toggle d-none" data-bs-toggle="dropdown">
                                                                  <div class="dot dot-primary"></div>
                                                                  <em class="icon ni ni-filter-alt"></em>
                                                              </a>
                                                              <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                                  <div class="dropdown-head">
                                                                      <span class="sub-title dropdown-title">Detaylı Arama</span>
                                                                      <div class="dropdown">
                                                                          <a href="#" class="btn btn-sm btn-icon">
                                                                              <em class="icon ni ni-more-h"></em>
                                                                          </a>
                                                                      </div>
                                                                  </div>
                                                                  <div class="dropdown-body dropdown-body-rg">
                                                                      <div class="row gx-6 gy-3">
                                                                          <div class="col-6">
                                                                              <div class="custom-control custom-control-sm custom-checkbox">
                                                                                  <input type="checkbox" class="custom-control-input" id="hasBalance">
                                                                                  <label class="custom-control-label" for="hasBalance"> Have Balance</label>
                                                                              </div>
                                                                          </div>
                                                                          <div class="col-6">
                                                                              <div class="custom-control custom-control-sm custom-checkbox">
                                                                                  <input type="checkbox" class="custom-control-input" id="hasKYC">
                                                                                  <label class="custom-control-label" for="hasKYC"> KYC Verified</label>
                                                                              </div>
                                                                          </div>
                                                                          <div class="col-6">
                                                                              <div class="form-group">
                                                                                  <label class="overline-title overline-title-alt">Role</label>
                                                                                  <select class="form-select js-select2">
                                                                                      <option value="any">Any Role</option>
                                                                                      <option value="investor">Investor</option>
                                                                                      <option value="seller">Seller</option>
                                                                                      <option value="buyer">Buyer</option>
                                                                                  </select>
                                                                              </div>
                                                                          </div>
                                                                          <div class="col-6">
                                                                              <div class="form-group">
                                                                                  <label class="overline-title overline-title-alt">Status</label>
                                                                                  <select class="form-select js-select2">
                                                                                      <option value="any">Any Status</option>
                                                                                      <option value="active">Active</option>
                                                                                      <option value="pending">Pending</option>
                                                                                      <option value="suspend">Suspend</option>
                                                                                      <option value="deleted">Deleted</option>
                                                                                  </select>
                                                                              </div>
                                                                          </div>
                                                                          <div class="col-12">
                                                                              <div class="form-group">
                                                                                  <button type="button" class="btn btn-secondary">Filter</button>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                  <div class="dropdown-foot between">
                                                                      <a class="clickable" href="#">Reset Filter</a>
                                                                      <a href="#">Save Filter</a>
                                                                  </div>
                                                              </div><!-- .filter-wg -->
                                                          </div><!-- .dropdown -->
                                                      </li><!-- li -->
                                                      <li>
                                                          <div class="dropdown">
                                                              <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                                  <em class="icon ni ni-setting"></em>
                                                              </a>
                                                              <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                                                  <ul class="link-check">
                                                                      <li><span>Sayfalama</span></li>
                                                                      <li class="active"><a href="#">10</a></li>
                                                                      <li><a href="#">20</a></li>
                                                                      <li><a href="#">50</a></li>
                                                                  </ul>
                                                                  
                                                                  
                                                              </div>
                                                          </div><!-- .dropdown -->
                                                      </li><!-- li -->
                                                  </ul><!-- .btn-toolbar -->
                                              </div><!-- .toggle-content -->
                                          </div><!-- .toggle-wrap -->
                                      </li><!-- li -->
                                  </ul><!-- .btn-toolbar -->
                              </div><!-- .card-tools -->
                          </div><!-- .card-title-group -->
                          <div class="card-search search-wrap" data-search="search">
                              <div class="card-body">
                                  <div class="search-content">
                                      <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                      <input type="text" class="form-control border-transparent form-focus-none" placeholder="Bulmak istediğiniz ürünün adını yada kodunu yazınız..">
                                      <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                                  </div>
                              </div>
                          </div><!-- .card-search -->
                      </div><!-- .card-inner -->
                      <div class="card-inner p-0">
                          <div class="nk-tb-list nk-tb-ulist">
                              <div class="nk-tb-item nk-tb-head tb-tnx-head">
                                  <div class="nk-tb-col nk-tb-col-check">
                                      <div class="custom-control custom-control-sm custom-checkbox notext">
                                          <input type="checkbox" class="custom-control-input" id="uid">
                                          <label class="custom-control-label" for="uid"></label>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col w-max-110px"><span class="sub-text">Tarih</span></div>
                                  <div class="nk-tb-col tb-col-mb"><span class="sub-text">Bilgi</span></div>
                                  <div class="nk-tb-col tb-col-mb w-max-110px"><span class="sub-text">Tutar</span></div>
                                  <div class="nk-tb-col tb-col-mb w-max-110px"><span class="sub-text">Bakiye</span></div>
                                  <div class="nk-tb-col nk-tb-col-tools text-end">
                                     
                                  </div>
                              </div><!-- .nk-tb-item -->
                            
                              <div class="nk-tb-item" data-url="#">
                                  <div class="nk-tb-col nk-tb-col-check">
                                      <div class="custom-control custom-control-sm custom-checkbox notext">
                                          <input type="checkbox" class="custom-control-input" id="uid2">
                                          <label class="custom-control-label" for="uid2"></label>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md">
                                    <div class="user-info">
                                        <span class="tb-lead">9 Ekim 2023 </span>
                                        <span>11:00:33</span>
                                    </div>
                                  </div>
                                  <div class="nk-tb-col">
                                      <div class="user-card">
                                          <div class="user-avatar bg-success-dim sq">
                                              <span>GRŞ</span>
                                          </div>
                                          <div class="user-info">
                                              <span class="tb-lead">PAYTR ÖDEME VE ELEKTRONİK PARA KURULUŞU ANONİM ŞİRKETİ</span>
                                              <span>Sorgu No: 6348432 - PAYTR NET TUTAR</span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount para">32.119,20 <span class="currency">₺</span></span>
                                    
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount text-success para">51.952,12 <span class="currency text-success">₺</span></span>
                                     
                                  </div>
                                  <div class="nk-tb-col nk-tb-col-tools  text-end">
                                    <a   data-bs-toggle="modal" data-bs-target="#myModal2" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                                  </div>

                                  
                              </div><!-- .nk-tb-item -->
                              
                              <div class="nk-tb-item" data-url="#">
                                  <div class="nk-tb-col nk-tb-col-check">
                                      <div class="custom-control custom-control-sm custom-checkbox notext">
                                          <input type="checkbox" class="custom-control-input" id="uid2">
                                          <label class="custom-control-label" for="uid2"></label>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md">
                                    <div class="user-info">
                                        <span class="tb-lead">9 Ekim 2023 </span>
                                        <span>09:29:57</span>
                                    </div>
                                  </div>
                                  <div class="nk-tb-col">
                                      <div class="user-card">
                                          <div class="user-avatar bg-success-dim sq">
                                              <span>GRŞ</span>
                                          </div>
                                          <div class="user-info">
                                              <span class="tb-lead">TİKO YAZILIM ANONİM ŞİRKETİ</span>
                                              <span>Genel Kuveyt Türk Katılım Bankası A.Ş.</span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount para">3.859,94 <span class="currency">₺</span></span>
                                    
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount text-success para">19.832,92 <span class="currency text-success">₺</span></span>
                                     
                                  </div>
                                  <div class="nk-tb-col nk-tb-col-tools  text-end">
                                    <a href="<?= route_to('tportal.hesaplar.detay') ?>" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                                  </div>

                                  
                              </div><!-- .nk-tb-item -->
                              
                              <div class="nk-tb-item" data-url="#">
                                  <div class="nk-tb-col nk-tb-col-check">
                                      <div class="custom-control custom-control-sm custom-checkbox notext">
                                          <input type="checkbox" class="custom-control-input" id="uid2">
                                          <label class="custom-control-label" for="uid2"></label>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md">
                                    <div class="user-info">
                                        <span class="tb-lead">8 Ekim 2023 </span>
                                        <span>16:05:41</span>
                                    </div>
                                  </div>
                                  <div class="nk-tb-col">
                                      <div class="user-card">
                                          <div class="user-avatar bg-danger-dim sq">
                                              <span>CKŞ</span>
                                          </div>
                                          <div class="user-info">
                                              <span class="tb-lead">TARIK CAN</span>
                                              <span>Faturaya İstinaden Al.Hs:118336631 Enpara Şirketim Cep Şubesi</span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount para">-1.500,00 <span class="currency">₺</span></span>
                                    
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount text-success para">15.972,98 <span class="currency text-success">₺</span></span>
                                     
                                  </div>
                                  <div class="nk-tb-col nk-tb-col-tools  text-end">
                                    <a href="<?= route_to('tportal.hesaplar.detay') ?>" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                                  </div>

                                  
                              </div><!-- .nk-tb-item -->
                              
                              <div class="nk-tb-item" data-url="#">
                                  <div class="nk-tb-col nk-tb-col-check">
                                      <div class="custom-control custom-control-sm custom-checkbox notext">
                                          <input type="checkbox" class="custom-control-input" id="uid2">
                                          <label class="custom-control-label" for="uid2"></label>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md">
                                    <div class="user-info">
                                        <span class="tb-lead">6 Ekim 2023 </span>
                                        <span>15:35:16</span>
                                    </div>
                                  </div>
                                  <div class="nk-tb-col">
                                      <div class="user-card">
                                          <div class="user-avatar bg-success-dim sq">
                                              <span>GRŞ</span>
                                          </div>
                                          <div class="user-info">
                                              <span class="tb-lead">MERT SEMİH AYKUT</span>
                                              <span>Hesaptan hesaba havale</span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount para">1.498,00 <span class="currency">₺</span></span>
                                    
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount text-success para">17.472,98 <span class="currency text-success">₺</span></span>
                                     
                                  </div>
                                  <div class="nk-tb-col nk-tb-col-tools  text-end">
                                    <a href="<?= route_to('tportal.hesaplar.detay') ?>" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                                  </div>

                                  
                              </div><!-- .nk-tb-item -->
                              
                              
                              <div class="nk-tb-item" data-url="#">
                                  <div class="nk-tb-col nk-tb-col-check">
                                      <div class="custom-control custom-control-sm custom-checkbox notext">
                                          <input type="checkbox" class="custom-control-input" id="uid2">
                                          <label class="custom-control-label" for="uid2"></label>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md">
                                    <div class="user-info">
                                        <span class="tb-lead">6 Ekim 2023 </span>
                                        <span>11:54:02</span>
                                    </div>
                                  </div>
                                  <div class="nk-tb-col">
                                      <div class="user-card">
                                          <div class="user-avatar bg-success-dim sq">
                                              <span>GRŞ</span>
                                          </div>
                                          <div class="user-info">
                                              <span class="tb-lead">KARATEPE OTOMASYON MAKİNA SANAYİ VE</span>
                                              <span>Sorgu No: 982000120 - Ticari ödeme Türkiye Garanti Ban</span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount para">2.270,00 <span class="currency">₺</span></span>
                                    
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount text-success para">15.974,98 <span class="currency text-success">₺</span></span>
                                     
                                  </div>
                                  <div class="nk-tb-col nk-tb-col-tools  text-end">
                                    <a href="<?= route_to('tportal.hesaplar.detay') ?>" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                                  </div>

                                  
                              </div><!-- .nk-tb-item -->
                              
                              <div class="nk-tb-item" data-url="#">
                                  <div class="nk-tb-col nk-tb-col-check">
                                      <div class="custom-control custom-control-sm custom-checkbox notext">
                                          <input type="checkbox" class="custom-control-input" id="uid2">
                                          <label class="custom-control-label" for="uid2"></label>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md">
                                    <div class="user-info">
                                        <span class="tb-lead">6 Ekim 2023 </span>
                                        <span>11:00:30</span>
                                    </div>
                                  </div>
                                  <div class="nk-tb-col">
                                      <div class="user-card">
                                          <div class="user-avatar bg-success-dim sq">
                                              <span>GRŞ</span>
                                          </div>
                                          <div class="user-info">
                                              <span class="tb-lead">SEDAT ÇETİNKAYA</span>
                                              <span>Sorgu No: 4394000086 - Bireysel Ödeme Türkiye Garanti Bankası A.Ş.</span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount para">999,00 <span class="currency">₺</span></span>
                                    
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount text-success para">13.704,98 <span class="currency text-success">₺</span></span>
                                     
                                  </div>
                                  <div class="nk-tb-col nk-tb-col-tools  text-end">
                                    <a href="<?= route_to('tportal.hesaplar.detay') ?>" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                                  </div>

                                  
                              </div><!-- .nk-tb-item -->
                              
                              <div class="nk-tb-item" data-url="#">
                                  <div class="nk-tb-col nk-tb-col-check">
                                      <div class="custom-control custom-control-sm custom-checkbox notext">
                                          <input type="checkbox" class="custom-control-input" id="uid2">
                                          <label class="custom-control-label" for="uid2"></label>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md">
                                    <div class="user-info">
                                        <span class="tb-lead">6 Ekim 2023 </span>
                                        <span>11:00:30</span>
                                    </div>
                                  </div>
                                  <div class="nk-tb-col">
                                      <div class="user-card">
                                          <div class="user-avatar bg-success-dim sq">
                                              <span>GRŞ</span>
                                          </div>
                                          <div class="user-info">
                                              <span class="tb-lead">HÜSEYİN YAĞAR </span>
                                              <span>Sorgu No: 8013072 - 794 - 09001073 DAN TR450011100 TÜRKİYE HALK BANKASI</span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount para">329,00 <span class="currency">₺</span></span>
                                    
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount text-success para">12.705,98 <span class="currency text-success">₺</span></span>
                                     
                                  </div>
                                  <div class="nk-tb-col nk-tb-col-tools  text-end">
                                    <a href="<?= route_to('tportal.hesaplar.detay') ?>" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                                  </div>

                                  
                              </div><!-- .nk-tb-item -->
                              
                              <div class="nk-tb-item" data-url="#">
                                  <div class="nk-tb-col nk-tb-col-check">
                                      <div class="custom-control custom-control-sm custom-checkbox notext">
                                          <input type="checkbox" class="custom-control-input" id="uid2">
                                          <label class="custom-control-label" for="uid2"></label>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md">
                                    <div class="user-info">
                                        <span class="tb-lead">6 Ekim 2023 </span>
                                        <span>09:16:55</span>
                                    </div>
                                  </div>
                                  <div class="nk-tb-col">
                                      <div class="user-card">
                                          <div class="user-avatar bg-success-dim sq">
                                              <span>GRŞ</span>
                                          </div>
                                          <div class="user-info">
                                              <span class="tb-lead">TİKO YAZILIM ANONİM ŞİRKETİ</span>
                                              <span>Sorgu No: 9811382 - Genel Kuveyt Türk Katılım Bankası A.Ş.</span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount para">1.447,48 <span class="currency">₺</span></span>
                                    
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount text-success para">12.376,98 <span class="currency text-success">₺</span></span>
                                     
                                  </div>
                                  <div class="nk-tb-col nk-tb-col-tools  text-end">
                                    <a href="<?= route_to('tportal.hesaplar.detay') ?>" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                                  </div>

                                  
                              </div><!-- .nk-tb-item -->
                              
                              <div class="nk-tb-item" data-url="#">
                                  <div class="nk-tb-col nk-tb-col-check">
                                      <div class="custom-control custom-control-sm custom-checkbox notext">
                                          <input type="checkbox" class="custom-control-input" id="uid2">
                                          <label class="custom-control-label" for="uid2"></label>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md">
                                    <div class="user-info">
                                        <span class="tb-lead">5 Ekim 2023 </span>
                                        <span>10:05:31</span>
                                    </div>
                                  </div>
                                  <div class="nk-tb-col">
                                      <div class="user-card">
                                          <div class="user-avatar bg-danger-dim sq">
                                              <span>CKŞ</span>
                                          </div>
                                          <div class="user-info">
                                              <span class="tb-lead">NERİMAN KOCAKURT</span>
                                              <span>Türkiye İş Bankası A.Ş. Sorgu No: 1070518116 MOBIL</span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount para">-7.000,00 <span class="currency">₺</span></span>
                                    
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount text-success para">10.929,50 <span class="currency text-success">₺</span></span>
                                     
                                  </div>
                                  <div class="nk-tb-col nk-tb-col-tools  text-end">
                                    <a href="<?= route_to('tportal.hesaplar.detay') ?>" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                                  </div>

                                  
                              </div><!-- .nk-tb-item -->
                              
                              <div class="nk-tb-item" data-url="#">
                                  <div class="nk-tb-col nk-tb-col-check">
                                      <div class="custom-control custom-control-sm custom-checkbox notext">
                                          <input type="checkbox" class="custom-control-input" id="uid2">
                                          <label class="custom-control-label" for="uid2"></label>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md">
                                    <div class="user-info">
                                        <span class="tb-lead">6 Ekim 2023 </span>
                                        <span>09:16:55</span>
                                    </div>
                                  </div>
                                  <div class="nk-tb-col">
                                      <div class="user-card">
                                          <div class="user-avatar bg-success-dim sq">
                                              <span>GRŞ</span>
                                          </div>
                                          <div class="user-info">
                                              <span class="tb-lead">TİKO YAZILIM ANONİM ŞİRKETİ</span>
                                              <span>Sorgu No: 7764377 - Genel Kuveyt Türk Katılım Bankası</span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount para">2.894,97 <span class="currency">₺</span></span>
                                    
                                  </div>
                                  <div class="nk-tb-col tb-col-md text-end">
                                       <span class="tb-amount text-success para">17.929,50 <span class="currency text-success">₺</span></span>
                                     
                                  </div>
                                  <div class="nk-tb-col nk-tb-col-tools  text-end">
                                    <a href="<?= route_to('tportal.hesaplar.detay') ?>" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                                  </div>

                                  
                              </div><!-- .nk-tb-item -->
                              
                          </div><!-- .nk-tb-list -->
                      </div><!-- .card-inner -->
                      <div class="card-inner">
                          <div class="nk-block-between-md g-3">
                              <div class="g">
                                  <ul class="pagination justify-content-center justify-content-md-start">
                                      <li class="page-item"><a class="page-link" href="#">Geri</a></li>
                                      <li class="page-item  active"><a class="page-link" style="color:#fff" href="#">1</a></li>
                                     
                                      <li class="page-item"><a class="page-link" href="#">İleri</a></li>
                                  </ul><!-- .pagination -->
                              </div>
                              <div class="g d-none">
                                  <div class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                                      <div>Page</div>
                                      <div>
                                          <select class="form-select js-select2" data-search="on" data-dropdown="xs center">
                                              <option value="page-1">1</option>
                                              <option value="page-2">2</option>
                                              <option value="page-4">4</option>
                                              <option value="page-5">5</option>
                                              <option value="page-6">6</option>
                                              <option value="page-7">7</option>
                                              <option value="page-8">8</option>
                                              <option value="page-9">9</option>
                                              <option value="page-10">10</option>
                                              <option value="page-11">11</option>
                                              <option value="page-12">12</option>
                                              <option value="page-13">13</option>
                                              <option value="page-14">14</option>
                                              <option value="page-15">15</option>
                                              <option value="page-16">16</option>
                                              <option value="page-17">17</option>
                                              <option value="page-18">18</option>
                                              <option value="page-19">19</option>
                                              <option value="page-20">20</option>
                                          </select>
                                      </div>
                                      <div>OF 102</div>
                                  </div>
                              </div><!-- .pagination-goto -->
                          </div><!-- .nk-block-between -->
                      </div><!-- .card-inner -->
                  </div><!-- .card-inner-group -->
              </div><!-- .card -->
          </div><!-- .nk-block -->
      </div>
  </div>
</div>

    <!-- Modal Alert 2 -->
    <div class="modal right fade" tabindex="-1" id="myModal2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent" style="font-size: 70px;"></em>
                        <h4 class="nk-modal-title">Hesabı Silmek İstediğinize<br>Emin misiniz?</h4>
                        <div class="nk-modal-action mb-5">
                            <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                            <a href="#" class="btn btn-lg btn-mw btn-danger" data-bs-dismiss="modal">Evet</a>
                        </div>
                        <div class="nk-modal-text">
                            <p class="lead">Bu hesabınızı silmeniz için;<br>mevcut herhangi bir hesap hareketi olmamalıdır.</p>
                            <p class="text-soft">Silmeden önce lütfen yetkilinize danışınız.</p>
                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div>
        </div>
    </div>

	<!-- Modal -->
	<div class="modal right fade" id="myModal222" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel2">Right Sidebar</h4>
				</div>

				<div class="modal-body">
					<p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
					</p>
				</div>

			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div><!-- modal -->
	
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>

</script>

<?= $this->endSection() ?>