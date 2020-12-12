<template>
  <!-- Flex -->
  <div class="d-flex flex-row justify-content-between">
    <!-- Label -->
    <span v-if="label != ''">{{ label }}</span>
    <!-- Switch outer -->
    <span :class="[label != '' ? 'ml-3' : '']">
      
      <!-- Switch -->
      <label v-if="!disabled" class="switch">
        <input
          type="checkbox"
          v-bind:checked="checked"
          v-on:change="$emit('change', $event.target.checked)"
        />
        <div class="slider round"></div>
      </label>
      <!-- /.Switch -->

      <!-- Disabled Switch -->
      <label v-else class="switch disabled">
        <input type="checkbox" />
        <div class="slider round"></div>
      </label>
      <!-- /.Disabled Switch -->

    </span>
    <!-- /.Switch outer -->
  </div>
  <!-- Flex -->
</template>

<script>
export default {
  name: "Switcher",
  model: {
    prop: "checked",
    event: "change",
  },
  // props: ['checked', 'label', disabled:Boolean],
  props: {
    checked: {
      type: "",
    },
    label: {
      type: String,
      default: "",
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style scoped>
.switch {
  display: inline-block;
  height: 28px; /*34*/
  position: relative;
  width: 56px; /*60*/
  margin: 0 !important;
  padding: 0 !important;
}
.switch input {
  display: none;
}
.slider {
  background-color: #ccc;
  bottom: 0;
  right: 0;
  top: 0;
  left: 0;
  cursor: pointer;
  position: absolute;
  transition: 0.3s;
}
.slider:before {
  background-color: #fff;
  bottom: 3px;
  content: "";
  height: 22px;
  width: 22px;
  left: 4px;
  position: absolute;
  transition: 0.4s;
}
input:checked + .slider {
  background-color: var(--success);
}
input:checked + .slider:before {
  transform: translateX(26px);
}
.slider.round {
  border-radius: 50px;
}
.slider.round:before {
  border-radius: 50%;
}

.switch.disabled,
.switch.disabled * {
  cursor: not-allowed !important;
}
</style>