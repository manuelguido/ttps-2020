<template>
  <dashboard-card :title="cardTitle" noBack>
    <loading-overlay v-if="loadingData" />

    <!-- Alertas -->
    <div v-if="alerts.length > 0" class="row justify-content-center">
      <div class="col-12 pt-5">
        <alerts @reloadData="reloadData" :alerts="alerts"></alerts>
      </div>
    </div>
    <!-- /.Alertas -->

    <!-- No hay alertas -->
    <div v-else class="row justify-content-center">
      <div class="col-12 my-5 text-center">
        <i class="black-alpha-30 fad fa-envelope-open fa-5x mb-4"></i>
        <p class="h5 black-alpha-40">Nada por aquí</p>
      </div>
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
    };
  },
  created() {
    this.fetchAlerts();
  },
  methods: {
    /**
     * Obtener alertas de usuario.
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
     * Guarda las alertas localmente
     */
    loadAlerts(data) {
      this.alerts = [];
      this.alerts = data;
      this.loadingData = false;
    },
  },
};
</script>
