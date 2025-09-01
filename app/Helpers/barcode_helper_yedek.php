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
                .brdr{
                    border: 1px solid #000;
                }
                .alt-brdr{
                    border-bottom: 1px solid #000;
                    padding-top: 5px;
                    padding-bottom: 5px;
                }
                .sag-brdr{
                    border-right: 1px solid #000;
                }
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
            <body><center><br><br><br>';

    if ($supplier != 0) {
        $barkodHtml = ' <tr class="" style="height:60px;">
                <td class="sag-brdr sola-text alt-brdr" style="height:60px;">
                    <b> TEDARİKÇİ KODU</b>
                </td>
                <td class="col-md-8 sola-text alt-brdr" style="height:60px;">
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
    $html .= '<table style="width: 380px;height: 390px;font-size: 20;  margin-bottom:30px;   text-align: center; page-break-after:always;" class="brdr">
        <tbody>
            <tr>
                <td class=" alt-brdr" style="height:30px;">
                    <!-- <b> DANSİTE</b><br> -->
                    <b style="font-size: 26px;">' . session()->get('user_item')['firma_adi'] . '</b>
                </td>
            </tr>
            <tr>
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
                                    <b id="adetx">' . $barcode_data['total_amount'] . '' . $stock_item['unit_title'] . '</b>
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
