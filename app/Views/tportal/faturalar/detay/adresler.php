<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Cari Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Cari Detay | <?= session()->get('user_item')['firma_adi'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head nk-block-head-lg">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Cari Adresleri</h4>

                                    </div>
                                    <div class="nk-block-head-content align-self-start">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mdl_adres">Yeni Adres</button>
                                        <button class="toggle btn btn-icon btn-trigger mt-n1 d-lg-none" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></button>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">
                                <div class="nk-data data-list">


                                    <table class="datatable-init-hareketler nowrap table" data-export-title="Export">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2;">Adres Türü</th>
                                                <th style="background-color: #ebeef2;">Şehir</th>
                                                <th style="background-color: #ebeef2;">İlçe</th>
                                                <th style="background-color: #ebeef2;">Adres</th>
                                                <th class="text-center" style="background-color: #ebeef2;">Varsayılan</th>
                                                <th style="background-color: #ebeef2;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($address_items as $address_item) { ?>
                                                <?php
                                                $basePhone = $address_item['address_phone'];
                                                $splitPhone = explode(" ", $basePhone);
                                                ?>
                                                <tr>
                                                    <td><?= $address_item['address_title'] ?></td>
                                                    <td><?= $address_item['address_city'] ?></td>
                                                    <td><?= $address_item['address_district'] ?></td>
                                                    <td style="max-width: 200px !important; width:200px !important; overflow:hidden; text-overflow:ellipsis" width="500"><?= $address_item['address'] ?></td>
                                                    <td class="text-center">
                                                        <div class="custom-control custom-switch" style="min-height: 1rem">
                                                            <input type="checkbox" class="custom-control-input default-button" id="<?= $address_item['address_id'] ?>" cari_id="<?= $cari_item['cari_id'] ?>" <?php if ($address_item['default'] == 'true') { ?>checked <?php } ?>>
                                                            <label class="custom-control-label" for="customSwitch1"></label>
                                                            <label class="custom-control-label" id="btn_default_<?= $address_item['address_id'] ?>" for="<?= $address_item['address_id'] ?>">
                                                            </label>
                                                        </div>

                                                    </td>
                                                    <td class="text-end">
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#mdl_edit_cari_address" id="editCariUser" address_id="<?= $address_item['address_id'] ?>" address_title="<?= $address_item['address_title'] ?>" address_country="<?= $address_item['address_country'] ?>" address_city="<?= $address_item['address_city'] ?>" address_city_plate="<?= $address_item['address_city_plate'] ?>" address_district="<?= $address_item['address_district'] ?>" zip_code="<?= $address_item['zip_code'] ?>" address="<?= $address_item['address'] ?>" address_email="<?= $address_item['address_email'] ?>" address_phone_area_code="<?= $splitPhone[0] ?>" address_phone="<?= $address_item['address_phone'] ?>" class="btn btn-icon btn-xs btn-dim btn-outline-dark editCariAddress"><em class="icon ni ni-pen-alt-fill"></em></button>
                                                        <button type="button" id="deleteCariAddress" address_id="<?= $address_item['address_id'] ?>" address_title="<?= $address_item['address_title'] ?>" class="btn btn-icon btn-xs btn-dim btn-outline-danger deleteCariAddress"><em class="icon ni ni-trash-empty"></em></button>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div><!-- data-list -->

                            </div><!-- .nk-block -->
                        </div>

                        <?= $this->include('tportal/cariler/detay/inc/sol_menu') ?>
                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>



<!-- Create Cari Address Modal -->
<div id="mdl_adres" class="modal fade" role="dialog" aria-labelledby="mdl_adres" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Cari Adres</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="createCariAddressForm" method="post">


                    <div class="errorTxtCreateCari" role=""></div>
                    <hr>
                    <div class="row g-3 align-center mb-3">
                        <div class="col-lg-12">
                            <label class="form-label" for="type_title">Adres Başlığı</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="Fatura Adresi, Fabrika Adresi, Depo Adresi vb." id="address_title" name="address_title" required>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-3 align-center">
                        <div class="col-lg-6 col-xxl-6 ">
                            <div class="form-group">

                                <label class="form-label" for="address_country">Ülke</label>
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
                        <div class="col-lg-6 col-xxl-6 ">
                            <div class="form-group">
                                <label class="form-label " for="address_city">Şehir</label>
                                <div class="form-control-wrap">

                                    <select id="Iller" name="address_city" class="form-select js-select2" data-ui="lg" data-search="on">
                                        <option value="0" selected>İl seçiniz</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 ">
                            <div class="form-group">
                                <label class="form-label  mt-2" for="address_district">İlçe</label>
                                <div class="form-control-wrap">

                                    <select id="Ilceler" name="address_district" class="form-select js-select2" data-ui="lg" data-placeholder="İlçe Seçiniz" data-search="on">
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 ">
                            <div class="form-group">
                                <label class="form-label  mt-2">Posta Kodu</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg" placeholder="Posta Kodu" name="zip_code" id="zip_code" value="" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 align-center">
                        <label class="form-label" for="type_title">Açık Adres</label>

                        <div class="form-control-wrap">
                            <textarea class="form-control form-control-lg" name="address" id="address" cols="30" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="row g-3 align-center mb-3">
                        <div class="col-lg-12">
                            <label class="form-label" for="type_title">E-posta</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="Fatura/İrsaliye Adresine Ait E-posta Adresi" name="address_email" id="address_email" required>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 align-center ">
                        <div class="col-lg-12 col-xxl-12 col-12">
                            <label class="form-label" for="type_title">Telefon</label>
                            <div class="form-control-wrap">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-lg btn-block btn-dim btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                                                <span id="lastAreaCode">seçiniz</span>
                                                <em class="icon mx-n1 ni ni-chevron-down"></em>
                                            </button>
                                            <div class="dropdown-menu">
                                                <select id="area_code" name="area_code" class="form-select js-select2" data-ui="lg" data-search="on" data-placeholder="Seçiniz"> <!--  -->
                                                    <option id="selecteditem" value="0">Seçiniz</option>
                                                    <option value="+90">🇹🇷 (+90) Türkiye</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" name="address_phone" id="address_phone" aria-label="Text input with dropdown button" placeholder="000 000 00 00" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <input type="hidden" name="default" value="false"> -->
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-dim btn-outline-light" data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <button type="button" id="saveCariAddress" class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Cari Address Modal -->
<div id="mdl_edit_cari_address" class="modal fade" role="dialog" aria-labelledby="mdl_edit_cari_address" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cari Adres Düzenle</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="editCariAddressForm" method="post">

                    <div class="errorTxtEditCari" role=""></div>
                    <hr>

                    <div class="row g-3 align-center mb-3">
                        <div class="col-lg-12">
                            <label class="form-label" for="type_title">Adres Başlığı</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="Fatura Adresi, Fabrika Adresi, Depo Adresi vb." id="edit_address_title" name="edit_address_title" required>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-3 align-center">
                        <div class="col-lg-6 col-xxl-6 ">
                            <div class="form-group">

                                <label class="form-label" for="address_country">Ülke</label>
                                <div class="form-control-wrap">
                                    <select id="edit_address_country" name="edit_address_country" class="form-select js-select2" data-ui="lg" data-search="on">
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
                        <div class="col-lg-6 col-xxl-6 ">
                            <div class="form-group">
                                <label class="form-label " for="address_city">Şehir</label>
                                <div class="form-control-wrap">
                                    <select id="Iller2" name="edit_address_city" class="form-select js-select2" data-ui="lg" data-placeholder="İl Seçiniz" data-search="off">
                                        <option value="0" disabled>İl seçiniz</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 ">
                            <div class="form-group">
                                <label class="form-label  mt-2" for="address_district">İlçe</label>
                                <div class="form-control-wrap">
                                    <select id="Ilceler2" name="edit_address_district" class="form-select js-select2" data-ui="lg" data-placeholder="İlçe Seçiniz" data-search="off">
                                        <option value="0" selected disabled>İlçe seçiniz</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 ">
                            <div class="form-group">
                                <label class="form-label mt-2">Posta Kodu</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg" placeholder="Posta Kodu" name="edit_zip_code" id="edit_zip_code" value="" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 align-center">
                        <label class="form-label" for="edit_address">Açık Adres</label>

                        <div class="form-control-wrap">
                            <textarea class="form-control form-control-lg" name="edit_address" id="edit_address" cols="30" rows="3" require></textarea>
                        </div>
                    </div>

                    <div class="row g-3 align-center mb-3">
                        <div class="col-lg-12">
                            <label class="form-label" for="edit_address_email">E-posta</label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control invalid form-control-xl" placeholder="Fatura/İrsaliye Adresine Ait E-posta Adresi" name="edit_address_email" id="edit_address_email">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 align-center ">
                        <div class="col-lg-12 col-xxl-12 col-12">
                            <label class="form-label" for="type_title">Telefon</label>
                            <div class="form-control-wrap">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-lg btn-block btn-dim btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                                                <span id="editlastAreaCode"></span>
                                                <em class="icon mx-n1 ni ni-chevron-down"></em>
                                            </button>
                                            <div class="dropdown-menu">
                                                <select id="edit_address_phone_area_code" name="edit_area_code" class="form-select js-select2" data-ui="lg" data-search="on" data-placeholder="Seçiniz"> <!--  -->
                                                    <option id="editselecteditem" value="">Seçiniz</option>
                                                    <option value="+90">🇹🇷 (+90) Türkiye</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" name="edit_address_phone" id="edit_address_phone" aria-label="Text input with dropdown button" placeholder="000 000 00 00" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="mdl_edit_cari_address" class="btn btn-lg  btn-dim btn-outline-light" data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <button type="button" id="editSaveCariUser" class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'create_cari_address',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Cari adres başarıyla eklendi',
                'modal_buttons' => '<a href="' . route_to('tportal.cariler.address', $cari_item['cari_id']) . '" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Adres Ekle</a>
                                    <a href="' . route_to('tportal.cariler.address', $cari_item['cari_id']) . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Tüm Adresleri Göster</a>'
            ],
        ],
    ]
); ?>

