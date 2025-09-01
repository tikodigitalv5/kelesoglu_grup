<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Tahsilat/Ödeme Oluştur <?= $this->endSection() ?>
<?= $this->section('title') ?> Tahsilat/Ödeme Oluştur | <?= session()->get('user_item')['firma_adi'] ?>
<?= $this->endSection() ?>
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
                                        <h4 class="nk-block-title">Tahsilat/Ödeme</h4>
                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <form onsubmit="return false;" id="createPaymentOrCollectionForm" method="POST">

                                    <div class="gy-3">
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-name">Müşteri</label>
                                                    <span class="form-note d-none d-md-block" style="">Satış yapılacak
                                                        müşteriyi seçin veya ekleyin.</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-xl"
                                                            id="cari_info" name="cari_info"
                                                            value=""
                                                            placeholder="Müşteri seçmek için tıklayınız..">
                                                        <div class="input-group-append">
                                                            <a href="javascript;" id="btn_musteriSec"
                                                                data-bs-toggle="modal" data-bs-target="#mdl_musteriSec"
                                                                class="btn btn-lg btn-block btn-dim btn-outline-primary"
                                                                >Müşteri
                                                                Seç</a>
                                                            <!-- <button class="btn btn-lg btn-block btn-dim btn-outline-light">EKLE</button> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5 col-xxl-5 ">
                                                <div class="form-group"><label class="form-label" for="site-name">Ödeme
                                                        / Tahsilat</label><span
                                                        class="form-note d-none d-md-block">Ödeme Aldıysanız
                                                        TAHSİLAT.<br>Ödeme yaptıysanız ÖDEME seçiniz.</span></div>
                                            </div>
                                            <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                <ul class="custom-control-group">
                                                    <li>
                                                        <div
                                                            class="custom-control custom-control-sm custom-radio custom-control-pro transaction_type">
                                                            <input type="radio" class="custom-control-input"
                                                                name="transaction_type" id="transaction_type_collection"
                                                                value="collection" required>
                                                            <label class="custom-control-label"
                                                                for="transaction_type_collection">
                                                                <span>TAHSİLAT</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div
                                                            class="custom-control custom-control-sm custom-radio custom-control-pro transaction_type">
                                                            <input type="radio" class="custom-control-input"
                                                                name="transaction_type" id="transaction_type_payment"
                                                                value="payment" required>
                                                            <label class="custom-control-label"
                                                                for="transaction_type_payment">
                                                                <span>ÖDEME</span>
                                                            </label>
                                                        </div>
                                                    </li>

                                                    <li>
                                                            <div
                                                                class="custom-control custom-control-sm custom-radio custom-control-pro transaction_type">
                                                                <input type="radio" class="custom-control-input"
                                                                    name="transaction_type"
                                                                    id="transaction_type_starting_balance"
                                                                    value="diger" required>
                                                                <label class="custom-control-label"
                                                                    for="transaction_type_starting_balance">
                                                                    <span>DİĞER</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                 
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="g-3" id="t_o_area">



                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="site-name">İşlem Hesabı</label>
                                                        <span class="form-note d-none d-md-block">İşlem yapılan hesabı
                                                            seçiniz veya ekleyiniz.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-xl"
                                                                id="account" name="account" disabled
                                                                placeholder="Hesap seçmek için tıklayınız..">
                                                            <div class="input-group-append">
                                                                <button data-bs-toggle="modal"
                                                                    data-bs-target="#mdl_hesaplar"
                                                                    class="btn btn-lg btn-block btn-dim btn-outline-light">SEÇ</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="site-name">Tutar, Para Birimi ve
                                                            Tarihi</label>
                                                        <span class="form-note d-none d-md-block">İşlem yapılan tutar,
                                                            para birimi ve tarih bilgisini giriniz.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control form-control-xl text-end"
                                                                name="transaction_amount" id="transaction_amount"
                                                                onkeypress="return SadeceRakam(event,[',']);"
                                                                placeholder="0,00">
                                                            <div class="input-group-append">
                                                                <button data-bs-toggle="modal"
                                                                    data-bs-target="#mdl_parabirimi"
                                                                    class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                    <span id="moneyUnit">SEÇ</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="" style="width: 160px">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left"
                                                            style="width: calc(1rem + 30px); top:1px">
                                                            <em class="icon ni ni-calendar icon-xl"></em>
                                                        </div>
                                                        <input id="transaction_date" name="transaction_date" type="text"
                                                            class="form-control form-control-xl date-picker"
                                                            style="padding-right: 16px; padding-left: 44px;"
                                                            data-date-format="dd/mm/yyyy" value="<?= date('d/m/Y') ?>">
                                                    </div>
                                                </div>
                                            </div>

                                        <div class="check_bill d-none">
                                        <div class="row g-3 align-center para_birimi_icin_ac d-none">
                                            <div class="col-lg-5 col-xxl-5  ">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-name">ÇEK Senet Seçildi </label>
                                                    <span class="form-note d-none d-md-block">Carinin para birimine ve işlemin <br> para birimine göre kur girilmelidir.</span>
                                                </div>
                                            </div>

                                            <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control form-control-xl text-end"
                                                                name="donusturulecek_kur" id="donusturulecek_kur"
                                                                onkeypress="return SadeceRakam(event,[',']);"
                                                                placeholder="0,00">
                                                            <div class="input-group-append">
                                                                <button 
                                                                    
                                                                    class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                    <span class="money_kod"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control form-control-xl text-end"
                                                                name="toplam_kur" readonly id="toplam_kur"
                                                                onkeypress="return SadeceRakam(event,[',']);"
                                                                placeholder="0,00">
                                                            <div class="input-group-append">
                                                                <button 
                                                                    class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                    <span class="money_kod"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                       
                                        </div>
                                        </div>

                                        <div class="row g-3 align-center para_birimi_icin_ac d-none">
                                            <div class="col-lg-5 col-xxl-5  ">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-name">Kur'a Göre Karşılığı </label>
                                                    <span class="form-note d-none d-md-block">Carinin para birimine ve işlemin <br> para birimine göre kur girilmelidir.</span>
                                                </div>
                                            </div>

                                            <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control form-control-xl text-end"
                                                                name="donusturulecek_kur" id="donusturulecek_kur"
                                                                onkeypress="return SadeceRakam(event,[',']);"
                                                                placeholder="0,00">
                                                            <div class="input-group-append">
                                                                <button 
                                                                    
                                                                    class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                    <span class="money_kod"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control form-control-xl text-end"
                                                                name="toplam_kur" readonly id="toplam_kur"
                                                                onkeypress="return SadeceRakam(event,[',']);"
                                                                placeholder="0,00">
                                                            <div class="input-group-append">
                                                                <button 
                                                                    class="btn btn-lg btn-block btn-dim btn-outline-light">
                                                                    <span class="money_kod"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                       
                                        </div>

                                        <input type="hidden" name="islem_kuru" id="islem_kuru" value="">



                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="urun_adi">İşlem Başlık</label>
                                                        <span class="form-note d-none d-md-block">Cari hareketlerinzde
                                                            gözükebilir yazarsanız.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text"
                                                                class="form-control form-control-xl"
                                                                id="transaction_title" name="transaction_title" value=""
                                                                placeholder="Örn : Ön Ödeme"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label"
                                                            for="transaction_description">İşlem Notu</label>
                                                        <span class="form-note d-none d-md-block">Sadece sizin detayda
                                                            görebileceğiniz br nottur.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control form-control-lg"
                                                                name="transaction_description"
                                                                id="transaction_description" cols="30"
                                                                rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <input type="hidden" name="financial_account_id" id="financial_account_id"
                                            value="">
                                        <input type="hidden" name="money_unit_id" id="money_unit_id" value="">
                                        <input type="hidden" name="cari_id" id="cari_id" value="">

                                    </div>
                                    <div class="d-none" id="sb_area">




