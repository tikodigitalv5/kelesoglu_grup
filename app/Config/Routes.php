<?php

use CodeIgniter\Router\RouteCollection;

use TikoPortal\Cron;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'TikoPortal\Home::index');
//$routes->get('set', 'TikoPortal\Home::setSession');
//$routes->get('clear', 'TikoPortal\Home::clearSession');
//$routes->get('uploadModuleData', 'TikoPortal\Home::module_data');


$routes->view('/register', 'auth/page/register', ['as' => 'tportal.auth.register']);

//$routes->get(from: 'login', 'TikoPortal\User::login', ['filter' => 'AlreadyLoggedIn', 'as' => 'tportal.auth.login']);
$routes->get('login', 'TikoPortal\User::login', ['filter' => 'AlreadyLoggedIn', 'as' => 'tportal.auth.login']);
$routes->get('register', 'TikoPortal\User::register', ['filter' => 'AlreadyLoggedIn', 'as' => 'tportal.auth.register']);
$routes->get('logout', 'TikoPortal\User::logout', ['as' => 'user_logout']);
$routes->match(['get', 'post'], 'checkLoginRule', 'TikoPortal\User::checkLogin', ['as' => 'tportal.auth.checkLogin']);
$routes->match(['get', 'post'], 'checkRegisterRule', 'TikoPortal\User::checkRegister', ['as' => 'tportal.auth.checkRegister']);

// $routes->get('getAllConfig', 'TikoERP\Home::getAllConfig');
// $routes->get('getAllStock', 'TikoERP\Home::getAllStock');
// $routes->get('getStockRecipe', 'TikoERP\Home::getStockRecipe');
// $routes->get('getStockGallery', 'TikoERP\Home::getStockGallery');
// $routes->get('getStockOperation', 'TikoERP\Home::getStockOperation');
// $routes->get('makeHash/(:any)', 'TikoPortal\User::makeHash/$1');

$routes->get('cron', 'TikoERP\Cron::updateExchangeRates', ['as' => 'tportal.auth.cron']);
$routes->get('sismond', 'Api\Sysmond::test', ['as' => 'tportal.auth.test']);
$routes->get('sysmond/index', 'Api\Sysmond::index');
$routes->post('sysmond/index', 'Api\Sysmond::index');
$routes->get('sysmond/check', 'Api\Sysmond::stock_and_sysmond');
$routes->get('sysmond/check_raf', 'Api\Sysmond::stock_sysmond_raf');
$routes->get('sysmond/stock_bilgisi_guncelleme', 'Api\Sysmond::sysmond_stock_bilgisi_guncelleme');
$routes->get('sysmond/sysmondFullStock', 'Api\Sysmond::sysmondFullStock');
$routes->get('sysmond/sysmondGunlukStokHareketi/', 'Api\Sysmond::sysmondGunlukStokHareketi');
$routes->get('sysmond/sysmondToWebEklenmeyenler', 'Api\Sysmond::sysmondToWebEklenmeyenler');
$routes->get('sysmond/sysmondToWebEklenmeyenlerGunluk', 'Api\Sysmond::sysmondToWebEklenmeyenlerGunluk');
$routes->get('sysmond/sysmondStokYoklarSadece', 'Api\Sysmond::sysmondStokYoklarSadece');
$routes->get('sysmond/stokesitle', 'Api\Sysmond::stokesitle');
$routes->get('sysmond/depodan_stok_esitle', 'Api\Sysmond::depodan_stok_esitle');
$routes->get('sysmond/sysmond_barcode', 'Api\Sysmond::sysmond_barcode');
$routes->get('sysmond/sysmond_depo', 'Api\Sysmond::sysmond_depo');
$routes->get('sysmond/sysmond_depo_kontrol', 'Api\Sysmond::sysmond_depo_kontrol');
$routes->get('sysmond/sysmond_depo_tekli/(:num)', 'Api\Sysmond::sysmond_depo_tekli/$1   ');
$routes->get('sysmond/sysmond_ikinci_barkod', 'Api\Sysmond::sysmond_ikinci_barkod');

$routes->get('fams/whatsapp', 'TikoERP\DopigoApi::siparisRaporWhatsApp');




