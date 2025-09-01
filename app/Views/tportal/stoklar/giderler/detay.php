


<?php
    $detail_text =  'Gider Fişi' ;
?>

<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> <?= $detail_text ?> Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> <?= $detail_text ?> Detay | <?= $invoice_item['gider_no'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>



<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="invoice">
                    <!-- <div class="invoice-action">
                        <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" href="/demo9/invoice-print.html" target="_blank"><em class="icon ni ni-printer-fill"></em></a>
                    </div> -->
                    <div class="card invoice-wrap">
                        <div class="invoice-head" style="">
                            <div class="invoice-contact"><span class="overline-title"><?= $invoice_item['gider_no'] ?></span>
                                <div class="invoice-contact-info">
                                    <h4 class="title"><?= $invoice_item['cari_invoice_title'] ?></h4>
                                    <ul class="list-plain">
                                        <?= $invoice_item['address'] != '' ? '<li><em class="icon ni ni-map-pin-fill"></em><span>' . $invoice_item['address'] . '</span></li>' : ''; ?>
                                        <?= $invoice_item['cari_phone'] != '' ? '<li><em class="icon ni ni-call-fill"></em><span>' . $invoice_item['cari_phone'] . '</span></li>' : ''; ?>
                                        <?= $invoice_item['cari_email'] != '' ? '<li><em class="icon ni ni-mail-fill"></em><span>' . $invoice_item['cari_email'] . '</span></li>' : ''; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="invoice-desc" style="min-width: 300px;">
                                <?php if($invoice_item["odeme_durumu"] == "odenecek"){ ?> 
                                    <h4 class="title text-danger">ÖDEME ALINACAK</h4>
                                <?php }else{ ?>
                                    <h4 class="title text-success">ÖDEME ALINDI</h4>
                                    <?php } ?>
                                <ul class="list-plain">
                                
                                    <li class="invoice-id"><span>Gider No</span>:<span><?= $invoice_item['gider_no'] ?></span></li>
                                    <li class="invoice-date"><span>Gider Tarihi</span>:<span><?= $invoice_item['gider_date'] ?></span></li>
                                    <li class="invoice-date"><span>Gider Kategori</span>:<span><?= $invoice_item['gider_category_title'] ?></span></li>
                                    <li class="invoice-date"><span>FİŞ BELGE:</span>:<span id="file-preview" ></span></li>
                                    <?php if($invoice_item["odeme_durumu"] == "odendi"){ ?>
                                        <li class="invoice-date"><span>TAHSİLAT:</span>:<span  >
                                            <a href="<?= route_to('tportal.cariler.payment_or_collection_edit', $invoice_item['is_quick_collection_financial_movement_id']) ?>">
                                                
                                            Tahsilatı Görüntüle</a></span></li>
                                    
                                    <?php } ?>


                                    
                                </ul>
                            </div>
                        </div>
                        <div class="invoice-bills">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="w-10">Açıklama</th>
                             
                                     
                                            <th class="text-right">Toplam</th>
                                            <th class="text-right">KDV</th>
                                           
                                            <th>Toplam</th>
                                        </tr>
                                    </thead>
                                    <tbody id="fatura_satirlar">

                                        <?php
                                       $colspan = 1;

                                        foreach ($invoice_rows as $invoice_row) { ?>
                                            <tr class="" id="Satir_<?= $invoice_row['gider_satir_id'] ?>">
                                                <td id="txt_aciklama_<?= $invoice_row['gider_satir_id'] ?>">
                                                    <strong><?= $invoice_row['stock_title'] ?><br></strong><?= $invoice_row['stock_code'] ?? '' ?>
                                                </td>
                                       
                                                <td id="txt_ara_toplam_<?= $invoice_row['gider_satir_id'] ?>" class="text-right"><?= number_format($invoice_row['subtotal_price'], 2, ',', '.') ?> <?= $invoice_item['money_icon'] ?></td>


                                                <td id="txt_kdv_<?= $invoice_row['gider_satir_id'] ?>" class="text-right"><?= number_format($invoice_row['tax_price'], 2, ',', '.') ?> <?= $invoice_item['money_icon'] ?> (%<?= $invoice_row['tax_id'] ?>)</td>
                                              
                                                <td id="txt_genel_toplam_<?= $invoice_row['gider_satir_id'] ?>" class="text-right"><?= number_format($invoice_row['total_price'], 2, ',', '.') ?> <?= $invoice_item['money_icon'] ?></td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td style="width:200px" >Gider Ara Toplam</td>
                                            <td style="width:30px" class="text-right" id="txt_kdvsiz_toplam"><?= number_format($invoice_item['stock_total'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></td>
                                        </tr>

                                     


                                    

                                        <?php
                                        if ($invoice_item['sub_total_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="2"></td>' .
                                                '<td style="width:200px" ></td>' .
                                                '<td class="text-right" id="txt_ara_toplam_dvz">' . number_format($invoice_item["sub_total_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['tax_rate_1_amount'] != 0) {
                                            echo '<tr>' .
                                                '<td colspan="2"></td>' .
                                                '<td style="width:200px">KDV Toplam (%1)</td>' .
                                                '<td style="width:30px" class="text-right" id="txt_kdv_toplam1">' . number_format($invoice_item["tax_rate_1_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['tax_rate_1_amount_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="2"></td>' .
                                                '<td style="width:200px" ></td>' .
                                                '<td style="width:30px" class="text-right" id="txt_kdv_toplam1_dvz">' . number_format($invoice_item["tax_rate_1_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['tax_rate_10_amount'] != 0) {
                                            echo '<tr>' .
                                                '<td colspan="2"></td>' .
                                                '<td style="width:200px" >KDV Toplam (%10)</td>' .
                                                '<td style="width:30px" class="text-right" id="txt_kdv_toplam10">' . number_format($invoice_item["tax_rate_10_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['tax_rate_10_amount_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="2"></td>' .
                                                '<td style="width:200px"></td>' .
                                                '<td style="width:30px" class="text-right" id="txt_kdv_toplam10_dvz">' . number_format($invoice_item["tax_rate_10_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['tax_rate_20_amount'] != 0) {
                                            echo '<tr>' .
                                                '<td colspan="2"></td>' .
                                                '<td style="width:200px" >KDV Toplam (%20)</td>' .
                                                '<td style="width:30px" class="text-right" id="txt_kdv_toplam20">' . number_format($invoice_item["tax_rate_20_amount"], 2, ',', '.') . ' ' . $invoice_item["money_code"] . '</td>' .
                                                '</tr>';
                                        }

                                        if ($invoice_item['tax_rate_20_amount_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="2"></td>' .
                                                '<td style="width:200px"  ></td>' .
                                                '<td style="width:30px" class="text-right" id="txt_kdv_toplam20_dvz">' . number_format($invoice_item["tax_rate_20_amount_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        }

                                        

                                        ?>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td style="width:200px"><strong>Genel Toplam</strong></td>
                                            <td style="width:30px" class="text-right" id="txt_genel_toplam"><strong><?= number_format($invoice_item['grand_total'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></strong></td>
                                        </tr>
                                      
                                        
                                       
                                    </tfoot>
                                </table>
                                <hr>
                                <div class="invoice-desc w-100" style="display: flex; justify-content:space-between; align-items:center;">
                                    <div>
                                        <span>Gider Not</span>:
                                        <ul class="list-plain">
                                            <li class="invoice-date">
                                                <span><?= $invoice_item['amount_to_be_paid_text'] ?></span>
                                            </li>

                                            <?php
                                            if ($invoice_item['currency_amount'] != 0) {
                                                echo '<li class="invoice-date">' .
                                                    '<span>Döviz Kur Bilgisi:' . number_format($invoice_row['currency_amount'], 2, ',', '.') . ' </span>' .
                                                    '</li>';
                                            }

                                            if ($invoice_item['odeme_durumu'] != "odenecek") {
                                                echo '<li class="invoice-date">' .
                                                    '<span>Tahsilatlı Gider </span>' .
                                                    '</li>';
                                            } ?>

                                            <li class="invoice-date">
                                                <!-- <span>Fatura Not</span>: -->
                                                <span style="text-transform:initial;"><?= $invoice_item['gider_note'] ?></span>
                                            </li>

                                         
                                        </ul>
                                    </div>

                                    <!-- #TODO burası modal yapısına çevirilebilir... -->
                                    <div>
                                        <div class="mt-1"><a href="<?= route_to('tportal.gider.edit', $invoice_item['gider_id']) ?>" class="btn btn-warning btn-block"><em class="icon ni ni-edit"></em><span><?= $detail_text ?> Düzenle</span></a></div>
                                        <div class="mt-1"><button class="btn btn-danger btn-block" data-invoice-id="<?= $invoice_item['gider_id'] ?>" id="btnDeleteInvoice"><em class="icon ni ni-edit"></em><span><?= $detail_text ?> Sil</span></button></div>


                                        <input type="hidden" id="fis_fatura_belge_data" value="<?= $invoice_item['fis_fatura_belge']; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->endSection() ?>

        <?= $this->section('script') ?>

        <script>


// Sayfa yüklendiğinde mevcut dosyayı göster
document.addEventListener('DOMContentLoaded', function () {
    const filePath = document.getElementById('fis_fatura_belge_data').value;
    const previewContainer = document.getElementById('file-preview');

    if (filePath) {
        // Dosya tipini kontrol et
        const fileExtension = filePath.split('.').pop().toLowerCase(); // Dosya uzantısını al

        // Dosya uzantısına göre uygun önizlemeyi göster
        if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
            // PDF dosyası ise link ile göster
            const link = document.createElement('a');
            link.href = `<?= base_url(''); ?>${filePath}`;
            link.target = '_blank';
            link.innerText = 'Fiş Belgeyi Görüntüle ';
            previewContainer.appendChild(link);
        } else if (fileExtension === 'pdf') {
            // PDF dosyası ise link ile göster
            const link = document.createElement('a');
            link.href = `<?= base_url(''); ?>${filePath}`;
            link.target = '_blank';
            link.innerText = 'Fiş Belgeyi Görüntüle ';
            previewContainer.appendChild(link);
        } else if (fileExtension === 'zip') {
            // ZIP dosyası için link göster
            const link = document.createElement('a');
            link.href = `<?= base_url(''); ?>${filePath}`;
            link.target = '_blank';
            link.innerText = 'Fiş Belgeyi Görüntüle ';
            previewContainer.appendChild(link);
        } else {
            previewContainer.innerHTML = '<p>Desteklenmeyen dosya formatı.</p>';
        }
    }
});


            $('document').ready(function () {
                var myVar = $("#DataTables_Table_1_wrapper").find('.with-export').removeClass('d-none');
                var myVar2 = $("#DataTables_Table_1_wrapper").find('.with-export').css("margin-bottom", "10px");
                var base_url = window.location.origin;

                $(document).on("click", "#btnDeleteInvoice", function () {
                    var gider_id = $(this).attr('data-invoice-id');
                    console.log(gider_id);


                    Swal.fire({
                            title: '<?= $detail_text ?> silmek üzeresiniz!',
                            html: 'Silme işlemine devam etmek istiyor musunuz?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Devam Et',
                            cancelButtonText: 'Hayır',
                            allowEscapeKey: false,
                            allowOutsideClick: false,

                        }).then((result) => {
                            if (result.isConfirmed) {

                                Swal.fire({
                                    title: 'İşleminiz gerçekleştiriliyor, lütfen bekleyiniz...',
                                    allowOutsideClick: false,
                                    onBeforeOpen: () => {
                                        Swal.showLoading();
                                    },
                                });

                                $.ajax({
                                    type: "POST",
                                    url: base_url + '/tportal/giderler/delete/' + gider_id,
                                    async: true,
                                    datatype: "json",
                                    success: function(response, data) {
                                        dataa = JSON.parse(response);
                                        if (dataa.icon === "success") {
                                            console.log(response);
                                            console.log(data);
                                            Swal.fire({
                                                    title: "İşlem Başarılı",
                                                    html: '<?= $detail_text ?> silme işlemi başarıyla gerçekleşti.',
                                                    confirmButtonText: "Tamam",
                                                    allowEscapeKey: false,
                                                    allowOutsideClick: false,
                                                    icon: "success",
                                                })
                                                .then(function() {
                                                    (window.history.length > 1) ? window.history.back() : window.location.href = base_url+"/tportal/invoice/list/all";
                                                });

                                        } else {
                                            Swal.fire({
                                                title: "İşlem Başarısız",
                                                text: dataa.message,
                                                confirmButtonText: "Tamam",
                                                allowEscapeKey: false,
                                                allowOutsideClick: false,
                                                icon: "error",
                                            })
                                        }
                                    },
                                    error: function () {
                                        swetAlert("Hata!", "bir şeyler ters gitti", "err");
                                    }
                                });

                            } else if (result.isCancel) {
                                Swal.fire('Değişiklikler kaydedilmedi', '', 'info')
                            }
                        });
                });

            });
        </script>

        <?= $this->endSection() ?>