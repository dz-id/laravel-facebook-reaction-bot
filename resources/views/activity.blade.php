@extends("layout.app", ["title" => "Log Aktifitas"])

@section("content")
<div class="section-header">
    <h1>Aktifitas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('home') }}">Home</a>
        </div>
        <div class="breadcrumb-item">
            Activity
        </div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">{{ date("j F Y") }}</h2>
    @if ($activity->count() === 0)
        <p class="text-center text-monospace text-muted">Belum ada aktifitas terbaru !</p>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="activities justify-content-center">
                    @foreach ($activity as $ac)
                        <div class="activity">
                            <div class="activity-icon bg-primary text-white shadow-primary">
                                <i class="{{ get_activity_icon_class($ac->getExtraProperty('name')) }}"></i>
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2">
                                    <span class="text-job text-primary">{{ $ac->created_at->diffForHumans() }}</span>
                                </div>
                                <p>
                                    {{ $ac->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection