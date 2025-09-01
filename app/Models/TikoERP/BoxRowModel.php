<?php 


namespace App\Models;

use CodeIgniter\Model;

class BoxRowModel extends Model
{
    protected $table = 'boxes_row'; // Tablo adı
    protected $primaryKey = 'boxes_id'; // Birincil anahtar

    protected $allowedFields = ['kutu_id', 'order_id', 'paket', 'adet', 'okutulan_adet','stock_id', 'stock_title', 'stock_amount', 'stock_image', 'order_date', 'okundu']; // Güncellenebilir alanlar
}