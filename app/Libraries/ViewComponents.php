<?php 
namespace App\Libraries;

class ViewComponents {
    private $componentDefaultPaths;

    public function __construct(){
        $this->componentDefaultPaths = [
            'stoklar.yeni' => 'default/stoklar/yeni',
            'stoklar.list' => 'default/stoklar/list',
            'stoklar.detay.detay' => 'default/stoklar/detay/detay',
            'stoklar.detay.hareketler' => 'default/stoklar/detay/hareketler',
            'stoklar.detay.alturunler' => 'default/stoklar/detay/alturunler',
            'stoklar.detay.ozellikler' => 'components/stoklar_detay_ozellikler_',
            'stoklar.detay.topluvaryant.buton' => 'components/stoklar_detay_topluvaryant_buton_',
            'stoklar.detay.ozellikler_solmenu' => 'components/stoklar_detay_ozellikler_solmenu_',

            
        ];
    }

    public function getModals(array $params = []){

        foreach($params['modals'] as $modalKey => $modalValue){
            $params['modals'][$modalKey]['element'] = $params['element'];
            echo view('tportal/inc/modals/'.$modalKey.'-modal', $params['modals'][$modalKey]);
        };

        # View Cell string dönmek zorunda. Eğer aşağıdaki stringe bir değer verirsek onu da
        # sayfaya bastığı için boş string veriyoruz.
        return '';
    }

    public function getSearchCustomerModal(string $fromWhere){
        $data = [
            'fromWhere' => $fromWhere,
        ];

        echo view('tportal/inc/modals/search-customer-modal.php', $data);
        return '';
    }

    public function getSearchSupplierModal(string $fromWhere){
        $data = [
            'fromWhere' => $fromWhere,
        ];

        echo view('tportal/inc/modals/search-supplier-modal.php', $data);
        return '';
    }

    public function getSearchTedarikCustomerModal(string $fromWhere){
        $data = [
            'fromWhere' => $fromWhere,
        ];

        echo view('tportal/inc/modals/search-tedarik-modal.php', $data);
        return '';
    }
    
    public function getSearchStockModal(){
        echo view('tportal/inc/modals/search-stock-modal.php');
        return '';
    }

    public function ExtraSelect(){
        echo view('tportal/components/extra_select.php');
        return '';
    }

    

    public function getSiparisStockModal(){
        echo view('tportal/inc/modals/siparis-stock-modal.php');
        return '';
    }

    public function getSiparisStockModalEslesen(){
        echo view('tportal/inc/modals/siparis-stock-modal-eslesen.php');
        return '';
    }

    public function getSearchSubStockModal(){
        echo view('tportal/inc/modals/search-sub-stock-modal.php');
        return '';
    }
    public function getSearchOrderModal(){
        echo view('tportal/inc/modals/search-order-modal.php');
        return '';
    }

    public function getSearchOrderModalUretim(){
        echo view('tportal/inc/modals/search-order-modal-uretim.php');
        return '';
    }

    public function getComponent(array $params = []){
        $component_name = $params['component_name'];
        $user_customizes = session('user_customizes');

        try{
            $file_path = isset($user_customizes[$component_name]) ? $user_customizes[$component_name]['file_path'] : $this->componentDefaultPaths[$component_name];
        }catch(\Exception $e){
            $file_path = null;
        }

        if(!$file_path){
            return '';
        }else {
            return view('tportal/'.$file_path);
        }
    }
}
?>