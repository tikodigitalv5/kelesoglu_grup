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
</style>
<div class="modal fade" id="mdl_SubUrunSec" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #013caa !important;">
                <h5 class="modal-title" id="mdl_sub_title">Ürün Seçiniz</h5>
                    <input type="hidden" name="defaultGorsel" id="defaultGorsel">
                <!-- <a href="#" id="btn_mdl_SubUrunSec_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross text-white"></em>
                </a> -->

                <a id="btn_mdl_SubUrunSec" data-bs-dismiss="modal" class="SubStockClose btn btn-lg btn-light"><em class="icon ni ni-arrow-left"></em><span>Ürünlere Dön</span></a>
            </div>


            <div class="modal-body p-0 bg-white">


                <div class="card-inner position-relative card-tools-toggle">
                    <div class="card-title-group" style="display:block">
                        <div class="card-tools">
                            <div class="d-flex gx-3" id="urun_property" style="flex-wrap:wrap;">




                            </div>

                        </div><!-- .form-inline -->


                    </div><!-- .card-title-group -->
                    <div class="card-search search-wrap" data-search="search">
                        <div class="card-body">
                            <div class="search-content">
                                <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em
                                        class="icon ni ni-arrow-left"></em></a>
                                <input type="text" id="stock_input_search"
                                    class="form-control border-transparent form-focus-none"
                                    placeholder="Bulmak istediğiniz ürünün adını yada kodunu yazınız..">
                                <a href="#" class="btn btn-icon toggle-search active" data-target="search"
                                    style="right: 0;transform: translate(-0.25rem, -50%);position: absolute;top: 50%;"><em
                                        class="icon ni ni-cross"></em></a>
                                <button class="search-submit btn btn-icon" style="margin-right: 50px;"
                                    id="stock_input_search_clear_button" name="stock_input_search_clear_button"><em
                                        class="icon ni ni-trash"></em></button>
                            </div>
                        </div>
                    </div><!-- .card-search -->
                </div><!-- .card-inner -->

                <table id="datatableStocks" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
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
                </table>

            </div>
            <div class="modal-footer">
                <a id="btn_mdl_SubUrunSec" data-bs-dismiss="modal" class="SubStockClose btn btn-lg btn-primary"><em class="icon ni ni-arrow-left"></em><span>Ürünlere Dön</span></a>
                <a id="" data-bs-dismiss="modal" class="btn btn-lg btn-secondary"><em class="icon ni ni-cross"></em><span>Kapat</span></a>
            </div>
        </div>
    </div>
</div>


