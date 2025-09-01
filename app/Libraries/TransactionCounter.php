<?php 
namespace App\Libraries;

use App\Controllers\TikoPortal\GeneralConfig;
use Exception;

class TransactionCounter {
    private $TikoERPModelPath;
    private $strPad;
    private $DatabaseConfig;
    private $currentDB;

    private $model;
    private $counterName;
    private $counterNameList;
    private $counterPrefix;
    private $modelName;


    # Cache example: 
    // {
    //     data: [
    //         user_id: [
    //             'stock_movement_counter': [
    //                 'TRNSFR': 54
    //             ],
    //             'financial_movement_counter': [
    //                 'PRF': 56,  **Eğer fatura no yoksa
    //                 'THS': 112,
    //                 'ODM': 654,
    //             ],
    //             'shipment_counter': [
    //                 'SVK': 78
    //             ]
    //         ],
    //         user_id: [
    //             'stock_movement_counter': [
    //                 'TRNSFR': 598
    //             ],
    //             'financial_movement_counter': [
    //                 'PRF': 56,  **Eğer fatura no yoksa
    //                 'THS': 112,
    //                 'ODM': 654,
    //             ],
    //             'shipment_counter': [
    //                 'SVK': 78
    //             ]
    //         ],
    //     ]
    // }
    
    public function __construct($model_name, $transaction_prefix){
        $this->TikoERPModelPath = 'App\Models\TikoERP';
        $this->strPad = 6;

        $this->counterNameList = [
            'StockMovementModel' => 'stock_movement_counter',
            'ShipmentModel' => 'shipment_counter',
            'FinancialMovementModel' => 'financial_movement_counter',
        ];
        $this->modelName = $model_name;
        $this->counterName = $this->counterNameList[$model_name];

        if(!$transaction_prefix){
            if($this->modelName == 'StockMovementModel'){
                $this->counterPrefix = 'TRNSFR'; 
            }else if($this->modelName == 'ShipmentModel'){
                $this->counterPrefix = 'SVK'; 
            }else {

            }
        }else {
            $this->counterPrefix = $transaction_prefix; 
        }
    }

    public function getTransactionCounter(){
        $transaction_counter = cache()->get('transaction_counter');
        $user_id = session()->get('user_id');
        if(isset($transaction_counter[$user_id][$this->counterName][$this->counterPrefix])){
            $value = $transaction_counter[$user_id][$this->counterName][$this->counterPrefix];
        }else {
            $value = $this->getLastCounter();
        }

        return [
            'transaction_number' => $this->counterPrefix . str_pad($value, $this->strPad, '0', STR_PAD_LEFT),
            'transaction_counter' => $value,
            'transaction_prefix' => $this->counterPrefix
        ];
    }

    public function updateCounter(){
        try{
            $transaction_counter = cache()->get('transaction_counter');
            $user_id = session()->get('user_id');
            if(isset($transaction_counter[$user_id][$this->counterName])){
                $transaction_counter[$user_id][$this->counterName] += 1;
            }else {
                $transaction_counter[$user_id][$this->counterName] = 1;
            }
            cache()->save('transaction_counter', $transaction_counter);
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    private function getLastCounter(){
        $set_model = $this->setModel();
        if($set_model){
            $last_item = $this->model->where('user_id', session()->get('user_id'))->where('transaction_prefix', $this->counterPrefix)->orderBy($this->counterName, 'DESC')->first();
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
?>