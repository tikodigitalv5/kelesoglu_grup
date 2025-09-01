<?php

namespace App\Models;

use CodeIgniter\Model;

class SysmondBarkodModel extends Model
{
    // Tablo adı
    protected $table = 'sysmond_barkod';

    // Birincil anahtar
    protected $primaryKey = 'id';
    // Otomatik artan birincil anahtar kullanılıyorsa
    protected $useAutoIncrement = true; // Otomatik artan birincil anahtar kullanıyorsanız true olmalı

    // Tablodaki izin verilen alanlar (insert ve update işlemleri için)
    protected $allowedFields = [
        'COMPANYID','CHANGE_LOG', 'STOCKID', 'STOCKNO', 'STOCKNAME', 'STOCKTYPE',  'UNITNAME', 
        'UNITIDNAME', 'INTUNITCODE', 'UNITID', 'ITEMNO', 'BARCODETYPENAME', 
        'BARCODETYPE', 'BARCODE', 'AUTOGENERATE', 'ACTNO', 'ACTNAME', 'ACTTYPE', 
        'ACTID', 'GRADENAME', 'GRADEID', 'QUANTITY', 'STOCKPRICETYPEID', 'TERAZITUSNO', 
        'OUTPRODUCT', 'PRICE', 'DESCRIPTION', 'INSERTUSERID', 'INSERTDATE', 'EDITUSERID', 
        'EDITDATE', 'GLBALERTID'
    ];

    // Zaman damgaları (created_at, updated_at) için
    protected $useTimestamps = true;
    protected $createdField  = 'INSERTDATE';
    protected $updatedField  = 'EDITDATE';

    // Tarih formatı
    protected $dateFormat = 'datetime';

    // Doğrulama kuralları (İsteğe bağlı)
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}