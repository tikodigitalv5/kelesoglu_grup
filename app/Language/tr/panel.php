<?php 

return array(
    
	
	"index_pagetitle"		=> "Sipariş Takip Paneli",
	"index_title"			=> "Sipariş Takip Paneli",
	"index_subtitle"		=> "",
	


	"musteri"				=> [

									"index"			=>[
										"pagetitle"		=> "Müşteriler",
										"title"			=> "Müşteriler",
										"subtitle"		=> "",
										"arama_text"	=> "Ünvan/Ad Soyad/ Vergi No / T.C.",
										"arama_icon"	=> "icon ni ni-user",
										"yeni_btn_text"	=> "Yeni Müsteri",

										"table_baslik1"	=> "Müşteri / E-posta",
										"table_baslik2"	=> "Firma Kodu",
										"table_baslik3"	=> "Tarih",
										"table_baslik4"	=> "Tel",
										"table_baslik5"	=> "Durum",
										"table_baslik6"	=> "",
									],	


									"yeni"			=>[
										"pagetitle"		=> "Yeni Müşteri Kayıt",
										"title"			=> "Yeni Müşteri Kayıt",
										"subtitle"		=> "",
										

										"label1"	=> "Firma Kodu",
										"label2"	=> "Müşteri Ünvanı",
										"label3"	=> "Yetkili Adı",
										"label4"	=> "Telefon",
										"label5"	=> "E-posta",
										"label6"	=> "Durum",


										"label_sub1"	=> "Müşteri Cpm Firma Kodu.",
										"label_sub2"	=> "Müşteri firma ünvanı adı.",
										"label_sub3"	=> "Firma yetkili adı.",
										"label_sub4"	=> "Firma veya yetkili telefonu.",
										"label_sub5"	=> "Firma veya yetkili e-postası.",
										"label_sub6"	=> "Sistemde yayınlamasına karar veriniz.",


										"label_placeholder1"	=> "120 16 20963",
										"label_placeholder2"	=> "Seraflex",
										"label_placeholder3"	=> "Ad Soyad",
										"label_placeholder4"	=> "0555 555 55 55",
										"label_placeholder5"	=> "Firmanın e-posta adresi",
										"label_placeholder6"	=> "",


									],	

									"detay"			=>[
										"pagetitle"		=> "Müşteri Detay",
										"title"			=> "Müşteri Detay",
										"subtitle"		=> "",
										

										"menu1"	=> "Siparişler",
										"menu2"	=> "Sipariş Oluştur",
										"menu3"	=> "Siparişler Ürün Bazlı",
										"menu4"	=> "Bilgileri Güncelle",
										"menu5"	=> "<span class=' text-danger'>Müşteri Sil</span>",
										"menu6"	=> "",


										"menu_icon1"	=> "icon ni ni-list-round",
										"menu_icon2"	=> "icon ni ni-plus-c",
										"menu_icon3"	=> "icon ni ni-package",
										"menu_icon4"	=> "icon ni ni-edit-alt",
										"menu_icon5"	=> "icon ni ni-trash text-danger",
										"menu_icon6"	=> "",


										
										"menu_route1"	=> "panel.musteri.detay",
										"menu_route2"	=> "panel.musteri.hareketler",
										"menu_route2"	=> "",
										"menu_route3"	=> "panel.musteri.urun_bazli",
										"menu_route4"	=> "panel.musteri.duzenle",
										"menu_route5"	=> "",
										"menu_route6"	=> "",

										"menu_active1"	=> "siparisler",
										"menu_active2"	=> "",
										"menu_active3"	=> "siparisler_urun",
										"menu_active4"	=> "bilgileri_guncelle",
										"menu_active5"	=> "",
										"menu_active6"	=> "",

									],	
									
									"menu"			=>[

										"baslik1"	=> "Sipariş",
										"baslik2"	=> "Teslim",
										"baslik3"	=> "Durum",
	
	
	
										"menu1"	=> "Sipariş Detay",
										"menu2"	=> "Müşteri Bilgileri",
										"menu3"	=> "Sevk Emri Ver",
										"menu4"	=> "Bilgileri Güncelle",
										"menu5"	=> "<span class=' text-danger'>Sipariş Sil</span>",
										"menu6"	=> "",
	
	
										"menu_icon1"	=> "icon ni ni-list-round",
										"menu_icon2"	=> "icon ni ni-user-c",
										"menu_icon3"	=> "icon ni ni-truck",
										"menu_icon4"	=> "icon ni ni-edit-alt",
										"menu_icon5"	=> "icon ni ni-trash text-danger",
										"menu_icon6"	=> "",
	
	
										"menu_route1"	=> "panel.musteri.detay",
										"menu_route2"	=> "panel.musteri.hareketler",
										"menu_route3"	=> "",
										"menu_route4"	=> "",
										"menu_route5"	=> "",
										"menu_route6"	=> "",
	
										"menu_active1"	=> "kalemler",
										"menu_active2"	=> "hareketler",
										"menu_active3"	=> "",
										"menu_active4"	=> "",
										"menu_active5"	=> "",
										"menu_active6"	=> "",
									],
									


	],


	"urun"				=> [


							"index"			=>[
								"pagetitle"		=> "Ürünler",
								"title"			=> "Ürünler",
								"subtitle"		=> "",
								"arama_text"	=> "Ürün Kodu / Ürün Adı",
								"arama_icon"	=> "icon ni ni-package",
								"yeni_btn_text"	=> "Yeni Ürün",

								"table_baslik1"	=> "Ürün Kodu",
								"table_baslik2"	=> "Ürün Bilgi",
								"table_baslik3"	=> "Kategori",
								"table_baslik4"	=> "Grup",
								"table_baslik5"	=> "Durum",
								"table_baslik6"	=> "",
							],	


							"yeni"			=>[
								"pagetitle"		=> "Yeni Ürün Kayıt",
								"title"			=> "Yeni Ürün Kayıt",
								"subtitle"		=> "",
								

								"label1"	=> "Ürün Adı",
								"label2"	=> "Ürün Kodu",
								"label3"	=> "Kategori",
								"label4"	=> "Grup",
								"label5"	=> "Birim",
								"label6"	=> "Durum",


								"label_sub1"	=> "Gözükecek ürün adı.",
								"label_sub2"	=> "Gözükecek ürün kodu.",
								"label_sub3"	=> "Ürünün ait olduğu kategori.",
								"label_sub4"	=> "Ürünün ait olduğu grup.",
								"label_sub5"	=> "Ürünün birimi.",
								"label_sub6"	=> "Sistemde yayınlamasına karar veriniz.",


								"label_placeholder1"	=> "TRAMBOLİN 500 (5 cm.)",
								"label_placeholder2"	=> "TRAMBOLIN500",
								"label_placeholder3"	=> "",
								"label_placeholder4"	=> "",
								"label_placeholder5"	=> "",
								"label_placeholder6"	=> "",


							],	

							"menu"			=>[
								"baslik1"	=> "Stok",
								"baslik2"	=> "Sipariş",
								"baslik3"	=> "Durum",

								"menu1"	=> "Siparişler",
								"menu2"	=> "Stok Hareketleri",
								"menu3"	=> "Üretim Ekle",
								"menu4"	=> "",
								"menu5"	=> "Bilgileri Güncelle",
								"menu6"	=> "<span class=' text-danger'>Ürün Sil</span>",


								"menu_icon1"	=> "icon ni ni-list-round",
								"menu_icon2"	=> "icon ni ni-list-thumb-fill",
								"menu_icon3"	=> "icon ni ni-plus-c",
								"menu_icon4"	=> "icon ni ni-printer",
								"menu_icon5"	=> "icon ni ni-edit-alt",
								"menu_icon6"	=> "icon ni ni-trash text-danger",


								"menu_route1"	=> "panel.urun.detay",
								"menu_route2"	=> "panel.urun.hareketler",
								"menu_route3"	=> "",
								"menu_route4"	=> "",
								"menu_route5"	=> "panel.urun.duzenle",
								"menu_route6"	=> "",

								"menu_active1"	=> "siparisler",
								"menu_active2"	=> "hareketler",
								"menu_active3"	=> "",
								"menu_active4"	=> "",
								"menu_active5"	=> "urun_guncelle",
								"menu_active6"	=> "",
							],

							"detay"			=>[
								"pagetitle"		=> "Ürün Detay",
								"title"			=> "Ürün Detay",
								"subtitle"		=> "",
								"baslik1"	=> "Stok",
								"baslik2"	=> "Sipariş",
								"baslik3"	=> "Durum",

								"menu1"	=> "Siparişler",
								"menu2"	=> "Stok Hareketleri",
								"menu3"	=> "Üretim Emri Ekle",
								"menu4"	=> "",
								"menu5"	=> "Bilgileri Güncelle",
								"menu6"	=> "<span class=' text-danger'>Ürün Sil</span>",


								"menu_icon1"	=> "icon ni ni-list-round",
								"menu_icon2"	=> "icon ni ni-list-thumb-fill",
								"menu_icon3"	=> "icon ni ni-repeat",
								"menu_icon4"	=> "icon ni ni-printer",
								"menu_icon5"	=> "icon ni ni-edit-alt",
								"menu_icon6"	=> "icon ni ni-trash text-danger",


								"menu_route1"	=> "panel.urun.detay",
								"menu_route2"	=> "panel.urun.hareketler",
								"menu_route3"	=> "panel.uretimler.yeni",
								"menu_route4"	=> "",
								"menu_route5"	=> "panel.urun.duzenle",
								"menu_route6"	=> "",

								"menu_active1"	=> "siparisler",
								"menu_active2"	=> "hareketler",
								"menu_active3"	=> "",
								"menu_active4"	=> "",
								"menu_active5"	=> "urun_guncelle",
								"menu_active6"	=> "",


								"label1"	=> "Ürün Adı",
								"label2"	=> "Ürün Kodu",
								"label3"	=> "Kategori",
								"label4"	=> "Grup",
								"label5"	=> "Birim",
								"label6"	=> "Durum",


								"label_sub1"	=> "Gözükecek ürün adı.",
								"label_sub2"	=> "Gözükecek ürün kodu.",
								"label_sub3"	=> "Ürünün ait olduğu kategori.",
								"label_sub4"	=> "Ürünün ait olduğu grup.",
								"label_sub5"	=> "Ürünün birimi.",
								"label_sub6"	=> "Sistemde yayınlamasına karar veriniz.",


								"label_placeholder1"	=> "TRAMBOLİN 500 (5 cm.)",
								"label_placeholder2"	=> "TRAMBOLIN500",
								"label_placeholder3"	=> "",
								"label_placeholder4"	=> "",
								"label_placeholder5"	=> "",
								"label_placeholder6"	=> "",


							],	

							"hareketler"			=>[
								"pagetitle"		=> "Ürün Stok Hareketleri",
								"title"			=> "Ürün Stok Hareketleri",
								"subtitle"		=> "",
								


							],	

					
		


	],


	"siparis"				=> [


								"index"			=>[
									"pagetitle"		=> "Siparişler",
									"title"			=> "Siparişler",
									"subtitle"		=> "",
									"arama_text"	=> "Sipariş Kodu / Müşteri Adı",
									"arama_icon"	=> "icon ni ni-list-round",
									"yeni_btn_text"	=> "Yeni Sipariş",

									"table_baslik1"	=> "Tarih",
									"table_baslik2"	=> "Sipariş No",
									"table_baslik3"	=> "Müşteri Bilgi",
									"table_baslik4"	=> "Miktar",
									"table_baslik5"	=> "Kalem",
									"table_baslik6"	=> "Durum",
									"table_baslik7"	=> "",
								],	


								"yeni"			=>[
									"pagetitle"		=> "Yeni Sipariş Kayıt",
									"title"			=> "Yeni Sipariş Kayıt",
									"subtitle"		=> "",
									

									"label1"	=> "Müşteri",
									"label2"	=> "Numune",
									"label3"	=> "Ürün",
									"label4"	=> "Miktar",
									"label5"	=> "Siparişler",
									"label6"	=> "Sipariş Notu",


									"label_sub1"	=> "Siparişi veren müşteriyi seçin.",
									"label_sub2"	=> "Sipariş numune içinse işaretleyiniz.",
									"label_sub3"	=> "Sipariş verilen ürünü seçin.",
									"label_sub4"	=> "Siparişteki ürün miktarı.",
									"label_sub5"	=> "Siparişe ait ürünler.",
									"label_sub6"	=> "Sipariş ile ilgili notunuz varsa yazınız.",


									"label_placeholder1"	=> "Müşteri Seçin, Listede Yoksa Ekleyebilirsiniz",
									"label_placeholder2"	=> "İşaretlenirse siparişte ürün başına 10 m. den fazla girilemez.",
									"label_placeholder3"	=> "Ürün Seçin, Listede Yoksa Ekleyebilirsiniz",
									"label_placeholder4"	=> "0,00",
									"label_placeholder5"	=> "",
									"label_placeholder6"	=> "",

									"table_baslik1"	=> "",
									"table_baslik2"	=> "Ürün Kodu",
									"table_baslik3"	=> "Ürün Adı",
									"table_baslik4"	=> "Miktar",
									"table_baslik5"	=> "",
									"table_baslik6"	=> "",
									"table_baslik7"	=> "",


									"table_baslik1_btn1"	=> "Müşteri Seç",
									"table_baslik1_btn2"	=> "Yeni Müşteri",


									"table_baslik2_btn1"	=> "Ürün Seç",
									"table_baslik2_btn2"	=> "Yeni Ürün",


									"arama_text2"	=> "Ünvan/Ad Soyad/ Vergi No / T.C.",
									"arama_icon2"	=> "icon ni ni-user",
									"yeni_btn_text1"	=> "Yeni Müsteri",

									"table_baslik11"	=> "Müşteri / E-posta",
									"table_baslik22"	=> "Firma Kodu",
									"table_baslik33"	=> "Tarih",
									"table_baslik44"	=> "Tel",
									"table_baslik55"	=> "Durum",
									"table_baslik66"	=> "",

									"label11"	=> "Firma Kodu",
									"label22"	=> "Müşteri Ünvanı",
									"label33"	=> "Yetkili Adı",
									"label44"	=> "Telefon",
									"label55"	=> "E-posta",
									"label66"	=> "Durum",


									"label_sub11"	=> "Müşteri Cpm Firma Kodu.",
									"label_sub22"	=> "Müşteri firma ünvanı adı.",
									"label_sub33"	=> "Firma yetkili adı.",
									"label_sub44"	=> "Firma veya yetkili telefonu.",
									"label_sub55"	=> "Firma veya yetkili e-postası.",
									"label_sub66"	=> "Sistemde yayınlamasına karar veriniz.",


									"label_placeholder11"	=> "120 16 20963",
									"label_placeholder22"	=> "Seraflex",
									"label_placeholder33"	=> "Ad Soyad",
									"label_placeholder44"	=> "0555 555 55 55",
									"label_placeholder55"	=> "Firmanın e-posta adresi",
									"label_placeholder66"	=> "",


									"label111"	=> "Ürün Adı",
									"label222"	=> "Ürün Kodu",
									"label333"	=> "Kategori",
									"label444"	=> "Grup",
									"label555"	=> "Birim",
									"label666"	=> "Durum",


									"label_sub111"	=> "Gözükecek ürün adı.",
									"label_sub222"	=> "Gözükecek ürün kodu.",
									"label_sub333"	=> "Ürünün ait olduğu kategori.",
									"label_sub444"	=> "Ürünün ait olduğu grup.",
									"label_sub555"	=> "Ürünün birimi.",
									"label_sub666"	=> "Sistemde yayınlamasına karar veriniz.",


									"label_placeholder111"	=> "TRAMBOLİN 500 (5 cm.)",
									"label_placeholder222"	=> "TRAMBOLIN500",
									"label_placeholder333"	=> "",
									"label_placeholder444"	=> "",
									"label_placeholder555"	=> "",
									"label_placeholder666"	=> "",

									"arama_text3"	=> "Ürün Kodu / Ürün Adı",
								"arama_icon3"	=> "icon ni ni-package",

								],	

								"menu"			=>[

									"baslik1"	=> "Sipariş",
									"baslik2"	=> "Teslim",
									"baslik3"	=> "Durum",



									"menu1"	=> "Sipariş Detay",
									"menu2"	=> "Müşteri Bilgileri",
									"menu3"	=> "Sevk Emri Ver",
									"menu4"	=> "Bilgileri Güncelle",
									"menu5"	=> "<span class=' text-danger'>Sipariş Sil</span>",
									"menu6"	=> "",


									"menu_icon1"	=> "icon ni ni-list-round",
									"menu_icon2"	=> "icon ni ni-user-c",
									"menu_icon3"	=> "icon ni ni-truck",
									"menu_icon4"	=> "icon ni ni-edit-alt",
									"menu_icon5"	=> "icon ni ni-trash text-danger",
									"menu_icon6"	=> "",


									"menu_route1"	=> "panel.siparis.detay",
									"menu_route2"	=> "panel.musteri.detay",
									"menu_route3"	=> "panel.sevkiyat.yeni_id",
									"menu_route4"	=> "",
									"menu_route5"	=> "",
									"menu_route6"	=> "",

									"menu_active1"	=> "kalemler",
									"menu_active2"	=> "hareketler",
									"menu_active3"	=> "",
									"menu_active4"	=> "",
									"menu_active5"	=> "",
									"menu_active6"	=> "",
								],

								"detay"			=>[
									"pagetitle"		=> "Sipariş Detay",
									"title"			=> "Sipariş Detay",
									"subtitle"		=> "",
									


								],	

								"hareketler"			=>[
									"pagetitle"		=> "Sipariş Stok Hareketleri",
									"title"			=> "Sipariş Stok Hareketleri",
									"subtitle"		=> "",
									


								],	



	],


	"depostok"				=> [


								"index"			=>[
									"pagetitle"		=> "Depo Stok",
									"title"			=> "Depo Stok",
									"subtitle"		=> "",
									"arama_text"	=> "Sipariş Kodu / Müşteri Adı",
									"arama_icon"	=> "icon ni ni-list-round",
									// "yeni_btn_text"	=> "Yeni Sipariş",

									"table_baslik1"	=> "Ürün Kodu",
									"table_baslik2"	=> "Ürün Bilgi",
									"table_baslik3"	=> "Stok",
									"table_baslik4"	=> "Sipariş",
									"table_baslik5"	=> "Durum",
									"table_baslik6"	=> "",
									"table_baslik7"	=> "",


									"table_baslik_btn1"	=> "Ambalaj Barkod",
									"table_route_btn1"	=> "ambalajbarkod",
									"table_baslik_btn2"	=> "Barkodsuzlar",
									"table_route_btn2"	=> "barkodsuzlar",
								],	


								"ambalajbarkod"			=>[
									"pagetitle"		=> "Yeni Ambalaj Barkod",
									"title"			=> "Yeni Ambalaj Barkod",
									"subtitle"		=> "",
									

									"label1"	=> "Ürün",
									"label2"	=> "Miktar",
									"label3"	=> "Ambalajdakiler",
									"label4"	=> "Ambalaj Notu",
									"label5"	=> "",
									"label6"	=> "",


									"label_sub1"	=> "Ambalaj yapılacak ürünü seçin.",
									"label_sub2"	=> "Ambalaja eklenecek ürün miktarı.",
									"label_sub3"	=> "Ambalaj için eklediğiniz ürünler.",
									"label_sub4"	=> "Ambalaj ile ilgili notunuz varsa yazınız.",
									"label_sub5"	=> "",
									"label_sub6"	=> "",


									"label_placeholder1"	=> "Ürün Seçin, Listede Yoksa Ekleyebilirsiniz",
									"label_placeholder2"	=> "0,00",
									"label_placeholder3"	=> "",
									"label_placeholder4"	=> "",
									"label_placeholder5"	=> "",
									"label_placeholder6"	=> "",

									"table_baslik1"	=> "",
									"table_baslik2"	=> "Ürün Kodu",
									"table_baslik3"	=> "Ürün Adı",
									"table_baslik4"	=> "Birim",
									"table_baslik5"	=> "Adet",
									"table_baslik6"	=> "Miktar",
									"table_baslik7"	=> "",


									"table_baslik1_btn1"	=> "Ürün Seç",

								],		



	],


	"ayarlar"				=> [


		"index"			=>[
				"pagetitle"		=> "Kategoriler",
				"title"			=> "Kategoriler",
				"subtitle"		=> "",
				"arama_text"	=> "Kategori Adı",
				"arama_icon"	=> "icon ni ni-opt-dot-alt",
				"yeni_btn_text"	=> "Yeni Kategori",

				"table_baslik1"	=> "Kategori Adı",
				"table_baslik2"	=> "Durum",
				"table_baslik3"	=> "",
		],	

	

		"kategoriler"			=>[
			"pagetitle"		=> "Kategoriler",
			"title"			=> "Ürün Kategorileri",
			"subtitle"		=> "",
			'label1'        => "Kategori Adı",
			'label_sub1'   => "Gözükecek kategori adı",
			'label_placeholder1' => "Kategori Adı Girin",
			'label2'    => "Kategori Durumu",
			'label_sub2' => "Kategori Durumunu Düzenleyin",
		
			


		],

		"gruplar"			=>[

				"pagetitle"		=> "Gruplar",
				"title"			=> "Ürün Grupları",
				"subtitle"		=> "",
				"arama_text"	=> "Grup Adı",
				"arama_icon"	=> "icon ni ni-opt-dot-alt",
				"yeni_btn_text"	=> "Yeni Grup",

				"table_baslik1"	=> "Grup Adı",
				"table_baslik2"	=> "Durum",
				"table_baslik3"	=> "",
				'label1'        => "Grup Adı",
				'label_sub1'   => "Gözükecek grup adı",
				'label_placeholder1' => "Grup Adı Girin",
				'label2'    => "Grup Durumu",
				'label_sub2' => "Grup Durumunu Düzenleyin",

		],


		"seriler"			=>[

			"pagetitle"		=> "Seriler",
			"title"			=> "Ürün Serileri",
			"subtitle"		=> "",
			"arama_text"	=> "Seri Adı",
			"arama_icon"	=> "icon ni ni-opt-dot-alt",
			"yeni_btn_text"	=> "Yeni Seri",

			"table_baslik1"	=> "Seri Adı",
			"table_baslik2"	=> "Durum",
			"table_baslik3"	=> "",
			'label1'        => "Seri Adı",
			'label_sub1'   => "Gözükecek seri adı",
			'label_placeholder1' => "Seri Adı Girin",
			'label2'    => "Seri Durumu",
			'label_sub2' => "Seri Durumunu Düzenleyin",

	],
		"birimler"			=>[
			"pagetitle"		=> "Birimler",
			"title"			=> "Ürün Birimleri",
			"subtitle"		=> "",
			"arama_text"	=> "Birim Adı",
			"arama_icon"	=> "icon ni ni-opt-dot-alt",
			"yeni_btn_text"	=> "Yeni Birim",

			"table_baslik1"	=> "Birim Adı",
			"table_baslik2"	=> "Durum",
			"table_baslik3"	=> "Birim Kodu",
			'label1'        => "Birim Adı",
			'label_sub1'   => "Gözükecek birim adı",
			'label_placeholder1' => "Birim Adı  Girin",
			'label2'    => "Birim Durumu",
			'label_sub2' => "Birim Durumunu Düzenleyin",

			'label3'        => "Birim Kodu",
			'label_sub3'   => "Gözükecek birim kodu ",
			'label_placeholder3' => "Birim Kodu Girin",
			


		],



],


	"sevkiyat"				=> [


		"index"			=>[
			"pagetitle"		=> "Sevkiyatlar",
			"title"			=> "Sevkiyatlar",
			"subtitle"		=> "",
			"arama_text"	=> "Sipariş Kodu / Müşteri Adı",
			"arama_icon"	=> "icon ni ni-list-round",
			"yeni_btn_text"	=> "Yeni Sevk Emri",

			"table_baslik1"	=> "Tarih",
			"table_baslik2"	=> "Sevkiyat No",
			"table_baslik3"	=> "Müşteri Bilgi",
			"table_baslik4"	=> "Miktar",
			"table_baslik5"	=> "Kalem",
			"table_baslik6"	=> "Durum",
			"table_baslik7"	=> "",
		],	


		"yeni"			=>[
			"pagetitle"		=> "Yeni Sevkiyat Emri",
			"title"			=> "Yeni Sevkiyat Emri",
			"subtitle"		=> "",
			

			"label1"	=> "Moşteri",
			"label2"	=> "Siparişler",
			"label3"	=> "",
			"label4"	=> "",
			"label5"	=> "",
			"label6"	=> " Notu",


			"label_sub1"	=> "Siparişi veren müşteriyi seçin.",
			"label_sub2"	=> "Müşteriye ait sipariş kalemleri.",
			"label_sub3"	=> "",
			"label_sub4"	=> "",
			"label_sub5"	=> ".",
			"label_sub6"	=> "",


			"label_placeholder1"	=> "Müşteri Seçin",
			"label_placeholder2"	=> "0,00",
			"label_placeholder3"	=> "",
			"label_placeholder4"	=> "",
			"label_placeholder5"	=> "",
			"label_placeholder6"	=> "",

			"table_baslik1"	=> "Ürün Kodu",
			"table_baslik2"	=> "Ürün Adı",
			"table_baslik3"	=> "Miktar",
			"table_baslik4"	=> "Kalan",
			"table_baslik5"	=> "Sevk",
			"table_baslik6"	=> "Toplam",


			"table_baslik1_btn1"	=> "Müşteri Seç",
			"table_baslik1_btn2"	=> "Yeni Müşteri",



		],	



		"detay"			=>[
			"pagetitle"		=> "Sevkiyat",
			"title"			=> "Sevkiyat",
			"subtitle"		=> "",
			

			"label1"	=> "Müşteri",
			"label2"	=> "Ürün",
			"label3"	=> "Siparişler",
			"label4"	=> "Sevk",
			"label5"	=> "",
			"label6"	=> "",


			"label_sub1"	=> "Siparişi veren müşteriyi seçin.",
			"label_sub2"	=> "Sevk etmek istediğiniz barkodu okutunuz.",
			"label_sub3"	=> "",
			"label_sub4"	=> "",
			"label_sub5"	=> ".",
			"label_sub6"	=> "",


			"label_placeholder1"	=> "Müşteri Seçin",
			"label_placeholder2"	=> "Sevk etmek istediğiniz barkodu okutunuz.",
			"label_placeholder3"	=> "",
			"label_placeholder4"	=> "",
			"label_placeholder5"	=> "",
			"label_placeholder6"	=> "",

			"table_baslik1"	=> "Ürün Kodu",
			"table_baslik2"	=> "Ürün Adı",
			"table_baslik3"	=> "Miktar",
			"table_baslik4"	=> "Kalan",
			"table_baslik5"	=> "Sevk",
			"table_baslik6"	=> "Toplam",


			"table_baslik1_btn1"	=> "Müşteri Seç",
			// "table_baslik1_btn2"	=> "Yeni Müşteri",

		],	

		"hareketler"			=>[
			"pagetitle"		=> "Sipariş Stok Hareketleri",
			"title"			=> "Sipariş Stok Hareketleri",
			"subtitle"		=> "",
			


		],	



],








"uretimler"				=> [


	"index"			=>[
		"pagetitle"		=> "Üretimler",
		"title"			=> "Üretimler",
		"subtitle"		=> "",
		"arama_text"	=> " Ürün Adı",
		"arama_icon"	=> "icon ni ni-repeat",
		"yeni_btn_text"	=> "Yeni Üretim Emri",

		"table_baslik1"	=> "Tarih",
		"table_baslik2"	=> "Üretim No",
		"table_baslik3"	=> "Ürün Bilgi",
		"table_baslik4"	=> "Miktar",
		"table_baslik5"	=> "Kalem",
		"table_baslik6"	=> "Durum",
		"table_baslik7"	=> "",
	],	

	"menu"			=>[
		"baslik1"	=> "Stok",
		"baslik2"	=> "Sipariş",
		"baslik3"	=> "Durum",

		"menu1"	=> "Siparişler",
		"menu2"	=> "Stok Hareketleri",
		"menu3"	=> "Ürün Bilgileri",
		"menu4"	=> "Barkod Yazdır",
		"menu5"	=> "Bilgileri Güncelle",
		"menu6"	=> "<span class=' text-danger'>Ürün Sil</span>",


		"menu_icon1"	=> "icon ni ni-list-round",
		"menu_icon2"	=> "icon ni ni-list-thumb-fill",
		"menu_icon3"	=> "icon ni ni-package",
		"menu_icon4"	=> "icon ni ni-printer",
		"menu_icon5"	=> "icon ni ni-edit-alt",
		"menu_icon6"	=> "icon ni ni-trash text-danger",


		"menu_route1"	=> "panel.urun.detay",
		"menu_route2"	=> "panel.urun.hareketler",
		"menu_route3"	=> "panel.urun.detay",
		"menu_route4"	=> "panel.uretim.barkod",
		"menu_route5"	=> "panel.urun.duzenle",
		"menu_route6"	=> "",

		"menu_active1"	=> "siparisler",
		"menu_active2"	=> "hareketler",
		"menu_active3"	=> "",
		"menu_active4"	=> "",
		"menu_active5"	=> "urun_guncelle",
		"menu_active6"	=> "",
	],



	"yeni"			=>[
		"pagetitle"		=> "Yeni Üretim Emri",
		"title"			=> "Yeni Üretim Emri",
		"subtitle"		=> "",
		

		"label1"	=> "Müşteri",
		"label2"	=> "Numune",
		"label3"	=> "Ürün",
		"label4"	=> "Miktar",
		"label5"	=> "Üretimler",
		"label6"	=> "Üretim Notu",


		"label_sub1"	=> "Siparişi veren müşteriyi seçin.",
		"label_sub2"	=> "Sipariş numune içinse işaretleyiniz.",
		"label_sub3"	=> "Sipariş verilen ürünü seçin.",
		"label_sub4"	=> "Üretimdeki ürün miktarı.",
		"label_sub5"	=> "Üretilen  ürünler.",
		"label_sub6"	=> "Üretim ile ilgili notunuz varsa yazınız.",


		"label_placeholder1"	=> "Müşteri Seçin, Listede Yoksa Ekleyebilirsiniz",
		"label_placeholder2"	=> "İşaretlenirse siparişte ürün başına 10 m. den fazla girilemez.",
		"label_placeholder3"	=> "Ürün Seçin, Listede Yoksa Ekleyebilirsiniz",
		"label_placeholder4"	=> "0,00",
		"label_placeholder5"	=> "",
		"label_placeholder6"	=> "",

		"table_baslik1"	=> "",
		"table_baslik2"	=> "Ürün Kodu",
		"table_baslik3"	=> "Ürün Adı",
		"table_baslik4"	=> "Miktar",
		"table_baslik5"	=> "",
		"table_baslik6"	=> "",
		"table_baslik7"	=> "",


		"table_baslik1_btn1"	=> "Müşteri Seç",
		"table_baslik1_btn2"	=> "Yeni Müşteri",


		"table_baslik2_btn1"	=> "Ürün Seç",
		"table_baslik2_btn2"	=> "Yeni Ürün",


		"arama_text2"	=> "Ünvan/Ad Soyad/ Vergi No / T.C.",
		"arama_icon2"	=> "icon ni ni-user",
		"yeni_btn_text1"	=> "Yeni Müsteri",

		"table_baslik11"	=> "Müşteri / E-posta",
		"table_baslik22"	=> "Firma Kodu",
		"table_baslik33"	=> "Tarih",
		"table_baslik44"	=> "Tel",
		"table_baslik55"	=> "Durum",
		"table_baslik66"	=> "",

		"label11"	=> "Firma Kodu",
		"label22"	=> "Müşteri Ünvanı",
		"label33"	=> "Yetkili Adı",
		"label44"	=> "Telefon",
		"label55"	=> "E-posta",
		"label66"	=> "Durum",


		"label_sub11"	=> "Müşteri Cpm Firma Kodu.",
		"label_sub22"	=> "Müşteri firma ünvanı adı.",
		"label_sub33"	=> "Firma yetkili adı.",
		"label_sub44"	=> "Firma veya yetkili telefonu.",
		"label_sub55"	=> "Firma veya yetkili e-postası.",
		"label_sub66"	=> "Sistemde yayınlamasına karar veriniz.",


		"label_placeholder11"	=> "120 16 20963",
		"label_placeholder22"	=> "Seraflex",
		"label_placeholder33"	=> "Ad Soyad",
		"label_placeholder44"	=> "0555 555 55 55",
		"label_placeholder55"	=> "Firmanın e-posta adresi",
		"label_placeholder66"	=> "",


		"label111"	=> "Ürün Adı",
		"label222"	=> "Ürün Kodu",
		"label333"	=> "Kategori",
		"label444"	=> "Grup",
		"label555"	=> "Birim",
		"label666"	=> "Durum",


		"label_sub111"	=> "Gözükecek ürün adı.",
		"label_sub222"	=> "Gözükecek ürün kodu.",
		"label_sub333"	=> "Ürünün ait olduğu kategori.",
		"label_sub444"	=> "Ürünün ait olduğu grup.",
		"label_sub555"	=> "Ürünün birimi.",
		"label_sub666"	=> "Sistemde yayınlamasına karar veriniz.",


		"label_placeholder111"	=> "TRAMBOLİN 500 (5 cm.)",
		"label_placeholder222"	=> "TRAMBOLIN500",
		"label_placeholder333"	=> "",
		"label_placeholder444"	=> "",
		"label_placeholder555"	=> "",
		"label_placeholder666"	=> "",

		"arama_text3"	=> "Ürün Kodu / Ürün Adı",
	"arama_icon3"	=> "icon ni ni-package",



	],	



	"detay"			=>[
		"pagetitle"		=> "Üretim",
		"title"			=> "Üretim",
		"subtitle"		=> "",
		"baslik1"	=> "Stok",
		"baslik2"	=> "Sipariş",
		"baslik3"	=> "Durum",

		"menu1"	=> "Siparişler",
		"menu2"	=> "Stok Hareketleri",
		"menu3"	=> "Stok Ekle",
		"menu4"	=> "Barkod Yazdır",
		"menu5"	=> "Bilgileri Güncelle",
		"menu6"	=> "<span class=' text-danger'>Ürün Sil</span>",


		"menu_icon1"	=> "icon ni ni-list-round",
		"menu_icon2"	=> "icon ni ni-list-thumb-fill",
		"menu_icon3"	=> "icon ni ni-plus-c",
		"menu_icon4"	=> "icon ni ni-printer",
		"menu_icon5"	=> "icon ni ni-edit-alt",
		"menu_icon6"	=> "icon ni ni-trash text-danger",


		"menu_route1"	=> "panel.urun.detay",
		"menu_route2"	=> "panel.urun.hareketler",
		"menu_route3"	=> "",
		"menu_route4"	=> "",
		"menu_route5"	=> "panel.urun.duzenle",
		"menu_route6"	=> "",

		"menu_active1"	=> "siparisler",
		"menu_active2"	=> "hareketler",
		"menu_active3"	=> "",
		"menu_active4"	=> "",
		"menu_active5"	=> "urun_guncelle",
		"menu_active6"	=> "",


		"label1"	=> "Ürün Adı",
		"label11"	=> "Üretilebilir Miktar",
		"label2"	=> "Ürün Kodu",
		"label22"	=> "Miktar",
		"label3"	=> "Kategori",
		"label4"	=> "Grup",
		"label5"	=> "Birim",
		"label6"	=> "Durum",


		"label_sub11"	=> "Üretilebilir ürün miktarı",
		"label_sub1"	=> "Gözükecek ürün adı.",
		"label_sub2"	=> "Gözükecek ürün kodu.",
		"label_sub22"	=> "Üretilecek ürün miktarı.",
		"label_sub3"	=> "Ürünün ait olduğu kategori.",
		"label_sub4"	=> "Ürünün ait olduğu grup.",
		"label_sub5"	=> "Ürünün birimi.",
		"label_sub6"	=> "Sistemde yayınlamasına karar veriniz.",


		"label_placeholder1"	=> "TRAMBOLİN 500 (5 cm.)",
		"label_placeholder2"	=> "TRAMBOLIN500",
		"label_placeholder22"	=> "300",
		"label_placeholder3"	=> "",
		"label_placeholder4"	=> "",
		"label_placeholder5"	=> "",
		"label_placeholder6"	=> "",


	],	




],



);

?>