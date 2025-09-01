<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> <?= $page_title ?> <?= $this->endSection() ?>
<?= $this->section('title') ?> <?= $page_title ?> | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>

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
            <div class="nk-block">
  <div class="row gy-gs">
  <div class="col-md-6 col-lg-3">
      <div class="nk-wg-card is-s0 card card-bordered">
        <div class="card-inner">
          <div class="nk-iv-wg2">
            <div class="nk-iv-wg2-title">
              <h6 class="title">Beklemede<em class="icon ni ni-loader"></em>
              </h6>
            </div>
            <div class="nk-iv-wg2-text">
              <div class="nk-iv-wg2-amount"> <?php echo $toplambeklemede; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="nk-wg-card is-s1 card card-bordered">
        <div class="card-inner">
          <div class="nk-iv-wg2">
            <div class="nk-iv-wg2-title">
              <h6 class="title">Devameden<em class="icon ni ni-play"></em>
              </h6>
            </div>
            <div class="nk-iv-wg2-text">
              <div class="nk-iv-wg2-amount">  <?php echo $toplamdevameden; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="nk-wg-card is-s2 card card-bordered">
        <div class="card-inner">
          <div class="nk-iv-wg2">
            <div class="nk-iv-wg2-title">
              <h6 class="title">Duraklatılan <em class="icon ni ni-pause"></em>
              </h6>
            </div>
            <div class="nk-iv-wg2-text">
              <div class="nk-iv-wg2-amount"> <?php echo $toplamduraklatilan; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="nk-wg-card is-s3 card card-bordered">
        <div class="card-inner">
          <div class="nk-iv-wg2">
            <div class="nk-iv-wg2-title">
              <h6 class="title">Bitenler <em class="icon ni ni-check-circle-cut"></em>
              </h6>
            </div>
            <div class="nk-iv-wg2-text">
              <div class="nk-iv-wg2-amount"> <?php echo $toplambiten; ?>
              </div>
            </div>
          </div>
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
                                    <div class="nk-tb-col tb-col-mb"><span class="sub-text">Üretim Tarihi</span></div>
                                    <div class="nk-tb-col tb-col-mb"><span class="sub-text">Üretim No</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Ürün</span></div>
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Miktar</span></div>
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Durum</span></div>
                                    <div class="nk-tb-col nk-tb-col-tools text-end">

                                    </div>
                                </div><!-- .nk-tb-item -->

                                <?php if ($order_items_count != 0) {
                                  
                                    foreach ($order_items as $key => $order_item) { ?>
                                        <div class="nk-tb-item" data-url="<?= route_to('tportal.uretim.detail', $order_item['production_id'],$order_item['stock_id']) ?>">
                                            <div class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                    <input type="checkbox" class="custom-control-input" id="uid_<?= $order_item['production_id'] ?>">
                                                    <label class="custom-control-label" for="uid_<?= $order_item['production_id'] ?>"></label>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col tb-col-mb">
                                                <div class="user-info">
                                                    <span class="tb-lead"><?= convert_date_for_view($order_item['created_at']) ?></span>
                                                    <span><?= convert_time_for_form($order_item['created_at']) ?></span>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col tb-col-mb">
                                                <div class="user-info">
                                                    <span class="tb-lead"><?= $order_item['production_number'] ?></span>
                                                    <span> Üretim</span>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col tb-col-md">
                                            <?= $order_item['stock_title'] ?>
                                            </div>
                                            <div class="nk-tb-col tb-col-md">
                                                <span class="tb-amount"><?= number_format($order_item['total_stock_amount'], 2, ',', '.') ?> </span></span>
                                            </div>
                                            <div class="nk-tb-col tb-col-md">
                                                <?php switch ($order_item['status']) {
                                                    case 'new':
                                                        echo "<span class='tb-status text-primary'> Yeni Üretim </span>";
                                                        break;
                                                    case 'pending':
                                                        echo "<span class='tb-status text-warning'> Hazırlanıyor </span>";
                                                        break;
                                                    case 'success':
                                                        echo "<span class='tb-status text-success'> Tamamlandı </span>";
                                                        break;
                                                    case 'failed':
                                                        echo "<span class='tb-status text-danger'> İptal </span>";
                                                        break;
                                                } ?>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col-tools  text-end">
                                                <a href="<?= route_to('tportal.uretim.detail', $order_item["production_id"],$order_item['stock_id']) ?>" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                    <?php }
                                } else { ?> 
                                    
                                

                            </div><!-- .nk-tb-list -->
                            <div class="text-center p-3">Üretim kaydı mevcut değil.</div>
                            <?php }  ?>
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

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    $(".nk-tb-item").click(function() {
        // alert($(this).data('url'));
        window.location.href = $(this).data('url');
    });
</script>

<?= $this->endSection() ?>