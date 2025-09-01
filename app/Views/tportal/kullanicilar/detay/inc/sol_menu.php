

<div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
    <div class="card-inner-group" data-simplebar>
        <div class="card-inner">
            <div class="user-card">
                <div class="user-avatar bg-success-dim sq">
                    <span>F</span>
                </div>
                <div class="user-info">
                    <span class="lead-text">FAMS OTOMOTİV</span>
                    <span class="sub-text">Ayna Kapağı 2 Prç. P.Çelik</span>
                </div>
                
            </div><!-- .user-card -->
        </div><!-- .card-inner -->
        <div class="card-inner">
            <div class="user-account-info py-0">
                <h6 class="overline-title-alt">CARİ DURUMU</h6>
                <div class="user-balance text-success" >19.000,00 <small class="currency currency-btc">₺</small></div>
                <div class="user-balance-sub  text-success">Borçlu  </div>
            </div>
        </div><!-- .card-inner -->
        <div class="card-inner p-0">
            <ul class="link-list-menu">
                <li><a class="active" href="<?= route_to('tportal.cariler.detay') ?>"><em class="icon ni ni-user-alt"></em><span>Cari Bilgileri</span></a></li>
                <li><a class="" href="<?= route_to('tportal.cariler.hareketler') ?>"><em class="icon ni ni-list-thumb"></em><span>Cari Hareketleri</span></a></li>
                <li><a class="" href="#"><em class="icon ni ni-file-plus"></em><span>Fatura Oluştur</span></a></li>
                <li><a class="" href="<?= route_to('tportal.cariler.tahsilat_odeme') ?>"><em class="icon ni ni-money"></em><span>Tahsilat / Ödeme Oluştur</span></a></li>
                <li><a class="" href="<?= route_to('tportal.cariler.yetkililer') ?>"><em class="icon ni ni-users"></em><span>Yetkili Bilgileri</span></a></li>
                <li><a class="" href="<?= route_to('tportal.cariler.adresler') ?>"><em class="icon ni ni-truck"></em><span>Cari Adresleri</span></a></li>
                <!-- <li><a class="" href="#"><em class="icon ni ni-account-setting-alt"></em><span>Cari Ayarları</span></a></li> -->
                <li><a class="" href="<?= route_to('tportal.cariler.duzenle') ?>"><em class="icon ni ni-edit"></em><span>Cari Düzenle</span></a></li>
                <li><a  data-bs-toggle="modal" data-bs-target="#mdl_carisil" class=" text-danger"><em class="icon ni ni-trash text-danger"></em><span>Cari Sil</span></a></li>
               
            </ul>
        </div><!-- .card-inner -->
    </div><!-- .card-inner-group -->
</div>

    <!-- Modal Alert 2 -->
    <div class="modal fade" tabindex="-1" id="mdl_carisil">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent" style="font-size: 70px;"></em>
                        <h4 class="nk-modal-title">Cari Silmek İstediğinize<br>Emin misiniz?</h4>
                        <div class="nk-modal-action mb-5">
                            <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                            <a href="#" class="btn btn-lg btn-mw btn-danger" data-bs-dismiss="modal">Evet</a>
                        </div>
                        <div class="nk-modal-text">
                            <p class="lead">Bu carinizi silmeniz için;<br>mevcut herhangi bir cari hareketi olmamalıdır.</p>
                            <p class="text-soft">Silmeden önce lütfen yetkilinize danışınız.</p>
                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div>
        </div>
    </div>


