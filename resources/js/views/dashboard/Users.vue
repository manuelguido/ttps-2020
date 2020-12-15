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
                <loading-overlay v-if="loadingUsers" />
                <data-table :columns="tableColumns" :rows="users"></data-table>
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
  name: "UsersView",
  title: "Usuarios",
  data() {
    return {
      title: "Usuarios del sistema",
      loadingUsers: true,
      users: [],
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
        {
          label: "Rol",
          field: "role",
          sort: "asc",
        },
        {
          label: "Sistema",
          field: "system",
          sort: "asc",
        },
      ],
    };
  },
  created() {
    this.hasPermission("user_index");
  },
  mounted() {
    this.$Progress.start();
    this.fetchUsers();
  },
  methods: {
    /**
     * Cargar información de usuarios para la tabla.
     *
     * @return void.
     */
    loadUsers(data) {
      for (let i = 0; i < data.length; i++) {
        let systemData = 'N/a';
        if (data[i].system) {
          systemData = data[i].system;
        }

        this.users.push({
          lastname: data[i].lastname,
          name: data[i].name,
          dni: this.formatDni(data[i].dni),
          email: data[i].email,
          phone: data[i].phone,
          role: data[i].role,
          system: systemData,
          show:
            '<a href="/dashboard/user/' +
            data[i].user_id +
            '" class="btn btn-primary btn-sm table-button">Ver</a>',
        });
        this.loadingUsers = false;
        this.$Progress.finish();
      }
    },

    /**
     * Obtener todos los usuarios del sistema.
     *
     * @return void.
     */
    fetchUsers() {
      const path = "/api/user/index";
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
          this.loadUsers(res.data);
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        });
    },
  },
};
</script>
