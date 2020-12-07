<template>
  <div :class="classList">
    <label>{{ label }}</label>
    <input
      class="v-input mb-2"
      v-bind:value="value"
      v-on:input="$emit('input', $event.target.value)"
      @keypress="dataValidation($event)"
      :type="type"
      :placeholder="placeholder"
      :disabled="disabled"
      :required="required"
    />
  </div>
</template>

<script>
export default {
  name: "VInput",
  props: {
    value: {
      type: String,
      default: "",
    },
    type: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
    label: {
      type: String,
      default: "",
    },
    classList: {
      type: String,
      default: "",
    },
    onlyLetters: {
      type: Boolean,
      default: false,
    },
    onlyNumbers: {
      type: Boolean,
      default: false,
    },
    onlyNumbersAndSymbols: {
      type: Boolean,
      default: false,
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
  methods: {
    dataValidation(e) {
      if (this.onlyLetters) {
        this.isLetter(e);
      }
      if (this.onlyNumbers) {
        this.isNumber(e);
      }
      if (this.onlyNumbersAndSymbols) {
        this.isNumberAndSymbols(e);
      }
    },

    isLetter(e) {
      let char = String.fromCharCode(e.keyCode); // Obtener el cracter
      if (/^[A-Za-z]+$/.test(char)) return true;
      // Match with regex
      else e.preventDefault(); // If not match, don't add to input text
    },

    isNumber: function (evt) {
      evt = evt ? evt : window.event;
      var charCode = evt.which ? evt.which : evt.keyCode;
      if (
        charCode > 31 &&
        (charCode < 48 || charCode > 57) &&
        charCode !== 46
      ) {
        evt.preventDefault();
      } else {
        return true;
      }
    },

    isNumberAndSymbols(e) {
      let char = String.fromCharCode(e.keyCode); // Obtener el cracter
      if (/^[A-Za-z]+$/.test(char)) e.preventDefault();
      else return true; // If not match, don't add to input text
    },
  },
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
