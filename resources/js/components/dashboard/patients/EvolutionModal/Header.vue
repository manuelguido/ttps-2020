<template>
  <!-- Stepper header -->
  <div class="stepper-header uns">
    <!-- Arrows -->
    <!-- <div class="arrows d-flex align-items-middle justify-content-between mb-4"> -->
      <!-- Arrow back -->
      <!-- <span @click="emitStepChange(current - 1)" class="arrow-icon text-center"> -->
        <!-- <i class="fad fa-chevron-left fa-lg"></i> -->
      <!-- </span> -->
      <!-- /.Arrow back -->
      <!-- Arrow forward -->
      <!-- <span @click="emitStepChange(current + 1)" class="arrow-icon text-center"> -->
        <!-- <i class="fad fa-chevron-right fa-lg"></i> -->
      <!-- </span> -->
      <!-- /.Arrow forward -->
    <!-- </div> -->
    <!-- Arrows -->

    <!-- Steps -->
    <div class="d-flex flex-row align-items-top justify-content-between">
      <!-- Step -->
      <span
        v-for="step in steps"
        :key="step.order"
        @click="emitStepChange(step.order)"
        class="step d-flex flex-column align-items-top text-center pt-3 pb-2 px-3"
        v-bind:class="step.order == current ? 'active' : ''"
      >
        <span class="step-icon mx-auto mb-2"
          ><i :class="[step.icon, 'fa-lg']"></i
        ></span>
        <span class="step-name mb-0">{{ step.name }}</span>
      </span>
      <!-- /.Step -->
    </div>
    <!-- Steps -->
  </div>
  <!-- /.Stepper header -->
</template>

<script>
export default {
  name: 'StepperHeader',
  props: {
    current: {
      type: Number,
    },
    steps: {
      type: Array,
      default: [],
    }
  },
  methods: {
    emitStepChange(value) {
      if (value >= 1 && value <= 6) {
        this.$emit('stepChange', value);
      }
    }
  }
}
</script>

<style scoped>
/* Header */
.stepper-header {
  padding: 0;
  overflow: hidden;
}

/* Step */
.step {
  border-radius: 5px;
  cursor: pointer;
  border-bottom: 5px solid transparent;
}
.step.active,
.step:hover {
  background: #f7f9fa;
}
.step.step.active {
  border-bottom: 5px solid var(--success) !important;
}
.step:active {
  background: #f4f4f4;
}

/* Step icon */
.step-icon {
  background: #f4f4f4;
  border-radius: 50px;
  display: inline-block;
  height: 45px !important;
  width: 45px !important;
  display: flex;
  align-content: center;
  align-items: center;
  justify-content: center;
}

.step.active .step-icon {
  color: var(--success) !important;
  background-color: #fff;
  box-shadow: 0 0 0.225em rgba(0, 0, 0, 0.2);
}

/* Step name */
.step-name {
  color: rgba(0, 0, 0, 0.4);
}

@media (max-width: 992px) {
  .step-name {
    display: block !important;
  }
}

.arrows {
  /* background: #f9f9f9; */
  border-radius: 5px !important;
  width: 100%;
}
.arrow-icon {
  cursor: pointer;
  padding: .3em;
  width: 50%;
}
.arrow-icon:hover {
  background: #f3f6fe;
  color: var(--success) !important;  
}
.arrow-icon:active {
  background-color: #f6f6f6;
}
</style>