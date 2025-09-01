<?php

namespace App\Models\TikoERP;

use CodeIgniter\Model;

class SysmondBarkodlar extends Model
{
    protected $table = 'sysmond_barkodlar';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['stock_id', 'sysmond_id', 'barkod', 'stok_kodu', 'stok_basligi'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat = 'datetime';

    // Barkod ile ürün arama
    public function findByBarkod($barkod)
    {
        return $this->where('barkod_1', $barkod)
                    ->orWhere('barkod_2', $barkod)
                    ->first();
    }

    // Stock ID ile ürün arama
    public function findByStockId($stock_id)
    {
        return $this->where('stock_id', $stock_id)->first();
    }

    // Sysmond ID ile ürün arama
    public function findBySysmondId($sysmond_id)
    {
        return $this->where('sysmond_id', $sysmond_id)->first();
    }

    // Stok kodu ile ürün arama
    public function findByStokKodu($stok_kodu)
    {
        return $this->where('stok_kodu', $stok_kodu)->first();
    }

    // Toplu veri ekleme
    public function insertBatch(?array $set = null, ?bool $escape = null, int $batchSize = 100, bool $testing = false)
    {
        return parent::insertBatch($set, $escape, $batchSize, $testing);
    }

    // Toplu güncelleme
    public function updateBatch(?array $set = null, ?string $index = null, int $batchSize = 100, bool $returnSQL = false)
    {
        return parent::updateBatch($set, $index, $batchSize, $returnSQL);
    }
} 