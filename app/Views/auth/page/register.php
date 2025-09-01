<?= $this->extend('auth/layout') ?>
<?= $this->section('page_title') ?> Ücretsiz Kayıt <?= $this->endSection() ?>
<?= $this->section('title') ?> Ücretsiz Kayıt <?= $this->endSection() ?>
<?= $this->section('subtitle') ?>Şuanda sadece sisitemimize üye oluyorsunuz. <?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="form-validate is-alter" autocomplete="off">
    <div class="form-group">
        <div class="form-control-wrap focused">
            <input type="text" autocomplete="off" name="firma_adi" placeholder="Firma Adınızı Giriniz"
                class="form-control form-control-xl form-control-outlined valid" id="firma_adi">
            <label class="form-label-outlined" for="firma_adi">Firma Adı</label>
        </div>
    </div><!-- .form-group -->
    <div class="form-group">
        <div class="form-control-wrap focused">
            <input type="text" autocomplete="off" name="user_adsoyad" placeholder="Adınızı ve Soyadınızı Giriniz"
                class="form-control form-control-xl form-control-outlined valid" id="user_adsoyad">
            <label class="form-label-outlined" for="user_adsoyad">Ad Soyad</label>
        </div>
    </div><!-- .form-group -->
    <div class="form-group">
        <div class="form-control-wrap focused">
            <input type="text" autocomplete="off" name="user_telefon" placeholder="Telefon Numaranızı Giriniz"
                class="form-control form-control-xl form-control-outlined valid" id="user_telefon">
            <label class="form-label-outlined" for="user_telefon">Gsm Numaranız</label>
        </div>
    </div><!-- .form-group -->
    <div class="form-group">
        <div class="form-control-wrap focused">
            <input type="text" autocomplete="off" name="user_eposta" placeholder="E-posta Adresinizi Giriniz"
                class="form-control form-control-xl form-control-outlined valid" id="user_eposta">
            <label class="form-label-outlined" for="user_eposta"><?= lang('auth.eposta_adresi') ?></label>
        </div>
    </div><!-- .form-group -->
    <div class="form-group">

        <div class="form-control-wrap  focused">
            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch xl" data-target="user_password">
                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
            </a>
            <input type="password" class="form-control form-control-xl form-control-outlined"
                placeholder="Şifreyi Giriniz" id="user_password" name="user_password">
            <label class="form-label-outlined" for="user_password"><?= lang('auth.sifre') ?></label>
        </div>
    </div><!-- .form-group -->
    <div class="form-group">

        <div class="form-control-wrap focused">
            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch xl" data-target="password_check">
                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
            </a>
            <input type="password" class="form-control form-control-xl form-control-outlined"
                placeholder="Şifreyi Tekrar Giriniz" id="password_check" name="password_check">
            <label class="form-label-outlined" for="password_check">Şifre Tekrar</label>
        </div>
    </div><!-- .form-group -->

    <div class="form-group">
        <div class="btn btn-lg btn-primary btn-block" id="btn_giris">KAYDET</div>
    </div>
</div>
<div class="text-center pt-4 pb-2">
    <h6 class="overline-title overline-title-sap"><span>Sistemimize zaten kayıtlı mısınız?</span></h6>
</div>
<div class="form-group">
    <a href="<?= route_to('tportal.auth.login') ?>" class="link_refs btn btn-lg btn-block btn-secondary"><span>Giriş
            Yapmak için Tıklayın</span><em class="icon ni ni-arrow-right"></em></a>
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
        url: '<?= route_to('tportal.auth.checkRegister') ?>',
        dataType: 'json',
        data: {
            user_eposta: $('#user_eposta').val(),
            user_telefon: $('#user_telefon').val(),
            user_adsoyad: $('#user_adsoyad').val(),
            firma_adi: $('#firma_adi').val(),
            user_password: $('#user_password').val(),
            password_check: $('#password_check').val(),
        },
        async: true,
        success: function(response) {
            if (response['icon'] == 'success') {
                window.location.href = '<?= route_to('tportal.login') ?>'
            } else {
                alert_uyari(
                    '<strong>' + response['message'] + '</strong>, <?= lang('alert.lutfen_kontrol_ediniz') ?>'
                    );
                return false;
            }
        }
    })


});
</script>

<?= $this->endSection() ?>