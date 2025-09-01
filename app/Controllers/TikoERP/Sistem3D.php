<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;

use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;

use function PHPUnit\Framework\returnSelf;

/**
 * @property IncomingRequest $request
 */


class Sistem3D extends BaseController
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
            'hostname' => '45.143.99.171',
            'username' => '3us',
            'password' => 'Ber0g101@',
            'database' => '3db',
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


   




    public function Sistem3DAddProducts(){
        try {
            // Veritabanı bağlantısı
            $database = $this->b2bConnect();
            
            // sistem3d alanı NULL olan tüm ürünleri al
            $ModelStock = $this->modelStock->where('sistem3d', null)->findAll();
            $count = 0;
            $bb = 0;
            $urun_id = 0;
            foreach ($ModelStock as $Stock) {
                 // Ürün durumunu belirle
            $durum = ($Stock["status"] == "active") ? 1 : 0;

            // Kategori sorgulama
            $catBul = $this->modelCategory->where("category_id", $Stock["category_id"])->first();
            if (!$catBul) {
                throw new \Exception('Kategori bulunamadı.');
            }

            $cleanTitle = trim($catBul['category_title']); // Baş ve sondaki boşlukları kaldır
            $diller = $database->table("opt_site_diller")->get()->getResultArray();
            $para_birimler = $database->table('opt_para_birimleri')->get()->getResultArray();
            $i = 0;

            // Kategoriyi tam olarak sorgulama
            $kategoriSorgula = $database->table("opt_urun_kategoriler")
                                        ->where("adi", $catBul['category_title'])
                                        ->get()->getFirstRow(); // Sadece ilk satırı al

            // Eğer kategori yoksa yeni ekleme işlemi yap
            if (!$kategoriSorgula || $kategoriSorgula == '') {
                $data_kategori = [
                    'adi'   => $catBul['category_title'],
                    'sira'  => $bb * 10,
                    'aktif' => 1,
                    'kodu'  => $this->seo_slug($catBul["category_title"])
                ];
                
                // Yeni kategori ekle
                $database->table('opt_urun_kategoriler')->insert($data_kategori);
                $kategori_id = $database->insertID();

                // Alt kategori ekle
                $data_kategori_alt = [
                    'adi'   => $catBul['category_title'],
                    'sira'  => $bb * 10,
                    'deger' => $kategori_id,
                    'kodu'  => $this->seo_slug($catBul["category_title"])
                ];
                $database->table('opt_urun_kategoriler_alt')->insert($data_kategori_alt);
            } else {
                // Eğer kategori zaten varsa, ID'yi al
                $kategori_id = $kategoriSorgula->id;
                $kategoriSorgula = $database->table("opt_urun_kategoriler")
                                        ->where("id", $kategori_id)
                                        ->get()->getFirstRow(); // Sadece ilk satırı al
            }


            

            // Ürün sorgula
            $urunSorgula = $database->table("urunler")->where("ad", $Stock["stock_title"])->get()->getFirstRow();

            // Ürün yoksa ekle
            if (!$urunSorgula || $urunSorgula == '' ) {
                $data_urun = [
                    'stokkod'          => $Stock["stock_code"],
                    'ad'               => $Stock["stock_title"],
                    'renk'             => '',
                    'tema'             => $Stock["sistem3d_durum"],
                    'sezon'            => $Stock["stock_id"],
                    'beden_dagilimi'   => $Stock["category_id"],
                    'seri_adet'        => 1,
                    'asorti_barkod'    => $Stock["stock_barcode"],
                    'sira'             => $i++,
                    'tema_id'          => 1,
                    'sezon_id'         => 1,
                ];

                $insert = $database->table('urunler')->insert($data_urun);
                $urun_id = $database->insertID();

                // Ürün fiyatlarını ekle
                foreach ($para_birimler as $para) {
                    $data_urun_fiyat = [
                        'urun_id'      => $urun_id,
                        'urun_tek_id'  => 0,
                        'para_birim_id'=> $para["id"],
                        'simge'        => $para["kodu"],
                        'tutar'        => $Stock["sale_unit_price_with_tax"],
                        'asorti_tutar' => $Stock["sale_unit_price_with_tax"],
                    ];
                    $database->table('urunler_fiyat')->insert($data_urun_fiyat);


                }

                // Ürün dil ekleme
                foreach ($diller as $dil) {
                    $data_urun_dil = [
                        'urun_id'    => $urun_id,
                        'dil_id'     => $dil["id"],
                        'ad'         => $Stock["stock_title"],
                        'aciklama'   => $kategoriSorgula ? $kategoriSorgula->adi : '',
                        'renk'       => '',
                    ];
                    $database->table('urunler_dil')->insert($data_urun_dil);
                }

                // Ürün tek giriş
                $urunlerTek = $database->table("urunler_tek")->where("urun_id", $Stock["stock_id"])->get()->getFirstRow();
                if (!$urunlerTek) {
                    $data_urun_tekk = [
                        'urun_id'        => $urun_id,
                        'barkod'         => $Stock["stock_barcode"],
                        'stokkod'        => $Stock["stock_code"],
                        'ad'             => $Stock["stock_title"],
                        'renk'           => '',
                        'tema'           => $Stock["sistem3d_durum"],
                        'sezon'          => $Stock["stock_id"],
                        'beden'          => $Stock["category_id"],
                        'asorti_barkod'  => $Stock["stock_barcode"],
                        'asorti_ici_adet'=> 2500 // Sabit değer
                    ];
                    $database->table('urunler_tek')->insert($data_urun_tekk);
                    $urun_tek_id = $database->insertID();
                }

                // Kategori ilişkisi
                $urunlerKategori = $database->table("urunler_kategori")
                                            ->where("urun_id", $urun_id)
                                            ->where("kategori_id", $kategori_id)
                                            ->get()->getFirstRow();
                if (!$urunlerKategori || $urunlerKategori == '' ) {
                    $data_urun_kategori = [
                        'urun_id'        => $urun_id,
                        'anakategori_id' => $kategori_id,
                        'ana_kategori'   => $kategoriSorgula->adi,
                        'kategori_id'    => $kategori_id,
                        'kategori'       => $kategoriSorgula->adi,
                    ];
                   $database->table('urunler_kategori')->insert($data_urun_kategori);
                }

            }

     
    
            try {
                $ftp_server = "45.143.99.171";
                $ftp_user = "app_sistem3d";
                $ftp_pass = "Yxpk432*4";
                
                // FTP bağlantısını başlat
                $ftp_conn = ftp_connect($ftp_server);
                if (!$ftp_conn) {
                    throw new \Exception('FTP sunucusuna bağlanılamadı.');
                }
            
                // FTP giriş yap
                $login = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
                if (!$login) {
                    ftp_close($ftp_conn);
                    throw new \Exception('FTP sunucusuna giriş başarısız.');
                }
            
                // Pasif mod ayarla
                ftp_pasv($ftp_conn, true);
            
                // Yerel dosya yolu
                $local_file = FCPATH . $Stock["default_image"];
                
                // Dosya mevcut mu kontrol et
                if (!file_exists($local_file)) {
                    $errorMessage = 'Dosya bulunamadı: ' . $local_file;
                    echo json_encode(['icon' => 'info', 'message' => $errorMessage]);
                    throw new \Exception($errorMessage);
                }
            
                // Uzak sunucudaki dosya adı
                $remote_file = basename($local_file);
            
                // Dosyayı FTP'ye yükle
                if (ftp_put($ftp_conn, $remote_file, $local_file, FTP_BINARY)) {
                    // Başarılı yükleme sonrası veritabanı güncelle
                    $newGaleri = [
                        'img' => "https://siparis.sistem3d.com/upload/image/" . $remote_file,
                    ];
                    $database->table("urunler")->set($newGaleri)->where("id", $urun_id)->update();
                    echo json_encode(['icon' => 'success', 'message' => 'Resim başarıyla yüklendi: ' . $remote_file]);
                } else {
                    $errorMessage = 'Dosya yükleme başarısız oldu: ' . $local_file;
                    echo json_encode(['icon' => 'error', 'message' => $errorMessage]);
                    throw new \Exception($errorMessage);
                }
            
                // FTP bağlantısını kapat
                ftp_close($ftp_conn);
            } catch (\Exception $e) {
                // Hatayı log dosyasına yaz
                file_put_contents(FCPATH . '/ftp_errors.log', 'Hata: ' . $e->getMessage() . ' Satır: ' . $e->getLine() . PHP_EOL, FILE_APPEND);
            
                // Hata mesajını ekrana yazdır
                echo json_encode(['icon' => 'error', 'message' => 'Bir hata oluştu: ' . $e->getMessage() . ' Satır: ' . $e->getLine()]);
            }
                      // Ürün güncelle
                   // Ürün güncelle
                   $this->modelStock->set("sistem3d", $urun_id)->where("stock_id", $Stock["stock_id"])->update();
                   $count++;
    
                }
    
              
          
    
            if ($count > 0) {
                echo json_encode(['icon' => 'success', 'message' => 'Toplam <b>' . $count . ' </b> Adet Ürün Sistem 3D Sitesine Aktarıldı.']);
            } else {
                echo json_encode(['icon' => 'info', 'message' => 'Sistem 3D sitesine aktarılacak ürün yoktur.']);
            }
        } catch (\Exception $e) {
            echo json_encode([
                'icon' => 'error',
                'message' => 'Bir hata oluştu: ' . $e->getMessage() . ' Satır: ' . $e->getLine()
            ]);
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





    /* public function Sistem3DAddProducts(){

        $database = $this->b2bConnect();

        $ModelStock = $this->modelStock->where('sistem3d', null)->findAll();
        $count = 0;
        $bb = 0;


        foreach($ModelStock as $Stock){

            if($Stock["status"] == "active"){
                $durum = 1;
            }else{
                $durum = 0;
            }

            $catBul = $this->modelCategory->where("category_id", $Stock["category_id"])->first();


            $cleanTitle = trim($catBul['category_title']);  // Baş ve sondaki boşlukları kaldırır
            $diller = $database->table("opt_site_diller")->get()->getResultArray();
            $para_birimler = $database->table('opt_para_birimleri')->get()->getResultArray();

            $i = 0;


            $kategoriSorgula = $database->table("opt_urun_kategoriler")->where("adi", $cleanTitle)->get()->getResultArray();

            if(!$kategoriSorgula)
            {

                
                $data_kategori = [
                    'adi'	        => $catBul['category_title'],
                    'sira'          => $bb*10,
                    'aktif'         => 1,
                    'kodu'	        => $this->seo_slug($catBul["category_title"])
                ];

                $kategori_ekle = $database->table('opt_urun_kategoriler')->insert($data_kategori);
                $KategoriID = $database->insertID();

                $data_kategori_alt = [
                    'adi'	        => $catBul['category_title'],
                    'sira'          => $bb*10,
                    'deger'         => $KategoriID,
                    'kodu'	        => $this->seo_slug($catBul["category_title"])
                ];

                $kategori_ekle_alt = $database->table('opt_urun_kategoriler_alt')->insert($data_kategori_alt);
               
                $kategori_id = $KategoriID;
                foreach($diller as $dil){
                    switch ($dil["id"]) {
                        case 1:                        
                            //data_urun_fiyat   -----------------------------------------------> FRANCEİSE  TL kayit
                            $data_dil_kategori = [
                                'alt_kategori_id'	 => $kategori_id,
                                'ad'	             => $catBul['category_title'],
                                'dil_id'	         => $dil["id"]                   
                            ];
                            $urun_d = $database->table('kategoriler_dil')->insert($data_dil_kategori);
                            break;
                        case 2:                        
                            //data_urun_fiyat   -----------------------------------------------> FRANCEİSE  TL kayit
                            $data_dil_kategori = [
                                'alt_kategori_id'	=> $kategori_id,
                                'ad'	            => $catBul['category_title'],
                                'dil_id'	        => $dil["id"]                   
                            ];
                            $urun_d = $database->table('kategoriler_dil')->insert($data_dil_kategori);
                            break;
                        
                        default:
                        # code...
                        break;
                    }
                }

            }else{
                $kategori_id = $kategoriSorgula["id"];
            }


            $urunSorgula = $database->table("urunler")->where("ad", $Stock["stock_title"])->get()->getResultArray();

            if(!$urunSorgula)
            {


                $data_urun = [
                    'stokkod'	        => $Stock["stock_code"],
                    'ad'	            => $Stock["stock_title"],
                    'renk'	            => '',
                    'tema'	            => $Stock["sistem3d_durum"],
                    'sezon'	            => $Stock["stock_id"],
                    'beden_dagilimi'	=> $Stock["category_id"],
                    'seri_adet'         => 1,
                    'asorti_barkod'     => $Stock["stock_barcode"],
                    'sira'              => $i++,
                    'tema_id'	        => 1,
                    'sezon_id'	        => 1,
                ];
    
                
                $urun_ii = $database->table('urunler')->insert($data_urun);
                $urun_id = $database->insertID();



                foreach ($para_birimler  as $para) {
               
                    switch ($para->id) {
                        case 1:                        
                            //data_urun_fiyat   -----------------------------------------------> TL kayit
                            $data_urun_fiyat = [
                                'urun_id'	        => $urun_id,
                                'urun_tek_id'	    => 0,
                                'para_birim_id'	    => $Stock["money_unit_id"],
                                'simge'	            => $para["kodu"],
                                'tutar'	            => $Stock["sale_unit_price"],                 
                                'asorti_tutar'	    => $Stock["sale_unit_price"],                 
                            ];

                            $urun_d = $database->table('urunler_fiyat')->insert($data_urun_fiyat);
                            break;
                        case 2:                        
                            //data_urun_fiyat   -----------------------------------------------> TL kayit
                            $data_urun_fiyat = [
                                'urun_id'	        => $urun_id,
                                'urun_tek_id'	    => 0,
                                'para_birim_id'	    => 2,
                                'simge'	            => $para["kodu"],
                                'tutar'	            => $Stock["sale_unit_price"],                 
                                'asorti_tutar'	    => $Stock["sale_unit_price"],                 
                            ];

                            $urun_d = $database->table('urunler_fiyat')->insert($data_urun_fiyat);
                            break;

                        case 3:                        
                            //data_urun_fiyat   -----------------------------------------------> TL kayit
                            $data_urun_fiyat = [
                                'urun_id'	        => $urun_id,
                                'urun_tek_id'	    => 0,
                                'para_birim_id'	    => 3,
                                'simge'	            => $para["kodu"],
                                'tutar'	            => $Stock["sale_unit_price"],                 
                                'asorti_tutar'	    => $Stock["sale_unit_price"],                 
                            ];

                            $urun_d = $database->table('urunler_fiyat')->insert($data_urun_fiyat);
                            break;
                        
            
                        
                        default:
                            # code...
                            break;
                    }
    
                } 

                      
                foreach ($diller  as $dil) {
                   
                    switch ($dil["id"]) {
                        case 1:                        
                            //urunler_dil TR kayit
                            $data_urun_dil = [
                                'urun_id'	        => $urun_id,
                                'dil_id'	        => $dil["id"],
                                'ad'	            => $Stock["stock_title"],                
                                'aciklama'	        => $kategoriSorgula["adi"],
                                'renk'	            => '',                    
                            ];
    
                            $urun_d = $database->table('urunler_dil')->insert($data_urun_dil);
                            break;
                        default:
                            # code...
                            break;
                    }
                }


                $urunlerTek = $database->table("urunler_tek")->where("urun_id", $Stock["stock_id"])->get()->getResultArray();

                if(!$urunlerTek)
                {


                    $data_urun_tekk = [
                        'urun_id'	        => $urun_id,
                        'barkod'	        => $Stock["stock_barcode"],
                        'stokkod'	        => $Stock["stock_code"],
                        'ad'	            => $Stock["stock_title"],
                        'renk'	            => '',
                        'tema'	            => $Stock["sistem3d_durum"],
                        'sezon'	            => $Stock["stock_id"],
                        'beden'         	=> $Stock["category_id"],
                        'asorti_barkod'     => $Stock["stock_barcode"],
                        'asorti_ici_adet'   => 2500 //$item_tek->asorti_ici_adet,
                    ];
                    $urun_tek_ii = $database->table('urunler_tek')->insert($data_urun_tekk);
                    $urun_tek_id = $database->insertID();

                    foreach ($para_birimler  as $para) {
                   
                        switch ($para->id) {
                            case 1:                        
                                //urunler_dil TL kayit
                                $data_urun_fiyat_tek = [
                                    'urun_id'	        => $urun_id,
                                    'urun_tek_id'	    => $urun_tek_id,
                                    'para_birim_id'	    => $para["id"],
                                    'simge'	            => $para["kodu"],
                                    'tutar'	            => $Stock["sale_unit_price"],                      
                                ];
                                $urun_d = $database->table('urunler_fiyat')->insert($data_urun_fiyat_tek);
                                break;

                                case 2:                        
                                    //urunler_dil TL kayit
                                    $data_urun_fiyat_tek = [
                                        'urun_id'	        => $urun_id,
                                        'urun_tek_id'	    => $urun_tek_id,
                                        'para_birim_id'	    => 2,
                                        'simge'	            => $para["kodu"],
                                        'tutar'	            => $Stock["sale_unit_price"],                      
                                    ];
                                    $urun_d = $database->table('urunler_fiyat')->insert($data_urun_fiyat_tek);
                                    break;

                                    case 3:                        
                                        //urunler_dil TL kayit
                                        $data_urun_fiyat_tek = [
                                            'urun_id'	        => $urun_id,
                                            'urun_tek_id'	    => $urun_tek_id,
                                            'para_birim_id'	    => 3,
                                            'simge'	            => $para["kodu"],
                                            'tutar'	            => $Stock["sale_unit_price"],                      
                                        ];
                                        $urun_d = $database->table('urunler_fiyat')->insert($data_urun_fiyat_tek);
                                        break;
                            
                
                            
                            default:
                                # code...
                                break;
                        }
        
                    }  



                }


                $urunlerKategori = $database->table("urunler_kategori")->where("kategori_id", $kategori_id)->get()->getResultArray();

                if(!$urunlerKategori)
                {


                    $data_urun_kategori = [
                        'urun_id'	        => $urun_id,
                        'anakategori_id'	=> $kategori_id,
                        'ana_kategori'	    => $kategoriSorgula["adi"],
                        'kategori_id'	    => $kategori_id,
                        'kategori'	        => $kategoriSorgula["adi"]//$item_tek->asorti_ici_adet,
                    ];

                    $urunler_kategori = $database->table('urunler_kategori')->insert($data_urun_kategori);


                }






                if ($urun_id) {

                    // FTP sunucusu bağlantı bilgileri
                    $ftp_server = "ftp.siparis.sistem3d.com";  // FTP sunucusu adresi
                    $ftp_user = "appsistem";    // FTP kullanıcı adı
                    $ftp_pass = "Yxpk432*4";        // FTP şifresi
                
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
                                    'img' => $remote_file, // Yüklenen resmin adı
                                ];
                                
                                $galeri = $database->table("urunler")->set($newGaleri)->where("id", $urun_id)->update();
                
                            } else {
                                //echo "Dosya yüklenemedi: " . $local_file . "<br>";
                            }
                        }
                
                        // FTP bağlantısını kapat
                        ftp_close($ftp_conn);
                    }
                
                    
    
                }







            }



            $count++;

            $UrunGuncelle = $this->modelStock->set("sistem3d", $urun_id)->where("stock_id", $Stock["stock_id"])->update();




          
        }



        if($count > 0){
            echo json_encode(['icon' => 'success', 'message' => 'Toplam <b>'.$count.' </b> Adet Ürün Sistem 3D Sitesine Aktarıldı.']);
        }else{
            echo json_encode(['icon' => 'info', 'message' => 'Sistem 3D sitesine aktarılacak ürün yoktur.']);

        }

        

    } 
        */


   



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


    


                    $CariSorgula = $this->modelCari->orWhere("cari_email", $musteriBilgileri->email)->where("invoice_title", $musteriBilgileri->firma_adi)->first();
                
                
                    
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
                            $d_date = $siparis["siparis_tarihi"];
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


                        $b2bText.= "İşlemi Yapan: <b> " . $musteriBilgileri->yetkili_adi . "</b>  <br>  Telefon: <b>" . $musteriBilgileri->firma_tel. "</b> <br>";
                        $b2bText.="Site: <b>http://siparis.sistem3d.com/</b><br>Sipariş No: <b>" . $siparis["siparis_no"] . "</b> <br> Sipariş Tarihi : <b>" . date("Y/m/d H:i", strtotime($siparis["siparis_tarihi"]))."</b>"; 

          
           
        
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
                            'satisci' => $musteriBilgileri->yetkili_adi,
                            'failed_reason' => ""
                        ];




                  
                        $this->modelOrder->insert($insert_order_data);
                        $order_id = $this->modelOrder->getInsertID();

                       

                    
                        $altsiparisler = $database->table("siparisler_detay")->where("siparis_id", $siparis["id"])->get()->getResult();

                     
             
        
                        foreach ($altsiparisler as $data_order_row) {
                            $data_order_row = get_object_vars($data_order_row);

    
                        
                            // Stok bilgilerini almak
                            $stokBilgileri = $this->modelStock->where('stock_id', $data_order_row['urun_sezon'])->first();

             
                        
    
                        
                       if ($stokBilgileri) {
                                

                                if(!empty($data_order_row["urun_sezon"])){
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

                        if(empty($data_order_row["urun_sezon"]))
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


}