<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'edit_cari_address',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Adres başarıyla güncellendi',
                'modal_buttons' => '<a href="' . route_to('tportal.cariler.address', $cari_item['cari_id']) . '" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Adres Ekle</a>
                                    <a href="' . route_to('tportal.cariler.address', $cari_item['cari_id']) . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Tüm Adresleri Göster</a>'
            ],
        ],
    ]
); ?>

<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'default_cari_address',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Varsayılan adres başarıyla güncellendi',
                'modal_buttons' => '<a href="' . route_to('tportal.cariler.address', $cari_item['cari_id']) . '" class="btn btn-primary btn-block mb-2">Tamam</a>'
            ],
        ],
    ]
); ?>


<?= $this->endSection() ?>

<?= $this->section('script') ?>



<script>
    $(document).ready(function() {
        $("#area_code, #Iller, #Ilceler").select2({
            dropdownParent: $('#mdl_adres .modal-content'),
            dropdownCssClass: "error",
        });

        $("#edit_address_phone_area_code").select2({
            dropdownParent: $('#mdl_edit_cari_address .modal-content'),
        });


        $("#area_code").change(function() {
            var selectedVal = $(this).val();
            $("#lastAreaCode").text(selectedVal);
        });
        $("#edit_address_phone_area_code").change(function() {
            var selectedVal = $(this).val();
            $("#editlastAreaCode").text(selectedVal);
        });


        $('#saveCariAddress').click(function(e) {

            $("#createCariAddressForm").validate({
                rules: {
                    address_title: "required",
                    address_country: "required",
                    address_city: {
                        required: true,
                        min: 1
                    },
                    address_district: {
                        required: true,
                        // lettersonly: true
                    },
                    zip_code: {
                        required: true,
                        number: true
                    },
                    address: "required",
                    address_email: {
                        required: true,
                        email: true
                    },
                    area_code: {
                        required: true,
                        min: 1
                    },
                    address_phone: "required",
                },
                messages: {
                    address_title: "Adres başlığı alanı zorunludur",
                    address_country: "Ülke alanı zorunludur",
                    address_city: "Şehir alanı zorunludur",
                    address_district: "İlçe alanı zorunludur",
                    zip_code: {
                        required: "Posta kodu alanı zorunludur",
                        number: "Lütfen sadece sayı giriniz."
                    },
                    address: "Açık adres alanı zorunludur",
                    address_email: "E-posta alanı zorunludur",
                    area_code: "Ülke kodu alanı zorunludur",
                    address_phone: "Telefon numarası alanı zorunludur",
                },
                errorElement: 'li',
                errorLabelContainer: '.errorTxtCreateCari',
                errorClass: "text-danger",
                submitHandler: function(form) { // for demo

                    e.preventDefault();

                    var formData = $('#createCariAddressForm').serializeArray();
                    formData.push({
                        name: "cari_id",
                        value: <?= $cari_item['cari_id'] ?>
                    });
                    formData.push({
                        name: 'address_city_name',
                        value: $("#Iller option:selected").text(),
                    });
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                        },
                        type: 'POST',
                        url: '<?= route_to('tportal.cariler.address_create', $cari_item['cari_id']) ?>',
                        dataType: 'json',
                        data: formData,
                        async: true,
                        success: function(response) {
                            if (response['icon'] == 'success') {
                                $("#trigger_create_cari_address_ok_button").click();
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
            $('#createCariAddressForm').submit();
        });

        $(".editCariAddress").each(function(index) {

            // $("#address_phone").mask("(000) 000 0000");
            // $("#edit_address_phone").mask("(000) 000 0000");

            $(this).on("click", function() {

                var address_id = $(this).attr('address_id'),
                    address_title = $(this).attr('address_title'),
                    edit_address_country = $(this).attr('address_country'),
                    edit_address_city = $(this).attr('address_city'),
                    edit_address_city_plate = $(this).attr('address_city_plate'),
                    edit_address_district = $(this).attr('address_district'),
                    edit_zip_code = $(this).attr('zip_code'),
                    edit_address = $(this).attr('address'),
                    edit_address_email = $(this).attr('address_email'),
                    edit_address_phone_area_code = $(this).attr('address_phone_area_code'),
                    edit_address_phone = $(this).attr('address_phone');


                basePhone = edit_address_phone;
                splitPhone = basePhone.split(" ");
                edit_address_phone = splitPhone[1];

                $('#edit_address_title').val(address_title);
                $('#edit_zip_code').val(edit_zip_code);
                $('#edit_address').val(edit_address);
                $('#edit_address_email').val(edit_address_email);
                $('#edit_address_phone_area_code').val(edit_address_phone_area_code);
                $('#edit_address_phone').val(edit_address_phone);
                $('#editlastAreaCode').text(edit_address_phone_area_code);

                document.getElementById("edit_address_country").options.selectedIndex = edit_address_country;

                //edit modal'ında il ilçe value olarak plaka basılması gerekiyor. ama elimizde sadece il ilçe bilgisinin ismi var.
                $('#Iller2').val(edit_address_city_plate);
                $('#Iller2').trigger('change');

                $('#Ilceler2').val(edit_address_district);
                $('#Ilceler2').trigger('change');

                $('#edit_address_phone_area_code').val(edit_address_phone_area_code);
                $('#edit_address_phone_area_code').trigger('change');


                $('#editSaveCariUser').click(function(e) {

                    $("#editCariAddressForm").validate({
                        rules: {
                            edit_address_title: "required",
                            edit_address_country: "required",
                            edit_address_city: {
                                required: true,
                                min: 1
                            },
                            edit_address_district: {
                                required: true,
                                // lettersonly: true
                            },
                            edit_zip_code: {
                                required: true,
                                number: true
                            },
                            edit_address: "required",
                            edit_address_email: {
                                required: true,
                                // email: true
                            },
                            edit_address_phone_area_code: {
                                required: true,
                                min: 1
                            },
                            edit_address_phone: "required",
                        },
                        messages: {
                            edit_address_title: "Adres başlığı alanı zorunludur",
                            address_country: "Ülke alanı zorunludur",
                            edit_address_city: "Şehir alanı zorunludur",
                            edit_address_district: "İlçe alanı zorunludur",
                            edit_zip_code: {
                                required: "Posta kodu alanı zorunludur",
                                number: "Lütfen sadece sayı giriniz."
                            },
                            edit_address: "Açık adres alanı zorunludur",
                            edit_address_email: "E-posta alanı zorunludur",
                            edit_address_phone_area_code: "Ülke kodu alanı zorunludur",
                            edit_address_phone: "Telefon numarası alanı zorunludur",
                        },
                        errorElement: 'li',
                        errorLabelContainer: '.errorTxtEditCari',
                        errorClass: "text-danger",
                        submitHandler: function(form) {

                            e.preventDefault();
                            if ($('#edit_address_title') == null || $('#edit_address').val() == '' || $('#edit_address_email').val() == '' || $('#edit_area_code').val() == '' || $('#edit_address_email').val() == '') {
                                swetAlert("Eksik Bir Şeyler Var", "Lütfen tüm alanları doldurunuz! ", "err");
                            } else {
                                var formData = $('#editCariAddressForm').serializeArray();
                                console.log(formData);
                                formData.push({
                                    name: 'address_id',
                                    value: address_id
                                });
                                formData.push({
                                    name: 'edit_address_city_name',
                                    value: $("#Iller2 option:selected").text(),
                                });
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                                    },
                                    type: 'POST',
                                    url: '<?= route_to('tportal.cariler.address_edit') ?>',
                                    dataType: 'json',
                                    data: formData,
                                    async: true,
                                    success: function(response) {
                                        if (response['icon'] == 'success') {
                                            $("#trigger_edit_cari_address_ok_button").click();
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
                        }
                    });
                    $('#editCariAddressForm').submit();
                });
            })
        });

        $(".deleteCariAddress").each(function(index) {
            $(this).on("click", function() {

                var address_id = $(this).attr('address_id');
                var address_title = $(this).attr('address_title');
                console.log(address_id);
                console.log(address_title);

                Swal.fire({
                    title: address_title + ' <br>adresini silmek üzeresiniz!',
                    html: 'Silme işlemine devam etmek istiyor musunuz?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Devam Et',
                    cancelButtonText: 'Hayır',
                    allowEscapeKey: false,
                    allowOutsideClick: false,

                }).then((result) => {
                    if (result.isConfirmed) {

                        Swal.fire({
                            title: 'İşleminiz gerçekleştiriliyor, lütfen bekleyiniz...',
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                Swal.showLoading();
                            },
                        });

                        $.ajax({
                            type: 'POST',
                            url: '<?= route_to('tportal.cariler.address_delete', $cari_item['cari_id']) ?>',
                            data: "address_id=" + address_id,
                            success: function(response, data) {
                                if (data === "success") {
                                    console.log(response);
                                    console.log(data);
                                    Swal.fire({
                                            title: "İşlem Başarılı",
                                            html: '<b> ' + address_title + '</b> adresi başarıyla silindi.',
                                            confirmButtonText: "Tamam",
                                            allowEscapeKey: false,
                                            allowOutsideClick: false,
                                            icon: "success",
                                        })
                                        .then(function() {
                                            window.location.reload();
                                        });

                                } else {
                                    Swal.fire({
                                        title: "İşlem Başarısız",
                                        text: data,
                                        confirmButtonText: "Tamam",
                                        allowEscapeKey: false,
                                        allowOutsideClick: false,
                                        icon: "error",
                                    })
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                                console.log(status);
                                console.log(error);
                                Swal.fire({
                                    title: "Bir hata oluştu",
                                    text: "sistemsel bir hata. daha sonra tekrar deneyiniz.",
                                    confirmButtonText: "Tamam",
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    icon: "error",
                                })
                            },
                        });

                    } else if (result.isCancel) {
                        Swal.fire('Değişiklikler kaydedilmedi', '', 'info')
                    }
                })

            });
        });

        $(".default-button").each(function(index) {
        $(this).on("click", function() {
            $(".default-button").prop('checked', false);
            $(this).prop('checked', true);
            var address_id = $(this).attr('id'),
                cari_id = $(this).attr('cari_id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.cariler.address_edit.default') ?>',
                dataType: 'json',
                data: {
                    cari_id: cari_id,
                    address_id: address_id,
                },
                async: true,
                success: function(response) {
                    if (response['icon'] == 'success') {
                        $("#trigger_default_cari_address_ok_button").trigger("click");
                    } else {
                        return false;
                    }
                }
            })
        });
    })

    });
</script>

<?= $this->endSection() ?>