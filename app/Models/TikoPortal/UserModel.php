<?php 

namespace App\Models\TikoPortal;

use CodeIgniter\Model;

class UserModel extends Model {

    protected $table      = 'user';
    protected $primaryKey = 'client_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'client_id',
        'user_id',
        'operation',
        'user_eposta',
        'pin',
        'user_telefon',
        'user_adsoyad',
        'firma_adi',
        'user_password',
        'super_admin',
        'status',
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