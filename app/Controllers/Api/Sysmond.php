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
use App\Models\TikoERP\SysmondOnlineGunlukModel;
use App\Models\TikoERP\SysmondDepolarModel;
use App\Models\TikoERP\SysmondBarkodlar;
use CodeIgniter\I18n\Time;
use Exception;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;
use tidy;
use DateTime;
use \Hermawan\DataTables\DataTable;

use App\Models\SendModel;


ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');

class Sysmond extends BaseController
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

    protected $sendModel;
    protected $SysmondCronModel;
    private $modelSysmondDepolar;

    

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
    private $modelSysmondOnlineGunluk;

    private $famsDB;

    private $orderStok;
    private $modelSysmondBarkodlar;
    public function __construct()
    {

        $userDatabaseDetail = [
            'hostname' => '78.135.66.90',
            'username' => 'fams_us',
            'password' => 'p15%5Io0z',
            'database' => 'fams_db',
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



        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
        helper('Helpers\formatter_helper');
        helper('Helpers\stock_func_helper');

        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($userDatabaseDetail);

        $this->famsDB = $db_connection;

        // SysmondModel'i initialize ediyoruz
        $this->modelSysmond = model($TikoERPModelPath.'\SysmondModel', true, $db_connection);
        $this->modelSysmondBarkod = model($TikoERPModelPath.'\SysmondBarkodModel', true, $db_connection);
        $this->modelSysmondLog = model($TikoERPModelPath.'\SysmondLogModel', true, $db_connection);
        $this->modelSysmondOnline = model($TikoERPModelPath.'\SysmondOnlineModel', true, $db_connection);
        $this->modelSysmondOnlineGunluk = model($TikoERPModelPath.'\SysmondOnlineGunlukModel', true, $db_connection);

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



        helper('date');
        helper('text');
        helper('Helpers\barcode_helper');
        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\stock_func_helper');
    }


    public function userDatabase()
    {
       
        
       
        

        $userDatabaseDetail = [
            'hostname' => '78.135.66.90',
            'username' => 'fams_us',
            'password' => 'p15%5Io0z',
            'database' => 'fams_db',
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



    public function sysmondStokYoklarSadece(){
        $sysmondOnline = $this->modelSysmondOnline->findAll();
        $i = 0;
        foreach($sysmondOnline as $barkod){
            $stoktaBul = $this->modelStock->where('stock_code', $barkod['URUNKODU'])->first();
           if(!$stoktaBul){
            echo $barkod['STOCKREFID'] . "<br>";
           }
        }
        echo $i;
    }

  /*  public function sysmondToWebEklenmeyenler(){
        $sysmondOnline = $this->modelSysmondOnline->findAll();
        $i = 0;
        foreach($sysmondOnline as $barkod){
            $stoktaBul = $this->modelStock->where('stock_code', $barkod['URUNKODU'])->first();
            if(!$stoktaBul){
                $BarkodlardanBul = $this->modelSysmondBarkod->where('STOCKNO', $barkod['URUNKODU'])->orWhere('STOCKID', $barkod['STOCKREFID'])->first();
                



                if($BarkodlardanBul){
                    $barcode_number = $BarkodlardanBul["BARCODE"];
                    if (strlen($barcode_number) < 13) {
                        // Eğer barkod uzunluğu 13 karakterden az ise, production barkod dönüşümü yapılır
                        $sorgu = convert_barcode_number_for_sql_productions($barcode_number);
                    } else {
                        // 13 karakter veya daha fazla ise normal sorgu yapılır
                        $sorgu = convert_barcode_number_for_sqls($barcode_number);
                    }
            
                    }else{
                        $sorgu = generate_barcode_number_fams();
                    }


                    // Barkod uzunluğunu kontrol et
                   
            
                    // modelStock tablosunda sorguyu çalıştır - Barkod ile ürün sorgulama
                    $urun = $this->modelStock->where('sysmond', $barkod["STOCKID"])->first();
            
                    if ($urun) {
                        // Eşleştiyse eğer güncelleme yapacağız öncelikle 
                        $SysmondBilgiler = $this->modelSysmond->where("STOCKID", $barkod["STOCKID"])->first();
            
                        // SPECCODE3'ten SPECCODE10'a kadar olan değerleri birleştir
                        $specCodes = [];
                        $specCodes[] = $SysmondBilgiler["SPECCODE9"];
                        $specCodes[] = $SysmondBilgiler["SPECCODE10"];
                      
                        // Birleştirilmiş SPECCODE değerleri
                        $combinedSpecCodes = implode(", ", $specCodes);
        
                        // Sadece başlık, raf adresi ve sysmond ID'sini güncelle
                        $updateData = [
                            'stock_title' => $barkod["STOCKNAME"],
                            'warehouse_address' => $combinedSpecCodes,
                            'sysmond' => $barkod["STOCKID"]
                        ];
                        
                        $this->modelStock->update($urun["stock_id"], $updateData);
        
                        // Log kaydı ekle
                        $logData = [
                            'sysmond_stockid' => $barkod["STOCKID"],
                            'stock_id' => $urun['stock_id'],
                            'updated_data' => json_encode($updateData),
                            'log_text' => 'Sysmond verileri güncellendi (barkod hariç)',
                            'user_id' => 1,
                            'client_id' => 1,
                            'ip_address' => $this->request->getIPAddress(),
                            'browser' => $this->request->getUserAgent()->getBrowser(),
                            'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
                        ];
                        $this->modelSysmondLog->insert($logData);
                    } 
                  
                    else {
                        // Eğer barkod ile ürün bulunamadıysa, STOCKNO ile sorgu yap
                        $urunStockNo = $this->modelStock->where('stock_code', $barkod['STOCKNO'])->first();
            
                        if ($urunStockNo) {
        
                            $SysmondBilgiler = $this->modelSysmond->where("STOCKID", $barkod["STOCKID"])->first();
        
                            $specCodes = [];
                            $specCodes[] = $SysmondBilgiler["SPECCODE9"];
                            $specCodes[] = $SysmondBilgiler["SPECCODE10"];
                           
                          
                            // Birleştirilmiş SPECCODE değerleri
                            $combinedSpecCodes = implode(", ", $specCodes);
            
        
        
        
                            if($BarkodlardanBul){
                            $barcode_number = $BarkodlardanBul["BARCODE"];
                            if (strlen($barcode_number) < 13) {
                                // Eğer barkod uzunluğu 13 karakterden az ise, production barkod dönüşümü yapılır
                                $sorgu = convert_barcode_number_for_sql_productions($barcode_number);
                            } else {
                                // 13 karakter veya daha fazla ise normal sorgu yapılır
                                $sorgu = convert_barcode_number_for_sqls($barcode_number);
                            }
                    
                            }else{
                                $sorgu = generate_barcode_number_fams();
                            }
        
        
                                $updateData = [
                                    'stock_title' => $barkod["STOCKNAME"],
                                    'warehouse_address' => $combinedSpecCodes, // Yeni SPECCODE birleşimi
                                    //'stock_barcode' => $sorgu, // Yeni SPECCODE birleşimi
                                    'sysmond' => $barkod["STOCKID"]
                                ];
                            
                    
                                // Güncelleme işlemini yap
                            $this->modelStock->update($urunStockNo["stock_id"], $updateData);
                    
                                // Loglama işlemi
                            
                                $logData = [
                                    'sysmond_stockid' => $barkod["STOCKID"],
                                    'stock_id' => $urunStockNo['stock_id'],
                                    'updated_data' => json_encode($updateData),
                                    'log_text' => 'Bu barkod yok, ancak stok numarası var Sysmond verileri güncellendi',
                                    'user_id' => 1,
                                    'client_id' => 1,
                                    'ip_address' => $this->request->getIPAddress(),
                                    'browser' => $this->request->getUserAgent()->getBrowser(),
                                    'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
                                ];
                            
                    
                                // Log modelini kullanarak log kaydını ekleyin
                                $this->modelSysmondLog->insert($logData);
                           
                             //echo "Bu barkod yok, ancak stok numarası var: " . $barkod['STOCKNO'] . "<br>";
                        } else {
                            echo "Bu barkod ve stok numarası yok: " . $barkod['BARCODE'] . " - " . $barkod['STOCKNO'] . "<br>";
        
                              $Excel = $barkod;
        
        
                            $SysmondBilgiler = $this->modelSysmond->where("STOCKID", $barkod["STOCKID"])->first();
        
        
                                $Stoklar = $this->modelStock->where("stock_title", $SysmondBilgiler["STOCKNAME"])->where("stock_code", $Excel["STOCKNO"])->first();
            
        
                                if($BarkodlardanBul){
                                    $barcode_number = $BarkodlardanBul["BARCODE"];
                                    if (strlen($barcode_number) < 13) {
                                        // Eğer barkod uzunluğu 13 karakterden az ise, production barkod dönüşümü yapılır
                                        $sorgu = convert_barcode_number_for_sql_productions($barcode_number);
                                    } else {
                                        // 13 karakter veya daha fazla ise normal sorgu yapılır
                                        $sorgu = convert_barcode_number_for_sqls($barcode_number);
                                    }
                            
                                    }else{
                                        $sorgu = generate_barcode_number_fams();
                                    }

                                if (!$Stoklar || empty($Stoklar)) {
                                   
                                    $stock_type = "product";
                                    $has_variant = 0;
                                    $tip = $SysmondBilgiler["STOCKTYPENAME"];
                                    $StokTipi = $this->modelType->where("type_title", $tip)->first();
                                    $type_id = $StokTipi ? $StokTipi["type_id"] : 1;
            
                                    $fiyati = 0;
                                    $category_id = 9; // Kategorisiz
                                    $stock_barcode = $sorgu;
                                    $stock_code = $SysmondBilgiler["STOCKNO"];
                                    $stock_title = $SysmondBilgiler["STOCKNAME"];
                                    $supplier_stock_code = ''; // Fixed double $
            
                                    $paraTipi = $this->modelMoneyUnit->where("money_code", $SysmondBilgiler["CURRCODE"])->first();
                                    $para_type = $paraTipi ? $paraTipi["money_unit_id"] : 1;
            
                                    $birimi = ($SysmondBilgiler["UNITNAME"] == "KG") ? "kg" : $SysmondBilgiler["UNITNAME"];
                                    $birimTpye = $this->modelUnit->where("unit_title", $birimi)->first();
                                    $birim_type = $birimTpye ? $birimTpye["unit_id"] : 1;
            
                                    $buy_unit_id = $birim_type; // Birim KG, ADET VB
                                    $buy_unit_price = $fiyati; // Fiyat
                                    $buy_unit_price_with_tax = $fiyati; // KDV Dahil Fiyat
                                    $buy_money_unit_id = $para_type; // Para tipi US, EUR, TR
                                    $buy_tax_rate = 0; // Default %1
            
                                    $sale_unit_id = $birim_type; // Birim KG, ADET VB
                                    $sale_unit_price = $fiyati; // Fiyat
                                    $sale_unit_price_with_tax = $fiyati; // KDV Dahil Fiyat
                                    $sale_money_unit_id = $para_type; // Para tipi US, EUR, TR
                                    $sale_tax_rate = 0; // Default %1
            
                                    $ManuelStok = "SYSMOND APİDEN EKLEME " . $SysmondBilgiler["STOCKID"] . " - " . Date("d-m-Y h:i");
            
            
            
                                    $status = "active";
                                    $stock_tracking = 0;
            
                                    if ($stock_tracking == '1') {
                                        $starting_stock = $this->request->getPost('starting_stock');
                                        $starting_stock_date = $this->request->getPost('starting_stock_date');
                                        $insert_data['critical_stock'] = $this->request->getPost('critical_stock');
                                    }
            
                                    $buy_unit_price = convert_number_for_sql($buy_unit_price);
                                    $buy_unit_price_with_tax = convert_number_for_sql($buy_unit_price_with_tax);
                                    $sale_unit_price = convert_number_for_sql($sale_unit_price);
                                    $sale_unit_price_with_tax = convert_number_for_sql($sale_unit_price_with_tax);
            
                                    $barcode_number = generate_barcode_number($stock_barcode);
                                   
                                    $has_variant = $has_variant ? 1 : 0;
            
                                    $temp_stock_code = $this->getStockCode($category_id, $stock_code);
                                    if ($temp_stock_code['icon'] == 'success') {
                                        $stock_code = $temp_stock_code['value'];
                                    } else {
                                        echo json_encode($temp_stock_code);
                                        return;
                                    }
            
                                    $insert_data = [
                                        'parent_id' => 0,
                                        'user_id' => 1,
                                        'type_id' => $type_id,
                                        'category_id' => $category_id,
                                        'buy_unit_id' => $buy_unit_id,
                                        'sale_unit_id' => $sale_unit_id,
                                        'buy_money_unit_id' => $buy_money_unit_id,
                                        'sale_money_unit_id' => $sale_money_unit_id,
                                        'buy_unit_price' => $buy_unit_price,
                                        'buy_unit_price_with_tax' => $buy_unit_price_with_tax,
                                        'sale_unit_price' => $sale_unit_price,
                                        'sale_unit_price_with_tax' => $sale_unit_price_with_tax,
                                        'buy_tax_rate' => $buy_tax_rate,
                                        'sale_tax_rate' => $sale_tax_rate,
                                        'stock_type' => $stock_type,
                                        'stock_title' => $stock_title,
                                        'stock_code' => $stock_code,
                                        'stock_barcode' => $barcode_number,
                                        'supplier_stock_code' => $supplier_stock_code,
                                        'default_image' => 'uploads/default.png',
                                        'status' => $status,
                                        'manuel_add' => $ManuelStok,
                                        'has_variant' => $has_variant,
                                        'stock_tracking' => $stock_tracking,
                                    ];
            
                                    $warehouse_address = $this->request->getPost('warehouse_address');
                                    $pattern_code = $this->request->getPost('pattern_code');
                                    $en = $this->request->getPost('en');
                                    $boy = $this->request->getPost('boy');
                                    $kalinlik = $this->request->getPost('kalinlik');
                                    $ozkutle = $this->request->getPost('ozkutle');
            
                                    if ($warehouse_address) {
                                        $insert_data['warehouse_address'] = $warehouse_address;
                                    }
                                    if ($pattern_code) {
                                        $insert_data['pattern_code'] = $pattern_code;
                                    }
                                    if ($en) {
                                        $insert_data['en'] = convert_number_for_sql($en);
                                    }
                                    if ($boy) {
                                        $insert_data['boy'] = convert_number_for_sql($boy);
                                    }
                                    if ($kalinlik) {
                                        $insert_data['kalinlik'] = convert_number_for_sql($kalinlik);
                                    }
                                    if ($ozkutle) {
                                        $insert_data['ozkutle'] = convert_number_for_sql($ozkutle);
                                    }
            
                                    $this->modelStock->insert($insert_data);
                                    $new_stock_id = $this->modelStock->getInsertID();
                                    $success = true; // Set success flag to true
            
                                    if ($temp_stock_code['category_counter']) {
                                        $update_category_data = [
                                            'category_counter' => $temp_stock_code['category_counter']
                                        ];
                                        $this->modelCategory->update($category_id, $update_category_data);
                                    }
            
                                    $insert_recipe_data = [
                                        'stock_id' => $new_stock_id,
                                        'recipe_title' => $stock_title . '_recipe',
                                    ];
                                    $this->modelStockRecipe->insert($insert_recipe_data);
            
                                    if ($stock_type == 'service') {
                                        $warehouse_item = $this->modelWarehouse->where('user_id', 1)->where('default', 'true')->first();
            
                                        $barcode_number = generate_barcode_number();
                                        $insert_barcode_data = [
                                            'stock_id' => $new_stock_id,
                                            'warehouse_id' => $warehouse_item['warehouse_id'] ?? 0,
                                            'warehouse_address' => $warehouse_item['warehouse_title'] ?? '',
                                            'barcode_number' => $barcode_number,
                                            'total_amount' => 0,
                                            'used_amount' => 0
                                        ];
                                        $this->modelStockBarcode->insert($insert_barcode_data);
                                        $new_insert_stock_barcode_id = $this->modelStockBarcode->getInsertID();
                                    }
        
        
        
                                
                                    $logData = [
                                        'sysmond_stockid' => $barkod["STOCKID"],
                                        'stock_id' => $new_stock_id,
                                        'updated_data' => json_encode($SysmondBilgiler),
                                        'log_text' => 'SYSMOND TARAFINDAN APİDEN EKLENDİ',
                                        'user_id' => 1,
                                        'client_id' => 1,
                                        'ip_address' => $this->request->getIPAddress(),
                                        'browser' => $this->request->getUserAgent()->getBrowser(),
                                        'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
                                    ];
                                
                        
                                    // Log modelini kullanarak log kaydını ekleyin
                                    $this->modelSysmondLog->insert($logData);
                                   
                               
                                }
        
        
                        }
                    }



            }
        }
     
    }
  */


  public function sysmondToWebEklenmeyenler() {
    try {
        $db = $this->famsDB;
        $db->transStart();
        
        // İstatistik sayaçları
        $stats = [
            'toplam_sysmond_urun' => 0,
            'stokta_bulunan' => 0,
            'barkodda_bulunan' => 0,
            'guncellenen' => 0,
            'eslesmeyenler' => [],
            'hata_alinan' => 0
        ];

        // Chunk size - bellek yönetimi için
        $chunk_size = 100;
        $offset = 0;

        // Toplam kayıt sayısını al
        $stats['toplam_sysmond_urun'] = $this->modelSysmondOnline->countAllResults();

        while ($sysmondVerileri = $this->modelSysmondOnline->findAll($chunk_size, $offset)) {
            foreach ($sysmondVerileri as $barkod) {
                try {
                    // 1. Stok kodunu kontrol et
                    $stoktaBul = $this->modelStock->where('stock_code', $barkod['URUNKODU'])->first();

                    if ($stoktaBul) {
                        $stats['stokta_bulunan']++;
                        
                        // STOCKREFID kullan STOCKID yerine
                        $SysmondBilgiler = $this->getSysmondBilgileri($barkod["STOCKREFID"]);
                        
                        if ($SysmondBilgiler) {
                            $combinedSpecCodes = $this->combineSpecCodes($barkod); // Direkt barkod verisini kullan
                            
                            $updateData = [
                                'stock_title' => $barkod["URUNADI"],
                                'warehouse_address' => $combinedSpecCodes,
                                'sysmond' => $barkod["STOCKREFID"]
                            ];
                            
                            $this->modelStock->update($stoktaBul["stock_id"], $updateData);
                            $stats['guncellenen']++;
                            
                            $this->createSysmondLog(
                                $stoktaBul['stock_id'],
                                $barkod["STOCKREFID"],
                                $updateData,
                                'Stok kodu ile eşleşti ve güncellendi'
                            );
                        }
                    } else {
                        // 2. Barkodlarda ara
                        $BarkodlardanBul = $this->modelSysmondBarkod
                            ->where('STOCKNO', $barkod['URUNKODU'])
                            ->orWhere('STOCKID', $barkod['STOCKREFID'])
                            ->first();
                    
                        // Barkod var ya da yok, artık direkt ekleyeceğiz
                        $sorgu = $BarkodlardanBul ?  $this->convertBarcodeNumber($BarkodlardanBul) :  generate_barcode_number_fams();
                    
                        // Temel stok bilgilerini hazırla
                        $stockData = [
                            'parent_id' => 0,
                            'user_id' => 1,
                            'type_id' => 1, // Default tip
                            'category_id' => 9, // Kategorisiz
                            'buy_unit_id' => 1, // Default birim
                            'sale_unit_id' => 1, // Default birim
                            'buy_money_unit_id' => 1, // Default para birimi
                            'sale_money_unit_id' => 1, // Default para birimi
                            'buy_unit_price' => 0,
                            'buy_unit_price_with_tax' => 0,
                            'sale_unit_price' => 0,
                            'sale_unit_price_with_tax' => 0,
                            'buy_tax_rate' => 0,
                            'sale_tax_rate' => 0,
                            'stock_type' => 'product',
                            'stock_title' => $barkod["URUNADI"],
                            'stock_code' => $barkod['URUNKODU'],
                            'stock_barcode' => $sorgu,
                            'supplier_stock_code' => '',
                            'default_image' => 'uploads/default.png',
                            'status' => 'active',
                            'manuel_add' => "SYSMOND APİDEN EKLEME " . $barkod["STOCKREFID"] . " - " . Date("d-m-Y h:i"),
                            'has_variant' => 0,
                            'stock_tracking' => 0,
                            'sysmond' => $barkod["STOCKREFID"] // Sysmond ID'sini kaydediyoruz
                        ];
                    
                        // Stok kaydı oluştur
                        $this->modelStock->insert($stockData);
                        $new_stock_id = $this->modelStock->getInsertID();
                    
                        // Reçete oluştur
                        $recipe_data = [
                            'stock_id' => $new_stock_id,
                            'recipe_title' => $barkod["URUNADI"] . '_recipe',
                        ];
                        $this->modelStockRecipe->insert($recipe_data);
                    
                        // Log kaydı oluştur
                        $this->createSysmondLog(
                            $new_stock_id,
                            $barkod["STOCKREFID"],
                            $stockData,
                            'SYSMOND TARAFINDAN YENİ ÜRÜN EKLENDİ'
                        );
                    
                        $stats['eslesmeyenler'][] = [
                            'urun_kodu' => $barkod['URUNKODU'],
                            'urun_adi' => $barkod['URUNADI'],
                            'sysmond_id' => $barkod['STOCKREFID'],
                            'grup' => $barkod['GROUPCODE']
                        ];
                    }

                } catch (\Exception $e) {
                    $stats['hata_alinan']++;
                    log_message('error', 'Ürün işleme hatası: ' . $e->getMessage() . ' - Ürün Kodu: ' . $barkod['URUNKODU']);
                    continue;
                }
            }
            $offset += $chunk_size;
            
            // Her chunk sonrası belleği temizle
            gc_collect_cycles();
        }

        $db->transCommit();

        // Özet rapor
        $ozet = [
            'Toplam Sysmond Ürün' => $stats['toplam_sysmond_urun'],
            'Stokta Bulunan' => $stats['stokta_bulunan'],
            'Barkodda Bulunan' => $stats['barkodda_bulunan'],
            'Güncellenen' => $stats['guncellenen'],
            'Eşleşmeyen' => count($stats['eslesmeyenler']),
            'Hata Alınan' => $stats['hata_alinan']
        ];

        // Detaylı rapor oluştur
        $rapor = "SYSMOND GÜNCELLEME RAPORU\n";
        $rapor .= "Tarih: " . date('Y-m-d H:i:s') . "\n\n";
        
        foreach ($ozet as $baslik => $deger) {
            $rapor .= str_pad($baslik, 20) . ": " . $deger . "\n";
        }

        // Eşleşmeyen ürünleri grupla
        $grupluEslesmeyenler = [];
        foreach ($stats['eslesmeyenler'] as $urun) {
            $grup = $urun['grup'] ?? 'Diğer';
            if (!isset($grupluEslesmeyenler[$grup])) {
                $grupluEslesmeyenler[$grup] = [];
            }
            $grupluEslesmeyenler[$grup][] = $urun;
        }

        if (!empty($grupluEslesmeyenler)) {
            $rapor .= "\nEŞLEŞMEYEN ÜRÜNLER (Gruplara Göre):\n";
            foreach ($grupluEslesmeyenler as $grup => $urunler) {
                $rapor .= "\n$grup (" . count($urunler) . " ürün):\n";
                foreach ($urunler as $urun) {
                    $rapor .= "- {$urun['urun_kodu']} | {$urun['urun_adi']}\n";
                }
            }
        }

        // Log dosyasına kaydet
        log_message('info', $rapor);

        return [
            'status' => true,
            'message' => 'İşlem tamamlandı',
            'ozet' => $ozet,
            'detayli_rapor' => $rapor
        ];

    } catch (\Exception $e) {
        $db->transRollback();
        log_message('error', '[Sysmond::sysmondToWebEklenmeyenler] Hata: ' . $e->getMessage());
        
        return [
            'status' => false,
            'message' => 'İşlem sırasında hata: ' . $e->getMessage()
        ];
    }
}



public function sysmondToWebEklenmeyenlerGunluk() {
    try {
        $db = $this->famsDB;
        $db->transStart();
        
        // İstatistik sayaçları
        $stats = [
            'toplam_sysmond_urun' => 0,
            'stokta_bulunan' => 0,
            'barkodda_bulunan' => 0,
            'guncellenen' => 0,
            'eslesmeyenler' => [],
            'hata_alinan' => 0
        ];

        // Chunk size - bellek yönetimi için
        $chunk_size = 100;
        $offset = 0;

        // Toplam kayıt sayısını al
        $stats['toplam_sysmond_urun'] = $this->modelSysmondOnlineGunluk->countAllResults();

        while ($sysmondVerileri = $this->modelSysmondOnlineGunluk->findAll($chunk_size, $offset)) {
            foreach ($sysmondVerileri as $barkod) {
                try {
                    // 1. Stok kodunu kontrol et
                    $stoktaBul = $this->modelStock->where('stock_code', $barkod['URUNKODU'])->first();

                    if ($stoktaBul) {
                        $stats['stokta_bulunan']++;
                        
                        // STOCKREFID kullan STOCKID yerine
                        $SysmondBilgiler = $this->getSysmondBilgileri($barkod["STOCKREFID"]);
                        
                        if ($SysmondBilgiler) {
                            $combinedSpecCodes = $this->combineSpecCodes($barkod); // Direkt barkod verisini kullan
                            
                            $updateData = [
                                'stock_title' => $barkod["URUNADI"],
                                'warehouse_address' => $combinedSpecCodes,
                                'sysmond' => $barkod["STOCKREFID"]
                            ];
                            
                            $this->modelStock->update($stoktaBul["stock_id"], $updateData);
                            $stats['guncellenen']++;
                            
                            $this->createSysmondLog(
                                $stoktaBul['stock_id'],
                                $barkod["STOCKREFID"],
                                $updateData,
                                'Stok kodu ile eşleşti ve güncellendi'
                            );
                        }
                    } else {
                        // 2. Barkodlarda ara
                        $BarkodlardanBul = $this->modelSysmondBarkod
                            ->where('STOCKNO', $barkod['URUNKODU'])
                            ->orWhere('STOCKID', $barkod['STOCKREFID'])
                            ->first();
                    
                        // Barkod var ya da yok, artık direkt ekleyeceğiz
                        $sorgu = $BarkodlardanBul ? 
                            $this->convertBarcodeNumber($BarkodlardanBul) : 
                            generate_barcode_number_fams();
                    
                        // Temel stok bilgilerini hazırla
                        $stockData = [
                            'parent_id' => 0,
                            'user_id' => 1,
                            'type_id' => 1, // Default tip
                            'category_id' => 9, // Kategorisiz
                            'buy_unit_id' => 1, // Default birim
                            'sale_unit_id' => 1, // Default birim
                            'buy_money_unit_id' => 1, // Default para birimi
                            'sale_money_unit_id' => 1, // Default para birimi
                            'buy_unit_price' => 0,
                            'buy_unit_price_with_tax' => 0,
                            'sale_unit_price' => 0,
                            'sale_unit_price_with_tax' => 0,
                            'buy_tax_rate' => 0,
                            'sale_tax_rate' => 0,
                            'stock_type' => 'product',
                            'stock_title' => $barkod["URUNADI"],
                            'stock_code' => $barkod['URUNKODU'],
                            'stock_barcode' => $sorgu,
                            'supplier_stock_code' => '',
                            'default_image' => 'uploads/default.png',
                            'status' => 'active',
                            'manuel_add' => "SYSMOND APİDEN EKLEME " . $barkod["STOCKREFID"] . " - " . Date("d-m-Y h:i"),
                            'has_variant' => 0,
                            'stock_tracking' => 0,
                            'sysmond' => $barkod["STOCKREFID"] // Sysmond ID'sini kaydediyoruz
                        ];
                    
                        // Stok kaydı oluştur
                        $this->modelStock->insert($stockData);
                        $new_stock_id = $this->modelStock->getInsertID();
                    
                        // Reçete oluştur
                        $recipe_data = [
                            'stock_id' => $new_stock_id,
                            'recipe_title' => $barkod["URUNADI"] . '_recipe',
                        ];
                        $this->modelStockRecipe->insert($recipe_data);
                    
                        // Log kaydı oluştur
                        $this->createSysmondLog(
                            $new_stock_id,
                            $barkod["STOCKREFID"],
                            $stockData,
                            'SYSMOND TARAFINDAN YENİ ÜRÜN EKLENDİ'
                        );
                    
                        $stats['eslesmeyenler'][] = [
                            'urun_kodu' => $barkod['URUNKODU'],
                            'urun_adi' => $barkod['URUNADI'],
                            'sysmond_id' => $barkod['STOCKREFID'],
                            'grup' => $barkod['GROUPCODE']
                        ];
                    }

                } catch (\Exception $e) {
                    $stats['hata_alinan']++;
                    log_message('error', 'Ürün işleme hatası: ' . $e->getMessage() . ' - Ürün Kodu: ' . $barkod['URUNKODU']);
                    continue;
                }
            }
            $offset += $chunk_size;
            
            // Her chunk sonrası belleği temizle
            gc_collect_cycles();
        }

        $db->transCommit();

        // Özet rapor
        $ozet = [
            'Toplam Sysmond Ürün' => $stats['toplam_sysmond_urun'],
            'Stokta Bulunan' => $stats['stokta_bulunan'],
            'Barkodda Bulunan' => $stats['barkodda_bulunan'],
            'Güncellenen' => $stats['guncellenen'],
            'Eşleşmeyen' => count($stats['eslesmeyenler']),
            'Hata Alınan' => $stats['hata_alinan']
        ];

        // Detaylı rapor oluştur
        $rapor = "SYSMOND GÜNCELLEME RAPORU\n";
        $rapor .= "Tarih: " . date('Y-m-d H:i:s') . "\n\n";
        
        foreach ($ozet as $baslik => $deger) {
            $rapor .= str_pad($baslik, 20) . ": " . $deger . "\n";
        }

        // Eşleşmeyen ürünleri grupla
        $grupluEslesmeyenler = [];
        foreach ($stats['eslesmeyenler'] as $urun) {
            $grup = $urun['grup'] ?? 'Diğer';
            if (!isset($grupluEslesmeyenler[$grup])) {
                $grupluEslesmeyenler[$grup] = [];
            }
            $grupluEslesmeyenler[$grup][] = $urun;
        }

        if (!empty($grupluEslesmeyenler)) {
            $rapor .= "\nEŞLEŞMEYEN ÜRÜNLER (Gruplara Göre):\n";
            foreach ($grupluEslesmeyenler as $grup => $urunler) {
                $rapor .= "\n$grup (" . count($urunler) . " ürün):\n";
                foreach ($urunler as $urun) {
                    $rapor .= "- {$urun['urun_kodu']} | {$urun['urun_adi']}\n";
                }
            }
        }

        // Log dosyasına kaydet
        log_message('info', $rapor);

        return [
            'status' => true,
            'message' => 'İşlem tamamlandı',
            'ozet' => $ozet,
            'detayli_rapor' => $rapor
        ];

    } catch (\Exception $e) {
        $db->transRollback();
        log_message('error', '[Sysmond::sysmondToWebEklenmeyenler] Hata: ' . $e->getMessage());
        
        return [
            'status' => false,
            'message' => 'İşlem sırasında hata: ' . $e->getMessage()
        ];
    }
}




// Yardımcı fonksiyonlar
private function convertBarcodeNumber($BarkodlardanBul) {
    if (!$BarkodlardanBul) {
        return generate_barcode_number_fams();
    }
    
    $barcode_number = $BarkodlardanBul["BARCODE"];
    return strlen($barcode_number) < 13 
        ? convert_barcode_number_for_sql_productions($barcode_number)
        : convert_barcode_number_for_sqls($barcode_number);
}

private function convertBarcodeNumber_secmeli($BarkodlardanBul) {
    if (!$BarkodlardanBul) {
        return generate_barcode_number_fams();
    }
    
    $barcode_number = $BarkodlardanBul["BARCODE"];
    if($barcode_number )
    return strlen($barcode_number) < 13 
        ? convert_barcode_number_for_sql_productions($barcode_number)
        : convert_barcode_number_for_sqls($barcode_number);
}

private function getSysmondBilgileri($stockId) {
    return $this->modelSysmond->where("STOCKID", $stockId)->first();
}

private function combineSpecCodes($SysmondBilgiler) {
    $specCodes = [
        $SysmondBilgiler["SPECCODE9"] ?? '',
        $SysmondBilgiler["SPECCODE10"] ?? ''
    ];
    return implode(", ", array_filter($specCodes));
}

private function createSysmondLog($stockId, $sysmondStockId, $updatedData, $logText) {
    $logData = [
        'sysmond_stockid' => $sysmondStockId,
        'stock_id' => $stockId,
        'updated_data' => json_encode($updatedData),
        'log_text' => $logText,
        'user_id' => 1,
        'client_id' => 1,
        'ip_address' => $this->request->getIPAddress(),
        'browser' => $this->request->getUserAgent()->getBrowser(),
        'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
    ];
    
    $this->modelSysmondLog->insert($logData);
}

private function updateExistingStock($urun, $barkod, $combinedSpecCodes, $sorgu) {
    $updateData = [
        'stock_title' => $barkod["STOCKNAME"],
        'warehouse_address' => $combinedSpecCodes,
        'sysmond' => $barkod["STOCKID"]
    ];
    
    $this->modelStock->update($urun["stock_id"], $updateData);
    
    $this->createSysmondLog(
        $urun['stock_id'],
        $barkod["STOCKID"],
        $updateData,
        'Sysmond verileri güncellendi'
    );
}

private function createNewStock($barkod, $SysmondBilgiler, $sorgu) {
    // Temel stok bilgilerini hazırla
    $stockData = $this->prepareStockData($barkod, $SysmondBilgiler, $sorgu);
    
    // Stok kaydı oluştur
    $this->modelStock->insert($stockData);
    $new_stock_id = $this->modelStock->getInsertID();
    
    // Reçete oluştur
    $this->createRecipe($new_stock_id, $stockData['stock_title']);
    
    // Servis tipi ürün için barkod oluştur
    if ($stockData['stock_type'] == 'service') {
        $this->createServiceBarcode($new_stock_id);
    }
    
    // Log kaydı oluştur
    $this->createSysmondLog(
        $new_stock_id,
        $barkod["STOCKID"],
        $SysmondBilgiler,
        'SYSMOND TARAFINDAN APİDEN EKLENDİ'
    );
}

private function prepareStockData($barkod, $SysmondBilgiler, $sorgu) {
    // Para birimi ve birim tiplerini al
    $paraTipi = $this->modelMoneyUnit->where("money_code", $SysmondBilgiler["CURRCODE"])->first();
    $para_type = $paraTipi ? $paraTipi["money_unit_id"] : 1;
    
    $birimi = ($SysmondBilgiler["UNITNAME"] == "KG") ? "kg" : $SysmondBilgiler["UNITNAME"];
    $birimType = $this->modelUnit->where("unit_title", $birimi)->first();
    $birim_type = $birimType ? $birimType["unit_id"] : 1;
    
    // Stok tipi kontrolü
    $tip = $SysmondBilgiler["STOCKTYPENAME"];
    $StokTipi = $this->modelType->where("type_title", $tip)->first();
    $type_id = $StokTipi ? $StokTipi["type_id"] : 1;
    
    // Stok kodu oluştur
    $temp_stock_code = $this->getStockCode(9, $SysmondBilgiler["STOCKNO"]);
    $stock_code = $temp_stock_code['icon'] == 'success' ? $temp_stock_code['value'] : $SysmondBilgiler["STOCKNO"];
    
    return [
        'parent_id' => 0,
        'user_id' => 1,
        'type_id' => $type_id,
        'category_id' => 9, // Kategorisiz
        'buy_unit_id' => $birim_type,
        'sale_unit_id' => $birim_type,
        'buy_money_unit_id' => $para_type,
        'sale_money_unit_id' => $para_type,
        'buy_unit_price' => 0,
        'buy_unit_price_with_tax' => 0,
        'sale_unit_price' => 0,
        'sale_unit_price_with_tax' => 0,
        'buy_tax_rate' => 0,
        'sale_tax_rate' => 0,
        'stock_type' => 'product',
        'stock_title' => $SysmondBilgiler["STOCKNAME"],
        'stock_code' => $stock_code,
        'stock_barcode' => $sorgu,
        'supplier_stock_code' => '',
        'default_image' => 'uploads/default.png',
        'status' => 'active',
        'manuel_add' => "SYSMOND APİDEN EKLEME " . $SysmondBilgiler["STOCKID"] . " - " . Date("d-m-Y h:i"),
        'has_variant' => 0,
        'stock_tracking' => 0,
    ];
}

private function createRecipe($stock_id, $stock_title) {
    $recipe_data = [
        'stock_id' => $stock_id,
        'recipe_title' => $stock_title . '_recipe',
    ];
    $this->modelStockRecipe->insert($recipe_data);
}

private function createServiceBarcode($stock_id) {
    $warehouse_item = $this->modelWarehouse
        ->where('user_id', 1)
        ->where('default', 'true')
        ->first();
    
    $barcode_data = [
        'stock_id' => $stock_id,
        'warehouse_id' => $warehouse_item['warehouse_id'] ?? 0,
        'warehouse_address' => $warehouse_item['warehouse_title'] ?? '',
        'barcode_number' => generate_barcode_number(),
        'total_amount' => 0,
        'used_amount' => 0
    ];
    
    $this->modelStockBarcode->insert($barcode_data);
}


    public function sysmondFullStock() {
        // Debug toolbar'ı devre dışı bırak
        $this->response->noCache();
        $this->response->setHeader('CI_DEBUG', 'false');
        
        ini_set('memory_limit', '1024M'); // Bellek limitini artır
        gc_enable(); // Garbage collector'ı aktif et
        
        $curl = curl_init();
                 //       "Query": "DECLARE @SIRKETID INT = 56 DECLARE @FIYAT1ID INT = 25 DECLARE @FIYAT2ID INT = 32 DECLARE @MERKEZDEPO INT = 22 DECLARE @BILGI1DEPO INT = 22 DECLARE @BILGI2DEPO INT = 22 DECLARE @EDITDATE DATETIME = CONVERT(DATETIME,\'01.01.2025\',104) SELECT S.COMPANYID, S.STOCKID STOCKREFID, S.STOCKNO URUNKODU, S.GROUPCODE GROUPCODE, S.SPECCODE1 SPECCODE1, SPECCODE2, S.SPECCODE3 SPECCODE3, S.SPECCODE4 SPECCODE4, S.SPECCODE5 SPECCODE5, S.SPECCODE6 SPECCODE6, S.SPECCODE7 SPECCODE7, S.SPECCODE8 SPECCODE8, S.SPECCODE9 SPECCODE9, S.SPECCODE10 SPECCODE10, S.SEASON SEASON, S.BRAND BRAND, S.MODEL MODEL, S.MINORDERQUANTITY, (SELECT COUNT(ITEMNO) RESIMSAY FROM STOCKPICTURE WHERE COMPANYID = @SIRKETID AND STOCKID = S.STOCKID ) AS RESIMSAY, ISNULL( (SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'1\') ,\'\') BARKOD1, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'2\') ,\'\') BARKOD2, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'3\') ,\'\') BARKOD3, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'4\') ,\'\') BARKOD4, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'5\') ,\'\') BARKOD5, (SELECT TOP 1 DESCRIPTION FROM GLBSPECDEF WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND ROOT = \'VE_STOCK\' AND ROOTFIELD = \'BRAND\' AND CODE = S.BRAND) MARKA, STOCKNAME URUNADI, STOCKNAME2 URUNADI2, (SELECT NOTES FROM NOTES WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND NOTES.NOTESID = S.NOTEID) NOTLAR, ISNULL((SELECT PRICE FROM STOCKPRICE WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND STOCKPRICETYPEID = @FIYAT1ID),0) FIYAT1, ISNULL((SELECT PRICE FROM STOCKPRICE WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND STOCKPRICETYPEID = @FIYAT2ID),0) FIYAT2, S.CURRCODE DOVIZ, S.VATSALES KDV, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID),0) TOPLAMMIKTARI, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @MERKEZDEPO),0) MERKEZDEPOMIKTAR, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @BILGI1DEPO),0) BILGIDEPO1, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @BILGI2DEPO),0) BILGIDEPO2, ISNULL((SELECT SUM(OI.QUANTITY) - SUM(OI.DQUANTITY) ACIKSIPMIK FROM ORDERS O WITH(NOLOCK) INNER JOIN ORDERSITEM OI WITH(NOLOCK) ON O.COMPANYID = OI.COMPANYID AND O.RECEIPTID = OI.RECEIPTID AND O.STATUS =2 AND STOCKID = S.STOCKID WHERE O.COMPANYID=S.COMPANYID AND O.TRANSTYPE = 103),0) acik_sip_miktari, S.UNITNAME BIRIM, S.MATRIX, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID) AS MATRIX1, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID2) AS MATRIX2, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID3) AS MATRIX3 FROM VE_STOCK S WITH(NOLOCK) WHERE COMPANYID = @SIRKETID  AND  Isnull(MATRIXSTOCKID, 0) = 0 AND EDITDATE >= @EDITDATE ",

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://85.105.220.154:8640/TrexIntegrationService/REST/GetObject',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "Query": "DECLARE @SIRKETID INT = 56 DECLARE @FIYAT1ID INT = 25 DECLARE @FIYAT2ID INT = 32 DECLARE @MERKEZDEPO INT = 22 DECLARE @BILGI1DEPO INT = 22 DECLARE @BILGI2DEPO INT = 22  SELECT S.COMPANYID, S.STOCKID STOCKREFID, S.STOCKNO URUNKODU, S.GROUPCODE GROUPCODE, S.SPECCODE1 SPECCODE1, SPECCODE2, S.SPECCODE3 SPECCODE3, S.SPECCODE4 SPECCODE4, S.SPECCODE5 SPECCODE5, S.SPECCODE6 SPECCODE6, S.SPECCODE7 SPECCODE7, S.SPECCODE8 SPECCODE8, S.SPECCODE9 SPECCODE9, S.SPECCODE10 SPECCODE10, S.SEASON SEASON, S.BRAND BRAND, S.MODEL MODEL, S.MINORDERQUANTITY, (SELECT COUNT(ITEMNO) RESIMSAY FROM STOCKPICTURE WHERE COMPANYID = @SIRKETID AND STOCKID = S.STOCKID ) AS RESIMSAY, ISNULL( (SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'1\') ,\'\') BARKOD1, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'2\') ,\'\') BARKOD2, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'3\') ,\'\') BARKOD3, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'4\') ,\'\') BARKOD4, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'5\') ,\'\') BARKOD5, (SELECT TOP 1 DESCRIPTION FROM GLBSPECDEF WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND ROOT = \'VE_STOCK\' AND ROOTFIELD = \'BRAND\' AND CODE = S.BRAND) MARKA, STOCKNAME URUNADI, STOCKNAME2 URUNADI2, (SELECT NOTES FROM NOTES WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND NOTES.NOTESID = S.NOTEID) NOTLAR, ISNULL((SELECT PRICE FROM STOCKPRICE WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND STOCKPRICETYPEID = @FIYAT1ID),0) FIYAT1, ISNULL((SELECT PRICE FROM STOCKPRICE WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND STOCKPRICETYPEID = @FIYAT2ID),0) FIYAT2, S.CURRCODE DOVIZ, S.VATSALES KDV, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID),0) TOPLAMMIKTARI, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @MERKEZDEPO),0) MERKEZDEPOMIKTAR, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @BILGI1DEPO),0) BILGIDEPO1, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @BILGI2DEPO),0) BILGIDEPO2, ISNULL((SELECT SUM(OI.QUANTITY) - SUM(OI.DQUANTITY) ACIKSIPMIK FROM ORDERS O WITH(NOLOCK) INNER JOIN ORDERSITEM OI WITH(NOLOCK) ON O.COMPANYID = OI.COMPANYID AND O.RECEIPTID = OI.RECEIPTID AND O.STATUS =2 AND STOCKID = S.STOCKID WHERE O.COMPANYID=S.COMPANYID AND O.TRANSTYPE = 103),0) acik_sip_miktari, S.UNITNAME BIRIM, S.MATRIX, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID) AS MATRIX1, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID2) AS MATRIX2, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID3) AS MATRIX3 FROM VE_STOCK S WITH(NOLOCK) WHERE COMPANYID = @SIRKETID AND STATUS =2 AND WebStock = 1   AND Isnull(MATRIXSTOCKID, 0) = 0  ",
                "Sirketid": "56",
                "Donemid": "57",
                "ApiKey": "1503279683"
              }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            echo 'cURL Hatası: ' . curl_error($curl);
            curl_close($curl);
            return;
        }

        curl_close($curl);

        if (empty($response)) {
            echo 'API yanıtı boş.';
            return;
        }

        $response = stripslashes($response);
        $response = trim($response, '"');
        $stockData = json_decode($response, true);





        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "JSON verisi çözümlenemedi. Hata: " . json_last_error_msg();
            return;
        }

        // Tüm kayıtları tamamen silelim
        $this->modelSysmondOnline->truncate();

        // Yeni verileri ekleyelim
        $batchSize = 100; // Her seferde 100 kayıt ekleyelim
        $chunks = array_chunk($stockData, $batchSize);
        
        foreach ($chunks as $chunk) {
            $insertData = [];
            foreach ($chunk as $item) {
                $insertData[] = [
                    'COMPANYID' => $item['COMPANYID'] ?? null,
                    'STOCKREFID' => $item['STOCKREFID'] ?? null,
                    'URUNKODU' => $item['URUNKODU'] ?? null,
                    'GROUPCODE' => $item['GROUPCODE'] ?? null,
                    'SPECCODE1' => null, //$item['SPECCODE1'] ?? null,
                    'SPECCODE2' => null, //$item['SPECCODE2'] ?? null,
                    'SPECCODE3' => null, //$item['SPECCODE3'] ?? null,
                    'SPECCODE4' => null, //$item['SPECCODE4'] ?? null,
                    'SPECCODE5' => null, //$item['SPECCODE5'] ?? null,
                    'SPECCODE6' => null, //$item['SPECCODE6'] ?? null,
                    'SPECCODE7' => null, //$item['SPECCODE7'] ?? null,
                    'SPECCODE8' => null, //$item['SPECCODE8'] ?? null,
                    'SPECCODE9' => $item['SPECCODE9'] ?? null,
                    'SPECCODE10' => $item['SPECCODE10'] ?? null,
                    'SEASON' => $item['SEASON'] ?? null,
                    'BRAND' => $item['BRAND'] ?? null,
                    'MODEL' => $item['MODEL'] ?? null,
                    'MINORDERQUANTITY' => $item['MINORDERQUANTITY'] ?? null,
                    'RESIMSAY' => $item['RESIMSAY'] ?? null,
                    'BARKOD1' => $item['BARKOD1'] ?? null,
                    'BARKOD2' => $item['BARKOD2'] ?? null,
                    'BARKOD3' => $item['BARKOD3'] ?? null,
                    'BARKOD4' => $item['BARKOD4'] ?? null,
                    'BARKOD5' => $item['BARKOD5'] ?? null,
                    'MARKA' => $item['MARKA'] ?? null,
                    'URUNADI' => $item['URUNADI'] ?? null,
                    'URUNADI2' => $item['URUNADI2'] ?? null,
                    'NOTLAR' => $item['NOTLAR'] ?? null,
                    'FIYAT1' => $item['FIYAT1'] ?? null,
                    'FIYAT2' => $item['FIYAT2'] ?? null,
                    'DOVIZ' => $item['DOVIZ'] ?? null,
                    'KDV' => $item['KDV'] ?? null,
                    'TOPLAMMIKTARI' => $item['TOPLAMMIKTARI'] ?? null,
                    'MERKEZDEPOMIKTAR' => $item['MERKEZDEPOMIKTAR'] ?? null,
                    'BILGIDEPO1' => $item['BILGIDEPO1'] ?? null,
                    'BILGIDEPO2' => $item['BILGIDEPO2'] ?? null,
                    'acik_sip_miktari' => $item['acik_sip_miktari'] ?? null,
                    'BIRIM' => $item['BIRIM'] ?? null,
                    'MATRIX' => $item['MATRIX'] ?? null,
                    'MATRIX1' => $item['MATRIX1'] ?? null,
                    'MATRIX2' => $item['MATRIX2'] ?? null,
                    'MATRIX3' => $item['MATRIX3'] ?? null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Her kayıt için log tutuyoruz
                $logData = [
                    'sysmond_stockid' => $item['STOCKREFID'],
                    'stock_id' => 0, // Henüz stock_id bilinmiyor
                    'updated_data' => json_encode($item),
                    'log_text' => 'SYSMOND ONLINE API Güncellemesi',
                    'user_id' => 1,
                    'client_id' => 1,
                    'ip_address' => $this->request->getIPAddress(),
                    'browser' => $this->request->getUserAgent()->getBrowser(),
                    'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
                ];
                $this->modelSysmondLog->insert($logData);
            }
            
            if (!empty($insertData)) {
                $this->modelSysmondOnline->insertBatch($insertData);
            }
            
            // Belleği temizle
            unset($insertData);
            gc_collect_cycles();
        }

        // Log kaydı oluştur
        $LogKaydet = [
            'tarih' => date("d-m-Y H:i"),
            'durum' => "SYSMOND ONLINE API GÜNCELLEME BAŞARILI",
            'mesaj' => "active",
            'mail'  => 1,
        ];

        $this->SysmondCronModel->insert($LogKaydet);
        $new_stock_id = $this->SysmondCronModel->getInsertID();

        // Mail gönderimi
        $datas = [
            'senk_id'    => $new_stock_id,
            'senk_tarih' => date("d-m-Y H:i"),
            'baslik'     => "SYSMOND ONLINE API Güncellendi!",
            'mesaj'      => "SYSMOND ONLINE API GÜNCELLEME BAŞARILI"
        ];

        $render_html = view('mail/page/api_error', $datas);
        
        // Mail gönderimi için alıcı listesi
        $mailList = [
            "developer@tiko.com.tr"
        ];

        foreach ($mailList as $email) {
            $data_email = [
                'email'         => $email,
                'subject'       => 'SYSMOND ONLINE API Güncelleme Bildirimi',
                'render_html'   => $render_html
            ];
           // $this->sendModel->mail_gonder($data_email);
        }

        echo "Sysmond Online veriler başarıyla güncellendi.";
        return;
    }




    public function sysmondGunlukStokHareketi() {

        $tarih = date("d.m.Y");

        // Debug toolbar'ı devre dışı bırak
        $this->response->noCache();
        $this->response->setHeader('CI_DEBUG', 'false');
        
        ini_set('memory_limit', '1024M'); // Bellek limitini artır
        gc_enable(); // Garbage collector'ı aktif et
        
        $curl = curl_init();
                 //       "Query": "DECLARE @SIRKETID INT = 56 DECLARE @FIYAT1ID INT = 25 DECLARE @FIYAT2ID INT = 32 DECLARE @MERKEZDEPO INT = 22 DECLARE @BILGI1DEPO INT = 22 DECLARE @BILGI2DEPO INT = 22 DECLARE @EDITDATE DATETIME = CONVERT(DATETIME,\'01.01.2025\',104) SELECT S.COMPANYID, S.STOCKID STOCKREFID, S.STOCKNO URUNKODU, S.GROUPCODE GROUPCODE, S.SPECCODE1 SPECCODE1, SPECCODE2, S.SPECCODE3 SPECCODE3, S.SPECCODE4 SPECCODE4, S.SPECCODE5 SPECCODE5, S.SPECCODE6 SPECCODE6, S.SPECCODE7 SPECCODE7, S.SPECCODE8 SPECCODE8, S.SPECCODE9 SPECCODE9, S.SPECCODE10 SPECCODE10, S.SEASON SEASON, S.BRAND BRAND, S.MODEL MODEL, S.MINORDERQUANTITY, (SELECT COUNT(ITEMNO) RESIMSAY FROM STOCKPICTURE WHERE COMPANYID = @SIRKETID AND STOCKID = S.STOCKID ) AS RESIMSAY, ISNULL( (SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'1\') ,\'\') BARKOD1, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'2\') ,\'\') BARKOD2, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'3\') ,\'\') BARKOD3, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'4\') ,\'\') BARKOD4, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'5\') ,\'\') BARKOD5, (SELECT TOP 1 DESCRIPTION FROM GLBSPECDEF WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND ROOT = \'VE_STOCK\' AND ROOTFIELD = \'BRAND\' AND CODE = S.BRAND) MARKA, STOCKNAME URUNADI, STOCKNAME2 URUNADI2, (SELECT NOTES FROM NOTES WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND NOTES.NOTESID = S.NOTEID) NOTLAR, ISNULL((SELECT PRICE FROM STOCKPRICE WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND STOCKPRICETYPEID = @FIYAT1ID),0) FIYAT1, ISNULL((SELECT PRICE FROM STOCKPRICE WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND STOCKPRICETYPEID = @FIYAT2ID),0) FIYAT2, S.CURRCODE DOVIZ, S.VATSALES KDV, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID),0) TOPLAMMIKTARI, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @MERKEZDEPO),0) MERKEZDEPOMIKTAR, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @BILGI1DEPO),0) BILGIDEPO1, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @BILGI2DEPO),0) BILGIDEPO2, ISNULL((SELECT SUM(OI.QUANTITY) - SUM(OI.DQUANTITY) ACIKSIPMIK FROM ORDERS O WITH(NOLOCK) INNER JOIN ORDERSITEM OI WITH(NOLOCK) ON O.COMPANYID = OI.COMPANYID AND O.RECEIPTID = OI.RECEIPTID AND O.STATUS =2 AND STOCKID = S.STOCKID WHERE O.COMPANYID=S.COMPANYID AND O.TRANSTYPE = 103),0) acik_sip_miktari, S.UNITNAME BIRIM, S.MATRIX, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID) AS MATRIX1, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID2) AS MATRIX2, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID3) AS MATRIX3 FROM VE_STOCK S WITH(NOLOCK) WHERE COMPANYID = @SIRKETID  AND  Isnull(MATRIXSTOCKID, 0) = 0 AND EDITDATE >= @EDITDATE ",

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://85.105.220.154:8640/TrexIntegrationService/REST/GetObject',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "Query": "DECLARE @SIRKETID INT = 56 DECLARE @FIYAT1ID INT = 25 DECLARE @FIYAT2ID INT = 32 DECLARE @MERKEZDEPO INT = 22 DECLARE @BILGI1DEPO INT = 22 DECLARE @BILGI2DEPO INT = 22 DECLARE @EDITDATE DATETIME = CONVERT(DATETIME,\''.$tarih.'\',104) SELECT S.COMPANYID, S.STOCKID STOCKREFID, S.STOCKNO URUNKODU, S.GROUPCODE GROUPCODE, S.SPECCODE1 SPECCODE1, SPECCODE2, S.SPECCODE3 SPECCODE3, S.SPECCODE4 SPECCODE4, S.SPECCODE5 SPECCODE5, S.SPECCODE6 SPECCODE6, S.SPECCODE7 SPECCODE7, S.SPECCODE8 SPECCODE8, S.SPECCODE9 SPECCODE9, S.SPECCODE10 SPECCODE10, S.SEASON SEASON, S.BRAND BRAND, S.MODEL MODEL, S.MINORDERQUANTITY, (SELECT COUNT(ITEMNO) RESIMSAY FROM STOCKPICTURE WHERE COMPANYID = @SIRKETID AND STOCKID = S.STOCKID ) AS RESIMSAY, ISNULL( (SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'1\') ,\'\') BARKOD1, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'2\') ,\'\') BARKOD2, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'3\') ,\'\') BARKOD3, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'4\') ,\'\') BARKOD4, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'5\') ,\'\') BARKOD5, (SELECT TOP 1 DESCRIPTION FROM GLBSPECDEF WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND ROOT = \'VE_STOCK\' AND ROOTFIELD = \'BRAND\' AND CODE = S.BRAND) MARKA, STOCKNAME URUNADI, STOCKNAME2 URUNADI2, (SELECT NOTES FROM NOTES WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND NOTES.NOTESID = S.NOTEID) NOTLAR, ISNULL((SELECT PRICE FROM STOCKPRICE WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND STOCKPRICETYPEID = @FIYAT1ID),0) FIYAT1, ISNULL((SELECT PRICE FROM STOCKPRICE WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND STOCKPRICETYPEID = @FIYAT2ID),0) FIYAT2, S.CURRCODE DOVIZ, S.VATSALES KDV, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID),0) TOPLAMMIKTARI, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @MERKEZDEPO),0) MERKEZDEPOMIKTAR, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @BILGI1DEPO),0) BILGIDEPO1, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @BILGI2DEPO),0) BILGIDEPO2, ISNULL((SELECT SUM(OI.QUANTITY) - SUM(OI.DQUANTITY) ACIKSIPMIK FROM ORDERS O WITH(NOLOCK) INNER JOIN ORDERSITEM OI WITH(NOLOCK) ON O.COMPANYID = OI.COMPANYID AND O.RECEIPTID = OI.RECEIPTID AND O.STATUS =2 AND STOCKID = S.STOCKID WHERE O.COMPANYID=S.COMPANYID AND O.TRANSTYPE = 103),0) acik_sip_miktari, S.UNITNAME BIRIM, S.MATRIX, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID) AS MATRIX1, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID2) AS MATRIX2, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID3) AS MATRIX3 FROM VE_STOCK S WITH(NOLOCK) WHERE COMPANYID = @SIRKETID AND STATUS =2 AND WEBSTOCK = 1 AND Isnull(MATRIXSTOCKID, 0) = 0 AND EDITDATE >= @EDITDATE ",
                "Sirketid": "56",
                "Donemid": "57",
                "ApiKey": "1503279683"
              }',
                CURLOPT_HTTPHEADER => array(
                  'Content-Type: application/json',
                  'Accept: application/json'
                ),
              ));

        $response = curl_exec($curl);

        if ($response === false) {
            echo 'cURL Hatası: ' . curl_error($curl);
            curl_close($curl);
            return;
        }

        curl_close($curl);

        if (empty($response)) {
            echo 'API yanıtı boş.';
            return;
        }

        $response = stripslashes($response);
        $response = trim($response, '"');
        $stockData = json_decode($response, true);


       





        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "JSON verisi çözümlenemedi. Hata: " . json_last_error_msg();
            return;
        }

        // Tüm kayıtları tamamen silelim
        $this->modelSysmondOnlineGunluk->truncate();

        // Yeni verileri ekleyelim
        $batchSize = 100; // Her seferde 100 kayıt ekleyelim
        $chunks = array_chunk($stockData, $batchSize);
        
        foreach ($chunks as $chunk) {
            $insertData = [];
            foreach ($chunk as $item) {
                $insertData[] = [
                    'COMPANYID' => $item['COMPANYID'] ?? null,
                    'STOCKREFID' => $item['STOCKREFID'] ?? null,
                    'URUNKODU' => $item['URUNKODU'] ?? null,
                    'GROUPCODE' => $item['GROUPCODE'] ?? null,
                    'SPECCODE1' => null, //$item['SPECCODE1'] ?? null,
                    'SPECCODE2' => null, //$item['SPECCODE2'] ?? null,
                    'SPECCODE3' => null, //$item['SPECCODE3'] ?? null,
                    'SPECCODE4' => null, //$item['SPECCODE4'] ?? null,
                    'SPECCODE5' => null, //$item['SPECCODE5'] ?? null,
                    'SPECCODE6' => null, //$item['SPECCODE6'] ?? null,
                    'SPECCODE7' => null, //$item['SPECCODE7'] ?? null,
                    'SPECCODE8' => null, //$item['SPECCODE8'] ?? null,
                    'SPECCODE9' => $item['SPECCODE9'] ?? null,
                    'SPECCODE10' => $item['SPECCODE10'] ?? null,
                    'SEASON' => $item['SEASON'] ?? null,
                    'BRAND' => $item['BRAND'] ?? null,
                    'MODEL' => $item['MODEL'] ?? null,
                    'MINORDERQUANTITY' => $item['MINORDERQUANTITY'] ?? null,
                    'RESIMSAY' => $item['RESIMSAY'] ?? null,
                    'BARKOD1' => $item['BARKOD1'] ?? null,
                    'BARKOD2' => $item['BARKOD2'] ?? null,
                    'BARKOD3' => $item['BARKOD3'] ?? null,
                    'BARKOD4' => $item['BARKOD4'] ?? null,
                    'BARKOD5' => $item['BARKOD5'] ?? null,
                    'MARKA' => $item['MARKA'] ?? null,
                    'URUNADI' => $item['URUNADI'] ?? null,
                    'URUNADI2' => $item['URUNADI2'] ?? null,
                    'NOTLAR' => $item['NOTLAR'] ?? null,
                    'FIYAT1' => $item['FIYAT1'] ?? null,
                    'FIYAT2' => $item['FIYAT2'] ?? null,
                    'DOVIZ' => $item['DOVIZ'] ?? null,
                    'KDV' => $item['KDV'] ?? null,
                    'TOPLAMMIKTARI' => $item['TOPLAMMIKTARI'] ?? null,
                    'MERKEZDEPOMIKTAR' => $item['MERKEZDEPOMIKTAR'] ?? null,
                    'BILGIDEPO1' => $item['BILGIDEPO1'] ?? null,
                    'BILGIDEPO2' => $item['BILGIDEPO2'] ?? null,
                    'acik_sip_miktari' => $item['acik_sip_miktari'] ?? null,
                    'BIRIM' => $item['BIRIM'] ?? null,
                    'MATRIX' => $item['MATRIX'] ?? null,
                    'MATRIX1' => $item['MATRIX1'] ?? null,
                    'MATRIX2' => $item['MATRIX2'] ?? null,
                    'MATRIX3' => $item['MATRIX3'] ?? null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Her kayıt için log tutuyoruz
                $logData = [
                    'sysmond_stockid' => $item['STOCKREFID'],
                    'stock_id' => 0, // Henüz stock_id bilinmiyor
                    'updated_data' => json_encode($item),
                    'log_text' => 'SYSMOND ONLINE API Güncellemesi',
                    'user_id' => 1,
                    'client_id' => 1,
                    'ip_address' => $this->request->getIPAddress(),
                    'browser' => $this->request->getUserAgent()->getBrowser(),
                    'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
                ];
                $this->modelSysmondLog->insert($logData);
            }
            
            if (!empty($insertData)) {
                $this->modelSysmondOnlineGunluk->insertBatch($insertData);
            }
            
            // Belleği temizle
            unset($insertData);
            gc_collect_cycles();
        }

        /* 
        $tarihFull = $tarih  . " ". Date("H:i:s");
        // Log kaydı oluştur
        $LogKaydet = [
            'tarih' => date("d-m-Y H:i"),
            'durum' => "Günlük Sysmond Online API Güncellendi - ". $tarihFull .  " ",
            'mesaj' => "active",
            'mail'  => 1,
        ];

        $this->SysmondCronModel->insert($LogKaydet);
        $new_stock_id = $this->SysmondCronModel->getInsertID();
          $datas = [
            'senk_id'    => $new_stock_id,
            'senk_tarih' => date("d-m-Y H:i"),
            'baslik'     => "Günlük Sysmond Online API Güncellendi - ". $tarihFull .  " ",
            'mesaj'      => "Günlük Sysmond Online API Güncellendi - ". $tarihFull .  " "
        ];

        $render_html = view('mail/page/api_error', $datas);
        
        // Mail gönderimi için alıcı listesi
        $mailList = [
            "developer@tiko.com.tr"
        ];

        foreach ($mailList as $email) {
            $data_email = [
                'email'         => $email,
                'subject'       => 'SYSMOND ONLINE API Güncelleme Bildirimi',
                'render_html'   => $render_html
            ];
           // $this->sendModel->mail_gonder($data_email);
        }
        */

        // Mail gönderimi
      

        $this->stokesitle_gunluk();
    }




    public function stokesitle_gunluk(){
        // Debug toolbar'ı devre dışı bırak
        $this->response->noCache();
        $this->response->setHeader('CI_DEBUG', 'false');

        // Memory limit ve timeout ayarları
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 900); // 15 dakika
        set_time_limit(900);
        
        // Garbage collection'ı aktif et
        gc_enable();

        // Test için sadece 5 kayıt alacağız
        $TumVeriler = $this->modelSysmondOnlineGunluk->findAll();
        $totalProcessed = 0;


            
        foreach ($TumVeriler as $item) {
            try {
                echo "İşlenen kayıt: " . ($totalProcessed + 1) . " - STOCKREFID: " . $item['STOCKREFID'] . "\n";
               
                $stock = $this->modelStock
                                        ->Where("stock_code", $item['URUNKODU'])
                                        ->first();
            
                                       
                
                if($stock){


                   $this->modelStock->set("sysmond", $item['STOCKREFID'])->where("stock_id", $stock['stock_id'])->update();

                    // Stok miktarı karşılaştırma
                    $apiStokMiktari = (float)$item['TOPLAMMIKTARI'];
                    $dbStokMiktari = (float)$stock['stock_total_quantity'];
                    $fark = $apiStokMiktari - $dbStokMiktari;
                    
                    if($fark != 0) {
                        $anlikTarih = new Time('now', 'Turkey', 'en_US');
                        $textMesaj = "Sysmond senkronizasyonu: ".$anlikTarih->toDateTimeString()." tarihinde ".abs($fark)." adet ".$item['URUNKODU']." ".($fark > 0 ? "stok girişi" : "stok düşümü")." (API: ".$apiStokMiktari.", DB: ".$dbStokMiktari.")";
                        
                        echo $textMesaj . "\n";


                        //$modelBarkodlar = $this->modelSysmondBarkod->where("STOCKID", $item['STOCKREFID'])->where("BARCODETYPENAME", "Aktif")->first();
                        $modelBarkodlar = $this->modelSysmondBarkod->where("STOCKID", $item['STOCKREFID'])->first();

                        

                        if($modelBarkodlar){
                            $barkodBul = $this->convertBarcodeNumber($modelBarkodlar);
                            $barkod = $barkodBul;
                            $this->modelStock->set("stock_barcode", $barkod)->where("stock_id", $stock['stock_id'])->update();

                        }

                        $this->modelStock->set("stock_total_quantity", $apiStokMiktari)->where("stock_id", $stock['stock_id'])->update();
                        
                       
                        $orderStoks = new \App\Controllers\TikoERP\Order();
                        if($fark > 0) {
                            $orderStoks->stokGiris($stock['stock_id'], abs($fark), 1, $textMesaj);
                            echo "Stok girişi yapıldı\n";
                        } else {
                            $orderStoks->stokDusum($stock['stock_id'], abs($fark), 1, $textMesaj);
                            echo "Stok düşümü yapıldı\n";
                        }
                       

                        // Log kaydı oluştur
                        $logData = [
                            'sysmond_stockid' => $item['STOCKREFID'],
                            'stock_id' => $stock['stock_id'],
                            'updated_data' => json_encode([
                                'old_quantity' => $dbStokMiktari,
                                'new_quantity' => $apiStokMiktari,
                                'difference' => $fark
                            ]),
                            'log_text' => 'Stok miktarı SYSMOND API ile senkronize edildi (TEST)',
                            'user_id' => 1,
                            'client_id' => 1,
                            'ip_address' => $this->request->getIPAddress(),
                            'browser' => $this->request->getUserAgent()->getBrowser(),
                            'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
                        ];
                        $this->modelSysmondLog->insert($logData);
                        echo "Log kaydı oluşturuldu\n";
                    } else {
                        echo "Stok miktarı aynı, güncelleme yapılmadı\n";
                    }
                } else {
                    echo "Stok bulunamadı: " . $item['STOCKREFID'] . "\n";
                }
            } catch (\Exception $e) {
                echo "Hata oluştu: " . $e->getMessage() . " - StockID: " . $item['STOCKREFID'] . "\n";
                continue;
            }
            
            $totalProcessed++;
            echo "-------------------\n";
        }
        
        // İşlem tamamlandı bildirimi
        $LogKaydet = [
            'tarih' => date("d-m-Y H:i"),
            'durum' => "GÜNLÜK ( ".date("d-m-Y H:i:s")." ) SYSMOND STOK  SENKRONİZASYONU TAMAMLANDI İŞLENEN KAYIT SAYISI: ".$totalProcessed,
            'mesaj' => "active",
            'mail'  => 1,
            'processed_records' => $totalProcessed
        ];
        
        $this->SysmondCronModel->insert($LogKaydet);
        echo "Günlük senkronizasyonu tamamlandı. İşlenen kayıt sayısı: $totalProcessed";
        return;
    }


    public function stokesitle(){
        // Debug toolbar'ı devre dışı bırak
        $this->response->noCache();
        $this->response->setHeader('CI_DEBUG', 'false');

        // Memory limit ve timeout ayarları
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 900); // 15 dakika
        set_time_limit(900);
        
        // Garbage collection'ı aktif et
        gc_enable();

        // Test için sadece 5 kayıt alacağız
        $TumVeriler = $this->modelSysmondOnline->findAll();
        $totalProcessed = 0;

        echo "Test için ilk 5 kayıt işlenecek...\n";
            
        foreach ($TumVeriler as $item) {
            try {
                echo "İşlenen kayıt: " . ($totalProcessed + 1) . " - STOCKREFID: " . $item['STOCKREFID'] . "\n";
               
                $stock = $this->modelStock
                                        ->Where("stock_code", $item['URUNKODU'])
                                        ->first();
            
                                       
                
                if($stock){


                   $this->modelStock->set("sysmond", $item['STOCKREFID'])->where("stock_id", $stock['stock_id'])->update();

                    // Stok miktarı karşılaştırma
                    $apiStokMiktari = (float)$item['TOPLAMMIKTARI'];
                    $dbStokMiktari = (float)$stock['stock_total_quantity'];
                    $fark = $apiStokMiktari - $dbStokMiktari;
                    
                    if($fark != 0) {
                        $anlikTarih = new Time('now', 'Turkey', 'en_US');
                        $textMesaj = "Sysmond senkronizasyonu: ".$anlikTarih->toDateTimeString()." tarihinde ".abs($fark)." adet ".$item['URUNKODU']." ".($fark > 0 ? "stok girişi" : "stok düşümü")." (API: ".$apiStokMiktari.", DB: ".$dbStokMiktari.")";
                        
                        echo $textMesaj . "\n";


                        //$modelBarkodlar = $this->modelSysmondBarkod->where("STOCKID", $item['STOCKREFID'])->where("BARCODETYPENAME", "Aktif")->first();
                        $modelBarkodlar = $this->modelSysmondBarkod->where("STOCKID", $item['STOCKREFID'])->first();
                        $barkodBul = $this->convertBarcodeNumber($modelBarkodlar);

                        if($barkodBul){
                            $barkod = $barkodBul;
                            $this->modelStock->set("stock_barcode", $barkod)->where("stock_id", $stock['stock_id'])->update();

                        }

                        $this->modelStock->set("stock_total_quantity", $apiStokMiktari)->where("stock_id", $stock['stock_id'])->update();
                        
                       /* 
                        $orderStoks = new \App\Controllers\TikoERP\Order();
                        if($fark > 0) {
                            $orderStoks->stokGiris($stock['stock_id'], abs($fark), 1, $textMesaj);
                            echo "Stok girişi yapıldı\n";
                        } else {
                            $orderStoks->stokDusum($stock['stock_id'], abs($fark), 1, $textMesaj);
                            echo "Stok düşümü yapıldı\n";
                        }
                       */

                        // Log kaydı oluştur
                        $logData = [
                            'sysmond_stockid' => $item['STOCKREFID'],
                            'stock_id' => $stock['stock_id'],
                            'updated_data' => json_encode([
                                'old_quantity' => $dbStokMiktari,
                                'new_quantity' => $apiStokMiktari,
                                'difference' => $fark
                            ]),
                            'log_text' => 'Stok miktarı SYSMOND API ile senkronize edildi (TEST)',
                            'user_id' => 1,
                            'client_id' => 1,
                            'ip_address' => $this->request->getIPAddress(),
                            'browser' => $this->request->getUserAgent()->getBrowser(),
                            'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
                        ];
                        $this->modelSysmondLog->insert($logData);
                        echo "Log kaydı oluşturuldu\n";
                    } else {
                        echo "Stok miktarı aynı, güncelleme yapılmadı\n";
                    }
                } else {
                    echo "Stok bulunamadı: " . $item['STOCKREFID'] . "\n";
                }
            } catch (\Exception $e) {
                echo "Hata oluştu: " . $e->getMessage() . " - StockID: " . $item['STOCKREFID'] . "\n";
                continue;
            }
            
            $totalProcessed++;
            echo "-------------------\n";
        }
        
        // İşlem tamamlandı bildirimi
        $LogKaydet = [
            'tarih' => date("d-m-Y H:i"),
            'durum' => "SYSMOND STOK  SENKRONİZASYONU TAMAMLANDI İŞLENEN KAYIT SAYISI: ".$totalProcessed,
            'mesaj' => "active",
            'mail'  => 1,
            'processed_records' => $totalProcessed
        ];
        
        $this->SysmondCronModel->insert($LogKaydet);
        echo "Test senkronizasyonu tamamlandı. İşlenen kayıt sayısı: $totalProcessed";
        return;
    }
    public function index() {
        // cURL başlatma
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://85.105.220.154:8640/TrexIntegrationService/REST/GetStock',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'Sirketid' => $this->sirketID,
                'ApiKey' => $this->ApiKey,
                'editdate' => ''
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));
    
        $response = curl_exec($curl);
    
        // cURL hatalarını kontrol et
        if ($response === false) {
            echo 'cURL Hatası: ' . curl_error($curl);
            curl_close($curl);
            return;
        }
    
        curl_close($curl);
    
        // Yanıtın boş olup olmadığını kontrol et
        if (empty($response)) {
            echo 'API yanıtı boş.';
            return;
        }
    
        // Kaçış karakterlerini temizle
        $response = stripslashes($response);
    
        // Baş ve sondaki çift tırnakları kaldır (eğer varsa)
        $response = trim($response, '"');
    
        // JSON'u PHP dizisine dönüştür
        $stockData = json_decode($response, true);


        ///
        ///   [SPECCODE9] => CCT01-E1-5 ikisi üzerinde güncelleme yapılacak
       //     [SPECCODE10] => ÖNP02-A2
        //


    

    


    
        // JSON verisinin doğru şekilde çözümlenip çözümlenmediğini kontrol et
        if (json_last_error() === JSON_ERROR_NONE) {
            // Tüm eklemeleri toplu olarak gerçekleştirmek için bir diziye ekle
            $batchInsertData = [];
            $batchUpdateData = [];
    
            foreach ($stockData as $item) {
                // Mevcut kayıt var mı kontrol et
                $existingRecord = $this->modelSysmond->where("STOCKID", $item['STOCKID'])->first();
    
                // Değişiklikleri kaydetmek için değişiklik listesi
                $changes = [];
    
                if (!$existingRecord) {
                    // Eğer kayıt yoksa eklemek için diziyi doldur
                    $batchInsertData[] = [
                        'COMPANYID' => $item['COMPANYID'] ?? null,
                        'STOCKID' => $item['STOCKID'] ?? null,
                        'STOCKTYPENAME' => $item['STOCKTYPENAME'] ?? null,
                        'STOCKTYPE' => $item['STOCKTYPE'] ?? null,
                        'STOCKNO' => $item['STOCKNO'] ?? null,
                        'STOCKNAME' => $item['STOCKNAME'] ?? null,
                        'GROUPCODE' => $item['GROUPCODE'] ?? null,
                        'SEASON' => $item['SEASON'] ?? null,
                        'BRAND' => $item['BRAND'] ?? null,
                        'MODEL' => $item['MODEL'] ?? null,
                        'SPECCODE1' => null,//$item['SPECCODE1'] ?? null,
                        'SPECCODE2' => null,//$item['SPECCODE2'] ?? null,
                        'EMPLOYEENO' => $item['EMPLOYEENO'] ?? null,
                        'EMPLOYEENAME' => $item['EMPLOYEENAME'] ?? null,
                        'EMPLOYEETYPE' => $item['EMPLOYEETYPE'] ?? null,
                        'EMPLOYEEID' => $item['EMPLOYEEID'] ?? null,
                        'STATUSNAME' => $item['STATUSNAME'] ?? null,
                        'STATUS' => $item['STATUS'] ?? null,
                        'NOTEID' => $item['NOTEID'] ?? null,
                        'CANCELDATE' => $item['CANCELDATE'] ?? null,
                        'DESCRIPTION' => $item['DESCRIPTION'] ?? null,
                        'DEBIT' => $item['DEBIT'] ?? null,
                        'CREDIT' => $item['CREDIT'] ?? null,
                        'REMTOTAL' => $item['REMTOTAL'] ?? null,
                        'REMTYPENAME' => $item['REMTYPENAME'] ?? null,
                        'REMTYPE' => $item['REMTYPE'] ?? null,
                        'CURRCODE' => $item['CURRCODE'] ?? null,
                        'CURRDEBIT' => $item['CURRDEBIT'] ?? null,
                        'CURRCREDIT' => $item['CURRCREDIT'] ?? null,
                        'CURRREMTOTAL' => $item['CURRREMTOTAL'] ?? null,
                        'CURRREMTYPENAME' => $item['CURRREMTYPENAME'] ?? null,
                        'CURRREMTYPE' => $item['CURRREMTYPE'] ?? null,
                        'QENTRY' => $item['QENTRY'] ?? null,
                        'QEXIT' => $item['QEXIT'] ?? null,
                        'QREM' => $item['QREM'] ?? null,
                        'QREM2' => $item['QREM2'] ?? null,
                        'QREM3' => $item['QREM3'] ?? null,
                        'QRESERVE' => $item['QRESERVE'] ?? null,
                        'QRESERVE2' => $item['QRESERVE2'] ?? null,
                        'QRESERVE3' => $item['QRESERVE3'] ?? null,
                        'QDEPOT' => $item['QDEPOT'] ?? null,
                        'STOCKNAME2' => $item['STOCKNAME2'] ?? null,
                        'DEPOTNO' => $item['DEPOTNO'] ?? null,
                        'DEPOTNAME' => $item['DEPOTNAME'] ?? null,
                        'DEPOTTYPE' => $item['DEPOTTYPE'] ?? null,
                        'DEPOTID' => $item['DEPOTID'] ?? null,
                        'UNITNAME' => $item['UNITNAME'] ?? null,
                        'UNITIDNAME' => $item['UNITIDNAME'] ?? null,
                        'INTUNITCODE' => $item['INTUNITCODE'] ?? null,
                        'UNITID' => $item['UNITID'] ?? null,
                        'SPECCODE3' => null, //$item['SPECCODE3'] ?? null,
                        'SPECCODE4' => null, //$item['SPECCODE4'] ?? null,
                        'SPECCODE5' => null, //$item['SPECCODE5'] ?? null,
                        'SPECCODE6' => null, //$item['SPECCODE6'] ?? null,
                        'SPECCODE7' => null, //$item['SPECCODE7'] ?? null,
                        'SPECCODE8' => null, //$item['SPECCODE8'] ?? null,
                        'SPECCODE9' => $item['SPECCODE9'] ?? null,
                        'SPECCODE10' => $item['SPECCODE10'] ?? null,
                        'PARENTID' => $item['PARENTID'] ?? null,
                        'TOUR' => $item['TOUR'] ?? null,
                        'DECITEKS' => $item['DECITEKS'] ?? null,
                        'LASTPURCPRICE' => $item['LASTPURCPRICE'] ?? null,
                        'LASTPURCDATE' => $item['LASTPURCDATE'] ?? null,
                        'LASTPURCCURRPRICE' => $item['LASTPURCCURRPRICE'] ?? null,
                        'VATSALES' => $item['VATSALES'] ?? null,
                        'VATPURCHASE' => $item['VATPURCHASE'] ?? null,
                        'QUANTITYMIN' => $item['QUANTITYMIN'] ?? null,
                        'QUANTITYMAX' => $item['QUANTITYMAX'] ?? null,
                        'MINORDERQUANTITY' => $item['MINORDERQUANTITY'] ?? null,
                        'TAXPRIVATE' => $item['TAXPRIVATE'] ?? null,
                        'TAXPRIVATETOTAL' => $item['TAXPRIVATETOTAL'] ?? null,
                        'ORDERSLEVEL' => $item['ORDERSLEVEL'] ?? null,
                        'ACTNOCUSTOMER' => $item['ACTNOCUSTOMER'] ?? null,
                        'ACTNAMECUSTOMER' => $item['ACTNAMECUSTOMER'] ?? null,
                        'ACTIDCUSTOMER' => $item['ACTIDCUSTOMER'] ?? null,
                        'ACTNOSUPPLIER' => $item['ACTNOSUPPLIER'] ?? null,
                        'ACTNAMESUPPLIER' => $item['ACTNAMESUPPLIER'] ?? null,
                        'ACTIDSUPPLIER' => $item['ACTIDSUPPLIER'] ?? null,
                        'PACKAGEQUANTITY' => $item['PACKAGEQUANTITY'] ?? null,
                        'CUSTOMERSTOCKNO' => $item['CUSTOMERSTOCKNO'] ?? null,
                        'SUPPLIERSTOCKNO' => $item['SUPPLIERSTOCKNO'] ?? null,
                        'FOLLOWLOT' => $item['FOLLOWLOT'] ?? null,
                        'FOLLOWSTOCK' => $item['FOLLOWSTOCK'] ?? null,
                        'FOLLOWSERIAL' => $item['FOLLOWSERIAL'] ?? null,
                        'FOLLOWSERIALFREE' => $item['FOLLOWSERIALFREE'] ?? null,
                        'FOLLOWSTOREHOUSE' => $item['FOLLOWSTOREHOUSE'] ?? null,
                        'DYNAMICPLACE' => $item['DYNAMICPLACE'] ?? null,
                        'MATRIX' => $item['MATRIX'] ?? null,
                        'STOCKSERISTART' => $item['STOCKSERISTART'] ?? null,
                        'WARRANTY' => $item['WARRANTY'] ?? null,
                        'WARRANTYTYPENAME' => $item['WARRANTYTYPENAME'] ?? null,
                        'WARRANTYTYPE' => $item['WARRANTYTYPE'] ?? null,
                        'FORMULAID' => $item['FORMULAID'] ?? null,
                        'PROVIDEDURATION' => $item['PROVIDEDURATION'] ?? null,
                        'PROVIDEDURATIONTYPENAME' => $item['PROVIDEDURATIONTYPENAME'] ?? null,
                        'PROVIDEDURATIONTYPE' => $item['PROVIDEDURATIONTYPE'] ?? null,
                        'PRICELIST' => $item['PRICELIST'] ?? null,
                        'BARCODEDIV' => $item['BARCODEDIV'] ?? null,
                        'PACKAGENAME' => $item['PACKAGENAME'] ?? null,
                        'STOCKPACKAGEID' => $item['STOCKPACKAGEID'] ?? null,
                        'CHANGERECORD' => $item['CHANGERECORD'] ?? null,
                        'POSDEPARTMAN' => $item['POSDEPARTMAN'] ?? null,
                        'POSDEPARTMANT' => $item['POSDEPARTMANT'] ?? null,
                        'POSPLU' => $item['POSPLU'] ?? null,
                        'POSUNITID' => $item['POSUNITID'] ?? null,
                        'POSTARTILI' => $item['POSTARTILI'] ?? null,
                        'ACCGROUPCODE' => $item['ACCGROUPCODE'] ?? null,
                        'TREXMODULSID' => $item['TREXMODULSID'] ?? null,
                        'QTYSELECT' => $item['QTYSELECT'] ?? null,
                        'NOTCONVERTUNIT' => $item['NOTCONVERTUNIT'] ?? null,
                        'STOCKPRICETYPEID' => $item['STOCKPRICETYPEID'] ?? null,
                        'PSTOCKPRICETYPEID' => $item['PSTOCKPRICETYPEID'] ?? null,
                        'EDUCATIONTIME' => $item['EDUCATIONTIME'] ?? null,
                        'GTYPENO' => $item['GTYPENO'] ?? null,
                        'GTYPENAME' => $item['GTYPENAME'] ?? null,
                        'GTYPEID' => $item['GTYPEID'] ?? null,
                        'MATRIXID' => $item['MATRIXID'] ?? null,
                        'MATRIXID2' => $item['MATRIXID2'] ?? null,
                        'MATRIXID3' => $item['MATRIXID3'] ?? null,
                        'MATRIXSTOCKID' => $item['MATRIXSTOCKID'] ?? null,
                        'SCURREXCTYPENAME' => $item['SCURREXCTYPENAME'] ?? null,
                        'SCURREXCTYPE' => $item['SCURREXCTYPE'] ?? null,
                        'PCURREXCTYPENAME' => $item['PCURREXCTYPENAME'] ?? null,
                        'PCURREXCTYPE' => $item['PCURREXCTYPE'] ?? null,
                        'MATRIXUNIQID' => $item['MATRIXUNIQID'] ?? null,
                        'MATRIXUNIQID2' => $item['MATRIXUNIQID2'] ?? null,
                        'MATRIXUNIQID3' => $item['MATRIXUNIQID3'] ?? null,
                        'ADVRATE' => $item['ADVRATE'] ?? null,
                        'ADVROTATE' => $item['ADVROTATE'] ?? null,
                        'RELATIONSTOCKNO' => $item['RELATIONSTOCKNO'] ?? null,
                        'RELATIONSTOCKNAME' => $item['RELATIONSTOCKNAME'] ?? null,
                        'STOCKIDRELATION' => $item['STOCKIDRELATION'] ?? null,
                        'TEKSSTOCK' => $item['TEKSSTOCK'] ?? null,
                        'SHELFLIFE' => $item['SHELFLIFE'] ?? null,
                        'SHELFLIFETYPENAME' => $item['SHELFLIFETYPENAME'] ?? null,
                        'SHELFLIFETYPE' => $item['SHELFLIFETYPE'] ?? null,
                        'LEGALLIABILITY' => $item['LEGALLIABILITY'] ?? null,
                        'STOCKPOINT' => $item['STOCKPOINT'] ?? null,
                        'DEVIATIONDATE' => $item['DEVIATIONDATE'] ?? null,
                        'FOLLOWBARCODE' => $item['FOLLOWBARCODE'] ?? null,
                        'MSG' => $item['MSG'] ?? null,
                        'MINREQQUANTITY' => $item['MINREQQUANTITY'] ?? null,
                        'NOBONUS' => $item['NOBONUS'] ?? null,
                        'CONVERTQTY' => $item['CONVERTQTY'] ?? null,
                        'SPECIFICGRAVITY' => $item['SPECIFICGRAVITY'] ?? null,
                        'WEBSTOCK' => $item['WEBSTOCK'] ?? null,
                        'PSSAMPLELEVELID' => $item['PSSAMPLELEVELID'] ?? null,
                        'MRPLOSSPERCENT' => $item['MRPLOSSPERCENT'] ?? null,
                        'DCASPLANCALCOEE' => $item['DCASPLANCALCOEE'] ?? null,
                        'STOCKMINPRICE' => $item['STOCKMINPRICE'] ?? null,
                        'TRANSCODE' => $item['TRANSCODE'] ?? null,
                        'MANUFACTUREPRICE' => $item['MANUFACTUREPRICE'] ?? null,
                        'MANUFACTURECURR' => $item['MANUFACTURECURR'] ?? null,
                        'MANUFACTUREDATE' => $item['MANUFACTUREDATE'] ?? null,
                        'ORIGIN' => $item['ORIGIN'] ?? null,
                        'CLASSIFICATIONCODE' => $item['CLASSIFICATIONCODE'] ?? null,
                        'LABELNO' => $item['LABELNO'] ?? null,
                        'QTYTREE' => $item['QTYTREE'] ?? null,
                        'DMOPRODUCTNO' => $item['DMOPRODUCTNO'] ?? null,
                        'DMOGLBPRODUCTNO' => $item['DMOGLBPRODUCTNO'] ?? null,
                        'PRICEEDITDATE' => $item['PRICEEDITDATE'] ?? null,
                        'INSERTUSERID' => $item['INSERTUSERID'] ?? null,
                        'INSERTDATE' => $item['INSERTDATE'] ?? null,
                        'EDITUSERID' => $item['EDITUSERID'] ?? null,
                        'EDITDATE' => $item['EDITDATE'] ?? null,
                        'GLBALERTID' => $item['GLBALERTID'] ?? null,
                        'NOTES' => $item['NOTES'] ?? null,
                    ];
        
                } else {
                    // Mevcut kayıt varsa güncellemek için değişiklikleri topla
                    foreach ($item as $key => $value) {
                        if (isset($existingRecord[$key]) && $existingRecord[$key] != $value) {
                            $changes[] = "$key: '{$existingRecord[$key]}' => '$value'";
                            $existingRecord[$key] = $value; // Veriyi güncelle
                        }
                    }
        
                    // Eğer güncellenecek veri varsa
                    if (!empty($changes)) {
                        $batchUpdateData[] = $existingRecord;
                    }
                }
            }
    
            // Toplu ekleme ve güncelleme işlemleri
            if (!empty($batchInsertData)) {
                $this->modelSysmond->insertBatch($batchInsertData);
            }
    
            if (!empty($batchUpdateData)) {
                $this->modelSysmond->updateBatch($batchUpdateData, 'STOCKID');
            }
            $this->modelSysmondBarkod->truncate();
            $this->sysmond_barcode();
    

 echo "JSON okundu";




        } else {
            // JSON çözümlemesinde hata varsa bunu göster
            echo "JSON verisi çözümlenemedi. Hata: " . json_last_error_msg();
        }
    }

    public function sysmond_barcode() {
        // cURL başlatma
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://85.105.220.154:8640/TrexIntegrationService/REST/GetStockBarcodes',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'Sirketid' => $this->sirketID,
                'ApiKey' => $this->ApiKey,
                'editdate' => ''
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));
    
        $response = curl_exec($curl);
    
        // cURL hatalarını kontrol et
        if ($response === false) {
            echo 'cURL Hatası: ' . curl_error($curl);
            curl_close($curl);
            return;
        }
    
        curl_close($curl);
    
        // Yanıtın boş olup olmadığını kontrol et
        if (empty($response)) {
            echo 'API yanıtı boş.';
            return;
        }
    
        // Kaçış karakterlerini temizle
        $response = stripslashes($response);
    
        // Baş ve sondaki çift tırnakları kaldır (eğer varsa)
        $response = trim($response, '"');
    
        // JSON'u PHP dizisine dönüştür
        $barcodeData = json_decode($response, true);

      



    
        // JSON verisinin doğru şekilde çözümlenip çözümlenmediğini kontrol et
        if (json_last_error() === JSON_ERROR_NONE) {
            // Toplu ekleme ve güncelleme için diziler
            $batchInsertData = [];
            $batchUpdateData = [];
    
            // Gelen her bir veri için kontrol ve ekleme/güncelleme işlemi
            foreach ($barcodeData as $item) {
                // Veritabanında bu STOCKID mevcut mu kontrol et
                $existingRecord = $this->modelSysmondBarkod->where('STOCKID', $item['STOCKID'])->first();
    
                // Değişiklikleri kaydetmek için değişiklik listesi
                $changes = [];
    
                if (!$existingRecord) {
                    // Kayıt yoksa ekleyeceğimiz veriyi toplu ekleme dizisine ekliyoruz
                    $batchInsertData[] = [
                        'COMPANYID' => $item['COMPANYID'] ?? null,
                        'STOCKNO' => $item['STOCKNO'] ?? null,
                        'STOCKNAME' => $item['STOCKNAME'] ?? null,
                        'STOCKTYPE' => $item['STOCKTYPE'] ?? null,
                        'STOCKID' => $item['STOCKID'] ?? null,
                        'UNITNAME' => $item['UNITNAME'] ?? null,
                        'UNITIDNAME' => $item['UNITIDNAME'] ?? null,
                        'INTUNITCODE' => $item['INTUNITCODE'] ?? null,
                        'UNITID' => $item['UNITID'] ?? null,
                        'ITEMNO' => $item['ITEMNO'] ?? null,
                        'BARCODETYPENAME' => $item['BARCODETYPENAME'] ?? null,
                        'BARCODETYPE' => $item['BARCODETYPE'] ?? null,
                        'BARCODE' => $item['BARCODE'] ?? null,
                        'AUTOGENERATE' => $item['AUTOGENERATE'] ?? null,
                        'ACTNO' => $item['ACTNO'] ?? null,
                        'ACTNAME' => $item['ACTNAME'] ?? null,
                        'ACTTYPE' => $item['ACTTYPE'] ?? null,
                        'ACTID' => $item['ACTID'] ?? null,
                        'GRADENAME' => $item['GRADENAME'] ?? null,
                        'GRADEID' => $item['GRADEID'] ?? null,
                        'QUANTITY' => $item['QUANTITY'] ?? null,
                        'STOCKPRICETYPEID' => $item['STOCKPRICETYPEID'] ?? null,
                        'TERAZITUSNO' => $item['TERAZITUSNO'] ?? null,
                        'OUTPRODUCT' => $item['OUTPRODUCT'] ?? null,
                        'PRICE' => $item['PRICE'] ?? null,
                        'DESCRIPTION' => $item['DESCRIPTION'] ?? null,
                        'INSERTUSERID' => $item['INSERTUSERID'] ?? null,
                        'INSERTDATE' => $item['INSERTDATE'] ?? null,
                        'EDITUSERID' => $item['EDITUSERID'] ?? null,
                        'EDITDATE' => $item['EDITDATE'] ?? null,
                        'GLBALERTID' => $item['GLBALERTID'] ?? null,
                    ];
                } else {
                    // Kayıt varsa güncellenecek alanları kontrol ediyoruz
                    foreach ($item as $key => $value) {
                        if (isset($existingRecord[$key]) && $existingRecord[$key] != $value) {
                            $changes[] = "$key: '{$existingRecord[$key]}' => '$value'";
                            $existingRecord[$key] = $value; // Veriyi güncelle
                        }
                    }
    
                    // Değişiklik varsa toplu güncelleme için diziyi doldur
                    if (!empty($changes)) {
                        // Değişikliklerin detayını güncel olarak saklamak için 'CHANGE_LOG' alanına ekle
                        $existingRecord['CHANGE_LOG'] = implode(', ', $changes);
    
                        // Güncellenmiş kaydı $batchUpdateData dizisine ekle
                        $batchUpdateData[] = $existingRecord;
                    }
                }
            }

           
      
    
            // Toplu ekleme ve güncelleme işlemleri
            if (!empty($batchInsertData)) {
                $this->modelSysmondBarkod->insertBatch($batchInsertData);
            }
    
            if (!empty($batchUpdateData)) {
                $this->modelSysmondBarkod->updateBatch($batchUpdateData, 'STOCKID');
            }
    
           
            $this->response->redirect(base_url('sysmond/check'));


        } else {
            // JSON çözümlemesinde hata varsa bunu göster
            echo "JSON verisi çözümlenemedi. Hata: " . json_last_error_msg();
        }
    }


    public function sysmond_stock_bilgisi($stock_id) {
        // cURL başlatma
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://85.105.220.154:8640/TrexIntegrationService/REST/GetStockInfo',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'companyid' => $this->sirketID,
                'ApiKey' => $this->ApiKey,
                'stockid' => $stock_id
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));
    
        $response = curl_exec($curl);
    
        // cURL hatalarını kontrol et
        if ($response === false) {
            echo 'cURL Hatası: ' . curl_error($curl);
            curl_close($curl);
            return;
        }
    
        curl_close($curl);
    
        // Yanıtın boş olup olmadığını kontrol et
        if (empty($response)) {
            echo 'API yanıtı boş.';
            return;
        }
    
        // Kaçış karakterlerini temizle
        $response = stripslashes($response);
    
        // Baş ve sondaki çift tırnakları kaldır (eğer varsa)
        $response = trim($response, '"');
    
        // JSON'u PHP dizisine dönüştür
        $barcodeData = json_decode($response, true);
    
        // JSON verisinin doğru şekilde çözümlenip çözümlenmediğini kontrol et
        if (json_last_error() === JSON_ERROR_NONE) {
          
            return $barcodeData;

        } else {
            // JSON çözümlemesinde hata varsa bunu göster
            echo "JSON verisi çözümlenemedi. Hata: " . json_last_error_msg();
        }
    }

    public function sysmond_stock_bilgisi_guncelleme(): void {
        $stoklar = $this->modelStock->where("sysmond !=", "")->where("deleted_at", null)->findAll();
        $guncellemeler = []; // Toplu güncelleme için dizi
    
        foreach ($stoklar as $stok) {
            $sysmond_bilgileri = $this->sysmond_stock_bilgisi($stok["sysmond"]);
    
            if (!is_array($sysmond_bilgileri) || !isset($sysmond_bilgileri["depotCountList"])) {
                // Hata kaydı (log) veya uygun hata yönetimi
                log_message('error', 'Geçersiz sysmond verisi. Sysmond: ' . $stok["sysmond"] . ', Veri: ' . print_r($sysmond_bilgileri, true));
                continue; // Bir sonraki stoğa geç
            }
    
            $toplamStok = 0;
            foreach ($sysmond_bilgileri["depotCountList"] as $depo) {
                if(isset($depo["count"]) && is_numeric($depo["count"])){
                    $toplamStok += (int)$depo["count"]; // Tamsayıya dönüştürme
                } else {
                    log_message('error', 'Geçersiz depo sayısı. Sysmond: ' . $stok["sysmond"] . ', Depo Verisi: ' . print_r($depo, true));
                }
    
            }
    
            if (!is_int($toplamStok) || $toplamStok < 0) {
                log_message('error', 'Geçersiz toplam stok değeri. Stok ID: ' . $stok["stock_id"] . ', Değer: ' . $toplamStok);
                continue;
            }



            
                                       
                
                if($stok){
                    // Stok miktarı karşılaştırma
                    $apiStokMiktari = (float)$toplamStok;
                    $dbStokMiktari = (float)$stok['stock_total_quantity'];
                    $fark = $apiStokMiktari - $dbStokMiktari;
                    
                    if($fark != 0) {
                        $anlikTarih = new Time('now', 'Turkey', 'en_US');
                        $textMesaj = "Sysmond senkronizasyonu: ".$anlikTarih->toDateTimeString()." tarihinde ".abs($fark)." adet ".$stok['stock_code']." ".($fark > 0 ? "stok girişi" : "stok düşümü")." (API: ".$apiStokMiktari.", DB: ".$dbStokMiktari.")";
                        
                        echo $textMesaj . "\n";
                        
                        $orderStoks = new \App\Controllers\TikoERP\Order();
                        if($fark > 0) {
                            $orderStoks->stokGiris($stok['stock_id'], abs($fark), 1, $textMesaj);
                            echo "Stok girişi yapıldı\n";
                        } else {
                            $orderStoks->stokDusum($stok['stock_id'], abs($fark), 1, $textMesaj);
                            echo "Stok düşümü yapıldı\n";
                        }

                        // Log kaydı oluştur
                        $logData = [
                            'sysmond_stockid' => $stok['sysmond'],
                            'stock_id' => $stok['stock_id'],
                            'updated_data' => json_encode([
                                'old_quantity' => $dbStokMiktari,
                                'new_quantity' => $apiStokMiktari,
                                'difference' => $fark
                            ]),
                            'log_text' => 'Stok miktarı SYSMOND API ile senkronize edildi (TEST)',
                            'user_id' => 1,
                            'client_id' => 1,
                            'ip_address' => $this->request->getIPAddress(),
                            'browser' => $this->request->getUserAgent()->getBrowser(),
                            'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
                        ];
                        $this->modelSysmondLog->insert($logData);
                        echo "Log kaydı oluşturuldu\n";
                    } else {
                        echo "Stok miktarı aynı, güncelleme yapılmadı\n";
                    }
                }
    
            $guncellemeler[] = [
                "stock_id" => $stok["stock_id"],
            ];
        }
    
        if (!empty($guncellemeler)) {
            if(!$this->modelStock->updateBatch($guncellemeler, 'stock_id')){
                log_message('error', 'Stok toplu güncelleme başarısız.');
            }
    
        }
    }
    
    /*
    public function sysmond_barcode() {
        // cURL başlatma
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://85.105.220.154:8640/TrexIntegrationService/REST/GetStockBarcodes',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'Sirketid' => $this->sirketID,
                'ApiKey' => $this->ApiKey,
                'editdate' => ''
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));
    
        $response = curl_exec($curl);
    
        // cURL hatalarını kontrol et
        if ($response === false) {
            echo 'cURL Hatası: ' . curl_error($curl);
            curl_close($curl);
            return;
        }
    
        curl_close($curl);
    
        // Yanıtın boş olup olmadığını kontrol et
        if (empty($response)) {
            echo 'API yanıtı boş.';
            return;
        }
    
        // Kaçış karakterlerini temizle
        $response = stripslashes($response);
    
        // Baş ve sondaki çift tırnakları kaldır (eğer varsa)
        $response = trim($response, '"');
    
        // JSON'u PHP dizisine dönüştür
        $barcodeData = json_decode($response, true);
    
        // JSON verisinin doğru şekilde çözümlenip çözümlenmediğini kontrol et
        if (json_last_error() === JSON_ERROR_NONE) {
            // Toplu ekleme ve güncelleme için diziler
            $batchInsertData = [];
            $batchUpdateData = [];
    
            // Gelen her bir veri için kontrol ve ekleme/güncelleme işlemi
            foreach ($barcodeData as $item) {
                // Veritabanında bu STOCKID mevcut mu kontrol et
                $existingRecord = $this->modelSysmondBarkod->where('STOCKID', $item['STOCKID'])->first();
    
                // Değişiklikleri kaydetmek için değişiklik listesi
                $changes = [];
    
                if (!$existingRecord) {
                    // Kayıt yoksa ekleyeceğimiz veriyi toplu ekleme dizisine ekliyoruz
                    $batchInsertData[] = [
                        'COMPANYID' => $item['COMPANYID'] ?? null,
                        'STOCKNO' => $item['STOCKNO'] ?? null,
                        'STOCKNAME' => $item['STOCKNAME'] ?? null,
                        'STOCKTYPE' => $item['STOCKTYPE'] ?? null,
                        'STOCKID' => $item['STOCKID'] ?? null,
                        'UNITNAME' => $item['UNITNAME'] ?? null,
                        'UNITIDNAME' => $item['UNITIDNAME'] ?? null,
                        'INTUNITCODE' => $item['INTUNITCODE'] ?? null,
                        'UNITID' => $item['UNITID'] ?? null,
                        'ITEMNO' => $item['ITEMNO'] ?? null,
                        'BARCODETYPENAME' => $item['BARCODETYPENAME'] ?? null,
                        'BARCODETYPE' => $item['BARCODETYPE'] ?? null,
                        'BARCODE' => $item['BARCODE'] ?? null,
                        'AUTOGENERATE' => $item['AUTOGENERATE'] ?? null,
                        'ACTNO' => $item['ACTNO'] ?? null,
                        'ACTNAME' => $item['ACTNAME'] ?? null,
                        'ACTTYPE' => $item['ACTTYPE'] ?? null,
                        'ACTID' => $item['ACTID'] ?? null,
                        'GRADENAME' => $item['GRADENAME'] ?? null,
                        'GRADEID' => $item['GRADEID'] ?? null,
                        'QUANTITY' => $item['QUANTITY'] ?? null,
                        'STOCKPRICETYPEID' => $item['STOCKPRICETYPEID'] ?? null,
                        'TERAZITUSNO' => $item['TERAZITUSNO'] ?? null,
                        'OUTPRODUCT' => $item['OUTPRODUCT'] ?? null,
                        'PRICE' => $item['PRICE'] ?? null,
                        'DESCRIPTION' => $item['DESCRIPTION'] ?? null,
                        'INSERTUSERID' => $item['INSERTUSERID'] ?? null,
                        'INSERTDATE' => $item['INSERTDATE'] ?? null,
                        'EDITUSERID' => $item['EDITUSERID'] ?? null,
                        'EDITDATE' => $item['EDITDATE'] ?? null,
                        'GLBALERTID' => $item['GLBALERTID'] ?? null,
                    ];
                } else {
                    // Kayıt varsa güncellenecek alanları kontrol ediyoruz
                    foreach ($item as $key => $value) {
                        if (isset($existingRecord[$key]) && $existingRecord[$key] != $value) {
                            $changes[] = "$key: '{$existingRecord[$key]}' => '$value'";
                            $existingRecord[$key] = $value; // Veriyi güncelle
                        }
                    }
    
                    // Değişiklik varsa toplu güncelleme için diziyi doldur
                    if (!empty($changes)) {
                        $batchUpdateData[] = $existingRecord;
    
                        // Değişikliklerin detayını güncel olarak saklamak için 'CHANGE_LOG' alanına ekle
                        $existingRecord['CHANGE_LOG'] = implode(', ', $changes);
                    }
                }
            }
    
            // Toplu ekleme ve güncelleme işlemleri
            if (!empty($batchInsertData)) {
                $this->modelSysmondBarkod->insertBatch($batchInsertData);
            }
    
            if (!empty($batchUpdateData)) {
                $this->modelSysmondBarkod->updateBatch($batchUpdateData, 'STOCKID');
            }
    
            echo "Tüm Barkodlar Eklendi veya Güncellendi";
        } else {
            // JSON çözümlemesinde hata varsa bunu göster
            echo "JSON verisi çözümlenemedi. Hata: " . json_last_error_msg();
        }
    } */

    public function stock_and_sysmond()
    {
       
        // modelSysmondBarkod tablosundan barkodları çek
        $barkodlar = $this->modelSysmondBarkod->findAll();  // Tüm barkodları çekiyoruz
    
        foreach ($barkodlar as $barkod) {
            // Barkod uzunluğunu kontrol et
            if (strlen($barkod['BARCODE']) < 13) {
                // Eğer barkod uzunluğu 13 karakterden az ise, production barkod dönüşümü yapılır
                $sorgu = convert_barcode_number_for_sql_productions($barkod['BARCODE']);
            } else {
                // 13 karakter veya daha fazla ise normal sorgu yapılır
                $sorgu = convert_barcode_number_for_sqls($barkod['BARCODE']);
            }

    
            // modelStock tablosunda sorguyu çalıştır - Barkod ile ürün sorgulama
            $urun = $this->modelStock->where('sysmond', $barkod["STOCKID"])->first();
    
            if ($urun) {
                // Eşleştiyse eğer güncelleme yapacağız öncelikle 
                $SysmondBilgiler = $this->modelSysmond->where("STOCKID", $barkod["STOCKID"])->first();
    
                // SPECCODE3'ten SPECCODE10'a kadar olan değerleri birleştir
                $specCodes = [];
                $specCodes[] = $SysmondBilgiler["SPECCODE9"];
                $specCodes[] = $SysmondBilgiler["SPECCODE10"];
              
                // Birleştirilmiş SPECCODE değerleri
                $combinedSpecCodes = implode(", ", $specCodes);

                // Sadece başlık, raf adresi ve sysmond ID'sini güncelle
                $updateData = [
                    'stock_title' => $barkod["STOCKNAME"],
                    'warehouse_address' => $combinedSpecCodes,
                    'sysmond' => $barkod["STOCKID"]
                ];
                
                $this->modelStock->update($urun["stock_id"], $updateData);

                // Log kaydı ekle
                $logData = [
                    'sysmond_stockid' => $barkod["STOCKID"],
                    'stock_id' => $urun['stock_id'],
                    'updated_data' => json_encode($updateData),
                    'log_text' => 'Sysmond verileri güncellendi (barkod hariç)',
                    'user_id' => 1,
                    'client_id' => 1,
                    'ip_address' => $this->request->getIPAddress(),
                    'browser' => $this->request->getUserAgent()->getBrowser(),
                    'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
                ];
                $this->modelSysmondLog->insert($logData);
            } 
          
            else {
                // Eğer barkod ile ürün bulunamadıysa, STOCKNO ile sorgu yap
                $urunStockNo = $this->modelStock->where('stock_code', $barkod['STOCKNO'])->first();
    
                if ($urunStockNo) {

                    $SysmondBilgiler = $this->modelSysmond->where("STOCKID", $barkod["STOCKID"])->first();

                    $specCodes = [];
                    $specCodes[] = $SysmondBilgiler["SPECCODE9"];
                    $specCodes[] = $SysmondBilgiler["SPECCODE10"];
                   
                  
                    // Birleştirilmiş SPECCODE değerleri
                    $combinedSpecCodes = implode(", ", $specCodes);
    



                        if (strlen($barkod['BARCODE']) < 13) {
                            // Eğer barkod uzunluğu 13 karakterden az ise, production barkod dönüşümü yapılır
                            $sorgu = convert_barcode_number_for_sql_production($barkod['BARCODE']);
                        } else {
                            // 13 karakter veya daha fazla ise normal sorgu yapılır
                            $sorgu = convert_barcode_number_for_sql($barkod['BARCODE']);
                        }


                        $updateData = [
                            'stock_title' => $barkod["STOCKNAME"],
                            'warehouse_address' => $combinedSpecCodes, // Yeni SPECCODE birleşimi
                            //'stock_barcode' => $sorgu, // Yeni SPECCODE birleşimi
                            'sysmond' => $barkod["STOCKID"]
                        ];
                    
            
                        // Güncelleme işlemini yap
                    $this->modelStock->update($urunStockNo["stock_id"], $updateData);
            
                        // Loglama işlemi
                    
                        $logData = [
                            'sysmond_stockid' => $barkod["STOCKID"],
                            'stock_id' => $urunStockNo['stock_id'],
                            'updated_data' => json_encode($updateData),
                            'log_text' => 'Bu barkod yok, ancak stok numarası var Sysmond verileri güncellendi',
                            'user_id' => 1,
                            'client_id' => 1,
                            'ip_address' => $this->request->getIPAddress(),
                            'browser' => $this->request->getUserAgent()->getBrowser(),
                            'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
                        ];
                    
            
                        // Log modelini kullanarak log kaydını ekleyin
                        $this->modelSysmondLog->insert($logData);
                   
                     //echo "Bu barkod yok, ancak stok numarası var: " . $barkod['STOCKNO'] . "<br>";
                } else {
                    echo "Bu barkod ve stok numarası yok: " . $barkod['BARCODE'] . " - " . $barkod['STOCKNO'] . "<br>";

                      $Excel = $barkod;


                    $SysmondBilgiler = $this->modelSysmond->where("STOCKID", $barkod["STOCKID"])->first();


                        $Stoklar = $this->modelStock->where("stock_title", $SysmondBilgiler["STOCKNAME"])->where("stock_code", $Excel["STOCKNO"])->first();
    

                        if (strlen($barkod['BARCODE']) < 13) {
                            // Eğer barkod uzunluğu 13 karakterden az ise, production barkod dönüşümü yapılır
                            $sorgu = convert_barcode_number_for_sql_production($barkod['BARCODE']);
                        } else {
                            // 13 karakter veya daha fazla ise normal sorgu yapılır
                            $sorgu = convert_barcode_number_for_sql($barkod['BARCODE']);
                        }

                        if (!$Stoklar || empty($Stoklar)) {
                           
                            $stock_type = "product";
                            $has_variant = 0;
                            $tip = $SysmondBilgiler["STOCKTYPENAME"];
                            $StokTipi = $this->modelType->where("type_title", $tip)->first();
                            $type_id = $StokTipi ? $StokTipi["type_id"] : 1;
    
                            $fiyati = 0;
                            $category_id = 9; // Kategorisiz
                            $stock_barcode = $sorgu;
                            $stock_code = $SysmondBilgiler["STOCKNO"];
                            $stock_title = $SysmondBilgiler["STOCKNAME"];
                            $supplier_stock_code = ''; // Fixed double $
    
                            $paraTipi = $this->modelMoneyUnit->where("money_code", $SysmondBilgiler["CURRCODE"])->first();
                            $para_type = $paraTipi ? $paraTipi["money_unit_id"] : 1;
    
                            $birimi = ($SysmondBilgiler["UNITNAME"] == "KG") ? "kg" : $SysmondBilgiler["UNITNAME"];
                            $birimTpye = $this->modelUnit->where("unit_title", $birimi)->first();
                            $birim_type = $birimTpye ? $birimTpye["unit_id"] : 1;
    
                            $buy_unit_id = $birim_type; // Birim KG, ADET VB
                            $buy_unit_price = $fiyati; // Fiyat
                            $buy_unit_price_with_tax = $fiyati; // KDV Dahil Fiyat
                            $buy_money_unit_id = $para_type; // Para tipi US, EUR, TR
                            $buy_tax_rate = 0; // Default %1
    
                            $sale_unit_id = $birim_type; // Birim KG, ADET VB
                            $sale_unit_price = $fiyati; // Fiyat
                            $sale_unit_price_with_tax = $fiyati; // KDV Dahil Fiyat
                            $sale_money_unit_id = $para_type; // Para tipi US, EUR, TR
                            $sale_tax_rate = 0; // Default %1
    
                            $ManuelStok = "SYSMOND APİDEN EKLEME " . $SysmondBilgiler["STOCKID"] . " - " . Date("d-m-Y h:i");
    
    
    
                            $status = "active";
                            $stock_tracking = 0;
    
                            if ($stock_tracking == '1') {
                                $starting_stock = $this->request->getPost('starting_stock');
                                $starting_stock_date = $this->request->getPost('starting_stock_date');
                                $insert_data['critical_stock'] = $this->request->getPost('critical_stock');
                            }
    
                            $buy_unit_price = convert_number_for_sql($buy_unit_price);
                            $buy_unit_price_with_tax = convert_number_for_sql($buy_unit_price_with_tax);
                            $sale_unit_price = convert_number_for_sql($sale_unit_price);
                            $sale_unit_price_with_tax = convert_number_for_sql($sale_unit_price_with_tax);
    
                            $barcode_number = generate_barcode_number($stock_barcode);
                           
                            $has_variant = $has_variant ? 1 : 0;
    
                            $temp_stock_code = $this->getStockCode($category_id, $stock_code);
                            if ($temp_stock_code['icon'] == 'success') {
                                $stock_code = $temp_stock_code['value'];
                            } else {
                                echo json_encode($temp_stock_code);
                                return;
                            }
    
                            $insert_data = [
                                'parent_id' => 0,
                                'user_id' => 1,
                                'type_id' => $type_id,
                                'category_id' => $category_id,
                                'buy_unit_id' => $buy_unit_id,
                                'sale_unit_id' => $sale_unit_id,
                                'buy_money_unit_id' => $buy_money_unit_id,
                                'sale_money_unit_id' => $sale_money_unit_id,
                                'buy_unit_price' => $buy_unit_price,
                                'buy_unit_price_with_tax' => $buy_unit_price_with_tax,
                                'sale_unit_price' => $sale_unit_price,
                                'sale_unit_price_with_tax' => $sale_unit_price_with_tax,
                                'buy_tax_rate' => $buy_tax_rate,
                                'sale_tax_rate' => $sale_tax_rate,
                                'stock_type' => $stock_type,
                                'stock_title' => $stock_title,
                                'stock_code' => $stock_code,
                                'stock_barcode' => $barcode_number,
                                'supplier_stock_code' => $supplier_stock_code,
                                'default_image' => 'uploads/default.png',
                                'status' => $status,
                                'manuel_add' => $ManuelStok,
                                'has_variant' => $has_variant,
                                'stock_tracking' => $stock_tracking,
                            ];
    
                            $warehouse_address = $this->request->getPost('warehouse_address');
                            $pattern_code = $this->request->getPost('pattern_code');
                            $en = $this->request->getPost('en');
                            $boy = $this->request->getPost('boy');
                            $kalinlik = $this->request->getPost('kalinlik');
                            $ozkutle = $this->request->getPost('ozkutle');
    
                            if ($warehouse_address) {
                                $insert_data['warehouse_address'] = $warehouse_address;
                            }
                            if ($pattern_code) {
                                $insert_data['pattern_code'] = $pattern_code;
                            }
                            if ($en) {
                                $insert_data['en'] = convert_number_for_sql($en);
                            }
                            if ($boy) {
                                $insert_data['boy'] = convert_number_for_sql($boy);
                            }
                            if ($kalinlik) {
                                $insert_data['kalinlik'] = convert_number_for_sql($kalinlik);
                            }
                            if ($ozkutle) {
                                $insert_data['ozkutle'] = convert_number_for_sql($ozkutle);
                            }
    
                            $this->modelStock->insert($insert_data);
                            $new_stock_id = $this->modelStock->getInsertID();
                            $success = true; // Set success flag to true
    
                            if ($temp_stock_code['category_counter']) {
                                $update_category_data = [
                                    'category_counter' => $temp_stock_code['category_counter']
                                ];
                                $this->modelCategory->update($category_id, $update_category_data);
                            }
    
                            $insert_recipe_data = [
                                'stock_id' => $new_stock_id,
                                'recipe_title' => $stock_title . '_recipe',
                            ];
                            $this->modelStockRecipe->insert($insert_recipe_data);
    
                            if ($stock_type == 'service') {
                                $warehouse_item = $this->modelWarehouse->where('user_id', 1)->where('default', 'true')->first();
    
                                $barcode_number = generate_barcode_number();
                                $insert_barcode_data = [
                                    'stock_id' => $new_stock_id,
                                    'warehouse_id' => $warehouse_item['warehouse_id'] ?? 0,
                                    'warehouse_address' => $warehouse_item['warehouse_title'] ?? '',
                                    'barcode_number' => $barcode_number,
                                    'total_amount' => 0,
                                    'used_amount' => 0
                                ];
                                $this->modelStockBarcode->insert($insert_barcode_data);
                                $new_insert_stock_barcode_id = $this->modelStockBarcode->getInsertID();
                            }



                        
                            $logData = [
                                'sysmond_stockid' => $barkod["STOCKID"],
                                'stock_id' => $new_stock_id,
                                'updated_data' => json_encode($SysmondBilgiler),
                                'log_text' => 'SYSMOND TARAFINDAN APİDEN EKLENDİ',
                                'user_id' => 1,
                                'client_id' => 1,
                                'ip_address' => $this->request->getIPAddress(),
                                'browser' => $this->request->getUserAgent()->getBrowser(),
                                'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
                            ];
                        
                
                            // Log modelini kullanarak log kaydını ekleyin
                            $this->modelSysmondLog->insert($logData);
                           
                       
                        }


                }
            }
           
        }



        $LogKaydet = [
            'tarih' => Date("d-m-Y h:i"),
            'durum' => "SYSMOND API GÜNCELLEME BAŞARILI",
            'mesaj' => "active",
            'mail'  => 1,
        ];

        $Senkro = $this->SysmondCronModel->insert($LogKaydet);
        $new_stock_id = $this->SysmondCronModel->getInsertID();

        $datas = [
            'senk_id'             => $new_stock_id,
            'senk_tarih'          => Date("d-m-Y h:i"),
            'baslik'                => "SYSMOND API Güncellendi!",
            'mesaj'             => "SYSMOND API GÜNCELLEME BAŞARILI"

        ];

        $render_html = view('mail/page/api_error', $datas);
        $data_email = [
            'email'         => "developer@tiko.com.tr",
            'subject'        => 'SYSMOND API Güncelleme Bildirimi',
            'render_html'    => $render_html
        ];

        $this->sendModel->mail_gonder($data_email);

        $data_emaild = [
            'email'         => "tiko@tiko.com.tr",
            'subject'        => 'SYSMOND API Güncelleme Bildirimi',
            'render_html'    => $render_html
        ];

        $this->sendModel->mail_gonder($data_emaild);

        $data_emails = [
            'email'         => "online@famsotomotiv.com",
            'subject'        => 'SYSMOND API Güncelleme Bildirimi',
            'render_html'    => $render_html
        ];

        $this->sendModel->mail_gonder($data_emails);


        echo "ok";
    }

    public function stock_sysmond_raf()
    {
        // modelSysmondBarkod tablosundan barkodları çek
        $barkodlar = $this->modelSysmondBarkod->findAll();  // Tüm barkodları çekiyoruz
    
        foreach ($barkodlar as $barkod) {
            // Barkod uzunluğunu kontrol et
            if (strlen($barkod['BARCODE']) < 13) {
                // Eğer barkod uzunluğu 13 karakterden az ise, production barkod dönüşümü yapılır
                $sorgu = convert_barcode_number_for_sql_production($barkod['BARCODE']);
            } else {
                // 13 karakter veya daha fazla ise normal sorgu yapılır
                $sorgu = convert_barcode_number_for_sql($barkod['BARCODE']);
            }
    
            // modelStock tablosunda sorguyu çalıştır - Barkod ile ürün sorgulama
            $urun = $this->modelStock->where('sysmond', $barkod["STOCKID"])->first();
    
            if ($urun) {
                // Eşleştiyse eğer güncelleme yapacağız öncelikle 
                $SysmondBilgiler = $this->modelSysmond->where("STOCKID", $barkod["STOCKID"])->first();
    
                // SPECCODE3'ten SPECCODE10'a kadar olan değerleri birleştir
                $specCodes = [];
                $specCodes[] = $SysmondBilgiler["SPECCODE9"];
                $specCodes[] = $SysmondBilgiler["SPECCODE10"];
              
                // Birleştirilmiş SPECCODE değerleri
                $combinedSpecCodes = implode(", ", $specCodes);

                $updateData = [
                    'stock_title' => $barkod["STOCKNAME"],
                    'warehouse_address' => $combinedSpecCodes,
                    'sysmond' => $barkod["STOCKID"]
                ];
            
                // Güncelleme işlemini yap
                if($urun["stock_barcode"] != $sorgu){
                    $this->modelStock->update($urun["stock_id"], $updateData);
                }
    
                // Şimdi Sysmond tablosundaki diğer güncellemeleri yapalım
               
                $updateData = [
                   // 'stock_barcode' => $sorgu, // Yeni SPECCODE birleşimi
                    'stock_title' => $SysmondBilgiler["STOCKNAME"], // Yeni SPECCODE birleşimi
                    'warehouse_address' => $combinedSpecCodes, // Yeni SPECCODE birleşimi
                ];
            
                $this->modelStock->update($urun["stock_id"], $updateData);
                // Güncelleme işlemini yap
         

          $logData = [
            'sysmond_stockid' => $barkod["STOCKID"],
            'stock_id' => $urun['stock_id'],
            'updated_data' => json_encode($SysmondBilgiler),
            'log_text' => 'Sysmond verileri güncellendi',
            'user_id' => 1,
            'client_id' => 1,
            'ip_address' => $this->request->getIPAddress(),
            'browser' => $this->request->getUserAgent()->getBrowser(),
            'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
        ];
        $this->modelSysmondLog->insert($logData);

      
            }
        }
    }


    private function getStockCode($category_id, $stock_code)
    {
        $category_counter = 0;
        if ($stock_code == '') {
            $category_item = $this->modelCategory->where('user_id', 1)->where('category_id', $category_id)->first();
            if (!$category_item) {
                return ['icon' => 'error', 'message' => 'Lütfen geçerli bir kategori seçiniz'];
            } elseif (!$category_item['category_value']) {
                return ['icon' => 'error', 'message' => 'Kategori benzersiz değeri boş olamaz. Lütfen otomatik stok kodu oluşturmadan önce kategori benzersiz kodu tanımlayınız.'];
            }
            $stock_code = $category_item['category_value'] . str_pad($category_item['category_counter'] + 1, 5, '0', STR_PAD_LEFT);
            $category_counter = $category_item['category_counter'] + 1;
        } else {
            # Kullanıcı tarafından verilen stok kodu daha önce kullanılmış mı kontrolü
            $stock_item = $this->modelStock->where('user_id', 1)->where('stock_code', $stock_code)->where('deleted_at IS NOT NULL', null, false)->first();
            if ($stock_item) {
                return ['icon' => 'error', 'message' => 'Bu ürün kodu daha önceden kullanılmış.'];
            }
        }
        return ['icon' => 'success', 'value' => $stock_code, 'category_counter' => $category_counter];
    }


    public function DepoCevir($depo)
    {
        $depolar = [
            "1.DEPO" => "1",
            "2.DEPO" => "2",
            "3.DEPO" => "3",
            "AMBALAJ" => "4",
            "SAC DEPOSU" => "5",
            "ABS DEPOSU" => "6",
            "KALIP DEPOSU" => "7",
            "ÜRETİM ALANI" => "8"
        ];

        return isset($depolar[$depo]) ? $depolar[$depo] : "1"; // Eğer depo bulunamazsa varsayılan olarak "1" döndür
    }
    

    public function sysmond_depo() {
        try {
            // Bellek optimizasyonu
            ini_set('memory_limit', '2048M');
            gc_enable();
            
            // Verileri toplu işlem için tutacağımız diziler
            $batchInsert = [];
            $batchUpdate = [];
            
            // Stokları chunk'lar halinde işle
            $chunkSize = 100;
            $stocks = $this->modelStock->where('sysmond !=', '')->where('deleted_at IS NULL')->findAll();
            $stockChunks = array_chunk($stocks, $chunkSize);
            
            foreach ($stockChunks as $stockChunk) {
                // API'den depo verilerini al
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://85.105.220.154:8640/TrexIntegrationService/REST/GetJson',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 300,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "Query": "SELECT B.DEPOTNO, B.DEPOTID, B.DEPOTNAME, A.STOCKID ,A.BAKIYE FROM STOCKDEPOTREM A INNER JOIN DEPOT B ON A.COMPANYID = B.COMPANYID AND A.DEPOTID = B.DEPOTID WHERE A.COMPANYID=56",
                        "ApiKey": "1503279683"
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Accept: application/json'
                    ),
                ));
                
                $response = curl_exec($curl);
                curl_close($curl);
                
                if (empty($response)) continue;
                
                $response = stripslashes($response);
                $response = trim($response, '"');
                $depoData = json_decode($response, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) continue;


              
                
                // Mevcut kayıtları bir kerede al
                $existingRecords = $this->modelSysmondDepolar
                    ->where('deleted_at IS NULL')
                    ->findAll();
                
                $existingMap = array_column($existingRecords, 'sysmond_depo_id', 'stock_id');
                
                foreach ($stockChunk as $stock) {
                    $dataEkle = [
                        'user_id' => 1,
                        'sysmond' => $stock['sysmond'],
                        'stock_id' => $stock['stock_id'],
                        'stock_code' => $stock['stock_code'],
                        'depo_1' => '1.DEPO',
                        'depo_1_id' => '1',
                        'depo_1_count' => 0,
                        'depo_2' => '2.DEPO',
                        'depo_2_id' => '2',
                        'depo_2_count' => 0,
                        'depo_3' => '3.DEPO',
                        'depo_3_id' => '3',
                        'depo_3_count' => 0,
                        'depo_4' => 'AMBALAJ',
                        'depo_4_id' => '4',
                        'depo_4_count' => 0
                    ];
                    
                    // Depo verilerini eşleştir
                    foreach ($depoData as $depo) {
                        if ($depo['STOCKID'] == $stock['sysmond']) {
                            $depoNo = $depo['DEPOTNO'];
                            if ($depoNo >= 1 && $depoNo <= 4) {
                                $dataEkle["depo_{$depoNo}"] = $depo['DEPOTNAME'];
                                $dataEkle["depo_{$depoNo}_id"] = $depo['DEPOTID'];
                                $dataEkle["depo_{$depoNo}_count"] = $depo['BAKIYE'];
                            }
                        }
                    }
                    
                    // Kayıt varsa güncelleme, yoksa ekleme listesine ekle
                    if (isset($existingMap[$stock['stock_id']])) {
                        $dataEkle['sysmond_depo_id'] = $existingMap[$stock['stock_id']];
                        $batchUpdate[] = $dataEkle;
                    } else {
                        $batchInsert[] = $dataEkle;
                    }
                }
                
                // Her chunk sonrası belleği temizle
                unset($depoData);
                gc_collect_cycles();
            }
            
            // Toplu işlemleri gerçekleştir
            if (!empty($batchInsert)) {
                $this->modelSysmondDepolar->insertBatch($batchInsert, 100);
            }
            
            if (!empty($batchUpdate)) {
                $this->modelSysmondDepolar->updateBatch($batchUpdate, 'sysmond_depo_id', 100);
            }
            
            // Log kaydı
            $LogKaydet = [
                'tarih' => date('Y-m-d H:i:s'),
                'durum' => 'SYSMOND DEPO GÜNCELLEME BAŞARILI',
                'mesaj' => 'active',
                'mail' => 1,
                'processed_records' => count($batchInsert) + count($batchUpdate)
            ];
            
            $this->SysmondCronModel->insert($LogKaydet);
            
            return "Toplu güncelleme başarılı. Eklenen: " . count($batchInsert) . ", Güncellenen: " . count($batchUpdate);
            
        } catch (Exception $e) {
            log_message('error', 'Sysmond Depo Hatası: ' . $e->getMessage());
            return "Hata oluştu: " . $e->getMessage();
        }
    }

    public function sysmond_depo_tekli($stock_id = null) {
        try {
            if (!$stock_id) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Stok ID gerekli'
                ]);
            }

            // Stok bilgisini al
            $stock = $this->modelStock->where('deleted_at IS NULL')->where('sysmond', $stock_id)->first();
            if (!$stock || empty($stock['sysmond'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Geçerli stok bulunamadı veya sysmond kodu yok'
                ]);
            }

            // API'den depo verilerini al
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://85.105.220.154:8640/TrexIntegrationService/REST/GetJson',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 300,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "Query": "SELECT B.DEPOTNO, B.DEPOTID, B.DEPOTNAME, A.STOCKID ,A.BAKIYE FROM STOCKDEPOTREM A INNER JOIN DEPOT B ON A.COMPANYID = B.COMPANYID AND A.DEPOTID = B.DEPOTID WHERE A.COMPANYID=56 AND A.STOCKID=\'' . $stock['sysmond'] . '\'",
                    "ApiKey": "1503279683"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: application/json'
                ),
            ));
            
            $response = curl_exec($curl);
            curl_close($curl);
            
            if (empty($response)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'API yanıt vermedi'
                ]);
            }
            
            $response = stripslashes($response);
            $response = trim($response, '"');
            $depoData = json_decode($response, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'API yanıtı geçersiz JSON formatı'
                ]);
            }

            // Güncellenecek veri
            $dataEkle = [
                'user_id' => 1,
                'sysmond' => $stock['sysmond'],
                'stock_id' => $stock['stock_id'],
                'stock_code' => $stock['stock_code'],
                'depo_1' => '1.DEPO',
                'depo_1_id' => '1',
                'depo_1_count' => 0,
                'depo_2' => '2.DEPO',
                'depo_2_id' => '2',
                'depo_2_count' => 0,
                'depo_3' => '3.DEPO',
                'depo_3_id' => '3',
                'depo_3_count' => 0,
                'depo_4' => 'AMBALAJ',
                'depo_4_id' => '4',
                'depo_4_count' => 0
            ];
            
            // Depo verilerini eşleştir
            foreach ($depoData as $depo) {
                if ($depo['STOCKID'] == $stock['sysmond']) {
                    $depoNo = $depo['DEPOTNO'];
                    if ($depoNo >= 1 && $depoNo <= 4) {
                        $dataEkle["depo_{$depoNo}"] = $depo['DEPOTNAME'];
                        $dataEkle["depo_{$depoNo}_id"] = $depo['DEPOTID'];
                        $dataEkle["depo_{$depoNo}_count"] = $depo['BAKIYE'];
                    }
                }
            }

            // Mevcut kaydı kontrol et
            $existingRecord = $this->modelSysmondDepolar
                ->where('sysmond', $stock_id)
                ->where('deleted_at IS NULL')
                ->first();

            if ($existingRecord) {
                // Güncelleme
                $dataEkle['sysmond_depo_id'] = $existingRecord['sysmond_depo_id'];
                $this->modelSysmondDepolar->update($existingRecord['sysmond_depo_id'], $dataEkle);
            } else {
                // Yeni kayıt
                $this->modelSysmondDepolar->insert($dataEkle);
            }

            // Güncel veriyi al
            $guncelVeri = $this->modelSysmondDepolar
                ->where('sysmond', $stock_id)
                ->where('deleted_at IS NULL')
                ->first();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Depo bilgileri güncellendi',
                'data' => $guncelVeri
            ]);

        } catch (Exception $e) {
            log_message('error', 'Sysmond Tekli Depo Hatası: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Hata oluştu: ' . $e->getMessage()
            ]);
        }
    }





    public function sysmond_ikinci_barkod() {
        // Debug toolbar'ı devre dışı bırak
        $this->response->noCache();
        $this->response->setHeader('CI_DEBUG', 'false');
        
        ini_set('memory_limit', '1024M'); // Bellek limitini artır
        gc_enable(); // Garbage collector'ı aktif et
        
        $curl = curl_init();
                 //       "Query": "DECLARE @SIRKETID INT = 56 DECLARE @FIYAT1ID INT = 25 DECLARE @FIYAT2ID INT = 32 DECLARE @MERKEZDEPO INT = 22 DECLARE @BILGI1DEPO INT = 22 DECLARE @BILGI2DEPO INT = 22 DECLARE @EDITDATE DATETIME = CONVERT(DATETIME,\'01.01.2025\',104) SELECT S.COMPANYID, S.STOCKID STOCKREFID, S.STOCKNO URUNKODU, S.GROUPCODE GROUPCODE, S.SPECCODE1 SPECCODE1, SPECCODE2, S.SPECCODE3 SPECCODE3, S.SPECCODE4 SPECCODE4, S.SPECCODE5 SPECCODE5, S.SPECCODE6 SPECCODE6, S.SPECCODE7 SPECCODE7, S.SPECCODE8 SPECCODE8, S.SPECCODE9 SPECCODE9, S.SPECCODE10 SPECCODE10, S.SEASON SEASON, S.BRAND BRAND, S.MODEL MODEL, S.MINORDERQUANTITY, (SELECT COUNT(ITEMNO) RESIMSAY FROM STOCKPICTURE WHERE COMPANYID = @SIRKETID AND STOCKID = S.STOCKID ) AS RESIMSAY, ISNULL( (SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'1\') ,\'\') BARKOD1, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'2\') ,\'\') BARKOD2, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'3\') ,\'\') BARKOD3, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'4\') ,\'\') BARKOD4, ISNULL ((SELECT TOP 1 BARCODE FROM STOCKBARCODES WITH(NOLOCK) WHERE STOCKID = S.STOCKID AND COMPANYID = S.COMPANYID AND DESCRIPTION =\'5\') ,\'\') BARKOD5, (SELECT TOP 1 DESCRIPTION FROM GLBSPECDEF WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND ROOT = \'VE_STOCK\' AND ROOTFIELD = \'BRAND\' AND CODE = S.BRAND) MARKA, STOCKNAME URUNADI, STOCKNAME2 URUNADI2, (SELECT NOTES FROM NOTES WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND NOTES.NOTESID = S.NOTEID) NOTLAR, ISNULL((SELECT PRICE FROM STOCKPRICE WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND STOCKPRICETYPEID = @FIYAT1ID),0) FIYAT1, ISNULL((SELECT PRICE FROM STOCKPRICE WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND STOCKPRICETYPEID = @FIYAT2ID),0) FIYAT2, S.CURRCODE DOVIZ, S.VATSALES KDV, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID),0) TOPLAMMIKTARI, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @MERKEZDEPO),0) MERKEZDEPOMIKTAR, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @BILGI1DEPO),0) BILGIDEPO1, ISNULL((SELECT Sum(QENTRY) - Sum(QEXIT) FROM STOCKTRANS WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND STOCKID = S.STOCKID AND DEPOTID = @BILGI2DEPO),0) BILGIDEPO2, ISNULL((SELECT SUM(OI.QUANTITY) - SUM(OI.DQUANTITY) ACIKSIPMIK FROM ORDERS O WITH(NOLOCK) INNER JOIN ORDERSITEM OI WITH(NOLOCK) ON O.COMPANYID = OI.COMPANYID AND O.RECEIPTID = OI.RECEIPTID AND O.STATUS =2 AND STOCKID = S.STOCKID WHERE O.COMPANYID=S.COMPANYID AND O.TRANSTYPE = 103),0) acik_sip_miktari, S.UNITNAME BIRIM, S.MATRIX, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID) AS MATRIX1, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID2) AS MATRIX2, (SELECT MATRIXNO FROM MATRIXITEM WITH(NOLOCK) WHERE COMPANYID = S.COMPANYID AND MATRIXUNIQID = S.MATRIXUNIQID3) AS MATRIX3 FROM VE_STOCK S WITH(NOLOCK) WHERE COMPANYID = @SIRKETID  AND  Isnull(MATRIXSTOCKID, 0) = 0 AND EDITDATE >= @EDITDATE ",

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://85.105.220.154:8640/TrexIntegrationService/REST/GetJson',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "Query": "SELECT * FROM STOCKBARCODES WHERE COMPANYID=56 ",
                "ApiKey": "1503279683"
              }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            echo 'cURL Hatası: ' . curl_error($curl);
            curl_close($curl);
            return;
        }

        curl_close($curl);

        if (empty($response)) {
            echo 'API yanıtı boş.';
            return;
        }

        $response = stripslashes($response);
        $response = trim($response, '"');
        $stockData = json_decode($response, true);


    
   

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "JSON verisi çözümlenemedi. Hata: " . json_last_error_msg();
            return;
        }

     

    

        foreach ($stockData as $stock) {


            
            $stockBul = $this->modelStock->where('sysmond', $stock['STOCKID'])->first();
            if($stockBul){
                $barcode_number_2 = generate_barcode_number_fams($stock['BARCODE']);
                
                // Önce bu barkodun var olup olmadığını kontrol et
                $existingBarcode = $this->modelSysmondBarkodlar
                    ->where('barkod', $barcode_number_2)
                    ->first();
                
                if(!$existingBarcode) {
                    // Barkod yoksa ekle
                    $this->modelSysmondBarkodlar->insert([
                        'stock_id' => $stockBul['stock_id'],
                        'sysmond_id' => $stock['STOCKID'],
                        'barkod' => $barcode_number_2,
                        'stok_kodu' => $stockBul['stock_code'],
                        'stok_basligi' => $stockBul['stock_title'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    
                    log_message('info', 'Yeni barkod eklendi: ' . $barcode_number_2);
                } else {
                    log_message('info', 'Bu barkod zaten var: ' . $barcode_number_2);
                }
            }
           
        }

            
     

        echo "Sysmond Online veriler başarıyla güncellendi.";
        return;
    }



    public function sysmond_depo_kontrol(){
        // Debug toolbar'ı devre dışı bırak
        $db = $this->userDatabase();
        $this->response->noCache();
  
        $this->response->setHeader('CI_DEBUG', 'false');

        // Memory limit ve timeout ayarları
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 900); // 15 dakika
        set_time_limit(900);
        
        // Garbage collection'ı aktif et
        gc_enable();

        // Test için sadece 5 kayıt alacağız
        $TumVeriler = $db->table("sysmond_depolar")->get()->getResultArray();
       
        $totalProcessed = 0;


            
        foreach ($TumVeriler as $item) {
            try {
               
               
                $stock = $this->modelStock
                ->select("stock_id, sysmond, stock_total_quantity")
                                        ->Where("sysmond", $item['sysmond'])
                                        ->first();
            
                                       
                
                if($stock){


                    $depo_1_count = $item['depo_1_count'];
                    $depo_2_count = $item['depo_2_count'];
                    $depo_3_count = $item['depo_3_count'];
                    $depo_4_count = $item['depo_4_count'];
                   
            

                    // Stok miktarı karşılaştırma
                   // ... existing code ...
                   $apiStokMiktari = (float)$item['depo_1_count'] + (float)$item['depo_2_count'] + (float)$item['depo_3_count'] + (float)$item['depo_4_count'];
                   $dbStokMiktari = (float)$stock['stock_total_quantity'];
                   $fark = round($apiStokMiktari - $dbStokMiktari, 4); // 4 decimal hassasiyet

                   if(abs($fark) > 0.0001){ // Çok küçük farkları göz ardı et
                       // Debug bilgisi ekleyelim
                       echo "DEBUG - Stok Durumu:<br>";
                       echo "API Toplam Stok: " . $apiStokMiktari . "<br>";
                       echo "DB Stok: " . $dbStokMiktari . "<br>";
                       echo "Fark: " . $fark . "<br>";
                       echo "İşlem: " . ($fark > 0 ? "Stok Girişi +" . abs($fark) : "Stok Düşümü -" . abs($fark)) . "<br>";
                       echo "-------------------<br>";

                       // Detaylı depo bilgisi
                       echo  $item['sysmond'] . " - " . 
                             $item['stock_code'] . " | " .
                             "1. DEPO: " . $item['depo_1_count'] . " - " .
                             "2. DEPO: " . $item['depo_2_count'] . " - " .
                             "3. DEPO: " . $item['depo_3_count'] . " - " .
                             "AMBALAJ: " . $item['depo_4_count'] . " | " .
                             "Toplam Stok: " . $apiStokMiktari . " - " .
                             "DB Stok: " . $stock['stock_total_quantity'] . " - " .
                             "Fark: " . $fark . "<br>";

                       $anlikTarih = new Time('now', 'Turkey', 'en_US');
                       $textMesaj = "Sysmond senkronizasyonu: ".$anlikTarih->toDateTimeString()." tarihinde ".abs($fark)." adet ".$item['stock_code']." ".($fark > 0 ? "stok girişi" : "stok düşümü")." (API: ".$apiStokMiktari.", DB: ".$dbStokMiktari.")";
                       
                       echo $textMesaj . "<br>";
                       $orderStoks = new \App\Controllers\TikoERP\Order();

                       // Örnek senaryolar:
                       // 1. API: 50, DB: 30 => Fark: +20 => Stok Girişi: 20
                       // 2. API: 30, DB: 50 => Fark: -20 => Stok Düşümü: 20
                       if($fark > 0) {
                           $orderStoks->stokGiris($stock['stock_id'], abs($fark), 1, $textMesaj);
                           echo "<strong>Stok girişi yapıldı: +" . abs($fark) . "</strong><br>";
                       } else {
                           $orderStoks->stokDusum($stock['stock_id'], abs($fark), 1, $textMesaj);
                           echo "<strong>Stok düşümü yapıldı: -" . abs($fark) . "</strong><br>";
                       }

                       $urunGuncelle = $this->modelStock->set('stock_total_quantity', $apiStokMiktari)->where('sysmond', $item['sysmond'])->update();
                       echo "===================<br>";
                   }
 
                } else {
                    echo "Stok bulunamadı: " . $item['sysmond'] . "\n";
                }
            } catch (\Exception $e) {
                echo "Hata oluştu: " . $e->getMessage() . " - StockID: " . $item['sysmond'] . "\n";
                continue;
            }
            
            $totalProcessed++;
            echo "-------------------\n";
        }
        
        // İşlem tamamlandı bildirimi
        $LogKaydet = [
            'tarih' => date("d-m-Y H:i"),
            'durum' => "SYSMOND STOK  SENKRONİZASYONU TAMAMLANDI İŞLENEN KAYIT SAYISI: ".$totalProcessed,
            'mesaj' => "active",
            'mail'  => 1,
            'processed_records' => $totalProcessed
        ];
        
        $this->SysmondCronModel->insert($LogKaydet);
        echo "Test senkronizasyonu tamamlandı. İşlenen kayıt sayısı: $totalProcessed";
        return;
    }




    public function depodan_stok_esitle(){
        // Debug toolbar'ı devre dışı bırak
        $this->response->noCache();
        $this->response->setHeader('CI_DEBUG', 'false');

        // Memory limit ve timeout ayarları
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 900); // 15 dakika
        set_time_limit(900);
        
        // Garbage collection'ı aktif et
        gc_enable();

        // Test için sadece 5 kayıt alacağız
        $TumVeriler = $this->modelSysmondDepolar->findAll();
        $totalProcessed = 0;


            
        foreach ($TumVeriler as $item) {
            try {
               
               
                $stock = $this->modelStock
                                        ->Where("stock_id", $item['stock_id'])
                                        ->first();
            
                                       
                
                if($stock){


                    $depo_1_count = $item['depo_1_count'];
                    $depo_2_count = $item['depo_2_count'];
                    $depo_3_count = $item['depo_3_count'];
                    $depo_4_count = $item['depo_4_count'];
                   
            

                    // Stok miktarı karşılaştırma
                    $apiStokMiktari = (float)$item['depo_1_count'] + (float)$item['depo_2_count'] + (float)$item['depo_3_count'] + (float)$item['depo_4_count'];
                    $dbStokMiktari = (float)$stock['stock_total_quantity'];
                    $fark = $apiStokMiktari - $dbStokMiktari;
                    
                    if($fark != 0) {
                        $anlikTarih = new Time('now', 'Turkey', 'en_US');
                        $textMesaj = "Sysmond senkronizasyonu: ".$anlikTarih->toDateTimeString()." tarihinde ".abs($fark)." adet ".$item['stock_code']." ".($fark > 0 ? "stok girişi" : "stok düşümü")." (API: ".$apiStokMiktari.", DB: ".$dbStokMiktari.")";
                        
                        echo $textMesaj . "\n";
                        
                        $orderStoks = new \App\Controllers\TikoERP\Order();
                        if($fark > 0) {
                            $orderStoks->stokGiris($stock['stock_id'], abs($fark), 1, $textMesaj);
                            echo "Stok girişi yapıldı\n";
                        } else {
                            $orderStoks->stokDusum($stock['stock_id'], abs($fark), 1, $textMesaj);
                            echo "Stok düşümü yapıldı\n";
                        }

                        // Log kaydı oluştur
                        $logData = [
                            'sysmond_stockid' => $item['sysmond'],
                            'stock_id' => $stock['stock_id'],
                            'updated_data' => json_encode([
                                'old_quantity' => $dbStokMiktari,
                                'new_quantity' => $apiStokMiktari,
                                'difference' => $fark
                            ]),
                            'log_text' => 'Stok miktarı SYSMOND API ile senkronize edildi ',
                            'user_id' => 1,
                            'client_id' => 1,
                            'ip_address' => $this->request->getIPAddress(),
                            'browser' => $this->request->getUserAgent()->getBrowser(),
                            'is_mobile' => $this->request->getUserAgent()->isMobile() ? 1 : 0
                        ];
                        $this->modelSysmondLog->insert($logData);
                        echo "Log kaydı oluşturuldu\n";
                    } else {
                        echo "Stok miktarı aynı, güncelleme yapılmadı\n";
                    }
                } else {
                    echo "Stok bulunamadı: " . $item['sysmond'] . "\n";
                }
            } catch (\Exception $e) {
                echo "Hata oluştu: " . $e->getMessage() . " - StockID: " . $item['sysmond'] . "\n";
                continue;
            }
            
            $totalProcessed++;
            echo "-------------------\n";
        }
        
        // İşlem tamamlandı bildirimi
        $LogKaydet = [
            'tarih' => date("d-m-Y H:i"),
            'durum' => "SYSMOND STOK  SENKRONİZASYONU TAMAMLANDI İŞLENEN KAYIT SAYISI: ".$totalProcessed,
            'mesaj' => "active",
            'mail'  => 1,
            'processed_records' => $totalProcessed
        ];
        
        $this->SysmondCronModel->insert($LogKaydet);
        echo "Test senkronizasyonu tamamlandı. İşlenen kayıt sayısı: $totalProcessed";
        return;
    }
}