<!-- Ürün Seç Modal -->
<style>
     td.nk-tb-col.nk-tb-col.tb-col-md{
        padding: 0;
     }
    td.nk-tb-col.nk-tb-col.tb-col-md:first-child{
    padding: 5px 0px 5px 20px!important;
}
th.nk-tb-col.tb-col-md.sorting{
    padding-left: 0;
}
.modal-backdrop.show{
    opacity: 0!important;
    display:none;
}
div.dataTables_wrapper div.dataTables_filter label{
        width: 97%;
    margin-bottom: 10px;
    margin-top: 10px;
    }

    .dataTables_filter{
        display: none;
        width: 100%!important;
        padding: 10px !important;
        margin-left:0 !important;
    }

    .dataTables_filter input{
        width:100%!important;
    }
  
</style>
<div class="modal fade" id="mdl_urunSec" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ürün Seçiniz</h5>
                <a href="#" id="btn_mdl_urunSec_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>

            <input type="text" id="mdl_stock_searchs"
                class="form-control border-transparent form-focus-none form-control-xl"
                placeholder="Bulmak istediğiniz ürünün adını veya stok kodunu yazınız. (en az 3 karakter giriniz.)">

            <div class="modal-body p-0 bg-white">

                <table id="datatableStock" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                        <tr>

                            <th width="9%" style="text-align:center">GÖRSEL</th>
                            <th style="padding-left:15px!important;" >STOK ADI</th>
                            <th>STOK KODU</th>
                            <th>BULUNDUĞU DEPO</th>
                            <th>STOK DURUMU</th>
                            <th>SATIŞ FİYATI</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <input type="hidden" name="s_id" id="s_id">
                    <input type="hidden" name="nereden" id="nereden">
                </table>

            </div>
            <div class="modal-footer">
                <button id="btn_mdl_urunSec" data-bs-dismiss="modal" data-satir="" class="btn btn-lg btn-primary ">Kapat
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="urunGorsel" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-m" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stock_basligi">Görsel</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <!-- <input type="text" id="mdl_stock_search" class="form-control border-transparent form-focus-none form-control-xl" placeholder="Bulmak istediğiniz ürünün adını veya stok kodunu yazınız. (en az 3 karakter giriniz.)"> -->
            <div class="modal-body p-0 bg-white">

                <img src="" alt="görsel" id="urunGorseli"   >

            </div>
           
        </div>
    </div>
</div>

