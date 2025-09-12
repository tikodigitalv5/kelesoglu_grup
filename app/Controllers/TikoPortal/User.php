<?php

namespace App\Controllers\TikoPortal;
use CodeIgniter\Database\Config;
use App\Controllers\BaseController;
use App\Libraries\Hash;
use App\Models\TikoERP\InvoiceExceptionTypeModel;
use App\Models\TikoERP\InvoiceSpecialBaseModel;
use App\Models\TikoERP\MoneyUnitModel;
use App\Models\TikoPortal\InvoiceTaxRateModel;
use App\Models\TikoPortal\InvoiceWithholdingModel;
use App\Models\TikoPortal\BankModel;
use App\Models\TikoPortal\DepartmentModel;
use App\Models\TikoPortal\ModuleModel;
use App\Models\TikoPortal\UserModel;
use App\Models\TikoPortal\UserModuleModel;
use App\Models\TikoPortal\UserPermission;
use App\Models\TikoPortal\UserViewCustomize;
use App\Models\TikoERP\OperationModel;
use CodeIgniter\I18n\Time;
use PhpCsFixer\Fixer\Casing\NativeFunctionTypeDeclarationCasingFixer;
use SebastianBergmann\CodeCoverage\NoCodeCoverageDriverWithPathCoverageSupportAvailableException;

/**
 * @property IncomingRequest $request 
 */

class User extends BaseController
{
    private $modelModule;
    private $modelUser;
    private $modelUserModule;
    private $modelUserPermission;
    private $modelUserViewCustomize;
    private $modelBank;
    private $modelDepartment;
    private $modelWithholding;
    private $modelExceptionType;
    private $modelSpecialBase;
    private $modelTaxRate;
    private $modelMoneyUnit;
    private $modelOperation;

    private $userDatabaseConnect;

    public function __construct()
    {
        $this->modelModule = new ModuleModel();
        $this->modelUser = new UserModel();
        $this->modelUserModule = new UserModuleModel();
        $this->modelUserPermission = new UserPermission();
        $this->modelUserViewCustomize = new UserViewCustomize();
        $this->modelBank = new BankModel();
        $this->modelDepartment = new DepartmentModel();
        $this->modelWithholding = new InvoiceWithholdingModel();
        $this->modelExceptionType = new InvoiceExceptionTypeModel();
        $this->modelSpecialBase = new InvoiceSpecialBaseModel();
        $this->modelTaxRate = new InvoiceTaxRateModel();
        $this->modelMoneyUnit = new MoneyUnitModel();
        $this->modelOperation = new OperationModel();
        helper('Helpers\number_format_helper');

    }

    public function login()
    {
        return view('auth/page/login');
    }

 

    public function register()
    {
        return view('auth/page/register');
    }

