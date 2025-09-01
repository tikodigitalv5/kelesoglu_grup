<?php 
namespace App\Controllers\TikoERP;
use App\Controllers\BaseController;
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;

/**
 * @property IncomingRequest $request 
 */


class Variant extends BaseController{
    private $DatabaseConfig;
    private $currentDB;
    
    private $modelVariantGroup;
    private $modelVariantProperty;
    private $modelStockVariantGroup;
    private $modelVariantGroupCategory;
    private $modelStock;
    private $logClass;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelVariantGroup = model($TikoERPModelPath.'\VariantGroupModel', true, $db_connection);
        $this->modelVariantProperty = model($TikoERPModelPath.'\VariantPropertyModel', true, $db_connection);
        $this->modelStockVariantGroup = model($TikoERPModelPath.'\StockVariantGroupModel', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath.'\StockModel', true, $db_connection);
        $this->modelVariantGroupCategory = model($TikoERPModelPath.'\VariantGroupCategoryModel', true, $db_connection);

        $this->logClass = new Log();

        helper('Helpers\number_format_helper');

    }

    public function list(){

        $variant_property_items = [];
        $variant_group_items = $this->modelVariantGroup->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();
        foreach($variant_group_items as $variant_group_item){
            $variant_property_items[$variant_group_item['variant_group_id']] = $this->modelVariantProperty->where('variant_group_id', $variant_group_item['variant_group_id'])->findAll();
        }

        $data = [
            'variant_group_items' => $variant_group_items,
            'variant_property_items' => $variant_property_items
        ];

        return view('tportal/stoklar/varyantlar/index', $data);
    }

    public function create(){

        if($this->request->getMethod('true') == 'POST'){
            try {
                $variant_title = $this->request->getPost('variant_group_title');
                $status = $this->request->getPost('variant_group_status');
                $order = $this->request->getPost('variant_group_order');
                $website = $this->request->getPost('variant_group_website') ?? 0;
                $b2b = $this->request->getPost('variant_group_b2b') ?? 0;

                $form_data = [
                    'user_id' => session()->get('user_id'),
                    'variant_title' => $variant_title,
                    'website' => $website,
                    'b2b' => $b2b,
                    'order' => $order,
                    'status' => $status,
                ];

                $this->modelVariantGroup->insert($form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Varyant grubu başarıyla eklendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'variant_group',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }

        }else {
            return redirect()->back();
        }
    }

    public function listLoad(){
        $variant_group_items = $this->modelVariantGroup->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();

        echo json_encode(['variant_group_items'=> $variant_group_items]);
        return;
    }

    public function edit(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $variant_group_id = $this->request->getPost('variant_group_id');
                $variant_title = $this->request->getPost('variant_group_title');
                $order = $this->request->getPost('variant_group_order');
                $website = $this->request->getPost('variant_group_website') ?? 0;
                $b2b = $this->request->getPost('variant_group_b2b') ?? 0;

                $variant_group_item = $this->modelVariantGroup->where('variant_group_id', $variant_group_id)->where('user_id', session()->get('user_id'))->first();
                if(!$variant_group_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen varyant grubu bulunamadı.']);
                    return;
                }

                $form_data = [
                    'website' => $website,
                    'b2b' => $b2b,
                    'variant_title' => $variant_title,
                    'order' => $order
                ];

                $this->modelVariantGroup->update($variant_group_id, $form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Varyant grubu başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'variant_group',
                    $variant_group_id,
                    null,
                    'edit',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }

        }else {
            return redirect()->back();
        }
    }

    public function editStatus(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $variant_group_id = $this->request->getPost('variant_group_id');
                $status = $this->request->getPost('status');

                $variant_group_item = $this->modelVariantGroup->where('variant_group_id', $variant_group_id)->where('user_id', session()->get('user_id'))->first();
                if(!$variant_group_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen varyant grubu bulunamadı.']);
                    return;
                }

                $this->modelVariantGroup->update($variant_group_id, ['status' => $status]);

                echo json_encode(['icon'=> 'success', 'message' => 'Varyant grubu başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'variant_group',
                    $variant_group_id,
                    null,
                    'edit',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }

        }else {
            return redirect()->back();
        }
    }



    public function editStatusB2B(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $variant_group_id = $this->request->getPost('variant_group_id');
                $status = $this->request->getPost('status');

                $variant_group_item = $this->modelVariantGroup->where('variant_group_id', $variant_group_id)->where('user_id', session()->get('user_id'))->first();
                if(!$variant_group_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen varyant grubu bulunamadı.']);
                    return;
                }

                $this->modelVariantGroup->update($variant_group_id, ['b2b' => $status]);

                echo json_encode(['icon'=> 'success', 'message' => 'Varyant b2b durumu başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'variant_group',
                    $variant_group_id,
                    null,
                    'edit',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }

        }else {
            return redirect()->back();
        }
    }



    public function editStatusWebsite(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $variant_group_id = $this->request->getPost('variant_group_id');
                $status = $this->request->getPost('status');

                $variant_group_item = $this->modelVariantGroup->where('variant_group_id', $variant_group_id)->where('user_id', session()->get('user_id'))->first();
                if(!$variant_group_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen varyant grubu bulunamadı.']);
                    return;
                }

                $this->modelVariantGroup->update($variant_group_id, ['website' => $status]);

                echo json_encode(['icon'=> 'success', 'message' => 'Varyant website durumu başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'variant_group',
                    $variant_group_id,
                    null,
                    'edit',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }

        }else {
            return redirect()->back();
        }
    }


    

    public function delete(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $variant_group_id = $this->request->getPost('variant_group_id');

                $variant_group_item = $this->modelVariantGroup->where('variant_group_id', $variant_group_id)->where('user_id', session()->get('user_id'))->first();
                if(!$variant_group_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen varyant grubu bulunamadı.']);
                    return;
                }


                $stockVariantGroup = $this->modelVariantGroupCategory->where("variant_group_id", $variant_group_id)->findAll();


               

               
                $stockError = [];

               


                $i = 0;
                foreach ($stockVariantGroup as $varyant) {
                            $substock_item = $this->modelStockVariantGroup->where("category_id", $varyant["category_id"])->first();
                            if($substock_item)
                            {
                                $i++;
                               
                            }
                }

       
                
            
                if($i > 0 ) {
                    echo json_encode(['icon'=> 'error', 'message' => '<b>'.$variant_group_item["variant_title"].'</b> Varyantına Ait Ürün Olduğu İçin Silinemedi']);
                    return;
                }

                if($i == 0 ) {            
                     $this->modelVariantGroup->delete($variant_group_id);

                     $related_data = $this->modelVariantGroupCategory->where('variant_group_id', $variant_group_id)->findAll();
                     $related_category_ids = array_column($related_data, 'category_id');
                     $related_variant_group_category_ids = array_column($related_data, 'variant_group_category_id');
                     if($related_variant_group_category_ids){
                        $this->modelVariantGroupCategory->whereIn('variant_group_category_id', $related_variant_group_category_ids)->delete();
                     }

                     if($related_category_ids){
                        $this->modelStockVariantGroup->whereIn('category_id', $related_category_ids)->delete();
                     }
     
                  
                    
     
     
                     echo json_encode(['icon'=> 'success', 'message' => 'Varyant grubu başarıyla silindi.']);
                     return;
                   
                }

    
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'variant_group',
                    $variant_group_id,
                    null,
                    'delete',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }

        }else {
            return redirect()->back();
        }
    }

    public function property_list(){

        $variant_property_items = $this->modelVariantProperty->join('variant_group', 'variant_group.variant_group_id = variant_property.variant_group_id')
                                                            ->where('variant_group.user_id', session()->get('user_id'))
                                                            ->orderBy('order', 'ASC')
                                                            ->findAll();

        $data = [
            'variant_property_items' => $variant_property_items,
        ];

        return;
    }

    public function property_create(){

        if($this->request->getMethod('true') == 'POST'){
            try {
                $variant_group_id = $this->request->getPost('variant_group_id');
                $variant_property_title = $this->request->getPost('variant_property_title');
                $variant_property_code = $this->request->getPost('variant_property_code');
                $order = $this->request->getPost('variant_property_order');

                $form_data = [
                    'variant_group_id' => $variant_group_id,
                    'variant_property_title' => $variant_property_title,
                    'variant_property_code' => $variant_property_code,
                    'order' => $order
                ];

                $this->modelVariantProperty->insert($form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Varyant özelliği başarıyla eklendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'variant_property',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }

        }else {
            return redirect()->back();
        }
    }

    public function property_listLoad(){
        $variant_property_items = $this->modelVariantProperty->join('variant_group', 'variant_group.variant_group_id = variant_property.variant_group_id')
                                                        ->where('variant_group.user_id', session()->get('user_id'))
                                                        ->orderBy('order', 'ASC')
                                                        ->findAll();

        echo json_encode(['variant_property_items'=> $variant_property_items]);
        return;
    }

    public function property_edit(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $variant_property_id = $this->request->getPost('variant_property_id');
                $variant_property_title = $this->request->getPost('variant_property_title');
                $variant_property_code = $this->request->getPost('variant_property_code');
                $order = $this->request->getPost('variant_property_order');

                $variant_group_item = $this->modelVariantProperty->join('variant_group', 'variant_group.variant_group_id = variant_property.variant_group_id')
                                                                ->where('variant_property.variant_property_id', $variant_property_id)
                                                                ->where('variant_group.user_id', session()->get('user_id'))
                                                                ->first();
                if(!$variant_group_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen varyant özelliği bulunamadı.']);
                    return;
                }

                $form_data = [
                    'variant_property_title' => $variant_property_title,
                    'variant_property_code' => $variant_property_code,
                    'order' => $order
                ];

                $this->modelVariantProperty->update($variant_property_id, $form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Varyant grubu başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'variant_property',
                    $variant_property_id,
                    null,
                    'edit',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }

        }else {
            return redirect()->back();
        }
    }

    public function property_delete(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $variant_property_id = $this->request->getPost('variant_property_id');

                $variant_property_item = $this->modelVariantProperty->join('variant_group', 'variant_group.variant_group_id = variant_property.variant_group_id')
                                                                   //  ->join('variant_group_category', 'variant_group_category.variant_group_id = variant_property.variant_group_id')
                                                                    ->where('variant_property.variant_property_id', $variant_property_id)
                                                                    ->where('variant_group.user_id', session()->get('user_id'))
                                                                    ->first();
                if(!$variant_property_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen varyant özelliği bulunamadı.']);
                    return;
                }

                $i = 0;

                $variantP = $this->modelVariantGroupCategory->where("variant_group_id", $variant_property_item["variant_group_id"])->first();

                if(!$variantP)
                {   

                    $i = 0;

                }else{
                    $variant_column = "variant_" . $variantP["variant_column"];
                    $variant_group_id =  $variant_property_item["variant_group_id"];
                
                    $variantlar = $this->modelVariantProperty->where("variant_group_id", $variant_group_id)->findAll();
                    $variant_bul = $this->modelVariantGroup->where("variant_group_id", $variant_group_id)->first();
                  
                    foreach ($variantlar as $varyant) {
                        $stoklardaBul = $this->modelStockVariantGroup->where($variant_column, $varyant["variant_property_id"])->countAllResults();
                        $i = $i + $stoklardaBul; 
                    }
                
                    if($i > 0 ) {
                        echo json_encode(['icon'=> 'error', 'message' => '<b>'.$variant_property_item["variant_property_title"].'</b> Özelliğine Ait Alt Ürünler Olduğu İçin Silinemedi.']);
                        return;
                    }
                }

              
               

                if($i == 0 ) {

                    $this->modelVariantProperty->delete($variant_property_id);

             
                     $related_data = $this->modelStockVariantGroup->where('variant_1', $variant_property_id)
                                                 ->orWhere('variant_2', $variant_property_id)
                                                 ->orWhere('variant_3', $variant_property_id)
                                                 ->orWhere('variant_4', $variant_property_id)
                                                 ->orWhere('variant_5', $variant_property_id)
                                                 ->orWhere('variant_6', $variant_property_id)
                                                 ->orWhere('variant_7', $variant_property_id)
                                                 ->orWhere('variant_8', $variant_property_id)
                                                 ->orWhere('variant_9', $variant_property_id)
                                                 ->orWhere('variant_10', $variant_property_id)
                                                 ->findAll();
                    if($related_data){
                        $related_stock_ids = array_column($related_data, 'stock_id');
                        $related_stock_variant_group_ids = array_column($related_data, 'stock_variant_group_id');
                        if($related_stock_ids){
                            $this->modelStock->whereIn('stock_id', $related_stock_ids)->delete();
                        }
                        if($related_stock_variant_group_ids){
                            $this->modelStockVariantGroup->whereIn('stock_variant_group_id', $related_stock_variant_group_ids)->delete();
                        }
                    }
     
                     
     
                    
                    
     
                     echo json_encode(['icon'=> 'success', 'message' => 'Varyant grubu başarıyla silindi.']); 
                     return;
                }



          
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'variant_property',
                    $variant_property_id,
                    null,
                    'delete',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }

        }else {
            return redirect()->back();
        }
    }
}