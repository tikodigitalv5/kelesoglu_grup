<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;

use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoERP\StockGalleryModel;
use App\Models\TikoERP\StockRecipeModel;
use App\Models\TikoERP\RecipeItemModel;
use function PHPUnit\Framework\returnSelf;
use \Hermawan\DataTables\DataTable;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;
use CodeIgniter\I18n\Time;
use App\Models\TikoERP\SysmondDepolarModel;
use Exception;
/**
 * @property IncomingRequest $request
 */

 ini_set('memory_limit', '1024M');
class Order extends BaseController
{
    private $DatabaseConfig;
    private $currentDB;
    private $modelBox;
    private $modelBoxRow;
    private $modelStockGallery;
    private $modelStockRecipe;
    private $modelRecipeItem;
    private $modelCari;
    private $modelMoneyUnit;
    private $modelFinancialMovement;
    private $modelAddress;
    private $modelStock;
    private $modelOrder;
    private $modelOrderRow;
    private $modelNote;

    private $logClass;
    private $modelInvoice;
    private $modelEmirler;

    private $modelStockBarcode;

    private $modelDopigoEslestir;
    private $modelIslem;
    private $modelWarehouse;
    private $modelStockWarehouseQuantity;
    private $modelStockMovement;
    private $modelFaturaTutar;
    private $modelInvoiceRow;
    private $modelUnit;
    private $db;
    private $modelCategory;
    private $modelFinancialAccount;
    private $modelSysmondDepolar;
    private $modelIrsaliye;


    public function __construct()
    {
        $this->request = \Config\Services::request();

        
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();

        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);
        $this->db = $db_connection;
        $this->modelCategory = model($TikoERPModelPath . '\CategoryModel', true, $db_connection);

        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
        $this->modelFinancialMovement = model($TikoERPModelPath . '\FinancialMovementModel', true, $db_connection);
        $this->modelMoneyUnit = model($TikoERPModelPath . '\MoneyUnitModel', true, $db_connection);
        $this->modelAddress = model($TikoERPModelPath . '\AddressModel', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath . '\StockModel', true, $db_connection);
        $this->modelOrder = model($TikoERPModelPath . '\OrderModel', true, $db_connection);
        $this->modelOrderRow = model($TikoERPModelPath . '\OrderRowModel', true, $db_connection);
        $this->modelNote = model($TikoERPModelPath . '\NoteModel', true, $db_connection);
        $this->modelInvoice = model($TikoERPModelPath . '\InvoiceModel', true, $db_connection);
        $this->modelEmirler = model($TikoERPModelPath . '\SevkEmirleri', true, $db_connection);
        $this->modelStockBarcode = model($TikoERPModelPath . '\StockBarcodeModel', true, $db_connection);
        $this->modelBox = model($TikoERPModelPath . '\BoxModel', true, $db_connection);
        $this->modelBoxRow = model($TikoERPModelPath . '\BoxRowModel', true, $db_connection);
        $this->modelStockGallery = model($TikoERPModelPath . '\StockGalleryModel', true, $db_connection);
        $this->modelStockRecipe = model($TikoERPModelPath . '\StockRecipeModel', true, $db_connection);
        $this->modelRecipeItem = model($TikoERPModelPath . '\RecipeItemModel', true, $db_connection);
        $this->modelDopigoEslestir = model($TikoERPModelPath . '\DopigoEslestirModel', true, $db_connection);
        $this->modelIslem = model($TikoERPModelPath . '\IslemLoglariModel', true, $db_connection);
        $this->modelWarehouse = model($TikoERPModelPath . '\WarehouseModel', true, $db_connection);
        $this->modelStockWarehouseQuantity = model($TikoERPModelPath . '\StockWarehouseQuantityModel', true, $db_connection);
        $this->modelStockMovement = model($TikoERPModelPath . '\StockMovementModel', true, $db_connection);
        $this->modelFaturaTutar = model($TikoERPModelPath . '\FaturaTutarlarModel', true, $db_connection);
        $this->modelSysmondDepolar = model($TikoERPModelPath . '\SysmondDepolarModel', true, $db_connection);
        $this->modelInvoiceRow = model($TikoERPModelPath . '\InvoiceRowModel', true, $db_connection);
        $this->modelUnit = model($TikoERPModelPath . '\UnitModel', true, $db_connection);
        $this->modelIrsaliye = model($TikoERPModelPath . '\IrsaliyeModel', true, $db_connection);


