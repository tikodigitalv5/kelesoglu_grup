<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;

use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoPortal\AppModel;
use CodeIgniter\I18n\Time;
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
use Predis\Cluster\Distributor\EmptyRingException;
use function PHPUnit\Framework\returnSelf;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\API\ResponseTrait;
use App\Models\TikoPortal\UserModel;
use App\Models\TikoERP\SysmondBarkodlar;
use DOMDocument;
use DOMXPath;
/**
 * @property IncomingRequest $request
 */


class Production extends BaseController
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
    private $modelProduction;

    private $modelProductionRow;

    private $modelProductionOperation;

    private $modelProductionOperationRow;

    private $logClass;

    private $modelOperation;

    private $modelStockOperation;
    
    private $modelProductionOperationRowModel;
    private $modelStockMovement;
    private $modelStockBarcode;

    private $modelInvoice;
    private $modelInvoiceRow;

    private $modelStockPackage;
    private $modelStockWarehouseQuantity;

    private $modelBox;
    private $modelBoxRow;
    private $modelStockRecipe;
    private $modelRecipeItem;
    private $modelIslem;

    private $UserModel;

    private $modelOperationUser;
    private $modelSysmondBarkodlar;

    public function __construct()
    {   
        date_default_timezone_set('Europe/Istanbul');

        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
        $this->modelFinancialMovement = model($TikoERPModelPath . '\FinancialMovementModel', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath . '\StockModel', true, $db_connection);
        $this->modelProduction = model($TikoERPModelPath . '\ProductionModel', true, $db_connection);
        $this->modelOrder = model($TikoERPModelPath . '\OrderModel', true, $db_connection);
        $this->modelOrderRow = model($TikoERPModelPath . '\OrderRowModel', true, $db_connection);
        $this->modelProductionRow = model($TikoERPModelPath . '\ProductionRowModel', true, $db_connection);
        $this->modelProductionOperation = model($TikoERPModelPath . '\ProductionOperationModel', true, $db_connection);
        $this->modelProductionOperationRow = model($TikoERPModelPath . '\ProductionOperationRowModel', true, $db_connection);
        $this->modelOperation = model($TikoERPModelPath . '\OperationModel', true, $db_connection);
        $this->modelStockOperation = model($TikoERPModelPath . '\StockOperationModel', true, $db_connection);
        $this->modelProductionOperationRowModel = model($TikoERPModelPath . '\ProductionOperationRowModel', true, $db_connection);
        $this->logClass = new Log();
        $this->modelStockMovement = model($TikoERPModelPath . '\StockMovementModel', true, $db_connection);
        $this->modelStockBarcode = model($TikoERPModelPath . '\StockBarcodeModel', true, $db_connection);
        $this->modelFinancialMovement = model($TikoERPModelPath . '\FinancialMovementModel', true, $db_connection);
        $this->modelInvoice = model($TikoERPModelPath . '\InvoiceModel', true, $db_connection);
        $this->modelInvoiceRow = model($TikoERPModelPath . '\InvoiceRowModel', true, $db_connection);
        $this->modelStockWarehouseQuantity = model($TikoERPModelPath . '\StockWarehouseQuantityModel', true, $db_connection);
        $this->modelStockPackage = model($TikoERPModelPath . '\StockPackageyModel', true, $db_connection);
        $this->modelBox = model($TikoERPModelPath . '\BoxModel', true, $db_connection);
        $this->modelBoxRow = model($TikoERPModelPath . '\BoxRowModel', true, $db_connection);

        $this->modelStockRecipe = model($TikoERPModelPath . '\StockRecipeModel', true, $db_connection);
        $this->modelRecipeItem = model($TikoERPModelPath . '\RecipeItemModel', true, $db_connection);
        $this->modelIslem = model($TikoERPModelPath . '\IslemLoglariModel', true, $db_connection);
        $this->UserModel = new UserModel();
        $this->modelOperationUser = model($TikoERPModelPath . '\OperationUser', true, $db_connection);
        $this->modelSysmondBarkodlar = model($TikoERPModelPath . '\SysmondBarkodlar', true, $db_connection);

        helper('date');
        helper('text');
        helper('Helpers\barcode_helper');
        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\stock_func_helper');

    }

    public function orderList($order_type = 'all')
    {

        // $order_items = $this->modelOrder->join('money_unit', 'money_unit.money_unit_id = order.money_unit_id')
        //     ->where('order.user_id', session()->get('user_id'))
        //     ->where('order_status', 'new')
        //     ->orWhere('order_status', 'pending')
        //     ->orderBy('order.order_date', 'DESC')
        //     ->findAll();


       /*  $builder = $this->modelOrder
            ->join('money_unit', 'money_unit.money_unit_id = order.money_unit_id')
            ->select('order.user_id,
                order_id,
                order_no,
                order.money_unit_id,
                order_date,
                order.amount_to_be_paid,
                order.cari_invoice_title,
                order.cari_name,
                order.cari_surname,
                order.cari_id,
                money_unit.money_icon')
            ->where('order.user_id', session()->get('user_id'))
            ->where('order.deleted_at IS NULL', null, false);

        if ($order_type == 'all') {
            $builder = $builder;
        } elseif ($order_type == 'closed') {
            $builder = $builder->where('order_status', 'failed')->orWhere('order_status', 'success')->findAll();
        } else {
            return redirect()->back();
        }
        
        

        return DataTable::of($builder)->filter(function ($builder, $request) {
        })
            ->setSearchableColumns(['order.cari_invoice_title'])
            ->toJson(true); */


            $builder = $this->modelOrder
    ->join('money_unit', 'money_unit.money_unit_id = order.money_unit_id')
    // modelProduction ile ilişki kuruyoruz
    ->join('production', 'production.order = order.order_id', 'left') // Left join yaparak production kaydının olup olmadığını kontrol ediyoruz
    ->select('order.user_id,
        order_id,
        order_no,
        order.money_unit_id,
        order_date,
        order.amount_to_be_paid,
        order.cari_invoice_title,
        order.cari_name,
        order.cari_surname,
        order.cari_id,
        money_unit.money_icon')
    ->where('order.user_id', session()->get('user_id'))
    ->where('order.deleted_at IS NULL', null, false)
    // production kaydı yoksa göster (NULL olanları seçiyoruz)
    ->where('production.order IS NULL', null, false);

if ($order_type == 'all') {
    $builder = $builder;
} elseif ($order_type == 'closed') {
    $builder = $builder->where('order_status', 'failed')
        ->orWhere('order_status', 'success');
} else {
    return redirect()->back();
}

// Datatable işlemi
return DataTable::of($builder)
    ->filter(function ($builder, $request) {
        // Filtreleme işlemleri burada yapılabilir
    })
    ->setSearchableColumns(['order.cari_invoice_title'])
    ->toJson(true);

    }


    public function getOrderDetail()
    {
        // print_r("geldi");
        // return;


        $data_order_id = $this->request->getPost('orderId');


        $order_rows = $this->modelOrderRow->join('unit', 'unit.unit_id = order_row.unit_id')
            ->join('order', 'order.order_id = order_row.order_id')
            ->join('stock', 'stock.stock_id = order_row.stock_id')
            ->where('order.order_id', $data_order_id)
            ->findAll();


        
        


        $html = "";
        $count = 0;

        
        $htmlProduction = '';
        foreach ($order_rows as $order_row) {




            $count++;
            $operation_amounts = [];

            $stock_operation = $this->modelStockOperation
                ->join('operation', 'operation.operation_id = stock_operation.operation_id')
                ->where("stock_operation.stock_id", $order_row["stock_id"])
                ->findAll();
            
            foreach ($stock_operation as $operation_stock) {
                $operations = $this->modelProductionOperation
                    ->where("operation_id", $operation_stock["operation_id"])
                    ->where("stock_id", $operation_stock["stock_id"])
                    ->findAll();
            
                // Her bir operasyon için miktarları hesapla
                foreach ($operations as $operation) {
                    $operation_id = $operation['operation_id'];
                    $status = $operation['status'];
                    $stock_amount = $operation['stock_amount'];
            
                    // İlgili operasyon türü için bekleyen ve işlemde olan miktarları güncelle
                    if (!isset($operation_amounts[$operation_id])) {
                        $operation_amounts[$operation_id] = [
                            'title' => $operation_stock['operation_title'],
                            'beklemede' => 0,
                            'islemde' => 0
                        ];
                    }
            
                    if ($status == "Beklemede") {
                        $operation_amounts[$operation_id]['beklemede'] += $stock_amount;
                    } elseif ($status == "İşlemde") {
                        $operation_amounts[$operation_id]['islemde'] += $stock_amount;
                    }
                }
                if (!isset($operation_amounts[$operation_stock["operation_id"]])) {
                    $operation_amounts[$operation_stock["operation_id"]] = [
                        'title' => $operation_stock['operation_title'],
                        'beklemede' => 0,
                        'islemde' => 0
                    ];
                }
            }
            
            $saylazer = 0;
            
            foreach ($operation_amounts as $operation_id => $amounts) {
                if ($amounts['islemde']) {
                    $saylazer += floatval($amounts['islemde']);
                } else {
                    $saylazer += 0;
                }
            }
            
            // Saylazer'ı formatlayıp çıktı almak isterseniz
            $formatted_saylazer = number_format($saylazer, 2, ',', '.');
            $uretimler = '';

                // UrunVarmiBak sorgusu
            $urunVarmiBak = $this->modelProduction->where('deleted_at IS NULL', null, false)->findAll();
            $uretimler = []; // Benzersiz üretim numaralarını toplamak için dizi kullanıyoruz
$uretimlerString= '';
            if ($urunVarmiBak) {
                foreach ($urunVarmiBak as $varmi) {
                    $uretimSatirlar = $this->modelProductionOperation->where("production_id", $varmi["production_id"])->findAll();

                    if ($uretimSatirlar) {
                        foreach($uretimSatirlar as $satir) {
                            if ($satir["stock_id"] == $order_row["stock_id"]) {
                                // Üretim numarasını diziye ekliyoruz, böylece tekrarlananları engelliyoruz
                                if (!in_array($satir["production_number"], $uretimler)) {
                                    $uretimler[] = $satir["production_number"];
                                }
                            }
                        }
                    }
                }

                // Dizi elemanlarını birleştirip virgülle ayırarak stringe dönüştürüyoruz
                $uretimlerString = implode(' , ', $uretimler);

                // $uretimlerString ile bir şeyler yapılabilir, örneğin ekrana yazdırmak gibi
            
            }



        

$html .= "<tr disabled style='line-height: 43px;border: 1px solid #d3d3d3;opacity: 0.7;'
    data-stock_title='".$order_row['stock_title']."' 
    data-stock_amount='".$order_row['stock_amount']."' 
    data-stock_total='".$order_row['stock_total_quantity']."' 
    data-stocks_id='".$order_row["stock_id"]."'
>
    <td class='text-right'> " . $count . " </td>
    <td class='text-right'> " . $order_row['stock_title'] . " <br> <b>$uretimlerString</b>  </td>
    <td class='text-center busayi_stok'> " . number_format($order_row['stock_amount'], 2, ',','.') . " " . $order_row['unit_title'] . " </td>
    <td class='text-right'> " . number_format($order_row['stock_total_quantity'], 2, ',','.') . " " . $order_row['unit_title'] . " </td>
    <td class='text-center'> <b>".$formatted_saylazer."</b> Adet </td>
    <td class='text-center'>  <span class='badge bg-success'>YENİ</span>  </td>
    <td class='text-right'> <input 
    
    data-min='".convert_number_for_form($order_row['stock_amount'], 2)."' 
    data-max='".convert_number_for_form($order_row['stock_amount'], 2)."' 
    
    type='text' min='1' max='" . $order_row['stock_amount'] . "' class='form-control form-control-lg girilen_miktar text-end' id='girilen_miktar' name='girilen_miktar' required value='".convert_number_for_form($order_row['stock_amount'], 2)."'></td>
</tr>";

        }


        // print_r($order_rows);
        // return $order_rows;

        echo json_encode(['icon' => 'success', 'message' => 'Sipariş detayları başarıyla getirildi.', 'data' => $html, 'data2' => $order_rows]);
        return;
    }

    public function sureHesapla($start_date, $end_date) {
        $date_format = 'd/m/Y H:i:s';
        
        // DateTime nesnelerini oluşturun
        $start_date_obj = \DateTime::createFromFormat($date_format, $start_date);
        $end_date_obj = \DateTime::createFromFormat($date_format, $end_date);
        
        // İki tarih arasındaki farkı hesaplayın
        $interval = $start_date_obj->diff($end_date_obj);
    
        // Toplam saniye cinsinden farkı hesaplayın
        $total_seconds = ($interval->days * 24 * 60 * 60) + 
                         ($interval->h * 60 * 60) + 
                         ($interval->i * 60) + 
                         $interval->s;
    
        // Farkı gün, saat, dakika ve saniye cinsinden hesaplayın
        $days = $interval->days;
        $hours = $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;
    
        // Sonucu formatlayın
        $result = '';
    
        if ($days != 0) {
            $result .= $days . " gün ";
        }
    
        if ($hours != 0) {
            $result .= $hours . " saat ";
        }
    
        if ($minutes != 0) {
            $result .= $minutes . " dakika ";
        }
    
        $result .= $seconds . " saniye";
    
        return $result;
    }

    public function list($order_status = 'all')
    {
       

            $production_model = $this->modelProduction->join('production_row', 'production_row.production_id = production.production_id')
            ->select(' production.*, production_row.*, SUM(production_row.stock_amount) as total_stock_amount')
            ->groupBy('production.production_id, production_row.stock_id')
            ->where('production.user_id', session()->get('user_id'))
            ->orderBy('production.created_at', 'DESC');
  
   
            $order_items = $production_model->where('production.deleted_at IS NULL', null, false)->findAll();

        


            $page_title = "Üretim Tablosu";

            $toplambeklemede = $this->modelProductionOperation
            ->select('stock_id, production_id, status')
            ->orderBy('updated_at', 'DESC')
            ->groupBy("stock_id, production_id")
            ->where('status', 'Beklemede')
            ->where('deleted_at IS NULL', null, false)
            ->countAllResults() ?? 0;
        
        $toplamdevameden = $this->modelProductionOperation
            ->select('stock_id, production_id, status')
            ->orderBy('updated_at', 'DESC')
            ->groupBy("stock_id, production_id")
            ->where('status', 'İşlemde')
            ->where('deleted_at IS NULL', null, false)
            ->countAllResults() ?? 0;
        
        $toplamduraklatilan = $this->modelProductionOperation
            ->select('stock_id, production_id, status')
            ->orderBy('updated_at', 'DESC')
            ->groupBy("stock_id, production_id")
            ->where('status', 'Durdu')
            ->where('deleted_at IS NULL', null, false)
            ->countAllResults() ?? 0;
           
        
        $toplambiten = $this->modelProductionOperation
            ->select('stock_id, production_id, status')
            ->orderBy('updated_at', 'DESC')
            ->groupBy("stock_id, production_id")
            ->where('status', 'Bitti')
            ->where('deleted_at IS NULL', null, false)
            ->countAllResults() ?? 0;
        

    
            
    
            $data = [
                'toplambeklemede' => $toplambeklemede,
                'toplamdevameden' => $toplamdevameden,
                'toplamduraklatilan' => $toplamduraklatilan,
                'toplambiten' => $toplambiten,
            'page_title' => $page_title,
            'order_items' => $order_items,
            'order_items_count' => count($order_items),
        ];


        

        return view('tportal/uretim/index', $data);
    }


    public function openlist()
    {

       
            $production_model = $this->modelProduction->join('production_row', 'production_row.production_id = production.production_id')
            ->select(' production.*, production_row.*, SUM(production_row.stock_amount) as total_stock_amount')
            ->groupBy('production.production_id, production_row.stock_id')
            ->where('production.user_id', session()->get('user_id'))
            ->orderBy('production.created_at', 'DESC');
  
   
            $page_title = "Üretimdekiler";
            $order_items = $production_model->where('production.deleted_at IS NULL', null, false)->where('production_status', 'new')->orWhere('production_status', 'pending')->findAll();

            $totalStok = "";

   



            $toplambeklemede = $this->modelProductionOperation
            ->select('stock_id, production_id, status')
            ->orderBy('updated_at', 'DESC')
            ->groupBy("stock_id, production_id")
            ->where('status', 'Beklemede')
            ->countAllResults() ?? 0;
        
        $toplamdevameden = $this->modelProductionOperation
            ->select('stock_id, production_id, status')
            ->orderBy('updated_at', 'DESC')
            ->groupBy("stock_id, production_id")
            ->where('status', 'İşlemde')
            ->countAllResults() ?? 0;
        
        $toplamduraklatilan = $this->modelProductionOperation
            ->select('stock_id, production_id, status')
            ->orderBy('updated_at', 'DESC')
            ->groupBy("stock_id, production_id")
            ->where('status', 'Durdu')
            ->countAllResults() ?? 0;
           
        
        $toplambiten = $this->modelProductionOperation
            ->select('stock_id, production_id, status')
            ->orderBy('updated_at', 'DESC')
            ->groupBy("stock_id, production_id")
            ->where('status', 'Bitti')
            ->countAllResults() ?? 0;
        

    
            
    
            $data = [
                'toplambeklemede' => $toplambeklemede,
                'toplamdevameden' => $toplamdevameden,
                'toplamduraklatilan' => $toplamduraklatilan,
                'toplambiten' => $toplambiten,
            'page_title' => $page_title,
            'order_items' => $order_items,
            'order_items_count' => count($order_items),
        ];

        return view('tportal/uretim/index', $data);
    }

    public function closelist()
    {



            $production_model = $this->modelProduction->join('production_row', 'production_row.production_id = production.production_id')
            ->select(' production.*, production_row.*, SUM(production_row.stock_amount) as total_stock_amount')
            ->groupBy('production.production_id, production_row.stock_id')
            ->where('production.user_id', session()->get('user_id'))
            ->orderBy('production.created_at', 'DESC');

   
            $page_title = "Üretilenler";
            $order_items = $production_model->where('production_status', 'failed')->orWhere('production_status', 'success')->findAll();




            $toplambeklemede = $this->modelProductionOperation
            ->select('stock_id, production_id, status')
            ->orderBy('updated_at', 'DESC')
            ->groupBy("stock_id, production_id")
            ->where('status', 'Beklemede')
            ->countAllResults() ?? 0;
        
        $toplamdevameden = $this->modelProductionOperation
            ->select('stock_id, production_id, status')
            ->orderBy('updated_at', 'DESC')
            ->groupBy("stock_id, production_id")
            ->where('status', 'İşlemde')
            ->countAllResults() ?? 0;
        
        $toplamduraklatilan = $this->modelProductionOperation
            ->select('stock_id, production_id, status')
            ->orderBy('updated_at', 'DESC')
            ->groupBy("stock_id, production_id")
            ->where('status', 'Durdu')
            ->countAllResults() ?? 0;
           
        
        $toplambiten = $this->modelProductionOperation
            ->select('stock_id, production_id, status')
            ->orderBy('updated_at', 'DESC')
            ->groupBy("stock_id, production_id")
            ->where('status', 'Bitti')
            ->countAllResults() ?? 0;
        

    
            
    
            $data = [
                'toplambeklemede' => $toplambeklemede,
                'toplamdevameden' => $toplamdevameden,
                'toplamduraklatilan' => $toplamduraklatilan,
                'toplambiten' => $toplambiten,
            'page_title' => $page_title,
            'order_items' => $order_items,
            'order_items_count' => count($order_items),
        ];

        return view('tportal/uretim/index', $data);
    }

    function dusurReceteStoklari($urun_stock_id, $uretim_miktari, $uretim_no) {
        // Ürünün reçetesini alıyoruz
        $recete = $this->modelStockRecipe->where('stock_id', $urun_stock_id)->first();
        
        if (!$recete) {
            return false;  // Reçete yoksa işlem yapmadan çıkıyoruz
        }
    
        // Reçetedeki bileşenleri alıyoruz
        $receteUrunleri = $this->modelRecipeItem->where('recipe_id', $recete["recipe_id"])->findAll();
    
        foreach ($receteUrunleri as $receteUrunu) {
            $bilesen_stock_id = $receteUrunu['stock_id'];  // Bileşenin stok ID'si
            $stock_item = $this->modelStock->where("stock_id", $bilesen_stock_id)->first();
            $kullanilacak_miktar = $receteUrunu['used_amount'] * floatval($uretim_miktari);  // Gerekli bileşen miktarı (sipariş miktarı ile çarpılır)
    
            // Bileşenin mevcut stok bilgilerini al
            $stokBilgisi = $this->modelStock->where('stock_id', $bilesen_stock_id)->first();
            
            if ($stokBilgisi) {
                $yeni_stok_miktari = $stokBilgisi['stock_total_quantity'] - $kullanilacak_miktar;

              
    
               

                $user_item_tedarik = session("user_item")["stock_uretim"];
                $user_item_depo = session("user_item")["depo_uretim"];

                $buy_unit_price = convert_number_for_sql($stock_item["sale_unit_price"]);

                $warehouse_id = $user_item_depo;
                $supplier_id =  $user_item_tedarik;
                // $stock_quantity = convert_number_for_sql($row['miktar']);
                $stock_quantity = $yeni_stok_miktari;
                $transaction_note = $uretim_no . " - Üretim Emiri Sonrası Stoktan Çıkış";
                $warehouse_address = "Depo";
                
                $buy_money_unit_id = 1;

             
                // print_r("burdasın");
                // exit();
                $currency_amount = 1;


                // tedarikçi varsa finansal hareket ve gelen fatura tipinde fatura oluşturuyoruz
                $financialMovement_id = 0;
                if ($supplier_id != 0) {


                    $supplier = $this->modelCari->join('address', 'cari.cari_id = address.cari_id', 'left')->where('cari.cari_id', $supplier_id)->where('cari.user_id', session()->get('user_id'))->first();

                    $stock_entry_prefix = "STKTDRK";

                    $stock_total = convert_number_uretim($stock_quantity) * $buy_unit_price;

                    [$transaction_direction, $amount_to_be_processed] = ['entry', $stock_total * -1];

                      // fatura kayıt oluşturuyoruz
                      $insert_invoice_data = [
                        'user_id' => session()->get('user_id'),
                        'money_unit_id' => $buy_money_unit_id,
                        'sale_type' => "quick",

                        'invoice_direction' => 'outgoing_invoice',
                        'invoice_date' => new Time('now', 'Turkey', 'en_US'),
                        'expiry_date' => new Time('now', 'Turkey', 'en_US'),
                        'currency_amount' => 1,

                        'stock_total' => $stock_quantity * $buy_unit_price,
                        'stock_total_try' => ($stock_quantity * $buy_unit_price) * floatval(str_replace(',', '.', $currency_amount)),
                        'sub_total' => $stock_quantity * $buy_unit_price,
                        'sub_total_try' => ($stock_quantity * $buy_unit_price) * floatval(str_replace(',', '.', $currency_amount)),
                        'grand_total' => $stock_quantity * $buy_unit_price,
                        'grand_total_try' => ($stock_quantity * $buy_unit_price) * floatval(str_replace(',', '.', $currency_amount)),
                        'amount_to_be_paid' => $stock_quantity * $buy_unit_price,
                        'amount_to_be_paid_try' => ($stock_quantity * $buy_unit_price) * floatval(str_replace(',', '.', $currency_amount)),

                        'cari_identification_number' => $supplier['identification_number'],
                        'cari_tax_administration' => $supplier['tax_administration'],

                        'cari_invoice_title' => $supplier['invoice_title'] == '' ? $supplier['name'] . " " . $supplier['surname'] : $supplier['invoice_title'],
                        'cari_name' => $supplier['name'],
                        'cari_surname' => $supplier['surname'],
                        'cari_obligation' => $supplier['obligation'],
                        'cari_company_type' => $supplier['company_type'],
                        'cari_phone' => $supplier['cari_phone'],
                        'cari_email' => $supplier['cari_email'],

                        'address_country' => $supplier['address_country'],
                        'address_city' => isset($supplier['address_city_name']) ? $supplier['address_city_name'] : "",
                        'address_city_plate' => isset($supplier['address_city']) ? $supplier['address_city'] : "",
                        'address_district' => isset($supplier['address_district']) ? $supplier['address_district'] : "",
                        'address_zip_code' => $supplier['zip_code'],
                        'address' => $supplier['address'],

                        'invoice_status_id' => "1",
                    ];

                    // print_r(str_replace(',', '.', $stock_quantity) * str_replace(',', '.', $buy_unit_price));
                    // print_r((str_replace(',', '.', $stock_quantity) * str_replace(',', '.', $buy_unit_price)) * str_replace(',', '.', $currency_amount));

                    $this->modelInvoice->insert($insert_invoice_data);
                    $invoice_id = $this->modelInvoice->getInsertID();

               

                    $currentDateTime = new Time('now', 'Turkey', 'en_US');
                    $currency_amount = str_replace(',', '.', $this->request->getPost('currency_amount')) ?? 1;
                    $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                    if ($last_transaction) {
                        $transaction_counter = $last_transaction['transaction_counter'] + 1;
                    } else {
                        $transaction_counter = 1;
                    }
                    $transaction_number = $stock_entry_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                    $insert_financial_movement_data = [
                        'user_id' => session()->get('user_id'),
                        'cari_id' => $supplier_id,
                        'money_unit_id' => $buy_money_unit_id,
                        'transaction_number' => $transaction_number,
                        'transaction_direction' => $transaction_direction,
                        'transaction_type' => 'outgoing_invoice',
                        'invoice_id' => $invoice_id,
                        'transaction_tool' => 'not_payroll',
                        'transaction_title' => "Üretim emiri sonrası stok çıkışından oluşan hareket",
                        'transaction_description' => "Üretim emiri sonrası stok çıkışından oluşan hareket",
                        'transaction_amount' => $kullanilacak_miktar,
                        'transaction_real_amount' => $kullanilacak_miktar,
                        'transaction_date' => $currentDateTime,
                        'transaction_prefix' => $stock_entry_prefix,
                        'transaction_counter' => $transaction_counter
                    ];
                    $this->modelFinancialMovement->insert($insert_financial_movement_data);
                    $financialMovement_id = $this->modelFinancialMovement->getInsertID();

                    $update_cari_data = [
                        'cari_balance' => $supplier['cari_balance'] + $amount_to_be_processed
                    ];
                    $this->modelCari->update($supplier['cari_id'], $update_cari_data);



                  

                    //cari harektlerinden ilgili hareket detayına gitmek için
                    $update_modelFinancialMovement_data = [
                        'invoice_id' => $invoice_id,
                    ];
                    $this->modelFinancialMovement->update($financialMovement_id, $update_modelFinancialMovement_data);


                  
                }else{
                    $supplier = 0;
                }
             
                
               

               
                $insert_StockWarehouseQuantity = [
                    'user_id' => session()->get('user_id'),
                    'warehouse_id' => $warehouse_id,
                    'stock_id' => $stock_item['stock_id'],
                    'parent_id' => $stock_item['parent_id'],
                    'stock_quantity' => $stock_quantity,
                ];

                 //print_r($insert_StockWarehouseQuantity);

                 if($stock_item['parent_id'] == 0){
                    $parentStok = $bilesen_stock_id;
                }else{
                    $parentStok  = $stock_item['parent_id'];
                }


                $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $warehouse_id, $stock_item['stock_id'], $parentStok, floatval($kullanilacak_miktar), 'remove', $this->modelStockWarehouseQuantity, $this->modelStock);
               


          

                $insert_invoice_row_data = [
                    'user_id' => session()->get('user_id'),
                    'invoice_id' => $invoice_id,
                    'stock_id' => $stock_item['stock_id'],
                    'stock_title' => $stock_item['stock_title'],
                    'stock_amount' => $kullanilacak_miktar,

                    'unit_id' => $stock_item['buy_unit_id'],
                    'unit_price' => $buy_unit_price,

                    'subtotal_price' => $stock_total,

                    'total_price' => $stock_total,
                ];
                $this->modelInvoiceRow->insert($insert_invoice_row_data);
                $invoice_row_id = $this->modelInvoiceRow->getInsertID();



                $last_stock_barcode_id = 0;
                $stock_barcode_all = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                    ->where('stock_barcode.stock_id', $stock_item['stock_id'])
                    ->where('stock_barcode.warehouse_id', $warehouse_id)
                    ->findAll();

                // stock_barcode'da used_amount günceller
                foreach ($stock_barcode_all as $stock_barcode_item) {

                    $varMi = $stock_barcode_item['total_amount'] - $stock_barcode_item['used_amount'];

                    if ($varMi >= $kullanilacak_miktar) {
                        $stock_movement_prefix = 'TRNSCTN';

                        $last_transaction = $this->modelStockMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                        if ($last_transaction) {
                            $transaction_counter = $last_transaction['transaction_counter'] + 1;
                        } else {
                            $transaction_counter = 1;
                        }
                        $transaction_prefix = "PRF";

                        $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                        $insert_stock_movement_data = [
                            'user_id' => session()->get('user_id'),
                            'stock_barcode_id' => $stock_barcode_item['stock_barcode_id'],
                            'invoice_id' => $invoice_id,
                            'movement_type' => 'outgoing',
                            'transaction_number' => $transaction_number,
                            'transaction_note' => null,
                            'from_warehouse' => $warehouse_id,
                            'transaction_info' => $transaction_note,
                            'sale_unit_price' => $stock_item['sale_unit_price'],
                            'sale_money_unit_id' => $stock_item['sale_money_unit_id'],
                            'transaction_quantity' => $kullanilacak_miktar,
                            'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                            'transaction_prefix' => $transaction_prefix,
                            'transaction_counter' => $transaction_counter,
                        ];
                        $this->modelStockMovement->insert($insert_stock_movement_data);
                        $stock_movement_id = $this->modelStockMovement->getInsertID();

                        $used_amount = $stock_barcode_item['used_amount'] + $kullanilacak_miktar;
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
               







                if ($yeni_stok_miktari < 0) {
                    // Burada stok eksikliği durumunda loglama yapabilirsiniz
                    // Stok eksikliği durumu
                    error_log("Stok yetersiz: " . $stokBilgisi['stock_title'] . " Ürün ID: " . $bilesen_stock_id);
                }
            }
        }
    
        return true;
    }

    public function stokHesapla($stock_id)
    {
       
           // İlk aşama: Sadece gelen stock_id'ye göre olan hareketleri hesapla
            $stock_item = $this->modelStock
            ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id', 'left') // Alış birimi
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id', 'left') // Satış birimi
            ->find($stock_id);

            if (!$stock_item) {

                echo json_encode(['icon' => 'error', 'message' => "<b>Geçerli bir ürün bulunamadı</b>"]);
                return;
            }
            if ($stock_item["parent_id"] == 0) {
                // Ana ürünse, tüm alt ürünleri alıyoruz
                $tumAltUrunler = $this->modelStock->where("parent_id", $stock_id)->findAll();
                
                $total_purchases = 0;
                $total_sales = 0;
                $total_remaining_stocks = 0; // Alt ürünlerin toplamını tutacağız
            
                // Alt ürünlerin her biri için stok hesaplama yapıyoruz
                foreach($tumAltUrunler as $urun) {
                    // Her alt ürüne ait stok hareketlerini al
                    $financial_movements = $this->modelStockMovement
                        ->join('stock_barcode', 'stock_barcode.stock_barcode_id = stock_movement.stock_barcode_id')
                        ->where('stock_movement.deleted_at', null)
                        ->where('stock_barcode.stock_id', $urun["stock_id"])
                        ->findAll();
            
                    // Alış ve satış toplamlarını hesaplama
                    $urun_total_purchases = 0; // Alt ürün için geçici alış
                    $urun_total_sales = 0; // Alt ürün için geçici satış
            
                    foreach ($financial_movements as $movement) {
                        if ($movement['movement_type'] === 'incoming') { // Alış işlemi
                            $urun_total_purchases += $movement['transaction_quantity'];
                        } elseif ($movement['movement_type'] === 'outgoing') { // Satış işlemi
                            $urun_total_sales += $movement['transaction_quantity'];
                        }
                    }
            
                    // Alt ürünün kalan stok miktarını hesapla
                    $urun_remaining_stock = $urun_total_purchases - $urun_total_sales;
            
                    // Alt ürüne kalan stoğu yaz
                    $this->modelStock->set("stock_total_quantity", $urun_remaining_stock)->where("stock_id", $urun["stock_id"])->update();
            
                    // Ana ürüne eklemek için tüm alt ürünlerin stok toplamlarını biriktiriyoruz
                    $total_purchases += $urun_total_purchases;
                    $total_sales += $urun_total_sales;
                    $total_remaining_stocks += $urun_remaining_stock;
                }
            
                // Şimdi ana ürünün stoğunu güncelleyeceğiz, tüm alt ürünlerin toplam stoklarına göre
                $this->modelStock->set("stock_total_quantity", $total_remaining_stocks)->where("stock_id", $stock_id)->update();
            
                // Sonuçları döndürelim
                $result = [
                    'icon' => 'success',
                    'stock_title' => $stock_item['stock_title'],
                    'buy_unit_name' => $stock_item['unit_title'], // Alış birimi
                    'sale_unit_name' => $stock_item['unit_title'], // Satış birimi
                    'total_purchase' => convert_number_for_form($total_purchases, 2),
                    'total_sales' => convert_number_for_form($total_sales, 2),
                    'remaining_stock' => convert_number_for_form($total_remaining_stocks, 2)
                ];
            
                
            }

            if ($stock_item["parent_id"] > 0) {
                // Ana ürünse, tüm alt ürünleri alıyoruz
                $tumAltUrunler = $this->modelStock->where("parent_id", $stock_item["parent_id"])->findAll();
                
                $total_purchasess = 0;
                $total_saless = 0;
                $total_remaining_stockss = 0; // Alt ürünlerin toplamını tutacağız
            
                // Alt ürünlerin her biri için stok hesaplama yapıyoruz
                foreach($tumAltUrunler as $urun) {
                    // Her alt ürüne ait stok hareketlerini al
                    $financial_movements = $this->modelStockMovement
                        ->join('stock_barcode', 'stock_barcode.stock_barcode_id = stock_movement.stock_barcode_id')
                        ->where('stock_movement.deleted_at', null)
                        ->where('stock_barcode.stock_id', $urun["stock_id"])
                        ->findAll();
            
                    // Alış ve satış toplamlarını hesaplama
                    $urun_total_purchasess = 0; // Alt ürün için geçici alış
                    $urun_total_saless = 0; // Alt ürün için geçici satış
            
                    foreach ($financial_movements as $movement) {
                        if ($movement['movement_type'] === 'incoming') { // Alış işlemi
                            $urun_total_purchasess += $movement['transaction_quantity'];
                        } elseif ($movement['movement_type'] === 'outgoing') { // Satış işlemi
                            $urun_total_saless += $movement['transaction_quantity'];
                        }
                    }
            
                    // Alt ürünün kalan stok miktarını hesapla
                    $urun_remaining_stock = $urun_total_purchasess - $urun_total_saless;
            
                    // Alt ürüne kalan stoğu yaz
                    $this->modelStock->set("stock_total_quantity", $urun_remaining_stock)->where("stock_id", $urun["stock_id"])->update();
            
                    // Ana ürüne eklemek için tüm alt ürünlerin stok toplamlarını biriktiriyoruz
                    $total_purchasess += $urun_total_purchasess;
                    $total_saless += $urun_total_saless;
                    $total_remaining_stockss += $urun_remaining_stock;
                }

      
            
                // Şimdi ana ürünün stoğunu güncelleyeceğiz, tüm alt ürünlerin toplam stoklarına göre
                $this->modelStock->set("stock_total_quantity", $total_remaining_stockss)->where("stock_id", $stock_item["parent_id"])->update();
            
               
            }


            

            // Bu ürüne ait stok hareketlerini alıyoruz
            $financial_movements = $this->modelStockMovement
            ->join('stock_barcode', 'stock_barcode.stock_barcode_id = stock_movement.stock_barcode_id')
            ->where('stock_movement.deleted_at', null)
            ->where('stock_barcode.stock_id', $stock_id)
            ->findAll();

            // Alış ve satış toplamlarını hesaplama
            $total_purchase = 0;
            $total_sales = 0;

            // Birim bilgilerini tutmak için değişkenler
            $buy_unit_name = $stock_item['unit_title'];  // Alış birimi
            $sale_unit_name = $stock_item['unit_title'];  // Satış birimi

            foreach ($financial_movements as $movement) {
            if ($movement['movement_type'] === 'incoming') { // Alış işlemi
                $total_purchase += $movement['transaction_quantity'];
            } elseif ($movement['movement_type'] === 'outgoing') { // Satış işlemi
                $total_sales += $movement['transaction_quantity'];
            }
            }

            // Kalan stok miktarını hesapla
            $remaining_stock = $total_purchase - $total_sales;

            // Gelen stock_id'ye göre verileri döndür
            $result = [
            'icon' => 'success',
            'stock_title' => $stock_item['stock_title'],
            'buy_unit_name' => $buy_unit_name, // Alış birimi
            'sale_unit_name' => $sale_unit_name, // Satış birimi
            'total_purchase' => convert_number_for_form($total_purchase, 2),
            'total_sales' => convert_number_for_form($total_sales, 2),
            'remaining_stock' => convert_number_for_form($remaining_stock, 2)
            ];

            if($result)
            {
                $stokGuncelle = $this->modelStock->set("stock_total_quantity", $remaining_stock)->where("stock_id", $stock_id)->update();
            }

           
        // İkinci aşama: Eğer parent_id'si varsa veya diğer alt ürünlere bakılması gerekiyorsa
        /* 
        
        if ($stock_item["parent_id"] != 0) {
            $parent_item = $this->modelStocks->find($stock_item["parent_id"]);
    
            if ($parent_item) {
                // Üst ürüne ait stok hareketlerini al
                $movements = $this->modelStockMovement
                    ->join('stock_barcode', 'stock_barcode.stock_barcode_id = stock_movement.stock_barcode_id')
                    ->where('stock_movement.deleted_at', null)
                    ->where('stock_barcode.stock_id', $parent_item["stock_id"])
                    ->findAll();
                
                // Üst ürüne ait hareketleri financial_movements dizisine ekle
                $financial_movements = array_merge($financial_movements, $movements);
    
                // Diğer alt ürünlerin hareketlerini al
                $other_siblings = $this->modelStocks->where("parent_id", $parent_item["stock_id"])->findAll();
                if ($other_siblings) {
                    foreach ($other_siblings as $sibling) {
                        $movements = $this->modelStockMovement
                            ->join('stock_barcode', 'stock_barcode.stock_barcode_id = stock_movement.stock_barcode_id')
                            ->where('stock_movement.deleted_at', null)
                            ->where('stock_barcode.stock_id', $sibling["stock_id"])
                            ->findAll();
    
                        $financial_movements = array_merge($financial_movements, $movements);
                    }
                }
    
                // Eğer ikinci aşama ile toplam hareketleri tekrar hesaplamak istiyorsanız, burada ikinci bir hesaplama yapabilirsiniz.
            }
        }
        
        */



        

    
    }

    public function uretimOlustur()
    {

      

        if($this->request->getPost('siparis_id')){
         

           $errorMessage = [];
           $validProducts = [];
           $validRecete = [];
           $kacurun = 0;
           $stokEksikUrunler = [];  // Eksik stokları tutacak dizi
           $maxUretilebilecekAdet = PHP_INT_MAX;  // Mevcut stoklarla üretilebilecek maksimum adet
           
           $totalCount = 0;
           $count = 0;
           
           $siparis  = $this->request->getPost('siparis_id');
           $shipment_note  = $this->request->getPost('shipment_note');
           $stock_adi = "";
           
           foreach ($this->request->getPost('rowsData') as $index => $row) {
               $stock_title = $row['stock_title'];
               $stock_amount = $row['stock_amount'];
               $stock_total = $row['stock_total'];
               $girilen_miktar = $row['girilen_miktar'];
               $stock_id = $row['stock_id'];
               $kacurun++;
           
               if ($girilen_miktar == 0 || empty($girilen_miktar)) {
                   continue;
               }
           
           
               $stokBilgileri = $this->modelStock->where('stock_id', $stock_id)->first();
               $urunOperasyonları = $this->modelStockOperation->where("stock_id", $stock_id)->orderBy("relation_order", "ASC")->findAll();
           
               if (!isset($urunOperasyonları) || empty($urunOperasyonları)) {
                   $errorMessage[] = [
                       'stok_title' => $stokBilgileri["stock_title"],
                       'error' =>  "<b>" . $stokBilgileri["stock_title"] . " </b> Ürün Operasyonu Yok"
                   ];
               } else {
                   $validProducts[] = $row;
               }
           
               // Reçeteyi ve reçetedeki bileşenleri alıyoruz
               $recete = $this->modelStockRecipe->where('stock_id', $stock_id)->first();
               if($recete)
                {
                    $receteUrunleri = $this->modelRecipeItem->where('recipe_id', $recete["recipe_id"])->findAll();
            
                    $maxUretilebilecekAdet = floatval($girilen_miktar);  // Maksimum üretilebilecek adet, sipariş miktarıyla başlatılır
                    $receteUrunleriWithStockTitle = [];
    
                    foreach ($receteUrunleri as $receteUrunu) {
                        $bilesen_stock_id = $receteUrunu['stock_id'];  // Reçetede kullanılan bileşenin stok ID'si
                        $siparisMiktari = floatval($girilen_miktar);  // Sipariş miktarını sayısal bir değere dönüştür
                    
                        $istenenMiktar = $receteUrunu['used_amount'] * $siparisMiktari;  // Gerekli bileşen miktarı
                    
                        // Bileşenin mevcut stok bilgilerini al
                        $stokBilgisi = $this->modelStock->where('stock_id', $bilesen_stock_id)->first();

                        if ($stokBilgisi && isset($stokBilgisi['stock_total_quantity'])) {
                    
                        // Eğer mevcut stok istenen miktardan azsa, eksik miktarı ve maksimum üretilebilecek miktarı hesapla
                        if ($stokBilgisi['stock_total_quantity'] < $istenenMiktar) {
                            $eksikMiktar = $istenenMiktar - $stokBilgisi['stock_total_quantity'];
                    
                            // Bu bileşen için mevcut stokla kaç adet üretilebileceğini hesapla
                            $bilesenIcinUretilebilecekAdet = floor($stokBilgisi['stock_total_quantity'] / $receteUrunu['used_amount']);
                    
                            // Mevcut stokla üretilebilecek maksimum adet, her bileşenin üretilebilecek en küçük miktarı ile güncellenir
                            $maxUretilebilecekAdet = min($maxUretilebilecekAdet, $bilesenIcinUretilebilecekAdet);
                    
                            // Eksik stok durumunu raporla
                            $stokEksikUrunler[] = [
                                'stock_id' => $stokBilgisi['stock_id'],
                                'stock_title' => $stokBilgisi['stock_title'],
                                'istenen_miktar' => $istenenMiktar,
                                'mevcut_stok' =>convert_number_for_form($stokBilgisi['stock_total_quantity'], 2),
                                'eksik_miktar' => $eksikMiktar,
                                'uret_ilebilecek_adet' => $bilesenIcinUretilebilecekAdet
                            ];
                        }
                         // Stok bilgisiyle birlikte her bileşeni yeni bir diziye ekliyoruz
                         $receteUrunleriWithStockTitle[] = array_merge($receteUrunu, [
                            'stock_title' => $stokBilgisi['stock_title']
                        ]);
                    }
                           
                    }
               }
           }



// Eğer eksik stoklar varsa ekranda gösterelim
if(session()->get('user_item')['user_id'] != 4 &&  session()->get('user_item')['user_id'] != 1){
    if (!empty($stokEksikUrunler)) {
        echo json_encode([
            'icon' => 'esik_stok',
            'message' => '<b>Yetersiz stoklar var, ancak mevcut stok reçetesiyle maksimum ' . $maxUretilebilecekAdet . ' adet üretilebilir.</b>',
            'eksik_urunler' => $stokEksikUrunler
        ]);
        return;
    } 
}



if (empty($validProducts)) {
    $errorMessage[] = [
        'error' => "<br> Siparişteki ürünlerin operasyonları olmadığı için <br> Üretim emiri oluşturulamadı."
];
 
    echo json_encode(['icon' => 'danger', 'message' => $errorMessage]);
    exit;
}






    $urunOperasyonlari = [];

    // Operasyonları benzersiz tutmak için geçici bir dizi
    $tempOperasyonlar = [];

    // Gelen veriler üzerinde işlem yap
    foreach ($this->request->getPost('rowsData') as $row) {
        $stock_title = $row['stock_title'];
        $stock_id = $row['stock_id'];
        $girilen_miktar = $row['girilen_miktar'];

        // Girilen miktar sıfırsa işlemi atla
        if ($girilen_miktar == 0 || empty($girilen_miktar)) {
            continue;
        }

        // Stok operasyonlarını al
        $operasyonBul = $this->modelStockOperation->where("stock_id", $stock_id)->findAll();

        if (!empty($operasyonBul)) {
            foreach ($operasyonBul as $operasyon) {
                // Operasyon detaylarını getir
                $Operasyon = $this->modelOperation->where("operation_id", $operasyon["operation_id"])->first();

                if ($Operasyon) {
                    $operation_key = $Operasyon['operation_id']; // Operasyonu benzersiz tanımlamak için ID

                    // Eğer bu operasyon daha önce eklenmediyse
                    if (!isset($tempOperasyonlar[$operation_key])) {
                        $tempOperasyonlar[$operation_key] = [
                            'operation_id' => $Operasyon['operation_id'],
                            'operation_title' => $Operasyon['operation_title'],
                            'related_products' => [] // İlgili ürünler listesi
                        ];
                    }

                    // Operasyona bağlı ürün bilgisini ekle
                    $tempOperasyonlar[$operation_key]['related_products'][] = [
                        'stock_title' => $stock_title,
                        'stock_id' => $stock_id,
                        'girilen_miktar' => $girilen_miktar
                    ];
                }
            }
        }
    }

    // Operasyonları temizle ve düzenle
    $urunOperasyonlari = array_values($tempOperasyonlar);

    // Kullanıcıları getir
    $kullanicilar = $this->UserModel
        ->where("operation !=", 0)
        ->where("user_id", session()->get('user_item')['user_id'])
        ->findAll();

    // Kullanıcıları gruplandır
    $secilenKullanicilar = [];
    $secimKutusuKullanicilar = [];

    foreach ($kullanicilar as $kullanici) {
        $kullaniciId = $kullanici['client_id'];
        $operatinuserID = $kullanici['operation'];
        $kullaniciAdi = $kullanici['user_adsoyad'];
        $operationTitle = null;

        // Kullanıcı operasyonunu kontrol et
        foreach ($urunOperasyonlari as $operasyon) {
            if ($operasyon['operation_id'] == $kullanici['operation']) {
                $operationTitle = $operasyon['operation_title'];
                break;
            }
        }

        // Kullanıcıyı uygun gruba ekle
        if ($operationTitle) {
            $secilenKullanicilar[] = [
                'client_id' => $kullaniciId,
                'user_operation_id' => $operatinuserID,
                'username' => $kullaniciAdi,
                'operation_title' => $operationTitle,
            ];
        } else {
            $opBilgiler = $this->modelOperation->where("operation_id", $operatinuserID)->first();
            $secimKutusuKullanicilar[] = [
                'client_id' => $kullaniciId,
                'user_operation_id' => $operatinuserID,
                'username' => $kullaniciAdi,
                'operation_title' => $opBilgiler["operation_title"],
            ];
        }
    }

    // JSON formatında döndür
    echo json_encode([
        'message' => "Operasyon Kullanıcıları Başarıyla Getirildi",
        'status' => 'uretimkullanici',
        'selected_users' => $secilenKullanicilar,
        'available_users' => $secimKutusuKullanicilar,
        'operations' => $urunOperasyonlari, // Gruplandırılmış operasyonlar ve ilgili ürünler
    ]);


        }
    }


    /*
    
    public function create()
    {




      

        if($this->request->getPost('siparis_id')){
            
          
           $errorMessage = [];
           $validProducts = [];
           $validRecete = [];
           $kacurun = 0;
           $stokEksikUrunler = [];  // Eksik stokları tutacak dizi
           $maxUretilebilecekAdet = PHP_INT_MAX;  // Mevcut stoklarla üretilebilecek maksimum adet
           
           $totalCount = 0;
           $count = 0;
           
           $siparis  = $this->request->getPost('siparis_id');
           $shipment_note  = $this->request->getPost('shipment_note');
           $stock_adi = "";
           
           foreach ($this->request->getPost('rowsData') as $index => $row) {
               $stock_title = $row['stock_title'];
               $stock_amount = $row['stock_amount'];
               $stock_total = $row['stock_total'];
               $girilen_miktar = $row['girilen_miktar'];
               $stock_id = $row['stock_id'];
               $kacurun++;
           
               if ($girilen_miktar == 0 || empty($girilen_miktar)) {
                continue;
            }
           
           
               $stokBilgileri = $this->modelStock->where('stock_id', $stock_id)->first();
               $urunOperasyonları = $this->modelStockOperation->where("stock_id", $stock_id)->orderBy("relation_order", "ASC")->findAll();
           
               if (!isset($urunOperasyonları) || empty($urunOperasyonları)) {
                   $errorMessage[] = [
                       'stok_title' => $stokBilgileri["stock_title"],
                       'error' =>  "<b>" . $stokBilgileri["stock_title"] . " </b> Ürün Operasyonu Yok"
                   ];
               } else {
                   $validProducts[] = $row;
               }
           
               // Reçeteyi ve reçetedeki bileşenleri alıyoruz
               $recete = $this->modelStockRecipe->where('stock_id', $stock_id)->first();
               if($recete)
                {
                    $receteUrunleri = $this->modelRecipeItem->where('recipe_id', $recete["recipe_id"])->findAll();
            
                    $maxUretilebilecekAdet = floatval($girilen_miktar);  // Maksimum üretilebilecek adet, sipariş miktarıyla başlatılır
                    $receteUrunleriWithStockTitle = [];
    
                    foreach ($receteUrunleri as $receteUrunu) {
                        $bilesen_stock_id = $receteUrunu['stock_id'];  // Reçetede kullanılan bileşenin stok ID'si
                        $siparisMiktari = floatval($girilen_miktar);  // Sipariş miktarını sayısal bir değere dönüştür
                    
                        $istenenMiktar = $receteUrunu['used_amount'] * $siparisMiktari;  // Gerekli bileşen miktarı
                    
                        // Bileşenin mevcut stok bilgilerini al
                        $stokBilgisi = $this->modelStock->where('stock_id', $bilesen_stock_id)->first();

                        if ($stokBilgisi && isset($stokBilgisi['stock_total_quantity'])) {
                    
                        // Eğer mevcut stok istenen miktardan azsa, eksik miktarı ve maksimum üretilebilecek miktarı hesapla
                        if ($stokBilgisi['stock_total_quantity'] < $istenenMiktar) {
                            $eksikMiktar = $istenenMiktar - $stokBilgisi['stock_total_quantity'];
                    
                            // Bu bileşen için mevcut stokla kaç adet üretilebileceğini hesapla
                            $bilesenIcinUretilebilecekAdet = floor($stokBilgisi['stock_total_quantity'] / $receteUrunu['used_amount']);
                    
                            // Mevcut stokla üretilebilecek maksimum adet, her bileşenin üretilebilecek en küçük miktarı ile güncellenir
                            $maxUretilebilecekAdet = min($maxUretilebilecekAdet, $bilesenIcinUretilebilecekAdet);
                    
                            // Eksik stok durumunu raporla
                            $stokEksikUrunler[] = [
                                'stock_id' => $stokBilgisi['stock_id'],
                                'stock_title' => $stokBilgisi['stock_title'],
                                'istenen_miktar' => $istenenMiktar,
                                'mevcut_stok' =>convert_number_for_form($stokBilgisi['stock_total_quantity'], 2),
                                'eksik_miktar' => $eksikMiktar,
                                'uret_ilebilecek_adet' => $bilesenIcinUretilebilecekAdet
                            ];
                        }
                         // Stok bilgisiyle birlikte her bileşeni yeni bir diziye ekliyoruz
                         $receteUrunleriWithStockTitle[] = array_merge($receteUrunu, [
                            'stock_title' => $stokBilgisi['stock_title']
                        ]);
                    }
                           
                    }
               }
           }



// Eğer eksik stoklar varsa ekranda gösterelim
if(session()->get('user_item')['user_id'] != 4 &&  session()->get('user_item')['user_id'] != 1){
    if (!empty($stokEksikUrunler)) {
        echo json_encode([
            'icon' => 'esik_stok',
            'message' => '<b>Yetersiz stoklar var, ancak mevcut stok reçetesiyle maksimum ' . $maxUretilebilecekAdet . ' adet üretilebilir.</b>',
            'eksik_urunler' => $stokEksikUrunler
        ]);
        return;
    } 
}



if (empty($validProducts)) {
    $errorMessage[] = [
        'error' => "<br> Siparişteki ürünlerin operasyonları olmadığı için <br> Üretim emiri oluşturulamadı."
];
 
    echo json_encode(['icon' => 'danger', 'message' => $errorMessage]);
    exit;
}







$siparisSrogula = $this->modelProduction->where("order", $siparis)->first();

if($siparisSrogula){
    $errorMessage[] = [
        'error' => "<br> Seçilen sipariş ile ilgili daha önce bir emir oluşturuldu. <b> " . $siparisSrogula["production_no"] . "</b>"
];
 
    echo json_encode(['icon' => 'danger', 'message' => $errorMessage]);
    exit;
}



// Yıl bilgisini al
$year = date("Y");

// O yıl için en son üretim numarasını bul
$lastProduction = $this->modelProduction
    ->like('production_no', "URT$year", 'after')
    ->orderBy('production_no', 'DESC')
    ->first();

if ($lastProduction) {
    // Son üretim numarasının son 6 hanesini al ve 1 artır
    $lastNumber = intval(substr($lastProduction['production_no'], -6));
    $newNumber = $lastNumber + 1;
} else {
    // O yıl için ilk üretim, 1'den başla
    $newNumber = 1;
}

// Yeni üretim numarasını oluştur
$uret = "URT" . $year . str_pad($newNumber, 6, "0", STR_PAD_LEFT);


$dataProduction = [
    'user_id' => session()->get('user_id'),
    'production_no' => $uret,
    'production_note' => $shipment_note,
    'order' => $siparis,
    'production_start_date' => Date("Y-m-d h:i:s"),
    'production_total' => $totalCount,
    'production_product_count' => $count,
    'production_status' => "new",
];

$productionAdd = $this->modelProduction->insert($dataProduction);
$addLastID = $this->modelProduction->getInsertID();


foreach ($validProducts as $index => $row) {
    $stock_title = $row['stock_title'];
    $stock_amount = $row['stock_amount'];
    $stock_total = $row['stock_total'];
    $girilen_miktar = $row['girilen_miktar'];
    $stock_id = $row['stock_id'];

    $stokBilgileri = $this->modelStock->where('stock_id', $stock_id)->first();

    
    $totalCount = floatval($totalCount) + floatval($girilen_miktar);

    $dataProductionRow = [
        'user_id' => session()->get('user_id'),
        'production_id' => $addLastID,
        'production_number' => $uret,
        'stock_id' => $stock_id,
        'stock_title' => $stock_title,
        'stock_code' => $stokBilgileri["stock_code"],
        'stock_barcode' => $stokBilgileri["stock_barcode"],
        'unit_id' => $stokBilgileri["buy_unit_id"],
        'stock_amount' => $girilen_miktar,
        'used_amount' => 0,
        'remaining_amount' => 0,
        'status' => "new",
    ];

    $productionrowAdd = $this->modelProductionRow->insert($dataProductionRow);
    $addRowID = $this->modelProductionRow->getInsertID();

    $urunOperasyonları = $this->modelStockOperation->where("stock_id", $stock_id)->orderBy("relation_order", "ASC")->findAll();
    $count = 0;

    foreach($urunOperasyonları as $op) {
        $count++;
        $Operasyon = $this->modelOperation->where("operation_id", $op["operation_id"])->orderBy("order", "ASC")->first();

        $islem = ($count == 1) ? "Beklemede" : "Askıda";

        $dataProductionRow = [
            'user_id' => session()->get('user_id'),
            'production_row_id' => $addRowID,
            'production_number' => $uret,
            'stock_id' => $stock_id,
            'production_id' => $addLastID,
            'operation_id' => $op["operation_id"],
            'stock_title' => $stock_title,
            'stock_code' => $stokBilgileri["stock_code"],
            'stock_barcode' => $stokBilgileri["stock_barcode"],
            'unit_id' => $stokBilgileri["buy_unit_id"],
            'stock_amount' => $girilen_miktar,
            'used_amount' => 0,
            'islem' => $Operasyon["operation_title"],
            'remaining_amount' => 0,
            'status' => $islem,
        ];

        $operationAdd = $this->modelProductionOperation->insert($dataProductionRow);
        $op_row_id = $this->modelProductionOperation->insertID();

        $uretimSatirlari = $this->modelProductionOperation->where('production_row_id', $addRowID)
            ->where("operation_id", $op["operation_id"])
            ->where("stock_id", $stock_id)
            ->first();

        $datatxtislemi = [
            'operation_title' => $Operasyon["operation_title"],
            'order_date' => date("d/m/Y H:i:s"),
            'order_quantity' => $girilen_miktar,
            'processed_quantity' => 0,
            'status' => $islem
        ];

        $txtislemi = json_encode($datatxtislemi, JSON_UNESCAPED_UNICODE);
        $datalog = [
            'user_id' => session()->get('user_id'),
            'production_row_operation_id' => $uretimSatirlari["production_row_operation_id"],
            'production_number' => $uret,
            'stock_id' => $stock_id,
            'operation_id' => $op["operation_id"],
            'stock_title' => $stokBilgileri["stock_title"],
            'stock_code' => $stokBilgileri["stock_code"],
            'stock_barcode' => $stokBilgileri["stock_barcode"],
            'unit_id' => $stokBilgileri["buy_unit_id"],
            'stock_amount' => $girilen_miktar,
            'used_amount' => 0,
            'islem' => $txtislemi,
            'remaining_amount' => 0,
            'status' => $islem,
        ];

        $operationUp = $this->modelProductionOperationRowModel->insert($datalog);
    }
}

if (!$errorMessage) {


if (session()->get('user_item')['user_id'] != 4 && session()->get('user_item')['user_id'] != 1) {
    foreach ($validProducts as $row) {
        $this->dusurReceteStoklari($row['stock_id'], $row['girilen_miktar'], $uret);  // $uret üretim no, $row['stock_id'] ve $row['girilen_miktar']
        $this->stokHesapla($row['stock_id']);
    }
}


$operationsData = $this->request->getPost("operationsData");

foreach ($operationsData as $operation) {
    $operationTitle = $operation['operation_title']; // Operasyon adı
    $productionId = $operation['operation_id']; // Operasyon ID
    if(isset($operation['users'])){
    foreach ($operation['users'] as $user) {
        $data = [
            'user_id' => session()->get('user_item')['user_id'], // Şu anki oturumun kullanıcısı
            'client_id' => $user['client_id'], // Kullanıcının client_id'si
            'operation_name' => $operationTitle, // Operasyon adı
            'operation_id' => $productionId, // Operasyon adı
            'username' => $user['username'], // Kullanıcı adı
            'status' => 'active', // Varsayılan olarak aktif
            'production' => $addLastID, // Operasyon ID
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Veritabanına ekle
        $this->modelOperationUser->insert($data);
        }
    }
}




    echo json_encode(['icon' => 'success', 'message' => 'Üretim Başarıyla Oluşturuldu']);
    $this->modelProduction->set("production_total", $totalCount)->set("production_product_count", $count)->where("production_id", $addLastID)->update();
} else {
    echo json_encode(['icon' => 'danger', 'message' => $errorMessage]);
}
exit;


          



        }

      
        $order_items = $this->modelProduction->join('production_row', 'production_row.production_id = production.production_id')
            ->where('production.user_id', session()->get('user_id'))
            ->where('production_status', 'new')
            ->orWhere('production_status', 'pending')
            ->orderBy('production.production_start_date', 'DESC')
            ->findAll();


        $data = [
            'page_title' => "Yeni Üretim Emri",
            'order_items' => $order_items,
        ];

        return view('tportal/uretim/yeni', $data);
    }

    */


    public function create()
    {




      

        if($this->request->getPost('siparis_id')){
            
          
           $errorMessage = [];
           $validProducts = [];
           $validRecete = [];
           $kacurun = 0;
           $stokEksikUrunler = [];  // Eksik stokları tutacak dizi
           $maxUretilebilecekAdet = PHP_INT_MAX;  // Mevcut stoklarla üretilebilecek maksimum adet
           
           $totalCount = 0;
           $count = 0;
           
           $siparis  = $this->request->getPost('siparis_id');
           $shipment_note  = $this->request->getPost('shipment_note');
           $stock_adi = "";
           
           foreach ($this->request->getPost('rowsData') as $index => $row) {
               $stock_title = $row['stock_title'];
               $stock_amount = $row['stock_amount'];
               $stock_total = $row['stock_total'];
               $girilen_miktar = $row['girilen_miktar'];
               $stock_id = $row['stock_id'];
               $kacurun++;
           
               if ($girilen_miktar == 0 || empty($girilen_miktar)) {
                continue;
            }
           
           
               $stokBilgileri = $this->modelStock->where('stock_id', $stock_id)->first();
               $urunOperasyonları = $this->modelStockOperation->where("stock_id", $stock_id)->orderBy("relation_order", "ASC")->findAll();
           
               if (!isset($urunOperasyonları) || empty($urunOperasyonları)) {
                   $errorMessage[] = [
                       'stok_title' => $stokBilgileri["stock_title"],
                       'error' =>  "<b>" . $stokBilgileri["stock_title"] . " </b> Ürün Operasyonu Yok"
                   ];
               } else {
                   $validProducts[] = $row;
               }
           
               // Reçeteyi ve reçetedeki bileşenleri alıyoruz
               $recete = $this->modelStockRecipe->where('stock_id', $stock_id)->first();
               if($recete)
                {
                    $receteUrunleri = $this->modelRecipeItem->where('recipe_id', $recete["recipe_id"])->findAll();
            
                    $maxUretilebilecekAdet = floatval($girilen_miktar);  // Maksimum üretilebilecek adet, sipariş miktarıyla başlatılır
                    $receteUrunleriWithStockTitle = [];
    
                    foreach ($receteUrunleri as $receteUrunu) {
                        $bilesen_stock_id = $receteUrunu['stock_id'];  // Reçetede kullanılan bileşenin stok ID'si
                        $siparisMiktari = floatval($girilen_miktar);  // Sipariş miktarını sayısal bir değere dönüştür
                    
                        $istenenMiktar = $receteUrunu['used_amount'] * $siparisMiktari;  // Gerekli bileşen miktarı
                    
                        // Bileşenin mevcut stok bilgilerini al
                        $stokBilgisi = $this->modelStock->where('stock_id', $bilesen_stock_id)->first();

                        if ($stokBilgisi && isset($stokBilgisi['stock_total_quantity'])) {
                    
                        // Eğer mevcut stok istenen miktardan azsa, eksik miktarı ve maksimum üretilebilecek miktarı hesapla
                        if ($stokBilgisi['stock_total_quantity'] < $istenenMiktar) {
                            $eksikMiktar = $istenenMiktar - $stokBilgisi['stock_total_quantity'];
                    
                            // Bu bileşen için mevcut stokla kaç adet üretilebileceğini hesapla
                            $bilesenIcinUretilebilecekAdet = floor($stokBilgisi['stock_total_quantity'] / $receteUrunu['used_amount']);
                    
                            // Mevcut stokla üretilebilecek maksimum adet, her bileşenin üretilebilecek en küçük miktarı ile güncellenir
                            $maxUretilebilecekAdet = min($maxUretilebilecekAdet, $bilesenIcinUretilebilecekAdet);
                    
                            // Eksik stok durumunu raporla
                            $stokEksikUrunler[] = [
                                'stock_id' => $stokBilgisi['stock_id'],
                                'stock_title' => $stokBilgisi['stock_title'],
                                'istenen_miktar' => $istenenMiktar,
                                'mevcut_stok' =>convert_number_for_form($stokBilgisi['stock_total_quantity'], 2),
                                'eksik_miktar' => $eksikMiktar,
                                'uret_ilebilecek_adet' => $bilesenIcinUretilebilecekAdet
                            ];
                        }
                         // Stok bilgisiyle birlikte her bileşeni yeni bir diziye ekliyoruz
                         $receteUrunleriWithStockTitle[] = array_merge($receteUrunu, [
                            'stock_title' => $stokBilgisi['stock_title']
                        ]);
                    }
                           
                    }
               }
           }



// Eğer eksik stoklar varsa ekranda gösterelim
if(session()->get('user_item')['user_id'] != 1){
    if (!empty($stokEksikUrunler)) {
        echo json_encode([
            'icon' => 'esik_stok',
            'message' => '<b>Yetersiz stoklar var, ancak mevcut stok reçetesiyle maksimum ' . $maxUretilebilecekAdet . ' adet üretilebilir.</b>',
            'eksik_urunler' => $stokEksikUrunler
        ]);
        return;
    } 
}



if (empty($validProducts)) {
    $errorMessage[] = [
        'error' => "<br> Siparişteki ürünlerin operasyonları olmadığı için <br> Üretim emiri oluşturulamadı."
];
 
    echo json_encode(['icon' => 'danger', 'message' => $errorMessage]);
    exit;
}







$siparisSrogula = $this->modelProduction->where("order", $siparis)->first();

if($siparisSrogula){
    $errorMessage[] = [
        'error' => "<br> Seçilen sipariş ile ilgili daha önce bir emir oluşturuldu. <b> " . $siparisSrogula["production_no"] . "</b>"
];
 
    echo json_encode(['icon' => 'danger', 'message' => $errorMessage]);
    exit;
}


$year = date("Y");

// O yıl için en son üretim numarasını bul
$lastProduction = $this->modelProduction
    ->like('production_no', "URT$year", 'after')
    ->orderBy('production_no', 'DESC')
    ->first();

if ($lastProduction) {
    // Son üretim numarasının son 6 hanesini al ve 1 artır
    $lastNumber = intval(substr($lastProduction['production_no'], -6));
    $newNumber = $lastNumber + 1;
} else {
    // O yıl için ilk üretim, 1'den başla
    $newNumber = 1;
}

// Yeni üretim numarasını oluştur
$uret = "URT" . $year . str_pad($newNumber, 6, "0", STR_PAD_LEFT);

$dataProduction = [
    'user_id' => session()->get('user_id'),
    'production_no' => $uret,
    'production_note' => $shipment_note,
    'order' => $siparis,
    'production_start_date' => Date("Y-m-d h:i:s"),
    'production_total' => $totalCount,
    'production_product_count' => $count,
    'production_status' => "new",
];

$productionAdd = $this->modelProduction->insert($dataProduction);
$addLastID = $this->modelProduction->getInsertID();


foreach ($validProducts as $index => $row) {
        $stock_title = $row['stock_title'];
    $stock_amount = $row['stock_amount'];
    $stock_total = $row['stock_total'];
    $girilen_miktar = $row['girilen_miktar'];
        $stock_id = $row['stock_id'];

    $stokBilgileri = $this->modelStock->where('stock_id', $stock_id)->first();

    
    $totalCount = floatval($totalCount) + floatval($girilen_miktar);


    for($i = 0; $i < $stock_amount; $i++) {
            $dataProductionRow = [
                'user_id' => session()->get('user_id'),
                'production_id' => $addLastID,
                'production_number' => $uret,
                'stock_id' => $stock_id,
                'stock_title' => $stock_title,
                'stock_code' => $stokBilgileri["stock_code"],
                'stock_barcode' => $stokBilgileri["stock_barcode"],
                'unit_id' => $stokBilgileri["buy_unit_id"],
                'stock_amount' => 1,
                'used_amount' => 0,
                'remaining_amount' => 0,
                'status' => "new",
            ];

            $productionrowAdd = $this->modelProductionRow->insert($dataProductionRow);
            $addRowID = $this->modelProductionRow->getInsertID();

            $urunOperasyonları = $this->modelStockOperation->where("stock_id", $stock_id)->orderBy("relation_order", "ASC")->findAll();
            $count = 0;

            foreach($urunOperasyonları as $op) {
                $count++;
                $Operasyon = $this->modelOperation->where("operation_id", $op["operation_id"])->orderBy("order", "ASC")->first();

                $islem = ($count == 1) ? "Beklemede" : "Askıda";

                $dataProductionRow = [
                    'user_id' => session()->get('user_id'),
                    'production_row_id' => $addRowID,
                    'production_number' => $uret,
                    'stock_id' => $stock_id,
                    'production_id' => $addLastID,
                    'operation_id' => $op["operation_id"],
                    'stock_title' => $stock_title,
                    'stock_code' => $stokBilgileri["stock_code"],
                    'stock_barcode' => $stokBilgileri["stock_barcode"],
                    'unit_id' => $stokBilgileri["buy_unit_id"],
                    'stock_amount' => 1,
                    'used_amount' => 0,
                    'islem' => $Operasyon["operation_title"],
                    'remaining_amount' => 0,
                    'status' => $islem,
                ];

                $operationAdd = $this->modelProductionOperation->insert($dataProductionRow);
                $op_row_id = $this->modelProductionOperation->insertID();

                $uretimSatirlari = $this->modelProductionOperation->where('production_row_id', $addRowID)
                    ->where("operation_id", $op["operation_id"])
                    ->where("stock_id", $stock_id)
                    ->first();

                $datatxtislemi = [
                    'operation_title' => $Operasyon["operation_title"],
                    'order_date' => date("d/m/Y H:i:s"),
                    'order_quantity' => $girilen_miktar,
                    'processed_quantity' => 0,
                    'status' => $islem
                ];

                $txtislemi = json_encode($datatxtislemi, JSON_UNESCAPED_UNICODE);
                $datalog = [
                    'user_id' => session()->get('user_id'),
                    'production_row_operation_id' => $uretimSatirlari["production_row_operation_id"],
                    'production_number' => $uret,
                        'stock_id' => $stock_id,
                    'operation_id' => $op["operation_id"],
                    'stock_title' => $stokBilgileri["stock_title"],
                    'stock_code' => $stokBilgileri["stock_code"],
                    'stock_barcode' => $stokBilgileri["stock_barcode"],
                    'unit_id' => $stokBilgileri["buy_unit_id"],
                    'stock_amount' => 1,
                    'used_amount' => 0,
                    'islem' => $txtislemi,
                    'remaining_amount' => 0,
                    'status' => $islem,
                ];

                $operationUp = $this->modelProductionOperationRowModel->insert($datalog);
            }
     }
}

if (!$errorMessage) {


if (session()->get('user_item')['user_id'] != 1) {
    foreach ($validProducts as $row) {
        $this->dusurReceteStoklari($row['stock_id'], $row['girilen_miktar'], $uret);  // $uret üretim no, $row['stock_id'] ve $row['girilen_miktar']
        $this->stokHesapla($row['stock_id']);
    }
}


$operationsData = $this->request->getPost("operationsData");

foreach ($operationsData as $operation) {
    $operationTitle = $operation['operation_title']; // Operasyon adı
    $productionId = $operation['operation_id']; // Operasyon ID

    foreach ($operation['users'] as $user) {
        $data = [
            'user_id' => session()->get('user_item')['user_id'], // Şu anki oturumun kullanıcısı
            'client_id' => $user['client_id'], // Kullanıcının client_id'si
            'operation_name' => $operationTitle, // Operasyon adı
            'operation_id' => $productionId, // Operasyon adı
            'username' => $user['username'], // Kullanıcı adı
            'status' => 'active', // Varsayılan olarak aktif
            'production' => $addLastID, // Operasyon ID
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Veritabanına ekle
        $this->modelOperationUser->insert($data);
    }
}




    echo json_encode(['icon' => 'success', 'message' => 'Üretim Başarıyla Oluşturuldu']);
    $this->modelProduction->set("production_total", $totalCount)->set("production_product_count", $count)->where("production_id", $addLastID)->update();
        } else {
    echo json_encode(['icon' => 'danger', 'message' => $errorMessage]);
}
exit;


          



        }

      
        $order_items = $this->modelProduction->join('production_row', 'production_row.production_id = production.production_id')
            ->where('production.user_id', session()->get('user_id'))
            ->where('production_status', 'new')
            ->orWhere('production_status', 'pending')
            ->orderBy('production.production_start_date', 'DESC')
            ->findAll();


        $data = [
            'page_title' => "Yeni Üretim Emri",
            'order_items' => $order_items,
        ];

        return view('tportal/uretim/yeni', $data);
    }

    public function detail($production_id,$order_id)
    {

     

            $order_item = $this->modelProduction->join('production_row', 'production_row.production_id = production.production_id')
            ->where('production.user_id', session()->get('user_id'))
            ->where('production_row.stock_id', $order_id)
            ->where('production_row.production_id', $production_id)
            ->orderBy('production.production_start_date')
            ->first();



        if (!$order_item) {
            return view('not-found');
        }

        $order_rows = $this->modelProductionRow->join('unit', 'unit.unit_id = production_row.unit_id')
            ->join('production', 'production.production_id = production_row.production_id')
            ->join('stock', 'stock.stock_id = production_row.stock_id')
            ->where('production_row.stock_id', $order_id)
            ->where('production_row.production_id', $production_id)
            ->findAll();
        $uretimHareketleri = $this->modelProductionOperationRowModel->where("stock_id", $order_id)->where("production_number", $order_item["production_no"])->orderBy("production_row_operation_row_id", "DESC")->findAll();


        $data = [

            'order_item' => $order_item,
            'uretimHareketleri' => $uretimHareketleri,
            'order_rows' => $order_rows
        ];


       

        // print_r($order_item);
        // return;

        return view('tportal/uretim/detay/detay', $data);
    }

    public function operationDurum()
    {   
        $user_item = session("user_item");
        $row_id = $this->request->getPost("id");
        $text = $this->request->getPost("text");
        $baslangic_tarihi = $this->request->getPost("production_baslangic");

        $BaslangicDurdurSaniye = $this->sureHesapla($baslangic_tarihi, date("d/m/Y H:i:s"));


        

        $OperasyonSatiri = $this->modelProductionOperationRowModel->where("production_row_operation_id", $row_id)->where("operation_id", $user_item["operation"])->first();
        $Operasyon = $this->modelOperation->where("operation_id", $OperasyonSatiri["operation_id"])->orderBy("order", "ASC")->first();

       

        if(!$OperasyonSatiri){
            $html = "Üretim Satırı Bulunamadı..";
            echo json_encode(['icon' => 'danger', 'response' => $html]);
            return false;
        }

        $data = [
            'status' => "Durdu"
        ];

        

        $operationUp = $this->modelProductionOperation->set($data)->where("production_row_operation_id", $row_id)->update();
        $opGetir = $this->modelProductionOperation->where("production_row_operation_id", $row_id)->first();

        $stokBilgileri = $this->modelStock->where('stock_id', $OperasyonSatiri["stock_id"])->first();
       

        if($opGetir["status"] == "Durdu"){

            $data_txt = [
                'operator' => $this->request->getPost("operator"),
                'operation_title' => $Operasyon["operation_title"],
                'stop_date' => date("d/m/Y H:i:s"),
                'islem' => $text,
                'sure' => $BaslangicDurdurSaniye,
                'order_quantity' => $OperasyonSatiri["stock_amount"],
                'processed_quantity' => $OperasyonSatiri["used_amount"],
                'status' => 'Durdu'
            ];
            
        $txtislemi = json_encode($data_txt, JSON_UNESCAPED_UNICODE);


            $datalog = [

                'user_id' => session()->get('user_id'),
                'production_row_operation_id' => $row_id,
                'baslangic' => date("d/m/Y H:i:s"),
                'production_number' =>  $OperasyonSatiri["production_number"],
                'stock_id' =>  $OperasyonSatiri["stock_id"],
                'operation_id' => $Operasyon["operation_id"],
                'stock_title' => $stokBilgileri["stock_title"],
                'stock_code' => $stokBilgileri["stock_code"],
                'stock_barcode' => $stokBilgileri["stock_barcode"],
                'unit_id' => $stokBilgileri["buy_unit_id"],
                'stock_amount' => $OperasyonSatiri["stock_amount"],
                'used_amount' => $OperasyonSatiri["used_amount"],
                'islem'       => $txtislemi,
                'remaining_amount' => 0,
                'status' => "Durdu",

            ];

            $operationUp = $this->modelProductionOperationRowModel->insert($datalog);

            $html = "Başarıyla Durduruldu";
        }
        echo json_encode(['icon' => 'success', 'response' => $html]);


    }


    public function operationDurumDevam()
    {   
        $user_item = session("user_item");
        $row_id = $this->request->getPost("id");

        $durdur_tarihi = $this->request->getPost("durdur_tarihi");

        $DurdurveDevamSaniye = $this->sureHesapla($durdur_tarihi, date("d/m/Y H:i:s"));



        $OperasyonSatiri = $this->modelProductionOperationRowModel->where("production_row_operation_id", $row_id)->where("operation_id", $user_item["operation"])->first();
        $Operasyon = $this->modelOperation->where("operation_id", $OperasyonSatiri["operation_id"])->orderBy("order", "ASC")->first();

       

        if(!$OperasyonSatiri){
            $html = "Üretim Satırı Bulunamadı..";
            echo json_encode(['icon' => 'danger', 'response' => $html]);
            return false;
        }

        $data = [
            'status' => "Devam"
        ];

        $operationUp = $this->modelProductionOperation->set($data)->where("production_row_operation_id", $row_id)->update();
        $opGetir = $this->modelProductionOperation->where("production_row_operation_id", $row_id)->first();

        $stokBilgileri = $this->modelStock->where('stock_id', $OperasyonSatiri["stock_id"])->first();
       


    $data_txt = [
        'operator' => $this->request->getPost("operator"),
        'operation_title' => $Operasyon["operation_title"],
        'baslangic' => date("d/m/Y H:i:s"),
        'islem' => "Üretime Devam Edildi",
        'sure' => $DurdurveDevamSaniye,
        'order_quantity' => $OperasyonSatiri["stock_amount"],
        'processed_quantity' => $OperasyonSatiri["used_amount"],
        'status' => 'Devam'
    ];
    
$txtislemi = json_encode($data_txt, JSON_UNESCAPED_UNICODE);


    $datalog = [

        'user_id' => session()->get('user_id'),
        'production_row_operation_id' => $row_id,
        'baslangic' => date("d/m/Y H:i:s"),
        'production_number' =>  $OperasyonSatiri["production_number"],
        'stock_id' =>  $OperasyonSatiri["stock_id"],
        'operation_id' => $Operasyon["operation_id"],
        'stock_title' => $stokBilgileri["stock_title"],
        'stock_code' => $stokBilgileri["stock_code"],
        'stock_barcode' => $stokBilgileri["stock_barcode"],
        'unit_id' => $stokBilgileri["buy_unit_id"],
        'stock_amount' => $OperasyonSatiri["stock_amount"],
        'used_amount' => $OperasyonSatiri["used_amount"],
        'islem'       => $txtislemi,
        'remaining_amount' => 0,
        'status' => "Devam",

    ];

    $operationUp = $this->modelProductionOperationRowModel->insert($datalog);

    $html = "Başarıyla Devam Ettirildi.";

        echo json_encode(['icon' => 'success', 'response' => $html]);


    }


    public function getOperationRow(){

        $user_item = session("user_item");

        $id = $this->request->getPost("id");
        $Operasyonlar = $this->modelProductionOperation->where("production_row_operation_id", $id)->where("operation_id", $user_item["operation"])->first();

       

        if($Operasyonlar){

            if($Operasyonlar["status"] == "Beklemede"){
                $opselect = "disabled";
                $islemde = '  <div class="col-lg-6 col-xxl-12 ">
                <div class="form-group">
                <br>
                   <div class="alert alert-info">  İşlemlere başlamak için lütfen durumu <b> "İşlemde"</b>  Olarak Değiştirin.</div>
                </div>
                </div>
';
            }else{
                $opselect = "";
                $islemde = '';
            }
         
            $html = ' 

            <input type="hidden" name="op_id" id="op_id" value="'.$Operasyonlar["production_row_operation_id"].' "   class="form-control form-control-xl"
            disabled 
            value="'.$Operasyonlar["operation_id"].'">
                <div class="col-lg-6 col-xxl-6 ">
                    <div class="form-group">
                        <label class="form-label" for="firma_adi">Ürün Adı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl"
                                disabled 
                                value="'.$Operasyonlar["stock_title"].'">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xxl-6 ">
                    <div class="form-group">
                        <label class="form-label" for="user_adsoyad">Sipariş Miktarı</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-xl"
                            value="'.number_format($Operasyonlar['stock_amount'], 2, ',', '.').'" id="siparis_miktar" disabled>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-xxl-6 ">
                    <div class="form-group">
                        <label class="form-label" for="islenen_miktar">İşlenen Miktar</label>
                        <div class="form-control-wrap">
                            <input type="number" '.$opselect.' max="'.$Operasyonlar["stock_amount"].'" class="form-control form-control-xl"
                            onchange="hesapla()"   id="islenen_miktar"
                                name="islenen_miktar">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xxl-6 ">
                    <div class="form-group">
                        <label class="form-label" for="user_eposta">Kalan Miktar</label>
                        <div class="form-control-wrap">
                            <input type="number" max="'.$Operasyonlar["stock_amount"].'" disabled id="kalanMiktar" class="form-control form-control-xl"
                                placeholder="Kalan Miktar" >
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xxl-6 ">
                    <div class="form-group">
                        <label class="form-label" for="user_eposta">Operasyon Durumu</label>
                        <div class="form-control-wrap">
                            <input type="text" value="'.$Operasyonlar["status"].'" disabled class="form-control form-control-xl"  >
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xxl-6 ">
                    <div class="form-group">
                    <label class="form-label" for="user_eposta">Durumu  Değiştir</label>
                        <div class="form-control-wrap">
                            <select class="form-select form-select-lg js-select2 form-control" data-ui="lg" 
                            id="operation_status"  data-ui="lg" 
                            data-placeholder="Seçiniz">
                                <option value="Beklemede" disabled >Beklemede</option>
                                 <option value="İşlemde" >İşlemde</option>
                                <option value="Bitti"  '.$opselect.' >Tamamlandı</option>
                                <option value="İptal" '.$opselect.' >İptal Edildi</option>
                            </select>
                        </div>
                    </div>
                </div>

              '.$islemde.'
            </div>';



            echo json_encode(['icon' => 'success', 'data' => $html]);

        }else{

            $html = "  Operasyon Bulunamadı... ";
            echo json_encode(['icon' => 'danger', 'data' => $html]);

        }



    }



    public function getOperationRowislem(){

        $user_item = session("user_item");

        $id = $this->request->getPost("id");


     

       
        
        $Operasyonlar = $this->modelProductionOperation->where("production_row_operation_id", $id)->where("operation_id", $user_item["operation"])->first();
  
        $Operasyon = $this->modelOperation->where("operation_id", $Operasyonlar["operation_id"])->orderBy("order", "ASC")->first();

      
   
 

        if($Operasyonlar){


           
   



            $islenen_miktar = $this->request->getPost("islenen_miktar");
            $operation_status = $this->request->getPost("operation_status");
            if($islenen_miktar){
                $yeniStok  = ($islenen_miktar + $Operasyonlar["used_amount"]);
            }else{
                $yeniStok  = 0;
            }

       
            

            if($yeniStok == $Operasyonlar["stock_amount"] || $yeniStok > $Operasyonlar["stock_amount"]){
                $stauts = "Bitti";  


                $data = [

                    'used_amount' => $yeniStok,
                    'remaining_amount' => 0,
                    'status' => "Bitti"

                ];

                $operationUp = $this->modelProductionOperation->set($data)->where("production_row_operation_id", $id)->update();

                $operationUpList = $this->modelProductionOperation->where("production_row_operation_id", $id)->first();


                $dataDiger = [
                    'status' => "Beklemede"
                ];

                $firstRow = $this->modelProductionOperation
                ->where("production_number", $Operasyonlar["production_number"])
                ->where("stock_id", $Operasyonlar["stock_id"])
                ->where("status", "Askıda")
                ->first();
                if($firstRow){

                   $operationUp = $this->modelProductionOperation->set($dataDiger)
                    ->where("production_row_operation_id",  $firstRow["production_row_operation_id"])->update();
                }


                



                $stokBilgileri = $this->modelStock->where('stock_id', $operationUpList["stock_id"])->first();
       
            



            $BaslangicVeBitis = $this->sureHesapla($Operasyonlar["baslangic"], date("d/m/Y H:i:s"));

            $data_txtislemi = [
                'operator' => $this->request->getPost("operator"),
                'operation_title' => $Operasyon["operation_title"],
                'start_date' => $Operasyonlar["baslangic"],
                'end_date' => date("d/m/Y H:i:s"),
                'sure' => $BaslangicVeBitis,
                'order_quantity' => $Operasyonlar["stock_amount"],
                'processed_quantity' => $yeniStok,
                'status' => 'Bitti'
            ];

            $txtislemi = json_encode($data_txtislemi, JSON_UNESCAPED_UNICODE);

                $datalog = [

                    'user_id' => session()->get('user_id'),
                    'production_row_operation_id' => $id,
                    'production_number' =>  $Operasyonlar["production_number"],
                    'stock_id' =>  $operationUpList["stock_id"],
                    'operation_id' => $Operasyonlar["operation_id"],
                    'stock_title' => $stokBilgileri["stock_title"],
                    'stock_code' => $stokBilgileri["stock_code"],
                    'stock_barcode' => $stokBilgileri["stock_barcode"],
                    'unit_id' => $stokBilgileri["buy_unit_id"],
                    'stock_amount' => $Operasyonlar["stock_amount"],
                    'used_amount' => $yeniStok,
                    'islem'       => $txtislemi,
                    'remaining_amount' => 0,
                    'status' => "Bitti",

                ];

                $operationUp = $this->modelProductionOperationRowModel->insert($datalog);



            }else{
                
                if($islenen_miktar == ""){
                    $data = [
                        'status' => "İşlemde",
                        'baslangic' => date("d/m/Y H:i:s")
                    ];
                   
                }else{
                    $data = [

                        'used_amount' => $islenen_miktar,
                        'remaining_amount' => ($Operasyonlar["used_amount"] - $islenen_miktar),
                        'status' => "İşlemde"
    
                    ];
                }

                
           

                $operationUpList = $this->modelProductionOperation->where("production_row_operation_id", $id)->first();
                $operationUp = $this->modelProductionOperation->set($data)->where("production_row_operation_id", $id)->update();

                $stokBilgileri = $this->modelStock->where('stock_id', $operationUpList["stock_id"])->first();
                $new_timestamp = date("d/m/Y H:i:s", strtotime($Operasyonlar["created_at"]));
                $OlusturmaveBaslama = $this->sureHesapla($new_timestamp, date("d/m/Y H:i:s"));
                $data_type = [
                    'operator' => $this->request->getPost("operator"),
                    'operation_title' => $Operasyon["operation_title"],
                    'start_date' => date("d/m/Y H:i:s"),
                    'update_date' => date("d/m/Y H:i:s"),
                    'sure' => $OlusturmaveBaslama,
                    'order_quantity' => $Operasyonlar["stock_amount"],
                    'processed_quantity' => $yeniStok,
                    'status' => 'İşlemde'
                ];
                
                $txtislemi = json_encode($data_type, JSON_UNESCAPED_UNICODE);

                $datalog = [

                    'user_id' => session()->get('user_id'),
                    'production_row_operation_id' => $id,
                    'production_number' =>  $Operasyonlar["production_number"],
                    'stock_id' =>  $stokBilgileri["stock_id"],
                    'operation_id' => $Operasyonlar["operation_id"],
                    'stock_title' => $stokBilgileri["stock_title"],
                    'stock_code' => $stokBilgileri["stock_code"],
                    'stock_barcode' => $stokBilgileri["stock_barcode"],
                    'unit_id' => $stokBilgileri["buy_unit_id"],
                    'stock_amount' => $Operasyonlar["stock_amount"],
                    'used_amount' => $yeniStok,
                    'islem'       => $txtislemi,
                    'remaining_amount' => 0,
                    'status' => "İşlemde",

                ];

                $operationUp = $this->modelProductionOperationRowModel->insert($datalog);

           



            }

            $lastRow = $this->modelProductionOperation
            ->where("production_number", $Operasyonlar["production_number"])
            ->where("stock_id", $stokBilgileri["stock_id"])
            //->where("status", "Bitti")
            //->where("production_row_operation_id", $id)
            ->orderBy("production_row_operation_id", "desc")
            ->first();

            
       
            if($lastRow["status"] == "Bitti"){
             
            if($lastRow["production_row_operation_id"]== $id){

     
    

          
 
                    $stock_id = $Operasyonlar["stock_id"];

                      # TODO: Bu query duruma göre azaltılabilir. Barkod sayfasının htmli oluşturulduktan sonra gereksiz şeyler buradan çıkıcak
            # Şu anda sadece ürün geçerli mi diye bakıyoruz ve generate_barcode_html içerisine yolluyoruz. Başka bir işlevi yok bu querynin.
            $stock_item = $this->modelStock->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
    
            ->select('stock.*')
            ->select('buy_unit.unit_title as buy_unit_title, buy_unit.unit_value as buy_unit_value')
            ->select('sale_unit.unit_title as unit_title, sale_unit.unit_value as sale_unit_value')
      
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.stock_id', $stock_id)
            ->first();
     
        if (!$stock_item) {
            echo json_encode(['icon' => 'error', 'message' => "Stoğa Kaydedilemedi"]);
            return;
        }

      

        $all_barcode = array();




                if (is_numeric($yeniStok)) {

                    $user_item_tedarik = session("user_item")["stock_uretim"];
                    $user_item_depo = session("user_item")["depo_uretim"];

                    $uretimEmiri = $this->modelProduction->where("production_no", $Operasyonlar["production_number"])->first();

                    $orderSatiri = $this->modelOrderRow->where("order_id", $uretimEmiri["order"])->where("stock_id", $stock_item['stock_id'])->first();

                    if($orderSatiri){
                        $buy_unit_price = convert_number_uretim($orderSatiri["unit_price"]);
                    }else{
                        $buy_unit_price = convert_number_uretim('1,0000');
                    }

                    $warehouse_id = $user_item_depo;
                    $supplier_id =  $user_item_tedarik;
                    // $stock_quantity = convert_number_for_sql($row['miktar']);
                    $stock_quantity = $yeniStok;
                    $transaction_note = $Operasyonlar["production_number"] . " - Üretim Emiri";
                    $warehouse_address = "Depo";
                    
                    $buy_money_unit_id = 1;

                    $barcode_number = generate_barcode_number();

                    $insert_barcode_data = [
                        'stock_id' => $stock_item['stock_id'],
                        'uretim_barcode' => $Operasyonlar["production_number"],
                        'warehouse_id' => $warehouse_id ?? 1,
                        'warehouse_address' => $warehouse_address,
                        'barcode_number' => $barcode_number,
                        'total_amount' => $stock_quantity,
                        'used_amount' => 0
                    ];
                    $this->modelStockBarcode->insert($insert_barcode_data);
                    $stock_barcode_id = $this->modelStockBarcode->getInsertID();

                    // print_r("burdasın");
                    // exit();


                    // tedarikçi varsa finansal hareket ve gelen fatura tipinde fatura oluşturuyoruz
                    $financialMovement_id = 0;
                    if ($supplier_id != 0) {
                        $supplier = $this->modelCari->join('address', 'cari.cari_id = address.cari_id', 'left')->where('cari.cari_id', $supplier_id)->where('cari.user_id', session()->get('user_id'))->first();

                        $stock_entry_prefix = "STKTDRK";

                        $stock_total = convert_number_uretim($stock_quantity) * $buy_unit_price;

                        [$transaction_direction, $amount_to_be_processed] = ['entry', $stock_total * -1];

                        $currentDateTime = new Time('now', 'Turkey', 'en_US');
                        $currency_amount = str_replace(',', '.', $this->request->getPost('currency_amount')) ?? 1;
                        $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                        if ($last_transaction) {
                            $transaction_counter = $last_transaction['transaction_counter'] + 1;
                        } else {
                            $transaction_counter = 1;
                        }
                        $transaction_number = $stock_entry_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                        $insert_financial_movement_data = [
                            'user_id' => session()->get('user_id'),
                            'cari_id' => $supplier_id,
                            'money_unit_id' => $buy_money_unit_id,
                            'transaction_number' => $transaction_number,
                            'transaction_direction' => $transaction_direction,
                            'transaction_type' => 'incoming_invoice',
                            'invoice_id' => 'incoming_invoice',
                            'transaction_tool' => 'not_payroll',
                            'transaction_title' => "Stok girişinden oluşan hareket",
                            'transaction_description' => "Stok girişinden oluşan otomatik hareket",
                            'transaction_amount' => $stock_total,
                            'transaction_real_amount' => $stock_total,
                            'transaction_date' => $currentDateTime,
                            'transaction_prefix' => $stock_entry_prefix,
                            'transaction_counter' => $transaction_counter
                        ];
                        $this->modelFinancialMovement->insert($insert_financial_movement_data);
                        $financialMovement_id = $this->modelFinancialMovement->getInsertID();

                        $update_cari_data = [
                            'cari_balance' => $supplier['cari_balance'] + $amount_to_be_processed
                        ];
                        $this->modelCari->update($supplier['cari_id'], $update_cari_data);



                        // fatura kayıt oluşturuyoruz
                        $insert_invoice_data = [
                            'user_id' => session()->get('user_id'),
                            'money_unit_id' => $buy_money_unit_id,
                            'sale_type' => "quick",

                            'invoice_direction' => 'incoming_invoice',
                            'invoice_date' => new Time('now', 'Turkey', 'en_US'),
                            'expiry_date' => new Time('now', 'Turkey', 'en_US'),
                            'currency_amount' => $currency_amount,

                            'stock_total' => $stock_quantity * $buy_unit_price,
                            'stock_total_try' => ($stock_quantity * $buy_unit_price) * floatval(str_replace(',', '.', $currency_amount)),
                            'sub_total' => $stock_quantity * $buy_unit_price,
                            'sub_total_try' => ($stock_quantity * $buy_unit_price) * floatval(str_replace(',', '.', $currency_amount)),
                            'grand_total' => $stock_quantity * $buy_unit_price,
                            'grand_total_try' => ($stock_quantity * $buy_unit_price) * floatval(str_replace(',', '.', $currency_amount)),
                            'amount_to_be_paid' => $stock_quantity * $buy_unit_price,
                            'amount_to_be_paid_try' => ($stock_quantity * $buy_unit_price) * floatval(str_replace(',', '.', $currency_amount)),

                            'cari_identification_number' => $supplier['identification_number'],
                            'cari_tax_administration' => $supplier['tax_administration'],

                            'cari_invoice_title' => $supplier['invoice_title'] == '' ? $supplier['name'] . " " . $supplier['surname'] : $supplier['invoice_title'],
                            'cari_name' => $supplier['name'],
                            'cari_surname' => $supplier['surname'],
                            'cari_obligation' => $supplier['obligation'],
                            'cari_company_type' => $supplier['company_type'],
                            'cari_phone' => $supplier['cari_phone'],
                            'cari_email' => $supplier['cari_email'],

                            'address_country' => $supplier['address_country'],
                            'address_city' => isset($supplier['address_city_name']) ? $supplier['address_city_name'] : "",
                            'address_city_plate' => isset($supplier['address_city']) ? $supplier['address_city'] : "",
                            'address_district' => isset($supplier['address_district']) ? $supplier['address_district'] : "",
                            'address_zip_code' => $supplier['zip_code'],
                            'address' => $supplier['address'],

                            'invoice_status_id' => "1",
                        ];

                        // print_r(str_replace(',', '.', $stock_quantity) * str_replace(',', '.', $buy_unit_price));
                        // print_r((str_replace(',', '.', $stock_quantity) * str_replace(',', '.', $buy_unit_price)) * str_replace(',', '.', $currency_amount));

                        $this->modelInvoice->insert($insert_invoice_data);
                        $invoice_id = $this->modelInvoice->getInsertID();

                        //cari harektlerinden ilgili hareket detayına gitmek için
                        $update_modelFinancialMovement_data = [
                            'invoice_id' => $invoice_id,
                        ];
                        $this->modelFinancialMovement->update($financialMovement_id, $update_modelFinancialMovement_data);


                        $insert_invoice_row_data = [
                            'user_id' => session()->get('user_id'),
                            'invoice_id' => $invoice_id,
                            'stock_id' => $stock_item['stock_id'],
                            'stock_barcode_id' => $stock_barcode_id,
                            'stock_title' => $stock_item['stock_title'],
                            'stock_amount' => $stock_quantity,

                            'unit_id' => $stock_item['buy_unit_id'],
                            'unit_price' => $buy_unit_price,

                            'subtotal_price' => $stock_total,

                            'total_price' => $stock_total,
                        ];
                        $this->modelInvoiceRow->insert($insert_invoice_row_data);
                    }else{
                        $supplier = 0;
                    }
                 
                    
                   

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
                        'stock_barcode_id' => $stock_barcode_id,
                        'invoice_id' => $invoice_id,
                        'supplier_id' => $supplier_id,
                        'movement_type' => 'incoming',
                        'transaction_number' => $transaction_number_stock_movement,
                        'to_warehouse' => $warehouse_id,
                        'transaction_note' => $transaction_note,
                        'transaction_info' =>  'Üretim Stok',
                        'buy_unit_price' => $buy_unit_price,
                        'buy_money_unit_id' => $buy_money_unit_id,
                        'transaction_quantity' => $stock_quantity,
                        'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                        'transaction_prefix' => $stock_movement_prefix,
                        'transaction_counter' => $transaction_counter_stock_movement,
                    ];
                    $this->modelStockMovement->insert($insert_movement_data);
                    $stock_movement_id = $this->modelStockMovement->getInsertID();

                    if ($supplier_id != 0) {
                        //cari harektlerinden ilgili hareket detayına gitmek ve stok silerken ilgili harekti de silmek için
                        $update_modelFinancialMovement_data = [
                            'stock_movement_id' => $stock_movement_id,
                        ];
                        $this->modelFinancialMovement->update($financialMovement_id, $update_modelFinancialMovement_data);
                    }
                    // $this->updateStockQuantity($stock_item['stock_id'], str_replace(',', '.', $stock_quantity), 'add');


                    $insert_StockWarehouseQuantity = [
                        'user_id' => session()->get('user_id'),
                        'warehouse_id' => $warehouse_id,
                        'stock_id' => $stock_item['stock_id'],
                        'parent_id' => $stock_item['parent_id'],
                        'stock_quantity' => $stock_quantity,
                    ];


                    // $StockWarehouseQuantity_item = $this->modelStockWarehouseQuantity
                    //     ->where('user_id', session()->get('user_id'))
                    //     ->where('warehouse_id', $warehouse_id)
                    //     ->where('stock_id', $stock_id)
                    //     ->where('parent_id', $stock_item['parent_id'])
                    //     ->first();

                    // $addStock = $this->updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $warehouse_id, $stock_id, $stock_item['parent_id'], $stock_quantity, 'add');
                    if($stock_item['parent_id'] == 0){
                        $parentStok = $stock_id;
                    }else{
                        $parentStok  = $stock_item['parent_id'];
                    }
                    $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $warehouse_id, $stock_id, $parentStok, $stock_quantity, 'add', $this->modelStockWarehouseQuantity, $this->modelStock);

                    if ($addStock === 'eksi_stok') {
                        echo json_encode(['icon' => 'error', 'message' => 'bu işlemden sonra stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz.']);
                        return;
                    }

                    $barcode_html = generate_barcode_html($stock_item, $insert_barcode_data, $transaction_note, $supplier);

                    array_push($all_barcode, $barcode_html);
                }
            
             // Biten operasyonları al
                $bitenler = $this->modelProductionOperation
                ->where("production_number", $Operasyonlar["production_number"])
                ->where("stock_id", $Operasyonlar["stock_id"])
                ->where("status", "Bitti")
                ->orderBy("production_row_operation_id", "desc")
                ->findAll();

                foreach($bitenler as $bitti)
                {
                    // Uygun satırı güncelle
                    $this->modelProductionRow
                        ->set("status", "success")
                        ->where("production_row_id", $bitti["production_row_id"])
                        ->update();

                    // 'new' statüsündeki satırları say
                    $newCount = $this->modelProductionRow
                        ->where("production_id", $bitti["production_id"])
                        ->where("status", "new")
                        ->countAllResults();

                    // Eğer 'new' statüsünde satır yoksa, genel üretim durumunu güncelle
                    if($newCount == 0){
                        $this->modelProduction
                            ->set("production_status", "success")
                            ->where("production_id", $bitti["production_id"])
                            ->update();
                    }
                }
              

            echo json_encode(['icon' => 'success', 'message' => 'Stok hareketi başarıyla oluşturuldu.', 'all_barcode' => $all_barcode]);



            }
        }
            else{
                $html = "ok";
                echo json_encode(['icon' => 'success', 'data' => $html]);
            }
     

        }else{

            $html = "  Operasyon Bulunamadı... ";
            echo json_encode(['icon' => 'danger', 'data' => $html]);

        }



    }
    /* public function getBarcode()
    {
        $barkod = $this->request->getPost('barcode');
        
        // Barkoda göre stok bilgisini al
        $StoktanBul = $this->modelStock->where("stock_barcode", $barkod)->first();
      
        if ($StoktanBul) {
            // Stok ID'ye göre order_row bilgilerini al
            $Satirlars = $this->modelOrderRow->where("stock_id", $StoktanBul["stock_id"])->first();
            
            if(!$Satirlars){
                echo json_encode(['icon' => 'danger', 'data' => "Girilen barkoda ait sipariş bulunamadı"]);
            } else {
                $html = '';
                
                    // order_id'ye göre tüm sipariş satırlarını al
                    $Satirlar = $this->modelOrderRow->where("order_id", $Satirlars["order_id"])->findAll();
                    
                    foreach($Satirlar as $satir) {
                        // Sipariş bilgilerini al
                        $Siparisler = $this->modelOrder->where("order_id", $satir["order_id"])->first(); 
    
                        // Platform bilgisini HTML içeriğinden ayır
                        $text = $Siparisler['b2b'];
                        $doc = new DOMDocument();
                        libxml_use_internal_errors(true); // HTML ayrıştırma hatalarını göz ardı et
                        $doc->loadHTML($text);
                        libxml_clear_errors();
                
                        $xpath = new DOMXPath($doc);
                        $platformNodes = $xpath->query("//b/span");
    
                        if ($platformNodes->length > 0) {
                            $platform = trim($platformNodes->item(0)->textContent);
                        } else {
                            $platform = '';
                        }
    
                        // HTML içeriğini oluştur
                        $html .= '<div class="row mb-2 mt-2 nowrap">';
                        $html .= '    <div class="col-6 col-sm-2 col-md-2 col-lg-2 tdPhoto">';
                        $html .= '        <a class="gallery-image popup-image" href="' . $StoktanBul["default_image"] . '">';
                        $html .= '            <img src="' . $StoktanBul["default_image"] . '" alt="" class="img-fluid">';
                        $html .= '        </a>';
                        $html .= '    </div>';
                        $html .= '    <div class="col-6 col-sm-5 col-md-5 col-lg-10 col-m-left">';
                        $html .= '        <ul class="urunBilgileri list-unstyled" style="height: 100%;">';
                        $html .= '            <li>';
                        $html .= '                <span>Platform :</span>';
                        $html .= '                <span><b style="text-transform:uppercase; font-size:17px;">' . $platform . '</b></span>';
                        $html .= '            </li>';
                        $html .= '            <li>';
                        $html .= '                <span>Sipariş Kodu :</span>';
                        $html .= '                <span><b>' . $Siparisler['order_no'] . '</b></span>';
                        $html .= '            </li>';
                        $html .= '            <li>';
                        $html .= '                <span>Tarih :</span>';
                        $html .= '                <span>' . date("d/m/Y h:i", strtotime($satir['created_at'])) . '</span>';
                        $html .= '            </li>';
                        $html .= '            <li>';
                        $html .= '                <span>Ürün Adı :</span>';
                        $html .= '                <span><b>' . $satir['dopigo_title'] . '</b></span>';
                        $html .= '            </li>';
                        $html .= '            <li>';
                        $html .= '                <span>Adet :</span>';
                        $html .= '                <span><b>' . number_format($satir['stock_amount'], 2, ',', '.') . '</b></span>';
                        $html .= '            </li>';
                        $html .= '        </ul>';
                        $html .= '    </div>';
                        $html .= '</div>';
                    }
                
    
                echo json_encode(['icon' => 'success', 'data' => $html]);
            }
        } else {
            echo json_encode(['icon' => 'danger', 'data' => "Ürün Bulunamadı"]);
        }
    } */


    /* 
    public function getBarcode()
{
    $barkod = $this->request->getPost('barcode');
    if(strlen($barkod) < 13){
        $sorgu = convert_barcode_number_for_sql_production($barkod);
    }else{
        $sorgu = convert_barcode_number_for_sql($barkod);

    }

  

    // Barkodun veritabanında olup olmadığını kontrol et
    $StoktanBul = $this->modelStock->where("stock_barcode", $sorgu)->first();
    if (!$StoktanBul) {
        echo json_encode(['icon' => 'danger', 'stock_id' => $StoktanBul["stock_id"], 'data' => "Ürün Bulunamadı"]);
        return;
    }


    // Sipariş satırlarını al
    $siparisSatirlari = $this->modelOrderRow->where("order_row_status", "sevk_emri")->where("stock_id", $StoktanBul["stock_id"])->findAll();
    if (empty($siparisSatirlari)) {
        echo json_encode(['icon' => 'danger', 'stock_id' => $StoktanBul["stock_id"], 'data' => "Girilen barkoda ait sipariş veya sevk emri bulunamadı"]);
        return;
    }

    $siparisGruplari = [];
    foreach ($siparisSatirlari as $satir) {
        $siparis_id = $satir["order_id"];
        if (!isset($siparisGruplari[$siparis_id])) {
            $siparisGruplari[$siparis_id] = [
                'total' => 0,
                'siparis_id' => $siparis_id,
                'satirlar' => []
            ];
        }
        $siparisGruplari[$siparis_id]['total']++;
        $siparisGruplari[$siparis_id]['satirlar'][] = $satir;
    }



    foreach ($siparisGruplari as $siparis_id => $siparis) {


        // Siparişi çek
        $siparisDetay = $this->modelOrder->where("order_status", "sevk_emri")->where("order_id", $siparis["siparis_id"])->first();
        if ($siparisDetay) {
            $new_order_id = $siparis_id;
            $new_stock_title = $siparis['satirlar'][0]['stock_title'];
            $new_stock_amount = $siparis['satirlar'][0]['stock_amount'];
            $new_stock_date = $siparisDetay["order_date"];
            $new_stock_image = $StoktanBul["default_image"];
            $new_platform_name = $siparisDetay["service_name"];
            $new_order_no = $siparisDetay["order_no"];

            // Kutudaki mevcut satırları güncelle
            $kutuSatirlari = $this->modelBoxRow->where("order_id", $siparis_id)->where("stock_id", $siparis['satirlar'][0]['stock_id'])->first();
            if ($kutuSatirlari) {
               
            
                // Tüm satırlar okundu mu kontrol ediyoruz
                $sonDurum = $this->modelBoxRow
                    ->where("kutu_id", $kutuSatirlari["kutu_id"])
                    ->where("okundu", 0)
                    ->countAllResults();
            
                if ($sonDurum == 0) {
                    $kutu_durumu = $kutuSatirlari["kutu_id"];
                    $order_id = $kutuSatirlari["order_id"];
                }
            }
        }


   


  


        $kutudakiler = $this->modelBox->where("order_id", $new_order_id)->first();

        

        if (!isset($kutudakiler)) {
            $bosta_kutu = $this->modelBox->where("is_empty", 1)->where("aktif", 1)->orderBy("id", "ASC")->first();
            if (!$bosta_kutu) {
                echo json_encode(['icon' => 'info', 'stock_id' => $StoktanBul["stock_id"], 'data' => "<b style='font-size:20px'>Bu ürün farklı bir siparişe aittir. <br> Bu ürüne siparişe devam edebilmek için mevcut kutuyu boşaltmalısınız.</b>"]);
                return;
            }
            $boxData = [
                'order_id' => $new_order_id,
                'platform' => $new_platform_name,
                'order_no' => $new_order_no,
                'is_empty' => 0
            ];
            $this->modelBox->update($bosta_kutu['id'], $boxData);
        } else {
            $bosta_kutu = $this->modelBox->where("order_id", $new_order_id)->orderBy("id", "ASC")->first();
        }

        // Sipariş satırlarını boxes_row tablosuna ekleme
        $toplamSatir = $this->modelOrderRow->where("order_id", $new_order_id)->countAllResults();
        $countBoxRow = $this->modelBoxRow->where("order_id", $new_order_id)->countAllResults();
        $countBoxRowOkundu = $this->modelBoxRow->where("okundu", 1)->where("order_id", $new_order_id)->countAllResults();

        // Tekli siparişlerde hemen kutuyu tamamla
        if ($toplamSatir == 1) {
            // Sipariş için daha önce bir kayıt oluşturulmuş mu kontrol ediyoruz
            $OkutulanVarmi = $this->modelBoxRow->where("order_id", $new_order_id)
                ->where("stock_id", $siparis['satirlar'][0]['stock_id'])
                ->first();
        
            $toplamAdet = $siparis['satirlar'][0]['stock_amount'];
        
            if ($OkutulanVarmi) {
                // Eğer kayıt varsa, okutulan adeti 1 artır ve güncelle
                $okutulanAdet = $OkutulanVarmi['okutulan_adet'] + 1;
        
                // Eğer okutulan adet, toplam adetten büyükse, uyarı mesajı göster ve işlemi durdur
                if ($okutulanAdet > $toplamAdet) {
                    $text = "<b>Bu ürünü daha önce okuttunuz veya ürün adeti kadar okutma yaptınız. <br>  Sipariş Fişini Yazdırınız</b>";
                    echo json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $bosta_kutu['id'], $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]);
                    return;
                }
        
                $this->modelBoxRow->set("okutulan_adet", $okutulanAdet)
                    ->where("boxes_id", $OkutulanVarmi["boxes_id"])
                    ->update();
            } else {
                // Eğer kayıt yoksa, yeni bir kayıt oluştur
                $okutulanAdet = 1;
                $boxRowData = [
                    'kutu_id' => $bosta_kutu['id'],
                    'order_id' => $new_order_id,
                    'stock_id' => $siparis['satirlar'][0]['stock_id'],
                    'adet' => $toplamAdet,
                    'okutulan_adet' => $okutulanAdet,
                    'stock_title' => $siparis['satirlar'][0]['stock_title'],
                    'stock_amount' => $toplamAdet,
                    'stock_image' => $new_stock_image,
                    'order_date' => $new_stock_date,
                    'okundu' => 0 // İlk başta okundu 0 olacak
                ];
                $this->modelBoxRow->save($boxRowData);
            }
        
            if ($okutulanAdet < $toplamAdet) {
                // Eğer okutulan adet, toplam adetten azsa, uyarı mesajı göster
                $kalanAdet = $toplamAdet - $okutulanAdet;
                $text = "Bu Ürünü <b>" . $bosta_kutu['id'] . " Nolu </b> Kutuya Koyunuz ve Okutmaya Devam Ediniz. <strong>AYNI ÜRÜNDEN <b style='color:#024ad0'>" . $kalanAdet . "</b> ADET  DAHA  OKUTUNUZ.</strong>";
                echo json_encode(['icon' => 'info', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $bosta_kutu['id'], 'order_id' => $new_order_id, 'data' => $text]);
            } else {
                // Okundu durumunu güncelle
                if ($OkutulanVarmi) {
                    $this->modelBoxRow->set("okundu", 1)
                        ->where("boxes_id", $OkutulanVarmi["boxes_id"])
                        ->update();
                } else {
                    $this->modelBoxRow->set("okundu", 1)
                        ->where("order_id", $new_order_id)
                        ->update();
                }
        
                $kutu_durumu = $bosta_kutu['id'];
                $text = "Bu Ürüne Ait Siparişin Yazdırılma Ekranına Yönlendiriliyorsunuz.. <br><br> <span style='text-transform:uppercase'><b>$kutu_durumu Nolu Kutu</b> Boşaltılacaktır.</span>";
                echo json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]);
            }
        
            return;
        }
  
        


        // Birden fazla sipariş satırı varsa kontrol
        if ($countBoxRowOkundu >= $toplamSatir) {
            $kutu_durumu = $bosta_kutu['id'];
            $text = "Bu ürünü ve <b>" .$kutu_durumu . " Nolu </b> Kutudaki Ürünleri Alınız. Siparişin Yazdırılma Ekranına  Yönlendiriliyorsunuz.. <br> <br>  <span style='text-transform:uppercase'><b> $kutu_durumu  Nolu Kutu </b> Boşaltılacaktır.</span> ";
            echo json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]);
            return;
        } else {
              // Birden fazla satır olan siparişler için güncelleme
$altSatirlar = $this->modelOrderRow->where("order_id", $new_order_id)->findAll();

foreach ($altSatirlar as $satir_alt) {
    $stokBul = $this->modelStock->where("stock_id", $satir_alt["stock_id"])->first();

    // Daha önce bu stock_id için bir kayıt var mı kontrol et
    $kontrolEt = $this->modelBoxRow->where("order_id", $new_order_id)->where("stock_id", $satir_alt["stock_id"])->first();

    if (!$kontrolEt) {
        // Kayıt yoksa, yeni bir kayıt oluştur
        $boxRowData = [
            'kutu_id' => $bosta_kutu['id'],
            'order_id' => $new_order_id,
            'stock_id' => $satir_alt['stock_id'],
            'stock_title' => $satir_alt['stock_title'],
            'adet' => $satir_alt['stock_amount'],
            'okutulan_adet' => 0, // Başlangıçta okutulan adet 0
            'stock_amount' => $satir_alt['stock_amount'],
            'stock_image' => $stokBul["default_image"],
            'order_date' => $new_stock_date,
            'okundu' => 0 // Başlangıçta okundu 0
        ];
        $this->modelBoxRow->save($boxRowData);
    }

    // Ürün paket mi değil mi kontrol et
    if ($stokBul["paket"] == 1) {
        $okundu = 1;
        $this->modelBoxRow->set('okutulan_adet', 1)
        ->set('okundu', $okundu)
        ->set('paket', $okundu)
        ->where('order_id', $new_order_id)
        ->where('stock_id', $stokBul['stock_id'])
        ->update();
    } 




    



}



$yeniSorgu = $this->modelBoxRow->where("order_id", $new_order_id)->where("stock_id", $StoktanBul["stock_id"])->first();

// Her okutma işleminde okutulan_adeti arttır
$dataToplam =  $yeniSorgu['okutulan_adet'] +  1;

// Eğer okutulan_adet, stock_amount'a eşitse veya geçerse okundu değerini güncelle
if ($dataToplam > $yeniSorgu['stock_amount']) {
    // Okutulan adet, stock_amount'u aştıysa uyarı ver ve işlemi sonlandır
    $text = "Bu ürünü daha önce okuttunuz veya ürün adeti kadar okutma yaptınız.";
    echo json_encode(['icon' => 'info', 'stock_id' => $StoktanBul["stock_id"], 'order_id' => $new_order_id, 'data' => $text]);
    return;
}

if ($yeniSorgu['okundu'] == 1) {
    // Eğer ürün zaten okundu olarak işaretlendiyse uyarı ver ve işlemi sonlandır
    $text = "Bu ürünü daha önce okuttunuz veya ürün adeti kadar okutma yaptınız";
    echo json_encode(['icon' => 'info', 'stock_id' => $StoktanBul["stock_id"], 'order_id' => $new_order_id, 'data' => $text]);
    return;
}

// Okutulan adet, stock_amount'a eşitse okundu'yu 1 yap
if ($dataToplam >= $yeniSorgu['stock_amount']) {
    $okundu_new = 1;
} else {
    $okundu_new = 0;
}

// Kayıtlı satır için okutulan_adet ve okundu değerini güncelle
$this->modelBoxRow->set('okutulan_adet', $dataToplam)
                 ->set('okundu', $okundu_new)
                 ->where('order_id', $new_order_id)
                 ->where('stock_id', $StoktanBul['stock_id']) // Doğru değişken ismiyle güncelleme yapıyoruz
                 ->update();

$countBoxRowOkundum = $this->modelBoxRow->where("okundu", 1)->where("order_id", $new_order_id)->countAllResults();
if ($countBoxRowOkundum >= $toplamSatir) {
    $kutu_durumu = $bosta_kutu['id'];
    $text = "Bu ürünü ve <b>" . $kutu_durumu . " Nolu </b> Kutudaki Ürünleri Alınız. Siparişin Yazdırılma Ekranına Yönlendiriliyorsunuz.. <br> <br>  <span style='text-transform:uppercase'><b> $kutu_durumu Nolu Kutu </b> Boşaltılacaktır.</span> ";
    echo json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]);
} else {
    // Kalan ürün adedine göre mesajı oluştur
    if ($satir_alt['stock_amount'] > 1 && $dataToplam < $satir_alt['stock_amount']) {
        $kalanAdet = $satir_alt['stock_amount'] - $dataToplam;
        $text = "Bu Ürünü <b>" . $bosta_kutu['id'] . " Nolu </b> Kutuya Koyunuz ve Okutmaya Devam Ediniz. Aynı üründen " . $kalanAdet . " adet daha okutunuz.";
    } else {
        $text = "Bu Ürünü <b>" . $bosta_kutu['id'] . " Nolu </b> Kutuya Koyunuz ve Okutmaya Devam Ediniz.";
    }

    echo json_encode(['icon' => 'success',  'stock_id' => $StoktanBul["stock_id"],'kutu_id' => $bosta_kutu['id'], 'order_id' => $new_order_id, 'data' => $text]);
}


}

     
    }
} */






public function getBarcode()
{
    $barkod = $this->request->getPost('barcode');
    $order_id_manuel = $this->request->getPost('order_id_manuel') ?? 0;
    
    // Barkodun uzunluğuna göre farklı sorgu fonksiyonları kullanılıyor.
    if(strlen($barkod) < 13){
        $sorgu = convert_barcode_number_for_sql_production($barkod);
    } else {
        $sorgu = convert_barcode_number_for_sql($barkod);
    }

    $sysmondBarkodlar = $this->modelSysmondBarkodlar->where("barkod", $sorgu)->first();
    if($sysmondBarkodlar){
        $StoktanBul = $this->modelStock->where("stock_id", $sysmondBarkodlar['stock_id'])->first();
    } else {
        // Barkodun veritabanında olup olmadığını kontrol et
        $StoktanBul = $this->modelStock->where("stock_barcode", $sorgu)->first();
    }
  


    if (!$StoktanBul) {

        $this->modelIslem->LogOlustur(
            session()->get('client_id'), 
            session()->get('user_id'), 
            0, 
            'hata',  
            'barkod',
            'Ürün Bulunamadı  Okutulan Barkod:  '.$barkod.' ', 
            session()->get("user_item")["user_adsoyad"],
            json_encode($this->request->getPost())  
        );

        echo json_encode(['icon' => 'danger', 'stock_id' => null, 'data' => "Ürün Bulunamadı <br> <b>Okutulan Barkod:  ".$barkod."  </b>"]);  // Stok_id `null` olarak düzeltildi
        return;
    }

  

    // Sipariş satırlarını al

    $siparisSatirlari = $this->modelOrderRow
    ->select('order_row.*, order.order_date') // İlgili alanları seçiyoruz, order_date ekleniyor
    ->join('order as order', 'order.order_id = order_row.order_id') // modelOrder ile join işlemi yapıyoruz
    ->where("order_row_status", "sevk_emri")
    ->where("stock_id", $StoktanBul["stock_id"])
    ->orderBy("order.order_date", "ASC") // order_date'e göre DESC sıralama yapıyoruz
    ->findAll();
    if (empty($siparisSatirlari)) {
        echo json_encode(['icon' => 'danger', 'stock_id' => $StoktanBul["stock_id"], 'data' => "Girilen barkoda ait sipariş veya sevk emri bulunamadı <br> <b>Okutulan Barkod:  ".$barkod."  </b>"]);

        $this->modelIslem->LogOlustur(
            session()->get('client_id'), 
            session()->get('user_id'), 
            0, 
            'hata',  
            'barkod',
            'Girilen barkoda ait sipariş veya sevk emri bulunamadı  Okutulan Barkod:  '.$barkod.' ', 
            session()->get("user_item")["user_adsoyad"],
            json_encode($this->request->getPost())  
        );

        return;
    }

    // Siparişleri grupla
    $siparisGruplari = [];
    foreach ($siparisSatirlari as $satir) {
        $siparis_id = $satir["order_id"];
        if (!isset($siparisGruplari[$siparis_id])) {
            $siparisGruplari[$siparis_id] = [
                'total' => 0,
                'siparis_id' => $siparis_id,
                'satirlar' => []
            ];
        }
        $siparisGruplari[$siparis_id]['total']++;
        $siparisGruplari[$siparis_id]['satirlar'][] = $satir;
    }

 
    foreach ($siparisGruplari as $siparis_id => $siparis) {
        
        // Siparişi çek
        $siparisDetay = $this->modelOrder->where("order_status", "sevk_emri")->where("order_id", $siparis["siparis_id"])->orderBy("order_date", "ASC")->first();
        if ($siparisDetay) {
            $new_order_id = $siparis_id;
            $new_stock_title = $siparis['satirlar'][0]['stock_title'];
            $new_stock_amount = $siparis['satirlar'][0]['stock_amount'];
            $new_stock_date = $siparisDetay["order_date"];
            $new_stock_image = $StoktanBul["default_image"];
            $new_platform_name = $siparisDetay["service_name"];
            $new_order_no = $siparisDetay["order_no"];

            // Kutudaki mevcut satırları güncelle
            $kutuSatirlari = $this->modelBoxRow->where("order_id", $siparis_id)->where("stock_id", $siparis['satirlar'][0]['stock_id'])->first();
            if ($kutuSatirlari) {
                // Tüm satırlar okundu mu kontrol ediyoruz
                $sonDurum = $this->modelBoxRow
                    ->where("kutu_id", $kutuSatirlari["kutu_id"])
                    ->where("okundu", 0)
                    ->countAllResults();
            
                if ($sonDurum == 0) {
                    $kutu_durumu = $kutuSatirlari["kutu_id"];
                    $order_id = $kutuSatirlari["order_id"];
                }
            }
        }

        if(isset($order_id_manuel) && $order_id_manuel != 0){
            $new_order_id = $order_id_manuel;
        }

        // Kutunun mevcut durumu kontrol ediliyor
        $kutudakiler = $this->modelBox->where("order_id", $new_order_id)->first();
        
        if (!isset($kutudakiler)) {
            // Eğer kutu boşsa veya siparişle ilişkili değilse, yeni kutu aranıyor
            $bosta_kutu = $this->modelBox->where("is_empty", 1)->where("aktif", 1)->orderBy("id", "ASC")->first();
            if (!$bosta_kutu) {
                // Eğer boş bir kutu yoksa kullanıcıya bilgilendirme yapılıyor
                echo json_encode(['icon' => 'info', 'stock_id' => $StoktanBul["stock_id"], 'data' => "<b style='font-size:20px'>Bu ürün farklı bir siparişe aittir. <br> Bu ürüne siparişe devam edebilmek için mevcut kutuyu boşaltmalısınız.</b> "]);
                return;
            }
            
            // Kutunun bilgileri güncelleniyor
            $boxData = [
                'order_id' => $new_order_id,
                'platform' => $new_platform_name,
                'order_no' => $new_order_no,
                'is_empty' => 0
            ];
            $this->modelBox->update($bosta_kutu['id'], $boxData);
        } else {
            // Eğer kutu zaten mevcutsa, aynı kutu ile devam ediliyor
            $bosta_kutu = $this->modelBox->where("order_id", $new_order_id)->orderBy("id", "ASC")->first();
        }

        // Sipariş satırlarını boxes_row tablosuna ekleme
        $toplamSatir = $this->modelOrderRow->where("order_id", $new_order_id)->countAllResults();
    
        $countBoxRow = $this->modelBoxRow->where("order_id", $new_order_id)->countAllResults();
        $countBoxRowOkundu = $this->modelBoxRow->where("okundu", 1)->where("order_id", $new_order_id)->countAllResults();

        // Tekli siparişlerde kutuyu tamamla
        if ($toplamSatir == 1) {
            // Eğer sipariş daha önce kaydedilmişse kontrol et
            $OkutulanVarmi = $this->modelBoxRow->where("order_id", $new_order_id)
                ->where("stock_id", $siparis['satirlar'][0]['stock_id'])
                ->first();
        
            $toplamAdet = $siparis['satirlar'][0]['stock_amount'];
        
            if ($OkutulanVarmi) {
                // Eğer kayıt varsa okutulan adet 1 artırılır ve güncellenir
                $okutulanAdet = $OkutulanVarmi['okutulan_adet'] + 1;
        
                // Eğer okutulan adet toplam adetten büyükse, uyarı gösterilir
                if ($okutulanAdet > $toplamAdet) {
                    $text = "<b>Bu ürünü daha önce okuttunuz veya ürün adeti kadar okutma yaptınız. <br>  Sipariş Fişini Yazdırınız</b>";
                    echo json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $bosta_kutu['id'], 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]);
                   

                   /* 
                    $this->modelIslem->LogOlustur(
                        session()->get('client_id'), 
                        session()->get('user_id'), 
                        $new_order_id, 
                        'ok',  
                        'siparis',
                        'Bu ürünü daha önce okuttunuz veya ürün adeti kadar okutma yaptınız.  Sipariş Fişini Yazdırınız  Okutulan Barkod:  '.$barkod.' ', 
                        session()->get("user_item")["user_adsoyad"],
                        json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $bosta_kutu['id'], 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text])  
                    );
                   */

                    $this->modelIslem->LogOlustur(
                        session()->get('client_id'), 
                        session()->get('user_id'), 
                        $new_order_id, 
                        'ok',  
                        'barkod',
                        "Bu ürünü daha önce okuttunuz veya ürün adeti kadar okutma yaptınız.  Sipariş Fişini Yazdırınız  Okutulan Barkod:  '.$barkod.'", 
                        session()->get("user_item")["user_adsoyad"],
                        json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $bosta_kutu['id'], 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]),
                        0,
                        $new_order_id,
                        0,
                        0
                    );

                    

                    return;

                }
        
                $this->modelBoxRow->set("okutulan_adet", $okutulanAdet)
                    ->where("boxes_id", $OkutulanVarmi["boxes_id"])
                    ->update();
            } else {
                // Eğer kayıt yoksa yeni bir kayıt oluştur
                $okutulanAdet = 1;
                $boxRowData = [
                    'kutu_id' => $bosta_kutu['id'],
                    'order_id' => $new_order_id,
                    'stock_id' => $siparis['satirlar'][0]['stock_id'],
                    'adet' => $toplamAdet,
                    'okutulan_adet' => $okutulanAdet,
                    'stock_title' => $siparis['satirlar'][0]['stock_title'],
                    'stock_amount' => $toplamAdet,
                    'stock_image' => $new_stock_image,
                    'order_date' => $new_stock_date,
                    'okundu' => 0 // İlk başta okundu 0 olacak
                ];
                $this->modelBoxRow->save($boxRowData);
            }
        
            if ($okutulanAdet < $toplamAdet) {
                // Eğer okutulan adet toplam adetten azsa uyarı gösterilir
                $kalanAdet = $toplamAdet - $okutulanAdet;
                $text = "Bu Ürünü <b>" . $bosta_kutu['id'] . " Nolu </b> Kutuya Koyunuz ve Okutmaya Devam Ediniz. <strong>AYNI ÜRÜNDEN <b style='color:#024ad0'>" . $kalanAdet . "</b> ADET DAHA OKUTUNUZ.</strong>";
                echo json_encode(['icon' => 'info', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $bosta_kutu['id'], 'order_id' => $new_order_id, 'data' => $text]);
              


                $this->modelIslem->LogOlustur(
                    session()->get('client_id'), 
                    session()->get('user_id'), 
                    $new_order_id, 
                    'ok',  
                    'barkod',
                    'Bu Ürünü <b>1  Nolu </b> Kutuya Koyunuz ve Okutmaya Devam Ediniz. <strong>AYNI ÜRÜNDEN <b style="color:#024ad0">' . $kalanAdet . '</b> ADET DAHA OKUTUNUZ.</strong> Okutulan Barkod:  '.$barkod.' ', 
                    session()->get("user_item")["user_adsoyad"],
                    json_encode(['icon' => 'info', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $bosta_kutu['id'], 'order_id' => $new_order_id, 'data' => $text]),
                    0,
                    $new_order_id,
                    0,
                    0
                );

            } else {
                // Okundu durumu güncellenir
                if ($OkutulanVarmi) {
                    $this->modelBoxRow->set("okundu", 1)
                        ->where("boxes_id", $OkutulanVarmi["boxes_id"])
                        ->update();
                } else {
                    $this->modelBoxRow->set("okundu", 1)
                        ->where("order_id", $new_order_id)
                        ->update();
                }
        
                $kutu_durumu = $bosta_kutu['id'];
                $text = "Bu Ürüne Ait Siparişin Yazdırılma Ekranına Yönlendiriliyorsunuz.. <br><br> <span style='text-transform:uppercase'><b>$kutu_durumu Nolu Kutu</b> Boşaltılacaktır.</span>";
                echo json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]);
                
            

                $this->modelIslem->LogOlustur(
                    session()->get('client_id'), 
                    session()->get('user_id'), 
                    $new_order_id, 
                    'ok',  
                    'barkod',
                    'Bu Ürüne Ait Siparişin Yazdırılma Ekranına Yönlendiriliyorsunuz.. ', 
                    session()->get("user_item")["user_adsoyad"],
                    json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]),
                    0,
                    $new_order_id,
                    0,
                    0
                );


                return;
            }
        
            return;
        }

        $countBoxRows = $this->modelBoxRow->where("order_id", $new_order_id)->findAll();

   
       
      

        // Birden fazla sipariş satırı varsa kontrol
   
           
            $altSatirlar = $this->modelOrderRow->where("order_id", $new_order_id)->findAll();

