<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoERP\StockRecipeModel;
use App\Models\TikoERP\RecipeItemModel;

class Home extends BaseController
{
    private $TikoERPModelPath = 'App\Models\TikoERP';
    private $DatabaseConfig;
    private $currentDB;
    private $modelInvoice;

    private $modelOperation;

    private $modelProductionRow;

    private $modelProductionOperation;

    private $modelProductionOperationRow;
    private $modelStock;

    private $modelEmirler;

    private $modelBox;
    private $modelBoxRow;

    private $modelOrderRow;
    private $modelStockRecipe;
    private $modelRecipeItem;

    private $db_con;
    private $stok_sayim;
    private $modelOperationUser;

    private $InvoiceOutgoingStatusModel;


    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->db_con = $db_connection;


        $this->modelInvoice = model($TikoERPModelPath . '\InvoiceModel', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath . '\StockModel', true, $db_connection);
        $this->modelOperation = model($TikoERPModelPath . '\OperationModel', true, $db_connection);
        $this->modelProductionRow = model($TikoERPModelPath . '\ProductionRowModel', true, $db_connection);
        $this->modelProductionOperation = model($TikoERPModelPath . '\ProductionOperationModel', true, $db_connection);
        $this->modelProductionOperationRow = model($TikoERPModelPath . '\ProductionOperationRowModel', true, $db_connection);
        $this->modelEmirler = model($TikoERPModelPath . '\SevkEmirleri', true, $db_connection);
        $this->modelBox = model($TikoERPModelPath . '\BoxModel', true, $db_connection);
        $this->modelBoxRow = model($TikoERPModelPath . '\BoxRowModel', true, $db_connection);
        $this->modelOrderRow = model($TikoERPModelPath . '\OrderRowModel', true, $db_connection);
        $this->modelStockRecipe = model($TikoERPModelPath . '\StockRecipeModel', true, $db_connection);
        $this->modelRecipeItem = model($TikoERPModelPath . '\RecipeItemModel', true, $db_connection);
        $this->modelOperationUser = model($TikoERPModelPath . '\OperationUser', true, $db_connection);
        $this->InvoiceOutgoingStatusModel = model($TikoERPModelPath . '\InvoiceOutgoingStatusModel', true, $db_connection);

        $this->stok_sayim =  session()->get("user_item")["stock_user"] ?? 0;

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


