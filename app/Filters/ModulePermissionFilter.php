<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class ModulePermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if(!session()->has('user_id')){
            return redirect()->to(route_to('tportal.auth.login'))->with('failed', 'Devam etmek için önce giriş yapmalısınız.');
        }
        // Kullanıcının yetkili olduğu modülleri session'dan al
        $userModules = session()->get('user_modules');

        // Geçerli route'u al (örneğin 'tportal/cari' veya 'tportal/order')
        $currentPath = $request->getUri()->getSegment(2); // 'cari', 'order', 'offer' gibi modül ismini al

   
        // Kullanıcının yetkili olduğu modüllerin başlıklarını alıyoruz
        $allowedModules = array_column($userModules, 'module_route');
  

        // Eğer kullanıcı bu modüle yetkili değilse, yetkisiz sayfasına yönlendir
        if (!in_array("$currentPath", $allowedModules)) {
            return redirect()->to('/tportal/yetkilendirme-hatasi');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Bu alan boş bırakılabilir
    }
}