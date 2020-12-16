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
                <loading-overlay v-if="loadingPatients" />
                <data-table
                  :columns="columnData()"
                  :rows="patients"
                ></data-table>
              </div>
            </div>
          </div>
          <!-- /.Search form -->
        </div>
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- /.Container -->
</template>

<script>
export default {
  name: "PatientsView",
  data() {
    return {
      title: "",
      loadingPatients: true,
      patients: [],
      tableColumns1: [
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
          field: "evolve",
        },
      ],
      tableColumns2: [
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
  created() {
    this.$Progress.start();
    this.hasPermission("patient_index");
    this.setTitle();
    this.fetchPatients();
  },
  methods: {
    columnData() {
      if (this.hasRole("Médico")) {
        return this.tableColumns1;
      } else {
        return this.tableColumns2;
      }
    },
    /**
     * Determinar el titulo de la página.
     *
     * @return void.
     */
    setTitle() {
      var condition = false;
      const roleData = JSON.parse(localStorage.getItem("role"));
      const systemData = JSON.parse(localStorage.getItem("system"));
      const roleGuard = "Jefe de Sistema";
      const roleMedic = "Médico";

      this.title =
        roleData == roleGuard || roleData == roleMedic
          ? "Pacientes de " + systemData.system
          : "Pacientes";
    },

    /**
     * Cargar información de pacientes para la tabla.
     *
     * @return void.
     */
    loadPatients(data) {
      for (let i = 0; i < data.length; i++) {
        let patientData = {
          lastname: data[i].lastname,
          name: data[i].name,
          dni: data[i].dni,
          room: data[i].room,
          bed: "Cama " + data[i].bed_number,
          show: '<a href="/dashboard/patient/' + data[i].patient_id + '" class="btn btn-primary btn-sm table-button">Ver</a>',
          evolve: '<a href="/dashboard/patient/evolution/add/' + data[i].patient_id +'" class="btn btn-purple btn-sm table-button">Evolucionar</a>',
        };

        if (this.hasRole("Jefe de Sistema")) {
          patientData.assign =
            '<a href="/dashboard/patient/assignment/' +
            data[i].patient_id +
            '" class="btn btn-indigo btn-sm table-button">Asignar médico</a>';
          patientData.change =
            '<a href="/dashboard/patient/system/change/' +
            data[i].patient_id +
            '" class="btn btn-deep-purple btn-sm table-button">Cambiar sistema</a>';
        }

        this.patients.push(patientData);
      }
      this.loadingPatients = false;
      this.$Progress.finish();
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
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        });
    },
  },
};
</script>
