<?= $this->section('page_title') ?> Operatör Sayfası
<?= $this->endSection() ?>
<?= $this->section('title') ?> <?php echo $operation_title; ?> Operatörü | <?= session()->get('user_item')['user_adsoyad'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>






<?= $this->include('tportal/inc/head') ?>
<style>
    .selectize-input {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 8px;
}

.selectize-dropdown {
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}
.form-label{
    margin-top: 10px;
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/selectize@0.15.2/dist/css/selectize.default.css">


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
                                                <span class="sub-title nk-dropdown-title">Yeni Sevk Emirleri</span>
                                            </div>
                                            <div class="dropdown-body">
                                                <div class="nk-notification">
                                                    <?php foreach ($sevkler as $sevk):
                                                        
                                                        if($sevk["bitti"] == 0){ ?>

                                                                <a target="_blank" href="<?php  echo base_url('tportal/order/sevkPrint/' . $sevk["sevk_id"]) ?>">

                                                                <div class="nk-notification-item dropdown-inner " style="cursor:pointer" >
                                                                    <div class="nk-notification-icon">
                                                                        <em class="icon ni ni-file-download text-primary" style="font-size: 36px"></em>
                                                                    </div>
                                                                    <div class="nk-notification-content">
                                                                        <div class="nk-notification-text"><span><?php echo $sevk["sevk_no"] ?> Numaralı Yeni Sevk Emri</span></div>
                                                                        <div class="nk-notification-time"><?php echo $sevk["created_at"]; ?> 
                                                                        <?php if($sevk["print"] == 1): ?>

                                                                            <div class="badge rounded-pill bg-success">Yazdırıldı</div>

                                                                        <?php endif; ?>
                                                                       
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                                    </a>

                                                       <?php  }else{ ?> 
                                                       

                                                        <a>

<div class="nk-notification-item dropdown-inner tamamlanan_sevk " style="cursor:pointer" >
    <div class="nk-notification-icon">
        <em class="icon ni ni-file-download text-primary" style="font-size: 36px"></em>
    </div>
    <div class="nk-notification-content">
        <div class="nk-notification-text"><span><?php echo $sevk["sevk_no"] ?> Numaralı Yeni Sevk Emri</span></div>
        <div class="nk-notification-time"><?php echo $sevk["created_at"]; ?> 
        <?php if($sevk["bitti"] == 1): ?>

            <div class="badge rounded-pill bg-success">
                  SEVK   TAMAMLANDI
            </div>

        <?php endif; ?>

        <?php if($sevk["bitti"] == 2): ?>

<div class="badge rounded-pill bg-danger">
        MANUEL KAPATILDI
</div>

<?php endif; ?>

       
        </div>


    </div>
</div>
    </a>
                                                       
                                                       
                                                       <?php }
                                                        ?>
                                               

                                                    <?php endforeach; ?>
                                                  
                                                    
                                                </div><!-- .nk-notification -->
                                            </div><!-- .nk-dropdown-body -->
                                            
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




<style>

@media screen and (max-width: 1024px) {
    body {
        zoom: 90%;
        padding: 20px;
    }
    .nk-menu-trigger{
      display:none!important;
    }
}

    .nk-sidebar, .nk-block-tools-opt,  .link-list{
      opacity: 0;
      display: none!important;
    }
  .nk-sidebar + .nk-wrap {
    transition: padding 450ms ease;
    padding-left: 0px !important;
}
    #prosess {} 
    #prosess .prosess-item {
        height:102px;
        transition:.5s;
        margin-bottom: 15px;
    }
    #prosess .prosess-item .title {
        font-family: 'gilroy-semibold';
        letter-spacing: .5px;
        position: relative;
        font-size:18px;
        line-height: 32px;
    }
    #prosess .prosess-item .title em {
        font-size:32px;
        float: left;
        line-height: 32px;
        margin-right:5px;
        margin-top:-2px;
    }
    #prosess .prosess-item .prosessToggle {
        background-color:white;
        padding:35px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: .2s;
    }
     #prosess .prosess-item .prosessToggle:hover {
        background-color:lavender;
    }
    #prosess .prosess-item .prosessToggle span {
        background-color:crimson;
        border-radius: 9px;
        height: 27px;
        padding:0px 10px;
        color:White;
        display:inline-flex;
        justify-content: center;
        font-family: 'gilroy-semibold';
        font-size:13px;
        line-height:28px;
        position: relative;
    }
    #prosess .prosess-item .prosessToggle span:before {
        font-family: "Nioicon" !important;
        speak: never;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        content: "\e99a";
        color:crimson;
        font-size:24px;
        position: absolute;
        left:-14px;
        top:2px;
    }

    #prosess .prosess-item .prosessToggle span.success {
        background-color:#0BB00A;
    }
    #prosess .prosess-item .prosessToggle span.success:before {
        color:#0BB00A;
    }
    #prosess .prosess-item .prosessToggle .row > div {
        display:flex;
        align-items: center;
    }
    #prosess .prosess-item .prosessToggle .caret {
        font-size:22px;
    }
    #prosess .prosess-item .prosessContent {
        background-color:#e7e8ee;
        transition:.5s;
        transform:scaleY(0);
        transform-origin: top;
    }


    #prosess .prosess-item.active .prosessToggle {
        background-color:#024ad0;
        background:#024ad0;
    }
    #prosess .prosess-item.active .prosessToggle .title {
        color:white;
    }
    #prosess .prosess-item.active .prosessToggle .caret {
        color:white;
    }
     #prosess .prosess-item.active .prosessContent {
        transform:scaleY(1);
    }
    .icon + span, span + .icon{
        margin-left:0;
    }




    #prosess .actionUl {
        display:flex;
        justify-content: flex-end;
        gap:8px;
    }
    #prosess .actionUl li {
        width: 100%;
    }
    #prosess .actionUl li a {
        display:flex;
        align-items: center;
        border:solid 1px #024ad040;
        background-color:#024ad03b;       
        padding:30px;
        border-radius: 10px;
        color:#024ad0;
        font-family: 'gilroy-semibold';
        line-height: 52px;
    font-size: 22px;
        justify-content: center;
        flex-direction: column;
    }
    #prosess .actionUl li a em {
        margin-right:5px;
        margin-top:-1px;
    }
    #prosess .actionUl li a.play em:before {
        content:"\eb3a";
    }
    #prosess .actionUl li a.pause {
        background-color: #0BB00A;
        color:White;
    }
    #prosess .actionUl li a.pause span:before {
        content:"Duraklat";
    }
    #prosess .actionUl li a.play span:before {
        content:"Başlat";
    }
    #prosess .actionUl li a.pause em:before {
        content:"\eb25";
    }
    #prosess .actionUl li a:hover {
        background-color:#024ad0;
        color:White;
    }
    #prosess .actionUl li.play a:hover em:before {
        content:"\eb39";
    }
    #prosess .actionUl li a em {
        font-size: 70px;
    line-height: 70px;
    }
    #prosess .datatable-init-operasyon tr td:last-child,
    #prosess .datatable-init-operasyon tr th:last-child {
        text-align: right !important;
        padding-right:25px;
    }
    #prosess .with-export {
        display:flex !important;
        background-color:white;
        margin:0px;
        padding:15px;
    }
    #prosess .with-export .col-5 {
        display:none;
    }
    #prosess .with-export .col-7 {
        width: 100% !important;
        min-width: 100% !important;
        max-width: 100% !important;
    }
    #prosess .with-export .col-7 label {
        width: 100% !important;
        min-width: 100% !important;
        max-width: 100% !important;
    }
    #prosess .with-export .col-7 label input {
        line-height: 40px;
    }
    #prosess .devamEden tbody tr {
        position: relative;   
    }
    #prosess .devamEden .prosessToggle {
        background: rgb(255,255,255);
        background: linear-gradient(90deg, rgba(255,255,255,1) 53%, rgba(29,173,16,0.3701855742296919) 100%);
    }
    #prosess .bekleyen .prosessToggle {
        background: rgb(255,255,255);
        background: linear-gradient(90deg, rgba(255, 255, 255, 1) 53%, rgb(195 174 44 / 37%) 100%);
    }
    #prosess .tamamlanan .prosessToggle {
        background: rgb(255, 255, 255);
        background: linear-gradient(90deg, rgba(255, 255, 255, 1) 53%, rgb(2 74 208 / 62%) 100%);
    }
    #prosess .devamEden tbody tr .progress {
        position: absolute;
        left:0;
        bottom:0;
        width: 100%;
        height: 60px;
        opacity: .2;
        --bs-progress-bg: transparent !important;
        z-index: -1;
    }
    #prosess tbody tr:nth-child(odd) {
        background-color:#ffffff52; !important;
    }
    #prosess tbody tr:nth-child(even) {
        background-color:transparent !important;
    }
    #prosess tbody tr td {
        background-color:transparent !important;
        vertical-align: middle;
    }
    #prosess tbody tr.paused {
        background-color:#ad010140 !important;
    }
    #prosess tbody tr.paused .actionUl li a {
        background-color:white;
    }
    #prosess tbody tr.paused .actionUl li a:hover {
        background-color:#024AD2;
    }

    .islem_bitti{
        background-color:#0BB00A !important;
        color:white!important;
    }

    #barcode {
        margin-bottom:20px;
        margin-top:10px;
    }
    #barcode .inputBox {
        position: relative;
    }
    #barcode .inputBox input {
        width: 100%;
        border-radius: 10px;
        background-color:#e5ecf9;
        border:solid 1px rgba(0,0,0,0.1);
        padding:25px;
        font-size:22px;
        text-align: center;
    }
    #barcode .inputBox em {
        position: absolute;
        left:25px;
        top:25px;
        font-size:36px;
        opacity: .6;
        z-index: 2;
    }

    @-webkit-keyframes AnimationName {
        0%{background-position:0% 50%}
        50%{background-position:100% 50%}
        100%{background-position:0% 50%}
    }
    @-moz-keyframes AnimationName {
        0%{background-position:0% 50%}
        50%{background-position:100% 50%}
        100%{background-position:0% 50%}
    }
    @keyframes AnimationName {
        0%{background-position:0% 50%}
        50%{background-position:100% 50%}
        100%{background-position:0% 50%}
    }

    .dataTables_wrapper > div:last-child {
        background-color:#f5f6fa !important;
    }
    #prosess tbody tr {
        transition: .5s;
        transform:translateX(0px);
        transform-origin: top;
        opacity: 1;
    }
    #prosess tbody tr:nth-child(odd):hover,
    #prosess tbody tr:nth-child(even):hover {
        background-color:#93bed87d !important;
    }


    .urunBilgileri {
        font-size:14px;
        padding:13px;
        background-color:white;
        border-radius: 10px;
    }
    .urunBilgileri li {
        display:flex;
        justify-content: space-between;
    }
    .urunBilgileri li span {
        width: 100%;
    }
    .urunBilgileri li span:first-child{
        max-width: 95px;
    }
    #prosess tbody tr.removeLine {
        transform: translateX(-100%);
        opacity: 0;
    }

    .nowrap{
        margin-left: 0;
    margin-right: 0;
        margin-top: 10px;
    margin-bottom: 20px;

    }


.tdPhoto{
        max-width: 195px;
        display: flex;
    align-items: center;
    justify-content: center;
    }
   .tdPhoto img{
        border-radius: 10px;
    }

    .hrClas{
        background: #024ad1; 
        color: #00153d; 
        height: 1px;
    }
    .hrClas:last-child{
       display: none;
    }

    @media screen and (min-width: 800px) and (max-width: 900px){
        .logo-img{
            margin-left: -57px;
        }
        .nk-menu-trigger{
        display:none;
    }
       
    }

    @media screen and (min-width: 500px) and (max-width: 800px){
        #prosess .actionUl li a{
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 29px;
        }

        span.tamam:before{
            content: 'TAMAMLA'!important;
        }
        .logo-img{
            margin-left: -57px;
        }
        .nk-menu-trigger{
        display:none;
    }
       
    }

    @media screen and (min-width: 1000px) and (max-width: 1200px){
        .logo-img{
            margin-left: -57px;
            margin-right: 15px;
        }
        .nk-menu-trigger{
        display:none;
    }
    }

    @media screen and (max-width: 540px) {
        #prosess .actionUl{
            margin-top: 10px;
        }
        .tdPhoto{
            max-width: 100%;
        }
        .col-m-left {
            padding-left: 0!important;
        }

        .logo-img{
            margin-left: -57px;
        }
        .nk-menu-trigger{
        display:none;
    }
       
    }

    span.tamam:before{
        content: 'Tamamlandı';
    }

    .has-fixed{
        display:none;
    }

    .nk-menu-trigger{
        display:none;
    }


    .box-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.box {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: calc(33.333% - 20px); /* 3 kutu için */
    box-sizing: border-box;
}

.box h3 {
    margin-top: 0;
    color: #333;
}

.box-content {
    margin-top: 20px;
}

/* Responsive düzenleme */
@media (max-width: 768px) {
    .box {
        width: calc(50% - 20px); /* 2 kutu için */
    }
}

@media (max-width: 480px) {
    .box {
        width: 100%; /* 1 kutu için */
    }
}
.yazdir{
    display: flex;
    align-items: center;
    justify-content: center;
}
.loading {
            display: none; /* Başlangıçta gizli olacak */
            text-align: center;
            font-size: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            background: #f5f5f5;
        }

        @keyframes blink {
    0% {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }
    50% {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }
    100% {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }
}

.blinking {
    animation: blink 1.5s linear infinite; /* Yanıp sönme efekti */
}

.select2-container--default .select2-selection--multiple {
    min-height: 45px;
    padding: 5px;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #014ad0;
    color: white;
    border: none;
    padding: 5px 10px;
    margin: 2px;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: white;
    margin-right: 5px;
}

