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
                <loading-overlay v-if="loadingMedics" />
                <data-table :columns="tableColumns" :rows="medics"></data-table>
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
  name: "MedicsView",
  title: "Médicos",
  data() {
    return {
      title: "",
      loadingMedics: true,
      medics: [],
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
          label: "Email",
          field: "email",
          sort: "asc",
        },
        {
          label: "Teléfono",
          field: "phone",
          sort: "asc",
        },
      ],
    };
  },
  created() {
    this.hasPermission("medic_index");
    this.setTitle();
  },
  mounted() {
    this.$Progress.start();
    this.fetchMedics();
  },
  methods: {
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
          ? "Médicos de " + systemData.system
          : "Médicos";
    },

    /**
     * Cargar información de médicos para la tabla.
     *
     * @return void.
     */
    loadMedics(data) {
      for (let i = 0; i < data.length; i++) {
        this.medics.push({
          lastname: data[i].lastname,
          name: data[i].name,
          dni: this.formatDni(data[i].dni),
          email: data[i].email,
          phone: data[i].phone,
          // show:
          //   '<a href="/dashboard/medic/' +
          //   data[i].medic_id +
          //   '" class="btn btn-primary btn-sm table-button">Ver</a>',
          // change:
          //   '<a href="/dashboard/medic/system/change/' +
          //   data[i].medic_id +
          //   '" class="btn btn-deep-purple btn-sm table-button">Cambiar sistema</a>',
        });
        this.loadingMedics = false;
        this.$Progress.finish();
      }
    },

    /**
     * Obtener todos los médicos del sistema.
     *
     * @return void.
     */
    fetchMedics() {
      const path = "/api/medic/assigned/index";
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
          // this.medics = res.data;
          this.loadMedics(res.data);
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        });
    },
  },
};
</script>
