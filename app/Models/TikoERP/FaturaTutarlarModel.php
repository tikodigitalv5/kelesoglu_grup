<?php

namespace App\Models;

use CodeIgniter\Model;

class FaturaTutarlarModel extends Model
{
    protected $table = 'fatura_tutarlar'; // Tablo adı
    protected $primaryKey = 'satir_id';   // Birincil anahtar

    protected $returnType     = 'array';


    // Kullanılacak alanlar
    protected $allowedFields = [
        'user_id',
        'cari_id',
        'fatura_id',
        'kur',
        'toplam_tutar',
        'tarih',
        'kur_value',
        'default',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Zaman damgası otomatik olarak eklensin mi?
    protected $useTimestamps = true;

    // Tarih alanları (created_at, updated_at, deleted_at)
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Kurallar ve hata mesajları (isteğe bağlı)
    protected $validationRules = [
        'user_id'      => 'required|integer',
        'cari_id'      => 'required|integer',
        'fatura_id'    => 'required|integer',
        'toplam_tutar' => 'required|max_length[50]',
        'tarih'        => 'required|max_length[50]',
    ];

    protected $validationMessages = [
        'user_id'      => ['required' => 'Kullanıcı ID zorunludur'],
        'cari_id'      => ['required' => 'Cari ID zorunludur'],
        'fatura_id'    => ['required' => 'Fatura ID zorunludur'],
        'toplam_tutar' => ['required' => 'Toplam tutar zorunludur'],
        'tarih'        => ['required' => 'Tarih zorunludur'],
    ];

    // Soft delete (yumuşak silme) işlemi için kullanılacak
    protected $useSoftDeletes = true;

}