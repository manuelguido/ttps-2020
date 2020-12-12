<template>
  <div class="d-flex justify-content-between align-items-baseline mb-3">
    <span>
      {{ data }}
    </span>
    <span>
      {{ value }}
    </span>
  </div>
</template>

<script>
export default {
  name: "InfoData",
  props: ["data", "value"],
};
</script>
