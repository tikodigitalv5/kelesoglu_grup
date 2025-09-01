<?php

namespace App\Models;

use CodeIgniter\Model;

class DopigoEslestirModel extends Model
{
    protected $table = 'dopigo_eslestir';  // Tablonun adı
    protected $primaryKey = 'id';          // Birincil anahtar

    protected $useAutoIncrement = true;    // Otomatik artan ID
    
    protected $returnType = 'array';       // Döndürülecek veri tipi (array veya object)
    protected $useSoftDeletes = false;     // Soft delete özelliği (silindi olarak işaretleme)

    protected $allowedFields = [
        'dopigo_id',
        'stock_id',
        'stock_title',
        'dopigo_title',
        'stock_code',
        'dopigo_code',
        'silindi',
        'created_at',
        'updated_at',
    ];  // Güncellenebilir ve eklenebilir alanlar

    protected $useTimestamps = true;      // created_at ve updated_at alanlarını otomatik yönetir
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}
