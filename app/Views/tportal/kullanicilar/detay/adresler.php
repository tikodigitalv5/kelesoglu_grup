
<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Cari Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Cari Detay | Müşteri Ünvan Gelecek <?= $this->endSection() ?>
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
                                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mdl_adres">Yeni Adres</a>
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1 d-lg-none" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                   

                                    <table class="datatable-init-hareketler nowrap table" data-export-title="Export">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2;">Şehir</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">İlçe</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">Adres</th>
                                                <th class="text-center" style="background-color: #ebeef2;" data-orderable="false">Varsayılan</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Bursa</td>
                                                <td>Osmangazi</td>
                                                <td>VEYSEL KARANİ MAH. 9.İNCİ SK. ...</td>
                                                <td class="text-center">
                                                    <div class="custom-control custom-switch" style="min-height: 1rem">    
                                                        <input type="checkbox" checked class="custom-control-input" id="customSwitch1">    
                                                        <label class="custom-control-label" for="customSwitch1"></label>
                                                    </div>
                                                    
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-icon btn-xs btn-dim btn-outline-dark"><em class="icon ni ni-pen-alt-fill"></em></a>
                                                    <a href="#" class="btn btn-icon btn-xs btn-dim btn-outline-danger"><em class="icon ni ni-trash-empty"></em></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bursa</td>
                                                <td>Nilüfer</td>
                                                <td>ÜÇEVLER MH. RİTİM SK. NO:12 ...</td>
                                                <td class="text-center">
                                                    <div class="custom-control custom-switch" style="min-height: 1rem">    
                                                        <input type="checkbox" class="custom-control-input" id="customSwitch1">    
                                                        <label class="custom-control-label" for="customSwitch1"></label>
                                                    </div>
                                                    
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-icon btn-xs btn-dim btn-outline-dark"><em class="icon ni ni-pen-alt-fill"></em></a>
                                                    <a href="#" class="btn btn-icon btn-xs btn-dim btn-outline-danger"><em class="icon ni ni-trash-empty"></em></a>
                                                </td>
                                            </tr>
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



