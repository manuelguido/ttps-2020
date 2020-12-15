<template>
  <!-- Alerts -->
  <router-link
    to="/user/alerts"
    :class="[
      'nav-item d-flex align-items-center mr-3 px-4 alert-badge uns',
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
      online: null,
    };
  },
  created() {
    if (localStorage.unreadCount) {
      this.amount = JSON.parse(localStorage.getItem("unreadCount"));
    }
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
          this.online = JSON.parse(localStorage.getItem("online"));

          if (this.online.value) {
            localStorage.setItem("unreadCount", JSON.stringify(res.data.count));
            localStorage.setItem("unreadAlerts", JSON.stringify(res.data.alerts));
            this.amount = res.data.count;
          } else {
            this.amount = JSON.parse(localStorage.getItem("unreadAlerts")).length;
          }
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
