<?php 

namespace App\Models\TikoPortal;

use CodeIgniter\Model;

class UserFaturaModel extends Model {

    protected $table      = 'user_fatura';
    protected $primaryKey = 'user_fatura_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'user_id',
        'vkn_tc',
        'vergi_dairesi',
        'mukellefiyet',
        'f_unvan',
        'f_ad',
        'f_soyad',
        'f_adres',
        'f_il',
        'f_ilce',
        'f_ulke',
        'f_postakodu',
        'f_eposta',
        'f_tel',
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