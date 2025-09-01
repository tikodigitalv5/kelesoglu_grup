<?php


// app/Controllers/Api/FaturaController.php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Database\Config;

class FaturaController extends ResourceController
{
    protected $format    = 'json'; // Yanıt formatı

    public function index()
    {
        // Kullanıcıdan gelen veritabanı ayrıntılarını al
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

        // Veritabanı bağlantısını oluştur
        $db = \Config\Database::connect($userDatabaseDetail);

        // 'invoice' ve 'invoice_rows' tablolarını birleştirerek sorgu yap
        $builder = $db->table('invoice');
        $builder->select('invoice.*, invoice_row.*');
        $builder->where("invoice.invoice_id", 123);
        $builder->join('invoice_row', 'invoice.invoice_id = invoice_row.invoice_id', 'left');
        $query = $builder->get();

        // Verileri organize et
        $results = $query->getResultArray();

        // Verileri gruplama
        $invoices = [];
        foreach ($results as $row) {
            $invoiceId = $row['invoice_id'];
            if (!isset($invoices[$invoiceId])) {
                $invoices[$invoiceId] = [
                    'invoice' => [
                        'invoice_id' => $row['invoice_id'],
                        'invoice_no' => $row['invoice_no'],
                        // diğer invoice alanları
                    ],
                    'rows' => []
                ];
            }

            if ($row['invoice_row_id']) { // Eğer invoice_rows tablosunda veri varsa
                $invoices[$invoiceId]['rows'][] = [
                    'invoice_row_id' => $row['invoice_row_id'],
                    'invoice_id' => $row['invoice_id'],
                    'stock_title' => $row['stock_title'],
                    'stock_amount' => $row['stock_amount'],
                    'price' => $row['total_price'],
                    // diğer invoice_rows alanları
                ];
            }
        }

        // JSON formatında yanıt dön
        return $this->respond(array_values($results));
    }


    public function fatura($id)
    {
        // Kullanıcıdan gelen veritabanı ayrıntılarını al
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
    
        // Veritabanı bağlantısını oluştur
        $db = \Config\Database::connect($userDatabaseDetail);
    
        // 'invoice' ve 'invoice_row' tablolarını birleştirerek sorgu yap
        $builder = $db->table('invoice');
        $builder->select('invoice.*, invoice_row.*');
        $builder->join('invoice_row', 'invoice.invoice_id = invoice_row.invoice_id', 'left');
        $builder->where("invoice.invoice_id", $id);
        $query = $builder->get();
    
        // Verileri organize et
        $results = $query->getResultArray();
    
        // Verileri gruplama
        $invoices = [];
 

        return $this->respond(array_values($results));

    }
}
