<!DOCTYPE html>
<html lang="tr" class="js">


<?= $this->include('auth/inc/head') ?>


    <body class="nk-body ui-rounder npc-default pg-auth">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <!-- wrap @s -->
                <div class="nk-wrap nk-wrap-nosidebar">
                    <!-- content @s -->
                    <div class="nk-content ">
                        <div class="nk-split nk-split-page nk-split-md">
                            <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                                <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                                    <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
                                </div>
                                <div class="nk-block nk-block-middle nk-auth-body">
                                    <div class="brand-logo">
                                        <a href="<?= route_to('auth.index') ?>" class="logo-link">
                                            <!-- <img class="logo-light logo-img logo-img-lg" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="logo"> -->
                                            <img class="logo-dark logo-img logo-img-lg" src="<?= base_url('assets') ?>/assets/custom/tiko_panel_logo_tek_renkli.svg" srcset="<?= base_url('assets') ?>/assets/custom/tiko_panel_logo_tek_renkli.svg 2x" alt="logo-dark">
                                        </a>
                                    </div>
                                    <div class="nk-block-head pb-3">
                                        <div class="nk-block-head-content">
                                            <h5 class="nk-block-title"><?= $this->renderSection('title', true) ?></h5>
                                            <div class="nk-block-des">
                                                <p><?= $this->renderSection('subtitle', true) ?></p>
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                   
                                    <?= $this->include('auth/inc/alert_genel') ?>
                                
                                        
                                    <?= $this->renderSection('content') ?>
                
                                    
                                </div><!-- .nk-block -->

                                <div class="nk-block nk-auth-footer">
                                    <div class="nk-block-between">
                                        <ul class="nav nav-sm">
                                            <li class="nav-item">
                                                <a class="nav-link" target="_blank" href="<?= lang('auth.alt_link1') ?>"><?= lang('auth.alt_link1_title') ?></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" target="_blank" href="<?= lang('auth.alt_link2') ?>"><?= lang('auth.alt_link2_title') ?></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" target="_blank" href="<?= lang('auth.alt_link3') ?>"><?= lang('auth.alt_link3_title') ?></a>
                                            </li>
                                        </ul><!-- .nav -->
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-soft text-center"><a href="https://www.tiko.com.tr"><img class="img" src="<?= base_url('assets') ?>/assets/custom/tiko_digital_logo_tek_renkli.png" alt="" style="height: 24px;"></a></p>
                                    </div>
                                </div><!-- .nk-block -->
                            </div><!-- .nk-split-content -->
                            <div class="nk-split-content nk-split-stretch bg-lighter bg_blue d-flex toggle-break-lg toggle-slide toggle-slide-right" data-toggle-body="true" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
                                <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
                                    <div class="slider-init" data-slick='{"dots":true, "arrows":false}'>
                                        <div class="slider-item">
                                            <div class="nk-feature nk-feature-center">
                                                <div class="nk-feature-img">
                                                    <img class="round" src="<?= base_url('assets') ?>/assets/custom/slide_0.png" srcset="<?= base_url('assets') ?>/assets/custom/slide_0.png" alt="">
                                                </div>
                                                <div class="nk-feature-content py-4 p-sm-5">
                                                    <h4 class="text-white">Kullanımı Kolay Arayüz</h4>
                                                    <p class="text-white">Siz değerli kullanıcılarımızdan gelen geri dönüşler ile
                                                        yazılımımızı ve arayüzümüzü devamlı güncelliyoruz.
                                                        Bunun neticesinde yapılan oylamada 2022 yılının
                                                        en kolay kullanılan fatura yazılımı seçildik.
                                                    </p>
                                                </div>
                                            </div>
                                        </div><!-- .slider-item -->
                                        <div class="slider-item">
                                            <div class="nk-feature nk-feature-center">
                                                <div class="nk-feature-img">
                                                    <img class="round" src="<?= base_url('assets') ?>/assets/custom/slide_1.png" srcset="<?= base_url('assets') ?>/assets/custom/slide_1.png" alt="">
                                                </div>
                                                <div class="nk-feature-content py-4 p-sm-5">
                                                    <h4 class="text-white">Tüm Yazılımlar için Tek Giriş</h4>
                                                    <p class="text-white">Size sunduğumuz özel, fatura, tahsilat, muhasebe ve eticaret gibi tüm yazılımlarımıza tek ekrandan ulaşabiliyorsunuz.
                                                    </p>
                                                </div>
                                            </div>
                                        </div><!-- .slider-item -->
                                        <div class="slider-item">
                                            <div class="nk-feature nk-feature-center">
                                                <div class="nk-feature-img">
                                                    <img class="round" src="<?= base_url('assets') ?>/assets/custom/slide_2.png" srcset="<?= base_url('assets') ?>/assets/custom/slide_2.png" alt="">
                                                </div>
                                                <div class="nk-feature-content py-4 p-sm-5">
                                                    <h4 class="text-white">Hızlı Entegrasyon</h4>
                                                    <p class="text-white">Başta Trendyol, Hepsiburada gibi tüm pazaryerleri, eticaret platformları ve ön muhasebe yazılımları ile<br>entegre çalışlıyoruz.
                                                    </p>
                                                </div>
                                            </div>
                                        </div><!-- .slider-item -->
                                    </div><!-- .slider-init -->
                                    <div class="slider-dots"></div>
                                    <div class="slider-arrows"></div>
                                </div><!-- .slider-wrap -->
                            </div><!-- .nk-split-content -->
                        </div><!-- .nk-split -->
                    </div>
                    <!-- wrap @e -->
                </div>
                <!-- content @e -->
            </div>
            <!-- main @e -->
        </div>
        <!-- app-root @e -->
        <!-- JavaScript -->
       
        <?= $this->include('auth/inc/script') ?>


        <?= $this->renderSection('script') ?>
    </body>

</html>