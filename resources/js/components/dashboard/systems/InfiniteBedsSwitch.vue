<template>
  <!-- Outer -->
  <div class="outer">
    <div v-if="disabled">
      No se puede modificar el sistema de camas ilimitadas.<br>
      Hay mas camas ocupadas de las registradas en el sistema
    </div>
  
      <!-- Flex -->
    <div :class="['d-flex align-items-center justify-content-between mb-4', disabled ? 'is-disabled' : '']">
      <!-- Total de camas -->
      <span class="primary">Camas ilimitadas</span>
      <!-- Col -->
      <span v-if="loadingData && !disabled">
        <loading-grey-bar />
      </span>
      <span v-else>
        <switcher v-model="newValue" :disabled="disabled" />
      </span>
      <!-- /.Col -->
    </div>
    <!-- /.Flex -->

  </div>
  <!-- /.Outer -->
</template>

<script>
export default {
  name: "InfiniteBedSwitch",
  props: {
    system: {
      type: Object,
    },
  },
  data() {
    return {
      loadingData: true,
      newValue: false,
      disabled: false,
    };
  },
  mounted() {
    this.setupData();
  },
  methods: {
    setupData() {
      this.newValue = this.system.infinite_beds;
      this.disabled = (this.system.occupied_beds > this.system.total_beds);
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

      const formData = {
        infinite_beds: this.newValue,
      };

      axios
        .post(path, formData, {
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          console.log(res);
          if (res.data.status != "success") {
            this.new_alert(res.data);
            this.newValue = !this.newValue;
          }
          this.loadingData = false;
        })
        .catch((err) => {
          this.newValue = !this.newValue;
          this.loadingData = false;
          // this.errorHandler(err.response.status);
        });
    },
  },
  watch: {
    newValue: function () {
      if (!this.loadingData) {
        this.updateInfiniteBedsValue();
      }
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