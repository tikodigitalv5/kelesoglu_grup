<?php 

namespace App\Models\TikoERP;

use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\Model;

class InvoiceOutgoingModel extends Model {

    protected $table      = 'invoice_outgoing_status';
    protected $primaryKey = 'invoice_outgoing_status_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'status_name',
        'status_info',
        'status_value',
        'status_publish',
        'status_order',
        'status_statement',
        'status_substatus',
        'action_to_taken',
        'status_code',
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $skipValidation     = false;

    protected $afterInsert = ['afterInsert'];
    protected $afterUpdate = ['afterUpdate'];

    protected function afterInsert(array $data){
        $DatabaseConfig = new GeneralConfig();
        $currentDB = $DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($currentDB);
        $modelLog = model('App\Models\TikoERP\LogModel', true, $db_connection);

        $log_data = [
            'user_id' => session()->get('user_id'),
            'log_type' => 'success',
            'authorized_user_id' => session()->get('authorized_user_id'),
            'model_name' => 'invoice_outgoing_status',
            'affected_id' => $data['id'],
            'after_action' => json_encode($data['data']),
            'log_action' => 'create',
            'log_message' => null,
            'request_data' => json_encode($_POST),
        ];
        $modelLog->insert($log_data);
    }

    protected function afterUpdate(array $data){
        $DatabaseConfig = new GeneralConfig();
        $currentDB = $DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($currentDB);
        $modelLog = model('App\Models\TikoERP\LogModel', true, $db_connection);

        $log_data = [
            'user_id' => session()->get('user_id'),
            'log_type' => 'success',
            'authorized_user_id' => session()->get('authorized_user_id'),
            'model_name' => 'invoice_outgoing_status',
            'affected_id' => $data['id'],
            'after_action' => json_encode($data['data']),
            'log_action' => 'update',
            'log_message' => null,
            'request_data' => json_encode($_POST),
        ];
        $modelLog->insert($log_data);
    }

    protected function afterDelete(array $data){
        $DatabaseConfig = new GeneralConfig();
        $currentDB = $DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($currentDB);
        $modelLog = model('App\Models\TikoERP\LogModel', true, $db_connection);
        
        $log_data = [
            'user_id' => session()->get('user_id'),
            'log_type' => 'success',
            'authorized_user_id' => session()->get('authorized_user_id'),
            'model_name' => 'invoice_outgoing_status',
            'affected_id' => $data['id'],
            'after_action' => json_encode($data['data']),
            'log_action' => 'delete',
            'log_message' => null,
            'request_data' => json_encode($_POST),
        ];
        $modelLog->insert($log_data);
    }

}




?>