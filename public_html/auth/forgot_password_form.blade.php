@extends('layouts.auth')

@section('page_title', 'Şifremi Unuttum')

@section('content')

    <div class="nk-block-head pb-3">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title">Şifremi Unuttum</h5>
            <div class="nk-block-des">
                <p>Sistemimize kayıtlı e-posta adresinizi giriniz.</p>
            </div>
        </div>
    </div><!-- .nk-block-head -->

    <form id="forgotPasswordForm" class="form-validate is-alter" autocomplete="off">

        <div class="form-group">
            <div class="form-control-wrap focused">
                <input type="hidden" id="token" name="txt_token" value="{{ $token }}" />
                <input type="text" autocomplete="off" class="form-control form-control-xl form-control-outlined valid" id="txt_email" name="txt_email" placeholder="E-posta Adresinizi Giriniz" value="{{ $email }}" readonly="readonly" />
                <label class="form-label-outlined" for="email">E-posta</label>
            </div>
        </div>

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

        <x-auth.alert_genel/>

        <div class="form-group">
            <button id="submitButton" class="btn btn-lg btn-primary btn-block" type="submit">Şifremi Sıfırla</button>
        </div>
    </form><!-- form -->

    <div class="text-center pt-4">
        <span class="fw-500"><b><a href="/forgot-password" class="link_refs">Şifremi Unuttum</a></b></span>
    </div>

    <div class="text-center pt-3 pb-3">
        <h6 class="overline-title overline-title-sap"><span>Sistemimize kayıtlı değil misiniz?</span></h6>
    </div>
    <form action="#">
        <div class="form-group">
            <a href="{{ route('auth.register') }}" class="link_refs btn btn-lg btn-block btn-secondary"><span>Kayıt Olmak için Tıklayın</span><em class="icon ni ni-arrow-right"></em></a>
        </div>
    </form><!-- form -->

    <div class="text-center pt-3 pb-3">
        <h6 class="overline-title overline-title-sap"><span>VEYA</span></h6>
    </div>
    <form action="#">

        <div class="form-group">
            <a href="#" class="link_refs btn btn-lg btn-block btn-dim btn-outline-secondary"><em class="icon ni ni-arrow-left"></em><span>Diğer Seçenekler için Tıklayın</span></a>

        </div>
    </form><!-- form -->

@endsection

@section('script')

<x-auth.page_script/>

<script>
    $("document").ready(function () {
        $("#forgotPasswordForm").submit(function (e) {

            alert_temizle();

            if ($('#txt_email').val() == '') {
                alert_uyari('Lütfen <strong>' + $("label[for='txt_email']").html() + '</strong> Kısmını Boş Bırakmayınız.!');
                $('#txt_email').focus();
                return false;
            } else {
                if(IsEmail($('#txt_email').val()) == false){
                    alert_uyari('Lütfen <strong>' + $("label[for='txt_email']").html() + '</strong> Kısmını Kontrol Ediniz.!');
                    $('#txt_email').focus();
                    return false;
                }
            }

            if ($('#txt_sifre').val() == '') {
                alert_uyari('Lütfen <strong>Şifre</strong> Kısmını Boş Bırakmayınız.!');
                $('#txt_sifre').focus();
                return false;
            } else {
                if ($('#txt_sifre').val().length < 6) {
                    alert_uyari('Lütfen <strong>Şifreniz</strong> En Az 6 Karakterden Oluşmalı.!');
                    $('#txt_sifre').focus();
                    return false;
                }
            }

            if ($('#txt_sifre_tekrar').val() == '') {
                alert_uyari('Lütfen <strong>Şifre Tekrar Kısmı</strong> Kısmını Boş Bırakmayınız.!');
                $('#txt_sifre_tekrar').focus();
                return false;
            }

            if ($('#txt_sifre').val() != $('#txt_sifre_tekrar').val()) {
                alert_uyari('Lütfen <strong>Şifre</strong> ve <strong>Şifre Tekrar</strong> Kısımları Eşleşmiyor.!');
                $('#txt_sifre_tekrar').focus();
                return false;
            }

            $('#submitButton').prop('disabled', true);

            $.ajax({
                type: "POST",
                url: " {{ route("password.reset.post") }} ",
                data: $(this).serialize(),
                dataType: 'json',
                async: true,
                success: function (data) {
                    if (data.success) {
                        alert_basarili('<strong>' + data.title + '</strong> ' + data.message);
                    } else {
                        alert_uyari('<strong>' + data.title + '</strong> ' + data.message);
                        $('#submitButton').prop('disabled', false);
                    }
                },
                error: function (data) {
                    alert_uyari('<strong>Parola sıfırlarken yapılırken bir hata oluştu.</strong>');
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
