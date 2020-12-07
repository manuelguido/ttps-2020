<template>
  <div :class="classList">
    <label>{{label}}</label>
    <textarea
      class="v-input mb-2"
      v-bind:value="value"
      rows="3"
      v-on:input="$emit('input', $event.target.value)"
      :placeholder="placeholder"
      ></textarea>
  </div>
</template>

<script>
export default {
  props: ["value", "type", "placeholder", "label", "rows", "classList"],
};
</script>

<style scoped>
.v-input {
  width: 100%;
  border: 0 !important;
  border-radius: 6px;
  background: var(--primary-light);
  padding: 10px 16px !important;
  color: #232323 !important;
}

.is-invalid {
  border: 2px solid rgba(255, 0, 0, 0.6);
}

.v-input:focus {
  outline: none !important;
  border: 0 none !important;
  box-shadow: none !important;
}

.v-input::placeholder {
  color: #444 !important;
}

label {
  color: #aaa;
  font-weight: 600;
}
</style>
