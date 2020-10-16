<template>
  <h2 class="dashboard-subtitle">{{text}}</h2>
</template>

<script>
export default {
  props: {
    text: {
      type: String,
      default: ''
    }
  }
}
</script>

<style scoped>
.dashboard-subtitle {
  font-size: 1.5em;
  color: var(--black);
}
</style>
