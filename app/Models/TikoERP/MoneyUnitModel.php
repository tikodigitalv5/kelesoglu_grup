<?php 

namespace App\Models\TikoERP;

use CodeIgniter\Model;

class MoneyUnitModel extends Model {

    protected $table      = 'money_unit';
    protected $primaryKey = 'money_unit_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'user_id',
        'money_code',
        'money_title',
        'money_icon',
        'money_value',
        'status',
        'usdeuro',
        'guncelleme',
        'default'
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