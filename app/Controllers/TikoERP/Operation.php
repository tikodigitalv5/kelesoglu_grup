<?php

namespace App\Controllers\TikoERP;
use App\Controllers\BaseController;
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoERP\OperationModel;

/**
 * @property IncomingRequest $request 
 */


class Operation extends BaseController{
    private $DatabaseConfig;
    private $currentDB;
    
    private $modelOperation;
    private $logClass;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelOperation = model($TikoERPModelPath.'\OperationModel', true, $db_connection);

        $this->logClass = new Log();
        
        helper('Helpers\number_format_helper');

    }

    public function list()
    {
        // Sayfalama için değişkenler
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10000; // Her sayfada 10 kayıt gösterilecek
    
        // Toplam kayıt sayısını al
        $total = $this->modelOperation
            ->where('user_id', session()->get('user_id'))
            ->countAllResults();
    
        // Sayfalı veriyi al
        $operation_items = $this->modelOperation
            ->where('user_id', session()->get('user_id'))
            ->orderBy('order', 'ASC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->findAll();
    
        // Sayfalama bilgilerini hazırla
        $pager = [
            'totalPages' => ceil($total / $perPage),
            'currentPage' => $page,
            'perPage' => $perPage,
            'total' => $total
        ];
    
        $data = [
            'operation_items' => $operation_items,
            'pager' => $pager
        ];
    
        return view('tportal/stoklar/operasyonlar/index', $data);
    }



    public function create(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $operation_title = $this->request->getPost('operation_title');
                $operation_value = $this->request->getPost('operation_value');
                $status = $this->request->getPost('status');
                $order = $this->request->getPost('order');
                $default = $this->request->getPost('default');
    
                // Aynı isimde operasyon var mı kontrol et
                $existingOperation = $this->modelOperation
                    ->where('user_id', session()->get('user_id'))
                    ->where('operation_title', $operation_title)
                    ->first();
    
                if ($existingOperation) {
                    echo json_encode([
                        'icon' => 'error', 
                        'message' => 'Bu operasyon adı zaten kullanılıyor. Lütfen farklı bir isim giriniz.'
                    ]);
                    return;
                }
    
                $form_data = [
                    'user_id' => session()->get('user_id'),
                    'operation_title' => $operation_title,
                    'operation_value' => $operation_value,
                    'status' => $status,
                    'order' => $order,
                    'default' => 'false'
                ];
    
                if($default){
                    $operation_items = $this->modelOperation
                        ->where('user_id', session()->get('user_id'))
                        ->where('default', 'true')
                        ->findAll();
                        
                    foreach($operation_items as $operation_item){
                        $this->modelOperation->update($operation_item['operation_id'], ['default' => 'false']);
                    }
    
                    $form_data['default'] = 'true';
                }
    
                $this->modelOperation->insert($form_data);
    
                echo json_encode(['icon'=> 'success', 'message' => 'Operasyon başarıyla eklendi.']);
                return;
            } catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'operation',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    public function listLoad(){
        $operation_items = $this->modelOperation->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();

        echo json_encode(['operation_items'=> $operation_items]);
        return;
    }

    public function edit(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $operation_id = $this->request->getPost('operation_id');
                $operation_title = $this->request->getPost('operation_title');
                $operation_value = $this->request->getPost('operation_value');
                $order = $this->request->getPost('order');

                $operation_item = $this->modelOperation->where('operation_id', $operation_id)->where('user_id', session()->get('user_id'))->first();
                if(!$operation_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen operasyon bulunamadı.']);
                    return;
                }

                $form_data = [
                    'operation_title' => $operation_title,
                    'operation_value' => $operation_value,
                    'order' => $order
                ];

                $this->modelOperation->update($operation_id, $form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Operasyon başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'operation',
                    $operation_id,
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
                $operation_id = $this->request->getPost('operation_id');
                $status = $this->request->getPost('status');

                $operation_item = $this->modelOperation->where('operation_id', $operation_id)->where('user_id', session()->get('user_id'))->first();
                if(!$operation_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen operasyon bulunamadı.']);
                    return;
                }

                $this->modelOperation->update($operation_id, ['status' => $status]);

                echo json_encode(['icon'=> 'success', 'message' => 'Operasyon başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'operation',
                    $operation_id,
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
                $operation_id = $this->request->getPost('operation_id');

                $operation_item = $this->modelOperation->where('operation_id', $operation_id)->where('user_id', session()->get('user_id'))->first();
                if(!$operation_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen operasyon bulunamadı.']);
                    return;
                }

                $operation_items = $this->modelOperation->where('user_id', session()->get('user_id'))->where('default', 'true')->findAll();
                
                foreach($operation_items as $operation_item){
                    $this->modelOperation->update($operation_item['operation_id'], ['default' => 'false']);
                }
                $this->modelOperation->update($operation_id, ['default' => 'true']);

                echo json_encode(['icon'=> 'success', 'message' => 'Operasyon başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'operation',
                    $operation_id,
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
                $operation_id = $this->request->getPost('operation_id');

                $operation_item = $this->modelOperation->where('operation_id', $operation_id)->where('user_id', session()->get('user_id'))->first();
                if(!$operation_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen operasyon bulunamadı.']);
                    return;
                }

                $this->modelOperation->delete($operation_id);

                echo json_encode(['icon'=> 'success', 'message' => 'Operasyon başarıyla silindi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'operation',
                    $operation_id,
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