<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Ürünler <?= $this->endSection() ?>
<?= $this->section('title') ?> Ürünler | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>






<div class="nk-content nk-content-fluid " >
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Ürünler</h3>
                        <!-- <div class="nk-block-des text-soft">
                          <p>You have total 2,595 users.</p>
                      </div> -->
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
                                            <select class="form-select js-select2" data-search="off" id="sltc_export" data-placeholder="Toplu İşlem">
                                                <option value="">Toplu İşlem</option>
                                                <option value="toExcel">İndir (Excel)</option>
                                                <option value="toPdf">İndir (PDF)</option>
                                                <option value="toPrint" disabled>Yazdır</option>
                                                <option value="#" disabled>Seçilenleri Sil</option>
                                            </select>
                                        </div>
                                        <div class="btn-wrap">
                                            <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light" id="applyExport">Uygula</button></span>
                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                        </div>
                                        <div class="btn-wrap">
                                            <span class="d-none d-md-block"> <a href="<?= route_to('tportal.stocks.substocksAll') ?>" class="btn btn-dim btn-outline-primary">Alt Ürünleri Gör</a> </span>
                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                        </div>

                                        <?php if(session()->get('user_id') == 12): ?>
                                            <div class="btn-wrap">
                                            <span class="d-none d-md-block"> <a  data-bs-toggle="modal" data-bs-target="#modalMytech" class="btn btn-dim btn-outline-secondary">  <em style="margin-top: -4px; margin-right: 5px;" class="icon ni ni-globe"></em>  Mytech Site</a> </span>
                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                        </div>
                                        <?php endif; ?>

                                        <?php if(session()->get('user_id') == 13): ?>
                                            <div class="btn-wrap">
                                            <span class="d-none d-md-block"> <a  data-bs-toggle="modal" data-bs-target="#modelArtliving" class="btn btn-dim btn-outline-secondary">  <em style="margin-top: -4px; margin-right: 5px;" class="icon ni ni-globe"></em>  Artliving B2B Site</a> </span>
                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                        </div>
                                        <?php endif; ?>

                                        <?php if(session()->get('user_id') == 5): ?>
                                            <div class="btn-wrap d-none">
                                            <span class="d-none d-md-block"> <a  data-bs-toggle="modal" data-bs-target="#mshDugmeModal" class="btn btn-dim btn-outline-secondary">  <em style="margin-top: -4px; margin-right: 5px;" class="icon ni ni-globe"></em>  Msh Düğme Satış Site</a> </span>
                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                        </div>
                                        <?php endif; ?>

                                        <?php if(session()->get('user_id') == 3 || session()->get('user_id') == 14 ): ?>
                                            <div class="btn-wrap ">
                                            <span class="d-none d-md-block"> <a  href="<?= route_to('tportal.stocks.depo_stoklari_say') ?>" class="btn btn-dim btn-outline-secondary">  <em style="margin-top: -4px; margin-right: 5px;" class="icon ni ni-layers"></em>  Stokları Say</a> </span>
                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                        </div>
                                        <?php endif; ?>

                                
                                        <div class="btn-wrap d-none excelAktar">
                                            <span class="d-none d-md-block"> <a data-bs-toggle="modal" data-bs-target="#modalExcel"  class="btn btn-dim btn-outline-primary">Excel İçeri Aktar</a> </span>
                                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
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
                                                                            <div class="col-6 d-none">
                                                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input" id="hasBalance">
                                                                                    <label class="custom-control-label" for="hasBalance"> Have
                                                                                        Balance</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6 d-none">
                                                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input" id="hasKYC">
                                                                                    <label class="custom-control-label" for="hasKYC"> KYC
                                                                                        Verified</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label class="overline-title overline-title-alt">Kategori</label>
                                                                                    <select class="form-select js-select2" id="category-filter-dropdown" data-ui="lg" data-search="on" data-placeholder="Seçiniz">
                                                                                        <option value="0" disabled selected>Seçiniz</option>
                                                                                        <?php foreach ($category_items as $category_item) { ?>
                                                                                            <option <?php if (isset($_GET['categoryId']) && $_GET['categoryId'] == $category_item['category_id']) {
                                                                                                        echo "selected";
                                                                                                    } ?> value="<?php echo $category_item['category_id'] ?>">
                                                                                                <?php echo $category_item['category_title'] ?>
                                                                                            </option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label class="overline-title overline-title-alt">Ürün Tipi</label>
                                                                                    <select class="form-select js-select2" id="type-filter-dropdown" data-ui="lg" data-search="on" data-placeholder="Seçiniz">
                                                                                        <option value="0" disabled selected>Seçiniz</option>
                                                                                        <?php foreach ($type_items as $type_item) { ?>
                                                                                            <option <?php if (isset($_GET['typeId']) && $_GET['typeId'] == $type_item['type_id']) {
                                                                                                        echo "selected";
                                                                                                    } ?> value="<?php echo $type_item['type_id'] ?>">
                                                                                                <?php echo $type_item['type_title'] ?>
                                                                                            </option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dropdown-foot between">
                                                                        <button class="btn btn-light" id="clearFilter">Filtreyi Temizle</button>
                                                                        <button class="btn btn-primary" id="applyFilter">Filtreyi Uygula</button>
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
                                        <th class="nk-tb-col"><span class="sub-text">Ürün</span></th>
                                        <!-- <th class="nk-tb-col tb-col-mb"><span class="sub-text">Kodu</span></th> -->
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">Kategori</span></th>
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">Stokta</span></th>
                                        <!-- <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">İşlemde</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">Toplam</span></th> -->
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">Alt Ürün</span></th>
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">Durum</span></th>
                                        <th class="nk-tb-col nk-tb-col-tools text-end" data-orderable="false"></th>
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

<?= $this->endSection() ?>

<?= $this->section('script') ?>


<?= view_cell('App\Libraries\ViewComponents::getComponent', ['component_name' => 'stoklar_excel_aktarma_famas']); ?>
<?= view_cell('App\Libraries\ViewComponents::getComponent', ['component_name' => 'stoklar_mytechbilisim']); ?>
<?= view_cell('App\Libraries\ViewComponents::getComponent', ['component_name' => 'stoklar_artliving']); ?>
<?= view_cell('App\Libraries\ViewComponents::getComponent', ['component_name' => 'stoklar_mshdugme']); ?>


<script>
    // Apply the saved filtering state when the page is loaded
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
                url: base_url + '/tportal/stock/getStock/'+lastPart,
                data: function(d) {
                    d.category_id = $('#category-filter-dropdown').find(':selected').val();
                    d.type_id = $('#type-filter-dropdown').find(':selected').val();
                }
            },
            order: [
                [2, 'asc']
            ],
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
                $(row).on('click', function() {
                // Burada 'data.id' örneğin veritabanından gelen bir ID olabilir. URL'yi kendi durumuna göre güncelle.
                window.location.href = '../detail/' + data.stock_id;
                });
            },
            columns: [{
                    data: null,
                    className: 'nk-tb-col',
                    render: function(data) {

                        return `
                        <div class="custom-control custom-control-sm custom-checkbox notext datatable-checkbox-container">
                            <input type="checkbox" class="custom-control-input datatable-checkbox" data-id="${data.stock_id}" data-stock-no="${data.stock_id}" id="stockRow_${data.stock_id}">
                            <label class="custom-control-label datatable-checkbox-label" for="stockRow_${data.stock_id}"></label>
                        </div>`
                    }
                },
                {
                    data: null,
                    name: 'stock_image',
                    className: 'nk-tb-col tb-col-lg',
                    render: function(data) {

                        return `
                        <td class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-avatar">
                                    <img class="w-100 h-100" src="${ base_url+"/"+data.default_image }" alt="${ data.stock_title }">
                                </div>
                                <div class="user-info">
                                    <span class="lead-text">${ data.stock_title }</span>
                                    <span class="sub-text">${ data.stock_code }</span>
                                </div>
                            </div>
                        </td>
                            `;
                    }
                },
                {
                    data: null,
                    name: 'category_title',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data) {
                        return `
                        <td class="nk-tb-col tb-col-lg">
                            <span class="tb-amount">${ data.category_title }</span>
                            <span class="sub-text">${ data.type_title == null ? '-' : data.type_title }</span>
                        </td>
                        `;
                    }
                },
                {
                    data: null,
                    name: 'stock_amount',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data) {
                        //data.stock_quantity ? parseFloat(data.stock_quantity).toLocaleString('tr-TR') : 0 }
                        return `

                        <td class="nk-tb-col tb-col-md"> 
                            <span class="tb-amount">${ data.stock_total_quantity == 0 || data.stock_total_quantity == null ? '0' : numberFormat(data.stock_total_quantity,2,',','.') }</span>
                            <span class="currency">${ data.buy_unit_title } </span>
                        </td>

                        `;
                    }
                },
                // {
                //     data: null,
                //     name: 'stock_amount',
                //     className: 'nk-tb-col tb-col-md',
                //     render: function(data) {

                //         return `

                //         <td class="nk-tb-col tb-col-md">
                //             <span class="tb-amount">0</span>
                //             <span class="currency">${ data.buy_unit_title } </span>
                //         </td>

                //         `;
                //     }
                // },
                // {
                //     data: null,
                //     name: 'stock_amount',
                //     className: 'nk-tb-col tb-col-md',
                //     render: function(data) {

                //         return `

                //         <td class="nk-tb-col tb-col-md">
                //             <span class="tb-amount">${ data.stock_total_quantity == 0 || data.stock_total_quantity == null ? '0' : numberFormat(data.stock_total_quantity,2,',','.') }</span>
                //             <span class="currency">${ data.buy_unit_title } </span>
                //         </td>

                //         `;
                //     }
                // },
                {
                    data: null,
                    name: 'stock_amount',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data) {

                        return `

                        <td class="nk-tb-col tb-col-md">
                            <span class="tb-amount">${ data.substock_count == 0 || data.substock_count == null ? '0' : data.substock_count }</span>
                            <span class="currency">Adet</span>
                        </td>

                        `;
                    }
                },

                {
                    data: null,
                    name: 'stock_status',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data) {


                        if (data.status == 'processing') {
                            var statusText = "İşlemde";
                            var statusTextColor = "text-warning";
                        } else if (data.status == 'critical') {
                            var statusText = "Kritik";
                            var statusTextColor = "text-danger";
                        } else if (data.status == 'active') {
                            var statusText = "Aktif";
                            var statusTextColor = "text-success";
                        } else if (data.status == 'passive') {
                            var statusText = "Pasif";
                            var statusTextColor = "text-secondary";
                        }

                        return `

                        <td class="nk-tb-col tb-col-md">
                            <span class="tb-status ${ statusTextColor }">${ statusText }</span>
                        </td>
                        `;
                    }
                },
                {
                    data: null,
                    name: 'cari_phone',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data) {
                        return `
                        <td class="nk-tb-col nk-tb-col-tools  text-end">
                            <a href="../detail/${data.stock_id}" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                        </td>
                        `;
                    }
                },
            ],

        });



        //stock search input
        $('#stock_input_search').keyup(function() {
            var searchWord = $(this).val().toLocaleUpperCase('tr-TR');

            var table = $('#datatableStock').DataTable();
            table.search(searchWord).draw();

            localStorage.setItem('datatableStock_filter_search', searchWord);

            $('#stock_input_search').val(searchWord);

            if (this.value.length > 0) {
                $('#notification-dot-search').removeClass('d-none');
            } else {
                $('#notification-dot-search').addClass('d-none');
            }

        });

        //stock search clear
        $('#stock_input_search_clear_button').on('click', function(e) {
            var table = $('#datatableStock').DataTable();

            $('#notification-dot-search').addClass('d-none');
            $('#stock_input_search').val('');
            localStorage.removeItem('datatableStock_filter_search');

            table.state.clear();
            table.ajax.reload();

            table.search('').draw();
            console.log("arama kelimesi temizlendi");

        });




        //stock filter
        $('#applyFilter').on('click', function() {
            var categoryId = $('#category-filter-dropdown').find(':selected').val();
            var typeId = $('#type-filter-dropdown').find(':selected').val();

            var table = $('#datatableStock').DataTable();
            table.column(2).search(status).draw();

            localStorage.setItem('datatableStock_filter_categoryId', categoryId);
            localStorage.setItem('datatableStock_filter_typeId', typeId);

            $('#notification-dot').removeClass('d-none');
        });


        //stock filter clear
        $('#clearFilter').on('click', function(e) {

            $('#category-filter-dropdown').val(0);
            $('#category-filter-dropdown').trigger('change');

            $('#type-filter-dropdown').val(0);
            $('#type-filter-dropdown').trigger('change');

            $('#notification-dot').addClass('d-none');

            var table = $('#datatableStock').DataTable();

            localStorage.removeItem('datatableStock_filter_categoryId');
            localStorage.removeItem('datatableStock_filter_typeId');

            table.state.clear();
            table.ajax.reload();

            console.log("filtre temizlendi");
        });



        $("#applyExport").on("click", function() {

            var sltd_value = $('#sltc_export').find(':selected').val();
            var table = $('#datatableStock').DataTable();

            if (sltd_value == "toExcel") {
                table.button('.buttons-excel').trigger();
                console.log("excel için hazırlanıyorr");
            } else if (sltd_value == "toPdf") {
                table.button('.buttons-pdf').trigger();
                console.log("pdf için hazırlanıyorr");
            } else if (sltd_value == "toPrint") {
                table.button('.buttons-print').trigger();
                console.log("yazdırmak için hazırlanıyorr");
            } else {
                console.log("işlem yok");
            }

        });

        var table = $('#datatableStock').DataTable();

        $(document).ajaxComplete(function () {
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
            selectAll = false;
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
            var rows = $('#datatableStock').DataTable().rows().nodes();
        });

    });
</script>

<?= $this->endSection() ?>