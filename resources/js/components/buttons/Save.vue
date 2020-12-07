<template>
  <button type="submit" class="btn button-success btn-block">
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
  },
};
</script>