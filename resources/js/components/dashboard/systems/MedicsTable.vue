<template>
  <div>
    <loading-overlay v-if="loadingData" />
    <data-table :columns="tableColumns" :rows="medics"></data-table>
  </div>
</template>

<script>
export default {
  name: "SystemMedicsTable",
  props: ["system_id"],
  data() {
    return {
      loadingData: true,
      medics: [],
      tableColumns: [
        {
          label: "Médico",
          field: "medic",
          sort: "asc",
        },
        {
          label: "DNI",
          field: "dni",
          sort: "asc",
        }
      ],
    };
  },
  created() {
    this.fetchMedics();
  },
  methods: {
    /**
     * Obtener los médicos del sistema.
     *
     * @return void.
     */
    fetchMedics() {
      const path = "/api/medic/index/" + this.system_id;
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
          this.loadMedics(res.data);
        })
        .catch((err) => {
          this.errorHandler(err.response.status);

          var $this = this;
          setTimeout(function () {
            $this.fetchMedics();
          }, 1300);
          console.log(err);
        });
    },

    /**
     * Cargar información de médicos para la tabla.
     *
     * @return void.
     */
    loadMedics(data) {
      for (let i = 0; i < data.length; i++) {
        this.medics.push({
          medic: data[i].lastname + ", " + data[i].name,
          dni: this.formatDni(data[i].dni),
        });
      }
      this.loadingData = false;
      this.$Progress.finish();
    },
  },
};
</script>