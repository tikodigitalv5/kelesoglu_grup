<?php

namespace App\Models\TikoERP;

use CodeIgniter\Model;

class OperationResource extends Model
{
    protected $table = 'operation_resources';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'resource_type',
        'name',
        'status'
    ];

    protected $useTimestamps = false;
    
    // Tip sabitleri - view'da da kullanılabilir
    const TYPE_KISI = 'kisi';
    const TYPE_ATOLYE = 'atolye';
    const TYPE_MAKINE = 'makine';
    const TYPE_SETUP = 'setup';

    // Durum sabitleri
    const STATUS_ACTIVE = 'active';
    const STATUS_PASSIVE = 'passive';

    // Tip listesi
    public static function getResourceTypes()
    {
        return [
            self::TYPE_KISI => 'Kişi',
            self::TYPE_ATOLYE => 'Atölye',
            self::TYPE_MAKINE => 'Makine',
            self::TYPE_SETUP => 'Setup'
        ];
    }

    // Tipe göre kayıtları getir
    public function getByType($type)
    {
        return $this->where('resource_type', $type)
                    ->where('status', self::STATUS_ACTIVE)
                    ->findAll();
    }
}