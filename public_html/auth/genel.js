/***
 * SCRIPTS
 */
// Modal Input Focus
$('.modal').on('shown.bs.modal', function() {
    $(this).find('[autofocus]').focus();
});

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

// Telefon Numarası
$('[telephone_number]').inputmask('9(999) 999 99 99');
$("[telephone_number]").on("input", function () {

    let value = $(this).inputmask('unmaskedvalue');

    if (value.length == 1 && value.charAt(0) !== "0")
        $(this).val("0"+value);

});

// Acordion
$("#accordionTumunuGosterButton").on("click", function () {
    if ($("#accordionTumunuGosterButton").attr("data-show") == 1) {
        $(".accordion").find(".accordion-body").removeClass("show");
        $("#accordionTumunuGosterButton").attr("data-show", 0);
    } else {
        $(".accordion").find(".accordion-body").addClass("show");
        $("#accordionTumunuGosterButton").attr("data-show", 1);
    }
});

/***
 ** HELPERS
 */

 function toastr_uyariver(uyari_tipi, baslik, mesaj){
    var a_op = {
        closeButton: !0,
        debug: !1,
        newestOnTop: !1,
        progressBar: !1,
        positionClass: "toast-bottom-left",//s.position + s.ui,
        closeHtml: '<span class="btn-trigger">Kapat</span>',
        preventDuplicates: !0,
        showDuration: "2500",
        hideDuration: "2500",
        timeOut: "3000",
        toastClass: "toastr",
        extendedTimeOut: "3000"
    }
    var bicimli_mesaj ="<h5>"+ baslik +"</h5><p class='toastr_icerik'>" + mesaj + "</p>";
    NioApp.Toast(bicimli_mesaj, uyari_tipi, {
            debug: !1,
            newestOnTop: !1,
            progressBar: !0,
            closeHtml: '<span class="btn-trigger">Kapat</span>',
            preventDuplicates: !0,
            showDuration: "2500",
            hideDuration: "2500",
            timeOut: "5000",
            toastClass: "toastr",
            extendedTimeOut: "3000",
            position: "top-full"
    });
}

function modal_basarili(baslik, mesaj){
    $('#mdl_basarili_title').html(baslik);
    $('#mdl_basarili_mesaj').html(mesaj);
    $('#modal_genel_basarili').modal('show');
}

// function SadeceRakam(e, allowedchars) {
//     var key = e.charCode == undefined ? e.keyCode : e.charCode;
//     if ((/^[0-9]+$/.test(String.fromCharCode(key))) || key == 0 || key == 13 || isPassKey(key, allowedchars)) { return true; } else { return false; }
// }

// function isPassKey(key, allowedchars) {
//     if (allowedchars != null) {
//         for (var i = 0; i < allowedchars.length; i++) {
//             if (allowedchars[i] == String.fromCharCode(key))
//                 return true;
//         }
//     }
//     return false;
// }

// function SadeceRakamBlur(e, clear) {
//     var nesne = e.target ? e.target : e.srcElement;
//     var val = nesne.value;
//     val = val.replace(/^\s+|\s+$/g, "");
//     if (clear) val = val.replace(/\s{2,}/g, " ");
//     nesne.value = val;
// }

function mailValidation(val) {
    // control.mailValidation = function(val) {
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

    if (!expr.test(val)) {
        return false;
    }
    else {
        return true;
    }
}

function swalYukleniyor (title, desc) {
    Swal.fire({
        title: title,
        html: desc,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        }
    })
}

function butonBeklemede (button, buttonText = "Yükleniyor") {

    if (!$(document).find(button))
        return false;

    var button = $(button)

    button.attr("disabled", true)
    button.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <span>${buttonText}</span>`);

}

function butonSifirla (button, buttonHtml) {

    if (!$(document).find(button))
        return false;

    var button = $(button);
    button.html(buttonHtml);
    button.attr("disabled", false);

}

$.fn.modalFocus = function (element) {
    this.on('shown.bs.modal', function() {
        this.find(element).focus();
    });
}

function validator (inputs) {

    var callback = [];

    $.each(inputs, function (index, arr) {

        var element = $(index)
        var val = element.val()
        var name;

        console.log(val)

        if (arr["name"] !== undefined)
            name = arr["name"]
        else if ($("label[for='"+index.substring(1)+"']").html())
            name =  $("label[for='"+index.substring(1)+"']").html()
        else
            name = index

        if (element == null || element.val() == undefined) {
            callback["element"] = index
            callback["message"] = `Lütfen ${name} kısmını boş bırakmayınız`
            return false;
        }

        if (arr["rules"] !== undefined) {

            var rules = arr["rules"]

            $.each(rules, function (ruleKey, ruleRaw) {

                var ruleValSplitted = ruleRaw.split(":");
                var rule = ruleValSplitted[0];
                var ruleVal = ruleValSplitted[1];

                switch (rule) {

                    case "required":

                        if (val.length == 0 || val.length === null || val.length === '') {
                            callback["element"] = index
                            callback["message"] ='Lütfen <strong>' + name + '</strong> kısmını boş bırakmayınız.'
                            element.focus();
                        }

                        break;

                    case "required_without":

                        if ((val.length == 0 || val.length === null || val.length === '') &&
                            ($(ruleVal).length == 0 || $(ruleVal).val() === null || $(ruleVal).val() === '')) {
                            callback["element"] = index
                            callback["message"] ='Lütfen <strong>' + name + '</strong> kısmını boş bırakmayınız.'
                            element.focus();
                        }

                        break;

                    case "required_if":

                        if ((val.length == 0 || val.length === null || val.length === '') &&
                            ($(ruleVal).length != 0 && $(ruleVal).val() !== null && $(ruleVal).val() !== ''))  {
                            callback["element"] = index
                            callback["message"] ='Lütfen <strong>' + name + '</strong> kısmını boş bırakmayınız.'
                            element.focus();
                        }

                        break;

                    case "minlength":

                        if (val.length < ruleVal) {
                            callback["element"] = index
                            callback["message"] = `<strong>${name}</strong> en az ${ruleVal} karakter olmalıdır.`
                            element.focus();
                        }

                        break;

                    case "length":

                            if (val.length != ruleVal) {
                                callback["element"] = index
                                callback["message"] = `<strong>${name}</strong> ${ruleVal} karakter olmalıdır.`
                                element.focus();
                            }

                            break;

                    case "maxlength":

                            if (val.length > ruleVal) {
                                callback["element"] = index
                                callback["message"] = `<strong>${name}</strong> en fazla ${ruleVal} karakter olmalıdır.`
                                element.focus();
                            }

                            break;

                    default:
                        break;
                }

                if (callback["message"] !== undefined && callback["message"].length)
                    return false;

            })

        } else {

            if (val.length == 0 || val.length === null || val.length === '') {
                callback["element"] = index
                callback["message"] ='Lütfen <strong>' + name + '</strong> kısmını boş bırakmayınız.'
                element.focus();
            }

        }

        if (callback["message"] !== undefined && callback["message"].length)
            return false;

    });

    return callback;

}
