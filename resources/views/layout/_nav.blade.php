<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    
    @auth
        <ul class="navbar-nav navbar-right">
            <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="fas fa-history"></i></a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                    <div class="dropdown-header">
                        Aktifitas
                        <div class="float-right">
                            <a href="#">{{ date("j F Y") }}</a>
                        </div>
                    </div>
                    @if ($globals_activity->count() === 0)
                        <p class="text-muted text-center">
                            Belum ada aktifitas terbaru
                        </p>
                    @else
                        <div class="dropdown-list-content dropdown-list-icons">
                            @foreach ($globals_activity as $activity)
                                @php $name = $activity->getExtraProperty("name"); @endphp
                                <a href="#" class="dropdown-item dropdown-item-unread">
                                    <div class="dropdown-item-icon bg-{{ get_activity_color_class($name) }} text-white">
                                        <i class="{{ get_activity_icon_class($name) }}"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        {{ $activity->description }}
                                        <div class="time text-primary">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="{{ route('activity') }}">Lihat semua <i class="fas fa-chevron-right"></i></a>
                        </div>
                    @endif
                </div>
            </li>
            <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ auth()->user()->avatarLinks() }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">
                    {{ auth()->user()->fb_name }}
                </div>
            </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-title">
                        Selemat Datang !
                    </div>
                    <a
                        href="javascript:void(0)"
                        class="dropdown-item has-icon"
                        id="show-token"
                    >
                        <i class="fas fa-key"></i> Access Token
                    </a>
                    <a href="{{ route('activity') }}" class="dropdown-item has-icon {{ Route::is('activity') ? 'active' : '' }}">
                        <i class="fas fa-history"></i> Aktifitas
                    </a>
                    <div class="dropdown-divider"></div>
                    <a
                        href="javascript:void(0)"
                        class="dropdown-item has-icon text-danger"
                        data-confirm="Kamu Yakin|Ingin keluar ?"
                        data-confirm-text-yes="Iya"
                        data-confirm-text-cancel="Tidak"
                        data-confirm-yes="$('#form-logout').submit();"
                    >
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                </div>
            </li>
        </ul>
        <form action="{{ route('logout') }}" method="post" id="form-logout">@csrf</form>
    @endauth

</nav>