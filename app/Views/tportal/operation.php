

<?= $this->section('page_title') ?> Operatör Sayfası
<?= $this->endSection() ?>
<?= $this->section('title') ?> <?php echo $operation_title; ?> Operatörü | <?= session()->get('user_item')['user_adsoyad'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>






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
                                                <span class="sub-title nk-dropdown-title">Yeni Sevk Emirleri</span>
                                            </div>
                                            <div class="dropdown-body">
                                                <div class="nk-notification">
                                                    <?php foreach ($sevkler as $sevk):
                                                        
                                                        if($sevk["bitti"] == 0){ ?>

                                                                <a target="_blank" href="<?php  echo base_url('tportal/order/sevkPrint_tarih/' . $sevk["sevk_id"]) ?>">

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
        line-height: 36px;
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
        top:35px;
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
</style>



<?php if(session()->get('user_item')['operation'] == 18 AND session()->get('user_item')['user_id'] == 1 || session()->get('user_item')['user_id'] == 19) : ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        
function backgroundDegis(id) {

    var element = document.querySelector(".kutu_genel_" + id);
    
    if (!element) {
        console.warn("Element bulunamadı: .kutu_genel_" + id);
        return;
    }

    var element = document.querySelector(".kutu_genel_" + id);
    var blinkDuration = 500; // Yanıp sönme süresi (milisaniye)
    var totalDuration = 5000; // Toplam süre (milisaniye)
    var elapsedTime = 0;

    var originalColor = getComputedStyle(element).backgroundColor; // Orijinal arka plan rengi

    var blinkInterval = setInterval(function() {
        if (elapsedTime >= totalDuration) {
            clearInterval(blinkInterval);
            element.style.backgroundColor = 'transparent'; // Yanıp sönmeyi durdur ve arka plan rengini şeffaf yap
            element.style.color = 'black'; // Yazı rengini siyah yap
            return;
        }

        if (element.style.backgroundColor === 'green') {
            element.style.backgroundColor = originalColor; // Orijinal rengi geri döndür
            element.style.color = 'black'; // Yazı rengini siyah yap
        } else {
            element.style.backgroundColor = 'green'; // Arka plan rengini yeşil yap
            element.style.color = 'white'; // Yazı rengini beyaz yap
        }
        elapsedTime += blinkDuration;
    }, blinkDuration);
}


function kutular() {

    $("#loading").show(); // Yükleme simgesini göster

    return new Promise((resolve, reject) => {
        $.ajax({
            url: '<?php echo route_to("tportal.kutular"); ?>',
            method: 'POST',
            data: {},
            success: function (res) {

                $("#loading").hide(); // Yükleme simgesini göster

                $("#kutuContainer").html(res);
                resolve(); // İçerik güncellendiğinde promise'i çöz
            },
            error: function () {
                reject(); // Hata durumunda promise'i reddet
            }
        });
    });
}


function DoluBosKontrol()
{
    



}



function submitOnEnter(event) {


    if (event.key === "Enter") {
        event.preventDefault();

        var barcode = $(event.target).val();

        var order_id_manuel = $("#order_id_manuel").val();

        Swal.fire({
            title: 'Barkod Sorgulanıyor, Lütfen Bekleyiniz!',
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading();
            },
        });

        $.ajax({
            url: '<?php echo route_to("tportal.getBarcode"); ?>',
            method: 'POST',
            data: { barcode: barcode, order_id_manuel:order_id_manuel },
            dataType: 'json',
            success: function (res) {
                Swal.close();
                $(".barkodSil").val('');


                if (res.icon === 'success') {
                    kutular().then(() => {
                        var div = $(".stock_id_" + res.stock_id);
                        div.attr("tabindex", -1).focus(); // tabindex eklenir ve odaklanır
                        div.removeClass('blinking'); // Yanıp sönme efekti kaldır
                        div.addClass("blinking");
                
                    });
                    if (res.yazdir == 1) {

                        Swal.fire({
                            icon: "success",
                            title: 'Başarılı',
                            showConfirmButton: false, // Hide the confirm button
                            timer: 4000, // Close after 4 seconds (4000 milliseconds)
                            html: res.data,
                        });
                        setInterval(() => {
                                    kutular();
                                }, 3000);
                        setTimeout(() => {
                                    kutular();
                                }, 3000);

                        $(".barkodSil").val('');

    
                                 setTimeout(() => {
                            
                                    window.open('<?php echo base_url(); ?>/tportal/order/sevkSiparisYazdir/' + res.order_id, '_blank');
                                }, 3000);

                               
                    }else{
                        Swal.fire({
                        icon: "info",
                        
                        confirmButtonText: "Kapat",
                        html: res.data,
                    });
                    kutular().then(() => {
                        var div = $(".stock_id_" + res.stock_id);
                        div.attr("tabindex", -1).focus(); // tabindex eklenir ve odaklanır
                        div.removeClass('blinking'); // Yanıp sönme efekti kaldır
                        div.addClass("blinking");
                    });
                    }
                   

                } else  if (res.icon === 'info') {
                    Swal.fire({
                        icon: "info",
                       
                        confirmButtonText: "Kapat",
                        html: res.data,
                    });
                    kutular().then(() => {
                        var div = $(".stock_id_" + res.stock_id);
                        div.attr("tabindex", -1).focus(); // tabindex eklenir ve odaklanır
                        div.removeClass('blinking'); // Yanıp sönme efekti kaldır
                        div.addClass("blinking");
                    });
                }
                else  if (res.icon === 'tekrar_stok') {
                    var div = $(".stock_id_" + res.stock_id);
                        div.attr("tabindex", -1).focus(); // tabindex eklenir ve odaklanır
                        div.removeClass('blinking'); // Yanıp sönme efekti kaldır
                        div.addClass("blinking");
                    Swal.fire({
                        icon: "info",
                      
                        confirmButtonText: "Kapat",
                        html: '<b>' + res.data + '</b>',
                    });
                
                }
                
                else {
                    Swal.fire({
                        icon: "warning",
                        title: 'Bu Ürün Siparişte Bulunamadı!',
                        html: res.data,
                        confirmButtonText: "Kapat",

                    });
                }
            },
            error: function () {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    confirmButtonText: "Kapat",

                    text: 'Bir hata oluştu, lütfen tekrar deneyin.',
                });
            }
        });
    }
}





        // Sayfa yüklendiğinde fonksiyonu çağır
        $(document).ready(function() {

           

            setTimeout(() => {
                DoluBosKontrol();
            }, 500);
            setInterval(() => {
            $('.gallery-image').on('click', function() {
            $("#imageModal").modal("show");
            var imageUrl = $(this).data('image-url');
            var title = $(this).data('image-title');
            $('#modalImage').attr('src', imageUrl);
            $('#titleModal').html(title);
        });
           }, 300);
            kutular();
        });


       /* 
        setInterval(() => {
            kutular();

        }, 30000);
       */

    </script>


