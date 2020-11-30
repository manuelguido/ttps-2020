<template>
  <div class="mb-5">
    <p class="h4-responsive w-600 black-alpha-50 mb-0">{{ text }}</p>
    <hr class="my-3" />
  </div>
</template>

<script>
export default {
  name: "EvolutionModalTitle",
  props: {
    text: {
      type: String,
      default: "Título",
    },
  },
};
</script>
