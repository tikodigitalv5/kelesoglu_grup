<?php

namespace App\Models;

use CodeIgniter\Model;

class SysmondLogModel extends Model
{
    protected $table = 'sysmond_log';  // Tablo adı
    protected $primaryKey = 'id';      // Birincil anahtar
    
    // Otomatik zaman damgaları (created_at ve updated_at) kullan
    protected $useTimestamps = true;

    // İzin verilen alanlar (insert ve update işlemleri için)
    protected $allowedFields = [
        'sysmond_stockid',
        'stock_id',
        'updated_data',
        'log_text',
        'user_id',
        'client_id',
        'ip_address',
        'browser',
        'is_mobile',
    ];

    // Tarih formatı (Otomatik olarak datetime)
    protected $dateFormat = 'datetime';

    // Validation rules (isteğe bağlı)
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}