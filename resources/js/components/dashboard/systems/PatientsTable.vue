<template>
  <div>
    <loading-overlay v-if="loadingData" />
    <data-table :columns="tableColumns" :rows="patients"></data-table>
  </div>
</template>

<script>
export default {
  name: "SystemPatientsTable",
  props: ["system_id"],
  data() {
    return {
      loadingData: true,
      patients: [],
      tableColumns: [
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
          label: "",
          field: "show",
        }
      ],
    };
  },
  mounted() {
    this.fetchPatients();
  },
  methods: {
    /**
     * Obtener los pacientes del sistema.
     *
     * @return void.
     */
    fetchPatients() {
      const path = "/api/patient/index/" + this.system_id;
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
          this.loadPatients(res.data);
        })
        .catch((err) => {
          // this.errorHandler(err.response.status);

          var $this = this;
          setTimeout(function () {
            $this.fetchPatients();
          }, 1300);
          console.log(err);
        });
    },

    /**
     * Cargar información de médicos para la tabla.
     *
     * @return void.
     */
    loadPatients(data) {
      for (let i = 0; i < data.length; i++) {
        this.patients.push({
          patient: data[i].lastname + ", " + data[i].name,
          dni: this.formatDni(data[i].dni),
          show:
            '<a href="/dashboard/patient/' +
            data[i].patient_id +
            '" class="btn btn-outline-primary btn-sm">Ver</a>',
        });
      }
      this.loadingData = false;
      this.$Progress.finish();
    },
  },
};
</script>