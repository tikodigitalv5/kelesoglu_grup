<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;

use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\HTTP\Request;
use CodeIgniter\I18n\Time;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DateTime;
use DateTimeZone;
// use App\Libraries\DataTable;
// use App\Libraries\DataTableNew;
// use App\Libraries\DataTables;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\API\ResponseTrait;

/**
 * @property IncomingRequest $request
 */
class Cari extends BaseController
{
    private $DatabaseConfig;
    private $currentDB;

    private $modelCari;
    private $modelMoneyUnit;
    private $modelFinancialAccount;
    private $modelFinancialMovement;
    private $modelAddress;
    private $modelStockBarcode;
    private $modelStockMovement;
    private $modelShipment;
    private $modelSaleOrderItem;
    private $modelWarehouse;
    private $modelInvoice;
    private $modelInvoiceRow;
    private $modelNotes;
    private $modelStocks;
    private $modelStockWarehouseQuantity;

    private $logClass;

    private $modelFaturaTutar;
    private $modelOffer;

    private $stok_sayim;

    private $modalStockExcel;
    private $InvoiceIncomingStatusModel;
    private $InvoiceOutgoingStatusModel;


    


    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
        $this->modelOffer = model($TikoERPModelPath . '\OfferModel', true, $db_connection);
        $this->modelFinancialAccount = model($TikoERPModelPath . '\FinancialAccountModel', true, $db_connection);
        $this->modelFinancialMovement = model($TikoERPModelPath . '\FinancialMovementModel', true, $db_connection);
        $this->modelMoneyUnit = model($TikoERPModelPath . '\MoneyUnitModel', true, $db_connection);
        $this->modelAddress = model($TikoERPModelPath . '\AddressModel', true, $db_connection);
        $this->modelStockBarcode = model($TikoERPModelPath . '\StockBarcodeModel', true, $db_connection);
        $this->modelStockMovement = model($TikoERPModelPath . '\StockMovementModel', true, $db_connection);
        $this->modelShipment = model($TikoERPModelPath . '\ShipmentModel', true, $db_connection);
        $this->modelSaleOrderItem = model($TikoERPModelPath . '\SaleOrderItemModel', true, $db_connection);
        $this->modelWarehouse = model($TikoERPModelPath . '\WarehouseModel', true, $db_connection);
        $this->modelInvoice = model($TikoERPModelPath . '\InvoiceModel', true, $db_connection);
        $this->modelInvoiceRow = model($TikoERPModelPath . '\InvoiceRowModel', true, $db_connection);
        $this->modelNotes = model($TikoERPModelPath . '\NoteModel', true, $db_connection);
        $this->modelFaturaTutar = model($TikoERPModelPath . '\FaturaTutarlarModel', true, $db_connection);
        $this->modalStockExcel = model($TikoERPModelPath . '\StockExcelModel', true, $db_connection);
        $this->modelStocks = model($TikoERPModelPath . '\StockModel', true, $db_connection);
        $this->modelStockWarehouseQuantity = model($TikoERPModelPath . '\StockWarehouseQuantityModel', true, $db_connection);
        $this->InvoiceIncomingStatusModel = model($TikoERPModelPath . '\InvoiceIncomingStatusModel', true, $db_connection);
        $this->InvoiceOutgoingStatusModel = model($TikoERPModelPath . '\InvoiceOutgoingStatusModel', true, $db_connection);
        $this->logClass = new Log();

        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
        helper('Helpers\formatter_helper');
        helper('Helpers\stock_func_helper');

        $this->stok_sayim =  session()->get("user_item")["stock_user"] ?? 0;

     


    }

        public function tekrarEdenKayitlar()
        {
            $user_id = session()->get('user_id');
            
            // Veritabanı bağlantısını al
            $db_connection = \Config\Database::connect($this->currentDB);
            
            // Tekrar eden identification_number'ları bul
            $duplicateQuery = "
                SELECT identification_number, COUNT(*) as tekrar_sayisi
                FROM cari 
                WHERE user_id = ? AND identification_number IS NOT NULL AND identification_number != '' AND deleted_at IS NULL
                GROUP BY identification_number 
                HAVING COUNT(*) > 1
                ORDER BY tekrar_sayisi DESC, identification_number
            ";
            
            $duplicateResults = $db_connection->query($duplicateQuery, [$user_id])->getResultArray();
            
            if (empty($duplicateResults)) {
                echo "<div style='padding: 20px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin: 20px;'>";
                echo "<h3 style='color: #155724; margin: 0;'>✅ Tekrar Eden Kayıt Bulunamadı</h3>";
                echo "<p style='color: #155724; margin: 10px 0 0 0;'>Tüm cari kayıtları benzersiz identification_number'lara sahip.</p>";
                echo "</div>";
                return;
            }
            
            echo "<div style='padding: 20px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px;'>";
            echo "<h3 style='color: #721c24; margin: 0;'>⚠️ Tekrar Eden Kayıtlar Bulundu</h3>";
            echo "<p style='color: #721c24; margin: 10px 0 0 0;'>Toplam " . count($duplicateResults) . " adet tekrar eden identification_number bulundu.</p>";
            echo "</div>";
            
            // Her tekrar eden identification_number için detaylı kayıtları getir
            foreach ($duplicateResults as $duplicate) {
                $identification_number = $duplicate['identification_number'];
                $tekrar_sayisi = $duplicate['tekrar_sayisi'];
                
                $detailQuery = "
                    SELECT 
                        c.cari_id,
                        c.cari_code,
                        c.identification_number,
                        c.tax_administration,
                        c.invoice_title,
                        c.name,
                        c.surname,
                        c.company_type,
                        c.cari_phone,
                        c.cari_email,
                        c.cari_balance,
                        c.is_customer,
                        c.is_supplier,
                        c.is_export_customer,
                        c.created_at,
                        c.updated_at,
                        (SELECT COUNT(*) FROM financial_movement fm WHERE fm.cari_id = c.cari_id AND fm.user_id = c.user_id AND fm.deleted_at IS NULL) as finansal_hareket_sayisi,
                        (SELECT COUNT(*) FROM invoice i WHERE i.cari_id = c.cari_id AND i.user_id = c.user_id AND i.deleted_at IS NULL) as fatura_sayisi,
                        (SELECT COUNT(*) FROM `order` o WHERE o.cari_id = c.cari_id AND o.user_id = c.user_id AND o.deleted_at IS NULL) as siparis_sayisi
                    FROM cari c
                    WHERE c.user_id = ? AND c.identification_number = ? AND c.deleted_at IS NULL
                    ORDER BY c.created_at ASC
                ";
                
                $detailResults = $db_connection->query($detailQuery, [$user_id, $identification_number])->getResultArray();
                
                echo "<div style='margin: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background-color: #fff;'>";
                echo "<h4 style='color: #dc3545; margin: 0 0 15px 0;'>";
                echo "🔍 Identification Number: <strong>" . htmlspecialchars($identification_number) . "</strong> ";
                echo "<span style='background-color: #dc3545; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px;'>" . $tekrar_sayisi . " kez tekrar</span>";
                echo "</h4>";
                
                echo "<table style='width: 100%; border-collapse: collapse; margin-top: 10px;'>";
                echo "<thead>";
                echo "<tr style='background-color: #f8f9fa;'>";
                echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>ID</th>";
                echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Cari Kodu</th>";
                echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Firma/Şahıs Adı</th>";
                echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Vergi Dairesi</th>";
                echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Telefon</th>";
                echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>E-posta</th>";
                echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Bakiye</th>";
                echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Tür</th>";
                echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Finansal Hareket</th>";
                echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Fatura</th>";
                echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Sipariş</th>";
                echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Oluşturulma</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                
                foreach ($detailResults as $index => $cari) {
                    $rowColor = $index % 2 == 0 ? '#ffffff' : '#f8f9fa';
                    $companyName = !empty($cari['invoice_title']) ? $cari['invoice_title'] : ($cari['name'] . ' ' . $cari['surname']);
                    $type = $cari['company_type'] == 'company' ? 'Firma' : ($cari['company_type'] == 'person' ? 'Şahıs' : 'Kamu');
                    
                    // Sayıları renklendir
                    $finansalClass = $cari['finansal_hareket_sayisi'] > 0 ? 'color: #28a745; font-weight: bold;' : 'color: #6c757d;';
                    $faturaClass = $cari['fatura_sayisi'] > 0 ? 'color: #007bff; font-weight: bold;' : 'color: #6c757d;';
                    $siparisClass = $cari['siparis_sayisi'] > 0 ? 'color: #ffc107; font-weight: bold;' : 'color: #6c757d;';
                    
                    echo "<tr style='background-color: " . $rowColor . ";'>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . $cari['cari_id'] . "</td>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . $cari['cari_code'] . "</td>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($companyName) . "</td>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($cari['tax_administration']) . "</td>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($cari['cari_phone']) . "</td>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($cari['cari_email']) . "</td>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . number_format($cari['cari_balance'], 2) . " ₺</td>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . $type . "</td>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px; text-align: center;'><span style='" . $finansalClass . "'>" . $cari['finansal_hareket_sayisi'] . "</span></td>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px; text-align: center;'><span style='" . $faturaClass . "'>" . $cari['fatura_sayisi'] . "</span></td>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px; text-align: center;'><span style='" . $siparisClass . "'>" . $cari['siparis_sayisi'] . "</span></td>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . date('d.m.Y H:i', strtotime($cari['created_at'])) . "</td>";
                    echo "</tr>";
                }
                
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            }
            
            // Özet bilgi
            echo "<div style='margin: 20px; padding: 15px; background-color: #e2e3e5; border-radius: 5px;'>";
            echo "<h4 style='margin: 0 0 10px 0; color: #383d41;'>📊 Özet Bilgiler</h4>";
            echo "<ul style='margin: 0; color: #383d41;'>";
            echo "<li>Toplam tekrar eden identification_number sayısı: <strong>" . count($duplicateResults) . "</strong></li>";
            
            $totalDuplicates = 0;
            foreach ($duplicateResults as $duplicate) {
                $totalDuplicates += $duplicate['tekrar_sayisi'];
            }
            echo "<li>Toplam tekrar eden kayıt sayısı: <strong>" . $totalDuplicates . "</strong></li>";
            echo "<li>Benzersiz kayıt sayısı: <strong>" . ($totalDuplicates - count($duplicateResults)) . "</strong></li>";
            echo "</ul>";
            echo "</div>";
        }

    public function checkCustomerVknInfo()
    {
        // vknInfo
        // 0: e-arşiv
        // 1: e-fatura

        $vknTc = $this->request->getPost('vknTc');
/*
        $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')
            ->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
            ->where('cari.identification_number', $vknTc)
            ->where('address.status', 'active')
            ->first();

        if (!$cari_item) {
            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'http://212.98.224.209:3009/vkn_sorgula_efatura',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'vknTc=' . $vknTc,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/x-www-form-urlencoded'
                    ),
                )
            );

            $response = curl_exec($curl);

            curl_close($curl);

            if ($response === false) {
                echo curl_error($curl);
            } else {
                // Başarılı
                // echo $response;
                echo $response;
                return;
            }
        } else {
            echo json_encode(['icon' => 'kayitli', 'message' => 'Kayıtlı olan kullanıcı getirildi.', 'response' => $cari_item]);
            return;
        } */

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'http://212.98.224.209:3009/yeni_vkn_sorgulama',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'vknTc=' . $vknTc,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);

        if ($response === false) {
            echo curl_error($curl);
        } else {
            // Başarılı
            // echo $response;
            echo $response;
            return;
        }
    }


    public function userDatabase()
    {
       
        
        
       

        $userDatabaseDetail = [
            'hostname' => session()->get("user_item")["db_host"],
            'username' => session()->get("user_item")["db_username"],
            'password' => session()->get("user_item")["db_password"],
            'database' => session()->get("user_item")["db_name"],
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

    public function getCariById()
    {
        $cari_id = $this->request->getPost('cariId');

        $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')
            ->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
            ->where('cari.user_id', session()->get('user_id'))
            ->where('cari.cari_id', $cari_id)
            ->where('cari.cari_id !=', $this->stok_sayim)
            ->where('address.status', 'active')
            ->where('address.default', 'true')
            ->first();

        echo json_encode(['icon' => 'success', 'message' => 'Cari başarıyla getirildi.', 'cari_item' => $cari_item]);
        return;
    }
    public function exportExcel()
    {
        // Çıktı tamponlamasını başlat
       
        ob_start();
    
       
       // URL'den gelen ID'leri al
        $ids = $this->request->getGet('ids');
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Lütfen en az bir cari seçiniz.');
        }
        
        // ID'leri diziye çevir
        $cariIds = explode(',', $ids);
        
        // Çıktı tamponlamasını başlat
        ob_start();

        // Tüm seçili cariler için veriyi al
        $cari_items = $this->modelCari
            ->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
            ->join('address', 'address.cari_id = cari.cari_id')
            ->where('cari.user_id', session()->get('user_id'))
            ->whereIn('cari.cari_id', $cariIds)  // Seçili ID'lere göre filtrele
            ->where('address.status', 'active')
            ->where('address.default', 'true')
            ->findAll();

        if (empty($cari_items)) {
            return redirect()->back()->with('error', 'Seçili cariler bulunamadı.');
        }
    

        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');
   
        
        // Hareket detaylarını doldur
        $row = 10;
        $bakiye = 0; // En son işlemden başlayarak bakiye hesaplanacak
    
        // Excel şablonunu yükle
        $template = 'tikoportal_cari_full_extre.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);
        $sheet = $spreadsheet->getActiveSheet();
    
        // Tüm hücrelerin font boyutunu 6px yap
        $sheet->getStyle('A5:L1000')->getFont()->setSize(6);
  
        // Alternatif satır renkleri için stil tanımla
        $styleArray = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'd9d9d9'] // Açık gri arka plan
            ]
        ];
    
        // Firma bilgilerini doldur
        $sheet->setCellValue('B2', ": " .   session()->get('user_item')['firma_adi']);
        $sheet->setCellValue('B3', ": " . session()->get('user_item')['firma_adi']);
        $sheet->setCellValue('B4',  date('d.m.Y'));
        $sheet->setCellValue('L2',  date('d.m.Y'));
        $sheet->setCellValue('L3',  date('H:i:s'));
        // Cari bilgilerini doldur
    
    
        // Rapor tarih ve sayfa bilgilerini doldur
        $sheet->setCellValue('K2', ": " . date('d.m.Y'));
        $sheet->setCellValue('K3', ": " . date('H:i:s'));
        $sheet->setCellValue('K4', ": " . '1 / ' . ceil(count($cari_items) / 20));
    
        try {
            // Önce birleştirilecek hücreleri temizle
            $sheet->setCellValue('B6', '');
            $sheet->setCellValue('C6', '');
            $sheet->setCellValue('D6', '');
            $sheet->setCellValue('E6', '');
    
            $sheet->setCellValue('F6', '');
            $sheet->setCellValue('G6', '');
            $sheet->setCellValue('H6', '');
            $sheet->setCellValue('I6', '');
    
         
    
    
     
       
        } catch (\Exception $e) {
   
        }
        // Hareket detaylarını doldur
        $row = 6;
        $bakiye = 0; //$cari_item['cari_balance'];
        $totalSatir = count($cari_items);
        foreach ($cari_items as $index => $cari_item) {
            
            // Her ikinci satıra gri arka plan uygula (index+1 ile başlayarak)
            if (($index + 1) % 2 == 0) {
                $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($styleArray);
            }


            
            // Hücreleri birleştir
          
                $sheet->mergeCells('B'.$row.':I'.$row);
                $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    
            
            
    
    
    
    
                $sheet->setCellValue('A' . $row, $cari_item['cari_code']);
                $sheet->setCellValue('B' . $row, $cari_item['invoice_title']);
                $sheet->setCellValue('J' . $row, $cari_item['money_code']);

                    // Bakiye değerini ayarla ve kalın yap
                $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('K' . $row)->getFont()->setBold(true);  // Bakiye değerini kalın yap
                $sheet->setCellValueExplicit('K' . $row, abs($cari_item['cari_balance']), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

                // B/A göstergesi ve kalın yap
                $sheet->setCellValue('L' . $row, $cari_item['cari_balance'] >= 0 ? 'B' : 'A');
                $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('L' . $row)->getFont()->setBold(true);  // B/A değerini kalın yap
                            $row++;


                    
            }

                        // foreach döngüsünden SONRA ekleyin (döngünün dışında)
                $lastRow = $row; // Son satırın bir sonraki satır numarası

                // A'dan L'ye kadar olan hücreleri birleştir
                $sheet->mergeCells('A' . $lastRow . ':L' . $lastRow);

                // Birleştirilmiş hücreye metni ekle ve formatla
                $sheet->setCellValue('A' . $lastRow, '*Bu döküman tikoportal.com üzerinden hazırlanmıştır.');
                $sheet->getStyle('A' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('A' . $lastRow)->getFont()->setItalic(true); // İtalik yazı tipi
                $sheet->getStyle('A' . $lastRow)->getFont()->setSize(6); // Font boyutu

    
        // Tampon temizle
        ob_end_clean();
    
        // Excel dosyasını oluştur
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'cari_listesi_' . date('Y_m_d-H_i') . '.xlsx';
    
        // İndirme bağlantısı
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }


public function exportDetayliCari($cari_id, $day = 30, $type = "excel")
{
    // Çıktı tamponlamasını başlat
   
    ob_start();

    $days = $day ?? 30;
    
    $cari_item = $this->modelCari
        ->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
        ->join('address', 'address.cari_id = cari.cari_id')
        ->where('cari.user_id', session()->get('user_id'))
        ->where('cari.cari_id', $cari_id)
        ->first();

    if (!$cari_item) {
        return redirect()->back();
    }

    $start_date = date('Y-m-d', strtotime('-'.$days.' days'));
    $end_date = date('Y-m-d');

    
        $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
        $cari_item["dolarKur"] = $MoneyUnitsDolar["money_value"];
        $cari_item["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
        $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
        $cari_item["euroKur"] = $MoneyUnitsEuro["money_value"];
        $cari_item["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];

         $financial_movement_items = $this->modelFinancialMovement
        ->join('invoice', 'invoice.invoice_id = financial_movement.invoice_id', 'left')
        ->join('money_unit', 'money_unit.money_unit_id = financial_movement.money_unit_id')
        ->select('money_unit.*,financial_movement.*,invoice.sale_type,invoice.currency_amount, invoice.invoice_no, invoice.amount_to_be_paid_try, invoice.amount_to_be_paid, invoice.money_unit_id AS money_id')
        ->where('financial_movement.user_id', session()->get('user_id'))
        ->where('financial_movement.cari_id', $cari_id)
        ->where('financial_movement.transaction_date >=', $start_date)
        ->where('financial_movement.transaction_date <=', $end_date)
        ->where('financial_movement.deleted_at', null) // NULL olan deleted_at kayıtlarını getirir
        ->orderBy('financial_movement.transaction_date', 'ASC')
        ->orderBy('financial_movement_id', 'ASC')
        
        ->findAll();

    // Hareket detaylarını doldur
    $row = 10;
    $bakiye = 0; // En son işlemden başlayarak bakiye hesaplanacak

    // Excel şablonunu yükle
    $template = 'tikoportal_cari_extre.xlsx';
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);
    $sheet = $spreadsheet->getActiveSheet();

    // Tüm hücrelerin font boyutunu 6px yap
    $sheet->getStyle('A10:L1000')->getFont()->setSize(6);

    // Başlık satırı stilini ayarla (9. satır)
    $headerStyle = [
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'd9d9d9']
        ],
        'font' => [
            'bold' => true,
            'size' => 6
        ],
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000']
            ]
        ]
    ];
    $sheet->getStyle('A9:L9')->applyFromArray($headerStyle);

    // Alternatif satır renkleri için stil tanımla
    $styleArray = [
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'd9d9d9'] // Açık gri arka plan
        ]
    ];


// Tahsilat için açık yeşil arka plan
$collectionStyle = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'e6ffe6'] // Açık yeşil
    ]
];

