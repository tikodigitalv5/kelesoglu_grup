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


class AltCategory extends BaseController
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

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelCategory = model($TikoERPModelPath . '\AltCategoryModel', true, $db_connection);
        $this->modelVariantGroupCategory = model($TikoERPModelPath . '\VariantGroupCategoryModel', true, $db_connection);
        $this->modelVariantGroup = model($TikoERPModelPath . '\VariantGroupModel', true, $db_connection);
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

    public function list()
    {


        $category_items = $this->modelCategory->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();


        $data = [
            'category_items' => $category_items,
            'variant_group_items' => "",
            'variant_category_items' => ""
        ];

        return view('tportal/stoklar/altkategoriler/index', $data);
    }

    public function create()
    {

        if ($this->request->getMethod('true') == 'POST') {
            try {

                $alt_category_title = $this->request->getPost('alt_category_title');
                $upload_image = $this->request->getPost('upload_image');
                if (empty($upload_image)) {
                    // Eğer 'upload_image' değeri boş ise, varsayılan bir resim atayın
                    $upload_images = "uploads/default.png";
                } else {
                    // Eğer 'upload_image' değeri var ise, bu değeri kullanın
                    $upload_images = $upload_image;
                }

         
                $status = $this->request->getPost('status');
                $order = $this->request->getPost('order');
                $default = $this->request->getPost('default');

            

                $form_data = [
                    'user_id' => session()->get('user_id'),
                    'alt_category_title' => $alt_category_title,
                    'default_image' => $upload_images,
                    'status' => $status,
                    'order' => $order
                ];


                $this->modelCategory->insert($form_data);

                echo json_encode(['icon' => 'success', 'message' => 'Kategori başarıyla eklendi.']);
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


                if($stock_id == 0)
                {


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
    
                    echo json_encode(['icon' => 'success', 'message' => 'Resim başarıyla yüklendi.', 'imagePath' => $imagePath, 'stock_id' => $stock_id]);
                    return;


                }


                $stock_item = $this->modelCategory->where('user_id', session()->get('user_id'))->where('alt_category_id', $stock_id)->first();
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



                        $form_data = [
                            'default_image' => $imagePath
                        ];

                        $this->modelCategory->update($stock_id, $form_data);


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

                echo json_encode(['icon' => 'success', 'message' => 'Resim başarıyla yüklendi.', 'imagePath' => $imagePath, 'stock_id' => $stock_id]);
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

    public function edit()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $alt_category_id = $this->request->getPost('alt_category_id');
                $alt_category_title = $this->request->getPost('alt_category_title');
                $order = $this->request->getPost('order');





                $category_item = $this->modelCategory->where('alt_category_id', $alt_category_id)->where('user_id', session()->get('user_id'))->first();
                if (!$category_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen kategori bulunamadı.']);
                    return;
                }

                # Düzenleme sayfasında eğer kategori değeri daha önceden tanımlanmışsa bu sayfaya post edilmeyeceği için
                # burada null kontrolü yapıyoruz.

                $form_data = [
                    'alt_category_title' => $alt_category_title,
                    'order' => $order
                ];

                $this->modelCategory->update($alt_category_id, $form_data);

                echo json_encode(['icon' => 'success', 'message' => 'Kategori başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'category',
                    $alt_category_id,
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
                $alt_category_id = $this->request->getPost('alt_category_id');
                $status = $this->request->getPost('status');

                $category_item = $this->modelCategory->where('alt_category_id', $alt_category_id)->where('user_id', session()->get('user_id'))->first();
                if (!$category_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen kategori bulunamadı.']);
                    return;
                }

                $this->modelCategory->update($alt_category_id, ['status' => $status]);

                echo json_encode(['icon' => 'success', 'message' => 'Kategori başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'category',
                    $alt_category_id,
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

    public function editDefault()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $alt_category_id = $this->request->getPost('alt_category_id');

                $category_item = $this->modelCategory->where('alt_category_id', $alt_category_id)->where('user_id', session()->get('user_id'))->first();
                if (!$category_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen kategori bulunamadı.']);
                    return;
                }

                $category_items = $this->modelCategory->where('user_id', session()->get('user_id'))->where('default', 'true')->findAll();
                foreach ($category_items as $category_item) {
                    $this->modelCategory->update($category_item['alt_category_id'], ['default' => 'false']);
                }

                $this->modelCategory->update($alt_category_id, ['default' => 'true']);

                echo json_encode(['icon' => 'success', 'message' => 'Kategori başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'category',
                    $alt_category_id,
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
                $alt_category_id = $this->request->getPost('alt_category_id');

                $category_item = $this->modelCategory->where('alt_category_id', $alt_category_id)->where('user_id', session()->get('user_id'))->first();
                if (!$category_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen kategori bulunamadı.']);
                    return;
                }






                $stockError = [];




                $i = 0;
                $substock_item = $this->modelStock->where("altcategory_id", $category_item["alt_category_id"])->first();
                    if ($substock_item) {
                        $i++;

                    }




                if ($i > 0) {
                    echo json_encode(['icon' => 'error', 'message' => '<b>' . $category_item["alt_category_title"] . '</b>  Ait Ürün Olduğu İçin Silinemedi']);
                    return;
                }

                if ($i == 0) {
                    $this->modelCategory->delete($alt_category_id);
                    echo json_encode(['icon' => 'success', 'message' => 'Kategori  başarıyla silindi.']);
                    return;
                }





            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'category',
                    $alt_category_id,
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

    public function createVariantGroupCategory()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $alt_category_id = $this->request->getPost('alt_category_id');
                $variant_group_id = $this->request->getPost('variant_group_id');

                $last_item = $this->modelVariantGroupCategory->where('alt_category_id', $alt_category_id)->orderBy('variant_column', 'DESC')->first();
                if (!$last_item) {
                    $variant_column = 1;
                } elseif ($last_item['variant_column'] < 10) {
                    $variant_column = $last_item['variant_column'] + 1;
                } else {
                    echo json_encode(['icon' => 'error', 'message' => 'Bir kategoriye en fazla 10 adet varyant grubu eklenebilir.']);
                    return;
                }
                $form_data = [
                    'user_id' => session()->get('user_id'),
                    'alt_category_id' => $alt_category_id,
                    'variant_group_id' => $variant_group_id,
                    'variant_column' => $variant_column,
                ];

                $this->modelVariantGroupCategory->insert($form_data);

                echo json_encode(['icon' => 'success', 'message' => 'Varyant kategoriye başarıyla eklendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'variant_group_category',
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

    public function deleteVariantGroupCategory()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $variant_alt_category_id = $this->request->getPost('variant_alt_category_id');

                $variant_category_item = $this->modelVariantGroupCategory
                    ->where('variant_group_alt_category_id', $variant_alt_category_id)
                    ->where('user_id', session()->get('user_id'))
                    ->first();

                if (!$variant_category_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen kategori varyantı bulunamadı.']);
                    return;
                }

                $variant_column = "variant_" . $variant_category_item["variant_column"];
                $variant_group_id = $variant_category_item["variant_group_id"];

                $variantlar = $this->modelVariantProperty->where("variant_group_id", $variant_group_id)->findAll();
                $variant_bul = $this->modelVariantGroup->where("variant_group_id", $variant_group_id)->first();
                $i = 0;
                foreach ($variantlar as $varyant) {
                    $stoklardaBul = $this->modelStockVariantGroup->where($variant_column, $varyant["variant_property_id"])->countAllResults();
                    $i = $i + $stoklardaBul; // Döngüdeki her adımda $i değerini güncelle
                }

                if ($i > 0) {
                    echo json_encode(['icon' => 'error', 'message' => '<b>' . $variant_bul["variant_title"] . '</b> Varyantına Ait Alt Ürünler Olduğu İçin Silinemedi.']);
                    return;
                }

                if ($i == 0) {
                    $this->modelVariantGroupCategory->delete($variant_alt_category_id);
                    echo json_encode(['icon' => 'success', 'message' => 'Kategori varyantı başarıyla silindi.']);
                    return;
                }

                // Eğer $i değeri 0 ise, silme işlemini gerçekleştir

            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'variant_group_category',
                    $variant_alt_category_id,
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