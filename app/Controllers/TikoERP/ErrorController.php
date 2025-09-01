<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;

class ErrorController extends BaseController
{
    public function index()
    {
        helper('Helpers\number_format_helper');

        return view('tportal/error/index');
    }
}