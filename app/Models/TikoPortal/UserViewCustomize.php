<?php 

namespace App\Models\TikoPortal;

use CodeIgniter\Model;

class UserViewCustomize extends Model {

    protected $table      = 'user_view_customize';
    protected $primaryKey = 'customize_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'user_id',
        'class_name',
        'function_name',
        'file_path'
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