<script>

    $('document').ready(function () {

        $(".modal-backdrop").remove();

        $('#mdl_urunSec').on('shown.bs.modal', function () {
            $("#mdl_stock_searchs").focus();
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });


        
$('#mdl_urunSec').on('click', '.buradanAl', function() {
       
        var title = $(this).attr("data-title");
           
            var href = $(this).attr("data-href");
            
    $(".modal-backdrop").remove();

          

            $("#urunGorsel .modal-title").text(title);
            $("#urunGorsel img").attr("src", href); 
            
            // Modalı göster
            $("#urunGorsel").modal("show");
});

$('#urunGorsel').on('click', '.close', function() {
    $("#urunGorsel").modal("hide");
    $(".modal-backdrop").remove();
});

$(".modal-backdrop").remove();

        var base_url = window.location.origin;
        var url = window.location.pathname;
        var parts = url.split('/');
        var lastPart = parts[parts.length - 1];
        var neredeyim = parts[parts.length - 2];

        if(base_url != "http://localhost:8080/"){
            base_part = "https://app.tikoportal.com.tr";
        }else{
            base_part = base_url;
        }
  
        // Global bir değişken olarak tanımlayalım
        var stockTable;

        // Table initialization
        stockTable = NioApp.DataTable('#datatableStock', {
            processing: true,
            serverSide: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Tümü"]
            ],
            ajax: {
                url: base_url + '/tportal/stock/getSubStock/' + lastPart,
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
                name: 'stock_code',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {
                    return `
                        <td  width="5%"  class="nk-tb-col tb-col-lg">
                        
                        <a class="buradanAl" data-title="` + data.stock_title + `"  data-href="`+ base_part+ "/" + data.default_image + `">
                        <img height="40" width="40" src=" `+ base_part+ "/" + data.default_image + `" alt="" class="thumb">
                        </a>
                        </td>
                        `;
                }
            },
            {
                data: null,
                name: 'stock_title',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {
                    var parentAnaurun = ''; 
                    if(neredeyim != 'order' &&   neredeyim != 'production'  &&   neredeyim != 'offer'){
                            if(data.has_variant == 0  && data.parent_id == 0  ){
                                parentAnaurun = "btnModalStockOrder";
                            }else{
                                parentAnaurun = "btnModalStock";
                            }
                        }else{
                            if(data.has_variant == 0  && data.parent_id == 0   ){
                                parentAnaurun = "btnModalStockOrder";
                            }else{
                                parentAnaurun = "btnModalStock";
                            }
                            }

                    return `
                        <div class="custom-control custom-control-sm custom-checkbox notext datatable-checkbox-container">
                            <div class="custom-control custom-radio no-control">
                                <input type="radio"  id="rd_stock_` + data.stock_id + `" name="rd_stock" class="custom-control-input rd_stock ${parentAnaurun}" value="` + data.stock_id + `" data-stock-code="`+data.stock_code+`" data-stock-parent-id="`+data.parent_id+`" data-stock-has-variant="`+data.has_variant+`"  data-stock-type="` + data.stock_type + `" data-stock-quantity="` + data.stock_total_quantity + `" data-stock-title="` + data.stock_title + `" data-stock-unit="` + data.sale_unit_id + `" data-stock-unit-price="` + parseFloat(data.sale_unit_price).toFixed(2) + `"  data-stock_ana_gorsel="` + data.default_image + `"  data-stock-warehouse-id="` + data.warehouse_id + `" data-stock-unit-sale-tax-rate="` + data.sale_tax_rate + ` ">
                                <label class="text-primary text-nowrap" for="rd_stock_` + data.stock_id + `">` + data.stock_title + `</label>
                            </div>
                        </div>`
                }
            },
            {
                data: null,
                name: 'stock_code',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {
                    return `
                        <td class="nk-tb-col tb-col-lg">
                            <span class="tb-amount">${data.stock_code}</span>
                        </td>
                        `;
                }
            },
            {
                data: null,
                name: 'warehouse_title',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {
                    //data.stock_quantity ? parseFloat(data.stock_quantity).toLocaleString('tr-TR') : 0 }
                    return `

                        <td class="nk-tb-col tb-col-md"> 
                            <span class="currency">${data.warehouse_title == null ? '' : data.warehouse_title}</span>
                        </td>

                        `;
                }
            },
            {
                data: null,
                name: 'stock_total_quantity',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {

                    return `

                        <td class="nk-tb-col tb-col-md">
                            <span class="tb-amount">${replace_for_form_input(parseFloat(data.stock_total_quantity).toFixed(2)) + ` ` + data.unit_title}</span>
                        </td>

                        `;
                }
            },
            {
                data: null,
                name: 'sale_unit_price',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {

                    return `

                        <td class="nk-tb-col tb-col-md">
                            <span class="tb-amount">${replace_for_form_input(parseFloat(data.sale_unit_price).toFixed(<?php echo session()->get('user_item')['para_yuvarlama'] ?? 2; ?>)) + ` ` + data.money_icon}</span>
                        </td>

                        `;
                }
            },
            ],

        });

        var myVar = $("#datatableStock_wrapper").find(find('dataTables_filter')).removeClass('d-none');
        var myVar2 = $("#datatableStock_wrapper").find(find('dataTables_filter')).css("margin-bottom", "10px");
        var base_url = window.location.origin;

        let searchTimeout = null;


        
        // Debounce fonksiyonu ekle
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Arama input'unu dinle
        $(document).on('keyup', '#mdl_stock_searchs', function() {
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(() => {
                var searchValue = $(this).val();
                if(searchValue && searchValue.length >= 3 || searchValue.length === 0) {
                    console.log("arama yapılıyor... ", searchValue);
                    // URL'i güncelle ve tabloyu yeniden yükle
                    stockTable.init({
                        ajax: {
                            url: base_url + '/tportal/stock/getSubStock/' + lastPart + '?search=' + searchValue
                        }
                    });
                }
            }, 500);
        });

    });



</script>