    public function userDatabase()
    {
       
        
       
        

        $userDatabaseDetail = [
            'hostname'     => '45.143.99.171',
            'username'     => 'brkd_us',
            'password'     => '2^bHSW9j?rMQ',
            'database'     => 'brkd_db',
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

    public function checkLogin()
    {
        helper('form');
        helper('text');

        $form_validation = \Config\Services::validation();
        $user_customizes = [];

        if ($this->request->getMethod(true) == 'POST') {
            $data = [
                'user_eposta' => $this->request->getPost('user_eposta'),
                'user_password' => $this->request->getPost('user_password')
            ];

            if (!$form_validation->run($data, 'loginRules')) {
                echo json_encode(['icon' => 'error', 'message' => $form_validation->getErrors()]);
                return;
            } else {
                $user_item = $this->modelUser->join('user_app', 'user.user_id = user_app.user_id')
                    ->join('app', 'app.app_id = user_app.app_id')
                    ->where('app.app_title', ENV('APP_NAME'))
                    ->where('user_eposta', $data['user_eposta'])
                    ->where('status', 'active')
                    ->first();
                
                if (!$user_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Kullanıcı durumu pasif. Lütfen yöneticiniz ile iletişime geçiniz.']);
                    return;
                }

                $check_password = Hash::check($data['user_password'], $user_item['user_password']);
                if (!$check_password) {
                    echo json_encode(['icon' => 'error', 'message' => 'Kullanıcı e-posta adresi veya şifre hatalı. Tekrar deneyiniz.']);
                    return;
                } else {
                    // $user_modules = $this->modelUserModule->join('module', 'module.module_id = user_module.module_id')
                    //     ->where('user_module.user_id', $user_item['user_id'])
                    //     ->where('user_module.status', 'active')
                    //     ->findAll();
                    $user_modules = $this->modelUserPermission->join('module', 'module.module_id = user_permission.module_id')
                        ->where('user_permission.client_id', $user_item['client_id'])
                        ->findAll();
                    $customize_items = $this->modelUserViewCustomize->where('user_id', $user_item['user_id'])->findAll();

                    # TODO: İlerleyen zamanlarda sorguları ve logic işlemleri optimize etmek adına aşağıdaki veriler 'id' => [item] şeklinde
                    # maplenerek koyulabilir. Ancak bu sefer order columnu gereksiz kalıyor. O yüzden şu anda bu konunun üzerinde çok
                    # durmaya gerek yok. İleride bu verileri cacheleyeceğimiz zaman tekrardan gündeme gelebilir.
                    $department_items = $this->modelDepartment->where('department_status', 'active')->orderBy('department_order', 'ASC')->findAll();
                    $bank_items = $this->modelBank->where('bank_status', 'active')->orderBy('bank_order', 'ASC')->findAll();
                    $withholding_items = $this->modelWithholding->where('withholding_status', 'active')->orderBy('withholding_order', 'ASC')->findAll();
                    $exception_type_items = $this->modelExceptionType->where('exception_status', 'active')->orderBy('exception_order', 'ASC')->findAll();
                    $special_base_items = $this->modelSpecialBase->where('special_base_status', 'active')->orderBy('special_base_order', 'ASC')->findAll();
                    $tax_rate_items = $this->modelTaxRate->where('tax_status', 'active')->orderBy('tax_order', 'ASC')->findAll();
                    $money_items = $this->modelMoneyUnit->where('user_id', $user_item['user_id'])->where('status', 'active')->orderBy('id', 'ASC')->findAll();

                    foreach ($customize_items as $customize_item) {
                        $user_customizes[$customize_item['component_name']] = $customize_item;
                    }
                    unset($user_item['user_password']);

     
                    $session_data = [
                        'user_item' => $user_item,
                        'user_id' => $user_item['user_id'],
                        'client_id' => $user_item['client_id'],
                        'user_modules' => $user_modules,
                        'user_customizes' => $user_customizes,
                        'department_items' => $department_items,
                        'bank_items' => $bank_items,
                        'withholding_items' => $withholding_items,
                        'exception_type_items' => $exception_type_items,
                        'special_base_items' => $special_base_items,
                        'tax_rate_items' => $tax_rate_items,
                        'money_items' => $money_items,
                    ];

                    if ($user_item['user_id'] == 7) {
                        $session_data['authorized_user_id'] = 7;
                        $session_data['user_id'] = 4;
                    }
                    session()->set($session_data);
                    echo json_encode(['icon' => 'success', 'message' => 'Başarılı bir şekilde giriş yapıldı']);
                    return;
                }
            }
        } else {
            return redirect()->back();
        }
    }

    public function checkRegister()
    {

        if (session()->has('logged_user')) {
            return redirect()->to(route_to('hesabim'));
        }

        helper('form');
        helper('text');
        helper('date');

        $form_validation = \Config\Services::validation();

        if ($this->request->getMethod(true) == 'POST') {
            $user_telefon = $this->request->getPost('user_phone');
            $user_adsoyad = $this->request->getPost('user_adsoyad');
            $firma_adi = $this->request->getPost('firma_adi');
            $operation_id = $this->request->getPost('operation_id');
            $user_pin = $this->request->getPost('user_pin');

            $user_id = 0;
            if (session()->has('user_id')) {
                $user_id = session()->get('user_id');
            }

            $data = [
                'user_eposta' => $this->request->getPost('user_eposta'),
                'user_password' => $this->request->getPost('user_password'),
                'password_check' => $this->request->getPost('password_check'),
            ];

            if (!$form_validation->run($data, 'signupRules')) {
                echo json_encode(['icon' => 'error', 'message' => 'Lütfen girilen değerleri kontrol ediniz']);
                return;
            } else {

                $insert_data = [
                    'user_id' => $user_id,
                    'operation' => $operation_id,
                    'user_eposta' => $data['user_eposta'],
                    'user_password' => Hash::make($data['user_password']),
                    'user_telefon' => $user_telefon,
                    'firma_adi' => $firma_adi,
                    'pin' => $user_pin,
                    'user_adsoyad' => $user_adsoyad,
                ];
                $this->modelUser->insert($insert_data);

                echo json_encode(['icon' => 'success', 'message' => 'Başarılı bir şekilde kayıt oluşturuldu']);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    public function makeHash($id)
    {
        $modelUser = new UserModel();
        $user_item = $modelUser->find($id);

        $modelUser->update($id, ['user_password' => Hash::make($user_item['user_password'])]);
    }

    public function logout()
    {
        $user_item = session()->get('user_item');

        session()->destroy();
        return redirect()->route('tportal.auth.login');
       
        /*if($user_item['operation'] > 0){
            session()->destroy();
            return redirect()->route('tportal.auth.login');
        }else{
            session()->destroy();
            return redirect()->route('tportal.auth.login');
           
        } */
    }

    public function userEdit()
    {
        $data_form = $this->request->getPost('formData');
        $data_list = $this->request->getPost('list');

 
        foreach ($data_form as $data) {
            $key = $data['name'];
            $value = $data['value'];
            $new_data_form[$key] = $value;
        }

        $user_item = $this->modelUser->where('user.client_id', $new_data_form['client_id'])->join('user_permission', 'user_permission.client_id = user.client_id', 'left')->first();
        if (!$user_item) {
            return view('not-found');
        }

        $permission_list_c = null;
        $permission_list_u = null;
        foreach ($data_list as $item) {
            if ($item['name'] == 'client_id') {
                $client_id = $item['value'];
            } elseif ($item['name'] == 'user_id') {
                $user_id = $item['value'];
            } elseif ($item['name'] == 'permission_list_c') {
                isset($item['value']) ? $permission_list_c = $item['value'] : '';
            } elseif ($item['name'] == 'permission_list_u') {
                isset($item['value']) ? $permission_list_u = $item['value'] : '';

            }
        }

        $user_id = $new_data_form['user_id'];
        $client_id = $new_data_form['client_id'];
        $firma_adi = $new_data_form['edit_firma_adi'];
        $user_adsoyad = $new_data_form['edit_user_adsoyad'];
        $user_telefon = $new_data_form['edit_user_telefon'];
        $user_eposta = $new_data_form['edit_user_eposta'];
        $user_status = $new_data_form['statusRadio'];
        $user_pass = $new_data_form['edit_user_password'];
        $user_pin = $new_data_form['edit_user_pin'];
        $operation_update = $new_data_form['operation_update'];

        $update_data = [
            'firma_adi' => $firma_adi,
            'user_adsoyad' => $user_adsoyad,
            'user_telefon' => $user_telefon,
            'user_eposta' => $user_eposta,
            'operation' => $operation_update,
            'user_password' => Hash::make($user_pass),
            'status' => $user_status,
            'pin' => $user_pin,
        ];
        if(strlen($user_pin) == 4){
            $this->modelUser->update($client_id, $update_data);
        }
        $is_change_user_mail = $user_item['user_eposta'] == $user_eposta ? 0 : 1;
        $is_change_user_password = $user_item['user_password'] == Hash::check($user_pass, $user_item['user_password']) ? 0 : 1;
        $is_change_user_status = $user_item['status'] == $user_status ? 0 : 1;

        if ($is_change_user_mail || $is_change_user_password || $is_change_user_status || $operation_update) {
            $this->modelUser->update($client_id, $update_data);
        }  


        $this->userDatabaseConnect = $this->userDatabase();

        $operation = $this->userDatabaseConnect->table("operation")->where("user_id", session()->get('user_id'))->get();
        $modelOperation = $operation->getResult();

        if(isset($permission_list_c)):
            foreach ($permission_list_c as $item) {
                $check_user_permission = $this->checkUserPermission($client_id, $item['value']);

                if ($check_user_permission['icon'] == 'success') {
                    $insert_data = [
                        'client_id' => $client_id,
                        'user_id' => $user_id,
                        'module_id' => $item['value'],
                    ];
                    $this->modelUserPermission->insert($insert_data);

                    $user_modules = $this->modelUserPermission->join('module', 'module.module_id = user_permission.module_id')
                        ->where('module.module_id', $item['value'])
                        ->findAll();

                } elseif ($check_user_permission['message'] == 'Bu modul zaten var.') {
                    $failed_permission_data[] = $item['name'];
                    continue;
                } else {
                    echo json_encode($check_user_permission);
                    return;
                }
            }
            if (isset($permission_list_u) && is_array($permission_list_u)) {
            foreach ($permission_list_u as $item) { // burada hataa veriyor
                $user_modules11 = $this->modelUserPermission
                    ->where('client_id', $client_id)
                    ->where('module_id', $item['value'])
                    ->first();

                if ($user_modules11) {
                    $this->modelUserPermission->delete($user_modules11['user_permission_id']);
                }
            }
        }
        endif;

        echo json_encode(['icon' => 'success', 'message' => 'Kullanıcı başarıyla güncellendi.', 'modelOperation' => $modelOperation, 'changeUserEposta' => $is_change_user_mail, 'changePassword' => $is_change_user_password, 'changeUserStatus' => $is_change_user_status]);
        return;
    }


    public function userList($date_start = null)
    {
        $page_title = "Kullanıcı Yönetimi";

        $user_list = $this->modelUser
            ->join('user u', 'user.client_id = u.user_id', 'left')
            ->where('user.client_id', session()->get('user_id'))
            ->where('u.super_admin', 0)
            ->where('u.deleted_at IS NULL', null, false)
            ->select('u.*')
            ->orderBy("created_at", "DESC")
            ->findAll();

        $all_module = $this->modelModule
            ->withDeleted()
            ->findAll();

            $this->userDatabaseConnect = $this->userDatabase();

            $operation = $this->userDatabaseConnect->table("operation")->where("user_id", session()->get('user_id'))->get();
            $modelOperation = $operation->getResult();

        // print_r($modelOperation);
        // return;

        $data = [
            'modelOperation' => $modelOperation,
            'page_title' => $page_title,
            'user_list' => $user_list,
            'all_module' => $all_module,
        ];

        return view('tportal/ayarlar/kullanici_yonetimi', $data);
    }

    public function userPermission()
    {
        $page_title = "Kullanıcı Yetkileri";

        $user_list = $this->modelUser
            ->join('user u', 'user.client_id = u.user_id', 'left')
            ->where('user.client_id', session()->get('user_id'))
            ->where('u.super_admin', 0)
            ->select('u.*')
            ->findAll();


        $all_module = $this->modelModule
            ->withDeleted()
            ->findAll();

        // print_r($all_module);
        // return;

        $data = [
            'page_title' => $page_title,
            'user_list' => $user_list,
            'all_module' => $all_module,
        ];

        return view('tportal/ayarlar/yetkiler', $data);
    }
    public function getUserPermission()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $user_id = $this->request->getPost('user_id');
            $client_id = $this->request->getPost('client_id');
            $user_pass = $this->request->getPost('pass');


            $all_user_permission = $this->modelUserPermission
                ->join('user', 'user.client_id = user_permission.client_id')
                ->where('user_permission.client_id', $client_id)
                ->findAll();

            $dec = Hash::decrypt($user_pass);

            $data = [
                'pass' => $dec,
            ];
            array_push($all_user_permission, $data);



            echo json_encode(['icon' => 'success', 'message' => 'Yetkiler getirildi', 'response' => $all_user_permission]);
            return;

        } else {
            return redirect()->back();
        }
    }

    public function userDelete()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $client_id = $this->request->getPost('client_id');

            $user_item = $this->modelUser->where('user.client_id', $client_id)->first();
            if (!$user_item) {
                return view('not-found');
            }

            $this->modelUser->delete($client_id);

            echo json_encode(['icon' => 'success', 'message' => 'Kullanıcı başarıyla silindi.']);
            return;

        } else {
            return redirect()->back();
        }
    }

    public function storeUserPermission()
    {

        if ($this->request->getMethod(true) == 'POST') {

            $selectedBaseModule = $this->request->getPost('params');
            $failed_permission_data = [];

            // print_r($selectedBaseModule);
            // return;

            // Kullanıcı bilgilerini al
            $client_id = null;
            $user_id = null;
            $permission_list_c = null;
            $permission_list_u = null;
            foreach ($selectedBaseModule as $item) {
                if ($item['name'] == 'client_id') {
                    $client_id = $item['value'];
                } elseif ($item['name'] == 'user_id') {
                    $user_id = $item['value'];
                } elseif ($item['name'] == 'permission_list_c') {
                    $permission_list_c = $item['value'];
                } elseif ($item['name'] == 'permission_list_u') {
                    $permission_list_u = $item['value'];
                }
            }


            foreach ($permission_list_c as $item) {

                $check_user_permission = $this->checkUserPermission($client_id, $item['value']);

                if ($check_user_permission['icon'] == 'success') {
                    $insert_data = [
                        'client_id' => $client_id,
                        'user_id' => $user_id,
                        'module_id' => $item['value'],
                    ];
                    $this->modelUserPermission->insert($insert_data);

                    $user_modules = $this->modelUserPermission->join('module', 'module.module_id = user_permission.module_id')
                        ->where('module.module_id', $item['value'])
                        ->findAll();

                } elseif ($check_user_permission['message'] == 'Bu modul zaten var.') {
                    $failed_permission_data[] = $item['name'];
                    continue;
                } else {
                    echo json_encode($check_user_permission);
                    return;
                }
            }

            $user_permission_ids_to_remove = array();

            foreach ($permission_list_u as $item) {
                $user_modules11 = $this->modelUserPermission
                    ->where('client_id', $client_id)
                    ->where('module_id', $item['value'])
                    ->first();

                if ($user_modules11) {
                    $this->modelUserPermission->delete($user_modules11['user_permission_id']);
                }

            }

            if (count($failed_permission_data) > 0) {
                $response_data['icon'] = 'warning';
                $response_data['message'] = 'Seçilen moduller bir kısmı tanımlanamadı. Aşağıda verilen modül isimleri kullanıcıda tanımlı olduğu için yeniden tanımlanmadı.';
                $response_data['failed_items'] = $failed_permission_data;
            } else {
                $response_data['icon'] = 'success';
                $response_data['message'] = 'Seçilen moduller başarıyla tanımlandı.';
                $response_data['failed_items'] = "";
            }

            echo json_encode($response_data);
            return;

        } else {
            return redirect()->back();
        }
    }

    private function checkUserPermission($client_id, $module_id)
    {
        $all_user_permission = $this->modelUserPermission
            ->where('client_id', $client_id)
            ->findAll();


        foreach ($all_user_permission as $item) {
            if (isset($item['module_id']) && ($item['module_id'] == $module_id)) {
                return ['icon' => 'error', 'message' => 'Bu modul zaten var.'];
            }
        }

        return ['icon' => 'success', 'value' => "gogogo"];
    }
}
