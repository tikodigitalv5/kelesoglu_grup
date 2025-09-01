<?= $this->extend('auth/layout') ?>
<?= $this->section('page_title') ?> E-posta ile Giriş <?= $this->endSection() ?>
<?= $this->section('title') ?> E-posta ile Giriş <?= $this->endSection() ?>
<?= $this->section('subtitle') ?>Sistemimizde kayıtlı e-posta ve şifreniz ile giriş yapabilirsiniz.
<?= $this->endSection() ?>

<?= $this->section('page_title') ?> Giriş <?= $this->endSection() ?>

<?= $this->section('title') ?> Üye Girişi<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>Sistemimizdeki e-posta adresinizi ve şifrenizi giriniz. <?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="form-validate is-alter" autocomplete="off">
    <div class="form-group">
        <div class="form-control-wrap focused">
            <input type="text" autocomplete="off" name="user_eposta"
                class="form-control form-control-xl form-control-outlined valid" id="user_eposta">
            <label class="form-label-outlined" for="user_eposta"><?= lang('auth.eposta_adresi') ?></label>
        </div>
    </div><!-- .form-group -->
    <div class="form-group">

        <div class="form-control-wrap">
            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch xl" data-target="user_password">
                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
            </a>
            <input type="password" class="form-control form-control-xl form-control-outlined" id="user_password"
                name="user_password">
            <label class="form-label-outlined" for="user_password"><?= lang('auth.sifre') ?></label>
        </div>
    </div><!-- .form-group -->
    <div class="form-group">
        <div class="custom-control custom-control-xs custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="beni_hatirla" id="chk_beni_hatirla">
            <label class="custom-control-label" for="chk_beni_hatirla"><?= lang('auth.beni_hatirla') ?></label>
        </div>
    </div>
    <div class="form-group">
        <div class="btn btn-lg btn-primary btn-block" id="btn_giris"><?= lang('auth.giris_yap') ?></div>
    </div>
</div>
<div class="text-center pt-4 pb-2">
    <h6 class="overline-title overline-title-sap"><span>Sistemimize kayıtlı değil misiniz?</span></h6>
</div>
<div class="form-group">
    <a href="<?= route_to('tportal.auth.register') ?>" class="link_refs btn btn-lg btn-block btn-secondary"><span>Kayıt
            Olmak için Tıklayın</span><em class="icon ni ni-arrow-right"></em></a>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>


<script>
alert_temizle();

$('.form-control').keyup(function(e) {
    // alert(e.which);
    e.preventDefault();
    if (e.which == 13) {
        $('#btn_giris').trigger('click');
    }
});

$('#btn_giris').click(function(e) {
    e.preventDefault();
    alert_temizle();

    if ($('#user_eposta').val() == '') {
        alert_uyari('<strong>' + $("label[for='user_eposta']").html() +
            '</strong>, <?= lang('alert.lutfen_bos_birakmayiniz') ?>');
        $('#user_eposta').focus();
        return false;
    } else {
        if (IsEmail($('#user_eposta').val()) == false) {
            alert_uyari('<strong>' + $("label[for='user_eposta']").html() +
                '</strong>, <?= lang('alert.lutfen_kontrol_ediniz') ?>');
            $('#user_eposta').focus();
            return false;
        }
    }

    if ($('#user_password').val() == '') {
        alert_uyari('<strong>' + $("label[for='user_password']").html() +
            '</strong>, <?= lang('alert.lutfen_bos_birakmayiniz') ?>');
        $('#user_password').focus();
        return false;
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        type: 'POST',
        url: '<?= route_to('tportal.auth.checkLogin') ?>',
        dataType: 'json',
        data: {
            user_eposta: $('#user_eposta').val(),
            user_password: $('#user_password').val()
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                window.location.href = '<?= route_to('tportal.dashboard') ?>'
            } else {
                alert_uyari(
                    '<strong>'+response.message+'</strong>'
                    );
                $('#user_eposta').focus();
                return false;
            }
        }
    })


});
</script>

<?= $this->endSection() ?>