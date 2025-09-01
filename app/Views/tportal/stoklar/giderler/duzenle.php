<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Gider Düzenle <?= $this->endSection() ?>
<?= $this->section('title') ?> Gider Düzenle | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>


<?= $this->section('styles') ?>

<style>
    /* .wide-xl {
        max-width: 90% !important;
    } */
</style>

<?= $this->endSection() ?>



<?= $this->section('main') ?>


<style>
    #loadingDiv {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.5); /* Beyaz arkaplan ve 50% opacity */
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
}
.loading-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    font-size: 20px;
    font-weight: bold;
    color: #333;
    top: 5%;
    position: absolute;
    height: 70px;
    width: 100%;
    text-align: center;
    justify-content: center;
    align-items: center;
}
#file-preview img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    max-height: 200px;
}
#file-preview a {
    color: #007bff;
    text-decoration: underline;
    font-weight: bold;
}
</style>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="components-preview wide-xl mx-auto">

                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner p-4">
                        <form onsubmit="return false;" id="createInvoice" method="post" enctype="multipart/form-data" autocomplete="off">
                        <ul class="nav nav-tabs mt-n3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1" aria-selected="false" role="tab" tabindex="-1"><em class="icon ni ni-users-fill"></em><span>Gider Bilgileri</span></a>
                                    </li>
                               
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="tabItem1" role="tabpanel">

                                    
                                    <div class="row g-3 align-center" style="margin-left:-15px">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group"><label class="form-label" for="identification_number">Tedarikçi</label>
                                                    <span class="form-note d-none d-md-block">Tedarikçi Seçiniz</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">
                                                <div class="input-group">
                                                    <input type="text" class="form-control  form-control-lg form-control-lg" id="identification_numbers" name="identification_numbers" placeholder="Tedarikçi Seçiniz"  disabled maxlength="11" value="<?php echo $invoice_item["cari_invoice_title"] ?>">
                                                    <input type="text" class="form-control d-none form-control-lg form-control-lg" id="identification_number" name="identification_number" placeholder="Tedarikçi Seçiniz"  disabled maxlength="11" value="<?php echo $invoice_item["cari_identification_number"] ?>">
                                                    <div class="input-group-append">
                                                     
                                                        <button  class="btn btn-lg btn-block  btn-dim btn-outline-primary">
                                                           Tedarikçi Seçili
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="customer_info_area" class=" d-none gy-2">
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="obligation">Mükellefiyet</label>
                                                        <span class="form-note d-none d-md-block">Carinin mükellefiyet durumu.</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                    <div class="col-lg-6 col-xxl-6 col-6 mt-0 mt-md-2 pe-1">
                                                        <div class="form-group">
                                                            <select class="form-select js-select2" id="obligation" name="obligation" data-ui="lg" data-search="on" data-placeholder="Mükellefiyet Seçiniz">
                                                                <option></option>
                                                                <option value="e-archive" <?= $invoice_item['cari_obligation'] == 'e-archive' ? "selected" : '' ?>>E-Arşiv Fatura</option>
                                                                <option value="e-invoice" <?= $invoice_item['cari_obligation'] == 'e-invoice' ? "selected" : '' ?>>E-Fatura</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-6 col-6 mt-0 mt-md-2 ps-1">
                                                        <div class="form-group">
                                                            <select id="company_type" name="company_type" class="form-select js-select2" data-ui="lg" data-placeholder="Şirket Tipi Seçiniz" data-search="on">
                                                                <option></option>
                                                                <option value="person" <?= $invoice_item['cari_company_type'] == 'person' ? "selected" : '' ?>>Şahıs</option>
                                                                <option value="company" <?= $invoice_item['cari_company_type'] == 'company' ? "selected" : '' ?>>Şirket</option>
                                                                <option value="public" <?= $invoice_item['cari_company_type'] == 'public' ? "selected" : '' ?>>Kamu</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="invoice_title">Fatura Ünvanı</label>
                                                        <span class="form-note d-none d-md-block">Vergi No ise Ünvan Faturada Gönderilir.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control  form-control-lg form-control-lg" name="invoice_title" id="invoice_title" value="<?= $invoice_item['cari_invoice_title'] ?>" placeholder="Fatura Ünvanı">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center" id="namesurname">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="">Adı Soyadı</label>
                                                        <span class="form-note d-none d-md-block">T.C. ise Ad Soyad FaturadaGönderilir.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control  form-control-lg form-control-lg" id="name" name="name" value="<?= $invoice_item['cari_name'] ?>" placeholder="Adı">
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control  form-control-lg form-control-lg" id="surname" name="surname" value="<?= $invoice_item['cari_surname'] ?>" placeholder="Soyadı">
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="cari_id" id="cari_id" value="<?= $invoice_item['cari_id'] ?>">


                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="tax_administration">Vergi Dairesi</label>
                                                        <span class="form-note d-none d-md-block">Fatura kesilecek resmi vergi dairesi.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control  form-control-lg form-control-lg" name="tax_administration" id="tax_administration" value="<?= $invoice_item['cari_tax_administration'] ?>" placeholder="Vergi Dairesi">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address">Fatura Adresi</label><span class="form-note d-none d-md-block">Fatura kesilecek resmi fatura adresi.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control  form-control-lg form-control-lg" name="address" id="address" cols="30" rows="5" placeholder="Fatura Adresi"><?= $invoice_item['address'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address_country">Ülke</label>
                                                        <span class="form-note d-none d-md-block">Fatura adresinin bulunduğu ülke</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select id="address_country" name="address_country" class="form-select js-select2" data-ui="lg" data-search="on">
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
                                        <option value="UM">
                                            Amerika Birleşik Devletleri Küçük Dış Adaları
                                        </option>
                                        <option value="AS">
                                            Amerikan Samoası
                                        </option>
                                        <option value="AD">
                                            Andora
                                        </option>
                                        <option value="AO">
                                            Angola
                                        </option>
                                        <option value="AI">
                                            Anguilla
                                        </option>
                                        <option value="AQ">
                                            Antarktika
                                        </option>
                                        <option value="AG">
                                            Antigua ve Barbuda
                                        </option>
                                        <option value="AR">
                                            Arjantin
                                        </option>
                                        <option value="AL">
                                            Arnavutluk
                                        </option>
                                        <option value="AW">
                                            Aruba
                                        </option>
                                        <option value="QU">
                                            Avrupa Birliği
                                        </option>
                                        <option value="AU">
                                            Avustralya
                                        </option>
                                        <option value="AT">
                                            Avusturya
                                        </option>
                                        <option value="AZ">
                                            Azerbaycan
                                        </option>
                                        <option value="BS">
                                            Bahamalar
                                        </option>
                                        <option value="BH">
                                            Bahreyn
                                        </option>
                                        <option value="BD">
                                            Bangladeş
                                        </option>
                                        <option value="BB">
                                            Barbados
                                        </option>
                                        <option value="EH">
                                            Batı Sahara
                                        </option>
                                        <option value="BZ">
                                            Belize
                                        </option>
                                        <option value="BE">
                                            Belçika
                                        </option>
                                        <option value="BJ">
                                            Benin
                                        </option>
                                        <option value="BM">
                                            Bermuda
                                        </option>
                                        <option value="BY">
                                            Beyaz Rusya
                                        </option>
                                        <option value="BT">
                                            Bhutan
                                        </option>
                                        <option value="ZZ">
                                            Bilinmeyen veya Geçersiz Bölge
                                        </option>
                                        <option value="AE">
                                            Birleşik Arap Emirlikleri
                                        </option>
                                        <option value="GB">
                                            Birleşik Krallık
                                        </option>
                                        <option value="BO">
                                            Bolivya
                                        </option>
                                        <option value="BA">
                                            Bosna Hersek
                                        </option>
                                        <option value="BW">
                                            Botsvana
                                        </option>
                                        <option value="BV">
                                            Bouvet Adası
                                        </option>
                                        <option value="BR">
                                            Brezilya
                                        </option>
                                        <option value="BN">
                                            Brunei
                                        </option>
                                        <option value="BG">
                                            Bulgaristan
                                        </option>
                                        <option value="BF">
                                            Burkina Faso
                                        </option>
                                        <option value="BI">
                                            Burundi
                                        </option>
                                        <option value="CV">
                                            Cape Verde
                                        </option>
                                        <option value="GI">
                                            Cebelitarık
                                        </option>
                                        <option value="DZ">
                                            Cezayir
                                        </option>
                                        <option value="CX">
                                            Christmas Adası
                                        </option>
                                        <option value="DJ">
                                            Cibuti
                                        </option>
                                        <option value="CC">
                                            Cocos Adaları
                                        </option>
                                        <option value="CK">
                                            Cook Adaları
                                        </option>
                                        <option value="TD">
                                            Çad
                                        </option>
                                        <option value="CZ">
                                            Çek Cumhuriyeti
                                        </option>
                                        <option value="CN">
                                            Çin
                                        </option>
                                        <option value="DK">
                                            Danimarka
                                        </option>
                                        <option value="DM">
                                            Dominik
                                        </option>
                                        <option value="DO">
                                            Dominik Cumhuriyeti
                                        </option>
                                        <option value="TL">
                                            Doğu Timor
                                        </option>
                                        <option value="EC">
                                            Ekvator
                                        </option>
                                        <option value="GQ">
                                            Ekvator Ginesi
                                        </option>
                                        <option value="SV">
                                            El Salvador
                                        </option>
                                        <option value="ID">
                                            Endonezya
                                        </option>
                                        <option value="ER">
                                            Eritre
                                        </option>
                                        <option value="AM">
                                            Ermenistan
                                        </option>
                                        <option value="EE">
                                            Estonya
                                        </option>
                                        <option value="ET">
                                            Etiyopya
                                        </option>
                                        <option value="FK">
                                            Falkland Adaları (Malvinalar)
                                        </option>
                                        <option value="FO">
                                            Faroe Adaları
                                        </option>
                                        <option value="MA">
                                            Fas
                                        </option>
                                        <option value="FJ">
                                            Fiji
                                        </option>
                                        <option value="CI">
                                            Fildişi Sahilleri
                                        </option>
                                        <option value="PH">
                                            Filipinler
                                        </option>
                                        <option value="PS">
                                            Filistin Bölgesi
                                        </option>
                                        <option value="FI">
                                            Finlandiya
                                        </option>
                                        <option value="FR">
                                            Fransa
                                        </option>
                                        <option value="GF">
                                            Fransız Guyanası
                                        </option>
                                        <option value="TF">
                                            Fransız Güney Bölgeleri
                                        </option>
                                        <option value="PF">
                                            Fransız Polinezyası
                                        </option>
                                        <option value="GA">
                                            Gabon
                                        </option>
                                        <option value="GM">
                                            Gambia
                                        </option>
                                        <option value="GH">
                                            Gana
                                        </option>
                                        <option value="GN">
                                            Gine
                                        </option>
                                        <option value="GW">
                                            Gine-Bissau
                                        </option>
                                        <option value="GD">
                                            Granada
                                        </option>
                                        <option value="GL">
                                            Grönland
                                        </option>
                                        <option value="GP">
                                            Guadeloupe
                                        </option>
                                        <option value="GU">
                                            Guam
                                        </option>
                                        <option value="GT">
                                            Guatemala
                                        </option>
                                        <option value="GG">
                                            Guernsey
                                        </option>
                                        <option value="GY">
                                            Guyana
                                        </option>
                                        <option value="ZA">
                                            Güney Afrika
                                        </option>
                                        <option value="GS">
                                            Güney Georgia ve Güney Sandwich Adaları
                                        </option>
                                        <option value="KR">
                                            Güney Kore
                                        </option>
                                        <option value="CY">
                                            Güney Kıbrıs Rum Kesimi
                                        </option>
                                        <option value="GE">
                                            Gürcistan
                                        </option>
                                        <option value="HT">
                                            Haiti
                                        </option>
                                        <option value="HM">
                                            Heard Adası ve McDonald Adaları
                                        </option>
                                        <option value="IN">
                                            Hindistan
                                        </option>
                                        <option value="IO">
                                            Hint Okyanusu İngiliz Bölgesi
                                        </option>
                                        <option value="NL">
                                            Hollanda
                                        </option>
                                        <option value="AN">
                                            Hollanda Antilleri
                                        </option>
                                        <option value="HN">
                                            Honduras
                                        </option>
                                        <option value="HK">
                                            Hong Kong SAR - Çin
                                        </option>
                                        <option value="HR">
                                            Hırvatistan
                                        </option>
                                        <option value="IQ">
                                            Irak
                                        </option>
                                        <option value="VG">
                                            İngiliz Virgin Adaları
                                        </option>
                                        <option value="IR">
                                            İran
                                        </option>
                                        <option value="IE">
                                            İrlanda
                                        </option>
                                        <option value="ES">
                                            İspanya
                                        </option>
                                        <option value="IL">
                                            İsrail
                                        </option>
                                        <option value="SE">
                                            İsveç
                                        </option>
                                        <option value="CH">
                                            İsviçre
                                        </option>
                                        <option value="IT">
                                            İtalya
                                        </option>
                                        <option value="IS">
                                            İzlanda
                                        </option>
                                        <option value="JM">
                                            Jamaika
                                        </option>
                                        <option value="JP">
                                            Japonya
                                        </option>
                                        <option value="JE">
                                            Jersey
                                        </option>
                                        <option value="KH">
                                            Kamboçya
                                        </option>
                                        <option value="CM">
                                            Kamerun
                                        </option>
                                        <option value="CA">
                                            Kanada
                                        </option>
                                        <option value="ME">
                                            Karadağ
                                        </option>
                                        <option value="QA">
                                            Katar
                                        </option>
                                        <option value="KY">
                                            Kayman Adaları
                                        </option>
                                        <option value="KZ">
                                            Kazakistan
                                        </option>
                                        <option value="KE">
                                            Kenya
                                        </option>
                                        <option value="KI">
                                            Kiribati
                                        </option>
                                        <option value="CO">
                                            Kolombiya
                                        </option>
                                        <option value="KM">
                                            Komorlar
                                        </option>
                                        <option value="CG">
                                            Kongo
                                        </option>
                                        <option value="CD">
                                            Kongo Demokratik Cumhuriyeti
                                        </option>
                                        <option value="CR">
                                            Kosta Rika
                                        </option>
                                        <option value="KW">
                                            Kuveyt
                                        </option>
                                        <option value="KP">
                                            Kuzey Kore
                                        </option>
                                        <option value="MP">
                                            Kuzey Mariana Adaları
                                        </option>
                                        <option value="CU">
                                            Küba
                                        </option>
                                        <option value="KG">
                                            Kırgızistan
                                        </option>
                                        <option value="LA">
                                            Laos
                                        </option>
                                        <option value="LS">
                                            Lesotho
                                        </option>
                                        <option value="LV">
                                            Letonya
                                        </option>
                                        <option value="LR">
                                            Liberya
                                        </option>
                                        <option value="LY">
                                            Libya
                                        </option>
                                        <option value="LI">
                                            Liechtenstein
                                        </option>
                                        <option value="LT">
                                            Litvanya
                                        </option>
                                        <option value="LB">
                                            Lübnan
                                        </option>
                                        <option value="LU">
                                            Lüksemburg
                                        </option>
                                        <option value="HU">
                                            Macaristan
                                        </option>
                                        <option value="MG">
                                            Madagaskar
                                        </option>
                                        <option value="MO">
                                            Makao S.A.R. Çin
                                        </option>
                                        <option value="MK">
                                            Makedonya
                                        </option>
                                        <option value="MW">
                                            Malavi
                                        </option>
                                        <option value="MV">
                                            Maldivler
                                        </option>
                                        <option value="MY">
                                            Malezya
                                        </option>
                                        <option value="ML">
                                            Mali
                                        </option>
                                        <option value="MT">
                                            Malta
                                        </option>
                                        <option value="IM">
                                            Man Adası
                                        </option>
                                        <option value="MH">
                                            Marshall Adaları
                                        </option>
                                        <option value="MQ">
                                            Martinik
                                        </option>
                                        <option value="MU">
                                            Mauritius
                                        </option>
                                        <option value="YT">
                                            Mayotte
                                        </option>
                                        <option value="MX">
                                            Meksika
                                        </option>
                                        <option value="FM">
                                            Mikronezya Federal Eyaletleri
                                        </option>
                                        <option value="MD">
                                            Moldovya Cumhuriyeti
                                        </option>
                                        <option value="MC">
                                            Monako
                                        </option>
                                        <option value="MS">
                                            Montserrat
                                        </option>
                                        <option value="MR">
                                            Moritanya
                                        </option>
                                        <option value="MZ">
                                            Mozambik
                                        </option>
                                        <option value="MN">
                                            Moğolistan
                                        </option>
                                        <option value="MM">
                                            Myanmar
                                        </option>
                                        <option value="EG">
                                            Mısır
                                        </option>
                                        <option value="NA">
                                            Namibya
                                        </option>
                                        <option value="NR">
                                            Nauru
                                        </option>
                                        <option value="NP">
                                            Nepal
                                        </option>
                                        <option value="NE">
                                            Nijer
                                        </option>
                                        <option value="NG">
                                            Nijerya
                                        </option>
                                        <option value="NI">
                                            Nikaragua
                                        </option>
                                        <option value="NU">
                                            Niue
                                        </option>
                                        <option value="NF">
                                            Norfolk Adası
                                        </option>
                                        <option value="NO">
                                            Norveç
                                        </option>
                                        <option value="CF">
                                            Orta Afrika Cumhuriyeti
                                        </option>
                                        <option value="UZ">
                                            Özbekistan
                                        </option>
                                        <option value="PK">
                                            Pakistan
                                        </option>
                                        <option value="PW">
                                            Palau
                                        </option>
                                        <option value="PA">
                                            Panama
                                        </option>
                                        <option value="PG">
                                            Papua Yeni Gine
                                        </option>
                                        <option value="PY">
                                            Paraguay
                                        </option>
                                        <option value="PE">
                                            Peru
                                        </option>
                                        <option value="PN">
                                            Pitcairn
                                        </option>
                                        <option value="PL">
                                            Polonya
                                        </option>
                                        <option value="PT">
                                            Portekiz
                                        </option>
                                        <option value="PR">
                                            Porto Riko
                                        </option>
                                        <option value="RE">
                                            Reunion
                                        </option>
                                        <option value="RO">
                                            Romanya
                                        </option>
                                        <option value="RW">
                                            Ruanda
                                        </option>
                                        <option value="RU">
                                            Rusya Federasyonu
                                        </option>
                                        <option value="SH">
                                            Saint Helena
                                        </option>
                                        <option value="KN">
                                            Saint Kitts ve Nevis
                                        </option>
                                        <option value="LC">
                                            Saint Lucia
                                        </option>
                                        <option value="PM">
                                            Saint Pierre ve Miquelon
                                        </option>
                                        <option value="VC">
                                            Saint Vincent ve Grenadinler
                                        </option>
                                        <option value="WS">
                                            Samoa
                                        </option>
                                        <option value="SM">
                                            San Marino
                                        </option>
                                        <option value="ST">
                                            Sao Tome ve Principe
                                        </option>
                                        <option value="SN">
                                            Senegal
                                        </option>
                                        <option value="SC">
                                            Seyşeller
                                        </option>
                                        <option value="SL">
                                            Sierra Leone
                                        </option>
                                        <option value="SG">
                                            Singapur
                                        </option>
                                        <option value="SK">
                                            Slovakya
                                        </option>
                                        <option value="SI">
                                            Slovenya
                                        </option>
                                        <option value="SB">
                                            Solomon Adaları
                                        </option>
                                        <option value="SO">
                                            Somali
                                        </option>
                                        <option value="LK">
                                            Sri Lanka
                                        </option>
                                        <option value="SD">
                                            Sudan
                                        </option>
                                        <option value="SR">
                                            Surinam
                                        </option>
                                        <option value="SY">
                                            Suriye
                                        </option>
                                        <option value="SA">
                                            Suudi Arabistan
                                        </option>
                                        <option value="SJ">
                                            Svalbard ve Jan Mayen
                                        </option>
                                        <option value="SZ">
                                            Svaziland
                                        </option>
                                        <option value="RS">
                                            Sırbistan
                                        </option>
                                        <option value="CS">
                                            Sırbistan-Karadağ
                                        </option>
                                        <option value="CL">
                                            Şili
                                        </option>
                                        <option value="TJ">
                                            Tacikistan
                                        </option>
                                        <option value="TZ">
                                            Tanzanya
                                        </option>
                                        <option value="TH">
                                            Tayland
                                        </option>
                                        <option value="TW">
                                            Tayvan
                                        </option>
                                        <option value="TG">
                                            Togo
                                        </option>
                                        <option value="TK">
                                            Tokelau
                                        </option>
                                        <option value="TO">
                                            Tonga
                                        </option>
                                        <option value="TT">
                                            Trinidad ve Tobago
                                        </option>
                                        <option value="TN">
                                            Tunus
                                        </option>
                                        <option value="TC">
                                            Turks ve Caicos Adaları
                                        </option>
                                        <option value="TV">
                                            Tuvalu
                                        </option>
                                        <option value="TM">
                                            Türkmenistan
                                        </option>
                                        <option value="UG">
                                            Uganda
                                        </option>
                                        <option value="UA">
                                            Ukrayna
                                        </option>
                                        <option value="OM">
                                            Umman
                                        </option>
                                        <option value="UY">
                                            Uruguay
                                        </option>
                                        <option value="QO">
                                            Uzak Okyanusya
                                        </option>
                                        <option value="JO">
                                            Ürdün
                                        </option>
                                        <option value="VU">
                                            Vanuatu
                                        </option>
                                        <option value="VA">
                                            Vatikan
                                        </option>
                                        <option value="VE">
                                            Venezuela
                                        </option>
                                        <option value="VN">
                                            Vietnam
                                        </option>
                                        <option value="WF">
                                            Wallis ve Futuna
                                        </option>
                                        <option value="YE">
                                            Yemen
                                        </option>
                                        <option value="NC">
                                            Yeni Kaledonya
                                        </option>
                                        <option value="NZ">
                                            Yeni Zelanda
                                        </option>
                                        <option value="GR">
                                            Yunanistan
                                        </option>
                                        <option value="ZM">
                                            Zambiya
                                        </option>
                                        <option value="ZW">
                                            Zimbabve
                                        </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
   
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address_city">İl / İlçe</label>
                                                        <span class="form-note d-none d-md-block">Fatura adresinin bulunduğu il ve ilçe bilgisi</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-xxl-3 col-6 mt-0 mt-md-2">
                                                <div class="form-control-wrap" id="ilDegisiklik">
                                                        <select id="Iller" name="address_city" class="form-select js-select2 add_city otomatikUlke" data-ui="lg" data-search="on" data-placeholder="İl Seçiniz">
                                                            <option value="0">İl seçiniz</option>
                                                        </select>
                                                        <input type="hidden" name="address_city_plate" id="address_city_plate" value="<?= $invoice_item['address_city_plate'] ?>">
                                                        <input type="hidden" class="manuelUlke form-control  form-control-lg form-control-lg" name="address_city_name" id="address_city_name" value="<?= $invoice_item['address_city'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-xxl-4 col-6 mt-0 mt-md-2">
                                                <div class="form-control-wrap" id="IlceDegisiklik">
                                                        <select id="Ilceler" name="address_district" class="form-select js-select2 otomatikUlke" data-ui="lg" data-search="on" data-placeholder="İlçe Seçiniz " disabled="disabled">
                                                            <option value="0">Önce il seçiniz</option>
                                                        </select>
                                                        <input type="hidden" class="manuelUlke form-control  form-control-lg form-control-lg" name="address_district" id="address_district"  >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="zip_code">Posta Kodu</label>
                                                        <span class="form-note d-none d-md-block">Fatura adresinin posta kodu.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-xxl-3 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control  form-control-lg form-control-lg" id="zip_code" name="zip_code" value="<?= $invoice_item['address_zip_code'] == 0 ? '' : $invoice_item['address_zip_code'] ?>" placeholder="Posta Kodu">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="cari_email">E-posta</label>
                                                        <span class="form-note d-none d-md-block">Carinin faturalarının gönderileceği e-posta adresi.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control  form-control-lg form-control-lg" id="cari_email" value="<?= $invoice_item['cari_email'] ?>" placeholder="Cari e-posta" name="cari_email">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="cari_phone">Telefon</label><span class="form-note d-none d-md-block">Carinin iletişim için telefon numarası</span></div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-lg btn-block btn-dim btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                                                                    <span id="lastAreaCode">+90</span>
                                                                    <em class="icon mx-n1 ni ni-chevron-down"></em>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <select id="area_code" name="area_code" class="form-select js-select2" data-ui="lg" data-search="on">
                                                                        <option id="selecteditem" value=""></option>
                                                                        <option value="+90" selected>🇹🇷 (+90)
                                                                            Türkiye
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <input type="text" class="form-control  form-control-lg form-control-lg" name="cari_phone" id="cari_phone" aria-label="Carinin iletişim için telefon numarası" placeholder="000 000 0000" value="<?php if ($invoice_item['cari_phone'] != 0) {
                                                                                                                                                                                                                                                                    $phone = explode(" ", $invoice_item['cari_phone']);
                                                                                                                                                                                                                                                                    echo $phone[1];
                                                                                                                                                                                                                                                                } ?>" onkeypress="return SadeceRakam(event,['-'],'');">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="is_customer_save">Müşteri
                                                            Kaydet / Güncelle</label>
                                                        <span class="form-note d-none d-md-block">Müşteri sistemde kayıtlı ise
                                                            bilgileri güncellenir,<br>kayıtlı değil ise kaydedilir.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <ul class="custom-control-group">
                                                        <li>
                                                            <div class="custom-control custom-checkbox custom-control-pro">
                                                                <input type="checkbox" class="custom-control-input" name="is_customer_save" id="is_customer_save">
                                                                <label class="custom-control-label" for="is_customer_save">
                                                                    Evet
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="" class=" gy-2">
                                         
                                           

                                            <input type="hidden" name="cari_id" id="cari_id">


                                            <div id="fatura_satirlar" class="">

                                            <?php $startZero = 0;
                                            foreach ($invoice_rows as $invoice_row) { ?>

                                                <div class="row no-gutters mb-2 ftr_str " id="Satir_<?= $startZero ?>" visible="true" gider_satir_id="<?= $invoice_row['gider_satir_id'] ?>">
                                                   
     
                                            


                                                        <div class="row g-3 align-center">
                                <div class="col-lg-5 col-xxl-5 ">
                                <div class="form-group"><label class="form-label" for="identification_number">Açıklama</label>
                                                    <span class="form-note d-none d-md-block">Gider Başlığı</span>
                                                </div>
                                    </div>
                                    <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">
                                        <div class="form-control-wrap">
                                        <input type="text" satir="<?= $startZero ?>" class="form-control form-control-lg" urun_id="<?= $invoice_row['stock_id'] ?>" str_id="<?= $startZero ?>" id="txt_aciklama_<?= $startZero ?>" value="<?= htmlspecialchars($invoice_row['stock_title']) ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 align-center">
                                <div class="col-lg-5 col-xxl-5 ">
                                <div class="form-group"><label class="form-label" for="identification_number">Fiyat</label>
                                                    <span class="form-note d-none d-md-block">Gider Fiyatı</span>
                                                </div>
                                    </div>
                                    <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">
                                        <div class="form-control-wrap">
                                        <input type="text" class="form-control form-control-lg   text-end px-1 ftr_hesap para" id="txt_birim_fiyat_<?= $startZero ?>" placeholder="0,00" satir="<?= $startZero ?>" value="<?= number_format($invoice_row['unit_price'], 2, ',', '.') ?>" onkeypress="return SadeceRakam(event,[',']);">
                                    </div>
                                    </div>
                                </div>

                                <div class="row g-3 align-center">
                                <div class="col-lg-5 col-xxl-5 ">
                                <div class="form-group"><label class="form-label" for="identification_number">Kdv Oranı</label>
                                                    <span class="form-note d-none d-md-block">Gider Kdv Oranı</span>
                                                </div>
                                    </div>
                                    <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">
                                        <div class="form-control-wrap">
                                        <select class="form-select form-control form-control-lg js-select2 ftr_select ftr_select_yeni_fatura para" data-search="on" id="slct_kdv_<?= $startZero ?>" satir="<?= $startZero ?>" data-placeholder="Seçiniz">
                                                                                    <option></option>
                                                                                    <?php foreach (session()->get('tax_rate_items') as $item) { ?>
                                                                                        <option value="<?= $item['tax_value'] ?>"> <?= $item['tax_name'] ?> </option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <input type="hidden" name="base_slct_kdv" id="base_slct_kdv_<?= $startZero ?>" value="<?= $invoice_row['tax_id'] ?>">

                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 align-center">
                                <div class="col-lg-5 col-xxl-5 ">
                                <div class="form-group"><label class="form-label" for="identification_number">KDV Dahil Toplam</label>
                                                    <span class="form-note d-none d-md-block">Gider Kdv Dahil Toplam Fiyatı</span>
                                                </div>
                                    </div>
                                    <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">
                                        <div class="form-control-wrap">
                                        <input type="text" disabled class="form-control  form-control-lg    text-end px-1 genel_toplam_hesapla para" value="0,00" id="txt_genel_toplam_<?= $startZero ?>" placeholder="" satir="<?= $startZero ?>">
                                        </div>
                                    </div>
                                </div>


                                                            <div class="col-lg-3 col-sm-6 pe-sm-1 ps-sm-0 d-none">
                                                                <div class="row  g-1">
                                                                    <div class="col-lg-3 col-4 d-none">
                                                                        <div class="form-group">
                                                                            <label class="form-label mt-2 mb-0" for="txt_miktar_<?= $startZero ?>">Miktar</label>
                                                                            <div class="form-control-wrap str_kaldir">
                                                                                <input type="text" class="form-control   text-end px-1 ftr_hesap para" placeholder="0" id="txt_miktar_<?= $startZero ?>" satir="<?= $startZero ?>" value="<?= number_format($invoice_row['stock_amount'], 2, ',', '.') ?>" onkeypress="return SadeceRakam(event,[',']);">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-5 col-4 d-none">
                                                                        <div class="form-group">
                                                                            <label class="form-label mt-2 mb-0 " for="slct_birim_<?= $startZero ?>">Birim</label>
                                                                            <div class="form-control-wrap str_kaldir">
                                                                                <select class="form-select js-select2 form-control  ftr_select select_birim_yeniFatura" data-search="on" id="slct_birim_<?= $startZero ?>" satir="<?= $startZero ?>" data-placeholder="Seçiniz">
                                                                                    <option></option>

                                                                                </select>
                                                                                <input type="hidden" name="base_slct_birim" id="base_slct_birim_<?= $startZero ?>" value="<?= $invoice_row['unit_id'] ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-sm-4 col-md-4 col-8 pe-sm-1 ps-sm-2 ps-lg-0 d-none">
                                                                <div class="row g-1">
                                                                    <div class="col-lg-6 col-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label mt-2 mb-0" for="txt_iskonto_orani_<?= $startZero ?>">İsk. %</label>
                                                                            <div class="form-control-wrap str_kaldir">
                                                                                <input type="text" class="form-control   text-end px-1 ftr_hesap para ftr_hesap para ftr_hesap_iskonto_yuzde" placeholder="0" id="txt_iskonto_orani_<?= $startZero ?>" satir="<?= $startZero ?>" value="<?= number_format($invoice_row['discount_rate'], 2, ',', '.') ?>" onkeypress="return SadeceRakam(event,[',']);">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label mt-2 mb-0" for="txt_iskonto_tutari_<?= $startZero ?>">İsk. Tutarı</label>
                                                                            <div class="form-control-wrap str_kaldir">

                                                                                <input type="text" class="form-control   text-end px-1 ftr_hesap para ftr_hesap para txt_iskonto_tutari" id="txt_iskonto_tutari_<?= $startZero ?>" placeholder="0,00" satir="<?= $startZero ?>" value="<?= number_format($invoice_row['discount_price'], 2, ',', '.') ?>" onkeypress="return SadeceRakam(event,[',']);">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1 col-sm-4 col-md-2 col-4 pe-sm-1 ps-sm-0 d-none">
                                                                <div class="form-group">
                                                                    <label class="form-label mt-2 mb-0" for="txt_ara_toplam_<?= $startZero ?>">A. Toplam</label>
                                                                    <div class="form-control-wrap str_kaldir">
                                                                        <input type="text" class="form-control   text-end px-1 ftr_hesap para" value="<?= number_format($invoice_row['subtotal_price'], 2, ',', '.') ?>" disabled="" id="txt_ara_toplam_<?= $startZero ?>" placeholder="" satir="<?= $startZero ?>" onkeypress="return SadeceRakam(event,[',']);">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-sm-4 col-8 pe-sm-1 ps-sm-0 d-none">
                                                                <div class="row g-1">
                                                                  
                                                                    <div class="col-lg-6 col-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label mt-2 mb-0" for="txt_kdv_<?= $startZero ?>">KDV Tutarı</label>
                                                                            <div class="form-control-wrap str_kaldir">
                                                                                <input type="text" class="form-control text-end px-1 para" id="txt_kdv_<?= $startZero ?>" placeholder="0,00" satir="<?= $startZero ?>" value="<?= $invoice_row['tax_price'] ?>" disabled="">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1 col-sm-4 col-md-2 col-4 ps-sm-2 ps-md-0 d-none">
                                                                <div class="form-group">
                                                                    <label class="form-label mt-2 mb-0" for="txt_genel_toplam_<?= $startZero ?>">G.Toplam</label>
                                                                    <div class="form-control-wrap str_kaldir">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    
                                            

                                  


                                                </div>


                                                <div class="col-lg-11 V9015 diger_vergi diger_vergi_sec mt-2" id="tevkifat_area_<?= $startZero ?>" satir="<?= $startZero ?>">
                                                        <div class="row  g-1">
                                                            <div class="col-lg-5 col-12  pe-sm-1 ps-sm-0">
                                                                <div class="form-group">
                                                                    <label class="form-label mb-0 mt-1" for="txt_V9015_<?= $startZero ?>">Tevkifat Kodu</label>

                                                                    <div class="form-control-wrap">
                                                                        <!-- Bu selectin aramalı olmasını istiyorum. -->
                                                                        <select class="form-select form-select-lg form-control  tevkifat_tipi slct_tevkifat_tipi" data-search="on" id="slct_tevkifat_tipi_<?= $startZero ?>" satir="<?= $startZero ?>" data-placeholder="Seçiniz">
                                                                            <option></option>

                                                                        </select>
                                                                        <input type="hidden" name="base_slct_tevkifat_tipi_" id="base_slct_tevkifat_tipi_<?= $startZero ?>" value="0">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-sm-6 pe-sm-1 ps-sm-0">
                                                                <div class="row  g-1">
                                                                    <div class="col-lg-4 col-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label mb-0 mt-1" for="txt_V9015_oran_<?= $startZero ?>">Tevkifat %</label>
                                                                            <div class="form-control-wrap">
                                                                                <input type="text" class="form-control   text-end px-1 ftr_hesap para" placeholder="0" id="txt_V9015_oran_<?= $startZero ?>" value=0" disabled="">

                                                                                <!-- Sadece diğer seceneginde disabled kalkacak oranı kendi girecek. -->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-5 col-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label mb-0 mt-1" for="txt_V9015_oran_<?= $startZero ?>">Tevkifat Tutar</label>
                                                                            <div class="form-control-wrap">
                                                                                <input type="text" class="form-control   text-end px-1 ftr_hesap para" placeholder="0,00" id="txt_V9015_<?= $startZero ?>" value="<?= number_format(0,2,',','.') ?>" onkeypress="return SadeceRakam(event,[',']);">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <input type="hidden" name="" id="txt_V9015_islem_tutar_<?= $startZero ?>">
                                                            <input type="hidden" name="" id="txt_V9015_hesaplanan_kdv_<?= $startZero ?>">

                                                        </div>
                                                    </div>

                                            <?php $startZero += 1;
                                            } ?>




</div>



                                            <div class="gy-3">

                              
                            

                                <div class="row g-3 align-center">
                                <div class="col-lg-5 col-xxl-5 ">
                                       
                                        <div class="form-group"><label class="form-label" for="identification_number">Fiş / Fatura No</label>
                                                    <span class="form-note d-none d-md-block">Fiş Numarasını Giriniz</span>
                                                </div>
                                    </div>
                                    <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">
                                        <div class="form-control-wrap">
                                            <input type="text" disabled class="form-control form-control-xl" id="fatura_no" name="fatura_no" value="<?php echo $invoice_item["gider_no"] ?>" placeholder="Fiş / Fatura No" maxlength="16">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 align-center">
                                <div class="col-lg-5 col-xxl-5 ">
                                      
                                        <div class="form-group"><label class="form-label" for="identification_number">Fiş / Fatura Tarihi</label>
                                                    <span class="form-note d-none d-md-block">Fiş Tarihi Giriniz</span>
                                                </div>
                                    </div>
                                    <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar icon-xl"></em>
                                            </div>
                                            <input id="fatura_tarihi" type="text" name="fatura_tarihi" class="form-control form-control-xl date-picker" data-date-format="dd/mm/yyyy" placeholder="Fiş / Fatura Tarihi" value="<?= date('d/m/Y', strtotime($invoice_item["gider_date"])) ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 align-center">
                                <div class="col-lg-5 col-xxl-5 ">
                                      
                                        <div class="form-group"><label class="form-label" for="identification_number">Gider Para Birimi</label>
                                                    <span class="form-note d-none d-md-block">Gider Para Birimi Giriniz</span>
                                                </div>
                                    </div>
                                    <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">
                                        
                                   
                                    <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                <div class="col-lg-12 col-xxl-12 col-12 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group">

                                                        <select disabled class="form-select form-select-lg js-select2 form-control slct_doviz_tipi" data-ui="lg" data-search="on" id="slct_doviz_tipi" satir="0" data-ui="lg" data-placeholder="Seçiniz">
                                                            <option></option>
                                                            <?php foreach ($money_unit_items as $money_unit_item) { ?>
                                                                <option value="<?= $money_unit_item['money_unit_id'] ?>" data-money-unit-code="<?= $money_unit_item['money_code'] ?>" data-money-unit-icon="<?= $money_unit_item['money_icon'] ?>" <?php if ($invoice_item['money_unit_id'] == $money_unit_item['money_unit_id']) {
                                                                                                                                                                                                                                                        echo "selected";
                                                                                                                                                                                                                                                    } ?>>
                                                                    <?= $money_unit_item['money_code'] ?> -
                                                                    <?= $money_unit_item['money_title'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <input type="hidden" name="base_slct_doviz_tipi" id="base_slct_doviz_tipi" value="<?= $invoice_item['money_unit_id'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-9 col-xxl-9 col-9 mt-0 mt-md-2 ps-1 d-none" id="txt_doviz_kuru_area">
                                                    <div class="input-group">
                                                        <input type="text" name="txt_doviz_kuru" id="txt_doviz_kuru" class="form-control form-control-lg form-control-lg text-end doviz_degis" placeholder="0,0000" onkeypress="return SadeceRakam(event,[',']);" value="<?= number_format($invoice_item['currency_amount'],2,',','.') ?>">
                                                        <input type="hidden" name="txt_doviz_kuru_eski" id="txt_doviz_kuru_eski" class="form-control form-control-lg form-control-lg text-end " placeholder="0,0000" onkeypress="return SadeceRakam(event,[',']);" value="<?= number_format($invoice_item['currency_amount'],2,',','.') ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="txt_doviz_kuru">TRY</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-control-wrap fatura_kur_goster d-none">
                                            <div class="input-group">
                                                <input type="text" id="fatura_kur" name="fatura_kur" class="form-control form-control-xl text-right" value="1" onkeypress="return SadeceRakam(event,[',','-']);" onblur="SadeceRakamBlur(event,true);">
                                                <div class="input-group-append"><span class="input-group-text">TL.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 align-center">
                                <div class="col-lg-5 col-xxl-5 ">
                                        <div class="form-group">
                                            <label class="form-label" for="odeme_durumu">Ödeme Durumu</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">
                                        <div class="custom-control custom-checkbox custom-control-pro no-control">
                                            <input disabled type="radio" class="custom-control-input" <?php if($invoice_item["odeme_durumu"] == "odenecek"): echo 'checked'; endif; ?> name="odeme_durumu" id="odenecekCheckbox" value="odenecek">
                                            <label class="custom-control-label" for="odenecekCheckbox">
                                                <em class="icon ni ni-clock"></em>
                                                <span>Ödenecek</span>
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-pro no-control">
                                            <input disabled type="radio" class="custom-control-input" name="odeme_durumu" <?php if($invoice_item["odeme_durumu"] == "odendi"): echo 'checked'; endif; ?> id="odendiCheckbox" value="odendi">
                                            <label class="custom-control-label" for="odendiCheckbox">
                                                <em class="icon ni ni-check-thick"></em>
                                                <span>Ödendi</span>
                                            </label>
                                        </div>
                                       
                                    </div>
                                </div>

                                <div id="kasaBlock" class="row g-3 align-center <?php if($invoice_item["odeme_durumu"] != "odendi"): echo 'd-none'; endif; ?>">
                                <div class="col-lg-5 col-xxl-5 ">
                                        <div class="form-group">
                                            <label class="form-label" for="kasa_banka">Kasa/Banka Seçimi</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">

                                    <select disabled class="form-select form-select-lg js-select2 form-control " data-ui="lg" data-search="on"  name="kasa_sec" id="kasa_sec" satir="0" data-ui="lg" data-placeholder="Seçiniz">
                                                            <option></option>
                                                            <?php foreach ($kasalar as $kasa) { ?>
                                                                <option
                                                                <?php if($kasa["financial_account_id"] == $invoice_item["kasa_id"]): echo 'selected'; endif; ?>
                                                                value="<?= $kasa['financial_account_id'] ?>">
                                                                <?= $kasa['money_code'] ?> - <?= $kasa['account_title'] ?> 
                                                                   </option>
                                                            <?php } ?>
                                                        </select>
                                       
                                    </div>
                                </div>

                         
                               
                                <div class="row g-3 align-center">
                                <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="obligation">Ödeneceği Tarih</label>
                                                    <span class="form-note d-none d-md-block">Ödeneceği tarihi seçiniz.</span>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-nowrap col-lg-6 col-xxl-6">
                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                            </div>
                                                            <input type="text" class="form-control  form-control-lg form-control-lg date-picker" name="offer_date" value="<?= date('d/m/Y', strtotime($invoice_item["gider_date"])) ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xxl-5 col-4 mt-0 mt-md-2 ps-1">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni icon-lg ni-clock"></em>
                                                            </div>
                                                            <input type="text" class="form-control  form-control-lg form-control-lg time-picker" name="offer_time" value="<?= date('H:i') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                <div class="row g-3 align-center">
                                <div class="col-lg-5 col-xxl-5 ">
                                        <div class="form-group">
                                            <label class="form-label" for="gider_kategorisi">Gider Kategorisi</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">
                                        <div class="form-control-wrap">
                                        <select class="form-select form-select-lg js-select2 form-control " data-ui="lg" data-search="on" name="gider_kategori" id="gider_kategori" satir="0" data-ui="lg" data-placeholder="Seçiniz">
                                                            <option></option>
                                                            <?php foreach ($gider_grup as $gider) { ?>
                                                                <optgroup label="<?php echo $gider["gider_group_category_title"]; ?>">
                                                                <?php foreach($gider_kategori as $kat):
                                                                        if($kat["grup_id"] == $gider["gider_group_category_id"]):
                                                                    ?>
                                                                    <option 
                                                                    <?php if($kat["gider_category_id"] == $invoice_item["gider_kategori"]): echo 'selected'; endif; ?>
                                                                    value="<?= $kat['gider_category_id'] ?>">
                                                               <?= $kat['gider_category_title'] ?> 
                                                                   </option>
                                                                <?php endif; endforeach; ?>
                                                                   </optgroup>
                                                            <?php } ?>
                                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <form id="createInvoices" method="post" enctype="multipart/form-data">
                                <div class="row g-3 align-center">
                                <div class="col-lg-5 col-xxl-5">
                                    <div class="form-group">
                                        <label class="form-label" for="fis_fatura_belge">Fiş/Fatura Belge</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">
                                    <input type="hidden" id="fis_fatura_belge_ekleme" value="0">
                                    <div class="form-control-wrap">
                                        <div class="form-file">
                                            <input type="file" class="form-file-input" name="fis_fatura_belge" id="fis_fatura_belge">
                                            <label class="form-file-label" for="fis_fatura_belge">Dosya Seçiniz</label>
                                        </div>
                                    </div>
                                 
                                    <div id="file-preview" class="mt-3"></div>
                                    <input type="hidden" id="fis_fatura_belge_data" value="<?= $invoice_item['fis_fatura_belge']; ?>" />
                                 
                                </div>
                            </div>
                            </form>


                            <div class="row g-3 align-center">
                                <div class="col-lg-5 col-xxl-5 ">
                                       
                                        <div class="form-group"><label class="form-label" for="identification_number">Toplam Tutar Yazıyla</label>
                                                    <span class="form-note d-none d-md-block">Gider Toplam Tutar Yazıyla</span>
                                                </div>
                                    </div>
                                    <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">
                                        <div class="form-control-wrap">
                                        <input type="text" class="form-control form-control-lg px-1" placeholder="" value="<?= $invoice_item['amount_to_be_paid_text'] ?>" name="total_to_text" id="total_to_text" disabled="">
                                        </div>
                                    </div>
                                </div>


                            
                           

                            </div>


                                     
                                        </div>











                              



                                     
                                 


                                        


                                      


                                        <div class="row no-gutters mt-1 d-none">

                                            <div class="col-lg-7">

                                                <div class="form-group">
                                                    <label class="form-label mt-2 mb-0" for="total_to_text">Toplam Tutar Yazıyla</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-lg px-1" placeholder="" value="<?= $invoice_item['amount_to_be_paid_text'] ?>" name="total_to_text" id="total_to_text" disabled="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label mt-2 mb-0 " for="slct_invoice_note">Not Seçin</label>
                                                    <div class="form-control-wrap str_kaldir">
                                                        <select class="form-select js-select2 form-select-lg form-control" data-ui="lg" data-search="on" id="slct_invoice_note" data-placeholder="Seçiniz">
                                                            <option>seçiniz</option>
                                                        </select>
                                                        <input type="hidden" name="base_slct_note" id="base_slct_note" value="<?= $invoice_item['gider_note_id'] ?>">
                                                    </div>
                                                </div>


                                                <div class="form-group d-none" id="fatura_not_baslik_area">
                                                    <label class="form-label mb-0" for="txt_fatura_not_baslik">Fatura Notu Başlığı</label>
                                                    <div class="form-control-wrap str_kaldir">
                                                        <input class="form-control form-control-lg" id="txt_fatura_not_baslik" name="txt_fatura_not_baslik" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label mb-0" for="txt_fatura_not">Fatura Notu</label>
                                                    <div class="form-control-wrap str_kaldir">
                                                        <input type="hidden" id="fatura_not_id" name="fatura_not_id">
                                                        <textarea class="form-control  form-control-lg form-control-xl" id="txt_fatura_not" name="txt_fatura_not" style="min-height: 200px;"></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="custom-control custom-control-lg custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="chk_not_kaydet" name="chk_not_kaydet">
                                                        <label class="custom-control-label" for="chk_not_kaydet">
                                                            Daha sonra kullanmak üzere notu <strong>kaydet</strong>
                                                        </label>
                                                    </div>
                                                </div>

                                              
                                            </div>

                                            <div class="col-lg-4">

                                                <div class="row no-gutter mt-1">
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end">
                                                        <label class="form-label mt-2 mb-1 " for="txt_kdvsiz_toplam">Mal/Hizmet Toplam</label>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 text-end">

                                                        <div class="input-group">
                                                            <input type="text" name="txt_kdvsiz_toplam" id="txt_kdvsiz_toplam" class="transparent-input form-control form-control-sm text-end para" value="<?= number_format($invoice_item['sub_total'],2,',','.') ?>">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text dvz" id="txt_doviz_kuru">TRY</span>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end dvz_str">
                                                        <label class="form-label mt-2 mb-1 " for="txt_kdvsiz_toplam_dvz"></label>
                                                    </div>

                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 dvz_str">
                                                        <div class="input-group">
                                                            <input type="text" class="transparent-input form-control form-control-sm text-end para" id="txt_kdvsiz_toplam_dvz" value="" placeholder="0,00" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row no-gutter mt-1">
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end">
                                                        <label class="form-label mt-2 mb-1 " for="txt_iskonto_toplam">İskonto Toplam</label>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 text-end">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_iskonto_toplam" id="txt_iskonto_toplam" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" value="<?= $invoice_item['discount_total'] ?>" onkeypress="return SadeceRakam(event,[',']);" disabled="">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text dvz" id="txt_doviz_kuru">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end dvz_str">
                                                        <label class="form-label mt-2 mb-1 " for="txt_iskonto_toplam_dvz"></label>
                                                    </div>

                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 dvz_str">
                                                        <div class="input-group">
                                                            <input type="text" class="transparent-input form-control form-control-sm text-end para" id="txt_iskonto_toplam_dvz" value="" placeholder="0,00" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row no-gutter mt-1">
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end">
                                                        <label class="form-label mt-2 mb-1 " for="txt_ara_toplam">Ara Toplam</label>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 text-end">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_ara_toplam" id="txt_ara_toplam" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" value="<?= $invoice_item['sub_total'] ?>" onkeypress="return SadeceRakam(event,[',']);" disabled="">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text dvz" id="txt_doviz_kuru">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end dvz_str">
                                                        <label class="form-label mt-2 mb-1 " for="txt_ara_toplam_dvz"></label>
                                                    </div>

                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 dvz_str">
                                                        <div class="input-group">
                                                            <input type="text" class="transparent-input form-control form-control-sm text-end para" id="txt_ara_toplam_dvz" value="" placeholder="0,00" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row no-gutter mt-1 d-none" id="visibleKdv1">
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end">
                                                        <label class="form-label mt-2 mb-1 " for="txt_kdv_toplam1">KDV Toplam (%1)</label>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 text-end">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_kdv_toplam1" id="txt_kdv_toplam1" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" value="<?= $invoice_item['sub_total_1'] ?>" onkeypress="return SadeceRakam(event,[',']);" disabled="">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text dvz" id="txt_doviz_kuru">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end dvz_str">
                                                        <label class="form-label mt-2 mb-1 " for="txt_kdv_toplam1_dvz"></label>
                                                    </div>

                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 dvz_str">
                                                        <div class="input-group">
                                                            <input type="text" class="transparent-input form-control form-control-sm text-end para" id="txt_kdv_toplam1_dvz" value="" placeholder="0,00" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row no-gutter mt-1 d-none" id="visibleKdv10">
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end">
                                                        <label class="form-label mt-2 mb-1 " for="txt_kdv_toplam10">KDV Toplam (%10)</label>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 text-end">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_kdv_toplam10" id="txt_kdv_toplam10" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" value="<?= $invoice_item['sub_total_10'] ?>" onkeypress="return SadeceRakam(event,[',']);" disabled="">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text dvz" id="txt_doviz_kuru">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end dvz_str">
                                                        <label class="form-label mt-2 mb-1 " for="txt_kdv_toplam10_dvz"></label>
                                                    </div>

                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 dvz_str">
                                                        <div class="input-group">
                                                            <input type="text" class="transparent-input form-control form-control-sm text-end para" id="txt_kdv_toplam10_dvz" value="" placeholder="0,00" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row no-gutter mt-1 d-none" id="visibleKdv20">
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end">
                                                        <label class="form-label mt-2 mb-1 " for="txt_kdv_toplam20">KDV Toplam (%20)</label>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 text-end">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_kdv_toplam20" id="txt_kdv_toplam20" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" value="<?= $invoice_item['sub_total_20'] ?>" onkeypress="return SadeceRakam(event,[',']);" disabled="">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text dvz" id="txt_doviz_kuru">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end dvz_str">
                                                        <label class="form-label mt-2 mb-1 " for="txt_kdv_toplam20_dvz"></label>
                                                    </div>

                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 dvz_str">
                                                        <div class="input-group">
                                                            <input type="text" class="transparent-input form-control form-control-sm text-end para" id="txt_kdv_toplam20_dvz" value="" placeholder="0,00" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row no-gutter mt-1 V9015 diger_vergi diger_vergi_sec">
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end">
                                                        <label class="form-label mt-2 mb-1 " for="txt_V9015_islem_tutar">Tevkifata Tabi İşlem Tutar</label>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 text-end">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_V9015_islem_tutar" id="txt_V9015_islem_tutar" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" value="0" onkeypress="return SadeceRakam(event,[',']);" disabled="">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text dvz" id="txt_doviz_kuru">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end dvz_str">
                                                        <label class="form-label mt-2 mb-1 " for="txt_V9015_islem_tutar_dvz"></label>
                                                    </div>

                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 dvz_str">
                                                        <div class="input-group">
                                                            <input type="text" class="transparent-input form-control form-control-sm text-end para" id="txt_V9015_islem_tutar_dvz" value="" placeholder="0,00" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row no-gutter mt-1 V9015 diger_vergi diger_vergi_sec">
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end">
                                                        <label class="form-label mt-2 mb-1 " for="txt_V9015_hesaplanan_kdv">Tevkifata Tabi İşlem Hes. KDV.</label>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 text-end">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_V9015_hesaplanan_kdv" id="txt_V9015_hesaplanan_kdv" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" value="0" onkeypress="return SadeceRakam(event,[',']);" disabled="">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text dvz" id="txt_doviz_kuru">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end dvz_str">
                                                        <label class="form-label mt-2 mb-1 " for="txt_V9015_hesaplanan_kdv_dvz"></label>
                                                    </div>

                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 dvz_str">
                                                        <div class="input-group">
                                                            <input type="text" class="transparent-input form-control form-control-sm text-end para" id="txt_V9015_hesaplanan_kdv_dvz" value="" placeholder="0,00" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row no-gutter mt-1 V9015 diger_vergi diger_vergi_sec">
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end">
                                                        <label class="form-label mt-2 mb-1 " for="txt_V9015">KDV Tevkifat</label>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 text-end">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_V9015" id="txt_V9015" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" value="0" onkeypress="return SadeceRakam(event,[',']);" disabled="">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text dvz" id="txt_doviz_kuru">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end dvz_str">
                                                        <label class="form-label mt-2 mb-1 " for="txt_V9015_dvz"></label>
                                                    </div>

                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 dvz_str">
                                                        <div class="input-group">
                                                            <input type="text" class="transparent-input form-control form-control-sm text-end para" id="txt_V9015_dvz" value="" placeholder="0,00" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row no-gutter mt-1">
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end">
                                                        <label class="form-label mt-2 mb-1 " for="txt_genel_toplam">Genel Toplam</label>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 text-end">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_genel_toplam" id="txt_genel_toplam" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" value="<?= $invoice_item['grand_total'] ?>" onkeypress="return SadeceRakam(event,[',']);" disabled="">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text dvz" id="txt_doviz_kuru">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end dvz_str">
                                                        <label class="form-label mt-2 mb-1 " for="txt_genel_toplam_dvz"></label>
                                                    </div>

                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 dvz_str">
                                                        <div class="input-group">
                                                            <input type="text" class="transparent-input form-control form-control-sm text-end para" id="txt_genel_toplam_dvz" value="" placeholder="0,00" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row no-gutter mt-1">
                                                <hr>

                                                    <?php foreach($Kurlar as $kur): ?>
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end kur_table_<?php echo $kur["money_unit_id"]; ?>">
                                                        <label class="form-label mb-1 " for="txt_genel_toplam">
                                                        <div class="input-group">
                                                            <input type="text" name="kur_fiyat_<?php echo $kur["money_code"]; ?>" id="kur_fiyat_<?php echo $kur["money_code"]; ?>" class="transparent-input form-control form-control-sm text-end para" value="<?php echo $kur["money_value"]; ?>"onkeypress="return SadeceRakam(event,[',']);" >
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text " id="">TRY</span>
                                                            </div>
                                                        </div>

                                                        </label>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 text-end kur_table_<?php echo $kur["money_unit_id"]; ?>">
                                                        <div class="input-group">
                                                            <input type="text" name="kur_toplam_fiyat_<?php echo $kur["money_code"]; ?>" id="kur_toplam_fiyat_<?php echo $kur["money_code"]; ?>"  class="transparent-input form-control form-control-sm text-end para" placeholder="0,00"onkeypress="return SadeceRakam(event,[',']);" disabled="">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text " id=""><?php echo $kur["money_code"]; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; ?>

                                                </div>


                                                <div class="row no-gutter mt-1 V9015 diger_vergi diger_vergi_sec">
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end">
                                                        <label class="form-label mt-2 mb-1 " for="txt_odenecek_tutar">Ödenecek Tutar</label>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 text-end">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_odenecek_tutar" id="txt_odenecek_tutar" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" value="<?= $invoice_item['amount_to_be_paid'] ?>" onkeypress="return SadeceRakam(event,[',']);" disabled="">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text dvz" id="txt_doviz_kuru">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end dvz_str">
                                                        <label class="form-label mt-2 mb-1 " for="txt_odenecek_tutar_dvz"></label>
                                                    </div>

                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 dvz_str">
                                                        <div class="input-group">
                                                            <input type="text" class="transparent-input form-control form-control-sm text-end para" id="txt_odenecek_tutar_dvz" value="" placeholder="0,00" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text">TRY</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-lg-1  pl-lg-2 pl-sm-0">

                                            </div>

                                        </div>

                                        <input type="hidden" id="tvkf_durum" value="0">
                                        <input type="hidden" id="str_s" value="<?= $startZero ?>">
                                        <input type="hidden" name="" id="txt_tutar_toplam0" value="0,00">
                                        <input type="hidden" name="" id="txt_tutar_toplam0_dvz" value="0,00">
                                        <input type="hidden" name="" id="txt_tutar_toplam1" value="0,00">
                                        <input type="hidden" name="" id="txt_tutar_toplam1_dvz" value="0,00">
                                        <input type="hidden" name="" id="txt_tutar_toplam10" value="0,00">
                                        <input type="hidden" name="" id="txt_tutar_toplam10_dvz" value="0,00">
                                        <input type="hidden" name="" id="txt_tutar_toplam20" value="0,00">
                                        <input type="hidden" name="" id="txt_tutar_toplam20_dvz" value="0,00">
                                        <input type="hidden" name="" id="txt_identification_number" value="">
                                        <input type="hidden" name="" id="txt_created_invoice_id" value="">
                                        <input type="hidden" name="" id="cari_money_unit_id" value="<?= $invoice_item['money_unit_id'] ?>">

                                      

                                 

                                </div>
                                </div>
                                <button type="button" class="btn btn-success mb-2 btnEditGider" id="btnEditGider">Gideri Güncelle</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div><!-- .components-preview -->
        </div>
    </div>
</div>

<!-- TODO: Bu kısımdaki modal componente çevirilecek. -->
<button type="button" id="triggerModal" class="btn btn-success d-none" data-bs-toggle="modal" data-bs-target="#musteriOK">OK</button>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" id="musteriOK">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                    <h4 class="nk-modal-title">İşlem Başarılı!</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text">Yeni Cari Başarıyla Eklendi</div>

                        </span>
                    </div>
                    <div class="nk-modal-action">
                        <a href="#" id="cariDetail" class="btn btn-info btn-block mb-2">Bu
                            Cari Detayına Git</a>
                        <a href="#" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Cari
                            Ekle</a>
                        <a href="<?= route_to('tportal.cariler.list', 'all') ?>" class="btn btn-l btn-dim btn-outline-dark btn-block">Tüm Cariler</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'gider_basarili',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Gider Başarıyla Oluşturuldu.',
                'modal_buttons' => '<a href="" id="offerDetail" class="btn btn-primary btn-block mb-2">Gider Detayına Git</a>
                                    <a href="#" onclick="location.reload()" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Gider Oluştur</a>
                                    <a href="' . route_to('tportal.gider.list', 'all') . '" class="btn btn-l btn-dim btn-outline-dark btn-block mb-2">Gider Listesini Gör</a>'
            ],
        ],
    ]
); ?>



