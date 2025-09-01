





<!DOCTYPE html>
<html lang="tr_TR" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="tiko digital">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="content-language" content="tr">
    <meta name="description" content="">
    <link rel="manifest" href="<?= base_url('custom/manifest.json') ?>">

    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?= base_url('custom/favicon.png') ?>">

    <!-- Page Title  -->
    <title><?= $this->renderSection('page_title', true) ?> - Tiko Portal | Online Ön Muhasebe, E-Arşiv Fatura ve E-Fatura Kesme Programı</title>
    
    <meta name="<?= csrf_header() ?>" content="<?= csrf_hash() ?>">
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?= base_url('assets/css/dashlite.css?ver=3.2.0') ?>">
    <link id="skin-default" rel="stylesheet" href="<?= base_url('assets/css/theme.css?ver=3.2.0') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= base_url('custom/webfont_gilroy/font.css') ?>">

    <link rel="stylesheet" href="<?= base_url('custom/theme_blue.css?ver=2.0.0') ?>">
    <link rel="stylesheet" href="<?= base_url('custom/style.css?ver=2.0.2') ?>">

    <style>
    .modal-xl{
        min-width: 1200px!important;
    }
    input.transparent-input{
        background-color:rgba(0,0,0,0) !important;
        border:none !important;
        color: #344357 !important;
    }

    .transparent-input-text{
        background-color:rgba(0,0,0,0) !important;
        border:none !important;
        color: #344357 !important;
        padding: 0px !important;
        margin-top: 4px !important;
    }

    .dvz_str{
        margin-top: -14px !important;
    }

    .minw-120{
        min-width: 120px !important;
    }
   
    #datatableStock-loading {
    display: none;
    opacity: 0;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    backdrop-filter: blur(5px);
    background: rgba(255, 255, 255, 0.75);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

/* KAPAT BUTONU */
#datatableStock-loading-close {
    position: absolute;
    top: 20px;
    right: 20px;
    background-color: rgba(0, 0, 0, 0.05);
    border: none;
    border-radius: 6px;
    padding: 6px 14px;
    font-size: 15px;
    font-family: 'Segoe UI', sans-serif;
    color: #333;
    cursor: pointer;
    transition: background-color 0.2s, color 0.2s;
}

#datatableStock-loading-close:hover {
    background-color: rgba(0, 0, 0, 0.1);
    color: #000;
}

.loading-content {
    text-align: center;
    animation: fadeIn 0.3s ease-in-out;
}

.loading-logo {
    width: 210px;
    height: auto;
    margin-bottom: 24px;
    animation: pulse 2s infinite ease-in-out;
}

.loading-text {
    font-size: 18px;
    color: #333;
    font-weight: 500;
    font-family: 'Segoe UI', sans-serif;
    letter-spacing: 2px;
}

.dots::after {
    content: '';
    display: inline-block;
    animation: dots 1.5s infinite;
}

@keyframes dots {
    0% { content: ''; }
    33% { content: '.'; }
    66% { content: '..'; }
    100% { content: '...'; }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

</style>

<?= $this->renderSection('styles') ?>
</head>

