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
                        <h3 class="nk-block-title page-title">Çekler</h3>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                    <li class="nk-block-tools-opt">
                                        <a href="<?= site_url('tikoerp/cekler/yeni') ?>" class="btn btn-primary">
                                            <em class="icon ni ni-plus"></em>
                                            <span>Yeni Çek</span>
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
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid">
                                            <label class="custom-control-label" for="uid"></label>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col w-max-100px"><span class="sub-text">Tarih</span></div>
                                    <div class="nk-tb-col tb-col-mb"><span class="sub-text">Bilgi</span></div>
                                    <div class="nk-tb-col tb-col-md w-max-100px"><span class="sub-text">Tutar</span></div>
                                    <div class="nk-tb-col tb-col-md w-max-100px"><span class="sub-text">Vade</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Durum</span></div>
                                    <div class="nk-tb-col nk-tb-col-tools text-end">İşlemler</div>
                                </div>

                                <?php foreach ($cekler as $cek): ?>
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid<?= $cek['id'] ?>">
                                            <label class="custom-control-label" for="uid<?= $cek['id'] ?>"></label>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                    <div class="user-info">
                                        <?php 
                                        setlocale(LC_TIME, 'tr_TR.UTF-8');
                                        $tarih = strtotime($cek['created_at']);
                                        $formatliTarih = strftime('%d %B %Y', $tarih);
                                        ?>
                                        <span class="tb-lead"><?= $formatliTarih ?></span>
                                        <span><?= date('H:i:s', $tarih) ?></span>
                                    </div>
                                    </div>
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-avatar bg-<?= $cek['cek_durum'] === 'BEKLEMEDE' ? 'success' : 'danger' ?>-dim sq">
                                                <span><?= $cek['cek_durum'] === 'BEKLEMEDE' ? 'GRŞ' : 'ÇKŞ' ?></span>
                                            </div>
                                            <div class="user-info">
                                                <span class="tb-lead"><?= $cek['company_type'] == 'company' ? $cek['invoice_title'] : $cek['name'] . ' ' . $cek['surname'] ?></span>
                                                <span><?= $cek['bank_title'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md text-end">
                                        <span class="tb-amount para"><?= number_format($cek['cek_tutar'], 2, ',', '.') ?> 
                                            <span class="currency"><?= $cek['cek_para_birimi'] ?></span>
                                        </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md text-end">
                                        <span><?= date('d.m.Y', strtotime($cek['vade_tarihi'])) ?></span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge badge-dot bg-<?= getDurumClass($cek['cek_durum']) ?>">
                                            <?= getDurumText($cek['cek_durum']) ?>
                                        </span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-col-tools text-end">
                                        <ul class="nk-tb-actions gx-1">
                                            <?php if ($cek['cek_durum'] === 'BEKLEMEDE'): ?>
                                            <li>
                                                <a href="<?= site_url('tikoerp/cekler/ciro/' . $cek['id']) ?>" 
                                                   class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" 
                                                   data-bs-placement="top" title="Ciro Et">
                                                    <em class="icon ni ni-repeat"></em>
                                                </a>
                                            </li>
                                            <?php endif; ?>
                                            <li>
                                                <a href="<?= site_url('tikoerp/cekler/detay/' . $cek['id']) ?>" 
                                                   class="btn btn-round btn-icon btn-outline-light">
                                                    <em class="icon ni ni-chevron-right"></em>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

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

<?= $this->section('js') ?>
<script>
$(document).ready(function() {
    $('.js-select2').select2({
        placeholder: "Seçiniz"
    });
});
</script>
<?= $this->endSection() ?>