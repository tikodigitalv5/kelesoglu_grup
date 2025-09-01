<?php

namespace App\Models;

use CodeIgniter\Model;

class SendModel extends Model
{


    private $email_adresi = "tiko@tiko.com.tr";
    private $email_sifre = "02ZC2yTKbN";
    private $accountid = "81515";

    private $email_token = "";

    private $accountProfil = "";

    public function getTokens()
    {
      
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://diyaccountapi.relateddigital.com/tokens',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "email": "'.$this->email_adresi.'",
        "password": "'.$this->email_sifre.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl); // cURL hatalarını kontrol et
        curl_close($curl);
    
        if ($err) {
            return null; // Hata oluşursa null döndür
        } else {
            $responseData = json_decode($response, true); // JSON'u PHP dizisine çeviriyoruz
            
            if (json_last_error() === JSON_ERROR_NONE) {
                return $responseData; // Başarılıysa token verisini döndür
            } else {
                return null; // JSON decode hatası varsa null döndür
            }
        }
    }
    public function mail_gonder($data)
    {
        // Önce token alalım
        $token = $this->getTokens();
    
        // Eğer token yoksa, işlemi durdurmak için return kullan
        if (empty($token) || $token == "") {
            return "Token alınamadı"; 
        }
        
        if (!isset($token["accountId"])) {
            return "Geçersiz hesap ID";
        }
    
        // cURL isteğini başlatalım
        $curl = curl_init();
    
        // Post data, JSON formatında oluşturuluyor
        $postData = json_encode([
            'senderProfileId' => $this->accountid,
            'receiverEmailAddress' => $data['email'],
            'subject' => $data['subject'],
            'content' => $data['render_html'],
            'startDate' => '',
            'finishDate' => ''
        ]);
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://diyaccountapi.relateddigital.com/accounts/' . $token["accountId"] . '/transactional-email',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData, // JSON verisini gönderiyoruz
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token['tokenValue'], // Token'ı Authorization header'a ekliyoruz
            ),
        ));
    
        $response = curl_exec($curl);
    
        // Eğer cURL bir hata döndürürse, hata mesajını döndür
        if (curl_errno($curl)) {
            $errorMessage = 'Curl error: ' . curl_error($curl);
            curl_close($curl);
            return $errorMessage;
        }
    
        // Yanıtı JSON olarak çözümleyin ve başarılı olup olmadığını kontrol edin
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
        // cURL işlemini kapatıyoruz
        curl_close($curl);
    
        if ($httpCode === 200) {
            return "ok"; // Başarılı ise "ok" döndür
        } else {
            return "Email gönderimi başarısız. HTTP Kodu: " . $httpCode;
        }
    }
    


}