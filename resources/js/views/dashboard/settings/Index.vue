<template>
  <!-- Dashboard card -->
  <dashboard-card :title="cardTitle" noBack>
    <!-- Form -->
    <form @submit.prevent="updateSettings" class="row">
      <!-- Col -->
      <div class="col-12 mb-5">
        <p class="h4 black-alpha-60 mb-4">
          Configuración de días para edición de evoliciones
        </p>
        <p class="black-alpha-40">
          <i class="fad fa-info-circle mr-3 fa-lg"></i>La evolución solo podrá editarla el médico o jefe de sistema que la haya creado
        </p>
      </div>
      <!-- /.Col -->

      <!-- Col -->
      <div class="col-12 col-lg-8 col-xl-6 d-flex flex-column">
        <loading-overlay v-if="loadingData" />
        <!-- Parámetro de frecuencia respiratoria -->
        <div class="form-group mb-5">
          <v-number-input
            v-model="settings.editing_days"
            label="Cantidad de días para editar una evolución"
            onlyNumbers
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
      cardTitle: "Configuración",
      loadingData: true,
      settings: {
        editing_days: 2,
      },
    };
  },
  created() {
    if(!this.hasRole("Administrador")) {
      this.handle403();
    }
    this.fetchSettings();
  },
  methods: {
    /**
     * Obtiene el sistema con sus habitaciones y camas
     */
    fetchSettings() {
      this.loadingData = true;
      const path = "/api/settings/show";
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
          this.settings = res.data;
          this.loadingData = false;
        })
        .catch((err) => {
          // this.errorHandler(err.response.status);
          console.log(err);
          this.loadingData = false;
        });
    },

    /**
     * Obtiene el sistema con sus habitaciones y camas
     */
    updateSettings() {
      this.loadingData = true;
      const path = "/api/settings/update";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      let formData = {
        editing_days: this.settings.editing_days,
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
