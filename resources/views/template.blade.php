<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="author" content="Lenophie" />
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