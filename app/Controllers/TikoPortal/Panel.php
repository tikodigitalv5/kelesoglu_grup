<?php

namespace App\Controllers\TikoPortal;

use App\Controllers\BaseController;

/**
 * @property IncomingRequest $request 
 */

class Panel extends BaseController{
    
    public function index(): string{
        return view('welcome_message');
    }
}
