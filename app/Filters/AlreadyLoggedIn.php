<?php 

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AlreadyLoggedIn implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null)
    {
        if(session()->has('user_id')){
            return redirect()->to(route_to('tportal.dashboard'));
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}


?>
