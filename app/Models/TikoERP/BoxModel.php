<?php 


namespace App\Models;

use CodeIgniter\Model;

class BoxModel extends Model
{
    protected $table = 'boxes'; // Tablo adı
    protected $primaryKey = 'id'; // Birincil anahtar

    protected $allowedFields = ['kutu_id', 'platform', 'aktif','order_no', 'content', 'is_empty', 'order_id']; // Güncellenebilir alanlar
}