        $this->logClass = new Log();

        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
        helper('Helpers\stock_func_helper');

        
    }
    public function list($order_status = 'all')
    {

    
      
        if ($order_status == 'all') {
            $page_title = "Tüm Siparişler";
        } else if ($order_status == 'open') {
            $page_title = "Açık Siparişler";
        } else if ($order_status == 'closed') {
            $page_title = "Kapalı Siparişler";
        } else {
            return redirect()->back();
        }

 
        /*$startDate = Date("Y-m-d") . '00:00:00';
        $endDate = Date("Y-m-d") . ' 23:59:59';
        
        $platformlar = $this->modelOrder
            ->select('service_name,service_logo, COUNT(*) as count') // service_name ve kayıt sayısını seç
            ->where('order_date >=', $startDate) // Başlangıç tarihine göre filtrele
            ->where('order_date <=', $endDate) // Bitiş tarihine göre filtrele
            ->groupBy('service_name') // service_name ile gruplandır
            ->findAll(); */

        

    $startDate = date("Y-m-d") . ' 00:00:00';
    $endDate = date("Y-m-d") . ' 23:59:59';
    
    // Sipariş sayısını almak için ilk sorgu
    $platformlar = $this->modelOrder
        ->join('money_unit', 'money_unit.money_unit_id = order.money_unit_id')
        ->select('service_name, COUNT(*) as count') // service_name ve kayıt sayısını seç
        ->where('order_date >=', $startDate) // Başlangıç tarihine göre filtrele
        ->where('order_date <=', $endDate) // Bitiş tarihine göre filtrele
        ->groupBy('service_name') // service_name ile gruplandır
        ->findAll();

        


    
    // Tüm platformları almak için ikinci sorgu


  
    $cacheKey = 'platformlar_liste_cache';
    $platformlarListe = cache()->get($cacheKey);
    if ($platformlarListe === null) {
        $db = $this->famsrapor();
        $sql = "SELECT service_name, service_logo, COUNT(*) as count FROM `order` WHERE deleted_at IS NULL GROUP BY service_name, service_logo";
        $query = $db->query($sql);
        $platformlarListe = $query->getResultArray();
        cache()->save($cacheKey, $platformlarListe, 300); // 5 dakika cache
    }
    
    // Platform listesine sayıları ekle
    foreach ($platformlarListe as &$platform) {
        $platform['count'] = 0; // Varsayılan olarak count'u 0 yap
        foreach ($platformlar as $sonuc) {
            if ($platform['service_name'] == $sonuc['service_name']) {
                $platform['count'] = $sonuc['count']; // Eğer eşleşme varsa count'u güncelle
                break;
            }
        }
    }
    unset($platform); // referansları temizle


    $bugunSevkler = $this->modelEmirler
    ->select('*') // service_name ve kayıt sayısını seç
    ->where("bitti", 0)
    ->countAllResults();

    


            
    
    
        $data = [
            'platformlar' => $platformlar,
            'bugunSevkler' => $bugunSevkler,
            'platformlarliste' => $platformlarListe,
            'page_title' => $page_title,
            'kargofirmalari' => $this->DopigoKargo(),
        ];
    if(session()->get("user_item")["user_id"] == 1 || session()->get("user_item")["user_id"] == 19){
        return view('tportal/siparisler/index_fams', $data);
    }else{
        return view('tportal/siparisler/index', $data);
    }
    }



    public function mshapp()
    {
       

        $userDatabaseDetail = [
            'hostname' => '78.135.66.90',
            'username' => 'msh_fabrika_us',
            'password' => '2^bHSW9j?rMQ',
            'database' => 'msh_fabrika',
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


    public function famsrapor()
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


    public function getOrderList($order_status = 'all')
    {
        $builder = $this->modelOrder
            ->where('order.user_id', session()->get('user_id'))
            ->orderBy('order.order_date', 'DESC');
    
        $isSpecialUser = (session()->get("user_item")["user_id"] == 1 || session()->get("user_item")["user_id"] == 19);
        // Tarih aralığı filtrelemesi
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
    
        if (!empty($start_date) && !empty($end_date)) {
            $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $start_date)));
            $end_date = date('Y-m-d', strtotime(str_replace('/', '-', $end_date)));
    
            $builder->where('order.order_date >=', $start_date . ' 00:00:00');
            $builder->where('order.order_date <=', $end_date . ' 23:59:59');
        } else {
            // Eğer tarih filtresi belirtilmemişse ve özel kullanıcı ise son 1 aylık veriyi göster
            if ($isSpecialUser) {
                $builder->where('order.order_date >=', date("Y-m-d H:i:s", strtotime("-2 months")));
                $builder->where('order.order_date <=', date("Y-m-d H:i:s"));
            }
        }
    
        $moneyUnits = [];
        foreach ($this->modelMoneyUnit->findAll() as $mu) {
            $moneyUnits[$mu['money_unit_id']] = $mu['money_icon'];
        }
        
        // Durum filtresi
        $status = $this->request->getGet('status');
        if (!empty($status) && $status != 'all') {
            $builder->where('order_status', $status);
        }
    
        // Platform filtresi
        $platform = $this->request->getGet('platform');
        if (!empty($platform)) {
            $builder->where('service_name', $platform);
        }
    
        // Sipariş durumu filtresi
        if ($order_status === 'open') {
            $builder->groupStart()
                ->where('order_status', 'new')
                ->orWhere('order_status', 'pending')
                ->groupEnd();
        } elseif ($order_status === 'closed') {
            $builder->groupStart()
                ->where('order_status', 'failed')
                ->orWhere('order_status', 'success')
                ->groupEnd();
        } elseif ($order_status !== 'all') {
            return redirect()->back();
        }

       
    
        // JSON olarak dönen veriyi kontrol et
        $data = DataTable::of($builder)
            ->setSearchableColumns(['order_date', 'order_no', 'cari_invoice_title'])
            ->add('money_icon', function ($row) use ($moneyUnits) {
                return $moneyUnits[$row->money_unit_id] ?? '-';
            })
            ->add('action', function ($row) {
                $modelrow = $this->modelOrderRow->where("order_id", $row->order_id)->where("stock_id", 0)->first();
                return $modelrow ? '<span class="tb-odr-status"><span class="badge badge-dot bg-danger">Eşleşmeyen Ürün Var</span></span>' : '';
            }, 'last')
            ->add('stok', function ($row) {
                $modelrow = $this->modelOrderRow->where("order_id", $row->order_id)->where("stock_id !=", 0)->findAll();
                $stokData = [];
                foreach($modelrow as $rows){
                    $order = $this->modelOrder->where("order_id", $rows["order_id"])->first();
                    $stokBul = $this->modelStock->where("stock_id", $rows["stock_id"])->first();
                    $stokData[] = [
                        'siparis_no' => substr($order["order_no"], 3),
                        "stock_id" => $stokBul["stock_id"] ?? 0,
                        "stock_title" => $stokBul["stock_title"] ?? '',
                        "mevcutStokta" => $stokBul["stock_total_quantity"] ?? 0,
                        "siparis_edilen" => $rows["stock_amount"] ?? 0,
                    ];
                }

                return $stokData ? $stokData : '';
            }, 'last')
            ->add('aktarim', function ($row) {
                $modelrow = $this->modelOrder->where("order_id", $row->order_id)->where("msh_order_id !=", "")->first();
                return $modelrow ? '<span class="tb-odr-status"><span class="badge badge-dot bg-success">PLANMAYA AKTARILDI</span></span>' : '';
            }, 'last')
            ->add('dopigo', function ($row) {
                $modelrow = $this->modelOrder->where("order_id", $row->order_id)->where("dopigo_siparis_id !=", "")->first();
                return $modelrow ? '<a data-dopigo_siparis_id="'.$modelrow["dopigo_siparis_id"].'" data-order_id="'.$modelrow["order_id"].'" data-invoice_title="'.$modelrow["cari_invoice_title"].'" data-siparis_no="'.$modelrow["order_no"].'"  style="margin-right: 5px;" class="siparisTekli btn btn-round btn-icon btn-outline-primary"><em class="icon ni ni-reload-alt"></em></a>' : '';
            }, 'last')
            ->add('kargo_sonuc', function ($row) {
                $modelrow = $this->modelOrder->where("order_id", $row->order_id)->first();
                return empty($modelrow["kargo_kodu"]) ? '<span class="tb-odr-status"><span class="badge badge-dot bg-danger">KARGO KODU BOŞ</span></span>' : '';
            }, 'last')
          
            ->add('guncelleme', function ($row) {
                if(session()->get("user_item")["user_id"] == 1 || session()->get("user_item")["user_id"] == 19) {
                    $modelrow = $this->modelIslem->where("siparis_id", $row->order_id)
                        ->orderBy("islem_log_id", "DESC")
                        ->limit(1)
                        ->first();
                    return $modelrow ? $modelrow["created_at"] : '';
                }
                return '';
            }, 'last')
           
                ->add('irsaliye', function ($row) {
                // Order ID'leri diziye çevir
                $order_ids = array_map('trim', explode(',', $row->order_id));
                
                // Sorguyu oluştur
                $builder = $this->modelIrsaliye->db->table('irsaliyeler');
                
                // Her bir order_id için OR koşulu ekleyelim
                $builder->groupStart();
                foreach ($order_ids as $id) {
                    $builder->orWhere('FIND_IN_SET("'.$id.'", REPLACE(order_id, " ", "")) > 0');
                }
                $builder->groupEnd()
                       ->where('deleted_at IS NULL');
                
                $irsaliyeler = $builder->get()->getResultArray();

                if (empty($irsaliyeler)) {
                    return '0';
                }

                // Tek irsaliye varsa direkt link
                if (count($irsaliyeler) === 1) {
                    return '<a href="'.base_url().'/tportal/irsaliye/detail/'.$irsaliyeler[0]['id'].'" class="btn btn-round btn-icon btn-outline-primary" title="İrsaliye Detay" style="margin-right:5px;">
                            <em class="icon ni ni-report-profit"></em>
                           </a>';
                }

                // Birden fazla irsaliye varsa modal button
                $modalId = 'irsaliyeModal_'.$irsaliyeler[0]['id'];
                $html = '<button type="button" class="btn btn-round btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#'.$modalId.'" title="İrsaliyeleri Görüntüle" style="margin-right:5px;">
                            <em class="icon ni ni-reports"></em>
                        </button>';


                $depoListesi = [
                    "33" => "1. Depo",
                    "34" => "2. Depo",
                    "35" => "3. Depo",
                ];
                
                // Modal HTML
                $html .= '<div class="modal fade" id="'.$modalId.'" tabindex="-1" role="dialog" aria-labelledby="'.$modalId.'Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="'.$modalId.'Label">İrsaliye Listesi</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>İrsaliye No</th>
                                                        <th>Depo</th>
                                                       
                                                        <th>İşlem</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
        
                foreach ($irsaliyeler as $irsaliye) {
                    $html .= '<tr>
                                <td>'.$irsaliye['irsaliye_no'].'</td>
                                <td>'.$depoListesi[$irsaliye['depo_id']].'</td>
                               
                                <td>
                                    <a target="_blank" href="'.base_url().'/tportal/irsaliye/detail/'.$irsaliye['id'].'" class="btn btn-sm btn-primary">
                                        <em class="icon ni ni-eye"></em> Görüntüle
                                    </a>
                                </td>
                            </tr>';
                }
        
                $html .= '           </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        </div>
                    </div>
                </div>
            </div>';
        
                return $html;
            }, 'last')
            ->add('satir_toplam', function ($row) {
                $orderTotal = $row->amount_to_be_paid_try;
                $rowTotal = $this->modelOrderRow
                    ->where("order_id", $row->order_id)
                    ->where("deleted_at", null)
                    ->selectSum('total_price')
                    ->first();
                
                $satirlarToplami = $rowTotal['total_price'] ?? 0;
                $fark = abs($orderTotal - $satirlarToplami);
                
                if ($fark > 0.01) {
                    return 'Fiyatlar uyuşmuyor<br>' . 
                    'Sipariş Toplamı: ' . number_format($orderTotal, 2) . ' TL<br>' . 
                    'Satır Toplamı: ' . number_format($satirlarToplami, 2) . ' TL';
                }
                return 1;
            }, 'last')
            ->toJson(true);
    
        return $data;
    }
    

    
    public function getOrderListss($order_status = 'all')
    {
        $userId = session()->get("user_id");
        $userItem = session()->get("user_item");
        $isSpecialUser = in_array($userItem["user_id"], [1, 19]);
    
        $builder = $this->modelOrder
            ->where('order.user_id', $userId)
            ->orderBy('order.order_date', 'DESC');
    
        // Detaylı filtreleme parametreleri
        $order_date_start = $this->request->getGet('order_date_start');
        $order_date_end = $this->request->getGet('order_date_end');
        $status = $this->request->getGet('status');
        $platform = $this->request->getGet('platform');
        $length = $this->request->getGet('length');
        $kargo = $this->request->getGet('kargo');
        $cari_name = $this->request->getGet('cari_name');
        $order_no = $this->request->getGet('order_no');
        
        // Tarih aralığı kontrolü - Detaylı filtreleme öncelikli
        if (!empty($order_date_start) && !empty($order_date_end)) {
            $start = date('Y-m-d', strtotime(str_replace('/', '-', $order_date_start))) . ' 00:00:00';
            $end = date('Y-m-d', strtotime(str_replace('/', '-', $order_date_end))) . ' 23:59:59';
            $builder->where('order.order_date >=', $start)
                    ->where('order.order_date <=', $end);
        } else {
            // Eski tarih filtreleme (geriye uyumluluk için)
            $start_date = $this->request->getGet('start_date');
            $end_date = $this->request->getGet('end_date');
            
            if (!empty($start_date) && !empty($end_date)) {
                $start = date('Y-m-d', strtotime(str_replace('/', '-', $start_date))) . ' 00:00:00';
                $end = date('Y-m-d', strtotime(str_replace('/', '-', $end_date))) . ' 23:59:59';
                $builder->where('order.order_date >=', $start)
                        ->where('order.order_date <=', $end);
            } elseif ($isSpecialUser) {
                $builder->where('order.order_date >=', date("Y-m-d H:i:s", strtotime("-1 months")))
                        ->where('order.order_date <=', date("Y-m-d H:i:s"));
            }
        }
        
        // Detaylı filtreleme uygula
        if (!empty($status) && $status != '0') {
            $builder->where('order_status', $status);
        }
        
        if (!empty($platform) && $platform != '0') {
            $builder->where('service_name', $platform);
        }
        
        if (!empty($kargo) && $kargo != '0') {
            $builder->where('kargo', $kargo);
        }
        
        if (!empty($cari_name)) {
            $builder->like('cari_invoice_title', $cari_name);
        }
        
        if (!empty($order_no)) {
            $builder->like('order_no', $order_no);
        }
        if (!empty($length)) {
            $builder->limit((int)$length);
        }
    
        // Para birimi eşlemesi
        $moneyUnits = [];
        foreach ($this->modelMoneyUnit->findAll() as $mu) {
            $moneyUnits[$mu['money_unit_id']] = $mu['money_icon'];
        }
    
        // Özel order_status filtresi
        if ($order_status === 'open') {
            $builder->groupStart()
                ->where('order_status', 'new')
                ->orWhere('order_status', 'pending')
                ->groupEnd();
        } elseif ($order_status === 'closed') {
            $builder->groupStart()
                ->where('order_status', 'failed')
                ->orWhere('order_status', 'success')
                ->groupEnd();
        } elseif ($order_status !== 'all') {
            return redirect()->back();
        }
    
        $data = DataTable::of($builder)
            ->setSearchableColumns(['order_date', 'order_no', 'cari_invoice_title'])
    
            ->add('money_icon', fn($row) => $moneyUnits[$row->money_unit_id] ?? '-', 'last')
    
            ->add('action', function ($row) {
                $modelrow = $this->modelOrderRow->where("order_id", $row->order_id)->where("stock_id", 0)->first();
                return $modelrow ? '<span class="tb-odr-status"><span class="badge badge-dot bg-danger">Eşleşmeyen Ürün Var</span></span>' : '';
            }, 'last')
    
            ->add('stok', function ($row) {
                $modelrows = $this->modelOrderRow->where("order_id", $row->order_id)->where("stock_id !=", 0)->findAll();
                $stokData = [];
                foreach ($modelrows as $rows) {
                    $stokBul = $this->modelStock->find($rows["stock_id"]);
                    $stokData[] = [
                        'siparis_no'     => substr($row->order_no, 3),
                        "stock_id"       => $stokBul["stock_id"] ?? 0,
                        "stock_title"    => $stokBul["stock_title"] ?? '',
                        "mevcutStokta"   => $stokBul["stock_total_quantity"] ?? 0,
                        "siparis_edilen" => $rows["stock_amount"] ?? 0,
                    ];
                }
                return $stokData ?: '';
            }, 'last')
    
            ->add('aktarim', fn($row) => 
                !empty($row->msh_order_id) ? '<span class="tb-odr-status"><span class="badge badge-dot bg-success">PLANMAYA AKTARILDI</span></span>' : '', 'last')
    
            ->add('dopigo', function ($row) {
                if (!empty($row->dopigo_siparis_id)) {
                    return '<a data-dopigo_siparis_id="'.$row->dopigo_siparis_id.'" data-order_id="'.$row->order_id.'" data-invoice_title="'.$row->cari_invoice_title.'" data-siparis_no="'.$row->order_no.'" style="margin-right: 5px;" class="siparisTekli btn btn-round btn-icon btn-outline-primary"><em class="icon ni ni-reload-alt"></em></a>';
                }
                return '';
            }, 'last')
    
            ->add('kargo_sonuc', fn($row) => 
                empty($row->kargo_kodu) ? '<span class="tb-odr-status"><span class="badge badge-dot bg-danger">KARGO KODU BOŞ</span></span>' : '', 'last')
    
            ->add('guncelleme', function ($row) use ($isSpecialUser) {
                if ($isSpecialUser) {
                    $modelrow = $this->modelIslem->where("siparis_id", $row->order_id)
                        ->orderBy("islem_log_id", "DESC")
                        ->first();
                    return $modelrow["created_at"] ?? '';
                }
                return '';
            }, 'last')
    
            ->add('irsaliye', function ($row) {
                $order_ids = array_map('trim', explode(',', $row->order_id));
                $builder = $this->modelIrsaliye->db->table('irsaliyeler');
                $builder->groupStart();
                foreach ($order_ids as $id) {
                    $builder->orWhere('FIND_IN_SET("'.$id.'", REPLACE(order_id, " ", "")) > 0');
                }
                $builder->groupEnd()->where('deleted_at IS NULL');
                $irsaliyeler = $builder->get()->getResultArray();
    
                if (empty($irsaliyeler)) return '0';
    
                $modalId = 'irsaliyeModal_'.$irsaliyeler[0]['id'];
                $depoListesi = ["33" => "1. Depo", "34" => "2. Depo", "35" => "3. Depo"];
    
                if (count($irsaliyeler) === 1) {
                    return '<a href="'.base_url().'/tportal/irsaliye/detail/'.$irsaliyeler[0]['id'].'" class="btn btn-round btn-icon btn-outline-primary" title="İrsaliye Detay" style="margin-right:5px;"><em class="icon ni ni-report-profit"></em></a>';
                }
    
                $html = '<button type="button" class="btn btn-round btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#'.$modalId.'" title="İrsaliyeleri Görüntüle" style="margin-right:5px;"><em class="icon ni ni-reports"></em></button>';
                $html .= '<div class="modal fade" id="'.$modalId.'" tabindex="-1" role="dialog"><div class="modal-dialog"><div class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">İrsaliye Listesi</h5>
                                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
                            </div><div class="modal-body"><div class="table-responsive"><table class="table table-bordered">
                            <thead><tr><th>İrsaliye No</th><th>Depo</th><th>İşlem</th></tr></thead><tbody>';
                foreach ($irsaliyeler as $irsaliye) {
                    $html .= '<tr><td>'.$irsaliye['irsaliye_no'].'</td>
                              <td>'.$depoListesi[$irsaliye['depo_id']].'</td>
                              <td><a target="_blank" href="'.base_url().'/tportal/irsaliye/detail/'.$irsaliye['id'].'" class="btn btn-sm btn-primary"><em class="icon ni ni-eye"></em> Görüntüle</a></td></tr>';
                }
                $html .= '</tbody></table></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button></div></div></div></div>';
                return $html;
            }, 'last')
    
            ->add('satir_toplam', function ($row) {
                $orderTotal = $row->amount_to_be_paid_try;
                $rowTotal = $this->modelOrderRow
                    ->where("order_id", $row->order_id)
                    ->where("deleted_at", null)
                    ->selectSum('total_price')
                    ->first();
                $satirlarToplami = $rowTotal['total_price'] ?? 0;
                $fark = abs($orderTotal - $satirlarToplami);
                if ($fark > 0.01) {
                    return 'Fiyatlar uyuşmuyor<br>Sipariş Toplamı: ' . number_format($orderTotal, 2) . ' TL<br>Satır Toplamı: ' . number_format($satirlarToplami, 2) . ' TL';
                }
                return 1;
            }, 'last')
            ->toJson(true);
    
        return $data;
    }
    
    
    public function urunleri_esle()
    {


        $eslesmeyenler = $this->modelOrderRow->where("stock_id", 0)->limit(0,1)->findAll();
       
        
    
        

    
        $data = [
            'eslesmeyenler' => $eslesmeyenler,
            'page_title' => "Ürünleri Eşitle",
        ];
    
        return view('tportal/siparisler/urun_eslestir', $data);
    }

    public function eslesen_urunler()
    {


        $eslesmeyenler = $this->modelDopigoEslestir->where("silindi", 0)->limit(0,1)->findAll();
       
        
    
        

    
        $data = [
            'eslesmeyenler' => $eslesmeyenler,
            'page_title' => "Eşleşen Ürünler",
        ];
    
        return view('tportal/siparisler/eslesen_urunler', $data);
    }


    

    public function DopigoHTML($eslesmeyenler)
    {
        $output = '';
        $count = 0;
        $satir_id =0;
        foreach($eslesmeyenler as $esle) { 
            $satir_id++;
            $modelStock = $this->modelStock->where("stock_id", $esle["stock_id"])->first();

            $count++;
            $output .= '
                <tr class="nk-tb-item">
                    <td class="nk-tb-col tb-col-mb">
                        <div class="user-info">
                            <span style="color:black; opacity:0.8;">
                                '. $esle["dopigo_title"] .' <br> Kodu: '. $esle["dopigo_code"] .'
                            </span>
                        </div>
                    </td>
                    <td class="nk-tb-col tb-col-mb text-left">
                        <div class="user-info">
                            <a id="imghrefs_'. $satir_id .'" class="gallery-image popup-image" data-title="'.$esle["stock_title"].'" data-href="https://app.tikoportal.com.tr/'.$modelStock["default_image"].'"">
                                <img class="" id="img_urun_'. $satir_id .'" src="https://app.tikoportal.com.tr/'.$modelStock["default_image"].'" alt="logo" style="height: 70px;">
                            </a>
                        </div>
                    </td>
                    <td class="nk-tb-col tb-col-mb">
                        <div class="user-info">
                            <div class="form-control-wrap">
                                <textarea class="form-control yeni_urun_'. $satir_id .' form-control-lg form-control-xl" placeholder="Ürün Seçiniz" disabled style="min-height: 70px; padding: 5px; font-size: 14px; line-height: 19px;">
'. htmlspecialchars($esle["stock_title"], ENT_QUOTES, 'UTF-8') .'
Ürün Kodu: '. htmlspecialchars($esle["stock_code"], ENT_QUOTES, 'UTF-8') .'</textarea>
                                <input type="hidden" name="stok_id[]" class="stok_id_'. $satir_id .'" value="'.$esle["stock_id"].'">
                                <input type="hidden" value="'. $esle["id"] .'" name="order_row_id[]" id="id">
                            </div>
                        </div>
                    </td>
                    <td class="nk-tb-col tb-col-mb text-center">
                        <div class="user-info">
                            <button 
                                type="button"
                                data-s-id="'. $satir_id .'"
                                data-order_row_id="'. $esle["id"] .'"
                                class="btn btn-outline-primary btn-dim btn_urun_sec"
                                data-nereden="siparis"
                                id="btn_urunSec">
                                <span>Ürün Seç</span>
                            </button>
                        </div>
                    </td>
                </tr>';
        }
        $output .= '';
        return $output;
    }
    

    public function eslesen_getir(){

    $stock_code = $this->request->getPost("stock_code");

    if(empty($stock_code)){
        echo json_encode(['icon' => 'danger', 'message' => 'Stok Kodu Boş Olamaz!']);
        return;
    }


    $dopigoEslesenler = $this->modelDopigoEslestir->like('stock_code', '%' . $stock_code . '%', false)->where("silindi",0)->findAll();
    if($dopigoEslesenler){
        $htmlData = $this->DopigoHTML($dopigoEslesenler);
        echo json_encode(['icon' => 'success', 'message' => 'Stok Getirildi', 'data' => $htmlData]);
        return;
    }else{
        echo json_encode(['icon' => 'danger', 'message' => 'Eşlenmiş Ürün Bulunamadı..']);
        return;
    }


    }


    

    public function urun_guncelle()
    {
        $stok_ids = $this->request->getPost("stok_id");
        $order_row_ids = $this->request->getPost("order_row_id");
    
        if(!empty($stok_ids) && !empty($order_row_ids) && count($stok_ids) == count($order_row_ids))
        {
            foreach($stok_ids as $index => $stok_id)
            {
                $order_row_id = $order_row_ids[$index];
    
                if(!empty($stok_id))
                {
                    $modelOrder = $this->modelOrderRow->set("stock_id", $stok_id)->where("order_row_id", $order_row_id)->update();
    
                    if($modelOrder)
                    {
                        $order_satir = $this->modelOrderRow->where("order_row_id", $order_row_id)->first();
                        $stokBilgisi = $this->modelStock->where("stock_id", $order_satir["stock_id"])->first(); 

                        $data = [
                            'dopigo_id'    => $order_satir["dopigo"] ?? 0,
                            'stock_id'     => $order_satir["stock_id"],
                            'stock_title'  => $order_satir["stock_title"],
                            'dopigo_title' => $order_satir["dopigo_title"] ?? $order_satir["stock_title"], // yoksa stock_title
                            'stock_code'   => $stokBilgisi["stock_code"],
                            'dopigo_code'  => $order_satir["dopigo_sku"] ?? $stokBilgisi["stock_code"], // yoksa stock_code
                            'silindi'      => false,
                        ];
                        
                        $EslesenEkle = $this->modelDopigoEslestir->insert($data);

                      /*  $this->modelIslem->LogOlustur(
                            session()->get('client_id'), 
                            session()->get('user_id'), 
                            $order_satir["stock_id"], 
                            'ok',  
                            'stok', 
                            'Ürünler başarıyla eşlendi',
                            session()->get("user_item")["user_adsoyad"],
                            json_encode($data)
                        ); */

    
                        //$this->modelStock->set("dopigo", $order_satir["dopigo"])->where("stock_id", $order_satir["stock_id"])->update();
                    }
                }
            }
        }
    

        



        echo json_encode(['icon' => 'success', 'message' => 'Ürünler başarıyla eşlendi']);
        return;
    }


    public function eslesme_guncelle()
    {
        $stok_ids = $this->request->getPost("stok_id");
        $order_row_ids = $this->request->getPost("order_row_id");


    
        if(!empty($stok_ids) && !empty($order_row_ids) && count($stok_ids) == count($order_row_ids))
        {
            foreach($stok_ids as $index => $stok_id)
            {
                $order_row_id = $order_row_ids[$index];
    
                if(!empty($stok_id))
                {
                    $modelEsle = $this->modelDopigoEslestir->set("silindi", 1)->where("id", $order_row_id)->update();
    
                    if($modelEsle)
                    {


                        $order_satir = $this->modelDopigoEslestir->where("id", $order_row_id)->first();
                        $stokBilgisi = $this->modelStock->where("stock_id", $stok_id)->first(); 

                        $data = [
                            'dopigo_id'    => $order_satir["dopigo_id"],
                            'stock_id'     => $stok_id,
                            'stock_title'  => $stokBilgisi["stock_title"],
                            'dopigo_title' => $order_satir["dopigo_title"] ?? $order_satir["stock_title"], // yoksa stock_title
                            'stock_code'   => $stokBilgisi["stock_code"],
                            'dopigo_code'  => $order_satir["dopigo_sku"] ?? $stokBilgisi["stock_code"], // yoksa stock_code
                            'silindi'      => false,
                        ];
                        
                        $EslesenEkle = $this->modelDopigoEslestir->insert($data);

                      /*  $this->modelIslem->LogOlustur(
                            session()->get('client_id'), 
                            session()->get('user_id'), 
                            $stok_id, 
                            'ok',  
                            'stok', 
                            'Ürünler başarıyla Değiştirildi',
                            session()->get("user_item")["user_adsoyad"],
                            json_encode($data)
                        );
    */
                        //$this->modelStock->set("dopigo", $order_satir["dopigo"])->where("stock_id", $order_satir["stock_id"])->update();
                    }else{
                        echo "bura2";
                        exit;
                    }
                }else{
                    echo 'bura';
                    exit;
                }
            }
        }
    
        echo json_encode(['icon' => 'success', 'message' => 'Eşleşmeler Başarıyla Değiştirildi']);
        return;
    }
    

    public function sevk_emirleri($data = null)
    {
        if ($data) {
            $sevkEmirleri = $this->modelEmirler
                ->whereIn("bitti", [1, 2, 3])
                ->orderBy("sevk_id", "DESC")
                ->findAll();
            $yazdirildi = 1;
        } else {
            $sevkEmirleri = $this->modelEmirler
                ->where("bitti", 0)
                ->orderBy("sevk_id", "ASC")
                ->findAll();
            $yazdirildi = 0;
        }
    
        // Tüm order_id'leri toplu olarak al
        $allOrderIds = [];
        foreach ($sevkEmirleri as $sevk) {
            $allOrderIds = array_merge($allOrderIds, explode(",", $sevk["order_id"]));
        }
        $allOrderIds = array_unique($allOrderIds); // Tekrarlı order_id'leri çıkar
    
        // Boş olmayan bir order_id listesi varsa sorguyu yap
        $orderMap = [];
        if (!empty($allOrderIds)) {
            // Toplu sorgu ile order_id'leri çek
            $orderRecords = $this->modelOrder
                ->select("order_no, order_id")
                ->whereIn("order_id", $allOrderIds)
                ->findAll();
    
            // order_id'ye göre order_no eşleştirme dizisi oluştur
            foreach ($orderRecords as $record) {
                $orderMap[$record["order_id"]] = $record["order_no"];
            }
        }
    
        // sevkEmirleri üzerinde dolaşarak order_no'ları ekle
        foreach ($sevkEmirleri as &$sevk) {
            $stoklar = explode(",", $sevk["order_id"]);
            $order_no_list = [];
            
            foreach ($stoklar as $stok) {
                if (isset($orderMap[$stok])) {
                    $order_no_list[] = $orderMap[$stok];
                }
            }
    
            // order_no'ları virgülle birleştir
            $sevk["order_no"] = implode(",", $order_no_list);
        }
        
    
        $data = [
            'sevkler' => $sevkEmirleri,
            'yazdirildi' => $yazdirildi,
            'page_title' => "Sevk Emirleri",
        ];
    
        return view('tportal/siparisler/sevkler', $data);
    }
    
    
    
    
    

    public function quickOrderPrint($invoice_id)
    {
        $invoice_item22 = $this->modelOrder->where('order.user_id', session()->get('user_id'))
            ->where('order.order_id', $invoice_id)
            ->first();

        $modelInvoice = $this->modelOrder->join('money_unit', 'money_unit.money_unit_id = order.money_unit_id')
            ->where('order.user_id', session()->get('user_id'))
            ->where('order.order_id', $invoice_id)
            ->first();

        if (!$modelInvoice) {
            return view('not-found');
        }


        $invoice_rows = $this->modelOrderRow->join('unit', 'unit.unit_id = order_row.unit_id')
            ->join('stock', 'stock.stock_id = order_row.stock_id')
            ->join('order', 'order.order_id = order_row.order_id')
            ->where('order.order_id', $invoice_id)
            ->findAll();

        $data = [
            'order_item' => $modelInvoice,
            'order_rows' => $invoice_rows
        ];

        // print_r($modelInvoice);
        // return;

        return view('tportal/siparisler/quickOrderPrint', $data);
    }

    public function sevkDetayliGuncelle($id)
    {
         // Sevk tablosundaki order_id'leri al
         $sevkSiparisleri = $this->modelEmirler->where("sevk_id", $id)->findAll();
   
        
         $html = '';
         $siparisDurumlari = [];
         foreach ($sevkSiparisleri as $siparis) {
             $orderIds = explode(',', $siparis['order_id']); // order_id'leri virgülle ayırıyoruz
         
             // Her bir order_id için işlem yapıyoruz
             foreach ($orderIds as $orderId) {
                 $orderId = trim($orderId); // Gereksiz boşlukları temizliyoruz
         
                 // Her siparişin son durumunu alalım
                 $siparisDurumlari[] = $this->modelOrder->where("order_id", $orderId)->first();
             }
         }
     
         // HTML içeriği oluştur
         $html = "";
         $count = 0;
         $counter = 0; // Sayaç tanımlıyoruz

         $toplamSiparis = count($siparisDurumlari);

         foreach ($siparisDurumlari as $siparisDurumu) {
         
             if($siparisDurumu['order_status'] != "sevk_edildi"){
             // Durumları kontrol ediyoruz
             switch ($siparisDurumu['order_status']) {
                 case 'new':
                     $statusText = 'Yeni Sipariş';
                     $statusTextColor = 'text-primary';
                     $statusBgColor = 'bg-primary';
                     break;
                 case 'sevk_emri':
                     $statusText = 'Sevk Emri Verildi';
                     $statusTextColor = 'text-primary';
                     $statusBgColor = 'bg-primary';
                     break;
                 case 'pending':
                     $statusText = 'Hazırlanıyor';
                     $statusTextColor = 'text-warning';
                     $statusBgColor = 'bg-warning';
                     break;
                 case 'success':
                     $statusText = 'Teslim Edildi';
                     $statusTextColor = 'text-success';
                     $statusBgColor = 'bg-success';
                     break;
                 case 'sevk_edildi':
                     $statusText = 'Sevk Edildi';
                     $statusTextColor = 'text-success';
                     $statusBgColor = 'bg-success';
                     break;
                 case 'failed':
                     $statusText = 'İptal';
                     $statusTextColor = 'text-danger';
                     $statusBgColor = 'bg-danger';
                     break;
                 case 'teknik_hata':
                     $statusText = 'Teknik Hata';
                     $statusTextColor = 'text-danger';
                     $statusBgColor = 'bg-danger';
                     break;
                 case 'stokta_yok':
                     $statusText = 'Stokta Yok';
                     $statusTextColor = 'text-danger';
                     $statusBgColor = 'bg-danger';
                     break;
                 default:
                     $statusText = 'Bilinmeyen';
                     $statusTextColor = 'text-secondary';
                     $statusBgColor = 'bg-secondary';
                     break;
             }
         
             $order_item = $siparisDurumu;
         
             $html .= ' <tr class="nk-tb-item">

               <td class="nk-tb-col tb-col-md"> <b>'.convert_datetime_for_view($siparisDurumu["order_date"]).'</b></td>
                        <input  type="hidden" name="sevk_id" value="'.$id.'">
                        <input  type="hidden" name="degisecek_id[]" value="'.$siparisDurumu["order_id"].'">
                                        <td class="nk-tb-col tb-col-md" style="padding-left:25px;">

                         <b>
                         <a target="_blank" href="'.route_to("tportal.siparisler.detail", $siparisDurumu["order_id"]).'">
                         '.substr($siparisDurumu["order_no"], 3).'
                         </a>
                         </b></td>
                                        <td class="nk-tb-col tb-col-md">

                             <div class="custom-control custom-radio no-control">
                                 <input type="radio" id="rd_cari_'.$siparisDurumu["order_no"].'" name="rd_cari" class="custom-control-input rd_cari" value="'.$siparisDurumu["order_no"].'" invoice_title="'.$siparisDurumu["cari_invoice_title"].'">
                                 <label class="custom-control-label text-primary" for="rd_cari_'.$siparisDurumu["order_no"].'">'.$siparisDurumu["cari_invoice_title"].'</label>
                             </div>
                         </td>
                         
                                         <td class="nk-tb-col tb-col-md">

                         <span class="badge badge-sm badge-dim '.$statusBgColor.' '.$statusTextColor.' ">'.$statusText.'</span></td>
                <td class="nk-tb-col nk-tb-col-tools  text-center">
                             <select class="form-select form-select-lg js-select2 form-control" name="orderStatus[]" required id="slct_order_status_' . $siparisDurumu["order_no"] . '" data-placeholder="Seçiniz">
                            <option value="'.$order_item['order_status'].'" selected>'.$statusText.'</option>
                            <option value="sevk_edildi"' . ($order_item['order_status'] == 'sevk_edildi' ? ' selected' : '') . '>Sevk Edildi</option>
                                                        <option value="failed"' . ($order_item['order_status'] == 'failed' ? ' selected' : '') . '>İptal Edildi</option>

                            <option value="teknik_hata"' . ($order_item['order_status'] == 'teknik_hata' ? ' selected' : '') . '>Teknik Hata</option>
                            <option value="stokta_yok"' . ($order_item['order_status'] == 'stokta_yok' ? ' selected' : '') . '>Stokta Yok</option>
                        </select>
                         </td>
                     </tr>';
         
             $counter++; // Sayaç değerini 1 artırıyoruz

             

            }
         }

         $data = [
            'page_title' => "Sevk Düzenle",
            'html' => $html,
            'id' => $id,
        ];
    
        return view('tportal/siparisler/sevkDuzenle', $data);
    }

    /*

    public function sevkEmirleri()
    {
        $transaction_prefix = "SVK";
        $order_ids = $this->request->getPost('order_id'); // order_id dizisini al
    
        if (empty($order_ids) || !is_array($order_ids)) {
            // Hata yönetimi: order_id dizisi boş veya geçersiz
            echo json_encode(['icon' => 'error', 'message' => 'Geçersiz sipariş ID dizisi.']);
            exit;
        }

       
        $sevk_no = $transaction_prefix . str_pad(rand(100, 10000), 6, '0', STR_PAD_LEFT);
    
        // Mevcut siparişleri kontrol et
        $existingOrders = $this->modelEmirler
            ->select('order_id')
            ->whereIn('order_id', $order_ids)
            ->findAll();
    
        // Mevcut sipariş ID'lerini birleştir ve virgülle ayır
        $existing_order_ids = [];
        foreach ($existingOrders as $order) {
            $existing_order_ids = array_merge($existing_order_ids, explode(',', $order['order_id']));
        }
    
        // Düz bir diziye dönüştür
        $existing_order_ids = array_unique($existing_order_ids);
    
        // Yeni sipariş ID'lerini belirle
        $new_order_ids = array_diff($order_ids, $existing_order_ids);
    
        if (empty($new_order_ids)) {
            // Tüm siparişler zaten mevcut, yeni sipariş eklenemedi
            return ['error' => 'Tüm siparişler zaten mevcut.'];
        }
    
        // Tek bir sevk emri oluştur
        $data = [
            'sevk_no' => $sevk_no,
            'order_id' => implode(',', $new_order_ids),
            'print' => 0 // Varsayılan değeri belirleyebilirsin
        ];
    
        // Yeni siparişleri ekle
        $this->modelEmirler->insert($data);
        $lastInsertId = $this->modelEmirler->insertID;    
        // Siparişlerin durumunu güncelle
        foreach ($new_order_ids as $order_id) {
            $this->modelOrder->update(
                ['order_id' => $order_id],
                ['order_status' => 'sevk_emri'] // Burada 'sevk_emri' yeni durum kodu
            );
            $this->modelOrderRow->set("order_row_status", "sevk_emri")->where("order_id", $order_id)->update();

            $this->modelIslem->LogOlustur(
                session()->get('client_id'),
                session()->get('user_id'),
                $order_id,
                'ok',
                'sevk',
                "Yeni Sipariş Sevk Emiri Oluşturuldu",
                session()->get("user_item")["user_adsoyad"],
                json_encode( ['order_id' => $order_id, 'order_status' => 'sevk_emri']),
                0,
                $order_id,
                0,
                $lastInsertId
             );
               
        }

    
    
        // Sonuçları döndür veya uygun bir şekilde işle
        return [
            'sevk_no' => $sevk_no,
            'order_ids' => implode(',', $new_order_ids)
        ];
    }
    */


    public function sevkEmirleri()
{
    try {
        $transaction_prefix = "SVK";
        $order_ids = $this->request->getPost('order_id');

        if (empty($order_ids) || !is_array($order_ids)) {
            return json_encode(['icon' => 'error', 'message' => 'Geçersiz sipariş ID dizisi.']);
        }

        $sevk_no = $transaction_prefix . str_pad(rand(100, 10000), 6, '0', STR_PAD_LEFT);

        // Mevcut siparişleri kontrol et
        $existingOrders = $this->modelEmirler
            ->select('order_id')
            ->whereIn('order_id', $order_ids)
            ->findAll();

        $existing_order_ids = [];
        foreach ($existingOrders as $order) {
            $existing_order_ids = array_merge($existing_order_ids, explode(',', $order['order_id']));
        }

        $existing_order_ids = array_unique($existing_order_ids);
        $new_order_ids = array_diff($order_ids, $existing_order_ids);

        if (empty($new_order_ids)) {
            return ['error' => 'Tüm siparişler zaten mevcut.'];
        }

        // Sevk emri oluştur
        $data = [
            'sevk_no' => $sevk_no,
            'order_id' => implode(',', $new_order_ids),
            'print' => 0
        ];

        $this->modelEmirler->insert($data);
        $lastInsertId = $this->modelEmirler->insertID;

        // Her bir sipariş için işlem yap
        foreach ($new_order_ids as $order_id) {
            // Sipariş durumunu güncelle
            $this->modelOrder->update(
                ['order_id' => $order_id],
                ['order_status' => 'sevk_emri']
            );
            
            // Sipariş satır durumunu güncelle
            $this->modelOrderRow->set("order_row_status", "sevk_emri")
                               ->where("order_id", $order_id)
                               ->update();

            // Log kaydı oluştur
            try {
                $logData = [
                    'client_id' => session()->get('client_id'),
                    'user_id' => session()->get('user_id'),
                    'log_islem_id' => $order_id,
                    'log_durum' => 'ok',
                    'log_islem' => 'sevk',
                    'log_mesaj' => "Yeni Sipariş Sevk Emiri Oluşturuldu",
                    'user_adi' => session()->get("user_item")["user_adsoyad"],
                    'log_ham_data' => json_encode(['order_id' => $order_id, 'order_status' => 'sevk_emri']),
                    'stock_id' => 0,
                    'siparis_id' => $order_id,
                    'fatura_id' => 0,
                    'sevk_id' => $lastInsertId
                ];
                
                $this->modelIslem->LogOlustur(...array_values($logData));
                
            } catch (\Exception $e) {
                log_message('error', 'Log oluşturma hatası: ' . $e->getMessage());
                // Log hatası olsa bile işleme devam et
                continue;
            }
        }

        return [
            'status' => 'success',
            'sevk_no' => $sevk_no,
            'order_ids' => implode(',', $new_order_ids)
        ];

    } catch (\Exception $e) {
        log_message('error', 'Sevk emri oluşturma hatası: ' . $e->getMessage());
        return [
            'status' => 'error',
            'message' => 'Sevk emri oluşturulurken bir hata oluştu: ' . $e->getMessage()
        ];
    }
}

    public function fabrika_aktar()
    {
        try {
            $order_ids = $this->request->getPost('order_id');
            
            // order_ids değerini doğru formata çevir
            $processed_order_ids = [];
            
            if (is_array($order_ids)) {
                foreach ($order_ids as $item) {
                    if (is_array($item) && isset($item['id'])) {
                        // Çoklu sipariş formatı: [{"id": "390", "durum": "YENİ SİPARİŞ"}]
                        $processed_order_ids[] = $item['id'];
                    } elseif (is_string($item) || is_numeric($item)) {
                        // Tekli sipariş formatı: ["390"] veya [390]
                        $processed_order_ids[] = $item;
                    }
                }
            } elseif (is_string($order_ids) || is_numeric($order_ids)) {
                // Tekli sipariş formatı: "390" veya 390
                $processed_order_ids[] = $order_ids;
            }
            

            
            if (empty($processed_order_ids)) {
                throw new \Exception('Geçersiz sipariş ID dizisi.');
            }
    
            // Uzak veritabanı bağlantısını al
            $remoteDb = $this->mshapp();

            if (!$remoteDb) {
                throw new \Exception('Uzak sunucu bağlantısı kurulamadı.');
            }
    
            $user_id = 16;
            $magazaSiparisCari = 4352;
    
            // Uzak sunucudan cari bilgilerini al
            $remoteCari = $remoteDb->table('cari')
                ->where('cari_id', $magazaSiparisCari)
                ->get()
                ->getRowArray();
    

    
            if (!$remoteCari) {
                throw new \Exception('Uzak sunucuda cari bilgileri bulunamadı.');
            }
    
            // Uzak sunucudan varsayılan adres bilgilerini al
            $remoteAddress = $remoteDb->table('address')
                ->where('cari_id', $magazaSiparisCari)
                ->where('default', 'true')
                ->get()
                ->getRowArray();
    

    
            if (!$remoteAddress) {
                throw new \Exception('Uzak sunucuda adres bilgileri bulunamadı.');
            }
    
            // Ana veritabanından siparişleri al
            $localOrders = $this->modelOrder->whereIn('order_id', $processed_order_ids)->findAll();
            if (empty($localOrders)) {
                throw new \Exception('Seçili siparişler bulunamadı.');
            }
    
            $localOrderRows = $this->modelOrderRow->whereIn('order_id', $processed_order_ids)->findAll();
    
            $remoteDb->transStart(); // Transaction başlat
    
            foreach ($localOrders as $localOrder) {
                // Fiyat alanlarını sıfırla ve cari bilgilerini güncelle
                $orderData = [
                    'user_id' => $user_id,
                    'currency_amount' => 0,
                    'stock_total' => 0, 'stock_total_try' => 0,
                    'discount_total' => 0, 'discount_total_try' => 0,
                    'tax_rate_1_amount' => 0, 'tax_rate_1_amount_try' => 0,
                    'tax_rate_10_amount' => 0, 'tax_rate_10_amount_try' => 0,
                    'tax_rate_20_amount' => 0, 'tax_rate_20_amount_try' => 0,
                    'sub_total' => 0, 'sub_total_try' => 0,
                    'sub_total_0' => 0, 'sub_total_0_try' => 0,
                    'sub_total_1' => 0, 'sub_total_1_try' => 0,
                    'sub_total_10' => 0, 'sub_total_10_try' => 0,
                    'sub_total_20' => 0, 'sub_total_20_try' => 0,
                    'grand_total' => 0, 'grand_total_try' => 0,
                    'amount_to_be_paid' => 0, 'amount_to_be_paid_try' => 0,
                    
                    // Cari bilgilerini güncelle
                    'cari_id' => $magazaSiparisCari,
                    'cari_identification_number' => $remoteCari['identification_number'],
                    'cari_tax_administration' => $remoteCari['tax_administration'],
                    'cari_invoice_title' => $remoteCari['invoice_title'],
                    'cari_name' => $remoteCari['name'],
                    'cari_surname' => $remoteCari['surname'],
                    'cari_obligation' => $remoteCari['obligation'],
                    'cari_company_type' => $remoteCari['company_type'],
                    'cari_phone' => $remoteCari['cari_phone'],
                    'cari_email' => $remoteCari['cari_email'],
                    
                    // Adres bilgilerini güncelle
                    'address_country' => $remoteAddress['address_country'],
                    'address_city' => $remoteAddress['address_city'],
                    'address_city_plate' => $remoteAddress['address_city_plate'],
                    'address_district' => $remoteAddress['address_district'],
                    'address_zip_code' => $remoteAddress['zip_code'],
                    'address' => $remoteAddress['address']
                ];
    
                // Orijinal siparişin değişmemesi gereken alanlarını koru
                $orderData['order_no'] = $localOrder['order_no'];
                $orderData['order_date'] = $localOrder['order_date'];
                $orderData['order_status'] = $localOrder['order_status'];
                $orderData['order_direction'] = $localOrder['order_direction'];
                $orderData['order_note'] = $localOrder['order_note'];
                $orderData['money_unit_id'] = $localOrder['money_unit_id'];
    

    
                try {
                    // Uzaktaki veritabanında sipariş kontrolü
                    $remoteOrder = $remoteDb->table('order')
                        ->where('order_no', $localOrder['order_no'])
                        ->get()
                        ->getRowArray();
    
                    if ($remoteOrder) {
                        // Sipariş güncelleme
                        $remoteDb->table('order')
                            ->where('order_no', $localOrder['order_no'])
                            ->update($orderData);
                    } else {
                        // Yeni sipariş ekleme
                        $orderData['msh_order_id'] = null;
                        $remoteDb->table('order')->insert($orderData);
                        $remoteOrder['order_id'] = $remoteDb->insertID();
    
                        // Uzak veritabanında `msh_order_id` güncelleme
                        $remoteDb->table('order')
                            ->where('order_id', $remoteOrder['order_id'])
                            ->update(['msh_order_id' => $localOrder['order_id']]);
                    }
    
                    // Ana veritabanında `msh_order_id` güncelleme
                    $this->modelOrder->update($localOrder['order_id'], ['msh_order_id' => $remoteOrder['order_id']]);
    
                    // Sipariş satırlarını işleme
                    foreach ($localOrderRows as $localOrderRow) {
                        if ($localOrderRow['order_id'] == $localOrder['order_id']) {
                            $orderRowData = [
                                'user_id' => $user_id,
                                'stock_id' => $localOrderRow['stock_id'],
                                'stock_barcode_id' => $localOrderRow['stock_barcode_id'],
                                'stock_title' => $localOrderRow['stock_title'],
                                'stock_amount' => $localOrderRow['stock_amount'],
                                'unit_id' => $localOrderRow['unit_id'],
                                'order_row_status' => $localOrderRow['order_row_status'],
                                
                                // Tüm fiyat alanlarını sıfırla
                                'unit_price' => 0,
                                'discount_rate' => 0,
                                'discount_price' => 0,
                                'subtotal_price' => 0,
                                'tax_price' => 0,
                                'total_price' => 0,
                                
                                // Diğer önemli alanları koru
                                'varyantlar' => $localOrderRow['varyantlar'],
                                'paket' => $localOrderRow['paket'],
                                'paket_text' => $localOrderRow['paket_text']
                            ];
    
                            $remoteOrderRow = $remoteDb->table('order_row')
                                ->where('stock_id', $localOrderRow['stock_id'])
                                ->where('order_id', $remoteOrder['order_id'])
                                ->get()
                                ->getRowArray();
    
                            if ($remoteOrderRow) {
                                $remoteDb->table('order_row')
                                    ->where('order_row_id', $remoteOrderRow['order_row_id'])
                                    ->update($orderRowData);
                            } else {
                                $orderRowData['order_id'] = $remoteOrder['order_id'];
                                $remoteDb->table('order_row')->insert($orderRowData);
                            }
                        }
                    }
    
                } catch (\Exception $e) {
                    $remoteDb->transRollback();
                    throw new \Exception('Sipariş işleme hatası: ' . $e->getMessage());
                }
            }
    
            $remoteDb->transComplete(); // Transaction'ı tamamla
    
            if ($remoteDb->transStatus() === false) {
                throw new \Exception('Veritabanı işlemi başarısız oldu.');
            }
    
            echo json_encode(['icon' => 'success', 'message' => 'Siparişler başarıyla aktarıldı.']);
    
        } catch (\Exception $e) {
            echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public function fabrika_aktar_eski()
    {
        $order_ids = $this->request->getPost('order_id'); // Seçili sipariş ID'leri
        
        if (empty($order_ids) || !is_array($order_ids)) {
            echo json_encode(['icon' => 'error', 'message' => 'Geçersiz sipariş ID dizisi.']);
            return;
        }
    
        // Ana veritabanından siparişleri al
        $localOrders = $this->modelOrder->whereIn('order_id', $order_ids)->findAll();
        $localOrderRows = $this->modelOrderRow->whereIn('order_id', $order_ids)->findAll();
    
        // Uzak veritabanı bağlantısını al
        $remoteDb = $this->mshapp();
        $user_id = 16;
        $magazaSiparisCari = 4352;

        
    
        foreach ($localOrders as $localOrder) {
            // Uzaktaki veritabanında sipariş kontrolü
            $remoteOrder = $remoteDb->table('order')
                ->where('order_no', $localOrder['order_no'])
                ->get()
                ->getRowArray();
    
            // user_id'yi ekle veya güncelle
            $localOrder['user_id'] = $user_id;
    
            if ($remoteOrder) {
                // Sipariş güncelleme
                $remoteDb->table('order')
                    ->where('order_no', $localOrder['order_no'])
                    ->update($localOrder);
            } else {
                // Yeni sipariş ekleme
                $localOrder['msh_order_id'] = null; // Düzgün bir ilişki için başta null bırakıyoruz
                $remoteDb->table('order')->insert($localOrder);
                $remoteOrder['order_id'] = $remoteDb->insertID(); // Yeni ID al
    
                // Uzak veritabanında `msh_order_id` güncelleme
                $remoteDb->table('order')
                    ->where('order_id', $remoteOrder['order_id'])
                    ->update(['msh_order_id' => $localOrder['order_id']]);
            }
    
            // Ana veritabanında `msh_order_id` güncelleme
            $this->modelOrder->update($localOrder['order_id'], ['msh_order_id' => $remoteOrder['order_id']]);
    
            // Sipariş satırlarını işleme
            foreach ($localOrderRows as $localOrderRow) {
                if ($localOrderRow['order_id'] == $localOrder['order_id']) {
                    // Uzak sunucuda sipariş satırı kontrolü
                    $remoteOrderRow = $remoteDb->table('order_row')
                        ->where('stock_id', $localOrderRow['stock_id'])
                        ->where('order_id', $remoteOrder['order_id'])
                        ->get()
                        ->getRowArray();
    
                    // user_id'yi ekle veya güncelle
                    $localOrderRow['user_id'] = $user_id;
    
                    if ($remoteOrderRow) {
                        // Satır güncelleme
                        $remoteDb->table('order_row')
                            ->where('order_row_id', $remoteOrderRow['order_row_id'])
                            ->update($localOrderRow);
                    } else {
                        // Yeni satır ekleme
                        $localOrderRow['order_id'] = $remoteOrder['order_id']; // Yeni sipariş ID'sini bağla
                        $remoteDb->table('order_row')->insert($localOrderRow);
                    }
                }
            }
        }
    
        echo json_encode(['icon' => 'success', 'message' => 'Siparişler başarıyla aktarıldı.']);
    }
    
    
    
    public function sevkGetir()
    {
        $order_ids = $this->request->getPost('sevk_id'); // order_id dizisini al
    
        if (empty($order_ids) || !is_array($order_ids)) {
            // Hata yönetimi: order_id dizisi boş veya geçersiz
            echo json_encode(['icon' => 'error', 'message' => 'Geçersiz sipariş ID dizisi.']);
            exit;
        }

        
        $acikSevkler = $this->modelEmirler->where("sevk_id", $order_ids)->first();

        if ($acikSevkler) {
            $sevkId = $acikSevkler["sevk_id"];
            
            // Sevk tablosundaki order_id'leri al
            $sevkSiparisleri = $this->modelEmirler->where("sevk_id", $sevkId)->findAll();
   
        
            $html = '';
            $siparisDurumlari = [];
            foreach ($sevkSiparisleri as $siparis) {
                $orderIds = explode(',', $siparis['order_id']); // order_id'leri virgülle ayırıyoruz
            
                // Her bir order_id için işlem yapıyoruz
                foreach ($orderIds as $orderId) {
                    $orderId = trim($orderId); // Gereksiz boşlukları temizliyoruz
            
                    // Her siparişin son durumunu alalım
                    $siparisDurumlari[] = $this->modelOrder
                    ->where("order_id", $orderId)
                    ->orderBy('order_date', 'ASC')
                    ->first(); // Her order_id için en yeni kaydı alır
                }
            }
        
            // HTML içeriği oluştur
            $html = "";
            $count = 0;
            $counter = 0; // Sayaç tanımlıyoruz
            $countSiparis = 0; // Sayaç tanımlıyoruz

            $toplamSiparis = count($siparisDurumlari);


           

            foreach ($siparisDurumlari as $siparisDurumu) {


                    if($siparisDurumu['order_status'] != "sevk_edildi"){
                        $countSiparis++;

                        // Durumları kontrol ediyoruz
                        switch ($siparisDurumu['order_status']) {
                            case 'new':
                                $statusText = 'Yeni Sipariş';
                                $statusTextColor = 'text-primary';
                                $statusBgColor = 'bg-primary';
                                break;
                            case 'sevk_emri':
                                $statusText = 'Sevk Emri Verildi';
                                $statusTextColor = 'text-primary';
                                $statusBgColor = 'bg-primary';
                                break;
                            case 'pending':
                                $statusText = 'Hazırlanıyor';
                                $statusTextColor = 'text-warning';
                                $statusBgColor = 'bg-warning';
                                break;
                            case 'success':
                                $statusText = 'Teslim Edildi';
                                $statusTextColor = 'text-success';
                                $statusBgColor = 'bg-success';
                                break;
                            case 'sevk_edildi':
                                $statusText = 'Sevk Edildi';
                                $statusTextColor = 'text-success';
                                $statusBgColor = 'bg-success';
                                break;
                            case 'failed':
                                $statusText = 'İptal';
                                $statusTextColor = 'text-danger';
                                $statusBgColor = 'bg-danger';
                                break;
                            case 'teknik_hata':
                                $statusText = 'Teknik Hata';
                                $statusTextColor = 'text-danger';
                                $statusBgColor = 'bg-danger';
                                break;
                            case 'stokta_yok':
                                $statusText = 'Stokta Yok';
                                $statusTextColor = 'text-danger';
                                $statusBgColor = 'bg-danger';
                                break;
                            default:
                                $statusText = 'Bilinmeyen';
                                $statusTextColor = 'text-secondary';
                                $statusBgColor = 'bg-secondary';
                                break;
                        }

                }
            }

            $countSayi = 0;

            foreach ($siparisDurumlari as $siparisDurumu) {
                if ($counter >= 5) {
                    break; // Sayaç 5'e ulaştıysa döngüyü sonlandırıyoruz
                }

                if($siparisDurumu['order_status'] != "sevk_edildi"){
                    $countSayi++;
            
                // Durumları kontrol ediyoruz
                switch ($siparisDurumu['order_status']) {
                    case 'new':
                        $statusText = 'Yeni Sipariş';
                        $statusTextColor = 'text-primary';
                        $statusBgColor = 'bg-primary';
                        break;
                    case 'sevk_emri':
                        $statusText = 'Sevk Emri Verildi';
                        $statusTextColor = 'text-primary';
                        $statusBgColor = 'bg-primary';
                        break;
                    case 'pending':
                        $statusText = 'Hazırlanıyor';
                        $statusTextColor = 'text-warning';
                        $statusBgColor = 'bg-warning';
                        break;
                    case 'success':
                        $statusText = 'Teslim Edildi';
                        $statusTextColor = 'text-success';
                        $statusBgColor = 'bg-success';
                        break;
                    case 'sevk_edildi':
                        $statusText = 'Sevk Edildi';
                        $statusTextColor = 'text-success';
                        $statusBgColor = 'bg-success';
                        break;
                    case 'failed':
                        $statusText = 'İptal';
                        $statusTextColor = 'text-danger';
                        $statusBgColor = 'bg-danger';
                        break;
                    case 'teknik_hata':
                        $statusText = 'Teknik Hata';
                        $statusTextColor = 'text-danger';
                        $statusBgColor = 'bg-danger';
                        break;
                    case 'stokta_yok':
                        $statusText = 'Stokta Yok';
                        $statusTextColor = 'text-danger';
                        $statusBgColor = 'bg-danger';
                        break;
                    default:
                        $statusText = 'Bilinmeyen';
                        $statusTextColor = 'text-secondary';
                        $statusBgColor = 'bg-secondary';
                        break;
                }
            
                $order_item = $siparisDurumu;
            
                $html .= '<tr style="line-height:35px;">
                <td> <b>'.convert_datetime_for_view($siparisDurumu["order_date"]).'</b></td>
                            <td class="cari_code">
                           
                            <b>
                            <a target="_blank" href="'.route_to("tportal.siparisler.detail", $siparisDurumu["order_id"]).'">
                            '.substr($siparisDurumu["order_no"], 3).'
                            </a>
                            </b></td>
                            <td data-order="0">
                                <div class="custom-control custom-radio no-control">
                                    <input type="radio" id="rd_cari_'.$siparisDurumu["order_no"].'" name="rd_cari" class="custom-control-input rd_cari" value="'.$siparisDurumu["order_no"].'" invoice_title="'.$siparisDurumu["cari_invoice_title"].'">
                                    <label class="custom-control-label text-primary" for="rd_cari_'.$siparisDurumu["order_no"].'">'.$siparisDurumu["cari_invoice_title"].'</label>
                                </div>
                            </td>
                            <td class="cari_phone"><span class="badge badge-sm badge-dim '.$statusBgColor.' '.$statusTextColor.' ">'.$statusText.'</span></td>
                        </tr>';
            
                $counter++; // Sayaç değerini 1 artırıyoruz
            }
                
            }

            $link = route_to("tportal.siparisler.sevkDetayliGuncelle", $sevkId);
        
            echo json_encode([
                'link' => $link,
                'toplamSiparis' => $countSiparis,
                'icon' => 'success',
                'message' => 'Açık Sevk Emri Olduğundan Yeni Sevk Emri Oluşturulamadı..',
                'sevk_id' => $sevkId,
                'html' => $html
            ]);
            exit;
        }
       
    }


    public function sevkGuncelle()
{
    $sevk_id = $this->request->getPost("sevk_id");
    $new_sevk_status = $this->request->getPost("new_sevk_status");



    

    // İlk olarak ilgili sevk kaydını alıyoruz
    $modelEmirler = $this->modelEmirler->where("sevk_id", $sevk_id)->first();

    if (!$modelEmirler) {
        // Sevk kaydı bulunamadıysa, işlem yapmadan çıkıyoruz
        return;
    }

    // Sevk edilen siparişlerin order_id'lerini alıyoruz
    $orderIds = explode(',', $modelEmirler['order_id']);

    // Biten siparişleri saymak için değişken
    $bitenSiparisler = 0;
    $eskiBiten = 0;

    $logData = [];
    // Her bir sipariş için durum güncellemesi ve kontrolü yapıyoruz
    foreach ($orderIds as $orderId) {
        // OrderModel üzerinden order_status kontrolü
        $order = $this->modelOrder->where("order_id", $orderId)->orderby("order_date", "ASC")->first();
        $order_row = $this->modelOrderRow->where("order_id", $orderId)->first();

        if ($order) {
            // Sevk edilen, yeni, başarılı ve hazırlanıyor durumundaki siparişleri atlıyoruz
            if (in_array($order['order_status'], ['sevk_edildi', 'new', 'success', 'pending'])) {
                $eskiBiten++;
                continue;
            }

            // Eğer status failed, teknik_hata veya stokta_yok ise güncelleme yapıyoruz
            if (in_array($new_sevk_status, ['failed', 'sevk_edildi', 'kargo_bekliyor','teknik_hata', 'stokta_yok'])) {
                $this->modelOrder->update($orderId, ['order_status' => $new_sevk_status]);
                $this->modelOrderRow->set(['order_row_status' => $new_sevk_status])->where("order_id", $orderId)->update();
                $this->modelIslem->LogOlustur(
                    session()->get('client_id'),
                    session()->get('user_id'),
                    $orderId,
                    'ok',
                    'sevk',
                    "Seçili siparişlerde manuel sevk  durum güncellemesi yapıldı.",
                    session()->get("user_item")["user_adsoyad"],
                    json_encode(["order" => $order, "order_row" => $order_row]),
                    0,
                    $orderId,
                    0,
                    $sevk_id
            );
                // Bu durumda siparişi bitmiş sayıyoruz
                $bitenSiparisler++;
            }

            
        }
    }

    // Toplam sipariş sayısı
    $bitenSiparisler = $bitenSiparisler +  $eskiBiten;
    $Hesapla = (count($orderIds) - $bitenSiparisler);
    $toplamSiparisler = $Hesapla;

    $updateEmir = "";
    // Eğer biten sipariş sayısı toplam sipariş sayısına eşitse sevkiyat emrini güncelle
    if ($bitenSiparisler === count($orderIds)) {
       $updateEmir = $this->modelEmirler->set("bitti", 3)->where("sevk_id", $sevk_id)->update();
    }

    if(isset($updateEmir)){

        echo json_encode(['icon' => 'success', 'message' => 'Sevkiyat Emiri Başarıyla Kapatıldı.']);
        return;
    }else{
        echo json_encode(['icon' => 'error', 'message' => 'Sevkiyat Emiri Kapatılırken Bir Hata Oluştu']);
        return;
    }
    if (!empty($logData)) {
        $this->modelIslem->insertBatch($logData);
    }
}

public function sevkManuelGuncelle()
{
    $sevk_id = $this->request->getPost("sevk_id");
    $degisecek_id = $this->request->getPost("degisecek_id"); // Array olarak geliyor
    $orderStatus = $this->request->getPost("orderStatus"); // Array olarak geliyor

    // İlk olarak ilgili sevk kaydını alıyoruz
    $modelEmirler = $this->modelEmirler->where("sevk_id", $sevk_id)->first();

    if (!$modelEmirler) {
        // Sevk kaydı bulunamadıysa, işlem yapmadan çıkıyoruz
        return;
    }

    // Biten siparişleri saymak için değişken
    $bitenSiparisler = 0;
    $eskiBiten = 0;

    // Log kayıtları için geçici bir dizi oluşturuyoruz
    $logData = [];

    // Her bir sipariş için durum güncellemesi ve kontrolü yapıyoruz
    foreach ($degisecek_id as $index => $orderId) {
        // İlgili orderStatus'u alıyoruz
        $status = $orderStatus[$index];

        // OrderModel üzerinden order_status kontrolü
        $order = $this->modelOrder->where("order_id", $orderId)->orderby("order_date", "ASC")->first();
        $order_row = $this->modelOrderRow->where("order_id", $orderId)->first();

        if ($order) {
            // Sevk edilen, yeni, başarılı ve hazırlanıyor durumundaki siparişleri atlıyoruz
            if (in_array($order['order_status'], ['sevk_edildi', 'new', 'success', 'pending'])) {
                $eskiBiten++;
                continue;
            }

            // Eğer status failed, teknik_hata veya stokta_yok ise güncelleme yapıyoruz
            if (in_array($status, ['failed', 'sevk_edildi', 'kargo_bekliyor', 'teknik_hata', 'stokta_yok'])) {
                $this->modelOrder->update($orderId, ['order_status' => $status]);
                $this->modelOrderRow->set(['order_row_status' => $status])->where("order_id", $orderId)->update();
                $this->modelIslem->LogOlustur(
                        session()->get('client_id'),
                        session()->get('user_id'),
                        $orderId,
                        'ok',
                        'sevk',
                        "Seçili siparişlerde manuel sevk  durum güncellemesi yapıldı.",
                        session()->get("user_item")["user_adsoyad"],
                        json_encode(["order" => $order, "order_row" => $order_row]),
                        0,
                        $orderId,
                        0,
                        $sevk_id
                );
                // Bu durumda siparişi bitmiş sayıyoruz
                $bitenSiparisler++;
            }

            // Log verilerini toplu olarak eklemek için geçici dizimize ekliyoruz
           
        }
    }

    // Toplam sipariş sayısı
    $bitenSiparisler += $eskiBiten;
    $Hesapla = (count($degisecek_id) - $bitenSiparisler);
    $toplamSiparisler = $Hesapla;

    // Eğer biten sipariş sayısı toplam sipariş sayısına eşitse sevkiyat emrini güncelle
    if ($bitenSiparisler === count($degisecek_id)) {
       $this->modelEmirler->set("bitti", 3)->where("sevk_id", $sevk_id)->update();
    }

    // Log verilerini tek bir sorguda veritabanına ekliyoruz
    if (!empty($logData)) {
        $this->modelIslem->insertBatch($logData);
    }

    echo json_encode(['icon' => 'success', 'message' => 'Sevkiyat Emiri Başarıyla Kapatıldı.']);
    return;
}


/*
public function sevkManuelGuncelle()
{
    $sevk_id = $this->request->getPost("sevk_id");
    $degisecek_id = $this->request->getPost("degisecek_id"); // Array olarak geliyor
    $orderStatus = $this->request->getPost("orderStatus"); // Array olarak geliyor

    // İlk olarak ilgili sevk kaydını alıyoruz
    $modelEmirler = $this->modelEmirler->where("sevk_id", $sevk_id)->first();

    if (!$modelEmirler) {
        // Sevk kaydı bulunamadıysa, işlem yapmadan çıkıyoruz
        return;
    }

    // Biten siparişleri saymak için değişken
    $bitenSiparisler = 0;
    $eskiBiten = 0;

    // Her bir sipariş için durum güncellemesi ve kontrolü yapıyoruz
    foreach ($degisecek_id as $index => $orderId) {
        // İlgili orderStatus'u alıyoruz
        $status = $orderStatus[$index];


        // OrderModel üzerinden order_status kontrolü
        $order = $this->modelOrder->where("order_id", $orderId)->orderby("order_date", "ASC")->first();

        if ($order) {
            // Sevk edilen, yeni, başarılı ve hazırlanıyor durumundaki siparişleri atlıyoruz
            if (in_array($order['order_status'], ['sevk_edildi', 'new', 'success', 'pending'])) {
                $eskiBiten++;
                continue;
            }

            // Eğer status failed, teknik_hata veya stokta_yok ise güncelleme yapıyoruz
            if (in_array($status, ['failed', 'sevk_edildi', 'kargo_bekliyor', 'teknik_hata', 'stokta_yok'])) {
               
                $this->modelOrder->update($orderId, ['order_status' => $status]);
                $this->modelOrderRow->set(['order_row_status' => $status])->where("order_id", $orderId)->update();

                // Bu durumda siparişi bitmiş sayıyoruz
                $bitenSiparisler++;
            }


              
            $this->modelIslem->LogOlustur(
                session()->get('client_id'), 
                session()->get('user_id'), 
                $orderId, 
                'ok',  
                'siparis',
                "Seçili siparişlerde manuel sevk  durum güncellemesi yapıldı.", 
                session()->get("user_item")["user_adsoyad"],
                json_encode(['order_status' => $status]),
                0,
                $orderId,
                0,
                0
            );


           /* $this->modelIslem->LogOlustur(
                session()->get('client_id'), 
                session()->get('user_id'), 
                $orderId, 
                'ok',  
                'sevk', 
                'Sevkiyat Emiri Başarıyla Kapatıldı.',
                session()->get("user_item")["user_adsoyad"],
                json_encode($order)
            ); 
        }
    }

    // Toplam sipariş sayısı
    $bitenSiparisler = $bitenSiparisler +  $eskiBiten;
    $Hesapla = (count($degisecek_id) - $bitenSiparisler);
    $toplamSiparisler = $Hesapla;
    $updateEmir = "";

    // Eğer biten sipariş sayısı toplam sipariş sayısına eşitse sevkiyat emrini güncelle
    if ($bitenSiparisler === count($degisecek_id)) {
       $updateEmir = $this->modelEmirler->set("bitti", 3)->where("sevk_id", $sevk_id)->update();
    }

  
   


    echo json_encode(['icon' => 'success', 'message' => 'Sevkiyat Emiri Başarıyla Kapatıldı.']);
    return;
} */


public function sevkPrintsv3($invoice_id)
{
    // modelEmirler tablosundan ilgili sevk emrini çek
    $modelEmirler = $this->modelEmirler
        ->where('sevk_id', $invoice_id)
        ->first();

    // Eğer sevk emri bulunamazsa, 'not-found' görünümüne yönlendir
    if (!$modelEmirler) {
        return view('not-found');
    }

    // Sevk emri print durumunu güncelle
    $this->modelEmirler->set("print", 1)->where("sevk_id", $invoice_id)->update();

    // order_id'leri al
    $order_ids = explode(',', $modelEmirler['order_id']);

    // modelOrder tablosundan bu order_id'ler ile ilgili siparişleri çek ve en eskiye göre sırala
    $orders = $this->modelOrder
        ->whereIn('order_id', $order_ids)
        ->where("order_status", "sevk_emri")
        ->orderBy("order_date", "ASC")
        ->findAll();

    // Her bir sipariş ve siparişe ait ürünleri sipariş bazlı organize et
    $order_rows = [];

    foreach ($orders as $order) {
        // Siparişe ait satırları çek
        $rows = $this->modelOrderRow
            ->where('order_id', $order['order_id'])
            ->findAll();

        // Sipariş detaylarını tutacak dizi
        $order_data = [
            'order_id' => $order['order_id'],
            'order_no' => $order['order_no'],
            'order_date' => $order['order_date'],
            'customer' => $order['cari_invoice_title'] ?? $order["invoice_title"],
            'shipping' => $order["kargo"] ?? "Kargo Yok!", 
            'status' => $order['order_status'],
            'items' => [] // Bu siparişe ait ürünleri burada tutacağız
        ];

        // Sipariş içindeki her bir ürünü ekleyelim
        foreach ($rows as $row) {
            $product_id = $row['stock_id'];
            $stockData = $this->modelStock->where("stock_id", $product_id)->first();
            $gallery = $this->modelStockGallery->where("stock_id", $product_id)->findAll();

            // Ürün detayları
            $product_data = [
                'product_id' => $product_id,
                'order_no' => $order['order_no'],
                'order_date' => $order['order_date'],
                'kargo' => $order['kargo'],
                'stok_miktari' => $stockData["stock_total_quantity"] ?? 0,
                'status' => $order['order_status'],
                'title' => $row['stock_title'], 
                'code' => $stockData["stock_code"] ?? '', 
                'barcode' => $stockData["stock_barcode"] ?? '', 
                'quantity' => $row['stock_amount'],
                'price' => $row['total_price'],
                'default_image' => $stockData["default_image"] ?? '',
                'warehouse_location' => $stockData["warehouse_address"] ?? '',
                'gallery' => $gallery
            ];

            // Ürünü, sipariş içindeki ürünler listesine ekle
            $order_data['items'][] = $product_data;
        }

        // Siparişi order_rows dizisine ekle
        $order_rows[] = $order_data;
    }

 
    // Verileri görünüm için hazırlayın
    $data = [
        'order_item' => $modelEmirler,
        'orders' => $order_rows // Artık sipariş bazlı yapıda
    ];

    return view('tportal/siparisler/sevkPrintsv3', $data);
}
    

public function sevkPrints($invoice_id)
{
    // Kargo sıralamasını belirleyen dizi (küçük harflerle normalize edilmiş)
    $kargoSiralama = [
        "ptt kargo marketplace" => "ptt kargo marketplace",
        "aras" => "aras",
        "hepsijet" => "hepsijet",
        "yurtiçi" => "yurtiçi"
    ];

    // modelEmirler tablosundan ilgili sevk emrini çek
    $modelEmirler = $this->modelEmirler
        ->where('sevk_id', $invoice_id)
        ->first();

    if (!$modelEmirler) {
        return view('not-found');
    }

    $this->modelEmirler->set("print", 1)->where("sevk_id", $invoice_id)->update();

    $order_ids = explode(',', $modelEmirler['order_id']);

    $orders = $this->modelOrder
        ->whereIn('order_id', $order_ids)
        ->orderBy("order_date", "ASC")
        ->findAll();

    $order_rows = [];

    foreach ($orders as $order) {
        $rows = $this->modelOrderRow
            ->where('order_id', $order['order_id'])
            ->findAll();

        $order_data = [
            'order_id' => $order['order_id'],
            'order_no' => $order['order_no'],
            'order_date' => $order['order_date'],
            'customer' => $order['cari_invoice_title'] ?? $order["invoice_title"],
            'shipping' => $order["kargo"] ?? "Kargo Yok!", 
            'status' => $order['order_status'],
            'items' => []
        ];

        foreach ($rows as $row) {
            $product_id = $row['stock_id'];
            $stockData = $this->modelStock->where("stock_id", $product_id)->first();
            $gallery = $this->modelStockGallery->where("stock_id", $product_id)->findAll();

            $product_data = [
                'product_id' => $product_id,
                'order_no' => $order['order_no'],
                'order_date' => $order['order_date'],
                'kargo' => $order['kargo'],
                'stok_miktari' => $stockData["stock_total_quantity"] ?? 0,
                'status' => $order['order_status'],
                'title' => $row['stock_title'], 
                'code' => $stockData["stock_code"] ?? '', 
                'barcode' => $stockData["stock_barcode"] ?? '', 
                'quantity' => $row['stock_amount'],
                'price' => $row['total_price'],
                'default_image' => $stockData["default_image"] ?? '',
                'warehouse_location' => $stockData["warehouse_address"] ?? '',
                'gallery' => $gallery
            ];

            $order_data['items'][] = $product_data;
        }

        $order_rows[] = $order_data;
    }

    // Kargo ve tarihe göre sıralama yap
    usort($order_rows, function ($a, $b) use ($kargoSiralama) {
        // Kargo adlarını küçük harfe çevirip normalize et
        $normalizedA = $kargoSiralama[mb_strtolower($a['shipping'])] ?? $a['shipping'];
        $normalizedB = $kargoSiralama[mb_strtolower($b['shipping'])] ?? $b['shipping'];

        $kargoA = array_search($normalizedA, array_keys($kargoSiralama));
        $kargoB = array_search($normalizedB, array_keys($kargoSiralama));

        if ($kargoA === $kargoB) {
            // Aynı kargo ise, tarihe göre sıralama yap
            return strtotime($a['order_date']) - strtotime($b['order_date']);
        }

        // Kargo sırasına göre sıralama yap
        return $kargoA - $kargoB;
    });

    $data = [
        'order_item' => $modelEmirler,
        'orders' => $order_rows
    ];

    return view('tportal/siparisler/sevkPrints', $data);
}



public function sevkPrints_tarih($invoice_id)
{
    // Kargo sıralamasını belirleyen dizi (küçük harflerle normalize edilmiş)
    $kargoSiralama = [
        "ptt kargo marketplace" => "ptt kargo marketplace",
        "aras" => "aras",
        "hepsijet" => "hepsijet",
        "yurtiçi" => "yurtiçi"
    ];

    // modelEmirler tablosundan ilgili sevk emrini çek
    $modelEmirler = $this->modelEmirler
        ->where('sevk_id', $invoice_id)
        ->first();

    if (!$modelEmirler) {
        return view('not-found');
    }

    $this->modelEmirler->set("print", 1)->where("sevk_id", $invoice_id)->update();

    $order_ids = explode(',', $modelEmirler['order_id']);

    $orders = $this->modelOrder
        ->whereIn('order_id', $order_ids)
        ->orderBy("order_date", "ASC")
        ->findAll();

    $order_rows = [];

    foreach ($orders as $order) {
        $rows = $this->modelOrderRow
            ->where('order_id', $order['order_id'])
            ->findAll();

        $order_data = [
            'order_id' => $order['order_id'],
            'order_no' => $order['order_no'],
            'order_date' => $order['order_date'],
            'customer' => $order['cari_invoice_title'] ?? $order["invoice_title"],
            'shipping' => $order["kargo"] ?? "Kargo Yok!", 
            'status' => $order['order_status'],
            'items' => []
        ];

        foreach ($rows as $row) {
            $product_id = $row['stock_id'];
            $stockData = $this->modelStock->where("stock_id", $product_id)->first();
            $gallery = $this->modelStockGallery->where("stock_id", $product_id)->findAll();

            $product_data = [
                'toplandi' => $row['toplandi'],
                'order_satir_id' => $row['order_row_id'],
                'product_id' => $product_id,
                'order_no' => $order['order_no'],
                'order_date' => $order['order_date'],
                'kargo' => $order['kargo'],
                'stok_miktari' => $stockData["stock_total_quantity"] ?? 0,
                'status' => $order['order_status'],
                'title' => $row['stock_title'], 
                'code' => $stockData["stock_code"] ?? '', 
                'barcode' => $stockData["stock_barcode"] ?? '', 
                'quantity' => $row['stock_amount'],
                'price' => $row['total_price'],
                'default_image' => $stockData["default_image"] ?? '',
                'warehouse_location' => $stockData["warehouse_address"] ?? '',
                'gallery' => $gallery
            ];

            $order_data['items'][] = $product_data;
        }

        $order_rows[] = $order_data;
    }

    // Kargo ve tarihe göre sıralama yap
    usort($order_rows, function ($a, $b) {
        return strtotime($a['order_date']) - strtotime($b['order_date']);
    });

    $data = [
        'order_item' => $modelEmirler,
        'orders' => $order_rows
    ];

    return view('tportal/siparisler/sevkPrints_tarih', $data);
}


public function sevkListesi()
{
    $sevkler = $this->modelEmirler->find(732);
    $order_ids = explode(',', $sevkler['order_id']);
    $orders = $this->modelOrder->whereIn('order_id', $order_ids)->findAll();
    
    if($orders){
        foreach ($orders as $order) {
           if($order['order_status'] == "kargo_bekliyor"){
            $update = $this->modelOrder->set("order_status", "sevk_emri")->where("order_id", $order['order_id'])->update();
            $update_row = $this->modelOrderRow->set("order_row_status", "sevk_emri")->where("order_id", $order['order_id'])->update();
           }
        }
    }
   
}


public function toplandiGuncelle()
{
    if ($this->request->isAJAX()) {
        $order_row_id = $this->request->getPost('order_row_id');
        $toplandi = $this->request->getPost('toplandi');

        // Önce order_row verisini alalım
        $orderRow = $this->modelOrderRow->find($order_row_id);
        
        $result = $this->modelOrderRow->update($order_row_id, [
            'toplandi' => $toplandi,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($result) {
            // Log mesajını hazırla
            $logMessage = $toplandi == 1 
                ? "Ürün Toplama İşlemi: <span class='badge bg-success'>TOPLANDI</span>" 
                : "Ürün Toplama İşlemi: <span class='badge bg-warning'>TOPLAMA İPTAL</span>";

            // Log kaydı oluştur
            $this->modelIslem->LogOlustur(
                session()->get('client_id'),
                session()->get('user_id'),
                $orderRow['order_id'], // order_id
                'ok',
                'siparis',
                $logMessage,
                session()->get("user_item")["user_adsoyad"],
                json_encode($orderRow), // değişiklik yapılan satırın tüm bilgileri
                0,
                $orderRow['order_id'],
                0,
                0
            );
        }

        return $this->response->setJSON([
            'success' => $result ? true : false
        ]);
    }
}

public function sevkPrint($invoice_id)
    {
        // modelEmirler tablosundan ilgili sevk emrini çek
        $modelEmirler = $this->modelEmirler
            ->where('sevk_id', $invoice_id)
            ->first();
    
        // Eğer sevk emri bulunamazsa, 'not-found' görünümüne yönlendir
        if (!$modelEmirler) {
            return view('not-found');
        }
    
        $this->modelEmirler->set("print", 1)->where("sevk_id", $invoice_id)->update();
    
        // order_id'leri al
        $order_ids = explode(',', $modelEmirler['order_id']);
    
        // modelOrder tablosundan bu order_id'ler ile ilgili siparişleri çek
        $orders = $this->modelOrder
            ->whereIn('order_id', $order_ids)
            ->orderBy("order_date", "ASC")
            ->findAll();
        
        // Sipariş satırlarını al
        $order_rows = [];


        foreach ($orders as $order) {
            $rows = $this->modelOrderRow
                ->where('order_id', $order['order_id'])
                ->findAll();
            $yazdirildi = 0;
            foreach ($rows as $row) {
                $product_id = $row['stock_id'];
                $stockBarkod = $this->modelStock->where("stock_id", $product_id)->first();
                $stokGallery = $this->modelStockGallery->where("stock_id", $product_id)->findAll();
        
                if ($stockBarkod === null) {
                    log_message('error', 'Ürün bulunamadı: ' . $product_id);
                    continue; // Bu ürünü atla
                }
                // Eğer paket değilse
                if ($stockBarkod["paket"] == 0) {
                    // Eğer ürün barkodu bulunamazsa, varsayılan bir değer ata
                    $stock_barcode = isset($stockBarkod["stock_barcode"]) ? $stockBarkod["stock_barcode"] : '';
                    $stock_code = isset($stockBarkod["stock_code"]) ? $stockBarkod["stock_code"] : '';
                    $default_image = isset($stockBarkod["default_image"]) ? $stockBarkod["default_image"] : ''; // Ürün resmi ekle
        
                    // Benzersiz bir anahtar oluşturun (sadece ürün kimliğine göre)
                    $unique_key = $product_id; // order_no'yu dahil etmiyoruz
        
                    // Eğer bu ürün daha önce eklenmediyse ilk değerleri ayarla
                    if (!isset($order_rows[$unique_key])) {
                        $order_rows[$unique_key] = [
                            'product_id' => $product_id,
                            'gallery' => $stokGallery,
                            'stok_miktari' => $stockBarkod["stock_total_quantity"] ?? 0,
                            'default_image' => $default_image,
                            'stock_quenty' => $stockBarkod["stock_total_quantity"] ?? 0,
                            'stock_title' => $row['stock_title'], // Ürün adını ekle
                            'stock_code' => $stock_code, // Ürün kodunu ekle
                            'stock_amount' => 0, // Başlangıçta sıfır, sonra eklenecek
                            'raf' => $stockBarkod["warehouse_address"],
                            'total_price' => 0, // Başlangıçta sıfır, sonra eklenecek
                            'stock_barcode' => $stock_barcode, // Ürün barkodunu ekle
                            'order_info' => [] // Sipariş numarası ve tarih bilgilerini tutan dizi
                        ];
                    }
        
                    // Eğer ürün daha önce eklendiyse mevcut değerleri güncelle
                    $order_rows[$unique_key]['stock_amount'] += $row['stock_amount']; // Ürün miktarını ekle
                    $order_rows[$unique_key]['total_price'] += $row['total_price']; // Toplam fiyatı ekle
        
                    // Sipariş numarasını ve sipariş tarihini aynı dizide birleştirerek ekleyelim

                    if($order['order_status'] == "sevk_edildi"){
                        $yazdirildi = 1;
                    }

                    $order_rows[$unique_key]['order_info'][] = [
                        'musteri' => $order['cari_invoice_title'] ?? $order["invoice_title"],
                        'order_no' => $order['order_no'],
                        'yazdir'   => $yazdirildi, 
                        'kargo'   => $order["kargo"] ?? "Kargo Yok!", 
                        'order_date' => $order['order_date']
                    ];


                }
            }
        }

       
/*
    usort($order_rows, function ($a, $b) {
        return strcmp($a['raf'], $b['raf']);
    }); */

    usort($order_rows, function ($a, $b) {
        // Öncelikle kargo bilgisine göre sıralama yap
        $result = strcmp($a['order_info'][0]['kargo'], $b['order_info'][0]['kargo']);
        
        // Eğer kargo bilgileri aynıysa, sipariş numarasına göre sıralama yap
        if ($result == 0) {
            return strcmp($a['order_info'][0]['order_no'], $b['order_info'][0]['order_no']);
        }
        return $result;
    });


        
        // Verileri görünüm için hazırlayın
        $data = [
            'order_item' => $modelEmirler,
            'orders' => $orders,
            'order_rows' => $order_rows
        ];
    
        return view('tportal/siparisler/sevkPrint', $data);
    }
    

    public function siparisYazdir($order_id)
    {
        

        $order = $this->modelOrder->where("order_id", $order_id)->first();

        if (!$order) {
            return view('not-found');
        }


        $order_rows = $this->modelOrderRow->where("order_id", $order_id)->findAll();

        foreach ($order_rows as &$order_row) {
            $stokBarkod = $this->modelStock->where("stock_id", $order_row["stock_id"])->first();
            $order_row["barkod"] = $stokBarkod["stock_barcode"];
        }

    

   

        // Verileri görünüm için hazırlayın
        $data = [
            'order' => $order,
            'order_rows' => $order_rows,
        ];

    

        return view('tportal/siparisler/siparisYazdir', $data);
    }


    public function sevkSiparisYazdir($order_id)
    {
        
        

        $order = $this->modelOrder->where("order_id", $order_id)->first();

        if (!$order) {
            return view('not-found');
        }

    


        $order_rows = $this->modelOrderRow->where("order_id", $order_id)->findAll();
      
        $kutu_id = 0;
        foreach ($order_rows as &$order_row) {

            
            
            $stokBarkod = $this->modelStock->where("stock_id", $order_row["stock_id"])->first();
            $order_row["barkod"] = $stokBarkod["stock_barcode"];
            if($order_row["dopigo_sku"] == ''){
                $order_row["dopigo_sku"] = $stokBarkod["stock_code"];
            }
            $kutu_id = $order_row["kutu_id"];
        }




        // kutuyu boşalt
        $guncelle = $this->modelBox->set("is_empty", 1)->where("id", $kutu_id)->update();
        $this->modelBoxRow->where("kutu_id", $kutu_id)->delete();
        $this->modelOrderRow->set("kutu_id", NULL)->where("order_id", $order_id)->update();

        $this->modelOrder->set("order_status", "sevk_edildi")->where("order_id", $order_id)->update();
        
        $this->modelOrderRow->set("order_row_status", "sevk_edildi")->where("order_id", $order_id)->update();

        $kutu = $this->modelBox->where("order_id", $order_id)->first();

       
        $this->modelIslem->LogOlustur(
            session()->get('client_id'), 
            session()->get('user_id'), 
            $order_id, 
            'ok',  
            'siparis',
            "Sipariş Durumu Barkod Okutma Sonrasında : <span class='badge bg-success'>SEVK EDİLDİ</span> Olarak Değiştirildi.", 
            session()->get("user_item")["user_adsoyad"],
            json_encode($kutu),
            0,
            $order_id,
            0,
            0
        );

        if($kutu){
            $data_up = [
                'order_id' => 0,
                'platform' => '',
                'order_no' => '',
                'is_empty' => 1
            ];
            $this->modelBox->set($data_up)->where("order_id", $order_id)->update();
            $this->modelBoxRow->where("kutu_id", $kutu["id"])->delete();
    
        }
       
            

      


       $sevkler = $this->modelEmirler->orderExists($order_id);


     
 
        if($sevkler != "YOK"){
            // Sevkler order_id'sini virgül ile bölerek diziye çevir
            $orderIds = explode(',', $sevkler['order_id']);

            // Toplam sipariş sayısı
            $toplamSiparisler = count($orderIds);

            // Biten siparişleri saymak için değişken
            $bitenSiparisler = 0;

            // Her bir order_id için döngü başlat
            foreach ($orderIds as $orderId) {
                // OrderModel üzerinden order_status kontrolü
                $orders = $this->modelOrder->find($orderId);

                if ($orders && $orders['order_status'] == 'sevk_edildi') {
                    // Eğer sipariş sevk edilmişse bitenSiparisler'i arttır
                    $bitenSiparisler++;
                }
               
            }

            // Eğer biten sipariş sayısı toplam sipariş sayısına eşitse sevkiyat emrini güncelle
            if ($bitenSiparisler === $toplamSiparisler) {
                $this->modelEmirler->set("bitti", 1)->where("sevk_id", $sevkler['sevk_id'])->update();
            
            } 
           
        }
 


 

        
   

        // Verileri görünüm için hazırlayın
        $data = [
            'order' => $order,
            'order_rows' => $order_rows,
        ];

    

        return view('tportal/siparisler/siparisYazdir', $data);
    }
    
        

    public function setOrderStatus() {
        $orderId = $this->request->getPost('orderId');
        $orderStatus = $this->request->getPost('orderStatus');

        $modelOrder = $this->modelOrder->where("order_id", $orderId)->first();

        $eskiDurum = $modelOrder["order_status"];

        $order_update_data = [
            'order_status' => $orderStatus,
        ];
        $order_row_status = [
            'order_row_status' => $orderStatus,
        ];


        // print_r($orderId);
        // print_r($orderStatus);
        // return;
        
        try {

            if(session()->get('user_item')['user_id'] == 5){
                if($order_status = "failed"){
                    $msh_db = $this->b2bConnect();
                    $siparis_no = $modelOrder["order_no"];
                    $siparisbul = $msh_db->table("siparisler")->where("siparis_no", $siparis_no)->get()->getRowArray();
                    if($siparisbul){
                        $msh_db->table("siparisler")->where("siparis_no", $siparis_no)->update(["durum_id" => "5"]);
                        $msh_db->table("siparisler_detay")->where("siparis_id", $siparisbul["id"])->update(["durum_id" => "5"]);
                    }
                }
            }



            $this->modelOrder->update($orderId, $order_update_data);
            $this->modelOrderRow->set($order_row_status)->where("order_id", $orderId)->update();

            echo json_encode(['icon' => 'success', 'message' => 'Sipariş durumu başarıyla güncellendi.', 'orderId' => $orderId]);


            $this->logClass->save_log(
                'success',
                'order',
                $orderId,
                null,
                'edit',
                "Sipariş Eski Durumu: <b>" .$eskiDurum. "</b> Yeni Durum: <b>" .$orderStatus . "</b>",
                json_encode($_POST)
            );


            switch ($eskiDurum) {
                case 'new':
                    $statusText = 'Yeni Sipariş';
                    $statusTextColor = 'text-primary';
                    $statusBgColor = 'bg-primary';
                    break;
                case 'sevk_emri':
                    $statusText = 'Sevk Emri Verildi';
                    $statusTextColor = 'text-primary';
                    $statusBgColor = 'bg-primary';
                    break;
                case 'pending':
                    $statusText = 'Hazırlanıyor';
                    $statusTextColor = 'text-warning';
                    $statusBgColor = 'bg-warning';
                    break;
                case 'success':
                    $statusText = 'Teslim Edildi';
                    $statusTextColor = 'text-success';
                    $statusBgColor = 'bg-success';
                    break;
                case 'sevk_edildi':
                    $statusText = 'Sevk Edildi';
                    $statusTextColor = 'text-success';
                    $statusBgColor = 'bg-success';
                    break;
                case 'failed':
                    $statusText = 'İptal';
                    $statusTextColor = 'text-danger';
                    $statusBgColor = 'bg-danger';
                    break;
                case 'teknik_hata':
                    $statusText = 'Teknik Hata';
                    $statusTextColor = 'text-danger';
                    $statusBgColor = 'bg-danger';
                    break;
                case 'stokta_yok':
                    $statusText = 'Stokta Yok';
                    $statusTextColor = 'text-danger';
                    $statusBgColor = 'bg-danger';
                    break;
                default:
                    $statusText = 'Bilinmeyen';
                    $statusTextColor = 'text-secondary';
                    $statusBgColor = 'bg-secondary';
                    break;
            }

            switch ($orderStatus) {
                case 'new':
                    $statusTexts = 'Yeni Sipariş';
                    $statusTextColors = 'text-primary';
                    $statusBgColors = 'bg-primary';
                    break;
                case 'sevk_emri':
                    $statusTexts = 'Sevk Emri Verildi';
                    $statusTextColors = 'text-primary';
                    $statusBgColors = 'bg-primary';
                    break;
                case 'pending':
                    $statusTexts = 'Hazırlanıyor';
                    $statusTextColors = 'text-warning';
                    $statusBgColors = 'bg-warning';
                    break;
                case 'success':
                    $statusTexts = 'Teslim Edildi';
                    $statusTextColors = 'text-success';
                    $statusBgColors = 'bg-success';
                    break;
                case 'sevk_edildi':
                    $statusTexts = 'Sevk Edildi';
                    $statusTextColors = 'text-success';
                    $statusBgColors = 'bg-success';
                    break;
                case 'failed':
                    $statusTexts = 'İptal';
                    $statusTextColors = 'text-danger';
                    $statusBgColors = 'bg-danger';
                    break;
                case 'teknik_hata':
                    $statusTexts = 'Teknik Hata';
                    $statusTextColors = 'text-danger';
                    $statusBgColors = 'bg-danger';
                    break;
                case 'stokta_yok':
                    $statusTexts = 'Stokta Yok';
                    $statusTextColors = 'text-danger';
                    $statusBgColors = 'bg-danger';
                    break;
                default:
                    $statusTexts = 'Bilinmeyen';
                    $statusTextColors = 'text-secondary';
                    $statusBgColors = 'bg-secondary';
                    break;
            }
            
            $this->modelIslem->LogOlustur(
                session()->get('client_id'), 
                session()->get('user_id'), 
                $orderId, 
                'ok',  
                'siparis',
                "Sipariş Eski Durumu: <b>" .$statusText. "</b> Yeni Durum: <b> " .$statusTexts . "</b>", 
                session()->get("user_item")["user_adsoyad"],
                json_encode($order_update_data),
                0,
                $orderId,
                0,
                0
            );


           



            return;
        } catch (\Exception $e) {
            $this->logClass->save_log(
                'error',
                'order',
                $orderId,
                null,
                'edit',
                $e->getMessage(),
                json_encode($_POST)
            );
            echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
            return;
        }
    }

    public function detail($order_id)
    {
        $order_item = $this->modelOrder->join('money_unit', 'money_unit.money_unit_id = order.money_unit_id')
            ->where('order.user_id', session()->get('user_id'))
            ->where('order.order_id', $order_id)
            ->orderBy('order.order_date')
            ->first();

        if (!$order_item) {
            return view('not-found');
        }

        $faturaVarmi = $this->modelInvoice->where("invoice_id", $order_item['fatura'])->first();

        $order_rows = $this->modelOrderRow
                            ->select('order_row.*, unit.*, order.*, stock.*')
                            ->join('unit', 'unit.unit_id = order_row.unit_id')
                            ->join('order', 'order.order_id = order_row.order_id')
                            ->join('stock', 'stock.stock_id = order_row.stock_id', 'left')
                            ->where('order.order_id', $order_id)
                            ->findAll();

        $data = [
            'faturaVarmi' => $faturaVarmi,
            'order_item' => $order_item,
            'order_rows' => $order_rows
        ];


        // print_r($order_item);
        // return;

        return view('tportal/siparisler/detay/detay', $data);
    }

    public function orderMovements($order_id = null)
    {

        $order_item = $this->modelOrder->join('money_unit', 'money_unit.money_unit_id = order.money_unit_id')
            ->where('order.user_id', session()->get('user_id'))
            ->where('order.order_id', $order_id)
            ->orderBy('order.order_date')
            ->first();

        if (!$order_item) {
            return view('not-found');
        }

        $data = [
            'order_item' => $order_item,
        ];

        return view('tportal/siparisler/detay/hareketler',$data);
    }


    public function loglar($order_id = null)
    {

        $order_item = $this->modelOrder->select('order.*, order.created_at as order_created_at, money_unit.* ')->join('money_unit', 'money_unit.money_unit_id = order.money_unit_id')
        ->where('order.user_id', session()->get('user_id'))
        ->where('order.order_id', $order_id)
        ->orderBy('order.order_date')
        ->first();

         

        if (!$order_item) {
            return view('not-found');
        }

        $LogBul = $this->modelIslem->where("siparis_id", $order_id)->orWhere("log_islem_id", $order_id)->orderBy("islem_log_id", "DESC")->findAll();
       

        $data = [
            'order_item' => $order_item,
            'loglar'     => $LogBul,
        ];

        return view('tportal/siparisler/detay/loglar',$data);
    }


    public function create()
    {   


    
        $Kurlar = $this->modelMoneyUnit->findAll();

        
        $transaction_prefix = "SPRS";
        $errRows = [];
        if ($this->request->getMethod('true') == 'POST') {


    
    
            try {
                $data_form = $this->request->getPost('data_form');
                $data_order_rows = $this->request->getPost('data_order_rows');
                $data_order_amounts = $this->request->getPost('data_order_amounts');

                foreach ($data_form as $data) {
                    $key = $data['name'];
                    $value = $data['value'];
                    $new_data_form[$key] = $value;
                }

                // print_r($new_data_form);
                // print_r($data_order_rows);
                // print_r($data_order_amounts);
                // return;

                $phone = isset($new_data_form['cari_phone']) ? str_replace(array('(', ')', ' '), '', $new_data_form['cari_phone']) : null;
                $phoneNumber = $new_data_form['cari_phone'] ? $new_data_form['area_code'] . " " . $phone : null;

                $order_date = $new_data_form['order_date'];
                $order_time = $new_data_form['order_time'];

                $order_datetime = convert_datetime_for_sql_time($order_date, $order_time);

                $transaction_amount = isset($data_order_amounts['amount_to_be_paid']) ? convert_number_for_sql($data_order_amounts['amount_to_be_paid']) : convert_number_for_sql($data_order_amounts['amount_to_be_paid_try']);

                // $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.identification_number', $new_data_form['identification_number'])->first();

                if (isset($new_data_form['cari_id']) && $new_data_form['cari_id'] != 0) {
                    $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id', $new_data_form['cari_id'])->first();
                }
                if (isset($new_data_form['identification_number']) && $new_data_form['identification_number'] != 0 && $new_data_form['identification_number'] != null) {
                    $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.identification_number', $new_data_form['identification_number'])->first();
                }

                // print_r($cari_item);
                // return;


                if ((isset($new_data_form['is_customer_save']) && $new_data_form['is_customer_save'] == 'on') || $cari_item) {
                    if (isset($new_data_form['is_export_customer']) && $new_data_form['is_export_customer'] == 'on') {
                        $is_export_customer = 1;
                    } else {
                        $is_export_customer = 0;
                    }
                    $cari_data = [
                        'user_id' => session()->get('user_id'),
                        'money_unit_id' => $data_order_amounts['money_unit_id'],
                        'identification_number' => $new_data_form['identification_number'],
                        'tax_administration' => $new_data_form['tax_administration'] != '' ? $new_data_form['tax_administration'] : null,
                        'invoice_title' => $new_data_form['invoice_title'] == '' ? $new_data_form['name'].' '.$new_data_form['surname'] : $new_data_form['invoice_title'],
                        'name' => $new_data_form['name'],
                        'surname' => $new_data_form['surname'],
                        'obligation' => $new_data_form['obligation'] != '' ? $new_data_form['obligation'] : null,
                        'company_type' => $new_data_form['company_type'] != '' ? $new_data_form['company_type'] : null ,
                        'cari_phone' => $phoneNumber,
                        'cari_email' => $new_data_form['cari_email'] != '' ? $new_data_form['cari_email'] : null,
                        'is_customer' => 1,
                        'is_supplier' => 0,
                        'is_export_customer' => $is_export_customer,
                    ];

                    $address_data = [
                        'user_id' => session()->get('user_id'),
                        'address_title' => 'Fatura Adresi',
                        'address_country' => $new_data_form['address_country'],
                        'address_city' => $new_data_form['address_city_name'] != '' ? $new_data_form['address_city_name'] : null,
                        'address_city_plate' => isset($new_data_form['address_city']) ? $new_data_form['address_city'] : null,
                        'address_district' => isset($new_data_form['address_district']) ? $new_data_form['address_district'] : null,
                        'zip_code' => $new_data_form['zip_code'] != '' ? $new_data_form['zip_code'] : null,
                        'address' => $new_data_form['address'],
                        'address_phone' => $phoneNumber,
                        'address_email' => $new_data_form['cari_email'] != '' ? $new_data_form['cari_email'] : null,
                    ];

                    if (!$cari_item) {
                        $cari_data['cari_balance'] =  $transaction_amount;
                        $cari_balance = $transaction_amount;
                        $this->modelCari->insert($cari_data);
                        $cari_id = $this->modelCari->getInsertID();
                        $address_data['cari_id'] = $cari_id;
                        $address_data['status'] = 'active';
                        $address_data['default'] = 'true';
                        $this->modelAddress->insert($address_data);
                    } else {
                        $cari_id = $cari_item['cari_id'];
                        $cari_address_id = $cari_item['address_id'];
                        
                        $cari_balance = $cari_item['cari_balance'] + $transaction_amount;
                        // $cari_data['cari_balance'] = $cari_balance;
                        // $this->modelCari->update($cari_id, $cari_data);

                        $address_data['cari_id'] = $cari_id;
                        $this->modelAddress->update($cari_address_id, $address_data);
                    }
                } else {
                    $cari_id = $cari_item['cari_id'];
                }

                if (isset($new_data_form['chk_musteri_bakiye_ekle']) && $new_data_form['chk_musteri_bakiye_ekle'] == 'on') {
                    $order_note_id = $new_data_form['invoiceNotesId'];
                    $order_note = $new_data_form['txt_fatura_not'] . " - " . $cari_balance;
                } else {
                    $order_note_id = $new_data_form['invoiceNotesId'];
                    $order_note = $new_data_form['txt_fatura_not'];
                }

                if (isset($new_data_form['chk_not_kaydet']) && $new_data_form['chk_not_kaydet'] == 'on') {
                    $note_item = $this->modelNote->where('note_id', $new_data_form['invoiceNotesId'])->where('user_id', session()->get('user_id'))->first();

                    if (!$note_item) {
                        $insert_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_type' => 'order',
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $this->modelNote->insert($insert_invoice_note_data);
                        $order_note_id = $this->modelNote->getInsertID();
                    } else {
                        $update_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_id' => $new_data_form['invoiceNotesId'],
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $order_note_id = $new_data_form['invoiceNotesId'];
                        $this->modelNote->update($new_data_form['invoiceNotesId'], $update_invoice_note_data);
                    }
                }

                ## SİPARİŞLER İÇİN FİNANSAL HAREKET VEYA STOK HAREKET İŞLENMEYECEK. SİPARİŞ FATURALAŞTIĞI ZAMAN İŞLENECEK.
                // $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                // if ($last_transaction) {
                //     $transaction_counter = $last_transaction['transaction_counter'] + 1;
                // } else {
                //     $transaction_counter = 1;
                // }
                // $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                // $insert_financial_movement_data = [
                //     'user_id' => session()->get('user_id'),
                //     'financial_account_id' => null,
                //     'cari_id' => $cari_id,
                //     'money_unit_id' => $data_order_amounts['money_unit_id'],
                //     'transaction_number' => $transaction_number,
                //     'transaction_direction' => 'entry',
                //     'transaction_type' => "order",
                //     'transaction_tool' => 'not_payroll',
                //     'transaction_title' => 'sipariş oluşturdan oluşan otomatik hareket',
                //     'transaction_description' => $order_note,
                //     'transaction_amount' => convert_number_for_sql($data_order_amounts['amount_to_be_paid']),
                //     'transaction_real_amount' => convert_number_for_sql($data_order_amounts['amount_to_be_paid']),
                //     'transaction_date' => $order_datetime,
                //     'transaction_prefix' => $transaction_prefix,
                //     'transaction_counter' => $transaction_counter
                // ];
                // $this->modelFinancialMovement->insert($insert_financial_movement_data);

                //8 rakamlı sipariş kodu
                $create_order_code = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
              
                $d_date = $new_data_form['deadline_date'];
                $insert_order_data = [
                    'user_id' => session()->get('user_id'),
                    'money_unit_id' => $data_order_amounts['money_unit_id'],
                    'order_direction' => $new_data_form['order_direction'],
                    'order_no' => $transaction_prefix . $create_order_code,
                    'order_date' => $order_datetime,

                    'order_note_id' => $new_data_form['invoiceNotesId'] == '' ? $order_note_id : $new_data_form['invoiceNotesId'],
                    'order_note' => $order_note,

                    'is_deadline' => $new_data_form['is_deadline'] == 'on' ? 1 : 0,
                    'deadline_date' => convert_datetime_for_sql_time($d_date, $order_time),

                    'currency_amount' => $data_order_amounts['currency_amount'],

                    'stock_total' => convert_number_for_sql($data_order_amounts['stock_total']),
                    'stock_total_try' => convert_number_for_sql($data_order_amounts['stock_total_try']),

                    'discount_total' => convert_number_for_sql($data_order_amounts['discount_total']),
                    'discount_total_try' => convert_number_for_sql($data_order_amounts['discount_total_try']),

                    'tax_rate_1_amount' => convert_number_for_sql($data_order_amounts['tax_rate_1_amount']),
                    'tax_rate_1_amount_try' => convert_number_for_sql($data_order_amounts['tax_rate_1_amount_try']),
                    'tax_rate_10_amount' => convert_number_for_sql($data_order_amounts['tax_rate_10_amount']),
                    'tax_rate_10_amount_try' => convert_number_for_sql($data_order_amounts['tax_rate_10_amount_try']),
                    'tax_rate_20_amount' => convert_number_for_sql($data_order_amounts['tax_rate_20_amount']),
                    'tax_rate_20_amount_try' => convert_number_for_sql($data_order_amounts['tax_rate_20_amount_try']),

                    'sub_total' => convert_number_for_sql($data_order_amounts['sub_total']),
                    'sub_total_try' => convert_number_for_sql($data_order_amounts['sub_total_try']),
                    'sub_total_0' => convert_number_for_sql($data_order_amounts['sub_total_all_tax0']),
                    'sub_total_0_try' => convert_number_for_sql($data_order_amounts['sub_total_all_tax0_try']),
                    'sub_total_1' => convert_number_for_sql($data_order_amounts['sub_total_all_tax1']),
                    'sub_total_1_try' => convert_number_for_sql($data_order_amounts['sub_total_all_tax1_try']),
                    'sub_total_10' => convert_number_for_sql($data_order_amounts['sub_total_all_tax10']),
                    'sub_total_10_try' => convert_number_for_sql($data_order_amounts['sub_total_all_tax10_try']),
                    'sub_total_20' => convert_number_for_sql($data_order_amounts['sub_total_all_tax20']),
                    'sub_total_20_try' => convert_number_for_sql($data_order_amounts['sub_total_all_tax20_try']),

                    'grand_total' => convert_number_for_sql($data_order_amounts['grand_total']),
                    'grand_total_try' => convert_number_for_sql($data_order_amounts['grand_total_try']),

                    'amount_to_be_paid' => convert_number_for_sql($data_order_amounts['amount_to_be_paid']),
                    'amount_to_be_paid_try' => convert_number_for_sql($data_order_amounts['amount_to_be_paid_try']),

                    'amount_to_be_paid_text' => $data_order_amounts['amount_to_be_paid_text'],

                    'cari_id' => $cari_id,
                    'cari_identification_number' => $new_data_form['identification_number'],
                    'cari_tax_administration' => $new_data_form['tax_administration'],

                    'cari_invoice_title' => $new_data_form['invoice_title'] == '' ? $new_data_form['name'] . " " . $new_data_form['surname'] : $new_data_form['invoice_title'],
                    'cari_name' => $new_data_form['name'],
                    'cari_surname' => $new_data_form['surname'],
                    'cari_obligation' => $new_data_form['obligation'],
                    'cari_company_type' => $new_data_form['company_type'],
                    'cari_phone' => $phoneNumber,
                    'cari_email' => $new_data_form['cari_email'],

                    'address_country' => $new_data_form['address_country'],

                    'address_city' => $new_data_form['address_city_name'],
                    'address_city_plate' => isset($new_data_form['address_city']) ? $new_data_form['address_city'] : "",
                    'address_district' => isset($new_data_form['address_district']) ? $new_data_form['address_district'] : "",
                    'address_zip_code' => $new_data_form['zip_code'],
                    'address' => $new_data_form['address'],

                    'order_status' => "new",
                    'failed_reason' => ""
                ];
         
                $this->modelOrder->insert($insert_order_data);
                $order_id = $this->modelOrder->getInsertID();

                foreach ($data_order_rows as $data_order_row) {
                    if (isset($data_order_row['isDeleted'])) {
                        continue;
                    } else {

                        $stokBilgileri = $this->modelStock->where('stock_id', $data_order_row['stock_id'])->first();

                        $insert_order_row_data = [
                            'user_id' => session()->get('user_id'),
                            'order_id' => $order_id,
                            'stock_id' => $data_order_row['stock_id'],
                            'stock_title' => $data_order_row['stock_title'],
                            'stock_amount' => $data_order_row['stock_amount'],
                            'stock_total_quantity' => $stokBilgileri['stock_total_quantity'],

                            'unit_id' => $data_order_row['unit_id'],
                            'unit_price' => $data_order_row['unit_price'],

                            'discount_rate' => $data_order_row['discount_rate'],
                            'discount_price' => $data_order_row['discount_price'],

                            'subtotal_price' => $data_order_row['subtotal_price'],

                            'tax_id' => $data_order_row['tax_id'],
                            'tax_price' => $data_order_row['tax_price'],

                            'total_price' => $data_order_row['total_price'],
                        ];
                        $this->modelOrderRow->insert($insert_order_row_data);
                    }
                }

                echo json_encode(['icon' => 'success', 'message' => 'Sipariş başarıyla sisteme kaydedildi.', 'errRows' => $errRows, 'newOrderId' => $order_id]);
                return;
            } catch (\Exception $e) {
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
        } else {
            $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
            $cari_items = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')->where('cari.user_id', session()->get('user_id'))->findAll();
            $invoice_note_items = $this->modelNote->where('user_id', session()->get('user_id'))->findAll();
            $stock_items = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock.stock_id <=', 0)->join('category', 'category.category_id = stock.category_id')->join('type', 'type.type_id = stock.type_id')->join('money_unit', 'money_unit.money_unit_id = stock.sale_money_unit_id')->findAll();

            $data = [
                'Kurlar' => $Kurlar,
                'money_unit_items' => $money_unit_items,
                'cari_items' => $cari_items,
                'invoice_note_items' => $invoice_note_items,
                'stock_items' => $stock_items
            ];

            return view('tportal/siparisler/yeni', $data);
        }
    }

    public function json()
    {

        $jsonData = '';

        // JSON'u bir PHP dizisine dönüştürelim
        $stockData = json_decode($jsonData, true);

        // Verinin başarılı şekilde decode edilip edilmediğini kontrol edelim
        if (json_last_error() === JSON_ERROR_NONE) {
            // Verinin bir dizi olup olmadığını kontrol edelim
            if (is_array($stockData)) {
                // Eğer dizi ise, veriyi işlemeye devam edelim
                foreach ($stockData as $stockItem) {
                   echo '<pre>';
                   print_r($stockItem);
                   echo '</pre>';
                }
            } else {
                echo "Beklenilen veri bir dizi değil!";
            }
        } else {
            // JSON'un geçerli olmaması durumunda hata mesajı
            echo "JSON verisi çözümlenemedi. Hata: " . json_last_error_msg();
        }
    }

    public function edit($order_id = null)
    {   

        $Kurlar = $this->modelMoneyUnit->findAll();

        $transaction_prefix = "PRF";
        $errRows = [];
        $order_item = $this->modelOrder->join('money_unit', 'money_unit.money_unit_id = order.money_unit_id')
            ->where('order.user_id', session()->get('user_id'))
            ->where('order.order_id', $order_id)
            ->first();
        if ($this->request->getMethod('true') == 'POST') {
            if (!$order_item) {
                echo json_encode(['icon' => 'error', 'message' => 'Sipariş bulunamadı.']);
                return;
            }

            try {
               // Post ile gelen verileri alıyoruz
                $data_form = $this->request->getPost('data_form');
                $data_order_rows = $this->request->getPost('data_order_rows');
                $data_order_amounts = $this->request->getPost('data_order_amounts');

                // JSON formatında gelen verileri tekrar orijinal yapısına döndürüyoruz
                $data_form = json_decode($data_form, true);  // true ile dizi olarak döner
                $data_order_rows = json_decode($data_order_rows, true);
                $data_order_amounts = json_decode($data_order_amounts, true);



               

           
                foreach ($data_form as $data) {
                    $key = $data['name'];
                    $value = $data['value'];
                    $new_data_form[$key] = $value;
                }
            
                // print_r($new_data_form);
                // print_r($data_order_rows);
                // print_r($data_order_amounts);
                // return;

                $phone = isset($new_data_form['cari_phone']) ? str_replace(array('(', ')', ' '), '', $new_data_form['cari_phone']) : null;
                $phoneNumber = $new_data_form['cari_phone'] ? $new_data_form['area_code'] . " " . $phone : null;

                $order_date = $new_data_form['order_date'];
                $order_time = $new_data_form['order_time'];

                $order_datetime = convert_datetime_for_sql_time($order_date, $order_time);

                $transaction_amount = isset($data_order_amounts['amount_to_be_paid']) ? convert_number_for_sql($data_order_amounts['amount_to_be_paid']) : convert_number_for_sql($data_order_amounts['amount_to_be_paid_try']);

                $cari_balance = null;
                $cari_id = null;
                $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.identification_number', $new_data_form['identification_number'])->first();

                if ((isset($new_data_form['is_customer_save']) && $new_data_form['is_customer_save'] == 'on') || !$cari_item) {

                    if (isset($new_data_form['is_export_customer']) && $new_data_form['is_export_customer'] == 'on') {
                        $is_export_customer = 1;
                    } else {
                        $is_export_customer = 0;
                    }
                    $cari_data = [
                        'user_id' => session()->get('user_id'),
                        'money_unit_id' => $data_order_amounts['money_unit_id'],
                        'identification_number' => $new_data_form['identification_number'],
                        'tax_administration' => $new_data_form['tax_administration'],
                        'invoice_title' => $new_data_form['invoice_title'],
                        'name' => $new_data_form['name'],
                        'surname' => $new_data_form['surname'],
                        'obligation' => $new_data_form['obligation'],
                        'company_type' => $new_data_form['company_type'],
                        'cari_phone' => $phoneNumber,
                        'cari_email' => $new_data_form['cari_email'],
                        'is_customer' => 1,
                        'is_supplier' => 0,
                        'is_export_customer' => $is_export_customer,
                    ];

                    $address_data = [
                        'user_id' => session()->get('user_id'),
                        'address_title' => 'Fatura Adresi',
                        'address_country' => $new_data_form['address_country'],
                        'address_city' => $new_data_form['address_city_name'],
                        'address_city_plate' => isset($new_data_form['address_city']) ? $new_data_form['address_city'] : "",
                        'address_district' => isset($new_data_form['address_district']) ? $new_data_form['address_district'] : "",
                        'zip_code' => $new_data_form['zip_code'],
                        'address' => $new_data_form['address'],
                        'address_phone' => $phoneNumber,
                        'address_email' => $new_data_form['cari_email'],
                    ];

                    if (!$cari_item) {
                        $cari_data['cari_balance'] = $transaction_amount;
                        $this->modelCari->insert($cari_data);
                        $cari_id = $this->modelCari->getInsertID();
                        $address_data['cari_id'] = $cari_id;
                        $address_data['status'] = 'active';
                        $address_data['default'] = 'true';
                        $this->modelAddress->insert($address_data);
                    } else {
                        $cari_id = $cari_item['cari_id'];
                        $cari_address_id = $cari_item['address_id'];
                        $cari_balance = $cari_item['cari_balance'] + $transaction_amount;
                        $cari_data['cari_balance'] = $cari_balance;
                        $this->modelCari->update($cari_id, $cari_data);

                        $address_data['cari_id'] = $cari_id;
                        $this->modelAddress->update($cari_address_id, $address_data);
                    }
                } else {
                    $cari_id = $cari_item['cari_id'];
                }

                if (isset($new_data_form['chk_musteri_bakiye_ekle']) && $new_data_form['chk_musteri_bakiye_ekle'] == 'on') {
                    $order_note_id = $new_data_form['invoiceNotesId'];
                    $order_note = $new_data_form['txt_fatura_not'] . " - " . $cari_balance;
                } else {
                    $order_note_id = $new_data_form['invoiceNotesId'];
                    $order_note = $new_data_form['txt_fatura_not'];
                }

                if (isset($new_data_form['chk_not_kaydet']) && $new_data_form['chk_not_kaydet'] == 'on') {
                    $note_item = $this->modelNote->where('note_id', $new_data_form['invoiceNotesId'])->where('user_id', session()->get('user_id'))->first();

                    if (!$note_item) {
                        $insert_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_type' => 'order',
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $this->modelNote->insert($insert_invoice_note_data);
                        $order_note_id = $this->modelNote->getInsertID();
                    } else {
                        $insert_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_id' => $new_data_form['invoiceNotesId'],
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $order_note_id = $new_data_form['invoiceNotesId'];
                        $this->modelNote->update($new_data_form['invoiceNotesId'], $insert_invoice_note_data);
                    }
                }



                // $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                // if ($last_transaction) {
                //     $transaction_counter = $last_transaction['transaction_counter'] + 1;
                // } else {
                //     $transaction_counter = 1;
                // }
                // #insert or update cari_balance and financial_movements
                // $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                // $insert_financial_movement_data = [
                //     'user_id' => session()->get('user_id'),
                //     'financial_account_id' => null,
                //     'cari_id' => $cari_id,
                //     'money_unit_id' => $data_order_amounts['money_unit_id'],
                //     'transaction_number' => $transaction_number,
                //     'transaction_direction' => 'entry',
                //     'transaction_type' => $new_data_form['ftr_turu'],
                //     'transaction_tool' => 'not_payroll',
                //     'transaction_title' => 'PRF00000000012',
                //     'transaction_description' => $order_note,
                //     'transaction_amount' => convert_number_for_sql($data_order_amounts['amount_to_be_paid_try']),
                //     'transaction_real_amount' => convert_number_for_sql($data_order_amounts['amount_to_be_paid_try']),
                //     'transaction_date' => $order_datetime,
                //     'transaction_prefix' => $transaction_prefix,
                //     'transaction_counter' => $transaction_counter
                // ];
                // $this->modelFinancialMovement->insert($insert_financial_movement_data);

                $d_date = $new_data_form['deadline_date'];
                $update_order_data = [
                    'user_id' => session()->get('user_id'),
                    'money_unit_id' => $data_order_amounts['money_unit_id'],
                    'order_date' => $order_datetime,

                    'order_note_id' => $order_note_id,
                    'order_note' => $order_note,

                    'is_deadline' => $new_data_form['is_deadline'] == 'on' ? 1 : 0,
                    'deadline_date' => convert_datetime_for_sql_time($d_date, $order_time),

                    'currency_amount' => $data_order_amounts['currency_amount'],

                    'stock_total' => convert_number_for_sql($data_order_amounts['stock_total']),
                    'stock_total_try' => convert_number_for_sql($data_order_amounts['stock_total_try']),

                    'discount_total' => convert_number_for_sql($data_order_amounts['discount_total']),
                    'discount_total_try' => convert_number_for_sql($data_order_amounts['discount_total_try']),

                    'tax_rate_1_amount' => convert_number_for_sql($data_order_amounts['tax_rate_1_amount']),
                    'tax_rate_1_amount_try' => convert_number_for_sql($data_order_amounts['tax_rate_1_amount_try']),
                    'tax_rate_10_amount' => convert_number_for_sql($data_order_amounts['tax_rate_10_amount']),
                    'tax_rate_10_amount_try' => convert_number_for_sql($data_order_amounts['tax_rate_10_amount_try']),
                    'tax_rate_20_amount' => convert_number_for_sql($data_order_amounts['tax_rate_20_amount']),
                    'tax_rate_20_amount_try' => convert_number_for_sql($data_order_amounts['tax_rate_20_amount_try']),

                    'sub_total' => convert_number_for_sql($data_order_amounts['sub_total']),
                    'sub_total_try' => convert_number_for_sql($data_order_amounts['sub_total_try']),
                    'sub_total_0' => convert_number_for_sql($data_order_amounts['sub_total_all_tax0']),
                    'sub_total_0_try' => convert_number_for_sql($data_order_amounts['sub_total_all_tax0_try']),
                    'sub_total_1' => convert_number_for_sql($data_order_amounts['sub_total_all_tax1']),
                    'sub_total_1_try' => convert_number_for_sql($data_order_amounts['sub_total_all_tax1_try']),
                    'sub_total_10' => convert_number_for_sql($data_order_amounts['sub_total_all_tax10']),
                    'sub_total_10_try' => convert_number_for_sql($data_order_amounts['sub_total_all_tax10_try']),
                    'sub_total_20' => convert_number_for_sql($data_order_amounts['sub_total_all_tax20']),
                    'sub_total_20_try' => convert_number_for_sql($data_order_amounts['sub_total_all_tax20_try']),

                    'grand_total' => convert_number_for_sql($data_order_amounts['grand_total']),
                    'grand_total_try' => convert_number_for_sql($data_order_amounts['grand_total_try']),

                    'amount_to_be_paid' => convert_number_for_sql($data_order_amounts['amount_to_be_paid']),
                    'amount_to_be_paid_try' => convert_number_for_sql($data_order_amounts['amount_to_be_paid_try']),

                    'cari_identification_number' => $new_data_form['identification_number'],
                    'cari_tax_administration' => $new_data_form['tax_administration'],

                    'cari_invoice_title' => $new_data_form['invoice_title'] == '' ? $new_data_form['name'] . " " . $new_data_form['surname'] : $new_data_form['invoice_title'],
                    'cari_name' => $new_data_form['name'],
                    'cari_surname' => $new_data_form['surname'],
                    'cari_obligation' => $new_data_form['obligation'],
                    'cari_company_type' => $new_data_form['company_type'],
                    'cari_phone' => $phoneNumber,
                    'cari_email' => $new_data_form['cari_email'],

                    'address_country' => $new_data_form['address_country'],

                    'address_city' => $new_data_form['address_city_name'],
                    'address_city_plate' => isset($new_data_form['address_city']) ? $new_data_form['address_city'] : "",
                    'address_district' => isset($new_data_form['address_district']) ? $new_data_form['address_district'] : "",
                    'address_zip_code' => $new_data_form['zip_code'],
                    'address' => $new_data_form['address'],

                    'order_status' => $new_data_form['order_status'],
                    'failed_reason' => ""
                ];


                $this->modelOrder->update($order_id, $update_order_data);

              
                foreach ($data_order_rows as $data_order_row) {

              
   
                    if (empty($data_order_row)) {
                        continue;
                    }

                    

               

                    $isDeleted = (isset($data_order_row["isDeletedOrder"])) ? $isDeleted = $data_order_row["isDeletedOrder"] : '' ;
                
                    $order_row_id = $data_order_row["order_row_id"] ?? 0;
                    
                    if (isset($data_order_row['order_row_id']) && isset($data_order_row['isDeletedOrder'])) {
                        $this->modelOrderRow->where('user_id', session()->get('user_id'))
                            ->where('order_row_id', $order_row_id)
                            ->delete();
                        continue;
                        
                    }

                    $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $data_order_row['stock_id'])->first();
                    if (!$stock_item) {
                        $errRows[] = [
                            'message' => "Verilen stok bulunamadı.",
                            'data' => [
                                'stock_id' => $data_order_row['stock_id'],
                                'stock_title' => $data_order_row['stock_title'],
                                'stock_amount' => $data_order_row['stock_amount'],
                            ]
                        ];
                        continue;
                    }

                    $order_row_data = [
                        'user_id' => session()->get('user_id'),
                        'order_id' => $order_id,
                        'stock_id' => $data_order_row['stock_id'],
                        'stock_title' => $data_order_row['stock_title'],
                        'stock_amount' => $data_order_row['stock_amount'], //convert_number_for_sql($data_order_row['stock_amount'])

                        'unit_id' => $data_order_row['unit_id'],
                        'unit_price' => $data_order_row['unit_price'],

                        'discount_rate' => $data_order_row['discount_rate'],
                        'discount_price' => $data_order_row['discount_price'],
                        'varyantlar' => $data_order_row['varyantlar'],
                        'subtotal_price' => $data_order_row['subtotal_price'],

                        'tax_id' => $data_order_row['tax_id'],
                        'tax_price' => $data_order_row['tax_price'],

                        'total_price' => $data_order_row['total_price'],
                    ];
                    if ($order_row_id == 0) {
                        $this->modelOrderRow->insert($order_row_data);
                    } else {
                        $this->modelOrderRow->update($order_row_id, $order_row_data);
                    }
                
                }
          

                echo json_encode(['icon' => 'success', 'message' => 'Sipariş başarıyla güncellendi.', 'errRows' => $errRows, 'orderId' => $order_id]);
                return;
            } catch (\Exception $e) {

                $backtrace = $e->getTrace();
                $errorDetails = [
                    'error_message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $backtrace
                ];

                $this->logClass->save_log(
                    'error',
                    'order',
                    $order_id,
                    null,
                    'edit',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon' => 'error', 'message' => $errorDetails]);
                return;
            }
        } else {
            if (!$order_item) {
                return view('not-found');
            }

            $order_rows = $this->modelOrderRow->where('user_id', session()->get('user_id'))->where('order_id', $order_id)->findAll();

            $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
            $cari_items = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')->where('cari.user_id', session()->get('user_id'))->findAll();
            $invoice_note_items = $this->modelNote->where('user_id', session()->get('user_id'))->findAll();
            $stock_items = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock.stock_id <=', 0)->join('category', 'category.category_id = stock.category_id')->join('type', 'type.type_id = stock.type_id')->join('money_unit', 'money_unit.money_unit_id = stock.sale_money_unit_id')->findAll();

            $data = [
                'Kurlar' => $Kurlar,
                'order_item' => $order_item,
                'order_rows' => $order_rows,
                'money_unit_items' => $money_unit_items,
                'cari_items' => $cari_items,
                'invoice_note_items' => $invoice_note_items,
                'stock_items' => $stock_items
            ];

            return view('tportal/siparisler/detay/duzenle', $data);
        }
    }

    public function delete($order_id = null)
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $order_item = $this->modelOrder->where('user_id', session()->get('user_id'))->where('order_id', $order_id)->first();

                if (!$order_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen fatura bulunamadı.']);
                    return;
                }

                $this->modelOrder->delete($order_item['order_id']);

                echo json_encode(['icon' => 'success', 'message' => 'Fatura başarıyla silindi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'order',
                    $order_id,
                    null,
                    'delete',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    public function stokKontrol()
    {
        $order_ids = $this->request->getPost('order_id');
        $eksikStok = false;
        $grupluStoklar = [];

        foreach ($order_ids as $order_id) {
            $modelrow = $this->modelOrderRow->where("order_id", $order_id)->where("stock_id !=", 0)->findAll();
            
            foreach ($modelrow as $row) {
                $stokBul = $this->modelStock->where("stock_id", $row["stock_id"])->first();
                
                // Stok ID'ye göre gruplama
                $stok_id = $stokBul["stock_id"];
                if (!isset($grupluStoklar[$stok_id])) {
                    $grupluStoklar[$stok_id] = [
                        "stock_code" => $stokBul["stock_code"],
                        "stock_title" => $stokBul["stock_title"],
                        "mevcutStokta" => $stokBul["stock_total_quantity"],
                        "siparis_edilen" => 0
                    ];
                }
                
                $grupluStoklar[$stok_id]["siparis_edilen"] += $row["stock_amount"];
                
                if ($stokBul["stock_total_quantity"] < $grupluStoklar[$stok_id]["siparis_edilen"]) {
                    $eksikStok = true;
                }
            }
        }

        // Eksik stok olanları başa alma ve sıralama
        $sonuclar = [];
        foreach ($grupluStoklar as $stok) {
            $eksikMi = $stok["mevcutStokta"] < $stok["siparis_edilen"];
            $sonuclar[] = [
                "stock_code" => $stok["stock_code"],
                "stock_title" => $stok["stock_title"],
                "mevcutStokta" => $stok["mevcutStokta"],
                "siparis_edilen" => $stok["siparis_edilen"],
                "eksik_miktar" => $eksikMi ? ($stok["siparis_edilen"] - $stok["mevcutStokta"]) : 0,
                "durum" => $eksikMi ? "warning" : "success"
            ];
        }

        // Eksik stok olanları başa alma
        usort($sonuclar, function($a, $b) {
            if ($a["durum"] === "warning" && $b["durum"] !== "warning") return -1;
            if ($a["durum"] !== "warning" && $b["durum"] === "warning") return 1;
            return 0;
        });

        return $this->response->setJSON([
            'eksikStok' => $eksikStok,
            'stokDurum' => $sonuclar
        ]);
    }

    public function stokWhatsappMesaj()
    {
        try {
            $stokDurum = $this->request->getPost('stokDurum');
            
            // Log: Gelen stok durumu verisi
            log_message('info', 'Stok WhatsApp Mesaj - Gelen veri: ' . json_encode($stokDurum));
            
            $mesaj = "⚠️ *Eksik Stok Bildirimi*\n\n";
            
            foreach ($stokDurum as $stok) {
                if ($stok['durum'] === 'warning') {
                    $mesaj .= "📦 *" . $stok['stock_title'] . "*\n";
                    $mesaj .= "Stok Kodu: " . $stok['stock_code'] . "\n";
                    $mesaj .= "Mevcut Stok: " . number_format($stok['mevcutStokta'], 2) . "\n";
                    $mesaj .= "Sipariş Edilen: " . number_format($stok['siparis_edilen'], 2) . "\n";
                    $mesaj .= "Eksik Miktar: " . number_format($stok['eksik_miktar'], 2) . "\n\n";
                }
            }

            // Log: Oluşturulan mesaj
            log_message('info', 'Stok WhatsApp Mesaj - Oluşturulan mesaj: ' . $mesaj);

            // WhatsApp API'ye gönder
            $phone = "5324086232"; //"5324086232"; // Mesajın gönderileceği numara
            
            // Log: API çağrısı başlangıcı
            log_message('info', 'Stok WhatsApp Mesaj - API çağrısı başlatılıyor. Telefon: ' . $phone);
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://212.98.224.209:3000/helper/sendWhatsappSms',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
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
            
            // Log: API yanıtı
            log_message('info', 'Stok WhatsApp Mesaj - API yanıtı: HTTP Kodu: ' . $httpCode . ', Yanıt: ' . $response);
            
            if ($error) {
                log_message('error', 'Stok WhatsApp Mesaj - CURL Hatası: ' . $error);
            }
            
            curl_close($curl);

            // Hata varsa logla
            if ($httpCode != 200 || !empty($error)) {
                log_message('error', 'Stok WhatsApp Mesaj - API Hatası: HTTP Kodu: ' . $httpCode . ' Hata: ' . $error);
                
                $this->logClass->save_log(
                    'error',
                    'whatsapp',
                    null,
                    null,
                    'whatsapp_message',
                    'WhatsApp mesajı gönderilemedi. HTTP Kodu: ' . $httpCode . ' Hata: ' . $error,
                    json_encode([
                        'phone' => $phone,
                        'message' => $mesaj,
                        'response' => $response
                    ])
                );
            } else {
                // Başarılı gönderim logu
                log_message('info', 'Stok WhatsApp Mesaj - Mesaj başarıyla gönderildi');
            }

        } catch (\Exception $e) {
            // Hata oluşursa logla
            log_message('error', 'Stok WhatsApp Mesaj - İşlem Hatası: ' . $e->getMessage());
            
            $this->logClass->save_log(
                'error',
                'whatsapp',
                null,
                null,
                'whatsapp_message',
                $e->getMessage(),
                json_encode($stokDurum)
            );
        }

        // Log: İşlem sonucu
        log_message('info', 'Stok WhatsApp Mesaj - İşlem tamamlandı');

        // Her durumda başarılı dön
        return $this->response->setJSON([
            'success' => true,
            'message' => $mesaj
        ]);
    }

    public function raporlar()
    {
        $page_title = "Sipariş Raporları";
        $data = [
            'page_title' => $page_title,
        ];
    
       
        return view('tportal/siparisler/raporlar', $data);
    
    }

    public function getReportData()
{
    try {
        // POST verilerini al
        $startDate = $this->request->getPost('startDate');
        $endDate = $this->request->getPost('endDate');
        $platform = $this->request->getPost('platform');
        $status = $this->request->getPost('status');
        
        // Tarih kontrolü ve formatlaması
        if (empty($startDate)) {
            // Eğer başlangıç tarihi boşsa, dünün başlangıcını al
            $startDate = date('Y-m-d 00:00:00');
        } else {
            // Gelen tarihi doğru formata çevir
            $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
        }
        
        if (empty($endDate)) {
            // Eğer bitiş tarihi boşsa, bugünün sonunu al
            $endDate = date('Y-m-d 23:59:59');
        } else {
            // Gelen tarihi doğru formata çevir
            $endDate = date('Y-m-d 23:59:59', strtotime($endDate));
        }

        // Log ekleyelim
        log_message('debug', 'getReportData çağrıldı: ' . json_encode([
            'platform' => $platform,
            'status' => $status,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]));

        // Temel sorgu
        $query = $this->db->table('order')
            ->select('order.order_id, order.order_no, order.service_logo, order.order_id as order_id, order.kargo, order.service_name as platform, 
                     order.order_date, order.cari_name, order.cari_surname, 
                     order.grand_total_try as total, order.order_status as status')
            ->where('order.deleted_at IS NULL')
            ->where('order.order_date >=', $startDate)
            ->where('order.order_date <=', $endDate);

        // Platform filtresi
        if (!empty($platform)) {
            $query->where('order.service_name', $platform);
        }

        // Durum filtresi
        if (!empty($status)) {
            $query->where('order.order_status', $status);
        }

        // Siparişleri al
        $orders = $query->get()->getResultArray();

        // İstatistikleri hesapla
        $totalOrders = count($orders);
        $successOrders = 0;
        $failedOrders = 0;
        $totalRevenue = 0;
        $platformData = [];
        $trendData = [];

        foreach ($orders as $order) {
            // Başarılı/Başarısız sayısını hesapla
            if ($order['status'] === 'success') {
                $successOrders++;
            } else if ($order['status'] === 'failed') {
                $failedOrders++;
            }

            // Toplam ciroyu hesapla
            $totalRevenue += floatval($order['total']);

            // Platform dağılımını hesapla
            if (!isset($platformData[$order['platform']])) {
                $platformData[$order['platform']] = 0;
            }
            $platformData[$order['platform']]++;

            // Günlük trendi hesapla
            $date = date('Y-m-d', strtotime($order['order_date']));
            if (!isset($trendData[$date])) {
                $trendData[$date] = 0;
            }
            $trendData[$date]++;
        }

        // Siparişleri formatla
        $formattedOrders = array_map(function($order) {
            return [
                'order_no' => $order['order_no'],
                'platform' => $order['platform'],
                'order_id' => $order['order_id'],
                'service_logo' => $order['service_logo'],
                'date' => date('d.m.Y H:i', strtotime($order['order_date'])),
                'customer' => $order['cari_name'] . ' ' . $order['cari_surname'],
                'shipping' => $order['kargo'] ?? '',
                'total' => number_format($order['total'], 2, ',', '.'),
                'status' => $order['status'],
                'actions' => base_url('tportal/siparisler/detay/' . $order['order_id'])
            ];
        }, $orders);

        return $this->response->setJSON([
            'totalOrders' => $totalOrders,
            'successOrders' => $successOrders,
            'failedOrders' => $failedOrders,
            'totalRevenue' => $totalRevenue,
            'avgBasket' => $totalOrders > 0 ? $totalRevenue / $totalOrders : 0,
            'platformData' => [
                'labels' => array_keys($platformData),
                'values' => array_values($platformData)
            ],
            'trendData' => [
                'dates' => array_keys($trendData),
                'orders' => array_values($trendData)
            ],
            'orders' => $formattedOrders
        ]);

    } catch (\Exception $e) {
        log_message('error', 'getReportData hatası: ' . $e->getMessage());
        return $this->response->setJSON([
            'error' => true,
            'message' => $e->getMessage()
        ]);
    }
}
    
    private function getStatusBadge($status)
    {
        $badges = [
            'success' => '<span class="badge bg-success">Başarılı</span>',
            'failed' => '<span class="badge bg-danger">Başarısız</span>',
            'pending' => '<span class="badge bg-warning">Beklemede</span>',
            'new' => '<span class="badge bg-info">Yeni</span>',
            'sevk_emri' => '<span class="badge bg-primary">Sevk Emri</span>',
            'sevk_edildi' => '<span class="badge bg-success">Sevk Edildi</span>',
            'stokta_yok' => '<span class="badge bg-danger">Stokta Yok</span>',
            'teknik_hata' => '<span class="badge bg-danger">Teknik Hata</span>',
            'kargolandi' => '<span class="badge bg-success">Kargolandı</span>',
            'kargo_bekliyor' => '<span class="badge bg-warning">Kargo Bekliyor</span>',
            'yetistirilemedi' => '<span class="badge bg-danger">Yetiştirilemedi</span>'
        ];
    
        return $badges[$status] ?? '<span class="badge bg-secondary">Bilinmiyor</span>';
    }
    
    private function getActionButtons($orderId)
    {
        return '
            <div class="dropdown">
                <a class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                    <em class="icon ni ni-more-h"></em>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <ul class="link-list-opt no-bdr">
                        <li>
                            <a href="' . base_url('tportal/siparisler/detay/' . $orderId) . '">
                                <em class="icon ni ni-eye"></em><span>Detay</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="printOrder(' . $orderId . ')">
                                <em class="icon ni ni-printer"></em><span>Yazdır</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        ';
    }
    public function whatsappMessageTest()
    {
        $phone = "5324086232"; //"5324086232"; // Mesajın gönderileceği numara
        $message = "Test mesajı";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://212.98.224.209:3000/helper/sendWhatsappSms',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'gsm='.$phone.'&text='.urlencode($message),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }


    public function stokDusum($stock_id, $miktar = 1, $warehouse_id = null, $text = null)
    {
        $Kurlar = $this->modelMoneyUnit->findAll();

        $transaction_prefix = "PRF";
        $errRows = [];     
        $dusum_cari_id = 15199;
            try {
                $stokBaglan = $this->modelStock->where("stock_id", $stock_id)->first();
                $cariBaglan = $this->modelCari->where("cari_id", $dusum_cari_id)->first();

                $adet = $miktar;
                $depo = $warehouse_id ?? 1;
            
             

               
                $phoneNumber = $cariBaglan['cari_phone'];

                $invoice_date = date("d/m/Y");
                $invoice_time = date("H:i:s");

                $invoice_datetime = convert_datetime_for_sql_time($invoice_date, $invoice_time);


                $expiry_date = $invoice_datetime;
                $payment_method = null;
                $expiry_date_datetime = convert_datetime_for_sql_time($invoice_date, $invoice_time);
                if($stokBaglan['buy_unit_price_with_tax'] != 0){
                    $birimFiyats = $stokBaglan['buy_unit_price_with_tax'];
                }else{
                    $birimFiyats = $stokBaglan['buy_unit_price'];
                }

                $transaction_amount = $birimFiyats;
               
                $transaction_direction = 'exit';
                $is_customer = 0;
                $is_supplier = 1;
                $multiplier_for_cari_balance = -1;
            

                $cari_balance = null;
                $cari_id = null;

                $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id', $dusum_cari_id)->first();


                $faturaAsilTutar = 0;
                $faturaAsilTutar = $transaction_amount;
                $birimFiyat = $transaction_amount;

                $faturaAsilTutar = $faturaAsilTutar* (int)$adet;
                $birimFiyat = $birimFiyat* (int)$adet;


                $cari_id = $cariBaglan['cari_id'];
       

                $anlikParaBaglan = $this->modelMoneyUnit->where('money_unit_id', $cariBaglan['money_unit_id'])->first();

                $invoice_note_id = 0;
                $invoice_note = "Manuel Oluşturulan Fatura ve Stok Hareketi";


                $chx_quickSale = 0;
                $last_invoice = $this->modelInvoice->where('stok_giris', 1)->orderBy('invoice_id', 'DESC')->first();
                if ($last_invoice) {
                    $last_number = intval(substr($last_invoice['invoice_no'], 3));
                    $new_number = $last_number + 1;
                } else {
                    $new_number = 1;
                }
                $invoice_no = 'ONLINE' . str_pad($new_number, 6, '0', STR_PAD_LEFT);
                
                $insert_invoice_data = [
                    'user_id' => session()->get('user_id'),
                    'money_unit_id' => $cariBaglan['money_unit_id'],
                    'invoice_serial_id' => 0,

                    'invoice_no' => $invoice_no,
                    'invoice_ettn' => get_uuid(),//$new_data_form['invoice_ettn'],

                    'invoice_direction' => 'outgoing_invoice',
                    'invoice_scenario' => 'TICARIFATURA',
                    'invoice_type' => 'SATIS',

                    'invoice_date' => $invoice_datetime,

                    'payment_method' => '',
                    'expiry_date' => $invoice_datetime,

                    'invoice_note_id' => 0,
                    'invoice_note' => $invoice_note,

                    'currency_amount' => $anlikParaBaglan['money_value'],

                    'stock_total' => $faturaAsilTutar,
                    'stock_total_try' => $faturaAsilTutar,

                    'discount_total' => 0,
                    'discount_total_try' => 0,

                    'tax_rate_1_amount' => 0,
                    'tax_rate_1_amount_try' => 0,
                    'tax_rate_10_amount' => 0,
                    'tax_rate_10_amount_try' => 0,
                    'tax_rate_20_amount' => 0,
                    'tax_rate_20_amount_try' => 0,

                    'sub_total' => $faturaAsilTutar,
                    'sub_total_try' => $faturaAsilTutar,
                    'sub_total_0' => $faturaAsilTutar,
                    'sub_total_0_try' => $faturaAsilTutar,
                    'sub_total_1' => $faturaAsilTutar,
                    'sub_total_1_try' => $faturaAsilTutar,
                    'sub_total_10' => $faturaAsilTutar,
                    'sub_total_10_try' => $faturaAsilTutar,
                    'sub_total_20' => $faturaAsilTutar,
                    'sub_total_20_try' => $faturaAsilTutar,

                    'transaction_subject_to_withholding_amount' => convert_number_for_sql(0),
                    'transaction_subject_to_withholding_amount_try' => convert_number_for_sql(0),
                    'transaction_subject_to_withholding_calculated_tax' => convert_number_for_sql(0),
                    'transaction_subject_to_withholding_calculated_tax_try' => convert_number_for_sql(0),
                    'withholding_tax' => convert_number_for_sql(0),
                    'withholding_tax_try' => convert_number_for_sql(0),

                    'grand_total' => $faturaAsilTutar,
                    'grand_total_try' => $faturaAsilTutar,

                    'amount_to_be_paid' => $faturaAsilTutar,
                    'amount_to_be_paid_try' => $faturaAsilTutar,

                    'amount_to_be_paid_text' => $faturaAsilTutar,

                    'cari_id' => $cari_id,
                    'cari_identification_number' => $cariBaglan['identification_number'],
                    'cari_tax_administration' => $cariBaglan['tax_administration'],

                    'cari_invoice_title' => $cariBaglan['invoice_title'] == '' ? $cariBaglan['name'] . " " . $cariBaglan['surname'] : $cariBaglan['invoice_title'],
                    'cari_name' => $cariBaglan['name'],
                    'cari_surname' => $cariBaglan['surname'],   
                    'cari_obligation' => $cariBaglan['obligation'],
                    'cari_company_type' => $cariBaglan['company_type'],
                    'cari_phone' => $phoneNumber,
                    'cari_email' => $cariBaglan['cari_email'],

                    'address_country' => $cari_item['address_country'],

                    'address_city' => isset($cari_item['address_city']) ? $cari_item['address_city'] : "",
                    'address_city_plate' => isset($cari_item['address_city']) ? $cari_item['address_city'] : "",
                    'address_district' => isset($cari_item['address_district']) ? $cari_item['address_district'] : "",
                    'address_zip_code' => $cari_item['zip_code'],
                    'address' => $cari_item['address'],
                    'stok_giris' => "1",
                    'invoice_status_id' => "1",
                    'is_quick_sale_receipt' => $chx_quickSale,
                    'warehouse_id' => $depo,
                    'incoming_invoice_warehouse_id' => $depo,
                ];



                $this->modelInvoice->insert($insert_invoice_data);
                $invoice_id = $this->modelInvoice->getInsertID();





            $this->modelIslem->LogOlustur(
                session()->get('client_id'),
                session()->get('user_id'),
                $invoice_id,
                'ok',
                'fatura',
                "Otomatik Fatura Başarıyla Oluşturuldu",
                session()->get("user_item")["user_adsoyad"],
                json_encode( ['invoice_id' => $invoice_id, 'fatura_bilgileri' => $insert_invoice_data, 'fatura_satirlari' => $stock_id]),
                0,
                0,
                $invoice_id,
                0
             );


                $kurlar = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();

                if(isset($kurlar)){

                    foreach ($kurlar as $kur) {
                   
                        
                        // Default değerini belirle
                        $default = ($cari_item['money_unit_id'] == $kur['money_unit_id']) ? "true" : "false";
                    
                        // Fiyat verilerini hazırlama
                        $fiyatDatalar = [
                            'user_id'      => session()->get('user_id'),
                            'cari_id'      => $cari_id,
                            'fatura_id'    => $invoice_id,
                            'kur'          => $kur['money_unit_id'],
                            'kur_value'    => $this->convert_sql($kur['money_value']),
                            'toplam_tutar' => $this->convert_sql($faturaAsilTutar / $kur['money_value']),
                            'tarih'        => date("d-m-Y h:i:s"),  // PHP'de date() fonksiyonu kullanılır
                            'default'      => $default
                        ];
                    
                            $insertFiyat = $this->modelFaturaTutar->insert($fiyatDatalar);
                            if (!$insertFiyat) {
                                echo "Fiyat eklenirken bir hata oluştu.";
                            }
                    }
                    

                }

              


                //cari para birimi
                $cari_money_unit_id = $cari_item['money_unit_id'];



                $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                if ($last_transaction) {
                    $transaction_counter = $last_transaction['transaction_counter'] + 1;
                } else {
                    $transaction_counter = 1;
                }
                $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                $insert_financial_movement_data = [
                    'user_id' => session()->get('user_id'),
                    'financial_account_id' => null,
                    'cari_id' => $cari_id,
                    'money_unit_id' => $cari_item['money_unit_id'],
                    'transaction_number' => $transaction_number,
                    'transaction_direction' => $transaction_direction,
                    'transaction_type' => 'outgoing_invoice',
                    'invoice_id' => $invoice_id,
                    'transaction_tool' => 'not_payroll',
                    'transaction_title' => 'Otomatik Fatura oluştur anında oluşan hareket',
                    'transaction_description' => $invoice_note,
                    'transaction_amount' => $faturaAsilTutar,
                    'transaction_real_amount' => $faturaAsilTutar,
                    'transaction_date' => $invoice_datetime,
                    'transaction_prefix' => $transaction_prefix,
                    'transaction_counter' => $transaction_counter
                ];
                $this->modelFinancialMovement->insert($insert_financial_movement_data);
                $financial_movement_id = $this->modelFinancialMovement->getInsertID();


                   

                
                

                        #TODO sistemde kayıtlı olmayan bir ürün için de te seferlik fatura oluşturabilmeli. daha sonra bu ürünü kaydet seçeneği de koyacağız.
                        #check if stock exists
                     
                        $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $stock_id)->first();
              

                        $parent_idd = $stock_item['parent_id'];


                        $insert_StockWarehouseQuantity = [
                            'user_id' => session()->get('user_id'),
                            'warehouse_id' => $depo,
                            'stock_id' => $stock_item['stock_id'],
                            'parent_id' => $stock_item['parent_id'],
                            'stock_quantity' => $adet,
                        ];

                        // print_r($insert_StockWarehouseQuantity);


                        $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $depo, $stock_item['stock_id'], $parent_idd, floatval($adet), 'remove', $this->modelStockWarehouseQuantity, $this->modelStock);
                       // if ($addStock === 'eksi_stok') {
                         //   echo json_encode(['icon' => 'error', 'message' => 'bu işlemden sonra bazı ürünlerin stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz.']);
                           // $this->modelInvoice->delete($invoice_id);
                            //$this->modelFinancialMovement->delete($financial_movement_id);
                            //exit();
                        //}


                        $insert_invoice_row_data = [
                            'user_id' => session()->get('user_id'),
                            'cari_id' => $cari_id,
                            'invoice_id' => $invoice_id,
                            'stock_id' => $stock_item['stock_id'],

                            'stock_title' => $stock_item['stock_title'],
                            'stock_amount' => $adet, //convert_number_for_sql($data_invoice_row['stock_amount'])

                            'unit_id' => 1,
                            'unit_price' => $faturaAsilTutar,

                            'discount_rate' => 0,
                            'discount_price' => 0,

                            'subtotal_price' => $faturaAsilTutar,

                            'tax_id' => 0,
                            'tax_price' => 0,

                            'total_price' => $faturaAsilTutar,

                            'gtip_code' => 0,

                            'withholding_id' => 0,
                            'withholding_rate' => 0,
                            'withholding_price' => 0,
                        ];

                        $this->modelInvoiceRow->insert($insert_invoice_row_data);
                        $invoice_row_id = $this->modelInvoiceRow->getInsertID();



                        $last_stock_barcode_id = 0;
                        $stock_barcode_all = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                            ->where('stock_barcode.stock_id', $stock_item['stock_id'])
                            ->where('stock_barcode.warehouse_id', 1)
                            ->findAll();

                        // stock_barcode'da used_amount günceller
                        foreach ($stock_barcode_all as $stock_barcode_item) {

                            $varMi = $stock_barcode_item['total_amount'] - $stock_barcode_item['used_amount'];

                            if ($varMi >= 1) {
                                $stock_movement_prefix = 'TRNSCTN';

                                $last_transaction = $this->modelStockMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                                if ($last_transaction) {
                                    $transaction_counter = $last_transaction['transaction_counter'] + 1;
                                } else {
                                    $transaction_counter = 1;
                                }
                                $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                                $insert_stock_movement_data = [
                                    'user_id' => session()->get('user_id'),
                                    'stock_barcode_id' => $stock_barcode_item['stock_barcode_id'],
                                    'invoice_id' => $invoice_id,
                                    'movement_type' => 'outgoing',
                                    'transaction_number' => $transaction_number,
                                    'transaction_note' => null,
                                    'from_warehouse' => $depo,
                                    'transaction_info' => 'Otomatik İrsaliye Sonucu Stok Çıkış',
                                    'sale_unit_price' => $faturaAsilTutar,
                                    'sale_money_unit_id' => $cariBaglan['money_unit_id'],
                                    'buy_money_unit_id' => $cariBaglan['money_unit_id'], // Satın alma para birimi eklendi
                                    'transaction_quantity' => $adet,
                                    'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                                    'transaction_prefix' => $transaction_prefix,
                                    'transaction_counter' => $transaction_counter,
                                ];
                                $this->modelStockMovement->insert($insert_stock_movement_data);
                                $stock_movement_id = $this->modelStockMovement->getInsertID();

                                $used_amount = $stock_barcode_item['used_amount'] + 1;
                                $stock_barcode_status = $used_amount == $stock_barcode_item['total_amount'] ? 'out_of_stock' : 'available';
                                $update_stock_barcode_data = [
                                    'used_amount' => $used_amount,
                                    'stock_barcode_status' => $stock_barcode_status
                                ];
                                $this->modelStockBarcode->update($stock_barcode_item['stock_barcode_id'], $update_stock_barcode_data);

                                $update_invoice_row_data = [
                                    'stock_barcode_id' => $stock_barcode_item['stock_barcode_id'],
                                ];
                                $this->modelInvoiceRow->update($invoice_row_id, $update_invoice_row_data);
                                break 1;
                            }
                        }


                        $BakiyeGuncelle = new Cari();
                        $BakiyeGuncelle->bakiyeHesapla($dusum_cari_id);
            

                return $invoice_id;
                // return;
                // }
            } catch (\Exception $e) {
                $backtrace = $e->getTrace();
                $errorMessage = $e->getMessage();
                $errorDetails = [
                    'error_message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $backtrace
                ];
                $this->logClass->save_log(
                    'error',
                    'invoice',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                $userFriendlyMessage = "Bir hata oluştu: <br>" . $errorMessage . ". <br>Lütfen daha sonra tekrar deneyin.";

                // Hata detaylarını JSON olarak döndürüyoruz (Opsiyonel: Bu kısmı son kullanıcıya göstermek yerine log için kullanın)
                $debugDetails = json_encode($errorDetails, JSON_PRETTY_PRINT); // Geliştirici için anlaşılır detaylar

                // Basit hata mesajını JSON formatında döndür
                echo json_encode(['icon' => 'error', 'message' => $debugDetails]);
                return;
            }
        
    }
    public function stokDusumTest($stock_id)
    {
        try {
            $miktar = $this->request->getGet('miktar') ?? 1;
            $warehouse_id = $this->request->getGet('warehouse_id') ?? null;
            
            $result = $this->stokDusum($stock_id, $miktar, $warehouse_id, $text = null);
            
            echo json_encode([
                'icon' => 'success',
                'message' => 'Stok Başarıyla Düşüldü',
                'errRows' => []
                
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function stokGiris($stock_id, $miktar = 1, $warehouse_id = null, $text = null)
    {
        $Kurlar = $this->modelMoneyUnit->findAll();

        $transaction_prefix = "PRF";
        $errRows = [];     
        $dusum_cari_id = 15199;
            try {
                $stokBaglan = $this->modelStock->where("stock_id", $stock_id)->first();
                $cariBaglan = $this->modelCari->where("cari_id", $dusum_cari_id)->first();


                $adet = $miktar;
                $depo = $warehouse_id ?? 1;
             

               
                $phoneNumber = $cariBaglan['cari_phone'];

                $invoice_date = date("d/m/Y");
                $invoice_time = date("H:i:s");

                $invoice_datetime = convert_datetime_for_sql_time($invoice_date, $invoice_time);


                $expiry_date = $invoice_datetime;
                $payment_method = null;
                $expiry_date_datetime = convert_datetime_for_sql_time($invoice_date, $invoice_time);
                if($stokBaglan['buy_unit_price_with_tax'] != 0){
                    $birimFiyats = $stokBaglan['buy_unit_price_with_tax'];
                }else{
                    $birimFiyats = $stokBaglan['buy_unit_price'];
                }

                $transaction_amount = $birimFiyats;
               
                $transaction_direction = 'entry';
                $is_customer = 0;
                $is_supplier = 1;
                $multiplier_for_cari_balance = -1;
            

                $cari_balance = null;
                $cari_id = null;

                $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id', $dusum_cari_id)->first();


                $faturaAsilTutar = 0;
                $faturaAsilTutar = $transaction_amount;
                $birimFiyat = $transaction_amount;

                $faturaAsilTutar = $faturaAsilTutar* (int)$adet;
                $birimFiyat = $birimFiyat* (int)$adet;

                $cari_id = $cariBaglan['cari_id'];
       

                $anlikParaBaglan = $this->modelMoneyUnit->where('money_unit_id', $cariBaglan['money_unit_id'])->first();

                $invoice_note_id = 0;
                $invoice_note = $text ?? "Manuel Oluşturulan Fatura ve Stok Hareketi";


                $chx_quickSale = 0;
                $last_invoice = $this->modelInvoice->where('stok_giris', 1)->orderBy('invoice_id', 'DESC')->first();
                if ($last_invoice) {
                    $last_number = intval(substr($last_invoice['invoice_no'], 3));
                    $new_number = $last_number + 1;
                } else {
                    $new_number = 1;
                }
                $invoice_no = 'ONLINE' . str_pad($new_number, 6, '0', STR_PAD_LEFT);
                
                $insert_invoice_data = [
                    'user_id' => session()->get('user_id'),
                    'money_unit_id' => $cariBaglan['money_unit_id'],
                    'invoice_serial_id' => 0,

                    'invoice_no' => $invoice_no,
                    'invoice_ettn' => get_uuid(),//$new_data_form['invoice_ettn'],

                    'invoice_direction' => 'incoming_invoice',
                    'invoice_scenario' => 'TICARIFATURA',
                    'invoice_type' => 'SATIS',

                    'invoice_date' => $invoice_datetime,

                    'payment_method' => '',
                    'expiry_date' => $invoice_datetime,

                    'invoice_note_id' => 0,
                    'invoice_note' => $invoice_note,

                    'currency_amount' => $anlikParaBaglan['money_value'],

                    'stock_total' => $faturaAsilTutar,
                    'stock_total_try' => $faturaAsilTutar,

                    'discount_total' => 0,
                    'discount_total_try' => 0,

                    'tax_rate_1_amount' => 0,
                    'tax_rate_1_amount_try' => 0,
                    'tax_rate_10_amount' => 0,
                    'tax_rate_10_amount_try' => 0,
                    'tax_rate_20_amount' => 0,
                    'tax_rate_20_amount_try' => 0,

                    'sub_total' => $faturaAsilTutar,
                    'sub_total_try' => $faturaAsilTutar,
                    'sub_total_0' => $faturaAsilTutar,
                    'sub_total_0_try' => $faturaAsilTutar,
                    'sub_total_1' => $faturaAsilTutar,
                    'sub_total_1_try' => $faturaAsilTutar,
                    'sub_total_10' => $faturaAsilTutar,
                    'sub_total_10_try' => $faturaAsilTutar,
                    'sub_total_20' => $faturaAsilTutar,
                    'sub_total_20_try' => $faturaAsilTutar,

                    'transaction_subject_to_withholding_amount' => convert_number_for_sql(0),
                    'transaction_subject_to_withholding_amount_try' => convert_number_for_sql(0),
                    'transaction_subject_to_withholding_calculated_tax' => convert_number_for_sql(0),
                    'transaction_subject_to_withholding_calculated_tax_try' => convert_number_for_sql(0),
                    'withholding_tax' => convert_number_for_sql(0),
                    'withholding_tax_try' => convert_number_for_sql(0),

                    'grand_total' => $faturaAsilTutar,
                    'grand_total_try' => $faturaAsilTutar,

                    'amount_to_be_paid' => $faturaAsilTutar,
                    'amount_to_be_paid_try' => $faturaAsilTutar,

                    'amount_to_be_paid_text' => $faturaAsilTutar,

                    'cari_id' => $cari_id,
                    'cari_identification_number' => $cariBaglan['identification_number'],
                    'cari_tax_administration' => $cariBaglan['tax_administration'],

                    'cari_invoice_title' => $cariBaglan['invoice_title'] == '' ? $cariBaglan['name'] . " " . $cariBaglan['surname'] : $cariBaglan['invoice_title'],
                    'cari_name' => $cariBaglan['name'],
                    'cari_surname' => $cariBaglan['surname'],   
                    'cari_obligation' => $cariBaglan['obligation'],
                    'cari_company_type' => $cariBaglan['company_type'],
                    'cari_phone' => $phoneNumber,
                    'cari_email' => $cariBaglan['cari_email'],

                    'address_country' => $cari_item['address_country'],

                    'address_city' => isset($cari_item['address_city']) ? $cari_item['address_city'] : "",
                    'address_city_plate' => isset($cari_item['address_city']) ? $cari_item['address_city'] : "",
                    'address_district' => isset($cari_item['address_district']) ? $cari_item['address_district'] : "",
                    'address_zip_code' => $cari_item['zip_code'],
                    'address' => $cari_item['address'],
                    'stok_giris' => "1",
                    'invoice_status_id' => "1",
                    'is_quick_sale_receipt' => $chx_quickSale,
                    'warehouse_id' => $depo,
                    'incoming_invoice_warehouse_id' => $depo,
                ];



                $this->modelInvoice->insert($insert_invoice_data);
                $invoice_id = $this->modelInvoice->getInsertID();



            $this->modelIslem->LogOlustur(
                session()->get('client_id'),
                session()->get('user_id'),
                $invoice_id,
                'ok',
                'fatura',
                "Otomatik Fatura Başarıyla Oluşturuldu",
                session()->get("user_item")["user_adsoyad"],
                json_encode( ['invoice_id' => $invoice_id, 'fatura_bilgileri' => $insert_invoice_data, 'fatura_satirlari' => $stock_id]),
                0,
                0,
                $invoice_id,
                0
             );


                $kurlar = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();

                if(isset($kurlar)){

                    foreach ($kurlar as $kur) {
                   
                        
                        // Default değerini belirle
                        $default = ($cari_item['money_unit_id'] == $kur['money_unit_id']) ? "true" : "false";
                    
                        // Fiyat verilerini hazırlama
                        $fiyatDatalar = [
                            'user_id'      => session()->get('user_id'),
                            'cari_id'      => $cari_id,
                            'fatura_id'    => $invoice_id,
                            'kur'          => $kur['money_unit_id'],
                            'kur_value'    => $this->convert_sql($kur['money_value']),
                            'toplam_tutar' => $this->convert_sql($faturaAsilTutar / $kur['money_value']),
                            'tarih'        => date("d-m-Y h:i:s"),  // PHP'de date() fonksiyonu kullanılır
                            'default'      => $default
                        ];
                    
                            $insertFiyat = $this->modelFaturaTutar->insert($fiyatDatalar);
                            if (!$insertFiyat) {
                                echo "Fiyat eklenirken bir hata oluştu.";
                            }
                    }
                    

                }

              


                //cari para birimi
                $cari_money_unit_id = $cari_item['money_unit_id'];



                $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                if ($last_transaction) {
                    $transaction_counter = $last_transaction['transaction_counter'] + 1;
                } else {
                    $transaction_counter = 1;
                }
                $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                $insert_financial_movement_data = [
                    'user_id' => session()->get('user_id'),
                    'financial_account_id' => null,
                    'cari_id' => $cari_id,
                    'money_unit_id' => $cari_item['money_unit_id'],
                    'transaction_number' => $transaction_number,
                    'transaction_direction' => $transaction_direction,
                    'transaction_type' => 'incoming_invoice',
                    'invoice_id' => $invoice_id,
                    'transaction_tool' => 'not_payroll',
                    'transaction_title' => 'Otomatik Fatura oluştur anında oluşan hareket',
                    'transaction_description' => $invoice_note,
                    'transaction_amount' => $faturaAsilTutar,
                    'transaction_real_amount' => $faturaAsilTutar,
                    'transaction_date' => $invoice_datetime,
                    'transaction_prefix' => $transaction_prefix,
                    'transaction_counter' => $transaction_counter
                ];
                $this->modelFinancialMovement->insert($insert_financial_movement_data);
                $financial_movement_id = $this->modelFinancialMovement->getInsertID();


                   

                
                

                        #TODO sistemde kayıtlı olmayan bir ürün için de te seferlik fatura oluşturabilmeli. daha sonra bu ürünü kaydet seçeneği de koyacağız.
                        #check if stock exists
                     
                        $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $stock_id)->first();
              

    
                                $parent_idd = $stock_item['parent_id'];
                                $insert_invoice_row_data = [
                                    'user_id' => session()->get('user_id'),
                                    'cari_id' => $cari_id,
                                    'invoice_id' => $invoice_id,
                                    'stock_id' => $stock_item['stock_id'],
    
                                    'stock_title' => $stock_item['stock_title'],
                                    'stock_amount' => $adet, //convert_number_for_sql($data_invoice_row['stock_amount'])
    
                                    'unit_id' => 1,
                                    'unit_price' => $faturaAsilTutar,
    
                                    'discount_rate' => 0,
                                    'discount_price' => 0,
    
                                    'subtotal_price' => $faturaAsilTutar,
    
                                    'tax_id' => 0,
                                    'tax_price' => 0,
    
                                    'total_price' => $faturaAsilTutar,
    
                                    'gtip_code' => 0,
    
                                    'withholding_id' => 0,
                                    'withholding_rate' => 0,
                                    'withholding_price' => 0,
                                ];
    
                                $this->modelInvoiceRow->insert($insert_invoice_row_data);
                                $warehouse_form = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('warehouse_id', $depo)->first();
                                if (isset($warehouse_form)) {
    
                                    $warehouse_id = $depo;
                                    $supplier_id = $cariBaglan['cari_id'];
                                    $stock_quantity = $adet;
                                    $warehouse_address = null;
                                    $buy_unit_price = $birimFiyat;
                                    $buy_money_unit_id = $cari_item['money_unit_id'];
    
                                    //stock_barcode eklendi
                                    $barcode_number = generate_barcode_number();
                                    $insert_barcode_data = [
                                        'stock_id' => $stock_item['stock_id'],
                                        'warehouse_id' => $warehouse_id,
                                        'warehouse_address' => null,
                                        'barcode_number' => $barcode_number,
                                        'total_amount' => $stock_quantity,
                                        'used_amount' => 0
                                    ];
                                    $this->modelStockBarcode->insert($insert_barcode_data);
                                    $new_insert_stock_barcode_id = $this->modelStockBarcode->getInsertID();
    
    
    
                                    $stock_movement_prefix = 'TRNSCTN';
                                    $last_transaction_stock_movement = $this->modelStockMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                                    if ($last_transaction_stock_movement) {
                                        $transaction_counter_stock_movement = $last_transaction_stock_movement['transaction_counter'] + 1;
                                    } else {
                                        $transaction_counter_stock_movement = 1;
                                    }
                                    $transaction_number_stock_movement = $stock_movement_prefix . str_pad($transaction_counter_stock_movement, 6, '0', STR_PAD_LEFT);
    
                                    $insert_movement_data = [
                                        'user_id' => session()->get('user_id'),
                                        'stock_barcode_id' => $new_insert_stock_barcode_id,
                                        'invoice_id' => $invoice_id,
                                        'supplier_id' => $supplier_id,
                                        'movement_type' => 'incoming',
                                        'transaction_number' => $transaction_number_stock_movement,
                                        'to_warehouse' => $warehouse_id,
                                        'transaction_note' => null,
                                        'transaction_info' => 'Otomatik İrsaliye Sonucu Stok Girişi',
                                        'buy_unit_price' => $faturaAsilTutar,
                                        'buy_money_unit_id' => $buy_money_unit_id,
                                        'transaction_quantity' => $adet,
                                        'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                                        'transaction_prefix' => $stock_movement_prefix,
                                        'transaction_counter' => $transaction_counter_stock_movement,
                                    ];
                                    $this->modelStockMovement->insert($insert_movement_data);
                                    $stock_movement_id = $this->modelStockMovement->getInsertID();
    
                                    $insert_StockWarehouseQuantity = [
                                        'user_id' => session()->get('user_id'),
                                        'warehouse_id' => $warehouse_id,
                                        'stock_id' => $stock_item['stock_id'],
                                        'parent_id' => $stock_item['parent_id'],
                                        'stock_quantity' => $adet,
                                    ];
    
                                    $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $warehouse_id, $stock_item['stock_id'], $stock_item['parent_id'], $stock_quantity, 'add', $this->modelStockWarehouseQuantity, $this->modelStock);
    
                                    //if ($addStock === 'eksi_stok') {
                                      //  echo json_encode(['icon' => 'error', 'message' => 'bu işlemden sonra bazı ürünlerin stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz.']);
    
                                        //return;
                                    //}
                                
                                }
                        



                        
                
                  
                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] - $faturaAsilTutar,
                    ];
                    $this->modelCari->update($cari_id, $update_cari_data);

                    
                    $BakiyeGuncelle = new Cari();
                    $BakiyeGuncelle->bakiyeHesapla($dusum_cari_id);



            

                return $invoice_id;
                // return;
                // }
            } catch (\Exception $e) {
                $backtrace = $e->getTrace();
                $errorMessage = $e->getMessage();
                $errorDetails = [
                    'error_message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $backtrace
                ];
                $this->logClass->save_log(
                    'error',
                    'invoice',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                $userFriendlyMessage = "Bir hata oluştu: <br>" . $errorMessage . ". <br>Lütfen daha sonra tekrar deneyin.";

                // Hata detaylarını JSON olarak döndürüyoruz (Opsiyonel: Bu kısmı son kullanıcıya göstermek yerine log için kullanın)
                $debugDetails = json_encode($errorDetails, JSON_PRETTY_PRINT); // Geliştirici için anlaşılır detaylar

                // Basit hata mesajını JSON formatında döndür
                echo json_encode(['icon' => 'error', 'message' => $debugDetails]);
                return;
            }
        
    }



    function convert_sql($number) {
        // Virgül ile ayrılmış ondalık sayıyı noktaya çevir
        $number = str_replace(",", ".", $number);
    
        // Eğer sayı ondalıklıysa iki ondalık basamağa kadar yuvarla
        return number_format((float)$number, 2, '.', '');
    }
    public function stokGirisTest($stock_id)
    {
        try {
            $miktar = $this->request->getGet('miktar') ?? 1;
            $warehouse_id = $this->request->getGet('warehouse_id') ?? null;
            
            $result = $this->stokGiris($stock_id, $miktar, $warehouse_id, $text = null );
            
            echo json_encode([
                'icon' => 'success',
                'message' => 'Stok Başarıyla Girildi',
                'errRows' => [],
                'newdInvoiceId' => $result
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
/*
    public function irsaliye()
    {
        $order_ids = $this->request->getGet('order_ids');
     
        if (!$order_ids) {
            return redirect()->to(base_url('tportal/order/list/all'))->with('error', 'Sipariş seçilmedi!');
        }

        $depoListesi = [
            [
                'depo_id' => 1,
                'depo_title' => '1.Depo'
            ],
            [
                'depo_id' => 2, 
                'depo_title' => '2.Depo'
            ],
            [
                'depo_id' => 3,
                'depo_title' => '3.Depo'
            ],  
            [
                'depo_id' => 4,
                'depo_title' => 'AMBALAJ'
            ],
            [
                'depo_id' => 5,
                'depo_title' => 'SAC DEPOSU'
            ],
            [
                'depo_id' => 6,
                'depo_title' => 'ABS DEPOSU'
            ],
            [
                'depo_id' => 7,
                'depo_title' => 'KALIP DEPOSU'
            ],
            [
                'depo_id' => 8,
                'depo_title' => 'ÜRETİM ALANI'
            ],
        ];

        $order_ids = explode(',', $order_ids);
        $order_rows = [];
        $order_items = [];
        $statistics = [
            'total_orders' => 0,
            'total_products' => 0,
            'total_quantity' => 0,
            'packaged_products' => [],
            'non_packaged_products' => []
        ];
        
        foreach ($order_ids as $order_id) {
            $order_item = $this->modelOrder
                ->select('order.*, money_unit.money_icon as money_icon')
                ->join('money_unit', 'money_unit.money_unit_id = order.money_unit_id')
                ->where('order.order_id', $order_id)
                ->first();
        
            if ($order_item) {
                $order_items[] = $order_item;
                $statistics['total_orders']++;
                
                $rows = $this->modelOrderRow
                    ->select('order_row.*, stock.sysmond as sysmond_id, stock.stock_title as stock_title, 
                             stock.stock_code as stock_code, order_row.paket_text, stock.paket,
                             stock.default_image, unit.unit_title as unit_title, 
                             sysmond_depolar.depo_1, sysmond_depolar.depo_1_id, sysmond_depolar.depo_1_count,
                             sysmond_depolar.depo_2, sysmond_depolar.depo_2_id, sysmond_depolar.depo_2_count,
                             sysmond_depolar.depo_3, sysmond_depolar.depo_3_id, sysmond_depolar.depo_3_count')
                    ->join('stock', 'stock.stock_id = order_row.stock_id', 'left')
                    ->join('unit', 'unit.unit_id = order_row.unit_id', 'left')
                    ->join('sysmond_depolar', 'sysmond_depolar.stock_id = stock.stock_id', 'left')
                    ->where('order_id', $order_id)
                    ->findAll();
        
                foreach ($rows as $row) {
                    $statistics['total_products']++;
                    $statistics['total_quantity'] += $row['stock_amount'];
        
                    if (!empty($row['paket_text'])) {
                        $statistics['packaged_products'][] = [
                            'stock_title' => $row['stock_title'],
                            'stock_code' => $row['stock_code'],
                            'quantity' => $row['stock_amount'],
                            'paket_text' => $row['paket_text']
                        ];
                    } else {
                        $statistics['non_packaged_products'][] = [
                            'stock_title' => $row['stock_title'],
                            'stock_code' => $row['stock_code'],
                            'quantity' => $row['stock_amount']
                        ];
                    }
                }
        
                $order_rows = array_merge($order_rows, $rows);
            }
        }
        
        if (empty($order_items)) {
            return redirect()->to(base_url('tportal/siparisler/list/all'))->with('error', 'Siparişler bulunamadı!');
        }

     
        $data = [
            'depoListesi' => $depoListesi,
            'order_items' => $order_items,
            'order_rows' => $order_rows,
            'order_id_full' => $order_ids,
            'statistics' => $statistics
        ];

        return view('tportal/siparisler/irsaliye', $data);
    }
*/


// app/Controllers/TikoERP/Order.php

public function irsaliye()
{
    $order_ids = $this->request->getGet('order_ids');
 
    if (!$order_ids) {
        return redirect()->to(base_url('tportal/order/list/all'))->with('error', 'Sipariş seçilmedi!');
    }

    $depoListesi = [
        [
            'depo_id' => 1,
            'depo_title' => '1.Depo'
        ],
        [
            'depo_id' => 2, 
            'depo_title' => '2.Depo'
        ],
        [
            'depo_id' => 3,
            'depo_title' => '3.Depo'
        ],  
        [
            'depo_id' => 4,
            'depo_title' => 'AMBALAJ'
        ],
        [
            'depo_id' => 5,
            'depo_title' => 'SAC DEPOSU'
        ],
        [
            'depo_id' => 6,
            'depo_title' => 'ABS DEPOSU'
        ],
        [
            'depo_id' => 7,
            'depo_title' => 'KALIP DEPOSU'
        ],
        [
            'depo_id' => 8,
            'depo_title' => 'ÜRETİM ALANI'
        ],
    ];

    $order_ids = explode(',', $order_ids);
    $order_rows = [];
    $order_items = [];
    $statistics = [
        'total_orders' => 0,
        'total_products' => 0,
        'total_quantity' => 0,
        'packaged_products' => [],
        'non_packaged_products' => []
    ];
    
    foreach ($order_ids as $order_id) {
        $order_item = $this->modelOrder
            ->select('order.*, money_unit.money_icon as money_icon')
            ->join('money_unit', 'money_unit.money_unit_id = order.money_unit_id')
            ->where('order.order_id', $order_id)
            ->first();
    
        if ($order_item) {
            $order_items[] = $order_item;
            $statistics['total_orders']++;
            
            $rows = $this->modelOrderRow
                ->select('order_row.*, stock.sysmond as sysmond_id, stock.stock_title as stock_title, 
                         stock.stock_code as stock_code, order_row.paket_text, stock.paket,
                         stock.default_image, unit.unit_title as unit_title, 
                         sysmond_depolar.depo_1, sysmond_depolar.depo_1_id, sysmond_depolar.depo_1_count,
                         sysmond_depolar.depo_2, sysmond_depolar.depo_2_id, sysmond_depolar.depo_2_count,
                         sysmond_depolar.depo_3, sysmond_depolar.depo_3_id, sysmond_depolar.depo_3_count')
                ->join('stock', 'stock.stock_id = order_row.stock_id', 'left')
                ->join('unit', 'unit.unit_id = order_row.unit_id', 'left')
                ->join('sysmond_depolar', 'sysmond_depolar.stock_id = stock.stock_id', 'left')
                ->where('order_id', $order_id)
                ->findAll();
    
            foreach ($rows as $row) {
                $statistics['total_products']++;
                $statistics['total_quantity'] += $row['stock_amount'];
    
                if (!empty($row['paket_text'])) {
                    $statistics['packaged_products'][] = [
                        'stock_title' => $row['stock_title'],
                        'stock_code' => $row['stock_code'],
                        'quantity' => $row['stock_amount'],
                        'paket_text' => $row['paket_text']
                    ];
                } else {
                    $statistics['non_packaged_products'][] = [
                        'stock_title' => $row['stock_title'],
                        'stock_code' => $row['stock_code'],
                        'quantity' => $row['stock_amount']
                    ];
                }
            }
    
            $order_rows = array_merge($order_rows, $rows);
        }
    }

    // Aynı ürünleri grupla
    $grouped_rows = [];
    foreach ($order_rows as $row) {
        $key = $row['stock_id'] . '_' . $row['unit_id']; // unit_price'ı kaldırdık
        
        if (!isset($grouped_rows[$key])) {
            $grouped_rows[$key] = $row;
            $grouped_rows[$key]['order_row_ids'] = [$row['order_row_id']];
            $grouped_rows[$key]['order_ids'] = [$row['order_id']];
            $grouped_rows[$key]['original_amounts'] = [$row['stock_amount']];
            $grouped_rows[$key]['unit_prices'] = [$row['unit_price']]; // Farklı fiyatları saklayalım
            $grouped_rows[$key]['total_prices'] = [$row['total_price']]; // Farklı toplamları saklayalım
        } else {
            $grouped_rows[$key]['stock_amount'] += $row['stock_amount'];
            $grouped_rows[$key]['order_row_ids'][] = $row['order_row_id'];
            $grouped_rows[$key]['order_ids'][] = $row['order_id'];
            $grouped_rows[$key]['original_amounts'][] = $row['stock_amount'];
            $grouped_rows[$key]['unit_prices'][] = $row['unit_price'];
            $grouped_rows[$key]['total_prices'][] = $row['total_price'];
            
            // En yüksek fiyatı ana fiyat olarak kullanalım
            if ($row['unit_price'] > $grouped_rows[$key]['unit_price']) {
                $grouped_rows[$key]['unit_price'] = $row['unit_price'];
            }
            
            // Toplam fiyatı güncelle
            $grouped_rows[$key]['total_price'] = array_sum($grouped_rows[$key]['total_prices']);
        }
    }

    if (empty($order_items)) {
        return redirect()->to(base_url('tportal/siparisler/list/all'))->with('error', 'Siparişler bulunamadı!');
    }

    $statistics = [
        'total_orders' => count($order_items),
        'total_products' => count(array_unique(array_column($order_rows, 'stock_id'))), // Tekil ürün sayısı
        'total_quantity' => array_sum(array_column($order_rows, 'stock_amount')),
        'packaged_products' => array_filter($order_rows, function($row) {
            return !empty($row['paket_text']);
        }),
        'non_packaged_products' => array_filter($order_rows, function($row) {
            return empty($row['paket_text']);
        })
    ];

    $data = [
        'depoListesi' => $depoListesi,
        'order_items' => $order_items,
        'order_rows' => array_values($grouped_rows),
        'order_id_full' => $order_ids,
        'statistics' => $statistics
    ];

    return view('tportal/siparisler/irsaliye', $data);
}
    public function gunlukrapor()
    {
        // Veritabanı bağlantısını doğrudan kur
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
        $db = \Config\Database::connect($userDatabaseDetail);

        $builder = $db->table('order');
       
        // Tarih filtrelerini al
        $start_date = $this->request->getGet('start_date') ? date('Y-m-d 00:00:00', strtotime($this->request->getGet('start_date'))) : date('Y-m-d 00:00:00');
        $end_date = $this->request->getGet('end_date') ? date('Y-m-d 23:59:59', strtotime($this->request->getGet('end_date'))) : date('Y-m-d 23:59:59');
        
        // Günlük siparişleri getir
        $daily_orders_dopigo = $builder->where('order_date >=', $start_date)
                              ->where('order_date <=', $end_date)
                             
                              ->get()
                              ->getResultArray();
        $daily_orders = [];
        foreach ($daily_orders_dopigo as $order) {
            if($order['dopigo'] != null){
                $daily_orders[] = $order;
            }
        }
                              

  
        $order_ids = array_column($daily_orders, 'id');
        
        // Sipariş detaylarını getir
        $order_details = [];
        if (!empty($order_ids)) {
            $order_details = $this->modelOrderRow->whereIn('order_id', $order_ids)->findAll();
        }

        // Sipariş tutarlarını hesapla
        $order_amounts = [];
        foreach ($order_details as $detail) {
            $order_id = $detail['order_id'];
            if (!isset($order_amounts[$order_id])) {
                $order_amounts[$order_id] = 0;
            }
            $order_amounts[$order_id] += $detail['total_price'];
        }

        // Service bazlı sipariş durumlarını analiz et
        $service_status = [];
        foreach ($daily_orders as $order) {
            $service = $order['service_name'] ?? 'Diğer';
            if (!isset($service_status[$service])) {
                $service_status[$service] = [
                    'name' => $service,
                    'sevk_edildi' => 0,
                    'sevk_edildi_amount' => 0,
                    'kargo_bekliyor' => 0,
                    'kargo_bekliyor_amount' => 0,
                    'failed' => 0,
                    'failed_amount' => 0,
                    'sevk_emri' => 0,
                    'sevk_emri_amount' => 0
                ];
            }

            $amount = $order_amounts[$order['order_id']] ?? 0;

            switch ($order['order_status']) {
                case 'sevk_edildi':
                    $service_status[$service]['sevk_edildi']++;
                    $service_status[$service]['sevk_edildi_amount'] += $amount;
                    break;
                case 'kargo_bekliyor':
                    $service_status[$service]['kargo_bekliyor']++;
                    $service_status[$service]['kargo_bekliyor_amount'] += $amount;
                    break;
                case 'failed':
                    $service_status[$service]['failed']++;
                    $service_status[$service]['failed_amount'] += $amount;
                    break;
                case 'sevk_emri':
                    $service_status[$service]['sevk_emri']++;
                    $service_status[$service]['sevk_emri_amount'] += $amount;
                    break;
            }
        }

        // Sipariş durumlarına göre gruplandırma ve renk kodları
        $status_data = [
            //'new' => ['name' => 'Yeni Sipariş', 'count' => 0, 'color' => '#6576ff'],
          //  'pending' => ['name' => 'Hazırlanıyor', 'count' => 0, 'color' => '#f4bd0e'],
            //'success' => ['name' => 'Teslim Edildi', 'count' => 0, 'color' => '#1ee0ac'],
            'failed' => ['name' => 'İptal', 'count' => 0, 'color' => '#e85347'],
            'sevk_emri' => ['name' => 'Sevk Emri Verildi', 'count' => 0, 'color' => '#6576ff'],
            'sevk_edildi' => ['name' => 'Sevk Edildi', 'count' => 0, 'color' => '#1ee0ac'],
            //'stokta_yok' => ['name' => 'Stokta Yok', 'count' => 0, 'color' => '#e85347'],
            //'teknik_hata' => ['name' => 'Teknik Hata', 'count' => 0, 'color' => '#e85347'],
            'kargolandi' => ['name' => 'Kargolandı', 'count' => 0, 'color' => '#1ee0ac'],
            'kargo_bekliyor' => ['name' => 'Kargo Bekliyor', 'count' => 0, 'color' => '#f4bd0e'],
           // 'yetistirilemedi' => ['name' => 'Yetiştirilemedi', 'count' => 0, 'color' => '#e85347']
        ];
        
        $total_amount = 0;
        $total_orders = count($daily_orders);
        
        // Saatlik sipariş dağılımı için array
        $hourly_orders = array_fill(0, 24, 0);
        $hourly_amounts = array_fill(0, 24, 0);
        
        // Başarılı ve başarısız sipariş sayıları
        $success_count = 0;
        $failed_count = 0;
        
        // Son 7 günlük veriler
        $weekly_data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $weekly_data[$date] = [
                'count' => 0,
                'amount' => 0
            ];
        }
        
        foreach ($daily_orders as $order_item) {
            $status_data[$order_item['order_status']]['count']++;
            $total_amount += $order_item['grand_total_try'];
            
            // Saatlik dağılım için
            $hour = date('G', strtotime($order_item['created_at']));
            $hourly_orders[$hour]++;
            $hourly_amounts[$hour] += $order_item['grand_total_try'];
            
            // Başarılı/Başarısız sayıları
            if (in_array($order_item['order_status'], ['success', 'sevk_edildi', 'kargolandi'])) {
                $success_count++;
            } elseif (in_array($order_item['order_status'], ['failed', 'stokta_yok', 'teknik_hata', 'yetistirilemedi'])) {
                $failed_count++;
            }
        }

         // En çok satılan ürün ve kategori analizi
         $product_sales = [];
         $category_sales = [];
         
         // Sipariş detaylarını analiz et
         foreach ($daily_orders as $order_item) {
             $order_rows = $this->modelOrderRow->where('order_id', $order_item['order_id'])->findAll();
             
             foreach ($order_rows as $row) {
                 // Ürün satış sayılarını topla
                 $product_id = $row['stock_id'];
                 $product_name = $row['stock_title'];
                 if (!isset($product_sales[$product_id])) {
                     $product_sales[$product_id] = [
                         'name' => $product_name,
                         'count' => 0
                     ];
                 }
                 $product_sales[$product_id]['count'] += $row['stock_amount'];
                
             }
         }
 
         // En çok satılan ürünü bul
         $top_product = ['name' => '-', 'count' => 0];
         foreach ($product_sales as $product) {
             if ($product['count'] > $top_product['count']) {
                 $top_product = $product;
             }
         }
 
         // En çok satılan kategoriyi bul
   
        
        // Son 7 günlük siparişleri getir
       
        
        // Platform bazlı sipariş durumu analizi
        $platform_status = [
            'dopigo' => [
                'name' => 'Dopigo',
                'new' => 0,
                'pending' => 0,
                'success' => 0,
                'failed' => 0,
                'sevk_emri' => 0,
                'sevk_edildi' => 0,
                'stokta_yok' => 0,
                'teknik_hata' => 0,
                'kargolandi' => 0,
                'kargo_bekliyor' => 0,
                'yetistirilemedi' => 0
            ],
            'b2b' => [
                'name' => 'B2B',
                'new' => 0,
                'pending' => 0,
                'success' => 0,
                'failed' => 0,
                'sevk_emri' => 0,
                'sevk_edildi' => 0,
                'stokta_yok' => 0,
                'teknik_hata' => 0,
                'kargolandi' => 0,
                'kargo_bekliyor' => 0,
                'yetistirilemedi' => 0
            ],
            'mshapp' => [
                'name' => 'MSH App',
                'new' => 0,
                'pending' => 0,
                'success' => 0,
                'failed' => 0,
                'sevk_emri' => 0,
                'sevk_edildi' => 0,
                'stokta_yok' => 0,
                'teknik_hata' => 0,
                'kargolandi' => 0,
                'kargo_bekliyor' => 0,
                'yetistirilemedi' => 0
            ]
        ];

        foreach ($daily_orders as $order_item) {
            // ... existing code ...
            
            // Platform bazlı analiz
            if (!empty($order_item['dopigo'])) {
                $platform_status['dopigo'][$order_item['order_status']]++;
            } elseif (!empty($order_item['b2b'])) {
                $platform_status['b2b'][$order_item['order_status']]++;
            } elseif (!empty($order_item['msh_order_id'])) {
                $platform_status['mshapp'][$order_item['order_status']]++;
            }
        }

      
     
        // Service bazlı sipariş durumu analizi için önce tüm servisleri bulalım
      
            
                 

        // Eğer hiç servis bulunamazsa varsayılan servisleri ekleyelim
        if (empty($services)) {
            $services = [
                ['service' => 'n11'],
                ['service' => 'trendyol'],
                ['service' => 'ciceksepeti'],
                ['service' => 'pazarama'],
                ['service' => 'hepsiburada']
            ];
        }

        $service_status = [];
        foreach ($services as $service) {
            if (!empty($service['service'])) {
                $service_status[$service['service']] = [
                    'name' => $service['service'],
                    'sevk_edildi' => 0,
                    'sevk_edildi_amount' => 0,
                    'kargo_bekliyor' => 0,
                    'kargo_bekliyor_amount' => 0,
                    'failed' => 0,
                    'failed_amount' => 0,
                    'sevk_emri' => 0,
                    'sevk_emri_amount' => 0
                ];
            }
        }

        // Siparişleri servislere göre analiz et
        foreach ($daily_orders as $order_item) {
            if (!empty($order_item['service_name'])) {
                $service_name = $order_item['service_name'];
                if (isset($service_status[$service_name])) {
                    $status = $order_item['order_status'];
                    $amount = floatval($order_item['grand_total_try'] ?? 0);
                    
                    switch($status) {
                        case 'sevk_edildi':
                            $service_status[$service_name]['sevk_edildi']++;
                            $service_status[$service_name]['sevk_edildi_amount'] += $amount;
                            break;
                        case 'kargo_bekliyor':
                            $service_status[$service_name]['kargo_bekliyor']++;
                            $service_status[$service_name]['kargo_bekliyor_amount'] += $amount;
                            break;
                        case 'failed':
                            $service_status[$service_name]['failed']++;
                            $service_status[$service_name]['failed_amount'] += $amount;
                            break;
                        case 'sevk_emri':
                            $service_status[$service_name]['sevk_emri']++;
                            $service_status[$service_name]['sevk_emri_amount'] += $amount;
                            break;
                    }
                }
            }
        }

     
      
        $data = [
            'daily_orders' => $daily_orders,
            'status_data' => $status_data,
            'total_orders' => $total_orders,
            'total_amount' => $total_amount,
            'hourly_orders' => $hourly_orders,
            'hourly_amounts' => $hourly_amounts,
            'success_count' => $success_count,
            'failed_count' => $failed_count,
            'weekly_data' => $weekly_data,
            'top_product' => $top_product,
            'top_category' => 0,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'service_status' => $service_status // platform_status yerine service_status kullanıyoruz
        ];
        
        // YENİ SAATLİK ANALİZ KODU - MEVCUT KODU BOZMADAN EKLENDİ
        $orderModel = $this->modelOrder;
        $hourly_analysis = $orderModel->select('order_date, grand_total_try')
                               ->where('order_date >=', $start_date)
                               ->where('order_date <=', $end_date)
                               ->findAll();

        $data['hourly_orders_new'] = array_fill(0, 24, 0);
        $data['hourly_amounts_new'] = array_fill(0, 24, 0);

        foreach ($hourly_analysis as $order_item) {
            if (!empty($order_item['order_date'])) {
                $hour = (int)date('H', strtotime($order_item['order_date']));
                $data['hourly_orders_new'][$hour]++;
                $data['hourly_amounts_new'][$hour] += floatval($order_item['grand_total_try']);
            }
        }

     

        return view('tportal/siparisler/gunlukrapor', $data);
    }










    public function DopigoKargo()
    {
        // Kargo firmaları verisini bir dizi olarak tanımla
        $cargoCompanies = [
           ["name" => "Carrtell"],
           ["name" => "Aras"],
           ["name" => "Yurtiçi"],
           ["name" => "Kargokar"],
           ["name" => "Sürat"],
           ["name" => "Elden Teslim"],
           ["name" => "Jetizz"],
           ["name" => "MNG Kargo"],
           ["name" => "Murathan JET"],
           ["name" => "PackUpp"],
           ["name" => "Navlungo"],
           ["name" => "Kargoray"],
           ["name" => "Asil Kargo"],
           ["name" => "Paket Taxi"],
           ["name" => "PTS"],
           ["name" => "SBY Express"],
           ["name" => "SkyNET"],
           ["name" => "Ulak Kurye"],
           ["name" => "Gittigidiyor Express"],
           ["name" => "Traffic Kurye"],
           ["name" => "Teknosa"],
           ["name" => "We World Express"],
           ["name" => "Ay Kargo"],
           ["name" => "Borusan Lojistik"],
           ["name" => "İstanbul Kurye"],
           ["name" => "Banabikurye"],
           ["name" => "Netkargo"],
           ["name" => "Kargoist"],
           ["name" => "KARGOMsende"],
           ["name" => "Vestel Regal Türkiye Servisi"],
           ["name" => "Scotty"],
           ["name" => "Oplog"],
           ["name" => "Kredilikargo_glvr"],
           ["name" => "hepsiJet"],
           ["name" => "Hepsijet"],
           ["name" => "ADEL"],
           ["name" => "B2C Direct"],
           ["name" => "hepsiJET"],
           ["name" => "hepsiJET XL"],
           ["name" => "PTT Kargo"],
           ["name" => "PTT Kargo Marketplace"],
           ["name" => "PTT Global"],
           ["name" => "UPS"],
           ["name" => "UPSGLOBAL"],
           ["name" => "Kolay Gelsin"],
           ["name" => "AGT"],
           ["name" => "ByExpress"],
           ["name" => "CDEK"],
           ["name" => "Horoz Lojistik"],
           ["name" => "Ceva Lojistik"],
           ["name" => "DHL"],
           ["name" => "Sendeo"],
           ["name" => "Trendyol Express"],
           ["name" => "Bir Günde Kargo"],
           
       ];
       
        return $cargoCompanies;
    }

    /**
     * Cari arama fonksiyonu
     */
    public function searchCariler()
    {
        $search = $this->request->getPost('search');
        
        if (empty($search) || strlen($search) < 3) {
            echo json_encode([
                'success' => false,
                'message' => 'Arama terimi en az 3 karakter olmalıdır.',
                'data' => []
            ]);
            return;
        }

        try {
            // Cari arama sorgusu
            $cariler = $this->modelCari
                ->select('cari_id, invoice_title, name, surname, cari_phone, identification_number, cari_balance')
                ->where('user_id', session()->get('user_id'))
                ->where('deleted_at IS NULL')
                ->groupStart()
                    ->like('invoice_title', $search)
                    ->orLike('name', $search)
                    ->orLike('surname', $search)
                    ->orLike('cari_phone', $search)
                    ->orLike('identification_number', $search)
                ->groupEnd()
                ->limit(20)
                ->findAll();

            echo json_encode([
                'success' => true,
                'message' => 'Cariler başarıyla getirildi.',
                'data' => $cariler
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Cari arama sırasında bir hata oluştu: ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }

    /**
     * Seçilen cari detaylarını getir
     */
    public function getCariDetails()
    {
        $cari_id = $this->request->getPost('cari_id');
        
        if (empty($cari_id)) {
            echo json_encode([
                'success' => false,
                'message' => 'Cari ID gerekli.',
                'data' => null
            ]);
            return;
        }

        try {
            // Cari bilgilerini getir
            $cari = $this->modelCari
                ->select('cari.*, address.address')
                ->join('address', 'address.cari_id = cari.cari_id AND address.default = "true"', 'left')
                ->where('cari.cari_id', $cari_id)
                ->where('cari.user_id', session()->get('user_id'))
                ->where('cari.deleted_at IS NULL')
                ->first();

            if (!$cari) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Cari bulunamadı.',
                    'data' => null
                ]);
                return;
            }

            echo json_encode([
                'success' => true,
                'message' => 'Cari bilgileri başarıyla getirildi.',
                'data' => $cari
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Cari bilgileri alınırken bir hata oluştu: ' . $e->getMessage(),
                'data' => null
            ]);
        }
    }

    /**
     * Sipariş cari bilgilerini güncelle
     */
    public function updateOrderCari()
    {
        $order_id = $this->request->getPost('order_id');
        $new_cari_id = $this->request->getPost('new_cari_id');
        
        if (empty($order_id) || empty($new_cari_id)) {
            echo json_encode([
                'success' => false,
                'message' => 'Sipariş ID ve yeni cari ID gerekli.'
            ]);
            return;
        }

        try {
            // Siparişi kontrol et
            $order = $this->modelOrder
                ->where('order_id', $order_id)
                ->where('user_id', session()->get('user_id'))
                ->first();

            if (!$order) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Sipariş bulunamadı.'
                ]);
                return;
            }

            // Yeni cari bilgilerini getir
            $new_cari = $this->modelCari
                ->where('cari_id', $new_cari_id)
                ->where('user_id', session()->get('user_id'))
                ->where('deleted_at IS NULL')
                ->first();

            if (!$new_cari) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Yeni cari bulunamadı.'
                ]);
                return;
            }

            // Eski cari bilgilerini sakla (log için)
            $old_cari_id = $order['cari_id'];
            $old_cari_name = $order['cari_invoice_title'];

            // Sipariş cari bilgilerini güncelle
            $update_data = [
                'cari_id' => $new_cari['cari_id'],
                'cari_identification_number' => $new_cari['identification_number'],
                'cari_tax_administration' => $new_cari['tax_administration'],
                'cari_invoice_title' => $new_cari['invoice_title'] ?: ($new_cari['name'] . ' ' . $new_cari['surname']),
                'cari_name' => $new_cari['name'],
                'cari_surname' => $new_cari['surname'],
                'cari_obligation' => $new_cari['obligation'],
                'cari_company_type' => $new_cari['company_type'],
                'cari_phone' => $new_cari['cari_phone'],
                'cari_email' => $new_cari['cari_email']
            ];

            $this->modelOrder->update($order_id, $update_data);

            // Log kaydı oluştur
            $this->modelIslem->LogOlustur(
                session()->get('client_id'),
                session()->get('user_id'),
                $order_id,
                'ok',
                'cari_degistir',
                "Sipariş cari bilgileri değiştirildi",
                session()->get("user_item")["user_adsoyad"],
                json_encode([
                    'old_cari_id' => $old_cari_id,
                    'old_cari_name' => $old_cari_name,
                    'new_cari_id' => $new_cari['cari_id'],
                    'new_cari_name' => $new_cari['invoice_title'] ?: ($new_cari['name'] . ' ' . $new_cari['surname'])
                ]),
                0,
                $order_id,
                0,
                0
            );

            echo json_encode([
                'success' => true,
                'message' => 'Sipariş cari bilgileri başarıyla güncellendi.'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Sipariş cari bilgileri güncellenirken bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }









}







