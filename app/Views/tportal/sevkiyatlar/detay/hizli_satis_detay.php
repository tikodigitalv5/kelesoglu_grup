<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?>
<?= $quick_sale_item['invoice_direction'] == 'incoming_invoice' ? "Hızlı Alış Detay" : "Hızlı Satış Detay" ?>
<?= $this->endSection() ?>
<?= $this->section('title') ?>
<?= $quick_sale_item['invoice_direction'] == 'incoming_invoice' ? "Hızlı Alış Detay" : "Hızlı Satış Detay" ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>
<?= $this->section('main') ?>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card card-stretch">
                    <form onsubmit="return false;" id="approve_shipment_form" method="POST">
                        <div class="card-inner-group">
                            <div class="card-inner">
                                <div class="gy-3">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-3 ">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Müşteri</label>
                                                <span class="form-note d-none d-md-block">Satış yapılan müşteri.</span>
                                            </div>
                                        </div>
                                        <div class="col mt-0 mt-md-2">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-xl" id="account"
                                                        name="account"
                                                        value="<?= $quick_sale_item['cari_invoice_title'] == '' ? $quick_sale_item['cari_name'] . ' ' . $quick_sale_item['cari_surname'] : $quick_sale_item['cari_invoice_title'] ?>"
                                                        disabled placeholder="Müşteri seçmek için tıklayınız..">
                                                    <!-- <div class="input-group-append">
                                                        <button data-bs-toggle="modal" data-bs-target="#mdl_hesaplar" class="btn btn-lg btn-block btn-dim btn-outline-light">SEÇ</button>
                                                        <button class="btn btn-lg btn-block btn-dim btn-outline-light">EKLE</button>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-center">
                                        <div class="col-lg-3 ">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Satış Zamanı</label>
                                                <span class="form-note d-none d-md-block">Satış oluşturulan tarih ve
                                                    saat bilgisi.</span>
                                            </div>
                                        </div>
                                        <div class="col mt-0 mt-md-2">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-xl" id="account"
                                                        name="account"
                                                        value="<?= date('d/m/Y H:i:s', strtotime($quick_sale_item['invoice_date'])) ?>"
                                                        disabled>
                                                    <!-- <div class="input-group-append">
                                                        <button data-bs-toggle="modal" data-bs-target="#mdl_hesaplar" class="btn btn-lg btn-block btn-dim btn-outline-light">SEÇ</button>
                                                        <button class="btn btn-lg btn-block btn-dim btn-outline-light">EKLE</button>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-center">
                                        <div class="col-lg-3 ">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Satış Durumu</label>
                                                <span class="form-note d-none d-md-block"></span>
                                            </div>
                                        </div>
                                        <div class="col mt-0 mt-md-2">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-xl" id="account"
                                                        name="account" value=" <?php switch ('sistemde') {
                                                            case 'sistemde':
                                                                echo 'Sistemde';
                                                                break;
                                                            case 'processing':
                                                                echo 'Sevkte';
                                                                break;
                                                            case 'successful':
                                                                echo 'Teslim Edildi';
                                                                break;
                                                            case 'failed':
                                                                echo 'İptal Edildi';
                                                                break;
                                                            default:
                                                                # code...
                                                                break;
                                                        } ?>" disabled placeholder="Müşteri seçmek için tıklayınız..">
                                                    <div class="input-group-append">
                                                        <!-- <button id="btnDeleteSaleOrder" class="btn btn-lg btn-block btn-dim btn-outline-danger" data-shipment-id=" //$shipment_item['shipment_id'] " >Siparişi İptal Et/Sil</button> -->
                                                        <!-- <button class="btn btn-lg btn-block btn-dim btn-outline-light">EKLE</button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if ($quick_sale_item['invoice_direction'] == "outgoing_invoice") { ?>
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-3 ">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-name">Sipariş No</label>
                                                    <span class="form-note d-none d-md-block"></span>
                                                </div>
                                            </div>
                                            <div class="col mt-0 mt-md-2">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-xl"
                                                            id="quick_sale_item_no" name="quick_sale_item_no"
                                                            value="<?= $quick_sale_item['invoice_no'] ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>


                                </div>
                            </div>
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="row g-3">
                                    <div class="col-md-12 col-lg-12 col-xxl-12 col-12">

                                        <?= $quick_sale_item['is_return'] == 1 ? '<div class="alert alert-primary alert-icon"><em class="icon ni ni-alert-circle"></em> Bu sipariş bir <strong>iade</strong> işlemidir. </div>' : '' ?>

                                        <div class="invoice-bills">
                                            <div class="table-responsive">


                                                <br><br>

                                                <table class="table table-striped" id="satisYapilacakUrunler">
                                                    <thead>
                                                        <tr>
                                                            <th class="" style="width:80px !important;">Sıra No</th>
                                                            <th class="">...</th>
                                                            <th class="w-100 d-none">Barkod</th>
                                                            <th>Ürün Adı</th>
                                                            <th class="w-100px text-right"
                                                                style="padding-right:50px; text-align:right ">Miktar
                                                            </th>
                                                            <th class="w-100px text-right"
                                                                style="padding-right:50px; text-align:right ">B.Fiyat
                                                            </th>
                                                            <th class="w-100px text-right" style="padding-right:50px;">
                                                                T.Fiyat</th>
                                                            <!-- <th class="text-center" style="width: 200px;"></th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="shipment_order_items">

                                                        <?php
                                                        $siraNo = 0;
                                                        $toplamMiktar = 0;
                                                        $unitTotals = []; // Her bir unit_title için birim_adet'leri saklayacak
                                                 
                                                        foreach ($quick_sale_items as $quick_sale_item1) {
                                                            $siraNo++;
                                                            $toplamMiktar = $toplamMiktar + $quick_sale_item1['birim_adet']; 
                                                            

                                                            $unitTitle = $quick_sale_item1['unit_title'];
                                                            if (!isset($unitTotals[$unitTitle])) {
                                                                $unitTotals[$unitTitle] = 0;
                                                            }
                                                            $unitTotals[$unitTitle] += $quick_sale_item1['birim_adet']; // Toplam birim_adet ekleniyor
                                                            
                                                            ?>
                                                            <tr
                                                                id="shipment_order_item_<?= $quick_sale_item1['stock_code'] ?>">
                                                                <td> <?= $siraNo ?> </td>
                                                               
                                                                <td style="width:100px">
                                                                <?php 
                                                                $carim = session()->get("user_item")["stock_user"] ?? 0;
                                                                if($carim != $quick_sale_item["cari_id"]):
                                                                ?>
                                                                    <?php
                                                                    if ($quick_sale_item['invoice_direction'] == 'outgoing_invoice' && $quick_sale_item1['birim_adet'] > 0 && ($quick_sale_item1['is_return_amount'] < $quick_sale_item1['birim_adet'])) { ?>
                                                                       <?php if($quick_sale_item["invoice_type"] != "IADE"): ?>
                                                                       <button
                                                                            class="btn btn-outline-warning btn-xs btn_return d-none"
                                                                            data-return-stock-barcode-id="<?= $quick_sale_item1['stock_barcode_id'] ?>"
                                                                            data-stock-barcode="<?= $quick_sale_item1['stock_barcode'] ?>"
                                                                            data-stock-id="<?= $quick_sale_item1['stock_id'] ?>"
                                                                            data-stock-birim="<?= $quick_sale_item1['unit_title'] ?>"
                                                                            data-stock-code="<?= $quick_sale_item1['stock_code'] ?>"
                                                                            data-stock-title="<?= $quick_sale_item1['stock_title'] ?>"
                                                                            data-stock-amount="<?= $quick_sale_item1['birim_adet'] ?>"
                                                                            data-stock-returned-amount="<?= $quick_sale_item1['is_return_amount'] ?>">iade
                                                                            et</button>
                                                                            <?php endif; ?>
                                                                    <?php }
                                                                    ?>

<button
                                                                            class="btn btn-outline-primary btn-xs btn_fiyat mt-1 d-none "
                                                                            data-return-stock-barcode-id="<?= $quick_sale_item1['stock_barcode_id'] ?>"
                                                                            data-stock-rowid="<?= $quick_sale_item1['fatura_satiri']; ?>"
                                                                            data-stock-unit="<?= $quick_sale_item1['birim_fiyat'] ?>"
                                                                            data-stock-barcode="<?= $quick_sale_item1['stock_barcode'] ?>"
                                                                            data-stock-id="<?= $quick_sale_item1['stock_id'] ?>"
                                                                            data-stock-money_unit="<?= $quick_sale_item1['money_unit'] ?>"
                                                                            data-stock-birim="<?= $quick_sale_item1['unit_title'] ?>"
                                                                            data-stock-code="<?= $quick_sale_item1['stock_code'] ?>"
                                                                            data-stock-title="<?= $quick_sale_item1['stock_title'] ?>"
                                                                            data-stock-amount="<?= $quick_sale_item1['birim_adet'] ?>"
                                                                            data-stock-sale="<?= $quick_sale_item1['sale_unit_price'] ?>"
                                                                            data-stock-returned-amount="<?= $quick_sale_item1['is_return_amount'] ?>">fiyat gnc</button>
                                                                            <?php endif; ?>
                                                                </td>
                                                               
                                                                <td>
                                                                    <!-- <a href="#" class="btn btn-outline-warning btn-xs"><em class="icon ni ni-curve-up-left"></em></a> -->

                                                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        data-bs-title="Stok Barkodu"><?= convert_barcode_number_for_form($quick_sale_item1['barcode_number']) ?></span>
                                                                    | <b class="fw-bold" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        data-bs-title="Ürün Barkodu <?= convert_barcode_number_for_form($quick_sale_item1['stock_barcode']) ?>">
                                                                        <?= $quick_sale_item1['stock_title'] ?>
                                                                    </b>
                                                                    <br>


                                                                    <?php if ($quick_sale_item['invoice_direction'] == 'incoming_invoice') { ?>

                                                                        <!-- <?= $quick_sale_item1['is_return_amount'] == $quick_sale_item1['birim_adet'] ? '' : '<br><span class="small">Bu ürünün tümü iade alındı</span>' ?> -->

                                                                        <?php if ($quick_sale_item1['supplier_id'])
                                                                            echo '<small>' . $quick_sale_item1['invoice_title'] . '</small>' ?>

                                                                    <?php } ?>

                                                                    <?php if ($quick_sale_item['invoice_direction'] == 'outgoing_invoice') {
                                                                        ; ?>

                                                                        <?= $quick_sale_item1['is_return'] == null ? '<span class="small">Bu ürün için daha önce <b>' . number_format($quick_sale_item1['is_return_amount'], 2, ',', '.') . ' ' . $quick_sale_item1['unit_title'] . ' </b> iade alındı</span>' : '' ?>


                                                                    <?php } ?>

                                                                </td>
                                                                <td>
                                                                    <?= number_format($quick_sale_item1['birim_adet'], 2, ',', '.') ?>
                                                                    <?= $quick_sale_item1['unit_title'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= number_format($quick_sale_item1['birim_fiyat'], 2, ',', '.') ?>
                                                                    <?= $quick_sale_item1['money_unit'] ?>
                                                                </td>

                                                                <td class="fw-bold">
                                                                    <a class="">
                                                                        <?= number_format($quick_sale_item1['toplam_fiyat'], 2, ',', '.'); ?>
                                                                        <?= $quick_sale_item1['money_unit'] ?>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                        <?php }
                                                        ?>

                                                    </tbody>
                                                    <tfoot>
                                                      

                                                                <input type="hidden" name="total_stock_amount"
                                                                    id="total_stock_amount" value="0">
                                                                    <?php foreach ($unitTotals as $unitTitle => $totalAdet): ?>

            <tr>
                                            <td colspan="3"></td>
                                            <td colspan="2"><strong>TOPLAM  <?= $unitTitle ?></strong></td>
                                            <td class="text-right" colspan=""><strong> <?= number_format($totalAdet, 2, ',', '.'); ?> <?= $unitTitle ?></strong></td>
                                        </tr>
        <?php endforeach; ?>
                                                        
                                                        <?php 
                                                        $invoice_item = $quick_sale_item;
                                                        $colspan = 3;
                                                        if(isset($Kurlar)): foreach($Kurlar as $kur){ 
                                                if($invoice_item['money_unit_id'] != $kur["kur"]):
                                            ?>
                                            <tr>
                                            <td colspan="<?= $colspan ?>"></td>
                                            <td colspan="2"><strong><?php echo $kur["money_code"] ?> </strong></td>
                                            <td class="text-right" id="txt_odenecek_toplam"><strong><?= number_format($kur['toplam_tutar'], 2, ',', '.') ?> <?= $kur['money_code'] ?></strong></td>
                                        </tr>

                                       
                                            
                                            
                                        <?php endif; } endif;?>
                                        <tr>
                                            <td colspan="<?= $colspan ?>"></td>
                                            <td colspan="2"><strong>Ödenecek Toplam</strong></td>
                                            <td class="text-right" id="txt_odenecek_toplam"><strong><?= number_format($invoice_item['amount_to_be_paid'], 2, ',', '.') ?> <?= $invoice_item['money_code'] ?></strong></td>
                                        </tr>
                                        <?php
                                        if ($invoice_item['amount_to_be_paid_try'] != 0 && $invoice_item['money_code'] != "TRY") {
                                            echo '<tr>' .
                                                '<td colspan="' . $colspan . '"></td>' .
                                                '<td colspan="2"></td>' .
                                                '<td class="text-right" id="txt_odenecek_toplam_dvz">' . number_format($invoice_item["amount_to_be_paid_try"], 2, ',', '.') . ' TRY</td>' .
                                                '</tr>';
                                        } ?>
                                                    </tfoot>
                                                </table>




                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center pt-5">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label" for="shipment_note">Satış
                                                Notu</label><span class="form-note d-none d-md-block">Satış ile
                                                ilgili
                                                notunuz varsa yazınız.</span></div>
                                    </div>
                                    <div class="col-lg-9 col-xxl-9 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <textarea disabled="" class="form-control form-control-xl no-resize"
                                                    name="shipment_note"
                                                    id="shipment_note"> <?= $quick_sale_item['invoice_note'] ?>  </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                        <div class="card-inner">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="form-group">
                                        <a href="javascript:history.back()"
                                            class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em
                                                class="icon ni ni-arrow-left"></em><span>Geri</span></a>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="form-group">
                                        <!-- <button type="button" id="checkBeforeArrival" class="btn btn-lg btn-primary">Sevkiyatı Tamamla</button> -->
                                        <?php 
                                                                $carim = session()->get("user_item")["stock_user"] ?? 0;
                                                                if($carim != $quick_sale_item["cari_id"]):
                                                                ?>
                                        <?php
                                        if ($quick_sale_item['invoice_direction'] == 'incoming_invoice' && $quick_sale_item['is_return'] == 1) { ?>
                                            <div class="mt-1">
                                                <button class="btn btn-danger" id="btn_delete_return_sale_order"
                                                    data-invoice-id="<?= $quick_sale_item['invoice_id'] ?>"
                                                    data-stock-barcode-id="<?= $quick_sale_items[0]['stock_barcode_id'] ?>"
                                                    data-stock-movement-id="<?= $quick_sale_items[0]['stock_movement_id'] ?>">
                                                    <em class="icon ni ni-trash"></em>
                                                    <span>Bu İade İşlemini Sil</span>
                                                </button>
                                            </div>

                                        <?php } ?>

                                        <?php
                                        if ($quick_sale_item['invoice_direction'] == 'outgoing_invoice') { ?>
                                            <div class="mt-1">
                                                <button class="btn btn-danger" id="btn_delete_sale_order"
                                                    data-invoice-id="<?= $quick_sale_item['invoice_id'] ?>">
                                                    <em class="icon ni ni-trash"></em>
                                                    <span>Bu Hızlı Satış İşlemini Sil</span>
                                                </button>
                                            </div>

                                        <?php } ?>

                                        <?php endif; ?>


                                        <?php
                                        if ($quick_sale_item['invoice_direction'] == 'incoming_invoice') { ?>
                                            <div class="mt-1"><button class="btn btn-dark" disabled><em
                                                        class="icon ni ni-printer"></em><span>Hızlı Alış Fişi
                                                        Yazdır</span></button></div>

                                        <?php } else { ?>
                                            <div class="mt-1"><a
                                                    href="<?= route_to('tportal.faturalar.quickSalePrint', $quick_sale_item['invoice_id']) ?>"
                                                    target="_blank" class="btn btn-dark"><em
                                                        class="icon ni ni-printer"></em><span>Hızlı Satış Fişi
                                                        Yazdır</span></a></div>

                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                    </form>
                </div>
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<button type="button" id="trigger_approve_shipment_modal" class="btn btn-success d-none" data-bs-toggle="modal"
    data-bs-target="#approve_shipment_modal">Approve</button>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" id="approve_shipment_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em
                        class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent"></em>
                    <h4 class="nk-modal-title">Sevkiyatı Onaylıyor Musunuz!</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text">Sevkiyatta eksik ürünler bulunmaktadır. Sevkiyatı onaylıyor
                            musunuz?</div><br>
                        <ul id="checked_shipment_items"></ul>
                    </div>
                    <div class="nk-modal-action">
                        <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger" id="approveDeparture"
                            data-bs-dismiss="modal">Evet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="mdl_price">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fiyat Değişikliği Yapılacak Ürün Bilgileri</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="FiyatModalForm" method="post" class="form-validate is-alter">

                    <div class="row g-3 align-center mb-4">
                        <div class="col-6">
                            <label class="form-label" for="stock_bardode">Ürün Barkodu</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" disabled placeholder=""
                                    id="stock_bardodes" name="stock_bardode" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="stock_code">Ürün Kodu</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="" disabled id="stock_codes"
                                    name="stock_code" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center mb-4">
                        <div class="col-12">
                            <label class="form-label" for="stock_title">Ürün Adı</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="" disabled id="stock_titles"
                                    name="stock_title" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 align-center mb-4">
                        <div class="col-12">
                            <label class="form-label" for="stock_quantity">Fiyatını Değiştir</label>
                            <div class="form-control-wrap" id="Satir_0">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl text-end"
                                        id="return_price" placeholder="Fiyat Giriniz" name="return_price"
                                        onkeypress="return SadeceRakam(event,[',']);" autocomplete="off">

                                        <div class="input-group-append">
                                        <span class="input-group-text" id="birim_tipis"></span>
                                    </div>
                                    
                                </div>
                            </div>
                         
                        </div>
                    </div>

                    <input type="hidden" name="stock_id" id="stock_ids">
                    <input type="hidden" name="stock_barcode_id" id="stock_barcode_ids">
                    <input type="hidden" name="satir_id" id="stock_satir_id">
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" class="btn btn-lg  btn-dim btn-outline-light"
                            data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0" id="base_btn">
                        <button type="button" id="fiyatiGuncelle" class="btn btn-lg btn-primary ">Fiyatı Güncelle</button>
                    </div>
                    <div class="col-md-8 text-end p-0 d-none" id="btn_waiting">
                        <button class="btn btn-lg btn-primary" type="button" disabled=""><span
                                class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span><span>İşleminiz gerçekleştiriliyor...</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="mdl_return">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">İade Bilgileri</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body bg-white">
                <form onsubmit="return false;" id="returnModalForm" method="post" class="form-validate is-alter">

                    <div class="row g-3 align-center mb-4">
                        <div class="col-6">
                            <label class="form-label" for="stock_bardode">Ürün Barkodu</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" disabled placeholder=""
                                    id="stock_bardode" name="stock_bardode" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="stock_code">Ürün Kodu</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="" disabled id="stock_code"
                                    name="stock_code" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center mb-4">
                        <div class="col-12">
                            <label class="form-label" for="stock_title">Ürün Adı</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-xl" placeholder="" disabled id="stock_title"
                                    name="stock_title" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 align-center mb-4">
                        <div class="col-12">
                            <label class="form-label" for="stock_quantity">İade Edilcek Miktar</label>
                            <div class="form-control-wrap" id="Satir_0">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-xl text-end"
                                        id="return_quantity" placeholder="Miktar Giriniz" name="return_quantity"
                                        onkeypress="return SadeceRakam(event,[',']);" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="birim_tipi"></span>
                                    </div>
                                </div>
                            </div>
                            <span style="float:right; margin-top:18px; cursor:pointer;" id="all_return"
                                class="text-primary all_return">TÜMÜNÜ İADE
                                ET</span>
                        </div>
                    </div>

                    <input type="hidden" name="stock_id" id="stock_id">
                    <input type="hidden" name="stock_barcode_id" id="stock_barcode_id">
                </form>
            </div>
            <div class="modal-footer d-block p-3 bg-white">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <button type="button" class="btn btn-lg  btn-dim btn-outline-light"
                            data-bs-dismiss="modal">KAPAT</button>
                    </div>
                    <div class="col-md-8 text-end p-0" id="base_btn">
                        <button type="button" id="iadeBarkodOlustur" class="btn btn-lg btn-primary ">İADE ET ve BARKOD
                            YAZDIR</button>
                    </div>
                    <div class="col-md-8 text-end p-0 d-none" id="btn_waiting">
                        <button class="btn btn-lg btn-primary" type="button" disabled=""><span
                                class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span><span>İşleminiz gerçekleştiriliyor...</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'shipment',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="' . route_to('tportal.shipment.create') . '" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Sevkiyat Emri Oluştur</a>
                                    <a href="' . route_to('tportal.shipment.list', 'all') . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Sevkiyat Listesi</a>'
            ],
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>

    number_format = function (number, decimals, dec_point, thousands_sep) {
        number = parseFloat(number);
        number = number.toFixed(decimals);


        var nstr = number.toString();
        nstr += '';
        x = nstr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? dec_point + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

        return x1 + x2;
    }

    $('#btn_delete_sale_order').on('click', function () {
        var invoice_id = $(this).attr('data-invoice-id');

        console.log("için gidiyoruz:", invoice_id);

        Swal.fire({
            title: 'Satış işlemini silmek üzeresiniz!',
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
                    type: 'POST',
                    url: '<?= route_to('tportal.cari.sale_order_delete') ?>',
                    data: {
                        invoice_id: invoice_id,
                    },
                    success: function (response, data) {
                        dataa = JSON.parse(response);
                        if (dataa.icon === "success") {
                            console.log(response);
                            console.log(data);
                            Swal.fire({
                                title: "İşlem Başarılı",
                                html: dataa.message,
                                confirmButtonText: "Tamam",
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                icon: "success",
                            })
                                .then(function () {
                                    // window.location.reload();
                                    (window.history.length > 1) ? window.history.back() : window.location.href = base_url + "/tportal/invoice/list/outgoing";
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
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        Swal.fire({
                            title: "Bir hata oluştu",
                            text: "sistemsel bir hata. daha sonra tekrar deneyiniz.",
                            confirmButtonText: "Tamam",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            icon: "error",
                        })
                    },
                });

            } else if (result.isCancel) {
                Swal.fire('Değişiklikler kaydedilmedi', '', 'info')
            }
        })
    });


    $('#btn_delete_return_sale_order').on('click', function () {
        var invoice_id = $(this).attr('data-invoice-id');
        var data_stock_barcode_id = $(this).attr('data-stock-barcode-id');
        var data_stock_movement_id = $(this).attr('data-stock-movement-id');

        Swal.fire({
            title: 'İade işlemini silmek üzeresiniz!',
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
                    type: 'POST',
                    url: '<?= route_to('tportal.cari.return_sale_order_delete') ?>',
                    data: {
                        invoice_id: invoice_id,
                        data_stock_barcode_id: data_stock_barcode_id,
                        data_stock_movement_id: data_stock_movement_id,
                    },
                    success: function (response, data) {
                        dataa = JSON.parse(response);
                        if (dataa.icon === "success") {
                            console.log(response);
                            console.log(data);
                            Swal.fire({
                                title: "İşlem Başarılı",
                                html: dataa.message,
                                confirmButtonText: "Tamam",
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                icon: "success",
                            })
                                .then(function () {
                                    // window.location.reload();
                                    (window.history.length > 1) ? window.history.back() : window.location.href = base_url + "/tportal/invoice/list/incoming";
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
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        Swal.fire({
                            title: "Bir hata oluştu",
                            text: "sistemsel bir hata. daha sonra tekrar deneyiniz.",
                            confirmButtonText: "Tamam",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            icon: "error",
                        })
                    },
                });

            } else if (result.isCancel) {
                Swal.fire('Değişiklikler kaydedilmedi', '', 'info')
            }
        })
    });



    $('.btn_fiyat').on('click', function () {

$('#mdl_price').modal('toggle');

// selectedStockBarcode = $('.rd_stock:checked').val();
selectedStockBarcodeId = $(this).attr('data-return-stock-barcode-id');
selectedStockBarcode = $(this).attr('data-stock-barcode');
selectedStockId = $(this).attr('data-stock-id');
selectedStockCode = $(this).attr('data-stock-code');
selectedStockTitle = $(this).attr('data-stock-title');
selected_birim = $(this).attr('data-stock-birim');
selected_unit = $(this).attr('data-stock-unit');
selectedStockQuantity = parseFloat($(this).attr('data-stock-amount'));
sale_unit_price_select = parseFloat($(this).attr('data-stock-sale'));
selectedStockReturnedQuantity = parseFloat($(this).attr('data-stock-returned-amount'));

selectedmoney_unit = $(this).attr('data-stock-money_unit');
degistirilecek_satir = $(this).attr('data-stock-rowid');





if (isNaN(selectedStockReturnedQuantity)) {
    selectedStockReturnedQuantity = 0;
}
selectedLastQuantity = selectedStockQuantity - selectedStockReturnedQuantity;


console.log(selectedStockBarcodeId);

$('#stock_barcode_ids').val(selectedStockBarcodeId);
$('#stock_bardodes').val(selectedStockBarcode.slice(0, <?= -get_user_number_length() ?>));
$('#stock_ids').val(selectedStockId);
$('#stock_codes').val(selectedStockCode);
$("#birim_tipis").html(selectedmoney_unit);
$('#stock_titles').val(selectedStockTitle);
$('#return_price').val(number_format(selected_unit, 2, ',', '.'));
$('#stock_satir_id').val(degistirilecek_satir);




});


    $('.btn_return').on('click', function () {

        $('#mdl_return').modal('toggle');

        // selectedStockBarcode = $('.rd_stock:checked').val();
        selectedStockBarcodeId = $(this).attr('data-return-stock-barcode-id');
        selectedStockBarcode = $(this).attr('data-stock-barcode');
        selectedStockId = $(this).attr('data-stock-id');
        selectedStockCode = $(this).attr('data-stock-code');
        selectedStockTitle = $(this).attr('data-stock-title');
        selected_birim = $(this).attr('data-stock-birim');
        selectedStockQuantity = parseFloat($(this).attr('data-stock-amount'));
        selectedStockReturnedQuantity = parseFloat($(this).attr('data-stock-returned-amount'));




        if (isNaN(selectedStockReturnedQuantity)) {
            selectedStockReturnedQuantity = 0;
        }
        selectedLastQuantity = selectedStockQuantity - selectedStockReturnedQuantity;


        console.log(selectedStockBarcodeId);

        $('#stock_barcode_id').val(selectedStockBarcodeId);
        $('#stock_bardode').val(selectedStockBarcode.slice(0, <?= -get_user_number_length() ?>));
        $('#stock_id').val(selectedStockId);
        $('#stock_code').val(selectedStockCode);
        $("#birim_tipi").html(selected_birim);
        $('#stock_title').val(selectedStockTitle);
        $('#return_quantity').val(number_format(selectedLastQuantity, 2, ',', '.'));

    });

    $('.all_return').on('click', function () {
        selectedLastQuantity = selectedStockQuantity - selectedStockReturnedQuantity;

        var dddd = number_format(selectedLastQuantity, 2, ',', '.');

        $('#return_quantity').val(dddd);
    });

    function printContent(content) {
        var w = window.open('', '_blank');
        w.document.write(content);
        setTimeout(function () {
            w.print();
        }, 300);
        // w.print();
    }

    $('#iadeBarkodOlustur').click(function (e) {
        e.preventDefault();
        var formData = $('#returnModalForm').serializeArray();
        console.log(formData);
        $('#btn_waiting').removeClass('d-none');
        $('#base_btn').addClass('d-none');

        var url = window.location.href;
        var lastSegment = url.split('/').filter(function (segment) {
            return segment !== ''; // Boş parçaları filtrele
        }).pop();

        formData.push({
            name: 'invoice_id',
            value: lastSegment,
        })

        if ($('#stock_quantity').val() != '' && $('#stock_quantity').val() != '0,0000' && $('#stock_quantity').val() != '0,00' && $('#supplier_id').val() != 0) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.cari.sale_order_return') ?>',
                dataType: 'json',
                data: {
                    data_form: formData,
                },
                async: true,
                success: function (response) {
                    if (response['icon'] == 'success') {

                        $('#btn_waiting').addClass('d-none');
                        $('#base_btn').removeClass('d-none');

                        $('#return_quantity').val();
                        $('#mdl_return').modal('toggle');

                        var timerInterval;
                        Swal.fire({
                            title: 'Barkod Oluşturuluyor',
                            html: 'Lütfen Oluşturulana kadar bekleyiniz..',
                            timer: 1000,
                            timerProgressBar: true,
                            onBeforeOpen: function onBeforeOpen() {
                                Swal.showLoading();
                                timerInterval = setInterval(function () {
                                    Swal.getContent().querySelector('b')
                                        .textContent = Swal.getTimerLeft();
                                }, 100);
                            },
                            onClose: function onClose() {
                                clearInterval(timerInterval);
                            }
                        }).then(function (result) {
                            if (
                                /* Read more about handling dismissals below */
                                result.dismiss === Swal.DismissReason.timer) {
                                console.log('I was closed by the timer'); // eslint-disable-line
                            }
                        });

                        setTimeout(function () {
                            printContent(response['barcode_html']);
                        }, 1000);

                        $("#trigger_stock_barcode_ok_button").trigger("click");
                    } else {
                        swetAlert("Bir Sorun Oluştu", response['message'], "err");

                        $('#btn_waiting').addClass('d-none');
                        $('#base_btn').removeClass('d-none');
                    }
                }
            })

        } else {
            $('#btn_waiting').addClass('d-none');
            $('#base_btn').removeClass('d-none');

            Swal.fire({
                title: "Uyarı!",
                html: 'Lütfen miktar alanını ve tedarikçi alanını boş bırakmayınız...',
                icon: "warning",
                confirmButtonText: 'Tamam',
            });


        }
    });




    $('#fiyatiGuncelle').click(function (e) {
        e.preventDefault();
        var formData = $('#FiyatModalForm').serializeArray();
        $('#btn_waiting').removeClass('d-none');
        $('#base_btn').addClass('d-none');

        var url = window.location.href;
        var lastSegment = url.split('/').filter(function (segment) {
            return segment !== ''; // Boş parçaları filtrele
        }).pop();

        formData.push({
            name: 'invoice_id',
            value: lastSegment,
        })

        if ($('#return_price').val() != '' && $('#return_price').val() != '0,0000' && $('#return_price').val() != '0,00' && $('#supplier_id').val() != 0) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.cari.sale_order_price') ?>',
                dataType: 'json',
                data: {
                    data_form: formData,
                },
                async: true,
                success: function (response) {
                    if (response['icon'] == 'success') {

                        $('#btn_waiting').addClass('d-none');
                        $('#base_btn').removeClass('d-none');

                        $('#return_quantity').val();
                        $('#mdl_price').modal('toggle');

                        var timerInterval;
                        Swal.fire({
                            title: 'Fiyat Güncelleniyor',
                            html: 'Lütfen Güncellenene kadar bekleyiniz..',
                            timer: 3000,
                            timerProgressBar: true,
                            onBeforeOpen: function onBeforeOpen() {
                                Swal.showLoading();
                                timerInterval = setInterval(function () {
                                    Swal.getContent().querySelector('b')
                                        .textContent = Swal.getTimerLeft();
                                }, 100);
                            },
                            onClose: function onClose() {
                                clearInterval(timerInterval);
                            }
                        }).then(function (result) {
                            if (
                                /* Read more about handling dismissals below */
                                result.dismiss === Swal.DismissReason.timer) {
                                console.log('I was closed by the timer'); // eslint-disable-line
                            }
                        });
                        Swal.fire({
                            title: "Başarılı!",
                            html: response['message'],
                            icon: "success",
                            confirmButtonText: 'Tamam',
                        }).then(function (result) {
                            location.reload();
                        });
                     

                    } else {
                        swetAlert("Bir Sorun Oluştu", response['message'], "err");

                        $('#btn_waiting').addClass('d-none');
                        $('#base_btn').removeClass('d-none');
                    }
                }
            })


        } else {
            $('#btn_waiting').addClass('d-none');
            $('#base_btn').removeClass('d-none');

            Swal.fire({
                title: "Uyarı!",
                html: 'Lütfen fiyat  alanını boş bırakmayınız...',
                icon: "warning",
                confirmButtonText: 'Tamam',
            });

            $('#return_price').focus();


        }
    });

</script>
<?= $this->endSection() ?>