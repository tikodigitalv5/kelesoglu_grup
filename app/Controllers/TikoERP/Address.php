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


class Address extends BaseController{
    private $DatabaseConfig;
    private $currentDB;
    
    private $modelCari;
    private $modelAddress;
    private $modelMoneyUnit;
    private $logClass;

    public function __construct()
    {

        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
        helper('Helpers\formatter_helper');
        helper('Helpers\stock_func_helper');

        
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelCari = model($TikoERPModelPath.'\CariModel', true, $db_connection);
        $this->modelAddress = model($TikoERPModelPath.'\AddressModel', true, $db_connection);
        $this->modelMoneyUnit = model($TikoERPModelPath . '\MoneyUnitModel', true, $db_connection);

        $this->logClass = new Log();
    }

    public function list($cari_id = null){
        $cari_item = $this->modelCari->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')
                                    ->where('cari.cari_id', $cari_id)
                                    ->where('cari.user_id', session()->get('user_id'))
                                    ->first();
                                    $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
                                    $cari_item["dolarKur"] = $MoneyUnitsDolar["money_value"];
                                    $cari_item["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
                                    $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
                                    $cari_item["euroKur"] = $MoneyUnitsEuro["money_value"];
                                    $cari_item["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];
        if(!$cari_item){
            echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen adres bulunamadı.']);
            return;
        }

        $address_items = $this->modelAddress->where('user_id', session()->get('user_id'))
                                            ->where('cari_id', $cari_id)
                                            ->where('status', 'active')
                                            ->findAll();
        $data = [
            'cari_item' => $cari_item,
            'address_items' => $address_items,
        ];

        return view('tportal/cariler/detay/adresler', $data);
    }

    public function create($cari_id = null){
        if($this->request->getMethod('true') == 'POST'){
            $cari_item = $this->modelCari->where('cari_id', $cari_id)->where('user_id', session()->get('user_id'))->first();
            if(!$cari_item){
                echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen stok bulunamadı.']);
                return;
            }
            try {
                $address_title = $this->request->getPost('address_title');
                $address_phone = $this->request->getPost('address_phone');
                $area_code = $this->request->getPost('area_code');
                $address_email = $this->request->getPost('address_email');
                $address = $this->request->getPost('address');
                $address_country = $this->request->getPost('address_country');
                $address_city = $this->request->getPost('address_city_name');   // il verir
                $address_city_plate = $this->request->getPost('address_city');  // plaka verir
                $address_district = $this->request->getPost('address_district');
                $zip_code = $this->request->getPost('zip_code');
                $default = $this->request->getPost('default');

                //gelen telefon numarasını temizledikten sonra alan kodunun yanına bir boşluk bıraktıktan sonra telefon numarasını kaydediyoruz.
                //telefon numarasını ekrana yazdırmak isterken boşluğu göre split ettikten sonra yazdırabiliriz.
                $phone = str_replace(array('(', ')', ' '), '', $address_phone);
                $phoneNumber = $address_phone ? $area_code . " " . $phone : null;

                $insert_address_data = [
                    'user_id' => session()->get('user_id'),
                    'cari_id' => $cari_id,
                    'address_title' => $address_title,
                    'address_country' => $address_country,
                    'address_city' => $address_city,
                    'address_city_plate' => $address_city_plate,
                    'address_district' => $address_district,
                    'zip_code' => $zip_code,
                    'address' => $address,
                    'address_phone' => $phoneNumber,
                    'address_email' => $address_email,
                    'default' => 'false',
                    'status' => 'active',
                ];

                if($default){
                    $address_items = $this->modelAddress->where('user_id', session()->get('user_id'))->where('cari_id', $cari_id)->where('default', 'true')->findAll();
                    foreach($address_items as $address_item){
                        $this->modelAddress->update($address_item['address_id'], ['default' => 'false']);
                    }

                    $insert_address_data['default'] = 'true';
                }

                $this->modelAddress->insert($insert_address_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Adres başarıyla eklendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'address',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }

        }else {
            return redirect()->back();
        }
    }

    public function edit(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $address_id = $this->request->getPost('address_id');
                $address_title = $this->request->getPost('edit_address_title');
                $address_phone = $this->request->getPost('edit_address_phone');
                $area_code = $this->request->getPost('edit_area_code');
                $address_email = $this->request->getPost('edit_address_email');
                $address = $this->request->getPost('edit_address');
                $address_country = $this->request->getPost('edit_address_country');
                $address_city = $this->request->getPost('edit_address_city_name');   // il verir
                $address_city_plate = $this->request->getPost('edit_address_city');  // plaka verir
                $address_district = $this->request->getPost('edit_address_district');
                $zip_code = $this->request->getPost('edit_zip_code');

                //gelen telefon numarasını temizledikten sonra alan kodunun yanına bir boşluk bıraktıktan sonra telefon numarasını kaydediyoruz.
                //telefon numarasını ekrana yazdırmak isterken boşluğu göre split ettikten sonra yazdırabiliriz.
                $phone = str_replace(array('(', ')', ' '), '', $address_phone);
                $phoneNumber = $address_phone ? $area_code . " " . $phone : null;

                
                $address_item = $this->modelAddress->where('address_id', $address_id)->where('user_id', session()->get('user_id'))->first();
                if(!$address_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen adres bulunamadı.']);
                    return;
                }

                $update_address_data = [
                    'address_title' => $address_title,
                    'address_country' => $address_country,
                    'address_city' => $address_city,
                    'address_city_plate' => $address_city_plate,
                    'address_district' => $address_district,
                    'zip_code' => $zip_code,
                    'address' => $address,
                    'address_phone' => $phoneNumber,
                    'address_email' => $address_email,
                ];

                $this->modelAddress->update($address_id, $update_address_data);

                echo json_encode(['icon'=> 'success', 'message' => 'Adres başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'address',
                    $address_id,
                    null,
                    'edit',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }

        }else {
            return redirect()->back();
        }
    }

    public function editDefault(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $cari_id = $this->request->getPost('cari_id');
                $address_id = $this->request->getPost('address_id');

                $address_item = $this->modelAddress->where('address_id', $address_id)->where('user_id', session()->get('user_id'))->first();
                if(!$address_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen adres bulunamadı.']);
                    return;
                }

                $address_items = $this->modelAddress->where('user_id', session()->get('user_id'))->where('cari_id', $cari_id)->where('default', 'true')->findAll();
                
                foreach($address_items as $address_item){
                    $this->modelAddress->update($address_item['address_id'], ['default' => 'false']);
                }
                $this->modelAddress->update($address_id, ['default' => 'true']);

                echo json_encode(['icon'=> 'success', 'message' => 'Adres başarıyla güncellendi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'address',
                    $address_id,
                    null,
                    'edit',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }

        }else {
            return redirect()->back();
        }
    }

    public function delete(){
        if($this->request->getMethod('true') == 'POST'){
            try {
                $address_id = $this->request->getPost('address_id');

                $address_item = $this->modelAddress->where('address_id', $address_id)->where('user_id', session()->get('user_id'))->first();
                if(!$address_item){
                    echo json_encode(['icon'=> 'error', 'message' => 'Belirtilen adres bulunamadı.']);
                    return;
                }

                $this->modelAddress->delete($address_id);

                echo json_encode(['icon'=> 'success', 'message' => 'Adres başarıyla silindi.']);
                return;
            }catch(\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'address',
                    $address_id,
                    null,
                    'delete',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon'=> 'error', 'message' => $e->getMessage()]);
                return;
            }

        }else {
            return redirect()->back();
        }
    }
}