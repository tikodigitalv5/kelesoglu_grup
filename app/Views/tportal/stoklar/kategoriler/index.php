<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Kategoriler <?= $this->endSection() ?>
<?= $this->section('title') ?> Kategoriler | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>


<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Kategoriler</h3>
                        <!-- <div class="nk-block-des text-soft">
                          <p>You have total 2,595 users.</p>
                      </div> -->
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                                    class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li><a href="#" class="btn btn-white btn-outline-light"><em
                                                class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                    <li class="nk-block-tools-opt">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary"
                                                data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
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
                                            <select class="form-select js-select2" data-search="off"
                                                data-placeholder="Toplu İşlem">
                                                <option value="">Toplu İşlem</option>
                                                <option value="#">İndir (Excel)</option>
                                                <option value="#">İndir (PDF)</option>
                                                <option value="#">Yazdır</option>
                                                <option value="#">Seçilenleri Sil</option>
                                            </select>
                                        </div>
                                        <div class="btn-wrap">
                                            <span class="d-none d-md-block"><button
                                                    class="btn btn-dim btn-outline-light disabled">Uygula</button></span>
                                            <span class="d-md-none"><button
                                                    class="btn btn-dim btn-outline-light btn-icon disabled"><em
                                                        class="icon ni ni-arrow-right"></em></button></span>
                                        </div>
                                    </div><!-- .form-inline -->
                                </div><!-- .card-tools -->
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>
                                            <a href="#" class="btn btn-icon search-toggle toggle-search"
                                                data-target="search"><em class="icon ni ni-search"></em></a>
                                        </li><!-- li -->
                                        <li class="btn-toolbar-sep"></li><!-- li -->
                                        <li>
                                            <div class="toggle-wrap">
                                                <a href="#" class="btn btn-icon btn-trigger toggle"
                                                    data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                <div class="toggle-content" data-content="cardTools">
                                                    <ul class="btn-toolbar gx-1">
                                                        <li class="toggle-close">
                                                            <a href="#" class="btn btn-icon btn-trigger toggle"
                                                                data-target="cardTools"><em
                                                                    class="icon ni ni-arrow-left"></em></a>
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#"
                                                                    class="btn btn-trigger btn-icon dropdown-toggle d-none"
                                                                    data-bs-toggle="dropdown">
                                                                    <div class="dot dot-primary"></div>
                                                                    <em class="icon ni ni-filter-alt"></em>
                                                                </a>
                                                                <div
                                                                    class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                                    <div class="dropdown-head">
                                                                        <span class="sub-title dropdown-title">Detaylı
                                                                            Arama</span>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="btn btn-sm btn-icon">
                                                                                <em class="icon ni ni-more-h"></em>
                                                                            </a>
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
                                                                <a href="#" class="btn btn-icon btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#createModalForm"><em
                                                                        class="icon ni ni-plus"></em><span
                                                                        class="ps-0 ms-0 pe-2">Yeni Kategori</span></a>

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
                                        <a href="#" class="search-back btn btn-icon toggle-search"
                                            data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" class="form-control border-transparent form-focus-none"
                                            placeholder="Bulmak istediğiniz ürünün adını yada kodunu yazınız..">
                                        <button class="search-submit btn btn-icon"><em
                                                class="icon ni ni-search"></em></button>
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
                                    <div class="nk-tb-col"><span class="sub-text">Sıralama</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Kategori Adı</span></div>
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Durum</span></div>
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Varsayılan</span></div>
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Varyantlar</span></div>
                                    <?php if(session()->get('user_id') == 5 || session()->get('client_id') == 154): ?>
                                    <div class="nk-tb-col"><span class="sub-text">Ham Ç.</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Kap Ç.</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Taş Ç<div class=""></div></span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Mineli Ç.</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Kar O.</span></div>
                                    <?php endif; ?>
                                    <div class="nk-tb-col nk-tb-col-tools text-end">

                                    </div>
                                </div><!-- .nk-tb-item -->

                                <?php 
                              foreach($category_items as $category_item){ ?>

                                <div class="nk-tb-item" data-url="'.route_to('tportal.stoklar.detay').'"
                                    id="category_'.$category_item['category_id'].'">
                                    <div class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid3">
                                            <label class="custom-control-label" for="uid3"></label>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead"><?= $category_item['order'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead"><?= $category_item['category_title'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <div class="custom-control custom-switch ps-0">
                                            <div id="div_status_<?= $category_item['category_id'] ?>"
                                                class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input status-button"
                                                    data-status="<?= $category_item['status'] ?>"
                                                    data-id="<?= $category_item['category_id'] ?>"
                                                    id="chk_status_<?= $category_item['category_id'] ?>"
                                                    <?php if($category_item['status'] == 'active'){ ?>checked
                                                    <?php } ?>>
                                                <label class="custom-control-label"
                                                    id="btn_status_<?= $category_item['category_id'] ?>"
                                                    for="chk_status_<?= $category_item['category_id'] ?>">
                                                    <?php if($category_item['status'] == 'active'){ echo 'Aktif'; }else{ echo 'Pasif'; } ?>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <div class="custom-control custom-switch ps-0">
                                            <div id="div_default_<?= $category_item['category_id'] ?>"
                                                class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input default-button"
                                                    data-default="<?= $category_item['default'] ?>"
                                                    data-id="<?= $category_item['category_id'] ?>"
                                                    id="chk_default_<?= $category_item['category_id'] ?>"
                                                    <?php if($category_item['default'] == 'true'){ ?>checked <?php } ?>>
                                                <label class="custom-control-label"
                                                    id="btn_default_<?= $category_item['category_id'] ?>"
                                                    for="chk_default_<?= $category_item['category_id'] ?>">
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#mdl_variant_category_list_<?= $category_item['category_id'] ?>"
                                            class="btn btn-round btn-dim btn-outline-dark"><?= count($variant_category_items[$category_item['category_id']]); ?>
                                            Adet
                                        </a>
                                    </div>
                                    <?php if(session()->get('user_id') == 5 || session()->get('client_id') == 154): ?>
                                    <div class="nk-tb-col">
                                        <span class="badge bg-secondary"><?= $category_item['ham_carpan'] ?? '' ?></span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge bg-secondary"><?= $category_item['kap_carpan'] ?? '' ?></span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge bg-secondary"><?= $category_item['tas_carpan'] ?? '' ?></span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge bg-secondary"><?= $category_item['mineli_carpan'] ?? '' ?></span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge bg-secondary"><?= $category_item['kar_oran'] ?? '' ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <div class="nk-tb-col nk-tb-col-tools  text-end">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#editModalForm"
                                            data-item-id="<?= $category_item['category_id'] ?>"
                                            data-title="<?= $category_item['category_title'] ?>"
                                            data-category-value="<?= $category_item['category_value'] ?>"
                                            data-order="<?= $category_item['order'] ?>"
                                            <?php if(session()->get('user_id') == 5 || session()->get('client_id') == 154): ?>
                                            data-ham-carpan="<?= $category_item['ham_carpan'] ?? '' ?>"
                                            data-kap-carpan="<?= $category_item['kap_carpan'] ?? '' ?>"
                                            data-tas-carpan="<?= $category_item['tas_carpan'] ?? '' ?>"
                                            data-mineli-carpan="<?= $category_item['mineli_carpan'] ?? '' ?>"
                                            data-kar-oran="<?= $category_item['kar_oran'] ?? '' ?>"
                                            <?php endif; ?>
                                            class="btn btn-round btn-icon btn-dim btn-outline-dark edit-action"><em
                                                class="icon ni ni-pen-alt-fill"></em></a>
                                        <a href="#"
                                            class="btn btn-round btn-icon btn-dim btn-outline-danger delete-action"
                                            data-bs-toggle="modal" data-bs-target="#modal_delete_category"
                                            data-item-id="<?= $category_item['category_id'] ?>"><em
                                                class="icon ni ni-trash-empty"></em></a>

                                    </div>
                                </div><!-- .nk-tb-item -->
                                <?php
                              } 
                              ?>

                            </div><!-- .nk-tb-list -->
                        </div><!-- .card-inner -->
                        <div class="card-inner">
                            <div class="nk-block-between-md g-3">
                                <div class="g">
                                    <ul class="pagination justify-content-center justify-content-md-start">
                                        <li class="page-item"><a class="page-link" href="#">Geri</a></li>
                                        <li class="page-item  active"><a class="page-link" style="color:#fff"
                                                href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><span class="page-link"><em
                                                    class="icon ni ni-more-h"></em></span></li>
                                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                                        <li class="page-item"><a class="page-link" href="#">7</a></li>
                                        <li class="page-item"><a class="page-link" href="#">İleri</a></li>
                                    </ul><!-- .pagination -->
                                </div>
                                <div class="g d-none">
                                    <div
                                        class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                                        <div>Page</div>
                                        <div>
                                            <select class="form-select js-select2" data-search="on"
                                                data-dropdown="xs center">
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

<?php foreach($variant_category_items as $category_id => $variant_category_item){ 
    $category_item = $category_items[array_search($category_id, array_column($category_items, 'category_id'))];
    $category_title = $category_item['category_title'];
?>
<div class="modal fade" tabindex="-1" id="mdl_variant_category_list_<?= $category_id ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom:0px;">
                <h5 class="modal-title"><?= $category_title ?></h5>
                <a href="#" id="btn_hesaplar_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body p-0">
                <table class="datatable-init nowrap table mb-0" data-export-title="Export">
                    <thead>
                        <tr style="background-color: #ebeef2;">
                            <th style="background-color: #ebeef2;">Kategori Adı</th>
                            <th style="background-color: #ebeef2;" data-orderable="false">Varyant Grup Adı</th>
                            <th style="background-color: #ebeef2;" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($variant_category_item as $item){ ?>
                        <tr>
                            <td><?= $category_title ?></td>
                            <td><?= $item['variant_title'] ?></td>
                            </td>
                            <td class="text-end">
                                <a href="#"
                                    class="btn btn-round btn-icon btn-xs btn-dim btn-outline-danger delete-variant-category-action"
                                    data-bs-toggle="modal" data-bs-target="#modal_delete_variant_category"
                                    data-item-id="<?= $item['variant_group_category_id'] ?>"
                                    data-category-title="<?= $category_title ?>"
                                    data-category-id="<?= $category_item['category_id'] ?>"><em
                                        class="icon ni ni-trash-empty"></em></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#createVariantCategoryModalForm"
                            data-category-title="<?= $category_title ?>"
                            data-category-id="<?= $category_item['category_id'] ?>"
                            class="btn btn-md btn-primary triggerModalCreateVariantCategory">YENİ VARYANT GRUBU</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <button type="button" id="btn_hesapyeniekle_mdl"
                            class="btn btn-md btn-dim btn-outline-light" data-bs-dismiss="modal">KAPAT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>


<!-- Create Variant Category Form -->
<div class="modal fade" id="createVariantCategoryModalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Varyant Grubu Ekle</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="createVariantCategoryForm" method="post"
                    class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="category_title">Kategori Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="variant_category_title"
                                name="category_title" required disabled value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control-wrap ">
                            <label class="form-label" for="variant_group_id">Varyant Grup Adı</label>
                            <div class="form-control-select">
                                <select required=""
                                    class="form-control select2 form-control-xl"
                                    name="variant_group_id" id="variant_group_id">
                                    <option value="">Lütfen Seçiniz
                                    </option>
                                    <?php 
                                foreach($variant_group_items as $variant_group_item){ ?>
                                    <option value="<?= $variant_group_item['variant_group_id'] ?>">
                                        <?= $variant_group_item['variant_title'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="close_modal_create" class="btn btn-lg  btn-dim btn-outline-light"
                            data-bs-dismiss="modal">KAPAT</button>

                    </div>
                    <div class="col-md-8 text-end p-0">
                        <!-- <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ HESAP</button> -->
                        <button type="button" id="variantCategoryOlustur"
                            class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal Form -->
<div class="modal fade" id="createModalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Kategori</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="createCategoryForm" method="post" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="category_title">Kategori Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="category_title"
                                name="category_title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="category_value">Kategori Benzersiz Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="category_value"
                                name="category_value">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="category_title">Sıralama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="order" name="order" required>
                        </div>
                    </div>
                    
                    <?php if(session()->get('user_id') == 5 || session()->get('client_id') == 154): ?>
                    <div class="form-group">
                        <label class="form-label" for="ham_carpan">Ham Çarpan</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="ham_carpan" name="ham_carpan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="kap_carpan">Kap Çarpan</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="kap_carpan" name="kap_carpan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tas_carpan">Taş Çarpan</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="tas_carpan" name="tas_carpan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="mineli_carpan">Mineli Çarpan</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="mineli_carpan" name="mineli_carpan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="kar_oran">Kar Oranı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="kar_oran" name="kar_oran">
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="row g-3 align-center mb-4">
                        <div class="col-lg-5 col-xxl-5 col-6">
                            <div class="form-group">
                                <label class="form-label">Durum</label>
                            </div>
                        </div>
                        <div class="col-lg-7 col-xxl-7 col-6">
                            <ul class="custom-control-group g-3 align-center flex-wrap">
                                <li>
                                    <div class="custom-control custom-control-xl custom-radio checked"><input
                                            type="radio" class="custom-control-input" value="active" checked=""
                                            name="status" id="reg-enable"><label class="custom-control-label"
                                            for="reg-enable">Aktif</label></div>
                                </li>
                                <li>
                                    <div class="custom-control custom-control-xl custom-radio"><input type="radio"
                                            class="custom-control-input" value="passive" name="status" id="reg-disable">
                                        <label class="custom-control-label" for="reg-disable">Pasif</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5 col-xxl-5 col-6">
                            <div class="form-group">
                                <label class="form-label">Varsayılan</label>
                            </div>
                        </div>
                        <div class="col-lg-7 col-xxl-7 col-6">
                            <div class="custom-control custom-switch">
                                <div id="is_default" class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="chk_default"
                                        name="default">
                                    <label class="custom-control-label" for="chk_default"></label>
                                </div>
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
                        <button type="button" id="categoryOlustur" class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal Form -->
<div class="modal fade" id="editModalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kategori Düzenle</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="editCategoryForm" method="post" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="edit_category_title">Kategori Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_category_title"
                                name="category_title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_category_value">Kategori Benzersiz Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_category_value"
                                name="category_value">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_order">Sıralama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_order" name="order"
                                required>
                        </div>
                    </div>
                    
                    <?php if(session()->get('user_id') == 5 || session()->get('client_id') == 154): ?>
                    <div class="form-group">
                        <label class="form-label" for="edit_ham_carpan">Ham Çarpan</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_ham_carpan" name="ham_carpan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_kap_carpan">Kap Çarpan</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_kap_carpan" name="kap_carpan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_tas_carpan">Taş Çarpan</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_tas_carpan" name="tas_carpan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_mineli_carpan">Mineli Çarpan</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_mineli_carpan" name="mineli_carpan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_kar_oran">Kar Oranı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_kar_oran" name="kar_oran">
                        </div>
                    </div>
                    <?php endif; ?>
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
                        <button type="button" id="categoryDuzenle" class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'category',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="#" data-bs-toggle="modal" data-bs-target="#createModalForm" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Kategori Ekle</a>
                                    <a href="#" onclick="location.reload()" class="btn btn-l btn-dim btn-outline-dark btn-block">Kategori Listesi</a>'
            ],
            'delete' => [
                'modal_title' => 'Bu Kategoriyi Silmek İstediğinize<br>Emin misiniz?',
                'modal_text' => 'Bu kategoriyi silmeden önce lütfen yetkilinize danışınız.',
            ]
        ],
    ]
); ?>

<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'variant_category',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="#" data-bs-toggle="modal" data-bs-target="#createVariantCategoryModalForm" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Varyant Grubu Ekle</a>
                                    <a href="#" onclick="location.reload()" class="btn btn-l btn-dim btn-outline-dark btn-block">Kategori Listesi</a>'
            ],
            'delete' => [
                'modal_title' => 'Bu Varyant Grubunu Kategoriden Silmek İstediğinize<br>Emin misiniz?',
                'modal_text' => 'Bu varyant gurubunu kategoriden silmeden önce lütfen yetkilinize danışınız.',
            ]
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
var item_id = 0;
$('#categoryOlustur').click(function(e) {
    if ($('#category_title').val() == '' || 
        $('#category_value').val() == '') {
        swetAlert("Eksik Birşeyler Var", "Kategori Adı Giriniz.! ", "err");
    } else {
        var formData = $('#createCategoryForm').serializeArray();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.category.create') ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {

                if (response['icon'] == 'success') {
                    $("#createCategoryForm")[0].reset();
                    $('#createModalForm').modal('toggle');
                    $("#trigger_category_ok_button").trigger("click");
                } else {
                    $('#sevkOlustur').attr("disabled", false);
                    return false;
                }
            }
        })
    }

});

