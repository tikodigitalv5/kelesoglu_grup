<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoERP\SysmondModel; // SysmondModel'i ekledim

use App\Models\TikoERP\CategoryModel;
use App\Models\TikoERP\MoneyUnitModel;
use App\Models\TikoERP\OperationModel;
use App\Models\TikoERP\RecipeItemModel;
use App\Models\TikoERP\StockGalleryModel;
use App\Models\TikoERP\StockModel;
use App\Models\TikoERP\StockOperationModel;
use App\Models\TikoERP\StockRecipeModel;
use App\Models\TikoERP\SubstockModel;
use App\Models\TikoERP\TypeModel;
use App\Models\TikoERP\UnitModel;
use App\Models\TikoERP\SysmondCronModel;
use App\Models\TikoERP\SysmondOnlineModel;
use App\Models\TikoERP\SysmondDepolarModel;
use App\Models\TikoERP\SysmondBarkodlar;
use App\Models\TikoERP\InvoiceOutgoingModel;
use CodeIgniter\I18n\Time;
use Exception;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;
use tidy;
use DateTime;
use \Hermawan\DataTables\DataTable;
use App\Models\TikoERP\IslemModel;

use App\Models\SendModel;


ini_set('memory_limit', '1024M');
ini_set('max_execution_time', "-1");

class TikoPortal extends BaseController
{
    private $sirketID = 56;
    private $ApiKey = 1503279683;
    private $DatabaseConfig;
    private $currentDB;
    private $modelSysmond;
    private $modelSysmondBarkod;
    private $modelSysmondLog;
    private $modelSysmondOnline;
    private $modelStock;
    private $logClass;

    private $erp_session_id;
    protected $sendModel;
    protected $SysmondCronModel;
    private $modelSysmondDepolar;

    private $modelAddress;

    private $modelCari;
    private $modelSubstock;
    private $modelType;
    private $modelUnit;
    private $modelCategory;
    private $modelOperation;
    private $modelStockOperation;
    private $modelStockGallery;
    private $modelStockRecipe;
    private $modelRecipeItem;
    private $modelMoneyUnit;
    private $modelWarehouse;
    private $modelVariantGroup;
    private $modelVariantProperty;
    private $modelStockVariantGroup;
    private $modelStockMovement;
    private $modelStockBarcode;
    private $modelFinancialMovement;
    private $modelInvoice;
    private $modelInvoiceRow;
    private $modelStockWarehouseQuantity;
    private $modelStockPackage;

    private $temp_schema;
    private $cacheList;
    private $modelProduction;

    private $modelProductionRow;

    private $modelProductionOperation;

    private $modelProductionOperationRow;
    private $modalStockExcel;
    private $apiurlSorgulama = "";

    private $orderStok;

    private $modelIslem;
    private $TikoPortalID = 0;
    private $modelSysmondBarkodlar;
    private $modelInvoiceOutgoing;

    private $modelInvoiceStatus;
    private $modelInvoiceOutgoingStatus;

    private $modelFaturaTutar;

    private $modelInvoiceSerial;
    public function __construct()
    {

        $userDatabaseDetail = [
            'hostname' => '78.135.66.90',
            'username' => 'mshus',
            'password' => '2^bHSW9j?rMQ',
            'database' => 'mshdb',
            'DBDriver' => 'MySQLi', // Veritabanı sürücüsünü belirtin (MySQLi, Postgre, vb.)
            'DBPrefix' => '',
            'pConnect' => false,
            'DBDebug'  => (ENVIRONMENT !== 'production'),
            'charset'  => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port'     => 3306,
        ];
        $this->erp_session_id = 5;

        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
        helper('Helpers\formatter_helper');
        helper('Helpers\stock_func_helper');

        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($userDatabaseDetail);

        // SysmondModel'i initialize ediyoruz
        $this->modelFaturaTutar = model($TikoERPModelPath . '\FaturaTutarlarModel', true, $db_connection);
        $this->modelInvoiceStatus = model($TikoERPModelPath . '\InvoiceIncomingStatusModel', true, $db_connection);
        $this->modelInvoiceOutgoingStatus = model($TikoERPModelPath . '\InvoiceOutgoingStatusModel', true, $db_connection);
        $this->modelInvoiceSerial = model($TikoERPModelPath . '\InvoiceSerialModel', true, $db_connection);
        $this->modelSysmond = model($TikoERPModelPath.'\SysmondModel', true, $db_connection);
        $this->modelSysmondBarkod = model($TikoERPModelPath.'\SysmondBarkodModel', true, $db_connection);
        $this->modelSysmondLog = model($TikoERPModelPath.'\SysmondLogModel', true, $db_connection);
        $this->modelSysmondOnline = model($TikoERPModelPath.'\SysmondOnlineModel', true, $db_connection);
        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
        $this->modelSysmondBarkodlar = model($TikoERPModelPath . '\SysmondBarkodlar', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath . '\StockModel', true, $db_connection);
        $this->modelSubstock = model($TikoERPModelPath . '\SubstockModel', true, $db_connection);
        $this->modelType = model($TikoERPModelPath . '\TypeModel', true, $db_connection);
        $this->modelUnit = model($TikoERPModelPath . '\UnitModel', true, $db_connection);
        $this->modelCategory = model($TikoERPModelPath . '\CategoryModel', true, $db_connection);
        $this->modelOperation = model($TikoERPModelPath . '\OperationModel', true, $db_connection);
        $this->modelStockOperation = model($TikoERPModelPath . '\StockOperationModel', true, $db_connection);
        $this->modelStockGallery = model($TikoERPModelPath . '\StockGalleryModel', true, $db_connection);
        $this->modelStockRecipe = model($TikoERPModelPath . '\StockRecipeModel', true, $db_connection);
        $this->modelRecipeItem = model($TikoERPModelPath . '\RecipeItemModel', true, $db_connection);
        $this->modelMoneyUnit = model($TikoERPModelPath . '\MoneyUnitModel', true, $db_connection);
        $this->modelWarehouse = model($TikoERPModelPath . '\WarehouseModel', true, $db_connection);
        $this->modelVariantGroup = model($TikoERPModelPath . '\VariantGroupModel', true, $db_connection);
        $this->modelVariantProperty = model($TikoERPModelPath . '\VariantPropertyModel', true, $db_connection);
        $this->modelStockVariantGroup = model($TikoERPModelPath . '\StockVariantGroupModel', true, $db_connection);
        $this->modelStockMovement = model($TikoERPModelPath . '\StockMovementModel', true, $db_connection);
        $this->modelStockBarcode = model($TikoERPModelPath . '\StockBarcodeModel', true, $db_connection);
        $this->modelFinancialMovement = model($TikoERPModelPath . '\FinancialMovementModel', true, $db_connection);
        $this->modelInvoice = model($TikoERPModelPath . '\InvoiceModel', true, $db_connection);
        $this->modelInvoiceRow = model($TikoERPModelPath . '\InvoiceRowModel', true, $db_connection);
        $this->modelStockWarehouseQuantity = model($TikoERPModelPath . '\StockWarehouseQuantityModel', true, $db_connection);
        $this->modelProductionRow = model($TikoERPModelPath . '\ProductionRowModel', true, $db_connection);
        $this->modelProductionOperation = model($TikoERPModelPath . '\ProductionOperationModel', true, $db_connection);
        $this->modelProductionOperationRow = model($TikoERPModelPath . '\ProductionOperationRowModel', true, $db_connection);
        $this->modalStockExcel = model($TikoERPModelPath . '\StockExcelModel', true, $db_connection);
        $this->SysmondCronModel = model($TikoERPModelPath . '\SysmondCronModel', true, $db_connection);
        $this->orderStok = model($TikoERPModelPath . '\OrderModel', true, $db_connection);
        $this->modelSysmondDepolar = model($TikoERPModelPath . '\SysmondDepolarModel', true, $db_connection);
        $this->modelOperation = model($TikoERPModelPath . '\OperationModel', true, $db_connection);
        $this->logClass = new Log();
        $this->sendModel = new SendModel();
        $this->modelIslem = model($TikoERPModelPath . '\IslemLoglariModel', true, $db_connection);
        $this->modelAddress = model($TikoERPModelPath . '\AddressModel', true, $db_connection);
        $this->modelInvoiceOutgoing = model($TikoERPModelPath . '\InvoiceOutgoingStatusModel', true, $db_connection);

        helper('date');
        helper('text');
        helper('Helpers\barcode_helper');
        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\stock_func_helper');



        $this->TikoPortalID = 940;
        $this->apiurlSorgulama = "212.98.224.209";
    }


    public function tikoPortalDatabase()
    {
       
        $userDatabaseDetail = [
            'hostname' => '78.135.66.89',
            'username' => 'user',
            'password' => 'tiko2010',
            'database' => 'dbmaster',
            'DBDriver' => 'MySQLi', // Veritabanı sürücüsünü belirtin (MySQLi, Postgre, vb.)
            'DBPrefix' => '',
            'pConnect' => false,
            'DBDebug'  => (ENVIRONMENT !== 'production'),
            'charset'  => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port'     => 3306,
        ];

        // Veritabanı bağlantısını oluştur
        return \Config\Database::connect($userDatabaseDetail);

    }

    public function seri_no_sorgula($fatura)
    {
        $tikoDB = $this->tikoPortalDatabase();

        if($fatura["cari_obligation"] == "e-archive"){
            $turu = "earsiv";
        }else{
            $turu = "efatura";
        }
        
        $seriNolar = $tikoDB->table('user_seriler')->where("tur", $turu)->where('user_id', $this->TikoPortalID)->get()->getResult();

        return $seriNolar;
    }

