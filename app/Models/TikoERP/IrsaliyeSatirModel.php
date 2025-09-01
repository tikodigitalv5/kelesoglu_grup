<?php

namespace App\Models\TikoERP;

use CodeIgniter\Model;

class IrsaliyeSatirModel extends Model
{
    protected $table = 'irsaliye_satirlar';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    
    protected $allowedFields = [
        'irsaliye_id',
        'order_satir_id',
        'stock_id',
        'stock_title',
        'stock_code',
        'stock_image',
        'depo_id',
        'stock_amount',
        'unit_title',
        'unit_price',
        'money_icon',
        'total_price',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'irsaliye_id' => 'required|numeric',
        
        'stock_id' => 'required|numeric',
        'stock_title' => 'required',
        'stock_code' => 'required',
        'depo_id' => 'required|numeric',
        'stock_amount' => 'required|numeric',
        'unit_title' => 'required',
        'unit_price' => 'required|numeric',
        'money_icon' => 'required'
    ];

    protected $validationMessages = [
        'irsaliye_id' => [
            'required' => 'İrsaliye ID zorunludur.',
            'numeric' => 'İrsaliye ID sayısal olmalıdır.'
        ],
       
        'stock_id' => [
            'required' => 'Stok ID zorunludur.',
            'numeric' => 'Stok ID sayısal olmalıdır.'
        ],
        'stock_title' => [
            'required' => 'Ürün adı zorunludur.'
        ],
        'stock_code' => [
            'required' => 'Stok kodu zorunludur.'
        ],
        'depo_id' => [
            'required' => 'Depo ID zorunludur.',
            'numeric' => 'Depo ID sayısal olmalıdır.'
        ],
        'unit_title' => [
            'required' => 'Birim adı zorunludur.'
        ],
        'money_icon' => [
            'required' => 'Para birimi zorunludur.'
        ]
    ];

    // Callbacks
    protected $afterInsert = ['logInsert'];
    protected $afterUpdate = ['logUpdate'];
    protected $afterDelete = ['logDelete'];

    protected function logInsert(array $data)
    {
        try {
            $logData = [
                'irsaliye_id' => $data['data']['irsaliye_id'],
                'satir_id' => $data['id'],
                'islem_tipi' => 'INSERT',
                'islem_detay' => 'Yeni irsaliye satırı eklendi',
                'created_by' => session()->get('user_id')
            ];

            $DatabaseConfig = new \App\Controllers\TikoPortal\GeneralConfig();
            $currentDB = $DatabaseConfig->setDBConfigs();
            $db = \Config\Database::connect($currentDB);
            $builder = $db->table('irsaliye_logs');
            $builder->insert($logData);
        } catch (\Exception $e) {
            log_message('error', '[IrsaliyeSatirModel::logInsert] Hata: ' . $e->getMessage());
        }
        return $data;
    }

    protected function logUpdate(array $data)
    {
        try {
            $logData = [
                'irsaliye_id' => $data['data']['irsaliye_id'],
                'satir_id' => $data['id'],
                'islem_tipi' => 'UPDATE',
                'islem_detay' => 'İrsaliye satırı güncellendi',
                'created_by' => session()->get('user_id')
            ];

            $DatabaseConfig = new \App\Controllers\TikoPortal\GeneralConfig();
            $currentDB = $DatabaseConfig->setDBConfigs();
            $db = \Config\Database::connect($currentDB);
            $builder = $db->table('irsaliye_logs');
            $builder->insert($logData);
        } catch (\Exception $e) {
            log_message('error', '[IrsaliyeSatirModel::logUpdate] Hata: ' . $e->getMessage());
        }
        return $data;
    }

    protected function logDelete(array $data)
    {
        try {
            $logData = [
                'irsaliye_id' => $data['data']['irsaliye_id'],
                'satir_id' => $data['id'],
                'islem_tipi' => 'DELETE',
                'islem_detay' => 'İrsaliye satırı silindi',
                'created_by' => session()->get('user_id')
            ];

            $DatabaseConfig = new \App\Controllers\TikoPortal\GeneralConfig();
            $currentDB = $DatabaseConfig->setDBConfigs();
            $db = \Config\Database::connect($currentDB);
            $builder = $db->table('irsaliye_logs');
            $builder->insert($logData);
        } catch (\Exception $e) {
            log_message('error', '[IrsaliyeSatirModel::logDelete] Hata: ' . $e->getMessage());
        }
        return $data;
    }
} 