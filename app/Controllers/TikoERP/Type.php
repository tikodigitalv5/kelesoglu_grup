<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoERP\TypeModel;

/**
 * @property IncomingRequest $request 
 */

class Type extends BaseController{
    private $DatabaseConfig;
    private $currentDB;

    private $modelType;
    private $logClass;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelType = model($TikoERPModelPath.'\TypeModel', true, $db_connection);

        $this->logClass = new Log();
        helper('Helpers\number_format_helper');

    }

    public function list(){

        $type_items = $this->modelType->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();

        $data = [
            'type_items' => $type_items,
        ];

        return view('tportal/stoklar/tipler/index', $data);
    }

    public function create(){

        if($this->request->getMethod('true') == 'POST'){
            try {
                $type_title = $this->request->getPost('type_title');
                $type_value = $this->request->getPost('type_value');
                $status = $this->request->getPost('status');
                $order = $this->request->getPost('order');
                $default = $this->request->getPost('default');

                $form_data = [
                    'user_id' => session()->get('user_id'),
                    'type_title' => $type_title,
                    'type_value' => $type_value,
                    'status' => $status,
                    'order' => $order,
                    'default' => 'false'
                ];

                if($default == 'on'){
                    $type_items = $this->modelType->where('user_id', session()->get('user_id'))->where('default', 'true')->findAll();
                    foreach($type_items as $type_item){
                        $this->modelType->update($type_item['type_id'], ['default' => 'false']);
                    }
                    $form_data['default'] = 'true';
                }
                $this->modelType->insert($form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Tip başarıyla eklendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'type',
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
        $type_items = $this->modelType->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();

        echo json_encode(['type_items'=> $type_items]);
        return;
    }

    public function edit(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $type_id = $this->request->getPost('type_id');
                $type_title = $this->request->getPost('type_title');
                $type_value = $this->request->getPost('type_value');
                $order = $this->request->getPost('order');

                $type_item = $this->modelType->where('type_id', $type_id)->where('user_id', session()->get('user_id'))->first();
                if(!$type_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen tip bulunamadı.']);
                    return;
                }

                $form_data = [
                    'type_title' => $type_title,
                    'type_value' => $type_value,
                    'order' => $order
                ];

                $this->modelType->update($type_id, $form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Tip başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'type',
                    $type_id,
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
                $type_id = $this->request->getPost('type_id');
                $status = $this->request->getPost('status');

                $type_item = $this->modelType->where('type_id', $type_id)->where('user_id', session()->get('user_id'))->first();
                if(!$type_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen tip bulunamadı.']);
                    return;
                }

                $this->modelType->update($type_id, ['status' => $status]);

                echo json_encode(['icon'=> 'success', 'message' => 'Tip başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'type',
                    $type_id,
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
                $type_id = $this->request->getPost('type_id');

                $type_item = $this->modelType->where('type_id', $type_id)->where('user_id', session()->get('user_id'))->first();
                if(!$type_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen tip bulunamadı.']);
                    return;
                }

                $type_items = $this->modelType->where('user_id', session()->get('user_id'))->where('default', 'true')->findAll();
                foreach($type_items as $type_item){
                    $this->modelType->update($type_item['type_id'], ['default' => 'false']);
                }

                $this->modelType->update($type_id, ['default' => 'true']);

                echo json_encode(['icon'=> 'success', 'message' => 'Tip başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'type',
                    $type_id,
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
                $type_id = $this->request->getPost('type_id');

                $type_item = $this->modelType->where('type_id', $type_id)->where('user_id', session()->get('user_id'))->first();
                if(!$type_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen tip bulunamadı.']);
                    return;
                }

                $this->modelType->delete($type_id);

                echo json_encode(['icon'=> 'success', 'message' => 'Tip başarıyla silindi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'type',
                    $type_id,
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