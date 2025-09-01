<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;

use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;

use function PHPUnit\Framework\returnSelf;

/**
 * @property IncomingRequest $request
 */
ini_set('memory_limit', '1024M'); // Bellek limitini 512 MB yap
ini_set('max_execution_time', "-1");


class MshApi extends BaseController
{
    private $DatabaseConfig;
    private $currentDB;

    private $modelCari;
    private $modelMoneyUnit;
    private $modelFinancialMovement;
    private $modelAddress;
    private $modelStock;
    private $modelOrder;
    private $modelOrderRow;

    private $modelStockVariantGroup;
    private $modelNote;

    private $logClass;
    private $modelStockRecipe;
    private $modelStockBarcode;
    private $modelWarehouse;
    private $modelStockGallery;
    private $modelCategory;
    private $modelVariantGroup;
    private $modelVariantProperty;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);
        $this->modelCategory = model($TikoERPModelPath . '\CategoryModel', true, $db_connection);

        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
        $this->modelFinancialMovement = model($TikoERPModelPath . '\FinancialMovementModel', true, $db_connection);
        $this->modelMoneyUnit = model($TikoERPModelPath . '\MoneyUnitModel', true, $db_connection);
        $this->modelAddress = model($TikoERPModelPath . '\AddressModel', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath . '\StockModel', true, $db_connection);
        $this->modelOrder = model($TikoERPModelPath . '\OrderModel', true, $db_connection);
        $this->modelOrderRow = model($TikoERPModelPath . '\OrderRowModel', true, $db_connection);
        $this->modelNote = model($TikoERPModelPath . '\NoteModel', true, $db_connection);
        $this->modelStockVariantGroup = model($TikoERPModelPath . '\StockVariantGroupModel', true, $db_connection);

        $this->modelUnit = model($TikoERPModelPath . '\UnitModel', true, $db_connection);
        $this->modelStockRecipe = model($TikoERPModelPath . '\StockRecipeModel', true, $db_connection);
        $this->modelStockBarcode = model($TikoERPModelPath . '\StockBarcodeModel', true, $db_connection);
        $this->modelWarehouse = model($TikoERPModelPath . '\WarehouseModel', true, $db_connection);
        $this->modelStockGallery = model($TikoERPModelPath . '\StockGalleryModel', true, $db_connection);


        $this->modelVariantGroup = model($TikoERPModelPath . '\VariantGroupModel', true, $db_connection);
        $this->modelVariantProperty = model($TikoERPModelPath . '\VariantPropertyModel', true, $db_connection);

        $this->logClass = new Log();

        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
    }

    public function b2bConnect()
    {
       
        
       
        

        $userDatabaseDetail = [
            'hostname' => '45.143.99.171',
            'username' => 'msh_us',
            'password' => '2iigNrDIaD5e2Bm6',
            'database' => 'msh_db',
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


    public function siteConnect()
    {
       
        
       
        

        $userDatabaseDetail = [
            'hostname' => '78.135.107.25',
            'username' => 'testmsh_db',
            'password' => 'jNXrqHX8QJ94Fma8j9zS',
            'database' => 'testmsh_db',
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


    public function siparisleriGetir()
    {
        $database = $this->b2bConnect();

      //  echo '<pre>';
        //print_r();
        //echo '</pre>';

        $tumSiparisler = $database->table("siparisler")->where("durum_id != ", 1)->get()->getResult();


       
        

        foreach($tumSiparisler as $siparis)
        {   
            $siparis = get_object_vars($siparis);

          
      
            $siparisData = [];
            $new_data_form = [];
            $data_order_amounts = [];
            $b2bText = "";
             // *********** SİPARİŞ EKLEME BAŞLANGIÇ **************** //


                $Sorgula = $this->modelOrder->where("order_no", $siparis["siparis_no"])->first();

                if(!$Sorgula)
                {   
                    

                    $musteriBilgilerim = $database->table("musteriler")->where("id", $siparis["musteri_id"])->get()->getResultObject();
                    $musteriBilgileri = $musteriBilgilerim[0];
              
                    $saticiBilgileri = $database->table("musteriler")->where("id", $siparis["satici"])->get()->getResultObject();
                    $satici = $saticiBilgileri[0];


    


                    $CariSorgula = $this->modelCari->orWhere("identification_number", $musteriBilgileri->firma_ulke)->where("invoice_title", $musteriBilgileri->firma_adi)->first();
                
                
                    
                    $cari_id = 0;
                    if(!$CariSorgula){

                        $is_export_customer = 0;
                        if(!empty($siparis['firma_ulke'])){
                            $tcvkn = $siparis['firma_ulke'];
                        }else{
                            $tcvkn = 3333333333;
                        }
                        $new_data_form['invoice_title'] = $siparis["firma_adi"];
                        $fullName = $siparis["yetkili_adi"] ?? '';
                        $nameParts = explode(' ', $fullName);
            
                        if (count($nameParts) < 2) {
                            // Handle cases where full name does not contain a space
                            $nameParts[] = '';
                        }
            
                        $new_data_form['surname'] = array_pop($nameParts);
                        $new_data_form['name'] = implode(' ', $nameParts);
                        
                        $new_data_form['obligation'] = "e-archive";
                        $new_data_form['company_type'] = "company";
                        $new_data_form['address_city_name'] = "";
                        $new_data_form['address_city'] = "";
                        $new_data_form['address_district'] = "";
                        $new_data_form['zip_code'] = "";
                        $new_data_form['address'] = "";

                        $phoneNumber = $musteriBilgileri->firma_tel;


                        if (substr($phoneNumber, 0, 1) === '0') {
                            $phoneNumber = substr($phoneNumber, 1);
                        }
                
                        // Numaranın 10 haneli olup olmadığını kontrol et
                        if (strlen($phoneNumber) < 10) {
                            $phoneNumber = str_pad($phoneNumber, 10, "0", STR_PAD_LEFT);
                        }
                
                        // +90 ekle ve boşluk bırak
                        $phoneNumber = '+90 ' . $phoneNumber;

                        $create_cari_code = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
                        if(!is_numeric($musteriBilgileri->firma_ulke))
                        {
                            $identification_number  = 1111111111;
                        }else{
                            $identification_number = $musteriBilgileri->firma_ulke;
                        }
                        $cari_data = [
                            'user_id' => session()->get('user_id'),
                            'money_unit_id' => 3,
                            'cari_code' => $create_cari_code,
                            'identification_number' => $identification_number,
                            'tax_administration' => $musteriBilgileri->firma_web != '' ? $musteriBilgileri->firma_web : null,
                            'invoice_title' => $new_data_form['invoice_title'],
                            'name' => $new_data_form['name'],
                            'surname' => $new_data_form['surname'],
                            'obligation' => $new_data_form['obligation'] != '' ? $new_data_form['obligation'] : null,
                            'company_type' => $new_data_form['company_type'] != '' ? $new_data_form['company_type'] : null ,
                            'cari_phone' => $phoneNumber,
                            'cari_email' => $musteriBilgileri->email != '' ? $musteriBilgileri->email : null,
                            'is_customer' => 1,
                            
                            'is_supplier' => 0,
                            'is_export_customer' => $is_export_customer,
                        ];
    
                        $address_data = [
                            'user_id' => session()->get('user_id'),
                            'address_title' => 'Fatura Adresi',
                            'address_country' => 'TR',
                            'address_city' => $new_data_form['address_city_name'] != '' ? $new_data_form['address_city_name'] : null,
                            'address_city_plate' => isset($new_data_form['address_city']) ? $new_data_form['address_city'] : null,
                            'address_district' => isset($new_data_form['address_district']) ? $new_data_form['address_district'] : null,
                            'zip_code' => $new_data_form['zip_code'] != '' ? $new_data_form['zip_code'] : null,
                            'address' => $new_data_form['address'],
                            'address_phone' => $phoneNumber,
                            'address_email' => $musteriBilgileri->email != '' ? $musteriBilgileri->email : null,
                        ];
    
                        if (!$CariSorgula) {
                      
                            $this->modelCari->insert($cari_data);
                            $cari_id = $this->modelCari->getInsertID();
                            $address_data['cari_id'] = $cari_id;
                            $address_data['status'] = 'active';
                            $address_data['default'] = 'true';
                            $this->modelAddress->insert($address_data);
                        } 
                        }else{
                            $cari_id = $CariSorgula['cari_id'];
                            $CariSorgula = $this->modelCari->where("cari_id", $cari_id)->first();
                       
                            
                  
                            
                           /*  $cari_balance = $CariSorgula['cari_balance'] + $siparis["toplam_tutar"];
                            $cari_data['cari_balance'] = $cari_balance;
                            $this->modelCari->update($cari_id, $cari_data); */
    
                  
                  
                        }


                        $CariSorgula = $this->modelCari->where("cari_id", $cari_id)->first();






                   
            
        

                   

                    $musteriMail = $musteriBilgileri->email;
                    $is_customer = 1;
                    $is_supplier = 0;
                    $is_export_customer  = 0;

                    $siparisTarih = $siparis["siparis_tarihi"];
                    $dateTime = new \DateTime($siparisTarih);
                    $new_data_form['order_date'] = $dateTime->format('Y') . "-" . $dateTime->format('m') . "-" . $dateTime->format('d');
                    $new_data_form['order_time'] = $dateTime->format('H') . ":" . $dateTime->format('i');


                    $data_order_amounts['amount_to_be_paid'] = $siparis["toplam_tutar"];
       
                    $transaction_prefix = $siparis["siparis_no"];
                    $errRows = [];


                    try {


                   
        
                        $phone = isset($CariSorgula['cari_phone']) ? str_replace(array('(', ')', ' '), '', $CariSorgula['cari_phone']) : null;
                      
                        $phoneNumber = $CariSorgula['cari_phone'];

                    
        
                        $order_date = $new_data_form['order_date'];
                        $order_time = $new_data_form['order_time'];

                      
        
                     
                        $transaction_amount = isset($data_order_amounts['amount_to_be_paid']) ? convert_number_for_sql($data_order_amounts['amount_to_be_paid']) : convert_number_for_sql($data_order_amounts['amount_to_be_paid_try']);
        
                        // $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.identification_number', $new_data_form['identification_number'])->first();
                        if (isset($CariSorgula['cari_id']) && $CariSorgula['cari_id'] != 0) {
                            $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id', $CariSorgula['cari_id'])->first();
                        }
                        if (isset($CariSorgula['identification_number']) && $CariSorgula['identification_number'] != 0 && $CariSorgula['identification_number'] != null) {
                            $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.identification_number', $CariSorgula['identification_number'])->first();
                        }
                       
                    
                        // print_r($cari_item);
                        // return;


                        if($siparis["siparis_temrin"]){
                            $is_deadline  = 1;
                            $d_date = $siparis["siparis_temrin"];
                        }else{
                            $is_deadline  = 0;
                            $d_date = null;
                        }

                        if($siparis["durum_id"] == "2"){
                            $status_degeri = "pending";
                        }
                        else  if($siparis["durum_id"] == "4"){
                            $status_degeri = "success";
                        }
                        else  if($siparis["durum_id"] == "5"){
                            $status_degeri = "failed";
                        }else{
                            $status_degeri = "new";

                        }


                        $b2bText.= "İşlemi Yapan Satıcı: <b> " . $satici->yetkili_adi . "</b>  <br> Satıcı Telefon: <b>" . $satici->firma_tel. "</b> <br>";
                        $b2bText.="Site: <b>http://msh.tikobayi.com/</b><br>Sipariş No: <b>" . $siparis["siparis_no"] . "</b> <br> Sipariş Tarihi : <b>" . date("Y/m/d H:i", strtotime($siparis["siparis_tarihi"]))."</b>"; 

          
           
        
                        $cari_id = $CariSorgula['cari_id'];
                    
        
                        $order_note_id = 0;
                        $order_note = $siparis['siparis_not'] . " <br>  Ödeme Tipi: "   . $siparis["odeme"];
                      
                        if($siparis['iskonto_tutar'] > 0){
                            $gnl_ttr = $siparis['toplam_tutar'] - $siparis['iskonto_tutar'];
                        }else{
                            $gnl_ttr = $siparis['toplam_tutar'];
                        }
                    
                        $insert_order_data = [
                            'user_id' => session()->get('user_id'),
                            'money_unit_id' => $siparis["para_birimi_id"],
                            'order_direction' => 'outgoing',
                            'order_no' => $transaction_prefix,
                            'order_date' => $siparis["siparis_tarihi"],
                            'b2b' => $b2bText,
                            'order_note_id' => 0,
                            'order_note' => $order_note,
                            'invoice_no' => "#PROFORMA",
                            'is_deadline' => $is_deadline,
                            'deadline_date' => $d_date,
        
                            'currency_amount' => 0,
        
                            'stock_total' => $siparis['toplam_tutar'],
                            'stock_total_try' => $siparis['toplam_tutar'],
        
                            'discount_total' => $siparis['iskonto_tutar'],
                            'discount_total_try' => $siparis['iskonto_tutar'],
        
                            'tax_rate_1_amount' => convert_number_for_sql(0),
                            'tax_rate_1_amount_try' => convert_number_for_sql(0),
                            'tax_rate_10_amount' => convert_number_for_sql(0),
                            'tax_rate_10_amount_try' => convert_number_for_sql(0),
                            'tax_rate_20_amount' => convert_number_for_sql(0),
                            'tax_rate_20_amount_try' => convert_number_for_sql(0),
        
                            'sub_total' => $gnl_ttr,
                            'sub_total_try' => $gnl_ttr,
                            'sub_total_0' => convert_number_for_sql(0),
                            'sub_total_0_try' => convert_number_for_sql(0),
                            'sub_total_1' => convert_number_for_sql(0),
                            'sub_total_1_try' => convert_number_for_sql(0),
                            'sub_total_10' => convert_number_for_sql(0),
                            'sub_total_10_try' => convert_number_for_sql(0),
                            'sub_total_20' => convert_number_for_sql(0),
                            'sub_total_20_try' => convert_number_for_sql(0),
        
                            'grand_total' => $gnl_ttr,
                            'grand_total_try' => $gnl_ttr,
        
                            'amount_to_be_paid' => $gnl_ttr,
                            'amount_to_be_paid_try' => $gnl_ttr,
        
                            'amount_to_be_paid_text' => $this->yaziyaCevir($gnl_ttr),
        
                            'cari_id' => $cari_id,
                            'cari_identification_number' => $CariSorgula['identification_number'],
                            'cari_tax_administration' => $CariSorgula['tax_administration'],
        
                            'cari_invoice_title' => $CariSorgula['invoice_title'] == '' ? $CariSorgula['name'] . " " . $CariSorgula['surname'] : $CariSorgula['invoice_title'],
                            'cari_name' => $CariSorgula['name'],
                            'cari_surname' => $CariSorgula['surname'],
                            'cari_obligation' => $CariSorgula['obligation'],
                            'cari_company_type' => $CariSorgula['company_type'],
                            'cari_phone' => $phoneNumber,
                            'cari_email' => $CariSorgula['cari_email'],
        
                            'address_country' => $cari_item['address_country'],
        
                            'address_city' => $cari_item['address_city'],
                            'address_city_plate' => isset($cari_item['address_city_plate']) ? $cari_item['address_city_plate'] : "",
                            'address_district' => isset($cari_item['address_district']) ? $cari_item['address_district'] : "",
                            'address_zip_code' => $cari_item['zip_code'],
                            'address' => $cari_item['address'],
        
                            'order_status' => $status_degeri,
                            'fatura' => $siparis["siparis_teslim"], // Fiş mi Fatura mı 
                            'satisci' => $satici->yetkili_adi,
                            'failed_reason' => ""
                        ];




                  
                        $this->modelOrder->insert($insert_order_data);
                        $order_id = $this->modelOrder->getInsertID();

                       

                    
                        $altsiparisler = $database->table("siparisler_detay")->where("siparis_id", $siparis["id"])->get()->getResult();

                     
             
        
                        foreach ($altsiparisler as $data_order_row) {
                            $data_order_row = get_object_vars($data_order_row);

    
                        
                            // Stok bilgilerini almak
                            $stokBilgileri = $this->modelStock->where('stock_id', $data_order_row['app_stock'])->first();

             
                        
    
                        
                       if ($stokBilgileri) {
                                

                                if(!empty($data_order_row["app_stock"])){
                                    $insert_order_row_data = [
                                        'user_id' => session()->get('user_id'),
                                        'order_id' => $order_id,
                                        'stock_id' => $stokBilgileri['stock_id'],
                                        'stock_title' => $stokBilgileri['stock_title'],
                                        'dopigo_title' => $stokBilgileri['stock_title'],
                                        'stock_amount' => $data_order_row['adet_miktar'],
                                        'stock_total_quantity' => $stokBilgileri['stock_total_quantity'],
                                        'unit_id' => 1,
                                        'unit_price' => $data_order_row['birim_tutar'],
                                        'discount_rate' => $data_order_row['iskonto_oran'],
                                        'discount_price' => $data_order_row['iskonto_tutar'],
                                        'subtotal_price' => $data_order_row['genel_toplam'],
                                        'varyantlar' => $data_order_row['varyantlar'],
                                        'tax_id' => 0,
                                        'order_row_status' => $status_degeri,

                                        'tax_price' => 0,
                                        'total_price' => $data_order_row['genel_toplam'],
                                    ];
                                    $this->modelOrderRow->insert($insert_order_row_data);
                                }

                                
                             
                                /*
                                // Alt stokları almak
                                $altStoklar = $this->getAltStoklar($this->modelStock, $stokBilgileri["stock_id"]);
                        
                                $varyantlar = json_decode($data_order_row["varyantlar"], true);

                                $variyantBulundu = false; // Varyant bulunup bulunmadığını kontrol etmek için
                                $bulunanVaryantlar = []; // Bulunan varyantları tutmak için

                                foreach ($altStoklar as $stok) {
                                    foreach ($varyantlar as $index => $value) {
                                        $property_id = $value["altvaryantId"];
                                        $kategori_id = $value["kategori_id"];
                                
                                        // Stock group ve varyant bilgilerini almak
                                        $variyant = $this->getStockGroupAndVariyant($index + 1, $this->modelStockVariantGroup, $this->modelStock, $kategori_id, $property_id, $stok);
                                
                                        if ($variyant) {
                                            $bulunanVaryantlar[] = $variyant; // Bulunan varyantı ekle
                                        } else {
                                            // Varyant bulunamadıysa döngüyü kır ve bir sonraki stok ile devam et
                                            $bulunanVaryantlar = [];
                                            break;
                                        }
                                    }
                                    if(!empty($varyantlar)){
                                      
                                  
                                        // Eğer tüm varyantlar bulunduysa işlemleri gerçekleştir
                                        if (count($bulunanVaryantlar) === count($varyantlar)) {
                                            $variyantBulundu = true; // Varyant bulunduğunu belirt
                                    
                                            // İlk bulunan varyantı kullanarak işlemleri gerçekleştir
                                            $variyant = $bulunanVaryantlar[0];
                                    
                                            $insert_order_row_data = [
                                                'user_id' => session()->get('user_id'),
                                                'order_id' => $order_id,
                                                'stock_id' => $variyant['stock_id'],
                                                'stock_title' => $variyant['stock_title'],
                                                'stock_amount' => $data_order_row['adet_miktar'],
                                                'stock_total_quantity' => $variyant['stock_total_quantity'],
                                                'unit_id' => 1,
                                                'unit_price' => $data_order_row['birim_tutar'],
                                                'discount_rate' => $data_order_row['iskonto_oran'],
                                                'discount_price' => $data_order_row['iskonto_tutar'],
                                                'subtotal_price' => $data_order_row['genel_toplam'],
                                                'varyantlar' => $data_order_row['varyantlar'],
                                                'tax_id' => 0,
                                                'tax_price' => 0,
                                                'total_price' => $data_order_row['genel_toplam'],
                                            ];
                                            $this->modelOrderRow->insert($insert_order_row_data);
                                            break; // Varyant bulunduğunda döngüden çık
                                        }
                                     }
                                }
                                
                        
                                if (!$variyantBulundu) {
                                    $insert_order_row_data = [
                                        'user_id' => session()->get('user_id'),
                                        'order_id' => $order_id,
                                        'stock_id' => $stokBilgileri['stock_id'],
                                        'stock_title' => $stokBilgileri['stock_title'],
                                        'stock_amount' => $data_order_row['adet_miktar'],
                                        'stock_total_quantity' => $stokBilgileri['stock_total_quantity'],
                                        'unit_id' => 1,
                                        'unit_price' => $data_order_row['birim_tutar'],
                                        'discount_rate' => $data_order_row['iskonto_oran'],
                                        'discount_price' => $data_order_row['iskonto_tutar'],
                                        'subtotal_price' => $data_order_row['genel_toplam'],
                                        'varyantlar' => $data_order_row['varyantlar'],
                                        'tax_id' => 0,
                                        'tax_price' => 0,
                                        'total_price' => $data_order_row['genel_toplam'],
                                    ];
                                    $this->modelOrderRow->insert($insert_order_row_data);
                                }*/
                        
                        }

                        if(empty($data_order_row["app_stock"]))
                        {
                          

                                $insert_order_row_data = [
                                    'user_id' => session()->get('user_id'),
                                    'order_id' => $order_id,
                                    'stock_id' => 0,
                                    'stock_title' => $data_order_row['urun_ad'],
                                    'dopigo_title' => $data_order_row['urun_ad'],
                                    'stock_amount' => $data_order_row['adet_miktar'],
                                    'stock_total_quantity' => 0,
                                    'unit_id' => 1,
                                    'order_row_status' => $status_degeri,
                                    'unit_price' => $data_order_row['birim_tutar'],
                                    'discount_rate' => $data_order_row['iskonto_oran'],
                                    'discount_price' => $data_order_row['iskonto_tutar'],
                                    'subtotal_price' => $data_order_row['genel_toplam'],
                                    'varyantlar' => $data_order_row['varyantlar'],
                                    'tax_id' => 0,
                                    'tax_price' => 0,
                                    'total_price' => $data_order_row['genel_toplam'],
                                ];
                                $this->modelOrderRow->insert($insert_order_row_data);

                           
                        }


                        }
                        
                    
        
                 
                    } catch (\Exception $e) {
                        $trace = $e->getTrace();
    $file = $trace[0]['file'] ?? 'N/A';
    $line = $trace[0]['line'] ?? 'N/A';
                        $this->logClass->save_log(
                            'error',
                            'order',
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
                    

                }

               
               // *********** SİPARİŞ EKLEME BİTİŞ **************** //
           

               
    }



    public function getAltStoklar($modelStock, $stock_id) {
        return $modelStock->where("parent_id", $stock_id)->findAll();
    }


    public function getStockGroupAndVariyant($count, $modelStockVariantGroup, $modelStock, $kategori_id, $property_id, $stok) {
        $sutun = "variant_" . $count;
        $stockGroup = $modelStockVariantGroup->where("category_id", $kategori_id)
                                            ->where($sutun, $property_id)
                                            ->where("stock_id", $stok["stock_id"])
                                            ->first();
        if ($stockGroup) {
            return $modelStock->where('stock_id', $stockGroup['stock_id'])->first();
        }
        return null;
    }

    


   public  function yaziyaCevir($sayi) {
        $birler = array("", "BİR", "İKİ", "ÜÇ", "DÖRT", "BEŞ", "ALTI", "YEDİ", "SEKİZ", "DOKUZ");
        $onlar = array("", "ON", "YİRMİ", "OTUZ", "KIRK", "ELLİ", "ALTMIŞ", "YETMİŞ", "SEKSEN", "DOKSAN");
        $sayi = number_format($sayi, 2, '.', '');
        $parcala = explode('.', $sayi);
        
        $lira = $parcala[0];
        $kurus = $parcala[1];
        
        $metin = '';
    
        if ($lira == 0) {
            $metin .= 'SIFIR';
        } else {
            $liraBirler = $lira % 10;
            $liraOnlar = ($lira / 10) % 10;
            $liraYuzler = ($lira / 100) % 10;
            $liraBinler = ($lira / 1000) % 10;
            
            if ($liraBinler != 0) {
                $metin .= $birler[$liraBinler] . ' BİN ';
            }
            
            if ($liraYuzler != 0) {
                $metin .= $birler[$liraYuzler] . ' YÜZ ';
            }
            
            if ($liraOnlar != 0) {
                $metin .= $onlar[$liraOnlar] . ' ';
            }
            
            if ($liraBirler != 0) {
                $metin .= $birler[$liraBirler] . ' ';
            }
        }
    
        $metin .= 'TÜRK LİRASI';
    
        if ($kurus != 0) {
            $kurusBirler = $kurus % 10;
            $kurusOnlar = ($kurus / 10) % 10;
    
            $metin .= ' ';
            
            if ($kurusOnlar != 0) {
                $metin .= $onlar[$kurusOnlar] . ' ';
            }
            
            if ($kurusBirler != 0) {
                $metin .= $birler[$kurusBirler] . ' ';
            }
    
            $metin .= 'KURUŞ';
        }
    
        return $metin;
    }
    




    public function seo_slug($string) {

        $string = mb_strtolower($string, 'UTF-8');
    
        $turkce = array('ş', 'ı', 'ö', 'ü', 'ç', 'ğ');
        $duzgun = array('s', 'i', 'o', 'u', 'c', 'g');
        $string = str_replace($turkce, $duzgun, $string);
    
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string); 
        $string = trim($string, '-'); 
    
        return $string;
    }

    function formatTitle($title) {
        // Tüm metni küçük harflere çeviriyoruz
        $lowercased = mb_strtolower($title, 'UTF-8');
    
        // Her kelimenin ilk harfini büyük yapıyoruz
        $formattedTitle = mb_convert_case($lowercased, MB_CASE_TITLE, 'UTF-8');
    
        return $formattedTitle;
    }


    public function UrunKontrolEt()
    {
        // Performans için sadece temel bilgileri çekelim
        $websiteVariantGroups = $this->modelVariantGroup
            ->where('website', 1)
            ->where('deleted_at', null)
            ->select('variant_group_id, variant_title, `order`, status, variant_column, maliyet, website, b2b')
            ->findAll();

        $result = [];
        $totalStocks = 0;
        $totalCategories = 0;
        $allCategories = [];
        $totalVariantProperties = 0;

        foreach ($websiteVariantGroups as $variantGroup) {
            $groupData = [
                'variant_group_id' => $variantGroup['variant_group_id'],
                'variant_title' => $variantGroup['variant_title'],
                'order' => $variantGroup['order'],
                'status' => $variantGroup['status'],
                'variant_column' => $variantGroup['variant_column'],
                'maliyet' => $variantGroup['maliyet'],
                'website' => $variantGroup['website'],
                'b2b' => $variantGroup['b2b'],
                'variant_properties' => [],
                'categories' => [],
                'stocks' => []
            ];

            // Varyant özelliklerini tek seferde çek
            $variantProperties = $this->modelVariantProperty
                ->where('variant_group_id', $variantGroup['variant_group_id'])
                ->where('deleted_at', null)
                ->select('variant_property_id, variant_property_title, variant_property_code, `order`')
                ->orderBy('order')
                ->findAll();

            $groupData['variant_properties'] = $variantProperties;
            $totalVariantProperties += count($variantProperties);

            // Kategorileri ve stokları tek sorguda çek (alt ürünlerden ana ürünleri bul)
            $categoryStocks = $this->modelVariantGroup
                ->join('variant_group_category vgc', 'vgc.variant_group_id = variant_group.variant_group_id')
                ->join('category c', 'c.category_id = vgc.category_id')
                ->join('stock_variant_group svg', 'svg.category_id = c.category_id')
                ->join('stock variant_stock', 'variant_stock.stock_id = svg.stock_id')
                ->join('stock main_stock', 'main_stock.stock_id = variant_stock.parent_id')
                ->where('variant_group.variant_group_id', $variantGroup['variant_group_id'])
                ->where('variant_group.deleted_at', null)
                ->where('c.deleted_at', null)
                ->where('svg.deleted_at', null)
                ->where('variant_stock.deleted_at', null)
                ->where('main_stock.deleted_at', null)
                ->where('main_stock.parent_id <', 1) // Ana ürünler
                ->select('
                    c.category_id, 
                    c.category_title, 
                    vgc.variant_column as category_variant_column,
                    main_stock.stock_id, 
                    main_stock.stock_title, 
                    main_stock.stock_code, 
                    main_stock.status as stock_status,
                    svg.variant_1, svg.variant_2, svg.variant_3, svg.variant_4, svg.variant_5,
                    svg.variant_6, svg.variant_7, svg.variant_8, svg.variant_9, svg.variant_10
                ')
                ->findAll();

            $categories = [];
            $stocks = [];

            foreach ($categoryStocks as $row) {
                // Kategori bilgisini ekle (eğer daha önce eklenmemişse)
                $categoryKey = $row['category_id'];
                if (!isset($categories[$categoryKey])) {
                    $categories[$categoryKey] = [
                        'category_id' => $row['category_id'],
                        'category_title' => $row['category_title'],
                        'variant_column' => $row['category_variant_column']
                    ];
                    
                    // Genel kategori listesine ekle
                    if (!isset($allCategories[$categoryKey])) {
                        $allCategories[$categoryKey] = [
                            'category_id' => $row['category_id'],
                            'category_title' => $row['category_title']
                        ];
                    }
                }

                // Stok bilgisini ekle
                $stockKey = $row['stock_id'];
                if (!isset($stocks[$stockKey])) {
                    $variantCombination = [];
                    
                    // Varyant değerlerini al
                    for ($i = 1; $i <= 10; $i++) {
                        if (!empty($row["variant_$i"])) {
                            // Varyant özelliğini bul
                            foreach ($variantProperties as $vp) {
                                if ($vp['variant_property_id'] == $row["variant_$i"]) {
                                    $variantCombination[] = [
                                        'variant_column' => $i,
                                        'variant_property_id' => $vp['variant_property_id'],
                                        'variant_property_title' => $vp['variant_property_title'],
                                        'variant_property_code' => $vp['variant_property_code']
                                    ];
                                    break;
                                }
                            }
                        }
                    }

                    $stocks[$stockKey] = [
                        'stock_id' => $row['stock_id'],
                        'stock_title' => $row['stock_title'],
                        'stock_code' => $row['stock_code'],
                        'category_id' => $row['category_id'],
                        'status' => $row['stock_status'],
                        'variant_combination' => $variantCombination
                    ];
                }
            }

            $groupData['categories'] = array_values($categories);
            $groupData['stocks'] = array_values($stocks);
            
            // Sayıları topla
            $totalStocks += count($stocks);
            $totalCategories += count($categories);
            
            $result[] = $groupData;
        }

        // Final JSON yapısı
        $finalResult = [
            'summary' => [
                'total_variant_groups' => count($websiteVariantGroups),
                'total_stocks' => $totalStocks,
                'total_categories' => count($allCategories),
                'total_variant_properties' => $totalVariantProperties
            ],
            'variant_groups' => $result,
            'all_categories' => array_values($allCategories)
        ];

        // Sonucu döndür
        return $finalResult;
    }

    public function msh_send_products_new_site(){

        $database = $this->siteConnect();

        // UrunKontrolEt fonksiyonunun çıktısını al
        $variantGroupsData = $this->UrunKontrolEt();
        
        // Eğer JSON çıktısı varsa decode et
        if (is_string($variantGroupsData)) {
            $variantGroupsData = json_decode($variantGroupsData, true);
        }
        
        // Varyant gruplarından stokları topla ve tam stok bilgilerini al
        $allStocks = [];
        if (isset($variantGroupsData['variant_groups'])) {
            foreach ($variantGroupsData['variant_groups'] as $variantGroup) {
                if (isset($variantGroup['stocks'])) {
                    foreach ($variantGroup['stocks'] as $stock) {
                        // Aynı stok ID'si varsa tekrar ekleme
                        if (!isset($allStocks[$stock['stock_id']])) {
                            // Tam stok bilgilerini veritabanından al
                            $fullStockData = $this->modelStock->where('stock_id', $stock['stock_id'])->first();
                            if ($fullStockData) {
                                // Varyant kombinasyonlarını da ekle
                                $fullStockData['variant_combination'] = $stock['variant_combination'];
                                $allStocks[$stock['stock_id']] = $fullStockData;
                            }
                        }
                    }
                }
            }
        }
        
        $ModelStock = array_values($allStocks);

        foreach($ModelStock as $Stock){
            if (!empty($Stock["mshsite"])) {
                $data = [
                 "erp_id" => $Stock["stock_id"],
                ];
                $result = $database->table("urunlers")->where("id", $Stock["mshsite"])->update($data);
                
                if (!$result) {
                    // Hata durumunda log veya echo
                    echo "Güncelleme başarısız: Stock ID " . $Stock["stock_id"];
                }
            }
         }


        echo "<pre>";
        print_r($ModelStock);
        echo "</pre>";
        die();



    
        $count = 0;
        foreach($ModelStock as $Stock){

            if($Stock["status"] == "active"){
                $durum = 1;
            }else{
                $durum = 0;
            }

            // Kategori bilgisini UrunKontrolEt'ten gelen veriden al
            $category = null;
            foreach ($variantGroupsData['all_categories'] as $cat) {
                if ($cat['category_id'] == $Stock['category_id']) {
                    $category = $cat;
                    break;
                }
            }
            
            // Eğer kategori bulunamazsa, veritabanından al
            if (!$category) {
                $catBul = $this->modelCategory->where("category_id", $Stock["category_id"])->first();
                $category = $catBul;
            }

            $cleanTitle = $category['category_title'];  
            $formattedTitle = $this->formatTitle($cleanTitle); 

            $ustKategori = $database->table("kategorilers")->where("baslik", $category['category_title'])->get()->getResultObject();
            
            if(empty($ustKategori)){

                $newCats = [
                    'sira' => 10,
                    'dil' => 'tr',
                    'baslik' => $category['category_title'],
                    'seflink' => $this->seo_slug($category['category_title']),
                    'modulid' => 79,
                    'modul' => "urunler",
                    'kategoriid' => 0,
                    'aciklama' => '',
                    'resim' => '',
                    'durum' =>  1,
                    'anasayfadurum' =>  1,
                    'tip' =>  1,
                ];
                
                $cats_insert = $database->table("kategorilers")->insert($newCats);
                $catID = $database->insertID();
                $ustKategoriId = $catID;
            }else{
                $ustKategoriId = $ustKategori[0]->id;
            }


            if(!empty($Stock["mshsite"])){

            }



                
           
            
            $newProducts = [
                'sira' => 0,
                'dil' => 'tr',
                'baslik' => $Stock["stock_title"],
                'seflink' => $this->seo_slug($Stock["stock_title"]),
                'modul' => 62,
                'ustkategori' => $ustKategoriId,
                'durum' =>  $durum
            ];
            $sorgula = $database->table("urunlers")->where("baslik", $Stock["stock_title"])->get()->getResultObject();
            if(empty($sorgula)){
                $insert = $database->table("urunlers")->insert($newProducts);
                $sonid = $database->insertID();
                if ($insert) {

                    // Bu stok için varyant gruplarını bul
                    $stockVariantGroups = [];
                    foreach ($variantGroupsData['variant_groups'] as $variantGroup) {
                        // Bu varyant grubunun bu kategoride kullanılıp kullanılmadığını kontrol et
                        foreach ($variantGroup['categories'] as $cat) {
                            if ($cat['category_id'] == $Stock['category_id']) {
                                $stockVariantGroups[] = $variantGroup;
                                break;
                            }
                        }
                    }
                
                foreach ($stockVariantGroups as $variant_group) {
                    // Varyant grubu başlığı varsa sorguluyoruz
                    $varyantSorgula = $database->table("kategorilers")
                        ->where("modul", "varyant")
                        ->where("baslik", $variant_group['variant_title'])
                        ->get()
                        ->getResultObject();
                    
                    if (empty($varyantSorgula)) {
                        // Varyant grubu yoksa ekliyoruz
                        $varyantEkle = [
                            'sira' => 10,
                            'dil' => 'tr',
                            'baslik' => $variant_group['variant_title'],
                            'seflink' => $this->seo_slug($variant_group['variant_title']),
                            'modulid' => 82,
                            'modul' => "varyant",
                            'kategoriid' => 0,
                            'aciklama' => '',
                            'resim' => '',
                            'durum' =>  1,
                            'anasayfadurum' =>  1,
                            'tip' =>  1,
                        ];
                
                        $varyan_kategori_insert = $database->table("kategorilers")->insert($varyantEkle);
                        $sorgula = $database->table("kategorilers")->where("baslik", $variant_group['variant_title'])->get()->getResultObject();
                        if(empty($sorgula)){
                            $varID = $database->insertID();
                            $varyantSorgulaID = $varID;
                        }else{
                            $varyantSorgulaID = $sorgula[0]->id;
                        }
                        
                    } else {
                        $varyantSorgulaID = $varyantSorgula[0]->id;
                    }
                
                    // Varyant eşleştirme sorgulaması
                    $varyantEslestirme = $database->table("varyant_eslestirmeler")
                        ->where("varyant_kategori_id", $varyantSorgulaID)
                        ->where("urun_kategori_id", $ustKategoriId)
                        ->get()
                        ->getResultObject();
                
                    if (empty($varyantEslestirme)) {
                        // Eşleşme yoksa ekliyoruz
                        $varyantEkle = [
                            'varyant_kategori_id' => $varyantSorgulaID,
                            'urun_kategori_id' => $ustKategoriId,
                        ];
                
                        $varyan_varyant_insert = $database->table("varyant_eslestirmeler")->insert($varyantEkle);
                        $varyantEslestirmeID = $database->insertID();
                    } else {
                        $varyantEslestirmeID = $varyantEslestirme[0]->eslestirme_id;
                    }
                
                    // Variant grubuna ait özellikleri al (UrunKontrolEt'ten gelen veriyi kullan)
                    $variant_properties = $variant_group['variant_properties'];
                
                    foreach ($variant_properties as $property) {
                        // Variant özelliklerini sorguluyoruz
                        $ProperySorgula = $database->table("varyants")
                            ->where("baslik", $property['variant_property_title'])
                            ->where("ustkategori", $varyantSorgulaID)
                            ->get()
                            ->getResultObject();
                
                        if (empty($ProperySorgula)) {
                            // Özellik yoksa ekliyoruz
                            $propertyEkle = [
                                'sira' => 10,
                                'dil' => 'tr',
                                'baslik' => $property['variant_property_title'],
                                'metin' => $property['variant_property_title'],
                                'kisaaciklama' => $property['variant_property_title'],
                                'seflink' => $this->seo_slug($property['variant_property_title']),
                                'modul' => 82,
                                'ustkategori' => $varyantSorgulaID,
                                'altkategori' => 0,
                                'durum' =>  1,
                                'anasayfadurum' =>  1,
                            ];
                
                            $varyan_property_insert = $database->table("varyants")->insert($propertyEkle);
                            $proPertyID = $database->insertID();
                        } else {
                            $proPertyID = $ProperySorgula[0]->id;
                        }
                    }
                }
    
                    // FTP sunucusu bağlantı bilgileri
                    $ftp_server = "ftp.mshdugme.tikodemo.com";  // FTP sunucusu adresi
                    $ftp_user = "app@mshdugme.tikodemo.com";    // FTP kullanıcı adı
                    $ftp_pass = "bXFnM5a4qPVjUu8fxtYK";        // FTP şifresi
                
                    // Galeri öğelerini al (ana stok ID'sini kullan)
                    $gallery_items = $this->modelStockGallery->where('stock_id', $Stock["stock_id"])->where("default", 'false')->orderBy('order', 'ASC')->findAll();
                
                
                    if (!empty($gallery_items)) {
                        // FTP bağlantısını kur
                        $ftp_conn = ftp_connect($ftp_server);
                        if (!$ftp_conn) {
                          echo json_encode(['icon' => 'info', 'message' => 'FTP sunucusuna bağlanılamadı.']);
    
                        }
                        
                        $login = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
                        if (!$login) {
                            ftp_close($ftp_conn);
                            echo json_encode(['icon' => 'info', 'message' => 'FTP sunucusuna giriş başarısız.']);
                        }
                
                        if (!ftp_pasv($ftp_conn, true)) {
                            ftp_close($ftp_conn);
                           // die("Pasif mod ayarlanamadı.");
                        }
                
                        // Her bir galeri öğesini işleme
                        foreach ($gallery_items as $item) {
                            $local_file = FCPATH . $item["image_path"]; // Yerel dosya yolu
                
                            // Dosyanın yerel sunucuda bulunup bulunmadığını kontrol edin
                            if (!file_exists($local_file)) {
                                echo json_encode(['icon' => 'info', 'message' => 'Dosya bulunamadı: ' . $local_file . '<br>']);
    
                               // echo "Dosya bulunamadı: " . $local_file . "<br>";
                                continue; // Eğer dosya yoksa bu öğeyi atla
                            }
                
                            // Uzak sunucudaki dosya adı
                            $remote_file = basename($local_file);
                
                            // Dosyayı FTP'ye yükle
                            if (ftp_put($ftp_conn, $remote_file, $local_file, FTP_BINARY)) {
                                //echo "Dosya başarılı bir şekilde yüklendi: " . $remote_file . "<br>";
                
                                // Yüklenen dosya veritabanına kaydediliyor
                                $newGaleri = [
                                    'icerik' => $sonid,
                                    'sira' => $item["order"],
                                    'etiket' => $Stock["stock_title"],
                                    'resim' => $remote_file, // Yüklenen resmin adı
                                    'modul' => 62,
                                ];
                                
                                $galeri = $database->table("urunler_galeris")->insert($newGaleri);
                
                            } 
                        }
                
                        // FTP bağlantısını kapat
                        ftp_close($ftp_conn);
                    }
                
                    // Ana görseli yükleme ve veritabanına kaydetme
                    $local_file = FCPATH . $Stock["default_image"];
                    if (file_exists($local_file)) {
                       

// Ana görseli yükleme ve veritabanına kaydetme
$local_file = FCPATH . $Stock["default_image"];

// 1) Dosya Yerelde Var Mı?
if (!file_exists($local_file)) {
    echo json_encode(['icon' => 'info', 'message' => 'Dosya bulunamadı: ' . $local_file]);
    return; // veya continue; senin yapına göre
}

// 2) FTP Sunucusuna Bağlanma
$ftp_conn = ftp_connect($ftp_server);
if (!$ftp_conn) {
    echo json_encode(['icon' => 'info', 'message' => 'FTP sunucusuna bağlanılamadı.']);
    return;
}

// 3) Kullanıcı Girişi
$login = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
if (!$login) {
    ftp_close($ftp_conn);
    echo json_encode(['icon' => 'info', 'message' => 'FTP sunucusuna giriş başarısız.']);
    return;
}

// 4) Pasif Moda Geç
ftp_pasv($ftp_conn, true);

// 5) “Sadece Warning’leri” Geçici Bastırma
// Mevcut error_reporting değerini yedekle
$oldErrorLevel = error_reporting();
// Warning ve Notice’ları devre dışı bırak (E_WARNING | E_NOTICE)
error_reporting($oldErrorLevel & ~E_WARNING & ~E_NOTICE);

// 6) Dosyayı Yükle
$remote_file   = basename($local_file);
// ftp_put’in Warning vermesi yerine, kendisi false dönerse bileceğiz ki hata var
$uploadResult  = ftp_put($ftp_conn, $remote_file, $local_file, FTP_BINARY);

// 7) Eski error_reporting geri getir
error_reporting($oldErrorLevel);

// 8) Yükleme Sonucu Kontrolü
if (!$uploadResult) {
    // Burada gerçekten hata oldu (sunucuya bağlanamadı, yetki yok, disk dolu vb.)
    //echo json_encode(['icon' => 'info', 'message' => 'FTP yüklemesi başarısız oldu: '.$remote_file]);
} else {
    // Yükleme başarılı
   

    // Veritabanını güncelle
    $UrunGuncelle = $database->table("urunlers")
        ->set("kapakresmi", $remote_file)
        ->where("id", $sonid)
        ->update();
}

// 9) Bağlantıyı Kapat
ftp_close($ftp_conn);
                    }
                
                    $count++;
    
                    // Ana stok kaydını güncelle
                    $UrunGuncelle = $this->modelStock->set("mshsite", $sonid)->where("stock_id", $Stock["stock_id"])->update();
    
                }
            }
           

           
        }



        if($count > 0){
            echo json_encode(['icon' => 'success', 'message' => 'Toplam <b>'.$count.' </b> Adet Ürün Msh Düğme Sitesine Aktarıldı.']);
        }else{
            echo json_encode(['icon' => 'info', 'message' => 'Msh Düğme sitesine aktarılacak ürün yoktur.']);

        }

        

    }



    public function msh_send_products(){

        $database = $this->siteConnect();

        $ModelStock = $this->modelStock->where("parent_id","<", 1)->findAll();



    
        $count = 0;
        foreach($ModelStock as $Stock){

            if($Stock["status"] == "active"){
                $durum = 1;
            }else{
                $durum = 0;
            }

            $catBul = $this->modelCategory->where("category_id", $Stock["category_id"])->first();
            $category = $catBul;

            $cleanTitle = $catBul['category_title'];  
            $formattedTitle = $this->formatTitle($cleanTitle); 

            $ustKategori = $database->table("kategorilers")->where("baslik", $catBul['category_title'])->get()->getResultObject();
            
            if(empty($ustKategori)){

                $newCats = [
                    'sira' => 10,
                    'dil' => 'tr',
                    'baslik' => $catBul['category_title'],
                    'seflink' => $this->seo_slug($catBul['category_title']),
                    'modulid' => 79,
                    'modul' => "urunler",
                    'kategoriid' => 0,
                    'aciklama' => '',
                    'resim' => '',
                    'durum' =>  1,
                    'anasayfadurum' =>  1,
                    'tip' =>  1,
                ];
                
                $cats_insert = $database->table("kategorilers")->insert($newCats);
                $catID = $database->insertID();
                $ustKategoriId = $catID;
            }else{
                $ustKategoriId = $ustKategori[0]->id;
            }


            if(!empty($Stock["mshsite"])){

            }



                
           
            
            $newProducts = [
                'sira' => 0,
                'dil' => 'tr',
                'baslik' => $Stock["stock_title"],
                'seflink' => $this->seo_slug($Stock["stock_title"]),
                'modul' => 62,
                'ustkategori' => $ustKategoriId,
                'durum' =>  $durum
            ];
            $sorgula = $database->table("urunlers")->where("baslik", $Stock["stock_title"])->get()->getResultObject();
            if(empty($sorgula)){
                $insert = $database->table("urunlers")->insert($newProducts);
                $sonid = $database->insertID();
                if ($insert) {


                    $variant_groups = $this->modelVariantGroup
                    ->join('variant_group_category', 'variant_group_category.variant_group_id = variant_group.variant_group_id')
                    ->where('variant_group_category.category_id', $category['category_id'])
                    ->where('variant_group.deleted_at', null)
                    ->select('variant_group.*')
                    ->orderBy('variant_group.order')
                    ->findAll();
                
                foreach ($variant_groups as $variant_group) {
                    // Varyant grubu başlığı varsa sorguluyoruz
                    $varyantSorgula = $database->table("kategorilers")
                        ->where("modul", "varyant")
                        ->where("baslik", $variant_group['variant_title'])
                        ->get()
                        ->getResultObject();
                    
                    if (empty($varyantSorgula)) {
                        // Varyant grubu yoksa ekliyoruz
                        $varyantEkle = [
                            'sira' => 10,
                            'dil' => 'tr',
                            'baslik' => $variant_group['variant_title'],
                            'seflink' => $this->seo_slug($variant_group['variant_title']),
                            'modulid' => 82,
                            'modul' => "varyant",
                            'kategoriid' => 0,
                            'aciklama' => '',
                            'resim' => '',
                            'durum' =>  1,
                            'anasayfadurum' =>  1,
                            'tip' =>  1,
                        ];
                
                        $varyan_kategori_insert = $database->table("kategorilers")->insert($varyantEkle);
                        $sorgula = $database->table("kategorilers")->where("baslik", $variant_group['variant_title'])->get()->getResultObject();
                        if(empty($sorgula)){
                            $varID = $database->insertID();
                            $varyantSorgulaID = $varID;
                        }else{
                            $varyantSorgulaID = $sorgula[0]->id;
                        }
                        
                    } else {
                        $varyantSorgulaID = $varyantSorgula[0]->id;
                    }
                
                    // Varyant eşleştirme sorgulaması
                    $varyantEslestirme = $database->table("varyant_eslestirmeler")
                        ->where("varyant_kategori_id", $varyantSorgulaID)
                        ->where("urun_kategori_id", $ustKategoriId)
                        ->get()
                        ->getResultObject();
                
                    if (empty($varyantEslestirme)) {
                        // Eşleşme yoksa ekliyoruz
                        $varyantEkle = [
                            'varyant_kategori_id' => $varyantSorgulaID,
                            'urun_kategori_id' => $ustKategoriId,
                        ];
                
                        $varyan_varyant_insert = $database->table("varyant_eslestirmeler")->insert($varyantEkle);
                        $varyantEslestirmeID = $database->insertID();
                    } else {
                        $varyantEslestirmeID = $varyantEslestirme[0]->eslestirme_id;
                    }
                
                    // Variant grubuna ait özellikleri ekliyoruz
                    $variant_properties = $this->modelVariantProperty
                        ->where('variant_property.variant_group_id', $variant_group['variant_group_id'])
                        ->where('variant_property.deleted_at', null)
                        ->select('variant_property.*')
                        ->orderBy('variant_property.order')
                        ->findAll();
                
                    foreach ($variant_properties as $property) {
                        // Variant özelliklerini sorguluyoruz
                        $ProperySorgula = $database->table("varyants")
                            ->where("baslik", $property['variant_property_title'])
                            ->where("ustkategori", $varyantSorgulaID)
                            ->get()
                            ->getResultObject();
                
                        if (empty($ProperySorgula)) {
                            // Özellik yoksa ekliyoruz
                            $propertyEkle = [
                                'sira' => 10,
                                'dil' => 'tr',
                                'baslik' => $property['variant_property_title'],
                                'metin' => $property['variant_property_title'],
                                'kisaaciklama' => $property['variant_property_title'],
                                'seflink' => $this->seo_slug($property['variant_property_title']),
                                'modul' => 82,
                                'ustkategori' => $varyantSorgulaID,
                                'altkategori' => 0,
                                'durum' =>  1,
                                'anasayfadurum' =>  1,
                            ];
                
                            $varyan_property_insert = $database->table("varyants")->insert($propertyEkle);
                            $proPertyID = $database->insertID();
                        } else {
                            $proPertyID = $ProperySorgula[0]->id;
                        }
                    }
                }
    
                    // FTP sunucusu bağlantı bilgileri
                    $ftp_server = "ftp.mshdugme.tikodemo.com";  // FTP sunucusu adresi
                    $ftp_user = "app@mshdugme.tikodemo.com";    // FTP kullanıcı adı
                    $ftp_pass = "bXFnM5a4qPVjUu8fxtYK";        // FTP şifresi
                
                    // Galeri öğelerini al
                    $gallery_items = $this->modelStockGallery->where('stock_id', $Stock["stock_id"])->where("default", 'false')->orderBy('order', 'ASC')->findAll();
                
                
                    if (!empty($gallery_items)) {
                        // FTP bağlantısını kur
                        $ftp_conn = ftp_connect($ftp_server);
                        if (!$ftp_conn) {
                          echo json_encode(['icon' => 'info', 'message' => 'FTP sunucusuna bağlanılamadı.']);
    
                        }
                        
                        $login = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
                        if (!$login) {
                            ftp_close($ftp_conn);
                            echo json_encode(['icon' => 'info', 'message' => 'FTP sunucusuna giriş başarısız.']);
                        }
                
                        if (!ftp_pasv($ftp_conn, true)) {
                            ftp_close($ftp_conn);
                           // die("Pasif mod ayarlanamadı.");
                        }
                
                        // Her bir galeri öğesini işleme
                        foreach ($gallery_items as $item) {
                            $local_file = FCPATH . $item["image_path"]; // Yerel dosya yolu
                
                            // Dosyanın yerel sunucuda bulunup bulunmadığını kontrol edin
                            if (!file_exists($local_file)) {
                                echo json_encode(['icon' => 'info', 'message' => 'Dosya bulunamadı: ' . $local_file . '<br>']);
    
                               // echo "Dosya bulunamadı: " . $local_file . "<br>";
                                continue; // Eğer dosya yoksa bu öğeyi atla
                            }
                
                            // Uzak sunucudaki dosya adı
                            $remote_file = basename($local_file);
                
                            // Dosyayı FTP'ye yükle
                            if (ftp_put($ftp_conn, $remote_file, $local_file, FTP_BINARY)) {
                                //echo "Dosya başarılı bir şekilde yüklendi: " . $remote_file . "<br>";
                
                                // Yüklenen dosya veritabanına kaydediliyor
                                $newGaleri = [
                                    'icerik' => $sonid,
                                    'sira' => $item["order"],
                                    'etiket' => $Stock["stock_title"],
                                    'resim' => $remote_file, // Yüklenen resmin adı
                                    'modul' => 62,
                                ];
                                
                                $galeri = $database->table("urunler_galeris")->insert($newGaleri);
                
                            } 
                        }
                
                        // FTP bağlantısını kapat
                        ftp_close($ftp_conn);
                    }
                
                    // Ana görseli yükleme ve veritabanına kaydetme
                    $local_file = FCPATH . $Stock["default_image"];
                    if (file_exists($local_file)) {
                       

// Ana görseli yükleme ve veritabanına kaydetme
$local_file = FCPATH . $Stock["default_image"];

// 1) Dosya Yerelde Var Mı?
if (!file_exists($local_file)) {
    echo json_encode(['icon' => 'info', 'message' => 'Dosya bulunamadı: ' . $local_file]);
    return; // veya continue; senin yapına göre
}

// 2) FTP Sunucusuna Bağlanma
$ftp_conn = ftp_connect($ftp_server);
if (!$ftp_conn) {
    echo json_encode(['icon' => 'info', 'message' => 'FTP sunucusuna bağlanılamadı.']);
    return;
}

// 3) Kullanıcı Girişi
$login = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
if (!$login) {
    ftp_close($ftp_conn);
    echo json_encode(['icon' => 'info', 'message' => 'FTP sunucusuna giriş başarısız.']);
    return;
}

// 4) Pasif Moda Geç
ftp_pasv($ftp_conn, true);

// 5) “Sadece Warning’leri” Geçici Bastırma
// Mevcut error_reporting değerini yedekle
$oldErrorLevel = error_reporting();
// Warning ve Notice’ları devre dışı bırak (E_WARNING | E_NOTICE)
error_reporting($oldErrorLevel & ~E_WARNING & ~E_NOTICE);

// 6) Dosyayı Yükle
$remote_file   = basename($local_file);
// ftp_put’in Warning vermesi yerine, kendisi false dönerse bileceğiz ki hata var
$uploadResult  = ftp_put($ftp_conn, $remote_file, $local_file, FTP_BINARY);

// 7) Eski error_reporting geri getir
error_reporting($oldErrorLevel);

// 8) Yükleme Sonucu Kontrolü
if (!$uploadResult) {
    // Burada gerçekten hata oldu (sunucuya bağlanamadı, yetki yok, disk dolu vb.)
    //echo json_encode(['icon' => 'info', 'message' => 'FTP yüklemesi başarısız oldu: '.$remote_file]);
} else {
    // Yükleme başarılı
   

    // Veritabanını güncelle
    $UrunGuncelle = $database->table("urunlers")
        ->set("kapakresmi", $remote_file)
        ->where("id", $sonid)
        ->update();
}

// 9) Bağlantıyı Kapat
ftp_close($ftp_conn);
                    }
                
                    $count++;
    
                    $UrunGuncelle = $this->modelStock->set("mshsite", $sonid)->where("stock_id", $Stock["stock_id"])->update();
    
                }
            }
           

           
        }



        if($count > 0){
            echo json_encode(['icon' => 'success', 'message' => 'Toplam <b>'.$count.' </b> Adet Ürün Msh Düğme Sitesine Aktarıldı.']);
        }else{
            echo json_encode(['icon' => 'info', 'message' => 'Msh Düğme sitesine aktarılacak ürün yoktur.']);

        }

        

    }

 

   





}
