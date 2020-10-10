<html>
<head>
  <meta charset="utf-8">
  <title>Callback</title>
  {{-- <script>
    window.opener.postMessage({ token: "{{ $token }}", user: "{{ $user }}" }, "http://127.0.0.1:8000");
    // window.close();
  </script> --}}
</head>
<body>
  <p id="token" style="display: none;">{{$token}}</p>

  <script>

    window.onload = function() {
      loadToken();
      // doSomethingElse();
    };
    
    function loadToken() {
      
      var token = document.getElementById('token').innerHTML;
      // alert(token);
      localStorage.setItem('access_token', token);
      // window.close();
      window.location.pathname = "dashboard/home";
    }
  </script>
</body>
</html>
