@extends('layouts.auth')

@section('page_title', 'Giriş Yap')

@section('content')

    <div class="nk-block-head pb-3">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title">E-posta ile Giriş</h5>
            <div class="nk-block-des">
                <p>Sistemimizde kayıtlı e-posta ve şifreniz ile giriş yapabilirsiniz.</p>
            </div>
        </div>
    </div><!-- .nk-block-head -->

    <form id="loginForm" class="form-validate is-alter" autocomplete="off">
        <div class="form-group">
            <div class="form-control-wrap focused">
                <input type="text" autocomplete="off" class="form-control form-control-xl form-control-outlined valid" id="email" name="txt_email" placeholder="E-posta Adresinizi Giriniz">
                <label class="form-label-outlined" for="email">E-posta</label>
            </div>
        </div><!-- .form-group -->
        <div class="form-group">
            <div class="form-label-group d-none">
                <label class="form-label" for="password"></label>
                <a tabindex="-1" href="#" class="passcode-switch lg" data-target="password">Şifreyi Göster</a>
            </div>
            <div class="form-control-wrap focused">
                <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch xl" data-target="password">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input autocomplete="new-password" type="password" class="form-control form-control-xl form-control-outlined" id="password" name="txt_password" placeholder="Şifrenizi Giriniz">
                <label class="form-label-outlined" for="password">Şifre</label>
            </div>
        </div><!-- .form-group -->
        <div class="form-group">
            <div class="custom-control custom-control-xs custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="beni_hatirla" id="chk_beni_hatirla">
                <label class="custom-control-label" for="chk_beni_hatirla">Beni Hatırla</label>
            </div>
        </div>

        <x-auth.alert_genel/>

        <div class="form-group">
            <button id="loginSubmitBtn" class="btn btn-lg btn-primary btn-block" type="submit">Giriş Yap</button>
        </div>
    </form><!-- form -->

    <div class="text-center pt-4">
        <span class="fw-500"><b><a href="{{ route("auth.forgot_password") }}" class="link_refs">Şifremi Unuttum</a></b></span>
    </div>

    <div class="text-center pt-3 pb-3">
        <h6 class="overline-title overline-title-sap"><span>Sistemimize kayıtlı değil misiniz?</span></h6>
    </div>
    <form action="#">

        <div class="form-group">
            <a href="{{ route('auth.register') }}" class="link_refs btn btn-lg btn-block btn-secondary"><span>Kayıt Olmak için Tıklayın</span><em class="icon ni ni-arrow-right"></em></a>
        </div>
    </form><!-- form -->

    {{-- <div class="text-center pt-3 pb-3">
        <h6 class="overline-title overline-title-sap"><span>VEYA</span></h6>
    </div>
    <form action="#">
        <div class="form-group">
            <a href="#" class="link_refs btn btn-lg btn-block btn-dim btn-outline-secondary"><em class="icon ni ni-arrow-left"></em><span>Diğer Seçenekler için Tıklayın</span></a>
        </div>
    </form><!-- form --> --}}

@endsection

@section('script')

<x-auth.page_script/>

<script>
    $("document").ready(function () {
        $("#loginForm").submit(function (e) {

            alert_temizle();
            $('#submitButton').prop('disabled', true);
            butonBeklemede("#loginSubmitBtn", "Giriş Yapılıyor");

            if ($('#email').val() == '') {
                alert_uyari('Lütfen <strong>' + $("label[for='email']").html() + '</strong> Kısmını Boş Bırakmayınız.!');
                $('#email').focus();
                butonSifirla("#loginSubmitBtn", "Giriş Yap");
                return false;
            } else {
                if(IsEmail($('#email').val()) == false){
                    alert_uyari('Lütfen <strong>' + $("label[for='email']").html() + '</strong> Kısmını Kontrol Ediniz.!');
                    $('#email').focus();
                    butonSifirla("#loginSubmitBtn", "Giriş Yap");
                    return false;
                }
            }

            if ($('#password').val() == '') {
                alert_uyari('Lütfen <strong>Şifre</strong> Kısmını Boş Bırakmayınız.!');
                $('#password').focus();
                butonSifirla("#loginSubmitBtn", "Giriş Yap");
                return false;
            }

            $.ajax({
                type: "POST",
                url: " {{ route("auth.login.post") }} ",
                data: $(this).serialize(),
                dataType: 'json',
                async: true,
                success: function (data) {
                    if (data.success) {
                        alert_basarili('<strong>' + data.title + '</strong> ' + data.message);
                        window.location = "{{ route ('index') }}";
                    } else {
                        alert_uyari('<strong>' + data.title + '</strong> ' + data.message);
                        butonSifirla("#loginSubmitBtn", "Giriş Yap");
                    }
                },
                error: function (data) {
                    alert_uyari('<strong>Giriş yapılırken bir hata oluştu.</strong>');
                    butonSifirla("#loginSubmitBtn", "Giriş Yap");
                }
            });

            e.preventDefault();

         })
    })
</script>
@endsection

@section('footer')

@endsection