$('.delete-action').on('click', function() {
    item_id = $(this).attr('data-item-id');
});

$('#modal_delete_category_button').on('click', function() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.category.delete') ?>',
        dataType: 'json',
        data: {
            category_id: item_id,
        },
        async: true,
        success: function (response) {
               
          
            if (response["icon"] == "success") {
                $("#editCategoryForm")[0].reset();
                $("#createCategoryForm")[0].reset();
                $("#trigger_category_ok_button").trigger("click");

            

            }else{

                var detailsHtml = '';
                if (response["details"] && response["details"].length > 0) {
                    detailsHtml = '<ul>';
                    response["details"].forEach(function(detail) {
                        detailsHtml += '<li><b>' + detail.stock_title + '</b></li>';
                    });
                    detailsHtml += '</ul>';
                }

                Swal.fire({
                    title: response["icon"] === 'success' ? 'Başarılı!' : 'İşlem Başarısız',
                    html: response["icon"] === 'error' ? response["message"] + detailsHtml : response["message"],
                    confirmButtonText: 'Tamam',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    icon: response["icon"],
                });
               
            }
        }
    })
});

$('.edit-action').on('click', function() {
    item_id = $(this).attr('data-item-id');
    item_title = $(this).attr('data-title');
    category_value = $(this).attr('data-category-value');
    item_order = $(this).attr('data-order');
    
    // Yeni alanlar için data attribute'ları ekle
    item_ham_carpan = $(this).attr('data-ham-carpan');
    item_kap_carpan = $(this).attr('data-kap-carpan');
    item_tas_carpan = $(this).attr('data-tas-carpan');
    item_mineli_carpan = $(this).attr('data-mineli-carpan');
    item_kar_oran = $(this).attr('data-kar-oran');

    $('#edit_category_title').val(item_title);
    $('#edit_order').val(item_order);
    $('#edit_category_value').val(category_value);
    
    // Yeni alanları doldur (sadece belirli kullanıcılar için)
    <?php if(session()->get('user_id') == 5 || session()->get('client_id') == 154): ?>
    $('#edit_ham_carpan').val(item_ham_carpan);
    $('#edit_kap_carpan').val(item_kap_carpan);
    $('#edit_tas_carpan').val(item_tas_carpan);
    $('#edit_mineli_carpan').val(item_mineli_carpan);
    $('#edit_kar_oran').val(item_kar_oran);
    <?php endif; ?>

    $('#categoryDuzenle').click(function(e) {

        if ($('#edit_category_title').val() == '' ||
            $('#edit_category_value').val() == '') {
            swetAlert("Eksik Birşeyler Var", "Kategori Adı Giriniz.! ", "err");
        } else {
            var formData = $('#editCategoryForm').serializeArray();
            formData.push({
                name: 'category_id',
                value: item_id
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.stocks.category.edit') ?>',
                dataType: 'json',
                data: formData,
                async: true,
                success: function(response) {
                    if (response['icon'] == 'success') {
                        $("#editCategoryForm")[0].reset();
                        $('#editModalForm').modal('toggle');
                        $("#trigger_category_ok_button").trigger("click");
                    } else {
                        $('#sevkOlustur').attr("disabled", false);
                        return false;
                    }
                }
            })
        }
    })

});

