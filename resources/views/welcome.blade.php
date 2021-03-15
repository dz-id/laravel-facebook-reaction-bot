@extends("layout.app", ["title" => "Home"])

@section("content")
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-user">
            <div class="card-body">
                <p class="card-text">
                    <div class="author">
                        <div class="block block-one"></div>
                        <div class="block block-two"></div>
                        <div class="block block-three"></div>
                        <div class="block block-four"></div>
                        <a href="javascript:void(0)">
                            <img class="avatar" src="{{ auth()->user()->avatarLinks() }}" alt="{{ auth()->user()->fb_name }}">
                            <h5 class="title">{{ auth()->user()->fb_name }}</h5>
                        </a>
                        <p class="description">
                            ID: {{ auth()->user()->fb_id }}
                        </p>
                    </div>
                </p>
            </div>
            <div class="card-footer">
                <div class="button-container">
                    <button onclick="window.location.href = 'https://www.facebook.com/{{ auth()->user()->fb_id }}';" class="btn btn-icon btn-round btn-facebook">
                        <i class="fab fa-facebook"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection