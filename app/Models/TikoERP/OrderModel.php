<?php 

namespace App\Models\TikoERP;

use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\Model;

class OrderModel extends Model {

    protected $table      = 'order';
    protected $primaryKey = 'order_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'user_id',
        'order_numara',
        'money_unit_id',
        'order_direction',
        'order_no',
        'order_date',
        'order_note_id',
        'order_note',
        'is_deadline',
        'b2b',
        'cron_id',
        'dopigo',
        'deadline_date',
        'currency_amount',
        'stock_total',
        'stock_total_try',
        'discount_total',
        'discount_total_try',
        'tax_rate_1_amount',
        'tax_rate_1_amount_try',
        'tax_rate_10_amount',
        'tax_rate_10_amount_try',
        'tax_rate_20_amount',
        'tax_rate_20_amount_try',
        'sub_total',
        'sub_total_try',
        'sub_total_0',
        'sub_total_0_try',
        'sub_total_1',
        'sub_total_1_try',
        'sub_total_10',
        'sub_total_10_try',
        'sub_total_20',
        'sub_total_20_try',
        'grand_total',
        'grand_total_try',
        'amount_to_be_paid',
        'amount_to_be_paid_try',
        'amount_to_be_paid_text',
        'cari_id',
        'cari_identification_number',
        'cari_tax_administration',
        'cari_invoice_title',
        'cari_name',
        'cari_surname',
        'cari_obligation',
        'cari_company_type',
        'cari_phone',
        'cari_email',
        'address_country',
        'address_city',
        'address_city_plate',
        'address_district',
        'address_zip_code',
        'address',
        'order_status',
        'fatura',
        'sevk_emri',
        'sevk_print',
        'service_name',
        'service_logo',
        'kargo',
        'kargo_kodu',
        'kargo_logo',
        'satisci',
        'shipped_date',
        'dopigo_data',
        'msh_order_id',
        'dopigo_siparis_id',
        'komisyon',
        'irsaliye',
        'failed_reason'
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
            'model_name' => 'order',
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
            'model_name' => 'order',
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
            'model_name' => 'order',
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