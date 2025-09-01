<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Yeni Fatura <?= $this->endSection() ?>
<?= $this->section('title') ?> Yeni Fatura | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>


<?= $this->section('styles') ?>

<style>
    
    .dataTables_filter {
        margin-left: 10px;
        width: 300px !important;
        padding: 10px !important;
    }
    .dataTables_scroll
    {
        overflow:auto;
    }

    /* Modern tablo stilleri */
#modalEskiFiyatlar .table {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 0;
}
#modalEskiFiyatlar th, #modalEskiFiyatlar td {
    vertical-align: middle;
    text-align: center;
}
#modalEskiFiyatlar th {
    background: #f1f3fa;
    font-weight: 600;
    color: #013caa;
    border-bottom: 2px solid #e3e6f0;
}
#modalEskiFiyatlar tr {
    border-bottom: 1px solid #f1f3fa;
}
#modalEskiFiyatlar .alert {
    border-radius: 8px;
}
</style>

<?= $this->endSection() ?>



<?= $this->section('main') ?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="components-preview wide-xl mx-auto">

                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner p-4">
                            <form onsubmit="return false;" id="createInvoice" method="post" autocomplete="off">
                                <ul class="nav nav-tabs mt-n3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1" aria-selected="false" role="tab" tabindex="-1"><em class="icon ni ni-users-fill"></em><span>Cari Bilgileri</span></a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tabItem2" aria-selected="false" role="tab" tabindex="-1"><em class="icon ni ni-file-fill"></em><span>Fatura Bilgileri</span></a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link " data-bs-toggle="tab" href="#tabItem3" aria-selected="true" role="tab"><em class="icon ni ni-file-text-fill"></em><span>Fatura Satırları</span></a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="tabItem1" role="tabpanel">

                                        <div class="row g-3 align-center mb-2">
                                            <div class="col-lg-5 col-xxl-5 col-8 ">
                                                <div class="form-group"><label class="form-label" for="is_export_customer">İhracat Müşterisi</label>
                                                    <span class="form-note d-none d-md-block">Eğer bu müşteri ihracat müşteriniz ise işaretleyiniz..</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-5 col-4  mt-0 mt-md-2">
                                                <div class="custom-control custom-control-lg custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="is_export_customer" name="is_export_customer">
                                                    <label class="custom-control-label" for="is_export_customer">
                                                        Evet
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center mb-2">
                                            <div class="col-lg-5 col-xxl-5 col-8 ">
                                                <div class="form-group"><label class="form-label" for="chx_sorgulama">Sorgulamadan Devam Et</label>
                                                    <span class="form-note d-none d-md-block"> Bilgileri kendim gireceğim.<br>(Bu müşteriye oluşturulacak faturalardaki hatalara dikkat ediniz.)</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-5 col-4  mt-0 mt-md-3">
                                                <div class="custom-control custom-control-lg custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="chx_sorgulama" name="chx_sorgulama">
                                                    <label class="custom-control-label" for="chx_sorgulama">
                                                        Evet
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group"><label class="form-label" for="identification_number">T.C./Vergi No</label>
                                                    <span class="form-note d-none d-md-block">Bu bilgiyi doğru girip sorgularsanız<br>ünvan ve vergi dairesi gibi bilgiler otomatik gelecektir.</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-6 mt-0 mt-md-2">
                                                <div class="input-group">
                                                    <input type="text" class="form-control  form-control-lg form-control-lg" id="identification_number" name="identification_number" placeholder="T.C. veya Vergi No Giriniz.." maxlength="11" value="">
                                                    <div class="input-group-append">
                                                        <button id="btn_musteriSorgulaNew"  class="btn btn-lg btn-block btn-dim btn-outline-light" >Sorgula
                                                        </button>
                                                        <button id="btn_musteriSec" data-bs-toggle="modal" data-bs-target="#mdl_musteriSec" class="btn btn-lg btn-block  btn-dim btn-outline-primary">
                                                            Seç
                                                        </button>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="customer_info_area" class="d-none gy-2">
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
                                                                <option value="e-archive">E-Arşiv Fatura</option>
                                                                <option value="e-invoice">E-Fatura</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-6 col-6 mt-0 mt-md-2 ps-1">
                                                        <div class="form-group">
                                                            <select id="company_type" name="company_type" class="form-select js-select2" data-ui="lg" data-placeholder="Şirket Tipi Seçiniz" data-search="on">
                                                                <option></option>
                                                                <option value="person">Şahıs</option>
                                                                <option value="company">Şirket</option>
                                                                <option value="public">Kamu</option>
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
                                                            <input type="text" class="form-control  form-control-lg form-control-lg" name="invoice_title" id="invoice_title" value="" placeholder="Fatura Ünvanı">
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
                                                        <input type="text" class="form-control  form-control-lg form-control-lg" id="name" name="name" value="" placeholder="Adı">
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control  form-control-lg form-control-lg" id="surname" name="surname" value="" placeholder="Soyadı">
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="cari_id" id="cari_id">


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
                                                            <input type="text" class="form-control  form-control-lg form-control-lg" name="tax_administration" id="tax_administration" value="" placeholder="Vergi Dairesi">
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
                                                            <textarea class="form-control  form-control-lg form-control-lg" name="address" id="address" cols="30" rows="5" placeholder="Fatura Adresi"></textarea>
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
                                                        <input type="hidden" class="manuelUlke form-control  form-control-lg form-control-lg" placeholder="İl Giriniz"  name="address_city_name" id="address_city_name" value="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xxl-4 col-6 mt-0 mt-md-2">
                                                <div class="form-control-wrap" id="IlceDegisiklik">
                                                <select id="Ilceler" name="address_district" class="form-select js-select2 otomatikUlke" data-ui="lg" data-search="on" data-placeholder="İlçe Seçiniz" disabled="disabled">
                                                            <option value="0">Önce il seçiniz</option>
                                                        </select>
                                                        
                                                                <input type="hidden" class="manuelUlke form-control  form-control-lg form-control-lg" placeholder="İlçe Giriniz"  name="address_district" id="address_district" value="">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="zip_code">Posta
                                                            Kodu</label><span class="form-note d-none d-md-block">Fatura
                                                            adresinin posta
                                                            kodu.</span></div>
                                                </div>
                                                <div class="col-lg-3 col-xxl-3 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control  form-control-lg form-control-lg" id="zip_code" name="zip_code" value="" placeholder="Posta Kodu">
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
                                                        <div class="form-control-wrap"><input type="text" class="form-control  form-control-lg form-control-lg" id="cari_email" value="" placeholder="Cari e-posta" name="cari_email">
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
                                                            <input type="text" class="form-control  form-control-lg form-control-lg" name="cari_phone" id="cari_phone" aria-label="Carinin iletişim için telefon numarası" placeholder="000 000 0000" onkeypress="return SadeceRakam(event,['-'],'');">
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
                                                                <input type="checkbox" class="custom-control-input" name="is_customer_save" checked id="is_customer_save">
                                                                <label class="custom-control-label" for="is_customer_save">
                                                                    Evet
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-5 bg-white">
                                            <!-- <button type="button" class="btn btn-secondary mb-2 btnPrevious" id="prevButton">Önceki</button> -->
                                            <button type="button" class="btn btn-primary mb-2 btnNext" id="nextButton">Sonraki</button>
                                        </div>

                                    </div>

                                    <div class="tab-pane" id="tabItem2" role="tabpanel">

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5  ">
                                                <div class="form-group"><label class="form-label" for="site-name">Fatura Türü</label>
                                                    <span class="form-note d-none d-md-block">Faturayı siz mi kesiyor sunuz? Size mi kesiliyor?</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                <ul class="custom-control-group">
                                                    <li>
                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                            <input type="radio" class="custom-control-input ftr_turu" name="ftr_turu" value="outgoing_invoice" id="ftr_satis" checked>
                                                            <label class="custom-control-label" for="ftr_satis">Satış (Giden)</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                            <input type="radio" class="custom-control-input ftr_turu" name="ftr_turu" value="incoming_invoice" id="ftr_alis">
                                                            <label class="custom-control-label" for="ftr_alis">Alış(Gelen)</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center d-none">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group"><label class="form-label" for="invoice_ettn">Fatura Ettn</label></div>
                                            </div>
                                            <div class="col-lg-7 col-xxl-5 mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control  form-control-lg form-control-lg" name="invoice_ettn" id="invoice_ettn" value="<?= get_uuid() ?>" placeholder="Fatura Ettn Numarası" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="fatura_para_birimi">Fatura Para Birimi</label>
                                                    <span class="form-note d-none d-md-block">Fatura para birimi seçiniz</span>
                                                </div>
                                            </div>


                                            <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group">

                                                        <select class="form-select form-select-lg js-select2 form-control slct_doviz_tipi" data-ui="lg" data-search="on" id="slct_doviz_tipi" satir="0" data-ui="lg" data-placeholder="Seçiniz">
                                                            <option></option>
                                                            <?php foreach ($money_unit_items as $money_unit_item) { ?>
                                                                <option value="<?= $money_unit_item['money_unit_id'] ?>" data-money-unit-code="<?= $money_unit_item['money_code'] ?>" data-money-unit-icon="<?= $money_unit_item['money_icon'] ?>" <?php if ($money_unit_item['default'] == 'true') {
                                                                                                                                                                                                                                                        echo "selected";
                                                                                                                                                                                                                                                    } ?>>
                                                                    <?= $money_unit_item['money_code'] ?> -
                                                                    <?= $money_unit_item['money_title'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <input type="hidden" id="base_slct_doviz_tipi" value="3">

                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xxl-5 col-4 mt-0 mt-md-2 ps-1 d-none" id="txt_doviz_kuru_area">
                                                    <div class="input-group">
                                                        <input type="text" name="txt_doviz_kuru" id="txt_doviz_kuru" class="form-control form-control-lg form-control-lg text-end doviz_degis "  placeholder="0,0000" onkeypress="return SadeceRakam(event,[',']);">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="txt_doviz_kurum">TRY</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row g-3 align-center" id="fatura_seri_alanı">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="fatura_seri">Fatura Seri</label>
                                                    <span class="form-note d-none d-md-block">Fatura seri seçiniz.</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group mb-0" id="fatura_seri_area">
                                                        <select class="form-select form-select-lg js-select2" id="fatura_seri" name="fatura_seri" data-ui="lg" data-search="on" data-placeholder="Fatura Seri Seçiniz">
                                                            <option value=""></option>
                                                        </select>

                                                    </div>
                                                    <input type="text" class="form-control form-control-lg form-control-lg d-none" id="customInvoiceNo" name="customInvoiceNo" value="" placeholder="Fatura Numarası Giriniz">
                                                </div>

                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 ps-1">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-control-sm custom-checkbox custom-control-pro" data-toggle="tooltip" data-placement="top" title="Varsa fatura numarasını giriniz, yoksa otomatik olarak oluşturulacaktır.">
                                                            <input type="checkbox" class="custom-control-input" name="is_customInvoiceNo" id="is_customInvoiceNo">
                                                            <label class="custom-control-label" for="is_customInvoiceNo">Fatura Numarası Gir</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="obligation">Fatura Tarihi</label>
                                                    <span class="form-note d-none d-md-block">Fatura tarihi seçiniz.</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                            </div>
                                                            <input type="text" class="form-control  form-control-lg form-control-lg date-picker" name="invoice_date" value="<?= date('d/m/Y') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xxl-5 col-4 mt-0 mt-md-2 ps-1">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni icon-lg ni-clock"></em>
                                                            </div>
                                                            <input type="text" class="form-control  form-control-lg form-control-lg time-picker" name="invoice_time" value="<?= date('H:i') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group"><label class="form-label" for="fatura_senaryo">Fatura Tipi</label>
                                                    <span class="form-note d-none d-md-block">Fatura tipini seçiniz.</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group">
                                                        <select class="form-select js-select2" id="fatura_senaryo" name="fatura_senaryo" data-ui="lg" data-search="on" data-placeholder="Fatura Tipi Seçiniz">
                                                            <option value="TEMELFATURA">TEMEL FATURA</option>
                                                            <option value="TICARIFATURA">TİCARİ FATURA</option>
                                                            <option value="EARSIVFATURA">E-ARŞİV FATURA</option>
                                                            <option value="KAMU">KAMU</option>
                                                            <option value="IHRACAT">İHRACAT</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xxl-5 col-4 mt-0 mt-md-2 ps-1">
                                                    <div class="form-group">
                                                        <select id="fatura_tipi" name="fatura_tipi" class="form-select js-select2" data-ui="lg" data-placeholder="Fatura Tipi Seçiniz" data-search="on">
                                                            <option value="SATIS">SATIŞ</option>
                                                            <option value="IADE">İADE</option>
                                                            <option value="TEVKIFAT">TEVKİFAT</option>
                                                            <option value="ISTISNA">İSTİSNA</option>
                                                            <option value="IADEISTISNA">İADE - İSTİSNA</option>
                                                            <option value="OZELMATRAH">ÖZEL MATRAH</option>
                                                            <option value="IHRACKAYITLI">İHRAÇ KAYITLI</option>
                                                        </select>
                                                        <input type="hidden" id="base_fatura_tipi" value="SATIS">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center d-none" id="iadeSatirOrnek">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group">
                                                    <label class="form-label">İade Tarihi / No</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                            </div>
                                                            <input type="text" class="form-control form-control-lg date-picker" id="txt_iade_tarihi_" name="txt_iade_tarihi_" value="<?= date('d/m/Y') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xxl-5 col-4 mt-0 mt-md-2 ps-1">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni icon-lg ni-article"></em>
                                                            </div>
                                                            <input type="text" class="form-control form-control-lg" id="txt_iade_fatura_no_" name="txt_iade_fatura_no_" value="" placeholder="Fatura Numarası">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-2" style="margin-left: 10px; align-self:center;">
                                                    <div class="row g-1">
                                                        <div class="col-6 text-center">
                                                            <button id="iade_satir_ekle" class="btn btn-icon btn-primary btn-block iade_satir_ekle"><em class="icon ni ni-plus"></em></button>
                                                        </div>
                                                        <div class="col-6 pl-sm-1 text-center">
                                                            <button id="iade_satir_sil" class="btn btn-icon btn-danger btn-block iade_satir_sil"><em class="icon ni ni-trash"></em></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="iadeBilgileriBlocks" class="d-none">
                                            <input id="iade_str_s" type="hidden" value="0">

                                            <div class="row g-3 align-center" id="iadeSatir_0">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label">İade Tarihi / No</label>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                    <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <div class="form-icon form-icon-right">
                                                                    <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                                </div>
                                                                <input type="text" class="form-control form-control-lg date-picker" id="txt_iade_tarihi_0" name="txt_iade_tarihi_0" value="<?= date('d/m/Y') ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xxl-5 col-4 mt-0 mt-md-2 ps-1">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <div class="form-icon form-icon-right">
                                                                    <em class="icon ni icon-lg ni-article"></em>
                                                                </div>
                                                                <input type="text" class="form-control form-control-lg" id="txt_iade_fatura_no_0" name="txt_iade_fatura_no_0" value="" placeholder="Fatura Numarası">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 mt-2" style="margin-left: 10px; align-self:center;">
                                                        <div class="row g-1">
                                                            <div class="col-6 text-center">
                                                                <button id="iade_satir_ekle_" class="btn btn-icon btn-primary btn-block iade_satir_ekle" satir="0" satir_id="0"><em class="icon ni ni-plus"></em></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="faturaIstisnaBlocks" class="d-none">
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label">Fatura İstisna Tipi</label>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                    <div class="col-lg-10 col-xxl-10 col-6 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <select id="istisna_tipi" name="istisna_tipi" class="form-select js-select2" data-ui="lg" data-placeholder="İstisna Tipi Seçiniz" data-search="on">
                                                                    <option></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="ozelMatrahBlocks" class="d-none">
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label">Fatura Özel Matrah</label>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                    <div class="col-lg-10 col-xxl-10 col-6 mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <select id="ozel_matrah_tipi" name="ozel_matrah_tipi" class="form-select js-select2" data-ui="lg" data-placeholder="Fatura Özel Matrah Seçiniz" data-search="on">
                                                                    <option></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center" id="irsaliye_alani">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="is_waybill">İrsaliye</label>
                                                    <span class="form-note d-none d-md-block">Fatura için irsaliye eklemek için seçilmelidir.</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-7  mt-0 mt-md-4">
                                                <ul class="custom-control-group">
                                                    <li>
                                                        <div class="custom-control custom-checkbox custom-control-pro">
                                                            <input type="checkbox" class="custom-control-input" name="is_waybill" id="is_waybill">
                                                            <label class="custom-control-label" for="is_waybill">
                                                                Evet
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center d-none" id="irsaliyeSatirOrnek">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group">
                                                    <label class="form-label">İrsaliye Tarihi / No</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                            </div>
                                                            <input type="text" class="form-control form-control-lg date-picker" id="txt_irsaliye_tarihi_" name="txt_irsaliye_tarihi_" value="<?= date('d/m/Y') ?>">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xxl-5 col-4 mt-0 mt-md-2 ps-1">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni icon-lg ni-article"></em>
                                                            </div>
                                                            <input type="text" class="form-control form-control-lg" id="txt_irsaliye_no_" name="txt_irsaliye_no_" value="" placeholder="İrsaliye Numarası">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-2" style="margin-left: 10px; align-self:center;">
                                                    <div class="row g-1">
                                                        <div class="col-6 text-center">
                                                            <button id="irsaliye_satir_ekle" class="btn btn-icon btn-primary btn-block irsaliye_satir_ekle"><em class="icon ni ni-plus"></em></button>
                                                        </div>
                                                        <div class="col-6 pl-sm-1 text-center">
                                                            <button id="irsaliye_satir_sil" class="btn btn-icon btn-danger btn-block irsaliye_satir_sil"><em class="icon ni ni-trash"></em></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="irsaliyeBilgileriBlocks" class="d-none">
                                            <input id="irsaliye_str_s" type="hidden" value="0">

                                            <div class="row g-3 align-center" id="irsaliyeSatir_0">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label">İrsaliye Tarihi / No</label>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                    <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <div class="form-icon form-icon-right">
                                                                    <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                                </div>
                                                                <input type="text" class="form-control form-control-lg date-picker" id="txt_irsaliye_tarihi_0" name="txt_irsaliye_tarihi_0" value="<?= date('d/m/Y') ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xxl-5 col-4 mt-0 mt-md-2 ps-1">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <div class="form-icon form-icon-right">
                                                                    <em class="icon ni icon-lg ni-article"></em>
                                                                </div>
                                                                <input type="text" class="form-control form-control-lg" id="txt_irsaliye_no_0" name="txt_irsaliye_no_0" value="" placeholder="İrsaliye Numarası">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 mt-2" style="margin-left: 10px; align-self:center;">
                                                        <div class="row g-1">
                                                            <div class="col-6 text-center">
                                                                <button id="irsaliye_satir_ekle_" class="btn btn-icon btn-primary btn-block irsaliye_satir_ekle" satir="0" satir_id="0"><em class="icon ni ni-plus"></em></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="is_maturity">Vade Tarihi</label>
                                                    <span class="form-note d-none d-md-block">Fatura için vade tarihi eklemek için seçilmelidir.</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-7  mt-0 mt-md-4">
                                                <ul class="custom-control-group">
                                                    <li>
                                                        <div class="custom-control custom-checkbox custom-control-pro">
                                                            <input type="checkbox" class="custom-control-input" name="is_maturity" id="is_maturity">
                                                            <label class="custom-control-label" for="is_maturity">
                                                                Evet
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center d-none" id="is_maturity_area">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group"><label class="form-label" for="is_maturity_date">Vade
                                                        Tarihi / Ödeme Şekli</label><span class="form-note d-none d-md-block"></span></div>
                                            </div>
                                            <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                            </div>
                                                            <input type="text" class="form-control  form-control-lg form-control-lg date-picker" name="expiry_date" value="<?= date('d/m/Y') ?>" placeholder="Vade Tarihi">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 ps-1 pe-1">
                                                    <div class="form-group">
                                                        <select id="" name="maturity_payment_method" class="form-select js-select2" data-ui="lg">
                                                            <option value="credit_card/bank_card">
                                                                Kredi Kartı / Banka Kartı
                                                            </option>
                                                            <option value="eft/transfer">
                                                                EFT / Havale
                                                            </option>
                                                            <option value="pay_at_door">
                                                                Kapıda Ödeme
                                                            </option>
                                                            <option value="others">
                                                                Diğerleri
                                                            </option>
                                                        </select>

                                                       
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="mt-5 bg-white">
                                            <button type="button" class="btn btn-secondary mb-2 btnPrevious" id="prevButton">Önceki</button>
                                            <button type="button" class="btn btn-primary mb-2 btnNext" id="nextButton">Sonraki</button>
                                        </div>

                                    </div>

                                    <div class="tab-pane " id="tabItem3" role="tabpanel">

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-3 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="obligation">Hızlı Satış Fişi</label>
                                                    <span class="form-note d-none d-md-block">Hızlı satış fişi olarak kullan</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="chx_quickSale" name="chx_quickSale">
                                                            <label class="custom-control-label" for="chx_quickSale">
                                                                Evet
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center" id="warehouse_area">
                                            <div class="col-lg-5 col-xxl-3 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="fatura_para_birimi">Depo Seç</label>
                                                    <span class="form-note d-none d-md-block">Depo seçiniz</span>
                                                </div>
                                            </div>


                                            <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group">

                                                    <select class="form-select init-select2" data-search="on" name="warehouse_id" id="warehouse_id">
                                                        <option value="" disabled>Lütfen Seçiniz</option>
                                                        <?php foreach ($warehouse_items as $warehouse_item) { ?>
                                                            <option value="<?= $warehouse_item['warehouse_id'] ?>" <?php if ($warehouse_item['default'] != 'true') {
                                                                                                                        echo 'disabled';
                                                                                                                    } ?>>
                                                                <?= $warehouse_item['warehouse_title'] ?></option>
                                                        <?php } ?>
                                                    </select>

                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xxl-5 col-4 mt-0 mt-md-2 ps-1 d-none" id="txt_doviz_kuru_area">
                                                    <div class="input-group">
                                                        <input type="text" name="txt_doviz_kuru" id="txt_doviz_kuru" class="form-control form-control-lg form-control-lg text-end " placeholder="0,0000" onkeypress="return SadeceRakam(event,[',']);">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="txt_doviz_kuru">TRY</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <hr>


                                        <div class="row no-gutters mb-2 mt-4 ftr_str d-none" id="Satir_Ornek" visible="false">
                                            <div class="col-lg-11">
                                                <div class="row no-gutter">
                                                    <div class="col-lg-3 col-sm-6 pe-sm-1">
                                                        <div class="form-group">
                                                            <label class="form-label d-lg-none mt-2 mb-0" for="txt_aciklama">Ürün/Hizmet/Açıklama</label>
                                                            <div class="form-control-wrap">
                                                                <div class="input-group">
                                                                    <input type="text" satir="" class="form-control  " urun_id="0" str_id="0" id="txt_aciklama_" value="">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-outline-primary btn-dim btn_urun_sec" data-satir="" id="btn_urunSec"><span>Seç</span></button>
                                                                        <button class="btn  btn-outline-primary btn-dim btn_urun_eski_fiyat" data-satir="0" data-urun_id="0" id="btn_urunEskiFiyat" disabled><span><i class="icon ni ni-sign-try"></i></span></button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-6 pe-sm-1 ps-sm-0">
                                                        <div class="row  g-1">
                                                            <div class="col-lg-3 col-4">
                                                                <div class="form-group">
                                                                    <label class="form-label d-lg-none mt-2 mb-0" for="txt_miktar">Miktar</label>

                                                                    <div class="form-control-wrap ">
                                                                        <input type="text" class="form-control   text-end px-1 ftr_hesap para" placeholder="0" id="txt_miktar_" satir="" onkeypress="return SadeceRakam(event,[',']);">
                                                                    </div>
                                                                    <input type="hidden" class="" placeholder="0" id="txt_warehouse_id_" satir="">

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5 col-4">
                                                                <div class="form-group">
                                                                    <label class="form-label d-lg-none mt-2 mb-0" for="txt_birim">Birim</label>
                                                                    <div class="form-control-wrap">
                                                                        <select class="form-select form-select-lg form-control  ftr_select select_birim_yeniFatura" data-ui="lg" data-search="on" id="slct_birim_" satir="" data-ui="lg" data-placeholder="Seçiniz">
                                                                            <option></option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-4">
                                                                <label class="form-label d-lg-none mt-2 mb-0" for="txt_birim_fiyat">Birim Fiyat</label>

                                                                <div class="form-group">
                                                                    <div class="form-control-wrap ">
                                                                        <input type="text" class="form-control   text-end px-1 ftr_hesap para" id="txt_birim_fiyat_" placeholder="0,00" satir="" onkeypress="return SadeceRakam(event,[',']);">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-sm-4 col-md-4 col-8 pe-sm-1 ps-sm-2 ps-lg-0">
                                                        <div class="row g-1">
                                                            <div class="col-lg-6 col-6">
                                                                <div class="form-group">
                                                                    <label class="form-label d-lg-none mt-2 mb-0" for="txt_iskonto_orani">İsk. Oranı</label>

                                                                    <div class="form-control-wrap ">
                                                                        <input type="text" class="form-control   text-end px-1 ftr_hesap para ftr_hesap para ftr_hesap_iskonto_yuzde" placeholder="0" id="txt_iskonto_orani_" satir="" onkeypress="return SadeceRakam(event,[',']);">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-6">
                                                                <div class="form-group">
                                                                    <label class="form-label d-lg-none mt-2 mb-0" for="txt_iskonto_tutari">İsk. Tutarı</label>

                                                                    <div class="form-control-wrap ">
                                                                        <input type="text" class="form-control   text-end px-1 ftr_hesap para ftr_hesap para ftr_hesap_iskonto_tutar" id="txt_iskonto_tutari_" placeholder="0,00" satir="" onkeypress="return SadeceRakam(event,[',']);">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-sm-4 col-md-2 col-4 pe-sm-1 ps-sm-0">
                                                        <div class="form-group">
                                                            <label class="form-label d-lg-none mt-2 mb-0" for="txt_ara_toplam">A. Toplam</label>

                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control   text-end px-1 ftr_hesap para" value="0,00" disabled="" id="txt_ara_toplam_" placeholder="" satir="" onkeypress="return SadeceRakam(event,[',']);">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-sm-4 col-8 pe-sm-1 ps-sm-0">
                                                        <div class="row g-1">
                                                            <div class="col-lg-6 col-6">
                                                                <div class="form-group">
                                                                    <label class="form-label d-lg-none mt-2 mb-0" for="slct_kdv">KDV %</label>
                                                                    <div class="form-control-wrap">
                                                                        <select class="form-select form-select-lg form-control  ftr_select ftr_select_yeni_fatura para" data-search="on" id="slct_kdv_" satir="" data-placeholder="Seçiniz">
                                                                            <option></option>
                                                                            <?php foreach (session()->get('tax_rate_items') as $item) { ?>
                                                                                <option value="<?= $item['tax_value'] ?>"> <?= $item['tax_name'] ?> </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <input type="hidden" class="baseFirstTax" id="baseFirstTax_" value="0">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-6 col-6">
                                                                <div class="form-group">
                                                                    <label class="form-label d-lg-none mt-2 mb-0" for="txt_kdv">KDV Tutarı</label>
                                                                    <div class="form-control-wrap ">
                                                                        <input type="text" class="form-control   text-end px-1 para" id="txt_kdv_" placeholder="0,00" satir="" disabled="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-sm-4 col-md-2 col-4 ps-sm-2 ps-md-0">
                                                        <div class="form-group">
                                                            <label class="form-label d-lg-none mt-2 mb-0" for="txt_genel_toplam">G.Toplam</label>
                                                            <div class="form-control-wrap ">
                                                                <input type="text" class="form-control   text-end px-1 genel_toplam_hesapla para" value="0,00" id="txt_genel_toplam_" placeholder="" satir="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-1  pl-lg-2 pl-sm-0">
                                                <div class="row g-1">
                                                    <div class="col-6 text-center">
                                                        <button id="btn_ekle_" class="btn btn-icon btn-primary btn-block satir_ekle" satir=""><em class="icon ni ni-plus"></em></button>
                                                    </div>
                                                    <div class="col-6 ps-sm-1 text-center">
                                                        <button id="btn_sil_" class="btn btn-icon btn-danger btn-block satir_sil" satir=""><em class="icon ni ni-trash"></em>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ÖNEMLİ Bunun seçilmesi için fatura tipi tevkifat olmalı.!!! -->
                                            <div class="col-lg-11 V9015 diger_vergi diger_vergi_sec mt-2" id="tevkifat_area_" satir="0">
                                                <div class="row  g-1">
                                                    <div class="col-lg-5 col-12  pe-sm-1 ps-sm-0">
                                                        <div class="form-group">
                                                            <!-- <label class="form-label mb-0 mt-1" for="txt_V9015_">Tevkifat Kodu</label> -->
                                                            <div class="form-control-wrap">
                                                                <!-- Bu selectin aramalı olmasını istiyorum. -->
                                                                <select class="form-select form-select-lg form-control  tevkifat_tipi slct_tevkifat_tipi" data-search="on" id="slct_tevkifat_tipi_" satir="" data-placeholder="Seçiniz">
                                                                    <option></option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-sm-6 pe-sm-1 ps-sm-0">
                                                        <div class="row  g-1">
                                                            <div class="col-lg-4 col-4">
                                                                <div class="form-group">
                                                                    <!-- <label class="form-label mb-0 mt-1" for="txt_V9015_oran_">Tevkifat %</label> -->
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control   text-end px-1 ftr_hesap para" placeholder="0" id="txt_V9015_oran_" disabled="">

                                                                        <!-- Sadece diğer seceneginde disabled kalkacak oranı kendi girecek. -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5 col-4">
                                                                <div class="form-group">
                                                                    <!-- <label class="form-label mb-0 mt-1" for="txt_V9015_">Tevkifat Tutar</label> -->
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control   text-end px-1 ftr_hesap para" placeholder="0,00" id="txt_V9015_" onkeypress="return SadeceRakam(event,[',']);">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="" id="txt_V9015_islem_tutar_">
                                                    <input type="hidden" name="" id="txt_V9015_hesaplanan_kdv_">
                                                </div>
                                            </div>


                                            <!-- ÖNEMLİ Bunun seçilmesi için fatura tipi istisna olmalı.!!! -->
                                            <div class="col-lg-11 col-sm-12 pr-sm-1 pl-sm-0 gtip" style="display:none">
                                                <div class="row  g-1">
                                                    <div class="col-lg-3 col-12  py-2">
                                                        <div class="form-group">
                                                            <!-- <label class="form-label mb-0 mt-1" for="txt_gtip_">GTİP Kodu</label> -->
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control px-1" placeholder="GTİP Kodunuzu Giriniz" id="txt_gtip_" satir="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div id="fatura_satirlar">

                                            <div class="row no-gutters mb-2 ftr_str " id="Satir_0" visible="true">
                                                <div class="col-lg-11">
                                                    <div class="row no-gutter">
                                                        <div class="col-lg-3 col-sm-6 pe-sm-1">
                                                            <div class="form-group">
                                                                <label class="form-label mt-2 mb-0" for="txt_aciklama_0">Ürün/Hizmet/Açıklama</label>
                                                                <div class="form-control-wrap str_kaldir">
                                                                    <div class="input-group">
                                                                        <input type="text" satir="0" class="form-control   " urun_id="0" str_id="0" id="txt_aciklama_0" value="">
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-outline-primary btn-dim btn_urun_sec" data-satir="0"><span>Seç</span></button>
                                                                            <button class="btn  btn-outline-primary btn-dim btn_urun_eski_fiyat" data-satir="0"  data-urun_id="0" id="btn_urunEskiFiyat" disabled><span><i class="icon ni ni-sign-try"></i></span></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--  <div class="form-control-wrap str_kaldir">
                                                                        <input type="text" satir="0" class="form-control   " str_id="0" id="txt_aciklama_0">
                                                                    </div>  -->
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6 pe-sm-1 ps-sm-0">
                                                            <div class="row  g-1">
                                                                <div class="col-lg-3 col-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label mt-2 mb-0" for="txt_miktar_0">Miktar</label>
                                                                        <div class="form-control-wrap str_kaldir">
                                                                            <input type="text" class="form-control   text-end px-1 ftr_hesap para" placeholder="0" id="txt_miktar_0" satir="0" onkeypress="return SadeceRakam(event,[',']);">
                                                                        </div>
                                                                        <input type="hidden" class="" placeholder="0" id="txt_warehouse_id_0" satir="0">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-5 col-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label mt-2 mb-0 " for="slct_birim_0">Birim</label>
                                                                        <div class="form-control-wrap str_kaldir">
                                                                            <select class="form-select js-select2 form-control  ftr_select select_birim_yeniFatura" data-search="on" id="slct_birim_0" satir="0" data-placeholder="Seçiniz">
                                                                                <option></option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label mt-2 mb-0" for="txt_birim_fiyat_0">Birim Fiyat</label>
                                                                        <div class="form-control-wrap str_kaldir">
                                                                            <input type="text" class="form-control   text-end px-1 ftr_hesap para" id="txt_birim_fiyat_0" placeholder="0,00" satir="0" onkeypress="return SadeceRakam(event,[',']);">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-sm-4 col-md-4 col-8 pe-sm-1 ps-sm-2 ps-lg-0">
                                                            <div class="row g-1">
                                                                <div class="col-lg-6 col-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label mt-2 mb-0" for="txt_iskonto_orani_0">İsk. %</label>
                                                                        <div class="form-control-wrap str_kaldir">
                                                                            <input type="text" class="form-control   text-end px-1 ftr_hesap para ftr_hesap para ftr_hesap_iskonto_yuzde" placeholder="0" id="txt_iskonto_orani_0" satir="0" onkeypress="return SadeceRakam(event,[',']);">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label mt-2 mb-0" for="txt_iskonto_tutari_0">İsk. Tutarı</label>
                                                                        <div class="form-control-wrap str_kaldir">

                                                                            <input type="text" class="form-control   text-end px-1 ftr_hesap para ftr_hesap para txt_iskonto_tutari" id="txt_iskonto_tutari_0" placeholder="0,00" satir="0" onkeypress="return SadeceRakam(event,[',']);">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1 col-sm-4 col-md-2 col-4 pe-sm-1 ps-sm-0">
                                                            <div class="form-group">
                                                                <label class="form-label mt-2 mb-0" for="txt_ara_toplam_0">A. Toplam</label>
                                                                <div class="form-control-wrap str_kaldir">
                                                                    <input type="text" class="form-control   text-end px-1 ftr_hesap para" value="0,00" disabled="" id="txt_ara_toplam_0" placeholder="" satir="0" onkeypress="return SadeceRakam(event,[',']);">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-sm-4 col-8 pe-sm-1 ps-sm-0">
                                                            <div class="row g-1">
                                                                <div class="col-lg-6 col-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label mt-2 mb-0" for="slct_kdv_0">KDV %</label>
                                                                        <div class="form-control-wrap str_kaldir">
                                                                            <select class="form-select form-control js-select2 ftr_select ftr_select_yeni_fatura para" data-search="on" id="slct_kdv_0" satir="0" data-placeholder="Seçiniz">
                                                                               
                                                                                <?php foreach (session()->get('tax_rate_items') as $item) { ?>
                                                                                    <option value="<?= $item['tax_value'] ?>"> <?= $item['tax_name'] ?> </option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <input type="hidden" class="baseFirstTax" id="baseFirstTax_0" value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label mt-2 mb-0" for="txt_kdv_0">KDV Tutarı</label>
                                                                        <div class="form-control-wrap str_kaldir">
                                                                            <input type="text" class="form-control   text-end px-1 para" id="txt_kdv_0" placeholder="0,00" satir="0" disabled="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1 col-sm-4 col-md-2 col-4 ps-sm-2 ps-md-0">
                                                            <div class="form-group">
                                                                <label class="form-label mt-2 mb-0" for="txt_genel_toplam_0">G.Toplam</label>
                                                                <div class="form-control-wrap str_kaldir">
                                                                    <input type="text" class="form-control   text-end px-1 genel_toplam_hesapla para" value="0,00" id="txt_genel_toplam_0" placeholder="" satir="0">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-1  ps-lg-2 ps-sm-0">
                                                    <div class="row g-1">
                                                        <div class="col-6 text-center">
                                                            <label class="form-label mt-2 mb-0" for="btn_ekle_0"><span class=" d-none d-lg-block">Ekle</span></label>

                                                            <button id="btn_ekle_0" class="btn btn-icon btn-primary btn-block satir_ekle str_kaldir" satir="0"><em class="icon ni ni-plus"></em></button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- ÖNEMLİ Bunun seçilmesi için fatura tipi tevkifat olmalı.!!! -->
                                                <div class="col-lg-11 V9015 diger_vergi diger_vergi_sec mt-2" id="tevkifat_area_0" satir="0">
                                                    <div class="row  g-1">
                                                        <div class="col-lg-5 col-12  pe-sm-1 ps-sm-0">
                                                            <div class="form-group">
                                                                <label class="form-label mb-0 mt-1" for="txt_V9015_0">Tevkifat Kodu</label>

                                                                <div class="form-control-wrap">
                                                                    <!-- Bu selectin aramalı olmasını istiyorum. -->
                                                                    <select class="form-select form-select-lg form-control  tevkifat_tipi slct_tevkifat_tipi" data-search="on" id="slct_tevkifat_tipi_0" satir="0" data-placeholder="Seçiniz">
                                                                        <option></option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3 col-sm-6 pe-sm-1 ps-sm-0">
                                                            <div class="row  g-1">
                                                                <div class="col-lg-4 col-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label mb-0 mt-1" for="txt_V9015_oran_0">Tevkifat %</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" class="form-control   text-end px-1 ftr_hesap para" placeholder="0" id="txt_V9015_oran_0" disabled="">

                                                                            <!-- Sadece diğer seceneginde disabled kalkacak oranı kendi girecek. -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-5 col-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label mb-0 mt-1" for="txt_V9015_oran_0">Tevkifat Tutar</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" class="form-control   text-end px-1 ftr_hesap para" placeholder="0,00" id="txt_V9015_0" onkeypress="return SadeceRakam(event,[',']);">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="" id="txt_V9015_islem_tutar_0">
                                                        <input type="hidden" name="" id="txt_V9015_hesaplanan_kdv_0">

                                                    </div>
                                                </div>

                                                <!-- ÖNEMLİ Bunun seçilmesi için fatura tipi istisna olmalı.!!! -->
                                                <div class="col-lg-11 col-sm-12 pr-sm-1 pl-sm-0 gtip" style="display:none">
                                                    <div class="row  g-1">
                                                        <div class="col-lg-3 col-12  py-2">
                                                            <div class="form-group">
                                                                <label class="form-label mb-0 mt-1" for="txt_gtip_0">GTİP Kodu</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control px-1" placeholder="GTİP Kodunuzu Giriniz" id="txt_gtip_0" satir="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                        <hr>


                                        <div class="row no-gutters mt-1">

                                            <div class="col-lg-7">

                                                <div class="form-group">
                                                    <label class="form-label mt-2 mb-0" for="total_to_text">Toplam Tutar Yazıyla</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-lg px-1" placeholder="" name="total_to_text" id="total_to_text" disabled="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label mt-2 mb-0 " for="slct_invoice_note">Not Seçin</label>
                                                    <div class="form-control-wrap str_kaldir">
                                                        <select class="form-select form-select-lg form-control" data-ui="lg" data-search="on" id="slct_invoice_note" data-placeholder="Seçiniz">
                                                            <option value="0">seçiniz</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group d-none" id="fatura_not_baslik_area">
                                                    <label class="form-label mb-0" for="txt_fatura_not_baslik">Fatura Notu Başlığı</label>
                                                    <div class="form-control-wrap str_kaldir">
                                                        <input class="form-control form-control-lg" id="txt_fatura_not_baslik" name="txt_fatura_not_baslik" placeholder="Fatura Notu Başlığı Yazınız">
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

                                                <div class="form-group">
                                                    <div class="custom-control custom-control-lg custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" checked id="chk_musteri_bakiye_ekle" name="chk_musteri_bakiye_ekle">
                                                        <label class="custom-control-label" for="chk_musteri_bakiye_ekle">
                                                            <strong>Müşteri Bakiyesini</strong> nota ekle
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">

                                                <div class="row no-gutter mt-1">
                                                    <div class="col-lg-7 col-sm-4 col-6 pr-sm-2 pl-sm-0 text-end">
                                                        <label class="form-label mt-2 mb-1 " for="txt_kdvsiz_toplam">Ürün/Hizmet Toplam</label>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-4 col-md-2 col-6 pl-sm-2 pl-md-0 text-end">

                                                        <div class="input-group">
                                                            <input type="text" name="txt_kdvsiz_toplam" id="txt_kdvsiz_toplam" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" onkeypress="return SadeceRakam(event,[',']);" disabled="">
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
                                                            <input type="text" name="txt_iskonto_toplam" id="txt_iskonto_toplam" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" onkeypress="return SadeceRakam(event,[',']);" disabled="">
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
                                                            <input type="text" name="txt_ara_toplam" id="txt_ara_toplam" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" onkeypress="return SadeceRakam(event,[',']);" disabled="">
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
                                                            <input type="text" name="txt_kdv_toplam1" id="txt_kdv_toplam1" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" onkeypress="return SadeceRakam(event,[',']);" disabled="">
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
                                                            <input type="text" name="txt_kdv_toplam10" id="txt_kdv_toplam10" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" onkeypress="return SadeceRakam(event,[',']);" disabled="">
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
                                                            <input type="text" name="txt_kdv_toplam20" id="txt_kdv_toplam20" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" onkeypress="return SadeceRakam(event,[',']);" disabled="">
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
                                                            <input type="text" name="txt_V9015_islem_tutar" id="txt_V9015_islem_tutar" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" onkeypress="return SadeceRakam(event,[',']);" disabled="">
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
                                                            <input type="text" name="txt_V9015_hesaplanan_kdv" id="txt_V9015_hesaplanan_kdv" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" onkeypress="return SadeceRakam(event,[',']);" disabled="">
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
                                                            <input type="text" name="txt_V9015" id="txt_V9015" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" onkeypress="return SadeceRakam(event,[',']);" disabled="">
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
                                                            <input type="text" name="txt_genel_toplam" id="txt_genel_toplam" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" onkeypress="return SadeceRakam(event,[',']);" disabled="">
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
                                                            <input type="text" name="kur_fiyat_<?php echo $kur["money_code"]; ?>" id="kur_fiyat_<?php echo $kur["money_code"]; ?>" class="transparent-input form-control form-control-sm text-end para" value="<?php echo number_format($kur["money_value"], 2, ',', '.'); ?>"onkeypress="return SadeceRakam(event,[',']);" >
                                                            <div class="input-group-append">
                                                                <span class="input-group-text transparent-input-text text_simge_<?php echo $kur["money_code"]; ?> " id="">TRY</span>
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
                                                            <input type="text" name="txt_odenecek_tutar" id="txt_odenecek_tutar" class="transparent-input form-control form-control-sm text-end para" placeholder="0,00" onkeypress="return SadeceRakam(event,[',']);" disabled="">
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

                                            <hr class="mt-4">

                                            <div class="" id="chx_has_collection_area">
                                            <div class="row g-3 mb-3 align-center">
                                                <div class="col-lg-3 col-xxl-3 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="chx_has_collection" id="fatura_tipi_title">Tahsilat Yapıldı mı?</label>
                                                        <span class="form-note d-none d-md-block" id="fatura_tipi_aciklama">Eğer bu satış işleminde tahsilat yapıldı ise işaretleyiniz.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                                    <ul class="custom-control-group">
                                                        <li>
                                                            <div class="custom-control custom-checkbox custom-control-pro">
                                                                <input type="checkbox" class="custom-control-input" name="chx_has_collection" id="chx_has_collection">
                                                                <label class="custom-control-label" for="chx_has_collection">
                                                                    Evet
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="d-none g-3" id="area_has_collection">
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 col-xxl-3 ">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">İşlem Hesabı</label>
                                                            <span class="form-note d-none d-md-block">İşlem yapılan hesabı seçiniz veya ekleyiniz.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-xxl-5  mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control form-control-xl" id="account_name" name="account_name" disabled placeholder="Hesap seçmek için tıklayınız..">
                                                                <div class="input-group-append">
                                                                    <a data-bs-toggle="modal" data-bs-target="#mdl_hesaplar" class="btn btn-lg btn-block btn-dim btn-outline-light">SEÇ</a>
                                                                    <!-- <button class="btn btn-lg btn-block btn-dim btn-outline-light">EKLE</button> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 col-xxl-3 ">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">Tutar, Para Birimi ve Tarihi</label>
                                                            <span class="form-note d-none d-md-block">İşlem yapılan tutar, para birimi ve tarih bilgisini giriniz.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-xxl-3  mt-0 mt-md-2">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control form-control-xl text-end" name="transaction_amount" id="transaction_amount" onkeypress="return SadeceRakam(event,[',']);" placeholder="0,00" autocomplete="off">
                                                                <div class="input-group-append">
                                                                    <button data-bs-toggle="modal" data-bs-target="#mdl_parabirimi" class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                        <span id="moneyUnit">TRY</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="" style="width: 160px">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-left" style="width: calc(1rem + 30px); top:1px">
                                                                <em class="icon ni ni-calendar icon-xl"></em>
                                                            </div>
                                                            <input id="transaction_date" name="transaction_date" type="text" class="form-control form-control-xl date-picker" style="padding-right: 16px; padding-left: 44px;" data-date-format="dd/mm/yyyy" value="<?= date('d/m/Y') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>

                                        </div>

                                        <input type="hidden" id="tvkf_durum" value="0">
                                        <input type="hidden" id="str_s" value="0">
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
                                        <input type="hidden" name="" id="cari_money_unit_id" value="">
                                        <input type="hidden" name="" id="cari_money_unit_data" value="">

                                        <div class="mt-5 bg-white">
                                            <button type="button" class="btn btn-secondary mb-2 btnPrevious" id="prevButton">Önceki</button>
                                            <button type="button" class="btn btn-success mb-2 btnSaveInvoice" id="btnSaveInvoice">Faturayı Kaydet</button>
                                        </div>

                                    </div>

                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>

            </div><!-- .components-preview -->
        </div>
    </div>
</div>

<div class="modal fade" id="modalEskiFiyatlar" tabindex="-1" aria-labelledby="modalEskiFiyatlarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content shadow-lg border-0" style="border-radius: 18px;">
      <div class="modal-header bg-primary text-white" style="border-top-left-radius: 18px; border-top-right-radius: 18px;">
        <h5 class="modal-title fw-bold" id="modalEskiFiyatlarLabel">
          <i class="ni ni-sign-try me-2"></i>Ürünün Eski Fiyatları
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Kapat"></button>
      </div>
      <div class="modal-body p-4" id="eskiFiyatlarBody" style="background: #f8fafd;">
        <!-- İçerik buraya gelecek -->
      </div>
    </div>
  </div>
</div>

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

<!-- Hesaplar Modal -->
<div class="modal fade" id="mdl_hesaplar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">İşlem Hesabı Seçiniz</h5>
                <a href="#" id="btn_hesaplar_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body p-0">
                <table class="datatable-hareketler table">
                    <thead>
                        <tr>
                            <th>Seç</th>
                            <th>Banka</th>
                            <th>Tipi - Döviz</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($financial_account_items)) {
                            foreach ($financial_account_items as $financial_account_item) {

                        ?>
                                <tr>

                                    <td data-order="0">
                                        <div class="custom-control custom-radio no-control">
                                            <input type="radio" class="custom-control-input rd_account " name="radioSizeAccount" accName="<?= $financial_account_item['account_title']; ?>" accMoneyUnitId="<?= $financial_account_item['money_unit_id']; ?>" accMoneyUnitName="<?= $financial_account_item['money_code']; ?>" id="<?= $financial_account_item['financial_account_id'] ?>" />
                                            <label class="custom-control-label text-primary" for="<?= $financial_account_item['financial_account_id'] ?>"><?= $financial_account_item['account_title']; ?></label>
                                        </div>
                                    </td>
                                    <td><?php if (isset($bank_items) && $financial_account_item['bank_id'] != null) {
                                            echo $bank_items[array_search($financial_account_item['bank_id'], array_column($bank_items, 'bank_id'))]['bank_title'];
                                        } else {
                                            echo " - ";
                                        }  ?></td>
                                    <td><?php switch ($financial_account_item['account_type']) {
                                            case 'vault':
                                                echo "Kasa";
                                                break;
                                            case 'bank':
                                                echo "Banka";
                                                break;
                                            case 'pos':
                                                echo "POS";
                                                break;
                                                case 'check_bill':
                                                    echo "ÇEK/SENET";
                                                    break; 
                                            case 'credit_card':
                                                echo "Kredi Kartı";
                                                break;
                                        } ?> - <?= $financial_account_item['money_code'] ?></td>

                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" class="btn btn-lg btn-dim btn-outline-light d-none" data-bs-dismiss="modal" aria-label="Close">KAPAT</button>

                    </div>
                    <div class="col-md-8 text-end p-0">

                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2" disabled>YENİ HESAP</button>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-lg btn-primary ">KAPAT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'success_create_invoice',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Proforma faturanız başarıyla oluşturuldu.',
                'modal_buttons' => '<a href="#" onclick="location.reload()" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Fatura Oluştur</a>
                                    <a href="" id="invoiceDetail" class="btn btn-primary btn-block mb-2">Fatura Detayına Git</a>
                                    <a href="' . route_to('tportal.faturalar.list', 'all') . '" class="btn btn-l btn-dim btn-outline-dark btn-block mb-2">Fatura Listesini Gör</a>'
            ],
        ],
    ]
); ?>




<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/create-invoice.js?ver=1.0.7') ?>"></script>

<?= view_cell(
    'App\Libraries\ViewComponents::getSearchCustomerModal',
    [
        'fromWhere' => 'createInvoice'
    ]
); ?>
<?= view_cell(
    'App\Libraries\ViewComponents::getSearchStockModal'
); ?>
<?= view_cell(
    'App\Libraries\ViewComponents::getSearchSubStockModal'
); ?>

<script>



/*
$(window).on('load', function() {

    if ($("#fatura_seri").find('option').length <= 1) { // Sadece boş seçenek varsa
                $("#is_customInvoiceNo").trigger("click");
            }

});
 */

// Function to handle setting value and disabled state

// Function to handle setting value and disabled state
function handleFtrSelect(element) {
    if ($('#chx_quickSale').is(':checked')) { // Sadece checkbox kontrolü yapılıyor
        // Create and select the "0" option if it doesn't exist
        if ($(element).find('option[value="0"]').length === 0) {
            $(element).append(new Option("0", "0"));
        }
        $(element).val("0").trigger('change').prop('disabled', true);
    } else {
        $(element).prop('disabled', false);
    }
}

// Sayfa yüklendiğinde kontrol

// Handle checkbox change
$('#chx_quickSale').on('change', function() {
    $('.ftr_select_yeni_fatura').each(function() {
        handleFtrSelect(this);
    });
});


// Handle new rows (observe DOM changes for new elements)
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.addedNodes.length) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1) { // Element node
                    $(node).find('.ftr_select_yeni_fatura').each(function() {
                        handleFtrSelect(this);
                    });
                }
            });
        }
    });
});