<div class="row g-3 align-center">
    <div class="col-lg-5 col-xxl-5 ">
        <div class="form-group"><label class="form-label" for="site-name">İşlem Seçiniz
    </label><span
                class="form-note d-none d-md-block">Başlangıç Bakiyesi veya <br>Borç Alacak/Verecek Ekleyebilirsiniz</span></div>
    </div>
    <div class="col-lg-4 col-xxl-7  mt-0 mt-md-2">
        <ul class="custom-control-group">
      
            <li>
                <div
                    class="custom-control custom-control-sm custom-radio custom-control-pro ">
                    <input type="radio" class="custom-control-input"
                        name="transaction_type" id="transaction_type_baslangic"
                        value="starting_balance" required checked>
                    <label class="custom-control-label"
                        for="transaction_type_baslangic">
                        <span>BAŞLANGIÇ BAKİYESİ</span>
                    </label>
                </div>
            </li>
         
            <li>
                <div
                    class="custom-control custom-control-sm custom-radio custom-control-pro ">
                    <input type="radio" class="custom-control-input"
                        name="transaction_type" id="transaction_type_borc"
                        value="borc_alacak" required>
                    <label class="custom-control-label"
                        for="transaction_type_borc">
                        <span>BORÇ/ALACAK/VERECEK EKLE</span>
                    </label>
                </div>
            </li>
           
             


        
        </ul>
    </div>
