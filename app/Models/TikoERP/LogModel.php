<?php 

namespace App\Models\TikoERP;

use CodeIgniter\Model;

class LogModel extends Model {

    protected $table      = 'log';
    protected $primaryKey = 'log_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'user_id',
        'log_type',
        'authorized_user_id',
        'model_name',
        'affected_id',
        'after_action',
        'log_action',
        'log_message',
        'request_data',
        'islemi_yapan',
        'islem',
        'ip',
        'client_id',
        'lokasyon',
        'isletim_sistemi',
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;

}




?>