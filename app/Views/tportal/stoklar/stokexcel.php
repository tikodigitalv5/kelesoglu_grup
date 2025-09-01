<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Stoklarınızı Excel'den Aktarın | <?= $this->endSection() ?>
<?= $this->section('title') ?> Stoklarınızı Excel'den Aktarın | <?= session()->get('user_item')['firma_adi'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>

<style>
    #barcode {
        margin-bottom:20px;
        margin-top:10px;
    }
    #barcode .inputBox {
        position: relative;
    }
    #barcode .inputBox input {
        width: 100%;
        border-radius: 10px;
        background-color:#e5ecf9;
        border:solid 1px rgba(0,0,0,0.1);
        padding:25px;
        font-size:22px;
        text-align: center;
    }
    #barcode .inputBox em {
        position: absolute;
        left:25px;
        top:35px;
        font-size:36px;
        opacity: .6;
        z-index: 2;
    }

    @-webkit-keyframes AnimationName {
        0%{background-position:0% 50%}
        50%{background-position:100% 50%}
        100%{background-position:0% 50%}
    }
    @-moz-keyframes AnimationName {
        0%{background-position:0% 50%}
        50%{background-position:100% 50%}
        100%{background-position:0% 50%}
    }
    @keyframes AnimationName {
        0%{background-position:0% 50%}
        50%{background-position:100% 50%}
        100%{background-position:0% 50%}
    }
    .custom-control-pro.custom-control-sm .custom-control-label::before, .custom-control-pro.custom-control-sm .custom-control-label::after{
        top: 57%;
        background-color: #014ad0;
        border-color: #014ad0;
        color: white;
        display: inline-flex;
    align-items: center;
    justify-content: center;
    background-image: none !important;
    font-family: "Nioicon";
    color: #fff;
    opacity: 0;
    }

    .checkbox-readonly {
    pointer-events: none;  /* Disable click events */
    cursor: default;       /* Show default cursor */
}
.ana-urun {
    background-color: #f8f9fa;
    font-weight: bold;
}

.alt-urun {
    background-color: #ffffff;
    color: #666;
}
</style>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Stok Say</h3>
                        <!-- <div class="nk-block-des text-soft">
                          <p>You have total 2,595 users.</p>
                      </div> -->
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                                    class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li><a href="#" class="btn btn-white btn-outline-light"><em
                                                class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                    <li class="nk-block-tools-opt">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary"
                                                data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>Add User</span></a></li>
                                                    <li><a href="#"><span>Add Team</span></a></li>
                                                    <li><a href="#"><span>Import User</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .toggle-wrap -->
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->


            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
            <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active"  href="<?php echo route_to("tportal.stocks.depo_stoklari_say") ?>">
      <em class="icon ni ni-layers"></em>
      <span>STOK İÇE AKTAR</span>
    </a>
  </li>

</ul>

<!-- Excel Upload Form -->
<div class="mt-4">
    <div class="card">
        <div class="card-inner">
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-lg-12">
                        <div class="card-head">
                            <h5 class="card-title">Excel Dosyası Yükle</h5>
                        </div>
                        <form action="<?php echo route_to('tportal.stocks.ozel_func_excel_import') ?>" method="post" enctype="multipart/form-data" class="form-validate">
                            <div class="row g-gs">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Excel Dosyası Seçin</label>
                                        <div class="form-control-wrap">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="excelFile" name="excelFile" accept=".xlsx, .xls" required>
                                                <label class="custom-file-label" for="excelFile">Dosya Seçin</label>
                                            </div>
                                        </div>
                                        <div class="form-note">Sadece .xlsx ve .xls formatları desteklenir</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <em class="icon ni ni-upload-cloud"></em>
                                            <span>Excel Dosyasını Yükle</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        <!-- Örnek Excel Şablonu -->
                        <div class="mt-4">
                            <h6>Excel Şablon Örneği:</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Stok Kodu</th>
                                        <th>Ürün Adı</th>
                                        <th>Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($urunler as $urunGrup): ?>
    <!-- Ana Ürün -->
    <tr class="ana-urun">
        <td><?php echo $urunGrup['ana_urun']['stok_kodu']; ?></td>
        <td><?php echo $urunGrup['ana_urun']['urun_adi']; ?></td>
        <td>Ana Ürün</td>
    </tr>
    
    <!-- Alt Ürünler -->
    <?php foreach ($urunGrup['alt_urunler'] as $altUrun): ?>
    <tr class="alt-urun">
        <td style="padding-left: 20px">└─ <?php echo $altUrun['stok_kodu']; ?></td>
        <td><?php echo $altUrun['urun_adi']; ?></td>
        <td>Alt Ürün</td>
    </tr>
    <?php endforeach; ?>