</div>

   

    
            <div class="row g-3 align-center mt-1 acilis d-none">
        <div class="col-lg-4 col-xxl-5 ">
            <div class="form-group">
                <label class="form-label" for="site-name">Açılış Bakiyesi /
                    Tarihi</label>
                <span class="form-note d-none d-md-block">Cari için açılış
                    bakiyesi belirleyebilirsiniz. <br> Alacaklı ise tutarı
                    başına (-) eksi ile giriniz.</span>
            </div>
        </div>
        <div class="col mt-0 mt-md-2">
            <div class="form-group">
                <div class="input-group">
                    <input type="text"
                        class="form-control form-control-xl text-end"
                        name="sb_transaction_amount" id="sb_transaction_amount"
                        onkeypress="return SadeceRakam(event,[',','-']);"
                        placeholder="0,00">
                </div>
            </div>
        </div>

        <div class="" style="width: 180px">
            <div class="form-control-wrap">
                <div class="form-icon form-icon-left"
                    style="width: calc(1rem + 30px); top:1px">
                    <em class="icon ni ni-calendar icon-xl"></em>
                </div>
                <input id="transaction_dates" name="transaction_dates" type="text"
                    class="form-control form-control-xl date-picker"
                    style="padding-right: 16px; padding-left: 44px;"
                    data-date-format="dd/mm/yyyy" value="<?= date('d/m/Y') ?>">
            </div>
        </div>
      </div>
 
        <div class="row g-3 align-center mt-1 borc_alacak d-none">


        <div class="col-lg-4 col-xxl-5 ">
            <div class="form-group">
                <label class="form-label" for="site-name">Borç Alacak/Verecek Ekle /
                    Tarihi</label>
                <span class="form-note d-none d-md-block">Cari için borç alacak verisi ekleyebilirsiniz  <br> Alacaklı ise tutarı 
                    başına (-) eksi ile giriniz.</span>
            </div>
        </div>
        <div class="col mt-0 mt-md-2">
            <div class="form-group">
                <div class="input-group">
                    <input type="text"
                        class="form-control form-control-xl text-end"
                        name="borc_alacak" id="borc_alacak"
                        onkeypress="return SadeceRakam(event,[',','-']);"
                        placeholder="0,00">
                </div>
            </div>
        </div>

        <div class="" style="width: 180px">
            <div class="form-control-wrap">
                <div class="form-icon form-icon-left"
                    style="width: calc(1rem + 30px); top:1px">
                    <em class="icon ni ni-calendar icon-xl"></em>
                </div>
                <input id="borc_dates" name="borc_dates" type="text"
                    class="form-control form-control-xl date-picker"
                    style="padding-right: 16px; padding-left: 44px;"
                    data-date-format="dd/mm/yyyy" value="<?= date('d/m/Y') ?>">
            </div>
        </div>
        </div>
 





        <div class="row g-3 align-center mt-1">
        <div class="col-lg-4 col-xxl-5 ">
            <div class="form-group"><label class="form-label"
                    for="urun_adi">İşlem Başlık</label>
                <span class="form-note d-none d-md-block">Cari hareketlerinzde
                    gözükebilir yazarsanız.</span>
            </div>
        </div>
        <div class="col mt-0 mt-md-2">
            <div class="form-group">
                <div class="form-control-wrap"><input type="text"
                        class="form-control form-control-xl"
                        id="borc_transaction_title" name="borc_transaction_title" value=""
                        placeholder="Örn : Ön Ödeme"></div>
            </div>
        </div>
    </div>

    <div class="row g-3 align-center mt-1">
        <div class="col-lg-4 col-xxl-5 ">
            <div class="form-group"><label class="form-label"
                    for="transaction_description">İşlem Notu</label>
                <span class="form-note d-none d-md-block">Sadece sizin detayda
                    görebileceğiniz br nottur.</span>
            </div>
        </div>
        <div class="col mt-0 mt-md-2">
            <div class="form-group">
                <div class="form-control-wrap">
                    <textarea class="form-control form-control-lg"
                        name="borc_transaction_description"
                        id="borc_transaction_description" cols="30"
                        rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>



  
