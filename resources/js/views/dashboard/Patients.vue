<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div
        class="col-12 d-flex justify-content-between align-items-center mb-4"
      >
        <!-- Title -->
        <span>
          <dashboard-title :text="title" :margin="false"></dashboard-title>
        </span>
      </div>
      <!-- /.Col -->

      <!-- Col -->
      <div class="col-12">
        <div class="row d-flex align-items-center">
          <!-- Search form -->
          <div class="col-12 mb-4">
            <div class="card c-card">
              <div class="card-body p-lg-5">
                <data-table
                  :columns="tableColumns"
                  :rows="patients"
                ></data-table>
              </div>
            </div>
          </div>
          <!-- Search form -->
        </div>
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- Container -->
</template>

<script>
export default {
  name: "PatientsPage",
  props: {
    system_id: {
      default: null,
    },
  },
  data() {
    return {
      title: "Pacientes",
      patients: [],
      tableColumns: [
        {
          label: "Apellido",
          field: "lastname",
          sort: "asc",
        },
        {
          label: "Nombre",
          field: "name",
          sort: "asc",
        },
        {
          label: "DNI",
          field: "dni",
          sort: "asc",
        },
        {
          label: "Sala",
          field: "room",
          sort: "asc",
        },
        {
          label: "Cama",
          field: "bed",
          sort: "asc",
        },
        {
          label: "",
          field: "show",
        },
        {
          label: "",
          field: "assign",
        },
        {
          label: "",
          field: "change",
        },
        {
          label: "",
          field: "evolve",
        },
      ],
    };
  },
  mounted() {
    this.$Progress.start();
    this.fetchPatients();
  },
  methods: {
    /**
     * Cargar información de pacientes para la tabla.
     *
     * @return void.
     */
    loadPatients(data) {
      for (let i = 0; i < data.length; i++) {
        this.patients.push({
          lastname: data[i].lastname,
          name: data[i].name,
          dni: data[i].dni,
          room: data[i].room,
          bed: "Cama " + data[i].bed_number,
          show:
            '<a href="/dashboard/patient/' +
            data[i].patient_id +
            '" class="btn btn-primary btn-sm table-button">Ver</a>',
          assign:
            '<a href="/dashboard/patient/assignment/' +
            data[i].patient_id +
            '" class="btn btn-indigo btn-sm table-button">Asignar médico</a>',
          change:
            '<a href="/dashboard/patient/system/change/' +
            data[i].patient_id +
            '" class="btn btn-deep-purple btn-sm table-button">Cambiar sistema</a>',
          evolve:
            '<a href="/dashboard/patient/evolution/add' +
            data[i].patient_id +
            '" class="btn btn-purple btn-sm table-button">Evolucionar</a>',
        });
      }
    },

    /**
     * Obtener todos los pacientes.
     *
     * @return void.
     */
    fetchPatients() {
      const path = "/api/patient/assigned/index";
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
          console.log(res.data);
          this.$Progress.finish();
          this.loading = false;
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        });
    },
  },
};
</script>

<style scoped>
/* Searchbar */
.search-form {
  /* background: var(--black-alpha-03); */
  background: #fff;
  border-radius: 8px;
  border: 0 none;
  padding: 10px;
}

.search-form input {
  width: 100%;
  height: 100%;
}

.search-form input,
.search-form input:focus {
  color: var(--white-a);
}

.search-form input:focus,
.search-form * {
  box-shadow: none;
  background: none;
  border: 0 none;
  outline: none;
}
</style>