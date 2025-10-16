<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoERP\StockRecipeModel;
use App\Models\TikoERP\RecipeItemModel;
use CodeIgniter\I18n\Time;
class Home extends BaseController
{
    private $TikoERPModelPath = 'App\Models\TikoERP';
    private $DatabaseConfig;
    private $currentDB;
    private $db_con;
    private $stok_sayim;
    private $logClass;
    private $temp_schema;
    private $cacheList;
    
    // Model değişkenleri
    private $modelInvoice;
    private $modelInvoiceRow;
    private $modelStock;
    private $modelOperation;
    private $modelProduction;
    private $modelProductionRow;
    private $modelProductionOperation;
    private $modelProductionOperationRow;
    private $modelProductionOperationRowModel;
    private $modelEmirler;
    private $modelBox;
    private $modelBoxRow;
    private $modelCategory;
    private $modelOrderRow;
    private $modelStockRecipe;
    private $modelRecipeItem;
    private $modelOperationUser;
    private $modelCari;
    private $modelSubstock;
    private $modelType;
    private $modelUnit;
    private $modelStockOperation;
    private $modelStockGallery;
    private $modelMoneyUnit;
    private $modelWarehouse;
    private $modelVariantGroup;
    private $modelVariantProperty;
    private $modelStockVariantGroup;
    private $modelStockMovement;
    private $modelStockBarcode;
    private $modelFinancialMovement;
    private $modelStockWarehouseQuantity;
    private $modelStockPackage;
    private $modalStockExcel;
    private $modelStockBarkodlar;
    private $modelOperationResource;
    private $modelSysmondBarkodlar;
    private $modelMaliyetLogs;
    private $InvoiceOutgoingStatusModel;


    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();
        $db_connection = \Config\Database::connect($this->currentDB);
        $this->db_con = $db_connection;
        $this->stok_sayim = session()->get("user_item")["stock_user"] ?? 0;
        $this->logClass = new Log();

        // Model başlatma
        $this->modelInvoice = model($TikoERPModelPath . '\InvoiceModel', true, $db_connection);
        $this->modelInvoiceRow = model($TikoERPModelPath . '\InvoiceRowModel', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath . '\StockModel', true, $db_connection);
        $this->modelOperation = model($TikoERPModelPath . '\OperationModel', true, $db_connection);
        $this->modelProduction = model($TikoERPModelPath . '\ProductionModel', true, $db_connection);
        $this->modelProductionRow = model($TikoERPModelPath . '\ProductionRowModel', true, $db_connection);
        $this->modelProductionOperation = model($TikoERPModelPath . '\ProductionOperationModel', true, $db_connection);
        $this->modelProductionOperationRow = model($TikoERPModelPath . '\ProductionOperationRowModel', true, $db_connection);
        $this->modelProductionOperationRowModel = model($TikoERPModelPath . '\ProductionOperationRowModel', true, $db_connection);
        $this->modelEmirler = model($TikoERPModelPath . '\SevkEmirleri', true, $db_connection);
        $this->modelBox = model($TikoERPModelPath . '\BoxModel', true, $db_connection);
        $this->modelBoxRow = model($TikoERPModelPath . '\BoxRowModel', true, $db_connection);
        $this->modelCategory = model($TikoERPModelPath . '\CategoryModel', true, $db_connection);
        $this->modelOrderRow = model($TikoERPModelPath . '\OrderRowModel', true, $db_connection);
        $this->modelStockRecipe = model($TikoERPModelPath . '\StockRecipeModel', true, $db_connection);
        $this->modelRecipeItem = model($TikoERPModelPath . '\RecipeItemModel', true, $db_connection);
        $this->modelOperationUser = model($TikoERPModelPath . '\OperationUser', true, $db_connection);
        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
        $this->modelSubstock = model($TikoERPModelPath . '\SubstockModel', true, $db_connection);
        $this->modelType = model($TikoERPModelPath . '\TypeModel', true, $db_connection);
        $this->modelUnit = model($TikoERPModelPath . '\UnitModel', true, $db_connection);
        $this->modelStockOperation = model($TikoERPModelPath . '\StockOperationModel', true, $db_connection);
        $this->modelStockGallery = model($TikoERPModelPath . '\StockGalleryModel', true, $db_connection);
        $this->modelMoneyUnit = model($TikoERPModelPath . '\MoneyUnitModel', true, $db_connection);
        $this->modelWarehouse = model($TikoERPModelPath . '\WarehouseModel', true, $db_connection);
        $this->modelVariantGroup = model($TikoERPModelPath . '\VariantGroupModel', true, $db_connection);
        $this->modelVariantProperty = model($TikoERPModelPath . '\VariantPropertyModel', true, $db_connection);
        $this->modelStockVariantGroup = model($TikoERPModelPath . '\StockVariantGroupModel', true, $db_connection);
        $this->modelStockMovement = model($TikoERPModelPath . '\StockMovementModel', true, $db_connection);
        $this->modelStockBarcode = model($TikoERPModelPath . '\StockBarcodeModel', true, $db_connection);
        $this->modelFinancialMovement = model($TikoERPModelPath . '\FinancialMovementModel', true, $db_connection);
        $this->modelStockWarehouseQuantity = model($TikoERPModelPath . '\StockWarehouseQuantityModel', true, $db_connection);
        $this->modelStockPackage = model($TikoERPModelPath . '\StockPackageyModel', true, $db_connection);
        $this->modalStockExcel = model($TikoERPModelPath . '\StockExcelModel', true, $db_connection);
        $this->modelStockBarkodlar = model($TikoERPModelPath . '\SysmondBarkodlar', true, $db_connection);
        $this->modelOperationResource = model($TikoERPModelPath . '\OperationResource', true, $db_connection);
        $this->modelSysmondBarkodlar = model($TikoERPModelPath . '\SysmondBarkodlar', true, $db_connection);
        $this->modelMaliyetLogs = model($TikoERPModelPath . '\MaliyetLogsModel', true, $db_connection);
        $this->InvoiceOutgoingStatusModel = model($TikoERPModelPath . '\InvoiceOutgoingStatusModel', true, $db_connection);