// Gruplamak için boş bir dizi oluşturuyoruz
$stokGruplari = [];

foreach ($altSatirlar as $satir_alt) {
    $stokBul = $this->modelStock->where("stock_id", $satir_alt["stock_id"])->first();

    // Eğer stock_amount alanı mevcutsa, işleme devam ediyoruz
    if (isset($satir_alt['stock_amount'])) {
        // Eğer stok_id daha önce eklenmişse, adeti topluyoruz
        if (isset($stokGruplari[$satir_alt['stock_id']])) {
            $stokGruplari[$satir_alt['stock_id']]['adet'] += $satir_alt['stock_amount'];  // Adetleri topluyoruz
        } else {
            // Eğer ilk kez ekleniyorsa, yeni bir grup oluşturuyoruz
            $stokGruplari[$satir_alt['stock_id']] = [
                'stock_id' => $satir_alt['stock_id'],
                'stock_title' => $stokBul['stock_title'],
                'adet' => $satir_alt['stock_amount'],  // İlk adeti kaydediyoruz
                'stock_image' => $stokBul['default_image'], // Görsel ve diğer bilgileri ekleyebilirsiniz
                'stock_code' => $stokBul['stock_code'], // Stok kodu gibi diğer bilgileri ekleyebilirsiniz
                'paket' => $stokBul['paket'] // Paket olup olmadığını ekliyoruz
            ];
        }
    }
}