// Ödeme için açık kırmızı arka plan
$paymentStyle = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'ffe6e6'] // Açık kırmızı
    ]
];


    // Firma bilgilerini doldur
    $sheet->setCellValue('B2', ": " .   session()->get('user_item')['firma_adi']);
    $sheet->setCellValue('B3', ": " . session()->get('user_item')['firma_adi']);
    $sheet->setCellValue('B4', date('d.m.Y', strtotime('-'.$days.' days')) . ' - ' . date('d.m.Y'));
    $sheet->setCellValue('L2',  date('d.m.Y'));
    $sheet->setCellValue('L3',  date('H:i:s'));
    // Cari bilgilerini doldur


    // Rapor tarih ve sayfa bilgilerini doldur
    $sheet->setCellValue('K2', ": " . date('d.m.Y'));
    $sheet->setCellValue('K3', ": " . date('H:i:s'));
    $sheet->setCellValue('K4', ": " . '1 / ' . ceil(count($financial_movement_items) / 20));

    try {
        // Önce birleştirilecek hücreleri temizle
        $sheet->setCellValue('I5', '');
        $sheet->setCellValue('J5', '');
        $sheet->setCellValue('K5', '');
        $sheet->setCellValue('L5', '');

        $sheet->setCellValue('B5', '');
        $sheet->setCellValue('C5', '');
        $sheet->setCellValue('D5', '');
        $sheet->setCellValue('E5', '');

        $sheet->setCellValue('B6', '');
        $sheet->setCellValue('C6', '');
        $sheet->setCellValue('D6', '');
        $sheet->setCellValue('E6', '');
        
        $sheet->setCellValue('I6', '');
        $sheet->setCellValue('J6', '');
        $sheet->setCellValue('K6', '');
        $sheet->setCellValue('L6', '');
        
        $sheet->setCellValue('I7', '');
        $sheet->setCellValue('J7', '');
        $sheet->setCellValue('K7', '');
        $sheet->setCellValue('L7', '');



        
        // Hücreleri birleştir
        if (!$sheet->getMergeCells()) {
            $sheet->mergeCells('I5:L5');
            $sheet->mergeCells('I6:L6');
            $sheet->mergeCells('B5:E5');
            $sheet->mergeCells('B6:E6');
            $sheet->mergeCells('I7:L7');
            
        }
        
        // Birleştirilmiş hücrelere değer yaz
        $sheet->setCellValue('I5', ": " . $cari_item['cari_phone'] ?? '');
        $sheet->setCellValue('I6', ": " . $cari_item['cari_email'] ?? '');
        $sheet->setCellValue('I7', ": " . $cari_item['address'] ?? '');
        $sheet->setCellValue('B5', ": " . $cari_item['invoice_title'] == '' ? $cari_item['name'] . ' ' . $cari_item['surname'] : $cari_item['invoice_title']);
        $sheet->setCellValue('B6', ": " . $cari_item['identification_number']);
        $sheet->setCellValue('A1',  $cari_item['invoice_title'] == '' ? $cari_item['name'] . ' ' . $cari_item['surname'] : $cari_item['invoice_title']  . " - CARİ EKSTRESİ");
   
    } catch (\Exception $e) {
        // Hata durumunda birleştirme olmadan devam et
        $sheet->setCellValue('I5', ": " . $cari_item['cari_phone'] ?? '');
        $sheet->setCellValue('I6', ": " . $cari_item['cari_email'] ?? '');
        $sheet->setCellValue('I7', ": " . $cari_item['address'] ?? '');
    }
    // Hareket detaylarını doldur
    $row = 10;
    $bakiye = 0; //$cari_item['cari_balance'];
    $totalSatir = count($financial_movement_items);
    foreach ($financial_movement_items as $index => $movement) {
        
        // Her ikinci satıra gri arka plan uygula (index+1 ile başlayarak)
        

        if ($movement['transaction_type'] == 'collection') {
            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($collectionStyle);
        } else if ($movement['transaction_type'] == 'payment') {
            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($paymentStyle);
        } else if (($index + 1) % 2 == 0) {
            $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($styleArray);
        }
        
        $transaction_amounts_satir = 0;
        if($movement["money_unit_id"] == $cari_item["money_unit_id"]){

            $transaction_amounts_satir = $movement['transaction_amount'];

        }else{
            if($movement["money_unit_id"] != 3){
                $transaction_amounts_satir = $movement["amount_to_be_paid_try"];
            }else{
                $transaction_amounts_satir = $movement["amount_to_be_paid"];
            }

            
            
        }


        $transaction_types = [
            'incoming_invoice' => 'Gelen Fatura',
            'outgoing_invoice' => 'Giden Fatura',
            'collection' => 'Tahsilat',
            'check_bill' => "Çek/Senet",
            'payment' => 'Ödeme',
            'outgoing_gider' => 'Gider',
            'incoming_gider' => 'Gider',
            'starting_balance' => 'Başlangıç Bakiyesi',
            'borc_alacak' => 'Borç/Alacak İşlemi',
        ];

        $transaction_type = $transaction_types[$movement['transaction_type']];

        /* 
        
        */

        if($movement["invoice_no"] != null){
            $invoice_no = $movement["invoice_no"];
        }else{
            $invoice_no = $movement["transaction_prefix"] . str_pad($movement["transaction_counter"], 6, "0", STR_PAD_LEFT);
        }


        $sheet->setCellValue('A' . $row, date('d.m.Y', strtotime($movement['transaction_date'])));
        $sheet->setCellValue('B' . $row, $invoice_no);
        $sheet->setCellValue('C' . $row, '-');
        $sheet->setCellValue('D' . $row, $transaction_type);
        $sheet->setCellValue('E' . $row, $cari_item['cari_code']);
        $sheet->setCellValue('F' . $row, $cari_item['invoice_title']);
        // G sütununa açıklama yazılmadan önce metni düzenle
        $description = $movement['transaction_description'];

        // 1. Yöntem: HTML etiketlerini temizle ve özel karakterleri dönüştür
        $description = strip_tags(html_entity_decode($description));
        $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

        // 2. Yöntem: Maksimum karakter sınırı koy
        $description  = mb_substr($description, 0, 30, 'UTF-8'); // İlk 100 karakter

        // 3. Yöntem: Satır sonlarını temizle
        $description = str_replace(["\r", "\n"], ' ', $description);

        // 4. Yöntem: Sadece belirli karakterlere izin ver
        $description = preg_replace('/[^a-zA-Z0-9\s\-_.üğışçöÜĞİŞÇÖ]/u', '', $description);

        // Tüm yöntemleri birleştirerek:
        $description = strip_tags(html_entity_decode($movement['transaction_description']));
        $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
        $description = str_replace(["\r", "\n"], ' ', $description);
        $description = mb_substr($description, 0, 30, 'UTF-8');
        $description = trim($description);

        // Düzenlenmiş metni hücreye yaz
        $sheet->setCellValue('G' . $row, $description ?: '-');
        $sheet->setCellValue('H' . $row, $cari_item['money_code']);
        
        // İşlem tipine göre borç/alacak yerleştirmesi
        switch($movement['transaction_type']) {
            case 'outgoing_invoice': // Giden Fatura - Borçta göster
            case 'payment': // Tahsilat - Borçta göster
                $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValueExplicit('I' . $row, abs($transaction_amounts_satir), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                $sheet->setCellValue('J' . $row, '');
              //  if ($row > 10) { // İlk satır değilse bakiyeyi güncelle
               //     $bakiye -= abs($transaction_amounts_satir);
               // }

                $bakiye += abs($transaction_amounts_satir);
                
                break;
               
            
            case 'incoming_invoice': // Gelen Fatura - Alacakta göster
            case 'collection': // Ödeme - Alacakta göster
            case 'outgoing_gider': // Gider
            case 'incoming_gider': // Gider
           
                $sheet->setCellValue('I' . $row, '');
                $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValueExplicit('J' . $row, abs($transaction_amounts_satir), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
              //  if ($row > 10) { // İlk satır değilse bakiyeyi güncelle
                  //  $bakiye += abs($transaction_amounts_satir);
                //}
                $bakiye -= abs($transaction_amounts_satir);
                break;
                
            case 'starting_balance':
            case 'borc_alacak':
            case 'check_bill':
                if ($transaction_amounts_satir < 0) {
                    // Negatif değer - Alacakta göster
                    $sheet->setCellValue('I' . $row, '');
                    $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                    $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValueExplicit('J' . $row, abs($transaction_amounts_satir), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                    //if ($row > 10) { // İlk satır değilse bakiyeyi güncelle
                    //      $bakiye += abs($transaction_amounts_satir);
                    //}
                    $bakiye -= abs($transaction_amounts_satir);
                    
                } else {
                    // Pozitif değer - Borçta göster
                    $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                    $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValueExplicit('I' . $row, $transaction_amounts_satir, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                    $sheet->setCellValue('J' . $row, '');
                   // if ($row > 10) { // İlk satır değilse bakiyeyi güncelle
                     //   $bakiye -= $transaction_amounts_satir;
                    //}
                    $bakiye += $transaction_amounts_satir;
                }
                break;
        }
        
        // Sayısal değerler için format
        $numericFormat = '#,##0.00';
        
        // Borç tutarı formatı
        if (!empty($transaction_amounts_satir)) {
            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode($numericFormat);
            $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        }
        
        // Alacak tutarı formatı
        if (!empty($transaction_amounts_satir)) {
            $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode($numericFormat);
            $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        }
        
        // Bakiye tutarı formatı - Kalın yazı
        $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('K' . $row)->getFont()->setBold(true);
        $sheet->setCellValueExplicit('K' . $row, $bakiye, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        
        // B/A göstergesi
        $sheet->setCellValue('L' . $row, $bakiye >= 0 ? 'B' : 'A');
        $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $row++;
    }

                     // foreach döngüsünden SONRA ekleyin (döngünün dışında)
                     $lastRow = $row; // Son satırın bir sonraki satır numarası

                     // A'dan L'ye kadar olan hücreleri birleştir
                     $sheet->mergeCells('A' . $lastRow . ':L' . $lastRow);
     
                     // Birleştirilmiş hücreye metni ekle ve formatla
                     $sheet->setCellValue('A' . $lastRow, '*Bu döküman tikoportal.com üzerinden hazırlanmıştır.');
                     $sheet->getStyle('A' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                     $sheet->getStyle('A' . $lastRow)->getFont()->setItalic(true); // İtalik yazı tipi
                     $sheet->getStyle('A' . $lastRow)->getFont()->setSize(6); // Font boyutu
     

    // Tampon temizle
    ob_end_clean();



    if($type == "excel"){   

        // Excel dosyasını oluştur
       $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
       $filename = 'cari_ekstre_' . date('Y_m_d-H_i') . '.xlsx';
       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       header('Content-Disposition: attachment;filename="' . $filename . '"');
       header('Cache-Control: max-age=0');
       $writer->save('php://output');
       exit;

   }else{

        // Excel'i PDF'e çevirmek için gerekli writer'ı tanımla
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
        $filename = 'cari_ekstre_' . date('Y_m_d-H_i') . '.pdf';
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;

   }

   
}



public function exportDetayliCariFull($cari_id, $day = 3, $type = "excel")
{
    // Çıktı tamponlamasını başlat
   
    ob_start();

    $days = $day ?? 30;
    
    $cari_item = $this->modelCari
        ->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
        ->join('address', 'address.cari_id = cari.cari_id')
        ->where('cari.user_id', session()->get('user_id'))
        ->where('cari.cari_id', $cari_id)
        ->where('address.status', 'active')
        ->where('address.default', 'true')
        ->first();

    if (!$cari_item) {
        return redirect()->back();
    }

    $start_date = date('Y-m-d', strtotime('-'.$days.' days'));
    $end_date = date('Y-m-d');

    $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
        $cari_item["dolarKur"] = $MoneyUnitsDolar["money_value"];
        $cari_item["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
        $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
        $cari_item["euroKur"] = $MoneyUnitsEuro["money_value"];
        $cari_item["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];

         $financial_movement_items = $this->modelFinancialMovement
        ->join('invoice', 'invoice.invoice_id = financial_movement.invoice_id', 'left')
        ->join('money_unit', 'money_unit.money_unit_id = financial_movement.money_unit_id')
        ->select('money_unit.*,financial_movement.*,invoice.sale_type,invoice.currency_amount, invoice.invoice_no, invoice.amount_to_be_paid_try, invoice.amount_to_be_paid, invoice.money_unit_id AS money_id')
        ->where('financial_movement.user_id', session()->get('user_id'))
        ->where('financial_movement.cari_id', $cari_id)
        ->where('financial_movement.transaction_date >=', $start_date)
        ->where('financial_movement.transaction_date <=', $end_date)
        ->where('financial_movement.deleted_at', null) // NULL olan deleted_at kayıtlarını getirir
        ->orderBy('financial_movement.transaction_date', 'ASC')
        ->orderBy('financial_movement_id', 'ASC')
        
        ->findAll();
    
    // Hareket detaylarını doldur
    $row = 10;
    $bakiye = 0; // En son işlemden başlayarak bakiye hesaplanacak

    // Excel şablonunu yükle
    $template = 'tikoportal_cari_satirli.xlsx';
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);
    $sheet = $spreadsheet->getActiveSheet();

    

    // Tüm hücrelerin font boyutunu 6px yap
    $sheet->getStyle('A10:L1000')->getFont()->setSize(6);

    // Başlık satırı stilini ayarla (9. satır)
    $headerStyle = [
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'd9d9d9']
        ],
        'font' => [
            'bold' => true,
            'size' => 6
        ],
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000']
            ]
        ]
    ];
    $sheet->getStyle('A9:L9')->applyFromArray($headerStyle);

    // Alternatif satır renkleri için stil tanımla
    $styleArray = [
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'd9d9d9'] // Açık gri arka plan
        ]
    ];

    // Firma bilgilerini doldur
    $sheet->setCellValue('B2', ": " .   session()->get('user_item')['firma_adi']);
    $sheet->setCellValue('B3', ": " . session()->get('user_item')['firma_adi']);
    $sheet->setCellValue('B4', date('d.m.Y', strtotime('-'.$days.' days')) . ' - ' . date('d.m.Y'));
    $sheet->setCellValue('L2',  date('d.m.Y'));
    $sheet->setCellValue('L3',  date('H:i:s'));
    // Cari bilgilerini doldur


    // Rapor tarih ve sayfa bilgilerini doldur
    $sheet->setCellValue('K2', ": " . date('d.m.Y'));
    $sheet->setCellValue('K3', ": " . date('H:i:s'));
    $sheet->setCellValue('K4', ": " . '1 / ' . ceil(count($financial_movement_items) / 20));

    try {
        // Önce birleştirilecek hücreleri temizle
        $sheet->setCellValue('I5', '');
        $sheet->setCellValue('J5', '');
        $sheet->setCellValue('K5', '');
        $sheet->setCellValue('L5', '');

        $sheet->setCellValue('B5', '');
        $sheet->setCellValue('C5', '');
        $sheet->setCellValue('D5', '');
        $sheet->setCellValue('E5', '');

        $sheet->setCellValue('B6', '');
        $sheet->setCellValue('C6', '');
        $sheet->setCellValue('D6', '');
        $sheet->setCellValue('E6', '');
        
        $sheet->setCellValue('I6', '');
        $sheet->setCellValue('J6', '');
        $sheet->setCellValue('K6', '');
        $sheet->setCellValue('L6', '');
        
        $sheet->setCellValue('I7', '');
        $sheet->setCellValue('J7', '');
        $sheet->setCellValue('K7', '');
        $sheet->setCellValue('L7', '');



        
        // Hücreleri birleştir
        if (!$sheet->getMergeCells()) {
            $sheet->mergeCells('I5:L5');
            $sheet->mergeCells('I6:L6');
            $sheet->mergeCells('B5:E5');
            $sheet->mergeCells('B6:E6');
            $sheet->mergeCells('I7:L7');
            
        }
        
        // Birleştirilmiş hücrelere değer yaz
        $sheet->setCellValue('I5', ": " . $cari_item['cari_phone'] ?? '');
        $sheet->setCellValue('I6', ": " . $cari_item['cari_email'] ?? '');
        $sheet->setCellValue('I7', ": " . $cari_item['address'] ?? '');
        $sheet->setCellValue('B5', ": " . $cari_item['invoice_title'] == '' ? $cari_item['name'] . ' ' . $cari_item['surname'] : $cari_item['invoice_title']);
        $sheet->setCellValue('B6', ": " . $cari_item['identification_number']);
        
   
    } catch (\Exception $e) {
        // Hata durumunda birleştirme olmadan devam et
        $sheet->setCellValue('I5', ": " . $cari_item['cari_phone'] ?? '');
        $sheet->setCellValue('I6', ": " . $cari_item['cari_email'] ?? '');
        $sheet->setCellValue('I7', ": " . $cari_item['address'] ?? '');
    }


    $sheet->setCellValue('A1',  $cari_item['invoice_title'] == '' ? $cari_item['name'] . ' ' . $cari_item['surname'] : $cari_item['invoice_title']  . " - CARİ EKSTRESİ");

    // Hareket detaylarını doldur
    $row = 10;
    $bakiye = 0; //$cari_item['cari_balance'];
    $totalSatir = count($financial_movement_items);


    // Tahsilat için açık yeşil arka plan
    $collectionStyle = [
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'e6ffe6'] // Açık yeşil
        ]
    ];

    // Ödeme için açık kırmızı arka plan
    $paymentStyle = [
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'ffe6e6'] // Açık kırmızı
        ]
    ];

    foreach ($financial_movement_items as $index => $movement) {
        
     


        $transaction_types = [
            'incoming_invoice' => 'Gelen Fatura',
            'outgoing_invoice' => 'Giden Fatura',
            'collection' => 'Tahsilat',
            'check_bill' => "Çek/Senet",
            'payment' => 'Ödeme',
            'outgoing_gider' => 'Gider',
            'incoming_gider' => 'Gider',
            'starting_balance' => 'Başlangıç Bakiyesi',
            'borc_alacak' => 'Borç/Alacak İşlemi',
        ];

        $transaction_type = $transaction_types[$movement['transaction_type']];

        if($movement["transaction_type"] != "collection" && $movement["invoice_id"] > 0){
            $FaturaSatir = $this->modelInvoiceRow
                ->join("unit", "unit.unit_id = invoice_row.unit_id")
                ->where('invoice_id', $movement['invoice_id'])->findAll();
            
            // Satır bakiyesi ana bakiyeden başlamalı
            $satir_bakiye = 0;
            
            foreach($FaturaSatir as $satir){


                if($movement["invoice_no"] != null){
                    $invoice_no = $movement["invoice_no"];
                }else{
                    $invoice_no = $movement["transaction_prefix"] . str_pad($movement["transaction_counter"], 6, "0", STR_PAD_LEFT);
                }
        
              


                $sheet->setCellValue('A' . $row, date('d.m.Y', strtotime($movement['transaction_date'])));
                $sheet->setCellValue('B' . $row, $invoice_no);
                $sheet->setCellValue('C' . $row, '-');
                $sheet->setCellValue('D' . $row, $transaction_type);
                $sheet->setCellValue('E' . $row, $cari_item['cari_code']);
                $sheet->setCellValue('F' . $row, $satir['stock_title']);
                $sheet->setCellValue('G' . $row, number_format(($satir['unit_price'] + $satir["tax_price"]), 2, ',', '.') . " " . $cari_item['money_code'] . ' x ' . number_format($satir['stock_amount'], 2, ',', '.') . " " . $satir['unit_title'] );
                $sheet->setCellValue('H' . $row, $cari_item['money_code']);
                
                // İşlem tipine göre borç/alacak yerleştirmesi
                switch($movement['transaction_type']) {
                    case 'outgoing_invoice': // Giden Fatura - Borçta göster
                    case 'payment': // Tahsilat - Borçta göster
                        $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                        $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->setCellValueExplicit('I' . $row, abs($satir['total_price']), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                        $sheet->setCellValue('J' . $row, '');
                        $satir_bakiye += abs($satir['total_price']);
                        
                        break;
                        
                    case 'incoming_invoice': // Gelen Fatura - Alacakta göster
                    case 'collection': // Ödeme - Alacakta göster
                    case 'outgoing_gider': // Gider
                    case 'incoming_gider': // Gider
                        $sheet->setCellValue('I' . $row, '');
                        $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                        $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->setCellValueExplicit('J' . $row, abs($satir['total_price']), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                        $satir_bakiye -= abs($satir['total_price']);
                        break;
                        
                    case 'starting_balance':
                    case 'borc_alacak':
                        if ($satir['total_price'] < 0) {
                            // Negatif değer - Alacakta göster
                            $sheet->setCellValue('I' . $row, '');
                            $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                            $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                            $sheet->setCellValueExplicit('J' . $row, abs($satir['total_price']), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            $satir_bakiye -= abs($satir['total_price']);
                            
                        } else {
                            // Pozitif değer - Borçta göster
                            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                            $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                            $sheet->setCellValueExplicit('I' . $row, $satir['total_price'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            $sheet->setCellValue('J' . $row, '');
                            $satir_bakiye += $satir['total_price'];
                        }
                        break;
                }
                
                // Sayısal değerler için format
                $numericFormat = '#,##0.00';
                
                // Borç tutarı formatı
                if (!empty($satir['total_price'])) {
                    $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode($numericFormat);
                    $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }
                
                // Alacak tutarı formatı
                if (!empty($satir['total_price'])) {
                    $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode($numericFormat);
                    $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }
                
                // Bakiye tutarı formatı - Kalın yazı
                $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('K' . $row)->getFont()->setBold(true);
                $sheet->setCellValueExplicit('K' . $row, $satir["total_price"], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                
                // B/A göstergesi
                $sheet->setCellValue('L' . $row, $satir["total_price"] >= 0 ? 'B' : 'A');
                $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $row++;
            }
            
           
            
        }else{
             

            if ($movement['transaction_type'] == 'collection') {
                $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($collectionStyle);
            } else if ($movement['transaction_type'] == 'payment') {
                $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($paymentStyle);
            } else {
                $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($styleArray);
            }
   
           
      
        
        }

        if($movement["transaction_type"] != "collection" && $movement["invoice_id"] > 0){

            if ($movement['transaction_type'] == 'collection') {
                $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($collectionStyle);
            } else if ($movement['transaction_type'] == 'payment') {
                $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($paymentStyle);
            } else {
                $sheet->getStyle('A'.$row.':L'.$row)->applyFromArray($styleArray);
            }
           
        }

        $transaction_amounts_satir = 0;
        if($movement["money_unit_id"] == $cari_item["money_unit_id"]){

            $transaction_amounts_satir = $movement['transaction_amount'];

        }else{
            if($movement["money_unit_id"] != 3){
                $transaction_amounts_satir = $movement["amount_to_be_paid_try"];
            }else{
                $transaction_amounts_satir = $movement["amount_to_be_paid"];
            }

            
            
        }

        $sheet->setCellValue('A' . $row, date('d.m.Y', strtotime($movement['transaction_date'])));
        $sheet->setCellValue('B' . $row, $movement['transaction_prefix'] . str_pad($movement['transaction_counter'], 6, "0", STR_PAD_LEFT));
        $sheet->setCellValue('C' . $row, '-');
        $sheet->setCellValue('D' . $row, $transaction_type);
        $sheet->setCellValue('E' . $row, $cari_item['cari_code']);
        $sheet->setCellValue('F' . $row, $cari_item['invoice_title']);
                // G sütununa açıklama yazılmadan önce metni düzenle
        $description = $movement['transaction_description'];

        // 1. Yöntem: HTML etiketlerini temizle ve özel karakterleri dönüştür
        $description = strip_tags(html_entity_decode($description));
        $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

        // 2. Yöntem: Maksimum karakter sınırı koy
        $description = mb_substr($description, 0, 30, 'UTF-8'); // İlk 100 karakter

        // 3. Yöntem: Satır sonlarını temizle
        $description = str_replace(["\r", "\n"], ' ', $description);

        // 4. Yöntem: Sadece belirli karakterlere izin ver
        $description = preg_replace('/[^a-zA-Z0-9\s\-_.üğışçöÜĞİŞÇÖ]/u', '', $description);

        // Tüm yöntemleri birleştirerek:
        $description = strip_tags(html_entity_decode($movement['transaction_description']));
        $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
        $description = str_replace(["\r", "\n"], ' ', $description);
        $description = mb_substr($description, 0, 30, 'UTF-8');
        $description = trim($description);

        // Düzenlenmiş metni hücreye yaz
        $sheet->setCellValue('G' . $row, $description ?: '-');

        $sheet->setCellValue('H' . $row, $cari_item['money_code']);
        
        // İşlem tipine göre borç/alacak yerleştirmesi
        switch($movement['transaction_type']) {
            case 'outgoing_invoice': // Giden Fatura - Borçta göster
            case 'payment': // Tahsilat - Borçta göster
                $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValueExplicit('I' . $row, abs($transaction_amounts_satir), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                $sheet->setCellValue('J' . $row, '');
                $bakiye += abs($transaction_amounts_satir);
                
                break;
                
            case 'incoming_invoice': // Gelen Fatura - Alacakta göster
            case 'collection': // Ödeme - Alacakta göster
            case 'outgoing_gider': // Gider
            case 'incoming_gider': // Gider
                $sheet->setCellValue('I' . $row, '');
                $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValueExplicit('J' . $row, abs($transaction_amounts_satir), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                $bakiye -= abs($transaction_amounts_satir);
                break;
                
            case 'starting_balance':
            case 'borc_alacak':
                if ($transaction_amounts_satir < 0) {
                    // Negatif değer - Alacakta göster
                    $sheet->setCellValue('I' . $row, '');
                    $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                    $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValueExplicit('J' . $row, abs($transaction_amounts_satir), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                    $bakiye -= abs($transaction_amounts_satir);
                    
                } else {
                    // Pozitif değer - Borçta göster
                    $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                    $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValueExplicit('I' . $row, $transaction_amounts_satir, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                    $sheet->setCellValue('J' . $row, '');
                    $bakiye += $transaction_amounts_satir;
                }
                break;
        }
        
        // Sayısal değerler için format
        $numericFormat = '#,##0.00';
        
        // Borç tutarı formatı
        if (!empty($transaction_amounts_satir)) {
            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode($numericFormat);
            $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        }
        
        // Alacak tutarı formatı
        if (!empty($transaction_amounts_satir)) {
            $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode($numericFormat);
            $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        }
        
        // Bakiye tutarı formatı - Kalın yazı
        $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('K' . $row)->getFont()->setBold(true);
        $sheet->setCellValueExplicit('K' . $row, $bakiye, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        
        // B/A göstergesi
        $sheet->setCellValue('L' . $row, $bakiye >= 0 ? 'B' : 'A');
        $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $row++;

       
    }
   

                     // foreach döngüsünden SONRA ekleyin (döngünün dışında)
                     $lastRow = $row; // Son satırın bir sonraki satır numarası

                     // A'dan L'ye kadar olan hücreleri birleştir
                     $sheet->mergeCells('A' . $lastRow . ':L' . $lastRow);
     
                     // Birleştirilmiş hücreye metni ekle ve formatla
                     $sheet->setCellValue('A' . $lastRow, '*Bu döküman tikoportal.com üzerinden hazırlanmıştır.');
                     $sheet->getStyle('A' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                     $sheet->getStyle('A' . $lastRow)->getFont()->setItalic(true); // İtalik yazı tipi
                     $sheet->getStyle('A' . $lastRow)->getFont()->setSize(6); // Font boyutu
     

    // Tampon temizle
    ob_end_clean();

    if($type == "excel"){   

         // Excel dosyasını oluştur
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'cari_full_ekstre_' . date('Y_m_d-H_i') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;

    }else{

         // Excel'i PDF'e çevirmek için gerekli writer'ı tanımla
         $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
         $filename = 'cari_full_ekstre_' . date('Y_m_d-H_i') . '.pdf';
         header('Content-Type: application/pdf');
         header('Content-Disposition: attachment;filename="' . $filename . '"');
         header('Cache-Control: max-age=0');
         $writer->save('php://output');
         exit;

    }
       
}
    
    public function getNotes($note_type = 'all')
    {
        $modelNotes = $this->modelNotes->where('user_id', session()->get('user_id'));

        if ($note_type == 'all') {
            $note_items = $modelNotes->findAll();
        } elseif ($note_type == 'invoice') {
            $note_items = $modelNotes->where('note_type', 'invoice')->findAll();
        } elseif ($note_type == 'order') {
            $note_items = $modelNotes->where('note_type', 'order')->findAll();
        } elseif ($note_type == 'offer') {
            $note_items = $modelNotes->where('note_type', 'offer')->findAll();
        } else {
            return redirect()->back();
        }

        echo json_encode(['icon' => 'success', 'message' => 'Notlar başarıyla getirildi.', 'note_items' => json_encode($note_items)]);
        return;
    }

    use ResponseTrait;

    public function getCustomers($customer_type = 'all')
    {
        $builder = $this->modelCari
            ->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
            ->select('cari.user_id,
            cari_id,
            cari_code,
            cari.money_unit_id,
            identification_number,
            tax_administration,
            invoice_title,
            name,
            surname,
            obligation,
            company_type,
            cari_phone,
            cari_email,
            cari_balance,
            is_customer,
            is_supplier,
            is_export_customer,money_unit.money_icon')
            ->where('cari.user_id', session()->get('user_id'))
            ->where('cari.cari_id !=', $this->stok_sayim)
            ->where('cari.deleted_at IS NULL', null, false);
        

        if ($customer_type == 'all') {
            $builder = $builder;
        } elseif ($customer_type == 'customer') {
            $builder = $this->modelCari->where('cari.is_customer', 1);
        } elseif ($customer_type == 'supplier') {
            $builder = $this->modelCari->where('cari.is_supplier', 1);
        } else {
            return redirect()->back();
        }

        return DataTable::of($builder)->filter(function ($builder, $request) {

            if ($request->cari_status == "Borçlu")
                $builder->where('cari_balance >', 0);
            $builder->orderBy("cari_balance", "DESC");

            if ($request->cari_status == "Alacaklı")
                $builder->where('cari_balance <', 0);
                $builder->orderBy("cari_balance", "DESC");
        })

            ->setSearchableColumns(['cari.invoice_title', 'cari.name', 'cari.surname'])
            ->toJson(true);
    }

    public function detailedSearchCustomer()
    {
        if ($this->request->getMethod('true') == 'POST') {
            $pager = \Config\Services::pager();


            $search = $this->request->getPost('search');

            $pageSize = $this->request->getPost('pageSize') ?? 5;
            $page = 1;
            $fromWhere = $this->request->getPost('fromWhere') ?? 'product';


            $cari_items = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
                // ->select('category.category_title, type.type_title, buy_unit.unit_title as buy_unit_title, sale_unit.unit_title as sale_unit_title, stock.*, money_unit.money_icon as sale_money_icon')
                ->where('cari.user_id', session()->get('user_id'))->where('cari.deleted_at IS NULL', null, false);

            $filters = '&pageSize=' . $pageSize;
            if ($search && strlen($search) > 3) {

                if ($fromWhere == 'onlyCustomers') {
                    $cari_items = $this->modelCari
                        ->where('cari.is_customer', 1)
                        ->where('cari.cari_id !=', $this->stok_sayim)
                        ->where('cari.deleted_at IS NULL')
                        ->groupStart()
                        ->like('cari.invoice_title', str_replace("#", "", $search))
                        ->orLike('cari.cari_code', str_replace("#", "", $search))
                        ->orLike('cari.name', str_replace("#", "", $search))
                        ->orLike('cari.surname', str_replace("#", "", $search))
                        ->orLike('cari.cari_phone', str_replace("#", "", $search))
                        ->groupEnd();
                } else {
                    $cari_items = $this->modelCari
                        ->groupStart()
                        ->like('cari.invoice_title', str_replace("#", "", $search))
                        ->orLike('cari.cari_code', str_replace("#", "", $search))
                        ->orLike('cari.name', str_replace("#", "", $search))
                        ->orLike('cari.surname', str_replace("#", "", $search))
                        ->orLike('cari.cari_phone', str_replace("#", "", $search))
                        ->groupEnd()
                        ->where('cari.cari_id !=', $this->stok_sayim)
                        ->where('cari.deleted_at IS NULL');
                }

                $filters .= '&search=' . $search;
            } else {
                $cari_items = $this->modelCari->where('cari.cari_id', 0);
                $filters .= '&search=' . 'q';
            }

            $cari_items = $this->modelCari->paginate($pageSize, 'default', $page);
            // session()->setFlashdata('pagination_filters', $filters);
            $pager->setPath('tportal/invoice/create');

            // print_r($cari_items);
            // return;

            $data = [
                'cari_items' => $cari_items,
                'pager' => $pager->links()
            ];


            echo json_encode(['icon' => 'success', 'message' => 'Arama sonuçları başarıyla getirildi.', 'data' => $data]);
            return;
        } else {
            return redirect()->back();
        }
    }


    public function detailedSearchTedarik()
    {
        if ($this->request->getMethod('true') == 'POST') {
            $pager = \Config\Services::pager();


            $search = $this->request->getPost('search');

            $pageSize = $this->request->getPost('pageSize') ?? 5;
            $page = 1;
            $fromWhere = $this->request->getPost('fromWhere') ?? 'product';


            $cari_items = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
                // ->select('category.category_title, type.type_title, buy_unit.unit_title as buy_unit_title, sale_unit.unit_title as sale_unit_title, stock.*, money_unit.money_icon as sale_money_icon')
                ->where('cari.user_id', session()->get('user_id'))->where('cari.deleted_at IS NULL', null, false);

            $filters = '&pageSize=' . $pageSize;
            if ($search && strlen($search) > 3) {

                if ($fromWhere == 'onlyCustomers') {
                    $cari_items = $this->modelCari
                        ->where('cari.is_supplier', 1)
                        ->where('cari.cari_id !=', $this->stok_sayim)
                        ->where('cari.deleted_at IS NULL')
                        ->groupStart()
                        ->like('cari.invoice_title', str_replace("#", "", $search))
                        ->orLike('cari.cari_code', str_replace("#", "", $search))
                        ->orLike('cari.name', str_replace("#", "", $search))
                        ->orLike('cari.surname', str_replace("#", "", $search))
                        ->orLike('cari.cari_phone', str_replace("#", "", $search))
                        ->groupEnd();
                } 

                $filters .= '&search=' . $search;
            } else {
                $cari_items = $this->modelCari->where('cari.cari_id', 0);
                $filters .= '&search=' . 'q';
            }

            $cari_items = $this->modelCari->paginate($pageSize, 'default', $page);
            // session()->setFlashdata('pagination_filters', $filters);
            $pager->setPath('tportal/invoice/create');

            // print_r($cari_items);
            // return;

            $data = [
                'cari_items' => $cari_items,
                'pager' => $pager->links()
            ];


            echo json_encode(['icon' => 'success', 'message' => 'Arama sonuçları başarıyla getirildi.', 'data' => $data]);
            return;
        } else {
            return redirect()->back();
        }
    }
    public function list($cari_type = 'all')
    {
        $modelCari = $this->modelCari->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id !=', $this->stok_sayim)->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id');
        if ($cari_type == 'all') {
            $page_title = "Tüm Cariler";
            $cari_items = $modelCari->findAll();
        } elseif ($cari_type == 'customer') {
            $page_title = "Müşteriler";
            $cari_items = $modelCari->where('is_customer', 1)->findAll();
        } elseif ($cari_type == 'supplier') {
            $page_title = "Tedarikçiler";
            $cari_items = $modelCari->where('is_supplier', 1)->findAll();
        } else {
            return redirect()->back();
        }


        $data = [
            'page_title' => $page_title,
            'cari_items' => $cari_items,
        ];

        return view('tportal/cariler/index', $data);
    }

    public function detail($cari_id)
    {
        $cari_item = $this->modelCari->join('address', 'address.cari_id = cari.cari_id')
            ->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
            ->where('cari.user_id', session()->get('user_id'))
            ->where('cari.cari_id', $cari_id)
            ->where('cari.cari_id !=', $this->stok_sayim)
            ->where('address.status', 'active')
            ->where('address.default', 'true')
            ->first();
            $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
            $cari_item["dolarKur"] = $MoneyUnitsDolar["money_value"];
            $cari_item["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
            $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
            $cari_item["euroKur"] = $MoneyUnitsEuro["money_value"];
            $cari_item["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];

        $data = [
            'cari_item' => $cari_item,
        ];

        return view('tportal/cariler/detay/detay', $data);
    }

    public function create()
    {




        $transaction_prefix = "TRNSCTN";
        if ($this->request->getMethod('true') == 'POST') {

            try {
                $is_customer = $this->request->getPost('is_customer');
                $is_supplier = $this->request->getPost('is_supplier');
                $is_export_customer = $this->request->getPost('is_export_customer');

                $is_customer = $is_customer == 'on' ? 1 : 0;
                $is_supplier = $is_supplier == 'on' ? 1 : 0;
                $is_export_customer = $is_export_customer == 'on' ? 1 : 0;

                $identification_number = $this->request->getPost('identification_number');
                $tax_administration = $this->request->getPost('tax_administration');
                $invoice_title = $this->request->getPost('invoice_title');
                $name = $this->request->getPost('name');
                $surname = $this->request->getPost('surname');
                $obligation = $this->request->getPost('obligation');
                $company_type = $this->request->getPost('company_type');
                $cari_phone = $this->request->getPost('cari_phone');
                $area_code = $this->request->getPost('area_code');
                $cari_email = $this->request->getPost('cari_email');
                $money_unit_id = $this->request->getPost('money_unit_id');

                $starting_balance = $this->request->getPost('starting_balance');
                $starting_balance_date = $this->request->getPost('starting_balance_date');

                $cari_note = $this->request->getPost('cari_note');

                // $starting_balance_date = $starting_balance_date ? convert_datetime_for_sql($starting_balance) : current_time();
                $starting_balance_date = $starting_balance_date ? convert_datetime_for_sql($starting_balance_date) : date('Y-m-d H:i:s');
                $starting_balance = convert_number_for_sql($starting_balance);
                $cari_balance = $starting_balance;

                $address = $this->request->getPost('address');
                $address_country = $this->request->getPost('address_country');
                $address_city = $this->request->getPost('address_city_name');   // il verir
                $address_city_plate = $this->request->getPost('address_city');  // plaka verir
                $address_district = $this->request->getPost('address_district');
                $zip_code = $this->request->getPost('zip_code');

                //gelen telefon numarasını temizledikten sonra alan kodunun yanına bir boşluk bıraktıktan sonra telefon numarasını kaydediyoruz.
                //telefon numarasını ekrana yazdırmak isterken boşluğu göre split ettikten sonra yazdırabiliriz.
                $phone = str_replace(array('(', ')', ' '), '', $cari_phone);
                $phoneNumber = $cari_phone ? $area_code . " " . $phone : null;

                //8 rakamlı cari kodu
                $create_cari_code = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);

                $form_data = [
                    'user_id' => session()->get('user_id'),
                    'cari_code' => $create_cari_code,
                    'money_unit_id' => $money_unit_id,
                    'identification_number' => $identification_number,
                    'tax_administration' => $tax_administration != '' ? $tax_administration : null,
                    'invoice_title' => $invoice_title == '' ? $name . ' ' . $surname : $invoice_title,
                    'name' => $name,
                    'surname' => $surname,
                    'obligation' => $obligation != '' ? $obligation : null,
                    'company_type' => $company_type != '' ? $company_type : null,
                    'cari_phone' => $phoneNumber,
                    'cari_email' => $cari_email != '' ? $cari_email : null,
                    'cari_balance' => $cari_balance,
                    'cari_note' => $cari_note,
                    'is_customer' => $is_customer,
                    'is_supplier' => $is_supplier,
                    'is_export_customer' => $is_export_customer,
                ];
                $this->modelCari->insert($form_data);
                $cari_id = $this->modelCari->getInsertID();

                if ($starting_balance != null && $starting_balance != 0 && $starting_balance != '') {
                    $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                    if ($last_transaction) {
                        $transaction_counter = $last_transaction['transaction_counter'] + 1;
                    } else {
                        $transaction_counter = 1;
                    }
                    $transaction_number = $transaction_prefix . str_pad($transaction_counter, 8, '0', STR_PAD_LEFT);

                    [$transaction_direction, $starting_balance] = $starting_balance > 0 ? ['exit', $starting_balance * -1] : ['entry', $starting_balance];
                    try {
                        $insert_financial_movement_data = [
                            'user_id' => session()->get('user_id'),
                            'financial_account_id' => null,
                            'cari_id' => $cari_id,
                            'money_unit_id' => $money_unit_id,
                            'transaction_number' => $transaction_number,
                            'transaction_direction' => $transaction_direction,
                            'transaction_type' => 'starting_balance',
                            'transaction_tool' => 'not_payroll',
                            'transaction_title' => 'Açılış Bakiyesi',
                            'transaction_description' => null,
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

                try {
                    $insert_address_data = [
                        'user_id' => session()->get('user_id'),
                        'cari_id' => $cari_id,
                        'address_title' => 'Fatura Adresi',
                        'address_country' => $address_country,
                        'address_city' => $address_city,
                        'address_city_plate' => $address_city_plate,
                        'address_district' => $address_district,
                        'zip_code' => $zip_code,
                        'address' => $address,
                        'address_phone' => $phoneNumber,
                        'address_email' => $cari_email,
                        'status' => 'active',
                        'default' => 'true'
                    ];
                    $this->modelAddress->insert($insert_address_data);
                } catch (\Exception $e) {
                    $this->logClass->save_log(
                        'error',
                        'address',
                        null,
                        null,
                        'create',
                        $e->getMessage(),
                        json_encode($_POST)
                    );
                    echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                    return;
                }

                echo json_encode(['icon' => 'success', 'message' => 'Cari başarıyla oluşturuldu.', 'new_cari_id' => $this->modelCari->getInsertID()]);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'cari',
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
                'money_unit_items' => $money_unit_items
            ];

            return view('tportal/cariler/yeni', $data);
        }
    }

    public function edit($cari_id = null)
    {
        $cari_item = $this->modelCari->where('cari.user_id', session()->get('user_id'))->where('cari_id', $cari_id)->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')->first();
        if (!$cari_item && $cari_id != $this->stok_sayim) {
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
                $is_customer = $this->request->getPost('is_customer');
                $is_supplier = $this->request->getPost('is_supplier');
                $is_export_customer = $this->request->getPost('is_export_customer');

                $is_customer = $is_customer == 'on' ? 1 : 0;
                $is_supplier = $is_supplier == 'on' ? 1 : 0;
                $is_export_customer = $is_export_customer == 'on' ? 1 : 0;

                $identification_number = $this->request->getPost('identification_number');
                $tax_administration = $this->request->getPost('tax_administration');
                $invoice_title = $this->request->getPost('invoice_title');
                $name = $this->request->getPost('name');
                $surname = $this->request->getPost('surname');
                $obligation = $this->request->getPost('obligation');
                $company_type = $this->request->getPost('company_type');
                $area_code = $this->request->getPost('area_code');
                $cari_phone = $this->request->getPost('cari_phone');
                $cari_email = $this->request->getPost('cari_email');
                $money_unit_id = $this->request->getPost('money_unit_id');
                $cari_note = $this->request->getPost('cari_note');

                $phone = str_replace(array('(', ')', ' '), '', $cari_phone);
                $phoneNumber = $cari_phone ? $area_code . " " . $phone : null;

               

                $form_data = [
                    'money_unit_id' => $money_unit_id,
                    'identification_number' => $identification_number,
                    'tax_administration' => $tax_administration,
                    'invoice_title' => $invoice_title,
                    'name' => $name,
                    'surname' => $surname,
                    'obligation' => $obligation,
                    'company_type' => $company_type,
                    'cari_phone' => $phoneNumber,
                    'cari_email' => $cari_email,
                    'cari_note' => $cari_note,
                    'is_customer' => $is_customer,
                    'is_supplier' => $is_supplier,
                    'is_export_customer' => $is_export_customer,
                ];

             
               $data =  $this->modelCari->update($cari_item['cari_id'], $form_data);

             

                echo json_encode(['icon' => 'success', 'message' => 'Cari başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'cari',
                    $cari_id,
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

            $money_item = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))
                ->where('money_unit_id', $cari_item['money_unit_id'])
                ->where('status', 'active')
                ->first();

            $data = [
                'cari_item' => $cari_item,
                'money_unit_items' => $money_unit_items,
                'money_item' => $money_item,
            ];

            return view('tportal/cariler/detay/duzenle', $data);
        }
    }

    public function delete($cari_id = null)
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $cari_item = $this->modelCari->where('user_id', session()->get('user_id'))->where('cari_id', $cari_id)->first();

                if (!$cari_item && $cari_id != $this->stok_sayim) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen cari bulunamadı.']);
                    return;
                }

                $this->modelCari->delete($cari_item['cari_id']);

                echo json_encode(['icon' => 'success', 'message' => 'Cari başarıyla silindi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'cari',
                    $cari_id,
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


    public function createPaymentOrCollectionPage()
    {
        # Burada cari item yollamamızın sebebi sol menü kısmında cariyi kullanıyor olmamız.
        # Bu işlemlerin bu controllerda yapılmasının sebebi de bu. Stok kısmındaki galeri ve reçete kısımlarıyla benzer çalışıyor.
        $cari_items = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
            ->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id !=', $this->stok_sayim)->findAll();


        $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
        $cari_itemd["dolarKur"] = $MoneyUnitsDolar["money_value"];
        $cari_itemd["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
        $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
        $cari_itemd["euroKur"] = $MoneyUnitsEuro["money_value"];
        $cari_itemd["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];



        $all_money_unit = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();

        $financial_account_items = $this->modelFinancialAccount->table('`financial_account`')
            ->select('financial_account_id, money_unit.money_unit_id, account_title, account_type, bank_id, money_code')
            ->join('money_unit', 'financial_account.money_unit_id = money_unit.money_unit_id')
            ->findAll();

        $data = [
            'cari_itemd' => $cari_itemd,
            'cari_items' => $cari_items,
            'financial_account_items' => $financial_account_items,
            'bank_items' => session()->get('bank_items'),
            'all_money_unit' => $all_money_unit,
        ];

        return view('tportal/cariler/tahsilat_odeme', $data);
    }

    public function createPaymentOrCollection($cari_id = null)
    {
        # Burada cari item yollamamızın sebebi sol menü kısmında cariyi kullanıyor olmamız.
        # Bu işlemlerin bu controllerda yapılmasının sebebi de bu. Stok kısmındaki galeri ve reçete kısımlarıyla benzer çalışıyor.
        $cari_item = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
            ->where('cari.user_id', session()->get('user_id'))
            ->where('cari.cari_id !=', $this->stok_sayim)
            ->where('cari.cari_id', $cari_id)->first();
        if (!$cari_item) {
            return view('not-found');
        }
        $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
        $cari_item["dolarKur"] = $MoneyUnitsDolar["money_value"];
        $cari_item["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
        $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
        $cari_item["euroKur"] = $MoneyUnitsEuro["money_value"];
        $cari_item["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];

        $has_starting_balance = 0;

        $starting_balance_item = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->where('cari_id', $cari_item['cari_id'])->first();
        if ($starting_balance_item) {
            $has_starting_balance = 1;
        }

        // print_r($has_starting_balance);
        // return;


        $all_money_unit = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();

        $financial_account_items = $this->modelFinancialAccount->table('`financial_account`')
            ->select('financial_account_id, money_unit.money_unit_id, account_title, account_type, bank_id, money_code')
            ->join('money_unit', 'financial_account.money_unit_id = money_unit.money_unit_id')
            ->findAll();

        $data = [
            'cari_item' => $cari_item,
            'financial_account_items' => $financial_account_items,
            'bank_items' => session()->get('bank_items'),
            'all_money_unit' => $all_money_unit,
            'starting_balance_item' => $has_starting_balance,
        ];

        return view('tportal/cariler/detay/tahsilat_odeme', $data);
    }


 
 

    public function storePaymentOrCollection($cari_id)
    {


  
        #TODO: number_helper içerisine mutlak değer alan bir fonksiyon yazılarak hareketlere hiçbir değerin
        #      eksili olmaması sağlanacak. Şu anda validasyon yapılmıyor.
        $transaction_prefix = "PRF";
        $tahsilat_prefix = "THS";
        $odeme_prefix = "ODM";

        $islem_kuru = $this->request->getPost("islem_kuru");
        $kur_degeri = $this->request->getPost("donusturulecek_kur");
        $toplam_aktarilacak = $this->request->getPost("toplam_kur");
        $financial_account_id_kur = $this->request->getPost("financial_account_id");

        

        if(!empty($islem_kuru)):
        $Virman = $this->modelMoneyUnit->where("money_code", $islem_kuru)->first();

        $FinansVirman = $this->modelFinancialAccount->where("financial_account_id", $financial_account_id_kur)->first();
        endif;

        $CariHesap = $this->modelCari->where("cari_id", $cari_id)->where('cari.cari_id !=', $this->stok_sayim)->first();
        $CariHesapMoney = $this->modelMoneyUnit->where("money_unit_id", $CariHesap["money_unit_id"])->first();
        $CariHesapFinans = $this->modelFinancialAccount->where("money_unit_id", $CariHesapMoney["money_unit_id"])->first();

   
      
        $prefix = "";

        if ($this->request->getMethod('true') == 'POST') {
            try {
                $cari_item = $this->modelCari->where('user_id', session()->get('user_id'))->where('cari_id', $cari_id)->first();
                if (!$cari_item && $cari_id != $this->stok_sayim) {
                    return view('not-found');
                }


                $money_unit_id = $this->request->getPost('money_unit_id');
                $transaction_type = $this->request->getPost('transaction_type');
                $transaction_title = $this->request->getPost('transaction_title');
                $transaction_description = $this->request->getPost('transaction_description');
                $borc_alacak = convert_number_for_sql($this->request->getPost('borc_alacak'));
                $sb_transaction_amount = convert_number_for_sql($this->request->getPost('sb_transaction_amount'));
                $transaction_amount = convert_number_for_sql($this->request->getPost('transaction_amount'));
                # Henüz bu kısıma işlem ücreti eklemedik.
                $transaction_real_amount = convert_number_for_sql($transaction_amount);
                $transaction_date = $this->request->getPost('transaction_date');
                $transaction_dates = $this->request->getPost('transaction_dates');
                # Eğer hata verirse date("Y-m-d H:i:s") OR date("Y-m-d H:i:s", $transaction_date)

                $financial_account_id = $this->request->getPost('financial_account_id');
                $financial_account_item = $this->modelFinancialAccount->where('user_id', session()->get('user_id'))->where('financial_account_id', $financial_account_id)->first();
                if (!$financial_account_item && ($transaction_type != 'starting_balance') && ($transaction_type != 'borc_alacak')) {
                    echo json_encode(['icon' => 'error', 'message' => 'Kasa bulunamadı.']);
                    return;
                }

                // print_r($transaction_amount);
                // return;

                $dateParts = explode('/', $transaction_date);
                if (count($dateParts) == 3) {
                    $day = $dateParts[0];
                    $month = $dateParts[1];
                    $year = $dateParts[2];

                    date_default_timezone_set('Europe/Istanbul');

                    $currentDateTime = new DateTime();
                    $timezone = new DateTimeZone('Europe/Istanbul');
                    $currentDateTime->setTimezone($timezone);

                    $hour = $currentDateTime->format('H');
                    $minute = $currentDateTime->format('i');
                    $second = $currentDateTime->format('s');

                    $transactionDate = date("$year-$month-$day $hour:$minute:$second");
                    // echo $transactionDate;
                    // exit;
                }

         
                if ($transaction_type == 'starting_balance') {


                    $dateParts = explode('/', $transaction_dates);
                    if (count($dateParts) == 3) {
                        $day = $dateParts[0];
                        $month = $dateParts[1];
                        $year = $dateParts[2];
    
                        date_default_timezone_set('Europe/Istanbul');
    
                        $currentDateTime = new DateTime();
                        $timezone = new DateTimeZone('Europe/Istanbul');
                        $currentDateTime->setTimezone($timezone);
    
                        $hour = $currentDateTime->format('H');
                        $minute = $currentDateTime->format('i');
                        $second = $currentDateTime->format('s');
    
                        $transactionDates = date("$year-$month-$day $hour:$minute:$second");
                        // echo $transactionDate;
                        // exit;
                    }

                    $starting_balance_item = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->where('cari_id', $cari_item['cari_id'])->where('transaction_type', 'starting_balance')->first();
                    if ($starting_balance_item) {
                        echo json_encode(['icon' => 'error', 'message' => 'Bu cari için daha önce açılış bakiye eklenmiş.']);
                        return;
                    }

                    [$transaction_direction, $sb_transaction_amount] = $sb_transaction_amount > 0 ? ['exit', $sb_transaction_amount] : ['entry', $sb_transaction_amount];

                    $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                    if ($last_transaction) {
                        $transaction_counter = $last_transaction['transaction_counter'] + 1;
                    } else {
                        $transaction_counter = 1;
                    }
                    $transaction_number = "AB" . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);

                    $insert_financial_movement_data = [
                        'user_id' => session()->get('user_id'),
                        'cari_id' => $cari_item['cari_id'],
                        'money_unit_id' => $cari_item['money_unit_id'],
                        'transaction_number' => $transaction_number,
                        'transaction_direction' => $transaction_direction,
                        'transaction_type' => $transaction_type,
                        'transaction_tool' => 'not_payroll',
                        'transaction_title' => "Açılış Bakiyesi",
                        'transaction_description' => "Tahsilat/Ödeme ekranından girilen açılış bakiyesi hareketi.",
                        'transaction_amount' => $sb_transaction_amount,
                        'transaction_real_amount' => $sb_transaction_amount,
                        'transaction_date' => $transactionDates,
                        'transaction_prefix' => "AB",
                        'transaction_counter' => $transaction_counter
                    ];
                    $this->modelFinancialMovement->insert($insert_financial_movement_data);

                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] + ($sb_transaction_amount)
                    ];
                    $this->modelCari->update($cari_item['cari_id'], $update_cari_data);

                    echo json_encode(['icon' => 'success', 'message' => 'Açılış bakiyesi başarıyla eklendi.']);
                }else 
                if ($transaction_type == 'borc_alacak') {
                    $borc_dates = $this->request->getPost('borc_dates');

                  

                    $dateParts = explode('/', $borc_dates);
                    if (count($dateParts) == 3) {
                        $day = $dateParts[0];
                        $month = $dateParts[1];
                        $year = $dateParts[2];
    
                        date_default_timezone_set('Europe/Istanbul');
    
                        $currentDateTime = new DateTime();
                        $timezone = new DateTimeZone('Europe/Istanbul');
                        $currentDateTime->setTimezone($timezone);
    
                        $hour = $currentDateTime->format('H');
                        $minute = $currentDateTime->format('i');
                        $second = $currentDateTime->format('s');
    
                        $transactionDates = date("$year-$month-$day $hour:$minute:$second");
                        // echo $transactionDate;
                        // exit;
                    }

                    $borc_transaction_title = $this->request->getPost('borc_transaction_title');
                    $borc_transaction_description = $this->request->getPost('borc_transaction_description');


                    [$transaction_direction, $borc_alacak] = $borc_alacak > 0 ? ['exit', $borc_alacak] : ['entry', $borc_alacak];

                    $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                    if ($last_transaction) {
                        $transaction_counter = $last_transaction['transaction_counter'] + 1;
                    } else {
                        $transaction_counter = 1;
                    }
                    $transaction_number = "BAV" . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);

                    $insert_financial_movement_data = [
                        'user_id' => session()->get('user_id'),
                        'cari_id' => $cari_item['cari_id'],
                        'money_unit_id' => $cari_item['money_unit_id'],
                        'transaction_number' => $transaction_number,
                        'transaction_direction' => $transaction_direction,
                        'transaction_type' => $transaction_type,
                        'transaction_tool' => 'not_payroll',
                        'transaction_title' => $borc_transaction_title,
                        'transaction_description' => $borc_transaction_description ?? "Borç Alacak/Verecek ekranından girilen işlem hareketi.",
                        'transaction_amount' => $borc_alacak,
                        'transaction_real_amount' => $borc_alacak,
                        'transaction_date' => $transactionDates,
                        'transaction_prefix' => "BAV",
                        'transaction_counter' => $transaction_counter
                    ];
                    $this->modelFinancialMovement->insert($insert_financial_movement_data);

                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] + ($borc_alacak)
                    ];
                    $this->modelCari->update($cari_item['cari_id'], $update_cari_data);

                    echo json_encode(['icon' => 'success', 'message' => 'Borç Alacak Verecek bakiyesi başarıyla eklendi.']);
                } else {

                    $tahsilat_prefix = "THS";
                    $odeme_prefix = "ODM";
                    #transaction_type validation
                    if ($transaction_type != 'payment' && $transaction_type != 'collection') {
                        echo json_encode(['icon' => 'error', 'message' => "Hatalı işlem tipi"]);
                        return;
                    }
                    [$transaction_direction, $amount_to_be_processed, $prefix] = $transaction_type == 'payment' ? ['exit', $transaction_amount * -1, $odeme_prefix] : ['entry', $transaction_amount, $tahsilat_prefix];


                    $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                    if ($last_transaction) {
                        $transaction_counter = $last_transaction['transaction_counter'] + 1;
                    } else {
                        $transaction_counter = 1;
                    }

                    if($FinansVirman["financial_account_id"] != $CariHesapFinans["financial_account_id"]){
                        
                        $financial_account_ids = $FinansVirman["financial_account_id"];
                        $transaction_amounts = convert_number_for_sql($toplam_aktarilacak);
                        $amount_to_be_processeds = $transaction_amounts;
                        
                        $NotOlustur = '
                            İşlem Kuru  : '.$kur_degeri.' - '.$CariHesapMoney["money_code"].' 
                            İşlem Tutarı: '.$toplam_aktarilacak.'  '.$CariHesapMoney["money_code"].' ( '.$transaction_amount.' '.$Virman["money_code"].' ) 
                            Virman Hesab: '.$FinansVirman["account_title"].'
                        ';


                        $transaction_description.= $NotOlustur;
            

                    }else{
                        $financial_account_ids = $financial_account_id;
                        $transaction_amounts = $transaction_amount;
                        $amount_to_be_processeds = $amount_to_be_processed;


                    }

                    if(!empty($kur_degeri)){
                        $virman  = $transaction_amounts;

                    }else{
                        $virman  = '';

                    }

                   

                    $financial_movements_sum = $this->modelFinancialMovement
                    ->where('cari_id', $cari_item['cari_id'])
                    ->where('transaction_direction !=', 'entry') // Yalnızca giriş hareketleri
                    ->whereNotIn('transaction_type', ['collection', 'incoming_invoice']) // Tahsilat ve alış faturalarını hariç tut
                    ->select('SUM(CASE 
                                    WHEN virman IS NOT NULL THEN virman 
                                    ELSE transaction_amount 
                                END) as total_amount')
                    ->first(); // Toplam finansal hareket tutarını bul
                
                // Eğer finansal hareket bulunduysa
                if ($financial_movements_sum && isset($financial_movements_sum['total_amount'])) {
                    $total_financial_movement_amount = floatval($financial_movements_sum['total_amount']);
                } else {
                    $total_financial_movement_amount = 0; // Eğer hiçbir hareket yoksa, 0
                }
                
                // 2. Collection ve incoming işlemlerini toplama dahil etmeyeceğiz
                $collection_and_incoming_sum = $this->modelFinancialMovement
                    ->where('cari_id', $cari_item['cari_id'])
                    ->whereIn('transaction_type', ['collection', 'incoming_invoice']) // Tahsilat ve alış faturalarını al
                    ->select('SUM(CASE 
                                    WHEN virman IS NOT NULL THEN virman 
                                    ELSE transaction_amount 
                                END) as total_deductions')
                    ->first(); // Toplam tahsilat ve alış faturası tutarlarını bul
                
                if ($collection_and_incoming_sum && isset($collection_and_incoming_sum['total_deductions'])) {
                    $total_deductions = floatval($collection_and_incoming_sum['total_deductions']);
                } else {
                    $total_deductions = 0; // Eğer tahsilat veya alış faturası yoksa, 0
                }
                
                // 3. Cari'nin güncel bakiyesini hesaplayın
                $cari_balance = $total_financial_movement_amount - $total_deductions;

                    


                    $transaction_number = $prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                    $insert_financial_movement_data = [
                        'user_id' => session()->get('user_id'),
                        'financial_account_id' => $financial_account_ids,
                        'cari_id' => $cari_item['cari_id'],
                        'money_unit_id' => $money_unit_id,
                        'virman' => $virman,
                        'transaction_number' => $transaction_number,
                        'transaction_direction' => $transaction_direction,
                        'transaction_type' => $transaction_type,
                        'transaction_tool' => 'not_payroll',
                        'transaction_title' => $transaction_title,
                        'transaction_description' => $transaction_description,
                        'transaction_amount' => $transaction_amount,
                        'transaction_real_amount' => $transaction_real_amount,
                        'transaction_date' => $transactionDate,
                        'transaction_prefix' => $prefix,
                        'transaction_counter' => $transaction_counter
                    ];
                    $this->modelFinancialMovement->insert($insert_financial_movement_data);
                    $financial_account_item = $this->modelFinancialAccount->find($financial_account_ids);
                    $update_financial_account_data = [
                        'account_balance' => $financial_account_item['account_balance'] + $amount_to_be_processed
                    ];
                    $this->modelFinancialAccount->update($financial_account_ids, $update_financial_account_data);

                    $amount_to_be_processed = $amount_to_be_processed * -1;
                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] + $amount_to_be_processeds
                    ];
                    $this->modelCari->update($cari_item['cari_id'], $update_cari_data);

                    echo json_encode(['icon' => 'success', 'message' => 'Tahsilat/Ödeme başarıyla oluşturuldu.']);
                }

                // Cari Bakiye Güncelle
                $this->bakiyeHesapla($cari_id);


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

    public function storePaymentOrCollectionEdit($financial_movement_id = null)
    {
        $financial_movement_item = $this->modelFinancialMovement->where('financial_movement.user_id', session()->get('user_id'))->where('financial_movement_id', $financial_movement_id)->first();
        if (!$financial_movement_item) {
            return view('not-found');
        }

        // print_r($financial_movement_item);
        // return;

        if ($this->request->getMethod('true') == 'POST') {
            try {
                $is_customer = $this->request->getPost('is_customer');
                $is_supplier = $this->request->getPost('is_supplier');
                $is_export_customer = $this->request->getPost('is_export_customer');

                $is_customer = $is_customer == 'on' ? 1 : 0;
                $is_supplier = $is_supplier == 'on' ? 1 : 0;
                $is_export_customer = $is_export_customer == 'on' ? 1 : 0;

                $identification_number = $this->request->getPost('identification_number');
                $tax_administration = $this->request->getPost('tax_administration');
                $invoice_title = $this->request->getPost('invoice_title');
                $name = $this->request->getPost('name');
                $surname = $this->request->getPost('surname');
                $obligation = $this->request->getPost('obligation');
                $company_type = $this->request->getPost('company_type');
                $area_code = $this->request->getPost('area_code');
                $cari_phone = $this->request->getPost('cari_phone');
                $cari_email = $this->request->getPost('cari_email');
                $money_unit_id = $this->request->getPost('money_unit_id');

                $phone = str_replace(array('(', ')', ' '), '', $cari_phone);
                $phoneNumber = $cari_phone ? $area_code . " " . $phone : null;

                $form_data = [
                    'money_unit_id' => $money_unit_id,
                    'identification_number' => $identification_number,
                    'tax_administration' => $tax_administration,
                    'invoice_title' => $invoice_title,
                    'name' => $name,
                    'surname' => $surname,
                    'obligation' => $obligation,
                    'company_type' => $company_type,
                    'cari_phone' => $phoneNumber,
                    'cari_email' => $cari_email,
                    'is_customer' => $is_customer,
                    'is_supplier' => $is_supplier,
                    'is_export_customer' => $is_export_customer,
                ];

                $this->modelCari->update($cari_item['cari_id'], $form_data);

                echo json_encode(['icon' => 'success', 'message' => 'Cari başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'cari',
                    $cari_id,
                    null,
                    'edit',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {

            $cari_item = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id', $financial_movement_item['cari_id'])->first();
            $cari_items = $this->modelCari->where('cari.user_id', session()->get('user_id'))->findAll();
            $current_financial_account_item = $this->modelFinancialAccount->where('financial_account.user_id', session()->get('user_id'))->where('financial_account.financial_account_id', $financial_movement_item['financial_account_id'])->join('money_unit', 'financial_account.money_unit_id = money_unit.money_unit_id')->first();

            $financial_account_items = $this->modelFinancialAccount->table('`financial_account`')
                ->select('financial_account_id, money_unit.money_unit_id, account_title, account_type, bank_id, money_code')
                ->join('money_unit', 'financial_account.money_unit_id = money_unit.money_unit_id')
                ->findAll();

            $all_money_unit = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();

            $data = [
                'financial_movement_item' => $financial_movement_item,
                'cari_item' => $cari_item,
                'cari_items' => $cari_items,
                'current_financial_account_item' => $current_financial_account_item,
                'financial_account_items' => $financial_account_items,
                'bank_items' => session()->get('bank_items'),
                'all_money_unit' => $all_money_unit,
            ];

            // print_r($current_financial_account_item);
            // return;

            return view('tportal/cariler/tahsilat_odeme_duzenle', $data);
        }
    }

    public function deletePaymentOrCollectionEdit($financial_movement_id = null)
    {

        if ($this->request->getMethod('true') == 'POST') {
            try {
                $financial_movement_item = $this->modelFinancialMovement
                    ->where('financial_movement_id', $financial_movement_id)
                    ->first();

              
                if (!$financial_movement_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen stok hareketi mevcut değil.', 'id' => $financial_movement_id,]);
                    return;
                }

                $data_form = $this->request->getPost('data_form');

                foreach ($data_form as $data) {
                    $key = $data['name'];
                    $value = $data['value'];
                    $new_data_form[$key] = $value;
                }



                $invoice_items = $this->modelInvoice
                    ->where('is_quick_collection_financial_movement_id', $financial_movement_id)
                    ->first();

                if ($invoice_items) {

                    $update_invoice_data = [
                        'is_quick_collection_financial_movement_id' => 0,
                    ];
                    $this->modelInvoice->update($invoice_items['invoice_id'], $update_invoice_data);
                }


                //finansal hareket silinir
                $this->modelFinancialMovement->delete($financial_movement_item['financial_movement_id']);




                if ($new_data_form['transaction_type'] == 'collection') {



                


                    //finansal hareket tutarı ilgili cariye tekrar eklenir
                    $cari_item = $this->modelCari->where('cari_id', $financial_movement_item['cari_id'])->first();

                   /*  if(isset($financial_movement_item["virman"])){
                        $amount_to_be_processed = floatval($financial_movement_item['virman']);
                       
                    }else{
                     
                        $amount_to_be_processed = floatval($financial_movement_item['transaction_amount']);
                    } */

                    $amount_to_be_processed = floatval($financial_movement_item['transaction_amount']);




                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] + $amount_to_be_processed
                    ];
                    $this->modelCari->update($cari_item['cari_id'], $update_cari_data);



                    //finansal hareket banka/hesap listesinden silinir
                    $financial_account_item = $this->modelFinancialAccount->where('financial_account_id', $financial_movement_item['financial_account_id'])->first();

                    $update_financial_account_data = [
                        'account_balance' => $financial_account_item['account_balance'] - $amount_to_be_processed
                    ];
                    $this->modelFinancialAccount->update($financial_account_item['financial_account_id'], $update_financial_account_data);


                } else {
                    //finansal hareket tutarı ilgili cariye tekrar eklenir
                    $cari_item = $this->modelCari->where('cari_id', $financial_movement_item['cari_id'])->first();

                    if(isset($financial_movement_item["virman"])){
                      
                        $amount_to_be_processed = floatval($financial_movement_item['virman']);
                    }else{
                        
                        $amount_to_be_processed = floatval($financial_movement_item['transaction_amount']);
                    }

                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] - $amount_to_be_processed
                    ];
                   $this->modelCari->update($cari_item['cari_id'], $update_cari_data);



                    //finansal hareket banka/hesap listesinden silinir
                    $financial_account_item = $this->modelFinancialAccount->where('financial_account_id', $financial_movement_item['financial_account_id'])->first();

                    $update_financial_account_data = [
                        'account_balance' => $financial_account_item['account_balance'] + $amount_to_be_processed
                    ];
                   $this->modelFinancialAccount->update($financial_account_item['financial_account_id'], $update_financial_account_data);
                }


                echo json_encode(['icon' => 'success', 'message' => 'Tahsilat başarıyla silindi.']);

                $this->bakiyeHesapla($financial_movement_item["cari_id"]);


                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'cari',
                    $financial_movement_id,
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

// Alt ürünlerin stok hareketlerini hesaplayan fonksiyon
function updateProductStock($stock_id, $parent = null) {

    $db = $this->userDatabase();

    $stock_item = $this->modelStocks
    ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id', 'left') // Alış birimi
    ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id', 'left') // Satış birimi
    ->where('stock.deleted_at', null) // Sadece silinmemiş kayıtlar
    ->find($stock_id);

    $query = "
        SELECT 
            sm_outer.*, 
            stock_barcode.stock_barcode_id,
            stock_barcode.total_amount,
            (stock_barcode.total_amount - stock_barcode.used_amount) AS remaining_stock,
            stock.stock_type,
            invoice.invoice_id,
            invoice.sale_type,
            invoice.is_return,
            invoice.cari_invoice_title
        FROM stock_movement sm_outer
        JOIN stock_barcode ON sm_outer.stock_barcode_id = stock_barcode.stock_barcode_id
        JOIN stock ON stock.stock_id = stock_barcode.stock_id
        LEFT JOIN cari ON cari.cari_id = sm_outer.supplier_id
        JOIN invoice ON invoice.invoice_id = sm_outer.invoice_id
        WHERE 
            stock_barcode.stock_id = $stock_id
            AND sm_outer.deleted_at IS NULL
            AND stock_barcode.deleted_at IS NULL
        ORDER BY sm_outer.transaction_date;
    ";
    
    // Veritabanı sorgusunu çalıştır
    $financial_movements = $db->query($query)->getResultArray();

    // Toplam giriş, çıkış ve kalan stokları başlat
    $total_purchases = 0;
    $total_sales = 0;
    $total_remaining_stocks = 0;

    // Finansal hareketleri döngü ile işleme
    foreach ($financial_movements as $movement) {
        // Giriş işlemleri (Alış)
        if ($movement['movement_type'] === 'incoming') {
            if (isset($movement['is_return']) && $movement['is_return'] === 'full') {
                // Giriş iadesi varsa toplam alımı azalt
                $total_purchases -= $movement['transaction_quantity'];
            } else {
                // Giriş miktarını ekle
                $total_purchases += $movement['transaction_quantity'];
            }
        } 
        
        // Çıkış işlemleri (Satış)
        elseif ($movement['movement_type'] === 'outgoing') {
            if (isset($movement['is_return']) && $movement['is_return'] === 'full') {
                // Çıkış iadesi varsa toplam satışı azalt
                $total_sales -= $movement['transaction_quantity'];
            } else {
                // Çıkış miktarını ekle
                $total_sales += $movement['transaction_quantity'];
            }
        }
    }

    // Kalan stok miktarını hesapla
    $total_remaining_stocks = $total_purchases - $total_sales;

    // Stok bilgisini güncelle
    $this->modelStocks->set("stock_total_quantity", $total_remaining_stocks)
        ->where("stock_id", $stock_id)
        ->where("deleted_at", null)
        ->update();

        $result = [
            'icon' => 'success',
            'stock_title' => $stock_item['stock_title'],
            'buy_unit_name' => $stock_item['unit_title'], // Alış birimi
            'sale_unit_name' => $stock_item['unit_title'], // Satış birimi
            'total_purchase' => convert_number_for_form($total_purchases, 2),
            'total_sales' => convert_number_for_form($total_sales, 2),
            'remaining_stock' => convert_number_for_form($total_remaining_stocks, 2),
            'remaining_stocks' => $total_remaining_stocks,
            'total_purchases' => $total_purchases,
            'total_saless' => $total_sales
        ];
    
        // Sonuç dizisini döndür
        return $result;
}




  public function stokHesapla($stock_id)
{
    $db = $this->userDatabase();
    // İlk aşama: Sadece gelen stock_id'ye göre olan hareketleri hesapla
    $stock_items = $this->modelStocks
        ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id', 'left') // Alış birimi
        ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id', 'left') // Satış birimi
        ->where('stock.deleted_at', null) // Sadece silinmemiş kayıtlar
        ->find($stock_id);

    if (!$stock_items) {
        echo json_encode(['icon' => 'error', 'message' => "<b>Geçerli bir ürün bulunamadı</b>"]);
        return;
    }
    $total_purchases = 0;
    $total_sales = 0;
    $total_remaining_stocks = 0;
    
    // Ana ürün mü yoksa alt ürün mü kontrol et
    if ($stock_items["parent_id"] == 0) {
        // Eğer ana ürünse, tüm alt ürünleri alıyoruz
        $allSubProducts = $this->modelStocks
            ->where("parent_id", $stock_id)
            ->where("deleted_at", null) // Sadece silinmemiş alt ürünler
            ->findAll();
 

            $totalAnaStok = 0; // Toplam Ana Stok
            $totalAlis = 0; // Toplam Ana Stok
            $totalSatis = 0; // Toplam Ana Stok
            foreach ($allSubProducts as $subProduct) {
                $results = $this->updateProductStock($subProduct["stock_id"], 0);
                $remainingStock = $results["remaining_stocks"];
                $total_purchases = $results["total_purchases"];
                $total_saless = $results["total_saless"];
                $convertedRemainingStock = $remainingStock;
                $totalAnaStok += $convertedRemainingStock;
                $totalAlis += $total_purchases;
                $totalSatis += $total_saless;
            }
            
    

    
        $this->modelStocks->set("stock_total_quantity", $totalAnaStok)
            ->where("stock_id", $stock_id)
            ->where("deleted_at", null)
            ->update();
   

        $result = [
            'icon' => 'success',
            'stock_title' => $stock_items['stock_title'],
            'buy_unit_name' => $stock_items['unit_title'], // Alış birimi
            'sale_unit_name' => $stock_items['unit_title'], // Satış birimi
            'total_purchase' => convert_number_for_form($totalAlis, 2),
            'total_sales' => convert_number_for_form($totalSatis, 2),
            'remaining_stock' => convert_number_for_form($totalAnaStok, 2)
        ];
    
    
        // Ana ürünün sonuçlarını döndür

    } else {
        // Eğer alt ürünse doğrudan updateProductStock fonksiyonunu çağır
        $result = $this->updateProductStock($stock_id, 0);
    }

    // Sonuçları hazırlayıp döndür
    
    echo json_encode(['icon' => 'success', 'message' => $result]);
    return;
}

public function stokHesaplat($stock_id)
{
    $db = $this->userDatabase();
    // İlk aşama: Sadece gelen stock_id'ye göre olan hareketleri hesapla
    $stock_items = $this->modelStocks
        ->join('unit as buy_unit', 'buy_unit.unit_id = stock.buy_unit_id', 'left') // Alış birimi
        ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id', 'left') // Satış birimi
        ->where('stock.deleted_at', null) // Sadece silinmemiş kayıtlar
        ->find($stock_id);

    if (!$stock_items) {
        echo json_encode(['icon' => 'error', 'message' => "<b>Geçerli bir ürün bulunamadı</b>"]);
        return;
    }
    $total_purchases = 0;
    $total_sales = 0;
    $total_remaining_stocks = 0;
    
    // Ana ürün mü yoksa alt ürün mü kontrol et
    if ($stock_items["parent_id"] == 0) {
        // Eğer ana ürünse, tüm alt ürünleri alıyoruz
        $allSubProducts = $this->modelStocks
            ->where("parent_id", $stock_id)
            ->where("deleted_at", null) // Sadece silinmemiş alt ürünler
            ->findAll();
 

            $totalAnaStok = 0; // Toplam Ana Stok
            $totalAlis = 0; // Toplam Ana Stok
            $totalSatis = 0; // Toplam Ana Stok
            foreach ($allSubProducts as $subProduct) {
                $results = $this->updateProductStock($subProduct["stock_id"], 0);
                $remainingStock = $results["remaining_stocks"];
                $total_purchases = $results["total_purchases"];
                $total_saless = $results["total_saless"];
                $convertedRemainingStock = $remainingStock;
                $totalAnaStok += $convertedRemainingStock;
                $totalAlis += $total_purchases;
                $totalSatis += $total_saless;
            }
            
    

    
        $this->modelStocks->set("stock_total_quantity", $totalAnaStok)
            ->where("stock_id", $stock_id)
            ->where("deleted_at", null)
            ->update();
   

        $result = [
            'icon' => 'success',
            'stock_title' => $stock_items['stock_title'],
            'buy_unit_name' => $stock_items['unit_title'], // Alış birimi
            'sale_unit_name' => $stock_items['unit_title'], // Satış birimi
            'total_purchase' => convert_number_for_form($totalAlis, 2),
            'total_sales' => convert_number_for_form($totalSatis, 2),
            'remaining_stock' => convert_number_for_form($totalAnaStok, 2)
        ];
    
    
        // Ana ürünün sonuçlarını döndür

    } else {
        // Eğer alt ürünse doğrudan updateProductStock fonksiyonunu çağır
        $result = $this->updateProductStock($stock_id, 0);
    }

    // Sonuçları hazırlayıp döndür
    
 
}



public function StokGenelHesapla() {
    // 'deleted_at' olmayan tüm ürünleri toplu olarak al
    $totalUrunler = $this->modelStocks->where("deleted_at", null)->findAll();

    // Eğer ürün sayısı çok fazlaysa, işlem yükünü dağıtmak için sayfalama yapabiliriz
    foreach ($totalUrunler as $urun) {
        // Her bir ürün için stok hesaplama işlemi
        $results = $this->stokHesapla($urun["stock_id"]);
        

    }

    echo json_encode(['icon' => 'error', 'message' => "Tüm Stoklar Güncellendi"]);
    return;
}

public function BakiyeGenelHesapla()
{
    try {
        $cari_list = $this->modelCari->where("deleted_at", null)->findAll();
        
        if (!$cari_list) {
            throw new \Exception("Cari listesi bulunamadı");
        }

        $processed = 0;
        $errors = [];

        foreach($cari_list as $cari) {
            try {
                $this->bakiyeHesapla($cari["cari_id"]);
                $processed++;
            } catch (\Exception $e) {
                $errors[] = [
                    'cari_id' => $cari["cari_id"],
                    'error' => $e->getMessage()
                ];
                
                // Her hata için log kaydı
                $this->logClass->save_log(
                    'error',
                    'cari',
                    $cari["cari_id"],
                    null,
                    'bakiye_hesapla',
                    $e->getMessage(),
                    json_encode($cari)
                );
            }
        }

        return [
            'success' => true,
            'message' => "Toplam {$processed} cari işlendi",
            'errors' => $errors
        ];

    } catch (\Exception $e) {
        // Genel bir hata durumunda
        $this->logClass->save_log(
            'error',
            'cari',
            null,
            null,
            'bakiye_genel_hesapla',
            $e->getMessage(),
            null
        );

        return [
            'success' => false,
            'message' => "Genel bir hata oluştu: " . $e->getMessage()
        ];
    }
}

    public function bakiyeHesapla($cari_id)
    {
        // Cari kaydını alıyoruz
        $cari_item = $this->modelCari->find($cari_id);
    
        if (!$cari_item && $cari_id != $this->stok_sayim) {
            return ['icon' => 'error', 'message' => 'Geçerli bir cari bulunamadı.'];
        }
    
        // Başlangıç bakiyesi
        $toplam_bakiye = 0;
    
        // Bu cari_id'ye ait tüm finansal hareketleri alalım
        $financial_movements = $this->modelFinancialMovement
                                    ->join('invoice', 'invoice.invoice_id = financial_movement.invoice_id', 'left')
                                    ->select('financial_movement.*, invoice.invoice_status_id, invoice.tiko_id')
                                    ->where('financial_movement.cari_id', $cari_id)
                                    ->findAll();

                                   
       
        // Tüm finansal hareketleri işlem türlerine göre işleyelim
        foreach ($financial_movements as &$movement) {



           
                $item['invoice_status_title'] = "";
               if($movement["tiko_id"] != 0){
                if($movement["transaction_type"] == "incoming_invoice"){
                    $movement['invoice_status_title'] = $this->InvoiceIncomingStatusModel->where('invoice_incoming_status_id', $movement['invoice_status_id'])->first()['status_name'];
                }
                if($movement["transaction_type"] == "outgoing_invoice"){
                    $movement['invoice_status_title'] = $this->InvoiceOutgoingStatusModel->where('invoice_outgoing_status_id', $movement['invoice_status_id'])->first()['status_name'];
                }
               }
      


            $transaction_type = $movement['transaction_type'];
            $transaction_id = $movement['financial_movement_id']; // Hangi işlemde olduğumuzu anlamak için
            $virman = $movement['virman']; // Hangi işlemde olduğumuzu anlamak için


            
            if($movement["money_unit_id"] == $cari_item["money_unit_id"]){
                $transaction_amount = ($movement['virman'] != '' && $movement['virman'] != 0 ) ? $movement['virman'] : $movement['transaction_amount'];
               // echo $transaction_amount;
            }else{
                $Faturalar = $this->modelInvoice->select("amount_to_be_paid,amount_to_be_paid_try,money_unit_id")->where("invoice_id", $movement["invoice_id"])->first();
                if(isset($Faturalar))
                {
                    if($Faturalar["money_unit_id"] != 3){
                        $movementFiyat = $Faturalar["amount_to_be_paid_try"];
                    }else{
                        $movementFiyat = $Faturalar["amount_to_be_paid"];
                    }
                    $transaction_amount = ($movement['virman'] != '' && $movement['virman'] != 0 ) ? $movement['virman'] : $movementFiyat;

                }else{

                    $transaction_amount = ($movement['virman'] != '' && $movement['virman'] != 0 ) ? $movement['virman'] : $movement['transaction_amount'];

                }
                
                
             
           /* 
                echo '<pre>';
                print_r($movementFiyat);
                echo '</pre>';
                exit;
           */
            
            }


       
       // Ana işlem kontrolü
       if($movement["tiko_id"] != 0) {
           // E-Fatura/E-Arşiv işlemleri için
           
           // Fatura işlemleri için status kontrolü
           if($movement['transaction_type'] == 'outgoing_invoice' || 
              $movement['transaction_type'] == 'incoming_invoice') {
               
               if(isset($movement['invoice_status_title']) && 
                  $movement['invoice_status_title'] != "İptal Edildi" && 
                  $movement['invoice_status_title'] != "Reddedildi" && 
                  $movement['invoice_status_title'] != "Red Edildi")
                  {
                   
                   // Fatura işlemleri
                   $this->processTransaction($movement, $transaction_type, $transaction_amount, $toplam_bakiye);
               }
           } else {
               // Fatura dışı işlemler (tahsilat, ödeme vb.)
               $this->processTransaction($movement, $transaction_type, $transaction_amount, $toplam_bakiye);
           }
       } else {
           // Normal işlemler için
           $this->processTransaction($movement, $transaction_type, $transaction_amount, $toplam_bakiye);
       }
       
     
        // Cari bakiyesini güncelle
        $update_cari_data = [
            'cari_balance' => $toplam_bakiye
        ];
        $this->modelCari->update($cari_item['cari_id'], $update_cari_data);
    
  

    }

}

    public function processTransaction($movement, $transaction_type, $transaction_amount, &$toplam_bakiye) {
        switch ($transaction_type) {
            // Borç artıran işlemler
            case 'outgoing_invoice': // Alış faturası
            case 'payment':          // Ödeme
            case 'outgoing_gider':   // Gider
                $toplam_bakiye += $transaction_amount;
                break;
            
            // Borç azaltan işlemler    
            case 'incoming_invoice': // Satış faturası
            case 'collection':      // Tahsilat
            case 'incoming_gider':  // Gelir     
                $toplam_bakiye -= $transaction_amount;
                break;
    
            // Başlangıç bakiyesi
            case 'starting_balance':
                if ($transaction_amount < 0) {
                    $toplam_bakiye -= abs($transaction_amount);
                } else {
                    $toplam_bakiye += abs($transaction_amount);
                }
                break;
    
            // Borç/Alacak işlemleri    
            case 'borc_alacak':
                if ($transaction_amount < 0) {
                    $toplam_bakiye += abs($transaction_amount);
                } else {
                    $toplam_bakiye -= abs($transaction_amount); 
                }
                break;
    
            // Virman işlemleri - bakiyeyi etkilemez
            case 'incoming_virman':
            case 'outgoing_virman':
                break;
    
            // Çek/Senet işlemleri    
            case 'check_bill':
                if($movement['transaction_direction'] == "entry") {
                    if($movement['tiko_id'] != 0) {
                        $toplam_bakiye += abs($transaction_amount);
                    } else {
                        $toplam_bakiye -= abs($transaction_amount);
                    }
                } else {
                    if($movement['tiko_id'] != 0) {
                        $toplam_bakiye -= abs($transaction_amount);
                    } else {
                        $toplam_bakiye += abs($transaction_amount);
                    }
                }
                break;
        }
    }


  
    public function financialMovements($cari_id = null, $detayli = 0)
    {
       
        $cari_item = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
            ->where('cari.user_id', session()->get('user_id'))
            ->where('cari.cari_id !=', $this->stok_sayim)
            ->where('cari.cari_id', $cari_id)->first();
        if (!$cari_item) {
            return view('not-found');
        }

        $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
        $cari_item["dolarKur"] = $MoneyUnitsDolar["money_value"];
        $cari_item["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
        $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
        $cari_item["euroKur"] = $MoneyUnitsEuro["money_value"];
        $cari_item["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];

        // print_r("nere bura");
        // return;


        //finansal hareketteki cari_idye göre faturadaki cari_idyi doldurdu
        // $query = $this->modelInvoice->get();
        // $invoices = $query->getResultArray();

        // foreach ($invoices as $invoice) {
        //     $query = $this->modelFinancialMovement->getWhere(['invoice_id' => $invoice['invoice_id']]);
        //     $financial_movement = $query->getRowArray();

        //     if (isset($financial_movement['cari_id'])) {
        //         $update_cari_data = ['cari_id' => $financial_movement['cari_id']];
        //         if ($financial_movement)
        //             $this->modelInvoice->update($invoice['invoice_id'], $update_cari_data);
        //     }
        // }

        $financial_movement_items = $this->modelFinancialMovement
        ->join('invoice', 'invoice.invoice_id = financial_movement.invoice_id', 'left')
        ->join('money_unit', 'money_unit.money_unit_id = financial_movement.money_unit_id')
        ->select('money_unit.*,financial_movement.*,invoice.sale_type,invoice.invoice_status_id,invoice.tiko_id, invoice.invoice_status_id as fatura_durum_id, invoice.invoice_direction as fatura_tipi,  invoice.invoice_id as fatura_id, invoice.invoice_no, invoice.currency_amount, invoice.amount_to_be_paid_try, invoice.amount_to_be_paid, invoice.money_unit_id AS money_id')
        ->where('financial_movement.user_id', session()->get('user_id'))
        ->where('financial_movement.cari_id', $cari_id)
        ->where('financial_movement.deleted_at', null) // NULL olan deleted_at kayıtlarını getirir
        ->orderBy('financial_movement.transaction_date', 'ASC')
        ->orderBy('financial_movement_id', 'ASC')
        ->findAll();
       
        foreach($financial_movement_items as &$item){
            $item['invoice_status_title_info'] = "";
            $item['invoice_status_title'] = "";
            if($item["tiko_id"] != 0){
            if($item["fatura_tipi"] == "incoming_invoice"){
                $item['invoice_status_title'] = $this->InvoiceIncomingStatusModel->where('invoice_incoming_status_id', $item['invoice_status_id'])->first()['status_name'] ?? "Bulunamadı";
                $item['invoice_status_title_info'] = $this->InvoiceIncomingStatusModel->where('invoice_incoming_status_id', $item['invoice_status_id'])->first()['status_info'] ?? "Bulunamadı";
            }else{
                $item['invoice_status_title'] = $this->InvoiceOutgoingStatusModel->where('invoice_outgoing_status_id', $item['invoice_status_id'])->first()['status_name'] ?? "Bulunamadı";
                $item['invoice_status_title_info'] = $this->InvoiceOutgoingStatusModel->where('invoice_outgoing_status_id', $item['invoice_status_id'])->first()['status_info'] ?? "Bulunamadı";
            }
                if($item["transaction_type"] == "incoming_invoice"){
                    $item['invoice_status_title'] = $this->InvoiceIncomingStatusModel->where('invoice_incoming_status_id', $item['invoice_status_id'])->first()['status_name'] ?? "Bulunamadı";
                }
                if($item["transaction_type"] == "outgoing_invoice"){
                    $item['invoice_status_title'] = $this->InvoiceOutgoingStatusModel->where('invoice_outgoing_status_id', $item['invoice_status_id'])->first()['status_name'] ?? "Bulunamadı";
                }
            }
        }
   
     
    
       /* 
            echo '<pre>';
         print_r($financial_movement_items);
         echo '</pre>';

         return;
       */

        $transaction_types = [
            'incoming_invoice' => 'Gelen Fatura',
            'outgoing_invoice' => 'Giden Fatura',
            'collection' => 'Tahsilat',
            'check_bill' => "Çek/Senet",
            'payment' => 'Ödeme',
            'outgoing_gider' => 'Gider',
            'incoming_gider' => 'Gider',
            'starting_balance' => 'Başlangıç Bakiyesi',
            'borc_alacak' => 'Borç/Alacak İşlemi',
        ];
        if($detayli != 0){

            $data = [
                'detayli'   => $detayli,
                'cari_item' => $cari_item,
                'financial_movement_items' => $financial_movement_items,
                'bank_items' => session()->get('bank_items'),
                'temp_balance' => $cari_item['cari_balance'],
                'transaction_types' => $transaction_types
            ];
           
            return view('tportal/cariler/detay/cari_detaylar', $data);

        }else{
            $data = [
                'detayli'   => $detayli,
                'cari_item' => $cari_item,
                'financial_movement_items' => $financial_movement_items,
                'bank_items' => session()->get('bank_items'),
                'temp_balance' => $cari_item['cari_balance'],
                'transaction_types' => $transaction_types
            ];
           
            return view('tportal/cariler/detay/hareketler', $data);
        }
       
    }


    public function offerMovements($cari_id = null, $detayli = 0)
    {
       
        $cari_item = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
            ->where('cari.user_id', session()->get('user_id'))
            ->where('cari.cari_id !=', $this->stok_sayim)
            ->where('cari.cari_id', $cari_id)->first();
        if (!$cari_item) {
            return view('not-found');
        }

        $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
        $cari_item["dolarKur"] = $MoneyUnitsDolar["money_value"];
        $cari_item["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
        $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
        $cari_item["euroKur"] = $MoneyUnitsEuro["money_value"];
        $cari_item["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];


        $offer_model = $this->modelOffer->join('money_unit', 'money_unit.money_unit_id = offer.money_unit_id')
            ->where('offer.user_id', session()->get('user_id'))
            ->where('offer.cari_id', $cari_id)
            ->orderBy('offer.offer_date','ASC');

        $offer_items = $offer_model->findAll();

      
            

        if($detayli != 0){

            $data = [
                'detayli'   => $detayli,
                'cari_item' => $cari_item,
                'financial_movement_items' => $offer_items,
                'bank_items' => session()->get('bank_items'),
                'temp_balance' => $cari_item['cari_balance'],
            ];
           
            return view('tportal/cariler/detay/cari_detaylar', $data);

        }else{
            $data = [
                'detayli'   => $detayli,
                'cari_item' => $cari_item,
                'financial_movement_items' => $offer_items,
                'bank_items' => session()->get('bank_items'),
                'temp_balance' => $cari_item['cari_balance'],
            ];
           
            return view('tportal/cariler/detay/teklifler', $data);
        }
       
    }



    public function getCariMovement($cari_id = null)
    {
        // DataTables'ten gelen istek parametreleri
        $draw = $this->request->getPostGet('draw') ?? 1;
        $start = $this->request->getPostGet('start') ?? 0; // Start index should be 0 for DataTables
        $length = $this->request->getPostGet('length') ?? 10; // Default length 10, adjust as needed
    
        // Arama terimi
        $searchValue = $this->request->getPostGet('search')['value'] ?? '';
    
        // Sıralama parametreleri
        $order = $this->request->getPostGet('order') ?? [];
        $columns = $this->request->getPostGet('columns') ?? [];
    
        $transaction_types = [
            'incoming_invoice' => 'Gelen Fatura',
            'outgoing_invoice' => 'Giden Fatura',
            'collection' => 'Tahsilat',
            'check_bill' => "Çek/Senet",
            'payment' => 'Ödeme',
            'outgoing_gider' => 'Gider',
            'incoming_gider' => 'Gider',
            'starting_balance' => 'Başlangıç Bakiyesi',
            'borc_alacak' => 'Borç/Alacak İşlemi',
        ];
    
        // Veritabanından cari bilgisi çekme
        $cari_item = $this->modelCari
            ->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
            ->where('cari.user_id', session()->get('user_id'))
            ->where('cari.cari_id', $cari_id)
            ->where('cari.cari_id !=', $this->stok_sayim)
            ->first();
    
        if (!$cari_item) {
            return view('not-found'); // Cari bulunamazsa hata sayfasını görüntüle
        }
    
        $db = $this->userDatabase(); // Veritabanı bağlantısını al
    
        // SQL sorgusu oluşturma
        $sql = "SELECT money_unit.*, financial_movement.*, invoice.sale_type
                FROM financial_movement
                LEFT JOIN invoice ON invoice.invoice_id = financial_movement.invoice_id
                LEFT JOIN money_unit ON money_unit.money_unit_id = financial_movement.money_unit_id
                WHERE financial_movement.user_id = ?
                  AND financial_movement.cari_id = ?
                  AND financial_movement.deleted_at IS NULL ";
    
        // Arama terimini sorguya dahil et
        if (!empty($searchValue)) {
            $sql .= "AND (
                        financial_movement.transaction_date LIKE '%$searchValue%' OR
                        financial_movement.transaction_number LIKE '%$searchValue%' OR
                        financial_movement.transaction_title LIKE '%$searchValue%' OR
                        financial_movement.transaction_amount LIKE '%$searchValue%' OR
                        invoice.sale_type LIKE '%$searchValue%'
                    ) ";
        }
    
        // Sıralama işlemi için order by kısmını ekle
      // Sıralama işlemi için order by kısmını ekle
if (!empty($order)) {
    $orderBy = [];
    foreach ($order as $orderItem) {
        $columnIndex = $orderItem['column'];

      
        if($columnIndex == 0){
            $columnName = "financial_movement.transaction_date";
        }
        if($columnIndex == 2){
            $columnName = "financial_movement.transaction_number";
        }

        $dir = $orderItem['dir'];
        $orderBy[] = "$columnName $dir";
    }
    $sql .= "ORDER BY " . implode(', ', $orderBy) . " ";
} else {
    $sql .= "ORDER BY financial_movement.transaction_date DESC, financial_movement.financial_movement_id DESC ";
}

$sql .= "LIMIT ?, ?";


    
        // SQL sorgusunu çalıştırma
        $query = $db->query($sql, [session()->get('user_id'), $cari_id, (int)$start, (int)$length]);
        $financial_movement_items = $query->getResult();
    
        // Başlangıç bakiyesi
        $temp_balance = $cari_item['cari_balance'];
    
        // Hareketleri döngüye al
        foreach ($financial_movement_items as &$item) {
            // Geçici bakiyeyi her bir hareket için ekleyin
            $item->temp_balance = convert_number_for_form($temp_balance, 2);
            $temp_balance = $item->transaction_direction === 'entry' ? $temp_balance + $item->transaction_amount : $temp_balance - $item->transaction_amount;
        }
    
        // Toplam kayıt sayısını al
        $sqlCount = "SELECT COUNT(*) as totalRecords
                     FROM financial_movement
                     WHERE financial_movement.user_id = ? AND financial_movement.cari_id = ? AND financial_movement.deleted_at IS NULL";
    
        // Toplam kayıt sayısını sorgula
        $queryCount = $db->query($sqlCount, [session()->get('user_id'), $cari_id]);
        $totalRecords = $queryCount->getRow()->totalRecords;
    
        // DataTables için gerekli JSON formatını oluşturma
        $output = [
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Şu an için filtreleme işlemi yapmıyoruz
            'data' => $financial_movement_items,
        ];
    
        return $this->response->setJSON($output);
    }
    
    
    
    public function listSaleOrder()
    {
        $shipment_items = $this->modelShipment->join('cari', 'cari.cari_id = shipment.to_where')
            ->join('warehouse from_warehouse', 'from_warehouse.warehouse_id = shipment.from_where')
            ->select('shipment.*, from_warehouse.warehouse_title as from_warehouse_title, cari.invoice_title as to_warehouse_title')
            ->where('shipment.user_id', session()->get('user_id'))
            ->where('shipment.shipment_type', 'warehouse_to_customer')
            ->orderBy('shipment.created_at', 'DESC')
            ->findAll();

        // print_r($shipment_items);
        // exit();

        $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();

        $data = [
            'shipment_items' => $shipment_items,
            'warehouse_items' => $warehouse_items
        ];
        return view('tportal/sevkiyatlar/index', $data);
    }

    public function detailSaleOrder($shipment_number = null)
    {
        $shipment_item = $this->modelShipment->join('warehouse from_warehouse', 'from_warehouse.warehouse_id = shipment.from_where')
            ->join('cari', 'cari.cari_id = shipment.to_where')
            ->select('shipment.*, from_warehouse.warehouse_title as from_warehouse_title, cari.invoice_title as to_warehouse_title, shipment.*')
            ->where('shipment.user_id', session()->get('user_id'))
            ->where('shipment.shipment_number', $shipment_number)
            ->first();

        if (!$shipment_item) {
            return view('not-found');
        }

        $sale_order_items = $this->modelSaleOrderItem->join('shipment', 'shipment.shipment_id = sale_order_item.shipment_id')
            ->join('stock_barcode', 'stock_barcode.stock_barcode_id = sale_order_item.stock_barcode_id')
            ->join('stock', 'stock.stock_id = stock_barcode.stock_id')
            ->join('unit as sale_unit', 'sale_order_item.sale_unit_id = sale_unit.unit_id')
            ->join('money_unit', 'money_unit.money_unit_id = sale_order_item.sale_money_unit_id')
            ->select('sale_order_item.sale_unit_price as birim_fiyat, sale_order_item.sale_amount as birim_adet, sale_order_item.total_price as toplam_fiyat, money_unit.money_icon as money_unit, shipment.*,stock.*,stock_barcode.*,sale_unit.*')
            ->where('sale_order_item.shipment_id', $shipment_item['shipment_id'])
            ->findAll();

        $data = [
            'shipment_item' => $shipment_item,
            'total_stock_amount' => 0,
            'sale_order_items' => $sale_order_items
        ];

        return view('tportal/sevkiyatlar/detay/sevkiyat_kabul', $data);
    }

    public function quickDetailSaleOrder($invoice_id = null)
    {


        $quick_sale_item = $this->modelInvoice->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
            ->where('invoice.invoice_id', $invoice_id)
            ->where('invoice.user_id', session()->get('user_id'))
            ->orderBy('invoice.invoice_date')
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

        if (!$quick_sale_item) {
            return view('not-found');
        }

        // $quick_sale_items = $this->modelInvoiceRow->join('stock_barcode', 'stock_barcode.stock_barcode_id = invoice_row.stock_barcode_id')
        //     ->join('stock', 'stock.stock_id = stock_barcode.stock_id')
        //     ->join('stock_movement', 'stock_movement.stock_barcode_id = invoice_row.stock_barcode_id')
        //     ->join('cari', 'cari.cari_id = stock_movement.supplier_id','left')
        //     ->join('unit as sale_unit', 'invoice_row.unit_id = sale_unit.unit_id','left')
        //     ->join('invoice', 'invoice.invoice_id = invoice_row.invoice_id')
        //     ->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
        //     ->select('invoice_row.unit_price as birim_fiyat, invoice_row.stock_amount as birim_adet, invoice_row.subtotal_price as toplam_fiyat, money_unit.money_icon as money_unit,stock.*,stock_barcode.*,sale_unit.*,stock_movement.*,cari.cari_id,cari.invoice_title,cari.name,cari.surname')
        //     ->where('invoice_row.invoice_id', $invoice_id)
        //     ->findAll();

        if ($quick_sale_item['invoice_direction'] == 'incoming_invoice') {



            $quick_sale_items = $this->modelInvoiceRow->join('stock_barcode', 'stock_barcode.stock_barcode_id = invoice_row.stock_barcode_id')
                ->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                ->join('stock_movement', 'stock_movement.stock_barcode_id = invoice_row.stock_barcode_id')
                ->join('cari', 'cari.cari_id = stock_movement.supplier_id', 'left')
                ->join('cari as supplier', 'supplier.cari_id = stock_movement.supplier_id')
                ->join('unit as sale_unit', 'invoice_row.unit_id = sale_unit.unit_id', 'left')
                ->join('invoice', 'invoice.invoice_id = invoice_row.invoice_id')
                ->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id')
                ->select('invoice_row.invoice_row_id as fatura_satiri,invoice_row.unit_price as birim_fiyat, invoice_row.stock_amount as birim_adet, invoice_row.subtotal_price as toplam_fiyat, invoice_row.subtotal_price as genel_toplam_fiyat, money_unit.money_icon as money_unit,stock.*,stock_barcode.*,sale_unit.*,stock_movement.*,cari.cari_id,cari.invoice_title,cari.name,cari.surname,invoice_row.is_return,invoice_row.is_return_amount,supplier.invoice_title,supplier.name,supplier.surname')
                ->where('invoice_row.invoice_id', $invoice_id)
                ->where('stock_movement.movement_type', 'incoming')
                ->findAll();
        } else {
            $quick_sale_items = $this->modelInvoiceRow->join('stock_barcode', 'stock_barcode.stock_barcode_id = invoice_row.stock_barcode_id', 'LEFT')
                ->join('stock', 'stock.stock_id = stock_barcode.stock_id', 'LEFT')
                ->join('unit as sale_unit', 'invoice_row.unit_id = sale_unit.unit_id', 'LEFT')
                ->join('invoice', 'invoice.invoice_id = invoice_row.invoice_id', 'LEFT')
                ->join('money_unit', 'money_unit.money_unit_id = invoice.money_unit_id', 'LEFT')
                ->select('invoice_row.invoice_row_id as fatura_satiri, invoice_row.unit_price as birim_fiyat, invoice_row.stock_amount as birim_adet, invoice_row.subtotal_price as toplam_fiyat, invoice.sub_total as genel_toplam_fiyat, money_unit.money_icon as money_unit,stock.*,sale_unit.*,invoice_row.is_return,invoice_row.is_return_amount,stock_barcode.barcode_number,stock_barcode.stock_barcode_id')
                ->where('invoice_row.invoice_id', $invoice_id)
                ->findAll();
        }




        $data = [
            'Kurlar' => $Kurlar,
            'quick_sale_item' => $quick_sale_item,
            'total_stock_amount' => 0,
            'quick_sale_items' => $quick_sale_items
        ];

    

        return view('tportal/sevkiyatlar/detay/hizli_satis_detay', $data);
    }

    #TODO: stock_movement_create edilirken sale_unit_id kısmına o anki satış fiyatlarını kaydet
    #TODO: bu kısımda stock_movement_transaction_number satışınkini alıcak

    public function createSaleOrder($cari_id = null)
    {
        $Kurlar = $this->modelMoneyUnit->findAll();

        $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))
            ->where('default', 'true')
            ->first();


        $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
        $cari_item = $this->modelCari->join('money_unit', 'money_unit_id', 'cari.money_unit_id')->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id', $cari_id)->first();
        $cari_items = $this->modelCari->join('money_unit', 'money_unit_id', 'cari.money_unit_id')->where('cari.user_id', 0)->where('cari.user_id', session()->get('user_id'))->orderBy('cari_id', 'ASC')->findAll();

        $financial_account_items = $this->modelFinancialAccount->join('money_unit', 'financial_account.money_unit_id = money_unit.money_unit_id')
            ->select('financial_account_id, money_unit.money_unit_id, account_title, account_type, bank_id, money_code')
            ->findAll();

        $data = [
            'Kurlar' => $Kurlar,

            'warehouse_items' => $warehouse_items,
            'money_unit_items' => $money_unit_items,
            'cari_item' => $cari_item,
            'cari_items' => $cari_items,
            'financial_account_items' => $financial_account_items,
        ];

        // print_r($money_unit_items);
        // return;

        if ($cari_id == 0) {
            return view('tportal/sevkiyatlar/yeni_satis', $data);
        } elseif (!$cari_item) {
            return view('not-found');
        }

        return view('tportal/sevkiyatlar/yeni_satis', $data);
    }



    public function createSupplierReturn($cari_id = null)
    {
        $Kurlar = $this->modelMoneyUnit->findAll();

        $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))
            ->where('default', 'true')
            ->first();


        $money_unit_items = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))->where('status', 'active')->findAll();
        $cari_item = $this->modelCari->join('money_unit', 'money_unit_id', 'cari.money_unit_id')->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id', $cari_id)->first();
        $cari_items = $this->modelCari->join('money_unit', 'money_unit_id', 'cari.money_unit_id')->where('cari.user_id', 0)->where('cari.user_id', session()->get('user_id'))->orderBy('cari_id', 'ASC')->findAll();

        $financial_account_items = $this->modelFinancialAccount->join('money_unit', 'financial_account.money_unit_id = money_unit.money_unit_id')
            ->select('financial_account_id, money_unit.money_unit_id, account_title, account_type, bank_id, money_code')
            ->findAll();

        $data = [
            'Kurlar' => $Kurlar,

            'warehouse_items' => $warehouse_items,
            'money_unit_items' => $money_unit_items,
            'cari_item' => $cari_item,
            'cari_items' => $cari_items,
            'financial_account_items' => $financial_account_items,
        ];

        // print_r($money_unit_items);
        // return;

        if ($cari_id == 0) {
            return view('tportal/sevkiyatlar/tedarik_iade', $data);
        } elseif (!$cari_item) {
            return view('not-found');
        }

        return view('tportal/sevkiyatlar/tedarik_iade', $data);
    }





    ## OTOMATİK SATIŞ YAPMA



    public function barkodKapat()
    {
        $stock_id = $this->request->getPost('stock_id');
        $barcodes = $this->request->getPost('barcodes'); // This will be an array of barcode objects
    
        // Collect all stock_barcode_id values from the submitted barcodes to exclude them
        $excludeStockBarcodeIds = [];
    
        foreach ($barcodes as $barcodeData) {
            // Convert JSON string back to an object/array (if using Option 2 - form submission)
            if (is_string($barcodeData)) {
                $barcodeData = json_decode($barcodeData, true);
            }
            
            // Add stock_barcode_id to the exclusion array
            $excludeStockBarcodeIds[] = $barcodeData['stock_barcode_id'];
        }
    
        // Query the model to get all rows where stock_id matches and stock_barcode_status is available,
        // but excluding the stock_barcode_ids in the $excludeStockBarcodeIds array
        $remainingBarcodes = $this->modelStockBarcode
            ->where('stock_id', $stock_id)
            //->where('stock_barcode_status', 'available')
            ->whereNotIn('stock_barcode_id', $excludeStockBarcodeIds)
            ->findAll();
            $ToplamSayi = count($remainingBarcodes);
      
        // $remainingBarcodes burda satılacak barkodları almış olduk
        // şimdi bir cari de belirledik o cariye işleyeceğiz işlemi $cari_id_stok bizim kapama işlemini yapacağımız hesap
        //  şimdi şunu yapmak istiyorum aşağıda değerlere göre olan satış işlemi var biz bunu değiştirecğeiz ve ürün ve cari bilgilerini 
        // bizim verdiğimiz değerlerden alacağız 
        // ürün bilgileri yukarıdan satış olarak money_unit_id  1 diyebiliriz ve satış fiyatını 1 dolar olarak yapabiliriz 
        // harici cari bilgilerini verdiğim gibi çek ürün bilgilerini de verdiğim gibi çek 
        // kurlar kısmında da hesaplarken modelFaturaTutar kısmında da kurları foreach e sokup total fiyatı para birimine göre kur değerine göre çarpıp hesaplatıp
        // o tabloya yazacağız
        // anlamadığın bir yer var mı ona göre  kodları seninle paylaşacağım 

            $cari_id_stok = session()->get('user_item')["stock_user"];
        
        foreach($remainingBarcodes as $satisYap)
        {


            try {
                $errList = [];
                $all_total_price = 0;
                $sale_price = 1;
                $sale_unit_price = 0.5;
                $transaction_prefix = "PRF";


                // print_r($form_data);
                // print_r($sale_order_items_data);
                // return;

                $defaultDepo = $this->modelWarehouse->where("default", "true")->first();

                $DefaultPara = $this->modelMoneyUnit->where("money_unit_id", 1)->first();


                $from_where = $defaultDepo['warehouse_id'];
                $to_where = $cari_id_stok;
                $shipment_note = "Otomatik Bakord Kapatmadan Oluşan İşlem";
                
                $total_stock_amount = number_format($ToplamSayi * 1, 2, ',', '.');
                $total_stock_amount = convert_number_for_sql($total_stock_amount);
                $total_stock_amount_try = number_format($ToplamSayi * 1, 2, ',', '.');
                $total_stock_amount_try = convert_number_for_sql($total_stock_amount_try);

                $currency_amount = $DefaultPara['money_value'] ?? 1;
                $money_unit_id = $DefaultPara['money_unit_id'] ?? 1;

                $warehouse_item = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('warehouse_id', $from_where)->first();
                if (!$warehouse_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Depo bulunamadı']);
                    return;
                }
                $cari_item = $this->modelCari->join('address', 'cari.cari_id = address.cari_id', 'left')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id', $to_where)->first();
                if (!$cari_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Cari bulunamadı']);
                    return;
                }

                //6 rakamlı sipariş barkod kodu
                $create_sale_order_code = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

                $prefix = "SPR";
                $random_value = $prefix . $from_where . $create_sale_order_code;


                // print_r($random_value);
                // return;

                $insert_invoice_data = [
                    'user_id' => session()->get('user_id'),

                    'money_unit_id' => $money_unit_id,
                    'sale_type' => "quick",
                    'invoice_no' => $random_value,

                    'invoice_direction' => 'outgoing_invoice',
                    'invoice_date' => new Time('now', 'Turkey', 'en_US'),
                    'expiry_date' => new Time('now', 'Turkey', 'en_US'),

                    'currency_amount' => $currency_amount,


                    'stock_total' => $total_stock_amount,
                    'stock_total_try' => $total_stock_amount_try,
                    'sub_total' => $total_stock_amount,
                    'sub_total_try' => $total_stock_amount_try,
                    'grand_total' => $total_stock_amount,
                    'grand_total_try' => $total_stock_amount_try,
                    'amount_to_be_paid' => $total_stock_amount,
                    'amount_to_be_paid_try' => $total_stock_amount_try,

                    'invoice_note' => $shipment_note,

                    'cari_id' => $cari_item['cari_id'],
                    'cari_identification_number' => $cari_item['identification_number'],
                    'cari_tax_administration' => $cari_item['tax_administration'],

                    'cari_invoice_title' => $cari_item['invoice_title'] == '' ? $cari_item['name'] . " " . $cari_item['surname'] : $cari_item['invoice_title'],
                    'cari_name' => $cari_item['name'],
                    'cari_surname' => $cari_item['surname'],
                    'cari_obligation' => $cari_item['obligation'],
                    'cari_company_type' => $cari_item['company_type'],
                    'cari_phone' => $cari_item['cari_phone'],
                    'cari_email' => $cari_item['cari_email'],

                    'address_country' => $cari_item['address_country'],

                    'address_city' => isset($cari_item['address_city_name']) ? $cari_item['address_city_name'] : "",
                    'address_city_plate' => isset($cari_item['address_city']) ? $cari_item['address_city'] : "",
                    'address_district' => isset($cari_item['address_district']) ? $cari_item['address_district'] : "",
                    'address_zip_code' => $cari_item['zip_code'],
                    'address' => $cari_item['address'],

                    'invoice_status_id' => "1",
                ];

                // print_r($insert_invoice_data);
                // return;

                $this->modelInvoice->insert($insert_invoice_data);
                $invoice_id = $this->modelInvoice->getInsertID();




                $kurlar =  $this->modelMoneyUnit->where("status", "active")->findAll();

                if(isset($kurlar)){

                    foreach ($kurlar as $kur) {

                        if($kur["money_unit_id"] == 1){
                            $default = "true";
                        }else{
                            $default = "false";
                        }
                       
                        $fiyatDatalar = [
                            'user_id'      => session()->get('user_id'),
                            'cari_id'      => $cari_item['cari_id'],
                            'fatura_id'    => $invoice_id,
                            'kur'          => $kur['money_unit_id'],
                            'kur_value'    => $this->convert_sql($kur['money_value']),
                            'toplam_tutar' => $this->convert_sql($total_stock_amount * $kur['money_value']),
                            'tarih'        => date("d-m-Y h:i"),  // PHP'de date() fonksiyonu kullanılır
                            'default'      => $default
                        ];
                        $insertFiyat = $this->modelFaturaTutar->insert($fiyatDatalar);
                    

                    }
                    

                }

               

                

              
                    $sale_amount = convert_number_for_sql($sale_price);
                    $sale_unit_price = convert_number_for_sql($sale_unit_price);

                    // print_r($sale_amount." ");
                    // print_r($sale_unit_price);
                    // return;

                    $barcode_number = $satisYap['barcode_number'];

                    

                    # TODO: Burada barkodun durumunun satış yapılmaya uygunluğunu kontrol ediyoruz.
                    #       Eğer buralara istisnalar koyulacaksa buraya bakılması gerekiyor.
                    $chk_barcode = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                        ->where('stock.user_id', session()->get('user_id'))
                        ->where('stock_barcode.barcode_number', $barcode_number)
                        ->first();
                    if (!$chk_barcode) {
                        $errList[$satisYap['barcode_number']] = "Geçersiz barkod numarası.";
                        echo "Geçersiz barkod numarası.";;
                       
                       continue;
                    } else if ($chk_barcode['stock_barcode_status'] == 'out_of_stock') {
                        $errList[$satisYap['barcode_number']] = "Girilen barkod bilgisindeki tüm ürün miktarı daha önce kullanıdı.";
                        echo "Girilen barkod bilgisindeki tüm ürün miktarı daha önce kullanıdı.";
                       
                       continue;
                    } else if ($chk_barcode['stock_barcode_status'] != 'available') {
                        $errList[$satisYap['barcode_number']] = "Girilen barkod siparişe eklenmeye uygun değil.";
                        echo "Girilen barkod siparişe eklenmeye uygun değil.";
                       
                       continue;
                    } else if ($sale_amount > $chk_barcode['total_amount'] - $chk_barcode['used_amount']) {
                        $errList[$satisYap['barcode_number']] = "Bu barkod numarası için istenen miktar barkodtaki miktardan fazla.";
                        echo "Bu barkod numarası için istenen miktar barkodtaki miktardan fazla.";
                       
                       continue;
                    } else if ($chk_barcode['warehouse_id'] != $from_where) {
                        $errList[$satisYap['barcode_number']] = "Bu barkod numarası girilen depoda bulunamadı.";
                        echo "Bu barkod numarası girilen depoda bulunamadı.";
                       
                       continue;
                    }
                

                    $old_stock_movement = $this->modelStockMovement
                        ->where('stock_movement.user_id', session()->get('user_id'))
                        ->where('stock_barcode_id', $chk_barcode['stock_barcode_id'])
                        ->first();

                    // print_r($old_stock_movement);
                    // return;

                    $total_price = $sale_unit_price * $sale_amount;

                    $stokBilgisi = $this->modelStocks->where("stock_id", $satisYap["stock_id"])->first();

                    try {
                        $insert_invoice_row_data = [
                            'user_id' => session()->get('user_id'),
                            'cari_id' => $to_where,
                            'invoice_id' => $invoice_id,
                            'stock_id' => $stokBilgisi['stock_id'],
                            'stock_barcode_id' => $satisYap['stock_barcode_id'],
                            'stock_title' => $stokBilgisi['stock_title'],
                            'stock_amount' => $satisYap["total_amount"], //convert_number_for_sql($data_invoice_row['stock_amount'])

                            'unit_id' => $stokBilgisi['sale_unit_id'],
                            'unit_price' => $sale_unit_price,

                            'subtotal_price' => $total_price,

                            # Vergi oranı 0 olduğu için statik tanımlandı.
                            'tax_id' => 1,
                            'total_price' => $total_price,
                        ];
                        $this->modelInvoiceRow->insert($insert_invoice_row_data);

                   
                        $all_total_price += $total_price;

                        $used_amount = $chk_barcode['used_amount'] + $satisYap["total_amount"];
                        $stock_barcode_status = $used_amount == $chk_barcode['total_amount'] ? 'out_of_stock' : 'available';
                        $update_stock_barcode_data = [
                            'used_amount' => $used_amount,
                            'stock_barcode_status' => $stock_barcode_status
                        ];
                        $this->modelStockBarcode->update($chk_barcode['stock_barcode_id'], $update_stock_barcode_data);


                        $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                        if ($last_transaction) {
                            $transaction_counter = $last_transaction['transaction_counter'] + 1;
                        } else {
                            $transaction_counter = 1;
                        }
                        $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);

                        $insert_stock_movement_data = [
                            'user_id' => session()->get('user_id'),
                            'stock_barcode_id' => $chk_barcode['stock_barcode_id'],
                            'invoice_id' => $invoice_id,
                            'supplier_id' => $old_stock_movement['supplier_id'],
                            'movement_type' => 'outgoing',
                            'transaction_number' => $transaction_number,
                            'from_warehouse' => $from_where,
                            'transaction_note' => null,
                            'transaction_info' => 'Stok Çıkış',
                            'sale_unit_price' => $sale_unit_price,
                            'sale_money_unit_id' => $DefaultPara['money_unit_id'],
                            'transaction_quantity' => ($satisYap["total_amount"]),
                            'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                            'transaction_prefix' => $transaction_prefix,
                            'transaction_counter' => $transaction_counter,
                        ];
                        $this->modelStockMovement->insert($insert_stock_movement_data);


                        $insert_StockWarehouseQuantity = [
                            'user_id' => 0
                        ];

         

                        $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $from_where, $chk_barcode['stock_id'], $chk_barcode['parent_id'], str_replace(',', '.', ($satisYap["total_amount"])), 'remove', $this->modelStockWarehouseQuantity, $this->modelStocks);
                        if ($addStock === 'eksi_stok') {
                            echo json_encode(['icon' => 'error', 'message' => 'bu işlemden sonra stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz.']);
                            return;
                        }


                    } catch (\Exception $e) {
                        $this->logClass->save_log(
                            'error',
                            'sale_order_item',
                            null,
                            null,
                            'create',
                            $e->getMessage(),
                            json_encode($_POST)
                        );
                        echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                        continue;
                    }
                

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
                    'cari_id' => $to_where,
                    'money_unit_id' => $DefaultPara['money_unit_id'],
                    'transaction_number' => $transaction_number,
                    'transaction_direction' => 'exit',
                    'transaction_type' => 'outgoing_invoice',
                    'invoice_id' => $invoice_id,
                    'transaction_tool' => 'not_payroll',
                    'transaction_title' => 'Otomatik Stok Çıkışından Oluşan satış faturasından oluşan hareket',
                    'transaction_description' => $shipment_note,
                    'transaction_amount' => $all_total_price,
                    'transaction_real_amount' => $all_total_price,
                    'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                    'transaction_prefix' => $transaction_prefix,
                    'transaction_counter' => $transaction_counter
                ];
                $this->modelFinancialMovement->insert($insert_financial_movement_data);


                // $update_cari_data = [
                //     'cari_balance' => $cari_item['cari_balance'] + $all_total_price
                // ];
                // $this->modelCari->update($cari_item['cari_id'], $update_cari_data);


                $faturaAsilTutar = $total_stock_amount;
                $has_collection = 1;


                #tahsilat yapılmışsa...
                if ($has_collection == 1) {

                    $FinansBankasi = $this->modelFinancialAccount->where("money_unit_id", $DefaultPara["money_unit_id"])->first();

                    $financial_account_id = $FinansBankasi["financial_account_id"];
                    $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                    if ($last_transaction) {
                        $transaction_counter = $last_transaction['transaction_counter'] + 1;
                    } else {
                        $transaction_counter = 1;
                    }
                    $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                    $insert_financial_movement_data = [
                        'user_id' => session()->get('user_id'),
                        'financial_account_id' => $financial_account_id,
                        'cari_id' => $to_where,
                        'money_unit_id' => $DefaultPara['money_unit_id'],
                        'transaction_number' => $transaction_number,
                        'transaction_direction' => 'entry',
                        'transaction_type' => 'collection',
                        'invoice_id' => $invoice_id,
                        'transaction_tool' => 'not_payroll',
                        'transaction_title' => 'Otomatik Stok Çıkışından Oluşan  satış faturası anında yapılan tahsilat hareketi',
                        'transaction_description' => $shipment_note,
                        'transaction_amount' => $all_total_price,
                        'transaction_real_amount' => $all_total_price,
                        'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                        'transaction_prefix' => $transaction_prefix,
                        'transaction_counter' => $transaction_counter
                    ];
                    $this->modelFinancialMovement->insert($insert_financial_movement_data);
                    $is_collection_financial_movement_id = $this->modelFinancialMovement->getInsertID();


                    $financial_account_item = $this->modelFinancialAccount->find($financial_account_id);
                    $update_financial_account_data = [
                        'account_balance' => $financial_account_item['account_balance'] + $all_total_price
                    ];
                    $this->modelFinancialAccount->update($financial_account_id, $update_financial_account_data);

                    $lastc = $total_stock_amount;
                    $amount_to_be_processed = $all_total_price * -1;
                    $firstCariBalance = $cari_item['cari_balance'] + $faturaAsilTutar;
                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] + $faturaAsilTutar
                    ];
                    $this->modelCari->update($cari_item['cari_id'], $update_cari_data);

                    //fatura oluştur anında tahsilat yapıldı ise oluşan finansal hareket id ver
                    $update_collect_invoice_data = [
                        'is_quick_collection_financial_movement_id' => $is_collection_financial_movement_id,
                    ];
                    $this->modelInvoice->update($invoice_id, $update_collect_invoice_data);

                    $update_cari_data = [
                        'cari_balance' => $firstCariBalance + $lastc,
                    ];
                    $this->modelCari->update($cari_item['cari_id'], $update_cari_data);

                    
                } else {
                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] + $faturaAsilTutar
                    ];
                    $this->modelCari->update($cari_item['cari_id'], $update_cari_data);
                }

                // Cari Güncelle

                $this->bakiyeHesapla($cari_item["cari_id"]);


             
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'shipment',
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

        $json_data = [
            'icon' => 'success',
            'message' => 'Satış kaydı başarıyla oluşturuldu.',
          
        ];

    
        echo json_encode($json_data);
        return;


    }


    public function barkodEkle()
    {
        $stock_id = $this->request->getPost('stock_id');
        $barcodes = $this->request->getPost('barcodes');
    
        $excludeStockBarcodeIds = [];
        foreach ($barcodes as $barcodeData) {
            if (is_string($barcodeData)) {
                $barcodeData = json_decode($barcodeData, true);
            }
            $excludeStockBarcodeIds[] = $barcodeData['stock_barcode_id'];
        }
    
        $remainingBarcodes = $this->modelStockBarcode
            ->where('stock_id', $stock_id)
            ->whereIn('stock_barcode_id', $excludeStockBarcodeIds)
            ->findAll();
    
        $cari_id_stok = session()->get('user_item')["stock_user"];
    
        foreach ($remainingBarcodes as $barkod) {
            $stokHareketleri = $this->modelStockMovement
                ->where("stock_barcode_id", $barkod["stock_barcode_id"])
                ->where("movement_type", "outgoing")
                ->first();
    
            if ($stokHareketleri) {
                $faturaHareketleri = $this->modelInvoice
                    ->where("invoice_id", $stokHareketleri["invoice_id"])
                    ->where("invoice_direction", "outgoing_invoice")
                    ->first();
    
                if ($faturaHareketleri) {
                    $this->modelFinancialMovement
                        ->where("invoice_id", $stokHareketleri["invoice_id"])
                        ->where("cari_id", $cari_id_stok)
                        ->delete();
                }
    
                $faturaSatir = $this->modelInvoiceRow
                    ->where("invoice_id", $stokHareketleri["invoice_id"])
                    ->first();
    
                if ($faturaSatir) {
                    $this->modelInvoiceRow
                        ->where("invoice_id", $stokHareketleri["invoice_id"])
                        ->delete();
                }
    
                $this->modelStockMovement
                    ->where("stock_barcode_id", $barkod["stock_barcode_id"])
                    ->where("movement_type", "outgoing")
                    ->delete();
                    $stokBilgileri     = $this->modelStocks->where("stock_id", $barkod["stock_id"])->first();

                    $this->stokHesaplat($stokBilgileri["parent_id"]);
            }
    
            $this->modelStockBarcode
                ->set("used_amount", 0)
                ->set("stock_barcode_status", "available")
                ->where("stock_barcode_id", $barkod["stock_barcode_id"])
                ->update();

            
        }
    
    
        $json_data = [
            'icon' => 'success',
            'message' => 'Barkodlar Stoğa Başarıyla Eklendi!',
          
        ];

    
        echo json_encode($json_data);
        return;
    
    }


    public function storeSaleOrderIade()
    {
        if ($this->request->getMethod('true') == 'POST') {





          /* 
            echo '<pre>';
            print_r($this->request->getPost());
            echo '</pre>';

            exit;
          */

            try {
                $errList = [];
                $all_total_price = 0;
                $transaction_prefix = "PRF";
                $tahsilat_prefix = "THS";
                $form_data = $this->request->getPost('formData');
                $sale_order_items_data = $this->request->getPost('sale_order_items');
                foreach ($form_data as $data) {
                    $key = $data['name'];
                    $value = $data['value'];
                    $new_form_data[$key] = $value;
                }

                // print_r($form_data);
                // print_r($sale_order_items_data);
                // return;


                $from_where = $new_form_data['warehouse_id'];
                $to_where = $new_form_data['cari_id'];
                $shipment_note = $new_form_data['shipment_note'];
                
                $total_stock_amount = number_format($new_form_data['total_stock_amount'], 2, ',', '.');
                $total_stock_amount = convert_number_for_sql($total_stock_amount);
                $total_stock_amount_try = number_format($new_form_data['total_stock_amount_try'], 2, ',', '.');
                $total_stock_amount_try = convert_number_for_sql($total_stock_amount_try);

                $currency_amount = $new_form_data['currency_amount'] ?? 1;
                $money_unit_id = $new_form_data['money_unit_id'] ?? 1;

                $warehouse_item = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('warehouse_id', $from_where)->first();
                if (!$warehouse_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Depo bulunamadı']);
                    return;
                }
                $cari_item = $this->modelCari->join('address', 'cari.cari_id = address.cari_id', 'left')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id', $to_where)->first();
                if (!$cari_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Cari bulunamadı']);
                    return;
                }

                //6 rakamlı sipariş barkod kodu
                $create_sale_order_code = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

                $prefix = "IADE";
                $random_value = $prefix . $from_where . $create_sale_order_code;


                // print_r($random_value);
                // return;

                $insert_invoice_data = [
                    'user_id' => session()->get('user_id'),

                    'money_unit_id' => $money_unit_id,
                    'sale_type' => "quick",
                    'invoice_no' => $random_value,

                    'invoice_direction' => 'outgoing_invoice',
                    'invoice_date' => new Time('now', 'Turkey', 'en_US'),
                    'expiry_date' => new Time('now', 'Turkey', 'en_US'),
                    'invoice_type' => 'IADE',
                    'currency_amount' => $currency_amount,


                    'stock_total' => $total_stock_amount,
                    'stock_total_try' => $total_stock_amount_try,
                    'sub_total' => $total_stock_amount,
                    'sub_total_try' => $total_stock_amount_try,
                    'grand_total' => $total_stock_amount,
                    'grand_total_try' => $total_stock_amount_try,
                    'amount_to_be_paid' => $total_stock_amount,
                    'amount_to_be_paid_try' => $total_stock_amount_try,

                    'invoice_note' => $new_form_data['shipment_note'],

                    'cari_id' => $cari_item['cari_id'],
                    'cari_identification_number' => $cari_item['identification_number'],
                    'cari_tax_administration' => $cari_item['tax_administration'],

                    'cari_invoice_title' => $cari_item['invoice_title'] == '' ? $cari_item['name'] . " " . $cari_item['surname'] : $cari_item['invoice_title'],
                    'cari_name' => $cari_item['name'],
                    'cari_surname' => $cari_item['surname'],
                    'cari_obligation' => $cari_item['obligation'],
                    'cari_company_type' => $cari_item['company_type'],
                    'cari_phone' => $cari_item['cari_phone'],
                    'cari_email' => $cari_item['cari_email'],

                    'address_country' => $cari_item['address_country'],

                    'address_city' => isset($cari_item['address_city_name']) ? $cari_item['address_city_name'] : "",
                    'address_city_plate' => isset($cari_item['address_city']) ? $cari_item['address_city'] : "",
                    'address_district' => isset($cari_item['address_district']) ? $cari_item['address_district'] : "",
                    'address_zip_code' => $cari_item['zip_code'],
                    'address' => $cari_item['address'],

                    'invoice_status_id' => "1",
                ];

                // print_r($insert_invoice_data);
                // return;

                $this->modelInvoice->insert($insert_invoice_data);
                $invoice_id = $this->modelInvoice->getInsertID();




                $kurlar = json_decode($new_form_data["kurlar"], true);

                if(isset($kurlar)){

                    foreach ($kurlar as $kur) {
                        // Fatura fiyatı mevcut mu kontrol et (fatura_id ve money_unit_id'yi kontrol ediyoruz)
                        $InvoiceFiyatlar = $this->modelFaturaTutar
                                                ->where("fatura_id", $invoice_id)
                                                ->where("kur", $kur['money_unit_id']) // Ek olarak money_unit_id kontrolü
                                                ->first();
                        
                        // Default değerini belirle
                        $default = ($new_form_data['money_unit_id'] == $kur['money_unit_id']) ? "true" : "false";
                    
                        // Fiyat verilerini hazırlama
                        $fiyatDatalar = [
                            'user_id'      => session()->get('user_id'),
                            'cari_id'      => $cari_item['cari_id'],
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
                    

                }


                # TODO: Eğer hızlı satışlar sevkiyatlara da işlenicekse buradaki yorum satırı açılmalı.
                // $last_shipment = $this->modelShipment->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                // if ($last_shipment) {
                //     $shipment_counter = $last_shipment['transaction_counter'] + 1;
                // } else {
                //     $shipment_counter = 1;
                // }
                // $shipment_number = $shipment_prefix . str_pad($shipment_counter, 6, '0', STR_PAD_LEFT);

                // $shipment_insert_data = [
                //     'user_id' => session()->get('user_id'),
                //     'shipment_number' => $shipment_number,
                //     'departure_date' => null,
                //     'arrival_date' => null,
                //     'shipment_status' => 'successful',
                //     'from_where' => $from_where,
                //     'to_where' => $to_where,
                //     'shipment_type' => 'warehouse_to_customer',
                //     'ordered_stock_amount' => $total_stock_amount,
                //     'shipped_stock_amount' => $total_stock_amount,
                //     'received_stock_amount' => $total_stock_amount,
                //     'shipment_note' => $shipment_note,
                //     'failed_reason' => null,
                //     'transaction_prefix' => $shipment_prefix,
                //     'transaction_counter' => $shipment_counter
                // ];
                // $this->modelShipment->insert($shipment_insert_data);
                // $shipment_id = $this->modelShipment->getInsertID();

                foreach ($sale_order_items_data as $sale_order_item) {
                    $sale_amount = convert_number_for_sql($sale_order_item['sale_amount']);
                    $sale_unit_price = convert_number_for_sql($sale_order_item['sale_unit_price']);

                    // print_r($sale_amount." ");
                    // print_r($sale_unit_price);
                    // return;

                    $barcode_number = convert_barcode_number_for_sql($sale_order_item['barcode_number']);

                    # TODO: Burada barkodun durumunun satış yapılmaya uygunluğunu kontrol ediyoruz.
                    #       Eğer buralara istisnalar koyulacaksa buraya bakılması gerekiyor.
                    $chk_barcode = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                        ->where('stock.user_id', session()->get('user_id'))
                        ->where('stock_barcode.barcode_number', $barcode_number)
                        ->first();
                    if (!$chk_barcode) {
                        $errList[$sale_order_item['barcode_number']] = "Geçersiz barkod numarası.";
                        continue;
                    } else if ($chk_barcode['stock_barcode_status'] == 'out_of_stock') {
                        $errList[$sale_order_item['barcode_number']] = "Girilen barkod bilgisindeki tüm ürün miktarı daha önce kullanıdı.";
                        continue;
                    } else if ($chk_barcode['stock_barcode_status'] != 'available') {
                        $errList[$sale_order_item['barcode_number']] = "Girilen barkod siparişe eklenmeye uygun değil.";
                        continue;
                    } else if ($sale_amount > $chk_barcode['total_amount'] - $chk_barcode['used_amount']) {
                        $errList[$sale_order_item['barcode_number']] = "Bu barkod numarası için istenen miktar barkodtaki miktardan fazla.";
                        continue;
                    } else if ($chk_barcode['warehouse_id'] != $from_where) {
                        $errList[$sale_order_item['barcode_number']] = "Bu barkod numarası girilen depoda bulunamadı.";
                        continue;
                    }

                    $old_stock_movement = $this->modelStockMovement
                        ->where('stock_movement.user_id', session()->get('user_id'))
                        ->where('stock_barcode_id', $chk_barcode['stock_barcode_id'])
                        ->first();

                    // print_r($old_stock_movement);
                    // return;

                    $total_price = $sale_unit_price * $sale_amount;

                    try {
                        $insert_invoice_row_data = [
                            'user_id' => session()->get('user_id'),
                            'cari_id' => $to_where,
                            'invoice_id' => $invoice_id,
                            'stock_id' => $chk_barcode['stock_id'],
                            'stock_barcode_id' => $chk_barcode['stock_barcode_id'],
                            'stock_title' => $chk_barcode['stock_title'],
                            'stock_amount' => $sale_amount, //convert_number_for_sql($data_invoice_row['stock_amount'])

                            'unit_id' => $chk_barcode['sale_unit_id'],
                            'unit_price' => $sale_unit_price,

                            'subtotal_price' => $total_price,

                            # Vergi oranı 0 olduğu için statik tanımlandı.
                            'tax_id' => 1,
                            'total_price' => $total_price,
                        ];
                        $this->modelInvoiceRow->insert($insert_invoice_row_data);

                        # TODO: İhtiyaç halinde açılabilir.
                        // $sale_order_item_insert_data = [
                        //     # TODO: Eğer hızlı satışlar sevkiyatlara da işlenicekse buradaki yorum satırı açılmalı.
                        //     'shipment_id' => '',
                        //     'invoice_id' => $invoice_id,
                        //     'stock_barcode_id' => $chk_barcode['stock_barcode_id'],
                        //     'sale_unit_id' => $sale_order_item['sale_unit_id'],
                        //     'sale_amount' => $sale_amount,
                        //     'sale_money_unit_id' => $sale_order_item['sale_money_unit_id'],
                        //     'sale_unit_price' => $sale_unit_price,
                        //     'total_price' => $total_price,
                        // ];
                        // $this->modelSaleOrderItem->insert($sale_order_item_insert_data);
                        $all_total_price += $total_price;

                        $used_amount = $chk_barcode['used_amount'] + $sale_amount;
                        $stock_barcode_status = $used_amount == $chk_barcode['total_amount'] ? 'out_of_stock' : 'available';
                        $update_stock_barcode_data = [
                            'used_amount' => $used_amount,
                            'stock_barcode_status' => $stock_barcode_status
                        ];
                        $this->modelStockBarcode->update($chk_barcode['stock_barcode_id'], $update_stock_barcode_data);


                        $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                        if ($last_transaction) {
                            $transaction_counter = $last_transaction['transaction_counter'] + 1;
                        } else {
                            $transaction_counter = 1;
                        }
                        $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);

                        $insert_stock_movement_data = [
                            'user_id' => session()->get('user_id'),
                            'stock_barcode_id' => $chk_barcode['stock_barcode_id'],
                            'invoice_id' => $invoice_id,
                            'supplier_id' => $old_stock_movement['supplier_id'],
                            'movement_type' => 'outgoing',
                            'transaction_number' => $transaction_number,
                            'from_warehouse' => $from_where,
                            'transaction_note' => null,
                            'transaction_info' => 'İade Çıkış',
                            'sale_unit_price' => $sale_unit_price,
                            'sale_money_unit_id' => $sale_order_item['sale_money_unit_id'],
                            'transaction_quantity' => $sale_amount,
                            'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                            'transaction_prefix' => $transaction_prefix,
                            'transaction_counter' => $transaction_counter,
                        ];
                        $this->modelStockMovement->insert($insert_stock_movement_data);

                        // updateStockQuantity($chk_barcode['stock_id'], str_replace(',', '.', $sale_amount), 'remove', $this->modelStocks);

                        $insert_StockWarehouseQuantity = [
                            'user_id' => 0
                        ];

                        // print_r($from_where.' ');
                        // print_r(' '.$chk_barcode['stock_id'].' ');
                        // print_r(' '.$chk_barcode['parent_id'].' ');
                        // print_r(' '.str_replace(',', '.', $sale_amount).' ');
                        // exit();

                        $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $from_where, $chk_barcode['stock_id'], $chk_barcode['parent_id'], str_replace(',', '.', $sale_amount), 'remove', $this->modelStockWarehouseQuantity, $this->modelStocks);
                        if ($addStock === 'eksi_stok') {
                           // echo json_encode(['icon' => 'error', 'message' => 'bu işlemden sonra stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz.']);
                            //return;
                        }


                    } catch (\Exception $e) {
                        $this->logClass->save_log(
                            'error',
                            'sale_order_item',
                            null,
                            null,
                            'create',
                            $e->getMessage(),
                            json_encode($_POST)
                        );
                        echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                        continue;
                    }
                }

                #TODO: Eğer fiyatlar fronttan gelmicekse
                // $update_invoice_data = [
                //     'stock_total' => $total_price * $currency_amount,
                //     'stock_total_try' => $total_price,
                //     'sub_total' => $total_price * $currency_amount,
                //     'sub_total_try' => $total_price,
                //     'sub_total_0' => $total_price * $currency_amount,
                //     'sub_total_0_try' => $total_price,
                //     'grand_total' => $total_price * $currency_amount,
                //     'grand_total_try' => $total_price,
                // ];
                // $this->modelInvoice->update($invoice_id, $update_invoice_data);

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
                    'cari_id' => $to_where,
                    'money_unit_id' => $sale_order_item['sale_money_unit_id'],
                    'transaction_number' => $transaction_number,
                    'transaction_direction' => 'exit',
                    'transaction_type' => 'outgoing_invoice',
                    'invoice_id' => $invoice_id,
                    'transaction_tool' => 'not_payroll',
                    'transaction_title' => 'Hızlı iade faturasından oluşan hareket',
                    'transaction_description' => $shipment_note,
                    'transaction_amount' => $all_total_price,
                    'transaction_real_amount' => $all_total_price,
                    'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                    'transaction_prefix' => $transaction_prefix,
                    'transaction_counter' => $transaction_counter
                ];
                $this->modelFinancialMovement->insert($insert_financial_movement_data);


                // $update_cari_data = [
                //     'cari_balance' => $cari_item['cari_balance'] + $all_total_price
                // ];
                // $this->modelCari->update($cari_item['cari_id'], $update_cari_data);


                $kurlar = json_decode($new_form_data["kurlar"], true);
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
                $faturaAsilTutar = $all_total_price;
               }



                #tahsilat yapılmışsa...
                if ($new_form_data['has_collection'] == 1) {

                    $financial_account_id = isset($new_form_data['selectedAccount']) ? $new_form_data['selectedAccount'] : '';
                    $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                    if ($last_transaction) {
                        $transaction_counter = $last_transaction['transaction_counter'] + 1;
                    } else {
                        $transaction_counter = 1;
                    }
                    $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                    $insert_financial_movement_data = [
                        'user_id' => session()->get('user_id'),
                        'financial_account_id' => $financial_account_id,
                        'cari_id' => $to_where,
                        'money_unit_id' => $sale_order_item['sale_money_unit_id'],
                        'transaction_number' => $transaction_number,
                        'transaction_direction' => 'entry',
                        'transaction_type' => 'collection',
                        'invoice_id' => $invoice_id,
                        'transaction_tool' => 'not_payroll',
                        'transaction_title' => 'Hızlı iade faturası anında yapılan tahsilat hareketi',
                        'transaction_description' => $shipment_note,
                        'transaction_amount' => $all_total_price,
                        'transaction_real_amount' => $all_total_price,
                        'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                        'transaction_prefix' => $transaction_prefix,
                        'transaction_counter' => $transaction_counter
                    ];
                    $this->modelFinancialMovement->insert($insert_financial_movement_data);
                    $is_collection_financial_movement_id = $this->modelFinancialMovement->getInsertID();


                    $financial_account_item = $this->modelFinancialAccount->find($financial_account_id);
                    $update_financial_account_data = [
                        'account_balance' => $financial_account_item['account_balance'] + $all_total_price
                    ];
                    $this->modelFinancialAccount->update($financial_account_id, $update_financial_account_data);

                    $lastc = $new_form_data['total_stock_amount'];
                    $amount_to_be_processed = $all_total_price * -1;
                    $firstCariBalance = $cari_item['cari_balance'] + $faturaAsilTutar;
                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] + $faturaAsilTutar
                    ];
                    $this->modelCari->update($cari_item['cari_id'], $update_cari_data);

                    //fatura oluştur anında tahsilat yapıldı ise oluşan finansal hareket id ver
                    $update_collect_invoice_data = [
                        'is_quick_collection_financial_movement_id' => $is_collection_financial_movement_id,
                    ];
                    $this->modelInvoice->update($invoice_id, $update_collect_invoice_data);

                    $update_cari_data = [
                        'cari_balance' => $firstCariBalance + $lastc,
                    ];
                    $this->modelCari->update($cari_item['cari_id'], $update_cari_data);

                    
                } else {
                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] + $faturaAsilTutar
                    ];
                    $this->modelCari->update($cari_item['cari_id'], $update_cari_data);
                }

                // Cari Güncelle

                $this->bakiyeHesapla($cari_item["cari_id"]);


                $json_data = [
                    'icon' => 'success',
                    'message' => 'İade kaydı başarıyla oluşturuldu.',
                    'newOrderId' => $invoice_id,
                ];

                if (count($errList)) {
                    $json_data['errList'] = $errList;
                }
                echo json_encode($json_data);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'shipment',
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


    ## OTOMATİK SATIŞ KAPAMA 

    public function storeSaleOrder()
    {
        if ($this->request->getMethod('true') == 'POST') {





          /* 
            echo '<pre>';
            print_r($this->request->getPost());
            echo '</pre>';

            exit;
          */

            try {
                $errList = [];
                $all_total_price = 0;
                $transaction_prefix = "PRF";
                $tahsilat_prefix = "THS";
                $form_data = $this->request->getPost('formData');
                $sale_order_items_data = $this->request->getPost('sale_order_items');
                foreach ($form_data as $data) {
                    $key = $data['name'];
                    $value = $data['value'];
                    $new_form_data[$key] = $value;
                }

                // print_r($form_data);
                // print_r($sale_order_items_data);
                // return;


                $from_where = $new_form_data['warehouse_id'];
                $to_where = $new_form_data['cari_id'];
                $shipment_note = $new_form_data['shipment_note'];
                
                $total_stock_amount = number_format($new_form_data['total_stock_amount'], 2, ',', '.');
                $total_stock_amount = convert_number_for_sql($total_stock_amount);
                $total_stock_amount_try = number_format($new_form_data['total_stock_amount_try'], 2, ',', '.');
                $total_stock_amount_try = convert_number_for_sql($total_stock_amount_try);

                $currency_amount = $new_form_data['currency_amount'] ?? 1;
                $money_unit_id = $new_form_data['money_unit_id'] ?? 1;

                $warehouse_item = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('warehouse_id', $from_where)->first();
                if (!$warehouse_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Depo bulunamadı']);
                    return;
                }
                $cari_item = $this->modelCari->join('address', 'cari.cari_id = address.cari_id', 'left')->where('address.default', 'true')->where('cari.user_id', session()->get('user_id'))->where('cari.cari_id', $to_where)->first();
                if (!$cari_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Cari bulunamadı']);
                    return;
                }

                //6 rakamlı sipariş barkod kodu
                $create_sale_order_code = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

                $prefix = "SPR";
                $random_value = $prefix . $from_where . $create_sale_order_code;


                // print_r($random_value);
                // return;

                $insert_invoice_data = [
                    'user_id' => session()->get('user_id'),

                    'money_unit_id' => $money_unit_id,
                    'sale_type' => "quick",
                    'invoice_no' => $random_value,

                    'invoice_direction' => 'outgoing_invoice',
                    'invoice_date' => new Time('now', 'Turkey', 'en_US'),
                    'expiry_date' => new Time('now', 'Turkey', 'en_US'),

                    'currency_amount' => $currency_amount,


                    'stock_total' => $total_stock_amount,
                    'stock_total_try' => $total_stock_amount_try,
                    'sub_total' => $total_stock_amount,
                    'sub_total_try' => $total_stock_amount_try,
                    'grand_total' => $total_stock_amount,
                    'grand_total_try' => $total_stock_amount_try,
                    'amount_to_be_paid' => $total_stock_amount,
                    'amount_to_be_paid_try' => $total_stock_amount_try,

                    'invoice_note' => $new_form_data['shipment_note'],

                    'cari_id' => $cari_item['cari_id'],
                    'cari_identification_number' => $cari_item['identification_number'],
                    'cari_tax_administration' => $cari_item['tax_administration'],

                    'cari_invoice_title' => $cari_item['invoice_title'] == '' ? $cari_item['name'] . " " . $cari_item['surname'] : $cari_item['invoice_title'],
                    'cari_name' => $cari_item['name'],
                    'cari_surname' => $cari_item['surname'],
                    'cari_obligation' => $cari_item['obligation'],
                    'cari_company_type' => $cari_item['company_type'],
                    'cari_phone' => $cari_item['cari_phone'],
                    'cari_email' => $cari_item['cari_email'],

                    'address_country' => $cari_item['address_country'],

                    'address_city' => isset($cari_item['address_city_name']) ? $cari_item['address_city_name'] : "",
                    'address_city_plate' => isset($cari_item['address_city']) ? $cari_item['address_city'] : "",
                    'address_district' => isset($cari_item['address_district']) ? $cari_item['address_district'] : "",
                    'address_zip_code' => $cari_item['zip_code'],
                    'address' => $cari_item['address'],

                    'invoice_status_id' => "1",
                ];

                // print_r($insert_invoice_data);
                // return;

                $this->modelInvoice->insert($insert_invoice_data);
                $invoice_id = $this->modelInvoice->getInsertID();




                $kurlar = json_decode($new_form_data["kurlar"], true);

                if(isset($kurlar)){

                    foreach ($kurlar as $kur) {
                        // Fatura fiyatı mevcut mu kontrol et (fatura_id ve money_unit_id'yi kontrol ediyoruz)
                        $InvoiceFiyatlar = $this->modelFaturaTutar
                                                ->where("fatura_id", $invoice_id)
                                                ->where("kur", $kur['money_unit_id']) // Ek olarak money_unit_id kontrolü
                                                ->first();
                        
                        // Default değerini belirle
                        $default = ($new_form_data['money_unit_id'] == $kur['money_unit_id']) ? "true" : "false";
                    
                        // Fiyat verilerini hazırlama
                        $fiyatDatalar = [
                            'user_id'      => session()->get('user_id'),
                            'cari_id'      => $cari_item['cari_id'],
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
                    

                }


                # TODO: Eğer hızlı satışlar sevkiyatlara da işlenicekse buradaki yorum satırı açılmalı.
                // $last_shipment = $this->modelShipment->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                // if ($last_shipment) {
                //     $shipment_counter = $last_shipment['transaction_counter'] + 1;
                // } else {
                //     $shipment_counter = 1;
                // }
                // $shipment_number = $shipment_prefix . str_pad($shipment_counter, 6, '0', STR_PAD_LEFT);

                // $shipment_insert_data = [
                //     'user_id' => session()->get('user_id'),
                //     'shipment_number' => $shipment_number,
                //     'departure_date' => null,
                //     'arrival_date' => null,
                //     'shipment_status' => 'successful',
                //     'from_where' => $from_where,
                //     'to_where' => $to_where,
                //     'shipment_type' => 'warehouse_to_customer',
                //     'ordered_stock_amount' => $total_stock_amount,
                //     'shipped_stock_amount' => $total_stock_amount,
                //     'received_stock_amount' => $total_stock_amount,
                //     'shipment_note' => $shipment_note,
                //     'failed_reason' => null,
                //     'transaction_prefix' => $shipment_prefix,
                //     'transaction_counter' => $shipment_counter
                // ];
                // $this->modelShipment->insert($shipment_insert_data);
                // $shipment_id = $this->modelShipment->getInsertID();

                foreach ($sale_order_items_data as $sale_order_item) {
                    $sale_amount = convert_number_for_sql($sale_order_item['sale_amount']);
                    $sale_unit_price = convert_number_for_sql($sale_order_item['sale_unit_price']);

                    // print_r($sale_amount." ");
                    // print_r($sale_unit_price);
                    // return;

                    $barcode_number = convert_barcode_number_for_sql($sale_order_item['barcode_number']);

                    # TODO: Burada barkodun durumunun satış yapılmaya uygunluğunu kontrol ediyoruz.
                    #       Eğer buralara istisnalar koyulacaksa buraya bakılması gerekiyor.
                    $chk_barcode = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                        ->where('stock.user_id', session()->get('user_id'))
                        ->where('stock_barcode.barcode_number', $barcode_number)
                        ->first();
                    if (!$chk_barcode) {
                        $errList[$sale_order_item['barcode_number']] = "Geçersiz barkod numarası.";
                        continue;
                    } else if ($chk_barcode['stock_barcode_status'] == 'out_of_stock') {
                        $errList[$sale_order_item['barcode_number']] = "Girilen barkod bilgisindeki tüm ürün miktarı daha önce kullanıdı.";
                        continue;
                    } else if ($chk_barcode['stock_barcode_status'] != 'available') {
                        $errList[$sale_order_item['barcode_number']] = "Girilen barkod siparişe eklenmeye uygun değil.";
                        continue;
                    } else if ($sale_amount > $chk_barcode['total_amount'] - $chk_barcode['used_amount']) {
                        $errList[$sale_order_item['barcode_number']] = "Bu barkod numarası için istenen miktar barkodtaki miktardan fazla.";
                        continue;
                    } else if ($chk_barcode['warehouse_id'] != $from_where) {
                        $errList[$sale_order_item['barcode_number']] = "Bu barkod numarası girilen depoda bulunamadı.";
                        continue;
                    }

                    $old_stock_movement = $this->modelStockMovement
                        ->where('stock_movement.user_id', session()->get('user_id'))
                        ->where('stock_barcode_id', $chk_barcode['stock_barcode_id'])
                        ->first();

                    // print_r($old_stock_movement);
                    // return;

                    $total_price = $sale_unit_price * $sale_amount;

                    try {
                        $insert_invoice_row_data = [
                            'user_id' => session()->get('user_id'),
                            'cari_id' => $to_where,
                            'invoice_id' => $invoice_id,
                            'stock_id' => $chk_barcode['stock_id'],
                            'stock_barcode_id' => $chk_barcode['stock_barcode_id'],
                            'stock_title' => $chk_barcode['stock_title'],
                            'stock_amount' => $sale_amount, //convert_number_for_sql($data_invoice_row['stock_amount'])

                            'unit_id' => $chk_barcode['sale_unit_id'],
                            'unit_price' => $sale_unit_price,

                            'subtotal_price' => $total_price,

                            # Vergi oranı 0 olduğu için statik tanımlandı.
                            'tax_id' => 1,
                            'total_price' => $total_price,
                        ];
                        $this->modelInvoiceRow->insert($insert_invoice_row_data);

                        # TODO: İhtiyaç halinde açılabilir.
                        // $sale_order_item_insert_data = [
                        //     # TODO: Eğer hızlı satışlar sevkiyatlara da işlenicekse buradaki yorum satırı açılmalı.
                        //     'shipment_id' => '',
                        //     'invoice_id' => $invoice_id,
                        //     'stock_barcode_id' => $chk_barcode['stock_barcode_id'],
                        //     'sale_unit_id' => $sale_order_item['sale_unit_id'],
                        //     'sale_amount' => $sale_amount,
                        //     'sale_money_unit_id' => $sale_order_item['sale_money_unit_id'],
                        //     'sale_unit_price' => $sale_unit_price,
                        //     'total_price' => $total_price,
                        // ];
                        // $this->modelSaleOrderItem->insert($sale_order_item_insert_data);
                        $all_total_price += $total_price;

                        $used_amount = $chk_barcode['used_amount'] + $sale_amount;
                        $stock_barcode_status = $used_amount == $chk_barcode['total_amount'] ? 'out_of_stock' : 'available';
                        $update_stock_barcode_data = [
                            'used_amount' => $used_amount,
                            'stock_barcode_status' => $stock_barcode_status
                        ];
                        $this->modelStockBarcode->update($chk_barcode['stock_barcode_id'], $update_stock_barcode_data);


                        $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                        if ($last_transaction) {
                            $transaction_counter = $last_transaction['transaction_counter'] + 1;
                        } else {
                            $transaction_counter = 1;
                        }
                        $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);

                        $insert_stock_movement_data = [
                            'user_id' => session()->get('user_id'),
                            'stock_barcode_id' => $chk_barcode['stock_barcode_id'],
                            'invoice_id' => $invoice_id,
                            'supplier_id' => $old_stock_movement['supplier_id'],
                            'movement_type' => 'outgoing',
                            'transaction_number' => $transaction_number,
                            'from_warehouse' => $from_where,
                            'transaction_note' => null,
                            'transaction_info' => 'Stok Çıkış',
                            'sale_unit_price' => $sale_unit_price,
                            'sale_money_unit_id' => $sale_order_item['sale_money_unit_id'],
                            'transaction_quantity' => $sale_amount,
                            'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                            'transaction_prefix' => $transaction_prefix,
                            'transaction_counter' => $transaction_counter,
                        ];
                        $this->modelStockMovement->insert($insert_stock_movement_data);

                        // updateStockQuantity($chk_barcode['stock_id'], str_replace(',', '.', $sale_amount), 'remove', $this->modelStocks);

                        $insert_StockWarehouseQuantity = [
                            'user_id' => 0
                        ];

                        // print_r($from_where.' ');
                        // print_r(' '.$chk_barcode['stock_id'].' ');
                        // print_r(' '.$chk_barcode['parent_id'].' ');
                        // print_r(' '.str_replace(',', '.', $sale_amount).' ');
                        // exit();

                        $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $from_where, $chk_barcode['stock_id'], $chk_barcode['parent_id'], str_replace(',', '.', $sale_amount), 'remove', $this->modelStockWarehouseQuantity, $this->modelStocks);
                        if ($addStock === 'eksi_stok') {
                           // echo json_encode(['icon' => 'error', 'message' => 'bu işlemden sonra stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz.']);
                            //return;
                        }


                    } catch (\Exception $e) {
                        $this->logClass->save_log(
                            'error',
                            'sale_order_item',
                            null,
                            null,
                            'create',
                            $e->getMessage(),
                            json_encode($_POST)
                        );
                        echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                        continue;
                    }
                }

                #TODO: Eğer fiyatlar fronttan gelmicekse
                // $update_invoice_data = [
                //     'stock_total' => $total_price * $currency_amount,
                //     'stock_total_try' => $total_price,
                //     'sub_total' => $total_price * $currency_amount,
                //     'sub_total_try' => $total_price,
                //     'sub_total_0' => $total_price * $currency_amount,
                //     'sub_total_0_try' => $total_price,
                //     'grand_total' => $total_price * $currency_amount,
                //     'grand_total_try' => $total_price,
                // ];
                // $this->modelInvoice->update($invoice_id, $update_invoice_data);

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
                    'cari_id' => $to_where,
                    'money_unit_id' => $sale_order_item['sale_money_unit_id'],
                    'transaction_number' => $transaction_number,
                    'transaction_direction' => 'exit',
                    'transaction_type' => 'outgoing_invoice',
                    'invoice_id' => $invoice_id,
                    'transaction_tool' => 'not_payroll',
                    'transaction_title' => 'Hızlı satış faturasından oluşan hareket',
                    'transaction_description' => $shipment_note,
                    'transaction_amount' => $all_total_price,
                    'transaction_real_amount' => $all_total_price,
                    'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                    'transaction_prefix' => $transaction_prefix,
                    'transaction_counter' => $transaction_counter
                ];
                $this->modelFinancialMovement->insert($insert_financial_movement_data);


                // $update_cari_data = [
                //     'cari_balance' => $cari_item['cari_balance'] + $all_total_price
                // ];
                // $this->modelCari->update($cari_item['cari_id'], $update_cari_data);


                $kurlar = json_decode($new_form_data["kurlar"], true);
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
                $faturaAsilTutar = $all_total_price;
               }



                #tahsilat yapılmışsa...
                if ($new_form_data['has_collection'] == 1) {

                    $financial_account_id = isset($new_form_data['selectedAccount']) ? $new_form_data['selectedAccount'] : '';
                    $last_transaction = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                    if ($last_transaction) {
                        $transaction_counter = $last_transaction['transaction_counter'] + 1;
                    } else {
                        $transaction_counter = 1;
                    }
                    $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);
                    $insert_financial_movement_data = [
                        'user_id' => session()->get('user_id'),
                        'financial_account_id' => $financial_account_id,
                        'cari_id' => $to_where,
                        'money_unit_id' => $sale_order_item['sale_money_unit_id'],
                        'transaction_number' => $transaction_number,
                        'transaction_direction' => 'entry',
                        'transaction_type' => 'collection',
                        'invoice_id' => $invoice_id,
                        'transaction_tool' => 'not_payroll',
                        'transaction_title' => 'Hızlı satış faturası anında yapılan tahsilat hareketi',
                        'transaction_description' => $shipment_note,
                        'transaction_amount' => $all_total_price,
                        'transaction_real_amount' => $all_total_price,
                        'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                        'transaction_prefix' => $transaction_prefix,
                        'transaction_counter' => $transaction_counter
                    ];
                    $this->modelFinancialMovement->insert($insert_financial_movement_data);
                    $is_collection_financial_movement_id = $this->modelFinancialMovement->getInsertID();


                    $financial_account_item = $this->modelFinancialAccount->find($financial_account_id);
                    $update_financial_account_data = [
                        'account_balance' => $financial_account_item['account_balance'] + $all_total_price
                    ];
                    $this->modelFinancialAccount->update($financial_account_id, $update_financial_account_data);

                    $lastc = $new_form_data['total_stock_amount'];
                    $amount_to_be_processed = $all_total_price * -1;
                    $firstCariBalance = $cari_item['cari_balance'] + $faturaAsilTutar;
                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] + $faturaAsilTutar
                    ];
                    $this->modelCari->update($cari_item['cari_id'], $update_cari_data);

                    //fatura oluştur anında tahsilat yapıldı ise oluşan finansal hareket id ver
                    $update_collect_invoice_data = [
                        'is_quick_collection_financial_movement_id' => $is_collection_financial_movement_id,
                    ];
                    $this->modelInvoice->update($invoice_id, $update_collect_invoice_data);

                    $update_cari_data = [
                        'cari_balance' => $firstCariBalance + $lastc,
                    ];
                    $this->modelCari->update($cari_item['cari_id'], $update_cari_data);

                    
                } else {
                    $update_cari_data = [
                        'cari_balance' => $cari_item['cari_balance'] + $faturaAsilTutar
                    ];
                    $this->modelCari->update($cari_item['cari_id'], $update_cari_data);
                }

                // Cari Güncelle

                $this->bakiyeHesapla($cari_item["cari_id"]);


                $json_data = [
                    'icon' => 'success',
                    'message' => 'Satış kaydı başarıyla oluşturuldu.',
                    'newOrderId' => $invoice_id,
                ];

                if (count($errList)) {
                    $json_data['errList'] = $errList;
                }
                echo json_encode($json_data);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'shipment',
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

    function convert_sql($number) {
        // Virgül ile ayrılmış ondalık sayıyı noktaya çevir
        $number = str_replace(",", ".", $number);
    
        // Eğer sayı ondalıklıysa iki ondalık basamağa kadar yuvarla
        return number_format((float)$number, 2, '.', '');
    }

    public function fatura_duzelt()
    {
        /* 
             $old_stock_fiyat_bulucu = $this->modelStockMovement
                ->select('supplier_id, buy_unit_price, buy_money_unit_id')
                ->where('user_id', session()->get('user_id'))
                ->where('movement_type', "incoming")
                ->where('stock_barcode_id', $stock_barcode_item['stock_barcode_id'])
                ->first();
       

        $faturaSatirlari = $this->modelInvoiceRow->where("is_return", "custom")->findAll();
        foreach($faturaSatirlari as $fatura)
        {
            $stock_barcode_item = $this->modelStockBarcode->where('stock_barcode_id', $fatura['stock_barcode_id'])->first();
            if(!empty($stock_barcode_item['stock_barcode_id'])):
            $old_stock_fiyat_bulucu = $this->modelStockMovement
                ->select('supplier_id, buy_unit_price, buy_money_unit_id')
                ->where('user_id', session()->get('user_id'))
                ->where('movement_type', "incoming")
                ->where('stock_barcode_id', $stock_barcode_item['stock_barcode_id'])
                ->first();
            $urununTedarikciFiyati = $old_stock_fiyat_bulucu["buy_unit_price"];

           $modelSet = $this->modelInvoiceRow->set("tedarik_price", $urununTedarikciFiyati)->where("invoice_row_id", $fatura["invoice_row_id"])->update();
           if($modelSet){
            echo 'Başarıyla Güncellendi ' . $fatura["invoice_row_id"] . "<br>";
           }else{
            echo 'HATA ' . $fatura["invoice_row_id"] . "<br>";

           }

        endif;

        }

         */

        
    }





    public function PriceSaleOrder()
{
    if ($this->request->getMethod(true) == 'POST') {
        try {
            $errList = [];
            $all_total_price = 0;
            $form_data = $this->request->getPost('data_form');

            // Form verilerini al ve düzenle
            foreach ($form_data as $data) {
                $key = $data['name'];
                $value = $data['value'];
                $new_form_data[$key] = $value;
            }

            // Stok barkod ve fatura satırı verilerini al
            $stokBarkoddanBul = $this->modelStockBarcode->where("stock_barcode_id", $new_form_data['stock_barcode_id'])->first();
            $stokDegeriniBul = $this->modelStocks->where("stock_id", $stokBarkoddanBul['stock_id'])->first();
            $invoice_fatura = $this->modelInvoiceRow->where("invoice_row_id", $new_form_data['satir_id'])->first();
            $invoice_fatura_full = $this->modelInvoice->where("invoice_id", $invoice_fatura["invoice_id"])->first();
    
            // Fatura satırını güncelle
            $updateSatir = [
                'unit_price' => $this->convert_sql($new_form_data["return_price"])
            ];
            $update = $this->modelInvoiceRow->set($updateSatir)->where("invoice_row_id", $new_form_data['satir_id'])->update();

            // Güncellenen satırdan fatura id'sini alın
            $invoice_id = $invoice_fatura["invoice_id"];

            // Faturanın tüm satırlarını al
            $invoice_rows = $this->modelInvoiceRow->where("invoice_id", $invoice_id)->findAll();

            // Faturanın toplam tutarını yeniden hesapla
            $grand_total = 0;
            $sub_total = 0;
            $tax_total = 0;
            $discount_total = 0;

            // Her bir satır için döviz kuru ve vergi oranına göre hesaplama yap
            foreach ($invoice_rows as $row) {
                $discount_rate = $row['discount_rate'] / 100;
                $discount_price = $row['unit_price'] * $row['stock_amount'] * $discount_rate;
                $subtotal_price = ($row['unit_price'] * $row['stock_amount']) - $discount_price;

                $tax_rate = $row['tax_id'] / 100;
                $tax_price = $subtotal_price * $tax_rate;
                $total_price = $subtotal_price + $tax_price;

                // Toplamları güncelle
                $sub_total += $subtotal_price;
                $tax_total += $tax_price;
                $discount_total += $discount_price;
                $grand_total += $total_price;

                // Satırdaki hesaplanmış değerleri güncelle
                $updateSatir = [
                    'discount_rate' => $row['discount_rate'],
                    'discount_price' => $discount_price,
                    'subtotal_price' => $subtotal_price,
                    'tax_id' => $row['tax_id'],
                    'tax_price' => $tax_price,
                    'total_price' => $total_price,
                ];

                // Fatura satırlarını güncelle
                $update = $this->modelInvoiceRow->set($updateSatir)->where("invoice_row_id", $row['invoice_row_id'])->update();
               
                if($invoice_fatura_full["invoice_direction"] == "incoming_invoice"){
                   $up_1 =   $this->modelStockMovement->set("buy_unit_price", $row['unit_price'])->where("invoice_id", $row['invoice_id'])->where("stock_barcode_id", $row['stock_barcode_id'])->update();
                }
                if($invoice_fatura_full["invoice_direction"] == "outgoing_invoice"){
                    $up_1 =   $this->modelStockMovement->set("sale_unit_price", $row['unit_price'])->where("invoice_id", $row['invoice_id'])->where("stock_barcode_id", $row['stock_barcode_id'])->update();
               }

           
                

                if (!$update) {
                    throw new \Exception("Fatura satırı güncellenemedi.");
                }
            }

            // Para birimine göre ana fatura güncellemeleri
                if ($invoice_fatura_full["money_unit_id"] == 3) { // TÜRK LİRASI
                    $updateInvoice = [
                        'stock_total' => $sub_total,
                        'stock_total_try' => $sub_total,
                        'discount_total' => $discount_total,
                        'discount_total_try' => $discount_total,
                        'tax_rate_1_amount' => $tax_total,
                        'tax_rate_1_amount_try' => $tax_total,
                        'sub_total' => $sub_total,
                        'sub_total_try' => $sub_total,
                        'total_price' => $grand_total,
                        'grand_total' => $grand_total,
                        'grand_total_try' => $grand_total,
                        'amount_to_be_paid' => $grand_total,
                        'amount_to_be_paid_try' => $grand_total,
                    ];
                } elseif ($invoice_fatura_full["money_unit_id"] == 2) { // EURO
                    $currency_multiplier = $invoice_fatura_full["currency_amount"];
                    $updateInvoice = [
                        'stock_total' => $sub_total,
                        'stock_total_try' => $sub_total * $currency_multiplier,
                        'discount_total' =>$discount_total,
                        'discount_total_try' => $discount_total * $currency_multiplier,
                        'tax_rate_1_amount' => $tax_total,
                        'tax_rate_1_amount_try' => $tax_total * $currency_multiplier,
                        'sub_total' => $sub_total,
                        'sub_total_try' => $sub_total * $currency_multiplier,
                        'total_price' => $grand_total,
                        'grand_total' => $grand_total,
                        'grand_total_try' => $grand_total * $currency_multiplier,
                        'amount_to_be_paid' => $grand_total,
                        'amount_to_be_paid_try' => $grand_total * $currency_multiplier,
                    ];
                } elseif ($invoice_fatura_full["money_unit_id"] == 1) { // DOLAR
                    $currency_multiplier = $invoice_fatura_full["currency_amount"];
                    $updateInvoice = [
                        'stock_total' => $sub_total,
                        'stock_total_try' => $sub_total * $currency_multiplier,
                        'discount_total' => $discount_total,
                        'discount_total_try' => $discount_total * $currency_multiplier,
                        'tax_rate_1_amount' => $tax_total,
                        'tax_rate_1_amount_try' => $tax_total * $currency_multiplier,
                        'sub_total' => $sub_total,
                        'sub_total_try' => $sub_total * $currency_multiplier,
                        'total_price' => $grand_total,
                        'grand_total' => $grand_total,
                        'grand_total_try' => $grand_total * $currency_multiplier,
                        'amount_to_be_paid' => $grand_total,
                        'amount_to_be_paid_try' => $grand_total * $currency_multiplier,
                    ];
                }

                // Ana faturayı güncelle
                $updateInvoiceResult = $this->modelInvoice->set($updateInvoice)->where("invoice_id", $invoice_id)->update();


                $modelFaturalar = $this->modelFaturaTutar->where("fatura_id", $invoice_id)->findAll();

                if(!$modelFaturalar)
                {
                    $Moneyler = $this->modelMoneyUnit->findAll();
                    foreach($Moneyler as $mono)
                    {

                        $faturaDeger = $this->modelInvoice->where("invoice_id", $invoice_id)->first();

                      

                    
                        // Döviz kurunu float olarak alıyoruz
                        $kur_value = floatval($mono["money_value"]);
                        
                        // Ana fatura toplamını float olarak alıyoruz
                        $grand_total = floatval($faturaDeger["grand_total"]);
                        $default = ($faturaDeger['money_unit_id'] == $mono['money_unit_id']) ? "true" : "false";
                        // grand_total ile döviz kurunu çarparak toplam değeri hesaplıyoruz
                        if($default == "true"){
                            $toplamDeger = $grand_total;
                        }else{
                            $toplamDeger = $grand_total / $kur_value;

                        }
                        
                        // Sonuçtaki değeri 2 ondalık olarak biçimlendiriyoruz
                        $toplamDeger = number_format($toplamDeger, 2, '.', '');
                        
                        $fiyatDatalar = [
                            'user_id'      => session()->get('user_id'),
                            'cari_id'      => $faturaDeger["cari_id"],
                            'fatura_id'    => $invoice_id,
                            'kur'          => $mono['money_unit_id'],
                            'kur_value'    => $this->convert_sql($mono['money_value']),
                            'toplam_tutar' => $this->convert_sql($toplamDeger),
                            'tarih'        => date("d-m-Y h:i"),  // PHP'de date() fonksiyonu kullanılır
                            'default'      => $default
                        ];
  
                        $guncelle = $this->modelFaturaTutar->insert($fiyatDatalar);

                    }
                }

                foreach ($modelFaturalar as $faturaModel) {
                    // İlgili faturanın detaylarını alıyoruz
                    $faturaDeger = $this->modelInvoice->where("invoice_id", $invoice_id)->first();
                    
                    // Döviz kurunu float olarak alıyoruz
                    $kur_value = floatval($faturaModel["kur_value"]);
                    
                    // Ana fatura toplamını float olarak alıyoruz
                    $grand_total = floatval($faturaDeger["grand_total"]);
                
                    $default = ($faturaDeger['money_unit_id'] == $faturaModel['kur']) ? "true" : "false";
                    // grand_total ile döviz kurunu çarparak toplam değeri hesaplıyoruz
                    if($default == "true"){
                        $toplamDeger = $grand_total;
                    }else{
                        $toplamDeger = $grand_total / $kur_value;

                    }
                    
                    // Sonuçtaki değeri 2 ondalık olarak biçimlendiriyoruz
                    $toplamDeger = number_format($toplamDeger, 2, '.', '');
                    
                    // Hesaplanan sonucu yazdırıyoruz (kontrol amacıyla)
                    
                    // Veritabanında güncelleme işlemini yapıyoruz
                    $guncelle = $this->modelFaturaTutar->set("toplam_tutar", $toplamDeger)
                                                       ->where("satir_id", $faturaModel["satir_id"])
                                                       ->update();

                   


                }

      

                $FinansFatura = $this->modelInvoice->where("invoice_id", $invoice_id)->first();
                $FinansHareketi = $this->modelFinancialMovement->set("transaction_amount", $FinansFatura["grand_total"])->set("transaction_real_amount", $FinansFatura["grand_total"])->where("invoice_id", $invoice_id)->update();
                $FinansHareketi2 = $this->modelStockMovement->set("sale_unit_price", $this->convert_sql($new_form_data["return_price"]))->where("stock_barcode_id", $new_form_data['stock_barcode_id'])->where("invoice_id", $invoice_id)->update();
                
             
             
                $this->bakiyeHesapla($FinansFatura["cari_id"]);
                if (!$updateInvoiceResult) {
                    throw new \Exception("Fatura güncellenemedi.");
                }
            

            // Başarı mesajını döndür
            $json_data = [
                'icon' => 'success',
                'message' => 'Ürün Fiyatı Başarıyla Güncellendi ve Fatura Yeniden Hesaplandı',
            ];

            if (count($errList)) {
                $json_data['errList'] = $errList;
            }

            echo json_encode($json_data);
            return;
        } catch (\Exception $e) {
            $backtrace = $e->getTrace();
            $errorDetails = [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $backtrace
            ];
            $this->logClass->save_log(
                'error',
                'shipment',
                null,
                null,
                'create',
                $e->getMessage(),
                json_encode($_POST)
            );
            echo json_encode(['icon' => 'error', 'message' => $errorDetails]);
            return;
        }
    } else {
        return redirect()->back();
    }
    }




    public function returnSaleOrder()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $errList = [];
                $all_total_price = 0;
                $transaction_prefix = "PRF";
                $tahsilat_prefix = "THS";
                $form_data = $this->request->getPost('data_form');
                // $sale_order_items_data = $this->request->getPost('sale_order_items');
                foreach ($form_data as $data) {
                    $key = $data['name'];
                    $value = $data['value'];
                    $new_form_data[$key] = $value;
                }

                $stokBarkoddanBul = $this->modelStockBarcode->where("stock_barcode_id", $new_form_data['stock_barcode_id'])->first();  
                $stokDegeriniBul = $this->modelStocks->where("stock_id", $stokBarkoddanBul['stock_id'])->first();  



                $stock_barcode_id = $new_form_data['stock_barcode_id'];
                $stock_barcode = $stokBarkoddanBul['barcode_number'];
                $invoice_id = $new_form_data['invoice_id'];
                $stock_id = $new_form_data['stock_id'];
                $stock_title = $stokDegeriniBul['stock_title'];

                $return_quantity = convert_number_for_sql($new_form_data['return_quantity']);
                // $return_quantity2 = number_format($return_quantity, 2, ',', '.');


                $invoice_item = $this->modelInvoice->where('user_id', session()->get('user_id'))->where('invoice_id', $invoice_id)->first();
                $base_invoice_grand_total = $invoice_item['grand_total'];
                $base_invoice_grand_total_try = $invoice_item['grand_total_try'];
                if (!$invoice_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Fatura bulunamadı']);
                    return;
                }

                $invoice_row_item = $this->modelInvoiceRow->where('user_id', session()->get('user_id'))->where('invoice_id', $invoice_id)->where('stock_id', $stock_id)->where('stock_barcode_id',$stock_barcode_id)->first();

                if (!$invoice_row_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Fatura satırları bulunamadı']);
                    return;
                }

                $stock_item = $this->modelStocks
                    ->join('unit as sale_unit', 'sale_unit.unit_id = stock.sale_unit_id')
                    ->join('stock_variant_group', 'stock_variant_group.stock_id = stock.stock_id')
                    ->join('variant_property v1', 'v1.variant_property_id = stock_variant_group.variant_1','left')
                    ->join('variant_property v2', 'v2.variant_property_id = stock_variant_group.variant_2','left')
                    ->join('variant_property v3', 'v3.variant_property_id = stock_variant_group.variant_3','left')
                    ->join('variant_property v4', 'v4.variant_property_id = stock_variant_group.variant_4','left')
                    ->join('variant_group vg1', 'v1.variant_group_id = vg1.variant_group_id','left')
                    ->join('variant_group vg2', 'v2.variant_group_id = vg2.variant_group_id','left')
                    ->join('variant_group vg3', 'v3.variant_group_id = vg3.variant_group_id','left')
                    ->join('variant_group vg4', 'v4.variant_group_id = vg4.variant_group_id','left')
                    ->select('stock.*, stock_variant_group.*, sale_unit.unit_title as unit_title, sale_unit.unit_value as sale_unit_value')
                    ->select('v1.variant_property_title as variant_property_v1, vg1.variant_title as variant_title_v1')
                    ->select('v2.variant_property_title as variant_property_v2, vg2.variant_title as variant_title_v2')
                    ->select('v3.variant_property_title as variant_property_v3, vg3.variant_title as variant_title_v3')
                    ->select('v4.variant_property_title as variant_property_v4, vg4.variant_title as variant_title_v4')
                    ->where('stock.user_id', session()->get('user_id'))
                    ->where('stock.stock_id', $stock_id)
                    ->first();
                if (!$stock_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Stok bilgisi bulunamadı']);
                    return;
                }

                $stock_barcode_item = $this->modelStockBarcode->where('stock_barcode_id', $invoice_row_item['stock_barcode_id'])->first();
                if (!$stock_barcode_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Stok barkod bilgisi bulunamadı']);
                    return;
                }


                $financial_movement_item = $this->modelFinancialMovement->where('user_id', session()->get('user_id'))->where('invoice_id', $invoice_id)->where('transaction_direction', 'exit')->first();
                if (!$financial_movement_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Finansal hareket bilgisi bulunamadı']);
                    return;
                }

                $cari_item = $this->modelCari->where('user_id', session()->get('user_id'))->where('cari_id', $invoice_item['cari_id'])->first();
                if (!$cari_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Cari bilgisi bulunamadı']);
                    return;
                }

                $old_stock_movement = $this->modelStockMovement
                    ->select('stock_movement.supplier_id')
                    ->where('stock_movement.user_id', session()->get('user_id'))
                    ->where('stock_barcode_id', $stock_barcode_item['stock_barcode_id'])
                    ->first();


                if ($return_quantity > $invoice_row_item['stock_amount'] || $return_quantity > ($invoice_row_item['stock_amount'] - $invoice_row_item['is_return_amount'])) {
                    echo json_encode(['icon' => 'error', 'message' => "Toplam stok miktarından  daha fazla ürün iade edilemez"]);
                    return;
                }

                $old_stock_fiyat_bulucu = $this->modelStockMovement
                ->select('supplier_id, buy_unit_price, buy_money_unit_id')
                ->where('user_id', session()->get('user_id'))
                ->where('movement_type', "incoming")
                ->where('stock_barcode_id', $stock_barcode_item['stock_barcode_id'])
                ->first();

                $satis_birim_fiyati = $old_stock_fiyat_bulucu["buy_unit_price"];
                $satis_para_birimi = $old_stock_fiyat_bulucu["buy_money_unit_id"];


               // $invoice_row_item['unit_price'] = $satis_birim_fiyati;
               // $invoice_item['money_unit_id'] =  $satis_para_birimi;
          

     


                // iade gelen ürün için yeni bir stock_barcode oluştur,
                $warehouse_id = $stock_barcode_item['warehouse_id'];
                $stock_quantity = $stock_barcode_item['total_amount'];


                $barcode_number = generate_barcode_number();
                $insert_barcode_data = [
                    'stock_id' => $stock_barcode_item['stock_id'],
                    'warehouse_id' => $warehouse_id,
                    'warehouse_address' => null,
                    'barcode_number' => $barcode_number,
                    'total_amount' => $return_quantity,
                    'used_amount' => 0
                ];
                $this->modelStockBarcode->insert($insert_barcode_data);
                $new_insert_stock_barcode_id = $this->modelStockBarcode->getInsertID();


                // iade gelen ürün için yeni bir stock iade hareketi oluştur,
                $last_transaction = $this->modelStockMovement->where('user_id', session()->get('user_id'))->orderBy('transaction_counter', 'DESC')->first();
                if ($last_transaction) {
                    $transaction_counter = $last_transaction['transaction_counter'] + 1;
                } else {
                    $transaction_counter = 1;
                }
                $transaction_number = $transaction_prefix . str_pad($transaction_counter, 6, '0', STR_PAD_LEFT);

                $insert_stock_movement_data = [
                    'user_id' => session()->get('user_id'),
                    'stock_barcode_id' => $new_insert_stock_barcode_id,
                    'invoice_id' => null,
                    'supplier_id' => $old_stock_movement['supplier_id'],
                    'movement_type' => 'incoming',
                    'transaction_number' => $transaction_number,
                    'to_warehouse' => $stock_barcode_item['warehouse_id'],
                    'transaction_note' => '',
                    'transaction_info' => 'iade işleminden oluşan hareket',
                    'buy_unit_price' => $satis_birim_fiyati,
                    'buy_money_unit_id' => $satis_para_birimi,
                    'transaction_quantity' => $return_quantity,
                    'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                    'transaction_prefix' => $transaction_prefix,
                    'transaction_counter' => $transaction_counter,
                ];
                $this->modelStockMovement->insert($insert_stock_movement_data);
                $new_stock_movement_id = $this->modelStockMovement->getInsertID();




                // iade sayıları kadar stok miktarları güncelle
                // print_r($return_quantity);
                $insert_StockWarehouseQuantity = [
                    'user_id' => session()->get('user_id'),
                ];
                $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $warehouse_id, $stock_item['stock_id'], $stock_item['parent_id'], $return_quantity, 'add', $this->modelStockWarehouseQuantity, $this->modelStocks);


                $is_return = null;
                $is_return_amount = null;


                if ($return_quantity <= $invoice_row_item['stock_amount']) {
                    $is_return = 'custom';
                    $is_return_amount = $return_quantity;
                } else if ($return_quantity == $invoice_row_item['stock_amount']) {
                    $is_return = 'full';
                    $is_return_amount = $invoice_row_item['stock_amount'];
                }


                $newStockAmount = $invoice_row_item['stock_amount'] - $return_quantity;
                // print_r($newStockAmount);


                // iade gelen ürün için ait olduğu invoice_row'u güncelle,
                $update_invoice_row_data = [
                    // 'stock_amount' => $newStockAmount,
                    // 'subtotal_price' => $newStockAmount * $invoice_row_item['unit_price'],
                    // 'total_price' => $newStockAmount * $invoice_row_item['unit_price'],
                    // 'is_return' => $is_return,
                    'is_return_amount' => $invoice_row_item['is_return_amount'] + $is_return_amount,
                ];
                $this->modelInvoiceRow->update($invoice_row_item['invoice_row_id'], $update_invoice_row_data);
                // print_r($update_invoice_row_data);


                //iade gelen ürünler için yeni finansal hareket oluştur,
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
                    'cari_id' => $cari_item['cari_id'],
                    'stock_movement_id' => $new_stock_movement_id,
                    'money_unit_id' => $invoice_item['money_unit_id'],
                    'transaction_number' => $transaction_number,
                    'transaction_direction' => 'entry',
                    'transaction_type' => 'incoming_invoice',
                    'invoice_id' => null,
                    'transaction_tool' => 'not_payroll',
                    'transaction_title' => 'iade anında anında oluşan finansal hareket',
                    'transaction_description' => '',// iade modal'ında açıklama alanı eklenebilir. neden iade alındı diye
                    'transaction_amount' => $return_quantity * $invoice_row_item['unit_price'],
                    'transaction_real_amount' => $return_quantity * $invoice_row_item['unit_price'],
                    'transaction_date' => new Time('now', 'Turkey', 'en_US'),
                    'transaction_prefix' => $transaction_prefix,
                    'transaction_counter' => $transaction_counter
                ];
                $this->modelFinancialMovement->insert($insert_financial_movement_data);
                $new_financial_movement_id = $this->modelFinancialMovement->getInsertID();
                // print_r($insert_financial_movement_data);




                // fatura kayıt oluşturuyoruz
                $invoice_currency_amount = $invoice_item['currency_amount'];
                $insert_invoice_data = [
                    'user_id' => session()->get('user_id'),
                    'money_unit_id' => $invoice_item['money_unit_id'],
                    'sale_type' => "quick",

                    'invoice_direction' => 'incoming_invoice',
                    'invoice_date' => new Time('now', 'Turkey', 'en_US'),
                    'expiry_date' => new Time('now', 'Turkey', 'en_US'),

                    'currency_amount' => $invoice_item['currency_amount'],
                    'stock_total' => $return_quantity * $invoice_row_item['unit_price'],
                    'stock_total_try' => ($return_quantity * $invoice_row_item['unit_price']) * $invoice_currency_amount,
                    'sub_total' => $return_quantity * $invoice_row_item['unit_price'],
                    'sub_total_try' => $return_quantity * $invoice_row_item['unit_price'] * $invoice_currency_amount,
                    'grand_total' => $return_quantity * $invoice_row_item['unit_price'],
                    'grand_total_try' => $return_quantity * $invoice_row_item['unit_price'] * $invoice_currency_amount,
                    'amount_to_be_paid' => $return_quantity * $invoice_row_item['unit_price'],
                    'amount_to_be_paid_try' => ($return_quantity * $invoice_row_item['unit_price']) * $invoice_currency_amount,

                    'cari_id' => $invoice_item['cari_id'],
                    'cari_identification_number' => $invoice_item['cari_identification_number'],
                    'cari_tax_administration' => $invoice_item['cari_tax_administration'],

                    'cari_invoice_title' => $invoice_item['cari_invoice_title'] == '' ? $invoice_item['cari_name'] . " " . $invoice_item['cari_surname'] : $invoice_item['cari_invoice_title'],
                    'cari_name' => $invoice_item['cari_name'],
                    'cari_surname' => $invoice_item['cari_surname'],
                    'cari_obligation' => $invoice_item['cari_obligation'],
                    'cari_company_type' => $invoice_item['cari_company_type'],
                    'cari_phone' => $invoice_item['cari_phone'],
                    'cari_email' => $invoice_item['cari_email'],

                    'address_country' => $invoice_item['address_country'],
                    'address_city' => isset($invoice_item['address_city_name']) ? $invoice_item['address_city_name'] : "",
                    'address_city_plate' => isset($invoice_item['address_city']) ? $invoice_item['address_city'] : "",
                    'address_district' => isset($invoice_item['address_district']) ? $invoice_item['address_district'] : "",
                    'address_zip_code' => $invoice_item['address_zip_code'],
                    'address' => $invoice_item['address'],

                    'invoice_status_id' => "1",
                    'is_return' => 1,
                ];

                // print_r(str_replace(',', '.', $stock_quantity) * str_replace(',', '.', $buy_unit_price));
                // print_r((str_replace(',', '.', $stock_quantity) * str_replace(',', '.', $buy_unit_price)) * str_replace(',', '.', $currency_amount));

                $this->modelInvoice->insert($insert_invoice_data);
                $new_invoice_id = $this->modelInvoice->getInsertID();
                // print_r($insert_invoice_data);

                $insert_invoice_row_data = [
                    'user_id' => session()->get('user_id'),
                    'cari_id' => $cari_item['cari_id'],
                    'invoice_id' => $new_invoice_id,
                    'stock_id' => $stock_item['stock_id'],
                    'stock_barcode_id' => $new_insert_stock_barcode_id,
                    'stock_title' => $stock_item['stock_title'],
                    'stock_amount' => $return_quantity,

                    'unit_id' => $stock_item['buy_unit_id'],
                    'unit_price' => $invoice_row_item['unit_price'],

                    'subtotal_price' => $return_quantity * $invoice_row_item['unit_price'],

                    'total_price' => $return_quantity * $invoice_row_item['unit_price'],

                    'is_return' => $is_return,
                    'is_return_amount' => $return_quantity,
                    'is_returned_invoice_row_id' => $invoice_row_item['invoice_row_id'],
                    // 'is_return_amount' => $invoice_row_item['is_return_amount'] + $is_return_amount,
                ];
                $this->modelInvoiceRow->insert($insert_invoice_row_data);



                // iade gelen ürün tutar kadar cari_balance güncelle,
                $new_stock_amount_price = $return_quantity * $invoice_row_item['unit_price'];
                $update_cari_data = [
                    'cari_balance' => $cari_item['cari_balance'] - $new_stock_amount_price,
                ];
                $this->modelCari->update($cari_item['cari_id'], $update_cari_data);



                // iade gelen ürün için eski hareketi sil,
                // $stock_barcode_item = $this->modelStockMovement->where('user_id', session()->get('user_id'))->where('invoice_id', $invoice_id)->delete();





                $update_stock_movement_data = [
                    'invoice_id' => $new_invoice_id,
                ];
                $this->modelStockMovement->update($new_stock_movement_id, $update_stock_movement_data);

                $update_invoice_data = [
                    'invoice_id' => $new_invoice_id,
                ];
                $this->modelFinancialMovement->update($new_financial_movement_id, $update_invoice_data);



                $barcode_html = generate_barcode_html($stock_item, $insert_barcode_data, '', $cari_item);

                $json_data = [
                    'icon' => 'success',
                    'message' => 'Ürün iade kaydı başarıyla tamamlandı.',
                    'newOrderId' => $invoice_id,
                    'barcode_html' => $barcode_html
                ];


                if (count($errList)) {
                    $json_data['errList'] = $errList;
                }
                echo json_encode($json_data);
                return;
            } catch (\Exception $e) {

                $this->logClass->save_log(
                    'error',
                    'shipment',
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


    public function deleteReturnSaleOrder()
    {
        $invoice_id = $this->request->getPost('invoice_id');
        $data_stock_barcode_id = $this->request->getPost('data_stock_barcode_id');
        $data_stock_movement_id = $this->request->getPost('data_stock_movement_id');



        if ($this->request->getMethod('true') == 'POST') {

            try {

                $invoice_item = $this->modelInvoice->where('user_id', session()->get('user_id'))->where('invoice_id', $invoice_id)->first();
                if (!$invoice_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Fatura bilgisi bulunamadı']);
                    return;
                }

                $invoice_row_item = $this->modelInvoiceRow->where('user_id', session()->get('user_id'))->where('invoice_id', $invoice_id)->first();
                if (!$invoice_row_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Fatura satır bilgisi bulunamadı']);
                    return;
                }

                $base_invoice_row_item = $this->modelInvoiceRow->where('user_id', session()->get('user_id'))->where('invoice_row_id', $invoice_row_item['is_returned_invoice_row_id'])->first();
                if (!$base_invoice_row_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Önceki fatura satır bilgisi bulunamadı']);
                    return;
                }

                $invoice_row_stock = $this->modelStocks
                    ->where('stock.stock_id', $invoice_row_item['stock_id'])
                    ->first();
                if (!$invoice_row_stock) {
                    echo json_encode(['icon' => 'error', 'message' => 'Ürün bilgisi bulunamadı']);
                    return;
                }

                $stock_movement_item = $this->modelStockMovement
                    ->where('stock_movement.stock_movement_id', $data_stock_movement_id)
                    ->first();
                if (!$stock_movement_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Stok hareket bilgisi bulunamadı']);
                    return;
                }

                $stock_barcode_item = $this->modelStockBarcode
                    ->where('stock_barcode.stock_barcode_id', $data_stock_barcode_id)
                    ->first();
                if (!$stock_barcode_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Ürün barkod bilgisi bulunamadı']);
                    return;
                }

                $invoice_cari_item = $this->modelCari
                    ->where('cari_id', $invoice_row_item['cari_id'])
                    ->first();
                if (!$invoice_cari_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Cari bilgisi bulunamadı']);
                    return;
                }

                $financial_item = $this->modelFinancialMovement
                    ->where('invoice_id', $invoice_row_item['invoice_id'])
                    ->first();
                if (!$financial_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Finansal hareket bilgisi bulunamadı']);
                    return;
                }

                // print_r($invoice_item);
                // print_r($invoice_row_item);
                // print_r($base_invoice_row_item);
                // print_r($invoice_row_stock);
                // print_r($stock_movement_item);
                // print_r($stock_barcode_item);
                // print_r($invoice_cari_item);
                // print_r($financial_item);
                // return;




                $base_invoice_row_item_returned_amount = $base_invoice_row_item['is_return_amount'];
                $last_returned_amount = $base_invoice_row_item_returned_amount - $invoice_row_item['is_return_amount'];



                $update_old_invoice_row_data = [
                    'is_return_amount' => $last_returned_amount,
                ];
                $this->modelInvoiceRow->update($base_invoice_row_item['invoice_row_id'], $update_old_invoice_row_data);
                // print_r($base_invoice_row_item['invoice_row_id']);
                // return;

                $insert_StockWarehouseQuantity = [
                    'user_id' => session()->get('user_id'),
                ];
                $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $stock_barcode_item['warehouse_id'], $invoice_row_stock['stock_id'], $invoice_row_stock['parent_id'], $invoice_row_item['stock_amount'], 'remove', $this->modelStockWarehouseQuantity, $this->modelStocks);

                $this->modelStockMovement->delete($stock_movement_item['stock_movement_id']);
                $this->modelStockBarcode->delete($stock_barcode_item['stock_barcode_id']);

                $lastc = $invoice_item['money_unit_id'] == $invoice_cari_item['money_unit_id'] ? $invoice_item['amount_to_be_paid'] : $invoice_item['amount_to_be_paid'];

                $update_cari_data = [
                    'cari_balance' => $invoice_cari_item['cari_balance'] + $lastc,
                ];
                $this->modelCari->update($invoice_cari_item['cari_id'], $update_cari_data);

                $this->modelFinancialMovement->delete($financial_item['financial_movement_id']);


                $this->modelInvoice->delete($invoice_item['invoice_id']);
                $this->modelInvoiceRow->delete($invoice_row_item['invoice_row_id']);


                echo json_encode(['icon' => 'success', 'message' => 'İade işlemi başarıyla silindi.', 'route_address' => route_to('tportal.faturalar.list', 'incoming')]);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock',
                    $invoice_id,
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

    public function deleteSaleOrder()
    {
        $invoice_id = $this->request->getPost('invoice_id');


        if ($this->request->getMethod('true') == 'POST') {

            try {
                $invoice_item = $this->modelInvoice->where('user_id', session()->get('user_id'))->where('invoice_id', $invoice_id)->first();
                if (!$invoice_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Fatura bilgisi bulunamadı']);
                    return;
                }

                $invoice_row_items = $this->modelInvoiceRow->where('user_id', session()->get('user_id'))->where('invoice_id', $invoice_id)->findAll();
                if (!$invoice_row_items) {
                    echo json_encode(['icon' => 'error', 'message' => 'Fatura satır bilgisi bulunamadı']);
                    return;
                }

                $invoice_cari_item = 0;

                foreach ($invoice_row_items as $invoice_row_item) {
                    $invoice_row_stock = $this->modelStocks
                        ->where('stock.stock_id', $invoice_row_item['stock_id'])
                        ->first();
                    if (!$invoice_row_stock) {
                        echo json_encode(['icon' => 'error', 'message' => 'Ürün bilgisi bulunamadı']);
                        return;
                    }

                    $stock_movement_item = $this->modelStockMovement
                        ->where('stock_movement.stock_barcode_id', $invoice_row_item['stock_barcode_id'])
                        ->where('stock_movement.invoice_id', $invoice_row_item['invoice_id'])
                        ->first();
                    if (!$stock_movement_item) {
                        echo json_encode(['icon' => 'error', 'message' => 'Stok hareket bilgisi bulunamadı']);
                        return;
                    }

                    $stock_barcode_item = $this->modelStockBarcode
                        ->where('stock_barcode.stock_barcode_id', $invoice_row_item['stock_barcode_id'])
                        ->first();
                    if (!$stock_barcode_item) {
                        echo json_encode(['icon' => 'error', 'message' => 'Ürün barkod bilgisi bulunamadı']);
                        return;
                    }

                    $invoice_cari_item = $this->modelCari
                        ->where('cari_id', $invoice_row_item['cari_id'])
                        ->first();
                    if (!$invoice_cari_item) {
                        echo json_encode(['icon' => 'error', 'message' => 'Cari bilgisi bulunamadı']);
                        return;
                    }

                    $financial_item = $this->modelFinancialMovement
                        ->where('invoice_id', $invoice_row_item['invoice_id'])
                        ->first();
                    if (!$financial_item) {
                        echo json_encode(['icon' => 'error', 'message' => 'Finansal hareket bilgisi bulunamadı']);
                        return;
                    }

                    if ($invoice_row_item['is_return_amount'] != 0) {
                        echo json_encode(['icon' => 'error', 'message' => 'Bu satış işlemindeki bazı ürünler iade edildiğinden satış silinemez.']);
                        return;
                    }


                    $insert_StockWarehouseQuantity = [
                        'user_id' => session()->get('user_id'),
                    ];
                    $addStock = updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $stock_barcode_item['warehouse_id'], $invoice_row_stock['stock_id'], $invoice_row_stock['parent_id'], $invoice_row_item['stock_amount'], 'add', $this->modelStockWarehouseQuantity, $this->modelStocks);

                    //stock_barcode'da used_amount stock_amount kadar arttır
                    $used_amount = $stock_barcode_item['used_amount'] - $invoice_row_item['stock_amount'];
                    $stock_barcode_status = $used_amount == $stock_barcode_item['total_amount'] ? 'out_of_stock' : 'available';
                    $update_stock_barcode_data = [
                        'used_amount' => $used_amount,
                        'stock_barcode_status' => $stock_barcode_status
                    ];
                    $this->modelStockBarcode->update($stock_barcode_item['stock_barcode_id'], $update_stock_barcode_data);

                    // print_r($update_stock_barcode_data);
                    // return;
                    $this->modelStockMovement->delete($stock_movement_item['stock_movement_id']);
                    // $this->modelStockBarcode->delete($stock_barcode_item['stock_barcode_id']);



                    $this->modelInvoiceRow->delete($invoice_row_item['invoice_row_id']);
                }




                $lastc = $invoice_item['amount_to_be_paid'];

                $update_cari_data = [
                    'cari_balance' => $invoice_cari_item['cari_balance'] - $lastc,
                ];
                $this->modelCari->update($invoice_cari_item['cari_id'], $update_cari_data);

                $this->modelFinancialMovement->delete($financial_item['financial_movement_id']);


                if ($invoice_item['is_quick_collection_financial_movement_id'] != 0) {

                    $financial_movement_item = $this->modelFinancialMovement
                        ->where('financial_movement_id', $invoice_item['is_quick_collection_financial_movement_id'])
                        ->first();


                    $financial_account_item = $this->modelFinancialAccount
                        ->where('financial_account_id', $financial_movement_item['financial_account_id'])
                        ->first();

                    $lastc = $invoice_item['amount_to_be_paid'];

                    $update_financial_account_data = [
                        'account_balance' => $financial_account_item['account_balance'] - $lastc,
                    ];
                    $this->modelFinancialAccount->update($financial_account_item['financial_account_id'], $update_financial_account_data);

                    $invoice_cari_item = $this->modelCari
                        ->where('cari_id', $invoice_item['cari_id'])
                        ->first();

                    $update_cari_data = [
                        'cari_balance' => $invoice_cari_item['cari_balance'] + $lastc,
                    ];
                    $this->modelCari->update($invoice_cari_item['cari_id'], $update_cari_data);

                    $this->modelFinancialMovement->delete($invoice_item['is_quick_collection_financial_movement_id']);
                }

                $this->modelInvoice->delete($invoice_item['invoice_id']);


                echo json_encode(['icon' => 'success', 'message' => 'Stok harekti başarıyla silindi.', 'route_address' => route_to('tportal.stocks.list', 'all')]);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock',
                    $invoice_item['invoice_id'],
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



    public function checkBarcodeIade()
    {
        if ($this->request->getMethod('true') == 'POST') {
            $barcode = $this->request->getPost('barcode_number');
            $warehouse_id = $this->request->getPost('warehouse_id');
            $cari_id = $this->request->getPost('cari_id');
            $barcode_number = convert_barcode_number_for_sql($barcode);

            $barcode_item = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                ->join('unit', 'stock.sale_unit_id = unit.unit_id')
                ->join('money_unit', 'stock.sale_money_unit_id = money_unit.money_unit_id')
                ->where('stock.user_id', session()->get('user_id'))
                ->where('stock_barcode.barcode_number', $barcode_number)
         
                ->first();
      
                if($barcode_item){
                
                    $stokBarkod = $this->modelStockBarcode->where("stock_id", $barcode_item["stock_id"])->findAll();
                    $stokHareketleri = [];
                    $stokFullHareketleri = [];
                    foreach($stokBarkod as $barkod){
                        $stockMovement = $this->modelStockMovement->where("stock_barcode_id", $barkod["stock_barcode_id"])->first();
                        if($stockMovement):
                        $stokHareketleri[] = $stockMovement["stock_barcode_id"];
                        $stokFullHareketleri[] = $stockMovement;
                        endif;

                    }


                    $financialMovement = $this->modelInvoiceRow->whereIn("stock_barcode_id", $stokHareketleri)->orderBy("invoice_row_id", "DESC")->limit(1)->first();
                
                    $supplierFound = false;
                    foreach($stokFullHareketleri as $hareket) {
                        if(isset($hareket["supplier_id"]) && $hareket["supplier_id"] == $cari_id) {
                            $supplierFound = true;
                            break;
                        }
                    }
                    
                    if(!$supplierFound) {
                        echo json_encode(['icon' => 'error', 'message' => "Girilen Barkod Bu Tedarikçiye Ait Değil İadesi Yapılamaz. -  $barcode_number"]);
                        return;
                    }




                    if(isset($financialMovement) && !empty($cari_id)){
                        $barcode_item["sale_unit_price"] = $financialMovement["unit_price"];
                    }else{
                        $barcode_item["sale_unit_price"] = 0;

                    }
                }

      



            if (!$barcode_item) {
                echo json_encode(['icon' => 'error', 'message' => "Barkod bulunamadı. -  $barcode_number"]);
                return;
            } else if ($warehouse_id != $barcode_item['warehouse_id']) {
                echo json_encode(['icon' => 'error', 'message' => 'Girilen barkod siparişin çıkış deposunda bulunamadı.']);
                return;
            } else if ($barcode_item['stock_barcode_status'] == 'out_of_stock') {
                echo json_encode(['icon' => 'error', 'message' => 'Girilen barkod bilgisindeki tüm ürün miktarı daha önce kullanıdı.']);
                return;
            } else if ($barcode_item['stock_barcode_status'] != 'available') {
                echo json_encode(['icon' => 'error', 'message' => 'Girilen barkod siparişe eklenmeye uygun değil.']);
                return;
            }

            echo json_encode(['icon' => 'success', 'message' => 'Barkod başarıyla getirildi.', 'data' => $barcode_item]);
            return;
        } else {
            return redirect()->back();
        }
    }


 

    public function checkBarcode()
    {
        if ($this->request->getMethod('true') == 'POST') {
            $barcode = $this->request->getPost('barcode_number');
            $warehouse_id = $this->request->getPost('warehouse_id');
            $cari_id = $this->request->getPost('cari_id');
            $barcode_number = convert_barcode_number_for_sql($barcode);

            $barcode_item = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                ->join('unit', 'stock.sale_unit_id = unit.unit_id')
                ->join('money_unit', 'stock.sale_money_unit_id = money_unit.money_unit_id')
                ->where('stock.user_id', session()->get('user_id'))
                ->where('stock_barcode.barcode_number', $barcode_number)
                ->first();
      
                if($barcode_item){
                
                    $stokBarkod = $this->modelStockBarcode->where("stock_id", $barcode_item["stock_id"])->findAll();
                    $stokHareketleri = [];
                    foreach($stokBarkod as $barkod){
                        $stockMovement = $this->modelStockMovement->where("stock_barcode_id", $barkod["stock_barcode_id"])->first();
                        if($stockMovement):
                        $stokHareketleri[] = $stockMovement["stock_barcode_id"];
                        endif;

                    }
                    $financialMovement = $this->modelInvoiceRow->whereIn("stock_barcode_id", $stokHareketleri)->where("cari_id", $cari_id)->orderBy("invoice_row_id", "DESC")->limit(1)->first();






                    if(isset($financialMovement) && !empty($cari_id)){
                        $barcode_item["sale_unit_price"] = $financialMovement["unit_price"];
                    }else{
                        $barcode_item["sale_unit_price"] = 0;

                    }
                }

      



            if (!$barcode_item) {
                echo json_encode(['icon' => 'error', 'message' => "Barkod bulunamadı. -  $barcode_number"]);
                return;
            } else if ($warehouse_id != $barcode_item['warehouse_id']) {
                echo json_encode(['icon' => 'error', 'message' => 'Girilen barkod siparişin çıkış deposunda bulunamadı.']);
                return;
            } else if ($barcode_item['stock_barcode_status'] == 'out_of_stock') {
                echo json_encode(['icon' => 'error', 'message' => 'Girilen barkod bilgisindeki tüm ürün miktarı daha önce kullanıdı.']);
                return;
            } else if ($barcode_item['stock_barcode_status'] != 'available') {
                echo json_encode(['icon' => 'error', 'message' => 'Girilen barkod siparişe eklenmeye uygun değil.']);
                return;
            }

            echo json_encode(['icon' => 'success', 'message' => 'Barkod başarıyla getirildi.', 'data' => $barcode_item]);
            return;
        } else {
            return redirect()->back();
        }
    }






    
    public function uploadDoc()
    {
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
    
        // Connect to the user database
        $databaseUser = \Config\Database::connect($userDatabaseDetail);
    
        // Truncate the stock_excel table
        $databaseUser->table('stock_excel')->truncate();
    
        $uploadPath = 'uploads/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE); // Create directory if it doesn't exist
        }
    
        $file_excel = $this->request->getFile('file-2');
        $ext = $file_excel->getClientExtension();
        $filename = $file_excel->getClientName(); // Get the original filename
    
        // Generate a new filename with the current date and time
        $baseFilename = pathinfo($filename, PATHINFO_FILENAME);
        $timestamp = date('Y_m_d-H_i');
        $newFilename = strtolower(str_replace(' ', '_', $baseFilename)) . '_' . $timestamp . '.' . $ext;

    
        // Move the file to the upload directory with the new filename
        $file_excel->move($uploadPath, $newFilename);
    
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else if ($ext == 'xlsx') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
    
        $spreadsheet = $render->load($uploadPath . $newFilename);
    
        $data = $spreadsheet->getActiveSheet()->toArray();
    
        foreach ($data as $x => $row) {
            if ($x != 0) {
                $data_2[] = array(
                    'adi'           => $row[1],
                    'no'            => $row[0],
                    'tip'           => $row[2],
                    'grupkodu'      => $row[3],
                    'ozelkod_1'     => $row[4],
                    'ozelkod_2'     => $row[5],
                    'para'          => $row[6],
                    'depo'          => $row[7],
                    'birim'         => $row[8],
                    'fiyat'         => $row[12],
                    'musteri'       => $row[13],
                    'tedarikci'     => $row[14],
                    'excel_dosya'   => $newFilename,
                    'tarih'         => date("Y-m-d H:i")
                );
            }
        }
    
        $rtn = $databaseUser->table('stock_excel')->insertBatch($data_2);
    }



    function func_excel_import(){

        // echo "func_import"; die();
        $upload_status  = $this->uploadDoc();
        if ($upload_status != false) {

            $inputFileName  = 'uploads/'.$upload_status;
            $inputTitleType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
            $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileName);
            $spreadsheet    = $reader->load($inputFileName);
            $sheet          = $spreadsheet->getSheet(0);


            foreach ($sheet->getRowIterator() as $row) 
            {
                $name = $spreadsheet->getActiveSheet()->getCell('A'.$row->getRowIndex());
                echo $name;
            }
        }else{

        }
         
		
	}


    function formatPhoneNumber($cari_phone) {
        // 1. Tüm gereksiz karakterleri (boşluk, parantez vb.) temizle
        $cleaned_phone = preg_replace('/[^0-9]/', '', $cari_phone);
    
        // 2. Uzunluk kontrolü yap ve uygun formata dönüştür
        if (preg_match('/^5\d{9}$/', $cleaned_phone)) {
            // Örnek: 5313533090 -> +90 531 353 30 90
            $formatted_phone = '+90 ' . substr($cleaned_phone, 0, 3) . ' ' . 
                               substr($cleaned_phone, 3, 3) . ' ' . 
                               substr($cleaned_phone, 6, 2) . ' ' . 
                               substr($cleaned_phone, 8, 2);
        } elseif (preg_match('/^\d{7}$/', $cleaned_phone)) {
            // Örnek: 4734160 -> +90 212 473 41 60 (İstanbul alan kodu eklenir)
            $formatted_phone = '+90 212 ' . substr($cleaned_phone, 0, 3) . ' ' . 
                               substr($cleaned_phone, 3, 2) . ' ' . 
                               substr($cleaned_phone, 5, 2);
        } elseif (preg_match('/^\d{10}$/', $cleaned_phone)) {
            // Örnek: 02123533090 -> +90 212 353 30 90
            $formatted_phone = '+90 ' . substr($cleaned_phone, 0, 3) . ' ' . 
                               substr($cleaned_phone, 3, 3) . ' ' . 
                               substr($cleaned_phone, 6, 2) . ' ' . 
                               substr($cleaned_phone, 8, 2);
        } else {
            // Geçersiz formatta numara için mesaj döndür
            $formatted_phone = '+90';
        }
    
        return $formatted_phone;
    }


    public function excelStock()
    {
        $insert_data = [];


        
        

     // Corrected the 'true' parameter
            try {
                $ExcelUrunler = $this->modalStockExcel->findAll();

                $success = false; // Flag to check if any stock is created

                foreach ($ExcelUrunler as $Excel) {
                   
                    $transaction_prefix = "TRNSCTN";

            try {
                $is_customer = 1;
                $is_supplier = 0;
                $is_export_customer = 0;

              

                $identification_number = $Excel["musteri"] ?? $Excel["tc"];
                $tax_administration = $Excel["tedarikci"];
                if(!empty($Excel["tc"])){
                    $ExcelAdi = $Excel["adi"];
                    $full_name = $ExcelAdi; // "Abdurrahman Burak Kocabey" gibi bir değer

                    // Ad ve soyadı ayırmak için boşluklara göre bölelim
                    $name_parts = explode(' ', trim($full_name));

                    // İlk kelimeyi isim olarak kabul edelim
                    $names = array_shift($name_parts);

                    // Kalan tüm parçaları soyisim olarak birleştirelim
                    $surnames = implode(' ', $name_parts);
                    $name = $names;
                    $surname = $surnames;
                    $company_types = "person";
                }else{
                    $name = "";
                    $surname = "";
                    $company_types = "company";
                    $invoice_title = $Excel["adi"];
                }
               
               
                $obligation = "e-archive";
                $company_type = $company_types;
                $cari_phone = $this->formatPhoneNumber($Excel["ozelkod_1"]);

               
                $area_code = "";
                $cari_email = $this->request->getPost($Excel["ozelkod_2"]);
                $money_unit_id = 3;

                $starting_balance = 0;
                $starting_balance_date = "";

                $cari_note = "";

                // $starting_balance_date = $starting_balance_date ? convert_datetime_for_sql($starting_balance) : current_time();
                $starting_balance_date = $starting_balance_date ? convert_datetime_for_sql($starting_balance_date) : date('Y-m-d H:i:s');
                $starting_balance = convert_number_for_sql($starting_balance);
                $cari_balance = $starting_balance;

                $address = $Excel["para"];
                $address_country = "TR";
                $address_city = $Excel["birim"];   // il verir
                $address_city_plate = 0;  // plaka verir
                $address_district = $Excel["depo"];
                $zip_code = "";

                $phoneNumber = $cari_phone;

                //8 rakamlı cari kodu
                $create_cari_code = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);

               

                $form_data = [
                    'user_id' => session()->get('user_id'),
                    'cari_code' => $create_cari_code,
                    'money_unit_id' => $money_unit_id,
                    'identification_number' => $identification_number,
                    'tax_administration' => $tax_administration != '' ? $tax_administration : null,
                    'invoice_title' => $invoice_title == '' ? $name . ' ' . $surname : $invoice_title,
                    'name' => $name,
                    'surname' => $surname,
                    'obligation' => $obligation != '' ? $obligation : null,
                    'company_type' => $company_type != '' ? $company_type : null,
                    'cari_phone' => $phoneNumber,
                    'cari_email' => $cari_email != '' ? $cari_email : null,
                    'cari_balance' => $cari_balance,
                    'cari_note' => $cari_note,
                    'is_customer' => $is_customer,
                    'is_supplier' => $is_supplier,
                    'is_export_customer' => $is_export_customer,
                ];
                $this->modelCari->insert($form_data);
                $cari_id = $this->modelCari->getInsertID();

         
                try {
                    $insert_address_data = [
                        'user_id' => session()->get('user_id'),
                        'cari_id' => $cari_id,
                        'address_title' => 'Fatura Adresi',
                        'address_country' => $address_country,
                        'address_city' => $address_city,
                        'address_city_plate' => $address_city_plate,
                        'address_district' => $address_district,
                        'zip_code' => $zip_code,
                        'address' => $address,
                        'address_phone' => $phoneNumber,
                        'address_email' => $cari_email,
                        'status' => 'active',
                        'default' => 'true'
                    ];
                    $this->modelAddress->insert($insert_address_data);
                } catch (\Exception $e) {
                    $this->logClass->save_log(
                        'error',
                        'address',
                        null,
                        null,
                        'create',
                        $e->getMessage(),
                        json_encode($_POST)
                    );
                    echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                    return;
                }
         

          
            } catch (\Exception $e) {
                $errorDetails = [
                    'error_message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ];


                $this->logClass->save_log(
                    'error',
                    'cari',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo $e->getLine();
                return;
            }

            $success = true;
        

                }

                if ($success) {
                    echo json_encode(['icon' => 'success', 'message' => 'Stok başarıyla oluşturuldu.']);
                } else {
                    echo json_encode(['icon' => 'error', 'message' => 'Stok Oluşturulamadı.']);
                }
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'stock',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
            }
        
    }



    public function vknBirlesimModal()
    {
        $user_id = session()->get('user_id');
        
        // Veritabanı bağlantısını al
        $db_connection = \Config\Database::connect($this->currentDB);
        
        // Tekrar eden identification_number'ları bul
        $duplicateQuery = "
            SELECT identification_number, COUNT(*) as tekrar_sayisi, name, surname, invoice_title
            FROM cari 
            WHERE user_id = ? AND identification_number IS NOT NULL AND identification_number != '' AND deleted_at IS NULL
            GROUP BY identification_number 
            HAVING COUNT(*) > 1
            ORDER BY tekrar_sayisi DESC, identification_number
        ";
        
        $duplicateResults = $db_connection->query($duplicateQuery, [$user_id])->getResultArray();
        
        $data = [
            'duplicateResults' => $duplicateResults,
            'db_connection' => $db_connection,
            'user_id' => $user_id
        ];
        
        return view('tportal/cariler/vkn_birlesim_modal', $data);
    }

    public function getVknBirlesimDetay()
    {
        if ($this->request->isAJAX()) {
            $identification_number = $this->request->getPost('identification_number');
            $user_id = session()->get('user_id');
            
            // Veritabanı bağlantısını al
            $db_connection = \Config\Database::connect($this->currentDB);
            
            $detailQuery = "
                SELECT 
                    c.cari_id,
                    c.cari_code,
                    c.identification_number,
                    c.tax_administration,
                    c.invoice_title,
                    c.name,
                    c.surname,
                    c.company_type,
                    c.cari_phone,
                    c.cari_email,
                    c.cari_balance,
                    c.is_customer,
                    c.is_supplier,
                    c.is_export_customer,
                    c.created_at,
                    c.updated_at,
                    (SELECT COUNT(*) FROM financial_movement fm WHERE fm.cari_id = c.cari_id AND fm.user_id = c.user_id AND fm.deleted_at IS NULL) as finansal_hareket_sayisi,
                    (SELECT COUNT(*) FROM invoice i WHERE i.cari_id = c.cari_id AND i.user_id = c.user_id AND i.deleted_at IS NULL) as fatura_sayisi,
                    (SELECT COUNT(*) FROM `order` o WHERE o.cari_id = c.cari_id AND o.user_id = c.user_id AND o.deleted_at IS NULL) as siparis_sayisi,
                    (SELECT COUNT(*) FROM address a WHERE a.cari_id = c.cari_id AND a.status = 'active') as adres_sayisi
                FROM cari c
                WHERE c.user_id = ? AND c.identification_number = ? AND c.deleted_at IS NULL
                ORDER BY c.created_at ASC
            ";
            
            $detailResults = $db_connection->query($detailQuery, [$user_id, $identification_number])->getResultArray();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $detailResults
            ]);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Geçersiz istek']);
    }

    public function vknBirlesimYap()
    {
        sleep(3);

        if ($this->request->isAJAX()) {
            $user_id = session()->get('user_id');
            $original_cari_id = $this->request->getPost('original_cari_id');
            $merge_cari_ids = $this->request->getPost('merge_cari_ids'); // Array
            
            if (empty($original_cari_id) || empty($merge_cari_ids)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gerekli parametreler eksik'
                ]);
            }
            
            // Veritabanı bağlantısını al
            $db_connection = \Config\Database::connect($this->currentDB);
            
            try {
                $db_connection->transStart();
                
                // Orijinal cari'yi kontrol et
                $originalCari = $db_connection->table('cari')
                    ->where('cari_id', $original_cari_id)
                    ->where('user_id', $user_id)
                    ->where('deleted_at IS NULL')
                    ->get()
                    ->getRowArray();
                
                if (!$originalCari) {
                    throw new \Exception('Orijinal cari bulunamadı');
                }
                
                $merge_cari_ids = is_array($merge_cari_ids) ? $merge_cari_ids : [$merge_cari_ids];
                
                foreach ($merge_cari_ids as $merge_cari_id) {
                    if ($merge_cari_id == $original_cari_id) {
                        continue; // Kendisini atla
                    }
                    
                    // Birleştirilecek cari'yi kontrol et
                    $mergeCari = $db_connection->table('cari')
                        ->where('cari_id', $merge_cari_id)
                        ->where('user_id', $user_id)
                        ->where('deleted_at IS NULL')
                        ->get()
                        ->getRowArray();
                    
                    if (!$mergeCari) {
                        continue;
                    }
                    
                    // 1. Financial Movement kayıtlarını güncelle
                    $db_connection->table('financial_movement')
                        ->where('cari_id', $merge_cari_id)
                        ->where('user_id', $user_id)
                        ->where('deleted_at IS NULL')
                        ->update(['cari_id' => $original_cari_id]);
                    
                    // 2. Invoice kayıtlarını güncelle
                    $db_connection->table('invoice')
                        ->where('cari_id', $merge_cari_id)
                        ->where('user_id', $user_id)
                        ->where('deleted_at IS NULL')
                        ->update(['cari_id' => $original_cari_id]);
                    
                    // 3. Order kayıtlarını güncelle
                    $db_connection->table('order')
                        ->where('cari_id', $merge_cari_id)
                        ->where('user_id', $user_id)
                        ->where('deleted_at IS NULL')
                        ->update(['cari_id' => $original_cari_id]);
                    
                
                    // 9. Birleştirilen cari'yi sil (soft delete)
                    $db_connection->table('cari')
                        ->where('cari_id', $merge_cari_id)
                        ->where('user_id', $user_id)
                        ->update(['deleted_at' => date('Y-m-d H:i:s')]);
                }
                
                // 10. Orijinal cari'nin bakiyesini yeniden hesapla
                $this->bakiyeHesapla($original_cari_id);
                
                $db_connection->transComplete();
                
                if ($db_connection->transStatus() === false) {
                    throw new \Exception('Birleştirme işlemi sırasında hata oluştu');
                }
                
                // Log kaydı
                $this->logClass->save_log(
                    'info',
                    'cari_birlesim',
                    null,
                    null,
                    'create',
                    'Birleştirme işlemi başarıyla tamamlandı',
                    json_encode(['original_cari_id' => $original_cari_id, 'merge_cari_ids' => $merge_cari_ids, 'user_id' => $user_id])
                );
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Birleştirme işlemi başarıyla tamamlandı',
                    'original_cari_id' => $original_cari_id
                ]);
                
            } catch (\Exception $e) {
                $db_connection->transRollback();
                
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Birleştirme işlemi başarısız: ' . $e->getMessage()
                ]);
            }
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Geçersiz istek']);
    }




}