</div>
                                    <div class="row g-3 pt-3">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <!-- <a href="javascript:history.back()" class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Geri</span></a> -->
                                            </div>
                                        </div>
                                        <div class="col-6 text-end">
                                            <div class="form-group">
                                                <button type="submit" id="savePaymentOrCollection"
                                                    class="btn btn-lg btn-primary">Kaydet</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div><!-- .nk-block -->
                        </div>

                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
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
                            foreach ($financial_account_items as $financial_account_item) { ?>
                                <tr>

                                    <td data-order="0">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="radioSizeAccount"
                                                accName="<?= $financial_account_item['account_title']; ?>"
                                                accType="<?= $financial_account_item['account_type']; ?>"
                                                accMoneyUnitId="<?= $financial_account_item['money_unit_id']; ?>"
                                                accMoneyUnitName="<?= $financial_account_item['money_code']; ?>"
                                                id="<?= $financial_account_item['financial_account_id'] ?>" />
                                            <label class="custom-control-label"
                                                for="<?= $financial_account_item['financial_account_id'] ?>"><?= $financial_account_item['account_title']; ?></label>
                                        </div>
                                    </td>
                                    <td><?php if (isset($bank_items) && $financial_account_item['bank_id'] != null) {
                                        echo $bank_items[array_search($financial_account_item['bank_id'], array_column($bank_items, 'bank_id'))]['bank_title'];
                                    } else {
                                        echo " - ";
                                    } ?></td>
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
                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg btn-dim btn-outline-light"
                            data-bs-dismiss="modal" aria-label="Close">KAPAT</button>

                    </div>
                    <div class="col-md-8 text-end p-0">

                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ
                            HESAP</button>
                        <button type="button" id="btn_hesapsec_mdl" class="btn btn-lg btn-primary ">SEÇ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Para Birimi Modal -->
<div class="modal fade" tabindex="-1" id="mdl_parabirimi">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Para Birimi Seçiniz</h5>
                <a href="#" id="btn_mdl_parabirimi_kapat" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <table class=" table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Birim Adı</th>
                            <th data-orderable="false">Kodu</th>
                            <th data-orderable="false">Simgesi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (isset($all_money_unit)) {
                            foreach ($all_money_unit as $money_unit) { ?>
                                <tr>
                                    <td data-order="0">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="radioSize"
                                                id="customRadio<?= $money_unit['money_unit_id'] ?>"
                                                value="<?= $money_unit['money_unit_id'] ?>"
                                                money_code="<?= $money_unit['money_code'] ?>">
                                            <label class="custom-control-label"
                                                for="customRadio<?= $money_unit['money_unit_id'] ?>"><?= $money_unit['money_title'] ?></label>
                                        </div>
                                    </td>
                                    <td><?= $money_unit['money_code'] ?></td>
                                    <td><?= $money_unit['money_icon'] ?></td>
                                </tr>
                            <?php }
                        } ?>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_parabirimisec_mdl" class="btn btn-lg btn-primary">SEÇ</button>
            </div>
        </div>
    </div>
</div>




<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'create_payment_or_collection',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => '<span id="paymentCollectionText"></span>',
                'modal_buttons' => '<a href="' . route_to('tportal.cariler.payment_or_collection_create_page') . '" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Tahsilat/Ödeme Ekle</a>'
            ],
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= view_cell(
    'App\Libraries\ViewComponents::getSearchCustomerModal',
    [
        'fromWhere' => 'createInvoice'
    ]
); ?>

