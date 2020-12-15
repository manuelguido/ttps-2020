<template>
  <div class="full-height-container d-flex flex-column align-items-center">
    <h1 class="h1 mb-4 animated fadeIn">Bienvenido</h1>
    <loading-dots message="Obteniendo información de usuario"></loading-dots>
  </div>
</template>

<script>
export default {
  name: "DataLoad",
  created() {
    this.loadUser();
  },
  data() {
    return {
      resp: null,
    };
  },
  methods: {
    /**
     * Carga el usuario en almacenamiento local del cliente
     * Carga el rol de usuario en el almacenamiento local del cliente
     */
    loadUser() {
      const path = "/api/user/full";
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
          // Carga la información
          this.storeUserData(res.data);
          this.resp = res.data;
          // Redirecciona
          this.redirect();
        })
        .catch((err) => {
          // Vuelve a intentar la operación
          var $this = this;
          setTimeout(function () {
            $this.loadUser();
          }, 1300);
          console.log("Fetching user again: " + err);
        });
    },

    /**
     * Almacenar información de usuario localmente
     */
    storeUserData(data) {
      localStorage.setItem("user", JSON.stringify(data.user));
      localStorage.setItem("role", JSON.stringify(data.role));
      localStorage.setItem("permissions", JSON.stringify(data.permissions));
      localStorage.setItem("routes", JSON.stringify(data.routes));
      if (data.system) {
        localStorage.setItem("system", JSON.stringify(data.system));
      }
      localStorage.setItem(
        "online",
        JSON.stringify({
          text: "Online",
          color: "text-success",
          bg_color: "bg-white",
          value: true,
          icon: "fad fa-toggle-on",
        })
      );
    },

    /**
     * Redirecciona al dashboard
     */
    redirect() {
      if (localStorage.routes) {
        const route = JSON.parse(localStorage.getItem("routes"))[0].url;
        this.$router.push({ path: route });
      }
    },
  },
};
</script>

<style scoped>
.full-height-container {
  padding: 20vh 0 0 0;
}
</style>