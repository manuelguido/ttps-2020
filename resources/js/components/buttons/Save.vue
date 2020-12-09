<template>
  <button type="submit" :class="['btn button-success btn-block', classList, disabled ? 'disabled' : '']">
    {{ text }}
  </button>
</template>

<script>
export default {
  name: "SaveButton",
  props: {
    text: {
      type: String,
      default: 'Guardar',
    },
    classList: {
      type: String,
      default: '',
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style scoped>

</style>