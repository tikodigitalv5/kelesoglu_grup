





<?= $this->include('tportal/inc/head') ?>

<body class="nk-body ui-rounder has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->

            <?= $this->include('tportal/inc/solmenu') ?>
           
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header is-light nk-header-fixed is-light">
                    <div class="container-xl wide-xl">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1 me-3">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="<?= route_to('tportal.dashboard') ?>" class="logo-link">
                                    <img class="logo-light logo-img" src="<?= base_url('custom/tiko_portal_renkli.png') ?>" srcset="<?= base_url('custom/tiko_portal_renkli.png') ?>" alt="logo">
                                    <img class="logo-dark logo-img" src="<?= base_url('custom/tiko_portal_renkli.png') ?>" srcset="<?= base_url('custom/tiko_portal_renkli.png') ?> 2x" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->
                            <div class="nk-header-menu is-light">
                                <div class="nk-block-head-content">
                                    <h3 class="nk-block-title page-title " style="line-height: .7; margin-bottom:0;"><?= $this->renderSection('title', true) ?></h3>
                                    <div class="nk-block-des text-soft">
                                        <p><?= $this->renderSection('subtitle', true) ?></p>
                                    </div>
                                </div>

                            </div><!-- .nk-header-menu -->
                            <div class="nk-header-tools">
                                
                                <ul class="nk-quick-nav">
                                       
                                      
                                    <li class="nk-block-tools-opt">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="<?= route_to('tportal.stocks.create') ?>" class="<?php if(array_search('Stoklar', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Stoklar', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'disabled'; ?>"><em class="icon ni ni-plus"></em><span>Yeni <b>Stok</b></span></a></li>
                                                    <li><a href="<?= route_to('tportal.faturalar.create') ?>" class="<?php if(array_search('Faturalar', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Faturalar', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'disabled'; ?>"><em class="icon ni ni-plus"></em><span>Yeni <b>Fatura</b></span></a></li>
                                                    <li><a href="#"><em class="icon ni ni-plus"></em><span>Yeni <b>Gider</b></span></a></li>
                                                    <li><a href="<?= route_to('tportal.cariler.create') ?>" class="<?php if(array_search('Cariler', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Cariler', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'disabled'; ?>"><em class="icon ni ni-plus"></em><span>Yeni <b>Cari</b></span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                   
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <em class="icon ni ni-user-alt"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar" style="background: #024ad0 !important;">
                                                        <span style="font-size: 16px; padding-top:5px;"><?= mb_substr(session()->get('user_item')['user_adsoyad'],0,1) ?></span>
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="lead-text"><?= session()->get('user_item')['user_adsoyad'] ?></span>
                                                        <span class="sub-text"><?= session()->get('user_item')['firma_adi'] ?></span>
                                                        <span class="sub-text"><?= session()->get('user_item')['user_eposta'] ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="#"><em class="icon ni ni-user-alt"></em><span>Profil Bilgileri</span></a></li>
                                                    <li><a href="#"><em class="icon ni ni-opt-alt"></em><span>Profil Tercihleri</span></a></li>
                                                    <li><a href="#"><em class="icon ni ni-activity-alt"></em><span>Profil Hareketleri</span></a></li>
                                                    <li><a class="dark-switch" href="#"><em class="icon ni ni-sun-fill"></em><span>Dark Mode</span></a></li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="<?= route_to('user_logout') ?>"><em class="icon ni ni-signout"></em><span>Çıkış</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                              
                                    <li class="dropdown notification-dropdown d-md-inline d-none" >
                                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                            <div class="dropdown-head">
                                                <span class="sub-title nk-dropdown-title">Bildirimler</span>
                                                <a href="#">Tümünü Okundu Yap</a>
                                            </div>
                                            <div class="dropdown-body">
                                                <div class="nk-notification">
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon ni ni-file-download text-primary" style="font-size: 36px"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text"><span>Yeni Gelen Faturalar</span><br>(3 Adet)</div>
                                                            <div class="nk-notification-time">01.07.2023 15:56</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon ni ni-file-check text-warning" style="font-size: 36px"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text"><span>Faturanız Kabul Edildi</span><br>TKD2023000000026<br>MERKEZ BEBEK GEREÇLER..</div>
                                                            <div class="nk-notification-time">01.07.2023 11:27</div>
                                                        </div>
                                                    </div>
                                                    
                                                </div><!-- .nk-notification -->
                                            </div><!-- .nk-dropdown-body -->
                                            <div class="dropdown-foot center">
                                                <a href="#">Tümünü Görüntüle</a>
                                            </div>
                                        </div>
                                    </li>
                                 
                                    <li class=" d-md-inline d-none">
                                    <a href="<?= route_to('user_logout') ?>" class="nk-quick-nav-icon">
                                        <div class="icon-status icon-status-na"><em class="icon ni ni-signout"></em></div>
                                    </a>
                                    </li>

                                </ul>
                            </div><!-- .nk-header-tools -->
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <!-- main header @e -->
                <!-- content @s -->
                 
                <div class="nk-block nk-block-middle  mx-auto">
                  <div class="nk-block-content nk-error-ld text-center">
                    <img class="nk-error-gfx" src="
			<?php echo base_url("error-504.svg"); ?>" alt="">
                    <div class="mx-auto">
                      <h3 class="nk-error-title">Yetkisiz Erişim!</h3>
                      <p class="nk-error-text"><b>Bu sayfaya erişim yetkiniz bulunmamaktadır. Yöneticiniz ile iletişime Geçiniz.</b></p>
                      <a href="javascript:history.back()" class="btn btn-lg btn-primary mt-2">Geri Dön</a>
                    </div>
                  </div>
                </div>                
                <!-- content @e -->

                
                <?= $this->include('tportal/inc/footer') ?>


              
                <?= $this->include('tportal/inc/script') ?>
            
        
                <?= $this->renderSection('script') ?>
                
            
            </body>
            
            </html>