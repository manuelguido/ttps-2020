<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Row -->
    <div class="row justify-content-center">
      <!-- Col -->
      <div class="col-12 col-lg-10 text-left">
        <!-- Title -->
        <dashboard-title :text="title"></dashboard-title>
      </div>
      <!-- /.Col -->

      <!-- Col -->
      <div class="col-12 col-lg-10 text-left">
        <systems-table :loading="loadingData" :systems="systems" />
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- Container -->
</template>

<script>
import SystemsTable from "../../components/dashboard/systems/systemsTable/Index";

export default {
  name: "SystemsView",
  components: {
    SystemsTable,
  },
  data() {
    return {
      title: "Sistemas del hospital",
      loadingData: true,
      systems: [],
    };
  },
  created() {
    this.fetchSystems();
  },
  methods: {
    /**
     * Obtiene el sistema con su información
     */
    fetchSystems() {
      const path = "/api/system/index";
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
          this.systems = res.data;
          this.loadingData = false;
          this.$Progress.finish();
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
