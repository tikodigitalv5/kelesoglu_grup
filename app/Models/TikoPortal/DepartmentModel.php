<?php 

namespace App\Models\TikoPortal;

use CodeIgniter\Model;

class DepartmentModel extends Model {

    protected $table      = 'department';
    protected $primaryKey = 'department_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'department_title',
        'department_status',
        'department_order',
        'department_default'
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;

    # protected $afterInsert = ['afterInsert'];
    # protected $afterUpdate = ['afterUpdate'];
    # protected $afterDelete = ['afterDelete'];


}




?>