<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<script>
   
</script>



<section id="barcode">
<div class="container-xl wide-xl">
<form id="barcodeForm" onsubmit="return false;">
        <div class="inputBox">
           <!-- <input  class="barkodSil" type="text" name="barcode" id="barcode" placeholder="Lütfen Ürün Barkodunu Okutun" onkeypress="submitOnEnter(event)"> -->
           <input class="barkodSil" type="text" name="barcode" id="barcode" 
       placeholder="Lütfen Ürün Barkodunu Okutun" 
       onkeypress="return handleBarcodeInput(event)"
       onpaste="return false"
       ondrop="return false"
       autocomplete="off"
       readonly
       onfocus="this.removeAttribute('readonly');"
       onblur="this.setAttribute('readonly','readonly');"> 
           <em class="icon ni ni-scan"></em>
        </div>
    </form>
</div>

</section>

<div id="prosess" class="container-xl wide-xl " style="margin-bottom:350px;">
<div class="row">
<div class="col-12 prosess-item bekleyen">
         
<div class="card card-preview">
  <div class="card-inner" style="padding:0">
    <div class="row g-gs" id="kutuContainer">

    <div id="loading" class="loading">Kutular Yükleniyor...</div>

    </div>
  </div>
  </div>
  </div>
</div>
</div>
<div id="prosess" class="container-xl wide-xl " style="margin-bottom:350px;">
<div class="row">
<div class="col-12 prosess-item bekleyen">
         
            <div class="" style="display:block">
                <div class="row">
                    <div class="col-12">
                             <div class="nk-block">
                                <div class="nk-data data-list">


                                <div class="urunlerGelsin">
                             
                              

                                </div>

                                  
                                </div><!-- data-list -->
                            </div><!-- .nk-block -->
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
<?php else: ?>
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
                        <span>Ürün Adı :</span>
                        <span><b><?= $outgoing_invoice['stock_title']; ?></b></span>
                    </li>
                    <li>
                        <span>Sipariş :</span>
                        <span><?= number_format($outgoing_invoice['stock_amount'], 2, ',', '.') ?></span>
                    </li>
                    <li>
                        <span>İşlenen :</span>
                        <span><?= number_format($outgoing_invoice['used_amount'], 2, ',', '.') ?></span>
                    </li>
                    <li>
                        <span>Kalan :</span>
                        <span><?= number_format(($outgoing_invoice['stock_amount'] - $outgoing_invoice['used_amount']), 2, ',', '.') ?></span>
                    </li>
                </ul>
            </div>
            <div class=" col-12 col-sm-5 col-md-5 col-lg-5">
                <ul class="actionUl">
                    <li>
                    <a 
                                                          data-op_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>"
                                                          data-operation_status="<?=  $outgoing_invoice['status'] ?>"
                                                          data-islenen_miktar=""
                                                          data-siparis_miktar="<?=  number_format($outgoing_invoice['stock_amount'], 2, ',', '.') ?>"
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
                            <span>Ürün Adı :</span>
                            <span><b><?= $outgoing_invoice['stock_title']; ?></b></span>
                        </li>
                        <li>
                            <span>Sipariş :</span>
                            <span><?= number_format($outgoing_invoice['stock_amount'], 2, ',', '.') ?></span>
                        </li>
                        <li>
                            <span>İşlenen :</span>
                            <span><?= number_format($outgoing_invoice['used_amount'], 2, ',', '.') ?></span>
                        </li>
                        <li>
                            <span>Kalan :</span>
                            <span><?= number_format(($outgoing_invoice['stock_amount'] - $outgoing_invoice['used_amount']), 2, ',', '.') ?></span>
                        </li>
                    </ul>
                </div>
                <div class=" col-12 col-sm-5 col-md-5 col-lg-5">
                    <ul class="actionUl">
                        <li>
                            <a data-durdur_tarihi="<?php echo $islemKontrol; ?>" data-data-baslangic="<?php echo $outgoing_invoice["baslangic"]; ?>" data-stock_title="<?= $outgoing_invoice['stock_title']; ?>" data-product="<?php echo $outgoing_invoice['production_row_operation_id']; ?>" class="durumislem_<?php echo $outgoing_invoice['production_row_operation_id']; ?> <?php if($outgoing_invoice["status"] == "Durdu" ) { echo 'play';  }else{ echo 'pause'; } ?> "  data-p_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>" href="javascript:;">
                                 <em class="icon ni ni-pause-fill"></em> <span></span>
                                 
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="kapat_<?php echo $outgoing_invoice['production_row_operation_id']; ?>  <?php if($outgoing_invoice["status"] == "Durdu" ) {?>   devam_ettir <?php }else{ echo 'tamamlandi_baslat'; } ?>  " data-op_id="<?php echo $outgoing_invoice['production_row_operation_id']; ?>" data-operation_status="<?=  $outgoing_invoice['status'] ?>" data-islenen_miktar="<?=  $outgoing_invoice['stock_amount'] ?>" data-siparis_miktar="<?=  $outgoing_invoice['stock_amount'] ?>">
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
                                                <th style="background-color: #ebeef2;">SIRA</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">SİPARİŞ KODU</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">TARİH</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">ÜRÜN ADI</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">SİPARİŞ</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">İŞLENEN</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">İŞLEYEN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                    foreach ($bitti_operasyonlar as $outgoing_invoice) {
                                  
                                        if($outgoing_invoice["operation_id"] == $operation){
                                      
                                       
                                      ?>
                                            <tr>
                                                <td><?php echo $outgoing_invoice['production_row_operation_id']; ?></td>
                                                <td><b><?php echo $outgoing_invoice['production_number']; ?></b></td>
                                                <td><?= date("d/m/Y h:i", strtotime($outgoing_invoice['created_at'])) ?></td>
                                                <td><?= $outgoing_invoice['stock_title']; ?></td>
                                                <td><?=  number_format($outgoing_invoice['stock_amount'], 2, ',', '.') ?></td>
                                                <td><?=  number_format($outgoing_invoice['used_amount'], 2, ',', '.') ?></td>
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
                                <span>Ürün Adı :</span>
                                <span><b><?= $outgoing_invoice['stock_title']; ?></b></span>
                            </li>
                            <li>
                                <span>Sipariş :</span>
                                <span><?= number_format($outgoing_invoice['stock_amount'], 2, ',', '.') ?></span>
                            </li>
                            <li>
                                <span>İşlenen :</span>
                                <span><?= number_format($outgoing_invoice['used_amount'], 2, ',', '.') ?></span>
                            </li>
                            <li>
                                <span>Kalan :</span>
                                <span><?= number_format(($outgoing_invoice['stock_amount'] - $outgoing_invoice['used_amount']), 2, ',', '.') ?></span>
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
<?php endif; ?>









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










<?= $this->section('script') ?>




<script>

var lastKeyTime = 0;



function handleBarcodeInput(event) {
    submitOnEnter(event);
}
$(document).ready(function () {



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





$(".bekeleyen_baslat").click(function(){

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
         })


});


$(".tamamlandi_baslat").click(function(){

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
       })


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
  NioApp.coms.docReady.push(function () {
    userActivityChart();
  });
</script>

<?= $this->endSection() ?>

<?= $this->include('tportal/inc/footer') ?>


              
<script>
  var para_yuvarlama = <?php echo session()->get('user_item')['para_yuvarlama'] ?? 2; ?>;
</script>

<script src="<?= base_url('assets/js/bundle.js') ?>"></script>
<script src="<?= base_url('assets/js/scripts.js?ver=3.0.27') ?>"></script>
<script src="<?= base_url('assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('assets/js/il-ilce.js?ver=1.1.1') ?>"></script>
<script src="<?= base_url('assets/js/phone-area-code.js?ver=1.1.0') ?>"></script>
<script src="<?= base_url('assets/js/charts/gd-default.js') ?>"></script>
<script src="<?= base_url('assets/js/libs/datatable-btns.js') ?>"></script>
<script src="<?= base_url('custom/tiko.js') ?>"></script>
<style>
  .logo-container {
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    color: #fff;
}

.logo-text {
    font-weight: 300;
    animation: fadeInLeft 0.8s ease-out;
}

.logo-portal {
    font-weight: 500;
    animation: fadeInRight 0.8s ease-out;
}

.logo-dot {
    color: #4A90E2;
    animation: bounce 1s ease-out;
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}
  #global-ajax-loading .loading-content {
    /* ... mevcut stiller ... */
    border: 1px solid #e0e0e0;
}

#global-ajax-loading .spinner-border {
    width: 3rem;
    height: 3rem;
}

#global-ajax-loading .loading-text {
    font-weight: 500;
    margin-top: 10px;
}
</style>
<div class="logo-container">
    <span class="logo-text">tiko</span><span class="logo-portal">portal</span><span class="logo-dot">.</span>
</div>
<script>





if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('https://app.tikoportal.com.tr/custom/service-worker.js').then(function(registration) {
      console.log('Service Worker başarıyla kayıt edildi:', registration.scope);
    }).catch(function(error) {
      console.log('Service Worker kaydedilirken hata oluştu:', error);
    });
  });
}



</script>




<?= $this->renderSection('script') ?>


</body>

</html>