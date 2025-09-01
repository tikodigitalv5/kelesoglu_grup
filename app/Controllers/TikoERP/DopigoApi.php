<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;

/**
 * @property IncomingRequest $request
 */

 ini_set('max_execution_time', "-1");


class DopigoApi extends BaseController
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

    private $apkey;
    private $secret;
    private $token;

    private $modelDopigo;

    private $modelStockRecipe;
    private $modelRecipeItem;

    private $modelDopigoEslestir;

    private $db;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);
        $this->db = $db_connection;
        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
        $this->modelFinancialMovement = model($TikoERPModelPath . '\FinancialMovementModel', true, $db_connection);
        $this->modelMoneyUnit = model($TikoERPModelPath . '\MoneyUnitModel', true, $db_connection);
        $this->modelAddress = model($TikoERPModelPath . '\AddressModel', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath . '\StockModel', true, $db_connection);
        $this->modelOrder = model($TikoERPModelPath . '\OrderModel', true, $db_connection);
        $this->modelOrderRow = model($TikoERPModelPath . '\OrderRowModel', true, $db_connection);
        $this->modelNote = model($TikoERPModelPath . '\NoteModel', true, $db_connection);
        $this->modelStockVariantGroup = model($TikoERPModelPath . '\StockVariantGroupModel', true, $db_connection);
        $this->modelDopigo = model($TikoERPModelPath . '\StockDopigoModel', true, $db_connection);
        $this->modelStockRecipe = model($TikoERPModelPath . '\StockRecipeModel', true, $db_connection);
        $this->modelRecipeItem = model($TikoERPModelPath . '\RecipeItemModel', true, $db_connection);
        $this->modelDopigoEslestir = model($TikoERPModelPath . '\DopigoEslestirModel', true, $db_connection);
        
        

        $this->logClass = new Log();

        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');

        $this->apkey = 'online@famsotomotiv.com';
        $this->secret = 'Famsotoaksesuar1.';
        $this->token = "";
    }


    //  05354162316

    /**
     * Obtain an authentication token from the Dopigo API.
     */
    public function getAuthToken()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://panel.dopigo.com/users/get_auth_token/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'username' => $this->apkey,
                'password' => $this->secret
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            $this->logClass->error('cURL error: ' . $error_msg);
        }

        curl_close($curl);

        $responseData = json_decode($response, true);

        // Check if the 'token' key exists in the response
        if (isset($responseData['token'])) {
            return  $responseData['token'];
        } else {
           return 'APİ HATA';
        }   
     }



     public function DopigoOrder($start_date, $end_date, $url = null)
     {
         // Tarihler belirlenmemişse mevcut günü ve 7 gün sonrasını al
         if (!$start_date || !$end_date) {
             $currentDate = new \DateTime();
             $start_date = $currentDate->format('Y-m-d');
             $end_date = $currentDate->format('Y-m-d');
         }
     
         $token = $this->getAuthToken();
     
         $url = $url ?? 'https://panel.dopigo.com/api/v1/orders?service_date_after=' . $start_date . '&service_date_before=' . $end_date;
     
         $curl = curl_init();
     
         curl_setopt_array($curl, array(
             CURLOPT_URL => $url,
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_ENCODING => '',
             CURLOPT_MAXREDIRS => 10,
             CURLOPT_TIMEOUT => 0,
             CURLOPT_FOLLOWLOCATION => true,
             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
             CURLOPT_CUSTOMREQUEST => 'GET',
             CURLOPT_HTTPHEADER => array(
                 'Authorization: Token ' . $token
             ),
         ));
     
         $response = curl_exec($curl);
     
         curl_close($curl);
         $responseData = json_decode($response, true);
     
         return $responseData;
     }

     public function DopigoKargo($id)
     {
         // Kargo firmaları verisini bir dizi olarak tanımla
         $cargoCompanies = [
            ["id" => 105, "name" => "Carrtell"],
            ["id" => 2, "name" => "Aras"],
            ["id" => 1, "name" => "Yurtiçi"],
            ["id" => 116, "name" => "Kargokar"],
            ["id" => 5, "name" => "Sürat"],
            ["id" => 58, "name" => "Elden Teslim"],
            ["id" => 62, "name" => "Jetizz"],
            ["id" => 3, "name" => "MNG Kargo"],
            ["id" => 95, "name" => "Murathan JET"],
            ["id" => 101, "name" => "PackUpp"],
            ["id" => 107, "name" => "Navlungo"],
            ["id" => 111, "name" => "Kargoray"],
            ["id" => 96, "name" => "Asil Kargo"],
            ["id" => 11, "name" => "Paket Taxi"],
            ["id" => 52, "name" => "PTS"],
            ["id" => 60, "name" => "SBY Express"],
            ["id" => 59, "name" => "SkyNET"],
            ["id" => 8, "name" => "Ulak Kurye"],
            ["id" => 99, "name" => "Gittigidiyor Express"],
            ["id" => 9, "name" => "Traffic Kurye"],
            ["id" => 50, "name" => "Teknosa"],
            ["id" => 56, "name" => "We World Express"],
            ["id" => 102, "name" => "Ay Kargo"],
            ["id" => 51, "name" => "Borusan Lojistik"],
            ["id" => 104, "name" => "İstanbul Kurye"],
            ["id" => 109, "name" => "Banabikurye"],
            ["id" => 106, "name" => "Netkargo"],
            ["id" => 108, "name" => "Kargoist"],
            ["id" => 110, "name" => "KARGOMsende"],
            ["id" => 112, "name" => "Vestel Regal Türkiye Servisi"],
            ["id" => 113, "name" => "Scotty"],
            ["id" => 114, "name" => "Oplog"],
            ["id" => 115, "name" => "Kredilikargo_glvr"],
            ["id" => 97, "name" => "hepsiJet"],
            ["id" => 10, "name" => "Hepsijet"],
            ["id" => 14, "name" => "ADEL"],
            ["id" => 54, "name" => "B2C Direct"],
            ["id" => 94, "name" => "hepsiJET"],
            ["id" => 100, "name" => "hepsiJET XL"],
            ["id" => 4, "name" => "PTT Kargo"],
            ["id" => 16, "name" => "PTT Kargo Marketplace"],
            ["id" => 49, "name" => "PTT Global"],
            ["id" => 6, "name" => "UPS"],
            ["id" => 64, "name" => "UPSGLOBAL"],
            ["id" => 13, "name" => "Kolay Gelsin"],
            ["id" => 55, "name" => "AGT"],
            ["id" => 61, "name" => "ByExpress"],
            ["id" => 57, "name" => "CDEK"],
            ["id" => 7, "name" => "Horoz Lojistik"],
            ["id" => 12, "name" => "Ceva Lojistik"],
            ["id" => 103, "name" => "DHL"],
            ["id" => 53, "name" => "Sendeo"],
            ["id" => 15, "name" => "Trendyol Express"],
            ["id" => 65, "name" => "Bir Günde Kargo"],
            
        ];
        
     
         // Girilen id'ye göre kargo firmasını bul
         foreach ($cargoCompanies as $company) {
             if ($company['id'] == $id) {
                 return $company['name'];
             }
         }
     
         // Eğer id bulunamazsa hata mesajı döndür
         return "Kargo firması bulunamadı.";
     }
     
    

     public function DopigoOrderFromNextUrl($nextUrl) {
        $orderResponse = $this->DopigoOrder(null, null, $nextUrl);
        return $orderResponse;
    }

    public function DopigoProduct($id = 0)
    {
        // Tarihler belirlenmemişse mevcut günü ve 7 gün sonrasını al

    
        $token = $this->getAuthToken();
    
        $url = 'https://panel.dopigo.com/api/v1/products/'  . $id;
    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Token ' . $token
            ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
        $responseData = json_decode($response, true);
    
        return $responseData;
    }



 


    public function DopigoProductFromNextUrl($nextUrl) {
        $orderResponse = $this->DopigoProduct($nextUrl);
        return $orderResponse;
    }


    public function DopigoUrunler()
    {

   $urunler =   $this->modelStock->where("dopigo !=", '')->findAll();
     foreach($urunler as $key):         // İlk isteği gönderelim
         $orderResponse = $this->DopigoProduct($key["dopigo"]);
     endforeach;
 
     
 
         // Eğer bir sonraki sayfa varsa, sırayla istekleri gönderelim ve sonuçları toplayalım
       
 
 
      
     
         echo '<pre>';
         print_r($orderResponse);
         echo '</pre>';
 
         exit; 
    }


    public function dopigo_eslesenler()
    {


        
        
        $urunler =   $this->modelStock->where("dopigo !=", '')->findAll();

        foreach($urunler as $urun)
        {


            $data = [
                'dopigo_id'    => $urun["dopigo"],
                'stock_id'     => $urun["stock_id"],
                'stock_title'  => $urun["stock_title"],
                'dopigo_title' => $urun["stock_title"],
                'stock_code'   => $urun["stock_code"],
                'dopigo_code'  => $urun["stock_code"],
                'silindi'      => false,
            ];

            $EslesenEkle = $this->modelDopigoEslestir->insert($data);



        }
 

       

    }


     public function DopigoSiparis()
     {
      
        // İlk isteği gönderelim
    //  $orderResponse = $this->DopigoOrder("2024-08-05", "2024-08-05");
    //$orderResponse = $this->DopigoOrder("2024-08-06", "2024-08-06");
       // $orderResponse = $this->DopigoOrder("2024-08-15", "2024-08-15");
        //$orderResponse = $this->DopigoOrder("2024-08-17", "2024-08-17");
      //  $orderResponse = $this->DopigoOrder("2024-08-20", "2024-08-20");
   
        $pazar_yeri = $this->request->getPost("pazar_yeri") ?? 1;

        if($pazar_yeri == 1){
            $platform = "Tüm Platformlar";
        }else if($pazar_yeri == 'ciceksepeti'){
            $platform = "Çiçek Sepeti";
        }else if($pazar_yeri == 'hepsiburada'){
            $platform = "Hepsiburada";
        }else if($pazar_yeri == 'n11'){
            $platform = "N11";
        }else if($pazar_yeri == 'trendyol'){
            $platform = "Trendyol";
        }
    

        $cronData = [
            'start_date' => $this->request->getPost("start_date"),
            'end_date' => $this->request->getPost("end_date"),
            'platform' => $platform,
            'cron_date' => date('Y-m-d H:i:s'),
            'status' => 'running'
        ];

        $this->db->table('dopigo_cron')->insert($cronData);
        $cronId = $this->db->insertID();

        // Mevcut sipariş çekme işlemi
        //$orderResponse = $this->DopigoOrder("2025-05-13", "2025-05-13");
        $orderResponse = $this->DopigoOrder($this->request->getPost("start_date"), $this->request->getPost("end_date"));
         
		 $orders = $orderResponse['results'];



        // Raw data'yı kaydet
        $this->db->table('dopigo_cron')->where('id', $cronId)->update([
            'raw_data' => json_encode($orderResponse)
        ]);


        // Eğer bir sonraki sayfa varsa, sırayla istekleri gönderelim ve sonuçları toplayalım
        while ($orderResponse['next']) {
            $orderResponse = $this->DopigoOrderFromNextUrl($orderResponse['next']);
            $orders = array_merge($orders, $orderResponse['results']);
        }



        $totalOrders = count($orders);
        $totalPlatforms = count(array_unique(array_column($orders, 'service_name')));
        $successfulOrders = 0;
        $failedOrders = 0;
        $pazaryeriCount = 0;
        $PazarYeriSuccessfulOrders = 0;



      
        foreach($orders as $key => $order)
        {

            try {
            
            $successfulOrders++;
        

            if(!empty($pazar_yeri) && $pazar_yeri != 1){

            
                if($order["service_name"] == $pazar_yeri){

                    $pazaryeriCount++;
                    $PazarYeriSuccessfulOrders++;

                    $dopigo_siparis_id = $order["id"];
        
                    $parts = explode('-', $order["service_value"]);
                    if($order["service_name"] == "epttavm"){
                        $order["id"] = $parts[1];
                    }else{
                         $order["id"] = $parts[0];
                    }
                              
        
        
                    $kargosu = "";
                    $kargo_kodu = "";
                    $service_name  = $order["service_name"];
                    $siparis_tarihi = $order["service_created"];

                 
                    $banka_komisyon = $order["bank_charge"] + $order["bank_charge_tax"];
                    $order['total'] = $order['total'] - $banka_komisyon;
        
                    $musteri = $order["customer"];
                    $account_type = $musteri["account_type"];
                    $full_name = $musteri["full_name"];
                    $contact_number = $musteri["contact_number"];
        
                    // MÜŞTERİ ADRES BAŞLANGIÇ ///
                    $adres = $musteri["address"];
        
                    $full_address = $adres["full_address"];
        
                    $country = $adres["country"];
                    $city = $adres["city"];
                    $district = $adres["district"];
                    $zip_code = $adres["zip_code"];
                    // MÜŞTERİ ADRES BİTİŞ //
        
        
                    $email = $musteri["email"];
                    $citizen_id = $musteri["citizen_id"];
                    $company_name = $musteri["company_name"];
                    $tax_office = $musteri["tax_office"];
                    $tax_id = $musteri["tax_id"];
        
        
                    $total = $order["total"];
        
                    $order_rows = [];


                    $banka_komisyon = 0;

                    
                    


        
        
               
        
                    foreach ($order["items"] as $row) {
                        // Add each row to the order_rows array
                        $order_rows[] = [
                            "sku" => $row["sku"],
                            "attributes" => $row["attributes"],
                            "stock_title" => $row["name"],
                            "urun_adi" => $row["name"],
                            "adet" => $row["amount"],
                            'urun_id' => $row["service_product_id"],
                            "price" => $row["price"],
                            "vergi" => $row["tax_ratio"],
                            "kargo" => $row["shipment_provider"],
                            "kargo_kodu" => $row["shipment_campaign_code"],
                            "linked_product_id" => isset($row["linked_product"]["id"]) ? $row["linked_product"]["id"] : null,
                            "linked_product_sku" => isset($row["linked_product"]["sku"]) ? $row["linked_product"]["sku"] : null,
                            "linked_product_foreign_sku" => isset($row["linked_product"]["foreign_sku"]) ? $row["linked_product"]["foreign_sku"] : null,
                            "linked_product_barcode" => isset($row["linked_product"]["barcode"]) ? $row["linked_product"]["barcode"] : null,
                        ];
                    }
        
                          
                    foreach ($order_rows as $order_row) {
                        $kargosu = $order_row["kargo"];
                        $kargo_kodu = $order_row["kargo_kodu"];
                       
                    }   
        


                   


              
        
        
        
        
        
                    $new_data_form = [];
                    $data_order_amounts = [];
                    $b2bText = "";
                     // *********** SİPARİŞ EKLEME BAŞLANGIÇ **************** //
        
        
                    
        
        
                        $Sorgula = $this->modelOrder->where("order_numara", $order["service_value"])->first();
        
                        if(!isset($Sorgula))
                        {   
        
                            
        
                            $transaction_prefix = "DPG" . $order["id"];
        
        
        
                            $sorgum = $this->modelOrder->where("order_numara", $order["service_value"])->first();
        
        
                           if(!$sorgum){
        
                            $siparis = $order;
                            
                      
        
                            $CariSorgula = $this->modelCari->orWhere("cari_email", $email)->where("invoice_title", $full_name)->first();
                        
                        
                            
                            $cari_id = 0;
                            if(!$CariSorgula){
        
                                $is_export_customer = 0;
                                if(!empty($siparis['citizen_id'])){
                                    $tcvkn = $siparis['citizen_id'];
                                }else{
                                    $tcvkn = 1111111111;
                                }
                                $new_data_form['invoice_title'] = $full_name;
                                $fullName = $full_name ?? '';
                                $nameParts = explode(' ', $fullName);
                    
                                if (count($nameParts) < 2) {
                                    // Handle cases where full name does not contain a space
                                    $nameParts[] = '';
                                }
                    
                                $new_data_form['surname'] = array_pop($nameParts);
                                $new_data_form['name'] = implode(' ', $nameParts);
                                
                                $new_data_form['obligation'] = "e-archive";
                                $new_data_form['company_type'] = "person";
                                $new_data_form['address_city_name'] = "";
                                $new_data_form['address_city'] = $city;
                                $new_data_form['address_district'] = $district;
                                $new_data_form['zip_code'] = $zip_code;
                                $new_data_form['address'] =$full_address;
        
                                $phoneNumber = $contact_number;
        
                                if($phoneNumber == "" || empty($phoneNumber))
                                {
                                    $phoneNumber = "+90 000 000 00 00";
                                }
        
        
                                if (substr($phoneNumber, 0, 1) === '0') {
                                    $phoneNumber = substr($phoneNumber, 1);
                                }
                        
                                // Numaranın 10 haneli olup olmadığını kontrol et
                                if (strlen($phoneNumber) < 10) {
                                    $phoneNumber = str_pad($phoneNumber, 10, "0", STR_PAD_LEFT);
                                }
                        
                                
                                $create_cari_code = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
                                if(!is_numeric($citizen_id))
                                {
                                    $identification_number  = 1111111111;
                                }else{
                                    $identification_number = $citizen_id;
                                }
                                $cari_data = [
                                    'user_id' => session()->get('user_id'),
                                    'money_unit_id' => 3,
                                    'cari_code' => $create_cari_code,
                                    'identification_number' => $identification_number,
                                    'tax_administration' => $tax_office != '' ? $tax_office : null,
                                    'invoice_title' => $new_data_form['invoice_title'],
                                    'name' => $new_data_form['name'],
                                    'surname' => $new_data_form['surname'],
                                    'obligation' => $new_data_form['obligation'] != '' ? $new_data_form['obligation'] : null,
                                    'company_type' => $new_data_form['company_type'] != '' ? $new_data_form['company_type'] : null ,
                                    'cari_phone' => $phoneNumber,
                                    'cari_email' => $email != '' ? $email : null,
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
                                    'address_email' => $email != '' ? $email : null,
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
        
        
        
        
        
        
                           
                    
                
        
                           
        
                            $musteriMail = $email;
                            $is_customer = 1;
                            $is_supplier = 0;
                            $is_export_customer  = 0;
        
        
        
                            $siparisTarih = $siparis_tarihi;
        
                            $dateTime = new \DateTime($siparisTarih);
        
                            // Yeni tarih ve saat formatı
                            $new_data_form['order_date'] = $dateTime->format('Y-m-d');
                            $new_data_form['order_time'] = $dateTime->format('H:i');
        
                            $data_order_amounts['amount_to_be_paid'] = $siparis["total"];
               
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
        
        
                                $is_deadline  = 0;
                                $d_date = Date("Y-m-d");
        
                                if($order["status"] == "shipped"){
                                    $status_degeri = "kargolandi";
                                }else if($order["status"] == "pending"){
                                    $status_degeri = "pending";
                                }else if($order["status"] == "waiting_shipment"){
                                    $status_degeri = "kargo_bekliyor";
                                }else if($order["status"] == "cancelled"){
                                    $status_degeri = "failed";
                                }
                                else if($order["status"] == "undefined"){
                                    $status_degeri = "failed";
                                }
                                else {
                                    $status_degeri = "new";
                                }
        
                                
        
        
                               
                            
        
        
                                $b2bText.= "<div> Sipariş: <b style='    text-transform: uppercase;'>Dopigo</b>  Platform:  <b style='    text-transform: uppercase;' ><span style='font-weight: bold; '>  ".$service_name."</span></b> <br> Sipariş Numarası :  <b><span style='font-weight: bold;'>".$order["id"]." </span></b>  <br>";
                                $b2bText.="Sipariş Tarihi : <b>" . $order_date . " " . $order_time . "</b></div>"; 
        
                  
                   
                
                                $cari_id = $CariSorgula['cari_id'];
                            
                
                                $order_note_id = 0;
                                $order_note = $order["notes"];
        
                                if(empty($order['discount']))
                                {
                                    $order['discount'] = 0;
                                }   
        
        
        
                            
                              $toplam_tutarim = ($order['total'] - $banka_komisyon);


                  
        
                         
                            
                                $insert_order_data = [
                                    'user_id' => session()->get('user_id'),
                                    'money_unit_id' => 3,
                                    'order_direction' => 'incoming',
                                    'order_no' => $transaction_prefix,
                                    'order_numara' => $order["service_value"],
                                    'order_date' => $siparis_tarihi,
                                    'b2b' => $b2bText,
                                    'dopigo' => $order["id"],
                                    'dopigo_siparis_id' => $dopigo_siparis_id,
                                    'cron_id' => $cronId,
                                    'order_note_id' => 0,
                                    'order_note' => $order_note,
                
                                    'is_deadline' => $is_deadline,
                                    'deadline_date' => $d_date,
                
                                    'currency_amount' => 0,
                
                                    'stock_total' => $toplam_tutarim,
                                    'stock_total_try' => $toplam_tutarim,
                
                                    'discount_total' => $order['discount'],
                                    'discount_total_try' => $order['discount'],
                
                                    'tax_rate_1_amount' => convert_number_for_sql(0),
                                    'tax_rate_1_amount_try' => convert_number_for_sql(0),
                                    'tax_rate_10_amount' => convert_number_for_sql(0),
                                    'tax_rate_10_amount_try' => convert_number_for_sql(0),
                                    'tax_rate_20_amount' => convert_number_for_sql(0),
                                    'tax_rate_20_amount_try' => convert_number_for_sql(0),
                
                                    'sub_total' => $toplam_tutarim,
                                    'sub_total_try' => $toplam_tutarim,
                                    'sub_total_0' => convert_number_for_sql(0),
                                    'sub_total_0_try' => convert_number_for_sql(0),
                                    'sub_total_1' => convert_number_for_sql(0),
                                    'sub_total_1_try' => convert_number_for_sql(0),
                                    'sub_total_10' => convert_number_for_sql(0),
                                    'sub_total_10_try' => convert_number_for_sql(0),
                                    'sub_total_20' => convert_number_for_sql(0),
                                    'sub_total_20_try' => convert_number_for_sql(0),
                
                                    'grand_total' => $toplam_tutarim,
                                    'grand_total_try' => $toplam_tutarim,
                
                                    'amount_to_be_paid' => $toplam_tutarim,
                                    'amount_to_be_paid_try' => $toplam_tutarim,
                
                                    'amount_to_be_paid_text' => $this->yaziyaCevir($order["total"]),
                
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
                
                                    'address_city' => $order['shipping_address']['city'],
                                    'address_city_plate' => isset($cari_item['address_city_plate']) ? $cari_item['address_city_plate'] : "",
                                    'address_district' => $order['shipping_address']['district'],
                                    'address_zip_code' => $order['shipping_address']['zip_code'],
                                    'address' => $order['shipping_address']['full_address'],
                                    
                                    'order_status' => $status_degeri,
                                    'service_name' => $order["service_name"],
                                    'service_logo' => $order["service_logo"],
                                    'shipped_date' => $order["shipped_date"] ?? '',
                                    'kargo_kodu'   => $kargo_kodu,
                                    'kargo' => $this->DopigoKargo($kargosu),
                                    'failed_reason' => "",
                                    'komisyon' => $banka_komisyon,
                                    'dopigo_data' => json_encode($order)
                                ];
        
        
        
        
                          
                                $this->modelOrder->insert($insert_order_data);
                                $order_id = $this->modelOrder->getInsertID();
        
                               
        
                             
        
                            
        
        
                    
                     
                
                                foreach ($order_rows as $data_order_row) {
                                
        
                                
                                                    
                                                         $dopigoQuery = $this->modelDopigoEslestir
                                                        ->where("silindi", 0)
                                                        ->groupStart()
                                                        
                                                        // ->where("dopigo_id", $data_order_row["linked_product_id"])
                                                            ->orWhere('dopigo_title', $data_order_row['urun_adi'])
                                                            ->orWhere('stock_title', $data_order_row['stock_title']);
        
                                                    // Eğer linked_product_foreign_sku boş değilse, koşula ekle
                                                    if (!empty($data_order_row["linked_product_foreign_sku"])) {
                                                        $dopigoQuery->orWhere('dopigo_code', $data_order_row['linked_product_foreign_sku']);
                                                    }
        
        
                                                    if (!empty($data_order_row["linked_product_id"]) || $data_order_row["linked_product_id"] != 0) {
                                                        $dopigoQuery->orWhere('dopigo_id', $data_order_row['linked_product_id']);
                                                    }
        
        
                                                    $dopigoEslesenlers = $dopigoQuery
                                                        ->groupEnd()
                                                        ->get()
                                                        ->getRowArray();
        
                                                    // Boşsa modelStock ile eşleşme yap
                                                    if (empty($dopigoEslesenlers)) {
                                                        $stockQueryBul = $this->modelStock
                                                            ->groupStart()
                                                                ->where("stock_code", $data_order_row['sku']);
        
                                                        // linked_product_foreign_sku boş değilse modelStock sorgusuna ekle
                                                        if (!empty($data_order_row["linked_product_foreign_sku"])) {
                                                            $stockQueryBul->orWhere('stock_code', $data_order_row['linked_product_foreign_sku']);
                                                        }
                                                        if (!empty($data_order_row["sku"])) {
                                                            $stockQueryBul->orWhere('stock_code', $data_order_row['sku']);
                                                        }
        
                                                        $stockQueryBul = $stockQueryBul
                                                            ->groupEnd()
                                                            ->get()
                                                            ->getRowArray();
                                                            
                                                        if(!empty($stockQueryBul) && isset($stockQueryBul["grup_id"]) && $stockQueryBul["grup_id"] > 0){
                                                            $grupStock = $this->modelStock->where("grup_id", $stockQueryBul["grup_id"])->first();
                                                            $dopigoEslesenler = $grupStock;
                                                        }else{
                                                            $dopigoEslesenler = $stockQueryBul;
                                                        }
                                                            
                                                    } else {
                                                        $dopigoEslesenler = $dopigoEslesenlers;
                                                    }
        
                                    // Stok bilgilerini almak
        
                       
                                 
                                    if (!empty($dopigoEslesenler) && isset($dopigoEslesenler['stock_id'])) {
         
                                    
                                        $stokBilgileri = $this->modelStock->where('stock_id', $dopigoEslesenler['stock_id'])->where('deleted_at IS NULL', null, false)->first();

        
                                        
        
                                        $stokBilgileri = $this->modelStock->where('stock_id', $dopigoEslesenler['stock_id'])->first();
        
        
        
                                                if(!empty($data_order_row["linked_product_id"])):
                                                $this->modelStock->set("dopigo", $data_order_row["linked_product_id"])->where("stock_id", $stokBilgileri['stock_id'])->update();
                                                endif;
        
                                                if($stokBilgileri["paket"] == 1){
                                                    $paket = 1;
                                                }else{
                                                    $paket = 0;
                                                }
                                       
                                        
                                                $insert_order_row_data = [
                                                    'user_id' => session()->get('user_id'),
                                                    'order_id' => $order_id,
                                                    'stock_id' => $stokBilgileri['stock_id'],
                                                    'stock_title' => $stokBilgileri['stock_title'],
                                                    'dopigo_title' => $data_order_row['stock_title'],
                                                    'stock_amount' => $data_order_row['adet'],
                                                    'stock_total_quantity' => $stokBilgileri['stock_total_quantity'],
                                                    'unit_id' => 1,
                                                    'unit_price' => $data_order_row['price'],
                                                    'discount_rate' => 0, //$order['iskonto_oran'],
                                                    'discount_price' => $order['discount'],
                                                    'subtotal_price' => $data_order_row['price'],
                                                    'tax_id' => 0,
                                                    'paket'  => $paket,
                                                    'dopigo' => $data_order_row["linked_product_id"],
                                                    'dopigo_sku' => $data_order_row["linked_product_foreign_sku"] ?? '',
                                                    'tax_price' => 0,
                                                    'total_price' => $data_order_row['price'],
                                                ];
                                                $this->modelOrderRow->insert($insert_order_row_data);
        
        
                                                if($stokBilgileri["paket"]  == 1){
        
        
                                                        $receteBul = $this->modelStockRecipe->where("stock_id", $stokBilgileri["stock_id"])->first();
        
                                                        $StoklariBul = $this->modelRecipeItem->where("recipe_id", $receteBul["recipe_id"])->findAll();
        
                                                        if($StoklariBul){
        
                                                            foreach($StoklariBul as $stoks){
        
                                                                $stok = $this->modelStock->where("stock_id", $stoks["stock_id"])->first();
        
        
                                                                $insert_order_row_data = [
                                                                    'user_id' => session()->get('user_id'),
                                                                    'order_id' => $order_id,
                                                                    'stock_id' => $stok['stock_id'],
                                                                    'stock_title' => $stok['stock_title'],
                                                                    'dopigo_title' => $stok['stock_title'],
                                                                    'stock_amount' => $data_order_row['adet'],
                                                                    'stock_total_quantity' => $stok['stock_total_quantity'],
                                                                    'unit_id' => 1,
                                                                    'unit_price' => 0,
                                                                    'discount_rate' => 0, //$order['iskonto_oran'],
                                                                    'discount_price' => 0,
                                                                    'subtotal_price' => 0,
                                                                    'tax_id' => 0,
                                                                    'paket'  => 0,
                                                                    'dopigo' => $stok["dopigo"],
                                                                    'dopigo_sku' => $stok["stock_code"],
                                                                    'tax_price' => 0,
                                                                    'total_price' => 0,
                                                                    'paket_text' => "Bu satırlar #" . $stokBilgileri["stock_id"] . " idli ürünün paket içeriğindeki ürünlerden birisidir.",
                                                                ];
                                                                $this->modelOrderRow->insert($insert_order_row_data);
        
        
        
        
                                                            }
        
                                                        }
        
        
                                                }
                                          
                                        
                                        
                                
                               
                                    }else{
        
                                        
        
                                     /*   echo "DOPİGO BİLGİLERİ  BAŞLANGIÇ<br>";
                                        echo '<pre>';
                                        print_r($data_order_row);
                                        print_r($order);
                                        echo '</pre>';
                                        echo "DOPİGO BİLGİLERİ  BİTİŞ<br>";
         */
                                
        
                                        $insert_order_row_data = [
                                            'user_id' => session()->get('user_id'),
                                            'order_id' => $order_id,
                                            'stock_id' => 0,
                                            'stock_title' => $data_order_row['stock_title'],
                                            'dopigo_title' => $data_order_row['stock_title'],
                                            'stock_amount' => $data_order_row['adet'],
                                            'stock_total_quantity' => 0,
                                            'unit_id' => 1,
                                            'unit_price' => $data_order_row['price'],
                                            'discount_rate' => 0, //$order['iskonto_oran'],
                                            'discount_price' => $order['discount'],
                                            'subtotal_price' => $data_order_row['price'],
                                            'tax_id' => 0,
                                            'paket'  => 0,
                                            'dopigo' => $data_order_row["linked_product_id"],
                                            'dopigo_sku' => $data_order_row["linked_product_foreign_sku"],
                                            'tax_price' => 0,
                                            'total_price' => $data_order_row['price'],
                                        ];
                                        $this->modelOrderRow->insert($insert_order_row_data);
        
                                    }
                                }
                                
                            
                               /* echo "DOPİGO BİLGİLERİ  BAŞLANGIÇ<br>";
                                echo '<pre>';
                                print_r($order);
                                echo '</pre>';
                                echo "DOPİGO BİLGİLERİ  BİTİŞ<br>"; */
                  
                
                         
                            } catch (\Exception $e) {
                                // Hata detaylarını almak
                                $errorLine = $e->getLine(); // Hata satırı
                                $errorFile = $e->getFile(); // Hata dosyası
                            
                                // Log kaydı oluşturma
                                $this->logClass->save_log(
                                    'error',
                                    'order',
                                    null,
                                    null,
                                    'create',
                                    $e->getMessage() . " in " . $errorFile . " on line " . $errorLine,
                                    json_encode($_POST)
                                );
                            
                                // Hata mesajını ve satır numarasını JSON olarak döndürme
                                echo json_encode([
                                    'icon' => 'error',
                                    'message' => $e->getMessage(),
                                    'file' => $errorFile,
                                    'line' => $errorLine,
                                ]);
                                return;
                            }
                        
                  
                      } else{
        
        
                         $shipment_provider = isset($order["items"][$key]["shipment_provider"]) ? $order["items"][$key]["shipment_provider"] : 'Undefined';
        
                         $transaction_prefix = "DPG" . $order["id"];
                         $modelStock = $this->modelOrder->where("order_no", $transaction_prefix)->first();
        
                         
                            
                         $data_up = [];
        
                            if($order["status"] == "shipped"){
                                $status_degeri = "kargolandi";
                            }else if($order["status"] == "pending"){
                                $status_degeri = "pending";
                            }else if($order["status"] == "waiting_shipment"){
                                $status_degeri = "kargo_bekliyor";
                            }else if($order["status"] == "cancelled"){
                                $status_degeri = "failed";
                            }
                            else if($order["status"] == "undefined"){
                                $status_degeri = "failed";
                            }
                            else {
                                $status_degeri = "new";
                            }
                            if(isset($modelStock["order_status"])){
                                if ($modelStock["order_status"] != "sevk_edildi" && $modelStock["order_status"] != "sevk_emri") {



                                    $data_up["order_status"] = $status_degeri;



                                } else {
                                    $data_up["order_status"] = $modelStock["order_status"];
                                }
                            }else{
                                $data_up["order_status"] = $status_degeri;
        
                            }
                          
                          
                            //$data_up['order_numara'] = $order["service_value"];
                           // $data_up['service_name'] = $order["service_name"];
                            //$data_up['service_logo'] = $order["service_logo"];
                            $data_up['shipped_date'] = $order["shipped_date"];
                            $data_up['kargo_kodu'] = $kargo_kodu;
                            $data_up['dopigo_siparis_id'] = $dopigo_siparis_id;
        
                            //$data_up['kargo'] = $this->DopigoKargo($kargosu);
                            $data_up['address_city'] = $order['shipping_address']['city'];
                            $data_up['address_district'] = $order['shipping_address']['district'];
                            $data_up['address_zip_code'] = $order['shipping_address']['zip_code'];
                            
                            $modelUp = $this->modelOrder->set($data_up)->where("order_id", $modelStock["order_id"])->update();
        
        
                      } 
               
                    
                    
                    }else{
        
        
                            $shipment_provider = isset($order["items"][$key]["shipment_provider"]) ? $order["items"][$key]["shipment_provider"] : 'Undefined';
        
                            $transaction_prefix = "DPG" . $order["id"];
                            $modelStock = $this->modelOrder->where("order_no", $transaction_prefix)->first();
        
                            
                            $data_up = [];
        
        
                            if($order["status"] == "shipped"){
                                $status_degeri = "kargolandi";
                            }else if($order["status"] == "pending"){
                                $status_degeri = "pending";
                            }else if($order["status"] == "waiting_shipment"){
                                $status_degeri = "kargo_bekliyor";
                            }else if($order["status"] == "cancelled"){
                                $status_degeri = "failed";
                            }
                            else if($order["status"] == "undefined"){
                                $status_degeri = "failed";
                            }
                            else {
                                $status_degeri = "new";
                            }
        
                      
                            if(isset($modelStock["order_status"])){
                                if ($modelStock["order_status"] != "sevk_edildi" && $modelStock["order_status"] != "sevk_emri" ) {
                                    $data_up["order_status"] = $status_degeri;
                                } else {
                                    $data_up["order_status"] = $modelStock["order_status"];
                                }
                            }else{
                                $data_up["order_status"] = $status_degeri;
        
                            }
                            
                           // $data_up['service_name'] = $order["service_name"];
                            //$data_up['order_numara'] = $order["service_value"];
                            //$data_up['service_logo'] = $order["service_logo"];
                            $data_up['shipped_date'] = $order["shipped_date"];
                            $data_up['kargo_kodu'] = $kargo_kodu;
                            $data_up['dopigo_siparis_id'] = $dopigo_siparis_id;
                          //  $data_up['kargo'] = $this->DopigoKargo($kargosu);
                            $data_up['address_city'] = $order['shipping_address']['city'];
                            $data_up['address_district'] = $order['shipping_address']['district'];
                            $data_up['address_zip_code'] = $order['shipping_address']['zip_code'];
                            
                            $modelUp = $this->modelOrder->set($data_up)->where("order_id", $modelStock["order_id"])->update();
        
                        }
                            
        
                        
                 }


            }else{
                

                if($order["service_name"] != "epttavm"){

                    $dopigo_siparis_id = $order["id"];
        
                    $parts = explode('-', $order["service_value"]);
                    if($order["service_name"] == "epttavm"){
                        $order["id"] = $parts[1];
                    }else{
                         $order["id"] = $parts[0];
                    }
                              
        
        
                    $kargosu = "";
                    $kargo_kodu = "";
                    $service_name  = $order["service_name"];
                    $siparis_tarihi = $order["service_created"];
                    $banka_komisyon = $order["bank_charge"] + $order["bank_charge_tax"];
                    $order['total'] = $order['total'] - $banka_komisyon;
        
                    $musteri = $order["customer"];
                    $account_type = $musteri["account_type"];
                    $full_name = $musteri["full_name"];
                    $contact_number = $musteri["contact_number"];
        
                    // MÜŞTERİ ADRES BAŞLANGIÇ ///
                    $adres = $musteri["address"];
        
                    $full_address = $adres["full_address"];
        
                    $country = $adres["country"];
                    $city = $adres["city"];
                    $district = $adres["district"];
                    $zip_code = $adres["zip_code"];
                    // MÜŞTERİ ADRES BİTİŞ //
        
        
                    $email = $musteri["email"];
                    $citizen_id = $musteri["citizen_id"];
                    $company_name = $musteri["company_name"];
                    $tax_office = $musteri["tax_office"];
                    $tax_id = $musteri["tax_id"];
        
        
                    $total = $order["total"];
        
                    $order_rows = [];
        
        
               
        
                    foreach ($order["items"] as $row) {
                        // Add each row to the order_rows array
                        $order_rows[] = [
                            "sku" => $row["sku"],
                            "attributes" => $row["attributes"],
                            "stock_title" => $row["name"],
                            "urun_adi" => $row["name"],
                            "adet" => $row["amount"],
                            'urun_id' => $row["service_product_id"],
                            "price" => $row["price"],
                            "vergi" => $row["tax_ratio"],
                            "kargo" => $row["shipment_provider"],
                            "kargo_kodu" => $row["shipment_campaign_code"],
                            "linked_product_id" => isset($row["linked_product"]["id"]) ? $row["linked_product"]["id"] : null,
                            "linked_product_sku" => isset($row["linked_product"]["sku"]) ? $row["linked_product"]["sku"] : null,
                            "linked_product_foreign_sku" => isset($row["linked_product"]["foreign_sku"]) ? $row["linked_product"]["foreign_sku"] : null,
                            "linked_product_barcode" => isset($row["linked_product"]["barcode"]) ? $row["linked_product"]["barcode"] : null,
                        ];
                    }
        
                          
                    foreach ($order_rows as $order_row) {
                        $kargosu = $order_row["kargo"];
                        $kargo_kodu = $order_row["kargo_kodu"];
                    }   
        
                    
        
        
        
        
        
                    $new_data_form = [];
                    $data_order_amounts = [];
                    $b2bText = "";
                     // *********** SİPARİŞ EKLEME BAŞLANGIÇ **************** //
        
        
                    
        
        
                        $Sorgula = $this->modelOrder->where("order_numara", $order["service_value"])->first();
        
                        if(!isset($Sorgula))
                        {   
        
                            
        
                            $transaction_prefix = "DPG" . $order["id"];
        
        
        
                            $sorgum = $this->modelOrder->where("order_numara", $order["service_value"])->first();
        
        
                           if(!$sorgum){
        
                            $siparis = $order;
                            
                      
        
                            $CariSorgula = $this->modelCari->orWhere("cari_email", $email)->where("invoice_title", $full_name)->first();
                        
                        
                            
                            $cari_id = 0;
                            if(!$CariSorgula){
        
                                $is_export_customer = 0;
                                if(!empty($siparis['citizen_id'])){
                                    $tcvkn = $siparis['citizen_id'];
                                }else{
                                    $tcvkn = 1111111111;
                                }
                                $new_data_form['invoice_title'] = $full_name;
                                $fullName = $full_name ?? '';
                                $nameParts = explode(' ', $fullName);
                    
                                if (count($nameParts) < 2) {
                                    // Handle cases where full name does not contain a space
                                    $nameParts[] = '';
                                }
                    
                                $new_data_form['surname'] = array_pop($nameParts);
                                $new_data_form['name'] = implode(' ', $nameParts);
                                
                                $new_data_form['obligation'] = "e-archive";
                                $new_data_form['company_type'] = "person";
                                $new_data_form['address_city_name'] = "";
                                $new_data_form['address_city'] = $city;
                                $new_data_form['address_district'] = $district;
                                $new_data_form['zip_code'] = $zip_code;
                                $new_data_form['address'] =$full_address;
        
                                $phoneNumber = $contact_number;
        
                                if($phoneNumber == "" || empty($phoneNumber))
                                {
                                    $phoneNumber = "+90 000 000 00 00";
                                }
        
        
                                if (substr($phoneNumber, 0, 1) === '0') {
                                    $phoneNumber = substr($phoneNumber, 1);
                                }
                        
                                // Numaranın 10 haneli olup olmadığını kontrol et
                                if (strlen($phoneNumber) < 10) {
                                    $phoneNumber = str_pad($phoneNumber, 10, "0", STR_PAD_LEFT);
                                }
                        
                                
                                $create_cari_code = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
                                if(!is_numeric($citizen_id))
                                {
                                    $identification_number  = 1111111111;
                                }else{
                                    $identification_number = $citizen_id;
                                }
                                $cari_data = [
                                    'user_id' => session()->get('user_id'),
                                    'money_unit_id' => 3,
                                    'cari_code' => $create_cari_code,
                                    'identification_number' => $identification_number,
                                    'tax_administration' => $tax_office != '' ? $tax_office : null,
                                    'invoice_title' => $new_data_form['invoice_title'],
                                    'name' => $new_data_form['name'],
                                    'surname' => $new_data_form['surname'],
                                    'obligation' => $new_data_form['obligation'] != '' ? $new_data_form['obligation'] : null,
                                    'company_type' => $new_data_form['company_type'] != '' ? $new_data_form['company_type'] : null ,
                                    'cari_phone' => $phoneNumber,
                                    'cari_email' => $email != '' ? $email : null,
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
                                    'address_email' => $email != '' ? $email : null,
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
        
        
        
        
        
        
                           
                    
                
        
                           
        
                            $musteriMail = $email;
                            $is_customer = 1;
                            $is_supplier = 0;
                            $is_export_customer  = 0;
        
        
        
                            $siparisTarih = $siparis_tarihi;
        
                            $dateTime = new \DateTime($siparisTarih);
        
                            // Yeni tarih ve saat formatı
                            $new_data_form['order_date'] = $dateTime->format('Y-m-d');
                            $new_data_form['order_time'] = $dateTime->format('H:i');
        
                            $data_order_amounts['amount_to_be_paid'] = $siparis["total"];
               
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
        
        
                                $is_deadline  = 0;
                                $d_date = Date("Y-m-d");
        
                                if($order["status"] == "shipped"){
                                    $status_degeri = "kargolandi";
                                }else if($order["status"] == "pending"){
                                    $status_degeri = "pending";
                                }else if($order["status"] == "waiting_shipment"){
                                    $status_degeri = "kargo_bekliyor";
                                }else if($order["status"] == "cancelled"){
                                    $status_degeri = "failed";
                                }
                                else if($order["status"] == "undefined"){
                                    $status_degeri = "failed";
                                }
                                else {
                                    $status_degeri = "new";
                                }
        
                                
        
        
                               
                            
        
        
                                $b2bText.= "<div> Sipariş: <b style='    text-transform: uppercase;'>Dopigo</b>  Platform:  <b style='    text-transform: uppercase;' ><span style='font-weight: bold; '>  ".$service_name."</span></b> <br> Sipariş Numarası :  <b><span style='font-weight: bold;'>".$order["id"]." </span></b>  <br>";
                                $b2bText.="Sipariş Tarihi : <b>" . $order_date . " " . $order_time . "</b></div>"; 
        
                  
                   
                
                                $cari_id = $CariSorgula['cari_id'];
                            
                
                                $order_note_id = 0;
                                $order_note = $order["notes"];
        
                                if(empty($order['discount']))
                                {
                                    $order['discount'] = 0;
                                }   
        
        
        
                            
                              
        
                         
                            
                                $insert_order_data = [
                                    'user_id' => session()->get('user_id'),
                                    'money_unit_id' => 3,
                                    'order_direction' => 'incoming',
                                    'order_no' => $transaction_prefix,
                                    'order_numara' => $order["service_value"],
                                    'order_date' => $siparis_tarihi,
                                    'b2b' => $b2bText,
                                    'dopigo' => $order["id"],
                                    'dopigo_siparis_id' => $dopigo_siparis_id,
                                    'order_note_id' => 0,
                                    'order_note' => $order_note,
                
                                    'is_deadline' => $is_deadline,
                                    'deadline_date' => $d_date,
                
                                    'currency_amount' => 0,
                                    'cron_id' => $cronId,
                                    'stock_total' => $order['total'],
                                    'stock_total_try' => $order['total'],
                
                                    'discount_total' => $order['discount'],
                                    'discount_total_try' => $order['discount'],
                
                                    'tax_rate_1_amount' => convert_number_for_sql(0),
                                    'tax_rate_1_amount_try' => convert_number_for_sql(0),
                                    'tax_rate_10_amount' => convert_number_for_sql(0),
                                    'tax_rate_10_amount_try' => convert_number_for_sql(0),
                                    'tax_rate_20_amount' => convert_number_for_sql(0),
                                    'tax_rate_20_amount_try' => convert_number_for_sql(0),
                
                                    'sub_total' => $order['total'],
                                    'sub_total_try' => $order['total'],
                                    'sub_total_0' => convert_number_for_sql(0),
                                    'sub_total_0_try' => convert_number_for_sql(0),
                                    'sub_total_1' => convert_number_for_sql(0),
                                    'sub_total_1_try' => convert_number_for_sql(0),
                                    'sub_total_10' => convert_number_for_sql(0),
                                    'sub_total_10_try' => convert_number_for_sql(0),
                                    'sub_total_20' => convert_number_for_sql(0),
                                    'sub_total_20_try' => convert_number_for_sql(0),
                
                                    'grand_total' => $order['total'],
                                    'grand_total_try' => $order['total'],
                
                                    'amount_to_be_paid' => $order['total'],
                                    'amount_to_be_paid_try' => $order['total'],
                
                                    'amount_to_be_paid_text' => $this->yaziyaCevir($order["total"]),
                
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
                
                                    'address_city' => $order['shipping_address']['city'],
                                    'address_city_plate' => isset($cari_item['address_city_plate']) ? $cari_item['address_city_plate'] : "",
                                    'address_district' => $order['shipping_address']['district'],
                                    'address_zip_code' => $order['shipping_address']['zip_code'],
                                    'address' => $order['shipping_address']['full_address'],
                
                                    'order_status' => $status_degeri,
                                    'service_name' => $order["service_name"],
                                    'service_logo' => $order["service_logo"],
                                    'shipped_date' => $order["shipped_date"] ?? '',
                                    'kargo_kodu'   => $kargo_kodu,
                                    'kargo' => $this->DopigoKargo($kargosu),
                                    'failed_reason' => "",
                                    'komisyon' => $banka_komisyon,
                                    'dopigo_data' => json_encode($order)
                                ];
        
        
        
        
                          
                                $this->modelOrder->insert($insert_order_data);
                                $order_id = $this->modelOrder->getInsertID();
        
                               
        
                             
        
                            
        
        
                    
                     
                
                                foreach ($order_rows as $data_order_row) {
                                
        
                                  
                                                    
                                                         $dopigoQuery = $this->modelDopigoEslestir
                                                        ->where("silindi", 0)
                                                        ->groupStart()
                                                        
                                                        // ->where("dopigo_id", $data_order_row["linked_product_id"])
                                                            ->orWhere('dopigo_title', $data_order_row['urun_adi'])
                                                            ->orWhere('stock_title', $data_order_row['stock_title']);
        
                                                    // Eğer linked_product_foreign_sku boş değilse, koşula ekle
                                                    if (!empty($data_order_row["linked_product_foreign_sku"])) {
                                                        $dopigoQuery->orWhere('dopigo_code', $data_order_row['linked_product_foreign_sku']);
                                                    }
        
        
                                                    if (!empty($data_order_row["linked_product_id"]) || $data_order_row["linked_product_id"] != 0) {
                                                        $dopigoQuery->orWhere('dopigo_id', $data_order_row['linked_product_id']);
                                                    }
        
        
                                                    $dopigoEslesenlers = $dopigoQuery
                                                        ->groupEnd()
                                                        ->get()
                                                        ->getRowArray();
        
                                                    // Boşsa modelStock ile eşleşme yap
                                                    if (empty($dopigoEslesenlers)) {
                                                        $stockQueryBul = $this->modelStock
                                                            ->groupStart()
                                                                ->where("stock_code", $data_order_row['sku']);
        
                                                        // linked_product_foreign_sku boş değilse modelStock sorgusuna ekle
                                                        if (!empty($data_order_row["linked_product_foreign_sku"])) {
                                                            $stockQueryBul->orWhere('stock_code', $data_order_row['linked_product_foreign_sku']);
                                                        }
                                                        if (!empty($data_order_row["sku"])) {
                                                            $stockQueryBul->orWhere('stock_code', $data_order_row['sku']);
                                                        }
        
                                                        $stockQueryBul = $stockQueryBul
                                                            ->groupEnd()
                                                            ->get()
                                                            ->getRowArray();
                                                            
                                                        if(!empty($stockQueryBul) && isset($stockQueryBul["grup_id"]) && $stockQueryBul["grup_id"] > 0){
                                                            $grupStock = $this->modelStock->where("grup_id", $stockQueryBul["grup_id"])->first();
                                                            $dopigoEslesenler = $grupStock;
                                                        }else{
                                                            $dopigoEslesenler = $stockQueryBul;
                                                        }
                                                            
                                                    } else {
                                                        $dopigoEslesenler = $dopigoEslesenlers;
                                                    }
        
                                    // Stok bilgilerini almak
        
                       
                                 
                                    if (!empty($dopigoEslesenler)  && isset($dopigoEslesenler['stock_id'])) {
         
                                        $stokBilgileri = $this->modelStock->where('stock_id', $dopigoEslesenler['stock_id'])->where('deleted_at IS NULL', null, false)->first();
                                        if(isset($stokBilgileri)){
                                          
                                     
        
                                        
        
                                        $stokBilgileri = $this->modelStock->where('stock_id', $dopigoEslesenler['stock_id'])->first();
        
        
        
                                                if(!empty($data_order_row["linked_product_id"])):
                                                $this->modelStock->set("dopigo", $data_order_row["linked_product_id"])->where("stock_id", $stokBilgileri['stock_id'])->update();
                                                endif;
        
                                                if($stokBilgileri["paket"] == 1){
                                                    $paket = 1;
                                                }else{
                                                    $paket = 0;
                                                }
                                       
                                        
                                                $insert_order_row_data = [
                                                    'user_id' => session()->get('user_id'),
                                                    'order_id' => $order_id,
                                                    'stock_id' => $stokBilgileri['stock_id'],
                                                    'stock_title' => $stokBilgileri['stock_title'],
                                                    'dopigo_title' => $data_order_row['stock_title'],
                                                    'stock_amount' => $data_order_row['adet'],
                                                    'stock_total_quantity' => $stokBilgileri['stock_total_quantity'],
                                                    'unit_id' => 1,
                                                    'unit_price' => $data_order_row['price'],
                                                    'discount_rate' => 0, //$order['iskonto_oran'],
                                                    'discount_price' => $order['discount'],
                                                    'subtotal_price' => $data_order_row['price'],
                                                    'tax_id' => 0,
                                                    'paket'  => $paket,
                                                    'dopigo' => $data_order_row["linked_product_id"],
                                                    'dopigo_sku' => $data_order_row["linked_product_foreign_sku"] ?? '',
                                                    'tax_price' => 0,
                                                    'total_price' => $data_order_row['price'],
                                                ];
                                                $this->modelOrderRow->insert($insert_order_row_data);
        
        
                                                if($stokBilgileri["paket"]  == 1){
        
        
                                                        $receteBul = $this->modelStockRecipe->where("stock_id", $stokBilgileri["stock_id"])->first();
        
                                                        $StoklariBul = $this->modelRecipeItem->where("recipe_id", $receteBul["recipe_id"])->findAll();
        
                                                        if($StoklariBul){
        
                                                            foreach($StoklariBul as $stoks){
        
                                                                $stok = $this->modelStock->where("stock_id", $stoks["stock_id"])->first();
        
        
                                                                $insert_order_row_data = [
                                                                    'user_id' => session()->get('user_id'),
                                                                    'order_id' => $order_id,
                                                                    'stock_id' => $stok['stock_id'],
                                                                    'stock_title' => $stok['stock_title'],
                                                                    'dopigo_title' => $stok['stock_title'],
                                                                    'stock_amount' => $data_order_row['adet'],
                                                                    'stock_total_quantity' => $stok['stock_total_quantity'],
                                                                    'unit_id' => 1,
                                                                    'unit_price' => 0,
                                                                    'discount_rate' => 0, //$order['iskonto_oran'],
                                                                    'discount_price' => 0,
                                                                    'subtotal_price' => 0,
                                                                    'tax_id' => 0,
                                                                    'paket'  => 0,
                                                                    'dopigo' => $stok["dopigo"],
                                                                    'dopigo_sku' => $stok["stock_code"],
                                                                    'tax_price' => 0,
                                                                    'total_price' => 0,
                                                                    'paket_text' => "Bu satırlar #" . $stokBilgileri["stock_id"] . " idli ürünün paket içeriğindeki ürünlerden birisidir.",
                                                                ];
                                                                $this->modelOrderRow->insert($insert_order_row_data);
        
        
        
        
                                                            }
        
                                                        }
        
        
                                                }
                                        }else{

        
                                        $insert_order_row_data = [
                                            'user_id' => session()->get('user_id'),
                                            'order_id' => $order_id,
                                            'stock_id' => 0,
                                            'stock_title' => $data_order_row['stock_title'],
                                            'dopigo_title' => $data_order_row['stock_title'],
                                            'stock_amount' => $data_order_row['adet'],
                                            'stock_total_quantity' => 0,
                                            'unit_id' => 1,
                                            'unit_price' => $data_order_row['price'],
                                            'discount_rate' => 0, //$order['iskonto_oran'],
                                            'discount_price' => $order['discount'],
                                            'subtotal_price' => $data_order_row['price'],
                                            'tax_id' => 0,
                                            'paket'  => 0,
                                            'dopigo' => $data_order_row["linked_product_id"],
                                            'dopigo_sku' => $data_order_row["linked_product_foreign_sku"],
                                            'tax_price' => 0,
                                            'total_price' => $data_order_row['price'],
                                        ];
                                        $this->modelOrderRow->insert($insert_order_row_data);
                                        }
                                        
                                
                               
                                    }else{
        
                                        
        
                                     /*   echo "DOPİGO BİLGİLERİ  BAŞLANGIÇ<br>";
                                        echo '<pre>';
                                        print_r($data_order_row);
                                        print_r($order);
                                        echo '</pre>';
                                        echo "DOPİGO BİLGİLERİ  BİTİŞ<br>";
         */
                                
        
                                        $insert_order_row_data = [
                                            'user_id' => session()->get('user_id'),
                                            'order_id' => $order_id,
                                            'stock_id' => 0,
                                            'stock_title' => $data_order_row['stock_title'],
                                            'dopigo_title' => $data_order_row['stock_title'],
                                            'stock_amount' => $data_order_row['adet'],
                                            'stock_total_quantity' => 0,
                                            'unit_id' => 1,
                                            'unit_price' => $data_order_row['price'],
                                            'discount_rate' => 0, //$order['iskonto_oran'],
                                            'discount_price' => $order['discount'],
                                            'subtotal_price' => $data_order_row['price'],
                                            'tax_id' => 0,
                                            'paket'  => 0,
                                            'dopigo' => $data_order_row["linked_product_id"],
                                            'dopigo_sku' => $data_order_row["linked_product_foreign_sku"],
                                            'tax_price' => 0,
                                            'total_price' => $data_order_row['price'],
                                        ];
                                        $this->modelOrderRow->insert($insert_order_row_data);
        
                                    }
                                }
                                
                            
                               /* echo "DOPİGO BİLGİLERİ  BAŞLANGIÇ<br>";
                                echo '<pre>';
                                print_r($order);
                                echo '</pre>';
                                echo "DOPİGO BİLGİLERİ  BİTİŞ<br>"; */
                  
                
                         
                            } catch (\Exception $e) {
                                // Hata detaylarını almak
                                $errorLine = $e->getLine(); // Hata satırı
                                $errorFile = $e->getFile(); // Hata dosyası
                            
                                // Log kaydı oluşturma
                                $this->logClass->save_log(
                                    'error',
                                    'order',
                                    null,
                                    null,
                                    'create',
                                    $e->getMessage() . " in " . $errorFile . " on line " . $errorLine,
                                    json_encode($_POST)
                                );
                            
                                // Hata mesajını ve satır numarasını JSON olarak döndürme
                                echo json_encode([
                                    'icon' => 'error',
                                    'message' => $e->getMessage(),
                                    'file' => $errorFile,
                                    'line' => $errorLine,
                                ]);
                                return;
                            }
                        
                  
                      } else{
        
        
                         $shipment_provider = isset($order["items"][$key]["shipment_provider"]) ? $order["items"][$key]["shipment_provider"] : 'Undefined';
        
                         $transaction_prefix = "DPG" . $order["id"];
                         $modelStock = $this->modelOrder->where("order_no", $transaction_prefix)->first();
        
                         
                            
                         $data_up = [];
        
                            if($order["status"] == "shipped"){
                                $status_degeri = "kargolandi";
                            }else if($order["status"] == "pending"){
                                $status_degeri = "pending";
                            }else if($order["status"] == "waiting_shipment"){
                                $status_degeri = "kargo_bekliyor";
                            }else if($order["status"] == "cancelled"){
                                $status_degeri = "failed";
                            }
                            else if($order["status"] == "undefined"){
                                $status_degeri = "failed";
                            }
                            else {
                                $status_degeri = "new";
                            }
                            if(isset($modelStock["order_status"])){
                                if ($modelStock["order_status"] != "sevk_edildi" && $modelStock["order_status"] != "sevk_emri") {
                                    $data_up["order_status"] = $status_degeri;
                                } else {
                                    $data_up["order_status"] = $modelStock["order_status"];
                                }
                            }else{
                                $data_up["order_status"] = $status_degeri;
        
                            }
                          
                          
                           // $data_up['order_numara'] = $order["service_value"];
                            //$data_up['service_name'] = $order["service_name"];
                            //$data_up['service_logo'] = $order["service_logo"];
                            $data_up['shipped_date'] = $order["shipped_date"];
                            $data_up['kargo_kodu'] = $kargo_kodu;
                            $data_up['dopigo_siparis_id'] = $dopigo_siparis_id;
        
                          //  $data_up['kargo'] = $this->DopigoKargo($kargosu);
                            $data_up['address_city'] = $order['shipping_address']['city'];
                            $data_up['address_district'] = $order['shipping_address']['district'];
                            $data_up['address_zip_code'] = $order['shipping_address']['zip_code'];
                            
                            $modelUp = $this->modelOrder->set($data_up)->where("order_id", $modelStock["order_id"])->update();
        
        
                      } 
               
                    
                    
                    }else{
        
        
                            $shipment_provider = isset($order["items"][$key]["shipment_provider"]) ? $order["items"][$key]["shipment_provider"] : 'Undefined';
        
                            $transaction_prefix = "DPG" . $order["id"];
                            $modelStock = $this->modelOrder->where("order_no", $transaction_prefix)->first();
        
                            
                            $data_up = [];
        
        
                            if($order["status"] == "shipped"){
                                $status_degeri = "kargolandi";
                            }else if($order["status"] == "pending"){
                                $status_degeri = "pending";
                            }else if($order["status"] == "waiting_shipment"){
                                $status_degeri = "kargo_bekliyor";
                            }else if($order["status"] == "cancelled"){
                                $status_degeri = "failed";
                            }
                            else if($order["status"] == "undefined"){
                                $status_degeri = "failed";
                            }
                            else {
                                $status_degeri = "new";
                            }
        
                      
                            if(isset($modelStock["order_status"])){
                                if ($modelStock["order_status"] != "sevk_edildi" && $modelStock["order_status"] != "sevk_emri" ) {
                                    $data_up["order_status"] = $status_degeri;
                                } else {
                                    $data_up["order_status"] = $modelStock["order_status"];
                                }
                            }else{
                                $data_up["order_status"] = $status_degeri;
        
                            }
                            
                           // $data_up['service_name'] = $order["service_name"];
                            //$data_up['order_numara'] = $order["service_value"];
                            //$data_up['service_logo'] = $order["service_logo"];
                            $data_up['shipped_date'] = $order["shipped_date"];
                            $data_up['kargo_kodu'] = $kargo_kodu;
                            $data_up['dopigo_siparis_id'] = $dopigo_siparis_id;
                          //  $data_up['kargo'] = $this->DopigoKargo($kargosu);
                            $data_up['address_city'] = $order['shipping_address']['city'];
                            $data_up['address_district'] = $order['shipping_address']['district'];
                            $data_up['address_zip_code'] = $order['shipping_address']['zip_code'];
                            
                            $modelUp = $this->modelOrder->set($data_up)->where("order_id", $modelStock["order_id"])->update();
        
                        }
                            
        
                        
                      }

                
                   

            }

            if($pazar_yeri == 1){
                $platform_count  = $totalOrders;
                $successfulOrder = $successfulOrders;
            }else{
                $platform_count = $pazaryeriCount;
                $successfulOrder = $PazarYeriSuccessfulOrders;
            }

            
            $orderStatus = $this->checkAndLogOrder($order, $cronId);

            if(!$orderStatus){
                $failedOrders++;
                
            }
            $this->db->table('dopigo_cron')->where('id', $cronId)->update([
             
                'total_orders' => $platform_count,
                'successful_orders' => $successfulOrder,
                'failed_orders' => $failedOrders,
                'status' => 'completed'
            ]);



            
            
           
            
           
        } catch (\Exception $e) {
            $failedOrders++;
            
            // Hata logunu kaydet
            $logData = [
                'cron_id' => $cronId,
                'order_id' => $order['id'],
                'error_message' => $e->getMessage(),
                'order_data' => json_encode($order)
            ];
            
            $this->db->table('dopigo_cron_logs')->insert($logData);
        }
         
            }

            if($failedOrders > 0){
                log_message('error', 'Dopigo Api Hata: '.$cronId);

                $this->siparisWhatsappMesajHata($cronId);
              
            }
            if($successfulOrders > 0){
                log_message('info', 'Dopigo Api Basarili: '.$cronId);

                $this->siparisWhatsappMesajBasarili($cronId);
              
            }






     
     }


     public function checkAndLogOrder($order, $cronId) {
        try {
            // Dopigo sipariş numarasını al
            $dopigoOrderNo = $order["service_value"];
    
            // Önce siparişin sistemde olup olmadığını kontrol et
            $existingOrder = $this->db->query("
                SELECT order_id 
                FROM `order` 
                WHERE order_numara = ?
            ", [$dopigoOrderNo])->getRow();
    
            // Eğer sipariş sistemde yoksa loga ekle
            if (!$existingOrder) {
                // Sipariş detaylarını JSON olarak kaydet
                $orderData = json_encode($order, JSON_UNESCAPED_UNICODE);
    
                // Log kaydı ekle
                $this->db->query("
                    INSERT INTO dopigo_cron_logs 
                    (cron_id, order_id, error_message, order_data) 
                    VALUES (?, ?, ?, ?)
                ", [
                    $cronId,
                    $dopigoOrderNo,
                    " " . $dopigoOrderNo.' Numaralı Sipariş sistemde bulunamadı',
                    $orderData
                ]);
    
                return false;
            }
    
            // Sipariş satırlarını kontrol et
            if (isset($order['items']) && is_array($order['items'])) {
                foreach ($order['items'] as $item) {
                    // Sipariş satırının sistemde olup olmadığını kontrol et
                    $existingOrderRow = $this->db->query("
                        SELECT order_row_id 
                        FROM order_row 
                        WHERE order_id = ? AND dopigo_sku = ?
                    ", [$existingOrder->order_id, $item["linked_product"]["foreign_sku"]])->getRow();
    
                    // Eğer sipariş satırı sistemde yoksa loga ekle
                    if (!$existingOrderRow) {
                        // Ürün detaylarını JSON olarak kaydet
                        $itemData = json_encode($item, JSON_UNESCAPED_UNICODE);
    
                        // Log kaydı ekle
                        $this->db->query("
                            INSERT INTO dopigo_cron_logs 
                            (cron_id, order_id, error_message, order_data) 
                            VALUES (?, ?, ?, ?)
                        ", [
                            $cronId,
                            $dopigoOrderNo,
                             "  " . $dopigoOrderNo.'  Numaralı Siparişteki satır sistemde bulunamadı: SKU=' . $item['sku'],
                            $itemData
                        ]);
                    }
                }
            }
    
            return true;
    
        } catch (\Exception $e) {
            // Hata durumunda log kaydı ekle
            $this->db->query("
                INSERT INTO dopigo_cron_logs 
                (cron_id, order_id, error_message, order_data) 
                VALUES (?, ?, ?, ?)
            ", [
                $cronId,
                $dopigoOrderNo ?? 'UNKNOWN',
                'Hata: ' . $e->getMessage(),
                json_encode($order, JSON_UNESCAPED_UNICODE)
            ]);
    
            return false;
        }
    }

     public function DopigoOrderSingle($order_id)
     {
         // Tarihler belirlenmemişse mevcut günü ve 7 gün sonrasını al
      
     
         $token = $this->getAuthToken();
     
         $url = "https://panel.dopigo.com/api/v1/orders/" . $order_id;
     
         $curl = curl_init();
     
         curl_setopt_array($curl, array(
             CURLOPT_URL => $url,
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_ENCODING => '',
             CURLOPT_MAXREDIRS => 10,
             CURLOPT_TIMEOUT => 0,
             CURLOPT_FOLLOWLOCATION => true,
             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
             CURLOPT_CUSTOMREQUEST => 'GET',
             CURLOPT_HTTPHEADER => array(
                 'Authorization: Token ' . $token
             ),
         ));
     
         $response = curl_exec($curl);
     
         curl_close($curl);
         return json_decode($response, true);
     }


     public function DopigoTekliSiparis($order_id)
     {
      

       $order = $this->DopigoOrderSingle($order_id);

     
       $siparis = $this->modelOrder->where("dopigo_siparis_id", $order_id)->first();
     
           if($order["service_name"] != "epttavm"){

           $parts = explode('-', $order["service_value"]);
           if($order["service_name"] == "epttavm"){
               $order["id"] = $parts[1];
           }else{
                $order["id"] = $parts[0];
           }
                     


           $kargosu = "";
           $kargo_kodu = "";
           $kargo_komisyon = 0;
           $service_name  = $order["service_name"];
           $siparis_tarihi = $order["service_created"];
           $banka_komisyon = $order["bank_charge"] + $order["bank_charge_tax"];
           $order['total'] = $order['total'] - $banka_komisyon;

       

           $musteri = $order["customer"];
           $account_type = $musteri["account_type"];
           $full_name = $musteri["full_name"];
           $contact_number = $musteri["contact_number"];

           // MÜŞTERİ ADRES BAŞLANGIÇ ///
           $adres = $musteri["address"];

           $full_address = $adres["full_address"];

           $country = $adres["country"];
           $city = $adres["city"];
           $district = $adres["district"];
           $zip_code = $adres["zip_code"];
           // MÜŞTERİ ADRES BİTİŞ //


           $email = $musteri["email"];
           $citizen_id = $musteri["citizen_id"];
           $company_name = $musteri["company_name"];
           $tax_office = $musteri["tax_office"];
           $tax_id = $musteri["tax_id"];


           $total = $order["total"];

           $order_rows = [];


      

           foreach ($order["items"] as $row) {
               // Add each row to the order_rows array
               $order_rows[] = [
                   "sku" => $row["sku"],
                   "attributes" => $row["attributes"],
                   "stock_title" => $row["name"],
                   "urun_adi" => $row["name"],
                   "adet" => $row["amount"],
                   'urun_id' => $row["service_product_id"],
                   "price" => $row["price"],
                   "vergi" => $row["tax_ratio"],
                   "kargo" => $row["shipment_provider"],
                   "kargo_kodu" => $row["shipment_campaign_code"],
                   "linked_product_id" => isset($row["linked_product"]["id"]) ? $row["linked_product"]["id"] : null,
                   "linked_product_sku" => isset($row["linked_product"]["sku"]) ? $row["linked_product"]["sku"] : null,
                   "linked_product_foreign_sku" => isset($row["linked_product"]["foreign_sku"]) ? $row["linked_product"]["foreign_sku"] : null,
                   "linked_product_barcode" => isset($row["linked_product"]["barcode"]) ? $row["linked_product"]["barcode"] : null,
               ];
           }

                 
           foreach ($order_rows as $order_row) {
               $kargosu = $order_row["kargo"];
               $kargo_kodu = $order_row["kargo_kodu"];
           }   

           
          

         /*   echo "<h3>Sipariş Satırları:</h3>";
           foreach ($order_rows as $order_row) {
               echo "SKU: " . $order_row["sku"] . "<br>";
               echo "Özellikler: " . $order_row["attributes"] . "<br>";
               echo "Stok Başlığı: " . $order_row["stock_title"] . "<br>";
               echo "Adet: " . $order_row["adet"] . "<br>";
               echo "Fiyat: " . $order_row["price"] . "<br>";
               echo "Vergi Oranı: " . $order_row["vergi"] . "<br>";
               echo "Bağlı Ürün SKU: " . $order_row["linked_product_sku"] . "<br>";
               echo "Bağlı Ürün Yabancı SKU: " . $order_row["linked_product_foreign_sku"] . "<br>";
               echo "Bağlı Ürün Barkodu: " . $order_row["linked_product_barcode"] . "<br><br>";
           } */



           $new_data_form = [];
           $data_order_amounts = [];
           $b2bText = "";
            // *********** SİPARİŞ EKLEME BAŞLANGIÇ **************** //


           


               $Sorgula = $this->modelOrder->where("dopigo", $order["id"])->first();

            
               if(!isset($Sorgula))
               {   

                   

                   $transaction_prefix = "DPG" . $order["id"];



                   $sorgum = $this->modelOrder->where("order_numara", $order["service_value"])->first();


                  if(!$sorgum){

                   $siparis = $order;


             
    
                   
             

                   $CariSorgula = $this->modelCari->orWhere("cari_email", $email)->where("invoice_title", $full_name)->first();
               
               
                   
                   $cari_id = 0;
                   if(!$CariSorgula){

                       $is_export_customer = 0;
                       if(!empty($siparis['citizen_id'])){
                           $tcvkn = $siparis['citizen_id'];
                       }else{
                           $tcvkn = 1111111111;
                       }
                       $new_data_form['invoice_title'] = $full_name;
                       $fullName = $full_name ?? '';
                       $nameParts = explode(' ', $fullName);
           
                       if (count($nameParts) < 2) {
                           // Handle cases where full name does not contain a space
                           $nameParts[] = '';
                       }
           
                       $new_data_form['surname'] = array_pop($nameParts);
                       $new_data_form['name'] = implode(' ', $nameParts);
                       
                       $new_data_form['obligation'] = "e-archive";
                       $new_data_form['company_type'] = "person";
                       $new_data_form['address_city_name'] = "";
                       $new_data_form['address_city'] = $city;
                       $new_data_form['address_district'] = $district;
                       $new_data_form['zip_code'] = $zip_code;
                       $new_data_form['address'] =$full_address;

                       $phoneNumber = $contact_number;

                       if($phoneNumber == "" || empty($phoneNumber))
                       {
                           $phoneNumber = "+90 000 000 00 00";
                       }


                       if (substr($phoneNumber, 0, 1) === '0') {
                           $phoneNumber = substr($phoneNumber, 1);
                       }
               
                       // Numaranın 10 haneli olup olmadığını kontrol et
                       if (strlen($phoneNumber) < 10) {
                           $phoneNumber = str_pad($phoneNumber, 10, "0", STR_PAD_LEFT);
                       }
               
                       
                       $create_cari_code = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
                       if(!is_numeric($citizen_id))
                       {
                           $identification_number  = 1111111111;
                       }else{
                           $identification_number = $citizen_id;
                       }
                       $cari_data = [
                           'user_id' => session()->get('user_id'),
                           'money_unit_id' => 3,
                           'cari_code' => $create_cari_code,
                           'identification_number' => $identification_number,
                           'tax_administration' => $tax_office != '' ? $tax_office : null,
                           'invoice_title' => $new_data_form['invoice_title'],
                           'name' => $new_data_form['name'],
                           'surname' => $new_data_form['surname'],
                           'obligation' => $new_data_form['obligation'] != '' ? $new_data_form['obligation'] : null,
                           'company_type' => $new_data_form['company_type'] != '' ? $new_data_form['company_type'] : null ,
                           'cari_phone' => $phoneNumber,
                           'cari_email' => $email != '' ? $email : null,
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
                           'address_email' => $email != '' ? $email : null,
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






                  
           
       

                  

                   $musteriMail = $email;
                   $is_customer = 1;
                   $is_supplier = 0;
                   $is_export_customer  = 0;



                   $siparisTarih = $siparis_tarihi;

                   $dateTime = new \DateTime($siparisTarih);

                   // Yeni tarih ve saat formatı
                   $new_data_form['order_date'] = $dateTime->format('Y-m-d');
                   $new_data_form['order_time'] = $dateTime->format('H:i');

                   $data_order_amounts['amount_to_be_paid'] = $siparis["total"];
      
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


                       $is_deadline  = 0;
                       $d_date = Date("Y-m-d");

                       if($order["status"] == "shipped"){
                           $status_degeri = "kargolandi";
                       }else if($order["status"] == "pending"){
                           $status_degeri = "pending";
                       }else if($order["status"] == "waiting_shipment"){
                           $status_degeri = "kargo_bekliyor";
                       }else if($order["status"] == "cancelled"){
                           $status_degeri = "failed";
                       }
                       else if($order["status"] == "undefined"){
                           $status_degeri = "failed";
                       }
                       else {
                           $status_degeri = "new";
                       }

                       


                      
                   


                       $b2bText.= "<div> Sipariş: <b style='    text-transform: uppercase;'>Dopigo</b>  Platform:  <b style='    text-transform: uppercase;' ><span style='font-weight: bold; '>  ".$service_name."</span></b> <br> Sipariş Numarası :  <b><span style='font-weight: bold;'>".$order["id"]." </span></b>  <br>";
                       $b2bText.="Sipariş Tarihi : <b>" . $order_date . " " . $order_time . "</b></div>"; 

         
          
       
                       $cari_id = $CariSorgula['cari_id'];
                   
       
                       $order_note_id = 0;
                       $order_note = $order["notes"];

                       if(empty($order['discount']))
                       {
                           $order['discount'] = 0;
                       }   



                   
                     

                
                   
                       $insert_order_data = [
                           'user_id' => session()->get('user_id'),
                           'money_unit_id' => 3,
                           'order_direction' => 'incoming',
                           'order_no' => $transaction_prefix,
                           'order_numara' => $order["service_value"],
                           'order_date' => $siparis_tarihi,
                           'b2b' => $b2bText,
                           'dopigo' => $order["id"],
                           'order_note_id' => 0,
                           'order_note' => $order_note,
       
                           'is_deadline' => $is_deadline,
                           'deadline_date' => $d_date,
       
                           'currency_amount' => 0,
       
                           'stock_total' => $order['total'],
                           'stock_total_try' => $order['total'],
       
                           'discount_total' => $order['discount'],
                           'discount_total_try' => $order['discount'],
       
                           'tax_rate_1_amount' => convert_number_for_sql(0),
                           'tax_rate_1_amount_try' => convert_number_for_sql(0),
                           'tax_rate_10_amount' => convert_number_for_sql(0),
                           'tax_rate_10_amount_try' => convert_number_for_sql(0),
                           'tax_rate_20_amount' => convert_number_for_sql(0),
                           'tax_rate_20_amount_try' => convert_number_for_sql(0),
       
                           'sub_total' => $order['total'],
                           'sub_total_try' => $order['total'],
                           'sub_total_0' => convert_number_for_sql(0),
                           'sub_total_0_try' => convert_number_for_sql(0),
                           'sub_total_1' => convert_number_for_sql(0),
                           'sub_total_1_try' => convert_number_for_sql(0),
                           'sub_total_10' => convert_number_for_sql(0),
                           'sub_total_10_try' => convert_number_for_sql(0),
                           'sub_total_20' => convert_number_for_sql(0),
                           'sub_total_20_try' => convert_number_for_sql(0),
       
                           'grand_total' => $order['total'],
                           'grand_total_try' => $order['total'],
       
                           'amount_to_be_paid' => $order['total'],
                           'amount_to_be_paid_try' => $order['total'],
       
                           'amount_to_be_paid_text' => $this->yaziyaCevir($order["total"]),
       
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
       
                           'address_city' => $order['shipping_address']['city'],
                           'address_city_plate' => isset($cari_item['address_city_plate']) ? $cari_item['address_city_plate'] : "",
                           'address_district' => $order['shipping_address']['district'],
                           'address_zip_code' => $order['shipping_address']['zip_code'],
                           'address' => $order['shipping_address']['full_address'],
       
                           'order_status' => $status_degeri,
                           'service_name' => $order["service_name"],
                           'service_logo' => $order["service_logo"],
                           'shipped_date' => $order["shipped_date"] ?? '',
                           'kargo_kodu'   => $kargo_kodu,
                           'kargo' => $this->DopigoKargo($kargosu),
                           'failed_reason' => "",
                           'dopigo_data' => json_encode($order)
                       ];




                 
                       $this->modelOrder->insert($insert_order_data);
                       $order_id = $this->modelOrder->getInsertID();

                      

                    

                   
                   
           
            
       
                       foreach ($order_rows as $data_order_row) {
                       

                         
                                           
                                                $dopigoQuery = $this->modelDopigoEslestir
                                               ->where("silindi", 0)
                                               ->groupStart()
                                               
                                               // ->where("dopigo_id", $data_order_row["linked_product_id"])
                                                   ->orWhere('dopigo_title', $data_order_row['urun_adi'])
                                                   ->orWhere('stock_title', $data_order_row['stock_title']);

                                           // Eğer linked_product_foreign_sku boş değilse, koşula ekle
                                           if (!empty($data_order_row["linked_product_foreign_sku"])) {
                                               $dopigoQuery->orWhere('dopigo_code', $data_order_row['linked_product_foreign_sku']);
                                           }


                                           if (!empty($data_order_row["linked_product_id"]) || $data_order_row["linked_product_id"] != 0) {
                                               $dopigoQuery->orWhere('dopigo_id', $data_order_row['linked_product_id']);
                                           }

                                          


                                           $dopigoEslesenlers = $dopigoQuery
                                               ->groupEnd()
                                               ->get()
                                               ->getRowArray();

                                           // Boşsa modelStock ile eşleşme yap
                                           if (empty($dopigoEslesenlers)) {
                                               $stockQuery = $this->modelStock
                                                   ->groupStart()
                                                       ->where("stock_code", $data_order_row['sku']);

                                               // linked_product_foreign_sku boş değilse modelStock sorgusuna ekle
                                               if (!empty($data_order_row["linked_product_foreign_sku"])) {
                                                   $stockQuery->orWhere('stock_code', $data_order_row['linked_product_foreign_sku']);
                                               }
                                               if (!empty($data_order_row["sku"])) {
                                                   $stockQuery->orWhere('stock_code', $data_order_row['sku']);
                                               }

                                               $dopigoEslesenler = $stockQuery
                                                   ->groupEnd()
                                                   ->get()
                                                   ->getRowArray();
                                           } else {
                                               $dopigoEslesenler = $dopigoEslesenlers;
                                           }

                           // Stok bilgilerini almak

                        
                           if (!empty($dopigoEslesenler)  && isset($dopigoEslesenler['stock_id'])) {

                            $stokBilgileri = $this->modelStock->where('stock_id', $dopigoEslesenler['stock_id'])->where('deleted_at IS NULL', null, false)->first();

                            

                               



                                       if(!empty($data_order_row["linked_product_id"])):
                                       $this->modelStock->set("dopigo", $data_order_row["linked_product_id"])->where("stock_id", $stokBilgileri['stock_id'])->update();
                                       endif;

                                       if($stokBilgileri["paket"] == 1){
                                           $paket = 1;
                                       }else{
                                           $paket = 0;
                                       }
                              
                               
                                       $insert_order_row_data = [
                                           'user_id' => session()->get('user_id'),
                                           'order_id' => $siparis["order_id"],
                                           'stock_id' => $stokBilgileri['stock_id'],
                                           'stock_title' => $stokBilgileri['stock_title'],
                                           'dopigo_title' => $data_order_row['stock_title'],
                                           'stock_amount' => $data_order_row['adet'],
                                           'stock_total_quantity' => $stokBilgileri['stock_total_quantity'],
                                           'unit_id' => 1,
                                           'unit_price' => $data_order_row['price'],
                                           'discount_rate' => 0, //$order['iskonto_oran'],
                                           'discount_price' => $order['discount'],
                                           'subtotal_price' => $data_order_row['price'],
                                           'tax_id' => 0,
                                           'paket'  => $paket,
                                           'dopigo' => $data_order_row["linked_product_id"],
                                           'dopigo_sku' => $data_order_row["linked_product_foreign_sku"] ?? '',
                                           'tax_price' => 0,
                                           'total_price' => $data_order_row['price'],
                                       ];
                                       $this->modelOrderRow->insert($insert_order_row_data);


                                       if($stokBilgileri["paket"]  == 1){


                                               $receteBul = $this->modelStockRecipe->where("stock_id", $stokBilgileri["stock_id"])->first();

                                               $StoklariBul = $this->modelRecipeItem->where("recipe_id", $receteBul["recipe_id"])->findAll();

                                               if($StoklariBul){

                                                   foreach($StoklariBul as $stoks){

                                                       $stok = $this->modelStock->where("stock_id", $stoks["stock_id"])->first();


                                                       $insert_order_row_data = [
                                                           'user_id' => session()->get('user_id'),
                                                           'order_id' => $siparis["order_id"],
                                                           'stock_id' => $stok['stock_id'],
                                                           'stock_title' => $stok['stock_title'],
                                                           'dopigo_title' => $stok['stock_title'],
                                                           'stock_amount' => $data_order_row['adet'],
                                                           'stock_total_quantity' => $stok['stock_total_quantity'],
                                                           'unit_id' => 1,
                                                           'unit_price' => 0,
                                                           'discount_rate' => 0, //$order['iskonto_oran'],
                                                           'discount_price' => 0,
                                                           'subtotal_price' => 0,
                                                           'tax_id' => 0,
                                                           'paket'  => 0,
                                                           'dopigo' => $stok["dopigo"],
                                                           'dopigo_sku' => $stok["stock_code"],
                                                           'tax_price' => 0,
                                                           'total_price' => 0,
                                                           'paket_text' => "Bu satırlar #" . $stokBilgileri["stock_id"] . " idli ürünün paket içeriğindeki ürünlerden birisidir.",
                                                       ];
                                                       $this->modelOrderRow->insert($insert_order_row_data);




                                                   }

                                               }


                                       }
                                 
                               
                               
                       
                      
                           }else{

                               

                            /*   echo "DOPİGO BİLGİLERİ  BAŞLANGIÇ<br>";
                               echo '<pre>';
                               print_r($data_order_row);
                               print_r($order);
                               echo '</pre>';
                               echo "DOPİGO BİLGİLERİ  BİTİŞ<br>";
*/
                       

                               $insert_order_row_data = [
                                   'user_id' => session()->get('user_id'),
                                   'order_id' => $siparis["order_id"],
                                   'stock_id' => 0,
                                   'stock_title' => $data_order_row['stock_title'],
                                   'dopigo_title' => $data_order_row['stock_title'],
                                   'stock_amount' => $data_order_row['adet'],
                                   'stock_total_quantity' => 0,
                                   'unit_id' => 1,
                                   'unit_price' => $data_order_row['price'],
                                   'discount_rate' => 0, //$order['iskonto_oran'],
                                   'discount_price' => $order['discount'],
                                   'subtotal_price' => $data_order_row['price'],
                                   'tax_id' => 0,
                                   'paket'  => 0,
                                   'dopigo' => $data_order_row["linked_product_id"],
                                   'dopigo_sku' => $data_order_row["linked_product_foreign_sku"],
                                   'tax_price' => 0,
                                   'total_price' => $data_order_row['price'],
                               ];
                               $this->modelOrderRow->insert($insert_order_row_data);

                           }
                       }
                       
                   
                      /* echo "DOPİGO BİLGİLERİ  BAŞLANGIÇ<br>";
                       echo '<pre>';
                       print_r($order);
                       echo '</pre>';
                       echo "DOPİGO BİLGİLERİ  BİTİŞ<br>"; */
         
       
                
                   } catch (\Exception $e) {
                       // Hata detaylarını almak
                       $errorLine = $e->getLine(); // Hata satırı
                       $errorFile = $e->getFile(); // Hata dosyası
                   
                       // Log kaydı oluşturma
                       $this->logClass->save_log(
                           'error',
                           'order',
                           null,
                           null,
                           'create',
                           $e->getMessage() . " in " . $errorFile . " on line " . $errorLine,
                           json_encode($_POST)
                       );
                   
                       // Hata mesajını ve satır numarasını JSON olarak döndürme
                       echo json_encode([
                           'icon' => 'error',
                           'message' => $e->getMessage(),
                           'file' => $errorFile,
                           'line' => $errorLine,
                       ]);
                       return;
                   }
               
         
             } else{


                $shipment_provider = isset($order["items"]["shipment_provider"]) ? $order["items"]["shipment_provider"] : 'Undefined';

                $transaction_prefix = "DPG" . $order["id"];
                $modelStock = $this->modelOrder->where("order_no", $transaction_prefix)->first();
                $orderBul = $this->modelOrder->where( 'order_numara', $order["service_value"])->first();

               
                   
                $data_up = [];

                   if($order["status"] == "shipped"){
                       $status_degeri = "kargolandi";
                   }else if($order["status"] == "pending"){
                       $status_degeri = "pending";
                   }else if($order["status"] == "waiting_shipment"){
                       $status_degeri = "kargo_bekliyor";
                   }else if($order["status"] == "cancelled"){
                       $status_degeri = "failed";
                   }
                   else if($order["status"] == "undefined"){
                       $status_degeri = "failed";
                   }
                   else {
                       $status_degeri = "new";
                   }
                   if(isset($orderBul["order_status"])){
                       if ($orderBul["order_status"] != "sevk_edildi" && $orderBul["order_status"] != "sevk_emri") {
                           $data_up["order_status"] = $status_degeri;
                       } else {
                           $data_up["order_status"] = $orderBul["order_status"];
                       }
                   }else{
                       $data_up["order_status"] = $status_degeri;

                   }

                 
                 
                   $data_up['order_numara'] = $order["service_value"];
                   $data_up['service_name'] = $order["service_name"];
                   $data_up['service_logo'] = $order["service_logo"];
                   $data_up['shipped_date'] = $order["shipped_date"];
                   $data_up['kargo_kodu'] = $kargo_kodu;
                   $data_up['kargo'] = $this->DopigoKargo($kargosu);
                   $data_up['address_city'] = $order['shipping_address']['city'];
                   $data_up['address_district'] = $order['shipping_address']['district'];
                   $data_up['address_zip_code'] = $order['shipping_address']['zip_code'];

               
                   
                   $modelUp = $this->modelOrder->set($data_up)->where("order_id", $modelStock["order_id"])->update();
                   

            


                    } 
                    foreach ($order_rows as $data_order_row) {
                       

                        $satirSorgula = $this->modelOrderRow->where("order_id", $orderBul["order_id"])->where("dopigo_title", $data_order_row['stock_title'])->first();
                        

                      
    
                        if (!$satirSorgula) {
                        

    
                            $dopigoQuery = $this->modelDopigoEslestir
                            ->where("silindi", 0)
                            ->groupStart()
                            
                            // ->where("dopigo_id", $data_order_row["linked_product_id"])
                                ->orWhere('dopigo_title', $data_order_row['urun_adi'])
                                ->orWhere('stock_title', $data_order_row['stock_title']);
         
                        // Eğer linked_product_foreign_sku boş değilse, koşula ekle
                        if (!empty($data_order_row["linked_product_foreign_sku"])) {
                            $dopigoQuery->orWhere('dopigo_code', $data_order_row['linked_product_foreign_sku']);
                        }
         
         
                        if (!empty($data_order_row["linked_product_id"]) || $data_order_row["linked_product_id"] != 0) {
                            $dopigoQuery->orWhere('dopigo_id', $data_order_row['linked_product_id']);
                        }
         
                       
         
         
                        $dopigoEslesenlers = $dopigoQuery
                            ->groupEnd()
                            ->get()
                            ->getRowArray();
         
                        // Boşsa modelStock ile eşleşme yap
                        if (empty($dopigoEslesenlers)) {
                            $stockQuery = $this->modelStock
                                ->groupStart()
                                    ->where("stock_code", $data_order_row['sku']);
         
                            // linked_product_foreign_sku boş değilse modelStock sorgusuna ekle
                            if (!empty($data_order_row["linked_product_foreign_sku"])) {
                                $stockQuery->orWhere('stock_code', $data_order_row['linked_product_foreign_sku']);
                            }
                            if (!empty($data_order_row["sku"])) {
                                $stockQuery->orWhere('stock_code', $data_order_row['sku']);
                            }
         
                            $dopigoEslesenler = $stockQuery
                                ->groupEnd()
                                ->get()
                                ->getRowArray();
                        } else {
                            $dopigoEslesenler = $dopigoEslesenlers;
                        }
                     
                        
         // Stok bilgilerini almak
      
         

         if (!empty($dopigoEslesenler) && !empty($dopigoEslesenler['stock_id'])) {
         

            $stokBilgileri = $this->modelStock->where('stock_id', $dopigoEslesenler['stock_id'])->where('deleted_at IS NULL', null, false)->first();
            if(isset($stokBilgileri)){
         
            
         
         
                    if(!empty($data_order_row["linked_product_id"])):
                    $this->modelStock->set("dopigo", $data_order_row["linked_product_id"])->where("stock_id", $stokBilgileri['stock_id'])->update();
                    endif;
         
                    if($stokBilgileri["paket"] == 1){
                        $paket = 1;
                    }else{
                        $paket = 0;
                    }
           
            
                    $insert_order_row_data = [
                        'user_id' => session()->get('user_id'),
                        'order_id' => $orderBul["order_id"],
                        'stock_id' => $stokBilgileri['stock_id'],
                        'stock_title' => $stokBilgileri['stock_title'],
                        'dopigo_title' => $data_order_row['stock_title'],
                        'stock_amount' => $data_order_row['adet'],
                        'stock_total_quantity' => $stokBilgileri['stock_total_quantity'],
                        'unit_id' => 1,
                        'unit_price' => $data_order_row['price'],
                        'discount_rate' => 0, //$order['iskonto_oran'],
                        'discount_price' => 0,
                        'subtotal_price' => $data_order_row['price'],
                        'tax_id' => 0,
                        'paket'  => $paket,
                        'dopigo' => $data_order_row["linked_product_id"],
                        'dopigo_sku' => $data_order_row["linked_product_foreign_sku"] ?? '',
                        'tax_price' => 0,
                        'total_price' => $data_order_row['price'],
                    ];
                    $this->modelOrderRow->insert($insert_order_row_data);
         
         
                    if($stokBilgileri["paket"]  == 1){
         
         
                            $receteBul = $this->modelStockRecipe->where("stock_id", $stokBilgileri["stock_id"])->first();
         
                            $StoklariBul = $this->modelRecipeItem->where("recipe_id", $receteBul["recipe_id"])->findAll();
         
                            if($StoklariBul){
         
                                foreach($StoklariBul as $stoks){
         
                                    $stok = $this->modelStock->where("stock_id", $stoks["stock_id"])->first();
         
         
                                    $insert_order_row_data = [
                                        'user_id' => session()->get('user_id'),
                                        'order_id' => $orderBul["order_id"],
                                        'stock_id' => $stok['stock_id'],
                                        'stock_title' => $stok['stock_title'],
                                        'dopigo_title' => $stok['stock_title'],
                                        'stock_amount' => $data_order_row['adet'],
                                        'stock_total_quantity' => $stok['stock_total_quantity'],
                                        'unit_id' => 1,
                                        'unit_price' => 0,
                                        'discount_rate' => 0, //$order['iskonto_oran'],
                                        'discount_price' => 0,
                                        'subtotal_price' => 0,
                                        'tax_id' => 0,
                                        'paket'  => 0,
                                        'dopigo' => $stok["dopigo"],
                                        'dopigo_sku' => $stok["stock_code"],
                                        'tax_price' => 0,
                                        'total_price' => 0,
                                        'paket_text' => "Bu satırlar #" . $stokBilgileri["stock_id"] . " idli ürünün paket içeriğindeki ürünlerden birisidir.",
                                    ];
                                    $this->modelOrderRow->insert($insert_order_row_data);
         
         
         
         
                                }
         
                            }
         
         
                    }
              
            
                }else{


            $insert_order_row_data = [
                'user_id' => session()->get('user_id'),
                'order_id' => $orderBul["order_id"],
                'stock_id' => 0,
                'stock_title' => $data_order_row['stock_title'],
                'dopigo_title' => $data_order_row['stock_title'],
                'stock_amount' => $data_order_row['adet'],
                'stock_total_quantity' => 0,
                'unit_id' => 1,
                'unit_price' => $data_order_row['price'],
                'discount_rate' => 0, //$order['iskonto_oran'],
                'discount_price' => 0,
                'subtotal_price' => $data_order_row['price'],
                'tax_id' => 0,
                'paket'  => 0,
                'dopigo' => $data_order_row["linked_product_id"],
                'dopigo_sku' => $data_order_row["linked_product_foreign_sku"],
                'tax_price' => 0,
                'total_price' => $data_order_row['price'],
            ];
            $this->modelOrderRow->insert($insert_order_row_data);

                }
         
         
         }else{
         
            
         
         /*   echo "DOPİGO BİLGİLERİ  BAŞLANGIÇ<br>";
            echo '<pre>';
            print_r($data_order_row);
            print_r($order);
            echo '</pre>';
            echo "DOPİGO BİLGİLERİ  BİTİŞ<br>";
         */
         
         
            $insert_order_row_data = [
                'user_id' => session()->get('user_id'),
                'order_id' => $orderBul["order_id"],
                'stock_id' => 0,
                'stock_title' => $data_order_row['stock_title'],
                'dopigo_title' => $data_order_row['stock_title'],
                'stock_amount' => $data_order_row['adet'],
                'stock_total_quantity' => 0,
                'unit_id' => 1,
                'unit_price' => $data_order_row['price'],
                'discount_rate' => 0, //$order['iskonto_oran'],
                'discount_price' => 0,
                'subtotal_price' => $data_order_row['price'],
                'tax_id' => 0,
                'paket'  => 0,
                'dopigo' => $data_order_row["linked_product_id"],
                'dopigo_sku' => $data_order_row["linked_product_foreign_sku"],
                'tax_price' => 0,
                'total_price' => $data_order_row['price'],
            ];
            $this->modelOrderRow->insert($insert_order_row_data);
         
         }
    
    
                        }
                             
                                               
                            
                       }
           
           }else{

            echo "2.kısımbyra";
                   $shipment_provider = isset($order["items"]["shipment_provider"]) ? $order["items"]["shipment_provider"] : 'Undefined';

                   $transaction_prefix = "DPG" . $order["id"];
                   $modelStock = $this->modelOrder->where("order_no", $transaction_prefix)->first();

                   
                   $data_up = [];


                   if($order["status"] == "shipped"){
                       $status_degeri = "kargolandi";
                   }else if($order["status"] == "pending"){
                       $status_degeri = "pending";
                   }else if($order["status"] == "waiting_shipment"){
                       $status_degeri = "kargo_bekliyor";
                   }else if($order["status"] == "cancelled"){
                       $status_degeri = "failed";
                   }
                   else if($order["status"] == "undefined"){
                       $status_degeri = "failed";
                   }
                   else {
                       $status_degeri = "new";
                   }

             
                   if(isset($modelStock["order_status"])){
                       if ($modelStock["order_status"] != "sevk_edildi" && $modelStock["order_status"] != "sevk_emri" ) {
                           $data_up["order_status"] = $status_degeri;
                       } else {
                           $data_up["order_status"] = $modelStock["order_status"];
                       }
                   }else{
                       $data_up["order_status"] = $status_degeri;

                   }
                   
                   $data_up['service_name'] = $order["service_name"];
                   $data_up['order_numara'] = $order["service_value"];
                   $data_up['service_logo'] = $order["service_logo"];
                   $data_up['shipped_date'] = $order["shipped_date"];
                   $data_up['kargo_kodu'] = $kargo_kodu;
                   $data_up['kargo'] = $this->DopigoKargo($kargosu);
                   $data_up['address_city'] = $order['shipping_address']['city'];
                   $data_up['address_district'] = $order['shipping_address']['district'];
                   $data_up['address_zip_code'] = $order['shipping_address']['zip_code'];
                   
                   $modelUp = $this->modelOrder->set($data_up)->where("dopigo", $order["id"])->update();


                   
                   $orderBul = $this->modelOrder->where( 'order_numara', $order["service_value"])->first();

                      
                   foreach ($order_rows as $data_order_row) {
                       

                    $satirSorgula = $this->modelOrderRow->where("order_id", $orderBul["order_id"])->where("dopigo_title", $data_order_row['stock_title'])->first();
                    
                

                    if (!$satirSorgula) {
             

                        $dopigoQuery = $this->modelDopigoEslestir
                        ->where("silindi", 0)
                        ->groupStart()
                        
                        // ->where("dopigo_id", $data_order_row["linked_product_id"])
                            ->orWhere('dopigo_title', $data_order_row['urun_adi'])
                            ->orWhere('stock_title', $data_order_row['stock_title']);
     
                    // Eğer linked_product_foreign_sku boş değilse, koşula ekle
                    if (!empty($data_order_row["linked_product_foreign_sku"])) {
                        $dopigoQuery->orWhere('dopigo_code', $data_order_row['linked_product_foreign_sku']);
                    }
     
     
                    if (!empty($data_order_row["linked_product_id"]) || $data_order_row["linked_product_id"] != 0) {
                        $dopigoQuery->orWhere('dopigo_id', $data_order_row['linked_product_id']);
                    }
     
                   
     
     
                    $dopigoEslesenlers = $dopigoQuery
                        ->groupEnd()
                        ->get()
                        ->getRowArray();
     
                    // Boşsa modelStock ile eşleşme yap
                    if (empty($dopigoEslesenlers)) {
                        $stockQuery = $this->modelStock
                            ->groupStart()
                                ->where("stock_code", $data_order_row['sku']);
     
                        // linked_product_foreign_sku boş değilse modelStock sorgusuna ekle
                        if (!empty($data_order_row["linked_product_foreign_sku"])) {
                            $stockQuery->orWhere('stock_code', $data_order_row['linked_product_foreign_sku']);
                        }
                        if (!empty($data_order_row["sku"])) {
                            $stockQuery->orWhere('stock_code', $data_order_row['sku']);
                        }
     
                        $dopigoEslesenler = $stockQuery
                            ->groupEnd()
                            ->get()
                            ->getRowArray();
                    } else {
                        $dopigoEslesenler = $dopigoEslesenlers;
                    }

                  
     
     // Stok bilgilerini almak
     $stokBilgileri = $this->modelStock->where('stock_id', $dopigoEslesenler['stock_id'])->where('deleted_at IS NULL', null, false)->first();
     
     if (!empty($dopigoEslesenler) && !empty($stokBilgileri) && isset($dopigoEslesenler['stock_id'])) {
     
     
     

        
     
     
     
                if(!empty($data_order_row["linked_product_id"])):
                $this->modelStock->set("dopigo", $data_order_row["linked_product_id"])->where("stock_id", $stokBilgileri['stock_id'])->update();
                endif;
     
                if($stokBilgileri["paket"] == 1){
                    $paket = 1;
                }else{
                    $paket = 0;
                }
       
        
                try {
                    $insert_order_row_data = [
                        'user_id' => session()->get('user_id'),
                        'order_id' => $siparis["order_id"],
                        'stock_id' => $stokBilgileri['stock_id'],
                        'stock_title' => $stokBilgileri['stock_title'],
                        'dopigo_title' => $data_order_row['stock_title'],
                        'stock_amount' => $data_order_row['adet'],
                        'stock_total_quantity' => $stokBilgileri['stock_total_quantity'],
                        'unit_id' => 1,
                        'unit_price' => $data_order_row['price'],
                        'discount_rate' => 0, //$order['iskonto_oran'],
                        'discount_price' => $order['discount'] ?? 0,
                        'subtotal_price' => $data_order_row['price'],
                        'tax_id' => 0,
                        'paket'  => $paket,
                        'dopigo' => $data_order_row["linked_product_id"],
                        'dopigo_sku' => $data_order_row["linked_product_foreign_sku"] ?? '',
                        'tax_price' => 0,
                        'total_price' => $data_order_row['price'],
                    ];
                    
                    $inserted = $this->modelOrderRow->insert($insert_order_row_data);
                    
                    if (!$inserted) {
                        throw new \Exception('Sipariş satırı eklenemedi');
                    }else{
                        echo "ekleenn satır _id" . $inserted;
                    }

                } catch (\Exception $e) {
                    log_message('error', 'Sipariş satırı eklenirken hata: ' . $e->getMessage());
                    return false;
                }

                
     
     
                if($stokBilgileri["paket"]  == 1){
     
     
                        $receteBul = $this->modelStockRecipe->where("stock_id", $stokBilgileri["stock_id"])->first();
     
                        $StoklariBul = $this->modelRecipeItem->where("recipe_id", $receteBul["recipe_id"])->findAll();
     
                        if($StoklariBul){
     
                            foreach($StoklariBul as $stoks){
     
                                $stok = $this->modelStock->where("stock_id", $stoks["stock_id"])->first();
     
     
                                $insert_order_row_data = [
                                    'user_id' => session()->get('user_id'),
                                    'order_id' => $order_id,
                                    'stock_id' => $stok['stock_id'],
                                    'stock_title' => $stok['stock_title'],
                                    'dopigo_title' => $stok['stock_title'],
                                    'stock_amount' => $data_order_row['adet'],
                                    'stock_total_quantity' => $stok['stock_total_quantity'],
                                    'unit_id' => 1,
                                    'unit_price' => 0,
                                    'discount_rate' => 0, //$order['iskonto_oran'],
                                    'discount_price' => 0,
                                    'subtotal_price' => 0,
                                    'tax_id' => 0,
                                    'paket'  => 0,
                                    'dopigo' => $stok["dopigo"],
                                    'dopigo_sku' => $stok["stock_code"],
                                    'tax_price' => 0,
                                    'total_price' => 0,
                                    'paket_text' => "Bu satırlar #" . $stokBilgileri["stock_id"] . " idli ürünün paket içeriğindeki ürünlerden birisidir.",
                                ];
                                $this->modelOrderRow->insert($insert_order_row_data);
     
     
     
     
                            }
     
                        }
     
     
                }
          
        
        
     
     
     }else{
     
        
     
     /*   echo "DOPİGO BİLGİLERİ  BAŞLANGIÇ<br>";
        echo '<pre>';
        print_r($data_order_row);
        print_r($order);
        echo '</pre>';
        echo "DOPİGO BİLGİLERİ  BİTİŞ<br>";
     */
  

     
        $insert_order_row_data = [
            'user_id' => session()->get('user_id'),
            'order_id' => $siparis["order_id"],
            'stock_id' => 0,
            'stock_title' => $data_order_row['stock_title'],
            'dopigo_title' => $data_order_row['stock_title'],
            'stock_amount' => $data_order_row['adet'],
            'stock_total_quantity' => 0,
            'unit_id' => 1,
            'unit_price' => $data_order_row['price'],
            'discount_rate' => 0, //$order['iskonto_oran'],
            'discount_price' => $order['discount'] ?? 0,
            'subtotal_price' => $data_order_row['price'],
            'tax_id' => 0,
            'paket'  => 0,
            'dopigo' => $data_order_row["linked_product_id"],
            'dopigo_sku' => $data_order_row["linked_product_foreign_sku"],
            'tax_price' => 0,
            'total_price' => $data_order_row['price'],
        ];
        $this->modelOrderRow->insert($insert_order_row_data);
     
     }


                    }
                         
                                           
                        
                   }




               }
                   

               
           }


           echo json_encode([
            'icon' => 'success',
            'data' => "Siparişiniz Başarıyla Güncellendi!",
         ]);
        return;

 
           

     
     }

       

     public function list()
     {
         // Günlük başarılı/başarısız sipariş sayıları
         $dailyStatsistatistik = $this->db->query("
             SELECT 
                 dc.id,
                 dc.platform,
                 dc.start_date,
                 dc.end_date,
                 DATE(dc.cron_date) as date,
                 dc.status,
                 dc.total_orders,
                 dc.successful_orders as successful,
                 dc.failed_orders as failed,
                 dc.raw_data,
                 SUM(dc.successful_orders) as total_successful,
                 SUM(dc.failed_orders) as total_failed
             FROM dopigo_cron dc
             WHERE dc.cron_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
             ORDER BY dc.cron_date DESC
         ")->getResultArray();
        

         $dailyStats = $this->db->query("
         SELECT 
             dc.id,
             dc.start_date,
             dc.end_date,
             dc.platform,
             DATE(dc.cron_date) as date,
             dc.status,
             dc.total_orders,
             dc.successful_orders as successful,
             dc.failed_orders as failed,
             dc.raw_data
            
         FROM dopigo_cron dc
         WHERE dc.cron_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
         ORDER BY dc.cron_date DESC
     ")->getResultArray();
     
     
    
  

         // En çok karşılaşılan hatalar
         $commonErrors = $this->db->query("
             SELECT 
                 error_message,
                 COUNT(*) as count
             FROM dopigo_cron_logs
             WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
             GROUP BY error_message
             ORDER BY count DESC
             LIMIT 5
         ")->getResultArray();
        
        
         // Başarı oranı trendi
         $successRate = $this->db->query("
         SELECT 
             DATE(cron_date) as date,
             ROUND(
                 (SUM(successful_orders) * 100.0) / 
                 (SUM(successful_orders) + SUM(failed_orders)), 
                 2
             ) as success_rate
         FROM dopigo_cron
         WHERE cron_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
         GROUP BY DATE(cron_date)
         ORDER BY date
     ")->getResultArray();
     if(empty($successRate)){
        $successRate = [[
            'date' => date('Y-m-d'),
            'success_rate' => 0
        ]];
     }
        

        
         $data = [
            'daily_istatistik' => $dailyStatsistatistik,
             'daily_stats' => $dailyStats,
             'common_errors' => $commonErrors,
             'success_rate' => $successRate
         ];
     
         return view('tportal/senkronizasyon/dopigo', $data);
     }
     
     public function getErrorDetails($cronId)
     {
         $errors = $this->db->query("
             SELECT *
             FROM dopigo_cron_logs
             WHERE cron_id = ?
             ORDER BY created_at DESC
         ", [$cronId])->getResultArray();
     
         $html = '<div class="error-details">';
         foreach($errors as $error) {
             $html .= '<div class="error-item mb-3">';
             $html .= '<strong>Sipariş ID:</strong> ' . $error['order_id'] . '<br>';
             $html .= '<strong>Hata Mesajı:</strong> ' . $error['error_message'] . '<br>';
             $html .= '<strong>Tarih:</strong> ' . $error['created_at'] . '<br>';
             if($error['order_data']) {
                 $html .= '<button class="btn btn-sm btn-outline-info mt-2" onclick="toggleOrderData(this)">Sipariş Detayları</button>';
                 $html .= '<pre class="mt-2 d-none">' . json_encode(json_decode($error['order_data'], true), JSON_PRETTY_PRINT) . '</pre>';
             }
             $html .= '</div>';
         }
         $html .= '</div>';
     
         return $this->response->setJSON(['html' => $html]);
     }

     public function siparisWhatsappMesajBasarili($cronId)
     {
         try {
             // Başarılı siparişleri getir (order tablosundan)
          

             $successOrders = $this->db->query("
             SELECT o.*, dc.start_date, dc.end_date, dc.cron_date,
                    o.order_id, o.service_name, o.grand_total_try, o.order_date
             FROM `order` o
             JOIN dopigo_cron dc ON dc.id = ?
             WHERE o.cron_id = ?  -- cronId'yi order_numara ile eşleştir
             AND o.deleted_at IS NULL
             GROUP BY o.order_id
             ORDER BY o.order_date DESC
         ", [$cronId, $cronId])->getResultArray();
         
         if (empty($successOrders)) {
             log_message('info', 'Başarılı sipariş bulunamadı. Order Numara: ' . $cronId);
             return [
                 'status' => false,
                 'message' => 'Bildirilecek başarılı sipariş bulunmamaktadır.'
             ];
         }
           
     
             $mesaj = "📊 *Dopigo Sipariş Raporu*\n\n";
     
             // Tarih bilgisi
             $cronTime = strtotime($successOrders[0]['cron_date']);
             $minutes = date('i', $cronTime);
             $seconds = date('s', $cronTime);
             
             $startDate = date('d.m.Y H', strtotime($successOrders[0]['start_date'])) . ":{$minutes}:{$seconds}";
             $endDate = date('d.m.Y H', strtotime($successOrders[0]['end_date'])) . ":{$minutes}:{$seconds}";
             
             $mesaj .= "📅 Tarih Aralığı: " . $startDate . " - " . $endDate . "\n\n";
             $mesaj .= "✅ *Başarılı Siparişler:*\n\n";
     
             // Platform bazlı gruplandırma için array
             $platformOrders = [];
             $totalAmount = 0;
     
             foreach ($successOrders as $order) {
                 $platform = $order['service_name'] ?? 'Diğer';
                 if (!isset($platformOrders[$platform])) {
                     $platformOrders[$platform] = [
                         'count' => 0,
                         'total' => 0
                     ];
                 }
                 $platformOrders[$platform]['count']++;
                 $platformOrders[$platform]['total'] += $order['grand_total_try'];
                 $totalAmount += $order['grand_total_try'];
             }
     
             // Platform bazlı özet
             foreach ($platformOrders as $platform => $data) {
                 $mesaj .= "🛍️ *{$platform}*\n";
                 $mesaj .= "📦 Sipariş Sayısı: " . $data['count'] . "\n";
                 $mesaj .= "\n";
             }
     
             $mesaj .= "📈 *Genel Toplam*\n";
             $mesaj .= "📦 Toplam Sipariş: " . count($successOrders) . " adet\n";
     
             // Debug için mesajı loglayalım
             log_message('info', 'WhatsApp Mesajı: ' . $mesaj);
     
             $phone = "5324086232"; //"5324086232"; // Mesajın gönderileceği numara
             
             $curl = curl_init();
             curl_setopt_array($curl, array(
                 CURLOPT_URL => 'http://212.98.224.209:3000/helper/sendWhatsappSms',
                 CURLOPT_RETURNTRANSFER => true,
                 CURLOPT_ENCODING => '',
                 CURLOPT_MAXREDIRS => 10,
                 CURLOPT_TIMEOUT => 30,
                 CURLOPT_FOLLOWLOCATION => true,
                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                 CURLOPT_CUSTOMREQUEST => 'POST',
                 CURLOPT_POSTFIELDS => 'gsm='.$phone.'&text='.urlencode($mesaj),
                 CURLOPT_HTTPHEADER => array(
                     'Content-Type: application/x-www-form-urlencoded'
                 ),
             ));
     
             $response = curl_exec($curl);
             $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
             
             if (curl_errno($curl)) {
                 throw new \Exception('WhatsApp API Hatası: ' . curl_error($curl));
             }
     
             curl_close($curl);
     
             return [
                 'status' => true,
                 'message' => 'WhatsApp bildirimi gönderildi',
                 'response' => $response,
                 'http_code' => $httpCode
             ];
     
         } catch (\Exception $e) {
             log_message('error', 'WhatsApp Mesaj Hatası: ' . $e->getMessage());
             return [
                 'status' => false,
                 'message' => 'WhatsApp bildirimi gönderilemedi: ' . $e->getMessage()
             ];
         }
     }


     public function siparisRaporWhatsApp()
     {
         try {
             // Bugünün başlangıç ve bitiş tarihleri
             $startDate2 = date('Y-m-d');
             $startDate = date('Y-m-d 00:00:00');
             $endDate = date('Y-m-d 23:59:59');
             
             $mesaj = "📊 *Fams Otomotiv Dopigo Günlük Sipariş Raporu*\n\n";
     
             // Tarih bilgisi
             $mesaj .= "📅 * Tarih: " .$startDate2 . "*\n\n";

             
             // Rapor linki - tarihleri URL parametresi olarak ekleyerek
             $encodedStartDate = urlencode(date('Y-m-d'));
             $encodedEndDate = urlencode(date('Y-m-d'));
             $mesaj .= "🔍 *Detaylı Raporu Görüntülemek İçin:*\n";
             $mesaj .= "https://app.tikoportal.com.tr/tportal/siparisler/gunlukrapor?start_date={$encodedStartDate}&end_date={$encodedEndDate}\n\n";
     
             // Alıcı numaralar
             $phones = [
                 "5324086232",
                 "5354162316",
                 '5326407989',
                 '5304005977'
             ];
             
             // Her bir numaraya ayrı ayrı gönderim
             foreach ($phones as $phone) {
                 $curl = curl_init();
                 curl_setopt_array($curl, array(
                     CURLOPT_URL => 'http://212.98.224.209:3000/helper/sendWhatsappSms',
                     CURLOPT_RETURNTRANSFER => true,
                     CURLOPT_ENCODING => '',
                     CURLOPT_MAXREDIRS => 10,
                     CURLOPT_TIMEOUT => 30,
                     CURLOPT_FOLLOWLOCATION => true,
                     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                     CURLOPT_CUSTOMREQUEST => 'POST',
                     CURLOPT_POSTFIELDS => 'gsm=' . $phone . '&text=' . urlencode($mesaj),
                     CURLOPT_HTTPHEADER => array(
                         'Content-Type: application/x-www-form-urlencoded'
                     ),
                 ));
     
                 $response = curl_exec($curl);
                 $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                 
                 if (curl_errno($curl)) {
                     log_message('error', 'WhatsApp API Hatası (' . $phone . '): ' . curl_error($curl));
                 }
     
                 curl_close($curl);
                 
                 // Her gönderim arasında kısa bir bekleme
                 sleep(1);
             }
     
             return [
                 'status' => true,
                 'message' => 'WhatsApp bildirimleri gönderildi',
                 'sent_to' => count($phones) . ' numara'
             ];
     
         } catch (\Exception $e) {
             log_message('error', 'WhatsApp Mesaj Hatası: ' . $e->getMessage());
             return [
                 'status' => false,
                 'message' => 'WhatsApp bildirimi gönderilemedi: ' . $e->getMessage()
             ];
         }
     }

     public function siparisWhatsappMesajHata($cronId)
     {
         try {
             // Başarısız siparişleri getir
             $failedOrders = $this->db->query("
                 SELECT dcl.*, dc.start_date, dc.end_date, dc.cron_date
                 FROM dopigo_cron_logs dcl
                 JOIN dopigo_cron dc ON dc.id = dcl.cron_id
                 WHERE dcl.cron_id = ?
             ", [$cronId])->getResultArray();
     
             if (empty($failedOrders)) {
                 return [
                     'status' => false,
                     'message' => 'Bildirilecek başarısız sipariş bulunmamaktadır.'
                 ];
             }
     
             $mesaj = "🚨 *Dopigo Sipariş Senkronizasyon Bildirimi*\n\n";

             // cron_date'den dakika ve saniyeyi alalım
             $cronTime = strtotime($failedOrders[0]['cron_date']);
             $minutes = date('i', $cronTime);
             $seconds = date('s', $cronTime);
             
             // start_date ve end_date'e aynı dakika ve saniyeyi ekleyelim
             $startDate = date('d.m.Y H', strtotime($failedOrders[0]['start_date'])) . ":{$minutes}:{$seconds}";
             $endDate = date('d.m.Y H', strtotime($failedOrders[0]['end_date'])) . ":{$minutes}:{$seconds}";
             
             $mesaj .= "📅 Tarih Aralığı: " . $startDate . " - " . $endDate . "\n\n";
             $mesaj .= "❌ *Aktarılamayan Siparişler:*\n\n";
     
             foreach ($failedOrders as $order) {
                 $orderData = json_decode($order['order_data'], true);
                 
                 $mesaj .= "📦 *Sipariş No:* " . ($order['order_id'] ?? 'Belirtilmemiş') . "\n";
                 $mesaj .= "🔴 *Hata:* " . $order['error_message'] . "\n";
                 $mesaj .= "\n---------------------------\n\n";
             }
     
             $mesaj .= "⚠️ Toplam " . count($failedOrders) . " adet sipariş aktarılamamıştır.";
     
             // Debug için mesajı loglayalım
             log_message('info', 'WhatsApp Mesajı: ' . $mesaj);
     
             $phone = "5324086232"; //"5324086232"; // Mesajın gönderileceği numara
             
             $curl = curl_init();
             curl_setopt_array($curl, array(
                 CURLOPT_URL => 'http://212.98.224.209:3000/helper/sendWhatsappSms',
                 CURLOPT_RETURNTRANSFER => true,
                 CURLOPT_ENCODING => '',
                 CURLOPT_MAXREDIRS => 10,
                 CURLOPT_TIMEOUT => 30,
                 CURLOPT_FOLLOWLOCATION => true,
                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                 CURLOPT_CUSTOMREQUEST => 'POST',
                 CURLOPT_POSTFIELDS => 'gsm='.$phone.'&text='.urlencode($mesaj),
                 CURLOPT_HTTPHEADER => array(
                     'Content-Type: application/x-www-form-urlencoded'
                 ),
             ));
     
             $response = curl_exec($curl);
             $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
             $error = curl_error($curl);
     
             // Debug için yanıtı loglayalım
             log_message('info', 'WhatsApp API Yanıtı: ' . $response);
             log_message('info', 'HTTP Kodu: ' . $httpCode);
             
             if ($error) {
                 log_message('error', 'cURL Hatası: ' . $error);
                 throw new \Exception('WhatsApp API Hatası: ' . $error);
             }
     
             if ($httpCode !== 200) {
                 throw new \Exception('WhatsApp API Yanıt Kodu: ' . $httpCode);
             }
     
             curl_close($curl);
     
             return [
                 'status' => true,
                 'message' => 'WhatsApp bildirimi gönderildi',
                 'response' => $response,
                 'http_code' => $httpCode
             ];
     
         } catch (\Exception $e) {
             log_message('error', 'WhatsApp Mesaj Hatası: ' . $e->getMessage());
             return [
                 'status' => false,
                 'message' => 'WhatsApp bildirimi gönderilemedi: ' . $e->getMessage()
             ];
         }
     }

     public function getDetails($id)
     {
       
         
         try {
             // Ana kaydı al
             $record = $this->db->query("
                 SELECT 
                     dc.id,
                     dc.start_date,
                     dc.end_date,
                     dc.platform,
                     dc.cron_date,
                     dc.total_orders,
                     dc.successful_orders as successful,
                     dc.failed_orders as failed,
                     dc.status,
                     dc.raw_data
                 FROM dopigo_cron dc
                 WHERE dc.id = ?
             ", [$id])->getRowArray();
     
             if (!$record) {
                 throw new \Exception('Kayıt bulunamadı');
             }
     
             // Hataları al (eğer varsa)
             $errors = $this->db->query("
                 SELECT 
                     error_message as message,
                     COUNT(*) as count
                 FROM dopigo_cron_logs
                 WHERE cron_id = ?
                 GROUP BY error_message
             ", [$id])->getResultArray();
     
             return $this->response->setJSON([
                 'success' => true,
                 'data' => [
                     'successful' => (int)$record['successful'],
                     'failed' => (int)$record['failed'],
                     'total_orders' => (int)$record['total_orders'],
                     'status' => $record['status'],
                     'errors' => $errors,
                     'raw_data' => json_decode($record['raw_data'], true),
                     'platform' => $record['platform'],
                     'start_date' => $record['start_date'],
                     'end_date' => $record['end_date'],
                     'cron_date' => $record['cron_date']
                 ]
             ]);
     
         } catch (\Exception $e) {
             return $this->response->setJSON([
                 'success' => false,
                 'message' => 'Detaylar alınırken bir hata oluştu: ' . $e->getMessage()
             ]);
         }
     }

     public function filter()
{
    $startDate = $this->request->getPost('start_date');
    $endDate = $this->request->getPost('end_date');

    try {
        // Seçilen tarih aralığına göre kayıtları getir
        $records = $this->db->query("
            SELECT 
                dc.id,
                dc.start_date,
                dc.end_date,
                dc.platform,
                DATE(dc.cron_date) as date,
                dc.total_orders,
                dc.successful_orders as successful,
                dc.failed_orders as failed,
                dc.status
            FROM dopigo_cron dc
            WHERE DATE(dc.cron_date) BETWEEN ? AND ?
            ORDER BY dc.cron_date DESC
        ", [$startDate, $endDate])->getResultArray();


        // Günlük istatistikler
        $dailyStats = $this->db->query("
            SELECT 
                DATE(cron_date) as date,
                SUM(successful_orders) as successful,
                SUM(failed_orders) as failed
            FROM dopigo_cron
            WHERE DATE(cron_date) BETWEEN ? AND ?
            GROUP BY DATE(cron_date)
            ORDER BY date ASC
        ", [$startDate, $endDate])->getResultArray();

        // Toplam istatistikler
        $totalSuccessful = array_sum(array_column($records, 'successful'));
        $totalFailed = array_sum(array_column($records, 'failed'));
        $totalOrders = $totalSuccessful + $totalFailed;
        $successRate = $totalOrders > 0 ? ($totalSuccessful / $totalOrders) * 100 : 0;

        $totalPlatforms = array_unique(array_column($records, 'platform'));
        $totalPlatforms = count($totalPlatforms);

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'total_platforms' => $totalPlatforms,
                'records' => $records,
                'daily_stats' => $dailyStats,
                'total_successful' => $totalSuccessful,
                'total_failed' => $totalFailed,
                'success_rate' => number_format($successRate, 2)
            ]
        ]);

    } catch (\Exception $e) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Veriler alınırken bir hata oluştu: ' . $e->getMessage()
        ]);
    }
}



    /**
     * Get alternative stocks.
     */
    public function getAltStoklar($stock_id)
    {
        return $this->modelStock->where("parent_id", $stock_id)->findAll();
    }

    /**
     * Get stock group and variant.
     */
    public function getStockGroupAndVariyant($count, $kategori_id, $property_id, $stok)
    {
        $sutun = "variant_" . $count;
        $stockGroup = $this->modelStockVariantGroup->where("category_id", $kategori_id)
                                                  ->where($sutun, $property_id)
                                                  ->where("stock_id", $stok["stock_id"])
                                                  ->first();
        if ($stockGroup) {
            return $this->modelStock->where('stock_id', $stockGroup['stock_id'])->first();
        }
        return null;
    }

    /**
     * Convert number to words in Turkish.
     */
    public function yaziyaCevir($sayi)
    {
        $birler = ["", "BİR", "İKİ", "ÜÇ", "DÖRT", "BEŞ", "ALTI", "YEDİ", "SEKİZ", "DOKUZ"];
        $onlar = ["", "ON", "YİRMİ", "OTUZ", "KIRK", "ELLİ", "ALTMIŞ", "YETMİŞ", "SEKSEN", "DOKSAN"];
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
}