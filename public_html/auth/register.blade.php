@extends('layouts.auth')

@section('page_title', 'Kayıt Ol')

@section('content')

    <div class="nk-block-head pb-3">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title">Ücretsiz Kayıt</h5>
            <div class="nk-block-des">
                <p>Şuanda sadece sisitemimize üye oluyorsunuz. </p>
            </div>
        </div>
    </div><!-- .nk-block-head -->

    <form id="registerForm" class="form-validate is-alter" autocomplete="off">

        <div class="form-group">
            <div class="form-control-wrap focused">
                <input type="text" autocomplete="off" class="form-control form-control-xl form-control-outlined" id="txt_adsoyad" name="txt_adsoyad" placeholder="Adınızı ve Soyadınızı Giriniz">
                <label class="form-label-outlined" for="txt_adsoyad">Ad Soyad</label>
            </div>
        </div><!-- .form-group -->
        <div class="form-group">
            <div class="form-control-wrap focused">
                <input type="text" class="form-control form-control-xl form-control-outlined phone" id="txt_gsm" name="txt_gsm" placeholder="Telefon Numaranızı Giriniz" telephone_number />
                <label class="form-label-outlined" for="txt_gsm">Gsm Numaranız</label>
            </div>
        </div>
        <div class="form-group">
            <div class="form-control-wrap focused">
                <input type="text" autocomplete="off" class="form-control form-control-xl form-control-outlined" id="txt_email" name="txt_email" placeholder="E-posta Adresinizi Giriniz">
                <label class="form-label-outlined" for="txt_email">E-posta</label>
            </div>
        </div><!-- .form-group -->
        <div class="form-group">
            <div class="form-label-group d-none">
                <label class="form-label" for="txt_sifre"></label>
                <a tabindex="-1" href="#" class="passcode-switch lg" data-target="txt_sifre">Şifreyi Göster</a>
            </div>
            <div class="form-control-wrap focused">
                <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch xl" data-target="txt_sifre">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input autocomplete="new-password" type="password" class="form-control form-control-xl form-control-outlined" id="txt_sifre" name="txt_sifre" placeholder="Şifrenizi Giriniz">
                <label class="form-label-outlined" for="txt_sifre">Şifre</label>
            </div>
        </div><!-- .form-group -->
        <div class="form-group">
            <div class="form-label-group d-none">
                <label class="form-label" for="txt_sifre_tekrar"></label>
                <a tabindex="-1" href="#" class="passcode-switch lg" data-target="txt_sifre_tekrar">Şifreyi Göster</a>
            </div>
            <div class="form-control-wrap focused">
                <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch xl" data-target="txt_sifre_tekrar">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input autocomplete="new-password" type="password" class="form-control form-control-xl form-control-outlined" id="txt_sifre_tekrar" name="txt_sifre_tekrar" placeholder="Şifrenizi Tekrar Giriniz">
                <label class="form-label-outlined" for="txt_sifre_tekrar">Şifre Tekrar</label>
            </div>
        </div><!-- .form-group -->
        <div class="form-group">
            <div class="custom-control custom-control-xs custom-checkbox checked">
                <input type="checkbox" class="custom-control-input" id="chk_uyelik_sozlesmesi" name="chk_uyelik_sozlesmesi" checked="checked">
                <label class="custom-control-label" for="chk_uyelik_sozlesmesi"><a href="https://earsivportal.net/tr/sayfa/kullanici-sozlesmesi" target="_blank">Üyelik Sözleşmesi</a> şartlarını okudum ve kabul ediyorum.</label>
            </div>
        </div>

        <x-auth.alert_genel/>

        <div class="form-group">
            <button id="submitButton" type="submit" class="btn btn-lg btn-primary btn-block">KAYDET</button>
        </div>
    </form>

    <div class="text-center pt-3 pb-3">
        <h6 class="overline-title overline-title-sap"><span>VEYA</span></h6>
    </div>
    <form action="#">
        <div class="form-group">
            <a href="{{ route('auth.login') }}" class="link_refs btn btn-lg btn-block btn-dim btn-outline-secondary"><em class="icon ni ni-arrow-left"></em><span>Giriş Yapmak için Tıklayın</span></a>
        </div>
    </form>

@endsection

@section('script')

<x-auth.page_script/>