$routes->group('tportal', ['filter' => 'AuthCheck'], function($routes){   


    $routes->get('cekler', 'TikoERP\Cekler::index', ['as' => 'tportal.gider.cekler']);
    $routes->get('cekler/yeni', 'TikoERP\Cekler::yeni', ['as' => 'tportal.gider.cekler.yeni']);
    $routes->post('cekler/yeni', 'TikoERP\Cekler::yeni', ['as' => 'tportal.gider.cekler.yeni']);
    $routes->get('cekler/ciro/(:num)', 'TikoERP\Cekler::ciro/$1', ['as' => 'tportal.gider.cekler.ciro']);
    $routes->get('cekler/sil/(:num)', 'TikoERP\Cekler::sil/$1', ['as' => 'tportal.gider.cekler.sil']);

    $routes->group('senkronizasyon', function($routes){
        $routes->get('list', 'TikoERP\Sysmond::list', ['as' => 'tportal.api.sysmond']);
        $routes->get('dopigo', 'TikoERP\DopigoApi::list', ['as' => 'tportal.api.dopigo.list']);
        $routes->post('dopigo/filter-data', 'TikoERP\DopigoApi::filter', ['as' => 'tportal.api.dopigo.filterData']);
        $routes->get('dopigo/get-details/(:num)', 'TikoERP\DopigoApi::getDetails/$1', ['as' => 'tportal.api.dopigo.getDetails']);
        $routes->get('dopigo/get-error-details/(:num)', 'TikoERP\DopigoApi::getErrorDetails/$1', ['as' => 'tportal.api.dopigo.getErrorDetails']);
    });

    $routes->get('yetkilendirme-hatasi', 'TikoERP\ErrorController::index');


    // $routes->view('/', 'tportal/index', ['as' => 'tportal.dashboard']);
    $routes->get('/', 'TikoERP\Home::index', ['as' => 'tportal.dashboard']);



    $routes->get('giderler', 'TikoPortal\Home::hazirlaniyor', ['as' => 'tportal.giderler']);
    $routes->get('giderler/kalemler', 'TikoPortal\Home::hazirlaniyor', ['as' => 'tportal.giderler.kalemler']);
    $routes->get('giderler/personeller', 'TikoPortal\Home::hazirlaniyor', ['as' => 'tportal.giderler.personeller']);
    $routes->get('giderler/araclar', 'TikoPortal\Home::hazirlaniyor' , ['as' => 'tportal.giderler.araclar']);
    $routes->get('giderler/yeni', 'TikoPortal\Home::hazirlaniyor', ['as' => 'tportal.giderler.yeni']);
    $routes->get('raporlar/siparis', 'TikoPortal\Home::hazirlaniyor' ,['as' => 'tportal.raporlar.siparis']);
    $routes->get('raporlar/odeme', 'TikoPortal\Home::hazirlaniyor',['as' => 'tportal.raporlar.odeme']);
    $routes->get('raporlar/tahsilat', 'TikoPortal\Home::hazirlaniyor',['as' => 'tportal.raporlar.tahsilat']);
    $routes->get('sevkiyatlar/detay', 'TikoPortal\Home::hazirlaniyor',['as' => 'tportal.sevkiyatlar.detay']);
    
    



    $routes->view('musteriler', 'tportal/hazirlaniyor', ['as' => 'tportal.musteriler']);
    $routes->view('tedarikciler', 'tportal/hazirlaniyor', ['as' => 'tportal.tedarikciler']);
    $routes->view('cariler', 'tportal/hazirlaniyor', ['as' => 'tportal.cariler']);
    $routes->view('cariler/detay', 'tportal/cariler/detay/detay', ['as' => 'tportal.cariler.detay']);
    $routes->view('cariler/hareketler', 'tportal/cariler/detay/hareketler', ['as' => 'tportal.cariler.hareketler']);
    $routes->view('cariler/tahsilat_odeme', 'tportal/cariler/detay/tahsilat_odeme', ['as' => 'tportal.cariler.tahsilat_odeme']);
    $routes->view('cariler/duzenle', 'tportal/cariler/detay/duzenle', ['as' => 'tportal.cariler.duzenle']);
    $routes->view('cariler/yetkililer', 'tportal/cariler/detay/yetkililer', ['as' => 'tportal.cariler.yetkililer']);
    $routes->view('cariler/adresler', 'tportal/cariler/detay/adresler', ['as' => 'tportal.cariler.adresler']);
    $routes->view('cariler/ayarlar', 'tportal/hazirlaniyor', ['as' => 'tportal.cariler.ayarlar']);

    $routes->view('stoklar', 'tportal/hazirlaniyor', ['as' => 'tportal.stoklar']);
    $routes->view('urunler', 'tportal/hazirlaniyor', ['as' => 'tportal.urunler']);
    $routes->view('hizmetler', 'tportal/hazirlaniyor', ['as' => 'tportal.hizmetler']);
    $routes->view('stoklar/yeni', 'tportal/hazirlaniyor', ['as' => 'tportal.stoklar.yeni']);
    $routes->view('stoklar/detay', 'tportal/hazirlaniyor', ['as' => 'tportal.stoklar.detay']);
    $routes->view('stoklar/hareketler', 'tportal/hazirlaniyor', ['as' => 'tportal.stoklar.hareketler']);
    $routes->view('stoklar/operasyonlar', 'tportal/hazirlaniyor', ['as' => 'tportal.stoklar.operasyonlar']);
    $routes->view('stoklar/duzenle', 'tportal/hazirlaniyor', ['as' => 'tportal.stoklar.duzenle']);
    $routes->view('stoklar/alturunler', 'tportal/hazirlaniyor', ['as' => 'tportal.stoklar.alturunler']);
    $routes->view('stoklar/galeri', 'tportal/hazirlaniyor', ['as' => 'tportal.stoklar.galeri']);
    $routes->view('stoklar/recete', 'tportal/hazirlaniyor', ['as' => 'tportal.stoklar.recete']);

    $routes->view('teklifler', 'tportal/hazirlaniyor', ['as' => 'tportal.teklifler']);
    $routes->view('teklifler/acik', 'tportal/hazirlaniyor', ['as' => 'tportal.teklifler.acik']);
    $routes->view('teklifler/kapali', 'tportal/hazirlaniyor', ['as' => 'tportal.teklifler.kapali']);
    $routes->view('teklifler/yeni', 'tportal/hazirlaniyor', ['as' => 'tportal.teklifler.yeni']);

    $routes->view('sevkiyatlar/tumu', 'tportal/sevkiyatlar/index', ['as' => 'tportal.sevkiyatlar']);
    $routes->view('sevkiyatlar/acik', 'tportal/sevkiyatlar/acik', ['as' => 'tportal.sevkiyatlar.acik']);
    $routes->view('sevkiyatlar/kapali', 'tportal/sevkiyatlar/kapali', ['as' => 'tportal.sevkiyatlar.kapali']);
    $routes->view('sevkiyatlar/yeni', 'tportal/sevkiyatlar/yeni', ['as' => 'tportal.sevkiyatlar.yeni']);
    $routes->view('sevkiyatlar/hareketler', 'tportal/sevkiyatlar/detay/hareketler', ['as' => 'tportal.sevkiyatlar.hareketler']);


    $routes->view('uretim', 'tportal/uretim/hazirlaniyor', ['as' => 'tportal.uretim']);
    $routes->view('uretim/acik', 'tportal/uretim/hazirlaniyor', ['as' => 'tportal.uretim.acik']);
    $routes->view('uretim/kapali', 'tportal/uretim/hazirlaniyor', ['as' => 'tportal.uretim.kapali']);
    $routes->view('uretim/yeni', 'tportal/hazirlaniyor', ['as' => 'tportal.uretim.yeni']);
    $routes->view('uretim/detay', 'tportal/hazirlaniyor', ['as' => 'tportal.uretim.detay']);
    $routes->view('uretim/hareketler', 'tportal/uretim/hazirlaniyor', ['as' => 'tportal.uretim.hareketler']);

    



    $routes->view('hesaplar', 'tportal/hesaplar/index', ['as' => 'tportal.hesaplar.list']);
    $routes->view('hesaplar/kasalar', 'tportal/hazirlaniyor', ['as' => 'tportal.hesaplar.kasalar']);
    $routes->view('hesaplar/bankalar', 'tportal/hazirlaniyor', ['as' => 'tportal.hesaplar.bankalar']);
    $routes->view('hesaplar/kredikartlari', 'tportal/hazirlaniyor', ['as' => 'tportal.hesaplar.kredikartlari']);

    $routes->view('hesaplar/yeni', 'tportal/hesaplar/yeni', ['as' => 'tportal.hesaplar.yeni']);
    //$routes->view('hesaplar/detay', 'tportal/hesaplar/detay/detay', ['as' => 'tportal.hesaplar.detay']);
    $routes->view('hesaplar/hareketler', 'tportal/hesaplar/detay/hareketler', ['as' => 'tportal.hesaplar.hareketler']);
    //$routes->view('hesaplar/detayli-hareketler', 'tportal/hesaplar/detay/hareketler_detayli', ['as' => 'tportal.hesaplar.hareketler.detayli']);
    $routes->view('hesaplar/islemekle', 'tportal/hesaplar/detay/islem_ekle', ['as' => 'tportal.hesaplar.hareketler.islem']);



    $routes->get('hesaplar/detayli-hareketler', 'TikoPortal\Home::hazirlaniyor',['as' => 'tportal.hesaplar.hareketler.detayli']);


    $routes->view('raporlar', 'tportal/hazirlaniyor', ['as' => 'tportal.raporlar']);
    $routes->view('raporlar/gelir', 'tportal/hazirlaniyor', ['as' => 'tportal.raporlar.gelir']);
    $routes->view('raporlar/gider', 'tportal/hazirlaniyor', ['as' => 'tportal.raporlar.gider']);
    $routes->view('raporlar/musteri', 'tportal/hazirlaniyor', ['as' => 'tportal.raporlar.musteri']);
    $routes->view('raporlar/tedarikci', 'tportal/hazirlaniyor', ['as' => 'tportal.raporlar.tedarikci']);
    $routes->view('raporlar/stok', 'tportal/hazirlaniyor', ['as' => 'tportal.raporlar.stok']);
    $routes->view('raporlar/siparis', 'tportal/hazirlaniyor', ['as' => 'tportal.raporlar.siparis']);
    $routes->view('raporlar/odeme', 'tportal/hazirlaniyor', ['as' => 'tportal.raporlar.odeme']);
    $routes->view('raporlar/tahsilat', 'tportal/hazirlaniyor', ['as' => 'tportal.raporlar.tahsilat']);
    $routes->view('raporlar/yeni', 'tportal/hazirlaniyor', ['as' => 'tportal.raporlar.yeni']);



    $routes->get('getNotes/(:any)', 'TikoERP\Cari::getNotes/$1', ['as' => 'tportal.getNotes']);


    $routes->post('paletSatisControl', 'TikoERP\Home::paletSatisControl', ['as' => 'tportal.paletSatisControl']);


    $routes->group('invoice',  function($routes){
        $routes->get('list/(:any)', 'TikoERP\Invoice::list/$1', ['filter' => 'modulePermission', 'as' => 'tportal.faturalar.list']);
        $routes->get('proforma/(:any)', 'TikoERP\Invoice::proforma/$1', ['filter' => 'modulePermission', 'as' => 'tportal.faturalar.proforma']);

        $routes->get('gunlukProformaFaturaBildirim', 'TikoERP\Invoice::GunlukProformaFaturaBildirim', ['as' => 'tportal.faturalar.gunlukProformaFaturaBildirim']);


        $routes->get('detail', 'TikoERP\Invoice::detail', ['filter' => 'modulePermission', 'as' => 'tportal.faturalar.detail.null']);
        $routes->get('detail/(:any)', 'TikoERP\Invoice::detail/$1', ['filter' => 'modulePermission', 'as' => 'tportal.faturalar.detail']);
        $routes->match(['get', 'post'], 'create', 'TikoERP\Invoice::create', ['filter' => 'modulePermission','as' => 'tportal.faturalar.create']);
        $routes->match(['get', 'post'], 'edit/(:any)', 'TikoERP\Invoice::edit/$1', ['filter' => 'modulePermission', 'as' => 'tportal.faturalar.edit']);
        $routes->match(['get', 'post'], 'delete/(:any)', 'TikoERP\Invoice::delete/$1', ['filter' => 'modulePermission', 'as' => 'tportal.faturalar.delete']);
        $routes->match(['get', 'post'], 'finans_hareket_delete/(:any)', 'TikoERP\Invoice::finans_hareket_delete/$1', ['filter' => 'modulePermission', 'as' => 'tportal.faturalar.finans_hareket_delete']);
        $routes->match(['get', 'post'], 'getInvoices/(:any)', 'TikoERP\Invoice::getInvoices/$1', ['as' => 'tportal.faturalar.getInvoices']);
        $routes->match(['get', 'post'], 'getInvoicesRow/(:any)', 'TikoERP\Invoice::getInvoicesRow/$1', ['as' => 'tportal.faturalar.getInvoicesRow']);

        $routes->get('getUnits', 'TikoERP\Invoice::getUnits', ['as' => 'tportal.faturalar.getUnits']);
        $routes->get('getWithholding', 'TikoERP\Invoice::getWithholding', ['as' => 'tportal.faturalar.getWithholding']);
        $routes->get('getMoneyUnits', 'TikoERP\Invoice::getMoneyUnits', ['as' => 'tportal.faturalar.getMoneyUnits']);
        $routes->get('getInvoiceSerial', 'TikoERP\Invoice::getInvoiceSerial', ['as' => 'tportal.faturalar.getInvoiceSerial']);
        $routes->get('getExceptionType', 'TikoERP\Invoice::getExceptionType', ['as' => 'tportal.faturalar.getExceptionType']);
        $routes->get('getSpecialBase', 'TikoERP\Invoice::getSpecialBase', ['as' => 'tportal.faturalar.getSpecialBase']);  
        
        $routes->get('quickSalePrint/(:any)', 'TikoERP\Invoice::quickSalePrint/$1', ['as' => 'tportal.faturalar.quickSalePrint']);


        $routes->get('faturaSatirkontrol', 'TikoERP\Invoice::faturaSatirkontrol', ['as' => 'tportal.faturalar.faturaSatirkontrol']);

        $routes->get('BakiyeGenelHesapla', 'TikoERP\Cari::BakiyeGenelHesapla', ['as' => 'tportal.faturalar.bakiyeGenelHesapla']);

        $routes->match(['get', 'post'], 'siparis/(:any)', 'TikoERP\Invoice::siparis_create/$1', ['filter' => 'modulePermission', 'as' => 'tportal.siparis_create']);
        $routes->match(['get', 'post'], 'teklif/(:any)', 'TikoERP\Invoice::teklif_create/$1', ['filter' => 'modulePermission', 'as' => 'tportal.teklif_create']);

        $routes->get('cari_detay/(:any)', 'TikoERP\Invoice::cariHesap/$1', ['filter' => 'modulePermission', 'as' => 'tportal.faturalar.cariHesap']);


        $routes->get('UrunEskiFiyatlar/(:any)', 'TikoERP\Invoice::UrunEskiFiyatlar/$1', ['as' => 'tportal.faturalar.UrunEskiFiyatlar']);

        

    });



    $routes->group('irsaliye',  function($routes){
        $routes->get('list/(:any)', 'TikoERP\Irsaliye::list/$1', [ 'as' => 'tportal.irsaliyeler.list']);
        $routes->get('detail/(:any)', 'TikoERP\Irsaliye::detail/$1', [ 'as' => 'tportal.irsaliyeler.detail']);
        $routes->match(['get', 'post'], 'getIrsaliyeList/(:any)', 'TikoERP\Irsaliye::getIrsaliyeList/$1', ['as' => 'tportal.irsaliyeler.getIrsaliyeList']);

    });


    $routes->post('getBarcode', 'TikoERP\Production::getBarcode', ['as' => 'tportal.getBarcode']);
    $routes->post('getKutular', 'TikoERP\Home::kutular', ['as' => 'tportal.kutular']);
    $routes->get('getBarcode', 'TikoERP\Production::getBarcode', ['as' => 'tportal.getBarcode']);



    $routes->group('offer',  function($routes){
        $routes->get('list/(:any)', 'TikoERP\Offer::list/$1', ['filter' => 'modulePermission', 'as' => 'tportal.teklifler.list']);
        $routes->match(['get', 'post'], 'create', 'TikoERP\Offer::create', ['filter' => 'modulePermission', 'as' => 'tportal.teklifler.create']);
        $routes->match(['get', 'post'], 'edit/(:any)', 'TikoERP\Offer::edit/$1', ['filter' => 'modulePermission', 'as' => 'tportal.teklifler.edit']);
        $routes->get('detail', 'TikoERP\Offer::detail', ['filter' => 'modulePermission', 'as' => 'tportal.teklifler.detail.null']);
        $routes->get('detail/(:any)', 'TikoERP\Offer::detail/$1', ['filter' => 'modulePermission','as' => 'tportal.teklifler.detail']);
        $routes->match(['get', 'post'], 'setOfferStatus', 'TikoERP\Offer::setOfferStatus', ['as' => 'tportal.teklifler.setOfferStatus']);
        $routes->match(['get', 'post'], 'getOfferList/(:any)', 'TikoERP\Offer::getOfferList/$1', ['filter' => 'modulePermission','as' => 'tportal.teklifler.getOfferList']);

        $routes->get('teklifYazdir/(:any)', 'TikoERP\Offer::teklifYazdir/$1', ['filter' => 'modulePermission','as' => 'tportal.teklifler.teklifYazdir']);

        $routes->post('delete/(:any)', 'TikoERP\Offer::delete/$1', ['filter' => 'modulePermission','as' => 'tportal.teklifler.delete']);


        // $routes->get('open', 'TikoERP\Order::detail', ['as' => 'tportal.siparisler.detail.null']);
        // $routes->get('quickOrderPrint/(:any)', 'TikoERP\Order::quickOrderPrint/$1', ['as' => 'tportal.siparisler.quickOrderPrint']);
    });


 
    $routes->group('order',  function($routes){


        $routes->get('sevkListesi', 'TikoERP\Order::sevkListesi', ['as' => 'tportal.siparisler.sevkListesi']);
        $routes->post('toplandiGuncelle', 'TikoERP\Order::toplandiGuncelle', ['as' => 'tportal.siparisler.toplandiGuncelle']);


        $routes->get('raporlar', 'TikoERP\Order::raporlar', ['as' => 'tportal.siparisler.raporlar']);
        $routes->match(['get', 'post'],'getReportData', 'TikoERP\Order::getReportData', ['as' => 'tportal.siparisler.getReportData']);
        $routes->get('list/(:any)', 'TikoERP\Order::list/$1', ['filter' => 'modulePermission', 'as' => 'tportal.siparisler.list']);
        $routes->match(['get', 'post'], 'create', 'TikoERP\Order::create', ['filter' => 'modulePermission', 'as' => 'tportal.siparisler.create']);
        $routes->match(['get', 'post'], 'edit/(:any)', 'TikoERP\Order::edit/$1', ['filter' => 'modulePermission', 'as' => 'tportal.siparisler.edit']);
        $routes->get('detail', 'TikoERP\Order::detail', ['filter' => 'modulePermission', 'as' => 'tportal.siparisler.detail.null']);
        $routes->get('detail/(:any)', 'TikoERP\Order::detail/$1', ['filter' => 'modulePermission', 'as' => 'tportal.siparisler.detail']);
        $routes->get('order-movements/(:any)', 'TikoERP\Order::orderMovements/$1', ['filter' => 'modulePermission', 'as' => 'tportal.siparisler.orderMovements']);
        $routes->get('loglar/(:any)', 'TikoERP\Order::loglar/$1', ['filter' => 'modulePermission', 'as' => 'tportal.siparisler.loglar']);

        $routes->match(['get', 'post'], 'setOrderStatus', 'TikoERP\Order::setOrderStatus', ['as' => 'tportal.siparisler.setOrderStatus']);
        $routes->post('searchCariler', 'TikoERP\Order::searchCariler', ['as' => 'tportal.siparisler.searchCariler']);
        $routes->post('getCariDetails', 'TikoERP\Order::getCariDetails', ['as' => 'tportal.siparisler.getCariDetails']);
        $routes->post('updateOrderCari', 'TikoERP\Order::updateOrderCari', ['as' => 'tportal.siparisler.updateOrderCari']);
        $routes->get('open', 'TikoERP\Order::detail', ['filter' => 'modulePermission','as' => 'tportal.siparisler.detail.null']);
        $routes->get('quickOrderPrint/(:any)', 'TikoERP\Order::quickOrderPrint/$1', ['filter' => 'modulePermission','as' => 'tportal.siparisler.quickOrderPrint']);
        $routes->match(['get', 'post'], 'getOrderList/(:any)', 'TikoERP\Order::getOrderList/$1', ['filter' => 'modulePermission','as' => 'tportal.siparisler.getOrderList']);
        $routes->match(['get', 'post'], 'fabrika_aktar', 'TikoERP\Order::fabrika_aktar', ['filter' => 'modulePermission','as' => 'tportal.siparisler.fabrika_aktar']);
        $routes->match(['get', 'post'], 'sevkEmirleri', 'TikoERP\Order::sevkEmirleri', ['filter' => 'modulePermission','as' => 'tportal.siparisler.sevkEmirleri']);
        $routes->match(['get', 'post'], 'sevkGetir', 'TikoERP\Order::sevkGetir', ['filter' => 'modulePermission','as' => 'tportal.siparisler.sevkGetir']);
        
        
        $routes->get('sevkPrint/(:any)', 'TikoERP\Order::sevkPrint/$1', ['as' => 'tportal.siparisler.sevkPrint']);
        $routes->get('sevkPrints/(:any)', 'TikoERP\Order::sevkPrints/$1', ['as' => 'tportal.siparisler.sevkPrints']);
        $routes->get('sevkPrint_tarih/(:any)', 'TikoERP\Order::sevkPrints_tarih/$1', ['as' => 'tportal.siparisler.sevkPrints_tarih']);
        $routes->get('sevkPrintsv3/(:any)', 'TikoERP\Order::sevkPrintsv3/$1', ['as' => 'tportal.siparisler.sevkPrintsv3']);
        $routes->get('siparisYazdir/(:any)', 'TikoERP\Order::siparisYazdir/$1', ['as' => 'tportal.siparisler.siparisYazdir']);

        $routes->get('sevkSiparisYazdir/(:any)', 'TikoERP\Order::sevkSiparisYazdir/$1', ['as' => 'tportal.siparisler.sevkSiparisYazdir']);
        $routes->get('sevkDetayliGuncelle/(:any)', 'TikoERP\Order::sevkDetayliGuncelle/$1', ['as' => 'tportal.siparisler.sevkDetayliGuncelle']);


        $routes->post('sevkManuelGuncelle', 'TikoERP\Order::sevkManuelGuncelle', ['as' => 'tportal.siparisler.sevkManuelGuncelle']);
        $routes->post('sevkGuncelle', 'TikoERP\Order::sevkGuncelle', ['as' => 'tportal.siparisler.sevkGuncelle']);
        $routes->get('sevk_emirleri', 'TikoERP\Order::sevk_emirleri', ['as' => 'tportal.siparisler.sevk_emirleri']);
        $routes->get('sevk_emirleri/(:any)', 'TikoERP\Order::sevk_emirleri/$1', ['as' => 'tportal.siparisler.sevk_emirlerim']);
        $routes->get('urunleri_esle', 'TikoERP\Order::urunleri_esle', ['filter' => 'modulePermission', 'as' => 'tportal.siparisler.urunleri_esle']);
        $routes->get('eslesen_urunler', 'TikoERP\Order::eslesen_urunler', ['filter' => 'modulePermission','as' => 'tportal.siparisler.eslesen_urunler']);
        $routes->post('urun_guncelle', 'TikoERP\Order::urun_guncelle', ['filter' => 'modulePermission','as' => 'tportal.siparisler.urun_guncelle']);
        $routes->post('eslesen_getir', 'TikoERP\Order::eslesen_getir', ['filter' => 'modulePermission','as' => 'tportal.siparisler.eslesen_getir']);
        $routes->post('eslesme_guncelle', 'TikoERP\Order::eslesme_guncelle', ['filter' => 'modulePermission','as' => 'tportal.siparisler.eslesme_guncelle']);

        

        $routes->get('json', 'TikoERP\Order::json/$1', ['as' => 'tportal.siparisler.json']);



    });

    $routes->group('cari',  function($routes){
        $routes->get('tekrarEdenKayitlar', 'TikoERP\Cari::tekrarEdenKayitlar', ['as' => 'tportal.cariler.tekrarEdenKayitlar']);
        $routes->get('vknBirlesimModal', 'TikoERP\Cari::vknBirlesimModal', ['filter' => 'modulePermission','as' => 'tportal.cariler.vknBirlesimModal']);
        $routes->post('getVknBirlesimDetay', 'TikoERP\Cari::getVknBirlesimDetay', ['filter' => 'modulePermission','as' => 'tportal.cariler.getVknBirlesimDetay']);
        $routes->post('vknBirlesimYap', 'TikoERP\Cari::vknBirlesimYap', ['filter' => 'modulePermission','as' => 'tportal.cariler.vknBirlesimYap']);
        $routes->get('list/(:any)', 'TikoERP\Cari::list/$1', ['filter' => 'modulePermission','as' => 'tportal.cariler.list']);
        $routes->get('detail', 'TikoERP\Cari::detail', ['filter' => 'modulePermission','as' => 'tportal.cariler.detail.null']);
        $routes->get('detail/(:any)', 'TikoERP\Cari::detail/$1', ['filter' => 'modulePermission','as' => 'tportal.cariler.detail']);
        $routes->match(['get', 'post'], 'create', 'TikoERP\Cari::create', ['filter' => 'modulePermission','as' => 'tportal.cariler.create']);
        $routes->match(['get', 'post'], 'edit/(:any)', 'TikoERP\Cari::edit/$1', ['filter' => 'modulePermission','as' => 'tportal.cariler.edit']);
        $routes->match(['get', 'post'], 'delete/(:any)', 'TikoERP\Cari::delete/$1', ['filter' => 'modulePermission','as' => 'tportal.cariler.delete']);

        $routes->match(['get', 'post'], 'getcustomers/(:any)', 'TikoERP\Cari::getCustomers/$1', ['as' => 'tportal.cariler.getCustomers']);
        $routes->post('checkCustomerVknInfo', 'TikoERP\Cari::checkCustomerVknInfo', ['as' => 'tportal.cariler.checkCustomerVknInfo']);
        $routes->post('getCariById', 'TikoERP\Cari::getCariById', ['as' => 'tportal.cariler.getCariById']);
        $routes->match(['get', 'post'], 'getCariMovement/(:any)', 'TikoERP\Cari::getCariMovement/$1', ['filter' => 'modulePermission','as' => 'tportal.cariler.getCariMovement']);

        $routes->get('address/(:any)', 'TikoERP\Address::list/$1', ['as' => 'tportal.cariler.address']);
        $routes->match(['get', 'post'], 'create-address/(:any)', 'TikoERP\Address::create/$1', ['as' => 'tportal.cariler.address_create']);
        $routes->match(['get', 'post'], 'delete-address', 'TikoERP\Address::delete', ['as' => 'tportal.cariler.address_delete']);
        $routes->match(['get', 'post'], 'edit-address', 'TikoERP\Address::edit', ['as' => 'tportal.cariler.address_edit']);
        $routes->match(['get', 'post'], 'edit-address/default', 'TikoERP\Address::editDefault', ['as' => 'tportal.cariler.address_edit.default']);

        $routes->get('cari_user/(:any)', 'TikoERP\CariUser::list/$1', ['as' => 'tportal.cariler.user']);
        $routes->match(['get', 'post'], 'create-cari-user/(:any)', 'TikoERP\CariUser::create/$1', ['as' => 'tportal.cariler.user_create']);
        $routes->match(['get', 'post'], 'delete-cari-user', 'TikoERP\CariUser::delete', ['as' => 'tportal.cariler.user_delete']);
        $routes->match(['get', 'post'], 'edit-cari-user', 'TikoERP\CariUser::edit', ['as' => 'tportal.cariler.user_edit']);

        $routes->match(['get', 'post'], 'payment-or-collection-page/create', 'TikoERP\Cari::createPaymentOrCollectionPage', ['as' => 'tportal.cariler.payment_or_collection_create_page']);
        
        $routes->get('payment-or-collection/create/(:any)', 'TikoERP\Cari::createPaymentOrCollection/$1', ['as' => 'tportal.cariler.payment_or_collection_create']);
        $routes->match(['get', 'post'], 'payment-or-collection/store/(:any)', 'TikoERP\Cari::storePaymentOrCollection/$1', ['as' => 'tportal.cariler.payment_or_collection_store']);
        $routes->match(['get', 'post'], 'payment-or-collection/edit/(:any)', 'TikoERP\Cari::storePaymentOrCollectionEdit/$1', ['as' => 'tportal.cariler.payment_or_collection_edit']);
        $routes->match(['get', 'post'], 'payment-or-collection/delete/(:any)', 'TikoERP\Cari::deletePaymentOrCollectionEdit/$1', ['as' => 'tportal.cariler.payment_or_collection_delete']);

        $routes->get('financial-movements/(:any)', 'TikoERP\Cari::financialMovements/$1', ['as' => 'tportal.cariler.financial_movements']);

        $routes->get('financial-movements/(:any)/(:any)', 'TikoERP\Cari::financialMovements/$1/$2', ['as' => 'tportal.cariler.financial_movements']);

        $routes->get('offer-movements/(:any)', 'TikoERP\Cari::offerMovements/$1', ['as' => 'tportal.cariler.offer_movements']);


        $routes->match(['get', 'post'], 'quick_sale_order/detail/(:any)', 'TikoERP\Cari::quickDetailSaleOrder/$1', ['as' => 'tportal.cari.quick_sale_order.detail']);

       
        $routes->match(['get', 'post'], 'sale_order/list', 'TikoERP\Cari::listSaleOrder', ['as' => 'tportal.cari.sale_order_list']);
        $routes->match(['get', 'post'], 'sale_order/detail', 'TikoERP\Cari::detailSaleOrder', ['as' => 'tportal.cari.sale_order.detail.null']);
        $routes->match(['get', 'post'], 'sale_order/detail/(:any)', 'TikoERP\Cari::detailSaleOrder/$1', ['as' => 'tportal.cari.sale_order.detail']);
        $routes->match(['get', 'post'], 'sale_order/create/(:any)', 'TikoERP\Cari::createSaleOrder/$1', ['as' => 'tportal.cari.sale_order_create']);
        $routes->match(['get', 'post'], 'supplier_return/create/(:any)', 'TikoERP\Cari::createSupplierReturn/$1', ['as' => 'tportal.cari.supplier_return_create']);
        $routes->match(['get', 'post'], 'sale_order/store_iade', 'TikoERP\Cari::storeSaleOrderIade', ['as' => 'tportal.cari.sale_order_store_iade']);
        $routes->match(['get', 'post'], 'sale_order/store', 'TikoERP\Cari::storeSaleOrder', ['as' => 'tportal.cari.sale_order_store']);
        $routes->match(['get', 'post'], 'sale_order/return', 'TikoERP\Cari::returnSaleOrder', ['as' => 'tportal.cari.sale_order_return']);
        $routes->match(['get', 'post'], 'sale_order_price/return', 'TikoERP\Cari::PriceSaleOrder', ['as' => 'tportal.cari.sale_order_price']);
        $routes->match(['get', 'post'], 'sale_order/return-delete', 'TikoERP\Cari::deleteReturnSaleOrder', ['as' => 'tportal.cari.return_sale_order_delete']);
        $routes->match(['get', 'post'], 'sale_order/delete', 'TikoERP\Cari::deleteSaleOrder', ['as' => 'tportal.cari.sale_order_delete']);
        $routes->match(['get', 'post'], 'sale_order/check_barcode', 'TikoERP\Cari::checkBarcode', ['as' => 'tportal.cari.sale_order.check_barcode']);
        $routes->match(['get', 'post'], 'sale_order/check_barcode_iade', 'TikoERP\Cari::checkBarcodeIade', ['as' => 'tportal.cari.sale_order.check_barcode_iade']);

        $routes->match(['get', 'post'], 'searchCustomer', 'TikoERP\Cari::detailedSearchCustomer', ['as' => 'tportal.cari.detailed_search']);
        $routes->match(['get', 'post'], 'searchTedarik', 'TikoERP\Cari::detailedSearchTedarik', ['as' => 'tportal.cari.detailed_search_tedarik']);


        $routes->get('exportExcel', 'TikoERP\Cari::exportExcel', ['as' => 'tportal.cariler.exportExcel']);
        $routes->get('exportDetayliCari/(:any)/(:any)/(:any)', 'TikoERP\Cari::exportDetayliCari/$1/$2/$3', ['as' => 'tportal.cariler.exportDetayliCari']);
        $routes->get('exportDetayliCariFull/(:any)/(:any)/(:any)', 'TikoERP\Cari::exportDetayliCariFull/$1/$2/$3', ['as' => 'tportal.cariler.exportDetayliCariFull']);
        $routes->get('fatura_duzelt', 'TikoERP\Cari::fatura_duzelt', ['as' => 'tportal.cariler.fatura_duzelt']);



        $routes->get('bakiyeHesapla/(:any)', 'TikoERP\Cari::bakiyeHesapla/$1', ['filter' => 'modulePermission', 'as' => 'tportal.faturalar.bakiyeHesapla']);
        $routes->post('bakiyeHesapla/(:any)', 'TikoERP\Cari::bakiyeHesapla/$1', ['filter' => 'modulePermission', 'as' => 'tportal.faturalar.bakiyeHesapla']);


        $routes->get('StokGenelHesapla', 'TikoERP\Cari::StokGenelHesapla', ['filter' => 'modulePermission', 'as' => 'tportal.faturalar.StokGenelHesapla']);
        $routes->get('stokHesapla/(:any)', 'TikoERP\Cari::stokHesapla/$1', ['filter' => 'modulePermission', 'as' => 'tportal.faturalar.stokHesapla']);
        $routes->post('stokHesapla/(:any)', 'TikoERP\Cari::stokHesapla/$1', ['filter' => 'modulePermission', 'as' => 'tportal.faturalar.stokHesapla']);

        

        $routes->get('excel/import'         , 'TikoERP\Cari::excel_upload'          , ['as' => 'tportal.cari.import']);
        $routes->post('excel/func_import'   , 'TikoERP\Cari::func_excel_import'     , ['as' => 'tportal.cari.excel']);
        $routes->post('excel/caribas'   , 'TikoERP\Cari::excelStock'     , ['as' => 'tportal.stocks.caribas']);
        $routes->get('excel/caribas'   , 'TikoERP\Cari::excelStock'     , ['as' => 'tportal.stocks.caribas']);




    });

    $routes->group('financial_account',  function($routes){
        $routes->get('list/(:any)', 'TikoERP\FinancialAccount::list/$1', ['filter' => 'modulePermission','as' => 'tportal.financial_accounts.list']);
        $routes->get('detail', 'TikoERP\FinancialAccount::detail', ['filter' => 'modulePermission','as' => 'tportal.financial_accounts.detail.null']);
        $routes->get('detail/(:any)', 'TikoERP\FinancialAccount::detail/$1', ['filter' => 'modulePermission','as' => 'tportal.financial_accounts.detail']);
        $routes->match(['get', 'post'], 'create', 'TikoERP\FinancialAccount::create', ['filter' => 'modulePermission','as' => 'tportal.financial_accounts.create']);
        $routes->match(['get', 'post'], 'edit/(:any)', 'TikoERP\FinancialAccount::edit/$1', ['filter' => 'modulePermission','as' => 'tportal.financial_accounts.edit']);

        $routes->match(['get', 'post'], 'listLoadCari', 'TikoERP\FinancialAccount::listLoadCari', ['as' => 'tportal.financial_accounts.list_load_cari']);
        $routes->match(['get', 'post'], 'listLoadFinancialAccount', 'TikoERP\FinancialAccount::listLoadFinancialAccount', ['as' => 'tportal.financial_accounts.list_load_financial_account']);
        $routes->get('payment-or-collection/create/(:any)', 'TikoERP\FinancialAccount::createTransaction/$1', ['as' => 'tportal.financial_accounts.payment_or_collection_create']);
        $routes->match(['get', 'post'], 'payment-or-collection/store/(:any)', 'TikoERP\FinancialAccount::storeTransaction/$1', ['as' => 'tportal.financial_accounts.payment_or_collection_store']);
        $routes->get('financial-movements/(:any)', 'TikoERP\FinancialAccount::financialMovements/$1', ['as' => 'tportal.financial_accounts.financial_movements']);

        $routes->match(['get', 'post'], 'delete/(:any)', 'TikoERP\FinancialAccount::delete/$1', ['filter' => 'modulePermission','as' => 'tportal.financial_accounts.delete']);

    });

    $routes->group('shipment',  function($routes){
        $routes->get('list/(:any)', 'TikoERP\Shipment::list/$1', ['filter' => 'modulePermission','as' => 'tportal.shipment.list']);
        $routes->get('detail', 'TikoERP\Shipment::detail', ['filter' => 'modulePermission','as' => 'tportal.shipment.detail.null']);
        $routes->get('detail/(:any)', 'TikoERP\Shipment::detail/$1', ['filter' => 'modulePermission','as' => 'tportal.shipment.detail']);

        $routes->match(['get', 'post'], 'create', 'TikoERP\Shipment::create', ['filter' => 'modulePermission','as' => 'tportal.shipment.create']);
        $routes->match(['get', 'post'], 'shipment_item/add', 'TikoERP\Shipment::addShipmentItem', ['as' => 'tportal.shipment.shipment_item.add']);
        $routes->match(['get', 'post'], 'shipment_item/remove', 'TikoERP\Shipment::removeShipmentItem', ['as' => 'tportal.shipment.shipment_item.remove']);
        $routes->match(['get', 'post'], 'shipment_item/receive', 'TikoERP\Shipment::receiveShipmentItem', ['as' => 'tportal.shipment.shipment_item.receive']);
        $routes->match(['get', 'post'], 'shipment_item/cancel-receive', 'TikoERP\Shipment::cancelReceiveShipmentItem', ['as' => 'tportal.shipment.shipment_item.cancel_receive']);
        $routes->match(['get', 'post'], 'check/before-departure', 'TikoERP\Shipment::checkBeforeDeparture', ['as' => 'tportal.shipment.check.before_departure']);
        $routes->match(['get', 'post'], 'check/before-arrival', 'TikoERP\Shipment::checkBeforeArrival', ['as' => 'tportal.shipment.check.before_arrival']);
        $routes->match(['get', 'post'], 'approve/departure', 'TikoERP\Shipment::approveDeparture', ['as' => 'tportal.shipment.approve.departure']);
        $routes->match(['get', 'post'], 'approve/arrival', 'TikoERP\Shipment::approveArrival', ['as' => 'tportal.shipment.approve.arrival']);
        $routes->match(['get', 'post'], 'stock/list', 'TikoERP\Shipment::getStockItemsByWarehouse', ['as' => 'tportal.shipment.stock.list']);
    });

    $routes->group('production',  function($routes){
        $routes->get('list', 'TikoERP\Production::list', ['filter' => 'modulePermission','as' => 'tportal.uretim.list']);
        $routes->get('open', 'TikoERP\Production::openlist', ['filter' => 'modulePermission','as' => 'tportal.uretim.openlist']);
        $routes->get('close', 'TikoERP\Production::closelist', ['filter' => 'modulePermission','as' => 'tportal.uretim.closelist']);
        $routes->get('detail', 'TikoERP\Production::detail', ['filter' => 'modulePermission','as' => 'tportal.uretim.detail.null']);
        $routes->get('detail/(:any)/(:any)', 'TikoERP\Production::detail/$1/$2', ['filter' => 'modulePermission','as' => 'tportal.uretim.detail']);
        $routes->get('orderList', 'TikoERP\Production::orderList', ['filter' => 'modulePermission','as' => 'tportal.uretim.orderlist']);
        $routes->post('orderListDetail', 'TikoERP\Production::getOrderDetail', ['filter' => 'modulePermission','as' => 'tportal.uretim.getOrderDetail']);
        $routes->post('operationDurum', 'TikoERP\Production::operationDurum', ['as' => 'tportal.uretim.operationDurum']);
        $routes->post('operationDurumDevam', 'TikoERP\Production::operationDurumDevam', ['as' => 'tportal.uretim.operationDurumDevam']);

        $routes->match(['get', 'post'], 'create', 'TikoERP\Production::create', ['as' => 'tportal.uretim.create']);
        $routes->match(['get', 'post'], 'uretimOlustur', 'TikoERP\Production::uretimOlustur', ['as' => 'tportal.uretim.uretimOlustur']);

        $routes->match(['get', 'post'], 'delete/(:any)', 'TikoERP\Production::uretimSil/$1', ['as' => 'tportal.uretim.uretimSil']);
        
        
        $routes->post('kutuyuBosalt', 'TikoERP\Production::kutuyuBosalt', ['as' => 'tportal.uretim.kutuyuBosalt']);
        $routes->post('getOperationRow', 'TikoERP\Production::getOperationRow', ['as' => 'tportal.uretim.getOperationRow']);
        $routes->post('getOperationRowislem', 'TikoERP\Production::getOperationRowislem', ['as' => 'tportal.uretim.getOperationRowislem']);
        $routes->post('getOperationRowislemLazer', 'TikoERP\Production::getOperationRowislemLazer', ['as' => 'tportal.uretim.getOperationRowislemLazer']);
        $routes->post('getOperationRowislemLazerTamamla', 'TikoERP\Production::getOperationRowislemLazerTamamla', ['as' => 'tportal.uretim.getOperationRowislemLazerTamamla']);
        $routes->post('getOperationRowislemGenelTamamla', 'TikoERP\Production::getOperationRowislemGenelTamamla', ['as' => 'tportal.uretim.getOperationRowislemGenelTamamla']);
       
       
    });

    $routes->group('stock',  function($routes){


        $routes->get('uruneslestirmeleri', 'TikoERP\Stock::uruneslestirmeleri', ['as' => 'tportal.stocks.uruneslestirmeleri']);
        $routes->get('tekrarlananlar', 'TikoERP\Stock::tekrarlananlar', ['as' => 'tportal.stocks.tekrarlananlar']);


        $routes->get('maliyet-hesapla/(:any)', 'TikoERP\Stock::maliyetHesapla/$1', ['as' => 'tportal.stocks.maliyet_hesapla']);

        $routes->get('excel/stock', 'TikoERP\Stock::getExcelStock', ['as' => 'tportal.stocks.excel_stock']);

        $routes->get('list/(:any)', 'TikoERP\Stock::list/$1', ['filter' => 'modulePermission','as' => 'tportal.stocks.list']);
        $routes->match(['get', 'post'], 'list-load/(:any)', 'TikoERP\Stock::listLoad/$1', ['filter' => 'modulePermission','as' => 'tportal.stocks.list_load']);
        $routes->match(['get', 'post'], 'list-load-by-type', 'TikoERP\Stock::listLoadByType', ['filter' => 'modulePermission','as' => 'tportal.stocks.list_load_by_type']);

        $routes->match(['get', 'post'], 'searchStock', 'TikoERP\Stock::detailedSearchforStock', ['as' => 'tportal.stocks.detailed_search_stock']);
        $routes->match(['get', 'post'], 'search', 'TikoERP\Stock::detailedSearch', ['as' => 'tportal.stocks.detailed_search']);

        //for datatable
        $routes->match(['get', 'post'], 'getStock/(:any)', 'TikoERP\Stock::getStock/$1', ['as' => 'tportal.stocks.getStock']);
        $routes->post('getStockVariant', 'TikoERP\Stock::getStockVariant', ['as' => 'tportal.stocks.getStockVariant']);
        $routes->match(['get', 'post'], 'getSubStock/(:any)', 'TikoERP\Stock::getSubStock/$1', ['as' => 'tportal.stocks.getSubStock']);
        $routes->match(['get', 'post'], 'getSubStockDatatable/(:any)', 'TikoERP\Stock::getSubStockDatatable/$1', ['as' => 'tportal.stocks.getSubStockDatatable']);

        $routes->get('detail', 'TikoERP\Stock::detail', ['filter' => 'modulePermission','as' => 'tportal.stocks.detail.null']);
        $routes->get('detail/(:any)', 'TikoERP\Stock::detail/$1', ['filter' => 'modulePermission','as' => 'tportal.stocks.detail']);
        $routes->get('load-single-item/(:any)', 'TikoERP\Stock::loadSingleItem/$1', ['as' => 'tportal.stocks.load_single_item']);

        $routes->match(['get', 'post'], 'create', 'TikoERP\Stock::create', ['filter' => 'modulePermission','as' => 'tportal.stocks.create']);
        $routes->match(['get', 'post'], 'edit/(:any)', 'TikoERP\Stock::edit/$1', ['filter' => 'modulePermission','as' => 'tportal.stocks.edit']);
        $routes->match(['get', 'post'], 'deleteBefore/(:any)', 'TikoERP\Stock::deleteBefore/$1', ['as' => 'tportal.stocks.deleteBefore']);
        $routes->match(['get', 'post'], 'delete/(:any)', 'TikoERP\Stock::delete/$1', ['as' => 'tportal.stocks.delete']);
        $routes->get('trash/(:any)', 'TikoERP\Stock::trash/$1', ['as' => 'tportal.stocks.trash']);
        
        $routes->get('property/(:any)', 'TikoERP\Stock::editStockProperty/$1', ['as' => 'tportal.stocks.property']);

        $routes->get('gallery/(:any)', 'TikoERP\Stock::listStockGallery/$1', ['filter' => 'modulePermission','as' => 'tportal.stocks.gallery']);
        $routes->match(['get', 'post'], 'create-gallery/(:any)', 'TikoERP\Stock::uploadStockGallery/$1', ['as' => 'tportal.stocks.gallery_create']);
        $routes->match(['get', 'post'], 'delete-gallery', 'TikoERP\Stock::deleteStockGallery', ['as' => 'tportal.stocks.gallery_delete']);
        $routes->match(['get', 'post'], 'edit-gallery', 'TikoERP\Stock::editStockGallery', ['as' => 'tportal.stocks.gallery_edit']);
        $routes->match(['get', 'post'], 'edit-gallery/status', 'TikoERP\Stock::editStockGalleryStatus', ['as' => 'tportal.stocks.gallery_edit.status']);
        $routes->match(['get', 'post'], 'edit-gallery/default', 'TikoERP\Stock::editStockGalleryDefault', ['as' => 'tportal.stocks.gallery_edit.default']);

        $routes->get('operations/(:any)', 'TikoERP\Stock::listStockOperation/$1', ['as' => 'tportal.stocks.operations']);
        $routes->match(['get', 'post'], 'create-operation/(:any)', 'TikoERP\Stock::createStockOperation/$1', ['as' => 'tportal.stocks.operation_create']);
        $routes->match(['get', 'post'], 'edit-operation', 'TikoERP\Stock::editStockOperation', ['as' => 'tportal.stocks.operation_edit']);
        $routes->match(['get', 'post'], 'delete-operation', 'TikoERP\Stock::deleteStockOperation', ['as' => 'tportal.stocks.operation_delete']);
        $routes->get('contents/(:any)', 'TikoERP\Stock::listStockContent/$1', ['as' => 'tportal.stocks.contents']);
        $routes->match(['get', 'post'], 'create-content', 'TikoERP\Stock::createStockContent', ['as' => 'tportal.stocks.content_create']);
        $routes->match(['get', 'post'], 'edit-content', 'TikoERP\Stock::editStockContent', ['as' => 'tportal.stocks.content_edit']);
        $routes->match(['get', 'post'], 'delete-content', 'TikoERP\Stock::deleteStockContent', ['as' => 'tportal.stocks.content_delete']);
        

        $routes->post('get-operations', 'TikoERP\Stock::getStockOperations', ['as' => 'tportal.stocks.get_operations']);
        $routes->match(['get', 'post'], 'copy-operation/(:any)', 'TikoERP\Stock::copyStockOperation/$1', ['as' => 'tportal.stocks.copy_operations']);

        $routes->post('get-recipes', 'TikoERP\Stock::getStockRecipes', ['as' => 'tportal.stocks.get_recipes']);
        $routes->match(['get', 'post'], 'copy-recipe/(:any)', 'TikoERP\Stock::copyStockRecipe/$1', ['as' => 'tportal.stocks.copy_recipes']);

        $routes->get('stok_excel', 'TikoERP\Stock::stok_excel', ['as' => 'tportal.stocks.stok_excel']);
        $routes->get('stok_gruplama', 'TikoERP\Stock::stok_gruplama', ['as' => 'tportal.stocks.stok_gruplama']);
        $routes->post('get_available_products', 'TikoERP\Stock::get_available_products', ['as' => 'tportal.stocks.get_available_products']);
        $routes->post('add_to_group', 'TikoERP\Stock::add_to_group', ['as' => 'tportal.stocks.add_to_group']);
        $routes->get('grup_ve_dopigo', 'TikoERP\Stock::grup_ve_dopigo', ['as' => 'tportal.stocks.grup_ve_dopigo']);

        $routes->post("gruba_yeni_eleman_ekle_dopigo_degistir", "TikoERP\Stock::gruba_yeni_eleman_ekle_dopigo_degistir", ['as' => 'tportal.stocks.gruba_yeni_eleman_ekle_dopigo_degistir']);


        $routes->post('check_dopigo_match', 'TikoERP\Stock::check_dopigo_match', ['as' => 'tportal.stocks.check_dopigo_match']);
        $routes->post('update_dopigo_match', 'TikoERP\Stock::update_dopigo_match', ['as' => 'tportal.stocks.update_dopigo_match']);
        $routes->get('stok_gruplama_detay/(:any)', 'TikoERP\Stock::stok_gruplama_detay/$1', ['as' => 'tportal.stocks.stok_gruplama_detay']);
        $routes->get('stok_barkodlar/(:any)', 'TikoERP\Stock::stok_barkodlar/$1', ['as' => 'tportal.stocks.stok_barkodlar']);
        $routes->get('stok_barkodlar_aktif/(:any)', 'TikoERP\Stock::stok_barkodlar_aktif/$1', ['as' => 'tportal.stocks.stok_barkodlar_aktif']);
        $routes->post('ozel_func_excel_import'   , 'TikoERP\Stock::ozel_func_excel_import'     , ['as' => 'tportal.stocks.ozel_func_excel_import']);


        //for datatable
        $routes->get('substocksDatatable', 'TikoERP\Stock::listStockSubstocksAllDatatable', ['as' => 'tportal.stocks.listStockSubstocksAllDatatable']);
        $routes->get('substocks', 'TikoERP\Stock::listStockSubstocksAll', ['as' => 'tportal.stocks.substocksAll']);

        $routes->get('substocks/(:any)', 'TikoERP\Stock::listStockSubstocks/$1', ['as' => 'tportal.stocks.substocks']);
        $routes->match(['get', 'post'], 'create-substock/(:any)', 'TikoERP\Stock::createStockSubstock/$1', ['as' => 'tportal.stocks.substock_create']);
        $routes->match(['get', 'post'], 'delete-substock', 'TikoERP\Stock::deleteStockSubstock', ['as' => 'tportal.stocks.substock_delete']);
        $routes->match(['get', 'post'], 'create-variant/(:any)', 'TikoERP\Stock::createStockVariant/$1', ['as' => 'tportal.stocks.variant_create']);
        $routes->match(['get', 'post'], 'edit-variant/(:any)', 'TikoERP\Stock::editStockVariant/$1', ['as' => 'tportal.stocks.variant_edit']);
        $routes->match(['get', 'post'], 'delete-variant', 'TikoERP\Stock::deleteStockVariant', ['as' => 'tportal.stocks.variant_delete']);
        $routes->get('create-variant-multiple/(:any)', 'TikoERP\Stock::createStockVariantMultiple/$1', ['as' => 'tportal.stocks.variant_create.multiple']);
        // Toplu Fiyat
        $routes->match(['get', 'post'], 'price-variant-multiple/(:any)', 'TikoERP\Stock::PriceStockVariantGet/$1', ['filter' => 'modulePermission','as' => 'tportal.stocks.variant_price.multiple']);
        $routes->match(['get', 'post'], 'stockVariantGet', 'TikoERP\Stock::stockVariantGet', ['as' => 'tportal.stocks.variant_price.stockVariantGet']);
      
        $routes->post('store-variant-multiple/(:any)', 'TikoERP\Stock::storeStockVariantMultiple/$1', ['filter' => 'modulePermission','as' => 'tportal.stocks.variant_store.multiple']);

        $routes->get('movements/(:any)', 'TikoERP\Stock::listStockMovement/$1', ['filter' => 'modulePermission','as' => 'tportal.stocks.movements']);
        $routes->match(['get', 'post'], 'create-stock-barcode/(:any)', 'TikoERP\Stock::createStockBarcode/$1', ['as' => 'tportal.stocks.stock_barcode_create']);
        $routes->match(['get', 'post'], 'print-stock-barcode', 'TikoERP\Stock::printStockBarcode', ['as' => 'tportal.stocks.stock_barcode_print']);
        $routes->match(['get', 'post'], 'delete-stocks-movements', 'TikoERP\Stock::deleteStockMovement', ['as' => 'tportal.stocks.stock_barcode_delete']);

        $routes->get('stock_package/(:any)', 'TikoERP\Stock::listStockPackage/$1', ['as' => 'tportal.stocks.stock_package_list']);

        $routes->match(['get', 'post'], 'TumUrunler', 'TikoERP\Cari::TumUrunler', ['as' => 'tportal.stocks.TumUrunler']);


        $routes->get('stockBas', 'TikoERP\Stock::stockBas', ['as' => 'tportal.stocks.stockBas']);
        $routes->get('stockBasAna', 'TikoERP\Stock::stockBasAna', ['as' => 'tportal.stocks.stockBasAna']);


        $routes->get('excel/import'                     , 'TikoERP\Stock::excel_upload'              , ['as' => 'tportal.stocks.import']);
        $routes->post('excel/func_import'   , 'TikoERP\Stock::func_excel_import'     , ['as' => 'tportal.stocks.excel']);
        $routes->post('excel/addstock'   , 'TikoERP\Stock::excelStock'     , ['as' => 'tportal.stocks.excelStock']);
        $routes->get('excel/resimler'   , 'TikoERP\Stock::resimler'     , ['as' => 'tportal.stocks.resimler']);


        ## Stok İşlemleri ##
        $routes->get('getBarcode', 'TikoERP\Stock::getBarcode', ['as' => 'tportal.stock.getBarcode']);
        $routes->post('getBarcode', 'TikoERP\Stock::getBarcode', ['as' => 'tportal.stock.getBarcode']);
        $routes->get('getBarcodeSorgulaSatis', 'TikoERP\Stock::getBarcodeSorgulaSatis', ['as' => 'tportal.stock.getBarcodeSorgulaSatis']);
        $routes->post('getBarcodeSorgulaSatis', 'TikoERP\Stock::getBarcodeSorgulaSatis', ['as' => 'tportal.stock.getBarcodeSorgulaSatis']);
        $routes->get('barkodKapat', 'TikoERP\Cari::barkodKapat', ['as' => 'tportal.stock.barkodKapat']);
        $routes->post('barkodKapat', 'TikoERP\Cari::barkodKapat', ['as' => 'tportal.stock.barkodKapat']);


        $routes->get('getBarcodeEkle', 'TikoERP\Stock::getBarcodeEkle', ['as' => 'tportal.stock.getBarcodeEkle']);
        $routes->post('getBarcodeEkle', 'TikoERP\Stock::getBarcodeEkle', ['as' => 'tportal.stock.getBarcodeEkle']);
        $routes->get('barkodEkle', 'TikoERP\Cari::barkodEkle', ['as' => 'tportal.stock.barkodEkle']);
        $routes->post('barkodEkle', 'TikoERP\Cari::barkodEkle', ['as' => 'tportal.stock.barkodEkle']);


        $routes->get('getBarkodDetail', 'TikoERP\Stock::getBarkodDetail', ['as' => 'tportal.stock.getBarkodDetail']);
        $routes->post('getBarkodDetail', 'TikoERP\Stock::getBarkodDetail', ['as' => 'tportal.stock.getBarkodDetail']);

        
        $routes->get('depo_stoklari_say', 'TikoERP\Stock::depo_stoklari_say', ['as' => 'tportal.stocks.depo_stoklari_say']);
        $routes->get('depo_stoklari_ekle', 'TikoERP\Stock::depo_stoklari_ekle', ['as' => 'tportal.stocks.depo_stoklari_ekle']);
        $routes->get('barkod_sorgula', 'TikoERP\Stock::barkod_sorgula', ['as' => 'tportal.stocks.barkod_sorgula']);



        $routes->post('barkod-ekle', 'TikoERP\Stock::barkodEkle', ['as' => 'tportal.stocks.barkod_ekle']);


        $routes->post('maliyet_hesapla_post', 'TikoERP\Stock::ajaxMaliyetKaydet', ['as' => 'tportal.stocks.ajaxMaliyetKaydet']);


        //// BİTİŞ /////

        $routes->group('type', function($routes){
            $routes->get('list', 'TikoERP\Type::list', ['as' => 'tportal.stocks.type']);
            $routes->match(['get', 'post'], 'list-load', 'TikoERP\Type::listLoad', ['as' => 'tportal.stocks.type.list_load']);
            $routes->match(['get', 'post'], 'create', 'TikoERP\Type::create', ['as' => 'tportal.stocks.type.create']);
            $routes->match(['get', 'post'], 'edit', 'TikoERP\Type::edit', ['as' => 'tportal.stocks.type.edit']);
            $routes->match(['get', 'post'], 'edit/status', 'TikoERP\Type::editStatus', ['as' => 'tportal.stocks.type.edit.status']);
            $routes->match(['get', 'post'], 'edit/default', 'TikoERP\Type::editDefault', ['as' => 'tportal.stocks.type.edit.default']);
            $routes->match(['get', 'post'], 'delete', 'TikoERP\Type::delete', ['as' => 'tportal.stocks.type.delete']);
        });




    
        $routes->group('category', function($routes){
            $routes->get('list', 'TikoERP\Category::list', ['as' => 'tportal.stocks.category']);
            $routes->match(['get', 'post'], 'list-load', 'TikoERP\Category::listLoad', ['as' => 'tportal.stocks.category.list_load']);
            $routes->match(['get', 'post'], 'create', 'TikoERP\Category::create', ['as' => 'tportal.stocks.category.create']);
            $routes->match(['get', 'post'], 'edit', 'TikoERP\Category::edit', ['as' => 'tportal.stocks.category.edit']);
            $routes->match(['get', 'post'], 'edit/status', 'TikoERP\Category::editStatus', ['as' => 'tportal.stocks.category.edit.status']);
            $routes->match(['get', 'post'], 'edit/default', 'TikoERP\Category::editDefault', ['as' => 'tportal.stocks.category.edit.default']);
            $routes->match(['get', 'post'], 'delete', 'TikoERP\Category::delete', ['as' => 'tportal.stocks.category.delete']);
            $routes->match(['get', 'post'], 'create/variant-group-category', 'TikoERP\Category::createVariantGroupCategory', ['as' => 'tportal.stocks.category.variant_group_category_create']);
            $routes->match(['get', 'post'], 'delete/variant-group-category', 'TikoERP\Category::deleteVariantGroupCategory', ['as' => 'tportal.stocks.category.variant_group_category_delete']);
        });
    
        $routes->group('unit', function($routes){
            $routes->get('list', 'TikoERP\Unit::list', ['as' => 'tportal.stocks.unit']);
            $routes->match(['get', 'post'], 'list-load', 'TikoERP\Unit::listLoad', ['as' => 'tportal.stocks.unit.list_load']);
            $routes->match(['get', 'post'], 'create', 'TikoERP\Unit::create', ['as' => 'tportal.stocks.unit.create']);
            $routes->match(['get', 'post'], 'edit', 'TikoERP\Unit::edit', ['as' => 'tportal.stocks.unit.edit']);
            $routes->match(['get', 'post'], 'edit/status', 'TikoERP\Unit::editStatus', ['as' => 'tportal.stocks.unit.edit.status']);
            $routes->match(['get', 'post'], 'edit/default', 'TikoERP\Unit::editDefault', ['as' => 'tportal.stocks.unit.edit.default']);
            $routes->match(['get', 'post'], 'delete', 'TikoERP\Unit::delete', ['as' => 'tportal.stocks.unit.delete']);
        });
    
        $routes->group('operation', function($routes){
            $routes->get('list', 'TikoERP\Operation::list', ['as' => 'tportal.stocks.operation']);
            $routes->match(['get', 'post'], 'list-load', 'TikoERP\Operation::listLoad', ['as' => 'tportal.stocks.operation.list_load']);
            $routes->match(['get', 'post'], 'create', 'TikoERP\Operation::create', ['as' => 'tportal.stocks.operation.create']);
            $routes->match(['get', 'post'], 'edit', 'TikoERP\Operation::edit', ['as' => 'tportal.stocks.operation.edit']);
            $routes->match(['get', 'post'], 'edit/status', 'TikoERP\Operation::editStatus', ['as' => 'tportal.stocks.operation.edit.status']);
            $routes->match(['get', 'post'], 'edit/default', 'TikoERP\Operation::editDefault', ['as' => 'tportal.stocks.operation.edit.default']);
            $routes->match(['get', 'post'], 'delete', 'TikoERP\Operation::delete', ['as' => 'tportal.stocks.operation.delete']);


        });

        $routes->group('operation_resource', function($routes){
            $routes->get('list', 'TikoERP\OperationResource::list', ['as' => 'tportal.stocks.operation_resource']);
            $routes->match(['get', 'post'], 'list-load', 'TikoERP\OperationResource::listLoad', ['as' => 'tportal.stocks.operation_resource.list_load']);
            $routes->match(['get', 'post'], 'create', 'TikoERP\OperationResource::create', ['as' => 'tportal.stocks.operation_resource.create']);
            $routes->match(['get', 'post'], 'edit', 'TikoERP\OperationResource::edit', ['as' => 'tportal.stocks.operation_resource.edit']);
            $routes->match(['get', 'post'], 'edit/status', 'TikoERP\OperationResource::editStatus', ['as' => 'tportal.stocks.operation_resource.edit.status']);
            $routes->match(['get', 'post'], 'delete', 'TikoERP\OperationResource::delete', ['as' => 'tportal.stocks.operation_resource.delete']);
        });

        $routes->group('warehouse', function($routes){
            $routes->get('list', 'TikoERP\Warehouse::list', ['as' => 'tportal.stocks.warehouse']);
            $routes->match(['get', 'post'], 'list-load', 'TikoERP\Warehouse::listLoad', ['as' => 'tportal.stocks.warehouse.list_load']);
            $routes->match(['get', 'post'], 'create', 'TikoERP\Warehouse::create', ['as' => 'tportal.stocks.warehouse.create']);
            $routes->match(['get', 'post'], 'edit', 'TikoERP\Warehouse::edit', ['as' => 'tportal.stocks.warehouse.edit']);
            $routes->match(['get', 'post'], 'edit/status', 'TikoERP\Warehouse::editStatus', ['as' => 'tportal.stocks.warehouse.edit.status']);
            $routes->match(['get', 'post'], 'edit/default', 'TikoERP\Warehouse::editDefault', ['as' => 'tportal.stocks.warehouse.edit.default']);
            $routes->match(['get', 'post'], 'delete', 'TikoERP\Warehouse::delete', ['as' => 'tportal.stocks.warehouse.delete']);
        });

        $routes->group('variant_group', function($routes){
            $routes->get('list', 'TikoERP\Variant::list', ['as' => 'tportal.stocks.variant']);
            $routes->match(['get', 'post'], 'list-load', 'TikoERP\Variant::listLoad', ['as' => 'tportal.stocks.variant.list_load']);
            $routes->match(['get', 'post'], 'create', 'TikoERP\Variant::create', ['as' => 'tportal.stocks.variant.create']);
            $routes->match(['get', 'post'], 'edit', 'TikoERP\Variant::edit', ['as' => 'tportal.stocks.variant.edit']);
            $routes->match(['get', 'post'], 'edit/status', 'TikoERP\Variant::editStatus', ['as' => 'tportal.stocks.variant.edit.status']);
            $routes->match(['get', 'post'], 'edit/status_b2b', 'TikoERP\Variant::editStatusB2B', ['as' => 'tportal.stocks.variant.edit.status_b2b']);
            $routes->match(['get', 'post'], 'edit/status_website', 'TikoERP\Variant::editStatusWebsite', ['as' => 'tportal.stocks.variant.edit.status_website']);
            $routes->match(['get', 'post'], 'delete', 'TikoERP\Variant::delete', ['as' => 'tportal.stocks.variant.delete']);
        });

        $routes->group('variant_property', function($routes){
            $routes->get('list', 'TikoERP\Variant::property_list', ['as' => 'tportal.stocks.variant_property']);
            $routes->match(['get', 'post'], 'list-load', 'TikoERP\Variant::property_listLoad', ['as' => 'tportal.stocks.variant_property.list_load']);
            $routes->match(['get', 'post'], 'create', 'TikoERP\Variant::property_create', ['as' => 'tportal.stocks.variant_property.create']);
            $routes->match(['get', 'post'], 'edit', 'TikoERP\Variant::property_edit', ['as' => 'tportal.stocks.variant_property.edit']);
            $routes->match(['get', 'post'], 'delete', 'TikoERP\Variant::property_delete', ['as' => 'tportal.stocks.variant_property.delete']);
        });

            
        $routes->group('altkategoriler', function($routes){
            $routes->get('list', 'TikoERP\AltCategory::list', ['as' => 'tportal.stocks.altkategoriler']);
            $routes->match(['get', 'post'], 'list-load', 'TikoERP\AltCategory::listLoad', ['as' => 'tportal.stocks.altkategoriler.list_load']);
            $routes->match(['get', 'post'], 'create', 'TikoERP\AltCategory::create', ['as' => 'tportal.stocks.altkategoriler.create']);
            $routes->match(['get', 'post'], 'edit', 'TikoERP\AltCategory::edit', ['as' => 'tportal.stocks.altkategoriler.edit']);
            $routes->match(['get', 'post'], 'edit/status', 'TikoERP\AltCategory::editStatus', ['as' => 'tportal.stocks.altkategoriler.edit.status']);
            $routes->match(['get', 'post'], 'delete', 'TikoERP\AltCategory::delete', ['as' => 'tportal.stocks.altkategoriler.delete']);
            $routes->match(['get', 'post'], 'create-gallery/(:any)', 'TikoERP\AltCategory::uploadStockGallery/$1', ['as' => 'tportal.stocks.altkategoriler.gallery_create']);

        });


 




        



    });

    $routes->group('reports',  function($routes){
        $routes->get('daily', 'TikoERP\Report::daily', ['filter' => 'modulePermission','as' => 'tportal.raporlar.gunluk_rapor']);
        $routes->get('daily_datatable/(:any)', 'TikoERP\Report::daily_datatable/$1', ['filter' => 'modulePermission','as' => 'tportal.raporlar.gunluk_rapor_tablo']);
        $routes->get('detayli_satis_raporlarim/(:any)/(:any)/(:any)/(:any)/(:any)', 'TikoERP\Report::detayli_satis_raporlarim/$1/$2/$3/$4/$5', ['filter' => 'modulePermission','as' => 'tportal.raporlar.detayli_satis_raporlarim']);

        $routes->get('outgoing', 'TikoERP\Report::outgoing', ['filter' => 'modulePermission','as' => 'tportal.raporlar.gelir_raporlari']);
        $routes->get('outgoing_datatable', 'TikoERP\Report::outgoing_datatable', ['filter' => 'modulePermission','as' => 'tportal.raporlar.gelir_raporlari_tablo']);

        $routes->get('incoming', 'TikoERP\Report::incoming', ['filter' => 'modulePermission','as' => 'tportal.raporlar.gider_raporlari']);
        $routes->get('incoming_datatable', 'TikoERP\Report::incoming_datatable', ['filter' => 'modulePermission','as' => 'tportal.raporlar.gider_raporlari_tablo']);
        $routes->get('stock_report', 'TikoERP\Report::stock_report', ['as' => 'tportal.raporlar.stock_report']);
        $routes->post('export_excel', 'TikoERP\Report::export_excel', ['as' => 'tportal.raporlar.export_excel']);
        $routes->get('musteri_report', 'TikoERP\Report::musteri_report', ['filter' => 'modulePermission','as' => 'tportal.raporlar.musteri_report']);

        $routes->get('tedarikci_report', 'TikoERP\Report::tedarikci_report', ['filter' => 'modulePermission','as' => 'tportal.raporlar.tedarikci_report']);

        $routes->get('cari_balance_report', 'TikoERP\Report::cari_balance_report', ['filter' => 'modulePermission','as' => 'tportal.raporlar.cari_balance_report']);

        $routes->post('stock_report_ajax', 'TikoERP\Report::stock_report_ajax', ['as' => 'tportal.raporlar.stock_report_ajax']);



        $routes->get('detayli_satis_raporlari_msh', 'TikoERP\Report::detayli_satis_raporlari_msh', ['filter' => 'modulePermission','as' => 'tportal.raporlar.detayli_satis_raporlari_msh']);

        $routes->get('detayli_satis_raporlari_msh/(:any)/(:any)/(:any)/(:any)/(:any)', 'TikoERP\Report::detayli_satis_raporlari_msh/$1/$2/$3/$4/$5', ['filter' => 'modulePermission','as' => 'tportal.raporlar.detayli_satis_raporlari_msh']);

        $routes->get('detayli-odeme-raporlari', 'TikoERP\Report::detayli_odeme_raporlari', ['filter' => 'modulePermission','as' => 'tportal.raporlar.detayli_odeme_raporlari']);
        $routes->get('detayli-odeme-raporlarim/(:any)/(:any)/(:num)/(:num)', 'TikoERP\Report::detayli_odeme_raporlarim/$1/$2/$3/$4', ['filter' => 'modulePermission','as' => 'tportal.raporlar.detayli_odeme_raporlarim']);

        $routes->get('detayli-tahsilat-raporlari', 'TikoERP\Report::detayli_tahsilat_raporlari', ['filter' => 'modulePermission','as' => 'tportal.raporlar.detayli_tahsilat_raporlari']);
        $routes->get('detayli-tahsilat-raporlarim/(:any)/(:any)/(:num)/(:num)', 'TikoERP\Report::detayli_tahsilat_raporlarim/$1/$2/$3/$4', ['filter' => 'modulePermission','as' => 'tportal.raporlar.detayli_tahsilat_raporlarim']);
    });

    $routes->group('setting',  function($routes){
        $routes->get('user_management', 'TikoPortal\User::userList', ['filter' => 'modulePermission','as' => 'tportal.ayarlar.kullanici_yonetimi']);
        $routes->get('user_management_datatable/(:any)', 'TikoPortal\User::user_management_datatable/$1', ['as' => 'tportal.ayarlar.kullanici_yonetimi_tablo']);
        
        $routes->post('store_user_permission', 'TikoPortal\User::storeUserPermission', ['as' => 'tportal.ayarlar.yetkiler.kaydet']);
        $routes->post('get_user_permission', 'TikoPortal\User::getUserPermission', ['as' => 'tportal.ayarlar.yetkiler.get']);

        $routes->post('user_edit', 'TikoPortal\User::userEdit', ['as' => 'tportal.ayarlar.kullanici.duzenle']);
        $routes->post('user_delete', 'TikoPortal\User::userDelete', ['as' => 'tportal.ayarlar.kullanici.sil']);
    });
    $routes->group('giderler',  function($routes){
        $routes->get('list/(:any)', 'TikoERP\Gider::list/$1', ['filter' => 'modulePermission', 'as' => 'tportal.gider.list']);
        $routes->match(['get', 'post'], 'create', 'TikoERP\Gider::create', ['filter' => 'modulePermission', 'as' => 'tportal.gider.create']);
        $routes->match(['get', 'post'], 'edit/(:any)', 'TikoERP\Gider::edit/$1', ['filter' => 'modulePermission', 'as' => 'tportal.gider.edit']);
        $routes->get('detail', 'TikoERP\Gider::detail', ['filter' => 'modulePermission', 'as' => 'tportal.gider.detail.null']);
        $routes->get('detail/(:any)', 'TikoERP\Gider::detail/$1', ['filter' => 'modulePermission','as' => 'tportal.gider.detail']);
        $routes->match(['get', 'post'], 'setOfferStatus', 'TikoERP\Gider::setOfferStatus', ['as' => 'tportal.gider.setOfferStatus']);
        $routes->match(['get', 'post'], 'getOfferList/(:any)', 'TikoERP\Gider::getOfferList/$1', ['filter' => 'modulePermission','as' => 'tportal.gider.getOfferList']);

        $routes->get('teklifYazdir/(:any)', 'TikoERP\Gider::teklifYazdir/$1', ['filter' => 'modulePermission','as' => 'tportal.gider.teklifYazdir']);

        $routes->post('delete/(:any)', 'TikoERP\Gider::delete/$1', ['filter' => 'modulePermission','as' => 'tportal.gider.delete']);
        $routes->post('gider_upload', 'TikoERP\Gider::upload', ['filter' => 'modulePermission','as' => 'tportal.gider.gider_upload']);

        $routes->group('gider_gruplari', function($routes){
            $routes->get('list', 'TikoERP\GiderGrup::list', ['as' => 'tportal.stocks.gider_gruplari']);
            $routes->match(['get', 'post'], 'list-load', 'TikoERP\GiderGrup::listLoad', ['as' => 'tportal.stocks.gider_gruplari.list_load']);
            $routes->match(['get', 'post'], 'create', 'TikoERP\GiderGrup::create', ['as' => 'tportal.stocks.gider_gruplari.create']);
            $routes->match(['get', 'post'], 'edit', 'TikoERP\GiderGrup::edit', ['as' => 'tportal.stocks.gider_gruplari.edit']);
            $routes->match(['get', 'post'], 'edit/status', 'TikoERP\GiderGrup::editStatus', ['as' => 'tportal.stocks.gider_gruplari.edit.status']);
            $routes->match(['get', 'post'], 'delete', 'TikoERP\GiderGrup::delete', ['as' => 'tportal.stocks.gider_gruplari.delete']);
        });

        $routes->group('gider_kategorileri', function($routes){
            $routes->get('list', 'TikoERP\GiderKategori::list', ['as' => 'tportal.stocks.gider_kategorileri']);
            $routes->match(['get', 'post'], 'list-load', 'TikoERP\GiderKategori::listLoad', ['as' => 'tportal.stocks.gider_kategorileri.list_load']);
            $routes->match(['get', 'post'], 'create', 'TikoERP\GiderKategori::create', ['as' => 'tportal.stocks.gider_kategorileri.create']);
            $routes->match(['get', 'post'], 'edit', 'TikoERP\GiderKategori::edit', ['as' => 'tportal.stocks.gider_kategorileri.edit']);
            $routes->match(['get', 'post'], 'edit/status', 'TikoERP\GiderKategori::editStatus', ['as' => 'tportal.stocks.gider_kategorileri.edit.status']);
            $routes->match(['get', 'post'], 'delete', 'TikoERP\GiderKategori::delete', ['as' => 'tportal.stocks.gider_kategorileri.delete']);
        });


       
        


    });
        
    $routes->group('api', function($routes){

        $routes->post('mshb2b', 'TikoERP\MshApi::siparisleriGetir', ['as' => 'tportal.api.msh']);
        $routes->get('msh_urun_kontrol', 'TikoERP\MshApi::UrunKontrolEt', ['as' => 'tportal.api.msh_urun_kontrol']);
        $routes->get('mshb2b', 'TikoERP\MshApi::siparisleriGetir', ['as' => 'tportal.api.msh']);
        $routes->post('dopigo', 'TikoERP\DopigoApi::DopigoSiparis', ['as' => 'tportal.api.dopigo']);
        $routes->get('dopigo', 'TikoERP\DopigoApi::DopigoSiparis', ['as' => 'tportal.api.dopigo']);
        $routes->post('dopigo/order/(:any)', 'TikoERP\DopigoApi::DopigoTekliSiparis/$1', ['as' => 'tportal.api.DopigoTekliSiparis']);
        $routes->get('dopigo/order/(:any)', 'TikoERP\DopigoApi::DopigoTekliSiparis/$1', ['as' => 'tportal.api.DopigoTekliSiparis']);
        

        $routes->post('dopigo_product', 'TikoERP\DopigoApi::DopigoUrunler', ['as' => 'tportal.api.dopigo_product']);
        $routes->get('dopigo_product', 'TikoERP\DopigoApi::DopigoUrunler', ['as' => 'tportal.api.dopigo_product']);
        $routes->get('dopigo_eslesenler', 'TikoERP\DopigoApi::dopigo_eslesenler', ['as' => 'tportal.api.dopigo_eslesenler']);
        $routes->get('dopigo_order_single', 'TikoERP\DopigoApi::DopigoOrderSingle', ['as' => 'tportal.api.DopigoOrderSingle']);
        $routes->post('dopigo_order_single', 'TikoERP\DopigoApi::DopigoOrderSingle', ['as' => 'tportal.api.DopigoOrderSingle']);


        ## Mytech ##
        $routes->post('mytech_get_product', 'TikoERP\Mytech::MytechProducts', ['as' => 'tportal.api.mytech_get_products']);
        $routes->get('mytech_get_product', 'TikoERP\Mytech::MytechProducts', ['as' => 'tportal.api.mytech_get_products']);
        $routes->get('mytech_send_product', 'TikoERP\Mytech::MytechAddProducts', ['as' => 'tportal.api.mytech_send_products']);
        $routes->post('mytech_send_product', 'TikoERP\Mytech::MytechAddProducts', ['as' => 'tportal.api.mytech_send_products']);


        $routes->get('mytechUrunler', 'TikoERP\Mytech::mytechUrunler', ['as' => 'tportal.api.mytechUrunler']);



        ## Mytech Bitiş ##


        $routes->get('mustericek', 'TikoERP\DopigoApi::Musteri', ['as' => 'tportal.api.Musteri']);


        ## APİ İŞLEMLERİ ###


        $routes->get('index', 'Api\FaturaController::index');
        $routes->get('fatura/(:any)', 'Api\FaturaController::fatura/$1', ['as' => 'api_fatura_data']);

        ## Sysmond APİ

     


        ## Sistem 3D 

        $routes->post('sistem3d_get_product', 'TikoERP\Sistem3D::Sistem3DProducts', ['as' => 'tportal.api.sistem3d_get_products']);
        $routes->get('sistem3d_get_product', 'TikoERP\Sistem3D::Sistem3DProducts', ['as' => 'tportal.api.sistem3d_get_products']);
        $routes->get('sistem3d_send_product', 'TikoERP\Sistem3D::Sistem3DAddProducts', ['as' => 'tportal.api.sistem3d_send_products']);
        $routes->post('sistem3d_send_product', 'TikoERP\Sistem3D::Sistem3DAddProducts', ['as' => 'tportal.api.sistem3d_send_products']);
        $routes->get('sistem3d_siparisgetir', 'TikoERP\Sistem3D::siparisleriGetir', ['as' => 'tportal.api.siparisleriGetir']);
        $routes->post('sistem3d_siparisgetir', 'TikoERP\Sistem3D::siparisleriGetir', ['as' => 'tportal.api.siparisleriGetir']);


        ## Artliving

        $routes->get('artliving_send_products', 'TikoERP\Artliving::ArtlivingAddProduct', ['as' => 'tportal.api.artliving_send_products']);
        $routes->post('artliving_send_products', 'TikoERP\Artliving::ArtlivingAddProduct', ['as' => 'tportal.api.artliving_send_products']);
        $routes->get('artliving_siparisgetir', 'TikoERP\Artliving::siparisleriGetir', ['as' => 'tportal.api.siparisleriGetir_art']);
        $routes->post('artliving_siparisgetir', 'TikoERP\Artliving::siparisleriGetir', ['as' => 'tportal.api.siparisleriGetir_art']);



         ## MSH Düğme

         $routes->get('msh_send_products', 'TikoERP\MshApi::msh_send_products', ['as' => 'tportal.api.msh_send_products']);
         $routes->post('msh_send_products', 'TikoERP\MshApi::msh_send_products', ['as' => 'tportal.api.msh_send_products']);

         $routes->get('msh_send_products_new_site', 'TikoERP\MshApi::msh_send_products_new_site', ['as' => 'tportal.api.msh_send_products_new_site']);
         $routes->post('msh_send_products_new_site', 'TikoERP\MshApi::msh_send_products_new_site', ['as' => 'tportal.api.msh_send_products_new_site']);
 

        
     
    });


    $routes->group('checks', ['namespace' => 'App\Controllers\TikoERP'], function($routes) {
        $routes->get('/', 'CheckController::index', ['as' => 'tportal.cekler.index']);
        $routes->get('add', 'CheckController::addCheck', ['as' => 'tportal.cekler.add']);
        $routes->post('add', 'CheckController::addCheck', ['as' => 'tportal.cekler.add']);
        $routes->get('portfolio', 'CheckController::portfolio', ['as' => 'tportal.cekler.portfolio']);
        $routes->get('endorsed', 'CheckController::endorsed', ['as' => 'tportal.cekler.endorsed']);
        $routes->get('endorse/(:num)', 'CheckController::endorse/$1', ['as' => 'tportal.cekler.endorse']);
        $routes->post('endorse/(:num)', 'CheckController::endorse/$1', ['as' => 'tportal.cekler.endorse']);
        $routes->get('transactions/(:num)', 'CheckController::transactions/$1', ['as' => 'tportal.cekler.transactions']);
        $routes->get('mark-as-paid/(:num)', 'CheckController::markAsPaid/$1', ['as' => 'tportal.cekler.markAsPaid']);
        $routes->get('mark-as-bounced/(:num)', 'CheckController::markAsBounced/$1', ['as' => 'tportal.cekler.markAsBounced']);
        $routes->get('print/(:num)', 'CheckController::printCheck/$1', ['as' => 'tportal.cekler.print']);
    });


});