<?php endforeach; ?>
                                   
                                </tbody>
                            </table>
                            <div class="form-note text-muted mt-2">
                                * Excel dosyanız yukarıdaki formatta olmalıdır.<br>
                                * Stok kodları benzersiz olmalıdır.<br>
                                * Durum sütunu "Ana Ürün" veya "Alt Ürün" değerlerini içermelidir.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Excel Upload Form -->

</div>
</div>
</div>
</div>

          
     



        <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">

                        <div class="card-inner row g-gs" style="padding-bottom:0!important;">
                      
<div id="html_baslik" style="margin-top: 20px; margin-bottom: 10px; padding-bottom: 5px;"></div>

  <div class="custom-control-group  row w-100" id="stockGetir">






 
    
    







</div>
  

                        </div>
                        
                      
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>



    </div>
</div>



<?= view_cell('App\Libraries\ViewComponents::getModals', 
    [
        'element' => 'type',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="#" data-bs-toggle="modal" data-bs-target="#createModalForm" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Tip Ekle</a>
                                    <a href="#" onclick="location.reload()" class="btn btn-l btn-dim btn-outline-dark btn-block">Tip Listesi</a>'
            ],
            'delete' => [
                'modal_title' => 'Bu Tipi Silmek İstediğinize<br>Emin misiniz?',
                'modal_text' => 'Bu tipi silmeden önce lütfen yetkilinize danışınız.',
            ]
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>





$(document).ready(function() {


    // Function to clear everything
    function clearAllData() {
        // Clear stock_id
        $("#stock_id").val('');

        // Clear stockGetir div (which contains scanned barcodes)
        $("#stockGetir").empty();

        // Clear all input fields (assuming there are input fields that need clearing)
        $("input[type='text']").val('');  // Modify selector if needed for other input types

        // Clear the addedBarcodes array
        addedBarcodes = [];

        // Reset total stock display
        $("#toplam_stok").text('0.00');
        $("#html_baslik").text('');

        
        $("#toplam_genel_stok").text('0.00');
        $("#fark").text('0.00').css('color', 'green');

        // Disable the "Stoğu Senkronize Et" button
        $("#yeniStok").addClass("disabled");
    }

    // Handle click event for the "Kutuyu Boşalt" button
    $("#bosalt").on("click", function() {
        // Ask for confirmation using SweetAlert
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Kutuyu boşaltmak istediğinize emin misiniz?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Evet, boşalt!',
            cancelButtonText: 'Hayır, iptal et!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, proceed with clearing all data
                clearAllData();

                // Show success message
                Swal.fire({
                    icon: "success",
                    title: "Başarılı",
                    text: "Kutu başarıyla boşaltıldı.",

                    confirmButtonText: "Kapat",
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // User canceled the action
                Swal.fire({
                    icon: 'info',
                    title: 'İptal Edildi',
                    text: 'İşlem iptal edildi!',
                    confirmButtonText: "Kapat",
                });
            }
        });
    });

    // Prevent checkbox interaction by stopping the click event
    $(".custom-control-input").on("click", function(e) {
        e.preventDefault();
    });
});

let addedBarcodes = [];
let toplamStok = 0;  // Variable to keep track of the total stock

