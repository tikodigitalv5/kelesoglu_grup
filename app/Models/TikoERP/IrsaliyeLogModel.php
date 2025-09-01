<?php

namespace App\Models\TikoERP;

use CodeIgniter\Model;

class IrsaliyeLogModel extends Model
{
    protected $table = 'irsaliye_logs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    
    protected $allowedFields = [
        'irsaliye_id',
        'satir_id',
        'islem_tipi',
        'islem_detay',
        'created_by'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'irsaliye_id' => 'required|numeric',
        'islem_tipi' => 'required',
        'islem_detay' => 'required',
        'created_by' => 'required|numeric'
    ];

    protected $validationMessages = [
        'irsaliye_id' => [
            'required' => 'İrsaliye ID zorunludur.',
            'numeric' => 'İrsaliye ID sayısal olmalıdır.'
        ],
        'islem_tipi' => [
            'required' => 'İşlem tipi zorunludur.'
        ],
        'islem_detay' => [
            'required' => 'İşlem detayı zorunludur.'
        ],
        'created_by' => [
            'required' => 'İşlemi yapan kullanıcı zorunludur.',
            'numeric' => 'Kullanıcı ID sayısal olmalıdır.'
        ]
    ];
} 