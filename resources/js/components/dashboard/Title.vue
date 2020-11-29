<template>
  <div v-if="full" class="row">
    <div class="title-col col-12">
      <h1 :class="['dashboard-title', margin ? 'mb-4' : 'mb-0']">{{text}}</h1>
    </div>
  </div>
  <h1 v-else :class="['dashboard-title', margin ? 'mb-4' : 'mb-0']">{{text}}</h1>
</template>

<script>
export default {
  props: {
    text: {
      type: String,
      default: ''
    },
    full: {
      type: Boolean,
      default: false
    },
    margin: {
      type: Boolean,
      default: true
    },
  }
}
</script>

<style scoped>
.dashboard-title {
  font-size: 1.45em;
  font-weight: 400;
  color: #676767;
  /* color: var(--primary); */
}
</style>
