<?php 

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthCheck implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null)
    {
        if(!session()->has('user_id')){
            return redirect()->to(route_to('tportal.auth.login'))->with('failed', 'Devam etmek için önce giriş yapmalısınız.');
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){


    }
    
}


?>