<!-- Modal Alert 2 -->
<div class="modal fade" tabindex="-1" id="mdl_adres">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Cari Adres</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="createStockOperationForm" method="post" class="form-validate is-alter">
                    <div class="row mb-3 align-center">
                        <div class="col-lg-6 col-xxl-6 ">
                            <div class="form-group">
                                
                                <label class="form-label" for="ddl_ulke">Ülke</label>
                                <div class="form-control-wrap">
                                    <select id="ddl_ulke" name="ddl_ulke" class="form-select js-select2" data-ui="lg" data-search="on">
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
                                <label class="form-label " for="ddl_ulke">Şehir</label>
                                <div class="form-control-wrap">
                                <select id="musteri_il" name="musteri_il" class="form-select js-select2" data-ui="lg" data-placeholder="İl Seçiniz" data-search="on">
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
                                            <option value="Antalya" data-plaka="7">
                                            Antalya
                                            </option>
                                            <option value="Artvin" data-plaka="8">
                                            Artvin
                                            </option>
                                            <option value="Aydın" data-plaka="9">
                                            Aydın
                                            </option>
                                            <option value="Balıkesir" data-plaka="10">
                                            Balıkesir
                                            </option>
                                            <option value="Bilecik" data-plaka="11">
                                            Bilecik
                                            </option>
                                            <option value="Bingöl" data-plaka="12">
                                            Bingöl
                                            </option>
                                            <option value="Bitlis" data-plaka="13">
                                            Bitlis
                                            </option>
                                            <option value="Bolu" data-plaka="14">
                                            Bolu
                                            </option>
                                            <option value="Burdur" data-plaka="15">
                                            Burdur
                                            </option>
                                            <option value="Bursa" data-plaka="16">
                                            Bursa
                                            </option>
                                            <option value="Çanakkale" data-plaka="17">
                                            Çanakkale
                                            </option>
                                            <option value="Çankırı" data-plaka="18">
                                            Çankırı
                                            </option>
                                            <option value="Çorum" data-plaka="19">
                                            Çorum
                                            </option>
                                            <option value="Denizli" data-plaka="20">
                                            Denizli
                                            </option>
                                            <option value="Diyarbakır" data-plaka="21">
                                            Diyarbakır
                                            </option>
                                            <option value="Edirne" data-plaka="22">
                                            Edirne
                                            </option>
                                            <option value="Elazığ" data-plaka="23">
                                            Elazığ
                                            </option>
                                            <option value="Erzincan" data-plaka="24">
                                            Erzincan
                                            </option>
                                            <option value="Erzurum" data-plaka="25">
                                            Erzurum
                                            </option>
                                            <option value="Eskişehir" data-plaka="26">
                                            Eskişehir
                                            </option>
                                            <option value="Gaziantep" data-plaka="27">
                                            Gaziantep
                                            </option>
                                            <option value="Giresun" data-plaka="28">
                                            Giresun
                                            </option>
                                            <option value="Gümüşhane" data-plaka="29">
                                            Gümüşhane
                                            </option>
                                            <option value="Hakkari" data-plaka="30">
                                            Hakkari
                                            </option>
                                            <option value="Hatay" data-plaka="31">
                                            Hatay
                                            </option>
                                            <option value="Isparta" data-plaka="32">
                                            Isparta
                                            </option>
                                            <option value="Mersin" data-plaka="33">
                                            Mersin
                                            </option>
                                            <option value="İstanbul" data-plaka="34">
                                            İstanbul
                                            </option>
                                            <option value="İzmir" data-plaka="35">
                                            İzmir
                                            </option>
                                            <option value="Kars" data-plaka="36">
                                            Kars
                                            </option>
                                            <option value="Kastamonu" data-plaka="37">
                                            Kastamonu
                                            </option>
                                            <option value="Kayseri" data-plaka="38">
                                            Kayseri
                                            </option>
                                            <option value="Kırklareli" data-plaka="39">
                                            Kırklareli
                                            </option>
                                            <option value="Kırşehir" data-plaka="40">
                                            Kırşehir
                                            </option>
                                            <option value="Kocaeli" data-plaka="41">
                                            Kocaeli
                                            </option>
                                            <option value="Konya" data-plaka="42">
                                            Konya
                                            </option>
                                            <option value="Kütahya" data-plaka="43">
                                            Kütahya
                                            </option>
                                            <option value="Malatya" data-plaka="44">
                                            Malatya
                                            </option>
                                            <option value="Manisa" data-plaka="45">
                                            Manisa
                                            </option>
                                            <option value="Kahramanmaraş" data-plaka="46">
                                            Kahramanmaraş
                                            </option>
                                            <option value="Mardin" data-plaka="47">
                                            Mardin
                                            </option>
                                            <option value="Muğla" data-plaka="48">
                                            Muğla
                                            </option>
                                            <option value="Muş" data-plaka="49">
                                            Muş
                                            </option>
                                            <option value="Nevşehir" data-plaka="50">
                                            Nevşehir
                                            </option>
                                            <option value="Niğde" data-plaka="51">
                                            Niğde
                                            </option>
                                            <option value="Ordu" data-plaka="52">
                                            Ordu
                                            </option>
                                            <option value="Rize" data-plaka="53">
                                            Rize
                                            </option>
                                            <option value="Sakarya" data-plaka="54">
                                            Sakarya
                                            </option>
                                            <option value="Samsun" data-plaka="55">
                                            Samsun
                                            </option>
                                            <option value="Siirt" data-plaka="56">
                                            Siirt
                                            </option>
                                            <option value="Sinop" data-plaka="57">
                                            Sinop
                                            </option>
                                            <option value="Sivas" data-plaka="58">
                                            Sivas
                                            </option>
                                            <option value="Tekirdağ" data-plaka="59">
                                            Tekirdağ
                                            </option>
                                            <option value="Tokat" data-plaka="60">
                                            Tokat
                                            </option>
                                            <option value="Trabzon" data-plaka="61">
                                            Trabzon
                                            </option>
                                            <option value="Tunceli" data-plaka="62">
                                            Tunceli
                                            </option>
                                            <option value="Şanlıurfa" data-plaka="63">
                                            Şanlıurfa
                                            </option>
                                            <option value="Uşak" data-plaka="64">
                                            Uşak
                                            </option>
                                            <option value="Van" data-plaka="65">
                                            Van
                                            </option>
                                            <option value="Yozgat" data-plaka="66">
                                            Yozgat
                                            </option>
                                            <option value="Zonguldak" data-plaka="67">
                                            Zonguldak
                                            </option>
                                            <option value="Aksaray" data-plaka="68">
                                            Aksaray
                                            </option>
                                            <option value="Bayburt" data-plaka="69">
                                            Bayburt
                                            </option>
                                            <option value="Karaman" data-plaka="70">
                                            Karaman
                                            </option>
                                            <option value="Kırıkkale" data-plaka="71">
                                            Kırıkkale
                                            </option>
                                            <option value="Batman" data-plaka="72">
                                            Batman
                                            </option>
                                            <option value="Şırnak" data-plaka="73">
                                            Şırnak
                                            </option>
                                            <option value="Bartın" data-plaka="74">
                                            Bartın
                                            </option>
                                            <option value="Ardahan" data-plaka="75">
                                            Ardahan
                                            </option>
                                            <option value="Iğdır" data-plaka="76">
                                            Iğdır
                                            </option>
                                            <option value="Yalova" data-plaka="77">
                                            Yalova
                                            </option>
                                            <option value="Karabük" data-plaka="78">
                                            Karabük
                                            </option>
                                            <option value="Kilis" data-plaka="79">
                                            Kilis
                                            </option>
                                            <option value="Osmaniye" data-plaka="80">
                                            Osmaniye
                                            </option>
                                            <option value="Düzce" data-plaka="81">
                                            Düzce
                                            </option>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 ">
                            <div class="form-group">
                                <label class="form-label  mt-2" for="ddl_ulke">İlçe</label>
                                <div class="form-control-wrap">
                                <select id="musteri_ilce" name="musteri_ilce" class="form-select js-select2" data-ui="lg" data-placeholder="İlçe Seçiniz" data-search="on">
                                                <option></option>
                                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-6 ">
                            <div class="form-group">
                                <label class="form-label  mt-2" for="ddl_ulke">Posta Kodu</label>
                                <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-lg" id="txt_eposta" value="" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                           
                    <div class="row mb-3 align-center">
                        <label class="form-label" for="type_title">Fatura / İrsaliye Adresi</label>
                           
                        <div class="form-control-wrap">
                            <textarea class="form-control form-control-lg" name="txt_adres" id="txt_adres" cols="30" rows="3"></textarea>
                        </div>
                            
                    </div>
                    

                    <div class="row g-3 align-center mb-3">
                        <div class="col-lg-12">
                            <label class="form-label" for="type_title">Ad Soyad</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="Adresteki Yetkilinin Adı Soyadı"
                                    id="relation_order" name="relation_order" required>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row g-3 align-center mb-3">
                        <div class="col-lg-12">
                            <label class="form-label" for="type_title">E-posta</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="Fatura/İrsaliye Adresine Ait E-posta Adresi"
                                    id="relation_order" name="relation_order" required>
                            </div>
                        </div>
                        
                    </div>
                   


                    <div class="row g-3 align-center ">
                        <div class="col-lg-9 col-xxl-9 col-9">
                            <label class="form-label" for="type_title">Telefonu</label>
                            <div class="form-control-wrap">
                                <div class="form-group">
                                    <div class="input-group  input-group-xl">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-lg btn-block btn-dim btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
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
                                        <input type="text" class="form-control form-control-xl" aria-label="Text input with dropdown button" placeholder="000 000 00 00">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xxl-3 col-3">
                            <label class="form-label" for="type_title">Dahili</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="10" required="" id="duration" name="duration">
                            </div>
                        </div>
                    </div>
                    


                                

                 
                   


                    
                    




                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-dim btn-outline-light"
                            data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0">
                        <!-- <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ HESAP</button> -->
                        <button type="button" id="stokOperasyonOlustur" class="btn btn-lg btn-primary ">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>

</script>

<?= $this->endSection() ?>