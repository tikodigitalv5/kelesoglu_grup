<!-- Sipariş Seç Modal -->


<div class="modal fade" id="mdl_siparisSec">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sipariş Seçiniz</h5>
                <a href="#" id="btn_mdl_siparisSec_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <!-- <input type="text" id="mdl_stock_search" class="form-control border-transparent form-focus-none form-control-xl" placeholder="Bulmak istediğiniz ürünün adını veya stok kodunu yazınız. (en az 3 karakter giriniz.)"> -->
            <div class="modal-body p-0 bg-white">
                <div class="text-center p-4">
                    <p class="text-muted">Arama yapmak için en az 3 karakter giriniz</p>
                </div>
                <table id="datatableOrder" class="nk-tb-list nk-tb-ulist" style="width: 100%!important;">
                    <thead>
                        <tr>

                            <th>MÜŞTERİ</th>
                            <th>SİPARİŞ TARİHİ</th>
                            <th>SİPARİŞ NO</th>
                            <th>TOPLAM SATIŞ FİYATI</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <input type="hidden" name="s_id" id="s_id">
                </table>

            </div>
            <div class="modal-footer">
                <button id="btn_mdl_siparisSec" data-bs-dismiss="modal" data-satir=""
                    class="btn btn-lg btn-primary ">Kapat
                </button>
            </div>
        </div>
    </div>
</div>


<script>

    $('#mdl_siparisSec').on('shown.bs.modal', function () {
        $("div.dataTables_filter input").focus();
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    var base_url = window.location.origin;
    var url = window.location.pathname;
    var parts = url.split('/');
    var lastPart = parts[parts.length - 1];

    var table = $('#datatableOrder').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/tr.json',
            search: '',
            searchPlaceholder: 'Arama kelimesi giriniz...'
        },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Tümü"]
        ],
        ajax: function(data, callback, settings) {
            var searchValue = data.search.value;
            // Loading göster
            if ($('.dt-loading').length === 0) {
                $('#datatableOrder_wrapper').append('<div class="dt-loading">Yükleniyor...</div>');
            }
            if (!searchValue || searchValue.length < 3) {
                callback({
                    data: [],
                    recordsTotal: 0,
                    recordsFiltered: 0
                });
                $('.dt-loading').remove();
                return;
            }
            $.ajax({
                url: base_url + '/tportal/production/orderList/',
                data: data,
                success: function(json) {
                    callback(json);
                    $('.dt-loading').remove();
                },
                error: function() {
                    $('.dt-loading').remove();
                }
            });
        },
    
        "dom": '<"top"f>rt<"bottom"lp>',
        // stateSave: true,
        // stateDuration: 15,
        columnDefs: [{
            className: "nk-tb-col",
            defaultContent: "-",
            targets: "_all"
        },
        ],
        select: {
            style: 'os',
            selector: 'td:first-child',
            style: 'multi'
        },
        order: [3, 'desc'],
        createdRow: (row, data, dataIndex, cells) => {
            $(row).addClass('nk-tb-item');
            // console.log(data);
        },
        columns: [{
            data: null,
            name: '',
            className: 'nk-tb-col tb-col-md',
            render: function (data) {
                return `
                        <div class="custom-control custom-control-sm custom-checkbox notext datatable-checkbox-container">
                            <div class="custom-control custom-radio no-control">
                                <input type="radio" id="rd_order_${data.order_id}" name="rd_order" class="custom-control-input rd_order btnModalStockOrder" value="${data.order_id}" data-cari-id="${data.cari_id}" data-order-cari-title="${data.cari_invoice_title == null ? data.name + ` ` + data.surname : data.cari_invoice_title} #${data.order_no} numaralı siparişi">
                                <label class="text-primary text-nowrap" for="rd_order_${data.order_id}">${data.cari_invoice_title == null ? data.name + ` ` + data.surname : data.cari_invoice_title}</label>
                            </div>
                        </div>`
            }
        },
        {
            data: null,
            name: 'order_date',
            className: 'nk-tb-col tb-col-md',
            render: function (data) {
                return `<span class="tb-amount">${data.order_date}</span>`;
            }
        },
        {
            data: null,
            name: 'order_no',
            className: 'nk-tb-col tb-col-md',
            render: function (data) {
                return `<span class="currency">${data.order_no == null ? '' : data.order_no}</span>`;
            }
        },
        {
            data: null,
            name: 'amount_to_be_paid',
            className: 'nk-tb-col tb-col-md',
            render: function (data) {
                return `<span class="tb-amount">${replace_for_form_input(parseFloat(data.amount_to_be_paid).toFixed(2)) + ` ` + data.money_icon}</span>`;
            }
        },
        ],
    });

    // Modal açıldığında input ve tabloyu temizle
    $('#mdl_siparisSec').on('show.bs.modal', function () {
        table.clear().draw();
        $('.modal-body .text-center').show();
        $('#datatableOrder_filter input').val('');
    });

    // Arama input'u için sadece Enter ile arama yap
    $(document).off('keyup', '#datatableOrder_filter input');
    $(document).on('keydown', '#datatableOrder_filter input', function(e) {
        if (e.key === 'Enter') {
            var searchValue = $(this).val();
            if (searchValue.length < 3) {
                table.clear().draw();
                $('.modal-body .text-center').show();
            } else {
                $('.modal-body .text-center').hide();
                // Loading göster
                if ($('.dt-loading').length === 0) {
                    $('#datatableOrder_wrapper').append('<div class="dt-loading">Yükleniyor...</div>');
                }
                table.search(searchValue).draw();
            }
        }
    });

    // DataTable search label'ını gizle
    $(document).ready(function(){
        $('#datatableOrder_filter label').contents().filter(function(){
            return this.nodeType === 3;
        }).remove();
    });

</script>