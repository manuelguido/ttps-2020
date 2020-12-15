<template>
  <div :class="classList">
    <label v-if="label">{{ label }}</label>
    <input
      class="v-input m-0"
      v-bind:value="value"
      v-on:input="$emit('input', $event.target.value)"
      @keypress="dataValidation($event)"
      type="number"
      :placeholder="placeholder"
      :disabled="disabled"
      :required="required"
    />
  </div>
</template>

<script>
export default {
  name: "VNumberInput",
  props: [
    "value",
    "placeholder",
    "label",
    "classList",
    "onlyNumbers",
    "onlyNumbersAndSymbols",
    "disabled",
    "required",
  ],
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
  background: #eee;
  padding: 12px 16px !important;
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