// Gruplanmış stoklar üzerinde güncelleme yapıyoruz
foreach ($stokGruplari as $stock_id => $stokData) {
    // Daha önce bu stock_id için bir kayıt var mı kontrol et
    $kontrolEt = $this->modelBoxRow->where("order_id", $new_order_id)
                                   ->where("stock_id", $stock_id)
                                   ->first();

    if (!$kontrolEt) {
        // Kayıt yoksa, yeni bir kayıt oluştur
        $boxRowData = [
            'kutu_id' => $bosta_kutu['id'],
            'order_id' => $new_order_id,
            'stock_id' => $stock_id,
            'stock_title' => $stokData['stock_title'],
            'adet' => $stokData['adet'],
            'okutulan_adet' => 0, // Başlangıçta okutulan adet 0
            'stock_amount' => $stokData['adet'], // Toplam adet
            'stock_image' => $stokData['stock_image'],
            'order_date' => $new_stock_date,
            'okundu' => 0, // Başlangıçta okundu 0
            'paket' => $stokData['paket'] // Paket bilgisi ekleniyor
        ];
        $this->modelBoxRow->save($boxRowData);
    } 

    // Ürün paket mi değil mi kontrol et
    if ($stokData["paket"] == 1) {
        $okundu = 1;
        $this->modelBoxRow->set('okutulan_adet', 1)
                          ->set('okundu', $okundu)
                          ->set('paket', $okundu)
                          ->where('order_id', $new_order_id)
                          ->where('stock_id', $stock_id)
                          ->update();
    }
}
            
            // Satır bazında okutma durumu kontrol
            $yeniSorgu = $this->modelBoxRow->where("order_id", $new_order_id)->where("stock_id", $StoktanBul["stock_id"])->first();
      
            

            $dataToplam = $yeniSorgu['okutulan_adet'] + 1;


            // Her okutma işleminde okutulan_adeti arttır
           
            // Eğer okutulan_adet, stock_amount'a eşitse veya geçerse okundu değerini güncelle
           /* 
            if ($dataToplam > $yeniSorgu['stock_amount']) {
                // Okutulan adet, stock_amount'u aştıysa uyarı ver ve işlemi sonlandır
                $text = "Bu ürünü daha önce okuttunuz veya ürün adeti kadar okutma yaptınız.";
                echo json_encode(['icon' => 'info', 'stock_id' => $StoktanBul["stock_id"], 'order_id' => $new_order_id, 'data' => $text]);
                return;
            }

            if ($yeniSorgu['okundu'] == 1) {
                // Eğer ürün zaten okundu olarak işaretlendiyse uyarı ver ve işlemi sonlandır
                $text = "Bu ürünü daha önce okuttunuz veya ürün adeti kadar okutma yaptınız";
                echo json_encode(['icon' => 'info', 'stock_id' => $StoktanBul["stock_id"], 'order_id' => $new_order_id, 'data' => $text]);
                return;
            }
           */

           if ($dataToplam > $yeniSorgu['stock_amount']) {

 

   
            if ($countBoxRowOkundu >= $countBoxRow) {
                $kutu_durumu = $bosta_kutu['id'];
                $text = "<font style='display: block; font-size: 19px; font-weight: bold; font-family: monospace; text-transform: uppercase;'>Bu ürünü ve <b>" .$kutu_durumu . " Nolu </b>  Kutudaki Ürünleri Alınız. Siparişin Yazdırılma Ekranına  Yönlendiriliyorsunuz.. <br> <br>  <span style='text-transform:uppercase'><b> $kutu_durumu  Nolu Kutu </b> Boşaltılacaktır.</span> </font>";
                echo json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]);
               
           



                $this->modelIslem->LogOlustur(
                    session()->get('client_id'), 
                    session()->get('user_id'), 
                    $new_order_id, 
                    'ok',  
                    'barkod',
                    ' Bu ürünü ve <b>1 Nolu </b>  Kutudaki Ürünleri Alınız. <br> Siparişin Yazdırılma Ekranına Yönlendiriliyorsunuz  <br> Okutulan Barkod:  <b>'.$barkod.' </b>', 
                    session()->get("user_item")["user_adsoyad"],
                    json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]) ,
                    0,
                    $new_order_id,
                    0,
                    0
                );
                
                return;
            }else{

                 // Okutulan adet, stock_amount'u aştıysa uyarı ver ve işlemi sonlandır
            $text = "<font style='display: block; font-size: 19px; font-weight: bold; font-family: monospace; text-transform: uppercase;'>Bu ürünü daha önce okuttunuz veya ürün adeti kadar okutma yaptınız.</font>";
            echo json_encode(['icon' => 'tekrar_stok', 'title' =>'Bilgilendirme', 'stock_id' => $StoktanBul["stock_id"], 'order_id' => $new_order_id, 'data' => $text]);
            
         

          
            $this->modelIslem->LogOlustur(
                session()->get('client_id'), 
                session()->get('user_id'), 
                $new_order_id, 
                'ok',  
                'barkod',
                'Bu ürünü daha önce okuttunuz veya ürün adeti kadar okutma yaptınız. Okutulan Barkod:  '.$barkod.' ', 
                session()->get("user_item")["user_adsoyad"],
                json_encode(['icon' => 'tekrar_stok', 'title' =>'Bilgilendirme', 'stock_id' => $StoktanBul["stock_id"], 'order_id' => $new_order_id, 'data' => $text]),
                0,
                $new_order_id,
                0,
                0
            );

            
            return; // İşlemi sonlandır
            }
           
        }

            // Okutulan adet, stock_amount'a eşitse okundu'yu 1 yap
            if ($dataToplam >= $yeniSorgu['stock_amount']) {
                $okundu_new = 1;
            } else {
                $okundu_new = 0;
            }

            // Kayıtlı satır için okutulan_adet ve okundu değerini güncelle
            $this->modelBoxRow->set('okutulan_adet', $dataToplam)
                            ->set('okundu', $okundu_new)
                            ->where('order_id', $new_order_id)
                            ->where('stock_id', $StoktanBul['stock_id']) // Doğru değişken ismiyle güncelleme yapıyoruz
                            ->update();

                       
            // Kutudaki tüm satırların okunup okunmadığını kontrol et
            $countBoxRowOkundum = $this->modelBoxRow->where("okundu", 1)->where("order_id", $new_order_id)->countAllResults();
            $toplamKacSatir = $this->modelBoxRow->where("order_id", $new_order_id)->countAllResults();

      

            if ($countBoxRowOkundum >= $toplamKacSatir) {
                $kutu_durumu = $bosta_kutu['id'];
                $text = "<font style='display: block; font-size: 19px; font-weight: bold; font-family: monospace; text-transform: uppercase;'>Bu ürünü ve <b>" . $kutu_durumu . " Nolu </b>  Kutudaki Ürünleri Alınız. Siparişin Yazdırılma Ekranına Yönlendiriliyorsunuz.. <br> <br>  <span style='text-transform:uppercase'><b> $kutu_durumu Nolu Kutu </b> Boşaltılacaktır.</span> </font>";
                echo json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]);
               
               
              

            $this->modelIslem->LogOlustur(
                session()->get('client_id'), 
                session()->get('user_id'), 
                $new_order_id, 
                'ok',  
                'barkod',
                'Bu ürünü ve <b>1 Nolu </b>  Kutudaki Ürünleri Alınız. <br> Siparişin Yazdırılma Ekranına Yönlendiriliyorsunuz   <br> Okutulan Barkod:  <b>'.$barkod.' </b>', 
                session()->get("user_item")["user_adsoyad"],
                json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]),                0,
                $new_order_id,
                0,
                0
            );

               
                return;
            } else {
                if ($countBoxRowOkundu >= $toplamKacSatir) {
                    $kutu_durumu = $bosta_kutu['id'];
                    $text = "<font style='display: block; font-size: 19px; font-weight: bold; font-family: monospace; text-transform: uppercase;'>Bu ürünü ve <b>" .$kutu_durumu . " Nolu </b>   Kutudaki Ürünleri Alınız. Siparişin Yazdırılma Ekranına  Yönlendiriliyorsunuz.. <br> <br>  <span style='text-transform:uppercase'><b> $kutu_durumu  Nolu Kutu </b> Boşaltılacaktır.</span> </font> ";
                    echo json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]);
                    
          
                    

                $this->modelIslem->LogOlustur(
                    session()->get('client_id'), 
                    session()->get('user_id'), 
                    $new_order_id, 
                    'ok',  
                    'barkod',
                    'Bu ürünü ve <b>1 Nolu </b>  Kutudaki Ürünleri Alınız. <br> Siparişin Yazdırılma Ekranına Yönlendiriliyorsunuz  <br> Okutulan Barkod:  <b>'.$barkod.' </b>', 
                    session()->get("user_item")["user_adsoyad"],
                    json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]),     
                    $new_order_id,
                    0,
                    0
                );

                    return;
                }else{

                    $modelDenBul = $this->modelBoxRow->where("stock_id", $StoktanBul["stock_id"])->where("order_id", $new_order_id)->first();
                        // Kalan ürün adedine göre mesaj oluşturuluyor
                        if ($modelDenBul['stock_amount'] > 1 && $dataToplam < $modelDenBul['stock_amount']) {
                            $kalanAdet = $modelDenBul['stock_amount'] - $dataToplam;
                            
                            // Eğer kalan adet varsa, mesajda kalan adet bilgisi veriliyor
                            if ($kalanAdet > 0) {
                                $text = "<font style='display: block; font-size: 19px; font-weight: bold; font-family: monospace; text-transform: uppercase;'>Bu Ürünü <b style='color:red'><span class='' style='color: #014ad0; margin-top: -4px; font-size: 20px; padding: 5px; font-weight: bold; font-family: monospace;'> " . $bosta_kutu['id'] . " Nolu</span>  </b> Kutuya Koyunuz ve Okutmaya Devam Ediniz. <br> <br>Aynı üründen <b style='color:red'><span class='' style='color: #014ad0; margin-top: -4px; font-size: 20px; padding: 5px; font-weight: bold; font-family: monospace;'>" . $kalanAdet . "</span></b> adet daha okutunuz.</font>";
                            }
                        } else {
                            // Tüm adetler okutulmuşsa, standart mesaj
                            $text = "<font style='display: block; font-size: 19px; font-weight: bold; font-family: monospace; text-transform: uppercase;'> Bu Ürünü <b>" . $bosta_kutu['id'] . " Nolu </b>  Kutuya Koyunuz ve Okutmaya Devam Ediniz.  </font>";
                        }


                              
         

                $this->modelIslem->LogOlustur(
                    session()->get('client_id'), 
                    session()->get('user_id'), 
                    $new_order_id, 
                    'ok',  
                    'barkod',
                    'Bu Ürünü <b>' . $bosta_kutu['id'] . ' Nolu </b>  Kutuya Koyunuz ve Okutmaya Devam Ediniz <br> Okutulan Barkod: <b> '.$barkod.' </b>', 
                    session()->get("user_item")["user_adsoyad"],
                    json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $bosta_kutu['id'], 'order_id' => $new_order_id, 'data' => $text]),     
                    $new_order_id,
                    0,
                    0
                );

                    echo json_encode(['icon' => 'success', 'stock_id' => $StoktanBul["stock_id"], 'kutu_id' => $bosta_kutu['id'], 'order_id' => $new_order_id, 'data' => $text]);
                    return;
                }
               
            }
        
    }
}





