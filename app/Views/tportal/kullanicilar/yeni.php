<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Yeni Ürün <?= $this->endSection() ?>
<?= $this->section('title') ?> Yeni Ürün | Fams Otomotiv A.Ş. <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>



<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content  d-xl-none">
                        <h3 class="nk-block-title page-title">Yeni Cari</h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">

                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->



            <div class="nk-block">
                <div class="row">
                    <div class="col-md-8 col-lg-8">
                        <div class="card card-stretch">
                            <div class="card-inner-group">
                                <form onsubmit="return false;" id="createCari" method="post">
                                    <div class="card-inner position-relative card-tools-toggle">
                                        <div class="gy-2">
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="site-name">Cari Tipi</label><span
                                                            class="form-note d-none d-md-block">Carinin ait olduğu
                                                            tipi.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <ul class="custom-control-group">
                                                        <li>
                                                            <div
                                                                class="custom-control custom-checkbox custom-control-pro">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="cari_tip_musteri" id="cari_tip_musteri">
                                                                <label class="custom-control-label"
                                                                    for="cari_tip_musteri">
                                                                    <em class="icon ni ni-user"></em>
                                                                    <span>Müşteri</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div
                                                                class="custom-control custom-checkbox custom-control-pro">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="cari_tip_tedarikci" id="cari_tip_tedarikci">
                                                                <label class="custom-control-label"
                                                                    for="cari_tip_tedarikci">
                                                                    <em class="icon ni ni-truck"></em>
                                                                    <span>Tedarikçi</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="chk_ihracatmusterisi">İhracat Müşterisi</label><span
                                                            class="form-note d-none d-md-block">Eğer bu müşteri ihracat
                                                            müşteriniz ise işaretleyiniz..</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <ul class="custom-control-group">
                                                        <li>
                                                            <div
                                                                class="custom-control custom-checkbox custom-control-pro">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="btnCheckControl" id="chk_ihracatmusterisi">
                                                                <label class="custom-control-label"
                                                                    for="chk_ihracatmusterisi">
                                                                    Evet
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="vkn_tc">T.C./Vergi No</label><span
                                                            class="form-note d-none d-md-block">Bu bilgiyi doğru girip
                                                            sorgularsanız ünvan ve vergi dairesi gibi bilgiler otomatik
                                                            gelecektir.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-lg"
                                                            id="vkn_tc" name="vkn_tc"
                                                            placeholder="T.C. veya Vergi No Giriniz..">
                                                        <div class="input-group-append">
                                                            <button id="btn_musteriSorgula"
                                                                class="btn btn-lg btn-block btn-dim btn-outline-light">Sorgula</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                   

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="site-name">Mükellefiyet</label><span
                                                            class="form-note d-none d-md-block">Carinin mükellefiyet
                                                            durumu.</span></div>
                                                </div>
                                                <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                    <div class="col-lg-6 col-xxl-6 col-6  mt-0 mt-md-2 pe-1">
                                                        <div class="form-group">
                                                            <select class="form-select js-select2" id="mukellefiyet"
                                                                name="mukellefiyet" data-ui="lg"
                                                                data-val="Mükellefiyet">
                                                                <option value="null" selected>Mükellefiyet Seçiniz
                                                                </option>
                                                                <option value="e-arsiv">E-ARSIVFATURA</option>
                                                                <option value="e-fatura">E-FATURA</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-6 col-6  mt-0 mt-md-2 ps-1">
                                                        <div class="form-group">
                                                            <select class="form-select js-select2" id="sirket_tip"
                                                                name="sirket_tip" data-ui="lg" data-val="Şirket Tipi">
                                                                <option value="null" selected>Şirket Tipi Seçiniz
                                                                </option>
                                                                <option value="sahis">Şahıs</option>
                                                                <option value="sirket">Şirket</option>
                                                                <option value="kamu">Kamu</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="unvan">Fatura
                                                            Ünvanı</label><span
                                                            class="form-note d-none d-md-block">Fatura kesilecek resmi
                                                            ünvan.<br>Şirket ise ünvan gelir, değil ise ad soyad.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text"
                                                                class="form-control form-control-lg" name="unvan"
                                                                id="unvan" value="" placeholder=""></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="vergi_dairesi">Vergi Dairesi</label><span
                                                            class="form-note d-none d-md-block">Fatura kesilecek resmi
                                                            vergi dairesi.</span></div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text"
                                                                class="form-control form-control-lg"
                                                                name="vergi_dairesi" id="vergi_dairesi" value=""
                                                                placeholder=""></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="ad_soyad">Ad Soyad</label><span
                                                            class="form-note d-none d-md-block">Carinin adı soyadı.</span></div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2 d-flex">
                                                    <div class="col-6 pe-1">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text"
                                                                    class="form-control form-control-lg"
                                                                    name="ad" id="ad" value=""
                                                                    placeholder="İsim"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 ps-1">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap"><input type="text"
                                                                    class="form-control form-control-lg"
                                                                    name="soyad" id="soyad" value=""
                                                                    placeholder="Soyisim"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="address">Fatura Adresi</label><span
                                                            class="form-note d-none d-md-block">Fatura kesilecek resmi
                                                            fatura adresi.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-lg"
                                                                name="address" id="address" cols="30"
                                                                rows="5"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="address_country">Ülke</label><span
                                                            class="form-note d-none d-md-block">Gözükecek ürün
                                                            kodu.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <select id="address_country" name="address_country"
                                                                class="form-select js-select2" data-ui="lg"
                                                                data-search="on">
                                                                <option value="TR">
                                                                    Türkiye
                                                                </option>
                                                                <option value="VI">
                                                                    ABD Virgin Adaları
                                                                </option>
                                                                <option value="AF">
                                                                    Afganistan
                                                                </option>
                                                                <option value="AX">
                                                                    Aland Adaları
                                                                </option>
                                                                <option value="DE">
                                                                    Almanya
                                                                </option>
                                                                <option value="US">
                                                                    Amerika Birleşik Devletleri
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="address_city">İl
                                                            / İlçe</label><span
                                                            class="form-note d-none d-md-block">Gözükecek ürün
                                                            kodu.</span></div>
                                                </div>
                                                <div class="col-lg-3 col-xxl-3 col-6 mt-0 mt-md-2">
                                                    <div class="form-control-wrap">
                                                        <select id="address_city" name="address_city"
                                                            class="form-select js-select2" data-ui="lg"
                                                            data-placeholder="İl Seçiniz" data-search="on">
                                                            <option></option>
                                                            <option value="Adana" data-plaka="1">
                                                                Adana
                                                            </option>
                                                            <option value="Adıyaman" data-plaka="2">
                                                                Adıyaman
                                                            </option>
                                                            <option value="Afyonkarahisar" data-plaka="3">
                                                                Afyonkarahisar
                                                            </option>
                                                            <option value="Ağrı" data-plaka="4">
                                                                Ağrı
                                                            </option>
                                                            <option value="Amasya" data-plaka="5">
                                                                Amasya
                                                            </option>
                                                            <option value="Ankara" data-plaka="6">
                                                                Ankara
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-xxl-4 col-6 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <select id="address_district" name="address_district"
                                                            class="form-select js-select2" data-ui="lg"
                                                            data-placeholder="İlçe Seçiniz" data-search="on">
                                                            <option></option>
                                                            <option value="Adana" data-plaka="1">
                                                                Adana
                                                            </option>
                                                            <option value="Adıyaman" data-plaka="2">
                                                                Adıyaman
                                                            </option>
                                                            <option value="Afyonkarahisar" data-plaka="3">
                                                                Afyonkarahisar
                                                            </option>
                                                            <option value="Ağrı" data-plaka="4">
                                                                Ağrı
                                                            </option>
                                                            <option value="Amasya" data-plaka="5">
                                                                Amasya
                                                            </option>
                                                            <option value="Ankara" data-plaka="6">
                                                                Ankara
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="zip_code">Posta Kodu</label><span
                                                            class="form-note d-none d-md-block">Fatura adresinin posta
                                                            kodu.</span></div>
                                                </div>
                                                <div class="col-lg-3 col-xxl-3 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-lg"
                                                            id="zip_code" name="zip_code" value="" placeholder="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="eposta">E-posta</label><span
                                                            class="form-note d-none d-md-block">Carinin faturalarının
                                                            gönderileceği e-posta adresi.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text"
                                                                class="form-control form-control-lg" id="eposta"
                                                                value="" placeholder="" name="eposta"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="cari_telefon">Telefon</label><span
                                                            class="form-note d-none d-md-block">Carinin faturalarının
                                                            gönderileceği e-posta adresi.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button
                                                                    class="btn btn-lg btn-block btn-dim btn-outline-light dropdown-toggle"
                                                                    data-bs-toggle="dropdown">
                                                                    <span>+90</span>
                                                                    <em class="icon mx-n1 ni ni-chevron-down"></em>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#">+90 Türkiye</a></li>
                                                                        <li><a href="#">+01 USA, Canada</a></li>
                                                                        <li><a href="#">+20 Mısır</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <input type="text" class="form-control form-control-lg"
                                                                aria-label="Text input with dropdown button"
                                                                placeholder="000 000 00 00" name="cari_telefon" id="cari_telefon">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="default_doviz">Para Birimi</label><span
                                                            class="form-note d-none d-md-block">Cari ile çalışmak
                                                            istediğiniz para birimi.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <select id="default_doviz" name="default_doviz"
                                                            class="form-select js-select2" data-ui="lg" data-search="on"
                                                            data-val="TRY">
                                                            <?php foreach($money_unit_items as $money_unit_item){ ?>
                                                            <option value="<?= $money_unit_item['money_code'] ?>"
                                                                <?php if($money_unit_item['default'] == 'true'){echo "selected";} ?>>
                                                                <?= $money_unit_item['money_title'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center d-none">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="site-name">Açılış Bakiyesi /
                                                            Tarihi</label>
                                                        <span class="form-note d-none d-md-block">Cari için açılış
                                                            bakiyesi belirleyebilirsiniz.<br>Alacaklı ise tutarı başına
                                                            (-) eksi ile giriniz.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-xxl-3 col-6 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-lg text-end"
                                                            id="txt_acilisbakiye" value="" disabled placeholder="0,00">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-xxl-4 col-6 mt-0 mt-md-2">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left">
                                                            <em class="icon ni ni-calendar icon-lg"></em>
                                                        </div>
                                                        <input id="fatura_tarihi" name="fatura_tarihi" type="text"
                                                            class="form-control form-control-lg date-picker"
                                                            data-date-format="dd/mm/yyyy" disabled value="12/08/2023">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <a href="javascript:history.back()"
                                                        class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em
                                                            class="icon ni ni-arrow-left"></em><span>Geri</span></a>
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <div class="form-group">
                                                    <button type="submit" id="yeniCari"
                                                        class="btn btn-lg btn-primary">Kaydet</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                </form>
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div>
                </div>
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<button type="button" id="triggerModal" class="btn btn-success d-none" data-bs-toggle="modal"
    data-bs-target="#musteriOK">OK</button>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" id="musteriOK">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                    <h4 class="nk-modal-title">İşlem Başarılı!</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text">Yeni Ürün/Hizmet Başarıyla Eklendi </div>

                        </span>
                    </div>
                    <div class="nk-modal-action">
                        <a href="#" id="cariDetail" class="btn btn-info btn-block mb-2">Bu
                            Cari Detayına Git</a>
                        <a href="#" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Cari
                            Ekle</a>
                        <a href="<?= route_to('tportaler.cariler.list', 'all') ?>"
                            class="btn btn-l btn-dim btn-outline-dark btn-block">Tüm Cariler</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$('#yeniCari').click(function(e) {
    e.preventDefault();
    if ($('#vkn_tc').val() == '') {
        swetAlert("Eksik Birşeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
    } else {
        var formData = $('#createCari').serializeArray();
        formData.push({
            name: 'vkn_tc',
            value: $('#vkn_tc').val()
        });
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.cariler.create') ?>',
            dataType: 'json',
            data: formData,
            async: true,
            success: function(response) {
                if (response['icon'] == 'success') {
                    $('#cariDetail').attr('href', '<?= route_to('tportal.cariler.detail.null')?>/' +
                        response['new_cari_id'])
                    $('#createCari')[0].reset();
                    $("#triggerModal").click();
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })

                    Toast.fire({
                        icon: response['icon'],
                        title: response['message']
                    })
                }
            }
        })
    }
});
$(document).ready(function() {
    $('#btn_musteriSorgula').attr('disabled', true);

    $('#chk_ihracatmusterisi').change(function() {
        if ($(this).is(':checked')) {
            $('#vkn_tc').val('22222222222');
            $('#vkn_tc').attr('disabled', true);
            $('#btn_musteriSorgula').attr('disabled', true);
        } else {
            $('#vkn_tc').val('');
            $('#vkn_tc').attr('disabled', false);
            $('#btn_musteriSorgula').attr('disabled', true);
        }
    });
    $('#vkn_tc').on('input', function() {
        var charCount = $(this).val().length;
        if ((charCount == 10 || charCount == 11) && $('#chk_ihracatmusterisi').is(':checked') ==
            false) {
            $('#btn_musteriSorgula').attr('disabled', false);
        } else {
            $('#btn_musteriSorgula').attr('disabled', true);
        }
        // $('#btn_musteriSorgula').html('Karakter Sayısı: ' + charCount);
    });
});
</script>

<?= $this->endSection() ?>