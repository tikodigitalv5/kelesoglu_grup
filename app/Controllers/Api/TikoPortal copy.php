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
        $this->modelStockPackage = model($TikoERPModelPath . '\StockPackageyModel', true, $db_connection);
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
                "tel"            => $musteri['cari_phone'] ?? null,
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
            $response = $client->post('http://' . $this->apiurlSorgulama . '/vkn_bilgi', [
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

            $seriNolar = $this->seri_no_sorgula($fatura);

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
                "fatura_vkn_tc"                     => $musteriBilgileri["vkn_tc"] ?? $musteriBilgileri["vkn_tc"],
                "fatura_vergi_dairesi"              => $musteriBilgileri["vergi_dairesi"] ?? null,
                "fatura_adres"                      => $musteriBilgileri["adres"] ?? null,
                "fatura_unvan"                      => $musteriBilgileri["unvan"] ?? null,
                "fatura_ad"                         => $musteriBilgileri["ad"] ?? null,
                "fatura_soyad"                      => $musteriBilgileri["soyad"] ?? null,
                "fatura_il"                         => $musteriBilgileri["il"] ?? null,
                "fatura_ilce"                       => $musteriBilgileri["ilce"] ?? null,
                "fatura_ulke"                       => $musteriBilgileri["ulke"] ?? 'TR',
                "fatura_posta_kodu"                 => $musteriBilgileri["posta_kodu"] ?? null,
                "fatura_eposta"                     => $musteriBilgileri["eposta"] ?? null,
                "fatura_tel"                        => $musteriBilgileri["tel"] ?? null,
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
    
            // Fatura ana bilgilerini güncelle
            $update_fatura = [
                "fatura_seri"                       => $seriNolar[0]->on_ek,
                "fatura_seri_id"                    => $seriNolar[0]->id,
                "fatura_ettn"                       => $fatura["invoice_ettn"],
                "fatura_direction"                  => $fatura["invoice_direction"] == "outgoing_invoice" ? 'OUT' : 'IN',
                "user_id"                           => $this->TikoPortalID,
                "musteri_id"                        => $musteriBilgileri["id"] ?? 0,
                "fatura_vkn_tc"                     => $musteriBilgileri["vkn_tc"] ?? $musteriBilgileri["vkn_tc"],
                "fatura_vergi_dairesi"              => $musteriBilgileri["vergi_dairesi"] ?? null,
                "fatura_adres"                      => $musteriBilgileri["adres"] ?? null,
                "fatura_unvan"                      => $musteriBilgileri["unvan"] ?? null,
                "fatura_ad"                         => $musteriBilgileri["ad"] ?? null,
                "fatura_soyad"                      => $musteriBilgileri["soyad"] ?? null,
                "fatura_il"                         => $musteriBilgileri["il"] ?? null,
                "fatura_ilce"                       => $musteriBilgileri["ilce"] ?? null,
                "fatura_ulke"                       => $musteriBilgileri["ulke"] ?? 'TR',
                "fatura_posta_kodu"                 => $musteriBilgileri["posta_kodu"] ?? null,
                "fatura_eposta"                     => $musteriBilgileri["eposta"] ?? null,
                "fatura_tel"                        => $musteriBilgileri["tel"] ?? null,
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
            $tikoDB->table('faturalar')
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


    public function fatura_alis_getir(){


        /* 
        
        Fatura Alış Getirme

        1. Faturaları ve satırlarını ÇEK
        2. Müşteri Bilgilerini ÇEK
        3. Müşteri sistemde kayıtlı mı kontrol et /  varsa id al yoksa ekle
        4. ona göre invoices tablosuna invoices_row ve financial_movements tablosuna kayıt edeceğiz
        
        */

        $tikoDB = $this->tikoPortalDatabase();
        $faturalar = $tikoDB->table('faturalar')->where('user_id', $this->TikoPortalID)->where("fatura_direction", "IN")->get()->getResultArray();
       
   
        foreach($faturalar as $fatura){

            /***
             * 
             * 
             * Örnek Fatura Çıktısı 
             * Array
                (
                    [id] => 379889
                    [fatura_seri] => 
                    [fatura_seri_id] => 
                    [fatura_no] => DYN2025000000336
                    [fatura_ettn] => 98F87816-4182-4E88-9B49-14D7EBFE3BED
                    [user_id] => 940
                    [musteri_id] => 59588
                    [fatura_gelen_manuel_ekleme] => 0
                    [proforma_fatura] => 0
                    [fatura_vkn_tc] => 3130935921
                    [fatura_vergi_dairesi] => DAVUTPAŞA
                    [fatura_unvan] => DUAYEN MATBAACILIK LİMİTED ŞİRKETİ
                    [fatura_ad] => 
                    [fatura_soyad] => 
                    [fatura_adres] => 
                    [fatura_eposta] => duayendijital@gmail.com
                    [fatura_tel] => 0212 567 59 91
                    [fatura_fatura] => EFATURA
                    [fatura_senaryo] => TEMELFATURA
                    [fatura_tipi] => SATIS
                    [fatura_gonderim_sekli] => 
                    [fatura_baslik] => 
                    [fatura_ulke] => TÜRKİYE
                    [fatura_tutar_yazi] => 
                    [fatura_tarihi] => 2025-04-16 18:00:15.000000
                    [fatura_irsaliye_no] => 
                    [fatura_irsaliye_tarihi] => 
                    [fatura_not] => 
                    [fatura_mal_hizmet_toplam] => 150
                    [fatura_iskonto_toplam] => 0
                    [fatura_ara_toplam] => 150
                    [fatura_kdv_tutar_toplam_0] => 0
                    [fatura_kdv_toplam_0] => 0
                    [fatura_kdv_toplam_1] => 0
                    [fatura_kdv_tutar_toplam_1] => 0
                    [fatura_kdv_toplam_8] => 0
                    [fatura_kdv_tutar_toplam_8] => 0
                    [fatura_kdv_toplam_10] => 0
                    [fatura_kdv_tutar_toplam_10] => 0
                    [fatura_kdv_toplam_18] => 0
                    [fatura_kdv_tutar_toplam_18] => 0
                    [fatura_kdv_toplam_20] => 30
                    [fatura_kdv_tutar_toplam_20] => 150
                    [fatura_odenecek_tutar] => 180
                    [fatura_genel_toplam] => 180
                    [fatura_doviz_birimi] => TRY
                    [fatura_doviz_kuru] => 
                    [fatura_tevkifat_code] => 
                    [fatura_tevkifat_name] => 
                    [fatura_tevkifat_oran] => 
                    [fatura_tevkifat_islem_tutari] => 
                    [fatura_tevkifat_islem_kdv] => 
                    [fatura_tevkifat_tutar] => 
                    [fatura_ek_vergi_tutar_toplam] => 
                    [fatura_vergi_muafiyet] => 
                    [fatura_istisna_kodu] => 
                    [fatura_istisna_adi] => 
                    [created_at] => 2025-04-16 18:05:29.000000
                    [updated_at] => 2025-04-17 09:32:27.000000
                    [deleted_at] => 
                    [hidden_at] => 
                    [fatura_direction] => IN
                    [fatura_intl_txn_id] => 
                    [fatura_in_status] => SUCCEED
                    [fatura_in_status_code] => 133
                    [fatura_in_status_description] => RECEIVE - SUCCEED
                    [fatura_in_gib_status_code] => 1300
                    [fatura_in_gib_status_description] => BAŞARIYLA TAMAMLANDI
                    [fatura_out_status] => 
                    [fatura_out_status_code] => 
                    [fatura_out_status_description] => 
                    [fatura_out_gib_status_code] => 
                    [fatura_out_gib_status_description] => 
                    [fatura_link_xml] => 
                    [fatura_link_html] => 
                    [fatura_link_pdf] => 
                    [fatura_link_zip] => 
                    [fatura_il] => 
                    [fatura_ilce] => 
                    [fatura_posta_kodu] => 
                    [fatura_sahsiyet] => 
                    [fatura_finans_kurum] => 
                    [fatura_finans_kurum_sube] => 
                    [fatura_finans_iban] => 
                    [fatura_payment_kodu] => 
                    [fatura_vade_tarihi] => 
                    [fatura_odeme_sekli] => 
                    [fatura_kategori_id] => 
                    [earsivden_aktarim_id] => 
                    [tiko_erp_id] => 
                    [fatura_musteri_bakiye_ekle] => 0
                )
             */

            $fatura_id = $fatura["musteri_id"];

            $musteriBilgileri = $tikoDB->table('musteriler')->where('id', $fatura_id)->get()->getRowArray();

            $musteri_id = $this->fatura_alis_musteri_kontrol($fatura_id);





          
        
        
        }
        return;
    }



    public function fatura_alis_musteri_kontrol($musteri_id){

        $erp_session_id = 5;
        $tikoDB = $this->tikoPortalDatabase();
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



            // $starting_balance_date = $starting_balance_date ? convert_datetime_for_sql($starting_balance) : current_time();
            $starting_balance_date = $starting_balance_date ? convert_datetime_for_sql($starting_balance_date) : date('Y-m-d H:i:s');
            $starting_balance = convert_number_for_sql($starting_balance);
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