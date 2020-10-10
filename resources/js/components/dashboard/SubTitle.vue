<template>
  <h2 class="dashboard-subtitle">{{title}}</h2>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default: ''
    }
  }
}
</script>

<style scoped>
.dashboard-subtitle {
  font-size: 1.5em;
  color: #454545;
}
</style>
