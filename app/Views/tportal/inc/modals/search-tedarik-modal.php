<!-- Müşteri Seç Modal -->
<div class="modal fade" id="mdl_musteriSec" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tedarikçi Seçiniz <em class="icon ni ni-info"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Bulmak istediğiniz müşterinin cari kodu, ünvanı, adı soyadını veya telefon tumarasını başında 0 olmadan yazınız. (en az 3 karakter giriniz.)"></em></h5>
                <a href="#" id="btn_mdl_musteriSec_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <input type="text" id="mdl_customer_search" class="form-control border-transparent form-focus-none form-control-xl" placeholder="Müşterinin Cari Kodu, Ünvanı, Adı Soyadını veya Telefon Numarasını yazınız. (en az 3 karakter giriniz.)" autocomplete="off">
            <div class="modal-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>CARİ KODU</th>
                            <th>MÜŞTERİ ÜNVAN/YETKİLİ</th>
                            <th>TELEFON</th>
                            <th>MUKELLEFİYET</th>
                        </tr>
                    </thead>
                    <tbody id="search_results_customer">
                        <?php

                        $cari_items2 = array_slice($cari_items, 0, 0);
                        foreach ($cari_items2 as $cari_item) { ?>
                            <tr>
                                <td class="cari_code"><?= $cari_item['cari_code'] ?> </td>
                                <td data-order="0">
                                    <div class="custom-control custom-radio no-control">
                                        <input type="radio" id="rd_cari_<?= $cari_item['cari_id'] ?>" name="rd_cari" class="custom-control-input rd_cari" value="<?= $cari_item['cari_id'] ?>" invoice_title="<?= $cari_item['invoice_title'] ?>" invoice_name="<?= $cari_item['name'] ?>" invoice_surname="<?= $cari_item['surname'] ?>"
                                        money_tipi="<?= $cari_item['money_code'] ?>"    money_tipi_id="<?= $cari_item['money_unit_code'] ?>"
                                        
                                        >
                                        <label class="custom-control-label text-primary" for="rd_cari_<?= $cari_item['cari_id'] ?>"><?= $cari_item['invoice_title'] ? $cari_item['invoice_title'] : $cari_item['name'] . " " . $cari_item['surname'] ?></label>
                                    </div>
                                </td>
                                <td class="cari_phone"><?= $cari_item['cari_phone'] ? $cari_item['cari_phone'] : "-" ?> </td>
                                <td><?php switch ($cari_item['obligation']) {
                                        case 'e-archive':
                                            echo "E-Arşiv Fatura";
                                            break;
                                        case 'e-invoice':
                                            echo "E-Fatura";
                                            break;
                                        default:
                                            echo "-";
                                            break;
                                    } ?></td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button data-bs-dismiss="modal" class="btn btn-lg btn-primary" satir="">Kapat </button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#mdl_customer_search').keyup(function(index) {
        var searchWord = $(this).val().toLocaleUpperCase('tr-TR');
        // console.log("searchWord", searchWord);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.cari.detailed_search_tedarik') ?>',
            dataType: 'json',
            data: {
                fromWhere: "<?= $fromWhere ?>",
                search: searchWord,
            },
            async: true,
            success: function(response) {
                // console.log("response", response);
                $('.rd_cari').prop('checked', false);
                appendResultsCustomer(response);
            }
        })
    });

    function appendResultsCustomer(response) {

        $('#search_results_customer').html('');

        jQuery.each(response['data']['cari_items'], function(index, cari_item) {

            var obligation_text;
            switch (cari_item.obligation) {
                case 'e-archive':
                    obligation_text = "E-Arşiv Fatura";
                    break;
                case 'e-invoice':
                    obligation_text = "E-Fatura";
                    break;
                default:
                    obligation_text = "-";
                    break;
            }

            var elem1 = `<tr>
                                    <td class="cari_code">` + cari_item.cari_code + `</td>
                                    <td data-order="0">
                                        <div class="custom-control custom-radio no-control">
                                            <input type="radio" id="rd_cari_` + cari_item.cari_id + `" name="rd_cari" class="custom-control-input rd_cari" value="` + cari_item.cari_id + `" invoice_title="`+cari_item.invoice_title+`" invoice_name="`+cari_item.name+`" invoice_surname="`+cari_item.surname+`"
                                            money_tipi="`+cari_item.money_code+`"  money_tipi_id="`+cari_item.money_unit_id+`"  money_tipi_icon="`+cari_item.money_icon+`" money_tipi_kur="`+cari_item.money_value+`"
                                            >
                                            <label class="custom-control-label text-primary" for="rd_cari_` + cari_item.cari_id + `">` + (cari_item.invoice_title ? cari_item.invoice_title : cari_item.name +' '+ cari.surname) + `</label>
                                        </div>
                                    </td>
                                    <td class="cari_phone">` + (cari_item.cari_phone !== null ? cari_item.cari_phone : '-') + `</td>
                                    <td>` + obligation_text + ` </td>
                                </tr>`;

            $('#search_results_customer').append(elem1);
        });
    }

    $('#mdl_musteriSec').on('shown.bs.modal', function() {
        $('#mdl_customer_search').focus();
    });
</script>






