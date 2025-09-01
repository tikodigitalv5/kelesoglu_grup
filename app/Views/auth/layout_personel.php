<!DOCTYPE html>
<html lang="tr" class="js">


<?= $this->include('auth/inc/head') ?>

<style>
    .nk-block-middle {
        padding: 40px;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .card-inner-lg {
        padding: 20px;
    }

    /* Mobil cihazlar için düzenlemeler */
    @media screen and (max-width: 768px) {
        .nk-block-middle {
            padding: 15px;
        }

        .card-inner-lg {
            padding: 15px;
        }

        .brand-logo {
            margin-bottom: 20px;
        }

        .brand-logo img {
            max-width: 150px;
        }
    }
</style>

    <body class="nk-body ui-rounder npc-default pg-auth">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main">
                <!-- wrap @s -->
                <div class="nk-wrap nk-wrap-nosidebar">
                    <!-- content @s -->
                    <div class="nk-content">
                        <div class="nk-block nk-block-middle   mx-auto">
                            
                            
                            <div class="card">
                                <div class="card-inner card-inner-lg">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                        <div class="brand-logo text-center mb-4">
                                <a href="<?= route_to('auth.index') ?>" class="logo-link">
                                    <img class="logo-dark logo-img logo-img-lg" 
                                         src="<?= base_url('assets') ?>/assets/custom/tiko_panel_logo_tek_renkli.svg" 
                                         srcset="<?= base_url('assets') ?>/assets/custom/tiko_panel_logo_tek_renkli.svg 2x" 
                                         alt="logo-dark">
                                </a>
                            </div>
                                            <h4 class="nk-block-title text-center"><?= $this->renderSection('title', true) ?></h4>
                                            <div class="nk-block-des text-center">
                                                <p><?= $this->renderSection('subtitle', true) ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <?= $this->include('auth/inc/alert_genel') ?>
                                    <?= $this->renderSection('content') ?>
                                </div>
                            </div>

                            <div class="nk-block nk-auth-footer">
                                <div class="mt-3">
                                    <p class="text-soft text-center">
                                        <a href="https://www.tiko.com.tr">
                                            <img class="img" 
                                                 src="<?= base_url('assets') ?>/assets/custom/tiko_digital_logo_tek_renkli.png" 
                                                 alt="" 
                                                 style="height: 24px;">
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content @e -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- main @e -->
        </div>
        <!-- app-root @e -->
        <!-- JavaScript -->
       
        <?= $this->include('auth/inc/script') ?>


        <?= $this->renderSection('script') ?>
    </body>

</html>