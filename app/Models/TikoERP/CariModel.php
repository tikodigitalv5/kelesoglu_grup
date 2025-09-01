<?php 

namespace App\Models\TikoERP;

use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\Model;

class CariModel extends Model {

    protected $table      = 'cari';
    protected $primaryKey = 'cari_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'user_id',
        'cari_code',
        'money_unit_id',
        'identification_number',
        'tax_administration',
        'invoice_title',
        'name',
        'surname',
        'obligation',
        'company_type',
        'cari_phone',
        'cari_email',
        'cari_balance',
        'cari_note',
        'is_customer',
        'is_supplier',
        'is_export_customer'
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;

    protected $afterInsert = ['afterInsert'];
    protected $afterUpdate = ['afterUpdate'];
    protected $afterDelete = ['afterDelete'];

    protected $modelFinancialMovement;



    protected function afterInsert(array $data){
        $DatabaseConfig = new GeneralConfig();
        $currentDB = $DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($currentDB);
        $modelLog = model('App\Models\TikoERP\LogModel', true, $db_connection);

        $log_data = [
            'user_id' => session()->get('client_id'),
            'log_type' => 'success',
            'authorized_user_id' => session()->get('authorized_user_id'),
            'model_name' => 'cari',
            'affected_id' => $data['id'],
            'after_action' => json_encode($data['data']),
            'log_action' => 'create',
            'log_message' => null,
            'request_data' => json_encode($_POST),
        ];
        $modelLog->insert($log_data);
    }

    protected function afterUpdate(array $data){
        $DatabaseConfig = new GeneralConfig();
        $currentDB = $DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($currentDB);
        $modelLog = model('App\Models\TikoERP\LogModel', true, $db_connection);

        $log_data = [
            'user_id' => session()->get('client_id'),
            'log_type' => 'success',
            'authorized_user_id' => session()->get('authorized_user_id'),
            'model_name' => 'cari',
            'affected_id' => $data['id'],
            'after_action' => json_encode($data['data']),
            'log_action' => 'update',
            'log_message' => null,
            'request_data' => json_encode($_POST),
        ];
        $modelLog->insert($log_data);
    }

    protected function afterDelete(array $data){
        $DatabaseConfig = new GeneralConfig();
        $currentDB = $DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($currentDB);
        $modelLog = model('App\Models\TikoERP\LogModel', true, $db_connection);
        
        $log_data = [
            'user_id' => session()->get('client_id'),
            'log_type' => 'success',
            'authorized_user_id' => session()->get('authorized_user_id'),
            'model_name' => 'cari',
            'affected_id' => $data['id'],
            'after_action' => json_encode($data['data']),
            'log_action' => 'delete',
            'log_message' => null,
            'request_data' => json_encode($_POST),
        ];
        $modelLog->insert($log_data);
    }

    public function bakiyeHesapla($cari_id)
    {

        $this->modelFinancialMovement = new \App\Models\TikoERP\FinancialMovementModel;

        $DatabaseConfig = new GeneralConfig();
        $currentDB = $DatabaseConfig->setDBConfigs();

      
        $db_connection = \Config\Database::connect($currentDB);
        
        // Cari kaydını alıyoruz
        $cari_item = $db_connection->table("cari")->where('cari_id', $cari_id)->get()->getRowArray();
    
        if (!$cari_item) {
            return ['icon' => 'error', 'message' => 'Geçerli bir cari bulunamadı.'];
        }
    
        // Başlangıç bakiyesi
        $toplam_bakiye = 0;
    
        // Bu cari_id'ye ait tüm finansal hareketleri alalım
        $financial_movements = $db_connection->table("financial_movement")->where('cari_id', $cari_id)->get()->getResultArray();

    
        // Tüm finansal hareketleri işlem türlerine göre işleyelim
        foreach ($financial_movements as $movement) {
            $transaction_amount = ($movement['virman'] != '' && $movement['virman'] != 0 ) ? $movement['virman'] : $movement['transaction_amount'];

            $transaction_type = $movement['transaction_type'];
            $transaction_id = $movement['financial_movement_id']; // Hangi işlemde olduğumuzu anlamak için
            $virman = $movement['virman']; // Hangi işlemde olduğumuzu anlamak için
            
    
            // İşlem türüne göre bakiyeyi güncelleme
            switch ($transaction_type) {
                case 'outgoing_invoice': // Alış faturası: Bakiye artar
                case 'payment':       // Tahsilat: Bakiye artar
                     // virman değeri doluysa  transaction_amount değerini  $virman yap 

                    $toplam_bakiye += $transaction_amount;
                    break;
                    
                case 'incoming_invoice': // Satış faturası: Bakiye düşer
                case 'collection':          // Ödeme: Bakiye düşer
                    // virman değeri doluysa  transaction_amount değerini  $virman yap 
                    $toplam_bakiye -= $transaction_amount;
                    break;
    
                case 'starting_balance': // Başlangıç bakiyesi
                    if ($transaction_amount < 0) {
                        $toplam_bakiye -= abs($transaction_amount);
                    } else {
                        $toplam_bakiye += abs($transaction_amount);
                    }
                    break;
    
                case 'borc_alacak': // Borç/Alacak
                    if ($transaction_amount < 0) {
                        $toplam_bakiye -= abs($transaction_amount);
                    } else {
                        $toplam_bakiye += abs($transaction_amount);
                    }
                    break;
    
                case 'incoming_virman': // Virmanlar (Etki yok)
                case 'outgoing_virman':
                    break;
            }
        }
    
        // Cari bakiyesini güncelle
        $update_cari_data = [
            'cari_balance' => $toplam_bakiye
        ];
        $db_connection->table("cari")
        ->where('cari_id', $cari_item['cari_id'])
        ->update(['cari_balance' => $toplam_bakiye]);

    
        // Bakiyenin negatif olduğunu belirterek döndürelim
        if ($toplam_bakiye < 0) {
            echo "Bakiyeniz negatif: $toplam_bakiye<br>";
        }
    
        return [
            'icon' => 'success',
            'message' => 'Cari bakiyesi başarıyla güncellendi.',
            'guncel_bakiye' => $toplam_bakiye
        ];
    }

}




?>