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
    <!-- /.Row -->

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
      reloadInterval: 1000,
      online: JSON.parse(localStorage.getItem("online")),
    };
  },
  created() {
    if (localStorage.unreadAlerts) {
      this.alerts = JSON.parse(localStorage.getItem("unreadAlerts"));
    }
    this.hasPermission("alerts");
    this.loadingData = false;
    this.alertCheckInterval();
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
        this.loadAlerts();
      }, this.reloadInterval);
    },

    /**
     * Guarda las alertas localmente
     */
    loadAlerts() {
      this.alerts = JSON.parse(localStorage.getItem("unreadAlerts"));
    },

    reloadData(alertId) {
      let aux = JSON.parse(localStorage.getItem("unreadAlerts"));
      aux.forEach(element => {
        if (element.alert_id == alertId) {
          aux.pop(element);
        } 
      });
      localStorage.setItem("unreadAlerts", JSON.stringify(aux));
      this.loadAlerts();
    },
  },
  watch: {
    alerts: {
      deep: true,
      handler() {},
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