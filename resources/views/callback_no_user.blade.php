<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Crsf --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Title --}}
    <title>Callback</title>
    {{-- Fonts --}}
    <link rel="stylesheet" href="{{ asset('fonts/fonts/css/all.min.css') }}">
    {{-- Icon --}}
    <link rel="icon" href="{{ asset('img/favicon.png') }}">
  </head>

  <body>
    <div id="app">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center pt-5 mt-5">
            <p class="h4">El usuario de google que elegiste no existe en el sistema.</p>
          </div>
        </div>
      </div>
    </div>

    <script src="{{ asset('js/appFinal3.min.js') }}"></script>

    <script>
      window.onload = function() {
        loadToken();
      };
      function loadToken() {
        setTimeout(function(){
          window.location.href = "/login";
        }, 2000);      
      }
    </script>
  </body>
</html>