$routes->get('soap', 'TikoERP\DopigoApi::index', ['as' => 'tportal.DopigoSoap.index']);

// Çek İşlemleri Routes

$routes->post('tportal/siparisler/stokKontrol', 'TikoERP\Order::stokKontrol', ['as' => 'tportal.siparisler.stokKontrol']);
$routes->post('tportal/siparisler/stokWhatsappMesaj', 'TikoERP\Order::stokWhatsappMesaj', ['as' => 'tportal.siparisler.stokWhatsappMesaj']);
$routes->get('tportal/siparisler/whatsappMessageTest', 'TikoERP\Order::whatsappMessageTest', ['as' => 'tportal.siparisler.whatsappMessageTest']);

$routes->group('tportal', ['namespace' => 'App\Controllers\TikoERP'], function ($routes) {
    $routes->get('stok-dusum-test/(:num)', 'Order::stokDusumTest/$1');
    $routes->get('stok-giris-test/(:num)', 'Order::stokGirisTest/$1');

});

$routes->group('tportal/siparisler', ['namespace' => 'App\Controllers\TikoERP'], static function ($routes) {
   
    $routes->get('irsaliye', 'Order::irsaliye', ['as' => 'tportal.siparisler.irsaliye']);

});

// İrsaliye Routes
$routes->group('tportal/siparisler', ['namespace' => 'App\Controllers\TikoERP'], function ($routes) {
    $routes->post('irsaliye/create', 'Irsaliye::create');
    $routes->post('irsaliye/irsaliye_kontrol', 'Irsaliye::irsaliye_kontrol');
    $routes->delete('irsaliye/delete/(:num)', 'Irsaliye::delete/$1');
    $routes->get('irsaliye/get/(:num)', 'Irsaliye::getIrsaliye/$1');
    $routes->post('irsaliye/resendSysmond', 'Irsaliye::resendSysmond', ['as' => 'tportal.siparisler.irsaliye.resendSysmond']);
});

