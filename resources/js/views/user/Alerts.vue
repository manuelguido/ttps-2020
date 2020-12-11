<template>
  <dashboard-card :title="cardTitle" noBack>
    <loading-overlay v-if="loadingData" />
    <div class="row">
      <div class="col-12 d-flex align-items-center justify-content-end">
        <router-link
          class="history-link d-flex flex-row align-items-center"
          to="/user/alerts/history"
        >
          Ver historial
          <i class="fas fa-chevron-right ml-2"></i>
        </router-link>
      </div>
    </div>

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
      cardTitle: "Alertas",
      loadingData: true,
      alerts: [],
      fetchInterval: null,
      reloadInterval: 3500,
    };
  },
  created() {
    this.alertCheckInterval();
    this.fetchAlerts();
  },
  beforeDestroy() {
    this.fetchInterval = null;
  },
  methods: {
    /**
     * Si hay notificaciones nuevas, las busca.
     */
    alertCheckInterval() {
      this.fetchInterval = setInterval(() => {
        this.checkNewAlerts();
      }, this.reloadInterval);
    },

    /**
     * Si hay notificaciones nuevas, las busca.
     */
    checkNewAlerts() {
      var count = JSON.parse(localStorage.getItem("unreadCount"));
      if (count > 0) this.fetchAlerts();
    },

    /**
     * Obtener alertas de usuario.
     */
    fetchAlerts() {
      var $this = this;
      const path = "/api/alert/unread/index";
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

    reloadData(alertId) {
      this.alerts.forEach((element) => {
        if (element.alert_id == alertId) {
          this.alerts.pop(element);
        }
      });
      this.fetchAlerts();
    },
  },
  watch: {
    alerts: {
      deep: true,
      handler() {
        console.log(this.alerts.length);
      },
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