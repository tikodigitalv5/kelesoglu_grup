<?php

namespace App\Controllers\TikoERP;
use App\Controllers\BaseController;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoERP\LogModel;

/**
 * @property IncomingRequest $request 
 */


class Log extends BaseController{
    private $DatabaseConfig;
    private $currentDB;
    private $modelLog;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelLog = model($TikoERPModelPath.'\LogModel', true, $db_connection);
    }

    public function save_log(
        $log_type, 
        $model_name, 
        $affected_id,
        $after_action,
        $log_action,
        $log_message,
        $request_data
    ){
        $log_data = [
            'user_id' => session()->get('user_id'),
            'log_type' => $log_type,
            'authorized_user_id' => session()->get('authorized_user_id'),
            'model_name' => $model_name,
            'affected_id' => $affected_id,
            'after_action' => $after_action,
            'log_action' => $log_action,
            'log_message' => $log_message,
            'request_data' => $request_data,
        ];
        $this->modelLog->insert($log_data);
        return;
    }

    

}