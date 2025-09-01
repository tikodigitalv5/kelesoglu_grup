<?php

namespace App\Models\TikoERP;

use CodeIgniter\Model;

class MaliyetLogsModel extends Model
{
    protected $table = 'maliyet_logs';
    protected $primaryKey = 'log_id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'user_id',
        'stock_id',
        'variant_id',
        'kod',
        'urun',
        'gram',
        'tas_sayisi',
        'ham',
        'kap_maliyet',
        'mineli',
        'tasli',
        'toplam_maliyet',
        'kar_orani',
        'satis',
        'ham_carpani',
        'kap_carpani',
        'tas_carpani',
        'mineli_carpani',
        'kar_orani_default',
        'created_at',
    ];

    // Yeni log ekle
    public function addLog($data)
    {
        return $this->insert($data);
    }

    // Tüm logları getir (opsiyonel filtre ile)
    public function getLogs($filter = [])
    {
        if (!empty($filter)) {
            return $this->where($filter)->orderBy('created_at', 'DESC')->findAll();
        }
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    // Tek bir log getir
    public function getLog($log_id)
    {
        return $this->find($log_id);
    }

    // Log sil
    public function deleteLog($log_id)
    {
        return $this->delete($log_id);
    }

    // Log güncelle
    public function updateLog($log_id, $data)
    {
        return $this->update($log_id, $data);
    }

    // Belirli bir stoğa ait logları getir
    public function getLogsByStock($stock_id)
    {
        return $this->where('stock_id', $stock_id)->orderBy('created_at', 'DESC')->findAll();
    }

    // Belirli bir kullanıcıya ait logları getir
    public function getLogsByUser($user_id)
    {
        return $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->findAll();
    }
} 