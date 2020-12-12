<template>
  <input
    class="search-input mb-1"
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
.search-input {
  width: 100%;
  border: 1px solid #bbb !important;
  border-radius: 6px;
  background: #fff;
  padding: 14px 20px !important;
  color: #232323;
}

.is-invalid {
  border: 2px solid rgba(255, 0, 0, .6);
}

.search-input:focus {
  outline: none !important;
  /* border: 0 none !important; */
  box-shadow: none !important;
}

.search-input::placeholder {
  color: #454545 !important;
}
</style>