<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/create-invoice.js?ver=1.0.7') ?>"></script>

<?= view_cell(
    'App\Libraries\ViewComponents::getSearchTedarikCustomerModal',
    [
        'fromWhere' => 'onlyCustomers'
    ]
); ?>
<?= view_cell(
    'App\Libraries\ViewComponents::getSearchStockModal'
); ?>
<?= view_cell(
    'App\Libraries\ViewComponents::getSearchSubStockModal'
); ?>
<script>


// Sayfa yüklendiğinde mevcut dosyayı göster
document.addEventListener('DOMContentLoaded', function () {
    const filePath = document.getElementById('fis_fatura_belge_data').value;
    const previewContainer = document.getElementById('file-preview');

    if (filePath) {
        // Dosya tipini kontrol et
        const fileExtension = filePath.split('.').pop().toLowerCase(); // Dosya uzantısını al

        // Dosya uzantısına göre uygun önizlemeyi göster
        if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
            // Resim dosyası ise img etiketi ile önizleme
            const img = document.createElement('img');
            img.src = `<?= base_url(''); ?>${filePath}`; // Dosya yolunu public klasörüyle birleştir
            img.style.maxWidth = '100%';
            img.style.height = 'auto';
            previewContainer.appendChild(img);
        } else if (fileExtension === 'pdf') {
            // PDF dosyası ise link ile göster
            const link = document.createElement('a');
            link.href = `<?= base_url(''); ?>${filePath}`;
            link.target = '_blank';
            link.innerText = 'PDF Dosyasını Görüntüle';
            previewContainer.appendChild(link);
        } else if (fileExtension === 'zip') {
            // ZIP dosyası için link göster
            const link = document.createElement('a');
            link.href = `<?= base_url(''); ?>${filePath}`;
            link.target = '_blank';
            link.innerText = 'ZIP Dosyasını Görüntüle';
            previewContainer.appendChild(link);
        } else {
            previewContainer.innerHTML = '<p>Desteklenmeyen dosya formatı.</p>';
        }
    }
});



