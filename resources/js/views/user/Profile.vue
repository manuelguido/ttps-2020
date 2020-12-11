<template>
  <!-- Dashboard card -->
  <dashboard-card>
    <!-- Row -->
    <div v-if="!editing" class="row">
      <!-- Title -->
      <div
        class="col-12 mb-5 d-flex justify-content-between align-items-baseline"
      >
        <span
          ><dashboard-title text="Perfil de usuario"></dashboard-title
        ></span>
        <span class="btn p-2 waves-effect" @click="editProfile(true)"
          ><i class="fad fa-pencil black-alpha-30 mr-2"></i>Editar</span
        >
      </div>

      <!-- Image Col -->
      <div class="col-12 col-md-4 mb-4">
        <img class="user-image" v-if="user.image" :src="user.image" />
        <img class="user-image" v-else :src="asset_path() + 'img/person.png'" />
      </div>
      <!-- /.Image Col -->

      <!-- Information Col -->
      <div class="col-12 col-md-8">
        <div class="row">
          <!-- Nombre y apellido -->
          <div class="col-12 mb-4">
            <span class="w-400 h4-responsive"
              >{{ user.name }} {{ user.lastname }}</span
            >
          </div>
          <!-- ./Nombre y apellido -->

          <!-- Sistema -->
          <div class="col-12 mb-2">
            <span class="h5-responsive primary">{{ system }}</span>
          </div>
          <!-- /.Sistema -->

          <!-- Rol -->
          <div class="col-12 mb-2">
            <span class="h6-responsive primary">{{ role }}</span>
          </div>
          <!-- /.Rol -->

          <div class="col-12">
            <hr />
            <info-data data="Email" :value="user.email"></info-data>
            <info-data data="DNI" :value="dni()"></info-data>
            <info-data data="Teléfono" :value="user.phone"></info-data>
          </div>
        </div>
        <!-- /.Row -->
      </div>
      <!-- /.Information Col -->
    </div>
    <!-- /.Row -->

    <!-- Row -->
    <div v-else class="row justify-content-center">
      <!-- Title -->
      <div
        class="col-12 mb-5 d-flex justify-content-between align-items-center"
      >
        <span><dashboard-title text="Editar perfil"></dashboard-title></span>
        <span class="btn p-2 waves-effect" @click="editProfile(false)"
          ><i class="fad fa-times black-alpha-30 mr-2"></i>Cancelar</span
        >
      </div>
      <!-- /.Title -->

      <!-- Information Col -->
      <div class="col-12 col-md-10 col-xl-6">
        <!-- Row -->
        <form class="row" method="POST" @submit.prevent="updateProfile()">
          <div class="col-12 col-lg-6 mb-4">
            <v-input v-model="newUserData.name" label="Nombre"></v-input>
          </div>
          <div class="col-12 col-lg-6 mb-4">
            <v-input v-model="newUserData.lastname" label="Apellido"></v-input>
          </div>
          <div class="col-12 mb-4">
            <v-input v-model="newUserData.email" label="Email"></v-input>
          </div>
          <div class="col-12 mb-4">
            <v-input v-model="newUserData.dni" label="DNI"></v-input>
          </div>
          <div class="col-12 mb-4">
            <v-input v-model="newUserData.phone" label="Teléfono"></v-input>
          </div>
          <div class="col-12 mb-4">
            <button class="btn button-primary btn-block">Guardar</button>
          </div>
        </form>
        <!-- /.Row -->
      </div>
      <!-- /.Col -->
    </div>
    <!-- Row -->
  </dashboard-card>
  <!-- /.Dashboard card -->
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      user: JSON.parse(localStorage.getItem("user")),
      role: JSON.parse(localStorage.getItem("role")),
      system: JSON.parse(localStorage.getItem("system")).system,
      editing: false,
      newUserData: {
        name: "",
        lastname: "",
        email: "",
        dni: "",
        phone: "",
      },
    };
  },
  created() {
    this.resetForm();
  },
  methods: {
    /**
     * Hace el formato de DNI
     */
    dni() {
      return (this.user.dni / 1)
        .toFixed(0)
        .replace(".")
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    /**
     * Resetear la info del formulario
     */
    resetForm() {
      this.newUserData = { ...this.user };
    },

    /**
     * Editar perfil de usuario
     */
    editProfile(data) {
      this.editing = data;
      if (!data) this.resetForm();
    },

    /**
     * Guardar perfil de usuario
     */
    updateProfile() {
      const path = "/api/user/profile/update";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      var formData = new FormData();
      formData.append("name", this.newUserData.name);
      formData.append("lastname", this.newUserData.lastname);
      formData.append("email", this.newUserData.email);
      formData.append("dni", this.newUserData.dni);
      formData.append("phone", this.newUserData.phone);

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
            this.updateLocalData(res.data.user);
            this.resetForm();
          }
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
        });
    },

    /**
     * Actualizar en localstorage la información de usuario
     */
    updateLocalData(newUserData) {
      var aux = JSON.parse(localStorage.getItem("user"));
      aux.name = newUserData.name;
      aux.lastname = newUserData.lastname;
      aux.email = newUserData.email;
      aux.dni = newUserData.dni;
      aux.phone = newUserData.phone;
      localStorage.setItem("user", JSON.stringify(aux));
      location.reload();
    },
  },
};
</script>

<style scoped>
.user-image {
  width: 140px;
  height: 140px;
  overflow: hidden;
  border-radius: 100px;
}
</style>