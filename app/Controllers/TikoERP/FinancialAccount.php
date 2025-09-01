<?php

namespace App\Controllers\TikoERP;
use App\Controllers\BaseController;
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoERP\OperationModel;

/**
 * @property IncomingRequest $request 
 */


class FinancialAccount extends BaseController
{
    private $DatabaseConfig;
    private $currentDB;
    
    private $modelFinancialAccount;
    private $modelFinancialMovement;
    private $modelMoneyUnit;
    private $modelPayroll;
    private $modelCari;
    private $logClass;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelFinancialAccount = model($TikoERPModelPath . '\FinancialAccountModel', true, $db_connection);
        $this->modelFinancialMovement = model($TikoERPModelPath . '\FinancialMovementModel', true, $db_connection);
        $this->modelMoneyUnit = model($TikoERPModelPath . '\MoneyUnitModel', true, $db_connection);
        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
        $this->modelPayroll = model($TikoERPModelPath . '\PayrollModel', true, $db_connection);


        $this->logClass = new Log();

        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
        helper('Helpers\formatter_helper');
        helper('Helpers\stock_func_helper');
        
    }

    public function list($account_type = 'all')
    {

        $modelFinancialAccount = $this->modelFinancialAccount->where('financial_account.user_id', session()->get('user_id'))->join('money_unit', 'money_unit.money_unit_id = financial_account.money_unit_id');
        if ($account_type == 'all') {
            $financial_account_items = $modelFinancialAccount->findAll();
        } elseif ($account_type == 'vault') {
            $financial_account_items = $modelFinancialAccount->where('financial_account.account_type', 'vault')->findAll();
        } elseif ($account_type == 'bank') {
            $financial_account_items = $modelFinancialAccount->where('financial_account.account_type', 'bank')->findAll();
        } elseif ($account_type == 'pos') {
            $financial_account_items = $modelFinancialAccount->where('financial_account.account_type', 'pos')->findAll();
        } elseif ($account_type == 'credit_card') {
            $financial_account_items = $modelFinancialAccount->where('financial_account.account_type', 'credit_card')->findAll();
        } elseif ($account_type == 'check_bill') {
            $financial_account_items = $this->modelPayroll->where('user_id', session()->get('user_id'))->findAll();
            $data = [
                'financial_account_items' => $financial_account_items,
            ];

            return view('tportal/hesaplar/detay/hareketler_detayli', $data);
        } else {
            return redirect()->back();
        }


        $data = [
            'financial_account_items' => $financial_account_items,
        ];

        return view('tportal/hesaplar/index', $data);
    }

    public function create()
    {
        $transaction_prefix = "TRNSCTN";
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $account_title = $this->request->getPost('account_title');
                $account_type = $this->request->getPost('account_type');
                $bank_branch = $this->request->getPost('bank_branch');
                $bank_account_number = $this->request->getPost('bank_account_number');
                $bank_iban = $this->request->getPost('bank_iban');
                $money_unit_id = $this->request->getPost('money_unit_id');
                $bank_id = $this->request->getPost('bank_id');
                if(empty($bank_id))
                {
                    $bank_id = '';
                }
                $transaction_description = $this->request->getPost('transaction_description');

                $starting_balance = $this->request->getPost('starting_balance');
                $starting_balance_date = $this->request->getPost('starting_balance_date');
                $starting_balance_date = $starting_balance_date ? convert_datetime_for_sql($starting_balance_date) : date('Y-m-d H:i:s');
                $starting_balance = convert_number_for_sql($starting_balance);
                $account_balance = $starting_balance;

                $insert_financial_account_data = [
                    'user_id' => session()->get('user_id'),
                    'account_title' => $account_title,
                    'account_type' => $account_type,
                    'bank_branch' => $bank_branch,
                    'bank_account_number' => $bank_account_number,
                    'bank_iban' => $bank_iban,
                    'money_unit_id' => $money_unit_id,
                    'bank_id' => $bank_id,
                    'account_balance' => $account_balance,
                    'default' => 'false',
                ];

                $this->modelFinancialAccount->insert($insert_financial_account_data);
                $financial_account_id = $this->modelFinancialAccount->getInsertID();


                if ($starting_balance != null && $starting_balance != 0 && $starting_balance != '') {
                    $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                    if ($last_transaction) {
                        $transaction_counter = $last_transaction['transaction_counter'] + 1;
                    } else {
                        $transaction_counter = 1;
                    }
                    $transaction_number = $transaction_prefix . str_pad($transaction_counter, 8, '0', STR_PAD_LEFT);

                    [$transaction_direction, $starting_balance] = $starting_balance < 0 ? ['exit', $starting_balance * -1] : ['entry', $starting_balance];
                    try {
                        $insert_financial_movement_data = [
                            'user_id' => session()->get('user_id'),
                            'financial_account_id' => $financial_account_id,
                            'cari_id' => null,
                            'money_unit_id' => $money_unit_id,
                            'transaction_number' => $transaction_number,
                            'transaction_direction' => $transaction_direction,
                            'transaction_type' => 'starting_balance',
                            'transaction_tool' => 'not_payroll',
                            'transaction_title' => 'Açılış Bakiyesi',
                            'transaction_description' => $transaction_description,
                            'transaction_amount' => $starting_balance,
                            'transaction_real_amount' => $starting_balance,
                            'transaction_date' => $starting_balance_date,
                            'transaction_prefix' => $transaction_prefix,
                            'transaction_counter' => $transaction_counter
                        ];
                        $this->modelFinancialMovement->insert($insert_financial_movement_data);
                    } catch (\Exception $e) {
                        $this->logClass->save_log(
                            'error',
                            'financial_movement',
                            null,
                            null,
                            'create',
                            $e->getMessage(),
                            json_encode($_POST)
                        );
                        echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                        return;
                    }
                }

                echo json_encode(['icon' => 'success', 'message' => 'Finansal hesap başarıyla eklendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'financial_account',
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

            $data = [
                'money_unit_items' => $money_unit_items,
                'bank_items' => session()->get('bank_items')
            ];

            return view('tportal/hesaplar/yeni', $data);
        }
    }

    public function edit($financial_account_id = null)
    {
        $financial_account_item = $this->modelFinancialAccount->where('financial_account.user_id', session()->get('user_id'))->join('money_unit', 'financial_account.money_unit_id = money_unit.money_unit_id')->where('financial_account_id', $financial_account_id)->first();
        if (!$financial_account_item) {
            return view('not-found');
        }
        $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
        $cari_item["dolarKur"] = $MoneyUnitsDolar["money_value"];
        $cari_item["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
        $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
        $cari_item["euroKur"] = $MoneyUnitsEuro["money_value"];
        $cari_item["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];

        if ($this->request->getMethod('true') == 'POST') {
            try {
                $account_title = $this->request->getPost('account_title');
                $bank_branch = $this->request->getPost('bank_branch');
                $bank_account_number = $this->request->getPost('bank_account_number');
                $bank_iban = $this->request->getPost('bank_iban');

                $update_financial_account_data = [
                    'account_title' => $account_title,
                    'bank_branch' => $bank_branch,
                    'bank_account_number' => $bank_account_number,
                    'bank_iban' => $bank_iban,
                ];

                $this->modelFinancialAccount->update($financial_account_id, $update_financial_account_data);

                echo json_encode(['icon' => 'success', 'message' => 'İşlem bilgileri başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'financial_account',
                    $financial_account_id,
                    null,
                    'edit',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();

            $data = [
                'cari_itemd' => $cari_item,
                'financial_account_item' => $financial_account_item,
                'money_unit_items' => $money_unit_items,
                'bank_items' => session()->get('bank_items')
            ];

            return view('tportal/hesaplar/detay/duzenle', $data);
        }
    }

    public function delete($financial_account_id)
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {

                $financial_account_item = $this->modelFinancialAccount->where('financial_account_id', $financial_account_id)->where('user_id', session()->get('user_id'))->first();
                if (!$financial_account_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen hesap bilgisi bulunamadı.']);
                    return;
                }

                $financial_account_movement_items = $this->modelFinancialMovement->where('financial_account_id', $financial_account_id)->where('user_id', session()->get('user_id'))->findAll();
                if ($financial_account_movement_items) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen hesap için hesap hareketi mevcut. Lütfen önce hesap hareketlerini siliniz.']);
                    return;
                }

                $this->modelFinancialAccount->delete($financial_account_id);

                echo json_encode(['icon' => 'success', 'message' => 'Belirtilen hesap başarıyla silindi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'financial_account',
                    $financial_account_id,
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

    public function detail($financial_account_id)
    {
        $financial_account_item = $this->modelFinancialAccount->join('money_unit', 'money_unit.money_unit_id = financial_account.money_unit_id')
            ->where('financial_account.user_id', session()->get('user_id'))
            ->where('financial_account.financial_account_id', $financial_account_id)
            ->first();
            $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
            $cari_item["dolarKur"] = $MoneyUnitsDolar["money_value"];
            $cari_item["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
            $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
            $cari_item["euroKur"] = $MoneyUnitsEuro["money_value"];
            $cari_item["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];

        $data = [
            'financial_account_item' => $financial_account_item,
            'cari_itemd' => $cari_item,
            'bank_items' => session()->get('bank_items')
        ];

        return view('tportal/hesaplar/detay/detay', $data);
    }

    public function listLoadCari()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {

                $cari_items = $this->modelCari->where('user_id', session()->get('user_id'))->findAll();

                echo json_encode(['icon' => 'success', 'message' => 'Cari hesapları başarıyla getirildi.', 'cari_items' => $cari_items]);
                return;
            } catch (\Exception $e) {
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    public function listLoadFinancialAccount()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {

                $financial_account_items = $this->modelFinancialAccount->where('user_id', session()->get('user_id'))->findAll();

                echo json_encode(['icon' => 'success', 'message' => 'Finansal hesaplar başarıyla getirildi.', 'financial_account_items' => $financial_account_items]);
                return;
            } catch (\Exception $e) {
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    public function createTransaction($financial_account_id = null)
    {

        $financial_account_item = $this->modelFinancialAccount->join('money_unit', 'money_unit.money_unit_id = financial_account.money_unit_id')
            ->where('financial_account.user_id', session()->get('user_id'))
            ->where('financial_account.financial_account_id', $financial_account_id)
            ->first();

            $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
        $cari_item["dolarKur"] = $MoneyUnitsDolar["money_value"];
        $cari_item["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
        $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
        $cari_item["euroKur"] = $MoneyUnitsEuro["money_value"];
        $cari_item["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];
        $financial_account_items = $this->modelFinancialAccount->table('`financial_account`')
            ->select('financial_account_id, money_unit.money_unit_id, account_title, account_type, bank_id, money_code')
            ->join('money_unit', 'financial_account.money_unit_id = money_unit.money_unit_id')
            ->findAll();

        if (!$financial_account_item) {
            return view('not-found');
        }

        $all_money_unit = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();

        $data = [
            'cari_itemd' => $cari_item,
            'financial_account_item' => $financial_account_item,
            'financial_account_items' => $financial_account_items,
            'bank_items' => session()->get('bank_items'),
            'all_money_unit' => $all_money_unit,
        ];

        return view('tportal/hesaplar/detay/islem_ekle', $data);
    }

    public function storeTransaction($financial_account_id = null)
    {

        $islem_kuru = $this->request->getPost("islem_kuru");
        $kur_degeri = $this->request->getPost("donusturulecek_kur");
        $toplam_aktarilacak = $this->request->getPost("toplam_kur");
        $kasa_id = $this->request->getPost("kasa_id");


        $Virman = $this->modelMoneyUnit->where("money_code", $islem_kuru)->first();

        $FinansVirman = $this->modelFinancialAccount->where("money_unit_id", $Virman["money_unit_id"])->first();

        $CariHesapFinans = $this->modelFinancialAccount->where("financial_account_id", $kasa_id)->first();
        $CariHesapMoney = $this->modelMoneyUnit->where("money_unit_id", $CariHesapFinans["money_unit_id"])->first();


        
        $transaction_prefix = "TRNSCTN";

        if ($this->request->getMethod('true') == 'POST') {
            try {
                $financial_account_item = $this->modelFinancialAccount->where('user_id', session()->get('user_id'))->where('financial_account_id', $kasa_id)->first();
                if (!$financial_account_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Hesap bulunamadı.']);
                    return;
                }

                $transaction_type = $this->request->getPost('transaction_type');
                $to_transaction_id = $kasa_id;
                if ($transaction_type == 'outgoing_virman') {
                    $to_transaction_item = $this->modelFinancialAccount->where('user_id', session()->get('user_id'))->where('financial_account_id', $to_transaction_id)->first();
                    $cari_id = null;
                    $message = "Belirtilen hesap bulunamadı.";
                } elseif ($transaction_type == 'payment') {
                    $to_transaction_item = $this->modelCari->where('user_id', session()->get('user_id'))->where('cari_id', $to_transaction_id)->first();
                    $cari_id = $to_transaction_item['cari_id'];
                    $message = "Belirtilen cari bulunamadı.";
                } else {
                    echo json_encode(['icon' => 'error', 'message' => "Hatalı işlem tipi"]);
                    return;
                }

                if (!$to_transaction_item) {
                    echo json_encode(['icon' => 'error', 'message' => $message]);
                    return;
                }

                $money_unit_id = $this->request->getPost('money_unit_id');
                $transaction_title = $this->request->getPost('transaction_title');
                $transaction_description = $this->request->getPost('transaction_description');
                $transaction_amount = convert_number_for_sql($this->request->getPost('transaction_amount'));
                $transaction_cost = $this->request->getPost('transaction_cost');
                $transaction_real_amount = $transaction_amount + $transaction_cost;
                $transaction_date = $this->request->getPost('transaction_date');
                $transaction_date = $transaction_date ? convert_datetime_for_sql($transaction_date) : date("Y-m-d H:i:s");

                $amount_to_be_processed = $transaction_amount * -1;
                $transaction_direction = 'exit';

                $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                if ($last_transaction) {
                    $transaction_counter = $last_transaction['transaction_counter'] + 1;
                } else {
                    $transaction_counter = 1;
                }

                if($FinansVirman["financial_account_id"] != $CariHesapFinans["financial_account_id"]){
                        
                    $financial_account_ids = $FinansVirman["financial_account_id"];
                    $transaction_real_amount = convert_number_for_sql($toplam_aktarilacak);
                    $amount_to_be_processeds = $transaction_real_amount;
                    
                    $NotOlustur = '
                        İşlem Kuru  : '.$kur_degeri.' - '.$CariHesapMoney["money_code"].' 
                        İşlem Tutarı: '.$toplam_aktarilacak.'  '.$CariHesapMoney["money_code"].' ( '.$transaction_amount.' '.$Virman["money_code"].' ) 
                        Virman Hesab: '.$FinansVirman["account_title"].'
                    ';


                    $transaction_description.= $NotOlustur;
        

                }else{
                    $financial_account_ids = $financial_account_id;
                    $transaction_real_amount = $transaction_amount;
                    $amount_to_be_processeds = $amount_to_be_processed;


                }

                if(!empty($kur_degeri)){
                    $virman  = convert_number_for_sql($transaction_amount);

                }else{
                    $virman  = '';

                }

             
                


                $transaction_number = $transaction_prefix . str_pad($transaction_counter, 8, '0', STR_PAD_LEFT);
                $insert_financial_movement_data = [

                    
                    'user_id' => session()->get('user_id'),
               

     
                    'financial_account_id' => $financial_account_id,
                    'cari_id' => $cari_id,
                    'virman' => convert_number_for_sql($this->request->getPost('transaction_amount')),
                    'money_unit_id' => $money_unit_id,
                    'transaction_number' => $transaction_number,
                    'transaction_direction' => $transaction_direction,
                    'transaction_type' => $transaction_type,
                    'transaction_tool' => 'not_payroll',
                    'transaction_title' => $transaction_title,
                    'transaction_description' => $transaction_description,
                    'transaction_amount' => convert_number_for_sql($toplam_aktarilacak),
                    'transaction_real_amount' => $transaction_real_amount,
                    'transaction_date' => $transaction_date,
                    'transaction_prefix' => $transaction_prefix,
                    'transaction_counter' => $transaction_counter
                ];
                $this->modelFinancialMovement->insert($insert_financial_movement_data);
                $update_financial_account_data = [
                    'account_balance' => $financial_account_item['account_balance'] - convert_number_for_sql($toplam_aktarilacak)
                ];
                $this->modelFinancialAccount->update($financial_account_id, $update_financial_account_data);

                $amount_to_be_processed = $amount_to_be_processed * -1;
                if ($transaction_type == 'outgoing_virman') {



                    if($FinansVirman["financial_account_id"] != $CariHesapFinans["financial_account_id"]){
                        
                        $financial_account_ids = $FinansVirman["financial_account_id"];
                        $transaction_real_amount = convert_number_for_sql($toplam_aktarilacak);
                        $amount_to_be_processeds = $transaction_real_amount;
                        
                        $NotOlustur = '
                            İşlem Kuru  : '.$kur_degeri.' - '.$CariHesapMoney["money_code"].' 
                            İşlem Tutarı: '.$toplam_aktarilacak.'  '.$CariHesapMoney["money_code"].' ( '.$transaction_amount.' '.$Virman["money_code"].' ) 
                            Virman Hesab: '.$FinansVirman["account_title"].'
                        ';
    
    
                        $transaction_description.= $NotOlustur;
            
    
                    }else{
                        $financial_account_ids = $financial_account_id;
                        $transaction_real_amount = $transaction_amount;
                        $amount_to_be_processeds = $amount_to_be_processed;
    
    
                    }
    
                    $virman  = '';
    
                  


                    $transaction_type = 'incoming_virman';
                    $transaction_direction = 'entry';
                    $transaction_counter += 1;
                    $transaction_number = $transaction_prefix . str_pad($transaction_counter, 8, '0', STR_PAD_LEFT);
                    $insert_financial_movement_data = [
                        'user_id' => session()->get('user_id'),
                        'financial_account_id' => $FinansVirman["financial_account_id"],
                        'cari_id' => $cari_id,
                        'virman' => $virman,
    
                        'money_unit_id' => $Virman["money_unit_id"],
    
                        'transaction_number' => $transaction_number,
                        'transaction_direction' => $transaction_direction,
                        'transaction_type' => $transaction_type,
                        'transaction_tool' => 'not_payroll',
                        'transaction_title' => $transaction_title,
                        'transaction_description' => $transaction_description,
                        'transaction_amount' => $transaction_amount,
                        'transaction_real_amount' => $transaction_real_amount,
                        'transaction_date' => $transaction_date,
                        'transaction_prefix' => $transaction_prefix,
                        'transaction_counter' => $transaction_counter
                    ];
                    $this->modelFinancialMovement->insert($insert_financial_movement_data);

                    $update_financial_account_data = [
                        'account_balance' => $to_transaction_item['account_balance'] + $amount_to_be_processed
                    ];
                    $this->modelFinancialAccount->update($FinansVirman["financial_account_id"], $update_financial_account_data);
                } elseif ($transaction_type == 'payment') {
                    $update_cari_data = [
                        'cari_balance' => $to_transaction_item['cari_balance'] + $amount_to_be_processed
                    ];
                    $this->modelCari->update($to_transaction_item['cari_id'], $update_cari_data);
                }

                echo json_encode(['icon' => 'success', 'message' => 'Tahsilat/Ödeme başarıyla oluşturuldu.']);
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'financial_movement',
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
            return redirect()->back();
        }
    }

    public function financialMovements($financial_account_id = null)
    {
     
        $financial_account_item = $this->modelFinancialAccount->join('money_unit', 'money_unit.money_unit_id = financial_account.money_unit_id')
                                                            ->where('financial_account.user_id', session()->get('user_id'))
                                                            ->where('financial_account.financial_account_id', $financial_account_id)
                                                            ->first();
        if (!$financial_account_item) {
            return view('not-found');
        }

        $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
        $cari_item["dolarKur"] = $MoneyUnitsDolar["money_value"];
        $cari_item["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
        $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
        $cari_item["euroKur"] = $MoneyUnitsEuro["money_value"];
        $cari_item["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];


        $financial_movement_items = $this->modelFinancialMovement
                                        ->join('cari', 'cari.cari_id = financial_movement.cari_id', "left")
                                        ->where('financial_movement.user_id', session()->get('user_id'))
                                        ->where('financial_movement.transaction_tool', 'not_payroll')
                                        ->where('financial_movement.financial_account_id', $financial_account_id)
                                        ->orderBy('financial_movement.transaction_date', 'DESC')
                                        ->orderBy('financial_movement.financial_movement_id', 'DESC')
                                        ->findAll();

                                    foreach($financial_movement_items as &$item) { // Referans ile döngü yapıyoruz
                                        $money = $this->modelMoneyUnit->where("money_unit_id", $item["money_unit_id"])->first();
                                        if ($money) {
                                            $item["money"] = $money["money_icon"]; // Doğrudan item'in içine atıyoruz
                                        }
                                    }

                                    // Referans bittiği için $financial_movement_items güncellenmiş olur
                              

        $data = [
            'cari_itemd' => $cari_item,
            'financial_account_item' => $financial_account_item,
            'financial_movement_items' => $financial_movement_items,
            'bank_items' => session()->get('bank_items'),
            'temp_balance' => $financial_account_item['account_balance']
        ];
        return view('tportal/hesaplar/detay/hareketler', $data);
    }
}
