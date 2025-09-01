<?php

use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;

function generate_barcode_html($stock_item, $barcode_data, $transaction_note, $supplier)
{
    $barcode_number_length = 13;

    # Barkod numaralarının her müşteriye özel olarak unique olması için user_id içeren formatta kaydediyoruz.
    # Ancak müşterinin göreceği kısımlarda bu barkod numarasını maskelememiz gerekiyor.
    $barcode_number = substr($barcode_data['barcode_number'], 0, $barcode_number_length);

    // Barkod türünü ve formatını ayarlayın (PNG veya SVG)
    $barcode_format = 'SVG';

    // Barkod genişliğini ve yüksekliğini ayarlayın (genişlik faktörü ve yükseklik piksel cinsinden)
    $width_factor = 3;
    $height = 50;

    // Barkod nesnesini oluşturun
    if ($barcode_format === 'PNG') {
        $generator = new BarcodeGeneratorPNG();
    } else {
        $generator = new BarcodeGeneratorSVG();
    }

    // Barkod dosyasını oluşturun
    $barcode_file = $generator->getBarcode($barcode_number, $generator::TYPE_CODE_128, $width_factor, $height);

    # Html contenti bölerek oluşturmamızın sebebi ilerleyen dönemlerde birden fazla barkod numarasını for döngüsüyle
    # basabilicek olmamız.
    $html = "";
    $html .= '<html>
                <head>
                    <link href="https://fonts.googleapis.com/css?family=Oswald:500,600,700&amp;subset=latin-ext" rel="stylesheet">
            <style>
            body{
                height:100vh;
                font-family:"Oswald", "Arial"; font-size:22px;padding-left: 25px;
                margin: 0;  padding-top:10px;
            }

        
       
            @media print {
                @page {
                  size: legal;
                }
              } 
         
                table{
                    border-spacing: 0px;
                }
                /*.brdr{
                    border: 1px solid #000;
                }
                .alt-brdr{
                    border-bottom: 1px solid #000;
                    padding-top: 5px;
                    padding-bottom: 5px;
                }
                .sag-brdr{
                    border-right: 1px solid #000;
                }*/
                .row{
                    margin-right: 0px;
                    margin-left: 0px;
                }
                .sola-text{
                    text-align: left; padding-left: 15px;
                }
                .stndrt{
                    font-size: 20px; text-align: center;
                }
            </style>

            </head>
            <body><center>';
            if (session()->get('user_id') == 3 && isset($barcode_data['barkod_olusturma'])) {
                $html.= '  <div style="margin-top:10px; display: flex; /* flex-direction: column; */ justify-content: space-between; align-items: center; width: 380px;"> <div> </div>     <p style="font-size: 25px; ">'.$barcode_data['barkod_olusturma'].' </p>  </div>';
            }else{
                $html .= '<br><br><br>';
            }
            

    if ($supplier != 0) {
        $barkodHtml = ' <tr class="" >
                <td class="sag-brdr sola-text alt-brdr">
                    <b> TEDARİKÇİ KODU</b>
                </td>
                <td class="col-md-8 sola-text alt-brdr">
                    <b>
                       ' . $supplier['cari_code'] . '
                    </b>
                </td>
            </tr>';
    } else
        $barkodHtml = '';
    if ($transaction_note != '') {
        $barkodHtml .= ' <tr class="" style="height:60px;">
        <td class="sag-brdr sola-text alt-brdr" style="height:60px;">
            <b> NOT</b>
        </td>
        <td class="col-md-8 sola-text alt-brdr" style="height:60px;">
            <b>
               ' . $transaction_note . '
            </b>
        </td>
    </tr>';
    }


    if (session()->get('user_id') == 3) {
        $html .= '
       
        <table style="width: 380px;height: 390px;font-size: 20;  margin-bottom:30px;   text-align: center; page-break-after:always;" class="">
            <tbody>';

                $html .= '<tr>
                <td class=" alt-brdr" style="height:30px;">
                    <img src="'. base_url('custom/emdersan-logo.png').'" alt="emdersan-logo" srcset="" style="width: 320px;">
                </td>
            </tr>';

            $html .='
                <tr>
                    <td class="alt-brdr">
                        <!-- <b>ÖLÇÜ</b><br> -->
                        <b style="font-size: 30px;">
                            ' . $stock_item['stock_code'] . '<br>' . $stock_item['stock_title'] . '
                        </b>
                    </td>
                </tr>';
                
                if ( isset($stock_item['variant_title_v1']) && $stock_item['variant_title_v1'] ) {
                    $html .= '<tr>
                    <td>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td style="width:50%;" class="sag-brdr sola-text alt-brdr">
                                        <b> '.$stock_item['variant_title_v1'].'</b>
                                    </td>
                                    <td class="col-md-8 sola-text alt-brdr">
                                        <b>' . $stock_item['variant_property_v1'] . '</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>';
                }
                if (isset($stock_item['variant_title_v2']) && $stock_item['variant_title_v2'] ) {
                    $html .= '<tr>
                    <td>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td style="width:50%;" class="sag-brdr sola-text alt-brdr">
                                        <b> '.$stock_item['variant_title_v2'].'</b>
                                    </td>
                                    <td class="col-md-8 sola-text alt-brdr">
                                        <b>' . $stock_item['variant_property_v2'] . '</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>';
                }
                if (isset($stock_item['variant_title_v3']) && $stock_item['variant_title_v3'] ) {
                    $html .= '<tr>
                    <td>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td style="width:50%;" class="sag-brdr sola-text alt-brdr">
                                        <b> '.$stock_item['variant_title_v3'].'</b>
                                    </td>
                                    <td class="col-md-8 sola-text alt-brdr">
                                        <b>' . $stock_item['variant_property_v3'] . '</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>';
                }
                if (isset($stock_item['variant_title_v4']) && $stock_item['variant_title_v4'] ) {
                    $html .= '<tr>
                    <td>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td style="width:50%;" class="sag-brdr sola-text alt-brdr">
                                        <b> '.$stock_item['variant_title_v4'].'</b>
                                    </td>
                                    <td class="col-md-8 sola-text alt-brdr">
                                        <b>' . $stock_item['variant_property_v4'] . '</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>';
                }
                
                $html .='
                <tr>
                    <td>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td style="width:50%;" class="sag-brdr sola-text alt-brdr">
                                        <b> MİKTAR</b>
                                    </td>
                                    <td class="col-md-8 sola-text alt-brdr">
                                        <b id="adetx">' . number_format($barcode_data['total_amount'],2,',','.') . '' . $stock_item['unit_title'] . '</b>
                                    </td>
                                </tr>
                            ' . $barkodHtml . '
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="stndrt" style="height: 91px;">
                        <div style="margin-top:0px;margin-left: 25px;margin-right: 25px;" data-barcode="' . $barcode_number . '" id="barkodlar">
                        ' . $barcode_file . '<br>' . $barcode_number . '
                            </div>
                    </td>
                </tr>
            </tbody>
        </table>';
    } else {
        $html .= '<table style="width: 380px;height: 390px;font-size: 20;  margin-bottom:30px;   text-align: center; page-break-after:always;" class="">
            <tbody>';

                $html .= '<tr>
                <td class=" alt-brdr" style="height:30px;">
                    <!-- <b> DANSİTE</b><br> -->
                    <b style="font-size: 26px;">' . session()->get('user_item')['firma_adi'] . '</b>
                </td>
            </tr>';

            $html .='<tr>
                    <td class="alt-brdr">
                        <!-- <b>ÖLÇÜ</b><br> -->
                        <b style="font-size: 30px;line-height: 50px;">
                            ' . $stock_item['stock_code'] . '<br>' . $stock_item['stock_title'] . '
                        </b>
                    </td>
                </tr>
                <tr>
                    <td style="height:60px;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td style="width:50%;height:60px;" class="sag-brdr sola-text alt-brdr">
                                        <b> MİKTAR</b>
                                    </td>
                                    <td class="col-md-8 sola-text alt-brdr">
                                        <b id="adetx">' . number_format($barcode_data['total_amount'],2,',','.') . '' . $stock_item['unit_title'] . '</b>
                                    </td>
                                </tr>
                            ' . $barkodHtml . '
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="stndrt" style="height: 91px;">
                        <div style="margin-top:0px;margin-left: 25px;margin-right: 25px;" data-barcode="' . $barcode_number . '" id="barkodlar">
                        ' . $barcode_file . '<br>' . $barcode_number . '
                            </div>
                    </td>
                </tr>
            </tbody>
        </table>';
    }
    

    $html .= '</center></body></html>';

    return $html;
}

