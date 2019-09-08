<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="/js/app.js"></script>
        <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body>
        <div class="container" id="app">

            @include('layouts.menu')

            @yield('breadcrumbs')

            @include('layouts.errors')

            @yield('content')
            
        </div>

        <footer class="footer">
            <div class="content has-text-centered">
                <p>
                <strong>Jeroen's weblog</strong> by <a href="http://www.jeroenpostema.nl">Jeroen Postema</a>.
                </p>
            </div>
        </footer>
    </body>
</html>