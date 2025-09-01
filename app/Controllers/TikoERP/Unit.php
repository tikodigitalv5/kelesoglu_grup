<?php

namespace App\Controllers\TikoERP;
use App\Controllers\BaseController;
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoERP\UnitModel;

/**
 * @property IncomingRequest $request 
 */


class Unit extends BaseController{
    private $DatabaseConfig;
    private $currentDB;

    private $modelUnit;
    private $logClass;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelUnit = model($TikoERPModelPath.'\UnitModel', true, $db_connection);
        $this->logClass = new Log();

        helper('Helpers\number_format_helper');

    }

    public function list(){

        $unit_items = $this->modelUnit->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();

        $data = [
            'unit_items' => $unit_items,
        ];

        return view('tportal/stoklar/birimler/index', $data);
    }

    public function create(){

        if($this->request->getMethod('true') == 'POST'){
            try {
                $unit_title = $this->request->getPost('unit_title');
                $unit_value = $this->request->getPost('unit_value');
                $status = $this->request->getPost('status');
                $order = $this->request->getPost('order');
                $default = $this->request->getPost('default');

                $form_data = [
                    'user_id' => session()->get('user_id'),
                    'unit_title' => $unit_title,
                    'unit_value' => $unit_value,
                    'status' => $status,
                    'order' => $order,
                    'default' => 'false'
                ];

                if($default){
                    $unit_items = $this->modelUnit->where('user_id', session()->get('user_id'))->where('default', 'true')->findAll();
                    foreach($unit_items as $unit_item){
                        $this->modelUnit->update($unit_item['unit_id'], ['default' => 'false']);
                    }

                    $form_data['default'] = 'true';
                }

                $this->modelUnit->insert($form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Birim başarıyla eklendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'unit',
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
        $unit_items = $this->modelUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();

        echo json_encode(['unit_items'=> $unit_items]);
        return;
    }

    public function edit(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $unit_id = $this->request->getPost('unit_id');
                $unit_title = $this->request->getPost('unit_title');
                $unit_value = $this->request->getPost('unit_value');
                $order = $this->request->getPost('order');

                $unit_item = $this->modelUnit->where('unit_id', $unit_id)->where('user_id', session()->get('user_id'))->first();
                if(!$unit_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen birim bulunamadı.']);
                    return;
                }

                $form_data = [
                    'unit_title' => $unit_title,
                    'unit_value' => $unit_value,
                    'order' => $order
                ];

                $this->modelUnit->update($unit_id, $form_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Birim başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'unit',
                    $unit_id,
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
                $unit_id = $this->request->getPost('unit_id');
                $status = $this->request->getPost('status');

                $unit_item = $this->modelUnit->where('unit_id', $unit_id)->where('user_id', session()->get('user_id'))->first();
                if(!$unit_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen birim bulunamadı.']);
                    return;
                }

                $this->modelUnit->update($unit_id, ['status' => $status]);

                echo json_encode(['icon'=> 'success', 'message' => 'Birim başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'unit',
                    $unit_id,
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
                $unit_id = $this->request->getPost('unit_id');

                $unit_item = $this->modelUnit->where('unit_id', $unit_id)->where('user_id', session()->get('user_id'))->first();
                if(!$unit_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen birim bulunamadı.']);
                    return;
                }

                $unit_items = $this->modelUnit->where('user_id', session()->get('user_id'))->where('default', 'true')->findAll();
                foreach($unit_items as $unit_item){
                    $this->modelUnit->update($unit_item['unit_id'], ['default' => 'false']);
                }

                $this->modelUnit->update($unit_id, ['default' => 'true']);

                echo json_encode(['icon'=> 'success', 'message' => 'Birim başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'unit',
                    $unit_id,
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
                $unit_id = $this->request->getPost('unit_id');

                $unit_item = $this->modelUnit->where('unit_id', $unit_id)->where('user_id', session()->get('user_id'))->first();
                if(!$unit_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen birim bulunamadı.']);
                    return;
                }

                $this->modelUnit->delete($unit_id);

                echo json_encode(['icon'=> 'success', 'message' => 'Birim başarıyla silindi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'unit',
                    $unit_id,
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