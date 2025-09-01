<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Varyantlar <?= $this->endSection() ?>
<?= $this->section('title') ?> Varyantlar | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>


<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Varyantlar</h3>
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
                                                                        <span class="sub-title dropdown-title">Detaylı Arama</span>
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
                                                                    data-bs-target="#createVariantGroupModalForm"><em
                                                                        class="icon ni ni-plus"></em><span
                                                                        class="ps-0 ms-0 pe-2">Yeni Varyant</span></a>

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
                                    <div class="nk-tb-col"><span class="sub-text">Varyant Adı</span></div>
                                    
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Durum</span></div>
                                    <?php if(session()->get('user_item')['user_id'] == 5){ ?>
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">B2B</span></div>
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Website</span></div>
                                    <?php } ?>
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Özellikler</span></div>
                                    <div class="nk-tb-col nk-tb-col-tools text-end">

                                    </div>
                                </div><!-- .nk-tb-item -->

                                <?php 
                              foreach($variant_group_items as $variant_group_item){ ?>

                                <div class="nk-tb-item" data-url="'.route_to('tportal.stoklar.detay').'"
                                    id="variant_group_<?=$variant_group_item['variant_group_id']?>">
                                    <div class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid3">
                                            <label class="custom-control-label" for="uid3"></label>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead"><?= $variant_group_item['order'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead"><?= $variant_group_item['variant_title'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <div class="custom-control custom-switch ps-0">
                                            <div id="div_status_<?= $variant_group_item['variant_group_id'] ?>"
                                                class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input status-button"
                                                    data-status="<?= $variant_group_item['status'] ?>"
                                                    data-id="<?= $variant_group_item['variant_group_id'] ?>"
                                                    id="chk_status_<?= $variant_group_item['variant_group_id'] ?>"
                                                    <?php if($variant_group_item['status'] == 'active'){ ?>checked
                                                    <?php } ?>>
                                                <label class="custom-control-label"
                                                    id="btn_status_<?= $variant_group_item['variant_group_id'] ?>"
                                                    for="chk_status_<?= $variant_group_item['variant_group_id'] ?>">
                                                    <?php if($variant_group_item['status'] == 'active'){ echo 'Aktif'; }else{ echo 'Pasif'; } ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(session()->get('user_item')['user_id'] == 5){ ?>
                                        <div class="nk-tb-col tb-col-md">
                                        <div class="custom-control custom-switch ps-0">
                                            <div id="div_b2b_<?= $variant_group_item['variant_group_id'] ?>"
                                                class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input  status-b2b"
                                                    data-status="<?= $variant_group_item['b2b'] ?>"
                                                    data-id="<?= $variant_group_item['variant_group_id'] ?>"
                                                    id="chk_b2b_<?= $variant_group_item['variant_group_id'] ?>"
                                                    <?php if($variant_group_item['b2b'] == 1){ ?>checked
                                                    <?php } ?>>
                                                <label class="custom-control-label"
                                                    id="btn_b2b_<?= $variant_group_item['variant_group_id'] ?>"
                                                    for="chk_b2b_<?= $variant_group_item['variant_group_id'] ?>">
                                                    <?php if($variant_group_item['b2b'] == 1){ echo 'Aktif'; }else{ echo 'Pasif'; } ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="nk-tb-col tb-col-md">
                                        <div class="custom-control custom-switch ps-0">
                                            <div id="div_website_<?= $variant_group_item['variant_group_id'] ?>"
                                                class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input  status-website"
                                                    data-status="<?= $variant_group_item['website'] ?>"
                                                    data-id="<?= $variant_group_item['variant_group_id'] ?>"
                                                    id="chk_website_<?= $variant_group_item['variant_group_id'] ?>"
                                                    <?php if($variant_group_item['website'] == 1){ ?>checked
                                                    <?php } ?>>
                                                <label class="custom-control-label"
                                                    id="btn_website_<?= $variant_group_item['variant_group_id'] ?>"
                                                    for="chk_website_<?= $variant_group_item['variant_group_id'] ?>">
                                                    <?php if($variant_group_item['website'] == 1){ echo 'Aktif'; }else{ echo 'Pasif'; } ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="nk-tb-col tb-col-md">
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#mdl_variant_property_list_<?= $variant_group_item['variant_group_id'] ?>"
                                            class="btn btn-round btn-dim btn-outline-dark edit-action"><?= count($variant_property_items[$variant_group_item['variant_group_id']]); ?>
                                            Adet
                                        </a>
                                    </div>
                                    <div class="nk-tb-col nk-tb-col-tools  text-end">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#editVariantGroupModalForm"
                                            data-item-id="<?= $variant_group_item['variant_group_id'] ?>"
                                            data-title="<?= $variant_group_item['variant_title'] ?>"
                                            data-order="<?= $variant_group_item['order'] ?>"
                                            class="btn btn-round btn-icon btn-dim btn-outline-dark edit-action"><em
                                                class="icon ni ni-pen-alt-fill"></em></a>
                                        <a href="#"
                                            class="btn btn-round btn-icon btn-dim btn-outline-danger delete-action"
                                            data-bs-toggle="modal" data-bs-target="#modal_delete_variant_group"
                                            data-item-id="<?= $variant_group_item['variant_group_id'] ?>"><em
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
<?php foreach($variant_property_items as $variant_group_id => $variant_property_item){ 
    $variant_group_item = $variant_group_items[array_search($variant_group_id, array_column($variant_group_items, 'variant_group_id'))];
    $variant_group_title = $variant_group_item['variant_title'];
?>
<div class="modal fade" tabindex="-1" id="mdl_variant_property_list_<?= $variant_group_id ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom:0px;">
                <h5 class="modal-title"><?= $variant_group_title ?></h5>
                <a href="#" id="btn_hesaplar_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body p-0">
                <table class="datatable-init nowrap table mb-0" data-export-title="Export">
                    <thead>
                        <tr style="background-color: #ebeef2;">
                            <th style="background-color: #ebeef2; width:80px">Sıralama</th>
                            <th style="background-color: #ebeef2; width:80px" data-orderable="false">Kod</th>
                            <th style="background-color: #ebeef2;" data-orderable="false">Özellik Adı</th>
                            <th style="background-color: #ebeef2;" data-orderable="false">Varyant Adı</th>
                            <th style="background-color: #ebeef2;" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($variant_property_item as $property_item){ ?>
                        <tr>
                            <td><?= $property_item['order'] ?></td>
                            <td><?= $property_item['variant_property_code'] ?></td>
                            <td><?= $property_item['variant_property_title'] ?></td>
                            <td><?= $variant_group_title ?>
                            </td>
                            <td class="text-end">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#editVariantPropertyModalForm"
                                    data-parent-title="<?= $variant_group_title ?>"
                                    data-parent-id="<?= $variant_group_item['variant_group_id'] ?>"
                                    data-item-id="<?= $property_item['variant_property_id'] ?>"
                                    data-property-order="<?= $property_item['order'] ?>"
                                    data-property-code="<?= $property_item['variant_property_code'] ?>"
                                    data-property-title="<?= $property_item['variant_property_title'] ?>"
                                    class="btn btn-round btn-icon btn-xs btn-dim btn-outline-dark edit-property-action"><em
                                        class="icon ni ni-pen-alt-fill"></em></a>
                                <a href="#"
                                    class="btn btn-round btn-icon btn-xs btn-dim btn-outline-danger delete-property-action"
                                    data-bs-toggle="modal" data-bs-target="#modal_delete_variant_property"
                                    data-property-id="<?= $property_item['variant_property_id'] ?>"
                                    data-parent-title="<?= $variant_group_title ?>"
                                    data-parent-id="<?= $variant_group_item['variant_group_id'] ?>"><em
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
                        <button type="button" data-bs-toggle="modal" data-bs-target="#createVariantPropertyModalForm"
                            data-parent-title="<?= $variant_group_title ?>"
                            data-parent-id="<?= $variant_group_item['variant_group_id'] ?>"
                            class="btn btn-md btn-primary triggerModalCreateVariantProperty">YENİ
                            ÖZELLİK</button>
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

<!-- Create Variant Property Form -->
<div class="modal fade" id="createVariantPropertyModalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Özellik</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="createVariantPropertyForm" method="post"
                    class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="variant_group_title">Varyant Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="variant_group_title"
                                name="variant_group_title" required disabled value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label class="form-label" for="variant_property_order">Sıralama</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" id="variant_property_order"
                                    name="variant_property_order" required>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label class="form-label" for="variant_property_code">Kodu</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" id="variant_property_code"
                                    name="variant_property_code" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="variant_property_title">Özellik Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="variant_property_title"
                                name="variant_property_title" required>
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
                        <button type="button" id="variantPropertyOlustur"
                            class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal Form -->
<div class="modal fade" id="createVariantGroupModalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Varyant</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="createVariantGroupForm" method="post" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="create_variant_group_title">Varyant Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="create_variant_group_title"
                                name="variant_group_title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create_variant_group_order">Sıralama</label>
                        <div class="form-control-wrap">
                            <input type="text" name="variant_group_order" class="form-control form-control-xl"
                                id="create_variant_group_order" required>
                        </div>
                    </div>
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
                                            name="variant_group_status" id="create_variant_group_status_active"><label
                                            class="custom-control-label"
                                            for="create_variant_group_status_active">Aktif</label></div>
                                </li>
                                <li>
                                    <div class="custom-control custom-control-xl custom-radio"><input type="radio"
                                            class="custom-control-input" value="passive" name="variant_group_status"
                                            id="create_variant_group_status_passive">
                                        <label class="custom-control-label"
                                            for="create_variant_group_status_passive">Pasif</label>
                                    </div>
                                </li>
                            </ul>
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
                        <button type="button" id="variantGroupOlustur" class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal Form -->
<div class="modal fade" id="editVariantGroupModalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Varyant Düzenle</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="editVariantGroupForm" method="post" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="edit_variant_group_title">Varyant Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_variant_group_title"
                                name="variant_group_title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_variant_group_order">Sıralama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_variant_group_order"
                                name="variant_group_order" required>
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
                        <button type="button" id="variantGroupDuzenle" class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Variant Property Form -->
<div class="modal fade" id="editVariantPropertyModalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Özellik Düzenle</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="editVariantPropertyForm" method="post"
                    class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="edit_variant_property_parent_title">Varyant Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl"
                                id="edit_variant_property_parent_title" name="variant_group_title" required disabled
                                value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label class="form-label" for="edit_variant_property_order">Sıralama</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" id="edit_variant_property_order"
                                    name="variant_property_order" required>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label class="form-label" for="edit_variant_property_code">Kodu</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" id="edit_variant_property_code"
                                    name="variant_property_code" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_variant_property_title">Özellik Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl" id="edit_variant_property_title"
                                name="variant_property_title" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="close_modal_edit" class="btn btn-lg  btn-dim btn-outline-light"
                            data-bs-dismiss="modal">KAPAT</button>

                    </div>
                    <div class="col-md-8 text-end p-0">
                        <!-- <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ HESAP</button> -->
                        <button type="button" id="variantPropertyDuzenle"
                            class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'variant_group',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="#" data-bs-toggle="modal" data-bs-target="#createVariantGroupModalForm" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Varyant Ekle</a>
                                    <a href="#" onclick="location.reload()" class="btn btn-l btn-dim btn-outline-dark btn-block">Varyant Listesi</a>'
            ],
            'delete' => [
                'modal_title' => 'Bu Varyant Grubunu Silmek İstediğinize<br>Emin misiniz?',
                'modal_text' => 'Bu varyant grubunu silmeden önce lütfen yetkilinize danışınız.',
            ]
        ],
    ]
); ?>

<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'variant_property',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="#" data-bs-toggle="modal" data-bs-target="#createVariantPropertyModalForm" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Varyant Özelliği Ekle</a>
                                    <a href="#" onclick="location.reload()" class="btn btn-l btn-dim btn-outline-dark btn-block">Varyant Listesi</a>'
            ],
            'delete' => [
                'modal_title' => 'Bu Varyant Özelliğini Silmek İstediğinize<br>Emin misiniz?',
                'modal_text' => 'Bu varyant özelliğini silmeden önce lütfen yetkilinize danışınız.',
            ]
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
var item_id = 0;