// Start observing the document with the configured parameters
observer.observe(document.body, { childList: true, subtree: true });

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


    
    let has_collection = 0;

    $(".cari_phone").each(function(index) {
        $(".cari_phone").mask("+00 (000) 000 0000");
    });

    $("#chx_has_collection").change(function() {
        if (this.checked) {
            $('#area_has_collection').removeClass('d-none');

            if ($('#txt_odenecek_tutar_dvz').val() != '0,00'){
                $('#transaction_amount').val($('#txt_odenecek_tutar_dvz').val());
            }
            else{
                $('#transaction_amount').val($('#txt_odenecek_tutar').val());
            }
            has_collection = 1;
        } else {
            $('#area_has_collection').addClass('d-none');
            $('#transaction_amount').val(0);
            has_collection = 0;
        }
    });

    $(document).on("click", ".rd_account", function() {
        var selectedAccount = $('input[name="radioSizeAccount"]:checked').attr('id');
        var selectedAccountName = $('input[name="radioSizeAccount"]:checked').attr('accName');
        var selectedAccountMoneyId = $('input[name="radioSizeAccount"]:checked').attr('accMoneyUnitId');
        var selectedAccountMoneyName = $('input[name="radioSizeAccount"]:checked').attr('accMoneyUnitName');

        if (selectedAccountMoneyName != $("#slct_doviz_tipi option:selected").attr('data-money-unit-code')) {
            Swal.fire({
                title: "Uyarı!",
                html: 'Döviz tipi sadece TRY olan işlem hesaplarını seçebilirsiz. ',
                icon: "warning",
                confirmButtonText: 'Tamam',
            });
        } else {
            if (selectedAccount != null && selectedAccount != 0) {
                // selectedAccount = selectedAccount.substring(11);
                $('#account_name').empty().val(selectedAccountName);
                $('#financial_account_id').empty().val(selectedAccount);
                $('#mdl_hesaplar').modal('hide');

                $('#moneyUnit').empty().append(selectedAccountMoneyName);
                $('#money_unit_id').val(selectedAccountMoneyId);

                $('#customRadio' + selectedAccountMoneyId).attr('checked', 'checked');
            } else {
                swetAlert("Lütfen işlem hesabı seçiniz", "", "err");
            }
        }
    });

    //sorgulamadan devam et
    $('#chx_sorgulama').change(function() {
        if ($("#chx_sorgulama").is(":checked")) {
            $('#customer_info_area').removeClass('d-none');
            $('#obligation').removeAttr('disabled');
            $('#fatura_senaryo').removeAttr('disabled');

        } else {
            $('#customer_info_area').addClass('d-none');
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
        console.log(selectedCariId);

        $('#address_country').val('');


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
                        $('#customer_info_area').removeClass('d-none');

                        $('#company_type').attr('disabled', 'disabled');
                        $('#obligation').attr('disabled', 'disabled');

                        $('#is_customer_save').removeAttr('checked');
                        $('#is_customer_save').removeAttr('disabled');

                        fullData = response.cari_item;

                        console.log(fullData);

                        $('#cari_money_unit_id').val(fullData.money_unit_id);
                        $('#cari_money_unit_data').val(fullData.money_title + ' - ' + fullData.money_code + ' ('+ fullData.money_icon +')');



                        if (fullData.cari_phone != null) {
                            phoneBase = fullData.cari_phone.split(" ");

                            areaCode = phoneBase[0];
                            phone = phoneBase[1];

                            $("#cari_phone").val(phone).unmask().mask("(000) 000 0000");
                            $('#area_code').val(areaCode);
                            $('#area_code').trigger('change');

                        }else{
                            $("#cari_phone").val('').unmask().mask("(000) 000 0000");
                        }


                        $('#identification_number').val(fullData.identification_number == 0 ? '' : fullData.identification_number);
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
                   

                        $("#slct_doviz_tipi").val(fullData.money_unit_id);
                        $("#slct_doviz_tipi").trigger("change");
                        $("#slct_doviz_tipi").prop("disabled", true); // Disable etme

                       

                        

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

                        $('#zip_code').val(fullData.zip_code == 0 ? '' : fullData.zip_code);
                        $('#cari_email').val(fullData.cari_email);


                        $('#money_unit_id').val(fullData.money_unit_id);
                        $('#money_unit_id').trigger('change');
                        $('#currency_exchange_value').val(fullData.money_value);

                        if (fullData.obligation == 'e-archive') {
                            $('#fatura_senaryo').val('EARSIVFATURA').trigger('change');
                                $('#fatura_senaryo').trigger('change');

                                $("#fatura_seri option[invoice-serial-type='e-invoice']").attr("disabled", true).trigger('change');
                                $("#fatura_seri option[invoice-serial-type='e-archive']").attr("disabled", false).trigger('change');
                                setTimeout(() => {
                                    $("#fatura_seri").val(1).trigger('change');
                                }, 100);

                                $("#fatura_senaryo option[value=TEMELFATURA]").attr('disabled', 'disabled').trigger('change');
                                $("#fatura_senaryo option[value=TICARIFATURA]").attr('disabled', 'disabled').trigger('change');
                                $("#fatura_senaryo option[value=KAMU]").attr('disabled', 'disabled').trigger('change');
                                $("#fatura_senaryo option[value=IHRACAT]").attr('disabled', 'disabled').trigger('change');
                        } else {
                            $('#fatura_senaryo').attr('disabled', false);
                            setTimeout(() => {
                                $("#fatura_seri").val(2).trigger('change');
                            }, 100);
                            $('#fatura_senaryo').val('TICARIFATURA').trigger('change');
                            $('#fatura_senaryo').trigger('change');

                            $("#fatura_seri option[invoice-serial-type='e-invoice']").attr("disabled", false).trigger('change');
                            $("#fatura_seri option[invoice-serial-type='e-archive']").attr("disabled", true).trigger('change');

                            $("#fatura_senaryo option[value=TEMELFATURA]").removeAttr('disabled').trigger('change');
                            $("#fatura_senaryo option[value=TICARIFATURA]").removeAttr('disabled').trigger('change');
                            $("#fatura_senaryo option[value=KAMU]").removeAttr('disabled').trigger('change');
                            $("#fatura_senaryo option[value=IHRACAT]").removeAttr('disabled').trigger('change');
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
                success: function(datsa) {
                    swal.close();

                    var datas = JSON.parse(datsa);
                    console.log(datas);

                    if (datas.response.unvan == '' && datas.response.ad == '' && datas.response.soyad == '') {

                        Swal.fire({
                            title: "Uyarı!",
                            html: 'Girilen VKN/TC ile eşleşen bir kayıt bulunamadı. <br> VKN/TC doğruluğunu kontrol edip tekrar deneyiniz.',
                            icon: "warning",
                            confirmButtonText: 'Tamam',
                        });

                    } else {
                        $('#customer_info_area').removeClass('d-none');

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

                            $('#identification_number').val(fullData.identification_number == 0 ? '' : fullData.identification_number);
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


                            $('#money_unit_id').val(fullData.money_unit_id);
                            $('#money_unit_id').trigger('change');
                            $('#currency_exchange_value').val(fullData.money_value);

                            $('#is_customer_save').removeAttr('checked');
                            $('#is_customer_save').removeAttr('disabled');

                            if (fullData.obligation == 'e-archive') {
                                
                                $('#fatura_senaryo').val('EARSIVFATURA').trigger('change');
                                $('#fatura_senaryo').trigger('change');

                                $("#fatura_seri option[invoice-serial-type='e-invoice']").attr("disabled", true).trigger('change');
                                $("#fatura_seri option[invoice-serial-type='e-archive']").attr("disabled", false).trigger('change');
                                setTimeout(() => {
                                    $("#fatura_seri").val(1).trigger('change');
                                }, 100);

                                $("#fatura_senaryo option[value=TEMELFATURA]").attr('disabled', 'disabled').trigger('change');
                                $("#fatura_senaryo option[value=TICARIFATURA]").attr('disabled', 'disabled').trigger('change');
                                $("#fatura_senaryo option[value=KAMU]").attr('disabled', 'disabled').trigger('change');
                                $("#fatura_senaryo option[value=IHRACAT]").attr('disabled', 'disabled').trigger('change');
                            } else {

                                $('#fatura_senaryo').attr('disabled', false);

                         
                                setTimeout(() => {
                                    $("#fatura_seri").val(2).trigger('change');
                                }, 100);
                                $('#fatura_senaryo').val('TICARIFATURA').trigger('change');
                                $('#fatura_senaryo').trigger('change');

                                $("#fatura_seri option[invoice-serial-type='e-invoice']").attr("disabled", false).trigger('change');
                                $("#fatura_seri option[invoice-serial-type='e-archive']").attr("disabled", true).trigger('change');

                                $("#fatura_senaryo option[value=TEMELFATURA]").removeAttr('disabled').trigger('change');
                                $("#fatura_senaryo option[value=TICARIFATURA]").removeAttr('disabled').trigger('change');
                                $("#fatura_senaryo option[value=KAMU]").removeAttr('disabled').trigger('change');
                                $("#fatura_senaryo option[value=IHRACAT]").removeAttr('disabled').trigger('change');
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


                            console.log(datas.response.unvan);

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
                                $('#invoice_title').val(datas.response.unvan);
                               
                                $('#company_type').trigger('change');
                            } else {
                                
                                $('#namesurname').addClass('d-none');
                                $('#invoice_title').addClass('d-none');

                                
                                $('#company_type').val('company');
                                $('#company_type').trigger('change');
                            }


                            if (datas.response.vknInfo == 0) {
                                $('#obligation').val('e-archive');
                                $('#obligation').trigger('change');

                                $('#fatura_senaryo').val('EARSIVFATURA').trigger('change');
                                $('#fatura_senaryo').trigger('change');

                                $("#fatura_seri option[invoice-serial-type='e-invoice']").attr("disabled", true).trigger('change');
                                $("#fatura_seri option[invoice-serial-type='e-archive']").attr("disabled", false).trigger('change');
                                setTimeout(() => {
                                    $("#fatura_seri").val(1).trigger('change');
                                }, 100);

                                $("#fatura_senaryo option[value=TEMELFATURA]").attr('disabled', 'disabled').trigger('change');
                                $("#fatura_senaryo option[value=TICARIFATURA]").attr('disabled', 'disabled').trigger('change');
                                $("#fatura_senaryo option[value=KAMU]").attr('disabled', 'disabled').trigger('change');
                                $("#fatura_senaryo option[value=IHRACAT]").attr('disabled', 'disabled').trigger('change');
                            } else {
                                $('#obligation').val('e-invoice');
                                $('#obligation').trigger('change');
                                setTimeout(() => {
                                    $("#fatura_seri").val(2).trigger('change');
                                }, 100);
                                $('#fatura_senaryo').val('TICARIFATURA').trigger('change');
                                $('#fatura_senaryo').trigger('change');

                                $("#fatura_seri option[invoice-serial-type='e-invoice']").attr("disabled", false).trigger('change');
                                $("#fatura_seri option[invoice-serial-type='e-archive']").attr("disabled", true).trigger('change');

                                $("#fatura_senaryo option[value=TEMELFATURA]").removeAttr('disabled').trigger('change');
                                $("#fatura_senaryo option[value=TICARIFATURA]").removeAttr('disabled').trigger('change');
                                $("#fatura_senaryo option[value=KAMU]").removeAttr('disabled').trigger('change');
                                $("#fatura_senaryo option[value=IHRACAT]").removeAttr('disabled').trigger('change');
                            }
                        }

                        if(vknTc.length == 10){
                        $('#company_type').val('company').trigger('change');
                        }
                            if(vknTc.length == 11){
                        $('#company_type').val('person').trigger('change');
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

        $('.js-select2').select2();
        $("#cari_phone").mask("(000) 000 0000");

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


        $('#btn_musteriSorgula').attr('disabled', true);

        $('#identification_number').keyup(function(e) {
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
                $('#identification_number').attr('disabled', true);
                $('#customer_info_area').removeClass('d-none');
                $('#identification_number').val('22222222222');
                $('#btn_musteriSorgulaNew').attr('disabled', true);
                $('#customer_info_area').removeClass('d-none');

                $("#fatura_senaryo option[value=IHRACAT]").removeAttr('disabled');
                $('#fatura_senaryo').val('IHRACAT');
                $('#fatura_senaryo').trigger('change');

                $("#fatura_senaryo option[value=EARSIVFATURA]").attr('disabled', 'disabled');
                $("#fatura_senaryo option[value=TEMELFATURA]").attr('disabled', 'disabled');
                $("#fatura_senaryo option[value=TICARIFATURA]").attr('disabled', 'disabled');
                $("#fatura_senaryo option[value=KAMU]").attr('disabled', 'disabled');


                $("#fatura_tipi option[value=ISTISNA]").removeAttr('disabled');
               setTimeout(() => {

                // Önce e-archive seçeneğini seç
                $("#fatura_seri").val($("#fatura_seri option[invoice-serial-type='e-archive']").val()).trigger('change');
                // Sonra select'i disabled yap
                $("#fatura_seri").prop('disabled', true);
                // e-invoice seçeneğini devre dışı bırak
                $("#fatura_seri option[invoice-serial-type='e-invoice']").prop('disabled', true);


                $("#fatura_senaryo").val('EARSIVFATURA');
                $("#fatura_senaryo").trigger('change');
                $('#fatura_senaryo').attr('disabled', true);
                $('#fatura_tipi').val('ISTISNA');
                $('#fatura_tipi').trigger('change');
                $('#fatura_tipi').attr('disabled', true);
               }, 500);

                $("#fatura_tipi option[value=SATIS]").attr('disabled', 'disabled');
                $("#fatura_tipi option[value=IADE]").attr('disabled', 'disabled');
                $("#fatura_tipi option[value=IADEISTISNA]").attr('disabled', 'disabled');
                $("#fatura_tipi option[value=OZELMATRAH]").attr('disabled', 'disabled');
                $("#fatura_tipi option[value=IHRACKAYITLI]").attr('disabled', 'disabled');


                $('#company_type').val('person');
                $('#company_type').trigger('change');
                $('#company_type').attr('disabled', 'disabled');


                $('#obligation').val('e-archive');
                $('#obligation').trigger('change');
                $('#obligation').attr('disabled', 'disabled');

            } else {
                $('#customer_info_area').addClass('d-none');
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
                $("#fatura_tipi option[value=IADEISTISNA]").removeAttr('disabled');
                $("#fatura_tipi option[value=OZELMATRAH]").removeAttr('disabled');
                $("#fatura_tipi option[value=IHRACKAYITLI]").removeAttr('disabled');

            }
        });
        $('#identification_number').on('input', function() {
            var charCount = $(this).val().length;
            if ((charCount == 10 || charCount == 11) && $('#is_export_customer').is(':checked') ==
                false) {
                $('#btn_musteriSorgula').attr('disabled', false);
            } else {
                $('#btn_musteriSorgula').attr('disabled', true);
            }
            // $('#btn_musteriSorgula').html('Karakter Sayısı: ' + charCount);
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
            $("#fatura_tipi_title").html("Tahsilat Yapıldı mı?");
            $("#fatura_tipi_aciklama").html("Eğer bu satış işleminde tahsilat yapıldı ise işaretleyiniz.");
        });
        $(document).on("click", "#ftr_alis", function() {
            $('#fatura_seri_alanı').removeClass('d-none');
            if ($("#fatura_seri").find('option').length <= 1) { // Sadece boş seçenek varsa
                setTimeout(() => {
                    $("#is_customInvoiceNo").trigger("checked");
                }, 300);
            }
            $('#irsaliye_alani').addClass('d-none');
            $("#fatura_tipi_title").html("Ödeme Alındı mı?");
            $("#fatura_tipi_aciklama").html("Eğer bu alış işleminde ödeme alındıysa ise işaretleyiniz.");
        });

        $(document).on("change", "#fatura_senaryo", function() {
            var selected_fatura_senaryo = $('#fatura_senaryo').val();
        });

        $(document).on("change", "#is_customInvoiceNo", function() {
            if (this.checked) {
                $("#fatura_seri").addClass("d-none")
                $("#customInvoiceNo").removeClass("d-none")
                $("#fatura_seri_area").addClass("d-none")
            } else {
                $("#fatura_seri").removeClass("d-none")
                $("#customInvoiceNo").addClass("d-none")
                $("#fatura_seri_area").removeClass("d-none")
            }
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


    });







    $(".btn_urun_eski_fiyat").click(function(){
    var urun_id = $(this).attr("data-urun_id");
    var satir = $(this).attr("data-satir");

    $("#eskiFiyatlarBody").html('<div class="text-center">Yükleniyor...</div>');
    $("#modalEskiFiyatlar").modal('show');

    $.ajax({
        url: '<?php echo base_url(); ?>/tportal/invoice/UrunEskiFiyatlar/' + urun_id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.eski_fiyatlar && response.eski_fiyatlar.length > 0) {
                var html = `
                    <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Tarih</th>
                                <th>Kullanıcı</th>
                                <th>Fiyat</th>
                                <th>Birim</th>
                                <th>Fatura Bilgisi</th>
                                <th>Seç</th>
                            </tr>
                        </thead>
                        <tbody>
                `;
                response.eski_fiyatlar.forEach(function(item){
                    html += `
                        <tr>
                            <td>${new Date(item.created_at).toLocaleDateString('tr-TR')}</td>
                            <td>${item.cari_invoice_title}</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-white fw-bold">${item.unit_price}</span></td>
                            <td>${item.unit_title}</td>
                            <td><a target="_blank" href="<?php echo base_url(); ?>/tportal/invoice/detail/${item.invoice_id}" target="_blank">Faturayı Görüntüle</a></td>
                            <td><button class="btn btn-sm btn-primary btn-dim btn_urun_eski_fiyat_sec" data-satir="${satir}" data-urun_id="${urun_id}" data-fiyat="${item.unit_price}" data-birim="${item.unit_title}" data-tarih="${item.created_at}" data-fatura_id="${item.invoice_id}">Seç</button></td>
                        </tr>
                    `;
                });
                html += `</tbody></table></div>`;
                $("#eskiFiyatlarBody").html(html);
            } else {
                $("#eskiFiyatlarBody").html('<div class="alert alert-warning text-center mb-0">Bu ürün için eski fiyat bulunamadı.</div>');
            }
        },
        error: function() {
            $("#eskiFiyatlarBody").html('<div class="alert alert-danger text-center mb-0">Bir hata oluştu.</div>');
        }
    });
});


$(document).on("click", ".btn_urun_eski_fiyat_sec", function() {
    var satir = $(this).data("satir");
    var fiyat = $(this).data("fiyat");

    // İlgili satırdaki birim fiyat inputunu bul ve değeri ata
    $("#txt_birim_fiyat_" + satir).val(fiyat);

    // Modalı kapat
    $("#modalEskiFiyatlar").modal('hide');
});
</script>

<?= $this->endSection() ?>