function updateTotalStock() {
    // Calculate total stock from total_amount - used_amount for each barcode
    let toplamStok = addedBarcodes.reduce((total, barcode) => {
        return total + (parseFloat(barcode.total_amount) - parseFloat(barcode.used_amount));
    }, 0);
    
    // Get the type (tipi) and toplam_genel_stok from the first barcode (assuming they are the same for all barcodes)
    let barcodeType = addedBarcodes.length > 0 ? addedBarcodes[0].tipi : '';
    let toplamGenelStok = addedBarcodes.length > 0 ? parseFloat(addedBarcodes[0].toplam_genel_stok) : 0;

    // Calculate the difference (fark)
    let fark = toplamGenelStok - toplamStok;

    // Update the #toplam_stok and #toplam_genel_stok elements
    $("#toplam_stok").text(toplamStok.toFixed(2) + " " + barcodeType); 
    $("#toplam_genel_stok").text(toplamGenelStok.toFixed(2) + " " + barcodeType); 

    // Change button and text color based on the difference
    if (fark !== 0) {
        // If fark is not equal to 0, set color to red and disable the button
        $("#fark").css("color", "red").text(fark.toFixed(2) + " " + barcodeType);
        $("#yeniStok").removeClass("disabled");
    } else {
        // If fark is exactly 0, set color to green and enable the button
        $("#fark").css("color", "green").text(fark.toFixed(2) + " " + barcodeType);
        $("#yeniStok").addClass("disabled");
    }
}

function submitOnEnter(event) {
    if (event.key === "Enter") {
        event.preventDefault();

        var barcode = $(event.target).val(),
            stockID = $("#stock_id").val();

        // Basic validation to check if the barcode is not empty
        if (!barcode) {
            Swal.fire({
                icon: 'warning',
                title: 'Barkod Girişi Boş!',
                text: 'Lütfen geçerli bir barkod giriniz.',
                confirmButtonText: "Kapat",
            });
            return;
        }

        // Check if the barcode has already been added (to prevent duplicates)
        if (addedBarcodes.some(item => item.barcode === barcode)) {
            $(".barkodSil").val('');  // Clears the barcode input field
            Swal.fire({
                icon: 'warning',
                title: 'Bu Barkod Zaten Eklendi!',
                text: 'Aynı barkod birden fazla kez eklenemez.',
                confirmButtonText: "Kapat",
            });
            return;
        }

        Swal.fire({
            title: 'Barkod Sorgulanıyor, Lütfen Bekleyiniz!',
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading();
            },
        });

        $.ajax({
            url: '<?php echo route_to("tportal.stock.getBarcode"); ?>',
            method: 'POST',
            dataType: 'json',
            data: { barcode: barcode, stockID: stockID },
            success: function (res) {
                Swal.close();
                $(".barkodSil").val('');  // Clears the barcode input field

                // Handle success response
                if (res.icon === 'success') {
                    // Update stock ID
                    $("#stock_id").val(res.stock_id);

                    // Append the result HTML to the stock section and add the title
                    $("#stockGetir").append(res.html);
                    $("#html_baslik").html(res.html_baslik);

                    // Ensure stock_barcode_id is correctly passed from the response
                    if (res.stock_barcode_id) {
                        // Add the barcode and its details to the array to prevent duplicate submissions
                        addedBarcodes.push({
                            stock_barcode_id: res.stock_barcode_id,  // Get stock_barcode_id from response
                            toplam_genel_stok: res.toplam_genel_stok,  // Get stock_barcode_id from response
                            
                            barcode: barcode,
                            tipi: res.tipi,
                            stock_id: res.stock_id,
                            total_amount: res.total_amount, // Assuming res has total_amount
                            used_amount: res.used_amount    // Assuming res has used_amount
                        });
                        
                        // Update the total stock after adding the new barcode
                        updateTotalStock();

                        Swal.fire({
                            icon: "success",
                            title: 'Başarılı',
                            html: res.data,
                            confirmButtonText: "Kapat",
                        });
                    }
                // If the barcode belongs to a different product
                } else if (res.icon === 'info') {
                    Swal.fire({
                        icon: "info",
                        title: 'Barkod Başka Ürüne Ait',
                        html: res.data,
                        confirmButtonText: "Kapat",
                    });

                // Handle other responses
                } else if (res.icon === 'warning') {
                    Swal.fire({
                        icon: "warning",
                        title: 'Barkod Bulunamadı!',
                        html: res.data,
                        confirmButtonText: "Kapat",
                    });

                } else {
                    Swal.fire({
                        icon: "error",
                        title: 'Hata',
                        html: res.data,
                        confirmButtonText: "Kapat",
                    });
                }
            },
            error: function () {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    html: 'Bir hata oluştu, lütfen tekrar deneyin.',
                    confirmButtonText: "Kapat",
                });
            }
        });
    }
}



