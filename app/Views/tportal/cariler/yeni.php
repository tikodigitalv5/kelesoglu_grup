<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Yeni Cari <?= $this->endSection() ?>
<?= $this->section('title') ?> Yeni Cari | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content  d-xl-none">
                        <h3 class="nk-block-title page-title">Yeni Cari</h3>

                    </div>
                    <div class="nk-block-head-content">

                    </div>
                </div>
            </div>
            <div class="nk-block">
                <div class="row">
                    <div class="col-md-8 col-lg-8">
                        <div class="card card-stretch">
                            <div class="card-inner-group">
                                <form onsubmit="return false;" id="createCari" method="post" autocomplete="off">
                                    <div class="card-inner position-relative card-tools-toggle">
                                        <div class="gy-2">
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="site-name">Cari Tipi</label><span class="form-note d-none d-md-block">Carinin ait olduğu
                                                            tipi.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <ul class="custom-control-group">
                                                        <li>
                                                            <div class="custom-control custom-checkbox custom-control-pro">
                                                                <input type="checkbox" class="custom-control-input" name="is_customer" id="is_customer" checked>
                                                                <label class="custom-control-label" for="is_customer">
                                                                    <em class="icon ni ni-user"></em>
                                                                    <span>Müşteri</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-checkbox custom-control-pro">
                                                                <input type="checkbox" class="custom-control-input" name="is_supplier" id="is_supplier">
                                                                <label class="custom-control-label" for="is_supplier">
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
                                                    <div class="form-group"><label class="form-label" for="is_export_customer">İhracat Müşterisi</label><span class="form-note d-none d-md-block">Eğer bu müşteri ihracat
                                                            müşteriniz ise işaretleyiniz..</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <ul class="custom-control-group">
                                                        <li>
                                                            <div class="custom-control custom-checkbox custom-control-pro">
                                                                <input type="checkbox" class="custom-control-input" name="is_export_customer" id="is_export_customer">
                                                                <label class="custom-control-label" for="is_export_customer">
                                                                    Evet
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="identification_number">VKN/TC Numarası</label><span class="form-note d-none d-md-block">Bu bilgiyi doğru girip
                                                            sorgularsanız ünvan ve vergi dairesi gibi bilgiler otomatik
                                                            gelecektir.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-lg" id="identification_number" name="identification_number" placeholder="VKN/TC Numarası Giriniz" maxlength="11" value="">
                                                        <div class="input-group-append">
                                                            <button id="btn_musteriSorgulaNew" class="btn btn-lg btn-block btn-dim btn-outline-light" disabled>Sorgula</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="obligation">Mükellefiyet</label><span class="form-note d-none d-md-block">Carinin mükellefiyet
                                                            durumu.</span></div>
                                                </div>
                                                <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                    <div class="col-lg-6 col-xxl-6 col-6 mt-0 mt-md-2 pe-1">
                                                        <div class="form-group">
                                                            <select class="form-select js-select2" id="obligation" name="obligation" data-ui="lg" data-search="on" data-placeholder="Mükellefiyet Seçiniz">
                                                                <option></option>
                                                                <option value="e-archive" selected>E-Arşiv Fatura</option>
                                                                <option value="e-invoice">E-Fatura</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-6 col-6 mt-0 mt-md-2 ps-1">
                                                        <div class="form-group">
                                                            <select id="company_type" name="company_type" class="form-select js-select2" data-ui="lg" data-placeholder="Şirket Tipi Seçiniz" data-search="on">
                                                                <option></option>
                                                                <option value="person">Şahıs</option>
                                                                <option value="company" selected>Şirket</option>
                                                                <option value="public">Kamu</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center" id="fatura_unvani_area">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="invoice_title">Fatura
                                                            Ünvanı</label><span class="form-note d-none d-md-block">Fatura kesilecek resmi
                                                            ünvan.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" name="invoice_title" id="invoice_title" value="" placeholder="Fatura Ünvanı"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center" id="namesurname">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="">Adı Soyadı</label>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-lg" id="name" name="name" value="" placeholder="Adı">
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-lg" id="surname" name="surname" value="" placeholder="Soyadı">
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="tax_administration">Vergi Dairesi</label><span class="form-note d-none d-md-block">Fatura kesilecek resmi
                                                            vergi dairesi.</span></div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" name="tax_administration" id="tax_administration" value="" placeholder="Vergi Dairesi"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="address">Fatura Adresi</label><span class="form-note d-none d-md-block">Fatura kesilecek resmi
                                                            fatura adresi.</span></div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-lg" name="address" id="address" cols="30" rows="5" placeholder="Fatura Adresi"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="address_country">Ülke</label><span class="form-note d-none d-md-block">Fatura adresinin bulunduğu ülke</span></div>
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
                                                    <div class="form-group"><label class="form-label" for="address_city">İl
                                                            / İlçe</label><span class="form-note d-none d-md-block">Fatura adresinin bulunduğu il ve ilçe bilgisi</span></div>
                                                </div>
                                                <div class="col-lg-3 col-xxl-3 col-6 mt-0 mt-md-2">
                                                    <div class="form-control-wrap" id="ilDegisiklik">
                                                        <select id="Iller" name="address_city" class="form-select js-select2" data-ui="lg" data-search="on" data-placeholder="İl Seçiniz">
                                                            <option value="0">İl seçiniz</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-xxl-4 col-6 mt-0 mt-md-2">
                                                    <div class="form-group" id="IlceDegisiklik">
                                                        <select id="Ilceler" name="address_district" class="form-select js-select2" data-ui="lg" data-search="on" data-placeholder="İlçe Seçiniz" disabled="disabled">
                                                            <option value="0">Önce il seçiniz</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="zip_code">Posta Kodu</label><span class="form-note d-none d-md-block">Fatura adresinin posta
                                                            kodu.</span></div>
                                                </div>
                                                <div class="col-lg-3 col-xxl-3 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-lg" id="zip_code" name="zip_code" value="" placeholder="Posta Kodu">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="cari_email">E-posta</label><span class="form-note d-none d-md-block">Carinin faturalarının
                                                            gönderileceği e-posta adresi.</span></div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" id="cari_email" value="" placeholder="Cari e-posta" name="cari_email"></div>
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
                                                                    <select id="area_code" name="area_code" class="form-select js-select2" data-ui="lg" data-search="on" data-placeholder="Seçiniz"> <!--  -->
                                                                        <option id="selecteditem" value="">+90</option>
                                                                        <option value="+90" selected>🇹🇷 (+90) Türkiye</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <input type="text" class="form-control form-control-lg" name="cari_phone" id="cari_phone" aria-label="Carinin iletişim için telefon numarası" placeholder="000 000 0000" onkeypress="return SadeceRakam(event,['-'],'');">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="money_unit_id">Para Birimi</label><span class="form-note d-none d-md-block">Cari ile çalışmak
                                                            istediğiniz para birimi.</span></div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <select id="money_unit_id" name="money_unit_id" class="form-select js-select2" data-ui="lg" data-search="on" data-val="TRY">
                                                            <?php foreach ($money_unit_items as $money_unit_item) { ?>
                                                                <option value="<?= $money_unit_item['money_unit_id'] ?>" <?php if ($money_unit_item['default'] == 'true') {
                                                                                                                                echo "selected";
                                                                                                                            } ?>>
                                                                    <?= $money_unit_item['money_code'] ?> -
                                                                    <?= $money_unit_item['money_title'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center d-none">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="starting_balance">Açılış Bakiyesi
                                                            /
                                                            Tarihi</label>
                                                        <span class="form-note d-none d-md-block">Cari için açılış
                                                            bakiyesi belirleyebilirsiniz.<br>Alacaklı ise tutarı başına
                                                            (-) eksi ile giriniz.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xxl-4 col-8 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-lg text-end" id="starting_balance" name="starting_balance" value="" onkeypress="return SadeceRakam(event,[',','-']);" placeholder="0,00">
                                                        <small>Kuruş bilgisini , ile belirleyebilirsiniz.</small>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-xxl-3 col-4 mt-0 mt-md-2">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left">
                                                            <em class="icon ni ni-calendar icon-lg"></em>
                                                        </div>
                                                        <input id="starting_balance_date" name="starting_balance_date" type="text" class="form-control form-control-lg date-picker" data-date-format="dd/mm/yyyy" value="<?= date('d/m/Y') ?>">
                                                        <small>&nbsp;</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="cari_note">Cari Notu</label><span class="form-note d-none d-md-block">Bu cari için eklemek istediğiniz bir not varsa yazınız.</span></div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-lg" name="cari_note" id="cari_note" rows="1" placeholder="Cari Notu"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <a href="javascript:history.back()" class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Geri</span></a>
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <div class="form-group">
                                                    <button type="submit" id="yeniCari" class="btn btn-lg btn-primary">Kaydet</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                    <input type="hidden" name="" id="txt_identification_number" value="">

                                </form>
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div>
                </div>
            </div><!-- .nk-block -->
        </div>
    </div>
</div>


<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'create_cari',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Cari başarıyla eklendi',
                'modal_buttons' => '<a href="" id="cariDetail" class="btn btn-primary btn-block mb-2">Bu Carnin Detayına Git</a>
                                    <a href="' . route_to('tportal.cariler.create') . '" class="btn btn-success btn-block mb-2">Yeni Cari Ekle</a>
                                    <a href="' . route_to('tportal.cariler.list', 'all') . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Tüm Carileri Göster</a>'
            ],
        ],
    ]
); ?>