    public function faturaSorgula($fatura_id)
    {
        $fatura = $this->modelInvoice->where('invoice_id', $fatura_id)->where('invoice_no', "#PROFORMA")->first();

        if($fatura){
            $faturaList = [];
            
            $faturaSatirlari = $this->modelInvoiceRow->where('invoice_id', $fatura['invoice_id'])->findAll();
            $faturaMusteri = $this->modelCari->where('cari_id', $fatura['cari_id'])->first();
            $fatura['satirlar'] = $faturaSatirlari;
            $fatura['musteri'] = $faturaMusteri;
            $faturaList[] = $fatura;
            return $this->response->setJSON([
                'status' => true,
                'fatura' => $faturaList
            ]);
           
        } else {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'İmzalanacak fatura bulunamadı'
            ]);
        }
    }


    public function fatura_imzala($fatura_id)
    {
        $fatura = $this->faturaSorgula($fatura_id);
        $responseBody = json_decode($fatura->getJSON(), true);
        
        if($responseBody['status']){
            $fatura = $responseBody['fatura'];
            $fatura = json_encode($fatura);
            $fatura = json_decode($fatura, true);
            $fatura = $fatura[0];
            
          
    
            
            $fatura_portal_ekle = $this->fatura_portal_ekle($fatura);
            $responseData = json_decode($fatura_portal_ekle->getJSON(), true);
            if($responseData['status']){
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Fatura başarıyla eklenmiş'
                ]);
            }else{
                return $this->response->setJSON([
                    'status' => false,
                    'message' => $responseData['message']
                ]);
            }

        } else {
            return $this->response->setJSON([
                'status' => false,
                'message' => $responseBody['message']
            ]);
        }
    }


    public function fatura_duzenle($fatura_id)
    {
        $fatura = $this->faturaSorgula($fatura_id);
        $responseBody = json_decode($fatura->getJSON(), true);
        
        if($responseBody['status']){
            $fatura = $responseBody['fatura'];
            $fatura = json_encode($fatura);
            $fatura = json_decode($fatura, true);
            $fatura = $fatura[0];
            
          
    
            
            $fatura_portal_ekle = $this->fatura_portal_guncelle($fatura);
            $responseData = json_decode($fatura_portal_ekle->getJSON(), true);
            if($responseData['status']){
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Fatura başarıyla güncellendi'
                ]);
            }else{
                return $this->response->setJSON([
                    'status' => false,
                    'message' => $responseData['message']
                ]);
            }

        } else {
            return $this->response->setJSON([
                'status' => false,
                'message' => $responseBody['message']
            ]);
        }
    }


    public function MusteriSorgula($musteri){

        $musBilgileri = $musteri;

        $tikoDB = $this->tikoPortalDatabase();
        $musteri = $tikoDB->table('musteriler')->where('user_id', $this->TikoPortalID)->where('vkn_tc', $musteri["identification_number"])->get()->getResult();
        if($musteri){
            $musterim =  $this->MusteriEkle($musBilgileri);
            return $musterim;
        }else{
           $musterim =  $this->MusteriEkle($musBilgileri);
            return $musterim;
        }

    }

    public function MusteriEkle($musteri)
    {
        $tikoDB = $this->tikoPortalDatabase();
        log_message('info', 'Müşteri Ekleme Çalıştı!');
    

        $musteriler = $this->modelCari->where('cari_id', $musteri["cari_id"])->first();

        if ($musteriler) {
            $existingMusteri = $tikoDB->table('musteriler')
                ->where('user_id', $this->TikoPortalID)
                ->where("earsivden_aktarim_id", $musteri["cari_id"])
                ->get()
                ->getNumRows();

            if ($existingMusteri > 0) {
                $musteriTiko = $tikoDB->table('musteriler')->where('user_id', $this->TikoPortalID)->where('earsivden_aktarim_id', $musteri["cari_id"])->get()->getResult();
                return $musteriTiko;
            }

            $mukellefiyet = 0;
            $sahis = 0;
            try {
                $mukellefiyetSorgu = $this->func_vkn_sorgula(!empty($musteri["identification_number"]) ? $musteri["identification_number"] : $musteri["identification_number"]);

                if (isset($mukellefiyetSorgu['status']) && $mukellefiyetSorgu["status"] == 200) {
                    $mukellefiyet   = $mukellefiyetSorgu["response"]["vknInfo"];
                    $sahis          = (isset($mukellefiyetSorgu['response']['adi']) && $mukellefiyetSorgu['response']['adi'] != null) ? 1 : 0;
                } else {
                    $mukellefiyet = 0;
                    $sahis          = (isset($musteri["name"]) && $musteri["name"] != null) ? 1 : 0;
                }

            } catch (\Throwable $th) {
                log_message('error', 'Müşteri Ekleme Hatası: ' . $th->getMessage());
                $mukellefiyet = 0;
                $sahis          = (isset($musteri["name"]) && $musteri["name"] != null) ? 1 : 0;
            }
           
            $adresBilgileri = $this->modelAddress->where('cari_id', $musteri["cari_id"])->where('default', 'true')->where('status', 'active')->first();
           

            $data = [
                "vkn_tc"         => !empty($musteri['identification_number']) ? $musteri['identification_number'] : $musteri['identification_number'],
                "vergi_dairesi"  => $musteri['tax_administration'] ?? null,
                "unvan"          => $musteri['invoice_title'],
                "ad"             => $musteri['name'] ?? null,
                "soyad"          => $musteri['surname'] ?? null,
                "adres"          => $adresBilgileri['address'] ?? null,
                "il"             => $adresBilgileri['address_city'] ?? null,
                "ilce"           => $adresBilgileri['address_district'] ?? null,
                "ulke"           => $musteri['country'] ?? 'TR',
                "posta_kodu"     => $adresBilgileri['zip_code'] ?? null,
                "eposta"         => $musteri['cari_email'] ?? null,
                "tel"            => preg_replace('/^9/', '', preg_replace('/[^0-9]/', '', $musteri['cari_phone'] ?? null)),
                "mukellefiyet"   => $mukellefiyet,
                "sahis"          => $sahis,
                "musteri"        => 1,
                "tedarikci"      => 0,
                "ihracat"        => 0,
                "default_doviz"  => 'TRY',
                'user_id'        => $this->TikoPortalID,
                "earsivden_aktarim_id" => $musteri['cari_id']
            ];

            if (!$tikoDB->table('musteriler')->insert($data)) {
                log_message('error', 'Müşteri eklemede hata: ' . json_encode($data));
                return false;
            }

            $musteri_id = $tikoDB->insertID();

            // Müşteri adres ekleme
            $adres_data = [
                "adres_baslik"      => "Ana Adres",
                "adres_aktif"       => 1,
                "musteri_id"        => $musteri_id,
                "adres_adres"       => $data['adres'],
                "adres_il"          => $data['il'],
                "adres_ilce"        => $data['ilce'],
                "adres_ulke"        => $data['ulke'],
                "adres_posta_kodu"  => $data['posta_kodu'],
                "adres_eposta"      => $data['eposta'],
                "adres_telefon"     => $data['tel']
            ];

            $tikoDB->table('musteri_adresler')->insert($adres_data);
            log_message('info', 'Müşteri başarıyla eklendi. ID: ' . $musteri_id);

            return [0 => $data];
        }

        return false;
    }

    private function apiReq()
    {
        $client = \Config\Services::curlrequest([
            'timeout' => 300,
            'http_errors' => false
        ]);
        return $client;
    }

    public function func_vkn_sorgula($vknTcknn)
    {
        try {
            $client = $this->apiReq();
            $response = $client->post('http://212.98.224.209:3009/yeni_vkn_sorgulama', [
                'form_params' => [
                    'vknTcknn' => $vknTcknn
                ],
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody(), true);
            }
            
            return [
                'status' => $response->getStatusCode(),
                'error' => 'VKN sorgulama hatası'
            ];

        } catch (\Exception $e) {
            log_message('error', 'VKN sorgulama hatası: ' . $e->getMessage());
            return [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
    }


    public function fatura_portal_ekle($fatura)
    {
     
        log_message('info', "Kullanıcı fatura aktarımları.");

        $tikoDB = $this->tikoPortalDatabase();
       


        $faturaSorgula = $tikoDB->table('faturalar')->where("tiko_erp_id", $fatura["invoice_id"])->where('user_id', $this->TikoPortalID)->get()->getResult();

        if($faturaSorgula){
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Fatura zaten eklenmiş'
            ]);
        }

       
      
            log_message('info', "User: " . $this->TikoPortalID . " Fatura: " . $fatura["invoice_id"]);

            $seriNolar = $this->seri_no_sorgula(fatura: $fatura);

            $seriNo = $seriNolar[0]->on_ek;
            $seriNoId = $seriNolar[0]->id;
            
            $musteriBilgileri = $this->MusteriSorgula($fatura["musteri"]);
            $musteriBilgileri = is_array($musteriBilgileri) && isset($musteriBilgileri[0]) ? (array)$musteriBilgileri[0] : $musteriBilgileri;

        
            $musteriAdresBilgileri = $tikoDB->table('musteri_adresler')->where('musteri_id', $musteriBilgileri["earsivden_aktarim_id"])->where('adres_aktif', 1)->get()->getResult();
        
            $faturaBirim = $this->modelMoneyUnit->where('money_unit_id', $fatura["money_unit_id"])->first();

            // Fatura modelini oluştur
            $new_fatura = [
                "fatura_seri"                       => $seriNo,
                "fatura_seri_id"                    => $seriNoId,
                "fatura_no"                         => null,
                "fatura_ettn"                       => $fatura["invoice_ettn"],
                "fatura_direction"                  => $fatura["invoice_direction"] == "outgoing_invoice" ? 'OUT' : 'IN',
                "user_id"                           => $this->TikoPortalID,
                "musteri_id"                        => $musteriBilgileri["id"] ?? 0,
                "fatura_vkn_tc"                     => $fatura["cari_identification_number"],
                "fatura_vergi_dairesi"              => $fatura["cari_tax_administration"] ?? null,
                "fatura_adres"                      => $fatura["address"] ?? null,
                "fatura_unvan"                      => $fatura["cari_invoice_title"] ?? null,
                "fatura_ad"                         => $fatura["cari_name"] ?? null,
                "fatura_soyad"                      => $fatura["cari_surname"] ?? null,
                "fatura_il"                         => $fatura["address_city"] ?? null,
                "fatura_ilce"                       => $fatura["address_district"] ?? null,
                "fatura_ulke"                       => $fatura["country"] ?? 'TR',
                "fatura_posta_kodu"                 => $fatura["zip_code"] ?? null,
                "fatura_eposta"                     => $fatura["cari_email"] ?? null,
                "fatura_tel"                        => preg_replace('/^9/', '', preg_replace('/[^0-9]/', '', $fatura["cari_phone"] ?? null)),
                "fatura_senaryo"                    => $fatura["invoice_scenario"] ?? "EARSIVFATURA",
                "fatura_tipi"                       => strtoupper($fatura["invoice_type"]),
                "fatura_gonderim_sekli"             => $fatura["invoice_scenario"] == "EARSIVFATURA" ? "ELEKTRONIK" : "",
                "fatura_fatura"                     => $fatura["invoice_scenario"] ?? "EARSIVFATURA",
                "fatura_baslik"                     => $fatura["fatura_baslik"] ?? null,
                "fatura_tutar_yazi"                 => $fatura["amount_to_be_paid_text"] ?? null,
                "fatura_tarihi"                     => date('Y-m-d H:i:s', strtotime($fatura["invoice_date"])),
                "fatura_not"                        => $fatura["invoice_note"] ?? null,
                "fatura_mal_hizmet_toplam"          => $fatura["stock_total"],
                "fatura_iskonto_toplam"             => $fatura["discount_total"],
                "fatura_ara_toplam"                 => $fatura["sub_total"],
                "fatura_kdv_toplam_0"               => 0,
                "fatura_kdv_tutar_toplam_0"         => $fatura["stock_total"],
                "fatura_kdv_toplam_1"               => $fatura["tax_rate_1_amount"],
                "fatura_kdv_tutar_toplam_1"         => $fatura["stock_total"] + $fatura["tax_rate_1_amount"],
                "fatura_kdv_toplam_8"               => 0,
                "fatura_kdv_tutar_toplam_8"         => 0,
                "fatura_kdv_toplam_10"              => $fatura["tax_rate_10_amount"],
                "fatura_kdv_tutar_toplam_10"        => $fatura["stock_total"] + $fatura["tax_rate_10_amount"],
                "fatura_kdv_toplam_18"              => 0,
                "fatura_kdv_tutar_toplam_18"        => 0,
                "fatura_kdv_toplam_20"              => $fatura["tax_rate_20_amount"],
                "fatura_kdv_tutar_toplam_20"        => $fatura["stock_total"] + $fatura["tax_rate_20_amount"],
                "fatura_genel_toplam"               => $fatura["grand_total"],
                "fatura_doviz_birimi"               => $faturaBirim["money_code"] ?? "TRY",
                "fatura_doviz_kuru"                 => ($faturaBirim["money_code"] !== "TRY") ? $faturaBirim["money_value"] : 1,
                "fatura_tevkifat_code"              => "",
                "fatura_tevkifat_name"              => "",
                "fatura_tevkifat_oran"              => "",
                "fatura_tevkifat_islem_tutari"      => '', //$fatura["fatura_tevkifat_islem_tutari"],
                "fatura_tevkifat_islem_kdv"         => '', //$fatura["fatura_tevkifat_islem_kdv"],
                "fatura_tevkifat_tutar"             => '', //$fatura["fatura_tevkifat_tutar"],
                "fatura_odenecek_tutar"             => $fatura["amount_to_be_paid"],
                "fatura_in_status_description"      => "SİSTEMDE GİB'E AKTARILMADI",
                "fatura_in_status_code"             => 0,
                "fatura_in_status"                  => "NOT TRANSFERRED IN THE SYSTEM",
                "fatura_in_gib_status_code"         => 0,
                "fatura_in_gib_status_description"  => "Henüz GİB'te İşlem Yapılmadı",
                "fatura_out_status_description"     => "DURUM BİLGİSİ",
                "fatura_out_status_code"            => 0,
                "fatura_out_status"                 => "DURUM BİLGİSİ",
                "fatura_out_gib_status_code"        => 0,
                "fatura_out_gib_status_description" => "DURUM BİLGİSİ",
                "fatura_istisna_kodu"               => null,
                "fatura_istisna_adi"                => null,
                "fatura_vergi_muafiyet"             => null,
                "fatura_sahsiyet"                   => null,
                "fatura_finans_kurum"               => null,
                "fatura_finans_kurum_sube"          => null,
                "fatura_finans_iban"                => null,
                "fatura_payment_kodu"               => null,
                "fatura_vade_tarihi"                => null,
                "fatura_odeme_sekli"                => null,
                "tiko_erp_id"              => $fatura["invoice_id"]
            ];

            // Faturayı veritabanına ekle
            if (!$tikoDB->table('faturalar')->insert($new_fatura)) {
                log_message('error', "Fatura oluşturmada hata oluştu.");
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Fatura oluşturmada hata oluştu'
                ]);
            }

            $fatura_id = $tikoDB->insertID();

            // Fatura satırlarını al
          

            foreach ($fatura["satirlar"] as $key => $earsiv_fatura_satir) {

                $olcuBul = $this->modelUnit->where('unit_id', $earsiv_fatura_satir["unit_id"])->first();
                $tikoOlcu = $tikoDB->table('ktgr_olcu_birimleri')->where('name', $olcuBul["unit_title"])->get()->getResult();
                if($tikoOlcu){
                    $tikoOlcuId = $tikoOlcu[0]->name;
                    $tikoOlcuadi = $tikoOlcu[0]->code;
                }else{
                    $tikoOlcuId = "Adet";
                    $tikoOlcuadi = "C62";
                }



                $data_satir = [
                    "satir_aciklama"                => $earsiv_fatura_satir["stock_title"],
                    "satir_miktar"                  => $earsiv_fatura_satir["stock_amount"],
                    "satir_miktar_birim"            => $tikoOlcuId,
                    "satir_miktar_birim_val"        => $tikoOlcuadi,
                    "satir_birim_fiyat"             => $earsiv_fatura_satir["unit_price"],
                    "satir_malhizmet_tutar"         => $earsiv_fatura_satir["unit_price"] * $earsiv_fatura_satir["stock_amount"],
                    "satir_iskonto_yuzde"           => $earsiv_fatura_satir["discount_rate"],
                    "satir_iskonto_tutari"          => $earsiv_fatura_satir["discount_price"],
                    "satir_iskontolu_tutar"         => $earsiv_fatura_satir["subtotal_price"],
                    "satir_kdv_orani"               => $earsiv_fatura_satir["tax_id"],
                    "satir_kdv_tutari"              => $earsiv_fatura_satir["tax_price"],
                    "satir_urun_id"                 => null,
                    "satir_genel_toplam"            => $earsiv_fatura_satir["total_price"],
                    "satir_sira"                    => ($key + 1),
                    "fatura_id"                     => $fatura_id,
                    "user_id"                       => $this->TikoPortalID,
                    "satir_musteri_id"              => 0,
                    "earsivden_aktarim_id"          => $earsiv_fatura_satir["invoice_id"]
                ];

                if (!$tikoDB->table('fatura_satirlar')->insert($data_satir)) {
                    log_message('error', "Fatura satırı eklenirken hata oluştu");
                    $tikoDB->table('invoices')->where('id', $fatura_id)->delete();
                    return $this->response->setJSON([
                        'status' => false,
                        'message' => 'Fatura satırı eklenirken hata oluştu'
                    ]);
                }
            }

            $updateInvoice = [
                'tiko_id' => $fatura_id
            ];

            $this->modelInvoice->where("invoice_id", $fatura["invoice_id"])->set( $updateInvoice)->update();
        
            /* $this->modelIslem->LogOlustur(
                session()->get('client_id'),
               $this->erp_session_id,
                 $fatura["invoice_id"],
                'ok',
                'fatura',
                "Fatura Başarıyla tikoportal'a aktarıldı",
                session()->get("user_item")["user_adsoyad"],
                json_encode( ['invoice_id' =>  $fatura["invoice_id"], 'fatura_bilgileri' => $new_fatura, 'fatura_satirlari' => $data_satir]),
                0,
                0,
                 $fatura["invoice_id"],
                0
             ); */

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Faturalar başarıyla aktarıldı'
        ]);

        


    }

    

    public function fatura_portal_guncelle($fatura)
    {

        $tikoDB = $this->tikoPortalDatabase();
        
        // Faturayı bul
        $mevcutFatura = $tikoDB->table('faturalar')
            ->where("tiko_erp_id", $fatura["invoice_id"])
            ->where('user_id', $this->TikoPortalID)
            ->get()
            ->getRowArray();

        // Fatura bulunamadıysa veya fatura numarası doluysa güncelleme yapma
        if (!$mevcutFatura) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Güncellenecek fatura bulunamadı'
            ]);
        }
    
        if (!is_null($mevcutFatura['fatura_no'])) {

            $dataFaturaNo = [
                'invoice_no' => $mevcutFatura['fatura_no'],
                'tiko_imza' => 1,
                'tiko_xml' => $mevcutFatura['fatura_link_xml'],
                'tiko_pdf' => $mevcutFatura['fatura_link_pdf'],
                'tiko_html' => $mevcutFatura['fatura_link_html'],
            ];
            $this->modelInvoice->where('invoice_id', $fatura["invoice_id"])->set($dataFaturaNo)->update();
            
            /* $this->modelIslem->LogOlustur(
                session()->get('client_id'),
               $this->erp_session_id,
                $fatura["invoice_id"],
                'ok',
                'fatura',
                "Fatura Başarıyla imzalandı!",
                session()->get("user_item")["user_adsoyad"],
                json_encode(['invoice_id' => $fatura["invoice_id"], 'fatura_bilgileri' => $dataFaturaNo]),
                0, 0, $fatura["invoice_id"], 0
            ); */

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Bu fatura numarası almış, <a href="https://tikoportal.com/e-fatura/faturalar/detay/'.$mevcutFatura['id'].'" target="_blank">tikoportal.com</a> adresinde düzenlenemez <br> Fatura numarası: '.$mevcutFatura['fatura_no']
            ]);

           
        }
    
        try {
            $tikoDB->transStart();
    
            // Müşteri ve seri no bilgilerini al
            $musteriBilgileri = $this->MusteriSorgula($fatura["musteri"]);
            $musteriBilgileri = is_array($musteriBilgileri) && isset($musteriBilgileri[0]) ? 
                (array)$musteriBilgileri[0] : $musteriBilgileri;
            
            $seriNolar = $this->seri_no_sorgula($fatura);
            $faturaBirim = $this->modelMoneyUnit->where('money_unit_id', $fatura["money_unit_id"])->first();

    
            // Debug log ekle
            log_message('info', "Fatura güncelleme debug - address_city: " . ($fatura["address_city"] ?? 'BOŞ') . 
                          ", address_district: " . ($fatura["address_district"] ?? 'BOŞ') . 
                          ", cari_phone: " . ($fatura["cari_phone"] ?? 'BOŞ'));
    
            // Fatura ana bilgilerini güncelle
            $update_fatura = [
                "fatura_seri"                       => $seriNolar[0]->on_ek,
                "fatura_seri_id"                    => $seriNolar[0]->id,
                "fatura_ettn"                       => $fatura["invoice_ettn"],
                "fatura_direction"                  => $fatura["invoice_direction"] == "outgoing_invoice" ? 'OUT' : 'IN',
                "user_id"                           => $this->TikoPortalID,
                "musteri_id"                        => $musteriBilgileri["id"] ?? 0,
                "fatura_vkn_tc"                     => $fatura["cari_identification_number"],
                "fatura_vergi_dairesi"              => $fatura["cari_tax_administration"] ?? null,
                "fatura_adres"                      => $fatura["address"] ?? null,
                "fatura_unvan"                      => $fatura["cari_invoice_title"] ?? null,
                "fatura_ad"                         => $fatura["cari_name"] ?? null,
                "fatura_soyad"                      => $fatura["cari_surname"] ?? null,
                "fatura_il"                         => $fatura["address_city"] ?? null,
                "fatura_ilce"                       => $fatura["address_district"] ?? null,
                "fatura_ulke"                       => $fatura["country"] ?? 'TR',
                "fatura_posta_kodu"                 => $fatura["zip_code"] ?? null,
                "fatura_eposta"                     => $fatura["cari_email"] ?? null,
                "fatura_tel"                        => preg_replace('/^9/', '', preg_replace('/[^0-9]/', '', $fatura["cari_phone"] ?? null)),
                "fatura_senaryo"                    => $fatura["invoice_scenario"] ?? "EARSIVFATURA",
                "fatura_tipi"                       => strtoupper($fatura["invoice_type"]),
                "fatura_gonderim_sekli"             => $fatura["invoice_scenario"] == "EARSIVFATURA" ? "ELEKTRONIK" : "",
                "fatura_fatura"                     => $fatura["invoice_scenario"] ?? "EARSIVFATURA",
                "fatura_baslik"                     => $fatura["fatura_baslik"] ?? null,
                "fatura_tutar_yazi"                 => $fatura["amount_to_be_paid_text"] ?? null,
                "fatura_tarihi"                     => date('Y-m-d H:i:s', strtotime($fatura["invoice_date"])),
                "fatura_not"                        => $fatura["invoice_note"] ?? null,
                "fatura_mal_hizmet_toplam"          => $fatura["stock_total"],
                "fatura_iskonto_toplam"             => $fatura["discount_total"],
                "fatura_ara_toplam"                 => $fatura["sub_total"],
                "fatura_kdv_toplam_0"               => 0,
                "fatura_kdv_tutar_toplam_0"         => $fatura["stock_total"],
                "fatura_kdv_toplam_1"               => $fatura["tax_rate_1_amount"],
                "fatura_kdv_tutar_toplam_1"         => $fatura["stock_total"] + $fatura["tax_rate_1_amount"],
                "fatura_kdv_toplam_8"               => 0,
                "fatura_kdv_tutar_toplam_8"         => 0,
                "fatura_kdv_toplam_10"              => $fatura["tax_rate_10_amount"],
                "fatura_kdv_tutar_toplam_10"        => $fatura["stock_total"] + $fatura["tax_rate_10_amount"],
                "fatura_kdv_toplam_18"              => 0,
                "fatura_kdv_tutar_toplam_18"        => 0,
                "fatura_kdv_toplam_20"              => $fatura["tax_rate_20_amount"],
                "fatura_kdv_tutar_toplam_20"        => $fatura["stock_total"] + $fatura["tax_rate_20_amount"],
                "fatura_genel_toplam"               => $fatura["grand_total"],
                "fatura_doviz_birimi"               => $faturaBirim["money_code"] ?? "TRY",
                "fatura_doviz_kuru"                 => ($faturaBirim["money_code"] !== "TRY") ? $faturaBirim["money_value"] : 1,
                "fatura_tevkifat_code"              => "",
                "fatura_tevkifat_name"              => "",
                "fatura_tevkifat_oran"              => "",
                "fatura_tevkifat_islem_tutari"      => '',
                "fatura_tevkifat_islem_kdv"         => '',
                "fatura_tevkifat_tutar"             => '',
                "fatura_odenecek_tutar"             => $fatura["amount_to_be_paid"],
                "fatura_in_status_description"      => "SİSTEMDE GİB'E AKTARILMADI",
                "fatura_in_status_code"             => 0,
                "fatura_in_status"                  => "NOT TRANSFERRED IN THE SYSTEM",
                "fatura_in_gib_status_code"         => 0,
                "fatura_in_gib_status_description"  => "Henüz GİB'te İşlem Yapılmadı",
                "fatura_out_status_description"     => "DURUM BİLGİSİ",
                "fatura_out_status_code"            => 0,
                "fatura_out_status"                 => "DURUM BİLGİSİ",
                "fatura_out_gib_status_code"        => 0,
                "fatura_out_gib_status_description" => "DURUM BİLGİSİ",
                "fatura_istisna_kodu"               => null,
                "fatura_istisna_adi"                => null,
                "fatura_vergi_muafiyet"             => null,
                "fatura_sahsiyet"                   => null,
                "fatura_finans_kurum"               => null,
                "fatura_finans_kurum_sube"          => null,
                "fatura_finans_iban"                => null,
                "fatura_payment_kodu"               => null,
                "fatura_vade_tarihi"                => null,
                "fatura_odeme_sekli"                => null
            ];

    
            // Fatura bilgilerini güncelle
            $updateResult = $tikoDB->table('faturalar')
                ->where('id', $mevcutFatura['id'])
                ->update($update_fatura);
                
    
    
            // Eski fatura satırlarını sil
            $tikoDB->table('fatura_satirlar')
                ->where('fatura_id', $mevcutFatura['id'])
                ->delete();
    
            // Yeni fatura satırlarını ekle
            foreach ($fatura["satirlar"] as $key => $earsiv_fatura_satir) {
                $olcuBul = $this->modelUnit->where('unit_id', $earsiv_fatura_satir["unit_id"])->first();
                $tikoOlcu = $tikoDB->table('ktgr_olcu_birimleri')
                    ->where('name', $olcuBul["unit_title"])
                    ->get()
                    ->getResult();
    
                $tikoOlcuId = $tikoOlcu ? $tikoOlcu[0]->name : "Adet";
                $tikoOlcuadi = $tikoOlcu ? $tikoOlcu[0]->code : "C62";
    
                $data_satir = [
                    "satir_aciklama"                => $earsiv_fatura_satir["stock_title"],
                    "satir_miktar"                  => $earsiv_fatura_satir["stock_amount"],
                    "satir_miktar_birim"            => $tikoOlcuId,
                    "satir_miktar_birim_val"        => $tikoOlcuadi,
                    "satir_birim_fiyat"             => $earsiv_fatura_satir["unit_price"],
                    "satir_malhizmet_tutar"         => $earsiv_fatura_satir["unit_price"] * $earsiv_fatura_satir["stock_amount"],
                    "satir_iskonto_yuzde"           => $earsiv_fatura_satir["discount_rate"],
                    "satir_iskonto_tutari"          => $earsiv_fatura_satir["discount_price"],
                    "satir_iskontolu_tutar"         => $earsiv_fatura_satir["subtotal_price"],
                    "satir_kdv_orani"               => $earsiv_fatura_satir["tax_id"],
                    "satir_kdv_tutari"              => $earsiv_fatura_satir["tax_price"],
                    "satir_urun_id"                 => null,
                    "satir_genel_toplam"            => $earsiv_fatura_satir["total_price"],
                    "satir_sira"                    => ($key + 1),
                    "fatura_id"                     => $mevcutFatura['id'],
                    "user_id"                       => $this->TikoPortalID,
                    "satir_musteri_id"              => 0,
                    "earsivden_aktarim_id"          => $earsiv_fatura_satir["invoice_id"]
                ];
    
                $tikoDB->table('fatura_satirlar')->insert($data_satir);
            }
    
            // Log oluştur
          /*  $this->modelIslem->LogOlustur(
                session()->get('client_id'),
               $this->erp_session_id,
                $fatura["invoice_id"],
                'ok',
                'fatura',
                "Fatura Başarıyla güncellendi",
                session()->get("user_item")["user_adsoyad"],
                json_encode(['invoice_id' => $fatura["invoice_id"], 'fatura_bilgileri' => $update_fatura]),
                0, 0, $fatura["invoice_id"], 0
            ); */
    
            $tikoDB->transComplete();
    
            if ($tikoDB->transStatus() === false) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Fatura güncellenirken bir hata oluştu'
                ]);
            }

      
    
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Fatura başarıyla güncellendi'
            ]);
    
        } catch (\Exception $e) {
            log_message('error', "Fatura güncelleme hatası: " . $e->getMessage());
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Fatura güncellenirken bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }


    public function fatura_sorgula($fatura_id){
        $tikoDB = $this->tikoPortalDatabase();
        $fatura = $tikoDB->table('faturalar')->where('id', $fatura_id)->get()->getRowArray();
        if($fatura){    
            $fatura_out_gib_status_description = $fatura["fatura_out_gib_status_description"];
            $fatura_out_status_description = $fatura["fatura_out_status_description"];
            $fatura_out_status_code = $fatura["fatura_out_status_code"];
            $fatura_out_gib_status_code = $fatura["fatura_out_gib_status_code"];

            $fatura_link_xml = $fatura["fatura_link_xml"];
            $fatura_link_pdf = $fatura["fatura_link_pdf"];
            $fatura_link_html = $fatura["fatura_link_html"];
            $fatura_no = $fatura["fatura_no"];
          
            $tikoFaturaDurumlari = $this->modelInvoiceOutgoing->Where('status_statement', $fatura_out_status_description)->first();

            if(!$tikoFaturaDurumlari){
                $tiko_fatura_durum = 2;
            }else{
                $tiko_fatura_durum = $tikoFaturaDurumlari["invoice_outgoing_status_id"];
            }
            $data_fatura = [
                'invoice_status_id' => $tiko_fatura_durum,
                'tiko_pdf' => $fatura_link_pdf,
                'tiko_imza' => 1,
                'invoice_no' => $fatura_no,
                'tiko_xml' => $fatura_link_xml,
                'tiko_html' => $fatura_link_html,
            ]; 
            $tikFaturaBul = $this->modelInvoice->where('tiko_id', $fatura_id)->first();
            $this->modelInvoice->where('tiko_id', $fatura_id)->set($data_fatura)->update();

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Fatura başarıyla güncellendi',
                'fatura' => $data_fatura
            ]);    
        }else{
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Fatura bulunamadı'
            ]);
        }


            
    }



    public function fatura_genel_guncelle() {
        try {
            // Yerel veritabanından tiko_id'si olan tüm faturaları al
            $lokalFaturalar = $this->modelInvoice
                ->where('tiko_id !=', '')
                ->where('tiko_id IS NOT NULL')
                ->findAll();
    
            if (empty($lokalFaturalar)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Güncellenecek fatura bulunamadı'
                ]);
            }

         
    
            // TikoPortal veritabanı bağlantısı
            $tikoDB = $this->tikoPortalDatabase();
            
            $basarili = 0;
            $basarisiz = 0;
            $guncellenenler = [];
    
            foreach ($lokalFaturalar as $lokalFatura) {
                try {
                    // TikoPortal'dan fatura bilgilerini al
                    $uzakFatura = $tikoDB->table('faturalar')
                        ->where('id', $lokalFatura['tiko_id'])
                        ->get()
                        ->getRowArray();
    
                    if (!$uzakFatura) {
                        $basarisiz++;
                        continue;
                    }
    
                    // Fatura durumunu kontrol et
                    $tikoFaturaDurumlari = $this->modelInvoiceOutgoing
                        ->where('status_statement', $uzakFatura['fatura_out_status_description'])
                        ->first();
    
                    $faturaDurumId = $tikoFaturaDurumlari ? 
                        $tikoFaturaDurumlari['invoice_outgoing_status_id'] : 2;
    
                    // Güncellenecek verileri hazırla
                    $guncelVeriler = [
                        'invoice_status_id' => $faturaDurumId,
                        'tiko_pdf' => $uzakFatura['fatura_link_pdf'],
                        'tiko_xml' => $uzakFatura['fatura_link_xml'],
                        'tiko_html' => $uzakFatura['fatura_link_html'],
                        'tiko_imza' => !empty($uzakFatura['fatura_no']) ? 1 : 0,
                        'invoice_no' => $uzakFatura['fatura_no'] ?? "#PROFORMA"
                    ];
    
                    // Faturayı güncelle
                    $guncelleme = $this->modelInvoice
                        ->where('invoice_id', $lokalFatura['invoice_id'])
                        ->set($guncelVeriler)
                        ->update();
    
                    if ($guncelleme) {
                        $basarili++;
                        $guncellenenler[] = [
                            'invoice_id' => $lokalFatura['invoice_id'],
                            'eski_durum' => $lokalFatura['invoice_status_id'],
                            'yeni_durum' => $faturaDurumId,
                            'fatura_no' => $uzakFatura['fatura_no']
                        ];
    
                        // Log oluştur
                        /* $this->modelIslem->LogOlustur(
                            1,
                            1,
                            $lokalFatura['invoice_id'],
                            'ok',
                            'fatura',
                            "Fatura durumu TikoPortal ile senkronize edildi",
                            "Tiko Portal",
                            json_encode([
                                'eski_durum' => $lokalFatura['invoice_status_id'],
                                'yeni_durum' => $faturaDurumId,
                                'fatura_no' => $uzakFatura['fatura_no']
                            ]),
                            0, 0, $lokalFatura['invoice_id'], 0
                        ); */
                    } else {
                        $basarisiz++;
                    }
    
                } catch (\Exception $e) {
                    log_message('error', "Fatura güncelleme hatası (ID: {$lokalFatura['invoice_id']}): " . $e->getMessage());
                    $basarisiz++;
                    continue;
                }
            }
    
            return $this->response->setJSON([
                'status' => true,
                'message' => sprintf(
                    'Toplam %d fatura güncellendi, %d fatura güncellenemedi.', 
                    $basarili, 
                    $basarisiz
                ),
                'guncellenen_faturalar' => $guncellenenler,
                'basarili' => $basarili,
                'basarisiz' => $basarisiz
            ]);
    
        } catch (\Exception $e) {
            log_message('error', "Genel güncelleme hatası: " . $e->getMessage());
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Fatura güncellemesi sırasında bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }



    function convert_sql($number) {
        // Önce virgülü noktaya çevir
        $number = str_replace(",", ".", $number);
        
        // Binlik ayracı noktaları kaldır
        $number = str_replace(".", "", $number);
        
        // Son iki basamağı ayır
        $whole = substr($number, 0, -2);
        $decimal = substr($number, -2);
        
        // Yeni format: 1953525.60
        return $whole . "." . $decimal;
    }

    function parse_turkish_number($number) {

        return $number;
    }


    public function fatura_alis_getir() {
        try {
            $tikoDB = $this->tikoPortalDatabase();
            
            $sonUcGun = date('Y-m-d H:i:s', strtotime('-90 days'));
            // Tikoportal'dan alış faturalarını çek
            $faturalar = $tikoDB->table('faturalar')
                ->where('user_id', $this->TikoPortalID)
                ->where("fatura_direction", "IN")
                ->where("fatura_no IS NOT NULL")  // Fatura numarası olanları al
                ->where("fatura_tarihi >=", $sonUcGun)  // Son 3 günün faturalarını al
                ->get()
                ->getResultArray();
    
            if (empty($faturalar)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Aktarılacak fatura bulunamadı'
                ]);
            }

            $aktarilan_faturalar = [];
            $aktarilmayan_faturalar = [];
            $toplam_fatura = 0;
            $basarili_aktarim = 0;
            $zaten_aktarilmis = 0;
            $hatali_aktarim = 0;
    
            foreach ($faturalar as $fatura) {
              
                $fatura_kontrol = $this->modelInvoice
                    ->where('invoice_no', $fatura['fatura_no'])
                    ->first();
    
                    $toplam_fatura++;
            
                    if ($fatura_kontrol) {
                        $zaten_aktarilmis++;
                        $aktarilmayan_faturalar[] = [
                            'fatura_no' => $fatura['fatura_no'],
                            'durum' => 'Zaten aktarılmış'
                        ];
                        continue;
                    }
    
              
                $fatura_doviz_kuru = 1;
                if($fatura['fatura_doviz_birimi'] == "TRY"){
                    $money_unit_id = 3;
                    $fatura_doviz_kuru = 1;
                }elseif($fatura['fatura_doviz_birimi'] == "USD"){
                    $money_unit_id = 1;
                    $fatura_doviz_kuru = $fatura['fatura_doviz_kuru'];
                }else{
                    $money_unit_id = 2;
                    $fatura_doviz_kuru = $fatura['fatura_doviz_kuru'];
                }

             
        

       
                if(empty($fatura['musteri_id'])){
                    $mus_sorgu_id = 0;
                }else{
                    $mus_sorgu_id = $fatura['musteri_id'];
                }

                $musteri_id = $this->fatura_alis_musteri_kontrol( $fatura['id'],$mus_sorgu_id);


                $cari_item = $this->modelCari->where('cari_id', $musteri_id)->first();




                

            

                $invoice_incoming_status_id = $this->modelInvoiceStatus->where('status_code', $fatura["fatura_in_status_code"])->first();

                $insert_invoice_data = [
                    'user_id' => $this->erp_session_id,
                    'money_unit_id' => $money_unit_id,
                    'invoice_serial_id' => 0,
                    'invoice_no' => $fatura['fatura_no'],
                    'invoice_ettn' =>$fatura['fatura_ettn'],//$new_data_form['invoice_ettn'],

                    'invoice_direction' => "incoming_invoice",
                    'invoice_scenario' => $fatura['fatura_senaryo'],
                    'invoice_type' => $fatura['fatura_tipi'],

                    'invoice_date' => $fatura['fatura_tarihi'],

                    'payment_method' => null,
                    'expiry_date' => $fatura['fatura_tarihi'],

                    'invoice_note_id' => 0,
                    'invoice_note' => $fatura["fatura_not"],

                    'currency_amount' => $fatura_doviz_kuru ?? 1,

                    'stock_total' => $this->parse_turkish_number($fatura['fatura_mal_hizmet_toplam'] ?? 0),
                    'stock_total_try' => $this->parse_turkish_number(($fatura['fatura_mal_hizmet_toplam'] ?? 0) * $fatura_doviz_kuru),
                    
                    'discount_total' => $this->parse_turkish_number($fatura['fatura_iskonto_toplam'] ?? 0),
                    'discount_total_try' => $this->parse_turkish_number(($fatura['fatura_iskonto_toplam'] ?? 0) * $fatura_doviz_kuru),
                
                    // KDV bilgileri
                    'tax_rate_1_amount' => $this->parse_turkish_number($fatura['fatura_kdv_tutar_toplam_1'] ?? 0),
                    'tax_rate_1_amount_try' => $this->parse_turkish_number(($fatura['fatura_kdv_tutar_toplam_1'] ?? 0) * $fatura_doviz_kuru),
                    'tax_rate_10_amount' => $this->parse_turkish_number($fatura['fatura_kdv_tutar_toplam_10'] ?? 0),
                    'tax_rate_10_amount_try' => $this->parse_turkish_number(($fatura['fatura_kdv_tutar_toplam_10'] ?? 0) * $fatura_doviz_kuru),
                    'tax_rate_20_amount' => $this->parse_turkish_number($fatura['fatura_kdv_tutar_toplam_20'] ?? 0),
                    'tax_rate_20_amount_try' => $this->parse_turkish_number(($fatura['fatura_kdv_tutar_toplam_20'] ?? 0) * $fatura_doviz_kuru),
                
                    // Alt toplamlar
                    'sub_total' => $this->parse_turkish_number($fatura['fatura_ara_toplam'] ?? 0),
                    'sub_total_try' => $this->parse_turkish_number(($fatura['fatura_ara_toplam'] ?? 0) * $fatura_doviz_kuru),
                    'sub_total_0' => $this->parse_turkish_number($fatura['fatura_kdv_toplam_0'] ?? 0),
                    'sub_total_0_try' => $this->parse_turkish_number(($fatura['fatura_kdv_toplam_0'] ?? 0) * $fatura_doviz_kuru),
                    'sub_total_1' => $this->parse_turkish_number($fatura['fatura_kdv_toplam_1'] ?? 0),
                    'sub_total_1_try' => $this->parse_turkish_number(($fatura['fatura_kdv_toplam_1'] ?? 0) * $fatura_doviz_kuru),
                    'sub_total_10' => $this->parse_turkish_number($fatura['fatura_kdv_toplam_10'] ?? 0),
                    'sub_total_10_try' => $this->parse_turkish_number(($fatura['fatura_kdv_toplam_10'] ?? 0) * $fatura_doviz_kuru),
                    'sub_total_20' => $this->parse_turkish_number($fatura['fatura_kdv_toplam_20'] ?? 0),
                    'sub_total_20_try' => $this->parse_turkish_number(($fatura['fatura_kdv_toplam_20'] ?? 0) * $fatura_doviz_kuru),
                

                    'transaction_subject_to_withholding_amount' => $this->parse_turkish_number($fatura['fatura_tevkifat_islem_tutari'] ?? 0),
                    'transaction_subject_to_withholding_amount_try' => $this->parse_turkish_number(($fatura['fatura_tevkifat_islem_tutari'] ?? 0) * $fatura_doviz_kuru),
                    'transaction_subject_to_withholding_calculated_tax' => $this->parse_turkish_number($fatura['fatura_tevkifat_islem_kdv'] ?? 0),
                    'transaction_subject_to_withholding_calculated_tax_try' => $this->parse_turkish_number(($fatura['fatura_tevkifat_islem_kdv'] ?? 0) * $fatura_doviz_kuru),
                    'withholding_tax' => $this->parse_turkish_number($fatura['fatura_tevkifat_tutar'] ?? 0),
                    'withholding_tax_try' => $this->parse_turkish_number(($fatura['fatura_tevkifat_tutar'] ?? 0) * $fatura_doviz_kuru),
                
                    // Genel toplamlar
                    'grand_total' => $this->parse_turkish_number($fatura['fatura_genel_toplam'] ?? 0),
                    'grand_total_try' => $this->parse_turkish_number(($fatura['fatura_genel_toplam'] ?? 0) * $fatura_doviz_kuru),
                    'amount_to_be_paid' => $this->parse_turkish_number($fatura['fatura_odenecek_tutar'] ?? 0),
                    'amount_to_be_paid_try' => $this->parse_turkish_number(($fatura['fatura_odenecek_tutar'] ?? 0) * $fatura_doviz_kuru),
                    'amount_to_be_paid_text' => $fatura['fatura_tutar_yazi'] ?? '',
            

                    'tiko_imza' => 1,
                    'tiko_id' => $fatura["id"],
                    'tiko_pdf' => $fatura["fatura_link_pdf"],
                    'tiko_xml' => $fatura["fatura_link_xml"],
                    'tiko_html' => $fatura["fatura_link_html"],
                    'cari_id' => $musteri_id,
                    'cari_identification_number' => $fatura['fatura_vkn_tc'],
                    'cari_tax_administration' => $fatura['fatura_vergi_dairesi'],
                    'cari_invoice_title' => $fatura['fatura_unvan'],
                    'cari_name' => $fatura['fatura_ad'],
                    'cari_surname' => $fatura['fatura_soyad'],
                    'cari_phone' => $fatura['fatura_tel'],
                    'cari_email' => $fatura['fatura_eposta'],
                    'cari_obligation' => $cari_item['obligation'],
                    'cari_company_type' => $cari_item['company_type'],
                    'address_country' => $fatura['fatura_ulke'],
                    'address_city' => $fatura['fatura_il'],
                    'address_city_plate' => $fatura['fatura_ilce'],
                    'address_district' => $fatura['fatura_ilce'],
                    'address_zip_code' => $fatura['fatura_posta_kodu'],
                    'address' => $fatura['fatura_adres'],
                    'invoice_status_id' => $invoice_incoming_status_id["invoice_incoming_status_id"] ?? 1,
                    'is_quick_sale_receipt' => 0,
                    'warehouse_id' => 1,
                ];


                

                $this->modelInvoice->insert($insert_invoice_data);
                $invoice_id = $this->modelInvoice->getInsertID();


                $basarili_aktarim++;
                $aktarilan_faturalar[] = [
                    'fatura_no' => $fatura['fatura_no'],
                    'invoice_id' => $invoice_id,
                    'tutar' => $this->parse_turkish_number($fatura['fatura_genel_toplam']),
                    'tarih' => $fatura['fatura_tarihi']
                ];

                $para_birimleri = $this->modelMoneyUnit->findAll();

                foreach($para_birimleri as $para_birimi){
                    if($para_birimi['money_unit_id'] == $money_unit_id){
                        $default = "true";
                        $toplam_tutars = $this->parse_turkish_number($fatura['fatura_odenecek_tutar']);
                    } else {
                        $default = "false";
                        if($para_birimi['money_unit_id'] == 3){ // TL
                            $toplam_tutars = $this->parse_turkish_number($fatura['fatura_odenecek_tutar']);
                        } else {
                            $toplam_tutars = $this->parse_turkish_number($fatura['fatura_odenecek_tutar']) / $para_birimi['money_value'];
                        }
                    }
                
                    $fiyatDatalar = [
                        'user_id'      => $this->erp_session_id,
                        'cari_id'      => $musteri_id,
                        'fatura_id'    => $invoice_id,
                        'kur'          => $para_birimi['money_unit_id'],
                        'kur_value'    => $para_birimi['money_value'],
                        'toplam_tutar' => $toplam_tutars,
                        'tarih'        => date("d-m-Y h:i:s"),
                        'default'      => $default
                    ];
                
                    $insertFiyat = $this->modelFaturaTutar->insert($fiyatDatalar);
                }
                

                $transaction_prefix = "PRF";

                $last_transaction = $this->modelFinancialMovement->where('user_id', $this->erp_session_id)->orderBy('transaction_counter', 'DESC')->first();
                if ($last_transaction) {
                    $transaction_counter = $last_transaction['transaction_counter'] + 1;
                } else {
                    $transaction_counter = 1;
                }
                $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                $insert_financial_movement_data = [
                    'user_id' => $this->erp_session_id,
                    'financial_account_id' => null,
                    'cari_id' => $musteri_id,
                    'money_unit_id' => $money_unit_id,
                    'transaction_number' => $transaction_number,
                    'transaction_direction' => "entry",
                    'transaction_type' => "incoming_invoice",
                    'invoice_id' => $invoice_id,
                    'transaction_tool' => 'not_payroll',
                    'transaction_title' => 'Fatura aktarma  anında oluşan fatura finans hareketi',
                    'transaction_description' => $fatura['fatura_not'],
                    'transaction_amount' => $this->parse_turkish_number($fatura['fatura_odenecek_tutar']),
                    'transaction_real_amount' => $this->parse_turkish_number($fatura['fatura_odenecek_tutar']),
                    'transaction_date' => $fatura['fatura_tarihi'],
                    'transaction_prefix' => $transaction_prefix,
                    'transaction_counter' => $transaction_counter
                ];
                $this->modelFinancialMovement->insert($insert_financial_movement_data);
                $financial_movement_id = $this->modelFinancialMovement->getInsertID();



              

                $fatura_satirlari = $tikoDB->table('fatura_satirlar')->where('fatura_id', $fatura['id'])->get()->getResultArray();

                foreach($fatura_satirlari as $fatura_satiri){
                    $model_unit = $this->modelUnit->where('unit_title', $fatura_satiri['satir_miktar_birim'])->first();
                    if($model_unit){
                        $unit_id = $model_unit['unit_id'];
                    }else{
                        $unit_id = 1;
                    }

                    $kdvTablosu = [
                        0 => [
                            'invoice_tax_rate_id' => 1,
                            'tax_name' => "%0",
                            'tax_code' => "KDV0",
                            'tax_value' => "0",
                        ],
                        1 => [
                            'invoice_tax_rate_id' => 2,
                            'tax_name' => "%1",
                            'tax_code' => "KDV1",
                            'tax_value' => "1",
                        ],
                        8 => [
                            'invoice_tax_rate_id' => 3,
                            'tax_name' => "%8",
                            'tax_code' => "KDV8",
                            'tax_value' => "8",
                        ],
                        10 => [
                            'invoice_tax_rate_id' => 4,
                            'tax_name' => "%10",
                            'tax_code' => "KDV10",
                            'tax_value' => "10",
                        ],
                        18 => [
                            'invoice_tax_rate_id' => 5,
                            'tax_name' => "%18",
                            'tax_code' => "KDV18",
                            'tax_value' => "18",
                        ],
                        20 => [
                            'invoice_tax_rate_id' => 6,
                            'tax_name' => "%20",
                            'tax_code' => "KDV20",
                            'tax_value' => "20",
                        ],
                    ];


                    $insert_invoice_row_data = [
                        'user_id' => $this->erp_session_id,
                        'cari_id' => $musteri_id,
                        'invoice_id' => $invoice_id,
                        'stock_id' => 0,
                        'stock_title' => $fatura_satiri['satir_aciklama'],
                        'stock_amount' => $fatura_satiri['satir_miktar'], //convert_number_for_sql($data_invoice_row['stock_amount'])
                        'unit_id' => $unit_id,
                        'unit_price' => $this->parse_turkish_number($fatura_satiri['satir_birim_fiyat']),
                        'discount_rate' => $fatura_satiri['satir_iskonto_yuzde'] ?? 0,
                        'discount_price' => $this->parse_turkish_number($fatura_satiri['satir_iskonto_tutari'] ?? 0),
                        'subtotal_price' => $this->parse_turkish_number($fatura_satiri['satir_malhizmet_tutar']),
                        'tax_id' => $kdvTablosu[$fatura_satiri['satir_kdv_orani'] ?? 0]['invoice_tax_rate_id'],
                        'tax_price' => $this->parse_turkish_number($fatura_satiri['satir_kdv_tutari'] ?? 0),
                        'total_price' => $this->parse_turkish_number($fatura_satiri['satir_genel_toplam']),
                        'gtip_code' => null,
                        'withholding_id' => 0,
                        'withholding_rate' => 0,
                        'withholding_price' => 0,
                    ];

                    $this->modelInvoiceRow->insert($insert_invoice_row_data);
                    $invoice_row_id = $this->modelInvoiceRow->getInsertID();
                }


                


                $BakiyeGuncelle = new \App\Controllers\TikoERP\Cari();
                $BakiyeGuncelle->bakiyeHesapla($musteri_id);


                $this->modelIslem->LogOlustur(
                    0,
                    $this->erp_session_id,
                    $invoice_id,
                    'ok',
                    'fatura',
                    "Fatura Tiko Portal Tarafından Alış Faturası Olarak Aktarıldı",
                    "Tiko Portal",
                    json_encode( ['invoice_id' => $invoice_id, 'fatura_bilgileri' => $insert_invoice_data, 'fatura_satirlari' => $fatura_satirlari]),
                    0,
                    0,
                    $invoice_id,
                    0
                 );

               
                log_message('info', $fatura['fatura_no'] . " numaralı fatura aktarılacak.");
            }
    

            return $this->response->setJSON([
                'status' => true,
                'istatistik' => [
                    'toplam_fatura' => $toplam_fatura,
                    'basarili_aktarim' => $basarili_aktarim,
                    'zaten_aktarilmis' => $zaten_aktarilmis,
                    'hatali_aktarim' => $hatali_aktarim
                ],
                'aktarilan_faturalar' => $aktarilan_faturalar,
                'aktarilmayan_faturalar' => $aktarilmayan_faturalar,
                'message' => sprintf(
                    'Toplam %d faturadan %d tanesi başarıyla aktarıldı, %d tanesi zaten aktarılmıştı, %d tanesi hatalı.',
                    $toplam_fatura,
                    $basarili_aktarim,
                    $zaten_aktarilmis,
                    $hatali_aktarim
                )
            ]);
    
        } catch (\Exception $e) {
            log_message('error', "Fatura kontrol hatası: " . $e->getMessage());
            return $this->response->setJSON([
                'status' => false,
                'istatistik' => [
                    'toplam_fatura' => 0,
                    'basarili_aktarim' => 0,
                    'zaten_aktarilmis' => 0,
                    'hatali_aktarim' => 1
                ],
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile(),
                'error_trace' => $e->getTraceAsString(),
                
                'message' => 'Fatura kontrol edilirken bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }

    public function fatura_alis_musteri_kontrol($fatura_id, $musteri_id = 0){

        $erp_session_id = 5;
        $tikoDB = $this->tikoPortalDatabase();
       

        if($musteri_id == 0){

            $faturayiBul = $tikoDB->table('faturalar')->where('id', $fatura_id)->get()->getRowArray();

            $is_customer = 1;
            $is_supplier = 0;
            $is_export_customer = 0;

            $identification_number = $faturayiBul["fatura_vkn_tc"];
            $tax_administration = $faturayiBul["fatura_vergi_dairesi"];
            $invoice_title = $faturayiBul["fatura_unvan"];
            $name = $faturayiBul["fatura_ad"] ?? '';
            $surname = $faturayiBul["fatura_soyad"] ?? '';
            if($faturayiBul["fatura_tipi"] == "EFATURA"){
                $obligation = "e-invoice";
            }else{
                $obligation = "e-archive";
            }

            $company_type = "person";

            $cari_phone = preg_replace('/[^0-9]/', '', $faturayiBul["fatura_tel"]);
            $area_code = $faturayiBul["fatura_il"] ?? '';
            $cari_email = $faturayiBul["fatura_eposta"] ?? '';
            $money_unit_id = 3;
            if($faturayiBul["fatura_doviz_birimi"] == "TRY"){
                $money_unit_id = 3;
            }elseif($faturayiBul["fatura_doviz_birimi"] == "USD"){
                $money_unit_id = 1;
            }else{
                $money_unit_id = 2;
            }

            $starting_balance = 0;
            $starting_balance_date = date("Y-m-d H:i:s");




            $cari_balance = $starting_balance;

            $address = $faturayiBul["fatura_adres"];
            $address_country = $faturayiBul["fatura_ulke"];
            $address_city = $faturayiBul["fatura_il"];   // il verir
            $address_city_plate = $faturayiBul["fatura_ilce"];  // plaka verir
            $address_district = $faturayiBul["fatura_ilce"];
            $zip_code = $faturayiBul["fatura_posta_kodu"];

            //gelen telefon numarasını temizledikten sonra alan kodunun yanına bir boşluk bıraktıktan sonra telefon numarasını kaydediyoruz.
            //telefon numarasını ekrana yazdırmak isterken boşluğu göre split ettikten sonra yazdırabiliriz.
            $phone = str_replace(array('(', ')', ' '), '', $cari_phone);
            $phoneNumber = $cari_phone ? $area_code . " " . $phone : null;

            //8 rakamlı cari kodu
            $create_cari_code = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);

            $form_data = [
                'user_id' =>$this->erp_session_id,
                'cari_code' => $create_cari_code,
                'money_unit_id' => $money_unit_id,
                'identification_number' => $identification_number,
                'tax_administration' => $tax_administration != '' ? $tax_administration : null,
                'invoice_title' => $invoice_title == '' ? $name . ' ' . $surname : $invoice_title,
                'name' => $name,
                'surname' => $surname,
                'obligation' => $obligation != '' ? $obligation : null,
                'company_type' => $company_type != '' ? $company_type : null,
                'cari_phone' => $phoneNumber,
                'cari_email' => $cari_email != '' ? $cari_email : null,
                'cari_balance' => $cari_balance,
                'cari_note' => "",
                'is_customer' => $is_customer,
                'is_supplier' => $is_supplier,
                'is_export_customer' => $is_export_customer,
            ];
            
            $cariSorgula = $this->modelCari->where('identification_number', $identification_number)->first();
            if($cariSorgula){
                return $cariSorgula['cari_id'];
            }else{
                $this->modelCari->insert($form_data);
                $cari_id = $this->modelCari->getInsertID();
    
    
                try {
                    $insert_address_data = [
                        'user_id' =>$this->erp_session_id,
                        'cari_id' => $cari_id,
                        'address_title' => 'Fatura Adresi',
                        'address_country' => $address_country,
                        'address_city' => $address_city,
                        'address_city_plate' => $address_city_plate,
                        'address_district' => $address_district,
                        'zip_code' => $zip_code,
                        'address' => $address,
                        'address_phone' => $phoneNumber,
                        'address_email' => $cari_email,
                        'status' => 'active',
                        'default' => 'true'
                    ];
                    $this->modelAddress->insert($insert_address_data);
                } catch (\Exception $e) {
                    $this->logClass->save_log(
                        'error',
                        'address',
                        null,
                        null,
                        'create',
                        $e->getMessage(),
                        json_encode($_POST)
                    );
                    echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                    return;
                }
            }

            return $cari_id;

        }else{
            $musteri_kontrol = $tikoDB->table('musteriler')->where('id', $musteri_id)->get()->getRowArray();

            $musteri_vkn = $musteri_kontrol['vkn_tc'];
    
            $musteri_kontrol_erp = $this->modelCari->where('identification_number', $musteri_vkn)->first();
    
            if($musteri_kontrol_erp){
                return $musteri_kontrol_erp['cari_id'];
            }else{
    
    
                $musteri_adres = $tikoDB->table('musteri_adresler')->where('musteri_id', $musteri_id)->get()->getRowArray();
                
    
    
                $is_customer = $musteri_kontrol["musteri"];
                $is_supplier = $musteri_kontrol["tedarikci"];
                $is_export_customer = $musteri_kontrol["ihracat"];
    
                $identification_number = $musteri_kontrol["vkn_tc"];
                $tax_administration = $musteri_kontrol["vergi_dairesi"];
                $invoice_title = $musteri_kontrol["unvan"];
                $name = $musteri_kontrol["ad"];
                $surname = $musteri_kontrol["soyad"];
                if($musteri_kontrol["mukellefiyet"] == 1){
                    $obligation = "e-invoice";
                }else{
                    $obligation = "e-archive";
                }
    
                if($musteri_kontrol["sahis"] == 1){
                    $company_type = "person";
                }else{
                    $company_type = "company";
                }
    
                $cari_phone = preg_replace('/[^0-9]/', '', $musteri_kontrol["tel"]);
                $area_code = $musteri_kontrol["il"];
                $cari_email = $musteri_kontrol["eposta"];
                $money_unit_id = 3;
                if($musteri_kontrol["default_doviz"] == "TRY"){
                    $money_unit_id = 3;
                }elseif($musteri_kontrol["default_doviz"] == "USD"){
                    $money_unit_id = 1;
                }else{
                    $money_unit_id = 2;
                }
    
                $starting_balance = $musteri_kontrol["bakiye"];
                $starting_balance_date = $musteri_kontrol["created_at"];
    
    
    
    
                $cari_balance = $starting_balance;
    
                $address = $musteri_adres["adres_adres"];
                $address_country = $musteri_adres["adres_ulke"];
                $address_city = $musteri_adres["adres_il"];   // il verir
                $address_city_plate = $musteri_adres["adres_ilce"];  // plaka verir
                $address_district = $musteri_adres["adres_ilce"];
                $zip_code = $musteri_adres["adres_posta_kodu"];
    
                //gelen telefon numarasını temizledikten sonra alan kodunun yanına bir boşluk bıraktıktan sonra telefon numarasını kaydediyoruz.
                //telefon numarasını ekrana yazdırmak isterken boşluğu göre split ettikten sonra yazdırabiliriz.
                $phone = str_replace(array('(', ')', ' '), '', $cari_phone);
                $phoneNumber = $cari_phone ? $area_code . " " . $phone : null;
    
                //8 rakamlı cari kodu
                $create_cari_code = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
    
                $form_data = [
                    'user_id' =>$this->erp_session_id,
                    'cari_code' => $create_cari_code,
                    'money_unit_id' => $money_unit_id,
                    'identification_number' => $identification_number,
                    'tax_administration' => $tax_administration != '' ? $tax_administration : null,
                    'invoice_title' => $invoice_title == '' ? $name . ' ' . $surname : $invoice_title,
                    'name' => $name,
                    'surname' => $surname,
                    'obligation' => $obligation != '' ? $obligation : null,
                    'company_type' => $company_type != '' ? $company_type : null,
                    'cari_phone' => $phoneNumber,
                    'cari_email' => $cari_email != '' ? $cari_email : null,
                    'cari_balance' => $cari_balance,
                    'cari_note' => "",
                    'is_customer' => $is_customer,
                    'is_supplier' => $is_supplier,
                    'is_export_customer' => $is_export_customer,
                ];
                $this->modelCari->insert($form_data);
                $cari_id = $this->modelCari->getInsertID();
    
    
                try {
                    $insert_address_data = [
                        'user_id' =>$this->erp_session_id,
                        'cari_id' => $cari_id,
                        'address_title' => 'Fatura Adresi',
                        'address_country' => $address_country,
                        'address_city' => $address_city,
                        'address_city_plate' => $address_city_plate,
                        'address_district' => $address_district,
                        'zip_code' => $zip_code,
                        'address' => $address,
                        'address_phone' => $phoneNumber,
                        'address_email' => $cari_email,
                        'status' => 'active',
                        'default' => 'true'
                    ];
                    $this->modelAddress->insert($insert_address_data);
                } catch (\Exception $e) {
                    $this->logClass->save_log(
                        'error',
                        'address',
                        null,
                        null,
                        'create',
                        $e->getMessage(),
                        json_encode($_POST)
                    );
                    echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                    return;
                }
    
                return $cari_id;
    
    
            }
        }


       

    }



    public function fatura_alis_status_kontrol(){
        $tikoDB = $this->tikoPortalDatabase();
    
        $sonUcGun = date('Y-m-d H:i:s', strtotime('-3 days'));
    
        $fatura_durumlar = $tikoDB->table('faturalar')
            ->where('user_id', $this->TikoPortalID)
            ->where("fatura_direction", "IN")
            ->where("fatura_no IS NOT NULL")
            ->where("fatura_tarihi >=", $sonUcGun)  // Son 3 günün faturalarını al
            ->get()
            ->getResultArray();

      
    
        $guncellenen = 0;
        $basarisiz = 0;
        $durum_degisiklikleri = [];
    
        foreach($fatura_durumlar as $fatura_durum){
            $invoice_status = $this->modelInvoiceStatus
                ->where("status_code", $fatura_durum["fatura_in_status_code"])
                ->first();
    
            $invoice_status_id = $invoice_status ? $invoice_status["invoice_incoming_status_id"] : 1;
    
            $erp_faturalar = $this->modelInvoice
                ->where("invoice_no", $fatura_durum["fatura_no"])
                ->first();
    
                if($erp_faturalar){
                    $onceki_durum = $this->modelInvoiceStatus->find($erp_faturalar["invoice_status_id"]);
                    
                    // Önce kontrol edelim
                    if($invoice_status_id) {
                        $this->modelInvoice
                            ->where("invoice_id", $erp_faturalar["invoice_id"])
                            ->set(["invoice_status_id" => $invoice_status_id])  // set() kullanıyoruz
                            ->update();  // Boş update() çağrısı
                    }
                    
                    $durum_degisiklikleri[] = [
                        'fatura_no' => $fatura_durum["fatura_no"],
                        'onceki_durum' => $onceki_durum ? $onceki_durum["status_name"] : "Belirsiz",
                        'yeni_durum' => $invoice_status ? $invoice_status["status_name"] : "Belirsiz"
                    ];
                    $guncellenen++;
                }else {
                $basarisiz++;
            }
        }
    
        return $this->response->setJSON([
            'status' => true,
            'guncellenen' => $guncellenen,
            'basarisiz' => $basarisiz,
            'durum_degisiklikleri' => $durum_degisiklikleri,
            'message' => 'Fatura durumları güncellendi'
        ]);
    }



    public function fatura_satis_status_kontrol(){
        $tikoDB = $this->tikoPortalDatabase();
    
        $sonUcGun = date('Y-m-d H:i:s', strtotime('-3 days'));
    
        $fatura_durumlar = $tikoDB->table('faturalar')
            ->where('user_id', $this->TikoPortalID)
            ->where("fatura_direction", "OUT")
            ->where("fatura_no IS NOT NULL")
            ->where("fatura_tarihi >=", $sonUcGun)  // Son 3 günün faturalarını al
            ->get()
            ->getResultArray();

      
    
        $guncellenen = 0;
        $basarisiz = 0;
        $durum_degisiklikleri = [];
    
        foreach($fatura_durumlar as $fatura_durum){
            $invoice_status = $this->modelInvoiceOutgoingStatus
                ->where("status_code", $fatura_durum["fatura_out_status_code"])
                ->first();
    
            $invoice_status_id = $invoice_status ? $invoice_status["invoice_outgoing_status_id"] : 1;
    
            $erp_faturalar = $this->modelInvoice
                ->where("invoice_no", $fatura_durum["fatura_no"])
                ->first();
    
                if($erp_faturalar){
                    $onceki_durum = $this->modelInvoiceOutgoingStatus->find($erp_faturalar["invoice_status_id"]);
                    
                    // Önce kontrol edelim
                    if($invoice_status_id) {
                        $this->modelInvoice
                            ->where("invoice_id", $erp_faturalar["invoice_id"])
                            ->set(["invoice_status_id" => $invoice_status_id])  // set() kullanıyoruz
                            ->update();  // Boş update() çağrısı
                    }
                    
                    $durum_degisiklikleri[] = [
                        'fatura_no' => $fatura_durum["fatura_no"],
                        'onceki_durum' => $onceki_durum ? $onceki_durum["status_name"] : "Belirsiz",
                        'yeni_durum' => $invoice_status ? $invoice_status["status_name"] : "Belirsiz"
                    ];
                    $guncellenen++;
                }else {
                $basarisiz++;
            }
        }
    
        return $this->response->setJSON([
            'status' => true,
            'guncellenen' => $guncellenen,
            'basarisiz' => $basarisiz,
            'durum_degisiklikleri' => $durum_degisiklikleri,
            'message' => 'Fatura durumları güncellendi'
        ]);
    }



    public function alis_fatura_cari_guncelle(){
        try {
            $faturalar = $this->modelInvoice->where('invoice_direction', 'incoming_invoice')
                                          ->where("tiko_id > ", "0")
                                          ->get()
                                          ->getResultArray();
            
            if (empty($faturalar)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Güncellenecek fatura bulunamadı']);
            }

            $updated = 0;
            $failed = 0;
            $failed_details = [];
            
            foreach($faturalar as $fatura){
                $fatura_vkn = $fatura['cari_identification_number'];
                $fatura_unvan = $fatura['cari_invoice_title'];

                if (empty($fatura_vkn) || empty($fatura_unvan)) {
                    $failed++;
                    $failed_details[] = [
                        'invoice_id' => $fatura['invoice_id'],
                        'reason' => 'VKN veya Unvan boş',
                        'vkn' => $fatura_vkn,
                        'unvan' => $fatura_unvan
                    ];
                    continue;
                }

                // Önce VKN ile arama yapalım
                $cari = $this->modelCari->where('identification_number', $fatura_vkn)->first();
                
                if(!$cari) {
                    $failed++;
                    $failed_details[] = [
                        'invoice_id' => $fatura['invoice_id'],
                        'reason' => 'VKN ile cari bulunamadı',
                        'vkn' => $fatura_vkn,
                        'unvan' => $fatura_unvan
                    ];
                    continue;
                }

                // VKN bulundu, şimdi unvan kontrolü yapalım
               /* if($cari['invoice_title'] != $fatura_unvan) {
                    $failed++;
                    $failed_details[] = [
                        'invoice_id' => $fatura['invoice_id'],
                        'reason' => 'VKN bulundu ama unvan eşleşmedi',
                        'vkn' => $fatura_vkn,
                        'fatura_unvan' => $fatura_unvan,
                        'cari_unvan' => $cari['invoice_title']
                    ];
                    continue;
                } */

                $this->modelInvoice->where('invoice_id', $fatura['invoice_id'])
                                 ->set(['cari_id' => $cari['cari_id']])
                                 ->update();


                $this->modelFinancialMovement->where('invoice_id', $fatura['invoice_id'])
                ->set(['cari_id' => $cari['cari_id']])
                ->update();

                $updated++;
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Fatura güncelleme işlemi tamamlandı',
                'data' => [
                    'updated' => $updated,
                    'failed' => $failed,
                    'failed_details' => $failed_details
                ]
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Fatura güncelleme işlemi sırasında hata oluştu: ' . $e->getMessage()
            ]);
        }
    }
   


}