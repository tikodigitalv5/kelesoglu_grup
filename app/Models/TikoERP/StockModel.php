<?php 

namespace App\Models\TikoERP;

use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\Model;

class StockModel extends Model {

    protected $table      = 'stock';
    protected $primaryKey = 'stock_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'parent_id',
        'paket',
        'altcategory_id',
        'artliving',
        'user_id',
        'cari_id',
        'type_id',
        'category_id',
        'buy_unit_id',
        'sale_unit_id',
        'buy_money_unit_id',
        'sale_money_unit_id',
        'buy_unit_price',
        'buy_unit_price_with_tax',
        'sale_unit_price',
        'sale_unit_price_with_tax',
        'buy_tax_rate',
        'sale_tax_rate',
        'stock_type',
        'stock_title',
        'stock_code',
        'stock_total_quantity',
        'stock_barcode',
        'pattern_code',
        'supplier_stock_code',
        'warehouse_address',
        'default_image',
        'critical_stock',
        'status',
        'has_variant',
        'stock_tracking',
        'manuel_add',
        'en',
        'boy',
        'kalinlik',
        'ozkutle',
        'dopigo',
        'sysmond',
        'sistem3d_durum',
        'sistem3d',
        'mshsite',
        'stock_barcode_2',
        'mytech',
        'grup_id'
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


    protected $globalScopes = ['active' => ['deleted_at' => null]];

    
    protected function afterInsert(array $data){
        $DatabaseConfig = new GeneralConfig();
        $currentDB = $DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($currentDB);
        $modelLog = model('App\Models\TikoERP\LogModel', true, $db_connection);

        $log_data = [
            'user_id' => session()->get('client_id'),
            'log_type' => 'success',
            'authorized_user_id' => session()->get('authorized_user_id'),
            'model_name' => 'stock',
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
            'model_name' => 'stock',
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
            'model_name' => 'stock',
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