public function kutuyuBosalt(){

    $data = [
        'order_id' => '',
        'content'  => '',
        'platform' => '',
        'order_no' => '',
        'is_empty' => 1,
    ];

    $modelBoxs = $this->modelBox->where("kutu_id", 1)->first();

    if($modelBoxs["order_id"]){
    
        $this->modelIslem->LogOlustur(
            session()->get('client_id'), 
            session()->get('user_id'), 
            $modelBoxs["order_id"], 
            'ok',  
            'barkod',
           'Manuel Olarak Kutu Boşaltıldı Siparişi Okutma Durduruldu',
            session()->get("user_item")["user_adsoyad"],
            json_encode($modelBoxs),     
            $modelBoxs["order_id"], 
            0,
            0
        );
    
    }
                     
   
    $modelBox = $this->modelBox->set($data)->where("kutu_id", 1)->update();

    if($modelBox){

        $delete = $this->modelBoxRow->where("kutu_id", 1)->delete();

        if($delete){

            


            echo json_encode(['icon' => 'success',  'data' => "Kutu Başarıyla Boşaltıldı"]);

        }else{
            echo json_encode(['icon' => 'danger',  'data' => "Bir Hata Oluştu"]);

        }

    }else{
        echo json_encode(['icon' => 'danger',  'data' => "Bir Hata Oluştu"]);

    }
    


}




    /* 
    
    public function getBarcode()
    {
        $barkod = $this->request->getPost('barcode');


        $sorgu = convert_barcode_number_for_sql($barkod);

   
    
        // Barkodun veritabanında olup olmadığını kontrol et
        $StoktanBul = $this->modelStock->where("stock_barcode", $sorgu)->first();
        if (!$StoktanBul) {
            echo json_encode(['icon' => 'danger', 'data' => "Ürün Bulunamadı"]);
            return;
        }
    
        // Sipariş satırlarını al
        $siparisSatirlari = $this->modelOrderRow->where("order_row_status", "sevk_emri")->where("stock_id", $StoktanBul["stock_id"])->findAll(); 
        if (empty($siparisSatirlari)) {
            echo json_encode(['icon' => 'danger', 'data' => "Girilen barkoda ait sipariş veya sevk emri bulunamadı"]);
            return;
        }
    
        $new_order_id = "";
        $new_stock_title = "";
        $new_stock_amount = "";
        $new_stock_date = "";
        $new_stock_image = "";
        $new_platform_name = "";
        $new_order_no = "";
    
        foreach ($siparisSatirlari as $satir) {
            if ($satir["stock_id"] == $StoktanBul["stock_id"]) {
                $siparis = $this->modelOrder->where("order_status", "sevk_emri")->where("order_id", $satir["order_id"])->first();
                if ($siparis) {
                    $new_order_id = $satir["order_id"];
                    $new_stock_title = $satir["stock_title"];
                    $new_stock_amount = $satir["stock_amount"];
                    $new_stock_date = $siparis["order_date"];
                    $new_stock_image = $StoktanBul["default_image"];
                    $new_platform_name = $siparis["service_name"];
                    $new_order_no = $siparis["order_no"];
                }
            }
    
            // Kutudaki mevcut satırları güncelle
            $kutuSatirlari = $this->modelBoxRow->where("order_id", $satir["order_id"])->where("stock_id", $satir["stock_id"])->first();
            if ($kutuSatirlari) {
                $this->modelBoxRow->set("okundu", 1)->where("boxes_id", $kutuSatirlari["boxes_id"])->update();
                $sonDurum = $this->modelBoxRow->where("kutu_id", $kutuSatirlari["kutu_id"])->where("okundu", 0)->countAllResults();
                if ($sonDurum == 0) {
                    $kutu_durum = $kutuSatirlari["kutu_id"];
                    $order_id = $kutuSatirlari["order_id"];
                }
            }
        }
    
        // Boş kutu bulma
        $kutudakiler = $this->modelBox->where("order_id", $new_order_id)->first();
    
        if (!isset($kutudakiler)) {
            $bosta_kutu = $this->modelBox->where("is_empty", 1)->orderBy("id", "ASC")->first();
            if (!$bosta_kutu) {
                echo json_encode(['icon' => 'danger', 'data' => "Boş kutu bulunamadı"]);
                return;
            }
            $boxData = [
                'order_id' => $new_order_id,
                'platform' => $new_platform_name,
                'order_no' => $new_order_no,
                'is_empty' => 0
            ];
            $this->modelBox->update($bosta_kutu['id'], $boxData);
        } else {
            $bosta_kutu = $this->modelBox->where("order_id", $new_order_id)->orderBy("id", "ASC")->first();
        }
    
        // Sipariş satırlarını boxes_row tablosuna ekleme
        $toplamSatir = $this->modelOrderRow->where("order_id", $new_order_id)->countAllResults();
        $countBoxRow = $this->modelBoxRow->where("order_id", $new_order_id)->countAllResults();
    
        // Tekli siparişlerde hemen kutuyu tamamla
        if ($toplamSatir == 1) {
            $boxRowData = [
                'kutu_id' => $bosta_kutu['id'],
                'order_id' => $new_order_id,
                'stock_id' => $satir['stock_id'],
                'stock_title' => $satir['stock_title'],
                'stock_amount' => $satir['stock_amount'],
                'stock_image' => $new_stock_image,
                'order_date' => $new_stock_date,
                'okundu' => 0
            ];
            $this->modelBoxRow->save($boxRowData);
            $kutu_durumu = $bosta_kutu['id'];

            $text = "<b>" .$kutu_durumu . " Nolu </b> Kutu Tamamlanmıştır. Siparişin Yazdırılması İçin Yönlendiriliyorsunuz.. <br> <br>  <span style='text-transform:uppercase'><b> $kutu_durumu  Nolu Kutu </b> Boşaltılacaktır.</span> ";
            echo json_encode(['icon' => 'success', 'kutu_id' => $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]);
    
            return;
        }
    
        // Birden fazla sipariş satırı varsa kontrol
        if ($countBoxRow >= $toplamSatir) {
            $kutu_durumu = $bosta_kutu['id'];
            $text = "<b>" .$kutu_durumu . " Nolu </b> Kutu Tamamlanmıştır. Siparişin Yazdırılması İçin Yönlendiriliyorsunuz.. <br> <br>  <span style='text-transform:uppercase'><b> $kutu_durumu  Nolu Kutu </b> Boşaltılacaktır.</span> ";
            echo json_encode(['icon' => 'success', 'kutu_id' => $kutu_durumu, 'yazdir' => 1, 'order_id' => $new_order_id, 'data' => $text]);
            return;
        } else {

            $altSatirlar = $this->modelOrderRow->where("order_id", $new_order_id)->findAll();

            foreach($altSatirlar as $satir_alt){
                $stokBul = $this->modelStock->where("stock_id", $satir_alt["stock_id"])->first();
                if($satir_alt["stock_id"] == $satir['stock_id']){
                    $okundu = 1;
                }else{
                    $okundu = 0;
                }
                $boxRowData = [
                    'kutu_id' => $bosta_kutu['id'],
                    'order_id' => $new_order_id,
                    'stock_id' => $satir_alt['stock_id'],
                    'stock_title' => $satir_alt['stock_title'],
                    'stock_amount' => $satir_alt['stock_amount'],
                    'stock_image' => $stokBul["default_image"],
                    'order_date' => $new_stock_date,
                    'okundu' => $okundu
                ];
                $this->modelBoxRow->save($boxRowData);
            }

            
        }
    
        $text = "<b>" .$bosta_kutu['id'] . " Nolu </b> Kutu Güncellenmiştir";
        echo json_encode(['icon' => 'success', 'kutu_id' => $bosta_kutu['id'], 'order_id' => $new_order_id, 'data' => $text]);
        return;
    }
    
    */
    
    
    


    
    