$('#variantGroupOlustur').click(function(e) {
    if ($('#create_variant_group_title').val() == '') {
        swetAlert("Eksik Birşeyler Var", "Varyant Adı Giriniz.! ", "err");
    } else {
        var formData = $('#createVariantGroupForm').serializeArray();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.variant.create') ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    $("#createVariantGroupForm")[0].reset();
                    $('#createVariantGroupModalForm').modal('toggle');
                    $("#trigger_variant_group_ok_button").trigger("click");
                }
            }
        })
    }
});

$('.triggerModalCreateVariantProperty').on('click', function() {
    parent_id = $(this).attr('data-parent-id');
    parent_title = $(this).attr('data-parent-title');

    $('#close_modal_create').attr('data-parent-id', parent_id);
    $('#variant_group_title').val(parent_title);
    $('#createVariantPropertyForm').attr('data-parent-id', parent_id);
});

$('#variantPropertyOlustur').click(function(e) {
    $('#variant_group_title').val(parent_title)
    if ($('#variant_property_title').val() == '' ||
        $('#variant_property_order').val() == '' ||
        $('#variant_property_code').val() == ''
    ) {
        swetAlert("Eksik Birşeyler Var", "Varyant Adı Giriniz.! ", "err");
    } else {
        var formData = $('#createVariantPropertyForm').serializeArray();
        formData.push({
            name: 'variant_group_id',
            value: parent_id
        });
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.stocks.variant_property.create') ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    $("#createVariantPropertyForm")[0].reset();
                    $('#createVariantPropertyModalForm').modal('toggle');
                    $('#variant_group_title').val(parent_title)
                    $('#createVariantPropertyForm').attr('data-parent-id', parent_id)
                    $("#trigger_variant_property_ok_button").trigger("click");
                }else {
                    swetAlert("Hatalı Barkod Numarası", response['message'], "err");
                }
            }
        })
    }
});

