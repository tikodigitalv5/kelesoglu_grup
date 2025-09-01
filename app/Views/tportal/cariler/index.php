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


<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js">

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
                            <a href="#" class="btn btn-icon toggle-expand me-n1" data-target="pageMenu"><em
                                    class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li><a href="#" class="btn btn-white btn-outline-light"><em
                                                class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                    <li class="nk-block-tools-opt">
                                        <div class="drodown">
                                            <a href="#" class="btn btn-icon btn-primary"
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
               
                <?php if(session()->get('user_id') == 5): ?>
                    <div class="card-inner-group d-flex justify-content-end " style="margin-top: 10px; margin-right: 10px;">
                <div class="" style="margin-right: 10px;">
                            <a href="<?= route_to('tportal.cariler.tekrarEdenKayitlar') ?>" target="_blank" class="btn btn-primary">
                                <em class="icon ni ni-merge"></em>
                                <span>Tekrar Eden Kayıtlar</span>
                            </a>
                        </div>
                        <div class="d-none">
                            <a href="<?= route_to('tportal.cariler.vknBirlesimModal') ?>" target="_blank" class="btn btn-primary">
                                <em class="icon ni ni-merge"></em>
                                <span>VKN Birleştirme</span>
                            </a>
                        </div>
                </div>
                <?php endif; ?>
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                    <div class="form-inline flex-nowrap gx-3">
                                        <div class="form-wrap w-150px">
                                            <select class="form-select toplu_islem js-select2" data-search="off"
                                                data-placeholder="Toplu İşlem">
                                                <option value="">Toplu İşlem</option>
                                                <option value="<?php echo route_to('tportal.cariler.exportExcel'); ?>">İndir (Excel)</option>
                                                <option value="#">İndir (PDF)</option>
                                                <option value="#">Yazdır</option>
                                                <option value="#">Seçilenleri Sil</option>
                                            </select>
                                        </div>
                                        <div class="btn-wrap">
                                            <span class="d-none d-md-block"><a
                                                    id="indirButton" class="btn btn-dim btn-outline-light disabled">Uygula</a></span>

                                                  

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
                                                <a href="#" class="btn btn-icon toggle" data-target="cardTools"><em
                                                        class="icon ni ni-menu-right"></em></a>
                                                <div class="toggle-content" data-content="cardTools">
                                                    <ul class="btn-toolbar gx-1">
                                                        <li class="toggle-close">
                                                            <a href="#" class="btn btn-icon toggle"
                                                                data-target="cardTools"><em
                                                                    class="icon ni ni-arrow-left"></em></a>
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon dropdown-toggle"
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
                                                                                        class="overline-title overline-title-alt">Durum</label>
                                                                                    <select
                                                                                        class="form-select js-select2"
                                                                                        id="status-filter-dropdown"
                                                                                        data-ui="lg">
                                                                                        <option value="0" selected
                                                                                            disabled>Seçiniz</option>
                                                                                        <option value="Borçlu">Borçlu
                                                                                        </option>
                                                                                        <option value="Alacaklı">
                                                                                            Alacaklı</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dropdown-foot between">
                                                                        <button class="btn btn-light"
                                                                            id="clearFilter">Filtreyi Temizle</button>
                                                                        <button class="btn btn-primary"
                                                                            id="applyFilter">Filtreyi Uygula</button>
                                                                    </div>
                                                                </div><!-- .filter-wg -->
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon dropdown-toggle"
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
                                        <input type="text" id="cariler_input_search"
                                            class="form-control border-transparent form-focus-none"
                                            placeholder="Bulmak istediğiniz carinin adını yazınız...">
                                        <a href="#" class="btn btn-icon toggle-search active" data-target="search"
                                            style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em
                                                class="icon ni ni-cross"></em></a>
                                        <button class="search-submit btn btn-icon" style="margin-right: 50px;"
                                            id="cariler_input_search_clear_button"
                                            name="cariler_input_search_clear_button"><em
                                                class="icon ni ni-trash"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div><!-- .card-inner -->


                        <div class="card-inner p-0">
                            <table id="datatableCari" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                <thead>
                                    <tr class="nk-tb-item nk-tb-head tb-tnx-head">
                                        <th class="nk-tb-col nk-tb-col-check">
                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                <input type="checkbox" class="custom-control-input" id="selectAllCari">
                                                <label class="custom-control-label" for="selectAllCari"></label>
                                            </div>
                                        </th>

                                        <th class="nk-tb-col"><span class="sub-text">Ünvan / Yetkili</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                class="sub-text">İletişim</span></th>
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span
                                                class="sub-text">Bakiye</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span
                                                class="sub-text">Durum</span></th>
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

<script>
    // $(".nk-tb-item").click(function() {
    //     // alert($(this).data('url'));
    //     window.location.href = $(this).data('url');
    // });
</script>

