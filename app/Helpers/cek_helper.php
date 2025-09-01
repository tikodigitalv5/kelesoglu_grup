<?php

if (!function_exists('getDurumClass')) {
    function getDurumClass($durum) {
        $classes = [
            'BEKLEMEDE' => 'warning',
            'TAHSIL' => 'success',
            'CIRO' => 'info',
            'IADE' => 'danger',
            'IPTAL' => 'danger',
            'ODENDI' => 'success',
            'KARSILIGI_YOK' => 'danger'
        ];

        return $classes[$durum] ?? 'secondary';
    }
}

if (!function_exists('getDurumText')) {
    function getDurumText($durum) {
        $texts = [
            'BEKLEMEDE' => 'PORTFÖY', // İLK
            'TAHSIL' => 'Tahsil Edildi', // virman
            'CIRO' => 'Ciro Edildi', // BİRİNE CİRO 
            'IADE' => 'İade Edildi', // İADE 
            'IPTAL' => 'İptal Edildi',
            'ODENDI' => 'Ödendi', // 
            'KARSILIGI_YOK' => 'Karşılığı Yok'
        ];

        return $texts[$durum] ?? $durum;
    }
}