$('.delete-action').on('click', function() {
    item_id = $(this).attr('data-item-id');
});

$('#modal_delete_variant_group_button').on('click', function() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.variant.delete') ?>',
        dataType: 'json',
        data: {
            variant_group_id: item_id,
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#editVariantGroupForm")[0].reset();
                $("#createVariantGroupForm")[0].reset();
                $("#trigger_variant_group_ok_button").trigger("click");
            } else{

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

$('.delete-property-action').on('click', function() {
    property_id = $(this).attr('data-property-id');
    parent_id = $(this).attr('data-parent-id');
    parent_title = $(this).attr('data-parent-title');

    $('#variant_group_title').val(parent_title);
    $('#createVariantPropertyForm').attr('data-parent-id', parent_id)
});

$('#modal_delete_variant_property_button').on('click', function() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.variant_property.delete') ?>',
        dataType: 'json',
        data: {
            variant_property_id: property_id,
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#editVariantPropertyForm")[0].reset();
                $("#createVariantPropertyForm")[0].reset();
                $("#trigger_variant_property_ok_button").trigger("click");

                $('#variant_group_title').val(parent_title);
                $('#createVariantPropertyForm').attr('data-parent-id', parent_id)
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

$('.edit-action').on('click', function() {
    item_id = $(this).attr('data-item-id');
    item_title = $(this).attr('data-title');
    item_order = $(this).attr('data-order');

    $('#edit_variant_group_title').val(item_title);
    $('#edit_variant_group_order').val(item_order);

    $('#variantGroupDuzenle').click(function(e) {
        if ($('#edit_variant_group_title').val() == '') {
            swetAlert("Eksik Birşeyler Var", "Varyant Adı Giriniz.! ", "err");
        } else {
            var formData = $('#editVariantGroupForm').serializeArray();
            formData.push({
                name: 'variant_group_id',
                value: item_id
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.stocks.variant.edit') ?>',
                dataType: 'json',
                data: formData,
                async: true,
                success: function(response) {
                    if (response['icon'] == 'success') {
                        $("#editVariantGroupForm")[0].reset();
                        $("#createVariantGroupForm")[0].reset();
                        $('#editVariantGroupModalForm').modal('toggle');
                        $("#trigger_variant_group_ok_button").trigger("click");
                    }
                }
            })
        }
    })
});

$('.edit-property-action').on('click', function() {
    parent_title = $(this).attr('data-parent-title');
    parent_id = $(this).attr('data-parent-id');
    item_id = $(this).attr('data-item-id');
    item_title = $(this).attr('data-property-title');
    item_code = $(this).attr('data-property-code');
    item_order = $(this).attr('data-property-order');

    $('#edit_variant_property_title').val(item_title);
    $('#edit_variant_property_code').val(item_code);
    $('#edit_variant_property_order').val(item_order);
    $('#edit_variant_property_parent_title').val(parent_title);
    $('#close_modal_edit').attr('data-parent-id', parent_id)

    $('#variantPropertyDuzenle').click(function(e) {
        if ($('#edit_variant_property_title').val() == '') {
            swetAlert("Eksik Birşeyler Var", "Varyant Adı Giriniz.! ", "err");
        } else {
            var formData = $('#editVariantPropertyForm').serializeArray();
            formData.push({
                name: 'variant_property_id',
                value: item_id
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.stocks.variant_property.edit') ?>',
                dataType: 'json',
                data: formData,
                async: true,
                success: function(response) {
                    if (response['icon'] == 'success') {
                        $("#editVariantPropertyForm")[0].reset();
                        $("#createVariantPropertyForm")[0].reset();
                        $('#editVariantPropertyModalForm').modal('toggle');
                        $("#trigger_variant_property_ok_button").trigger("click");
                    }
                }
            })
        }
    })
});

$('#close_modal_edit').on('click', function(){
    parent_id = $(this).attr('data-parent-id')
    $('#mdl_variant_property_list_'+parent_id).modal('toggle');
})

$('#close_modal_create').on('click', function(){
    parent_id = $(this).attr('data-parent-id')
    $('#mdl_variant_property_list_'+parent_id).modal('toggle');
})

$('.status-button').on('change', function() {
    if ($(this).data('status') == '0') {
        $('#btn_status_' + $(this).data('id')).html('Aktif');
        $(this).data('status', '1');
    } else {
        $('#btn_status_' + $(this).data('id')).html('Pasif');
        $(this).data('status', '0')
    }

    variant_group_id = $(this).data('id');
    status = $(this).data('status');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.variant.edit.status') ?>',
        dataType: 'json',
        data: {
            status: status,
            variant_group_id: variant_group_id
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#editVariantGroupForm")[0].reset();
                $("#createVariantGroupForm")[0].reset();
                $("#trigger_variant_group_ok_button").trigger("click");
            }
        }
    })
});

$('.status-b2b').on('change', function() {
    if ($(this).data('status') == '0') {
        $('#btn_b2b_' + $(this).data('id')).html('Aktif');
        $(this).data('status', '1');
    } else {
        $('#btn_b2b_' + $(this).data('id')).html('Pasif');
        $(this).data('status', '0')
    }

    variant_group_id = $(this).data('id');
    status = $(this).data('status');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.variant.edit.status_b2b') ?>',
        dataType: 'json',
        data: {
            status: status,
            variant_group_id: variant_group_id
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#editVariantGroupForm")[0].reset();
                $("#createVariantGroupForm")[0].reset();
                $("#trigger_variant_group_ok_button").trigger("click");
            }
        }
    })
});



$('.status-website').on('change', function() {
    if ($(this).data('status') == '0') {
        $('#btn_website_' + $(this).data('id')).html('Aktif');
        $(this).data('status', '1');
    } else {
        $('#btn_website_' + $(this).data('id')).html('Pasif');
        $(this).data('status', '0')
    }

    variant_group_id = $(this).data('id');
    status = $(this).data('status');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.stocks.variant.edit.status_website') ?>',
        dataType: 'json',
        data: {
            status: status,
            variant_group_id: variant_group_id
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                $("#editVariantGroupForm")[0].reset();
                $("#createVariantGroupForm")[0].reset();
                $("#trigger_variant_group_ok_button").trigger("click");
            }
        }
    })
});
</script>

<?= $this->endSection() ?>