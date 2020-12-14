<template>
  <!-- Alerts -->
  <router-link
    to="/user/alerts"
    :class="[
      'nav-item d-flex align-items-center mx-3 px-4 alert-badge uns',
      amount > 0 ? 'notify' : '',
    ]"
  >
    <span class="mr-2 w-700">{{ amount }}</span>
    <i class="fad fa-bell fa-lg"></i>
  </router-link>
  <!-- /.Alerts -->
</template>

<script>
import axios from "axios";
export default {
  name: "AlertsBadge",
  data() {
    return {
      amount: 0,
      fetchInterval: null,
      reloadInterval: 2000,
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
        this.fetchAlerts();
      }, this.reloadInterval);
    },

    /**
     * Obtener alertas de usuario.
     */
    fetchAlerts() {
      var $this = this;
      const path = "/api/alert/unread/count";
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
          this.amount = res.data.count;
          localStorage.setItem("unreadCount", JSON.stringify(res.data.count));
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style scoped>
.alert-badge {
  border-radius: 50px;
  color: #fff;
}
.alert-badge:hover {
  background: rgba(0, 0, 0, 0.1);
  cursor: pointer;
}
.alert-badge:active {
  opacity: 0.7;
  cursor: pointer;
}
.alert-badge.notify {
  color: var(--primary) !important;
  background: #fff;
}
</style>
