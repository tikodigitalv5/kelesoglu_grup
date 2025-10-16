# 🏭 Palet Stok Kontrol Algoritması

## 📋 Genel Bakış
Bu algoritma, bir palet satışı için gerekli stok kontrolünü yapar ve maksimum kaç koli oluşturulabileceğini hesaplar.

## 🏗️ Sistem Yapısı

### Hiyerarşi:
```
PALET (Ana Ürün)
├── KOLİ (Palet Reçetesi - category_id: 113)
│   ├── ÜRÜN 1 (Koli Reçetesi - category_id: 114)
│   ├── ÜRÜN 2 (Koli Reçetesi - category_id: 114)
│   └── ÜRÜN N (Koli Reçetesi - category_id: 114)
```

### Örnek Veri:
- **Palet**: "PALET 10 KOLİ" (ID: 85)
- **Koli**: "2025 Yılbaşı Sepeti" (ID: 82, category_id: 113)
- **Ürünler**: 40 farklı ürün (category_id: 114)

## 🔄 Algoritma Adımları

### 1. Palet Reçetesini Al
```php
$palet_recipe_items = $this->getRecipeItems($palet_id);
```
- Palet ID'sinden paletin reçetesini getir
- Kaç koli istediğini bul (`used_amount`)

### 2. Koli Reçetelerini Al
```php
foreach ($palet_recipe_items as &$koli_item) {
    if ($koli_item['category_id'] == 113) {
        $koli_item['koli_reçetesi'] = $this->getRecipeItems($koli_item['stock_id']);
    }
}
```
- Her koli için `category_id` = 113 kontrolü
- 113 ise koli'nin reçetesini getir

### 3. Stok Hesaplama
```php
// Her ürün için:
$gerekli_miktar = $palet_koli_sayisi * $koli_icindeki_urun_miktari;
$mevcut_stok = $this->getStockQuantity($urun_id);
$cikarilabilir = min($mevcut_stok, $gerekli_miktar);
```

### 4. Maksimum Koli Hesaplama
```php
$maksimum_koli = PHP_INT_MAX;
foreach ($urunler as $urun) {
    $koli_sayisi = floor($urun['mevcut_stok'] / $urun['koli_icindeki_miktar']);
    $maksimum_koli = min($maksimum_koli, $koli_sayisi);
}
```

## 📊 Örnek Hesaplama

### Veri:
- **Palet**: 40 koli istiyor
- **BURN ENERJİ İÇECEĞİ**: Mevcut stok 39 adet, koli içinde 1 adet
- **CAPPY LİMONATA**: Mevcut stok 45 adet, koli içinde 1 adet

### Hesaplama:
```
BURN ENERJİ İÇECEĞİ:
- Gerekli: 40 koli × 1 adet = 40 adet
- Mevcut: 39 adet
- Eksik: 1 adet
- Oluşturulabilir koli: 39 adet

CAPPY LİMONATA:
- Gerekli: 40 koli × 1 adet = 40 adet
- Mevcut: 45 adet
- Eksik: 0 adet
- Oluşturulabilir koli: 40 adet
```

### Sonuç:
- **Maksimum oluşturulabilir koli**: 39 adet (en düşük sınır)
- **Eksik ürün**: BURN ENERJİ İÇECEĞİ (1 adet eksik)
- **Çıkarılacak stok**: Her üründen 39 adet

## 📤 JSON Response Formatı

```json
{
    "icon": "success",
    "title": "Stok Analizi Tamamlandı",
    "text": "Palet stok kontrolü başarıyla yapıldı",
    "data": {
        "palet_bilgisi": {
            "stock_id": "85",
            "stock_title": "PALET 10 KOLİ",
            "istenen_koli": 40
        },
        "stok_analizi": {
            "maksimum_olusturulabilir_koli": 39,
            "durum": "KISMEN_YETERLI",
            "urun_detaylari": [
                {
                    "urun_id": "33",
                    "urun_adi": "BURN ENERJİ İÇECEĞİ 250 ML KUTU",
                    "gerekli_miktar": 40,
                    "mevcut_stok": 39,
                    "eksik_miktar": 1,
                    "durum": "EKSİK",
                    "olusturulabilir_koli": 39
                },
                {
                    "urun_id": "34",
                    "urun_adi": "CAPPY LİMONATA 1LT PET",
                    "gerekli_miktar": 40,
                    "mevcut_stok": 45,
                    "eksik_miktar": 0,
                    "durum": "YETERLI",
                    "olusturulabilir_koli": 40
                }
            ]
        },
        "cikarilacak_stok": {
            "toplam_koli": 39,
            "urun_listesi": [
                {
                    "urun_id": "33",
                    "urun_adi": "BURN ENERJİ İÇECEĞİ",
                    "cikarilacak_miktar": 39
                },
                {
                    "urun_id": "34", 
                    "urun_adi": "CAPPY LİMONATA",
                    "cikarilacak_miktar": 39
                }
            ]
        }
    }
}
```

## 🎯 Durum Kodları

- **YETERLI**: Tüm ürünler yeterli stokta
- **KISMEN_YETERLI**: Bazı ürünler eksik, kısmi üretim mümkün
- **YETERSIZ**: Hiç üretim yapılamaz

## 🔧 Kullanılan Fonksiyonlar

### `getRecipeItems($stock_id)`
- Belirtilen stok ID'sinin reçetesini getirir
- Tüm join'lerle birlikte detaylı bilgi döndürür

### `getStockQuantity($stock_id)`
- Stok ID'sinin mevcut miktarını hesaplar
- Parent-child ilişkilerini dikkate alır

## ⚠️ Önemli Notlar

1. **Kategori ID Kontrolü**: Sadece `category_id = 113` olan koli'lerin reçetesi alınır
2. **Maksimum Hesaplama**: En düşük stok sınırı belirleyicidir
3. **Stok Çıkarma**: Sadece oluşturulabilir koli sayısı kadar stok çıkarılır
4. **Hata Yönetimi**: Eksik stok durumunda detaylı bilgi verilir

## 🚀 Gelecek Geliştirmeler

- [ ] Stok rezervasyon sistemi
- [ ] Otomatik stok siparişi
- [ ] Stok uyarı sistemi
- [ ] Batch işlem desteği
