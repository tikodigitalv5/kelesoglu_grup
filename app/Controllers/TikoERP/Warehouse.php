<?php

namespace App\Controllers\TikoERP;
use App\Controllers\BaseController;
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;

/**
 * @property IncomingRequest $request 
 */


class Warehouse extends BaseController{
    private $DatabaseConfig;
    private $currentDB;
    
    private $modelWarehouse;
    private $logClass;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelWarehouse = model($TikoERPModelPath.'\WarehouseModel', true, $db_connection);

        $this->logClass = new Log();

        helper('Helpers\number_format_helper');

    }

    public function list(){

        $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();

        $data = [
            'warehouse_items' => $warehouse_items,
        ];

        return view('tportal/stoklar/depolar/index', $data);
    }

    public function create(){

        if($this->request->getMethod('true') == 'POST'){
            try {
                $warehouse_title = $this->request->getPost('warehouse_title');
                $warehouse_value = $this->request->getPost('warehouse_value');
                $status = $this->request->getPost('status');
                $order = $this->request->getPost('order');
                $default = $this->request->getPost('default');

                $form_data = [
                    'user_id' => session()->get('user_id'),
                    'warehouse_title' => $warehouse_title,
                    'warehouse_value' => $warehouse_value,
                    'status' => $status,
                    'order' => $order,
                    'default' => 'false'
                ];

                if($default){
                    $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('default', 'true')->findAll();
                    foreach($warehouse_items as $warehouse_item){
                        $this->modelWarehouse->update($warehouse_item['warehouse_id'], ['default' => 'false']);
                    }

                    $form_data['default'] = 'true';
                }

                $this->modelWarehouse->insert($form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Depo başarıyla eklendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'warehouse',
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
        $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();

        echo json_encode(['warehouse_items'=> $warehouse_items]);
        return;
    }

    public function edit(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $warehouse_id = $this->request->getPost('warehouse_id');
                $warehouse_title = $this->request->getPost('warehouse_title');
                $warehouse_value = $this->request->getPost('warehouse_value');
                $order = $this->request->getPost('order');

                $warehouse_item = $this->modelWarehouse->where('warehouse_id', $warehouse_id)->where('user_id', session()->get('user_id'))->first();
                if(!$warehouse_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen depo bulunamadı.']);
                    return;
                }

                $form_data = [
                    'warehouse_title' => $warehouse_title,
                    'warehouse_value' => $warehouse_value,
                    'order' => $order
                ];

                $this->modelWarehouse->update($warehouse_id, $form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Depo başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'warehouse',
                    $warehouse_id,
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
                $warehouse_id = $this->request->getPost('warehouse_id');
                $status = $this->request->getPost('status');

                $warehouse_item = $this->modelWarehouse->where('warehouse_id', $warehouse_id)->where('user_id', session()->get('user_id'))->first();
                if(!$warehouse_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen depo bulunamadı.']);
                    return;
                }

                $this->modelWarehouse->update($warehouse_id, ['status' => $status]);

                echo json_encode(['icon'=> 'success', 'message' => 'Depo başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'warehouse',
                    $warehouse_id,
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
                $warehouse_id = $this->request->getPost('warehouse_id');

                $warehouse_item = $this->modelWarehouse->where('warehouse_id', $warehouse_id)->where('user_id', session()->get('user_id'))->first();
                if(!$warehouse_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen depo bulunamadı.']);
                    return;
                }

                $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('default', 'true')->findAll();
                
                foreach($warehouse_items as $warehouse_item){
                    $this->modelWarehouse->update($warehouse_item['warehouse_id'], ['default' => 'false']);
                }
                $this->modelWarehouse->update($warehouse_id, ['default' => 'true']);

                echo json_encode(['icon'=> 'success', 'message' => 'Depo başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'warehouse',
                    $warehouse_id,
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
                $warehouse_id = $this->request->getPost('warehouse_id');

                $warehouse_item = $this->modelWarehouse->where('warehouse_id', $warehouse_id)->where('user_id', session()->get('user_id'))->first();
                if(!$warehouse_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen depo bulunamadı.']);
                    return;
                }

                $this->modelWarehouse->delete($warehouse_id);

                echo json_encode(['icon'=> 'success', 'message' => 'Depo başarıyla silindi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'warehouse',
                    $warehouse_id,
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