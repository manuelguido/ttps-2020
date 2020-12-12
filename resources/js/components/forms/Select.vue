<template>
  <div :class="classList">
    <label>{{ label }}</label>
    <select
      v-bind:value="value"
      v-on:input="$emit('input', $event.target.value)"
      class="v-input mb-2"
      :disabled="disabled"
      :required="required"
    >
      <option disabled value="0">Seleccione un elemento</option>
      <option v-for="o in options" :key="o.id" :value="o.id">
        {{ o.name }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  name: "VSelect",
  props: {
    value: {
      type: String,
      default: null,
    },
    placeholder: {
      type: String,
      default: "",
    },
    label: {
      type: String,
      default: "",
    },
    options: {
      type: Array,
      default: [],
    },
    classList: {
      type: String,
      default: "",
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    required: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style scoped>
.v-input {
  width: 100%;
  border: 0 !important;
  border-top-left-radius: 6px;
  border-bottom-left-radius: 6px;
  background: #eee;
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
