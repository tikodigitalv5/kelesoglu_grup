<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\API\ResponseTrait;
use \Hermawan\DataTables\DataTable;
use App\Models\TikoERP\MoneyUnitModel;

ini_set('memory_limit', '512M'); // Bellek limitini geçici olarak 256MB yap

class Report extends BaseController
{
    private $DatabaseConfig;
    private $currentDB;

    private $modelInvoice;
    private $logClass;
    private $modelCari;

    private $modelStock;
    private $modelSubstock;
    private $modelType;
    private $modelUnit;
    private $modelStockRecipe;
    private $modelRecipeItem;
    private $modelMoneyUnit;
    private $modelWarehouse;
    private $modelStockMovement;
    private $modelStockBarcode;
    private $modelFinancialMovement;
    private $modelInvoiceRow;
    private $modelGider;
    

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);
        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
        $this->modelInvoice = model($TikoERPModelPath . '\InvoiceModel', true, $db_connection);
        $this->modelInvoiceRow = model($TikoERPModelPath . '\InvoiceRowModel', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath . '\StockModel', true, $db_connection);
        $this->modelSubstock = model($TikoERPModelPath . '\SubstockModel', true, $db_connection);
        $this->modelType = model($TikoERPModelPath . '\TypeModel', true, $db_connection);
        $this->modelUnit = model($TikoERPModelPath . '\UnitModel', true, $db_connection);
        $this->modelStockRecipe = model($TikoERPModelPath . '\StockRecipeModel', true, $db_connection);
        $this->modelRecipeItem = model($TikoERPModelPath . '\RecipeItemModel', true, $db_connection);
        $this->modelMoneyUnit = model($TikoERPModelPath . '\MoneyUnitModel', true, $db_connection);
        $this->modelWarehouse = model($TikoERPModelPath . '\WarehouseModel', true, $db_connection);
        $this->modelStockMovement = model($TikoERPModelPath . '\StockMovementModel', true, $db_connection);
        $this->modelStockBarcode = model($TikoERPModelPath . '\StockBarcodeModel', true, $db_connection);
        $this->modelFinancialMovement = model($TikoERPModelPath . '\FinancialMovementModel', true, $db_connection);
        $this->modelGider = model($TikoERPModelPath . '\GiderModel', true, $db_connection);

        $this->logClass = new Log();
        helper('Helpers\number_format_helper');

    }

    private function truncateName($name, $limit = 20) {
        return (strlen($name) > $limit) ? substr($name, 0, $limit) . '...' : $name;
    }

    public function userDatabase()
    {
       
        
       
        

        $userDatabaseDetail = [
            'hostname' => session()->get("user_item")["db_host"],
            'username' => session()->get("user_item")["db_username"],
            'password' => session()->get("user_item")["db_password"],
            'database' => session()->get("user_item")["db_name"],
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

    //günlük rapor
    public function daily($date_start = null)
    {
        $page_title = "Günlük Rapor";

        $date_start = date("Y-m-d").' 00:00:00';
        $date_end = date("Y-m-d").' 23:59:59';

        $invoice_items_outgoing = $this->modelInvoice
            ->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->join('invoice_serial', 'invoice_serial.invoice_serial_id = invoice.invoice_serial_id', 'left')
            ->join('invoice_incoming_status iis', 'iis.invoice_incoming_status_id = invoice.invoice_status_id', 'left')
            ->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice_direction', 'outgoing_invoice')
            ->where('invoice.deleted_at IS NULL', null, false)
            ->where('invoice.invoice_date >=', $date_start)
            ->where('invoice.invoice_date <=', $date_end)
            ->where('invoice.cari_id != 15199', null, false)
            ->orderBy('invoice.invoice_date', 'DESC')
            ->findAll();

        $invoice_items_incoming = $this->modelInvoice
            ->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->join('invoice_serial', 'invoice_serial.invoice_serial_id = invoice.invoice_serial_id', 'left')
            ->join('invoice_outgoing_status ios', 'ios.invoice_outgoing_status_id = invoice.invoice_status_id', 'left')
            ->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice_direction', 'incoming_invoice')
            ->where('invoice.deleted_at IS NULL', null, false)
            ->where('invoice.invoice_date >=', $date_start)
            ->where('invoice.invoice_date <=', $date_end)
            ->where('invoice.cari_id != 15199', null, false)
            ->orderBy('invoice.invoice_date', 'DESC')
            ->findAll();

        $gider_items = $this->modelGider
            ->join('money_unit', 'money_unit.money_unit_id = giderler.money_unit_id')
            ->join('financial_movement', 'financial_movement.gider_id = giderler.gider_id')
            ->where('giderler.user_id', session()->get('user_id'))
            ->where('giderler.deleted_at IS NULL', null, false)
            ->where('giderler.gider_date >=', $date_start)
            ->where('giderler.gider_date <=', $date_end)
            ->orderBy('giderler.gider_date', 'DESC')
            ->findAll();

        $outgoing_invoice_ids = array_column($invoice_items_outgoing, 'invoice_id');
        $incoming_invoice_ids = array_column($invoice_items_incoming, 'invoice_id');
    
        $outgoingInvoiceRows = [];
        $incomingInvoiceRows = [];
    
        if (!empty($outgoing_invoice_ids)) {
            $outgoingInvoiceRows = $this->modelInvoiceRow
                ->select('unit_id, SUM(stock_amount) as total_amount')
                ->whereIn('invoice_id', $outgoing_invoice_ids)
                ->groupBy('unit_id')
                ->findAll();
        }
    
        if (!empty($incoming_invoice_ids)) {
            $incomingInvoiceRows = $this->modelInvoiceRow
                ->select('unit_id, SUM(stock_amount) as total_amount')
                ->whereIn('invoice_id', $incoming_invoice_ids)
                ->groupBy('unit_id')
                ->findAll();
        }

        $outgoing_invoice_summary = [];
        $incoming_invoice_summary = [];
        $gider_summary = [];
    
        // Giden faturaların toplamları
        foreach ($invoice_items_outgoing as $invoice_item_outgoing) {
            $money_unit_id = $invoice_item_outgoing['money_unit_id'];
            $money_icon = $invoice_item_outgoing['money_icon'];
    
            if (!isset($outgoing_invoice_summary[$money_unit_id])) {
                $outgoing_invoice_summary[$money_unit_id] = [
                    'money_icon' => $money_icon,
                    'total_sub_total' => 0,
                    'total_tax' => 0,
                    'total_amount' => 0
                ];
            }
    
            // KDV hesaplama
            $tax_1 = $invoice_item_outgoing['tax_rate_1_amount'];
            $tax_10 = $invoice_item_outgoing['tax_rate_10_amount'];
            $tax_20 = $invoice_item_outgoing['tax_rate_20_amount'];
            $total_tax = floatval($tax_1) + floatval($tax_10) + floatval($tax_20);
    
            $outgoing_invoice_summary[$money_unit_id]['total_sub_total'] += floatval($invoice_item_outgoing['sub_total']);
            $outgoing_invoice_summary[$money_unit_id]['total_tax'] += $total_tax;
            $outgoing_invoice_summary[$money_unit_id]['total_amount'] += floatval($invoice_item_outgoing['amount_to_be_paid']);
        }
    
        // Gelen faturaların toplamları
        foreach ($invoice_items_incoming as $invoice_item_incoming) {
            $money_unit_id = $invoice_item_incoming['money_unit_id'];
            $money_icon = $invoice_item_incoming['money_icon'];
    
            if (!isset($incoming_invoice_summary[$money_unit_id])) {
                $incoming_invoice_summary[$money_unit_id] = [
                    'money_icon' => $money_icon,
                    'total_sub_total' => 0,
                    'total_tax' => 0,
                    'total_amount' => 0
                ];
            }
    
            // KDV hesaplama
            $tax_1 = $invoice_item_incoming['tax_rate_1_amount'];
            $tax_10 = $invoice_item_incoming['tax_rate_10_amount'];
            $tax_20 = $invoice_item_incoming['tax_rate_20_amount'];
            $total_tax = floatval($tax_1) + floatval($tax_10) + floatval($tax_20);
    
            $incoming_invoice_summary[$money_unit_id]['total_sub_total'] += floatval($invoice_item_incoming['sub_total']);
            $incoming_invoice_summary[$money_unit_id]['total_tax'] += $total_tax;
            $incoming_invoice_summary[$money_unit_id]['total_amount'] += floatval($invoice_item_incoming['amount_to_be_paid']);
        }

        // Gider toplamları
        foreach ($gider_items as $gider_item) {
            $money_unit_id = $gider_item['money_unit_id'];
            $money_icon = $gider_item['money_icon'];
    
            if (!isset($gider_summary[$money_unit_id])) {
                $gider_summary[$money_unit_id] = [
                    'money_icon' => $money_icon,
                    'total_sub_total' => 0,
                    'total_tax' => 0,
                    'total_amount' => 0
                ];
            }
    
            // KDV hesaplama
            $tax_1 = $gider_item['tax_rate_1_amount'];
            $tax_10 = $gider_item['tax_rate_10_amount'];
            $tax_20 = $gider_item['tax_rate_20_amount'];
            $total_tax = floatval($tax_1) + floatval($tax_10) + floatval($tax_20);
    
            $gider_summary[$money_unit_id]['total_sub_total'] += floatval($gider_item['sub_total']);
            $gider_summary[$money_unit_id]['total_tax'] += $total_tax;
            $gider_summary[$money_unit_id]['total_amount'] += floatval($gider_item['amount_to_be_paid']);
        }
    
        $unitTitles = $this->modelUnit->select('unit_id, unit_title')->where("status", "active")->findAll();
        $unitTitleMap = [];
    
        foreach ($unitTitles as $unit) {
            $unitTitleMap[$unit['unit_id']] = $unit['unit_title'];
        }
    
        $outgoingInvoiceMap = [];
        foreach ($outgoingInvoiceRows as $row) {
            $outgoingInvoiceMap[$row['unit_id']] = $row['total_amount'];
        }
    
        $incomingInvoiceMap = [];
        foreach ($incomingInvoiceRows as $row) {
            $incomingInvoiceMap[$row['unit_id']] = $row['total_amount'];
        }
    
        $outgoingInvoiceSummary = [];
        foreach ($unitTitleMap as $unit_id => $unit_title) {
            $total_amount = isset($outgoingInvoiceMap[$unit_id]) ? $outgoingInvoiceMap[$unit_id] : '0.00';
            $outgoingInvoiceSummary[] = [
                'unit_title' => $unit_title,
                'total_amount' => $total_amount,
            ];
        }
    
        $incomingInvoiceSummary = [];
        foreach ($unitTitleMap as $unit_id => $unit_title) {
            $total_amount = isset($incomingInvoiceMap[$unit_id]) ? $incomingInvoiceMap[$unit_id] : '0.00';
            $incomingInvoiceSummary[] = [
                'unit_title' => $unit_title,
                'total_amount' => $total_amount,
            ];
        }
    
        $data = [
            'page_title' => $page_title,
            'unitTitleMap' => $unitTitleMap,
            'outgoing_invoice_summary' => $outgoing_invoice_summary,
            'incoming_invoice_summary' => $incoming_invoice_summary,
            'gider_summary' => $gider_summary,
            'incomingInvoiceSummary' => $incomingInvoiceSummary,
            'outgoingInvoiceSummary' => $outgoingInvoiceSummary,
            'invoice_items_outgoing' => $invoice_items_outgoing,
            'invoice_items_incoming' => $invoice_items_incoming,
            'gider_items' => $gider_items,
        ];

        return view('tportal/raporlar/rapor_gunluk', $data);
    }


    public function stock_report($date_start = null)
    {
        $page_title = "Stok Raporları";

        $db = $this->userDatabase(); // Veritabanı bağlantısını al

        // Tarih filtresi parametrelerini al
        $start_date = $this->request->getGet('start_date') ?? null;
        $end_date = $this->request->getGet('end_date') ?? null;

        $sql = "
            SELECT DISTINCT
                mu.money_unit_id,
                mu.money_icon,
                mu.money_title,
                sale_unit.unit_title AS sale_unit_title,
                stock.buy_unit_id,
                stock.sale_unit_id,
                sale_unit.unit_value AS sale_unit_value,
                buy_unit.unit_title AS buy_unit_title,
                buy_unit.unit_value AS buy_unit_value,
                stock.stock_id,
                stock.stock_title,
                stock.parent_id,
                stock_barcode.stock_barcode_id,
                stock_barcode.stock_id,
                stock_barcode.total_amount,
                stock_barcode.used_amount,
                stock_barcode.stock_barcode_status,
                stock_movement.stock_barcode_id,
                stock_movement.buy_unit_price,
                stock_movement.created_at
            FROM stock
            LEFT JOIN stock_barcode ON stock_barcode.stock_id = stock.stock_id
            JOIN unit AS buy_unit ON buy_unit.unit_id = stock.buy_unit_id
            JOIN unit AS sale_unit ON sale_unit.unit_id = stock.sale_unit_id
            JOIN money_unit mu ON stock.sale_money_unit_id = mu.money_unit_id
            LEFT JOIN stock_movement ON stock_movement.stock_barcode_id = stock_barcode.stock_barcode_id
            WHERE stock.user_id = ?
            AND stock.parent_id != 0
            AND stock_movement.movement_type = 'incoming'
            AND stock_barcode.stock_barcode_status = 'available'
            AND stock_barcode.deleted_at IS NULL
        ";

        $params = [session()->get('user_id')];

        // Tarih filtresi ekle
        if ($start_date && $end_date) {
            $sql .= " AND DATE(stock_movement.created_at) BETWEEN ? AND ?";
            $params[] = $start_date;
            $params[] = $end_date;
        }

        // Sorguyu çalıştır
        $stock_report = $db->query($sql, $params)->getResultArray();
            // Hata kontrolü
        
    
    $summary = []; // Ürün özetini tutacak bir dizi
    $totalPricesByCurrency = []; // Para birimlerine göre toplam fiyatları tutacak dizi
    $totalStockTpye = []; // Para birimlerine göre toplam fiyatları tutacak dizi
    $toplam_miktar = 0;
    
    foreach ($stock_report as $report) {
        $product_title = $report["stock_title"];
        $totalKalan = $report["total_amount"] - $report["used_amount"];
        $buy_unit_price = $report["buy_unit_price"];
        $buy_unit_title = $report["buy_unit_title"];
        $money_unit_id = $report["money_unit_id"];
        $buy_unit_id = $report["buy_unit_id"];
        $money_icon = $report["money_icon"];
        $total_price = $totalKalan * $buy_unit_price;
    
        $toplam_miktar += $totalKalan;
    
        // Para birimine göre toplam fiyatı güncelle
        if (!isset($totalPricesByCurrency[$money_unit_id])) {
            $totalPricesByCurrency[$money_unit_id] = [
                'money_icon' => $money_icon,
                'total_price' => 0
            ];
        }

        if (!isset($totalStockTpye[$buy_unit_id])) {
            $totalStockTpye[$buy_unit_id] = [
                'buy_unit_title' => $buy_unit_title,
                'total_amount' => 0
            ];
        }

        $totalPricesByCurrency[$money_unit_id]['total_price'] += $total_price;
        $totalStockTpye[$buy_unit_id]['total_amount'] += $totalKalan;
    
        // Ürün özetine ekleme yap
        if (!isset($summary[$product_title])) {
            $summary[$product_title] = [
                'total_amount' => 0,
                'total_price' => 0,
                'buy_unit_title' => $buy_unit_title,
                'stock_id' => $report["stock_id"]
            ];
        }
    
        // Toplam stok girişini ve toplam fiyatı güncelle
        $summary[$product_title]['total_amount'] += $totalKalan;
        $summary[$product_title]['total_price'] += $total_price;
    }
    
    // Özet bilgilerini yazdır
    foreach ($summary as $product_title => $data) {
        //echo "<pre>";
        //echo "{$product_title} İsimli Üründen Stok Girişi: <b>" . number_format($data['total_amount'], 2, ',', '.') . "</b>  Toplam Fiyatı: <b>" . number_format($data['total_price'], 2, ',', '.') . "</b><br>";
       // echo "</pre>";
    }
    
    // Para birimlerine göre toplam fiyatları yazdır
  
    $totalPricesByCurrencyJson = json_encode($totalPricesByCurrency);
    $totalStockTypes = json_encode($totalStockTpye);


    
    $data = [
        'page_title' => $page_title,
        'toplam_adet' => $totalStockTypes,
        'toplam_fiyat' => $totalPricesByCurrencyJson, // Para birimlerine göre toplam fiyatlar
        'summary' => $summary
    ];
        


        return view('tportal/raporlar/rapor_stok', $data);
    }

    // AJAX endpoint for stock report filtering
    public function stock_report_ajax()
    {
        $db = $this->userDatabase();

        // POST parametrelerini al
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        // Eğer tarih parametreleri gönderilmemişse, ay başından bugüne kadar olan tarih aralığını kullan
        if (!$start_date || !$end_date) {
            $start_date = date('Y-m-01'); // Ay başı
            $end_date = date('Y-m-d');    // Bugün
        }

        $sql = "
            SELECT DISTINCT
                mu.money_unit_id,
                mu.money_icon,
                mu.money_title,
                sale_unit.unit_title AS sale_unit_title,
                stock.buy_unit_id,
                stock.sale_unit_id,
                sale_unit.unit_value AS sale_unit_value,
                buy_unit.unit_title AS buy_unit_title,
                buy_unit.unit_value AS buy_unit_value,
                stock.stock_id,
                stock.stock_title,
                stock.parent_id,
                stock_barcode.stock_barcode_id,
                stock_barcode.stock_id,
                stock_barcode.total_amount,
                stock_barcode.used_amount,
                stock_barcode.stock_barcode_status,
                stock_movement.stock_barcode_id,
                stock_movement.buy_unit_price,
                stock_movement.created_at
            FROM stock
            LEFT JOIN stock_barcode ON stock_barcode.stock_id = stock.stock_id
            JOIN unit AS buy_unit ON buy_unit.unit_id = stock.buy_unit_id
            JOIN unit AS sale_unit ON sale_unit.unit_id = stock.sale_unit_id
            JOIN money_unit mu ON stock.sale_money_unit_id = mu.money_unit_id
            LEFT JOIN stock_movement ON stock_movement.stock_barcode_id = stock_barcode.stock_barcode_id
            WHERE stock.user_id = ?
            AND stock.parent_id != 0
            AND stock_movement.movement_type = 'incoming'
            AND stock_barcode.stock_barcode_status = 'available'
            AND stock_barcode.deleted_at IS NULL
        ";

        $params = [session()->get('user_id')];

        // Tarih filtresi ekle (artık her zaman tarih filtresi var)
        $sql .= " AND DATE(stock_movement.created_at) BETWEEN ? AND ?";
        $params[] = $start_date;
        $params[] = $end_date;

        // Sorguyu çalıştır
        $stock_report = $db->query($sql, $params)->getResultArray();

        $summary = [];
        $totalPricesByCurrency = [];
        $totalStockTpye = [];
        $toplam_miktar = 0;

        foreach ($stock_report as $report) {
            $product_title = $report["stock_title"];
            $totalKalan = $report["total_amount"] - $report["used_amount"];
            $buy_unit_price = $report["buy_unit_price"];
            $buy_unit_title = $report["buy_unit_title"];
            $money_unit_id = $report["money_unit_id"];
            $buy_unit_id = $report["buy_unit_id"];
            $money_icon = $report["money_icon"];
            $total_price = $totalKalan * $buy_unit_price;

            $toplam_miktar += $totalKalan;

            // Para birimine göre toplam fiyatı güncelle
            if (!isset($totalPricesByCurrency[$money_unit_id])) {
                $totalPricesByCurrency[$money_unit_id] = [
                    'money_icon' => $money_icon,
                    'total_price' => 0
                ];
            }

            if (!isset($totalStockTpye[$buy_unit_id])) {
                $totalStockTpye[$buy_unit_id] = [
                    'buy_unit_title' => $buy_unit_title,
                    'total_amount' => 0
                ];
            }

            $totalPricesByCurrency[$money_unit_id]['total_price'] += $total_price;
            $totalStockTpye[$buy_unit_id]['total_amount'] += $totalKalan;

            // Ürün özetine ekleme yap
            if (!isset($summary[$product_title])) {
                $summary[$product_title] = [
                    'total_amount' => 0,
                    'total_price' => 0,
                    'buy_unit_title' => $buy_unit_title,
                    'stock_id' => $report["stock_id"]
                ];
            }

            // Toplam stok girişini ve toplam fiyatı güncelle
            $summary[$product_title]['total_amount'] += $totalKalan;
            $summary[$product_title]['total_price'] += $total_price;
        }

        $totalPricesByCurrencyJson = json_encode($totalPricesByCurrency);
        $totalStockTypes = json_encode($totalStockTpye);

        $data = [
            'summary' => $summary,
            'toplam_adet' => $totalStockTypes,
            'toplam_fiyat' => $totalPricesByCurrencyJson
        ];

        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }



    public function export_excel($date_start = null)
    {
        $db = $this->userDatabase(); // Veritabanı bağlantısını al

        $sql = "
            SELECT DISTINCT
                mu.money_unit_id,
                mu.money_icon,
                mu.money_title,
                sale_unit.unit_title AS sale_unit_title,
                stock.buy_unit_id,
                stock.sale_unit_id,
                sale_unit.unit_value AS sale_unit_value,
                buy_unit.unit_title AS buy_unit_title,
                buy_unit.unit_value AS buy_unit_value,
                stock.stock_id,
                stock.stock_title,
                stock.parent_id,
                stock_barcode.stock_barcode_id,
                stock_barcode.stock_id,
                stock_barcode.total_amount,
                stock_barcode.used_amount,
                stock_barcode.stock_barcode_status,
                stock_movement.stock_barcode_id,
                stock_movement.buy_unit_price
            FROM stock
            LEFT JOIN stock_barcode ON stock_barcode.stock_id = stock.stock_id
            JOIN unit AS buy_unit ON buy_unit.unit_id = stock.buy_unit_id
            JOIN unit AS sale_unit ON sale_unit.unit_id = stock.sale_unit_id
            JOIN money_unit mu ON stock.sale_money_unit_id = mu.money_unit_id
            LEFT JOIN stock_movement ON stock_movement.stock_barcode_id = stock_barcode.stock_barcode_id
            WHERE stock.user_id = ?
            AND stock.parent_id != 0
            AND stock_movement.movement_type = 'incoming'
            AND stock_barcode.stock_barcode_status = 'available'
            AND stock_barcode.deleted_at IS NULL
        ";

        // Sorguyu çalıştır
        $stock_report = $db->query($sql, [session()->get('user_id')])->getResultArray();
        
        $summary = []; // Ürün özetini tutacak bir dizi
        $totalPricesByCurrency = []; // Para birimlerine göre toplam fiyatları tutacak dizi
        $totalStockTpye = []; // Para birimlerine göre toplam fiyatları tutacak dizi
        $toplam_miktar = 0;
        
        foreach ($stock_report as $report) {
            $product_title = $report["stock_title"];
            $totalKalan = $report["total_amount"] - $report["used_amount"];
            $buy_unit_price = $report["buy_unit_price"];
            $buy_unit_title = $report["buy_unit_title"];
            $money_unit_id = $report["money_unit_id"];
            $buy_unit_id = $report["buy_unit_id"];
            $money_icon = $report["money_icon"];
            $total_price = $totalKalan * $buy_unit_price;
        
            $toplam_miktar += $totalKalan;
        
            // Para birimine göre toplam fiyatı güncelle
            if (!isset($totalPricesByCurrency[$money_unit_id])) {
                $totalPricesByCurrency[$money_unit_id] = [
                    'money_icon' => $money_icon,
                    'total_price' => 0
                ];
            }

            if (!isset($totalStockTpye[$buy_unit_id])) {
                $totalStockTpye[$buy_unit_id] = [
                    'buy_unit_title' => $buy_unit_title,
                    'total_amount' => 0
                ];
            }

            $totalPricesByCurrency[$money_unit_id]['total_price'] += $total_price;
            $totalStockTpye[$buy_unit_id]['total_amount'] += $totalKalan;
        
            // Ürün özetine ekleme yap
            if (!isset($summary[$product_title])) {
                $summary[$product_title] = [
                    'total_amount' => 0,
                    'total_price' => 0,
                    'buy_unit_title' => $buy_unit_title,
                    'stock_id' => $report["stock_id"]
                ];
            }
        
            // Toplam stok girişini ve toplam fiyatı güncelle
            $summary[$product_title]['total_amount'] += $totalKalan;
            $summary[$product_title]['total_price'] += $total_price;
        }

        // Excel dosyası oluştur
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Başlık satırı
        $sheet->setCellValue('A1', '#');
        $sheet->setCellValue('B1', 'ÜRÜN ADI');
        $sheet->setCellValue('C1', 'TOPLAM STOK');
        $sheet->setCellValue('D1', 'TİPİ');
        $sheet->setCellValue('E1', 'TOPLAM FİYAT');
        
        // Başlık stilini ayarla
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:E1')->getFill()->getStartColor()->setRGB('E7E6E6');
        
        $row = 2;
        foreach ($summary as $product_title => $data) {
            $sheet->setCellValue('A' . $row, $row - 1);
            $sheet->setCellValue('B' . $row, $product_title);
            $sheet->setCellValue('C' . $row, number_format($data['total_amount'], 2, ',', '.'));
            $sheet->setCellValue('D' . $row, $data['buy_unit_title']);
            $sheet->setCellValue('E' . $row, number_format($data['total_price'], 2, ',', '.'));
            $row++;
        }
        
        // Sütun genişliklerini ayarla
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        
        // Excel dosyasını oluştur
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        // Response header'larını ayarla
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Stok_Raporu.xlsx"');
        header('Cache-Control: max-age=0');
        
        // Dosyayı output'a yaz
        $writer->save('php://output');
        exit;
    }



    public function musteri_report($customer = null)
    {
        $page_title = "Müşteri Raporları";


        $where = "cari.is_customer";

        
        $builder = $this->modelCari
        ->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
        ->select('cari.user_id,
        cari_id,
        cari_code,
        cari.money_unit_id,
        identification_number,
        tax_administration,
        invoice_title,
        name,
        surname,
        obligation,
        company_type,
        cari_phone,
        cari_email,
        cari_balance,
        is_customer,
        is_supplier,
        is_export_customer, money_unit.money_icon')
        ->where('cari.user_id', session()->get('user_id'))
        ->where('cari.deleted_at IS NULL', null, false)
        ->where($where, 1)
        ->where('cari.cari_id != 15199', null, false)
        ->orderBy("cari.cari_balance", "DESC")
        ->findAll();
    
    // Başlangıç değerleri
   // Başlangıç değerleri
$totals_borclu = [];
$totals_alacakli = [];

foreach ($builder as $cari) {
    $money_unit = $cari['money_unit_id'];

    if (!isset($totals_borclu[$money_unit])) {
        $totals_borclu[$money_unit] = ['amount' => 0, 'icon' => $cari['money_icon']];
    }
    if (!isset($totals_alacakli[$money_unit])) {
        $totals_alacakli[$money_unit] = ['amount' => 0, 'icon' => $cari['money_icon']];
    }

    if ($cari['cari_balance'] > 0) {
        $totals_borclu[$money_unit]['amount'] += $cari['cari_balance'];
    } else {
        $totals_alacakli[$money_unit]['amount'] += $cari['cari_balance'];
    }
}

$data = [
    'page_title' => $page_title,
    'builder' => $builder,
    'totals_borclu' => json_encode($totals_borclu),
    'totals_alacakli' => json_encode($totals_alacakli)
];


    

        return view('tportal/raporlar/rapor_musteri', $data);
    }

    public function tedarikci_report($customer = null)
    {
        $page_title = "Tedarikçi Raporları";


        $where = "cari.is_supplier";

        
        $builder = $this->modelCari
        ->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
        ->select('cari.user_id,
        cari_id,
        cari_code,
        cari.money_unit_id,
        identification_number,
        tax_administration,
        invoice_title,
        name,
        surname,
        obligation,
        company_type,
        cari_phone,
        cari_email,
        cari_balance,
        is_customer,
        is_supplier,
        is_export_customer, money_unit.money_icon')
        ->where('cari.user_id', session()->get('user_id'))
        ->where('cari.deleted_at IS NULL', null, false)
        ->where($where, 1)
        ->where('cari.cari_id != 15199', null, false)
        ->orderBy("cari.cari_balance", "DESC")
        ->findAll();
    
    // Başlangıç değerleri
   // Başlangıç değerleri
$totals_borclu = [];
$totals_alacakli = [];

foreach ($builder as $cari) {
    $money_unit = $cari['money_unit_id'];

    if (!isset($totals_borclu[$money_unit])) {
        $totals_borclu[$money_unit] = ['amount' => 0, 'icon' => $cari['money_icon']];
    }
    if (!isset($totals_alacakli[$money_unit])) {
        $totals_alacakli[$money_unit] = ['amount' => 0, 'icon' => $cari['money_icon']];
    }

    if ($cari['cari_balance'] > 0) {
        $totals_borclu[$money_unit]['amount'] += $cari['cari_balance'];
    } else {
        $totals_alacakli[$money_unit]['amount'] += $cari['cari_balance'];
    }
}

$data = [
    'page_title' => $page_title,
    'builder' => $builder,
    'totals_borclu' => json_encode($totals_borclu),
    'totals_alacakli' => json_encode($totals_alacakli)
];


    

        return view('tportal/raporlar/rapor_tedarik', $data);
    }

    public function cari_balance_report()
    {

        $page_title = "Müşteri Raporları";



        $data = [
            'page_title' => $page_title,

        ];
            
    
    
            return view('tportal/raporlar/cari_report', $data);

    }


    public function detayli_satis_raporlari()
    {
        $paraBirimleri = $this->modelMoneyUnit->where("status", "active")->findAll();
        $musteriler = $this->modelCari->findAll();
        $urunler = $this->modelStock->where("parent_id !=", 0)->findAll();

        $paraSec = $this->modelMoneyUnit->where("default", "true")->first();

        $page_title = "Detaylı Satış Raporları";

        $date_start = date("Y-m-d").' 00:00:00';
        $date_end = date("Y-m-d").' 23:59:59';
        // Aktif birimleri al
        $units = $this->modelUnit->select('unit_id, unit_title')->where("status", "active")->findAll();
        $unitIds = array_column($units, 'unit_id');
        $unitTitleMap = [];

        foreach ($units as $unit) {
            $unitTitleMap[""] = $unit['unit_title'];
            $unitTitleMap["unit_id"] = $unit['unit_id'];
        }
       

        $db = $this->userDatabase();


        // Fatura satırlarını çek
        $query = "
        SELECT 
            invoice_row.*, 
            money_unit.*, 
            variant_property.*,
            stock_variant_group.*,
            stock_movement.*,
            invoice.invoice_id, 
            invoice.invoice_no, 
            invoice.cari_invoice_title, 
            invoice.invoice_date, 
            invoice.invoice_type, 
            invoice.currency_amount, 
            invoice.is_return, 
            invoice.invoice_scenario, 
            invoice.invoice_direction, 
            invoice.money_unit_id, 
            invoice.invoice_date, 
            unit.unit_id, 
            unit.unit_title, 
            invoice_row.stock_amount,
            SUM(invoice_row.stock_amount) AS total_stock_amount

        FROM 
            invoice_row
        JOIN 
            invoice ON invoice.invoice_id = invoice_row.invoice_id
        JOIN 
            money_unit ON money_unit.money_unit_id = invoice.money_unit_id
        JOIN 
            unit ON unit.unit_id = invoice_row.unit_id
        JOIN 
            stock_movement ON stock_movement.stock_barcode_id = invoice_row.stock_barcode_id
        JOIN 
        stock_variant_group ON stock_variant_group.stock_id = invoice_row.stock_id
         JOIN 
        variant_property ON variant_property.variant_property_id = stock_variant_group.variant_1
        WHERE 
            invoice.money_unit_id = ? AND
            invoice.invoice_type = ? AND
            invoice.invoice_date >= ? AND
            invoice.invoice_date <= ? AND
            invoice.deleted_at IS NULL AND
            invoice_row.deleted_at IS NULL
            
                GROUP BY invoice_row.invoice_id, invoice_row.stock_id



    ";
    
    $invoiceRows = $db->query($query, [$paraSec["money_unit_id"],'SATIS', $date_start, $date_end])->getResultArray();

    function truncateName($name, $limit = 20) {
        return (strlen($name) > $limit) ? substr($name, 0, $limit) . '...' : $name;
    }
    foreach ($invoiceRows as &$row) {
        $row['cari_invoice_title_full'] = $row['cari_invoice_title'];
        $row['cari_invoice_title'] = truncateName($row['cari_invoice_title']);
        
    }
    unset($row); 
    
       
        $data = [
            'musteriler'     => $musteriler,
            'para_birimleri' => $paraBirimleri,
            'page_title' => $page_title,
            'unitTitleMap' => $units,
            'secilen_musteri' =>0,
            'secilen_urun' => 0,
            'urunler' => $urunler,

            'invoiceRows' => $invoiceRows,
            'currency'   => $paraSec["money_unit_id"]
        ];



    
        return view('tportal/raporlar/rapor_detayli_satis', $data);




    }



    public function detayli_odeme_raporlari()
    {
        $paraBirimleri = $this->modelMoneyUnit->where("status", "active")->findAll();
        $musteriler = $this->modelCari->findAll();

        $paraSec = $this->modelMoneyUnit->where("default", "true")->first();

        $page_title = "Detaylı Ödeme Raporları";

        $date_start = date("Y-m-d").' 00:00:00';
        $date_end = date("Y-m-d").' 23:59:59';

        $db = $this->userDatabase();

        // Finansal hareketleri çek
        $query = "
        SELECT 
            financial_movement.*,
            money_unit.money_icon,
            money_unit.money_title,
            money_unit.money_code,
            cari.invoice_title as cari_invoice_title,
            cari.cari_code,
            cari.identification_number,
            financial_movement.transaction_description,
            financial_account.account_title,
            financial_account.account_type,
            CASE 
                WHEN financial_account.account_type = 'vault' THEN 'Kasa'
                WHEN financial_account.account_type = 'bank' THEN 'Banka'
                WHEN financial_account.account_type = 'pos' THEN 'POS'
                WHEN financial_account.account_type = 'credit_card' THEN 'Kredi Kartı'
                WHEN financial_account.account_type = 'check_bill' THEN 'Çek/Senet'
                ELSE 'Diğer'
            END as account_type_tr
        FROM 
            financial_movement
        JOIN 
            money_unit ON money_unit.money_unit_id = financial_movement.money_unit_id
        LEFT JOIN 
            cari ON cari.cari_id = financial_movement.cari_id
        LEFT JOIN 
            financial_account ON financial_account.financial_account_id = financial_movement.financial_account_id
        WHERE 
            financial_movement.money_unit_id = ? AND
            (
                (financial_movement.transaction_type = 'payment') OR
                (
                    financial_movement.transaction_type IN ('starting_balance', 'borc_alacak') AND
                    financial_movement.transaction_amount >= 0
                )
            ) AND
            financial_movement.transaction_date >= ? AND
            financial_movement.transaction_date <= ? AND
            financial_movement.deleted_at IS NULL";
    
    $financialMovements = $db->query($query, [$paraSec["money_unit_id"], $date_start, $date_end])->getResultArray();
    
    foreach ($financialMovements as &$row) {
        $row['cari_invoice_title_full'] = $row['cari_invoice_title'];
        $row['cari_invoice_title'] = $this->truncateName($row['cari_invoice_title']);
        
        // İşlem tipini Türkçeye çevir
        switch($row['transaction_type']) {
            case 'payment':
                $row['transaction_type_tr'] = 'Ödeme';
                break;
            case 'collection':
                $row['transaction_type_tr'] = 'Tahsilat';
                break;
            case 'starting_balance':
                $row['transaction_type_tr'] = 'Açılış Bakiyesi';
                break;
            case 'borc_alacak':
                $row['transaction_type_tr'] = 'Borç/Alacak';
                break;
        }

        // İşlem yönünü Türkçeye çevir
        $row['transaction_direction_tr'] = $row['transaction_direction'] == 'entry' ? 'Giriş' : 'Çıkış';
    }
    unset($row);
       
    $data = [
        'musteriler'     => $musteriler,
        'para_birimleri' => $paraBirimleri,
        'page_title'     => $page_title,
        'secilen_musteri' => 0,
        'financialMovements' => $financialMovements,
        'currency'       => $paraSec["money_unit_id"]
    ];

    return view('tportal/raporlar/rapor_detayli_odeme', $data);
    }




    public function detayli_odeme_raporlarim($date, $date2, $currency, $musteri = null)
    {
        $paraBirimleri = $this->modelMoneyUnit->where("status", "active")->findAll();
        $musteriler = $this->modelCari->findAll();

        $paraSec = $this->modelMoneyUnit->where("money_unit_id", $currency)->first();

        $page_title = "Detaylı Ödeme Raporları";

        $date_start = $date.' 00:00:00';
        $date_end = $date2.' 23:59:59';

        $db = $this->userDatabase();

        // Finansal hareketleri çek
        $query = "
        SELECT 
            financial_movement.*,
            money_unit.money_icon,
            money_unit.money_title,
            money_unit.money_code,
            cari.invoice_title as cari_invoice_title,
            cari.cari_code,
            cari.identification_number,
            financial_movement.transaction_description,
            financial_account.account_title,
            financial_account.account_type,
            CASE 
                WHEN financial_account.account_type = 'vault' THEN 'Kasa'
                WHEN financial_account.account_type = 'bank' THEN 'Banka'
                WHEN financial_account.account_type = 'pos' THEN 'POS'
                WHEN financial_account.account_type = 'credit_card' THEN 'Kredi Kartı'
                WHEN financial_account.account_type = 'check_bill' THEN 'Çek/Senet'
                ELSE 'Diğer'
            END as account_type_tr
        FROM 
            financial_movement
        JOIN 
            money_unit ON money_unit.money_unit_id = financial_movement.money_unit_id
        LEFT JOIN 
            cari ON cari.cari_id = financial_movement.cari_id
        LEFT JOIN 
            financial_account ON financial_account.financial_account_id = financial_movement.financial_account_id
        WHERE 
            financial_movement.money_unit_id = ? AND
            (
                (financial_movement.transaction_type = 'payment') OR
                (
                    financial_movement.transaction_type IN ('starting_balance', 'borc_alacak') AND
                    financial_movement.transaction_amount >= 0
                )
            ) AND
            financial_movement.transaction_date >= ? AND
            financial_movement.transaction_date <= ? AND
            financial_movement.deleted_at IS NULL";

        $params = [$currency, $date_start, $date_end];

        if ($musteri != 0) {
            $query .= " AND financial_movement.cari_id = ?";
            $params[] = $musteri;
        }

        $query .= " ORDER BY financial_movement.transaction_date DESC";
    
        $financialMovements = $db->query($query, $params)->getResultArray();

        foreach ($financialMovements as &$row) {
            $row['cari_invoice_title_full'] = $row['cari_invoice_title'];
            $row['cari_title'] = $row['cari_invoice_title'];
            $row['cari_invoice_title'] = $this->truncateName($row['cari_invoice_title']);
            
            // İşlem tipini Türkçeye çevir
            switch($row['transaction_type']) {
                case 'payment':
                    $row['transaction_type_tr'] = 'Ödeme';
                    break;
                case 'collection':
                    $row['transaction_type_tr'] = 'Tahsilat';
                    break;
                case 'starting_balance':
                    $row['transaction_type_tr'] = 'Açılış Bakiyesi';
                    break;
                case 'borc_alacak':
                    $row['transaction_type_tr'] = 'Borç/Alacak';
                    break;
            }

            // İşlem yönünü Türkçeye çevir
            $row['transaction_direction_tr'] = $row['transaction_direction'] == 'entry' ? 'Giriş' : 'Çıkış';
        }
     
        $data = [
            'musteriler'     => $musteriler,
            'para_birimleri' => $paraBirimleri,
            'page_title'     => $page_title,
            'secilen_musteri' => $musteri,
            'financialMovements' => $financialMovements,
            'currency'       => $currency,
            'date'          => $date,
            'date2'         => $date2
        ];

        return view('tportal/raporlar/rapor_detayli_odeme', $data);
    }




    public function detayli_tahsilat_raporlari()
    {
        $paraBirimleri = $this->modelMoneyUnit->where("status", "active")->findAll();
        $musteriler = $this->modelCari->findAll();

        $paraSec = $this->modelMoneyUnit->where("default", "true")->first();

        $page_title = "Detaylı Tahsilat Raporları";

        $date_start = date("Y-m-d").' 00:00:00';
        $date_end = date("Y-m-d").' 23:59:59';

        $db = $this->userDatabase();

        // Finansal hareketleri çek
        $query = "
        SELECT 
            financial_movement.*,
            money_unit.money_icon,
            money_unit.money_title,
            money_unit.money_code,
            cari.invoice_title as cari_invoice_title,
            cari.cari_code,
            cari.identification_number,
            financial_movement.transaction_description,
            financial_account.account_title,
            financial_account.account_type,
            CASE 
                WHEN financial_account.account_type = 'vault' THEN 'Kasa'
                WHEN financial_account.account_type = 'bank' THEN 'Banka'
                WHEN financial_account.account_type = 'pos' THEN 'POS'
                WHEN financial_account.account_type = 'credit_card' THEN 'Kredi Kartı'
                WHEN financial_account.account_type = 'check_bill' THEN 'Çek/Senet'
                ELSE 'Diğer'
            END as account_type_tr
        FROM 
            financial_movement
        JOIN 
            money_unit ON money_unit.money_unit_id = financial_movement.money_unit_id
        LEFT JOIN 
            cari ON cari.cari_id = financial_movement.cari_id
        LEFT JOIN 
            financial_account ON financial_account.financial_account_id = financial_movement.financial_account_id
        WHERE 
            financial_movement.money_unit_id = ? AND
            (
                (financial_movement.transaction_type = 'collection') OR
                (
                    financial_movement.transaction_type IN ('starting_balance', 'borc_alacak') AND
                    financial_movement.transaction_amount <= 0
                )
            ) AND
            financial_movement.transaction_date >= ? AND
            financial_movement.transaction_date <= ? AND
            financial_movement.deleted_at IS NULL";
    
    $financialMovements = $db->query($query, [$paraSec["money_unit_id"], $date_start, $date_end])->getResultArray();
    
    foreach ($financialMovements as &$row) {
        $row['cari_invoice_title_full'] = $row['cari_invoice_title'];
        $row['cari_invoice_title'] = $this->truncateName($row['cari_invoice_title']);
        
        // İşlem tipini Türkçeye çevir
        switch($row['transaction_type']) {
            case 'payment':
                $row['transaction_type_tr'] = 'Ödeme';
                break;
            case 'collection':
                $row['transaction_type_tr'] = 'Tahsilat';
                break;
            case 'starting_balance':
                $row['transaction_type_tr'] = 'Açılış Bakiyesi';
                break;
            case 'borc_alacak':
                $row['transaction_type_tr'] = 'Borç/Alacak';
                break;
        }

        // İşlem yönünü Türkçeye çevir
        $row['transaction_direction_tr'] = $row['transaction_direction'] == 'entry' ? 'Giriş' : 'Çıkış';
    }
    unset($row);
       
    $data = [
        'musteriler'     => $musteriler,
        'para_birimleri' => $paraBirimleri,
        'page_title'     => $page_title,
        'secilen_musteri' => 0,
        'financialMovements' => $financialMovements,
        'currency'       => $paraSec["money_unit_id"]
    ];

    return view('tportal/raporlar/rapor_detayli_tahsilat', $data);
    }




    public function detayli_tahsilat_raporlarim($date, $date2, $currency, $musteri = null)
    {
        $paraBirimleri = $this->modelMoneyUnit->where("status", "active")->findAll();
        $musteriler = $this->modelCari->findAll();

        $paraSec = $this->modelMoneyUnit->where("money_unit_id", $currency)->first();

        $page_title = "Detaylı Tahsilat Raporları";

        $date_start = $date.' 00:00:00';
        $date_end = $date2.' 23:59:59';

        $db = $this->userDatabase();

        // Finansal hareketleri çek
        $query = "
        SELECT 
            financial_movement.*,
            money_unit.money_icon,
            money_unit.money_title,
            money_unit.money_code,
            cari.invoice_title as cari_invoice_title,
            cari.cari_code,
            cari.identification_number,
            financial_movement.transaction_description,
            financial_account.account_title,
            financial_account.account_type,
            CASE 
                WHEN financial_account.account_type = 'vault' THEN 'Kasa'
                WHEN financial_account.account_type = 'bank' THEN 'Banka'
                WHEN financial_account.account_type = 'pos' THEN 'POS'
                WHEN financial_account.account_type = 'credit_card' THEN 'Kredi Kartı'
                WHEN financial_account.account_type = 'check_bill' THEN 'Çek/Senet'
                ELSE 'Diğer'
            END as account_type_tr
        FROM 
            financial_movement
        JOIN 
            money_unit ON money_unit.money_unit_id = financial_movement.money_unit_id
        LEFT JOIN 
            cari ON cari.cari_id = financial_movement.cari_id
        LEFT JOIN 
            financial_account ON financial_account.financial_account_id = financial_movement.financial_account_id
        WHERE 
            financial_movement.money_unit_id = ? AND
            (
                (financial_movement.transaction_type = 'collection') OR
                (
                    financial_movement.transaction_type IN ('starting_balance', 'borc_alacak') AND
                    financial_movement.transaction_amount <= 0
                )
            ) AND
            financial_movement.transaction_date >= ? AND
            financial_movement.transaction_date <= ? AND
            financial_movement.deleted_at IS NULL";

        $params = [$currency, $date_start, $date_end];

        if ($musteri != 0) {
            $query .= " AND financial_movement.cari_id = ?";
            $params[] = $musteri;
        }

        $query .= " ORDER BY financial_movement.transaction_date DESC";
    
        $financialMovements = $db->query($query, $params)->getResultArray();

        foreach ($financialMovements as &$row) {
            $row['cari_invoice_title_full'] = $row['cari_invoice_title'];
            $row['cari_title'] = $row['cari_invoice_title'];
            $row['cari_invoice_title'] = $this->truncateName($row['cari_invoice_title']);
            
            // İşlem tipini Türkçeye çevir
            switch($row['transaction_type']) {
                case 'payment':
                    $row['transaction_type_tr'] = 'Ödeme';
                    break;
                case 'collection':
                    $row['transaction_type_tr'] = 'Tahsilat';
                    break;
                case 'starting_balance':
                    $row['transaction_type_tr'] = 'Açılış Bakiyesi';
                    break;
                case 'borc_alacak':
                    $row['transaction_type_tr'] = 'Borç/Alacak';
                    break;
            }

            // İşlem yönünü Türkçeye çevir
            $row['transaction_direction_tr'] = $row['transaction_direction'] == 'entry' ? 'Giriş' : 'Çıkış';
        }
     
        $data = [
            'musteriler'     => $musteriler,
            'para_birimleri' => $paraBirimleri,
            'page_title'     => $page_title,
            'secilen_musteri' => $musteri,
            'financialMovements' => $financialMovements,
            'currency'       => $currency,
            'date'          => $date,
            'date2'         => $date2
        ];

        return view('tportal/raporlar/rapor_detayli_tahsilat', $data);
    }



    public function daily_datatable($date)
    {
        $page_title = "Günlük Rapor";

        $date_start = $date.' 00:00:00';
        $date_end = $date.' 23:59:59';

        $invoice_items_outgoing = $this->modelInvoice
            ->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->join('invoice_serial', 'invoice_serial.invoice_serial_id = invoice.invoice_serial_id', 'left')
            ->join('invoice_incoming_status iis', 'iis.invoice_incoming_status_id = invoice.invoice_status_id', 'left')
            ->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice_direction', 'outgoing_invoice')
            ->where('invoice.invoice_date >=', $date_start)
            ->where('invoice.invoice_date <=', $date_end)
            ->where('invoice.deleted_at IS NULL', null, false)
            ->where('invoice.cari_id != 15199', null, false)
            ->orderBy('invoice.invoice_date', 'DESC')
            ->findAll();

        $invoice_items_incoming = $this->modelInvoice
            ->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->join('invoice_serial', 'invoice_serial.invoice_serial_id = invoice.invoice_serial_id', 'left')
            ->join('invoice_outgoing_status ios', 'ios.invoice_outgoing_status_id = invoice.invoice_status_id', 'left')
            ->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice_direction', 'incoming_invoice')
            ->where('invoice.deleted_at IS NULL', null, false)
            ->where('invoice.invoice_date >=', $date_start)
            ->where('invoice.invoice_date <=', $date_end)
            ->where('invoice.cari_id != 15199', null, false)
            ->orderBy('invoice.invoice_date', 'DESC')
            ->findAll();

        $gider_items = $this->modelGider
            ->join('money_unit', 'money_unit.money_unit_id = giderler.money_unit_id')
            ->join('financial_movement', 'financial_movement.gider_id = giderler.gider_id')
            ->where('giderler.user_id', session()->get('user_id'))
            ->where('giderler.deleted_at IS NULL', null, false)
            ->where('giderler.gider_date >=', $date_start)
            ->where('giderler.gider_date <=', $date_end)
            ->orderBy('giderler.gider_date', 'DESC')
            ->findAll();
                    
        $outgoing_invoice_ids = array_column($invoice_items_outgoing, 'invoice_id');
        $incoming_invoice_ids = array_column($invoice_items_incoming, 'invoice_id');
        
        $outgoingInvoiceRows = [];
        $incomingInvoiceRows = [];
        
        if (!empty($outgoing_invoice_ids)) {
            $outgoingInvoiceRows = $this->modelInvoiceRow
                ->select('unit_id, SUM(stock_amount) as total_amount')
                ->whereIn('invoice_id', $outgoing_invoice_ids)
                ->groupBy('unit_id')
                ->findAll();
        }
        
        if (!empty($incoming_invoice_ids)) {
            $incomingInvoiceRows = $this->modelInvoiceRow
                ->select('unit_id, SUM(stock_amount) as total_amount')
                ->whereIn('invoice_id', $incoming_invoice_ids)
                ->groupBy('unit_id')
                ->findAll();
        }

        $outgoing_invoice_summary = [];
        $incoming_invoice_summary = [];
        $gider_summary = [];
        
        // Giden faturaların toplamları
        foreach ($invoice_items_outgoing as $invoice_item_outgoing) {
            $money_unit_id = $invoice_item_outgoing['money_unit_id'];
            $money_icon = $invoice_item_outgoing['money_icon'];
        
            if (!isset($outgoing_invoice_summary[$money_unit_id])) {
                $outgoing_invoice_summary[$money_unit_id] = [
                    'money_icon' => $money_icon,
                    'total_sub_total' => 0,
                    'total_tax' => 0,
                    'total_amount' => 0
                ];
            }
        
            // KDV hesaplama
            $tax_1 = $invoice_item_outgoing['tax_rate_1_amount'];
            $tax_10 = $invoice_item_outgoing['tax_rate_10_amount'];
            $tax_20 = $invoice_item_outgoing['tax_rate_20_amount'];
            $total_tax = floatval($tax_1) + floatval($tax_10) + floatval($tax_20);
        
            $outgoing_invoice_summary[$money_unit_id]['total_sub_total'] += floatval($invoice_item_outgoing['sub_total']);
            $outgoing_invoice_summary[$money_unit_id]['total_tax'] += $total_tax;
            $outgoing_invoice_summary[$money_unit_id]['total_amount'] += floatval($invoice_item_outgoing['amount_to_be_paid']);
        }
        
        // Gelen faturaların toplamları
        foreach ($invoice_items_incoming as $invoice_item_incoming) {
            $money_unit_id = $invoice_item_incoming['money_unit_id'];
            $money_icon = $invoice_item_incoming['money_icon'];
        
            if (!isset($incoming_invoice_summary[$money_unit_id])) {
                $incoming_invoice_summary[$money_unit_id] = [
                    'money_icon' => $money_icon,
                    'total_sub_total' => 0,
                    'total_tax' => 0,
                    'total_amount' => 0
                ];
            }
        
            // KDV hesaplama
            $tax_1 = $invoice_item_incoming['tax_rate_1_amount'];
            $tax_10 = $invoice_item_incoming['tax_rate_10_amount'];
            $tax_20 = $invoice_item_incoming['tax_rate_20_amount'];
            $total_tax = floatval($tax_1) + floatval($tax_10) + floatval($tax_20);
        
            $incoming_invoice_summary[$money_unit_id]['total_sub_total'] += floatval($invoice_item_incoming['sub_total']);
            $incoming_invoice_summary[$money_unit_id]['total_tax'] += $total_tax;
            $incoming_invoice_summary[$money_unit_id]['total_amount'] += floatval($invoice_item_incoming['amount_to_be_paid']);
        }

        // Gider toplamları
        foreach ($gider_items as $gider_item) {
            $money_unit_id = $gider_item['money_unit_id'];
            $money_icon = $gider_item['money_icon'];

            if (!isset($gider_summary[$money_unit_id])) {
                $gider_summary[$money_unit_id] = [
                    'money_icon' => $money_icon,
                    'total_sub_total' => 0,
                    'total_tax' => 0,
                    'total_amount' => 0
                ];
            }

            // KDV hesaplama
            $tax_1 = $gider_item['tax_rate_1_amount'];
            $tax_10 = $gider_item['tax_rate_10_amount'];
            $tax_20 = $gider_item['tax_rate_20_amount'];
            $total_tax = floatval($tax_1) + floatval($tax_10) + floatval($tax_20);

            $gider_summary[$money_unit_id]['total_sub_total'] += floatval($gider_item['sub_total']);
            $gider_summary[$money_unit_id]['total_tax'] += $total_tax;
            $gider_summary[$money_unit_id]['total_amount'] += floatval($gider_item['amount_to_be_paid']);
        }
        
        $unitTitles = $this->modelUnit->select('unit_id, unit_title')->where("status", "active")->findAll();
        $unitTitleMap = [];
        
        foreach ($unitTitles as $unit) {
            $unitTitleMap[$unit['unit_id']] = $unit['unit_title'];
        }
        
        $outgoingInvoiceMap = [];
        foreach ($outgoingInvoiceRows as $row) {
            $outgoingInvoiceMap[$row['unit_id']] = $row['total_amount'];
        }
        
        $incomingInvoiceMap = [];
        foreach ($incomingInvoiceRows as $row) {
            $incomingInvoiceMap[$row['unit_id']] = $row['total_amount'];
        }
        
        $outgoingInvoiceSummary = [];
        foreach ($unitTitleMap as $unit_id => $unit_title) {
            $total_amount = isset($outgoingInvoiceMap[$unit_id]) ? $outgoingInvoiceMap[$unit_id] : '0.00';
            $outgoingInvoiceSummary[] = [
                'unit_title' => $unit_title,
                'total_amount' => $total_amount,
            ];
        }
        
        $incomingInvoiceSummary = [];
        foreach ($unitTitleMap as $unit_id => $unit_title) {
            $total_amount = isset($incomingInvoiceMap[$unit_id]) ? $incomingInvoiceMap[$unit_id] : '0.00';
            $incomingInvoiceSummary[] = [
                'unit_title' => $unit_title,
                'total_amount' => $total_amount,
            ];
        }
        
        $data = [
            'page_title' => $page_title,
            'unitTitleMap' => $unitTitleMap,
            'outgoing_invoice_summary' => $outgoing_invoice_summary,
            'incoming_invoice_summary' => $incoming_invoice_summary,
            'gider_summary' => $gider_summary,
            'incomingInvoiceSummary' => $incomingInvoiceSummary,
            'outgoingInvoiceSummary' => $outgoingInvoiceSummary,
            'invoice_items_outgoing' => $invoice_items_outgoing,
            'invoice_items_incoming' => $invoice_items_incoming,
            'gider_items' => $gider_items,
            'date' => $date,
        ];

   

        return view('tportal/raporlar/rapor_gunluk', $data);
    }








    //gelir raporları
    public function outgoing()
    {

        $page_title = "Gelir Raporları";


        // print_r($invoice_items);
        // return;

        $data = [
            'page_title' => $page_title,
        ];

        return view('tportal/raporlar/rapor_satis', $data);
    }

    public function outgoing_datatable()
    {
        
        $builder = $this->modelInvoice
            ->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->join('invoice_serial', 'invoice_serial.invoice_serial_id = invoice.invoice_serial_id', 'left')
            ->join('invoice_outgoing_status ios', 'ios.invoice_outgoing_status_id = invoice.invoice_status_id', 'left')
            ->select('invoice.user_id,
                invoice.invoice_id,
                invoice.invoice_no,
                money_unit.money_icon,
                invoice.invoice_date,
                invoice.invoice_type,
                invoice.invoice_scenario,
                invoice.invoice_direction,
                invoice_serial.invoice_serial_prefix,
                invoice.money_unit_id,
                invoice.cari_id,
                invoice.sub_total,
                invoice.discount_total,
                invoice.tax_rate_1_amount,
                invoice.tax_rate_1_amount_try,
                invoice.tax_rate_10_amount,
                invoice.tax_rate_10_amount_try,
                invoice.tax_rate_20_amount,
                invoice.tax_rate_20_amount_try,
                invoice.amount_to_be_paid,
                invoice.amount_to_be_paid_try,
                invoice.sale_type,
                invoice.cari_invoice_title,
                ios.status_name,
                ios.status_info,')
            ->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice.cari_id !=', session()->get("user_item")["stock_user"] ?? 0)
            ->where('invoice_direction', 'outgoing_invoice')
            ->where('invoice.cari_id != 15199', null, false)
            ->where('invoice.deleted_at IS NULL', null, false)
            ->orderBy('invoice.invoice_date', 'DESC');


        return DataTable::of($builder)
            ->setSearchableColumns(['invoice.cari_invoice_title', 'invoice.invoice_no'])
            ->toJson(true);
    }


    public function incoming()
    {

        $page_title = "Gider Raporları";


        // print_r($invoice_items);
        // return;

        $data = [
            'page_title' => $page_title,
        ];

        return view('tportal/raporlar/rapor_alis', $data);
    }

    public function incoming_datatable()
    {
        $db = \Config\Database::connect($this->currentDB);
        
        // Geçici view oluştur
        $db->query('CREATE OR REPLACE VIEW combined_view AS 
            SELECT 
                invoice.user_id,
                invoice.invoice_id as id,
                CAST(invoice.invoice_no AS CHAR(50)) COLLATE utf8_general_ci as invoice_no,
                CAST(money_unit.money_icon AS CHAR(10)) COLLATE utf8_general_ci as money_icon,
                invoice.invoice_date as invoice_date,
                CAST(invoice.invoice_type AS CHAR(50)) COLLATE utf8_general_ci as invoice_type,
                CAST(invoice.invoice_scenario AS CHAR(50)) COLLATE utf8_general_ci as invoice_scenario,
                CAST(invoice.invoice_direction AS CHAR(50)) COLLATE utf8_general_ci as invoice_direction,
                CAST(invoice_serial.invoice_serial_prefix AS CHAR(50)) COLLATE utf8_general_ci as invoice_serial_prefix,
                invoice.money_unit_id,
                invoice.sub_total,
                invoice.tax_rate_1_amount,
                invoice.tax_rate_1_amount_try,
                invoice.tax_rate_10_amount,
                invoice.tax_rate_10_amount_try,
                invoice.tax_rate_20_amount,
                invoice.tax_rate_20_amount_try,
                invoice.amount_to_be_paid,
                invoice.amount_to_be_paid_try,
                CAST(invoice.sale_type AS CHAR(50)) COLLATE utf8_general_ci as sale_type,
                CAST(invoice.cari_invoice_title AS CHAR(255)) COLLATE utf8_general_ci as cari_invoice_title,
                CAST(iis.status_name AS CHAR(50)) COLLATE utf8_general_ci as status_name,
                CAST(iis.status_info AS CHAR(255)) COLLATE utf8_general_ci as status_info,
                "invoice" as type
            FROM invoice 
            JOIN money_unit ON money_unit.money_unit_id = invoice.money_unit_id
            LEFT JOIN invoice_serial ON invoice_serial.invoice_serial_id = invoice.invoice_serial_id
            LEFT JOIN invoice_incoming_status iis ON iis.invoice_incoming_status_id = invoice.invoice_status_id
            WHERE invoice.cari_id != ' . (session()->get("user_item")["stock_user"] ?? 0) . '
            AND invoice.user_id = ' . session()->get('user_id') . '
            AND invoice_direction = "incoming_invoice"
            AND invoice.deleted_at IS NULL
            AND invoice.cari_id != 15199
            UNION ALL
            
            SELECT 
                giderler.user_id,
                giderler.gider_id as id,
                CAST(giderler.gider_no AS CHAR(50)) COLLATE utf8_general_ci as invoice_no,
                CAST(money_unit.money_icon AS CHAR(10)) COLLATE utf8_general_ci as money_icon,
                giderler.gider_date as invoice_date,
                CAST(NULL AS CHAR(50)) COLLATE utf8_general_ci as invoice_type,
                CAST(NULL AS CHAR(50)) COLLATE utf8_general_ci as invoice_scenario,
                CAST(NULL AS CHAR(50)) COLLATE utf8_general_ci as invoice_direction,
                CAST(NULL AS CHAR(50)) COLLATE utf8_general_ci as invoice_serial_prefix,
                giderler.money_unit_id,
                giderler.sub_total,
                giderler.tax_rate_1_amount,
                giderler.tax_rate_1_amount_try,
                giderler.tax_rate_10_amount,
                giderler.tax_rate_10_amount_try,
                giderler.tax_rate_20_amount,
                giderler.tax_rate_20_amount_try,
                giderler.amount_to_be_paid,
                giderler.amount_to_be_paid_try,
                CAST(NULL AS CHAR(50)) COLLATE utf8_general_ci as sale_type,
                CAST(giderler.cari_invoice_title AS CHAR(255)) COLLATE utf8_general_ci as cari_invoice_title,
                CAST(giderler.offer_status AS CHAR(50)) COLLATE utf8_general_ci as status_name,
                CAST(NULL AS CHAR(255)) COLLATE utf8_general_ci as status_info,
                "gider" as type
            FROM giderler
            JOIN money_unit ON money_unit.money_unit_id = giderler.money_unit_id
            JOIN financial_movement ON financial_movement.gider_id = giderler.gider_id
            WHERE giderler.user_id = ' . session()->get('user_id') . '
            AND giderler.cari_id != ' . (session()->get("user_item")["stock_user"] ?? 0) . '
            AND financial_movement.transaction_type = "incoming_gider"
            AND giderler.deleted_at IS NULL');

        // View'dan veri çek
        $builder = $db->table('combined_view')
            ->orderBy('invoice_date', 'DESC');

        return DataTable::of($builder)
            ->setSearchableColumns(['cari_invoice_title', 'invoice_date', 'invoice_no'])
            ->toJson(true);
    }

}