document.getElementById('fis_fatura_belge').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('file-preview');
    previewContainer.innerHTML = ''; // Önceki önizlemeyi temizle

    // Yalnızca geçerli dosya türlerine izin ver
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
    const fileType = file ? file.type : '';

    // Geçerli dosya türü değilse SweetAlert ile hata mesajı göster
    if (file && !allowedTypes.includes(fileType)) {
        Swal.fire({
            title: 'Geçersiz Dosya Formatı!',
            text: 'Sadece .pdf, .png, .jpg, .jpeg,  formatları kabul edilmektedir.',
            icon: 'error',
            confirmButtonText: 'Tamam'
        });
        // Dosyayı temizle
        event.target.value = '';
        return;
    }

    // Dosya türü geçerli ise, dosya önizlemesini göster
    if (file) {
        // Görsel dosyaları için img etiketiyle önizleme
        if (fileType.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.maxWidth = '100%';
            img.style.height = 'auto';
            previewContainer.appendChild(img);
        } 
        // PDF dosyası için link gösterimi
        else if (fileType === 'application/pdf') {
            const link = document.createElement('a');
            link.href = URL.createObjectURL(file);
            link.target = '_blank';
            link.innerText = 'PDF Dosyasını Görüntüle';
            previewContainer.appendChild(link);
        }
        // ZIP dosyası için link gösterimi
        else if (fileType === 'application/zip') {
            const link = document.createElement('a');
            link.href = URL.createObjectURL(file);
            link.target = '_blank';
            link.innerText = 'ZIP Dosyasını Görüntüle';
            previewContainer.appendChild(link);
        }
    } else {
        previewContainer.innerHTML = '<p>Dosya seçilmedi.</p>';
    }

    // Yükleme işlemini başlat
    if (file) {
        var formData = new FormData();
        formData.append('fis_fatura_belge', file);  // Dosyayı FormData'ya ekle

        $.ajax({
            url: '<?php echo  route_to("tportal.gider.gider_upload") ?>',  // Controller'daki dosya yükleme fonksiyonuna yönlendirme
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.filePath) {
                    // Dosya başarıyla yüklendiğinde, dosya yolunu input'a yazdır
                    document.getElementById('fis_fatura_belge_data').value = response.filePath;
                   
                } else {
                    Swal.fire('Hata', 'Dosya yükleme işlemi başarısız.', 'error');
                }
            },
            error: function() {
                Swal.fire('Hata', 'Dosya yükleme sırasında bir hata oluştu.', 'error');
            }
        });
    }
});



