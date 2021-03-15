@php $title = $title ?? env("APP_NAME"); @endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#6777ef">
    <meta name="title" content="{{ $title }}" />
    <meta name="description" content="{{ env('APP_DESCRIPTION') }}" />
    <meta name="keywords" content="{{ env('APP_KEYWORDS') }}" />
    <meta name="author" content="{{ env('APP_AUTHOR') }}" />
    <meta name="copyright" content="{{ request()->getHost() }}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="{{ $title }}" />
    <meta name="twitter:site" content="{{ request()->getHost() }}" />
    <meta name="twitter:description" content="{{ env('APP_DESCRIPTION') }}" />
    <meta name="twitter:image" content="{{ asset('assets/img/favicon-158x158.png') }}" />
    <meta name="robots" content="index, follow, noarchive" />
    <meta name="googlebot" content="index, follow, noarchive" />
    <meta property="og:alt" content="{{ env('APP_NAME') }}" />
    <meta property="og:locale" content="id_ID" />
    <meta property="og:author" content="{{ env('APP_AUTHOR') }}" />
    <meta property="og:description" content="{{ env('APP_DESCRIPTION') }}" />
    <meta property="og:site_name" content="{{ request()->getHost() }}" />
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:image" content="{{ asset('assets/img/favicon-158x158.png') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <title>{{ $title }}</title>
    
    @if (env("APP_DEBUG") === true)
        <script src="//cdn.jsdelivr.net/npm/eruda"></script>
        <script type="text/javascript">eruda.init()</script>
    @endif
    
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon-158x158.png') }}" size="158x158">
    <link rel="apple-touch-icon" type="image/png" href="{{ asset('assets/img/favicon-158x158.png') }}" size="158x158">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.min.css') }}">
    
    <style>
        .break-word {
            overflow-wrap: break-word;
        }
    </style>
    @stack("head")

</head>
<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            
            @include("layout._nav")
            @include("layout._sidebar")
            
            @yield("before-content")

            <div class="main-content">
                <section class="section">
                    @yield("content")
                </section>
            </div>

            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; {{ date("Y") }} <div class="bullet"></div>
                    <a href="{{ url()->current() }}">{{ env("APP_NAME") }}</a>
                </div>
                <div class="footer-right">
                    {{ env("APP_VERSION") }}
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-newsbox/jquery.bootstrap.newsbox.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js?v=1') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $("[data-owl-carousel]").each(function() {
               var elOwl = $(this);
               try {
                   eval("var owl = " + elOwl.data("owl-carousel").trim());
                   if (typeof owl === "object") {
                       $(elOwl).owlCarousel(owl)
                   }
               } catch (e) {}
            });
            
            @if (auth()->check())
                $("#show-token").fireModal({
                    bodyClass: 'break-word',
                    title: 'Access Token',
                    body: '{{ auth()->user()->fb_access_token }}'
                });
            @endif
        });
    </script>

    @stack("script")

</body>
</html>