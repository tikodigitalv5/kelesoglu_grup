<?php

namespace App\Models\TikoERP;

use CodeIgniter\Model;

class CheckTransactionModel extends Model
{
    protected $table = 'check_transactions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    
    protected $allowedFields = [
        'check_id',
        'transaction_type',
        'from_id',
        'to_id',
        'transaction_date',
        'description'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // İşlem tipleri için sabitler
    const TYPE_RECEIVE = 'receive';
    const TYPE_ENDORSE = 'endorse';
    const TYPE_PAYMENT = 'payment';
    const TYPE_BOUNCE = 'bounce';
    const TYPE_CANCEL = 'cancel';

    public function getCheckTransactions($checkId)
    {
        return $this->where('check_id', $checkId)
                    ->orderBy('transaction_date', 'DESC')
                    ->findAll();
    }

    public function getTransactionsByDate($startDate, $endDate)
    {
        return $this->where('transaction_date >=', $startDate)
                    ->where('transaction_date <=', $endDate)
                    ->findAll();
    }

    public function getTransactionsByType($type)
    {
        return $this->where('transaction_type', $type)
                    ->findAll();
    }

    public function addTransaction($data)
    {
        return $this->insert($data);
    }
} 