$('.status-button').on('change', function() {
    if ($(this).data('status') == 'passive') {
        $('#btn_status_' + $(this).data('id')).html('Aktif');
        $(this).data('status', 'active');
    } else {
        $('#btn_status_' + $(this).data('id')).html('Pasif');
        $(this).data('status', 'passive')
    }

    category_id = $(this).data('id');
    status = $(this).data('status');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.category.edit.status') ?>',
        dataType: 'json',
        data: {
            status: status,
            category_id: category_id
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#editCategoryForm")[0].reset();
                $("#createCategoryForm")[0].reset();
                $("#trigger_category_ok_button").trigger("click");
            } else {
                $('#sevkOlustur').attr("disabled", false);
                return false;
            }
        }
    })
});

$('.default-button').on('click', function() {
    $(".default-button").prop('checked', false);
    $(this).prop('checked', true);
    category_id = $(this).data('id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.category.edit.default') ?>',
        dataType: 'json',
        data: {
            category_id: category_id
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#editCategoryForm")[0].reset();
                $("#createCategoryForm")[0].reset();
                $("#trigger_category_ok_button").trigger("click");
            } else {
                $('#sevkOlustur').attr("disabled", false);
                return false;
            }
        }
    })
});


$('.triggerModalCreateVariantCategory').on('click', function() {
    category_id = $(this).attr('data-category-id');
    variant_category_title = $(this).attr('data-category-title');

    $('#close_modal_create').attr('data-category-id', category_id);
    $('#variant_category_title').val(variant_category_title);
    $('#createVariantCategoryForm').attr('data-category-id', category_id);
});