<!-- Modal Alert 2 -->
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
                <table class="datatable-parabirimi table">
                    <thead>
                        <tr>
                            <th>Seç</th>
                            <th>Kodu</th>
                            <th>Adı</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioAFN"><label class="custom-control-label" for="customRadioAFN">AFN</label></div>
                            </td>
                          <td>AFN</td>
                          <td>Afghani</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioDZD"><label class="custom-control-label" for="customRadioDZD">DZD</label></div>
                            </td>
                          <td>DZD</td>
                          <td>Algerian Dinar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioARS"><label class="custom-control-label" for="customRadioARS">ARS</label></div>
                            </td>
                          <td>ARS</td>
                          <td>Argentine Peso</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioAWG"><label class="custom-control-label" for="customRadioAWG">AWG</label></div>
                            </td>
                          <td>AWG</td>
                          <td>Aruban Guilder</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioAUD"><label class="custom-control-label" for="customRadioAUD">AUD</label></div>
                            </td>
                          <td>AUD</td>
                          <td>Australian Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioAZM"><label class="custom-control-label" for="customRadioAZM">AZM</label></div>
                            </td>
                          <td>AZM</td>
                          <td>Azerbaijanian Manat</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBSD"><label class="custom-control-label" for="customRadioBSD">BSD</label></div>
                            </td>
                          <td>BSD</td>
                          <td>Bahamian Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBHD"><label class="custom-control-label" for="customRadioBHD">BHD</label></div>
                            </td>
                          <td>BHD</td>
                          <td>Bahraini Dinar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioTHB"><label class="custom-control-label" for="customRadioTHB">THB</label></div>
                            </td>
                          <td>THB</td>
                          <td>Baht</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioPAB"><label class="custom-control-label" for="customRadioPAB">PAB</label></div>
                            </td>
                          <td>PAB</td>
                          <td>Balboa</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBBD"><label class="custom-control-label" for="customRadioBBD">BBD</label></div>
                            </td>
                          <td>BBD</td>
                          <td>Barbados Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBYR"><label class="custom-control-label" for="customRadioBYR">BYR</label></div>
                            </td>
                          <td>BYR</td>
                          <td>Belarussian Ruble</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBZD"><label class="custom-control-label" for="customRadioBZD">BZD</label></div>
                            </td>
                          <td>BZD</td>
                          <td>Belize Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBMD"><label class="custom-control-label" for="customRadioBMD">BMD</label></div>
                            </td>
                          <td>BMD</td>
                          <td>Bermudian Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioVEB"><label class="custom-control-label" for="customRadioVEB">VEB</label></div>
                            </td>
                          <td>VEB</td>
                          <td>Bolivar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBOB"><label class="custom-control-label" for="customRadioBOB">BOB</label></div>
                            </td>
                          <td>BOB</td>
                          <td>Boliviano</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBGN"><label class="custom-control-label" for="customRadioBGN">BGN</label></div>
                            </td>
                          <td>BGN</td>
                          <td>Bulgarian Lev</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBRL"><label class="custom-control-label" for="customRadioBRL">BRL</label></div>
                            </td>
                          <td>BRL</td>
                          <td>Brazilian Real</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBND"><label class="custom-control-label" for="customRadioBND">BND</label></div>
                            </td>
                          <td>BND</td>
                          <td>Brunei Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBIF"><label class="custom-control-label" for="customRadioBIF">BIF</label></div>
                            </td>
                          <td>BIF</td>
                          <td>Burundi Franc</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioCAD"><label class="custom-control-label" for="customRadioCAD">CAD</label></div>
                            </td>
                          <td>CAD</td>
                          <td>Canadian Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioCVE"><label class="custom-control-label" for="customRadioCVE">CVE</label></div>
                            </td>
                          <td>CVE</td>
                          <td>Cape Verde Escudo</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioKYD"><label class="custom-control-label" for="customRadioKYD">KYD</label></div>
                            </td>
                          <td>KYD</td>
                          <td>Cayman Islands Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioGHC"><label class="custom-control-label" for="customRadioGHC">GHC</label></div>
                            </td>
                          <td>GHC</td>
                          <td>Cedi</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioXAF"><label class="custom-control-label" for="customRadioXAF">XAF</label></div>
                            </td>
                          <td>XAF</td>
                          <td>CFA Franc</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioXOF"><label class="custom-control-label" for="customRadioXOF">XOF</label></div>
                            </td>
                          <td>XOF</td>
                          <td>CFA Franc</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioXPF"><label class="custom-control-label" for="customRadioXPF">XPF</label></div>
                            </td>
                          <td>XPF</td>
                          <td>CFP Franc</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioCLP"><label class="custom-control-label" for="customRadioCLP">CLP</label></div>
                            </td>
                          <td>CLP</td>
                          <td>Chilean Peso</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioCOP"><label class="custom-control-label" for="customRadioCOP">COP</label></div>
                            </td>
                          <td>COP</td>
                          <td>Colombian Peso</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioKMF"><label class="custom-control-label" for="customRadioKMF">KMF</label></div>
                            </td>
                          <td>KMF</td>
                          <td>Comoro Franc</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioNIO"><label class="custom-control-label" for="customRadioNIO">NIO</label></div>
                            </td>
                          <td>NIO</td>
                          <td>Cordoba Oro</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioCRC"><label class="custom-control-label" for="customRadioCRC">CRC</label></div>
                            </td>
                          <td>CRC</td>
                          <td>Costa Rican Colon</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioCUP"><label class="custom-control-label" for="customRadioCUP">CUP</label></div>
                            </td>
                          <td>CUP</td>
                          <td>Cuban Peso</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioCYP"><label class="custom-control-label" for="customRadioCYP">CYP</label></div>
                            </td>
                          <td>CYP</td>
                          <td>Cyprus Pound</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioCZK"><label class="custom-control-label" for="customRadioCZK">CZK</label></div>
                            </td>
                          <td>CZK</td>
                          <td>Czech Koruna</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioDKK"><label class="custom-control-label" for="customRadioDKK">DKK</label></div>
                            </td>
                          <td>DKK</td>
                          <td>Danish Krone</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioGMD"><label class="custom-control-label" for="customRadioGMD">GMD</label></div>
                            </td>
                          <td>GMD</td>
                          <td>Dalasi</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMKD"><label class="custom-control-label" for="customRadioMKD">MKD</label></div>
                            </td>
                          <td>MKD</td>
                          <td>Denar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioAED"><label class="custom-control-label" for="customRadioAED">AED</label></div>
                            </td>
                          <td>AED</td>
                          <td>Dirham</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioDJF"><label class="custom-control-label" for="customRadioDJF">DJF</label></div>
                            </td>
                          <td>DJF</td>
                          <td>Djibouti Franc</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSTD"><label class="custom-control-label" for="customRadioSTD">STD</label></div>
                            </td>
                          <td>STD</td>
                          <td>Dobra</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioDOP"><label class="custom-control-label" for="customRadioDOP">DOP</label></div>
                            </td>
                          <td>DOP</td>
                          <td>Dominican Peso</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioVND"><label class="custom-control-label" for="customRadioVND">VND</label></div>
                            </td>
                          <td>VND</td>
                          <td>Dong</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioAMD"><label class="custom-control-label" for="customRadioAMD">AMD</label></div>
                            </td>
                          <td>AMD</td>
                          <td>Dram</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioXCD"><label class="custom-control-label" for="customRadioXCD">XCD</label></div>
                            </td>
                          <td>XCD</td>
                          <td>East Carribean Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioEGP"><label class="custom-control-label" for="customRadioEGP">EGP</label></div>
                            </td>
                          <td>EGP</td>
                          <td>Egyptian Pound</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSVC"><label class="custom-control-label" for="customRadioSVC">SVC</label></div>
                            </td>
                          <td>SVC</td>
                          <td>El Salvador Colon</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioETB"><label class="custom-control-label" for="customRadioETB">ETB</label></div>
                            </td>
                          <td>ETB</td>
                          <td>Ethopian Birr</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioEUR"><label class="custom-control-label" for="customRadioEUR">EUR</label></div>
                            </td>
                          <td>EUR</td>
                          <td>Euro</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioFKP"><label class="custom-control-label" for="customRadioFKP">FKP</label></div>
                            </td>
                          <td>FKP</td>
                          <td>Falkland Islands Pound</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioFJD"><label class="custom-control-label" for="customRadioFJD">FJD</label></div>
                            </td>
                          <td>FJD</td>
                          <td>Fiji Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioHUF"><label class="custom-control-label" for="customRadioHUF">HUF</label></div>
                            </td>
                          <td>HUF</td>
                          <td>Forint</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioCDF"><label class="custom-control-label" for="customRadioCDF">CDF</label></div>
                            </td>
                          <td>CDF</td>
                          <td>Franc Congolais</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioGIP"><label class="custom-control-label" for="customRadioGIP">GIP</label></div>
                            </td>
                          <td>GIP</td>
                          <td>Gibraltar Pound</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioXAU"><label class="custom-control-label" for="customRadioXAU">XAU</label></div>
                            </td>
                          <td>XAU</td>
                          <td>Gold</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioHTG"><label class="custom-control-label" for="customRadioHTG">HTG</label></div>
                            </td>
                          <td>HTG</td>
                          <td>Gourde</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioPYG"><label class="custom-control-label" for="customRadioPYG">PYG</label></div>
                            </td>
                          <td>PYG</td>
                          <td>Guarani</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioGNF"><label class="custom-control-label" for="customRadioGNF">GNF</label></div>
                            </td>
                          <td>GNF</td>
                          <td>Guinea Franc</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioGYD"><label class="custom-control-label" for="customRadioGYD">GYD</label></div>
                            </td>
                          <td>GYD</td>
                          <td>Guyana Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioHKD"><label class="custom-control-label" for="customRadioHKD">HKD</label></div>
                            </td>
                          <td>HKD</td>
                          <td>HKD</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioUAH"><label class="custom-control-label" for="customRadioUAH">UAH</label></div>
                            </td>
                          <td>UAH</td>
                          <td>Hryvnia</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioISK"><label class="custom-control-label" for="customRadioISK">ISK</label></div>
                            </td>
                          <td>ISK</td>
                          <td>Iceland Krona</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioINR"><label class="custom-control-label" for="customRadioINR">INR</label></div>
                            </td>
                          <td>INR</td>
                          <td>Indian Rupee</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioIQD"><label class="custom-control-label" for="customRadioIQD">IQD</label></div>
                            </td>
                          <td>IQD</td>
                          <td>Iraqi Dinar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioIRR"><label class="custom-control-label" for="customRadioIRR">IRR</label></div>
                            </td>
                          <td>IRR</td>
                          <td>Iranian Rial</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioJMD"><label class="custom-control-label" for="customRadioJMD">JMD</label></div>
                            </td>
                          <td>JMD</td>
                          <td>Jamaican Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioJOD"><label class="custom-control-label" for="customRadioJOD">JOD</label></div>
                            </td>
                          <td>JOD</td>
                          <td>Jordanian Dinar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioKES"><label class="custom-control-label" for="customRadioKES">KES</label></div>
                            </td>
                          <td>KES</td>
                          <td>Kenyan Shilling</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioPGK"><label class="custom-control-label" for="customRadioPGK">PGK</label></div>
                            </td>
                          <td>PGK</td>
                          <td>Kina</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioLAK"><label class="custom-control-label" for="customRadioLAK">LAK</label></div>
                            </td>
                          <td>LAK</td>
                          <td>Kip</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioEEK"><label class="custom-control-label" for="customRadioEEK">EEK</label></div>
                            </td>
                          <td>EEK</td>
                          <td>Kroon</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioHRK"><label class="custom-control-label" for="customRadioHRK">HRK</label></div>
                            </td>
                          <td>HRK</td>
                          <td>Kuna</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioKWD"><label class="custom-control-label" for="customRadioKWD">KWD</label></div>
                            </td>
                          <td>KWD</td>
                          <td>Kuwaiti Dinar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMWK"><label class="custom-control-label" for="customRadioMWK">MWK</label></div>
                            </td>
                          <td>MWK</td>
                          <td>Kwacha</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioZMK"><label class="custom-control-label" for="customRadioZMK">ZMK</label></div>
                            </td>
                          <td>ZMK</td>
                          <td>Kwacha</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioAOA"><label class="custom-control-label" for="customRadioAOA">AOA</label></div>
                            </td>
                          <td>AOA</td>
                          <td>Kwanza</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMMK"><label class="custom-control-label" for="customRadioMMK">MMK</label></div>
                            </td>
                          <td>MMK</td>
                          <td>Kyat</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioGEL"><label class="custom-control-label" for="customRadioGEL">GEL</label></div>
                            </td>
                          <td>GEL</td>
                          <td>Lari</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioLVL"><label class="custom-control-label" for="customRadioLVL">LVL</label></div>
                            </td>
                          <td>LVL</td>
                          <td>Latvian Lats</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioLBP"><label class="custom-control-label" for="customRadioLBP">LBP</label></div>
                            </td>
                          <td>LBP</td>
                          <td>Lebanese Pound</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioALL"><label class="custom-control-label" for="customRadioALL">ALL</label></div>
                            </td>
                          <td>ALL</td>
                          <td>Lek</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioHNL"><label class="custom-control-label" for="customRadioHNL">HNL</label></div>
                            </td>
                          <td>HNL</td>
                          <td>Lempira</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSLL"><label class="custom-control-label" for="customRadioSLL">SLL</label></div>
                            </td>
                          <td>SLL</td>
                          <td>Leone</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioROL"><label class="custom-control-label" for="customRadioROL">ROL</label></div>
                            </td>
                          <td>ROL</td>
                          <td>Leu</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioLRD"><label class="custom-control-label" for="customRadioLRD">LRD</label></div>
                            </td>
                          <td>LRD</td>
                          <td>Liberian Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioLYD"><label class="custom-control-label" for="customRadioLYD">LYD</label></div>
                            </td>
                          <td>LYD</td>
                          <td>Libyan Dinar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSZL"><label class="custom-control-label" for="customRadioSZL">SZL</label></div>
                            </td>
                          <td>SZL</td>
                          <td>Lilangeni</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioLTL"><label class="custom-control-label" for="customRadioLTL">LTL</label></div>
                            </td>
                          <td>LTL</td>
                          <td>Lithuanian Litas</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioLSL"><label class="custom-control-label" for="customRadioLSL">LSL</label></div>
                            </td>
                          <td>LSL</td>
                          <td>Loti</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMGF"><label class="custom-control-label" for="customRadioMGF">MGF</label></div>
                            </td>
                          <td>MGF</td>
                          <td>Malagasy Franc</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMYR"><label class="custom-control-label" for="customRadioMYR">MYR</label></div>
                            </td>
                          <td>MYR</td>
                          <td>Malaysian Ringgit</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMTL"><label class="custom-control-label" for="customRadioMTL">MTL</label></div>
                            </td>
                          <td>MTL</td>
                          <td>Maltese Lira</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioTMM"><label class="custom-control-label" for="customRadioTMM">TMM</label></div>
                            </td>
                          <td>TMM</td>
                          <td>Manat</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMUR"><label class="custom-control-label" for="customRadioMUR">MUR</label></div>
                            </td>
                          <td>MUR</td>
                          <td>Mauritius Rupee</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMZM"><label class="custom-control-label" for="customRadioMZM">MZM</label></div>
                            </td>
                          <td>MZM</td>
                          <td>Metical</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMXN"><label class="custom-control-label" for="customRadioMXN">MXN</label></div>
                            </td>
                          <td>MXN</td>
                          <td>Mexican Peso</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMDL"><label class="custom-control-label" for="customRadioMDL">MDL</label></div>
                            </td>
                          <td>MDL</td>
                          <td>Moldovan Leu</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMAD"><label class="custom-control-label" for="customRadioMAD">MAD</label></div>
                            </td>
                          <td>MAD</td>
                          <td>Morrocan Dirham</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioNGN"><label class="custom-control-label" for="customRadioNGN">NGN</label></div>
                            </td>
                          <td>NGN</td>
                          <td>Naira</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioERN"><label class="custom-control-label" for="customRadioERN">ERN</label></div>
                            </td>
                          <td>ERN</td>
                          <td>Nakfa</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioNAD"><label class="custom-control-label" for="customRadioNAD">NAD</label></div>
                            </td>
                          <td>NAD</td>
                          <td>Namibia Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioNPR"><label class="custom-control-label" for="customRadioNPR">NPR</label></div>
                            </td>
                          <td>NPR</td>
                          <td>Nepalese Rupee</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioANG"><label class="custom-control-label" for="customRadioANG">ANG</label></div>
                            </td>
                          <td>ANG</td>
                          <td>Netherlands Antillian Guilder</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioYUM"><label class="custom-control-label" for="customRadioYUM">YUM</label></div>
                            </td>
                          <td>YUM</td>
                          <td>New Dinar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioILS"><label class="custom-control-label" for="customRadioILS">ILS</label></div>
                            </td>
                          <td>ILS</td>
                          <td>New Israeli Sheqel</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioTWD"><label class="custom-control-label" for="customRadioTWD">TWD</label></div>
                            </td>
                          <td>TWD</td>
                          <td>New Taiwan Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioNZD"><label class="custom-control-label" for="customRadioNZD">NZD</label></div>
                            </td>
                          <td>NZD</td>
                          <td>New Zealand Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioKPW"><label class="custom-control-label" for="customRadioKPW">KPW</label></div>
                            </td>
                          <td>KPW</td>
                          <td>North Korean Won</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioNOK"><label class="custom-control-label" for="customRadioNOK">NOK</label></div>
                            </td>
                          <td>NOK</td>
                          <td>Norwegian Krone</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBTN"><label class="custom-control-label" for="customRadioBTN">BTN</label></div>
                            </td>
                          <td>BTN</td>
                          <td>Ngultrum</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioPEN"><label class="custom-control-label" for="customRadioPEN">PEN</label></div>
                            </td>
                          <td>PEN</td>
                          <td>Nuevo Sol</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMRO"><label class="custom-control-label" for="customRadioMRO">MRO</label></div>
                            </td>
                          <td>MRO</td>
                          <td>Ouguiya</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioTOP"><label class="custom-control-label" for="customRadioTOP">TOP</label></div>
                            </td>
                          <td>TOP</td>
                          <td>Pa&amp;amp;apos;anga</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioPKR"><label class="custom-control-label" for="customRadioPKR">PKR</label></div>
                            </td>
                          <td>PKR</td>
                          <td>Pakistan Rupee</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioXPD"><label class="custom-control-label" for="customRadioXPD">XPD</label></div>
                            </td>
                          <td>XPD</td>
                          <td>Palladium</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMOP"><label class="custom-control-label" for="customRadioMOP">MOP</label></div>
                            </td>
                          <td>MOP</td>
                          <td>Pataca</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioUYU"><label class="custom-control-label" for="customRadioUYU">UYU</label></div>
                            </td>
                          <td>UYU</td>
                          <td>Peso Uruguayo</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioPHP"><label class="custom-control-label" for="customRadioPHP">PHP</label></div>
                            </td>
                          <td>PHP</td>
                          <td>Philippine Peso</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioXPT"><label class="custom-control-label" for="customRadioXPT">XPT</label></div>
                            </td>
                          <td>XPT</td>
                          <td>Platinum</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioGBP"><label class="custom-control-label" for="customRadioGBP">GBP</label></div>
                            </td>
                          <td>GBP</td>
                          <td>Pound Sterling</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBWP"><label class="custom-control-label" for="customRadioBWP">BWP</label></div>
                            </td>
                          <td>BWP</td>
                          <td>Pula</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioQAR"><label class="custom-control-label" for="customRadioQAR">QAR</label></div>
                            </td>
                          <td>QAR</td>
                          <td>Qatari Rial</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioGTQ"><label class="custom-control-label" for="customRadioGTQ">GTQ</label></div>
                            </td>
                          <td>GTQ</td>
                          <td>Quetzal</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioZAR"><label class="custom-control-label" for="customRadioZAR">ZAR</label></div>
                            </td>
                          <td>ZAR</td>
                          <td>Rand</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioOMR"><label class="custom-control-label" for="customRadioOMR">OMR</label></div>
                            </td>
                          <td>OMR</td>
                          <td>Rial Omani</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioKHR"><label class="custom-control-label" for="customRadioKHR">KHR</label></div>
                            </td>
                          <td>KHR</td>
                          <td>Riel</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMVR"><label class="custom-control-label" for="customRadioMVR">MVR</label></div>
                            </td>
                          <td>MVR</td>
                          <td>Rufiyaa</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioRON"><label class="custom-control-label" for="customRadioRON">RON</label></div>
                            </td>
                          <td>RON</td>
                          <td>Rumen Leyi</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioIDR"><label class="custom-control-label" for="customRadioIDR">IDR</label></div>
                            </td>
                          <td>IDR</td>
                          <td>Rupiah</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioRUB"><label class="custom-control-label" for="customRadioRUB">RUB</label></div>
                            </td>
                          <td>RUB</td>
                          <td>Russian Ruble</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioRWF"><label class="custom-control-label" for="customRadioRWF">RWF</label></div>
                            </td>
                          <td>RWF</td>
                          <td>Rwanda Franc</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSAR"><label class="custom-control-label" for="customRadioSAR">SAR</label></div>
                            </td>
                          <td>SAR</td>
                          <td>Saudi Riyal</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioXDR"><label class="custom-control-label" for="customRadioXDR">XDR</label></div>
                            </td>
                          <td>XDR</td>
                          <td>SDR</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSCR"><label class="custom-control-label" for="customRadioSCR">SCR</label></div>
                            </td>
                          <td>SCR</td>
                          <td>Seychelles Rupee</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioXAG"><label class="custom-control-label" for="customRadioXAG">XAG</label></div>
                            </td>
                          <td>XAG</td>
                          <td>Silver</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSGD"><label class="custom-control-label" for="customRadioSGD">SGD</label></div>
                            </td>
                          <td>SGD</td>
                          <td>Singapore Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSKK"><label class="custom-control-label" for="customRadioSKK">SKK</label></div>
                            </td>
                          <td>SKK</td>
                          <td>Slovak Koruna</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSBD"><label class="custom-control-label" for="customRadioSBD">SBD</label></div>
                            </td>
                          <td>SBD</td>
                          <td>Solomon Islands Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSOS"><label class="custom-control-label" for="customRadioSOS">SOS</label></div>
                            </td>
                          <td>SOS</td>
                          <td>Somali Shilling</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioLKR"><label class="custom-control-label" for="customRadioLKR">LKR</label></div>
                            </td>
                          <td>LKR</td>
                          <td>Sri Lanka Rupee</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioKGS"><label class="custom-control-label" for="customRadioKGS">KGS</label></div>
                            </td>
                          <td>KGS</td>
                          <td>Som</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioTJS"><label class="custom-control-label" for="customRadioTJS">TJS</label></div>
                            </td>
                          <td>TJS</td>
                          <td>Somoni</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSHP"><label class="custom-control-label" for="customRadioSHP">SHP</label></div>
                            </td>
                          <td>SHP</td>
                          <td>St. Helena Pound</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSDD"><label class="custom-control-label" for="customRadioSDD">SDD</label></div>
                            </td>
                          <td>SDD</td>
                          <td>Sudanese Dinar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSRG"><label class="custom-control-label" for="customRadioSRG">SRG</label></div>
                            </td>
                          <td>SRG</td>
                          <td>Suriname Guilder</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSEK"><label class="custom-control-label" for="customRadioSEK">SEK</label></div>
                            </td>
                          <td>SEK</td>
                          <td>Swedish Krona</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioCHF"><label class="custom-control-label" for="customRadioCHF">CHF</label></div>
                            </td>
                          <td>CHF</td>
                          <td>Swiss Franc</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSYP"><label class="custom-control-label" for="customRadioSYP">SYP</label></div>
                            </td>
                          <td>SYP</td>
                          <td>Syrian Pound</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioBDT"><label class="custom-control-label" for="customRadioBDT">BDT</label></div>
                            </td>
                          <td>BDT</td>
                          <td>Taka</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioWST"><label class="custom-control-label" for="customRadioWST">WST</label></div>
                            </td>
                          <td>WST</td>
                          <td>Tala</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioTZS"><label class="custom-control-label" for="customRadioTZS">TZS</label></div>
                            </td>
                          <td>TZS</td>
                          <td>Tanzanian Shilling</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioKZT"><label class="custom-control-label" for="customRadioKZT">KZT</label></div>
                            </td>
                          <td>KZT</td>
                          <td>Tenge</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioSIT"><label class="custom-control-label" for="customRadioSIT">SIT</label></div>
                            </td>
                          <td>SIT</td>
                          <td>Tolar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioTTD"><label class="custom-control-label" for="customRadioTTD">TTD</label></div>
                            </td>
                          <td>TTD</td>
                          <td>Trinidad and Tobago Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioMNT"><label class="custom-control-label" for="customRadioMNT">MNT</label></div>
                            </td>
                          <td>MNT</td>
                          <td>Tugrik</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioTND"><label class="custom-control-label" for="customRadioTND">TND</label></div>
                            </td>
                          <td>TND</td>
                          <td>Tunisian Dinar</td>
                          </tr>
                          <tr>
                            <td data-order="1">
                              <div class="custom-control custom-radio"><input type="radio" checked class="custom-control-input" name="radioSize" id="customRadioTRY"><label class="custom-control-label" for="customRadioTRY">TRY</label></div>
                            </td>
                          <td>TRY</td>
                          <td>Türk Lirası</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioUGX"><label class="custom-control-label" for="customRadioUGX">UGX</label></div>
                            </td>
                          <td>UGX</td>
                          <td>Uganda Shilling</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioUSD"><label class="custom-control-label" for="customRadioUSD">USD</label></div>
                            </td>
                          <td>USD</td>
                          <td>US Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioUZS"><label class="custom-control-label" for="customRadioUZS">UZS</label></div>
                            </td>
                          <td>UZS</td>
                          <td>Uzbekistan Sum</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioVUV"><label class="custom-control-label" for="customRadioVUV">VUV</label></div>
                            </td>
                          <td>VUV</td>
                          <td>Vatu</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioKRW"><label class="custom-control-label" for="customRadioKRW">KRW</label></div>
                            </td>
                          <td>KRW</td>
                          <td>Won</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioYER"><label class="custom-control-label" for="customRadioYER">YER</label></div>
                            </td>
                          <td>YER</td>
                          <td>Yemeni Rial</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioJPY"><label class="custom-control-label" for="customRadioJPY">JPY</label></div>
                            </td>
                          <td>JPY</td>
                          <td>Yen</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioCNY"><label class="custom-control-label" for="customRadioCNY">CNY</label></div>
                            </td>
                          <td>CNY</td>
                          <td>Yuan Renminbi</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioZWD"><label class="custom-control-label" for="customRadioZWD">ZWD</label></div>
                            </td>
                          <td>ZWD</td>
                          <td>Zimbabwe Dollar</td>
                          </tr>
                          <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadioPLN"><label class="custom-control-label" for="customRadioPLN">PLN</label></div>
                            </td>
                          <td>PLN</td>
                          <td>Zloty</td>
                          </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_parabirimisec_mdl" class="btn btn-lg btn-primary">SEÇ</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Alert 2 -->
