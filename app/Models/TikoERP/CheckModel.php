<?php

namespace App\Models\TikoERP;

use CodeIgniter\Model;

class CheckModel extends Model
{
    protected $table = 'checks';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    
    protected $allowedFields = [
        'check_no',
        'amount',
        'currency',
        'exchange_rate',
        'due_date',
        'issue_date',
        'bank_id',
        'drawer_id',
        'payee_id',
        'status',
        'check_type',
        'description',
        'check_image'  // Yeni eklenen alan
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Çek durumları için sabitler
    const STATUS_PORTFOLIO = 'portfolio';
    const STATUS_ENDORSED = 'endorsed';
    const STATUS_PAID = 'paid';
    const STATUS_BOUNCED = 'bounced';
    const STATUS_CANCELLED = 'cancelled';

    // Çek tipleri için sabitler
    const TYPE_CUSTOMER = 'customer';
    const TYPE_OWN = 'own';
    const TYPE_ENDORSED = 'endorsed';

    public function getPortfolioChecks()
    {
        return $this->where('status', self::STATUS_PORTFOLIO)
                    ->findAll();
    }

    public function getEndorsedChecks()
    {
        return $this->where('status', self::STATUS_ENDORSED)
                    ->findAll();
    }

    public function getPaidChecks()
    {
        return $this->where('status', self::STATUS_PAID)
                    ->findAll();
    }

    public function getBouncedChecks()
    {
        return $this->where('status', self::STATUS_BOUNCED)
                    ->findAll();
    }

    public function getChecksByDueDate($startDate, $endDate)
    {
        return $this->where('due_date >=', $startDate)
                    ->where('due_date <=', $endDate)
                    ->findAll();
    }
} 