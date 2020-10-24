<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- Crsf --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Title --}}
        <title>SeCo</title>
        {{-- Fonts --}}
        <link rel="stylesheet" href="{{ asset('fonts/fonts/css/all.min.css') }}">
        {{-- Icon --}}
        <link rel="icon" href="{{ asset('img/favicon.png') }}">
    </head>
    <body>
        {{-- App --}}
        <div id="app">
            <app></app>
        </div>
        {{-- App script --}}
        <script src="{{ asset('js/app2.js') }}"></script>
    </body>
</html>