$routes->get('tportal/siparisler/gunlukrapor/', 'TikoERP\Order::gunlukrapor', ['as' => 'tportal.siparisler.gunlukrapor']);
$routes->get('tportal/siparisler/gunlukrapor/(:any)/(:any)', 'TikoERP\Order::gunlukrapor/$1/$2', ['as' => 'tportal.siparisler.gunlukrapor']);


$routes->get('api/tikoportal/fatura/imzala/(:num)', 'Api\TikoPortal::fatura_imzala/$1', ['as' => 'tportal.siparisler.imzasizfaturalar']);
$routes->post('api/tikoportal/fatura/imzala/(:num)', 'Api\TikoPortal::fatura_imzala/$1', ['as' => 'tportal.siparisler.imzasizfaturalar']);

$routes->get('api/tikoportal/fatura/alis/status/kontrol', 'Api\TikoPortal::fatura_alis_status_kontrol', ['as' => 'tportal.fatura.alis_status_kontrol']);
$routes->post('api/tikoportal/fatura/alis/status/kontrol', 'Api\TikoPortal::fatura_alis_status_kontrol', ['as' => 'tportal.fatura.alis_status_kontrol']);

$routes->get('api/tikoportal/fatura/satis/status/kontrol', 'Api\TikoPortal::fatura_satis_status_kontrol', ['as' => 'tportal.fatura.satis_status_kontrol']);
$routes->post('api/tikoportal/fatura/satis/status/kontrol', 'Api\TikoPortal::fatura_satis_status_kontrol', ['as' => 'tportal.fatura.satis_status_kontrol']);