private function findEmptyBox()
{
    // Tüm kutuları çek
    $boxes = $this->modelBox->findAll();
    
    foreach ($boxes as $box) {
        // Eğer kutu boşsa
        if ($box['is_empty'] == 1) {
            return $box['kutu_id']; // Boş kutunun ID'sini döndür
        }
    }
    
    // Eğer hiçbir boş kutu bulunamazsa
    return null;
}
    
   
    
    
    /* 
       public function getBarcode()
    {
        $barkod = $this->request->getPost('barcode');
        
        // Barkoda göre stok bilgisini al
        $StoktanBul = $this->modelStock->where("stock_barcode", $barkod)->first();
      
        if ($StoktanBul) {
            // Stok ID'ye göre order_row bilgilerini al
            $Satirlars = $this->modelOrderRow->where("stock_id", $StoktanBul["stock_id"])->findAll();
            
            if(!$Satirlars){
                echo json_encode(['icon' => 'danger', 'data' => "Girilen barkoda ait sipariş bulunamadı"]);
            } else {
                $html = '';
    
                $siparisGruplari = [];
              
                foreach($Satirlars as $satir) {
                    // order_id'ye göre sipariş bilgilerini al
                    $order_id = $satir["order_id"];
                    if (!isset($siparisGruplari[$order_id])) {
                        $Siparisler = $this->modelOrder->where("order_id", $order_id)->first();
                        if ($Siparisler) {
                            $siparisGruplari[$order_id]['siparis'] = $Siparisler;
                        }
                    }
                    $satirlar = $this->modelOrderRow->where("order_id", $Siparisler["order_id"])->findAll();
                    $siparisGruplari[$order_id]['satirlar'] = $satirlar;
    
    
                }
    
                $index = 0;
                foreach($siparisGruplari as $siparisId => $siparisGrup) {
                    if (!isset($siparisGrup['siparis'])) {
                        continue; // Eğer sipariş bilgisi yoksa, geç
                    }
                    $Siparisler = $siparisGrup['siparis'];
                    $Satirlar = $siparisGrup['satirlar'];
    
               
    
                    // Platform bilgisini HTML içeriğinden ayır
                    $text = $Siparisler['b2b'];
                    $doc = new DOMDocument();
                    libxml_use_internal_errors(true); // HTML ayrıştırma hatalarını göz ardı et
                    $doc->loadHTML($text);
                    libxml_clear_errors();
            
                    $xpath = new DOMXPath($doc);
                    $platformNodes = $xpath->query("//b/span");
    
                    if ($platformNodes->length > 0) {
                        $platform = trim($platformNodes->item(0)->textContent);
                    } else {
                        $platform = '';
                    }
                    


                    switch ($Siparisler['order_status']) {
                        case 'new':
                            $statusText = 'Yeni Sipariş';
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
                        case 'failed':
                            $statusText = 'İptal';
                            $statusTextColor = 'text-danger';
                            $statusBgColor = 'bg-danger';
                            break;
                    }
                    // Collapse yapısı oluşturma
                    $html .= '<div class="accordion" id="siparisAccordion' . $index . '" style="margin-bottom:10px;">';
                    $html .= '<div class="accordion-item">';
                    $html .= '    <h2 class="accordion-header" id="heading' . $index . '">';
                    $html .= '        <button class="accordion-button ' . ($index == 0 ? '' : 'collapsed') . '" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $index . '" aria-expanded="' . ($index == 0 ? 'true' : 'false') . '" aria-controls="collapse' . $index . '">';
                    $html .= '            <div> Platform: &nbsp;<b style="text-transform:uppercase;"> ' . $platform . '</b> &nbsp; - &nbsp; Sipariş Numarası: &nbsp; <b>' . $Siparisler['order_no'] . '</b></div>  &nbsp; &nbsp;   <label class=" badge    '.$statusTextColor.' ">'.$statusText.'</label>';
                    $html .= '        </button>';
                    $html .= '    </h2>';
                    $html .= '    <div id="collapse' . $index . '" class="accordion-collapse collapse ' . ($index == 0 ? 'show' : '') . '" aria-labelledby="heading' . $index . '" data-bs-parent="#siparisAccordion' . $index . '">';
                    $html .= '        <div class="accordion-body">';
    
                    // Her bir sipariş satırını içeren HTML bloğunu oluştur
                    foreach($Satirlar as $satir) {
                        // Eşleşen stok_id için border ekle
                        $borderClass = '';
                        if ($satir['stock_id'] == $StoktanBul['stock_id']) {
                            $borderClass = 'padding-top:10px; border: 1px solid #ddebfe;'; // İstediğiniz border rengini burada belirtebilirsiniz
                        }else{
                            $borderClass = 'padding-top:0px; border-bottom: 1px solid #dddddd7a;'; // İstediğiniz border rengini burada belirtebilirsiniz
                        }
    
                        $html .= '<div class="row mb-2 mt-2 nowrap ' . $borderClass . '" style=" padding-bottom:10px; '.$borderClass.' ">';
                        $html .= '    <div class="col-3 col-sm-2 col-md-2 col-lg-2 tdPhoto">';
                        $html .= '        <a class="gallery-image popup-image" href="' . $StoktanBul["default_image"] . '">';
                        $html .= '            <img style="height:100px" src="' . $StoktanBul["default_image"] . '" alt="" class="img-fluid">';
                        $html .= '        </a>';
                        $html .= '    </div>';
                        $html .= '    <div class="col-9 col-sm-7 col-md-5 col-lg-10 col-m-left">';
                        $html .= '        <ul class="urunBilgileri list-unstyled" style="height: 100%;">';
                        $html .= '            <li>';
                        $html .= '                <span>Tarih:</span>';
                        $html .= '                <span><b>' . date("d/m/Y h:i", strtotime($satir['created_at'])) . '</b></span>';
                        $html .= '            </li>';
                        $html .= '            <li>';
                        $html .= '                <span>Ürün Adı:</span>';
                        $html .= '                <span><b>' . $satir['dopigo_title'] . '</b></span>';
                        $html .= '            </li>';
                        $html .= '            <li>';
                        $html .= '                <span>Adet:</span>';
                        $html .= '                <span><b>' . number_format($satir['stock_amount'], 2, ',', '.') . '</b></span>';
                        $html .= '            </li>';
                        $html .= '        </ul>';
                        $html .= '    </div>';
                        $html .= '</div>';
                    }
    
                    $html .= '        </div>'; // accordion-body
                    $html .= '    </div>'; // accordion-collapse
                    $html .= '</div>'; // accordion-item
                    $html .= '</div>'; // accordion
    
                    $index++;
                }
    
                echo json_encode(['icon' => 'success', 'data' => $html]);
            }
        } else {
            echo json_encode(['icon' => 'danger', 'data' => "Ürün Bulunamadı"]);
        }
    }
    */
    
    

    
    
    








}