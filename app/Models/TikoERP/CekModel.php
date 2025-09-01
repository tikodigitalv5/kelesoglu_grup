<?php

namespace App\Models\TikoERP;

use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\Model;

class CekModel extends Model
{
    protected $table = 'cekler';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    
    protected $allowedFields = [
        'user_id',
        'cari_id',
        'bank_id',
        'cek_para_birimi',
        'cek_durum',
        'cek_tutar',
        'cek_kur',
        'cek_reel_tutar',
        'cek_no',
        'tahsilat_tarihi',
        'vade_tarihi',
        'islem_notu'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    const DURUM_BEKLEMEDE = 'BEKLEMEDE';
    const DURUM_TAHSIL = 'TAHSIL';
    const DURUM_CIRO = 'CIRO';
    const DURUM_IADE = 'IADE';

    public function getCeklerWithDetails()
    {
        return $this->select('cekler.*, 
                            cari.name, cari.company_type, cari.surname, cari.invoice_title,
                            bank.bank_title')
                    ->join('cari', 'cari.cari_id = cekler.cari_id')
                    ->join('bank', 'bank.bank_id = cekler.bank_id')
                    ->where('cekler.deleted_at IS NULL')
                    ->orderBy('cekler.vade_tarihi', 'ASC')
                    ->findAll();
    }

    public function getCekById($id)
    {
        return $this->select('cekler.*, 
                            cari.name, cari.surname, cari.invoice_title,
                            bank.bank_title')
                    ->join('cari', 'cari.cari_id = cekler.cari_id')
                    ->join('bank', 'bank.bank_id = cekler.bank_id')
                    ->where('cekler.id', $id)
                    ->first();
    }
}