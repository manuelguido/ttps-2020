<template>
  <div class="container-fluid py-5 text-center">
    <h1 class="h6 black-c mt-5 mb-4">Token</h1>
    <spinner></spinner>
  </div>
</template>

<script>
export default {
  created() {
    function parseHttpHeaders(httpHeaders) {
        return httpHeaders.split("\n")
        .map(x=>x.split(/: */,2))
        .filter(x=>x[0])
        .reduce((ac, x)=>{ac[x[0]] = x[1];return ac;}, {});
    }

    var req = new XMLHttpRequest();
    req.open('GET', document.location, false);
    req.send(null);
    var headers = parseHttpHeaders(req.getAllResponseHeaders());

    console.log(headers)
  }
};
</script>
