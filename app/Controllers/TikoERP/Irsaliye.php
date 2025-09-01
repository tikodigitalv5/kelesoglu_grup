<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;
use App\Models\TikoERP\IrsaliyeModel;
use App\Models\TikoERP\IrsaliyeSatirModel;
use App\Models\TikoERP\IrsaliyeLogModel;
use App\Models\TikoERP\SysmondDepolarModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\HTTP\Request;
use CodeIgniter\I18n\Time;
use DateTime;
use DateTimeZone;
use PHPUnit\Util\Json;
use \Hermawan\DataTables\DataTable;

class Irsaliye extends BaseController
{
    use ResponseTrait;

    protected $irsaliyeModel;
    protected $irsaliyeSatirModel;
    protected $irsaliyeLogModel;
    protected $sysmondDepolarModel;
    protected $DatabaseConfig;
    protected $modelOrderRow;
    protected $modelOrder;
    protected $currentDB;
    protected $logClass;
    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);
        $this->irsaliyeModel = model($TikoERPModelPath . '\IrsaliyeModel', true, $db_connection);
        $this->irsaliyeSatirModel = model($TikoERPModelPath . '\IrsaliyeSatirModel', true, $db_connection);
        $this->irsaliyeLogModel = model($TikoERPModelPath . '\IrsaliyeLogModel', true, $db_connection);
        $this->sysmondDepolarModel = model($TikoERPModelPath . '\SysmondDepolarModel', true, $db_connection);
        $this->modelOrderRow = model($TikoERPModelPath . '\OrderRowModel', true, $db_connection);
        $this->modelOrder = model($TikoERPModelPath . '\OrderModel', true, $db_connection);
        $this->logClass = new Log();
        


        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
        helper('Helpers\stock_func_helper');
    }

 // app/Controllers/TikoERP/Irsaliye.php

 public function irsaliye_kontrol()
 {
     try {
         $db = \Config\Database::connect($this->currentDB);
         $db->transStart();
 
         // Form verilerini al
         $stock_ids = $this->request->getPost('stock_ids');
         $stock_titles = $this->request->getPost('stock_titles');
         $stock_codes = $this->request->getPost('stock_codes');
         $stock_images = $this->request->getPost('stock_images');
         $depo_ids = $this->request->getPost('depo_ids');
         $stock_amounts = $this->request->getPost('real_stock_amounts');
         $unit_titles = $this->request->getPost('unit_titles');
         $unit_prices = $this->request->getPost('unit_prices');
         $money_icons = $this->request->getPost('money_icons');
         $total_prices = $this->request->getPost('total_prices');
         
         // Sipariş verilerini al
         $order_row_ids = $this->request->getPost('order_row_id');
         $order_ids_array = $this->request->getPost('order_ids');
 
         // Debug logları
         log_message('debug', 'STOCK IDS: ' . json_encode($stock_ids));
         log_message('debug', 'ORDER IDS: ' . json_encode($order_ids_array));
         log_message('debug', 'ORDER ROW IDS: ' . json_encode($order_row_ids));
 
         if (!is_array($stock_ids) || empty($stock_ids)) {
             throw new \Exception('En az bir ürün girişi yapılmalıdır.');
         }
 
         // Depolara göre satırları grupla
         $depoGruplari = [];
 
         foreach ($stock_ids as $index => $stock_id) {
             // Temel kontroller
             if (empty($stock_id) || empty($depo_ids[$index])) {
                 log_message('warning', 'Boş stock_id veya depo_id. Index: ' . $index);
                 continue;
             }
 
             // Sipariş kontrolleri
             if (!isset($order_ids_array[$index]) || !isset($order_row_ids[$index])) {
                 log_message('warning', 'Sipariş bilgisi eksik. Stock ID: ' . $stock_id . ', Index: ' . $index);
                 continue;
             }
 
             $depo_id = $depo_ids[$index];
             if($depo_id == 1){
                 $depo_id = 34;
             }
 
             // Depo grubu oluştur
             if (!isset($depoGruplari[$depo_id])) {
                 $depoGruplari[$depo_id] = [
                     'satirlar' => [],
                     'ara_toplam' => 0,
                     'order_ids' => [],
                     'order_numbers' => []
                 ];
             }
 
             // Siparişleri işle
             $current_order_ids = explode(',', $order_ids_array[$index]);
             foreach ($current_order_ids as $order_id) {
                 if (!in_array($order_id, $depoGruplari[$depo_id]['order_ids'])) {
                     $depoGruplari[$depo_id]['order_ids'][] = $order_id;
                     
                     $order_number = $this->modelOrder
                         ->where('order_id', $order_id)
                         ->first()['order_no'] ?? null;
 
                     if ($order_number) {
                         $order_number = str_replace('DPG', '', $order_number);
                         if (!in_array($order_number, $depoGruplari[$depo_id]['order_numbers'])) {
                             $depoGruplari[$depo_id]['order_numbers'][] = $order_number;
                         }
                     }
                 }
             }
 
             // Satır verilerini ekle
             $depoGruplari[$depo_id]['satirlar'][] = [
                 'stock_id' => $stock_id,
                 'order_row_ids' => explode(',', $order_row_ids[$index]),
                 'order_ids' => $current_order_ids,
                 'stock_title' => $stock_titles[$index] ?? '',
                 'stock_code' => $stock_codes[$index] ?? '',
                 'stock_image' => $stock_images[$index] ?? null,
                 'depo_id' => $depo_id,
                 'stock_amount' => str_replace(',', '.', $stock_amounts[$index] ?? 1),
                 'unit_title' => $unit_titles[$index] ?? '',
                 'unit_price' => str_replace(',', '.', $unit_prices[$index] ?? 0),
                 'money_icon' => $money_icons[$index] ?? '₺',
                 'total_price' => str_replace(',', '.', $total_prices[$index] ?? 0)
             ];
 
             // Ara toplamı güncelle
             $depoGruplari[$depo_id]['ara_toplam'] += floatval(str_replace(',', '.', $total_prices[$index] ?? 0));
         }
 
         // Sonuçları döndür
         return $this->respond([
             'status' => 'success',
             'depoGruplari' => $depoGruplari
         ]);
 
     } catch (\Exception $e) {
         // Hata durumunda
         log_message('error', 'İRSALİYE KONTROL HATASI: ' . $e->getMessage());
         log_message('error', 'HATA KONUMU: ' . $e->getFile() . ':' . $e->getLine());
         log_message('error', 'STACK TRACE: ' . $e->getTraceAsString());
 
         return $this->respond([
             'status' => 'error',
             'message' => 'İrsaliye kontrolü sırasında bir hata oluştu: ' . $e->getMessage(),
             'error' => $e->getMessage(),
             'file' => $e->getFile(),
             'line' => $e->getLine()
         ]);
     }
 }

