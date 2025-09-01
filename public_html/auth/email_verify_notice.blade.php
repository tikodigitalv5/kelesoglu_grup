@extends('layouts.auth')

@section('page_title', 'E-Posta Onaylama')

@section('content')

    <div class="nk-block-head pb-3">
        <div class="nk-block-head-content">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">E-Posta Onaylaması</h5>
                <div class="nk-block-des text-info">
                    <p>
                        Üye kaydınız başarıyla oluşturuldu.
                        Lütfen size gönderilen e-postadan üyeliğinizi onaylayın.
                    </p>
                </div>
            </div>
        </div>
    </div><!-- .nk-block-head -->

    <div class="form-group">
        <button id="resendEmail" class="btn btn-lg btn-primary btn-block" type="submit">Onaylama E-Postasını Tekrar Gönder</button>
    </div>

@endsection

@section('script')

<script>
    $("document").ready(function () {

        $("#resendEmail").click(function (e) {

            $(this).attr("disabled", true);

            $.ajax({
                type: "POST",
                url: " {{ route('verification.resend') }}",
                data: $(this).serialize(),
                dataType: 'json',
                async: true,
                success: function (data) {
                    if (data.success) {
                        toastr_uyariver('success', 'İstek Başarılı', data.message);
                    } else {
                        toastr_uyariver('error', 'İstek Başarısız', data.message);
                    }
                    $(this).attr("disabled", false);
                },
                error: function (data) {
                    toastr_uyariver('error', 'İstek Başarısız', 'Sistemsel bir sıkıntı oluştu');
                    $(this).attr("disabled", false);
                }
            });

            e.preventDefault();

        })
    })
</script>
@endsection

@section('footer')

@endsection
