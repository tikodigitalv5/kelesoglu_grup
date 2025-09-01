<?php

use Faker\Core\Uuid;
use Config\Database;
use Config\Config;


function convert_number_for_sql($val){
    $val = $val ?? '0,00';
    return str_replace(',', '.', str_replace('.', '', $val));
}

function convert_number_for_form($val, $number_of_decimal_places = 4){
    return number_format($val, $number_of_decimal_places, ',', '.');
}

function get_uuid() {

    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      // 32 bits for the time_low
      mt_rand(0, 0xffff), mt_rand(0, 0xffff),
      // 16 bits for the time_mid
      mt_rand(0, 0xffff),
      // 16 bits for the time_hi,
      mt_rand(0, 0x0fff) | 0x4000,

      // 8 bits and 16 bits for the clk_seq_hi_res,
      // 8 bits for the clk_seq_low,
      mt_rand(0, 0x3fff) | 0x8000,
      // 48 bits for the node
      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
  }

  function convert_number_uretim($val)
  {
    return rtrim(rtrim(number_format($val, 4, '.', ''), '0'), '.');
  }


  function getDynamicDBConnection()
  {
      // Kullanıcı veritabanı bilgilerini session'dan alıyoruz
      $userDatabaseDetail = [
        'hostname' => session()->get("user_item")["db_host"],
        'username' => session()->get("user_item")["db_username"],
        'password' => session()->get("user_item")["db_password"],
        'database' => session()->get("user_item")["db_name"],
        'DBDriver' => 'MySQLi', 
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
      ];
  
      // Dinamik veritabanı bağlantısını oluşturuyoruz
      $userGuncellemeDB = Database::connect($userDatabaseDetail);
  
      // Model kullanarak verileri çekiyoruz
      $model = new \App\Models\TikoERP\MoneyUnitModel($userGuncellemeDB);
  
      // Kullanıcıya ait verileri getiriyoruz ve return ediyoruz
      return $model->where("user_id", session()->get('user_id'))->findAll();
  }

  function altkategorilerHelper() {

    $userDatabaseDetail = [
      'hostname' => session()->get("user_item")["db_host"],
      'username' => session()->get("user_item")["db_username"],
      'password' => session()->get("user_item")["db_password"],
      'database' => session()->get("user_item")["db_name"],
      'DBDriver' => 'MySQLi', 
      'DBPrefix' => '',
      'pConnect' => false,
      'DBDebug'  => (ENVIRONMENT !== 'production'),
      'charset'  => 'utf8',
      'DBCollat' => 'utf8_general_ci',
      'swapPre'  => '',
      'encrypt'  => false,
      'compress' => false,
      'strictOn' => false,
      'failover' => [],
      'port'     => 3306,
    ];

    // Dinamik veritabanı bağlantısını oluşturuyoruz
    $userGuncellemeDB = Database::connect($userDatabaseDetail);
    
    $model = new \App\Models\TikoERP\AltCategoryModel($userGuncellemeDB);
    return $model->findAll(); 
  }