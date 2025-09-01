<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;
use App\Models\TikoERP\CheckModel;
use App\Models\TikoERP\CheckTransactionModel;
use App\Controllers\TikoPortal\GeneralConfig;

class CheckController extends BaseController
{
    protected $checkModel;
    protected $checkTransactionModel;
    protected $DatabaseConfig;
    protected $currentDB;
    protected $MainDB;
    protected $modelCari;
    protected $financialMovementModel;
    protected $financialAccountModel;
    protected $modelMoneyUnit;

    public function __construct()
    {
        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
        helper('Helpers\formatter_helper');
        helper('Helpers\stock_func_helper');

        $this->MainDB = \Config\Database::connect();
        $TikoERPModelPath = 'App\Models\TikoERP';
        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);
        $this->checkModel = model($TikoERPModelPath.'\CheckModel', true, $db_connection);
        $this->checkTransactionModel = model($TikoERPModelPath.'\CheckTransactionModel', true, $db_connection);
        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
        $this->financialMovementModel = model($TikoERPModelPath.'\FinancialMovementModel', true, $db_connection);
        $this->financialAccountModel = model($TikoERPModelPath.'\FinancialAccountModel', true, $db_connection);
        $this->modelMoneyUnit = model($TikoERPModelPath.'\MoneyUnitModel', true, $db_connection);
    }

    private function createFinancialMovement($check, $transaction_type, $direction, $description, $cari_id = null)
    {
        try {
            // Son hareket numarasını al
            $last_transaction = $this->financialMovementModel
                ->where('user_id', session()->get('user_id'))
                ->orderBy('transaction_counter', 'DESC')
                ->first();
            
            $transaction_counter = $last_transaction ? $last_transaction['transaction_counter'] + 1 : 1;
            
            // Para birimi ID'sini al
            $money_unit = $this->modelMoneyUnit->where('money_code', $check['currency'])->first();
            
            // İlgili çek kasasını bul
            $financial_account = $this->financialAccountModel
                ->where('account_type', 'check_bill')
                ->where('money_unit_id', $money_unit['money_unit_id'])
                ->first();
            
            if (!$financial_account) {
                throw new \Exception('Bu para birimi için çek kasası bulunamadı: ' . $check['currency']);
            }
    
            // Cari ID kontrolü - kendi çekimizse 0 olarak ayarla
            $final_cari_id = null;
            if ($check['check_type'] == 'own') {
                $final_cari_id = 0; // Kendi çekimiz için 0
            } else {
                $final_cari_id = $cari_id ?? $check['drawer_id'];
                if (!$final_cari_id) {
                    throw new \Exception('Müşteri çeki için cari_id gereklidir');
                }
            }
    
            // Finans hareketi oluştur
            $movement_data = [
                'user_id' => session()->get('user_id'),
                'financial_account_id' => $financial_account['financial_account_id'],
                'cari_id' => $final_cari_id,
                'money_unit_id' => $money_unit['money_unit_id'],
                'transaction_number' => 'CHK' . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT),
                'transaction_direction' => $direction,
                'transaction_type' => 'check_bill',
                'transaction_tool' => 'not_payroll',
                'transaction_title' => 'Çek İşlemi - ' . $check['check_no'],
                'transaction_description' => $description,
                'transaction_amount' => $check['amount'],
                'transaction_real_amount' => $check['amount'],
                'transaction_date' => date('Y-m-d H:i:s'),
                'transaction_prefix' => 'CHK',
                'transaction_counter' => $transaction_counter,
                'stock_movement_id' => 0 // Gerekli alan için varsayılan değer
            ];
            
            $this->financialMovementModel->insert($movement_data);
            
            // Kasa bakiyesini güncelle
            $amount_to_process = $direction == 'entry' ? $check['amount'] : -$check['amount'];
            $new_balance = $financial_account['account_balance'] + $amount_to_process;
            
            $this->financialAccountModel->update(
                $financial_account['financial_account_id'], 
                ['account_balance' => $new_balance]
            );
    
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Finans hareketi oluşturma hatası: ' . $e->getMessage());
            return false;
        }
    }

    public function index()
    {
        $data['checks'] = $this->checkModel->select('checks.*, cari.*, bank.bank_title, checks.created_at as check_created_at')
            ->join('bank', 'bank.bank_id = checks.bank_id', 'left')
            ->join('cari', 'cari.cari_id = checks.drawer_id', 'left')
            ->findAll();
        
        $data['bankalar'] = $this->MainDB->table('bank')->where('bank_status', 'active')->get()->getResultArray();
        $data['diger_para_birimleri'] = $this->MainDB->table('diger_para_birimleri')->get()->getResultArray();
        return view('tportal/cekler/index', $data);
    }

    public function addCheck()
    {
        if ($this->request->getMethod() === 'post') {
            try {
                // Çek resmi yükleme işlemi
                $check_image = '';
                $file = $this->request->getFile('check_image');
                
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    if (!is_dir('uploads/cek')) {
                        mkdir('uploads/cek', 0777, true);
                    }
                    $newName = $file->getRandomName();
                    if ($file->move('uploads/cek', $newName)) {
                        $check_image = 'uploads/cek/' . $newName;
                    }
                }
        
                // Form verilerini hazırla
                $data = [
                    'check_no' => $this->request->getPost('check_no'),
                    'amount' => $this->request->getPost('amount'),
                    'currency' => $this->request->getPost('currency'),
                    'exchange_rate' => $this->request->getPost('exchange_rate'),
                    'due_date' => $this->request->getPost('due_date'),
                    'issue_date' => $this->request->getPost('issue_date'),
                    'bank_id' => $this->request->getPost('bank_id'),
                    'drawer_id' => $this->request->getPost('customer_id'),
                    'status' => CheckModel::STATUS_PORTFOLIO,
                    'check_type' => $this->request->getPost('check_type'),
                    'description' => $this->request->getPost('description'),
                    'check_image' => $check_image
                ];
        
                if ($this->checkModel->insert($data)) {
                    $check_id = $this->checkModel->getInsertID();
                    $check = $this->checkModel->find($check_id);

                    // İşlem kaydı oluştur
                    $transactionData = [
                        'check_id' => $check_id,
                        'transaction_type' => CheckTransactionModel::TYPE_RECEIVE,
                        'from_id' => $data['drawer_id'] ?: session()->get('user_id'),
                        'to_id' => session()->get('user_id'),
                        'transaction_date' => date('Y-m-d H:i:s'),
                        'description' => 'Çek portföye eklendi'
                    ];
                    $this->checkTransactionModel->insert($transactionData);
        
                    // Finans hareketi oluştur
                    if ($this->createFinancialMovement(
                        $check,
                        'check_bill',
                        'entry',
                        'Çek portföye alındı',
                        $data['drawer_id']
                    )) {
                        return redirect()->to('/tportal/checks')->with('success', 'Çek başarıyla eklendi');
                    }
                }
            } catch (\Exception $e) {
                return redirect()->to('/tportal/checks')->with('error', 'Çek eklenirken bir hata oluştu: ' . $e->getMessage());
            }
        }
    
        $data['bankalar'] = $this->MainDB->table('bank')->where('bank_status', 'active')->get()->getResultArray();
        $data['customers'] = $this->modelCari->findAll();
        $data['currencies'] = [
            ['code' => 'TRY', 'name' => 'Türk Lirası'],
            ['code' => 'USD', 'name' => 'Amerikan Doları'],
            ['code' => 'EUR', 'name' => 'Euro']
        ];
        return view('tportal/cekler/add', $data);
    }

    public function endorse($id)
    {
        if ($this->request->getMethod() === 'post') {
            try {
                $check = $this->checkModel->find($id);
                
                if ($check) {
                    // Çek durumunu güncelle
                    $this->checkModel->update($id, [
                        'status' => CheckModel::STATUS_ENDORSED,
                        'payee_id' => $this->request->getPost('payee_id')
                    ]);

                    // Ciro işlemi kaydı
                    $transactionData = [
                        'check_id' => $id,
                        'transaction_type' => CheckTransactionModel::TYPE_ENDORSE,
                        'from_id' => session()->get('user_id'),
                        'to_id' => $this->request->getPost('payee_id'),
                        'transaction_date' => date('Y-m-d H:i:s'),
                        'description' => $this->request->getPost('description')
                    ];
                    $this->checkTransactionModel->insert($transactionData);

                    // Finans hareketi oluştur
                    if ($this->createFinancialMovement(
                        $check,
                        'check_bill',
                        'exit',
                        'Çek ciro edildi',
                        $this->request->getPost('payee_id')
                    )) {
                        return redirect()->to('/tportal/checks')->with('success', 'Çek başarıyla ciro edildi');
                    }
                }
            } catch (\Exception $e) {
                return redirect()->to('/tportal/checks')->with('error', 'Çek ciro edilirken bir hata oluştu: ' . $e->getMessage());
            }
        }

        $data['bankalar'] = $this->MainDB->table('bank')->where('bank_status', 'active')->get()->getResultArray();
        $data['customers'] = $this->modelCari->findAll();
        $data['check'] = $this->checkModel->find($id);
        return view('tportal/cekler/endorse', $data);
    }

    public function markAsPaid($id)
    {
        try {
            $check = $this->checkModel->find($id);
            
            if ($check) {
                $this->checkModel->update($id, ['status' => CheckModel::STATUS_PAID]);
                
                // İşlem kaydı
                $transactionData = [
                    'check_id' => $id,
                    'transaction_type' => CheckTransactionModel::TYPE_PAYMENT,
                    'from_id' => session()->get('user_id'),
                    'to_id' => null,
                    'transaction_date' => date('Y-m-d H:i:s'),
                    'description' => 'Çek ödendi'
                ];
                $this->checkTransactionModel->insert($transactionData);

                // Finans hareketi oluştur
                if ($this->createFinancialMovement(
                    $check,
                    'check_bill',
                    'exit',
                    'Çek ödendi'
                )) {
                    return redirect()->to('/tportal/checks')->with('success', 'Çek ödenmiş olarak işaretlendi');
                }
            }
        } catch (\Exception $e) {
            return redirect()->to('/tportal/checks')->with('error', 'Çek ödenirken bir hata oluştu: ' . $e->getMessage());
        }

        return redirect()->to('/tportal/checks')->with('error', 'Çek bulunamadı');
    }

    public function markAsBounced($id)
    {
        try {
            $check = $this->checkModel->find($id);
            
            if ($check) {
                $this->checkModel->update($id, ['status' => CheckModel::STATUS_BOUNCED]);
                
                // İşlem kaydı
                $transactionData = [
                    'check_id' => $id,
                    'transaction_type' => CheckTransactionModel::TYPE_BOUNCE,
                    'from_id' => session()->get('user_id'),
                    'to_id' => null,
                    'transaction_date' => date('Y-m-d H:i:s'),
                    'description' => 'Çek karşılıksız çıktı'
                ];
                $this->checkTransactionModel->insert($transactionData);

                // Finans hareketi oluştur
                if ($this->createFinancialMovement(
                    $check,
                    'check_bill',
                    'exit',
                    'Çek karşılıksız çıktı'
                )) {
                    return redirect()->to('/tportal/checks')->with('success', 'Çek karşılıksız olarak işaretlendi');
                }
            }
        } catch (\Exception $e) {
            return redirect()->to('/tportal/checks')->with('error', 'Çek karşılıksız işaretlenirken bir hata oluştu: ' . $e->getMessage());
        }

        return redirect()->to('/tportal/checks')->with('error', 'Çek bulunamadı');
    }

    public function transactions($checkId)
    {
        $data['check'] = $this->checkModel->select('checks.*, bank.bank_title')
            ->join('bank', 'bank.bank_id = checks.bank_id', 'left')
            ->find($checkId);
        $data['transactions'] = $this->checkTransactionModel->getCheckTransactions($checkId);
        
        // Her işlem için kimden-kime bilgilerini ekleyelim
        foreach ($data['transactions'] as &$transaction) {
            if ($transaction['from_id']) {
                $from_cari = $this->modelCari->find($transaction['from_id']);
                $transaction['from_name'] = $from_cari ? $from_cari['invoice_title'] : '';
            } else {
                $transaction['from_name'] = session()->get('user_item')['firma_adi'];
            }
            
            if ($transaction['to_id']) {
                $to_cari = $this->modelCari->find($transaction['to_id']);
                $transaction['to_name'] = $to_cari ? $to_cari['invoice_title'] : '';
            } else {
                $transaction['to_name'] = session()->get('user_item')['firma_adi'];
            }
        }
        
        return view('tportal/cekler/transactions', $data);
    }

    public function printCheck($id)
    {
        $data['check'] = $this->checkModel->find($id);
        if (!$data['check']) {
            return redirect()->to('/tportal/checks')->with('error', 'Çek bulunamadı');
        }
        return view('tportal/cekler/print', $data);
    }
}