<script type="text/javascript">
    $(document).ready(function () {

        // Seçili cari ID'lerini tutacak dizi
        var selectedCariIds = [];

        // Tekli checkbox değişikliklerini dinle
        $(document).on('change', '.datatable-checkbox', function() {
            var cariId = $(this).data('id');
            
            if (this.checked) {
                // ID'yi listeye ekle
                if (!selectedCariIds.includes(cariId)) {
                    selectedCariIds.push(cariId);
                }
            } else {
                // ID'yi listeden çıkar
                selectedCariIds = selectedCariIds.filter(id => id !== cariId);
            }
            
            console.log("Seçili ID'ler:", selectedCariIds);
            updateSelectedStatus();
        });

        // Tümünü seç checkbox'ı için
        $('#selectAllCari').on('change', function() {
            var rows = $('#datatableCari').DataTable().rows().nodes();
            var checked = this.checked;
            
            selectedCariIds = []; // Listeyi temizle
            
            $('input.datatable-checkbox', rows).each(function() {
                this.checked = checked;
                var cariId = $(this).data('id');
                if (checked && cariId) {
                    selectedCariIds.push(cariId);
                }
            });
            
            console.log("Tümü seçildi - Seçili ID'ler:", selectedCariIds);
            updateSelectedStatus();
        });

        // Seçili durumu güncelle
        function updateSelectedStatus() {
            if (selectedCariIds.length > 0) {
                $("#indirButton").removeClass("disabled");
                // Seçili toplu işlem varsa URL'yi güncelle
                var selectedValue = $('.toplu_islem').val();
                if (selectedValue && selectedValue !== '#') {
                    var urlWithIds = selectedValue + '?ids=' + selectedCariIds.join(',');
                    $('#indirButton').attr('href', urlWithIds);
                }
                console.log(`${selectedCariIds.length} cari seçildi:`, selectedCariIds);
            } else {
                $("#indirButton").addClass("disabled");
                $("#indirButton").prop("href", "#");
            }
        }

        $('.toplu_islem').on('change', function() {
            var selectedValue = $(this).val();
            
            // Seçili ID'leri kontrol et
            if (selectedCariIds.length === 0) {
                toastr.warning("Lütfen en az bir cari seçiniz.");
                $("#indirButton").addClass("disabled");
                $("#indirButton").prop("href", "#");
                return;
            }

            // Eğer seçilen değer boşsa butonu devre dışı bırak
            if (selectedValue == '#') {
                $("#indirButton").addClass("disabled");
                $("#indirButton").prop("href", "#");
                return;
            }

            // URL'ye seçili ID'leri ekle
            var urlWithIds = selectedValue + '?ids=' + selectedCariIds.join(',');
            
            // Butonu etkinleştir
            $("#indirButton").removeClass("disabled");
            $('#indirButton').attr('href', urlWithIds);
        });

        var search_text = localStorage.getItem('datatableCari_filter_search');
        var status = localStorage.getItem('datatableCari_filter_status');

        console.log("search_text", search_text);
        console.log("status", status);

        if (search_text) {
            $('#notification-dot-search').removeClass('d-none');
            $('#cariler_input_search').val(search_text);
        }
        if (status) {
            $('#notification-dot').removeClass('d-none');
            $('#status-filter-dropdown').val(status);
            $('#status-filter-dropdown').trigger('change');
        }
    });


    $(document).ready(function () {

        number_format = function (number, decimals, dec_point, thousands_sep) {
            number = parseFloat(number);
            number = number.toFixed(decimals);


            var nstr = number.toString();
            nstr += '';
            x = nstr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? dec_point + x[1] : '';
            var rgx = /(\d+)(\d{3})/;

            while (rgx.test(x1))
                x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

            return x1 + x2;
        }

        var base_url = window.location.origin;

        var url = window.location.pathname;
        var parts = url.split('/');
        var lastPart = parts[parts.length - 1];

        console.log(lastPart);

        var myVar = $("#DataTables_Table_0_wrapper").find('.with-export').removeClass('d-none');
        var myVar2 = $("#DataTables_Table_0_wrapper").find('.with-export').css("margin-bottom", "10px");

        var table = NioApp.DataTable('#datatableCari', {
            processing: true,
            serverSide: true,
            stateSave: true,
      
            ajax: {
                url: base_url + '/tportal/cari/getcustomers/' + lastPart,
                data: function (d) {
                    d.cari_status = $('#status-filter-dropdown').find(':selected').val();
                }
            },
            pageLength: 15,
            search: true,
            
            stateDuration: 15,
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
                window.location.href = '../detail/' + data.cari_id;
                });
            },
            columns: [{
                data: null,
                className: 'nk-tb-col',
                render: function (data) {

                    return `
                        <div class="custom-control custom-control-sm custom-checkbox notext datatable-checkbox-container">
                            <input type="checkbox" class="custom-control-input datatable-checkbox" data-id="${data.cari_id}" data-fatura-no="${data.cari_id}" id="faturaRow${data.cari_id}">
                            <label class="custom-control-label datatable-checkbox-label" for="faturaRow${data.cari_id}"></label>
                        </div>`
                }
            },
            {
                data: null,
                name: 'invoice_title',
                className: 'nk-tb-col tb-col-lg',
                render: function (data) {


                    var cari_balance = data.cari_balance;
                    var balanceColor = (data.cari_balance == 0) ? "text-secondary" : (data.cari_balance > 0 ? "text-success" : "text-danger");
                    var balanceBgColor = (data.cari_balance == 0) ? "bg-secondary-dim" : (data.cari_balance > 0 ? "bg-success-dim" : "bg-danger-dim");
                    var balanceText = (data.cari_balance == 0) ? "-" : (data.cari_balance > 0 ? "Borçlu" : "Alacaklı");

                    return `
                            <td class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar ${balanceBgColor} sq">
                                        <span>${data.invoice_title == '' ? data.name.substring(0, 1) : data.invoice_title.substring(0, 1)} </span>
                                    </div>
                                    <div class="user-info">
                                        <a href="${data.cari_id}" style="color:inherit;">
                                            <span class="tb-lead">${data.invoice_title}<span class="dot dot-warning d-md-none ms-1"></span></span>
                                            <span class="">${data.name + ' ' + data.surname}</span>
                                        </a>
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
                defaultContent: "-",
                render: function (data) {
                    return `
                        <td class="nk-tb-col tb-col-lg">
                            <div class="user-info">
                                <span class="tb-lead">${data.cari_phone != null ? data.cari_phone : '-'} <span class="dot dot-warning d-md-none ms-1"></span></span>
                                <span>${(data.cari_email != null) ? data.cari_email : '-'}</span>
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

                    var cari_balance = data.cari_balance;
                    var balanceColor = (data.cari_balance == 0) ? "text-secondary" : (data.cari_balance > 0 ? "text-success" : "text-danger");
                    var balanceBgColor = (data.cari_balance == 0) ? "bg-secondary-dim" : (data.cari_balance > 0 ? "bg-success-dim" : "bg-danger-dim");
                    var balanceText = (data.cari_balance == 0) ? "-" : (data.cari_balance > 0 ? "Borçlu" : "Alacaklı");
                    return `
                        <td class="nk-tb-col tb-col-md">
                            <span class="tb-amount ${balanceColor} para">${ number_format(cari_balance,2,',','.') } ${data.money_icon}</span>
                        </td>
                        `;
                }
            },

            {
                data: null,
                name: 'cari_phone',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {

                    var cari_balance = data.cari_balance;
                    var balanceColor = (data.cari_balance == 0) ? "text-secondary" : (data.cari_balance > 0 ? "text-success" : "text-danger");
                    var balanceBgColor = (data.cari_balance == 0) ? "bg-secondary-dim" : (data.cari_balance > 0 ? "bg-success-dim" : "bg-danger-dim");
                    var balanceText = (data.cari_balance == 0) ? "-" : (data.cari_balance > 0 ? "Borçlu" : "Alacaklı");
                    return `
                        <td class="nk-tb-col tb-col-md">
                            <span class="tb-status ${balanceColor}">${balanceText}</span>
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
                        <td class="nk-tb-col nk-tb-col-tools  text-end">
                            <a href="../detail/${data.cari_id}" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a>
                        </td>
                        `;
                }
            },
            ],
        });



        //cariler arama input
        $('#cariler_input_search').keyup(function () {
            var searchWord = $(this).val().toLocaleUpperCase('tr-TR');

            var table = $('#datatableCari').DataTable();
            table.search(searchWord).draw();

            localStorage.setItem('datatableCari_filter_search', searchWord);


            if (this.value.length > 0) {
                $('#notification-dot-search').removeClass('d-none');
            } else {
                $('#notification-dot-search').addClass('d-none');
            }

        });

        //cariler arama temizleme
        $('#cariler_input_search_clear_button').on('click', function (e) {
            var table = $('#datatableCari').DataTable();

            $('#notification-dot-search').addClass('d-none');
            $('#cariler_input_search').val('');

            localStorage.removeItem('datatableCari_filter_search');

            table.state.clear();
            table.ajax.reload();

            table.search('').draw();
            console.log("arama kelimesi temizlendi");
        });

        //cariler filtreleme
        $('#applyFilter').on('click', function (e) {
            var cari_status = $('#status-filter-dropdown').find(':selected').val();
            console.log("uygulanacak filtre", cari_status);

            $('#notification-dot').removeClass('d-none');

            var table = $('#datatableCari').DataTable();
            table.column(4).search('').draw();

            localStorage.setItem('datatableCari_filter_status', cari_status);

            console.log("cari filtre başladı");

        });

        //cariler filter clear
        $('#clearFilter').on('click', function (e) {

            $('#status-filter-dropdown').val(0);
            $('#status-filter-dropdown').trigger('change');

            $('#notification-dot').addClass('d-none');

            var table = $('#datatableCari').DataTable();

            localStorage.removeItem('datatableCari_filter_status');

            table.state.clear();
            table.ajax.reload();

            console.log("filtre temizlendi");
        });

        var table = $('#datatableCari').DataTable();

        $(document).ajaxComplete(function () {
            console.log("ajax bitti");
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

        $('#selectAllCari').on('click', function () {
            selectAll = false;
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
            var rows = $('#datatableCari').DataTable().rows().nodes();
        });

    });
</script>

<?= $this->endSection() ?>