<script>
    $(document).ready(function () {
        $('#transaction_amount').mask('000.000.000,00', {
            reverse: true
        });

        let searchParams = new URLSearchParams(window.location.search)
        let param = searchParams.get('q')

        if (param == "tahsilat")
            $('#transaction_type_collection').attr('checked', true);
        if (param == "odeme")
            $('#transaction_type_payment').attr('checked', true);


       

        $('#btn_parabirimisec_mdl').click(function () {
            var selectedBaseMoneyCode = $('input[name="radioSize"]:checked').attr('money_code'); //TRY
            var selectedBaseMoneyID = $('input[name="radioSize"]:checked').attr('value');

            $('#moneyUnit').empty().append(selectedBaseMoneyCode);
            $('#money_unit_id').empty().val(selectedBaseMoneyID);
            $('#mdl_parabirimi').modal('hide');

        });

        // $('.rd_cari').click(function () {
        $(document).on("click", ".rd_cari", function () {
            $('#mdl_musteriSec').modal('hide');
            selectedCariId = $('.rd_cari:checked').val();
            selectedCariInvoiceTitle = $('.rd_cari:checked').attr('invoice_title');
            selectedCariInvoiceName = $('.rd_cari:checked').attr('invoice_name');
            selectedCariInvoiceSurname = $('.rd_cari:checked').attr('invoice_surname');
            money_tipi = $('.rd_cari:checked').attr('money_tipi');

            
            $('#cari_id').val($('.rd_cari:checked').val());

            console.log(selectedCariId, selectedCariInvoiceTitle);

            lastTitle = selectedCariInvoiceTitle == '' ? selectedCariInvoiceName + " " + selectedCariInvoiceSurname : selectedCariInvoiceTitle;
            $('#cari_info').val(lastTitle);
        });
    });





  $('#btn_hesapsec_mdl').click(function() {

var selectedAccount = $('input[name="radioSizeAccount"]:checked').attr('id');
var selectedAccountName = $('input[name="radioSizeAccount"]:checked').attr('accName');
var selectedAccountType = $('input[name="radioSizeAccount"]:checked').attr('accType');
var selectedAccountMoneyId = $('input[name="radioSizeAccount"]:checked').attr('accMoneyUnitId');
var selectedAccountMoneyName = $('input[name="radioSizeAccount"]:checked').attr('accMoneyUnitName');

var secili_transaction_type = $('input[name="transaction_type"]:checked').attr('value');

if(secili_transaction_type == 'payment'){
  $(".check_bill").removeClass("d-none");
}else{
  $(".check_bill").addClass("d-none");
}

if(selectedAccountType == "check_bill"){
  $(".check_bill_var").addClass("d-none");

  $(".check_bill_div").removeClass("d-none");
}else{
  $(".check_bill_div").addClass("d-none");
  $(".check_bill_var").removeClass("d-none");


}


var  musteriParaTipi = money_tipi;

$(".money_kod").html(musteriParaTipi);

if (selectedAccount != null && selectedAccount != 0) {
     

     // Müşteri para birimi ve hesap para birimi kıyaslamaları
  if (selectedAccountMoneyName == 'TRY' && musteriParaTipi == 'USD') {
      $("#donusturulecek_kur").val(<?php echo $cari_itemd["dolarKur"] ?>).toFixed(2);
  }
  if (selectedAccountMoneyName == 'EUR' && musteriParaTipi == 'USD') {
      $("#donusturulecek_kur").val(<?php echo number_format($cari_itemd["euroKurCeviri"], 2, '.', '') ?>);
  }
  if (selectedAccountMoneyName == 'USD' && musteriParaTipi == 'EUR') {
      $("#donusturulecek_kur").val(<?php echo number_format($cari_itemd["dolarKurCeviri"], 2, '.', '') ?>);
  }
  if (musteriParaTipi == 'TRY' && selectedAccountMoneyName == 'USD') {
      $("#donusturulecek_kur").val(<?php echo number_format($cari_itemd["dolarKur"], 2, '.', '') ?>);
  }
  if (musteriParaTipi == 'TRY' && selectedAccountMoneyName == 'EUR') {
      $("#donusturulecek_kur").val(<?php echo number_format($cari_itemd["euroKur"], 2, '.', '') ?>);
  }
  if (musteriParaTipi == 'EUR' && selectedAccountMoneyName == 'TRY') {
      $("#donusturulecek_kur").val(<?php echo number_format($cari_itemd["euroKur"], 2, '.', '') ?>);
  }
  if (musteriParaTipi == 'EUR' && selectedAccountMoneyName == 'USD') {
      $("#donusturulecek_kur").val(<?php echo number_format($cari_itemd["euroKurCeviri"], 2, '.', '') ?>);
  }
  if (musteriParaTipi == 'USD' && selectedAccountMoneyName == 'TRY') {
      $("#donusturulecek_kur").val(<?php echo number_format($cari_itemd["dolarKur"], 2, '.', '') ?>);
  }
  if (musteriParaTipi == 'USD' && selectedAccountMoneyName == 'EUR') {
      $("#donusturulecek_kur").val(<?php echo number_format($cari_itemd["dolarKurCeviri"], 2, '.', '') ?>);
  }
  

  console.log("selectedAccountMoneyName " + selectedAccountMoneyName);



  // selectedAccount = selectedAccount.substring(11);
  $('#account').empty().val(selectedAccountName);
  $('#financial_account_id').empty().val(selectedAccount);
  $('#selectedAccountType').empty().val(selectedAccountType);
  $('#mdl_hesaplar').modal('hide');

  $('#moneyUnit').empty().append(selectedAccountMoneyName);

  $("#islem_kuru").val(selectedAccountMoneyName);


  if(selectedAccountMoneyName == money_tipi){
      $(".para_birimi_icin_ac").addClass("d-none");


  }else if(selectedAccountMoneyName == 'USD'){
    $(".para_birimi_icin_ac").removeClass("d-none");  

   


    
  }
  else if(selectedAccountMoneyName == 'EUR'){
    $(".para_birimi_icin_ac").removeClass("d-none");



  



  }else if(selectedAccountMoneyName == 'TRY'){
    $(".para_birimi_icin_ac").removeClass("d-none");

   

  }else{
    $(".para_birimi_icin_ac").addClass("d-none");

  }

  $('#money_unit_id').val(selectedAccountMoneyId);

  $('#customRadio' + selectedAccountMoneyId).attr('checked', 'checked');
} else {
  swetAlert("Lütfen işlem hesabı seçiniz", "", "err");
}

$("#transaction_amount").keyup(function() {



// Replace the comma with a dot and then parse as float
// Girilen değeri doğru işlemek için önce binlik virgülleri kaldırıyoruz
var transactionAmount = parseFloat($("#transaction_amount").val().replace(/\./g, '').replace(",", ".")) || 0;

// Kur değerini de düzgün işlemek için ondalık ayraçları noktaya çeviriyoruz (ama burada binlik ayracı zaten yok)
var exchangeRate = parseFloat($("#donusturulecek_kur").val().replace(",", ".")) || 0;


console.log("transactionAmount " + transactionAmount);
console.log("exchangeRate " + exchangeRate);


      

if(selectedAccountMoneyName == 'TRY' &&   musteriParaTipi == 'USD'){


  $("#donusturulecek_kur").val(<?php echo $cari_itemd["dolarKur"] ?>);

     
      var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'TRY' &&   musteriParaTipi == 'EUR'){


$("#donusturulecek_kur").val(<?php echo $cari_itemd["euroKur"] ?>);


var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'USD' &&   musteriParaTipi == 'EUR'){


$("#donusturulecek_kur").val(<?php echo $cari_itemd["dolarKurCeviri"] ?>);


var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'EUR' &&   musteriParaTipi == 'USD'){


$("#donusturulecek_kur").val(<?php echo $cari_itemd["euroKurCeviri"] ?>);


var total = (transactionAmount / exchangeRate).toFixed(2);

}else{
      var total = (transactionAmount * exchangeRate).toFixed(2);

}

// Calculate the total

// Convert the result back to a string with a comma as the decimal separator
var formattedTotal = total.replace(".", ",");

// Update the #toplam_kur input with the formatted result
$("#toplam_kur").val(formattedTotal);
});
$("#donusturulecek_kur").keyup(function() {


// Replace the comma with a dot and then parse as float
var transactionAmount = parseFloat($("#transaction_amount").val().replace(",", ".")) || 0;
var exchangeRate = parseFloat($("#donusturulecek_kur").val().replace(",", ".")) || 0;

// Calculate the total
if(selectedAccountMoneyName == 'TRY' &&   musteriParaTipi == 'USD'){


     
      var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'TRY' &&   musteriParaTipi == 'EUR'){




var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'USD' &&   musteriParaTipi == 'EUR'){




var total = (transactionAmount / exchangeRate).toFixed(2);

}else if(selectedAccountMoneyName == 'EUR' &&   musteriParaTipi == 'USD'){




var total = (transactionAmount / exchangeRate).toFixed(2);

}else{
      var total = (transactionAmount * exchangeRate).toFixed(2);

}

// Convert the result back to a string with a comma as the decimal separator
var formattedTotal = total.replace(".", ",");

// Update the #toplam_kur input with the formatted result
$("#toplam_kur").val(formattedTotal);
});

});


