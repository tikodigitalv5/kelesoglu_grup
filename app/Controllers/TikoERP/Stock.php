<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;
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
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;

use CodeIgniter\I18n\Time;
use Exception;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;
use tidy;
use DateTime;
use \Hermawan\DataTables\DataTable;

use function PHPUnit\Framework\returnSelf;



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

/**
 * @property IncomingRequest $request 
 */

 ini_set('memory_limit', '1024M'); // Bellek limitini 512 MB yap
 ini_set('max_execution_time', "-1");
 
class Stock extends BaseController
{
    private $DatabaseConfig;
    private $currentDB;

    private $modelCari;
    private $modelStock;
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
    private $logClass;

    private $temp_schema;
    private $cacheList;
    private $modelProduction;

    private $modelProductionRow;

    private $modelProductionOperation;

    private $modelProductionOperationRow;
    private $modalStockExcel;

    private $modelStockBarkodlar;


    private $modelOperationResource;

    
    private $modelProductionOperationRowModel;

    private $modelSysmondBarkodlar;

    private $modelMaliyetLogs;
    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
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
        $this->modelProductionOperationRowModel = model($TikoERPModelPath . '\ProductionOperationRowModel', true, $db_connection);
        $this->modalStockExcel = model($TikoERPModelPath . '\StockExcelModel', true, $db_connection);
        $this->modelStockBarkodlar = model($TikoERPModelPath . '\SysmondBarkodlar', true, $db_connection);
        $this->modelOperationResource = model($TikoERPModelPath . '\OperationResource', true, $db_connection);
        $this->modelOperation = model($TikoERPModelPath . '\OperationModel', true, $db_connection);
        $this->logClass = new Log();
        $this->modelSysmondBarkodlar = model($TikoERPModelPath . '\SysmondBarkodlar', true, $db_connection);
        $this->modelMaliyetLogs = model($TikoERPModelPath . '\MaliyetLogsModel', true, $db_connection);

