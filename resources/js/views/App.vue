<template>
  <div>
    <router-view/>
  </div>
</template>

<script>
export default {
  name: 'App',
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap');

#app {
  font-family: 'Nunito', sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: left;
  color: #5f6368;
  font-weight: 400;
  margin: 0;
  padding: 0;
  min-height: 100vh;
}

body {
  background-color: #fcfcfc !important;
  overflow-x: hidden !important;
}
</style>
