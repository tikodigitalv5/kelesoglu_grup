<?php 

namespace App\Models\TikoERP;

use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\Model;

class StockMovementModel extends Model {

    protected $table      = 'stock_movement';
    protected $primaryKey = 'stock_movement_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'user_id',
        'stock_barcode_id',
        'invoice_id',
        'supplier_id',
        'movement_type',
        'transaction_number',
        'from_warehouse',
        'to_warehouse',
        'transaction_info',
        'transaction_note',
        'transaction_quantity',
        'transaction_date',
        'buy_unit_price',
        'buy_money_unit_id',
        'sale_unit_price',
        'sale_money_unit_id',
        'transaction_prefix',
        'transaction_counter'
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;

    protected $afterInsert = ['afterInsert'];
    protected $afterUpdate = ['afterUpdate'];
    protected $afterDelete = ['afterDelete'];

    protected function afterInsert(array $data){
        $DatabaseConfig = new GeneralConfig();
        $currentDB = $DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($currentDB);
        $modelLog = model('App\Models\TikoERP\LogModel', true, $db_connection);

        $log_data = [
            'user_id' => session()->get('client_id'),
            'log_type' => 'success',
            'authorized_user_id' => session()->get('authorized_user_id'),
            'model_name' => 'stock_movement',
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
            'user_id' => session()->get('client_id'),
            'log_type' => 'success',
            'authorized_user_id' => session()->get('authorized_user_id'),
            'model_name' => 'stock_movement',
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
            'user_id' => session()->get('client_id'),
            'log_type' => 'success',
            'authorized_user_id' => session()->get('authorized_user_id'),
            'model_name' => 'stock_movement',
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