/*
   public function create()
    {
        try {
            $db = \Config\Database::connect($this->currentDB);
            $db->transStart();

            // İrsaliye verilerini al
            $order_ids = explode(',', $this->request->getPost('order_id'));
            $stock_ids = $this->request->getPost('stock_ids');
            $stock_titles = $this->request->getPost('stock_titles');
            $stock_codes = $this->request->getPost('stock_codes');
            $stock_images = $this->request->getPost('stock_images');
            $depo_ids = $this->request->getPost('depo_ids');
            $stock_amounts = $this->request->getPost('real_stock_amounts');
            $unit_titles = $this->request->getPost('unit_titles');
            $unit_prices = $this->request->getPost('unit_prices');
            $money_icons = $this->request->getPost('money_icons');
            $total_prices = $this->request->getPost('total_prices');
            $order_row_ids = $this->request->getPost('order_row_id');
            if (!is_array($stock_ids) || empty($stock_ids)) {
                throw new \Exception('En az bir ürün girişi yapılmalıdır.');
            }

       

            // Depolara göre satırları grupla
            $depoGruplari = [];

            foreach ($stock_ids as $index => $stock_id) {
                if (empty($stock_id) || empty($depo_ids[$index])) {
                    continue;
                }

                $depo_id = $depo_ids[$index];
                if (!isset($depoGruplari[$depo_id])) {
                    $depoGruplari[$depo_id] = [
                        'satirlar' => [],
                        'ara_toplam' => 0,
                        'order_ids' => []
                    ];
                }

                $stock_order_id = $this->modelOrderRow
                    ->where('stock_id', $stock_id)
                    ->where('stock_amount', str_replace(',', '.', $stock_amounts[$index]))
                    ->orderBy('created_at', 'DESC')
                    ->first()['order_id'] ?? null;

                if ($stock_order_id && !in_array($stock_order_id, $depoGruplari[$depo_id]['order_ids'])) {
                    $depoGruplari[$depo_id]['order_ids'][] = $stock_order_id;
                }

                $depoGruplari[$depo_id]['satirlar'][] = [
                    'stock_id' => $stock_id,
                    'order_satir_id' => $order_row_ids[$index],
                    'stock_title' => $stock_titles[$index],
                    'stock_code' => $stock_codes[$index],
                    'stock_image' => $stock_images[$index] ?? null,
                    'depo_id' => $depo_id,
                    'stock_amount' => str_replace(',', '.', $stock_amounts[$index]),
                    'unit_title' => $unit_titles[$index],
                    'unit_price' => str_replace(',', '.', $unit_prices[$index]),
                    'money_icon' => $money_icons[$index],
                    'total_price' => str_replace(',', '.', $total_prices[$index])
                ];

                $depoGruplari[$depo_id]['ara_toplam'] += floatval(str_replace(',', '.', $total_prices[$index]));
            }


            $created_irsaliye_ids = [];
            $trex_results = [];

            // Her depo için ayrı irsaliye oluştur
            foreach ($depoGruplari as $depo_id => $depo_grup) {
                $irsaliyeData = [
                    'order_id' => implode(',', $depo_grup['order_ids']),
                    'irsaliye_tarihi' => $this->request->getPost('irsaliye_tarihi'),
                    'irsaliye_saati' => $this->request->getPost('irsaliye_saati'),
                    'irsaliye_notu' => $this->request->getPost('irsaliye_notu'),
                    'depo_id' => $depo_id,
                    'ara_toplam' => $depo_grup['ara_toplam'],
                    'genel_toplam' => $depo_grup['ara_toplam'],
                    'status' => 'draft',
                    'created_by' => session()->get('user_id')
                ];

                if (!$this->irsaliyeModel->validate($irsaliyeData)) {
                    throw new \Exception('Validasyon hatası: ' . implode(', ', $this->irsaliyeModel->errors()));
                }

                $irsaliye_id = $this->irsaliyeModel->insert($irsaliyeData);
                if (!$irsaliye_id) {
                    throw new \Exception('İrsaliye kaydı oluşturulamadı.');
                }

                $created_irsaliye_ids[] = $irsaliye_id;

                foreach ($depo_grup['satirlar'] as $satir) {
                    $satirData = array_merge($satir, [
                        'irsaliye_id' => $irsaliye_id,
                        'created_by' => session()->get('user_id')
                    ]);

                    $satir_id = $this->irsaliyeSatirModel->insert($satirData);
                    if (!$satir_id) {
                        throw new \Exception('Satır eklenemedi.');
                    }
                }

                $updateData = [
                    'status' => 'active'
                ];

                if (!$this->irsaliyeModel->update($irsaliye_id, $updateData)) {
                    throw new \Exception('İrsaliye durumu güncellenemedi.');
                }

                // Trex'e göndermeyi dene
                $trex_result = $this->sendToTrex($irsaliye_id);
                $trex_results[$irsaliye_id] = $trex_result;
                //$trex_results[] = $trex_result;
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Veritabanı işlemi tamamlanamadı.');
            }

            // Başarılı ve başarısız Trex gönderimlerini kontrol et
            $success_count = 0;
            $failed_count = 0;
            foreach ($trex_results as $result) {
                if ($result['status'] === 'success') {
                    $success_count++;
                } else {
                    $failed_count++;
                }
            }

            $trex_message = '';
            if ($success_count > 0) {
                $trex_message .= $success_count . ' irsaliye Sysmond"a başarıyla gönderildi. ';
            }
            if ($failed_count > 0) {
                $trex_message .= $failed_count . ' irsaliye Sysmond"a gönderilemedi.';
            }

            return $this->respond([
                'status' => 'success',
                'message' => count($created_irsaliye_ids) . ' adet irsaliye başarıyla oluşturuldu. ' . $trex_message,
                'irsaliye_ids' => $created_irsaliye_ids,
                'trex_results' => $trex_results,
                'redirect' => base_url('tportal/irsaliye/list/all')
            ]);

        } catch (\Exception $e) {
            if (isset($db) && $db->transStatus() === false) {
                $db->transRollback();
            }
            log_message('error', '[Irsaliye::create] HATA DETAYI: ' . $e->getMessage());
            log_message('error', '[Irsaliye::create] Hata Konumu: ' . $e->getFile() . ':' . $e->getLine());
            log_message('error', '[Irsaliye::create] Stack Trace: ' . $e->getTraceAsString());
    
            

            return $this->respond([
                'status' => 'error',
                'message' => 'İrsaliye oluşturulurken bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }
        */


        // app/Controllers/TikoERP/Irsaliye.php

