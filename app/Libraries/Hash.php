<?php 
namespace App\Libraries;

class Hash {

    
    public static function make($password){
        $encrypter = \Config\Services::encrypter();
        $ciphertext = bin2hex($encrypter->encrypt($password));;
        return $ciphertext;
    }

    public static function check($entered_password, $db_password){
        $encrypter = \Config\Services::encrypter();

        $decryptedtext = $encrypter->decrypt(hex2bin($db_password));
        if($entered_password == $decryptedtext){
            return true;
        } else {
            return false;
        }
    }
    public static function decrypt($entered_password)
    {
        $encrypter = \Config\Services::encrypter();

        $decryptedtext = $encrypter->decrypt(hex2bin($entered_password));
        return $decryptedtext;
    }
}

?>