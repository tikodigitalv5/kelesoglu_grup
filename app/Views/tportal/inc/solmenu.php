<style>
   
   
</style>
<div class="nk-sidebar is-theme" data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="<?= route_to('tportal.dashboard') ?>" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="<?= base_url('custom/tiko_portal_beyaz.png') ?>"
                    srcset="<?= base_url('custom/tiko_portal_beyaz.png') ?> 2x" alt="logo">
                <img class="logo-dark logo-img" src="<?= base_url('custom/tiko_portal_renkli.png') ?>"
                    srcset="<?= base_url('custom/tiko_portal_renkli.png') ?> 2x" alt="logo-dark">
                <img class="logo-small logo-img logo-img-small" src="<?= base_url('custom/tiko_portal_renkli.png') ?>"
                    srcset="<?= base_url('custom/tiko_portal_renkli.png') ?> 2x" alt="logo-small">
            </a>
        </div>
        <div class="nk-menu-trigger me-n2 pt-3">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em
                    class="icon ni ni-cross"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">

                    <li class="nk-menu-item" id="home_page">
                        <a href="<?= route_to('tportal.dashboard') ?>" class="nk-menu-link " data-bs-original-title=""
                            title="">
                            <span class="nk-menu-icon"><em class="icon ni ni-monitor"></em></span>
                            <span class="nk-menu-text">Anasayfa</span>
                        </a>
                    </li>
                    <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19){ ?> 

                        <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-server"></em></span>
                            <span class="nk-menu-text">APİ</span>
                        </a>
                        <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.api.dopigo.list') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Dopigo</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.api.sysmond') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Sysmond</span></a>
                            </li>

                        </ul>
                    </li>

                    <?php }  ?>
                    <?php
                    $user_modules = session()->get('user_modules');
                    if(array_search('Cariler', array_column($user_modules, 'module_title')) != null || strval(array_search('Cariler', array_column($user_modules, 'module_title'))) == '0'){ ?>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">Cariler</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.cariler.list', 'customer') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Müşteriler</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.cariler.list', 'supplier') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Tedarikçiler</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.cariler.list', 'all') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Tüm Cariler</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.cariler.create') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Yeni Cari</span></a>
                            </li>
                            <?php if(session()->get('user_id') == 5): ?>
                            <li class="nk-menu-item d-none">
                                <a href="<?= route_to('tportal.cariler.vknBirlesimModal') ?>" target="_blank" class="nk-menu-link"><span
                                        class="nk-menu-text">VKN Birleştirme</span></a>
                            </li>
                            <?php endif; ?>
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <?php
                    }
                    if(array_search('Stoklar', array_column($user_modules, 'module_title')) != null || strval(array_search('Stoklar', array_column($user_modules, 'module_title'))) == '0'){ ?>
                    <li class="nk-menu-item has-sub ">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-layers"></em></span>
                            <span class="nk-menu-text">Stoklar</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.stocks.list','products') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Ürünler</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.stocks.list','services') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Hizmetler</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.stocks.list','all') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Tüm Stoklar</span></a>
                            </li>
                            

                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.stocks.create') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Yeni Ürün/Hizmet</span></a>
                            </li>

                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle"><span
                                        class="nk-menu-text">Ayarlar</span></a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="<?= route_to('tportal.stocks.type') ?>" class="nk-menu-link"><span
                                                class="nk-menu-text">Tipler</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="<?= route_to('tportal.stocks.category') ?>" class="nk-menu-link"><span
                                                class="nk-menu-text">Kategoriler</span></a>
                                    </li>
                                    <?=  view_cell(
                                                'App\Libraries\ViewComponents::getComponent',
                                                [
                                                    'component_name' => 'stoklar.detay.altkategoriler',
                                                ]
                                    ) ?>
                                       
                                    <li class="nk-menu-item">
                                        <a href="<?= route_to('tportal.stocks.unit') ?>" class="nk-menu-link"><span
                                                class="nk-menu-text">Birimler</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="<?= route_to('tportal.stocks.operation') ?>" class="nk-menu-link"><span
                                                class="nk-menu-text">Operasyonlar</span></a>
                                    </li>
                                    <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19): ?>
                                    <li class="nk-menu-item">
                                        <a href="<?= route_to('tportal.stocks.operation_resource') ?>" class="nk-menu-link"><span
                                                class="nk-menu-text">O. Kaynakları</span></a>
                                    </li>
                                    <?php endif; ?>
                                    <li class="nk-menu-item">
                                        <a href="<?= route_to('tportal.stocks.warehouse') ?>" class="nk-menu-link"><span
                                                class="nk-menu-text">Depolar</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="<?= route_to('tportal.stocks.variant') ?>" class="nk-menu-link"><span
                                                class="nk-menu-text">Varyantlar</span></a>
                                    </li>
                                </ul>
                            </li>

                     

                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <?php
                    }
                    if(array_search('Teklifler', array_column($user_modules, 'module_title')) != null || strval(array_search('Teklifler', array_column($user_modules, 'module_title'))) == '0'){ ?>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-folder-list"></em></span>
                            <span class="nk-menu-text">Teklifler</span>
                        </a>
                        <ul class="nk-menu-sub">
                           
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.teklifler.list','open') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Açık Teklifler</span></a>
                            </li>
                   
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.teklifler.list','closed') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Kapalı Teklifler</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.teklifler.list','all') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Tüm Teklifler</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.teklifler.create') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Yeni Teklif</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <?php
                    }
                    if(array_search('Siparişler', array_column($user_modules, 'module_title')) != null || strval(array_search('Siparişler', array_column($user_modules, 'module_title'))) == '0'){ ?>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-clipboad-check"></em></span>
                            <span class="nk-menu-text">Siparişler</span>
                        </a>
                        <ul class="nk-menu-sub">
                        <?php if(session()->get('user_id') != 1 && session()->get('user_id') != 19): ?>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.siparisler.list','open') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Açık Siparişler</span></a>
                            </li>
                            <?php endif; ?>
                            <?php if(session()->get('user_id') != 1 && session()->get('user_id') != 19): ?>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.siparisler.list','closed') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Kapalı Siparişler</span></a>
                            </li>
                            <?php endif; ?>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.siparisler.list','all') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Tüm Siparişler</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.siparisler.create') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Yeni Sipariş</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <?php
                    }
                    if(array_search('Üretim', array_column($user_modules, 'module_title')) != null  || strval(array_search('Üretim', array_column($user_modules, 'module_title'))) == '0'){ ?>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-property"></em></span>
                            <span class="nk-menu-text">Üretim</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.uretim.openlist') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Açık Emirler</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.uretim.closelist') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Kapalı Emirler</span></a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.uretim.list', 'all') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Tüm Emirler</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.uretim.create') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Yeni Üretim Emri</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <?php
                    }
                    
                    if(array_search('Faturalar', array_column($user_modules, 'module_title')) != null || strval(array_search('Faturalar', array_column($user_modules, 'module_title'))) == '0'){ ?>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-file-text"></em></span>
                            <span class="nk-menu-text">Faturalar</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.faturalar.list', 'outgoing') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Satış Faturaları</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.faturalar.list', 'incoming') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Alış Faturaları</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.faturalar.list', 'all') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Tüm Faturalar</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.faturalar.create') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Yeni Fatura</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->

                       
                    </li><!-- .nk-menu-item -->
                        <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19): ?>
                            <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-list-index"></em></span>
                            <span class="nk-menu-text">İrsaliyeler</span>
                        </a>
                        <ul class="nk-menu-sub">
                           
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.irsaliyeler.list', 'all') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Tüm İrsaliyeler</span></a>
                            </li>
                           
                        </ul><!-- .nk-menu-sub -->

                       
                    </li><!-- .nk-menu-item -->
                        <?php endif; ?>

                    <?php
                    }
                    if(array_search('Sevkiyatlar', array_column($user_modules, 'module_title')) != null || strval(array_search('Sevkiyatlar', array_column($user_modules, 'module_title'))) == '0'){ ?>
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-truck"></em></span>
                                <span class="nk-menu-text">Sevkiyatlar</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="<?= route_to('tportal.shipment.list', 'open') ?>" class="nk-menu-link"><span
                                            class="nk-menu-text">Açık Sevkiyatlar</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="<?= route_to('tportal.shipment.list', 'closed') ?>" class="nk-menu-link"><span
                                            class="nk-menu-text">Kapalı Sevkiyatlar</span></a>
                                </li>
    
                                <li class="nk-menu-item">
                                    <a href="<?= route_to('tportal.cari.sale_order_list') ?>" class="nk-menu-link"><span
                                            class="nk-menu-text">Sipariş Sevkiyatları</span></a>
    
                                <li class="nk-menu-item">
                                    <a href="<?= route_to('tportal.shipment.list', 'all') ?>" class="nk-menu-link"><span
                                            class="nk-menu-text">Tüm Sevkiyatlar</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="<?= route_to('tportal.shipment.create') ?>" class="nk-menu-link"><span
                                            class="nk-menu-text">Yeni Sevkiyat Emri</span></a>
                                </li>
                            </ul><!-- .nk-menu-sub -->
                        </li><!-- .nk-menu-item -->
                        <?php
                        }

                    if(array_search('Giderler', array_column($user_modules, 'module_title')) != null || strval(array_search('Giderler', array_column($user_modules, 'module_title'))) == '0'){ ?>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-wallet-alt"></em></span>
                            <span class="nk-menu-text">Giderler</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.stocks.gider_gruplari') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Gider Grupları</span></a>
                            </li>
                            <li class="nk-menu-item">
                            <a href="<?= route_to('tportal.stocks.gider_kategorileri') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Gider Kategorileri</span></a>
                            </li>
                            <li class="nk-menu-item d-none">
                                <a href="<?= route_to('tportal.giderler.personeller') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Personeller</span></a>
                            </li>
                            <li class="nk-menu-item d-none">
                                <a href="<?= route_to('tportal.giderler.araclar') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Araçlar</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.gider.list', "all") ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Tüm Giderler</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.gider.create') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Yeni Gider</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <?php
                    }
                    if(array_search('Hesaplar', array_column($user_modules, 'module_title')) != null || strval(array_search('Hesaplar', array_column($user_modules, 'module_title'))) == '0'){ ?>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-money"></em></span>
                            <span class="nk-menu-text">Hesaplar</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.financial_accounts.list', 'vault') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Kasalar</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.financial_accounts.list', 'bank') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Banka Hesapları</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.financial_accounts.list', 'credit_card') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Kredi Kartları</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.cekler.index', 'check_bill') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Çek ve Senetler</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.financial_accounts.create') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Yeni Hesap</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.financial_accounts.list', 'all') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Tüm Hesaplar</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <?php
                    }
                    if(array_search('Raporlar', array_column($user_modules, 'module_title')) != null || strval(array_search('Raporlar', array_column($user_modules, 'module_title'))) == '0'){ ?>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-growth"></em></span>
                            <span class="nk-menu-text">Raporlar</span>
                        </a>
                        <ul class="nk-menu-sub">
                        <?php if(session()->get('user_id') == 5): ?>
                        <?= view_cell('App\Libraries\ViewComponents::getComponent', ['component_name' => 'tportal.raporlar.satis_raporlari']); ?>
                        <?= view_cell('App\Libraries\ViewComponents::getComponent', ['component_name' => 'tportal.raporlar.satis_raporlari_msh']); ?>
                        <?php endif; ?>
                      
                        <?php if(session()->get('user_id') == 1 || session()->get('user_id') == 19): ?>
                            <li class="nk-menu-item">
                                <a href="<?= base_url('tportal/order/raporlar') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Sipariş Raporları</span></a>
                            </li>
                            <?php endif; ?>

                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.raporlar.gunluk_rapor') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Günlük Rapor</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.raporlar.gelir_raporlari') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Gelir Raporları</span></a>
                            </li>
                            <li class="nk-menu-item">
                            <a href="<?= route_to('tportal.raporlar.gider_raporlari') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Gider Raporları</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.raporlar.musteri_report') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Müşteri Raporları</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.raporlar.tedarikci_report') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Tedarikçi Raporları</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.raporlar.stock_report') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Stok Raporları</span></a>
                            </li>
                            <li class="nk-menu-item d-none">
                                <a href="<?= route_to('tportal.raporlar.siparis') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Sipariş Raporları</span></a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.raporlar.detayli_odeme_raporlari') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Ödeme Raporları</span></a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="<?= route_to('tportal.raporlar.detayli_tahsilat_raporlari') ?>" class="nk-menu-link"><span
                                        class="nk-menu-text">Tahsilat Raporları</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <?php
                    }
                    if(array_search('Ayarlar', array_column($user_modules, 'module_title')) != null || strval(array_search('Ayarlar', array_column($user_modules, 'module_title'))) == '0'){ ?>
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                                <span class="nk-menu-text">Ayarlar</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="<?= route_to('tportal.ayarlar.kullanici_yonetimi') ?>" class="nk-menu-link"><span
                                            class="nk-menu-text">Kullanıcı Yönetimi</span></a>
                                </li>
                            </ul><!-- .nk-menu-sub -->
                        </li><!-- .nk-menu-item -->
                        <?php }
                    ?>
                </ul><!-- .nk-menu -->
                <div class="nk-sidebar-widget">
                        <div class="widget-title">
                            <h6 class="overline-title">Döviz Kurları
                            </h6>
                            
                        </div>
                        <?php
                        $currencies = getDynamicDBConnection();

                        ?>

                        <ul class="wallet-list">
                            <?php foreach ($currencies as $currency): if($currency["money_code"] != "TRY"): ?>
                            <li class="wallet-item">
                            <a href="#">
                                <div class="wallet-icon">
                                <?php if ($currency['money_code'] == 'USD'): ?>
                                <em class="icon ni ni-sign-usd"></em>
                                <?php elseif ($currency['money_code'] == 'EUR'): ?>
                                <em class="icon ni ni-sign-eur"></em>
                                <?php elseif ($currency['money_code'] == 'TRY'): ?>
                                    <em class="icon ni ni-sign-try"></em>
                                <?php endif; ?>
                                </div>
                                <div class="wallet-text">
                                <h6 class="wallet-name"><?= $currency['money_title']; ?></h6>
                                <span class="wallet-balance"><?= number_format($currency['money_value'], 2); ?>
                                    <span class="currency currency-<?= strtolower($currency['money_code']); ?>">
                                    <?= $currency['money_code']; ?>
                                    </span>
                                </span>
                                <small style="color: #a9cdff; font-size:12px;">Güncellendi: 
                                <?php
                                    // Eğer guncelleme varsa onu kullan, yoksa updated_at'i kullan
                                    $updateTime = !empty($currency['guncelleme']) ? $currency['guncelleme'] : $currency['updated_at'];
                                    echo date('d M Y H:i', strtotime($updateTime));
                                    ?>
                                </small>
                                
                                </div>
                            </a>
                            <!-- Son güncelleme bilgisi -->
                        
                            </li>
                            <?php endif; endforeach; ?>
                        </ul>

                </div>
                                </div><!-- .nk-sidebar-menu -->

                            


                            </div><!-- .nk-sidebar-content -->
                        </div><!-- .nk-sidebar-element -->
                    </div>