$(document).ready(function() {
    $("#yeniStok").on("click", function() {
        // Calculate the values we want to show in the confirmation prompt
        let toplamStok = parseFloat($("#toplam_stok").text());
        let toplamGenelStok = parseFloat($("#toplam_genel_stok").text());
        let fark = toplamGenelStok - toplamStok;

        // Show confirmation prompt with a table structure for better alignment
        if (fark !== 0) {
            Swal.fire({
                title: 'Bu işlemi onaylıyormusunuz?',
                html: `
                    <table style="width: 100%; text-align: left; font-size: 16px;">
                        <tr>
                            <td><strong>Toplam Okutulan Stok:</strong></td>
                            <td style="text-align: right; font-family: monospace;">${toplamStok.toFixed(2)}</td>
                        </tr>
                        <tr>
                            <td><strong>Güncel Stok:</strong></td>
                            <td style="text-align: right; font-family: monospace;">${toplamGenelStok.toFixed(2)}</td>
                        </tr>
                        <tr>
                            <td><strong>Fark:</strong></td>
                            <td style="text-align: right; font-family: monospace; color:${fark == 0 ? 'green' : 'red'};">${fark.toFixed(2)}</td>
                        </tr>
                        <tr>
                            <td style="color:black"><strong>Yeni Güncellenecek Stok Değeri:</strong></td>
                            <td style="text-align: right; font-weight:bold; color:black; font-family: monospace;">${toplamStok.toFixed(2)}</td>
                        </tr>
                    </table>
                   
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Evet, devam et!',
                cancelButtonText: 'Hayır, iptal et!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, proceed with the AJAX request
                    
                    // Log the current addedBarcodes array
                    console.log("Selected Barcodes:", addedBarcodes);

                    // Submit data via AJAX
                    $.ajax({
                        url: '<?php echo route_to("tportal.stock.barkodKapat"); ?>',  // Replace with your save route
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            stock_id: $("#stock_id").val(),  // Send the stock ID
                            barcodes: addedBarcodes          // Send the array of selected barcode objects
                        },
                        success: function(response) {
                            Swal.fire({
                                    icon: "success",
                                    title: "Başarılı",
                                    text: "Değişiklikler kaydedildi!",
                                    confirmButtonText: 'Tamam'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                        },
                        error: function() {
                            Swal.fire({
                                icon: "error",
                                title: "Hata",
                                text: "Bir hata oluştu. Lütfen tekrar deneyin."
                            });
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // User canceled the action
                    Swal.fire({
                        icon: 'info',
                        title: 'İptal Edildi',
                        text: 'İşlem iptal edildi!',
                    });
                }
            });
        }
    });
});

// Excel dosya seçimi için
$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').html(fileName);
    
    // Dosya uzantısı kontrolü
    let fileExt = fileName.split('.').pop().toLowerCase();
    if (fileExt !== "xlsx" && fileExt !== "xls") {
        Swal.fire({
            icon: 'error',
            title: 'Geçersiz Dosya Formatı',
            text: 'Lütfen sadece .xlsx veya .xls formatında dosya yükleyin!',
            confirmButtonText: "Tamam"
        });
        $(this).val('');
        $(this).next('.custom-file-label').html('Dosya Seçin');
        return false;
    }
});

// Form submit kontrolü
$('.form-validate').on('submit', function(e) {
    e.preventDefault();
    
    let formData = new FormData(this);
    
    Swal.fire({
        title: 'Excel Yükleniyor',
        text: 'Lütfen bekleyin...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Başarılı!',
                    text: response.message,
                    confirmButtonText: "Tamam"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: response.message,
                    confirmButtonText: "Tamam"
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                text: 'Dosya yükleme sırasında bir hata oluştu.',
                confirmButtonText: "Tamam"
            });
        }
    });
});
</script>

<?= $this->endSection() ?>