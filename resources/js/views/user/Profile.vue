<template>
  <!-- Container -->
  <div class="container-fluid">
    <dashboard-title text="Perfil"></dashboard-title>
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12 col-lg-8 col-xl-6">
        <!-- Row -->
        <div class="row">
          <!-- Image Col -->
          <div class="col-12 mb-4">
            <img class="user-image" v-if="user.image" :src="user.image">
            <img class="user-image" v-else :src="asset_path() + 'img/person.png'">
          </div>
          <!-- /.Image Col -->
          <!-- Email -->
          <div class="col-12 mb-3">
            <span class="h4-responsive primary">{{role}}</span>
          </div>
          <!-- /.Email -->
          <!-- Nombre y apellido -->
          <div class="col-12 mb-3">
            <span class="w-300 h5-responsive">{{user.name}} {{user.lastname}}</span>
          </div>
          <!-- ./Nombre y apellido -->
          <!-- Email -->
          <div class="col-12 mb-3">
            <span class="w-300 h5-responsive">{{user.email}}</span>
          </div>
          <!-- /.Email -->
          <!-- Email -->
          <div class="col-12 mb-3">
            <span class="w-300 h5-responsive">{{dni()}}</span>
          </div>
          <!-- /.Email -->
          <!-- Email -->
          <div class="col-12 mb-3">
            <span class="w-300 h5-responsive">Teléfono: {{user.phone}}</span>
          </div>
          <!-- /.Email -->
        </div>
        <!-- /.Row -->
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- /.Container -->
</template>

<script>
export default {
  data () {
    return {
      user: JSON.parse(localStorage.getItem('user')),
      role: JSON.parse(localStorage.getItem('role')),
      system: JSON.parse(localStorage.getItem('system')),
    }
  },
  methods: {
    /**
     * Hace el formato de DNI
     */
    dni() {
      let val = (this.user.dni/1).toFixed(0).replace('.')
      return "DNI " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    }
  }
}
</script>

<style scoped>
.user-image {
  width: 140px;
  height: 140px;
  overflow: hidden;
  border-radius: 100px;
}
</style>