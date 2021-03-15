@extends("layout.app", ["title" => "Facebook Bot Reaction"])

@section("content")
<div class="section-header">
    <h1>Bot Reaction</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('home') }}">Home</a>
        </div>
        <div class="breadcrumb-item">
            Reactions
        </div>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary shadow-sm">
                <div class="card-body">
                    @if (empty($reaction))
                        <p><i class="fas fa-times"></i> <strong>Saat ini kamu belum menginstall Bot Reaction</strong></p>
                    @elseif (empty($reaction->is_active))
                        <form action="{{ route('reactions.enable') }}" method="post" id="enable-reaction">
                            @csrf
                            <p class="text-danger">
                                <i class="fas fa-ban"></i> <strong>Status Bot reaction kamu Mati</strong>
                                <button
                                    type="button"
                                    data-confirm="Kamu Yakin|Ingin mengaktifkan bot reaction ini ?"
                                    data-confirm-text-yes="Iya"
                                    data-confirm-text-cancel="Batal"
                                    data-confirm-yes="$('#enable-reaction').submit();"
                                    class="btn btn-round btn-sm btn-success float-right"
                                    data-toggle="tooltip"
                                    title="Aktifkan Bot"
                                >
                                    <i class="fas fa-check"></i>
                                </button>
                            </p>
                        </form>
                    @else
                        <form action="{{ route('reactions.disable') }}" method="post" id="disable-reaction">
                            @csrf
                            <p class="text-success">
                                <i class="fas fa-check"></i> <strong>Status Bot Reaction kamu Aktif dan sedang dalam antrian</strong>
                                <button
                                    type="button"
                                    data-confirm="Kamu Yakin|Ingin menonaktifkan bot reaction ini ?"
                                    data-confirm-text-yes="Iya"
                                    data-confirm-text-cancel="Batal"
                                    data-confirm-yes="$('#disable-reaction').submit();"
                                    class="btn btn-round btn-sm btn-danger float-right"
                                    data-toggle="tooltip"
                                    title="Nonaktifkan Bot"
                                >
                                    <i class="fas fa-ban"></i>
                                </button>
                            </p>
                        </form>
                    @endif
    
                    @include("alert-message-block")
                </div>
            </div>
            <div class="card card-primary shadow-sm">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-cog fa-spin"></i> {{ isset($reaction) ? "Update Bot" : "Install Bot" }}</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>×</span>
                                </button>
                                <ul>
                                    @foreach ($errors->all() as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('reactions.post') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-6">
                                <div class="row">
                                    <label class="col-sm-5 col-form-label">Pilih Type Reaction</label>
                                    <div class="col-sm-7">
                                        @foreach (config("bot.reaction_type") as $key => $value)
                                            <div class="custom-control custom-radio">
                                                <input
                                                    class="custom-control-input"
                                                    name="type"
                                                    id="type_{{ $key }}"
                                                    type="radio"
                                                    value="{{ $key }}"
                                                    @if (($reaction->type ?? null) === $key) checked @endif
                                                >
                                                <label class="custom-control-label" for="type_{{ $key }}">
                                                    {{ $value["name"] }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <div class="row">
                                    <label class="col-sm-5 col-form-label">Hanya postingan teman ?</label>
                                    <div class="col-sm-7">
                                        <div class="custom-control custom-radio">
                                            <input
                                                class="custom-control-input"
                                                name="only_friends"
                                                type="radio" value="1"
                                                id="only_friends_1"
                                                @if (isset($reaction) && ((bool) $reaction->only_friends ?? false)) checked @endif
                                            >
                                            <label class="custom-control-label" for="only_friends_1">
                                                Iya
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input
                                                class="custom-control-input"
                                                name="only_friends"
                                                type="radio" value="0"
                                                id="only_friends_0"
                                                @if (isset($reaction) && !((bool) $reaction->only_friends ?? false)) checked @endif
                                            >
                                            <label class="custom-control-label" for="only_friends_0">
                                                Tidak, postingan group / fanspage juga boleh
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-tool"></i> {{ isset($reaction) ? "Update" : "Install" }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><i>%</i> Stastistik</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($persentaseOnlyFriends as $key => $persentase)
                            <div class="col-md-6 mb-3">
                                <div class="text-small float-right font-weight-bold text-muted">{{ $persentase["total"] }}</div>
                                <div class="font-weight-bold mb-1">{{ $key }}</div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" data-width="{{ $persentase['persentase'] }}%" aria-valuenow="{{ $persentase['persentase'] }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $persentase['persentase'] }}%
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="row">
                        @foreach ($persentaseType as $key => $persentase)
                            <div class="col-6 mb-3">
                                <div class="text-small float-right font-weight-bold text-muted">{{ $persentase["total"] }}</div>
                                <div class="font-weight-bold mb-1">{{ config("bot.reaction_type")[$key]["name"] }}</div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" data-width="{{ $persentase['persentase'] }}%" aria-valuenow="{{ $persentase['persentase'] }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $persentase["persentase"] }}%
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h2 class="text-center">Apa itu Bot Reaction ?</h2>
    <p class="category text-center">
        Adalah bot yang dapat berjalan otomatis untuk nge-Like postingan beranda dalam waktu tertentu.
    </p>
    <h4>Info Bot:</h4>
    <ul class="category">
        <li>Bot akan berjalan 5 menit sekali dengan eksekusi 3 postingan</li>
        <li>Bot tidak jalan? Update cookie baru jika masih sama cek apakah akun diblokir Like</li>
        <li>
            Jika akun kamu LogOut dari browser facebook yang untuk memgambil Cookie itu artinya
            Cookie kamu mati, dan bot akan otomatis dihapus
        </li>
        <li>Jika mau bot kamu awet saran Jangan pernah di LogOut dari browser yang untuk mengambil Cookie</li>
    </ul>
</div>
@endsection