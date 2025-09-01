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


class CariUser extends BaseController
{
    private $DatabaseConfig;
    private $currentDB;

    private $modelCari;
    private $modelCariUser;
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

        $this->modelCari = model($TikoERPModelPath . '\CariModel', true, $db_connection);
        $this->modelCariUser = model($TikoERPModelPath . '\CariUserModel', true, $db_connection);
        $this->modelMoneyUnit = model($TikoERPModelPath . '\MoneyUnitModel', true, $db_connection);

        $this->logClass = new Log();
    }

    public function list($cari_id = null)
    {
        $cari_item = $this->modelCari->where('cari_id', $cari_id)->where('cari.user_id', session()->get('user_id'))->join('money_unit', 'money_unit.money_unit_id = cari.money_unit_id')->first();
        if (!$cari_item) {
            echo json_encode(['icon' => 'error', 'message' => 'Belirtilen kullanıcı bulunamadı.']);
            return;
        }
        $MoneyUnitsDolar = $this->modelMoneyUnit->where("money_unit_id", 1)->first();
        $cari_item["dolarKur"] = $MoneyUnitsDolar["money_value"];
        $cari_item["dolarKurCeviri"] = $MoneyUnitsDolar["usdeuro"];
        $MoneyUnitsEuro = $this->modelMoneyUnit->where("money_unit_id", 2)->first();
        $cari_item["euroKur"] = $MoneyUnitsEuro["money_value"];
        $cari_item["euroKurCeviri"] = $MoneyUnitsEuro["usdeuro"];
        $cari_user_items = $this->modelCariUser->where('user_id', session()->get('user_id'))
            ->where('cari_id', $cari_id)
            ->orderBy('cari_user_id', 'DESC')
            ->findAll();

        $money_item = $this->modelMoneyUnit->where('user_id', session()->get('user_id'))
            ->where('money_unit_id', $cari_item['money_unit_id'])
            ->where('status', 'active')
            ->first();

        $data = [
            'cari_item' => $cari_item,
            'cari_user_items' => $cari_user_items,
            'department_items' => session()->get('department_items'),
            'money_item' => $money_item,
        ];

        // var_dump($cari_user_items);
        // exit;

        return view('tportal/cariler/detay/yetkililer', $data);
    }

    public function create($cari_id = null)
    {
        if ($this->request->getMethod('true') == 'POST') {
            $cari_item = $this->modelCari->where('cari_id', $cari_id)->where('user_id', session()->get('user_id'))->first();
            if (!$cari_item) {
                echo json_encode(['icon' => 'error', 'message' => 'Belirtilen yetkili bulunamadı.']);
                return;
            }
            try {
                $department_id = $this->request->getPost('department_id');
                $cari_user_name = $this->request->getPost('cari_user_name');
                $cari_user_phone = $this->request->getPost('cari_user_phone');
                $area_code = $this->request->getPost('area_code');
                $cari_user_email = $this->request->getPost('cari_user_email');
                $internal_number = $this->request->getPost('internal_number');

                //gelen telefon numarasını temizledikten sonra alan kodunun yanına bir boşluk bıraktıktan sonra telefon numarasını kaydediyoruz.
                //telefon numarasını ekrana yazdırmak isterken boşluğu göre split ettikten sonra yazdırabiliriz.
                $phone = str_replace(array('(', ')', ' '), '', $cari_user_phone);
                $phoneNumber = $cari_user_phone ? $area_code . " " . $phone : null;

                $insert_cari_user_data = [
                    'user_id' => session()->get('user_id'),
                    'cari_id' => $cari_id,
                    'department_id' => $department_id,
                    'cari_user_name' => $cari_user_name,
                    'cari_user_phone' => $phoneNumber,
                    'cari_user_email' => $cari_user_email,
                    'internal_number' => $internal_number,
                ];

                $this->modelCariUser->insert($insert_cari_user_data);

                echo json_encode(['icon' => 'success', 'message' => 'Yetkili bilgisi başarıyla eklendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'cari_user',
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

    public function edit()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $cari_user_id = $this->request->getPost('cari_user_id');
                $department_id = $this->request->getPost('edit_department_id');
                $cari_user_name = $this->request->getPost('edit_cari_user_name');
                $cari_user_phone = $this->request->getPost('edit_cari_user_phone');
                $area_code = $this->request->getPost('area_code');
                $cari_user_email = $this->request->getPost('edit_cari_user_email');
                $internal_number = $this->request->getPost('edit_cari_user_internal_number');

                //gelen telefon numarasını temizledikten sonra alan kodunun yanına bir boşluk bıraktıktan sonra telefon numarasını kaydediyoruz.
                //telefon numarasını ekrana yazdırmak isterken boşluğu göre split ettikten sonra yazdırabiliriz.
                $phone = str_replace(array('(', ')', ' '), '', $cari_user_phone);
                $phoneNumber = $cari_user_phone ? $area_code . " " . $phone : null;

                $cari_user_item = $this->modelCariUser->where('cari_user_id', $cari_user_id)->where('user_id', session()->get('user_id'))->first();
                if (!$cari_user_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen yetkili bilgisi bulunamadı.']);
                    return;
                }

                $update_cari_user_data = [
                    'department_id' => $department_id,
                    'cari_user_name' => $cari_user_name,
                    'cari_user_phone' => $phoneNumber,
                    'cari_user_email' => $cari_user_email,
                    'internal_number' => $internal_number,
                ];

                $this->modelCariUser->update($cari_user_id, $update_cari_user_data);

                echo json_encode(['icon' => 'success', 'message' => 'Yetkili bilgisi başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'cari_user',
                    $cari_user_id,
                    null,
                    'edit',
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

    public function delete()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $cari_user_id = $this->request->getPost('cari_user_id');

                $cari_user_item = $this->modelCariUser->where('cari_user_id', $cari_user_id)->where('user_id', session()->get('user_id'))->first();
                if (!$cari_user_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Belirtilen yetkili bilgisi bulunamadı.']);
                    return;
                }

                $this->modelCariUser->delete($cari_user_id);

                echo json_encode(['icon' => 'success', 'message' => 'Yetkili bilgisi başarıyla silindi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'cari_user',
                    $cari_user_id,
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
}
