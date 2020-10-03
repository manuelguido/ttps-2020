<template>
  <input
    class="v-input mb-1"
    v-bind:value="value"
    v-on:input="$emit('input', $event.target.value)"
    :type="type"
    :placeholder="placeholder"
    />
    <!-- :class="['v-input [invalid ? 'is-invalid' : '']]" -->
</template>

<script>
export default {
  props: ['value', 'type', 'placeholder'],
}
</script>

<style>
.v-input {
  width: 100%;
  border: 0 !important;
  border-radius: 6px;
  background: var(--primary-light);
  padding: 14px 20px !important;
  color: #454545;
}

.is-invalid {
  border: 2px solid rgba(255, 0, 0, .6);
}

.v-input:focus {
  outline: none !important;
  border: 0 none !important;
  box-shadow: none !important;
}

.v-input::placeholder {
  color: #454545 !important;
}
</style>