var selectedTransaction;
    $('input[name="transaction_type"]').on('change', function () {
        selectedTransaction = $('input[name="transaction_type"]:checked').val();

        console.log('Seçilen işlem tipi: ' + selectedTransaction);

        if (selectedTransaction === 'starting_balance') {
            console.log('starting_balance tespit edildi');
            $('#t_o_area').addClass('d-none');
            $('#sb_area').removeClass('d-none');


            $('.acilis').removeClass('d-none');
            $('.borc_alacak').addClass('d-none');


            



        }else if (selectedTransaction === 'diger') {

            $('#t_o_area').addClass('d-none');
            $('#sb_area').removeClass('d-none');

            $('.acilis').addClass('d-none');
            $('.borc_alacak').removeClass('d-none');
        }else if (selectedTransaction === 'borc_alacak') {
            console.log('borc_alacak tespit edildi');

            $('#t_o_area').addClass('d-none');
            $('#sb_area').removeClass('d-none');

            $('.acilis').addClass('d-none');
            $('.borc_alacak').removeClass('d-none');
        }
        else {
            $('.acilis').addClass('d-none');
            $('.borc_alacak').addClass('d-none');
            $('#t_o_area').removeClass('d-none');
            $('#sb_area').addClass('d-none');

        }
    });

    $('#savePaymentOrCollection').click(function (e) {
        e.preventDefault();
        var formData2 = $('#createPaymentOrCollectionForm').serializeArray();
        var lastCariId = $('#cari_id').val();
        var base_url = window.location.origin;
        console.log(base_url);
        console.log(formData2);
        if (selectedTransaction == 'starting_balance') {

            formData.push({
                name: "sb_transaction_amount",
                value: $('#sb_transaction_amount').val(),
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: base_url + '/tportal/cari/payment-or-collection/store/' + lastCariId,
                dataType: 'json',
                data: formData2,
                async: true,
                success: function (response) {
                    console.log(response);
                    if (response['icon'] == 'success') {
                        $('#createPaymentOrCollectionForm')[0].reset();
                        $('#paymentCollectionText').text(response.message);
                        $("#trigger_create_payment_or_collection_ok_button").click();
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
            });
        } else      if (selectedTransaction == 'borc_alacak') {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: base_url + '/tportal/cari/payment-or-collection/store/' + lastCariId,
                dataType: 'json',
                data: formData2,
                async: true,
                success: function (response) {
                    if (response['icon'] == 'success') {
                        $('#createPaymentOrCollectionForm')[0].reset();
                        $('#paymentCollectionText').text(response.message);
                        $("#trigger_create_payment_or_collection_ok_button").click();
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
        }else {
            if ($('.transaction_type').val() == null || $('#transaction_amount').val() == "" || $('#money_unit_id').val() == "" || $('#financial_account_id').val() == "" || $('#transaction_title').val() == "") {
                var formData = $('#createPaymentOrCollectionForm').serializeArray();
                swetAlert("Hatalı İşlem", "Lütfen sizden istenen bilgileri doldurunuz...", "err");
            } else {
                var formData = $('#createPaymentOrCollectionForm').serializeArray();
                var lastCariId = $('#cari_id').val();
                formData.push({
                    name: "money_unit_id",
                    value: $('#money_unit_id').val(),
                });
                formData.push({
                    name: "financial_account_id",
                    value: $('#financial_account_id').val(),
                });

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    type: 'POST',
                    url: base_url + '/tportal/cari/payment-or-collection/store/' + lastCariId,
                    dataType: 'json',
                    data: formData,
                    async: true,
                    success: function (response) {
                        if (response['icon'] == 'success') {
                            $('#createPaymentOrCollectionForm')[0].reset();
                            $('#paymentCollectionText').text(response.message);
                            $("#trigger_create_payment_or_collection_ok_button").click();
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

    $(document).ready(function() {
        // Form elemanlarını başlat
        $('.js-select2').select2();
        $('.date-picker').datepicker({
            language: 'tr',
            autoclose: true,
            todayHighlight: true
        });

        // Hesap tipi değiştiğinde
        $('input[name="radioSizeAccount"]').change(function() {
            const accountType = $(this).attr('accType');
            if(accountType === 'check_bill') {
                $('.check_bill').removeClass('d-none').hide().fadeIn(300);
            } else {
                $('.check_bill').fadeOut(300, function() {
                    $(this).addClass('d-none');
                });
            }
        });

        // Yeni çek ekleme butonu
        $('#btnNewCheck').click(function() {
            const $form = $('#newCheckForm');
            const $otherBtn = $('#btnSelectCheck');
            
            if($form.hasClass('d-none')) {
                $form.removeClass('d-none').hide().slideDown(300);
                $otherBtn.addClass('btn-dim');
                $(this).removeClass('btn-dim');
            } else {
                $form.slideUp(300, function() {
                    $(this).addClass('d-none');
                });
                $otherBtn.removeClass('btn-dim');
                $(this).addClass('btn-dim');
            }
        });

        // Çek seçme modalı açıldığında
        $('#modalSelectCheck').on('show.bs.modal', function() {
            const $tbody = $(this).find('.check-list');
            $tbody.html('<tr><td colspan="6" class="text-center">Yükleniyor...</td></tr>');

            // AJAX ile aktif çekleri getir
            $.ajax({
                url: '/tportal/checks/get-active-checks',
                method: 'GET',
                data: {
                    cari_id: $('#cari_id').val()
                },
                success: function(response) {
                    let html = '';
                    if(response.checks.length === 0) {
                        html = '<tr><td colspan="6" class="text-center">Aktif çek/senet bulunamadı</td></tr>';
                    } else {
                        response.checks.forEach(check => {
                            html += `
                                <tr>
                                    <td>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="check_select" id="check_${check.id}" value="${check.id}">
                                            <label class="custom-control-label" for="check_${check.id}"></label>
                                        </div>
                                    </td>
                                    <td><span class="tb-lead">${check.check_no}</span></td>
                                    <td><span class="tb-sub">${check.bank_title}</span></td>
                                    <td><span class="tb-amount">${formatMoney(check.amount)} ${check.currency}</span></td>
                                    <td><span class="tb-date">${formatDate(check.due_date)}</span></td>
                                    <td><span class="badge badge-dim badge-outline-primary">Portföyde</span></td>
                                </tr>
                            `;
                        });
                    }
                    $tbody.html(html);
                },
                error: function() {
                    $tbody.html('<tr><td colspan="6" class="text-center text-danger">Veriler yüklenirken bir hata oluştu</td></tr>');
                }
            });
        });

        // Seçilen çeki uygula
        $('#btnApplySelectedCheck').click(function() {
            const $selected = $('input[name="check_select"]:checked');
            if($selected.length === 0) {
                Swal.fire({
                    title: 'Uyarı',
                    text: 'Lütfen bir çek/senet seçiniz',
                    icon: 'warning',
                    confirmButtonText: 'Tamam'
                });
                return;
            }

            // Seçilen çekin bilgilerini forma aktar
            $.ajax({
                url: '/tportal/checks/get-check-details/' + $selected.val(),
                method: 'GET',
                success: function(response) {
                    $('#transaction_amount').val(formatMoney(response.check.amount));
                    $('#moneyUnit').text(response.check.currency);
                    $('#modalSelectCheck').modal('hide');
                    
                    Swal.fire({
                        title: 'Başarılı',
                        text: 'Çek/senet bilgileri tahsilat formuna aktarıldı',
                        icon: 'success',
                        confirmButtonText: 'Tamam'
                    });
                },
                error: function() {
                    Swal.fire({
                        title: 'Hata',
                        text: 'Çek/senet bilgileri alınırken bir hata oluştu',
                        icon: 'error',
                        confirmButtonText: 'Tamam'
                    });
                }
            });
        });

        // Para formatı için yardımcı fonksiyon
        function formatMoney(amount) {
            return new Intl.NumberFormat('tr-TR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(amount);
        }

        // Tarih formatı için yardımcı fonksiyon
        function formatDate(date) {
            return new Date(date).toLocaleDateString('tr-TR');
        }
    });
</script>

<?= $this->endSection() ?>