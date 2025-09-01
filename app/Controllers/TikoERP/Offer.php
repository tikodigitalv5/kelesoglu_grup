<?php

namespace App\Controllers\TikoERP;
use CodeIgniter\Database\Config;

use App\Controllers\BaseController;

use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;
use \Hermawan\DataTables\DataTable;
use function PHPUnit\Framework\returnSelf;

/**
 * @property IncomingRequest $request
 */


class Offer extends BaseController
{
    private $DatabaseConfig;
    private $currentDB;

    private $modelCari;
    private $modelMoneyUnit;
    private $modelFinancialMovement;
    private $modelAddress;
    private $modelStock;
    private $modelOffer;
    private $modelOfferRow;
    private $modelNote;
    private $modelInvoice;

    private $logClass;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
        $this->modelFinancialMovement = model($TikoERPModelPath . '\FinancialMovementModel', true, $db_connection);
        $this->modelMoneyUnit = model($TikoERPModelPath . '\MoneyUnitModel', true, $db_connection);
        $this->modelAddress = model($TikoERPModelPath . '\AddressModel', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath . '\StockModel', true, $db_connection);
        $this->modelOffer = model($TikoERPModelPath . '\OfferModel', true, $db_connection);
        $this->modelOfferRow = model($TikoERPModelPath . '\OfferRowModel', true, $db_connection);
        $this->modelNote = model($TikoERPModelPath . '\NoteModel', true, $db_connection);
        $this->modelInvoice = model($TikoERPModelPath . '\InvoiceModel', true, $db_connection);