<script>
$('document').ready(function() {
    $(".modal-backdrop").remove();



    let SelectVariantColumn = "";
    let SelectVariantValue = "";

    $(".modal-backdrop").remove();


$('#mdl_SubUrunSec').on('click', '.subimg', function() {
    var title = $(this).attr("data-title");
    var href = $(this).attr("data-href");

    $('.modal').css('z-index', '1050');
    $('#urunGorsel').css('z-index', '1060');

    $("#urunGorsel .modal-title").text(title);
    $("#urunGorsel img").attr("src", href);
    $(".modal-backdrop").remove();
    // Modalı göster
    $("#urunGorsel").modal("show");
});

$('#urunGorsel').on('click', '.close', function() {
    $("#urunGorsel").modal("hide");
    $(".modal-backdrop").remove();
});

    $(".SubStockClose").click(function(e) {
        $('#mdl_urunSec').modal('show');
        $('#mdl_SubUrunSec').modal('hide');
        $('.js-select2').val(null).trigger('change');
        $("#urun_property").html('');
        $('#datatableStocks').DataTable().destroy();
    });

    /*  $('#mdl_SubUrunSec').on('shown.bs.modal', function () {
         $("div.dataTables_filter input").focus();
         $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
     }); */


    $(document).ready(function() {

        $(document).on('change', '.variant_select', function() {

            var selectedOption = $(this).find('option:selected');
            SelectVariantValue = selectedOption.attr("data-variant");
            SelectVariantColumn = selectedOption.attr("data-variant-column");
           
            var selectedValues = [];


            $('.variant_select').each(function() {
                var $select = $(this);

                // Seçilen tüm <option> öğelerini alalım
                var selectedOptions = $select.select2('data');

                // Her bir seçili <option> için işlem yapalım
                selectedOptions.forEach(function(option) {
                    // Seçili <option> öğesinin DOM elemanını alalım
                    var $option = $(option.element);

                    // <option> öğesinin data-variant-column özelliğini alalım
                    var SelectVariantColumn_1 = $option.data('variant-column');

                    // Seçili <option> öğesinin id değerini alalım (varsayılan olarak option.id)
                    var SelectVariantValue_1 = option.id;



                    // Özellikler tanımlıysa selectedValues dizisine ekleyelim
                    if (SelectVariantColumn_1 !== undefined &&
                        SelectVariantValue_1 !== undefined) {
                        selectedValues.push({
                            name: SelectVariantColumn_1,
                            value: SelectVariantValue_1
                        });
                    }
                });
            });






            selectedStockId = $('.rd_stock:checked').val();
            selectAnaGorsel = $('#defaultGorsel').val();


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

            if ($.fn.DataTable.isDataTable('#datatableStocks')) {
                $('#datatableStocks').DataTable().destroy();
            }
            var table = NioApp.DataTable('#datatableStocks', {

                processing: true,
                serverSide: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Tümü"]
                ],
                ajax: {
                    url: base_url + '/tportal/stock/getSubStockDatatable/create',
                    type: 'POST',
                    data: {
                        id: selectedStockId,
                        selectedValues: selectedValues,


                    }
                },
                "dom": '<"top"f>rt<"bottom"lp>',
                // stateSave: true,
                // stateDuration: 15,
                columnDefs: [{
                    className: "nk-tb-col",
                    defaultContent: "-",
                    targets: "_all"
                }, ],
                select: {
                    style: 'os',
                    selector: 'td:first-child',
                    style: 'multi'
                },
                order: [3, 'desc'],
                createdRow: (row, data, dataIndex, cells) => {
                    $(row).addClass('nk-tb-item');
                     
                },
                
                columns: [{
                data: null,
                name: 'stock_code',
                className: 'nk-tb-col tb-col-md',
                render: function (data) {
                    if(data.default_image == "uploads/default.png"){
                        default_image = selectAnaGorsel;
                    }else{
                        default_image = data.default_image;
                    }
                    return `
                    
                        <td  width="5%"  class="nk-tb-col tb-col-lg">
                        
                        <a class="subimg" data-title="` + data.stock_title + `"  data-href="`+ base_part+ "/" + default_image + `">
                        <img height="40" width="40" src=" `+ base_part+ "/" + default_image + `" alt="" class="thumb">
                        </a>
                        </td>
                        `;
                }
            },{
                    
                        data: null,
                        name: 'stock_title',
                        className: 'nk-tb-col tb-col-md',
                        render: function(data) {
                     
                            return `
                <div class="custom-control custom-control-sm custom-checkbox notext datatable-checkbox-container">
                    <div class="custom-control custom-radio no-control">
                        <input type="radio" id="rd_substock` + data.stock_id +
                                `" name="rd_substock" class="custom-control-input rd_substock btnModalSubStock" value="` +
                                data.stock_id + `" data-stock-code="` + data
                                .stock_code +
                                `" data-stock-parent-id="` + data.parent_id +
                                `" data-stock-has-variant="` + data
                                .has_variant +
                                `"  data-stock-type="` + data.stock_type +
                                `" data-stock-quantity="` + data
                                .stock_total_quantity +
                                `" data-stock-title="` + data.stock_title +
                                `" data-stock-unit="` + data.sale_unit_id +
                                `" data-stock-unit-price="` + parseFloat(data
                                    .sale_unit_price).toFixed(2) +
                                `" data-stock-warehouse-id="` + data
                                .warehouse_id +
                                `" data-stock-unit-sale-tax-rate="` + data
                                .sale_tax_rate + ` ">
                        <label class="text-primary text-nowrap" for="rd_substock` + data.stock_id + `">` + data
                                .stock_title + `</label>
                    </div>
                </div>`
                        }
                    },
                    {
                        data: null,
                        name: 'stock_code',
                        className: 'nk-tb-col tb-col-md',
                        render: function(data) {
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
                        render: function(data) {
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
                        render: function(data) {

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
                        render: function(data) {

                            return `

                <td class="nk-tb-col tb-col-md">
                            <span class="tb-amount">${replace_for_form_input(parseFloat(data.sale_unit_price).toFixed(<?php echo session()->get('user_item')['para_yuvarlama'] ?? 2; ?>)) + ` ` + data.money_icon}</span>
                        </td>

                `;
                        }
                    },
                ],

            });



        });
    });



    $(document).on("click", ".btnModalStock", function() {

        

        var s_id = $('#s_id').val();
        $('#mdl_urunSec').modal('hide');
        $('#mdl_SubUrunSec').modal('show');


        selectedStockId = $('.rd_stock:checked').val();
        selectedStockCode = $('.rd_stock:checked').attr('data-stock-code');
        selectedStockText = $('.rd_stock:checked').attr('data-stock-title');
        selectAnaGorsel = $('.rd_stock:checked').attr('data-stock_ana_gorsel');




        var propertyList = $("#urun_property");

        $.ajax({
            url: '<?php echo base_url(); ?>/tportal/stock/getStockVariant',
            type: 'POST',
            data: {
                id: selectedStockId,
             
            },
            success: function(response) {

                propertyList.html(response);
                $('#mdl_SubUrunSec').find('.variant_select').select2({
                    dropdownParent: $("#mdl_SubUrunSec")
                });
            },
            error: function(xhr, status, error) {

                propertyList.html('Bu ürüne ait özellik bulunamadı..');
            }
        });


        $("#mdl_sub_title").html("Varyantlar | " + selectedStockCode + "-" + selectedStockText);
        $("#defaultGorsel").val(selectAnaGorsel);


        var base_url = window.location.origin;
        var url = window.location.pathname;
        var parts = url.split('/');
        var lastPart = parts[parts.length - 1];

        if(base_url != "http://localhost:8080/"){
            base_part = "https://app.tikoportal.com.tr";
        }else{
            base_part = base_url;
        }

        if ($.fn.DataTable.isDataTable('#datatableStocks')) {
            $('#datatableStocks').DataTable().destroy();
        }
        var table = NioApp.DataTable('#datatableStocks', {

            processing: true,
            serverSide: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Tümü"]
            ],
            ajax: {
                url: base_url + '/tportal/stock/getSubStockDatatable/create',
                type: 'POST',
                data: {
                    id: selectedStockId,
                    selectedValues: 0,


                }
            },
            "dom": '<"top"f>rt<"bottom"lp>',
            // stateSave: true,
            // stateDuration: 15,
            columnDefs: [{
                className: "nk-tb-col",
                defaultContent: "-",
                targets: "_all"
            }, ],
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
                    if(data.default_image == "uploads/default.png"){
                        default_image = selectAnaGorsel;
                    }else{
                        default_image = data.default_image;
                    }
                    return `
                        <td  width="5%"  class="nk-tb-col tb-col-lg">
                        
                        <a class="subimg" data-title="` + data.stock_title + `"  data-href="`+ base_part+ "/" + default_image + `">
                        <img height="40" width="40" src=" `+ base_part+ "/" + default_image + `" alt="" class="thumb">
                        </a>
                        </td>
                        `;
                }
            },{
                    data: null,
                    name: 'stock_title',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data) {

                        return `
                        <div class="custom-control custom-control-sm custom-checkbox notext datatable-checkbox-container">
                            <div class="custom-control custom-radio no-control">
                                <input type="radio" id="rd_substock` + data.stock_id +
                            `" name="rd_substock" class="custom-control-input rd_substock btnModalSubStock" value="` +
                            data.stock_id + `" data-stock-code="` + data.stock_code +
                            `" data-stock-parent-id="` + data.parent_id +
                            `" data-stock-has-variant="` + data.has_variant +
                            `"  data-stock-type="` + data.stock_type +
                            `"  data-stock_ana_gorsel="` + selectAnaGorsel +
                            
                            `" data-stock-quantity="` + data.stock_total_quantity +
                            `" data-stock-title="` + data.stock_title +
                            `" data-stock-unit="` + data.sale_unit_id +
                            `" data-stock-unit-price="` + parseFloat(data
                                .sale_unit_price).toFixed(2) +
                            `" data-stock-warehouse-id="` + data.warehouse_id +
                            `" data-stock-unit-sale-tax-rate="` + data.sale_tax_rate + ` ">
                                <label class="text-primary text-nowrap" for="rd_substock` + data.stock_id + `">` + data
                            .stock_title + `</label>
                            </div>
                        </div>`
                    }
                },
                {
                    data: null,
                    name: 'stock_code',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data) {
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
                    render: function(data) {
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
                    render: function(data) {

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
                    render: function(data) {

                        return `

                        <td class="nk-tb-col tb-col-md">
                            <span class="tb-amount">${replace_for_form_input(parseFloat(data.sale_unit_price).toFixed(<?php echo session()->get('user_item')['para_yuvarlama'] ?? 2; ?>)) + ` ` + data.money_icon}</span>
                        </td>

                        `;
                    }
                },
            ],

        });





    });



    var myVar = $("#datatableStock_wrapper").find(find('dataTables_filter')).removeClass('d-none');
    var myVar2 = $("#datatableStock_wrapper").find(find('dataTables_filter')).css("margin-bottom", "10px");
    var base_url = window.location.origin;

});


</script>