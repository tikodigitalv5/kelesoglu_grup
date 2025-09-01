<?php
namespace App\Models\TikoERP;

use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\Model;

class IslemLoglariModel extends Model
{
    protected $table = 'islem_loglari';  // Bağlantılı tablo adı
    protected $primaryKey = 'islem_log_id';  // Birincil anahtar (primary key)

    // Tablo alanları
    protected $allowedFields = [
        'client_id', 
        'user_id', 
        'siparis_id',
        'stock_id',
        'fatura_id',
        'sevk_id',
        'log_islem_id', 
        'log_durum', 
        'log_islem', 
        'log_mesaj', 
        'log_ham_data', 
        'islemi_yapan', 
        'islem', 
        'ip', 
        'lokasyon', 
        'isletim_sistemi', 
        'created_at', 
        'deleted_at'
    ];

    // Zaman damgaları ayarları
    protected $useTimestamps = true;  // created_at, updated_at otomatik yönetimi
    protected $createdField  = 'created_at';  // 'created_at' alanını kullan
    protected $updatedField  = null;  // 'updated_at' kullanmadığınız için null
    protected $deletedField  = 'deleted_at';  // Soft delete için 'deleted_at' alanı
    
    // Varsayılan değerler
    protected $returnType     = 'array';  // Sonuçlar dizi olarak dönecek
    protected $useSoftDeletes = true;  // Soft delete aktif



    // Log kaydını oluşturmak için basit bir fonksiyon
    public function LogOlustur($client_id, $user_id, $log_islem_id, $log_durum, $log_islem, $log_mesaj, $user_adi,$log_ham_data = null, $stock_id = 0, $siparis_id = 0, $fatura_id = 0, $sevk_id = 0)
    {
       $ip_adres = \Config\Services::request()->getIPAddress();
       if($ip_adres == "::1"){
        $ip_adres = $this->get_client_ip();
       }
        $logData = [
            'client_id' => $client_id,
            'user_id' => $user_id,
            'log_islem_id' => $log_islem_id,
            'stock_id' => $stock_id,
            'siparis_id' => $siparis_id,
            'fatura_id' => $fatura_id,
            'sevk_id' => $sevk_id,
            'log_durum' => $log_durum,  // 'ok' veya 'hata'
            'log_islem' => $log_islem,  // 'siparis', 'fatura', 'barkod'
            'log_mesaj' => $log_mesaj,
            'log_ham_data' => $log_ham_data,  // Ham veri, isteğe bağlı
            'islemi_yapan' => $user_adi,  // Kullanıcı adı veya ID
            'islem' => $log_mesaj,  // İşlem mesajı, isteğe bağlı
            'ip' => $ip_adres,  // IP adresi
            'lokasyon' => "", //$this->getLokasyonFromIP($ip_adres),  // Lokasyon
            'isletim_sistemi' => $this->getIsletimSistemi()  // İşletim sistemi
        ];

        // Veritabanına kaydediyoruz
        return $this->insert($logData);
    }

    // Kullanıcının işletim sistemi bilgisini almak için fonksiyon
    private function getIsletimSistemi()
    {
        $userAgent = \Config\Services::request()->getUserAgent();
        return $userAgent->getPlatform();  // İşletim sistemi bilgisi
    }

    private function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = '127.0.0.1';
        return $ipaddress;
    }

    // Kullanıcının lokasyon bilgisini almak için basit bir yöntem (isteğe bağlı)
    private function getLokasyonFromIP($ip)
    {
        try {
            // IP API endpoint
            $apiURL = "http://ip-api.com/php/{$ip}?fields=status,message,continent,country,countryCode,region,regionName,city,district,zip,lat,lon,timezone,isp,org,as,mobile,query";
        
            // API'den yanıt almak için cURL kullanıyoruz
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $apiURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 5, // 5 saniye timeout
                CURLOPT_SSL_VERIFYPEER => false
            ]);
            
            $result = curl_exec($ch);
            $curl_error = curl_error($ch);
            curl_close($ch);

            if ($curl_error) {
                log_message('error', 'IP API CURL hatası: ' . $curl_error);
                return 'Lokasyon bilgisi alınamadı';
            }

            if (!$result) {
                return 'Lokasyon bilgisi alınamadı';
            }

            // API'den gelen veriyi PHP dizisine dönüştürüyoruz
            $data = @unserialize($result);
            
            if (!$data || !is_array($data)) {
                return 'Lokasyon verisi işlenemedi';
            }

            // API durumu başarılıysa
            if (isset($data['status']) && $data['status'] === 'success') {
                $il = $data['regionName'] ?? 'Bilinmiyor';
                $ilce = $data['district'] ?? 'Bilinmiyor';
                $lat = $data['lat'] ?? '';
                $lon = $data['lon'] ?? '';

                return "{$ilce}, {$il}" . ($lat && $lon ? " Kordinat: Enlem: {$lat} Boylam: {$lon}" : '');
            }

            return 'Lokasyon bulunamadı: ' . ($data['message'] ?? 'Bilinmeyen hata');

        } catch (\Exception $e) {
            log_message('error', 'getLokasyonFromIP hatası: ' . $e->getMessage());
            return 'Lokasyon bilgisi alınamadı';
        }
    }

    // Kullanıcı adını almak için örnek fonksiyon
    private function getIslemiYapan($user_id)
    {
        // Burada kullanıcı veritabanından sorgulanabilir ya da direkt user_id kullanabiliriz
        // Örnek olarak sadece user_id döndürüyoruz
        return "Kullanıcı #" . $user_id;
    }

}