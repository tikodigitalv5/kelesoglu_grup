<?php 

namespace App\Models\TikoERP;

use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\Model;

class StockWarehouseQuantity extends Model {

    protected $table      = 'stock_warehouse_quantity';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'user_id',
        'warehouse_id',
        'stock_id',
        'parent_id',
        'stock_quantity',
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