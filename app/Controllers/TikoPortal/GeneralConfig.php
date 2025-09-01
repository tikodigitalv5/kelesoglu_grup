<?php

namespace App\Controllers\TikoPortal;

use App\Controllers\BaseController;


/**
 * @property IncomingRequest $request 
 */

class GeneralConfig extends BaseController{

    private $className;

    public function index(): string{
        return view('welcome_message');
    }

    public function setDBConfigs(){
        $user_item = session('user_item');
        if($user_item){
            $currentDB = Config('Database')->dynamicDB;
    
            $currentDB['hostname'] = ($user_item['db_host']) ?: '85.117.239.191';
            $currentDB['username'] = ($user_item['db_username']) ?: 'tikoportal_default_user';
            $currentDB['password'] = ($user_item['db_password']) ?: 'F(u[vl[d[xyZ';
            $currentDB['database'] = ($user_item['db_name']) ?: 'tikoportal_default_db';
        }else {
            $currentDB = Config('Database')->defaultDB;
        }

        return $currentDB;
    }

    public function filterCustomizeByClassName($className){
        $this->className = $className;

        $user_customizes = session('user_customizes');
        $filtered_array = array_filter($user_customizes, array($this, "filterByClassName"));
        return $filtered_array;
    }

    public function searchByFunctionName($filteredArray, $functionName){
        $newArray = array_column($filteredArray, 'file_path', 'function_name');
        $result = isset($newArray[$functionName]) ? $newArray[$functionName] : 'default/';
        return $result;
    }

    private function filterByClassName($array){
        if(array_search($this->className, $array))
           return TRUE;
        else 
           return FALSE; 
    }
    
}
