<?php 

namespace App\Models\TikoPortal;

use CodeIgniter\Model;

class ModuleModel extends Model {

    protected $table      = 'module';
    protected $primaryKey = 'module_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'module_title',
        'module_route',
        'module_icon',
        'module_order',
        'parent_id',
        'is_dropdown'
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