<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
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

    $("#cari_phone").mask("(000) 000 0000");
    // $('#starting_balance').mask('000.000.000.000.000,00', {
    //     reverse: true
    // });

    $("#area_code").change(function() {
        var selectedVal = $(this).val();
        $("#lastAreaCode").text(selectedVal);
    });

    var $cariTip = 0;
    $('.custom-control-input').change(function() {
        if ($('.custom-control-input:checked').length > 0) $cariTip = 1;
        else $cariTip = 0;
    });

    $('#yeniCari').click(function(e) {
        e.preventDefault();

        enableDisabledInputs();

        var formData = $('#createCari').serializeArray();
        console.log(formData);
        if (($('#invoice_title').val() == '') && ($('#name').val() == '' || $('#surname').val() == '') || ($('#area_code').val() == '' || $('#cari_phone').val() == '' || $('#address').val() == '')) {
            Swal.fire({
                title: "Uyarı!",
                html: 'Lütfen aşağıdaki alanları doldurunuz. <br><br> <ul><li>Fatura Ünvanı veya Adı Soyadı</li> <li>Fatura Adres Bilgisi</li> <li>Telefon Bilgisi</li> </ul>',
                icon: "warning",
                confirmButtonText: 'Tamam',
            });
        } else {

            if ($('#company_type').val() == 'person') {
                var name = $('#name').val();
                var surname = $('#surname').val();

                $('#invoice_title').val(name + " " + surname);
            }

            var formData = $('#createCari').serializeArray();
            formData.push({
                name: 'identification_number',
                value: $('#identification_number').val()
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
                        $('#cariDetail').attr('href', '<?= route_to('tportal.cariler.detail.null') ?>/' + response['new_cari_id'])
                        $('#createCari')[0].reset();

                        $("#trigger_create_cari_ok_button").click();

                    } else {
                        swetAlert("Bir Şeyler Ters Gitti", response["message"], "err");
                    }
                }
            })
        }
    });

    $('#identification_number').keyup(function(e) {
        e.preventDefault();
        var dInput = this.value;
        if (dInput.length == 11) $('#btn_musteriSorgulaNew').removeAttr("disabled");
        else if (dInput.length == 10) $('#btn_musteriSorgulaNew').removeAttr("disabled");
        else $('#btn_musteriSorgulaNew').attr("disabled", "");
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
                        $('#customer_info_area').removeClass('d-none');

                        $('#obligation').attr('disabled', 'disabled');
                        $('#company_type').attr('disabled', 'disabled');

                        //cari ilk dbye bakılıyor
                        if (datas.icon == 'kayitli') {
                            $('#createCari')[0].reset();

                           // $('#yeniCari').attr('disabled','disabled');
                           // $('#yeniCari').text('Bu cari sistemde kayıtlı');

                            fullData = datas.response;

                            phoneBase = fullData.cari_phone.split(" ");

                            areaCode = phoneBase[0];
                            phone = phoneBase[1];

                            $('#identification_number').val(fullData.identification_number);

                            $('#company_type').val(fullData.company_type);
                            $('#company_type').trigger('change');


                            if (fullData.is_customer == 1) $('#is_customer').attr('checked', 'checked');
                            else $('#is_customer').removeAttr('checked');

                            if (fullData.is_supplier == 1) $('#is_supplier').attr('checked', 'checked');
                            else $('#is_supplier').removeAttr('checked');

                            if (fullData.is_export_customer == 1) $('#is_export_customer').attr('checked', 'checked');
                            else $('#is_export_customer').removeAttr('checked');

                            if (fullData.invoice_title == '') $('#invoice_title').val(fullData.name + " " + fullData.surname);
                            else $('#invoice_title').val(fullData.invoice_title);

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



  $('#Iller').val(fullData.address_city_plate);
    $('#Iller').trigger('change');

    $('#Ilceler').val(fullData.address_district);
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
                            $('#area_code').val(areaCode);
                            $('#area_code').trigger('change');
                            $("#cari_phone").val(phone).unmask().mask("(000) 000 0000");


                            $('#money_unit_id').val(fullData.money_unit_id);
                            $('#money_unit_id').trigger('change');
                            $('#currency_exchange_value').val(fullData.money_value);

                            $('#is_customer_save').removeAttr('checked');
                            $('#is_customer_save').removeAttr('disabled');

                            if (fullData.obligation == 'e-archive') {
                                $('#obligation').val('e-archive');
                                $('#obligation').trigger('change');
                                $('#obligation').attr('disabled', 'disabled');

                            } else {
                                $('#obligation').val('e-invoice');
                                $('#obligation').trigger('change');
                                $('#obligation').attr('disabled', 'disabled');
                            }
                        }
                        else {
                            $('#yeniCari').removeAttr('disabled');
                            $('#yeniCari').text('Kaydet');


                            var temp = $('#identification_number').val();
                            $('#txt_identification_number').val(temp);

                            $('#createCari')[0].reset();
                            $('#Iller').trigger('change');
                            $('#Ilceler').trigger('change');

                            $('#identification_number').val(temp);

                            $('#invoice_title').val(datas.response.unvan);
                            $('#tax_administration').val(datas.response.vergi_dairesi);

                            $('#is_customer').attr('checked', 'checked');

                            $('#is_supplier').removeAttr('checked');
                            $('#is_export_customer').removeAttr('checked');

                            if (datas.response.adres != 0) $('#address').val(datas.response.adres);

                            if (datas.response.unvan != "") {
                                $('#name').val(datas.response.adi);
                                $('#surname').val(datas.response.soyadi);
                                $('#invoice_title').val(datas.response.unvan);

                                $('#company_type').val('person');
                                $('#company_type').trigger('change');
                            } else {
                                $('#invoice_title').val(datas.response.unvan);
                                $('#company_type').val('company');
                                $('#company_type').trigger('change');
                            }


                            if (datas.response.vknInfo == 0) {
                                $('#obligation').val('e-archive');
                                $('#obligation').trigger('change');
                            } else {
                                $('#obligation').val('e-invoice');
                                $('#obligation').trigger('change');
                            }

                           if(vknTc.length == 10){
                            $('#company_type').val('company').trigger('change');
                            }
                                if(vknTc.length == 11){
                            $('#company_type').val('person').trigger('change');
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
        $('#btn_musteriSorgula').attr('disabled', true);

        $('#is_export_customer').change(function() {
            if ($(this).is(':checked')) {
                $('#identification_number').val('22222222222');
                $('#btn_musteriSorgula').attr('disabled', true);
            } else {
                $('#identification_number').val('');
                $('#identification_number').attr('disabled', false);
            }
        });
        $('#identification_number').on('input', function() {
            var charCount = $(this).val().length;
            if ((charCount == 10 || charCount == 11) && $('#is_export_customer').is(':checked') == false) $('#btn_musteriSorgula').attr('disabled', false);
            else $('#btn_musteriSorgula').attr('disabled', true);
        });

        $('#company_type').change(function() {
            var c_type = $('#company_type').val();

            if (c_type == 'person') {
                $('#namesurname').removeClass('d-none');
                $('#fatura_unvani_area').removeClass('d-none');

            } else {
                $('#namesurname').addClass('d-none');
            }
        });
    });





$("#address_country").on("change", function() {

var selectedValue = $(this).val();


var SehirDiv2 = $("#ilDegisiklik");
var IlceDiv2 = $("#IlceDegisiklik");
var sehir2Template = '<select id="Iller" name="address_city" class="form-select js-select2 add_city otomatikUlke" data-ui="lg" data-search="on" data-placeholder="İl Seçiniz"><option value="0">İl seçiniz</option>  </select> <input type="hidden" class=" form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_city_name" id="address_city_name" >';
var Ilce2Template = '<select id="Ilceler" name="address_district" class="form-select js-select2 otomatikUlke" data-ui="lg" data-placeholder="İlçe Seçiniz" data-search="off"> <option value="0" selected disabled>İlçe seçiniz</option></select>';

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
        text:  'Lütfen Bir İlçe seçiniz'
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
            
            $('#Iller').select2();
            $('#Ilceler').select2();


        }, 100);



}


});

</script>

<?= $this->endSection() ?>