<script>
    $("document").ready(function () {

        $("#registerForm").submit(function (e) {

            $('#submitButton').prop('disabled', true);

            alert_temizle();

            if ($('#txt_adsoyad').val() == '') {
                alert_uyari('Lütfen <strong>' + $("label[for='txt_adsoyad']").html() + '</strong> Kısmını Boş Bırakmayınız.!');
                $('#txt_adsoyad').focus();
                $('#submitButton').prop('disabled', false);
                return false;
            }

            if ($('#txt_gsm').val() == '') {
                alert_uyari('Lütfen <strong>' + $("label[for='txt_gsm']").html() + '</strong> Kısmını Boş Bırakmayınız.!');
                $('#txt_gsm').focus();
                $('#submitButton').prop('disabled', false);
                return false;
            }

            if (!$('#txt_gsm').inputmask("isComplete")){
                alert_uyari('Lütfen <strong>' + $("label[for='txt_gsm']").html() + '</strong> Kısmı Geçerli Değil!');
                $('#txt_gsm').focus();
                $('#submitButton').prop('disabled', false);
                return false;
            }

            if ($('#txt_email').val() == '') {
                alert_uyari('Lütfen <strong>' + $("label[for='txt_email']").html() + '</strong> Kısmını Boş Bırakmayınız.!');
                $('#txt_email').focus();
                $('#submitButton').prop('disabled', false);
                return false;
            } else {
                if(IsEmail($('#txt_email').val()) == false){
                    alert_uyari('Lütfen <strong>' + $("label[for='txt_email']").html() + '</strong> Kısmını Kontrol Ediniz.!');
                    $('#txt_email').focus();
                    $('#submitButton').prop('disabled', false);
                    return false;
                }
            }

            if ($('#txt_sifre').val() == '') {
                alert_uyari('Lütfen <strong>Şifre</strong> Kısmını Boş Bırakmayınız.!');
                $('#txt_sifre').focus();
                $('#submitButton').prop('disabled', false);
                return false;
            } else {
                if ($('#txt_sifre').val().length < 6) {
                    alert_uyari('Lütfen <strong>Şifreniz</strong> En Az 6 Karakterden Oluşmalı.!');
                    $('#txt_sifre').focus();
                $('#submitButton').prop('disabled', false);
                    return false;
                }
            }

            if ($('#txt_sifre_tekrar').val() == '') {
                alert_uyari('Lütfen <strong>Şifre Tekrar Kısmı</strong> Kısmını Boş Bırakmayınız.!');
                $('#txt_sifre_tekrar').focus();
                $('#submitButton').prop('disabled', false);
                return false;
            }

            if ($('#txt_sifre').val() != $('#txt_sifre_tekrar').val()) {
                alert_uyari('Lütfen <strong>Şifre</strong> ve <strong>Şifre Tekrar</strong> Kısımları Eşleşmiyor.!');
                $('#txt_sifre_tekrar').focus();
                $('#submitButton').prop('disabled', false);
                return false;
            }

            if (!$('#chk_uyelik_sozlesmesi').is(':checked')) {
                alert_uyari('Lütfen <strong>' + $("label[for='chk_uyelik_sozlesmesi']>span").html() + '</strong> Kısmını Boş Bırakmayınız.!');
                $('#chk_uyelik_sozlesmesi').focus();
                $('#submitButton').prop('disabled', false);
                return false;
            }

            $.ajax({
                type: "POST",
                url: " {{ route("auth.register.post") }} ",
                data: $(this).serialize(),
                dataType: 'json',
                async: true,
                success: function (data) {
                    if (data.success) {
                        return Swal.fire({
                            title: data.title,
                            text: "Üyeliğiniz başarıyla oluşturuldu. Yönlendiriliyorsunuz...",
                            showConfirmButton: false,
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true
                        }).then(function() {
                            window.location = "{{ route('e-fatura.index') }}";
                        });
                    } else {
                        alert_uyari('<strong>' + data.title + '</strong> ' + data.message);
                        $('#submitButton').prop('disabled', false);
                    }
                },
                error: function (data) {
                    alert_uyari('<strong>Sistemsel bir hata oluştu.</strong>');
                    $('#submitButton').prop('disabled', false);
                }
            });

            e.preventDefault();

         })
    })
</script>
@endsection

@section('footer')

@endsection
