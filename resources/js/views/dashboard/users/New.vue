<template>
  <dashboard-card>
    <loading-overlay v-if="loadingData" />
    <!-- Step 1  -->
    <div>
      <!-- Row -->
      <div class="row justify-content-center">
        <!-- Form -->
        <form
          class="col-12 col-lg-8 text-center d-flex flex-column align-items-center"
          @submit.prevent="createUser"
        >
          <!-- Row -->
          <div class="row text-left">
            <!-- Title -->
            <div class="col-12 mb-4">
              <dashboard-subtitle text="Crear un usuario"></dashboard-subtitle>
            </div>
            <!-- /.Title -->
            <!-- Nombre -->
            <v-input
              v-model="user.name"
              label="Nombre"
              placeholder="Ingresar nombre"
              classList="col-lg-6 mb-4"
              onlyLetters
              required
            ></v-input>
            <!-- /.Nombre -->
            <!-- Apellido -->
            <v-input
              v-model="user.lastname"
              label="Apellido"
              placeholder="Ingresar apellido"
              classList="col-lg-6 mb-4"
              onlyLetters
              required
            ></v-input>
            <!-- /.Apellido -->
            <!-- Email -->
            <v-input
              v-model="user.email"
              label="Email"
              placeholder="ejemplo@gmail.com"
              classList="col-lg-6 mb-4"
              type="email"
              required
            ></v-input>
            <!-- /.Email del paciente -->
            <!-- Email -->
            <v-input
              v-model="user.password"
              label="Contraseña"
              placeholder="Ingrese contraseña"
              classList="col-lg-6 mb-4"
              type="password"
              required
            ></v-input>
            <!-- /.Email del paciente -->
            <!-- DNI -->
            <v-input
              v-model="user.dni"
              label="DNI"
              placeholder="Sin puntos ni espacios"
              classList="col-lg-6 mb-4"
              onlyNumbers
              required
            ></v-input>
            <!-- /.DNI -->
            <!-- Teléfono -->
            <v-input
              v-model="user.phone"
              label="Teléfono"
              placeholder="Teléfono del paciente"
              classList="col-lg-6 mb-4"
              onlyNumbersAndSymbols
              required
            ></v-input>
            <!-- /.Teléfono -->
            <!-- Roles -->
            <v-input-select
              v-model="user.role_id"
              label="Rol"
              classList="col-lg-6 mb-4"
              :options="roles"
              required
            ></v-input-select>
            <!-- /.Roles -->
            <!-- Sistemas -->
            <v-input-select
              v-if="user.role_id == 3"
              v-model="user.system_id"
              label="Sistema"
              classList="col-lg-6 mb-4"
              :options="systems"
              required
            ></v-input-select>
            <!-- /.Sistemas -->

            <!-- Col -->
            <div class="col-12 mt-4">
              <!-- Button -->
              <save-button text="Guardar paciente"></save-button>
              <!-- /.Button -->
            </div>
            <!-- /.Col -->
          </div>
          <!-- /.Row -->
        </form>
        <!-- /.Form -->
      </div>
      <!-- /.Row -->
    </div>
    <!-- /.Step 1 -->
  </dashboard-card>
</template>

<script>
import Dashboard from "../../../layouts/Dashboard.vue";
export default {
  components: { Dashboard },
  name: "NewUserView",
  data() {
    return {
      loadingData: false,
      user: {
        name: "",
        lastname: "",
        dni: "",
        phone: "",
        email: "",
        password: "",
        role_id: "",
        system_id: "",
      },
      roles: [],
      systems: [],
    };
  },
  created() {
    this.hasPermission("user_store");
    this.fetchRoles();
    this.fetchSystems();
  },
  methods: {
    resetForm() {
      name = "";
      lastname = "";
      dni = "";
      phone = "";
      email = "";
      password = "";
      role_id = "";
      system_id = "";
    },

    /**
     * Crea un paciente, le agrega una entrada al sistema y una hospitalización en guardia.
     *
     * @return void.
     */
    createUser() {
      this.loadingData = true;
      const path = "/api/user/store";

      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      let formData = {
        name: this.user.name,
        lastname: this.user.lastname,
        dni: this.user.dni,
        phone: this.user.phone,
        email: this.user.email,
        password: this.user.password,
        role_id: this.user.role_id,
        system_id: this.user.system_id,
      };

      axios
        .post(path, formData, {
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          this.new_alert(res.data);
          if (res.data.status == "success") {
            this.resetForm();
          }
          this.loadingData = false;
        })
        .catch((err) => {
          console.log(err);
          this.loadingData = false;
        });
    },

    /**
     * Obtener todos los roles.
     */
    fetchRoles() {
      const path = "/api/role/index/reduced";
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
          this.formatRoles(res.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },

    /**
     * Formatear los roles para el formulario.
     */
    formatRoles(data) {
      var newData = data;
      newData.forEach((element) => {
        element.id = element.role_id;
        element.name = element.role;
      });
      this.roles = newData;
    },

    /**
     * Obtener todos los roles.
     */
    fetchSystems() {
      const path = "/api/system/index/reduced";
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
          this.formatSystems(res.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },

    /**
     * Formatear los roles para el formulario.
     */
    formatSystems(data) {
      var newData = data;
      newData.forEach((element) => {
        element.id = element.system_id;
        element.name = element.system;
      });
      this.systems = newData;
    },
  },
};
</script>
