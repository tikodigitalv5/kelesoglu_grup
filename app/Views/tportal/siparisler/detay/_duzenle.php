<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Sipariş Düzenle <?= $this->endSection() ?>
<?= $this->section('title') ?> Sipariş Düzenle | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>


<?= $this->section('styles') ?>

<style>
    /* .wide-xl {
        max-width: 90% !important;
    } */
</style>

<?= $this->endSection() ?>



<?= $this->section('main') ?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="components-preview wide-xl mx-auto">

                <!-- <div class="example-alert">
                    <div class="alert alert-primary alert-icon"><em class="icon ni ni-alert-circle"></em> <strong>Sipariş oluştur sayfasından çoğaltıldı</strong>. Tasarım değiştirilip siparişler olarak devam edecek.</div>
                </div>
                <hr> -->

                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner p-4">
                            <form onsubmit="return false;" id="createOrder" method="post" autocomplete="off">
                                <ul class="nav nav-tabs mt-n3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1" aria-selected="false" role="tab" tabindex="-1"><em class="icon ni ni-users-fill"></em><span>Cari Bilgileri</span></a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link " data-bs-toggle="tab" href="#tabItem3" aria-selected="true" role="tab"><em class="icon ni ni-file-text-fill"></em><span>Sipariş Bilgileri</span></a>
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
                                                    <input type="text" class="form-control  form-control-lg form-control-lg" id="identification_number" name="identification_number" placeholder="T.C. veya Vergi No Giriniz.." maxlength="11" value="<?= $order_item['cari_identification_number'] == 0 ? '' : $order_item['cari_identification_number'] ?>">
                                                    <div class="input-group-append">
                                                        <button id="btn_musteriSorgulaNew"  class="btn btn-lg btn-block btn-dim btn-outline-light" disabled>Sorgula
                                                        </button>
                                                        <button id="btn_musteriSec" data-bs-toggle="modal" data-bs-target="#mdl_musteriSec" class="btn btn-lg btn-block  btn-dim btn-outline-primary">
                                                            Seç
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="customer_info_area" class="gy-2">

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
                                                                <option value="e-archive" <?php if ($order_item['cari_obligation'] == 'e-archive') {
                                                                                            echo "selected";
                                                                                        } ?>>
                                                                E-Arşiv Fatura</option>
                                                            <option value="e-invoice" <?php if ($order_item['cari_obligation'] == 'e-invoice') {
                                                                                            echo "selected";
                                                                                        } ?>>
                                                                E-Fatura</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xxl-6 col-6 mt-0 mt-md-2 ps-1">
                                                        <div class="form-group">
                                                            <select id="company_type" name="company_type" class="form-select js-select2" data-ui="lg" data-placeholder="Şirket Tipi Seçiniz" data-search="on">
                                                                <option></option>
                                                                <option value="person" <?= $order_item['cari_company_type'] == 'person' ? "selected" : '' ?>>Şahıs</option>
                                                                <option value="company" <?= $order_item['cari_company_type'] == 'company' ? "selected" : '' ?>>Şirket</option>
                                                                <option value="public" <?= $order_item['cari_company_type'] == 'public' ? "selected" : '' ?>>Kamu</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="invoice_title">Sipariş Ünvanı</label>
                                                        <span class="form-note d-none d-md-block">Vergi No ise Ünvan Siparişda Gönderilir.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control  form-control-lg form-control-lg" name="invoice_title" id="invoice_title" value="<?= $order_item['cari_invoice_title'] ?>" placeholder="Sipariş Ünvanı">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center" id="namesurname">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="">Adı Soyadı</label>
                                                        <span class="form-note d-none d-md-block">T.C. ise Ad Soyad SiparişdaGönderilir.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control  form-control-lg form-control-lg" id="name" name="name" value="<?= $order_item['cari_name'] ?>" placeholder="Adı">
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control  form-control-lg form-control-lg" id="surname" name="surname" value="<?= $order_item['cari_surname'] ?>" placeholder="Soyadı">
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="cari_id" id="cari_id">


                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="tax_administration">Vergi Dairesi</label>
                                                        <span class="form-note d-none d-md-block">Sipariş kesilecek resmi vergi dairesi.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control  form-control-lg form-control-lg" name="tax_administration" id="tax_administration" value="<?= $order_item['cari_tax_administration'] ?>" placeholder="Vergi Dairesi">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address">Sipariş Adresi</label><span class="form-note d-none d-md-block">Sipariş kesilecek resmi fatura adresi.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control  form-control-lg form-control-lg" name="address" id="address" cols="30" rows="5" placeholder="Sipariş Adresi"><?= $order_item['address'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address_country">Ülke</label>
                                                        <span class="form-note d-none d-md-block">Sipariş adresinin bulunduğu ülke</span>
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
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address_city">İl / İlçe</label>
                                                        <span class="form-note d-none d-md-block">Sipariş adresinin bulunduğu il ve ilçe bilgisi</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-xxl-3 col-6 mt-0 mt-md-2">
                                                    <div class="form-control-wrap">
                                                        <select id="Iller" name="address_city" class="form-select js-select2 add_city" data-ui="lg" data-search="on" data-placeholder="İl Seçiniz">
                                                            <option value="0">İl seçiniz</option>
                                                        </select>
                                                        <input type="hidden" name="address_city_plate" id="address_city_plate" value="<?= $order_item['address_city_plate'] ?>">
                                                        <input type="hidden" name="address_city_name" id="address_city_name" value="">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-xxl-4 col-6 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <select id="Ilceler" name="address_district" class="form-select js-select2" data-ui="lg" data-search="on" data-placeholder="İlçe Seçiniz" disabled="disabled">
                                                            <option value="0">Önce il seçiniz</option>
                                                        </select>
                                                        <input type="hidden" name="address_district" id="address_district" value="<?= $order_item['address_district'] ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="zip_code">Posta
                                                            Kodu</label><span class="form-note d-none d-md-block">Sipariş
                                                            adresinin posta
                                                            kodu.</span></div>
                                                </div>
                                                <div class="col-lg-3 col-xxl-3 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control  form-control-lg form-control-lg" id="zip_code" name="zip_code" value="<?= $order_item['address_zip_code'] == 0 ? '' : $order_item['address_zip_code'] ?>" placeholder="Posta Kodu">
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
                                                        <div class="form-control-wrap"><input type="text" class="form-control  form-control-lg form-control-lg" id="cari_email" value="<?= $order_item['cari_email'] ?>" placeholder="Cari e-posta" name="cari_email">
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
                                                            <input type="text" class="form-control  form-control-lg form-control-lg" name="cari_phone" id="cari_phone" aria-label="Carinin iletişim için telefon numarası" placeholder="000 000 0000" value="<?php if ($order_item['cari_phone'] != 0) {
                                                                                                                                                                                                                                                                    $phone = explode(" ", $order_item['cari_phone']);
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

                                        <div class="mt-5 bg-white">
                                            <!-- <button type="button" class="btn btn-secondary mb-2 btnPrevious" id="prevButton">Önceki</button> -->
                                            <button type="button" class="btn btn-primary mb-2 btnNext" id="nextButton">Sonraki</button>
                                        </div>

                                    </div>


                                    <div class="tab-pane " id="tabItem3" role="tabpanel">



                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-3 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="fatura_para_birimi">Sipariş Durmunu</label>
                                                    <span class="form-note d-none d-md-block">Sipariş durmunu seçiniz</span>
                                                </div>
                                            </div>


                                            <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group">

                                                        <select class="form-select form-select-lg js-select2 form-control slct_order_status" data-ui="lg" id="slct_order_status" satir="0" data-ui="lg" data-placeholder="Seçiniz">
                                                            <option></option>
                                                            <option value="new" <?= $order_item['order_status'] == 'new' ? "selected" : '' ?>>Yeni Sipraiş</option>
                                <option value="pending" <?= $order_item['order_status'] == 'pending' ? "selected" : '' ?>>Hazırlanıyor</option>
                                <option value="success" <?= $order_item['order_status'] == 'success' ? "selected" : '' ?>>Tamamlandı</option>
                                <option value="failed" <?= $order_item['order_status'] == 'failed' ? "selected" : '' ?>>İptal Edildi</option>
                                <option value="sevk_emri" <?= $order_item['order_status'] == 'sevk_emri' ? "selected" : '' ?>>Sevk Emri Verildi</option>
                                <option value="sevk_edildi" <?= $order_item['order_status'] == 'sevk_edildi' ? "selected" : '' ?>>Sevk Edildi</option>
                                <option value="teknik_hata" <?= $order_item['order_status'] == 'teknik_hata' ? "selected" : '' ?>>Teknik Hata</option>
                                <option value="stokta_yok" <?= $order_item['order_status'] == 'stokta_yok' ? "selected" : '' ?>>Stokta Yok</option>
                                <option value="kargo_bekliyor" <?= $order_item['order_status'] == 'kargo_bekliyor' ? "selected" : '' ?>>Kargo Bekliyor</option>

                                <option value="kargolandi" <?= $order_item['order_status'] == 'kargolandi' ? "selected" : '' ?>>Kargolandı</option>
                                <option value="yetistirilemedi" <?= $order_item['order_status'] == 'yetistirilemedi' ? "selected" : '' ?>>Yetiştirilemedi</option>

                                                        </select>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                   
                                        <div class="row g-3 align-center">
                                        <div class="col-lg-5 col-xxl-3 ">
                                        <div class="form-group">
                                                    <label class="form-label" for="fatura_para_birimi">Sipariş Para Birimi</label>
                                                    <span class="form-note d-none d-md-block">Sipariş para birimi seçiniz</span>
                                                </div>
                                            </div>


                                            <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                            <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                            <div class="form-group">

                                                        <select class="form-select form-select-lg js-select2 form-control slct_doviz_tipi" data-ui="lg" data-search="on" id="slct_doviz_tipi" satir="0" data-ui="lg" data-placeholder="Seçiniz">
                                                            <option></option>
                                                            <?php foreach ($money_unit_items as $money_unit_item) { ?>
                                                                <option value="<?= $money_unit_item['money_unit_id'] ?>" data-money-unit-code="<?= $money_unit_item['money_code'] ?>" data-money-unit-icon="<?= $money_unit_item['money_icon'] ?>" <?php if ($order_item['money_unit_id'] == $money_unit_item['money_unit_id']) {
                                                                                                                                                                                                                                                        echo "selected";
                                                                                                                                                                                                                                                    } ?>>
                                                                    <?= $money_unit_item['money_code'] ?> -
                                                                    <?= $money_unit_item['money_title'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <input type="hidden" name="base_slct_doviz_tipi" id="base_slct_doviz_tipi" value="<?= $order_item['money_unit_id'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xxl-5 col-4 mt-0 mt-md-2 ps-1 d-none" id="txt_doviz_kuru_area">
                                                    <div class="input-group">
                                                        <input type="text" name="txt_doviz_kuru" id="txt_doviz_kuru" class="form-control form-control-lg form-control-lg text-end doviz_degis" placeholder="0,0000" onkeypress="return SadeceRakam(event,[',']);" value="<?= number_format($order_item['currency_amount'],2,',','.') ?>">
                                                        <input type="hidden" name="txt_doviz_kuru_eski" id="txt_doviz_kuru_eski" class="form-control form-control-lg form-control-lg text-end " placeholder="0,0000" onkeypress="return SadeceRakam(event,[',']);" value="<?= number_format($order_item['currency_amount'],2,',','.') ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="txt_doviz_kuru">TRY</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-3 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="obligation">Sipariş Tarihi</label>
                                                    <span class="form-note d-none d-md-block">Sipariş tarihi seçiniz.</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-nowrap col-lg-7 col-xxl-7">
                                                <div class="col-lg-6 col-xxl-5 col-6 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                            </div>
                                                            <input type="text" class="form-control  form-control-lg form-control-lg date-picker" name="order_date" value="<?= convert_date_for_view($order_item['order_date']) ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xxl-5 col-4 mt-0 mt-md-2 ps-1">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni icon-lg ni-clock"></em>
                                                            </div>
                                                            <input type="text" class="form-control  form-control-lg form-control-lg time-picker" name="order_time" value="<?= convert_time_for_form($order_item['order_date']) ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-3 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="obligation">Sipariş Fişi</label>
                                                    <span class="form-note d-none d-md-block">Sipraiş fişi olarak kullan</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-7  mt-0 mt-md-4">
                                                <ul class="custom-control-group">
                                                    <li>
                                                        <div class="custom-control custom-checkbox custom-control-pro">
                                                            <input type="checkbox" 
                                                         
                                                            class="custom-control-input" name="chx_quickSale" id="chx_quickSale" <?= $order_item['fatura'] == 1 ? 'checked' : '' ?> >
                                                            <label class="custom-control-label" for="chx_quickSale">
                                                                Evet
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>


                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-3 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="is_deadline">Termin Tarihi</label>
                                                    <span class="form-note d-none d-md-block">Bu sipraiş için termin tarihi ekleyebilirsiniz.</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-7  mt-0 mt-md-4">
                                                <ul class="custom-control-group">
                                                    <li>
                                                        <div class="custom-control custom-checkbox custom-control-pro">
                                                            <input type="checkbox" class="custom-control-input" name="is_deadline" id="is_deadline" <?= $order_item['is_deadline'] == 1 ? 'checked' : '' ?>>
                                                            <label class="custom-control-label" for="is_deadline">
                                                                Evet
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center <?= $order_item['is_deadline'] == 1 ? '' : 'd-none' ?>" id="is_deadline_area">
                                            <div class="col-lg-5 col-xxl-3 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="is_deadline_date">Termin Tarihi</label>
                                                    <span class="form-note d-none d-md-block">Bu sipraiş için termin tarihini belirtiniz.</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-nowrap col-lg-7 col-xxl-8 align-items-baseline">

                                                <div class="col-lg-6 col-xxl-3 col-6 mt-0 mt-md-2 pe-1">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right">
                                                                <em class="icon ni icon-lg ni-calendar-alt"></em>
                                                            </div>
                                                            <input type="text" class="form-control  form-control-lg form-control-lg date-picker" name="deadline_date" id="deadline_date" value="<?= $order_item['is_deadline'] == 1 ? convert_date_for_view($order_item['deadline_date']) : date('d/m/Y') ?>" placeholder="Termin Tarihi">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-xxl-8 col-6 mt-0 mt-md-2 ps-1 pe-1">
                                                    <div class="form-group">
                                                        <button class="btn btn-dim btn-outline-dark setDateTimePicker" day-value="3">+3 Gün</button>
                                                        <button class="btn btn-dim btn-outline-dark setDateTimePicker" day-value="5">+5 Gün</button>
                                                        <button class="btn btn-dim btn-outline-dark setDateTimePicker" day-value="7">+1 Hafta</button>
                                                        <button class="btn btn-dim btn-outline-dark setDateTimePicker" day-value="14">+2 Hafta</button>
                                                        <button class="btn btn-dim btn-outline-dark setDateTimePicker" day-value="30">+1 Ay</button>
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
                                                            <label class="form-label d-lg-none mt-2 mb-0" for="txt_aciklama">Mal/Hizmet/Açıklama</label>
                                                            <div class="form-control-wrap">
                                                                <div class="input-group">
                                                                    <input type="text" satir="" class="form-control  " urun_id="0" str_id="0" id="txt_aciklama_" value="">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-outline-primary btn-dim btn_urun_sec" data-satir="" id="btn_urunSec"><span>Seç</span></button>
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
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5 col-4">
                                                                <div class="form-group">
                                                                    <label class="form-label d-lg-none mt-2 mb-0" for="txt_birim">Birim</label>
                                                                    <div class="form-control-wrap">
                                                                        <select class="form-select form-select-lg form-control  ftr_select select_birim_yeniSipariş" data-ui="lg" data-search="on" id="slct_birim_" satir="" data-ui="lg" data-placeholder="Seçiniz">
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
                                            <?php $startZero = 0;
                                            foreach ($order_rows as $order_row) {   ?>

                                                <div class="row no-gutters mb-2 ftr_str " id="Satir_<?= $startZero ?>" visible="true" order_row_id="<?= $order_row['order_row_id'] ?>">
                                                    <div class="col-lg-11">
                                                        <div class="row no-gutter">
                                                            <div class="col-lg-3 col-sm-6 pe-sm-1">
                                                                <div class="form-group">
                                                                    <label class="form-label mt-2 mb-0" for="txt_aciklama_<?= $startZero ?>">Mal/Hizmet/Açıklama</label>
                                                                    <div class="form-control-wrap str_kaldir">
                                                                        <div class="input-group">
                                                                            <?php if(!empty($order_row["dopigo_title"])){
                                                                                $order_title = $order_row["dopigo_title"];
                                                                            }else{
                                                                                $order_title = $order_row["stock_title"];

                                                                            } ?>
                                                                            <input type="text" satir="<?= $startZero ?>" class="form-control" urun_id="<?= $order_row['stock_id'] ?>" str_id="<?= $startZero ?>" id="txt_aciklama_<?= $startZero ?>" value="<?= $order_title ?>">
                                                                            <div class="input-group-append">
                                                                                <button class="btn btn-outline-primary btn-dim btn_urun_sec" data-satir="<?= $startZero ?>"><span>Seç</span></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php if($order_row["stock_id"] == 0): ?>
                                                                      <div class="form-control-wrap d-none" style="float:right; margin-top:3px;">
                                                                      <button class="btn btn-outline-primary btn-dim btn_urun_sec" data-satir="<?= $startZero ?>"><span>ÜRÜNLE EŞLEŞTİR</span></button>
                                                                      </div>  
                                                                      <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6 pe-sm-1 ps-sm-0">
                                                                <div class="row  g-1">
                                                                    <div class="col-lg-3 col-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label mt-2 mb-0" for="txt_miktar_<?= $startZero ?>">Miktar</label>
                                                                            <div class="form-control-wrap str_kaldir">
                                                                                <input type="text" class="form-control   text-end px-1 ftr_hesap para" placeholder="0" id="txt_miktar_<?= $startZero ?>" satir="<?= $startZero ?>" value="<?= number_format($order_row['stock_amount'], 2, ',', '.') ?>" onkeypress="return SadeceRakam(event,[',']);">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-5 col-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label mt-2 mb-0 " for="slct_birim_<?= $startZero ?>">Birim</label>
                                                                            <div class="form-control-wrap str_kaldir">
                                                                                <select class="form-select js-select2 form-control  ftr_select select_birim_yeniFatura" data-search="on" id="slct_birim_<?= $startZero ?>" satir="<?= $startZero ?>" data-placeholder="Seçiniz">
                                                                                    <option></option>

                                                                                </select>
                                                                                <input type="hidden" name="base_slct_birim" id="base_slct_birim_<?= $startZero ?>" value="<?= $order_row['unit_id'] ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label mt-2 mb-0" for="txt_birim_fiyat_<?= $startZero ?>">Birim Fiyat</label>
                                                                            <div class="form-control-wrap str_kaldir">
                                                                                <input type="text" class="form-control   text-end px-1 ftr_hesap para" id="txt_birim_fiyat_<?= $startZero ?>" placeholder="0,00" satir="<?= $startZero ?>" value="<?= number_format($order_row['unit_price'], 2, ',', '.') ?>" onkeypress="return SadeceRakam(event,[',']);">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-sm-4 col-md-4 col-8 pe-sm-1 ps-sm-2 ps-lg-0">
                                                                <div class="row g-1">
                                                                    <div class="col-lg-6 col-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label mt-2 mb-0" for="txt_iskonto_orani_<?= $startZero ?>">İsk. %</label>
                                                                            <div class="form-control-wrap str_kaldir">
                                                                                <input type="text" class="form-control   text-end px-1 ftr_hesap para ftr_hesap para ftr_hesap_iskonto_yuzde" placeholder="0" id="txt_iskonto_orani_<?= $startZero ?>" satir="<?= $startZero ?>" value="<?= number_format($order_row['discount_rate'], 2, ',', '.') ?>" onkeypress="return SadeceRakam(event,[',']);">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label mt-2 mb-0" for="txt_iskonto_tutari_<?= $startZero ?>">İsk. Tutarı</label>
                                                                            <div class="form-control-wrap str_kaldir">

                                                                                <input type="text" class="form-control   text-end px-1 ftr_hesap para ftr_hesap para txt_iskonto_tutari" id="txt_iskonto_tutari_<?= $startZero ?>" placeholder="0,00" satir="<?= $startZero ?>" value="<?= number_format($order_row['discount_price'], 2, ',', '.') ?>" onkeypress="return SadeceRakam(event,[',']);">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1 col-sm-4 col-md-2 col-4 pe-sm-1 ps-sm-0">
                                                                <div class="form-group">
                                                                    <label class="form-label mt-2 mb-0" for="txt_ara_toplam_<?= $startZero ?>">A. Toplam</label>
                                                                    <div class="form-control-wrap str_kaldir">
                                                                        <input type="text" class="form-control   text-end px-1 ftr_hesap para" value="<?= number_format($order_row['subtotal_price'], 2, ',', '.') ?>" disabled="" id="txt_ara_toplam_<?= $startZero ?>" placeholder="" satir="<?= $startZero ?>" onkeypress="return SadeceRakam(event,[',']);">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-sm-4 col-8 pe-sm-1 ps-sm-0">
                                                                <div class="row g-1">
                                                                    <div class="col-lg-6 col-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label mt-2 mb-0" for="slct_kdv_<?= $startZero ?>">KDV %</label>
                                                                            <div class="form-control-wrap str_kaldir">
                                                                                <select class="form-select form-control js-select2 ftr_select ftr_select_yeni_fatura para" data-search="on" id="slct_kdv_<?= $startZero ?>" satir="<?= $startZero ?>" data-placeholder="Seçiniz">
                                                                                    <option></option>
                                                                                    <?php foreach (session()->get('tax_rate_items') as $item) { ?>
                                                                                        <option value="<?= $item['tax_value'] ?>"> <?= $item['tax_name'] ?> </option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <input type="hidden" name="base_slct_kdv" id="base_slct_kdv_<?= $startZero ?>" value="<?= $order_row['tax_id'] ?>">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label mt-2 mb-0" for="txt_kdv_<?= $startZero ?>">KDV Tutarı</label>
                                                                            <div class="form-control-wrap str_kaldir">
                                                                                <input type="text" class="form-control text-end px-1 para" id="txt_kdv_<?= $startZero ?>" placeholder="0,00" satir="<?= $startZero ?>" value="<?= $order_row['tax_price'] ?>" disabled="">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1 col-sm-4 col-md-2 col-4 ps-sm-2 ps-md-0">
                                                                <div class="form-group">
                                                                    <label class="form-label mt-2 mb-0" for="txt_genel_toplam_<?= $startZero ?>">G.Toplam</label>
                                                                    <div class="form-control-wrap str_kaldir">
                                                                        <input type="text" class="form-control   text-end px-1 genel_toplam_hesapla para" value="0,00" id="txt_genel_toplam_<?= $startZero ?>" placeholder="" satir="<?= $startZero ?>">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1  ps-lg-2 ps-sm-0">
                                                        <div class="row g-1">
                                                            <div class="col-6 text-center">
                                                                <label class="form-label mt-2 mb-0" for="btn_ekle_<?= $startZero ?>"><span class=" d-none d-lg-block">Ekle</span></label>
                                                                <button id="btn_ekle_<?= $startZero ?>" class="btn btn-icon btn-primary btn-block satir_ekle str_kaldir" satir="<?= $startZero ?>"><em class="icon ni ni-plus"></em></button>
                                                            </div>
                                                            <div class="col-6 ps-sm-1 text-center">
                                                                <label class="form-label mt-2 mb-0" for="btn_sil_<?= $startZero ?>"><span class=" d-none d-lg-block">Kaldır</span></label>
                                                                <button id="btn_sil_<?= $startZero ?>" class="btn btn-icon btn-danger btn-block satir_sil" satir="<?= $startZero ?>"><em class="icon ni ni-trash"></em></button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- ÖNEMLİ Bunun seçilmesi için fatura tipi tevkifat olmalı.!!! -->
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
                                                                        <input type="hidden" name="base_slct_tevkifat_tipi_" id="base_slct_tevkifat_tipi_<?= $startZero ?>" value="">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-sm-6 pe-sm-1 ps-sm-0">
                                                                <div class="row  g-1">
                                                                    <div class="col-lg-4 col-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label mb-0 mt-1" for="txt_V9015_oran_<?= $startZero ?>">Tevkifat %</label>
                                                                            <div class="form-control-wrap">
                                                                                <input type="text" class="form-control   text-end px-1 ftr_hesap para" placeholder="0" id="txt_V9015_oran_<?= $startZero ?>" value="" disabled="">

                                                                                <!-- Sadece diğer seceneginde disabled kalkacak oranı kendi girecek. -->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-5 col-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label mb-0 mt-1" for="txt_V9015_oran_<?= $startZero ?>">Tevkifat Tutar</label>
                                                                            <div class="form-control-wrap">
                                                                                <input type="text" class="form-control   text-end px-1 ftr_hesap para" placeholder="0,00" id="txt_V9015_<?= $startZero ?>" value="" onkeypress="return SadeceRakam(event,[',']);">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <input type="hidden" name="" id="txt_V9015_islem_tutar_<?= $startZero ?>">
                                                            <input type="hidden" name="" id="txt_V9015_hesaplanan_kdv_<?= $startZero ?>">

                                                        </div>
                                                    </div>

                                                    <!-- ÖNEMLİ Bunun seçilmesi için fatura tipi istisna olmalı.!!! -->
                                                    <div class="col-lg-11 col-sm-12 pr-sm-1 pl-sm-0 gtip" style="display:none">
                                                        <div class="row  g-1">
                                                            <div class="col-lg-3 col-12  py-2">
                                                                <div class="form-group">
                                                                    <label class="form-label mb-0 mt-1" for="txt_gtip_<?= $startZero ?>">GTİP Kodu</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control px-1" placeholder="GTİP Kodunuzu Giriniz" id="txt_gtip_<?= $startZero ?>" satir="<?= $startZero ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                            <?php $startZero += 1;
                                            } ?>
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
                                                        <input type="hidden" name="base_slct_note" id="base_slct_note" value="<?= $order_item['order_note_id'] ?>">
                                                    </div>
                                                </div>


                                                <div class="form-group d-none" id="fatura_not_baslik_area">
                                                    <label class="form-label mb-0" for="txt_fatura_not_baslik">Sipariş Notu Başlığı</label>
                                                    <div class="form-control-wrap str_kaldir">
                                                        <input class="form-control form-control-lg" id="txt_fatura_not_baslik" name="txt_fatura_not_baslik" placeholder="Sipariş Notu Başlığı Yazınız">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label mb-0" for="txt_fatura_not">Sipariş Notu</label>
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
                                        <input type="hidden" name="" id="txt_created_order_id" value="">

                                        <div class="mt-5 bg-white">
                                            <button type="button" class="btn btn-secondary mb-2 btnPrevious" id="prevButton">Önceki</button>
                                            <button type="button" class="btn btn-success mb-2 btnEditOrder" id="btnEditOrder">Sipariş Kaydet</button>
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
        'element' => 'success_create_invoice',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Siprişiniz başarıyla düzenlendi.',
                'modal_buttons' => '<a href="" id="orderDetail" class="btn btn-primary btn-block mb-2">Sipariş Detayına Git</a>
                                    <a href="' . route_to('tportal.siparisler.list', 'all') . '" class="btn btn-l btn-dim btn-outline-dark btn-block mb-2">Sipariş Listesini Gör</a>'
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
        'fromWhere' => 'createOrder'
    ]
); ?>
<?= view_cell(
    'App\Libraries\ViewComponents::getSearchStockModal'
); ?>
<?= view_cell(
    'App\Libraries\ViewComponents::getSearchSubStockModal'
); ?>

<script>




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


    $('#address_country').val('<?= $order_item['address_country'] ?>').trigger('change');

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

      $('#address_city').val('<?= $order_item['address_city'] ?>');

      $('#address_district').val('<?= $order_item['address_district'] ?>');

      $("#address_city_name").val($("#address_city").val());



  }else{

 
 
    $('#Iller').val('<?= $order_item['address_city_plate'] ?>');
          $('#Iller').trigger('change');

         $('#Ilceler').val('<?= $order_item['address_district'] ?>');
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
                        $('#customer_info_area').removeClass('d-none');

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
                $('#customer_info_area').removeClass('d-none');

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

            setTimeout(() => {
                    $("#is_customInvoiceNo").trigger("checked");
                }, 300);

            $('#irsaliye_alani').addClass('d-none');
        });

        $(document).on("change", "#fatura_senaryo", function() {
            var selected_fatura_senaryo = $('#fatura_senaryo').val();
        });


        

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


</script>

<?= $this->endSection() ?>