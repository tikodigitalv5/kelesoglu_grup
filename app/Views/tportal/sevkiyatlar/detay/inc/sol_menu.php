

<div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
    <div class="card-inner-group" data-simplebar>
        <div class="card-inner">
            <div class="user-card">
                <div class="user-avatar sq bg-primary"><span>YY</span></div>
                <div class="user-info">
                    <span class="lead-text">FMS2023000014</span>
                    <span class="sub-text">YATAŞ YATAK VE YORGAN SAN. TİC. A.Ş.</span>
                </div>
                
            </div><!-- .user-card -->
        </div><!-- .card-inner -->
        <div class="card-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="user-account-info py-0">
                        <h6 class="overline-title-alt">Sipariş Tutarı</h6>
                        <div class="user-balance"><strong>44.212,80 <small class="currency currency-btc">₺</small></strong></div>
                        <span class="badge badge-sm badge-dim bg-primary">Yeni Sipariş</span>
                    </div>
                </div>
                <div class="col-md-6 d-none">
                    <div class="user-account-info py-0">
                    <h6 class="overline-title-alt">Ön Ödeme <small><strong>(%25)</strong></small></h6>
                        <div class="user-balance text-secondary">0,00 <small class="currency currency-btc">₺</small></div>
                        <span class="badge badge-dot badge-dot-xs bg-success"></span>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-md-6">
                    <div class="user-account-info py-0">
                        <h6 class="overline-title-alt">Tahsilat Toplamı</h6>
                        <div class="user-balance"><strong>1.000,00 <small class="currency currency-btc">€</small></strong></div>
                        <span class="badge badge-dot badge-dot-xs bg-success"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="user-account-info py-0">
                    <h6 class="overline-title-alt">Ön Ödeme Kalan <small></small></h6>
                        <div class="user-balance text-info">931,47 <small class="currency currency-btc">€</small></div>
                        <span class="badge badge-dot badge-dot-xs bg-success"></span>
                    </div>
                </div>
            </div> -->
           
        </div>
        <div class="card-inner p-0">
            <ul class="link-list-menu">
                <li><a class="" href="<?= route_to('tportal.siparisler.detay') ?>"><em class="icon ni ni-layers"></em><span>Sipariş Kalemleri</span></a></li>
                <li><a class="" href="<?= route_to('tportal.siparisler.hareketler') ?>"><em class="icon ni ni-list-thumb"></em><span>Sipariş Hareketleri</span></a></li>
                <li><a   data-bs-toggle="modal" data-bs-target="#mdl_siparisdurumguncelle"><em class="icon ni ni-edit"></em><span>Sipariş Durum Güncelle</span></a></li>
                <li><a  data-bs-toggle="modal" data-bs-target="#mdl_siparissil" class=" text-danger"><em class="icon ni ni-trash text-danger"></em><span>Sipariş Sil</span></a></li>
               
            </ul>
        </div><!-- .card-inner -->
    </div><!-- .card-inner-group -->
</div>

<!-- Modal Alert 2 -->
<div class="modal fade" tabindex="-1" id="mdl_siparisdurumguncelle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sipariş Durum Güncelle</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter">
                    <div class="form-group">    
                    
                        <div class="form-control-wrap">        
                            <select class="form-control form-control-lg" id="default-06">
                                <option value="2">Yeni Sipariş</option>
                                <option value="2">Kontrol Ediliyor</option>
                                <option value="2">Hazırlanıyor</option>
                                <option value="2">Sevk Edildi</option>
                                <option value="2">Teslim Edildi</option>
                            </select>
                           
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-lg btn-primary">Kaydet</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Alert 2 -->
<div class="modal fade" tabindex="-1" id="mdl_siparissil">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent" style="font-size: 70px;"></em>
                    <h4 class="nk-modal-title">Siparişi Silmek İstediğinize<br>Emin misiniz?</h4>
                    <div class="nk-modal-action mb-5">
                        <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger" data-bs-dismiss="modal">Evet</a>
                    </div>
                    <div class="nk-modal-text">
                        <p class="lead">Bu siparişi silmeniz için;<br>mevcut herhangi bir hareket olmamalıdır.</p>
                        <p class="text-soft">Silmeden önce lütfen yetkilinize danışınız.</p>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>