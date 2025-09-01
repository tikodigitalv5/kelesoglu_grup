<!-- Sipariş Seç Modal -->
<style>
    div.dataTables_wrapper div.dataTables_filter label{
        width: 97%;
    margin-bottom: 10px;
    margin-top: 10px;
    }

    .dataTables_filter{
        width: 100%!important;
        padding: 10px !important;
        margin-left:0 !important;
    }

    .dataTables_filter input{
        width:100%!important;
    }
    
</style>

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

                <table id="datatableOrder" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
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

    var table = NioApp.DataTable('#datatableOrder', {

        processing: true,
        serverSide: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Tümü"]
        ],
        ajax: {
            url: base_url + '/tportal/production/orderList/',
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
                return `
                        <td class="nk-tb-col tb-col-lg">
                            <span class="tb-amount">${data.order_date}</span>
                        </td>
                        `;
            }
        },
        {
            data: null,
            name: 'order_no',
            className: 'nk-tb-col tb-col-md',
            render: function (data) {
                //data.stock_quantity ? parseFloat(data.stock_quantity).toLocaleString('tr-TR') : 0 }
                return `

                        <td class="nk-tb-col tb-col-md"> 
                            <span class="currency">${data.order_no == null ? '' : data.order_no}</span>
                        </td>

                        `;
            }
        },
        {
            data: null,
            name: 'amount_to_be_paid',
            className: 'nk-tb-col tb-col-md',
            render: function (data) {

                return `

                        <td class="nk-tb-col tb-col-md">
                            <span class="tb-amount">${replace_for_form_input(parseFloat(data.amount_to_be_paid).toFixed(2)) + ` ` + data.money_icon}</span>
                        </td>

                        `;
            }
        },
        ],

    });

    var myVar = $("#datatableStock_wrapper").find(find('dataTables_filter')).removeClass('d-none');
    var myVar2 = $("#datatableStock_wrapper").find(find('dataTables_filter')).css("margin-bottom", "10px");
    var base_url = window.location.origin;


</script>