$routes->get('api/tikoportal/fatura/duzenle/(:num)', 'Api\TikoPortal::fatura_duzenle/$1', ['as' => 'tportal.siparisler.duzenle']);
$routes->post('api/tikoportal/fatura/duzenle/(:num)', 'Api\TikoPortal::fatura_duzenle/$1', ['as' => 'tportal.siparisler.duzenle']);

$routes->get('api/tikoportal/fatura/sorgula/(:num)', 'Api\TikoPortal::fatura_sorgula/$1', ['as' => 'tportal.fatura.sorgula']);
$routes->post('api/tikoportal/fatura/sorgula/(:num)', 'Api\TikoPortal::fatura_sorgula/$1', ['as' => 'tportal.fatura.sorgula']);

$routes->get('api/tikoportal/fatura/genel/guncelle', 'Api\TikoPortal::fatura_genel_guncelle', ['as' => 'tportal.fatura.genel_guncelle']);
$routes->post('api/tikoportal/fatura/genel/guncelle', 'Api\TikoPortal::fatura_genel_guncelle', ['as' => 'tportal.fatura.genel_guncelle']);

$routes->get('api/tikoportal/fatura/alis/getir', 'Api\TikoPortal::fatura_alis_getir', ['as' => 'tportal.fatura.alis_getir']);
$routes->post('api/tikoportal/fatura/alis/getir', 'Api\TikoPortal::fatura_alis_getir', ['as' => 'tportal.fatura.alis_getir']);

$routes->get('api/tikoportal/fatura/alis/cari/guncelle', 'Api\TikoPortal::alis_fatura_cari_guncelle', ['as' => 'tportal.fatura.alis_cari_guncelle']);
$routes->post('api/tikoportal/fatura/alis/cari/guncelle', 'Api\TikoPortal::alis_fatura_cari_guncelle', ['as' => 'tportal.fatura.alis_cari_guncelle']);

// Palet Etiket Yazdırma
$routes->post('api/tikoportal/palet/etiket/yazdir', 'TikoERP\Home::printEtiket', ['as' => 'tportal.printEtiket']);

$routes->get('sysmond/index', 'Api\Sysmond::index');
$routes->get('sysmond/check', 'Api\Sysmond::stock_and_sysmond');
$routes->get('sysmond/check_raf', 'Api\Sysmond::stock_sysmond_raf');