public function create()
{
    try {
        $db = \Config\Database::connect($this->currentDB);
        $db->transStart();

        $stock_ids = $this->request->getPost('stock_ids');
        $stock_titles = $this->request->getPost('stock_titles');
        $stock_codes = $this->request->getPost('stock_codes');
        $stock_images = $this->request->getPost('stock_images');
        $depo_ids = $this->request->getPost('depo_ids');
        $stock_amounts = $this->request->getPost('real_stock_amounts');
        $unit_titles = $this->request->getPost('unit_titles');
        $unit_prices = $this->request->getPost('unit_prices');
        $money_icons = $this->request->getPost('money_icons');
        $total_prices = $this->request->getPost('total_prices');
        
        // Yeni yapıya göre gelen veriler - array olarak alıp işleme
        $order_row_ids = $this->request->getPost('order_row_id'); // array olarak geliyor
        $order_ids_array = $this->request->getPost('order_ids'); // array olarak geliyor

        if (!is_array($stock_ids) || empty($stock_ids)) {
            throw new \Exception('En az bir ürün girişi yapılmalıdır.');
        }

        // Depolara göre satırları grupla
        $depoGruplari = [];

        foreach ($stock_ids as $index => $stock_id) {
            if (empty($stock_id) || empty($depo_ids[$index])) {
                continue;
            }

            $depo_id = $depo_ids[$index];
            if($depo_id == 1){
                $depo_id = 34;
            }

            if (!isset($depoGruplari[$depo_id])) {
                $depoGruplari[$depo_id] = [
                    'satirlar' => [],
                    'ara_toplam' => 0,
                    'order_ids' => [],
                    'order_numbers' => [],
                    'order_rows' => [] // Sipariş satırlarını takip etmek için
                ];
            }

            // Her bir order_id için sipariş numaralarını al
            if (!isset($order_ids_array[$index])) {
                continue; // Bu ürün için sipariş bilgisi yoksa atla
            }
            
            $current_order_ids = explode(',', $order_ids_array[$index]);
            $current_order_row_ids = explode(',', $order_row_ids[$index]);

            foreach ($current_order_ids as $order_id) {
                if (!in_array($order_id, $depoGruplari[$depo_id]['order_ids'])) {
                    $depoGruplari[$depo_id]['order_ids'][] = $order_id;
                    
                    $order_number = $this->modelOrder
                        ->where('order_id', $order_id)
                        ->first()['order_no'] ?? null;

                    if ($order_number) {
                        $order_number = str_replace('DPG', '', $order_number);
                        if (!in_array($order_number, $depoGruplari[$depo_id]['order_numbers'])) {
                            $depoGruplari[$depo_id]['order_numbers'][] = $order_number;
                        }
                    }
                }
            }

            // Sipariş satırlarını sakla
            foreach ($current_order_row_ids as $row_id) {
                if (!in_array($row_id, $depoGruplari[$depo_id]['order_rows'])) {
                    $depoGruplari[$depo_id]['order_rows'][] = $row_id;
                }
            }

            $depoGruplari[$depo_id]['satirlar'][] = [
                'stock_id' => $stock_id,
                'order_row_ids' => $current_order_row_ids,
                'order_ids' => $current_order_ids,
                'stock_title' => $stock_titles[$index],
                'stock_code' => $stock_codes[$index],
                'stock_image' => $stock_images[$index] ?? null,
                'depo_id' => $depo_id,
                'stock_amount' => str_replace(',', '.', $stock_amounts[$index]),
                'unit_title' => $unit_titles[$index],
                'unit_price' => str_replace(',', '.', $unit_prices[$index]),
                'money_icon' => $money_icons[$index],
                'total_price' => str_replace(',', '.', $total_prices[$index])
            ];

            $depoGruplari[$depo_id]['ara_toplam'] += floatval(str_replace(',', '.', $total_prices[$index]));
        }

        $created_irsaliye_ids = [];
        $trex_results = [];

        // Her depo için ayrı irsaliye oluştur
        foreach ($depoGruplari as $depo_id => $depo_grup) {
            $irsaliyeData = [
                'order_id' => implode(',', $depo_grup['order_ids']),
                'irsaliye_tarihi' => $this->request->getPost('irsaliye_tarihi'),
                'irsaliye_saati' => $this->request->getPost('irsaliye_saati'),
                'irsaliye_notu' => $this->request->getPost('irsaliye_notu'),
                'depo_id' => $depo_id,
                'ara_toplam' => $depo_grup['ara_toplam'],
                'genel_toplam' => $depo_grup['ara_toplam'],
                'status' => 'draft',
                'created_by' => session()->get('user_id')
            ];

            if (!$this->irsaliyeModel->validate($irsaliyeData)) {
                throw new \Exception('Validasyon hatası: ' . implode(', ', $this->irsaliyeModel->errors()));
            }

            $irsaliye_id = $this->irsaliyeModel->insert($irsaliyeData);
            if (!$irsaliye_id) {
                throw new \Exception('İrsaliye kaydı oluşturulamadı.');
            }

            $created_irsaliye_ids[] = $irsaliye_id;

            // İrsaliye satırlarını ekle
            foreach ($depo_grup['satirlar'] as $satir) {
                $satirData = array_merge($satir, [
                    'irsaliye_id' => $irsaliye_id,
                    'created_by' => session()->get('user_id')
                ]);

                $satir_id = $this->irsaliyeSatirModel->insert($satirData);
                if (!$satir_id) {
                    throw new \Exception('Satır eklenemedi.');
                }
            }

            // Sipariş satırlarını güncelle
          /*  foreach ($depo_grup['order_rows'] as $row_id) {
                $this->modelOrderRow->update($row_id, ['order_row_status' => 'sevk_edildi']);
            } */

            // Siparişleri güncelle
           /* foreach ($depo_grup['order_ids'] as $order_id) {
                // Siparişin tüm satırlarını kontrol et
                $all_rows = $this->modelOrderRow->where('order_id', $order_id)->findAll();
                $all_shipped = true;

                foreach ($all_rows as $row) {
                    if ($row['order_row_status'] !== 'sevk_edildi') {
                        $all_shipped = false;
                        break;
                    }
                }

                // Eğer tüm satırlar sevk edildiyse siparişi güncelle
                if ($all_shipped) {
                    $this->modelOrder->update($order_id, ['order_status' => 'sevk_edildi']);
                }
            } */

            $updateData = [
                'status' => 'active'
            ];

            if (!$this->irsaliyeModel->update($irsaliye_id, $updateData)) {
                throw new \Exception('İrsaliye durumu güncellenemedi.');
            }

            $trex_result = $this->sendToTrex($irsaliye_id);
            $trex_results[$irsaliye_id] = $trex_result;
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            throw new \Exception('Veritabanı işlemi tamamlanamadı.');
        }

        // Başarılı ve başarısız Trex gönderimlerini kontrol et
        $success_count = 0;
        $failed_count = 0;
        foreach ($trex_results as $result) {
            if ($result['status'] === 'success') {
                $success_count++;
            } else {
                $failed_count++;
            }
        }

        $trex_message = '';
        if ($success_count > 0) {
            $trex_message .= $success_count . ' irsaliye Sysmond"a başarıyla gönderildi. ';
        }
        if ($failed_count > 0) {
            $trex_message .= $failed_count . ' irsaliye Sysmond"a gönderilemedi.';
        }

        return $this->respond([
            'status' => 'success',
            'message' => count($created_irsaliye_ids) . ' adet irsaliye başarıyla oluşturuldu. ' . $trex_message,
            'irsaliye_ids' => $created_irsaliye_ids,
            'trex_results' => $trex_results,
            'redirect' => base_url('tportal/irsaliye/list/all')
        ]);

    } catch (\Exception $e) {
        if (isset($db) && $db->transStatus() === false) {
            $db->transRollback();
        }
        log_message('error', '[Irsaliye::create] HATA DETAYI: ' . $e->getMessage());
        log_message('error', '[Irsaliye::create] Hata Konumu: ' . $e->getFile() . ':' . $e->getLine());
        log_message('error', '[Irsaliye::create] Stack Trace: ' . $e->getTraceAsString());

        return $this->respond([
            'status' => 'error',
            'message' => 'İrsaliye oluşturulurken bir hata oluştu: ' . $e->getMessage()
        ]);
    }
}

    public function delete($id)
    {
        try {
            $db = \Config\Database::connect($this->currentDB);
            $db->transStart();

            // Önce irsaliye satırlarını sil
            $this->irsaliyeSatirModel->where('irsaliye_id', $id)->delete();

            // Sonra irsaliyeyi sil
            $this->irsaliyeModel->delete($id);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('İrsaliye silinemedi.');
            }

            return $this->respond([
                'status' => 'success',
                'message' => 'İrsaliye başarıyla silindi.'
            ]);

        } catch (\Exception $e) {
            if (isset($db) && $db->transStatus() === false) {
                $db->transRollback();
            }
            log_message('error', '[Irsaliye::delete] Hata: ' . $e->getMessage());
            return $this->respond([
                'status' => 'error',
                'message' => 'İrsaliye silinirken bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }


    public function resendSysmond()
    {

      
        $id = $this->request->getPost('id');

        $irsaliye = $this->irsaliyeModel->find($id);
        if (!$irsaliye) {
            return $this->respond([
                'status' => 'error',
                'message' => 'İrsaliye bulunamadı.'
            ]);
        }
        $trex_result = $this->sendToTrex($irsaliye['id']);
        


        if ($trex_result['status'] === 'success') {
            return $this->respond([
                'status' => 'success',
                'message' => 'İrsaliye Sysmond"a başarıyla gönderildi.' 
            ]);
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => $irsaliye['irsaliye_no'] . ' -  ' . $trex_result['message']  
            ]); 
        }
    }

    public function getIrsaliye($id)
    {
        try {
            $irsaliye = $this->irsaliyeModel->find($id);
            if (!$irsaliye) {
                throw new \Exception('İrsaliye bulunamadı.');
            }

            $satirlar = $this->irsaliyeSatirModel
                ->where('irsaliye_id', $id)
                ->findAll();

            return $this->respond([
                'status' => 'success',
                'irsaliye' => $irsaliye,
                'satirlar' => $satirlar
            ]);

        } catch (\Exception $e) {
            log_message('error', '[Irsaliye::getIrsaliye] Hata: ' . $e->getMessage());
            return $this->respond([
                'status' => 'error',
                'message' => 'İrsaliye bilgileri alınırken bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }

    public function list($type = 'all')
    {
        // Tüm irsaliyeleri getir (görüntüleme için)
        $irsaliyeler = $this->irsaliyeModel
            ->where('irsaliyeler.deleted_at IS NULL')
            ->orderBy('irsaliyeler.created_at', 'DESC')
            ->findAll();
    
        if ($type == 'all') {
            $page_title = "Tüm İrsaliyeler";
        } else {
            return redirect()->back();
        }
    
        // İstatistikleri hesapla
        $statistics = [
            'total_invoices' => 0,      // Toplam irsaliye
            'total_orders' => 0,        // Toplam benzersiz sipariş
            'total_products' => 0,      // Toplam ürün çeşidi
            'total_quantity' => 0,      // Toplam miktar
            'total_amount' => 0         // Toplam tutar
        ];
    
        $processed_products = []; // Tekrar eden ürünleri saymamak için
        $processed_orders = [];   // Tekrar eden siparişleri saymamak için
        
        // Bugünün tarihini al
        $today = date('Y-m-d');
        
        // sysmond_id = 0 olan irsaliyeleri ayrı tut
        $sysmond_zero_irsaliyeler = [];
        $sysmond_zero_count = 0;
    
        foreach ($irsaliyeler as &$irsaliye) {
            // sysmond_id = 0 olan irsaliyeleri ayrı tut
            if ($irsaliye['sysmond_id'] == 0 && $irsaliye['sysmond_id'] !== null && $irsaliye['sysmond_id'] !== '') {
                $sysmond_zero_irsaliyeler[] = $irsaliye;
                $sysmond_zero_count++;
            }
            
            // Sadece bugünün irsaliyelerini say
            $irsaliye_date = date('Y-m-d', strtotime($irsaliye['irsaliye_tarihi']));
            
            if ($irsaliye_date === $today) {
                $statistics['total_invoices']++;
                
                // Sipariş sayısını hesapla (benzersiz siparişleri say)
                $order_ids = explode(',', $irsaliye['order_id']);
                foreach ($order_ids as $order_id) {
                    $order_id = trim($order_id); // Boşlukları temizle
                    if (!empty($order_id) && !isset($processed_orders[$order_id])) {
                        $processed_orders[$order_id] = true;
                        $statistics['total_orders']++;
                    }
                }
    
                // İrsaliye satırlarını al
                $irsaliye['satirlar'] = $this->irsaliyeSatirModel
                    ->where('irsaliye_id', $irsaliye['id'])
                    ->where('deleted_at IS NULL')
                    ->findAll();
    
                // Satır istatistiklerini hesapla
                foreach ($irsaliye['satirlar'] as $satir) {
                    // Benzersiz ürün sayısı için
                    if (!isset($processed_products[$satir['stock_id']])) {
                        $processed_products[$satir['stock_id']] = true;
                        $statistics['total_products']++;
                    }
    
                    $statistics['total_quantity'] += $satir['stock_amount'];
                    $statistics['total_amount'] += $satir['total_price'];
                }
            }
            
            // Tüm irsaliyelerin satırlarını göstermek için
            $irsaliye['satirlar'] = $this->irsaliyeSatirModel
                ->where('irsaliye_id', $irsaliye['id'])
                ->where('deleted_at IS NULL')
                ->findAll();
        }
    
      
        $data = [
            'page_title' => $page_title,
            'irsaliyeler' => $irsaliyeler,
            'irsaliye_count' => count($irsaliyeler),
            'statistics' => $statistics,
            'today' => $today, // View'da kullanmak için bugünün tarihini de gönderelim
            'sysmond_zero_irsaliyeler' => $sysmond_zero_irsaliyeler, // sysmond_id = 0 olan irsaliyeler
            'sysmond_zero_count' => $sysmond_zero_count // sysmond_id = 0 olan irsaliye sayısı
        ];
    
        return view('tportal/faturalar/irsaliye/index', $data);
    }
    use ResponseTrait;
    public function getIrsaliyeList($type = 'all')
    {
        $builder = $this->irsaliyeModel
            ->select('irsaliyeler.id, irsaliyeler.order_id, irsaliyeler.irsaliye_no, irsaliyeler.irsaliye_tarihi, 
                     irsaliyeler.irsaliye_saati, irsaliyeler.irsaliye_notu, irsaliyeler.depo_id, 
                     irsaliyeler.ara_toplam, irsaliyeler.genel_toplam, irsaliyeler.status, 
                     irsaliyeler.sysmond_id, irsaliyeler.created_at, irsaliyeler.updated_at')
            ->where('irsaliyeler.deleted_at IS NULL')
            ->orderBy('irsaliyeler.created_at', 'DESC');

        // sysmond_zero_only filtresi
        if ($this->request->getPost('sysmond_zero_only')) {
            $builder->where('sysmond_id', 0);
        }

        if ($type == 'all') {
            $builder = $builder;
        } else {
            return redirect()->back();
        }

        return DataTable::of($builder)
            ->filter(function ($builder, $request) {
                if (!empty($request->irsaliye_date_start) && !empty($request->irsaliye_date_end)) {
                    try {
                        $start_date = DateTime::createFromFormat('d/m/Y', $request->irsaliye_date_start)->format('Y-m-d');
                        $end_date = DateTime::createFromFormat('d/m/Y', $request->irsaliye_date_end)->format('Y-m-d');
                        $builder->where('DATE(irsaliyeler.irsaliye_tarihi) >=', $start_date)
                               ->where('DATE(irsaliyeler.irsaliye_tarihi) <=', $end_date);
                    } catch (\Exception $e) {
                        // Tarih dönüştürme hatası durumunda filtreleme yapma
                    }
                }
            })
            ->add('depo_adi', function($row) {
                return $this->getDepoAdi($row->depo_id);
            }, 'last')
            ->setSearchableColumns(['irsaliyeler.irsaliye_no'])
            ->toJson(true);
    }

    public function detail($id){
        $invoice_item = $this->irsaliyeModel->find($id);
        $invoice_item['depo_adi'] = $this->getDepoAdi($invoice_item['depo_id']);
        $invoice_rows = $this->irsaliyeSatirModel->where('irsaliye_id', $id)->findAll();
        
        // Sipariş ID'lerini virgülle ayrılmış string'den array'e çeviriyoruz
        $order_ids = explode(',', $invoice_item['order_id']);
        
        // İstatistikleri hesapla
        $statistics = [
            'total_orders' => count($order_ids), // Toplam sipariş sayısı
            'total_products' => 0,               // Toplam ürün çeşidi
            'total_quantity' => 0,               // Toplam miktar
            'total_amount' => 0                  // Toplam tutar
        ];
        
        foreach($invoice_rows as $row) {
            $statistics['total_products']++;
            $statistics['total_quantity'] += $row['stock_amount'];
            $statistics['total_amount'] += $row['total_price'];
        }
        
        $data = [
            'page_title' => 'İrsaliye Detayları',
            'invoice_item' => $invoice_item,
            'invoice_rows' => $invoice_rows,
            'statistics' => $statistics
        ];
        
        return view('tportal/faturalar/irsaliye/detail', $data);
    }

    protected function getDepoAdi($depo_id)
    {
        $depolar = $this->sysmondDepolarModel->findAll();
        
        foreach ($depolar as $depo) {
            if ($depo['depo_1_id'] == $depo_id) return $depo['depo_1'];
            if ($depo['depo_2_id'] == $depo_id) return $depo['depo_2'];
            if ($depo['depo_3_id'] == $depo_id) return $depo['depo_3'];
            if ($depo['depo_4_id'] == $depo_id) return $depo['depo_4'];
        }
        
        return 'Bilinmeyen Depo';
    }

    protected function sendToTrex($irsaliye_id)
    {
       try {
            // İrsaliye bilgilerini al
            $irsaliye = $this->irsaliyeModel->find($irsaliye_id);
            if (!$irsaliye) {
                return [
                    'status' => 'error',
                    'message' => 'İrsaliye bulunamadı.'
                ];
            }

            // İrsaliye satırlarını al
            $satirlar = $this->irsaliyeSatirModel->where('irsaliye_id', $irsaliye_id)->findAll();
            if (empty($satirlar)) {
                return [
                    'status' => 'error',
                    'message' => 'İrsaliye satırları bulunamadı.'
                ];
            }

            // DeliveryItemList oluştur
            $deliveryItems = [];
            foreach ($satirlar as $satir) {
                $deliveryItems[] = [
                    "StockNo" => $satir['stock_code'],
                    "Quantity" => (float)$satir['stock_amount'],
                    "Quantity2" => 0,
                    "Quantity3" => 0,
                    "Price" => (float)$satir['unit_price'],
                    "LotId" => 0,
                    "Description" => $satir['stock_title'],
                    "Status" => 2,
                    "Vat" => 20,
                    "Discount1" => 0,
                    "Discount2" => 0,
                    "Discount3" => 0,
                    "Discount4" => 0,
                    "Discount5" => 0,
                    "Discount6" => 0,
                    "VatInOut" => true,
                    "CurrCode" => 0,
                    "CurrPrice" => (float)$satir['unit_price'],
                    "CurrExc" => 1,
                    "UnitName" => $satir['unit_title']
                ];
            }
            $depot_no = "002";
            if($irsaliye['depo_id'] == 34 ){
                $depot_no = "2";
            }else if($irsaliye['depo_id'] == 33 ){
                $depot_no = "1";
            } else if($irsaliye['depo_id'] == 2 ){
                $depot_no = "2";
            } else if($irsaliye['depo_id'] == 1 ){
                $depot_no = "2";
            } else if($irsaliye['depo_id'] == 3 ){
                $depot_no = "2";
            }  else if($irsaliye['depo_id'] == 4 ){
                $depot_no = "2";
            } else{
                $depot_no = "2";
            }


         

            // API isteği için veriyi hazırla
            $postData = [
                "newDelivery" => [
                    "ApiKey" => "1503279683",
                    "ReceiptNo" => $irsaliye['irsaliye_no'],
                    "DeliveryType" => 102,
                    "TransCode" => "",
                    "ActNo" => "CRK-0030-516",
                    "TransDate" => date('d.m.Y', strtotime($irsaliye['irsaliye_tarihi'])),
                    "DeliveryStatus" => 2,
                    "CompanyId" => 56,
                    "Cperiodid" => 57,
                    "EmployeeNo" => "",
                    "Ettn" => "",
                    "CurrCode" => 0,
                    "CurrExc" => 1,
                    "ReceiptTypeId" => 34,
                    "GroupCode" => "",
                    "SpecCode1" => "",
                    "SpecCode2" => "",
                    "Description" => $irsaliye['irsaliye_notu'] ?? "",
                    "Description1" => "",
                    "Description2" => "",
                    "DepotNo" => $depot_no,
                    "DefDrvName" => "",
                    "DefDrvSurName" => "",
                    "DefDrvTCNO" => "",
                    "DocumnetNot" => "",
                    "Plaka" => "",
                    "Address" => [
                        "Address1" => "adres1",
                        "Address2" => "adres2",
                        "Address3" => "adres3",
                        "AddressType" => 3004,
                        "PostalCode" => "",
                        "City" => "Bursa",
                        "Town" => "Nilüfer",
                        "Country" => "Türkiye",
                        "Phone1" => "5305555555",
                        "Gsm" => "5305555555",
                        "Email" => "developer@tiko.com.tr",
                        "Web" => ""
                    ],
                    "Receiver_Name" => "Tiko Yazılım",
                    "Receiver_Taxno" => "",
                    "Receiver_Email" => "developer@tiko.com.tr",
                    "Receiver_Phone" => "05366455320",
                    "Receiver_Gsm" => "05366455320",
                    "Receiver_Address1" => "",
                    "Receiver_Address2" => "",
                    "Receiver_PostCode" => "",
                    "Receiver_Town" => "",
                    "Receiver_City" => "Bursa",
                    "Receiver_Region" => "",
                    "Receiver_State" => "",
                    "Receiver_Country" => "Türkiye",
                    "Receiver_gibetiket" => "",
                    "isnetsale" => true,
                    "paymentmeanscode" => 0,
                    "instructionnote" => "",
                    "paymentduedate" => "",
                    "paymentcannelcode" => "",
                    "DeliveryItemList" => $deliveryItems
                ]
            ];

            // CURL isteğini hazırla
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'http://85.105.220.154:8640/TrexIntegrationService/REST/AddDelivery',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($postData),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Accept: application/json'
                ]
            ]);

            // İsteği gönder ve yanıtı al
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                return [
                    'status' => 'error',
                    'message' => 'CURL Hatası: ' . $err
                ];
            }

            // Yanıtı decode et
            $result = json_decode($response, true);

      
      

            // Başarılı yanıt kontrolü ve sysmond_id güncelleme
            if (!isset($result['Message'])) {
                $updateData = [
                    'sysmond_id' => $result
                ];
                
                if (!$this->irsaliyeModel->update($irsaliye_id, $updateData)) {
                    return [
                        'status' => 'error',
                        'message' => 'Sysmond ID güncellenemedi.'
                    ];
                }

                return [
                    'status' => 'success',
                    'message' => 'İrsaliye Sysmond"a başarıyla gönderildi ve Sysmond ID güncellendi.',
                    'response' => $result
                ];
            }

            return [
                'status' => 'error',
                'message' => isset($result['Message']) ? $result['Message'] : 'Sysmond İrsaliye Sırasında Hata Oluştu',
                'response' => $result
            ];

        } catch (\Exception $e) {
            log_message('error', '[Irsaliye::sendToTrex] Hata: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'İrsaliye Trex sistemine gönderilirken bir hata oluştu: ' . $e->getMessage()
            ];
        }

       
        
    }

   

} 
