<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Sevkiyat Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Sevkiyat Detay | SVK0342342344 <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>
<?= $this->section('main') ?>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner">
                            <div class="row g-3 align-center">
                                <div class="col-lg-3 col-xxl-3 ">
                                    <div class="form-group">
                                        <label class="form-label" for="site-name">Depo</label>
                                        <span class="form-note d-none d-md-block">Sekiyatı yapılan depo.</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 mt-0 mt-md-2">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <input type="text" id="musteriAdi" class="form-control form-control-xl"
                                                    value="Merter Mağaza" placeholder="" disabled="">
                                                <input type="hidden" id="musteriID" name="musteri_id"
                                                    class="form-control form-control-xl">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="gy-3">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label"
                                                for="site-name">Ürün</label><span
                                                class="form-note d-none d-md-block">Sevkini kabul etmek istediğiniz
                                                ürünün barkodu okutunuz.</span></div>
                                    </div>
                                    <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <input type="text" id="txt_barkod_oku"
                                                    class="form-control form-control-xl"
                                                    placeholder="Sevk girmek istediğiniz barkodu okutunuz.">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-6 col-xxl-6  col-12">
                                    <div class="col-lg-12 col-xxl-12  pb-2">
                                        <div class="form-group"><label class="form-label"
                                                for="site-name">Sevkler</label>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="invoice-bills">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Ürün Kodu</th>
                                                        <!-- <th >Ürün Adı</th> -->
                                                        <th class="w-150px">Miktar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>E23101000008964 | <b class="fw-bold">ANTRASIT ALMUS NAPA</b>
                                                        </td>
                                                        <!-- <td>TROMBOLİN 500 (5 cm.)</td> -->
                                                        <td class="fw-bold"><a class="">618,00 </a></td>

                                                    </tr>
                                                    <tr>
                                                        <td>E23101000008965 | <b class="fw-bold">ANTRASIT ALMUS NAPA</b>
                                                        </td>
                                                        <!-- <td>TROMBOLİN 500 (5 cm.)</td> -->
                                                        <td class="fw-bold"><a class="">598,00 </a></td>

                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="1" class="text-right"></td>
                                                        <td class="fw-bold">1000 dm<sup>2</sup></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xxl-6  col-12">
                                    <div class="col-lg-12 col-xxl-12  pb-2">
                                        <div class="form-group">
                                            <label class="form-label" for="site-name">Sevk </label>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="invoice-bills">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="tum_sevkler" sevkid="1">
                                                <thead>
                                                    <tr>
                                                        <th>Ürün Kodu</th>
                                                        <!-- <th >Ürün Adı</th> -->
                                                        <th class="w-150px">Miktar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="text-right text-uppercase">Toplam</td>
                                                        <td class="fw-bold">0 m.</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 align-center pt-5 d-none">
                                <div class="col-lg-3 col-xxl-3 ">
                                    <div class="form-group"><label class="form-label" for="site-name">Sipariş
                                            Notu</label><span class="form-note d-none d-md-block">Sipariş ile ilgili
                                            notunuz varsa yazınız.</span></div>
                                </div>
                                <div class="col-lg-9 col-xxl-9 mt-0 mt-md-2">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <textarea class="form-control form-control-xl no-resize"
                                                id="default-textarea"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 align-center pt-5">
                                <div class="col-lg-3 col-xxl-3 ">
                                    <div class="form-group"><label class="form-label" for="site-name">Sevkiyat
                                            Notu</label><span class="form-note d-none d-md-block">Sevkiyat ile ilgili
                                            notunuz varsa yazınız.</span></div>
                                </div>
                                <div class="col-lg-9 col-xxl-9 mt-0 mt-md-2">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <textarea disabled="" class="form-control form-control-xl no-resize"
                                                name="sevkiyatNotu" id="default-textarea"></textarea>
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
                            <div class="col-6 text-right">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary">Kaydet</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- .card-inner -->
                </div>
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>

</script>
<?= $this->endSection() ?>