function swetAlert(title,msg,type){
    var status = '';
    if(type == "ok"){
        status = "success";
    } 
    if(type == "err"){
        status = "warning";
    }
    Swal.fire({
        icon: status,
        title: title,
        html: '<b>'+msg+'</b>',
        showConfirmButton: false,
        timer: 2500
    });
}


// Select 2 modal fix
$('.init-select2').each(function () {
    let t = {
        placeholder: $(this).data("placeholder"),
        clear: $(this).data("clear"),
        search: $(this).data("search"),
        width: $(this).data("width"),
        theme: $(this).data("theme"),
        ui: $(this).data("ui"),
    };
    t.ui = t.ui ? " " + $(this).csskey(t.ui, "select2") : "";
    (t = {
        theme: t.theme ? t.theme + " " + t.ui : "default" + t.ui,
        allowClear: t.clear || !1,
        placeholder: t.placeholder || "",
        dropdownAutoWidth: !(!t.width || "auto" !== t.width),
        minimumResultsForSearch: t.search && "on" === t.search ? 1 : -1,
    });
    if ($(this).parents('.modal').first().attr('id') != null)
        t.dropdownParent = $(this).parents('.modal').first()
    $(this).select2(t);
    if ($(this).data("val") != null && $(this).data("val") !== 'null' && $(this).data("val") != 0)
        $(this).val($(this).data("val")).trigger('change.select2');
});

function SadeceRakam(e, allowedchars, message = 've virgül') {
    var key = e.charCode == undefined ? e.keyCode : e.charCode;
    var inputValue = e.target.value;
    // console.log("inputValue",inputValue);

    // Virgül sayısını kontrol et
    var commaCount = (inputValue.match(/,/g) || []).length;
    // console.log("commaCount",commaCount);
    // Eğer virgül sayısı 1'den fazlaysa, son eklenen virgülü sil
    if (commaCount > 1) {
        e.target.value = inputValue.slice(0, -1);
        return false; // Eklenen virgülü sildik, devam etmeyi durdur
    }

    if (
        /^[0-9]+$/.test(String.fromCharCode(key)) ||
        key == 0 ||
        key == 13 ||
        isPassKey(key, allowedchars)
    ) {
        return true;
    } else {
        console.log(e.key);
        Swal.fire({
            title: "Uyarı",
            text: "Lütfen sadece rakam " + message + " girişi yapınız.",
            allowOutsideClick: false,
            keydownListenerCapture: true,
            confirmButtonText: 'Tamam',
            didOpen: function() {
                document.addEventListener("keydown", SadeceRakamSwalListener);
                $(".swal2-confirm").focus();
            },
            didClose: function() {
                document.removeEventListener("keydown", SadeceRakamSwalListener);
            },
        });
        document.addEventListener("keydown", SadeceRakamSwalListener);
        return false;
    }
}

function SadeceRakamSwalListener(event) {
    if (event.target.classList.contains("swal2-popup")) {
        Swal.close();
    } else event.stopPropagation();
}

function isPassKey(key, allowedchars) {
    if (allowedchars != null) {
        for (var i = 0; i < allowedchars.length; i++) {
            if (allowedchars[i] == String.fromCharCode(key)) return true;
        }
    }
    return false;
}

function replace_for_calculation(number) {
    if (number.includes(",")) {
        number = number.replace(',', '.')
        number = parseFloat(number).toFixed(4)
    } else {
        number = parseFloat(number).toFixed(4)
    }
    return number
  }
  
  function replace_for_form_input(number) {
    if (String(number).includes(",")) {
        return
    } else {
        return String(number).replace('.', ',')
    }
  }

  function numberFormat(number, decimals, dec_point, thousands_sep) {
    number = parseFloat(number);
    if (isNaN(number)) {
        return '';
    }
    var fixed = number.toFixed(decimals);
    var parts = fixed.split('.');
    var intPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);
    var decimalPart = parts.length > 1 ? (dec_point || '.') + parts[1] : '';
    return intPart + decimalPart;
}