<?php

namespace App\Controllers\TikoERP;
use App\Controllers\BaseController;
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;

class OperationResource extends BaseController {
    private $DatabaseConfig;
    private $currentDB;
    private $modelOperationResource;
    private $logClass;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';
        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();
        $db_connection = \Config\Database::connect($this->currentDB);
        $this->modelOperationResource = model($TikoERPModelPath.'\OperationResource', true, $db_connection);
        $this->logClass = new Log();
           
        helper('Helpers\number_format_helper');
    }

    public function list()
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;
        $type = $this->request->getVar('type') ?? 'kisi';

        $total = $this->modelOperationResource
            ->where('resource_type', $type)
            ->countAllResults();

        $resources = $this->modelOperationResource
            ->where('resource_type', $type)
            ->orderBy('name', 'ASC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->findAll();

        $pager = [
            'totalPages' => ceil($total / $perPage),
            'currentPage' => $page,
            'perPage' => $perPage,
            'total' => $total
        ];

        $data = [
            'resources' => $resources,
            'pager' => $pager,
            'current_type' => $type
        ];

        return view('tportal/stoklar/operasyonlar/resources/index', $data);
    }

    public function create()
    {
        if($this->request->getMethod('true') == 'POST'){
            try {
                $name = $this->request->getPost('name');
                $type = $this->request->getPost('resource_type');
                
                // Aynı isimde kaynak var mı kontrol et
                $existing = $this->modelOperationResource
                    ->where('name', $name)
                    ->where('resource_type', $type)
                    ->first();

                if ($existing) {
                    echo json_encode([
                        'icon' => 'error', 
                        'message' => 'Bu isimde kaynak zaten mevcut. Lütfen farklı bir isim giriniz.'
                    ]);
                    return;
                }

                $form_data = [
                    'name' => $name,
                    'resource_type' => $type,
                    'status' => 'active'
                ];

                $this->modelOperationResource->insert($form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Kaynak başarıyla eklendi.']);
                return;
            } catch(\Exception $e) {
                $this->logClass->save_log('error', 'operation_resource', null, null, 'create', $e->getMessage(), json_encode($_POST));
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }
        }
        return redirect()->back();
    }

    public function edit()
    {
        if($this->request->getMethod('true') == 'POST'){
            try {
                $id = $this->request->getPost('id');
                $name = $this->request->getPost('name');
                
                $resource = $this->modelOperationResource->find($id);
                if(!$resource){
                    echo json_encode(['icon'=> 'error', 'message' => 'Kaynak bulunamadı.']);
                    return;
                }

                $this->modelOperationResource->update($id, ['name' => $name]);

                echo json_encode(['icon'=> 'success', 'message' => 'Kaynak başarıyla güncellendi.']);
                return;
            } catch(\Exception $e) {
                $this->logClass->save_log('error', 'operation_resource', $id, null, 'edit', $e->getMessage(), json_encode($_POST));
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }
        }
        return redirect()->back();
    }

    public function delete()
    {
        if($this->request->getMethod('true') == 'POST'){
            try {
                $id = $this->request->getPost('id');

                $resource = $this->modelOperationResource->find($id);
                if(!$resource){
                    echo json_encode(['icon'=> 'error', 'message' => 'Kaynak bulunamadı.']);
                    return;
                }

                $this->modelOperationResource->delete($id);

                echo json_encode(['icon'=> 'success', 'message' => 'Kaynak başarıyla silindi.']);
                return;
            } catch(\Exception $e) {
                $this->logClass->save_log('error', 'operation_resource', $id, null, 'delete', $e->getMessage(), json_encode($_POST));
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }
        }
        return redirect()->back();
    }
}