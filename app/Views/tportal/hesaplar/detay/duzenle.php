<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Hesap Düzenle <?= $this->endSection() ?>
<?= $this->section('title') ?> Hesap Düzenle | <?= $financial_account_item['account_title'] ?><?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head nk-block-head-lg">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Hesap Düzenle</h4>

                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <form onsubmit="return false;" id="edit_account" method="post">
                                    <div class="card-inner position-relative card-tools-toggle p-0">
                                        <div class="gy-2">

                                        <div class="row g-3 align-center">
                                                <div class="col-lg-5 ">
                                                    <div class="form-group"><label class="form-label" for="account_title">Hesap Tipi</label><span class="form-note d-none d-md-block">Hesabın ait olduğu tip.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" name="" id="" value="<?php switch ($financial_account_item['account_type']) {
                                                    case 'vault':
                                                        echo "Kasa";
                                                        break;
                                                    case 'bank':
                                                        echo "Banka";
                                                        break;
                                                    case 'pos':
                                                        echo "POS";
                                                        break;
                                                        case 'check_bill':
                                                            echo "ÇEK/SENET";
                                                            break; 
                                                    case 'credit_card':
                                                        echo "Kredi Kartı";
                                                        break;
                                                } ?>" placeholder="ENPARA ŞİRKETİM vb." disabled></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 ">
                                                    <div class="form-group"><label class="form-label" for="account_title">Hesap Adı</label><span class="form-note d-none d-md-block">Seçerken kolaylık sağlayacak bir ad.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" name="account_title" id="account_title" value="<?= $financial_account_item['account_title'] ?>" placeholder="ENPARA ŞİRKETİM vb."></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($financial_account_item['account_type'] != 'check_bill'): ?>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 ">
                                                    <div class="form-group"><label class="form-label" for="bank_iban">IBAN</label><span class="form-note d-none d-md-block">Banka iban bilgilsi.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" name="bank_iban" id="bank_iban" value="<?= $financial_account_item['bank_iban'] ?>" placeholder="TR00 0000 0000 0000 0000 0000 00"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 col-xxl-5 ">
                                                    <div class="form-group"><label class="form-label" for="bank_branch">Banka Şubesi</label>
                                                        <span class="form-note d-none d-md-block">Banka şube bilgilsi.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" id="bank_branch" name="bank_branch" value="<?= $financial_account_item['bank_branch'] ?>" placeholder="İstanbul/İstoç">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-5 ">
                                                    <div class="form-group"><label class="form-label" for="bank_account_number">Banka Hesap No</label><span class="form-note d-none d-md-block">Banka hesap bilgilsi.</span>
                                                    </div>
                                                </div>
                                                <div class="col mt-0 mt-md-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" name="bank_account_number" id="bank_account_number" value="<?= $financial_account_item['bank_account_number'] ?>" placeholder="ENPARA ŞİRKETİM vb."></div>
                                                    </div>
                                                </div>
                                            </div>
                                                <?php endif; ?>
                                        </div>
                                    </div><!-- .card-inner -->
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <!-- <a href="javascript:history.back()" class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Geri</span></a>  -->
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <div class="form-group">
                                                    <button type="submit" id="saveAccount" class="btn btn-lg btn-primary">Kaydet</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                </form>
                            </div><!-- .nk-block -->
                        </div>
                        <?= $this->include('tportal/hesaplar/detay/inc/sol_menu') ?>
                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<button type="button" id="triggerModal" class="btn btn-success d-none" data-bs-toggle="modal" data-bs-target="#musteriOK">OK</button>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" id="musteriOK">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                    <h4 class="nk-modal-title">İşlem Başarılı!</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text">Cari Başarıyla Güncellendi </div>

                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'edit_payment_or_collection',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'Hesap bilgileri başarıyla güncellendi',
                'modal_buttons' => '<a href="' . route_to('tportal.financial_accounts.detail', $financial_account_item['financial_account_id']) . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Hesap Bilgilerini Göster</a>'
            ],
        ],
    ]
); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    $('#saveAccount').click(function(e) {
        e.preventDefault();

        if ($('#account_title').val() == '' ) {
            swetAlert("Eksik Bir Şeyler Var", "Lütfen Tüm Alanları Doldurunuz! ", "err");
        } else {
            var formData = $('#edit_account').serializeArray();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                type: 'POST',
                url: '<?= route_to('tportal.financial_accounts.edit', $financial_account_item['financial_account_id']) ?>',
                dataType: 'json',
                data: formData,
                async: true,
                success: function(response) {
                    if (response['icon'] == 'success') {
                        $("#trigger_edit_payment_or_collection_ok_button").click();
                    } else {
                        swetAlert("Bir Şeyler Ters Gitti", response["message"], "err");
                    }
                }
            })
        }
    });
</script>

<?= $this->endSection() ?>