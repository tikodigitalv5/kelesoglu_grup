<?php

namespace App\Controllers\TikoERP;
use App\Controllers\BaseController;
use App\Models\TikoERP\CategoryModel;
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;

/**
 * @property IncomingRequest $request 
 */
ob_start();


class GiderKategori extends BaseController
{
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
    private $modelGiderGrup;
    private $modelGiderKategori;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelCategory = model($TikoERPModelPath . '\GiderKategoriModel', true, $db_connection);
        $this->modelVariantGroupCategory = model($TikoERPModelPath . '\VariantGroupCategoryModel', true, $db_connection);
        $this->modelVariantGroup = model($TikoERPModelPath . '\VariantGroupModel', true, $db_connection);
        $this->modelStockVariantGroup = model($TikoERPModelPath . '\StockVariantGroupModel', true, $db_connection);
        $this->modelVariantProperty = model($TikoERPModelPath . '\VariantPropertyModel', true, $db_connection);
        $this->modelStockMovement = model($TikoERPModelPath . '\StockMovementModel', true, $db_connection);
        $this->modelStockBarcode = model($TikoERPModelPath . '\StockBarcodeModel', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath . '\StockModel', true, $db_connection);

        $this->modelGiderGrup = model($TikoERPModelPath . '\GiderGrupModel', true, $db_connection);
        $this->modelGiderKategori = model($TikoERPModelPath . '\GiderKategoriModel', true, $db_connection);


        $this->logClass = new Log();

        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
        helper('Helpers\formatter_helper');
        helper('Helpers\stock_func_helper');
    }

    public function list()
    {


        $category_items = $this->modelCategory
        ->join('gider_group_category', 'gider_group_category.gider_group_category_id = gider_category.grup_id')
        ->select("gider_category.*, gider_group_category.gider_group_category_title, gider_group_category.gider_group_category_id")
        ->where('gider_category.user_id', session()->get('user_id'))
        ->orderBy('gider_category.order', 'ASC')
        ->findAll();

        $giderGruplari = $this->modelGiderGrup->where("status", "active")->findAll();

        $data = [
            'category_items' => $category_items,
            'variant_group_items' => "",
            'gruplar' => $giderGruplari,
            'variant_category_items' => ""
        ];

        return view('tportal/stoklar/giderler/kategori/index', $data);
    }

    public function create()
    {

        if ($this->request->getMethod('true') == 'POST') {
            try {

                $gider_category_title = $this->request->getPost('gider_category_title');
                

         
                $status = $this->request->getPost('status');
                $order = $this->request->getPost('order');
                $default = $this->request->getPost('default');
                $grup_id = $this->request->getPost('gider_new_id');

            

                $form_data = [
                    'user_id' => session()->get('user_id'),
                    'gider_category_title' => $gider_category_title,
                    'grup_id' => $grup_id,
                    'status' => $status,
                    'order' => $order
                ];


                $this->modelCategory->insert($form_data);

                echo json_encode(['icon' => 'success', 'message' => 'Gider Grubu başarıyla eklendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'category',
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

    public function listLoad()
    {
        $category_items = $this->modelCategory->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();

        echo json_encode(['category_items' => $category_items]);
        return;
    }

    public function edit()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $gider_category_id = $this->request->getPost('gider_category_id');
                $gider_category_title = $this->request->getPost('gider_category_title');
                $order = $this->request->getPost('order');
                $grup_id = $this->request->getPost('grup_id');





                $category_item = $this->modelCategory->where('gider_category_id', $gider_category_id)->where('user_id', session()->get('user_id'))->first();
                if (!$category_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen grup bulunamadı.']);
                    return;
                }

                # Düzenleme sayfasında eğer kategori değeri daha önceden tanımlanmışsa bu sayfaya post edilmeyeceği için
                # burada null kontrolü yapıyoruz.

                $form_data = [
                    'grup_id' => $grup_id,
                    'gider_category_title' => $gider_category_title,
                    'order' => $order
                ];

                $this->modelCategory->update($gider_category_id, $form_data);

                echo json_encode(['icon' => 'success', 'message' => 'Gider Grubu başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'category',
                    $gider_category_id,
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

    public function editStatus()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $gider_category_id = $this->request->getPost('gider_category_id');
                $status = $this->request->getPost('status');

                $category_item = $this->modelCategory->where('gider_category_id', $gider_category_id)->where('user_id', session()->get('user_id'))->first();
                if (!$category_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen gider grubu bulunamadı.']);
                    return;
                }

                $this->modelCategory->update($gider_category_id, ['status' => $status]);

                echo json_encode(['icon' => 'success', 'message' => 'Gider Grubu başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'category',
                    $gider_category_id,
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

  

    public function delete()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $gider_category_id = $this->request->getPost('gider_category_id');

                $category_item = $this->modelCategory->where('gider_category_id', $gider_category_id)->where('user_id', session()->get('user_id'))->first();
                if (!$category_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Gider grubu kategori bulunamadı.']);
                    return;
                }






                $stockError = [];




                $i = 0;
             

                if ($i == 0) {
                    $this->modelCategory->delete($gider_category_id);
                    echo json_encode(['icon' => 'success', 'message' => 'Gider Grubu  başarıyla silindi.']);
                    return;
                }





            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'category',
                    $gider_category_id,
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

   


}