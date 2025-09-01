<?php

namespace App\Controllers\TikoERP;
use App\Controllers\BaseController;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoERP\MoneyUnitModel;
use App\Controllers\TikoERP\Log;

class Cron extends BaseController
{
    private $DatabaseConfig;
    private $currentDB;
    private $logClass;
    private $MainDB;
    private $MoneyUnitModel;

    private $userGuncellemeDB;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);
        $this->MainDB = \Config\Database::connect();

        // MoneyUnitModel kullanımı
        $this->MoneyUnitModel = new MoneyUnitModel($db_connection);
        $this->logClass = new Log();
    }

    
    public function updateExchangeRates()
    {
        // TCMB'den XML dosyasını çekiyoruz
        $xml = simplexml_load_file('https://www.tcmb.gov.tr/kurlar/today.xml');
    
        if ($xml === false) {
            log_message('error', 'Döviz kurları XML dosyası alınamadı.');
            return;
        }
    
        // Hedef döviz kurları
        $targetCurrencies = ['USD' => 'DOLAR', 'EUR' => 'EURO', 'TRY' => 'TÜRK LİRASI'];
    
        // Güncel tarih ve saat
        $currentDateTime = date('Y-m-d H:i:s');
    
        // Kullanıcı veritabanlarını alıyoruz
        $userApp = $this->MainDB->table("user_app")->get()->getResult();
    
        // EUR/USD çapraz kuru için bir değişken tanımlıyoruz
        $eurToUsdRate = null;
    
        // Döviz kurları bellekte tutulacak
        $currencies = [];
    
        // Tüm döviz kurlarını bellekte saklıyoruz
        foreach ($xml->Currency as $currency) {
            $currencyCode = (string)$currency['Kod'];
    
            // Hedef döviz kodlarıyla eşleşen dövizleri bellekte saklıyoruz
            if (array_key_exists($currencyCode, $targetCurrencies)) {
                $currencies[$currencyCode] = $currency;
            }
        }
    
        // Önce EUR'yu işliyoruz (EUR/USD çapraz kuru için)
        if (isset($currencies['EUR'])) {
            $currency = $currencies['EUR'];
            $eurToUsdRate = (float)$currency->CrossRateOther; // EUR/USD çapraz kuru
            $forexBuying = (float)$currency->ForexBuying;
    
            $data = [
                'money_value' => $forexBuying,
                'usdeuro'     => $eurToUsdRate,
                'guncelleme'  => $currentDateTime
            ];
    
            // EUR için veritabanı güncelleme işlemi
            foreach ($userApp as $app) {
                if (!empty($app->db_host)) {
                    $userMoneyDB = [
                        'hostname' => $app->db_host,
                        'username' => $app->db_username,
                        'password' => $app->db_password,
                        'database' => $app->db_name,
                        'DBDriver' => 'MySQLi',
                        'DBPrefix' => '',
                        'pConnect' => false,
                        'DBDebug'  => false,
                        'charset'  => 'utf8',
                        'DBCollat' => 'utf8_general_ci',
                        'swapPre'  => '',
                        'encrypt'  => false,
                        'compress' => false,
                        'strictOn' => false,
                        'failover' => [],
                        'port'     => 3306,
                    ];
    
                    try {
                        $userGuncellemeDB = \Config\Database::connect($userMoneyDB);
                        $builder = $userGuncellemeDB->table('money_unit');
                        $result = $builder->where('money_code', 'EUR')
                                          ->set($data)
                                          ->update();
    
                        if ($result) {
                            echo "EUR güncellemesi başarılı.\n";
                        } else {
                            echo "EUR güncellemesi başarısız.\n";
                        }
                    } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                        echo "Bağlantı hatası: " . $e->getMessage() . "\n";
                        continue;
                    }
                }
            }
        }
    
        // Şimdi USD'yi işliyoruz ve EUR/USD oranını kullanıyoruz
        if (isset($currencies['USD'])) {
            $currency = $currencies['USD'];
            $forexBuying = (float)$currency->ForexBuying;
    
            $data = [
                'money_value' => $forexBuying,
                'usdeuro'     => $eurToUsdRate, // EUR/USD oranı burada kullanılıyor
                'guncelleme'  => $currentDateTime
            ];
    
            // USD için veritabanı güncelleme işlemi
            foreach ($userApp as $app) {
                if (!empty($app->db_host)) {
                    $userMoneyDB = [
                        'hostname' => $app->db_host,
                        'username' => $app->db_username,
                        'password' => $app->db_password,
                        'database' => $app->db_name,
                        'DBDriver' => 'MySQLi',
                        'DBPrefix' => '',
                        'pConnect' => false,
                        'DBDebug'  => false,
                        'charset'  => 'utf8',
                        'DBCollat' => 'utf8_general_ci',
                        'swapPre'  => '',
                        'encrypt'  => false,
                        'compress' => false,
                        'strictOn' => false,
                        'failover' => [],
                        'port'     => 3306,
                    ];
    
                    try {
                        $userGuncellemeDB = \Config\Database::connect($userMoneyDB);
                        $builder = $userGuncellemeDB->table('money_unit');
                        $result = $builder->where('money_code', 'USD')
                                          ->set($data)
                                          ->update();
    
                        if ($result) {
                            echo "USD güncellemesi başarılı.\n";
                        } else {
                            echo "USD güncellemesi başarısız.\n";
                        }
                    } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                        echo "Bağlantı hatası: " . $e->getMessage() . "\n";
                        continue;
                    }
                }
            }
        }
    }

      
}