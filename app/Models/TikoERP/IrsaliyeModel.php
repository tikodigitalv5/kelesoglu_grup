<?php

namespace App\Models\TikoERP;

use CodeIgniter\Model;

class IrsaliyeModel extends Model
{
    protected $table = 'irsaliyeler';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    
    protected $allowedFields = [
        'irsaliye_no',
       'order_id',
       'sysmond_id',
        'irsaliye_tarihi',
        'irsaliye_saati',
        'irsaliye_notu',
        'depo',
        'depo_id',
        'order_satir_id',
        'ara_toplam',
        'genel_toplam',
        'created_by',
        'updated_by',
        'deleted_by',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
      
        'irsaliye_tarihi' => 'required|valid_date',
        'irsaliye_saati' => 'required|regex_match[/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/]',
        'created_by' => 'required|numeric'
    ];

    protected $validationMessages = [
     
        'irsaliye_tarihi' => [
            'required' => 'İrsaliye tarihi zorunludur.',
            'valid_date' => 'Geçerli bir tarih giriniz.'
        ],
        'irsaliye_saati' => [
            'required' => 'İrsaliye saati zorunludur.',
            'regex_match' => 'Geçerli bir saat giriniz. (ÖR: 13:45)'
        ],
        'created_by' => [
            'required' => 'Oluşturan kullanıcı bilgisi zorunludur.',
            'numeric' => 'Geçersiz kullanıcı bilgisi.'
        ]
    ];

    // Callbacks
    protected $beforeInsert = ['generateIrsaliyeNo'];
    protected $afterInsert = ['logInsert'];
    protected $afterUpdate = ['logUpdate'];
    protected $afterDelete = ['logDelete'];

    protected function generateIrsaliyeNo(array $data)
    {
        if (!isset($data['data']['irsaliye_no'])) {
            try {
                $prefix = 'IRS';
                $year = date('Y');
                
                $builder = $this->db->table($this->table);
                $builder->select('irsaliye_no');
                $builder->orderBy('id', 'DESC');
                $builder->limit(1);
                $builder->where('deleted_at IS NULL');
                $query = $builder->get();
                
                if ($query && $lastIrsaliye = $query->getRow()) {
                    $lastNumber = intval(substr($lastIrsaliye->irsaliye_no, -4));
                } else {
                    $lastNumber = 0;
                }
                
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
                $data['data']['irsaliye_no'] = "{$prefix}-{$year}-{$newNumber}";
                
            } catch (\Exception $e) {
                log_message('error', '[IrsaliyeModel::generateIrsaliyeNo] Hata: ' . $e->getMessage());
                // Hata durumunda varsayılan bir numara oluştur
                $randomNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $data['data']['irsaliye_no'] = "IRS-" . date('Y') . "-" . $randomNumber;
            }
        }
        return $data;
    }

    protected function logInsert(array $data)
    {
        try {
            $logData = [
                'irsaliye_id' => $data['id'],
                'islem_tipi' => 'INSERT',
                'islem_detay' => 'Yeni irsaliye oluşturuldu',
                'created_by' => session()->get('user_id')
            ];

            $DatabaseConfig = new \App\Controllers\TikoPortal\GeneralConfig();
            $currentDB = $DatabaseConfig->setDBConfigs();
            $db = \Config\Database::connect($currentDB);
            $builder = $db->table('irsaliye_logs');
            $builder->insert($logData);
        } catch (\Exception $e) {
            log_message('error', '[IrsaliyeModel::logInsert] Hata: ' . $e->getMessage());
        }
        return $data;
    }

    protected function logUpdate(array $data)
    {
        try {
            $logData = [
                'irsaliye_id' => $data['id'],
                'islem_tipi' => 'UPDATE',
                'islem_detay' => 'İrsaliye güncellendi',
                'created_by' => session()->get('user_id')
            ];

            $DatabaseConfig = new \App\Controllers\TikoPortal\GeneralConfig();
            $currentDB = $DatabaseConfig->setDBConfigs();
            $db = \Config\Database::connect($currentDB);
            $builder = $db->table('irsaliye_logs');
            $builder->insert($logData);
        } catch (\Exception $e) {
            log_message('error', '[IrsaliyeModel::logUpdate] Hata: ' . $e->getMessage());
        }
        return $data;
    }

    protected function logDelete(array $data)
    {
        try {
            $logData = [
                'irsaliye_id' => $data['id'],
                'islem_tipi' => 'DELETE',
                'islem_detay' => 'İrsaliye silindi',
                'created_by' => session()->get('user_id')
            ];

            $DatabaseConfig = new \App\Controllers\TikoPortal\GeneralConfig();
            $currentDB = $DatabaseConfig->setDBConfigs();
            $db = \Config\Database::connect($currentDB);
            $builder = $db->table('irsaliye_logs');
            $builder->insert($logData);
        } catch (\Exception $e) {
            log_message('error', '[IrsaliyeModel::logDelete] Hata: ' . $e->getMessage());
        }
        return $data;
    }
} 