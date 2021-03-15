@extends("layout.app", ["title" => "Beranda"])

@section("before-content")
    @guest
        <div class="modal fade" id="modal-tutorial" tabindex="-1" role="dialog" aria-labelledby="modal-tutorial-title" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-tutorial-title">Cara Mendapatkan Cookie Facebook</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <p>
                                1). Install <a href="https://play.google.com/store/apps/details?id=com.kiwibrowser.browser" target="_blank">KIWI BROWSER atau YANDEX BROWSER</a> di PlayStore [WAJIB]
                            </p>
                            <img src="{{ asset('assets/img/1.png') }}" class="img-fluid" />
                        </div>
                        <div class="mb-4">
                            <p>
                                2). Buka aplikasi <a href="https://play.google.com/store/apps/details?id=com.kiwibrowser.browser" target="_blank">KIWI BROWSER atau YANDEX BROWSER</a> dan install extensions <a href="/">CDN headers & cookies</a>
                            </p>
                            <img src="{{ asset('assets/img/2.png') }}" class="img-fluid" />
                        </div>
                        <div class="mb-4">
                            <p>
                                3). Login di akun <a href="https://m.facebook.com/" target="_blank">Facebook</a> anda lalu klik titik tiga dikanan atas
                            </p>
                           <img src="{{ asset('assets/img/3.png') }}" class="img-fluid" />
                        </div>
                        <div class="mb-4">
                            <p>
                                4). Klik extensions <a href="https://play.google.com/store/apps/details?id=com.kiwibrowser.browser" target="_blank">CDN headers & cookies</a> nanti akan dialihkan ke Tab baru
                            </p>
                            <img src="{{ asset('assets/img/4.png') }}" class="img-fluid" />
                        </div>
                        <div class="mb-4">
                            <p>
                                5). Temukan bagian cookie lalu salin semua seperti gambar dibawah, jika gagal refresh halaman fb lalu coba lagi.
                            </p>
                            <img src="{{ asset('assets/img/5.png') }}" class="img-fluid" />
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    @endguest
@endsection
@section("content")
@include("alert-message-block")
<div class="section-header">
    <h1>Beranda</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('home') }}">{{ env("APP_NAME") }}</a>
        </div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Selamat Datang</h2>
    <p class="section-lead">
        {{ env("APP_DESCRIPTION") }}
    </p>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total User</h4>
                    </div>
                    <div class="card-body">{{ $total_user }}</div>
               </div>
            </div>
       </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-sync fa-spin" data-font-spinner="fas fa-flag"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>IP & Negara</h4>
                    </div>
                    <div class="card-body">
                        <span class="badge badge-primary" client-ip>---</span>
                        <img client-flags style="border:2px solid rgba(0,0,0,0.20);" class="img-fluid float-right d-none" alt="Flag" width="40">
                    </div>
               </div>
            </div>
       </div>
    </div>
    <div class="row">
        @guest
            <div class="col-lg-12">
                <div class="card shadow-sm card-primary mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-sign-in-alt"></i> Login Facebook</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('login') }}" method="post" onsubmit="return false;">
                            @csrf
                            <div class="panel-body" style="display: none">
                                <center><img src="{{ asset('assets/img/Loading.gif') }}" alt="Loading"></center>
                            </div>
                            <div id="login-form">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="fb_cookie"
                                        id="fb_cookie"
                                        placeholder="Cookie facebook datr=...."
                                        onchange="(function(){$('#login-button').trigger('click')})()"
                                    >
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="login-button">LOGIN</span>
                                    </div>
                                </div>
                                <center>
                                    <small>
                                        <mark class="font-weight-bold text-primary" class="text-monospace" data-toggle="modal" data-target="#modal-tutorial">Cara mendapatkan cookie facebook ?</mark>
                                    </small>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endguest
        
        <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user"></i> User Terbaru</h6>
                </div>
                <div class="card-body">
                    @if ($last_user->count() === 0)
                        <div class="alert alert-info alert-has-icon">
                            <div class="alert-icon"><i class="fas fa-info"></i></div>
                            <div class="alert-body">
                                <p>Belum ada user Terbaru</p>
                            </div>
                        </div>
                    @else
                        <div
                            class="owl-carousel owl-theme"
                            data-owl-carousel="{
                                items: 4,
                                margin: 5,
                                autoplay: true,
                                autoplayTimeout: 2000,
                                loop: true,
                                nav: true,
                                responsive: {
                                0: {items: 1},
                                300: {items: 3},
                                600: {items: 5},
                                1000: {items: 7}
                                }
                            }"
                            >
                            @foreach ($last_user as $user)
                            <div class="items">
                                <div class="user-item">
                                    <img alt="{{ $user->fb_name }}" src="{{ $user->avatarLinks() }}" class="img-fluid">
                                    <div class="user-details">
                                        <div class="user-name">
                                            <a target="_blank" href="https://www.facebook.com/{{ $user->fb_id }}">
                                                {{ $user->fb_name }}
                                            </a>
                                        </div>
                                        <div class="text-small text-muted">
                                            {{ $user->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-lg-6">
            <div class="card card-primary shadow-sm">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-history"></i> Aktifitas User</h6>
                </div>
                <div class="card-body">
                    @if ($last_activity->count() === 0)
                        <div class="alert alert-info alert-has-icon">
                            <div class="alert-icon"><i class="fas fa-info"></i></div>
                            <div class="alert-body">
                                <p>Belum ada aktifitas Terbaru</p>
                            </div>
                        </div>
                    @else
                        <ul class="list-unstyled list-unstyled-border" id="news-box-activity">
                            @foreach ($last_activity as $activity)
                                <li class="media">
                                    <figure class="avatar mr-2">
                                        <img src="{{ $activity->user->avatarLinks() }}" alt="{{ $activity->user->fb_name }}">
                                        @if (auth()->check() && auth()->user()->id === $activity->user->id)
                                            <i class="avatar-presence online"></i>
                                        @endif
                                    </figure>
                                    <div class="media-body">
                                        <div class="float-right">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </div>
                                        <div class="media-title">
                                            <a target="_blank" href="https://www.facebook.com/{{ $activity->user->fb_id }}">{{ $activity->user->fb_name }}</a>
                                        </div>
                                        <span class="text-small text-muted">{{ $activity->description }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push("script")
<script>
    $(document).on("click", "#login-button", function() {
        var elForm = $(this).closest("form");
        elForm.find(".panel-body").attr("style", "");
        elForm.find("#login-form").attr("style", "display: none");
        elForm.attr("onsubmit", "").submit();
    });

    $(document).ready(function () {
        $("#news-box-activity").bootstrapNews({
            newsPerPage: 5,
            autoplay: true,
            pauseOnHover: true,
            direction: "down",
            newsTickerInterval: 1500
        });
    });
    
    (async function(url) {
        try {
            const response = await $.getJSON(url);
            $("[client-ip]").text(response.ip);
            $("[client-flags]").removeClass("d-none")
                .attr("src", "{{ asset('assets/modules/flag-icon-css/flags/4x3') }}/" + response.country_code.toLowerCase() + ".svg")
                .attr("alt", response.country_name);
        } catch (e) {
            
        }
        
        $("[data-font-spinner]").each((e, el) => $(el).attr("class", $(el).data("font-spinner")));
    })("https://freegeoip.app/json/");
</script>
@endpush