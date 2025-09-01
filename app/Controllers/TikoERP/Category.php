<?php

namespace App\Controllers\TikoERP;
use App\Controllers\BaseController;
use App\Models\TikoERP\CategoryModel;
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;

/**
 * @property IncomingRequest $request 
 */


class Category extends BaseController{
    private $DatabaseConfig;
    private $currentDB;

    private $modelCategory;
    private $modelVariantGroupCategory;
    private $modelVariantGroup;
    private $logClass;
    private $modelStockVariantGroup;
    private $modelVariantProperty;
    private $modelStockMovement;

    private $modelStock;
    private $modelStockBarcode;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelCategory = model($TikoERPModelPath.'\CategoryModel', true, $db_connection);
        $this->modelVariantGroupCategory = model($TikoERPModelPath.'\VariantGroupCategoryModel', true, $db_connection);
        $this->modelVariantGroup = model($TikoERPModelPath.'\VariantGroupModel', true, $db_connection);
        $this->modelStockVariantGroup = model($TikoERPModelPath . '\StockVariantGroupModel', true, $db_connection);
        $this->modelVariantProperty = model($TikoERPModelPath . '\VariantPropertyModel', true, $db_connection);
        $this->modelStockMovement = model($TikoERPModelPath . '\StockMovementModel', true, $db_connection);
        $this->modelStockBarcode = model($TikoERPModelPath . '\StockBarcodeModel', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath . '\StockModel', true, $db_connection);
        $this->logClass = new Log();

        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
        helper('Helpers\formatter_helper');
        helper('Helpers\stock_func_helper');
    }

    public function list(){

        $variant_category_items = [];
        $category_items = $this->modelCategory->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();
       
        $variant_group_items = $this->modelVariantGroup->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();

        foreach($category_items as $category_item){
            $variant_category_items[$category_item['category_id']] = $this->modelVariantGroupCategory->join('variant_group', 'variant_group.variant_group_id = variant_group_category.variant_group_id')->where('category_id', $category_item['category_id'])->findAll();
        }
        $data = [
            'category_items' => $category_items,
            'variant_group_items' => $variant_group_items,
            'variant_category_items' => $variant_category_items
        ];

        return view('tportal/stoklar/kategoriler/index', $data);
    }

    public function create(){

        if($this->request->getMethod('true') == 'POST'){
            try {
                
                $category_title = $this->request->getPost('category_title');
                $category_value = $this->request->getPost('category_value');
                $status = $this->request->getPost('status');
                $order = $this->request->getPost('order');
                $default = $this->request->getPost('default');

                # Kategori value benzersiz mi diye kontrol ediyoruz
                $chk_category_value = $this->modelCategory->where('user_id', session()->get('user_id'))->where('category_value', $category_value)->first();
                if($chk_category_value){
                    echo json_encode(['icon'=> 'error', 'message' => "Aynı kategori benzersiz adında birden fazla kategori olamaz."]);
                    return;
                }

                $form_data = [
                    'user_id' => session()->get('user_id'),
                    'category_title' => $category_title,
                    'category_value' => $category_value,
                    'status' => $status,
                    'order' => $order,
                    'default' => 'false'
                ];

                // Sadece belirli kullanıcılar için ek alanları ekle
                if(session()->get('user_id') == 5 || session()->get('client_id') == 154) {
                    $form_data['ham_carpan'] = $this->request->getPost('ham_carpan');
                    $form_data['kap_carpan'] = $this->request->getPost('kap_carpan');
                    $form_data['tas_carpan'] = $this->request->getPost('tas_carpan');
                    $form_data['mineli_carpan'] = $this->request->getPost('mineli_carpan');
                    $form_data['kar_oran'] = $this->request->getPost('kar_oran');
                }

                if($default){
                    $category_items = $this->modelCategory->where('user_id', session()->get('user_id'))->where('default', 'true')->findAll();
                    foreach($category_items as $category_item){
                        $this->modelCategory->update($category_item['category_id'], ['default' => 'false']);
                    }

                    $form_data['default'] = 'true';
                }

                $this->modelCategory->insert($form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Kategori başarıyla eklendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'category',
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
        $category_items = $this->modelCategory->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();

        echo json_encode(['category_items'=> $category_items]);
        return;
    }

    public function edit(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $category_id = $this->request->getPost('category_id');
                $category_title = $this->request->getPost('category_title');
                $category_value = $this->request->getPost('category_value');
                $order = $this->request->getPost('order');

                # Kategori value benzersiz mi diye kontrol ediyoruz
                $chk_category_value = $this->modelCategory->where('user_id', session()->get('user_id'))->where('category_value', $category_value)->where('category_id !=', $category_id)->first();
                if($chk_category_value){
                    echo json_encode(['icon'=> 'error', 'message' => "Aynı kategori benzersiz adında birden fazla kategori olamaz."]);
                    return;
                }

                $category_item = $this->modelCategory->where('category_id', $category_id)->where('user_id', session()->get('user_id'))->first();
                if(!$category_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen kategori bulunamadı.']);
                    return;
                }

                # Düzenleme sayfasında eğer kategori değeri daha önceden tanımlanmışsa bu sayfaya post edilmeyeceği için
                # burada null kontrolü yapıyoruz.
                $category_value = $category_value == null || $category_value == '' ? $category_item['category_value'] : $category_value;

                $form_data = [
                    'category_title' => $category_title,
                    'category_value' => $category_value,
                    'order' => $order
                ];

                // Sadece belirli kullanıcılar için ek alanları ekle
                if(session()->get('user_id') == 5 || session()->get('client_id') == 154) {
                    $form_data['ham_carpan'] = $this->request->getPost('ham_carpan');
                    $form_data['kap_carpan'] = $this->request->getPost('kap_carpan');
                    $form_data['tas_carpan'] = $this->request->getPost('tas_carpan');
                    $form_data['mineli_carpan'] = $this->request->getPost('mineli_carpan');
                    $form_data['kar_oran'] = $this->request->getPost('kar_oran');
                }

                $this->modelCategory->update($category_id, $form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Kategori başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'category',
                    $category_id,
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
                $category_id = $this->request->getPost('category_id');
                $status = $this->request->getPost('status');

                $category_item = $this->modelCategory->where('category_id', $category_id)->where('user_id', session()->get('user_id'))->first();
                if(!$category_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen kategori bulunamadı.']);
                    return;
                }

                $this->modelCategory->update($category_id, ['status' => $status]);

                echo json_encode(['icon'=> 'success', 'message' => 'Kategori başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'category',
                    $category_id,
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

    public function editDefault(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $category_id = $this->request->getPost('category_id');

                $category_item = $this->modelCategory->where('category_id', $category_id)->where('user_id', session()->get('user_id'))->first();
                if(!$category_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen kategori bulunamadı.']);
                    return;
                }

                $category_items = $this->modelCategory->where('user_id', session()->get('user_id'))->where('default', 'true')->findAll();
                foreach($category_items as $category_item){
                    $this->modelCategory->update($category_item['category_id'], ['default' => 'false']);
                }

                $this->modelCategory->update($category_id, ['default' => 'true']);

                echo json_encode(['icon'=> 'success', 'message' => 'Kategori başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'category',
                    $category_id,
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
                $category_id = $this->request->getPost('category_id');

                $category_item = $this->modelCategory->where('category_id', $category_id)->where('user_id', session()->get('user_id'))->first();
                if(!$category_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen kategori bulunamadı.']);
                    return;
                }

                $stockVariantGroup = $this->modelStockVariantGroup->where("category_id", $category_id)->findAll();


               

               
                $stockError = [];

               


                $i = 0;
                foreach ($stockVariantGroup as $varyant) {
                            $substock_item = $this->modelStock->where("stock_id", $varyant["stock_id"])->first();
                            if($substock_item)
                            {
                                $i++;
                               
                            }
                }

       
                
            
                if($i > 0 ) {
                    echo json_encode(['icon'=> 'error', 'message' => '<b>'.$category_item["category_title"].'</b> Kategorisine Ait Ürün Olduğu İçin Silinemedi']);
                    return;
                }

                if($i == 0 ) {
                    $this->modelCategory->delete($category_id);
                     echo json_encode(['icon'=> 'success', 'message' => 'Kategori  başarıyla silindi.']);
                     return;
                }


                

               
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'category',
                    $category_id,
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

    public function createVariantGroupCategory(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $category_id = $this->request->getPost('category_id');
                $variant_group_id = $this->request->getPost('variant_group_id');

                $last_item = $this->modelVariantGroupCategory->where('category_id', $category_id)->orderBy('variant_column', 'DESC')->first();
                if(!$last_item){
                    $variant_column = 1;
                }elseif($last_item['variant_column'] < 10){
                    $variant_column = $last_item['variant_column'] + 1;
                }else {
                    echo json_encode(['icon'=> 'error', 'message' => 'Bir kategoriye en fazla 10 adet varyant grubu eklenebilir.']);
                    return;
                }
                $form_data = [
                    'user_id' => session()->get('user_id'),
                    'category_id' => $category_id,
                    'variant_group_id' => $variant_group_id,
                    'variant_column' => $variant_column,
                ];

                $this->modelVariantGroupCategory->insert($form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Varyant kategoriye başarıyla eklendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'variant_group_category',
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

    public function deleteVariantGroupCategory(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $variant_category_id = $this->request->getPost('variant_category_id');
            
                $variant_category_item = $this->modelVariantGroupCategory
                    ->where('variant_group_category_id', $variant_category_id)
                    ->where('user_id', session()->get('user_id'))
                    ->first();
            
                if(!$variant_category_item) {
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen kategori varyantı bulunamadı.']);
                    return;
                }
            
                $variant_column = "variant_" . $variant_category_item["variant_column"];
                $variant_group_id =  $variant_category_item["variant_group_id"];
            
                $variantlar = $this->modelVariantProperty->where("variant_group_id", $variant_group_id)->findAll();
                $variant_bul = $this->modelVariantGroup->where("variant_group_id", $variant_group_id)->first();
                $i = 0;
                foreach ($variantlar as $varyant) {
                    $stoklardaBul = $this->modelStockVariantGroup->where($variant_column, $varyant["variant_property_id"])->countAllResults();
                    $i = $i + $stoklardaBul; // Döngüdeki her adımda $i değerini güncelle
                }
            
                if($i > 0 ) {
                    echo json_encode(['icon'=> 'error', 'message' => '<b>'.$variant_bul["variant_title"].'</b> Varyantına Ait Alt Ürünler Olduğu İçin Silinemedi.']);
                    return;
                }

                if($i == 0 ) {
                     $this->modelVariantGroupCategory->delete($variant_category_id);
                     echo json_encode(['icon'=> 'success', 'message' => 'Kategori varyantı başarıyla silindi.']);
                     return;
                }
            
                // Eğer $i değeri 0 ise, silme işlemini gerçekleştir
               
            } catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'variant_group_category',
                    $variant_category_id,
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