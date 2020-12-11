<template>
  <!-- Dashboard card -->
  <dashboard-card :title="cardTitle">
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12 d-flex justify-content-between mb-3">
        <!-- Titulo -->
        <dashboard-title text="Configuración de reglas" full></dashboard-title>
      </div>
      <!-- /.Col -->

      <!-- Col -->
      <form
        class="col-12 d-flex justify-content-between mb-3"
        method="post"
        @submit.prevent=""
      >
        <p>1) Texto cuando el paciente tiene somnolencia</p>
      </form>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </dashboard-card>
  <!-- /.Dashboard card -->
</template>

<script>
export default {
  name: "SettingsView",
  props: ["system_id"],
  data() {
    return {
      cardTitle: "Configuración",
      loading: true,
      system: {},
      rooms: [],
      bed_percentage: 0,
    };
  },
  created() {
    this.fetchSystem();
  },
  methods: {
    calcBedPercentage() {
      this.bed_percentage =
        ((this.system.occupied_beds * 100) / this.system.total_beds).toFixed(
          1
        ) + "%";
    },
    /**
     * Obtiene el sistema con sus habitaciones y camas
     */
    fetchSystem() {
      const path = "/api/system/full";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      axios
        .get(path, {
          params: {
            system_id: this.system_id,
          },
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          this.system = res.data;
          this.calcBedPercentage();
          this.loading = false;
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        });
    },
  },
};
</script>