# Daha sonrasında bu sayı 13(random sayı) + 5(başına 0 konulacak şekilde user_id)
# olarak üretilerek barkod pdf oluşturulacak
function generate_barcode_number($barcode = null)
{
    helper('text');
    helper('date');
    if ($barcode) {
        $converted_user_id = str_pad(session()->get('user_id'), get_user_number_length(), '0', STR_PAD_LEFT);
        $converted_barcode = str_pad($barcode, get_barcode_number_length(), '0', STR_PAD_LEFT);
        $barcode_number = $converted_barcode . $converted_user_id;
    } else {
        $random_number = '';
        for ($i = 0; $i < get_barcode_number_length(); $i++) {
            $random_number .= random_int(0, 9);
        }
        $user_id_padded = str_pad(session()->get('user_id'), get_user_number_length(), '0', STR_PAD_LEFT);
        $barcode_number = $random_number . $user_id_padded;
        // $barcode_number = random_string('numeric', get_barcode_number_length()) . str_pad(session()->get('user_id'), get_user_number_length(), '0', STR_PAD_LEFT);
    }

    return $barcode_number;
}


function generate_barcode_number_fams($barcode = null)
{
    helper('text');
    helper('date');
    if ($barcode) {
        $converted_user_id = str_pad(1, get_user_number_length(), '0', STR_PAD_LEFT);
        $converted_barcode = str_pad($barcode, get_barcode_number_length(), '0', STR_PAD_LEFT);
        $barcode_number = $converted_barcode . $converted_user_id;
    } else {
        $random_number = '';
        for ($i = 0; $i < get_barcode_number_length(); $i++) {
            $random_number .= random_int(0, 9);
        }
        $user_id_padded = str_pad(1, get_user_number_length(), '0', STR_PAD_LEFT);
        $barcode_number = $random_number . $user_id_padded;
        // $barcode_number = random_string('numeric', get_barcode_number_length()) . str_pad(1, get_user_number_length(), '0', STR_PAD_LEFT);
    }

    return $barcode_number;
}

