<?php

namespace App\Controllers\TikoERP;
use App\Controllers\BaseController;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoERP\LogModel;

/**
 * @property IncomingRequest $request 
 */


class CacheHandler extends BaseController{
    private $TikoERPModelPath;
    private $DatabaseConfig;
    private $currentDB;
    private $model;
    private $counterName;
    private $counterNameList;
    private $modelName;

    public function __construct($model_name)
    {
        $this->TikoERPModelPath = 'App\Models\TikoERP';

        $this->counterNameList = [
            'StockMovementModel' => 'stock_movement_counter',
            'FinancialMovementModel' => 'financial_movement_counter',
            'ShipmentModel' => 'shipment_counter',
        ];
        $this->modelName = $model_name;
        $this->counterName = $this->counterNameList[$model_name];
    }

    public function getTransactionCounter(){
        $transaction_counter = cache()->get('transaction_counter');
        $user_id = session()->get('user_id');
        if(isset($transaction_counter[$user_id])){
            $counter_data = $transaction_counter[$user_id];
            if(isset($counter_data[$this->counterName])){
                $value = $counter_data[$this->counterName];
            }else {
                $value =  $this->getLastCounter();
            }
        }else {
            $value = $this->getLastCounter();
        }

        # TODO: Duruma göre bunun için ayrı bir fonksiyon yazılabilir.
        # Çünkü insert işleminin başarısız olduğu durumlarda arttırılmaması gerekiyor.
        # Update Cache
        $transaction_counter[$user_id][$this->counterName] = $value + 1;
        cache()->save('transaction_counter', $transaction_counter);
        return $value;
    }

    private function getLastCounter(){
        $set_model = $this->setModel();
        if($set_model){
            $last_item = $this->model->where('user_id', session()->get('user_id'))->orderBy($this->counterName, 'DESC')->first();
            if ($last_item) {
                $counter = $last_item[$this->counterName] + 1;
            } else {
                $counter = 1;
            }

            return $counter;
        }else {
            return false;
        }
    }
    
    private function setModel(){
        try{
            $this->DatabaseConfig = new GeneralConfig();
            $this->currentDB = $this->DatabaseConfig->setDBConfigs();

            $db_connection = \Config\Database::connect($this->currentDB);

            $this->model = model($this->TikoERPModelPath.'\\'.$this->modelName, true, $db_connection);
            return true;
        }catch(\Exception $e){
            return false;
        }
    }
}