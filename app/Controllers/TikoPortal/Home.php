<?php

namespace App\Controllers\TikoPortal;

use App\Controllers\BaseController;
use App\Models\TikoPortal\ModuleModel;
use App\Models\TikoPortal\UserModel;
use App\Models\TikoPortal\UserModuleModel;

/**
 * @property IncomingRequest $request 
 */

class Home extends BaseController{


        public function __construct()
    {

        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');
        helper('Helpers\formatter_helper');
        helper('Helpers\stock_func_helper');

    }

    public function index(){
        return redirect()->route('tportal.auth.login');
    }

    public function setSession(){
        $modelUser = new UserModel();
        $modelUserModule = new UserModuleModel();
        $user_item = $modelUser->join('user_app', 'user.user_id = user_app.user_id')
                                ->first();

        $user_modules = $modelUserModule->join('module', 'module.module_id = user_module.module_id')
                                    ->where('user_module.user_id', $user_item['user_id'])
                                    ->where('user_module.status', 'active')
                                    ->findAll();
        $session_data = [
            'user_item' => $user_item,
            'user_modules' => $user_modules
        ];
        session()->set($session_data);
    }

    public function clearSession(){
        session()->destroy();
    }

    public function hazirlaniyor(){
        
       
        return view('tportal/hazirlaniyor');
    }

