<template>
  <!-- Outer -->
  <div v-if="system" class="outer mb-4">
    <div v-if="!is_available_to_change">
      No se puede modificar el sistema de camas ilimitadas.<br />
      Hay mas camas ocupadas de las registradas en el sistema
    </div>

    <!-- Flex -->
    <div
      :class="[
        'd-flex align-items-center justify-content-between mb-4',
        disabled ? 'is-disabled' : '',
      ]"
    >
      <!-- Total de camas -->
      <span class="primary">Camas ilimitadas</span>
      <!-- Col -->
      <span v-if="loadingData && is_available_to_change">
        <loading-grey-bar />
      </span>
      <span v-else>
        <switcher v-model="newValue"  />
      </span>
      <!-- /.Col -->
    </div>
    <!-- /.Flex -->
    <div :class="['mb-5', is_available_to_change ? '' : 'is-disabled']">
      <button
        @click="updateInfiniteBedsValue"
        class="btn button-primary mx-0 btn-block"
      >
        Guardar
      </button>
    </div>
  </div>
  <!-- /.Outer -->
</template>

<script>
export default {
  name: "InfiniteBedSwitch",
  props: {
    system: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      loadingData: true,
      locker: true,
      is_available_to_change: false,
      newValue: false,
      disabled: false,
    };
  },
  created() {
    this.fetchAvailability();
    this.setupData();
  },
  methods: {
    fetchAvailability() {
      const path = "/api/system/guard/availability_to_change";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      axios
        .get(path, {
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          this.is_available_to_change = res.data.is_available_to_change;
          // this.disabled = !res.data.disabled;
        })
        .catch((err) => {
          console.log(res.data);
        });
    },

    setupData() {
      this.loadingData = true;
      this.newValue = this.system.infinite_beds;
      this.loadingData = false;
    },
    /**
     * Actualizar el valor de camas
     */
    updateInfiniteBedsValue() {
      this.loadingData = true;
      const path = "/api/system/guard/inite_beds/update";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      const formData = { infinite_beds: this.newValue };

      axios
        .post(path, formData, {
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          this.new_alert(res.data);
          // if (res.data.status != "success") {
          //   this.newValue = !this.newValue;
          // }
          this.loadingData = false;
        })
        .catch((err) => {
          this.loadingData = false;
        });
    },
  },
};
</script>

<style scoped>
.is-disabled,
.is-disabled * {
  opacity: 0.6 !important;
  cursor: not-allowed !important;
}
</style>