<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;

use App\Controllers\TikoERP\Log;
use App\Controllers\TikoERP\Cari;
use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\HTTP\Request;
use CodeIgniter\I18n\Time;
use DateTime;
use DateTimeZone;
use PHPUnit\Util\Json;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\API\ResponseTrait;

use function PHPUnit\Framework\returnSelf;

/**
 * @property IncomingRequest $request
 */
ini_set('memory_limit', '1024M');


class Invoice extends BaseController
{
    private $DatabaseConfig;
    private $currentDB;

    private $modelCari;
    private $modelMoneyUnit;
    private $modelFinancialAccount;
    private $modelFinancialMovement;
    private $modelAddress;
    private $modelStock;
    private $modelInvoice;
    private $modelNote;
    private $modelInvoiceSerial;
    private $modelInvoiceRow;
    private $modelStockWarehouseQuantity;
    private $modelStockBarcode;
    private $modelStockMovement;
    private $modelWarehouse;

    private $modelUnit;

    private $logClass;
    private $modelVariantGroup;
    private $modelVariantProperty;
    private $modelOrder;
    private $modelOrderRow;
    private $modelFaturaTutar;

    private $modelOffer;
    private $modelOfferRow;

    private $modelInvoiceOutStatus;
    private $modelInvoiceInStatus;
    private $modelIslem;


    
    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);
        $this->modelVariantGroup = model($TikoERPModelPath . '\VariantGroupModel', true, $db_connection);
        $this->modelVariantProperty = model($TikoERPModelPath . '\VariantPropertyModel', true, $db_connection);
        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
        $this->modelFinancialAccount = model($TikoERPModelPath . '\FinancialAccountModel', true, $db_connection);
        $this->modelFinancialMovement = model($TikoERPModelPath . '\FinancialMovementModel', true, $db_connection);
        $this->modelMoneyUnit = model($TikoERPModelPath . '\MoneyUnitModel', true, $db_connection);
        $this->modelAddress = model($TikoERPModelPath . '\AddressModel', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath . '\StockModel', true, $db_connection);
        $this->modelInvoice = model($TikoERPModelPath . '\InvoiceModel', true, $db_connection);
        $this->modelNote = model($TikoERPModelPath . '\NoteModel', true, $db_connection);
        $this->modelInvoiceSerial = model($TikoERPModelPath . '\InvoiceSerialModel', true, $db_connection);
        $this->modelInvoiceRow = model($TikoERPModelPath . '\InvoiceRowModel', true, $db_connection);
        $this->modelStockWarehouseQuantity = model($TikoERPModelPath . '\StockWarehouseQuantityModel', true, $db_connection);
        $this->modelStockBarcode = model($TikoERPModelPath . '\StockBarcodeModel', true, $db_connection);
        $this->modelStockMovement = model($TikoERPModelPath . '\StockMovementModel', true, $db_connection);
        $this->modelUnit = model($TikoERPModelPath . '\UnitModel', true, $db_connection);
        $this->modelWarehouse = model($TikoERPModelPath . '\WarehouseModel', true, $db_connection);
        $this->modelOrder = model($TikoERPModelPath . '\OrderModel', true, $db_connection);
        $this->modelOrderRow = model($TikoERPModelPath . '\OrderRowModel', true, $db_connection);
        $this->modelFaturaTutar = model($TikoERPModelPath . '\FaturaTutarlarModel', true, $db_connection);
        $this->modelOffer = model($TikoERPModelPath . '\OfferModel', true, $db_connection);
        $this->modelOfferRow = model($TikoERPModelPath . '\OfferRowModel', true, $db_connection);
        $this->modelIslem = model($TikoERPModelPath . '\IslemLoglariModel', true, $db_connection);

        $this->modelInvoiceOutStatus = model($TikoERPModelPath . '\InvoiceOutgoingStatusModel', true, $db_connection);
        $this->modelInvoiceInStatus = model($TikoERPModelPath . '\InvoiceIncomingStatusModel', true, $db_connection);
        $this->logClass = new Log();
        


        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
        helper('Helpers\stock_func_helper');
    }

    public function getUnits()
    {
        $unit_items = $this->modelUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();

        echo json_encode(['icon' => 'success', 'message' => 'Birimler başarıyla getirildi.', 'unit_items' => $unit_items]);
        return;
    }


    public function faturaSatirkontrol()
    {
        // Önce fatura satırlarını al
        $fatura_satirlar = $this->modelInvoiceRow
            ->select("invoice_row_id, stock_id")
            ->where('stock_id !=', 0)  // stock_id'si 0 olmayanları al
            ->findAll();
    
        $guncellenen = 0;
        
        foreach($fatura_satirlar as $fatura_satir) {
            // Her satır için stock tablosunda ilgili ürün var mı kontrol et
            $stock_item = $this->modelStock
                ->where('stock_id', $fatura_satir["stock_id"])
                ->first();
                
            // Eğer stock bulunamadıysa (silinmişse)
            if(!$stock_item) {
               
                // Fatura satırındaki stock_id'yi 0 yap
               echo "var";
                    
                $guncellenen++;
            }
        }
        
        return [
            'status' => true,
            'message' => "Toplam {$guncellenen} fatura satırı güncellendi",
            'guncellenen' => $guncellenen
        ];
    } 

    public function getMoneyUnits()
    {
        $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('money_unit_id')->findAll();
        // $money_unit_items = session()->get('money_items');

        // print_r($money_unit_items);
        // return;

        echo json_encode(['icon' => 'success', 'message' => 'Para birimleri başarıyla getirildi.', 'money_unit_items' => $money_unit_items]);
        return;
    }

    //tevkifat tipleri
    public function getWithholding()
    {
        $tevkifat_items = session()->get('withholding_items');

        echo json_encode(['icon' => 'success', 'message' => 'Tevkifatlar başarıyla getirildi.', 'tevkifat_items' => $tevkifat_items]);
        return;
    }

    //istisna tipleri
    public function getExceptionType()
    {
        $exception_type_items = session()->get('exception_type_items');

        echo json_encode(['icon' => 'success', 'message' => 'İstisna tipleri başarıyla getirildi.', 'exception_type_items' => $exception_type_items]);
        return;
    }

    //özel matrah
    public function getSpecialBase()
    {
        $special_base_items = session()->get('special_base_items');

        echo json_encode(['icon' => 'success', 'message' => 'Özel matrah listesi başarıyla getirildi.', 'special_base_items' => $special_base_items]);
        return;
    }

    public function getInvoiceSerial()
    {
        $invoice_serial_items = $this->modelInvoiceSerial->where('user_id', session()->get('user_id'))->findAll();

        echo json_encode(['icon' => 'success', 'message' => 'Fatura serileri başarıyla getirildi.', 'invoice_serial_items' => $invoice_serial_items]);
        return;
    }
    public function getInvoicesRow($cari_id = null)
    {
        $cari_item = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
        ->where('cari.user_id', session()->get('user_id'))
        ->where('cari.cari_id', $cari_id)->first();
      
        $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
        $cari_item["dolarKur"] = $MoneyUnitsDolar["money_value"];
        $cari_item["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
        $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
        $cari_item["euroKur"] = $MoneyUnitsEuro["money_value"];
        $cari_item["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];

    if (!$cari_item) {
        return view('not-found');
    }
    
    $invoice_row_items = $this->modelInvoiceRow
        ->join('invoice', 'invoice.invoice_id=invoice_row.invoice_id')
        ->join('unit', 'unit.unit_id=invoice_row.unit_id')
        ->where('invoice_row.user_id', session()->get('user_id'))
        ->where('invoice_row.cari_id', $cari_id)
        ->select('invoice_row.*, invoice.*, unit.unit_title, invoice_row.created_at,')
        ->orderBy('invoice.invoice_id', 'DESC')
        ->findAll();
       // echo '<pre>';
         //print_r($invoice_row_items);
        //echo '</pre>';
         //return;

        // echo json_encode(['icon' => 'success', 'message' => 'Fatura satırları başarıyla getirildi.', 'invoice_row_count' => count($invoice_row_items), 'invoice_row_items' => $invoice_row_items, ]);
        // return;

        $data = [
            'cari_item' => $cari_item,
            'invoice_row_count' => count($invoice_row_items),
            'invoice_row_items' => $invoice_row_items,
        ];

        return view('tportal/cariler/detay/fatura_hareketler', $data);
    }

    use ResponseTrait;
    public function getInvoices($invoices_type = 'all')
    {
        $builder = $this->modelInvoice
            ->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->join('invoice_serial', 'invoice_serial.invoice_serial_id = invoice.invoice_serial_id', 'LEFT')
            ->select('invoice.user_id,
            invoice_id,
            invoice.invoice_status_id,
            invoice_no,
            expiry_date,
            cari_id,
            invoice.is_quick_sale_receipt,
            money_unit.money_icon,
            invoice_date,
            invoice_type,
            is_quick_collection_financial_movement_id,
            invoice_scenario,
            payment_method,
            invoice_direction,
            invoice_serial_prefix,
            cari_obligation,
            amount_to_be_paid,
            sale_type,
            is_return,
            is_quick_sale_receipt,
            cari_invoice_title,')
            ->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice.cari_id !=', session()->get("user_item")["stock_user"] ?? 0)
            ->where('invoice.deleted_at IS NULL', null, false)
            ->where('invoice.cari_id != 15199', null, false)
            ->orderBy('invoice.invoice_date', 'DESC');

        if ($invoices_type == 'all') {
            $builder = $builder;
        } elseif ($invoices_type == 'outgoing') {
            $builder = $this->modelInvoice->where('invoice_direction', 'outgoing_invoice');
        } elseif ($invoices_type == 'incoming') {
            $builder = $this->modelInvoice->where('invoice_direction', 'incoming_invoice');
        } else {
            return redirect()->back();
        }

        
       

        return DataTable::of($builder)->filter(function ($builder, $request) {
            if($request->invoice_status != "null")
            {

                if ($request->invoice_status == "incoming_invoice")
                $builder->where('invoice_direction', 'incoming_invoice');

                if ($request->invoice_status == "outgoing_invoice")
                    $builder->where('invoice_direction', 'outgoing_invoice');

            }

            if($request->is_quick_collection_financial_movement_id != "null")
            {

                if($request->is_quick_collection_financial_movement_id == 1)
                {
                    $builder->where('is_quick_collection_financial_movement_id > ', 0);
                }else{
                    $builder->where('is_quick_collection_financial_movement_id', 0);
                }

            }
          

               

                if (!empty($request->invoice_date_start) && !empty($request->invoice_date_end)) {
                    try {
                        $start_date = DateTime::createFromFormat('d/m/Y', $request->invoice_date_start)->format('Y-m-d');
                        $end_date = DateTime::createFromFormat('d/m/Y', $request->invoice_date_end)->format('Y-m-d');
                        $builder->where('DATE(invoice.invoice_date) >=', $start_date)
                               ->where('DATE(invoice.invoice_date) <=', $end_date);
                    } catch (\Exception $e) {
                        // Tarih dönüştürme hatası durumunda filtreleme yapma
                    }
                }
    
                if (!empty($request->expiry_date_start) && !empty($request->expiry_date_end)) {
                    try {
                        $start_date = DateTime::createFromFormat('d/m/Y', $request->expiry_date_start)->format('Y-m-d');
                        $end_date = DateTime::createFromFormat('d/m/Y', $request->expiry_date_end)->format('Y-m-d');
                        $builder->where('DATE(invoice.expiry_date) >=', $start_date)
                               ->where('DATE(invoice.expiry_date) <=', $end_date);
                    } catch (\Exception $e) {
                        // Tarih dönüştürme hatası durumunda filtreleme yapma
                    }
                }
          

        })->add('giden_fatura_durumlar', function ($row) {
           
            $invoice_out_statusler = $this->modelInvoiceOutStatus->findAll();
            return $invoice_out_statusler;
        })
        ->add('gelen_fatura_durumlar', function ($row) {
           
            $invoice_in_statusler = $this->modelInvoiceInStatus->findAll();
            return $invoice_in_statusler;
        })
        ->setSearchableColumns(['invoice.cari_invoice_title', 'invoice.invoice_no'])
            ->toJson(true);
    }


     public function UrunEskiFiyatlar($stock_id = null)
     {
        $stock_item = $this->modelStock->where('stock_id', $stock_id)->first();
        
        // Bu stock_id için daha önce satılmış olan farklı birim fiyatlarını al
        $db_connection = \Config\Database::connect($this->currentDB);
        
        // Debug: Önce bu stock_id için kaç kayıt var kontrol edelim
        $total_records = $db_connection->table('invoice_row')
            ->where('stock_id', $stock_id)
            ->countAllResults();
        
        // Debug: Tüm kayıtları alalım (fiyat filtresi olmadan)
        $all_records = $db_connection->table('invoice_row')
            ->select('unit_price, unit_id, created_at, invoice_id, stock_id')
            ->where('stock_id', $stock_id)
            ->get()
            ->getResultArray();
        
        $eski_fiyatlar = $db_connection->table('invoice_row')
            ->select('invoice_row.unit_price, invoice_row.unit_id, invoice_row.created_at, invoice_row.invoice_id')
            ->join('invoice', 'invoice.invoice_id = invoice_row.invoice_id', 'left')
            ->select('invoice.cari_invoice_title, invoice.cari_name, invoice.cari_surname')
            ->where('invoice_row.stock_id', $stock_id)
            ->where('invoice_row.unit_price >', 0)
            ->groupBy('invoice_row.unit_price, invoice_row.unit_id')
            ->orderBy('invoice_row.created_at', 'DESC')
            ->get()
            ->getResultArray();
        
        // Birim bilgilerini de al
        $birimler = [];
        if (!empty($eski_fiyatlar)) {
            $unit_ids = array_column($eski_fiyatlar, 'unit_id');
            $birimler = $db_connection->table('unit')
                ->select('unit_id, unit_title')
                ->whereIn('unit_id', $unit_ids)
                ->get()
                ->getResultArray();
            
            // Birim bilgilerini eski fiyatlarla birleştir
            $birim_map = [];
            foreach ($birimler as $birim) {
                $birim_map[$birim['unit_id']] = $birim['unit_title'];
            }
            
            foreach ($eski_fiyatlar as &$fiyat) {
                $fiyat['unit_title'] = $birim_map[$fiyat['unit_id']] ?? '';
                
                // Müşteri adını belirle
                if (!empty($fiyat['cari_invoice_title'])) {
                    $fiyat['musteri_adi'] = $fiyat['cari_invoice_title'];
                } else {
                    $ad = trim($fiyat['cari_name'] ?? '');
                    $soyad = trim($fiyat['cari_surname'] ?? '');
                    $fiyat['musteri_adi'] = trim($ad . ' ' . $soyad);
                }
            }
        }
        
        $data = [
            'stock_item' => $stock_item,
            'eski_fiyatlar' => $eski_fiyatlar,
            'birimler' => $birimler,
            'debug_info' => [
                'total_records_for_stock_id' => $total_records,
                'all_records' => $all_records,
                'stock_id_searched' => $stock_id
            ]
        ];
        
        return $this->response->setJSON($data);
     }

 


    public function edit($invoice_id = null)
    {

        

        $Kurlar = $this->modelMoneyUnit->findAll();


        $transaction_prefix = "PRF";
        $errRows = [];
        $invoice_item = $this->modelInvoice->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->join('invoice_serial', 'invoice_serial.invoice_serial_id = invoice.invoice_serial_id', 'LEFT')
            ->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice.invoice_id', $invoice_id)
            ->first();

      
          /*  if($invoice_item["tiko_imza"] != 0){

                return redirect()->to(route_to("tportal.faturalar.detail", $invoice_id));
                    
             } */
   
    
         if($invoice_item["sale_type"] == "quick"){

        return redirect()->to(route_to("tportal.cari.quick_sale_order.detail", $invoice_item["invoice_id"]));
            

       }
   
    
       
        



        if ($this->request->getMethod('true') == 'POST') {

          


            if (!$invoice_item) {
                echo json_encode(['icon' => 'error', 'message' => 'Fatura bulunamadı.']);
                return;
            }
            # elseif(checkInvoiceStatusForUpdate($invoice_item)){
            #     echo json_encode(['icon' => 'error', 'message' => 'Fatura düzenlemeye uygun değildir.']);
            #     return;
            # }

            try {
                $data_form = $this->request->getPost('data_form');
                $data_invoice_rows = $this->request->getPost('data_invoice_rows');
                $data_invoice_amounts = $this->request->getPost('data_invoice_amounts');
                $data_invoice_irsaliye = $this->request->getPost('data_invoice_irsaliye');  // İrsaliye aktif olduğunda bu gelen data kullanılacak.
                $data_invoice_iade = $this->request->getPost('data_invoice_iade'); // İade satırları aktif olduğunda bu gelen data kullanılacak.

                foreach ($data_form as $data) {
                    $key = $data['name'];
                    $value = $data['value'];
                    $new_data_form[$key] = $value;
                }



               
                // print_r($new_data_form);
                // print_r($data_invoice_rows);
                // print_r($data_invoice_amounts);
                // return;


                $phone = isset($new_data_form['cari_phone']) ? str_replace(array('(', ')', ' '), '', $new_data_form['cari_phone']) : null;
                $phoneNumber = $new_data_form['cari_phone'] ? $new_data_form['area_code'] . " " . $phone : null;

                $invoice_date = $new_data_form['invoice_date'];
                $invoice_time = $new_data_form['invoice_time'];

                $invoice_datetime = convert_datetime_for_sql_time($invoice_date, $invoice_time);

                if (isset($new_data_form['is_expiry']) && $new_data_form['is_expiry'] == 'on') {
                    $expiry_date = $new_data_form['expiry_date'];
                    $payment_method = $new_data_form['payment_method'];
                } else {
                    $expiry_date = $invoice_datetime;
                    $payment_method = null;
                }

                $transaction_amount = isset($data_invoice_amounts['amount_to_be_paid']) ? convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']) : convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try']);
                if ($invoice_item['invoice_direction'] == 'outgoing_invoice') {
                    $transaction_direction = 'exit';
                    $is_customer = 1;
                    $is_supplier = 0;
                    $multiplier_for_cari_balance = 1;
                } else {
                    $transaction_direction = 'entry';
                    $is_customer = 0;
                    $is_supplier = 1;
                    $multiplier_for_cari_balance = -1;
                }

                $cari_balance = null;
                $cari_id = null;
                // $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.identification_number', $new_data_form['identification_number'])->first();
                $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id', $new_data_form['cari_id'])->first();

                // print_r($cari_item);
                // return;



                $kurlar = json_decode($new_data_form["kurlar"], true);
                $faturaAsilTutar = 0;
               foreach($kurlar  as $kur)
               {
                    if($kur["money_unit_id"] == $cari_item["money_unit_id"]){
                        $moneyKod = $this->modelMoneyUnit->where("money_unit_id", $kur["money_unit_id"])->first();
                        $fiyatBul = "kur_toplam_fiyat_" . $moneyKod["money_code"];
                        $faturaAsilTutar =  $kur[$fiyatBul];
                    }
               }

               if(!empty($faturaAsilTutar) || !isset($faturaAsilTutar))
               {
                $faturaAsilTutar = $transaction_amount;
               }


                if ((isset($new_data_form['is_customer_save']) && $new_data_form['is_customer_save'] == 'on') || !$cari_item) {

                    if (isset($new_data_form['is_export_customer']) && $new_data_form['is_export_customer'] == 'on') {
                        $is_export_customer = 1;
                    } else {
                        $is_export_customer = 0;
                    }
                    $cari_data = [
                        'user_id' => session()->get('user_id'),
                        'money_unit_id' => $data_invoice_amounts['money_unit_id'],
                        'identification_number' => $new_data_form['identification_number'],
                        'tax_administration' => $new_data_form['tax_administration'],
                        'invoice_title' => $new_data_form['invoice_title'],
                        'name' => $new_data_form['name'],
                        'surname' => $new_data_form['surname'],
                        'obligation' => $new_data_form['obligation'],
                        'company_type' => $new_data_form['company_type'],
                        'cari_phone' => $phoneNumber,
                        'cari_email' => $new_data_form['cari_email'],
                        'is_customer' => $is_customer,
                        'is_supplier' => $is_supplier,
                        'is_export_customer' => $is_export_customer,
                    ];

                    $address_data = [
                        'user_id' => session()->get('user_id'),
                        'address_title' => 'Fatura Adresi',
                        'address_country' => $new_data_form['address_country'],
                        'address_city' => $new_data_form['address_city_name'],
                        'address_city_plate' => isset($new_data_form['address_city']) ? $new_data_form['address_city'] : "",
                        'address_district' => isset($new_data_form['address_district']) ? $new_data_form['address_district'] : "",
                        'zip_code' => $new_data_form['zip_code'],
                        'address' => $new_data_form['address'],
                        'address_phone' => $phoneNumber,
                        'address_email' => $new_data_form['cari_email'],
                    ];

                    $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.identification_number', $new_data_form['identification_number'])->first();

                    if (!$cari_item) {
                        //8 rakamlı cari kodu
                        $create_cari_code = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
                        $cari_data['cari_code'] = $create_cari_code;
                        $cari_data['cari_balance'] = $multiplier_for_cari_balance * $faturaAsilTutar;
                        $this->modelCari->insert($cari_data);
                        $cari_id = $this->modelCari->getInsertID();
                        $address_data['cari_id'] = $cari_id;
                        $address_data['status'] = 'active';
                        $address_data['default'] = 'true';
                        $this->modelAddress->insert($address_data);
                    } else {
                        $cari_id = $cari_item['cari_id'];
                        $cari_address_id = $cari_item['address_id'];
                        $cari_balance = $cari_item['cari_balance'] + ($multiplier_for_cari_balance * $faturaAsilTutar);
                        $cari_data['cari_balance'] = $cari_balance;
                        $this->modelCari->update($cari_id, $cari_data);

                        $address_data['cari_id'] = $cari_id;
                        $this->modelAddress->update($cari_address_id, $address_data);
                    }
                } else {
                    $cari_id = $cari_item['cari_id'];
                    $cari_balance = number_format($cari_item['cari_balance'], 2, ',', '.');
                }


                // print_r($cari_id);
                // return;

                if (isset($new_data_form['chk_musteri_bakiye_ekle']) && $new_data_form['chk_musteri_bakiye_ekle'] == 'on') {
                    $invoice_note_id = $new_data_form['invoiceNotesId'];
                    $invoice_note = $new_data_form['txt_fatura_not'] . " - " . $cari_balance;
                } else {
                    $invoice_note_id = $new_data_form['invoiceNotesId'];
                    $invoice_note = $new_data_form['txt_fatura_not'];
                }

                if (isset($new_data_form['chk_not_kaydet']) && $new_data_form['chk_not_kaydet'] == 'on') {
                    $note_item = $this->modelNote->where('note_id', $new_data_form['invoiceNotesId'])->where('user_id', session()->get('user_id'))->first();



                    if (!$note_item) {
                        $insert_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_type' => 'invoice',
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $this->modelNote->insert($insert_invoice_note_data);
                        $invoice_note_id = $this->modelNote->getInsertID();

                    } else {
                        $insert_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_id' => $new_data_form['invoiceNotesId'],
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $invoice_note_id = $new_data_form['invoiceNotesId'];
                        $this->modelNote->update($new_data_form['invoiceNotesId'], $insert_invoice_note_data);
                    }
                }



                // $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                // if ($last_transaction) {
                //     $transaction_counter = $last_transaction['transaction_counter'] + 1;
                // } else {
                //     $transaction_counter = 1;
                // }
                // #insert or update cari_balance and financial_movements
                // $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                // $insert_financial_movement_data = [
                //     'user_id' => session()->get('user_id'),
                //     'financial_account_id' => null,
                //     'cari_id' => $cari_id,
                //     'money_unit_id' => $data_invoice_amounts['money_unit_id'],
                //     'transaction_number' => $transaction_number,
                //     'transaction_direction' => $transaction_direction,
                //     'transaction_type' => $new_data_form['ftr_turu'],
                //     'transaction_tool' => 'not_payroll',
                //     'transaction_title' => 'PRF00000000012',
                //     'transaction_description' => $invoice_note,
                //     'transaction_amount' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try']),
                //     'transaction_real_amount' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try']),
                //     'transaction_date' => $invoice_datetime,
                //     'transaction_prefix' => $transaction_prefix,
                //     'transaction_counter' => $transaction_counter
                // ];
                // $this->modelFinancialMovement->insert($insert_financial_movement_data);

                $update_invoice_data = [
                    'user_id' => session()->get('user_id'),
                    'money_unit_id' => $data_invoice_amounts['money_unit_id'],
                    'invoice_serial_id' => $new_data_form['fatura_seri'],

                    'invoice_no' => $invoice_item['invoice_no'],
                    'invoice_ettn' => $invoice_item['invoice_ettn'],

                    'invoice_direction' => $new_data_form['ftr_turu'],
                    'invoice_scenario' => $new_data_form['fatura_senaryo'],
                    'invoice_type' => $new_data_form['fatura_tipi'],

                    'invoice_date' => $invoice_datetime,

                    'payment_method' => $payment_method,
                    'expiry_date' => $expiry_date,

                    'invoice_note_id' => $invoice_note_id,
                    'invoice_note' => $invoice_note,

                    'currency_amount' => $data_invoice_amounts['currency_amount'],

                    'stock_total' => convert_number_for_sql($data_invoice_amounts['stock_total']),
                    'stock_total_try' => convert_number_for_sql($data_invoice_amounts['stock_total_try']),

                    'discount_total' => convert_number_for_sql($data_invoice_amounts['discount_total']),
                    'discount_total_try' => convert_number_for_sql($data_invoice_amounts['discount_total_try']),

                    'tax_rate_1_amount' => convert_number_for_sql($data_invoice_amounts['tax_rate_1_amount']),
                    'tax_rate_1_amount_try' => convert_number_for_sql($data_invoice_amounts['tax_rate_1_amount_try']),
                    'tax_rate_10_amount' => convert_number_for_sql($data_invoice_amounts['tax_rate_10_amount']),
                    'tax_rate_10_amount_try' => convert_number_for_sql($data_invoice_amounts['tax_rate_10_amount_try']),
                    'tax_rate_20_amount' => convert_number_for_sql($data_invoice_amounts['tax_rate_20_amount']),
                    'tax_rate_20_amount_try' => convert_number_for_sql($data_invoice_amounts['tax_rate_20_amount_try']),

                    'sub_total' => convert_number_for_sql($data_invoice_amounts['sub_total']),
                    'sub_total_try' => convert_number_for_sql($data_invoice_amounts['sub_total_try']),
                    'sub_total_0' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax0']),
                    'sub_total_0_try' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax0_try']),
                    'sub_total_1' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax1']),
                    'sub_total_1_try' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax1_try']),
                    'sub_total_10' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax10']),
                    'sub_total_10_try' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax10_try']),
                    'sub_total_20' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax20']),
                    'sub_total_20_try' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax20_try']),

                    'grand_total' => convert_number_for_sql($data_invoice_amounts['grand_total']),
                    'grand_total_try' => convert_number_for_sql($data_invoice_amounts['grand_total_try']),

                    'amount_to_be_paid' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']),
                    'amount_to_be_paid_try' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try']),

                    'amount_to_be_paid_text' => $data_invoice_amounts['amount_to_be_paid_text'],

                    'cari_id' => $cari_id,
                    'cari_identification_number' => $new_data_form['identification_number'],
                    'cari_tax_administration' => $new_data_form['tax_administration'],

                    'cari_invoice_title' => $new_data_form['invoice_title'] == '' ? $new_data_form['name'] . " " . $new_data_form['surname'] : $new_data_form['invoice_title'],
                    'cari_name' => $new_data_form['name'],
                    'cari_surname' => $new_data_form['surname'],
                    'cari_obligation' => $new_data_form['obligation'],
                    'cari_company_type' => $new_data_form['company_type'],
                    'cari_phone' => $phoneNumber,
                    'cari_email' => $new_data_form['cari_email'],

                    'address_country' => $new_data_form['address_country'],

                    'address_city' => $new_data_form['address_city_name'],
                    'address_city_plate' => isset($new_data_form['address_city']) ? $new_data_form['address_city'] : "",
                    'address_district' => isset($new_data_form['address_district']) ? $new_data_form['address_district'] : "",
                    'address_zip_code' => $new_data_form['zip_code'],
                    'address' => $new_data_form['address'],

                    'invoice_status_id' => "1",
                ];



                $this->modelInvoice->update($invoice_id, $update_invoice_data);



            $this->modelIslem->LogOlustur(
                session()->get('client_id'),
                session()->get('user_id'),
                $invoice_id,
                'ok',
                'fatura',
                "Fatura Başarıyla Güncellendi",
                session()->get("user_item")["user_adsoyad"],
                json_encode( ['invoice_id' => $invoice_id, 'fatura_bilgileri' => $update_invoice_data, 'fatura_satirlari' => $data_invoice_rows]),
                0,
                0,
                $invoice_id,
                0
             );



                $kurlar = json_decode($new_data_form["kurlar"], true);

                foreach ($kurlar as $kur) {
                    // Fatura fiyatı mevcut mu kontrol et (fatura_id ve money_unit_id'yi kontrol ediyoruz)
                    $InvoiceFiyatlar = $this->modelFaturaTutar
                                            ->where("fatura_id", $invoice_id)
                                            ->where("kur", $kur['money_unit_id']) // Ek olarak money_unit_id kontrolü
                                            ->first();
                    
                    // Default değerini belirle
                    $default = ($data_invoice_amounts['money_unit_id'] == $kur['money_unit_id']) ? "true" : "false";

                    // Fiyat verilerini hazırlama
                    $fiyatDatalar = [
                        'user_id'      => session()->get('user_id'),
                        'cari_id'      => $cari_id,
                        'fatura_id'    => $invoice_id,
                        'kur'          => $kur['money_unit_id'],
                        'kur_value'    => $this->convert_sql($kur['money_value']),
                        'toplam_tutar' => $this->convert_sql($kur['kur_toplam_fiyat_' . $kur['money_code']]),
                        'tarih'        => date("d-m-Y h:i"),  // PHP'de date() fonksiyonu kullanılır
                        'default'      => $default
                    ];

                    // Fatura fiyatı mevcutsa güncelle, yoksa ekle
                    if ($InvoiceFiyatlar) {
                        $updateFiyat = $this->modelFaturaTutar->update($InvoiceFiyatlar["satir_id"], $fiyatDatalar);
                        if (!$updateFiyat) {
                            // Güncelleme başarısızsa hata işlemi yapılabilir
                            echo "Fiyat güncellenirken bir hata oluştu.";
                        }
                    } else {
                        $insertFiyat = $this->modelFaturaTutar->insert($fiyatDatalar);
                        if (!$insertFiyat) {
                            // Ekleme başarısızsa hata işlemi yapılabilir
                            echo "Fiyat eklenirken bir hata oluştu.";
                        }
                    }
                }





                $originalInvoiceRowAllData = $this->modelInvoiceRow->where('invoice_id', $invoice_id)->findAll();

                // print_r($data_invoice_rows);
                // print_r($originalInvoiceRowAllData);
                // return;

             

                foreach ($data_invoice_rows as $data_invoice_row) {

                    
                  //  if ($data_invoice_row['stock_id'] == 0) {
                    //    continue;
                    //}

                    $isDeleted = (isset($data_invoice_row["isDeletedInvoice"])) ? $isDeleted = $data_invoice_row["isDeletedInvoice"] : '';
                    $invoice_row_id = $data_invoice_row["invoice_row_id"];

                    $originalInvoiceRowData = $this->modelInvoiceRow->where('invoice_row_id', $invoice_row_id)->first();

                    if ($originalInvoiceRowData) {
                        $originalInvoiceRowData_stock_id = $originalInvoiceRowData['stock_id'];
                        $originalInvoiceRowData_stock_amount = $originalInvoiceRowData['stock_amount'];
                    }

                    $new_invoice_row_stock_id = $data_invoice_row['stock_id'];
                    $new_invoice_row_stock_amount = $data_invoice_row['stock_amount'];



                    if (isset($data_invoice_row['isDeletedInvoice'])) {
                        $this->modelInvoiceRow->where('user_id', session()->get('user_id'))
                            ->where('invoice_row_id', $invoice_row_id)
                            ->delete();
                        continue;
                    }


                    #check if stock exists
                    $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $data_invoice_row['stock_id'])->first();
                    $parent_idd = $stock_item['parent_id'] ?? 0;

                    // if (!$stock_item) {
                    //     $errRows[] = [
                    //         'message' => "Verilen stok bulunamadı.",
                    //         'data' => [
                    //             'stock_id' => $data_invoice_row['stock_id'],
                    //             'stock_title' => $data_invoice_row['stock_title'],
                    //             'gtip_code' => $data_invoice_row['gtip_code'],
                    //             'stock_amount' => $data_invoice_row['stock_amount'],
                    //         ]
                    //     ];
                    //     continue;
                    // }


                    //satır silindiyse
                    if (isset($data_invoice_row['invoice_row_id']) && isset($data_invoice_row['isDeletedInvoice']) && isset($data_invoice_row['stock_id']) && $data_invoice_row['stock_id'] != 0) {

                        $insert_StockWarehouseQuantity = [
                            'user_id' => session()->get('user_id'),
                            'parent_id' => $parent_idd ?? 0,
                            'stock_quantity' => convert_number_for_sql($data_invoice_row['stock_amount'])
                        ];
                        updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $new_data_form['warehouse_id'], $data_invoice_row['stock_id'], $parent_idd, convert_number_for_sql($data_invoice_row['stock_amount']), 'add', $this->modelStockWarehouseQuantity, $this->modelStock);

                        $this->modelInvoiceRow->where('user_id', session()->get('user_id'))
                            ->where('invoice_row_id', $invoice_row_id)
                            ->delete();

                        continue;
                    }

                    if ( $invoice_row_id == 0 || ($data_invoice_row["stock_id"] == $originalInvoiceRowData['stock_id'])) {

                        if ($new_invoice_row_stock_amount > $originalInvoiceRowData_stock_amount) {
                            $aradaki_fark_stok_miktari = $new_invoice_row_stock_amount - $originalInvoiceRowData_stock_amount;

                            $insert_StockWarehouseQuantity = [
                                'user_id' => session()->get('user_id'),
                            'parent_id' => $parent_idd ?? 0,
                            'stock_quantity' => convert_number_for_sql($data_invoice_row['stock_amount'])

                            ];
                            updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $new_data_form['warehouse_id'], $data_invoice_row['stock_id'], $parent_idd, $aradaki_fark_stok_miktari, 'remove', $this->modelStockWarehouseQuantity, $this->modelStock);

                            $stock_barcode_all = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                                ->where('stock_barcode.stock_id', $data_invoice_row['stock_id'])
                                ->where('stock_barcode.warehouse_id', $new_data_form['warehouse_id'])
                                ->findAll();

                            // stock_barcode'da used_amount günceller
                            foreach ($stock_barcode_all as $stock_barcode_item) {

                                $varMi = $stock_barcode_item['total_amount'] - $aradaki_fark_stok_miktari;

                                if ($varMi >= $data_invoice_row['stock_amount']) {

                                    $used_amount = $stock_barcode_item['used_amount'] + $aradaki_fark_stok_miktari;
                                    $stock_barcode_status = $used_amount == $stock_barcode_item['total_amount'] ? 'out_of_stock' : 'available';
                                    $update_stock_barcode_data = [
                                        'used_amount' => $used_amount,
                                        'stock_barcode_status' => $stock_barcode_status
                                    ];
                                    $this->modelStockBarcode->update($stock_barcode_item['stock_barcode_id'], $update_stock_barcode_data);
                                    break 1;
                                }
                            }
                        }

                        if ($new_invoice_row_stock_amount < $originalInvoiceRowData_stock_amount) {
                            $aradaki_fark_stok_miktari = (int)$originalInvoiceRowData_stock_amount - (int)$new_invoice_row_stock_amount;

                            $insert_StockWarehouseQuantity = [
                                'user_id' => session()->get('user_id'),
                                'parent_id' => $parent_idd ?? 0,
                                'stock_quantity' => convert_number_for_sql($data_invoice_row['stock_amount'])
                            ];
                            if(!isset($new_data_form['warehouse_id'])){

                                $modelStockWork = $this->modelStockWarehouseQuantity->where("stock_id", $data_invoice_row['stock_id'])->first();
                                $new_data_form['warehouse_id'] = $modelStockWork["warehouse_id"];
                            }
                   
                            updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $new_data_form['warehouse_id'], $data_invoice_row['stock_id'], $parent_idd, $aradaki_fark_stok_miktari, 'add', $this->modelStockWarehouseQuantity, $this->modelStock);

                            $stock_barcode_all = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                                ->where('stock_barcode.stock_id', $data_invoice_row['stock_id'])
                                ->where('stock_barcode.warehouse_id', $new_data_form['warehouse_id'])
                                ->findAll();

                            // stock_barcode'da used_amount günceller
                            foreach ($stock_barcode_all as $stock_barcode_item) {

                                $varMi = $stock_barcode_item['total_amount'] - $aradaki_fark_stok_miktari;

                                if ($varMi >= $data_invoice_row['stock_amount']) {

                                    $used_amount = $stock_barcode_item['used_amount'] - $aradaki_fark_stok_miktari;
                                    $stock_barcode_status = $used_amount == $stock_barcode_item['total_amount'] ? 'out_of_stock' : 'available';
                                    $update_stock_barcode_data = [
                                        'used_amount' => $used_amount,
                                        'stock_barcode_status' => $stock_barcode_status
                                    ];
                                    $this->modelStockBarcode->update($stock_barcode_item['stock_barcode_id'], $update_stock_barcode_data);
                                    break 1;
                                }
                            }
                        }

                       if(!isset($data_invoice_row['unit_price'])){
                        continue;
                       }

                        $fatura_money_id = $data_invoice_amounts['money_unit_id']; // Para birimi ID'si
                                $unit_price = $data_invoice_row['unit_price'] ?? 0; // Ürün birim fiyatı
                                $new_column_cari = $unit_price; // Varsayılan değer TL

                                // Para birimi 1 ise zaten TL
                                if ($fatura_money_id == 3) {
                                    $new_column_cari = $unit_price;
                                } else {
                                    // Para birimi TL değilse, döviz çarpanını al
                                    $moneyItem = $this->modelMoneyUnit
                                        ->where('user_id', session()->get('user_id'))
                                        ->where('money_unit_id', $fatura_money_id)
                                        ->first();

                                    // Eğer çarpan bulunamazsa varsayılan TL değeri kalır
                                    if ($moneyItem && isset($moneyItem['money_value'])) {
                                        // Unit_price * Döviz çarpanı (TL'ye çevirme)
                                        $new_column_cari = $unit_price * $moneyItem['money_value'];
                                    }
                                }


                        $invoice_row_data = [
                            'user_id' => session()->get('user_id'),
                            'invoice_id' => $invoice_id,
                            'stock_id' => $data_invoice_row['stock_id'],
                            'stock_title' => $data_invoice_row['stock_title'],
                            'stock_amount' => $data_invoice_row['stock_amount'], //convert_number_for_sql($data_invoice_row['stock_amount'])

                            'unit_id' => $data_invoice_row['unit_id'],
                            'unit_price' => $data_invoice_row['unit_price'],
                            'unit_price_sabit' => $new_column_cari,

                            'discount_rate' => $data_invoice_row['discount_rate'],
                            'discount_price' => $data_invoice_row['discount_price'],

                            'subtotal_price' => $data_invoice_row['subtotal_price'],

                            'tax_id' => $data_invoice_row['tax_id'],
                            'tax_price' => $data_invoice_row['tax_price'],

                            'total_price' => $data_invoice_row['total_price'],

                            'gtip_code' => $data_invoice_row['gtip_code'],

                            'withholding_id' => $data_invoice_row['withholding_id'],
                            'withholding_rate' => $data_invoice_row['withholding_rate'],
                            'withholding_price' => $data_invoice_row['withholding_price'],
                        ];
                        if ($invoice_row_id == 0) {
                            $this->modelInvoiceRow->insert($invoice_row_data);
                        } else {
                            $this->modelInvoiceRow->update($invoice_row_id, $invoice_row_data);
                        }
                    } else {



                        //eski stock hareketini sil
                        $deleted_stock_movement = $this->modelStockMovement
                            ->where('user_id', session()->get('user_id'))
                            ->where('invoice_row', $originalInvoiceRowData['invoice_row'])
                            ->where('stock_barcode_id', $originalInvoiceRowData['stock_barcode_id'])
                            ->first();

                        if (!$deleted_stock_movement) {
                            $this->modelStockMovement
                                ->where('user_id', session()->get('user_id'))
                                ->where('stock_movement_id', $deleted_stock_movement['stock_movement_id'])
                                ->delete();
                        }
                        $insert_StockWarehouseQuantity = [
                           'user_id' => session()->get('user_id'),
                            'parent_id' => $parent_idd ?? 0,
                            'stock_quantity' => convert_number_for_sql($data_invoice_row['stock_amount'])
                        ];
                        updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $invoice_item['warehouse_id'], $originalInvoiceRowData['stock_id'], $parent_idd, convert_number_for_sql($originalInvoiceRowData_stock_amount), 'add', $this->modelStockWarehouseQuantity, $this->modelStock);


                        $stock_barcode_all = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                            ->where('stock_barcode.stock_id', $data_invoice_row['stock_id'])
                            ->where('stock_barcode.warehouse_id', $data_invoice_row['warehouse_id'])
                            ->findAll();

                        //önceki ürün için stock amount'u ilgili barcode'a geri ver
                        foreach ($stock_barcode_all as $stock_barcode_item) {
                            $used_amount = $stock_barcode_item['used_amount'] - $aradaki_fark_stok_miktari;
                            $stock_barcode_status = $used_amount == $stock_barcode_item['total_amount'] ? 'out_of_stock' : 'available';
                            $update_stock_barcode_data = [
                                'used_amount' => $used_amount,
                                'stock_barcode_status' => $stock_barcode_status
                            ];
                            $this->modelStockBarcode->update($stock_barcode_item['stock_barcode_id'], $update_stock_barcode_data);
                        }


                        //yeni stock hareketi ekle ve stock_barcode'dan used_amount arttır
                        foreach ($stock_barcode_all as $stock_barcode_item) {

                            $varMi = $stock_barcode_item['total_amount'] - $stock_barcode_item['used_amount'];

                            if ($varMi >= $data_invoice_row['stock_amount']) {
                                $stock_movement_prefix = 'TRNSCTN';

                                $last_transaction = $this->modelStockMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                                if ($last_transaction) {
                                    $transaction_counter = $last_transaction['transaction_counter'] + 1;
                                } else {
                                    $transaction_counter = 1;
                                }
                                $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                                $insert_stock_movement_data = [
                                    'user_id' => session()->get('user_id'),
                                    'stock_barcode_id' => $stock_barcode_item['stock_barcode_id'],
                                    'invoice_id' => $invoice_id,
                                    'movement_type' => 'outgoing',
                                    'transaction_number' => $transaction_number,
                                    'transaction_note' => null,
                                    'from_warehouse' => $new_data_form['warehouse_id'],
                                    'transaction_info' => 'Stok Çıkış',
                                    'sale_unit_price' => $data_invoice_row['unit_price'],
                                    'sale_money_unit_id' => $data_invoice_amounts['money_unit_id'],
                                    'transaction_quantity' => $data_invoice_row['stock_amount'],
                                    'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                                    'transaction_prefix' => $transaction_prefix,
                                    'transaction_counter' => $transaction_counter,
                                ];
                                $this->modelStockMovement->insert($insert_stock_movement_data);
                                $stock_movement_id = $this->modelStockMovement->getInsertID();
                                print_r("yeni stock movement silindi: ".$stock_movement_id);

                                $used_amount = $stock_barcode_item['used_amount'] + $data_invoice_row['stock_amount'];
                                $stock_barcode_status = $used_amount == $stock_barcode_item['total_amount'] ? 'out_of_stock' : 'available';
                                $update_stock_barcode_data = [
                                    'used_amount' => $used_amount,
                                    'stock_barcode_status' => $stock_barcode_status
                                ];
                                $this->modelStockBarcode->update($stock_barcode_item['stock_barcode_id'], $update_stock_barcode_data);

                                $update_invoice_row_data = [
                                    'stock_barcode_id' => $stock_barcode_item['stock_barcode_id'],
                                ];
                                $this->modelInvoiceRow->update($invoice_row_id, $update_invoice_row_data);
                                break 1;
                            }
                        }




                        //miktarı iade et
                        //stock_barcode iade et

                        $fatura_money_id = $data_invoice_amounts['money_unit_id']; // Para birimi ID'si
                        $unit_price = $data_invoice_row['unit_price']; // Ürün birim fiyatı
                        $new_column_cari = $unit_price; // Varsayılan değer TL

                        // Para birimi 1 ise zaten TL
                        if ($fatura_money_id == 3) {
                            $new_column_cari = $unit_price;
                        } else {
                            // Para birimi TL değilse, döviz çarpanını al
                            $moneyItem = $this->modelMoneyUnit
                                ->where('user_id', session()->get('user_id'))
                                ->where('money_unit_id', $fatura_money_id)
                                ->first();

                            // Eğer çarpan bulunamazsa varsayılan TL değeri kalır
                            if ($moneyItem && isset($moneyItem['money_value'])) {
                                // Unit_price * Döviz çarpanı (TL'ye çevirme)
                                $new_column_cari = $unit_price * $moneyItem['money_value'];
                            }
                        }


                        $invoice_row_data = [
                            'user_id' => session()->get('user_id'),
                            'invoice_id' => $invoice_id,
                            'stock_id' => $data_invoice_row['stock_id'],
                            'stock_title' => $data_invoice_row['stock_title'],
                            'stock_amount' => $data_invoice_row['stock_amount'], //convert_number_for_sql($data_invoice_row['stock_amount'])

                            'unit_id' => $data_invoice_row['unit_id'],
                            'unit_price' => $data_invoice_row['unit_price'],
                            'unit_price_sabit' => $new_column_cari,

                            'discount_rate' => $data_invoice_row['discount_rate'],
                            'discount_price' => $data_invoice_row['discount_price'],

                            'subtotal_price' => $data_invoice_row['subtotal_price'],

                            'tax_id' => $data_invoice_row['tax_id'],
                            'tax_price' => $data_invoice_row['tax_price'],

                            'total_price' => $data_invoice_row['total_price'],

                            'gtip_code' => $data_invoice_row['gtip_code'],

                            'withholding_id' => $data_invoice_row['withholding_id'],
                            'withholding_rate' => $data_invoice_row['withholding_rate'],
                            'withholding_price' => $data_invoice_row['withholding_price'],
                        ];
                        if ($invoice_row_id == 0) {
                            $this->modelInvoiceRow->insert($invoice_row_data);
                        } else {
                            $this->modelInvoiceRow->update($invoice_row_id, $invoice_row_data);
                        }

                        $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $data_invoice_row['warehouse_id'], $data_invoice_row['stock_id'], $parent_idd, floatval($data_invoice_row['stock_amount']), 'remove', $this->modelStockWarehouseQuantity, $this->modelStock);

                        // bu senaryoda neler yapılacakk
                        // if ($addStock === 'eksi_stok') {
                        //     echo json_encode(['icon' => 'error', 'message' => 'bu işlemden sonra bazı ürünlerin stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz.']);
                        //     $this->modelInvoice->delete($invoice_id);
                        //     $this->modelFinancialMovement->delete($financial_movement_id);
                        //     exit();
                        // }

                    }

                }

                $invioceType = $this->modelInvoice->where("invoice_id", $invoice_id)->first();

                //finansal hareketi düzenle
                $financial_movement = $this->modelFinancialMovement
                    ->where('user_id', session()->get('user_id'))
                    ->where('transaction_type', $invioceType["invoice_direction"])
                    ->where('invoice_id', $invoice_id)
                    ->first();

                $financial_movement_base_amount = $financial_movement['transaction_amount'];



                $cari_balance_base_amount = $cari_item['cari_balance'];

                // echo ' base financial_movement_base_amount: '.$financial_movement_base_amount.'<br>';
                // echo ' base cari_balance_base_amount: '.$cari_balance_base_amount.'<br>';

                $step1 = $cari_balance_base_amount - $financial_movement_base_amount;
                $step2 = $step1 + convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try'] != '0,00' ? $data_invoice_amounts['amount_to_be_paid_try'] : $data_invoice_amounts['amount_to_be_paid']);

                // echo ' base step1: '.$step1.'<br>';
                // echo ' base step2: '.$step2.'<br>';


                $insert_financial_movement_data = [
                    'user_id' => session()->get('user_id'),
                    'financial_account_id' => null,
                    'cari_id' => $cari_id,
                    'money_unit_id' => $data_invoice_amounts['money_unit_id'],
                    'transaction_direction' => $transaction_direction,
                    'transaction_type' => $new_data_form['ftr_turu'],
                    'transaction_amount' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try'] != '0,00' ? $data_invoice_amounts['amount_to_be_paid_try'] : $data_invoice_amounts['amount_to_be_paid']),
                    'transaction_real_amount' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try'] != '0,00' ? $data_invoice_amounts['amount_to_be_paid_try'] : $data_invoice_amounts['amount_to_be_paid']),
                    'transaction_date' => $invoice_datetime,
                ];
                $this->modelFinancialMovement->update($financial_movement['financial_movement_id'], $insert_financial_movement_data);

                $update_cari_data = [
                    'cari_balance' => $step2,
                ];
                $this->modelCari->update($cari_id, $update_cari_data);

                $tiko_id = $this->modelInvoice->where('invoice_id', $invoice_id)->first()['tiko_id'];
                echo json_encode(['icon' => 'success', 'message' => 'Fatura başarıyla düzenlendi.', 'errRows' => $errRows, 'tiko_id' => $tiko_id, 'invoiceId' => $invoice_id]);


                return;
            } catch (\Exception $e) {
                $backtrace = $e->getTrace();
                $errorMessage = $e->getMessage();

                $errorDetails = [
                    'error_message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $backtrace
                ];
                $this->logClass->save_log(
                    'error',
                    'invoice',
                    null,
                    null,
                    'edit',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                 // Kullanıcı dostu hata mesajı
                $userFriendlyMessage = "Bir hata oluştu: <br>" . $errorMessage . ". <br>Lütfen daha sonra tekrar deneyin.";

                // Hata detaylarını JSON olarak döndürüyoruz (Opsiyonel: Bu kısmı son kullanıcıya göstermek yerine log için kullanın)
                $debugDetails = json_encode($errorDetails, JSON_PRETTY_PRINT); // Geliştirici için anlaşılır detaylar
                echo '<pre>';
                print_r($debugDetails);
                echo '</pre>';
                exit;
                // Basit hata mesajını JSON formatında döndür
                echo json_encode(['icon' => 'error', 'message' => $debugDetails]);
                return;
            }
        } else {
            if (!$invoice_item) {
                return view('not-found');
            }
            # elseif(checkInvoiceStatusForUpdate($invoice_item)){
            #     echo json_encode(['icon' => 'error', 'message' => 'Fatura düzenlemeye uygun değildir.']);
            #     return;
            # }

            // $invoice_rows = $this->modelInvoiceRow->join('stock_movement','stock_movement.invoice_id = invoice_row.invoice_id')->where('invoice_row.invoice_id', $invoice_id)->where('invoice_row.user_id', session()->get('user_id'))->findAll();

            $invoice_rows = $this->modelInvoiceRow
                ->distinct()
                ->select('invoice_row.invoice_row_id, invoice_row.*, stock_movement.from_warehouse')
                ->join('stock_movement', 'stock_movement.invoice_id = invoice_row.invoice_id')
                ->where('stock_movement.invoice_id', $invoice_id)
                ->where('invoice_row.user_id', session()->get('user_id'))
                ->findAll();
           

            if (!$invoice_rows) {
                $invoice_rows = $this->modelInvoiceRow
                    ->distinct()
                    ->select('invoice_row.invoice_row_id, invoice_row.*, invoice.warehouse_id as from_warehouse')
                    ->join('invoice', 'invoice.invoice_id = invoice_row.invoice_id')
                    ->where('invoice.invoice_id', $invoice_id)
                    ->where('invoice_row.user_id', session()->get('user_id'))
                    ->findAll();
            }

            $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
            $cari_items = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')->where('cari.user_id', session()->get('user_id'))->findAll();
            $invoice_note_items = $this->modelNote->where('user_id', session()->get('user_id'))->findAll();
            $invoice_serial_items = $this->modelInvoiceSerial->where('user_id', session()->get('user_id'))->orderBy('invoice_serial_type', 'ASC')->orderBy('invoice_serial_prefix', 'ASC')->findAll();
            // $stock_items = $this->modelStock->join('category', 'category.category_id = stock.category_id')->join('type', 'type.type_id = stock.type_id')->where('stock.user_id', session()->get('user_id'))->findAll(15);
            $stock_items = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock.stock_id <=', 0)->join('category', 'category.category_id = stock.category_id')->join('type', 'type.type_id = stock.type_id')->join('money_unit', 'money_unit.money_unit_id = stock.sale_money_unit_id')->findAll();
            $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();

            $data = [
                'Kurlar'       => $Kurlar,
                'invoice_item' => $invoice_item,
                'invoice_rows' => $invoice_rows,
                'money_unit_items' => $money_unit_items,
                'cari_items' => $cari_items,
                'invoice_note_items' => $invoice_note_items,
                'invoice_serial_items' => $invoice_serial_items,
                'stock_items' => $stock_items,
                'warehouse_items' => $warehouse_items,
            
            ];

            // print_r($invoice_rows);
            // return;

            return view('tportal/faturalar/detay/duzenle2', $data);
        }
    }
    private function addInvoiceStatusToQuery()
    {
        $column_names = [
            'status_name',
            'status_info',
            'status_value',
            'status_publish',
            'status_order',
            'status_statement',
            'status_substatus',
            'action_to_taken',
            'status_code',
        ];
        $selectArray = [
            'invoice.*',
            'money_unit.*',
            'invoice_serial.*'
        ];

        foreach ($column_names as $column_name) {
            $selectStr =
                'CASE 
                WHEN invoice.invoice_direction = "incoming_invoice" THEN iis.' . $column_name . '
                WHEN invoice.invoice_direction = "outgoing_invoice" THEN ios.' . $column_name . '
            END as ' . $column_name;
            array_push($selectArray, $selectStr);
        }
        return $selectArray;
    }
  

    private function addInvoiceStatusToQueryList($invoice_type)
    {
    $column_names = [
        'status_name',
        'status_info',
        'status_value',
        'status_publish',
        'status_order',
        'status_statement',
        'status_substatus',
        'action_to_taken',
        'status_code',
    ];
    $selectArray = [
        'invoice.*',
        'money_unit.*',
        'invoice_serial.*'
    ];

    // Her fatura tipi için ayrı ayrı seçiyoruz
    foreach ($column_names as $column_name) {
        if ($invoice_type == 'incoming') {
            $selectStr = "iis.{$column_name} as {$column_name}";
        } else if ($invoice_type == 'outgoing') {
            $selectStr = "ios.{$column_name} as {$column_name}";
        } else {
            // Tüm faturalar için
            $selectStr = "COALESCE(
                CASE WHEN invoice.invoice_direction = 'incoming_invoice' THEN iis.{$column_name} 
                WHEN invoice.invoice_direction = 'outgoing_invoice' THEN ios.{$column_name}
                END) as {$column_name}";
            }
            array_push($selectArray, $selectStr);
        }
        return $selectArray;
    }


    public function list($invoice_type = 'all')
    {
       
     
         /* 
           // Sayfa numarası ve sayfa başına gösterilecek kayıt sayısı
        //$page = $this->request->getVar('page') ?? 1;
        //$perPage = 99999; // Sayfa başına gösterilecek kayıt sayısı
    
        if ($invoice_type == 'all') {
            $page_title = "Tüm Faturalar";
            $invoice_items = $modelInvoice->paginate($perPage, 'default', $page);
        } else if ($invoice_type == 'incoming') {
            $page_title = "Alış Faturaları";
            $invoice_items = $modelInvoice->where('invoice_direction', 'incoming_invoice')->paginate($perPage, 'default', $page);
        } else if ($invoice_type == 'outgoing') {
            $page_title = "Satış Faturaları";
            $invoice_items = $modelInvoice->where('invoice_direction', 'outgoing_invoice')->paginate($perPage, 'default', $page);
        } else {
            return redirect()->back();
        }
    
        $pager = $modelInvoice->pager;
    
        $data = [
            'page_title' => $page_title,
            'invoice_items' => $invoice_items,
            'invoice_items_count' => count($invoice_items),
            'pager' => $pager,
        ];
         */

        if ($invoice_type == 'all') {
            $page_title = "Tüm Faturalar";
            $selectArray = $this->addInvoiceStatusToQueryList('all');
            $modelInvoice = $this->modelInvoice
            ->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->join('invoice_serial', 'invoice_serial.invoice_serial_id = invoice.invoice_serial_id', 'left')
            // Her iki status tablosunu da conditional join yapalım
            ->join('invoice_incoming_status iis', 'iis.invoice_incoming_status_id = invoice.invoice_status_id AND invoice.invoice_direction = "incoming_invoice"', 'left')
            ->join('invoice_outgoing_status ios', 'ios.invoice_outgoing_status_id = invoice.invoice_status_id AND invoice.invoice_direction = "outgoing_invoice"', 'left')
            ->select($selectArray, false)
            ->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice.cari_id !=', session()->get("user_item")["stock_user"] ?? 0)
            ->orderBy('invoice.invoice_date', 'DESC');
            $invoice_items = $modelInvoice->findAll();
        } else if ($invoice_type == 'incoming') {
            $page_title = "Alış Faturaları";
            $selectArray = $this->addInvoiceStatusToQueryList('incoming');
            $modelInvoice = $this->modelInvoice
            ->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->join('invoice_serial', 'invoice_serial.invoice_serial_id = invoice.invoice_serial_id', 'left')
            // Her iki status tablosunu da conditional join yapalım
            ->join('invoice_incoming_status iis', 'iis.invoice_incoming_status_id = invoice.invoice_status_id AND invoice.invoice_direction = "incoming_invoice"', 'left')
            ->select($selectArray, false)
            ->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice.cari_id !=', session()->get("user_item")["stock_user"] ?? 0)
            ->orderBy('invoice.invoice_date', 'DESC');
            $invoice_items = $modelInvoice->where('invoice_direction', 'incoming_invoice')->findAll();
        
        } else if ($invoice_type == 'outgoing') {
            $page_title = "Satış Faturaları";
            $selectArray = $this->addInvoiceStatusToQueryList('outgoing');
            $modelInvoice = $this->modelInvoice
            ->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->join('invoice_serial', 'invoice_serial.invoice_serial_id = invoice.invoice_serial_id', 'left')
            // Her iki status tablosunu da conditional join yapalım
            ->join('invoice_outgoing_status ios', 'ios.invoice_outgoing_status_id = invoice.invoice_status_id AND invoice.invoice_direction = "outgoing_invoice"', 'left')
            ->select($selectArray, false)
            ->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice.cari_id !=', session()->get("user_item")["stock_user"] ?? 0)
            ->orderBy('invoice.invoice_date', 'DESC');
            $invoice_items = $modelInvoice->where('invoice_direction', 'outgoing_invoice')->findAll();
        } else {
            return redirect()->back();
        }

        $data = [
            'page_title' => $page_title,
            'invoice_items' => $invoice_items,
            'invoice_items_count' => count($invoice_items),
        ];

        return view('tportal/faturalar/index', $data);
    }


    public function tikoPortalDatabase()
    {
       
        $userDatabaseDetail = [
            'hostname' => '78.135.66.89',
            'username' => 'user',
            'password' => 'tiko2010',
            'database' => 'dbmaster',
            'DBDriver' => 'MySQLi', // Veritabanı sürücüsünü belirtin (MySQLi, Postgre, vb.)
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
        return \Config\Database::connect($userDatabaseDetail);

    }

    public function delete($invoice_id = null)
    {   
        $cari_id = 0;
        
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $invoice_item = $this->modelInvoice->where('user_id', session()->get('user_id'))->where('invoice_id', $invoice_id)->first();

                $cari_id = $invoice_item["cari_id"];

                if (!$invoice_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen fatura bulunamadı.']);
                    return;
                }


                $invoice_row_items = $this->modelInvoiceRow->where('invoice_id', $invoice_item['invoice_id'])->findAll();
                $invoice_row_items_count = count($invoice_row_items);

               

                if (!$invoice_row_items) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen fatura için fatura satırları bulunamadı.']);
                    return;
                }



                if ($invoice_row_items_count > 1) {

                    foreach ($invoice_row_items as $invoice_row_item) {

                        if ($invoice_row_item['stock_id'] != 0) {
                            $invoice_row_stock = $this->modelStock
                                ->join('stock_barcode', 'stock_barcode.stock_id = stock.stock_id')
                                ->where('stock.stock_id', $invoice_row_item['stock_id'])
                                ->first();
                        }

                        $stock_movement_item = $this->modelStockMovement
                            ->join('invoice', 'invoice.invoice_id = stock_movement.invoice_id', 'left')
                            ->where('invoice.invoice_id', $invoice_row_item['invoice_id'])
                            ->first();

                        $invoice_cari_item = $this->modelCari
                            ->where('cari_id', $invoice_row_item['cari_id'])
                            ->first();

                        $financial_item = $this->modelFinancialMovement
                            ->where('invoice_id', $invoice_row_item['invoice_id'])
                            ->first();

                        
            

                        if ($invoice_row_item['stock_id'] != 0) {
                            $insert_StockWarehouseQuantity = [
                                'user_id' => 0
                            ];
                            $warehouse_id = 0;
                            if ($stock_movement_item['movement_type'] == 'incoming') {
                                $warehouse_id = $stock_movement_item['to_warehouse'];
                            } else {
                                $warehouse_id = $stock_movement_item['from_warehouse'];
                            }
                            

                            if($invoice_item["invoice_direction"] == "incoming_invoice"){

                              

                                //invoice_row'daki ürünü tekrar stok ekle
                                updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $invoice_row_stock['warehouse_id'], $invoice_row_stock['stock_id'], $invoice_row_stock['parent_id'], $stock_movement_item['transaction_quantity'], 'remove', $this->modelStockWarehouseQuantity, $this->modelStock);

                                //stock_barcode'da used_amount stock_amount kadar arttır
                                $used_amount = $invoice_row_stock['used_amount'] - $invoice_row_item['stock_amount'];
                                $stock_barcode_status = $used_amount == $invoice_row_stock['total_amount'] ? 'out_of_stock' : 'available';
                                $update_stock_barcode_data = [
                                    'used_amount' => $used_amount,
                                    'stock_barcode_status' => $stock_barcode_status
                                ];
                                $this->modelStockBarcode->update($invoice_row_stock['stock_barcode_id'], $update_stock_barcode_data);

                            }else{
                             
                                   //invoice_row'daki ürünü tekrar stok ekle
                            updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $invoice_row_stock['warehouse_id'], $invoice_row_stock['stock_id'], $invoice_row_stock['parent_id'], $stock_movement_item['transaction_quantity'], 'add', $this->modelStockWarehouseQuantity, $this->modelStock);

                            //stock_barcode'da used_amount stock_amount kadar arttır
                            $used_amount = $invoice_row_stock['used_amount'] - $invoice_row_item['stock_amount'];
                            $stock_barcode_status = $used_amount == $invoice_row_stock['total_amount'] ? 'out_of_stock' : 'available';
                            $update_stock_barcode_data = [
                                'used_amount' => $used_amount,
                                'stock_barcode_status' => $stock_barcode_status
                            ];
                            $this->modelStockBarcode->update($invoice_row_stock['stock_barcode_id'], $update_stock_barcode_data);

                            }

                            

                         

                            //kayıtları sil
                            $this->modelStockMovement->delete($stock_movement_item['stock_movement_id']);
                        }

                   
                        
                        //invoice_row tutar kadar cari_balance ekle
                        if(isset($invoice_cari_item)){
                            $amount_to_be_processed = floatval($invoice_row_item['total_price']);
                            $update_cari_data = [
                                'cari_balance' => $invoice_cari_item['cari_balance'] - $amount_to_be_processed
                            ];
                          
                            $this->modelCari->update($invoice_cari_item['cari_id'], $update_cari_data);
                        }
                        

                        //kayıtları sil
                        $this->modelInvoiceRow->delete($invoice_row_item['invoice_row_id']);
                    }

             

                    if ($invoice_item['is_quick_collection_financial_movement_id'] != 0) {

                        $financial_movement_item = $this->modelFinancialMovement
                            ->where('financial_movement_id', $invoice_item['is_quick_collection_financial_movement_id'])
                            ->first();


                        $financial_account_item = $this->modelFinancialAccount
                            ->where('financial_account_id', $financial_movement_item['financial_account_id'])
                            ->first();

                        $lastc = $invoice_item['money_unit_id'] != 3 ? $invoice_item['amount_to_be_paid_try'] : $invoice_item['amount_to_be_paid'];

                        $update_financial_account_data = [
                            'account_balance' => $financial_account_item['account_balance'] - $lastc,
                        ];
                        $this->modelFinancialAccount->update($financial_account_item['financial_account_id'], $update_financial_account_data);

                        

                        $invoice_cari_item = $this->modelCari
                            ->where('cari_id', $invoice_item['cari_id'])
                            ->first();

                            if(isset($invoice_cari_item)){
                                $update_cari_data = [
                                    'cari_balance' => $invoice_cari_item['cari_balance'] + $lastc,
                                ];
                                $this->modelCari->update($invoice_cari_item['cari_id'], $update_cari_data);
                            }


                        $this->modelFinancialMovement->delete($invoice_item['is_quick_collection_financial_movement_id']);
                    }

                    $this->modelFinancialMovement->delete($financial_item['financial_movement_id']);
                    $this->modelInvoice->delete($invoice_item['invoice_id']);
                    $invoice_cari_item = $this->modelCari
                    ->where('cari_id', $invoice_item['cari_id'])
                    ->first();
                    if(isset($invoice_cari_item)){
                        $BakiyeGuncelleFull = new Cari();
                        $BakiyeGuncelleFull->bakiyeHesapla($cari_id);
                    }
                   
                    echo json_encode(['icon' => 'success', 'message' => 'row silindi. Stok harekti başarıyla silindi.', 'route_address' => route_to('tportal.stocks.list', 'all')]);
                    return;

                } else {

                    $invoice_row_stock = $this->modelStock
                        ->join('stock_barcode', 'stock_barcode.stock_id = stock.stock_id')
                        ->where('stock.stock_id', $invoice_row_items[0]['stock_id'])
                        ->first();

                    $stock_movement_item = $this->modelStockMovement
                        ->join('invoice', 'invoice.invoice_id = stock_movement.invoice_id', 'left')
                        ->where('invoice.invoice_id', $invoice_row_items[0]['invoice_id'])
                        ->first();

                    $invoice_cari_item = $this->modelCari
                        ->where('cari_id', $invoice_row_items[0]['cari_id'])
                        ->first();

                    $financial_item = $this->modelFinancialMovement
                        ->where('invoice_id', $invoice_row_items[0]['invoice_id'])
                        ->first();


                    // print_r($invoice_row_stock);
                    // print_r($stock_movement_item);
                    // print_r($invoice_cari_item);
                    // print_r($financial_item);
                    // return;

                    


                    if (isset($invoice_row_stock['stock_id']) && $invoice_row_stock['stock_id'] != 0) {
                        $insert_StockWarehouseQuantity = [
                            'user_id' => 0
                        ];
                        $warehouse_id = 0;
                        if (isset($stock_movement_item['movement_type'])){
                            if ($stock_movement_item['movement_type'] == 'incoming') {
                                $warehouse_id = $stock_movement_item['to_warehouse'];
                            } else {
                                $warehouse_id = $stock_movement_item['from_warehouse'];
                            }
                        }
                        

                        if ($invoice_row_stock['stock_type'] == 'service') {

                            $parent_stock_item = $this->modelStock
                                ->where('stock.stock_id', $invoice_row_stock['parent_id'])
                                ->first();

                            // print_r($stock_movement_item['transaction_quantity']);
                            print_r(($parent_stock_item['stock_total_quantity']) - ($stock_movement_item['transaction_quantity']));

                            $update_stock_data = [
                                'stock_total_quantity' => $invoice_row_stock['stock_total_quantity'] - $stock_movement_item['transaction_quantity'],
                            ];
                            $this->modelStock->update($invoice_row_items[0]['stock_id'], $update_stock_data);

                            $update_stock_parent_data = [
                                'stock_total_quantity' => $parent_stock_item['stock_total_quantity'] - $stock_movement_item['transaction_quantity'],
                            ];
                            $this->modelStock->update($invoice_row_stock['parent_id'], $update_stock_parent_data);

                            
                            //stock_barcode'da used_amount stock_amount kadar arttır
                            $used_amount = $invoice_row_stock['used_amount'] - $invoice_row_items[0]['stock_amount'];
                            $update_stock_barcode_data = [
                                'used_amount' => $used_amount,
                            ];
                            $this->modelStockBarcode->update($invoice_row_stock['stock_barcode_id'], $update_stock_barcode_data);
                            
                            print_r("stock_up oldu");

                        } else {



                            if($invoice_item["invoice_direction"] == "incoming_invoice"){

                            

                                   //invoice_row'daki ürünü tekrar stok ekle
                                   if(isset($invoice_row_stock['stock_id'])){
                            updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $invoice_row_stock['warehouse_id'], $invoice_row_stock['stock_id'], $invoice_row_stock['parent_id'], $stock_movement_item['transaction_quantity'], 'remove', $this->modelStockWarehouseQuantity, $this->modelStock);
                                   }
                            //stock_barcode'da used_amount stock_amount kadar arttır
                            $used_amount = $invoice_row_stock['used_amount'] - $invoice_row_items[0]['stock_amount'];
                            $stock_barcode_status = $used_amount == $invoice_row_stock['total_amount'] ? 'out_of_stock' : 'available';
                            $update_stock_barcode_data = [
                                'used_amount' => $used_amount,
                                'stock_barcode_status' => $stock_barcode_status
                            ];
                            $this->modelStockBarcode->update($invoice_row_stock['stock_barcode_id'], $update_stock_barcode_data);

                            }else{
                                
                                   //invoice_row'daki ürünü tekrar stok ekle
                            //invoice_row'daki ürünü tekrar stok ekle
                            if(isset($invoice_row_stock['stock_id'])){
                            updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $invoice_row_stock['warehouse_id'], $invoice_row_stock['stock_id'], $invoice_row_stock['parent_id'], $stock_movement_item['transaction_quantity'], 'add', $this->modelStockWarehouseQuantity, $this->modelStock);
                            }
                         
                           
                           //stock_barcode'da used_amount stock_amount kadar arttır
                            $used_amount = $invoice_row_stock['used_amount'] - $invoice_row_items[0]['stock_amount'];
                            $stock_barcode_status = $used_amount == $invoice_row_stock['total_amount'] ? 'out_of_stock' : 'available';
                            $update_stock_barcode_data = [
                                'used_amount' => $used_amount,
                                'stock_barcode_status' => $stock_barcode_status
                            ];
                            $this->modelStockBarcode->update($invoice_row_stock['stock_barcode_id'], $update_stock_barcode_data);

                            }
                         




                        }
                        

    
                        // print_r("dönüşş");
                        // return;


                        //kayıtları sil
                        $this->modelStockMovement->delete($stock_movement_item['stock_movement_id']);
                    }

                    //invoice_row tutar kadar cari_balance ekle
                    $amount_to_be_processed = floatval($invoice_row_items[0]['total_price']);
                    $invoice_cari_item = $this->modelCari
                    ->where('cari_id', $invoice_item['cari_id'])
                    ->first();
                    if(isset($invoice_cari_item)){
                    $update_cari_data = [
                        'cari_balance' => $invoice_cari_item['cari_balance'] - $amount_to_be_processed
                    ];
                    $this->modelCari->update($invoice_cari_item['cari_id'], $update_cari_data);
                    }

                    if ($invoice_item['is_quick_collection_financial_movement_id'] != 0) {

                        $financial_movement_item = $this->modelFinancialMovement
                            ->where('financial_movement_id', $invoice_item['is_quick_collection_financial_movement_id'])
                            ->first();

                        $financial_account_item = $this->modelFinancialAccount
                            ->where('financial_account_id', $financial_movement_item['financial_account_id'])
                            ->first();


                        $lastc = $invoice_item['money_unit_id'] != 3 ? $invoice_item['amount_to_be_paid_try'] : $invoice_item['amount_to_be_paid'];

                        $update_financial_account_data = [
                            'account_balance' => $financial_account_item['account_balance'] - $lastc,
                        ];
                        $this->modelFinancialAccount->update($financial_account_item['financial_account_id'], $update_financial_account_data);


                        $invoice_cari_item = $this->modelCari
                            ->where('cari_id', $invoice_item['cari_id'])
                            ->first();
                            if(isset($invoice_cari_item)){

                        $update_cari_data = [
                            'cari_balance' => $invoice_cari_item['cari_balance'] + $lastc,
                        ];
                        $this->modelCari->update($invoice_cari_item['cari_id'], $update_cari_data);
                        }

                        $this->modelFinancialMovement->delete($invoice_item['is_quick_collection_financial_movement_id']);
                    }

                    if($invoice_item["tiko_id"] != 0){
                        $tikoDB = $this->tikoPortalDatabase();
                        $tarih = Date('Y-m-d H:i:s');
                        
                        // Doğru sorgu: deleted_at sütununu güncelle
                        $tikoDB->table('faturalar')
                            ->where('id', $invoice_item["tiko_id"])
                            ->update(['deleted_at' => $tarih]);

                        $tikoDB->table('fatura_satirlar')
                            ->where('fatura_id', $invoice_item["tiko_id"])
                            ->update(['deleted_at' => $tarih]);
                    }


                    $this->modelInvoiceRow->delete($invoice_row_items[0]['invoice_row_id']);
                    $this->modelInvoice->delete($invoice_row_items[0]['invoice_id']);
                    $this->modelFinancialMovement->delete($financial_item['financial_movement_id']);
                    $invoice_cari_item = $this->modelCari
                    ->where('cari_id', $invoice_item['cari_id'])
                    ->first();
                    if(isset($invoice_cari_item)){
                        $BakiyeGuncelleFull = new Cari();
                        $BakiyeGuncelleFull->bakiyeHesapla($cari_id);
                    }



                    
                    echo json_encode(['icon' => 'success', 'message' => 'fatura silindi. Stok harekti başarıyla silindi.', 'route_address' => route_to('tportal.stocks.list', 'all')]);
                    return;

                }

              
                $invoice_cari_items = $this->modelCari
                ->where('cari_id', $cari_id)
                ->first();
                if(isset($invoice_cari_items)){
                $BakiyeGuncelleFulls = new Cari();
                $BakiyeGuncelleFulls->bakiyeHesapla($cari_id);
                }
                echo json_encode(['icon' => 'success', 'message' => 'Fatura başarıyla silindi.']);
                return;
            } catch (\Exception $e) {
          

                $backtrace = $e->getTrace();
                $errorMessage = $e->getMessage();

                $errorDetails = [
                    'error_message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $backtrace
                ];
                $this->logClass->save_log(
                    'error',
                    'invoice',
                    $invoice_id,
                    null,
                    'delete',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                $userFriendlyMessage = "Bir hata oluştu: <br>" . $errorMessage . ". <br>Lütfen daha sonra tekrar deneyin.";

                // Hata detaylarını JSON olarak döndürüyoruz (Opsiyonel: Bu kısmı son kullanıcıya göstermek yerine log için kullanın)
                $debugDetails = json_encode($userFriendlyMessage, JSON_PRETTY_PRINT); // Geliştirici için anlaşılır detaylar

                // Basit hata mesajını JSON formatında döndür
                echo json_encode(['icon' => 'error', 'message' => $debugDetails]);
                return;
      
            }


           
        } else {
            return redirect()->back();
        }
    }



    public function finans_hareket_delete($finansal_hareket_id = null)
    {   
        $cari_id = 0;
        
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $financial_movement_item = $this->modelFinancialMovement->where('financial_movement_id', $finansal_hareket_id)->first();

                $cari_id = $financial_movement_item["cari_id"];

                if (!$financial_movement_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen finansal hareket bulunamadı.']);
                    return;
                }


             

                $this->modelFinancialMovement->delete($financial_movement_item['financial_movement_id']);
                $invoice_cari_item = $this->modelCari
                ->where('cari_id', $financial_movement_item['cari_id'])
                ->first();
                if(isset($invoice_cari_item)){
                    $BakiyeGuncelleFull = new Cari();
                    $BakiyeGuncelleFull->bakiyeHesapla($cari_id);
                }
                   
                 

               

              
                $invoice_cari_items = $this->modelCari
                ->where('cari_id', $cari_id)
                ->first();
                if(isset($invoice_cari_items)){
                $BakiyeGuncelleFulls = new Cari();
                $BakiyeGuncelleFulls->bakiyeHesapla($cari_id);
                }
                echo json_encode(['icon' => 'success', 'message' => 'Finansal hareket başarıyla silindi.']);
                return;
            } catch (\Exception $e) {
          

                $backtrace = $e->getTrace();
                $errorMessage = $e->getMessage();

                $errorDetails = [
                    'error_message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $backtrace
                ];
                $this->logClass->save_log(
                    'error',
                    'invoice',
                    $finansal_hareket_id,
                    null,
                    'delete',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                $userFriendlyMessage = "Bir hata oluştu: <br>" . $errorMessage . ". <br>Lütfen daha sonra tekrar deneyin.";

                // Hata detaylarını JSON olarak döndürüyoruz (Opsiyonel: Bu kısmı son kullanıcıya göstermek yerine log için kullanın)
                $debugDetails = json_encode($userFriendlyMessage, JSON_PRETTY_PRINT); // Geliştirici için anlaşılır detaylar

                // Basit hata mesajını JSON formatında döndür
                echo json_encode(['icon' => 'error', 'message' => $debugDetails]);
                return;
      
            }


           
        } else {
            return redirect()->back();
        }
    }

    public function siparis_create($id)
    {
        $transaction_prefix = "PRF";
        $errRows = [];

        $Kurlar = $this->modelMoneyUnit->findAll();

  

        if ($this->request->getMethod('true') == 'POST') {
        

    
     

            try {
                $data_form = $this->request->getPost('data_form');
                $data_invoice_rows = $this->request->getPost('data_invoice_rows');
                $data_invoice_amounts = $this->request->getPost('data_invoice_amounts');
                $data_invoice_irsaliye = $this->request->getPost('data_invoice_irsaliye');  // İrsaliye aktif olduğunda bu gelen data kullanılacak.
                $data_invoice_iade = $this->request->getPost('data_invoice_iade'); // İade satırları aktif olduğunda bu gelen data kullanılacak.

                foreach ($data_form as $data) {
                    $key = $data['name'];
                    $value = $data['value'];
                    $new_data_form[$key] = $value;
                }
                
                $err = [];
                foreach ($data_invoice_rows as $inrows) {
                    $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $inrows['stock_id'])->first();
                    
                    if ($stock_item) {
                        
                    
                        if ($stock_item['parent_id'] == 0) {
                            $err[] = [
                                'message' => "Faturaya Girilen Ürün Ana Ürün Olamaz! <br>",
                                'stock_title' => $stock_item['stock_title'],
                            ];
                        }
                    }
                }
                
                if (!empty($err)) {
                    // Create a string containing all error messages and stock titles
                    $error_messages = array_map(function($error) {
                        return $error['message'] . (isset($error['stock_title']) ? ' ' . $error['stock_title'] : '');
                    }, $err);
                    
                    echo json_encode(['icon' => 'error', 'message' => implode(' ', $error_messages)]);
                    return;
                }
                

          


                $phone = isset($new_data_form['cari_phone']) ? str_replace(array('(', ')', ' '), '', $new_data_form['cari_phone']) : null;
                $phoneNumber = $new_data_form['cari_phone'] ? $new_data_form['area_code'] . " " . $phone : null;

                $invoice_date = $new_data_form['invoice_date'];
                $invoice_time = $new_data_form['invoice_time'];

                $invoice_datetime = convert_datetime_for_sql_time($invoice_date, $invoice_time);


                if (isset($new_data_form['is_expiry']) && $new_data_form['is_expiry'] == 'on') {
                    $expiry_date = $new_data_form['expiry_date'];
                    $payment_method = $new_data_form['payment_method'];
                } else {
                    $expiry_date = $invoice_datetime;
                    $payment_method = null;
                }

                $transaction_amount = isset($data_invoice_amounts['amount_to_be_paid']) ? convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']) : convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try']);
                if ($new_data_form['ftr_turu'] == 'outgoing_invoice') { // outgoing_invoice => Giden Fatura  // incoming_invoice => Gelen Fatura
                    $transaction_direction = 'exit';
                    $is_customer = 1;
                    $is_supplier = 0;
                    $multiplier_for_cari_balance = 1;
                } else {
                    $transaction_direction = 'entry';
                    $is_customer = 0;
                    $is_supplier = 1;
                    $multiplier_for_cari_balance = -1;
                }

                $cari_balance = null;
                $cari_id = null;

                // fatura müşteri seçten geliyorsa cari id  zaten var onu koy geç, 
                // vkn kimlik sorguladan geliyorsa identification_number var ona bak geç
                // $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari', $new_data_form['identification_number'])->first();

                if (isset($new_data_form['cari_id']) && $new_data_form['cari_id'] != 0) {
                    $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id', $new_data_form['cari_id'])->first();
                }
                if (isset($new_data_form['identification_number']) && $new_data_form['identification_number'] != 0 && $new_data_form['identification_number'] != null) {
                    $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.identification_number', $new_data_form['identification_number'])->where("cari.invoice_title", $new_data_form['invoice_title'] == '' ? $new_data_form['name'] . ' ' . $new_data_form['surname'] : $new_data_form['invoice_title'])->first();
                }
                // else{
                //     echo json_encode(['icon' => 'error', 'message' => 'cari tespit edilemedi']);
                //     return;
                // }




                if ((isset($new_data_form['is_customer_save']) && $new_data_form['is_customer_save'] == 'on') || !$cari_item) {
                    if (isset($new_data_form['is_export_customer']) && $new_data_form['is_export_customer'] == 'on') {
                        $is_export_customer = 1;
                    } else {
                        $is_export_customer = 0;
                    }
                    $cari_data = [
                        'user_id' => session()->get('user_id'),
                        'money_unit_id' => $data_invoice_amounts['money_unit_id'],
                        'identification_number' => $new_data_form['identification_number'],
                        'tax_administration' => $new_data_form['tax_administration'] != '' ? $new_data_form['tax_administration'] : null,
                        'invoice_title' => $new_data_form['invoice_title'] == '' ? $new_data_form['name'] . ' ' . $new_data_form['surname'] : $new_data_form['invoice_title'],
                        'name' => $new_data_form['name'],
                        'surname' => $new_data_form['surname'],
                        'obligation' => $new_data_form['obligation'] != '' ? $new_data_form['obligation'] : null,
                        'company_type' => $new_data_form['company_type'] != '' ? $new_data_form['company_type'] : null,
                        'cari_phone' => $phoneNumber != '' ? $phoneNumber : null,
                        'cari_email' => $new_data_form['cari_email'] != '' ? $new_data_form['cari_email'] : null,
                        'is_customer' => $is_customer,
                        'is_supplier' => $is_supplier,
                        'is_export_customer' => $is_export_customer,
                    ];

                    $address_data = [
                        'user_id' => session()->get('user_id'),
                        'address_title' => 'Fatura Adresi',
                        'address_country' => $new_data_form['address_country'],
                        'address_city' => $new_data_form['address_city_name'] != '' ? $new_data_form['address_city_name'] : null,
                        'address_city_plate' => isset($new_data_form['address_city']) ? $new_data_form['address_city'] : null,
                        'address_district' => isset($new_data_form['address_district']) ? $new_data_form['address_district'] : null,
                        'zip_code' => $new_data_form['zip_code'],
                        'address' => $new_data_form['address'],
                        'address_phone' => $phoneNumber,
                        'address_email' => $new_data_form['cari_email'] != '' ? $new_data_form['cari_email'] : null,
                    ];

                    if (!$cari_item) {
                        //8 rakamlı cari kodu
                        $create_cari_code = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
                        $cari_data['cari_code'] = $create_cari_code;
                        // $cari_data['cari_balance'] = $multiplier_for_cari_balance * $transaction_amount; 
                        $cari_data['cari_balance'] = 0;

                        $this->modelCari->insert($cari_data);
                        $cari_id = $this->modelCari->getInsertID();
                        $cari_item = $cari_data;
                        $address_data['cari_id'] = $cari_id;
                        $address_data['status'] = 'active';
                        $address_data['default'] = 'true';
                        $this->modelAddress->insert($address_data);
                    } else {
                        $cari_id = $cari_item['cari_id'];
                        $cari_address_id = $cari_item['address_id'];
                        $cari_balance = $cari_item['cari_balance'] + ($multiplier_for_cari_balance * $transaction_amount);
                        $cari_data['cari_balance'] = $cari_balance;
                        $this->modelCari->update($cari_id, $cari_data);

                        $address_data['cari_id'] = $cari_id;
                        $this->modelAddress->update($cari_address_id, $address_data);
                    }
                } else {
                    $cari_id = $cari_item['cari_id'];
                }

                // print_r($cari_id);
                // return;

                // $update_cari_data = [
                //     'cari_balance' => $cari_item['cari_balance'] - convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try'] != '0' ? $data_invoice_amounts['amount_to_be_paid_try'] : $data_invoice_amounts['amount_to_be_paid'])
                // ];
                // print_r($update_cari_data);
                // return;


                if (isset($new_data_form['chk_musteri_bakiye_ekle']) && $new_data_form['chk_musteri_bakiye_ekle'] == 'on') {
                    $invoice_note_id = $new_data_form['invoiceNotesId'];
                    $invoice_note = $new_data_form['txt_fatura_not'] . " - " . $cari_balance;
                } else {
                    $invoice_note_id = $new_data_form['invoiceNotesId'];
                    $invoice_note = $new_data_form['txt_fatura_not'];
                }

                if (isset($new_data_form['chk_not_kaydet']) && $new_data_form['chk_not_kaydet'] == 'on') {
                    $note_item = $this->modelNote->where('note_id', $new_data_form['invoiceNotesId'])->where('user_id', session()->get('user_id'))->first();

                    if (!$note_item) {
                        $insert_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_type' => 'invoice',
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $this->modelNote->insert($insert_invoice_note_data);
                        $invoice_note_id = $this->modelNote->getInsertID();

                    } else {
                        $insert_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_id' => $new_data_form['invoiceNotesId'],
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $invoice_note_id = $new_data_form['invoiceNotesId'];
                        $this->modelNote->update($new_data_form['invoiceNotesId'], $insert_invoice_note_data);
                    }
                }

                if (isset($new_data_form['chx_quickSale']) && $new_data_form['chx_quickSale'] == 'on') {
                    $chx_quickSale = 1;
                } else {
                    $chx_quickSale = 0;
                }

                if (isset($new_data_form['is_customInvoiceNo']) && $new_data_form['is_customInvoiceNo'] == 'on') {
                    $invoice_no = $new_data_form['customInvoiceNo'];
                } else {
                    
                    $create_sale_order_code = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                    $invoice_no = $chx_quickSale == 1 ? 'SF-'.$create_sale_order_code : "#PROFORMA";

                    
                }
                

          

                $insert_invoice_data = [
                    'user_id' => session()->get('user_id'),
                    'money_unit_id' => $data_invoice_amounts['money_unit_id'],
                    'invoice_serial_id' => $new_data_form['fatura_seri'],

                    'invoice_no' => $invoice_no,
                    'invoice_ettn' => get_uuid(),//$new_data_form['invoice_ettn'],

                    'invoice_direction' => $new_data_form['ftr_turu'],
                    'invoice_scenario' => $new_data_form['fatura_senaryo'],
                    'invoice_type' => $new_data_form['fatura_tipi'],

                    'invoice_date' => $invoice_datetime,

                    'payment_method' => $payment_method,
                    'expiry_date' => $expiry_date,

                    'invoice_note_id' => $new_data_form['invoiceNotesId'] == '' ? $invoice_note_id : $new_data_form['invoiceNotesId'],
                    'invoice_note' => $invoice_note,

                    'currency_amount' => $data_invoice_amounts['currency_amount'],

                    'stock_total' => convert_number_for_sql($data_invoice_amounts['stock_total']),
                    'stock_total_try' => convert_number_for_sql($data_invoice_amounts['stock_total_try']),

                    'discount_total' => convert_number_for_sql($data_invoice_amounts['discount_total']),
                    'discount_total_try' => convert_number_for_sql($data_invoice_amounts['discount_total_try']),

                    'tax_rate_1_amount' => convert_number_for_sql($data_invoice_amounts['tax_rate_1_amount']),
                    'tax_rate_1_amount_try' => convert_number_for_sql($data_invoice_amounts['tax_rate_1_amount_try']),
                    'tax_rate_10_amount' => convert_number_for_sql($data_invoice_amounts['tax_rate_10_amount']),
                    'tax_rate_10_amount_try' => convert_number_for_sql($data_invoice_amounts['tax_rate_10_amount_try']),
                    'tax_rate_20_amount' => convert_number_for_sql($data_invoice_amounts['tax_rate_20_amount']),
                    'tax_rate_20_amount_try' => convert_number_for_sql($data_invoice_amounts['tax_rate_20_amount_try']),

                    'sub_total' => convert_number_for_sql($data_invoice_amounts['sub_total']),
                    'sub_total_try' => convert_number_for_sql($data_invoice_amounts['sub_total_try']),
                    'sub_total_0' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax0']),
                    'sub_total_0_try' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax0_try']),
                    'sub_total_1' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax1']),
                    'sub_total_1_try' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax1_try']),
                    'sub_total_10' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax10']),
                    'sub_total_10_try' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax10_try']),
                    'sub_total_20' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax20']),
                    'sub_total_20_try' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax20_try']),

                    'transaction_subject_to_withholding_amount' => convert_number_for_sql($data_invoice_amounts['tevkifataTabiIslemTutar']),
                    'transaction_subject_to_withholding_amount_try' => convert_number_for_sql($data_invoice_amounts['tevkifataTabiIslemTutar_try']),
                    'transaction_subject_to_withholding_calculated_tax' => convert_number_for_sql($data_invoice_amounts['tevkifataTabiIslemKdv']),
                    'transaction_subject_to_withholding_calculated_tax_try' => convert_number_for_sql($data_invoice_amounts['tevkifataTabiIslemKdv_try']),
                    'withholding_tax' => convert_number_for_sql($data_invoice_amounts['hesaplananTevkifat']),
                    'withholding_tax_try' => convert_number_for_sql($data_invoice_amounts['hesaplananTevkifat_try']),

                    'grand_total' => convert_number_for_sql($data_invoice_amounts['grand_total']),
                    'grand_total_try' => convert_number_for_sql($data_invoice_amounts['grand_total_try']),

                    'amount_to_be_paid' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']),
                    'amount_to_be_paid_try' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try']),

                    'amount_to_be_paid_text' => $data_invoice_amounts['amount_to_be_paid_text'],

                    'cari_id' => $cari_id,
                    'cari_identification_number' => $new_data_form['identification_number'],
                    'cari_tax_administration' => $new_data_form['tax_administration'],

                    'cari_invoice_title' => $new_data_form['invoice_title'] == '' ? $new_data_form['name'] . " " . $new_data_form['surname'] : $new_data_form['invoice_title'],
                    'cari_name' => $new_data_form['name'],
                    'cari_surname' => $new_data_form['surname'],
                    'cari_obligation' => $new_data_form['obligation'],
                    'cari_company_type' => $new_data_form['company_type'],
                    'cari_phone' => $phoneNumber,
                    'cari_email' => $new_data_form['cari_email'],

                    'address_country' => $new_data_form['address_country'],

                    'address_city' => $new_data_form['address_city_name'],
                    'address_city_plate' => isset($new_data_form['address_city']) ? $new_data_form['address_city'] : "",
                    'address_district' => isset($new_data_form['address_district']) ? $new_data_form['address_district'] : "",
                    'address_zip_code' => $new_data_form['zip_code'],
                    'address' => $new_data_form['address'],

                    'invoice_status_id' => "1",
                    'is_quick_sale_receipt' => $chx_quickSale,
                    'fatura' => $id,
                    'warehouse_id' => $new_data_form['warehouse_id'],
                ];



                $this->modelInvoice->insert($insert_invoice_data);
                $invoice_id = $this->modelInvoice->getInsertID();


                //cari para birimi
                $cari_money_unit_id = $cari_item['money_unit_id'];



                $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                if ($last_transaction) {
                    $transaction_counter = $last_transaction['transaction_counter'] + 1;
                } else {
                    $transaction_counter = 1;
                }
                $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                $insert_financial_movement_data = [
                    'user_id' => session()->get('user_id'),
                    'financial_account_id' => null,
                    'cari_id' => $cari_id,
                    'money_unit_id' => $data_invoice_amounts['money_unit_id'],
                    'transaction_number' => $transaction_number,
                    'transaction_direction' => $transaction_direction,
                    'transaction_type' => $new_data_form['ftr_turu'],
                    'invoice_id' => $invoice_id,
                    'transaction_tool' => 'not_payroll',
                    'transaction_title' => 'Fatura oluştur anında oluşan hareket',
                    'transaction_description' => $invoice_note,
                    'transaction_amount' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']),
                    'transaction_real_amount' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']),
                    'transaction_date' => $invoice_datetime,
                    'transaction_prefix' => $transaction_prefix,
                    'transaction_counter' => $transaction_counter
                ];
                $this->modelFinancialMovement->insert($insert_financial_movement_data);
                $financial_movement_id = $this->modelFinancialMovement->getInsertID();

      
                

                if ($new_data_form['ftr_turu'] == 'outgoing_invoice') { //fatura_turu satış(giden) ise

                
    
                 

                    foreach ($data_invoice_rows as $data_invoice_row) {

                        if(!isset($data_invoice_row["warehouse_id"]))
                        {
                            $data_invoice_row["warehouse_id"] = $new_data_form["warehouse_id"];
                        }

                        if (isset($data_invoice_row['isDeletedInvoice'])) {
                            continue;
                        } else {

                        

                            $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $data_invoice_row['stock_id'])->first();
                            if (!$stock_item) {

                             
                                // $errRows[] = [
                                //     'message' => "Verilen stok bulunamadı.",
                                //     'data' => [
                                //         'stock_id' => $data_invoice_row['stock_id'],
                                //         'stock_title' => $data_invoice_row['stock_title'],
                                //         'gtip_code' => $data_invoice_row['gtip_code'],
                                //         'stock_amount' => $data_invoice_row['stock_amount'],
                                //     ]
                                // ];

                            

                                $insert_invoice_row_data = [
                                    'user_id' => session()->get('user_id'),
                                    'cari_id' => $cari_id,
                                    'invoice_id' => $invoice_id,
                                    'stock_id' => $data_invoice_row['stock_id'],

                                    'stock_title' => $data_invoice_row['stock_title'],
                                    'stock_amount' => $data_invoice_row['stock_amount'], //convert_number_for_sql($data_invoice_row['stock_amount'])

                                    'unit_id' => $data_invoice_row['unit_id'],
                                    'unit_price' => $data_invoice_row['unit_price'],

                                    'discount_rate' => $data_invoice_row['discount_rate'],
                                    'discount_price' => $data_invoice_row['discount_price'],

                                    'subtotal_price' => $data_invoice_row['subtotal_price'],

                                    'tax_id' => $data_invoice_row['tax_id'],
                                    'tax_price' => $data_invoice_row['tax_price'],

                                    'total_price' => $data_invoice_row['total_price'],

                                    'gtip_code' => $data_invoice_row['gtip_code'],

                                    'withholding_id' => $data_invoice_row['withholding_id'],
                                    'withholding_rate' => $data_invoice_row['withholding_rate'],
                                    'withholding_price' => $data_invoice_row['withholding_price'],
                                ];

                                $this->modelInvoiceRow->insert($insert_invoice_row_data);
                                $invoice_row_id = $this->modelInvoiceRow->getInsertID();

                                continue;
                            } else if ($stock_item['stock_type'] == 'service') {

                                print_r("bu ürün bir hizmettir");
                                // return;


                                // fatura satırlarını oluştur
                                $insert_invoice_row_data = [
                                    'user_id' => session()->get('user_id'),
                                    'cari_id' => $cari_id,
                                    'invoice_id' => $invoice_id,
                                    'stock_id' => $data_invoice_row['stock_id'],

                                    'stock_title' => $data_invoice_row['stock_title'],
                                    'stock_amount' => $data_invoice_row['stock_amount'], //convert_number_for_sql($data_invoice_row['stock_amount'])

                                    'unit_id' => $data_invoice_row['unit_id'],
                                    'unit_price' => $data_invoice_row['unit_price'],

                                    'discount_rate' => $data_invoice_row['discount_rate'],
                                    'discount_price' => $data_invoice_row['discount_price'],

                                    'subtotal_price' => $data_invoice_row['subtotal_price'],

                                    'tax_id' => $data_invoice_row['tax_id'],
                                    'tax_price' => $data_invoice_row['tax_price'],

                                    'total_price' => $data_invoice_row['total_price'],

                                    'gtip_code' => $data_invoice_row['gtip_code'],

                                    'withholding_id' => $data_invoice_row['withholding_id'],
                                    'withholding_rate' => $data_invoice_row['withholding_rate'],
                                    'withholding_price' => $data_invoice_row['withholding_price'],
                                ];

                                $this->modelInvoiceRow->insert($insert_invoice_row_data);
                                $invoice_row_id = $this->modelInvoiceRow->getInsertID();

                                print_r($insert_invoice_row_data);


                                $stock_barcode_item = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                                    ->where('stock_barcode.stock_id', $data_invoice_row['stock_id'])
                                    ->first();


                                $curentUsedAmount = $stock_barcode_item['used_amount'];
                                $update_stock_barcode_data = [
                                    'used_amount' => $curentUsedAmount + $data_invoice_row['stock_amount'],
                                ];
                                $this->modelStockBarcode->update($stock_barcode_item['stock_barcode_id'], $update_stock_barcode_data);

                                print_r($update_stock_barcode_data);



                                $curentStockTotalQuantity = $stock_item['stock_total_quantity'];
                                $update_stock_data = [
                                    'stock_total_quantity' => $curentStockTotalQuantity + $data_invoice_row['stock_amount'],
                                ];
                                $this->modelStock->update($stock_item['stock_id'], $update_stock_data);

                                print_r($update_stock_data);


                                $parent_stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $stock_item['parent_id'])->first();
                                print_r("parent item başlangıç");
                                print_r($parent_stock_item);
                                print_r("parent item bitiş");


                                ///parent ürünü bul onun toplamına da ekle
                                $curentParentStockTotalQuantity = $parent_stock_item['stock_total_quantity'];
                                $update_parent_stock_data = [
                                    'stock_total_quantity' => $curentParentStockTotalQuantity + $data_invoice_row['stock_amount'],
                                ];
                                $this->modelStock->update($parent_stock_item['stock_id'], $update_parent_stock_data);



                                // $warehouse_item = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('default','true')->first();

                                // stock hareketi oluştur
                                $last_transaction = $this->modelStockMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                                if ($last_transaction) {
                                    $transaction_counter = $last_transaction['transaction_counter'] + 1;
                                } else {
                                    $transaction_counter = 1;
                                }
                                $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                                $insert_stock_movement_data = [
                                    'user_id' => session()->get('user_id'),
                                    'stock_barcode_id' => $stock_barcode_item['stock_barcode_id'],
                                    'invoice_id' => $invoice_id,
                                    'movement_type' => 'outgoing',
                                    'transaction_number' => $transaction_number,
                                    'transaction_note' => null,
                                    'from_warehouse' => null,
                                    'to_warehouse' => null,
                                    'transaction_info' => 'Stok Çıkış',
                                    'sale_unit_price' => $data_invoice_row['unit_price'],
                                    'sale_money_unit_id' => $data_invoice_amounts['money_unit_id'],
                                    'transaction_quantity' => $data_invoice_row['stock_amount'],
                                    'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                                    'transaction_prefix' => $transaction_prefix,
                                    'transaction_counter' => $transaction_counter,
                                ];
                                $this->modelStockMovement->insert($insert_stock_movement_data);
                                $stock_movement_id = $this->modelStockMovement->getInsertID();

                                print_r($insert_stock_movement_data);


                            } else {
                                //  echo 'stock id gibi: ' . $data_invoice_row['stock_id'];
                                //  print_r($stock_item);
                                 // return;

                                $parent_idd = $stock_item['parent_id'];

                                if($stock_item["parent_id"] == 0){
                                    $errRows[] = [
                                        'message' => "Faturaya Girilen Ürün Ana Ürün Olamaz!",
                                         'data' => [
                                             'stock_id' => $stock_item['stock_id'],
                                             'stock_title' => $stock_item['stock_title'],
                                            
                                         ]
                                     ];

                                     echo json_encode(['icon' => 'error', 'message' => 'Faturaya Girilen Ürün Ana Ürün Olamaz! '.$stock_item['stock_title'].' ' ]);
                                     return;
                                }

                        


                                $insert_StockWarehouseQuantity = [
                                    'user_id' => session()->get('user_id'),
                                    'warehouse_id' => $new_data_form['warehouse_id'],
                                    'stock_id' => $stock_item['stock_id'],
                                    'parent_id' => $stock_item['parent_id'],
                                    'stock_quantity' => $data_invoice_row['stock_amount'],
                                ];

                                 //print_r($insert_StockWarehouseQuantity);


                                $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $new_data_form['warehouse_id'], $data_invoice_row['stock_id'], $parent_idd, floatval($data_invoice_row['stock_amount']), 'remove', $this->modelStockWarehouseQuantity, $this->modelStock);
                                if ($addStock === 'eksi_stok') {
                                    echo json_encode(['icon' => 'error', 'message' => 'bu işlemden sonra bazı ürünlerin stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz.']);
                                    $this->modelInvoice->delete($invoice_id);
                                    $this->modelFinancialMovement->delete($financial_movement_id);
                                    exit();
                                }


                          


                                $insert_invoice_row_data = [
                                    'user_id' => session()->get('user_id'),
                                    'cari_id' => $cari_id,
                                    'invoice_id' => $invoice_id,
                                    'stock_id' => $data_invoice_row['stock_id'],

                                    'stock_title' => $data_invoice_row['stock_title'],
                                    'stock_amount' => $data_invoice_row['stock_amount'], //convert_number_for_sql($data_invoice_row['stock_amount'])

                                    'unit_id' => $data_invoice_row['unit_id'],
                                    'unit_price' => $data_invoice_row['unit_price'],

                                    'discount_rate' => $data_invoice_row['discount_rate'],
                                    'discount_price' => $data_invoice_row['discount_price'],

                                    'subtotal_price' => $data_invoice_row['subtotal_price'],

                                    'tax_id' => $data_invoice_row['tax_id'],
                                    'tax_price' => $data_invoice_row['tax_price'],

                                    'total_price' => $data_invoice_row['total_price'],

                                    'gtip_code' => $data_invoice_row['gtip_code'],

                                    'withholding_id' => $data_invoice_row['withholding_id'],
                                    'withholding_rate' => $data_invoice_row['withholding_rate'],
                                    'withholding_price' => $data_invoice_row['withholding_price'],
                                ];


                                $this->modelInvoiceRow->insert($insert_invoice_row_data);
                                $invoice_row_id = $this->modelInvoiceRow->getInsertID();



                                $last_stock_barcode_id = 0;
                                $stock_barcode_all = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                                    ->where('stock_barcode.stock_id', $data_invoice_row['stock_id'])
                                    ->where('stock_barcode.warehouse_id', $new_data_form['warehouse_id'])
                                    ->findAll();

                                // stock_barcode'da used_amount günceller
                                foreach ($stock_barcode_all as $stock_barcode_item) {

                                    $varMi = $stock_barcode_item['total_amount'] - $stock_barcode_item['used_amount'];

                                    if ($varMi >= $data_invoice_row['stock_amount']) {
                                        $stock_movement_prefix = 'TRNSCTN';

                                        $last_transaction = $this->modelStockMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                                        if ($last_transaction) {
                                            $transaction_counter = $last_transaction['transaction_counter'] + 1;
                                        } else {
                                            $transaction_counter = 1;
                                        }
                                        $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                                        $insert_stock_movement_data = [
                                            'user_id' => session()->get('user_id'),
                                            'stock_barcode_id' => $stock_barcode_item['stock_barcode_id'],
                                            'invoice_id' => $invoice_id,
                                            'movement_type' => 'outgoing',
                                            'transaction_number' => $transaction_number,
                                            'transaction_note' => null,
                                            'from_warehouse' => $new_data_form['warehouse_id'],
                                            'transaction_info' => 'Stok Çıkış',
                                            'sale_unit_price' => $data_invoice_row['unit_price'],
                                            'sale_money_unit_id' => $data_invoice_amounts['money_unit_id'],
                                            'transaction_quantity' => $data_invoice_row['stock_amount'],
                                            'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                                            'transaction_prefix' => $transaction_prefix,
                                            'transaction_counter' => $transaction_counter,
                                        ];
                                        $this->modelStockMovement->insert($insert_stock_movement_data);
                                        $stock_movement_id = $this->modelStockMovement->getInsertID();

                                        $used_amount = $stock_barcode_item['used_amount'] + $data_invoice_row['stock_amount'];
                                        $stock_barcode_status = $used_amount == $stock_barcode_item['total_amount'] ? 'out_of_stock' : 'available';
                                        $update_stock_barcode_data = [
                                            'used_amount' => $used_amount,
                                            'stock_barcode_status' => $stock_barcode_status
                                        ];
                                        $this->modelStockBarcode->update($stock_barcode_item['stock_barcode_id'], $update_stock_barcode_data);

                                        $update_invoice_row_data = [
                                            'stock_barcode_id' => $stock_barcode_item['stock_barcode_id'],
                                        ];
                                        $this->modelInvoiceRow->update($invoice_row_id, $update_invoice_row_data);
                                        break 1;
                                    }
                                }
                            }
                        }
                    }

                    

                    // print_r("foreach dışı/sonu");
                    // return;

                    // echo ' amount_to_be_paid_try: '.$data_invoice_amounts['amount_to_be_paid_try'];
                    // echo ' amount_to_be_paid: '.$data_invoice_amounts['amount_to_be_paid'];




                    // $last = $data_invoice_amounts['money_unit_id'] != 3 ? $data_invoice_amounts['amount_to_be_paid_try'] : $data_invoice_amounts['amount_to_be_paid'];
                    $lastc = convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']);

                    // echo ' convertsiz: '.$last;
                    // echo ' convertli: '.$lastc;


                    // echo ' cari_balance '.$cari_item['cari_balance'];
                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] + $lastc
                    ];
                    $this->modelCari->update($cari_id, $update_cari_data);
                    // print_r($update_cari_data);

                    // print_r($cari_item['cari_balance'] - convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try'] != '0,00' ? $data_invoice_amounts['amount_to_be_paid_try'] : $data_invoice_amounts['amount_to_be_paid']));

                } else if ($new_data_form['ftr_turu'] == 'incoming_invoice') { //fatura_turu alış(gelen) ise
                    foreach ($data_invoice_rows as $data_invoice_row) {

                        if(!isset($data_invoice_row["warehouse_id"]))
                        {
                            $data_invoice_row["warehouse_id"] = $new_data_form["warehouse_id"];
                        }

                        #TODO sistemde kayıtlı olmayan bir ürün için de te seferlik fatura oluşturabilmeli. daha sonra bu ürünü kaydet seçeneği de koyacağız.
                        #check if stock exists
                        $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $data_invoice_row['stock_id'])->first();
                        if (!$stock_item) {
                         

                            if($stock_item["parent_id"] == 0){
                                $errRows[] = [
                                    'message' => "Faturaya Girilen Ürün Ana Ürün Olamaz!",
                                     'data' => [
                                         'stock_id' => $stock_item['stock_id'],
                                         'stock_title' => $stock_item['stock_title'],
                                        
                                     ]
                                 ];

                                 echo json_encode(['icon' => 'error', 'message' => 'Faturaya Girilen Ürün Ana Ürün Olamaz! '.$stock_item['stock_title'].' ' ]);
                                 return;
                            }

                            $insert_invoice_row_data = [
                                'user_id' => session()->get('user_id'),
                                'cari_id' => $cari_id,
                                'invoice_id' => $invoice_id,
                                'stock_id' => $data_invoice_row['stock_id'],

                                'stock_title' => $data_invoice_row['stock_title'],
                                'stock_amount' => $data_invoice_row['stock_amount'], //convert_number_for_sql($data_invoice_row['stock_amount'])

                                'unit_id' => $data_invoice_row['unit_id'],
                                'unit_price' => $data_invoice_row['unit_price'],

                                'discount_rate' => $data_invoice_row['discount_rate'],
                                'discount_price' => $data_invoice_row['discount_price'],

                                'subtotal_price' => $data_invoice_row['subtotal_price'],

                                'tax_id' => $data_invoice_row['tax_id'],
                                'tax_price' => $data_invoice_row['tax_price'],

                                'total_price' => $data_invoice_row['total_price'],

                                'gtip_code' => $data_invoice_row['gtip_code'],

                                'withholding_id' => $data_invoice_row['withholding_id'],
                                'withholding_rate' => $data_invoice_row['withholding_rate'],
                                'withholding_price' => $data_invoice_row['withholding_price'],
                            ];

                            $this->modelInvoiceRow->insert($insert_invoice_row_data);
                            $invoice_row_id = $this->modelInvoiceRow->getInsertID();

                            continue;
                        }
                        else{
                            if (isset($data_invoice_row['isDeleted'])) {
                                continue;
                            } else {
    
                                $parent_idd = $stock_item['parent_id'];
                                $insert_invoice_row_data = [
                                    'user_id' => session()->get('user_id'),
                                    'cari_id' => $cari_id,
                                    'invoice_id' => $invoice_id,
                                    'stock_id' => $data_invoice_row['stock_id'],
    
                                    'stock_title' => $data_invoice_row['stock_title'],
                                    'stock_amount' => $data_invoice_row['stock_amount'], //convert_number_for_sql($data_invoice_row['stock_amount'])
    
                                    'unit_id' => $data_invoice_row['unit_id'],
                                    'unit_price' => $data_invoice_row['unit_price'],
    
                                    'discount_rate' => $data_invoice_row['discount_rate'],
                                    'discount_price' => $data_invoice_row['discount_price'],
    
                                    'subtotal_price' => $data_invoice_row['subtotal_price'],
    
                                    'tax_id' => $data_invoice_row['tax_id'],
                                    'tax_price' => $data_invoice_row['tax_price'],
    
                                    'total_price' => $data_invoice_row['total_price'],
    
                                    'gtip_code' => $data_invoice_row['gtip_code'],
    
                                    'withholding_id' => $data_invoice_row['withholding_id'],
                                    'withholding_rate' => $data_invoice_row['withholding_rate'],
                                    'withholding_price' => $data_invoice_row['withholding_price'],
                                ];
    
                                $this->modelInvoiceRow->insert($insert_invoice_row_data);
                                #fatura_turu alış ise eklenen fatura satırları stok giriş olarak davranacak...
                                if (isset($new_data_form['incoming_invoice_warehouse_id']) && $new_data_form['incoming_invoice_warehouse_id'] != 0) {
    
                                    $warehouse_id = $new_data_form['warehouse_id'];
                                    $supplier_id = $new_data_form['cari_id'];
                                    $stock_quantity = $data_invoice_row['stock_amount'];
                                    $warehouse_address = null;
                                    $buy_unit_price = $data_invoice_row['unit_price'];
                                    $buy_money_unit_id = $data_invoice_amounts['money_unit_id'];
    
                                    //stock_barcode eklendi
                                    $barcode_number = generate_barcode_number();
                                    $insert_barcode_data = [
                                        'stock_id' => $data_invoice_row['stock_id'],
                                        'warehouse_id' => $warehouse_id,
                                        'warehouse_address' => null,
                                        'barcode_number' => $barcode_number,
                                        'total_amount' => $stock_quantity,
                                        'used_amount' => 0
                                    ];
                                    $this->modelStockBarcode->insert($insert_barcode_data);
                                    $new_insert_stock_barcode_id = $this->modelStockBarcode->getInsertID();
    
    
                                    //finansal hareket eklenecek       ->       fatura oluşunca da bir hareket oluşuyor. SORULACAK
                                    // $stock_entry_prefix = "FTRTDRK";
                                    // $stock_total = str_replace(',', '.', $stock_quantity) * str_replace(',', '.', $buy_unit_price);
    
                                    // [$transaction_direction, $amount_to_be_processed] = ['entry', $stock_total * -1];
    
                                    // $currentDateTime = new Time('now', 'Turkey', 'en_US');
                                    // $currency_amount = str_replace(',', '.', $this->request->getPost('currency_amount')) ?? 1;
                                    // $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                                    // if ($last_transaction) {
                                    //     $transaction_counter = $last_transaction['transaction_counter'] + 1;
                                    // } else {
                                    //     $transaction_counter = 1;
                                    // }
                                    // $transaction_number = $stock_entry_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                                    // $insert_financial_movement_data = [
                                    //     'user_id' => session()->get('user_id'),
                                    //     'cari_id' => $supplier_id,
                                    //     'money_unit_id' => $buy_money_unit_id,
                                    //     'transaction_number' => $transaction_number,
                                    //     'transaction_direction' => $transaction_direction,
                                    //     'transaction_type' => 'incoming_invoice',
                                    //     'invoice_id' => $invoice_id,
                                    //     'transaction_tool' => 'not_payroll',
                                    //     'transaction_title' => "fatura alış türü, stok girişinden oluşan hareket",
                                    //     'transaction_description' => "fatura sayfasında fatura tipi alış seçildiğinden stok girişi yapılırken oluşan hareket.",
                                    //     'transaction_amount' => $stock_total,
                                    //     'transaction_real_amount' => $stock_total,
                                    //     'transaction_date' => $currentDateTime,
                                    //     'transaction_prefix' => $stock_entry_prefix,
                                    //     'transaction_counter' => $transaction_counter
                                    // ];
                                    // $this->modelFinancialMovement->insert($insert_financial_movement_data);
                                    // $financialMovement_id = $this->modelFinancialMovement->getInsertID();
    
                                    $stock_movement_prefix = 'TRNSCTN';
                                    $last_transaction_stock_movement = $this->modelStockMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                                    if ($last_transaction_stock_movement) {
                                        $transaction_counter_stock_movement = $last_transaction_stock_movement['transaction_counter'] + 1;
                                    } else {
                                        $transaction_counter_stock_movement = 1;
                                    }
                                    $transaction_number_stock_movement = $stock_movement_prefix . str_pad($transaction_counter_stock_movement, 6, '0', STR_PAD_LEFT);
    
                                    $insert_movement_data = [
                                        'user_id' => session()->get('user_id'),
                                        'stock_barcode_id' => $new_insert_stock_barcode_id,
                                        'invoice_id' => $invoice_id,
                                        'supplier_id' => $supplier_id,
                                        'movement_type' => 'incoming',
                                        'transaction_number' => $transaction_number_stock_movement,
                                        'to_warehouse' => $warehouse_id,
                                        'transaction_note' => null,
                                        'transaction_info' => $supplier_id != 0 ? ($cari_item['invoice_title'] == '' ? $cari_item['name'] . " " . $cari_item['surname'] : $cari_item['invoice_title']) : 'Manuel Stok',
                                        'buy_unit_price' => $buy_unit_price,
                                        'buy_money_unit_id' => $buy_money_unit_id,
                                        'transaction_quantity' => $stock_quantity,
                                        'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                                        'transaction_prefix' => $stock_movement_prefix,
                                        'transaction_counter' => $transaction_counter_stock_movement,
                                    ];
                                    $this->modelStockMovement->insert($insert_movement_data);
                                    $stock_movement_id = $this->modelStockMovement->getInsertID();
    
                                    $insert_StockWarehouseQuantity = [
                                        'user_id' => session()->get('user_id'),
                                        'warehouse_id' => $warehouse_id,
                                        'stock_id' => $stock_item['stock_id'],
                                        'parent_id' => $stock_item['parent_id'],
                                        'stock_quantity' => $stock_quantity,
                                    ];
    
                                    $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $warehouse_id, $stock_item['stock_id'], $stock_item['parent_id'], $stock_quantity, 'add', $this->modelStockWarehouseQuantity, $this->modelStock);
    
                                    if ($addStock === 'eksi_stok') {
                                        echo json_encode(['icon' => 'error', 'message' => 'bu işlemden sonra bazı ürünlerin stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz.']);
    
                                        return;
                                    }
                                }
                            }
                        }



                        
                    }
                    $lastc = convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']);

                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] - $lastc,
                    ];
                    $this->modelCari->update($cari_id, $update_cari_data);

                } else {
                    // print_r("else düştük beee");
                }


                #tahsilat yapılmışsa...
                if (isset($new_data_form['chx_has_collection'])) {
                    $financial_account_id = isset($new_data_form['selectedAccount']) ? $new_data_form['selectedAccount'] : '';
                    $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                    if ($last_transaction) {
                        $transaction_counter = $last_transaction['transaction_counter'] + 1;
                    } else {
                        $transaction_counter = 1;
                    }
                    $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                    


                    if ($new_data_form['ftr_turu'] == 'outgoing_invoice') {

                        $insert_financial_movement_data = [
                            'user_id' => session()->get('user_id'),
                            'financial_account_id' => $financial_account_id,
                            'cari_id' => $cari_id,
                            'money_unit_id' => $new_data_form['selectedAccountMoneyId'],
                            'transaction_number' => $transaction_number,
                            'transaction_direction' => 'entry',
                            'transaction_type' => 'collection',
                            'invoice_id' => $invoice_id,
                            'transaction_tool' => 'not_payroll',
                            'transaction_title' => 'Fatura oluştur anında yapılan tahsilat',
                            'transaction_description' => $new_data_form['txt_fatura_not'],
                            'transaction_amount' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']),
                            'transaction_real_amount' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']),
                            'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                            'transaction_prefix' => $transaction_prefix,
                            'transaction_counter' => $transaction_counter
                        ];
                        $this->modelFinancialMovement->insert($insert_financial_movement_data);
                        $is_collection_financial_movement_id = $this->modelFinancialMovement->getInsertID();
                        
                        $financial_account_item = $this->modelFinancialAccount->find($financial_account_id);
                        $update_financial_account_data = [
                            'account_balance' => $financial_account_item['account_balance'] + convert_number_for_sql($data_invoice_amounts['amount_to_be_paid'])
                        ];
                        $this->modelFinancialAccount->update($financial_account_id, $update_financial_account_data);

                        //fatura oluştur anında tahsilat yapıldı ise oluşan finansal hareket id ver
                        $update_collect_invoice_data = [
                            'is_quick_collection_financial_movement_id' => $is_collection_financial_movement_id,
                        ];
                        $this->modelInvoice->update($invoice_id, $update_collect_invoice_data);


                        $lastc = convert_number_for_sql($cari_money_unit_id == 3 ? $data_invoice_amounts['amount_to_be_paid_try'] : $data_invoice_amounts['amount_to_be_paid']);


                        $amount_to_be_processed = $lastc * -1;

                        $firstCariBalance = $cari_item['cari_balance'] + $amount_to_be_processed;

                        $update_cari_data = [
                            'cari_balance' => $cari_item['cari_balance'] + $amount_to_be_processed,
                        ];
                        $this->modelCari->update($cari_id, $update_cari_data);

                        $update_cari_data = [
                            'cari_balance' => $firstCariBalance + $lastc,
                        ];
                        $this->modelCari->update($cari_id, $update_cari_data);
                    }
                    else if ($new_data_form['ftr_turu'] == 'incoming_invoice') {

                        $insert_financial_movement_data = [
                            'user_id' => session()->get('user_id'),
                            'financial_account_id' => $financial_account_id,
                            'cari_id' => $cari_id,
                            'money_unit_id' => $new_data_form['selectedAccountMoneyId'],
                            'transaction_number' => $transaction_number,
                            'transaction_direction' => 'exit',
                            'transaction_type' => 'payment',
                            'invoice_id' => $invoice_id,
                            'transaction_tool' => 'not_payroll',
                            'transaction_title' => $data_invoice_rows[0]['stock_title'],
                            'transaction_description' => $new_data_form['txt_fatura_not'],
                            'transaction_amount' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']),
                            'transaction_real_amount' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']),
                            'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                            'transaction_prefix' => $transaction_prefix,
                            'transaction_counter' => $transaction_counter
                        ];
                        $this->modelFinancialMovement->insert($insert_financial_movement_data);
                        $is_collection_financial_movement_id = $this->modelFinancialMovement->getInsertID();
                        
                        $financial_account_item = $this->modelFinancialAccount->find($financial_account_id);
                        $update_financial_account_data = [
                            'account_balance' => $financial_account_item['account_balance'] - convert_number_for_sql($data_invoice_amounts['amount_to_be_paid'])
                        ];
                        $this->modelFinancialAccount->update($financial_account_id, $update_financial_account_data);

                        //fatura oluştur anında tahsilat yapıldı ise oluşan finansal hareket id ver
                        $update_collect_invoice_data = [
                            'is_quick_collection_financial_movement_id' => $is_collection_financial_movement_id,
                        ];
                        $this->modelInvoice->update($invoice_id, $update_collect_invoice_data);


                        $lastc = convert_number_for_sql($cari_money_unit_id == 3 ? $data_invoice_amounts['amount_to_be_paid_try'] : $data_invoice_amounts['amount_to_be_paid']);


                        $amount_to_be_processed = $lastc * 1;

                        $firstCariBalance = $cari_item['cari_balance'] - $amount_to_be_processed;

                        $update_cari_data = [
                            'cari_balance' => $cari_item['cari_balance'] - $amount_to_be_processed,
                        ];
                        $this->modelCari->update($cari_id, $update_cari_data);

                        $update_cari_data = [
                            'cari_balance' => $firstCariBalance - $lastc,
                        ];
                        $this->modelCari->update($cari_id, $update_cari_data);
                    }
                    else{

                    }
                    

                    
                }


                $this->modelOrder->set("fatura", $invoice_id)->where("order_id", $id)->update();


                echo json_encode(['icon' => 'success', 'message' => 'Fatura başarıyla sisteme kaydedildi.', 'errRows' => $errRows, 'newdInvoiceId' => $invoice_id]);
                // return;
                // }
            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();

                $this->logClass->save_log(
                    'error',
                    'invoice',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                $userFriendlyMessage = "Bir hata oluştu: <br>" . $errorMessage . ". <br>Lütfen daha sonra tekrar deneyin.";

                // Hata detaylarını JSON olarak döndürüyoruz (Opsiyonel: Bu kısmı son kullanıcıya göstermek yerine log için kullanın)
                $debugDetails = json_encode($errorDetails, JSON_PRETTY_PRINT); // Geliştirici için anlaşılır detaylar

                // Basit hata mesajını JSON formatında döndür
                echo json_encode(['icon' => 'error', 'message' => $userFriendlyMessage]);
                return;

            }
        } else {
            $siparisler = $this->modelOrder->where("order_id", $id)->first();

            $satirlar = $this->modelOrderRow->where("order_id", $id)->findAll();
            $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
            $cari_items = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')->where('cari.user_id', session()->get('user_id'))->findAll();
            $invoice_note_items = $this->modelNote->where('user_id', session()->get('user_id'))->findAll();
            $invoice_serial_items = $this->modelInvoiceSerial->where('user_id', session()->get('user_id'))->orderBy('invoice_serial_type', 'ASC')->orderBy('invoice_serial_prefix', 'ASC')->findAll();
            $stock_items = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock.stock_id <=', 0)->join('category', 'category.category_id = stock.category_id')->join('type', 'type.type_id = stock.type_id')->join('money_unit', 'money_unit.money_unit_id = stock.sale_money_unit_id')->findAll();
            $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();


            $financial_account_items = $this->modelFinancialAccount->table('`financial_account`')
                ->select('financial_account_id, money_unit.money_unit_id, account_title, account_type, bank_id, money_code')
                ->join('money_unit', 'financial_account.money_unit_id = money_unit.money_unit_id')
                ->findAll();
               
                $variant_property_items = [];
                
            $data = [
                'order_id' => $id,
                'Kurlar' => $Kurlar,
                'siparis' => $siparisler,
                'invoice_rows' => $satirlar,
                'money_unit_items' => $money_unit_items,
                'cari_items' => $cari_items,
                'invoice_note_items' => $invoice_note_items,
                'invoice_serial_items' => $invoice_serial_items,
                'stock_items' => $stock_items,
                'financial_account_items' => $financial_account_items,
                'warehouse_items' => $warehouse_items
            ];

            return view('tportal/faturalar/siparis', $data);
        }
    }

    public function quickSalePrint($invoice_id)
    {
        $invoice_item22 = $this->modelInvoice->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice.invoice_id', $invoice_id)
            ->first();

            $Kurlar = $this->modelFaturaTutar->where("fatura_id", $invoice_id)->findAll();
            foreach($Kurlar as &$qur)
            {
                $KurKod = $this->modelMoneyUnit->where("money_unit_id", $qur["kur"])->first();
                if($KurKod)
                {
                    $qur["money_code"] = $KurKod["money_code"];
                }
            }

        $selectArray = $this->addInvoiceStatusToQuery();
        $modelInvoice = $this->modelInvoice->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->join('invoice_serial', 'invoice_serial.invoice_serial_id = invoice.invoice_serial_id', 'left')
            ->join('invoice_incoming_status iis', 'iis.invoice_incoming_status_id = invoice.invoice_status_id', 'left')
            ->join('invoice_outgoing_status ios', 'ios.invoice_outgoing_status_id = invoice.invoice_status_id', 'left')
            ->select($selectArray, false)
            ->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice.invoice_id', $invoice_id);

        if (!$modelInvoice) {
            return view('not-found');
        }

        $invoice_direction = $invoice_item22['invoice_direction'];

        if ($invoice_direction == 'incoming_invoice')
            $invoice_items = $modelInvoice->where('invoice_direction', 'incoming_invoice')->first();
        else if ($invoice_direction == 'outgoing_invoice')
            $invoice_items = $modelInvoice->where('invoice_direction', 'outgoing_invoice')->first();


        $invoice_rows = $this->modelInvoiceRow->join('unit', 'unit.unit_id = invoice_row.unit_id')
            ->join('invoice', 'invoice.invoice_id = invoice_row.invoice_id')
            ->where('invoice.invoice_id', $invoice_id)
            ->findAll();

        $data = [
            'Kurlar' => $Kurlar,
            'invoice_item' => $invoice_items,
            'invoice_rows' => $invoice_rows
        ];

        // print_r($invoice_items);
        // return;

        return view('tportal/faturalar/detay/quickSalePrint', $data);
    }


    public function proforma($invoice_id)
    {
        $invoice_item22 = $this->modelInvoice->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice.invoice_id', $invoice_id)
            ->first();
            $Kurlar = $this->modelFaturaTutar->where("fatura_id", $invoice_id)->findAll();
            foreach($Kurlar as &$qur)
            {
                $KurKod = $this->modelMoneyUnit->where("money_unit_id", $qur["kur"])->first();
                if($KurKod)
                {
                    $qur["money_code"] = $KurKod["money_code"];
                }
            }

     
            
            if($invoice_item22["sale_type"] == "quick"){

            return redirect()->to(route_to("tportal.cari.quick_sale_order.detail", $invoice_item22["invoice_id"]));
                

        }
        
        $selectArray = $this->addInvoiceStatusToQuery();
        $modelInvoice = $this->modelInvoice->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->join('invoice_serial', 'invoice_serial.invoice_serial_id = invoice.invoice_serial_id', 'left')
            ->join('invoice_incoming_status iis', 'iis.invoice_incoming_status_id = invoice.invoice_status_id', 'left')
            ->join('invoice_outgoing_status ios', 'ios.invoice_outgoing_status_id = invoice.invoice_status_id', 'left')
            ->select($selectArray, false)
            ->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice.invoice_id', $invoice_id);

        if (!$modelInvoice) {
            return view('not-found');
        }

        $invoice_direction = $invoice_item22['invoice_direction'];

        if ($invoice_direction == 'incoming_invoice')
            $invoice_items = $modelInvoice->where('invoice_direction', 'incoming_invoice')->first();
        else if ($invoice_direction == 'outgoing_invoice')
            $invoice_items = $modelInvoice->where('invoice_direction', 'outgoing_invoice')->first();


        $invoice_rows1 = $this->modelInvoiceRow->join('unit', 'unit.unit_id = invoice_row.unit_id')
            ->join('invoice', 'invoice.invoice_id = invoice_row.invoice_id')
            ->join('stock', 'stock.stock_id = invoice_row.stock_id')
            ->where('invoice.invoice_id', $invoice_id)
            ->findAll();

        $invoice_rows2 = $this->modelInvoiceRow->join('unit', 'unit.unit_id = invoice_row.unit_id')
            ->join('invoice', 'invoice.invoice_id = invoice_row.invoice_id')
            ->where('invoice.invoice_id', $invoice_id)
            ->where('invoice_row.stock_id', 0)
            ->findAll();

        $invoice_rows = array_merge($invoice_rows1, $invoice_rows2);
      

        $invoiceLoglar = $this->modelIslem->where("fatura_id", $invoice_id)->orderBy("islem_log_id", "DESC")->findAll() ?? '';



        
 
 

        $data = [
            'Kurlar' => $Kurlar,
            'invoiceLoglar' => $invoiceLoglar,
            'invoice_item' => $invoice_items,
            'invoice_rows' => $invoice_rows
        ];

        // print_r($invoice_rows);
        // return;

        return view('tportal/faturalar/proforma', $data);
    }

 
    

    
    public function detail($invoice_id)
    {
        $invoice_item22 = $this->modelInvoice->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice.invoice_id', $invoice_id)
            ->first();
            $Kurlar = $this->modelFaturaTutar->where("fatura_id", $invoice_id)->findAll();
            foreach($Kurlar as &$qur)
            {
                $KurKod = $this->modelMoneyUnit->where("money_unit_id", $qur["kur"])->first();
                if($KurKod)
                {
                    $qur["money_code"] = $KurKod["money_code"];
                }
            }

     
            
            if($invoice_item22["sale_type"] == "quick"){

            return redirect()->to(route_to("tportal.cari.quick_sale_order.detail", $invoice_item22["invoice_id"]));
                

        }
        
        $selectArray = $this->addInvoiceStatusToQuery();
        $modelInvoice = $this->modelInvoice->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->join('invoice_serial', 'invoice_serial.invoice_serial_id = invoice.invoice_serial_id', 'left')
            ->join('invoice_incoming_status iis', 'iis.invoice_incoming_status_id = invoice.invoice_status_id', 'left')
            ->join('invoice_outgoing_status ios', 'ios.invoice_outgoing_status_id = invoice.invoice_status_id', 'left')
            ->select($selectArray, false)
            ->where('invoice.user_id', session()->get('user_id'))
            ->where('invoice.invoice_id', $invoice_id);

        if (!$modelInvoice) {
            return view('not-found');
        }

        $invoice_direction = $invoice_item22['invoice_direction'];

        if ($invoice_direction == 'incoming_invoice')
            $invoice_items = $modelInvoice->where('invoice_direction', 'incoming_invoice')->first();
        else if ($invoice_direction == 'outgoing_invoice')
            $invoice_items = $modelInvoice->where('invoice_direction', 'outgoing_invoice')->first();


        $invoice_rows1 = $this->modelInvoiceRow->join('unit', 'unit.unit_id = invoice_row.unit_id')
            ->join('invoice', 'invoice.invoice_id = invoice_row.invoice_id')
            ->join('stock', 'stock.stock_id = invoice_row.stock_id')
            ->where('invoice.invoice_id', $invoice_id)
            ->findAll();

        $invoice_rows2 = $this->modelInvoiceRow->join('unit', 'unit.unit_id = invoice_row.unit_id')
            ->join('invoice', 'invoice.invoice_id = invoice_row.invoice_id')
            ->where('invoice.invoice_id', $invoice_id)
            ->where('invoice_row.stock_id', 0)
            ->findAll();

        $invoice_rows = array_merge($invoice_rows1, $invoice_rows2);
      

        $invoiceLoglar = $this->modelIslem->where("fatura_id", $invoice_id)->orderBy("islem_log_id", "DESC")->findAll() ?? '';



        
 
 

        $data = [
            'Kurlar' => $Kurlar,
            'invoiceLoglar' => $invoiceLoglar,
            'invoice_item' => $invoice_items,
            'invoice_rows' => $invoice_rows
        ];

        // print_r($invoice_rows);
        // return;

        return view('tportal/faturalar/detay/detay', $data);
    }

    public function create()
    {
        $Kurlar = $this->modelMoneyUnit->findAll();

        $transaction_prefix = "PRF";
        $errRows = [];
        if ($this->request->getMethod('true') == 'POST') {
        

    
    
     

            try {
                $data_form = $this->request->getPost('data_form');
                $data_invoice_rows = $this->request->getPost('data_invoice_rows');
                $data_invoice_amounts = $this->request->getPost('data_invoice_amounts');
                $data_invoice_irsaliye = $this->request->getPost('data_invoice_irsaliye');  // İrsaliye aktif olduğunda bu gelen data kullanılacak.
                $data_invoice_iade = $this->request->getPost('data_invoice_iade'); // İade satırları aktif olduğunda bu gelen data kullanılacak.

                foreach ($data_form as $data) {
                    $key = $data['name'];
                    $value = $data['value'];
                    $new_data_form[$key] = $value;
                }

                // print_r($new_data_form);
                // print_r($data_invoice_rows);
                // print_r($data_invoice_amounts);
                // return;


                // echo (int)$data_invoice_amounts['amount_to_be_paid_try'].'   ';
                // echo (int)"0,522".'   ';


                // $money_unit_id = $data_invoice_amounts['money_unit_id'].'   ';

                // echo $money_unit_id.'   ';


                // // str_replace(array('(', ')', ' '), '', $new_data_form['cari_phone'])


                // $dsa = (int)$data_invoice_amounts['amount_to_be_paid_try'].'   ' ;


                // if ($data_invoice_amounts['money_unit_id'] != 3) {
                //     echo "true".'   ' ;
                // } else {
                //     echo "false".'   ' ;
                // }


                // echo $dsa;
                // exit;


                // $stock_items_allls = $this->modelStock->where('user_id', session()->get('user_id'))->where('parent_id', 0)->where('manuel_add', 0)->findAll();

                // print_r($stock_items_allls);
                // return;



                // foreach ($stock_items_allls as $stock_items_alll) {
                //     $stock_items12 = $this->modelStock->where('user_id', session()->get('user_id'))->where('parent_id', $stock_items_alll['stock_id'])->findAll();



                //     // print_r($stock_items12);
                //     // return;



                //     $data_invoice_rows = [];
                //     $satirCount = 0;

                //     $stok_adet = 5000;
                //     $birim_fiyat = 0.5;


                // foreach ($stock_items12 as $stock_item) {

                //     // print_r($stock_item);
                //     // return;


                //     $satir = [
                //         'satir_id' => $satirCount,
                //         'stock_id' => $stock_item['stock_id'],
                //         'stock_title' => $stock_item['stock_title'],
                //         'stock_amount' => $stok_adet,
                //         'unit_id' => $stock_item['sale_unit_id'],
                //         'unit_price' => $birim_fiyat,
                //         'discount_rate' => 0,
                //         'discount_price' => 0,
                //         'subtotal_price' => 0,
                //         'tax_id' => 0,
                //         'tax_price' => 0,
                //         'total_price' => ($stok_adet * $birim_fiyat),
                //         'warehouse_id' => 2,
                //         'gtip_code' => null,
                //         'withholding_id' => 0,
                //         'withholding_rate' => 0,
                //         'withholding_price' => 0,
                //     ];

                //     $satirCount++;
                //     array_push($data_invoice_rows, $satir);
                // }

                // $toplam_fiyat = ($stok_adet * $birim_fiyat) * $satirCount;

                // // print_r($toplam_fiyat);
                // // return;


                // $data_invoice_amounts = [
                //     'money_unit_id' => 3,
                //     'currency_amount' => '0,00',
                //     'stock_total' => $toplam_fiyat,
                //     'stock_total_try' => '0,00',
                //     'discount_total' => '0,00',
                //     'discount_total_try' => '0,00',
                //     'sub_total' => $toplam_fiyat,
                //     'sub_total_try' => '0,00',
                //     'sub_total_all_tax0' => $toplam_fiyat,
                //     'sub_total_all_tax0_try' => '0,00',
                //     'sub_total_all_tax1' => '0,00',
                //     'sub_total_all_tax1_try' => '0,00',
                //     'tax_rate_1_amount' => '0,00',
                //     'tax_rate_1_amount_try' => '0,00',
                //     'sub_total_all_tax10' => '0,00',
                //     'sub_total_all_tax10_try' => '0,00',
                //     'tax_rate_10_amount' => '0,00',
                //     'tax_rate_10_amount_try' => '0,00',
                //     'sub_total_all_tax20' => '0,00',
                //     'sub_total_all_tax20_try' => '0,00',
                //     'tax_rate_20_amount' => '0,00',
                //     'tax_rate_20_amount_try' => '0,00',
                //     'grand_total' => $toplam_fiyat,
                //     'grand_total_try' => '0,00',
                //     'amount_to_be_paid' => $toplam_fiyat,
                //     'amount_to_be_paid_try' => '0,00',
                //     'amount_to_be_paid_text' => null,
                //     'tevkifataTabiIslemTutar' => '0,00',
                //     'tevkifataTabiIslemTutar_try' => '0,00',
                //     'tevkifataTabiIslemKdv' => '0,00',
                //     'tevkifataTabiIslemKdv_try' => '0,00',
                //     'hesaplananTevkifat' => '0,00',
                //     'hesaplananTevkifat_try' => '0,00',
                // ];

                // print_r($data_invoice_rows);
                // print_r($data_invoice_amounts);
                // return;

                $phone = isset($new_data_form['cari_phone']) ? str_replace(array('(', ')', ' '), '', $new_data_form['cari_phone']) : null;
                $phoneNumber = $new_data_form['cari_phone'] ? $new_data_form['area_code'] . " " . $phone : null;

                $invoice_date = $new_data_form['invoice_date'];
                $invoice_time = $new_data_form['invoice_time'];

                $invoice_datetime = convert_datetime_for_sql_time($invoice_date, $invoice_time);


                if (isset($new_data_form['is_expiry']) && $new_data_form['is_expiry'] == 'on') {
                    $expiry_date = $new_data_form['expiry_date'];
                    $payment_method = $new_data_form['payment_method'];
                    $expiry_date_datetime = convert_datetime_for_sql_time($expiry_date, $invoice_time);
                } else {
                    $expiry_date = $invoice_datetime;
                    $payment_method = null;
                    $expiry_date_datetime = convert_datetime_for_sql_time($invoice_date, $invoice_time);
                }

             

                $transaction_amount = isset($data_invoice_amounts['amount_to_be_paid']) ? convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']) : convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try']);
                if ($new_data_form['ftr_turu'] == 'outgoing_invoice') { // outgoing_invoice => Giden Fatura  // incoming_invoice => Gelen Fatura
                    $transaction_direction = 'exit';
                    $is_customer = 1;
                    $is_supplier = 0;
                    $multiplier_for_cari_balance = 1;
                } else {
                    $transaction_direction = 'entry';
                    $is_customer = 0;
                    $is_supplier = 1;
                    $multiplier_for_cari_balance = -1;
                }

                $cari_balance = null;
                $cari_id = null;

                // fatura müşteri seçten geliyorsa cari id  zaten var onu koy geç, 
                // vkn kimlik sorguladan geliyorsa identification_number var ona bak geç
                // $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari', $new_data_form['identification_number'])->first();

                if (isset($new_data_form['cari_id']) && $new_data_form['cari_id'] != 0) {
                    $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id', $new_data_form['cari_id'])->first();
                }
                if (isset($new_data_form['identification_number']) && $new_data_form['identification_number'] != 0 && $new_data_form['identification_number'] != null) {
                    $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.identification_number', $new_data_form['identification_number'])->where("cari.invoice_title", $new_data_form['invoice_title'] == '' ? $new_data_form['name'] . ' ' . $new_data_form['surname'] : $new_data_form['invoice_title'])->first();
                }
                // else{
                //     echo json_encode(['icon' => 'error', 'message' => 'cari tespit edilemedi']);
                //     return;
                // }


                $kurlar = json_decode($new_data_form["kurlar"], true);
                $faturaAsilTutar = 0;
               foreach($kurlar  as $kur)
               {    
                if(isset($cari_item))
                {
                    if($kur["money_unit_id"] == $cari_item["money_unit_id"]){
                        $moneyKod = $this->modelMoneyUnit->where("money_unit_id", $kur["money_unit_id"])->first();
                        $fiyatBul = "kur_toplam_fiyat_" . $moneyKod["money_code"];
                        $faturaAsilTutar =  $kur[$fiyatBul];
                    }else{
                        $faturaAsilTutar = $transaction_amount;
                    }
                }
                   
               }

               if(!empty($faturaAsilTutar) || !isset($faturaAsilTutar))
               {
                $faturaAsilTutar = $transaction_amount;
               }




                if ((isset($new_data_form['is_customer_save']) && $new_data_form['is_customer_save'] == 'on') || !$cari_item) {
                    if (isset($new_data_form['is_export_customer']) && $new_data_form['is_export_customer'] == 'on') {
                        $is_export_customer = 1;
                    } else {
                        $is_export_customer = 0;
                    }
                    $cari_data = [
                        'user_id' => session()->get('user_id'),
                        'money_unit_id' => $data_invoice_amounts['money_unit_id'],
                        'identification_number' => $new_data_form['identification_number'],
                        'tax_administration' => $new_data_form['tax_administration'] != '' ? $new_data_form['tax_administration'] : null,
                        'invoice_title' => $new_data_form['invoice_title'] == '' ? $new_data_form['name'] . ' ' . $new_data_form['surname'] : $new_data_form['invoice_title'],
                        'name' => $new_data_form['name'],
                        'surname' => $new_data_form['surname'],
                        'obligation' => $new_data_form['obligation'] != '' ? $new_data_form['obligation'] : null,
                        'company_type' => $new_data_form['company_type'] != '' ? $new_data_form['company_type'] : null,
                        'cari_phone' => $phoneNumber != '' ? $phoneNumber : null,
                        'cari_email' => $new_data_form['cari_email'] != '' ? $new_data_form['cari_email'] : null,
                        'is_customer' => $is_customer,
                        'is_supplier' => $is_supplier,
                        'is_export_customer' => $is_export_customer,
                    ];

                    $address_data = [
                        'user_id' => session()->get('user_id'),
                        'address_title' => 'Fatura Adresi',
                        'address_country' => $new_data_form['address_country'],
                        'address_city' => $new_data_form['address_city_name'] != '' ? $new_data_form['address_city_name'] : null,
                        'address_city_plate' => isset($new_data_form['address_city']) ? $new_data_form['address_city'] : null,
                        'address_district' => isset($new_data_form['address_district']) ? $new_data_form['address_district'] : null,
                        'zip_code' => $new_data_form['zip_code'],
                        'address' => $new_data_form['address'],
                        'address_phone' => $phoneNumber,
                        'address_email' => $new_data_form['cari_email'] != '' ? $new_data_form['cari_email'] : null,
                    ];

                    if (!$cari_item) {
                        //8 rakamlı cari kodu
                        $create_cari_code = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
                        $cari_data['cari_code'] = $create_cari_code;
                        // $cari_data['cari_balance'] = $multiplier_for_cari_balance * $transaction_amount; 
                        $cari_data['cari_balance'] = 0;

                        $this->modelCari->insert($cari_data);
                        $cari_id = $this->modelCari->getInsertID();
                        $cari_item = $cari_data;
                        $address_data['cari_id'] = $cari_id;
                        $address_data['status'] = 'active';
                        $address_data['default'] = 'true';
                        $this->modelAddress->insert($address_data);
                    } else {
                        $cari_id = $cari_item['cari_id'];
                        $cari_address_id = $cari_item['address_id'];
                        $cari_balance = $cari_item['cari_balance'] + ($faturaAsilTutar * $transaction_amount);
                        $cari_data['cari_balance'] = $cari_balance;
                        $this->modelCari->update($cari_id, $cari_data);

                        $address_data['cari_id'] = $cari_id;
                        $this->modelAddress->update($cari_address_id, $address_data);
                    }
                } else {
                    $cari_id = $cari_item['cari_id'];
                }

                // print_r($cari_id);
                // return;

                // $update_cari_data = [
                //     'cari_balance' => $cari_item['cari_balance'] - convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try'] != '0' ? $data_invoice_amounts['amount_to_be_paid_try'] : $data_invoice_amounts['amount_to_be_paid'])
                // ];
                // print_r($update_cari_data);
                // return;


                if (isset($new_data_form['chk_musteri_bakiye_ekle']) && $new_data_form['chk_musteri_bakiye_ekle'] == 'on') {
                    $invoice_note_id = $new_data_form['invoiceNotesId'];
                    $invoice_note = $new_data_form['txt_fatura_not'] . " - " . $cari_balance;
                } else {
                    $invoice_note_id = $new_data_form['invoiceNotesId'];
                    $invoice_note = $new_data_form['txt_fatura_not'];
                }

                if (isset($new_data_form['chk_not_kaydet']) && $new_data_form['chk_not_kaydet'] == 'on') {
                    $note_item = $this->modelNote->where('note_id', $new_data_form['invoiceNotesId'])->where('user_id', session()->get('user_id'))->first();

                    if (!$note_item) {
                        $insert_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_type' => 'invoice',
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $this->modelNote->insert($insert_invoice_note_data);
                        $invoice_note_id = $this->modelNote->getInsertID();

                    } else {
                        $insert_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_id' => $new_data_form['invoiceNotesId'],
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $invoice_note_id = $new_data_form['invoiceNotesId'];
                        $this->modelNote->update($new_data_form['invoiceNotesId'], $insert_invoice_note_data);
                    }
                }

                if (isset($new_data_form['chx_quickSale']) && $new_data_form['chx_quickSale'] == 'on') {
                    $chx_quickSale = 1;
                } else {
                    $chx_quickSale = 0;
                }

                if (isset($new_data_form['is_customInvoiceNo']) && $new_data_form['is_customInvoiceNo'] == 'on') {
                    $invoice_no = $new_data_form['customInvoiceNo'];
                } else {
                    
                    $create_sale_order_code = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                    $invoice_no = $chx_quickSale == 1 ? 'SF-'.$create_sale_order_code : "#PROFORMA";

                }
                
                $insert_invoice_data = [
                    'user_id' => session()->get('user_id'),
                    'money_unit_id' => $data_invoice_amounts['money_unit_id'],
                    'invoice_serial_id' => $new_data_form['fatura_seri'],

                    'invoice_no' => $invoice_no,
                    'invoice_ettn' => get_uuid(),//$new_data_form['invoice_ettn'],

                    'invoice_direction' => $new_data_form['ftr_turu'],
                    'invoice_scenario' => $new_data_form['fatura_senaryo'],
                    'invoice_type' => $new_data_form['fatura_tipi'],

                    'invoice_date' => $invoice_datetime,

                    'payment_method' => $payment_method,
                    'expiry_date' => $expiry_date_datetime,

                    'invoice_note_id' => $new_data_form['invoiceNotesId'] == '' ? $invoice_note_id : $new_data_form['invoiceNotesId'],
                    'invoice_note' => $invoice_note,

                    'currency_amount' => $data_invoice_amounts['currency_amount'],

                    'stock_total' => convert_number_for_sql($data_invoice_amounts['stock_total']),
                    'stock_total_try' => convert_number_for_sql($data_invoice_amounts['stock_total_try']),

                    'discount_total' => convert_number_for_sql($data_invoice_amounts['discount_total']),
                    'discount_total_try' => convert_number_for_sql($data_invoice_amounts['discount_total_try']),

                    'tax_rate_1_amount' => convert_number_for_sql($data_invoice_amounts['tax_rate_1_amount']),
                    'tax_rate_1_amount_try' => convert_number_for_sql($data_invoice_amounts['tax_rate_1_amount_try']),
                    'tax_rate_10_amount' => convert_number_for_sql($data_invoice_amounts['tax_rate_10_amount']),
                    'tax_rate_10_amount_try' => convert_number_for_sql($data_invoice_amounts['tax_rate_10_amount_try']),
                    'tax_rate_20_amount' => convert_number_for_sql($data_invoice_amounts['tax_rate_20_amount']),
                    'tax_rate_20_amount_try' => convert_number_for_sql($data_invoice_amounts['tax_rate_20_amount_try']),

                    'sub_total' => convert_number_for_sql($data_invoice_amounts['sub_total']),
                    'sub_total_try' => convert_number_for_sql($data_invoice_amounts['sub_total_try']),
                    'sub_total_0' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax0']),
                    'sub_total_0_try' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax0_try']),
                    'sub_total_1' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax1']),
                    'sub_total_1_try' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax1_try']),
                    'sub_total_10' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax10']),
                    'sub_total_10_try' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax10_try']),
                    'sub_total_20' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax20']),
                    'sub_total_20_try' => convert_number_for_sql($data_invoice_amounts['sub_total_all_tax20_try']),

                    'transaction_subject_to_withholding_amount' => convert_number_for_sql($data_invoice_amounts['tevkifataTabiIslemTutar']),
                    'transaction_subject_to_withholding_amount_try' => convert_number_for_sql($data_invoice_amounts['tevkifataTabiIslemTutar_try']),
                    'transaction_subject_to_withholding_calculated_tax' => convert_number_for_sql($data_invoice_amounts['tevkifataTabiIslemKdv']),
                    'transaction_subject_to_withholding_calculated_tax_try' => convert_number_for_sql($data_invoice_amounts['tevkifataTabiIslemKdv_try']),
                    'withholding_tax' => convert_number_for_sql($data_invoice_amounts['hesaplananTevkifat']),
                    'withholding_tax_try' => convert_number_for_sql($data_invoice_amounts['hesaplananTevkifat_try']),

                    'grand_total' => convert_number_for_sql($data_invoice_amounts['grand_total']),
                    'grand_total_try' => convert_number_for_sql($data_invoice_amounts['grand_total_try']),

                    'amount_to_be_paid' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']),
                    'amount_to_be_paid_try' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try']),

                    'amount_to_be_paid_text' => $data_invoice_amounts['amount_to_be_paid_text'],

                    'cari_id' => $cari_id,
                    'cari_identification_number' => $new_data_form['identification_number'],
                    'cari_tax_administration' => $new_data_form['tax_administration'],

                    'cari_invoice_title' => $new_data_form['invoice_title'] == '' ? $new_data_form['name'] . " " . $new_data_form['surname'] : $new_data_form['invoice_title'],
                    'cari_name' => $new_data_form['name'],
                    'cari_surname' => $new_data_form['surname'],
                    'cari_obligation' => $new_data_form['obligation'],
                    'cari_company_type' => $new_data_form['company_type'],
                    'cari_phone' => $phoneNumber,
                    'cari_email' => $new_data_form['cari_email'],

                    'address_country' => $new_data_form['address_country'],

                    'address_city' => $new_data_form['address_city_name'],
                    'address_city_plate' => isset($new_data_form['address_city']) ? $new_data_form['address_city'] : "",
                    'address_district' => isset($new_data_form['address_district']) ? $new_data_form['address_district'] : "",
                    'address_zip_code' => $new_data_form['zip_code'],
                    'address' => $new_data_form['address'],

                    'invoice_status_id' => "1",
                    'is_quick_sale_receipt' => $chx_quickSale,
                    'warehouse_id' => $new_data_form['warehouse_id'],
                ];



                $this->modelInvoice->insert($insert_invoice_data);
                $invoice_id = $this->modelInvoice->getInsertID();



            $this->modelIslem->LogOlustur(
                session()->get('client_id'),
                session()->get('user_id'),
                $invoice_id,
                'ok',
                'fatura',
                "Fatura Başarıyla Oluşturuldu",
                session()->get("user_item")["user_adsoyad"],
                json_encode( ['invoice_id' => $invoice_id, 'fatura_bilgileri' => $insert_invoice_data, 'fatura_satirlari' => $data_invoice_rows]),
                0,
                0,
                $invoice_id,
                0
             );


                $kurlar = json_decode($new_data_form["kurlar"], true);

                if(isset($kurlar)){

                    foreach ($kurlar as $kur) {
                        // Fatura fiyatı mevcut mu kontrol et (fatura_id ve money_unit_id'yi kontrol ediyoruz)
                        $InvoiceFiyatlar = $this->modelFaturaTutar
                                                ->where("fatura_id", $invoice_id)
                                                ->where("kur", $kur['money_unit_id']) // Ek olarak money_unit_id kontrolü
                                                ->first();
                        
                        // Default değerini belirle
                        $default = ($data_invoice_amounts['money_unit_id'] == $kur['money_unit_id']) ? "true" : "false";
                    
                        // Fiyat verilerini hazırlama
                        $fiyatDatalar = [
                            'user_id'      => session()->get('user_id'),
                            'cari_id'      => $cari_id,
                            'fatura_id'    => $invoice_id,
                            'kur'          => $kur['money_unit_id'],
                            'kur_value'    => $this->convert_sql($kur['money_value']),
                            'toplam_tutar' => $this->convert_sql($kur['kur_toplam_fiyat_' . $kur['money_code']]),
                            'tarih'        => date("d-m-Y h:i:s"),  // PHP'de date() fonksiyonu kullanılır
                            'default'      => $default
                        ];
                    
                        // Fatura fiyatı mevcutsa güncelle, yoksa ekle
                        if ($InvoiceFiyatlar) {
                            $updateFiyat = $this->modelFaturaTutar->update($InvoiceFiyatlar["satir_id"], $fiyatDatalar);
                            if (!$updateFiyat) {
                                // Güncelleme başarısızsa hata işlemi yapılabilir
                                echo "Fiyat güncellenirken bir hata oluştu.";
                            }
                        } else {
                            $insertFiyat = $this->modelFaturaTutar->insert($fiyatDatalar);
                            if (!$insertFiyat) {
                                // Ekleme başarısızsa hata işlemi yapılabilir
                                echo "Fiyat eklenirken bir hata oluştu.";
                            }
                        }
                    }
                    

                }

              


                //cari para birimi
                $cari_money_unit_id = $cari_item['money_unit_id'];



                $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                if ($last_transaction) {
                    $transaction_counter = $last_transaction['transaction_counter'] + 1;
                } else {
                    $transaction_counter = 1;
                }
                $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                $insert_financial_movement_data = [
                    'user_id' => session()->get('user_id'),
                    'financial_account_id' => null,
                    'cari_id' => $cari_id,
                    'money_unit_id' => $data_invoice_amounts['money_unit_id'],
                    'transaction_number' => $transaction_number,
                    'transaction_direction' => $transaction_direction,
                    'transaction_type' => $new_data_form['ftr_turu'],
                    'invoice_id' => $invoice_id,
                    'transaction_tool' => 'not_payroll',
                    'transaction_title' => 'Fatura oluştur anında oluşan hareket',
                    'transaction_description' => $invoice_note,
                    'transaction_amount' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']),
                    'transaction_real_amount' => convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']),
                    'transaction_date' => $invoice_datetime,
                    'transaction_prefix' => $transaction_prefix,
                    'transaction_counter' => $transaction_counter
                ];
                $this->modelFinancialMovement->insert($insert_financial_movement_data);
                $financial_movement_id = $this->modelFinancialMovement->getInsertID();



                if ($new_data_form['ftr_turu'] == 'outgoing_invoice') { //fatura_turu satış(giden) ise

                    $data_outgoing_invoice_invoice_rows_batch = []; // Toplu ekleme için dizi
                    foreach ($data_invoice_rows as $data_invoice_row) {

                        if (isset($data_invoice_row['isDeletedInvoice'])) {
                            continue;
                        } else {

                            $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $data_invoice_row['stock_id'])->first();
                            if (!$stock_item) {
                                // $errRows[] = [
                                //     'message' => "Verilen stok bulunamadı.",
                                //     'data' => [
                                //         'stock_id' => $data_invoice_row['stock_id'],
                                //         'stock_title' => $data_invoice_row['stock_title'],
                                //         'gtip_code' => $data_invoice_row['gtip_code'],
                                //         'stock_amount' => $data_invoice_row['stock_amount'],
                                //     ]
                                // ];
                     
                                $fatura_money_id = $data_invoice_amounts['money_unit_id']; // Para birimi ID'si
                                $unit_price = $data_invoice_row['unit_price']; // Ürün birim fiyatı
                                $new_column_cari = $unit_price; // Varsayılan değer TL

                                // Para birimi 1 ise zaten TL
                                if ($fatura_money_id == 3) {
                                    $new_column_cari = $unit_price;
                                } else {
                                    // Para birimi TL değilse, döviz çarpanını al
                                    $moneyItem = $this->modelMoneyUnit
                                        ->where('user_id', session()->get('user_id'))
                                        ->where('money_unit_id', $fatura_money_id)
                                        ->first();

                                    // Eğer çarpan bulunamazsa varsayılan TL değeri kalır
                                    if ($moneyItem && isset($moneyItem['money_value'])) {
                                        // Unit_price * Döviz çarpanı (TL'ye çevirme)
                                        $new_column_cari = $unit_price * $moneyItem['money_value'];
                                    }
                                }

// Artık $new_column_cari her zaman TL cinsinden saklanıyor


                                $insert_invoice_row_data = [
                                    'user_id' => session()->get('user_id'),
                                    'cari_id' => $cari_id,
                                    'invoice_id' => $invoice_id,
                                    'stock_id' => $data_invoice_row['stock_id'],

                                    'stock_title' => $data_invoice_row['stock_title'],
                                    'stock_amount' => $data_invoice_row['stock_amount'], //convert_number_for_sql($data_invoice_row['stock_amount'])

                                    'unit_id' => $data_invoice_row['unit_id'],
                                    'unit_price' => $data_invoice_row['unit_price'],
                                    'unit_price_sabit' => $new_column_cari,

                                    'discount_rate' => $data_invoice_row['discount_rate'],
                                    'discount_price' => $data_invoice_row['discount_price'],

                                    'subtotal_price' => $data_invoice_row['subtotal_price'],

                                    'tax_id' => $data_invoice_row['tax_id'],
                                    'tax_price' => $data_invoice_row['tax_price'],

                                    'total_price' => $data_invoice_row['total_price'],

                                    'gtip_code' => $data_invoice_row['gtip_code'],

                                    'withholding_id' => $data_invoice_row['withholding_id'],
                                    'withholding_rate' => $data_invoice_row['withholding_rate'],
                                    'withholding_price' => $data_invoice_row['withholding_price'],
                                ];

                                $this->modelInvoiceRow->insert($insert_invoice_row_data);
                                $invoice_row_id = $this->modelInvoiceRow->getInsertID();

                                continue;
                            } else if ($stock_item['stock_type'] == 'service') {

                                // return;


                                // fatura satırlarını oluştur
                                $insert_invoice_row_data = [
                                    'user_id' => session()->get('user_id'),
                                    'cari_id' => $cari_id,
                                    'invoice_id' => $invoice_id,
                                    'stock_id' => $data_invoice_row['stock_id'],

                                    'stock_title' => $data_invoice_row['stock_title'],
                                    'stock_amount' => $data_invoice_row['stock_amount'], //convert_number_for_sql($data_invoice_row['stock_amount'])

                                    'unit_id' => $data_invoice_row['unit_id'],
                                    'unit_price' => $data_invoice_row['unit_price'],

                                    'discount_rate' => $data_invoice_row['discount_rate'],
                                    'discount_price' => $data_invoice_row['discount_price'],

                                    'subtotal_price' => $data_invoice_row['subtotal_price'],

                                    'tax_id' => $data_invoice_row['tax_id'],
                                    'tax_price' => $data_invoice_row['tax_price'],

                                    'total_price' => $data_invoice_row['total_price'],

                                    'gtip_code' => $data_invoice_row['gtip_code'],

                                    'withholding_id' => $data_invoice_row['withholding_id'],
                                    'withholding_rate' => $data_invoice_row['withholding_rate'],
                                    'withholding_price' => $data_invoice_row['withholding_price'],
                                ];

                                $this->modelInvoiceRow->insert($insert_invoice_row_data);
                                $invoice_row_id = $this->modelInvoiceRow->getInsertID();

                               // print_r($insert_invoice_row_data);


                                $stock_barcode_item = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                                    ->where('stock_barcode.stock_id', $data_invoice_row['stock_id'])
                                    ->first();


                                $curentUsedAmount = $stock_barcode_item['used_amount'];
                                $update_stock_barcode_data = [
                                    'used_amount' => $curentUsedAmount + $data_invoice_row['stock_amount'],
                                ];
                                $this->modelStockBarcode->update($stock_barcode_item['stock_barcode_id'], $update_stock_barcode_data);

                               // print_r($update_stock_barcode_data);



                                $curentStockTotalQuantity = $stock_item['stock_total_quantity'];
                                $update_stock_data = [
                                    'stock_total_quantity' => $curentStockTotalQuantity + $data_invoice_row['stock_amount'],
                                ];
                                $this->modelStock->update($stock_item['stock_id'], $update_stock_data);

                               // print_r($update_stock_data);


                                $parent_stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $stock_item['parent_id'])->first();
                              //  print_r("parent item başlangıç");
                               // print_r($parent_stock_item);
                               // print_r("parent item bitiş");


                                ///parent ürünü bul onun toplamına da ekle
                               // Güvenli dizi erişimi
                                $curentParentStockTotalQuantity = $parent_stock_item['stock_total_quantity'] ?? 0;
                                $stockAmount = $data_invoice_row['stock_amount'] ?? 0;

                                // Güncelleme verisini hazırlama
                                $update_parent_stock_data = [
                                    'stock_total_quantity' => $curentParentStockTotalQuantity + $stockAmount,
                                ];

                                // Stok güncelleme
                                if (isset($parent_stock_item['stock_id'])) {
                                    $this->modelStock->update($parent_stock_item['stock_id'], $update_parent_stock_data);
                                } else {
                                    // Hata mesajı veya alternatif işlem
                                }

                                
                                
                                // $warehouse_item = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('default','true')->first();

                                // stock hareketi oluştur
                                $last_transaction = $this->modelStockMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                                if ($last_transaction) {
                                    $transaction_counter = $last_transaction['transaction_counter'] + 1;
                                } else {
                                    $transaction_counter = 1;
                                }
                                $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                                $insert_stock_movement_data = [
                                    'user_id' => session()->get('user_id'),
                                    'stock_barcode_id' => $stock_barcode_item['stock_barcode_id'],
                                    'invoice_id' => $invoice_id,
                                    'movement_type' => 'outgoing',
                                    'transaction_number' => $transaction_number,
                                    'transaction_note' => null,
                                    'from_warehouse' => null,
                                    'to_warehouse' => null,
                                    'transaction_info' => 'Stok Çıkış',
                                    'sale_unit_price' => $data_invoice_row['unit_price'],
                                    'sale_money_unit_id' => $data_invoice_amounts['money_unit_id'],
                                    'transaction_quantity' => $data_invoice_row['stock_amount'],
                                    'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                                    'transaction_prefix' => $transaction_prefix,
                                    'transaction_counter' => $transaction_counter,
                                ];
                                $this->modelStockMovement->insert($insert_stock_movement_data);
                                $stock_movement_id = $this->modelStockMovement->getInsertID();

                              //  print_r($insert_stock_movement_data);


                            } else {
                                // echo 'stock id gibi: ' . $data_invoice_row['stock_id'];
                                // print_r($stock_item);
                                // return;

                                $parent_idd = $stock_item['parent_id'];


                                $insert_StockWarehouseQuantity = [
                                    'user_id' => session()->get('user_id'),
                                    'warehouse_id' => $data_invoice_row['warehouse_id'],
                                    'stock_id' => $stock_item['stock_id'],
                                    'parent_id' => $stock_item['parent_id'],
                                    'stock_quantity' => $data_invoice_row['stock_amount'],
                                ];

                                // print_r($insert_StockWarehouseQuantity);


                                $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $data_invoice_row['warehouse_id'], $data_invoice_row['stock_id'], $parent_idd, floatval($data_invoice_row['stock_amount']), 'remove', $this->modelStockWarehouseQuantity, $this->modelStock);
                                if ($addStock === 'eksi_stok') {
                                    echo json_encode(['icon' => 'error', 'message' => 'bu işlemden sonra bazı ürünlerin stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz.']);
                                    $this->modelInvoice->delete($invoice_id);
                                    $this->modelFinancialMovement->delete($financial_movement_id);
                                    exit();
                                }


                                $insert_invoice_row_data = [
                                    'user_id' => session()->get('user_id'),
                                    'cari_id' => $cari_id,
                                    'invoice_id' => $invoice_id,
                                    'stock_id' => $data_invoice_row['stock_id'],

                                    'stock_title' => $data_invoice_row['stock_title'],
                                    'stock_amount' => $data_invoice_row['stock_amount'], //convert_number_for_sql($data_invoice_row['stock_amount'])

                                    'unit_id' => $data_invoice_row['unit_id'],
                                    'unit_price' => $data_invoice_row['unit_price'],

                                    'discount_rate' => $data_invoice_row['discount_rate'],
                                    'discount_price' => $data_invoice_row['discount_price'],

                                    'subtotal_price' => $data_invoice_row['subtotal_price'],

                                    'tax_id' => $data_invoice_row['tax_id'],
                                    'tax_price' => $data_invoice_row['tax_price'],

                                    'total_price' => $data_invoice_row['total_price'],

                                    'gtip_code' => $data_invoice_row['gtip_code'],

                                    'withholding_id' => $data_invoice_row['withholding_id'],
                                    'withholding_rate' => $data_invoice_row['withholding_rate'],
                                    'withholding_price' => $data_invoice_row['withholding_price'],
                                ];

                                $this->modelInvoiceRow->insert($insert_invoice_row_data);
                                $invoice_row_id = $this->modelInvoiceRow->getInsertID();



                                $last_stock_barcode_id = 0;
                                $stock_barcode_all = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                                    ->where('stock_barcode.stock_id', $data_invoice_row['stock_id'])
                                    ->where('stock_barcode.warehouse_id', $data_invoice_row['warehouse_id'])
                                    ->findAll();

                                // stock_barcode'da used_amount günceller
                                foreach ($stock_barcode_all as $stock_barcode_item) {

                                    $varMi = $stock_barcode_item['total_amount'] - $stock_barcode_item['used_amount'];

                                    if ($varMi >= $data_invoice_row['stock_amount']) {
                                        $stock_movement_prefix = 'TRNSCTN';

                                        $last_transaction = $this->modelStockMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                                        if ($last_transaction) {
                                            $transaction_counter = $last_transaction['transaction_counter'] + 1;
                                        } else {
                                            $transaction_counter = 1;
                                        }
                                        $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                                        $insert_stock_movement_data = [
                                            'user_id' => session()->get('user_id'),
                                            'stock_barcode_id' => $stock_barcode_item['stock_barcode_id'],
                                            'invoice_id' => $invoice_id,
                                            'movement_type' => 'outgoing',
                                            'transaction_number' => $transaction_number,
                                            'transaction_note' => null,
                                            'from_warehouse' => $data_invoice_row['warehouse_id'],
                                            'transaction_info' => 'Stok Çıkış',
                                            'sale_unit_price' => $data_invoice_row['unit_price'],
                                            'sale_money_unit_id' => $data_invoice_amounts['money_unit_id'],
                                            'transaction_quantity' => $data_invoice_row['stock_amount'],
                                            'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                                            'transaction_prefix' => $transaction_prefix,
                                            'transaction_counter' => $transaction_counter,
                                        ];
                                        $this->modelStockMovement->insert($insert_stock_movement_data);
                                        $stock_movement_id = $this->modelStockMovement->getInsertID();

                                        $used_amount = $stock_barcode_item['used_amount'] + $data_invoice_row['stock_amount'];
                                        $stock_barcode_status = $used_amount == $stock_barcode_item['total_amount'] ? 'out_of_stock' : 'available';
                                        $update_stock_barcode_data = [
                                            'used_amount' => $used_amount,
                                            'stock_barcode_status' => $stock_barcode_status
                                        ];
                                        $this->modelStockBarcode->update($stock_barcode_item['stock_barcode_id'], $update_stock_barcode_data);

                                        $update_invoice_row_data = [
                                            'stock_barcode_id' => $stock_barcode_item['stock_barcode_id'],
                                        ];
                                        $this->modelInvoiceRow->update($invoice_row_id, $update_invoice_row_data);
                                        break 1;
                                    }
                                }
                            }
                        }
                    }

                    // print_r("foreach dışı/sonu");
                    // return;

                    // echo ' amount_to_be_paid_try: '.$data_invoice_amounts['amount_to_be_paid_try'];
                    // echo ' amount_to_be_paid: '.$data_invoice_amounts['amount_to_be_paid'];




                    // $last = $data_invoice_amounts['money_unit_id'] != 3 ? $data_invoice_amounts['amount_to_be_paid_try'] : $data_invoice_amounts['amount_to_be_paid'];
                    $lastc = convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']);

                    // echo ' convertsiz: '.$last;
                    // echo ' convertli: '.$lastc;


                    // echo ' cari_balance '.$cari_item['cari_balance'];
                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] + $faturaAsilTutar
                    ];
                    $this->modelCari->update($cari_id, $update_cari_data);
                    // print_r($update_cari_data);

                    // print_r($cari_item['cari_balance'] - convert_number_for_sql($data_invoice_amounts['amount_to_be_paid_try'] != '0,00' ? $data_invoice_amounts['amount_to_be_paid_try'] : $data_invoice_amounts['amount_to_be_paid']));

                } else if ($new_data_form['ftr_turu'] == 'incoming_invoice') { //fatura_turu alış(gelen) ise

                   

                
                    foreach ($data_invoice_rows as $data_invoice_row) {

                        #TODO sistemde kayıtlı olmayan bir ürün için de te seferlik fatura oluşturabilmeli. daha sonra bu ürünü kaydet seçeneği de koyacağız.
                        #check if stock exists
                     
                        $stock_item = $this->modelStock->where('user_id', session()->get('user_id'))->where('stock_id', $data_invoice_row['stock_id'])->first();
                        if (!$stock_item) {
                            // $errRows[] = [
                            //     'message' => "Verilen stok bulunamadı.",
                            //     'data' => [
                            //         'stock_id' => $data_invoice_row['stock_id'],
                            //         'stock_title' => $data_invoice_row['stock_title'],
                            //         'gtip_code' => $data_invoice_row['gtip_code'],
                            //         'stock_amount' => $data_invoice_row['stock_amount'],
                            //     ]
                            // ];

                            $insert_invoice_row_data = [
                                'user_id' => session()->get('user_id'),
                                'cari_id' => $cari_id,
                                'invoice_id' => $invoice_id,
                                'stock_id' => $data_invoice_row['stock_id'],

                                'stock_title' => $data_invoice_row['stock_title'],
                                'stock_amount' => $data_invoice_row['stock_amount'], //convert_number_for_sql($data_invoice_row['stock_amount'])

                                'unit_id' => $data_invoice_row['unit_id'],
                                'unit_price' => $data_invoice_row['unit_price'],

                                'discount_rate' => $data_invoice_row['discount_rate'],
                                'discount_price' => $data_invoice_row['discount_price'],

                                'subtotal_price' => $data_invoice_row['subtotal_price'],

                                'tax_id' => $data_invoice_row['tax_id'],
                                'tax_price' => $data_invoice_row['tax_price'],

                                'total_price' => $data_invoice_row['total_price'],

                                'gtip_code' => $data_invoice_row['gtip_code'],

                                'withholding_id' => $data_invoice_row['withholding_id'],
                                'withholding_rate' => $data_invoice_row['withholding_rate'],
                                'withholding_price' => $data_invoice_row['withholding_price'],
                            ];

                            $this->modelInvoiceRow->insert($insert_invoice_row_data);
                            $invoice_row_id = $this->modelInvoiceRow->getInsertID();

                            continue;
                        }
                        else{
                            if (isset($data_invoice_row['isDeleted'] ) ) {
                                continue;
                            } else {

                                if(empty( $data_invoice_row['stock_title'])){
                                    continue;
                                }
    
                                $parent_idd = $stock_item['parent_id'];
                                $insert_invoice_row_data = [
                                    'user_id' => session()->get('user_id'),
                                    'cari_id' => $cari_id,
                                    'invoice_id' => $invoice_id,
                                    'stock_id' => $data_invoice_row['stock_id'],
    
                                    'stock_title' => $data_invoice_row['stock_title'],
                                    'stock_amount' => $data_invoice_row['stock_amount'], //convert_number_for_sql($data_invoice_row['stock_amount'])
    
                                    'unit_id' => $data_invoice_row['unit_id'],
                                    'unit_price' => $data_invoice_row['unit_price'],
    
                                    'discount_rate' => $data_invoice_row['discount_rate'],
                                    'discount_price' => $data_invoice_row['discount_price'],
    
                                    'subtotal_price' => $data_invoice_row['subtotal_price'],
    
                                    'tax_id' => $data_invoice_row['tax_id'],
                                    'tax_price' => $data_invoice_row['tax_price'],
    
                                    'total_price' => $data_invoice_row['total_price'],
    
                                    'gtip_code' => $data_invoice_row['gtip_code'],
    
                                    'withholding_id' => $data_invoice_row['withholding_id'],
                                    'withholding_rate' => $data_invoice_row['withholding_rate'],
                                    'withholding_price' => $data_invoice_row['withholding_price'],
                                ];
    
                                $this->modelInvoiceRow->insert($insert_invoice_row_data);
                                #fatura_turu alış ise eklenen fatura satırları stok giriş olarak davranacak...
                                if (isset($new_data_form['incoming_invoice_warehouse_id']) && $new_data_form['incoming_invoice_warehouse_id'] != 0) {
    
                                    $warehouse_id = $new_data_form['warehouse_id'];
                                    $supplier_id = $new_data_form['cari_id'];
                                    $stock_quantity = $data_invoice_row['stock_amount'];
                                    $warehouse_address = null;
                                    $buy_unit_price = $data_invoice_row['unit_price'];
                                    $buy_money_unit_id = $data_invoice_amounts['money_unit_id'];
    
                                    //stock_barcode eklendi
                                    $barcode_number = generate_barcode_number();
                                    $insert_barcode_data = [
                                        'stock_id' => $data_invoice_row['stock_id'],
                                        'warehouse_id' => $warehouse_id,
                                        'warehouse_address' => null,
                                        'barcode_number' => $barcode_number,
                                        'total_amount' => $stock_quantity,
                                        'used_amount' => 0
                                    ];
                                    $this->modelStockBarcode->insert($insert_barcode_data);
                                    $new_insert_stock_barcode_id = $this->modelStockBarcode->getInsertID();
    
    
                                    //finansal hareket eklenecek       ->       fatura oluşunca da bir hareket oluşuyor. SORULACAK
                                    // $stock_entry_prefix = "FTRTDRK";
                                    // $stock_total = str_replace(',', '.', $stock_quantity) * str_replace(',', '.', $buy_unit_price);
    
                                    // [$transaction_direction, $amount_to_be_processed] = ['entry', $stock_total * -1];
    
                                    // $currentDateTime = new Time('now', 'Turkey', 'en_US');
                                    // $currency_amount = str_replace(',', '.', $this->request->getPost('currency_amount')) ?? 1;
                                    // $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                                    // if ($last_transaction) {
                                    //     $transaction_counter = $last_transaction['transaction_counter'] + 1;
                                    // } else {
                                    //     $transaction_counter = 1;
                                    // }
                                    // $transaction_number = $stock_entry_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                                    // $insert_financial_movement_data = [
                                    //     'user_id' => session()->get('user_id'),
                                    //     'cari_id' => $supplier_id,
                                    //     'money_unit_id' => $buy_money_unit_id,
                                    //     'transaction_number' => $transaction_number,
                                    //     'transaction_direction' => $transaction_direction,
                                    //     'transaction_type' => 'incoming_invoice',
                                    //     'invoice_id' => $invoice_id,
                                    //     'transaction_tool' => 'not_payroll',
                                    //     'transaction_title' => "fatura alış türü, stok girişinden oluşan hareket",
                                    //     'transaction_description' => "fatura sayfasında fatura tipi alış seçildiğinden stok girişi yapılırken oluşan hareket.",
                                    //     'transaction_amount' => $stock_total,
                                    //     'transaction_real_amount' => $stock_total,
                                    //     'transaction_date' => $currentDateTime,
                                    //     'transaction_prefix' => $stock_entry_prefix,
                                    //     'transaction_counter' => $transaction_counter
                                    // ];
                                    // $this->modelFinancialMovement->insert($insert_financial_movement_data);
                                    // $financialMovement_id = $this->modelFinancialMovement->getInsertID();
    
                                    $stock_movement_prefix = 'TRNSCTN';
                                    $last_transaction_stock_movement = $this->modelStockMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                                    if ($last_transaction_stock_movement) {
                                        $transaction_counter_stock_movement = $last_transaction_stock_movement['transaction_counter'] + 1;
                                    } else {
                                        $transaction_counter_stock_movement = 1;
                                    }
                                    $transaction_number_stock_movement = $stock_movement_prefix . str_pad($transaction_counter_stock_movement, 6, '0', STR_PAD_LEFT);
    
                                    $insert_movement_data = [
                                        'user_id' => session()->get('user_id'),
                                        'stock_barcode_id' => $new_insert_stock_barcode_id,
                                        'invoice_id' => $invoice_id,
                                        'supplier_id' => $supplier_id,
                                        'movement_type' => 'incoming',
                                        'transaction_number' => $transaction_number_stock_movement,
                                        'to_warehouse' => $warehouse_id,
                                        'transaction_note' => null,
                                        'transaction_info' => $supplier_id != 0 ? ($cari_item['invoice_title'] == '' ? $cari_item['name'] . " " . $cari_item['surname'] : $cari_item['invoice_title']) : 'Manuel Stok',
                                        'buy_unit_price' => $buy_unit_price,
                                        'buy_money_unit_id' => $buy_money_unit_id,
                                        'transaction_quantity' => $stock_quantity,
                                        'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                                        'transaction_prefix' => $stock_movement_prefix,
                                        'transaction_counter' => $transaction_counter_stock_movement,
                                    ];
                                    $this->modelStockMovement->insert($insert_movement_data);
                                    $stock_movement_id = $this->modelStockMovement->getInsertID();
    
                                    $insert_StockWarehouseQuantity = [
                                        'user_id' => session()->get('user_id'),
                                        'warehouse_id' => $warehouse_id,
                                        'stock_id' => $stock_item['stock_id'],
                                        'parent_id' => $stock_item['parent_id'],
                                        'stock_quantity' => $stock_quantity,
                                    ];
    
                                    $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $warehouse_id, $stock_item['stock_id'], $stock_item['parent_id'], $stock_quantity, 'add', $this->modelStockWarehouseQuantity, $this->modelStock);
    
                                    if ($addStock === 'eksi_stok') {
                                        echo json_encode(['icon' => 'error', 'message' => 'bu işlemden sonra bazı ürünlerin stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz.']);
    
                                        return;
                                    }
                                }
                            }
                        }



                        
                    }
                    $lastc = convert_number_for_sql($data_invoice_amounts['amount_to_be_paid']);

                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] - $faturaAsilTutar,
                    ];
                    $this->modelCari->update($cari_id, $update_cari_data);

                } else {
                    // print_r("else düştük beee");
                }


                #tahsilat yapılmışsa...
                if (isset($new_data_form['chx_has_collection'])) {
                    $financial_account_id = isset($new_data_form['selectedAccount']) ? $new_data_form['selectedAccount'] : '';
                    $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                    if ($last_transaction) {
                        $transaction_counter = $last_transaction['transaction_counter'] + 1;
                    } else {
                        $transaction_counter = 1;
                    }
                    $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                    


                    if ($new_data_form['ftr_turu'] == 'outgoing_invoice') {

                        $insert_financial_movement_data = [
                            'user_id' => session()->get('user_id'),
                            'financial_account_id' => $financial_account_id,
                            'cari_id' => $cari_id,
                            'money_unit_id' => $new_data_form['selectedAccountMoneyId'],
                            'transaction_number' => $transaction_number,
                            'transaction_direction' => 'entry',
                            'transaction_type' => 'collection',
                            'invoice_id' => $invoice_id,
                            'transaction_tool' => 'not_payroll',
                            'transaction_title' => 'Fatura oluştur anında yapılan tahsilat 2',
                            'transaction_description' => $new_data_form['txt_fatura_not'],
                            'transaction_amount' => convert_number_for_sql($new_data_form['transaction_amount']),
                            'transaction_real_amount' => convert_number_for_sql($new_data_form['transaction_amount']),
                            'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                            'transaction_prefix' => $transaction_prefix,
                            'transaction_counter' => $transaction_counter
                        ];
                        $this->modelFinancialMovement->insert($insert_financial_movement_data);
                        $is_collection_financial_movement_id = $this->modelFinancialMovement->getInsertID();
                        
                        $financial_account_item = $this->modelFinancialAccount->find($financial_account_id);
                        $update_financial_account_data = [
                            'account_balance' => $financial_account_item['account_balance'] + convert_number_for_sql($new_data_form['transaction_amount'])
                        ];
                        $this->modelFinancialAccount->update($financial_account_id, $update_financial_account_data);

                        //fatura oluştur anında tahsilat yapıldı ise oluşan finansal hareket id ver
                        $update_collect_invoice_data = [
                            'is_quick_collection_financial_movement_id' => $is_collection_financial_movement_id,
                        ];
                        $this->modelInvoice->update($invoice_id, $update_collect_invoice_data);


                        $lastc = convert_number_for_sql($cari_money_unit_id == 3 ? convert_number_for_sql($new_data_form['transaction_amount']) : convert_number_for_sql($new_data_form['transaction_amount']));


                        $amount_to_be_processed = $lastc * -1;

                        $firstCariBalance = $cari_item['cari_balance'] + $amount_to_be_processed;

                        $update_cari_data = [
                            'cari_balance' => $cari_item['cari_balance'] + $amount_to_be_processed,
                        ];
                        $this->modelCari->update($cari_id, $update_cari_data);

                        $update_cari_data = [
                            'cari_balance' => $firstCariBalance + $lastc,
                        ];
                        $this->modelCari->update($cari_id, $update_cari_data);
                    }
                    else if ($new_data_form['ftr_turu'] == 'incoming_invoice') {

                        $insert_financial_movement_data = [
                            'user_id' => session()->get('user_id'),
                            'financial_account_id' => $financial_account_id,
                            'cari_id' => $cari_id,
                            'money_unit_id' => $new_data_form['selectedAccountMoneyId'],
                            'transaction_number' => $transaction_number,
                            'transaction_direction' => 'exit',
                            'transaction_type' => 'payment',
                            'invoice_id' => $invoice_id,
                            'transaction_tool' => 'not_payroll',
                            'transaction_title' => $data_invoice_rows[0]['stock_title'],
                            'transaction_description' => $new_data_form['txt_fatura_not'],
                            'transaction_amount' => convert_number_for_sql($new_data_form['transaction_amount']),
                            'transaction_real_amount' => convert_number_for_sql($new_data_form['transaction_amount']),
                            'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                            'transaction_prefix' => $transaction_prefix,
                            'transaction_counter' => $transaction_counter
                        ];
                        $this->modelFinancialMovement->insert($insert_financial_movement_data);
                        $is_collection_financial_movement_id = $this->modelFinancialMovement->getInsertID();
                        
                        $financial_account_item = $this->modelFinancialAccount->find($financial_account_id);
                        $update_financial_account_data = [
                            'account_balance' => $financial_account_item['account_balance'] - convert_number_for_sql($new_data_form['transaction_amount'])
                        ];
                        $this->modelFinancialAccount->update($financial_account_id, $update_financial_account_data);

                        //fatura oluştur anında tahsilat yapıldı ise oluşan finansal hareket id ver
                        $update_collect_invoice_data = [
                            'is_quick_collection_financial_movement_id' => $is_collection_financial_movement_id,
                        ];
                        $this->modelInvoice->update($invoice_id, $update_collect_invoice_data);


                        $lastc = convert_number_for_sql($cari_money_unit_id == 3 ? convert_number_for_sql($new_data_form['transaction_amount']) : convert_number_for_sql($new_data_form['transaction_amount']));


                        $amount_to_be_processed = $lastc * 1;

                        $firstCariBalance = $cari_item['cari_balance'] - $amount_to_be_processed;

                        $update_cari_data = [
                            'cari_balance' => $cari_item['cari_balance'] - $amount_to_be_processed,
                        ];
                        $this->modelCari->update($cari_id, $update_cari_data);

                        $update_cari_data = [
                            'cari_balance' => $firstCariBalance - $lastc,
                        ];
                        $this->modelCari->update($cari_id, $update_cari_data);


                   
                      




                    }
                    else{

                    }

            


                 
                    $paraBirikur = $this->modelMoneyUnit->where("money_unit_id", $data_invoice_amounts['money_unit_id'])->first();
                    $this->modelIslem->LogOlustur(
                        session()->get('client_id'),
                        session()->get('user_id'),
                        $invoice_id,
                        'ok',
                        'odeme',
                        "Fatura Anında Oluşan Tahsilat İşlemi  <b style='color: #0FCA7A'>(" . number_format(convert_number_for_sql($new_data_form['transaction_amount']), 2, ',', '.') . " " . $paraBirikur["money_icon"] . ")</b>",
                        session()->get("user_item")["user_adsoyad"],
                        json_encode( ['invoice_id' => $invoice_id, 'odeme_id' => $is_collection_financial_movement_id,'odeme_log' => $insert_financial_movement_data]),
                        0,
                        0,
                        $invoice_id,
                        0
                    );
                    

                    
                }

                $BakiyeGuncelle = new Cari();
                $BakiyeGuncelle->bakiyeHesapla($cari_id);


                echo json_encode(['icon' => 'success', 'message' => 'Fatura başarıyla sisteme kaydedildi.', 'errRows' => $errRows, 'newdInvoiceId' => $invoice_id]);
                // return;
                // }
            } catch (\Exception $e) {
                $backtrace = $e->getTrace();
                $errorMessage = $e->getMessage();
                $errorDetails = [
                    'error_message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $backtrace
                ];
                $this->logClass->save_log(
                    'error',
                    'invoice',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                $userFriendlyMessage = "Bir hata oluştu: <br>" . $errorMessage . ". <br>Lütfen daha sonra tekrar deneyin.";

                // Hata detaylarını JSON olarak döndürüyoruz (Opsiyonel: Bu kısmı son kullanıcıya göstermek yerine log için kullanın)
                $debugDetails = json_encode($errorDetails, JSON_PRETTY_PRINT); // Geliştirici için anlaşılır detaylar

                // Basit hata mesajını JSON formatında döndür
                echo json_encode(['icon' => 'error', 'message' => $debugDetails]);
                return;
            }
        } else {
            $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
            $cari_items = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')->where('cari.user_id', session()->get('user_id'))->findAll();
            $invoice_note_items = $this->modelNote->where('user_id', session()->get('user_id'))->findAll();
            $invoice_serial_items = $this->modelInvoiceSerial->where('user_id', session()->get('user_id'))->orderBy('invoice_serial_type', 'ASC')->orderBy('invoice_serial_prefix', 'ASC')->findAll();
            $stock_items = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock.stock_id <=', 0)->join('category', 'category.category_id = stock.category_id')->join('type', 'type.type_id = stock.type_id')->join('money_unit', 'money_unit.money_unit_id = stock.sale_money_unit_id')->findAll();
            $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->orderBy('order', 'ASC')->findAll();


            $financial_account_items = $this->modelFinancialAccount->table('`financial_account`')
                ->select('financial_account_id, money_unit.money_unit_id, account_title, account_type, bank_id, money_code')
                ->join('money_unit', 'financial_account.money_unit_id = money_unit.money_unit_id')
                ->findAll();
               
                $variant_property_items = [];
                
            $data = [
                'Kurlar' => $Kurlar,
                'money_unit_items' => $money_unit_items,
                'cari_items' => $cari_items,
                'invoice_note_items' => $invoice_note_items,
                'invoice_serial_items' => $invoice_serial_items,
                'stock_items' => $stock_items,
                'financial_account_items' => $financial_account_items,
                'warehouse_items' => $warehouse_items
            ];

            return view('tportal/faturalar/yeni_3step', $data);
        }
    }

    function convert_sql($number) {
        // Virgül ile ayrılmış ondalık sayıyı noktaya çevir
        $number = str_replace(",", ".", $number);
    
        // Eğer sayı ondalıklıysa iki ondalık basamağa kadar yuvarla
        return number_format((float)$number, 2, '.', '');
    }


    public function cariHesap($cari_id)
    {
        // USD kuru: TL'yi USD'ye çevirmek için sabit bir oran kullanıyoruz
        $usdExchangeRate = 32.50;  // TL'yi USD'ye çevirme kuru
    
        // Veritabanı bağlantısı için CodeIgniter'ın database özelliğini kullanıyoruz
        $db = \Config\Database::connect($this->currentDB);
    
        // 1. ADIM: Satış faturalarını (outgoing_invoice) cari_id'ye göre çek
        $invoices = $db->table('invoice i')
            ->select('i.invoice_id, i.invoice_no, i.invoice_date, i.invoice_direction, mu.money_title, mu.money_code, mu.money_value')
            ->join('money_unit mu', 'i.money_unit_id = mu.money_unit_id')
            ->where('i.cari_id', $cari_id)
            ->where('i.invoice_direction', 'outgoing_invoice') // Sadece satış faturaları
            ->get()->getResultArray();
    
        if (empty($invoices)) {
            // Satış faturası yoksa
            return $this->response->setJSON([
                'error' => 'Satış faturası bulunamadı.'
            ]);
        }
    
        // 2. ADIM: Satış faturalarına bağlı tüm fatura satırlarını çekiyoruz
        $invoiceIds = array_column($invoices, 'invoice_id'); // Fatura ID'leri
    
        $invoiceRows = $db->table('invoice_row')
            ->select('invoice_id, stock_amount, unit_price, discount_rate, discount_price, subtotal_price, tax_id, tax_price, total_price, is_return')
            ->whereIn('invoice_id', $invoiceIds)
            ->get()->getResultArray();
    
        // KDV oranlarını elle tanımlıyoruz
        $taxMap = [
            1 => 0,    // %0 KDV
            2 => 1,    // %1 KDV
            3 => 8,    // %8 KDV
            4 => 10,   // %10 KDV
            5 => 18,   // %18 KDV
            6 => 20    // %20 KDV
        ];
    
        // Cari hesap için toplama değerleri tutmak için
        $totalUSD = 0;
        $totalTRY = 0;
    
        // 3. ADIM: Fatura ve satırları TL'den USD'ye çeviriyoruz (eğer TL ise)
        foreach ($invoices as $invoice) {
            $invoiceId = $invoice['invoice_id'];
            $currency = $invoice['money_code'];
    
            // Eğer fatura para birimi TL ise USD'ye çevir
            if ($currency == 'TRY') {
                // TL faturasını USD'ye çeviriyoruz
                $this->convertInvoiceToUSD($invoiceId, $usdExchangeRate);
            }
    
            // Cari hesapta kullanmak üzere her faturayı işliyoruz
            $relatedRows = array_filter($invoiceRows, function ($row) use ($invoiceId) {
                return $row['invoice_id'] == $invoiceId;
            });
    
            $invoiceTotalUSD = 0;  // USD cinsinden toplam
    
            foreach ($relatedRows as $row) {
                // Ara toplam: satılan miktar * birim fiyat - indirim tutarı
                $subtotal = ($row['stock_amount'] * $row['unit_price']) - $row['discount_price'];
    
                // KDV oranını bul
                $taxRate = isset($taxMap[$row['tax_id']]) ? $taxMap[$row['tax_id']] : 0;
    
                // KDV tutarını hesapla
                $taxAmount = $subtotal * ($taxRate / 100);
    
                // Genel satır toplamı: Ara toplam + KDV tutarı
                $totalPrice = $subtotal + $taxAmount;
    
                // USD toplama ekle
                $invoiceTotalUSD += $totalPrice;
            }
    
            // USD toplamını ekliyoruz
            $totalUSD += $invoiceTotalUSD;
            $totalTRY += $invoiceTotalUSD * $usdExchangeRate;
        }
    
        // 4. ADIM: Alış faturalarını (incoming_invoice) cari_id'ye göre çek
        $purchaseInvoices = $db->table('invoice i')
            ->select('i.invoice_id, i.invoice_no, i.invoice_date, i.invoice_direction, mu.money_title, mu.money_code, mu.money_value')
            ->join('money_unit mu', 'i.money_unit_id = mu.money_unit_id')
            ->where('i.cari_id', $cari_id)
            ->where('i.invoice_direction', 'incoming_invoice') // Alış faturaları
            ->get()->getResultArray();
    
        // Alış faturalarına bağlı tüm fatura satırlarını çekiyoruz
        $purchaseInvoiceIds = array_column($purchaseInvoices, 'invoice_id'); // Alış fatura ID'leri
    
        if (empty($purchaseInvoices)) {
            return $this->response->setJSON([
                'error' => 'Alış faturası bulunamadı.'
            ]);
        }
    
        $purchaseInvoiceRows = $db->table('invoice_row')
            ->select('invoice_id, stock_amount, unit_price, discount_rate, discount_price, subtotal_price, tax_id, tax_price, total_price, is_return')
            ->whereIn('invoice_id', $purchaseInvoiceIds)
            ->get()->getResultArray();
    
        // 5. ADIM: Alış faturalarını toplama ekliyoruz
        $totalPurchaseUSD = 0;
        $totalPurchaseTRY = 0;
    
        foreach ($purchaseInvoices as $invoice) {
            $invoiceId = $invoice['invoice_id'];
            $currency = $invoice['money_code'];
    
            $relatedRows = array_filter($purchaseInvoiceRows, function ($row) use ($invoiceId) {
                return $row['invoice_id'] == $invoiceId;
            });
    
            $invoiceTotalUSD = 0;
    
            foreach ($relatedRows as $row) {
                $subtotal = ($row['stock_amount'] * $row['unit_price']) - $row['discount_price'];
                $taxRate = isset($taxMap[$row['tax_id']]) ? $taxMap[$row['tax_id']] : 0;
                $taxAmount = $subtotal * ($taxRate / 100);
                $totalPrice = $subtotal + $taxAmount;
    
                // Alışları USD ve TRY cinsinden hesaplıyoruz
                $invoiceTotalUSD += $totalPrice;
            }
    
            $totalPurchaseUSD += $invoiceTotalUSD;
            $totalPurchaseTRY += $invoiceTotalUSD * $usdExchangeRate;
        }
    
        // 6. ADIM: Cari hesap bakiyesi
        $balanceUSD = $totalUSD - $totalPurchaseUSD;  // USD cinsinden bakiye
        $balanceTRY = $totalTRY - $totalPurchaseTRY;  // TRY karşılık
    
        // Sonuçları JSON olarak döndür
        $data = [
            'total_sales_usd' => number_format($totalUSD, 2, ',', '.'),    // USD satış toplamı
            'total_sales_try' => number_format($totalTRY, 2, ',', '.'),    // TRY karşılık
            'total_purchase_usd' => number_format($totalPurchaseUSD, 2, ',', '.'),  // USD alış toplamı
            'total_purchase_try' => number_format($totalPurchaseTRY, 2, ',', '.'),  // TRY karşılık
            'balance_usd' => number_format($balanceUSD, 2, ',', '.'),  // USD bakiye
            'balance_try' => number_format($balanceTRY, 2, ',', '.'),  // TRY bakiye
        ];
    
        return $this->response->setJSON($data); // JSON formatında döndür
    }
    
    // TL olan faturayı USD'ye çeviren fonksiyon
    public function convertInvoiceToUSD($invoiceId, $usdExchangeRate)
    {
        $db = \Config\Database::connect($this->currentDB);
    
        // Faturayı TL'den USD'ye çevir
        $invoice = $db->table('invoice')
            ->where('invoice_id', $invoiceId)
            ->get()
            ->getRowArray();
    
        $grandTotalUSD = $invoice['grand_total'] / $usdExchangeRate;
        $grandTotalTRY = $grandTotalUSD * $usdExchangeRate;
    
        $db->table('invoice')
            ->where('invoice_id', $invoiceId)
            ->update([
                'money_unit_id' => 1,  // USD
                'grand_total' => $grandTotalUSD,
                'grand_total_try' => $grandTotalTRY
            ]);
    
        // Fatura satırlarını USD'ye çevir
        $invoiceRows = $db->table('invoice_row')
            ->where('invoice_id', $invoiceId)
            ->get()
            ->getResultArray();
    
        foreach ($invoiceRows as $row) {
            $subtotalUSD = $row['subtotal_price'] / $usdExchangeRate;
            $subtotalTRY = $subtotalUSD * $usdExchangeRate;
    
            $db->table('invoice_row')
                ->where('invoice_row_id', $row['invoice_row_id'])
                ->update([
                    'subtotal_price' => $subtotalUSD,
                    'subtotal_price_try' => $subtotalTRY
                ]);
        }
    }


















    public function GunlukProformaFaturaBildirim()
    {
        // Bugünün tarihini al
        $bugun = date("Y-m-d");
        
        // Saat 17:00'ı bugünün tarihi ile birleştir
        $saat17 = $bugun . ' 17:00:00';
        
        // Bugün oluşturulmuş ve saat 17:00'a kadar imzalanmamış faturaları getir
        $tumFaturalar = $this->modelInvoice
            ->where("DATE(created_at)", $bugun)
            ->where("invoice_direction", "outgoing_invoice")
            ->where("created_at <=", $saat17)
            ->where("(tiko_id = 0 OR tiko_id IS NULL)") // İmzalanmamış faturalar (tiko_id = 0 veya NULL)
            ->findAll();

        $response = [
            'success' => true,
            'message' => 'Günlük proforma fatura bildirimi başarıyla alındı',
            'data' => [
                'tarih' => $bugun,
                'saat_siniri' => '17:00',
                'toplam_fatura_sayisi' => count($tumFaturalar),
                'faturalar' => $tumFaturalar
            ]
        ];
        
        return $this->response->setJSON($response);
    }
}

