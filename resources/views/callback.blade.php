<!DOCTYPE html>
  <html lang="es">
    <meta charset="utf-8">
    <title>Callback</title>
  </head>
  <body>
    <p id="token" style="display: none;">{{$token}}</p>

    <script>
      window.onload = function() {
        loadToken();
      };
      
      function loadToken() {
        var token = document.getElementById('token').innerHTML;
        localStorage.setItem('access_token', token);
        window.location.href = "/dashboard";
      }
    </script>
  </body>
</html>
