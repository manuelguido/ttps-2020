<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Row -->
    <div class="row justify-content-center">
      <div class="col-12 col-lg-9">
        <dashboard-title text="Perfil de usuario"></dashboard-title>
      </div>
      <!-- Col -->
      <div class="col-12 col-lg-9">
        <!-- Card -->
        <div class="card">
          <!-- Card body -->
          <div class="card-body p-md-4 p-lg-5">
            <!-- Row -->
            <div class="row">

              <!-- Image Col -->
              <div class="col-12 col-md-4 mb-4">
                <img class="user-image" v-if="user.image" :src="user.image">
                <img class="user-image" v-else :src="asset_path() + 'img/person.png'">
              </div>
              <!-- /.Image Col -->

              <!-- Information Col -->
              <div class="col-12 col-md-8">
                <div class="row">
                  <!-- Nombre y apellido -->
                  <div class="col-12 mb-4">
                    <span class="w-400 h4-responsive">{{user.name}} {{user.lastname}}</span>
                  </div>
                  <!-- ./Nombre y apellido -->
 
                  <!-- Sistema -->
                  <div class="col-12 mb-2">
                    <span class="h5-responsive primary">{{system}}</span>
                  </div>
                  <!-- /.Sistema -->

                  <!-- Rol -->
                  <div class="col-12 mb-2">
                    <span class="h6-responsive primary">{{role}}</span>
                  </div>
                  <!-- /.Rol -->
                  
                  <div class="col-12">
                    <hr>
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
                    
          </div>
          <!-- /.Card body -->
        </div>
        <!-- /.Card -->
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
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
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