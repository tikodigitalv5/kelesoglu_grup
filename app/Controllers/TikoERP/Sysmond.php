<?php

namespace App\Controllers\TikoERP;
use App\Controllers\BaseController;
use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\DatabaseConfig;
use App\Controllers\TikoPortal\GeneralConfig;
use App\Models\TikoERP\UnitModel;
use App\Models\TikoERP\SysmondCronModel;

/**
 * @property IncomingRequest $request 
 */


class Sysmond extends BaseController{
    private $DatabaseConfig;
    private $currentDB;

    private $sysmond;
    private $logClass;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->sysmond = model($TikoERPModelPath.'\SysmondCronModel', true, $db_connection);
        $this->logClass = new Log();

        helper('Helpers\number_format_helper');

    }

    public function list(){

        $sysmond_item = $this->sysmond->orderBy('tarih', 'DESC')->findAll();

        $data = [
            'sysmond_item' => $sysmond_item,
        ];

        return view('tportal/senkronizasyon/index', $data);
    }


}