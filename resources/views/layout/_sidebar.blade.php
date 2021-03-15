<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url()->current() }}">{{ env("APP_NAME") }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm"></div>
        <ul class="sidebar-menu">
            <li @if (Route::is('home')) class="active" @endif>
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-home"></i> <span>Beranda</span>
                </a>
            </li>
            <li class="menu-header">FITURES</li>
            <li @if (Route::is('reactions.')) class="active" @endif>
                <a class="nav-link" href="{{ route('reactions.') }}">
                    <i class="fas fa-smile"></i> <span>Bot Reaction</span>
                </a>
            </li>
        </ul>
    </aside>
</div>