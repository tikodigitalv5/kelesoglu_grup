<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;

use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;

use function PHPUnit\Framework\returnSelf;

/**
 * @property IncomingRequest $request
 */


class Mytech extends BaseController
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
    private $modelType;
    private $modelCategory;
    private $modelUnit;
    private $modelStockRecipe;
    private $modelStockBarcode;
    private $modelWarehouse;
    private $modelStockGallery;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);
        $this->modelType = model($TikoERPModelPath . '\TypeModel', true, $db_connection);
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

        $this->logClass = new Log();

        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
    }

    public function b2bConnect()
    {
       
        
       
        

        $userDatabaseDetail = [
            'hostname' => '78.135.107.25',
            'username' => 'mytechbilisim_db',
            'password' => 'PuRdZmSxu8D33358fCRc',
            'database' => 'mytechbilisim_db',
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

    private function getStockCode($category_id, $stock_code)
    {
        $category_counter = 0;
    
        if ($stock_code == '') {
            // Kullanıcının seçtiği kategoriyi bul
            $category_item = $this->modelCategory->where('user_id', session()->get('user_id'))->where('category_id', $category_id)->first();
            if (!$category_item) {
                return ['icon' => 'error', 'message' => 'Lütfen geçerli bir kategori seçiniz'];
            } elseif (!$category_item['category_value']) {
                return ['icon' => 'error', 'message' => 'Kategori benzersiz değeri boş olamaz. Lütfen otomatik stok kodu oluşturmadan önce kategori benzersiz kodu tanımlayınız.'];
            }
    
            // Kategoriye ait ürünleri say
            $existing_stock_count = $this->modelStock->where('user_id', session()->get('user_id'))->where('category_id', $category_id)->countAllResults();
    
            // Eğer ürün varsa, category_counter'i mevcut ürün sayısına göre artır
            if ($existing_stock_count > 0) {
                $category_counter = $existing_stock_count + 1;
            } else {
                $category_counter = $category_item['category_counter'] + 1;
            }
    
            // Stok kodunu oluştur
            $stock_code = $category_item['category_value'] . str_pad($category_counter, 5, '0', STR_PAD_LEFT);
    
            // Aynı stok kodu varsa category_counter'i +1 artır
            $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_code', $stock_code)->first();
            if ($stock_item) {
                $category_counter += 1;
                $stock_code = $category_item['category_value'] . str_pad($category_counter, 5, '0', STR_PAD_LEFT);
            }
    
            // Kategori counter'ını güncelle
            $update_category_data = [
                'category_counter' => $category_counter
            ];
            $this->modelCategory->update($category_id, $update_category_data);
    
        } else {
            // Kullanıcı tarafından verilen stok kodu daha önce kullanılmış mı kontrolü
            $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_code', $stock_code)->where('deleted_at IS NOT NULL', null, false)->first();
            if ($stock_item) {
                return ['icon' => 'error', 'message' => 'Bu ürün kodu daha önceden kullanılmış.'];
            }
        }
    
        return ['icon' => 'success', 'value' => $stock_code, 'category_counter' => $category_counter];
    }


    public function MytechProducts(){
        $database = $this->b2bConnect();

        //  echo '<pre>';
          //print_r();
          //echo '</pre>';
  
          $tumUrunler = $database->table('urunlers')
          ->select('*')
          ->get()
          ->getResultArray();

          $eklenen_urun = 0;


     
          

        foreach($tumUrunler as $Excel){

            $Kategorisi = $database->table("kategorilers")
            ->where("id", $Excel["ustkategori"])
            ->get()
            ->getResultArray();
        
        if (!empty($Kategorisi)) {
            $Excel["kategori_baslik"] = $Kategorisi[0]["baslik"];
        } else {
            $Excel["kategori_baslik"] = null; // Eğer kategori bulunamazsa, başlığı null yapabilirsiniz
        }
            $sorgula = $this->modelStock->where("stock_title", $Excel["baslik"])->first();
            if(!$sorgula){
    
                   
                    $stock_type = "product";
                    $has_variant = 0;
                    $tip = "MAMÜL";
                    $StokTipi = $this->modelType->where("type_title", $tip)->first();
                    $type_id = $StokTipi ? $StokTipi["type_id"] : 1;

                    $fiyati = 0;
                    $kategori = $this->modelCategory->where("category_title", $Excel["kategori_baslik"])->first();
                    

                    if(empty($kategori)){

                        $sonCategori = $this->modelCategory
                        ->orderBy('category_id', 'DESC')
                        ->first();

                     if (!empty($Excel["kategori_baslik"])) {
                            // Sesli harfler ve onların yerine geçecek harfler
                            $sesliHarfler = ['A', 'E', 'I', 'İ', 'O', 'Ö', 'U', 'Ü'];
                            $harfDonusum = ['A', 'E', 'I', 'I', 'O', 'O', 'U', 'U'];
                            
                            $kelimeler = explode(' ', $Excel["kategori_baslik"]);
                            $kisaltilmis = '';

                            foreach ($kelimeler as $kelime) {
                                if (!empty($kelime)) {
                                    $ilkHarf = strtoupper($kelime[0]);

                                    // Eğer ilk harf sesli bir harfse, onu dönüştür
                                    if (in_array($ilkHarf, $sesliHarfler)) {
                                        $index = array_search($ilkHarf, $sesliHarfler);
                                        $ilkHarf = $harfDonusum[$index];
                                    }

                                    $kisaltilmis .= $ilkHarf;
                                }
                            }

                            $category_value = $kisaltilmis;
                        } else {
                            $category_value = null; // Kategori başlığı yoksa kısaltma boş olabilir
                        }

                        $form_data = [
                            'user_id' => session()->get('user_id'),
                            'category_title' => $Excel["kategori_baslik"],
                            'category_value' => $category_value,
                            'status' => "active",
                            'order' => ($sonCategori["order"] + 10),
                            'default' => 'false'
                        ];

                        if(!empty($Excel["kategori_baslik"])){

                        $this->modelCategory->insert($form_data);

                        $category_id = $this->modelCategory->getInsertID();
                         }else{
                            $category_id = 0; // Kategorisiz

                         }




                    }else{
                        $category_id = $kategori["category_id"]; // Kategorisiz
                    }

                    $stock_barcode = $this->request->getPost('stock_barcode');
                    $temp_stock_code = $this->getStockCode($category_id, "");
                 

                    if ($temp_stock_code['icon'] == 'success') {
                        $stock_code = $temp_stock_code['value'];
                    } else {
                        echo json_encode($temp_stock_code);
                        return;
                    }


                   
                    $stock_title = $Excel["baslik"];
                    $supplier_stock_code = ""; // Fixed double $
                    $Para = "TRY";
                    $paraTipi = $this->modelMoneyUnit->where("money_code", $Para)->first();
                    $para_type = $paraTipi ? $paraTipi["money_unit_id"] : 1;

                    $birimi = 1;
                    $birimTpye = $this->modelUnit->where("unit_id", $birimi)->first();
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

                    $ManuelStok = "Mytech Ürün Aktarımı/Güncellemesi";



                    $status = "active";
                    $stock_tracking = 0;

                   

                    $buy_unit_price = convert_number_for_sql($buy_unit_price);
                    $buy_unit_price_with_tax = convert_number_for_sql($buy_unit_price_with_tax);
                    $sale_unit_price = convert_number_for_sql($sale_unit_price);
                    $sale_unit_price_with_tax = convert_number_for_sql($sale_unit_price_with_tax);

                    $barcode_number = generate_barcode_number($stock_barcode);
                    $has_variant = $has_variant ? 1 : 0;

                
                    if(!empty($Excel["kapakresmi"])){

                    $uzakSunucuDosya = "https://mytechbilisim.com.tr/upload/urunler/" . $Excel["kapakresmi"]; // Uzak sunucudaki resim dosyasının URL'si
                    $image = "images/uploads/" . $Excel["kapakresmi"]; // Yerel dizine kaydedilecek dosya yolu
                    
                    // Uzak sunucudan dosyayı al
                    $ch = curl_init($uzakSunucuDosya);
                    $fp = fopen($image, 'wb'); // Yerel dosyayı aç
                    
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    
                    curl_exec($ch); // Dosyayı indir
                    
                    if(curl_errno($ch)) {
                        // Eğer bir hata olursa bu kısmı kullanabilirsiniz
                        echo 'Curl error: ' . curl_error($ch);
                    }
                    
                    curl_close($ch);
                    fclose($fp);
                      }else{
                        $image = 'uploads/default.png';
                      }

                    $insert_data = [
                        'parent_id' => 0,
                        'user_id' => session()->get('user_id'),
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
                        'default_image' => $image,
                        'status' => $status,
                        'manuel_add' => $ManuelStok,
                        'has_variant' => $has_variant,
                        'mytech' => $Excel["id"],
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
                    $eklenen_urun++;

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
                        $warehouse_item = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('default', 'true')->first();

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



                


                
                
            }
        }

        echo json_encode(['icon' => 'success', 'eklenen_urun' => $eklenen_urun, 'message' => 'Stok başarıyla oluşturuldu.']);

    }


    public function MytechAddProducts(){

        $database = $this->b2bConnect();

        $ModelStock = $this->modelStock->where("mytech", "")->findAll();
        $count = 0;
        foreach($ModelStock as $Stock){

            if($Stock["status"] == "active"){
                $durum = 1;
            }else{
                $durum = 0;
            }

            $catBul = $this->modelCategory->where("category_id", $Stock["category_id"])->first();


            $cleanTitle = trim($catBul['category_title']);  // Baş ve sondaki boşlukları kaldırır
            $ustKategori = $database->table("kategorilers")->where("baslik", $cleanTitle)->get()->getResultObject();
      
            
            $ustKategoriId = $ustKategori[0]->id;
            
            $newProducts = [
                'sira' => 0,
                'dil' => 'tr',
                'baslik' => $Stock["stock_title"],
                'seflink' => $this->seo_slug($Stock["stock_title"]),
                'modul' => 62,
                'ustkategori' => $ustKategoriId,
                'durum' =>  $durum
            ];
            
            $insert = $database->table("urunlers")->insert($newProducts);
            $sonid = $database->insertID();
           

            if ($insert) {

                // FTP sunucusu bağlantı bilgileri
                $ftp_server = "ftp.mytechbilisim.com.tr";  // FTP sunucusu adresi
                $ftp_user = "app@mytechbilisim.com.tr";    // FTP kullanıcı adı
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
            
                        } else {
                            //echo "Dosya yüklenemedi: " . $local_file . "<br>";
                        }
                    }
            
                    // FTP bağlantısını kapat
                    ftp_close($ftp_conn);
                }
            
                // Ana görseli yükleme ve veritabanına kaydetme
                $local_file = FCPATH . $Stock["default_image"];
                if (file_exists($local_file)) {
                    $ftp_conn = ftp_connect($ftp_server);
                    if ($ftp_conn && ftp_login($ftp_conn, $ftp_user, $ftp_pass) && ftp_pasv($ftp_conn, true)) {
                        $remote_file = basename($local_file);
                        if (ftp_put($ftp_conn, $remote_file, $local_file, FTP_BINARY)) {
                            //echo "Ana görsel başarılı bir şekilde yüklendi: " . $remote_file . "<br>";
                            $UrunGuncelle = $database->table("urunlers")->set("kapakresmi", $remote_file)->where("id", $sonid)->update();
                        }
                        ftp_close($ftp_conn);
                    }
                }
            
                $count++;

                $UrunGuncelle = $this->modelStock->set("mytech", $sonid)->where("stock_id", $Stock["stock_id"])->update();

            }
        }



        if($count > 0){
            echo json_encode(['icon' => 'success', 'message' => 'Toplam <b>'.$count.' </b> Adet Ürün Mytech Sitesine Aktarıldı.']);
        }else{
            echo json_encode(['icon' => 'info', 'message' => 'Mytech sitesine aktarılacak ürün yoktur.']);

        }

        

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


   


}
