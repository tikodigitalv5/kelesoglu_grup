<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>
<?= $this->section('title') ?>
<?= $page_title ?> |
<?= session()->get('user_item')['firma_adi'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>




<?= $this->section('main') ?>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">
                            <?= $page_title ?>
                        </h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon  toggle-expand me-n1" data-target="pageMenu"><em
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
                                            <select class="form-select js-select2" data-search="off" id="sltc_export"
                                                data-placeholder="Toplu İşlem">
                                                <option value="">Toplu İşlem</option>
                                                <option value="toExcel">İndir (Excel)</option>
                                                <option value="toPdf">İndir (PDF)</option>
                                                <option value="toPrint" disabled>Yazdır</option>
                                                <option value="#" disabled>Seçilenleri Sil</option>
                                            </select>
                                        </div>
                                        <div class="btn-wrap">
                                            <span class="d-none d-md-block"><button
                                                    class="btn btn-dim btn-outline-light"
                                                    id="applyExport">Uygula</button></span>
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
                                                data-target="search">
                                                <div class="dot dot-primary d-none" id="notification-dot-search"></div>
                                                <em class="icon ni ni-search"></em>
                                            </a>
                                        </li><!-- li -->
                                        <li class="btn-toolbar-sep"></li><!-- li -->
                                        <li>
                                            <div class="toggle-wrap">
                                                <a href="#" class="btn btn-icon  toggle" data-target="cardTools"><em
                                                        class="icon ni ni-menu-right"></em></a>
                                                <div class="toggle-content" data-content="cardTools">
                                                    <ul class="btn-toolbar gx-1">
                                                        <li class="toggle-close">
                                                            <a href="#" class="btn btn-icon  toggle"
                                                                data-target="cardTools"><em
                                                                    class="icon ni ni-arrow-left"></em></a>
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn  btn-icon dropdown-toggle"
                                                                    data-bs-toggle="dropdown">
                                                                    <div class="dot dot-primary d-none"
                                                                        id="notification-dot"></div>
                                                                    <em class="icon ni ni-filter"></em>
                                                                </a>
                                                                <div
                                                                    class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                                    <div class="dropdown-head">
                                                                        <span class="sub-title dropdown-title">Detaylı
                                                                            Arama</span>
                                                                        <div class="dropdown">
                                                                            <a href="#"
                                                                                class=" d-none btn btn-sm btn-icon">
                                                                                <em class="icon ni ni-more-h"></em>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dropdown-body dropdown-body-rg">
                                                                        <div class="row gx-6 gy-3">
                                                                            <div class="col-6 d-none">
                                                                                <div
                                                                                    class="custom-control custom-control-sm custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        class="custom-control-input"
                                                                                        id="hasBalance">
                                                                                    <label class="custom-control-label"
                                                                                        for="hasBalance"> Have
                                                                                        Balance</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6 d-none">
                                                                                <div
                                                                                    class="custom-control custom-control-sm custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        class="custom-control-input"
                                                                                        id="hasKYC">
                                                                                    <label class="custom-control-label"
                                                                                        for="hasKYC"> KYC
                                                                                        Verified</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6 d-none">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        class="overline-title overline-title-alt">Kategori</label>
                                                                                    <select
                                                                                        class="form-select js-select2"
                                                                                        id="category-filter-dropdown">
                                                                                        <option value="0" selected
                                                                                            disabled>Seçiniz</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        class="overline-title overline-title-alt">Fatura
                                                                                        Tipi</label>
                                                                                    <select
                                                                                        class="form-select js-select2"
                                                                                        id="invoice-type-filter-dropdown"
                                                                                        data-ui="lg">
                                                                                        <option value="0" selected
                                                                                            disabled>Seçiniz</option>
                                                                                        <option
                                                                                            value="incoming_invoice">
                                                                                            Alış</option>
                                                                                        <option
                                                                                            value="outgoing_invoice">
                                                                                            Satış</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dropdown-foot between">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            id="applyFilter">Filtrele</button>
                                                                        <button type="button" class="btn btn-light"
                                                                            id="clearFilter">Filtreyi Sıfırla</button>

                                                                        <!-- <a href="#">Filtreyi Kaydet</a> -->
                                                                    </div>
                                                                </div><!-- .filter-wg -->
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn  btn-icon dropdown-toggle"
                                                                    data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-filter-alt"></em>
                                                                </a>
                                                                <div
                                                                    class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                                                    <ul class="link-check">
                                                                        <li><span>Sayfalama</span></li>
                                                                        <li><a href="javascript:;" id="row-10">10</a>
                                                                        </li>
                                                                        <li><a href="javascript:;" id="row-25">25</a>
                                                                        </li>
                                                                        <li><a href="javascript:;" id="row-50">50</a>
                                                                        </li>
                                                                        <li><a href="javascript:;" id="row-100">100</a>
                                                                        </li>
                                                                        <li><a href="javascript:;" id="row-200">200</a>
                                                                        </li>
                                                                        <li><a href="javascript:;"
                                                                                id="row-1000">1000</a></li>
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
                                        <a href="#" class="search-back btn btn-icon toggle-search"
                                            data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" id="invoice_input_search"
                                            class="form-control border-transparent form-focus-none"
                                            placeholder="Bulmak istediğiniz faturanın fatura ünvanını veya fatura numarasını yazınız...">
                                        <a href="#" class="btn btn-icon toggle-search active" data-target="search"
                                            style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em
                                                class="icon ni ni-cross"></em></a>
                                        <button class="search-submit btn btn-icon" style="margin-right: 50px;"
                                            id="invoice_input_search_clear_button"
                                            name="invoice_input_search_clear_button"><em
                                                class="icon ni ni-trash"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div><!-- .card-inner -->


                        <div class="card-inner p-0">
                            <table id="datatableInvoice" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                <thead>
                                    <tr class="nk-tb-item nk-tb-head tb-tnx-head">
                                        <th class="nk-tb-col nk-tb-col-check">
                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="selectAllInvoice">
                                                <label class="custom-control-label" for="selectAllInvoice"></label>
                                            </div>
                                        </th>

                                        <th class="nk-tb-col"><span class="sub-text">FATURA TARİHİ </span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                class="sub-text">FATURA NUMARASI</span></th>
                                        <th class="nk-tb-col tb-col-md" data-orderable="false" style="min-width:120px">
                                            <span class="sub-text">DURUM</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                class="sub-text">FATURA UNVAN</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false" style="min-width:120px"><span
                                                class="sub-text">FATURA TİPİ</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                class="sub-text">ARA TOPLAM </span></th>
                                                <?php if(session()->get('user_id') == 5): ?>
                                                    <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                    class="sub-text">İSK TOPLAM </span></th>
                                                    <?php endif; ?>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                class="sub-text">KDV TOPLAM </span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                class="sub-text">GENEL TOPLAM </span></th>
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

<script>
    // $(".nk-tb-item").click(function() {
    //     // alert($(this).data('url'));
    //     window.location.href = $(this).data('url');
    // });

    $(".custom-control-input").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(document).ready(function () {

        var base_url = window.location.origin;

        var url = window.location.pathname;
        var parts = url.split('/');
        var lastPart = parts[parts.length - 1];

        var myVar = $("#DataTables_Table_0_wrapper").find('.with-export').removeClass('d-none');
        var myVar2 = $("#DataTables_Table_0_wrapper").find('.with-export').css("margin-bottom", "10px");

        var table = NioApp.DataTable('#datatableInvoice', {
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: base_url + '/tportal/reports/outgoing_datatable',
                data: function (d) {
                    d.invoice_status = $('#invoice-type-filter-dropdown').find(':selected').val()
                }
            },
            pageLength: 15,
            search: true,
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
                orderable: true,
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
                // console.log(data);
            },
            columns: [{
                data: null,
                className: 'nk-tb-col',
                render: function (data) {

                    return `
                        <div class="custom-control custom-control-sm custom-checkbox notext datatable-checkbox-container">
                            <input type="checkbox" class="custom-control-input datatable-checkbox" data-id="${data.invoice_id}" data-fatura-no="${data.invoice_id}" id="faturaRow${data.invoice_id}">
                            <label class="custom-control-label datatable-checkbox-label" for="faturaRow${data.invoice_id}"></label>
                        </div>`
                }
            },

            {
                data: null,
                name: 'cari_phone',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {

                    var currentdate = new Date(data.invoice_date);

                    var date = currentdate.getDate().toString().padStart(2, '0') + "/" + (currentdate.getMonth() + 1).toString().padStart(2, '0') + "/" + currentdate.getFullYear();
                    var time = currentdate.getHours().toString().padStart(2, '0') + ":" + currentdate.getMinutes().toString().padStart(2, '0') + ":" + currentdate.getSeconds().toString().padStart(2, '0');

                    return `

                        <td class="nk-tb-col tb-col-lg">
                            <div class="user-info">
                                <span class="tb-lead">${date}</span>
                            </div>
                        </td>
                        `;
                }
            },
            {
                data: null,
                name: 'cari_phone',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {
                    return `

                        <td class="nk-tb-col tb-col-lg">
                            <div class="user-info">
                                <span class="tb-lead">${data.sale_type == "quick" ? "#PROFORMA" : data.invoice_no} <span class="dot dot-warning d-md-none ms-1"></span></span>
                            </div>
                        </td>
                        `;
                }
            },

            {
                data: null,
                name: 'cari_phone',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {
                    return `
                        <td class="nk-tb-col tb-col-lg">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead"><span class="dot dot-${data.status_info}"></span> ${data.status_name} </span>
                                                        </div>
                                                    </div>
                                                </td>
                        `;
                }
            },
            {
                data: null,
                name: 'invoice_title',
                className: 'nk-tb-col tb-col-lg',
                render: function (data) {

                    return `
                            <td class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-info">
                                        <span class="tb-lead">${data.cari_invoice_title}</span>
                                    </div>
                                </div>
                            </td>
                            `;
                }
            },
            {
                data: null,
                name: 'cari_phone',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {
                    var invoice_scenario = data.invoice_scenario;
                    var invoice_scenario_text = '';

                    if (invoice_scenario == "TEMELFATURA") {
                        invoice_scenario_text = "Temel Fatura";
                    } else if (invoice_scenario == "TICARIFATURA") {
                        invoice_scenario_text = "Ticari Fatura";
                    } else if (invoice_scenario == "EARSIVFATURA") {
                        invoice_scenario_text = "E-Arşiv Fatura";
                    } else if (invoice_scenario == "KAMU") {
                        invoice_scenario_text = "Kamu";
                    } else if (invoice_scenario == "IHRACAT") {
                        invoice_scenario_text = "İhracat";
                    }

                    return `
                        <td class="nk-tb-col tb-col-lg">
                            <span class="tb-lead">${data.invoice_direction == 'incoming_invoice' ? "Alış" : "Satış"}</span>
                            <span> ${ invoice_scenario_text } </span>
                        </td>
                        `;
                }
            },
            {
                data: null,
                name: 'cari_phone',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {
                    return `
                        <td class="nk-tb-col tb-col-lg">
                            <span class="tb-lead">${data.money_icon + ' ' + numberFormat(data.sub_total, 2, '.', ',')}</span>
                        </td>
                        `;
                }
            },
            {
                data: null,
                name: 'discount_total',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {
                    
                    return `<td class="nk-tb-col tb-col-lg"><span class="tb-lead">${data.money_icon + ' ' + numberFormat(data.discount_total ?? 0, 2, '.', ',')}</span></td>`;

                }
            },
            {
                data: null,
                name: 'isk_toplam',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {
                    if (data.money_unit_id == 3) {
                        var tax_1 = data.tax_rate_1_amount;
                        var tax_10 = data.tax_rate_10_amount;
                        var tax_20 = data.tax_rate_20_amount;


                        var toplam_kdv = (parseFloat(tax_1) + parseFloat(tax_10) + parseFloat(tax_20));
                        // console.log("toplam_kdv", toplam_kdv);


                        return `<td class="nk-tb-col tb-col-lg"><span class="tb-lead">${data.money_icon + ' ' + numberFormat(toplam_kdv, 2, '.', ',')}</span></td>`;
                    }
                    else {
                        var tax_1 = data.tax_rate_1_amount_try;
                        var tax_10 = data.tax_rate_10_amount_try;
                        var tax_20 = data.tax_rate_20_amount_try;


                        var toplam_kdv = (parseFloat(tax_1) + parseFloat(tax_10) + parseFloat(tax_20));

                        return `<td class="nk-tb-col tb-col-lg"><span class="tb-lead">${data.money_icon + ' ' + numberFormat(toplam_kdv, 2, '.', ',')}</span></td>`;

                    }
                }
            },
            {
                data: null,
                name: 'cari_phone',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {
                    if (data.money_unit_id == 3)
                        return `<td class="nk-tb-col tb-col-lg"><span class="tb-lead">${data.money_icon + ' ' + numberFormat(data.amount_to_be_paid, 2, '.', ',')}</span></td>`;
                    else
                        return `<td class="nk-tb-col tb-col-lg"><span class="tb-lead">${data.money_icon + ' ' + numberFormat(data.amount_to_be_paid_try, 2, '.', ',')}</span></td>`;
                }
            },
            ],
        });



        //fatura arama input
        $('#invoice_input_search').keyup(function () {
            var searchWord = $(this).val().toLocaleUpperCase('tr-TR');

            var table = $('#datatableInvoice').DataTable();
            table.search(searchWord).draw();

            localStorage.setItem('datatableInvoice_filter_search', searchWord);


            if (this.value.length > 0) {
                $('#notification-dot-search').removeClass('d-none');
            } else {
                $('#notification-dot-search').addClass('d-none');
            }

        });

        //fatura arama temizleme
        $('#invoice_input_search_clear_button').on('click', function (e) {
            var table = $('#datatableInvoice').DataTable();

            $('#notification-dot-search').addClass('d-none');
            $('#invoice_input_search').val('');

            localStorage.removeItem('datatableInvoice_filter_search');

            table.state.clear();
            table.ajax.reload();

            table.search('').draw();
            console.log("arama kelimesi temizlendi");
        });

        //fatura filtreleme
        $('#applyFilter').on('click', function (e) {
            var invoice_status = $('#invoice-type-filter-dropdown').find(':selected').val();
            console.log("uygulanacak filtre", invoice_status);

            $('#notification-dot').removeClass('d-none');

            var table = $('#datatableInvoice').DataTable();
            table.column(4).search('').draw();

            localStorage.setItem('datatableInvoice_filter_status', invoice_status);

            console.log("fatura filtre başladı");

        });

        //fatura filter clear
        $('#clearFilter').on('click', function (e) {

            $('#invoice-type-filter-dropdown').val(0);
            $('#invoice-type-filter-dropdown').trigger('change');

            $('#notification-dot').addClass('d-none');

            var table = $('#datatableInvoice').DataTable();

            localStorage.removeItem('datatableInvoice_filter_status');

            table.state.clear();
            table.ajax.reload();

            console.log("fatura filtre temizlendi");
        });

        $("#applyExport").on("click", function () {
            var sltd_value = $('#sltc_export').find(':selected').val();
            var table = $('#datatableInvoice').DataTable();

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

        var table = $('#datatableInvoice').DataTable();

        $(document).ajaxComplete(function () {
            console.log("fatura yüklendi, ajax bitti");
        });
        $('#row-10').on('click', function () {
            table.page.len(10).draw();
        });
        $('#row-25').on('click', function () {
            table.page.len(25).draw();
        });
        $('#row-50').on('click', function () {
            table.page.len(50).draw();
        });
        $('#row-100').on('click', function () {
            table.page.len(100).draw();
        });
        $('#row-200').on('click', function () {
            table.page.len(200).draw();
        });
        $('#row-1000').on('click', function () {
            table.page.len(1000).draw();
        });

        $('#selectAllInvoice').on('click', function () {
            selectAll = false;
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
            var rows = $('#datatableInvoice').DataTable().rows().nodes();
        });

    });
</script>

<?= $this->endSection() ?>