.is-invalid {
    border-color: #dc3545 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}
</style>



    <section id="barcode">
    <div class="container-xl wide-xl">
        <div class="inputBox">
            <input type="text" placeholder="Lütfen Ürün Barkodunu Okutun">
            <em class="icon ni ni-scan"></em>
        </div>
    </div>
</section>
<div id="prosess" class="container-xl wide-xl " style="margin-bottom:350px;">
    <div class="row">
        <!-- ***** -->
        <div class="col-12 prosess-item bekleyen">
            <div class="prosessToggle">
                <div class="row">
                    <div class="col-auto title">
                        <em class="ni ni-loader"></em> Bekleyen İşlemler
                    </div>
                    <div class="col-auto">
                       <span><?php  echo $beklemede_count; ?> Adet</span>
                    </div>
                    <div class="col"></div>
                    <div class="col-auto">
                        <em class="icon ni ni-caret-down-fill caret"></em>
                    </div>
                </div>
            </div>
            <div class="prosessContent">
                <div class="row">
                    <div class="col-12">
                             <div class="nk-block">
                                <div class="nk-data data-list">


                                <div class="">
                                <?php
    if(!$beklemede_operasyonlar){ ?>
            <div class="row">
                <div class="col-md-12">
                    <div style="border-radius: 0; padding: 11px; margin: 3px; font-size:17px" class="alert alert-danger"><strong>Bekleyen İşlem Bulunamadı</strong></div>
                </div>
            </div>
    <?php }else{ foreach ($beklemede_operasyonlar as $outgoing_invoice) {
    if($outgoing_invoice["operation_id"] == $operation) { 
            if(!file_exists(FCPATH . $outgoing_invoice["default_image"]))
            $outgoing_invoice["default_image"] = "uploads/default.png";
        ?>
        <div class=" row mb-2 mt-2 nowrap devam_satir devam_satir_log_<?php echo $outgoing_invoice['production_row_operation_id']; ?> <?php if($outgoing_invoice["status"] == "Durdu" ) { echo 'paused';  } ?>" data-stock_title="<?= $outgoing_invoice['stock_title']; ?>" data-product="<?php echo $outgoing_invoice['production_row_operation_id']; ?>">
        <div class="col-6  col-sm-2 col-md-2 col-lg-2 tdPhoto">
                <a  class="gallery-image popup-image" href="<?php echo $outgoing_invoice["default_image"]; ?>">
                <img src="<?php echo $outgoing_invoice["default_image"]; ?>" alt="" class="img-fluid">
                
                </a>
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-5 col-m-left  ">
                <ul class="urunBilgileri list-unstyled">
                    <li>
                        <span>Sipariş Kodu :</span>
                        <span><b><?php echo $outgoing_invoice['production_number']; ?></b></span>
                    </li>
                    <li>
                        <span>Tarih :</span>
                        <span><?= date("d/m/Y h:i", strtotime($outgoing_invoice['created_at'])) ?></span>
                    </li>
                    <li>
                                <span>Şahıs/Firma :</span>
                                <span><b><?= $outgoing_invoice['cari_invoice_title']; ?></b></span>
                            </li>
                    <li>
                        <span>Ürün Adı :</span>
                        <span><b><?= $outgoing_invoice['stock_title']; ?></b></span>
                    </li>
                    <li>
                        <span>Sipariş :</span>
                        <span><?= number_format($outgoing_invoice['siparis_toplam_miktar'], 2, ',', '.') ?></span>
                    </li>
                    <li>
                        <span>İşlenen :</span>
                        <span><?= number_format(($outgoing_invoice['siparis_toplam_miktar'] - $outgoing_invoice['toplam_satir_sayisi']), 2, ',', '.') ?></span>
                    </li>
                    <li>
                        <span>Kalan :</span>
                        <span><?= number_format($outgoing_invoice['toplam_satir_sayisi'], 2, ',', '.') ?></span>
                    </li>
                </ul>
            </div>
            <div class=" col-12 col-sm-5 col-md-5 col-lg-5">
                <ul class="actionUl">
                    <li>
                    <a 
                                                          data-op_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                                                          data-operation_status="<?=  $outgoing_invoice['status'] ?>"
                                                          data-islenen_miktar="<?=  number_format($outgoing_invoice['used_amount'], 2, ',', '.') ?>"
                                                          data-siparis_miktar="<?=  number_format($outgoing_invoice['stock_amount'], 2, ',', '.') ?>"
                                                          data-islem_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>" 
                                                          class="bekeleyen_baslat"
                                                            href="javascript:;">
                                                               <em class="icon ni ni-play"></em>
                                                               <span>
                                                                   Başlat 
                                                               </span>
                                                            </a>
                    </li>
                   
                </ul>
            </div>
        </div>
        <hr class="hrClas">
<?php } }  }?>

</div>

                                  
                                </div><!-- data-list -->
                            </div><!-- .nk-block -->
                    </div>
                </div>
            </div>
        </div>
        <!-- ***** -->
        <div class="col-12 prosess-item devamEden">
            <div class="prosessToggle">
                <div class="row">
                    <div class="col-auto title">
                        <em class="icon ni ni-play-fill"></em> Devam Eden İşlemler
                    </div>
                    <div class="col-auto">
                       <span class="success"><?php  echo $islemde_count; ?> Adet</span>
                    </div>
                    <div class="col"></div>
                    <div class="col-auto">
                        <em class="icon ni ni-caret-down-fill caret"></em>
                    </div>
                </div>
            </div>
            <div class="prosessContent">
                <div class="row">
                    <div class="col-12">
                             <div class="nk-block">
                                <div class="nk-data data-list">
                                            
                                <div class="">
        

    <?php
    if(!$islemde_operasyonlar){ ?>
            <div class="row">
                <div class="col-md-12">
                    <div style="border-radius: 0; padding: 11px; margin: 3px; font-size:17px" class="alert alert-danger"><strong>Devam Eden İşlem Bulunamadı</strong></div>
                </div>
            </div>
    <?php }else{
       
    foreach ($islemde_operasyonlar as $outgoing_invoice) {
        if($outgoing_invoice["operation_id"] == $operation) {
            if(!file_exists(FCPATH . $outgoing_invoice["default_image"]))
            $outgoing_invoice["default_image"] = "uploads/default.png";
          
        
            if($outgoing_invoice['islemler']){
                  $islemler = json_decode($outgoing_invoice['islemler'], true);
                  $islemKontrol = $islemler["stop_date"];
            }else{
                $islemKontrol  = '';
            }
            ?>
            <div class=" row mb-2 mt-2 nowrap devam_satir devam_satir_log_<?php echo $outgoing_invoice['production_row_operation_id']; ?> <?php if($outgoing_invoice["status"] == "Durdu" ) { echo 'paused';  } ?>" >
                <div class="col-6  col-sm-2 col-md-2 col-lg-2 tdPhoto">
                    <a  class="gallery-image popup-image" href="<?php echo $outgoing_invoice["default_image"]; ?>">
                    <img src="<?php echo $outgoing_invoice["default_image"]; ?>" alt="" class="img-fluid">
                    </a>
                </div>
                <div class="col-6 col-sm-5 col-md-5 col-lg-5 col-m-left  ">
                    <ul class="urunBilgileri list-unstyled">
                        <li>
                            <span>Sipariş Kodu :</span>
                            <span><b><?php echo $outgoing_invoice['production_number']; ?></b></span>
                        </li>
                        <li>
                            <span>Tarih :</span>
                            <span><?= date("d/m/Y h:i", strtotime($outgoing_invoice['created_at'])) ?></span>
                        </li>
                        <li>
                                <span>Şahıs/Firma :</span>
                                <span><b><?= $outgoing_invoice['cari_invoice_title']; ?></b></span>
                            </li>
                        <li>
                            <span>Ürün Adı :</span>
                            <span><b><?= $outgoing_invoice['stock_title']; ?></b></span>
                        </li>
                        <li>
                            <span>Sipariş :</span>
                            <span><?= number_format($outgoing_invoice['toplam_miktar'], 2, ',', '.') ?></span>
                        </li>
                        <li>
                            <span>İşlenen :</span>
                            <span><?= number_format($outgoing_invoice['used_amount'], 2, ',', '.') ?></span>
                        </li>
                        <li>
                            <span>Kalan :</span>
                            <span><?= number_format(($outgoing_invoice['toplam_miktar'] - $outgoing_invoice['used_amount']), 2, ',', '.') ?></span>
                        </li>
                    </ul>
                </div>
                <div class=" col-12 col-sm-5 col-md-5 col-lg-5">
                    <ul class="actionUl">
                        <li>
                            <a data-durdur_tarihi="<?php echo $islemKontrol; ?>" data-data-baslangic="<?php echo $outgoing_invoice["baslangic"]; ?>" data-stock_title="<?= $outgoing_invoice['stock_title']; ?>" data-product="<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                             class="durumislem_<?php echo $outgoing_invoice['production_row_operation_id']; ?> <?php if($outgoing_invoice["status"] == "Durdu" ) { echo 'play';  }else{ echo 'pause'; } ?> "  data-p_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>" href="javascript:;">
                                 <em class="icon ni ni-pause-fill"></em> <span></span>
                                 
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" data-islem_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>" class="kapat_<?php echo $outgoing_invoice['production_row_operation_id']; ?>  <?php if($outgoing_invoice["status"] == "Durdu" ) {?>   devam_ettir <?php }else{ echo 'tamamlandi_baslat'; } ?>  "
                             data-op_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>" data-sac="<?php echo $outgoing_invoice['sac']; ?>" data-operation_status="<?=  $outgoing_invoice['status'] ?>" data-islenen_miktar="<?=  $outgoing_invoice['stock_amount'] ?>" data-siparis_miktar="<?=  $outgoing_invoice['stock_amount'] ?>">
                                 <em class="icon ni ni-check-thick"></em> <span class="tamam"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
    <?php } } }?>

</div>

</div>

                                </div><!-- data-list -->
                            </div><!-- .nk-block -->
                    </div>
                </div>
            </div>
        </div>
        <!-- ***** -->
        <div class="col-12 prosess-item tamamlanan">
            <div class="prosessToggle">
                <div class="row">
                    <div class="col-auto title">
                        <em class="icon ni ni-check-circle-cut"></em> Tamamlanan İşlemler
                    </div>
                    <div class="col-auto">
                       <span class="success"><?php  echo $bitti_count; ?> Adet</span>
                    </div>
                    <div class="col"></div>
                    <div class="col-auto">
                        <em class="icon ni ni-caret-down-fill caret"></em>
                    </div>
                </div>
            </div>
            <div class="prosessContent">
                <div class="row">
                    <div class="col-12">
                             <div class="nk-block">
                                <div class="nk-data data-list">
                                <table class="datatable-init-operasyon nowrap table" data-export-title="Dışa Aktar">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th  style="text-align:left; background-color: #ebeef2;">SIRA</th>
                                                <th  style="text-align:left; background-color: #ebeef2;" data-orderable="false">ŞAHIS/FİRMA</th>
                                                <th  style="text-align:left; background-color: #ebeef2;" data-orderable="false">SİPARİŞ KODU</th>
                                                <th  style="text-align:left; background-color: #ebeef2;" data-orderable="false">TARİH</th>
                                                <th  style="text-align:left; background-color: #ebeef2;" data-orderable="false">ÜRÜN ADI</th>
                                                <th  style="text-align:left; background-color: #ebeef2;" data-orderable="false">SİPARİŞ</th>
                                                <th  style="text-align:left; background-color: #ebeef2;" data-orderable="false">İŞLENEN</th>
                                                <th  style="text-align:left; background-color: #ebeef2;" data-orderable="false">İŞLEYEN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                    foreach ($bitti_operasyonlar as $outgoing_invoice) {
                                  
                                        if($outgoing_invoice["operation_id"] == $operation){
                                      
                                       
                                      ?>
                                            <tr>
                                                <td><?php echo $outgoing_invoice['production_row_operation_id']; ?></td>
                                                <td><b><?php echo $outgoing_invoice['cari_invoice_title']; ?></b></td>
                                                <td><b><?php echo $outgoing_invoice['production_number']; ?></b></td>
                                                <td><?= date("d/m/Y h:i", strtotime($outgoing_invoice['created_at'])) ?></td>
                                                <td><?= $outgoing_invoice['stock_title']; ?></td>
                                                <td><?=  number_format($outgoing_invoice['siparis_toplam_miktar'], 2, ',', '.') ?></td>
                                                <td><?=  number_format($outgoing_invoice['toplam_miktar'], 2, ',', '.') ?></td>
                                                <td><?= session()->get('user_item')['user_adsoyad'] ?></td>
                                            </tr>
                                            <?php } }  ?>
                                        </tbody>
                                    </table>
                                <div class="container d-none">
        

        <?php
        if(!$bitti_operasyonlar){ ?>
                <div class="row">
                    <div class="col-md-12">
                        <div style="border-radius: 0; padding: 11px; margin: 3px; font-size:17px" class="alert alert-danger"><strong>Tamamlanan İşlem Bulunamadı</strong></div>
                    </div>
                </div>
        <?php }else{
        
        foreach ($bitti_operasyonlar as $outgoing_invoice) {
            if($outgoing_invoice["operation_id"] == $operation) { ?>
                <div class=" row mb-2 mt-2 nowrap devam_satir devam_satir_log_<?php echo $outgoing_invoice['production_row_operation_id']; ?> <?php if($outgoing_invoice["status"] == "Durdu" ) { echo 'paused';  } ?>" data-stock_title="<?= $outgoing_invoice['stock_title']; ?>" data-product="<?php echo $outgoing_invoice['production_row_operation_id']; ?>">
                    <div class="col-md-2 tdPhoto">
                        <a  class="gallery-image popup-image" href="<?php echo $outgoing_invoice["default_image"]; ?>">
                        <img src="<?php echo $outgoing_invoice["default_image"]; ?>" alt="" class="img-fluid">
                        </a>
                    </div>
                    <div class="col-md-4">
                        <ul class="urunBilgileri list-unstyled">
                            <li>
                                <span>Sipariş Kodu :</span>
                                <span><b><?php echo $outgoing_invoice['production_number']; ?></b></span>
                            </li>
                            <li>
                                <span>Tarih :</span>
                                <span><?= date("d/m/Y h:i", strtotime($outgoing_invoice['created_at'])) ?></span>
                            </li>
                            <li>
                                <span>Şahıs/Firma :</span>
                                <span><b><?= $outgoing_invoice['cari_invoice_title']; ?></b></span>
                            </li>
                            <li>
                                <span>Ürün Adı :</span>
                                <span><b><?= $outgoing_invoice['stock_title']; ?></b></span>
                            </li>
                            <li>
                                <span>Sipariş :</span>
                                <span><?= number_format($outgoing_invoice['siparis_toplam_miktar'], 2, ',', '.') ?></span>
                            </li>
                            <li>
                                <span>İşlenen :</span>
                                <span><?= number_format($outgoing_invoice['toplam_miktar'], 2, ',', '.') ?></span>
                            </li>
                            <li>
                                <span>Kalan :</span>
                                <span><?= number_format(($outgoing_invoice['siparis_toplam_miktar'] - $outgoing_invoice['toplam_miktar']), 2, ',', '.') ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="actionUl">
                         
                            <li>
                                <a href="javascript:;" class="  islem_bitti " >
                                     <em class="icon ni ni-check-thick"></em> Tamamlandı
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
        <?php } } }?>
    
    </div>
    


                                   
                                </div><!-- data-list -->
                              
                            </div><!-- .nk-block -->
                    </div>
                </div>
            </div>
        </div>
        <!-- ***** -->
</div>
</div>










<div class="modal fade " tabindex="-1" id="excuse">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="operasyon_urun">Operasyon Durumu</h5>
                                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <em class="icon ni ni-cross"></em>
                                    </a>
                                </div>
                                <div class="modal-body bg-white">
                                    <form id="createSubUserModal" class="form-validate is-alter">
                                    <div class="row mb-3 g-3 align-center">
                                        
                                        <div class="col-lg-12 col-xxl-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="firma_adi">Operatör</label>
                                                    <div class="form-control-wrap">
                                                        <input disabled type="text" class="form-control form-control-xl"
                                                        
                                                            value="<?php echo $operation_title; ?> Operatörü | <?= session()->get('user_item')['user_adsoyad'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xxl-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="duraklatma">Duraklatma Nedeni</label>
                                                    <div class="form-control-wrap">
                                                        <textarea type="text" id="duraklatma" class="form-control form-control-xl"
                                                        
                                                            value=""></textarea>
                                                            <input type="hidden" id="production_row_id">
                                                            <input type="hidden" id="production_baslangic">
                                                    </div>
                                                </div>
                                            </div>
                             
                                       </div>
                                    </form>
                                    <hr>
                                  
                                </div>
                                <div class="modal-footer d-block p-3 bg-white">
                                    <div class="row">
                                        <div class="col-md-4 p-0">
                                            <button type="button" class="btn  btn-dim btn-outline-light"
                                                data-bs-dismiss="modal">Kapat</button>
                                        </div>
                                        <div class="col-md-8 text-end p-0">
                                            <button type="button" id="operationPause"    class="btn btn-primary">İşlemi Durdur</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




<?php if($operation == 16): ?>
<div class="modal fade" tabindex="-1" id="lazerModal">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <a href="#" class="close lazerModalClose" data-dismiss="modal" aria-label="Close">
        <em class="icon ni ni-cross"></em>
      </a>
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $operation_title; ?> Operasyonu  / Bekleyen İşlemler</h5>
      </div>
      <div class="modal-body" style="    font-family: monospace;">
        <div class="row">
        
        <div class="row g-3 align-center" id="urun_tipi_alani">
                                                <div class="col-lg-3 col-xxl-3 ">
                                                    <div class="form-group"><label class="form-label" for="type_id">Sac Seçiniz</label>
                                                    <span class="form-note d-none d-md-block">Üretime Uygun Saç Seçiniz</span></div>
                                                </div>
                                                <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap ">
                                                            <div class="form-control-select ">
                                                            <select required="" class="form-control form-control-xl" name="stok_sec" id="stok_sec" multiple="multiple">
    <?php foreach($modalStock as $stock): ?>
        <option value="<?php echo $stock["stock_id"] ?>"><?php echo $stock["stock_code"] ?> - <?php echo $stock["stock_title"] ?></option>
    <?php endforeach; ?>
</select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center mb-5" id="urun_tipi_alani">
                                                <div class="col-lg-3 col-xxl-3 ">
                                                    <div class="form-group"><label class="form-label" for="type_id">İşler</label>
                                                    <span class="form-note d-none d-md-block">Aktif Üretim Emirleri</span></div>
                                                </div>
                                                <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap ">
                                                            <div class="form-control " style="display:flex;     flex-direction: column;">
                                                            <?php foreach ($beklemede_operasyonlar as $islenen_invoice) { ?>
    <label style="display: flex ; align-items: center;  gap: 6px;">
        <input type="checkbox"  
               data-op_id="<?php echo $islenen_invoice['production_row_operation_id']; ?>"
               data-operation_status="<?=  $islenen_invoice['status'] ?>"
               data-islenen_miktar="<?=  number_format(($islenen_invoice['siparis_toplam_miktar'] - $islenen_invoice['toplam_satir_sayisi']), 2, ',', '.') ?>"
               data-siparis_miktar="<?=  number_format($islenen_invoice['siparis_toplam_miktar'], 2, ',', '.') ?>" 
               data-row-marker="row_marker_<?php echo $islenen_invoice['production_row_operation_id']; ?>"
               name="operation_ids[]" 
               value="<?php echo $islenen_invoice['operation_id']; ?>" 
               <?php if ($islenen_invoice["operation_id"] == $operation) echo 'checked'; ?>>
        <strong><?php echo $islenen_invoice["cari_invoice_title"]; ?></strong> - 
        <?php echo $islenen_invoice['production_number']; ?> - 
        <?php echo $islenen_invoice['stock_title']; ?>
    </label>
<?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                    
                                    

                                            <div class="row g-3 align-center" id="uretilen_adet_form">
                                                <div class="col-lg-3 col-xxl-3 ">
                                                    <div class="form-group"><label class="form-label" for="type_id">Üretilen Adet</label>
                                                    <span class="form-note d-none d-md-block">Lütfen Üretilen Adet Giriniz</span></div>
                                                </div>
                                                <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                                <div class="table-responsive">
    <table class="table table_bekleyen table-bordered">
        <thead>
            <tr>
                <th>Stok Adı</th>
                <th >Tümünü Ürettin mi?</th>
                <th>Sipariş</th>
                <th>Kalan</th>
                <th>Üretilen</th>
                <th>Aktif Kalan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($beklemede_operasyonlar as $outgoing_invoice) { ?>
                <tr data-row-marker="row_marker_<?php echo $outgoing_invoice['production_row_operation_id']; ?>">

                    <td>
                        <strong><?php echo $outgoing_invoice['stock_title']; ?></strong>
                        <br>
                        <small><?php echo $outgoing_invoice['production_number']; ?></small>
                    </td>
                    <td class="text-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" 
                                   class="custom-control-input tumu_kullanildi" 
                                   id="tumu_uretildi_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                                   data-op_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>">
                            <label class="custom-control-label" 
                                   for="tumu_uretildi_<?php echo $outgoing_invoice['production_row_operation_id']; ?>">
                            </label>
                        </div>
                    </td>
                    <td>
                        <input type="text" 
                               class="form-control siparis_toplam_adeti" 
                               id="siparis_toplam_adeti_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               value="<?=  number_format($outgoing_invoice['siparis_toplam_miktar'], 2, ',', '.') ?>" 
                               disabled>
                    </td>
                    <td>
                        <input type="text" 
                               class="form-control toplam_kalan_adet" 
                               id="toplam_kalan_adet_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               value="<?= number_format($outgoing_invoice['toplam_satir_sayisi'], 2, ',', '.') ?>" 
                               disabled>
                    </td>
                    <td>
                        <input type="text" 
                               class="form-control toplam_uretilen_adet" 
                               id="toplam_uretilen_adet_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               data-siparis_miktar="<?php echo $outgoing_invoice['toplam_miktar']; ?>"
                               value="0"
                               min="0"
                               max="<?php echo $outgoing_invoice['toplam_miktar']; ?>">
                    </td>
                  
                    <td>
                        <input type="text" 
                               class="form-control aktif_kalan" 
                               id="aktif_kalan_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               value="<?= number_format($outgoing_invoice['toplam_satir_sayisi'], 2, ',', '.') ?>" 
                               disabled>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<style>
.table {
    background: white;
    margin-bottom: 0;
}
.table th {
    background: #f5f6fa;
    vertical-align: middle;
    text-align: center;
}
.table td {
    vertical-align: middle;
}
.custom-control {
    min-height: 1.5rem;
    padding-left: 1.5rem;
    margin-bottom: 0;
}
.form-control:disabled {
    background-color: #f5f6fa;
}
</style>

<script>
    setTimeout(() => {
    $(document).ready(function() {
        
        // Tablo satırlarını kontrol et ve göster/gizle
        function updateTableRows() {
            // Önce tüm satırları gizle
            $('.table_bekleyen tbody tr').addClass('d-none');
            
            // Seçili checkbox'ları kontrol et
            $('input[name="operation_ids[]"]:checked').each(function() {
                let marker = $(this).data('row-marker');
                // İlgili satırı göster
                $(`.table_bekleyen tbody tr[data-row-marker="${marker}"]`).removeClass('d-none');
            });

            // Hiç seçili checkbox yoksa tüm satırları göster
            if ($('input[name="operation_ids[]"]:checked').length === 0) {
                $('.table_bekleyen tbody tr').removeClass('d-none');
            }
        }

        // Checkbox değişiminde tabloyu güncelle
        $('body').on('change', 'input[name="operation_ids[]"]', function() {
            updateTableRows();
        });

        // Modal açıldığında ilk kontrolü yap
        $('#lazerModal').on('shown.bs.modal', function() {
            // İlk yüklemede seçili checkbox'lara göre tabloyu güncelle
            setTimeout(() => {
                updateTableRows();
            }, 100);
        });

        // Modal açıldığında ilk kontrolü yap
        $('#lazerModal').on('shown.bs.modal', function() {
            updateTableRows();
            // Sayfa yüklendiğinde tüm değerleri formatla
            $(".toplam_uretilen_adet, .toplam_kalan_adet, .aktif_kalan").each(function() {
                let value = parseFloat($(this).val()) || 0;
                $(this).val(value.toFixed(2).replace('.', ','));
            });
        });

        // Diğer event handler'lar aynı kalacak...
        $('body').on('change', '.tumu_kullanildi', function() {
            let row_id = $(this).data('op_id');
            let uretilen = $("#toplam_uretilen_adet_" + row_id);
            let kalan = $("#toplam_kalan_adet_" + row_id);
            let aktifKalan = $("#aktif_kalan_" + row_id);

            if($(this).is(":checked")) {
                let kalanMiktar = parseFloat(kalan.val().replace(',', '.')) || 0;
                uretilen.val(kalanMiktar.toFixed(2).replace('.', ','));
                aktifKalan.val('0,00');
                uretilen.prop('disabled', true);
            } else {
                uretilen.val('0,00');
                uretilen.prop('disabled', false);
                let kalanMiktar = parseFloat(kalan.val().replace(',', '.')) || 0;
                aktifKalan.val(kalanMiktar.toFixed(2).replace('.', ','));
            }
        });

        // Üretilen miktar input kontrolü
        $('body').on('keypress', '.toplam_uretilen_adet', function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $('body').on('input', '.toplam_uretilen_adet', function() {
            let $this = $(this);
            let currentValue = $this.val();
            let row_id = $this.attr('id').split('_').pop();
            let kalan = parseFloat($("#toplam_kalan_adet_" + row_id).val().replace(',', '.')) || 0;
            
            let girilenMiktar = parseInt(currentValue) || 0;
            
            if (girilenMiktar > kalan) {
                girilenMiktar = kalan;
                $this.val(kalan.toFixed(0));
                
                Swal.fire({
                    title: 'Uyarı!',
                    text: 'Kalan miktardan fazla değer giremezsiniz!',
                    icon: 'warning',
                    confirmButtonText: 'Tamam'
                });
            }

            let yeniAktifKalan = kalan - girilenMiktar;
            $("#aktif_kalan_" + row_id).val(yeniAktifKalan.toFixed(2).replace('.', ','));
        });

        // Modal kapandığında temizlik
        $('#lazerModal').on('hidden.bs.modal', function() {
            $('.tumu_kullanildi').prop('checked', false);
            $('.toplam_uretilen_adet').each(function() {
                $(this).val('0').prop('disabled', false);
            });
            $('.aktif_kalan').each(function() {
                let row_id = $(this).attr('id').split('_').pop();
                let kalanDeger = $("#toplam_kalan_adet_" + row_id).val();
                $(this).val(kalanDeger);
            });
            // Tüm tablo satırlarını göster (bir sonraki açılış için)
            $('.table tbody tr').show();
        });
    });
}, 100);
</script>
                                                  
                                                </div>
                                            </div>

                                       
         
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-primary" id="islemBaslat">Başlat</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" tabindex="-1" id="lazerModalDevam">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <a href="#" class="close lazerModalClose" data-dismiss="modal" aria-label="Close">
        <em class="icon ni ni-cross"></em>
      </a>
      <div class="modal-header">
        <h5 class="modal-title">Lazer Operasyonu - Kesim İşlemleri / Devam Eden İşlemler</h5>
      </div>
      <div class="modal-body">
        <div class="row">
        
        <div class="row g-3 align-center" id="urun_tipi_alani">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="type_id">Sac Seçiniz</label>
                                                    <span class="form-note d-none d-md-block">Üretime Uygun Saç Seçiniz</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap ">
                                                        <div class="form-control-select ">
                                                        
                                                        <select required="" class="form-control form-control-xl" name="islem_stok" id="islem_stok" multiple="multiple">
    <?php foreach($modalStock as $stock): ?>
        <option value="<?php echo $stock["stock_id"] ?>"><?php echo $stock["stock_code"] ?> - <?php echo $stock["stock_title"] ?></option>
    <?php endforeach; ?>
</select>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center mb-5" id="urun_tipi_alani">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="type_id">İşler</label>
                                                    <span class="form-note d-none d-md-block">Aktif Üretim Emirleri</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap ">
                                                       
                                                        
                                                        <div class="form-control " style="display:flex;     flex-direction: column;">
                                                            <?php foreach ($islemde_operasyonlar as $outgoing_invoice) { ?>
    <label style="display: flex; align-items: center;  gap: 6px;">
        <input type="checkbox"  
       disabled
             data-op_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
               data-operation_status="<?=  $outgoing_invoice['status'] ?>"
               data-islenen_miktar="<?=  number_format(($outgoing_invoice['siparis_toplam_miktar'] - $outgoing_invoice['toplam_satir_sayisi']), 2, ',', '.') ?>"
               data-siparis_miktar="<?=  number_format($outgoing_invoice['siparis_toplam_miktar'], 2, ',', '.') ?>" 
               data-row-islenen="row_marker_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
               name="operation_idsislenen[]" 
               data-sac="<?php echo $outgoing_invoice['sac']; ?>" 
               value="<?php echo $outgoing_invoice['operation_id']; ?>" 
               <?php if ($outgoing_invoice["operation_id"] == $operation) echo 'checked'; ?>>
        <strong><?php echo $outgoing_invoice["cari_invoice_title"]; ?></strong> - 
        <?php echo $outgoing_invoice['production_number']; ?> - 
        <?php echo $outgoing_invoice['stock_title']; ?>
    </label>
<?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                       <div class="bitis_sonrasi">
                                       <div class="row g-3 align-center" id="urun_tipi_alani">
    <div class="col-lg-5 col-xxl-5 ">
        <div class="form-group">
            <label class="form-label" for="type_id">Kalan Sac</label>
            <span class="form-note d-none d-md-block">Üretim Sonrası Kalan Sac</span>
        </div>
    </div>
    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
        <div class="form-group" style="">
            <div class="form-control-wrap">
            <div id="olcu-container">
            <div class="olcu-row form-control col-12 mb-2" style="display: flex; align-items: center; gap: 20px;">
                <div class="form-group col-3" style="margin-bottom:0; display:flex; align-items: center; gap: 12px;">
                    <label class="form-label" for="en_0">EN</label>
                    <input type="number" class="form-control en-input" id="en_0" name="en[]" step="0.01">
                </div>
                <div class="form-group col-3" style="margin-bottom:0; display:flex; align-items: center; gap: 12px;">
                    <label class="form-label" for="boy_0">BOY</label>
                    <input type="number" class="form-control boy-input" id="boy_0" name="boy[]" step="0.01">
                </div>
                <div class="form-group col-3" style="margin-bottom:0; display:flex; align-items: center; gap: 12px;">
                    <label class="form-label" for="sac_0">SAÇ</label>
                    <select name="sac[]" id="sac_0" class="form-control">
                        <option value="0">Lütfen Seçiniz</option>
                        
                    </select>
                </div>
                <div class="col-4 d-flex align-items-center">
                    <button type="button" class="btn btn-icon btn-outline-primary btn-sm ekle-btn" style="margin-right: 10px;">
                        <em class="icon ni ni-plus"></em>
                    </button>
                    <button type="button" class="btn btn-icon btn-outline-danger btn-sm ml-2 sil-btn" style="display:none;">
                        <em class="icon ni ni-trash"></em>
                    </button>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 align-center" id="urun_tipi_alani">
    <div class="col-lg-5 col-xxl-5 ">
        <div class="form-group">
            <label class="form-label" for="type_id">Hepsini Kullandın mı?</label>
            <span class="form-note d-none d-md-block">Üretim emiri sonucu arta kalan malzeme </span>
        </div>
    </div>
    <div class="col-lg-6 col-xxl-7 mt-0 mt-md-2">
        <div class="form-group">
            <div class="form-control-wrap">
                <div class="form-control">
                    <label style="display: flex; align-items: center; gap: 6px;">
                        <input type="checkbox" id="hepsini-kullandin-checkbox" name="operasyon_bitir" value="1">
                        Tüm ürünü kullandınız mı?
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row g-3 align-center mt-3" id="uretilen_adet_form">
                                                <div class="col-lg-3 col-xxl-3 ">
                                                    <div class="form-group"><label class="form-label" for="type_id">Üretilen Adet</label>
                                                    <span class="form-note d-none d-md-block">Lütfen Üretilen Adet Giriniz</span></div>
                                                </div>
                                                <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                                <div class="table-responsive">
    <table class="table table_islenen table-bordered">
        <thead>
            <tr>
                <th>Stok Adı</th>
                <th >Tümünü Ürettin mi?</th>
                <th>Sipariş</th>
                <th>Kalan</th>
                <th>Üretilen</th>
                <th>Aktif Kalan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($islemde_operasyonlar as $outgoing_invoice) { ?>
                <tr data-row-islenen="row_marker_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>">

                    <td>
                        <strong><?php echo $outgoing_invoice['stock_title']; ?></strong>
                        <br>
                        <small><?php echo $outgoing_invoice['production_number']; ?></small>
                    </td>
                    <td class="text-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" 
                                   class="custom-control-input tumu_kullanildi_islenen" 
                                   id="tumu_uretildi_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                                   data-op_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>">
                            <label class="custom-control-label" 
                                   for="tumu_uretildi_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>">
                            </label>
                        </div>
                    </td>
                    <td>
                        <input type="text" 
                               class="form-control siparis_toplam_adeti_islenen" 
                               id="siparis_toplam_adeti_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               value="<?=  number_format($outgoing_invoice['siparis_toplam_miktar'], 2, ',', '.') ?>" 
                               disabled>
                    </td>
                    <td>
                                <input type="text" 
                               class="form-control toplam_kalan_adet_islenen" 
                               id="toplam_kalan_adet_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               value="<?= number_format($outgoing_invoice['toplam_satir_sayisi'], 2, ',', '.') ?>" 
                               disabled>
                    </td>
                    <td>
                        <input type="text" 
                               class="form-control toplam_uretilen_adet_islenen" 
                               id="toplam_uretilen_adet_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               data-siparis_miktar="<?php echo $outgoing_invoice['toplam_miktar']; ?>"
                               value="0"
                               min="0"
                               max="<?php echo $outgoing_invoice['toplam_miktar']; ?>">
                    </td>
                  
                    <td>
                        <input type="text" 
                               class="form-control aktif_kalan_islenen" 
                               id="aktif_kalan_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               value="<?= number_format($outgoing_invoice['toplam_satir_sayisi'], 2, ',', '.') ?>" 
                               disabled>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<style>
.table_islenen {
    background: white;
    margin-bottom: 0;
}
.table_islenen th {
    background: #f5f6fa;
    vertical-align: middle;
    text-align: center;
}
.table_islenen td {
    vertical-align: middle;
}
.custom-control {
    min-height: 1.5rem;
    padding-left: 1.5rem;
    margin-bottom: 0;
}
.form-control:disabled {
    background-color: #f5f6fa;
}
</style>

<script>
    setTimeout(() => {
    $(document).ready(function() {
      
        // Tablo satırlarını kontrol et ve göster/gizle
        function updateTableRowsIslenen() {
            // Önce tüm satırları gizle
            $('.table_islenen tbody tr').addClass('d-none');
            
            // Seçili checkbox'ları kontrol et
            $('input[name="operation_idsislenen[]"]:checked').each(function() {
                let marker = $(this).data('row-islenen');
              
                $(`.table_islenen tbody tr[data-row-islenen="${marker}"]`).removeClass('d-none');
            });

            // Hiç seçili checkbox yoksa tüm satırları göster
            if ($('input[name="operation_idsislenen[]"]:checked').length === 0) {
                let marker = $(this).data('row-islenen');
                
             
                
                $('.table_islenen tbody tr').removeClass('d-none');
            }

        }

        // Checkbox değişiminde tabloyu güncelle
        $('body').on('change', 'input[name="operation_idsislenen[]"]', function() {
            updateTableRowsIslenen();
        });

        // Modal açıldığında ilk kontrolü yap
        $('#lazerModalDevam').on('shown.bs.modal', function() {
            // İlk yüklemede seçili checkbox'lara göre tabloyu güncelle
            setTimeout(() => {
                updateTableRowsIslenen();
            }, 100);
        });

        // Modal açıldığında ilk kontrolü yap
            $('#lazerModalDevam').on('shown.bs.modal', function() {
            updateTableRowsIslenen();
            // Sayfa yüklendiğinde tüm değerleri formatla
            $(".toplam_uretilen_adet_islenen, .toplam_kalan_adet_islenen, .aktif_kalan_islenen").each(function() {
                let value = parseFloat($(this).val()) || 0;
                $(this).val(value.toFixed(2).replace('.', ','));
            });
        });

        // Diğer event handler'lar aynı kalacak...
        $('body').on('change', '.tumu_kullanildi_islenen', function() {
            let row_id = $(this).data('op_id');
            let uretilen = $("#toplam_uretilen_adet_islenen_" + row_id);
            let kalan = $("#toplam_kalan_adet_islenen_" + row_id);
            let aktifKalan = $("#aktif_kalan_islenen_" + row_id);

            if($(this).is(":checked")) {
                let kalanMiktar = parseFloat(kalan.val().replace(',', '.')) || 0;
                uretilen.val(kalanMiktar.toFixed(2).replace('.', ','));
                aktifKalan.val('0,00');
                uretilen.prop('disabled', true);
            } else {
                uretilen.val('0,00');
                uretilen.prop('disabled', false);
                let kalanMiktar = parseFloat(kalan.val().replace(',', '.')) || 0;
                aktifKalan.val(kalanMiktar.toFixed(2).replace('.', ','));
            }
        });

        // Üretilen miktar input kontrolü
        $('body').on('keypress', '.toplam_uretilen_adet_islenen', function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $('body').on('input', '.toplam_uretilen_adet_islenen', function() {
            let $this = $(this);
            let currentValue = $this.val();
            let row_id = $this.attr('id').split('_').pop();
            let kalan = parseFloat($("#toplam_kalan_adet_islenen_" + row_id).val().replace(',', '.')) || 0;
            
            let girilenMiktar = parseInt(currentValue) || 0;
            
            if (girilenMiktar > kalan) {
                girilenMiktar = kalan;
                $this.val(kalan.toFixed(0));
                
                Swal.fire({
                    title: 'Uyarı!',
                    text: 'Kalan miktardan fazla değer giremezsiniz!',
                    icon: 'warning',
                    confirmButtonText: 'Tamam'
                });
            }

            let yeniAktifKalan = kalan - girilenMiktar;
            $("#aktif_kalan_islenen_" + row_id).val(yeniAktifKalan.toFixed(2).replace('.', ','));
        });

        // Modal kapandığında temizlik
        $('#lazerModalDevam').on('hidden.bs.modal', function() {
            $('.tumu_kullanildi_islenen').prop('checked', false);
            $('.toplam_uretilen_adet_islenen').each(function() {
                $(this).val('0').prop('disabled', false);
            });
            $('.aktif_kalan').each(function() {
                let row_id = $(this).attr('id').split('_').pop();
                let kalanDeger = $("#toplam_kalan_adet_islenen_" + row_id).val();
                $(this).val(kalanDeger);
            });
            // Tüm tablo satırlarını göster (bir sonraki açılış için)
            $('.table_islenen tbody tr').show();
        });
    });
}, 200);
</script>
                                                  
                                                </div>
                                            </div>
                                       </div>
         
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-primary" id="islemDevam">Tamamla!</button>
      </div>
    </div>
  </div>
</div>
<?php else: ?>

    <div class="modal fade" tabindex="-1" id="tumOperasyonlarBekleyen">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <a href="#" class="close lazerModalClose" data-dismiss="modal" aria-label="Close">
        <em class="icon ni ni-cross"></em>
      </a>
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $operation_title; ?> Operasyonu  | Bekleyen İşlemler</h5>
      </div>
      <div class="modal-body" style="    font-family: monospace;">
        <div class="row">
        


                                            <div class="row g-3 align-center mb-5" id="urun_tipi_alani">
                                                <div class="col-lg-3 col-xxl-3 ">
                                                    <div class="form-group"><label class="form-label" for="type_id">İşler</label>
                                                    <span class="form-note d-none d-md-block">Aktif Üretim Emirleri</span></div>
                                                </div>
                                                <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap ">
                                                            <div class="form-control " style="display:flex;     flex-direction: column;">
                                                            <?php foreach ($beklemede_operasyonlar as $islenen_invoice) { ?>
    <label style="display: flex ; align-items: center;  gap: 6px;">
        <input type="checkbox"  
               data-op_id="<?php echo $islenen_invoice['production_row_operation_id']; ?>"
               data-operation_status="<?=  $islenen_invoice['status'] ?>"
               data-islenen_miktar="<?=  number_format(($islenen_invoice['siparis_toplam_miktar'] - $islenen_invoice['toplam_satir_sayisi']), 2, ',', '.') ?>"
               data-siparis_miktar="<?=  number_format($islenen_invoice['siparis_toplam_miktar'], 2, ',', '.') ?>" 
               data-row-default="row_marker_default_<?php echo $islenen_invoice['production_row_operation_id']; ?>"
               name="operation_default_ids[]" 
               value="<?php echo $islenen_invoice['operation_id']; ?>" 
               <?php if ($islenen_invoice["operation_id"] == $operation) echo 'checked'; ?>>
        <strong><?php echo $islenen_invoice["cari_invoice_title"]; ?></strong> - 
        <?php echo $islenen_invoice['production_number']; ?> - 
        <?php echo $islenen_invoice['stock_title']; ?>
    </label>
<?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                    
                                    

                                            <div class="row g-3 align-center" id="uretilen_adet_form">
                                                <div class="col-lg-3 col-xxl-3 ">
                                                    <div class="form-group"><label class="form-label" for="type_id">Üretilen Adet</label>
                                                    <span class="form-note d-none d-md-block">Lütfen Üretilen Adet Giriniz</span></div>
                                                </div>
                                                <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                                <div class="table-responsive">
    <table class="table table_default_bekleyen table-bordered">
        <thead>
            <tr>
                <th>Stok Adı</th>
                <th >Tümünü Ürettin mi?</th>
                <th>Sipariş</th>
                <th>Kalan</th>
                <th>Üretilen</th>
                <th>Aktif Kalan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($beklemede_operasyonlar as $outgoing_invoice) { ?>
                <tr data-row-default="row_marker_default_<?php echo $outgoing_invoice['production_row_operation_id']; ?>">

                    <td>
                        <strong><?php echo $outgoing_invoice['stock_title']; ?></strong>
                        <br>
                        <small><?php echo $outgoing_invoice['production_number']; ?></small>
                    </td>
                    <td class="text-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" 
                                   class="custom-control-input tumu_kullanildi_default" 
                                   id="tumu_uretildi_default_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                                   data-op_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>">
                            <label class="custom-control-label" 
                                   for="tumu_uretildi_default_<?php echo $outgoing_invoice['production_row_operation_id']; ?>">
                            </label>
                        </div>
                    </td>
                    <td>
                        <input type="text" 
                               class="form-control siparis_toplam_adeti" 
                               id="siparis_toplam_adeti_default_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               value="<?=  number_format($outgoing_invoice['siparis_toplam_miktar'], 2, ',', '.') ?>" 
                               disabled>
                    </td>
                    <td>
                        <input type="text" 
                               class="form-control toplam_kalan_adet_default" 
                               id="toplam_kalan_adet_default_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               value="<?= number_format($outgoing_invoice['toplam_satir_sayisi'], 2, ',', '.') ?>" 
                               disabled>
                    </td>
                    <td>
                        <input type="text" 
                               class="form-control toplam_uretilen_adet_default" 
                               id="toplam_uretilen_adet_default_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               data-siparis_miktar="<?php echo $outgoing_invoice['toplam_miktar']; ?>"
                               value="0"
                               min="0"
                               max="<?php echo $outgoing_invoice['toplam_miktar']; ?>">
                    </td>
                  
                    <td>
                        <input type="text" 
                               class="form-control aktif_kalan_default" 
                               id="aktif_kalan_default_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               value="<?= number_format($outgoing_invoice['toplam_satir_sayisi'], 2, ',', '.') ?>" 
                               disabled>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<style>
.table {
    background: white;
    margin-bottom: 0;
}
.table th {
    background: #f5f6fa;
    vertical-align: middle;
    text-align: center;
}
.table td {
    vertical-align: middle;
}
.custom-control {
    min-height: 1.5rem;
    padding-left: 1.5rem;
    margin-bottom: 0;
}
.form-control:disabled {
    background-color: #f5f6fa;
}
</style>

<script>
    setTimeout(() => {
    $(document).ready(function() {
        
        // Tablo satırlarını kontrol et ve göster/gizle
        function DefaultupdateTableRows() {
            // Önce tüm satırları gizle
            $('.table_default_bekleyen tbody tr').addClass('d-none');
            
            // Seçili checkbox'ları kontrol et
            $('input[name="operation_default_ids[]"]:checked').each(function() {
                let marker = $(this).data('row-default');
                // İlgili satırı göster
                $(`.table_default_bekleyen tbody tr[data-row-default="${marker}"]`).removeClass('d-none');
            });

            // Hiç seçili checkbox yoksa tüm satırları göster
            if ($('input[name="operation_default_ids[]"]:checked').length === 0) {
                $('.table_default_bekleyen tbody tr').removeClass('d-none');
            }
        }

        // Checkbox değişiminde tabloyu güncelle
        $('body').on('change', 'input[name="operation_default_ids[]"]', function() {
            DefaultupdateTableRows();
        });

        // Modal açıldığında ilk kontrolü yap
        $('#tumOperasyonlarBekleyen').on('shown.bs.modal', function() {
            // İlk yüklemede seçili checkbox'lara göre tabloyu güncelle
            setTimeout(() => {
                DefaultupdateTableRows();
            }, 100);
        });

        // Modal açıldığında ilk kontrolü yap
        $('#tumOperasyonlarBekleyen').on('shown.bs.modal', function() {
            DefaultupdateTableRows();
            // Sayfa yüklendiğinde tüm değerleri formatla
            $(".toplam_uretilen_adet_default, .toplam_kalan_adet_default, .aktif_kalan_default").each(function() {
                let value = parseFloat($(this).val()) || 0;
                $(this).val(value.toFixed(2).replace('.', ','));
            });
        });

        // Diğer event handler'lar aynı kalacak...
        $('body').on('change', '.tumu_kullanildi_default', function() {
            let row_id = $(this).data('op_id');
            let uretilen = $("#toplam_uretilen_adet_default_" + row_id);
            let kalan = $("#toplam_kalan_adet_default_" + row_id);
            let aktifKalan = $("#aktif_kalan_default_" + row_id);

            if($(this).is(":checked")) {
                let kalanMiktar = parseFloat(kalan.val().replace(',', '.')) || 0;
                uretilen.val(kalanMiktar.toFixed(2).replace('.', ','));
                aktifKalan.val('0,00');
                uretilen.prop('disabled', true);
            } else {
                uretilen.val('0,00');
                uretilen.prop('disabled', false);
                let kalanMiktar = parseFloat(kalan.val().replace(',', '.')) || 0;
                aktifKalan.val(kalanMiktar.toFixed(2).replace('.', ','));
            }
        });

        // Üretilen miktar input kontrolü
        $('body').on('keypress', '.toplam_uretilen_adet_default', function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $('body').on('input', '.toplam_uretilen_adet_default', function() {
            let $this = $(this);
            let currentValue = $this.val();
            let row_id = $this.attr('id').split('_').pop();
            let kalan = parseFloat($("#toplam_kalan_adet_default_" + row_id).val().replace(',', '.')) || 0;
            
            let girilenMiktar = parseInt(currentValue) || 0;
            
            if (girilenMiktar > kalan) {
                girilenMiktar = kalan;
                $this.val(kalan.toFixed(0));
                
                Swal.fire({
                    title: 'Uyarı!',
                    text: 'Kalan miktardan fazla değer giremezsiniz!',
                    icon: 'warning',
                    confirmButtonText: 'Tamam'
                });
            }

            let yeniAktifKalan = kalan - girilenMiktar;
            $("#aktif_kalan_default_" + row_id).val(yeniAktifKalan.toFixed(2).replace('.', ','));
        });

        // Modal kapandığında temizlik
        $('#tumOperasyonlarBekleyen').on('hidden.bs.modal', function() {
            $('.tumu_kullanildi_default').prop('checked', false);
                $('.toplam_uretilen_adet_default').each(function() {
                $(this).val('0').prop('disabled', false);
            });
            $('.aktif_kalan_default').each(function() {
                let row_id = $(this).attr('id').split('_').pop();
                let kalanDeger = $("#toplam_kalan_adet_default_" + row_id).val();
                $(this).val(kalanDeger);
            });
            // Tüm tablo satırlarını göster (bir sonraki açılış için)
            $('.table_default_bekleyen tbody tr').show();
        });
    });
}, 100);
</script>
                                                  
                                                </div>
                                            </div>

                                       
         
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-primary operasyonBekleyen" id="operasyonBekleyen">Başlat</button>
      </div>
    </div>
  </div>
</div>





<div class="modal fade" tabindex="-1" id="tumOperasyonlarDevam">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <a href="#" class="close lazerModalClose" data-dismiss="modal" aria-label="Close">
        <em class="icon ni ni-cross"></em>
      </a>
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $operation_title; ?> / Devam Eden İşlemler</h5>
      </div>
      <div class="modal-body">
        <div class="row">
        
      

                                          <div class="row g-3 align-center mb-5" id="urun_tipi_alani">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="type_id">İşler</label>
                                                    <span class="form-note d-none d-md-block">Aktif Üretim Emirleri</span></div>
                                                </div>
                                                <div class="col-lg-6 col-xxl-7  mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap ">
                                                       
                                                        
                                                        <div class="form-control " style="display:flex;     flex-direction: column;">
                                                            <?php foreach ($islemde_operasyonlar as $outgoing_invoice) { ?>
    <label style="display: flex; align-items: center;  gap: 6px;">
        <input type="checkbox"  
       disabled
             data-op_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
               data-operation_status="<?=  $outgoing_invoice['status'] ?>"
               data-islenen_miktar="<?=  number_format(($outgoing_invoice['siparis_toplam_miktar'] - $outgoing_invoice['toplam_satir_sayisi']), 2, ',', '.') ?>"
               data-siparis_miktar="<?=  number_format($outgoing_invoice['siparis_toplam_miktar'], 2, ',', '.') ?>" 
               data-row-islenen="row_marker_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
               name="operation_idsislenen[]" 
               data-sac="<?php echo $outgoing_invoice['sac']; ?>" 
               value="<?php echo $outgoing_invoice['operation_id']; ?>" 
               <?php if ($outgoing_invoice["operation_id"] == $operation) echo 'checked'; ?>>
        <strong><?php echo $outgoing_invoice["cari_invoice_title"]; ?></strong> - 
        <?php echo $outgoing_invoice['production_number']; ?> - 
        <?php echo $outgoing_invoice['stock_title']; ?>
    </label>
<?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                       <div class="bitis_sonrasi">
                                



<div class="row g-3 align-center mt-3" id="uretilen_adet_form">
                                                <div class="col-lg-3 col-xxl-3 ">
                                                    <div class="form-group"><label class="form-label" for="type_id">Üretilen Adet</label>
                                                    <span class="form-note d-none d-md-block">Lütfen Üretilen Adet Giriniz</span></div>
                                                </div>
                                                <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                                <div class="table-responsive">
    <table class="table table_islenen table-bordered">
        <thead>
            <tr>
                <th>Stok Adı</th>
                <th >Tümünü Ürettin mi?</th>
                <th>Sipariş</th>
                <th>Kalan</th>
                <th>Üretilen</th>
                <th>Aktif Kalan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($islemde_operasyonlar as $outgoing_invoice) { ?>
                <tr data-row-islenen="row_marker_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>">

                    <td>
                        <strong><?php echo $outgoing_invoice['stock_title']; ?></strong>
                        <br>
                        <small><?php echo $outgoing_invoice['production_number']; ?></small>
                    </td>
                    <td class="text-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" 
                                   class="custom-control-input tumu_kullanildi_islenen" 
                                   id="tumu_uretildi_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                                   data-op_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>">
                            <label class="custom-control-label" 
                                   for="tumu_uretildi_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>">
                            </label>
                        </div>
                    </td>
                    <td>
                        <input type="text" 
                               class="form-control siparis_toplam_adeti_islenen" 
                               id="siparis_toplam_adeti_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               value="<?=  number_format($outgoing_invoice['siparis_toplam_miktar'], 2, ',', '.') ?>" 
                               disabled>
                    </td>
                    <td>
                                <input type="text" 
                               class="form-control toplam_kalan_adet_islenen" 
                               id="toplam_kalan_adet_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               value="<?= number_format($outgoing_invoice['toplam_satir_sayisi'], 2, ',', '.') ?>" 
                               disabled>
                    </td>
                    <td>
                        <input type="text" 
                               class="form-control toplam_uretilen_adet_islenen" 
                               id="toplam_uretilen_adet_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               data-siparis_miktar="<?php echo $outgoing_invoice['toplam_miktar']; ?>"
                               value="0"
                               min="0"
                               max="<?php echo $outgoing_invoice['toplam_miktar']; ?>">
                    </td>
                  
                    <td>
                        <input type="text" 
                               class="form-control aktif_kalan_islenen" 
                               id="aktif_kalan_islenen_<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                               value="<?= number_format($outgoing_invoice['toplam_satir_sayisi'], 2, ',', '.') ?>" 
                               disabled>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<style>
.table_islenen {
    background: white;
    margin-bottom: 0;
}
.table_islenen th {
    background: #f5f6fa;
    vertical-align: middle;
    text-align: center;
}
.table_islenen td {
    vertical-align: middle;
}
.custom-control {
    min-height: 1.5rem;
    padding-left: 1.5rem;
    margin-bottom: 0;
}
.form-control:disabled {
    background-color: #f5f6fa;
}
</style>

<script>
    setTimeout(() => {
    $(document).ready(function() {
      
        // Tablo satırlarını kontrol et ve göster/gizle
        function updateTableRowsIslenen() {
            // Önce tüm satırları gizle
            $('.table_islenen tbody tr').addClass('d-none');
            
            // Seçili checkbox'ları kontrol et
            $('input[name="operation_idsislenen[]"]:checked').each(function() {
                let marker = $(this).data('row-islenen');
              
                $(`.table_islenen tbody tr[data-row-islenen="${marker}"]`).removeClass('d-none');
            });

            // Hiç seçili checkbox yoksa tüm satırları göster
            if ($('input[name="operation_idsislenen[]"]:checked').length === 0) {
                let marker = $(this).data('row-islenen');
                
             
                
                $('.table_islenen tbody tr').removeClass('d-none');
            }

        }

        // Checkbox değişiminde tabloyu güncelle
        $('body').on('change', 'input[name="operation_idsislenen[]"]', function() {
            updateTableRowsIslenen();
        });

        // Modal açıldığında ilk kontrolü yap
        $('#lazerModalDevam').on('shown.bs.modal', function() {
            // İlk yüklemede seçili checkbox'lara göre tabloyu güncelle
            setTimeout(() => {
                updateTableRowsIslenen();
            }, 100);
        });

        // Modal açıldığında ilk kontrolü yap
            $('#lazerModalDevam').on('shown.bs.modal', function() {
            updateTableRowsIslenen();
            // Sayfa yüklendiğinde tüm değerleri formatla
            $(".toplam_uretilen_adet_islenen, .toplam_kalan_adet_islenen, .aktif_kalan_islenen").each(function() {
                let value = parseFloat($(this).val()) || 0;
                $(this).val(value.toFixed(2).replace('.', ','));
            });
        });

        // Diğer event handler'lar aynı kalacak...
        $('body').on('change', '.tumu_kullanildi_islenen', function() {
            let row_id = $(this).data('op_id');
            let uretilen = $("#toplam_uretilen_adet_islenen_" + row_id);
            let kalan = $("#toplam_kalan_adet_islenen_" + row_id);
            let aktifKalan = $("#aktif_kalan_islenen_" + row_id);

            if($(this).is(":checked")) {
                let kalanMiktar = parseFloat(kalan.val().replace(',', '.')) || 0;
                uretilen.val(kalanMiktar.toFixed(2).replace('.', ','));
                aktifKalan.val('0,00');
                uretilen.prop('disabled', true);
            } else {
                uretilen.val('0,00');
                uretilen.prop('disabled', false);
                let kalanMiktar = parseFloat(kalan.val().replace(',', '.')) || 0;
                aktifKalan.val(kalanMiktar.toFixed(2).replace('.', ','));
            }
        });

        // Üretilen miktar input kontrolü
        $('body').on('keypress', '.toplam_uretilen_adet_islenen', function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $('body').on('input', '.toplam_uretilen_adet_islenen', function() {
            let $this = $(this);
            let currentValue = $this.val();
            let row_id = $this.attr('id').split('_').pop();
            let kalan = parseFloat($("#toplam_kalan_adet_islenen_" + row_id).val().replace(',', '.')) || 0;
            
            let girilenMiktar = parseInt(currentValue) || 0;
            
            if (girilenMiktar > kalan) {
                girilenMiktar = kalan;
                $this.val(kalan.toFixed(0));
                
                Swal.fire({
                    title: 'Uyarı!',
                    text: 'Kalan miktardan fazla değer giremezsiniz!',
                    icon: 'warning',
                    confirmButtonText: 'Tamam'
                });
            }

            let yeniAktifKalan = kalan - girilenMiktar;
            $("#aktif_kalan_islenen_" + row_id).val(yeniAktifKalan.toFixed(2).replace('.', ','));
        });

        // Modal kapandığında temizlik
        $('#lazerModalDevam').on('hidden.bs.modal', function() {
            $('.tumu_kullanildi_islenen').prop('checked', false);
            $('.toplam_uretilen_adet_islenen').each(function() {
                $(this).val('0').prop('disabled', false);
            });
            $('.aktif_kalan').each(function() {
                let row_id = $(this).attr('id').split('_').pop();
                let kalanDeger = $("#toplam_kalan_adet_islenen_" + row_id).val();
                $(this).val(kalanDeger);
            });
            // Tüm tablo satırlarını göster (bir sonraki açılış için)
            $('.table_islenen tbody tr').show();
        });
    });
}, 200);
</script>
                                                  
                                                </div>
                                            </div>
                                       </div>
         
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-primary" id="islemDevam">Tamamla!</button>
      </div>
    </div>
  </div>
</div>


  <?php endif; ?>


<?= $this->section('script') ?>




<script>

$('body').on('click', '.actionUl a.pause', function() {
  var urun = $(this).attr('data-product');
  var stock = $(this).attr('data-stock_title');
  var production_baslangic = $(this).attr('data-data-baslangic');
  $('#operasyon_urun').html(stock + " | İşlemini Durdur");
  $('#operationPause').attr('data-target', urun);
  $("#excuse").modal("show");

  $("#production_row_id").val('');
  $("#production_row_id").val(urun);
  $("#production_baslangic").val('');
  $("#production_baslangic").val(production_baslangic);
});

$('#operationPause').click(function(){
    var text    = $("#duraklatma").val(),
        row_id = $("#production_row_id").val();
        production_baslangic = $("#production_baslangic").val();
      
        if(text == '' || row_id == '' )
        {
            Swal.fire({
                title: 'Hata!',
                html: "Duraklatma Mesajı Boş Olamaz",
                icon: 'warning',
                confirmButtonText: 'Tamam',
                allowEscapeKey: false,
                allowOutsideClick: false,
            });

            return false;

        }

        $("#excuse").modal("hide");


        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.uretim.operationDurum') ?>',
                dataType: 'json',
                data: {
                    id: row_id,
                    text:text,
                    production_baslangic:production_baslangic,
                    operator: '<?= session()->get('user_item')['user_adsoyad'] ?>'
                },
                async: true,
                success: function (response) {
                    if (response['icon'] == 'success') {
                        
            

                        $(".durumislem_" + row_id).removeClass("pause");
                        $(".durumislem_" + row_id).addClass("play");

                        $(".kapat_" + row_id).removeClass("tamamlandi_baslat");
                        $(".kapat_" + row_id).addClass("devam_ettir");
                        $(".kapat_" + row_id).off("click").on('click', function() {
                            Swal.fire({
                                        title: 'Hata!',
                                        html: "İlk Önce Durdurulan Üretimi Devam Ettirin.",
                                        icon: 'error',
                                        confirmButtonText: 'Tamam',
                                        allowEscapeKey: false,
                                        allowOutsideClick: false,
                                    });
                                    return;
                        });

                        Swal.fire({
                            title: 'İşlem Başarılı!',
                            html: "Üretim Başarıyla Durdurudu",
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });
                        

                        
                    } else {

                        $(".durumislem_" + row_id).removeClass("play");
                        $(".durumislem_" + row_id).addClass("pause");

                        Swal.fire({
                            title: 'Hata!',
                            html: "Üretim Bulunamadı",
                            icon: 'warning',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        return false;
                    }
                }
            })


});

$('body').on('click', '.actionUl a.play', function() {
    var row_id = $(this).attr("data-p_id");
    var durdur_tarihi = $(this).attr("data-durdur_tarihi");
    Swal.fire({
    title: 'Durdurulan İşleme Devam etmek istiyormusunuz?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, Devam Et',
    cancelButtonText: 'Hayır',
    }).then((result) => {
    if (result.isConfirmed) {
   
   
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.uretim.operationDurumDevam') ?>',
                dataType: 'json',
                data: {
                    id: row_id,
                    durdur_tarihi:durdur_tarihi,
                    operator: '<?= session()->get('user_item')['user_adsoyad'] ?>'
                },
                async: true,
                success: function (response) {
                    if (response['icon'] == 'success') {


                        $('.devam_satir_log_' + row_id).removeClass('paused');
                        $('.durumislem_' + row_id).removeClass('play').addClass('pause'); 
                    
                        Swal.fire({
                            title: 'Devam',
                            icon: 'success',
                            html: 'İşleme Devam Ediliyor',
                            showCancelButton: false,
                            confirmButtonText: 'Kapat',
                        });
                        
                        var targetElement = $('[data-product="' + row_id + '"]');
                        if (targetElement.length) {
                            targetElement.removeClass('paused');
                            targetElement.find('.play').removeClass('play').addClass('pause');
                        }
                                            
                        $(".kapat_" + row_id).addClass("tamamlandi_baslat");
                        $(".kapat_" + row_id).removeClass("devam_ettir");

                        setTimeout(() => {
                            location.reload()
                        }, 1600);

                        
                    } else {

                      
                        var targetElement = $('[data-product="' + row_id + '"]');
                        if (targetElement.length) {
                            targetElement.addClass('paused');
                            targetElement.find('.pause').removeClass('pause').addClass('play');
                        }
                        Swal.fire({
                            title: 'Hata!',
                            html: "Üretim Bulunamadı",
                            icon: 'warning',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        return false;
                    }
                }
            })
   
   
   
   
    } 
    });

});

$(document).ready(function () {
   // Checkbox ve input alanlarını seçelim
const checkbox = document.getElementById('hepsini-kullandin-checkbox');
const enInput = document.getElementById('en-input');
const boyInput = document.getElementById('boy-input');

// Checkbox'a tıklama olayını dinle
checkbox.addEventListener('change', function () {
    if (checkbox.checked) {
        // Checkbox işaretliyse EN ve BOY alanlarını kilitle
        enInput.value = ''; // Değerleri sıfırla
        boyInput.value = '';
        enInput.disabled = true; // Kilitle
        boyInput.disabled = true;
    } else {
        // Checkbox işareti kaldırıldıysa EN ve BOY alanlarını serbest bırak
        enInput.disabled = false;
        boyInput.disabled = false;
    }
});

    $(".lazerModalClose").click(function(){
        $("#lazerModal").modal("hide");
        $("#lazerModalDevam").modal('hide');
    });




$(".devam_ettir").click(function(e){
    Swal.fire({
        title: 'Hata!',
        html: "İlk Önce Durdurulan Üretimi Devam Ettirin.",
        icon: 'error',
        confirmButtonText: 'Tamam',
        allowEscapeKey: false,
        allowOutsideClick: false,
    });
})




$('body').on('click', '[data-target]', function() {
    // Tıklanan nesnenin data-target özniteliğinin değerini al
    var targetValue = $(this).attr('data-target');

    // Bu değere eşleşen data-product özniteliğine sahip nesneyi bul
    var targetElement = $('[data-product="' + targetValue + '"]');

    // Eğer böyle bir nesne varsa, ona 'buldu' sınıfını ekle
    if (targetElement.length) {
        targetElement.addClass('paused');
        targetElement.find('.pause').removeClass('pause').addClass('play');
    }
});




/* 

$('#stock_quantity').on('blur', function () {
    if ($('#stock_quantity').val() != null && $('#stock_quantity').val() != '') {
        tempValue = $('#stock_quantity').val();

        if (String(tempValue).includes(",")) {
            tempValue = tempValue.replace(',', '.')
            tempValue = parseFloat(tempValue).toFixed(4)
        } else {
            tempValue = parseFloat(tempValue).toFixed(4)
        }
        tempValue = replace_for_form_input(tempValue)

        $('#stock_quantity').val(tempValue)
    } else {
        $('#stock_quantity').val('0,0000')
    }
})

$('#buy_unit_price').on('blur', function () {
    if ($('#buy_unit_price').val() != null && $('#buy_unit_price').val() != '') {
        tempValue = $('#buy_unit_price').val();

        if (String(tempValue).includes(",")) {
            tempValue = tempValue.replace(',', '.')
            tempValue = parseFloat(tempValue).toFixed(4)
        } else {
            tempValue = parseFloat(tempValue).toFixed(4)
        }
        tempValue = replace_for_form_input(tempValue)

        $('#buy_unit_price').val(tempValue)
    } else {
        $('#buy_unit_price').val('0,0000')
    }
})


*/





});



         function hesapla() {
                            var islenenMiktar = parseFloat(document.getElementById("islenen_miktar").value);
                            var siparisMiktar = parseFloat(document.getElementById("siparis_miktar").value);
                            
                            if (!isNaN(islenenMiktar) && !isNaN(siparisMiktar)) {
                                var kalanMiktar = siparisMiktar - islenenMiktar;
                                document.getElementById("kalanMiktar").value = kalanMiktar;
                            }
                        }

$(".operation_edit").click(function(){

        var id = $(this).attr("data-oprowid");

        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.uretim.getOperationRow') ?>',
                dataType: 'json',
                data: {
                    id: id,
                },
                async: true,
                success: function (response) {
                    if (response['icon'] == 'success') {

                        $("#add_user").modal("show");
                        $("#operasyonDetaylari").html('');
                        $("#operasyonDetaylari").html(response['data']);


               


                        
                    } else {

                        Swal.fire({
                            title: 'Hata!',
                            html: "Operasyon Bulunamadı",
                            icon: 'warning',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        return false;
                    }
                }
            })


});
/*

$(document).ready(function () {
    // Sayfa yüklendiğinde "En", "Boy" ve "Select" değerlerini localStorage'dan yükle
    if (localStorage.getItem("selectedEn")) {
        $("#en").val(localStorage.getItem("selectedEn"));
    }

    if (localStorage.getItem("selectedBoy")) {
        $("#boy").val(localStorage.getItem("selectedBoy"));
    }

    if (localStorage.getItem("selectedStok")) {
        $("#stok_sec").val(localStorage.getItem("selectedStok"));
    }

    // Değişikliklerde localStorage'a kaydet
    $("#en").on("input", function () {
        localStorage.setItem("selectedEn", $(this).val());
    });

    $("#boy").on("input", function () {
        localStorage.setItem("selectedBoy", $(this).val());
    });

    $("#stok_sec").on("change", function () {
        localStorage.setItem("selectedStok", $(this).val());
    });

    // Modal kapandığında temizle (isteğe bağlı)
    $("#lazerModal").on("hidden.bs.modal", function () {
        localStorage.removeItem("selectedEn");
        localStorage.removeItem("selectedBoy");
        localStorage.removeItem("selectedStok");
    });
});


// Tüm form elemanlarını localStorage'a kaydet ve geri yükle
function manageLocalStorage(element, key) {
    if (localStorage.getItem(key)) {
        $(element).val(localStorage.getItem(key));
    }
    $(element).on("input change", function () {
        localStorage.setItem(key, $(this).val());
    });
}

// Kullanım
$(document).ready(function () {
    manageLocalStorage("#en", "selectedEn");
    manageLocalStorage("#boy", "selectedBoy");
    manageLocalStorage("#stok_sec", "selectedStok");

    // Modal kapandığında temizle
    $("#lazerModal").on("hidden.bs.modal", function () {
        localStorage.removeItem("selectedEn");
        localStorage.removeItem("selectedBoy");
        localStorage.removeItem("selectedStok");
    });
});
*/




$(".bekeleyen_baslat").click(function(){

<?php if ($operation == 16) { ?>
   

    -
        // Modalı göster
        $("#lazerModal").modal("show");

        // Modal içindeki Başlat butonuna tıklanınca
        $("#islemBaslat").click(function () {
            // Seçilen checkbox değerlerini topla


        $("#siparis_toplam_adeti").val($(this).data("siparis_miktar"));
            $("#toplam_uretilen_adet").val(0);
          
           
                $("#toplam_kalan_adet").val(parseInt($(this).data("siparis_miktar")) - parseInt($(this).data("islenen_miktar") ?? 0));
     

        $("#toplam_uretilen_adet").keyup(function(){
            let siparisMiktar = parseInt($(this).data("siparis_miktar"));
            let girilenMiktar = parseInt($(this).val()) || 0; // Eğer geçersiz bir değer girilirse 0 olarak al

            // Miktar kontrolü
            if (girilenMiktar < 0) {
                girilenMiktar = 0;
                $(this).val(0);
            } else if (girilenMiktar > siparisMiktar) {
                girilenMiktar = siparisMiktar;
                $(this).val(siparisMiktar);
            }

            // Kalan adeti hesapla
            $("#toplam_kalan_adet").val(siparisMiktar - girilenMiktar);
        });

        $("#toplam_uretilen_adet").attr({
            "min": 0,
            "max": parseInt($(this).data("siparis_miktar"))
        });

           
            var selectedOperations = [];
            var selectedStock = $("#stok_sec").val(); // Seçilen sacın ID'sini al

            var saclar = [];
    $("#stok_sec option:selected").each(function() {
        saclar.push({
            id: $(this).val(),
            text: $(this).text()
        });
       
    });

    
       
            if (!selectedStock || selectedStock.length === 0) {
                    // Select2'ye hata stili ekle
                    $("#stok_sec").addClass('is-invalid');
                    
                    // Varsa eski hata mesajını kaldır
                    $('#sac-error').remove();
                    
                    // Hata mesajı ekle
                    $("#stok_sec").before('<div id="sac-error" class="invalid-feedback" style="display:block">Lütfen en az bir sac seçiniz!</div>');
                    
                    // SweetAlert ile uyarı göster
                    Swal.fire({
                        title: "Uyarı!",
                        text: "Lütfen en az bir sac seçiniz!",
                        icon: "warning",
                        confirmButtonText: "Tamam",
                        allowOutsideClick: false
                    });
                    
                    return false;
                }


                var hasError = false;
                var selectedOperations = [];

    $('tr[data-row-marker]:not(.d-none) .toplam_uretilen_adet').each(function() {
        var uretilen = $(this).val();
        if (!uretilen || uretilen === '0' || uretilen === '0,00') {
            $(this).addClass('is-invalid');
            // Varsa eski hata mesajını kaldır
            $(this).next('.invalid-feedback').remove();
            // Hata mesajı ekle
            $(this).after('<div class="invalid-feedback" style="display: block; font-size: 9.8px !important; font-family: monospace; font-weight: bold;"> girilmesi zorunludur!</div>');
            hasError = true;
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });

    if (hasError) {
        Swal.fire({
            title: "Uyarı!",
            text: "Lütfen üretilen adet değerlerini giriniz!",
            icon: "warning",
            confirmButtonText: "Tamam",
            allowOutsideClick: false
        });
        return false;
    }


                $("#lazerModal").modal("hide");
     
            $("input[name='operation_ids[]']:checked").each(function () {
        var opId = $(this).data("op_id");
        var uretimData = {
            lazer: 1,
            operation_id: $(this).val(),
            production_row_operation_id: opId,
            operation_status: $(this).data("operation_status"),
            siparis_miktar: $(this).data("siparis_miktar"),
            uretilen_miktar: $("#toplam_uretilen_adet_" + opId).val(),
            kalan_miktar: $("#toplam_kalan_adet_" + opId).val(),
            aktif_kalan: $("#aktif_kalan_" + opId).val(),
            tumu_kullanildi: $("#tumu_kullanildi_" + opId).is(":checked"),
            tumu_uretildi: $("#tumu_uretildi_" + opId).is(":checked"),
            stok_adi: $(this).closest('tr').find('td:first').text().trim(),
            saclar: saclar
        };
    
        selectedOperations.push(uretimData);

        // Üretilen adet kontrolü
        if (!uretimData.uretilen_miktar || uretimData.uretilen_miktar === '0' || uretimData.uretilen_miktar === '0,00') {
            $("#toplam_uretilen_adet_" + opId).addClass('is-invalid');
            hasError = true;
        }
    });

 



      
            if (selectedOperations.length > 0) {
                selectedOperations.forEach(function (operationData, index) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                        },
                        type: 'POST',
                        url: '<?= route_to("tportal.uretim.getOperationRowislemLazer") ?>',
                        dataType: 'json',
                        data: operationData,
                        success: function (response) {
                            if (response.icon === "success") {
                                console.log(`Operation ${operationData.id} başarıyla işlendi.`);
                                
                                if (index === selectedOperations.length - 1) {
                                    Swal.fire({
                                        title: "Başarılı!",
                                        text: "Tüm işlemler başarıyla tamamlandı.",
                                        icon: "success",
                                        confirmButtonText: "Tamam",
                                        allowOutsideClick: false
                                    }).then(function () {
                                        location.reload();
                                    });
                                }
                            } else {
                                console.error(`Operation ${operationData.id} sırasında hata oluştu: ${response.message}`);
                            }
                        },
                        error: function () {
                            console.error(`Operation ${operationData.id} sırasında AJAX hatası oluştu.`);
                        }
                    });
                });
            } else {
                Swal.fire({
                    title: "Uyarı!",
                    text: "Lütfen en az bir işlem seçiniz.",
                    icon: "warning",
                    confirmButtonText: "Tamam",
                    allowOutsideClick: false
                });
            }
        });
// Üretilen adet input kontrolü
$('body').on('input', '.toplam_uretilen_adet', function() {
    var value = $(this).val();
    if (value && value !== '0' && value !== '0,00') {
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
    }
});

// Modal açıldığında hata mesajlarını temizle
$('#lazerModal').on('shown.bs.modal', function() {
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
});

<?php }else{ ?>
    
    $("#tumOperasyonlarBekleyen").modal("show");

    var islem_id = $(this).attr("data-islem_id");
    console.log("Seçilen işlem ID:", islem_id);

// Önce tüm checkboxları kontrol edelim
$('input[name="operation_default_ids[][]"]').each(function() {
    var currentId = $(this).data("op_id");
    if(currentId != islem_id) {
        // Checkbox'ı ve label'ı tamamen kaldır
        $(this).prop('checked', false);
        $(this).closest('label').hide();
        // İlgili satırı tamamen kaldır
        $(`.table_default_bekleyen tbody tr[data-row-default="row_marker_default_${islem_id}"]`).addClass('d-none');
    } else {
        // Seçili olanı göster
        $(this).closest('label').show();
        $(`.table_default_bekleyen tbody tr[data-row-default="row_marker_default_${islem_id}"]`).removeClass('d-none');
    }
});







    $(".operasyonBekleyen").click(function(){



      
        $("#siparis_toplam_adeti_default").val($(this).data("siparis_miktar"));
            $("#toplam_uretilen_adet_default").val(0);
          
           
                $("#toplam_kalan_adet_default").val(parseInt($(this).data("siparis_miktar")) - parseInt($(this).data("islenen_miktar") ?? 0));
     

        $("#toplam_uretilen_adet_default").keyup(function(){
            let siparisMiktar = parseInt($(this).data("siparis_miktar"));
            let girilenMiktar = parseInt($(this).val()) || 0; // Eğer geçersiz bir değer girilirse 0 olarak al

            // Miktar kontrolü
            if (girilenMiktar < 0) {
                girilenMiktar = 0;
                $(this).val(0);
            } else if (girilenMiktar > siparisMiktar) {
                girilenMiktar = siparisMiktar;
                $(this).val(siparisMiktar);
            }

            // Kalan adeti hesapla
            $("#toplam_kalan_adet_default").val(siparisMiktar - girilenMiktar);
        });

        $("#toplam_uretilen_adet_default").attr({
            "min": 0,
            "max": parseInt($(this).data("siparis_miktar"))
        });

           
            var selectedOperations = [];
          

        

                var hasError = false;
                var selectedOperations = [];

    $('tr[data-row-default]:not(.d-none) .toplam_uretilen_adet_default').each(function() {
        var uretilen = $(this).val();
        if (!uretilen || uretilen === '0' || uretilen === '0,00') {
            $(this).addClass('is-invalid');
            // Varsa eski hata mesajını kaldır
            $(this).next('.invalid-feedback').remove();
            // Hata mesajı ekle
            $(this).after('<div class="invalid-feedback" style="display: block; font-size: 9.8px !important; font-family: monospace; font-weight: bold;"> girilmesi zorunludur!</div>');
            hasError = true;
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });

    if (hasError) {
        Swal.fire({
            title: "Uyarı!",
            text: "Lütfen üretilen adet değerlerini giriniz!",
            icon: "warning",
            confirmButtonText: "Tamam",
            allowOutsideClick: false
        });
        return false;
    }


                $("#lazerModal").modal("hide");
     
            $("input[name='operation_default_ids[]']:checked").each(function () {
        var opId = $(this).data("op_id");
        var uretimData = {
            lazer: 1,
            operation_id: $(this).val(),
            production_row_operation_id: opId,
            operation_status: $(this).data("operation_status"),
            siparis_miktar: $(this).data("siparis_miktar"),
            uretilen_miktar: $("#toplam_uretilen_adet_default_" + opId).val(),
            kalan_miktar: $("#toplam_kalan_adet_default_" + opId).val(),
            aktif_kalan: $("#aktif_kalan_default_" + opId).val(),
            tumu_uretildi: $("#tumu_uretildi_default" + opId).is(":checked"),
            stok_adi: $(this).closest('tr').find('td:first').text().trim(),
            saclar: 0
        };
    
        selectedOperations.push(uretimData);

        // Üretilen adet kontrolü
        if (!uretimData.uretilen_miktar || uretimData.uretilen_miktar === '0' || uretimData.uretilen_miktar === '0,00') {
            $("#toplam_uretilen_adet_default").addClass('is-invalid');
            hasError = true;
        }
    });





    if (selectedOperations.length > 0) {
                selectedOperations.forEach(function (operationData, index) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                        },
                        type: 'POST',
                        url: '<?= route_to("tportal.uretim.getOperationRowislem") ?>',
                        dataType: 'json',
                        data: operationData,
                        success: function (response) {
                            if (response.icon === "success") {
                                console.log(`Operation ${operationData.id} başarıyla işlendi.`);
                                
                                if (index === selectedOperations.length - 1) {
                                    Swal.fire({
                                        title: "Başarılı!",
                                        text: "Tüm işlemler başarıyla tamamlandı.",
                                        icon: "success",
                                        confirmButtonText: "Tamam",
                                        allowOutsideClick: false
                                    }).then(function () {
                                        location.reload();
                                    });
                                }
                            } else {
                                console.error(`Operation ${operationData.id} sırasında hata oluştu: ${response.message}`);
                            }
                        },
                        error: function () {
                            console.error(`Operation ${operationData.id} sırasında AJAX hatası oluştu.`);
                        }
                    });
                });
            } else {
                Swal.fire({
                    title: "Uyarı!",
                    text: "Lütfen en az bir işlem seçiniz.",
                    icon: "warning",
                    confirmButtonText: "Tamam",
                    allowOutsideClick: false
                });
            }



       /* 
    var id = $(this).attr("data-op_id");
  var operation_status = $(this).attr("operation_status");
  var islenen_miktar = $(this).attr("data-islenen_miktar");
  var siparis_miktar = $(this).attr("data-siparis_miktar");



 var islenenMiktar = parseFloat(islenen_miktar);
  var siparisMiktar = parseFloat(siparis_miktar);
  <?php if($operation_title == "Paketleme"){ ?>
 if(islenenMiktar == siparisMiktar){
     var sonislem = 1;
 }else{
   var sonislem = 0;
 }
 <?php }else{ ?>
   var sonislem = 0;
 <?php } ?>


     $.ajax({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
             },
             type: 'POST',
             url: '<?= route_to('tportal.uretim.getOperationRowislem') ?>',
             dataType: 'json',
             data: {
                 id: id,
                 sonislem: sonislem,
                 operation_status: operation_status,
                 islenen_miktar: islenen_miktar,
                 operator: '<?= session()->get('user_item')['user_adsoyad'] ?>'

             },
             async: true,
             success: function (response) {
                 if (response['icon'] == 'success') {

                  if (response.all_barcode) {

                     Swal.fire({
                         title: 'Başarılı!',
                         html: "İşleminiz Başarıyla Kaydedildi",
                         icon: 'success',
                         confirmButtonText: 'Tamam',
                         allowEscapeKey: false,
                         allowOutsideClick: false,
                     }).then(function () {
                         location.reload();
                     });

                     if(islenen_miktar > 0){

                           Swal.fire({
                             title: 'Başarılı!',
                             html: "Stok Girişi Olarak Eklendi. Barkod Yazdırılıyor Lütfen Bekleyiniz..",
                             icon: 'success',
                             allowEscapeKey: false,
                             allowOutsideClick: false,
                         });

                         function printContent(content) {
                               var w = window.open('', '_blank');

                               for (let index = 0; index < content.length; index++) {
                                   w.document.write(content[index]);
                               }

                               setTimeout(function () {
                                   w.print();
                                   // w.close();
                               }, 1600);
                           }


                         setTimeout(function () {
                             printContent(response.all_barcode);
                         }, 1600);


                         $("#add_user").modal("hide");
                     }

                     

                   }else{ 

                     Swal.fire({
                         title: 'Başarılı!',
                         html: "İşleminiz Başarıyla Kaydedildi",
                         icon: 'success',
                         confirmButtonText: 'Tamam',
                         allowEscapeKey: false,
                         allowOutsideClick: false,
                     }).then(function () {
                         location.reload();
                     });
                     } 
                     
                 } else {

                     Swal.fire({
                         title: 'Hata!',
                         html: "Operasyon Bulunamadı",
                         icon: 'warning',
                         confirmButtonText: 'Tamam',
                         allowEscapeKey: false,
                         allowOutsideClick: false,
                     });

                     return false;
                 }
             }
         })    */
    });
<?php } ?>
  


});


$(".tamamlandi_baslat").click(function(){



    <?php if ($operation == 16) { ?>

        // Modalı göster
        $("#lazerModalDevam").modal("show");

        var sacDegeri = $(this).data("sac");
var saclar = typeof sacDegeri === 'string' && sacDegeri.includes(',') ? 
             sacDegeri.split(',') : 
             [sacDegeri.toString()];

$("#islem_stok").val(saclar);
$("#islem_stok").prop("disabled", true);
$("#islem_stok").trigger("change");

$("input[name='operation_idsislenen[]']").each(function() {
    $(this).closest('label').show();
    $(this).prop('checked', true);
});

var selectedStocks = $("#islem_stok").val();

$("input[name='operation_idsislenen[]']:checked").each(function () {
    var checkboxSacDegeri = $(this).data("sac");
    var opSaclar = typeof checkboxSacDegeri === 'string' && checkboxSacDegeri.includes(',') ? 
                   checkboxSacDegeri.split(',') : 
                   [checkboxSacDegeri.toString()];
    
    // Kesişim kontrolü
    var kesisimVar = opSaclar.some(sac => selectedStocks.includes(sac));
    
    if(!kesisimVar) {
        $(this).prop('checked', false);
        $(this).closest('label').hide();
    }
});
var islem_id = $(this).attr("data-islem_id");
console.log("Seçilen işlem ID:", islem_id);

// Önce tüm checkboxları kontrol edelim
$('input[name="operation_idsislenen[]"]').each(function() {
    var currentId = $(this).data("op_id");
    if(currentId != islem_id) {
        // Checkbox'ı ve label'ı tamamen kaldır
        $(this).prop('checked', false);
        $(this).closest('label').hide();
        // İlgili satırı tamamen kaldır
        $(`.table_islenen tbody tr[data-row-islenen="row_marker_islenen_${islem_id}"]`).addClass('d-none');
    } else {
        // Seçili olanı göster
        $(this).closest('label').show();
        $(`.table_islenen tbody tr[data-row-islenen="row_marker_islenen_${islem_id}"]`).removeClass('d-none');
    }
});


           
    $("#islem_stok option:selected").each(function() {

        $("#sac_0").append('<option value="'+$(this).val()+'" selected>'+$(this).text()+'</option>');
    });


// Modal içindeki Başlat butonuna tıklanınca
$("#islemDevam").click(function () {

    // Modalı kapat
   
    // Sac seçimi kontrolü
    /*var selectedStock = $("#islem_stok").val();
     $("#lazerModalDevam").modal("hide");
    if (!selectedStock) {
        $("#lazerModalDevam").modal("show");
        Swal.fire({
            title: "Uyarı!",
            text: "Lütfen bir sac seçiniz.",
            icon: "warning",
            confirmButtonText: "Tamam",
            allowOutsideClick: false
        });
        return;
            // Modalı kapat

    }

    // En-Boy ve Kullanım durumu bilgilerini al
    var enValue = $("#en-input").val();
    var boyValue = $("#boy-input").val();
    var tumuKullanildi = $("#hepsini-kullandin-checkbox").is(":checked");

    // En-Boy kontrolü (eğer tümü kullanılmadıysa)
    if (!tumuKullanildi && (!enValue || !boyValue)) {
        $("#lazerModalDevam").modal("show");
        Swal.fire({
            title: "Uyarı!",
            text: "Lütfen kalan sac için en ve boy değerlerini giriniz.",
            icon: "warning",
            confirmButtonText: "Tamam",
            allowOutsideClick: false
        });
        return;
    } */



    $("#siparis_toplam_adeti_islenen").val($(this).data("siparis_miktar"));
            $("#toplam_uretilen_adet_islenen").val(0);
          
           
                $("#toplam_kalan_adet_islenen").val(parseInt($(this).data("siparis_miktar")) - parseInt($(this).data("islenen_miktar") ?? 0));
     

        $("#toplam_uretilen_adet_islenen").keyup(function(){
            let siparisMiktar = parseInt($(this).data("siparis_miktar"));
            let girilenMiktar = parseInt($(this).val()) || 0; // Eğer geçersiz bir değer girilirse 0 olarak al

            // Miktar kontrolü
            if (girilenMiktar < 0) {
                girilenMiktar = 0;
                $(this).val(0);
            } else if (girilenMiktar > siparisMiktar) {
                girilenMiktar = siparisMiktar;
                $(this).val(siparisMiktar);
            }

            // Kalan adeti hesapla
            $("#toplam_kalan_adet_islenen").val(siparisMiktar - girilenMiktar);
        });

        $("#toplam_uretilen_adet_islenen").attr({
            "min": 0,
            "max": parseInt($(this).data("siparis_miktar"))
        });

           
            var selectedOperations_islenen = [];
            var selectedStock = $("#islem_stok").val(); // Seçilen sacın ID'sini al

            var saclar = [];
    $("#islem_stok option:selected").each(function() {
        console.log($(this).val());
        saclar.push({
            id: $(this).val(),
            text: $(this).text()
        });
        $("#sac_0").append('<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
    });
       
            if (!selectedStock || selectedStock.length === 0) {
                    // Select2'ye hata stili ekle
                    $("#islem_stok").addClass('is-invalid');
                    
                    // Varsa eski hata mesajını kaldır
                    $('#sac-error').remove();
                    
                    // Hata mesajı ekle
                    $("#islem_stok").before('<div id="sac-error" class="invalid-feedback" style="display:block">Lütfen en az bir sac seçiniz!</div>');
                    
                    // SweetAlert ile uyarı göster
                    Swal.fire({
                        title: "Uyarı!",
                        text: "Lütfen en az bir sac seçiniz!",
                        icon: "warning",
                        confirmButtonText: "Tamam",
                        allowOutsideClick: false
                    });
                    
                    return false;
                }


                var hasError = false;
                var selectedOperations = [];

    $('tr[data-row-islenen]:not(.d-none) .toplam_uretilen_adet_islenen').each(function() {
        var uretilen = $(this).val();
        if (!uretilen || uretilen === '0' || uretilen === '0,00') {
            $(this).addClass('is-invalid');
            // Varsa eski hata mesajını kaldır
            $(this).next('.invalid-feedback').remove();
            // Hata mesajı ekle
            $(this).after('<div class="invalid-feedback" style="display: block; font-size: 9.8px !important; font-family: monospace; font-weight: bold;"> girilmesi zorunludur!</div>');
            hasError = true;
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });

    if (hasError) {
        Swal.fire({
            title: "Uyarı!",
            text: "Lütfen üretilen adet değerlerini giriniz!",
            icon: "warning",
            confirmButtonText: "Tamam",
            allowOutsideClick: false
        });
        return false;
    }

  // Tüm en ve boy değerlerini alalım
var enValues = [];
var boyValues = [];

$("input[name='en[]']").each(function() {
    enValues.push($(this).val());
});

$("input[name='boy[]']").each(function() {
    boyValues.push($(this).val());
});

var tumuKullanildi = $("#hepsini-kullandin-checkbox").is(":checked");

// En az bir en-boy çifti girilmiş mi kontrolü
if(!tumuKullanildi && (!enValues[0] || !boyValues[0])){
    $("#lazerModalDevam").modal("show");
    Swal.fire({
        title: "Uyarı!",
        text: "Lütfen kalan sac için en ve boy değerlerini giriniz.",
        icon: "warning",
        confirmButtonText: "Tamam",
        allowOutsideClick: false
    });
    return;
}

var enBoy = [];

// En-boy çiftlerini birleştir
for(let i = 0; i < enValues.length; i++) {
    if(enValues[i] && boyValues[i]) { // Boş değer kontrolü
        enBoy.push({
            en: enValues[i],
            boy: boyValues[i]
        });
    }
}




                $("#lazerModalDevam").modal("hide");
     
            $("input[name='operation_idsislenen[]']:checked").each(function () {
        var opId = $(this).data("op_id");
        var uretimData = {
            lazer: 1,
            enBoy:enBoy,
            operation_id: $(this).val(),
            production_row_operation_id: opId,
            operation_status: $(this).data("operation_status"),
            siparis_miktar: $(this).data("siparis_miktar"),
            uretilen_miktar: $("#toplam_uretilen_adet_islenen_" + opId).val(),
            kalan_miktar: $("#toplam_kalan_adet_islenen_" + opId).val(),
            aktif_kalan: $("#aktif_kalan_islenen_" + opId).val(),
            tumu_kullanildi: $("#tumu_kullanildi_islenen_" + opId).is(":checked"),
            tumu_uretildi: $("#tumu_uretildi_islenen_" + opId).is(":checked"),
            stok_adi: $(this).closest('tr').find('td:first').text().trim(),
            saclar: saclar
        };
    
        selectedOperations_islenen.push(uretimData);

        // Üretilen adet kontrolü
        if (!uretimData.uretilen_miktar || uretimData.uretilen_miktar === '0' || uretimData.uretilen_miktar === '0,00') {
            $("#toplam_uretilen_adet_islenen_" + opId).addClass('is-invalid');
            hasError = true;
        }
    });



    // Seçilen checkbox değerlerini topla

    var uyumsuzSaclar = false;


  

    if (selectedOperations_islenen.length > 0) {
        selectedOperations_islenen.forEach(function (operationData, index) {
        console.log("İŞLEM DEVAM!");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                <?php if($operation == 16): ?>
                url: '<?= route_to("tportal.uretim.getOperationRowislemLazerTamamla") ?>',
                <?php else: ?>
                url: '<?= route_to("tportal.uretim.getOperationRowislem") ?>',
                <?php endif; ?>
                dataType: 'json',
                data: operationData,
                success: function (response) {
                    if (response.icon === "success") {
                        console.log(`Operation ${operationData.id} başarıyla işlendi.`);
                        
                        if (index === selectedOperations_islenen.length - 1) {
                            Swal.fire({
                                title: "Başarılı!",
                                text: "Tüm işlemler başarıyla tamamlandı.",
                                icon: "success",
                                confirmButtonText: "Tamam",
                                allowOutsideClick: false
                            }).then(function () {
                                location.reload();
                            });
                        }
                    } else {
                        console.error(`Operation ${operationData.id} sırasında hata oluştu: ${response.message}`);
                    }
                },
                error: function () {
                    console.error(`Operation ${operationData.id} sırasında AJAX hatası oluştu.`);
                }
            });
        });
    } else {
        $("#lazerModalDevam").modal("show");
        Swal.fire({
            title: "Uyarı!",
            text: "Lütfen en az bir işlem seçiniz.",
            icon: "warning",
            confirmButtonText: "Tamam",
            allowOutsideClick: false
        });
    }
});

<?php }else{ ?>

    $("#tumOperasyonlarDevam").modal("show");




$("input[name='operation_idsislenen[]']").each(function() {
$(this).closest('label').show();
$(this).prop('checked', true);
});

$("input[name='operation_idsislenen[]']:checked").each(function () {
var checkboxSacDegeri = $(this).data("sac");
var opSaclar = typeof checkboxSacDegeri === 'string' && checkboxSacDegeri.includes(',') ? 
           checkboxSacDegeri.split(',') : 
           [checkboxSacDegeri.toString()];
        });
// Kesişim kontrolü

var islem_id = $(this).attr("data-islem_id");
console.log("Seçilen işlem ID:", islem_id);

// Önce tüm checkboxları kontrol edelim
$('input[name="operation_idsislenen[]"]').each(function() {
var currentId = $(this).data("op_id");
if(currentId != islem_id) {
// Checkbox'ı ve label'ı tamamen kaldır
$(this).prop('checked', false);
$(this).closest('label').hide();
// İlgili satırı tamamen kaldır
$(`.table_islenen tbody tr[data-row-islenen="row_marker_islenen_${islem_id}"]`).addClass('d-none');
} else {
// Seçili olanı göster
$(this).closest('label').show();
$(`.table_islenen tbody tr[data-row-islenen="row_marker_islenen_${islem_id}"]`).removeClass('d-none');
}
});








// Modal içindeki Başlat butonuna tıklanınca
$("#islemDevam").click(function () {

// Modalı kapat

// Sac seçimi kontrolü
/*var selectedStock = $("#islem_stok").val();
 $("#lazerModalDevam").modal("hide");
if (!selectedStock) {
    $("#lazerModalDevam").modal("show");
    Swal.fire({
        title: "Uyarı!",
        text: "Lütfen bir sac seçiniz.",
        icon: "warning",
        confirmButtonText: "Tamam",
        allowOutsideClick: false
    });
    return;
        // Modalı kapat

}

// En-Boy ve Kullanım durumu bilgilerini al
var enValue = $("#en-input").val();
var boyValue = $("#boy-input").val();
var tumuKullanildi = $("#hepsini-kullandin-checkbox").is(":checked");

// En-Boy kontrolü (eğer tümü kullanılmadıysa)
if (!tumuKullanildi && (!enValue || !boyValue)) {
    $("#lazerModalDevam").modal("show");
    Swal.fire({
        title: "Uyarı!",
        text: "Lütfen kalan sac için en ve boy değerlerini giriniz.",
        icon: "warning",
        confirmButtonText: "Tamam",
        allowOutsideClick: false
    });
    return;
} */



$("#siparis_toplam_adeti_islenen").val($(this).data("siparis_miktar"));
        $("#toplam_uretilen_adet_islenen").val(0);
      
       
            $("#toplam_kalan_adet_islenen").val(parseInt($(this).data("siparis_miktar")) - parseInt($(this).data("islenen_miktar") ?? 0));
 

    $("#toplam_uretilen_adet_islenen").keyup(function(){
        let siparisMiktar = parseInt($(this).data("siparis_miktar"));
        let girilenMiktar = parseInt($(this).val()) || 0; // Eğer geçersiz bir değer girilirse 0 olarak al

        // Miktar kontrolü
        if (girilenMiktar < 0) {
            girilenMiktar = 0;
            $(this).val(0);
        } else if (girilenMiktar > siparisMiktar) {
            girilenMiktar = siparisMiktar;
            $(this).val(siparisMiktar);
        }

        // Kalan adeti hesapla
        $("#toplam_kalan_adet_islenen").val(siparisMiktar - girilenMiktar);
    });

    $("#toplam_uretilen_adet_islenen").attr({
        "min": 0,
        "max": parseInt($(this).data("siparis_miktar"))
    });

       
     
    


            var hasError = false;
            var selectedOperations_islenen = [];

$('tr[data-row-islenen]:not(.d-none) .toplam_uretilen_adet_islenen').each(function() {
    var uretilen = $(this).val();
    if (!uretilen || uretilen === '0' || uretilen === '0,00') {
        $(this).addClass('is-invalid');
        // Varsa eski hata mesajını kaldır
        $(this).next('.invalid-feedback').remove();
        // Hata mesajı ekle
        $(this).after('<div class="invalid-feedback" style="display: block; font-size: 9.8px !important; font-family: monospace; font-weight: bold;"> girilmesi zorunludur!</div>');
        hasError = true;
    } else {
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
    }
});

if (hasError) {
    Swal.fire({
        title: "Uyarı!",
        text: "Lütfen üretilen adet değerlerini giriniz!",
        icon: "warning",
        confirmButtonText: "Tamam",
        allowOutsideClick: false
    });
    return false;
}






            $("#lazerModalDevam").modal("hide");
 
        $("input[name='operation_idsislenen[]']:checked").each(function () {
    var opId = $(this).data("op_id");
    var uretimData = {
        lazer: 1,
        enBoy:null,
        operation_id: $(this).val(),
        production_row_operation_id: opId,
        operation_status: $(this).data("operation_status"),
        siparis_miktar: $(this).data("siparis_miktar"),
        uretilen_miktar: $("#toplam_uretilen_adet_islenen_" + opId).val(),
        kalan_miktar: $("#toplam_kalan_adet_islenen_" + opId).val(),
        aktif_kalan: $("#aktif_kalan_islenen_" + opId).val(),
        tumu_kullanildi: 0,
        tumu_uretildi: $("#tumu_uretildi_islenen_" + opId).is(":checked"),
        stok_adi: $(this).closest('tr').find('td:first').text().trim(),
        saclar: 0
    };

    selectedOperations_islenen.push(uretimData);

    // Üretilen adet kontrolü
    if (!uretimData.uretilen_miktar || uretimData.uretilen_miktar === '0' || uretimData.uretilen_miktar === '0,00') {
        $("#toplam_uretilen_adet_islenen_" + opId).addClass('is-invalid');
        hasError = true;
    }
});



// Seçilen checkbox değerlerini topla

var uyumsuzSaclar = false;




if (selectedOperations_islenen.length > 0) {
    selectedOperations_islenen.forEach(function (operationData, index) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to("tportal.uretim.getOperationRowislemGenelTamamla") ?>',
            dataType: 'json',
            data: operationData,
            success: function (response) {
                if (response.icon === "success") {
                    console.log(`Operation ${operationData.id} başarıyla işlendi.`);
                    
                    if (index === selectedOperations_islenen.length - 1) {
                        if (response.all_barcode) {
                            stokUret = 1;

                                        if(stokUret > 0){

                                            Swal.fire({
                                                title: 'Başarılı!',
                                                html: "Stok Girişi Olarak Eklendi. Barkod Yazdırılıyor Lütfen Bekleyiniz..",
                                                icon: 'success',
                                                allowEscapeKey: false,
                                                allowOutsideClick: false,
                                            });

                                            function printContent(content) {
                                                var w = window.open('', '_blank');

                                                for (let index = 0; index < content.length; index++) {
                                                    w.document.write(content[index]);
                                                }

                                                setTimeout(function () {
                                                    w.print();
                                                    // w.close();
                                                }, 1600);
                                            }


                                            setTimeout(function () {
                                                printContent(response.all_barcode);
                                            }, 1600);


                                            $("#add_user").modal("hide");
                                        }



                                        }else{ 

                                        Swal.fire({
                                            title: 'Başarılı!',
                                            html: "İşleminiz Başarıyla Kaydedildi",
                                            icon: 'success',
                                            confirmButtonText: 'Tamam',
                                            allowEscapeKey: false,
                                            allowOutsideClick: false,
                                        }).then(function () {
                                            location.reload();
                                        });
                                        } 
                 
                    }
                } else {
                    console.error(`Operation ${operationData.id} sırasında hata oluştu: ${response.message}`);
                }
            },
            error: function () {
                console.error(`Operation ${operationData.id} sırasında AJAX hatası oluştu.`);
            }
        });
    });
} else {
    $("#lazerModalDevam").modal("show");
    Swal.fire({
        title: "Uyarı!",
        text: "Lütfen en az bir işlem seçiniz.",
        icon: "warning",
        confirmButtonText: "Tamam",
        allowOutsideClick: false
    });
}
});


       

<?php } ?>
});


$("#operationEdit").click(function(){

   var id = $("#op_id").val(),
    operation_status = $("#operation_status").val(),
    islenen_miktar = $("#islenen_miktar").val(),
    siparis_miktar = $("#siparis_miktar").val();


    var islenenMiktar = parseFloat(document.getElementById("islenen_miktar").value);
     var siparisMiktar = parseFloat(document.getElementById("siparis_miktar").value);
     <?php if($operation_title == "Paketleme"){ ?>
    if(islenenMiktar == siparisMiktar){
        var sonislem = 1;
    }else{
      var sonislem = 0;
    }
    <?php }else{ ?>
      var sonislem = 0;
    <?php } ?>

    if(islenen_miktar > siparis_miktar){
        Swal.fire({
                            title: 'Hata!',
                            html: "İşlenen Miktar Sipariş Miktarından Fazla Olamaz.",
                            icon: 'warning',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });
               
    }

        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.uretim.getOperationRowislem') ?>',
                dataType: 'json',
                data: {
                    id: id,
                    sonislem: sonislem,
                    operation_status: operation_status,
                    islenen_miktar: islenen_miktar,
                    operator: '<?= session()->get('user_item')['user_adsoyad'] ?>'

                },
                async: true,
                success: function (response) {
                    if (response['icon'] == 'success') {

                      <?php if($operation_title == "Paketleme"){ ?>

                        Swal.fire({
                            title: 'Başarılı!',
                            html: "İşleminiz Başarıyla Kaydedildi",
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then(function () {
                            location.reload();
                        });

                        if(islenen_miktar > 0){

                              Swal.fire({
                                title: 'Başarılı!',
                                html: "Stok Girişi Olarak Eklendi. Barkod Yazdırılıyor Lütfen Bekleyiniz..",
                                icon: 'success',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                            });

                            function printContent(content) {
                                  var w = window.open('', '_blank');

                                  for (let index = 0; index < content.length; index++) {
                                      w.document.write(content[index]);
                                  }

                                  setTimeout(function () {
                                      w.print();
                                      // w.close();
                                  }, 1600);
                              }


                            setTimeout(function () {
                                printContent(response.all_barcode);
                            }, 1600);


                            $("#add_user").modal("hide");
                        }

                        

                      <?php }else{ ?>

                        Swal.fire({
                            title: 'Başarılı!',
                            html: "İşleminiz Başarıyla Kaydedildi",
                            icon: 'success',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then(function () {
                            location.reload();
                        });
                        <?php } ?>
                        
                    } else {

                        Swal.fire({
                            title: 'Hata!',
                            html: "Operasyon Bulunamadı",
                            icon: 'warning',
                            confirmButtonText: 'Tamam',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        });

                        return false;
                    }
                }
            })


});



  var orderOverview = {
    labels: ["Ağustos", "Eylül", "Ekim", "Kasım", "Aralık", "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz"],
    dataUnit: 'TL',
    datasets: [{
      label: "Gider",
      color: "#F2426E",
      data: [18200, 12000, 16000, 25000, 18200, 14400, 17000, 18200, 14000, 21000, 11000, 660]
    }, {
      label: "Gelir",
      color: "#035cff",
      data: [30000, 34500, 24500, 18200, 27000, 48700, 24700, 26000, 40000, 23800, 21000, 4000]
    }]
  };
  function orderOverviewChart(selector, set_data) {
    var $selector = selector ? $(selector) : $('.order-overview-chart');
    $selector.each(function () {
      var $self = $(this),
        _self_id = $self.attr('id'),
        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
        _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;
      var selectCanvas = document.getElementById(_self_id).getContext("2d");
      var chart_data = [];
      for (var i = 0; i < _get_data.datasets.length; i++) {
        chart_data.push({
          label: _get_data.datasets[i].label,
          data: _get_data.datasets[i].data,
          // Styles
          backgroundColor: _get_data.datasets[i].color,
          borderWidth: 2,
          borderColor: 'transparent',
          hoverBorderColor: 'transparent',
          borderSkipped: 'bottom',
          barPercentage: .8,
          categoryPercentage: .6
        });
      }
      var chart = new Chart(selectCanvas, {
        type: 'bar',
        data: {
          labels: _get_data.labels,
          datasets: chart_data
        },
        options: {
          legend: {
            display: _get_data.legend ? _get_data.legend : false,
            rtl: NioApp.State.isRTL,
            labels: {
              boxWidth: 30,
              padding: 20,
              fontColor: '#6783b8'
            }
          },
          maintainAspectRatio: false,
          tooltips: {
            enabled: true,
            rtl: NioApp.State.isRTL,
            callbacks: {
              title: function title(tooltipItem, data) {
                return data.datasets[tooltipItem[0].datasetIndex].label;
              },
              label: function label(tooltipItem, data) {
                return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
              }
            },
            backgroundColor: '#eff6ff',
            titleFontSize: 13,
            titleFontColor: '#6783b8',
            titleMarginBottom: 6,
            bodyFontColor: '#9eaecf',
            bodyFontSize: 12,
            bodySpacing: 4,
            yPadding: 12,
            xPadding: 12,
            footerMarginTop: 0,
            displayColors: false
          },
          scales: {
            yAxes: [{
              display: true,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              position: NioApp.State.isRTL ? "right" : "left",
              ticks: {
                beginAtZero: true,
                fontSize: 11,
                fontColor: '#9eaecf',
                padding: 10,
                callback: function callback(value, index, values) {
                  return value + ' TL';
                },
                min: 1000,
                max: 51000,
                stepSize: 10000
              },
              gridLines: {
                color: NioApp.hexRGB("#526484", .2),
                tickMarkLength: 0,
                zeroLineColor: NioApp.hexRGB("#526484", .2)
              }
            }],
            xAxes: [{
              display: true,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              ticks: {
                fontSize: 9,
                fontColor: '#9eaecf',
                source: 'auto',
                padding: 10,
                reverse: NioApp.State.isRTL
              },
              gridLines: {
                color: "transparent",
                tickMarkLength: 0,
                zeroLineColor: 'transparent'
              }
            }]
          }
        }
      });
    });
  }
  // init chart
  NioApp.coms.docReady.push(function () {
    orderOverviewChart();
  });




  var coinOverview = {
    labels: ["Satış Faturaları için", "Alış Faturaları için"],
    stacked: true,
    datasets: [{
      label: "Kontür",
      color: ["#014ad0", "#F2426E"],
      data: [17, 15]
    }]
  };
  function coinOverviewChart(selector, set_data) {
    var $selector = selector ? $(selector) : $('.coin-overview-chart');
    $selector.each(function () {
      var $self = $(this),
        _self_id = $self.attr('id'),
        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
        _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;
      var selectCanvas = document.getElementById(_self_id).getContext("2d");
      var chart_data = [];
      for (var i = 0; i < _get_data.datasets.length; i++) {
        chart_data.push({
          label: _get_data.datasets[i].label,
          data: _get_data.datasets[i].data,
          // Styles
          backgroundColor: _get_data.datasets[i].color,
          borderWidth: 2,
          borderColor: 'transparent',
          hoverBorderColor: 'transparent',
          borderSkipped: 'bottom',
          barThickness: '8',
          categoryPercentage: 0.5,
          barPercentage: 1.0
        });
      }
      var chart = new Chart(selectCanvas, {
        type: 'horizontalBar',
        data: {
          labels: _get_data.labels,
          datasets: chart_data
        },
        options: {
          legend: {
            display: _get_data.legend ? _get_data.legend : false,
            rtl: NioApp.State.isRTL,
            labels: {
              boxWidth: 30,
              padding: 20,
              fontColor: '#6783b8'
            }
          },
          maintainAspectRatio: false,
          tooltips: {
            enabled: true,
            rtl: NioApp.State.isRTL,
            callbacks: {
              title: function title(tooltipItem, data) {
                return data['labels'][tooltipItem[0]['index']];
              },
              label: function label(tooltipItem, data) {
                return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + data.datasets[tooltipItem.datasetIndex]['label'];
              }
            },
            backgroundColor: '#eff6ff',
            titleFontSize: 13,
            titleFontColor: '#6783b8',
            titleMarginBottom: 6,
            bodyFontColor: '#9eaecf',
            bodyFontSize: 12,
            bodySpacing: 4,
            yPadding: 10,
            xPadding: 10,
            footerMarginTop: 0,
            displayColors: false
          },
          scales: {
            yAxes: [{
              display: false,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              ticks: {
                beginAtZero: true,
                padding: 0
              },
              gridLines: {
                color: NioApp.hexRGB("#526484", .2),
                tickMarkLength: 0,
                zeroLineColor: NioApp.hexRGB("#526484", .2)
              }
            }],
            xAxes: [{
              display: false,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              ticks: {
                fontSize: 9,
                fontColor: '#9eaecf',
                source: 'auto',
                padding: 0,
                reverse: NioApp.State.isRTL
              },
              gridLines: {
                color: "transparent",
                tickMarkLength: 0,
                zeroLineColor: 'transparent'
              }
            }]
          }
        }
      });
    });
  }
  // init chart
  NioApp.coms.docReady.push(function () {
    coinOverviewChart();
  });



  var userActivity = {
    labels: ["01 Nov", "02 Nov", "03 Nov", "04 Nov", "05 Nov", "06 Nov", "07 Nov", "08 Nov", "09 Nov", "10 Nov", "11 Nov", "12 Nov", "13 Nov", "14 Nov", "15 Nov", "16 Nov", "17 Nov", "18 Nov", "19 Nov", "20 Nov", "21 Nov"],
    dataUnit: '',
    stacked: true,
    datasets: [{
      label: "Müşteri",
      color: "#014ad0",
      data: [110, 80, 125, 55, 95, 75, 90, 110, 80, 125, 55, 95, 75, 90, 110, 80, 125, 55, 95, 75, 90]
    }, {
      label: "Tedarikçi",
      color: NioApp.hexRGB("#6196f9", .2),
      data: [125, 55, 95, 75, 90, 110, 80, 125, 55, 95, 75, 90, 110, 80, 125, 55, 95, 75, 90, 75, 90]
    }]
  };
  function userActivityChart(selector, set_data) {
    var $selector = selector ? $(selector) : $('.usera-activity-chart');
    $selector.each(function () {
      var $self = $(this),
        _self_id = $self.attr('id'),
        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
        _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;
      var selectCanvas = document.getElementById(_self_id).getContext("2d");
      var chart_data = [];
      for (var i = 0; i < _get_data.datasets.length; i++) {
        chart_data.push({
          label: _get_data.datasets[i].label,
          data: _get_data.datasets[i].data,
          // Styles
          backgroundColor: _get_data.datasets[i].color,
          borderWidth: 2,
          borderColor: 'transparent',
          hoverBorderColor: 'transparent',
          borderSkipped: 'bottom',
          barPercentage: .7,
          categoryPercentage: .7
        });
      }
      var chart = new Chart(selectCanvas, {
        type: 'bar',
        data: {
          labels: _get_data.labels,
          datasets: chart_data
        },
        options: {
          legend: {
            display: _get_data.legend ? _get_data.legend : false,
            rtl: NioApp.State.isRTL,
            labels: {
              boxWidth: 30,
              padding: 20,
              fontColor: '#6783b8'
            }
          },
          maintainAspectRatio: false,
          tooltips: {
            enabled: true,
            rtl: NioApp.State.isRTL,
            callbacks: {
              title: function title(tooltipItem, data) {
                return data.datasets[tooltipItem[0].datasetIndex].label;
              },
              label: function label(tooltipItem, data) {
                return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
              }
            },
            backgroundColor: '#eff6ff',
            titleFontSize: 13,
            titleFontColor: '#6783b8',
            titleMarginBottom: 6,
            bodyFontColor: '#9eaecf',
            bodyFontSize: 12,
            bodySpacing: 4,
            yPadding: 10,
            xPadding: 10,
            footerMarginTop: 0,
            displayColors: false
          },
          scales: {
            yAxes: [{
              display: false,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              ticks: {
                beginAtZero: true
              }
            }],
            xAxes: [{
              display: false,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              ticks: {
                reverse: NioApp.State.isRTL
              }
            }]
          }
        }
      });
    });
  }
  // init chart



setTimeout(() => {

    $("#stok_sec").addClass("js-select2");
    $("#stok_sec").select2({
            dropdownParent: $("#lazerModal"),
            placeholder: "Sac Seçiniz",
            allowClear: true,
            multiple: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "Sonuç bulunamadı";
                },
                searching: function() {
                    return "Aranıyor...";
                }
            },
            // Lütfen Seçiniz seçeneğini filtrele
            templateResult: function(data) {
                if(data.text === "Lütfen Seçiniz") {
                    return null;
                }
                return data.text;
            },
            // Seçilen elemanlarda Lütfen Seçiniz'i gösterme
            templateSelection: function(data) {
                if(data.text === "Lütfen Seçiniz") {
                    return null;
                }
                return data.text;
            }
        });

        // Lütfen Seçiniz seçeneğini gizle
        $("#stok_sec option[value='0']").remove();

  $("#islem_stok").addClass("js-select2");
    $("#islem_stok").select2({
    dropdownParent: $("#lazerModalDevam")
  });


}, 500);


</script>



// JavaScript kısmı
<script>
$(document).ready(function() {
    let satirSayisi = 0;

    // Checkbox değişim olayını dinle
    $('#hepsini-kullandin-checkbox').change(function() {
        const isChecked = $(this).is(':checked');
        
        if (isChecked) {
            // Tüm input'ları disabled yap
            $('.en-input, .boy-input').prop('disabled', true);
            $(".en-input").val("");
            $(".boy-input").val("");
            
            // İlk satır dışındaki tüm satırları sil
            $('.olcu-row:not(:first)').remove();
            
            // Ekle butonunu gizle
            $('.ekle-btn').hide();
            $('.sil-btn').hide();
        } else {
            // Input'ların disabled özelliğini kaldır
            $('.en-input, .boy-input').prop('disabled', false);
           
            
            // Ekle butonunu göster
            $('.ekle-btn').show();
            guncelleButonlar();
        }
    });

    // Yeni satır ekleme fonksiyonu
    function yeniSatirEkle() {
        // Eğer "Tümünü kullandım" seçili ise yeni satır eklemeye izin verme
        if ($('#hepsini-kullandin-checkbox').is(':checked')) {
            return;
        }

        satirSayisi++;
        const yeniSatir = `
            <div class="olcu-row form-control col-12 mb-2" style="display: flex; align-items: center; gap: 20px;">
                <div class="form-group col-3" style="margin-bottom:0; display:flex; align-items: center; gap: 12px;">
                    <label class="form-label" for="en_${satirSayisi}">EN</label>
                    <input type="number" class="form-control en-input" id="en_${satirSayisi}" name="en[]" step="0.01">
                </div>
                <div class="form-group col-3" style="margin-bottom:0; display:flex; align-items: center; gap: 12px;">
                    <label class="form-label" for="boy_${satirSayisi}">BOY</label>
                    <input type="number" class="form-control boy-input" id="boy_${satirSayisi}" name="boy[]" step="0.01">
                </div>
                 <div class="form-group col-3" style="margin-bottom:0; display:flex; align-items: center; gap: 12px;">
                    <label class="form-label" for="sac_${satirSayisi}">SAÇ</label>
                    <select class="form-control sac-input" id="sac_${satirSayisi}" name="sac[]">
                        <option value="0">Lütfen Seçiniz</option>
                       
                    </select>
                </div>
                <div class="col-4 d-flex align-items-center">
                    <button type="button" class="btn btn-icon btn-outline-primary btn-sm ekle-btn" style="margin-right: 10px;">
                        <em class="icon ni ni-plus"></em>
                    </button>
                    <button type="button" class="btn btn-icon btn-outline-danger btn-sm ml-2 sil-btn">
                        <em class="icon ni ni-trash"></em>
                    </button>
                </div>
            </div>
        `;
        $('#olcu-container').append(yeniSatir);
        guncelleButonlar();
    }

    // Butonları güncelleme fonksiyonu
    function guncelleButonlar() {
        // Eğer "Tümünü kullandım" seçili ise butonları güncelleme
        if ($('#hepsini-kullandin-checkbox').is(':checked')) {
            $('.ekle-btn, .sil-btn').hide();
            return;
        }

        $('.olcu-row').each(function(index) {
            const sonEleman = index === $('.olcu-row').length - 1;
            $(this).find('.ekle-btn').toggle(sonEleman);
            $(this).find('.sil-btn').toggle(index !== 0 || $('.olcu-row').length > 1);
        });
    }

    // Ekle butonu tıklama olayı
    $(document).on('click', '.ekle-btn', function() {
        yeniSatirEkle();
    });

    // Sil butonu tıklama olayı
    $(document).on('click', '.sil-btn', function() {
        $(this).closest('.olcu-row').remove();
        guncelleButonlar();
    });

    // İlk satırın sil butonunu gizle
    guncelleButonlar();
});
</script>


<?= $this->endSection() ?>

<?= $this->include('tportal/inc/footer') ?>


              
<?= $this->include('tportal/inc/script') ?>


<?= $this->renderSection('script') ?>


</body>

</html>