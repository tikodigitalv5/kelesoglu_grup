<?php

namespace App\Models\TikoERP;

use CodeIgniter\Model;

class SysmondDepolarModel extends Model
{
    protected $table = 'sysmond_depolar';
    protected $primaryKey = 'sysmond_depo_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    
    protected $allowedFields = [
        'user_id',
        'sysmond',
        'stock_id',
        'stock_code',
        'depo_1',
        'depo_1_id',
        'depo_1_count',
        'depo_2',
        'depo_2_id',
        'depo_2_count',
        'depo_3',
        'depo_3_id',
        'depo_3_count',
        'depo_4',
        'depo_4_id',
        'depo_4_count'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|numeric',
        'stock_id' => 'required|numeric',
        'stock_code' => 'required',
        'depo_1_count' => 'permit_empty|decimal',
        'depo_2_count' => 'permit_empty|decimal',
        'depo_3_count' => 'permit_empty|decimal',
        'depo_4_count' => 'permit_empty|decimal'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'Kullanıcı ID gerekli',
            'numeric' => 'Kullanıcı ID sayısal olmalı'
        ],
        'stock_id' => [
            'required' => 'Stok ID gerekli',
            'numeric' => 'Stok ID sayısal olmalı'
        ],
        'stock_code' => [
            'required' => 'Stok kodu gerekli'
        ]
    ];

    protected $skipValidation = true;

    // Callbacks
    protected $beforeInsert = ['setUserID'];
    protected $beforeUpdate = ['setUserID'];

    protected function setUserID(array $data)
    {
        if (!isset($data['data']['user_id']) && session()->has('user_id')) {
            $data['data']['user_id'] = session()->get('user_id');
        }
        return $data;
    }

    // Depo miktarlarını güncelle
    public function updateDepoMiktari($stock_id, $depo_no, $miktar)
    {
        $depo_field = "depo_{$depo_no}_count";
        return $this->where('stock_id', $stock_id)
                   ->set($depo_field, $miktar)
                   ->update();
    }

    // Stok için tüm depo miktarlarını getir
    public function getDepoMiktarlari($stock_id)
    {
        return $this->select('depo_1, depo_1_count, depo_2, depo_2_count, depo_3, depo_3_count, depo_4, depo_4_count')
                   ->where('stock_id', $stock_id)
                   ->first();
    }

    // Depo bazlı stok raporu
    public function getDepoRaporu($depo_no)
    {
        $depo_field = "depo_{$depo_no}";
        $count_field = "depo_{$depo_no}_count";
        
        return $this->select("stock_code, {$depo_field}, {$count_field}")
                   ->where("{$count_field} >", 0)
                   ->findAll();
    }
} 