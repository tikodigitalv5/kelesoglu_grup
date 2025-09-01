
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
                                        <h4 class="nk-block-title">Cari Düzenle</h4>
                                      
                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <form onsubmit="return false;" id="" method="post"> 
                                    <div class="card-inner position-relative card-tools-toggle p-0">
                                        <div class="gy-2">
                
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group"><label class="form-label" for="site-name">Cari Tipi</label><span class="form-note d-none d-md-block">Ürünün ait olduğu tipi.</span></div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                            <ul class="custom-control-group">
                                                                <li>
                                                                    <div class="custom-control custom-control-sm custom-checkbox custom-control-pro">
                                                                        <input type="checkbox" checked class="custom-control-input" name="btnCheckControl" id="btnCheckControl1">
                                                                        <label class="custom-control-label" for="btnCheckControl1">
                                                                            <em class="icon ni ni-user"></em>
                                                                            <span>Müşteri</span>
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-control-sm custom-checkbox custom-control-pro">
                                                                        <input type="checkbox" class="custom-control-input" name="btnCheckControl" id="btnCheckControl2">
                                                                        <label class="custom-control-label" for="btnCheckControl2">
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
                                                <div class="form-group"><label class="form-label" for="chk_ihracatmusterisi">İhracat Müşterisi</label><span class="form-note d-none d-md-block">Eğer bu müşteri ihracat müşteriniz ise işaretleyiniz..</span></div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                <ul class="custom-control-group">
                                                    <li>
                                                        <div class="custom-control custom-control-sm custom-checkbox custom-control-pro">
                                                            <input type="checkbox" class="custom-control-input" name="btnCheckControl" id="chk_ihracatmusterisi">
                                                            <label class="custom-control-label" for="chk_ihracatmusterisi">
                                                                Evet
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group"><label class="form-label" for="tc_vergino">T.C./Vergi No</label><span class="form-note d-none d-md-block">Bu bilgiyi doğru girip sorgularsanız ünvan ve vergi dairesi gibi bilgiler otomatik gelecektir.</span></div>
                                            </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-lg" id="tc_vergino" placeholder="T.C. veya Vergi No Giriniz.." value="3850728955">
                                                        <div class="input-group-append">
                                                            <button id="btn_musteriSorgula" class="btn btn-lg btn-block btn-dim btn-outline-light">Sorgula</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group"><label class="form-label" for="site-name">Mükellefiyet</label><span class="form-note d-none d-md-block">Carinin mükellefiyet durumu.</span></div>
                                            </div>
                                            <div class="col-lg-4 col-xxl-4  mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <select class="form-select js-select2"  id="slct_mukellefiyet" name="slct_mukellefiyet" data-ui="lg" data-val="Mükellefiyet">
                                                    <option value="null">Mükellefiyet</option>
                                                    <option value="0">E-ARSIVFATURA</option>
                                                    <option selected value="1">E-FATURA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-xxl-3  mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <select class="form-select js-select2"  id="slct_sirkettipi" name="slct_sirkettipi" data-ui="lg" data-val="Şirket Tipi">
                                                    <option value="null">Şirket Tipi</option>
                                                    <option value="0">Şahıs</option>
                                                    <option selected value="1">Şirket</option>
                                                    <option value="2">Kamu</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="txt_unvan">Fatura Ünvanı</label><span class="form-note d-none d-md-block">Fatura kesilecek resmi ünvan.<br>Şirket ise ünvan gelir, değil ise ad soyad.</span></div>
                                                </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" id="txt_unvan" value="FAMS OTOMOTİV AKSESUARLARI YEDEK PARÇA TİCARET SANAYİ ANONİM ŞİRKETİ
                                                            " placeholder=""></div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="txt_vergi_dairesi">Vergi Dairesi</label><span class="form-note d-none d-md-block">Fatura kesilecek resmi vergi dairesi.</span></div>
                                                </div>
                                                    <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" id="txt_vergi_dairesi" value="ULUDAĞ VERGİ DAİRESİ MÜD." placeholder=""></div>
                                                    </div>
                                                </div>
                                            </div>
                
                                            
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="txt_adres">Fatura Adresi</label><span class="form-note d-none d-md-block">Fatura kesilecek resmi fatura adresi.</span></div>
                                                </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-lg" name="txt_adres" id="txt_adres" cols="30" rows="5">VEYSEL KARANİ MAH. 9.İNCİ SK. NO: 18 İÇ KAPI NO: 1 OSMANGAZİ/ BURSA</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="ddl_ulke">Ülke</label><span class="form-note d-none d-md-block">Fatura adresinin ülkesi.</span></div>
                                                </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <select id="ddl_ulke" name="ddl_ulke" class="form-select js-select2" data-ui="lg" data-search="on">
                                                                <option value="TR" selected>
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
                                                    <div class="form-group"><label class="form-label" for="ddl_ulke">İl / İlçe</label><span class="form-note d-none d-md-block">Gözükecek ürün kodu.</span></div>
                                                </div>
                                                <div class="col-lg-3 col-xxl-3 col-6 mt-0 mt-md-2">
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
                                                            <option selected value="Bursa" data-plaka="16">
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
                
                                                    <div class="col-lg-4 col-xxl-4 col-6 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <select id="musteri_ilce" name="musteri_ilce" class="form-select js-select2" data-ui="lg" data-placeholder="İlçe Seçiniz" data-search="on">
                                                                <option selected>Osmangazi</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="txt_postakodu">Posta Kodu</label><span class="form-note d-none d-md-block">Fatura adresinin posta kodu.</span></div>
                                                </div>
                                                <div class="col-lg-3 col-xxl-3 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-lg" id="txt_postakodu" value="16000" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="txt_eposta">E-posta</label><span class="form-note d-none d-md-block">Carinin faturalarının gönderileceği e-posta adresi.</span></div>
                                                </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" id="txt_eposta" value="info@famsotomotiv.com" placeholder=""></div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="txt_telefon">Telefon</label><span class="form-note d-none d-md-block">Carinin faturalarının gönderileceği e-posta adresi.</span></div>
                                                </div>
                                                    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
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
                                                            <input type="text" class="form-control form-control-lg" aria-label="Text input with dropdown button" placeholder="224 214 00 40"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="ddl_parabirimi">Para Birimi</label><span class="form-note d-none d-md-block">Cari ile çalışmak istediğiniz para birimi.</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <select id="sltc_para_birimi" name="doviz" class="form-select js-select2" data-ui="lg" data-search="on" data-val="TRY">
                                                            <option value="AFN">Afghani</option>
                                                            <option value="DZD">Algerian Dinar</option>
                                                            <option value="ARS">Argentine Peso</option>
                                                            <option value="AWG">Aruban Guilder</option>
                                                            <option value="AUD">Australian Dollar</option>
                                                            <option value="AZM">Azerbaijanian Manat</option>
                                                            <option value="BSD">Bahamian Dollar</option>
                                                            <option value="BHD">Bahraini Dinar</option>
                                                            <option value="THB">Baht</option>
                                                            <option value="PAB">Balboa</option>
                                                            <option value="BBD">Barbados Dollar</option>
                                                            <option value="BYR">Belarussian Ruble</option>
                                                            <option value="BZD">Belize Dollar</option>
                                                            <option value="BMD">Bermudian Dollar</option>
                                                            <option value="VEB">Bolivar</option>
                                                            <option value="BOB">Boliviano</option>
                                                            <option value="BGN">Bulgarian Lev</option>
                                                            <option value="BRL">Brazilian Real</option>
                                                            <option value="BND">Brunei Dollar</option>
                                                            <option value="BIF">Burundi Franc</option>
                                                            <option value="CAD">Canadian Dollar</option>
                                                            <option value="CVE">Cape Verde Escudo</option>
                                                            <option value="KYD">Cayman Islands Dollar</option>
                                                            <option value="GHC">Cedi</option>
                                                            <option value="XAF">CFA Franc</option>
                                                            <option value="XOF">CFA Franc</option>
                                                            <option value="XPF">CFP Franc</option>
                                                            <option value="CLP">Chilean Peso</option>
                                                            <option value="COP">Colombian Peso</option>
                                                            <option value="KMF">Comoro Franc</option>
                                                            <option value="NIO">Cordoba Oro</option>
                                                            <option value="CRC">Costa Rican Colon</option>
                                                            <option value="CUP">Cuban Peso</option>
                                                            <option value="CYP">Cyprus Pound</option>
                                                            <option value="CZK">Czech Koruna</option>
                                                            <option value="DKK">Danish Krone</option>
                                                            <option value="GMD">Dalasi</option>
                                                            <option value="MKD">Denar</option>
                                                            <option value="AED">Dirham</option>
                                                            <option value="DJF">Djibouti Franc</option>
                                                            <option value="STD">Dobra</option>
                                                            <option value="DOP">Dominican Peso</option>
                                                            <option value="VND">Dong</option>
                                                            <option value="AMD">Dram</option>
                                                            <option value="XCD">East Carribean Dollar</option>
                                                            <option value="EGP">Egyptian Pound</option>
                                                            <option value="SVC">El Salvador Colon</option>
                                                            <option value="ETB">Ethopian Birr</option>
                                                            <option value="EUR">Euro</option>
                                                            <option value="FKP">Falkland Islands Pound</option>
                                                            <option value="FJD">Fiji Dollar</option>
                                                            <option value="HUF">Forint</option>
                                                            <option value="CDF">Franc Congolais</option>
                                                            <option value="GIP">Gibraltar Pound</option>
                                                            <option value="XAU">Gold</option>
                                                            <option value="HTG">Gourde</option>
                                                            <option value="PYG">Guarani</option>
                                                            <option value="GNF">Guinea Franc</option>
                                                            <option value="GYD">Guyana Dollar</option>
                                                            <option value="HKD">HKD</option>
                                                            <option value="UAH">Hryvnia</option>
                                                            <option value="ISK">Iceland Krona</option>
                                                            <option value="INR">Indian Rupee</option>
                                                            <option value="IQD">Iraqi Dinar</option>
                                                            <option value="IRR">Iranian Rial</option>
                                                            <option value="JMD">Jamaican Dollar</option>
                                                            <option value="JOD">Jordanian Dinar</option>
                                                            <option value="KES">Kenyan Shilling</option>
                                                            <option value="PGK">Kina</option>
                                                            <option value="LAK">Kip</option>
                                                            <option value="EEK">Kroon</option>
                                                            <option value="HRK">Kuna</option>
                                                            <option value="KWD">Kuwaiti Dinar</option>
                                                            <option value="MWK">Kwacha</option>
                                                            <option value="ZMK">Kwacha</option>
                                                            <option value="AOA">Kwanza</option>
                                                            <option value="MMK">Kyat</option>
                                                            <option value="GEL">Lari</option>
                                                            <option value="LVL">Latvian Lats</option>
                                                            <option value="LBP">Lebanese Pound</option>
                                                            <option value="ALL">Lek</option>
                                                            <option value="HNL">Lempira</option>
                                                            <option value="SLL">Leone</option>
                                                            <option value="ROL">Leu</option>
                                                            <option value="LRD">Liberian Dollar</option>
                                                            <option value="LYD">Libyan Dinar</option>
                                                            <option value="SZL">Lilangeni</option>
                                                            <option value="LTL">Lithuanian Litas</option>
                                                            <option value="LSL">Loti</option>
                                                            <option value="MGF">Malagasy Franc</option>
                                                            <option value="MYR">Malaysian Ringgit</option>
                                                            <option value="MTL">Maltese Lira</option>
                                                            <option value="TMM">Manat</option>
                                                            <option value="MUR">Mauritius Rupee</option>
                                                            <option value="MZM">Metical</option>
                                                            <option value="MXN">Mexican Peso</option>
                                                            <option value="MDL">Moldovan Leu</option>
                                                            <option value="MAD">Morrocan Dirham</option>
                                                            <option value="NGN">Naira</option>
                                                            <option value="ERN">Nakfa</option>
                                                            <option value="NAD">Namibia Dollar</option>
                                                            <option value="NPR">Nepalese Rupee</option>
                                                            <option value="ANG">Netherlands Antillian Guilder</option>
                                                            <option value="YUM">New Dinar</option>
                                                            <option value="ILS">New Israeli Sheqel</option>
                                                            <option value="TWD">New Taiwan Dollar</option>
                                                            <option value="NZD">New Zealand Dollar</option>
                                                            <option value="KPW">North Korean Won</option>
                                                            <option value="NOK">Norwegian Krone</option>
                                                            <option value="BTN">Ngultrum</option>
                                                            <option value="PEN">Nuevo Sol</option>
                                                            <option value="MRO">Ouguiya</option>
                                                            <option value="TOP">Pa&amp;amp;apos;anga</option>
                                                            <option value="PKR">Pakistan Rupee</option>
                                                            <option value="XPD">Palladium</option>
                                                            <option value="MOP">Pataca</option>
                                                            <option value="UYU">Peso Uruguayo</option>
                                                            <option value="PHP">Philippine Peso</option>
                                                            <option value="XPT">Platinum</option>
                                                            <option value="GBP">Pound Sterling</option>
                                                            <option value="BWP">Pula</option>
                                                            <option value="QAR">Qatari Rial</option>
                                                            <option value="GTQ">Quetzal</option>
                                                            <option value="ZAR">Rand</option>
                                                            <option value="OMR">Rial Omani</option>
                                                            <option value="KHR">Riel</option>
                                                            <option value="MVR">Rufiyaa</option>
                                                            <option value="RON">Rumen Leyi</option>
                                                            <option value="IDR">Rupiah</option>
                                                            <option value="RUB">Russian Ruble</option>
                                                            <option value="RWF">Rwanda Franc</option>
                                                            <option value="SAR">Saudi Riyal</option>
                                                            <option value="XDR">SDR</option>
                                                            <option value="SCR">Seychelles Rupee</option>
                                                            <option value="XAG">Silver</option>
                                                            <option value="SGD">Singapore Dollar</option>
                                                            <option value="SKK">Slovak Koruna</option>
                                                            <option value="SBD">Solomon Islands Dollar</option>
                                                            <option value="SOS">Somali Shilling</option>
                                                            <option value="LKR">Sri Lanka Rupee</option>
                                                            <option value="KGS">Som</option>
                                                            <option value="TJS">Somoni</option>
                                                            <option value="SHP">St. Helena Pound</option>
                                                            <option value="SDD">Sudanese Dinar</option>
                                                            <option value="SRG">Suriname Guilder</option>
                                                            <option value="SEK">Swedish Krona</option>
                                                            <option value="CHF">Swiss Franc</option>
                                                            <option value="SYP">Syrian Pound</option>
                                                            <option value="BDT">Taka</option>
                                                            <option value="WST">Tala</option>
                                                            <option value="TZS">Tanzanian Shilling</option>
                                                            <option value="KZT">Tenge</option>
                                                            <option value="SIT">Tolar</option>
                                                            <option value="TTD">Trinidad and Tobago Dollar</option>
                                                            <option value="MNT">Tugrik</option>
                                                            <option value="TND">Tunisian Dinar</option>
                                                            <option selected value="TRY">Türk Lirası</option>
                                                            <option value="UGX">Uganda Shilling</option>
                                                            <option value="USD">US Dollar</option>
                                                            <option value="UZS">Uzbekistan Sum</option>
                                                            <option value="VUV">Vatu</option>
                                                            <option value="KRW">Won</option>
                                                            <option value="YER">Yemeni Rial</option>
                                                            <option value="JPY">Yen</option>
                                                            <option value="CNY">Yuan Renminbi</option>
                                                            <option value="ZWD">Zimbabwe Dollar</option>
                                                            <option value="PLN">Zloty</option>
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                          
                                            
                                            
                                          
                
                                            
                                            
                                        </div>
                                    </div><!-- .card-inner -->
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <!-- <a href="javascript:history.back()" class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Geri</span></a>  -->
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <div class="form-group">
                                                    <button type="submit" id="yeniUrun" class="btn btn-lg btn-primary">Kaydet</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                </form>
                              
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

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>

</script>

<?= $this->endSection() ?>