            if (session()->get('user_item')['user_id'] == 4) {

                $AtananLar = $this->modelOperationUser->where("client_id", session()->get('user_item')['client_id'])->where("status", "active")->first();
               
                if (empty($AtananLar)) {
                    // Eğer $AtananLar boş ise mevcut session'a operation_id'yi set et
                    $AtananLar["operation_id"] = session("user_item")["operation"];
                } else {
                    // Eğer $AtananLar mevcut ise, session'daki operation değerini güncelle
                    $userItem = session()->get('user_item');
                    $userItem['operation'] = $AtananLar["operation_id"];
                    session()->set('user_item', $userItem);
                }


                $modalStock = $this->modelStock->where("category_id", 10)->findAll();
               

                $operasyonlar = $this->modelOperation->where("operation_id", $AtananLar["operation_id"])->first();


                $beklemede_operasyonlar = $this->modelProductionOperation
                ->select('production_row_operation.*, stock.default_image, stock.parent_id, production.order, order.cari_invoice_title')
                ->join("stock", "stock.stock_id = production_row_operation.stock_id") // stock tablosuna bağlan
                ->join("production", "production.production_id = production_row_operation.production_id") // production tablosuna bağlan
                ->join("order", "order.order_id = production.order") // orders tablosuna bağlan
                ->where("production_row_operation.status", "Beklemede") // Beklemede olan işlemleri al
                ->where("production_row_operation.operation_id", $AtananLar["operation_id"]) // İlgili operasyon ID'sine göre filtrele
                ->findAll();
            
            // Görüntü yolu kontrolü ve parent_id üzerinden resim güncelleme
            foreach ($beklemede_operasyonlar as &$beklemede) {
                if ($beklemede["default_image"] == "uploads/default.png") {
                    $stoklar = $this->modelStock->where("stock_id", $beklemede["parent_id"])->first();
                    if ($stoklar && $stoklar["default_image"] != "uploads/default.png") {
                        $beklemede["default_image"] = $stoklar["default_image"];
                    }
                }
            }

           
    
                  $islemde_operasyonlar = $this->modelProductionOperation
                                               ->select('production_row_operation.*, stock.default_image, stock.parent_id , production.order, order.cari_invoice_title')
                                               ->join("stock", "stock.stock_id = production_row_operation.stock_id")
                                               ->join("production", "production.production_id = production_row_operation.production_id") // production tablosuna bağlan
                                               ->join("order", "order.order_id = production.order") // orders tablosuna bağlan
                                               ->where("production_row_operation.status", "İşlemde")
                                               ->orWhere("production_row_operation.status", "Durdu")
                                               ->orWhere("production_row_operation.status", "Devam")
                                               ->where("production_row_operation.operation_id", $AtananLar["operation_id"])
                                               ->findAll();
                                           
                                             
                      
                                           foreach($islemde_operasyonlar as &$islemde) {
                                            
                                               if($islemde["default_image"] == "uploads/default.png") {
                                                   $stoklar = $this->modelStock->where("stock_id", $islemde["parent_id"])->first();
                                                   if($islemde["default_image"] != "uploads/default.png"){
                                                    $islemde["default_image"] = $stoklar["default_image"];
                                                   }
                                                       
                                                }
                                                    $satirlar = $this->modelProductionOperationRow
                                                                     ->where("operation_id", $AtananLar["operation_id"])
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
                                                ->select('production_row_operation.*, stock.default_image, stock.parent_id, production.order, order.cari_invoice_title')
                                                ->join("stock", "stock.stock_id = production_row_operation.stock_id")
                                                ->join("production", "production.production_id = production_row_operation.production_id") // production tablosuna bağlan
                                                ->join("order", "order.order_id = production.order") // orders tablosuna bağlan
                                                ->where("production_row_operation.status", "Bitti")
                                                ->where("production_row_operation.operation_id", $AtananLar["operation_id"])
                                                ->findAll();
    
                                                foreach($bitti_operasyonlar as &$bitti) {
                                                    if($bitti["default_image"] == "uploads/default.png") {
                                                        $stoklar = $this->modelStock->where("stock_id", $bitti["parent_id"])->first();
                                                        if($bitti["default_image"] != "uploads/default.png")
                                                        $bitti["default_image"] = $stoklar["default_image"];
                                                    }
                                                }
    
    
    
    
                $beklemede_count = $this->modelProductionOperation->where("status", "Beklemede")->where("operation_id", $AtananLar["operation_id"])->countAllResults();
                $islemde_count = $this->modelProductionOperation->where("status", "İşlemde")->where("operation_id", $AtananLar["operation_id"])->orWhere("status", "Durdu")->orWhere("status", "Devam")->countAllResults();
    
                $bitti_count = $this->modelProductionOperation->where("status", "Bitti")->where("operation_id", $AtananLar["operation_id"])->countAllResults();
                
                $sevkler = $this->modelEmirler->orderBy("sevk_id", "DESC")->findAll();
                $kutular = $this->modelBox->findAll();
                foreach($kutular as $index => $satirlar){
                    $kutular[$index]["satirlar"] = $this->modelBoxRow->where("kutu_id", $satirlar["id"])->findAll();
                }
                $order_satirlar = $this->modelOrderRow->where("kutu_id !=", NULL)->findAll();
    
                $data = [
                    'beklemede_operasyonlar' => $beklemede_operasyonlar,
                    'beklemede_count' => $beklemede_count,
                    'islemde_operasyonlar' => $islemde_operasyonlar,
                    'islemde_count' => $islemde_count,
                    'bitti_operasyonlar' => $bitti_operasyonlar,
                    'bitti_count' => $bitti_count,
                    'sevkler' => $sevkler,
                    'kutular' => $kutular,
                    'modalStock' => $modalStock,
                    'order_satirlar' => $order_satirlar,
                    'outgoing_invoices' => $outgoing_items,
                    'incoming_invoices' => $incoming_items,
                    'operation' => $AtananLar["operation_id"],
                    'operation_title' => $operasyonlar["operation_title"]
    
                ];
    
                return view('tportal/operations', $data);





                
            }else{
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
    
                $data = [
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
            }



         
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
}