$(document).on("change", "#odendiCheckbox", function () {

$("#calisanOdediBlock").addClass("d-none")

if ($("#odendiCheckbox").is(":checked") === true)
    $("#kasaBlock").removeClass("d-none")
else
    $("#kasaBlock").addClass("d-none")

});

$(document).on("change", "#odenecekCheckbox", function () {

$("#calisanOdediBlock").addClass("d-none")

if ($("#odenecekCheckbox").is(":checked") === true)
    $("#kasaBlock").addClass("d-none")

});

var kurlar = [];

    <?php foreach($Kurlar as $kur): ?>
        kurlar.push({
            money_unit_id: <?php echo $kur["money_unit_id"]; ?>,
            money_code: '<?php echo $kur["money_code"]; ?>',
            money_value: '<?php echo $kur["money_value"]; ?>',
            usdeuro: '<?php echo $kur["usdeuro"]; ?>',
            kur_fiyat_<?php echo $kur["money_code"]; ?>:'<?php echo $kur["money_value"]; ?>',
            kur_toplam_fiyat_<?php echo $kur["money_code"]; ?>: '0,00'
        });
    <?php endforeach; ?>

$(document).ready(function() {

    $("#Ilceler").on("change", function() {
    var selectedValue = $(this).val(); // Seçilen değeri al
    $("input[name='address_district']").val(selectedValue); // Değeri input'a yaz
});


    $('#address_country').val('<?= $invoice_item['address_country'] ?>').trigger('change');

    var SecilenUlke = $("#address_country").val();
  
  var SehirDiv2 = $("#ilDegisiklik");
  var IlceDiv2 = $("#IlceDegisiklik");
  var sehir2Template = '<select id="Iller" name="address_city" class="form-select js-select2 otomatikUlke" data-ui="lg" data-placeholder="İl Seçiniz" data-search="off"> <option value="0" disabled>İl seçiniz</option></select>  <input type="hidden" class=" form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_city_name" id="address_city_name" >';
  var Ilce2Template = '<select id="Ilceler" name="address_district" class="form-select js-select2 otomatikUlke" data-ui="lg" data-placeholder="İlçe Seçiniz " data-search="off"> <option value="0" selected disabled>İlçe seçiniz </option></select>';

  var sehir2InputTemplate = '<input type="text" class="manuelUlke form-control  form-control-lg form-control-lg" placeholder="İl Giriniz"  name="address_city" id="address_city" >                     <input type="hidden" class=" form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_city_name" id="address_city_name" >';
  var Ilce2InputTemplate = '<input type="text" class="manuelUlke form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_district" id="address_district" >';

  if(SecilenUlke != "TR"){


 setTimeout(() => {
  $("#address_city").on("keyup", function() {
      $("#address_city_name").val($(this).val());
  });
 }, 500);

      $("#ilDegisiklik").html(sehir2InputTemplate);

      $("#IlceDegisiklik").html(Ilce2InputTemplate);

      $('#address_city').val('<?= $invoice_item['address_city'] ?>');

      $('#address_district').val('<?= $invoice_item['address_district'] ?>');

      $("#address_city_name").val($("#address_city").val());



  }else{

 
 
    $('#Iller').val('<?= $invoice_item['address_city_plate'] ?>');
          $('#Iller').trigger('change');

         $('#Ilceler').val('<?= $invoice_item['address_district'] ?>');
         $('#Ilceler').trigger('change');


   $("#address_city_name").val($("#Iller option:selected").text());


                        
      $("#Iller").select2();
      $("#Ilceler").select2();

      $.each(data, function( index, value ) {
      $('#Iller').append($('<option>', {
          value: value.plaka,
          text:  value.il,
      }));
      });
      $("#Iller").change(function(){
      var valueSelected = this.value;
      if($('#Iller').val() > 0) {

          $("#address_city_name").val($("#Iller option:selected").text());

          
          $('#Ilceler').html('');
          $('#Ilceler').append($('<option>', {
          value: 0,
          text:  'Lütfen Bir İlçe seçiniz '
          }));
          $('#Ilceler').prop("disabled", false);
          var resultObject = search($('#Iller').val(), data);
          $.each(resultObject.ilceleri.sort(), function( index, value ) {
          $('#Ilceler').append($('<option>', {
              value: value,
              text:  value
          }));
          });
          return false;
      }
      $('#Ilceler').prop("disabled", true);
      });

      setTimeout(() => {
        
      
      }, 100);

  }



    $("#address_country").on("change", function() {

var selectedValue = $(this).val();


var SehirDiv2 = $("#ilDegisiklik");
var IlceDiv2 = $("#IlceDegisiklik");
var sehir2Template = '<select id="Iller" name="address_city" class="form-select js-select2 add_city otomatikUlke" data-ui="lg" data-search="on" data-placeholder="İl Seçiniz"><option value="0">İl seçiniz</option>  </select> <input type="hidden" class=" form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_city_name" id="address_city_name" >';
var Ilce2Template = '<select id="Ilceler" name="address_district" class="form-select js-select2 otomatikUlke" data-ui="lg" data-placeholder="İlçe Seçiniz " data-search="off"> <option value="0" selected disabled>İlçe seçiniz </option></select>';

var sehir2InputTemplate = '<input type="text" class="manuelUlke form-control  form-control-lg form-control-lg" placeholder="İl Giriniz"  name="address_city" id="address_city">  <input type="hidden" class=" form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_city_name" id="address_city_name" >';
var Ilce2InputTemplate = '<input type="text" class="manuelUlke form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_district" id="address_district">';

if(selectedValue != "TR"){


   setTimeout(() => {
    $("#address_city").on("keyup", function() {
        $("#address_city_name").val($(this).val());
    });
   }, 500);

    $("#ilDegisiklik").html('');

    $("#IlceDegisiklik").html('');

    $("#ilDegisiklik").append(sehir2InputTemplate);

    $("#IlceDegisiklik").append(Ilce2InputTemplate);



}else{


    setTimeout(() => {
        $("#ddress_city_name").val($("#Iller option:selected").text());

   }, 500);





   
    $("#ilDegisiklik").html('');

    $("#IlceDegisiklik").html('');

    $("#ilDegisiklik").html(sehir2Template);

    $("#IlceDegisiklik").html(Ilce2Template);





    $.each(data, function( index, value ) {
    $('#Iller').append($('<option>', {
        value: value.plaka,
        text:  value.il,
    }));
    });
    $("#Iller").change(function(){
    var valueSelected = this.value;
    if($('#Iller').val() > 0) {

        $("#address_city_name").val($("#Iller option:selected").text());

        $('#Ilceler').html('');
        $('#Ilceler').append($('<option>', {
        value: 0,
        text:  'Lütfen Bir İlçe seçiniz '
        }));
        $('#Ilceler').prop("disabled", false);
        var resultObject = search($('#Iller').val(), data);
        $.each(resultObject.ilceleri.sort(), function( index, value ) {
        $('#Ilceler').append($('<option>', {
            value: value,
            text:  value
        }));
        });
        return false;
    }
    $('#Ilceler').prop("disabled", true);
    });

        setTimeout(() => {
            
            $("#Iller").select2();
$("#Ilceler").select2();


        }, 100);



}


});


    });






    $("#cari_phone").mask("(000) 000 0000");
    $('#starting_balance').mask('000.000.000.000.000,00', {
        reverse: true
    });

    let has_collection = 0;

    $("#chx_sorgulama").attr("checked", true);
    //sorgulamadan devam et
    $('#chx_sorgulama').change(function() {
        if ($("#chx_sorgulama").is(":checked")) {
            $('#obligation').removeAttr('disabled');
            $('#fatura_senaryo').removeAttr('disabled');

        } else {
            $('#obligation').removeAttr('disabled');
        }
    });

    //irsaliye
    $('#is_waybill').change(function() {
        if ($("#is_waybill").is(":checked")) {
            $('#is_waybill_area').removeClass('d-none');
        } else {
            $('#is_waybill_area').addClass('d-none');
        }
    });

    //vade
    $('#is_maturity').change(function() {
        if ($("#is_maturity").is(":checked")) {
            $('#is_maturity_area').removeClass('d-none');
        } else {
            $('#is_maturity_area').addClass('d-none');
        }
    });

    //vade
    $('#money_unit_id').change(function() {
        var d = $('#money_unit_id').val();
        console.log(d);
        if (d == 3) {
            $('#currency_exchange_value').attr('disabled', 'disabled');
        } else {
            $('#currency_exchange_value').removeAttr('disabled');

        }
    });

    $(document).on("click", ".rd_cari", function () {

        selectedCariId = $('.rd_cari:checked').val();
        // console.log(selectedCariId);

        if (selectedCariId <= 0) {
            swetAlert("Hatalı İşlem", "Lütfen cari seçiniz", "err");
        } else {

            Swal.fire({
                title: 'Sorgulama yapılıyor, lütfen bekleyiniz...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                },
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.cariler.getCariById') ?>',
                dataType: 'json',
                data: {
                    cariId: selectedCariId,
                },
                async: true,
                success: function(response) {
                    $('#mdl_musteriSec').modal('hide');

                    if (response['icon'] == 'success') {
                        swal.close();
                        console.log(response);
                       // $('#customer_info_area').removeClass('d-none');

                        $('#company_type').attr('disabled', 'disabled');
                        $('#obligation').attr('disabled', 'disabled');

                        $('#is_customer_save').removeAttr('checked');
                        $('#is_customer_save').removeAttr('disabled');

                        fullData = response.cari_item;

                        console.log(fullData);


                        if (fullData.cari_phone != null) {
                            phoneBase = fullData.cari_phone.split(" ");

                            areaCode = phoneBase[0];
                            phone = phoneBase[1];

                            $("#cari_phone").val(phone).unmask().mask("(000) 000 0000");
                            $('#area_code').val(areaCode);
                            $('#area_code').trigger('change');

                        }


                        $('#identification_number').val(fullData.identification_number);
                        $('#obligation').val(fullData.obligation);
                        $('#obligation').trigger('change');

                        $('#company_type').val(fullData.company_type);
                        $('#company_type').trigger('change');

                        if (fullData.invoice_title == '') {
                            $('#invoice_title').val(fullData.name + " " + fullData.surname);
                        } else {
                            $('#invoice_title').val(fullData.invoice_title);
                        }

                        $('#name').val(fullData.name);
                        $('#surname').val(fullData.surname);
                        $('#tax_administration').val(fullData.tax_administration);
                        $('#address').val(fullData.address);

                      
                        $('#address_country').val(fullData.address_country).trigger('change');

  
  var SehirDiv2 = $("#ilDegisiklik");
  var IlceDiv2 = $("#IlceDegisiklik");
  var sehir2Template = '<select id="Iller" name="address_city" class="form-select js-select2 otomatikUlke" data-ui="lg" data-placeholder="İl Seçiniz" data-search="off"> <option value="0" disabled>İl seçiniz</option></select>  <input type="hidden" class=" form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_city_name" id="address_city_name" >';
  var Ilce2Template = '<select id="Ilceler" name="address_district" class="form-select js-select2 otomatikUlke" data-ui="lg" data-placeholder="İlçe Seçiniz " data-search="off"> <option value="0" selected disabled>İlçe seçiniz </option></select>';

  var sehir2InputTemplate = '<input type="text" class="manuelUlke form-control  form-control-lg form-control-lg" placeholder="İl Giriniz"  name="address_city" id="address_city" >                     <input type="hidden" class=" form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_city_name" id="address_city_name" >';
  var Ilce2InputTemplate = '<input type="text" class="manuelUlke form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_district" id="address_district" >';

  if(fullData.address_country != "TR"){


 setTimeout(() => {
  $("#address_city").on("keyup", function() {
      $("#address_city_name").val($(this).val());
  });
 }, 500);

      $("#ilDegisiklik").html(sehir2InputTemplate);

      $("#IlceDegisiklik").html(Ilce2InputTemplate);

      $('#address_city').val(fullData.address_city);

      $('#address_district').val(fullData.address_district);

      $("#address_city_name").val($("#address_city").val());



  }else{

      $("#ilDegisiklik").html(sehir2Template);

      $("#IlceDegisiklik").html(Ilce2Template);




   $("#address_city_name").val($("#Iller option:selected").text());


                        
      $("#Iller").select2();
      $("#Ilceler").select2();

      $.each(data, function( index, value ) {
      $('#Iller').append($('<option>', {
          value: value.plaka,
          text:  value.il,
      }));
      });
      $("#Iller").change(function(){
      var valueSelected = this.value;
      if($('#Iller').val() > 0) {

          $("#address_city_name").val($("#Iller option:selected").text());

          
          $('#Ilceler').html('');
          $('#Ilceler').append($('<option>', {
          value: 0,
          text:  'Lütfen Bir İlçe seçiniz '
          }));
          $('#Ilceler').prop("disabled", false);
          var resultObject = search($('#Iller').val(), data);
          $.each(resultObject.ilceleri.sort(), function( index, value ) {
          $('#Ilceler').append($('<option>', {
              value: value,
              text:  value
          }));
          });
          return false;
      }
      $('#Ilceler').prop("disabled", true);
      });

      setTimeout(() => {
          $('#Iller').val(fullData.address_city_plate);
      $('#Iller').trigger('change');

      $('#Ilceler').val(fullData.address_district);
      $('#Ilceler').trigger('change');
      }, 10);

  }

                        $('#address_city_name').val(fullData.address_city)
                        $('#cari_id').val(fullData.cari_id)

                        $('#zip_code').val(fullData.zip_code);
                        $('#cari_email').val(fullData.cari_email);


                        $('#money_unit_id').val(fullData.money_unit_id);
                        $('#money_unit_id').trigger('change');
                        $('#currency_exchange_value').val(fullData.money_value);

                        if (fullData.obligation == 'e-archive') {
                            $('#fatura_senaryo').val('EARSIVFATURA');
                            $('#fatura_senaryo').trigger('change');
                            $('#fatura_senaryo').attr('disabled', 'disabled');


                            $("#fatura_seri option[invoice-serial-type='e-invoice']").attr("disabled", true);
                            $("#fatura_seri option[invoice-serial-type='e-archive']").attr("disabled", false);


                            $("#fatura_senaryo option[value=EARSIVFATURA]").removeAttr('disabled');

                            $("#fatura_senaryo option[value=TEMELFATURA]").attr('disabled', 'disabled');
                            $("#fatura_senaryo option[value=TICARIFATURA]").attr('disabled', 'disabled');
                            $("#fatura_senaryo option[value=KAMU]").attr('disabled', 'disabled');
                            $("#fatura_senaryo option[value=IHRACAT]").attr('disabled', 'disabled');
                        } else {
                            $('#fatura_senaryo').val('TEMELFATURA');
                            $('#fatura_senaryo').trigger('change');
                            $('#fatura_senaryo').removeAttr('disabled');

                            $("#fatura_seri option[invoice-serial-type='e-invoice']").attr("disabled", false);
                            $("#fatura_seri option[invoice-serial-type='e-archive']").attr("disabled", true);

                            $("#fatura_senaryo option[value=EARSIVFATURA]").attr('disabled', 'disabled');

                            $("#fatura_senaryo option[value=TEMELFATURA]").removeAttr('disabled');
                            $("#fatura_senaryo option[value=TICARIFATURA]").removeAttr('disabled');
                            $("#fatura_senaryo option[value=KAMU]").removeAttr('disabled');
                            $("#fatura_senaryo option[value=IHRACAT]").removeAttr('disabled');
                        }


                    } else {
                        swal.close();
                        swetAlert("Hatalı İşlem", response['message'], "err");
                    }
                }
            })
        }

    });

    $("#area_code").change(function() {
        var selectedVal = $(this).val();
        $("#lastAreaCode").text(selectedVal);
    });


    $(".add_city").change(function() {
        // var selectedVal = $(this).text();
        var selectedVal = $(this).find(":selected").text();
        $("#address_city_name").val(selectedVal);
    });

    var $cariTip = 0;
    $('.custom-control-input').change(function() {
        if ($('.custom-control-input:checked').length > 0) {
            $cariTip = 1;
        } else {
            $cariTip = 0;
        }
    });


    $('#btn_musteriSorgulaNew').click(function() {
        var vknTc = $('#identification_number').val();

        if (vknTc.length >= 10) {

            Swal.fire({
                title: 'Sorgulama yapılıyor, lütfen bekleyiniz...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                },
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.cariler.checkCustomerVknInfo') ?>',
                data: {
                    vknTc: vknTc
                },
                success: function(data) {
                    swal.close();

                    var datas = JSON.parse(data);
                    console.log(datas);

                    if (datas.response.unvan == '' && datas.response.adi == '' && datas.response.soyadi == '') {

                        Swal.fire({
                            title: "Uyarı!",
                            html: 'Girilen VKN/TC ile eşleşen bir kayıt bulunamadı. <br> VKN/TC doğruluğunu kontrol edip tekrar deneyiniz.',
                            icon: "warning",
                            confirmButtonText: 'Tamam',
                        });

                    } else {
                       // $('#customer_info_area').removeClass('d-none');

                        $('#company_type').attr('disabled', 'disabled');
                        $('#obligation').attr('disabled', 'disabled');

                        //cari ilk dbye bakılıyor
                        if (datas.icon == 'kayitli') {
                            $('#createInvoice')[0].reset();
                            fullData = datas.response;

                            // phoneBase = fullData.cari_phone.split(" ");

                            // areaCode = phoneBase[0];
                            // phone = phoneBase[1];


                            if (fullData.cari_phone != '') {
                                phoneBase = fullData.cari_phone.split(" ");

                                areaCode = phoneBase[0];
                                phone = phoneBase[1];

                                $("#cari_phone").val(phone).unmask().mask("(000) 000 0000");
                                $('#area_code').val(areaCode);
                                $('#area_code').trigger('change');

                            }

                            $('#identification_number').val(fullData.identification_number);
                            $('#obligation').val(fullData.obligation);
                            $('#obligation').trigger('change');

                            $('#company_type').val(fullData.company_type);
                            $('#company_type').trigger('change');

                            if (fullData.invoice_title == '') {
                                $('#invoice_title').val(fullData.name + " " + fullData.surname);
                            } else {
                                $('#invoice_title').val(fullData.invoice_title);
                            }

                            $('#name').val(fullData.name);
                            $('#surname').val(fullData.surname);
                            $('#tax_administration').val(fullData.tax_administration);
                            $('#address').val(fullData.address);


                            var SecilenUlke = $("#address_country").val();
  
  var SehirDiv2 = $("#ilDegisiklik");
  var IlceDiv2 = $("#IlceDegisiklik");
  var sehir2Template = '<select id="Iller" name="address_city" class="form-select js-select2 otomatikUlke" data-ui="lg" data-placeholder="İl Seçiniz" data-search="off"> <option value="0" disabled>İl seçiniz</option></select>  <input type="hidden" class=" form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_city_name" id="address_city_name" >';
  var Ilce2Template = '<select id="Ilceler" name="address_district" class="form-select js-select2 otomatikUlke" data-ui="lg" data-placeholder="İlçe Seçiniz" data-search="off"> <option value="0" selected disabled>İlçe seçiniz </option></select>';

  var sehir2InputTemplate = '<input type="text" class="manuelUlke form-control  form-control-lg form-control-lg" placeholder="İl Giriniz"  name="address_city" id="address_city" >                     <input type="hidden" class=" form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_city_name" id="address_city_name" >';
  var Ilce2InputTemplate = '<input type="text" class="manuelUlke form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_district" id="address_district" >';

  if(SecilenUlke != "TR"){


 setTimeout(() => {
  $("#address_city").on("keyup", function() {
      $("#address_city_name").val($(this).val());
  });
 }, 500);

      $("#ilDegisiklik").html(sehir2InputTemplate);

      $("#IlceDegisiklik").html(Ilce2InputTemplate);

      $('#address_city').val(fullData.address_city);

      $('#address_district').val(fullData.address_district);

      $("#address_city_name").val($("#address_city").val());



  }else{

      $("#ilDegisiklik").html(sehir2Template);

      $("#IlceDegisiklik").html(Ilce2Template);




   $("#address_city_name").val($("#Iller option:selected").text());


                        
      $("#Iller").select2();
      $("#Ilceler").select2();

      $.each(data, function( index, value ) {
      $('#Iller').append($('<option>', {
          value: value.plaka,
          text:  value.il,
      }));
      });
      $("#Iller").change(function(){
      var valueSelected = this.value;
      if($('#Iller').val() > 0) {

          $("#address_city_name").val($("#Iller option:selected").text());

          
          $('#Ilceler').html('');
          $('#Ilceler').append($('<option>', {
          value: 0,
          text:  'Lütfen Bir İlçe seçiniz '
          }));
          $('#Ilceler').prop("disabled", false);
          var resultObject = search($('#Iller').val(), data);
          $.each(resultObject.ilceleri.sort(), function( index, value ) {
          $('#Ilceler').append($('<option>', {
              value: value,
              text:  value
          }));
          });
          return false;
      }
      $('#Ilceler').prop("disabled", true);
      });

      setTimeout(() => {
          $('#Iller').val(fullData.address_city_plate);
      $('#Iller').trigger('change');

      $('#Ilceler').val(fullData.address_district);
      $('#Ilceler').trigger('change');
      }, 10);

  }




                  

                            $('#address_city_name').val(fullData.address_city)
                            $('#cari_id').val(fullData.cari_id)

                            $('#zip_code').val(fullData.zip_code);
                            $('#cari_email').val(fullData.cari_email);


                            $('#money_unit_id').val(fullData.money_unit_id);
                            $('#money_unit_id').trigger('change');
                            $('#currency_exchange_value').val(fullData.money_value);

                            $('#is_customer_save').removeAttr('checked');
                            $('#is_customer_save').removeAttr('disabled');

                            if (fullData.obligation == 'e-archive') {
                                $('#fatura_senaryo').val('EARSIVFATURA');
                                $('#fatura_senaryo').trigger('change');
                                $('#fatura_senaryo').attr('disabled', 'disabled');

                                $("#fatura_seri option[invoice-serial-type='e-invoice']").attr("disabled", true);
                                $("#fatura_seri option[invoice-serial-type='e-archive']").attr("disabled", false);

                                $("#fatura_senaryo option[value=EARSIVFATURA]").removeAttr('disabled');

                                $("#fatura_senaryo option[value=TEMELFATURA]").attr('disabled', 'disabled');
                                $("#fatura_senaryo option[value=TICARIFATURA]").attr('disabled', 'disabled');
                                $("#fatura_senaryo option[value=KAMU]").attr('disabled', 'disabled');
                                $("#fatura_senaryo option[value=IHRACAT]").attr('disabled', 'disabled');
                            } else {
                                $("#fatura_senaryo option[value=EARSIVFATURA]").attr('disabled', 'disabled');

                                $("#fatura_seri option[invoice-serial-type='e-invoice']").attr("disabled", false);
                                $("#fatura_seri option[invoice-serial-type='e-archive']").attr("disabled", true);

                                $("#fatura_senaryo option[value=TEMELFATURA]").removeAttr('disabled');
                                $("#fatura_senaryo option[value=TICARIFATURA]").removeAttr('disabled');
                                $("#fatura_senaryo option[value=KAMU]").removeAttr('disabled');
                                $("#fatura_senaryo option[value=IHRACAT]").removeAttr('disabled');
                            }
                        } else {
                            var temp = $('#identification_number').val();
                            $('#txt_identification_number').val(temp);

                            $('#createInvoice')[0].reset();
                            $('#Iller').trigger('change');
                            $('#Ilceler').trigger('change');

                            $('#identification_number').val(temp);

                            $('#is_customer_save').attr('checked', 'checked');
                            $('#is_customer_save').attr('disabled', 'disabled');


                            $('#invoice_title').val(datas.response.unvan);
                            $('#name').val(datas.response.adi);
                            $('#surname').val(datas.response.soyadi);
                            $('#tax_administration').val(datas.response.vergi_dairesi);
                            // $('#identification_number').val(datas.vkn);
                            // console.log("bilgileri doldurmaya başla2");

                            if (datas.response.adres != 0) {
                                $('#address').val(datas.response.adres);
                            }
                            if (datas.response.unvan != "") {
                                $('#namesurname').removeClass('d-none');
                                $('#invoice_title').val(datas.response.adi + " " + datas.response.soyadi);

                                $('#company_type').val('person');
                                $('#company_type').trigger('change');
                            } else {
                                $('#namesurname').addClass('d-none');

                                $('#company_type').val('company');
                                $('#company_type').trigger('change');
                            }


                            if (datas.response.vknInfo == 0) {
                                $('#obligation').val('e-archive');
                                $('#obligation').trigger('change');

                                $('#fatura_senaryo').val('EARSIVFATURA');
                                $('#fatura_senaryo').trigger('change');

                                $("#fatura_seri option[invoice-serial-type='e-invoice']").attr("disabled", true);
                                $("#fatura_seri option[invoice-serial-type='e-archive']").attr("disabled", false);

                                $("#fatura_senaryo option[value=TEMELFATURA]").attr('disabled', 'disabled');
                                $("#fatura_senaryo option[value=TICARIFATURA]").attr('disabled', 'disabled');
                                $("#fatura_senaryo option[value=KAMU]").attr('disabled', 'disabled');
                                $("#fatura_senaryo option[value=IHRACAT]").attr('disabled', 'disabled');

                            } else {
                                $('#obligation').val('e-invoice');
                                $('#obligation').trigger('change');

                                $('#fatura_senaryo').val('TEMELFATURA');
                                $('#fatura_senaryo').trigger('change');

                                $("#fatura_seri option[invoice-serial-type='e-invoice']").attr("disabled", false);
                                $("#fatura_seri option[invoice-serial-type='e-archive']").attr("disabled", true);

                                $("#fatura_senaryo option[value=TEMELFATURA]").removeAttr('disabled');
                                $("#fatura_senaryo option[value=TICARIFATURA]").removeAttr('disabled');
                                $("#fatura_senaryo option[value=KAMU]").removeAttr('disabled');
                                $("#fatura_senaryo option[value=IHRACAT]").removeAttr('disabled');
                            }
                        }
                    }


                },
                error: function(error) {
                    swal.close();
                    console.log("err: " + error);
                }
            })
        }
    });




    $(document).ready(function() {


        $('.btnNext').click(function() {

            // if ($('#identification_number').val() == '') {
            //     swetAlert("Eksik Bir Şeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
            // } else {
            const nextTabLinkEl = $('.nav-tabs .active').closest('li').next('li').find('a')[0];
            const nextTab = new bootstrap.Tab(nextTabLinkEl);
            nextTab.show();
            // }

        });

        $('.btnPrevious').click(function() {
            const prevTabLinkEl = $('.nav-tabs .active').closest('li').prev('li').find('a')[0];
            const prevTab = new bootstrap.Tab(prevTabLinkEl);
            prevTab.show();
        });



        $('.dvz_str').hide();

        var faturaTipi = $('#fatura_tipi').val();



        $('#txt_miktar_0').keyup(function(e) {
            e.preventDefault();
            var dInput = this.value;
            if (dInput.length == 11) {
                $('#btn_musteriSorgulaNew').removeAttr("disabled");
            } else if (dInput.length == 10) {
                $('#btn_musteriSorgulaNew').removeAttr("disabled");
            } else {
                $('#btn_musteriSorgulaNew').attr("disabled", "");
            }
        });



        $('#is_export_customer').change(function() {
            if ($(this).is(':checked')) {
                $('#identification_number').val('22222222222');
                $('#btn_musteriSorgula').attr('disabled', true);
               // $('#customer_info_area').removeClass('d-none');

                $("#fatura_senaryo option[value=IHRACAT]").removeAttr('disabled');
                $('#fatura_senaryo').val('IHRACAT');
                $('#fatura_senaryo').trigger('change');

                $("#fatura_senaryo option[value=EARSIVFATURA]").attr('disabled', 'disabled');
                $("#fatura_senaryo option[value=TEMELFATURA]").attr('disabled', 'disabled');
                $("#fatura_senaryo option[value=TICARIFATURA]").attr('disabled', 'disabled');
                $("#fatura_senaryo option[value=KAMU]").attr('disabled', 'disabled');


                $("#fatura_tipi option[value=ISTISNA]").removeAttr('disabled');
                $('#fatura_tipi').val('ISTISNA');
                $('#fatura_tipi').trigger('change');

                $("#fatura_tipi option[value=SATIS]").attr('disabled', 'disabled');
                $("#fatura_tipi option[value=IADE]").attr('disabled', 'disabled');
                $("#fatura_tipi option[value=ISTISNA]").attr('disabled', 'disabled');
                $("#fatura_tipi option[value=IADEISTISNA]").attr('disabled', 'disabled');
                $("#fatura_tipi option[value=OZELMATRAH]").attr('disabled', 'disabled');
                $("#fatura_tipi option[value=IHRACKAYITLI]").attr('disabled', 'disabled');

            } else {
               // $('#customer_info_area').addClass('d-none');
                $('#identification_number').val('');
                $('#identification_number').attr('disabled', false);
                $('#btn_musteriSorgula').attr('disabled', true);

                $("#fatura_senaryo option[value=IHRACAT]").removeAttr('disabled');

                $("#fatura_senaryo option[value=EARSIVFATURA]").removeAttr('disabled');
                $("#fatura_senaryo option[value=TEMELFATURA]").removeAttr('disabled');
                $("#fatura_senaryo option[value=TICARIFATURA]").removeAttr('disabled');
                $("#fatura_senaryo option[value=KAMU]").removeAttr('disabled');

                $('#fatura_senaryo').val('TEMELFATURA');
                $('#fatura_senaryo').trigger('change');


                $("#fatura_tipi option[value=ISTISNA]").removeAttr('disabled');
                $('#fatura_tipi').val('SATIS');
                $('#fatura_tipi').trigger('change');

                $("#fatura_tipi option[value=SATIS]").removeAttr('disabled');
                $("#fatura_tipi option[value=IADE]").removeAttr('disabled');
                $("#fatura_tipi option[value=ISTISNA]").removeAttr('disabled');
                $("#fatura_tipi option[value=IADEISTISNA]").removeAttr('disabled');
                $("#fatura_tipi option[value=OZELMATRAH]").removeAttr('disabled');
                $("#fatura_tipi option[value=IHRACKAYITLI]").removeAttr('disabled');

            }
        });

        $('#company_type').change(function() {
            var c_type = $('#company_type').val();

            if (c_type == 'person') {
                $('#namesurname').removeClass('d-none');
            } else {
                $('#namesurname').addClass('d-none');

            }
        });

        $(document).on("click", "#ftr_satis", function() {
            $('#fatura_seri_alanı').removeClass('d-none');
            $('#irsaliye_alani').removeClass('d-none');
        });
        $(document).on("click", "#ftr_alis", function() {
            $('#fatura_seri_alanı').removeClass('d-none');
            $('#irsaliye_alani').addClass('d-none');
        });

        $(document).on("change", "#fatura_senaryo", function() {
            var selected_fatura_senaryo = $('#fatura_senaryo').val();
        });

    });
</script>

<?= $this->endSection() ?>