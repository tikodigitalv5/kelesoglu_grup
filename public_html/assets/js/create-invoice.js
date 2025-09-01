$(document).ready(function () {

    var exchange_rates = {
        'USD': 1.0,    // USD sabit referans, yani 1 USD = 1 USD
        'EUR': 1.1,    // 1 EUR = 1.1 USD (örnek)
        'TRY': 0.05    // 1 TRY = 0.05 USD (örnek)
    };


    var base_url = window.location.origin;
    var $ss = parseInt($("#str_s").val());

    var pageURL = $(location).attr("href");
    var segments = pageURL.split('/');
    var page_type = segments[4]; //invoice,order,offer

    getNotes(page_type);
    getInvoiceSerial();
    getExceptionType();
    getSpecialBase();

    for (let i = 0; i <= $ss; i++) {
        getUnits(i);
        getWithholding(i);
    }

    const myTimeout = setTimeout(myGreeting, 2400);

    function myGreeting() {
        var ss = $('#str_s').val();

        $('#Iller').val($('#address_city_plate').val());
        $('#Iller').trigger('change');

        $('#Ilceler').val($('#address_district').val());
        $('#Ilceler').trigger('change');

        $('#fatura_seri').val($('#base_fatura_seri').val());
        $('#fatura_seri').trigger('change');

        $('#fatura_tipi').val($('#base_fatura_tipi').val());
        $('#fatura_tipi').trigger('change');

        $('#slct_invoice_note').val($('#base_slct_note').val());
        $('#slct_invoice_note').trigger('change');

        $('#slct_doviz_tipi').val($('#base_slct_doviz_tipi').val());
        $('#slct_doviz_tipi').trigger('change');


        for (var i = 0; i <= ss; i++) {
            $('#slct_birim_' + i).val($('#base_slct_birim_' + i).val());
            $('#slct_birim_' + i).trigger('change');

            $('#slct_kdv_' + i).val($('#base_slct_kdv_' + i).val());
            $('#slct_kdv_' + i).trigger('change');

            if ($("#slct_tevkifat_tipi_" + i).is(":visible")) {
                $('#slct_tevkifat_tipi_' + i).val($('#base_slct_tevkifat_tipi_' + i).val());
                $('#slct_tevkifat_tipi_' + i).trigger('change');
            }
        }
    }

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

    //mükellefiyet değiştiğinde -> alış faturası, satış faturası
    //0: satış (giden) fatura
    //1: alış (gelen) fatura
    var ftr_turu = 0;
    $(document).on("click", ".ftr_turu", function () {
        console.log("ftr_turu change edildi");

        var selectedInvoiceType = $("input:radio[name=ftr_turu]:checked").val();
        console.log("ftr_turu", selectedInvoiceType);
        
        if (selectedInvoiceType == 'outgoing_invoice') {
            // $('#warehouse_area').addClass("d-none");
            // $('#chx_has_collection_area').removeClass("d-none");

            ftr_turu = 0;
        }
        else if (selectedInvoiceType == 'incoming_invoice') {
            // $('#warehouse_area').removeClass("d-none");
            // $('#chx_has_collection_area').addClass("d-none");

            ftr_turu = 1;
        }
        else {
            console.log("fatura tipi tespit edilemedi");
        }
    });

    //mükellefiyet değiştiğinde
    $(document).on("change", "#obligation", function () {

        console.log($('#obligation').val());
        if ($('#obligation').val() == 'e-archive') {

            $('#fatura_senaryo').val('EARSIVFATURA');
            $('#fatura_senaryo').trigger('change');

            $("#fatura_senaryo option[value=EARSIVFATURA]").removeAttr('disabled');

            $("#fatura_senaryo option[value=TEMELFATURA]").attr('disabled', 'disabled');
            $("#fatura_senaryo option[value=TICARIFATURA]").attr('disabled', 'disabled');
            $("#fatura_senaryo option[value=KAMU]").attr('disabled', 'disabled');
            $("#fatura_senaryo option[value=IHRACAT]").attr('disabled', 'disabled');
        } else if ($('#obligation').val() == 'e-invoice') {

            $('#fatura_senaryo').val('EFATURA');
            $('#fatura_senaryo').trigger('change');

            $("#fatura_senaryo option[value=EARSIVFATURA]").attr('disabled', 'disabled');

            $("#fatura_senaryo option[value=TEMELFATURA]").removeAttr('disabled');
            $("#fatura_senaryo option[value=TICARIFATURA]").removeAttr('disabled');
            $("#fatura_senaryo option[value=KAMU]").removeAttr('disabled');
            $("#fatura_senaryo option[value=IHRACAT]").removeAttr('disabled');
        }
    });

    //fatura_senaryo değiştiğinde
    $(document).on("change", "#fatura_senaryo", function () {

        var selectedFaturaSenaryo = $('#fatura_senaryo').val();

        if (selectedFaturaSenaryo == 'TEMELFATURA') {
            $('#fatura_tipi').val('SATIS');
            $('#fatura_tipi').trigger('change');

            $("#fatura_tipi option[value=SATIS]").removeAttr('disabled');
            $("#fatura_tipi option[value=IADE]").removeAttr('disabled');
            $("#fatura_tipi option[value=TEVKIFAT]").removeAttr('disabled');
            $("#fatura_tipi option[value=ISTISNA]").removeAttr('disabled');
            $("#fatura_tipi option[value=IADEISTISNA]").removeAttr('disabled');
            $("#fatura_tipi option[value=OZELMATRAH]").removeAttr('disabled');
            $("#fatura_tipi option[value=IHRACKAYITLI]").removeAttr('disabled');
        }
        else if (selectedFaturaSenaryo == 'TICARIFATURA') {
            $('#fatura_tipi').val('SATIS');
            $('#fatura_tipi').trigger('change');

            $("#fatura_tipi option[value=IADE]").attr('disabled', 'disabled');
            $("#fatura_tipi option[value=IADEISTISNA]").attr('disabled', 'disabled');

        }
        else if (selectedFaturaSenaryo == 'EARSIVFATURA') {
            $('#fatura_tipi').val('SATIS');
            $('#fatura_tipi').trigger('change');

        }
        else if (selectedFaturaSenaryo == 'KAMU') {
            $('#fatura_tipi').val('SATIS');
            $('#fatura_tipi').trigger('change');

            $("#faturaIstisnaBlocks").addClass('d-none');
            $("#iadeBilgileriBlocks").addClass('d-none');
            $("#ozelMatrahBlocks").addClass('d-none');

            $("#fatura_tipi option[value=SATIS]").removeAttr('disabled');
            $("#fatura_tipi option[value=IADE]").removeAttr('disabled');
            $("#fatura_tipi option[value=TEVKIFAT]").removeAttr('disabled');
            $("#fatura_tipi option[value=ISTISNA]").removeAttr('disabled');
            $("#fatura_tipi option[value=IADEISTISNA]").removeAttr('disabled');
            $("#fatura_tipi option[value=OZELMATRAH]").removeAttr('disabled');
            $("#fatura_tipi option[value=IHRACKAYITLI]").removeAttr('disabled');

        }
        else if (selectedFaturaSenaryo == 'IHRACAT') {
            $('#fatura_tipi').val('ISTISNA');
            $('#fatura_tipi').trigger('change');

            $("#fatura_tipi option[value=SATIS]").attr('disabled', 'disabled');
            $("#fatura_tipi option[value=IADE]").attr('disabled', 'disabled');
            $("#fatura_tipi option[value=TEVKIFAT]").attr('disabled', 'disabled');
            $("#fatura_tipi option[value=ISTISNA]").removeAttr('disabled');
            $("#fatura_tipi option[value=IADEISTISNA]").attr('disabled', 'disabled');
            $("#fatura_tipi option[value=OZELMATRAH]").attr('disabled', 'disabled');
            $("#fatura_tipi option[value=IHRACKAYITLI]").attr('disabled', 'disabled');


        }
    });

    //not başlık ekle
    $("#chk_not_kaydet").change(function () {
        if (this.checked) {

            $('#slct_invoice_note').attr('disabled', true);
            $('#fatura_not_baslik_area').removeClass('d-none');

            var invoiceNotesTitle = $('#slct_invoice_note').find(":selected").text();

            $('#txt_fatura_not_baslik').val(invoiceNotesTitle == "seçiniz" ? '' : invoiceNotesTitle);

        } else {
            $('#slct_invoice_note').removeAttr('disabled');

            $('#fatura_not_baslik_area').addClass('d-none')
        }
    });


    //Birim Fiyat veya Miktar Değiştiğinde
    $(document).on("keyup", ".ftr_hesap", function () {
        // $(this).val($(this).val().replace(',','.'));
        // alert($(this).attr('satir'));
        fatura_satir_hesapla($(this).attr("satir"));
    });

    //KDV Değiştiğinde
    $(document).on("change", ".ftr_select", function () {
        // alert();
        fatura_satir_hesapla($(this).attr("satir"));
    });

    $(".diger_vergi_sec").attr("visible", "false").hide();

    //Fatura Tipi Değiştiğinde
    $(document).on("change", "#fatura_tipi", function () {
        $(".gtip").hide();
        $(".diger_vergi_sec").attr("visible", "false").hide();

        selectedFaturaTipi = $("#fatura_tipi").val();
        // console.log("Fatura Tipi: " + selectedFaturaTipi);

        if (selectedFaturaTipi == "SATIS") {
            $(".diger_vergi_sec").attr("visible", "false").hide();
            $("#iadeBilgileriBlocks").addClass('d-none');
            $("#faturaIstisnaBlocks").addClass('d-none');
            $("#ozelMatrahBlocks").addClass('d-none');

            // yaziyla(number_format($('#txt_genel_toplam').val(), 2, ',', '.'));
        }
        else if (selectedFaturaTipi == "IADE") {
            $("#iadeBilgileriBlocks").removeClass('d-none');
            $("#faturaIstisnaBlocks").addClass('d-none');
            $("#ozelMatrahBlocks").addClass('d-none');

        }
        else if (selectedFaturaTipi == "TEVKIFAT") {
            $(".diger_vergi_sec").attr("visible", "true").show();
            $("#iadeBilgileriBlocks").addClass('d-none');
            $("#faturaIstisnaBlocks").addClass('d-none');
            $("#ozelMatrahBlocks").addClass('d-none');

        }
        else if (selectedFaturaTipi == "ISTISNA") {
            $(".gtip").show();
            $("#faturaIstisnaBlocks").removeClass('d-none');
            $("#iadeBilgileriBlocks").addClass('d-none');
            $("#ozelMatrahBlocks").addClass('d-none');

        }
        else if (selectedFaturaTipi == "IADEISTISNA") {
            $("#iadeBilgileriBlocks").removeClass('d-none');
            $("#faturaIstisnaBlocks").removeClass('d-none');
            $(".diger_vergi_sec").attr("visible", "false").hide();
            $("#ozelMatrahBlocks").addClass('d-none');


        }
        else if (selectedFaturaTipi == "OZELMATRAH") {
            $("#ozelMatrahBlocks").removeClass('d-none');
            $("#faturaIstisnaBlocks").addClass('d-none');
            $("#faturaIstisnaBlocks").addClass('d-none');



        }
        else if (selectedFaturaTipi == "IHRACKAYITLI") {
            $("#faturaIstisnaBlocks").removeClass('d-none');
            $("#iadeBilgileriBlocks").addClass('d-none');
            $("#ozelMatrahBlocks").addClass('d-none');

        }
        else {
            $(".iade_fatura").attr("style", "display:none !important");
        }

        var invoiceNotesCode = $('#slct_doviz_tipi').find(":selected").attr("data-money-unit-code");
        $(".dvz").html(invoiceNotesCode);

    });

    //Para Birimi Değiştiğinde

    $(document).on("change", "#slct_doviz_tipi", function () {

       
        var anlikParaBirimi = $('#slct_doviz_tipi').find(":selected").attr("data-money-unit-code"),
            anlikParaBirimiID = $(this).val();
    
        console.log("Selected currency:", anlikParaBirimi);
        console.log("Selected currency ID:", anlikParaBirimiID);
    
        // Fetch the correct currency rate
        var selectedRate = kurlar.find(function(kur) {
            return kur.money_unit_id == anlikParaBirimiID;
        });




        if (anlikParaBirimi == "TRY") {

            // USD ve EUR kurlarını array'den bulup TRY karşılıklarını yazdır
            var usdKur = kurlar.find(kur => kur.money_code === 'USD'); // USD kurunu bul
            var eurKur = kurlar.find(kur => kur.money_code === 'EUR'); // EUR kurunu bul
        
            // USD ve EUR için kur değerleri varsa işlemleri yap
            if (usdKur && eurKur) {
                // USD'nin TRY karşılığı
                var usdToTry = typeof usdKur['kur_fiyat_USD'] === 'string' 
                    ? parseFloat(usdKur['kur_fiyat_USD'].replace(",", ".")) // Eğer string ise replace ile düzenle
                    : usdKur['kur_fiyat_USD']; // Zaten sayıysa olduğu gibi al
        
                var usdFormatted = usdToTry.toFixed(2); // TRY'ye çevrilen USD'yi formatla
                $("#kur_fiyat_USD").val(usdFormatted);  // USD'nin TRY karşılığını inputa yaz
        
                // EUR'nin TRY karşılığı
                var eurToTry = typeof eurKur['kur_fiyat_EUR'] === 'string' 
                    ? parseFloat(eurKur['kur_fiyat_EUR'].replace(",", ".")) // Eğer string ise replace ile düzenle
                    : eurKur['kur_fiyat_EUR']; // Zaten sayıysa olduğu gibi al
        
                var eurFormatted = eurToTry.toFixed(2); // TRY'ye çevrilen EUR'yu formatla
                $("#kur_fiyat_EUR").val(eurFormatted);  // EUR'nin TRY karşılığını inputa yaz
        
                // Simgeleri "TRY" olarak güncelle
                $(".text_simge_EUR").html("TRY");  // EUR simgesi TRY olacak
                $(".text_simge_USD").html("TRY");  // USD simgesi TRY olacak
            } else {
                console.log("USD veya EUR için kur bulunamadı.");
            }
        }
        
       
    
  
        if (selectedRate) {
            // Kur değerini formatla
            var roundedValue = parseFloat(selectedRate.money_value).toFixed(2);
            var formattedValue = roundedValue.replace('.', ',');

               
            // Remove any readonly or disabled attributes, if they exist
            $(".doviz_degis").removeAttr('readonly').removeAttr('disabled');
            
            // Set the input value
            $(".doviz_degis").val(formattedValue);
    
            // Seçilen para birimi USD ise
            if (anlikParaBirimi == "USD") {
                // USD to TRY
                $("#kur_fiyat_TRY").val(formattedValue);
    
                // USD to EUR: 1 USD = 1 / EUR kuru
                var usdToEur = (1 / exchange_rates['EUR']).toFixed(2);
                $("#kur_fiyat_EUR").val(usdToEur.replace('.', ','));
                    $(".text_simge_EUR").html("EUR");
    
            } else if (anlikParaBirimi == "EUR") {
                // EUR to TRY
                $("#kur_fiyat_TRY").val(formattedValue);
    
                // EUR to USD: EUR'dan USD'ye dönüşüm (doğrudan kullan)
                var eurToUsd = (exchange_rates['EUR']).toFixed(2);
                $("#kur_fiyat_USD").val(eurToUsd.replace('.', ','));
                $(".text_simge_USD").html("USD");
    
            } else if (anlikParaBirimi != "TRY") {
                // TRY dışındaki diğer para birimlerinde yine TL'ye çevir
                $("#kur_fiyat_TRY").val(formattedValue);
                
            }


    
            console.log("Updated input with value:", formattedValue);
        } else {
            console.log("No rate found for this currency");
        }


         

            
    
        // Handle if the selected currency is ID '3'
        if ($("#slct_doviz_tipi").val() == '3') {
            $("#txt_doviz_kuru_area").addClass("d-none");
            $(".dvz_str").hide();
            $("#txt_doviz_kuru").val("1,00");
            fatura_genel_toplam();
        } else {
            $("#txt_doviz_kuru_area").removeClass("d-none");
            $(".dvz_str").show();
            fatura_genel_toplam();
        }
    
        // Update the currency symbol or code in the UI
        var invoiceNotesCode = $('#slct_doviz_tipi').find(":selected").attr("data-money-unit-code");
        $(".dvz").html(invoiceNotesCode);
    });



    $(document).on("keyup", "#txt_doviz_kuru", function () {
        // console.log("kur deÄŸiÅŸtiiii.. fatura_genel_toplam gidilmek Ã¼zere");
        fatura_genel_toplam();

        var roundedValue = parseFloat($(this).val()).toFixed(2);
            var formattedValue = roundedValue.replace('.', ',');

               

            // Set the input value
            setTimeout(() => {
                $("#kur_fiyat_TRY").val(formattedValue);
            }, 100);
    


    });

    //Tevfikat Tipi Değiştiğinde
    $(document).on("change", ".tevkifat_tipi", function (event) {
        var dd = $(this).select2('data')[0];

        // console.log("hangi select id: " + $(this).select2("data")[0].val());


        if ($("#fatura_tipi").val() == "TEVKIFAT") {
            var value = $(this).val();
            if (value == 650) {
                // alert(value);
                $("#txt_V9015_oran_" + $(this).attr("satir")).prop("disabled", false);
            }

            $("#txt_V9015_oran_" + $(this).attr("satir")).val(
                $(this).select2("data")[0].withholding_value
            );

            fatura_satir_hesapla($(this).attr("satir"));
        }
    });




    //Not Değiştiğinde
    $(document).on("change", "#slct_invoice_note", function () {
        var invoiceNotesId = $('#slct_invoice_note').val();
        var invoiceNotesTitle = $('#slct_invoice_note').find(":selected").text();
        var invoiceNotes = $('#slct_invoice_note').find(":selected").attr("invoice_note_text");

        $('#txt_fatura_not_baslik').val(invoiceNotesTitle);
        $("#txt_fatura_not").val(invoiceNotes);
        $("#fatura_not_id").val(invoiceNotesId);


    });

    $(document).on("click", ".iade_satir_ekle", function () {
        var t = parseInt($("#iade_str_s").val());
        t = t + 1;
        var a = $("#iadeSatirOrnek").clone().prop("id", "iadeSatir_" + t);

        a.find("#txt_iade_tarihi_").attr("id", "txt_iade_tarihi_" + t);
        a.find("#txt_iade_fatura_no_").attr("id", "txt_iade_fatura_no_" + t); //.attr("iade_satir", t);


        a.find("#iade_satir_ekle").attr("iade_satir", t);
        a.find("#iade_satir_sil").attr("iade_satir", t);

        $("#iadeBilgileriBlocks").append(a);
        $("#iadeSatir_" + t).removeClass("d-none");
        $("#iade_str_s").val(t);

        $("#txt_iade_tarihi_" + t).datepicker({
            clearBtn: false,
            todayBtn: false,
            todayHighlight: true,
            autoclose: true,
            language: 'tr',
            format: "dd/mm/yyyy",
        });
    });

    $(document).on("click", ".iade_satir_sil", function () {
        var t = parseInt($("#iade_str_s").val());
        t = t - 1;

        var a = parseInt($(this).attr("iade_satir"));
        if (a > 0) {
            $("#iade_str_s").val(t);
            $("#iadeSatir_" + $(this).attr("iade_satir")).remove()
        }
    });

    $(document).on("click", ".irsaliye_satir_ekle", function () {
        var t = parseInt($("#irsaliye_str_s").val());
        t = t + 1;
        var a = $("#irsaliyeSatirOrnek").clone().prop("id", "irsaliyeSatir_" + t);

        a.find("#txt_irsaliye_tarihi_").attr("id", "txt_irsaliye_tarihi_" + t);
        a.find("#txt_irsaliye_no_").attr("id", "txt_irsaliye_no_" + t);


        a.find("#irsaliye_satir_ekle").attr("irsaliye_satir", t);
        a.find("#irsaliye_satir_sil").attr("irsaliye_satir", t);

        $("#irsaliyeBilgileriBlocks").append(a);
        $("#irsaliyeSatir_" + t).removeClass("d-none");
        $("#irsaliye_str_s").val(t);

        $("#txt_irsaliye_tarihi_" + t).datepicker({
            clearBtn: false,
            todayBtn: false,
            todayHighlight: true,
            autoclose: true,
            language: 'tr',
            format: "dd/mm/yyyy",
        });
    });

    $(document).on("click", ".irsaliye_satir_sil", function () {
        var t = parseInt($("#irsaliye_str_s").val());
        // t = t - 1;

        var a = parseInt($(this).attr("irsaliye_satir"));
        if (a > 0) {
            $("#irsaliye_str_s").val(t);
            $("#irsaliyeSatir_" + $(this).attr("irsaliye_satir")).remove()
        }
    });



    $(document).on("click", ".satir_ekle", function () {
        var $ss = parseInt($("#str_s").val());
        $ss = $ss + 1;

        var str = $("#Satir_Ornek")
            .clone()
            .prop("id", "Satir_" + $ss);

        getUnits($ss);
        // getMoneyUnits($ss);
        // getTaxs($ss);
        getWithholding($ss);



        str.find("#txt_aciklama_").attr("satir", $ss);
        str.find("#txt_aciklama_").attr("str_id", "0");
        str.find("#txt_aciklama_").attr("urun_id", "0");
        str.find("#txt_aciklama_").attr("id", "txt_aciklama_" + $ss);

        str.find(".btn_urun_sec").attr("data-satir", $ss);
        str.find(".btnModalStock").attr("data-satir", $ss);
        str.find(".btn_urun_eski_fiyat").attr("data-satir", $ss);

        // str.find('#btn_urunler_').attr('str_id', $ss);
        // str.find('#btn_urunler_').attr('id', 'btn_urunler_' + $ss);
        str.find("#txt_birim_fiyat_").attr("satir", $ss);
        str.find("#txt_birim_fiyat_").attr("id", "txt_birim_fiyat_" + $ss);
        str.find("#txt_iskonto_orani_").attr("satir", $ss);
        str.find("#txt_iskonto_orani_").attr("id", "txt_iskonto_orani_" + $ss);
        str.find("#txt_iskonto_tutari_").attr("satir", $ss);
        str.find("#txt_iskonto_tutari_").attr("id", "txt_iskonto_tutari_" + $ss);
        str.find("#txt_miktar_").attr("satir", $ss);
        str.find("#txt_miktar_").attr("id", "txt_miktar_" + $ss);
        str.find("#txt_warehouse_id_").attr("satir", $ss);
        str.find("#txt_warehouse_id_").attr("id", "txt_warehouse_id_" + $ss);
        str.find("#slct_birim_").attr("satir", $ss);
        str.find("#slct_birim_").attr("id", "slct_birim_" + $ss);
        str.find("#slct_kdv_").attr("satir", $ss);
        str.find("#slct_kdv_").attr("id", "slct_kdv_" + $ss);
        str.find("#baseFirstTax_").attr("satir", $ss);
        str.find("#baseFirstTax_").attr("id", "baseFirstTax_" + $ss);
        str.find("#tevkifat_area_").attr("satir", $ss);
        str.find("#tevkifat_area_").attr("id", "tevkifat_area_" + $ss);
        str.find("#slct_tevkifat_tipi_").attr("satir", $ss);
        str.find("#slct_tevkifat_tipi_").attr("id", "slct_tevkifat_tipi_" + $ss);
        str.find("#txt_V9015_oran_").attr("satir", $ss);
        str.find("#txt_V9015_oran_").attr("id", "txt_V9015_oran_" + $ss);
        str.find("#txt_V9015_").attr("satir", $ss);
        str.find("#txt_V9015_").attr("id", "txt_V9015_" + $ss);
        str.find("#txt_V9015_islem_tutar_").attr("satir", $ss);
        str.find("#txt_V9015_islem_tutar_").attr("id", "txt_V9015_islem_tutar_" + $ss);
        str.find("#txt_V9015_hesaplanan_kdv_").attr("satir", $ss);
        str.find("#txt_V9015_hesaplanan_kdv_").attr("id", "txt_V9015_hesaplanan_kdv_" + $ss);

        str.find("#txt_gtip_").attr("satir", $ss);
        str.find("#txt_gtip_").attr("id", "txt_gtip_" + $ss);

        str.find("#txt_kdv_").attr("satir", $ss);
        str.find("#txt_kdv_").attr("id", "txt_kdv_" + $ss);
        str.find("#txt_ara_toplam_").attr("satir", $ss);
        str.find("#txt_ara_toplam_").attr("id", "txt_ara_toplam_" + $ss);
        str.find("#txt_genel_toplam_").attr("satir", $ss);
        str.find("#txt_genel_toplam_").attr("id", "txt_genel_toplam_" + $ss);
        str.find("#btn_ekle_").attr("satir", $ss);
        str.find("#btn_ekle_").attr("id", "btn_ekle_" + $ss);
        str.find("#btn_sil_").attr("satir", $ss);
        str.find("#btn_sil_").attr("id", "btn_sil_" + $ss);

        $("#fatura_satirlar").append(str);

        // var faturaTipi = $('#fatura_tipi').val();
        // if (faturaTipi == 'TEVKIFAT') {
        //     $("#tevkifat_area_" + $ss).removeClass("d-none");
        // } else {
        //     $('#tevkifat_area_' + $ss).addClass('d-none');
        // }




        $("#Satir_" + $ss).removeClass("d-none");
        $("#Satir_" + $ss).attr("visible", "true");

        $("#Satir_" + $ss).attr("invoice_row_id", "0"); //düzenleme için. 0 ise düzenleme ekranında yeni satır eklemiş
        $("#Satir_" + $ss).attr("order_row_id", "0"); //düzenleme için. 0 ise düzenleme ekranında yeni satır eklemiş
        $("#Satir_" + $ss).attr("offer_row_id", "0"); //düzenleme için. 0 ise düzenleme ekranında yeni satır eklemiş
        $("#Satir_" + $ss).attr("gider_satir_id", "0"); //düzenleme için. 0 ise düzenleme ekranında yeni satır eklemiş

        $("#str_s").val($ss);


        // $("#slct_kdv_" + $ss).val($('#varsayilan_kdv').val()).change();


        $("#slct_tevkifat_tipi_" + $ss).select2({
            // minimumResultsForSearch: -1
        });

        $("#slct_kdv_" + $ss).select2({
            // minimumResultsForSearch: -1
        });

        $("#slct_birim_" + $ss).select2({
            // minimumResultsForSearch: -1
        });

        // $('#slct_kdv_' + $ss).trigger('change');
        // $('#slct_birim_' + $ss).trigger('change');
        // $('#slct_tevkifat_tipi_' + $ss).trigger('change');

    });


    // let silinmisSatirlar = [];
    // let silinmisSatir = {};

    $(document).on("click", ".satir_sil", function () {
        var $ss = parseInt($("#str_s").val());
        // $ss = $ss - 1;
        var $str_id = parseInt($(this).attr("satir"));
        if ($str_id > 0) {
            $("#str_s").val($ss);
            // silinmisSatir = {
            //     silinmisSatirId: $("#Satir_" + $(this).attr("satir")).text(),
            // }
            // silinmisSatirlar.push(silinmisSatir);

            // console.log(silinmisSatirlar);
            $("#Satir_" + $(this).attr("satir")).attr("isDeleted", true);
            $("#Satir_" + $(this).attr("satir")).attr("visible", false).hide();
            fatura_genel_toplam();

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: true,
                confirmButtonText: "Geri al",
                timer: 8000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            Toast.fire({
                icon: 'success',
                title: "Fatura satırı kaldırıldı. Geri almak için tıklayınız!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#Satir_" + $(this).attr("satir")).show();
                    $("#Satir_" + $(this).attr("satir")).attr("visible", true);
                    $("#Satir_" + $(this).attr("satir")).removeAttr("isDeleted");
                    fatura_genel_toplam();
                }
            });

        }
    });


    $(document).on("change", "#is_waybill", function () {
        if (this.checked) {
            $("#irsaliyeBilgileriBlocks").removeClass("d-none")
        } else {
            $("#irsaliyeBilgileriBlocks").addClass("d-none")
        }
    });

    function fatura_satir_hesapla(gln) {
        // Birim fiyat alma ve dönüştürme
        let birim_fiyat = 0;
        if ($("#txt_birim_fiyat_" + gln).val() !== "") {
            let value = $("#txt_birim_fiyat_" + gln).val();
            // Son virgülü noktaya çevir, diğer tüm noktaları kaldır
            let parts = value.split(',');
            let numericValue = parts[0].replace(/\./g, '') + (parts[1] ? '.' + parts[1] : '');
            birim_fiyat = parseFloat(numericValue);
        }
    
        // Miktar alma ve dönüştürme
        let miktar = 0;
        if ($("#txt_miktar_" + gln).val() !== "") {
            let value = $("#txt_miktar_" + gln).val();
            let parts = value.split(',');
            let numericValue = parts[0].replace(/\./g, '') + (parts[1] ? '.' + parts[1] : '');
            miktar = parseFloat(numericValue);
        }
    
        // İskonto işlemleri
        let iskonto_orani = 0;
        let iskonto_tutari = 0;
    
        if ($("#txt_iskonto_orani_" + gln).val() !== "") {
            let value = $("#txt_iskonto_orani_" + gln).val();
            let parts = value.split(',');
            let numericValue = parts[0].replace(/\./g, '') + (parts[1] ? '.' + parts[1] : '');
            iskonto_orani = parseFloat(numericValue);
        }
    
        if (iskonto_orani >= 1) {
            iskonto_tutari = birim_fiyat * miktar * (iskonto_orani / 100);
        }
    
        // Ara toplam hesaplama
        let aratplm_ = (birim_fiyat * miktar) - iskonto_tutari;
    
        if (aratplm_ < 0) {
            let focused = $(':focus');
            focused.val(0);
            swetAlert("Uyarı", "Ara toplam 0'dan küçük olamaz. Lütfen girdiğiniz değerleri kontrol edin", "err");
            return;
        }
    
        // KDV hesaplama
        let kdv = $("#slct_kdv_" + gln).val();
        let k = 0;
        if (kdv > 0) {
            k = kdv / 100;
        }
        let kdv_ = aratplm_ * k;
        let tplm = aratplm_ + kdv_;
    
        // Sonuçları forma yazma (number_format kullanmadan)
        $("#txt_kdv_" + gln).val(number_format(kdv_, 2, ',', '.'));
        $("#txt_ara_toplam_" + gln).val(number_format(aratplm_, 2, ',', '.'));
        $("#txt_genel_toplam_" + gln).val(number_format(tplm, 2, ',', '.'));
        
        // Tevkifat hesaplamaları için de aynı şekilde
        if ($(".diger_vergi").attr("visible") === "true") {
            if ($("#slct_tevkifat_tipi_" + gln).val() != 0) {
                let tevkifat_oran = $("#txt_V9015_oran_" + gln).val();
                let tevkifat_ = kdv_ * (tevkifat_oran / 100);
        
                $("#txt_V9015_" + gln).val(number_format(tevkifat_, 2, ',', '.'));
                $("#txt_V9015_islem_tutar_" + gln).val(number_format(aratplm_, 2, ',', '.'));
                $("#txt_V9015_hesaplanan_kdv_" + gln).val(number_format(kdv_, 2, ',', '.'));
            }
        }
    
        fatura_genel_toplam();
    }

    

    function fatura_satir_hesapla_geneltoplamdan(gln) {
        if ($("#txt_genel_toplam_" + gln).val() == "") {
            var genel_toplam = 0;
        } else {

            console.log("satir genel toplam1 ---> ", $("#txt_genel_toplam_" + gln).val());

            var genel_toplam = $("#txt_genel_toplam_" + gln)
                .val()
                .replace(".", "")
                .replace(",", ".");
            console.log("satir genel toplam ---> ", genel_toplam);
        }
        var kdv = $("#slct_kdv_" + gln).val();
        var k = 1;
        if (kdv > 0) {
            k = parseFloat(kdv) + 100;
        }

        var kdv_ = (parseFloat(genel_toplam) / parseFloat(k)) * parseFloat(kdv);
        var aratplm_ = parseFloat(genel_toplam) - parseFloat(kdv_);

        // if ($('#txt_iskonto_orani_' + gln).val() == '') {
        //   var iskonto_orani = 0;
        // } else {
        //   var iskonto_orani = $('#txt_iskonto_orani_' + gln).val().replace('.', '').replace(',', '.');
        // }

        if ($("#txt_iskonto_tutari_" + gln).val() == "") {
            var iskonto_tutari = 0;
        } else {
            var iskonto_tutari = $("#txt_iskonto_tutari_" + gln).val().replace(".", "").replace(",", ".");
        }
        if ($("#txt_miktar_" + gln).val() == "") {
            var miktar = 0;
        } else {
            var miktar = $("#txt_miktar_" + gln)
                .val()
                .replace(".", "")
                .replace(",", ".");
        }

        var birim_miktar = parseFloat(aratplm_) + parseFloat(iskonto_tutari);

        var birim_fiyat = parseFloat(birim_miktar) / parseFloat(miktar);

        $("#txt_birim_fiyat_" + gln).val(number_format((birim_fiyat), 2, ',', '.'));
        $("#txt_ara_toplam_" + gln).val(number_format((aratplm_), 2, ',', '.'));
        $("#txt_kdv_" + gln).val(number_format((kdv_), 2, ',', '.'));

        var tevkifat_oran = 0;
        var tevkifat_ = 0;
        // if ($(".diger_vergi").is(":visible")) {
        if ($(".diger_vergi").attr("visible", "true")) {
            if ($("#slct_tevkifat_tipi_" + gln).val() != 0) {
                tevkifat_oran = $("#txt_V9015_oran_" + gln).val();

                tevkifat_ = kdv_ * (tevkifat_oran / 100);

            }

            $("#txt_V9015_" + gln).val(number_format((tevkifat_), 2, ',', '.'));
            $("#txt_V9015_islem_tutar_" + gln).val(number_format((aratplm_), 2, ',', '.'));
            $("#txt_V9015_hesaplanan_kdv_" + gln).val(number_format((kdv_), 2, ',', '.'));
        }

        fatura_genel_toplam();
    }

    //Toplam Tutar DEğiştiğinde
    $(document).on("keyup", ".ftr_tplm", function () {
        fatura_satir_hesapla($(this).attr("satir"));
    });

    //genel toplandan geri hesapla
    $(document).on("keyup", ".genel_toplam_hesapla", function () {
        // $(this).val($(this).val().replace(',','.'));
        // alert($(this).attr('satir'));

        fatura_satir_hesapla_geneltoplamdan($(this).attr("satir"));
    });

    $(document).on("keyup", ".ftr_hesap_iskonto_tutar", function () {
        var gln = $(this).attr("satir");
        $("#txt_iskonto_orani_" + gln).val("");

        // alert($('#txt_iskonto_tutari_' + gln).val());

        // fatura_satir_hesapla(gln);
    });


    $(document).on("keyup", ".ftr_hesap_iskonto_yuzde", function () {
        var gln = $(this).attr("satir");
        if ($("#txt_birim_fiyat_" + gln).val() == "") {
            var birim_fiyat = 0;
        } else {
            var birim_fiyat = $("#txt_birim_fiyat_" + gln)
                .val()
                .replace(".", "")
                .replace(",", ".");
        }
        if ($("#txt_miktar_" + gln).val() == "") {
            var miktar = 0;
        } else {
            var miktar = $("#txt_miktar_" + gln)
                .val()
                .replace(".", "")
                .replace(",", ".");
        }

        if ($("#txt_iskonto_orani_" + gln).val() == "") {
            var iskonto_orani = 0;
        } else {
            var iskonto_orani = $("#txt_iskonto_orani_" + gln)
                .val()
                .replace(".", "")
                .replace(",", ".");
        }

        var iskonto_tutari = birim_fiyat * miktar * (iskonto_orani / 100);
        if ($("#txt_iskonto_orani_" + gln).val() != "") {
            $("#txt_iskonto_tutari_" + gln).val(number_format(iskonto_tutari, 2, ',', '.'));
            $("#txt_iskonto_tutari_" + gln).attr(
                "dgr",
                number_format(iskonto_tutari, 2, ',', '.')
            );

            fatura_satir_hesapla(gln);
        }
    });



    $(document).on("click", ".btn_urun_sec", function () {
        var gln = $(this).attr("data-satir");
        var nereden = $(this).attr("data-nereden");

        $('#s_id').val(gln);
        $('#nereden').val(nereden);
        $('#mdl_urunSec').modal('show');



        $(".custom-radio").attr('checked', false);

    });


    $(document).on("change", "#chx_quickSale", function () {
        if (this.checked) {
            console.log("tüm kdv'ler 0 olacak");

            $('.baseFirstTax').each(function (index) {
                console.log("baseFirstTax_" + index);
                // $(this).val(0);


                $('#slct_kdv_' + index).val(0);
                $('#slct_kdv_' + index).trigger('change');
            });

        } else {
            console.log("tüm kdv'leri eski haline dönecek");

            $('.baseFirstTax').each(function (index) {
                console.log("baseFirstTax_" + index);
                console.log("kdv eski hali", $(this).val());

                $('#slct_kdv_' + index).val($(this).val());
                $('#slct_kdv_' + index).trigger('change');

                if (index == 1) {
                    $('#slct_kdv_0').val($(this).val());
                    $('#slct_kdv_0').trigger('change');
                }

            });
        }
    });




    $(document).on("click", ".btnModalStockOrder", function () {

        var s_id = $('#s_id').val();
        $('#mdl_urunSec').modal('hide');
  

       
        selectedStockId = $('.rd_stock:checked').val();

        selectedParentId = $('.rd_stock:checked').attr('data-stock-parent-id');

        selectedStockCode = $('.rd_stock:checked').attr('data-stock-code');
        selectedStockHasVariant = $('.rd_stock:checked').attr('data-stock-has-variant');
        selectedStockType = $('.rd_stock:checked').attr('data-stock-type');
        selectedStockText = $('.rd_stock:checked').attr('data-stock-title');
        selectedStockSaleUnitId = $('.rd_stock:checked').attr('data-stock-unit');
        selectedStockSaleUnitPrice = $('.rd_stock:checked').attr('data-stock-unit-price');
        selectedStockSaleUnitSaleTaxRate1 = $('.rd_stock:checked').attr('data-stock-unit-sale-tax-rate');
        selectedStockSaleUnitSaleTaxRate = parseInt(selectedStockSaleUnitSaleTaxRate1);
        selectedStockQuantity = $('.rd_stock:checked').attr('data-stock-quantity');
        selectedWarehouseId = $('.rd_stock:checked').attr('data-stock-warehouse-id');



       /*  console.log('s_id ' + s_id);
        console.log('selectedStockId ' + selectedStockId);
        console.log('selectedStockCode ' + selectedStockCode);
        console.log('selectedParentkId ' + selectedParentId);
        console.log('selectedStockHasVariant ' + selectedStockHasVariant);
        console.log('selectedStockType ' + selectedStockType);
        console.log(' selectedStockText ' + selectedStockText);
        console.log(' selectedStockSaleUnitId ' + selectedStockSaleUnitId);
        console.log(' selectedStockSaleUnitPrice ' + selectedStockSaleUnitPrice);
        console.log(' selectedStockSaleUnitSaleTaxRate ' + selectedStockSaleUnitSaleTaxRate);
        console.log(' selectedStockQuantity ' + selectedStockQuantity);
        console.log(' selectedWarehouseId ' + selectedWarehouseId); */

        // var pageURL = $(location).attr("href");
        // var segments = pageURL.split( '/' );
        // var page_type = segments[4]; //invoice,order,offer

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

   

        if(neredeyim == 'offer'){

            $('#txt_aciklama_' + s_id).val(selectedStockText);

            $('#txt_aciklama_' + s_id).attr("urun_id", selectedStockId);

            $('#txt_miktar_' + s_id).val(1);

            $('#txt_warehouse_id_' + s_id).val(selectedWarehouseId);
            $('#slct_birim_' + s_id).val(selectedStockSaleUnitId);
            $('#slct_birim_' + s_id).trigger('change');

            if (selectedStockSaleUnitPrice == '0,00' || selectedStockSaleUnitPrice == '0,0000' || selectedStockSaleUnitPrice == '0.00' || selectedStockSaleUnitPrice == '0.0000') {
                $('#txt_birim_fiyat_' + s_id).val('');
            } else {
                // $('#txt_birim_fiyat_' + s_id).val(selectedStockSaleUnitPrice.replace('.', ''));
                $('#txt_birim_fiyat_' + s_id).val(number_format(selectedStockSaleUnitPrice, para_yuvarlama, ',', '.'));
            }

            $('#baseFirstTax_' + s_id).val(selectedStockSaleUnitSaleTaxRate);

            if ($('#chx_quickSale').is(':checked')) {
                $('#slct_kdv_' + s_id).val(0);
                $('#slct_kdv_' + s_id).trigger('change');
            } else {
                $('#slct_kdv_' + s_id).val(selectedStockSaleUnitSaleTaxRate);
                $('#slct_kdv_' + s_id).trigger('change');
            }

        }

      
        if ($("#ftr_alis").is(":checked")) {
            ftr_turum = 1;
        } else if ($("#ftr_satis").is(":checked")) {
            ftr_turum = 0;
        } else {
            ftr_turum = 0;
        }

        console.log("fatura tipi", ftr_turum);
        if (ftr_turum == 0 && selectedStockType == 'product' && page_type != 'order' && page_type != 'offer') {
            if (selectedStockQuantity <= 0 || (selectedParentId == 0 && selectedStockHasVariant == 1)) {
                if(neredeyim != 'offer'){
                    swetAlert("Uyarı!", selectedStockText + " ürünü eklenemez. <br>  Stok durumu uygun değil veya ana ürün.", "err");
                }
            } else {
                $('#txt_aciklama_' + s_id).val(selectedStockText);

                $('#txt_aciklama_' + s_id).attr("urun_id", selectedStockId);

                $('#txt_miktar_' + s_id).val(1);

                $('#txt_warehouse_id_' + s_id).val(selectedWarehouseId);
                $('#slct_birim_' + s_id).val(selectedStockSaleUnitId);
                $('#slct_birim_' + s_id).trigger('change');

                if (selectedStockSaleUnitPrice == '0,00' || selectedStockSaleUnitPrice == '0,0000' || selectedStockSaleUnitPrice == '0.00' || selectedStockSaleUnitPrice == '0.0000') {
                    $('#txt_birim_fiyat_' + s_id).val('');
                } else {
                    // $('#txt_birim_fiyat_' + s_id).val(selectedStockSaleUnitPrice.replace('.', ''));
                    $('#txt_birim_fiyat_' + s_id).val(number_format(selectedStockSaleUnitPrice, para_yuvarlama, ',', '.'));
                }

                $('#baseFirstTax_' + s_id).val(selectedStockSaleUnitSaleTaxRate);

                if ($('#chx_quickSale').is(':checked')) {
                    $('#slct_kdv_' + s_id).val(0);
                    $('#slct_kdv_' + s_id).trigger('change');
                } else {
                    $('#slct_kdv_' + s_id).val(selectedStockSaleUnitSaleTaxRate);
                    $('#slct_kdv_' + s_id).trigger('change');
                }
            }
        }
        else {
            $('#txt_aciklama_' + s_id).val(selectedStockText);

            $('#txt_aciklama_' + s_id).attr("urun_id", selectedStockId);

            $('#txt_miktar_' + s_id).val(1);

            $('#txt_warehouse_id_' + s_id).val(selectedWarehouseId);
            $('#slct_birim_' + s_id).val(selectedStockSaleUnitId);
            $('#slct_birim_' + s_id).trigger('change');

            if (selectedStockSaleUnitPrice == '0,00' || selectedStockSaleUnitPrice == '0,0000' || selectedStockSaleUnitPrice == '0.00' || selectedStockSaleUnitPrice == '0.0000') {
                $('#txt_birim_fiyat_' + s_id).val('');
            } else {
                $('#txt_birim_fiyat_' + s_id).val(number_format(selectedStockSaleUnitPrice, para_yuvarlama, ',', '.'));
            }

            $('#baseFirstTax_' + s_id).val(selectedStockSaleUnitSaleTaxRate);
            if ($('#chx_quickSale').is(':checked')) {
                $('#slct_kdv_' + s_id).val(0);
                $('#slct_kdv_' + s_id).trigger('change');
            } else {
                $('#slct_kdv_' + s_id).val(selectedStockSaleUnitSaleTaxRate);
                $('#slct_kdv_' + s_id).trigger('change');
            }
        }
    });






    //  btn_mdl_urunSec - SUBSTOCKS TIKLAMA VE TABLOYA YAZMA

     $(document).on("click", ".btnModalSubStock", function () {
        var s_id = $('#s_id').val();
        $('#mdl_urunSec').modal('hide');
        $('#mdl_SubUrunSec').modal('hide'); 
        
        selectedStockId = $('.rd_substock:checked').val();
        selectedParentId = $('.rd_substock:checked').attr('data-stock-parent-id');
        selectedStockCode = $('.rd_substock:checked').attr('data-stock-code');
        selectedStockHasVariant = $('.rd_substock:checked').attr('data-stock-has-variant');
        selectedStockType = $('.rd_substock:checked').attr('data-stock-type');
        selectedStockText = $('.rd_substock:checked').attr('data-stock-title');
        selectedStockSaleUnitId = $('.rd_substock:checked').attr('data-stock-unit');
        selectedStockSaleUnitPrice = $('.rd_substock:checked').attr('data-stock-unit-price');
        selectedStockSaleUnitSaleTaxRate1 = $('.rd_substock:checked').attr('data-stock-unit-sale-tax-rate');
        selectedStockSaleUnitSaleTaxRate = parseInt(selectedStockSaleUnitSaleTaxRate1);
        selectedStockQuantity = $('.rd_substock:checked').attr('data-stock-quantity');
        selectedWarehouseId = $('.rd_substock:checked').attr('data-stock-warehouse-id');

// satır numarasını da al
$('.btn_urun_eski_fiyat[data-satir="' + s_id + '"]')
    .removeClass('btn-dim')
    .removeAttr('disabled')
    .attr('data-urun_id', selectedStockId);

        console.log('s_id ' + s_id);
        console.log('selectedStockId ' + selectedStockId);
        console.log('selectedStockCode ' + selectedStockCode);
        console.log('selectedParentkId ' + selectedParentId);
        console.log('selectedStockHasVariant ' + selectedStockHasVariant);
        console.log('selectedStockType ' + selectedStockType);
        console.log(' selectedStockText ' + selectedStockText);
        console.log(' selectedStockSaleUnitId ' + selectedStockSaleUnitId);
        console.log(' selectedStockSaleUnitPrice ' + selectedStockSaleUnitPrice);
        console.log(' selectedStockSaleUnitSaleTaxRate ' + selectedStockSaleUnitSaleTaxRate);
        console.log(' selectedStockQuantity ' + selectedStockQuantity);
        console.log(' selectedWarehouseId ' + selectedWarehouseId);




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

   
        if(neredeyim == 'offer'){

            $('#txt_aciklama_' + s_id).val(selectedStockText);

                $('#txt_aciklama_' + s_id).attr("urun_id", selectedStockId);

                $('#txt_miktar_' + s_id).val(1);

                $('#txt_warehouse_id_' + s_id).val(selectedWarehouseId);
                $('#slct_birim_' + s_id).val(selectedStockSaleUnitId);
                $('#slct_birim_' + s_id).trigger('change');

                if (selectedStockSaleUnitPrice == '0,00' || selectedStockSaleUnitPrice == '0,0000' || selectedStockSaleUnitPrice == '0.00' || selectedStockSaleUnitPrice == '0.0000') {
                    $('#txt_birim_fiyat_' + s_id).val('');
                } else {
                    // $('#txt_birim_fiyat_' + s_id).val(selectedStockSaleUnitPrice.replace('.', ''));
                    $('#txt_birim_fiyat_' + s_id).val(number_format(selectedStockSaleUnitPrice, para_yuvarlama, ',', '.'));
                }

                $('#baseFirstTax_' + s_id).val(selectedStockSaleUnitSaleTaxRate);

                if ($('#chx_quickSale').is(':checked')) {
                    $('#slct_kdv_' + s_id).val(0);
                    $('#slct_kdv_' + s_id).trigger('change');
                } else {
                    $('#slct_kdv_' + s_id).val(selectedStockSaleUnitSaleTaxRate);
                    $('#slct_kdv_' + s_id).trigger('change');
                }

        }

        if ($("#ftr_alis").is(":checked")) {
            ftr_turum = 1;
        } else if ($("#ftr_satis").is(":checked")) {
            ftr_turum = 0;
        } else {
            ftr_turum = 0;
        }


        if (ftr_turum == 0 && selectedStockType == 'product' && page_type != 'order') {
            if (selectedStockQuantity <= 0 || (selectedParentId == 0 && selectedStockHasVariant == 1)) {
                if(neredeyim != 'offer'){
                    swetAlert("Uyarı!", selectedStockText + " ürünü eklenemez. <br> Stok durumu uygun değil veya ana ürün.", "err");
                }
            } else {
                $('#txt_aciklama_' + s_id).val(selectedStockText);

                $('#txt_aciklama_' + s_id).attr("urun_id", selectedStockId);

                $('#txt_miktar_' + s_id).val(1);

                $('#txt_warehouse_id_' + s_id).val(selectedWarehouseId);
                $('#slct_birim_' + s_id).val(selectedStockSaleUnitId);
                $('#slct_birim_' + s_id).trigger('change');

                if (selectedStockSaleUnitPrice == '0,00' || selectedStockSaleUnitPrice == '0,0000' || selectedStockSaleUnitPrice == '0.00' || selectedStockSaleUnitPrice == '0.0000') {
                    $('#txt_birim_fiyat_' + s_id).val('');
                } else {
                    // $('#txt_birim_fiyat_' + s_id).val(selectedStockSaleUnitPrice.replace('.', ''));
                    $('#txt_birim_fiyat_' + s_id).val(number_format(selectedStockSaleUnitPrice, para_yuvarlama, ',', '.'));
                }

                $('#baseFirstTax_' + s_id).val(selectedStockSaleUnitSaleTaxRate);

                if ($('#chx_quickSale').is(':checked')) {
                    $('#slct_kdv_' + s_id).val(0);
                    $('#slct_kdv_' + s_id).trigger('change');
                } else {
                    $('#slct_kdv_' + s_id).val(selectedStockSaleUnitSaleTaxRate);
                    $('#slct_kdv_' + s_id).trigger('change');
                }
            }
        }
        else {
            $('#txt_aciklama_' + s_id).val(selectedStockText);

            $('#txt_aciklama_' + s_id).attr("urun_id", selectedStockId);

            $('#txt_miktar_' + s_id).val(1);

            $('#txt_warehouse_id_' + s_id).val(selectedWarehouseId);
            $('#slct_birim_' + s_id).val(selectedStockSaleUnitId);
            $('#slct_birim_' + s_id).trigger('change');

            if (selectedStockSaleUnitPrice == '0,00' || selectedStockSaleUnitPrice == '0,0000' || selectedStockSaleUnitPrice == '0.00' || selectedStockSaleUnitPrice == '0.0000') {
                $('#txt_birim_fiyat_' + s_id).val('');
            } else {
                $('#txt_birim_fiyat_' + s_id).val(number_format(selectedStockSaleUnitPrice, para_yuvarlama, ',', '.'));
            }

            $('#baseFirstTax_' + s_id).val(selectedStockSaleUnitSaleTaxRate);
            if ($('#chx_quickSale').is(':checked')) {
                $('#slct_kdv_' + s_id).val(0);
                $('#slct_kdv_' + s_id).trigger('change');
            } else {
                $('#slct_kdv_' + s_id).val(selectedStockSaleUnitSaleTaxRate);
                $('#slct_kdv_' + s_id).trigger('change');
            }
        }
    });


   

    function formatTurkishNumber(number) {
        // Sayıyı iki ondalık basamaklı hale getirir
        let parts = number.toFixed(2).split("."); // Virgülden önce ve sonrası
        // Binlik ayraçları ekler
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        // Ondalık ayırıcı olarak virgül kullanır
        return parts.join(",");
    }
    
    

   
    function fatura_genel_toplam() {

        
        var ii = parseInt($("#str_s").val());

        var doviz = $("#txt_doviz_kuru").val();
        doviz = (doviz === null || doviz === undefined || doviz.trim() === "") ? 1 : doviz;

        var kur = 1;
        var brmfyt = 0;
        var mktr = 0;
        var aratplm = 0;
        var isk_ttr = 0;
        var aratplm2 = 0;
        // var tutartplm0 = 0;
        var tutartplm0 = 0;
        var tutartplm1 = 0;
        var tutartplm10 = 0;
        var tutartplm20 = 0;
        var kdvtplm1 = 0;
        var kdvtplm10 = 0;
        var kdvtplm20 = 0;
        var gnltplm = 0;
        var tevkifattplm = 0;
        var tevkifatislemttr = 0;
        var tevkifatislemkdv = 0;

        for (var i = 0; i <= ii; i++) {
            // if ($("#Satir_" + i).is(":visible") == true) {
            if ($("#Satir_" + i).attr("visible") == "true") {
                // console.log("hangi satÄ±r iÃ§in burdayÄ±z: " + i);
         brmfyt = parseFloat(
                    $("#txt_birim_fiyat_" + i).val() == "" ||
                    $("#txt_birim_fiyat_" + i).val() == undefined
                        ? "0"
                        : $("#txt_birim_fiyat_" + i)
                            .val()
                            .replace(".", "")
                            .replace(",", ".")
                ).toFixed(para_yuvarlama);

                console.log(brmfyt);

                mktr = parseFloat(
                    $("#txt_miktar_" + i).val() == "" ||
                        $("#txt_miktar_" + i).val() == undefined ?
                        "0" :
                        $("#txt_miktar_" + i)
                            .val()
                            .replace(".", "")
                            .replace(",", ".")
                );

                // aratplm = parseFloat(aratplm) + (brmfyt * mktr);

                aratplm = parseFloat(
                    $("#txt_ara_toplam_" + i).val() == "" ||
                        $("#txt_ara_toplam_" + i).val() == undefined ?
                        "0" :
                        $("#txt_ara_toplam_" + i)
                            .val()
                            .replace(".", "")
                            .replace(",", ".")
                );

                isk_ttr =
                    parseFloat(isk_ttr) +
                    parseFloat(
                        $("#txt_iskonto_tutari_" + i).val() == "" ||
                            $("#txt_iskonto_tutari_" + i).val() == undefined ?
                            "0" :
                            $("#txt_iskonto_tutari_" + i)
                                .val()
                                .replace(".", "")
                                .replace(",", ".")
                    );

                aratplm2 = parseFloat(aratplm2) + parseFloat(aratplm);

                switch ($("#slct_kdv_" + i).val()) {

                    case "0":
                        tutartplm0 =
                            parseFloat(tutartplm0) +
                            parseFloat(
                                $("#txt_ara_toplam_" + i).val() == "" ||
                                    $("#txt_ara_toplam_" + i).val() == undefined ?
                                    "0" :
                                    $("#txt_ara_toplam_" + i)
                                        .val()
                                        .replace(".", "")
                                        .replace(",", ".")
                            );
                        break;
                    case "1":
                        tutartplm1 =
                            parseFloat(tutartplm1) +
                            parseFloat(
                                $("#txt_ara_toplam_" + i).val() == "" ||
                                    $("#txt_ara_toplam_" + i).val() == undefined ?
                                    "0" :
                                    $("#txt_ara_toplam_" + i)
                                        .val()
                                        .replace(".", "")
                                        .replace(",", ".")
                            );
                        kdvtplm1 =
                            parseFloat(kdvtplm1) +
                            parseFloat(
                                $("#txt_kdv_" + i).val() == "" ||
                                    $("#txt_kdv_" + i).val() == undefined ?
                                    "0" :
                                    $("#txt_kdv_" + i)
                                        .val()
                                        .replace(".", "")
                                        .replace(",", ".")
                            );
                        break;
                    case "10":
                        tutartplm10 =
                            parseFloat(tutartplm10) +
                            parseFloat(
                                $("#txt_ara_toplam_" + i).val() == "" ||
                                    $("#txt_ara_toplam_" + i).val() == undefined ?
                                    "0" :
                                    $("#txt_ara_toplam_" + i)
                                        .val()
                                        .replace(".", "")
                                        .replace(",", ".")
                            );
                        kdvtplm10 =
                            parseFloat(kdvtplm10) +
                            parseFloat(
                                $("#txt_kdv_" + i).val() == "" ||
                                    $("#txt_kdv_" + i).val() == undefined ?
                                    "0" :
                                    $("#txt_kdv_" + i)
                                        .val()
                                        .replace(".", "")
                                        .replace(",", ".")
                            );
                        break;
                    case "20":
                        tutartplm20 =
                            parseFloat(tutartplm20) +
                            parseFloat(
                                $("#txt_ara_toplam_" + i).val() == "" ||
                                    $("#txt_ara_toplam_" + i).val() == undefined ?
                                    "0" :
                                    $("#txt_ara_toplam_" + i)
                                        .val()
                                        .replace(".", "")
                                        .replace(",", ".")
                            );
                        kdvtplm20 =
                            parseFloat(kdvtplm20) +
                            parseFloat(
                                $("#txt_kdv_" + i).val() == "" ||
                                    $("#txt_kdv_" + i).val() == undefined ?
                                    "0" :
                                    $("#txt_kdv_" + i)
                                        .val()
                                        .replace(".", "")
                                        .replace(",", ".")
                            );
                        break;
                    default:
                        break;
                }

                if (kdvtplm1 <= 0) {
                    $('#visibleKdv1').addClass('d-none');
                } else {
                    $('#visibleKdv1').removeClass('d-none');
                }
                if (kdvtplm10 <= 0) {
                    $('#visibleKdv10').addClass('d-none');
                } else {
                    $('#visibleKdv10').removeClass('d-none');
                }
                if (kdvtplm20 <= 0) {
                    $('#visibleKdv20').addClass('d-none');
                } else {
                    $('#visibleKdv20').removeClass('d-none');
                }

                // if ($(".diger_vergi").is(":visible")) {
                if ($(".diger_vergi").attr("visible", "true")) {
                    // console.log("diÄŸer vergi aÃ§Ä±k. if'deyiz");
                    if ($("#slct_tevkifat_tipi_" + i).val() != 0) {
                        // console.log("#slct_tevkifat_tipi_" + i + " : " + $("#slct_tevkifat_tipi_" + i).val());
                        tevkifatislemttr =
                            parseFloat(tevkifatislemttr) +
                            parseFloat(
                                $("#txt_V9015_islem_tutar_" + i)
                                    .val()
                                    .replace(".", "")
                                    .replace(",", ".")
                            );
                        // console.log("#slct_tevkifat_tipi_" + i + " : tevkifatislemttr: " + tevkifatislemttr);

                        tevkifatislemkdv =
                            parseFloat(tevkifatislemkdv) +
                            parseFloat(
                                $("#txt_V9015_hesaplanan_kdv_" + i)
                                    .val()
                                    .replace(".", "")
                                    .replace(",", ".")
                            );
                        // console.log("#slct_tevkifat_tipi_" + i + " : tevkifatislemkdv: " + tevkifatislemkdv);

                        tevkifattplm =
                            parseFloat(tevkifattplm) +
                            parseFloat(
                                $("#txt_V9015_" + i)
                                    .val()
                                    .replace(".", "")
                                    .replace(",", ".")
                            );
                        // console.log("#slct_tevkifat_tipi_" + i + " : tevkifattplm: " + tevkifattplm);

                    }
                }
            }
        }

        kur = $("#txt_doviz_kuru")
            .val()
            .replace(".", "")
            .replace(",", ".");





        gnltplm = parseFloat(aratplm2) + parseFloat(kdvtplm1 + kdvtplm10 + kdvtplm20);

        $("#txt_kdvsiz_toplam").val(number_format((aratplm2 + isk_ttr), para_yuvarlama, ',', '.'));
        $("#txt_kdvsiz_toplam_dvz").val(number_format(((aratplm2 + isk_ttr) * kur), 2, ',', '.'));

        $("#txt_iskonto_toplam").val(number_format((isk_ttr), 2, ',', '.'));
        $("#txt_iskonto_toplam_dvz").val(number_format((isk_ttr * kur), 2, ',', '.'));

        $("#txt_ara_toplam").val(number_format((aratplm2 - isk_ttr), para_yuvarlama, ',', '.'));
        $("#txt_ara_toplam_dvz").val(number_format((aratplm2 - isk_ttr) * kur, 2, ',', '.'));

        $("#txt_tutar_toplam0").val(number_format((tutartplm0), 2, ',', '.'));
        $('#txt_tutar_toplam0_dvz').val(number_format((tutartplm0 * kur), 2, ',', '.'));

        $("#txt_tutar_toplam1").val(number_format((tutartplm1), 2, ',', '.'));
        $('#txt_tutar_toplam1_dvz').val(number_format((tutartplm1 * kur), 2, ',', '.'));

        $("#txt_tutar_toplam10").val(number_format((tutartplm10), 2, ',', '.'));
        $('#txt_tutar_toplam10_dvz').val(number_format((tutartplm10 * kur), 2, ',', '.'));

        $("#txt_tutar_toplam20").val(number_format((tutartplm20), 2, ',', '.'));
        $('#txt_tutar_toplam20_dvz').val(number_format((tutartplm20 * kur), 2, ',', '.'));

        $("#txt_kdv_toplam1").val(number_format((kdvtplm1), 2, ',', '.'));
        $("#txt_kdv_toplam1_dvz").val(number_format((kdvtplm1 * kur), 2, ',', '.'));

        $("#txt_kdv_toplam10").val(number_format((kdvtplm10), 2, ',', '.'));
        $("#txt_kdv_toplam10_dvz").val(number_format((kdvtplm10 * kur), 2, ',', '.'));

        $("#txt_kdv_toplam20").val(number_format((kdvtplm20), 2, ',', '.'));
        $("#txt_kdv_toplam20_dvz").val(number_format((kdvtplm20 * kur), 2, ',', '.'));

        $("#txt_genel_toplam").val(number_format((gnltplm), para_yuvarlama, ',', '.'));
        $("#txt_genel_toplam_dvz").val(number_format((gnltplm * kur), 2, ',', '.'));

        $("#txt_V9015_islem_tutar").val(number_format((tevkifatislemttr), 2, ',', '.'));
        $("#txt_V9015_islem_tutar_dvz").val(number_format((tevkifatislemttr * kur), 2, ',', '.'));

        $("#txt_V9015_hesaplanan_kdv").val(number_format((tevkifatislemkdv), 2, ',', '.'));
        $("#txt_V9015_hesaplanan_kdv_dvz").val(number_format((tevkifatislemkdv * kur), 2, ',', '.'));

        $("#txt_V9015").val(number_format((tevkifattplm), 2, ',', '.'));
        $("#txt_V9015_dvz").val(number_format((tevkifattplm * kur), 2, ',', '.'));

        $("#txt_odenecek_tutar").val(number_format((gnltplm - tevkifattplm), para_yuvarlama, ',', '.'));
        $("#txt_odenecek_tutar_dvz").val(number_format(((gnltplm - tevkifattplm) * kur), 2, ',', '.'));




          // Genel toplam ve diÄŸer deÄŸerler
          var GenelToplamFull = (gnltplm - tevkifattplm); // Ä°lk genel toplam hesaplamasÄ±
        
          // SeÃ§ilen para birimi
          var anlikParaBirimi = $('#slct_doviz_tipi').find(":selected").attr("data-money-unit-code"); // Ã–rneÄŸin USD, EUR
      
          // Kurlar Ã¼zerinde dÃ¶ngÃ¼ yaparak hesaplama
          kurlar.forEach(function(kur) {
              // Kur fiyatÄ± anahtarÄ±nÄ± oluÅŸtur
              var kurFiyatKey = 'kur_fiyat_' + kur.money_code; // Ã–rnek: 'kur_fiyat_USD'
              var kurFiyat = 0; // VirgÃ¼lÃ¼ noktaya Ã§evirip float yapÄ±yoruz
      
              // EÄŸer seÃ§ilen para birimi farklÄ±ysa hesaplamayÄ± yap
              var toplamFiyat;
              if (anlikParaBirimi === kur.money_code) {
                  // EÄŸer seÃ§ilen para birimi aynÄ±ysa (Ã¶rn. USD), genel toplamÄ± direkt alÄ±rÄ±z
                  toplamFiyat = GenelToplamFull;
              } else {
                  // Bu kÄ±sÄ±mda TRY veya diÄŸer kurlar iÃ§in input deÄŸerini alÄ±yoruz
                  var kurInputValue = 0;
      
                  if(kur.money_code == "TRY") {
                      kurInputValue = $(".doviz_degis").val(); // TRY iÃ§in 'doviz_degis' sÄ±nÄ±fÄ±ndan deÄŸer alÄ±yoruz
                      if (!kurInputValue) {
                          console.log("TRY iÃ§in input deÄŸeri bulunamadÄ±.");
                      }
                  } else {
                      kurInputValue = $("#kur_fiyat_" + kur.money_code).val(); // DiÄŸer kurlar iÃ§in ID'den alÄ±yoruz
                      if (!kurInputValue) {
                          console.log(kur.money_code + " iÃ§in input deÄŸeri bulunamadÄ±.");
                      }
                  }
      
                  if (kurInputValue) {
                      kurFiyat = parseFloat(kurInputValue.replace(",", ".")); // Input deÄŸerini sayÄ±ya Ã§eviriyoruz
                  }
      
                  // SeÃ§ilen para birimi farklÄ±ysa dÃ¶nÃ¼ÅŸÃ¼m iÅŸlemi yap
                  if(anlikParaBirimi == "TRY"){
                      toplamFiyat = GenelToplamFull / kurFiyat; // Genel toplamÄ± kur fiyatÄ±na bÃ¶leriz

                  }else{
                      toplamFiyat = GenelToplamFull * kurFiyat; // Genel toplamÄ± kur fiyatÄ±na bÃ¶leriz

                  }
      
                 
              }
      
              // Kur toplam fiyatÄ±nÄ± string hale getirip gÃ¼ncelle
              var kurToplamFiyatKey = 'kur_toplam_fiyat_' + kur.money_code; // Ã–rnek: 'kur_toplam_fiyat_USD'
              kur[kurToplamFiyatKey] = toplamFiyat.toFixed(2); // Sonucu iki ondalÄ±klÄ± hale getirir
      
              // Hesaplanan toplam fiyatÄ± ilgili input alanÄ±na yaz
              var toplamFiyatInput = document.querySelector('input[name="' + kurToplamFiyatKey + '"]');
              if (toplamFiyatInput) {
                  toplamFiyatInput.value = formatTurkishNumber(toplamFiyat); // Input alanÄ±na deÄŸeri yaz
              }
      
              // AynÄ± ÅŸekilde kur fiyatÄ±nÄ± da ilgili input alanÄ±na yaz
              var kurFiyatInput = document.querySelector('input[name="' + kurFiyatKey + '"]');
              if (kurFiyatInput) {
                  kurFiyatInput.value = formatTurkishNumber(kurFiyat); // Kur fiyatÄ± input alanÄ±na deÄŸeri yaz
              }
      
              // Input alanÄ± dinleyicisi ekleyelim ki kur fiyatÄ± deÄŸiÅŸirse hesaplamayÄ± gÃ¼ncelle
              if (kurFiyatInput) {
                  kurFiyatInput.addEventListener('keyup', function () {
                      // Input alanÄ±ndaki yeni deÄŸeri al ve sayÄ±ya dÃ¶nÃ¼ÅŸtÃ¼r
                      var newKurFiyat = parseFloat(kurFiyatInput.value.replace(",", "."));
              
                      // EÄŸer sayÄ± geÃ§erli deÄŸilse iÅŸlemi durdur
                      if (isNaN(newKurFiyat)) {
                          return;
                      }
              
                      // Yeni kur fiyatÄ± ile GenelToplamFull'Ã¼ yeniden Ã§arp/bÃ¶l
                      var newToplamFiyat;
                      if (anlikParaBirimi === kur.money_code) {
                          newToplamFiyat = GenelToplamFull; // EÄŸer aynÄ± para birimi ise, genel toplam direkt alÄ±nÄ±r
                      } else {
                          // TRY ise bÃ¶lme, diÄŸer para birimleri iÃ§in Ã§arpma iÅŸlemi yapÄ±lÄ±r
                          if (anlikParaBirimi == "TRY") {
                              newToplamFiyat = GenelToplamFull / newKurFiyat; // TRY iÃ§in genel toplamÄ± kur fiyatÄ±na bÃ¶leriz
                          } else {
                              newToplamFiyat = GenelToplamFull * newKurFiyat; // DiÄŸer para birimleri iÃ§in Ã§arparÄ±z
                          }
                      }
              
                      // Sonucu ilgili 'kur_toplam_fiyat_' inputuna yaz
                      if (toplamFiyatInput) {
                          toplamFiyatInput.value = formatTurkishNumber(newToplamFiyat);
                      }
              
                      // Kurlar dizisindeki ilgili objeyi gÃ¼ncelle
                      kur['kur_fiyat_' + kur.money_code] = newKurFiyat; // Kur fiyatÄ±nÄ± gÃ¼ncelle
                      kur['kur_toplam_fiyat_' + kur.money_code] = newToplamFiyat.toFixed(2); // Toplam fiyatÄ± gÃ¼ncelle
              
                      console.log('GÃ¼ncellenmiÅŸ kurlar:', kurlar); // GÃ¼ncellenmiÅŸ kurlar dizisini kontrol et
                  });
              }
          });
      


        if (gnltplm - tevkifattplm > 0) {

            if (kur == 0) {
                kur = 1;
            }
            yaziyla(number_format(((gnltplm - tevkifattplm) * kur), 2, ',', '.'));
        }
    }


    function kurDonustur(){


var selectedId = parseInt($("#slct_doviz_tipi").val());  // jQuery kullanarak seçili value'yu alıyoruz

// Kurlar üzerinde döngü yaparak tüm inputları gizle, eşleşeni göster
kurlar.forEach(function(kur) {
// Kur fiyat ve toplam fiyat inputlarını kontrol edelim
if (kur.money_unit_id === selectedId) {
// Eşleşen kurun satırını göster (d-none sınıfını kaldır)
$(".kur_table_" + kur.money_unit_id).addClass("d-none");
} else {
// Eşleşmeyenleri gizle (d-none sınıfını ekle)
$(".kur_table_" + kur.money_unit_id).removeClass("d-none");
}
});

// Select değiştiğinde de aynı işlem devam etsin
$("#slct_doviz_tipi").on('change', function() {
    // Seçilen option'un value (id) değerini al

    var selectedId = parseInt($("#slct_doviz_tipi").val());  // jQuery kullanarak seçili value'yu alıyoruz

// Kurlar üzerinde döngü yaparak tüm inputları gizle, eşleşeni göster
kurlar.forEach(function(kur) {
// Kur fiyat ve toplam fiyat inputlarını kontrol edelim
if (kur.money_unit_id === selectedId) {
// Eşleşen kurun satırını göster (d-none sınıfını kaldır)
$(".kur_table_" + kur.money_unit_id).addClass("d-none");
} else {
// Eşleşmeyenleri gizle (d-none sınıfını ekle)
$(".kur_table_" + kur.money_unit_id).removeClass("d-none");
}
});
    
});
    }

    kurDonustur();


    function enableDisabledInputs() {
        var disabledInputs = document.querySelectorAll('input[disabled]');
        var disabledSelect = document.querySelectorAll('select[disabled]');
        disabledInputs.forEach(function (input) {
            input.removeAttribute('disabled');
        });
        disabledSelect.forEach(function (input) {
            input.removeAttribute('disabled');
        });
    }

    function fatura_kayit($element, $crud) {

        enableDisabledInputs();

        var formDataInvoice = $('#createInvoice').serializeArray();
        var formDataOrder = $('#createOrder').serializeArray();
        var formDataOffer = $('#createOffer').serializeArray();

        var cariMoneyUnitId = $('#cari_money_unit_id').val();
        var cariMoneyUnitData = $('#cari_money_unit_data').val();
        var invoice_money_unit_id = $("#slct_doviz_tipi").val();
        var invoice_money_unit_icon = $('#slct_doviz_tipi').find(":selected").attr("data-money-unit-icon");
        var invoice_money_unit_code = $('#slct_doviz_tipi').find(":selected").attr("data-money-unit-code");

  


        let satir_sayi = $("#str_s").val();
        let satir_array = [];
        let satir = {};

        let fatura_satir_err = false;

        let fatura_tutar = {};

        let iiii = 0;

     

      /*   KONTROL EDİLECEK
        if (cariMoneyUnitId != invoice_money_unit_id) {
            Swal.fire({
                title: "Uyarı!",
                html: 'Cari para birimi ile fatura para birimi aynı değil. <br> İşleme devam etmek için lütfen bilgileri gözden geçiriniz. <br><br>Cari para birimi: '+cariMoneyUnitData,
                icon: "warning",
                confirmButtonText: 'Tamam',
            });
        } else {
      */

            for (let index = iiii; index <= satir_sayi; index++) {
                // alert($('#txt_gtip_' + index).val());

                console.log("dön babam dön_" + index);

                if ($("#Satir_" + index).is(":visible") == true) {

                    if ($("#txt_iskonto_orani_" + index).val() == "") {
                        var iskonto_o = 0;
                    } else {
                        var iskonto_o = $("#txt_iskonto_orani_" + index)
                            .val()
                            .replace(".", "")
                            .replace(",", ".");
                    }

                    if ($("#txt_iskonto_tutari_" + index).val() == "") {
                        var iskonto_t = 0;
                    } else {
                        var iskonto_t = $("#txt_iskonto_tutari_" + index)
                            .val()
                            .replace(".", "")
                            .replace(",", ".");
                    }
                    console.log("++++++++++ SATİR İD +++++++++++" + $("#txt_aciklama_" + index).attr("str_id"));
                    satir = {

                        // fatura_satir_sira: (index+1),
                        satir_id: $("#txt_aciklama_" + index).attr("str_id"),



                        stock_id: $("#txt_aciklama_" + index).attr("urun_id"),
                        stock_title: $("#txt_aciklama_" + index).val(),
                        varyantlar: $("#text_varyant" + index).val(),

                        stock_amount: parseFloat(
                            $("#txt_miktar_" + index)
                                .val()
                                .replace(".", "")
                                .replace(",", ".")
                        ),
                        unit_id: parseInt($("#slct_birim_" + index).val()),
                        unit_price: parseFloat(
                            $("#txt_birim_fiyat_" + index)
                                .val()
                                .replace(".", "")
                                .replace(",", ".")
                        ),

                        discount_rate: parseFloat(iskonto_o),
                        discount_price: parseFloat(iskonto_t),

                        //KDV'siz toplam satir_ara_toplam'a eşit
                        subtotal_price: parseFloat(
                            $("#txt_ara_toplam_" + index)
                                .val()
                                .replace(".", "")
                                .replace(",", ".")
                        ),


                        tax_id: parseInt($("#slct_kdv_" + index).val()),
                        tax_price: parseFloat(
                            $("#txt_kdv_" + index)
                                .val()
                                .replace(".", "")
                                .replace(",", ".")
                        ),

                        total_price: parseFloat(
                            $("#txt_genel_toplam_" + index)
                                .val()
                                .replace(".", "")
                                .replace(",", ".")
                        ),
                        warehouse_id: $("#txt_warehouse_id_" + index).val(),
                        invoice_row_id: $("#Satir_" + index).attr('invoice_row_id'),
                        order_row_id: $("#Satir_" + index).attr('order_row_id'),
                        offer_row_id: $("#Satir_" + index).attr('offer_row_id'),
                        gider_satir_id: $("#Satir_" + index).attr('gider_satir_id'),
                        gtip_code: $("#txt_gtip_" + index).val(),
                    };

                    (satir.withholding_id = $("#slct_tevkifat_tipi_" + index).val() ? $("#slct_tevkifat_tipi_" + index).val() : 0),
                        (satir.withholding_rate = $("#txt_V9015_oran_" + index).val() ? parseInt($("#txt_V9015_oran_" + index).val()) : 0),
                        (satir.withholding_price = $("#txt_V9015_" + index).val() ? parseFloat($("#txt_V9015_" + index).val().replace(".", "").replace(",", ".")) : 0),

                        satir_array.push(satir);

                    console.log(satir_array);

                    if (satir.stock_title == '' || isNaN(satir.unit_id) || isNaN(satir.stock_amount) || isNaN(satir.unit_price) || isNaN(satir.tax_id)) {
                        console.log("lütfen satırlarınızı kontol edinizzz....");

                        fatura_satir_err = true;
                    }


                } else {
                    // fatura_satir_sil(index);
                    satir = {
                        invoice_row_id: $("#Satir_" + index).attr('invoice_row_id'),
                        gider_satir_id: $("#Satir_" + index).attr('gider_satir_id'),
                        order_row_id: $("#Satir_" + index).attr('order_row_id'),
                        offer_row_id: $("#Satir_" + index).attr('offer_row_id'),
                        isDeletedInvoice: $("#Satir_" + index).attr('invoice_row_id'),
                        isDeletedOrder: $("#Satir_" + index).attr('order_row_id'),
                        isDeletedOffer: $("#Satir_" + index).attr('offer_row_id'),
                        isDeletedGider: $("#Satir_" + index).attr('gider_satir_id'),

                        stock_amount: $("#txt_miktar_" + index).val(),
                        warehouse_id: $("#txt_warehouse_id_" + index).val(),
                        stock_id: $("#txt_aciklama_" + index).attr("urun_id"),
                        // stock_amount: $("#txt_miktar_" + index).val() != null || $("#txt_miktar_" + index).val() != undefined ? parseFloat($("#txt_miktar_" + index).val().replace(".", "").replace(",", ".")) : 0,

                    };

                    satir_array.push(satir);

                }
            }


            let iade_satir_sayi = $("#iade_str_s").val();
            let iade_satir_array = [];
            let iade_satir = {};
            console.log("iade satır sayısı: " + iade_satir_sayi);

            let i4 = 0;

            for (let index = i4; index <= iade_satir_sayi; index++) {
                iade_satir = {
                    iade_tarih: $("#txt_iade_tarihi_" + index).val(),
                    iade_no: $("#txt_iade_fatura_no_" + index).val(),
                };

                iade_satir_array.push(iade_satir);
            }


            let irsaliye_satir_sayi = $("#irsaliye_str_s").val();
            let irsaliye_satir_array = [];
            let irsaliye_satir = {};
            console.log("irsaliye satır sayısı: " + irsaliye_satir_sayi);

            let i3 = 0;

            for (let index = i3; index <= irsaliye_satir_sayi; index++) {

                if ($("#txt_irsaliye_tarihi_" + index).val()) {
                    irsaliye_satir = {
                        irsaliye_tarih: $("#txt_irsaliye_tarihi_" + index).val(),
                        irsaliye_no: $("#txt_irsaliye_no_" + index).val(),
                    };

                    irsaliye_satir_array.push(irsaliye_satir);
                }
            }


            fatura_tutar = {
                money_unit_id: $("#slct_doviz_tipi").val(), // v2 Eklendi
                currency_amount: $("#txt_doviz_kuru").val(), // v2 Eklendi

                stock_total: $("#txt_kdvsiz_toplam")
                    .val()
                    .replace(".", ""),
                stock_total_try: $("#txt_kdvsiz_toplam_dvz")
                    .val()
                    .replace(".", ""),

                discount_total: $("#txt_iskonto_toplam")
                    .val()
                    .replace(".", ""),
                discount_total_try: $("#txt_iskonto_toplam_dvz")
                    .val()
                    .replace(".", ""),

                sub_total: $("#txt_ara_toplam")
                    .val()
                    .replace(".", ""),
                sub_total_try: $("#txt_ara_toplam_dvz")
                    .val()
                    .replace(".", ""),

                sub_total_all_tax0: $("#txt_tutar_toplam0")
                    .val()
                    .replace(".", ""),
                sub_total_all_tax0_try: $("#txt_tutar_toplam0_dvz")
                    .val()
                    .replace(".", ""),

                sub_total_all_tax1: $("#txt_tutar_toplam1")
                    .val()
                    .replace(".", ""),
                sub_total_all_tax1_try: $("#txt_tutar_toplam1_dvz")
                    .val()
                    .replace(".", ""),

                tax_rate_1_amount: $("#txt_kdv_toplam1")//1 olan kdvler toplamı
                    .val()
                    .replace(".", ""),
                tax_rate_1_amount_try: $("#txt_kdv_toplam1_dvz")
                    .val()
                    .replace(".", ""),

                sub_total_all_tax10: $("#txt_tutar_toplam10")
                    .val()
                    .replace(".", ""),
                sub_total_all_tax10_try: $("#txt_tutar_toplam10_dvz")
                    .val()
                    .replace(".", ""),

                tax_rate_10_amount: $("#txt_kdv_toplam10")//10 olan kdvler toplamı
                    .val()
                    .replace(".", ""),
                tax_rate_10_amount_try: $("#txt_kdv_toplam10_dvz")
                    .val()
                    .replace(".", ""),

                sub_total_all_tax20: $("#txt_tutar_toplam20")
                    .val()
                    .replace(".", ""),
                sub_total_all_tax20_try: $("#txt_tutar_toplam20_dvz")
                    .val()
                    .replace(".", ""),

                tax_rate_20_amount: $("#txt_kdv_toplam20") //20 olan kdvler toplamı
                    .val()
                    .replace(".", ""),
                tax_rate_20_amount_try: $("#txt_kdv_toplam20_dvz")
                    .val()
                    .replace(".", ""),

                grand_total: $("#txt_genel_toplam")
                    .val()
                    .replace(".", ""),
                grand_total_try: $("#txt_genel_toplam_dvz")
                    .val()
                    .replace(".", ""),

                amount_to_be_paid: $("#txt_odenecek_tutar")
                    .val()
                    .replace(".", ""),
                amount_to_be_paid_try: $("#txt_odenecek_tutar_dvz")
                    .val()
                    .replace(".", ""),

                amount_to_be_paid_text: $("#total_to_text").val(),

                vergiCesidi: $("#slct_vergi_tipi").val(),

                tevkifataTabiIslemTutar: $("#txt_V9015_islem_tutar")
                    .val()
                    .replace(".", ""),
                tevkifataTabiIslemTutar_try: $("#txt_V9015_islem_tutar_dvz")
                    .val()
                    .replace(".", ""),

                tevkifataTabiIslemKdv: $("#txt_V9015_hesaplanan_kdv")
                    .val()
                    .replace(".", ""),
                tevkifataTabiIslemKdv_try: $("#txt_V9015_hesaplanan_kdv_dvz")
                    .val()
                    .replace(".", ""),

                hesaplananTevkifat: $("#txt_V9015")
                    .val()
                    .replace(".", ""),
                hesaplananTevkifat_try: $("#txt_V9015_dvz")
                    .val()
                    .replace(".", ""),
            };

            if (has_collection === 1) {
                formDataInvoice.push({
                    name: "selectedAccount",
                    value: $('input[name="radioSizeAccount"]:checked').attr('id'),
                }, {
                    name: "selectedAccountMoneyId",
                    value: $('input[name="radioSizeAccount"]:checked').attr('accMoneyUnitId'),
                }, {
                    name: "collection_date",
                    value: $('#transaction_date').val(),
                });
            }

            if (ftr_turu == 1) {
                formDataInvoice.push({
                    name: "incoming_invoice_warehouse_id",
                    value: $('#warehouse_id').find(":selected").val()
                });
            }

            formDataInvoice.push({
                name: 'invoiceNotesId',
                value: $('#fatura_not_id').val(),
            });
            formDataInvoice.push({
                name: 'warehouse_id',
                value: $('#warehouse_id').val(),
            });
            formDataOrder.push({
                name: 'invoiceNotesId',
                value: $('#fatura_not_id').val(),
            });
            formDataOffer.push({
                name: 'invoiceNotesId',
                value: $('#fatura_not_id').val(),
            });

            if (fatura_satir_err) {
                Swal.fire({
                    title: "Uyarı!",
                    html: 'Lütfen satırlarınızı gözden geçiriniz. <br><br> Mal/Hizmet/Açıklama, Miktar, Birim, Birim Fiyat veya KDV Yüzdesi boş olamaz. <br> Boş satır olamaz.',
                    icon: "warning",
                    confirmButtonText: 'Tamam',
                });
            } else {
                var invoiceTitleValue, invoiceNameValue, invoiceSurnameValue;

                $.each(formDataInvoice, function (index, element) {
                    if (element.name === 'invoice_title') {
                        invoiceTitleValue = element.value;
                    }
                    if (element.name === 'name') {
                        invoiceNameValue = element.value;
                    }
                    if (element.name === 'surname') {
                        invoiceSurnameValue = element.value;
                    }
                });
                $.each(formDataOrder, function (index, element) {
                    if (element.name === 'invoice_title') {
                        invoiceTitleValue = element.value;
                    }
                    if (element.name === 'name') {
                        invoiceNameValue = element.value;
                    }
                    if (element.name === 'surname') {
                        invoiceSurnameValue = element.value;
                    }
                });
                $.each(formDataOffer, function (index, element) {
                    if (element.name === 'invoice_title') {
                        invoiceTitleValue = element.value;
                    }
                    if (element.name === 'name') {
                        invoiceNameValue = element.value;
                    }
                    if (element.name === 'surname') {
                        invoiceSurnameValue = element.value;
                    }
                });

                if ((typeof invoiceTitleValue === 'undefined' || invoiceTitleValue.trim() === '') && ((typeof invoiceNameValue === 'undefined' || invoiceNameValue.trim() === '') || (typeof invoiceSurnameValue === 'undefined' || invoiceSurnameValue.trim() === ''))) {
                    console.log('cari bilgileri boş.');

                    Swal.fire({
                        title: "Uyarı!",
                        html: 'Lütfen cari bilgilerini gözden geçiriniz. <br><br> Fatura Unvan veya İsim Soyisim alanları dolu olmalıdır.',
                        icon: "warning",
                        confirmButtonText: 'Tamam',
                    });
                } else {
                    console.log("en az ünvan veya ad soyad mevcut");

                    console.log("BİTİS" + $('#is_deadline').val());


                    if ($element == "gider") {

                        

                        formDataOrder.push({
                            name: 'gider_status',
                            value: $('#slct_order_status').val(),
                        });
                        formDataOrder.push({
                            name: 'money_unit_id',
                            value: $('#slct_doviz_tipi').val(),
                        });
                        formDataOrder.push({
                            name: 'fis_fatura_belge',
                            value: $('#fis_fatura_belge_data').val(),
                        });

                   

                        formDataOrder.push({
                            name: 'unit_id',
                            value: 1,
                        });

                        

                        Swal.fire({
                            title: 'Gideri Kaydetmek Üzeresiniz!',
                            html: 'Gider sisteme kaydedilip işleme alınacaktır.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Devam Et',
                            cancelButtonText: 'Düzenle',
                            allowEscapeKey: false,
                            allowOutsideClick: false,

                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Gideriniz kaydediliyor, lütfen bekleyiniz...',
                                    html: 'Gideriniz kaydedilirken, lütfen bekleyiniz...',
                                    allowOutsideClick: false,
                                    onBeforeOpen: () => {
                                        Swal.showLoading();
                                    },
                                });

                                if ($crud == "create") {
                                    $.ajax({
                                        type: "POST",
                                        url: base_url + '/tportal/giderler/create',
                                        data: {
                                            id: $("#btn_detayli_fatura_kaydet").attr("kyt_id"),
                                            // fatura_durum    : $('#fatura_durum').val()
                                            // musteri_id      : $('#txt_musteri_tedarikci').attr('m_id'),
                                            data_form: formDataOrder,
                                            data_order_rows: satir_array,
                                            data_order_amounts: fatura_tutar,
                                        },
                                        async: true,
                                       
                                        datatype: "json",
                                        success: function (response) {
                                            console.log(response);
                                            data = JSON.parse(response);
                                            $('#txt_created_invoice_id').val(data['createdInvoiceId']);
                                            if (data['icon'] == 'success') {
                                                swal.close();

                                                $('#offerDetail').attr('href', base_url + '/tportal/giderler/detail/' + data.newOfferId)

                                                $("#trigger_gider_basarili_ok_button").trigger("click");
                                            }
                                            else {
                                                swal.close();
                                                swetAlert("Hatalı İşlem", data.message, "err");
                                            }
                                        },
                                        error: function () {
                                            swetAlert("Hata!", "bir şeyler ters gitti", "err");
                                        }
                                    });
                                }
                                else if ($crud == "update") {
                                    var url = window.location.href;
                                    var lastSegment = url.split('/').filter(function (segment) {
                                        return segment !== ''; // Boş parçaları filtrele
                                    }).pop();

                                    formDataInvoice.push({
                                        name: 'kurlar',
                                        value: JSON.stringify(kurlar), // Kurlar dizisini JSON formatında ekledik
                                    });
                                    formDataInvoice.push({
                                        name: 'fis_fatura_belge',
                                        value: $('#fis_fatura_belge_data').val(),
                                    });



                                    

                                    $.ajax({
                                        type: "POST",
                                        url: base_url + '/tportal/giderler/edit/' + lastSegment,
                                        data: {
                                            id: $("#btn_detayli_fatura_kaydet").attr("kyt_id"),
                                            // fatura_durum    : $('#fatura_durum').val()
                                            // musteri_id      : $('#txt_musteri_tedarikci').attr('m_id'),
                                            data_form: formDataInvoice,
                                            data_invoice_rows: satir_array,
                                            data_invoice_amounts: fatura_tutar,
                                     
                                            // iadeTable: iade_array,
                                        },
                                        async: true,
                                        datatype: "json",
                                        success: function (response) {
                                            console.log(response);
                                            data = JSON.parse(response);
                                            $('#txt_created_invoice_id').val(data['createdInvoiceId']);
                                            if (data['icon'] == 'success') {
                                                swal.close();
                                                $('#invoiceDetail').attr('href', base_url + '/tportal/giderler/detail/' + data.invoiceId)
                                                $("#trigger_gider_basarili_ok_button").click();
                                            }
                                            else {
                                                swal.close();
                                                swetAlert("Hatalı İşlem", data.message, "err");
                                            }
                                        },
                                        error: function () {
                                            swetAlert("Hata!", "bir şeyler ters gitti", "err");
                                        }
                                    });
                                }
                                else {
                                    console.log("hata! order crud tipi seçilmedi.");
                                }
                            }
                        });
                    }

                    if ($element == "order") {
                        formDataOrder.push({
                            name: 'order_status',
                            value: $('#slct_order_status').val(),
                        });
                        formDataOrder.push({
                            name: 'is_deadline',
                            value: is_deadline,
                        });
                        formDataOrder.push({
                            name: 'deadline_date',
                            value: $('#deadline_date').val(),
                        });
                        console.log(formDataOrder);
                        Swal.fire({
                            title: 'Siparişinizi Kaydetmek Üzeresiniz!',
                            html: 'Siparişiniz sisteme kaydedilip işleme alınacaktır.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Devam Et',
                            cancelButtonText: 'Düzenle',
                            allowEscapeKey: false,
                            allowOutsideClick: false,

                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Siparişiniz kaydediliyor, lütfen bekleyiniz...',
                                    html: 'Siparişiniz kaydedilirken, lütfen bekleyiniz...',
                                    allowOutsideClick: false,
                                    onBeforeOpen: () => {
                                        Swal.showLoading();
                                    },
                                });

                                if ($crud == "create") {
                                    console.log("create_invoice'dan fatura_kayit(orderCreate) func çalıştı");
                                    $.ajax({
                                        type: "POST",
                                        url: base_url + '/tportal/order/create',
                                        data: {
                                            id: $("#btn_detayli_fatura_kaydet").attr("kyt_id"),
                                            // fatura_durum    : $('#fatura_durum').val()
                                            // musteri_id      : $('#txt_musteri_tedarikci').attr('m_id'),
                                            data_form: formDataOrder,
                                            data_order_rows: satir_array,
                                            data_order_amounts: fatura_tutar,
                                        },
                                        async: true,
                                        datatype: "json",
                                        success: function (response) {
                                            console.log(response);
                                            data = JSON.parse(response);
                                            $('#txt_created_invoice_id').val(data['createdInvoiceId']);
                                            if (data['icon'] == 'success') {
                                                swal.close();

                                                $('#orderDetail').attr('href', base_url + '/tportal/order/detail/' + data.newOrderId)

                                                $("#trigger_success_create_invoice_ok_button").click();
                                            }
                                            else {
                                                swal.close();
                                                swetAlert("Hatalı İşlem", data.message, "err");
                                            }
                                        },
                                        error: function () {
                                            swetAlert("Hata!", "bir şeyler ters gitti", "err");
                                        }
                                    });
                                }
                                else if ($crud == "update") {
                                    console.log("order update çalışacak.");

                                    var url = window.location.href;
                                    var lastSegment = url.split('/').filter(function (segment) {
                                        return segment !== ''; // Boş parçaları filtrele
                                    }).pop();


                                    $.ajax({
                                        type: "POST",
                                        url: base_url + '/tportal/order/edit/' + lastSegment,
                                        data: {
                                           
                                            // fatura_durum    : $('#fatura_durum').val()
                                            // musteri_id      : $('#txt_musteri_tedarikci').attr('m_id'),
                                            data_form: JSON.stringify(formDataOrder),  // JSON formatına çevir
                                            data_order_rows: JSON.stringify(satir_array),  // JSON formatına çevir
                                            data_order_amounts: JSON.stringify(fatura_tutar),  // JSON formatına çevir
                                        },
                                        async: true,
                                        datatype: "json",
                                        success: function (response) {
                                            console.log(response);
                                            data = JSON.parse(response);

                                            $('#txt_created_invoice_id').val(data['createdInvoiceId']);
                                            if (data['icon'] == 'success') {
                                                swal.close();

                                                $('#orderDetail').attr('href', base_url + '/tportal/order/detail/' + data.orderId);

                                                $("#trigger_success_create_invoice_ok_button").click();
                                            }
                                            else {
                                                swal.close();
                                                swetAlert("Hatalı İşlem", data.message, "err");
                                            }
                                        },
                                        error: function () {
                                            swetAlert("Hata!", "bir şeyler ters gitti", "err");
                                        }
                                    });
                                }
                                else {
                                    console.log("hata! order crud tipi seçilmedi.");
                                }
                            }
                        });
                    }
                    else if ($element == "invoice") {

                        Swal.fire({
                            title: 'Faturayı Kaydetmek Üzeresiniz!',
                            html: '<b>Proforma Fatura</b> olarak sadece sisteme kaydedilecektir. <br> Resmi geçerliliği yoktur.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Devam Et',
                            cancelButtonText: 'Düzenle',
                            allowEscapeKey: false,
                            allowOutsideClick: false,

                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Faturanız kaydediliyor, lütfen bekleyiniz...',
                                    html: 'Faturanız kaydedilirken, lütfen bekleyiniz...',
                                    allowOutsideClick: false,
                                    onBeforeOpen: () => {
                                        Swal.showLoading();
                                    },
                                });

                                if ($crud == "siparis") {

                                    $.ajax({
                                        type: "POST",
                                        url: base_url + '/tportal/invoice/siparis/' + $('#order_id').val(),
                                        data: {
                                            id: $("#btn_detayli_fatura_kaydet").attr("kyt_id"),
                                            // fatura_durum    : $('#fatura_durum').val()
                                            // musteri_id      : $('#txt_musteri_tedarikci').attr('m_id'),
                                            data_form: formDataInvoice,
                                            data_invoice_rows: satir_array,
                                            data_invoice_amounts: fatura_tutar,
                                            data_invoice_iade: iade_satir_array,
                                            data_invoice_irsaliye: irsaliye_satir_array,
                                            // iadeTable: iade_array,
                                        },
                                        async: true,
                                        datatype: "json",
                                        success: function (response) {
                                            console.log(response);
                                            data = JSON.parse(response);
                                            $('#txt_created_invoice_id').val(data['createdInvoiceId']);
                                            if (data['icon'] == 'success') {
                                                swal.close();
                                                $('#invoiceDetail').attr('href', base_url + '/tportal/invoice/detail/' + data.newdInvoiceId)
                                                $("#trigger_success_create_invoice_ok_button").click();
                                            }
                                            else {
                                                swal.close();
                                                swetAlert("Hatalı İşlem", data.message, "err");
                                            }
                                        },
                                        error: function () {
                                            swetAlert("Hata!", "bir şeyler ters gitti", "err");
                                        }
                                    });
                                }

                                if ($crud == "teklif") {


                                  


                                    $.ajax({
                                        type: "POST",
                                        url: base_url + '/tportal/invoice/teklif/' + $('#offer_id').val(),
                                        data: {
                                            id: $("#btn_detayli_fatura_kaydet").attr("kyt_id"),
                                            // fatura_durum    : $('#fatura_durum').val()
                                            // musteri_id      : $('#txt_musteri_tedarikci').attr('m_id'),
                                            data_form: formDataInvoice,
                                            data_invoice_rows: satir_array,
                                            data_invoice_amounts: fatura_tutar,
                                            data_invoice_iade: iade_satir_array,
                                            data_invoice_irsaliye: irsaliye_satir_array,
                                            // iadeTable: iade_array,
                                        },
                                        async: true,
                                        datatype: "json",
                                        success: function (response) {
                                            console.log(response);
                                            data = JSON.parse(response);
                                            $('#txt_created_invoice_id').val(data['createdInvoiceId']);
                                            if (data['icon'] == 'success') {
                                                swal.close();
                                                $('#invoiceDetail').attr('href', base_url + '/tportal/invoice/detail/' + data.newdInvoiceId)
                                                $("#trigger_success_create_invoice_ok_button").click();
                                            }
                                            else {
                                                swal.close();
                                                swetAlert("Hatalı İşlem", data.message, "err");
                                            }
                                        },
                                        error: function () {
                                            swetAlert("Hata!", "bir şeyler ters gitti", "err");
                                        }
                                    });
                                }

                                if ($crud == "create") {

                                    formDataInvoice.push({
                                        name: 'kurlar',
                                        value: JSON.stringify(kurlar), // Kurlar dizisini JSON formatında ekledik
                                    });


                                    formDataInvoice.push({
                                        name: 'is_expiry',
                                        value: $("#is_maturity").prop('checked') ? 'on' : 'off',
                                    });

                                    formDataInvoice.push({
                                        name: 'payment_method',
                                        value: $("select[name='maturity_payment_method']").val(),
                                    });



                                    $.ajax({
                                        type: "POST",
                                        url: base_url + '/tportal/invoice/create',
                                        data: {
                                            id: $("#btn_detayli_fatura_kaydet").attr("kyt_id"),
                                            // fatura_durum    : $('#fatura_durum').val()
                                            // musteri_id      : $('#txt_musteri_tedarikci').attr('m_id'),
                                            data_form: formDataInvoice,
                                            data_invoice_rows: satir_array,
                                            data_invoice_amounts: fatura_tutar,
                                            data_invoice_iade: iade_satir_array,
                                            data_invoice_irsaliye: irsaliye_satir_array,
                                            // iadeTable: iade_array,
                                        },
                                        async: true,
                                        datatype: "json",
                                        success: function (response) {
                                            console.log(response);
                                            data = JSON.parse(response);
                                            $('#txt_created_invoice_id').val(data['createdInvoiceId']);
                                            if (data['icon'] == 'success') {
                                                swal.close();
                                                $('#invoiceDetail').attr('href', base_url + '/tportal/invoice/detail/' + data.newdInvoiceId)
                                                $("#trigger_success_create_invoice_ok_button").click();
                                            }
                                            else {
                                                swal.close();
                                                swetAlert("Hatalı İşlem", data.message, "err");
                                            }
                                        },
                                        error: function () {
                                            swetAlert("Hata!", "bir şeyler ters gitti", "err");
                                        }
                                    });
                                }
                                else if ($crud == "update") {
                                    var url = window.location.href;
                                    var lastSegment = url.split('/').filter(function (segment) {
                                        return segment !== ''; // Boş parçaları filtrele
                                    }).pop();

                                    formDataInvoice.push({
                                        name: 'kurlar',
                                        value: JSON.stringify(kurlar), // Kurlar dizisini JSON formatında ekledik
                                    });

                                    formDataInvoice.push({
                                        name: 'is_expiry',
                                        value: $("#is_maturity").prop('checked') ? 'on' : 'off',
                                    });

                                    formDataInvoice.push({
                                        name: 'payment_method',
                                        value: $("select[name='maturity_payment_method']").val(),
                                    });


                                    $.ajax({
                                        type: "POST",
                                        url: base_url + '/tportal/invoice/edit/' + lastSegment,
                                        data: {
                                            id: $("#btn_detayli_fatura_kaydet").attr("kyt_id"),
                                            // fatura_durum    : $('#fatura_durum').val()
                                            // musteri_id      : $('#txt_musteri_tedarikci').attr('m_id'),
                                            data_form: formDataInvoice,
                                            data_invoice_rows: satir_array,
                                            data_invoice_amounts: fatura_tutar,
                                            data_invoice_iade: iade_satir_array,
                                            data_invoice_irsaliye: irsaliye_satir_array,
                                            // iadeTable: iade_array,
                                        },
                                        async: true,
                                        datatype: "json",
                                        success: function (response) {
                                            console.log(response);
                                            data = JSON.parse(response);
                                            $('#txt_created_invoice_id').val(data['createdInvoiceId']);
                                            if (data['icon'] == 'success') {
                                               
                                                swal.close();
                                                $('#invoiceDetail').attr('href', base_url + '/tportal/invoice/detail/' + data.invoiceId)
                                                $("#trigger_success_create_invoice_ok_button").click();
                                                if(data.tiko_id != null){
                                                    var invoice_id = data.invoiceId;
                                                    otomatikDuzenle(invoice_id); // Direkt olarak AJAX çağrısını yap
                                                }
                                            }
                                            else {
                                                swal.close();
                                                swetAlert("Hatalı İşlem", data.message, "err");
                                            }
                                        },
                                        error: function () {
                                            swetAlert("Hata!", "bir şeyler ters gitti", "err");
                                        }
                                    });
                                }
                                else {
                                    console.log("hata! invoice crud tipi seçilmedi.");
                                }
                            }
                        });
                    }
                    else if ($element == "offer") {
                        formDataOffer.push({
                            name: 'offer_status',
                            value: 'new',
                        });
                        Swal.fire({
                            title: 'Teklifiniz Kaydetmek Üzeresiniz!',
                            html: 'Teklifiniz sisteme kaydedilecektir.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Devam Et',
                            cancelButtonText: 'Düzenle',
                            allowEscapeKey: false,
                            allowOutsideClick: false,

                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Teklifiniz kaydediliyor, lütfen bekleyiniz...',
                                    html: 'Teklifiniz kaydedilirken, lütfen bekleyiniz...',
                                    allowOutsideClick: false,
                                    onBeforeOpen: () => {
                                        Swal.showLoading();
                                    },
                                });

                                if ($crud == "create") {

                                    console.log("formDataOffer offer>create ->", formDataOffer);

                                    $.ajax({
                                        type: "POST",
                                        url: base_url + '/tportal/offer/create',
                                        data: {
                                            data_form: formDataOffer,
                                            data_offer_rows: satir_array,
                                            data_offer_amounts: fatura_tutar,
                                        },
                                        async: true,
                                        datatype: "json",
                                        success: function (response) {
                                            console.log(response);
                                            data = JSON.parse(response);
                                            console.log("yeni teklif id", data.newOfferId);
                                            $('#txt_created_offer_id').val(data.newOfferId);
                                            if (data['icon'] == 'success') {
                                                swal.close();
                                                $('#offerDetail').attr('href', base_url + '/tportal/offer/detail/' + data.newOfferId)
                                                $("#trigger_success_create_offer_ok_button").click();
                                            }
                                            else {
                                                swal.close();
                                                swetAlert("Hatalı İşlem", data.message, "err");
                                            }
                                        },
                                        error: function () {
                                            swetAlert("Hata!", "sunucuda bir şeyler ters gitti", "err");
                                        }
                                    });
                                }
                                else if ($crud == "update") {
                                    var url = window.location.href;
                                    var lastSegment = url.split('/').filter(function (segment) {
                                        return segment !== ''; // Boş parçaları filtrele
                                    }).pop();


                                    formDataOffer.push({
                                        name: 'is_validity',
                                        value: $("#is_validity").val(),
                                    });


                                    $.ajax({
                                        type: "POST",
                                        url: base_url + '/tportal/offer/edit/' + lastSegment,
                                        data: {
                                            data_form: formDataOffer,
                                            data_offer_rows: satir_array,
                                            data_offer_amounts: fatura_tutar,
                                        },
                                        async: true,
                                        datatype: "json",
                                        success: function (response) {
                                            console.log(response);
                                            data = JSON.parse(response);
                                            $('#txt_created_offer_id').val(data.offerId);
                                            if (data['icon'] == 'success') {
                                                swal.close();
                                                $('#offerDetail').attr('href', base_url + '/tportal/offer/detail/' + data.offerId)
                                                $("#trigger_success_edit_offer_ok_button").click();
                                            }
                                            else {
                                                swal.close();
                                                swetAlert("Hatalı İşlem", data.message, "err");
                                            }
                                        },
                                        error: function () {
                                            swetAlert("Hata!", "bir şeyler ters gitti", "err");
                                        }
                                    });
                                }
                                else {
                                    console.log("hata! teklif crud tipi seçilmedi.");
                                }
                            }
                        });
                    }
                    else {
                        console.log("hata! işlem tipi seçilmedi.");
                    }
                }



            }
        
    }

    function yaziyla(yazitl) {
        var sayi = yazitl.replace(".", "").replace(".", "").split(",");
        // console.log("sayi: " + sayi);
        var sayisol = sayi[0];
        // console.log("sayisol: " + sayisol);
        var sayisag = sayi[1];
        // console.log("sayisag: " + sayisag);
        var i9;
        var i8;
        var i7;
        var i6;
        var i5;
        var i4;
        var i3;
        var i2;
        var i1;
        var r2;
        var r1;
        //DOKUZLAR
        if (sayisol.length == 9) {
            i = Math.floor(sayisol / 100000000);
            if (i == 1) { i9 = 'YÜZ' }
            if (i == 2) { i9 = 'İKİYÜZ' }
            if (i == 3) { i9 = 'ÜÇYÜZ' }
            if (i == 4) { i9 = 'DÖRTYÜZ' }
            if (i == 5) { i9 = 'BEŞYÜZ' }
            if (i == 6) { i9 = 'ALTIYÜZ' }
            if (i == 7) { i9 = 'YEDİYÜZ' }
            if (i == 8) { i9 = 'SEKİZYÜZ' }
            if (i == 9) { i9 = 'DOKUZYÜZ' }
            if (i == 0) { i9 = '' }
            sayisol = sayisol.substr(1, sayisol - 1);
        } else { i9 = '' }
        //SEKİZLER
        if (sayisol.length == 8) {
            i = Math.floor(sayisol / 10000000);
            if (i == 1) { i8 = 'ON' }
            if (i == 2) { i8 = 'YİRMİ' }
            if (i == 3) { i8 = 'OTUZ' }
            if (i == 4) { i8 = 'KIRK' }
            if (i == 5) { i8 = 'ELLİ' }
            if (i == 6) { i8 = 'ALTMIŞ' }
            if (i == 7) { i8 = 'YETMİŞ' }
            if (i == 8) { i8 = 'SEKSEN' }
            if (i == 9) { i8 = 'DOKSAN' }
            if (i == 0) { i8 = '' }
            sayisol = sayisol.substr(1, sayisol - 1);
        } else { i8 = '' }
        //YEDİLER
        if (sayisol.length == 7) {
            i = Math.floor(sayisol / 1000000);
            if (i == 1) {
                if (i !== '') {
                    i7 = 'BİRMİLYON';
                } else { i7 = 'MİLYON'; }
            }
            if (i == 2) { i7 = 'İKİMİLYON' }
            if (i == 3) { i7 = 'ÜÇMİLYON' }
            if (i == 4) { i7 = 'DÖRTMİLYON' }
            if (i == 5) { i7 = 'BEŞMİLYON' }
            if (i == 6) { i7 = 'ALTIMİLYON' }
            if (i == 7) { i7 = 'YEDİMİLYON' }
            if (i == 8) { i7 = 'SEKİZMİLYON' }
            if (i == 9) { i7 = 'DOKUZMİLYON' }
            if (i == 0) {
                if (i7 !== '') { i7 = 'MİLYON' }
                else { i7 = '' }
            }
            sayisol = sayisol.substr(1, sayisol - 1);
        } else { i7 = '' }
        //ALTİLAR
        if (sayisol.length == 6) {
            i = Math.floor(sayisol / 100000);
            if (i == 1) { i6 = 'YÜZ' }
            if (i == 2) { i6 = 'İKİYÜZ' }
            if (i == 3) { i6 = 'ÜÇYÜZ' }
            if (i == 4) { i6 = 'DÖRTYÜZ' }
            if (i == 5) { i6 = 'BEŞYÜZ' }
            if (i == 6) { i6 = 'ALTIYÜZ' }
            if (i == 7) { i6 = 'YEDİYÜZ' }
            if (i == 8) { i6 = 'SEKİZYÜZ' }
            if (i == 9) { i6 = 'DOKUZYÜZ' }
            if (i == 0) { i6 = '' }
            sayisol = sayisol.substr(1, sayisol - 1);
        } else { i6 = '' }
        //BEŞLER
        if (sayisol.length == 5) {
            i = Math.floor(sayisol / 10000);
            if (i == 1) { i5 = 'ON' }
            if (i == 2) { i5 = 'YİRMİ' }
            if (i == 3) { i5 = 'OTUZ' }
            if (i == 4) { i5 = 'KIRK' }
            if (i == 5) { i5 = 'ELLİ' }
            if (i == 6) { i5 = 'ALTMIŞ' }
            if (i == 7) { i5 = 'YETMİŞ' }
            if (i == 8) { i5 = 'SEKSEN' }
            if (i == 9) { i5 = 'DOKSAN' }
            if (i == 0) { i5 = '' }
            sayisol = sayisol.substr(1, sayisol - 1);
        } else { i5 = '' }
        //DÖRTLER
        if (sayisol.length == 4) {
            i = Math.floor(sayisol / 1000);
            if (i == 1) {
                if (i5 !== '') {
                    i4 = 'BİRBİN';
                } else { i4 = 'BİN'; }
            }
            if (i == 2) { i4 = 'İKİBİN' }
            if (i == 3) { i4 = 'ÜÇBİN' }
            if (i == 4) { i4 = 'DÖRTBİN' }
            if (i == 5) { i4 = 'BEŞBİN' }
            if (i == 6) { i4 = 'ALTIBİN' }
            if (i == 7) { i4 = 'YEDİBİN' }
            if (i == 8) { i4 = 'SEKİZBİN' }
            if (i == 9) { i4 = 'DOKUZBİN' }
            if (i == 0) {
                if (i4 !== '') { i4 = 'BİN' }
                else { i4 = '' }
            }
            sayisol = sayisol.substr(1, sayisol - 1);
        } else { i4 = '' }
        //ÜÇLER
        if (sayisol.length == 3) {
            i = Math.floor(sayisol / 100);
            if (i == 1) { i3 = 'YÜZ' }
            if (i == 2) { i3 = 'İKİYÜZ' }
            if (i == 3) { i3 = 'ÜÇYÜZ' }
            if (i == 4) { i3 = 'DÖRTYÜZ' }
            if (i == 5) { i3 = 'BEŞYÜZ' }
            if (i == 6) { i3 = 'ALTIYÜZ' }
            if (i == 7) { i3 = 'YEDİYÜZ' }
            if (i == 8) { i3 = 'SEKİZYÜZ' }
            if (i == 9) { i3 = 'DOKUZYÜZ' }
            if (i == 0) { i3 = '' }
            sayisol = sayisol.substr(1, sayisol - 1);
        } else { i3 = '' }
        //İKİLERR
        if (sayisol.length == 2) {
            i = Math.floor(sayisol / 10);
            if (i == 1) { i2 = 'ON' }
            if (i == 2) { i2 = 'YİRMİ' }
            if (i == 3) { i2 = 'OTUZ' }
            if (i == 4) { i2 = 'KIRK' }
            if (i == 5) { i2 = 'ELLİ' }
            if (i == 6) { i2 = 'ALTMIŞ' }
            if (i == 7) { i2 = 'YETMİŞ' }
            if (i == 8) { i2 = 'SEKSEN' }
            if (i == 9) { i2 = 'DOKSAN' }
            if (i == 0) { i2 = '' }
            sayisol = sayisol.substr(1, sayisol - 1);
        } else { i2 = '' }
        //BİRLER
        if (sayisol.length == 1) {
            i = Math.floor(sayisol / 1);
            if (i == 1) { i1 = 'BİR' }
            if (i == 2) { i1 = 'İKİ' }
            if (i == 3) { i1 = 'ÜÇ' }
            if (i == 4) { i1 = 'DÖRT' }
            if (i == 5) { i1 = 'BEŞ' }
            if (i == 6) { i1 = 'ALTI' }
            if (i == 7) { i1 = 'YEDİ' }
            if (i == 8) { i1 = 'SEKİZ' }
            if (i == 9) { i1 = 'DOKUZ' }
            if (i == 0) { i1 = '' }
            sayisol = sayisol.substr(1, sayisol - 1);
        } else { i1 = '' }
        //SAĞ İKİ
        if (sayisag !== undefined && sayisag !== "00") {
            if (sayisag.length == 2) {
                i = Math.floor(sayisag / 10);
                if (i == 1) { r2 = 'ON' }
                if (i == 2) { r2 = 'YİRMİ' }
                if (i == 3) { r2 = 'OTUZ' }
                if (i == 4) { r2 = 'KIRK' }
                if (i == 5) { r2 = 'ELLİ' }
                if (i == 6) { r2 = 'ALTMIŞ' }
                if (i == 7) { r2 = 'YETMİŞ' }
                if (i == 8) { r2 = 'SEKSEN' }
                if (i == 9) { r2 = 'DOKSAN' }
                if (i == 0) { r2 = '' }
                sayisag = sayisag.substr(1, sayisag - 1);
            }
            //SAĞ BİR
            if (sayisag.length == 1) {
                i = Math.floor(sayisag / 1);
                if (i == 1) { r1 = 'BİR' }
                if (i == 2) { r1 = 'İKİ' }
                if (i == 3) { r1 = 'ÜÇ' }
                if (i == 4) { r1 = 'DÖRT' }
                if (i == 5) { r1 = 'BEŞ' }
                if (i == 6) { r1 = 'ALTI' }
                if (i == 7) { r1 = 'YEDİ' }
                if (i == 8) { r1 = 'SEKİZ' }
                if (i == 9) { r1 = 'DOKUZ' }
                if (i == 0) { r1 = '' }
                sayisag = sayisag.substr(1, sayisag - 1);
            }
        } else { r2 = ''; r1 = 'SIFIR'; }

        if ((r2 == '' && r1 == '') || r1 == "SIFIR") {
            rs = i9 + i8 + i7 + i6 + i5 + i4 + i3 + i2 + i1 + " TÜRK LİRASI";
        } else {
            rs = i9 + i8 + i7 + i6 + i5 + i4 + i3 + i2 + i1 + " TÜRK LİRASI " + r2 + r1 + " KURUŞ";
        }

        return $("#total_to_text").val("YALNIZ: #" + rs + "#");
    }


    $(document).on("click", ".btnSaveInvoice", function (event) {
        fatura_kayit("invoice", "create");
    });

    $(document).on("click", ".btnSaveSiparis", function (event) {
        fatura_kayit("invoice", "siparis");
    });

    $(document).on("click", ".btnSaveTeklif", function (event) {
        fatura_kayit("invoice", "teklif");
    });

    $(document).on("click", ".btnSaveEditInvoice", function (event) {
        fatura_kayit("invoice", "update");
        
    });

    $(document).on("click", ".btnSaveOrder", function (event) {
        fatura_kayit("order", "create");
    });

    $(document).on("click", ".btnEditOrder", function (event) {
        fatura_kayit("order", "update");
    });

    $(document).on("click", ".btnSaveOffer", function (event) {
        fatura_kayit("offer", "create");
    });

    $(document).on("click", ".btnEditOffer", function (event) {
        fatura_kayit("offer", "update");
    });



    $(document).on("click", ".btnSaveGider", function (event) {
        fatura_kayit("gider", "create");
    });


    $(document).on("click", ".btnEditGider", function (event) {
        fatura_kayit("gider", "update");
    });

    function getUnits(satir) {
        setTimeout(function () {
            $.ajax({
                type: 'GET',
                url: base_url + '/tportal/invoice/getUnits',
                dataType: 'json',
                success: function (response) {
                    let data = response.unit_items;
                    data.forEach(obj => addOpt3(obj, satir))
                },
                error: function (error) {
                    swal.close();
                    console.log("err: " + error);
                }
            });
        }, 100 * satir); // Satır başına 100ms gecikme ekledik
    };

    function getUnitsForAllRows() {
        var totalRows = parseInt($("#str_s").val()); // Toplam satır sayısını al

        $.ajax({
            type: 'GET',
            url: base_url + '/tportal/invoice/getUnits',
            dataType: 'json',
            success: function (response) {
                let data = response.unit_items;
                
                for (let i = 0; i < totalRows; i++) {
                    data.forEach(obj => addOpt3(obj, i));
                }
            },
            error: function (error) {
                swal.close();
                console.log("err: " + error);
            }
        });
    }
    

    getUnitsForAllRows();
    
    function getWithholding(satir) {
        $.ajax({
            type: 'GET',
            url: base_url + '/tportal/invoice/getWithholding',
            dataType: 'json',
            success: function (response) {
                if (response['icon'] == 'success') {
                    let data = response.tevkifat_items;
                    data.forEach(obj => delete obj["id"]);
                    data.forEach(obj => renameKey(obj, "withholding_code", "id"));


                    for (let i = 0; i < data.length; i++) {
                        const element = data[i];
                        let newData = '(%' + element.withholding_value + ') | ' + element.id + ' - ' + element.withholding_name;
                        element.text = newData;
                    }

                    const all_select = $(".tevkifat_tipi");
                    $.each(all_select, function (indexInArray, valueOfElement) {
                        const value = $(valueOfElement).data("val");
                        $("#slct_tevkifat_tipi_" + satir).select2({
                            data: data
                        });
                        if (value > 0) {
                            $(valueOfElement)
                                .val(value)
                                .trigger("change");
                        }
                    });
                }
                // else {
                //     console.log("baba data yok: " + response);
                // }
            }
        });
    }

    function getNotes(note_type) {
        $(document).ready(function () {
            $.ajax({
                type: 'GET',
                url: base_url + '/tportal/getNotes/' + note_type,
                dataType: 'json',
                success: function (response) {
                    let data2 = JSON.parse(response.note_items);
                    data2.forEach(obj => addOpt(obj))
                },
                error: function (error) {
                    swal.close();
                    console.log("err: " + error);
                }
            });
        });
    }

    function getExceptionType() {
        $(document).ready(function () {
            $.ajax({
                type: 'GET',
                url: base_url + '/tportal/invoice/getExceptionType',
                dataType: 'json',
                success: function (response) {
                    let data2 = response.exception_type_items;
                    data2.forEach(obj => addOpt4(obj))
                },
                error: function (error) {
                    swal.close();
                    console.log("err: " + error);
                }
            });
        });
    }

    function getSpecialBase() {
        $(document).ready(function () {
            $.ajax({
                type: 'GET',
                url: base_url + '/tportal/invoice/getSpecialBase',
                dataType: 'json',
                success: function (response) {
                    let data2 = response.special_base_items;
                    data2.forEach(obj => addOpt5(obj))
                },
                error: function (error) {
                    swal.close();
                    console.log("err: " + error);
                }
            });
        });
    }

    function getInvoiceSerial() {
        $.ajax({
            type: 'GET',
            url: base_url + '/tportal/invoice/getInvoiceSerial',
            dataType: 'json',
            success: function (response) {
                let data = response.invoice_serial_items;
                data.forEach(obj => addOpt2(obj))
            },
            error: function (error) {
                swal.close();
                console.log("err: " + error);
            }
        });
    }

    function renameKey(obj, oldKey, newKey) {
        obj[newKey] = obj[oldKey];
        delete obj[oldKey];
    }

    function addOpt(obj) {
        var data = {
            invoice_note_id: obj.note_id,
            invoice_note_title: obj.note_title,
            invoice_note_text: obj.note,
        };

        var opt = document.createElement('option');
        opt.value = data.invoice_note_id;
        opt.text = data.invoice_note_title;
        opt.setAttribute('invoice_note_text', data.invoice_note_text);

        const button = document.querySelector("#slct_invoice_note");
        button.options.add(opt);
    }

    function addOpt2(obj) {
        var data = {
            serial_id: obj.invoice_serial_id,
            serial_title: obj.invoice_serial_prefix,
            serial_type: obj.invoice_serial_type,
        };

        var opt = document.createElement('option');
        opt.value = data.serial_id;
        opt.text = data.serial_title + " - " + (data.serial_type == 'e-archive' ? 'E-Arşiv' : 'E-Fatura');
        opt.setAttribute('invoice-serial-type', data.serial_type);

        const button = document.querySelector("#fatura_seri");
        button.options.add(opt);
    }

    function addOpt3(obj, satir) {
        let button = document.querySelector("#slct_birim_" + satir);
        
        // Eğer button bulunamazsa satir değerini azalt ve tekrar dene
        if (!button) {
            satir--;  // satir değerini 1 azalt
            button = document.querySelector("#slct_birim_" + satir);  // yeni satir değeriyle tekrar dene
        }
        
        // Hala button bulunamazsa işlemi sonlandır
        if (!button) {
            console.error("Element with id slct_birim_" + satir + " still not found.");
            return;
        }
        
        // Gelen veriyi option olarak ekleyelim
        var data = {
            unit_id: obj.unit_id,
            unit_title: obj.unit_title,
            unit_value: obj.unit_value,
        };
    
        var opt = document.createElement('option');
        opt.value = data.unit_id;
        opt.text = data.unit_title;
        opt.setAttribute('data-unit-value', data.unit_value);
    
        button.options.add(opt);
    }
    function addOpt4(obj) {
        var data = {
            exception_type_code: obj.exception_code,
            exception_type_name: obj.exception_name,
        };

        var opt = document.createElement('option');
        opt.value = data.exception_type_code;
        opt.text = data.exception_type_code + " | " + data.exception_type_name;
        opt.setAttribute('data-istisna-adi', data.exception_type_name);

        const button = document.querySelector("#istisna_tipi");
        button.options.add(opt);
    }

    function addOpt5(obj) {
        var data = {
            special_base_code: obj.special_base_code,
            special_base_name: obj.special_base_name,
        };

        var opt = document.createElement('option');
        opt.value = data.special_base_code;
        opt.text = data.special_base_code + " | " + data.special_base_name;
        opt.setAttribute('data-matrah-adi', data.special_base_name);

        const button = document.querySelector("#ozel_matrah_tipi");
        button.options.add(opt);
    }




})

