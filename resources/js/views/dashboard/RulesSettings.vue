<template>
  <!-- Dashboard card -->
  <dashboard-card :title="cardTitle" noBack>
    <!-- Form -->
    <form @submit.prevent="updateRulesSettings" class="row">
      <!-- Col -->
      <div class="col-12 mb-5">
        <p class="h4 black-alpha-60 mb-4">
          Configuración de parámetros para las reglas que generan alertas en el
          sistema:
        </p>
        <p class="black-alpha-40">
          <i class="fad fa-info-circle mr-3 fa-lg"></i>Si se desactiva la
          configuración de reglas, ningúna regla será evaluada al generar
          evoluciones.
        </p>
        <p class="black-alpha-40">
          <i class="fad fa-info-circle mr-3 fa-lg"></i>Para guardar los cambios,
          presiona en el botón de "Guardar" al final del formulario.
        </p>
      </div>
      <!-- /.Col -->

      <!-- Col -->
      <div class="col-12 col-lg-8 col-xl-6 d-flex flex-column">
        <loading-overlay v-if="loadingData" />
        <!-- Activacion de reglas -->
        <div class="form-group mb-5">
          <switcher
            v-model="rules.activated"
            label="Activación de reglas"
          ></switcher>
        </div>
        <!-- /.Activacion de reglas -->

        <!-- Parámetro de frecuencia respiratoria -->
        <div class="form-group mb-5">
          <v-number-input
            v-model="rules.breathing_rate"
            label="Parámetro de frecuencia respiratoria"
            onlyNumbers
          ></v-number-input>
        </div>
        <!-- /.Parámetro de frecuencia respiratoria -->

        <!-- Parámetro de frecuencia respiratoria -->
        <div class="form-group mb-5">
          <v-number-input
            v-model="rules.days_to_evaluate"
            label="Días desde el inicio de sítomas para evaluar alta"
            onlyNumbers
          ></v-number-input>
        </div>
        <!-- /.Parámetro de frecuencia respiratoria -->

        <!-- Parámetro de frecuencia respiratoria -->
        <div class="form-group mb-5">
          <v-number-input
            v-model="rules.oxigen_saturation"
            label="Parámetro de saturación de oxígeno"
            onlyNumbers
            min="0"
            max="100"
          ></v-number-input>
        </div>
        <!-- /.Parámetro de frecuencia respiratoria -->

        <!-- Parámetro de frecuencia respiratoria -->
        <div class="form-group mb-5">
          <v-number-input
            v-model="rules.oxigen_saturation_down_percentage"
            label="Parámetro de baja de saturación de oxígeno"
            onlyNumbers
            min="0"
            max="100"
          ></v-number-input>
        </div>
        <!-- /.Parámetro de frecuencia respiratoria -->

        <!-- Parámetro de frecuencia respiratoria -->
        <div class="form-group">
          <save-button />
        </div>
        <!-- /.Parámetro de frecuencia respiratoria -->
      </div>
      <!-- /.Col -->
    </form>
    <!-- /.Form -->
  </dashboard-card>
  <!-- /.Dashboard card -->
</template>

<script>
export default {
  name: "RulesSettingsView",
  props: ["system_id"],
  data() {
    return {
      cardTitle: "Configuración de reglas",
      loadingData: true,
      rules: {},
    };
  },
  created() {
    this.hasPermission("rule_crud");
    this.fetchRulesSettings();
  },
  methods: {
    /**
     * Obtiene el sistema con sus habitaciones y camas
     */
    fetchRulesSettings() {
      this.loadingData = true;
      const path = "/api/settings/rules/show";
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
          this.rules = res.data;
          this.loadingData = false;
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
          this.loadingData = false;
        });
    },

    /**
     * Obtiene el sistema con sus habitaciones y camas
     */
    updateRulesSettings() {
      this.loadingData = true;
      const path = "/api/settings/rules/update";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      let formData = {
        activated: this.rules.activated,
        breathing_rate: this.rules.breathing_rate,
        days_to_evaluate: this.rules.days_to_evaluate,
        oxigen_saturation: this.rules.oxigen_saturation,
        oxigen_saturation_down_percentage: this.rules.oxigen_saturation_down_percentage,
      };

      axios
        .post(path, formData, {
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          this.new_alert(res.data);
          // this.rules = res.data;
          this.loadingData = false;
        })
        .catch((err) => {
          // this.errorHandler(err.response.status);
          console.log(err);
          this.loadingData = false;
        });
    },
  },
};
</script>
