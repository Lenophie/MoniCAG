<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=3, minimum-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="author" content="Lenophie" />
        <meta name="CSRF-TOKEN" content="{{ csrf_token() }}">
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
        @yield('content')
        @include('footer')
    </body>

    <script type="text/javascript" src="{{ asset('js/common.js') }}"></script>
    @stack('scripts')
</html>