    public function module_data(){
        $module_data = [
            [
                'module_title' => 'Cariler',
                'module_route' => '',
                'module_icon' => 'icon ni ni-users',
                'module_order' => '1000',
                'parent_id' => '0',
            ],
            [
                'module_title' => 'Stoklar',
                'module_route' => '',
                'module_icon' => 'icon ni ni-layers',
                'module_order' => '2000',
                'parent_id' => '0',
            ],
            [
                'module_title' => 'Teklifler',
                'module_route' => '',
                'module_icon' => 'icon ni ni-folder-list',
                'module_order' => '3000',
                'parent_id' => '0',
            ],
            [
                'module_title' => 'Siparişler',
                'module_route' => '',
                'module_icon' => 'icon ni ni-clipboad-check',
                'module_order' => '4000',
                'parent_id' => '0',
            ],
            [
                'module_title' => 'Üretim',
                'module_route' => '',
                'module_icon' => 'icon ni ni-property',
                'module_order' => '5000',
                'parent_id' => '0',
            ],
            [
                'module_title' => 'Faturalar',
                'module_route' => '',
                'module_icon' => 'icon ni ni-file-text',
                'module_order' => '6000',
                'parent_id' => '0',
            ],
            [
                'module_title' => 'Giderler',
                'module_route' => '',
                'module_icon' => 'icon ni ni-wallet-alt',
                'module_order' => '7000',
                'parent_id' => '0',
            ],
            [
                'module_title' => 'Hesaplar',
                'module_route' => '',
                'module_icon' => 'icon ni ni-money',
                'module_order' => '8000',
                'parent_id' => '0',
            ],
            [
                'module_title' => 'Raporlar',
                'module_route' => '',
                'module_icon' => 'icon ni ni-growth',
                'module_order' => '9000',
                'parent_id' => '0',
            ],
            [
                'module_title' => 'Müşteriler',
                'module_route' => 'tportal.cariler.list/customers',
                'module_icon' => '',
                'module_order' => '1001',
                'parent_id' => '1',
            ],
            [
                'module_title' => 'Tedarikçiler',
                'module_route' => 'tportal.cariler.list/suppliers',
                'module_icon' => '',
                'module_order' => '1002',
                'parent_id' => '1',
            ],
            [
                'module_title' => 'Tüm Cariler',
                'module_route' => 'tportal.cariler.list/all',
                'module_icon' => '',
                'module_order' => '1003',
                'parent_id' => '1',
            ],
            [
                'module_title' => 'Yeni Cari',
                'module_route' => 'tportal.cariler.create',
                'module_icon' => '',
                'module_order' => '1004',
                'parent_id' => '1',
            ],
            [
                'module_title' => 'Ürünler',
                'module_route' => 'tportal.stocks.list/products',
                'module_icon' => '',
                'module_order' => '2001',
                'parent_id' => '2',
            ],
            [
                'module_title' => 'Hizmetler',
                'module_route' => 'tportal.stocks.list/services',
                'module_icon' => '',
                'module_order' => '2002',
                'parent_id' => '2',
            ],
            [
                'module_title' => 'Tüm Stoklar',
                'module_route' => 'tportal.stocks.list/all',
                'module_icon' => '',
                'module_order' => '2003',
                'parent_id' => '2',
            ],
            [
                'module_title' => 'Yeni Ürün/Hizmet',
                'module_route' => 'tportal.stocks.create',
                'module_icon' => '',
                'module_order' => '2004',
                'parent_id' => '2',
            ],
            [
                'module_title' => 'Ayarlar',
                'module_route' => '',
                'module_icon' => '',
                'module_order' => '2005',
                'parent_id' => '2',
                'is_dropdown' => 'true'
            ],
            [
                'module_title' => 'Tipler',
                'module_route' => 'tportal.stocks.type',
                'module_icon' => '',
                'module_order' => '2005',
                'parent_id' => '2',
            ],
            [
                'module_title' => 'Kategoriler',
                'module_route' => 'tportal.stocks.category',
                'module_icon' => '',
                'module_order' => '2006',
                'parent_id' => '2',
            ],
            [
                'module_title' => 'Birimler',
                'module_route' => 'tportal.stocks.unit',
                'module_icon' => '',
                'module_order' => '2007',
                'parent_id' => '2',
            ],
            [
                'module_title' => 'Operasyonlar',
                'module_route' => 'tportal.stocks.operation',
                'module_icon' => '',
                'module_order' => '2008',
                'parent_id' => '2',
            ],
            [
                'module_title' => 'Depolar',
                'module_route' => 'tportal.stocks.warehouse',
                'module_icon' => '',
                'module_order' => '2009',
                'parent_id' => '2',
            ],
            [
                'module_title' => 'Varyantlar',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '2010',
                'parent_id' => '2',
            ],
            [
                'module_title' => 'Açık Teklifler',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '3001',
                'parent_id' => '3',
            ],
            [
                'module_title' => 'Kapalı Teklifler',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '3002',
                'parent_id' => '3',
            ],
            [
                'module_title' => 'Tüm Teklifler',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '3003',
                'parent_id' => '3',
            ],
            [
                'module_title' => 'Yeni Teklif',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '3004',
                'parent_id' => '3',
            ],
            [
                'module_title' => 'Açık Siparişler',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '4001',
                'parent_id' => '4',
            ],
            [
                'module_title' => 'Kapalı Siparişler',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '4002',
                'parent_id' => '4',
            ],
            [
                'module_title' => 'Tüm Siparişler',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '4003',
                'parent_id' => '4',
            ],
            [
                'module_title' => 'Yeni Sipariş',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '4004',
                'parent_id' => '4',
            ],
            [
                'module_title' => 'Açık Emirler',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '5001',
                'parent_id' => '5',
            ],
            [
                'module_title' => 'Kapalı Emirler',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '5002',
                'parent_id' => '5',
            ],
            [
                'module_title' => 'Tüm Emirler',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '5003',
                'parent_id' => '5',
            ],
            [
                'module_title' => 'Yeni Üretim Emri',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '5004',
                'parent_id' => '5',
            ],
            [
                'module_title' => 'Satış Faturaları',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '6001',
                'parent_id' => '6',
            ],
            [
                'module_title' => 'Alış Faturaları',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '6002',
                'parent_id' => '6',
            ],
            [
                'module_title' => 'Tüm Faturalar',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '6003',
                'parent_id' => '6',
            ],
            [
                'module_title' => 'Yeni Fatura',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '6004',
                'parent_id' => '6',
            ],
            [
                'module_title' => 'Gider Kalemleri',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '7001',
                'parent_id' => '7',
            ],
            [
                'module_title' => 'Personeller',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '7002',
                'parent_id' => '7',
            ],
            [
                'module_title' => 'Araçlar',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '7003',
                'parent_id' => '7',
            ],
            [
                'module_title' => 'Tüm Giderler',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '7004',
                'parent_id' => '7',
            ],
            [
                'module_title' => 'Yeni Gider',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '7005',
                'parent_id' => '7',
            ],
            [
                'module_title' => 'Kasalar',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '8001',
                'parent_id' => '8',
            ],
            [
                'module_title' => 'Banka Hesapları',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '8002',
                'parent_id' => '8',
            ],
            [
                'module_title' => 'Kredi Kartları',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '8003',
                'parent_id' => '8',
            ],
            [
                'module_title' => 'Çek ve Senetler',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '8004',
                'parent_id' => '8',
            ],
            [
                'module_title' => 'Yeni Hesap',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '8005',
                'parent_id' => '8',
            ],
            [
                'module_title' => 'Tüm Hesaplar',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '8005',
                'parent_id' => '8',
            ],
            [
                'module_title' => 'Gelir Raporları',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '9001',
                'parent_id' => '9',
            ],
            [
                'module_title' => 'Gider Raporları',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '9002',
                'parent_id' => '9',
            ],
            [
                'module_title' => 'Müşteri Raporları',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '9003',
                'parent_id' => '9',
            ],
            [
                'module_title' => 'Tedarikçi Raporları',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '9004',
                'parent_id' => '9',
            ],
            [
                'module_title' => 'Stok Raporları',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '9005',
                'parent_id' => '9',
            ],
            [
                'module_title' => 'Sipariş Raporları',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '9006',
                'parent_id' => '9',
            ],
            [
                'module_title' => 'Ödeme Raporları',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '9007',
                'parent_id' => '9',
            ],
            [
                'module_title' => 'Tahsilat Raporları',
                'module_route' => 'tportal.hazirlaniyor',
                'module_icon' => '',
                'module_order' => '9008',
                'parent_id' => '9',
            ],
        ];

        $modelUser = new UserModel();
        $modelUserModule = new UserModuleModel();
        $modelModule = new ModuleModel();

        foreach($module_data as $module){
            $modelModule->insert($module);
        }

        $module_items = $modelModule->findAll();

        $all_users = $modelUser->findAll();
        foreach($all_users as $user){
            foreach($module_items as $module_item){
                $user_module_data = [
                    'user_id' => $user['user_id'],
                    'module_id'=> $module_item['module_id'],
                    'status' => 'active'
                ];
                $modelUserModule->insert($user_module_data);
            }
        }

    }
}
