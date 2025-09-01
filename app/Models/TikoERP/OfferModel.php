<?php 

namespace App\Models\TikoERP;

use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\Model;

class OfferModel extends Model {

    protected $table      = 'offer';
    protected $primaryKey = 'offer_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'user_id',
        'cari_id',
        'client_id',
        'money_unit_id',
        'offer_no',
        'offer_date',
        'offer_expire_date',
        'offer_note_id',
        'offer_note',
        'is_validity',
        'validity_date',
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
        'offer_status',
        'fatura',
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
            'model_name' => 'offer',
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
            'model_name' => 'offer',
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
            'model_name' => 'offer',
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