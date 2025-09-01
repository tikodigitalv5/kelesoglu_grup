<?php

namespace App\Models\TikoERP;

use CodeIgniter\Model;

class SysmondCronModel extends Model
{
    protected $table = 'sysmond_cron';  // Tablo adı
    protected $primaryKey = 'cron_id';      // Birincil anahtar
    
    // Otomatik zaman damgaları (created_at ve updated_at) kullan
    protected $useTimestamps = true;

    // İzin verilen alanlar (insert ve update işlemleri için)
    protected $allowedFields = [
        'tarih',
        'durum',
        'mesaj',
        'mail',
    ];

    // Tarih formatı (Otomatik olarak datetime)
    protected $dateFormat = 'datetime';

    // Validation rules (isteğe bağlı)
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}