<div class="modal fade" tabindex="-1" id="mdl_hesaplar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hesap Seçiniz</h5>
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
                        <tr>
                            <td data-order="0">
                              <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadio1"><label class="custom-control-label" for="customRadio1">Enpara Şirketim</label></div>
                            </td>
                            <td>QNB Finansbank</td>
                            <td>Banka (TRY)</td>
                          
                          </tr>
                          <tr>
                              <td data-order="0">
                                <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadio2"><label class="custom-control-label" for="customRadio2">Enpara Şahsi</label></div>
                              </td>
                              <td>QNB Finansbank</td>
                              <td>Banka (TRY)</td>
                            
                            </tr>
                            <tr>
                                <td data-order="0">
                                  <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadio3"><label class="custom-control-label" for="customRadio3">Kuveyt Şirket</label></div>
                                </td>
                                <td>Kuveyt Türk</td>
                                <td>Banka (TRY)</td>
                            </tr>
                            <tr>
                                <td data-order="0">
                                  <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadio4"><label class="custom-control-label" for="customRadio4">Kuveyt POS</label></div>
                                </td>
                                <td>Kuveyt Türk POS</td>
                                <td>POS (TRY)</td>
                            </tr>
                            <tr>
                                <td data-order="0">
                                  <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadio5"><label class="custom-control-label" for="customRadio5">PAYTR POS</label></div>
                                </td>
                                <td>PAYTR POS</td>
                                <td>POS (TRY)</td>
                            </tr>
                            <tr>
                                <td data-order="0">
                                  <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadio6"><label class="custom-control-label" for="customRadio6">Nakit TL</label></div>
                                </td>
                                <td>Kasa TL</td>
                                <td>Kasa (TRY)</td>
                            </tr>
                            <tr>
                                <td data-order="0">
                                  <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadio7"><label class="custom-control-label" for="customRadio7">Nakit DOLAR</label></div>
                                </td>
                                <td>Kasa DOLAR</td>
                                <td>Kasa (USD)</td>
                            </tr>
                            <tr>
                                <td data-order="0">
                                  <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadio8"><label class="custom-control-label" for="customRadio8">Enpara Şirketim KK</label></div>
                                </td>
                                <td>QNB Finansbank</td>
                                <td>Kredi Kartı (TRY)</td>
                              
                              </tr>
                              <tr>
                                  <td data-order="0">
                                    <div class="custom-control custom-radio"><input type="radio" class="custom-control-input" name="radioSize" id="customRadio9"><label class="custom-control-label" for="customRadio9">Enpara Şahsi KK</label></div>
                                  </td>
                                  <td>QNB Finansbank</td>
                                  <td>Kredi Kartı (TRY)</td>
                                
                                </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-dim btn-outline-light">KAPAT</button>

                    </div>
                    <div class="col-md-8 text-end p-0">

                        <button type="button" id="btn_hesapyeniekle_mdl" class="btn btn-lg  btn-outline-light me-2">YENİ HESAP</button>
                        <button type="button" id="btn_hesapsec_mdl" class="btn btn-lg btn-primary ">SEÇ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>