<?php


namespace App\Controllers\TikoERP;
use CodeIgniter\Database\Config;
use App\Controllers\BaseController;
use App\Controllers\TikoERP\Log;
use App\Models\TikoPortal\BankModel;
use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoERP\OperationModel;
use App\Models\TikoERP\CekModel;

/**
 * @property IncomingRequest $request 
 */


class Cekler extends BaseController{
    private $DatabaseConfig;
    private $currentDB;
    
    private $modelCari;
    private $modelAddress;
    private $modelMoneyUnit;
    private $modelCek;
    private $cekModel;

    private $cariModel;
    private $bankModel;

    private $logClass;

    private $MainDB;

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
        $this->cekModel = model($TikoERPModelPath.'\CekModel', true, $db_connection);
        $this->cariModel = model($TikoERPModelPath.'\CariModel', true, $db_connection);

    }

    public function index()
    {
        $data = [
            'cekler' => $this->cekModel->getCeklerWithDetails(),
            'bankalar' => $this->MainDB->table('bank')->where('bank_status', 'active')->get()->getResultArray(),
            'diger_para_birimleri' => $this->MainDB->table('diger_para_birimleri')->get()->getResultArray()
        ];
        
        
        return view('tportal/cekler/index', $data);
    }

    public function yeni()
    {
        $data = [
            'cariler' => $this->cariModel->where('deleted_at', null)->findAll(),
            'bankalar' => $this->MainDB->table('bank')->where('bank_status', 'active')->get()->getResultArray(),
            'diger_para_birimleri' => $this->MainDB->table('diger_para_birimleri')->get()->getResultArray()
        ];

       
    if ($this->request->getMethod() === 'post') {
        try {
            // Form verilerini al
            $cekTutar = str_replace(',', '.', $this->request->getPost('cek_tutar'));
            $paraBirimi = $this->request->getPost('cek_para_birimi');
            
            // Kur hesaplama
            $kur = 1.0000;
            if ($paraBirimi !== 'TRY') {
                $kur = str_replace(',', '.', $this->request->getPost('cek_kur'));
            }
            
            // Reel tutar hesaplama (TRY karşılığı)
            $reelTutar = $cekTutar * $kur;

            // Tarihleri formatla
            $tahsilatTarihi = $this->request->getPost('tahsilat_tarihi');
            $vadeTarihi = $this->request->getPost('vade_tarihi');

            // Insert verilerini hazırla
            $insertData = [
                'user_id' => session()->get('user_id'),
                'cari_id' => $this->request->getPost('cari_id'),
                'bank_id' => $this->request->getPost('bank_id'),
                'cek_para_birimi' => $paraBirimi,
                'cek_durum' => 'BEKLEMEDE',
                'cek_tutar' => $cekTutar,
                'cek_kur' => $kur,
                'cek_reel_tutar' => $reelTutar,
                'cek_no' => $this->request->getPost('cek_no'),
                'tahsilat_tarihi' => $tahsilatTarihi ? date('Y-m-d', strtotime($tahsilatTarihi)) : null,
                'vade_tarihi' => date('Y-m-d', strtotime($vadeTarihi)),
                'islem_notu' => $this->request->getPost('islem_notu')
            ];

            // Validasyon kuralları
            $rules = [
                'cari_id' => 'required|numeric',
                'bank_id' => 'required|numeric',
                'cek_para_birimi' => 'required|string',
                'cek_tutar' => 'required|numeric|greater_than[0]',
                'cek_no' => 'required|string',
                'vade_tarihi' => 'required|valid_date'
            ];

            // Validasyon kontrolü
            if (!$this->validate($rules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            // Veritabanına kaydet
            if ($this->cekModel->insert($insertData)) {
                return redirect()->to('/tportal/cekler')
                    ->with('success', 'Çek başarıyla eklendi.');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Çek eklenirken bir hata oluştu.');
            }

        } catch (\Exception $e) {
            log_message('error', '[Cek Ekleme] Hata: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'İşlem sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }

        return view('tportal/cekler/yeni', $data);
    }

    public function ciro($id)
    {
        $cek = $this->cekModel->find($id);
        
        if ($cek) {
            $this->cekModel->update($id, [
                'cek_durum' => CekModel::DURUM_CIRO,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            return redirect()->to('/tportal/cekler')->with('success', 'Çek başarıyla ciro edildi.');
        }

        return redirect()->to('/tportal/cekler')->with('error', 'Çek bulunamadı.');
    }

    public function sil($id)
    {
        if ($this->cekModel->delete($id)) {
            return redirect()->to('/tportal/cekler')->with('success', 'Çek başarıyla silindi.');
        }

        return redirect()->to('/tportal/cekler')->with('error', 'Çek silinemedi.');
    }
}