$('#variantCategoryOlustur').click(function(e) {
    $('#variant_category_title').val(variant_category_title)
    if ($('#variant_group_id').find(":selected").val() == ''
    ) {
        swetAlert("Eksik Birşeyler Var", "Varyant Grubu Seçiniz.! ", "err");
    } else {
        var formData = $('#createVariantCategoryForm').serializeArray();
        formData.push({
            name: 'category_id',
            value: category_id
        });
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.category.variant_group_category_create') ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    $("#createVariantCategoryForm")[0].reset();
                    $('#createVariantCategoryModalForm').modal('toggle');
                    $('#variant_category_title').val(variant_category_title)
                    $('#createVariantCategoryForm').attr('data-category-id', category_id)
                    $("#trigger_variant_category_ok_button").trigger("click");
                }
            }
        })
    }
});

$('.delete-variant-category-action').on('click', function() {
    item_id = $(this).attr('data-item-id');
    category_id = $(this).attr('data-category-id');
    variant_category_title = $(this).attr('data-category-title');

    $('#variant_category_title').val(variant_category_title);
    $('#createVariantCategoryForm').attr('data-category-id', category_id)
});

$('#modal_delete_variant_category_button').on('click', function() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.category.variant_group_category_delete') ?>',
        dataType: 'json',
        data: {
            variant_category_id: item_id,
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#createVariantCategoryForm")[0].reset();
                $("#trigger_variant_category_ok_button").trigger("click");

                $('#variant_category_title').val(variant_category_title);
                $('#createVariantCategoryForm').attr('data-category-id', category_id)
            }else{
                Swal.fire({
                        title: "Hata Oluştu",
                        html: response['message'],
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "error",
                    })
            }
        }
    })
});
$('#close_modal_create').on('click', function(){
    category_id = $(this).attr('data-category-id')
    $('#mdl_variant_category_list_'+category_id).modal('toggle');
})
</script>

<?= $this->endSection() ?>