        $this->logClass = new Log();

        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
    }

    public function list($offer_status = 'all')
    {

        $offer_model = $this->modelOffer->join('money_unit', 'money_unit.money_unit_id = offer.money_unit_id')
            ->where('offer.user_id', session()->get('user_id'))
            ->orderBy('offer.offer_date','DESC');

            $cariler = $this->modelCari->findAll();

        if ($offer_status == 'all') {
            $page_title = "Tüm Teklifler";
            $offer_items = "";
        } else if ($offer_status == 'open') {
            $page_title = "Açık Teklifler";
            $offer_items = "";
        } else if ($offer_status == 'closed') {
            $page_title = "Kapalı Teklifler";
            $offer_items = "";
        } else {
            return redirect()->back();
        }

    
        $data = [
            'page_title' => $page_title,
            'cariler' => $cariler,
            'offer_items' => $offer_items,
            'offer_items_count' => 0,
        ];

        return view('tportal/teklifler/index', $data);
    }

    public function quickOfferPrint($invoice_id)
    {
        $invoice_item22 = $this->modelOffer->where('offer.user_id', session()->get('user_id'))
            ->where('offer.offer_id', $invoice_id)
            ->first();

        $modelInvoice = $this->modelOffer->join('money_unit', 'money_unit.money_unit_id = offer.money_unit_id')
            ->where('offer.user_id', session()->get('user_id'))
            ->where('offer.offer_id', $invoice_id)
            ->first();

        if (!$modelInvoice) {
            return view('not-found');
        }


        $invoice_rows = $this->modelOfferRow->join('unit', 'unit.unit_id = offer_row.unit_id')
            ->join('stock', 'stock.stock_id = offer_row.stock_id')
            ->join('offer', 'offer.offer_id = offer_row.offer_id')
            ->where('offer.offer_id', $invoice_id)
            ->findAll();

        $data = [
            'offer_item' => $modelInvoice,
            'offer_rows' => $invoice_rows
        ];

        // print_r($modelInvoice);
        // return;

        return view('tportal/siparisler/quickOfferPrint', $data);
    }

    

    public function setOfferStatus() {
        $offerId = $this->request->getPost('offerId');
        $offerStatus = $this->request->getPost('offerStatus');

        $offer_update_data = [
            'offer_status' => $offerStatus,
        ];

        // print_r($offerId);
        // print_r($offerStatus);
        // return;
        
        try {
            $this->modelOffer->update($offerId, $offer_update_data);

            echo json_encode(['icon' => 'success', 'message' => 'Teklif durumu başarıyla güncellendi.', 'offerId' => $offerId]);
            return;
        } catch (\Exception $e) {
            $this->logClass->save_log(
                'error',
                'offer',
                $offerId,
                null,
                'edit',
                $e->getMessage(),
                json_encode($_POST)
            );
            echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
            return;
        }
    }

    public function detail($offer_id)
    {


      


        $offer_item = $this->modelOffer->join('money_unit', 'money_unit.money_unit_id = offer.money_unit_id')
            ->where('offer.user_id', session()->get('user_id'))
            ->where('offer.offer_id', $offer_id)
            ->orderBy('offer.offer_date')
            ->first();


           

        if (!$offer_item) {
            return view('not-found');
        }
        $faturaVarmi = $this->modelInvoice->where("offer_id", $offer_id)->first();

        $offer_rows = $this->modelOfferRow->join('stock', 'stock.stock_id = offer_row.stock_id', 'left')
        ->join('unit', 'unit.unit_id = offer_row.unit_id')
        ->join('offer', 'offer.offer_id = offer_row.offer_id')
        ->select('stock.*,unit.*,offer.*, offer_row.*, offer_row.stock_title as stok_adi')
        ->where('offer.offer_id', $offer_id)
        ->orderBy('offer_row.offer_row_id', "ASC")

        ->findAll();
    
        // Referans kullanarak döngü yapıyoruz
        foreach ($offer_rows as &$rows) {
            if ($rows["default_image"] == "uploads/default.png") {
                $ust = $this->modelStock->where("stock_id", $rows["parent_id"])->first();
                if ($ust) {
                    $rows["default_image"] = $ust["default_image"];
                }
            }
        }
    
  

        $data = [
            'faturaVarmi' => $faturaVarmi,
            'offer_item' => $offer_item,
            'offer_rows' => $offer_rows
        ];

        // print_r($offer_rows);
        // return;

        return view('tportal/teklifler/detay/detay', $data);
    }

    public function offerMovements($offer_id = null)
    {

        $offer_item = $this->modelOffer->join('money_unit', 'money_unit.money_unit_id = offer.money_unit_id')
            ->where('offer.user_id', session()->get('user_id'))
            ->where('offer.offer_id', $offer_id)
            ->orderBy('offer.offer_date')
            ->first();

        if (!$offer_item) {
            return view('not-found');
        }

        $data = [
            'offer_item' => $offer_item,
        ];

        return view('tportal/siparisler/detay/hareketler',$data);
    }

    public function create()
    {
        $Kurlar = $this->modelMoneyUnit->findAll();

        $transaction_prefix = "TKLF";
        $errRows = [];
        if ($this->request->getMethod('true') == 'POST') {

            try {
                $data_form = $this->request->getPost('data_form');
                $data_offer_rows = $this->request->getPost('data_offer_rows');
                $data_offer_amounts = $this->request->getPost('data_offer_amounts');

              

                foreach ($data_form as $data) {
                    $key = $data['name'];
                    $value = $data['value'];
                    $new_data_form[$key] = $value;
                }

                // print_r($new_data_form);
                // print_r($data_offer_rows);
                // print_r($data_offer_amounts);
                // return;

                $phone = isset($new_data_form['cari_phone']) ? str_replace(array('(', ')', ' '), '', $new_data_form['cari_phone']) : null;
                $phoneNumber = $new_data_form['cari_phone'] ? $new_data_form['area_code'] . " " . $phone : null;

                $offer_date = $new_data_form['offer_date'];
                $offer_time = $new_data_form['offer_time'];

                $offer_datetime = convert_datetime_for_sql_time($offer_date, $offer_time);

                $transaction_amount = isset($data_offer_amounts['amount_to_be_paid']) ? convert_number_for_sql($data_offer_amounts['amount_to_be_paid']) : convert_number_for_sql($data_offer_amounts['amount_to_be_paid_try']);

                $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.identification_number', $new_data_form['identification_number'])->first();

                if ((isset($new_data_form['is_customer_save']) && $new_data_form['is_customer_save'] == 'on') || $cari_item) {
                    if (isset($new_data_form['is_export_customer']) && $new_data_form['is_export_customer'] == 'on') {
                        $is_export_customer = 1;
                    } else {
                        $is_export_customer = 0;
                    }
                    $cari_data = [
                        'user_id' => session()->get('user_id'),
                        'money_unit_id' => $data_offer_amounts['money_unit_id'],
                        'identification_number' => $new_data_form['identification_number'],
                        'tax_administration' => $new_data_form['tax_administration'] != '' ? $new_data_form['tax_administration'] : null,
                        'invoice_title' => $new_data_form['invoice_title'] == '' ? $new_data_form['name'].' '.$new_data_form['surname'] : $new_data_form['invoice_title'],
                        'name' => $new_data_form['name'],
                        'surname' => $new_data_form['surname'],
                        'obligation' => $new_data_form['obligation'] != '' ? $new_data_form['obligation'] : null,
                        'company_type' => $new_data_form['company_type'] != '' ? $new_data_form['company_type'] : null ,
                        'cari_phone' => $phoneNumber,
                        'cari_email' => $new_data_form['cari_email'] != '' ? $new_data_form['cari_email'] : null,
                        'is_customer' => 1,
                        'is_supplier' => 0,
                        'is_export_customer' => $is_export_customer,
                    ];

                    $address_data = [
                        'user_id' => session()->get('user_id'),
                        'address_title' => 'Fatura Adresi',
                        'address_country' => $new_data_form['address_country'],
                        'address_city' => $new_data_form['address_city_name'] != '' ? $new_data_form['address_city_name'] : null,
                        'address_city_plate' => isset($new_data_form['address_city']) ? $new_data_form['address_city'] : null,
                        'address_district' => isset($new_data_form['address_district']) ? $new_data_form['address_district'] : null,
                        'zip_code' => $new_data_form['zip_code'] != '' ? $new_data_form['zip_code'] : null,
                        'address' => $new_data_form['address'],
                        'address_phone' => $phoneNumber,
                        'address_email' => $new_data_form['cari_email'] != '' ? $new_data_form['cari_email'] : null,
                    ];

                    if (!$cari_item) {
                        $cari_data['$cari_balance'] =  $transaction_amount;
                        $this->modelCari->insert($cari_data);
                        $cari_id = $this->modelCari->getInsertID();
                        $address_data['cari_id'] = $cari_id;
                        $address_data['status'] = 'active';
                        $address_data['default'] = 'true';
                        $this->modelAddress->insert($address_data);
                    } else {
                        $cari_id = $cari_item['cari_id'];
                        $cari_address_id = $cari_item['address_id'];
                        $cari_balance = $cari_item['cari_balance'] + $transaction_amount;
                        $cari_data['cari_balance'] = $cari_balance;
                        if(session()->get('user_id') != 5){
                            $this->modelCari->update($cari_id, $cari_data);
                          }

                        $address_data['cari_id'] = $cari_id;
                        $this->modelAddress->update($cari_address_id, $address_data);
                    }
                } else {
                    $cari_id = $cari_item['cari_id'];
                }

                if (isset($new_data_form['chk_musteri_bakiye_ekle']) && $new_data_form['chk_musteri_bakiye_ekle'] == 'on') {
                    $offer_note_id = $new_data_form['invoiceNotesId'];
                    $offer_note = $new_data_form['txt_fatura_not'] . " - " . $cari_balance;
                } else {
                    $offer_note_id = $new_data_form['invoiceNotesId'];
                    $offer_note = $new_data_form['txt_fatura_not'];
                }

                if (isset($new_data_form['chk_not_kaydet']) && $new_data_form['chk_not_kaydet'] == 'on') {
                    $note_item = $this->modelNote->where('note_id', $new_data_form['invoiceNotesId'])->where('user_id', session()->get('user_id'))->first();

                    if (!$note_item) {
                        $insert_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_type' => 'offer',
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $this->modelNote->insert($insert_invoice_note_data);
                        $offer_note_id = $this->modelNote->getInsertID();
                    } else {
                        $update_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_id' => $new_data_form['invoiceNotesId'],
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $offer_note_id = $new_data_form['invoiceNotesId'];
                        $this->modelNote->update($new_data_form['invoiceNotesId'], $update_invoice_note_data);
                    }
                }

                ## SİPARİŞLER İÇİN FİNANSAL HAREKET VEYA STOK HAREKET İŞLENMEYECEK. SİPARİŞ FATURALAŞTIĞI ZAMAN İŞLENECEK.
                // $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                // if ($last_transaction) {
                //     $transaction_counter = $last_transaction['transaction_counter'] + 1;
                // } else {
                //     $transaction_counter = 1;
                // }
                // $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                // $insert_financial_movement_data = [
                //     'user_id' => session()->get('user_id'),
                //     'financial_account_id' => null,
                //     'cari_id' => $cari_id,
                //     'money_unit_id' => $data_offer_amounts['money_unit_id'],
                //     'transaction_number' => $transaction_number,
                //     'transaction_direction' => 'entry',
                //     'transaction_type' => "offer",
                //     'transaction_tool' => 'not_payroll',
                //     'transaction_title' => 'sipariş oluşturdan oluşan otomatik hareket',
                //     'transaction_description' => $offer_note,
                //     'transaction_amount' => convert_number_for_sql($data_offer_amounts['amount_to_be_paid']),
                //     'transaction_real_amount' => convert_number_for_sql($data_offer_amounts['amount_to_be_paid']),
                //     'transaction_date' => $offer_datetime,
                //     'transaction_prefix' => $transaction_prefix,
                //     'transaction_counter' => $transaction_counter
                // ];
                // $this->modelFinancialMovement->insert($insert_financial_movement_data);

                //8 rakamlı sipariş kodu
                $create_offer_code = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);

                if(!isset($new_data_form['is_validity'])){
                    $new_data_form['is_validity'] = 0;
                }

                $d_date = $new_data_form['validity_date'];
                $insert_offer_data = [
                    'user_id' => session()->get('user_id'),
                    'client_id' => session()->get('client_id'),
                    'money_unit_id' => $data_offer_amounts['money_unit_id'],
                    'offer_no' => $transaction_prefix . $create_offer_code,
                    'offer_date' => $offer_datetime,

                    'offer_note_id' => $new_data_form['invoiceNotesId'] == '' ? $offer_note_id : $new_data_form['invoiceNotesId'],
                    'offer_note' => $offer_note,

                    'is_validity' => $new_data_form['is_validity'] == 'on' ? 1 : 0,
                    'validity_date' => convert_datetime_for_sql_time($d_date, $offer_time),

                    'currency_amount' => $data_offer_amounts['currency_amount'],

                    'stock_total' => convert_number_for_sql($data_offer_amounts['stock_total']),
                    'stock_total_try' => convert_number_for_sql($data_offer_amounts['stock_total_try']),

                    'discount_total' => convert_number_for_sql($data_offer_amounts['discount_total']),
                    'discount_total_try' => convert_number_for_sql($data_offer_amounts['discount_total_try']),

                    'tax_rate_1_amount' => convert_number_for_sql($data_offer_amounts['tax_rate_1_amount']),
                    'tax_rate_1_amount_try' => convert_number_for_sql($data_offer_amounts['tax_rate_1_amount_try']),
                    'tax_rate_10_amount' => convert_number_for_sql($data_offer_amounts['tax_rate_10_amount']),
                    'tax_rate_10_amount_try' => convert_number_for_sql($data_offer_amounts['tax_rate_10_amount_try']),
                    'tax_rate_20_amount' => convert_number_for_sql($data_offer_amounts['tax_rate_20_amount']),
                    'tax_rate_20_amount_try' => convert_number_for_sql($data_offer_amounts['tax_rate_20_amount_try']),

                    'sub_total' => convert_number_for_sql($data_offer_amounts['sub_total']),
                    'sub_total_try' => convert_number_for_sql($data_offer_amounts['sub_total_try']),
                    'sub_total_0' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax0']),
                    'sub_total_0_try' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax0_try']),
                    'sub_total_1' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax1']),
                    'sub_total_1_try' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax1_try']),
                    'sub_total_10' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax10']),
                    'sub_total_10_try' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax10_try']),
                    'sub_total_20' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax20']),
                    'sub_total_20_try' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax20_try']),

                    'grand_total' => convert_number_for_sql($data_offer_amounts['grand_total']),
                    'grand_total_try' => convert_number_for_sql($data_offer_amounts['grand_total_try']),

                    'amount_to_be_paid' => convert_number_for_sql($data_offer_amounts['amount_to_be_paid']),
                    'amount_to_be_paid_try' => convert_number_for_sql($data_offer_amounts['amount_to_be_paid_try']),

                    'amount_to_be_paid_text' => $data_offer_amounts['amount_to_be_paid_text'],

                    'cari_identification_number' => $new_data_form['identification_number'],
                    'cari_tax_administration' => $new_data_form['tax_administration'],

                    'cari_invoice_title' => $new_data_form['invoice_title'] == '' ? $new_data_form['name'] . " " . $new_data_form['surname'] : $new_data_form['invoice_title'],
                    'cari_name' => $new_data_form['name'],
                    'cari_id' => $new_data_form['cari_id'],
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

                    'offer_status' => "new",
                    'failed_reason' => ""
                ];
                // print_r($insert_offer_data);
                // return;
                $this->modelOffer->insert($insert_offer_data);
                $offer_id = $this->modelOffer->getInsertID();

                foreach ($data_offer_rows as $data_offer_row) {
                    if (isset($data_offer_row['isDeleted'])) {
                        continue;
                    } else {

                        $insert_offer_row_data = [
                            'user_id' => session()->get('user_id'),
                            'offer_id' => $offer_id,
                            'stock_id' => $data_offer_row['stock_id'],
                            'stock_title' => $data_offer_row['stock_title'],
                            'stock_amount' => $data_offer_row['stock_amount'],

                            'unit_id' => $data_offer_row['unit_id'],
                            'unit_price' => $data_offer_row['unit_price'],

                            'discount_rate' => $data_offer_row['discount_rate'],
                            'discount_price' => $data_offer_row['discount_price'],

                            'subtotal_price' => $data_offer_row['subtotal_price'],

                            'tax_id' => $data_offer_row['tax_id'],
                            'tax_price' => $data_offer_row['tax_price'],

                            'total_price' => $data_offer_row['total_price'],
                        ];
                        $this->modelOfferRow->insert($insert_offer_row_data);
                    }
                }

                echo json_encode(['icon' => 'success', 'message' => 'Sipariş başarıyla sisteme kaydedildi.', 'errRows' => $errRows, 'newOfferId' => $offer_id]);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'offer',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
            $cari_items = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')->where('cari.user_id', session()->get('user_id'))->findAll();
            $invoice_note_items = $this->modelNote->where('user_id', session()->get('user_id'))->findAll();
            $stock_items = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock.stock_id <=', 0)->join('category', 'category.category_id = stock.category_id')->join('type', 'type.type_id = stock.type_id')->join('money_unit', 'money_unit.money_unit_id = stock.sale_money_unit_id')->findAll();

            $data = [
                'Kurlar' => $Kurlar,
                'money_unit_items' => $money_unit_items,
                'cari_items' => $cari_items,
                'invoice_note_items' => $invoice_note_items,
                'stock_items' => $stock_items
            ];

            return view('tportal/teklifler/yeni', $data);
        }
    }


    public function getOfferList($order_status = 'all')
{

    $builder = $this->modelOffer
   
    ->where('offer.user_id', session()->get('user_id'))
    ->where('offer.deleted_at', null)
    ->orderBy('offer.offer_date', 'DESC');


    // Tarih aralığı filtrelemesi
    $start_date = $this->request->getGet('start_date');
    $end_date = $this->request->getGet('end_date');

    if (!empty($start_date) && !empty($end_date)) {
        // Tarih formatlarını dönüştür (dd/mm/yyyy -> yyyy-mm-dd)
        $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $start_date)));
        $end_date = date('Y-m-d', strtotime(str_replace('/', '-', $end_date)));

        // Veritabanındaki 'offer_date' sütununu tarih aralığına göre filtreleme
        $builder->where('DATE(offer.offer_date) >=', $start_date);
        $builder->where('DATE(offer.offer_date) <=', $end_date);
    }

    // Durum filtresi
    $status = $this->request->getGet('status');
    if (!empty($status) && $status != '0') {
        $builder->where('offer.offer_status', $status);
    }

    // Müşteri filtresi
    $musteri = $this->request->getGet('musteri');
    if (!empty($musteri) && $musteri != '0') {
        $builder->where('offer.cari_id', $musteri);
    }

    // Teklif durumu filtresi
    if ($order_status == 'all') {
        $page_title = "Tüm Teklifler";
    } else if ($order_status == 'open') {
        $page_title = "Açık Teklifler";
        $builder->groupStart()
            ->where('offer.offer_status', 'new')
            ->orWhere('offer.offer_status', 'pending')
            ->groupEnd();
    } else if ($order_status == 'closed') {
        $page_title = "Kapalı Teklifler";
        $builder->groupStart()
            ->where('offer.offer_status', 'failed')
            ->orWhere('offer.offer_status', 'success')
            ->groupEnd();
    } else {
        return redirect()->back();
    }



    // JSON olarak dönen veriyi kontrol et
    $data = DataTable::of($builder)
        ->setSearchableColumns(['offer_date', 'offer_no', 'cari_invoice_title'])
        ->add('money_code', function($row){ 
            $modelrow = $this->modelMoneyUnit->where("money_unit_id", $row->money_unit_id)->first();
            if($modelrow){
                $text =$modelrow["money_icon"];
            } else {
                $text = '';
            }
            return $text;
        }, 'last')
        ->toJson(true);

    return $data;
}
    

    public function edit($offer_id = null)
    {
        
        $transaction_prefix = "PRF";
        $errRows = [];
        $offer_item = $this->modelOffer->join('money_unit', 'money_unit.money_unit_id = offer.money_unit_id')
        ->where('offer.user_id', session()->get('user_id'))
        ->where('offer.offer_id', $offer_id)
        ->first();

    if(empty($offer_item["cari_id"])){
        $cari_item = $this->modelCari->where("identification_number", $offer_item["cari_identification_number"])->first();
    
        if ($cari_item) {
            $offer_item["cari_id"] = $cari_item["cari_id"]; // Hatalı: == | Doğru: =
        }else{
            $offer_item["cari_id"] = 0; // Hatalı: == | Doğru: =
        }
    }
   
    
   
        if ($this->request->getMethod('true') == 'POST') {
            if (!$offer_item) {
                echo json_encode(['icon' => 'error', 'message' => 'Sipariş bulunamadı.']);
                return;
            }

           
            try {
                $data_form = $this->request->getPost('data_form');
                $data_offer_rows = $this->request->getPost('data_offer_rows');
                $data_offer_amounts = $this->request->getPost('data_offer_amounts');

                foreach ($data_form as $data) {
                    $key = $data['name'];
                    $value = $data['value'];
                    $new_data_form[$key] = $value;
                }

                // print_r($new_data_form);
                // print_r($data_offer_rows);
                // print_r($data_offer_amounts);
                // return;

                $phone = isset($new_data_form['cari_phone']) ? str_replace(array('(', ')', ' '), '', $new_data_form['cari_phone']) : null;
                $phoneNumber = $new_data_form['cari_phone'] ? $new_data_form['area_code'] . " " . $phone : null;

                $offer_date = $new_data_form['offer_date'];
                $offer_time = $new_data_form['offer_time'];

                $offer_datetime = convert_datetime_for_sql_time($offer_date, $offer_time);

                $transaction_amount = isset($data_offer_amounts['amount_to_be_paid']) ? convert_number_for_sql($data_offer_amounts['amount_to_be_paid']) : convert_number_for_sql($data_offer_amounts['amount_to_be_paid_try']);

                $cari_balance = null;
                $cari_id = null;
                $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.identification_number', $new_data_form['identification_number'])->first();

                if ((isset($new_data_form['is_customer_save']) && $new_data_form['is_customer_save'] == 'on') || !$cari_item) {

                    if (isset($new_data_form['is_export_customer']) && $new_data_form['is_export_customer'] == 'on') {
                        $is_export_customer = 1;
                    } else {
                        $is_export_customer = 0;
                    }
                    $cari_data = [
                        'user_id' => session()->get('user_id'),
                        'money_unit_id' => $data_offer_amounts['money_unit_id'],
                        'identification_number' => $new_data_form['identification_number'],
                        'tax_administration' => $new_data_form['tax_administration'],
                        'invoice_title' => $new_data_form['invoice_title'],
                        'name' => $new_data_form['name'],
                        'surname' => $new_data_form['surname'],
                        'obligation' => $new_data_form['obligation'],
                        'company_type' => $new_data_form['company_type'],
                        'cari_phone' => $phoneNumber,
                        'cari_email' => $new_data_form['cari_email'],
                        'is_customer' => 1,
                        'is_supplier' => 0,
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

                    if (!$cari_item) {
                        $cari_data['$cari_balance'] = $transaction_amount;
                        $this->modelCari->insert($cari_data);
                        $cari_id = $this->modelCari->getInsertID();
                        $address_data['cari_id'] = $cari_id;
                        $address_data['status'] = 'active';
                        $address_data['default'] = 'true';
                        $this->modelAddress->insert($address_data);
                    } else {
                        $cari_id = $cari_item['cari_id'];
                        $cari_address_id = $cari_item['address_id'];
                        $cari_balance = $cari_item['cari_balance'] + $transaction_amount;
                        $cari_data['cari_balance'] = $cari_balance;
                        if(session()->get('user_id') != 5){
                          $this->modelCari->update($cari_id, $cari_data);
                        }

                        $address_data['cari_id'] = $cari_id;
                        $this->modelAddress->update($cari_address_id, $address_data);
                    }
                } else {
                    $cari_id = $cari_item['cari_id'];
                }

                if (isset($new_data_form['chk_musteri_bakiye_ekle']) && $new_data_form['chk_musteri_bakiye_ekle'] == 'on') {
                    $offer_note_id = $new_data_form['invoiceNotesId'];
                    $offer_note = $new_data_form['txt_fatura_not'] . " - " . $cari_balance;
                } else {
                    $offer_note_id = $new_data_form['invoiceNotesId'];
                    $offer_note = $new_data_form['txt_fatura_not'];
                }

                if (isset($new_data_form['chk_not_kaydet']) && $new_data_form['chk_not_kaydet'] == 'on') {
                    $note_item = $this->modelNote->where('note_id', $new_data_form['invoiceNotesId'])->where('user_id', session()->get('user_id'))->first();

                    if (!$note_item) {
                        $insert_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_type' => 'offer',
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $this->modelNote->insert($insert_invoice_note_data);
                        $offer_note_id = $this->modelNote->getInsertID();
                    } else {
                        $insert_invoice_note_data = [
                            'user_id' => session()->get('user_id'),
                            'note_id' => $new_data_form['invoiceNotesId'],
                            'note_title' => $new_data_form['txt_fatura_not_baslik'],
                            'note' => $new_data_form['txt_fatura_not']
                        ];
                        $offer_note_id = $new_data_form['invoiceNotesId'];
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
                //     'money_unit_id' => $data_offer_amounts['money_unit_id'],
                //     'transaction_number' => $transaction_number,
                //     'transaction_direction' => 'entry',
                //     'transaction_type' => $new_data_form['ftr_turu'],
                //     'transaction_tool' => 'not_payroll',
                //     'transaction_title' => 'PRF00000000012',
                //     'transaction_description' => $offer_note,
                //     'transaction_amount' => convert_number_for_sql($data_offer_amounts['amount_to_be_paid_try']),
                //     'transaction_real_amount' => convert_number_for_sql($data_offer_amounts['amount_to_be_paid_try']),
                //     'transaction_date' => $offer_datetime,
                //     'transaction_prefix' => $transaction_prefix,
                //     'transaction_counter' => $transaction_counter
                // ];
                // $this->modelFinancialMovement->insert($insert_financial_movement_data);

                $d_date = $new_data_form['validity_date'];
                $update_offer_data = [
                    'user_id' => session()->get('user_id'),
                    'money_unit_id' => $data_offer_amounts['money_unit_id'],
                    'offer_date' => $offer_datetime,

                    'offer_note_id' => $offer_note_id,
                    'offer_note' => $offer_note,
                    
                    'is_validity' => $new_data_form['is_validity'] == 'on' ? 1 : 0,
                    'validity_date' => convert_datetime_for_sql_time($d_date, $offer_time),

                    'currency_amount' => $data_offer_amounts['currency_amount'],

                    'stock_total' => convert_number_for_sql($data_offer_amounts['stock_total']),
                    'stock_total_try' => convert_number_for_sql($data_offer_amounts['stock_total_try']),

                    'discount_total' => convert_number_for_sql($data_offer_amounts['discount_total']),
                    'discount_total_try' => convert_number_for_sql($data_offer_amounts['discount_total_try']),

                    'tax_rate_1_amount' => convert_number_for_sql($data_offer_amounts['tax_rate_1_amount']),
                    'tax_rate_1_amount_try' => convert_number_for_sql($data_offer_amounts['tax_rate_1_amount_try']),
                    'tax_rate_10_amount' => convert_number_for_sql($data_offer_amounts['tax_rate_10_amount']),
                    'tax_rate_10_amount_try' => convert_number_for_sql($data_offer_amounts['tax_rate_10_amount_try']),
                    'tax_rate_20_amount' => convert_number_for_sql($data_offer_amounts['tax_rate_20_amount']),
                    'tax_rate_20_amount_try' => convert_number_for_sql($data_offer_amounts['tax_rate_20_amount_try']),

                    'sub_total' => convert_number_for_sql($data_offer_amounts['sub_total']),
                    'sub_total_try' => convert_number_for_sql($data_offer_amounts['sub_total_try']),
                    'sub_total_0' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax0']),
                    'sub_total_0_try' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax0_try']),
                    'sub_total_1' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax1']),
                    'sub_total_1_try' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax1_try']),
                    'sub_total_10' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax10']),
                    'sub_total_10_try' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax10_try']),
                    'sub_total_20' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax20']),
                    'sub_total_20_try' => convert_number_for_sql($data_offer_amounts['sub_total_all_tax20_try']),

                    'grand_total' => convert_number_for_sql($data_offer_amounts['grand_total']),
                    'grand_total_try' => convert_number_for_sql($data_offer_amounts['grand_total_try']),

                    'amount_to_be_paid' => convert_number_for_sql($data_offer_amounts['amount_to_be_paid']),
                    'amount_to_be_paid_try' => convert_number_for_sql($data_offer_amounts['amount_to_be_paid_try']),

                    'cari_identification_number' => $new_data_form['identification_number'],
                    'cari_tax_administration' => $new_data_form['tax_administration'],

                    'cari_invoice_title' => $new_data_form['invoice_title'] == '' ? $new_data_form['name'] . " " . $new_data_form['surname'] : $new_data_form['invoice_title'],
                    'cari_name' => $new_data_form['name'],
                    'cari_surname' => $new_data_form['surname'],
                    'cari_obligation' => $new_data_form['obligation'],
                    'cari_company_type' => $new_data_form['company_type'],
                    'cari_phone' => $phoneNumber,
                    'cari_email' => $new_data_form['cari_email'],
                    'cari_id' => $new_data_form['cari_id'],
                    'address_country' => $new_data_form['address_country'],

                    'address_city' => $new_data_form['address_city_name'],
                    'address_city_plate' => isset($new_data_form['address_city']) ? $new_data_form['address_city'] : "",
                    'address_district' => isset($new_data_form['address_district']) ? $new_data_form['address_district'] : "",
                    'address_zip_code' => $new_data_form['zip_code'],
                    'address' => $new_data_form['address'],

                    'offer_status' => $new_data_form['offer_status'],
                    'failed_reason' => ""
                ];


                $this->modelOffer->update($offer_id, $update_offer_data);

                // print_r($data_offer_rows);
                // return;

                foreach ($data_offer_rows as $data_offer_row) {

              

                    $isDeleted = (isset($data_offer_row["isDeleted"])) ? $isDeleted = $data_offer_row["isDeleted"] : '';
                    $offer_row_id = $data_offer_row["offer_row_id"];
                    $satirSay = $this->modelOfferRow->where('user_id', session()->get('user_id'))->where('offer_id', $offer_id)->countAllResults();
                
                    // Silme işlemi kontrolü
                    if (isset($data_offer_row['offer_row_id']) && isset($data_offer_row['isDeletedOffer'])) {
                        // Eğer bu son satır ise silme
                        if($satirSay <= 1) {
                           
                            continue;
                        } else {
                         
                            $this->modelOfferRow->where('user_id', session()->get('user_id'))
                                               ->where('offer_row_id', $offer_row_id)
                                               ->delete();
                        }
                        continue;
                    }
                
                    // Diğer işlemler aynı kalacak
                    $offer_row_data = [
                        'user_id' => session()->get('user_id'),
                        'offer_id' => $offer_id,
                        'stock_id' => $data_offer_row['stock_id'],
                        'stock_title' => $data_offer_row['stock_title'],
                        'stock_amount' => $data_offer_row['stock_amount'],
                        'unit_id' => $data_offer_row['unit_id'],
                        'unit_price' => $data_offer_row['unit_price'],
                        'discount_rate' => $data_offer_row['discount_rate'],
                        'discount_price' => $data_offer_row['discount_price'],
                        'subtotal_price' => $data_offer_row['subtotal_price'],
                        'tax_id' => $data_offer_row['tax_id'],
                        'tax_price' => $data_offer_row['tax_price'],
                        'total_price' => $data_offer_row['total_price'],
                    ];
                
                    if ($offer_row_id == 0) {
                        $this->modelOfferRow->insert($offer_row_data);
                    } else {
                        $this->modelOfferRow->update($offer_row_id, $offer_row_data);
                    }
                }

                echo json_encode(['icon' => 'success', 'message' => 'Teklif başarıyla güncellendi.', 'errRows' => 0, 'offerId' => $offer_id]);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'offer',
                    $offer_id,
                    null,
                    'edit',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            if (!$offer_item) {
                return view('not-found');
            }

            $offer_rows = $this->modelOfferRow->where('user_id', session()->get('user_id'))->where('offer_id', $offer_id)->findAll();
            $Kurlar = $this->modelMoneyUnit->findAll();

            $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
            $cari_items = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')->where('cari.user_id', session()->get('user_id'))->findAll();
            $invoice_note_items = $this->modelNote->where('user_id', session()->get('user_id'))->findAll();
            $stock_items = $this->modelStock->where('stock.user_id', session()->get('user_id'))->where('stock.stock_id <=', 0)->join('category', 'category.category_id = stock.category_id')->join('type', 'type.type_id = stock.type_id')->join('money_unit', 'money_unit.money_unit_id = stock.sale_money_unit_id')->findAll();

            $data = [
                'Kurlar' => $Kurlar,
                'offer_item' => $offer_item,
                'offer_rows' => $offer_rows,
                'money_unit_items' => $money_unit_items,
                'cari_items' => $cari_items,
                'invoice_note_items' => $invoice_note_items,
                'stock_items' => $stock_items
            ];

            return view('tportal/teklifler/detay/duzenle', $data);
        }
    }

    public function delete($offer_id = null)
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $offer_item = $this->modelOffer->where('user_id', session()->get('user_id'))->where('offer_id', $offer_id)->first();

                if (!$offer_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen teklif bulunamadı.']);
                    return;
                }

                $this->modelOffer->delete($offer_item['offer_id']);

                echo json_encode(['icon' => 'success', 'message' => 'Teklif başarıyla silindi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'offer',
                    $offer_id,
                    null,
                    'delete',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }


    public function teklifYazdir($invoice_id)
    {
        

        

        $invoice_item22 = $this->modelOffer->where('offer.user_id', session()->get('user_id'))
            ->where('offer.offer_id', $invoice_id)
            ->first();

        $modelInvoice = $this->modelOffer
        ->join('money_unit', 'money_unit.money_unit_id = offer.money_unit_id')
            ->where('offer.user_id', session()->get('user_id'))
            ->where('offer.offer_id', $invoice_id)
            ->first();
            $db_connect = \Config\Database::connect('mainDB');  

            $teklif_hazirlayan = $db_connect->table("user")->where("client_id", $modelInvoice["client_id"])->get()->getResultArray()[0];

        if (!$modelInvoice) {
            return view('not-found');
        }


        $invoice_rows = $this->modelOfferRow->join('stock', 'stock.stock_id = offer_row.stock_id', 'left')
        ->join('unit', 'unit.unit_id = offer_row.unit_id')
        ->join('offer', 'offer.offer_id = offer_row.offer_id')
        ->select('stock.*,unit.*,offer.*, offer_row.*, offer_row.stock_title as stok_adi')
        ->where('offer.offer_id', $invoice_id)
        ->orderBy('offer_row.offer_row_id', "ASC")

        ->findAll();
    
          // Referans kullanarak döngü yapıyoruz
          foreach ($invoice_rows as &$rows) {
            if ($rows["default_image"] == "uploads/default.png") {
                $ust = $this->modelStock->where("stock_id", $rows["parent_id"])->first();
                if ($ust) {
                    $rows["default_image"] = $ust["default_image"];
                }
            }
        }
          

   

        // Verileri görünüm için hazırlayın
        $data = [
            'teklif_hazirlayan' => $teklif_hazirlayan,
            'order' => $modelInvoice,
            'order_rows' => $invoice_rows,
        ];

    

        return view('tportal/teklifler/fatura', $data);
    }



}
