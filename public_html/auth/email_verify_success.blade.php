@extends('layouts.auth')

@section('page_title', 'E-Posta Onaylandı')

@section('content')

    <div class="nk-block-head pb-3">
        <div class="nk-block-head-content">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">E-Posta Onaylandı</h5>
                <div class="nk-block-des text-info">
                    <p>
                        E-Postanız Başarıyla Onaylandı.
                        Sistemimizi kullanmaya başlayabilirsiniz.
                    </p>
                </div>
            </div>
        </div>
    </div><!-- .nk-block-head -->

    <div class="form-group">
        <button id="goHome" class="btn btn-lg btn-primary btn-block" type="submit">Anasayfaya Gitmek İçin Tıklayınız</button>
    </div>

@endsection

@section('script')

<script>
    $("document").ready(function () {

        $("#goHome").click(function (e) {

            window.location.href = "/";

         })
    })
</script>
@endsection

@section('footer')

@endsection