function convert_barcode_number_for_form($barcode = null)
{
    return substr($barcode, 0, get_barcode_number_length());;
}

function convert_barcode_number_for_sql($barcode = null)
{
    $converted_user_id = str_pad(session()->get('user_id'), get_user_number_length(), '0', STR_PAD_LEFT);
    $converted_barcode = str_pad($barcode, get_barcode_number_length(), '0', STR_PAD_LEFT);

    return $converted_barcode . $converted_user_id;
}

function convert_barcode_number_for_sqls($barcode = null)
{
    $converted_user_id = str_pad(1, get_user_number_length(), '0', STR_PAD_LEFT);
    $converted_barcode = str_pad($barcode, get_barcode_number_length(), '0', STR_PAD_LEFT);

    return $converted_barcode . $converted_user_id;
}


function convert_barcode_number_for_sql_4($barcode = null)
{
    $converted_user_id = str_pad(session()->get('user_id'), get_user_number_length_4(), '0', STR_PAD_LEFT);
    $converted_barcode = str_pad($barcode, get_user_number_length_4(), '0', STR_PAD_LEFT);

    return $converted_barcode . $converted_user_id;
}

function convert_barcode_number_for_sql_production($barcode = null)
{
  // Önce kullanıcı ID'sini alıp sonunda sıfır ekleyelim
  $converted_user_id = str_pad(session()->get('user_id'), get_user_number_length(), '0', STR_PAD_LEFT);

  // Barkod numarasını sonunda sıfır ekleyerek dönüştürelim
  $converted_barcode = str_pad($barcode, get_barcode_number_length(), '0', STR_PAD_RIGHT);

  // Barkod numarasını öne, kullanıcı ID'sini arkaya koyarak döndürelim
  return $converted_barcode . $converted_user_id;
}
function convert_barcode_number_for_sql_productions($barcode = null)
{
  // Önce kullanıcı ID'sini alıp sonunda sıfır ekleyelim
  $converted_user_id = str_pad(1, get_user_number_length(), '0', STR_PAD_LEFT);

  // Barkod numarasını sonunda sıfır ekleyerek dönüştürelim
  $converted_barcode = str_pad($barcode, get_barcode_number_length(), '0', STR_PAD_RIGHT);

  // Barkod numarasını öne, kullanıcı ID'sini arkaya koyarak döndürelim
  return $converted_barcode . $converted_user_id;
}
function remove_end_of_barcode($barcode = null)
{
    $length = get_user_number_length(); // Kaldırmak istediğiniz uzunluk
    if ($barcode !== null && strlen($barcode) > $length) {
        return substr($barcode, 0, -$length); // Barkodun sonundan belirli uzunluktaki kısmı kaldır
    } else {
        return $barcode; // Barkod uzunluğu yeterli değilse orijinal barkodu döndür
    }
}

function get_barcode_number_length()
{
    $barcode_number_length = 13;

    return $barcode_number_length;
}

function get_user_number_length()
{
    $user_number_length = 5;

    return $user_number_length;
}

function get_user_number_length_4()
{
    $user_number_length = 4;

    return $user_number_length;
}