        helper('date');
        helper('text');
        helper('Helpers\barcode_helper');
        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\stock_func_helper');
    }

    public function getStockQuantity($stockId)
    {
        $stock = $this->modelStock->find($stockId);
        if (!$stock) {
            return null; // Stok bulunamazsa null döndür
        }

        if ($stock['parent_id'] == 0) {
            $subStocks = $this->modelStockWarehouseQuantity->where('parent_id', $stockId)->findAll();
            $totalQuantity = 0;
            foreach ($subStocks as $subStock) {
                $totalQuantity += $this->getStockQuantity($subStock['stock_id']);
            }
            return $totalQuantity;
        } else {
            return 0;
        }
    }


    public function getExcelStock()
    {
        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Başlıkları ayarla ve stilleri düzenle
            $sheet->setCellValue('A1', 'Stok Adı');
            $sheet->setCellValue('B1', 'Stok Kodu');
            $sheet->setCellValue('C1', 'Birim');
            $sheet->setCellValue('D1', 'Ortalama Fiyat (Alış)');
            $sheet->setCellValue('E1', 'Miktar');
            $sheet->setCellValue('F1', 'Toplam Tutar');

            // Başlık stillerini ayarla
            $headerStyle = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'E2EFDA',
                    ],
                ],
            ];
            $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

            // Sütun genişliklerini ayarla
            $sheet->getColumnDimension('A')->setWidth(40);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(20);

            // Ana stokları al (parent_id = 0 ve buy_unit_id = 5 olanlar)
            $mainStocks = $this->modelStock
                ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
                ->where('stock.user_id', session()->get('user_id'))
                ->where('stock.parent_id', 0)
                ->where('stock.buy_unit_id', 6)
                ->where('stock.deleted_at IS NULL', null, false)
                ->findAll();

            $row = 2;
            foreach ($mainStocks as $mainStock) {
                // Ana stok için ortalama fiyat hesapla
                $ana_fatura_satirlari = $this->modelInvoiceRow
                    ->select('invoice_row.*, invoice.invoice_direction')
                    ->join('invoice', 'invoice.invoice_id = invoice_row.invoice_id')
                    ->where('invoice_row.stock_id', $mainStock['stock_id'])
                    ->where('invoice.invoice_direction', 'incoming_invoice')
                    ->where('invoice_row.deleted_at IS NULL', null, false)
                    ->where('invoice.deleted_at IS NULL', null, false)
                    ->findAll();

                $ana_toplam_fiyat = 0;
                $ana_toplam_miktar = 0;
                foreach($ana_fatura_satirlari as $hareket){
                    $ana_toplam_fiyat += $hareket['unit_price'] * $hareket['stock_amount'];
                    $ana_toplam_miktar += $hareket['stock_amount'];
                }

                $ortalama_fiyat = $ana_toplam_miktar > 0 ? $ana_toplam_fiyat / $ana_toplam_miktar : 0;

                // Ana stok bilgilerini yaz
                $sheet->setCellValue('A' . $row, $mainStock['stock_title']);
                $sheet->setCellValue('B' . $row, $mainStock['stock_code']);
                $sheet->setCellValue('C' . $row, $mainStock['unit_title']);
                $sheet->setCellValue('D' . $row, $ortalama_fiyat);
                $sheet->setCellValue('E' . $row, $mainStock['stock_total_quantity']);
                $sheet->setCellValue('F' . $row, $ortalama_fiyat * $mainStock['stock_total_quantity']); // Direkt çarpımı yazıyoruz

                // Ana stok satırını kalın yap
                $sheet->getStyle('A' . $row . ':F' . $row)->getFont()->setBold(true);

                $row++;

                // Alt stokları al
                $subStocks = $this->modelStock
                    ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
                    ->where('stock.user_id', session()->get('user_id'))
                    ->where('stock.parent_id', $mainStock['stock_id'])
                    ->where('stock.buy_unit_id', 6)
                    ->where('stock.deleted_at IS NULL', null, false)
                    ->findAll();

                foreach ($subStocks as $subStock) {
                    // Alt stok için ortalama fiyat hesapla
                    $sub_fatura_satirlari = $this->modelInvoiceRow
                        ->select('invoice_row.*, invoice.invoice_direction')
                        ->join('invoice', 'invoice.invoice_id = invoice_row.invoice_id')
                        ->where('invoice_row.stock_id', $subStock['stock_id'])
                        ->where('invoice.invoice_direction', 'incoming_invoice')
                        ->where('invoice_row.deleted_at IS NULL', null, false)
                        ->where('invoice.deleted_at IS NULL', null, false)
                        ->findAll();

                    $sub_toplam_fiyat = 0;
                    $sub_toplam_miktar = 0;
                    foreach($sub_fatura_satirlari as $hareket){
                        $sub_toplam_fiyat += $hareket['unit_price'] * $hareket['stock_amount'];
                        $sub_toplam_miktar += $hareket['stock_amount'];
                    }

                    $sub_ortalama_fiyat = $sub_toplam_miktar > 0 ? $sub_toplam_fiyat / $sub_toplam_miktar : 0;

                    // Alt stok bilgilerini yaz ve girintili göster
                    $sheet->setCellValue('A' . $row, '    ' . $subStock['stock_title']);
                    $sheet->setCellValue('B' . $row, $subStock['stock_code']);
                    $sheet->setCellValue('C' . $row, $subStock['unit_title']);
                    $sheet->setCellValue('D' . $row, $sub_ortalama_fiyat);
                    $sheet->setCellValue('E' . $row, $subStock['stock_total_quantity']);
                    $sheet->setCellValue('F' . $row, $sub_ortalama_fiyat * $subStock['stock_total_quantity']); // Direkt çarpımı yazıyoruz
                    $row++;
                }
            }

            // Tüm hücrelere kenarlık ekle
            $sheet->getStyle('A1:F' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Para birimi formatını ayarla
            $sheet->getStyle('D2:D' . ($row - 1))->getNumberFormat()->setFormatCode('#,##0.00 ₺');
            $sheet->getStyle('F2:F' . ($row - 1))->getNumberFormat()->setFormatCode('#,##0.00 ₺');
            
            // Miktar sütununu sayısal formata çevir
            $sheet->getStyle('E2:E' . ($row - 1))->getNumberFormat()->setFormatCode('#,##0.00');

            // En alta toplam satırı ekle
            $sheet->setCellValue('A' . $row, 'GENEL TOPLAM');
            $sheet->setCellValue('F' . $row, '=SUM(F2:F'.($row-1).')');
            $sheet->getStyle('A'.$row.':F'.$row)->getFont()->setBold(true);
            $sheet->getStyle('F'.$row)->getNumberFormat()->setFormatCode('#,##0.00 ₺');

            // Excel dosyasını oluştur
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = 'stok_listesi_' . date('Y-m-d_H-i-s') . '.xlsx';
            
            // Dizinin varlığını kontrol et
            $uploadPath = WRITEPATH . 'uploads/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $filePath = $uploadPath . $fileName;
            $writer->save($filePath);

            return $this->response->download($filePath, null)->setFileName($fileName);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Excel dosyası oluşturulurken bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }




    public function getStock($stock_type = 'all')
    {
        $builder = $this->modelStock->join('category', 'category.category_id = stock.category_id')
            ->join('type', 'type.type_id = stock.type_id','left')
            ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->select('(select count(stock_id) from stock as child where parent_id = stock.stock_id AND child.deleted_at IS NULL) as substock_count')
            ->select('stock.stock_id, stock.stock_title, stock.stock_code, stock.status, stock.default_image, category.category_title, type.type_title, buy_unit.unit_title as buy_unit_title, sale_unit.unit_title as sale_unit_title, stock.stock_total_quantity,')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('parent_id', 0)
            ->where('stock.deleted_at IS NULL', null, false);


        if ($stock_type == 'all') {
            $builder = $builder;
        } elseif ($stock_type == 'services') {
            $builder = $this->modelStock->where('stock.stock_type', 'service');
        } elseif ($stock_type == 'products') {
            $builder = $this->modelStock->where('stock.stock_type', 'product');
        } else {
            return redirect()->back();
        }

        $builder = $builder->orderBy(
            '(CASE WHEN stock.stock_total_quantity > 0 THEN 1 ELSE 0 END)', 'DESC' // Parantez içine alıyoruz
        )->orderBy('stock.stock_total_quantity', 'DESC'); // Büyükten küçüğe sıralama

        return DataTable::of($builder)->filter(function ($builder, $request) {
            if ($request->category_id)
                $builder->where('stock.category_id', $request->category_id);
            if ($request->type_id)
                $builder->where('stock.type_id', $request->type_id);
        })
            ->setSearchableColumns(['stock.stock_title', 'stock.stock_code', 'stock.stock_barcode'])
            ->toJson(true);
    }




    
    
    
    


    public function getSubStock2($stock_type = 'all')
    {
        $builder = $this->modelStock
            ->join('type', 'type.type_id = stock.type_id','left')
            ->join('unit', 'unit.unit_id = stock.sale_unit_id')
            ->join('stock_warehouse_quantity', 'stock_warehouse_quantity.stock_id = stock.stock_id', 'LEFT')
            ->join('warehouse', 'warehouse.warehouse_id = stock_warehouse_quantity.warehouse_id', 'LEFT')
            ->select('(select count(stock_id) from stock as child where parent_id = stock.stock_id AND child.deleted_at IS NULL) as substock_count')
            ->select('stock.stock_id, stock.stock_title, stock.stock_code, stock.status, stock.default_image, stock.stock_total_quantity, stock.sale_unit_id, unit.unit_title, stock.sale_unit_price, warehouse.warehouse_id, warehouse.warehouse_title, stock.sale_tax_rate')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.parent_id !=', 0)
            ->where('stock.deleted_at IS NULL', null, false);



        // $builder = $this->modelStock->join('category', 'category.category_id = stock.category_id')
        //     ->join('money_unit', 'money_unit.money_unit_id = stock.sale_money_unit_id')
        //     ->join('type', 'type.type_id = stock.type_id')
        //     ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
        //     ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
        //     ->join('stock_warehouse_quantity', 'stock_warehouse_quantity.stock_id = stock.stock_id', 'LEFT')
        //     ->join('warehouse', 'warehouse.warehouse_id = stock_warehouse_quantity.warehouse_id', 'LEFT')
        //     ->select('category.category_title, type.type_title, buy_unit.unit_title as buy_unit_title, sale_unit.unit_title as sale_unit_title, stock.*, money_unit.money_icon as sale_money_icon, warehouse.*')
        //     ->where('stock.user_id', session()->get('user_id'))
        //     ->where('parent_id !=', 0)
        //     ->where('stock.deleted_at IS NULL', null, false);



        if ($stock_type == 'all') {
            $builder = $builder;
        } elseif ($stock_type == 'services') {
            $builder = $this->modelStock->where('stock.stock_type', 'service');
        } elseif ($stock_type == 'products') {
            $builder = $this->modelStock->where('stock.stock_type', 'product');
        } elseif ($stock_type == 'create') { //fatura oluştur search
            $builder = $this->modelStock->where('stock.stock_type', 'product');
        } else {
            return redirect()->back();
        }


        // print_r($builder->findAll());
        // return;

        return DataTable::of($builder)
            ->setSearchableColumns(['stock.stock_title', 'stock.stock_code', 'stock.stock_barcode'])
            ->toJson(true);
    }

    // # Varyantların Select Çıktıları
    public function getStockVariant()
    {   
        $stock_id = $this->request->getPost("id");
        $html   = "";
        
        $stockVariant = $this->modelStock->where('stock_id', $stock_id)->first();
        $variant_group_items = $this->modelVariantGroup    
                            ->where('variant_group.user_id', session()->get('user_id'))
                            ->join('variant_group_category', 'variant_group_category.variant_group_id = variant_group.variant_group_id', 'LEFT')
                            ->where("variant_group_category.category_id", $stockVariant["category_id"])
                            ->orderBy('order', 'ASC')
                            ->where('variant_group_category.deleted_at IS NULL', null, false)
                            ->findAll();

                                   

        $variant_property_items = $this->modelVariantProperty->findAll();

       

        foreach($variant_group_items as $variant_group_item)
        {
            $htmlsub = ""; 
            foreach($variant_property_items as $variant_property_item){
                if($variant_group_item["variant_group_id"] == $variant_property_item["variant_group_id"]){
                    $htmlsub.= '

                    <option
                    data-variant="'.$variant_property_item["variant_property_id"].'"
                    data-variant-column="variant_'.$variant_group_item["variant_column"].'"
                    value="'.$variant_property_item["variant_property_id"].'">
                   '.$variant_property_item["variant_property_title"].'</option>
                
                    ';
                }
               
            }
            $html .= '
            
                 <div class="form-group col-md-3">
                                    <label class="overline-title overline-title-alt">
                                       '.$variant_group_item['variant_title'].'</label>
                                    <select class="form-select variant_select "
                                        id="variant_'.$variant_group_item['variant_group_id'].'" data-ui="lg"
                                        data-search="on" data-placeholder="Seçiniz">
                                        <option value="0" disabled selected>Seçiniz</option>
                                        <option value="tumu" 
                                            data-variant="tumu"  
                                            data-variant-column="tumu"
                                            >Tümü</option>
                                            '.$htmlsub.'
                                    </select>
                </div>

            ';
        }

        return $html;

    }
    // ALT ÜRÜNLERİN LİSTESİ
    public function getSubStockDatatable($stock_type = "all")
    {   

        $id = $this->request->getPost("id");
       
        $Varyantlar =   $this->request->getPost('selectedValues');
   

     
        $builder = $this->modelStock
            ->join('type', 'type.type_id = stock.type_id','left')
            ->join('unit', 'unit.unit_id = stock.sale_unit_id')
            ->join('money_unit', 'money_unit.money_unit_id = stock.sale_money_unit_id')
            ->join('stock_warehouse_quantity', 'stock_warehouse_quantity.stock_id = stock.stock_id', 'LEFT')
            ->join('warehouse', 'warehouse.warehouse_id = stock_warehouse_quantity.warehouse_id', 'LEFT')
            ->join('stock_variant_group', 'stock_variant_group.stock_id = stock.stock_id', 'LEFT')
            ->select('(select count(stock_id) from stock as child where parent_id = stock.stock_id AND child.deleted_at IS NULL) as substock_count')
            ->select('stock.stock_id, stock.stock_type, stock.parent_id,  stock.stock_title, stock.has_variant,  stock.stock_code, stock.status, stock.default_image, stock.stock_total_quantity, stock.sale_unit_id, unit.unit_title, stock.sale_unit_price, warehouse.warehouse_id, warehouse.warehouse_title, stock.sale_tax_rate, money_unit.money_icon')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.parent_id =', $id)
            ->where('stock.deleted_at IS NULL', null, false);


        // $builder = $this->modelStock->join('category', 'category.category_id = stock.category_id')
        //     ->join('money_unit', 'money_unit.money_unit_id = stock.sale_money_unit_id')
        //     ->join('type', 'type.type_id = stock.type_id')
        //     ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
        //     ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
        //     ->join('stock_warehouse_quantity', 'stock_warehouse_quantity.stock_id = stock.stock_id', 'LEFT')
        //     ->join('warehouse', 'warehouse.warehouse_id = sm.to_warehouse', 'left')
        //     ->join('unit', 'unit.unit_id = child.sale_unit_id')
        //     ->join('invoice', 'invoice.invoice_id = sm.invoice_id')
        //     ->where('child.stock_id', $stock_id)
        //     ->orwhere('child.parent_id', $stock_id)
        //     ->where('child.deleted_at IS NULL')
        //     ->where('sm.deleted_at IS NULL')
        //     ->where('sb.deleted_at IS NULL')
        //     ->orderBy('sm.transaction_date')
        //     ->findAll();

        if($Varyantlar != 0){
            foreach($Varyantlar as $varyant){
                $text = "stock_variant_group." . $varyant["name"];
                if(!empty($varyant["value"]) && !empty($varyant["name"]) && $varyant["name"] != "tumu"  && $varyant["value"] != "tumu") {
                    $builder = $this->modelStock->where($text, $varyant["value"]);
            
                }
            }
        }
    
        
      

        if ($stock_type == 'all') {
            $builder = $builder;
        } elseif ($stock_type == 'services') {
            $builder = $this->modelStock->where('stock.stock_type', 'service');
        } elseif ($stock_type == 'products') {
            $builder = $this->modelStock->where('stock.stock_type', 'product');
        } elseif ($stock_type == 'create') { //fatura oluştur search
            $builder = $this->modelStock->where('stock.stock_type', 'product');
        }elseif ($stock_type == 'edit') { //fatura oluştur search
            $builder = $this->modelStock->where('stock.stock_type', 'product');
        } else {
            return redirect()->back();
        }


        // print_r($builder->findAll());
        // return;

        return DataTable::of($builder)
            ->setSearchableColumns(['stock.stock_title', 'stock.stock_code', 'stock.stock_barcode'])
            ->toJson(true);
    }


 

    public function getSubStock($stock_type = 'all')
    {

        $draw = $this->request->getPost('draw') ?? $this->request->getGet('draw') ?? 1;
        if ($this->request->getPost('no_search') == 'true' || $this->request->getGet('no_search') == 'true') {
            echo json_encode([
                "draw" => intval($draw),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ]);
            exit;
        }




        $searchValue = $this->request->getVar('search_value');
        
        // Builder'ı oluştur
        $builder = $this->modelStock
            ->select([
                'stock.stock_id',
                'stock.stock_title', 
                'stock.stock_code',
                'stock.default_image',
                'stock.stock_total_quantity',
                'stock.sale_unit_price',
                'stock.sale_tax_rate',
                'stock.parent_id',
                'stock.has_variant',
                'stock.status',
                'unit.unit_title',
                'warehouse.warehouse_title',
                'money_unit.money_icon'
            ])
            ->join('money_unit', 'money_unit.money_unit_id = stock.sale_money_unit_id')
            ->join('unit', 'unit.unit_id = stock.sale_unit_id')
            ->join('stock_warehouse_quantity', 'stock_warehouse_quantity.stock_id = stock.stock_id', 'LEFT')
            ->join('warehouse', 'warehouse.warehouse_id = stock_warehouse_quantity.warehouse_id', 'LEFT')
            ->where('stock.deleted_at IS NULL', null, false)
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.parent_id', 0);
    
        // Arama değeri varsa ve 3 karakterden uzunsa filtrele
        if (!empty($searchValue) && strlen($searchValue) >= 3) {
            $builder->groupStart()
                ->like('stock.stock_title', $searchValue)
                ->orLike('stock.stock_code', $searchValue)
                ->orLike('stock.stock_barcode', $searchValue)
            ->groupEnd();
        }
    
        $builder->limit(50); // Maksimum 50 sonuç
    
        return DataTable::of($builder)->toJson(true);
    }



    
    public function list($stock_type = 'all')
    {
        $pageSize = $this->request->getGet('pageSize' ?? 15);
        $search = $this->request->getGet('search');
        $categoryId = $this->request->getGet('categoryId');
        $typeId = $this->request->getGet('typeId');
        $pager = \Config\Services::pager();

        $category_items = $this->modelCategory->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();
        $type_items = $this->modelType->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();
        $stock_items = $this->modelStock->join('category', 'category.category_id = stock.category_id')
            ->join('type', 'type.type_id = stock.type_id','left')
            ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->select('category.category_title, type.type_title, buy_unit.unit_title as buy_unit_title, sale_unit.unit_title as sale_unit_title, stock.*')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('parent_id', 0);
        if ($stock_type == 'all') {
            $stock_items = $stock_items;
        } elseif ($stock_type == 'services') {
            $stock_items = $this->modelStock->where('stock.stock_type', 'service');
        } elseif ($stock_type == 'products') {
            $stock_items = $this->modelStock->where('stock.stock_type', 'product');
        } else {
            return redirect()->back();
        }



        // Paginate işlemi için tüm list fonksiyonlarının yukarıdaki yapıya çevirilmesi gerekiyor.
        // Paginate ile direk erişebiliyoruz. Pager ile de viewda ekrana basıyoruz.
        // Birden fazla paginate kullanılacaksa: 
        // 'users' => $userModel->paginate(10, 'group1'),
        // 'pages' => $pageModel->paginate(15, 'group2'),
        // <!-- In your view file: -->
        // $pager->links('group1')
        // $pager->links('group2')
        if ($search) {
            $stock_items = $this->modelStock->like('stock.stock_title', $search);
        }
        if ($categoryId) {
            $stock_items = $this->modelStock->where('category.user_id', session()->get('user_id'))->where('stock.category_id', $categoryId);
        }
        if ($typeId) {
            $stock_items = $this->modelStock->where('type.user_id', session()->get('user_id'))->where('stock.type_id', $typeId);
        }

        //$stock_items = $this->modelStock->paginate($pageSize);


        $stock_items = $this->modelStock
                    ->orderBy('stock.stock_title', 'ASC')
                    ->paginate($pageSize);


        $data = [
            'stock_type' => $stock_type,
            'stock_items' => $stock_items,
            'category_items' => $category_items,
            'type_items' => $type_items,
            'pager' => $pager
        ];


   

        // $stock_items2 = $this->modelStock
        //     ->where('user_id', session()->get('user_id'))
        //     ->onlyDeleted()
        //     ->findAll();


        // foreach ($stock_items2 as $stock_items3) {
        //     $stock_items2 = $this->modelStockWarehouseQuantity
        //         ->where('stock_id', $stock_items3['stock_id'])
        //         ->delete();
        // }


        // $stock_items2 = $this->modelStockWarehouseQuantity
        //     ->where('user_id', session()->get('user_id'))
        //     ->onlyDeleted()
        //     ->findAll(1000);

        //     print_r($stock_items2);
        //     // return;

        // foreach ($stock_items2 as $stock_items3) {

        //     // print_r($stock_items3);
            
        //     // $up_data = [
        //     //     'deleted_at' => '1',
        //     // ];
        //     // $stock_items421 = $this->modelStock->update($stock_items3['stock_id'], $up_data);

        //     // print_r($up_data);

        //     // return;


        //     $update_stock_barcode_data = [
        //         'deleted_at' => NULL,
        //     ];
        //     $this->modelStock->update($stock_items3['stock_id'], ['deleted_at' => null]);
        // }


        // print_r("dur gitme daha fazla");
        // return;

        return view('tportal/stoklar/index', $data);
    }


    ## Barkod İşlemleri  BAŞLANGIÇ

    public function depo_stoklari_say()
    {


        $data = [
            'page_title' => "Stokları Sayın"
        ];
        

        return view('tportal/stoklar/stok/stoksay', $data);
    }


    public function stok_gruplama() {
        $db = $this->userDatabase();  


        $altUrunler = $this->modelStock
        ->where('user_id', session()->get('user_id'))
        ->where('grup_id !=', 0) // Alt ürünleri seç
        ->findAll();
    
    // Her alt ürün için dopigo eşleştirmesi var mı kontrol edelim
    foreach($altUrunler as $altUrun) {
        // Alt ürünün dopigo eşleştirmesini bul
        $dopigoEsleme = $db->table('dopigo_eslestir')
            ->where('stock_id', $altUrun['stock_id'])
            ->where('silindi', 0)
            ->get()
            ->getResultArray();
    
        if(!empty($dopigoEsleme)) {
            // Ana ürünü bul
            $anaUrun = $this->modelStock
                ->where('stock_id', $altUrun['grup_id'])
                ->first();
    
            if($anaUrun) {
                // Her eşleştirmeyi güncelle
                foreach($dopigoEsleme as $esleme) {
                    $db->table('dopigo_eslestir')
                        ->where('dopigo_id', $esleme['dopigo_id'])
                        ->update([
                            'stock_id' => $anaUrun['stock_id'],
                            'stock_title' => $anaUrun['stock_title'],
                            'stock_code' => $anaUrun['stock_code'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
    
                    echo "Dopigo ID: " . $esleme['dopigo_id'] . " için güncelleme yapıldı. ";
                    echo "Alt ürün (" . $altUrun['stock_title'] . ") -> Ana ürün (" . $anaUrun['stock_title'] . ")<br>";
                }
            }
        }
    }
    
    echo "İşlem tamamlandı";
    return;

    /*
        
        // Mevcut stokları al
       /* $stoklar = $this->modelStock->where('user_id', session()->get('user_id'))->findAll();
        
        // Ana ürünleri al
        $anaUrunler = $db->table('urunler')
            ->where('parent_id IS NULL')
            ->get()
            ->getResultArray();
    
        foreach($anaUrunler as $anaUrun) {
            // Ana ürünün stock tablosundaki karşılığını bul
            $anaStok = null;
            foreach($stoklar as $stok) {
                if($stok['stock_code'] == $anaUrun['stok_kodu']) {
                    $anaStok = $stok;
                    break;
                }
            }
    
            if($anaStok) {
                // Alt ürünleri al
                $altUrunler = $db->table('urunler')
                    ->where('parent_id', $anaUrun['id'])
                    ->get()
                    ->getResultArray();
    
                // Her alt ürün için
                foreach($altUrunler as $altUrun) {
                    // Alt ürünün stock tablosundaki karşılığını bul
                    foreach($stoklar as $stok) {
                        if($stok['stock_code'] == $altUrun['stok_kodu']) {
                            // Alt ürünün grup_id'sini güncelle
                            $this->modelStock->update($stok['stock_id'], [
                                'grup_id' => $anaStok['stock_id']
                            ]);
                            break;
                        }
                    }
                }
            }
        }
    
        echo "İşlem tamamlandı";
        return; 



    $altUrunluGruplar = $this->modelStock
    ->select('grup_id')
    ->where('user_id', session()->get('user_id'))
    ->where('grup_id !=', 0)
    ->groupBy('grup_id')
    ->findAll();

$anaUrunIds = array_column($altUrunluGruplar, 'grup_id');

// Ana ürünlerin dopigo eşleştirmelerini alalım
$dopigoEslesmeleri = $db->table('dopigo_eslestir')
    ->where('silindi', 0)
    ->get()
    ->getResultArray();

// Stock ID'ye göre eşleştirmeleri indexleyelim
$dopigoMap = [];
foreach($dopigoEslesmeleri as $esleme) {
    $dopigoMap[$esleme['stock_id']] = $esleme; // Tüm eşleştirme bilgilerini saklayalım
}

// Ana ürünleri çekelim
$anaUrunler = $this->modelStock
    ->where('user_id', session()->get('user_id'))
    ->whereIn('stock_id', $anaUrunIds)
    ->findAll();

echo '<table border="1" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 10px;">Stok Kodu</th>
                <th style="padding: 10px;">Ürün Adı</th>
                <th style="padding: 10px;">Stock ID</th>
                <th style="padding: 10px;">Grup ID</th>
                <th style="padding: 10px;">DOPİGO</th>
                <th style="padding: 10px;">Eşleşme Durumu</th>
            </tr>
        </thead>
        <tbody>';

foreach($anaUrunler as $anaUrun) {
    echo '<tr style="background-color: #e6f3ff;">
            <td style="padding: 8px;"><b>' . $anaUrun['stock_code'] . '</b></td>
            <td style="padding: 8px;"><b>' . $anaUrun['stock_title'] . '</b></td>
            <td style="padding: 8px;"><b>' . $anaUrun['stock_id'] . '</b></td>
            <td style="padding: 8px;"><b>' . $anaUrun['grup_id'] . '</b></td>
            <td style="padding: 8px;"></td>
            <td style="padding: 8px;"></td>
        </tr>';

    // Alt ürünleri al
    $altUrunler = $this->modelStock
        ->where('user_id', session()->get('user_id'))
        ->where('grup_id', $anaUrun['stock_id'])
        ->findAll();

    foreach($altUrunler as $altUrun) {
        // Ana ürünün dopigo eşleştirmesi var mı?
        $anaUrunDopigo = isset($dopigoMap[$anaUrun['stock_id']]) ? $dopigoMap[$anaUrun['stock_id']] : null;
        
        $eslesme = '';
        if($anaUrunDopigo && $anaUrunDopigo['dopigo_code'] == $altUrun['stock_code']) {
            $eslesme = '<span style="background-color: #28a745; color: white; padding: 2px 6px; border-radius: 3px;">Eşleşti</span>';
        }

        echo '<tr>
                <td style="padding: 8px; padding-left: 20px;">└─ ' . $altUrun['stock_code'] . '</td>
                <td style="padding: 8px;">' . $altUrun['stock_title'] . '</td>
                <td style="padding: 8px;">' . $altUrun['stock_id'] . '</td>
                <td style="padding: 8px;">' . $altUrun['grup_id'] . '</td>
                <td style="padding: 8px;">' . (isset($dopigoMap[$altUrun['stock_id']]) ? $dopigoMap[$altUrun['stock_id']]['dopigo_id'] : '') . '</td>
                <td style="padding: 8px;">' . $eslesme . '</td>
            </tr>';
    }
}

echo '</tbody></table>';
return;

/*
    $altUrunler = $this->modelStock
    ->where('user_id', session()->get('user_id'))
    ->where('grup_id !=', 0) // Alt ürünleri seç
    ->findAll();

// Her alt ürün için dopigo eşleştirmesi var mı kontrol edelim
foreach($altUrunler as $altUrun) {
    // Alt ürünün dopigo eşleştirmesini bul
    $dopigoEsleme = $db->table('dopigo_eslestir')
        ->where('stock_id', $altUrun['stock_id'])
        ->where('silindi', 0)
        ->get()
        ->getResultArray();

    if(!empty($dopigoEsleme)) {
        // Ana ürünü bul
        $anaUrun = $this->modelStock
            ->where('stock_id', $altUrun['grup_id'])
            ->first();

        if($anaUrun) {
            // Her eşleştirmeyi güncelle
            foreach($dopigoEsleme as $esleme) {
                $db->table('dopigo_eslestir')
                    ->where('dopigo_id', $esleme['dopigo_id'])
                    ->update([
                        'stock_id' => $anaUrun['stock_id'],
                        'stock_title' => $anaUrun['stock_title'],
                        'stock_code' => $anaUrun['stock_code'],
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                echo "Dopigo ID: " . $esleme['dopigo_id'] . " için güncelleme yapıldı. ";
                echo "Alt ürün (" . $altUrun['stock_title'] . ") -> Ana ürün (" . $anaUrun['stock_title'] . ")<br>";
            }
        }
    }
}

echo "İşlem tamamlandı";
return; */
    
    }



    public function stok_gruplama_detay($stock_id) {
        $db = $this->userDatabase();  
    
        // Verilen stock_id'ye sahip ürünü bul
        $stok = $this->modelStock
            ->where('user_id', session()->get('user_id'))
            ->where('stock_id', $stock_id)
            ->first();
    
        if(!$stok) {
            return "Ürün bulunamadı";
        }
    
        $gruplar = [];
        
        if($stok['grup_id'] == 0) { // Ana ürün ise
            // Ana ürünü ve alt ürünlerini al
            $gruplar[$stok['stock_id']] = [
                'ana_urun' => $stok,
                'alt_urunler' => $this->modelStock
                    ->where('user_id', session()->get('user_id'))
                    ->where('grup_id', $stok['stock_id'])
                    ->findAll()
            ];
        } else { // Alt ürün ise
            // Ana ürünü bul
            $anaUrun = $this->modelStock
                ->where('user_id', session()->get('user_id'))
                ->where('stock_id', $stok['grup_id'])
                ->first();
    
            if($anaUrun) {
                // Ana ürün ve tüm alt ürünlerini al
                $gruplar[$anaUrun['stock_id']] = [
                    'ana_urun' => $anaUrun,
                    'alt_urunler' => $this->modelStock
                        ->where('user_id', session()->get('user_id'))
                        ->where('grup_id', $anaUrun['stock_id'])
                        ->findAll()
                ];



                


            }
        }
    
        // Dopigo eşleştirmelerini al
        $dopigoEslesmeleri = $db->table('dopigo_eslestir')
            ->where('silindi', 0)
            ->get()
            ->getResultArray();

        
            $dopigoEslesmeleriFull = $db->table('dopigo_eslestir de')
            ->select('de.*, s.default_image, s.stock_total_quantity')
            ->join('stock s', 's.stock_id = de.stock_id')
            ->where('de.silindi', 0)
            ->where('de.stock_id', $stock_id)
            ->get()
            ->getResultArray();

        
    
        // Her eşleştirme için ek bilgileri ekle
        foreach($dopigoEslesmeleriFull as &$eslemem) {
            $eslemem['default_image'] = 'uploads/default.png';
            $urunbul = $this->modelStock->where('stock_code', $eslemem['dopigo_code'])->first();       
            $eslemem["default_image"] = $urunbul['default_image'] ?? "uploads/default.png";
            $eslemem["stock_total_quantity"] = $urunbul['stock_total_quantity'] ?? 0;
            $eslemem['dopigo_info'] = [
                'resim' => $urunbul['default_image'] ?? "uploads/default.png",
                'stock_total_quantity' => $urunbul['stock_total_quantity'] ?? 0,
                'dopigo_id' => $eslemem['dopigo_id'],
                'dopigo_title' => $eslemem['dopigo_title'],
                'dopigo_code' => $eslemem['dopigo_code'],
                'created_at' => $eslemem['created_at'],
                'updated_at' => $eslemem['updated_at']
            ];
        }

   
    

 
        // Dopigo eşleştirmelerini indexle
        $dopigoMap = [];
        foreach($dopigoEslesmeleri as $esleme) {
            $dopigoMap[$esleme['stock_id']] = $esleme;
        }
    
        $data = [
            'dopigoEslesmeleriFull' => $dopigoEslesmeleriFull,
            'stock_item' => $stok,
            'page_title' => 'Grup Detayları',
            'gruplar' => $gruplar,
            'dopigoMap' => $dopigoMap,
            'aranan_urun' => $stok // Hangi ürüne bakıldığını belirtmek için
        ];
    
        return view('tportal/stoklar/detay/grup_detay', $data);
        
    }




    public function stok_barkodlar($stock_id) {


        $stock_item = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock_id', $stock_id)->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')->first();
        if (!$stock_item) {
            return view('not-found');
        }

        if ($stock_item['parent_id'] != 0)
            $parentStockId = $stock_item['parent_id'];
        else
            $parentStockId = 0;

        // $stock_item['stock_total_amount'] = $this->sonStokBilgisi($stock_item['stock_id']);
        $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);

        $operation_items = $this->modelOperation->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();
        $stock_operation_items = $this->modelStockOperation->join('stock', 'stock.stock_id = stock_operation.stock_id')
            ->join('operation', 'operation.operation_id = stock_operation.operation_id')
            ->select('stock_operation.*, operation.operation_title')
            ->where('stock.stock_id', $stock_id)
            ->orderBy('relation_order', 'ASC')
            ->findAll();

          
        
            $stock_operation = $this->modelStockOperation
            ->join('operation', 'operation.operation_id = stock_operation.operation_id')
            ->where("stock_operation.stock_id", $stock_id)
            ->findAll();
        
        $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
        
        // Tüm operasyon türleri için döngü oluştur
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
    
    
        $stock_items = $this->modelStock->where('user_id', session()->get('user_id'))->findAll();
    
    


        if(!$stock_item) {
            return redirect()->back()->with('error', 'Ürün bulunamadı');
        }
       
        // Verilen stock_id'ye sahip ürünü bul
        $stok = $this->modelStockBarkodlar
        ->join('stock', 'stock.stock_id = sysmond_barkodlar.stock_id')
            ->where('sysmond_barkodlar.stock_id', $stock_id)
            ->where('stock.user_id', session()->get('user_id'))
            ->findAll();
    
    
        $data = [
            'stok' => $stok,
            'operation_amounts' => $operation_amounts,
            'stock_operation' => $stock_operation,

        'stock_item' => $stock_item,
        'stock_items' => $stock_items,
        'operation_items' => $operation_items,
        'stock_operation_items' => $stock_operation_items,
        'parentStockId' => $parentStockId,
            'page_title' => 'Stok Barkodları',
            'aranan_urun' => $stok // Hangi ürüne bakıldığını belirtmek için
        ];
    
        return view('tportal/stoklar/detay/stok_barkodlar', $data);
        
    }



    public function stok_barkodlar_aktif($stock_id) {


        $stock_item = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock_id', $stock_id)->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')->first();
        if (!$stock_item) {
            return view('not-found');
        }

        if ($stock_item['parent_id'] != 0)
            $parentStockId = $stock_item['parent_id'];
        else
            $parentStockId = 0;

        // $stock_item['stock_total_amount'] = $this->sonStokBilgisi($stock_item['stock_id']);
        $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);

        $operation_items = $this->modelOperation->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();
        $stock_operation_items = $this->modelStockOperation->join('stock', 'stock.stock_id = stock_operation.stock_id')
            ->join('operation', 'operation.operation_id = stock_operation.operation_id')
            ->select('stock_operation.*, operation.operation_title')
            ->where('stock.stock_id', $stock_id)
            ->orderBy('relation_order', 'ASC')
            ->findAll();

          
        
            $stock_operation = $this->modelStockOperation
            ->join('operation', 'operation.operation_id = stock_operation.operation_id')
            ->where("stock_operation.stock_id", $stock_id)
            ->findAll();
        
        $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
        
        // Tüm operasyon türleri için döngü oluştur
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
    
    
        $stock_items = $this->modelStock->where('user_id', session()->get('user_id'))->findAll();
    
    


        if(!$stock_item) {
            return redirect()->back()->with('error', 'Ürün bulunamadı');
        }
       
    
        // Verilen stock_id'ye sahip ürünü bul
        $stokBarkodlar = [];
        
        $stokSayBak = $this->modelStock->where("stock_id", $stock_id)->first();

        if($stokSayBak['parent_id'] == 0) {
            $stokBarkodlari = $this->modelStock->where("parent_id", $stokSayBak["stock_id"])->findAll();

        foreach($stokBarkodlari as $stokBarkod) {
            $stokBarkodlar[] = $this->modelStockBarcode->select("stock_barcode.*, stock.stock_title, stock.stock_code, warehouse.warehouse_title")
            ->join("stock", "stock.stock_id = stock_barcode.stock_id")
            ->join('warehouse', 'warehouse.warehouse_id = stock_barcode.warehouse_id', 'left')
            ->where("stock_barcode.stock_id", $stokBarkod["stock_id"])
            ->where("stock_barcode.stock_barcode_status", "available")->findAll();
        }
        } else {


            $stokBarkodlar[] = $this->modelStockBarcode->select("stock_barcode.*, stock.stock_title, stock.stock_code, warehouse.warehouse_title")
            ->join("stock", "stock.stock_id = stock_barcode.stock_id")
            ->join('warehouse', 'warehouse.warehouse_id = stock_barcode.warehouse_id', 'left')
            ->where("stock_barcode.stock_id", $stock_id)
            ->where("stock_barcode.stock_barcode_status", "available")->findAll();
       
        }



    

    
        $data = [
            'stok' => $stokBarkodlar,
            'operation_amounts' => $operation_amounts,
            'stock_operation' => $stock_operation,

        'stock_item' => $stock_item,
        'stock_items' => $stock_items,
        'operation_items' => $operation_items,
        'stock_operation_items' => $stock_operation_items
        ];
    
        return view('tportal/stoklar/detay/stok_barkodlar_aktif', $data);
        
    }


    public function grup_ve_dopigo(){
        $db = $this->userDatabase();  
    
        $altUrunler = $this->modelStock
            ->where('user_id', session()->get('user_id'))
            ->where('grup_id !=', 0)
            ->findAll();
    
        $guncellemeler = [];
        $hata_mesajlari = [];
        $toplam_islenen = 0;
        $toplam_guncellenen = 0;
    
        foreach($altUrunler as $altUrun) {
            $toplam_islenen++;
            $dopigoEsleme = $db->table('dopigo_eslestir')
                ->where('stock_id', $altUrun['stock_id'])
                ->where('silindi', 0)
                ->get()
                ->getResultArray();
    
            if(!empty($dopigoEsleme)) {
                $anaUrun = $this->modelStock
                    ->where('stock_id', $altUrun['grup_id'])
                    ->first();
    
                if($anaUrun) {
                    foreach($dopigoEsleme as $esleme) {
                        try {
                           /* $db->table('dopigo_eslestir')
                                ->where('dopigo_id', $esleme['dopigo_id'])
                                ->update([
                                    'stock_id' => $anaUrun['stock_id'],
                                    'stock_title' => $anaUrun['stock_title'],
                                    'stock_code' => $anaUrun['stock_code'],
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]); */
                            $guncellemeler[] = [
                                'dopigo_id' => $esleme['dopigo_id'],
                                'alt_urun' => [
                                    'stock_id' => $altUrun['stock_id'],
                                    'stock_title' => $altUrun['stock_title'],
                                    'stock_code' => $altUrun['stock_code']
                                ],
                                'ana_urun' => [
                                    'stock_id' => $anaUrun['stock_id'],
                                    'stock_title' => $anaUrun['stock_title'],
                                    'stock_code' => $anaUrun['stock_code']
                                ],
                                'guncelleme_zamani' => date('Y-m-d H:i:s')
                            ];
                            $toplam_guncellenen++;
                        } catch (Exception $e) {
                            $hata_mesajlari[] = [
                                'dopigo_id' => $esleme['dopigo_id'],
                                'hata' => $e->getMessage(),
                                'alt_urun' => $altUrun['stock_title']
                            ];
                        }
                    }
                } else {
                    $hata_mesajlari[] = [
                        'alt_urun_id' => $altUrun['stock_id'],
                        'alt_urun' => $altUrun['stock_title'],
                        'hata' => 'Ana ürün bulunamadı (grup_id: ' . $altUrun['grup_id'] . ')'
                    ];
                }
            }
        }
    
        return $this->response->setJSON([
            'success' => true,
            'islem_ozeti' => [
                'toplam_islenen_alt_urun' => $toplam_islenen,
                'toplam_guncellenen_dopigo' => $toplam_guncellenen,
                'toplam_hata' => count($hata_mesajlari)
            ],
            'guncellemeler' => $guncellemeler,
            'hatalar' => $hata_mesajlari,
            'mesaj' => $toplam_guncellenen . ' adet dopigo eşleştirmesi güncellendi.'
        ]);
    }


    public function check_dopigo_match() {
        $db = $this->userDatabase();
        $stock_id = $this->request->getPost('stock_id');
        
        // Dopigo eşleştirmesini kontrol et
        $match = $db->table('dopigo_eslestir')
            ->where('stock_id', $stock_id)
            ->where('silindi', 0)
            ->get()
            ->getRowArray();
        
        if($match) {
            // Ana ürün bilgilerini al
            $anaUrun = $this->modelStock
                ->where('stock_id', $this->request->getPost('grup_id'))
                ->first();
                
            return $this->response->setJSON([
                'has_match' => true,
                'old_data' => $match,
                'new_data' => $anaUrun
            ]);
        }
        
        return $this->response->setJSON(['has_match' => false]);
    }
    
    public function gruba_yeni_eleman_ekle_dopigo_degistir() {
        $db = $this->userDatabase();
        $stock_id = $this->request->getPost('stock_id');
        $grup_id = $this->request->getPost('grup_id');
        
        // Eski dopigo eşleştirmesini al
        $oldMatch = $db->table('dopigo_eslestir')
            ->where('stock_id', $stock_id)
            ->get()
            ->getRowArray();
        
        // Ana ürün bilgilerini al
        $anaUrun = $this->modelStock->find($grup_id);
        
        // Dopigo eşleştirmesini güncelle
        $db->table('dopigo_eslestir')
            ->where('stock_id', $stock_id)
            ->update([
                'stock_id' => $grup_id,
                'stock_code' => $anaUrun['stock_code'],
                'stock_title' => $anaUrun['stock_title']
            ]);
        
        // Ürünü gruba ekle
        $success = $this->modelStock->update($stock_id, ['grup_id' => $grup_id]);
        
        if($success) {
            // Log kaydı
            $db->table('grup_log')->insert([
                'user_id' => session()->get('user_id'),
                'stock_id' => $stock_id,
                'islem_tipi' => 'GRUBA_EKLEME_VE_DOPIGO_TRANSFER',
                'onceki_veri' => json_encode($oldMatch),
                'sonraki_veri' => json_encode([
                    'stock_id' => $grup_id,
                    'stock_code' => $anaUrun['stock_code'],
                    'stock_title' => $anaUrun['stock_title']
                ]),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        return $this->response->setJSON(['success' => $success]);
    }


    public function update_dopigo_match() {
        $db = $this->userDatabase();
        
        $dopigoId = $this->request->getPost('dopigo_id');
        $stockId = $this->request->getPost('stock_id');
        $stockCode = $this->request->getPost('stock_code');
        $stockTitle = $this->request->getPost('stock_title');
        
        // Eski veriyi al
        $oldMatch = $db->table('dopigo_eslestir')
            ->where('dopigo_id', $dopigoId)
            ->get()
            ->getRowArray();
        
        // Güncelle
        $success = $db->table('dopigo_eslestir')
            ->where('dopigo_id', $dopigoId)
            ->update([
                'stock_id' => $stockId,
                'stock_code' => $stockCode,
                'stock_title' => $stockTitle,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        
        if($success) {
            // Log kaydı
            $db->table('grup_log')->insert([
                'user_id' => session()->get('user_id'),
                'stock_id' => $stockId,
                'islem_tipi' => 'EŞLEŞME_DEĞİŞİMİ',
                'onceki_veri' => json_encode($oldMatch),
                'sonraki_veri' => json_encode([
                    'stock_id' => $stockId,
                    'stock_code' => $stockCode,
                    'stock_title' => $stockTitle
                ]),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        return $this->response->setJSON(['success' => $success]);
    }


    public function get_available_products() {
        $term = $this->request->getPost('term');
        $db = $this->userDatabase();
        
        $products = $this->modelStock
            ->where('user_id', session()->get('user_id'))
            ->where('grup_id', 0)
            ->where('stock_id NOT IN (SELECT DISTINCT grup_id FROM stock WHERE grup_id != 0)', null, false)
            ->groupStart()
                ->like('stock_code', $term)
                ->orLike('stock_title', $term)
            ->groupEnd()
            ->limit(10)  // Performans için limit
            ->findAll();
        
        return $this->response->setJSON(['products' => $products]);
    }
    
    public function add_to_group() {
        $stock_id = $this->request->getPost('stock_id');
        $grup_id = $this->request->getPost('grup_id');
        
        // Ürünü gruba ekle
        $success = $this->modelStock->update($stock_id, ['grup_id' => $grup_id]);
        
        return $this->response->setJSON(['success' => $success]);
    }

    public function stok_excel()
    {
        $db = $this->userDatabase();
        
        // Önce ana ürünleri al
        $anaUrunler = $db->table('urunler')
            ->where('parent_id IS NULL')
            ->get()
            ->getResultArray();
    
        // Her ana ürün için alt ürünleri al
        $urunHiyerarsi = [];
        foreach($anaUrunler as $anaUrun) {
            $urunHiyerarsi[] = [
                'ana_urun' => $anaUrun,
                'alt_urunler' => $db->table('urunler')
                    ->where('parent_id', $anaUrun['id'])
                    ->get()
                    ->getResultArray()
            ];
        }
    
        $data = [
            'page_title' => "Stokları Excel'e Çıkartın",
            'urunler' => $urunHiyerarsi
        ];
    
        return view('tportal/stoklar/stokexcel', $data);
    }


    function ozel_func_excel_import(){
        $upload_status  = $this->OzeluploadDoc();
        echo '<pre>';
        print_r($upload_status);
        echo '</pre>';
        return;
        if ($upload_status != false) {
            $inputFileName  = 'uploads/'.$upload_status;
            $inputTitleType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
            $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileName);
            $spreadsheet    = $reader->load($inputFileName);
            $sheet          = $spreadsheet->getSheet(0);

            foreach ($sheet->getRowIterator() as $row) 
            {
                $name = $spreadsheet->getActiveSheet()->getCell('A'.$row->getRowIndex());
                echo $name;
            }
        }else{
        }
    }
    
    public function OzeluploadDoc()
    {
       
        try {
            $userDatabaseDetail = [
                'hostname' => session()->get("user_item")["db_host"],
                'username' => session()->get("user_item")["db_username"],
                'password' => session()->get("user_item")["db_password"],
                'database' => session()->get("user_item")["db_name"],
                'DBDriver' => 'MySQLi',
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
        
            // Veritabanı bağlantısı
            $databaseUser = \Config\Database::connect($userDatabaseDetail);
        
            // Upload klasörü kontrolü
            $uploadPath = WRITEPATH . 'uploads/excel/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, TRUE);
            }
        
            $file = $this->request->getFile('excelFile');
            
            // Dosya kontrolü
            if (!$file->isValid()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Lütfen geçerli bir Excel dosyası yükleyin.'
                ]);
            }
    
            $ext = $file->getClientExtension();
            
            // Uzantı kontrolü
            if (!in_array($ext, ['xls', 'xlsx'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Sadece .xls ve .xlsx formatları desteklenir.'
                ]);
            }
    
            // Dosya adı oluşturma
            $filename = date('YmdHis') . '_' . $file->getRandomName();
            
            // Dosyayı yükle
            $file->move($uploadPath, $filename);
        
            // Excel okuyucuyu belirle
            $reader = ($ext == 'xls') ? new \PhpOffice\PhpSpreadsheet\Reader\Xls() : new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            
            // Excel'i oku
            $spreadsheet = $reader->load($uploadPath . $filename);
            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();
            
            // İlk satırı (başlıkları) atla ve verileri hazırla
            $insertData = [];
            $parentIds = [];
            
            // Ana ürünleri önce ekle
            foreach ($data as $index => $row) {
                if ($index === 0) continue; // Başlık satırını atla
                
                if (empty($row[0]) || empty($row[1]) || empty($row[2])) continue; // Boş satırları atla
                
                if ($row[2] === 'Ana Ürün') {
                    $result = $databaseUser->table('urunler')->insert([
                        'parent_id' => null,
                        'stok_kodu' => $row[0],
                        'urun_adi' => $row[1],
                        'durum' => $row[2]
                    ]);
                    
                    if ($result) {
                        // Ana ürünün ID'sini sakla
                        $parentIds[$row[0]] = $databaseUser->insertID();
                    }
                }
            }
            
            // Alt ürünleri ekle
            foreach ($data as $index => $row) {
                if ($index === 0) continue;
                
                if (empty($row[0]) || empty($row[1]) || empty($row[2])) continue;
                
                if ($row[2] === 'Alt Ürün') {
                    // Ana stok kodunu bul (son 6 hane)
                    $mainStockCode = substr($row[0], -6);
                    
                    if (isset($parentIds[$mainStockCode])) {
                        $databaseUser->table('urunler')->insert([
                            'parent_id' => $parentIds[$mainStockCode],
                            'stok_kodu' => $row[0],
                            'urun_adi' => $row[1],
                            'durum' => $row[2]
                        ]);
                    }
                }
            }
            
            // Dosyayı sil
            unlink($uploadPath . $filename);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Excel dosyası başarıyla içe aktarıldı.'
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Hata oluştu: ' . $e->getMessage()
            ]);
        }

    }



    




    public function depo_stoklari_ekle()
    {


        $data = [
            'page_title' => "Stoklarınızı Ekleyin"
        ];
        

        return view('tportal/stoklar/stok/stokekle', $data);
    }

    public function barkod_sorgula()
    {


        $data = [
            'page_title' => "Barkod Sorgulama"
        ];
        

        return view('tportal/stoklar/stok/stoksorgula', $data);
    }

    public function getBarcode()
    {
      // Retrieve the barcode from the POST request
        $barkod = $this->request->getPost('barcode');
        $submittedStockID = $this->request->getPost('stockID');

        // Step 1: Try the first modification function (convert_barcode_number_for_sql_production)
        $sorgu = convert_barcode_number_for_sql_production($barkod); // Attempt to modify to 18 characters

        // Step 2: Check if the barcode exists in the database with the modified barcode
        $StoktanBul = $this->modelStockBarcode->where("barcode_number", $sorgu)->where("stock_barcode_status", "available")->first();

        // If no match found, move to the next function
        if (!$StoktanBul) {
            // Step 3: Try the second modification function (convert_barcode_number_for_sql)
            $sorgu = convert_barcode_number_for_sql($barkod); // Modify again to 18 characters
            
            // Check the database again with this modified barcode
            $StoktanBul = $this->modelStockBarcode->where("barcode_number", $sorgu)->where("stock_barcode_status", "available")->first();
        }

        // If still no match, try the final function
        if (!$StoktanBul) {
            // Step 4: Try the third modification function (convert_barcode_number_for_sql_4)
            $sorgu = convert_barcode_number_for_sql_4($barkod); // Modify to 17 characters
            
            // Check the database one more time
            $StoktanBul = $this->modelStockBarcode->where("barcode_number", $sorgu)->where("stock_barcode_status", "available")->first();
        }

        // Step 5: If still no stock found after all attempts, return an error message
        if (!$StoktanBul) {
            echo json_encode([
                'icon' => 'danger',
                'stock_id' => null,
                'data' => "Okuttuğunuz Barkoda Ait Stok Bulunamadı <br> <b>Okutulan Barkod:  " . $sorgu . "  </b>"
            ]);
            return;
        }
        
        $StokAdiniBul = $this->modelStock->where("stock_id", $StoktanBul["stock_id"])->join('unit', 'unit.unit_id = stock.sale_unit_id')->first();
        
        // Check if the barcode belongs to a different product (different stock_id)
        if ($submittedStockID && $submittedStockID != $StoktanBul["stock_id"]) {
            echo json_encode([
                'icon' => 'info',
                'data' => 'Bu barkod, <b>"' . $StokAdiniBul["stock_title"] . '"</b> ürününe aittir ve şu anda başka bir ürün için barkod taratıyorsunuz.',
                'stock_id' => $StoktanBul["stock_id"]
            ]);
            return;
        }

  
 

$stock_id = $StoktanBul["stock_id"];
$stock_barcode_id = $StoktanBul["stock_barcode_id"];


     $db = $this->userDatabase();

     $stock_item = $this->modelStock->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
         ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
         ->where('stock.user_id', session()->get('user_id'))
         ->where('stock.stock_id', $stock_id)
         ->select('stock.*')
         ->select('buy_unit.unit_title as buy_unit_title, buy_unit.unit_value as buy_unit_value')
         ->select('sale_unit.unit_title as sale_unit_title, sale_unit.unit_value as sale_unit_value')
         ->first();

     

     $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);

     


     # Ürün kodu geçerli mi diye kontrol ediyoruz.
     if (!$stock_item) {
         return view('not-found');
     }

     $query = "
        SELECT sm_outer.*, stock_barcode.*, stock.stock_type, invoice.invoice_id, invoice.sale_type, invoice.is_return, invoice.cari_invoice_title, 
             SUM(stock_barcode.total_amount - stock_barcode.used_amount) AS stock_amount
         FROM stock_movement sm_outer
         JOIN stock_barcode ON sm_outer.stock_barcode_id = stock_barcode.stock_barcode_id
         JOIN stock ON stock.stock_id = stock_barcode.stock_id
         LEFT JOIN cari ON cari.cari_id = sm_outer.supplier_id
         JOIN invoice ON invoice.invoice_id = sm_outer.invoice_id
         WHERE stock_barcode.stock_barcode_id = $stock_barcode_id
         AND sm_outer.deleted_at IS NULL
         AND stock_barcode.deleted_at IS NULL
         GROUP BY sm_outer.transaction_number, sm_outer.buy_unit_price, stock_barcode.total_amount
         ORDER BY sm_outer.transaction_date DESC
     ";
     
     $stock_movement_items = $db->query($query)->getResultArray();
 
    
     
    
 
 
 
     $data = [
 

         'stock_movement_items' => $stock_movement_items,
         'stock_item' => $stock_item,
       
     ];


     $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
     $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();
     $supplier_items = $this->modelCari->where('is_supplier', 1)->where('user_id', session()->get('user_id'))->orderBy('cari_id', 'ASC')->findAll();


    
        // Initialize HTML content to be populated with stock barcode data
        $html_baslik = '<div class="form-inline"><h5>'.$StokAdiniBul["stock_code"].' - '.$StokAdiniBul["stock_title"].'</h5> </div>';
        $html = '
        <div class="form-inline mb-5">
            <h5>' . $stock_item['stock_code'] . ' - ' . $stock_item['stock_title'] . ' </h5>
        </div>
        <table class="datatable-init-hareketler nowrap table" data-export-title="Export">
            <thead>
                <tr style="background-color: #ebeef2;">
                    <th>Tarih</th>
                    <th>İşlem</th>
                    <th>İşlem No</th>
                    <th>Bilgi</th>
                    <th>Depo</th>
                    <th>Miktar</th>
                    <th>Stok</th>
                    <th>...</th>
                </tr>
            </thead>
            <tbody>';
            
        foreach ($stock_movement_items as $item) {
            $transactionDate = date("d/m/Y", strtotime($item['transaction_date']));
            $transactionType = $item['movement_type'] == 'incoming' 
                ? '<span class="tb-status text-success">Giriş</span>'
                : ($item['movement_type'] == 'outgoing' 
                    ? '<span class="tb-status text-danger">Çıkış</span>' 
                    : '<span class="tb-status text-soft">Sevk</span>');
            $transactionInfo = $item['transaction_info'] ?? '-';
            $transactionNumber = $item['transaction_number'] ?? '-';
            $quantity = number_format($item['transaction_quantity'], 2, ',', '.');
          
            
            // Depo bilgisi
            $warehouseInfo = '-';
            if (!empty($item['from_warehouse'])) {
                $warehouse = $warehouse_items[array_search($item['from_warehouse'], array_column($warehouse_items, 'warehouse_id'))]['warehouse_title'];
                $warehouseInfo = $warehouse . ($item['is_return'] == 1 ? '<small> (iade)</small>' : '');
            } elseif (!empty($item['to_warehouse'])) {
                $warehouse = $warehouse_items[array_search($item['to_warehouse'], array_column($warehouse_items, 'warehouse_id'))]['warehouse_title'];
                $warehouseInfo = $warehouse . ($item['is_return'] == 1 ? '<small> (iade)</small>' : '');
            }
        
            $actionButton = '-';
            if ($item['movement_type'] == 'outgoing') {
                if ($item['sale_type'] == 'detailed') {
                    $actionButton = '<a href="' . route_to('tportal.faturalar.detail', $item['invoice_id']) . '" class="btn btn-icon btn-xs btn-dim btn-outline-dark" data-bs-title="Faturayı Görüntüle Detaylı">
                        <em class="icon ni ni-arrow-right"></em>
                    </a>';
                } elseif ($item['sale_type'] == 'quick') {
                    $actionButton = '<a href="' . route_to('tportal.cari.quick_sale_order.detail', $item['invoice_id']) . '" class="btn btn-icon btn-xs btn-dim btn-outline-dark" data-bs-title="Faturayı Görüntüle Hızlı">
                        <em class="icon ni ni-arrow-right"></em>
                    </a>';
                }
            } else {
                $actionButton = '<button type="button" class="btn btn-icon btn-xs btn-dim btn-outline-dark" data-barcode-number="' . $item['barcode_number'] . '" data-bs-title="Barkod Yazdır">
                    <em class="icon ni ni-printer-fill"></em>
                </button>';
             
            }
        
            // Tablo satırını oluştur
            $html .= '
            <tr>
                <td data-order="' . $item['transaction_date'] . $item['stock_movement_id'] . '" title="' . $item['transaction_date'] . '">' . $transactionDate . '</td>
                <td>' . $transactionType . '</td>
                <td>' . $transactionNumber . '</td>
                <td>' . $transactionInfo . '</td>
                <td>' . $warehouseInfo . '</td>
                <td class="text-right">' . $quantity . '</td>
               
                <td>' . $actionButton . '</td>
            </tr>';
        }
        
        $html .= '
            </tbody>
        </table>';
    
        // Return success response
        echo json_encode([
            'icon' => 'success',
            'toplam_genel_stok' => $StokAdiniBul["stock_total_quantity"],
            'html_baslik' => '',
            'html' => $html,
            'tipi' => $StokAdiniBul["unit_title"],
            'stock_id' => $StoktanBul["stock_id"],
            'total_amount' => $StoktanBul["total_amount"], // Include total amount
            'used_amount' => $StoktanBul["used_amount"],   // Include used amount
            'stock_barcode_id' => $StoktanBul["stock_barcode_id"],   // Include used amount
            'data' => 'Bu barkod, <b> "' . $StokAdiniBul["stock_title"] . '"</b> ürününe aittir detayları getirildi.',
        ]);
    }


    public function getBarcodeSorgulaSatis()
    {
      // Retrieve the barcode from the POST request
        $barkod = $this->request->getPost('barcode');
        $submittedStockID = $this->request->getPost('stockID');

        // Step 1: Try the first modification function (convert_barcode_number_for_sql_production)
        $sorgu = convert_barcode_number_for_sql_production($barkod); // Attempt to modify to 18 characters

        // Step 2: Check if the barcode exists in the database with the modified barcode
        $StoktanBul = $this->modelStockBarcode->where("barcode_number", $sorgu)->where("stock_barcode_status", "available")->first();

        // If no match found, move to the next function
        if (!$StoktanBul) {
            // Step 3: Try the second modification function (convert_barcode_number_for_sql)
            $sorgu = convert_barcode_number_for_sql($barkod); // Modify again to 18 characters
            
            // Check the database again with this modified barcode
            $StoktanBul = $this->modelStockBarcode->where("barcode_number", $sorgu)->where("stock_barcode_status", "available")->first();
        }

        // If still no match, try the final function
        if (!$StoktanBul) {
            // Step 4: Try the third modification function (convert_barcode_number_for_sql_4)
            $sorgu = convert_barcode_number_for_sql_4($barkod); // Modify to 17 characters
            
            // Check the database one more time
            $StoktanBul = $this->modelStockBarcode->where("barcode_number", $sorgu)->where("stock_barcode_status", "available")->first();
        }

        // Step 5: If still no stock found after all attempts, return an error message
        if (!$StoktanBul) {
            echo json_encode([
                'icon' => 'danger',
                'stock_id' => null,
                'data' => "Okuttuğunuz Barkoda Ait Stok Bulunamadı <br> <b>Okutulan Barkod:  " . $sorgu . "  </b>"
            ]);
            return;
        }
        
        $StokAdiniBul = $this->modelStock->where("stock_id", $StoktanBul["stock_id"])->join('unit', 'unit.unit_id = stock.sale_unit_id')->first();
        
        // Check if the barcode belongs to a different product (different stock_id)
        if ($submittedStockID && $submittedStockID != $StoktanBul["stock_id"]) {
            echo json_encode([
                'icon' => 'info',
                'data' => 'Bu barkod, <b>"' . $StokAdiniBul["stock_title"] . '"</b> ürününe aittir ve şu anda başka bir ürün için barkod taratıyorsunuz.',
                'stock_id' => $StoktanBul["stock_id"]
            ]);
            return;
        }

  
 

$stock_id = $StoktanBul["stock_id"];
$stock_barcode_id = $StoktanBul["stock_barcode_id"];


     $db = $this->userDatabase();

     $stock_item = $this->modelStock->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
         ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
         ->where('stock.user_id', session()->get('user_id'))
         ->where('stock.stock_id', $stock_id)
         ->select('stock.*')
         ->select('buy_unit.unit_title as buy_unit_title, buy_unit.unit_value as buy_unit_value')
         ->select('sale_unit.unit_title as sale_unit_title, sale_unit.unit_value as sale_unit_value')
         ->first();

     

     $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);

     


     # Ürün kodu geçerli mi diye kontrol ediyoruz.
     if (!$stock_item) {
         return view('not-found');
     }

     $query = "
        SELECT sm_outer.*, stock_barcode.*, stock.stock_type, invoice.invoice_id, invoice.sale_type, invoice.is_return, invoice.cari_invoice_title, 
             SUM(stock_barcode.total_amount - stock_barcode.used_amount) AS stock_amount
         FROM stock_movement sm_outer
         JOIN stock_barcode ON sm_outer.stock_barcode_id = stock_barcode.stock_barcode_id
         JOIN stock ON stock.stock_id = stock_barcode.stock_id
         LEFT JOIN cari ON cari.cari_id = sm_outer.supplier_id
         JOIN invoice ON invoice.invoice_id = sm_outer.invoice_id
         WHERE stock_barcode.stock_barcode_id = $stock_barcode_id
         AND sm_outer.deleted_at IS NULL
         AND stock_barcode.deleted_at IS NULL
         GROUP BY sm_outer.transaction_number, sm_outer.buy_unit_price, stock_barcode.total_amount
         ORDER BY sm_outer.transaction_date DESC
     ";
     
     $stock_movement_items = $db->query($query)->getResultArray();
 
    
     
    
 
 
 
     $data = [
 

         'stock_movement_items' => $stock_movement_items,
         'stock_item' => $stock_item,
       
     ];


     $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
     $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();
     $supplier_items = $this->modelCari->where('is_supplier', 1)->where('user_id', session()->get('user_id'))->orderBy('cari_id', 'ASC')->findAll();


    
        // Initialize HTML content to be populated with stock barcode data
        $html_baslik = '<div class="form-inline"><h5>'.$StokAdiniBul["stock_code"].' - '.$StokAdiniBul["stock_title"].'</h5> </div>';
        $html = '
           <div class="col-lg-3">
    <div class="custom-control custom-control-sm custom-checkbox custom-control-pro checked">
        <input type="checkbox" class="custom-control-input" checked id="user-selection-s'.$StoktanBul["stock_barcode_id"].'" name="user-selection">
        <label class="custom-control-label" for="user-selection-s'.$StoktanBul["stock_barcode_id"].'">
            <span class="user-card">
                <span class="user-avatar sq">
                    <img src="https://images.vexels.com/media/users/3/157862/isolated/lists/5fc76d9e8d748db3089a489cdd492d4b-barcode-scanning-icon.png" alt="">
                </span>
                <span class="user-info">
                    <span class="lead-text"><b>' . remove_end_of_barcode($StoktanBul["barcode_number"]) . '</b> </span>
                    <span class="sub-text"><b><span>Barkod</span> <b>'.number_format($StoktanBul['total_amount'], 2, ',', '').'</b> '.$StokAdiniBul["unit_title"].' <br> <span>Eklenecek</span>  <b>'.number_format(($StoktanBul['used_amount'] ), 2, ',', '').'</b> '.$StokAdiniBul["unit_title"].'</b></span>
                </span>
            </span>
        </label>
    </div>
    </div>';
    
        // Return success response
        echo json_encode([
            'icon' => 'success',
            'toplam_genel_stok' => $StokAdiniBul["stock_total_quantity"],
            'html_baslik' => '',
            'html' => $html,
            'tipi' => $StokAdiniBul["unit_title"],
            'stock_id' => $StoktanBul["stock_id"],
            'total_amount' => $StoktanBul["total_amount"], // Include total amount
            'used_amount' => $StoktanBul["used_amount"],   // Include used amount
            'stock_barcode_id' => $StoktanBul["stock_barcode_id"],   // Include used amount
            'data' => 'Bu barkod, <b> "' . $StokAdiniBul["stock_title"] . '"</b> ürününe aittir detayları getirildi.',
        ]);
    }


    public function getBarcodeEkle()
    {
      // Retrieve the barcode from the POST request
        $barkod = $this->request->getPost('barcode');
        $submittedStockID = $this->request->getPost('stockID');

        // Step 1: Try the first modification function (convert_barcode_number_for_sql_production)
        $sorgu = convert_barcode_number_for_sql_production($barkod); // Attempt to modify to 18 characters

        // Step 2: Check if the barcode exists in the database with the modified barcode
        $StoktanBul = $this->modelStockBarcode->where("barcode_number", $sorgu)->where("stock_barcode_status", "out_of_stock")->first();

        // If no match found, move to the next function
        if (!$StoktanBul) {
            // Step 3: Try the second modification function (convert_barcode_number_for_sql)
            $sorgu = convert_barcode_number_for_sql($barkod); // Modify again to 18 characters
            
            // Check the database again with this modified barcode
            $StoktanBul = $this->modelStockBarcode->where("barcode_number", $sorgu)->where("stock_barcode_status", "out_of_stock")->first();
        }

        // If still no match, try the final function
        if (!$StoktanBul) {
            // Step 4: Try the third modification function (convert_barcode_number_for_sql_4)
            $sorgu = convert_barcode_number_for_sql_4($barkod); // Modify to 17 characters
            
            // Check the database one more time
            $StoktanBul = $this->modelStockBarcode->where("barcode_number", $sorgu)->where("stock_barcode_status", "out_of_stock")->first();
        }

        // Step 5: If still no stock found after all attempts, return an error message
        if (!$StoktanBul) {
            echo json_encode([
                'icon' => 'danger',
                'stock_id' => null,
                'data' => "Okuttuğunuz Barkoda Ait Stok Bulunamadı <br> <b>Okutulan Barkod:  " . $sorgu . "  </b>"
            ]);
            return;
        }
        
        $StokAdiniBul = $this->modelStock->where("stock_id", $StoktanBul["stock_id"])->join('unit', 'unit.unit_id = stock.sale_unit_id')->first();
        
        // Check if the barcode belongs to a different product (different stock_id)
        if ($submittedStockID && $submittedStockID != $StoktanBul["stock_id"]) {
            echo json_encode([
                'icon' => 'info',
                'data' => 'Bu barkod, <b>"' . $StokAdiniBul["stock_title"] . '"</b> ürününe aittir ve şu anda başka bir ürün için barkod taratıyorsunuz.',
                'stock_id' => $StoktanBul["stock_id"]
            ]);
            return;
        }
    
        // Initialize HTML content to be populated with stock barcode data
        $html_baslik = '<div class="form-inline"><h5>'.$StokAdiniBul["stock_code"].' - '.$StokAdiniBul["stock_title"].'</h5> </div>';
        $html = '
           <div class="col-lg-3">
    <div class="custom-control custom-control-sm custom-checkbox custom-control-pro checked">
        <input type="checkbox" class="custom-control-input" checked id="user-selection-s'.$StoktanBul["stock_barcode_id"].'" name="user-selection">
        <label class="custom-control-label" for="user-selection-s'.$StoktanBul["stock_barcode_id"].'">
            <span class="user-card">
                <span class="user-avatar sq">
                    <img src="https://images.vexels.com/media/users/3/157862/isolated/lists/5fc76d9e8d748db3089a489cdd492d4b-barcode-scanning-icon.png" alt="">
                </span>
                <span class="user-info">
                    <span class="lead-text"><b>' . remove_end_of_barcode($StoktanBul["barcode_number"]) . '</b> </span>
                    <span class="sub-text"><b><span>Barkod</span> <b>'.number_format($StoktanBul['total_amount'], 2, ',', '').'</b> '.$StokAdiniBul["unit_title"].' <br> <span>Eklenecek</span>  <b>'.number_format(($StoktanBul['used_amount'] ), 2, ',', '').'</b> '.$StokAdiniBul["unit_title"].'</b></span>
                </span>
            </span>
        </label>
    </div>
    </div>';
    
        // Return success response
        echo json_encode([
            'icon' => 'success',
            'toplam_genel_stok' => $StokAdiniBul["stock_total_quantity"],
            'html_baslik' => $html_baslik,
            'html' => $html,
            'tipi' => $StokAdiniBul["unit_title"],
            'stock_id' => $StoktanBul["stock_id"],
            'total_amount' => $StoktanBul["total_amount"], // Include total amount
            'used_amount' => $StoktanBul["used_amount"],   // Include used amount
            'stock_barcode_id' => $StoktanBul["stock_barcode_id"],   // Include used amount
            'data' => 'Bu barkod, <b> "' . $StokAdiniBul["stock_title"] . '"</b> ürününe aittir listeye eklendi.',
        ]);
    }

    ## Barkod İşlemleri BİTİŞ

    public function listLoad($stock_type = 'all')
    {

        if ($stock_type == 'all') {
            $stock_items = $this->modelStock->join('category', 'category.category_id = stock.category_id')
                ->join('type', 'type.type_id = stock.type_id','left')
                ->select('category.category_title, type.type_title, stock.*')
                ->where('stock.user_id', session()->get('user_id'))
                ->findAll();
        } elseif ($stock_type == 'services') {
            $stock_items = $this->modelStock->join('category', 'category.category_id = stock.category_id')
                ->join('type', 'type.type_id = stock.type_id','left')
                ->select('category.category_title, type.type_title, stock.*')
                ->where('stock.user_id', session()->get('user_id'))
                ->where('stock.stock_type', 'service')
                ->findAll();
        } elseif ($stock_type == 'products') {
            $stock_items = $this->modelStock->join('category', 'category.category_id = stock.category_id')
                ->join('type', 'type.type_id = stock.type_id','left')
                ->select('category.category_title, type.type_title, stock.*')
                ->where('stock.user_id', session()->get('user_id'))
                ->where('stock.stock_type', 'product')
                ->findAll();
        } else {
            echo json_encode(['stock_items' => '']);
            return;
        }

        echo json_encode(['stock_items' => $stock_items]);
        return;
    }
    
    public function listLoadByType()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $type_id = $this->request->getPost('type_id');
                $stock_items = $this->modelStock->join('category', 'category.category_id = stock.category_id')
                    ->join('unit', 'unit.unit_id = stock.unit_id')
                    ->join('type', 'type.type_id = stock.type_id','left')
                    ->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
                    ->join('money_unit as sale_money_unit', 'sale_money_unit.money_unit_id = stock.buy_money_unit_id')
                    ->where('stock.user_id', session()->get('user_id'))
                    ->where('stock.type_id', $type_id)
                    ->select('*')
                    ->select('buy_money_unit.money_title as buy_money_title, buy_money_unit.money_code as buy_money_code, buy_money_unit.money_icon as buy_money_icon, buy_money_unit.money_value as buy_money_value')
                    ->select('sale_money_unit.money_title as sale_money_title, sale_money_unit.money_code as sale_money_code, sale_money_unit.money_icon as sale_money_icon, sale_money_unit.money_value as sale_money_value')
                    ->orderBy('category.category_title', 'ASC')
                    ->orderBy('stock.stock_code', 'ASC')
                    ->findAll();

                if (!$stock_items) {
                    echo json_encode(['icon' => 'error', 'message' => 'Girilen tipe ait stok bulunamadı.']);
                    return;
                } else {
                    echo json_encode(['icon' => 'success', 'stock_items' => $stock_items]);
                    return;
                }
            } catch (\Exception $e) {
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        }
    }

    public function detailedSearch()
    {
        if ($this->request->getMethod('true') == 'POST') {
            $pager = \Config\Services::pager();

            $stock_type = $this->request->getPost('stock_type') ?? 'all';
            $search = $this->request->getPost('search');
            $pageSize = $this->request->getPost('pageSize') ?? 15;
            $categoryId = $this->request->getPost('categoryId') ?? null;
            $typeId = $this->request->getPost('typeId') ?? null;
            $page = 1;
            $fromWhere = $this->request->getPost('fromWhere') ?? 'product';

            $stock_items = $this->modelStock->join('category', 'category.category_id = stock.category_id')
                ->join('money_unit', 'money_unit.money_unit_id = stock.sale_money_unit_id')
                ->join('type', 'type.type_id = stock.type_id','left')
                ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
                ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
                ->join('stock_warehouse_quantity', 'stock_warehouse_quantity.stock_id = stock.stock_id', 'LEFT')
                ->join('warehouse', 'warehouse.warehouse_id = stock_warehouse_quantity.warehouse_id', 'LEFT')
                ->select('category.category_title, type.type_title, buy_unit.unit_title as buy_unit_title, sale_unit.unit_title as sale_unit_title, stock.*, money_unit.money_icon as sale_money_icon, warehouse.*')
                ->where('stock.user_id', session()->get('user_id'))
                ->where('stock.deleted_at IS NULL', null, false);
            // ->where('parent_id', 0);

            if ($fromWhere == 'createInvoice') {
                $stock_items = $this->modelStock->where('stock.parent_id !=', 0);
            } elseif ($fromWhere == 'product') {
                $stock_items = $this->modelStock->where('stock.parent_id', 0);
            } else {
                echo json_encode(['icon' => 'error', 'message' => 'fromWhere bulunamadı.']);
                return;
            }

            if ($stock_type == 'all') {
                $stock_items = $stock_items;
            } elseif ($stock_type == 'services') {
                $stock_items = $this->modelStock->where('stock.stock_type', 'service');
            } elseif ($stock_type == 'products') {
                $stock_items = $this->modelStock->where('stock.stock_type', 'product');
            } else {
                echo json_encode(['icon' => 'error', 'message' => 'Stok tipi bulunamadı.']);
                return;
            }

            $filters = '&pageSize=' . $pageSize;
            if ($search && strlen($search) > 3) {
                $stock_items = $this->modelStock->like('stock.stock_title', str_replace("#", "", $search))->orLike('stock.stock_code', str_replace("#", "", $search));
                $filters .= '&search=' . $search;
            } else {
                if ($fromWhere == 'createInvoice') {
                    $stock_items = $this->modelStock->like('stock.stock_title', str_replace("#", "", 'q'))->orLike('stock.stock_code', str_replace("#", "", 'q'));
                    $filters .= '&search=' . 'q';
                } else {
                    $stock_items = $this->modelStock->like('stock.stock_title', str_replace("#", "", $search))->orLike('stock.stock_code', str_replace("#", "", $search));
                    $filters .= '&search=' . $search;
                    // echo "else'in else'i çalıştı";
                }
            }
            if ($categoryId) {
                $stock_items = $this->modelStock->where('category.user_id', session()->get('user_id'))->where('stock.category_id', str_replace("#", "", $categoryId));
                $filters .= '&categoryId=' . $categoryId;
            }
            if ($typeId) {
                $stock_items = $this->modelStock->where('type.user_id', session()->get('user_id'))->where('stock.type_id', str_replace("#", "", $typeId));
                $filters .= '&typeId=' . $typeId;
            }

            $stock_items = $this->modelStock->paginate($pageSize, 'default', $page);
            session()->setFlashdata('pagination_filters', $filters);
            $pager->setPath('tportal/stock/list/' . $stock_type);
            $data = [
                'stock_items' => $stock_items,
                'pager' => $pager->links()
            ];


            echo json_encode(['icon' => 'success', 'message' => 'Arama sonuçları başarıyla getirildi.', 'data' => $data]);
            return;
        } else {
            return redirect()->back();
        }
    }

    //stoklar listesi için ana ürünleri getirir
    public function detailedSearchforStock()
    {
        if ($this->request->getMethod('true') == 'POST') {
            $pager = \Config\Services::pager();

            $stock_type = $this->request->getPost('stock_type') ?? 'all';
            $search = $this->request->getPost('search');
            $pageSize = $this->request->getPost('pageSize') ?? 15;
            $categoryId = $this->request->getPost('categoryId') ?? null;
            $typeId = $this->request->getPost('typeId') ?? null;
            $page = 1;

            $stock_items = $this->modelStock->join('category', 'category.category_id = stock.category_id')
                ->join('type', 'type.type_id = stock.type_id','left')
                ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
                ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
                ->join('money_unit as sale_money_unit', 'sale_money_unit.money_unit_id = stock.sale_money_unit_id')
                ->select('category.category_title, type.type_title, buy_unit.unit_title as buy_unit_title, sale_unit.unit_title as sale_unit_title, stock.*, sale_money_unit.money_icon as sale_money_icon')
                // ->where('stock.deletet_at IS NULL')
                ->where('stock.user_id', session()->get('user_id'))
                ->where('parent_id', 0);
            if ($stock_type == 'all') {
                $stock_items = $stock_items;
            } elseif ($stock_type == 'services') {
                $stock_items = $this->modelStock->where('stock.stock_type', 'service');
            } elseif ($stock_type == 'products') {
                $stock_items = $this->modelStock->where('stock.stock_type', 'product');
            } else {
                echo json_encode(['icon' => 'error', 'message' => 'Stok tipi bulunamadı.']);
                return;
            }

            $filters = '&pageSize=' . $pageSize;
            if ($search && strlen($search) > 3) {
                $stock_items = $this->modelStock->like('stock.stock_title', str_replace("#", "", $search));
                $filters .= '&search=' . $search;
            }
            if ($categoryId) {
                $stock_items = $this->modelStock->where('category.user_id', session()->get('user_id'))->where('stock.category_id', str_replace("#", "", $categoryId));
                $filters .= '&categoryId=' . $categoryId;
            }
            if ($typeId) {
                $stock_items = $this->modelStock->where('type.user_id', session()->get('user_id'))->where('stock.type_id', str_replace("#", "", $typeId));
                $filters .= '&typeId=' . $typeId;
            }

            $stock_items = $this->modelStock->paginate($pageSize, 'default', $page);
            session()->setFlashdata('pagination_filters', $filters);
            $pager->setPath('tportal/stock/list/' . $stock_type);
            $data = [
                'stock_items' => $stock_items,
                'pager' => $pager->links()
            ];
            echo json_encode(['icon' => 'success', 'message' => 'Arama sonuçları başarıyla getirildi.', 'data' => $data]);
            return;
        } else {
            return redirect()->back();
        }
    }

    public function loadSingleItem($stock_code = null)
    {
        $stock_item = $this->modelStock->join('category', 'category.category_id = stock.category_id')
            ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->join('type', 'type.type_id = stock.type_id','left')
            ->select('category.category_title, buy_unit.unit_title as buy_unit_title, sale_unit.unit_title as sale_unit_title, type.type_title, stock.*')
            ->where('user_id', session()->get('user_id'))
            ->where('stock_code', $stock_code)
            ->first();

        if (!$stock_item) {
            echo json_encode(['stock_item' => '']);
            return;
        } else {
            echo json_encode(['stock_item' => $stock_item]);
            return;
        }
    }

    public function create()
    {
        $cariler = $this->modelCari->where('is_supplier', '1')->where('user_id', session()->get('user_id'))->findAll();

        $insert_data = [];
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $stock_type = $this->request->getPost('stock_type');
                $has_variant = $this->request->getPost('has_variant');
                $paketli_id = $this->request->getPost('paket');
                if($paketli_id == "on"){
                    $paketli_id = 1;
                }else{
                    $paketli_id = 0;
                }
                $type_id = $stock_type == 'service' ? null : $this->request->getPost('type_id');
                $category_id = $this->request->getPost('category_id');
                $stock_barcode = $this->request->getPost('stock_barcode');
                $stock_code = $this->request->getPost('stock_code');
                $stock_title = $this->request->getPost('stock_title');

                $supplier_stock_code = $this->request->getPost('supplier_stock_code');
                $buy_unit_id = $this->request->getPost('buy_unit_id');
                $buy_unit_price = $this->request->getPost('buy_unit_price');
                $buy_unit_price_with_tax = $this->request->getPost('buy_unit_price_with_tax');
                $buy_money_unit_id = $this->request->getPost('buy_money_unit_id');
                $buy_tax_rate = $this->request->getPost('buy_tax_rate');

                $sale_unit_id = $this->request->getPost('sale_unit_id');
                $sale_unit_price = $this->request->getPost('sale_unit_price');
                $sale_unit_price_with_tax = $this->request->getPost('sale_unit_price_with_tax');
                $sale_money_unit_id = $this->request->getPost('sale_money_unit_id');
                $sale_tax_rate = $this->request->getPost('sale_tax_rate');
                $alt_category_id = $this->request->getPost('alt_category_id');

                $cari_id = $this->request->getPost('cari_id');
                $status = $this->request->getPost('status');

                $stock_tracking = $this->request->getPost('stock_tracking');
                if ($stock_tracking == '1') {
                    # Eğer stok takibi yapılsın işaretlenmişse ilk stok hareketi burada tanımlanacak
                    $starting_stock = $this->request->getPost('starting_stock');
                    $starting_stock_date = $this->request->getPost('starting_stock_date');

                    # Eğer kritik stok boş gelirse veritabanında 0 default olarak belirlendi.
                    # İşlem yaparken kritik stok 0 olanlar dikkate alınmayacak.
                    $insert_data['critical_stock'] = $this->request->getPost('critical_stock');
                }

                # Convert form data to sql data
                $buy_unit_price = convert_number_for_sql($buy_unit_price);
                $buy_unit_price_with_tax = convert_number_for_sql($buy_unit_price_with_tax);
                $sale_unit_price = convert_number_for_sql($sale_unit_price);
                $sale_unit_price_with_tax = convert_number_for_sql($sale_unit_price_with_tax);


                # Convert stock_barcode to unique
                $barcode_number = generate_barcode_number($stock_barcode);

                # Convert has_variant
                $has_variant = $has_variant ? 1 : 0;

                # Create unique stock_code
                $temp_stock_code = $this->getStockCode($category_id, $stock_code);
                if ($temp_stock_code['icon'] == 'success') {
                    $stock_code = $temp_stock_code['value'];
                } else {
                    echo json_encode($temp_stock_code);
                    return;
                }

                $insert_data = [
                    'parent_id' => 0,
                    'paket'    => $paketli_id,
                    'cari_id' => $cari_id,
                    'user_id' => session()->get('user_id'),
                    'type_id' => $type_id,
                    'category_id' => $category_id,
                    'altcategory_id' => $alt_category_id ?? 0,
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
                    'has_variant' => $has_variant,
                    'stock_tracking' => $stock_tracking,
                ];

                # Custom Fields
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

                // print_r($insert_data);
                // print_r($new_stock_id);

                if ($temp_stock_code['category_counter']) {
                    $update_category_data = [
                        'category_counter' => $temp_stock_code['category_counter']
                    ];
                    $this->modelCategory->update($category_id, $update_category_data);
                }

                $insert_recipe_data = [
                    'stock_id' => $this->modelStock->getInsertID(),
                    'recipe_title' => $stock_title . '_recipe',
                ];
                $this->modelStockRecipe->insert($insert_recipe_data);

                if ($stock_type == 'service') {
                    $warehouse_item = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('default','true')->first();

                    //stock_barcode eklendi
                    $barcode_number = generate_barcode_number();
                    $insert_barcode_data = [
                        'stock_id' => $this->modelStock->getInsertID(),
                        'warehouse_id' => $warehouse_item['warehouse_id'] ?? 0,
                        'warehouse_address' => $warehouse_item['warehouse_title'] ?? '',
                        'barcode_number' => $barcode_number,
                        'total_amount' => 0,
                        'used_amount' => 0
                    ];
                    $this->modelStockBarcode->insert($insert_barcode_data);
                    $new_insert_stock_barcode_id = $this->modelStockBarcode->getInsertID();
                    // print_r($new_insert_stock_barcode_id);
                }

                // print_r($new_stock_id);



                echo json_encode(['icon' => 'success', 'message' => 'Stok başarıyla oluşturuldu.', 'new_stock_id' => $this->modelStock->getInsertID(), 'new_stock_code' => $stock_code]);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock',
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

            $type_items = $this->modelType->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();
            $unit_items = $this->modelUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();
            $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
            $category_items = $this->modelCategory->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();

            $data = [
                'cariler' => $cariler,
                'type_items' => $type_items,
                'unit_items' => $unit_items,
                'category_items' => $category_items,
                'money_unit_items' => $money_unit_items
            ];

            return view('tportal/stoklar/yeni', $data);
        }
    }

    public function detail($stock_id = null)
    {

        $stock_item = $this->modelStock->join('category', 'category.category_id = stock.category_id')
            ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->join('type', 'type.type_id = stock.type_id','left')
            ->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
            ->join('money_unit as sale_money_unit', 'sale_money_unit.money_unit_id = stock.sale_money_unit_id')
          
            ->select('category.category_title, type.type_title, stock.*')
            ->select('buy_unit.unit_title as buy_unit_title, sale_unit.unit_title as sale_unit_title')
            ->select('buy_money_unit.money_code as buy_money_code, buy_money_unit.money_title as buy_money_title, buy_money_unit.money_icon as buy_money_icon, buy_money_unit.money_value as buy_money_value')
            ->select('sale_money_unit.money_code as sale_money_code, sale_money_unit.money_title as sale_money_title, sale_money_unit.money_icon as sale_money_icon, sale_money_unit.money_value as sale_money_value')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.stock_id', $stock_id)
            ->first();

        if ($stock_item['parent_id'] != 0)
            $parentStockId = $stock_item['parent_id'];
        else
            $parentStockId = 0;

       

  

        // $stock_item['stock_total_amount'] = $this->sonStokBilgisi($stock_item['stock_id']);
        $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);

        if (!$stock_item) {
            return view('not-found');
        }       
            
        $stock_operation = $this->modelStockOperation
        ->join('operation', 'operation.operation_id = stock_operation.operation_id')
        ->where("stock_operation.stock_id", $stock_id)
        ->findAll();
    
    $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
    
    // Tüm operasyon türleri için döngü oluştur
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
            }elseif ($status == "Durdu") {
                $operation_amounts[$operation_id]['islemde'] += $stock_amount;
            }
            elseif ($status == "Devam") {
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



    $data = [

            'operation_amounts' => $operation_amounts,
            'stock_operation' => $stock_operation,
            'stock_item' => $stock_item,
            'parentStockId' => $parentStockId,
        ];

     /* 
        echo '<pre>';
        print_r($stock_item);
         echo '</pre>';

         exit;*/

        // print_r($stock_item);
        // return;

        return view('tportal/stoklar/detay/detay', $data);
    }

    public function edit($stock_id = null)
    {
        $stock_item = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock_id', $stock_id)->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')->first();
        $cariler = $this->modelCari->where('is_supplier', '1')->where('user_id', session()->get('user_id'))->findAll();

 
        if (!$stock_item) {
            return view('not-found');
        }

        if ($stock_item['parent_id'] != 0)
            $parentStockId = $stock_item['parent_id'];
        else
            $parentStockId = 0;

        if ($this->request->getMethod('true') == 'POST') {
            try {
                $stock_title = $this->request->getPost('stock_title');

                $supplier_stock_code = $this->request->getPost('supplier_stock_code');
                $buy_unit_id = $this->request->getPost('buy_unit_id');
                $buy_unit_price = $this->request->getPost('buy_unit_price');
                $buy_unit_price_with_tax = $this->request->getPost('buy_unit_price_with_tax');
                $buy_money_unit_id = $this->request->getPost('buy_money_unit_id');
                $buy_tax_rate = $this->request->getPost('buy_tax_rate');
                $type_id = $this->request->getPost('type_id');
                $paket_id = $this->request->getPost('paket');
                $alt_category_id = $this->request->getPost('alt_category_id');
                $stock_barcode = $this->request->getPost('stock_barcode');
                $cari_id = $this->request->getPost('cari_id');

             

                
                    $barcode_number = generate_barcode_number($stock_barcode);
             
             

                if($paket_id == "on"){
                    $paket_id = 1;
                }else{
                    $paket_id = 0;
                }
                $category_id = $this->request->getPost('category_id');

                $sale_unit_id = $this->request->getPost('sale_unit_id');
                $sale_unit_price = $this->request->getPost('sale_unit_price');
                $sale_unit_price_with_tax = $this->request->getPost('sale_unit_price_with_tax');
                $sale_money_unit_id = $this->request->getPost('sale_money_unit_id');
                $sale_tax_rate = $this->request->getPost('sale_tax_rate');

                $status = $this->request->getPost('status');

                $stock_tracking = $this->request->getPost('stock_tracking');
                if ($stock_tracking == '1') {
                    # Eğer kritik stok boş gelirse veritabanında 0 default olarak belirlendi.
                    # İşlem yaparken kritik stok 0 olanlar dikkate alınmayacak.
                    $update_data['critical_stock'] = $this->request->getPost('critical_stock');
                }

                # Convert form data to sql data
                $buy_unit_price = convert_number_for_sql($buy_unit_price);
                $buy_unit_price_with_tax = convert_number_for_sql($buy_unit_price_with_tax);
                $sale_unit_price = convert_number_for_sql($sale_unit_price);
                $sale_unit_price_with_tax = convert_number_for_sql($sale_unit_price_with_tax);

                $update_data = [
                    'user_id' => session()->get('user_id'),
                    'type_id' => $type_id,
                    'paket'   => $paket_id,
                    'cari_id' => $cari_id,
                    'category_id' => $category_id,
                    'altcategory_id' => $alt_category_id ?? 0,
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
                    'stock_title' => $stock_title,
                    'supplier_stock_code' => $supplier_stock_code,
                    'status' => $status,
                    'stock_tracking' => $stock_tracking,
                    'stock_barcode' => $barcode_number,
                ];

             

                # Custom Fields
                $warehouse_address = $this->request->getPost('warehouse_address');
                $pattern_code = $this->request->getPost('pattern_code');
                $en = $this->request->getPost('en');
                $boy = $this->request->getPost('boy');
                $kalinlik = $this->request->getPost('kalinlik');
                $ozkutle = $this->request->getPost('ozkutle');
                if ($warehouse_address) {
                    $update_data['warehouse_address'] = $warehouse_address;
                }
                if ($pattern_code) {
                    $update_data['pattern_code'] = $pattern_code;
                }
                if ($en) {
                    $update_data['en'] = convert_number_for_sql($en);
                }
                if ($boy) {
                    $update_data['boy'] = convert_number_for_sql($boy);
                }
                if ($kalinlik) {
                    $update_data['kalinlik'] = convert_number_for_sql($kalinlik);
                }
                if ($ozkutle) {
                    $update_data['ozkutle'] = convert_number_for_sql($ozkutle);
                }

                $this->modelStock->update($stock_item['stock_id'], $update_data);

                # TODO: Aşağıdaki fonksiyon ana ürün değiştiğinde bu ürünün bulunduğu
                #       tüm reçete elemanlarını gezerek fiyatını güncelliyor.
                #       Aktif edilmeli mi diye sor.
                #
                if ($buy_unit_price != $stock_item['buy_unit_price']) {
                    $this->checkAllStockContents($stock_item, $buy_unit_price);
                }

                echo json_encode(['icon' => 'success', 'message' => 'Stok başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock',
                    $stock_id,
                    null,
                    'edit',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {

            $type_items = $this->modelType->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();
            $unit_items = $this->modelUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();
            $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
            $category_items = $this->modelCategory->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();
            $stock_total_amount = $this->modelStockMovement->select([
                'sm_outer.*',
                'stock_barcode.*',
                '(SELECT SUM(stock_barcode.total_amount)
                  FROM stock_movement sm_inner
                  JOIN stock_barcode ON sm_inner.stock_barcode_id = stock_barcode.stock_barcode_id
                  WHERE sm_inner.transaction_date <= sm_outer.transaction_date
                    AND stock_barcode.stock_id = ' . $stock_item['stock_id'] . '
                    AND stock_barcode.deleted_at is null
                  ORDER BY sm_inner.transaction_date DESC
                ) AS stock_amount'
            ])
                ->from('stock_movement sm_outer')
                ->join('stock_barcode', 'sm_outer.stock_barcode_id = stock_barcode.stock_barcode_id')
                ->where('stock_barcode.stock_id', $stock_item['stock_id'])
                ->groupBy([
                    'sm_outer.transaction_number',
                    'sm_outer.buy_unit_price',
                    'stock_barcode.total_amount'
                ])
                ->orderBy('sm_outer.transaction_date', 'DESC')
                ->first();

            $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);
        
            $stock_operation = $this->modelStockOperation
        ->join('operation', 'operation.operation_id = stock_operation.operation_id')
        ->where("stock_operation.stock_id", $stock_id)
        ->findAll();
    
    $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
    
    // Tüm operasyon türleri için döngü oluştur
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
            }elseif ($status == "Durdu") {
                $operation_amounts[$operation_id]['islemde'] += $stock_amount;
            }
            elseif ($status == "Devam") {
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



    $data = [
            'cariler' => $cariler,
            'operation_amounts' => $operation_amounts,
            'stock_operation' => $stock_operation,
                'stock_item' => $stock_item,
                'type_items' => $type_items,
                'unit_items' => $unit_items,
                'money_unit_items' => $money_unit_items,
                'category_items' => $category_items,
                'stock_total_amount' => $stock_total_amount,
                'parentStockId' => $parentStockId,
            ];

            return view('tportal/stoklar/detay/duzenle', $data);
        }
    }

    private function checkAllStockContents($stock_item, $newUnitPrice)
    {
        $recipe_items = $this->modelRecipeItem->where('stock_id', $stock_item['stock_id'])->findAll();

        foreach ($recipe_items as $recipe_item) {

            try {
                $total_cost = $recipe_item['total_amount'] * $newUnitPrice;

                $update_data = [
                    'total_cost' => $total_cost
                ];
                $this->modelRecipeItem->update($recipe_item['recipe_item_id'], $update_data);
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'recipe_item',
                    $recipe_item['recipe_id'],
                    null,
                    'update',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                continue;
            }
        }
    }

    public function deleteBefore($stock_id = null)
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $stock_item = $this->modelStock->where('stock_id', $stock_id)->where('user_id', session()->get('user_id'))->first();
                if (!$stock_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok bulunamadı.']);
                    return;
                }


                //alt ürün var mı diye bak
                $substock_items = $this->modelStock->where('parent_id', $stock_id)->where('user_id', session()->get('user_id'))->findAll();

                if ($substock_items) {
                    $total_sub_stock = count($substock_items);
                    echo json_encode(['icon' => 'success', 'message' => 'Alt stok var', 'count' => $total_sub_stock, 'route_address' => route_to('tportal.stocks.list', 'all')]);
                    return;
                }
                else{
                    $total_sub_stock = count($substock_items);

                    echo json_encode(['icon' => 'success', 'message' => 'Alt stok yok', 'count' => 0, 'route_address' => route_to('tportal.stocks.list', 'all')]);
                    return;
                }

            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock',
                    $stock_id,
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

    public function delete($stock_id = null)
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $stock_item = $this->modelStock->where('stock_id', $stock_id)->where('user_id', session()->get('user_id'))->first();
                if (!$stock_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok bulunamadı.']);
                    return;
                }


                //alt ürün var mı diye bak
                $substock_items = $this->modelStock->where('parent_id', $stock_id)->where('user_id', session()->get('user_id'))->findAll();
                
                $stokMovement = $this->modelStockBarcode->where("stock_id", $stock_id)->countAllResults();

               
                $stockError = [];

                if ($substock_items) {
                    foreach ($substock_items as $substock_item) {
                        $stokMovement = $this->modelStockBarcode->where("stock_id", $substock_item["stock_id"])->countAllResults();
                        if ($stokMovement) {
                            $stockError[] = [
                                'stock_title' => $substock_item["stock_title"],
                                'error' => true,
                            ];
                        }
                    }
        
                    if (!empty($stockError)) {
                        echo json_encode(['icon' => 'error', 'message' => 'Alt ürünlerde stok hareketi bulunduğu için silinemedi', 'details' => $stockError]);
                        return;
                    } else {
                        // Alt ürünleri sil
                        foreach ($substock_items as $substock_item) {
                           $this->modelStock->delete($substock_item['stock_id']);
                        }
                        // Ana ürünü sil
                       $this->modelStock->delete($stock_id);
        
                        echo json_encode(['icon' => 'success', 'message' => 'Stok ve alt stok ürünleri başarıyla silindi.', 'route_address' => route_to('tportal.stocks.list', 'all')]);
                        return;
                    }
                } else {
                    if ($stokMovement) {
                        echo json_encode(['icon' => 'error', 'message' => 'Ürüne ait stok hareketi bulunduğu için silinemedi']);
                        return;
                    } else {
                        // Ana ürünü sil
                       $this->modelStock->delete($stock_id);
        
                        echo json_encode(['icon' => 'success', 'message' => 'Stok başarıyla silindi.', 'route_address' => route_to('tportal.stocks.list', 'all')]);
                        return;
                    }
                }
            

            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock',
                    $stock_id,
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

    # Bu aşağıdaki fonksiyon şu anda pasif durumda. Bu fonksiyon kendi panelimize taşınacak.
    # Yetkilendirme kontrolü orada yapılacak. Gerekli database bilgileri buraya post edilecek.
    # Gereken Bilgiler:
    #   -Hangi kullanıcı
    #   -Hangi Database
    #   -Hangi Tablo
    #   -Hangi Eleman
    # Bu sayede istenilen tablodaki istenilen değere müdahale edilebilecek.
    # İhtiyaç duyulmasının sebebi soft delete kullanmamız
    public function trash($stock_id)
    {

        $this->modelStock->delete($stock_id, true);

        return redirect()->back();
    }

    public function editStockProperty($stock_id = null)
    {
        $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $stock_id)->first();
        // $gallery_items = $this->modelStockGallery->where('stock_id', $stock_id)->orderBy('order', 'ASC')->findAll();

        if (!$stock_item) {
            return view('not-found');
        }

        $stock_operation = $this->modelStockOperation
        ->join('operation', 'operation.operation_id = stock_operation.operation_id')
        ->where("stock_operation.stock_id", $stock_id)
        ->findAll();
    
    $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
    
    // Tüm operasyon türleri için döngü oluştur
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
            }elseif ($status == "Durdu") {
                $operation_amounts[$operation_id]['islemde'] += $stock_amount;
            }
            elseif ($status == "Devam") {
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



    $data = [

            'operation_amounts' => $operation_amounts,
            'stock_operation' => $stock_operation,
            'stock_item' => $stock_item,
            // 'gallery_items' => $gallery_items
        ];

        return view('tportal/stoklar/detay/ozellikler', $data);
    }


    public function maliyetHesapla($stock_id = null)
    {
        // 1 ana ürün (ör: BLZ00001) çek
        $mainProduct = $this->modelStock
            ->where('user_id', session()->get('user_id'))
            ->where('stock_id', $stock_id)
            ->where('status', 'active')
            ->first();
    
            $stock_item = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock_id', $mainProduct['stock_id'])->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')->first();
            if (!$stock_item) {
                return view('not-found');
            }
    
            if ($stock_item['parent_id'] != 0)
                $parentStockId = $stock_item['parent_id'];
            else
                $parentStockId = 0;
    
            $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
    
            $stock_item['stock_total_amount'] = $this->sonStokBilgisi($stock_item['stock_id']);
    
    
            $data = [
                'stock_item' => $stock_item,
                'money_unit_items' => $money_unit_items,
                'parentStockId' => $parentStockId,
            ];
            // print_r($data['stock_item']);
    
    
            if ($stock_item['has_variant'] == 1) {
                $variant_property_items = $this->modelVariantProperty->join('variant_group', 'variant_group.variant_group_id = variant_property.variant_group_id')
                    ->join('variant_group_category', 'variant_group_category.variant_group_id = variant_group.variant_group_id')
                    ->where('variant_group_category.deleted_at', null)
                    ->where('variant_group.deleted_at', null)
                    ->where('variant_group_category.category_id', $stock_item['category_id'])
                    ->where('variant_group.status', 'active')
                    ->where('variant_group.maliyet', '1')
                    ->where('variant_group.user_id', session()->get('user_id'))
                    ->orderBy('variant_group.order')
                    ->orderBy('variant_property.order')
                    ->findAll();
    
                $variant_stocks = $this->modelStock->join('stock_variant_group', 'stock_variant_group.stock_id = stock.stock_id')
                    ->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
                    ->join('money_unit as sale_money_unit', 'sale_money_unit.money_unit_id = stock.sale_money_unit_id')
                    ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
                    ->select('stock.*, buy_money_unit.money_icon as buy_money_icon, sale_money_unit.money_icon as sale_money_icon')
                    ->select('stock_variant_group.*')
    
                    //->where('stock_variant_group.deleted_at', null)
                    
                    ->where('stock.parent_id', $stock_item['stock_id'])
                    ->where('stock.user_id', session()->get('user_id'))
                    ->orderBy('stock.stock_code', 'ASC')
                    ->findAll();
    
    
                $variant_groups = array_column($variant_property_items, 'variant_title', 'variant_column');
                $variant_properties = array_column($variant_property_items, 'variant_property_title', 'variant_property_id');
    
                $category_item = $this->modelCategory->find($stock_item['category_id']);
    
    
    
                foreach ($variant_stocks as &$variant_stock) {
                    $variant_stock['stock_total_amount'] = $this->getStockQuantity($variant_stock['stock_id'], $stock_item);
                }
                $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);
    
    
                $data = [
                    'stock_item' => $stock_item,
                    'money_unit_items' => $money_unit_items,
                ];
    
                    
    
                $data['variant_stocks'] = $variant_stocks;
                $data['variant_property_items'] = $variant_property_items;
                $data['variant_properties'] = $variant_properties;
                $data['variant_groups'] = $variant_groups;
                $data['category_item'] = $category_item;
                $data['parentStockId'] = $parentStockId;
    
                


                
                
            }

       

            if(!empty($data["variant_property_items"]) && !empty($data["variant_properties"])){
                $column_number = $data["variant_property_items"][0]["variant_column"];

                $data["column_number"] = $column_number;
            }


         
         
          

            return view('tportal/stoklar/maliyet_hesapla', $data);
    
     
    }


    public function ajaxMaliyetKaydet()
    {
        if ($this->request->getMethod(true) == 'POST') {
            try {
                $postData = $this->request->getPost();
            
                $this->modelMaliyetLogs = model('App\\Models\\TikoERP\\MaliyetLogsModel');
    
                $user_id = session()->get('user_id');
                $stock_id = $postData['stock_id'] ?? null;
                $created_at = date('Y-m-d H:i:s');
    
                // Çarpanlar
                $ham_carpani = $postData['ham_carpani'] ?? $postData['hamCarpaniInput'] ?? null;
                $kap_carpani = $postData['kap_carpani'] ?? $postData['kapCarpaniInput'] ?? null;
                $tas_carpani = $postData['tas_carpani'] ?? $postData['tasCarpaniInput'] ?? null;
                $mineli_carpani = $postData['mineli_default'] ?? $postData['mineliDefaultInput'] ?? null;
                $kar_orani_default = $postData['kar_orani_default'] ?? $postData['karOraniDefaultInput'] ?? null;
    
                $logCount = 0;
    
                // Variant satırları varsa
                if (isset($postData['variant']) && is_array($postData['variant'])) {
                    foreach ($postData['variant'] as $variant) {
                        $logData = [
                            'user_id' => $user_id,
                            'stock_id' => $variant['stock_id'] ?? null,
                            'variant_id' => $variant['variant_id'] ?? null,
                            'kod' => $variant['kod'] ?? null,
                            'urun' => $variant['urun'] ?? null,
                            'gram' => $variant['gram'] ?? null,
                            'tas_sayisi' => $variant['tas_sayisi'] ?? null,
                            'ham' => isset($variant['ham']) ? str_replace(['₺',','],['','.'],$variant['ham']) : null,
                            'kap_maliyet' => isset($variant['kap_maliyet']) ? str_replace(['₺',','],['','.'],$variant['kap_maliyet']) : null,
                            'mineli' => $variant['mineli'] ?? null,
                            'tasli' => isset($variant['tasli']) ? str_replace(['₺',','],['','.'],$variant['tasli']) : null,
                            'toplam_maliyet' => isset($variant['toplam_maliyet']) ? str_replace(['₺',','],['','.'],$variant['toplam_maliyet']) : null,
                            'kar_orani' => $variant['kar_orani'] ?? null,
                            'satis' => isset($variant['satis']) ? str_replace(['₺',','],['','.'],$variant['satis']) : null,
                            'ham_carpani' => $ham_carpani,
                            'kap_carpani' => $kap_carpani,
                            'tas_carpani' => $tas_carpani,
                            'mineli_carpani' => $mineli_carpani,
                            'kar_orani_default' => $kar_orani_default,
                            'created_at' => $created_at,
                        ];
                        $this->modelMaliyetLogs->addLog($logData);
                        $logCount++;
                    }
                } else {
                    // Tek satır için (örneğin ana ürün)
                    $logData = [
                        'user_id' => $user_id,
                        'stock_id' => $postData['stock_id'] ?? null,
                        'variant_id' => $postData['variant_id'] ?? null,
                        'kod' => $postData['kod'] ?? null,
                        'urun' => $postData['urun'] ?? null,
                        'gram' => $postData['gram'] ?? null,
                        'tas_sayisi' => $postData['tas_sayisi'] ?? null,
                        'ham' => isset($postData['ham']) ? str_replace(['₺',','],['','.'],$postData['ham']) : null,
                        'kap_maliyet' => isset($postData['kap_maliyet']) ? str_replace(['₺',','],['','.'],$postData['kap_maliyet']) : null,
                        'mineli' => $postData['mineli'] ?? null,
                        'tasli' => isset($postData['tasli']) ? str_replace(['₺',','],['','.'],$postData['tasli']) : null,
                        'toplam_maliyet' => isset($postData['toplam_maliyet']) ? str_replace(['₺',','],['','.'],$postData['toplam_maliyet']) : null,
                        'kar_orani' => $postData['kar_orani'] ?? null,
                        'satis' => isset($postData['satis']) ? str_replace(['₺',','],['','.'],$postData['satis']) : null,
                        'ham_carpani' => $ham_carpani,
                        'kap_carpani' => $kap_carpani,
                        'tas_carpani' => $tas_carpani,
                        'mineli_carpani' => $mineli_carpani,
                        'kar_orani_default' => $kar_orani_default,
                        'created_at' => $created_at,
                    ];
                    $this->modelMaliyetLogs->addLog($logData);
                    $logCount++;
                }
    
                return $this->response->setJSON([
                    'icon' => 'success',
                    'message' => 'Maliyet verileri başarıyla kaydedildi. ('.$logCount.' kayıt)',
                    'data' => $postData
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'icon' => 'error',
                    'message' => 'Hata: ' . $e->getMessage()
                ]);
            }
        } else {
            return $this->response->setJSON([
                'icon' => 'error',
                'message' => 'Geçersiz istek.'
            ]);
        }
    }

    public function barkodEkle()
    {
        // AJAX isteği kontrolü
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Geçersiz istek']);
        }

        // JSON verisini al
        $jsonData = $this->request->getJSON();
        $stock_id = $jsonData->stock_id ?? null;
        $barkod = $jsonData->barkod ?? null;

        // Validasyon
        if (!$stock_id || !$barkod) {
            return $this->response->setJSON(['success' => false, 'message' => 'Gerekli alanlar eksik']);
        }

        // Barkod uzunluk kontrolü
        if (strlen($barkod) !== 13) {
            return $this->response->setJSON(['success' => false, 'message' => 'Barkod 13 karakter olmalıdır']);
        }

        $stockBul = $this->modelStock->where('stock_id', $stock_id)->first();
        if (!$stockBul) {
            return $this->response->setJSON(['success' => false, 'message' => 'Stok bulunamadı']);
        }

        $barcode_number_2 = generate_barcode_number_fams($barkod);
        
        // Önce bu barkodun var olup olmadığını kontrol et
        $existingBarcode = $this->modelSysmondBarkodlar
            ->where('barkod', $barcode_number_2)
            ->first();
        
        if (!$existingBarcode) {
            // Barkod yoksa ekle
            $insertData = [
                'stock_id' => $stockBul['stock_id'],
                'sysmond_id' => $stockBul['sysmond'],
                'barkod' => $barcode_number_2,
                'stok_kodu' => $stockBul['stock_code'],
                'stok_basligi' => $stockBul['stock_title'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            
            $result = $this->modelSysmondBarkodlar->insert($insertData);
            
            if ($result) {
                log_message('info', 'Yeni barkod eklendi: ' . $barcode_number_2);
                return $this->response->setJSON(['success' => true, 'message' => 'Barkod başarıyla eklendi']);
            } else {
                log_message('error', 'Barkod eklenirken hata oluştu: ' . $barcode_number_2);
                return $this->response->setJSON(['success' => false, 'message' => 'Barkod eklenirken hata oluştu']);
            }
        } else {
            log_message('info', 'Bu barkod zaten var: ' . $barcode_number_2);
            return $this->response->setJSON(['success' => false, 'message' => 'Bu barkod zaten mevcut']);
        }
    }


    // Ürün Operasyon İşlemleri
    public function listStockOperation($stock_id = null)
    {
       
        $stock_item = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock_id', $stock_id)->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')->first();
        if (!$stock_item) {
            return view('not-found');
        }

        if ($stock_item['parent_id'] != 0)
            $parentStockId = $stock_item['parent_id'];
        else
            $parentStockId = 0;

            
        // $stock_item['stock_total_amount'] = $this->sonStokBilgisi($stock_item['stock_id']);
        $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);

        $operation_items = $this->modelOperation->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();
        $stock_operation_items = $this->modelStockOperation->join('stock', 'stock.stock_id = stock_operation.stock_id')
            ->join('operation', 'operation.operation_id = stock_operation.operation_id')
            ->select('stock_operation.*, operation.operation_title')
            ->where('stock.stock_id', $stock_id)
            ->orderBy('relation_order', 'ASC')
            ->findAll();

            foreach($stock_operation_items as &$stock_operation_item){
                $kisi_resource = $this->modelOperationResource->where('id', $stock_operation_item['kisi'])->first();
                $stock_operation_item['kisi'] = $kisi_resource ? $kisi_resource['name'] : null;
                $stock_operation_item['kisi_id'] = $kisi_resource ? $kisi_resource['id'] : null;
            
                $atolye_resource = $this->modelOperationResource->where('id', $stock_operation_item['atolye'])->first();
                $stock_operation_item['atolye'] = $atolye_resource ? $atolye_resource['name'] : null;
                $stock_operation_item['atolye_id'] = $atolye_resource ? $atolye_resource['id'] : null;
            
                $makine_resource = $this->modelOperationResource->where('id', $stock_operation_item['makine'])->first();
                $stock_operation_item['makine'] = $makine_resource ? $makine_resource['name'] : null;
                $stock_operation_item['makine_id'] = $makine_resource ? $makine_resource['id'] : null;
            
                $setup_resource = $this->modelOperationResource->where('id', $stock_operation_item['setup'])->first();
                $stock_operation_item['setup'] = $setup_resource ? $setup_resource['name'] : null;
                $stock_operation_item['setup_id'] = $setup_resource ? $setup_resource['id'] : null;
            }

          
        $operation_resources = $this->modelOperationResource->where('status', 'active')->orderBy('id', 'ASC')->findAll();

          
        
            $stock_operation = $this->modelStockOperation
            ->join('operation', 'operation.operation_id = stock_operation.operation_id')
            ->where("stock_operation.stock_id", $stock_id)
            ->findAll();
        
        $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
        
        // Tüm operasyon türleri için döngü oluştur
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
    
    
        $stock_items = $this->modelStock->where('user_id', session()->get('user_id'))->findAll();
    
        $data = [
    
                'operation_amounts' => $operation_amounts,
                'stock_operation' => $stock_operation,
                'operation_resources' => $operation_resources,
            'stock_item' => $stock_item,
            'stock_items' => $stock_items,
            'operation_items' => $operation_items,
            'stock_operation_items' => $stock_operation_items,
            'parentStockId' => $parentStockId,
        ];
     

        return view('tportal/stoklar/detay/operasyonlar', $data);
    }

    // Ürün Galeri İşlemleri
    public function listStockGallery($stock_id = null)
    {
        $stock_item = $this->modelStock->where('stock.user_id', session()->get('user_id'))->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')->where('stock_id', $stock_id)->first();
        $gallery_items = $this->modelStockGallery->where('stock_id', $stock_id)->orderBy('order', 'ASC')->findAll();

        $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);

        if ($stock_item['parent_id'] != 0)
            $parentStockId = $stock_item['parent_id'];
        else
            $parentStockId = 0;

        if (!$stock_item) {
            return view('not-found');
        }

        $stock_operation = $this->modelStockOperation
        ->join('operation', 'operation.operation_id = stock_operation.operation_id')
        ->where("stock_operation.stock_id", $stock_id)
        ->findAll();
    
    $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
    
    // Tüm operasyon türleri için döngü oluştur
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
            }elseif ($status == "Durdu") {
                $operation_amounts[$operation_id]['islemde'] += $stock_amount;
            }
            elseif ($status == "Devam") {
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



    $data = [

            'operation_amounts' => $operation_amounts,
            'stock_operation' => $stock_operation,
            'stock_item' => $stock_item,
            'gallery_items' => $gallery_items,
            'parentStockId' => $parentStockId,
        ];

        return view('tportal/stoklar/detay/galeri', $data);
    }

    public function listLoadStockGallery($stock_id = null)
    {
        $gallery_items = $this->modelStockGallery->join('stock', 'stock.stock_id = stock_gallery.stock_id')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock_gallery.stock_id', $stock_id)
            ->orderBy('stock_gallery.order', 'ASC')
            ->findAll();

        echo json_encode(['icon' => 'success', 'gallery_items' => $gallery_items]);
        return;
    }

    public function uploadStockGallery($stock_id = null)
    {
        $allowed_types = [
            'image/tiff',
            'image/jpeg',
            'image/png',
            'image/webp',
            'image/svg+xml',
            'image/gif',
            'image/bmp'
        ];

        if ($this->request->getMethod('true') == 'POST') {
            try {
                $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $stock_id)->first();
                if (!$stock_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok bulunamadı.']);
                    return;
                }

                $gallery_image = $this->request->getFile('file');
                if ($gallery_image) {
                    if ($gallery_image->isValid() && !$gallery_image->hasMoved()) {
                        $uploadDir = './images/uploads';
                        $newName = $gallery_image->getRandomName();

                        if (!array_search($gallery_image->getClientMimeType(), $allowed_types)) {
                            echo json_encode(['icon' => 'error', 'message' => 'Lütfen galeriye sadece resim yükleyiniz.']);
                            return;
                        }

                        $gallery_image->move($uploadDir, $newName);
                        $imagePath = str_replace(".", "", $uploadDir) . '/' . $newName;

                        $lastOrderItem = $this->modelStockGallery->join('stock', 'stock.stock_id = stock_gallery.stock_id')
                            ->where('stock.user_id', session()->get('user_id'))
                            ->where('stock_gallery.stock_id', $stock_id)
                            ->orderBy('stock_gallery.order', 'DESC')
                            ->first();
                        if ($lastOrderItem) {
                            $newOrder = $lastOrderItem['order'] + 1;
                        } else {
                            $newOrder = 1;
                        }

                        $insert_data = [
                            'stock_id' => $stock_id,
                            'image_path' => $imagePath,
                            'image_title' => $newName,
                            'status' => 'active',
                            'order' => $newOrder,
                            'default' => 'false'
                        ];
                        $this->modelStockGallery->insert($insert_data);
                    } else {
                        $this->logClass->save_log(
                            'error',
                            'stock_gallery',
                            null,
                            null,
                            'create',
                            'Resim taşınmış veya geçerli değil',
                            null,
                        );
                    }
                }

                echo json_encode(['icon' => 'success', 'message' => 'Resim başarıyla yüklendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock_gallery',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    null,
                );
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    public function deleteStockGallery()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $stock_code = $this->request->getPost('stock_code');
                $gallery_item_id = $this->request->getPost('gallery_item_id');
                $default_image = $this->request->getPost('default_image');

                $gallery_item = $this->modelStockGallery->join('stock', 'stock.stock_id = stock_gallery.stock_id')
                    ->where('stock.user_id', session()->get('user_id'))
                    ->where('stock.stock_code', $stock_code)
                    ->where('stock_gallery.gallery_item_id', $gallery_item_id)
                    ->first();

                if (!$gallery_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen resim bulunamadı.']);
                    return;
                } else {
                    $this->modelStockGallery->delete($gallery_item_id, true);

                    if ($default_image == $gallery_item['image_path']) {
                        $this->modelStock->set('default_image', 'uploads/default.png');
                        $this->modelStock->where('user_id', session()->get('user_id'));
                        $this->modelStock->where('stock_code', $stock_code);
                        $this->modelStock->update();
                    }

                    unlink('images/uploads/' . $gallery_item['image_title']);
                }
                echo json_encode(['icon' => 'success', 'message' => 'Resim başarıyla silindi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock_gallery',
                    $gallery_item_id,
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

    public function editStockGallery()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $gallery_item_id = $this->request->getPost('gallery_item_id');
                $order = $this->request->getPost('order');

                $gallery_item = $this->modelStockGallery->join('stock', 'stock.stock_id = stock_gallery.stock_id')
                    ->where('stock_gallery.gallery_item_id', $gallery_item_id)
                    ->where('stock.user_id', session()->get('user_id'))
                    ->first();
                if (!$gallery_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen resim bulunamadı.']);
                    return;
                }

                $this->modelStockGallery->update($gallery_item_id, ['order' => $order]);

                echo json_encode(['icon' => 'success', 'message' => 'Resim başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock_gallery',
                    $gallery_item_id,
                    null,
                    'edit',
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

    public function editStockGalleryStatus()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $gallery_item_id = $this->request->getPost('gallery_item_id');
                $status = $this->request->getPost('status');

                $gallery_item = $this->modelStockGallery->join('stock', 'stock.stock_id = stock_gallery.stock_id')
                    ->where('stock_gallery.gallery_item_id', $gallery_item_id)
                    ->where('stock.user_id', session()->get('user_id'))
                    ->first();
                if (!$gallery_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen resim bulunamadı.']);
                    return;
                }

                $this->modelStockGallery->update($gallery_item_id, ['status' => $status]);

                echo json_encode(['icon' => 'success', 'message' => 'Resim başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock_gallery',
                    $gallery_item_id,
                    null,
                    'edit',
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

    public function editStockGalleryDefault()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $gallery_item_id = $this->request->getPost('gallery_item_id');
                $stock_code = $this->request->getPost('stock_code');
                $image_path = $this->request->getPost('image_path');

                $gallery_item = $this->modelStockGallery->join('stock', 'stock.stock_id = stock_gallery.stock_id')
                    ->where('stock_gallery.gallery_item_id', $gallery_item_id)
                    ->where('stock.user_id', session()->get('user_id'))
                    ->first();

                  

                if (!$gallery_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen resim bulunamadı.']);
                    return;
                }

                $gallery_items = $this->modelStockGallery->join('stock', 'stock.stock_id = stock_gallery.stock_id')
                    ->where('stock.user_id', session()->get('user_id'))
                    ->where('stock.stock_code', $stock_code)
                    ->where('stock_gallery.default', 'true')
                    ->findAll();
                foreach ($gallery_items as $gallery_item) {
                    $this->modelStockGallery->update($gallery_item['gallery_item_id'], ['default' => 'false']);
                }

                $this->modelStockGallery->update($gallery_item_id, ['default' => 'true']);

                $this->modelStock->set('default_image', $image_path);
                $this->modelStock->where('user_id', session()->get('user_id'));
                $this->modelStock->where('stock_id', $gallery_item["stock_id"]);
                $this->modelStock->update();

                echo json_encode(['icon' => 'success', 'message' => 'Resim başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock',
                    $gallery_item_id,
                    null,
                    'edit',
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

    public function sonStokBilgisi($stock_id)
    {
        $stock_item = $this->modelStock
            ->where('stock.stock_id', $stock_id)
            ->first();

        if ($stock_item['has_variant'] == 1) {

            $variant_stocks = $this->modelStock
                ->join('stock_variant_group', 'stock_variant_group.stock_id = stock.stock_id')
                ->where('stock_variant_group.deleted_at', null)
                ->where('stock.parent_id', $stock_item['stock_id'])
                ->where('stock.user_id', session()->get('user_id'))
                ->orderBy('stock.stock_code', 'ASC')
                ->findAll();



            $grandTotal = 0;
            foreach ($variant_stocks as &$variant_stock) {
                $variant_stock['stock_total_amount'] = $this->sonStokBilgisi($variant_stock['stock_id']); //$variant_stock['stock_id'];
                $grandTotal += $this->sonStokBilgisi($variant_stock['stock_id']);
            }

            return $grandTotal;
        } else {
            $stock_movement_items = $this->modelStock
                ->join('stock_barcode', 'stock_barcode.stock_id = stock.stock_id')
                ->join('stock_movement', 'stock_movement.stock_barcode_id = stock_barcode.stock_barcode_id')
                ->where('stock.user_id', session()->get('user_id'))
                ->where('stock.stock_id', $stock_id)
                ->findAll();

            $total_stock_quantity = 0;
            foreach ($stock_movement_items as $stock_movement_item) {
                $total_stock_quantity = $stock_movement_item['movement_type'] == 'incoming' ? ($total_stock_quantity + $stock_movement_item['transaction_quantity']) : ($total_stock_quantity - $stock_movement_item['transaction_quantity']);
            }

            return $total_stock_quantity;
        }
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

 /* Eski Versiyonu
    public function listStockMovement($stock_id = null)
    {
        $stock_item = $this->modelStock->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.stock_id', $stock_id)
            ->select('stock.*')
            ->select('buy_unit.unit_title as buy_unit_title, buy_unit.unit_value as buy_unit_value')
            ->select('sale_unit.unit_title as sale_unit_title, sale_unit.unit_value as sale_unit_value')
            ->first();

        $stock_movement_items_parent = null;

        if ($stock_item['parent_id'] != 0)
            $parentStockId = $stock_item['parent_id'];
        else {
            $parentStockId = 0;

            if ($stock_item['stock_type'] == 'product' ) {
                $stock_movement_items_parent = $this->modelStock
                    ->select('child.*,sm.*,warehouse.warehouse_title, unit.unit_title, invoice.cari_invoice_title,invoice.sale_type, invoice.is_return')
                    ->join('stock as child', 'child.stock_id = stock.stock_id')
                    ->join('stock_barcode as sb', 'sb.stock_id = child.stock_id')
                    ->join('stock_movement as sm', 'sm.stock_barcode_id = sb.stock_barcode_id')
                    ->join('warehouse', 'warehouse.warehouse_id = sm.to_warehouse', 'left')
                    ->join('unit', 'unit.unit_id = child.sale_unit_id')
                    ->join('invoice', 'invoice.invoice_id = sm.invoice_id')
                    ->where('child.stock_id', $stock_id)
                    ->orwhere('child.parent_id', $stock_id)
                    ->where('child.deleted_at IS NULL')
                    ->where('sm.deleted_at IS NULL')
                    ->where('sb.deleted_at IS NULL')
                    ->orderBy('sm.transaction_date')
                    ->findAll();
            } else {
                $stock_movement_items_parent = $this->modelStock
                    ->select('child.*, sm.*, warehouse.warehouse_title, unit.unit_title, invoice.cari_invoice_title,invoice.sale_type, invoice.is_return')
                    ->join('stock as child', 'child.stock_id = stock.stock_id')
                    ->join('stock_barcode as sb', 'sb.stock_id = stock.stock_id')
                    ->join('stock_movement as sm', 'sm.stock_barcode_id = sb.stock_barcode_id')
                    ->join('warehouse', 'warehouse.warehouse_id = sm.to_warehouse', 'left')
                    ->join('unit', 'unit.unit_id = child.sale_unit_id')
                    ->join('invoice', 'invoice.invoice_id = sm.invoice_id')
                    ->groupStart()
                        ->where('stock.parent_id', $stock_id)
                        ->where('stock.stock_id', $stock_id)
                    ->groupEnd()
                    ->where('child.deleted_at IS NULL')
                    ->where('sm.deleted_at IS NULL')
                    ->where('sb.deleted_at IS NULL')
                    ->orderBy('sm.transaction_date')
                    ->findAll();
            }
            
        }

        $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);

        


        # Ürün kodu geçerli mi diye kontrol ediyoruz.
        if (!$stock_item) {
            return view('not-found');
        }

        $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
        $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();
        $supplier_items = $this->modelCari->where('is_supplier', 1)->where('user_id', session()->get('user_id'))->orderBy('cari_id', 'ASC')->findAll();
        $stock_movement_items = $this->modelStockMovement->select([
            'sm_outer.*',
            'stock_barcode.*',
            'stock.stock_type',
            'invoice.invoice_id',
            'invoice.sale_type',
            'invoice.is_return',
            'invoice.cari_invoice_title',
            '(SELECT SUM(stock_barcode.total_amount - stock_barcode.used_amount)
              FROM stock_movement sm_inner
              JOIN stock_barcode ON sm_inner.stock_barcode_id = stock_barcode.stock_barcode_id
              WHERE sm_inner.transaction_date <= sm_outer.transaction_date
                AND stock_barcode.stock_id = ' . $stock_item['stock_id'] . '
                AND stock_barcode.deleted_at is null
              ORDER BY sm_inner.transaction_date DESC
            ) AS stock_amount'
        ])
            ->from('stock_movement sm_outer')
            ->join('stock_barcode', 'sm_outer.stock_barcode_id = stock_barcode.stock_barcode_id')
            ->join('stock', 'stock.stock_id = stock_barcode.stock_id')
            ->join('cari', 'cari.cari_id = stock_movement.supplier_id','left')
            ->join('invoice', 'invoice.invoice_id = sm_outer.invoice_id')
            ->where('stock_barcode.stock_id', $stock_item['stock_id'])
            ->where('sm_outer.deleted_at IS NULL')
            ->where('stock_barcode.deleted_at IS NULL')
            ->groupBy([
                'sm_outer.transaction_number',
                'sm_outer.buy_unit_price',
                'stock_barcode.total_amount'
            ])
            ->orderBy('sm_outer.transaction_date')
            ->findAll();

    
          //  print_r($stock_movement_items);
            // return;
            $stock_operation = $this->modelStockOperation
            ->join('operation', 'operation.operation_id = stock_operation.operation_id')
            ->where("stock_operation.stock_id", $stock_id)
            ->findAll();
        
        $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
        
        // Tüm operasyon türleri için döngü oluştur
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
    
    
    
        $data = [
    
                'operation_amounts' => $operation_amounts,
                'stock_operation' => $stock_operation,
            'supplier_items' => $supplier_items,
            'warehouse_items' => $warehouse_items,
            'money_unit_items' => $money_unit_items,
            'stock_movement_items' => $stock_movement_items,
            'stock_item' => $stock_item,
            'temp_balance' => 0,
            'parentStockId' => $parentStockId,
            'stock_movement_items_parent' => $stock_movement_items_parent,
        ];

        return view('tportal/stoklar/detay/hareketler', $data);
    } */
    

    //Ürün Hareket İşlemleri
    public function listStockMovement($stock_id = null)
    {

        $db = $this->userDatabase();

        $stock_item = $this->modelStock->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.stock_id', $stock_id)
            ->select('stock.*')
            ->select('buy_unit.unit_title as buy_unit_title, buy_unit.unit_value as buy_unit_value')
            ->select('sale_unit.unit_title as sale_unit_title, sale_unit.unit_value as sale_unit_value')
            ->first();

        $stock_movement_items_parent = null;

        if ($stock_item['parent_id'] != 0)
            $parentStockId = $stock_item['parent_id'];
        else {
            $parentStockId = 0;

            if ($stock_item['stock_type'] == 'product' ) {
                $query = "
        SELECT child.*, sm.*, warehouse.warehouse_title, unit.unit_title, invoice.cari_invoice_title, invoice.sale_type, invoice.is_return
        FROM stock AS child
        JOIN stock_barcode AS sb ON sb.stock_id = child.stock_id
        JOIN stock_movement AS sm ON sm.stock_barcode_id = sb.stock_barcode_id
        LEFT JOIN warehouse ON warehouse.warehouse_id = sm.to_warehouse
        JOIN unit ON unit.unit_id = child.sale_unit_id
        JOIN invoice ON invoice.invoice_id = sm.invoice_id
        WHERE (child.stock_id = $stock_id OR child.parent_id = $stock_id)
        AND child.deleted_at IS NULL
        AND sm.deleted_at IS NULL
        AND sb.deleted_at IS NULL
        ORDER BY sm.transaction_date;
    ";

    $stock_movement_items_parent = $db->query($query)->getResultArray();
                /* $stock_movement_items_parent = $this->modelStock
                    ->select('child.*, sm.*, warehouse.warehouse_title, unit.unit_title, invoice.cari_invoice_title,invoice.sale_type, invoice.is_return')
                    ->join('stock as child', 'child.stock_id = stock.stock_id')
                    ->join('stock_barcode as sb', 'sb.stock_id = child.stock_id')
                    ->join('stock_movement as sm', 'sm.stock_barcode_id = sb.stock_barcode_id')
                    ->join('warehouse', 'warehouse.warehouse_id = sm.to_warehouse', 'left')
                    ->join('unit', 'unit.unit_id = child.sale_unit_id')
                    ->join('invoice', 'invoice.invoice_id = sm.invoice_id')
                    ->where('child.stock_id', $stock_id)
                    ->orwhere('child.parent_id', $stock_id)
                    ->where('child.deleted_at IS NULL')
                    ->where('sm.deleted_at IS NULL')
                    ->where('sb.deleted_at IS NULL')
                    ->orderBy('sm.transaction_date')
                    ->findAll(); */
            } else {

                $query = "
                SELECT child.*, sm.*, warehouse.warehouse_title, unit.unit_title, invoice.cari_invoice_title, invoice.sale_type, invoice.is_return
                FROM stock AS child
                JOIN stock_barcode AS sb ON sb.stock_id = stock.stock_id
                JOIN stock_movement AS sm ON sm.stock_barcode_id = sb.stock_barcode_id
                LEFT JOIN warehouse ON warehouse.warehouse_id = sm.to_warehouse
                JOIN unit ON unit.unit_id = child.sale_unit_id
                JOIN invoice ON invoice.invoice_id = sm.invoice_id
                WHERE (child.parent_id = $stock_id OR child.stock_id = $stock_id)
                AND child.deleted_at IS NULL
                AND sm.deleted_at IS NULL
                AND sb.deleted_at IS NULL
                ORDER BY sm.transaction_date;
            ";
        
            $stock_movement_items_parent = $db->query($query)->getResultArray();

               /* $stock_movement_items_parent = $this->modelStock
                    ->select('child.*, sm.*, warehouse.warehouse_title, unit.unit_title, invoice.cari_invoice_title,invoice.sale_type, invoice.is_return')
                    ->join('stock as child', 'child.stock_id = stock.stock_id')
                    ->join('stock_barcode as sb', 'sb.stock_id = stock.stock_id')
                    ->join('stock_movement as sm', 'sm.stock_barcode_id = sb.stock_barcode_id')
                    ->join('warehouse', 'warehouse.warehouse_id = sm.to_warehouse', 'left')
                    ->join('unit', 'unit.unit_id = child.sale_unit_id')
                    ->join('invoice', 'invoice.invoice_id = sm.invoice_id')
                    ->groupStart()
                        ->where('stock.parent_id', $stock_id)
                        ->where('stock.stock_id', $stock_id)
                    ->groupEnd()
                    ->where('child.deleted_at IS NULL')
                    ->where('sm.deleted_at IS NULL')
                    ->where('sb.deleted_at IS NULL')
                    ->orderBy('sm.transaction_date')
                    ->findAll(); */
            }
            
        }

        $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);

        


        # Ürün kodu geçerli mi diye kontrol ediyoruz.
        if (!$stock_item) {
            return view('not-found');
        }

        $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
        $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();
        $supplier_items = $this->modelCari->where('is_supplier', 1)->where('user_id', session()->get('user_id'))->orderBy('cari_id', 'ASC')->findAll();
        $query = "
           SELECT sm_outer.*, stock_barcode.*, stock.stock_type, invoice.invoice_id, invoice.sale_type, invoice.is_return, invoice.cari_invoice_title, 
                SUM(stock_barcode.total_amount - stock_barcode.used_amount) AS stock_amount
            FROM stock_movement sm_outer
            JOIN stock_barcode ON sm_outer.stock_barcode_id = stock_barcode.stock_barcode_id
            JOIN stock ON stock.stock_id = stock_barcode.stock_id
            LEFT JOIN cari ON cari.cari_id = sm_outer.supplier_id
            JOIN invoice ON invoice.invoice_id = sm_outer.invoice_id
            WHERE stock_barcode.stock_id = $stock_id
            AND sm_outer.deleted_at IS NULL
            AND stock_barcode.deleted_at IS NULL
            GROUP BY sm_outer.transaction_number, sm_outer.buy_unit_price, stock_barcode.total_amount
            ORDER BY sm_outer.transaction_date;
        ";
        
        $stock_movement_items = $db->query($query)->getResultArray();
    
          //  print_r($stock_movement_items);
            // return;
            $stock_operation = $this->modelStockOperation
            ->join('operation', 'operation.operation_id = stock_operation.operation_id')
            ->where("stock_operation.stock_id", $stock_id)
            ->findAll();
        
        $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
        
        // Tüm operasyon türleri için döngü oluştur
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
    
    
    
        $data = [
    
                'operation_amounts' => $operation_amounts,
                'stock_operation' => $stock_operation,
            'supplier_items' => $supplier_items,
            'warehouse_items' => $warehouse_items,
            'money_unit_items' => $money_unit_items,
            'stock_movement_items' => $stock_movement_items,
            'stock_item' => $stock_item,
            'temp_balance' => 0,
            'parentStockId' => $parentStockId,
            'stock_movement_items_parent' => $stock_movement_items_parent,
        ];

        return view('tportal/stoklar/detay/hareketler', $data);
    }

    public function createStockBarcode($stock_id = null)
    {
        if ($this->request->getMethod('true') == 'POST') {
            # TODO: Bu query duruma göre azaltılabilir. Barkod sayfasının htmli oluşturulduktan sonra gereksiz şeyler buradan çıkıcak
            # Şu anda sadece ürün geçerli mi diye bakıyoruz ve generate_barcode_html içerisine yolluyoruz. Başka bir işlevi yok bu querynin.
            $stock_item = $this->modelStock->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
                ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
                ->join('stock_variant_group', 'stock_variant_group.stock_id = stock.stock_id')
                ->join('variant_property v1', 'v1.variant_property_id = stock_variant_group.variant_1','left')
                ->join('variant_property v2', 'v2.variant_property_id = stock_variant_group.variant_2','left')
                ->join('variant_property v3', 'v3.variant_property_id = stock_variant_group.variant_3','left')
                ->join('variant_property v4', 'v4.variant_property_id = stock_variant_group.variant_4','left')
                ->join('variant_group vg1', 'v1.variant_group_id = vg1.variant_group_id','left')
                ->join('variant_group vg2', 'v2.variant_group_id = vg2.variant_group_id','left')
                ->join('variant_group vg3', 'v3.variant_group_id = vg3.variant_group_id','left')
                ->join('variant_group vg4', 'v4.variant_group_id = vg4.variant_group_id','left')
                ->select('stock.*, stock_variant_group.*')
                ->select('buy_unit.unit_title as buy_unit_title, buy_unit.unit_value as buy_unit_value')
                ->select('sale_unit.unit_title as unit_title, sale_unit.unit_value as sale_unit_value')
                ->select('v1.variant_property_title as variant_property_v1, vg1.variant_title as variant_title_v1')
                ->select('v2.variant_property_title as variant_property_v2, vg2.variant_title as variant_title_v2')
                ->select('v3.variant_property_title as variant_property_v3, vg3.variant_title as variant_title_v3')
                ->select('v4.variant_property_title as variant_property_v4, vg4.variant_title as variant_title_v4')
                ->where('stock.user_id', session()->get('user_id'))
                ->where('stock.stock_id', $stock_id)
                
                ->first();
                if (!$stock_item) {
                    echo json_encode(['icon' => 'error', 'message' => $stock_id]);
                    return;
                }
        
                $data_form = $this->request->getPost('data_form');
                $data_rows = $this->request->getPost('data_rows');
        
                foreach ($data_form as $data) {
                    $key = $data['name'];
                    $value = $data['value'];
                    $new_data_form[$key] = $value;
                }
        
                $all_barcode = array();
                
                try {
                    // Fatura için toplam değerleri hesaplama
                    $total_stock_quantity = 0;
                    $total_stock_price = 0;
                    $warehouse_id = $new_data_form['warehouse_id'];
                    $supplier_id = $new_data_form['supplier_id'];
                    $buy_unit_price = convert_number_for_sql($new_data_form['buy_unit_price']);
                    $buy_money_unit_id = $new_data_form['buy_money_unit_id'];
                    $currency_amount = str_replace(',', '.', $this->request->getPost('currency_amount')) ?? 1;
        
                    // Önce toplamları hesapla
                    foreach ($data_rows as $row) {
                        if (is_numeric($row['miktar'])) {
                            $stock_quantity = $row['miktar'];
                            $total_stock_quantity += $stock_quantity;
                            $total_stock_price += ($stock_quantity * $buy_unit_price);
                        }
                    }
        
                    // Tedarikçi varsa tek bir fatura oluştur
                    $invoice_id = 0;
                    $financialMovement_id = 0;
                    
                    if ($supplier_id != 0) {
                        $supplier = $this->modelCari->join('address', 'cari.cari_id = address.cari_id', 'left')
                            ->where('cari.cari_id', $supplier_id)
                            ->where('cari.user_id', session()->get('user_id'))
                            ->first();
        
                        $stock_entry_prefix = "STKTDRK";
                        $currentDateTime = new Time('now', 'Turkey', 'en_US');
                        
                        // Finansal hareket oluştur
                        $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))
                            ->orderBy('transaction_counter', 'DESC')
                            ->first();
                            
                        $transaction_counter = $last_transaction ? $last_transaction['transaction_counter'] + 1 : 1;
                        $transaction_number = $stock_entry_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
        
                        // Tek bir finansal hareket oluştur
                        $insert_financial_movement_data = [
                            'user_id' => session()->get('user_id'),
                            'cari_id' => $supplier_id,
                            'money_unit_id' => $buy_money_unit_id,
                            'transaction_number' => $transaction_number,
                            'transaction_direction' => 'entry',
                            'transaction_type' => 'incoming_invoice',
                            'transaction_tool' => 'not_payroll',
                            'transaction_title' => "Stok girişinden oluşan hareket",
                            'transaction_description' => "Stok girişinden oluşan otomatik hareket",
                            'transaction_amount' => $total_stock_price,
                            'transaction_real_amount' => $total_stock_price,
                            'transaction_date' => $currentDateTime,
                            'transaction_prefix' => $stock_entry_prefix,
                            'transaction_counter' => $transaction_counter
                        ];
                        
                        $this->modelFinancialMovement->insert($insert_financial_movement_data);
                        $financialMovement_id = $this->modelFinancialMovement->getInsertID();
        
                        // Tek bir fatura oluştur
                        $insert_invoice_data = [
                            'user_id' => session()->get('user_id'),
                            'money_unit_id' => $buy_money_unit_id,
                            'sale_type' => "quick",
                            'invoice_direction' => 'incoming_invoice',
                            'invoice_date' => $currentDateTime,
                            'expiry_date' => $currentDateTime,
                            'currency_amount' => $currency_amount,
                            'stock_total' => $total_stock_price,
                            'stock_total_try' => $total_stock_price * floatval($currency_amount),
                            'sub_total' => $total_stock_price,
                            'sub_total_try' => $total_stock_price * floatval($currency_amount),
                            'grand_total' => $total_stock_price,
                            'grand_total_try' => $total_stock_price * floatval($currency_amount),
                            'amount_to_be_paid' => $total_stock_price,
                            'amount_to_be_paid_try' => $total_stock_price * floatval($currency_amount),
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
                        
                        $this->modelInvoice->insert($insert_invoice_data);
                        $invoice_id = $this->modelInvoice->getInsertID();
                        
                        // Finansal hareket güncelle
                        $this->modelFinancialMovement->update($financialMovement_id, [
                            'invoice_id' => $invoice_id
                        ]);
                    }
        
                    // Şimdi her satır için işlem yap
                    foreach ($data_rows as $row) {
                        if (is_numeric($row['miktar'])) {
                            $stock_quantity = $row['miktar'];
                            
                            // Barkod oluştur
                            $barcode_number = generate_barcode_number();
                            $formatted_date = date('d-m-Y');
                            $insert_barcode_data = [
                                'stock_id' => $stock_item['stock_id'],
                                'warehouse_id' => $warehouse_id,
                                'warehouse_address' => $new_data_form['warehouse_address'],
                                'barcode_number' => $barcode_number,
                                'total_amount' => $stock_quantity,
                                'used_amount' => 0,
                                'barkod_olusturma' => $formatted_date,
                            ];
                            
                            $this->modelStockBarcode->insert($insert_barcode_data);
                            $stock_barcode_id = $this->modelStockBarcode->getInsertID();
        
                            // Eğer fatura varsa satır ekle
                            if ($invoice_id > 0) {
                                $insert_invoice_row_data = [
                                    'user_id' => session()->get('user_id'),
                                    'invoice_id' => $invoice_id,
                                    'stock_id' => $stock_item['stock_id'],
                                    'stock_barcode_id' => $stock_barcode_id,
                                    'stock_title' => $stock_item['stock_title'],
                                    'stock_amount' => $stock_quantity,
                                    'unit_id' => $stock_item['buy_unit_id'],
                                    'unit_price' => $buy_unit_price,
                                    'subtotal_price' => $stock_quantity * $buy_unit_price,
                                    'total_price' => $stock_quantity * $buy_unit_price,
                                ];
                                $this->modelInvoiceRow->insert($insert_invoice_row_data);
                            }
        
                            // Stok hareketi oluştur
                            $stock_movement_prefix = 'TRNSCTN';
                            $last_transaction_stock_movement = $this->modelStockMovement
                                ->where('user_id', session()->get('user_id'))
                                ->orderBy('transaction_counter', 'DESC')
                                ->first();
                                
                            $transaction_counter_stock_movement = $last_transaction_stock_movement ? 
                                $last_transaction_stock_movement['transaction_counter'] + 1 : 1;
                                
                            $transaction_number_stock_movement = $stock_movement_prefix . 
                                str_pad($transaction_counter_stock_movement, 6, '0', STR_PAD_LEFT);
        
                            $insert_movement_data = [
                                'user_id' => session()->get('user_id'),
                                'stock_barcode_id' => $stock_barcode_id,
                                'invoice_id' => $invoice_id,
                                'supplier_id' => $supplier_id,
                                'movement_type' => 'incoming',
                                'transaction_number' => $transaction_number_stock_movement,
                                'to_warehouse' => $warehouse_id,
                                'transaction_note' => $new_data_form['transaction_note'],
                                'transaction_info' => $supplier_id != 0 ? 
                                    ($supplier['invoice_title'] == '' ? $supplier['name'] . " " . $supplier['surname'] : $supplier['invoice_title']) : 
                                    'Manuel Stok',
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
                                $this->modelFinancialMovement->update($financialMovement_id, [
                                    'stock_movement_id' => $stock_movement_id
                                ]);
                            }
        
                            // Depo miktarlarını güncelle
                            $insert_StockWarehouseQuantity = [
                                'user_id' => session()->get('user_id'),
                                'warehouse_id' => $warehouse_id,
                                'stock_id' => $stock_item['stock_id'],
                                'parent_id' => $stock_item['parent_id'],
                                'stock_quantity' => $stock_quantity,
                            ];
        
                            $addStock = updateStockWarehouseParentQuantity(
                                $insert_StockWarehouseQuantity, 
                                $warehouse_id, 
                                $stock_id, 
                                $stock_item['parent_id'], 
                                $stock_quantity, 
                                'add', 
                                $this->modelStockWarehouseQuantity, 
                                $this->modelStock
                            );
        
                            if ($addStock === 'eksi_stok') {
                                echo json_encode([
                                    'icon' => 'error', 
                                    'message' => 'bu işlemden sonra stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz.'
                                ]);
                                return;
                            }
        
                            $barcode_html = generate_barcode_html($stock_item, $insert_barcode_data, $new_data_form['transaction_note'], $supplier);
                            array_push($all_barcode, $barcode_html);
                        }
                    }
        
                    echo json_encode([
                        'icon' => 'success', 
                        'message' => 'Stok hareketi başarıyla oluşturuldu.', 
                        'all_barcode' => $all_barcode
                    ]);
                    return;
        
                } catch (\Exception $e) {
                    $this->logClass->save_log(
                        'error',
                        'stock_movement',
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


    public function getBarkodDetail()
    {
      // Retrieve the barcode from the POST request
        $barkod = $this->request->getPost('barcode');
        $submittedStockID = $this->request->getPost('stockID');

        // Step 1: Try the first modification function (convert_barcode_number_for_sql_production)
        $sorgu = convert_barcode_number_for_sql_production($barkod); // Attempt to modify to 18 characters

        // Step 2: Check if the barcode exists in the database with the modified barcode
        $StoktanBul = $this->modelStockBarcode->where("barcode_number", $sorgu)->first();

        // If no match found, move to the next function
        if (!$StoktanBul) {
            // Step 3: Try the second modification function (convert_barcode_number_for_sql)
            $sorgu = convert_barcode_number_for_sql($barkod); // Modify again to 18 characters
            
            // Check the database again with this modified barcode
            $StoktanBul = $this->modelStockBarcode->where("barcode_number", $sorgu)->first();
        }

        // If still no match, try the final function
        if (!$StoktanBul) {
            // Step 4: Try the third modification function (convert_barcode_number_for_sql_4)
            $sorgu = convert_barcode_number_for_sql_4($barkod); // Modify to 17 characters
            
            // Check the database one more time
            $StoktanBul = $this->modelStockBarcode->where("barcode_number", $sorgu)->first();
        }

        // Step 5: If still no stock found after all attempts, return an error message
        if (!$StoktanBul) {
            echo json_encode([
                'icon' => 'danger',
                'stock_id' => null,
                'data' => "Okuttuğunuz Barkoda Ait Stok Bulunamadı <br> <b>Okutulan Barkod:  " . $sorgu . "  </b>"
            ]);
            return;
        }
        
        $StokAdiniBul = $this->modelStock->where("stock_id", $StoktanBul["stock_id"])->join('unit', 'unit.unit_id = stock.sale_unit_id')->first();
        
        // Check if the barcode belongs to a different product (different stock_id)
        if ($submittedStockID && $submittedStockID != $StoktanBul["stock_id"]) {
            echo json_encode([
                'icon' => 'info',
                'data' => 'Bu barkod, <b>"' . $StokAdiniBul["stock_title"] . '"</b> ürününe aittir ve şu anda başka bir ürün için barkod taratıyorsunuz.',
                'stock_id' => $StoktanBul["stock_id"]
            ]);
            return;
        }

  
 

$stock_id = $StoktanBul["stock_id"];
$stock_barcode_id = $StoktanBul["stock_barcode_id"];


     $db = $this->userDatabase();

     $stock_item = $this->modelStock->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
         ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
         ->where('stock.user_id', session()->get('user_id'))
         ->where('stock.stock_id', $stock_id)
         ->select('stock.*')
         ->select('buy_unit.unit_title as buy_unit_title, buy_unit.unit_value as buy_unit_value')
         ->select('sale_unit.unit_title as sale_unit_title, sale_unit.unit_value as sale_unit_value')
         ->first();

     

     $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);

     


     # Ürün kodu geçerli mi diye kontrol ediyoruz.
     if (!$stock_item) {
         return view('not-found');
     }

     $query = "
        SELECT sm_outer.*, stock_barcode.*, stock.stock_type, invoice.invoice_id, invoice.sale_type, invoice.is_return, invoice.cari_invoice_title, 
             SUM(stock_barcode.total_amount - stock_barcode.used_amount) AS stock_amount
         FROM stock_movement sm_outer
         JOIN stock_barcode ON sm_outer.stock_barcode_id = stock_barcode.stock_barcode_id
         JOIN stock ON stock.stock_id = stock_barcode.stock_id
         LEFT JOIN cari ON cari.cari_id = sm_outer.supplier_id
         JOIN invoice ON invoice.invoice_id = sm_outer.invoice_id
         WHERE stock_barcode.stock_barcode_id = $stock_barcode_id
         AND sm_outer.deleted_at IS NULL
         AND stock_barcode.deleted_at IS NULL
         GROUP BY sm_outer.transaction_number, sm_outer.buy_unit_price, stock_barcode.total_amount
         ORDER BY sm_outer.transaction_date DESC
     ";
     
     $stock_movement_items = $db->query($query)->getResultArray();
 
    
     
    
 
 
 
     $data = [
 

         'stock_movement_items' => $stock_movement_items,
         'stock_item' => $stock_item,
       
     ];


     $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
     $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();
     $supplier_items = $this->modelCari->where('is_supplier', 1)->where('user_id', session()->get('user_id'))->orderBy('cari_id', 'ASC')->findAll();


    
        // Initialize HTML content to be populated with stock barcode data
        $html_baslik = '<div class="form-inline"><h5>'.$StokAdiniBul["stock_code"].' - '.$StokAdiniBul["stock_title"].'</h5> </div>';
        $html = '
        <div class="form-inline mb-5">
            <h5>' . $stock_item['stock_code'] . ' - ' . $stock_item['stock_title'] . ' </h5>
        </div>
        <table class="datatable-init-hareketler nowrap table" data-export-title="Export">
            <thead>
                <tr style="background-color: #ebeef2;">
                    <th>Tarih</th>
                    <th>İşlem</th>
                    <th>İşlem No</th>
                    <th>Bilgi</th>
                    <th>Depo</th>
                    <th>Miktar</th>
                    <th>Stok</th>
                    <th>...</th>
                </tr>
            </thead>
            <tbody>';
            
        foreach ($stock_movement_items as $item) {
            $transactionDate = date("d/m/Y", strtotime($item['transaction_date']));
            $transactionType = $item['movement_type'] == 'incoming' 
                ? '<span class="tb-status text-success">Giriş</span>'
                : ($item['movement_type'] == 'outgoing' 
                    ? '<span class="tb-status text-danger">Çıkış</span>' 
                    : '<span class="tb-status text-soft">Sevk</span>');
            $transactionInfo = $item['transaction_info'] ?? '-';
            $transactionNumber = $item['transaction_number'] ?? '-';
            $quantity = number_format($item['transaction_quantity'], 2, ',', '.');
          
            
            // Depo bilgisi
            $warehouseInfo = '-';
            if (!empty($item['from_warehouse'])) {
                $warehouse = $warehouse_items[array_search($item['from_warehouse'], array_column($warehouse_items, 'warehouse_id'))]['warehouse_title'];
                $warehouseInfo = $warehouse . ($item['is_return'] == 1 ? '<small> (iade)</small>' : '');
            } elseif (!empty($item['to_warehouse'])) {
                $warehouse = $warehouse_items[array_search($item['to_warehouse'], array_column($warehouse_items, 'warehouse_id'))]['warehouse_title'];
                $warehouseInfo = $warehouse . ($item['is_return'] == 1 ? '<small> (iade)</small>' : '');
            }
        
            $actionButton = '-';
            if ($item['movement_type'] == 'outgoing') {
                if ($item['sale_type'] == 'detailed') {
                    $actionButton = '<a href="' . route_to('tportal.faturalar.detail', $item['invoice_id']) . '" class="btn btn-icon btn-xs btn-dim btn-outline-dark" data-bs-title="Faturayı Görüntüle Detaylı">
                        <em class="icon ni ni-arrow-right"></em>
                    </a>';
                } elseif ($item['sale_type'] == 'quick') {
                    $actionButton = '<a href="' . route_to('tportal.cari.quick_sale_order.detail', $item['invoice_id']) . '" class="btn btn-icon btn-xs btn-dim btn-outline-dark" data-bs-title="Faturayı Görüntüle Hızlı">
                        <em class="icon ni ni-arrow-right"></em>
                    </a>';
                }
            } else {
                $actionButton = '<button type="button" class="btn btn-icon btn-xs btn-dim btn-outline-dark" data-barcode-number="' . $item['barcode_number'] . '" data-bs-title="Barkod Yazdır">
                    <em class="icon ni ni-printer-fill"></em>
                </button>';
             
            }
        
            // Tablo satırını oluştur
            $html .= '
            <tr>
                <td data-order="' . $item['transaction_date'] . $item['stock_movement_id'] . '" title="' . $item['transaction_date'] . '">' . $transactionDate . '</td>
                <td>' . $transactionType . '</td>
                <td>' . $transactionNumber . '</td>
                <td>' . $transactionInfo . '</td>
                <td>' . $warehouseInfo . '</td>
                <td class="text-right">' . $quantity . '</td>
               
                <td>' . $actionButton . '</td>
            </tr>';
        }
        
        $html .= '
            </tbody>
        </table>';
    
        // Return success response
        echo json_encode([
            'icon' => 'success',
            'toplam_genel_stok' => $StokAdiniBul["stock_total_quantity"],
            'html_baslik' => '',
            'html' => $html,
            'tipi' => $StokAdiniBul["unit_title"],
            'stock_id' => $StoktanBul["stock_id"],
            'total_amount' => $StoktanBul["total_amount"], // Include total amount
            'used_amount' => $StoktanBul["used_amount"],   // Include used amount
            'stock_barcode_id' => $StoktanBul["stock_barcode_id"],   // Include used amount
            'data' => 'Bu barkod, <b> "' . $StokAdiniBul["stock_title"] . '"</b> ürününe aittir detayları getirildi.',
        ]);
    }
    public function printStockBarcode()
    {
        if ($this->request->getMethod('true') == 'POST') {

            $stock_barcode_number = $this->request->getPost('barcode_number');

            $stock_item = $this->modelStockBarcode
                            ->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                            ->join('warehouse', 'warehouse.warehouse_id = stock_barcode.warehouse_id')
                            ->join('stock_movement', 'stock_movement.stock_barcode_id = stock_barcode.stock_barcode_id')
                            ->join('unit', 'unit.unit_id = stock.sale_unit_id')
                            ->join('stock_variant_group', 'stock_variant_group.stock_id = stock.stock_id')
                            ->join('variant_property v1', 'v1.variant_property_id = stock_variant_group.variant_1', 'left')
                            ->join('variant_property v2', 'v2.variant_property_id = stock_variant_group.variant_2', 'left')
                            ->join('variant_property v3', 'v3.variant_property_id = stock_variant_group.variant_3', 'left')
                            ->join('variant_property v4', 'v4.variant_property_id = stock_variant_group.variant_4', 'left')
                            ->join('variant_group vg1', 'v1.variant_group_id = vg1.variant_group_id', 'left')
                            ->join('variant_group vg2', 'v2.variant_group_id = vg2.variant_group_id', 'left')
                            ->join('variant_group vg3', 'v3.variant_group_id = vg3.variant_group_id', 'left')
                            ->join('variant_group vg4', 'v4.variant_group_id = vg4.variant_group_id', 'left')
                            ->select('stock.*, stock_barcode.*, warehouse.*, stock_movement.*, unit.*, stock_variant_group.*')
                            ->select('v1.variant_property_title as variant_property_v1, vg1.variant_title as variant_title_v1')
                            ->select('v2.variant_property_title as variant_property_v2, vg2.variant_title as variant_title_v2')
                            ->select('v3.variant_property_title as variant_property_v3, vg3.variant_title as variant_title_v3')
                            ->select('v4.variant_property_title as variant_property_v4, vg4.variant_title as variant_title_v4')
                            ->select('stock_barcode.created_at as barkod_olusturma')
                            ->where('barcode_number', $stock_barcode_number)
                            ->first();
            if (!$stock_item) {
                echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok hareketi bulunamadı.']);
                return;
            }

 

            try {
                $date = new DateTime($stock_item['barkod_olusturma']);
                $formatted_date = $date->format('d-m-Y');
                $warehouse_id = $stock_item['warehouse_id'];
                $supplier_id = $stock_item['supplier_id'];
                $stock_quantity = $stock_item['total_amount'];
                $transaction_note = $stock_item['transaction_note'];
                $warehouse_address = $stock_item['warehouse_address'];

                $barcode_number = $stock_barcode_number;

                $insert_barcode_data = [
                    'stock_id' => $stock_item['stock_id'],
                    'warehouse_id' => $warehouse_id,
                    'supplier_id' => $supplier_id,
                    'warehouse_address' => $warehouse_address,
                    'barcode_number' => $barcode_number,
                    'total_amount' => $stock_quantity,
                    'barkod_olusturma' => $formatted_date
                ];

                if ($supplier_id != 0)
                    $supplier = $this->modelCari->where('cari_id', $supplier_id)->where('user_id', session()->get('user_id'))->first();
                else
                    $supplier = 0;

                $barcode_html = generate_barcode_html($stock_item, $insert_barcode_data, $transaction_note, $supplier);

                echo json_encode(['icon' => 'success', 'message' => 'Barkod başarıyla oluşturuldu.', 'barcode_html' => $barcode_html]);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock_movement',
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

    public function deleteStockMovement()
    {

        $stock_barcode_id = $this->request->getPost('stock_barcode_id');
        $stock_id = $this->request->getPost('stock_id');

        // print_r($stock_barcode_id);
        // print_r($stock_id);
        // return;


        if ($this->request->getMethod('true') == 'POST') {

            try {
                $stock_item = $this->modelStock->where('stock_id', $stock_id)->first();
                $stock_barcode_item = $this->modelStockBarcode->where('stock_barcode_id', $stock_barcode_id)->first();
                $stock_movement_item = $this->modelStockMovement
                    ->join('invoice', 'invoice.invoice_id = stock_movement.invoice_id', 'left')
                    ->where('stock_barcode_id', $stock_barcode_id)
                    ->first();

                // print_r($stock_item);
                // print_r($stock_barcode_item);
                // print_r($stock_movement_item);
                // return;

                $supplier_cari_item = $this->modelCari->where('cari_id', $stock_movement_item['supplier_id'])->first();
                $financial_movement_item = $this->modelFinancialMovement->where('stock_movement_id', $stock_movement_item['stock_movement_id'])->first();

                // print_r($financial_movement_item);
                // return;

                if (!$stock_barcode_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok hareketi bulunamadı.']);
                    return;
                }

                if ($stock_barcode_item['used_amount'] != 0) {
                    echo json_encode(['icon' => 'error', 'message' => 'İşlem yapılmak istenilen stok daha önce bir satışta kullanıldığından silinemez.']);
                    return;
                }

                // if ($stock_movement_item['supplier_id'] != 0) {
                //     $financial_movement_item = $this->modelFinancialMovement->where('stock_movement_id', $stock_movement_item['stock_movement_id'])->first();
                //     $cari_item = $this->modelCari->where('cari_id', $financial_movement_item['cari_id'])->first();

                //     $this->modelStockMovement->delete($stock_movement_item['stock_movement_id']);
                //     $this->modelFinancialMovement->delete($financial_movement_item['financial_movement_id']);

                //     $update_cari_data = [
                //         'cari_balance' => $cari_item['cari_balance'] + $financial_movement_item['transaction_amount']
                //     ];
                //     $this->modelCari->update($cari_item['cari_id'], $update_cari_data);
                // }


                $insert_StockWarehouseQuantity = [
                    'user_id' => 0
                ];
                $warehouse_id = 0;
                if ($stock_movement_item['movement_type'] == 'incoming') {
                    $warehouse_id = $stock_movement_item['to_warehouse'];
                } else {
                    $warehouse_id = $stock_movement_item['from_warehouse'];
                }


                $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $stock_barcode_item['warehouse_id'], $stock_item['stock_id'], $stock_item['parent_id'], $stock_movement_item['transaction_quantity'], 'remove', $this->modelStockWarehouseQuantity, $this->modelStock);


                if ($addStock === 'eksi_stok') {
                    echo json_encode(['icon' => 'error', 'message' => 'bu işlemden sonra stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz.']);
                    return;
                }



                $invoice_items = $this->modelInvoice->where('invoice_id', $stock_movement_item['invoice_id'])->findAll();
                $invoice_row_items = $this->modelInvoiceRow->where('invoice_id', $stock_movement_item['invoice_id'])->findAll();

                $invoice_row_items_count = count($invoice_row_items);

                // print_r($invoice_items);
                // print_r($invoice_row_items);
                // return;


                if ($invoice_row_items_count > 1) {
                    //faturada birden fazla satır var, sadece ilgili row idyi sil
                    foreach ($invoice_row_items as $invoice_row_item) {
                        if ($invoice_row_item['stock_id'] == $stock_item['stock_id']) {

                            $this->modelStockBarcode->delete($stock_barcode_item['stock_barcode_id']);
                            $this->modelStockMovement->delete($stock_movement_item['stock_movement_id']);
                            $this->modelInvoiceRow->delete($invoice_row_item['invoice_row_id']);


                            $amount_to_be_processed = floatval($invoice_row_item['total_price']);
                            $update_cari_data = [
                                'cari_balance' => $supplier_cari_item['cari_balance'] + $amount_to_be_processed
                            ];
                            $this->modelCari->update($supplier_cari_item['cari_id'], $update_cari_data);


                            echo json_encode(['icon' => 'success', 'message' => 'row silindi. Stok harekti başarıyla silindi.', 'route_address' => route_to('tportal.stocks.list', 'all')]);
                            return;
                        }
                    }
                } else {
                    //faturada tek satır var direkt fatura sil

                    $this->modelStockBarcode->delete($stock_barcode_item['stock_barcode_id']);
                    $this->modelStockMovement->delete($stock_movement_item['stock_movement_id']);
                    $this->modelInvoiceRow->delete($invoice_row_items[0]['invoice_row_id']);

                    //stok hareket silinin tedarikçininde cari balance'ı güncellenir
                    $amount_to_be_processed = floatval($stock_movement_item['amount_to_be_paid']);
                    $update_cari_data = [
                        'cari_balance' => $supplier_cari_item['cari_balance'] + $amount_to_be_processed
                    ];
                    $this->modelCari->update($supplier_cari_item['cari_id'], $update_cari_data);
                    
                    $this->modelFinancialMovement->delete($financial_movement_item['financial_movement_id']);
                    $this->modelInvoice->delete($invoice_items[0]['invoice_id']);


                    echo json_encode(['icon' => 'success', 'message' => 'fatura silindi. Stok harekti başarıyla silindi.', 'route_address' => route_to('tportal.stocks.list', 'all')]);
                    return;
                }





            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock',
                    $stock_barcode_id,
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


    //Ürün Reçete İşlemleri
    public function listStockContent($stock_id = null)
    {
        $stock_item = $this->modelStock->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.stock_id', $stock_id)
            ->select('buy_money_unit.money_icon as buy_money_icon, buy_money_unit.money_code as buy_money_code, stock.*, sale_unit.*')
            ->first();

        if (!$stock_item) {
            return view('not-found');
        }

        if ($stock_item['parent_id'] != 0)
            $parentStockId = $stock_item['parent_id'];
        else
            $parentStockId = 0;

        $all_stock_items = $this->modelStock->join('category', 'category.category_id = stock.category_id')
            ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->join('type', 'type.type_id = stock.type_id','left')
            ->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
            ->join('money_unit as sale_money_unit', 'sale_money_unit.money_unit_id = stock.sale_money_unit_id')
            ->select('sale_unit.unit_title as sale_unit_title, sale_unit.unit_value as sale_unit_value, type.type_title, category.category_title')
            ->select('buy_unit.unit_title as buy_unit_title, buy_unit.unit_value as buy_unit_value')
            ->select('buy_money_unit.money_icon as buy_money_icon, buy_money_unit.money_code as buy_money_code, stock.*')
            ->select('sale_money_unit.money_icon as sale_money_icon, sale_money_unit.money_code as sale_money_icon')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.stock_id !=', $stock_id)
            ->where('parent_id', 0)
            ->orderBy('category.category_title', 'ASC')
            ->orderBy('stock.stock_code', 'ASC')
            ->findAll();

        $stock_recipe_items = $this->modelRecipeItem->join('stock_recipe', 'stock_recipe.recipe_id = recipe_item.recipe_id')
            ->join('stock', 'recipe_item.stock_id = stock.stock_id')
            ->join('type', 'stock.type_id = type.type_id','left')
            ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
            ->join('money_unit as sale_money_unit', 'sale_money_unit.money_unit_id = stock.sale_money_unit_id')
            ->select('stock.*, type.type_title, stock_recipe.*, buy_unit.unit_value as buy_unit_value, sale_unit.unit_id as sale_unit_id, buy_money_unit.money_icon as buy_money_icon, sale_money_unit.money_icon as sale_money_icon, buy_money_unit.money_title as buy_money_title, sale_money_unit.money_title as sale_money_title, recipe_item.*')
            ->where('stock_recipe.stock_id', $stock_id)
            ->findAll();

        

        $type_items = $this->modelType->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();
        $recipe_item = $this->modelStockRecipe->join('stock', 'stock.stock_id = stock_recipe.stock_id')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock_recipe.stock_id', $stock_id)->first();
        

        // $stock_item['stock_total_amount'] = $this->sonStokBilgisi($stock_item['stock_id']);
        $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);

        # TODO: Bütün ürünlerin total_costlarını toplayan bir query yazılacak
        ## SUM(recipe_item.total_cost) as all_total_cost
        ### $builder->select('(SELECT SUM(payments.amount) FROM payments WHERE payments.invoice_id=4) AS amount_paid', false);

        $stock_operation = $this->modelStockOperation
        ->join('operation', 'operation.operation_id = stock_operation.operation_id')
        ->where("stock_operation.stock_id", $stock_id)
        ->findAll();
    
    $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
    
    // Tüm operasyon türleri için döngü oluştur
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
            }elseif ($status == "Durdu") {
                $operation_amounts[$operation_id]['islemde'] += $stock_amount;
            }
            elseif ($status == "Devam") {
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
    $stock_items = $this->modelStock->where('user_id', session()->get('user_id'))->findAll();



    $data = [
            'stock_items' => $stock_items,
            'operation_amounts' => $operation_amounts,
            'stock_operation' => $stock_operation,
            'stock_item' => $stock_item,
            'stock_recipe_items' => $stock_recipe_items,
            'recipe_item' => $recipe_item,
            'type_items' => $type_items,
            'all_stock_items' => $all_stock_items,
            'all_total_cost' => 0.00,
            'parentStockId' => $parentStockId,
        ];

        return view('tportal/stoklar/detay/recete', $data);
    }

    public function deleteStockContent()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $recipe_id = $this->request->getPost('recipe_id');
                $recipe_item_id = $this->request->getPost('recipe_item_id');

                $recipe_item = $this->modelRecipeItem->join('stock_recipe', 'stock_recipe.recipe_id = recipe_item.recipe_id')
                    ->join('stock', 'stock.stock_id = stock_recipe.stock_id')
                    ->where('stock.user_id', session()->get('user_id'))
                    ->where('stock_recipe.recipe_id', $recipe_id)
                    ->where('recipe_item.recipe_item_id', $recipe_item_id)
                    ->first();
                if (!$recipe_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen reçete elemanı bulunamadı.']);
                    return;
                }

                $this->modelRecipeItem->delete($recipe_item['recipe_item_id']);

                echo json_encode(['icon' => 'success', 'message' => 'Reçete elemanı başarıyla silindi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'recipe_item',
                    $recipe_item_id,
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

    public function createStockContent()
    {
        if ($this->request->getMethod(true) == 'POST') {
            try {
                $recipe_id = $this->request->getPost('recipe_id');
                $stock_id = $this->request->getPost('stock_id');

                $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $stock_id)->first();
                $recipe = $this->modelStockRecipe->join('stock', 'stock.stock_id = stock_recipe.stock_id')
                    ->where('stock.user_id', session()->get('user_id'))
                    ->where('stock_recipe.recipe_id', $recipe_id)
                    ->first();
                if (!$stock_item || !$recipe) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok elemanı bulunamadı.']);
                    return;
                }

                $recipe_item = $this->modelRecipeItem->where('stock_id', $stock_id)->where('recipe_id', $recipe_id)->first();
                if ($recipe_item) {
                    $this->logClass->save_log(
                        'error',
                        'recipe_item',
                        null,
                        null,
                        'create',
                        'Belirtilen stok reçetede zaten var.',
                        json_encode($_POST)
                    );
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok reçetede zaten var.']);
                    return;
                }

                $used_amount = $this->request->getPost('used_amount');
                $wastage_amount = $this->request->getPost('wastage_amount');

                $used_amount = str_replace('.', '', $used_amount);
                $used_amount = str_replace(',', '.', $used_amount);

                $wastage_amount = str_replace('.', '', $wastage_amount);
                $wastage_amount = str_replace(',', '.', $wastage_amount);

                $unit_price = $stock_item['buy_unit_price'];

                $total_amount = floatval($used_amount) + floatval($wastage_amount);
                $total_cost = $total_amount * $unit_price;

                $insert_data = [
                    'recipe_id' => $recipe_id,
                    'stock_id' => $stock_id,
                    'used_amount' => $used_amount,
                    'wastage_amount' => $wastage_amount,
                    'total_amount' => $total_amount,
                    'total_cost' => $total_cost
                ];

                $this->modelRecipeItem->insert($insert_data);
                echo json_encode(['icon' => 'success', 'message' => 'Reçete elemanı başarıyla eklendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'recipe_item',
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
            return redirect()->back();
        }
    }

    public function editStockContent()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $recipe_id = $this->request->getPost('recipe_id');
            $stock_id = $this->request->getPost('stock_id');

            $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $stock_id)->first();
            if (!$stock_item) {
                echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok bulunamadı.']);
                return;
            }

            $recipe_item = $this->modelRecipeItem->join('stock', 'stock.stock_id = recipe_item.stock_id')
                ->where('recipe_item.recipe_id', $recipe_id)
                ->where('stock.stock_id', $stock_id)
                ->first();
            if ($recipe_item) {
                try {
                    $used_amount = $this->request->getPost('used_amount');
                    $wastage_amount = $this->request->getPost('wastage_amount');

                    $used_amount = str_replace('.', '', $used_amount);
                    $used_amount = str_replace(',', '.', $used_amount);

                    $wastage_amount = str_replace('.', '', $wastage_amount);
                    $wastage_amount = str_replace(',', '.', $wastage_amount);

                    $buy_unit_price = $stock_item['buy_unit_price'];

                    $total_amount = floatval($used_amount) + floatval($wastage_amount);
                    $total_cost = $total_amount * $buy_unit_price;

                    $update_data = [
                        'used_amount' => $used_amount,
                        'wastage_amount' => $wastage_amount,
                        'total_amount' => $total_amount,
                        'total_cost' => $total_cost
                    ];

                    $this->modelRecipeItem->update($recipe_item['recipe_item_id'], $update_data);
                    echo json_encode(['icon' => 'success', 'message' => 'Reçete elemanı başarıyla güncellendi.']);
                    return;
                } catch (\Exception $e) {
                    $this->logClass->save_log(
                        'error',
                        'recipe_item',
                        $recipe_item['recipe_item_id'],
                        null,
                        'edit',
                        $e->getMessage(),
                        json_encode($_POST)
                    );
                    echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                    return;
                }
            } else {
                echo json_encode(['icon' => 'error', 'message' => 'Belirtilen reçete elemanı bulunamadı.']);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    //Alt Ürün İşlemleri
    public function listStockSubstocks($stock_id = null)
    {


     

        $stock_item = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock_id', $stock_id)->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')->first();
        if (!$stock_item) {
            return view('not-found');
        }

        if ($stock_item['parent_id'] != 0)
            $parentStockId = $stock_item['parent_id'];
        else
            $parentStockId = 0;

        $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();

        $stock_item['stock_total_amount'] = $this->sonStokBilgisi($stock_item['stock_id']);


        $data = [
            'stock_item' => $stock_item,
            'money_unit_items' => $money_unit_items,
            'parentStockId' => $parentStockId,
        ];
        // print_r($data['stock_item']);


        if ($stock_item['has_variant'] == 1) {
            $variant_property_items = $this->modelVariantProperty->join('variant_group', 'variant_group.variant_group_id = variant_property.variant_group_id')
                ->join('variant_group_category', 'variant_group_category.variant_group_id = variant_group.variant_group_id')
                ->where('variant_group_category.deleted_at', null)
                ->where('variant_group.deleted_at', null)
                ->where('variant_group_category.category_id', $stock_item['category_id'])
                ->where('variant_group.status', 'active')
                ->where('variant_group.user_id', session()->get('user_id'))
                ->orderBy('variant_group.order')
                ->orderBy('variant_property.order')
                ->findAll();

            $variant_stocks = $this->modelStock->join('stock_variant_group', 'stock_variant_group.stock_id = stock.stock_id')
                ->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
                ->join('money_unit as sale_money_unit', 'sale_money_unit.money_unit_id = stock.sale_money_unit_id')
                ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
                ->select('stock.*, buy_money_unit.money_icon as buy_money_icon, sale_money_unit.money_icon as sale_money_icon')
                ->select('stock_variant_group.*')

                //->where('stock_variant_group.deleted_at', null)
                
                ->where('stock.parent_id', $stock_item['stock_id'])
                ->where('stock.user_id', session()->get('user_id'))
                ->orderBy('stock.stock_code', 'ASC')
                ->findAll();


            $variant_groups = array_column($variant_property_items, 'variant_title', 'variant_column');
            $variant_properties = array_column($variant_property_items, 'variant_property_title', 'variant_property_id');

            $category_item = $this->modelCategory->find($stock_item['category_id']);



            foreach ($variant_stocks as &$variant_stock) {
                $variant_stock['stock_total_amount'] = $this->getStockQuantity($variant_stock['stock_id'], $stock_item);
            }
            $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);


            $data = [
                'stock_item' => $stock_item,
                'money_unit_items' => $money_unit_items,
            ];

                

            $data['variant_stocks'] = $variant_stocks;
            $data['variant_property_items'] = $variant_property_items;
            $data['variant_properties'] = $variant_properties;
            $data['variant_groups'] = $variant_groups;
            $data['category_item'] = $category_item;
            $data['parentStockId'] = $parentStockId;


            
            $stock_operation = $this->modelStockOperation
        ->join('operation', 'operation.operation_id = stock_operation.operation_id')
        ->where("stock_operation.stock_id", $stock_id)
        ->findAll();
    
    $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
    
    // Tüm operasyon türleri için döngü oluştur
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
            }elseif ($status == "Durdu") {
                $operation_amounts[$operation_id]['islemde'] += $stock_amount;
            }
            elseif ($status == "Devam") {
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





            $data['stock_operation'] = $stock_operation;
            $data['operation_amounts'] = $operation_amounts;


   


            return view('tportal/stoklar/detay/varyantlar', $data);
        } else {
            $substock_items = $this->modelStock
                ->join('money_unit','money_unit.money_unit_id=stock.sale_money_unit_id')
                ->join('unit', 'unit.unit_id = stock.sale_unit_id')
                ->where('parent_id', $stock_item['stock_id'])
                ->orderBy('stock_code', 'ASC')
                ->findAll();

            foreach ($substock_items as $substock_item) {
                $substock_item['stock_total_amount'] = $this->sonStokBilgisi($substock_item['stock_id']);
            }

            // print_r($substock_items);
            // return;

                  
            $stock_operation = $this->modelStockOperation
            ->join('operation', 'operation.operation_id = stock_operation.operation_id')
            ->where("stock_operation.stock_id", $stock_id)
            ->findAll();
        
        $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
        
        // Tüm operasyon türleri için döngü oluştur
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
    
    
    
    
    
                $data['stock_operation'] = $stock_operation;
                $data['operation_amounts'] = $operation_amounts;
    
    
       



            $data['substock_items'] = $substock_items;

            return view('tportal/stoklar/detay/alturunler', $data);
        }
    }

    //Alt Ürün İşlemleri - for datatable
    public function listStockSubstocksAll()
    {   

        $category_items = $this->modelCategory->where('user_id', session()->get('user_id'))->findAll();
        $type_items = $this->modelType->where('user_id', session()->get('user_id'))->findAll();

        // print_r($category_items);
        // return;


        $data = [
            'category_items' => $category_items,
            'type_items' => $type_items,
        ];

        return view('tportal/stoklar/substokcs_index', $data);
    }

    //Alt Ürün İşlemleri - for datatable
    public function listStockSubstocksAllDatatable()
    {
        $builder = $this->modelStock
            ->join('stock parent', 'stock.parent_id = parent.stock_id')
            ->join('category ct', 'stock.category_id = ct.category_id')
            ->join('money_unit mu', 'stock.sale_money_unit_id = mu.money_unit_id')
            ->join('type', 'type.type_id = stock.type_id','left')
            ->join('unit', 'unit.unit_id = stock.sale_unit_id')
            ->select('stock.stock_id AS child_id, 
                stock.stock_title AS stock_stock_title,
                stock.stock_code AS child_stock_code,
                parent.stock_title AS parent_stock_title,
                parent.stock_id AS parent_id,
                parent.stock_code AS parent_stock_code,
                stock.default_image,
                ct.category_title AS category,
                type.type_title AS type,
                mu.money_icon AS sale_money_icon,
                stock.sale_unit_price AS unit_price,
                stock.stock_total_quantity,
                unit.unit_title,')
            ->where('stock.deleted_at IS NULL', null, false)
            ->where('stock.user_id', session()->get('user_id'));


        return DataTable::of($builder)->filter(function ($builder, $request) {

            if ($request->category_id)
                $builder->where('stock.category_id', $request->category_id);
            if ($request->type_id)
                $builder->where('stock.type_id', $request->type_id);
        })
            ->setSearchableColumns(['stock.stock_title', 'stock.stock_code', 'stock.stock_barcode'])
            ->toJson(true);
    }

    public function createStockVariantMultiple($stock_id = null)
    {
        $stock_item = $this->modelStock->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')->where('stock.user_id', session()->get('user_id'))->where('stock.stock_id', $stock_id)->first();
        if (!$stock_item) {
            return view('not-found');
        }

        $data = [
            'stock_item' => $stock_item,
        ];
        if ($stock_item['has_variant'] == 1) {
            $variant_property_items = $this->modelVariantProperty->join('variant_group', 'variant_group.variant_group_id = variant_property.variant_group_id')
                ->join('variant_group_category', 'variant_group_category.variant_group_id = variant_group.variant_group_id')
                ->where('variant_group_category.deleted_at', null)
                ->where('variant_group.deleted_at', null)
                ->where('variant_group_category.category_id', $stock_item['category_id'])
                ->where('variant_group.status', 'active')
                ->where('variant_group.user_id', session()->get('user_id'))
                ->select('variant_property.*')
                ->select('variant_group_category.variant_column')
                ->select('variant_group.variant_title')
                ->orderBy('variant_group.order')
                ->orderBy('variant_property.order')
                ->findAll();

            $stock_total_amount = $this->modelStockMovement->select([
                'sm_outer.*',
                'stock_barcode.*',
                '(SELECT SUM(stock_barcode.total_amount)
                      FROM stock_movement sm_inner
                      JOIN stock_barcode ON sm_inner.stock_barcode_id = stock_barcode.stock_barcode_id
                      WHERE sm_inner.transaction_date <= sm_outer.transaction_date
                        AND stock_barcode.stock_id = ' . $stock_item['stock_id'] . '
                        AND stock_barcode.deleted_at is null
                      ORDER BY sm_inner.transaction_date DESC
                    ) AS stock_amount'
            ])
                ->from('stock_movement sm_outer')
                ->join('stock_barcode', 'sm_outer.stock_barcode_id = stock_barcode.stock_barcode_id')
                ->where('stock_barcode.stock_id', $stock_item['stock_id'])
                ->groupBy([
                    'sm_outer.transaction_number',
                    'sm_outer.buy_unit_price',
                    'stock_barcode.total_amount'
                ])
                ->orderBy('sm_outer.transaction_date', 'DESC')
                ->first();

            $data = [
                'variant_property_items' => $variant_property_items,
                'stock_item' => $stock_item,
                'total_amount' => $stock_total_amount
            ];

            return view('tportal/stoklar/detay/varyantlar_toplu', $data);
        } else {
            # Buraya flashdata gelicek
            echo json_encode(['icon' => 'error', 'message' => 'Bu ürün toplu varyant eklemeye uygun değil']);
            return;
        }
    }
 
    public function PriceStockVariantGet($stock_id = null)
    {
        
        if ($this->request->getMethod('true') == 'POST') {

            $stock_ids = $this->request->getPost('stock_ids');
            $updated_prices = $this->request->getPost('updated_prices');

            foreach ($stock_ids as $index => $stock_id) {
              
                $price = str_replace(',', '.', $updated_prices[$index]);

                if(!empty($updated_prices[$index])){
                    $stokGuncelle  = $this->modelStock->set("sale_unit_price", convert_number_for_sql($updated_prices[$index]))->where("stock_id", $stock_id)->update();
                }

               
                

            }
        
            session()->setFlashdata('success', 'Fiyatlar başarıyla güncellendi');

            return redirect()->back();

        }
        
        $stock_item = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock_id', $stock_id)->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')->first();
        if (!$stock_item) {
            return view('not-found');
        }

        if ($stock_item['parent_id'] != 0)
            $parentStockId = $stock_item['parent_id'];
        else
            $parentStockId = 0;

        $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();

        $stock_item['stock_total_amount'] = $this->sonStokBilgisi($stock_item['stock_id']);


        $data = [
            'stock_item' => $stock_item,
            'money_unit_items' => $money_unit_items,
            'parentStockId' => $parentStockId,
        ];
        // print_r($data['stock_item']);


        if ($stock_item['has_variant'] == 1) {
            $variant_property_items = $this->modelVariantProperty->join('variant_group', 'variant_group.variant_group_id = variant_property.variant_group_id')
                ->join('variant_group_category', 'variant_group_category.variant_group_id = variant_group.variant_group_id')
                ->where('variant_group_category.deleted_at', null)
                ->where('variant_group.deleted_at', null)
                ->where('variant_group_category.category_id', $stock_item['category_id'])
                ->where('variant_group.status', 'active')
                ->where('variant_group.user_id', session()->get('user_id'))
                ->orderBy('variant_group.order')
                ->orderBy('variant_property.order')
                ->findAll();

            $variant_stocks = $this->modelStock->join('stock_variant_group', 'stock_variant_group.stock_id = stock.stock_id')
                ->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
                ->join('money_unit as sale_money_unit', 'sale_money_unit.money_unit_id = stock.sale_money_unit_id')
                ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
                ->select('stock.*, buy_money_unit.money_icon as buy_money_icon, sale_money_unit.money_icon as sale_money_icon')
                ->select('stock_variant_group.*')

                //->where('stock_variant_group.deleted_at', null)
                
                ->where('stock.parent_id', $stock_item['stock_id'])
                ->where('stock.user_id', session()->get('user_id'))
                ->orderBy('stock.stock_code', 'ASC')
                ->findAll();


            $variant_groups = array_column($variant_property_items, 'variant_title', 'variant_column');
            $variant_properties = array_column($variant_property_items, 'variant_property_title', 'variant_property_id');

            $category_item = $this->modelCategory->find($stock_item['category_id']);



            foreach ($variant_stocks as &$variant_stock) {
                $variant_stock['stock_total_amount'] = $this->getStockQuantity($variant_stock['stock_id'], $stock_item);
            }
            $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);


            $data = [
                'stock_item' => $stock_item,
                'money_unit_items' => $money_unit_items,
            ];

                

            $data['variant_stocks'] = $variant_stocks;
            $data['variant_property_items'] = $variant_property_items;
            $data['variant_properties'] = $variant_properties;
            $data['variant_groups'] = $variant_groups;
            $data['category_item'] = $category_item;
            $data['parentStockId'] = $parentStockId;


            
            $stock_operation = $this->modelStockOperation
        ->join('operation', 'operation.operation_id = stock_operation.operation_id')
        ->where("stock_operation.stock_id", $stock_id)
        ->findAll();
    
    $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
    
    // Tüm operasyon türleri için döngü oluştur
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
            }elseif ($status == "Durdu") {
                $operation_amounts[$operation_id]['islemde'] += $stock_amount;
            }
            elseif ($status == "Devam") {
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





            $data['stock_operation'] = $stock_operation;
            $data['operation_amounts'] = $operation_amounts;


   


            return view('tportal/stoklar/detay/varyantlar_fiyat', $data);
        } else {
            $substock_items = $this->modelStock
                ->join('money_unit','money_unit.money_unit_id=stock.sale_money_unit_id')
                ->join('unit', 'unit.unit_id = stock.sale_unit_id')
                ->where('parent_id', $stock_item['stock_id'])
                ->orderBy('stock_code', 'ASC')
                ->findAll();

            foreach ($substock_items as $substock_item) {
                $substock_item['stock_total_amount'] = $this->sonStokBilgisi($substock_item['stock_id']);
            }

            // print_r($substock_items);
            // return;

                  
            $stock_operation = $this->modelStockOperation
            ->join('operation', 'operation.operation_id = stock_operation.operation_id')
            ->where("stock_operation.stock_id", $stock_id)
            ->findAll();
        
        $operation_amounts = []; // Operasyon türlerine göre miktarları tutacak dizi
        
        // Tüm operasyon türleri için döngü oluştur
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
    
    
    
    
    
                $data['stock_operation'] = $stock_operation;
                $data['operation_amounts'] = $operation_amounts;
    
    
       



            $data['substock_items'] = $substock_items;

            return view('tportal/stoklar/detay/varyantlar_fiyat', $data);
        }


    }


    public function stockVariantGet(){

        $stock_id = $this->request->getPost("stock_id");
        $title = $this->request->getPost("variant_id");
        
        $stock_item = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock_id', $stock_id)->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')->first();
        if (!$stock_item) {
            return view('not-found');
        }

        if ($stock_item['parent_id'] != 0)
            $parentStockId = $stock_item['parent_id'];
        else
            $parentStockId = 0;

        $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();

        $stock_item['stock_total_amount'] = $this->sonStokBilgisi($stock_item['stock_id']);


        $data = [
            'stock_item' => $stock_item,
            'money_unit_items' => $money_unit_items,
            'parentStockId' => $parentStockId,
        ];
        // print_r($data['stock_item']);


        if ($stock_item['has_variant'] == 1) {
            $variant_property_items = $this->modelVariantProperty->join('variant_group', 'variant_group.variant_group_id = variant_property.variant_group_id')
                ->join('variant_group_category', 'variant_group_category.variant_group_id = variant_group.variant_group_id')
                ->where('variant_group_category.deleted_at', null)
                ->where('variant_group.deleted_at', null)
                ->where('variant_group_category.category_id', $stock_item['category_id'])
                ->where('variant_group.status', 'active')
                ->where('variant_group.user_id', session()->get('user_id'))
                ->orderBy('variant_group.order')
                ->where("variant_group.variant_title", $title)
                ->orderBy('variant_property.order')
                ->findAll();

            $variant_stocks = $this->modelStock->join('stock_variant_group', 'stock_variant_group.stock_id = stock.stock_id')
                ->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
                ->join('money_unit as sale_money_unit', 'sale_money_unit.money_unit_id = stock.sale_money_unit_id')
                ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
                ->select('stock.*, buy_money_unit.money_icon as buy_money_icon, sale_money_unit.money_icon as sale_money_icon')
                ->select('stock_variant_group.*')

                //->where('stock_variant_group.deleted_at', null)
                
                ->where('stock.parent_id', $stock_item['stock_id'])
                ->where('stock.user_id', session()->get('user_id'))
                ->orderBy('stock.stock_code', 'ASC')
                ->findAll();


            $variant_groups = array_column($variant_property_items, 'variant_title', 'variant_column');
            $variant_properties = array_column($variant_property_items, 'variant_property_title', 'variant_property_id');

            $category_item = $this->modelCategory->find($stock_item['category_id']);



            foreach ($variant_stocks as &$variant_stock) {
                $variant_stock['stock_total_amount'] = $this->getStockQuantity($variant_stock['stock_id'], $stock_item);
            }
            $stock_item['stock_total_amount'] = $this->getStockQuantity($stock_item['stock_id'], $stock_item);


            $data = [
                'stock_item' => $stock_item,
                'money_unit_items' => $money_unit_items,
            ];

                

            $data['variant_stocks'] = $variant_stocks;
            $data['variant_property_items'] = $variant_property_items;
            $data['variant_properties'] = $variant_properties;
            $data['variant_groups'] = $variant_groups;
            $data['category_item'] = $category_item;
            $data['parentStockId'] = $parentStockId;


            
            $stock_operation = $this->modelStockOperation
            ->join('operation', 'operation.operation_id = stock_operation.operation_id')
            ->where("stock_operation.stock_id", $stock_id)
            ->findAll();
  
        } else {
            $substock_items = $this->modelStock
                ->join('money_unit','money_unit.money_unit_id=stock.sale_money_unit_id')
                ->join('unit', 'unit.unit_id = stock.sale_unit_id')
                ->where('parent_id', $stock_item['stock_id'])
                ->orderBy('stock_code', 'ASC')
                ->findAll();

            foreach ($substock_items as $substock_item) {
                $substock_item['stock_total_amount'] = $this->sonStokBilgisi($substock_item['stock_id']);
            }

            $data['substock_items'] = $substock_items;

        }


       return $this->stocktable($data["variant_stocks"],$data["variant_groups"],$data["variant_properties"],$stock_id);


    }

    public function stocktable($variant_stocks, $variant_groups, $variant_properties, $stock_id) {
        ?>


<table class="nowrap table  table-hover" style="border:1px solid #dedede">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2; width:120px">Kod
                                                </th>
                                               
                                                <?php
                                                            if(isset($variant_groups)){ 
                                                                  foreach($variant_groups as $variant_column_name => $variant_group_title){
                                                                    echo '
                                                                    <th style="background-color: #ebeef2;">'.$variant_group_title.'</th>
                                                                    ';
                                                                } }
                                                                ?>
                                               
                                                <th style="background-color: #ebeef2;" class="text-end">
                                                    Stok</th>
                                                    <th style="background-color: #ebeef2;" class="text-end">
                                                    B.Fiyat</th>
                                                    <th style="background-color: #ebeef2;" class="text-center">
                                                    Yeni Fiyat</th>
                                                <th style="background-color: #ebeef2;"></th>
                                            </tr>
                                        </thead>
                                        <form method="POST" action="<?= route_to('tportal.stocks.variant_price.multiple', $stock_id) ?>"> 
                                        <tbody id="tableContent">
                                           
                                         


                                               

                                         
                                    

            <?php if (isset($variant_stocks) && !empty($variant_stocks)) { ?>
                <?php foreach ($variant_stocks as $variant_stock) { ?>
                    <tr class="">
                        <td class="text-black">
                            <?= $variant_stock['stock_code'] ?>
                        </td>
                        <?php if (isset($variant_groups)) { ?>
                            <?php foreach ($variant_groups as $variant_column_name => $variant_group_title) { ?>
                                <?php
                                if ($variant_stock['variant_' . $variant_column_name]) {
                                    $ColorBlack = "";
                                    $variant_title = $variant_properties[$variant_stock['variant_' . $variant_column_name]];
                                } else {
                                    $variant_title = '';
                                    $ColorBlack = "ana_varyant";
                                }
                                ?>
                                <td data-property="<?= $variant_title; ?>" class="<?= $ColorBlack; ?>">
                                    <span><?= $variant_title; ?></span>
                                </td>
                            <?php } ?>
                        <?php } ?>
                        <td class="text-end stock">
                            <?= $variant_stock['stock_total_quantity'] != 0 ? number_format($variant_stock['stock_total_quantity'], 2, '.') : 0; ?>
                        </td>
                        <td class="text-end para">
                            <?= number_format($variant_stock['sale_unit_price'], 4, ',', '') . ' ' . $variant_stock['sale_money_icon'] ?>
                        </td>
                        <td class="text-center para" style="">
                            <div class="form-control-wrap" style="width: 60%; text-align: center; margin-left: auto; margin-right: auto;">
                                <div class="form-text-hint">
                                    <span class="overline-title"><em class="icon ni ni-sign-try"></em></span>
                                </div>
                                <input type="text" class="form-control" name="updated_prices[]" placeholder="">
                            </div>
                        </td>
                        <input type="hidden" name="stock_ids[]" value="<?= $variant_stock['stock_id'] ?>">
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5" class="text-black text-center">
                        <b>Ürün Bulunamadı</b>
                    </td>
                </tr>
            <?php } ?>

            </tbody>


</table>
        <?php
        }
        

    public function storeStockVariantMultiple($stock_id = null)
    {
        $stock_item = $this->modelStock->join('category', 'stock.category_id = category.category_id')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.stock_id', $stock_id)
            ->first();
        $failed_variant_data = [];
        if (!$stock_item) {
            echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok bulunamadı.']);
            return;
        }
        try {
            $variant_groups = $this->request->getPost('params');
            foreach (json_decode($variant_groups, true) as $variant_group) {
                foreach ($variant_group['value'] as $variant_item) {
                    $key = '';
                    $value = '';
                    foreach ($variant_item['value'] as $variant_attr) {
                        $key = $variant_attr['name'];
                        $value = $variant_attr['value'];
                        $temp_variant_item[$key] = $value;
                    }
                }
                $variant_mapped_multiple_items[$variant_group['name']][] = $temp_variant_item;
                $temp_variant_item = [];
            }

          

            foreach ($variant_mapped_multiple_items as $mapped_item) {
                $variant_multiple_items[] = $mapped_item;
            }

          

            $title_schema = $stock_item['variant_title_template'];
            $final_list = [];
            $this->temp_schema = $title_schema;
            $this->cacheList = [];
         
            $final_list = $this->processVariantItems($variant_multiple_items, $title_schema, 0, [], $final_list);
         
            # Insert variants as stock
            foreach ($final_list as $variant) {



             
               
              // `variant_property_ids` ve `variant_columns` değerlerini virgülle ayırarak dizilere dönüştürün
               


                $barcode_number = generate_barcode_number();
                $temp_variant_code = $this->getStockCode($stock_item['category_id'], $stock_item['stock_code'] . $variant['variant_property_code']);
                $variant_title = str_replace('[PRODUCT_TITLE] ', $stock_item['stock_title'], $variant['temp_variant_title']);
                $variant_title = str_replace('[PRODUCT_TITLE]', $stock_item['stock_title'], $variant_title);
                if ($temp_variant_code['icon'] == 'success') {
                    $variant_code = $temp_variant_code['value'];
                } elseif ($temp_variant_code['message'] == 'Bu ürün kodu daha önceden kullanılmış.') {
                    $failed_variant_data[] = $variant['variant_property_code'] . ' | ' . $variant_title;
                    continue;
                } else {
                    echo json_encode($temp_variant_code);
                    return;
                }

                $insert_data = [
                    'parent_id' => $stock_item['stock_id'],
                    'user_id' => session()->get('user_id'),
                    'type_id' => $stock_item['type_id'],
                    'category_id' => $stock_item['category_id'],
                    'buy_unit_id' => $stock_item['buy_unit_id'],
                    'sale_unit_id' => $stock_item['sale_unit_id'],
                    'buy_money_unit_id' => $stock_item['buy_money_unit_id'],
                    'sale_money_unit_id' => $stock_item['sale_money_unit_id'],
                    'buy_unit_price' => $stock_item['buy_unit_price'],
                    'buy_unit_price_with_tax' => $stock_item['buy_unit_price_with_tax'],
                    'sale_unit_price' => $stock_item['sale_unit_price'],
                    'sale_unit_price_with_tax' => $stock_item['sale_unit_price_with_tax'],
                    'buy_tax_rate' => $stock_item['buy_tax_rate'],
                    'sale_tax_rate' => $stock_item['sale_tax_rate'],
                    'stock_type' => $stock_item['stock_type'],
                    'stock_title' => $variant_title,
                    'stock_code' => $variant_code,
                    'stock_barcode' => $barcode_number,
                    'supplier_stock_code' => $stock_item['supplier_stock_code'],
                    'default_image' => 'uploads/default.png',
                    'status' => $stock_item['status'],
                    'has_variant' => 0,
                    'stock_tracking' => $stock_item['stock_tracking'],
                    'critical_stock' => $stock_item['critical_stock'],
                    'warehouse_address' => $stock_item['warehouse_address'],
                    'pattern_code' => $stock_item['pattern_code'],
                ];

                $this->modelStock->insert($insert_data);

                $insert_recipe_data = [
                    'stock_id' => $this->modelStock->getInsertID(),
                    'recipe_title' => $variant_title . '_recipe',
                ];
                $this->modelStockRecipe->insert($insert_recipe_data);

                $stock_variant_insert_data = [
                    'stock_id' => $this->modelStock->getInsertID(),
                    'category_id' => $stock_item['category_id']
                ];


            


                $variant_property_ids = explode(",", $variant['variant_property_ids']);
                $variant_columns = explode(",", $variant['variant_columns']);
                
                // İşlemi tek bir döngüde gerçekleştirin
                foreach ($variant_property_ids as $key => $value) {
                    // `variant_columns` dizisindeki değeri anahtar olarak kullanarak veri ekleyin
                    if (isset($variant_columns[$key])) {
                        $stock_variant_insert_data['variant_' . $variant_columns[$key]] = $value;
                    }
                }
                $ekle =   $this->modelStockVariantGroup->insert($stock_variant_insert_data);

           

               
         






                if ($temp_variant_code['category_counter']) {
                    $update_category_data = [
                        'category_counter' => $temp_variant_code['category_counter']
                    ];
                    $this->modelCategory->update($stock_item['category_id'], $update_category_data);
                }
            }
            $response_data = [
                'icon' => 'success',
            ];
            if (count($failed_variant_data) > 0) {
                $response_data['icon'] = 'warning';
                $response_data['message'] = 'Seçilen varyantların bir kısmı oluşturuldu. Aşağıda verilen stok kodları sistemde mevcut olduğu için oluşturulamadı.';
                $response_data['failed_items'] = $failed_variant_data;
            } else {
                $response_data['icon'] = 'success';
                $response_data['message'] = 'Seçilen varyantlar başarıyla oluşturuldu.';
            }
            echo json_encode($response_data);
            return;
        } catch (\Exception $e) {
            $this->logClass->save_log(
                'error',
                'substock',
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

    private function processVariantItems($items, $title_schema, $currentIndex = 0, $currentCombination = [], &$finalList = [])
    {

    
        $totalItems = count($items);

        if ($currentIndex == $totalItems) {
            // Burada kombinasyon üzerinde yapılacak işlemleri gerçekleştirin
            $variant_property_code = implode('', $currentCombination['variant_property_code']);
            $variant_property_ids = implode(',', $currentCombination['variant_property_id']);
            $variant_columns = implode(',', $currentCombination['variant_column']);
            $this->temp_schema = $title_schema;
            foreach ($currentCombination['convert_schema'] as $key => $value) {
                $this->temp_schema = str_replace($key, $value, $this->temp_schema);
            }
            $variant_property_title = $this->temp_schema;


            $result = ['variant_property_code' => $variant_property_code, 'temp_variant_title' => $variant_property_title, 'variant_property_ids' => $variant_property_ids, 'variant_columns' => $variant_columns];
            $finalList[] = $result;

            return;
        }
     


        foreach ($items[$currentIndex] as $variant) {
            $currentCombination['variant_property_code'][] = $variant['variant_property_code'];
            $currentCombination['variant_property_id'][] = $variant['variant_property_id'];
            $currentCombination['variant_column'][] = $variant['variant_column'];


            if (str_contains($this->temp_schema, 'VARIANT_' . $variant['variant_column'])) {
                $this->temp_schema = str_replace('[VARIANT_' . $variant['variant_column'] . ']', $variant['variant_property_title'] . " ", $this->temp_schema);
                $currentCombination['convert_schema']['[VARIANT_' . $variant['variant_column'] . ']'] = $variant['variant_property_title'];
            } else {
                if ($currentIndex != 0 && isset($this->cacheList[$currentIndex - 1])) {
                    $prev_variable = $this->cacheList[$currentIndex - 1];
                } else {
                    $prev_variable = '[PRODUCT_TITLE] ';
                }

                $product_part = $prev_variable . " " . $variant['variant_property_title'];
                $this->cacheList[$currentIndex] = $product_part;
                $currentCombination['convert_schema']['[PRODUCT_TITLE]'] = $product_part;
            }
            $this->processVariantItems($items, $title_schema, $currentIndex + 1, $currentCombination, $finalList);

            array_pop($currentCombination['variant_property_code']);
            array_pop($currentCombination['variant_property_id']);
            array_pop($currentCombination['convert_schema']);
            array_pop($currentCombination['variant_column']);
  
            $this->temp_schema = $title_schema;


            unset($this->cacheList[$currentIndex]);
        }

  

        return $finalList;
    }


    public function createStockSubstock($stock_id = null)
    {
        if ($this->request->getMethod('true') == 'POST') {
            $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $stock_id)->first();
            if (!$stock_item) {
                echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok bulunamadı.']);
                return;
            }
            try {

                $substock_code = $this->request->getPost('substock_code');
                $substock_title = $this->request->getPost('substock_title');
                $substock_barcode = $this->request->getPost('substock_barcode');

                $barcode_number = generate_barcode_number($substock_barcode);
                $temp_substock_code = $this->getStockCode($stock_item['category_id'], $substock_code);
                if ($temp_substock_code['icon'] == 'success') {
                    $substock_code = $temp_substock_code['value'];
                } else {
                    echo json_encode($temp_substock_code);
                    return;
                }

                $insert_data = [
                    'parent_id' => $stock_item['stock_id'],
                    'user_id' => session()->get('user_id'),
                    'type_id' => $stock_item['type_id'],
                    'category_id' => $stock_item['category_id'],
                    'buy_unit_id' => $stock_item['buy_unit_id'],
                    'sale_unit_id' => $stock_item['sale_unit_id'],
                    'buy_money_unit_id' => $stock_item['buy_money_unit_id'],
                    'sale_money_unit_id' => $stock_item['sale_money_unit_id'],
                    'buy_unit_price' => $stock_item['buy_unit_price'],
                    'buy_unit_price_with_tax' => $stock_item['buy_unit_price_with_tax'],
                    'sale_unit_price' => $stock_item['sale_unit_price'],
                    'sale_unit_price_with_tax' => $stock_item['sale_unit_price_with_tax'],
                    'buy_tax_rate' => $stock_item['buy_tax_rate'],
                    'sale_tax_rate' => $stock_item['sale_tax_rate'],
                    'stock_type' => $stock_item['stock_type'],
                    'stock_title' => $substock_title,
                    'stock_code' => $substock_code,
                    'stock_barcode' => $barcode_number,
                    'supplier_stock_code' => $stock_item['supplier_stock_code'],
                    'default_image' => 'uploads/default.png',
                    'status' => $stock_item['status'],
                    'has_variant' => 0,
                    'stock_tracking' => $stock_item['stock_tracking'],
                    'critical_stock' => $stock_item['critical_stock'],
                    'warehouse_address' => $stock_item['warehouse_address'],
                    'pattern_code' => $stock_item['pattern_code'],
                ];

                $this->modelStock->insert($insert_data);

                $insert_recipe_data = [
                    'stock_id' => $this->modelStock->getInsertID(),
                    'recipe_title' => $substock_title . '_recipe',
                ];
                $this->modelStockRecipe->insert($insert_recipe_data);

                if ($temp_substock_code['category_counter']) {
                    $update_category_data = [
                        'category_counter' => $temp_substock_code['category_counter']
                    ];
                    $this->modelCategory->update($stock_item['category_id'], $update_category_data);
                }

                if ($stock_item['stock_type'] == 'service') {
                    $warehouse_item = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('default','true')->first();

                    //stock_barcode eklendi
                    $barcode_number = generate_barcode_number();
                    $insert_barcode_data = [
                        'stock_id' => $this->modelStock->getInsertID(),
                        'warehouse_id' => $warehouse_item['warehouse_id'] ?? 0,
                        'warehouse_address' => $warehouse_item['warehouse_title'] ?? '',
                        'barcode_number' => $barcode_number,
                        'total_amount' => 0,
                        'used_amount' => 0
                    ];
                    $this->modelStockBarcode->insert($insert_barcode_data);
                    $new_insert_stock_barcode_id = $this->modelStockBarcode->getInsertID();
                }

                echo json_encode(['icon' => 'success', 'message' => 'Stok başarıyla oluşturuldu.', 'new_stock_id' => $this->modelStock->getInsertID(), 'new_stock_code' => $substock_code]);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'substock',
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
            return redirect()->back();
        }
    }

    public function deleteStockSubstock()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $stock_id = $this->request->getPost('stock_id');
                $substock_id = $this->request->getPost('substock_id');

                $substock_item = $this->modelSubstock->join('stock', 'stock.stock_id = substock.stock_id')
                    ->where('stock.user_id', session()->get('user_id'))
                    ->where('substock.substock_id', $substock_id)
                    ->where('substock.stock_id', $stock_id)
                    ->first();
                if (!$substock_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok bulunamadı.']);
                    return;
                }

                $this->modelSubstock->delete($substock_item['substock_id']);

                echo json_encode(['icon' => 'success', 'message' => 'Alt Ürün başarıyla silindi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'substock',
                    $substock_id,
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

    public function createStockVariant($stock_id = null)
    {
        if ($this->request->getMethod('true') == 'POST') {
            $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $stock_id)->first();
            if (!$stock_item) {
                echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok bulunamadı.']);
                return;
            }
            try {

                $params = $this->request->getPost('params');
                foreach (json_decode($params, true) as $param) {
                    switch ($param['name']) {
                        case 'variant_code':
                            $variant_code = $stock_item['stock_code'] . $param['value'];
                            break;
                        case 'variant_title':
                            $variant_title = $param['value'];
                            break;
                        case 'variant_barcode':
                            $variant_barcode = $param['value'];
                            break;
                        case 'stock_variant':
                            $stock_variant = $param['value'];
                            break;
                    }
                }

                $barcode_number = generate_barcode_number($variant_barcode);
                $temp_variant_code = $this->getStockCode($stock_item['category_id'], $variant_code);
                if ($temp_variant_code['icon'] == 'success') {
                    $variant_code = $temp_variant_code['value'];
                } else {
                    echo json_encode($temp_variant_code);
                    return;
                }

                $insert_data = [
                    'parent_id' => $stock_item['stock_id'],
                    'user_id' => session()->get('user_id'),
                    'type_id' => $stock_item['type_id'],
                    'category_id' => $stock_item['category_id'],
                    'buy_unit_id' => $stock_item['buy_unit_id'],
                    'sale_unit_id' => $stock_item['sale_unit_id'],
                    'buy_money_unit_id' => $stock_item['buy_money_unit_id'],
                    'sale_money_unit_id' => $stock_item['sale_money_unit_id'],
                    'buy_unit_price' => $stock_item['buy_unit_price'],
                    'buy_unit_price_with_tax' => $stock_item['buy_unit_price_with_tax'],
                    'sale_unit_price' => $stock_item['sale_unit_price'],
                    'sale_unit_price_with_tax' => $stock_item['sale_unit_price_with_tax'],
                    'buy_tax_rate' => $stock_item['buy_tax_rate'],
                    'sale_tax_rate' => $stock_item['sale_tax_rate'],
                    'stock_type' => $stock_item['stock_type'],
                    'stock_title' => $variant_title,
                    'stock_code' => $variant_code,
                    'stock_barcode' => $barcode_number,
                    'supplier_stock_code' => $stock_item['supplier_stock_code'],
                    'default_image' => 'uploads/default.png',
                    'status' => $stock_item['status'],
                    'has_variant' => 0,
                    'stock_tracking' => $stock_item['stock_tracking'],
                    'critical_stock' => $stock_item['critical_stock'],
                    'warehouse_address' => $stock_item['warehouse_address'],
                    'pattern_code' => $stock_item['pattern_code'],
                ];

                $this->modelStock->insert($insert_data);

                $insert_recipe_data = [
                    'stock_id' => $this->modelStock->getInsertID(),
                    'recipe_title' => $variant_title . '_recipe',
                ];
                $this->modelStockRecipe->insert($insert_recipe_data);

                $stock_variant_insert_data = [
                    'stock_id' => $this->modelStock->getInsertID(),
                    'category_id' => $stock_item['category_id']
                ];
                foreach ($stock_variant as $key => $value) {
                    $stock_variant_insert_data['variant_' . $value['name']] = $value['value'];
                }
                $this->modelStockVariantGroup->insert($stock_variant_insert_data);

                if ($temp_variant_code['category_counter']) {
                    $update_category_data = [
                        'category_counter' => $temp_variant_code['category_counter']
                    ];
                    $this->modelCategory->update($stock_item['category_id'], $update_category_data);
                }
                echo json_encode(['icon' => 'success', 'message' => 'Stok başarıyla oluşturuldu.', 'new_stock_id' => $this->modelStock->getInsertID(), 'new_stock_code' => $variant_code]);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'substock',
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
            return redirect()->back();
        }
    }

    public function deleteStockVariant()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $stock_id = $this->request->getPost('stock_id');
                $substock_id = $this->request->getPost('substock_id');

                $substock_item = $this->modelSubstock->join('stock', 'stock.stock_id = substock.stock_id')
                    ->where('stock.user_id', session()->get('user_id'))
                    ->where('substock.substock_id', $substock_id)
                    ->where('substock.stock_id', $stock_id)
                    ->first();
                if (!$substock_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok bulunamadı.']);
                    return;
                }

                $this->modelSubstock->delete($substock_item['substock_id']);

                echo json_encode(['icon' => 'success', 'message' => 'Ürün varyantı başarıyla silindi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'substock',
                    $substock_id,
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

    public function stockBas()
    {
        $stocklar = $this->modelStock->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
        ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
        ->select('stock.*')
        ->select('buy_unit.unit_title as buy_unit_title, buy_unit.unit_value as buy_unit_value')
        ->select('sale_unit.unit_title as unit_title, sale_unit.unit_value as sale_unit_value')
        ->where('stock.user_id', session()->get('user_id'))
        ->where('stock.stock_total_quantity', 0)
        ->findAll();

        foreach($stocklar as $stock)
        {
            $stock_items = $this->modelStock->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->select('stock.*')
            ->select('buy_unit.unit_title as buy_unit_title, buy_unit.unit_value as buy_unit_value')
            ->select('sale_unit.unit_title as unit_title, sale_unit.unit_value as sale_unit_value')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.parent_id', $stock["stock_id"])
            ->findAll();

            foreach($stock_items as $stock_item)
            {
                if($stock_item["stock_total_quantity"] == 0){
                    $stock_id = $stock_item["stock_id"];

                    $all_barcode = array();
                    $user_item_tedarik = session("user_item")["stock_uretim"];
                    $user_item_depo = session("user_item")["depo_uretim"];


                   
                    $buy_unit_price = convert_number_uretim($stock_item["sale_unit_price"]);
                    $warehouse_id = $user_item_depo;
                    $supplier_id =  $user_item_tedarik;

                
                    $stock_quantity = 1000000;
                    $transaction_note = "Hızlı Manuel Stok Girişi";
                    $warehouse_address = "Depo";
                    $buy_money_unit_id = 1;
                    $barcode_number = generate_barcode_number();

                    $insert_barcode_data = [
                        'stock_id' => $stock_item['stock_id'],
                        'warehouse_id' => $warehouse_id,
                        'warehouse_address' => $warehouse_address,
                        'barcode_number' => $barcode_number,
                        'total_amount' => $stock_quantity,
                        'used_amount' => 0
                    ];
                    $this->modelStockBarcode->insert($insert_barcode_data);
                    $stock_barcode_id = $this->modelStockBarcode->getInsertID();

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
                        $amount_to_be_processed = $amount_to_be_processed ?? 0;
                        $update_cari_data = [
                            'cari_balance' => $supplier['cari_balance'] + $amount_to_be_processed
                        ];
                        $this->modelCari->update($supplier['cari_id'], $update_cari_data);

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
                        $invoice_id = 20659;

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
                        'transaction_info' =>  'Manuel Stok',
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
                        $update_modelFinancialMovement_data = [
                            'stock_movement_id' => $stock_movement_id,
                        ];
                        $this->modelFinancialMovement->update($financialMovement_id, $update_modelFinancialMovement_data);
                    }

                    $insert_StockWarehouseQuantity = [
                        'user_id' => session()->get('user_id'),
                        'warehouse_id' => $warehouse_id,
                        'stock_id' => $stock_item['stock_id'],
                        'parent_id' => $stock_item['parent_id'],
                        'stock_quantity' => $stock_quantity,
                    ];

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
                }
            }
        }
    }


    public function createStockOperation($stock_id = null)
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $stock_id)->first();
                if (!$stock_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok elemanı bulunamadı.']);
                    return;
                }

                $operation_id = $this->request->getPost('operation_id');
                $duration = $this->request->getPost('duration');
                //$duration_type = $this->request->getPost('duration_type');
                $duration_type = 'saniye';
                $kisi = $this->request->getPost('kisi');
                $atolye = $this->request->getPost('atolye');
                $makine = $this->request->getPost('makine');
                $setup = $this->request->getPost('setup');
                $relation_order = $this->request->getPost('relation_order');

                $form_data = [
                    'stock_id' => $stock_id,
                    'operation_id' => $operation_id,
                    'duration' => $duration,
                    'duration_type' => $duration_type,
                    'kisi' => $kisi,
                    'atolye' => $atolye,
                    'makine' => $makine,
                    'setup' => $setup,
                    'relation_order' => $relation_order,
                ];

                $this->modelStockOperation->insert($form_data);

                echo json_encode(['icon' => 'success', 'message' => 'Operasyon başarıyla oluşturuldu.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock_operation',
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
            return redirect()->back();
        }
    }

    public function editStockOperation()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $relation_id = $this->request->getPost('relation_id');
                $duration = $this->request->getPost('duration');
                $relation_order = $this->request->getPost('relation_order');

                $stock_operation_item = $this->modelStockOperation->join('stock', 'stock.stock_id = stock_operation.stock_id')
                    ->where('stock.user_id', session()->get('user_id'))
                    ->where('stock_operation.relation_id', $relation_id)
                    ->first();
                if (!$stock_operation_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok operasyonu bulunamadı.']);
                    return;
                }
                $kisi = $this->request->getPost('kisi');
                $atolye = $this->request->getPost('atolye');
                $makine = $this->request->getPost('makine');
                $setup = $this->request->getPost('setup');

                $form_data = [
                    'duration' => $duration,
                    'relation_order' => $relation_order,
                    'kisi' => $kisi,
                    'atolye' => $atolye,
                    'makine' => $makine,
                    'setup' => $setup,
                ];

                $this->modelStockOperation->update($relation_id, $form_data);

                echo json_encode(['icon' => 'success', 'message' => 'Operasyon başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock_operation',
                    $relation_id,
                    null,
                    'edit',
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

    public function uruneslestirmeleri()
    {
        $stocks = $this->modelStock->where("deleted_at", null)->findAll();
        $grouped_stocks = [];
        $orphaned_groups = []; // Ana ürünü olmayan gruplar için
        
        // Stokları grupla
        foreach ($stocks as $stock) {
            $stock_code = $stock['stock_code'];
            $last_six_digits = substr($stock_code, -6);
            
            if (!isset($grouped_stocks[$last_six_digits])) {
                $grouped_stocks[$last_six_digits] = [
                    'main_product' => null,
                    'sub_products' => []
                ];
            }
            
            // Eğer stock_code tam 6 karakterse, bu ana ürün
            if (strlen($stock_code) === 6) {
                $grouped_stocks[$last_six_digits]['main_product'] = $stock;
            } else {
                $grouped_stocks[$last_six_digits]['sub_products'][] = $stock;
            }
        }
        
        // Sadece birden fazla eşleşen grupları filtrele
        $filtered_groups = array_filter($grouped_stocks, function($group) {
            return count($group['sub_products']) > 0 || $group['main_product'] !== null;
        });
    
        // Ana ürünü olmayan grupları ayır
        foreach ($filtered_groups as $last_six => $group) {
            if ($group['main_product'] === null) {
                $orphaned_groups[$last_six] = $group['sub_products'];
                unset($filtered_groups[$last_six]);
            }
        }
    
        // Excel oluştur
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Başlık stillerini tanımla
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
    
        // Ana ürün stili
        $mainProductStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2EFDA']
            ]
        ];
    
        // Alt başlık stili
        $subHeaderStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FF0000']
            ]
        ];
    
        // Başlıkları ayarla
        $sheet->setCellValue('A1', 'Son 6 Hane');
        $sheet->setCellValue('B1', 'Stok Kodu');
        $sheet->setCellValue('C1', 'Ürün Adı');
        $sheet->setCellValue('D1', 'Durum');
        
        // Başlık stillerini uygula
        $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);
        
        $row = 2;
        
        // Ana ürünü olan grupları listele
        foreach ($filtered_groups as $last_six => $group) {
            // Ana ürünü listele
            if ($group['main_product']) {
                $sheet->setCellValue('A' . $row, $last_six);
                $sheet->setCellValue('B' . $row, $group['main_product']['stock_code']);
                $sheet->setCellValue('C' . $row, $group['main_product']['stock_title']);
                $sheet->setCellValue('D' . $row, 'Ana Ürün');
                $sheet->getStyle('A'.$row.':D'.$row)->applyFromArray($mainProductStyle);
                $row++;
            }
            
            // Alt ürünleri listele
            foreach ($group['sub_products'] as $stock) {
                $sheet->setCellValue('A' . $row, $last_six);
                $sheet->setCellValue('B' . $row, $stock['stock_code']);
                $sheet->setCellValue('C' . $row, $stock['stock_title']);
                $sheet->setCellValue('D' . $row, 'Alt Ürün');
                $row++;
            }
            
            // Gruplar arasına boşluk
            $row++;
        }
        
        // Ana ürünü olmayan gruplar için başlık
        if (!empty($orphaned_groups)) {
            $sheet->setCellValue('A' . $row, 'ANA ÜRÜNÜ OLMAYANLAR');
            $sheet->mergeCells('A'.$row.':D'.$row);
            $sheet->getStyle('A'.$row.':D'.$row)->applyFromArray($subHeaderStyle);
            $row++;
            
            foreach ($orphaned_groups as $last_six => $stocks) {
                foreach ($stocks as $stock) {
                    $sheet->setCellValue('A' . $row, $last_six);
                    $sheet->setCellValue('B' . $row, $stock['stock_code']);
                    $sheet->setCellValue('C' . $row, $stock['stock_title']);
                    $sheet->setCellValue('D' . $row, 'Gruplanmamış');
                    $row++;
                }
                $row++; // Gruplar arasına boşluk
            }
        }
        
        // Tüm hücrelere kenarlık ekle
        $lastRow = $row - 1;
        $sheet->getStyle('A1:D'.$lastRow)->getBorders()->getAllBorders()->setBorderStyle(
            \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        );
        
        // Sütun genişliklerini otomatik ayarla
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Excel dosyasını indir
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="stok_eslestirmeleri.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }



    


    public function tekrarlananlar()
    {
        // Önce tekrarlanan stock_code'ları bul
        $tekrarliKodlar = $this->modelStock
            ->select('stock_code, COUNT(*) as tekrar_sayisi')
            ->where('deleted_at', null)
            ->groupBy('stock_code')
            ->having('COUNT(*) >', 1)
            ->findAll();
    
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Stil tanımlamaları
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
            ],
            'alignment' => ['horizontal' => 'center']
        ];
    
        $groupHeaderStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFD700']
            ]
        ];
    
        // Başlıklar
        $sheet->setCellValue('A1', 'Sysmond ID');
        $sheet->setCellValue('B1', 'Stok Kodu');
        $sheet->setCellValue('C1', 'Stok Adı');
        $sheet->setCellValue('D1', 'Stok Barkodu');
        $sheet->setCellValue('E1', 'Oluşturma Tarihi');
        $sheet->setCellValue('F1', 'Son Güncelleme');
        $sheet->setCellValue('G1', 'Tekrar Sayısı');
        
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);
        
        $row = 2;
        
        foreach ($tekrarliKodlar as $kod) {
            // Her tekrarlanan kod için grup başlığı
            $sheet->setCellValue('A' . $row, "TEKRARLANAN KAYITLAR");
            $sheet->setCellValue('B' . $row, "Stok Kodu: " . $kod['stock_code']);
            $sheet->setCellValue('G' . $row, $kod['tekrar_sayisi'] . " Adet");
            $sheet->getStyle('A'.$row.':G'.$row)->applyFromArray($groupHeaderStyle);
            $row++;
    
            // Bu stock_code'a ait tüm kayıtları al
            $ayniKodluKayitlar = $this->modelStock
                ->where('stock_code', $kod['stock_code'])
                ->where('deleted_at', null)
                ->findAll();
            
            // Her kaydı ayrı ayrı listele
            foreach ($ayniKodluKayitlar as $index => $kayit) {
                $sheet->setCellValue('A' . $row, $kayit['stock_id']);
                $sheet->setCellValue('B' . $row, $kayit['stock_code']);
                $sheet->setCellValue('C' . $row, $kayit['stock_title']);
                $sheet->setCellValue('D' . $row, $kayit['stock_barcode']);
                $sheet->setCellValue('E' . $row, $kayit['created_at']);
                $sheet->setCellValue('F' . $row, $kayit['updated_at']);
                
                // Her tekrarlanan kaydı farklı renkle göster
                $rowColor = ($index % 2 == 0) ? 'FFECEC' : 'FFE0E0';
                $sheet->getStyle('A'.$row.':G'.$row)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB($rowColor);
                
                $row++;
            }
            
            // Gruplar arası boşluk
            $row++;
        }
        
        // Tüm hücrelere kenarlık
        $lastRow = $row - 1;
        $sheet->getStyle('A1:G'.$lastRow)->getBorders()->getAllBorders()->setBorderStyle(
            \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        );
        
        // Sütun genişlikleri
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Excel'i indir
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="tekrarlanan_stoklar.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function deleteStockOperation()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $stock_id = $this->request->getPost('stock_id');
                $relation_id = $this->request->getPost('relation_id');

                $stock_operation_item = $this->modelStockOperation->join('stock', 'stock.stock_id = stock_operation.stock_id')
                    ->where('stock.user_id', session()->get('user_id'))
                    ->where('stock_operation.relation_id', $relation_id)
                    ->where('stock_operation.stock_id', $stock_id)
                    ->first();
                if (!$stock_operation_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok operasyonu bulunamadı.']);
                    return;
                }

                $this->modelStockOperation->delete($stock_operation_item['relation_id']);

                echo json_encode(['icon' => 'success', 'message' => 'Operasyon başarıyla silindi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock_operation',
                    $relation_id,
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


    public function stockBasAna()
    {
        $stocklar = $this->modelStock->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
        ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
        ->select('stock.*')
        ->select('buy_unit.unit_title as buy_unit_title, buy_unit.unit_value as buy_unit_value')
        ->select('sale_unit.unit_title as unit_title, sale_unit.unit_value as sale_unit_value')
        ->where('stock.user_id', session()->get('user_id'))
        ->findAll();

        foreach($stocklar as $stock)
        {
            $stock_items = $this->modelStock->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->select('stock.*')
            ->select('buy_unit.unit_title as buy_unit_title, buy_unit.unit_value as buy_unit_value')
            ->select('sale_unit.unit_title as unit_title, sale_unit.unit_value as sale_unit_value')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.stock_id', $stock["stock_id"])
            ->where('stock.type_id', 18)
            ->findAll();

            foreach($stock_items as $stock_item)
            {
                if($stock_item["stock_total_quantity"] < 222500){
                    $stock_id = $stock_item["stock_id"];

                    $all_barcode = array();
                    $user_item_tedarik = session("user_item")["stock_uretim"];
                    $user_item_depo = session("user_item")["depo_uretim"];

                    $buy_unit_price = convert_number_uretim($stock_item["sale_unit_price"]);
                    $warehouse_id = $user_item_depo;
                    $supplier_id =  $user_item_tedarik;
                    $stock_quantity = 15000;
                    $transaction_note = "Hızlı Manuel Stok Girişi";
                    $warehouse_address = "Depo";
                    $buy_money_unit_id = 1;
                    $barcode_number = generate_barcode_number();

                    $insert_barcode_data = [
                        'stock_id' => $stock_item['stock_id'],
                        'warehouse_id' => $warehouse_id,
                        'warehouse_address' => $warehouse_address,
                        'barcode_number' => $barcode_number,
                        'total_amount' => $stock_quantity,
                        'used_amount' => 0
                    ];
                    $this->modelStockBarcode->insert($insert_barcode_data);
                    $stock_barcode_id = $this->modelStockBarcode->getInsertID();

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
                        $invoice_id = 381;

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
                        'transaction_info' =>  'Manuel Stok',
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
                        $update_modelFinancialMovement_data = [
                            'stock_movement_id' => $stock_movement_id,
                        ];
                        $this->modelFinancialMovement->update($financialMovement_id, $update_modelFinancialMovement_data);
                    }

                    $insert_StockWarehouseQuantity = [
                        'user_id' => session()->get('user_id'),
                        'warehouse_id' => $warehouse_id,
                        'stock_id' => $stock_item['stock_id'],
                        'parent_id' => $stock_item['parent_id'],
                        'stock_quantity' => $stock_quantity,
                    ];

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
                }
            }
        }
    }

    function func_excel_import(){
        $upload_status  = $this->uploadDoc();
        if ($upload_status != false) {
            $inputFileName  = 'uploads/'.$upload_status;
            $inputTitleType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
            $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileName);
            $spreadsheet    = $reader->load($inputFileName);
            $sheet          = $spreadsheet->getSheet(0);

            foreach ($sheet->getRowIterator() as $row) 
            {
                $name = $spreadsheet->getActiveSheet()->getCell('A'.$row->getRowIndex());
                echo $name;
            }
        }else{
        }
    }
    
    public function uploadDoc()
    {
        $userDatabaseDetail = [
            'hostname' => session()->get("user_item")["db_host"],
            'username' => session()->get("user_item")["db_username"],
            'password' => session()->get("user_item")["db_password"],
            'database' => session()->get("user_item")["db_name"],
            'DBDriver' => 'MySQLi',
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
    
        // Connect to the user database
        $databaseUser = \Config\Database::connect($userDatabaseDetail);
    
        // Truncate the stock_excel table
        $databaseUser->table('stock_excel')->truncate();
    
        $uploadPath = 'uploads/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE); // Create directory if it doesn't exist
        }
    
        $file_excel = $this->request->getFile('file-2');
        $ext = $file_excel->getClientExtension();
        $filename = $file_excel->getClientName(); // Get the original filename
    
        // Generate a new filename with the current date and time
        $baseFilename = pathinfo($filename, PATHINFO_FILENAME);
        $timestamp = date('Y_m_d-H_i');
        $newFilename = strtolower(str_replace(' ', '_', $baseFilename)) . '_' . $timestamp . '.' . $ext;

    
        // Move the file to the upload directory with the new filename
        $file_excel->move($uploadPath, $newFilename);
    
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else if ($ext == 'xlsx') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
    
        $spreadsheet = $render->load($uploadPath . $newFilename);
    
        $data = $spreadsheet->getActiveSheet()->toArray();
    
        foreach ($data as $x => $row) {
            if ($x != 0) {
                $data_2[] = array(
                    'adi'           => $row[0],
                    'no'            => $row[1],
                    'tip'           => $row[2],
                    'grupkodu'      => $row[3],
                    'ozelkod_1'     => $row[4],
                    'ozelkod_2'     => $row[5],
                    'para'          => $row[6],
                    'depo'          => $row[8],
                    'birim'         => $row[9],
                    'fiyat'         => $row[10],
                    'musteri'       => $row[11],
                    'tedarikci'     => $row[12],
                    'tc'     => $row[13],
                    'excel_dosya'   => $newFilename,
                    'tarih'         => date("Y-m-d H:i")
                );
            }
        }
    
        $rtn = $databaseUser->table('stock_excel')->insertBatch($data_2);
    }


    public function resimler(){

        // Resimleri kaydedeceğiniz dizin yolu
    $saveDir = 'images/uploads/';

    // Dizin yoksa oluşturun
    if (!file_exists($saveDir)) {
        mkdir($saveDir, 0755, true);
    }

    // Veritabanından tüm ürünleri alın
    $ExcelUrunler = $this->modalStockExcel->limit(10)->findAll();


        foreach ($ExcelUrunler as $urun) {
            // Ürünün resim URL'sini alın (tip alanını kullanarak)
            $imageUrl = $urun["tip"];

            // Resim adını URL'den çıkartın
            $imageName = basename($imageUrl);

            // Resmin kaydedileceği tam yol
            $savePath = $saveDir . $imageName;

            // Resmi indirip kaydetme işlemi
            try {
                // Resmi indirin
                $imageContent = file_get_contents($imageUrl);

                // Resmi belirlenen yola kaydedin
                file_put_contents($savePath, $imageContent);

                // Dosyanın gerçekten indirildiğini kontrol edin
                if (file_exists($savePath)) {
                    // Resmin tam yolunu veritabanına kaydetme
                    $this->modelStock->set('default_image', $savePath)->where("stock_code", $urun["adi"])->update();

                    echo "Resim indirildi ve kaydedildi: " . $imageName . '<br>';
                } else {
                    echo "Resim kaydedilemedi: " . $imageUrl . '<br>';
                }
                        } catch (Exception $e) {
                echo "Resim indirilemedi: " . $imageUrl . " Hata: " . $e->getMessage() . '<br>';
            }
        }
        // Her chunk işleminden sonra bir süre bekleyin (isteğe bağlı)
        // usleep(500000); // 500 milisaniye bekleyin
    

    }
    



    public function excelStock()
    {
        $insert_data = [];

/*
  if ($this->request->getMethod(true) == 'POST') {

    $ExcelUrunler = $this->modalStockExcel->findAll();

    foreach($ExcelUrunler as $excel) {
        // Güncellenen mevcut kaydı çekin
        $currentStock = $this->modelStock->where("stock_code", $excel["no"])->first();

        if ($currentStock) {
            // Log current stock details
            error_log("Current Stock: " . json_encode($currentStock));

            // Eğer barkod aynıysa, güncellemeyi atla
            if ($currentStock['stock_barcode'] === $excel["tip"]) {
                error_log("Barkod aynı, güncellemeyi atla: " . $excel["tip"]);
                continue;
            }

            // Barkod değişiyorsa, yeni barkodun benzersiz olup olmadığını kontrol edin
            $existingEntry = $this->modelStock->where("stock_barcode", $excel["tip"])->first();
            
            // Log existing entry details
            if ($existingEntry) {
                error_log("Barkod zaten mevcut: " . json_encode($existingEntry));
                continue;
            }

            // Barkod benzersizse, güncelleme işlemini yap
            try {
                $this->modelStock->set("stock_barcode", $excel["tip"])->where("stock_code", $excel["no"])->update();
                error_log("Barkod güncellendi: " . $excel["tip"]);
            } catch (Exception $e) {
                error_log("Güncelleme hatası: " . $e->getMessage() . " Barkod: " . $excel["tip"]);
            }
        } else {
            error_log("Mevcut stok bulunamadı: " . $excel["no"]);
        }
    }
}
 */
        
        

       if ($this->request->getMethod(true) == 'POST') { // Corrected the 'true' parameter
            try {
                $ExcelUrunler = $this->modalStockExcel->findAll();

                $success = false; // Flag to check if any stock is created

                foreach ($ExcelUrunler as $Excel) {
                    $Stoklar = $this->modelStock->where("stock_title", $Excel["adi"])->where("stock_code", $Excel["no"])->first();

                    if (!$Stoklar || empty($Stoklar)) {
                       
                        $stock_type = "product";
                        $has_variant = 0;
                        $tip = $Excel["tip"];
                        $StokTipi = $this->modelType->where("type_title", $tip)->first();
                        $type_id = $StokTipi ? $StokTipi["type_id"] : 1;

                        $fiyati = ($Excel["fiyat"] == "Yanlış") ? 0 : $Excel["fiyat"];
                        $category_id = 9; // Kategorisiz
                        $stock_barcode = $this->request->getPost('stock_barcode');
                        $stock_code = $Excel["no"];
                        $stock_title = $Excel["adi"];
                        $supplier_stock_code = $Excel["tedarikci"]; // Fixed double $

                        $paraTipi = $this->modelMoneyUnit->where("money_code", $Excel["para"])->first();
                        $para_type = $paraTipi ? $paraTipi["money_unit_id"] : 1;

                        $birimi = ($Excel["birim"] == "KG") ? "kg" : $Excel["birim"];
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

                        $ManuelStok = $Excel["excel_dosya"] . " - " . $Excel["tarih"];



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
                       
                } else {
                        


             
                      
                    }
                }

                if ($success) {
                    echo json_encode(['icon' => 'success', 'message' => 'Stok başarıyla oluşturuldu.']);
                } else {
                    echo json_encode(['icon' => 'error', 'message' => 'Stok Oluşturulamadı.']);
                }
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
            }
        } 
    }


    


    
    public function getStockRecipes()
    {
        if ($this->request->isAJAX()) {
            $stock_id = $this->request->getPost('stock_id');
            
            if (!$stock_id) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Ürün ID bulunamadı',
                    'recipe_items' => []
                ]);
            }
    
            $stock_recipe_items = $this->modelRecipeItem
                ->join('stock_recipe', 'stock_recipe.recipe_id = recipe_item.recipe_id')
                ->join('stock', 'recipe_item.stock_id = stock.stock_id')
                ->join('type', 'stock.type_id = type.type_id','left')
                ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
                ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
                ->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
                ->join('money_unit as sale_money_unit', 'sale_money_unit.money_unit_id = stock.sale_money_unit_id')
                ->select('stock.*, type.type_title, stock_recipe.*, buy_unit.unit_value as buy_unit_value, sale_unit.unit_id as sale_unit_id, buy_money_unit.money_icon as buy_money_icon, sale_money_unit.money_icon as sale_money_icon, buy_money_unit.money_title as buy_money_title, sale_money_unit.money_title as sale_money_title, recipe_item.*')
                ->where('stock_recipe.stock_id', $stock_id)
                ->findAll();
    
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Reçete elemanları başarıyla getirildi',
                'recipe_items' => $stock_recipe_items
            ]);
        }
    
        return $this->response->setJSON([
            'status' => false,
            'message' => 'Geçersiz istek',
            'recipe_items' => []
        ]);
    }


    public function copyStockRecipe($target_stock_id)
    {
        if ($this->request->isAJAX()) {
            $source_stock_id = $this->request->getPost('source_stock_id');
    
            if (!$source_stock_id || !$target_stock_id) {
                return $this->response->setJSON([
                    'icon' => 'error',
                    'message' => 'Kaynak veya hedef ürün seçilmedi!'
                ]);
            }
    
            // Kaynak reçeteyi bul
            $source_recipe = $this->modelStockRecipe->where('stock_id', $source_stock_id)->first();
            if (!$source_recipe) {
                return $this->response->setJSON([
                    'icon' => 'error',
                    'message' => 'Kaynak ürüne ait reçete bulunamadı!'
                ]);
            }
    
            // Hedef üründe reçete var mı kontrol et
            $target_recipe = $this->modelStockRecipe->where('stock_id', $target_stock_id)->first();

    
            // Yeni reçete oluştur
            $new_recipe_id = $target_recipe['recipe_id'];
    
            // Kaynak reçetenin elemanlarını al
            $source_recipe_items = $this->modelRecipeItem->where('recipe_id', $source_recipe['recipe_id'])->findAll();
    
            foreach ($source_recipe_items as $item) {
                $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $item['stock_id'])->first();
                if (!$stock_item) continue;
            
                // Doğrudan float'a çevir
                $used_amount = floatval($item['used_amount']);
                $wastage_amount = floatval($item['wastage_amount']);
                $total_amount = $used_amount + $wastage_amount;
                $unit_price = floatval($stock_item['buy_unit_price']);
                $total_cost = $total_amount * $unit_price;
            
                $insert_data = [
                    'recipe_id' => $new_recipe_id,
                    'stock_id' => $item['stock_id'],
                    'used_amount' => $used_amount,
                    'wastage_amount' => $wastage_amount,
                    'total_amount' => $total_amount,
                    'total_cost' => $total_cost
                ];
            
                $this->modelRecipeItem->insert($insert_data);
            }
    
            return $this->response->setJSON([
                'icon' => 'success',
                'message' => 'Reçeteler başarıyla kopyalandı!'
            ]);
        }
    
        return $this->response->setJSON([
            'icon' => 'error',
            'message' => 'Geçersiz istek!'
        ]);
    }



    public function getStockOperations()
{
    if ($this->request->isAJAX()) {
        $stock_id = $this->request->getPost('stock_id');
        
        if (!$stock_id) {
        return $this->response->setJSON([
                'status' => false,
                'message' => 'Ürün ID bulunamadı',
                'operations' => []
            ]);
        }

        $operations = $this->modelStockOperation
            ->join('operation', 'operation.operation_id = stock_operation.operation_id')
            ->select('
                stock_operation.relation_id,
                stock_operation.relation_order,
                stock_operation.duration,
                stock_operation.kisi,
                stock_operation.atolye,
                stock_operation.makine,
                stock_operation.setup,
                operation.operation_title
            ')
            ->where('stock_operation.stock_id', $stock_id)
            ->orderBy('stock_operation.relation_order', 'ASC')
            ->findAll();

        foreach($operations as &$stock_operation_item){
           
                $kisi_resource = $this->modelOperationResource->where('id', $stock_operation_item['kisi'])->first();
                $stock_operation_item['kisi'] = $kisi_resource ? $kisi_resource['name'] : null;
                $stock_operation_item['kisi_id'] = $kisi_resource ? $kisi_resource['id'] : null;
            
                $atolye_resource = $this->modelOperationResource->where('id', $stock_operation_item['atolye'])->first();
                $stock_operation_item['atolye'] = $atolye_resource ? $atolye_resource['name'] : null;
                $stock_operation_item['atolye_id'] = $atolye_resource ? $atolye_resource['id'] : null;
            
                $makine_resource = $this->modelOperationResource->where('id', $stock_operation_item['makine'])->first();
                $stock_operation_item['makine'] = $makine_resource ? $makine_resource['name'] : null;
                $stock_operation_item['makine_id'] = $makine_resource ? $makine_resource['id'] : null;
            
                $setup_resource = $this->modelOperationResource->where('id', $stock_operation_item['setup'])->first();
                $stock_operation_item['setup'] = $setup_resource ? $setup_resource['name'] : null;
                $stock_operation_item['setup_id'] = $setup_resource ? $setup_resource['id'] : null;
  
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Operasyonlar başarıyla getirildi',
            'operations' => $operations
        ]);
    }

    return $this->response->setJSON([
        'status' => false,
        'message' => 'Geçersiz istek',
        'operations' => []
    ]);
}


public function copyStockOperation($target_stock_id = null)
{
    if ($this->request->isAJAX()) {
        $source_stock_id = $this->request->getPost('source_stock_id');

        if (!$source_stock_id || !$target_stock_id) {
            return $this->response->setJSON([
                'icon' => 'error',
                'message' => 'Gerekli parametreler eksik'
            ]);
        }

        // Kaynak üründeki tüm operasyonları al
        $sourceOperations = $this->modelStockOperation
            ->join('operation', 'operation.operation_id = stock_operation.operation_id')
            ->select('
                stock_operation.*,
                operation.operation_title
            ')
            ->where('stock_operation.stock_id', $source_stock_id)
            ->orderBy('stock_operation.relation_order', 'ASC')
            ->findAll();

        if (empty($sourceOperations)) {
            return $this->response->setJSON([
                'icon' => 'error',
                'message' => 'Kopyalanacak operasyon bulunamadı'
            ]);
        }

        // Her bir operasyonu yeni ürüne kopyala
        $db = db_connect();
        $db->transStart();

        try {
            foreach ($sourceOperations as $operation) {




                $newOperation = [
                    'stock_id' => $target_stock_id,
                    'operation_id' => $operation['operation_id'],
                    'relation_order' => $operation['relation_order'],
                    'duration' => $operation['duration'],
                    'kisi' => $operation['kisi'],
                    'atolye' => $operation['atolye'],
                    'makine' => $operation['makine'],
                    'setup' => $operation['setup'],
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $this->modelStockOperation->insert($newOperation);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON([
                    'icon' => 'error',
                    'message' => 'Operasyonlar kopyalanırken bir hata oluştu'
                ]);
            }

            return $this->response->setJSON([
                'icon' => 'success',
                'message' => 'Operasyonlar başarıyla kopyalandı'
            ]);

        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'icon' => 'error',
                'message' => 'İşlem sırasında bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }

    return $this->response->setJSON([
        'icon' => 'error',
        'message' => 'Geçersiz istek'
    ]);
}


  

}

