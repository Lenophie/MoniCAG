<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="author" content="Lenophie">
        <link href="@yield('stylesheet')" rel="stylesheet">
        <title>@yield('title')</title>
    </head>

    <body>
        @yield('content')
    </body>

    <script type="text/javascript" src="{{ URL::asset('js/common.js') }}"></script>
</html>