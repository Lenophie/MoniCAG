<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=3, minimum-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="author" content="Lenophie" />
        <meta name="CSRF-TOKEN" content="{{ csrf_token() }}">
        <meta name="X-Localization" content="{{ App::getLocale() }}">
        <link href="{{asset("css/bulma.css")}}" rel="stylesheet" />
        <link href="{{asset("css/common.css")}}" rel="stylesheet" />
        <link href="{{asset("css/flag-icon.min.css")}}" rel="stylesheet" />
        @if (\Illuminate\Support\Facades\Session::get('theme') === 'dark')
            <link href="{{ asset('css/dark-theme.css') }}" rel="stylesheet" />
        @else
            <link href="{{ asset('css/light-theme.css') }}" rel="stylesheet" />
        @endif
        <link href="@yield('stylesheet')" rel="stylesheet" />
        <link rel="shortcut icon" href="@yield('favicon')" />
        <title>@yield('title')</title>
    </head>

    <body>
        <div id="app">
            @yield('content')
            @include('footer')
        </div>
    </body>

    <script type="text/javascript" src="{{ mix('js/manifest.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/vendor.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/common.js') }}"></script>
    @stack('scripts')
</html>
