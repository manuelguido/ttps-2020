<template>
  <dashboard-card :title="cardTitle" noBack>
    <loading-overlay v-if="loadingData" />
    <!-- Row -->
    <div class="row">
      <div class="col-12 d-flex align-items-center justify-content-end">
        <router-link
          class="history-link d-flex flex-row align-items-center"
          to="/user/alerts"
        >
          Ver alertas recientes
          <i class="fas fa-chevron-right ml-2"></i>
        </router-link>
      </div>
    </div>
    <!-- /.Row -->

    <!-- No hay alertas -->
    <div class="row justify-content-center">
      <!-- Col -->
      <div class="col-12">
        <data-table :columns="tableColumns" :rows="alerts"></data-table>
      </div>
      <!-- /.Col -->
    </div>
    <!-- No hay alertas -->
  </dashboard-card>
</template>

<script>
import Alerts from "../../components/dashboard/user/Alerts";

export default {
  name: "AlertsView",
  components: {
    Alerts,
  },
  data() {
    return {
      cardTitle: "Historial de alertas",
      loadingData: true,
      alerts: [],
      fetchInterval: null,
      reloadInterval: 3500,
      tableColumns: [
        {
          label: "Fecha",
          field: "date",
          sort: "desc",
        },
        {
          label: "Paciente",
          field: "patient",
          sort: "asc",
        },
        {
          label: "DNI",
          field: "dni",
          sort: "asc",
        },
        {
          label: "Información",
          field: "description",
          sort: "asc",
        },
      ],
    };
  },
  created() {
    this.fetchAlerts();
  },
  methods: {
    /**
     * Obtener alertas de usuario.
     *
     * @return void.
     */
    fetchAlerts() {
      var $this = this;
      const path = "/api/alert/read/index";
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
          this.loadAlerts(res.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },

    /**
     * Cargar información de pacientes para la tabla.
     *
     * @return void.
     */
    loadAlerts(data) {
      for (let i = 0; i < data.length; i++) {
        this.alerts.push({
          date: this.formatDate(data[i].created_at),
          patient: data[i].lastname + " " + data[i].name,
          dni: this.formatDni(data[i].dni),
          description: data[i].description,
        });
        this.loadingData = false;
        this.$Progress.finish();
      }
    },
  },
};
</script>

<style scoped>
.history-link {
  color: var(--black-alpha-40);
}
.history-link:hover {
  color: var(--primary);
}
</style>