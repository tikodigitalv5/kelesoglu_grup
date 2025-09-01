
        
    
<?php

function generate_barcode($code) {
    $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();
    return $generator->getBarcode($code, $generator::TYPE_CODE_128);
}

function kargo_logo($kargo)
{
	$img = '';


    if($kargo == "Yurtiçi"){
        $img = '<img src="'.base_url("images/kargo/yurtici.png").'" style="height: 48px; width: auto;;" alt="logo">';
    }
    if($kargo == "Aras"){
        $img = '<img src="'.base_url("images/kargo/aras.png").'" style="height: 48px; width: auto;;" alt="logo">';
    }

    if($kargo == "Carrtell"){
        $img = '<img src="'.base_url("images/kargo/cartel.jpg").'" style="height: 48px; width: auto;;" alt="logo">';
    }

    if($kargo == "Gittigidiyor Express"){
        $img = '<img src="'.base_url("images/kargo/gittigidiyor.png").'" style="height: 48px; width: auto;;" alt="logo">';
    }

    if($kargo == "Trendyol Express"){
        $img = '<img src="'.base_url("images/kargo/trendyol_express.png?v=3").'" style="height: 48px; width: auto;;" alt="logo">';
    }

    if($kargo == "Jetizz"){
        $img = '<img src="'.base_url("images/kargo/jetiz.png").'" style="height: 48px; width: auto;;" alt="logo">';
    }
    if($kargo == "Kargokar"){
        $img = '<img src="'.base_url("images/kargo/kargokar.png").'" style="height: 48px; width: auto;;" alt="logo">';
    }

    if($kargo == "MNG Kargo"){
        $img = '<img src="'.base_url("images/kargo/mng.png").'" style="height: 48px; width: auto;;" alt="logo">';
    }

    if($kargo == "Murathan JET"){
        $img = '<img src="'.base_url("images/kargo/murat.png").'" style="height: 48px; width: auto;;" alt="logo">';
    }

    if($kargo == "Sürat"){
        $img = '<img src="'.base_url("images/kargo/surat.png").'" style="height: 48px; width: auto;;" alt="logo">';
    }

    if($kargo == "hepsiJet"){
        $img = '<img src="'.base_url("images/kargo/hepsiJet.png").'" style="height: 48px; width: auto; max-width: 180px" alt="logo">';
    }
    if($kargo == "HepsiJet"){
        $img = '<img src="'.base_url("images/kargo/hepsiJet.png").'" style="height: 48px; width: auto; max-width: 180px" alt="logo">';
    }
    if($kargo == "hepsiJET"){
        $img = '<img src="'.base_url("images/kargo/hepsiJet.png").'" style="height: 48px; width: auto; max-width: 180px" alt="logo">';
    }
    if($kargo == "hepsiJET XL"){
        $img = '<img src="'.base_url("images/kargo/hepsiJET_XL.png").'" style="height: 48px; width: auto; max-width: 180px" alt="logo">';
    }

   if($kargo == "PTT Kargo" || $kargo == "PTT" ||  $kargo == "PTT Global" || $kargo == "PTT Kargo Marketplace"){
        $img = '<img src="'.base_url("uploads/ptt_kargo.png").'" style="height: 77px; width: auto;;" alt="logo">';
    }

    if($kargo == "Sendeo"){
        $img = '<img src="'.base_url("images/kargo/sendeo.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
    }


      return $img;

}



?>


<body style="width: 283px; height: 482px; overflow:hidden;">




    

        
    
    <table style="table-layout: fixed; font:16px arial,sans-serif;padding:5px;font-size:16px;">
        <tr>
            <th style="width: 144px;"></th>
            <th style="width: 208px"></th>
            <th style="width: 208px"></th>
            <th style="width: 208px"></th>
            <th></th>
        </tr>

        <tr>
            <td style="text-align:left;font-weight:bold; ">Gönderen</td>
           
        </tr>
        <tr>
        <td colspan="">FAMS OTOMOTİV</td>
            <td>+902242140041</td>
        </tr>
       
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align:left;font-weight:bold; width:100%;">Alıcı Bilgileri</td>
            <td><b><?php echo substr($order["order_no"], 3) ?></b></td>
        </tr>
        <tr>
           
            <td><?php echo $order["cari_invoice_title"]; ?> </td>
        </tr>
        
        <tr>
            
            <td colspan="2"><?php echo $order["address"]; ?></td>
        </tr>
        <tr>
           
            <td><?php echo $order["address_city"]; ?> / <?php echo $order["address_district"]; ?></td>
        </tr>
        
   
        <tr>
           
            <td><?php echo $order["cari_phone"]; ?></td>
        </tr>
        
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td></td>
            <td></td>
        </tr>

        <?php   foreach($order_rows as $order_row): 
            
                if(empty($order_row["paket_text"])):
            ?>
                        
                        <tr>
                            
                            
                            <td style="text-align:left; font-size:15px;" colspan="2"
                            
                            >
                            
                            <b>
                                
                                <?php echo $order_row["dopigo_sku"]; ?>  </b>  (  <?php echo number_format($order_row['stock_amount'], 2, ',', '.'); ?> Adet ) 
                                     
                                     
                                         <br> 
                                    
                                   
                                </td>
                                
                            
                        </tr>
                    
                <?php endif; endforeach;  ?>
     
                <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
            <tr>

            <td colspan="2">

            <div 
             style="padding:3px; text-align:center;">
                        
                        <div> 
                            <?php 
                        if(!empty($order["kargo_kodu"])){
                           echo  generate_barcode($order["kargo_kodu"]);
                        }
                        ?></div>
     
     <p style="padding-top:1px; margin-top:1px;">                    
     <?php  if(!empty($order["kargo_kodu"])){ ?>   
     <?php echo $order["kargo_kodu"]; ?>
     <?php } ?>
     </p>
                         </div>
            </td></tr>
     
    </table>

    <div style="display:flex; align-items:center; justify-content:space-between; height: 22px; margin-bottom: 10px;">
<img src="<?php echo $order["service_logo"]; ?>" style="height: 50px;" alt="logo">

<h3><?php if(!empty(kargo_logo($order["kargo"]))) { echo kargo_logo($order["kargo"]); } ?></h3>

</div>


<script>
    
        window.print();
    
</script>
    


    
</body>
    