        // Helper'ları yükle
        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
        helper('Helpers\stock_func_helper');
    }

    // public function index(): string
    // {
    //     return view('welcome_message');
    // }

    public function index()
    {
        
        
            $selectArrayOutGoing = $this->addInvoiceStatusToQuery();

            $sql2 = "SELECT * FROM invoice
            JOIN money_unit ON money_unit.money_unit_id = invoice.money_unit_id
            LEFT JOIN invoice_serial ON invoice_serial.invoice_serial_id = invoice.invoice_serial_id
            LEFT JOIN invoice_incoming_status iis ON iis.invoice_incoming_status_id = invoice.invoice_status_id
            LEFT JOIN invoice_outgoing_status ios ON ios.invoice_outgoing_status_id = invoice.invoice_status_id
            WHERE
             invoice.user_id = ? 
            AND 
            invoice.cari_id != ? 
            AND 
             invoice.cari_id != 15199
            AND invoice_direction = 'outgoing_invoice'
            AND DATE(invoice.invoice_date) = ?
            AND invoice.deleted_at IS NULL
            ORDER BY invoice.invoice_date DESC
            LIMIT 100";
            
            $outgoing_items = $this->db_con->query($sql2, [ session()->get('user_id'), session()->get("user_item")["stock_user"] ?? 0, date('Y-m-d')])->getResultArray();
            

            $sql = "SELECT * FROM invoice
            JOIN money_unit ON money_unit.money_unit_id = invoice.money_unit_id
            LEFT JOIN invoice_serial ON invoice_serial.invoice_serial_id = invoice.invoice_serial_id
            LEFT JOIN invoice_incoming_status iis ON iis.invoice_incoming_status_id = invoice.invoice_status_id
            LEFT JOIN invoice_outgoing_status ios ON ios.invoice_outgoing_status_id = invoice.invoice_status_id
            WHERE 
            invoice.user_id = ?
            AND 
            invoice.cari_id != ? 
            AND 
             invoice.cari_id != 15199
            AND invoice_direction = 'incoming_invoice'
            AND DATE(invoice.invoice_date) = ?
            AND invoice.deleted_at IS NULL
            ORDER BY invoice.invoice_date DESC
            LIMIT 100";
            
            $incoming_items = $this->db_con->query($sql, [ session()->get('user_id'), session()->get("user_item")["stock_user"] ?? 0, date('Y-m-d')])->getResultArray();

        // $outgoing_items = $invoice_items;
        // // $incoming_items = $modelInvoice->where('invoice_direction', 'incoming_invoice')->findAll(5);
        // $incoming_items = $invoice_items->where('invoice_direction', 'incoming_invoice')->findAll(1);

 
  

        if (session("user_item")["operation"]) {


      
                $operasyonlar = $this->modelOperation->where("operation_id", session("user_item")["operation"])->first();

                $beklemede_operasyonlar = $this->modelProductionOperation
                                               ->select('production_row_operation.*, stock.default_image, stock.parent_id')
                                               ->join("stock", "stock.stock_id = production_row_operation.stock_id")
                                               ->where("production_row_operation.status", "Beklemede")
                                               ->where("production_row_operation.operation_id", session("user_item")["operation"])
                                               ->findAll();
                                               foreach($beklemede_operasyonlar as &$beklemede) {
                                                if($beklemede["default_image"] == "uploads/default.png") {
                                                    $stoklar = $this->modelStock->where("stock_id", $beklemede["parent_id"])->first();
                                                    if($beklemede["default_image"] != "uploads/default.png")
                                                             $beklemede["default_image"] = $stoklar["default_image"];
                                                }
                                            }
    
    
                  $islemde_operasyonlar = $this->modelProductionOperation
                                               ->select('production_row_operation.*, stock.default_image, stock.parent_id')
                                               ->join("stock", "stock.stock_id = production_row_operation.stock_id")
                                               ->where("production_row_operation.status", "İşlemde")
                                               ->orWhere("production_row_operation.status", "Durdu")
                                               ->orWhere("production_row_operation.status", "Devam")
                                               ->where("production_row_operation.operation_id", session("user_item")["operation"])
                                               ->findAll();
                                           
                                             
                      
                                           foreach($islemde_operasyonlar as &$islemde) {
                                            
                                               if($islemde["default_image"] == "uploads/default.png") {
                                                   $stoklar = $this->modelStock->where("stock_id", $islemde["parent_id"])->first();
                                                   if($islemde["default_image"] != "uploads/default.png"){
                                                    $islemde["default_image"] = $stoklar["default_image"];
                                                   }
                                                       
                                                }
                                                    $satirlar = $this->modelProductionOperationRow
                                                                     ->where("operation_id", session("user_item")["operation"])
                                                                     ->where("stock_id", $islemde["stock_id"])
                                                                     ->where("production_number", $islemde["production_number"])
                                                                     ->where("status", "Durdu")
                                                                     ->first();
                                                        if($satirlar){
                                                            $islemde["islemler"] = $satirlar["islem"];
                                                        }else{
                                                            $islemde["islemler"] = '';
                                                        }
                                                           
    
    
                                                        
                                               
                                           }
                               
                                      
                                     
                                           
           
                $bitti_operasyonlar = $this->modelProductionOperation
                                                ->select('production_row_operation.*, stock.default_image, stock.parent_id')
                                                ->join("stock", "stock.stock_id = production_row_operation.stock_id")
                                                ->where("production_row_operation.status", "Bitti")
                                                ->where("production_row_operation.operation_id", session("user_item")["operation"])
                                                ->findAll();
    
                                                foreach($bitti_operasyonlar as &$bitti) {
                                                    if($bitti["default_image"] == "uploads/default.png") {
                                                        $stoklar = $this->modelStock->where("stock_id", $bitti["parent_id"])->first();
                                                        if($bitti["default_image"] != "uploads/default.png")
                                                        $bitti["default_image"] = $stoklar["default_image"];
                                                    }
                                                }
    
    
    
    
                $beklemede_count = $this->modelProductionOperation->where("status", "Beklemede")->where("operation_id", session("user_item")["operation"])->countAllResults();
                $islemde_count = $this->modelProductionOperation->where("status", "İşlemde")->where("operation_id", session("user_item")["operation"])->orWhere("status", "Durdu")->orWhere("status", "Devam")->countAllResults();
    
                $bitti_count = $this->modelProductionOperation->where("status", "Bitti")->where("operation_id", session("user_item")["operation"])->countAllResults();
                
                $sevkler = $this->modelEmirler->orderBy("sevk_id", "DESC")->findAll();
                $kutular = $this->modelBox->findAll();
                foreach($kutular as $index => $satirlar){
                    $kutular[$index]["satirlar"] = $this->modelBoxRow->where("kutu_id", $satirlar["id"])->findAll();
                }
                $order_satirlar = $this->modelOrderRow->where("kutu_id !=", NULL)->findAll();


                $Kategoriler = $this->modelCategory->where("category_id", 115)->first();
                $kategori_urunleri = $this->modelStock->where("category_id", 115)->findAll();

                foreach($kategori_urunleri as &$urun){
                    $urun["stok_koli"] =  $this->modelRecipeItem->join('stock_recipe', 'stock_recipe.recipe_id = recipe_item.recipe_id')
                    ->join('stock', 'recipe_item.stock_id = stock.stock_id')
                    ->join('type', 'stock.type_id = type.type_id','left')
                    ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
                    ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
                    ->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
                    ->join('money_unit as sale_money_unit', 'sale_money_unit.money_unit_id = stock.sale_money_unit_id')
                    ->select('stock.*, type.type_title, stock_recipe.*, buy_unit.unit_value as buy_unit_value, sale_unit.unit_id as sale_unit_id, buy_money_unit.money_icon as buy_money_icon, sale_money_unit.money_icon as sale_money_icon, buy_money_unit.money_title as buy_money_title, sale_money_unit.money_title as sale_money_title, recipe_item.*')
                    ->where('stock_recipe.stock_id', $urun["stock_id"])
                    ->findAll();
                    foreach($urun["stok_koli"] as &$recete){
                        $recete["koli_recete"] = $this->modelRecipeItem->join('stock_recipe', 'stock_recipe.recipe_id = recipe_item.recipe_id')
                        ->join('stock', 'recipe_item.stock_id = stock.stock_id')
                        ->join('type', 'stock.type_id = type.type_id','left')
                        ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
                        ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
                        ->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
                        ->join('money_unit as sale_money_unit', 'sale_money_unit.money_unit_id = stock.sale_money_unit_id')
                        ->select('stock.*, type.type_title, stock_recipe.*, buy_unit.unit_value as buy_unit_value, sale_unit.unit_id as sale_unit_id, buy_money_unit.money_icon as buy_money_icon, sale_money_unit.money_icon as sale_money_icon, buy_money_unit.money_title as buy_money_title, sale_money_unit.money_title as sale_money_title, recipe_item.*')
                        ->where('stock_recipe.stock_id', $recete["stock_id"])
                        ->findAll();
                    }
                }

              
              


    
                $data = [
                    'kategori_urunleri' => $kategori_urunleri,
                    'kategoriler' => $Kategoriler,
                    'beklemede_operasyonlar' => $beklemede_operasyonlar,
                    'beklemede_count' => $beklemede_count,
                    'islemde_operasyonlar' => $islemde_operasyonlar,
                    'islemde_count' => $islemde_count,
                    'bitti_operasyonlar' => $bitti_operasyonlar,
                    'bitti_count' => $bitti_count,
                    'sevkler' => $sevkler,
                    'kutular' => $kutular,
                    'order_satirlar' => $order_satirlar,
                    'outgoing_invoices' => $outgoing_items,
                    'incoming_invoices' => $incoming_items,
                    'operation' => session("user_item")["operation"],
                    'operation_title' => $operasyonlar["operation_title"]
    
                ];
    
                return view('tportal/operation', $data);
            



         
        } else {

            $data = [
                'outgoing_invoices' => $outgoing_items,
                'incoming_invoices' => $incoming_items,
                'selectArrayOutGoing' => $selectArrayOutGoing
            ];

            return view('tportal/index', $data);
        }



    }


    public function kutular()
    {

        $kutular = $this->modelBox->where("aktif", 1)->findAll();
        foreach($kutular as $index => $satirlar){
            $kutular[$index]["satirlar"] = $this->modelBoxRow->where("kutu_id", $satirlar["id"])->orderBy("paket", "DESC")->findAll();
        }
    
        ob_start();
        foreach($kutular as $kutu): 
        ?>    
    
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card" data-kutu-id="<?php echo $kutu["kutu_id"]; ?>" data-is-empty="true">
                    <div class="card-header border-bottom" style="display: flex; align-items: center; justify-content: space-between;" id="kutu_baslik_<?php echo $kutu["kutu_id"]; ?>"><span></span>
                    <div class="yazdir text-center">
                                        <div class="text-center p-3">
                                        <button id="kutuyuBosalt" class="btn btn-lg btn-danger btn-block"
                                         >KUTUYU BOŞALT <em style="margin-top:-5px" class="icon ni ni-trash"></em></button>
                                        </div>
                                    </div>
                </div>
                    <div class="card-inner" style="padding:0;">
                        <?php if(isset($kutu["satirlar"]) && $kutu["is_empty"] == 0){ ?>
    
                            <div class="col-md-12 mb-3">
                                <div class="card kutu_genel_<?php echo $kutu["kutu_id"];  ?>">
                                    <div class="card-header border-bottom">
                                        <h7>Platform: <b><?php echo $kutu["platform"]; ?></b> - Sipariş No: <b><?php echo $kutu["order_no"]; ?></b></h7>
                                        <span class="badge text-info">Sevk Emri</span>
                                    </div>
                                    <?php
                                    $i = 0;
                                    $paketVarmi = 0;
                                    $okutulan_adet = 0;
                                    $toplam_adet = 0;
                                    $order_id_manuel = 0;
                                    $saydir = count($kutu["satirlar"]);
                                    foreach($kutu["satirlar"] as $rows){
                                        if($rows["paket"] == 1){
                                            $paketVarmi++;
                                        }

                                        $toplam_adet = $toplam_adet + $rows["adet"];
                                        $okutulan_adet = $okutulan_adet + $rows["okutulan_adet"];
                                        $order_id_manuel = $rows["order_id"];
                                    } ?> 
                                    
                                    <input type="hidden" id="order_id_manuel" name="order_id_manuel" value="<?php echo $order_id_manuel; ?>">
                                    <input type="hidden" id="kalan_adet" name="kalan_adet" value="<?php echo ($toplam_adet - $okutulan_adet); ?>">
                                    
                                    
                                    <?php 
                                    foreach($kutu["satirlar"] as $rows){
                                        if($rows["okundu"] == 0){
                                            $i++;
                                        }



                                      

                                 


                                        
                                        $modelImage = $this->modelStock->where("stock_id", $rows["stock_id"])->first(); 

                                        $orderRow = $this->modelOrderRow->where("stock_id", $rows["stock_id"])->first();

                                        
                                        


                                    ?>
                                    <div class="card-body stock_id_<?php echo $modelImage["stock_id"]; ?>" style="padding-top:0; padding-bottom:0;">
                                        <div class="row mb-2 stock_id_<?php echo $modelImage["stock_id"]; ?>" style="<?php $count = 0; if($paketVarmi == 1 && $rows["paket"] != 1){  echo "margin-left:100px;";  }           ?><?php if($rows["okundu"] == 0 ){ echo 'padding-top:13px; padding-bottom:13px; border-bottom: 1px solid #dddddd7a;      background: lightgrey;';}else{ echo 'border: 1px solid #ddebfe; padding-top:13px; padding-bottom:13px;'; } ?> display: flex; align-items: center;">
                                            <div class="col-md-2">
                                            <a class="gallery-image" data-image-title="<?php echo $modelImage["stock_title"]; ?>"  data-image-url="https://app.tikoportal.com.tr/<?php echo $modelImage["default_image"]; ?>">
                <img style="min-height:175px;" src="https://app.tikoportal.com.tr/<?php echo $modelImage["default_image"]; ?>" alt="1"  class="img-fluid">
            </a>
                                            </div>
                                            <div class="col-md-10">
                                                <ul class="list-unstyled">


                                                <?php if($rows["paket"] == 1): ?>
                                                    <li>
                                                        <span class="badge bg-danger text-white"><?php echo ($toplam_adet - $okutulan_adet); ?> Adet Daha Okutunuz</span>
                                                    </li>
                                                        
                                                <?php endif;  ?>

                                                <?php if($rows['stock_amount'] > 1 && ($rows['stock_amount'] - $rows['okutulan_adet'] != 0)){ ?>
                                                            <li>
                                                        <span class="badge bg-danger text-white" style="text-transform:uppercase"><?php echo ($rows['stock_amount'] - $rows['okutulan_adet']); ?> Adet Daha Okutunuz</span>
                                                    </li>
                                                            <?php }else{ ?>
                                                <?php if($rows["okundu"] == 1 ){ ?>
                                                    <?php if($rows["paket"] != 1): ?>
                                                    <li>
                                                        <span class="badge bg-info text-white">OKUTULDU</span>
                                                    </li>
                                                      <?php endif;  ?>
                                                    <?php }else{ ?> 
                                                        <li>
                                                        <span class="badge bg-danger text-white">BEKLİYOR</span>
                                                    </li>
                                                        <?php } } ?>

                                                       

                                                      

                                                    <li><strong>Tarih:</strong> <?php echo $rows["order_date"]; ?></li>
                                                    <li><strong>Ürün Adı:</strong> <?php echo $rows["stock_title"]; ?> </li>
                                                    <li><strong>Ürün Kodu:</strong> <?php echo $modelImage["stock_code"]; ?> </li>

                                                    <li><strong>Adet:</strong> <?php echo number_format($rows['stock_amount'], 2, ',', '.'); ?></li>
                                                    <?php if($rows['stock_amount'] > 1): ?>
                                                    <li style="font-weight:bold"><strong>Okutulan Adet:</strong> <?php echo number_format($rows['okutulan_adet'], 2, ',', '.'); ?></li>
                                                    <?php  endif; ?> 

                                                 


                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }  ?>
                                    <div class="yazdir text-center">
                                    <div class="text-center p-3">
                                        <button id="kutuyuBosalt"  class="btn btn-lg btn-danger btn-block"
                                         >KUTUYU BOŞALT <em style="margin-top:-5px" class="icon ni ni-trash"></em></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal structure -->

                        <?php } ?>
                        <p class="card-text kutu_icerik_<?php echo $kutu["kutu_id"]; ?>"></p>
                    </div>
                </div>
            </div>
            <script>
                $("#kutuyuBosalt").click(function(){
                    Swal.fire({
                    title: 'Kutuyu Boşaltmak İstiyormusunuz?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Evet, Boşalt',
                    cancelButtonText: 'Hayır, Devam Et',
                    }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                        },
                        type: 'POST',
                        url: '<?= route_to('tportal.uretim.kutuyuBosalt') ?>',
                        dataType: 'json',
                        data: {
                            id: 1,
                        },
                        async: true,
                        success: function (response) {
                            if (response['icon'] == 'success') {
                                $("#order_id_manuel").val('');
                                Swal.fire({
                                    title: 'Devam',
                                    icon: 'success',
                                    html: 'Kutu Başarıyla Temizlendi',
                                    showCancelButton: false,
                                    confirmButtonText: 'Kapat',
                                });      
                                
                                setTimeout(() => {
                                  kutular();
                                  }, 100);
                                
                            } else {

                            
                               
                                Swal.fire({
                                    title: 'Hata!',
                                    html: "Bir Hata Oluştu Site Yönetimi İle İletişime Geçiniz",
                                    icon: 'warning',
                                    confirmButtonText: 'Tamam',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                });

                                return false;
                            }
                        }
                     })
                        
                    }
                  });
                 });
            </script>
        <?php endforeach;
    
        $htmlOutput = ob_get_clean();
        echo $htmlOutput;
    }
    


    public function getAllConfig()
    {
        $oldDb = $this->setOldDb();
        $newDb = $this->setNewDb();
        $oldConnection = \Config\Database::connect($oldDb);
        $newConnection = \Config\Database::connect($newDb);

        $modelCategory = model($this->TikoERPModelPath . '\CategoryModel', false, $oldConnection);
        $category_items = $modelCategory->withDeleted()->findAll();
        $modelCategory = model($this->TikoERPModelPath . '\CategoryModel', false, $newConnection);
        $modelCategory->insertBatch($category_items);

        $modelType = model($this->TikoERPModelPath . '\TypeModel', false, $oldConnection);
        $type_items = $modelType->withDeleted()->findAll();
        $modelType = model($this->TikoERPModelPath . '\TypeModel', false, $newConnection);
        $modelType->insertBatch($type_items);

        $modelUnit = model($this->TikoERPModelPath . '\UnitModel', false, $oldConnection);
        $unit_items = $modelUnit->withDeleted()->findAll();
        $modelUnit = model($this->TikoERPModelPath . '\UnitModel', false, $newConnection);
        $modelUnit->insertBatch($unit_items);

        $modelOperation = model($this->TikoERPModelPath . '\OperationModel', false, $oldConnection);
        $operation_items = $modelOperation->withDeleted()->findAll();
        $modelOperation = model($this->TikoERPModelPath . '\OperationModel', false, $newConnection);
        $modelOperation->insertBatch($operation_items);

        $modelMoneyUnit = model($this->TikoERPModelPath . '\MoneyUnitModel', false, $oldConnection);
        $money_unit_items = $modelMoneyUnit->withDeleted()->findAll();
        $modelMoneyUnit = model($this->TikoERPModelPath . '\MoneyUnitModel', false, $newConnection);
        $modelMoneyUnit->insertBatch($money_unit_items);

    }

    public function getAllStock()
    {
        $oldDb = $this->setOldDb();
        $newDb = $this->setNewDb();
        $oldConnection = \Config\Database::connect($oldDb);
        $newConnection = \Config\Database::connect($newDb);

        $modelStock = model($this->TikoERPModelPath . '\StockModel', false, $oldConnection);
        $stock_items = $modelStock->withDeleted()->findAll();
        $modelStock = model($this->TikoERPModelPath . '\StockModel', false, $newConnection);
        foreach ($stock_items as $stock_item) {
            $default_image = str_replace('https://famserp.tikopanel.com/', '', $stock_item['default_image']);
            $insert_data = [
                'stock_id' => $stock_item['stock_id'],
                'parent_id' => 0,
                'user_id' => 1,
                'type_id' => $stock_item['type_id'],
                'category_id' => $stock_item['category_id'],
                'buy_unit_id' => $stock_item['unit_id'],
                'sale_unit_id' => $stock_item['unit_id'],
                'buy_money_unit_id' => $stock_item['money_unit_id'],
                'sale_money_unit_id' => $stock_item['money_unit_id'],
                'buy_unit_price' => $stock_item['unit_price'],
                'buy_unit_price_with_tax' => $stock_item['unit_price_with_tax'],
                'sale_unit_price' => $stock_item['unit_price'],
                'sale_unit_price_with_tax' => $stock_item['unit_price_with_tax'],
                'buy_tax_rate' => 20,
                'sale_tax_rate' => 20,
                'stock_type' => $stock_item['stock_type'],
                'stock_title' => $stock_item['stock_title'],
                'stock_code' => $stock_item['stock_code'],
                'stock_barcode' => null,
                'supplier_stock_code' => $stock_item['supplier_stock_code'],
                'default_image' => $default_image,
                'status' => $stock_item['status'],
                'has_variant' => 0,
                'stock_tracking' => 1,
                'pattern_code' => $stock_item['pattern_code'],
                'warehouse_address' => $stock_item['warehouse_address'],
                'critical_stock' => $stock_item['critical_stock'],
                'deleted_at' => $stock_item['deleted_at'],
                'created_at' => $stock_item['created_at'],
                'updated_at' => $stock_item['updated_at'],
            ];
            $modelStock->insert($insert_data);
        }
    }

    public function getStockRecipe()
    {
        $oldDb = $this->setOldDb();
        $newDb = $this->setNewDb();
        $oldConnection = \Config\Database::connect($oldDb);
        $newConnection = \Config\Database::connect($newDb);

        $modelStockRecipe = model($this->TikoERPModelPath . '\StockRecipeModel', false, $oldConnection);
        $stock_recipe_items = $modelStockRecipe->withDeleted()->findAll();
        $modelStockRecipe = model($this->TikoERPModelPath . '\StockRecipeModel', false, $newConnection);
        $modelStockRecipe->insertBatch($stock_recipe_items);

        $modelRecipeItem = model($this->TikoERPModelPath . '\RecipeItemModel', false, $oldConnection);
        $recipe_items = $modelRecipeItem->withDeleted()->findAll();
        $modelRecipeItem = model($this->TikoERPModelPath . '\RecipeItemModel', false, $newConnection);
        $modelRecipeItem->insertBatch($recipe_items);
    }

    public function getStockGallery()
    {
        $oldDb = $this->setOldDb();
        $newDb = $this->setNewDb();
        $oldConnection = \Config\Database::connect($oldDb);
        $newConnection = \Config\Database::connect($newDb);

        $modelStockGallery = model($this->TikoERPModelPath . '\StockGalleryModel', false, $oldConnection);
        $stock_gallery_items = $modelStockGallery->withDeleted()->findAll();
        $modelStockGallery = model($this->TikoERPModelPath . '\StockGalleryModel', false, $newConnection);
        foreach ($stock_gallery_items as $item) {
            $image_path = str_replace('https://famserp.tikopanel.com/', '', $item['image_path']);
            $insert_data = [
                'gallery_item_id' => $item['gallery_item_id'],
                'stock_id' => $item['stock_id'],
                'image_title' => $item['image_title'],
                'status' => $item['status'],
                'order' => $item['order'],
                'default' => $item['default'],
                'image_path' => $image_path,
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
                'deleted_at' => $item['deleted_at'],
            ];
            $modelStockGallery->insert($insert_data);
        }
    }

    public function getStockOperation()
    {
        $oldDb = $this->setOldDb();
        $newDb = $this->setNewDb();
        $oldConnection = \Config\Database::connect($oldDb);
        $newConnection = \Config\Database::connect($newDb);

        $modelStockOperation = model($this->TikoERPModelPath . '\StockOperationModel', false, $oldConnection);
        $operation_items = $modelStockOperation->withDeleted()->findAll();
        $modelStockOperation = model($this->TikoERPModelPath . '\StockOperationModel', false, $newConnection);
        $modelStockOperation->insertBatch($operation_items);
    }

    private function setOldDb()
    {
        $currentDB = Config('Database')->dynamicDB;

        $currentDB['hostname'] = '78.135.107.25';
        $currentDB['username'] = 'tikopanel_famserp_user';
        $currentDB['password'] = 'XeveqnjFP5eStwHFuh3N';
        $currentDB['database'] = 'tikopanel_famserp_db';
        return $currentDB;
    }

    private function setNewDb()
    {
        $currentDB = Config('Database')->dynamicDB;

        $currentDB['hostname'] = '85.117.239.191';
        $currentDB['username'] = 'tikoportal_fams_user';
        $currentDB['password'] = 'WQFT89JYixwr';
        $currentDB['database'] = 'tikoportal_fams_db';
        return $currentDB;
    }

    private function addInvoiceStatusToQuery()
    {
       
        return $this->InvoiceOutgoingStatusModel->findAll();
    }


    public function paletSatisControl()
    {
        $palet_id = $this->request->getPost('palet_id');
        $stokBul = $this->modelStock->where('stock_id', $palet_id)->first();
        if($stokBul){
            
            $stock_item = $this->modelStock->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.stock_id', $palet_id)
            ->select('buy_money_unit.money_icon as buy_money_icon, buy_money_unit.money_code as buy_money_code, stock.*, sale_unit.*')
            ->first();

        if (!$stock_item) {
            return view('not-found');
        }

        // Gereksiz değişkenler kaldırıldı

        // Paletin reçetesini getir (koli bilgileri)
        $palet_recipe_items = $this->getRecipeItems($palet_id);
        
        // Stok analizi için gerekli değişkenler
        $stok_analizi = [];
        $maksimum_koli = PHP_INT_MAX;
        $toplam_urun_sayisi = 0;
        $eksik_urunler = [];
        $yeterli_urunler = [];
        
        // Her koli için kategori_id 113 kontrolü yap ve stok analizi
        foreach ($palet_recipe_items as &$koli_item) {
            if ($koli_item['category_id'] == 113) {
                // Bu kolinin de reçetesi var, onu da getir
                $koli_item['koli_reçetesi'] = $this->getRecipeItems($koli_item['stock_id']);
                
                // Koli içindeki ürün sayısı
                $koli_icindeki_urun_sayisi = count($koli_item['koli_reçetesi']);
                $toplam_urun_sayisi += $koli_icindeki_urun_sayisi;
                
                // Her ürün için stok kontrolü
                foreach ($koli_item['koli_reçetesi'] as $urun) {
                    $urun_id = $urun['stock_id'];
                    $urun_adi = $urun['stock_title'];
                    $koli_icindeki_miktar = floatval($urun['used_amount']);
                    $palet_istegi = floatval($koli_item['used_amount']);
                    
                    // Gerekli toplam miktar
                    $gerekli_miktar = $palet_istegi * $koli_icindeki_miktar;
                    
                    // Mevcut stok - ürün ID'sini gönder
                    $mevcut_stok = $this->getStockQuantity($urun_id);
                    
                    // Oluşturulabilir koli sayısı (palet isteği ile sınırla)
                    $olusturulabilir_koli = min($palet_istegi, floor($mevcut_stok / $koli_icindeki_miktar));
                    
                    // Maksimum koli sayısını güncelle
                    $maksimum_koli = min($maksimum_koli, $olusturulabilir_koli);
                    
                    // Ürün detayları
                    $urun_detay = [
                        'urun_id' => $urun_id,
                        'urun_adi' => $urun_adi,
                        'koli_icindeki_miktar' => $koli_icindeki_miktar,
                        'palet_istegi' => $palet_istegi,
                        'gerekli_miktar' => $gerekli_miktar,
                        'mevcut_stok' => $mevcut_stok,
                        'eksik_miktar' => max(0, $gerekli_miktar - $mevcut_stok),
                        'olusturulabilir_koli' => $olusturulabilir_koli,
                        'durum' => $mevcut_stok >= $gerekli_miktar ? 'YETERLI' : 'EKSİK'
                    ];
                    
                    $stok_analizi[] = $urun_detay;
                    
                    // Eksik ve yeterli ürünleri ayır
                    if ($mevcut_stok < $gerekli_miktar) {
                        $eksik_urunler[] = $urun_detay;
                    } else {
                        $yeterli_urunler[] = $urun_detay;
                    }
                }
            }
        }

        
        // Genel durum belirleme
        $genel_durum = 'YETERLI';
        if (count($eksik_urunler) > 0) {
            $genel_durum = $maksimum_koli > 0 ? 'KISMEN_YETERLI' : 'YETERSIZ';
        }
        
        // Çıkarılacak stok listesi
        $cikarilacak_stok = [];
        foreach ($stok_analizi as $urun) {
            $cikarilacak_stok[] = [
                'urun_id' => $urun['urun_id'],
                'urun_adi' => $urun['urun_adi'],
                'cikarilacak_miktar' => $maksimum_koli * $urun['koli_icindeki_miktar']
            ];
        }

        // JSON response döndür - Detaylı stok analizi
        return $this->response->setJSON([
            'icon' => 'success',
            'title' => 'Stok Analizi Tamamlandı',
            'text' => 'Palet stok kontrolü başarıyla yapıldı',
            'data' => [
                'palet_bilgisi' => [
                    'stock_id' => $stock_item['stock_id'],
                    'stock_title' => $stock_item['stock_title'],
                    'stock_code' => $stock_item['stock_code'],
                    'istenen_koli' => !empty($palet_recipe_items) ? intval($palet_recipe_items[0]['used_amount']) : 0,
                    'toplam_urun_sayisi' => $toplam_urun_sayisi
                ],
                'stok_analizi' => [
                    'maksimum_olusturulabilir_koli' => $maksimum_koli,
                    'genel_durum' => $genel_durum,
                    'yeterli_urun_sayisi' => count($yeterli_urunler),
                    'eksik_urun_sayisi' => count($eksik_urunler),
                    'urun_detaylari' => $stok_analizi
                ],
                'eksik_urunler' => $eksik_urunler,
                'yeterli_urunler' => $yeterli_urunler,
                'cikarilacak_stok' => [
                    'toplam_koli' => $maksimum_koli,
                    'urun_listesi' => $cikarilacak_stok
                ],
                'palet_reçetesi' => $palet_recipe_items
            ]
        ]);

        }else{
            return $this->response->setJSON(['icon' => 'error', 'title' => 'Hata', 'text' => 'Palet bulunamadı']);
        }
    }

    /**
     * Reçete elemanlarını getir
     */
    private function getRecipeItems($stock_id)
    {
        return $this->modelRecipeItem
            ->join('stock_recipe', 'stock_recipe.recipe_id = recipe_item.recipe_id')
            ->join('stock', 'recipe_item.stock_id = stock.stock_id')
            ->join('type', 'stock.type_id = type.type_id', 'left')
            ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
            ->join('money_unit as sale_money_unit', 'sale_money_unit.money_unit_id = stock.sale_money_unit_id')
            ->select('stock.*, type.type_title, stock_recipe.*, buy_unit.unit_value as buy_unit_value, sale_unit.unit_id as sale_unit_id, buy_money_unit.money_icon as buy_money_icon, sale_money_unit.money_icon as sale_money_icon, buy_money_unit.money_title as buy_money_title, sale_money_unit.money_title as sale_money_title, recipe_item.*')
            ->where('stock_recipe.stock_id', $stock_id)
            ->findAll();
    }

    public function getStockQuantity($stockId)
    {
        // Stock tablosundan direkt stock_total_quantity alanını al
        $stock = $this->modelStock->select('stock_total_quantity')->find($stockId);
        return $stock ? floatval($stock['stock_total_quantity']) : 0;
    }



    public function printEtiket()
    {
        $palet_id = $this->request->getPost('palet_id');
        $koli_sayisi = $this->request->getPost('koli_sayisi');
        
        // Palet bilgilerini al (cari bilgileri ile birlikte)
        $palet_bilgisi = $this->modelStock->join('money_unit as buy_money_unit', 'buy_money_unit.money_unit_id = stock.buy_money_unit_id')
            ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
            ->join('cari', 'cari.cari_id = stock.cari_id')
            ->where('stock.user_id', session()->get('user_id'))
            ->where('stock.stock_id', $palet_id)
            ->select('buy_money_unit.money_icon as buy_money_icon, buy_money_unit.money_code as buy_money_code, stock.*, sale_unit.*, cari.name, cari.surname, cari.invoice_title')
            ->first();

        if (!$palet_bilgisi) {
            return $this->response->setJSON(['icon' => 'error', 'title' => 'Hata', 'text' => 'Palet bulunamadı']);
        }

        // Cari adını belirle
        $cari_adi = '';
        if (!empty($palet_bilgisi['name']) && !empty($palet_bilgisi['surname'])) {
            $cari_adi = trim($palet_bilgisi['name'] . ' ' . $palet_bilgisi['surname']);
        } elseif (!empty($palet_bilgisi['invoice_title'])) {
            $cari_adi = $palet_bilgisi['invoice_title'];
        } else {
            $cari_adi = 'KELEŞOĞLU GRUP'; // Varsayılan
        }

        // Paletin reçetesini getir (koli bilgileri)
        $palet_recipe_items = $this->getRecipeItems($palet_id);
        
        // Her koli için kategori_id 113 kontrolü yap ve reçetelerini al
        foreach ($palet_recipe_items as &$koli_item) {
            if ($koli_item['category_id'] == 113) {
                // Bu kolinin de reçetesi var, onu da getir
                $koli_item['koli_reçetesi'] = $this->getRecipeItems($koli_item['stock_id']);
            }
        }

        // Çıkarılacak stok hesaplama
        $cikarilacak_stok = [];
        foreach ($palet_recipe_items as $koli_item) {
            if ($koli_item['category_id'] == 113 && isset($koli_item['koli_reçetesi'])) {
                foreach ($koli_item['koli_reçetesi'] as $urun) {
                    $cikarilacak_stok[] = [
                        'urun_id' => $urun['stock_id'],
                        'urun_adi' => $urun['stock_title'],
                        'cikarilacak_miktar' => $koli_sayisi * $urun['used_amount']
                    ];
                }
            }
        }

        // Barkod oluştur
        $barcode_svg = $this->generate_barcode($palet_id);
        
        // Etiket verilerini hazırla
        $etiket_data = [
            'palet_bilgisi' => $palet_bilgisi,
            'cari_adi' => $cari_adi,
            'koli_sayisi' => $koli_sayisi,
            'palet_recipe_items' => $palet_recipe_items,
            'cikarilacak_stok' => $cikarilacak_stok,
            'barcode_svg' => $barcode_svg,
            'yazdirma_tarihi' => date('Y-m-d H:i:s'),
            'kullanici_id' => session()->get('user_id')
        ];

        // FATURA KESME İŞLEMİ BAŞLANGIÇ VE STOK DÜŞÜMÜ
        
        // Palet için satış faturası oluştur
        $user_item_tedarik = $palet_bilgisi['cari_id'] ?? 0; // Add null check
        $user_item_depo = 1;
        $warehouse_id = $user_item_depo;
        $supplier_id = $user_item_tedarik;
        $buy_money_unit_id = 1;
        $currency_amount = 1;
        
        // Palet numarası için transaction note
        $transaction_note = "P" . $palet_id . " - Palet Etiket Yazdırma Sonrası Otomatik Stoktan Çıkış";
        
        // Cari bilgilerini al
        $supplier = $this->modelCari->join('address', 'cari.cari_id = address.cari_id', 'left')
            ->where('cari.cari_id', $supplier_id)
            ->where('cari.user_id', session()->get('user_id'))
            ->first();


        // Cari varsa satış faturası oluştur
        $financialMovement_id = 0;
        $invoice_id = 0;
        
        if ($supplier_id != 0 && $supplier) {
            $stock_entry_prefix = "PALET";
            
            // Toplam tutarı hesapla (tüm ürünler için)
            $toplam_tutar = 0;
            foreach ($cikarilacak_stok as $urun) {
                $urun_bilgisi = $this->modelStock->find($urun['urun_id']);
                if ($urun_bilgisi) {
                    $toplam_tutar += $urun['cikarilacak_miktar'] * floatval($urun_bilgisi['sale_unit_price']);
                }
            }

            [$transaction_direction, $amount_to_be_processed] = ['entry', $toplam_tutar * -1];

            $create_sale_order_code = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            $invoice_no = 'PALET-'.$create_sale_order_code;

            // Fatura kayıt oluştur
            $insert_invoice_data = [
                'user_id' => session()->get('user_id'),
                'money_unit_id' => $buy_money_unit_id,
                'sale_type' => "quick",
                'invoice_no' => $invoice_no,
                'invoice_direction' => 'outgoing_invoice',
                'invoice_date' => date('Y-m-d H:i:s'),
                'expiry_date' => date('Y-m-d H:i:s'),
                'currency_amount' => 1,
                'invoice_note' => $transaction_note,    
                'stock_total' => $toplam_tutar,
                'stock_total_try' => $toplam_tutar * floatval(str_replace(',', '.', $currency_amount)),
                'sub_total' => $toplam_tutar,
                'sub_total_try' => $toplam_tutar * floatval(str_replace(',', '.', $currency_amount)),
                'grand_total' => $toplam_tutar,
                'grand_total_try' => $toplam_tutar * floatval(str_replace(',', '.', $currency_amount)),
                'amount_to_be_paid' => $toplam_tutar,
                'amount_to_be_paid_try' => $toplam_tutar * floatval(str_replace(',', '.', $currency_amount)),
                'cari_identification_number' => $supplier['identification_number'],
                'cari_tax_administration' => $supplier['tax_administration'],
                'cari_id' => $user_item_tedarik,
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

            // Finansal hareket oluştur
            $currentDateTime = new Time('now', 'Turkey', 'en_US');
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
                'transaction_title' => "Palet Etiket Yazdırma - Stoktan Çıkış",
                'transaction_description' => "Palet Etiket Yazdırma - Stoktan Çıkış",
                'transaction_amount' => $toplam_tutar,
                'transaction_real_amount' => $toplam_tutar,
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


          
        } else {
            $supplier = 0;
        }
        
        // Her ürün için stok çıkış işlemi yap
        if ($invoice_id > 0) {
            foreach ($cikarilacak_stok as $urun) {
                $urun_bilgisi = $this->modelStock->find($urun['urun_id']);
                if (!$urun_bilgisi) continue;
                
                $kullanilacak_miktar = $urun['cikarilacak_miktar'];
                $buy_unit_price = convert_number_for_sql($urun_bilgisi["sale_unit_price"]);
                $stock_total = $kullanilacak_miktar * $buy_unit_price;
                
                // Stok miktarını güncelle
                $yeni_stok_miktari = $urun_bilgisi['stock_total_quantity'] - $kullanilacak_miktar;
                
                $insert_StockWarehouseQuantity = [
                    'user_id' => session()->get('user_id'),
                    'warehouse_id' => $warehouse_id,
                    'stock_id' => $urun_bilgisi['stock_id'],
                    'parent_id' => $urun_bilgisi['parent_id'],
                    'stock_quantity' => $yeni_stok_miktari,
                ];

                $parentStok = $urun_bilgisi['parent_id'] == 0 ? $urun['urun_id'] : $urun_bilgisi['parent_id'];
                $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $warehouse_id, $urun['urun_id'], $parentStok, floatval($kullanilacak_miktar), 'remove', $this->modelStockWarehouseQuantity, $this->modelStock);

                // Fatura satırı oluştur
                $insert_invoice_row_data = [
                    'user_id' => session()->get('user_id'),
                    'invoice_id' => $invoice_id,
                    'stock_id' => $urun['urun_id'],
                    'stock_title' => $urun['urun_adi'],
                    'stock_amount' => $kullanilacak_miktar,
                    'unit_id' => $urun_bilgisi['buy_unit_id'],
                    'unit_price' => $buy_unit_price,
                    'subtotal_price' => $stock_total,
                    'total_price' => $stock_total,
                ];
                $this->modelInvoiceRow->insert($insert_invoice_row_data);
                $invoice_row_id = $this->modelInvoiceRow->getInsertID();

                // Stok hareketi oluştur
                $stock_barcode_all = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                    ->where('stock_barcode.stock_id', $urun['urun_id'])
                    ->where('stock_barcode.warehouse_id', $warehouse_id)
                    ->findAll();

                foreach ($stock_barcode_all as $stock_barcode_item) {
                    $varMi = $stock_barcode_item['total_amount'] - $stock_barcode_item['used_amount'];

                    if ($varMi >= $kullanilacak_miktar) {
                        $last_transaction = $this->modelStockMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                        if ($last_transaction) {
                            $transaction_counter = $last_transaction['transaction_counter'] + 1;
                        } else {
                            $transaction_counter = 1;
                        }
                        $transaction_prefix = "PALET";
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
                            'sale_unit_price' => $urun_bilgisi['sale_unit_price'],
                            'sale_money_unit_id' => $urun_bilgisi['sale_money_unit_id'],
                            'transaction_quantity' => $kullanilacak_miktar,
                            'transaction_date' => date('Y-m-d H:i:s'),
                            'transaction_prefix' => $transaction_prefix,
                            'transaction_counter' => $transaction_counter,
                        ];
                        $this->modelStockMovement->insert($insert_stock_movement_data);

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
            }
        }
       








        ///     FATURA KESME İŞLEMİ BİTİŞ VE STOK DÜŞÜMÜ BİTİŞ

        // Başarılı response döndür
        return $this->response->setJSON([
            'icon' => 'success',
            'title' => 'Başarılı',
            'text' => 'Etiket başarıyla hazırlandı',
            'data' => [
                'etiket_data' => $etiket_data,
                'yazdirma_bilgisi' => [
                    'palet_id' => $palet_id,
                    'koli_sayisi' => $koli_sayisi,
                    'toplam_urun_cesidi' => count($cikarilacak_stok),
                    'yazdirma_tarihi' => date('Y-m-d H:i:s')
                ]
            ]
        ]);
    }
    

    public function generate_barcode($code) {
        $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();
        $barcode_svg = $generator->getBarcode($code, $generator::TYPE_CODE_128);
        
        // Barkodun altına sayıyı da ekle
        $barcode_with_text = '<div style="text-align: center;">';
        $barcode_with_text .= $barcode_svg;
        $barcode_with_text .= '<div style="font-family: monospace; font-size: 14px; font-weight: bold; margin-top: 5px; color: #333;">' . $code . '</div>';
        $barcode_with_text .= '</div>';
        
        return $barcode_with_text;
    }
}