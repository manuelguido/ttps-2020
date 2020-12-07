<template>
  <h2 :class="['subtitle', colored ? 'text-primary' : 'black-alpha-50']">
    {{ text }}
  </h2>
</template>

<script>
export default {
  props: {
    text: {
      type: String,
      default: "",
    },
    colored: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style scoped>
.subtitle {
  font-size: 1.2em;
}
</style>
