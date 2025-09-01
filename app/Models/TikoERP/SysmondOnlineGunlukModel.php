<?php

namespace App\Models\TikoERP;

use CodeIgniter\Model;

class SysmondOnlineGunlukModel extends Model
{
    protected $table = 'sysmond_online_gunluk';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'COMPANYID', 'STOCKREFID', 'URUNKODU', 'GROUPCODE',
        'SPECCODE1', 'SPECCODE2', 'SPECCODE3', 'SPECCODE4', 'SPECCODE5',
        'SPECCODE6', 'SPECCODE7', 'SPECCODE8', 'SPECCODE9', 'SPECCODE10',
        'SEASON', 'BRAND', 'MODEL', 'MINORDERQUANTITY', 'RESIMSAY',
        'BARKOD1', 'BARKOD2', 'BARKOD3', 'BARKOD4', 'BARKOD5',
        'MARKA', 'URUNADI', 'URUNADI2', 'NOTLAR', 'FIYAT1', 'FIYAT2',
        'DOVIZ', 'KDV', 'TOPLAMMIKTARI', 'MERKEZDEPOMIKTAR',
        'BILGIDEPO1', 'BILGIDEPO2', 'acik_sip_miktari', 'BIRIM',
        'MATRIX', 'MATRIX1', 'MATRIX2', 'MATRIX3'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
} 