if (! function_exists('KargoLogo')){

    function KargoLogo($kargo)
    {
        $img = '';
    
    
        if($kargo == "Yurtiçi"){
            $img = '<img src="'.base_url("images/kargo/yurtici.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
        if($kargo == "Aras"){
            $img = '<img src="'.base_url("images/kargo/aras.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
    
        if($kargo == "Carrtell"){
            $img = '<img src="'.base_url("images/kargo/cartel.jpg").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
    
        if($kargo == "Gittigidiyor Express"){
            $img = '<img src="'.base_url("images/kargo/gittigidiyor.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
        if($kargo == "Trendyol Express"){
            $img = '<img src="'.base_url("images/kargo/trendyol_express.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
        if($kargo == "Jetizz"){
            $img = '<img src="'.base_url("images/kargo/jetiz.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
        if($kargo == "Kargokar"){
            $img = '<img src="'.base_url("images/kargo/kargokar.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
    
        if($kargo == "MNG Kargo"){
            $img = '<img src="'.base_url("images/kargo/mng.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
    
        if($kargo == "Murathan JET"){
            $img = '<img src="'.base_url("images/kargo/murat.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
    
        if($kargo == "Sürat"){
            $img = '<img src="'.base_url("images/kargo/surat.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
    
        if($kargo == "hepsiJet"){
            $img = '<img src="'.base_url("images/kargo/hepsiJet.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
        if($kargo == "HepsiJet"){
            $img = '<img src="'.base_url("images/kargo/hepsiJet.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
        if($kargo == "hepsiJET"){
            $img = '<img src="'.base_url("images/kargo/hepsiJet.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
        if($kargo == "hepsiJET XL"){
            $img = '<img src="'.base_url("images/kargo/hepsiJET_XL.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
        if($kargo == "Sendeo"){
            $img = '<img src="'.base_url("images/kargo/sendeo.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
    
       if($kargo == "PTT Kargo" || $kargo == "PTT" ||  $kargo == "PTT Global" || $kargo == "PTT Kargo Marketplace"){
            $img = '<img src="'.base_url("uploads/ptt_kargo.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
        }
    
    
          return $img;
    
    }
    }


    if (! function_exists('KargoLogoCustom')){

        function KargoLogoCustom($kargo)
        {
            $img = '';
            if($kargo == "Sendeo"){
                $img = '<img src="'.base_url("images/kargo/sendeo.png").'" style="height: auto; width: auto; max-width: 120px;" alt="logo">';
            }
        
            if($kargo == "Yurtiçi"){
                $img = '<img src="'.base_url("images/kargo/yurtici.png").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
            if($kargo == "Aras"){
                $img = '<img src="'.base_url("images/kargo/aras.png").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
        
            if($kargo == "Carrtell"){
                $img = '<img src="'.base_url("images/kargo/cartel.jpg").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
        
            if($kargo == "Gittigidiyor Express"){
                $img = '<img src="'.base_url("images/kargo/gittigidiyor.png").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
            if($kargo == "Jetizz"){
                $img = '<img src="'.base_url("images/kargo/jetiz.png").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
            if($kargo == "Kargokar"){
                $img = '<img src="'.base_url("images/kargo/kargokar.png").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }

            if($kargo == "Trendyol Express"){
                $img = '<img src="'.base_url("images/kargo/trendyol_express.png").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
        
            if($kargo == "MNG Kargo"){
                $img = '<img src="'.base_url("images/kargo/mng.png").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
        
            if($kargo == "Murathan JET"){
                $img = '<img src="'.base_url("images/kargo/murat.png").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
        
            if($kargo == "Sürat"){
                $img = '<img src="'.base_url("images/kargo/surat.png").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
        
            if($kargo == "hepsiJet"){
                $img = '<img src="'.base_url("images/kargo/hepsiJet.png").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
            if($kargo == "HepsiJet"){
                $img = '<img src="'.base_url("images/kargo/hepsiJet.png").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
            if($kargo == "hepsiJET"){
                $img = '<img src="'.base_url("images/kargo/hepsiJet.png").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
            if($kargo == "hepsiJET XL"){
                $img = '<img src="'.base_url("images/kargo/hepsiJET_XL.png").'" style="height: auto; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
        
           if($kargo == "PTT Kargo" || $kargo == "PTT" ||  $kargo == "PTT Global" || $kargo == "PTT Kargo Marketplace"){
                $img = '<img src="'.base_url("uploads/ptt_kargo.png").'" style="height: 50px; width: auto; max-width: 80px; margin-left: 5px;" alt="logo">';
            }
        
        
              return $img;
        
        }
        }


    function get_image_url($image_path) {
        return isset($image_path) && file_exists(FCPATH . $image_path) ? base_url($image_path) : base_url('uploads/default.png');
    }

    